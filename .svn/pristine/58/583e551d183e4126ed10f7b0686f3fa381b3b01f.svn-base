<?php $this->load->view('admin/header');?>

<script>
KindEditor.ready(function(K) {
	K.create('#content',{urlType :'relative'});
});
function select_game(){
	var gameID = $('#RoomID').val();
	if(gameID != '0'){
		$('#select_game').attr('src','<?=$this->baseurl?>&m=select_game&gameID='+gameID);
	}
	//如果等于3则是赛狗游戏
	if(gameID == 3){
		$.post("<?=$this->baseurl?>&m=checkport",
		{
		  name:"Donald Duck",		 
		},
		function(data,status){
		  $('#ScoketPort_tr').show();
		  $('#ScoketPort').val(data);
		 // alert("Data: " + data + "\nStatus: " + status);
	    });
	}else{
		 $('#ScoketPort_tr').hide();
		 $('#ScoketPort').val('');
	}
}
function checkport(){
	var port = $('#ScoketPort').val();
	if(port != ''){
		var r = /^[0-9]*[1-9][0-9]*$/　　//正整数
		if( ! r.test(port) ){
			alert('端口号为正整数！')
			$('#ScoketPort').focus();
			return false;
		}
	}
}
</script>

<div class="col-xs-12 col-md-12">
<div class="widget">
<div class="well with-header">
<div class="header bordered-blue">添加活动</div>   
<div >
</div> 
<form action="<?=$this->baseurl?>&m=save" method="post">
		<input type="hidden" name="ActiveID" value="<?=$ActiveID?>">
        <input type="hidden" name="value[GameID]" value="<?=$value['GameID']?>">
        <input type="hidden" name="ChannelID" value="<?=$value['ChannelID']?>">
        <input type="hidden" name="RoomID" value="<?=$value['RoomID']?>">
		<table class="table" width="100%">            
			<tr>
				<td width="80">活动名称</td>
				<td><input name="value[ActiveName]" type="text" class="form-control" value="<?=$value[ActiveName]?>"></td>
			</tr>
           
             <tr>
				<td>来源渠道</td>
				<td>
                <select <?php if($ActiveID) echo 'disabled="disabled"'; ?>  name="value[ChannelID]" id="ChannelID">	
                <?php if (count($channel_list)>1){ ?>
                <option value="0">--请选择渠道--</option>		
                <?php }?>					
						<?php foreach($channel_list as $v){?>
						<option <?=($value['ChannelID'] == $v[ChannelID])?'selected':''?> value="<?=$v['ChannelID']?>"><?=$v['ChannelName']?></option>
						<?php }?>
				</select>
                <font color="#FF0000">添加成功后不可再更改！</font>
               </td>
			</tr>
            
             <tr>
				<td>活动状态</td>
				<td>
                <input name="value[Status]" type="radio" class="set" value="0" <?php if ($value[Status] == 0){echo 'checked';} ?>/>
                未开始
                <input name="value[Status]" type="radio" class="set" value="1" <?php if ($value[Status] == 1){echo 'checked';} ?>/>
                <font  color="green">进行中</font>  
                <input name="value[Status]" type="radio" class="set" value="2" <?php if ($value[Status] == 2){echo 'checked';} ?>/>
                <font color="#FF0000">已结束</font>  
                <?php if ($_SESSION['GroupID'] == 1){ ?>    
                  <input name="value[Status]" type="radio" class="set" value="3" <?php if ($value[Status] == 3){echo 'checked';} ?>/>
                试玩   
                <?php }?>    
                </td>
			</tr>
            
             <tr>
				<td>选择游戏</td>
				<td>
                <select <?php if($ActiveID) echo 'disabled="disabled"'; ?> onchange="select_game()"  name="value[RoomID]" id="RoomID">	
              
                  <?php if (count($room_list)>1){ ?>
                 <option value="0">--请选择游戏--</option>		
                <?php }?>				
						<?php foreach($room_list as $v){?>
						<option <?=($value['RoomID'] == $v[RoomID])?'selected':''?> value="<?=$v['RoomID']?>"><?=$v['GameName']?></option>
						<?php }?>
				</select>
                <font color="#FF0000">添加成功后不可再更改！</font>
               </td>
			</tr>
              <tr id="ScoketPort_tr"  <?php if ($value['RoomID'] !=3) echo 'style="display:none;"'; ?>>
				<td width="80">Scoket端口</td>
				<td><input    name="value[ScoketPort]" type="text" class="form-control"  readonly="readonly" id="ScoketPort" value="<?=$value[ScoketPort]?>"> <font color="#FF0000"></font></td>
               
			</tr>
            
            
            <tr>
				<td>是否更新UI</td>
				<td>
                <input name="value[updateUI]" checked="checked" type="radio" class="set" value="0" />
                否
                <input name="value[updateUI]" type="radio" class="set" value="1" />
                是
                  
                </td>
			</tr>
            
             <tr>
				<td>是否更新规则</td>
				<td>
                <input name="value[updateRule]" checked="checked" type="radio" class="set" value="0" />
                否
                <input name="value[updateRule]" type="radio" class="set" value="1" />
                是
                  
                </td>
			</tr>
            
            
			 <tr>
				<td>活动备注</td>
				<td><textarea rows="5" cols="" name="value[Remark]" class="form-control"><?=$value[Remark]?></textarea></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
                <input type="submit" name="submit" value=" 提 交 " class="btn btn-blue" tabindex="3" /> &nbsp;&nbsp;&nbsp;
                <input type="button"   value=" 取 消 " class="btn" onclick="location.href='<?=$this->baseurl?>&m=index'" />
                </td>
			</tr>
		</table>
	</form>
  <iframe id="select_game" frameborder="0" src="<?=$this->baseurl?>&m=select_game" width="100%" height="600px">

</iframe> 
</div>


</div>
</div>
<?php $this->load->view('admin/footer');?>