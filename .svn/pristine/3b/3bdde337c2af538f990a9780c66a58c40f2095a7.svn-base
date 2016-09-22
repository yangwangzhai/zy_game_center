<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 管理员  控制器 by tangjian 

include 'application/controllers/admin/content.php';

class record extends Content
{
    function __construct ()
    {    
        parent::__construct();

        $this->ChannelID = intval($_GET['ChannelID']);
        $this->ActiveID = intval($_GET['ActiveID']);
        $this->RoomID = intval($_GET['RoomID']);
            
        $this->control = 'record';
        $this->baseurl = 'index.php?d=craps&c=record&ActiveID='.$this->ActiveID.'&ChannelID='.$this->ChannelID.'&RoomID='.$this->RoomID;
        $this->table = 'zy_craps_bet_on';
        $this->list_view = 'craps/record_list';
    }
    


    public function index(){

        $keywords = trim($_REQUEST['keywords']);
        $searchsql = "b.ChannelID = {$this->ChannelID} AND b.ActiveID = {$this->ActiveID} AND b.RoomID = {$this->RoomID}";
        
        // 是否是查询
        if (empty($keywords)) {
            $config['base_url'] = $this->baseurl . "&m=index";
        } else {
            $searchsql .= " AND (b.Openid like '%{$keywords}%')";
            $config['base_url'] = $this->baseurl ."&m=index&keywords=" . rawurlencode($keywords);
        }


        $query = $this->db->query(
            "SELECT COUNT(*) AS num FROM $this->table b WHERE $searchsql ");

        $count = $query->row_array();
        $data['count'] = $count['num'];
        $config['total_rows'] = $count['num'];
        $config['per_page'] = 20;
        $this->load->library('pagination');
        $this->pagination->initialize($config);
        $data['pages'] = $this->pagination->create_links();
        $offset = $_GET['per_page'] ? intval($_GET['per_page']) : 0;
        $per_page = $config['per_page'];

        $data['offset'] = $offset;



		$rank_sql = "SELECT b.*,p.NickName as NickName FROM $this->table b,zy_craps_player p where $searchsql and b.Openid=p.Openid ORDER BY b.AddTime desc limit  $offset,$per_page";
		$query = $this->db->query( $rank_sql );
		$result = $query->result_array();
        $data['list'] = $result;

        $_SESSION['url_forward'] =  $config['base_url']. "&per_page=$offset";
        
        $this->load->view($this->list_view, $data);
    }

    public function showRemark(){
        $id = $_GET['id'];
        $replace_arr = array('Bet1'=>'1点','Bet2'=>'2点','Bet3'=>'3点','Bet4'=>'4点','Bet5'=>'5点','Bet6'=>'6点','BetBig'=>'大','BetSmall'=>'小','BetSingle'=>'单','BetDouble'=>'双');
        $one = $this->db->get_where($this->table,array('id'=>$id))->row_array();
        $remark = string2array($one['Rmark']);
        foreach ($remark as $key => $value) {
            echo $replace_arr[$key],' => ',($value<0)?'输'.abs($value):'赢'.abs($value),'<br/>';
        }
    }

    public function delete(){
        $id = $_GET['id'];
        
        
        if ($id) {
            $this->db->query("delete from $this->table where id=$id");
        } else {
            $ids = implode(",", $_POST['delete']);
            $this->db->query("delete from $this->table where id in ($ids)");
        }
        show_msg('删除成功！', $_SESSION['url_forward']);
    }

}
