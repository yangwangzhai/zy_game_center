<?php $this->load->view('admin/header');?>
<script type="text/javascript">

</script>
<div class="col-xs-12 col-md-12">
<div class="widget">
<div class="well with-header wellpadding">
<div class="header bordered-blue">游戏规则管理</div> 
<div>
	<div class="form-inline">
		<span>
			<form action="<?=$this->baseurl?>&m=index&ActiveID=<?=$ActiveID?>" method="post">
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
    
	
	<form action="<?=$this->baseurl?>&m=delete" method="post">
		<table width="99%" border="0" cellpadding="3" cellspacing="0"
			class="table table-hover table-bordered"  id="sortTable">
			<tr>
				<th width="30"></th>
				<th  class="td_l">规则ID</th>
                <th  class="td_l">规则名称</th>
				<th  class="td_l" width="600">规则值</th>
				<th class="td_l">规则标记</th>
				<th  class="td_l">最近更新</th>
				<th class="td_c" width="70">操作</th>
			</tr>

    <?php 
	 foreach($list as $key=>$r) {?>
    <tr class="sortTr">
				<td  class="td_c">
                <input type="checkbox" name="delete[]" value="<?=$r['RuleID']?>"class="checkbox" />

                </td>
				<td><?=$r['RuleID']?></td>
                <td class="td_l"><?=$r['RuleName']?></td>
				<td class="td_l"><?=$r['RuleSet']?></td>
				<td class="td_l"><?=$r['RuleSign']?></td>
				
				<td class="td_l"><?=$r['UserName']?>,<?=timeFromNow($r['UpdateTime'])?></td>
				<td>
					
					<span class="btn btn-success btn-xs icon-only white"><?=zy_a('Active_edit','<i class="fa fa-edit" title="编辑"></i>',$this->baseurl.'&m=edit&RuleID='.$r['RuleID']);?>
                </span>
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