<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 管理员  控制器 by tangjian 

include 'content.php';

class resources extends Content
{
    function __construct ()
    {    
        parent::__construct();
            
        $this->control = 'resources';
        $this->baseurl = 'index.php?d=admin&c=resources';
        $this->table = 'zy_gamelist_resources';
        $this->list_view = 'game_resources_list';
        $this->add_view = 'game_resources_add';		
        $this->ReType = array(
                            0 => '图片',
                            1 => '音乐',
                            2 => '其他',
                        );
	 $RoomID = intval($_GET['RoomID']);					
	 $room = $this->my_common_model->get_room_list($RoomID); 
	 $this->uploadpath = $room['Folder'];						
    }
    
    // 首页
    public function index ()
    {
        $keywords = trim($_REQUEST['keywords']);
        $data['RoomID'] = intval($_GET['RoomID']);
		$RepID = trim($_REQUEST['RepID']);
		
        $searchsql = ' RoomID = '.$data['RoomID'].' and IsBase = 1';
        //         if ($catid) {
        //             $searchsql .= " AND catid=$catid ";
        //         }
        // 是否是查询
        if (empty($keywords)) {
            $config['base_url'] = $this->baseurl . "&m=index&RepID=$RepID&RoomID=". $data['RoomID'];
        } else {
        $searchsql .= " AND (`ReName` like '%{$keywords}%' OR `VarName` like '%{$keywords}%')";
        $config['base_url'] = $this->baseurl ."&m=index&keywords=" . rawurlencode($keywords)."&RepID=$RepID&RoomID=". $data['RoomID'];
        }

        $this->baseurl .= "&RepID=$RepID&RoomID=". $data['RoomID'];
        
        $data['list'] = array();
        $query = $this->db->query(
        "SELECT COUNT(*) AS num FROM $this->table WHERE  $searchsql");
        $count = $query->row_array();
        $data['count'] = $count['num'];
        $this->load->library('pagination');
        
        $config['total_rows'] = $count['num'];
        $config['per_page'] = 20;
        $this->pagination->initialize($config);
        $data['pages'] = $this->pagination->create_links();
        $offset = $_GET['per_page'] ? intval($_GET['per_page']) : 0;
        $per_page = $config['per_page'];
        $sql = "SELECT * FROM $this->table WHERE  $searchsql ORDER BY ReID ASC limit $offset,$per_page";
        $query = $this->db->query($sql);
        $data['list'] = $query->result_array();

        $data['ReType'] = $this->ReType;

        $_SESSION['url_forward'] =  $config['base_url']. "&per_page=$offset"."&RepID=$RepID&RoomID=".$data['RoomID'];
        $this->load->view('admin/' . $this->list_view, $data);
    }

    // 添加
    public function add ()
    {
        $data['RoomID'] = intval($_GET['RoomID']);
        $data['ReType'] = $this->ReType;
        $this->load->view('admin/' . $this->add_view,$data);
    }
    
    // 编辑
    public function edit ()
    {
        $id = intval($_GET['ReID']);
        $data['RoomID'] = intval($_GET['RoomID']);
        // 这条信息
        $query = $this->db->get_where($this->table, 'ReID = ' . $id, 1);
        $value = $query->row_array();
        $data['value'] = $value;
        $data['ReID'] = $id;
        $data['ReType'] = $this->ReType;
        $this->load->view('admin/' . $this->add_view, $data);
    }
	
