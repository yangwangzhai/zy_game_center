<?php

if (! defined('BASEPATH'))   exit('No direct script access allowed');
include 'content.php';
class game_log extends Content
{
    function __construct ()
    {    
        parent::__construct();
        $this->baseurl = 'index.php?d='.$this->folder.'&c=game_log'.$this->game_sign;
        $this->table = 'zy_fruit_game';
        $this->list_view = 'game_list';
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
		
		 if($_GET['starttime'] && $_GET['endtime'] && $_GET['openid']){
            $startTime = $_GET['starttime'];
            $endTime   = $_GET['endtime'];
            $config['base_url'] .= "&starttime=".$startTime."&endtime=".$endTime;
			$searchsql .= ' AND addtime > '.$startTime.' and addtime < '.$endTime.' AND openid=\''.$_GET['openid'].'\' ';
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
		$data_sql = 'select * FROM '.$this->table.' where '.$searchsql.' ORDER BY addtime desc limit '. $offset . ','.$this->per_page;
		$query = $this->db->query( $data_sql );
		$result = $query->result_array();
		$result_arr = $this->result_arr();
		foreach( $result as &$val){
			$row = $this->db->query("SELECT head_img,nickname,openID FROM zy_fruit_player WHERE openID= '".$val['openid'] ."'")->row_array();
			$val['head_img'] = $row['head_img'];
			$val['nickname'] = $row['nickname'];
			$val['openID'] = $row['openID'];
			
			$count_sql = "SELECT count(*) as num FROM zy_fruit_result_bs_log WHERE gameid=".$val['id'];
			$row = $this->db->query( $count_sql ) -> row_array();
			
			$bet_on_sum = 0;//下注龙币的总数，即各个水果下注数的总数
            for ($i = 1; $i < 9; $i++) {                
                $bet_on_sum += $val['bet' . $i] ;
            }
			$result_gold = $val['result_gold'] - $bet_on_sum;
			$jiesuan_text = ', 总下注:'.$bet_on_sum.', 赢回:'.$val['result_gold'];
			if($result_gold < 0){
				$jiesuan_text .= ', <font color="#FF0000">亏损:'.$result_gold.'</font>';
			}else{
				$jiesuan_text .= ', <font color="#009900">盈余:'.$result_gold.'</font>';
			}
			$re_text = $val['result_gold'] > 0 ? '(<font color="#009900">中奖</font>)' : '(<font color="#FF0000">未中</font>)';
			$val['result_text'] = '开:' . $result_arr[$val['result_index']]['name'] . $re_text.', 倍数:' . $val['result_bs'].$jiesuan_text;
			
			if($row['num'] > 2){
				$sum_sql = "SELECT sum(real_trade_gold) as real_sum FROM zy_fruit_result_bs_log WHERE type IN('result','big','small') AND  gameid=".$val['id'];
				$sum_row = $this->db->query( $sum_sql ) -> row_array();
				if($sum_row['real_sum'] < 0){
					$real_sum = ', <font color="#FF0000">比倍后亏损:'.$sum_row['real_sum'].'</font>';
				}else{
					$real_sum = ', <font color="#009900">比倍后盈余:'.$sum_row['real_sum'].'</font>';
				}
				$val['result_text'] .=$real_sum.', <a onclick="result_bs_log(\''.$val['id'].'\')">比倍明细</a>'; 
			}
		}
		$data['list'] = $result;
		$data['bet_arr'] = array(5 => '苹果',10 => '柠檬',15 => '橙子',20 => '石榴',25 => '西瓜',30 => '樱桃',35 => '双7',40 => 'BAR');
		$_SESSION['url_forward'] =  $config['base_url']. "&per_page=$offset";
        $this->load->view($this->folder.'/' . $this->list_view, $data);
    }
	
	function get_result_bs_log(){
		$game_id = $_GET['gameid'] ? $_GET['gameid'] : 0;
		$data_sql = "SELECT * FROM zy_fruit_result_bs_log WHERE gameid=$game_id order by id";
		$query = $this->db->query( $data_sql );
		$result = $query->result_array();
		foreach( $result as &$val){
			$val['result_num'] = $val['result_num'] > 0 ? $val['result_num'] : '未押';
			if($val['result_num'] > 0){
				$val['result_status'] = $val['result_status'] == 1 ? '赢' : '输';
			}else{
				$val['result_status'] = '';
			}
			
		}
		$data['list'] = $result;
		$data['type'] = array('result'=>'开奖', 'return'=>'退币', 'left'=>'加倍', 'right'=>'减倍', 'big'=>'押大', 'small'=>'押小');
		$this->load->view($this->folder.'/result_bs_list', $data);
		
	}
	
	function result_arr(){
		$prize_arr = array(
                1 => array('name' => '石榴', 'field' => 'bet4', 'bs' => 20, 'coordinate' => array(1, 1),'v'=>3),
                2 => array('name' => 'BAR', 'field' => 'bet8', 'bs' => 40, 'coordinate' => array(1, 2),'v'=>1),
                3 => array('name' => '小BAR', 'field' => 'bet8', 'bs' => 20, 'coordinate' => array(1, 3),'v'=>3),
                4 => array('name' => '苹果', 'field' => 'bet1', 'bs' => 5, 'coordinate' => array(1, 4),'v'=>4),
                5 => array('name' => '小苹果', 'field' => 'bet1', 'bs' => 2, 'coordinate' => array(1, 5),'v'=>8),
                6 => array('name' => '橙子', 'field' => 'bet3', 'bs' => 15, 'coordinate' => array(1, 6),'v'=>3),

                7 => array('name' => '西瓜', 'field' => 'bet5', 'bs' => 25, 'coordinate' => array(2, 1),'v'=>2),
                8 => array('name' => '小西瓜', 'field' => 'bet5', 'bs' => 2, 'coordinate' => array(2, 2),'v'=>8),
                9 => array('name' => 'goodluck', 'field' => 'goodluck', 'bs' => 0, 'coordinate' => array(2, 3),'v'=>1),
                10 => array('name' => '苹果', 'field' => 'bet1', 'bs' => 5, 'coordinate' => array(2, 4),'v'=>4),
                11 => array('name' => '小柠檬', 'field' => 'bet2', 'bs' => 2, 'coordinate' => array(2, 5),'v'=>8),
                12 => array('name' => '柠檬', 'bs' => 10, 'coordinate' => array(2, 6),'v'=>3),

                13 => array('name' => '石榴', 'field' => 'bet4', 'bs' => 20, 'coordinate' => array(3, 1),'v'=>3),
                14 => array('name' => '小双7', 'field' => 'bet7', 'bs' => 2, 'coordinate' => array(3, 2),'v'=>8),
                15 => array('name' => '双7', 'field' => 'bet7', 'bs' => 35, 'coordinate' => array(3, 3),'v'=>1),
                16 => array('name' => '苹果', 'field' => 'bet1', 'bs' => 5, 'coordinate' => array(3, 4),'v'=>4),
                17 => array('name' => '小橙子', 'field' => 'bet3', 'bs' => 2, 'coordinate' => array(3, 5),'v'=>8),
                18 => array('name' => '橙子', 'field' => 'bet3', 'bs' => 15, 'coordinate' => array(3, 6),'v'=>3),

                19 => array('name' => '樱桃', 'field' => 'bet6', 'bs' => 30, 'coordinate' => array(4, 1),'v'=>2),
                20 => array('name' => '小樱桃', 'field' => 'bet6', 'bs' => 2, 'coordinate' => array(4, 2),'v'=>8),
                21 => array('name' => 'goodluck', 'field' => 'goodluck', 'bs' => 0, 'coordinate' => array(4, 3),'v'=>1),
                22 => array('name' => '苹果', 'field' => 'bet1', 'bs' => 5, 'coordinate' => array(4, 4),'v'=>4),
                23 => array('name' => '小石榴', 'field' => 'bet4', 'bs' => 2, 'coordinate' => array(4, 5),'v'=>8),
                24 => array('name' => '柠檬', 'field' => 'bet2', 'bs' => 10, 'coordinate' => array(4, 6),'v'=>3),

        );
		return $prize_arr;
	}
	


}
