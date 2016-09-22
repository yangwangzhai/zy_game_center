<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 管理员  控制器 by tangjian 

include 'content.php';

class Active extends Content
{
    function __construct ()
    {    
        parent::__construct();
            
        $this->control = 'active';
        $this->baseurl = 'index.php?d=admin&c=active';
        $this->table = 'zy_active_main';
        $this->list_view = 'active_list';
        $this->add_view = 'active_add';
		$this->load->model('content_model'); 
     	$this->content_model->set_table( $this->table );
    }
    


    public function index(){			
		$keywords = trim($_REQUEST['keywords']);
		//只显示可管理的渠道的活动
		$UID= $this->session->userdata('UID');
		$user = $this->my_common_model->get_user($UID);
		$can_channels = $user['CanChannel'];
		if($can_channels){	
			$searchsql = ' ChannelID IN('. $can_channels .') ';
		}else{
			 $searchsql = '1';
		}
        
		if ($_SESSION['GroupID'] != 1){
			 $searchsql .= ' AND Status !=3 ';			
		}
		
		$status = array('未开始', '<font  color="green">进行中</font>' , '<font color="#FF0000">已结束</font>','<b>试玩</b>');
		 // 是否是查询
        if (empty($keywords)) {
            $config['base_url'] = $this->baseurl . "&m=index";
        } else {
            $searchsql .= " AND (ActiveName like '%{$keywords}%' OR Remark like '%{$keywords}%')";
            $config['base_url'] = $this->baseurl ."&m=index&keywords=" . rawurlencode($keywords);
        }
		$data['count'] = $this->content_model->get_count($searchsql);
		$config['total_rows'] = $data['count'] ;
        $config['per_page'] = $this->per_page;
        $this->load->library('pagination');
        $this->pagination->initialize($config);
        $data['pages'] = $this->pagination->create_links();
        $offset = $_GET['per_page'] ? intval($_GET['per_page']) : 0;
        $per_page = $config['per_page'];
		$result = $this->content_model->get_list('*', $searchsql, 'ActiveID DESC',  $offset);	
		foreach($result as $key=>$val){
			$room_row = $this->my_common_model->get_room_list($val['RoomID']);
			$channel_row = $this->my_common_model->get_channel_list($val['ChannelID']);			
			$user_row = $this->my_common_model->get_user($val['UID']);     
			$nav_arr = $this->my_common_model->get_nav_by_roomid($val['RoomID']); 
			
			
			$result[$key]['ChannelName'] = $channel_row['ChannelName'];
			$result[$key]['GameName'] = $room_row['GameName'];
			$result[$key]['UserName'] = $user_row['Username'];
			$result[$key]['Status'] = $status[$val['Status']];
			$result[$key]['navs_arr'] = $nav_arr;
			
		}
		
		
		//var_dump($result);
        $data['list'] = $result;		
        $_SESSION['url_forward'] =  $config['base_url']. "&per_page=$offset";
        $this->load->view('admin/' . $this->list_view, $data);
    }
	
	
	function add(){
		
		$UID= $this->session->userdata('UID');
		$user = $this->my_common_model->get_user($UID);
		$can_channels = $user['CanChannel'];
		
		if($can_channels){
			$data['channel_list'] = $this->my_common_model->get_channel_list();
			$can_channels_arr = explode(',', $can_channels);
			foreach($data['channel_list'] as $key=>$val){
				if(!in_array($val['ChannelID'], $can_channels_arr)) unset($data['channel_list'][$key]);
			}
		}else{
			$data['channel_list'] = array();
		}
		$data['room_list'] = $this->my_common_model->get_room_list();       
        $this->load->view('admin/' . $this->add_view, $data);
	}
	
	function edit(){
		$id = intval($_GET['id']);
		$data['ActiveID'] = $id;
		$data['value'] = $this->content_model->get_one($id, 'ActiveID');		
		$data['room_list'] = $this->my_common_model->get_room_list();  
		$UID= $this->session->userdata('UID');
		$user = $this->my_common_model->get_user($UID);
		$can_channels = $user['CanChannel'];
		
		if($can_channels){
			$data['channel_list'] = $this->my_common_model->get_channel_list();
			$can_channels_arr = explode(',', $can_channels);
			foreach($data['channel_list'] as $key=>$val){
				if(!in_array($val['ChannelID'], $can_channels_arr)) unset($data['channel_list'][$key]);
			}
		}else{
			$data['channel_list'] = array();
		}
		$this->load->view('admin/' . $this->add_view, $data);
	}
	
