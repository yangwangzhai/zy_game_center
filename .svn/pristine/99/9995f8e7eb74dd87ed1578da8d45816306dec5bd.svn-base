<!DOCTYPE html>
<html>
<head>
<title>【<?=TITLE?>】后台管理中心</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link rel="stylesheet" href="static/admin_img/admincp.css?1"
	type="text/css" media="all" />
<script type="text/javascript" src="static/js/jquery-1.7.1.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    $('.nav li').click(function(){
    	$('.nav li').removeClass();
    	$(this).addClass("tabon");
    	$(".frame_left > ul").hide().eq($('.nav li').index(this)).show();
    });
    
    $('.frame_left a').click(function(){
    	$('.frame_left a').removeClass();			
    	$(this).addClass("on");		
        });
	
	var ids = [0,1,2,3,4,5];	
	$('.nav ul li').each(function(){		
		var id = $(this).data('id');		
		ids.splice(id, 1 , -1);
	})	
   
	for(var i=0;i<ids.length;i++){
		if(ids[i] != -1){			
			$('.frame_left .children_'+ids[i]).remove();
		}
	}
	
});
</script>
<style>
html,body {
	width: 100%;
	height: 100%;
	overflow: hidden;
}
.frame_left ul{
	display:none;
}
</style>
<?php 
$main_li = array( 
			0=> array('name' => '渠道管理', 'psign' => 'qdgl' ),
			1=> array('name' => '活动管理', 'psign' => 'hdgl' ),
			2=> array('name' => '游戏仓库', 'psign' => 'yxck' ),
			3=> array('name' => '安全控制', 'psign' => 'aqkz' ),
			4=> array('name' => '数据统计', 'psign' => 'sjtj' ),
			5=> array('name' => '系统管理', 'psign' => 'xtgl' ),
			 );

?>
</head>
<body scroll="no">
	<div class="mainhd">
		<div class="logo">
			<img src="./static/admin_img/logo.png">
		</div>
		<div class="nav" style="width:auto;">
			<ul>
            
            <?php 
			
			foreach($main_li as $key=>$li){				
				 $li_class = 'class="'.$li['psign'].'" data-id="'.$key.'"';
				echo zy_li($li['psign'], $li['name'], '', '' , $li_class );
			}
			?>
				<!--<li class="tabon">                
                <a href="#">渠道管理</a></li>
             	<li><a href="#">活动管理</a></li>
                <li><a href="#">游戏仓库</a></li>
                <li><a href="#">安全控制</a></li>
                <li><a href="#">数据统计</a></li>
				<li><a href="#">系统管理</a></li>-->
                
                
			</ul>
		</div>
		
		
		
		<div style=" float: right;padding-top: 10px;margin-right: 15px;">
			
			<p>
				欢迎您, <em><?php echo $_SESSION['TrueName']?$_SESSION['TrueName']:$_SESSION['Username'];?></em> 
               <a href="index.php?d=admin&c=admin&m=index&m=edit&id=<?=$this->session->userdata('id')?>" target="main">个人资料</a>
           
                <a href="index.php?d=admin&c=common&m=login_out" target="_top">退出</a>
			</p>
			

		</div>
		
	</div>
    
	<table cellpadding="0" cellspacing="0" width="100%" height="100%">
		<tr>
			<td valign="top" width="160"
				style="background: #F2F9FD; width: 160px; padding-top: 15px;">
				<div class="frame_left">
            
                
					<ul class="children_0">
                    
                    <?php 
					$hdgl = array(
							0=> array('name' => '▪渠道列表', 'psign' => 'Channel_list', 'url' => 'index.php?d=admin&c=sets', 'attr' => 'target="main"'),
							1=> array('name' => '▪积分排行', 'psign' => 'jfph', 'url' => 'index.php?d=admin&c=notice', 'attr' => 'target="main"'),
							2=> array('name' => '▪游戏设置', 'psign' => 'yxsz', 'url' => 'index.php?d=admin&c=game_set', 'attr' => 'target="main"'),
					);
					
					foreach($hdgl as $key=>$li){						
						if($key == 0) $li['attr'] = ' ' . $li['attr'];
						echo zy_li($li['psign'], $li['name'], $li['url'], $li['attr']);
					}
					
					
					?>                   
                      	               
					</ul>

					<ul class="children_1">
                    
                     <?php 
					$hdgl = array(
							0=> array('name' => '▪活动列表', 'psign' => 'Active_list', 'url' => 'index.php?d=admin&c=active', 'attr' => 'target="main"'),
							1=> array('name' => '▪黑名单', 'psign' => 'Black_list', 'url' => 'index.php?d=admin&c=black', 'attr' => 'target="main"'),
								);
					
					foreach($hdgl as $key=>$li){						
						if($key == 0) $li['attr'] = ' ' . $li['attr'];
						echo zy_li($li['psign'], $li['name'], $li['url'], $li['attr']);
					}
					
					
					?>            
                    
                    
                    </ul>
					<ul class="children_2"></ul>
					<ul class="children_3"></ul>
					<ul class="children_4"></ul>					
 					<ul class="children_5">	
 						<?php 
						$hdgl = array(
								0=> array('name' => '▪用户管理', 'psign' => 'Manager_view', 'url' => 'index.php?d=admin&c=admin&m=index', 'attr' => 'target="main"'),
								1=> array('name' => '▪角色管理', 'psign' => 'Group_view', 'url' => 'index.php?d=admin&c=group&m=index', 'attr' => 'target="main"'),
								2=> array('name' => '▪权限列表', 'psign' => 'Privicy_view', 'url' => 'index.php?d=admin&c=privicy&m=index', 'attr' => 'target="main"'),
						);
						
						foreach($hdgl as $key=>$li){						
							if($key == 0) $li['attr'] = ' ' . $li['attr'];
							echo zy_li($li['psign'], $li['name'], $li['url'], $li['attr']);
						}
						
						
						?>			
						<!-- <li><a href="index.php?d=admin&c=admin&m=index" target="main"> ▪用户管理</a></li>                       
						                        <li><a href="./index.php?d=admin&c=group&m=index" target="main"> ▪角色管理</a></li>
						                        <li><a href="./index.php?d=admin&c=privicy&m=index" target="main"> ▪权限列表</a></li> -->
					</ul>                   
				</div>
			</td>

			<td valign="top" height="100%"><iframe
					src="./index.php?d=admin&c=common&m=main" name="main" width="100%"
					height="96%" frameborder="0" scrolling="yes"
					style="overflow: auto;"></iframe></td>
		</tr>
	</table>
</body>
</html>