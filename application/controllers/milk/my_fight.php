<?php if (! defined('BASEPATH'))  exit('No direct script access allowed');
//  

class my_fight extends CI_Controller
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
		
	}
    public function index () {	
		$user_id = $_GET['user_id'];
		if(!$user_id) show_msg('未知参数！', 'index.php?d=milk&c=milk_fight');
		$nickname = $_GET['nickname'];
		$data['game_sign'] = "&ActiveID=$this->ActiveID&ChannelID=$this->ChannelID&RoomID=$this->RoomID";
		$game_sign_sql = "AND ActiveID=$this->ActiveID AND ChannelID=$this->ChannelID AND RoomID=$this->RoomID";
		
		$query = $this->db->query("SELECT COUNT(id) AS num FROM zy_milk_attend_log WHERE user_id=$user_id  $game_sign_sql");
        $count = $query->row_array();
        $count = intval($count['num']);
		
		$this->config->load('pagination', TRUE);
        $pagination = $this->config->item('pagination');
        $pagination['base_url'] = 'index.php?d=milk&c=my_fight&m=index&user_id='.$user_id.$data['game_sign'];
        $pagination['total_rows'] =  $count;
		$pagination['per_page'] = 6;
		$pagination['display_pages']= FALSE;//当前页码的前面和后面的"数字"链接的数量
		$pagination['next_link'] = '下一页'; // 下一页显示   
		$pagination['prev_link'] = '上一页'; // 上一页显示   
        $this->load->library('pagination');
        $this->pagination->initialize($pagination);
        $data['pages'] = $this->pagination->create_links();
        
        $offset = $_GET['per_page'] ? intval($_GET['per_page']) : 0;
		
		$this->db->order_by('id','desc');
		$where = array('user_id' => $user_id, 'ActiveID' => $this->ActiveID, 'ChannelID' => $this->ChannelID, 'RoomID' => $this->RoomID);
		$query = $this->db->get_where('zy_milk_attend_log', $where,6,$offset);
		$result = $query->result_array();
		
		foreach($result as $key=>&$val){
			$val['playtime'] = date('Y-m-d H:i:s',$val['addtime']);	
		}
	
		/*$rank_sql = 'SELECT M.*,C.head_img FROM ( SELECT A.*,@rank:=@rank+1 AS pm FROM ' ;
		$rank_sql .= ' ( SELECT *,score AS MaxS  FROM ( SELECT *  FROM zy_milk_attend_log ORDER BY score DESC,id ASC) AS b GROUP BY user_id  ORDER BY score DESC,id ASC ';
		$rank_sql .= ' ) A ,(SELECT @rank:=0) B ) M, zy_milk_attend_user C WHERE M.user_id=C.id AND M.user_id = '.$user_id.' ORDER BY M.user_id';
		*/
		$query_max = $this->db->query("SELECT  max_score,head_img FROM zy_milk_attend_user WHERE id = $user_id $game_sign_sql ");
        $row_max_score = $query_max->row_array();
        $max_score = intval($row_max_score['max_score']);
		
		//排名
		$query_pm = $this->db->query("SELECT COUNT(DISTINCT max_score) AS pm FROM zy_milk_attend_user WHERE max_score>= $max_score AND status=0 $game_sign_sql ");
		$row_pm = $query_pm->row_array();
		
		$data['ranking'] = $row_pm['pm'];
		$data['max_score'] = $max_score;	
		$data['head_img'] = $row_max_score['head_img'];
		
		/*$query = $this->db->query( $rank_sql );
		$row = $query->row_array();
		if($row){
			$data['ranking'] = $row_pm['pm'];
			$data['max_score'] = $max_score;	
			$data['head_img'] = $row['head_img'];
		}else{
			$data['ranking'] = '未知';
			$data['max_score'] = '未知';	
			
		}*/
		$data['list'] = $result;
		$data['nickname'] = $nickname;	
		
        $this->load->view('milk/my_fight_view', $data);
    } 
		
	
	
}




?>
