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
<div class="header bordered-blue">游戏规则管理</div> 
<div>
	<div class="form-inline">
		<span>
			<form action="<?=$this->baseurl?>&m=index" method="post">
				<div class="form-group">
					<span class="input-icon">
						<input type="text" name="keywords" value="" class="form-control input-sm"> 
						<i class="glyphicon glyphicon-search blue"></i>
					</span>
				</div>
				<div class="form-group">
					<input type="submit" name="submit" value=" 搜索 " class="btn btn-blue">
				</div>
			</form>
		</span> 
		<?=zy_btn('BaseTable_add',' + 添加规则 ','class="btn btn-success"  onclick="location.href=\'index.php?d=admin&c=rule&m=add&RoomID='.$RoomID.'\'" ');?>
	</div> 
    
    <form action="<?=$this->baseurl?>&m=delete" method="post">
		<table width="100%" border="0" cellpadding="3" cellspacing="0"
			class="table table-hover table-bordered" id="sortTable">
			<tr>
				<th width="30"></th>
				<th  class="td_l">规则ID</th>
                <th  class="td_l">规则名称</th>
				<th  class="td_l" width="600">规则值</th>
				<th  class="td_l">规则标记</th>
				<th  class="td_l">最近更新</th>
				<th width="80">操作</th>
			</tr>

    <?php 
	 foreach($list as $key=>$r) {?>
    <tr class="sortTr">
				<td  class="td_c">
                <input type="checkbox" name="delete[]" value="<?=$r['RuleID']?>"class="checkbox" />

                </td>
				<td><?=$r['RuleID']?></td>
                <td><?=$r['RuleName']?></td>
				<td><?=$r['RuleSet']?></td>
				<td><?=$r['RuleSign']?></td>
				
				<td><?=getUserName($r['UID'])?>,<?=timeFromNow($r['UpdateTime'])?></td>
				<td  class="td_c">
					
					<span class="btn btn-success btn-xs icon-only white"><?=zy_a('BaseTable_update','<i class="fa fa-edit" title="编辑"></i>',$this->baseurl.'&m=edit&RuleID='.$r['RuleID'].'&RoomID='.$r['RoomID']);?></span>
					&nbsp;
                	<span class="btn btn-danger btn-xs icon-only white"><?=zy_a('BaseTable_del','<i class="fa fa-trash" title="删除"></i>',$this->baseurl.'&m=delete&RuleID='.$r['RuleID'],'onclick="return confirm(\'确定要删除吗？\');"');?></span>
                	
                
                </td>
			</tr>
    <?php }?>
		</table>

		<div class="margintop">共：<?=$count?>条&nbsp;&nbsp;<?=$pages?></div>

	</form>

</div>
</div>
</div>
</div>


<?php $this->load->view('admin/footer');?>