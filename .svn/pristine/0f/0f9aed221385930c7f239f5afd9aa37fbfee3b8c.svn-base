<?php $this->load->view('admin/header');?>

<style>
	.long {width:200px; margin-bottom: 10px;}
</style>
<script type="text/javascript">

function addBlack(){
	var ActiveID = $('#ActiveID').val();
	var Openid = $('#Openid').val();
	var Nickname = $('#Nickname').val();
	var Remark = $('#Remark').val();

	$.ajax({
		url:'index.php?d=admin&c=black&m=add',
		type:'post',
		data:{ActiveID:ActiveID,Openid:Openid,Nickname:Nickname,Remark:Remark},
		success:function(res){
			if(res == '1'){
				alert('已加入黑名单');
			}else{
				alert('添加黑名单失败或已存在');
			}
		}
	})
}
</script>
<div class="mainbox">
  
	
	<form action="<?=$this->baseurl?>&m=add" method="post">
		<input type="hidden" name="ActiveID" id="ActiveID" value="<?=$ActiveID?>">
		<table>
			<tr>
				<td>openid:</td>
				<td><input type="text" class="txt long" name="Openid" id="Openid" value="<?=$openid?>"></td>
				
			</tr>
			
			<tr>
				<td>昵称:</td>
				<td><input type="text" class="txt long" name="Nickname" id="Nickname" value="<?=$nickname?>"></td>

			</tr>
			<tr>
				<td>列黑原因:</td>
				<td><input type="text" class="txt long" name="Remark" id="Remark"></td>
			</tr>

			<tr>
				<td></td>
				<td><input type="button" class="btn" onclick="addBlack()" value="提交"></td>
			</tr>
		</table>
		
		


	</form>

</div>
