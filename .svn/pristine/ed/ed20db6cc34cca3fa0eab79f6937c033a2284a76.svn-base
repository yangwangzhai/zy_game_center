<?php if (! defined('BASEPATH'))  exit('No direct script access allowed');
//  
session_start();
class raceDog extends CI_Controller
{
	private $openidkey = 'wx263e9fc25c21324f';
	
	private $zlkey = '123456';
	private $zlapp_id = '123456';   //111111
	
	private $appId = 'wx309d71544a02bd4a';//紫云
    private $appSecret = 'b8d778616059287d3854c8ef433d97c2';//紫云
	
	private $url_appid = 'wxaa13dc461510723a';//'wxb22508fbae4f4ef4'; //wx5442329a3bf072a0
	private $yrurl = 'wx.thewm.com.cn';  //生产环境    wx93024a4137666ab3   wx.zhenlong.wang
	//private $yrurl = 'zl.haiyunzy.com';  //测试环境   wxb22508fbae4f4ef4
	
	private $systemPlayer = 'systemPlayer'; //系统玩家的openid
	
	function __construct ()
    {    
        parent::__construct();
        $this->ChannelID = intval($_GET['ChannelID']);
        $this->ActiveID = intval($_GET['ActiveID']);
        $this->RoomID = intval($_GET['RoomID']);
        $this->sql_where = " AND ChannelID={$this->ChannelID} AND ActiveID={$this->ActiveID} AND RoomID={$this->RoomID} ";	
		
	}
	
    public function index () {	
	
	
		//是否存在游戏设置
		//$exit_game_set = $this->db->query("select *  from zy_racedog_game_set where id=1 ")->row_array();
		$game_set_start = $this->my_common_model->getRule('start_time',$this->ChannelID,$this->ActiveID,$this->RoomID);
		$game_set_end = $this->my_common_model->getRule('end_time',$this->ChannelID,$this->ActiveID,$this->RoomID);
		$now_time =  strtotime(date('Y-m-d H:i'));	
		$start_time = strtotime( date('Y-m-d 07:30') );
		$end_time = strtotime( date('Y-m-d 23:30') );
		if($game_set_start && $game_set_end){
			$start_time = strtotime( date( 'Y-m-d ' . $game_set_start ) );
			$end_time = strtotime( date( 'Y-m-d '. $game_set_end ) );
		}


		//如果在维护时间内则进入维护页面
		if($now_time < $start_time || $now_time > $end_time ){
			redirect('d=racedog&c=raceDog&m=repaired&ChannelID='.$this->ChannelID.'&ActiveID='.$this->ActiveID.'&RoomID='.$this->RoomID);
			return;
		}
		/*$state_base64 = base64_encode('http://h5game.gxtianhai.cn/racedog/index.php?c=raceDog&m=getUserInfo');
		header('Location: https://open.weixin.qq.com/connect/oauth2/authorize?appid='. $this->url_appid .'&redirect_uri=http://'. $this->yrurl .'/thirdInterface/thirdInterface!autoLogin2.action&response_type=code&scope=snsapi_base&state='.$state_base64.'#wechat_redirect');*/
		
		$state_base64 = base64_encode('http://h5game.gxtianhai.cn/gamecenter/index.php?d=racedog&c=raceDog&m=getUserInfo&CID='.$this->ChannelID.'&AID='.$this->ActiveID.'&RID='.$this->RoomID);
        $this->load->model('ChannelApi_model');
        $apiUrl = $this->ChannelApi_model->getApi($this->ChannelID,'GetUserInfo');
        if(!$apiUrl){
            $data['msg']='渠道接口未开启';
            $this->load->view('tip', $data);
            return;
        }
        $temp = sprintf($apiUrl,$state_base64);
        
        header("Location: ".$temp);
    } 
	
	//提交下注
	function save_beton(){		
		$bet_gold_sum = 0;
		$postData = $_POST['data'];		
		$postData = json_decode($postData,true);	
		$cur_game = $this->db->query("select id from zy_racedog_game WHERE 1 {$this->sql_where} order by id desc limit 1")->row_array();
		$cur_game_id = $cur_game['id'];	
		$session_id_exit = $this->check_seesion_id($postData[0]['openid']);
		if($session_id_exit){
			
			foreach($postData as $val){
				$bet_gold_sum += intval($val['gold']); //累积烟豆扣除
			}
			
			//查询烟豆数
			//$user = $this->getYD($postData[0]['openid']);
			$user_obj = array('status'=>0,'smokeBeansCount'=>10000);//json_decode($user,true);	
			$smokeBeansCount = 0;		
			if($user_obj['status'] == '0'){				
					$smokeBeansCount = $user_obj['smokeBeansCount'];
			}
			
			if($smokeBeansCount < $bet_gold_sum ){
				$data_uncommon_log['openid'] = $postData[0]['openid'];		
				$data_uncommon_log['gameid'] = $cur_game_id;
				$data_uncommon_log['smokeBeansCount'] = $smokeBeansCount;
				$data_uncommon_log['bet_gold_sum'] = $bet_gold_sum ;
				$data_uncommon_log['content'] =	 '下注';			
				$data_uncommon_log['addtime'] = time(); 
				$data_uncommon_log['phone_os'] = $_SERVER['HTTP_USER_AGENT'] ? $_SERVER['HTTP_USER_AGENT'] : '';
				$data_uncommon_log['ChannelID'] = $this->ChannelID;
				$data_uncommon_log['ActiveID'] = $this->ActiveID;
				$data_uncommon_log['RoomID'] = $this->RoomID;
				$this->db->insert('zy_racedog_uncommon_log',$data_uncommon_log);
				echo -3;
				exit;
			}
			
			
		/*	$status = $this->consumeYD($bet_gold_sum, $postData[0]['openid'], '下注', $cur_game_id );//消耗烟豆
			
			if($status['status'] != '0' ){
				echo -2;
				exit;
			}*/
			
			foreach($postData as &$val){
				if( empty($val['openid']) || empty($val['dog']) ) continue;
				$data = array();	
				$data['openid'] = $val['openid'];		
				$data['dog'] = $val['dog'];
				$data['gold'] = $val['gold'];
				$data['gameid'] = $cur_game_id ;				
				$data['addtime'] = time(); 
				$data['ChannelID'] = $this->ChannelID;
				$data['ActiveID'] = $this->ActiveID;
				$data['RoomID'] = $this->RoomID;
					
				//判断是否这只狗狗下过注		
				$isexit = $this->db->query("select count(*) as num  from zy_racedog_bet_on where openid='".$data['openid']."' AND dog= '".$data['dog']."' AND gameid=".$data['gameid'])->row_array();
				if($isexit['num'] > 0){
					$this->db->query( "UPDATE zy_racedog_bet_on SET gold = gold+". $data['gold'] ." WHERE  openid='".$data['openid']."' AND dog= '".$data['dog']."' AND gameid=".$data['gameid']);
			
				}else{
					$this->db->insert('zy_racedog_bet_on',$data);	
				}
				$val['key'] = md5($this->openidkey . $val['dog'] . $val['gold'] . $cur_game_id);
			}
		//	$this->db->query( "UPDATE zy_player SET total_gold = total_gold-". $bet_gold_sum ." WHERE  openid= '".$postData[0]['openid'] ."'");
			
			
			
			echo json_encode($postData);
		}else{
			echo json_encode(-1);
		}
		
	}
	//重复下注
	function save_beton_again(){
		$bet_gold_sum = 0;
		$postData = $_POST['openid'];
		//判断是否有session
		$session_id_exit = $this->check_seesion_id($postData);
		if(!$session_id_exit){
		
			 echo -1 ;
			 exit;
		}
		
		$return_array = array();//重复提交返回的狗狗信息，广播给客户端
		$cur_game = $this->db->query("select id from zy_racedog_game WHERE 1 {$this->sql_where} order by id desc limit 1")->row_array();
		$cur_game_id = $cur_game['id'];

		//上一局id
		$pre_game = $this->db->query("select id from zy_racedog_game WHERE id < {$cur_game_id} {$this->sql_where} order by id desc limit 1")->row_array();
		$pre_game_id = $pre_game['id'];
	
		
		$sql = "SELECT dog,gold FROM zy_racedog_bet_on WHERE openid= '" .$postData. "' AND gameid=" .($pre_game_id) ;
		$query = $this->db->query( $sql );
		$result = $query->result_array();
		if(count($result) <1 ){ //上一局没有 下注
			$data['dog'] = '0';
			$data['openid'] = $postData;
			$data['gold'] = '2';		
			$data['key'] = md5($this->openidkey . $data['gold'] . $data['dog'] . $cur_game_id);	
			array_push($return_array,$data);
			echo json_encode($return_array);
			exit;
			
		}
		
		
		foreach($result as $val){
				$bet_gold_sum += intval($val['gold']); //累积烟豆扣除
		}
		
		//$user = $this->getYD($postData);
		$user_obj = array('status'=>0,'smokeBeansCount'=>10000);//json_decode($user,true);	
		$smokeBeansCount = 0;		
		if($user_obj['status'] == '0'){				
				$smokeBeansCount = $user_obj['smokeBeansCount'];
		}
		
		
		if($smokeBeansCount < $bet_gold_sum){ //烟豆不足时
			$data_uncommon_log['openid'] = $postData;		
			$data_uncommon_log['gameid'] = $cur_game_id;
			$data_uncommon_log['smokeBeansCount'] = $smokeBeansCount;
			$data_uncommon_log['bet_gold_sum'] = $bet_gold_sum ;
			$data_uncommon_log['content'] =	 '重复下注';						
			$data_uncommon_log['addtime'] = time(); 
			$data_uncommon_log['phone_os'] = $_SERVER['HTTP_USER_AGENT'] ? $_SERVER['HTTP_USER_AGENT'] : '';
			$data_uncommon_log['ChannelID'] = $this->ChannelID;
			$data_uncommon_log['ActiveID'] = $this->ActiveID;
			$data_uncommon_log['RoomID'] = $this->RoomID;
			$this->db->insert('zy_racedog_uncommon_log',$data_uncommon_log);
		
		
		
			$data['dog'] = '-1';
			$data['openid'] = $postData;
			$data['gold'] = '2';		
			$data['key'] = md5($this->openidkey . $data['gold'] . $data['dog'] . $cur_game_id);	
			array_push($return_array,$data);
			echo json_encode($return_array);
			exit;
		}
		
		
		/*$status = $this->consumeYD($bet_gold_sum, $postData, '重复下注', $cur_game_id );//消耗烟豆
			
		if($status['status'] != '0' ){
				echo -2;
				exit;
		}*/
		
		$sql_insert = "INSERT INTO `zy_racedog_bet_on`( `openid`, `gameid`,  `dog`,  `gold` , `addtime`, `ChannelID`, `ActiveID`, `RoomID`) SELECT '" . $postData. "'," . $cur_game_id .",dog,gold, ".time().",ChannelID,ActiveID,RoomID FROM zy_racedog_bet_on WHERE openid='" . $postData. "' AND gameid =".($pre_game_id);
		$query_insert = $this->db->query( $sql_insert );	
		
		
		foreach($result as $val){
			$data = array();			
			$data['dog'] = $val['dog'];
			$data['openid'] = $postData;
			$data['gold'] = $val['gold'];
			$data['key'] = md5($this->openidkey . $val['dog'] . $val['gold'] . $cur_game_id);
			array_push($return_array,$data);
			//$bet_gold_sum += intval($val['gold']); //累积烟豆扣除
			
		}
		
		
		
		//$this->db->query( "UPDATE zy_player SET total_gold = total_gold-". $bet_gold_sum ." WHERE  openid= '".$postData ."'");
		
		echo json_encode($return_array);
	}
	
