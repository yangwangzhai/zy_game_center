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

function lookimg(url){
	if(url == '') return;
	$.dialog({
		id: 'a15',
		
		title: '查看原图',
		lock: true,
		content: '<img style="max-height:500px;" src="'+url+'" />',
		padding: 0
	});
}

</script>
<div class="col-xs-12 col-md-12">
<div class="widget">
<div class="well with-header wellpadding">
<div class="header bordered-blue">游戏资原管理</div> 
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
	    <?=zy_btn('BaseTable_add',' + 添加资源 ','class="btn btn-success"  onclick="location.href=\'index.php?d=admin&c=resources&m=add&RoomID='.$RoomID.'\'" ');?>
	<a style="display:none;" href="index.php?d=admin&c=resources&m=import&RoomID=<?=$RoomID?>">批量导入</a>
    </div>    
		
	<form action="<?=$this->baseurl?>&m=delete" method="post">
		<table width="100%" border="0" cellpadding="3" cellspacing="0"
			class="table table-hover table-bordered" id="sortTable">
			<tr>
				<th width="30"></th>
				<th align="left">资源ID</th>
				<th align="left">缩略图</th>
                <th  class="td_l">资源名称</th>
				<th align="left">资源类型</th>
				<th  class="td_l">资源大小</th>
				<th  class="td_l">变量名</th>
				<th  class="td_l">资源路径</th>
                 <th  class="td_c">可修改</th>
				<th  class="td_l">最近更新</th>
				<th>操作</th>
			</tr>

    <?php 
	 foreach($list as $key=>$r) {?>
    <tr class="sortTr">
				<td  class="td_c">
                <input type="checkbox" name="delete[]" value="<?=$r['ReID']?>"class="checkbox" />

                </td>
				<td  class="td_c"><?=$r['ReID']?></td>
                <td  <?php if ($r['ReType'] == '0') {?> onclick="lookimg('<?=$r['ReSrc']?>')"   <?php }?>>
               <?php if ($r['ReType'] == '0') {?>
                <img width="50" height="50"  src="<?=$r['ReSrc']?>" />
                <?php }?>
                </td>
                
                <td><?=$r['ReName']?></td>
				<td class="td_c"><?=$ReType[$r['ReType']]?></td>
				<td class="td_l"><?=$r['ReSize']?></td>
				<td class="td_l"><?=$r['VarName']?></td>
				<td><?=$r['ReSrc']?></td>
                <td  class="td_c"><?=$r['IsEdit'] == 1 ? '<font color="#090">是</font>' : '否'?></td>
				<td class="td_l"><?=getUserName($r['UID'])?>,<?=timeFromNow($r['UpdateTime'])?></td>
				<td>
					
					<span class="btn btn-success btn-xs icon-only white"><?=zy_a('BaseTable_update','<i class="fa fa-edit" title="编辑"></i>',$this->baseurl.'&m=edit&ReID='.$r['ReID'].'&RoomID='.$r['RoomID']);?></span>
					&nbsp;
                	<span class="btn btn-danger btn-xs icon-only white"><?=zy_a('BaseTable_del','<i class="fa fa-trash" title="删除"></i>',$this->baseurl.'&m=delete&ReID='.$r['ReID'],'onclick="return confirm(\'确定要删除吗？\');"');?></span>
                	&nbsp;
                	<span class="btn btn-blue btn-xs icon-only white"><?=zy_a('BaseTable_add','<i class="fa fa-copy" title="复制"></i>',$this->baseurl.'&m=copyre&ReID='.$r['ReID'].'&RoomID='.$r['RoomID']);?></span>
					
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