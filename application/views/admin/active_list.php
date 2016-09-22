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
	
	
	$( ".menu_list a:nth-child(4n+4)").next().before("<br>");
	
});

function show_ewm(url, filename){
	var content = '<img width="" src="ewm/' + filename + '" /><br><p style="text-align: left; width: 250px;">'+url + '</p>';
	var title = '查看';
	var w = 300;
	var h = 200;
	dialog(content,title,w,h);
}

</script>
<div class="col-xs-12 col-md-12">
<div class="widget">
<div class="well with-header wellpadding">
<div class="header bordered-blue">活动列表</div>   
<div >
    <div class="form-inline">
    	<span >
		<form action="<?=$this->baseurl?>&m=index" method="post" >
        
        <div class="form-group">
                                                        <span class="input-icon">
                                                            <input type="text" name="keywords"  value="" class="form-control input-sm">
                                                            <i class="glyphicon glyphicon-search blue"></i>
                                                           
                                                        </span>
                                                    </div>
         <div class="form-group"> <input type="submit"name="submit" value=" 搜索 " class="btn btn-blue"></div>  

          <?php echo zy_btn('Active_add',' + 添加','class="btn btn-success"  onclick="location.href=\'index.php?d=admin&c=active&m=add\'" ');?>
          
          </div>  
		</form>
          
	</span> 
 </div>
		<form action="<?=$this->baseurl?>&m=delete" method="post">
    <table width="100%" border="0" cellpadding="3" cellspacing="0" class="table table-hover table-bordered" id="sortTable">
      <tr>
        <th width="30"></th>
        <th   class="td_l">活动名称</th>
        <th class="td_l">活动备注</th>
        <th  align="left">来源渠道</th>
        <th  class="td_l">所选游戏</th>
        <th  align="left">活动状态</th>
        <th  align="left">参与人数</th>
        <th  class="td_l">最近变更</th>
        <th   class="td_l">游戏管理</th>
        <th >操作</th>
      </tr>      
      <?php foreach($list as $key=>$r) {?>
      <tr class="sortTr">
        <td class="td_c">
		 <?php if($r['IsRoot'] == 0){?>
		<input type="checkbox" name="delete[]" value="<?=$r['ActiveID']?>"class="checkbox" />
		 <?php } ?>
		</td>
        <td><?=$r['ActiveName']?></td>
        <td><?=$r['Remark']?></td>
        <td class="td_c"><?=$r['ChannelName']?></td>
        <td class="td_l"><?=$r['GameName']?></td>
        <td class="td_l"><?=$r['Status']?></td>
        <td>
		
		
		 <?php if($r['IsRoot'] == 0){?>
		<?=$this->my_common_model->getActivePartNum($r['ActiveID']) == 0 ? '0' : $this->my_common_model->getActivePartNum($r['ActiveID']);?>人
		<?php }else{
		   $counts = curlGetData("h5game.gxtianhai.cn/racedog/index.php?c=raceDog&m=get_player");
		    $counts = json_decode($counts,true); 
			echo $counts['count_num'] . '人';
		 }?>
		</td>
        <td class="td_l"><?=$r['UserName']?>,<?=timeFromNow($r['Uptime'])?></td>  
        <td class="menu_list">
        <?php if($r['IsRoot'] == 0){?>
        <?php foreach($r['navs_arr'] as $k=>$v) {	
			if ($v['NavName'] == '游戏地址'){ 
				 $url = $v['NavUrl']. '&ActiveID='.$r['ActiveID'].'&ChannelID='.$r['ChannelID'].'&RoomID='.$r['RoomID'];
				 $filename = 'a_'.$r['ActiveID'].'_c_'.$r['ChannelID'].'_r_'.$r['RoomID'].'.png';
				  phpqrcode($url,$filename);  	
			?>
            
        <a  onclick="show_ewm('<?=$url?>', '<?=$filename?>')" data-url="<?=$v['NavUrl']?>&ActiveID=<?=$r['ActiveID']?>&ChannelID=<?=$r['ChannelID']?>&RoomID=<?=$r['RoomID']?>" href="javascript:void(0)"><?=$v['NavName']?></a>
       &nbsp; &nbsp;  
		
           <?=zy_a('Active_edit','资源管理','index.php?d=admin&c=customResources&m=index&ActiveID='.$r['ActiveID'],'')?>
         &nbsp; &nbsp;
         <?=zy_a('Active_edit','规则控制','index.php?d=admin&c=customRule&m=index&ActiveID='.$r['ActiveID'],'')?>
        &nbsp; &nbsp;
        <?=zy_a('GameopeningAPI_view','开放接口','index.php?d=admin&c=gameopeningAPI&RoomID='.$r['RoomID']);?> &nbsp; &nbsp;
       
        <?php }else{?>
        
         <a href="<?=$v['NavUrl']?>&ActiveID=<?=$r['ActiveID']?>&ChannelID=<?=$r['ChannelID']?>&RoomID=<?=$r['RoomID']?>" ><?=$v['NavName']?></a>
       &nbsp; &nbsp;
        <?php }}?>
		
		 <?php }else{?>
		<a style="color:red;" href="http://119.29.87.142/racedog/index.php?d=admin&c=common&m=index&id=18" target="_blank">点击进入赛狗游戏独立管理</a>
		<?php }?>
        </td>
        <td>
        <?php if($r['IsRoot'] == 0){?>
        <span class="btn btn-success btn-xs icon-only white"><?=zy_a('Active_edit','<i class="fa fa-edit" title="编辑"></i>',$this->baseurl.'&m=edit&id='.$r['ActiveID'],'')?></span>
         &nbsp; &nbsp;
        <span class="btn btn-danger btn-xs icon-only white"><?=zy_a('Active_del','<i class="fa fa-trash" title="删除"></i>',$this->baseurl.'&m=delete&id='.$r['ActiveID'],'onclick="return confirm(\'确定要删除吗？\');"')?></span>
         <?php }?>
        </td>
      </tr>
      <?php }?>
      <tr>
        <td colspan="11"><input type="checkbox" name="chkall" id="chkall"onclick="checkall('delete[]')" class="checkbox" />
          <label for="chkall">全选/反选</label>
          &nbsp;
          <?php echo zy_btn('Active_del','删除',' class="btn btn-danger" onclick="return confirm(\'确定要删除吗？\');" ', 'submit');?>
          
 
          &nbsp;
           <div class="margintop">共：
      <?=$count?>
      条&nbsp;&nbsp;
      <?=$pages?>
    </div>
          
          </td>
      </tr>
    </table>
   
  </form>

	
</div> 
	</div>

    
	</form>

</div>
</div>

<?php $this->load->view('admin/footer');?>
