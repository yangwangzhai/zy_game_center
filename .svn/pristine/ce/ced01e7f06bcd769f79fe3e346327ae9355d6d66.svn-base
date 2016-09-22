<?php if (! defined('BASEPATH'))  exit('No direct script access allowed');
//  
session_start();
class milk_fight extends CI_Controller
{
	
	//private $appId = 'wxaa13dc461510723a';//真龙
   // private $appSecret = '0fd561ea6d2bce6410805f50c041d65a';//真龙
	
	private $appId = 'wx309d71544a02bd4a';//紫云
    private $appSecret = 'b8d778616059287d3854c8ef433d97c2';//紫云
	private $url_appid = 'wxaa13dc461510723a';//'wxb22508fbae4f4ef4'; //wx5442329a3bf072a0
	private $yrurl = 'wx.thewm.cn';  //生产环境    wx93024a4137666ab3   wx.zhenlong.wang
	
	public $ActiveID = 0;
	public $ChannelID = 0;
	public $RoomID = 0;
	function __construct ()
    {    
        parent::__construct();
		$this->ActiveID = $this->input->get('ActiveID') ? $this->input->get('ActiveID') : $this->input->get('AID');
		$this->ChannelID = $this->input->get('ChannelID') ? $this->input->get('ChannelID') : $this->input->get('CID');
		$this->RoomID = $this->input->get('RoomID') ? $this->input->get('RoomID') : $this->input->get('RID');
		if($this->ActiveID && !$this->ChannelID){
			$this->content_model->set_table( 'zy_active_main' );
			$row = $this->content_model->get_one($this->ActiveID, 'ActiveID');			
			$this->ChannelID = $row['ChannelID'];
			$this->RoomID    = $row['RoomID'];			
		}
		$this->load->model('my_common_model','common');
		
	}
	
