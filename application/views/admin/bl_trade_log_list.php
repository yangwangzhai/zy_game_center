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
	
	
	 $(".lookinfo").click(function(){ 
		  	var postdata = $(this).data('postdata');
			var returndata = $(this).data('returndata');			
			var url = $(this).data('url');	
				url = '地址：' + url + '<br><br>'; 
			var postdata_text = 'POST参数：<br>';
			if(typeof(postdata) == 'object'){
				for(var key in postdata){
					postdata_text += key + '：' +  postdata[key] + '<br>';
				}
			}
			postdata_text += '<br>';
			
			var returndata_text = '返回参数：<br>';
			if(typeof(returndata) == 'object'){
				for(var key in returndata){
					returndata_text += key + '：' +  returndata[key] + '<br>';
				}
			}
			returndata_text += '<br>';
			var content =url + postdata_text + returndata_text ;
								var title = '查看信息';
								$.dialog({
										id: 'a15',
										max: false,    
										min: false,
										//height: 350 ,
										width: 350,
										padding: '10px' ,
										title:  title,
										lock: true,
										content: content,//'<img  src="'+img[index]+'" width="100%" height="auto" />',
										cancelVal: '关闭',
										cancel: true /*为true等价于function(){}*/
								});
			
		  })
	
});

</script>

<div class="col-xs-12 col-md-12">
<div class="widget">
<div class="well with-header wellpadding">
<div class="header bordered-blue">龙币POST记录</div> 
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
    <table  width="100%" border="0" cellpadding="3" cellspacing="0" class="table table-hover table-bordered " id="sortTable">
      <tr>
        <th width="30"></th>
        <th width="80">游戏ID</th>        
        <th  align="left" width="">OPENID</th>
        <!--<th  align="left" width="">发送的参数</th>
        <th  align="left" width="">返回的参数</th>-->
        <th  align="left" width="">POST地址</th>       
        <th  align="left" width="">IP地址</th>
        <th  align="left" width="">状态</th>
        <th  align="left" width="">ChannelID</th>
        <th  align="left" width="">ActiveID</th>
        <th  align="left" width="">RoomID</th>
        <th  align="left" width="">时间</th>
        <th >操作</th>
      </tr>
      <?php foreach($list as $key=>$r) {?>
      <tr class="sortTr">
        <td><?php if(!$r['islock']){?>
          <input type="checkbox" name="delete[]" value="<?=$r['id']?>"class="checkbox" />
          <?php }?></td>
        <td><?=$r['gameid']?></td>
        
        <td><?=($r['openid'])?></td>
       <!-- <td style="word-break:break-all"><?=$r['postdata']?></td>
        <td style="word-break:break-all"><?=$r['returndata']?></td>-->
        <td style="word-break:break-all">
		<?=$r['postUrl']?> &nbsp; &nbsp;
        <a data-postdata='<?=$r['postdata']?>' href="javascript:" data-url='<?=$r['postUrl']?>'  data-returndata='<?=$r['returndata']?>' class="lookinfo">查看</a>
        </td>
        <td><?=$r['ip']?></td>
        <td><?=$r['status']?></td>
        <td><?=$r['ChannelID']?></td>
        <td><?=$r['ActiveID']?></td>
        <td><?=$r['RoomID']?></td>
        <td title="<?=date('Y-m-d H:i:s',$r['addtime'])?>"><?=timeFromNow($r['addtime'])?></td>
        <!-- <td title="<?=date('Y-m-d H:i:s',$r['addtime'])?>"><?=date('Y-m-d H:i:s',$r['addtime'])?></td> -->
        
        <td><?php if(!$r['islock']){?>
          <span class="btn btn-danger btn-xs icon-only white">
          <a href="<?=$this->baseurl?>&m=delete&catid=<?=$catid?>&id=<?=$r['id']?>" onclick="return confirm('确定要删除吗？');"><i class="fa fa-trash" title="删除"></i></a></span>
          <?php }?></td>
      </tr>
      <?php }?>
      <tr>
        <td colspan="11"><input type="checkbox" name="chkall" id="chkall"onclick="checkall('delete[]')" class="checkbox" />
          <label for="chkall">全选/反选</label>
          &nbsp;
          <input type="submit" value=" 删除 "class="btn" onclick="return confirm('确定要删除吗？');" />
          &nbsp;</td>
      </tr>
    </table>
    <div class="margintop">共：
      <?=$count?>
      条&nbsp;&nbsp;
      <?=$pages?>
    </div>
  </form>
</div>
</div>
</div>
</div>
<?php $this->load->view('admin/footer');?>
