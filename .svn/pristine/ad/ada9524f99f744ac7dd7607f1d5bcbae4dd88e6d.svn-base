<?php $this->load->view('admin/header');?>
<script type="text/javascript">

function getstate(){		
		$('#submit').trigger("click");
	}	
</script>
<div class="col-xs-12 col-md-12">
<div class="widget">
<div class="well with-header wellpadding">
<div class="header bordered-blue">游戏参与用户</div> 
<div>

	<div class="form-inline">
    <font color="#FF0000">人均参与次数：<b><?=$vga?></b>次/人</font>
		<span>
		<form action="<?=$this->baseurl?>&m=index<?=$game_sign?>" method="post">
        
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
			 id="submit"	name="submit" value=" 搜索 " class="btn  btn-blue">
		</form>
		</span> 
 </div>   



		<input type="hidden" name="catid" value="<?=$catid?>">
		<table width="100%" border="0" cellpadding="3" cellspacing="0"
			class="table table-hover table-bordered"  id="sortTable">
			<tr>
				<th class="td_c"  width="30">排序</th>
				<th class="td_c" >头像</th>
                <th class="td_l" >微信昵称</th>
				<th align="left">性别</th>
                <th class="td_l">openid</th>
				
				<th class="td_l">游戏次数</th>
				<th class="td_l">最高积分</th>
                <th class="td_l">参与时间</th>
				<th class="td_l">活跃时间</th>
			<!--	<th >操作</th>-->

			</tr>

    <?php $sex = array('未知','男','女');foreach($list as $key=>$r) {?>
    <tr class="sortTr">


				<td class="td_c" ><?=$key+1?></td>
		        <td class="td_c" ><img src="<?=$r['head_img']?>" width="40" height="40" /></td>
                <td><?=$r['nickname']?></td>
		        <td class="td_c"> <?=$sex[$r['sex']]?>
              </td>
		        <td ><?=$r['openID']?></td>
		      
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
</div>
</div>
</div>


<?php $this->load->view('admin/footer');?>