    public function index () {	
	
		$ActiveID = $this->input->get('ActiveID');
		$ChannelID = $this->input->get('ChannelID');
		$RoomID = $this->input->get('RoomID');		
		
        //判断活动、游戏状态
        $isRun = $this->common->get_active_game_status($ActiveID,$RoomID);
        if(!$isRun['status']) {
            $data['msg'] = $isRun['msg'];
            $this->load->view('tip', $data);
            return;
        }
		
		if($ActiveID && $ChannelID && $RoomID){
			$url = 'http://h5game.gxtianhai.cn/mntvdb/gamecenter/index.php?d=milk&c=milk_fight&m=getInfo&AID='.$ActiveID;
			$state_base64 = base64_encode($url);        	
			$this->load->model('ChannelApi_model');
        	$apiUrl = $this->ChannelApi_model->getApi($ChannelID,'GetUserInfo');
        	$temp = sprintf($apiUrl,$state_base64);
			if(empty($temp)) show_msg('渠道接口获取失败ChannelID：'.$ChannelID.'！');
        	header("Location: ".$temp);

 			return;
		}else{
			show_msg('非法访问！');
			exit;
		}		
		
    } 
	
	
	function getInfo(){
		$openid = $data['openid'] = $_REQUEST['openid'];
		$nickname = $data['nickname'] = $_REQUEST['nickName'];
		$headPhoto = $data['headimgurl'] = $_REQUEST['headPhoto'];
		
		$ActiveID = $this->ActiveID;
		$ChannelID = $this->ChannelID;
		$RoomID = $this->RoomID;
		
		$data['game_sign'] = "&ActiveID=$this->ActiveID&ChannelID=$this->ChannelID&RoomID=$this->RoomID";
		$game_sign_sql = " AND ActiveID=$this->ActiveID AND ChannelID=$this->ChannelID AND RoomID=$this->RoomID";
		$data['has_save_info'] = 0;//是否保存过信息
		if(empty($openid)){
	        show_msg('openid is null,非法访问！');
		}else{
				
		}
		
		//判断活动是否结束
		$query = $this->db->get_where('zy_milk_attend_set', array('ActiveID' => $ActiveID, 'ChannelID' => $ChannelID, 'RoomID' => $RoomID), 1);
		$row_set = $query->row_array();
		if($row_set){		
			$data['game_time'] = $row_set['game_time'];
			$result_txt = '';
			if($row_set['isover'] == 1){
				//删除用户不存在的记录
				$this->db->query('DELETE FROM zy_milk_attend_log WHERE user_id NOT IN(SELECT id FROM zy_milk_attend_user WHERE 1 '.$game_sign_sql.' ) '.$game_sign_sql.'  OR user_id IS NULL');
				$where = array('ActiveID' => $ActiveID, 'ChannelID' => $ChannelID, 'RoomID' => $RoomID, 'openid' => $openid);
				$query = $this->db->get_where('zy_milk_attend_user', $where, 1);
				$row = $query->row_array();
				if($row){
					$data['user_id'] = $row['id'];	
					$user_id = $row['id']; 
					/*$rank_sql = 'SELECT M.*,C.is_winning FROM ( SELECT A.*,@rank:=@rank+1 AS pm FROM ' ;
					$rank_sql .= ' ( SELECT *,score AS MaxS FROM ( SELECT *  FROM zy_milk_attend_log ORDER BY score DESC,id ASC) AS b GROUP BY user_id  ORDER BY score DESC ,id ASC';
					$rank_sql .= ' ) A ,(SELECT @rank:=0) B ) M, zy_milk_attend_user C WHERE M.user_id=C.id AND M.user_id = '.$user_id.' ORDER BY M.user_id';
					$query = $this->db->query( $rank_sql );
					$row_result = $query->row_array();
					*/
					//排名
					$max_score = $row['max_score'];
					$query_pm = $this->db->query("SELECT COUNT(DISTINCT max_score) AS pm FROM zy_milk_attend_user WHERE max_score>= $max_score  AND status = 0 $game_sign_sql");
					$row_pm = $query_pm->row_array();
					
					
					$ranking = $row_pm['pm'];
					$max_score = $max_score;//$row_result['MaxS'];	
					$is_winning = $row['is_winning'];		
					
					$txt = array('','一','二','三');
					if(!empty($is_winning)){
						$data['is_winning'] = 1; 
						$result_txt = '<p>恭喜您获得了：<strong>'.$txt[$is_winning].'等奖</strong></p>';
					}else{
						$data['is_winning'] = 0; 
						$result_txt = '<p><strong>很遗憾，您未中奖~</strong></p>';
					}
					if($row['status'] == 1) $max_score = 0;
					$result_txt .= '<p>您的最高纪录喝了<strong>'.$max_score.'瓶</strong>奶</p>';
					$result_txt .= '<p>最佳排名：<strong>第'.$ranking.'名</strong></p>';
					
				}else{
					$result_txt = '<p><strong>本次活动已结束！</strong></p>';
				}
				$data['result_txt'] = $result_txt;
				$this->load->view('milk/result_view', $data);
				return;
			}
		}else{
			$data['game_time'] = 20;
		}
		
		
		
		//检查是否提交过手机号码
		$where = array('ActiveID' => $ActiveID, 'ChannelID' => $ChannelID, 'RoomID' => $RoomID, 'openid' => $openid);				
		$query = $this->db->get_where('zy_milk_attend_user', $where, 1);
		$row = $query->row_array();
		
		if($row){
			$data['has_save_info'] = 1;
			$data['user_id'] = $row['id'];	
			$data['max_score'] = $row['max_score'];		
		}else{
			$data['max_score'] = 0 ;
		}
		//添加游戏访问量
       	$this->common->add_game_VistNum($this->RoomID,$ChannelID,$ActiveID,trim($openid));

		
		$signPackage = $this-> getSignPackage();
		$data['signPackage'] = $signPackage;	    
        $this->load->view('milk/milk_fight_view', $data);
		
	}
	
	
	function index2(){
		 $data['game_time'] = 10;
		 $this->load->view('milk_fight_view2', $data);
	}
	public function save(){
		$comefrom = $_SERVER['HTTP_REFERER'];
		//$milk_url = base_url('index.php?c=milk_fight');
		//if( empty($comefrom) || !strstr($comefrom,$milk_url)){
		//	header('location: index.php?c=milk_fight');	
		//	exit;
		//}
		$game_sign_sql = " AND ActiveID=$this->ActiveID AND ChannelID=$this->ChannelID AND RoomID=$this->RoomID";
		
		$countdown = intval($_POST['countdown']);
		if($countdown > 249) {
			$data_log['openid'] = $_POST['openid'];
			$data_log['score'] = $_POST['countdown'];
			$data_log['addtime'] = time();
			
			$data_log['ip'] = ip();
			$data_log['comefrom'] = $comefrom;
			$data_log['browser'] = $this->getbrowser();
			$data_log['os'] = $this->getos();
			$data_log['ActiveID'] = $this->ActiveID;
			$data_log['ChannelID'] = $this->ChannelID;
			$data_log['RoomID'] = $this->RoomID;
			
			$query = $this->db->insert('zy_milk_attend_log2', $data_log);			
			echo -1;
			exit;
		}
		
		if($countdown == 0){
			$query = $this->db->query("SELECT COUNT(id) AS num FROM zy_milk_attend_user $game_sign_sql");
        	$count = $query->row_array();
        	$num = intval($count['num']);
			echo json_encode( array('status' => 0,'rank' => $num , 'max_count' => 0 ,'bfb' => 0 ,'user_id'=>-1) );
			exit;
		}
		
		$data['openid'] = $_POST['openid'];
		$data['sex'] = $_POST['sex'];
		$data['tel'] = $_POST['tel'];
		$data['nickname'] = $_POST['nickname'];
		$data['head_img'] = $_POST['headimgurl'];	
		$data['ActiveID'] = $this->ActiveID;
		$data['ChannelID'] = $this->ChannelID;
		$data['RoomID'] = $this->RoomID;			
		$data['addtime'] = time();
		
		//检查是否提交过手机号码
		$where = array('openid' => $data['openid'], 'ActiveID' => $this->ActiveID, 'ChannelID' => $this->ChannelID, 'RoomID' => $this->RoomID);
		$query = $this->db->get_where('zy_milk_attend_user', $where, 1);
		$row = $query->row_array();
		if($row){
			echo json_encode( array('status' => 2,'rank' => 0) );
			return;
		}
		//添加到公共用户名表
		$game_row = $this->db->get_where('zy_active_game', array('ChannelID'=>$data['ChannelID'],'ActiveID'=>$data['ActiveID'],'RoomID'=>$data['RoomID']),1)->row_array();
		
		$this->db->insert('zy_gamelist_user',array('Openid'=>$data['openid'],'Nickname'=>$data['nickname'],'ChannelID'=>$data['ChannelID'],'ActiveID'=>$data['ActiveID'],'GameID'=>$game_row['GameID'],'Num'=>$countdown,'UpdateTime'=>time(),'AddTime'=>time()));

        $query = $this->db->insert('zy_milk_attend_user', $data);
		$new_id = $this->db->insert_id();
		if($new_id){
			$data_log['user_id'] = $new_id;
			$data_log['score'] = $_POST['countdown'];
			$data_log['addtime'] = $data['addtime'];
			
			$data_log['ip'] = ip();
			$data_log['comefrom'] = $comefrom;
			$data_log['browser'] = $this->getbrowser();
			$data_log['os'] = $this->getos();
			$data_log['ActiveID'] = $this->ActiveID;
			$data_log['ChannelID'] = $this->ChannelID;
			$data_log['RoomID'] = $this->RoomID;	
		
			
			$query = $this->db->insert('zy_milk_attend_log', $data_log);
			
			$rank = $this->get_rank($new_id);
			echo json_encode( array('status' => 0,'rank' => $rank['pm'] , 'max_count' => $rank['MaxS'] ,'bfb' => $rank['bfb'] ,'user_id'=>$new_id) );
		}else{
			echo 1;
		}
}
	