	//送礼物
	function save_gift(){
		//判断是否有session
		$postData = $_POST['data'];				
		$postData = json_decode($postData,true);
		$session_id_exit = $this->check_seesion_id($postData['openid']);
		if(!$session_id_exit){
			 echo -1 ;
			 exit;
		}	
		
		
		$cur_game_id = $this->get_game_id();
		$data['openid'] = $postData['openid'];		
		$data['dog'] = $postData['dog'];
		$data['gold'] = $postData['gold'];
		$data['gift_type'] = $postData['gift_type'];	
		$data['num'] = $postData['num'] ? $postData['num'] : 1;		
		$data['gameid'] = $cur_game_id ;
		$data['addtime'] = time(); 
		
		$total_gold = intval($data['gold']) * intval($data['num']);
		
		
		//查询烟豆数
		$user = $this->getYD($postData['openid']);
		$user_obj = json_decode($user,true);	
		$smokeBeansCount = 0;		
		if($user_obj['status'] == '0'){				
				$smokeBeansCount = $user_obj['smokeBeansCount'];
		}
		
		if($smokeBeansCount < $total_gold ){
			echo -3;
			exit;
		}
		
		
		$status = $this->consumeYD($total_gold, $data['openid'], '送道具-'.$data['gift_type'], $cur_game_id );//消耗烟豆
			
		if($status['status'] != '0' ){
				echo -2;
				exit;
		}
		
		
		
		$this->db->insert('zy_gift_log',$data);
		
		$data['key'] = md5($this->openidkey . $data['gold'] . $data['dog'] . $data['gift_type'] . $cur_game_id);	
		$this->db->query( "UPDATE zy_player SET total_gold = total_gold-". $total_gold ." WHERE  openid= '". $postData['openid'] ."'");
		
		
		echo json_encode($data);
		
		
	}
	
	
	//系统自动下注
	function system_beton(){		
		$bet_gold_sum = 0;
		$postData = $_REQUEST['data'];			
		$postData = json_decode($postData,true);		
		$cur_game = $this->db->query("select id from zy_racedog_game WHERE 1 {$this->sql_where} order by id desc limit 1")->row_array();
		$cur_game_id = $cur_game['id'];	
			foreach($postData as $val){
				$bet_gold_sum += intval($val['gold']); //累积烟豆扣除
			}
			
			foreach($postData as &$val){
				if( empty($val['openid']) || empty($val['dog']) ) continue;
				$data = array();	
				$data['openid'] = $val['openid'];		
				$data['dog'] = $val['dog'];
				$data['gold'] = $val['gold'];
				$data['gameid'] = $cur_game_id ;				
				$data['addtime'] = time(); 
				$data['ChannelID'] = $this->ChannelID;
				$data['ActiveID'] = $this->ActiveID;
				$data['RoomID'] = $this->RoomID;
					
				//判断是否这只狗狗下过注		
				$isexit = $this->db->query("select count(*) as num  from zy_racedog_bet_on where openid='".$data['openid']."' AND dog= '".$data['dog']."' AND gameid=".$data['gameid']." ".$this->sql_where)->row_array();
				if($isexit['num'] > 0){
					$this->db->query( "UPDATE zy_racedog_bet_on SET gold = gold+". $data['gold'] ." WHERE  openid='".$data['openid']."' AND dog= '".$data['dog']."' AND gameid=".$data['gameid']." ".$this->sql_where);
			
				}else{
					$this->db->insert('zy_racedog_bet_on',$data);	
				}
				$val['key'] = md5($this->openidkey . $val['dog'] . $val['gold']);
			}
			echo json_encode($postData);
		
		
	}

	
	
	
	
	
	//获取游戏局数的id
	function get_game_id(){
		$cur_game = $this->db->query("select id from zy_racedog_game WHERE 1 {$this->sql_where} order by id desc limit 1")->row_array();
		$cur_game_id = $cur_game['id'];
		return $cur_game_id;
	}
	

	
	function dogspeeds(){
		$times = array(1=>13,2=>13.5,3=>14,4=>14.5,5=>15);	
		$dogspeedArr = array();
		$numbers = range(1,5);
		srand((float)microtime()*1000000);
		shuffle($numbers);
		//$numbers = array(4,3,2,5,1);
		 $cur_game_id = $this->get_game_id();
		 
		$numbers = $this->get_ranking($numbers , $cur_game_id );
		 
		 $result = array2string($numbers);
		 $data['ranking'] =   $result;
		 $this->db->where('id', $cur_game_id );
		 $this->db->update('zy_racedog_game',$data);
		// $this->db->query( "UPDATE zy_game SET ranking = '". $result ."' WHERE  id= '". $cur_game_id."'");
		//$numbers = array(4,3,1,5,2);
		
		foreach ($numbers as $key=>$number) {			
			$newspeed = $this->spendRand($key);		
			$dogspeedArr[$number-1] = $newspeed;			
		}
		
		ksort($dogspeedArr);
		echo json_encode($dogspeedArr );

	}
	
	function saveSCZ(){
		$openid = $_REQUEST['openid'];
		if(!empty($openid)){
			 $cur_game_id = $this->get_game_id();
			 $data['game_owner'] =   $openid;
			 $this->db->where('id', $cur_game_id );
			 $this->db->update('zy_racedog_game',$data);
			 sleep(3);//暂停三秒再进入结算，防止30秒时有人提交
			 $this->reckon( $cur_game_id , $openid);
		}
		var_dump($_REQUEST);
	}
	
