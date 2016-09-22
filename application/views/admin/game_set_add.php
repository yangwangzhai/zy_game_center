<?php $this->load->view('admin/header');?>
<script type="text/javascript">

</script>
<div class="mainbox nomargin" style="margin:10px 0px 0px 10px;">
	<form action="<?=$this->baseurl?>&m=save" method="post">
		<input type="hidden" name="id" value="<?=$value[id]?>">
       
		<table class="opt">
          
			<!-- <tr>
				<th >游戏时长</th>
				<td><input name="value[game_time]" style="width:50px;" type="text" class="txt" value="<?=$value[game_time]?>"/>秒</td>
			</tr>
			
			<tr>
				<th>大红包分值</th>
				<td><input name="value[bigred]" style="width:50px;" class="txt" type="text"
					id="thumb" value="<?=$value[bigred]?>" />分</td>
			</tr>
			
			<tr>
				<th>小红包分值</th>
				<td><input name="value[smallred]" style="width:50px;" class="txt" type="text"
					id="thumb" value="<?=$value[smallred]?>" />分</td>
			</tr>
			
			<tr>
				<th>鞭炮减分值</th>
				<td><input name="value[bomb]" style="width:50px;" class="txt" type="text"
					id="thumb" value="<?=$value[bomb]?>" />分</td>
			</tr> -->
			
			<tr>
				<th>游戏最大分数设定</th>
				<td><input name="value[max_score]" style="width:50px;" class="txt" type="text"
					id="thumb" value="<?=$value[max_score]?>" />分</td>
			</tr>
		
			<tr>
				<th>&nbsp;</th>
				<td><input type="submit" name="submit" value=" 提 交 " class="btn"
					tabindex="3" /> </td>
			</tr>
		</table>
	</form>

</div>

<?php $this->load->view('admin/footer');?>