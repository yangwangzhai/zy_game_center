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
<div class="header bordered-blue">行为监控</div>   
<div >
<div class="form-inline">
    	<span >

          
          <form action="<?=$this->baseurl?>&m=index" method="post">
        <div class="form-group">
                                                        <span class="input-icon">
                                                            <input type="text" name="catid"  value="<?=$catid?>" class="form-control input-sm">
                                                            <i class="glyphicon glyphicon-search blue"></i>
                                                           
                                                        </span>
                                                    </div>
         <div class="form-group"> <input type="submit"name="submit" value=" 搜索 " class="btn btn-blue"></div>
         <div class="form-group"><?php echo zy_btn('ClearLog',' 清除所有记录',' class="btn btn-danger"  onclick="clearAll()" ');?>  </div>
          <input type="hidden" name="catid" value="<?=$catid?>">  
		</form>
          
	</span> 
 </div>
<table width="100%" border="0" cellpadding="3" cellspacing="0" class="table table-hover table-bordered" id="sortTable">
			<tr>
				<th width="30">UID</th>
				<th>管理员</th>
				<th>来源URL</th>
				<th>控制器</th>
				<th>方法</th>
				<th>POST</th>
				<th>操作系统</th>
				<th>IP</th>
				<th>浏览器</th>
				
                <th>操作时间</th>
			<!--	<th >操作</th>-->

			</tr>

    <?php foreach($list as $key=>$r) {?>
    <tr class="sortTr">


				<td><?=$r['UID']?></td>
				<td class="td_c"><?=getUserName($r['UID'])?></td>
				<td><?=$r['Url']?></td>
				<td class="td_c"><?=$r['Controller']?></td>
				<td class="td_c"><?=$r['Method']?></td>
				<td class="td_c"><?=$r['Param']?'<a href="javascript:;" onclick="comDialog(\''.$r['Param'].'\',\'POST参数\')">点击查看</a>':'--'?></td>
				<td class="td_c"><?=$r['Os']?></td>
				<td class="td_c"><?=$r['Ip']?></td>
                <td class="td_c"><?=$r['Browser']?></td>
                
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
function clearAll(){
	if(confirm('确定要清空记录吗？')){
		location.href='index.php?d=admin&c=behavior&m=delete';
	}
	
}

	
</script>
<?php $this->load->view('admin/footer');?>