<?php $this->load->view('admin/header');?>
<script src="static/system/js/date/WdatePicker.js"></script>
<script type="text/javascript">
$(function($)
{
})
	 
	
function selectTime(){
  var starttime = $('#starttime').val();
  var endtime = $('#endtime').val();
  if(starttime == '' || endtime == ''){
    alert('请选择一个时间段');
    return false;
  }
  location.href="<?=$this->baseurl?>&m=index&starttime="+starttime+'&endtime='+endtime;
}


</script>
<style>
.tab_btn {
	width: 100px;
	height: 30px;
	margin-right: 10px;
	border-radius: 5px;
	border-color: #eee;
	background-color: #F2F9FD;
	font-weight: bold;
}
.tab_btn_selected {
	width: 100px;
	height: 30px;
	margin-right: 10px;
	border-radius: 5px;
	color:#FFF;
	border-color: #eee;
	background-color: #39F;
	font-weight: bold;
}
.datalist2 {
  margin-top: 10px;
  border-bottom: 2px solid #b5cfd9;
  border-top: 2px solid #b5cfd9;
  clear: both;
  width: 100%;
}
.datalist2 th {
  border-bottom: 1px dashed #ccc;
  color: #9ebecb;
  font-size: 12px;
  height: 25px;
  line-height: 20px;
  padding: 5px;
  text-align: left;
  word-break: break-all;
}
.datalist2 tr:hover {
	background: #F2F9FD
}

.datalist2 td {
	padding: 10px 3px;
	background: url(./static/system/admin_img/bg_repd.gif) repeat-x 0 bottom;
	height: 25px; word-break:break-all;
}

</style>
<style>
#sortTable td {
	padding:0;
	vertical-align:middle;
}
#sortTable td a {
	cursor:pointer;
}
</style>
<div class="col-xs-12 col-md-12">
  <div class="widget">
    <div class="well with-header wellpadding">
      <div class="header bordered-blue">幸运水果机->游戏统计</div>
      <div>
      
      
    <input class="<?=($_GET['day']=='all' || !$_GET['day'])?'tab_btn_selected':'tab_btn'?>" type="button" onclick="location.href='<?=$this->baseurl?>&m=index&day=all'" value=" 全部 ">
    
    <input class="<?=($_GET['day']=='today')?'tab_btn_selected':'tab_btn'?>" type="button" onclick="location.href='<?=$this->baseurl?>&m=index&day=today'" value=" 今天 ">
  	<input class="<?=($_GET['day']=='yesterday')?'tab_btn_selected':'tab_btn'?>" type="button" onclick="location.href='<?=$this->baseurl?>&m=index&day=yesterday'" value=" 昨天 ">
  	
  	<input type="input" class="px" id="starttime" value="<?=date('Y-m-d H:i:s',$startTime)?>" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" name="starttime">
  	到
  	<input type="input" class="px" id="endtime" value="<?=date('Y-m-d H:i:s',$endTime)?>" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" name="endtime">
  	
  	<input type="button" onclick="selectTime()" value=" 查询 " class="btn btn-blue">
	
	<table width="100%" border="0" cellpadding="3" cellspacing="0" class="datalist2">

		<tr>
		  	<td class="td_r" width="150">日期区间： </td>
			<td colspan="2"><?=date('Y-m-d H:i:s',$startTime)?>
			到
			<?=date('Y-m-d H:i:s',$endTime)?></td>
		</tr>
		<tr>
		    <td class="td_r" nowrap="nowrap">日期区间内系统总赢龙币：</td>
		    <td style="color:#090;" width="120"><?=$win_total?>  </td>
		    <td style="color:;">今日：<font color="#090"><?=$win_today_total?></font></td>  
		</tr>
		<tr>
		    <td class="td_r">日期区间内系统总输龙币：</td>
		    <td style=" color:#00F"><?=$lost_total?>  </td>
		    <td style=" color:">今日：<font color="#00F"><?=$lost_today_total?></font></td>
		</tr>
		<tr> 
		    <td class="td_r">日期区间内系统实际收支：</td>
		    <td style=" color: #F00"><?=$win_total+$lost_total > 0 ? '+'.($win_total+$lost_total) : $win_total+$lost_total?>  </td>
		    <td style=" color: ">今日：<font color="#F00"><?=$win_today_total+$lost_today_total > 0 ? '+'.($win_today_total+$lost_today_total) : $win_today_total+$lost_today_total?></font></td>
		</tr>
		<tr> 
		    <td class="td_r">日期区间内玩家总访问量：</td>
		    <td style=" color: #F00"><?=$visit_all_total?>  </td>
		    <td style=" color: ">今日：<font color="#F00"><?=$visit_today_total?></font></td>
		</tr>
		<tr> 
		    <td class="td_r">日期区间内新增玩家数量：</td>
		    <td style=" color: #F00"><?=$player_total?>  </td>
		    <td style=" color: ">今日：<font color="#F00"><?=$player_add_total?></font></td>
		</tr>
		<!--<tr> 
		    <td class="td_r">今日新增玩家：</td>
		    <td style=" color: #F00"><?=$active_player_total?>  </td>
		    <td></td>
		</tr>-->
	</table>
      
      
      
        <div class="form-inline"> <span>
          <form action="<?=$this->baseurl?>&m=index" method="post">
            <div class="form-group"> <span class="input-icon">
              <input type="text" name="keywords" value="" class="form-control input-sm">
              <i class="glyphicon glyphicon-search blue"></i> </span> </div>
            <div class="form-group">
              <input type="submit" name="submit" value=" 搜索 " class="btn btn-blue">
            </div>
          </form>
          </span> </div>
        <table width="100%" border="0" cellpadding="3" cellspacing="0"
			class="table table-hover table-bordered" id="sortTable">
          <tr>
            <th width="30">ID</th>
            <th>头像</th>
            <th class="td_l">微信昵称</th>           
            <th class="td_l">总龙币</th>
            <th class="td_l">龙币输赢</th>
            <th class="td_l">游戏局数</th>
            <th>操作</th>
          </tr>
          <?php foreach($list as $key=>$r) {?>
          <tr class="sortTr">
            <td  class="td_c result_log"><?=$r['id']?></td>
            <td width="40"  class="openID" data-openid='<?=$r['openID']?>'><img align="middle" src="<?=$r['head_img']?>" width="40" height="40" /></td>
            <td ><?=$r['nickname']?></td>
            <td><?=$r['score']?></td>
            <td><?=$r['sum_num']?></td>
            <td><?=$r['game_num']?></td>
            <td class="td_c" title="">
			<a href="./index.php?d=fruit&c=game_log<?=$this->game_sign?>&starttime=<?=$startTime?>&endtime=<?=$endTime?>&openid=<?=$r['openID']?>"> 详细 </a>
            </td>
          </tr>
          <?php }?>
        </table>
        <div class="margintop">共：
          <?=$count?>
          条&nbsp;&nbsp;
          <?=$pages?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('admin/footer');?>
