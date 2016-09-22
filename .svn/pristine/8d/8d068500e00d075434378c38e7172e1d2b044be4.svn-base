<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 管理员  控制器 by tangjian 

include 'content.php';

class ydrank extends Content
{
    function __construct ()
    {    
        parent::__construct();
            
        $this->control = 'racedog';
        $this->baseurl = 'index.php?d=racedog&c=ydrank'.$this->game_sign;;
        $this->table = 'zy_racedog_player';
        $this->list_view = 'ydrank_list';       
    }
    


    public function index(){

        $keywords = trim($_REQUEST['keywords']);
        $searchsql = 'status = 0 ' . $this->game_sign_sql; ;
		$searchsql2 = 'status = 0';      
        // 是否是查询
        if (empty($keywords)) {
            $config['base_url'] = $this->baseurl . "&m=index&catid=$catid";
        } else {
            $searchsql .= " AND (openID like '%{$keywords}%' OR nickname like '%{$keywords}%' )";
			
            $config['base_url'] = $this->baseurl ."&m=index&catid=$catid&keywords=" . rawurlencode($keywords);
        }
        $query = $this->db->query("SELECT COUNT(*) AS num FROM $this->table WHERE $searchsql ");
        $count = $query->row_array();
        $data['count'] = $count['num'];
        $config['total_rows'] = $count['num'];
        $config['per_page'] = 20;
        $this->load->library('pagination');
        $this->pagination->initialize($config);
        $data['pages'] = $this->pagination->create_links();
        $offset = $_GET['per_page'] ? intval($_GET['per_page']) : 0;
        $per_page = $config['per_page'];


	

		$rank_sql = 'select * FROM '.$this->table.' where '.$searchsql.'  ORDER BY total_gold DESC limit '. $offset . ',20';
		$query = $this->db->query( $rank_sql );
		$result = $query->result_array();	
		
        $data['list'] = $result;
        $data['offset'] = $offset;
        $this->load->view('racedog/' . $this->list_view, $data);
    }

}
