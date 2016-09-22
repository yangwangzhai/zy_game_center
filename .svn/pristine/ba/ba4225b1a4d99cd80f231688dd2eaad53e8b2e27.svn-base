<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 管理员  控制器 by tangjian 

include 'content.php';

class Black extends Content
{
    function __construct ()
    {    
        parent::__construct();
            
        $this->control = 'admin';
        $this->baseurl = 'index.php?d=admin&c=black';
        $this->table = 'zy_active_blacklist';
        $this->list_view = 'black_list';        
		$this->load->model('content_model'); 
     	$this->content_model->set_table( $this->table );
    }
    


    public function index(){			
		$keywords = trim($_REQUEST['keywords']);
		//只显示可管理的渠道的
		$UID= $this->session->userdata('UID');
		$user = $this->my_common_model->get_user($UID);
		$can_channels = $user['CanChannel'];
		if($can_channels){	
			$searchsql = ' ChannelID IN('. $can_channels .') ';
		}else{
			 $searchsql = '1';
		}
    //    $searchsql = '1';		
		 // 是否是查询
        if (empty($keywords)) {
            $config['base_url'] = $this->baseurl . "&m=index";
        } else {
            $searchsql .= " AND (Openid like '%{$keywords}%' OR Nickname like '%{$keywords}%' OR Remark like '%{$keywords}%')";
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
		$result = $this->content_model->get_list('*', $searchsql, 'ActiveBlackID DESC',  $offset);	
		foreach($result as $key=>$val){			
			$channel_row = $this->my_common_model->get_channel_list($val['ChannelID']);
			$active_row = $this->my_common_model->get_active_list($val['ActiveID']);  
			$room_row = $this->my_common_model->get_room_list($val['RoomID']); 
			$add_user_row = $this->my_common_model->get_user($val['AddUid']);
			$release_user_row = $this->my_common_model->get_user($val['ReleaseUid']);	
			
			$result[$key]['ChannelName'] = $channel_row['ChannelName'];
			$result[$key]['ActiveName'] = $active_row['ActiveName'];
			$result[$key]['GameName'] = $room_row['GameName'];
			$result[$key]['AddUName'] = $add_user_row['Username'];			
			$result[$key]['ReleaseText'] = '[' .$release_user_row['Username']. '] => ' . date('Y-m-d H:i:s',$val['ReleaseTime']);
			if( empty($val['ReleaseTime']) ) $result[$key]['ReleaseText'] = '<font color="#FF0000">未解禁</font>';
		
		}
        $data['list'] = $result;
			 
        $_SESSION['url_forward'] =  $config['base_url']. "&per_page=$offset";
        $this->load->view('admin/' . $this->list_view, $data);
    }

    public function dialog(){
        $data['ActiveID'] = $_GET['ActiveID'];
        $data['openid'] = $_GET['openid'];
        $data['nickname'] = $_GET['nickname'];

        $this->load->view('admin/black_dialog',$data);

    }

    public function add(){
        $ActiveID = intval($_POST['ActiveID']);
        $Openid = trim($_POST['Openid']);
        $Nickname = trim($_POST['Nickname']);
        $Remark = trim($_POST['Remark']);
        
        if($this->my_common_model->addBlackList($ActiveID,$Openid,$Nickname,$Remark)){
            echo 1;
        }else{
            echo 0;
        }
        
    }
	
	
	public function release(){
		$id = $_GET['id'] ? $_GET['id'] : $_POST['delete'];
		if(empty($id))     show_msg('请选择要解禁的黑名单！', $_SESSION['url_forward']);  
		$row = $this->my_common_model->release($id, 'ActiveBlackID');   
        if ($row) {
            show_msg('解禁成功！', $_SESSION['url_forward']);
        } else {
            show_msg('解禁失败！', $_SESSION['url_forward']);
        }	
	}
	
	 // 删除
    public function delete ()
    {
        $id = $_GET['id'] ? $_GET['id'] : $_POST['delete'];
		if(empty($id))     show_msg('请选择要删除的数据！', $_SESSION['url_forward']);  
		$row = $this->content_model->delete($id, 'ActiveBlackID');   
        if ($row) {
            show_msg('删除成功！', $_SESSION['url_forward']);
        } else {
            show_msg('删除失败！', $_SESSION['url_forward']);
        }		
        
    }

}
