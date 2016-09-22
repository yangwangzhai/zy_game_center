<?php $this->load->view('admin/header');?>
<script type="text/javascript">


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
		<form action="<?=$this->baseurl?>&m=index&ActiveID=<?=$ActiveID?>"  method="post">
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
    </div>
    <div style="clear:both;"></div>
	
	<form action="<?=$this->baseurl?>&m=delete" method="post">
		<table width="100%" border="0" cellpadding="3" cellspacing="0"
			class="table table-hover table-bordered"  id="sortTable">
			<tr>
				<th width="30"></th>
				<th  class="td_l">资源ID</th>
				<th  class="td_l">缩略图</th>
                <th  class="td_l">资源名称</th>
				<th align="left">资源类型</th>
				<th  class="td_l">资源大小</th>
				<th  class="td_l">变量名</th>
				<th class="td_l">资源路径</th>
				<th  class="td_l">最近更新</th>
				<th>操作</th>
			</tr>

    <?php 
	 foreach($list as $key=>$r) {?>
    <tr class="sortTr">
				<td class="td_c">
                <input type="checkbox" name="delete[]" value="<?=$r['ReID']?>"class="checkbox" />

                </td>
				<td><?=$r['ReID']?></td>
                <td  <?php if ($r['ReType'] == '0') {?> onclick="lookimg('<?=$r['ReSrc']?>')"   <?php }?>>
               <?php if ($r['ReType'] == '0') {?>
                <img width="50" height="50"  src="<?=$r['ReSrc']?>" />
                <?php }?>
                </td>
                <td><?=$r['ReName']?></td>
				<td class="td_c"><?=$ReType[$r['ReType']]?></td>
				<td><?=$r['ReSize']?></td>
				<td><?=$r['VarName']?></td>
				<td><?=$r['ReSrc']?></td>
				<td><?=$r['UserName']?>,<?=timeFromNow($r['UpdateTime'])?></td>
				<td>
					<?php if ($r['IsEdit']){ ?>
					<span class="btn btn-success btn-xs icon-only white"><?=zy_a('Active_edit','<i class="fa fa-edit" title="编辑"></i>',$this->baseurl.'&m=edit&ReID='.$r['ReID'].'&RoomID='.$r['RoomID']);?>
					 </span>
                      <?php }?>
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