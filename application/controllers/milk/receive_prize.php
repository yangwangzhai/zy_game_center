<?php if (! defined('BASEPATH'))  exit('No direct script access allowed');
//  

class receive_prize extends CI_Controller
{
	//private $appId = 'wxaa13dc461510723a';//真龙
   // private $appSecret = '0fd561ea6d2bce6410805f50c041d65a';//真龙
	
	private $appId = 'wx309d71544a02bd4a';//紫云
    private $appSecret = 'b8d778616059287d3854c8ef433d97c2';//紫云
	
	public $ActiveID = 0;
	public $ChannelID = 0;
	public $RoomID = 0;
	function __construct ()
    {    
        parent::__construct();
		$this->ActiveID = $this->input->get('ActiveID');
		$this->ChannelID = $this->input->get('ChannelID');
		$this->RoomID = $this->input->get('RoomID');
		
	}
    public function index () {	
		$ActiveID = $this->input->get('ActiveID');
		$ChannelID = $this->input->get('ChannelID');
		$RoomID = $this->input->get('RoomID');
		$data['openid'] = $_REQUEST['openid'];
		$data['game_sign'] = "&ActiveID=$this->ActiveID&ChannelID=$this->ChannelID&RoomID=$this->RoomID";
		if($ActiveID && $ChannelID && $RoomID & !$data['openid']){
			$state_base64 = base64_encode('http://h5game.gxtianhai.cn/gamecenter/index.php?d=milk&c=receive_prize&m=index&ChannelID='.$this->ChannelID.'&ActiveID='.$this->ActiveID.'&RoomID='.$this->RoomID);
        	$this->load->model('ChannelApi_model');
        	$apiUrl = $this->ChannelApi_model->getApi($this->ChannelID,'GetUserInfo');
        	$temp = sprintf($apiUrl,$state_base64);
			if(empty($temp)) show_msg('渠道接口获取失败ChannelID：'.$this->ChannelID.'！');
        	header("Location: ".$temp);

 			return;
		}else{
			//show_msg('非法访问！');
			//exit;
		}		
		    
	    if($data['openid'] == ''){
	        $state_base64 = base64_encode('http://h5game.gxtianhai.cn/gamecenter/index.php?d=milk&c=receive_prize&m=index&ChannelID='.$this->ChannelID.'&ActiveID='.$this->ActiveID.'&RoomID='.$this->RoomID);
        	$this->load->model('ChannelApi_model');
        	$apiUrl = $this->ChannelApi_model->getApi($this->ChannelID,'GetUserInfo');
        	$temp = sprintf($apiUrl,$state_base64);
			if(empty($temp)) show_msg('渠道接口获取失败ChannelID：'.$this->ChannelID.'！');
        	header("Location: ".$temp);

 			return;
	    }
		$has_win = false;//未中奖
	//	$data['tip'] = '请填写您的收货地址';
		$game_sign_sql = " AND ActiveID=$this->ActiveID AND ChannelID=$this->ChannelID AND RoomID=$this->RoomID";		
		$query = $this->db->query("SELECT * FROM zy_milk_attend_user  where openID ='{$data['openid']}' AND is_winning!=0 $game_sign_sql ");
        $row = $query->row_array();		
		
		if($row){			
			$data['address'] = $row['address'] ;
			$data['name'] = $row['name'] ;
			$data['tel'] = $row['tel'] ;
			
			$data['prov'] = $row['prov'];
			$data['city'] = $row['city'];
			$data['dist'] = $row['dist'];
			$data['code'] = $row['code'];
			$data['received'] = $row['received'];
			$txt = array('','一','二','三');
			$jp = array('','10','5','1');
			$data['tip'] = '<p>恭喜您获得了：<strong>'.$txt[$row['is_winning']].'等奖</strong></p><p>奖品为：'.$jp[$row['is_winning']].'件摩拉菲尔·清养水牛纯牛奶</p>';	
			if($data['address']){
				
			}else{
			//	$data['tip'] = '恭喜您，您得了'.$txt[$row['is_winning']].'等奖<br>请填写您的联系信息';	
			}
			$has_win = true;
			
		}	
		if($has_win == false){	
		//	echo '活动还未结束，无法领奖!';	
		//	exit;						
			redirect('d=milk&c=milk_fight'.$data['game_sign']);
			return;
		}
		
        $this->load->view('milk/save_address_view', $data);
    } 
	
	
	function save_address(){
		$comefrom = $_SERVER['HTTP_REFERER'];
		$milk_url = base_url('index.php?d=milk&c=receive_prize');
		if( empty($comefrom) || !strstr($comefrom,$milk_url)){
		//	header('location: index.php?c=milk_fight');	
			echo -1;			
			exit();
		}
		$data['address'] = $_POST['address'];
		$data['name'] = $_POST['name'];
		$data['tel'] = $_POST['tel'];
		$data['prov'] = $_POST['prov'];
		$data['city'] = $_POST['city'];
		$data['dist'] = $_POST['dist'];
		$data['code'] = $_POST['code'];
		$data['received'] = $_POST['received'];
		
		$openid = $_POST['openid'];
		if($openid){
			$where = array('openID' => $openid, 'ActiveID' => $this->ActiveID, 'ChannelID' => $this->ChannelID, 'RoomID' => $this->RoomID);
			$this->db->update('zy_milk_attend_user',$data, $where);
			echo 0;
		}else{
			echo 1;
		}
		
	}
	
	
	
}




?>
