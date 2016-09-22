<?php

if (! defined('BASEPATH'))   exit('No direct script access allowed');
include 'content.php';
class game_tj extends Content
{
    function __construct ()
    {    
        parent::__construct();
        $this->baseurl = 'index.php?d='.$this->folder.'&c=game_tj'.$this->game_sign;
        $this->table = 'zy_fruit_game';
        $this->list_view = 'game_tj_list';
    }
    


    public function index(){
        $keywords = trim($_REQUEST['keywords']);
        $searchsql = ' status=1 AND ' . $this->game_sign_sql;
		// 是否是查询
		if (empty($keywords)) {
			$config['base_url'] = $this->baseurl . "&m=index";
		} else {
			$searchsql .= " AND openid in( select openID FROM zy_fruit_player WHERE ( openID like '%{$keywords}%' OR nickname like '%{$keywords}%' ) AND $this->game_sign_sql ) ";
			$config['base_url'] = $this->baseurl ."&m=index&keywords=" . rawurlencode($keywords);
		}
		
		
		 if($_GET['day'] == 'today' ){
            //默认显示今天的统计
            $startTime = strtotime(date('Y-m-d 0:0:0'));
            $endTime = strtotime(date('Y-m-d 23:59:59'));
        }else if($_GET['day'] == 'yesterday'){
            $startTime = strtotime(date('Y-m-d 0:0:0',time()-86400));
            $endTime = strtotime(date('Y-m-d 23:59:59',time()-86400));
            
        }else{
			$startTime = strtotime(date('2016-07-20 0:0:0'));
            $endTime = strtotime(date('Y-m-d 23:59:59'));	
		}       

        if($_GET['starttime'] && $_GET['endtime']){
            $startTime = strtotime($_GET['starttime']);
            $endTime = strtotime($_GET['endtime']);
            $config['base_url'] .= "&starttime=".date("Y-m-d H:i:s",$startTime)."&endtime=".date("Y-m-d H:i:s",$endTime);
        }
        $data['startTime'] = $startTime;
        $data['endTime'] = $endTime;
		
		
		$query = $this->db->query("SELECT COUNT(distinct openid) AS num FROM $this->table WHERE $searchsql AND addtime > $startTime and addtime < $endTime ");
		$count = $query->row_array();
		$data['count'] = $count['num'];
		$config['total_rows'] = $count['num'];
		$config['per_page'] = $this->per_page;
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		$data['pages'] = $this->pagination->create_links();
		$offset = $_GET['per_page'] ? intval($_GET['per_page']) : 0;
		$per_page = $config['per_page'];
		$data_sql = 'select * FROM '.$this->table.' where '.$searchsql.' AND addtime > '.$startTime.' and addtime < '.$endTime.' group by openid ORDER BY addtime desc  limit '. $offset . ','.$this->per_page;
		
		$query = $this->db->query( $data_sql );
		$result = $query->result_array();
		
		foreach( $result as &$val){
			$row = $this->db->query("SELECT head_img,local_img,nickname,openID,score FROM zy_fruit_player WHERE openID= '".$val['openid'] ."'")->row_array();
			$val['head_img'] = $row['local_img'];
			$val['nickname'] = $row['nickname'];
			$val['score'] 	 = $row['score'];
			$val['openID']   = $row['openID'];
			//统计输赢
			$query = $this->db->query("SELECT sum(gold) AS sum_num FROM zy_fruit_player_result WHERE  addtime > $startTime and addtime < $endTime AND openid= '".$val['openid'] ."'");
			$count = $query->row_array();
			$val['sum_num'] = $count['sum_num'];
			
			//游戏局数
			$query = $this->db->query("SELECT count(id) AS game_num FROM zy_fruit_game WHERE  addtime > $startTime and addtime < $endTime AND openid= '".$val['openid'] ."'");
			$count = $query->row_array();
			$val['game_num'] = $count['game_num'];			
		}
		$data['list'] = $result;
		
		//赢得
		$win_sql = "SELECT sum(gold) as total  FROM `zy_fruit_player_result` where gold< 0 and addtime > $startTime and addtime < $endTime  AND " . $this->game_sign_sql;
        $query 	 = $this->db->query($win_sql);
        $win_row = $query->row_array();
		$data['win_total'] = '+' . abs($win_row['total']);
		//输
        $lost_sql = "SELECT sum(gold) as total  FROM `zy_fruit_player_result` where gold> 0 and addtime > $startTime and addtime < $endTime AND " . $this->game_sign_sql;
        $query    = $this->db->query($lost_sql);
        $lost_row = $query->row_array();
		$data['lost_total'] = -$lost_row['total'];
	
		
		
		//今日系统赢得
		$win_sql = "SELECT sum(gold) as total  FROM `zy_fruit_player_result` where gold< 0 and addtime > ".strtotime(date('Y-m-d 0:0:0'))." and addtime < ".strtotime(date('Y-m-d 23:59:59')) . "  AND " . $this->game_sign_sql;
        $query   = $this->db->query($win_sql);
        $win_row = $query->row_array();
		$data['win_today_total'] = '+' . abs($win_row['total']);
		//今日系统输
        $lost_sql = "SELECT sum(gold) as total  FROM `zy_fruit_player_result` where  gold> 0 and addtime > ".strtotime(date('Y-m-d 0:0:0'))." and addtime < ".strtotime(date('Y-m-d 23:59:59')). "  AND " . $this->game_sign_sql;
        $query    = $this->db->query($lost_sql);
        $lost_row = $query->row_array();
		$data['lost_today_total'] = -$lost_row['total'];
		
		
		//玩家访问量
		$visit_sql = "SELECT COUNT(distinct openid) AS num FROM `zy_game_log` where  Addtime > $startTime and Addtime < $endTime  AND " . $this->game_sign_sql;
        $query 	   = $this->db->query($visit_sql);
        $visit_row = $query->row_array();
		$data['visit_all_total'] = $visit_row['num'];
		//今日玩家访问量
        $visit_sql = "SELECT COUNT(distinct openid) AS num FROM `zy_game_log` where  Addtime > ".strtotime(date('Y-m-d 0:0:0'))." and Addtime <  " .strtotime(date('Y-m-d 23:59:59')) . "  AND " . $this->game_sign_sql;
        $query 	   = $this->db->query($visit_sql);
        $visit_row = $query->row_array();
		$data['visit_today_total'] = $visit_row['num'];
		
		//玩家添加量
		$game_row = $this->db->get_where('zy_active_game', array('ChannelID'=>$this->ChannelID,'ActiveID'=>$this->ActiveID,'RoomID'=>$this->RoomID),1)->row_array();
		$game_sign_sql = "ActiveID=$this->ActiveID AND ChannelID=$this->ChannelID AND GameID=" . $game_row['GameID'] ;
		
		$player_sql = "SELECT COUNT(Openid) AS num FROM `zy_gamelist_user` where  Addtime > $startTime and Addtime < $endTime  AND " . $game_sign_sql;
        $query 	   = $this->db->query($player_sql);
        $player_row = $query->row_array();
		$data['player_total'] = $player_row['num'];
		//今日玩家添加量
        $player_sql = "SELECT COUNT(Openid) AS num FROM `zy_gamelist_user` where  Addtime > ".strtotime(date('Y-m-d 0:0:0'))." and Addtime <  " .strtotime(date('Y-m-d 23:59:59')) . "  AND " . $game_sign_sql;
        $query 	   = $this->db->query($player_sql);
        $player_row = $query->row_array();
		$data['player_add_total'] = $player_row['num'];
		
		
		$_SESSION['url_forward'] =  $config['base_url']. "&per_page=$offset";
        $this->load->view($this->folder.'/' . $this->list_view, $data);
    }
	
	
	


}
