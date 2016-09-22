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
<div class="header bordered-blue">游戏记录</div> 
<div>
	<div class="form-inline">
		<span>
			<form action="<?=$this->baseurl?>&m=index" method="post">
				<div class="form-group">
					<span class="input-icon">
						<input type="text" name="keywords" value="" class="form-control input-sm"> 
						<i class="glyphicon glyphicon-search blue"></i>
					</span>
				</div>
				<div class="form-group">
					<input type="submit" name="submit" value=" 搜索 " class="btn btn-blue">
				</div>
			</form>
		</span> 
	    
	</div>    
	<form action="<?=$this->baseurl?>&m=delete" method="post">
		<table width="100%" border="0" cellpadding="3" cellspacing="0" class="table table-hover table-bordered" id="sortTable">
			<tr>
				<th width="30"></th>
				<th width="30">排序</th>
                <th>Openid</th>
				<th>1点</th>
				<th>2点</th>
				<th>3点</th>
				<th>4点</th>
				<th>5点</th>
				<th>6点</th>
				<th>大</th>
				<th>小</th>
				<th>单</th>
				<th>双</th>
                <th>游戏结果</th>
                <th>明细</th>
                <th>输(赢)龙币数</th>
                <th>状态</th>
                <th>游戏时间</th>
				<th width="100">操作</th>

			</tr>

    <?php foreach($list as $key=>$r) {?>
    <tr class="sortTr">
		<td>
				<input type="checkbox" name="delete[]" value="<?=$r['id']?>"class="checkbox" />
			
		</td>

				<td><?=$key+1 ?></td>
                <td class="td_l"><?=$r['Openid']?></td>
                <td class="td_c"><?=$r['Bet1']?></td>
                <td class="td_c"><?=$r['Bet2']?></td>
                <td class="td_c"><?=$r['Bet3']?></td>
                <td class="td_c"><?=$r['Bet4']?></td>
                <td class="td_c"><?=$r['Bet5']?></td>
                <td class="td_c"><?=$r['Bet6']?></td>
                <td class="td_c"><?=$r['BetBig']?></td>
                <td class="td_c"><?=$r['BetSmall']?></td>
                <td class="td_c"><?=$r['BetSingle']?></td>
                <td class="td_c"><?=$r['BetDouble']?></td>
                <td class="td_c"><?=$r['Count']?>点</td>
				<td class="td_c"><a href="javascript:;" onclick="urlDialogCus('<?=$this->baseurl?>&m=showRemark&id=<?=$r['id']?>','明细')">查看明细</a></td>
				
 				<td class="td_c"><?=($r['Result']<0)?'输'.abs($r['Result']):'赢'.abs($r['Result'])?></td>
 				<td class="td_c"><?=$r['Status']?'<span style="color:green;">成功</span>':'<span style="color:red;">失败</span>'?></td>
                <td class="td_c" title="<?=date('Y-m-d H:i:s',$r['AddTime'])?>"><?=timeFromNow($r['AddTime'])?></td>
				<td class="td_c">
				<span class="btn btn-success btn-xs icon-only white">
                <a href="javascript:;" onclick="addBlackList(<?=$r['ActiveID']?>,'<?=$r['Openid']?>','<?=$r['NickName']?>');"><i class="fa fa-ban" title="加入黑名单"></i></a></span>
                &nbsp;&nbsp;
                <span class="btn btn-danger btn-xs icon-only white">
                <a href="<?=$this->baseurl?>&m=delete&id=<?=$r['id']?>" onclick="return confirm('确定要删除吗？');"><i class="fa fa-trash" title="删除"></i></a></span>
                
                </td>
			</tr>
    <?php }?>
			<tr>
				<td colspan="19"><input type="checkbox" name="chkall" id="chkall"onclick="checkall('delete[]')" class="checkbox" /><label for="chkall">全选/反选</label>&nbsp; <input type="submit" value=" 删除 "class="btn" onclick="return confirm('确定要删除吗？');" /> &nbsp;</td>
			</tr>
		</table>

		<div class="margintop">共：<?=$count?>条&nbsp;&nbsp;<?=$pages?></div>

	</form>

</div>
</div>
</div>
</div>


<?php $this->load->view('admin/footer');?>