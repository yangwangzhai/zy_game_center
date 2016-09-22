<?php if (! defined('BASEPATH'))  exit('No direct script access allowed');
//  
session_start();
class Redrain extends CI_Controller
{
    private $key = "ew849*j%(02sx+@wasf4522><sa231";

    public function index () {

        $ChannelID = intval($_GET['ChannelID']);
        $ActiveID = intval($_GET['ActiveID']);
        $RoomID = intval($_GET['RoomID']);

        $state_base64 = base64_encode('http://h5game.gxtianhai.cn/mntvdb/gamecenter/index.php?d=redrain&c=redrain&m=game&CID='.$ChannelID.'&AID='.$ActiveID.'&RID='.$RoomID);
        $this->load->model('ChannelApi_model');
        $apiUrl = $this->ChannelApi_model->getApi($ChannelID,'GetUserInfo');
        if(!$apiUrl){
            $data['msg']='渠道接口未开启';
            $this->load->view('tip', $data);
            return;
        }
        $temp = sprintf($apiUrl,$state_base64);
        header("Location: ".$temp);
    }
	
	public function game () {
        

        $randomStr = "abcdefghijklmnopqrstuvwxyz0123456789";
        if(!is_mobile_request()){
            //$data['msg']='获取不到用户信息';
            $this->load->view('tip', $data);
            return;
        }
        $data['ChannelID'] = intval($_GET['CID']);
        $data['ActiveID'] = intval($_GET['AID']);
        $data['RoomID'] = intval($_GET['RID']);

        $this->load->model('my_common_model','common');
        //判断活动、游戏状态
        $isRun = $this->common->get_active_game_status($data['ActiveID'],$data['RoomID']);
        if(!$isRun['status']) {
            $data['msg'] = $isRun['msg'];
            $this->load->view('tip', $data);
            return;
        }

        //添加游戏访问量
        $this->common->add_game_VistNum($data['RoomID'],$data['ChannelID'],$data['ActiveID'],trim($_GET['openid']));

        

        $gamekey = substr(str_shuffle($randomStr), 0,5);//随机生成一个key用于成绩提交验证

        $postdata['openid'] = trim($_GET['openid']);
        //查询获取用户及checksign接口地址
        $get_checksign = $this->db->query("SELECT RuleSign,RuleSet FROM zy_gamelist_rule WHERE RuleSign = 'GetUserAndChecksign' and ChannelID = {$data['ChannelID']} and ActiveID = {$data['ActiveID']} and RoomID = {$data['RoomID']}")->row_array();
        $getUserInfo_url = $get_checksign['RuleSet'].$postdata['openid'];//"http://h5game.gxtianhai.cn/redrain/index.php?c=getuserinfo";
        
        

        $resStr = curlGetData($getUserInfo_url);

        $resdata = json_decode($resStr);
        
        //存获取用户用户信息返回的内容    
        $this->db->insert('zy_redrain_log',array('openid'=>$postdata['openid'],'log'=>json_encode($resdata),'code'=>$resdata->ErrorCode,'addtime'=>time(),'ChannelID'=>$data['ChannelID'],'ActiveID'=>$data['ActiveID'],'RoomID'=>$data['RoomID']));
        
        if($resdata->UserInfo->openId == 'null'){
            $this->common->addErrLog($postdata['openid'], $data['ChannelID'], $data['ActiveID'], $data['RoomID'], '获取不到用户信息及checksign', 1);
        }

        $data['openid'] = $resdata->UserInfo->openId;
        $data['img_url'] = $resdata->UserInfo->headimgurl;
        $data['nickname'] = $resdata->UserInfo->nickname;
        $data['gamesign'] = md5($resdata->UserInfo->checksign.$gamekey);
        $updatetime = time();

        $hasSession = $this->db->query("SELECT count(*) as num FROM zy_redrain_session where openid = '{$data['openid']}' and ChannelID = {$data['ChannelID']} and ActiveID = {$data['ActiveID']} and RoomID = {$data['RoomID']}")->row_array();

        if($hasSession['num']){
            $this->db->query("UPDATE zy_redrain_session set checksign='{$resdata->UserInfo->checksign}',gamesign='{$data['gamesign']}',updatetime='$updatetime' where openid='{$data['openid']}' and ChannelID = {$data['ChannelID']} and ActiveID = {$data['ActiveID']} and RoomID = {$data['RoomID']}");
        }else{
            $this->db->query("INSERT zy_redrain_session (openid, checksign,gamesign,updatetime,ChannelID,ActiveID,RoomID) values ('{$data['openid']}', '{$resdata->UserInfo->checksign}','{$data['gamesign']}','$updatetime',{$data['ChannelID']},{$data['ActiveID']},{$data['RoomID']})");
        }

        $this->db->query("delete from zy_redrain_session where updatetime < ($updatetime-43200) and ChannelID = {$data['ChannelID']} and ActiveID = {$data['ActiveID']} and RoomID = {$data['RoomID']}");

        
        //判断用户是否已玩过
        $query = $this->db->query("SELECT count(*) as num FROM zy_redrain_user WHERE openid = '{$data['openid']}' and ChannelID = {$data['ChannelID']} and ActiveID = {$data['ActiveID']} and RoomID = {$data['RoomID']}");
        $res = $query->row_array();
        $data['isPlayed'] = $res['num'];

        //获取该活动自定义规则
        $Rule_arr = $this->db->query("SELECT RuleSign,RuleSet FROM zy_gamelist_rule WHERE RuleSign in ('Game_time','Bigred','Smallred','Bomb','GetLongBiUrl','ActiveUrl') and ChannelID = {$data['ChannelID']} and ActiveID = {$data['ActiveID']} and RoomID = {$data['RoomID']}")->result_array();
        $Rule = array();
        foreach ($Rule_arr as $k => $v) {
            $Rule[$v['RuleSign']] = $v['RuleSet'];
        }
        $data['rule'] = json_encode($Rule);

        //获取该活动自定义资源
        $Resources_arr = $this->db->query("SELECT VarName,ReSrc FROM zy_gamelist_resources WHERE ChannelID = {$data['ChannelID']} and ActiveID = {$data['ActiveID']} and RoomID = {$data['RoomID']}")->result_array();
        
        $Resources = array();
        foreach ($Resources_arr as $k => $v) {
            $Resources[$v['VarName']] = str_replace('static/gameroom/redrain/', '', $v['ReSrc']);
        }
        $data['resources'] = json_encode($Resources);
		
		$this->load->view('redrain/redrain_complie',$data);

        
    } 

