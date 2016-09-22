<?php if (! defined('BASEPATH'))  exit('No direct script access allowed');
//  
session_start();
class ozb extends CI_Controller
{
    private $key = "ew849*j%(02sx+@wasf4522><sa231";
	
	public function index () {

        $data['time'] = strtotime(date('Y-m-d 23:59:59',time()));
        //获取用户信息
        $openid = 'lkl11';
        $nickname = 'lkl';
        $head_img = 'http://';
        $total_gold = '5000';//需要通过龙币接口查询龙币

        //查询系统是否有该用户
        $has = $this->db->query("SELECT count(*) as num FROM zy_player WHERE openID = '".$openid."'")->row_array();
        if($has['num']){
            $sql = "UPDATE zy_player SET total_gold = ".$total_gold." WHERE openID='".$openid."'";
            $this->db->query($sql);
        }else{
            $addData['openid'] = $openid;
            $addData['nickname'] = $nickname;
            $addData['head_img'] = $head_img;
            $addData['total_gold'] = $total_gold;
            $this->db->insert('zy_player',$addData);
        }


        $user = $this->db->query("SELECT * FROM zy_player where openID = '".$openid."'")->row_array();
        $data['user'] = $user;

        //获取队伍信息
        $country = $this->db->query("SELECT * FROM zy_country")->result_array();
        $data['country'] = $country;
        
        //获取比赛列表
        $list = $this->db->query("SELECT * FROM zy_racelist")->result_array();

        foreach ($list as &$v) {
            foreach ($country as $c) {
                if($v['team1_id'] == $c['id']){
                    $v['team1_logo'] = $c['logo'];
                    $v['team1_name'] = $c['name'];
                    //获取已投数据
                    $res = $this->db->query("SELECT sum(gold) as yitou FROM zy_bet WHERE race_id = {$v['id']} and country_id = {$c['id']}")->row_array();
                    $v['team1_yitou'] = $res['yitou'];
                    //获取支持数据
                    $res = $this->db->query("SELECT count(*) as ZC FROM zy_bet WHERE race_id = {$v['id']} and country_id = {$c['id']}")->row_array();
                    $v['team1_ZC'] = $res['ZC'];

                }

                if($v['team2_id'] == $c['id']){
                    $v['team2_logo'] = $c['logo'];
                    $v['team2_name'] = $c['name'];
                    //获取已投数据
                    $res = $this->db->query("SELECT sum(gold) as yitou FROM zy_bet WHERE race_id = {$v['id']} and country_id = {$c['id']}")->row_array();
                    $v['team2_yitou'] = $res['yitou'];

                    //获取支持数据
                    $res = $this->db->query("SELECT count(*) as ZC FROM zy_bet WHERE race_id = {$v['id']} and country_id = {$c['id']}")->row_array();
                    $v['team2_ZC'] = $res['ZC'];
                }
            }
            //获取平局已投数据
            $res = $this->db->query("SELECT sum(gold) as yitou FROM zy_bet WHERE race_id = {$v['id']} and country_id = 0")->row_array();
            $v['pj_yitou'] = $res['yitou'];

        }

		$data['list'] = $list;
        //var_dump($list);

        //获取我的精竞猜
        $my_JC = $this->db->query("SELECT * FROM zy_bet WHERE openid = '".$openid."' ORDER BY id DESC")->result_array();
        $data['my_JC'] = $my_JC;

        $this->getLongbi('lkl');
        

	    $this->load->view('ozb',$data);

        
    } 

    public function bet(){
        $data['race_id'] = intval($_POST['race_id']);
        $data['openid'] = trim($_POST['openid']);
        $data['country_id'] = intval($_POST['country_id']);
        $data['gold'] = intval($_POST['gold']);
        $data['addtime'] = time();

        if($data['gold'] <= 0){
            $result['code'] = -2;//成功
            $result['msg'] = '参数异常';
            echo json_encode($result);
            exit();
        }

        //判断比赛是否能下注，比赛开始前15分钟停止下注
        $race = $this->db->query("SELECT * FROM zy_racelist WHERE id = ".$data['race_id'])->row_array();
        if(time() > $race['starttime']-15*60){
            $result['code'] = -4;//
            $result['msg'] = '本场已停止下注';
            echo json_encode($result);
            exit();
        }

        //判断用户龙币是否够下注
        $user = $this->db->query("SELECT * FROM zy_player WHERE openID = '".$data['openid']."'")->row_array();
        if($user['total_gold'] < $data['gold']){
            $result['code'] = -3;
            $result['msg'] = '龙币不足';
            echo json_encode($result);
            exit();
        }

        //判断是否下过同场次同队伍，下过则跟新记录，否则添加记录
        $res = $this->db->query("SELECT count(*) as num FROM zy_bet WHERE openid = '".$data['openid']."' and race_id = ".$data['race_id']." and country_id = ".$data['country_id'])->row_array();

        if($res['num']){
            $sql = "UPDATE zy_bet SET gold=gold+{$data['gold']} WHERE openid = '".$data['openid']."' and race_id = ".$data['race_id']." and country_id = ".$data['country_id'];
            if($this->db->query($sql)){
                //扣减用户龙币调用接口成功后再减系统龙币
                $this->db->query("UPDATE zy_player SET total_gold=total_gold-{$data['gold']} where openID = '".$data['openid']."'");
                //消耗龙币如失败要减记录金额
                $result['code'] = 0;//成功
                $result['msg'] = '下注成功';
            }else{
                $result['code'] = -1;//成功
                $result['msg'] = '下注失败';
            }
        }else{
            if($this->db->insert('zy_bet',$data)){
                $insert_id = $this->db->insert_id();
                //扣减用户龙币调用接口成功后再减系统龙币
                $this->db->query("UPDATE zy_player SET total_gold=total_gold-{$data['gold']} where openID = '".$data['openid']."'");
                //消耗龙币如失败要删除记录
                $result['code'] = 0;//成功
                $result['msg'] = '下注成功';
            }else{
                $result['code'] = -1;//成功
                $result['msg'] = '下注失败';
            }
        }
        
        echo json_encode($result);
    }

