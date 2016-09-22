<?php $this->load->view('admin/header');?>
<script type="text/javascript">
$(function($)
{
	// 数据列表 点击开始排序
	var sortFlag = 0;	
	$("#sortTable th").click(function()
	{		
		var tdIndex = $(this).index();		
		var temp = "";
		var trContent = new Array();
		//alert($(this).text());	
		
		// 把要排序的字符放到行的最前面，方便排序
		$("#sortTable .sortTr").each(function(i){ 
			temp = "##" + $(this).find("td").eq(tdIndex).text() + "##";			
			trContent[i] = temp + '<tr class="sortTr">' + $(this).html() + "</tr>";	
				
		});
		
		// 排序
		if(sortFlag==0) {
			trContent.sort(sortNumber);
			sortFlag = 1;
		} else {
			trContent.sort(sortNumber);
			trContent.reverse();
			sortFlag = 0;
		}
		
		// 删除原来的html 添加排序后的
		$("#sortTable .sortTr").remove();
		$("#sortTable tr").first().after( trContent.join("").replace(/##(.*?)##/, "") );		
	});
	
});

</script>

<div class="col-xs-12 col-md-12">
<div class="widget">
<div class="well with-header wellpadding">
<div class="header bordered-blue">异常监控</div>   
<div >
<div class="form-inline">
    	
	<span >
		<form action="<?=$this->baseurl?>&m=index" method="post">
        <input type="hidden" name="catid" value="<?=$catid?>">
         <div class="form-group"><span class="input-icon">
                                                            <input type="text" name="keywords"  class="form-control input-sm">
                                                            <i class="glyphicon glyphicon-search blue"></i>
                                                           
                                                        </span>
                                                        
   </div>
                
                 <div class="form-group"><input type="submit" name="submit" value=" 搜索 " class="btn btn-blue"></div>
		</form>
	</span> 
	
	<span style="margin-left:10px;">选择渠道：</span>
    <select id="selectChannel" onchange="select()">
    	<option value="0">全部</option>
    	<?php foreach($CList as $v){?>
		<option <?=($ChannelID == $v['ChannelID'])?'selected="selected"':''?> value="<?=$v['ChannelID']?>"><?=$v['ChannelName']?></option>
    	<?php }?>
    </select>

    <span style="margin-left:10px;">选择活动：</span>
    <select id="selectActive" onchange="select()">
    	<option value="0">全部</option>
    	<?php foreach($AList as $v){?>
		<option <?=($ActiveID == $v['ActiveID'])?'selected="selected"':''?> value="<?=$v['ActiveID']?>"><?=$v['ActiveName']?></option>
    	<?php }?>
    </select>

    <span style="margin-left:10px;">选择游戏：</span>
    <select id="selectGame" onchange="select()">
    	<option value="0">全部</option>
    	<?php foreach($GList as $v){?>
		<option <?=($RoomID == $v['RoomID'])?'selected="selected"':''?> value="<?=$v['RoomID']?>"><?=$v['GameName']?></option>
    	<?php }?>
    </select>

		<input type="hidden" name="catid" value="<?=$catid?>"> 
 </div>
<table width="100%" border="0" cellpadding="3" cellspacing="0" class="table table-hover table-bordered" id="sortTable">
			<tr>
				<th width="30">排序</th>
				<th>openid</th>
				<th>类型</th>
				<th>所属渠道</th>
				<th>所属活动</th>
				<th>所属游戏</th>
				<th class="td_l">错误信息</th>
				<th class="td_l">IP</th>
				<th class="td_l">浏览器</th>
                <th>添加时间</th>
			<!--	<th >操作</th>-->

			</tr>

    <?php foreach($list as $key=>$r) {?>
    <tr class="sortTr">


				<td><?=$key+1?></td>
				<td class="td_c"><?=$r['Openid']?></td>
				<td class="td_c"><?=$type[$r['Type']]?></td>
				<td class="td_c"><?=$r['ChannelName']?></td>
				<td class="td_c"><?=$r['ActiveName']?></td>
				<td class="td_c"><?=$r['GameName']?></td>
                <td><?=$r['Content']?></td>
                <td><?=$r['Ip']?></td>
                <td><?=$r['Browser']?></td>
				<td class="td_c" title="<?=times($r['AddTime'],1)?>"><?=timeFromNow($r['AddTime'])?></td>

			<!--	<td>

                </td>-->
			</tr>
    <?php }?>
    <tr ><td colspan="11"> <div class="margintop">共：<?=$count?>条&nbsp;&nbsp;<?=$pages?></div></td></tr>
		</table>
</div> 
</div>
</div>
</div>
<script>
	function select(){
		var RoomID = $('#selectGame').val();
		var ChannelID = $('#selectChannel').val();
		var ActiveID = $('#selectActive').val();
		window.location.href="<?=$this->baseurl?>&RoomID="+RoomID+"&ChannelID="+ChannelID+"&ActiveID="+ActiveID;
	}

	
</script>
<?php $this->load->view('admin/footer');?>