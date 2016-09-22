<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 管理员  控制器 by tangjian 

include 'content.php';

class notice extends Content
{
	public $ActiveID = 0;
	public $ChannelID = 0;
	public $RoomID = 0;
    function __construct ()
    {    
        parent::__construct();
        $this->baseurl = 'index.php?d=milk&c=notice';
        $this->table = 'zy_milk_attend_user';
        $this->list_view = 'notice_list';
		$this->ActiveID = $this->input->get('ActiveID');
		$this->ChannelID = $this->input->get('ChannelID');
		$this->RoomID = $this->input->get('RoomID');
    }
    


    public function index(){
		$data['game_sign'] = "&ActiveID=$this->ActiveID&ChannelID=$this->ChannelID&RoomID=$this->RoomID";
		$game_sign_sql = " AND ActiveID=$this->ActiveID AND ChannelID=$this->ChannelID AND RoomID=$this->RoomID";

        $keywords = trim($_REQUEST['keywords']);
        $searchsql = 'status = 0' .$game_sign_sql;
		$searchsql2 = 'status = 0';      
        // 是否是查询
        if (empty($keywords)) {
            $config['base_url'] = $this->baseurl . "&m=index".$data['game_sign'];
        } else {
            $searchsql .= " AND (openID like '%{$keywords}%' OR nickname like '%{$keywords}%' OR tel like '%{$keywords}%')";
			$searchsql2 .= " AND (C.openID like '%{$keywords}%' OR C.nickname like '%{$keywords}%' OR C.tel like '%{$keywords}%')";
            $config['base_url'] = $this->baseurl ."&m=index&catid=$catid&keywords=" . rawurlencode($keywords).$data['game_sign'];
        }


        $query = $this->db->query(
            "SELECT COUNT(*) AS num FROM zy_milk_attend_user WHERE $searchsql ");

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

		$rank_sql = ' select * FROM zy_milk_attend_user where '.$searchsql.'  ORDER BY max_score   DESC,lasttime ASC limit '. $offset . ',20';
		$query = $this->db->query( $rank_sql );
		$result = $query->result_array();	
		foreach($result as &$val){
			$val['score'] = $val['max_score'];
			$max_score = $val['max_score'];
			$query_pm = $this->db->query("SELECT COUNT(DISTINCT max_score) AS pm FROM zy_milk_attend_user WHERE max_score>= $max_score AND status = 0");
			$row_pm = $query_pm->row_array();
			$val['pm'] = $row_pm['pm'];
		}

        $data['list'] = $result;
        $this->load->view('milk/' . $this->list_view, $data);
    }

}