	function save_log(){
		
		$comefrom = $_SERVER['HTTP_REFERER'];
		//$milk_url = base_url('index.php?c=milk_fight');
		//if( empty($comefrom) || !strstr($comefrom,$milk_url) ){
			//header('location: index.php?c=milk_fight');	
		//	echo -1;
		//	exit;
		//}		
		$countdown = intval($_POST['countdown']);
		$game_sign_sql = " AND ActiveID=$this->ActiveID AND ChannelID=$this->ChannelID AND RoomID=$this->RoomID";
		
		if($countdown == 0){
			$rank = $this->get_rank($_POST['user_id']);
			echo  json_encode( array('status' => 0,'rank' => $rank['pm'] , 'max_count' => $rank['MaxS']  ,'bfb' => $rank['bfb']) );
			exit;
		}
		$countdown = $_POST['countdown'];
		$openid = $_POST['openid'];
		$data_log['user_id'] = $_POST['user_id'];
		$data_log['score'] = $countdown;
		
		$data_log['ip'] = ip();
		$data_log['comefrom'] = $comefrom;
		$data_log['browser'] = $this->getbrowser();
		$data_log['os'] = $this->getos();
		$data_log['ActiveID'] = $this->ActiveID;
		$data_log['ChannelID'] = $this->ChannelID;
		$data_log['RoomID'] = $this->RoomID;	
		$data_log['addtime'] = time();
		
		
		$countdown = intval($_POST['countdown']);
		if($countdown > 249) {
			echo -1;
			$query = $this->db->insert('zy_milk_attend_log2', $data_log);	
			$query_pm = $this->db->query("UPDATE zy_milk_attend_user set   status= 1 where openID='{$openid}' $game_sign_sql ");		
			exit;
		}
		
		
		if($data_log['user_id'] == ''){
			$where = array('openid' => $openid, 'ActiveID' => $this->ActiveID, 'ChannelID' => $this->ChannelID, 'RoomID' => $this->RoomID);
			$query = $this->db->get_where('zy_milk_attend_user', $where, 1);
			$row = $query->row_array();
			if($row){				
				$data_log['user_id'] = $row['id'];
			}else{
				echo  json_encode( array('status' => 1) );
				return;
			}
			
		}else{
			$where = array('id' => $data_log['user_id'], 'ActiveID' => $this->ActiveID, 'ChannelID' => $this->ChannelID, 'RoomID' => $this->RoomID);
			$query = $this->db->get_where('zy_milk_attend_user', $where, 1);
			$row = $query->row_array();
			if($row){			
				
			}else{
				echo  json_encode( array('status' => 2) );
				return;
			}
			
		}
		$query = $this->db->insert('zy_milk_attend_log', $data_log);
		$rank = $this->get_rank($data_log['user_id']);
		echo  json_encode( array('status' => 0,'rank' => $rank['pm'] , 'max_count' => $rank['MaxS']  ,'bfb' => $rank['bfb']) );
	}
	
	
	function get_rank($user_id){
		$game_sign_sql = "AND ActiveID=$this->ActiveID AND ChannelID=$this->ChannelID AND RoomID=$this->RoomID";
		
		//删除用户不存在的记录
		$this->db->query('DELETE FROM zy_milk_attend_log WHERE user_id NOT IN(SELECT id FROM zy_milk_attend_user WHERE 1 '.$game_sign_sql.' ) '.$game_sign_sql.'  OR user_id IS NULL');
				
		$query = $this->db->query("SELECT COUNT(id) AS num FROM zy_milk_attend_user WHERE 1 $game_sign_sql");
        $count = $query->row_array();
        $num = intval($count['num']);
		
		$query_max = $this->db->query("SELECT *, score AS max_score FROM ( SELECT *  FROM zy_milk_attend_log WHERE 1 $game_sign_sql  ORDER BY score DESC,id ASC) AS b WHERE  b.user_id=$user_id  ORDER BY b.score DESC,b.id ASC LIMIT 1");
        $row_max_score = $query_max->row_array();
        $max_score = intval($row_max_score['max_score']);
		$lasttime = $row_max_score['addtime'];
		$countdown = intval($countdown);
		$MaxS = 0;
		
		$this->db->where('id',$user_id);
		$query = $this->db->update('zy_milk_attend_user',array('max_score'=>$max_score,'lasttime'=>$lasttime));
		 
		//$this->db->query("UPDATE zy_milk_attend_user SET max_score=$countdown  WHERE id = $user_id");
		//排名
		$query_pm = $this->db->query("SELECT COUNT(DISTINCT max_score) AS pm FROM zy_milk_attend_user WHERE max_score>= $max_score AND status=0  $game_sign_sql");
		//打败多少人
		$query_db = $this->db->query("SELECT COUNT(id) AS sum_db FROM zy_milk_attend_user WHERE max_score< $max_score AND status=0  $game_sign_sql");
		
		
        $row_pm = $query_pm->row_array();
		$row_db = $query_db->row_array();
		
		$row = array();
		$bfb = $row_db['sum_db'] / $num;
		if($bfb < 0.01){
				$bfb =  sprintf("%.4f", $bfb) * 100; 
		}else if($bfb > 0.98){
			$bfb = 99;
		}else{
				$bfb =  sprintf("%.2f", $bfb) * 100; 
		}
		
		
		return  array('pm' => $row_pm['pm'],'MaxS' => $max_score , 'bfb' => $bfb) ;
	}
	
