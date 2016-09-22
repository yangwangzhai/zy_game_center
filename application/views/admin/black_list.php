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

<div class="mainbox"> <span style="float: right">
  <form action="<?=$this->baseurl?>&m=index" method="post">
    <input type="hidden" name="catid" value="<?=$catid?>">
    <input
				type="text" name="keywords" value="">
    <input type="submit"
				name="submit" value=" 搜索 " class="btn">
  </form>
  </span>
  <div style="clear:both;"></div>
  <input type="hidden" name="catid" value="<?=$catid?>">
  
</div>
<div class="col-xs-12 col-md-12">
<div class="widget">
<div class="well with-header wellpadding">
<div class="header bordered-blue">黑名单</div>   
<div >
    <div class="form-inline">
    	<span >
		 <form action="<?=$this->baseurl?>&m=index" method="post">
        
        <div class="form-group">
                                                        <span class="input-icon">
                                                            <input type="text" name="catid"  value="" class="form-control input-sm">
                                                            <i class="glyphicon glyphicon-search blue"></i>
                                                           
                                                        </span>
                                                    </div>
         <div class="form-group"> <input type="submit"name="submit" value=" 搜索 " class="btn btn-blue"></div>  
        
          
          </div>  
		</form>
          <input type="hidden" name="catid" value="<?=$catid?>">  
	</span> 
 </div>
			<form action="<?=$this->baseurl?>&m=delete" method="post">
    <table width="100%" border="0" cellpadding="3" cellspacing="0" class="table table-hover table-bordered" id="sortTable">
      <tr>
        <th width="30"></th>
        <th class="td_l">微信昵称</th>
        <th  align="left">Openid</th>
        <th   class="td_l">列黑原因</th>
        <th  class="td_l">来源</th>
        <th   class="td_l">时间</th>
        <th >操作</th>
      </tr>
      <?php foreach($list as $key=>$r) {?>
      <tr class="sortTr">
        <td  class="td_c"><input type="checkbox" name="delete[]" value="<?=$r['ActiveBlackID']?>"class="checkbox" /></td>
        <td class="td_l"><?=$r['Nickname']?></td>
        <td class="td_c"><?=$r['Openid']?></td>
        <td class="td_l"><?=$r['Remark']?></td>
        <td>渠道：
          <?=$r['ChannelName']?>
          <br>
          活动：
          <?=$r['ActiveName']?>
          <br>
          游戏：
          <?=$r['GameName']?>
          <br></td>
        <td> 列入：[
          <?=$r['AddUName']?>
          ] =>
          <?=date('Y-m-d H:i:s',$r['AddTime'])?>
          <br>
          解禁：
          <?=$r['ReleaseText']?></td>
        <td  class="td_c">
        <?php if(empty($r['ReleaseTime'])){ ?>
			<span class="btn btn-success btn-xs icon-only white"><?=zy_a('Black_release','<i class="fa fa-user-times" title="解禁"></i>',$this->baseurl.'&m=release&id='.$r['ActiveBlackID'],'onclick="return confirm(\'确定要解禁此黑名单吗？\');"')?></span>
		<?php }else{ ?>
			<span class="btn btn-success btn-xs icon-only white"><a href="javascript:;"><i class="fa fa-user" title="已解禁"></i></a></span>
		<?php }
			  ?>
		&nbsp;&nbsp;
		<span class="btn btn-danger btn-xs icon-only white"><?=zy_a('Black_del','<i class="fa fa-trash" title="删除"></i>',$this->baseurl.'&m=delete&id='.$r['ActiveBlackID'],'onclick="return confirm(\'确定要删除吗？\');"')?></span>
        </td>
      </tr>
      <?php }?>
      <tr>
        <td colspan="11"><input type="checkbox" name="chkall" id="chkall"onclick="checkall('delete[]')" class="checkbox" />
          <label for="chkall">全选/反选</label>
          &nbsp;
         <?php echo zy_btn('Black_del','删除',' class="btn btn-danger" onclick="return confirm(\'确定要删除吗？\');" ', 'submit');?>
          &nbsp;<div class="margintop">共：<?=$count?>条&nbsp;&nbsp;<?=$pages?></div></td>
      </tr>
    </table>
    
  </form>

</div> 
	</div>

    
	</form>

</div>
</div>
<?php $this->load->view('admin/footer');?>
