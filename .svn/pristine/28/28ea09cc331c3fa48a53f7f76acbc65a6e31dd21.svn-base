<?php $this->load->view('admin/header');?>

<script>
KindEditor.ready(function(K) {
	K.create('#ApiRemark',{urlType :'relative', items : [
    'source', '|', 'fontname', 'fontsize', '|', 'textcolor', 'bgcolor', 'bold', 'italic', 'underline',
    'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
    'insertunorderedlist', '|', 'emoticons', 'image', 'link']});
});
</script>

<div class="col-xs-12 col-md-12">
<div class="widget">
<div class="well with-header">
<div class="header bordered-blue">添加接口</div>   
<div >
</div> 
<form action="<?=$this->baseurl?>&m=save" method="post">
		<input type="hidden" name="ApiId" value="<?=$ApiId?>">
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
				<td width="90">接口名称</td>
				<td><input name="value[ApiName]" type="text" class="form-control" value="<?=$value[ApiName]?>"></td>
			</tr>

			<tr>
				<td>接口标记</td>
				<td><input name="value[ApiSign]" type="text" class="form-control" value="<?=$value[ApiSign]?>"></td>
			</tr>

			<tr>
				<td>接口地址</td>
				<td><input name="value[ApiUrl]" type="text" class="form-control" value="<?=$value[ApiUrl]?>"></td>
			</tr>

			<tr>
				<td>鉴权IP</td>
				<td><input name="value[VrIP]" type="text" class="form-control" value="<?=$value[VrIP]?>"></td>
			</tr>

			<tr>
				<td>校验码</td>
				<td><input name="value[Vrkey]" type="text" class="form-control" value="<?=$value[Vrkey]?>"></td>
			</tr>

			<tr>
				<td width="90">接口状态</td>
				<td>
					<select name="value[Status]" id="">
						<option <?=($value['Status'])?'selected="selected"':''?> value="1">启用</option>
						<option <?=($value['Status'])?'':'selected="selected"'?> value="0">停用</option>
					</select>
				</td>
			</tr>

			<tr>
				<td>接口说明</td>
				<td>
					<textarea name="value[ApiRemark]" id="ApiRemark" class="form-control"><?=$value[ApiRemark]?></textarea>
					
				</td>
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