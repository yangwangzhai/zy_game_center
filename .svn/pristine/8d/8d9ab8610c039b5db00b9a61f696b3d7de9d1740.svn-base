<?php $this->load->view('admin/header');?>

<script>
// 上传文件
function upload_image(input) 
{	
	editor.loadPlugin('myimage', function() { 
			editor.plugin.imageDialog({
				showRemote : false,
				imageUrl : $('#'+input).val(),
				uploadpath : 'gameroom/<?=$this->uploadpath?>/res/',
				clickFn : function(url, title, width, height, border, align) {
						$('#'+input).val(url);
						$('#'+input+'-img').attr('src',url);
						editor.hideDialog();
				}
			});
			//$(".ke-dialog-row input[name='localUrl']").val( $('#'+input).val());
		});

}
KindEditor.ready(function(K) {
				
				K('#filemanager').click(function() {
					editor.loadPlugin('filemanager', function() {
						editor.plugin.filemanagerDialog({
							viewType : 'VIEW',
							dirName : 'res',
							paths : 'gameroom/<?=$this->uploadpath?>/',
							clickFn : function(url, title) {
								K('#resUrl').val(url);
								editor.hideDialog();
							}
						});
					});
				});
});

</script>
<div class="col-xs-12 col-md-12">
<div class="widget">
<div class="well with-header">
<div class="header bordered-blue">修改资源</div>   

	<form action="<?=$this->baseurl?>&m=save" method="post">
		<input type="hidden" name="ReID" value="<?=$ReID?>">
		<table class="table" width="100%">
            
            <tr>
				<td width="90">资源名称</td>
				<td><input name="value[ReName]" type="text" class="form-control" value="<?=$value[ReName]?>"></td>
			</tr>

			<tr>
				<td width="90">变量名</td>
				<td><input name="value[VarName]" type="text" class="form-control" readonly="readonly" value="<?=$value[VarName]?>"></td>
			</tr>

			<tr>
				<td>资源路径</td>
				<td>
					<input name="value[ReSrc]" id="resUrl" type="text" class="form-control" style="width: 500px; display: inline;" value="<?=$value[ReSrc]?>">
				
					<input type="button" value=" 上传 " class="btn btn-success" style="margin-top: -4px; margin-right: 10px; margin-left: 10px;" onclick="upload_image('resUrl')" />
                   <input class="btn btn-info" type="button" style="margin-top: -4px; margin-right: 10px; " id="filemanager" value="浏览服务器" />
				</td>
			</tr>

			<tr>
				<td>资源类型</td>
				<td>
					<select name="value[ReType]">
						<?php foreach($ReType as $k => $v){?>
						<option <?=($value['ReType']==$k)?'selected="selected"':''?> value="<?=$k?>"><?=$v?></option>
						<?php }?>
					</select>
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