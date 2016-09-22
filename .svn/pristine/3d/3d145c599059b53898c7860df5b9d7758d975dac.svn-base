<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 管理员  控制器 by tangjian 

include 'content.php';

class gameRegTable extends Content
{
    function __construct ()
    {    
        parent::__construct();
            
        $this->control = 'gameRegTable';
        $this->baseurl = 'index.php?d=admin&c=gameRegTable';
        $this->table = 'zy_game_reg_basetable';
        $this->list_view = 'game_table_list';
        $this->add_view = 'game_table_add';
    }
    
    // 首页
    public function index ()
    {
        $keywords = trim($_REQUEST['keywords']);

        $RoomID = intval($_GET['RoomID']);

        $data['RoomID'] = $RoomID;
        if($RoomID){
            $searchsql = 'RoomID = '.$RoomID;
        }else{
            $searchsql = '1';
        }

        
        //         if ($catid) {
        //             $searchsql .= " AND catid=$catid ";
        //         }
        // 是否是查询
        if (empty($keywords)) {
            $config['base_url'] = $this->baseurl . "&m=index";
        } else {
        $searchsql .= " AND (BaseName like '%{$keywords}%' or BaseTable like '%{$keywords}%')";
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
        $sql = "SELECT * FROM $this->table WHERE  $searchsql ORDER BY RepID ASC limit $offset,$per_page";
        $query = $this->db->query($sql);
        $data['list'] = $query->result_array();

        $data['GameList'] = getGameList();

        $data['tableType'] = array(
            'zy_gamelist_resources' => 'index.php?d=admin&c=resources',
            'zy_gamelist_rule'=>'index.php?d=admin&c=rule');

        
        $_SESSION['url_forward'] =  $config['base_url']. "&per_page=$offset";
        if($RoomID){
            $_SESSION['url_forward'] .= '&RoomID='.$RoomID;
        }
        $this->load->view('admin/' . $this->list_view, $data);
    }

    // 添加
    public function add ()
    {
        
        $data['GameList'] = getGameList();
        $this->load->view('admin/' . $this->add_view,$data);
    }
    
    // 编辑
    public function edit ()
    {
        $id = intval($_GET['RepID']);
        
        // 这条信息
        $query = $this->db->get_where($this->table, 'RepID = ' . $id, 1);
        $value = $query->row_array();
        $data['value'] = $value;
        $data['RepID'] = $id;
        $data['GameList'] = getGameList();
        $this->load->view('admin/' . $this->add_view, $data);
    }
	
    // 保存 添加和修改都是在这里
    public function save ()
    {
        $id = intval($_POST['RepID']);
        $data = trims($_POST['value']);
        $data['UpdateTime'] = time();
        $data['UID'] = $this->session->userdata('UID');
        if ($id) { // 修改 ===========
            $this->db->where('RepID', $id);
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
        $id = $_GET['RepID'];
        
        
        if ($id) {
            $this->db->query("delete from $this->table where RepID=$id");
        } else {
            $ids = implode(",", $_POST['delete']);
            $this->db->query("delete from $this->table where RepID in ($ids)");
        }
        show_msg('删除成功！', $_SESSION['url_forward']);
    }

    
}
