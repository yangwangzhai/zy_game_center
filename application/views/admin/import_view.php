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
<div class="header bordered-blue">批量导入资源</div>   
<div >
</div> 
	<form action="<?=$this->baseurl?>&m=import_save&RoomID=<?=$RoomID?>" method="post">
		<input type="hidden" name="ReID" value="<?=$ReID?>">
		<input type="hidden" name="RoomID" value="<?=$RoomID?>">
		<table class="table" width="100%">
            
            <tr>
				<td width="90">resource.js资源名称</td>
				<td>
               <textarea rows="" cols="" name="url" style="width: 504px; height: 569px;"></textarea></td>
			</tr>

			
			
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" name="submit" value=" 导入 " class="btn btn-blue"
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