	//结算
	function reckon( $cur_game_id, $SCZopenid ){
		
			//$cur_game_id = 608;$this->get_game_id();
			/*$numbers = "array (
  0 => '2',
  1 => '5',
  2 => '3',
  3 => '1',
  4 => '4',  3 2 5 4 1
)";*/
			$cur_game = $this->db->query("select ranking from zy_racedog_game where id= $cur_game_id limit 1")->row_array();
		    $numbers = $cur_game['ranking'];
			$result = string2array($numbers);
			$bh_to_rank = array();
			$bh_to_bs = array();			
			foreach( $result as $key=>$val){
				$dogBH = $val;
				$ranking = $key+1;
				$bh_to_rank[$dogBH] = $ranking;				
			}
			$cz_ranking = $bh_to_rank[1];
			$multiples = array(0,5,3,2,1);
			foreach( $bh_to_rank as $bh=>$pm){//
				if($bh == 1) continue;
				$bs = 0;
				if($cz_ranking == 1) {
					$bs = -5;
					$bh_to_bs[$bh] = $bs;
					//array_push($bh_to_bs,array($bh=>$bs));
					continue;
				}
				
				if($pm > $cz_ranking) {
					$bs = -$multiples[$cz_ranking];
					$bh_to_bs[$bh] = $bs;
				}
				if($pm <$cz_ranking) {
					$bs = $multiples[$pm];
					$bh_to_bs[$bh] = $bs;
				}				
				
			}
			
			foreach($bh_to_bs as $key=>$val ){
				$sql = 'UPDATE zy_racedog_bet_on SET bs = '.$val.',last_gold = gold*'.$val.',updatetime = '.time().' WHERE gameid = '.$cur_game_id.' AND dog = '.$key;
				$this->db->query($sql);
				//echo $this->db->last_query() . '<br>';
			}
			
			//再次查找为倍数0 的记录
			$sql_a = "SELECT * FROM zy_racedog_bet_on WHERE gameid=" .$cur_game_id . " AND bs=0";
			$query_a = $this->db->query( $sql_a );
			$result_a = $query_a->result_array();
			foreach($result_a as $val){
				$dog = $val['dog'];
				$bs = $bh_to_bs[$dog];
				$id = $val['id'] ? $val['id'] : 0;
				$sql = 'UPDATE zy_racedog_bet_on SET bs = '.$bs.',last_gold = gold*'.$bs.',remark = '.time().' WHERE id = '.$id;
				$this->db->query($sql);
			}
			
			
			$sql = "SELECT dog,gold,openid FROM zy_racedog_bet_on WHERE gameid=" .$cur_game_id . " GROUP BY openid";
			$query = $this->db->query( $sql );
			$result = $query->result_array();
			foreach($result as $val){
				
				if($val['openid'] == $this->systemPlayer) continue;
				
				//更新游戏玩家表的最终剩余烟豆
				$update_sql = "SELECT sum(last_gold) as last_gold,openid  FROM zy_racedog_bet_on WHERE  gameid=". $cur_game_id ." AND openid='" .$val['openid']. "'";
				$total = $this->db->query( $update_sql )->row_array();				
				$return = array();
				$yd_total = $total['last_gold'];
				if($total['last_gold'] > 0){					
					$return = $this->rechargeDY($total['last_gold'], $val['openid'], '玩疯狂赛狗赢', $cur_game_id );//充值烟豆
				}else{
					$return = $this->consumeYD($total['last_gold'], $val['openid'], '玩疯狂赛狗输', $cur_game_id );//消耗烟豆
				}
				
				if(!empty($return) && $return['status'] == 0){
				
					$this->db->query( "UPDATE zy_racedog_player SET total_gold = ".$return['smokeBeansCount']." WHERE  openid= '".$val['openid']."' ".$this->sql_where);
					//说明是消耗烟豆
					if($return['errormsg'] == '成功') $return['smokeBeans'] = -$return['smokeBeans'];
					$data = array();
					$data['openid'] = 	$val['openid'];	 
					$data['gameid'] = 	$cur_game_id;	 
					$data['total'] = $return['smokeBeans'];	
					$data['yd_total'] = $yd_total;
					$data['addtime'] = 	time();
					$data['ChannelID'] = $this->ChannelID;
					$data['ActiveID'] = $this->ActiveID;
					$data['RoomID'] = $this->RoomID;
					$this->db->insert('zy_racedog_player_result',$data); 	
				
				}
			}
			
			//计算赛场主输赢的烟豆
			$sql = "SELECT sum(last_gold) as last_gold  FROM zy_racedog_bet_on WHERE  gameid=". $cur_game_id ;
			$total = $this->db->query( $sql )->row_array();
			if(empty($total['last_gold'])) return; //没人参与游戏
			
			//如果玩家结算后烟豆大于零，说明赛场主输
			$return = array();
			if($total['last_gold'] > 0){
					$return = $this->consumeYD($total['last_gold'], $SCZopenid, '赛场主输', $cur_game_id );//消耗烟豆
			}else{
					$return = $this->rechargeDY(abs($total['last_gold']), $SCZopenid, '赛场主赢', $cur_game_id );//充值烟豆
			}
			
			if(!empty($return) && $return['status'] == 0){
			
				$data = array();
				$data['openid'] = 	$SCZopenid;	 
				$data['gameid'] = 	$cur_game_id;
				$data['is_scz'] = 	1;	 
				$data['total'] = $total['last_gold'] > 0 ? -($return['smokeBeans']) : abs($return['smokeBeans']) ;	
				$data['addtime'] = 	time();
				$data['ChannelID'] = $this->ChannelID;
				$data['ActiveID'] = $this->ActiveID;
				$data['RoomID'] = $this->RoomID;
				$this->db->insert('zy_racedog_player_result',$data); 	
				$this->db->query( "UPDATE zy_racedog_player SET total_gold = ".$return['smokeBeansCount']." WHERE  openid= '".$SCZopenid."' ".$this->sql_where);
			}
			//$this->update_spuer_dog();//更新超级狗庄的烟豆
		
		//	var_dump($bh_to_bs);
			
	}
	
	function spendRand($key){
		//25步
		$rank1 = array(15, 20, 31,  21, 130,  20, 18,  23,  15,  21,  15,  23, 18,  20, 21,  20,  15,  17,  26,  25,  23, 15,  27,  20,  21);
		//26步
		$rank2 = array(22, 20, 30,  21, 20,  19, 18,  23,  70,  27,  23, 25,  26, 18,  23, 17,  20,  25,  20,  26,  21,  20, 15,  22,  28,  21);
		
		//27步
		$rank3 = array(22, 70, 26,  21, 20,  19, 18,  23,  20,  27,  23, 25,  26, 16,  18,  21, 17,  20,  21,  20,  24,  19,  18, 15,  22,  28,  21);
		
		//28步
		$rank4 = array(22, 19, 25,  20, 70,  18, 17,  22,  20,  26,  22, 24,  22, 16,  17, 18,  21, 17,  18,  20,  20,  22,  19,  18, 15,  22,  28,  22);
		
		//29步
		$rank5 = array(22, 18, 24,  20, 18,  16, 15,  21,  20,  25,  21, 24,  22, 16,  17, 70,  16,  21, 15,  18,  20,  19,  22,  19,  18, 15,  22,  25,  21);
		
		@include("./application/controllers/racedog/speed.data.php");
		$ranks = $_speendata;
		
		//$ranks = array($rank1, $rank2, $rank3, $rank4, $rank5);
		
	//	srand((float)microtime()*1000000);
	//	shuffle($ranks[$key]);
		return $ranks[$key];
				
	}
	
