<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 管理员  控制器 by tangjian 


class Api extends CI_Controller
{
    function __construct ()
    {    
        parent::__construct();

        $this->ChannelID = intval($_GET['ChannelID']);
        $this->ActiveID = intval($_GET['ActiveID']);
        $this->RoomID = intval($_GET['RoomID']);
            
        $this->control = 'api';
        $this->baseurl = 'index.php?d=redrain&c=rank&ActiveID='.$this->ActiveID.'&ChannelID='.$this->ChannelID.'&RoomID='.$this->RoomID;
        $this->table = 'zy_redrain_user';
        $this->list_view = 'redrain/rank_list';
    }

    public function index(){
        
    }
    


    public function rank(){

        $res = array();

        if(!$this->ChannelID){
            $res['ErrorCode'] = -1;
            $res['msg'] = '缺少ChannelID';
            exit(json_encode($res));
        }

        if(!$this->ActiveID){
            $res['ErrorCode'] = -2;
            $res['msg'] = '缺少ActiveID';
            exit(json_encode($res));
        }

        if(!$this->RoomID){
            $res['ErrorCode'] = -3;
            $res['msg'] = '缺少RoomID';
            exit(json_encode($res));
        }

        $searchsql = "ChannelID = {$this->ChannelID} AND ActiveID = {$this->ActiveID} AND RoomID = {$this->RoomID}";
        
        $data['ErrorCode'] = 0;
        $config['base_url'] = $this->baseurl . "&m=rank";
        


        $query = $this->db->query(
            "SELECT COUNT(*) AS num FROM $this->table WHERE status=0 and $searchsql ");

        $count = $query->row_array();
        $data['count'] = $count['num'];
        $config['total_rows'] = $count['num'];
        $config['per_page'] = 20;
        $this->load->library('pagination');
        $this->pagination->initialize($config);
        //$data['pages'] = $this->pagination->create_links();
        $offset = $_GET['per_page'] ? intval($_GET['per_page']) : 0;
        $per_page = $config['per_page'];

        //$data['offset'] = $offset;



		$rank_sql = "SELECT openid,nickname,img_url,score,addtime FROM $this->table where status = 0 and $searchsql ORDER BY score desc limit  $offset,$per_page";
		$query = $this->db->query( $rank_sql );
		$result = $query->result_array();	

        $data['rank'] = $result;


        echo json_encode($data);
    }

}
