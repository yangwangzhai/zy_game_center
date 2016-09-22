<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 活动自定义游戏资源  控制器 by tangjian 

include 'content.php';

class customResources extends Content
{
    function __construct ()
    {    
        parent::__construct();
            
        $this->control = 'customResources';
        $this->baseurl = 'index.php?d=admin&c=customResources';
        $this->table = 'zy_gamelist_resources';
        $this->list_view = 'customRes_list';
        $this->add_view = 'customRes_add';
		$this->load->model('content_model'); 
     	$this->content_model->set_table( $this->table );
     	$this->ReType = array(
                0 => '图片',
                1 => '音乐',
                2 => '其他',
            );

        $RoomID = intval($_GET['RoomID']);                  
        $room = $this->my_common_model->get_room_list($RoomID); 
        $this->uploadpath = $room['Folder'];
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

		$ActiveID = intval($_REQUEST['ActiveID']);
       
		
		 // 是否是查询
        if (empty($keywords)) {
        	$searchsql .= " AND ActiveID = ".$ActiveID;
            $config['base_url'] = $this->baseurl . "&m=index&ActiveID=$ActiveID";
        } else {
            $searchsql .= " AND (`ReName` like '%{$keywords}%' or `VarName` like '%{$keywords}%') AND ActiveID = ".$ActiveID;
            $config['base_url'] = $this->baseurl ."&m=index&ActiveID=$ActiveID&keywords=" . rawurlencode($keywords);
        }
		$data['count'] = $this->content_model->get_count($searchsql);
		$config['total_rows'] = $data['count'] ;
        $config['per_page'] = $this->per_page;
        $this->load->library('pagination');
        $this->pagination->initialize($config);
        $data['pages'] = $this->pagination->create_links();
        $offset = $_GET['per_page'] ? intval($_GET['per_page']) : 0;
        $per_page = $config['per_page'];
		$result = $this->content_model->get_list('*', $searchsql, 'ReID DESC',  $offset);	
		foreach($result as $key=>$val){		
			$user_row = $this->my_common_model->get_user($val['UID']);     
			
			
			$result[$key]['UserName'] = $user_row['Username'];
		}
		//var_dump($result);

		$data['ReType'] = $this->ReType;
		$data['ActiveID'] = $ActiveID;
        $data['list'] = $result;		
        $_SESSION['url_forward'] =  $config['base_url']. "&per_page=$offset";
        $this->load->view('admin/' . $this->list_view, $data);
    }
	
	
	function add(){
		
		
        $this->load->view('admin/' . $this->add_view, $data);
	}
	
	function edit(){
		$id = intval($_GET['ReID']);
        $data['RoomID'] = intval($_GET['RoomID']);
        // 这条信息
        $query = $this->db->get_where($this->table, 'ReID = ' . $id, 1);
        $value = $query->row_array();
        $data['value'] = $value;
        $data['ReID'] = $id;
        $data['ReType'] = $this->ReType;
		$this->load->view('admin/' . $this->add_view, $data);
	}
	
	function save(){

		$id = intval($_POST['ReID']);
        $data = trims($_POST['value']);
        $data['UpdateTime'] = time();
        $data['UID'] = $this->session->userdata('UID');
        if(file_exists($data['ReSrc'])){
            $data['ReSize'] = formatBytes(filesize($data['ReSrc']));
        }
        if ($id) { // 修改 ===========
            $this->db->where('ReID', $id);
            $query = $this->db->update($this->table, $data);
            show_msg('修改成功！',$_SESSION['url_forward']);
        } else { // ===========添加 ===========
            $data['IsBase'] = 1;
            $query = $this->db->insert($this->table, $data);
            show_msg('添加成功！',$_SESSION['url_forward']);
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

    

}