	function rank_result(){
		$game_sign_sql = "AND ActiveID=$this->ActiveID AND ChannelID=$this->ChannelID AND RoomID=$this->RoomID";		
		//删除用户不存在的记录
		$this->db->query('DELETE FROM zy_milk_attend_log WHERE user_id NOT IN(SELECT id FROM zy_milk_attend_user WHERE 1 '.$game_sign_sql.' ) '.$game_sign_sql.'  OR user_id IS NULL');
		$query = $this->db->query("SELECT COUNT(id) AS num FROM zy_milk_attend_user where max_score > 0 $game_sign_sql");
        $count = $query->row_array();
        $count = intval($count['num']);
		$data['game_sign'] = "&ActiveID=$this->ActiveID&ChannelID=$this->ChannelID&RoomID=$this->RoomID";
		
		$this->config->load('pagination', TRUE);
        $pagination = $this->config->item('pagination');
        $pagination['base_url'] = 'index.php?d=milk&c=milk_fight&m=rank_result'.$data['game_sign'];
        $pagination['total_rows'] =   $count;//1006;
		$pagination['per_page'] = 6;
		$pagination['display_pages']= FALSE;//当前页码的前面和后面的"数字"链接的数量
		$pagination['next_link'] = '下一页'; // 下一页显示   
		$pagination['prev_link'] = '上一页'; // 上一页显示   
        $this->load->library('pagination');
        $this->pagination->initialize($pagination);
        $data['pages'] = $this->pagination->create_links();
        
        $offset = $_GET['per_page'] ? intval($_GET['per_page']) : 0;
		$per_page = 6;
		if( $offset > 1000){
			$per_page = 4;
		}
		$status_sql = ' AND status = 0 ';
		
		$rank_sql = ' select * FROM zy_milk_attend_user where max_score > 0 and max_score < 350 '.$status_sql.$game_sign_sql.' ORDER BY max_score DESC,lasttime ASC   limit '. $offset . ','.$per_page;
	//	$rank_sql = ' SELECT *, score AS max_score FROM ( SELECT *  FROM zy_milk_attend_log where score <350 ORDER BY score DESC,id ASC) AS b GROUP BY b.user_id  ORDER BY b.score DESC,b.id ASC  limit '. $offset . ','.$per_page;
		$query = $this->db->query( $rank_sql );
		$result = $query->result_array();	
		foreach($result as &$val){
			$val['MaxS'] = $val['max_score'];
			$max_score = $val['max_score'];
			//$query = $this->db->get_where('zy_milk_attend_user', array('id' => $val['user_id']), 1);
			//$row = $query->row_array();
			//$val['head_img'] = $row['head_img']; 
			$query_pm = $this->db->query("SELECT COUNT(DISTINCT max_score) AS pm FROM zy_milk_attend_user WHERE  max_score>= $max_score and max_score < 350  ".$status_sql.$game_sign_sql);
			$row_pm = $query_pm->row_array();
			$val['pm'] = $row_pm['pm'];
		}
		
		
		$data['list'] = $result;		
		$this->load->view('milk/rank_view', $data);
		
	}
	
	
	
