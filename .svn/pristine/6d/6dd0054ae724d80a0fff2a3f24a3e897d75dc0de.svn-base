<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 管理员  控制器 by tangjian 

include 'content.php';

class error_log extends Content
{
    function __construct ()
    {    
        parent::__construct();
            
        $this->control = 'error_log';
        $this->baseurl = 'index.php?d=admin&c=error_log';
        $this->table = 'zy_error_log';
        $this->list_view = 'error_log_list';
    }
    


    public function index(){

        $keywords = trim($_REQUEST['keywords']);
        $searchsql = '1';
        //         if ($catid) {
        //             $searchsql .= " AND catid=$catid ";
        //         }
        // 是否是查询
        if (empty($keywords)) {
            $config['base_url'] = $this->baseurl . "&m=index&catid=$catid";
        } else {
            $searchsql .= " AND (Openid like '%{$keywords}%' or Content like '%{$keywords}%')";
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


        $rank_sql = "select * FROM $this->table where $searchsql ORDER BY AddTime desc limit  $offset,$per_page";
        $query = $this->db->query( $rank_sql );
        $result = $query->result_array();   

        $data['list'] = $result;
        $this->load->view('admin/' . $this->list_view, $data);
    }

}
