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
<div class="header bordered-blue">游戏接口管理</div>   
<div >
<div class="form-inline">
    	<span >

          <div class="form-group"> 
          <span style="margin-left:10px;">选择游戏：</span>
    <select id="selectGame" onchange="selectGame()">
    	<option value="0">全部</option>
    	<?php foreach($GameList as $v){?>
		<option <?=($RoomID == $v['RoomID'])?'selected="selected"':''?> value="<?=$v['RoomID']?>"><?=$v['GameName']?></option>
    	<?php }?>
    </select>
          </div>
          <form action="<?=$this->baseurl?>&m=index" method="post">
        <div class="form-group">
                                                        <span class="input-icon">
                                                            <input type="text" name="keywords"  value="" class="form-control input-sm">
                                                            <i class="glyphicon glyphicon-search blue"></i>
                                                           
                                                        </span>
                                                    </div>
         <div class="form-group"> <input type="submit"name="submit" value=" 搜索 " class="btn btn-blue"></div>  
          <div class="form-group">
          
            <?=zy_btn('GameAPI_add',' + 添加接口 ','class="btn btn-success"  onclick="location.href=\'index.php?d=admin&c=gameAPI&m=add\'" ');?>
          
          </div>  
		</form>
          
	</span> 
 </div>
<form action="<?=$this->baseurl?>&m=delete" method="post">
		<table width="100%" border="0" cellpadding="3" cellspacing="0" class="table table-hover table-bordered" id="sortTable">
			<tr>
				<th width="30"></th>
				<th align="left">ID</th>
                <th  class="td_l">游戏名称</th>
				<th  class="td_l">接口名称</th>
				<th  class="td_l">接口标记</th>
				<th align="left">调用次数</th>
				<th  class="td_l">鉴权IP</th>
				<th  class="td_l">校验码</th>
				<!-- <th class="td_l">接口地址</th> -->
				<th align="left">接口说明</th>
				<th align="left">接口状态</th>
				<th  class="td_l">最近更新</th>
				<th>操作</th>
			</tr>

    <?php 
	 foreach($list as $key=>$r) {?>
    <tr class="sortTr">
				<td class="td_c">
                <input type="checkbox" name="delete[]" value="<?=$r['ApiId']?>"class="checkbox" />

                </td>
				<td class="td_c"><?=$r['ApiId']?></td>
                <td><?=getGameName($r['RoomID'])?></td>
				<td><?=$r['ApiName']?></td>
				<td><?=$r['ApiSign']?></td>
				<td class="td_c"><?=$r['UseNum']?>次</td>
				<td class="td_l"><?=$r['VrIP']?></td>
				<td class="td_l"><?=$r['Vrkey']?></td>
				<!-- <td class="td_l"><?=$r['ApiUrl']?></td> -->
				<td class="td_c"><a href="javascript:;" onclick="urlDialogCus('<?=$this->baseurl?>&m=showRemark&ApiId=<?=$r['ApiId']?>','接口说明',500,300)" >点击查看</a></td>
				<td class="td_c"><?php $Status = array(0=>'停用',1=>'启用');?>
					<?=$Status[$r['Status']]?></td>
				<td><?=getUserName($r['UID'])?>,<?=timeFromNow($r['UpdateTime'])?></td>
				<td class="td_c">
					
					<span class="btn btn-success btn-xs icon-only white"><?=zy_a('GameAPI_update','<i class="fa fa-edit" title="编辑"></i>',$this->baseurl.'&m=edit&ApiId='.$r['ApiId']);?></span>
					&nbsp;&nbsp;
                	<span class="btn btn-danger btn-xs icon-only white"><?=zy_a('GameAPI_del','<i class="fa fa-trash" title="删除"></i>',$this->baseurl.'&m=delete&ApiId='.$r['ApiId'],'onclick="return confirm(\'确定要删除吗？\');"');?></span>
                	
                
                </td>
			</tr>
    <?php }?>
    <tr ><td colspan="13"> <div class="margintop">共：<?=$count?>条&nbsp;&nbsp;<?=$pages?></div></td></tr
		</table>

		
	</form>
</div> 
</div>
</div>
</div>
<script>
	function selectGame(){
		var RoomID = $('#selectGame').val();
		window.location.href="<?=$this->baseurl?>&RoomID="+RoomID;
	}
</script>