	function winner_result(){
		$game_sign_sql = " AND ActiveID=$this->ActiveID AND ChannelID=$this->ChannelID AND RoomID=$this->RoomID";
		$data['game_sign'] = "&ActiveID=$this->ActiveID&ChannelID=$this->ChannelID&RoomID=$this->RoomID";
				
		//删除用户不存在的记录
		$this->db->query('DELETE FROM zy_milk_attend_log WHERE user_id NOT IN(SELECT id FROM zy_milk_attend_user WHERE 1 '.$game_sign_sql.' ) '.$game_sign_sql.'  OR user_id IS NULL');
		
		$query = $this->db->query("SELECT COUNT(id) AS num FROM zy_milk_attend_user where is_winning !=0 AND is_winning !='' $game_sign_sql");
        $count = $query->row_array();
        $count = intval($count['num']);
		
		$this->config->load('pagination', TRUE);
        $pagination = $this->config->item('pagination');
        $pagination['base_url'] = 'index.php?d=milk&c=milk_fight&m=winner_result'.$data['game_sign'];
        $pagination['total_rows'] =  $count;
		$pagination['per_page'] = 6;
		$pagination['display_pages']= FALSE;//当前页码的前面和后面的"数字"链接的数量
		$pagination['next_link'] = '下一页'; // 下一页显示   
		$pagination['prev_link'] = '上一页'; // 上一页显示   
        $this->load->library('pagination');
        $this->pagination->initialize($pagination);
        $data['pages'] = $this->pagination->create_links();
        
        $offset = $_GET['per_page'] ? intval($_GET['per_page']) : 0;
		
		$rank_sql = 'SELECT M.* ,C.is_winning,C.nickname,C.id,C.head_img,C.status  FROM ( SELECT A.*,@rank:=@rank+1 AS pm FROM ' ;
		$rank_sql .= ' ( SELECT *,score AS MaxS FROM ( SELECT *  FROM zy_milk_attend_log ORDER BY score DESC,id ASC) AS b GROUP BY user_id  ORDER BY score DESC,id ASC ';
	//	$rank_sql .= ' ( SELECT  * FROM (SELECT id,user_id,ADDTIME,score as MaxS  FROM  zy_milk_attend_log AS a     WHERE score=(SELECT MAX(b.score)    FROM zy_milk_attend_log AS b  WHERE a.user_id = b.user_id     )   ) AS a   GROUP BY user_id  ORDER BY MaxS DESC,id asc ';
		$rank_sql .= " ) A ,(SELECT @rank:=0) B ) M , zy_milk_attend_user C WHERE M.user_id=C.id AND C.is_winning !=0 AND C.is_winning !='' ORDER BY M.pm  limit ". $offset . ",6";
		$query = $this->db->query( $rank_sql );
		$result = $query->result_array();	
		
		$data['list'] = $result;
		$this->load->view('milk/winner_view', $data);
		
	}
	
	
	
