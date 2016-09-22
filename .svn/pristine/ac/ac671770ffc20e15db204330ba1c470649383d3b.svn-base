<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 管理员  控制器 by tangjian 

include 'content.php';

class Game_visit_tj extends Content
{
    function __construct ()
    {    
        parent::__construct();    
        $this->control = 'Game_visit_tj';
        $this->baseurl = 'index.php?d=admin&c=game_visit_tj';
        $this->table = 'zy_game_log';
        $this->list_view = 'Game_visit_tj_list1';
        $this->add_view = 'Game_visit_tj_add';
        $this->load->model('content_model'); 
        $this->content_model->set_table( $this->table );
    }
    
    // 首页
    public function index ()
    {

        /*$searchsql = '1';

        $categories = array();

        $data['subtitle'] = '近7天访问量';

        //7天内记录
        $res = $this->db->query("SELECT RoomID, DATE_FORMAT(FROM_UNIXTIME(AddTime),'%m月%d') day, count(*) num FROM $this->table WHERE UNIX_TIMESTAMP(date_sub(curdate(), INTERVAL 7 DAY)) <= AddTime Group By RoomID,day")->result_array();

        for($i = 6; $i >= 0; $i--){
            if($i == 0){
                $categories[] = date('m月d',time());
            }else{
                $categories[] = date('m月d',strtotime('-'.$i.' day'));
            }
            
        }
        $data['categories'] = $categories;


        //获取游戏
        $game_data = $this->db->query('SELECT RoomID,GameName FROM zy_game_room')->result_array();

        $series = array();

        foreach ($game_data as $k => $v) {
            $series[$k]['name'] = $v['RoomID'];
            foreach ($categories as $ck => $c) {
                $series[$k]['data'][$ck] = 0;
                foreach ($res as $r) {
                    if($v['RoomID'] == $r['RoomID']){
                        //list($m,$d) = explode('月', $c);
                        //echo $r['day'],',',$d;exit();
                        if($c == $r['day']){
                            $series[$k]['data'][$ck] = intval($r['num']);
                        }
                    }
                }
            }
        }

        $data['series'] = $series;

        $_SESSION['url_forward'] =  $config['base_url'];
        $this->load->view('admin/' . $this->list_view, $data);*/

        //$data['count'] = $this->content_model->get_count($searchsql);
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
                     $count = $this->content_model->get_count($sql . ' AND RoomID='.$val['RoomID']);
                     $series .= $count . ',';
                }
                
                $series .= "]},";
            }
            
            $data['series'] = $series;
            
        }
        
        $data['title'] = '游戏访问统计';
        $_SESSION['url_forward'] =  $config['base_url']. "&per_page=$offset";
        $this->load->view('admin/' . $this->list_view, $data);
    }

    function add(){
        
        
        $years = array(2015,2016);      
        foreach($years as $y){
            $this->get_days_by_year($y);
        }
        
        
        
    }

    //根据年份计算每个月的天数
function get_days_by_year($year){
    //首先判断闰年
    if($year%400 == 0  || ($year%4 == 0 && $year%100 !== 0)){
        $rday = 29;
    }else{
        $rday = 28;
    } 
    $m = 12;
    if($year == 2016) $m = 7;
    for ($i=1; $i<=$m;$i++){
        if($i==2){
            $days = $rday;
        }else{
            //判断是大月（31），还是小月（30）
            $days = (($i - 1)%7%2) ? 30 : 31;
        }
        for($d = 1 ; $d <= $days ; $d++){           
            $input = array(1, 2);
            $input2 = array(2, 6);  
            $key = rand(0,1);   
            $data['Openid'] =  rand(1000,9999);
            $data['Remark'] = '游戏作弊';
            $data['AddTime'] = strtotime($year . '-'. $i . '-' . $d . ' ' . rand(0,23).':08:08' );
            $data['AddUid'] = 1;
            $data['ChannelID'] = $input[rand(0,1)];
            $data['ActiveID'] = $input2[rand(0,1)];
            $data['RoomID'] = $input[rand(0,1)];
            $this->db->insert('zy_active_blacklist', $data);
        }
        //echo $year."年".$i."月有：".$days."天";
    }
     
}




    
}
