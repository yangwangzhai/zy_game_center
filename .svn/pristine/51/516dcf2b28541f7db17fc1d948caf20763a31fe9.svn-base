<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 管理员  控制器 by tangjian 

include 'content.php';

class betlog extends Content
{
    function __construct ()
    {    
        parent::__construct();
            
        $this->control = 'admin';
        $this->baseurl = 'index.php?d=racedog&c=betlog'.$this->game_sign;
        $this->table = 'zy_racedog_bet_on';
        $this->list_view = 'betlog_list';      
    }
    


    public function index(){

        $keywords = trim($_REQUEST['keywords']);
        $searchsql = '1' . $this->game_sign_sql;  
        // 是否是查询
        if (empty($keywords)) {
            $config['base_url'] = $this->baseurl . "&m=index&catid=$catid";
        } else {
            $searchsql .= " AND (openid like '%{$keywords}%' or gameid like '%{$keywords}%')";
            $config['base_url'] = $this->baseurl ."&m=index&catid=$catid&keywords=" . rawurlencode($keywords);
        }
		$type = (string)$_REQUEST['type'] ;		
		if($type == 1 || $type == '') {
			 $searchsql .= " AND openid != 'systemPlayer' ";
			 $config['base_url'] .= "&type=1" ;
			 $data['type'] = 1;
		}else{
			 $config['base_url'] .= "&type=0" ;
			 $data['type'] = 0;
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

        $sql="select * from  $this->table WHERE $searchsql  order by addtime desc limit $offset,$per_page";
        $query = $this->db->query($sql);
        $data['list'] = $query->result_array();
        foreach($data['list'] as &$val){
            $row = $this->db->query("SELECT head_img FROM zy_racedog_player WHERE openID= '".$val['openid'] ."'")->row_array();
            $val['head_img'] = $row['head_img'];
        }

        $_SESSION['url_forward'] =  $config['base_url']. "&per_page=$offset";
        $this->load->view('racedog/' . $this->list_view, $data);
    }

}
