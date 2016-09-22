<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 管理员  控制器 by tangjian 

include 'content.php';

class Concern_tj extends Content
{
    function __construct ()
    {    
        parent::__construct();           
        $this->control = 'concern_tj';
        $this->baseurl = 'index.php?d=admin&c=concern_tj';
        $this->table = 'zy_gamelist_user';
        $this->list_view = 'concern_tj_view';
        $this->load->model('content_model'); 
     	$this->content_model->set_table( $this->table );  
    }
    
    // 首页
    public function index ()
    {
        $type = $_REQUEST['type'] ? trim($_REQUEST['type']) : 'channel';
		$timetype = $_REQUEST['timetype']? trim($_REQUEST['timetype']) : '7days';
		$year =  $_REQUEST['year'] ? trim($_REQUEST['year']) : date('Y');
		$month =  $_REQUEST['month'] ? trim($_REQUEST['month']) : date('m');
		$showtype = $_REQUEST['showtype'] ? trim($_REQUEST['showtype']) : 'a';
		if($year < date('Y')) {
			$data['months'] = 12;
		}else{
			$data['months'] = date('m');
		}
		
		$data['type'] = $type;
		$data['timetype'] = $timetype;
		$data['year'] = $year;
		$data['month'] = $month;
		$data['showtype'] = $showtype;
		$sql_arr = array();
		//近七天的统计
		if($timetype == '7days'){
			for($i = 6; $i >= 0; $i--){
					if($i == 0){
						$categories[] = date('m-d',time());
						$dates =  date('Y-m-d',time());
					}else{
						$categories[] = date('m-d',strtotime('-'.$i.' day'));
						$dates =  date('Y-m-d',strtotime('-'.$i.' day'));
					}
				$start_time = strtotime($dates . " 00:00:00");
				$end_time = strtotime($dates . " 23:59:59");
				$sql_arr [] = " AddTime between $start_time and  $end_time ";	
			}
		}else{ 
			//自定义按年份所有月份的统计
			if($month == -1){
				for($m =1;$m<=$data['months'];$m++ ){
					$dates =  date($year.'-'.$m.'-01');
					$month_last_date = date('Y-m-d', strtotime("$dates +1 month -1 day"));//月的最后一天
					
					$categories[] = $year.'-'.$m.'';	
					
					$start_time = strtotime($dates . " 00:00:00");
					$end_time = strtotime($month_last_date . " 23:59:59");
					$sql_arr [] = " AddTime between $start_time and  $end_time ";	
				}
				
			}else{
				//自定义按年份选择的月份的天数的统计
				 $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
				 for($i = 1; $i <= $days; $i++){
					$dates = $year . '-' . $month . '-' . $i; 
					$categories[] = $year . '-' . $month . '-' . $i; ;	
					$start_time = strtotime($dates . " 00:00:00");
					$end_time = strtotime($dates . " 23:59:59");
					$sql_arr [] = " AddTime between $start_time and  $end_time ";	
				}
				
			}
			
			
		}
		
		$data['categories'] = $categories;
			
		
		if($type == 'channel'){			
			$sql = "SELECT * FROM zy_channel_main  ";
			$query = $this->db->query($sql);
			$list = $query->result_array();
			$series = "";
			foreach($list as $val){	
				$series .= "{";	
				$series .= "name: '".$val['ChannelName']."',";
				$series .= "data: [";	
				foreach($sql_arr as $sql){
					 $sql .= ' AND ChannelID='.$val['ChannelID'];				
					 $count = $this->content_model->get_count( $sql );
					 $series .= $count . ',';
				}
				
				$series .= "]},";
			}
			
			$data['series'] = rtrim($series, ',');
		}elseif($type == 'active'){
			
			$sql = "SELECT * FROM zy_active_main WHERE Status in(1,2) ";
			$query = $this->db->query($sql);
			$list = $query->result_array();
			$series = "";
			foreach($list as $val){	
				$series .= "{";	
				$series .= "name:'".$val['ActiveName']."',";
				$series .= "data: [";	
				foreach($sql_arr as $sql){
					 $count = $this->content_model->get_count($sql . ' AND ActiveID='.$val['ActiveID']);
					 $series .= $count . ',';
				}
				
				$series .= "]},";
			}
			
			$data['series'] = $series;
			
		}elseif($type == 'room'){			
			
			$sql = "SELECT * FROM zy_game_room  ";
			$query = $this->db->query($sql);
			$list = $query->result_array();
			$series = "";
			foreach($list as $val){	
				$series .= "{";	
				$series .= "name:'".$val['GameName']."',";
				$series .= "data: [";	
				foreach($sql_arr as $sql){
					 $sql .= ' AND GameID IN(SELECT GameID FROM zy_active_game WHERE RoomID='.$val['RoomID'].')';
					 $count = $this->content_model->get_count( $sql );
					 $series .= $count . ',';
				}
				
				$series .= "]},";
			}
			
			$data['series'] = $series;
			
		}
		
		
        $data['title'] = '游戏关注统计';
        $this->load->view('admin/' . $this->list_view, $data);
    }

   

    
}
