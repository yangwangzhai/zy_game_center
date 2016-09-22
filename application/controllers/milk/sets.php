<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 管理员  控制器 by tangjian 

include 'content.php';

class sets extends Content
{
	public $ActiveID = 0;
	public $ChannelID = 0;
	public $RoomID = 0;
    function __construct ()
    {    
        parent::__construct();
            
        $this->control = 'admin';
        $this->baseurl = 'index.php?d=milk&c=sets';
        $this->table = 'zy_milk_attend_log';
        $this->list_view = 'sets_list';       
		$this->ActiveID = $this->input->get('ActiveID');
		$this->ChannelID = $this->input->get('ChannelID');
		$this->RoomID = $this->input->get('RoomID');
    }
    


    public function index(){
		$data['game_sign'] = "&ActiveID=$this->ActiveID&ChannelID=$this->ChannelID&RoomID=$this->RoomID";
		$game_sign_sql = "  zy_milk_attend_log.ActiveID=$this->ActiveID AND zy_milk_attend_log.ChannelID=$this->ChannelID AND zy_milk_attend_log.RoomID=$this->RoomID";

        $keywords = trim($_REQUEST['keywords']);
        $searchsql = ' ' .$game_sign_sql;        
        // 是否是查询
        if (empty($keywords)) {
            $config['base_url'] = $this->baseurl . "&m=index&catid=$catid".$data['game_sign'];
        } else {
            $searchsql .= " AND (openID like '%{$keywords}%' OR nickname = '{$keywords}' OR tel like '%{$keywords}%')";
            $config['base_url'] = $this->baseurl ."&m=index&catid=$catid&keywords=" . rawurlencode($keywords).$data['game_sign'];
        }


        $query = $this->db->query(
            "SELECT COUNT(*) AS num FROM zy_milk_attend_log inner join zy_milk_attend_user on zy_milk_attend_log.user_id=zy_milk_attend_user.id
WHERE $searchsql ");
        $count = $query->row_array();
        $data['count'] = $count['num'];
        $config['total_rows'] = $count['num'];
        $config['per_page'] = 20;
        $this->load->library('pagination');
        $this->pagination->initialize($config);
        $data['pages'] = $this->pagination->create_links();

        $offset = $_GET['per_page'] ? intval($_GET['per_page']) : 0;
        $per_page = $config['per_page'];

        $sql="select zy_milk_attend_log.*,zy_milk_attend_user.head_img,zy_milk_attend_user.nickname from  zy_milk_attend_log inner join zy_milk_attend_user on zy_milk_attend_log.user_id=zy_milk_attend_user.id
WHERE $searchsql  order by zy_milk_attend_log.addtime desc limit $offset,$per_page";
        $query = $this->db->query($sql);
        $data['list'] = $query->result_array();
        //print_r($data['list']);exit;
        $_SESSION['url_forward'] =  $config['base_url']. "&per_page=$offset".$data['game_sign'];
        $this->load->view('milk/' . $this->list_view, $data);
    }

}
