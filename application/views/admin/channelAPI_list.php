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
<div class="header bordered-blue">渠道接口管理</div>   
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
          <div class="form-group">  <?=zy_btn('ChannelAPI_add',' + 添加接口 ','class="btn btn-success"  onclick="location.href=\'index.php?d=admin&c=channelAPI&m=add\'" ');?></div>  
		</form>
          
	</span> 
 </div>
			<form action="<?=$this->baseurl?>&m=delete" method="post">
		<table width="100%" border="0" cellpadding="3" cellspacing="0"
			class="table table-hover table-bordered" id="sortTable">
			<tr>
				<th width="30"></th>
				<th align="left">ID</th>
				<th align="left">所属渠道</th>
                <th  class="td_l">接口名称</th>
                <th  class="td_l">接口标记</th>
				<!-- <th  class="td_l" width="600">接口地址</th> -->
				<th align="left">接口说明</th>
				<th align="left">接口状态</th>
				<th align="left">最近更新</th>
				<th width="100">操作</th>
			</tr>

    <?php 
	 foreach($list as $key=>$r) {?>
    <tr class="sortTr">
				<td class="td_c">
                <input type="checkbox" name="delete[]" value="<?=$r['ChannelApiID']?>"class="checkbox" />

                </td>
				<td class="td_c"><?=$r['ChannelApiID']?></td>
				<td class="td_c"><?php foreach($CList as $c){?>
					<?=($r['ChannelID'] == $c['ChannelID'])?$c['ChannelName']:''?>
					<?php }?>
				</td>
                <td class="td_l"><?=$r['ApiName']?></td>
                <td class="td_l"><?=$r['ApiSign']?></td>
				<!-- <td  class="td_l"><div style="width:600px;">"<?=$r['ApiUrl']?></div></td> -->
				<td class="td_c"><a href="javascript:" onclick="urlDialogCus('<?=$this->baseurl?>&m=showRemark&ChannelApiID=<?=$r['ChannelApiID']?>','接口说明',500,300)">点击查看</a></td>
				<td class="td_c"><?=$r['Status']?'<font color="red">启用</font>':'<font color="red">停用</font>'?></td>
				<td class="td_c"><?=getUserName($r['UID'])?>,<?=timeFromNow($r['Uptime'])?></td>
				<td class="td_c">
					
					<span class="btn btn-success btn-xs icon-only white"><?=zy_a('ChannelAPI_update','<i class="fa fa-edit" title="编辑"></i>',$this->baseurl.'&m=edit&ChannelApiID='.$r['ChannelApiID']);?></span>
					&nbsp;&nbsp;
                	<span class="btn btn-danger btn-xs icon-only white"><?=zy_a('ChannelAPI_del','<i class="fa fa-trash" title="删除"></i>',$this->baseurl.'&m=delete&ChannelApiID='.$r['ChannelApiID'],'onclick="return confirm(\'确定要删除吗？\');"');?></span>
                	
                
                </td>
			</tr>
    <?php }?>
    <tr><td colspan="10"><div class="margintop">共：<?=$count?>条&nbsp;&nbsp;<?=$pages?></div></td></tr>
		</table>

		

	</form>

</div> 
	</div>

    
	</form>

</div>
</div>



<?php $this->load->view('admin/footer');?>