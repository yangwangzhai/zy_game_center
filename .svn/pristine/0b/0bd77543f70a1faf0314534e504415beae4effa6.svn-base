<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 管理员  控制器 by tangjian 

include 'content.php';

class game_set extends Content
{
    function __construct ()
    {    
        parent::__construct();
            
        $this->control = 'admin';
        $this->baseurl = 'index.php?d=admin&c=game_set';
        $this->table = 'zy_attend_set';      
        $this->add_view = 'game_set_add';
    }
    


    public function index(){
		$query = $this->db->get_where('zy_attend_set', array('id' => 1), 1);
		$row = $query->row_array();
		if($row){		
			$data['value'] = $row;
		}
        $this->load->view('admin/' . $this->add_view, $data);
    }
	function save(){
		$data = $_POST['value'];
        /*$data['bigred'] = intval($data['bigred']);
        $data['smallred'] = intval($data['smallred']);*/
        $data['max_score'] = intval($data['max_score']);
		$id = $_POST['id'];
		$_SESSION['url_forward'] = $this->baseurl ;
		if(! empty($data['max_score'])){
			if($id){
				$this->db->where('id', $id);				
            	$query = $this->db->update($this->table, $data);
            	show_msg('设置成功！', $_SESSION['url_forward']);
        	} else { // ===========添加 ===========
				$data['id'] = 1;            	
            	$query = $this->db->insert($this->table, $data);
            	show_msg('设置成功！', $_SESSION['url_forward']);
        	}
		}else{
            show_msg('设置只能为数字且不能为空！', $_SESSION['url_forward']);
        }
	}

}
