<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 管理员  控制器 by tangjian 

include 'content.php';

class work_title extends Content
{
    function __construct ()
    {    
        parent::__construct();
            
        $this->control = 'admin';
        $this->baseurl = 'index.php?d=admin&c=work_title';
        $this->table = 'zy_attend_user';
        $this->list_view = 'work_title_list';
        $this->add_view = 'admin_add';
    }
    


    public function index(){

        $keywords = trim($_REQUEST['keywords']);
        $searchsql = '';
        $data['isover'] = 0; 
		$data['address'] = trim($_REQUEST['address']);
		$data['received'] = trim($_REQUEST['received']);
		$data['isReceived'] = trim($_REQUEST['isReceived']);
		 //判断活动是否结束
		$query = $this->db->get_where('zy_attend_set', array('isover' => 1), 1);
		$row_set = $query->row_array();
	    if($row_set){			
			  // 是否是查询
			if (empty($keywords)) {
				$config['base_url'] = $this->baseurl . "&m=index&catid=$catid";
			} else {
				$searchsql .= " AND (C.openID like '%{$keywords}%' OR C.nickname like '%{$keywords}%' OR C.tel like '%{$keywords}%' OR C.name like '%{$keywords}%')";
				$config['base_url'] = $this->baseurl ."&m=index&catid=$catid&keywords=" . rawurlencode($keywords);
			}
			
			if($data['address'] != ''){
				$config['base_url'] = $config['base_url'] . "&address=".$data['address'];
				if($data['address'] == '0'){
					$searchsql .= " AND C.tel !='' ";
				}
				if($data['address'] == '1'){
					$searchsql .= " AND (C.tel ='' OR C.tel is NULL)";
				}
			}
			
			if($data['received'] != ''){
				$config['base_url'] = $config['base_url'] . "&received=".$data['received'];				
					$searchsql .= " AND C.received = ".$data['received'];
			}
			
			
			if($data['isReceived'] != ''){
				$config['base_url'] = $config['base_url'] . "&isReceived=".$data['isReceived'];
				if($data['isReceived'] == '0'){
					$searchsql .= " AND C.admin_id !=0 ";
				}
				if($data['isReceived'] == '1'){
					$searchsql .= " AND C.admin_id =0";
				}
			}
			
			$query = $this->db->query("SELECT COUNT(id) AS num FROM zy_attend_user C where C.is_winning !=0 AND C.is_winning !='' $searchsql ");
			$count = $query->row_array();
			$count = intval($count['num']);
			$data['count'] = $count;
			$this->config->load('pagination');
		//	$config = $this->config->item('pagination');			
			$config['total_rows'] =  $count;
			$config['per_page'] = 20;			
			$this->load->library('pagination');
			$this->pagination->initialize($config);
			$data['pages'] = $this->pagination->create_links();
			
			$offset = $_GET['per_page'] ? intval($_GET['per_page']) : 0;
			
			$rank_sql = 'SELECT M.* ,C.admin_id,C.admin_time,C.is_winning,C.nickname,C.id,C.head_img,C.status,C.tel,C.is_winning ,C.address,C.prov,C.city,C.dist,C.name,C.received  FROM ( SELECT A.*,@rank:=@rank+1 AS pm FROM ' ;
			$rank_sql .= ' ( SELECT * FROM ( SELECT *  FROM zy_attend_log ORDER BY score DESC,id ASC) AS b GROUP BY user_id  ORDER BY score DESC,id ASC ';
		//	$rank_sql .= ' ( SELECT  * FROM (SELECT id,user_id,ADDTIME,score as MaxS  FROM  zy_attend_log AS a     WHERE score=(SELECT MAX(b.score)    FROM zy_attend_log AS b  WHERE a.user_id = b.user_id     )   ) AS a   GROUP BY user_id  ORDER BY MaxS DESC,id asc ';
			$rank_sql .= " ) A ,(SELECT @rank:=0) B ) M , zy_attend_user C WHERE M.user_id=C.id AND C.is_winning !=0 AND C.is_winning !='' $searchsql ORDER BY M.pm  limit ". $offset . ",20";
			$query = $this->db->query( $rank_sql );
			$result = $query->result_array();
			
			foreach($result as &$val){
				$admin_id = $val['admin_id'];
				$query = $this->db->query("select truename from zy_admin where id=$admin_id");
				$user = $query->row_array();
				$val['truename'] = $user['truename'];
			}
			
			$data['list'] = $result;
		    $data['isover'] = 1; 
		}else{	   
       	 $data['list']=array();		
		}
        $_SESSION['url_forward'] =  $config['base_url']. "&per_page=$offset";
        $this->load->view('admin/' . $this->list_view, $data);
    }

