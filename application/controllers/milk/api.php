<?php if (! defined('BASEPATH'))  exit('No direct script access allowed');

class Api extends CI_Controller
{
	
	public $ActiveID = 0;
	public $ChannelID = 0;
	public $RoomID = 0;
	function __construct ()
    {    
        parent::__construct();
		$this->ActiveID = $this->input->get('ActiveID');
		$this->ChannelID = $this->input->get('ChannelID');
		$this->RoomID = $this->input->get('RoomID');
		$this->load->model('my_common_model','common');
		if(!$this->ActiveID || !$this->ChannelID || !$this->RoomID){
			show(1,'ActiveID OR ChannelID OR RoomID IS NULL');
		}
		
	}
	
    public function get_rank () {	
		$per_page = $_GET['per_page'] ? intval($_GET['per_page']) : 20;		
		$page = $_GET['page'] ? intval($_GET['page']) : 1;	
		$offset = ($page - 1) * $per_page;
		$game_sign_sql = "AND ActiveID=$this->ActiveID AND ChannelID=$this->ChannelID AND RoomID=$this->RoomID";		
		//删除用户不存在的记录
		$this->db->query('DELETE FROM zy_milk_attend_log WHERE user_id NOT IN(SELECT id FROM zy_milk_attend_user WHERE 1 '.$game_sign_sql.' ) '.$game_sign_sql.'  OR user_id IS NULL');
		$query = $this->db->query("SELECT COUNT(id) AS num FROM zy_milk_attend_user where max_score > 0 $game_sign_sql");
        $count = $query->row_array();
        $count = intval($count['num']);
		$data['game_sign'] = "&ActiveID=$this->ActiveID&ChannelID=$this->ChannelID&RoomID=$this->RoomID";		
	  
        		
		$status_sql = ' AND status = 0 ';		
		$rank_sql = ' select nickname,head_img,max_score FROM zy_milk_attend_user where max_score > 0 and max_score < 350 '.$status_sql.$game_sign_sql.' ORDER BY max_score DESC,lasttime ASC   limit '. $offset . ','.$per_page;
		$query = $this->db->query( $rank_sql );
		$result = $query->result_array();	
		foreach($result as &$val){
			$val['MaxS'] = $val['max_score'];
			$max_score = $val['max_score'];			
			$query_pm = $this->db->query("SELECT COUNT(DISTINCT max_score) AS pm FROM zy_milk_attend_user WHERE  max_score>= $max_score and max_score < 350  ".$status_sql.$game_sign_sql);
			$row_pm = $query_pm->row_array();
			$val['pm'] = $row_pm['pm'];
		}
		
		
	  echo  json_encode($result);	
     
		
	}
	
	
	

	
}




?>
