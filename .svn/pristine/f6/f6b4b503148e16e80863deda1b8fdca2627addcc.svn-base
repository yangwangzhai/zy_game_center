<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>登录 - 后台管理系统</title>
<link rel="stylesheet" href="static/system/admin_img/admincp.css" type="text/css" media="all" />
<link rel="stylesheet" href="static/system/js/kindeditor410/themes/default/default.css" />
<link rel="stylesheet" type="text/css"	href="static/system/css/font-awesome.min.css" />
<link rel="stylesheet" type="text/css"	href="static/system/css/font-awesome-ie7.min.css" />
<script type="text/javascript" src="static/system/js/jquery-1.7.1.min.js"></script>
<script charset="utf-8" src="static/system/js/kindeditor410/kindeditor.js?aa"></script>
<script type="text/javascript" src="static/system/js/lhgdialog/lhgdialog.min.js?skin=idialog"></script>
<script charset="utf-8" src="static/system/js/kindeditor410/lang/zh_CN.js"></script>
<script type="text/javascript" src="static/system/js/common.js?23974928734"></script>
<meta content="tangjianft@qq.com" name="Copyright" />

<style>
#breadcrumbs-one{
  background: #eee;
  border-width: 1px;
  border-style: solid;
  border-color: #f5f5f5 #e5e5e5 #ccc;
  border-radius: 5px;
  box-shadow: 0 0 2px rgba(0,0,0,.2);
  overflow: hidden;
  width: 400px;
}
 
#breadcrumbs-one li{
  float: left;
}
 
#breadcrumbs-one a{
  padding: .7em 1em .7em 2em;
  float: left;
  text-decoration: none;
  color: #444;
  position: relative;
  text-shadow: 0 1px 0 rgba(255,255,255,.5);
  background-color: #ddd;
  background-image: linear-gradient(to right, #f5f5f5, #ddd); 
}
 
#breadcrumbs-one li:first-child a{
  padding-left: 1em;
  border-radius: 5px 0 0 5px;
}
 
#breadcrumbs-one a:hover{
  background: #fff;
}
 
#breadcrumbs-one a::after,
#breadcrumbs-one a::before{
  content: "";
  position: absolute;
  top: 50%;
  margin-top: -1.5em;  
  border-top: 1.5em solid transparent;
  border-bottom: 1.5em solid transparent;
  border-left: 1em solid;
  right: -1em;
}
 
#breadcrumbs-one a::after{
  z-index: 2;
  border-left-color: #ddd; 
}
 
#breadcrumbs-one a::before{
  border-left-color: #ccc; 
  right: -1.1em;
  z-index: 1;
}
 
#breadcrumbs-one a:hover::after{
  border-left-color: #fff;
}
 
#breadcrumbs-one .current,
#breadcrumbs-one .current:hover{
  font-weight: bold;
  background: none;
}
 
#breadcrumbs-one .current::after,
#breadcrumbs-one .current::before{
  content: normal; 
}

a,img{border:0;}   
body{font:12px/180% Arial, Helvetica, sans-serif, "新宋体";}   
/* demo */   
.demo{width:600px;margin:100px auto;background:#f0f0f0;position:relative;}   
.demo ul{height:32px;}   
.demo li{float:left;width:200px;text-align:center;position:relative;z-index:2;font-weight:bold;font-size:14px;line-height:32px;}   
.demo li em{position:absolute;right:-24px;top:-8px;width:0;height:0;line-height:0;border-width:24px 0 24px 24px;border-color:transparent transparent transparent #fff;border-style:dashed dashed dashed solid;}   
.demo li i{position:absolute;right:-16px;top:0;width:0;height:0;line-height:0;border-width:16px 0 16px 16px;border-color:transparent transparent transparent #f0f0f0;border-style:dashed dashed dashed solid;}   
.demo li.current{background:#56a2cf;color:#fff;z-index:1;}   
.demo li.current i{border-color:transparent transparent transparent #56a2cf;}   



    .dropDown{display:inline-block}.dropDown_A{display:inline-block}
    .dropDown-menu{ display:none;transition: all 0.3s ease 0s}
    .dropDown:focus,.dropDown-menu:focus {outline:0}
    	.dropDown-menu li.arrow{ position:absolute;display:block; width:12px; height:8px; margin-top:-13px; margin-left:20%; line-height:0;background:url(../images/icon-jt.png) no-repeat 0 0}
     
    /*鼠标经过	*/
    .dropDown.hover.dropDown_A,.dropDown.open.dropDown_A{text-decoration:none;background-color:rgba(255,255,255,0.2)}
    .dropDown.open.dropDown_A.menu_dropdown-arrow{transition-duration:0.3s ;transition-property:all;_background-position:0 0}
    .dropDown.open.dropDown_A.menu_dropdown-arrow{transform: rotate(180deg);}
    	.menu{background-color:#fff;border:solid 1px #f2f2f2; display: inline-block;}
    	.menu.radius{border-top-left-radius:0;border-top-right-radius:0}
    	.menu.box-shadow{border-top:none;}
    	.menu > li{ position: relative; float: none;display:block;}
    	.menu > li > a{ display: block;clear: both;border-bottom:solid 1px #f2f2f2;padding:6px 20px;text-align:left;line-height:1.5;font-weight: normal;white-space:nowrap}
    	.menu > li:last-child > a{ border-bottom:none}
    	.menu > li > a:hover,.menu > li > a:focus,.menu > li.open > a{ text-decoration:none;background-color:#fafafa}
    	.menu > li > a.arrow{ position:absolute; top:50%; margin-top:-10px; right:5px;line-height: 20px; height: 20px; color: #999}
    	.menu > li >.menu{ display: none}
    	.menu > li.open >.menu{ display: inline-block;position: absolute; left:100%;top:-1px;min-width:100%;}
    	/*禁用菜单*/
    	.menu > li.disabled > a{color:#999;text-decoration:none; cursor:no-drop; background-color:transparent}
    	/*线条*/
    	.menu > li.divider{ display:block;height:0px; line-height:0px;margin:9px 0;overflow:hidden; border-top:solid 1px #eee}
    /*打开菜单*/
    .dropDown >.dropDown-menu{ display: none}
    .dropDown.open{position:relative;z-index:990}
    /*默认左对齐*/
    .dropDown.open >.dropDown-menu{position:absolute;z-index:1000;display:inline-block;top:100%;left:-1px;min-width:100%;background-color:#fff;border:solid 1px #f2f2f2}
    /*右对齐*/
    .dropDown.open.right >.dropDown-menu{right:-1px!important;left:auto!important}
</style>
<script type="text/javascript" src="http://static.h-ui.net/h-ui/js/H-ui.js"></script> 
</head>

<body>

<ul style="display:none;" id="breadcrumbs-one">
    <li><a href="">Lorem ipsum</a></li>
    <li><a href="">Vivamus nisi eros</a></li>
    <li><a href=""  class="current">Nulla sed lorem risus</a></li>
    
</ul>

<div style="display:none;" class="demo">  
<ul class="clearfix">  
<li>面包屑一<em></em><i></i></li>  
 
<li class="current"><span class="dropDown dropDown_hover"><a href="#" class="dropDown_A">经过菜单</a>
					<ul class="dropDown-menu menu radius box-shadow">
						<li class=""><a href="#">菜单一</a></li>
						<li><a href="#">菜单二</a></li>
					</ul>
					</span>
<em></em>


   

<i></i></li>  
</ul>  
</div>  