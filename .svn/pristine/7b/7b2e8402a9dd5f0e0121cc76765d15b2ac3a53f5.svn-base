<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 管理员  控制器 by tangjian 

include 'content.php';

class gameRoom extends Content
{
    function __construct ()
    {    
        parent::__construct();
            
        $this->control = 'gameRoom';
        $this->baseurl = 'index.php?d=admin&c=gameRoom';
        $this->table = 'zy_game_room';
        $this->list_view = 'game_room_list';
        $this->add_view = 'game_room_add';
    }
    
    // 首页
    public function index ()
    {
        $keywords = trim($_REQUEST['keywords']);
		
		$visit_num = curlGetData("h5game.gxtianhai.cn/racedog/index.php?c=raceDog&m=get_visit_num");
		$visit_num = json_decode($visit_num,true); 		
		$this->db->query("UPDATE zy_game_room SET VistNum=".$visit_num['count_num']." WHERE RoomID=3");

        $searchsql = '1';       
        if (empty($keywords)) {
            $config['base_url'] = $this->baseurl . "&m=index";
        } else {
        $searchsql .= " AND (GameName like '%{$keywords}%')";
        $config['base_url'] = $this->baseurl ."&m=index&keywords=" . rawurlencode($keywords);
        }
        
        $data['list'] = array();
        $query = $this->db->query(
        "SELECT COUNT(*) AS num FROM $this->table WHERE  $searchsql");
        $count = $query->row_array();
        $data['count'] = $count['num'];
        $this->load->library('pagination');
        
        $config['total_rows'] = $count['num'];
        $config['per_page'] = 20;
        $this->pagination->initialize($config);
        $data['pages'] = $this->pagination->create_links();
        $offset = $_GET['per_page'] ? intval($_GET['per_page']) : 0;
        $per_page = $config['per_page'];
        $sql = "SELECT * FROM $this->table WHERE  $searchsql ORDER BY VistNum DESC,RoomID DESC limit $offset,$per_page";
        $query = $this->db->query($sql);
        $data['list'] = $query->result_array();
		foreach($data['list'] as $key=>$val){
			$count = $this->db->query("SELECT COUNT(*) AS num FROM zy_active_main WHERE  RoomID=".$val['RoomID'])->row_array();        
        	$this->db->update($this->table, array('ActiveUseNum'=>$count['num']),array('RoomID'=>$val['RoomID']));
			$data['list'][$key]['ActiveUseNum'] = $count['num'];
			
			//获得试玩信息
			$row_active_info = $this->db->query("SELECT * FROM zy_active_main WHERE Status=3 AND  RoomID=".$val['RoomID'])->row_array(); 
			$row_nav_info = $this->db->query("SELECT * FROM zy_game_reg_nav WHERE NavSign='index' AND  RoomID=".$val['RoomID'])->row_array();   
			$data['list'][$key]['PlayUrl'] = $row_nav_info['NavUrl'] . '&ActiveID='.$row_active_info['ActiveID'].'&ChannelID='.$row_active_info['ChannelID'].'&RoomID='.$row_active_info['RoomID'];
			$data['list'][$key]['FileName'] = 'a_'.$row_active_info['ActiveID'].'_c_'.$row_active_info['ChannelID'].'_r_'.$row_active_info['RoomID'].'.png';
		}

        $data['GameType'] = config_item('GameType');
        
        $_SESSION['url_forward'] =  $config['base_url']. "&per_page=$offset";
        $this->load->view('admin/' . $this->list_view, $data);
    }

    // 添加
    public function add ()
    {
        
        $data['GameType'] = config_item('GameType');		
        $this->load->view('admin/' . $this->add_view,$data);
    }
    
    // 编辑
    public function edit ()
    {
        $id = intval($_GET['RoomID']);
        
        // 这条信息
        $query = $this->db->get_where($this->table, 'RoomID = ' . $id, 1);
        $value = $query->row_array();
        $data['value'] = $value;
        $data['RoomID'] = $id;
        $data['GameType'] = config_item('GameType');		
        $this->load->view('admin/' . $this->add_view, $data);
    }
	
    // 保存 添加和修改都是在这里
    public function save ()
    {
		$id = intval($_POST['RoomID']);
        $data = trims($_POST['value']);
		
		$static_path = 'static/gameroom/'.$data['Folder'];  //独立资源文件夹
		$controllers_path = 'application/controllers/'.$data['Folder']; //独立控制器文件夹
		$views_path = 'application/views/'.$data['Folder']; //独立视图文件夹
		$return_url = $this->baseurl . '&m=add';
		if($id) $return_url = $this->baseurl . '&m=edit&RoomID='.$id;
		if(empty($data['Folder'])){
			show_msg('请填写文件夹名称！', $return_url);
		}
		
		if (! file_exists($static_path)) {			
            mkdir($static_path);
        }
		if (! file_exists($controllers_path)) {			
            @mkdir($controllers_path);
        }
		if (! file_exists($views_path)) {			
            @mkdir($views_path);
        }
		
       
        $data['UpdateTime'] = time();
        $data['UID'] = $this->session->userdata('UID');
        $path_str = '';
        foreach ($data['ScreenImages'] as $v) {
            if($v){
                $path_str .= $v.'|';
            }
        }
		
       
        $data['ScreenImages'] = trim($path_str,'|');
        if ($id) { // 修改 ===========
            $this->db->where('RoomID', $id);
            $query = $this->db->update($this->table, $data);
            show_msg('修改成功！',$_SESSION['url_forward']);
        } else { // ===========添加 ===========
            
            $query = $this->db->insert($this->table, $data);
            show_msg('添加成功！',$_SESSION['url_forward']);
        }
    }
    
    // 删除
    public function delete ()
    {
        $id = $_GET['RoomID'];
        
        
        if ($id) {
            $this->db->query("delete from $this->table where RoomID=$id");
        } else {
            $ids = implode(",", $_POST['delete']);
            $this->db->query("delete from $this->table where RoomID in ($ids)");
        }
        show_msg('删除成功！', $_SESSION['url_forward']);
    }

    
}
