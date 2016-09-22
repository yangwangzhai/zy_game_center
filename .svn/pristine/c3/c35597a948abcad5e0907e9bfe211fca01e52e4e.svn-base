<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 管理员  控制器 by tangjian 

include 'content.php';

class Attachment extends Content
{
    function __construct ()
    {    
        parent::__construct();
            
        $this->control = 'admin';
        $this->baseurl = 'index.php?d=admin&c=attachment';
        $this->table = 'zy_attachment';
        $this->list_view = 'attachment_list';        
		$this->load->model('content_model'); 
     	$this->content_model->set_table( $this->table );
    }
    


    public function index(){			
		$keywords = trim($_REQUEST['keywords']);
		$searchsql = '1';	
		 // 是否是查询
        if (empty($keywords)) {
            $config['base_url'] = $this->baseurl . "&m=index";
        } else {
            $searchsql .= " AND (file_name like '%{$keywords}%' OR filepath like '%{$keywords}%' OR updateIP like '%{$keywords}%')";
            $config['base_url'] = $this->baseurl ."&m=index&keywords=" . rawurlencode($keywords);
        }
		$data['count'] = $this->content_model->get_count($searchsql);
		$config['total_rows'] = $data['count'] ;
        $config['per_page'] = $this->per_page;
        $this->load->library('pagination');
        $this->pagination->initialize($config);
        $data['pages'] = $this->pagination->create_links();
        $offset = $_GET['per_page'] ? intval($_GET['per_page']) : 0;
        $per_page = $config['per_page'];
		$result = $this->content_model->get_list('*', $searchsql, 'id DESC',  $offset);	
		foreach($result as $key=> $val){
			$sql = "SELECT * FROM zy_attachment_log WHERE attachment_id =".$val['id'];
			$crond =  $this->db->query( $sql )->result_array();	
			$result[$key]['updateIP'] = '';
			$result[$key]['updatetime'] = '';
			foreach($crond as $v){
				$result[$key]['updateIP'] .= $v['fromIP'] . '<br>';
				$result[$key]['updatetime_time'] = date('Y-m-d H:i:s',$v['addtime']) . ',';
				$result[$key]['updatetime'] = timeFromNow($v['addtime']) . '<br>';
			}
			if(file_exists($val['filepath'])){ 
				$result[$key]['updateIP'] = rtrim($result[$key]['updateIP'], '<br>');
				$result[$key]['updatetime'] = rtrim($result[$key]['updatetime'], '<br>');
			}else{
				$result[$key]['updateIP'] = '<font color="#FF0000">文件不存在</font>';
			}
			
		}
        $data['list'] = $result;
			 
        $_SESSION['url_forward'] =  $config['base_url']. "&per_page=$offset";
        $this->load->view('admin/' . $this->list_view, $data);
    }
	
	
	
	
	 // 删除
    public function delete ()
    {
        $id = $_GET['id'] ? $_GET['id'] : $_POST['delete'];
		if(empty($id))     show_msg('请选择要删除的数据！', $_SESSION['url_forward']);  
		$row = $this->content_model->delete($id, 'id');   
        if ($row) {
            show_msg('删除成功！', $_SESSION['url_forward']);
        } else {
            show_msg('删除失败！', $_SESSION['url_forward']);
        }		
        
    }

}
