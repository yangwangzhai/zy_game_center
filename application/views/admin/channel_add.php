<?php $this->load->view('admin/header');?>

<script>
KindEditor.ready(function(K) {
	K.create('#content',{urlType :'relative'});
});
</script>

<div class="col-xs-12 col-md-12">
<div class="widget">
<div class="well with-header">
<div class="header bordered-blue">添加渠道</div>   
<div >
</div> 
<form action="<?=$this->baseurl?>&m=save" method="post">
		<input type="hidden" name="ChannelID" value="<?=$ChannelID?>">
		<table class="table  noborder" width="100%">
            
			<tr>
				<td width="90">渠道名称</td>
				<td><input name="value[ChannelName]" type="text" class="form-control" value="<?=$value[ChannelName]?>"></td>
			</tr>

			<tr>
				<td>备注</td>
				<td>
					<textarea name="value[Remark]" class="form-control" rows="5"><?=$value[Remark]?></textarea>
					
				</td>
			</tr>
			
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" name="submit" value=" 提 交 " class="btn"
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