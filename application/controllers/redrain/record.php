<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 管理员  控制器 by tangjian 

include 'application/controllers/admin/content.php';

class record extends Content
{
    function __construct ()
    {    
        parent::__construct();

        $this->ChannelID = intval($_GET['ChannelID']);
        $this->ActiveID = intval($_GET['ActiveID']);
        $this->RoomID = intval($_GET['RoomID']);
            
        $this->control = 'record';
        $this->baseurl = 'index.php?d=redrain&c=record&ActiveID='.$this->ActiveID.'&ChannelID='.$this->ChannelID.'&RoomID='.$this->RoomID;
        $this->table = 'zy_redrain_user';
        $this->list_view = 'redrain/record_list';
    }
    


    public function index(){

       

        $keywords = trim($_REQUEST['keywords']);
        $searchsql = "ChannelID = {$this->ChannelID} AND ActiveID = {$this->ActiveID} AND RoomID = {$this->RoomID}";
        
        // 是否是查询
        if (empty($keywords)) {
            $config['base_url'] = $this->baseurl . "&m=index";
        } else {
            $searchsql .= " AND (openid like '%{$keywords}%' OR nickname like '%{$keywords}%')";
            $config['base_url'] = $this->baseurl ."&m=index&keywords=" . rawurlencode($keywords);
        }

        $query = $this->db->query("SELECT COUNT(*) AS num FROM $this->table WHERE $searchsql");
        $count = $query->row_array();
        $data['count'] = $count['num'];
        $config['total_rows'] = $count['num'];
        $config['per_page'] = 20;
        $this->load->library('pagination');
        $this->pagination->initialize($config);
        $data['pages'] = $this->pagination->create_links();

        $offset = $_GET['per_page'] ? intval($_GET['per_page']) : 0;
        $per_page = $config['per_page'];

        $sql = "SELECT * FROM $this->table WHERE $searchsql order by addtime desc limit $offset,$per_page";
        $query = $this->db->query($sql);
        $data['list'] = $query->result_array();
        $_SESSION['url_forward'] =  $config['base_url']. "&per_page=$offset";
        $this->load->view($this->list_view, $data);
    }

    // 删除
    public function delete ()
    {
        $id = $_GET['id'];

        if ($id) {
            $this->db->query("delete from $this->table where id=$id");
        } else {
            $ids = implode(",", $_POST['delete']);
            $this->db->query("delete from $this->table where id in ($ids)");
        }
        //header("Location:{$_SESSION['url_forward']}");
        show_msg('删除成功！', $_SESSION['url_forward']);
    }

}
