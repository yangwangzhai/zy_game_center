<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 管理员  控制器 by tangjian 

include 'content.php';

class Log extends Content
{
    function __construct ()
    {    
        parent::__construct();
            
        $this->control = 'admin';
        $this->baseurl = 'index.php?d=admin&c=notice';
        $this->table = 'zy_log';
        $this->list_view = 'log';
        $this->add_view = 'admin_add';
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
            $searchsql .= " AND (openid like '%{$keywords}%')";
            $config['base_url'] = $this->baseurl ."&m=index&catid=$catid&keywords=" . rawurlencode($keywords);
        }


        $query = $this->db->query(
            "SELECT COUNT(*) AS num FROM zy_log WHERE $searchsql ");

        //$query = $this->db->query("SELECT COUNT(*) AS num FROM zy_attend_log");
        $count = $query->row_array();
        $data['count'] = $count['num'];
        $config['total_rows'] = $count['num'];
        $config['per_page'] = 20;
        $this->load->library('pagination');
        $this->pagination->initialize($config);
        $data['pages'] = $this->pagination->create_links();
        $offset = $_GET['per_page'] ? intval($_GET['per_page']) : 0;
        $per_page = $config['per_page'];


    /*$rank_sql = 'SELECT M.* ,C.openID,C.id,C.head_img,C.status,C.nickname,C.tel  FROM ( SELECT A.*,@rank:=@rank+1 AS pm FROM ' ;
        $rank_sql .= ' ( SELECT * FROM ( SELECT *  FROM zy_attend_log ORDER BY score DESC,id ASC) AS b GROUP BY user_id  ORDER BY score DESC,id ASC ';
        $rank_sql .= ' ) A ,(SELECT @rank:=0) B ) M , zy_attend_user C WHERE M.user_id=C.id  '.$searchsql2 . ' ORDER BY M.pm  limit '. $offset . ',20';
        $query = $this->db->query( $rank_sql );
        $result = $query->result_array();   
        
        $data['list'] = $result;*/

        $rank_sql = "select * FROM zy_log where $searchsql ORDER BY addtime desc limit  $offset,$per_page";
        $query = $this->db->query( $rank_sql );
        $result = $query->result_array();   

        $data['list'] = $result;
        $this->load->view('admin/' . $this->list_view, $data);
    }

}
