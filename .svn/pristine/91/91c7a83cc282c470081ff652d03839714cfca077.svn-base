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
<div class="header bordered-blue">积分排行</div> 
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
				<th width="30">排序</th>
				<th  width="80">头像</th>
                <th>微信昵称</th>
				<th>积分</th>
				<th>排行</th>
                <th>游戏时间</th>
			<!--	<th >操作</th>-->

			</tr>

    <?php $paihang=$offset; foreach($list as $key=>$r) {?>
    <tr class="sortTr">


				<td><?=$key+1?></td>
				<td class="td_c"><img src="<?=$r['img_url']?>" width="40" height="40" /></td>
                <td class="td_l"><?=$r['nickname']?></td>
                <td class="td_c"><?=$r['score']?></td>
		        <td class="td_c"><?=++$paihang?></td>
				<td class="td_c" title="<?=times($r['addtime'],1)?>"><?=timeFromNow($r['addtime'])?></td>

			<!--	<td>

                </td>-->
			</tr>
    <?php }?>
		</table>

		<div class="margintop">共：<?=$count?>条&nbsp;&nbsp;<?=$pages?></div>

	</form>

</div>
</div>
</div>
</div>


<?php $this->load->view('admin/footer');?>