    public function recore(){

        
        $result = array();
        $comefrom = $_SERVER['HTTP_REFERER'];
        //echo $comefrom;
        $milk_url = base_url('');
        $ip_url = "http://119.29.87.142/redrain/";

        $isComeFromTrue = false;

        if(strpos($comefrom,$milk_url) !== false){
            $isComeFromTrue = true;
        }

        $data['ChannelID'] = intval($_POST['ChannelID']);
        $data['ActiveID'] = intval($_POST['ActiveID']);
        $data['RoomID'] = intval($_POST['RoomID']);

        //查询提交数据接口地址
        $get_sibmit_url = $this->db->query("SELECT RuleSign,RuleSet FROM zy_gamelist_rule WHERE RuleSign = 'SubmitUrl' and ChannelID = {$data['ChannelID']} and ActiveID = {$data['ActiveID']} and RoomID = {$data['RoomID']}")->row_array();
        $receiveGold_url = $get_sibmit_url['RuleSet'];

        $session = $this->db->query("SELECT * FROM zy_redrain_session WHERE openid = '{$_POST['openid']}' and ChannelID = {$data['ChannelID']} and ActiveID = {$data['ActiveID']} and RoomID = {$data['RoomID']}")->row_array();


        if( empty($comefrom) || md5($session['gamesign'].$_POST['score'].'sadjiasdo') !== $_POST['gamesign'] || empty($session['gamesign']) ){
            //header('location: index.php?c=redrain');
            //var_dump(md5($_SESSION['gamesign'].$_POST['score'].'sadjiasdo') !== $_POST['gamesign']);
            $result['code'] = 0;
            $result['error'] = '数据异常';
            echo json_encode($result);
            exit;
        }
    	$data['score'] = intval($_POST['score']);
        $data['openid'] = trim($_POST['openid']);
        $data['img_url'] = trim($_POST['img_url']);
        $data['nickname'] = trim($_POST['nickname']);
        //$data['gender'] = intval($_POST['gender']);
        $data['ip'] = ip();
        $data['browser'] = getbrowser();
        $data['os'] = getos();
        $data['comefrom'] = $comefrom;
        $data['addtime'] =time();

        if($data['openid'] == 'null'){
            $result['code'] = 3;
            $result['error'] = "没有获取到用户信息";
            echo json_encode($result);
            exit();
        }

        //判断分数是否大于设定最大值
        $max_query = $this->db->query("SELECT RuleSet FROM zy_gamelist_rule WHERE RuleSign = 'Allow_max_num' and ChannelID = {$data['ChannelID']} and ActiveID = {$data['ActiveID']} and RoomID = {$data['RoomID']}");
        $max_score = $max_query->row_array();

        if($data['score'] > $max_score['RuleSet']){
            $data['score'] = $max_score['RuleSet'];
        }

        $query = $this->db->query("SELECT count(*) as num FROM zy_redrain_user WHERE status = 0 and openid = '{$data['openid']}' and ChannelID = {$data['ChannelID']} and ActiveID = {$data['ActiveID']} and RoomID = {$data['RoomID']}");
        $res = $query->row_array();
        $isPlayed = $res['num'];

        if(!$isPlayed){
            $isIsert = $this->db->insert('zy_redrain_user',$data);
            $insert_id = $this->db->insert_id();
            if($isIsert){
                $postres = json_decode(curlPost($receiveGold_url,array('openid'=>$data['openid'],'gold'=>$data['score'],'checksign'=>$session['checksign'])),true);
                //存提交数据返回的内容    
                $this->db->insert('zy_redrain_log',array('openid'=>$data['openid'],'log'=>json_encode($postres),'code'=>$postres['ErrorCode'],'addtime'=>time(),'ChannelID'=>$data['ChannelID'],'ActiveID'=>$data['ActiveID'],'RoomID'=>$data['RoomID']));
                //$postres['ErrorCode'] = '0';

                if($postres['ErrorCode'] == '0'){
                    //获取活动对应的GameID
                    $Active = $this->db->get_where('zy_active_main',array('ActiveID'=>$data['ActiveID']))->row_array();
                    if($Active){
                        $this->db->insert('zy_gamelist_user',array('Openid'=>$data['openid'],'Nickname'=>$data['nickname'],'ChannelID'=>$data['ChannelID'],'ActiveID'=>$data['ActiveID'],'GameID'=>$Active['GameID'],'Num'=>$data['score'],'UpdateTime'=>time(),'AddTime'=>time()));
                    }
                    
                    $result['code'] = 1;
                    $result['msg'] = "数据保存成功";
                }else {

                    $this->my_common_model->addErrLog($data['openid'], $data['ChannelID'], $data['ActiveID'], $data['RoomID'], '游戏数据提交失败', 1);
                    
                    $this->db->where('id',$insert_id);
                    $this->db->update('zy_redrain_user',array('status'=>1));
                    $result['code'] = 3;
                    $result['error'] = "游戏数据提交失败";
                }
            }
            
        }else{
            $result['code'] = 2;
            $result['error'] = "您已经参与过游戏啦";
            $result['sip'] = '43';
        }

        
    	
    	echo json_encode($result);
    }

    

    
	

}


?>
