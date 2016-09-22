<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 管理员  控制器 by tangjian 

include 'content.php';

class channelAPI extends Content
{
    function __construct ()
    {    
        parent::__construct();
            
        $this->control = 'channelAPI';
        $this->baseurl = 'index.php?d=admin&c=channelAPI';
        $this->table = 'zy_channel_api';
        $this->list_view = 'channelAPI_list';
        $this->add_view = 'channelAPI_add';
    }
    
    // 首页
    public function index ()
    {
        $keywords = trim($_REQUEST['keywords']);

        $searchsql = '1';
        //         if ($catid) {
        //             $searchsql .= " AND catid=$catid ";
        //         }
        // 是否是查询
        if (empty($keywords)) {
            $config['base_url'] = $this->baseurl . "&m=index";
        } else {
        $searchsql .= " AND (ApiName like '%{$keywords}%' or ApiSign like '%{$keywords}%')";
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
        $sql = "SELECT * FROM $this->table WHERE  $searchsql ORDER BY ChannelApiID ASC limit $offset,$per_page";
        $query = $this->db->query($sql);
        $data['list'] = $query->result_array();

        //获取渠道列表
        $CList = $this->db->query("SELECT ChannelID,ChannelName FROM zy_channel_main")->result_array();
        $data['CList'] = $CList;
        
        $_SESSION['url_forward'] =  $config['base_url']. "&per_page=$offset";
        $this->load->view('admin/' . $this->list_view, $data);
    }

    // 添加
    public function add ()
    {
        //获取渠道列表
        $CList = $this->db->query("SELECT ChannelID,ChannelName FROM zy_channel_main")->result_array();
        $data['CList'] = $CList;
        $this->load->view('admin/' . $this->add_view,$data);
    }
    
    // 编辑
    public function edit ()
    {
        $id = intval($_GET['ChannelApiID']);
        
        // 这条信息
        $query = $this->db->get_where($this->table, 'ChannelApiID = ' . $id, 1);
        $value = $query->row_array();
        $data['value'] = $value;
        $data['ChannelApiID'] = $id;

        //获取渠道列表
        $CList = $this->db->query("SELECT ChannelID,ChannelName FROM zy_channel_main")->result_array();
        $data['CList'] = $CList;
        
        $this->load->view('admin/' . $this->add_view, $data);
    }
	
    // 保存 添加和修改都是在这里
    public function save ()
    {
        $id = intval($_POST['ChannelApiID']);
        $data = trims($_POST['value']);
        $data['UID'] = $this->session->userdata('UID');
        $data['Uptime'] =time();
        if ($id) { // 修改 ===========
            $this->db->where('ChannelApiID', $id);
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
        $id = $_GET['ChannelApiID'];
        
        
        if ($id) {
            $this->db->query("delete from $this->table where ChannelApiID=$id");
        } else {
            $ids = implode(",", $_POST['delete']);
            $this->db->query("delete from $this->table where ChannelApiID in ($ids)");
        }
        show_msg('删除成功！', $_SESSION['url_forward']);
    }

    // 锁定
    public function changeStatus ()
    {
        $id = intval($_GET['ChannelApiID']);
        //update   book   status=ABS(status-1)
        $this->db->query("update $this->table set Status=ABS(Status-1) WHERE ChannelApiID = $id");
        show_msg('操作成功！',$_SESSION['url_forward']);
    }

    public function showRemark(){
        $id = $_GET['ChannelApiID'];

        $api = $this->db->query("SELECT ApiUrl,Remark FROM $this->table WHERE ChannelApiID = $id")->row_array();

        echo '接口地址：'.$api['ApiUrl'].'<br/><br/>';
        echo '备注信息：<br/>'.$api['Remark'];
    }

    
}