    public function fahuo(){
        $id= intval($_GET['id']);
        $status = intval($_GET['status']);
		$admin_id = $_SESSION['id'];
		$admin_time = time();
		
		$query = $this->db->query("select admin_id from $this->table where id=$id");
		$user = $query->row_array();
		$val['admin_id'] = $user['admin_id'];
		if(intval($val['admin_id']) > 0){
			  show_msg('已经被确认过！', $_SESSION['url_forward']);
			  return;
		}
		
        if ($id) { // 修改 ===========
            $this->db->where('id', $id);
            $data['admin_id'] = $admin_id;
			$data['admin_time'] = $admin_time;
            $query = $this->db->update($this->table, $data);
           //echo 1111; exit;
            show_msg('确认成功！', $_SESSION['url_forward']);

        }else {
            $ids = implode(",", $_POST['delete']);
            $this->db->query("UPDATE $this->table SET `admin_id` = $admin_id , admin_time = $admin_time WHERE id in ($ids)");
            show_msg('确认成功！', $_SESSION['url_forward']);
        }

    }

    public function over (){
		//删除用户不存在的记录
		$this->db->query('DELETE FROM zy_attend_log WHERE user_id NOT IN(SELECT id FROM zy_attend_user) OR user_id IS NULL');
		$this->db->query('UPDATE  zy_attend_user set is_winning =0');
        $this->db->where('isover',0);
        $data['isover']=1;
        $query = $this->db->update('zy_attend_set', $data);

       if($query){
		   // $order_sql_A = ' SELECT user_id,MAX(score) AS MaxS FROM zy_attend_log  GROUP BY user_id  ORDER BY MaxS   DESC ,id ASC ';
		 //   $order_sql_A = 'SELECT * FROM ( SELECT *  FROM zy_attend_log ORDER BY score DESC,id ASC) AS b GROUP BY user_id  ORDER BY score DESC,id ASC';
          //  $sql="SELECT * FROM  (  SELECT A.*,@rank:=@rank+1 AS pm  FROM     (      $order_sql_A ) A ,(SELECT @rank:=0) B   ) M  limit 1006 ";
            $sql = '  SELECT id,max_score,lasttime,@rank:=@rank+1 AS pm FROM  zy_attend_user ,(SELECT @rank:=0) B WHERE max_score > 0 AND max_score < 350 AND STATUS =0  ORDER BY max_score DESC,lasttime ASC   LIMIT 1006 ';
		  
		    $query = $this->db->query($sql);
            $list = $query->result_array();

        foreach($list as $k=>$v){
             if($v['pm']==1){
                 $data_win['is_winning'] = 1;
             }
            if($v['pm']>1 && $v['pm']<=6 ){
                $data_win['is_winning'] = 2;
            }
            if($v['pm']>6 && $v['pm']<=1005 ){
                $data_win['is_winning'] = 3;
            }

			
            $query_win = $this->db->update($this->table,$data_win,"id =".$v['id']);
        }
           show_msg('成功结束活动！', $this->baseurl);
        //print_r($list);exit;
        }


    }
	
	
	function add(){
		$query = $this->db->get_where('zy_attend_user');
		$list = $query->result_array();
		$j = 0;
		for($i=0;$i<15;$i++){
			foreach($list as $k=>$v){
				$data['openid'] = $v['openid'] . $j;
				$data['sex'] = $v['sex'];
				$data['tel'] = $v['tel'];
				$data['nickname'] = $v['nickname'] . $j;;
				$data['head_img'] = $v['head_img'];				
				$data['addtime'] = time() + $j;
				$query = $this->db->insert('zy_attend_user', $data);
				$j++;
			}
		}
	}
	
	function add_log(){
		$query = $this->db->get_where('zy_attend_user');
		$list = $query->result_array();
		$j = 0;
		for($i=0;$i<10;$i++){
			foreach($list as $k=>$v){				
				$data['user_id'] = $v['id'];
				$data['score'] = rand(10,200);						
				$data['addtime'] = 1456714126 - $j;
				$query = $this->db->insert('zy_attend_log', $data);
				$j++;
			}
		}
	}
	
	
	
}
