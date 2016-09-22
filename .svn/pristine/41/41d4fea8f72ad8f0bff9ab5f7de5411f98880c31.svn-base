<?php $this->load->view('admin/header');?>
<script type="text/javascript">
$(function(){
	$('.set').click(function(){
		var cur_val = $(tdis).val();
		if(cur_val == 1) $('#shuoming').show();
		if(cur_val == 0) $('#shuoming').hide();
	})
})
</script>
<div class="col-xs-12 col-md-12">
<div class="widget">
<div class="well with-header">
<div class="header bordered-blue">游戏设置</div>   
<div >
</div> 

	<form action="<?=$tdis->baseurl?>&m=save" metdod="post">
		<input type="hidden" name="id" value="<?=$value[id]?>">
       
		<table class="table" widtd="100%">
          
			<tr>
				<td ></td>
				<td>游戏维护时间从<input name="value[end_time]" style="widtd:50px;" type="text" class="txt" value="<?=$value[end_time]?>"/>开始到第二天
                <input name="value[start_time]" style="widtd:50px;" type="text" class="txt" value="<?=$value[start_time]?>"/>
                </td>
			</tr>
			
			<tr>
				<td></td>
				<td>是否停止游戏 <input name="value[isStop]" type="radio" class="set" value="1" <?php if ($value[isStop] == 1){echo 'checked';} ?>/><font color="#FF0000">是</font>
                			   <input name="value[isStop]" type="radio" class="set" value="0" <?php if ($value[isStop] == 0){echo 'checked';} ?>/>否
                </td>
			</tr>
			
            <tr id="shuoming" style="display:<?php if ($value[isStop] == 0){echo 'none';} ?>">
				<td></td>
				<td>维护说明  <input name="value[repairedtext]" style="widtd:250px;" type="text" class="txt" value="<?=$value[repairedtext]?>"/>     </td>
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