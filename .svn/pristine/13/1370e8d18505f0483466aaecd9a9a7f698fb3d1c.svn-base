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
<div class="col-xs-12 col-md-12">
<div class="widget">
<div class="well with-header wellpadding">
<div class="header bordered-blue">权限列表</div>   
<div >
<div class="form-inline">
    	<span >

          
  
   <form action="<?=$this->baseurl?>&m=index" method="post">
    <div class="form-group">
    <span class="input-icon">
			<input type="hidden" name="catid" value="<?=$catid?>"> <input
				type="text" name="keywords" value="" class="form-control input-sm">
                 <i class="glyphicon glyphicon-search blue"></i>
</span></div> 
     <div class="form-group"><input type="submit" name="submit" value=" 搜索 " class="btn btn-blue"></div>
		</form>
         
          <input type="hidden" name="catid" value="<?=$catid?>">  
	
          
	</span> 
 </div>
<form action="<?=$this->baseurl?>&m=delete" method="post">
    <table width="100%" border="0" cellpadding="3" cellspacing="0" class="table table-hover table-bordered" id="sortTable">
      <tr>
        <th width="30"></th>
        <th width="200" class="td_l">原文件名</th>
        <th nowrap="nowrap" align="left">文件大小</th>
        <th nowrap="nowrap"  class="td_l">路径</th>
        <th nowrap="nowrap" class="td_l">来源</th>
        <th nowrap="nowrap" class="td_l">已同步的IP</th>
        <th nowrap="nowrap" class="td_l">同步时间</th>
        <th nowrap="nowrap"  class="td_l">添加时间</th>
        <th >操作</th>
      </tr>
      <?php foreach($list as $key=>$r) {?>
      <tr class="sortTr">
        <td  class="td_c"><input type="checkbox" name="delete[]" value="<?=$r['id']?>"class="checkbox" /></td>
        <td class="td_l"><?=$r['file_name']?></td>
        <td class="td_c"><?=$r['file_size']?></td>
        <td class="td_l"><?=$r['filepath']?></td>
        <td nowrap="nowrap"><?=$r['fromIP']?></td>
        <td nowrap="nowrap"><?=$r['updateIP']?></td>
        <td title="<?=$r['updatetime_title']?>"><?=$r['updatetime']?></td>
        <td title="<?=date('Y-m-d H:i:s',$r['addtime'])?>"><?=timeFromNow($r['addtime'])?></td>
        <td  class="td_c">&nbsp;&nbsp;
          <span class="btn btn-danger btn-xs icon-only white"><?=zy_a('Attachment_del','<i class="fa fa-trash" title="删除"></i>',$this->baseurl.'&m=delete&id='.$r['id'],'onclick="return confirm(\'确定要删除吗？\');"')?></span></td>
      </tr>
      <?php }?>
      <tr>
        <td colspan="11"><input type="checkbox" name="chkall" id="chkall"onclick="checkall('delete[]')" class="checkbox" />
          <label for="chkall">全选/反选</label>
          &nbsp; <?php echo zy_btn('Attachment_del','删除',' class="btn btn-danger" onclick="return confirm(\'确定要删除吗？\');" ', 'submit');?> &nbsp;</td>
      </tr>
      <tr ><td colspan="9"> <div class="margintop">共：<?=$count?>条&nbsp;&nbsp;<?=$pages?></div></td></tr>
    </table>
   
  </form>
</div> 
</div>
</div>
</div>
<?php $this->load->view('admin/footer');?>
