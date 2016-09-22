<?php $this->load->view('admin/header');?>
<script type="text/javascript">

</script>
<div class="col-xs-12 col-md-12">
<div class="widget">
<div class="well with-header">
<div class="header bordered-blue">添加喇叭</div>   
<div >
</div> 
	<form action="<?=$this->baseurl?>&m=save" method="post">
		<input type="hidden" name="id" value="<?=$value[id]?>">
       
		<table class="opt">
          
			<tr>
				<td >喇叭内容</td>
				<td><textarea name="value[content]" style="width:500px;" type="text" class="txt"><?=$value[content]?></textarea></td>
			</tr>
			
			<tr>
				<td>启用状态</td>
				<td>
					<select name="value[status]" id="status">
						<option value='0' <?=$value['status']?'':'selected=true'?>>启用</option>
						<option value='1' <?=$value['status']?'selected=true':''?>>禁用</option>
					</select>
				</td>
			</tr>
			
		
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" name="submit" value=" 提 交 " class="btn btn-blue"
					tabindex="3" /> </td>
			</tr>
		</table>
	</form>

</div>


</div>
</div>

<?php $this->load->view('admin/footer');?>