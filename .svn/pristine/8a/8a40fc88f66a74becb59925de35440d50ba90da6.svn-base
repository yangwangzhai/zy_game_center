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

</script>
<div class="col-xs-12 col-md-12">
<div class="widget">
<div class="well with-header wellpadding">
<div class="header bordered-blue">渠道列表</div>   
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
          <div class="form-group"> <?=zy_btn('Channel_add',' + 添加渠道 ','class="btn btn-success"  onclick="location.href=\'index.php?d=admin&c=channel&m=add\'" ');?></div>  
		</form>
          
	</span> 
 </div>
		<table width="100%" border="0" cellpadding="3" cellspacing="0"
			class="table table-hover table-bordered " id="sortTable">
			<tr>
				<th width="30"></th>
				<th align="left">渠道ID</th>
                <th align="left">渠道名称</th>
				<th align="left">添加时间</th>
				<th align="left">渠道活动数/最近活跃</th>
				<th align="left">渠道接口数/最近更新</th>
				<th class="td_l">备注</th>
				<th>操作</th>
			</tr>

    <?php 
	 foreach($list as $key=>$r) {?>
    <tr class="sortTr">
				<td class="td_c">
                <input type="checkbox" name="delete[]" value="<?=$r['ChannelID']?>"class="checkbox" />

                </td>
				<td class="td_c"><?=$r['ChannelID']?></td>
                <td class="td_c"><?=$r['ChannelName']?></td>
				<td class="td_c" title="<?=times($r['AddTime'],1)?>"><?=date('Y/m/d',$r['AddTime'])?></td>
				<td class="td_c"><?=$this->my_common_model->getActiveNum($r['ChannelID'])?> / <?=$r['ActiveTime']?timeFromNow($r['ActiveTime']):'无'?></td>
				<td class="td_c"><?=$this->my_common_model->getChannelApiNum($r['ChannelID'])?> / <?=$this->my_common_model->getChannelApiUpdateTime($r['ChannelID'])?timeFromNow($this->my_common_model->getChannelApiUpdateTime($r['ChannelID'])):'无'?></td>
				<td class="td_l"><?=$r['Remark']?></td>
				<td  class="td_c">
					
					<span class="btn btn-success btn-xs icon-only white"><?=zy_a('Channel_update','<i class="fa fa-edit" title="编辑"></i>',$this->baseurl.'&m=edit&ChannelID='.$r['ChannelID']);?></span>
					&nbsp;&nbsp;
                	<span class="btn btn-danger btn-xs icon-only white"><?=zy_a('Channel_del','<i class="fa fa-trash" title="删除"></i>',$this->baseurl.'&m=delete&ChannelID='.$r['ChannelID'],'onclick="return confirm(\'确定要删除吗？\');"');?></span>
                	
               
 
                </td>
			</tr>
            
    <?php }?>
    <tr ><td colspan="8"> <div class="margintop">共：<?=$count?>条&nbsp;&nbsp;<?=$pages?></div></td></tr>
		</table>

		
	</div>

    
	</form>

</div>
</div>

<?php $this->load->view('admin/footer');?>