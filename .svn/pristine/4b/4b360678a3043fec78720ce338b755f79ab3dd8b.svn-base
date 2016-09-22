<?php $this->load->view('admin/header');?>

<script>
KindEditor.ready(function(K) {
	K.create('#content',{urlType :'relative'});
});
</script>

<div class="col-xs-12 col-md-12">
<div class="widget">
<div class="well with-header">
<div class="header bordered-blue">添加用户</div>   
<div >
</div> 
<form action="<?=$this->baseurl?>&m=save" method="post">
		<input type="hidden" name="UID" value="<?=$UID?>">
		
	<table class="table" width="100%">
        
            <?php //if(!$value['islock'] && $value['groupid']==1){?>
       	 	<tr>
        		<td width="90">分组 </td>
				<td>
                	<select name="value[GroupID]" id="GroupID">
                		<?php foreach($grouplist as $r){?>
						<option <?=($r['GroupID'] == $value['GroupID'])?'selected="selected"':''?> value="<?=$r['GroupID']?>"><?=$r['GroupName']?></option>
                		<?php }?>
                	</select>
                </td>
			</tr>	
            <?php // }?>
            <tr>
				<td>用户类型</td>
				<td>
					<select name="value[UserType]">
						<option <?=($value['UserType']==0)?'selected="selected"':''?> value="0">系统</option>
						<option <?=($value['UserType']==1)?'selected="selected"':''?> value="1">渠道</option>
					</select>
				</td>
			</tr>	
            <tr>
				<td >可管理渠道</td>
				<td>
                <?php  foreach($channel as $key=>$r) {?>
                <input type="checkbox" name="channel[]" <?php if (in_array($r['ChannelID'], $channels)) echo "checked" ?> value="<?=$r['ChannelID']?>"class="checkbox" /><?=$r['ChannelName']?>&nbsp;&nbsp;
                <?php }?>
                </td>
			</tr>
			<tr>
				<td >用户名</td>
				<td><input name="value[Username]" type="text" class="form-control" value="<?=$value[Username]?>" <?php if($id==$_SESSION[UID]){?> readonly /><?php }?></td>
			</tr>
			<tr>
				<td>密码</td>
				<td><input name="value[Password]" class="form-control" type="password"
					id="thumb" value="" />不修改请留空</td>
			</tr>
			<tr>
				<td>姓名</td>
				<td><input name="value[TrueName]" class="form-control" type="text"
					id="thumb" value="<?=$value[TrueName]?>" /></td>
			</tr>
			<tr>
				<td>手机</td>
				<td><input name="value[Tel]" class="form-control" type="text"
					id="thumb" value="<?=$value[Tel]?>" /></td>
			</tr>
			<tr>
				<td>邮箱</td>
				<td><input name="value[Email]" class="form-control" type="text"
					id="thumb" value="<?=$value[Email]?>" /></td>
			</tr>

			<tr>
				<td>备注</td>
				<td><input name="value[Remark]" class="form-control" type="text"
					id="thumb" value="<?=$value[Remark]?>" /></td>
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