<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 管理员  控制器 by tangjian 

include 'content.php';

class play_title extends Content
{
    function __construct ()
    {    
        parent::__construct();
            
        $this->control = 'admin';
        $this->baseurl = 'index.php?d=admin&c=play_title';
        $this->table = 'zy_attend_user';
        $this->list_view = 'play_title_list';
        $this->add_view = '';
    }
    


    public function index(){

        $keywords = trim($_REQUEST['keywords']);
		$data['order'] = trim($_REQUEST['order']);
		$data['blacklist'] = trim($_REQUEST['blacklist']);
        $searchsql = '';
		$order_sql =  ' maxtime DESC ';
        //         if ($catid) {
        //             $searchsql .= " AND catid=$catid ";
        //         }
        // 是否是查询
        if (empty($keywords)) {
            $config['base_url'] = $this->baseurl . "&m=index&catid=$catid";
        } else {
            $searchsql .= " AND (U.openID like '%{$keywords}%' OR U.nickname like '%{$keywords}%' OR U.tel like '%{$keywords}%')";
            $config['base_url'] = $this->baseurl ."&m=index&catid=$catid&keywords=" . rawurlencode($keywords);
        }
		
		if(!empty($data['order'])){
			$config['base_url'] = $config['base_url'] . "&order=".$data['order'];
			if($data['order'] == 'desc'){
				$order_sql =  ' num DESC ';
			}
			if($data['order'] == 'asc'){
				$order_sql =  ' num ASC ';
			}
		}
		
		if($data['blacklist'] != ''){
			$config['base_url'] = $config['base_url'] . "&blacklist=".$data['blacklist'];			
			$searchsql .=  ' AND U.status='.$data['blacklist'] ;	
		}
		 


        $query = $this->db->query("SELECT COUNT(*) AS num FROM $this->table U WHERE 1 $searchsql");
        $count = $query->row_array();
        $data['count'] = $count['num'];
        $config['total_rows'] = $count['num'];
        $config['per_page'] = 20;
        $this->load->library('pagination');
        $this->pagination->initialize($config);
        $data['pages'] = $this->pagination->create_links();
        $offset = $_GET['per_page'] ? intval($_GET['per_page']) : 0;
        $per_page = $config['per_page'];
		
		
		$sql_user="SELECT MAX(score) AS  score,MAX(L.`addtime`) AS maxtime,MIN(L.`addtime`) AS mintime,COUNT(*) AS num,user_id,U.`openID`,U.`nickname`,U.`head_img`,U.sex FROM zy_attend_log L,zy_attend_user U WHERE L.`user_id`=U.`id` $searchsql GROUP BY user_id  ORDER BY $order_sql  limit $offset,$per_page";
		$user = $this->db->query($sql_user);
        $user= $user->result_array();
		
      /*  $sql_user="select * from zy_attend_user WHERE $searchsql  order by id limit $offset,$per_page";
        $user = $this->db->query($sql_user);
        $user= $user->result_array();


        $sql="select * from zy_attend_log  order by id ";
        $query = $this->db->query($sql);
        $list= $query->result_array();
       // print_r($list);exit;
        $arr=array();
        $sql="SELECT MAX(score) AS  score,MAX(addtime) as logtime,COUNT(*) AS num,user_id FROM zy_attend_log  GROUP BY user_id  ORDER BY addtime DESC  limit $offset,$per_page";
        $query = $this->db->query($sql);
        $list= $query->result_array();

        foreach($list as &$v){
            foreach($user as $key=>$val){
                if($val['id']==$v['user_id']){
                     $v['nickname']=$val['nickname'];
                     $v['openID']=$val['openID'];
                     $v['addtime']=$val['addtime'];
                     $v['head_img']=$val['head_img'];
                     $v['sex']=$val['sex'];
                 }
            }

        }*/
       // print_r($list);exit;
       //print_r($user);exit;
	   //游戏总记录数
	    $query = $this->db->query("SELECT COUNT(*) AS num FROM zy_attend_log where user_id IN(select id from zy_attend_user U where 1=1  $searchsql) ");
        $count = $query->row_array();
        $data['count_log'] = $count['num'];
		$data['vga'] =  ceil($data['count_log']/$data['count']) ;
    	$data['list']=$user;

        $this->load->view('admin/' . $this->list_view, $data);
    }

}
