<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 管理员  控制器 by tangjian 

include 'content.php';

class GameopeningAPI extends Content
{
    function __construct ()
    {    
        parent::__construct();
            
        $this->control = 'admin';
        $this->baseurl = 'index.php?d=admin&c=gameopeningAPI';
        $this->table = 'zy_game_opening_api';
        $this->list_view = 'opening_api_list';  
		$this->add_view = 'opening_api_add';      
		$this->load->model('content_model'); 
     	$this->content_model->set_table( $this->table );
    }
    


    public function index(){	
		$RoomID = $this->input->get('RoomID');		
		$keywords = trim($_REQUEST['keywords']);
		$searchsql = ' RoomID='.$RoomID;	
		 // 是否是查询
        if (empty($keywords)) {
            $config['base_url'] = $this->baseurl . "&m=index";
        } else {
            $searchsql .= " AND (ApiName like '%{$keywords}%' OR ApiDesc like '%{$keywords}%' OR ApiRequet like '%{$keywords}%')";
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
		$result = $this->content_model->get_list('*', $searchsql, 'ID DESC',  $offset);	
		foreach($result as $key=> &$val){
			$row = $this->my_common_model->get_room_list($val['RoomID']);
			$val['GameName'] = $row['GameName'];
			
		}
        $data['list'] = $result;
		$data['RoomID'] = $RoomID;    	 
        $_SESSION['url_forward'] =  $config['base_url']. "&per_page=$offset";
        $this->load->view('admin/' . $this->list_view, $data);
    }
	
	function add(){
		$RoomID = $this->input->get('RoomID');		
		$row = $this->my_common_model->get_room_list($RoomID);
		if($row){
			$data['GameName'] = $row['GameName']; 
		}
		$data['RoomID'] = $RoomID;       
        $this->load->view('admin/' . $this->add_view, $data);
	}
	function edit(){
		$RoomID = $this->input->get('RoomID');
		$ID =$this->input->get('ID');
		$row = $this->my_common_model->get_room_list($RoomID);
		if($row){
			$data['GameName'] = $row['GameName']; 
		}
		$data['value'] = $this->content_model->get_one($ID, 'ID');
		$data['RoomID'] = $RoomID;   
		$data['ID'] = $ID;       
        $this->load->view('admin/' . $this->add_view, $data);
		
	}
	function copyrow(){
		$RoomID = $this->input->get('RoomID');
		$ID =$this->input->get('ID');
		$row = $this->my_common_model->get_room_list($RoomID);
		if($row){
			$data['GameName'] = $row['GameName']; 
		}
		$data['value'] = $this->content_model->get_one($ID, 'ID');
		$data['RoomID'] = $RoomID; 
		$this->load->view('admin/' . $this->add_view, $data);
	}
	
	function save(){
		
		$ID = intval($_POST['ID']);
        $data = trims($_POST['value']);
        
        if ($data['ApiName'] == "") {
             show_msg('接口名称不能为空');
        }  
		if ($data['ApiUrl'] == "0") {
             show_msg('接口地址不能为空');
        }  
		$data['RoomID'] = intval($_POST['RoomID']);   
        if ($ID) { // 修改 ===========			
            $this->db->where('ID', $ID);			
            $query = $this->db->update($this->table, $data);
            show_msg('修改成功！', $_SESSION['url_forward'].'&RoomID='.$data['RoomID']);
        } else { // ===========添加 ===========
            $data['AddTime'] = time();			
            $query = $this->db->insert($this->table, $data);
			$new_id = $this->db->insert_id();
			show_msg('添加成功！', $_SESSION['url_forward'].'&RoomID='.$data['RoomID']);
				
		}
	}
	
	
	
	 // 删除
    public function delete ()
    {
		$RoomID = $this->input->get('RoomID');
        $id = $_GET['ID'] ? $_GET['ID'] : $_POST['delete'];
		if(empty($id))     show_msg('请选择要删除的数据！', $_SESSION['url_forward']);  
		$row = $this->content_model->delete($id, 'ID');   
        if ($row) {
            show_msg('删除成功！', $_SESSION['url_forward'].'&RoomID='.$RoomID);
        } else {
            show_msg('删除失败！', $_SESSION['url_forward'].'&RoomID='.$RoomID);
        }		
        
    }

}
