<?php

if (! defined('BASEPATH'))   exit('No direct script access allowed');

include 'content.php';
class bl_trade_log extends Content
{
    function __construct ()
    {    
        parent::__construct();
		
		$this->ActiveID = $this->input->get('ActiveID') ;
		$this->ChannelID = $this->input->get('ChannelID') ;
		$this->RoomID = $this->input->get('RoomID') ;
		$this->game_sign = "&ActiveID=$this->ActiveID&ChannelID=$this->ChannelID&RoomID=$this->RoomID";
		$this->game_sign_sql = " AND ActiveID=$this->ActiveID AND ChannelID=$this->ChannelID AND RoomID=$this->RoomID";
		
            
        $this->control = 'racedog';
        $this->baseurl = 'index.php?d=admin&c=bl_trade_log'.$this->game_sign;
        $this->table = 'zy_game_bl_trade_log';
        $this->list_view = 'bl_trade_log_list';
    }
    


    public function index(){

        $keywords = trim($_REQUEST['keywords']);
        $searchsql = '1  '. $this->game_sign_sql;  ;
        // 是否是查询
        if (empty($keywords)) {
            $config['base_url'] = $this->baseurl . "&m=index&catid=$catid";
        } else {
            $searchsql .= " AND (openid like '%{$keywords}%' or gameid = {$keywords})";
            $config['base_url'] = $this->baseurl ."&m=index&catid=$catid&keywords=" . rawurlencode($keywords);
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

        $sql="select * from  $this->table WHERE $searchsql  order by id desc limit $offset,$per_page";
        $query = $this->db->query($sql);
        $data['list'] = $query->result_array();
        foreach($data['list'] as &$val){
			$val['status'] = $val['status'] == 1 ? '<font color="#009900">成功</font>' : '<font color="#FF0000">失败</font>';
			// $val['postdata'] = array2string( json_decode($val['postdata'],true) );
            //$row = $this->db->query("SELECT head_img FROM zy_racedog_player WHERE openID= '".$val['openid'] ."'")->row_array();
           // $val['head_img'] = $row['head_img'];
           // $val['desc'] = array2string(json_decode($val['desc'],true));
        }

        $_SESSION['url_forward'] =  $config['base_url']. "&per_page=$offset";
        $this->load->view('admin/' . $this->list_view, $data);
    }

}