	function select_game(){
		$gameID = $_GET['gameID'];
		if($gameID){
			$query = $this->db->get_where('zy_game_room', array('RoomID' => $gameID),1);
			$result = $query->result_array();
			$data['list'] = $result;
			$this->load->view('admin/select_game', $data);
		}
	}
	
	function save(){
		$ActiveID = intval($_POST['ActiveID']);
        $data = trims($_POST['value']);
        
        if ($data['ActiveName'] == "") {
             show_msg('活动名称不能为空');
        }  
		if ($data['ChannelID'] == "0") {
             show_msg('请选择渠道');
        }  
		if ($data['RoomID'] == "0") {
             show_msg('请选择游戏');
        }     
		
		
	
		
		
		   
        if ($ActiveID) { // 修改 ===========
			//如果是赛狗游戏并且状态改为结束
			if($row['RoomID'] == 3 && $data['Status'] == 2){
					$crond_filename = '/phpstudy/nodeServer/shell/racedog_start_crond.sh';//换行，linux使用"\n"就可以，windows"\r\n".
					$crond_content = file_get_contents($crond_filename);
					$crond_content = str_replace("/phpstudy/nodeServer/shell/racedog_start.sh ".$data['ScoketPort'],"/phpstudy/nodeServer/shell/racedog_stop.sh ".$data['ScoketPort'], $crond_content);
					
					file_put_contents($crond_filename, $crond_content); 
			}
			
			if($data['updateUI'] == 1){
				//删除资源列表
				$query = $this->db->query ( "delete from zy_gamelist_resources where ActiveID=$ActiveID AND IsBase=0" );
				$this->copyGameResources($_POST['RoomID'],$_POST['ChannelID'],$ActiveID,$data['GameID']);
				
			}	
			if($data['updateRule'] == 1){
				//删除规则列表
				$query = $this->db->query ( "delete from zy_gamelist_rule where ActiveID=$ActiveID AND IsBase=0" );				
				//复制规则、资源数据
				$this->copyGameRule($_POST['RoomID'],$_POST['ChannelID'],$ActiveID,$data['GameID']);				
			}			
			
			unset($data['updateUI']);
			unset($data['updateRule']);
			unset($data['ChannelID']);
			unset($data['RoomID']);
            $this->db->where('ActiveID', $ActiveID);
			$data['Uptime'] = time();
			$data['UID'] = $this->session->userdata('UID');
            $query = $this->db->update($this->table, $data);
            show_msg('修改成功！', $_SESSION['url_forward']);
        } else { // ===========添加 ===========
			 unset($data['updateUI']);
			 unset($data['updateRule']);
			 if(!empty($data['ScoketPort'])){
				$row = $this->content_model->get_one($ActiveID, 'ActiveID');			 
				//$filename = 'scoketscript/racedog_index_def.js';
				$filename = '/phpstudy/nodeServer/racedog_index_def.js';
				if (! file_exists($filename)) {	
					 show_msg('scoket文件不存在！', $return_url);
				}else{
					if (is_writable($filename)) {
						//$new_filename = 'scoketscript/racedog_index_'. $data['ScoketPort'] . '.js';
						$new_filename = '/phpstudy/nodeServer/racedog_index_'. $data['ScoketPort'] . '.js';
						if(!@copy($filename, $new_filename)){
						  show_msg('复制scoket文件失败！', $return_url);
						}
						$content = file_get_contents($new_filename);
						$content = str_replace('ChannelID=0','ChannelID='.$row['ChannelID'], $content);
						$content = str_replace('ActiveID=0','ActiveID='.$ActiveID, $content);
						$content = str_replace('RoomID=0','RoomID='.$row['RoomID'], $content);
						$content = str_replace('3000',$data['ScoketPort'], $content);
						file_put_contents($new_filename, $content); 
						
						$crond_filename = '/phpstudy/nodeServer/shell/racedog_start_crond.sh';//换行，linux使用"\n"就可以，windows"\r\n".
						$crond_content = file_get_contents($crond_filename);
						$crond_content .= "\n"."/phpstudy/nodeServer/shell/racedog_start.sh ".$data['ScoketPort'];
						file_put_contents($crond_filename, $crond_content); 
						
					} else {
					  show_msg('scoket文件不可写！', $return_url);
					}
				}
			}
		
            $data['Uptime'] = time();
			$data['UID'] = $this->session->userdata('UID');
            $query = $this->db->insert($this->table, $data);
			$new_id = $this->db->insert_id();
			if($new_id){
				//往活动-游戏表里添加一条记录
				$a_g_data['ChannelID'] = $data['ChannelID'];
				$a_g_data['ActiveID'] = $new_id;
				$a_g_data['RoomID'] = $data['RoomID'];
				$this->db->insert('zy_active_game', $a_g_data);
				$new_a_g_id = $this->db->insert_id();
				//把活动-游戏表里的自增GameID更新到活动主表
				$this->db->where('ActiveID', $new_id);
				$query = $this->db->update($this->table, array('GameID' => $new_a_g_id));
				
				//往游戏_更多相关表添加一条记录
				$g_m_data['ChannelID'] = $data['ChannelID'];
				$g_m_data['ActiveID'] = $new_id;
				$g_m_data['GameID'] = $new_a_g_id;
				$this->db->insert('zy_gamelist_more', $g_m_data);

				//复制规则、资源数据
				$this->copyGameRule($data['RoomID'],$data['ChannelID'],$new_id,$new_a_g_id);
				$this->copyGameResources($data['RoomID'],$data['ChannelID'],$new_id,$new_a_g_id);

				
			}
            show_msg('添加成功！', $_SESSION['url_forward']);
        }
	}
	
