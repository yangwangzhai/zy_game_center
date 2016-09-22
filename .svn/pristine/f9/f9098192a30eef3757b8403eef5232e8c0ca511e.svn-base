<?php $this->load->view('admin/header');?>

<script>
KindEditor.ready(function(K) {
	K.create('#content',{urlType :'relative'});
});
</script>

<div class="col-xs-12 col-md-12">
<div class="widget">
<div class="well with-header">
<div class="header bordered-blue">添加导航</div>   
<div >
</div> 
<form action="<?=$this->baseurl?>&m=save" method="post">
		<input type="hidden" name="NavID" value="<?=$NavID?>">
		<table class="table" width="100%">
            
            <tr>
				<td width="90">游戏</td>
				<td>
					<select name="value[RoomID]" id="">
						<?php foreach($GameList as $k => $v){?>
							<option <?=($v['RoomID']==$value['RoomID'])?'selected="selected"':''?> value="<?=$v['RoomID']?>"><?=$v['GameName']?></option>
						<?php }?>
					</select>
				</td>
			</tr>

			<tr>
				<td width="90">导航名称</td>
				<td><input name="value[NavName]" type="text" class="form-control" value="<?=$value[NavName]?>"></td>
			</tr>

			<tr>
				<td>导航标记</td>
				<td><input name="value[NavSign]" type="text" class="form-control" value="<?=$value[NavSign]?>"></td>
			</tr>

			<tr>
				<td>导航基础URL</td>
				<td><input name="value[NavUrl]" type="text" class="form-control" value="<?=$value[NavUrl]?>"></td>
			</tr>

			<tr>
				<td>排序</td>
				<td><input name="value[Sort]" type="text" class="form-control" value="<?=$value[Sort]?>"></td>
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