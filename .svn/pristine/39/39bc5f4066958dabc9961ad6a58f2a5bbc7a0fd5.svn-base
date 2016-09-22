<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 管理员  控制器 by tangjian 

include 'content.php';

class Behavior extends Content
{
    function __construct ()
    {    
        parent::__construct();  
        $this->control = 'Behavior';
        $this->baseurl = 'index.php?d=admin&c=behavior';
        $this->table = 'zy_sys_log';
        $this->list_view = 'Behavior_list';
        $this->add_view = 'Behavior_add';
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
        $searchsql .= " AND (Controller like '%{$keywords}%' OR Method like '%{$keywords}%' OR Param like '%{$keywords}%' OR Comment like '%{$keywords}%')";
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
        $sql = "SELECT * FROM $this->table WHERE  $searchsql ORDER BY AddTime DESC limit $offset,$per_page";
        $query = $this->db->query($sql);
        $data['list'] = $query->result_array();
		
        
        $_SESSION['url_forward'] =  $config['base_url']. "&per_page=$offset";
        $this->load->view('admin/' . $this->list_view, $data);
    }

    
    
    // 删除
    public function delete ()
    {
        
        
        
        
        $this->db->query("delete from $this->table");
        
        show_msg('删除成功！', $_SESSION['url_forward']);
    }

    
}
