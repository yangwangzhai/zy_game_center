<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');
    
    // 图组查看器  控制器 by tangjian 

include 'content.php';

class vPics extends Content
{
    function __construct ()
    {    
        parent::__construct();
            
        $this->control = 'vPics';
        $this->baseurl = 'index.php?d=admin&c=vPics';
        $this->list_view = 'vPics_list';
    }
    
    // 首页
    public function index ()
    {
        $path = trim($_REQUEST['path']);

        $data['path_arr'] = explode('|', $path);

        
        $this->load->view('admin/' . $this->list_view, $data);
    }

    
    
}
