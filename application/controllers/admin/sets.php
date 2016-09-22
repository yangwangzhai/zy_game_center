<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 管理员  控制器 by tangjian 

include 'content.php';

class sets extends Content
{
    function __construct ()
    {    
        parent::__construct();
            
        $this->control = 'admin';
        $this->baseurl = 'index.php?d=admin&c=sets';
        $this->table = 'zy_user';
        $this->list_view = 'sets_list';
        $this->add_view = 'admin_add';
    }
    


    public function index(){
		echo zy_a('channel_list', '链接', 'index.php?d=admin&c=admin&m=index', 'onclick="return confirm(\'确定要删除吗？\');"') . '<br>';
		echo zy_li('channel_list','删除') . '<br>';
		echo zy_btn('channel_list',' + 添加','  onclick="location.href=\'index.php?d=admin&c=group&m=add\'" ') . '<br>';;
		
       
        $_SESSION['url_forward'] =  $config['base_url']. "&per_page=$offset";
        $this->load->view('admin/' . $this->list_view, $data);
    }

}
