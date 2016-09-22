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
<div class="header bordered-blue">游戏复用资原管理</div>   
<div >
    <div class="form-inline">
    	<span >
	<form action="<?=$this->baseurl?>&m=index" method="post">
          <div class="form-group"> <span style="margin-left:10px;">选择游戏：</span>
    <select id="selectGame" onchange="selectGame()">
    	<option value="0">全部</option>
    	<?php foreach($GameList as $v){?>
		<option <?=($RoomID == $v['RoomID'])?'selected="selected"':''?> value="<?=$v['RoomID']?>"><?=$v['GameName']?></option>
    	<?php }?>
    </select></div>
        <div class="form-group">
                                                        <span class="input-icon">
                                                            <input type="text" name="keywords"  value="" class="form-control input-sm">
                                                            <i class="glyphicon glyphicon-search blue"></i>
                                                           
                                                        </span>
                                                    </div>
         <div class="form-group"> <input type="submit"name="submit" value=" 搜索 " class="btn btn-blue"></div>  
          <div class="form-group">
           <?=zy_btn('GameRegTable_add',' + 添加 ','class="btn btn-success"  onclick="location.href=\'index.php?d=admin&c=gameRegTable&m=add\'" ');?>
          </div>  
		</form>
          
	</span> 
 </div>
			<form action="<?=$this->baseurl?>&m=delete" method="post">
		<table width="100%" border="0" cellpadding="3" cellspacing="0"
			class="table table-hover table-bordered" id="sortTable">
			<tr>
				<th width="30"></th>
				<th align="left">ID</th>
                <th  class="td_l">游戏</th>
				<th  class="td_l">复用母表名称</th>
				<th  class="td_l">复用母表</th>
				<th  class="td_l">备注</th>
				<th  class="td_l">最近更新</th>
				<th class="td_l">操作</th>
			</tr>

    <?php 
	 foreach($list as $key=>$r) {?>
    <tr class="sortTr">
				<td  class="td_c">
                <input type="checkbox" name="delete[]" value="<?=$r['RepID']?>"class="checkbox" />

                </td>
				<td  class="td_c"><?=$r['RepID']?></td>
                <td><?=getGameName($r['RoomID'])?></td>
				<td><?=$r['BaseName']?></td>
				<td><?=$r['BaseTable']?></td>
				<td><?=$r['Remark']?></td>
				
				<td><?=getUserName($r['UID'])?>,<?=timeFromNow($r['UpdateTime'])?></td>
				<td>
					<span class="btn btn-blue btn-xs icon-only white"><?=zy_a('BaseTable_view','<i class="fa fa-gears" title="母数据管理"></i>',$tableType[$r['BaseTable']].'&RepID='.$r['RepID'].'&RoomID='.$r['RoomID']);?></span>
					&nbsp;&nbsp;
					<span class="btn btn-success btn-xs icon-only white"><?=zy_a('GameRegTable_update','<i class="fa fa-edit" title="编辑"></i>',$this->baseurl.'&m=edit&RepID='.$r['RepID']);?></span>
					&nbsp;&nbsp;
                	<span class="btn btn-danger btn-xs icon-only white"><?=zy_a('GameRegTable_del','<i class="fa fa-trash" title="删除"></i>',$this->baseurl.'&m=delete&RepID='.$r['RepID'],'onclick="return confirm(\'确定要删除吗？\');"');?></span>
                	
                
                </td>
			</tr>
    <?php }?>
    <tr ><td colspan="8"> <div class="margintop">共：<?=$count?>条&nbsp;&nbsp;<?=$pages?></div></td></tr>
		</table>

		

	</form>

</div> 
	</div>

    
	</form>

</div>
</div>
<script>
	function selectGame(){
		var RoomID = $('#selectGame').val();
		window.location.href="<?=$this->baseurl?>&RoomID="+RoomID;
	}
</script>

<?php $this->load->view('admin/footer');?>