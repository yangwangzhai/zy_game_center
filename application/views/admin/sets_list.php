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
function urlDialog(urls,thetitle) {
	$.dialog({id:"comDialogID",content:"url:"+urls,title:thetitle,padding:0}).max();
}
</script>
<div class="mainbox">
 <?php echo zy_btn('yxjl',' + 添加','  onclick="urlDialog(\'index.php?d=admin&c=group&m=add\',\'dddd\')" ') . '<br>';;?>
  
	<span style="float: right">

		<form action="<?=$this->baseurl?>&m=index" method="post">
			<input type="hidden" name="catid" value="<?=$catid?>"> <input
				type="text" name="keywords" value=""> <input type="submit"
				name="submit" value=" 搜索 " class="btn">
		</form>
	</span> 
	


		<input type="hidden" name="catid" value="<?=$catid?>">
	<form action="<?=$this->baseurl?>&m=delete" method="post">
		<table width="69%" border="0" cellpadding="3" cellspacing="0" class="datalist fixwidth" id="sortTable">
			<tr>
				<th width="30"></th>
				<th width="30">排序</th>

				<th width="80">头像</th>
                <th  align="left">微信昵称</th>
				<th  align="left">得分</th>
                <th  align="left">游戏时间</th>
                <th  align="left">具体时间</th>
                <th  align='left'>数据提交状态</th>
                <th width="200"  align="left">浏览器</th>
                <th  align="left">ip</th>
                 <th width="200"  align="left">来源地址</th>
				<th >操作</th>

			</tr>

    <?php foreach($list as $key=>$r) {?>
    <tr class="sortTr">
		<td><?php if(!$r['islock']){?>
				<input type="checkbox" name="delete[]" value="<?=$r['id']?>"class="checkbox" />
			<?php }?>
		</td>

				<td><?=$key+1 ?></td>
				<td><img src="<?=$r['img_url']?>" width="40" height="40" /></td>
                <td><?=$r['nickname']?></td>
                <td><?=$r['score']?></td>
				<td title="<?=date('Y-m-d H:i:s',$r['addtime'])?>"><?=timeFromNow($r['addtime'])?></td>
<td title="<?=date('Y-m-d H:i:s',$r['addtime'])?>"><?=date('Y-m-d H:i:s',$r['addtime'])?></td>
 				<td><?=$r['status']?'<font color="red">失败</font>':'<font color="green">成功</font>'?></td>
                <td><?=$r['browser']?></td>
                  <td><?=$r['ip']?></td>
                    <td><?=$r['comefrom']?></td>
				<td>
                <?php if(!$r['islock']){?>
                <a href="<?=$this->baseurl?>&m=delete&catid=<?=$catid?>&id=<?=$r['id']?>" onclick="return confirm('确定要删除吗？');">删除</a>
                <?php }?>
                </td>
			</tr>
    <?php }?>
			<tr>
				<td colspan="11"><input type="checkbox" name="chkall" id="chkall"onclick="checkall('delete[]')" class="checkbox" /><label for="chkall">全选/反选</label>&nbsp; <input type="submit" value=" 删除 "class="btn" onclick="return confirm('确定要删除吗？');" /> &nbsp;</td>
			</tr>
		</table>

		<div class="margintop">共：<?=$count?>条&nbsp;&nbsp;<?=$pages?></div>

	</form>

</div>


<?php $this->load->view('admin/footer');?>