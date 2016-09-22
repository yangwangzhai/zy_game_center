<?php $this->load->view('admin/header');?>
<script type="text/javascript">
$(function($)
{
	// 数据列表 点击开始排序
	var sortFlag = 0;	
	$("#sortTable th").click(function()
	{		
		var tdIndex = $(this).index();		
		var temp = "";
		var trContent = new Array();
		//alert($(this).text());	
		
		// 把要排序的字符放到行的最前面，方便排序
		$("#sortTable .sortTr").each(function(i){ 
			temp = "##" + $(this).find("td").eq(tdIndex).text() + "##";			
			trContent[i] = temp + '<tr class="sortTr">' + $(this).html() + "</tr>";	
				
		});
		
		// 排序
		if(sortFlag==0) {
			trContent.sort(sortNumber);
			sortFlag = 1;
		} else {
			trContent.sort(sortNumber);
			trContent.reverse();
			sortFlag = 0;
		}
		
		// 删除原来的html 添加排序后的
		$("#sortTable .sortTr").remove();
		$("#sortTable tr").first().after( trContent.join("").replace(/##(.*?)##/, "") );		
	});
	
});
function show_ewm(url, filename){
	var content = '<img width="" src="ewm/' + filename + '" /><br><p style="text-align: left; width: 250px;">'+url + '</p>';
	var title = '扫二维码进入游戏';
	var w = 300;
	var h = 200;
	dialog(content,title,w,h);
}


</script>

<div class="form-inline" style="padding:10px;">
	
		<form action="<?=$this->baseurl?>&m=index" method="post">
			<div class="form-group">
            
              <span class="input-icon">
                                                            <input type="text" name="keywords"  value="" class="form-control input-sm">
                                                            <i class="glyphicon glyphicon-search blue"></i>
                                                           
                                                        </span>
            </div>
            <div class="form-group"><input type="submit" name="submit" value=" 搜索 " class="btn btn-blue"></div>
             <div class="form-group"> <?=zy_btn('GameRoom_add',' + 添加游戏 ','class="btn btn-success"  onclick="location.href=\'index.php?d=admin&c=gameRoom&m=add\'" ');?></div>
		</form>
	
  
    
</div>  	<form action="<?=$this->baseurl?>&m=delete" method="post">
<div style="padding:0 10px;">
<?php 
	 foreach($list as $key=>$r) {?>  
           
<div class="col-lg-6 col-sm-6 col-xs-12">
<div class="widget">
<div class="well with-header">
<div class="header bordered-blue"><span style="float: right;">
    <i class="fa fa-folder"><?=zy_a('GameRegTable_view','资源','index.php?d=admin&c=gameRegTable&RoomID='.$r['RoomID']);?></i>
    <i class="fa fa-navicon"><?=zy_a('GameRegNav_view','导航','index.php?d=admin&c=gameRegNav&RoomID='.$r['RoomID']);?></i>
    <i class="fa fa-puzzle-piece"><?=zy_a('GameopeningAPI_view','接口','index.php?d=admin&c=gameopeningAPI&RoomID='.$r['RoomID']);?></i>
    <i class="fa fa-edit"><?=zy_a('GameRoom_update','修改',$this->baseurl.'&m=edit&RoomID='.$r['RoomID']);?></i>
    <i class="fa fa-trash"><?=zy_a('GameRoom_del','删除',$this->baseurl.'&m=delete&RoomID='.$r['RoomID'],'onclick="return confirm(\'确定要删除吗？\');"');?></i>
     <i class="fa fa-hand-o-right"><a style="cursor:pointer;" onclick="show_ewm('<?=$r['PlayUrl']?>', '<?=$r['FileName']?>')">试玩</a></i>
    </span><strong><?=$r['GameName']?></strong></div>   
<div >
</div> 
<div class="gamelist_body">   
<div class="gamelist">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200" rowspan="11" class="noborder"><?php $patharr = explode('|', $r['ScreenImages']);?>
					<img onclick="urlDialogCus('index.php?d=admin&c=vPics&path=<?=$r['ScreenImages']?>','游戏截图',800,600)" src="<?=$patharr[0]?>" width="220" class="gameimg"/></td>
    <td>ID库：<?=$r['RoomID']?></td>
  </tr>
  <tr>
    <td>游戏名称：<?=$r['GameName']?></td>
  </tr>
  <tr>
    <td>游戏类型：<?=$GameType[$r['GameType']]?></td>
  </tr>
  <tr>
    <td>游戏版本：<?=$r['Version']?></td>
  </tr>
  <tr>
    <td>被使用数：<?=$r['ActiveUseNum']?>次</td>
  </tr>
  <tr>
    <td>访问总数：<?=$r['VistNum']?>   次  
    </td>
  </tr>
  <tr>
    <td>游戏状态：<?php $Status = array(0=>'测试',1=>'开放',2=>'停用',3=>'维护中');?>
					<?=$Status[$r['Status']]?></td>
  </tr>
  <tr>
    <td>游戏备注：
    <?php 
	$Remark = str_cut($r['Remark'], 100 , '...');
	if (strpos($Remark, '...') !== false) { 
	
		echo str_cut(strip_tags($r['Remark']), 100 , '...')?>
    	
      <a href="javascript:;" onclick="dialog('<?=urlencode($r['Remark'])?>','游戏备注',500,300,true)" >详细</a>
   <?php }else{ echo $Remark; 
   	}?>
    
    
    </td>
  </tr>
  <tr>
    <td>游戏介绍：<?php $GameResume = str_cut($r['GameResume'], 100 , '...');?>
    <?php if (strpos(str_cut($r['GameResume'], 100 , '...'), '...') !== false) {
		echo str_cut(strip_tags($r['GameResume']), 100 , '...')?>
		
    <a href="javascript:;" onclick="dialog('<?=urlencode($r['GameResume'])?>','游戏介绍',500,300,true)" >详细</a>
       <?php }else{ echo $GameResume; }?>
    </td>
  </tr>
  <tr>
    <td class="noborder">最近更新：<?=getUserName($r['UID'])?>,<?=timeFromNow($r['UpdateTime'])?></td>
  </tr>
   <tr>
    <td class="noborder"></td>
  </tr>
</table>
</div>
</div>
</div>
</div>
</div>
<?php }?>
</div>
</form>




<?php $this->load->view('admin/footer');?>