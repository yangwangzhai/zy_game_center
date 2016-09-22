<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 管理员  控制器 by tangjian 

include 'content.php';

class game_rule extends Content
{
	
    function __construct ()
    {    
        parent::__construct();
            
        $this->control = 'admin';
        $this->baseurl = 'index.php?d=racedog&c=game_rule'.$this->game_sign;
        $this->table = 'zy_racedog_game_rule';
        $this->list_view = 'game_rule';       
    }
    


    public function index(){
        $rank_sql = 'select * FROM '.$this->table.' WHERE 1 ' .$this->game_sign_sql. '  ORDER BY dog,yandou  ';
        $query = $this->db->query( $rank_sql );
        $result = $query->result_array();          
		
		$data['dog2'] = array();
		$data['dog3'] = array();
		$data['dog4'] = array();
		$data['dog5'] = array();
		foreach($result as $val){
			array_push($data['dog'.$val['dog']] ,$val);			
		}	
		$data['status'] = 0;
		if(!empty($result))	$data['status'] = $result[0]['status'];
		
		$_SESSION['url_forward'] =  $this->baseurl ;
        $this->load->view('racedog/' . $this->list_view, $data);
    }
	
	
	
	function save(){
		//$this->db->query(' truncate ' . $this->table);
		$this->db->query("delete from $this->table where 1  $this->game_sign_sql");
		$value = $_POST['value'];
		$status = 0;
		if(isset($_POST['status']) && $_POST['status'] == 1)$status = 1;
		foreach($value as $key => $val){
			$dog = $key ;
			$data = array();
			foreach($val as $v){
				$data['dog'] = $dog;
				$data['yandou'] = $v['yandou'];
				$data['gailv'] = $v['gailv'];
				$data['status'] = $status;
				$data['addtime'] = time();
				$data['ActiveID'] = $this->ActiveID;
				$data['ChannelID'] = $this->ChannelID;
				$data['RoomID'] = $this->RoomID;
				if(!empty($data['yandou'])  && $data['gailv'] >=0 && $data['gailv'] != ''){
					 $this->db->insert($this->table,$data) . '<br>';
				}
			}
		}
		
		show_msg('设置成功！', $_SESSION['url_forward']);
	}
	
	
	
	

}