    //查询龙币
    private function getLongbi($openid){
        $url = 'http://xxx/api/dcurrency/query.do';
        $key = 'lll';//约定的密钥
        $sid = '1000';//设备号
        $seq = '300300'.date('YmdHis',time());//流水号
        $useraccount = $openid;//用户账号
        $accounttype = 2;
        $timestamp = time();
        $skey = MD5($sid.$seq.$useraccount.$accounttype.$timestamp.$key);
        
        $res = json_decode(curlPost($url,array('sid'=>$sid,'seq'=>$seq,'useraccount'=>$useraccount,'accounttype'=>$accounttype,'timestamp'=>$timestamp,'skey'=>$skey)));
        return $res->dcurrency;
    }

    //充值龙币
    private function addLongbi($openid,$num){
        $url = 'https://xxx/api/dcurrency/recharge.do';
        $key = 'lll';//约定的密钥
        $sid = '1000';//设备号
        $seq = '300300'.date('YmdHis',time());//流水号
        $useraccount = $openid;//用户账号
        $accounttype = 2;
        $rechargetype = '0000';//由龙币系统提供，用来识别活动
        $rechargeamount = $num;//充值龙币数(正整数)
        $timestamp = time();
        $skey = MD5($sid.$seq.$useraccount.$accounttype.$rechargetype.$rechargeamount.$timestamp.$key);
        
        $res = json_decode(curlPost($url,array('sid'=>$sid,'seq'=>$seq,'useraccount'=>$useraccount,'accounttype'=>$accounttype,'timestamp'=>$timestamp,'skey'=>$skey)));
        return $res->returncode;
    }

    //消耗龙币
    private function decLongbi($openid,$num){
        $url = 'https://xxx/api/dcurrency/consume.do';
        $key = 'lll';//约定的密钥
        $sid = '1000';//设备号
        $seq = '300300'.date('YmdHis',time());//流水号
        $useraccount = $openid;//用户账号
        $accounttype = 2;
        $consumetype = '0000';//由龙币系统提供，用来识别活动
        $consumeamount = $num;//消耗龙币数(正整数)
        $timestamp = time();
        $skey = MD5($sid.$seq.$useraccount.$accounttype.$consumetype.$consumeamount.$timestamp.$key);
        
        $res = json_decode(curlPost($url,array('sid'=>$sid,'seq'=>$seq,'useraccount'=>$useraccount,'accounttype'=>$accounttype,'timestamp'=>$timestamp,'skey'=>$skey)));
        return $res->returncode;
    }

    private function getbrowser() { 
        $browser = $_SERVER['HTTP_USER_AGENT']; 
       
        return $browser; 
    } 
    private function getos() { 
        $os = $_SERVER['HTTP_USER_AGENT']; 
        if (preg_match('/win/i',$os)) { 
            $os = 'windows'; 
        } 
        elseif (preg_match('/mac/i',$os)) { 
            $os = 'mac'; 
        } 
        elseif (preg_match('/linux/i',$os)) { 
            $os = 'linux'; 
        } 
        elseif (preg_match('/unix/i',$os)) { 
            $os = 'unix'; 
        } 
        elseif (preg_match('/bsd/i',$os)) { 
            $os = 'bsd'; 
        } 
        else { 
            $os = 'other'; 
        } 
        return $os; 
    }  

    function is_mobile_request()  
    {  
     $_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : '';  
     $mobile_browser = '0';  
     if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))  
      $mobile_browser++;  
     if((isset($_SERVER['HTTP_ACCEPT'])) and (strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') !== false))  
      $mobile_browser++;  
     if(isset($_SERVER['HTTP_X_WAP_PROFILE']))  
      $mobile_browser++;  
     if(isset($_SERVER['HTTP_PROFILE']))  
      $mobile_browser++;  
     $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));  
     $mobile_agents = array(  
        'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',  
        'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',  
        'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',  
        'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',  
        'newt','noki','oper','palm','pana','pant','phil','play','port','prox',  
        'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',  
        'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',  
        'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',  
        'wapr','webc','winw','winw','xda','xda-'
        );  
     if(in_array($mobile_ua, $mobile_agents))  
      $mobile_browser++;  
     if(strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false)  
      $mobile_browser++;  
     // Pre-final check to reset everything if the user is on Windows  
     if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false)  
      $mobile_browser=0;  
     // But WP7 is also Windows, with a slightly different characteristic  
     if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false)  
      $mobile_browser++;  
     if($mobile_browser>0)  
      return true;  
     else
      return false;
    }

    function getCountry($id){
        return $c = $this->db->query("SELECT * FROM zy_country WHERE id = ".$id)->row_array();
    }

    
	

}


?>
