<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 管理员  控制器 by tangjian 

include 'content.php';

class channel extends Content
{
    function __construct ()
    {    
        parent::__construct();
            
        $this->control = 'channel';
        $this->baseurl = 'index.php?d=admin&c=channel';
        $this->table = 'zy_channel_main';
        $this->list_view = 'channel_list';
        $this->add_view = 'channel_add';
        $this->load->model('my_common_model');
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
        $searchsql .= " AND (ChannelName like '%{$keywords}%')";
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
        $sql = "SELECT * FROM $this->table WHERE  $searchsql ORDER BY ChannelID ASC limit $offset,$per_page";
        $query = $this->db->query($sql);
        $data['list'] = $query->result_array();
		foreach($data['list'] as $key=>&$val){
			$query = $this->db->query("SELECT COUNT(*) AS num FROM zy_active_main WHERE  ChannelID =".$val['ChannelID']);
			$count = $query->row_array();
			$this->db->query("UPDATE $this->table SET ActiveNum = ".$count['num'] . " WHERE ChannelID=".$val['ChannelID'] );
			
			$query = $this->db->query("SELECT * FROM zy_gamelist_user WHERE  ChannelID =".$val['ChannelID'] . " ORDER BY UpdateTime desc limit 1");
			$row = $query->row_array();
			if($row){
				$data['list'][$key]['ActiveTime'] = $row['UpdateTime'];
				$this->db->query("UPDATE $this->table SET ActiveNum = ".$row['UpdateTime'] . " WHERE ChannelID=".$val['ChannelID'] );
			}
			
		}
        
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
