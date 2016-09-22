<?php $this->load->view('admin/header');?>

<script>
KindEditor.ready(function(K) {
	K.create('#content1',{urlType :'relative'});
});
KindEditor.ready(function(K) {
	K.create('#content2',{urlType :'relative'});
});
</script>
<div class="col-xs-12 col-md-12">
<div class="widget">
<div class="well with-header">
<div class="header bordered-blue">添加游戏</div>   
<div >
</div> 
	<form action="<?=$this->baseurl?>&m=save" method="post">
		<input type="hidden" name="RoomID" value="<?=$RoomID?>">
		<table class="table" width="100%">
            
			<tr>
				<td width="90">游戏名称</td>
				<td><input name="value[GameName]" type="text" class="form-control" value="<?=$value[GameName]?>"></td>
			</tr>
            
            <tr>
				<td width="90">文件夹名称</td>
				<td>
					<input <?php if ($RoomID)echo 'readonly="readonly"'; ?>  name="value[Folder]" type="text" class="form-control" value="<?=$value[Folder]?>"> 
					<br/>
					<font color="#FF0000">将会在./static/gameroom/下建立此名称的文件夹存放此游戏的独立资源，添加成功无法再更改。</font>
				</td>
               
			</tr>
           

			<tr>
				<td width="90">游戏类型</td>
				<td>
					<select name="value[GameType]" id="">
						<?php foreach($GameType as $k => $v){?>
							<option <?=($k==$value['GameType'])?'selected="selected"':''?> value="<?=$k?>"><?=$v?></option>
						<?php }?>
					</select>
				</td>
			</tr>

			<tr>
				<td width="90">游戏状态</td>
				<td>
					<select name="value[Status]" id="">
						<?php $Status = array(0=>'测试',1=>'开放',2=>'停用',3=>'维护中');?>
						<?php foreach($Status as $k => $v){?>
							<option <?=($k==$value['Status'])?'selected="selected"':''?> value="<?=$k?>"><?=$v?></option>
						<?php }?>
					</select>
				</td>
			</tr>

			<tr>
				<td>游戏版本</td>
				<td><input name="value[Version]" type="text" class="form-control" value="<?=$value[Version]?>"></td>
			</tr>

			<tr>
				<td>游戏截图</td>
				<td id="images">
					<?php $patharr = explode('|', $value['ScreenImages']); foreach($patharr as $k => $v){?>
					<input name="value[ScreenImages][]" id="ScreenImages<?=$k?$k:''?>" type="text" class="txt images form-control" value="<?=$v?>">
					<input type="button" value=" 查看 " class="btn btn-success" onclick="vPicFromID('ScreenImages<?=$k?$k:''?>')" />
					<input type="button" value=" 上传 " class="btn btn-info" onclick="upfile('ScreenImages<?=$k?$k:''?>')" /><br/><br/>
					<?php }?>
				</td>
			</tr>

			<tr>
				<td></td>
				<td>
					
					<input type="button" value=" 添加截图 "  class="btn btn-success" onclick="addImage()" />
				</td>
			</tr>

			<tr>
				<td>游戏介绍</td>
				<td>
					<textarea name="value[GameResume]" id="content1" class="form-control"><?=$value[GameResume]?></textarea>
					
				</td>
			</tr>

			<tr>
				<td>游戏备注</td>
				<td>
					<textarea name="value[Remark]" id="content2" class="form-control"><?=$value[Remark]?></textarea>
					
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

<script>
function addImage(){
	var num = $('.images').length;
	var html = "<input name=\"value[ScreenImages][]\" id=\"ScreenImages"+num+"\" type=\"text\" class=\"txt images form-control\" value=\"\"><input type=\"button\" value=\" 查看 \" class=\"btn btn-success\" onclick=\"vPicFromID('ScreenImages"+num+"')\" /><input type=\"button\" value=\" 上传 \" class=\"btn btn-info\" onclick=\"upfile('ScreenImages"+num+"')\" /><br/><br/>";
	$('#images').append(html);
}
</script>

<?php $this->load->view('admin/footer');?>