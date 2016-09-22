<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 管理员  控制器 by tangjian 

include 'content.php';

class Exceptional extends Content
{
    function __construct ()
    {    
        parent::__construct();   
        $this->control = 'Exceptional';
        $this->baseurl = 'index.php?d=admin&c=exceptional';
        $this->table = 'zy_error_log';
        $this->list_view = 'Exceptional_list';
        $this->add_view = 'Exceptional_add';
        $this->type = array(0=>'数据',1=>'接口',2=>'其他');
    }
    
    // 首页
    public function index ()
    {
        $keywords = trim($_REQUEST['keywords']);
        $data['ChannelID'] = intval($_REQUEST['ChannelID']);
        $data['ActiveID'] = intval($_REQUEST['ActiveID']);
        $data['RoomID'] = intval($_REQUEST['RoomID']);


        $searchsql = '1';
        //         if ($catid) {
        //             $searchsql .= " AND catid=$catid ";
        //         }
        // 是否是查询
        if (empty($keywords)) {
            $config['base_url'] = $this->baseurl . "&m=index";
        } else {
        $searchsql .= " AND (Openid like '%{$keywords}%' or Content like '%{$keywords}%')";
        $config['base_url'] = $this->baseurl ."&m=index&keywords=" . rawurlencode($keywords);
        }

        if($data['ChannelID']){
            $searchsql .= ' AND ChannelID = '.$data['ChannelID'];
            $config['base_url'] .= '&ChannelID='.$data['ChannelID'];
        }

        if($data['ActiveID']){
            $searchsql .= ' AND ActiveID = '.$data['ActiveID'];
            $config['base_url'] .= '&ActiveID='.$data['ActiveID'];
        }

        if($data['RoomID']){
            $searchsql .= ' AND RoomID = '.$data['RoomID'];
            $config['base_url'] .= '&RoomID='.$data['RoomID'];
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
        $sql = "SELECT * FROM $this->table WHERE  $searchsql ORDER BY AddTime ASC limit $offset,$per_page";
        $query = $this->db->query($sql);
        $data['list'] = $query->result_array();
        foreach ($data['list'] as &$v) {
            $ChannelData = $this->my_common_model->get_channel_list($v['ChannelID']);
            $ActiveData = $this->my_common_model->get_active_list($v['ActiveID']);
            $RoomData = $this->my_common_model->get_room_list($v['RoomID']);

            $v['ChannelName'] = $ChannelData['ChannelName'];
            $v['ActiveName'] = $ActiveData['ActiveName'];
            $v['GameName'] = $RoomData['GameName'];
        }

        $data['CList'] = $this->my_common_model->get_channel_list();
        $data['AList'] = $this->my_common_model->get_active_list();
        $data['GList'] = $this->my_common_model->get_room_list();

		$data['type'] = $this->type;
        
        $_SESSION['url_forward'] =  $config['base_url']. "&per_page=$offset";
        $this->load->view('admin/' . $this->list_view, $data);
    }

    // 添加
    public function add ()
    {
        
        
        $this->load->view('admin/' . $this->add_view);
    }
    
    // 编辑
    public function edit ()
    {
        $id = intval($_GET['ChannelID']);
        
        // 这条信息
        $query = $this->db->get_where($this->table, 'ChannelID = ' . $id, 1);
        $value = $query->row_array();
        $data['value'] = $value;
        $data['ChannelID'] = $id;
        
        $this->load->view('admin/' . $this->add_view, $data);
    }
	
    // 保存 添加和修改都是在这里
    public function save ()
    {
        $id = intval($_POST['ChannelID']);
        $data = trims($_POST['value']);
        
        if ($id) { // 修改 ===========
            $this->db->where('ChannelID', $id);
            $query = $this->db->update($this->table, $data);
            show_msg('修改成功！',$_SESSION['url_forward']);
        } else { // ===========添加 ===========
            $data['AddTime'] = time();
            $query = $this->db->insert($this->table, $data);
            show_msg('添加成功！',$_SESSION['url_forward']);
        }
    }
    
    // 删除
    public function delete ()
    {
        $id = $_GET['ChannelID'];
        
        
        if ($id) {
            $this->db->query("delete from $this->table where ChannelID=$id");
        } else {
            $ids = implode(",", $_POST['delete']);
            $this->db->query("delete from $this->table where ChannelID in ($ids)");
        }
        show_msg('删除成功！', $_SESSION['url_forward']);
    }

    
}
