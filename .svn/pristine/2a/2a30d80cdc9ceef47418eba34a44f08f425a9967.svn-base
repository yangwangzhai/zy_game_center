<?php

if (! defined('BASEPATH'))   exit('No direct script access allowed');
include 'content.php';
class player extends Content
{
    function __construct ()
    {    
        parent::__construct();
        $this->baseurl = 'index.php?d='.$this->folder.'&c=player'.$this->game_sign;
        $this->table = 'zy_fruit_player';
        $this->list_view = 'player_list';
    }
    


    public function index(){
        $keywords = trim($_REQUEST['keywords']);
        $searchsql = '1 AND ' . $this->game_sign_sql;
		// 是否是查询
		if (empty($keywords)) {
			$config['base_url'] = $this->baseurl . "&m=index";
		} else {
			$searchsql .= " AND (openID like '%{$keywords}%' OR nickname like '%{$keywords}%') ";
			$config['base_url'] = $this->baseurl ."&m=index&keywords=" . rawurlencode($keywords);
		}
		$query = $this->db->query("SELECT COUNT(*) AS num FROM $this->table WHERE $searchsql ");
		$count = $query->row_array();
		$data['count'] = $count['num'];
		$config['total_rows'] = $count['num'];
		$config['per_page'] = $this->per_page;
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		$data['pages'] = $this->pagination->create_links();
		$offset = $_GET['per_page'] ? intval($_GET['per_page']) : 0;
		$per_page = $config['per_page'];
		$data_sql = 'select * FROM '.$this->table.' where '.$searchsql.' ORDER BY lasttime desc,addtime desc limit '. $offset . ','.$this->per_page;
		$query = $this->db->query( $data_sql );
		$result = $query->result_array();
		foreach( $result as &$val){

		}
		$data['list'] = $result;
		$_SESSION['url_forward'] =  $config['base_url']. "&per_page=$offset";
        $this->load->view($this->folder.'/' . $this->list_view, $data);
    }
	
	function lookLB(){
		$openid = $this->input->post('openid');
		$this->load->model('lb_model');
		$lb_num = $this->lb_model->get_lb_num($openid, $this->ActiveID, $this->ChannelID, $this->RoomID);
		if ($lb_num['returncode'] == '000000') {
            echo  $lb_num['dcurrency']; //龙币数
		}else{
			echo json_encode($lb_num);
		}
	}
	
	function rechargeByMy(){
		$openid = $this->input->get('openid');
		$num = $this->input->get('num') ? $this->input->get('num') : 10;
		$this->load->model('lb_model');
		 $return = $this->lb_model->recharge_lb($num, 902, $openid, $this->ActiveID, $this->ChannelID, $this->RoomID, 000000);
       
	}


}