	//获取通杀或通赔
	function get_tx_tp(){
		$cur_game_id = $this->get_game_id(); 
		$cur_game = $this->db->query("select ranking from zy_racedog_game WHERE 1 {$this->sql_where} order by id desc  limit 1,1")->row_array();

		//上一局id
		$pre_game = $this->db->query("select id from zy_racedog_game WHERE id < {$cur_game_id} {$this->sql_where} order by id desc limit 1")->row_array();
		$pre_game_id = $pre_game['id'];

		$numbers = $cur_game['ranking'];
		$result = string2array($numbers);
		$data['status'] = 0;
		$data['total'] = 0;
		if($result[0] == '1'){ //通杀
			$total = $this->db->query("select SUM(last_gold) AS total from zy_racedog_bet_on where  gameid=".$pre_game_id." {$this->sql_where} limit 1")->row_array();
			$data['status'] = 1;
			$data['total'] = $total['total'] != NULL  ? abs($total['total']) : NULL;
			
			if( empty($total['total']) ){
				$content = $this->db->query("select content from zy_racedog_xlb where   status=0 {$this->sql_where} order by rand() limit 1")->row_array();
				if($content && !empty($content['content'])){
					$data['status'] = 3;
					$data['content'] = $content['content'];
				}
			}
			
			
		}else if($result[4] == '1') {//通赔
			$total = $this->db->query("select SUM(last_gold) AS total from zy_racedog_bet_on where  gameid=".$pre_game_id." {$this->sql_where} limit 1")->row_array();
			$data['status'] = -1;
			$data['total'] = $total['total'];
			
			if( empty($total['total']) ){
				$content = $this->db->query("select content from zy_racedog_xlb where   status=0 {$this->sql_where} order by rand() limit 1")->row_array();
				if($content && !empty($content['content'])){
					$data['status'] = 3;
					$data['content'] = $content['content'];
				}
			}
			
		}else{
			$total = $this->db->query("select MAX(total) AS total,openid from zy_racedog_player_result where   gameid=".$pre_game_id." AND total > 0 {$this->sql_where} limit 1")->row_array();
			if($total && !empty($total['total'])){
				
				
				$cur_player = $this->db->query("select nickname from zy_racedog_player where openid = '".$total['openid']."' {$this->sql_where}")->row_array();
				$data['nickname'] = $cur_player['nickname'];
				$data['status'] = 2;
				$data['total'] = $total['total'];
				//如果大于1000就推送给云软
				if($data['total'] > 1000 ){
						//推送给云软的头条内容
					$url = 'http://'. $this->yrurl .'/integral/winning!saveWinningInfo.action';
					$tt_data['winningName'] = '疯狂赛狗';
					$tt_data['winningState'] = 1;
					$tt_data['winningContent'] = '玩家[' . $data['nickname'] . ']赢得' . $data['total'] . '烟豆!';
					$tt_data['winningType'] = 'SG';//活动类型（赛狗：SG，跑马灯：PMD）
					$return = $this->curlPost($url,$tt_data);
					
					
					//存入数据库
					$data_log['addtime'] = time();
					$data_log['desc'] = json_encode($tt_data);
					$data_log['return'] = $return;
					$data_log['gameid'] = 0;
					$data_log['browser'] =  ''; 
					$data_log['ip'] = ip();
					$data_log['comefrom'] =   ''; 	
					$data_log['postUrl'] =  $url;	
					$data_log['ChannelID'] = $this->ChannelID;
					$data_log['ActiveID'] = $this->ActiveID;
					$data_log['RoomID'] = $this->RoomID;	
					$this->db->insert('zy_racedog_recharge_log',$data_log);
				}
				
				
			}else{
				$content = $this->db->query("select content from zy_racedog_xlb where   status=0 {$this->sql_where} order by rand() limit 1")->row_array();
				if($content && !empty($content['content'])){
					$data['status'] = 3;
					$data['content'] = $content['content'];
					
					//推送给云软的头条内容
					$url = 'http://'. $this->yrurl .'/integral/winning!saveWinningInfo.action';
					$tt_data['winningName'] = '疯狂赛狗';
					$tt_data['winningState'] = 1;
					$tt_data['winningContent'] = $content['content'];
					$tt_data['winningType'] = 'SG';//活动类型（赛狗：SG，跑马灯：PMD）
					$return = $this->curlPost($url,$tt_data);
					
					
					//存入数据库
					$data_log['addtime'] = time();
					$data_log['desc'] = json_encode($tt_data);
					$data_log['return'] = $return;
					$data_log['gameid'] = 0;
					$data_log['browser'] =  ''; 
					$data_log['ip'] = ip();
					$data_log['comefrom'] =   ''; 	
					$data_log['postUrl'] =  $url;	
					$data_log['ChannelID'] = $this->ChannelID;
					$data_log['ActiveID'] = $this->ActiveID;
					$data_log['RoomID'] = $this->RoomID;			
					$this->db->insert('zy_racedog_recharge_log',$data_log);
					
					
				}
			}
		}
		
		
		
		
		echo json_encode($data);
	}
	
	function update_spuer_dog(){
		//更新超级狗庄的烟豆
		$yd = $this->getYD('zyracedog20160418');
		$yd = json_decode($yd,true);	
		$smokeBeansCount = 0;		
		if($yd['status'] == '0'){				
			$smokeBeansCount = $yd['smokeBeansCount'];
			$this->db->query( "UPDATE zy_racedog_player SET total_gold = ".$smokeBeansCount." WHERE  openid= 'zyracedog20160418'".$this->sql_where);
		}
	}


	
	
