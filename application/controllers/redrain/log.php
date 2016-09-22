<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 管理员  控制器 by tangjian 

include 'application/controllers/admin/content.php';

class Log extends Content
{
    function __construct ()
    {    
        parent::__construct();

        $this->ChannelID = intval($_GET['ChannelID']);
        $this->ActiveID = intval($_GET['ActiveID']);
        $this->RoomID = intval($_GET['RoomID']);
            
        $this->control = 'Log';
        $this->baseurl = 'index.php?d=redrain&c=log&ActiveID='.$this->ActiveID.'&ChannelID='.$this->ChannelID.'&RoomID='.$this->RoomID;
        $this->table = 'zy_redrain_log';
        $this->list_view = 'redrain/log';
    }
    


    public function index(){

        $keywords = trim($_REQUEST['keywords']);
        $searchsql = "ChannelID = {$this->ChannelID} AND ActiveID = {$this->ActiveID} AND RoomID = {$this->RoomID}";
        
        // 是否是查询
        if (empty($keywords)) {
            $config['base_url'] = $this->baseurl . "&m=index";
        } else {
            $searchsql .= " AND (openid like '%{$keywords}%')";
            $config['base_url'] = $this->baseurl ."&m=index&keywords=" . rawurlencode($keywords);
        }


        $query = $this->db->query(
            "SELECT COUNT(*) AS num FROM $this->table WHERE $searchsql ");

        $count = $query->row_array();
        $data['count'] = $count['num'];
        $config['total_rows'] = $count['num'];
        $config['per_page'] = 20;
        $this->load->library('pagination');
        $this->pagination->initialize($config);
        $data['pages'] = $this->pagination->create_links();
        $offset = $_GET['per_page'] ? intval($_GET['per_page']) : 0;
        $per_page = $config['per_page'];


        $rank_sql = "SELECT * FROM $this->table WHERE $searchsql ORDER BY addtime desc limit  $offset,$per_page";
        $query = $this->db->query( $rank_sql );
        $result = $query->result_array();   

        $data['list'] = $result;
        $this->load->view($this->list_view, $data);
    }

}