	// 复制
    public function copyre ()
    {
        $id = intval($_GET['ReID']);
        $data['RoomID'] = intval($_GET['RoomID']);
        // 这条信息
        $query = $this->db->get_where($this->table, 'ReID = ' . $id, 1);
        $value = $query->row_array();
        $data['value'] = $value;
       // $data['ReID'] = $id;
        $data['ReType'] = $this->ReType;
        $this->load->view('admin/' . $this->add_view, $data);
    }
	
	
    // 保存 添加和修改都是在这里
    public function save ()
    {
        $id = intval($_POST['ReID']);
        $data = trims($_POST['value']);
        $data['UpdateTime'] = time();
        $data['UID'] = $this->session->userdata('UID');
		if(empty($data['ReSrc'])){
			show_msg('资源路径必填！');
		}
        if(file_exists($data['ReSrc'])){
            $data['ReSize'] = formatBytes(filesize($data['ReSrc']));
        }
        if ($id) { // 修改 ===========
			//修改IsEdit字段
			$where = array('RoomID'=>trims($data['RoomID']), 'VarName'=>trims($data['VarName']));
			$query = $this->db->update($this->table, array('IsEdit'=>$data['IsEdit']), $where);
			
            $this->db->where('ReID', $id);
            $query = $this->db->update($this->table, $data);
            show_msg('修改成功！',$_SESSION['url_forward']);
        } else { // ===========添加 ===========
            $data['IsBase'] = 1;
            $query = $this->db->insert($this->table, $data);
            show_msg('添加成功！',$_SESSION['url_forward']);
        }
    }
    
    // 删除
    public function delete ()
    {
        $id = $_GET['ReID'];
        
        
        if ($id) {
            $this->db->query("delete from $this->table where ReID=$id");
        } else {
            $ids = implode(",", $_POST['delete']);
            $this->db->query("delete from $this->table where ReID in ($ids)");
        }
        show_msg('删除成功！', $_SESSION['url_forward']);
    }
	
	function import(){
		$data['RoomID'] = intval($_GET['RoomID']);        
		$this->load->view('admin/import_view', $data);
	}
	
	function import_save(){
		$urls = $_POST['url'];
		$url_names = explode(',', $urls);
		$res_num = 0; //新增个数
		$repeat_num = 0; //重复个数
		$update_num = 0; //更新个数
		foreach($url_names as $names){
			$data = array();
			if(empty($names)) continue;
			$names_arr = explode(':', trim($names) );			
			$data['ReName'] = $names_arr[0];
			$data['VarName'] = $names_arr[0];			
			$data['RoomID'] = $_POST['RoomID'];
			
			$ReSrc = str_replace('"', '',  trim($names_arr[1]));
			
			$file_ext = substr($ReSrc, strrpos($ReSrc, '.')+1);
			$images = array(
                'gif',
                'jpg',
                'jpeg',
                'png',
                'bmp'
        	);
			$music = array(
                'swf',
                'flv',
                'mp3',
                'wav',
                'wma',
                'wmv',
                'mid',
                'avi',
                'mpg',
                'asf',
                'rm',
                'rmvb'
        	);
			$data['ReType'] = 2;
			if(in_array($file_ext, $images)) $data['ReType'] = 0;
			if(in_array($file_ext, $music)) $data['ReType'] = 1;
			
			$data['ReSrc'] = 'static/gameroom/'.$this->uploadpath .'/'.$ReSrc ;
			$data['UpdateTime'] = time();
       		$data['UID'] = $this->session->userdata('UID');
			if(file_exists($data['ReSrc'])){
				$data['ReSize'] = formatBytes(filesize($data['ReSrc']));
			}			
			$data['IsBase'] = 1;
			//判断重复
			$query = $this->db->get_where($this->table, array('RoomID'=>$data['RoomID'], 'VarName'=>$data['VarName']), 1);
        	$value = $query->row_array();
			if($value){
				if($value['ReSrc'] == $data['ReSrc']){
					$repeat_num++;
					
				}else{
					$where = array('RoomID'=>$data['RoomID'], 'VarName'=>trims($data['VarName']));
					$query = $this->db->update($this->table, array('ReSrc'=>$data['ReSrc']), $where);
					$update_num++;
				}
				continue;
			}
			
            $query = $this->db->insert($this->table, trims($data));			
			$res_num ++;
		}
		
		 show_msg('一共成功导入'.$res_num.'个资源,重复'.$repeat_num.',更新'.$update_num.'个！',$_SESSION['url_forward']);
	}
    

    
}