		//接口POST
	function curlPost($postUrl , $postArr=array()) {
		$curl = curl_init($postUrl);
		$cookie = dirname(__FILE__).'/cache/cookie.txt';
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);    // https请求 不验证证书和hosts
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT,10); //超时设置 (秒)
		curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie); // ?Cookie
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postArr));
		$result = curl_exec($curl);
		curl_close($curl);
		return $result;
	}
	
	
	function getYD($openid){
		$key = $this->zlkey;
		$data['app_id'] = $this->zlapp_id;
		$data['openid'] = $openid;
		$data['sign'] = md5($data['app_id'].$data['openid'].$key);
		$url = 'http://'. $this->yrurl .'/integral/integralManage!getUserIntegral.action';
		$return = $this->curlPost($url,$data);
		return $return;
		
	}
	
	
	//消耗烟豆
	function consumeYD($smokeBeans, $openid, $desc, $gameid){
				
		$user = $this->getYD($openid);
		$user_obj = json_decode($user,true);	
		$smokeBeansCount = 0;		
		if($user_obj['status'] == '0'){				
				$smokeBeansCount = $user_obj['smokeBeansCount'];
			if($smokeBeansCount < abs($smokeBeans) || $smokeBeansCount == abs($smokeBeans)){// 如果扣除的烟豆数少于剩余的烟豆数就扣完
				$smokeBeans = $smokeBeansCount;  
				if($openid == 'zyracedog20160418'){
					$yd = $this->rechargeDY(500000, $openid, '超级狗庄烟豆不足自动充值', $gameid);
					if($yd['status'] == '0'){				
						$smokeBeansCount = $yd['smokeBeansCount'];
						$this->db->query( "UPDATE zy_racedog_player SET total_gold = ".$smokeBeansCount." WHERE  openid= 'zyracedog20160418' ".$this->sql_where);
					}
				}
			}
		}
		
		
		$key = $this->zlkey;
		$data['orderno'] = 'racedog_'.$this->randomkeys(6). '_' . time(). '_'. $gameid; //流水号
		$data['smokeBeans'] = abs($smokeBeans);
		$data['consumeType'] = '疯狂赛狗';
		$data['desc'] = $desc;;
		$data['app_id'] = $this->zlapp_id;
		$data['openid'] = $openid;
		$data['sign'] = md5($data['app_id'] . $data['orderno'] .$data['openid']. $data['smokeBeans'] .$data['consumeType'] .$data['desc'] .$key);
		$url = 'http://'. $this->yrurl .'/integral/integralManage!consumeIntegral.action';
		$return = $this->curlPost($url,$data);
		
		//存入数据库
		$data_log['addtime'] = time();
		$data_log['desc'] = json_encode($data);
		$data_log['return'] = $return;
		$data_log['gameid'] = $gameid;
		$data_log['browser'] = $_SERVER['HTTP_USER_AGENT'] ? $_SERVER['HTTP_USER_AGENT'] : ''; 
		$data_log['ip'] = ip();
		$data_log['comefrom'] =  $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : ''; 
		$data_log['openid'] =  $openid;
		$data_log['postUrl'] =  $url;
		$data_log['ChannelID'] = $this->ChannelID;
		$data_log['ActiveID'] = $this->ActiveID;
		$data_log['RoomID'] = $this->RoomID;
		$this->db->insert('zy_racedog_recharge_log',$data_log);
		
		return json_decode($return,true);
		
	}
	//充值烟豆
	function rechargeDY($smokeBeans, $openid, $desc, $gameid){
		$key = $this->zlkey;
		$data['orderno'] = 'racedog_'.$this->randomkeys(6). '_' . time(). '_'. $gameid; //流水号
		$data['qrcodeNo'] = '';//二维码的值（没有则为空）
		$data['smokeBeans'] = $smokeBeans;
		$data['smokeBrand'] = '疯狂赛狗';//香烟牌子
		$data['type'] = '疯狂赛狗'; //获取烟豆的途径
		$data['desc'] = $desc;
		$data['app_id'] = $this->zlapp_id;
		$data['openid'] = $openid;
		$data['sign'] = md5($data['app_id'] . $data['qrcodeNo']. $data['orderno'] .$data['openid']. $data['smokeBeans'] .$data['smokeBrand'] .$data['desc'] .$key);
		$url = 'http://'. $this->yrurl .'/integral/integralManage!addIntegral.action';
		$return = $this->curlPost($url,$data);
		
		//存入数据库
		$data_log['addtime'] = time();
		$data_log['desc'] = json_encode($data);
		$data_log['return'] = $return;
		$data_log['gameid'] = $gameid;
		$data_log['browser'] = $_SERVER['HTTP_USER_AGENT'] ? $_SERVER['HTTP_USER_AGENT'] : ''; 
		$data_log['ip'] = ip();
		$data_log['comefrom'] =  $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : ''; 
		$data_log['openid'] =  $openid;
		$data_log['postUrl'] =  $url;
		$data_log['ChannelID'] = $this->ChannelID;
		$data_log['ActiveID'] = $this->ActiveID;
		$data_log['RoomID'] = $this->RoomID;
		$this->db->insert('zy_racedog_recharge_log',$data_log);
		
		return json_decode($return,true);
		
	}
	
	
	function getopenid(){
		
		$state_base64 = base64_encode('http://h5game.gxtianhai.cn/racedog/index.php?c=raceDog&m=by');
		header('Location: https://open.weixin.qq.com/connect/oauth2/authorize?appid='. $this->url_appid .'&redirect_uri=http://'. $this->yrurl .'/thirdInterface/thirdInterface!autoLogin2.action&response_type=code&scope=snsapi_base&state='.$state_base64.'#wechat_redirect');
	
	}
	function getUserInfo(){
		
		$phone_os = $_SERVER['HTTP_USER_AGENT'];
		$is_frist_time = $_REQUEST['is_frist_time'] ? $_REQUEST['is_frist_time'] : 'no';
		$openid = $_REQUEST['openid'];
		$nickname = $_REQUEST['nickName'];
		$headPhoto = $_REQUEST['headPhoto'];
		
		$ChannelID = intval($_REQUEST['CID']);
		$ActiveID = intval($_REQUEST['AID']);
		$RoomID = intval($_REQUEST['RID']);

		$data['ChannelID'] = $ChannelID;
		$data['ActiveID'] = $ActiveID;
		$data['RoomID'] = $RoomID;
		
		/*if (strpos($phone_os, 'MicroMessenger') === false ) {
		// 非微信浏览器禁止浏览
		 $this->load->view('tip', $data);return;
		} else{			
			if (strpos($phone_os, 'Windows Phone') === false ) {
				// 非微信浏览器禁止浏览
				// $this->load->view('tip', $data);return;
			}
			
		}*/
		 
		
		//是否存在游戏设置
		$game_set_start = $this->my_common_model->getRule('start_time',$ChannelID,$ActiveID,$RoomID);
		$game_set_end = $this->my_common_model->getRule('end_time',$ChannelID,$ActiveID,$RoomID);
		$now_time =  strtotime(date('Y-m-d H:i'));	
		$start_time = strtotime( date('Y-m-d 07:30') );
		$end_time = strtotime( date('Y-m-d 23:30') );
		if($game_set_start && $game_set_end){
			$start_time = strtotime( date( 'Y-m-d ' . $game_set_start ) );
			$end_time = strtotime( date( 'Y-m-d '. $game_set_end ) );
		}
		$isStop = 0;
		$res = $this->db->query("SELECT Status FROM zy_game_room WHERE RoomID = {$RoomID}")->row_array();
		if($res['Status'] == '3'){
			$isStop = 1;
		}
		//如果在维护时间内则进入维护页面
		if($now_time < $start_time || $now_time > $end_time || $now_time == $end_time || $isStop == 1 ){
			
			redirect('d=racedog&c=raceDog&m=repaired&ChannelID='.$ChannelID.'&ActiveID='.$ActiveID.'&RoomID='.$RoomID);
			return;
		}else{

			//判断活动、游戏状态
	        $isRun = $this->my_common_model->get_active_game_status($data['ActiveID'],$data['RoomID']);

	        if(!$isRun['status']) {
	            $data['msg'] = $isRun['msg'];
	            $this->load->view('tip', $data);
	            return;
	        }

			$accept = $_REQUEST['accept'];
			$bzxs = $_REQUEST['bzxs'];			
			$filename = 'static/gameroom/racedog/wxheadimg/'. $openid . '.jpg';	
			$session_id = session_id();
			//var_dump($session_id);
			if(!empty($openid ) && $openid != '0000'){
				//$user = $this->getYD($openid);
				$user_obj = array('status'=>0,'smokeBeansCount'=>10000);//json_decode($user,true);			
				if($user_obj['status'] == '0'){
					//更新访问的记录的烟豆
					//$this->db->query("update zy_visit_log set total_gold =".$data['smokeBeansCount']." where id= ".$visit_id."");
					$isexit = $this->db->query("select count(*) as num,nickname,head_img, local_img  from zy_racedog_player where openID='".$openid."' AND ChannelID={$ChannelID} AND ActiveID={$ActiveID} AND RoomID={$RoomID}")->row_array();

									
					$data['openid'] = $openid;
					$data['nickname'] = $nickname;
					
					$data['sex'] = 0;
					$data['smokeBeansCount'] = $user_obj['smokeBeansCount'];
					$data['is_frist_time'] = 'no';
					
					
					if($isexit['num'] > 0){
						if(! file_exists($filename)  || $isexit['head_img'] != $headPhoto  ){
							
							$img_local_url = $this->getImg($headPhoto,$filename );
							$headLocalPhoto =base_url(). $img_local_url;
							$data['headimgurl'] = $headLocalPhoto;
						}else{						
							$data['headimgurl'] = $isexit['local_img'] ? $isexit['local_img'] :  base_url().$filename;
						}
						$update_nickname = "";
						if($isexit['nickname'] != $nickname) $update_nickname = "  nickname='".$nickname."' , ";
						
						$this->db->query("update zy_racedog_player set {$update_nickname} total_gold =".$data['smokeBeansCount']."  , lasttime= ".time()." ,head_img = '" . $headPhoto . "' ,session_id = '" . $session_id . "',phone_os = '" . $phone_os . "' ,local_img = '" . base_url().$filename . "' where openID= '".$openid."' AND ChannelID={$ChannelID} AND ActiveID={$ActiveID} AND RoomID={$RoomID}");//更新烟豆
					}else{
						$data['is_frist_time'] = 'yes';
						$img_local_url = $this->getImg($headPhoto,$filename );
						$headLocalPhoto =base_url(). $img_local_url;
						
						$data['headimgurl'] = $headLocalPhoto;
						
						$user_data['openID'] =  $openid;
						$user_data['nickname'] =  $nickname;
						$user_data['head_img'] =  $headPhoto;
						$user_data['local_img'] =  $headLocalPhoto;
						$user_data['sex'] =  0;
						$user_data['addtime'] =  time();
						$user_data['lasttime'] =  time();
						$user_data['total_gold'] = $data['smokeBeansCount'];
						$user_data['session_id'] = $session_id;	
						$user_data['phone_os'] = $phone_os;
						$user_data['ChannelID'] = $ChannelID;
						$user_data['ActiveID'] = $ActiveID;
						$user_data['RoomID'] = $RoomID;
						$insert_sql = $this->db->insert_string('zy_racedog_player',$user_data);
						$insert_sql = str_replace('INSERT', 'INSERT ignore ', $insert_sql);
						$this->db->query($insert_sql);
					}
					
					
					$_SESSION['openID'] = $data['openid'];
					//$data['gift_score'] = $this->db->query("select * from zy_gift limit 1")->row_array();
					$data['audioSetting'] = $this->db->query("select music_set,effects_set from zy_racedog_player WHERE openID = '{$data['openid']}' AND ChannelID={$ChannelID} AND ActiveID={$ActiveID} AND RoomID={$RoomID} limit 1")->row_array();
					
					/*$today = strtotime(date('Y-m-d 0:0:0'));
			
					$is_set_today = $this->db->query("SELECT count(*) as num FROM zy_online_count WHERE updatetime >  $today")->row_array();
					if(!$is_set_today['num']){
						$base_onlinecount = mt_rand(200,1000);
						$this->db->update('zy_online_count',array('base_onlinecount'=>$base_onlinecount,'updatetime'=>time()));
					}else{
						$now = time();
						$is_half = $this->db->query("SELECT count(*) as num FROM zy_online_count WHERE updatetime < $now-1800 ")->row_array();
						if($is_half['num']){
							$is_add = mt_rand(0,1);
							if($is_add){
								$rand_add = mt_rand(-20,20);
								$this->db->query("UPDATE zy_online_count SET base_onlinecount=base_onlinecount+$rand_add,updatetime=$now");
							}
								
						}
					}*/
	
			
					//$this->load->view('racedog', $data);
				
				 $signPackage = $this-> getSignPackage();
				 $data['signPackage'] = $signPackage;	 	
					
					//改变不再显示状态
				if($bzxs){
					$this->db->query("update zy_racedog_player set readagain = 0 WHERE openID= '".$openid."' AND ChannelID={$ChannelID} AND ActiveID={$ActiveID} AND RoomID={$RoomID}");
				}
				//判断显示规则页面
				if(!$accept){
					$is_view = $this->db->query("SELECT readagain FROM zy_racedog_player WHERE openID = '".$openid."' AND ChannelID={$ChannelID} AND ActiveID={$ActiveID} AND RoomID={$RoomID}")->row_array();
					if($is_view['readagain']){
						$this->load->view("racedog/rule",$data);
						return;
					}
				}
					 $this->db->query("update zy_racedog_player set  session_id = '" . $session_id . "' where openID= '".$openid."' AND ChannelID={$ChannelID} AND ActiveID={$ActiveID} AND RoomID={$RoomID}");//更新烟豆
						
					 $data['is_frist_time'] = $is_frist_time;
					 
					 //添加访问记录
					/*$visit_data['openid'] =  $openid ? $openid : '';
					$visit_data['nickname'] =  $nickname ?  $nickname : '';		
					$visit_data['addtime'] =  time();		
					$visit_data['total_gold'] = $data['smokeBeansCount'];;		
					$visit_data['phone_os'] = $phone_os ? $phone_os : '';
					$visit_data['ip'] =ip();
					$visit_id = $this->db->insert('zy_racedog_visit_log',$visit_data);*/

					//添加游戏访问量
        			$this->my_common_model->add_game_VistNum($RoomID,$ChannelID,$ActiveID,trim($openid));

					 
					//获取该活动自定义资源
			        $Resources_arr = $this->db->query("SELECT VarName,ReSrc FROM zy_gamelist_resources WHERE ChannelID = {$data['ChannelID']} and ActiveID = {$data['ActiveID']} and RoomID = {$data['RoomID']}")->result_array();
			        
			        $Resources = array();
			        foreach ($Resources_arr as $k => $v) {
			            $Resources[$v['VarName']] = str_replace('static/gameroom/racedog/res/Normal', '', $v['ReSrc']);
			        }
			        $data['resources'] = json_encode($Resources);

			        $Active = $this->db->query("SELECT ScoketPort FROM zy_active_main WHERE ActiveID = {$ActiveID}")->row_array();
			        $data['SocketPort'] = $Active['ScoketPort'];
					

					 
					$this->load->view('racedog/racedog', $data);
					
				}else{
					echo $user_obj['errormsg']; 
					var_dump($user);
					
				}
				
			}else{
				echo '获取openid失败！';
			}
		}
	}
	
	function repaired(){
		//$exit_game_set = $this->db->query("select *  from zy_game_set where id=1 ")->row_array();
		$game_set_start = $this->my_common_model->getRule('start_time',$this->ChannelID,$this->ActiveID,$this->RoomID);
		$game_set_end = $this->my_common_model->getRule('end_time',$this->ChannelID,$this->ActiveID,$this->RoomID);
		$repairedtext = $this->my_common_model->getRule('repairedtext',$this->ChannelID,$this->ActiveID,$this->RoomID);

		$isStop = 0;
		$res = $this->db->query("SELECT Status FROM zy_game_room WHERE RoomID = {$this->RoomID}")->row_array();
		if($res['Status'] == '3'){
			$isStop = 1;
		}

		$now_time =  strtotime(date('Y-m-d H:i'));	
		$start_time = strtotime( date( 'Y-m-d ' . $game_set_start ) );
		$end_time = strtotime( date( 'Y-m-d '. $game_set_end ) );
		$data['body_class'] = 'bg_b';
		//如果在维护时间内则进入维护页面
		if($now_time < $start_time || $now_time >= $end_time ){
			$data['text'] = '维护时间:'.$game_set_end . '-' . $game_set_start;
		}else if($isStop == 1) {
			$data['body_class'] = 'bg_a';
			$data['text'] = $repairedtext ? $repairedtext : '请稍后再来';
		}
		$this->load->view('racedog/repaired', $data);
	}
	
	//检查是否在维护中
	function check_repaired(){
		
		$now_time =  strtotime(date('Y-m-d H:i'));	
		$time7 = strtotime( date('Y-m-d 07:30') );
		$time9 = strtotime( date('Y-m-d 09:30') );
		$time11 = strtotime( date('Y-m-d 11:30') );
		$time13 = strtotime( date('Y-m-d 13:30') );
		$time15 = strtotime( date('Y-m-d 15:30') );
		$time17 = strtotime( date('Y-m-d 17:30') );
		$time19 = strtotime( date('Y-m-d 19:30') );
		$time21 = strtotime( date('Y-m-d 21:30') );
		$time23 = strtotime( date('Y-m-d 23:30') );
		
		$is_half = $this->db->query("SELECT count(*) as num FROM zy_racedog_online_count WHERE updatetime < $now_time-180 ".$this->sql_where)->row_array();
		if($is_half['num'] > 0){
			$new_num = mt_rand(20,80);
			if($now_time >= $time9 && $now_time < $time11) $new_num = mt_rand(100,300);
			if($now_time >= $time11 && $now_time < $time13) $new_num = mt_rand(150,400);
			if($now_time >= $time13 && $now_time < $time15) $new_num = mt_rand(50,200);
			if($now_time >= $time15 && $now_time < $time17) $new_num = mt_rand(100,200);
			if($now_time >= $time17 && $now_time < $time19) $new_num = mt_rand(300,500);
			if($now_time >= $time19 && $now_time < $time21) $new_num = mt_rand(100,200);			
			$this->db->query("UPDATE zy_racedog_online_count SET base_onlinecount=$new_num,updatetime=$now_time WHERE 1 ".$this->sql_where);
							
		}
		
		
		//是否存在游戏设置
		/*$exit_game_set = $this->db->query("select *  from zy_game_set where id=1 ")->row_array();
		
		$start_time = strtotime( date('Y-m-d 07:30') );
		$end_time = strtotime( date('Y-m-d 23:30') );
		if($exit_game_set){
			$start_time = strtotime( date( 'Y-m-d ' . $exit_game_set['start_time'] ) );
			$end_time = strtotime( date( 'Y-m-d '. $exit_game_set['end_time'] ) );
		}*/

		$game_set_start = $this->my_common_model->getRule('start_time',$this->ChannelID,$this->ActiveID,$this->RoomID);
		$game_set_end = $this->my_common_model->getRule('end_time',$this->ChannelID,$this->ActiveID,$this->RoomID);
		$now_time =  strtotime(date('Y-m-d H:i'));	
		$start_time = strtotime( date('Y-m-d 07:30') );
		$end_time = strtotime( date('Y-m-d 23:30') );
		if($game_set_start && $game_set_end){
			$start_time = strtotime( date( 'Y-m-d ' . $game_set_start ) );
			$end_time = strtotime( date( 'Y-m-d '. $game_set_end ) );
		}
		$isStop = 0;
		$res = $this->db->query("SELECT Status FROM zy_game_room WHERE RoomID = {$this->RoomID}")->row_array();
		if($res['Status'] == '3'){
			$isStop = 1;
		}
		//如果在维护时间内则进入维护页面或者停止游戏		
		if($now_time < $start_time || $now_time > $end_time || $now_time == $end_time || $isStop == 1 ){
			echo json_encode(array('isStop' =>1));
		}else{
			echo json_encode(array('isStop' =>0));
		}
	}
	
	

	
	function randomkeys($length)
	{
	 $pattern='1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
	 for($i=0;$i<$length;$i++)
	 {
	   $key .= $pattern{mt_rand(0,35)};    //生成php随机数
	 }
	  return strtolower($key);
	}
	
	function test_index(){
		
		//是否存在游戏设置
		$exit_game_set = $this->db->query("select *  from zy_game_set where id=1 ")->row_array();
		$now_time =  strtotime(date('Y-m-d H:i'));	
		$start_time = strtotime( date('Y-m-d 07:30') );
		$end_time = strtotime( date('Y-m-d 23:30') );
		if($exit_game_set){
			$start_time = strtotime( date( 'Y-m-d ' . $exit_game_set['start_time'] ) );
			$end_time = strtotime( date( 'Y-m-d '. $exit_game_set['end_time'] ) );
		}
		//如果在维护时间内则进入维护页面或者停止游戏		
		if($now_time < $start_time || $now_time > $end_time || $now_time == $end_time || $exit_game_set['isStop'] == 1 ){
			 redirect('c=raceDog&m=repaired');
			return;
		}else{
		}
		
		
		
		
		$data = array();
		$my = $_GET['my'];
		if(!empty($my) && isset($my)){
			$headurl = "http://wx.qlogo.cn/mmopen/GQfdS1CPWRJWI6Xu0Rn6mUqL3tICLeRiazbwFtr6pC3E5wxM5hM4Efw2CSo17Ow6ibPVns0otmphxY62BibVuBP4Y3743NEFkVO/0";
			$wx_info = array('openid' => 'woM0Mxs3oVcGxDn9vdeEKnL3HpdSo' . $my, 'nickname' => '测试', 'headimgurl' => $headurl, 'sex' => 1);
		}else{
				$wx_info = $this->get_wx_info();
		}
		
		// echo $_SERVER['HTTP_USER_AGENT'];
		
		$filename = 'static/wxheadimg/'.$wx_info['openid'] . '.jpg';	
		//if(file_exists($filename)){var_dump('sss');}
		//$filename = 'static/wxheadimg/'. $wx_info['openid'] . '.jpg';		
				
				$img_local_url = $this->getImg($wx_info['headimgurl'],$filename );
				$headPhoto =base_url(). $img_local_url;
					
	
		
	  
		
		$data['openid'] = $wx_info['openid'];
		$data['nickname'] = $wx_info['nickname'];
		$data['headimgurl'] = base_url(). $img_local_url ;//$wx_info['headimgurl'];
		$data['smokeBeansCount'] = 10000;
		$data['sex'] = $wx_info['sex'];
		$data['is_frist_time'] = 'no';
		if($data['openid'] == ''){
			$this->get_code();return;
		}
		$_SESSION['openid'] = $data['openid'];
		$data['gift_score'] = $this->db->query("select * from zy_gift limit 1")->row_array();
		$data['audioSetting'] = $this->db->query("select music_set,effects_set from zy_player WHERE openid = '{$data['openid']}' limit 1")->row_array();
		
		$today = strtotime(date('Y-m-d 0:0:0'));
		
		$is_set_today = $this->db->query("SELECT count(*) as num FROM zy_online_count WHERE updatetime >  $today")->row_array();
		if(!$is_set_today['num']){
			$base_onlinecount = mt_rand(200,1000);
			$this->db->update('zy_online_count',array('base_onlinecount'=>$base_onlinecount,'updatetime'=>time()));
		}else{
			$now = time();
			$is_half = $this->db->query("SELECT count(*) as num FROM zy_online_count WHERE updatetime < $now-1800 ")->row_array();
			if($is_half['num']){
				$is_add = mt_rand(0,1);
				if($is_add){
					$rand_add = mt_rand(-20,20);
					$this->db->query("UPDATE zy_online_count SET base_onlinecount=base_onlinecount+$rand_add,updatetime=$now");
				}
					
			}
		}
		$this->db->query("update zy_player set session_id = '" . session_id() . "' where openID= '".$data['openid']."' ");//更新烟豆
		
		
		
		
		$data['self'] = $this;
        $this->load->view('racedog', $data);
	}
	
	function findYD(){
		$key = $this->zlkey;
		$data['app_id'] = $this->zlapp_id;
		$data['openid'] = $openid;
		$data['sign'] = md5($data['app_id'].$data['openid'].$key);
		$url = 'http://'. $this->yrurl .'/integral/integralManage!getUserIntegral.action';
		$return = $this->curlPost($url,$data);
		echo $return;
		
	}
	
	function check_seesion_id($openid){
		$isexit = $this->db->query("select session_id  from zy_racedog_player where openID='".$openid."' {$this->sql_where}")->row_array();
		if($isexit && $isexit['session_id'] == $_COOKIE['PHPSESSID']){
			return true;
		}else{
			return false;
		}
	}
	
	//检查session_id和$_COOKIE['PHPSESSID'] 是否一致
	function check_id(){
		$openid = $_POST['openid'];
		if(empty($openid)) {
			 echo json_encode(array('status' => -1)) ;
			 exit;
		}
		//判断是否有session
		$isexit = $this->db->query("select session_id,openID  from zy_racedog_player where openID='".$openid."' ".$this->sql_where)->row_array();
		if(!$isexit){
			echo json_encode(array('status' => -1)) ;
			 exit;
		}
		if($isexit['session_id'] != $_COOKIE['PHPSESSID']){
			 $this->db->query("update zy_racedog_player set session_id = '" . $_COOKIE['PHPSESSID'] . "' where openID= '".$openid ."' ".$this->sql_where);//更新烟豆
		
			// echo json_encode(array('status' => -2, 'openID' => $isexit['openID'], 'head_img' => $isexit['head_img'], 'nickname' => $isexit['nickname'])) ;
			 exit;
		}
		echo json_encode(array('status' => 0)) ;
	}
	
	
	function img(){
			$headurl = "http://wx.qlogo.cn/mmopen/GQfdS1CPWRJWI6Xu0Rn6mUqL3tICLeRiazbwFtr6pC3E5wxM5hM4Efw2CSo17Ow6ibPVns0otmphxY62BibVuBP4Y3743NEFkVO/0";
		    $openid = 'abc';
			$filename = 'static/wxheadimg/'.$openid . '.jpg';		
			
			 	$img_local_url = $this->getImg($headurl,$filename);
			
			echo  $imgurl;
	}
	
	function savrImg($url,$filename){
		if($url=='' || $url=='0000') return false;		
		ob_start();
		readfile($url);
		$img = ob_get_contents();
		ob_end_clean();
		$size = strlen($img);
		$fp2=@fopen($filename, 'a');
		fwrite($fp2,$img);
		fclose($fp2);
		$this->thumb($filename,66,66);
		return $filename;
		
	}
	
	/**
	 * 生成缩略图函数  剪切
	 *
	 * @param $imgurl 图片路径            
	 * @param $width 缩略图宽度            
	 * @param $height 缩略图高度            
	 * @return string 生成图片的路径 类似：./uploads/201203/img_100_80.jpg
	 */
	function thumb ($imgurl, $width = 100, $height = 100)
	{
		if (empty($imgurl))
			return '不能为空';
	
		include_once 'application/libraries/image_moo.php';
		$moo = new Image_moo();
		$moo->load($imgurl);
		$moo->resize_crop($width, $height);
		$moo->save_pa('','',true);    
	}
	
	
			/*
		*@通过curl方式获取指定的图片到本地
		*@ 完整的图片地址
		*@ 要存储的文件名
		*/
		function getImg($url = "", $filename = "")
		{
			   //去除URL连接上面可能的引号
				//$url = preg_replace( '/(?:^['"]+|['"/]+$)/', '', $url );
				$hander = curl_init();
				$fp = fopen($filename,'wb');
				curl_setopt($hander,CURLOPT_URL,$url);
				curl_setopt($hander,CURLOPT_FILE,$fp);
				curl_setopt($hander,CURLOPT_HEADER,0);
				curl_setopt($hander,CURLOPT_FOLLOWLOCATION,1);
				//curl_setopt($hander,CURLOPT_RETURNTRANSFER,false);//以数据流的方式返回数据,当为false是直接显示出来
				curl_setopt($hander,CURLOPT_TIMEOUT,60);
				curl_exec($hander);
				curl_close($hander);
				fclose($fp);
				$this->thumb($filename,66,66);
				return $filename;
		}
		
		function by(){
			
		$openid = $_REQUEST['openid'];
		$nickname = $_REQUEST['nickName'];
		$headPhoto = $_REQUEST['headPhoto'];
		$ChannelID = 
		$filename = 'static/gameroom/racedog/wxheadimg/'. $openid . '.jpg';	
		
		$session_id = session_id();
		if(!empty($openid ) && $openid != '0000'){
			//$user = $this->getYD($openid);
			$user_obj = array('status'=>0,'smokeBeansCount'=>10000);//json_decode($user,true);			
			if($user_obj['status'] == '0'){
				$isexit = $this->db->query("select count(*) as num,head_img, local_img  from zy_racedog_player where openid='".$openid."' ")->row_array();
								
				$data['openid'] = $openid;
				$data['nickname'] = $nickname;
				
				$data['sex'] = 0;
				$data['smokeBeansCount'] = $user_obj['smokeBeansCount'];
				$data['is_frist_time'] = 'no';
				
				
				if($isexit['num'] > 0){
					if(! file_exists($filename)  || $isexit['head_img'] != $headPhoto  ){
						
						$img_local_url = $this->getImg($headPhoto,$filename );
						$headLocalPhoto =base_url(). $img_local_url;
						$data['headimgurl'] = $headLocalPhoto;
					}else{						
						$data['headimgurl'] = $isexit['local_img'] ? $isexit['local_img'] :  base_url().$filename;
					}
					
					
					
					$this->db->query("update zy_racedog_player set total_gold =".$data['smokeBeansCount']."  , lasttime= ".time()." ,head_img = '" . $headPhoto . "' ,session_id = '" . $session_id . "' ,local_img = '" . base_url().$filename . "' where openID= '".$openid."' ");//更新烟豆
				}else{
					$data['is_frist_time'] = 'yes';
					$img_local_url = $this->getImg($headPhoto,$filename );
					$headLocalPhoto =base_url(). $img_local_url;
					
					$data['headimgurl'] = $headLocalPhoto;
					
					$user_data['openID'] =  $openid;
					$user_data['nickname'] =  $nickname;
					$user_data['head_img'] =  $headPhoto;
					$user_data['local_img'] =  $headLocalPhoto;
					$user_data['sex'] =  0;
					$user_data['addtime'] =  time();
					$user_data['lasttime'] =  time();
					$user_data['total_gold'] = $data['smokeBeansCount'];
					$user_data['session_id'] = $session_id;	
					$this->db->insert('zy_racedog_player',$user_data);
					
				}
				
				
				$_SESSION['openid'] = $data['openid'];
				//$data['gift_score'] = $this->db->query("select * from zy_racedog_gift limit 1")->row_array();
				$data['audioSetting'] = $this->db->query("select music_set,effects_set from zy_racedog_player WHERE openid = '{$data['openid']}' limit 1")->row_array();

				$signPackage = $this-> getSignPackage();
				$data['signPackage'] = $signPackage;	
		
				 $this->load->view('racedog/racedog', $data);
				
			}else{
				echo $user_obj['errormsg']; 
				var_dump($user);
				
			}
			
		}else{
			echo '获取openid失败！';
		}
       
	}
	//$numbers ,$gameid
	function get_ranking($numbers ,$gameid){
		
		/*$numbers = array(2,4,3,1,5);
		$numbers = range(1,5);
		srand((float)microtime()*1000000);
		shuffle($numbers);
		var_dump($numbers);
		
		$yandou_dog2 = 0;
		$yandou_dog3 = 0;
		$yandou_dog4 = 0;
		$yandou_dog5 = 0;
		$gameid = 3395;*/
		$yandou_sql = "SELECT SUM(gold) AS gold_sum,dog FROM zy_racedog_bet_on WHERE  gameid=$gameid  GROUP BY dog ";
        $query = $this->db->query( $yandou_sql );
        $result_yandou = $query->result_array(); 
		foreach($result_yandou as $val){
			${'yandou_dog'.$val['dog']} = $val['gold_sum'] ? $val['gold_sum'] : 0;
		}
		
		
		$rule_sql = "select * FROM zy_racedog_game_rule where status = 1 {$this->sql_where} ORDER BY dog,yandou DESC ";
        $query = $this->db->query( $rule_sql );
        $result = $query->result_array();  
		//随机打乱狗狗的顺序
		$dogs = array(2,3,4,5);
		srand((float)microtime()*1000000);
		shuffle($dogs);
		
		
		$dog_0 = true;
		$dog_1 = true;
		$dog_2 = true;
		$dog_3  = true;
		
		foreach($result as $val){
			
			foreach($dogs as $k=>$dog){
				if($val['dog'] == $dogs[$k] && ${'yandou_dog'.$dogs[$k]} > $val['yandou'] && ${'dog_'.$k}){				
					${'dog_'.$k} = false;
					$dog_new_rank = array();
					$gailv = intval($val['gailv']);
					$proArr = array($gailv ,100 - $gailv);//概率，第一个参数是当前狗狗的概率，第二个是1号狗的概率
					$result = $this->get_rand($proArr);//返回赢的狗狗，0表示当前狗狗赢，1表示1号狗
					$result == '0' ? $dog_new_rank = array(intval($val['dog']),1) : $dog_new_rank = array(1,intval($val['dog']));
				//	var_dump($result . ' - ' . $dogs[$k]);
					$dog1 = array_search('1',$numbers);//1号狗的排名位置
					$dogx = array_search($val['dog'],$numbers);//当前狗狗的排名位置
					//按照概率如果算出当前狗狗的排名赢了1号狗，但是随机排名时当前狗狗的排名大于1号狗，那就把当前狗狗的排名排在1号狗前面
					if($result == '0' && $dogx > $dog1 ){
						array_splice($numbers, $dogx, 1); //删除当前狗狗位置
						$dog1 = array_search('1',$numbers);//重新获取1号狗的排名位置
						array_splice($numbers,$dog1,1,$dog_new_rank); //把1号狗的位置替换成新的，如1,2或2,1
						
					}
					//按照概率如果算出当前狗狗的排名输了1号狗，但是随机排名时1号狗狗的排名大于当前狗狗，那就把当前狗狗的排名排在1号狗后面
					if($result == '1' && $dog1 > $dogx ){
						array_splice($numbers, $dogx, 1); //删除当前狗狗位置
						$dog1 = array_search('1',$numbers);//重新获取1号狗的排名位置
						array_splice($numbers,$dog1,1,$dog_new_rank); //把1号狗的位置替换成新的，如1,2或2,1
					}		
					
				}
			}
			
			
			
			
			
			
		}
		
		return  $numbers;
		
	}
	
	function get_rand($proArr) { 
		  $result = ''; 
		  
		  //概率数组的总概率精度 
		  $proSum = array_sum($proArr); 
		  
		  //概率数组循环 
		  foreach ($proArr as $key => $proCur) { 
				$randNum = mt_rand(1, $proSum); 
				if ($randNum <= $proCur) { 
				  $result = $key; 
				  break; 
				} else { 
				  $proSum -= $proCur; 
				} 
		  } 
		  unset ($proArr); 		  
		  return $result; 
	} 
	
	function getRank(){//获取后台排名
		$cur_game_id = $this->get_game_id();
		$result = $this->db->query("SELECT ranking FROM zy_racedog_game WHERE id = $cur_game_id")->row_array();
		

		$ranking['rank'] = string2array($result['ranking']);

		echo json_encode($ranking);
	}


	
	
	
	function insert_xlb(){
		$rule_sql = 'select * FROM `pigcms_wechat_group_list`  WHERE LENGTH( TRIM(nickname) ) > 12 ORDER BY id LIMIT 0, 1000 ';
        $query = $this->db->query( $rule_sql );
        $result = $query->result_array();  
		
		
		foreach($result as $val){
			if( empty($val['nickname']) )  continue;
			$user_data['addtime'] =  time();
			$user_data['content'] = '恭喜玩家['. $val['nickname'] . ']赢得' . mt_rand(1000,10000) . '烟豆！';
			$user_data['status'] = 0;	
			$this->db->insert('zy_xlb',$user_data);
		}
	
	}
	
	
	function get_fans(){
		$access_token_910 = 'AJTbwk6kh5gmnvCGn0h5FZKkLaueOhOd9vUgAOTK4-ZSevxe4yOyY3k-ijK4EjuzItwDYACBpbu3Bss3HwlmVpFnAxo4rp2a9eKm3XVjQaSTXQtUxHP2qV0lh1qQjHjrHBClCCAYST';
		$access_token_930 = 'uBrRD1JK9PmOD6yLneERkTe8P2z2OhoT8e6-nOYkOaO9EsBdpsn89CbLdDxitLO4jawkn3Wqg8ShI4_QKfpa_DT-ENzoFYw8ccmVG366PoElZIo-ptHJvRImIiXsjbZ6KEQjCFAUOA';
		
		$url = 'https://api.weixin.qq.com/datacube/getusercumulate?access_token='.$access_token_930;
		$data['begin_date'] = '2016-06-07';
		$data['end_date'] = '2016-06-07';
		$re = $this->https_request($url ,json_encode($data));
		print_r($re['list'][0]['cumulate_user']);
	}
	/**
     * 模拟POST提交数据
     * @param string $url 链接地址
     * @param array $data 数组
     */
    public function https_request($url,$data = null){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return json_decode($output,true);
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
	

}


?>
