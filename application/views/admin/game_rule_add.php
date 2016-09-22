<?php $this->load->view('admin/header');?>

<script>
KindEditor.ready(function(K) {
	K.create('#content',{urlType :'relative'});
});
</script>
<div class="col-xs-12 col-md-12">
<div class="widget">
<div class="well with-header">
<div class="header bordered-blue">添加规则</div>   
<div >
</div> 
	<form action="<?=$this->baseurl?>&m=save" method="post">
		<input type="hidden" name="RuleID" value="<?=$RuleID?>">
		<input type="hidden" name="value[RoomID]" value="<?=$RoomID?>">
		<table class="table" width="100%">
            
            <tr>
				<td width="90">规则名称</td>
				<td><input name="value[RuleName]" type="text" class="form-control" value="<?=$value[RuleName]?>"></td>
			</tr>

			<tr>
				<td>规则标记</td>
				<td><input name="value[RuleSign]" type="text" class="form-control" value="<?=$value[RuleSign]?>"></td>
			</tr>

			<tr>
				<td>规则值</td>
				<td><input name="value[RuleSet]" type="text" class="form-control" value="<?=$value[RuleSet]?>"></td>
			</tr>

			
			
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" name="submit" value=" 提 交 " class="btn btn-blue"
					tabindex="3" /> &nbsp;&nbsp;&nbsp;<input type="button"
					name="submit" value=" 取消 " class="btn"
					onclick="javascript:history.back();" /></td>
			</tr>
		</table>
	</form>

</div>
</div>
</div>

<?php $this->load->view('admin/footer');?>