	 // 删除
    public function delete ()
    {
        $id = $_GET['id'] ? $_GET['id'] : $_POST['delete'];
		if(empty($id))     show_msg('请选择要删除的数据！', $_SESSION['url_forward']);  
		$row = $this->content_model->delete($id, 'ActiveID');   
        if ($row) {
            show_msg('删除成功！', $_SESSION['url_forward']);
        } else {
            show_msg('删除失败！', $_SESSION['url_forward']);
        }		
        
    }

    //复制游戏规则数据
    public function copyGameRule($RoomID,$ChannelID,$ActiveID,$GameID){
    	if(!$RoomID || !$ChannelID || !$ActiveID || !$GameID){
    		return false;
    	}
    	$UID = $this->session->userdata('UID');
    	$time = time();

    	$this->db->query("INSERT INTO `zy_gamelist_rule` (`RoomID`, `RuleName`, `RuleSign`, `RuleSet`, `ChannelID`, `ActiveID`, `GameID`, `UID`, `UpdateTime`, `IsBase`) SELECT RoomID, RuleName, RuleSign, RuleSet, $ChannelID, $ActiveID, $GameID, $UID, $time, 0 FROM `zy_gamelist_rule` WHERE RoomID = $RoomID AND isBase = 1");
    }

    //复制游戏资源数据
    public function copyGameResources($RoomID,$ChannelID,$ActiveID,$GameID){
    	if(!$RoomID || !$ChannelID || !$ActiveID || !$GameID){
    		return false;
    	}
    	$UID = $this->session->userdata('UID');
    	$time = time();

    	$this->db->query("INSERT INTO `zy_gamelist_resources` (`RoomID`, `ReName`, `VarName`, `ReSrc`, `ReType`, `ReSize`, `ChannelID`, `ActiveID`, `GameID`, `UID`, `UpdateTime`, `IsBase`) SELECT RoomID, `ReName`, VarName, ReSrc, ReType, ReSize, $ChannelID, $ActiveID, $GameID, $UID, $time, 0 FROM `zy_gamelist_resources` WHERE RoomID = $RoomID AND isBase = 1");
    }
	
	//判断端口是否占有
	function checkport(){
		
		$row_active_info = $this->db->query("SELECT max(ScoketPort) as port FROM zy_active_main ")->row_array();
		$max_port = $row_active_info['port'];
		if($max_port == ''){
			$max_port = 3001;
		}else{
			$max_port ++;
		}
		echo $max_port;
	}


}