	function get_wx_info($code = ''){
	    $appid = $this->appId;  
	    $secret = $this->appSecret;   
	    $code = $_GET["code"];      
	    $get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';  

	    
	    $ch=curl_init();
	    curl_setopt($ch,CURLOPT_URL,$get_token_url);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	    @curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在   
	    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);//返回文本流,
	    $data=curl_exec($ch);
	    curl_close($ch);
	    $json_obj=json_decode($data,true);
	    
	    
	    $access_token = $json_obj['access_token'];  
	    $openid = $json_obj['openid'];  
	    $get_user_info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';  
	      
	    $ch = curl_init();  
	    curl_setopt($ch,CURLOPT_URL,$get_user_info_url);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	    @curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在   
	    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);//返回文本流,
	    $res = curl_exec($ch);  
	    curl_close($ch);        
	    //解析json  
	    $user_obj = json_decode($res,true);  
	    return $user_obj;
	}   
	// snsapi_userinfo snsapi_base
	function get_code($id=''){
	    $url = urlencode('http://h5game.gxtianhai.cn/index.php?c=milk_fight');
	    header('Location: https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$this->appId.'&redirect_uri='.$url.'&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect');   
	}
	
	
	
	
	function getDataFromCurl($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1');
		$data = curl_exec($ch);
		$status = curl_getinfo($ch);
		$errno = curl_errno($ch);
		curl_close($ch);
		return $data;
	}
	
	public function getSignPackage() {
	    $jsapiTicket = $this->getJsApiTicket();
	
	    // 注意 URL 一定要动态获取，不能 hardcode.
	    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	    $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	
	    $timestamp = time();
	    $nonceStr = $this->createNonceStr();
	
	    // 这里参数的顺序要按照 key 值 ASCII 码升序排序
	    $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
	
	    $signature = sha1($string);
	
	    $signPackage = array(
	        "appId"     => $this->appId,
	        "nonceStr"  => $nonceStr,
	        "timestamp" => $timestamp,
	        "url"       => $url,
	        "signature" => $signature,
	        "rawString" => $string
	    );
	    return $signPackage;
	}
	
	private function createNonceStr($length = 16) {
	    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	    $str = "";
	    for ($i = 0; $i < $length; $i++) {
	        $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
	    }
	    return $str;
	}
	
	private function getJsApiTicket() {
	    // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
		$isexit = $this->db->query("select *   from zy_racedog_wx_token where type='ticket' ")->row_array();	
	    
	    if ($isexit['expire_time'] < time()) {
	        $accessToken = $this->getAccessToken();
	        // 如果是企业号用以下 URL 获取 ticket
	        // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
	        $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
	        $res = json_decode($this->httpGet($url));
	        $ticket = $res->ticket;
	        if ($ticket) {
				$data['expire_time'] = time() + 7000;
	            $data['content'] = $ticket;
				$this->db->where('type','ticket');
	            $this->db->update('zy_racedog_wx_token',$data);	            
	        }
	    } else {
	        $ticket = $isexit['content'] ;
	    }
	
	    return $ticket;
	}
	
	private function getAccessToken() {
	    // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
	    $isexit = $this->db->query("select *   from zy_racedog_wx_token where type='token' ")->row_array();	
	    if ($isexit['expire_time'] < time()) {
	        // 如果是企业号用以下URL获取access_token
	        // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
	        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
	        $res = json_decode($this->httpGet($url));
	        $access_token = $res->access_token;
	        if ($access_token) {
				
	            $data['expire_time'] = time() + 7000;
	            $data['content'] = $access_token;
				$this->db->where('type','token');
	            $this->db->update('zy_racedog_wx_token',$data);
	        }
	    } else {
	        $access_token = $isexit['content'];
	    }
	    return $access_token;
	}
	
	private function httpGet($url) {
	    $ch=curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在   
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);//返回文本流,
		$res=curl_exec($ch);
		curl_close($ch);
	
	    return $res;
	}
	
	private function get_php_file($filename) {
	    return trim(substr(file_get_contents($filename), 15));
	}
	private function set_php_file($filename, $content) {
	    $fp = fopen($filename, "w");
	    fwrite($fp, "<?php exit();?>" . $content);
	    fclose($fp);
	}
	
	function getbrowser() { 
        $browser = $_SERVER['HTTP_USER_AGENT']; 
       
        return $browser; 
    } 
    function getos() { 
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
	
	
	function update_log(){
		$rank_sql = ' SELECT *, score AS max_score FROM ( SELECT *  FROM zy_milk_attend_log  ORDER BY score DESC,id ASC) AS b GROUP BY b.user_id  ORDER BY b.score DESC,b.id ASC ';
		$query = $this->db->query( $rank_sql );
		$result = $query->result_array();	
		foreach($result as $val){
			$lasttime = $val['addtime'];
			$user_id = $val['user_id'];
			$query_pm = $this->db->query("UPDATE zy_milk_attend_user set   lasttime= $lasttime where id=$user_id");
			
		}
	}

	
}




?>
