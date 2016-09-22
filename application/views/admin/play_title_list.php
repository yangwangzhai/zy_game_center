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
function getstate(){		
		$('#submit').trigger("click");
	}	
</script>
<div class="mainbox">
<font color="#FF0000">人均参与次数：<b><?=$vga?></b>次/人</font>
	<span style="float: right">
   
		<form action="<?=$this->baseurl?>&m=index" method="post">
        
         <select  onchange="getstate()" style="width:auto"  name="blacklist">	
    						<option  value="">全部</option>					
                            <option <?php if($blacklist =='0') echo "selected"; ?> value="0">白名单</option>
                            <option <?php if($blacklist =='1') echo "selected"; ?> value="1">黑名单</option>
                  </select>     
        
        
         按总次数
    <select  onchange="getstate()" style="width:auto"  name="order">	
    						<option  value="">---</option>					
                            <option <?php if($order =='desc') echo "selected"; ?> value="desc">降序</option>
                            <option <?php if($order =='asc') echo "selected"; ?> value="asc">升序</option>
                  </select>     
    排序
			<input type="hidden" name="catid" value="<?=$catid?>"> <input
				type="text" name="keywords" value=""> <input type="submit"
			 id="submit"	name="submit" value=" 搜索 " class="btn">
		</form>
	</span> 


		<input type="hidden" name="catid" value="<?=$catid?>">
		<table width="99%" border="0" cellpadding="3" cellspacing="0"
			class="datalist fixwidth" id="sortTable">
			<tr>
				<th width="30">排序</th>
				<th >头像</th>
                <th align="left">微信昵称</th>
				<th align="left">性别</th>
                <th align="left">openid</th>
				
				<th >游戏次数</th>
				<th >最高积分</th>
                <th >参与时间</th>
				<th >活跃时间</th>
			<!--	<th >操作</th>-->

			</tr>

    <?php $sex = array('未知','男','女');foreach($list as $key=>$r) {?>
    <tr class="sortTr">


				<td><?=$key+1?></td>
		        <td><img src="<?=$r['head_img']?>" width="40" height="40" /></td>
                <td><?=$r['nickname']?></td>
		        <td> <?=$sex[$r['sex']]?>
              </td>
		        <td><?=$r['openID']?></td>
		      
		        <td><?=$r['num']?></td>
                <td><?=$r['score']?></td>
                  <td title="<?=times($r['mintime'],1)?>"><?=timeFromNow($r['mintime'])?></td>
		        <td title="<?=times($r['maxtime'],1)?>"><?=timeFromNow($r['maxtime'])?></td>


			<!--	<td>
               
                </td>-->
			</tr>
    <?php }?>
		</table>

		<div class="margintop">共：<?=$count?>条&nbsp;&nbsp;<?=$pages?></div>

	</form>

</div>


<?php $this->load->view('admin/footer');?>