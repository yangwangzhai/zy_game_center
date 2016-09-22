<?php $this->load->view('admin/header');?>
<script type="text/javascript">
$(function($)
{	
	 $(".lookyd").click(function(){ 
		 var openid = $(this).data('openid');
		if(openid != ''){
			$.ajax({
				type:'post',
				url:'<?=$this->baseurl?>&m=lookyd',
				dataType:'text',
				data:{openid:openid },
				success:function(res){								
					var title = '查看烟豆';
					$.dialog({
							id: 'a15',
							max: false,    
							min: false,
							height: 50 ,
							width: 350,
							padding: '10px' ,
							title:  title,
							lock: true,
							content: res,//'<img  src="'+img[index]+'" width="100%" height="auto" />',
							cancelVal: '关闭',
							cancel: true /*为true等价于function(){}*/
					});
				}
			})
		}
		  
	})
	
	$(".result_log").click(function(){ 
		  	var phone = $(this).data('result');	
			var title = '查看';
			$.dialog({
					id: 'a15',
					max: false,    
					min: false,
					height: 80 ,
					width: 150,
					padding: '10px' ,
					title:  title,
					lock: true,
					content: phone,//'<img  src="'+img[index]+'" width="100%" height="auto" />',
					
			});
			
	})
	
});
function result_bs_log(gameid){
	if(gameid == '') return;
	$.dialog({
		  id: 'a15',
		  max: false,    
		  min: false,
		  height: 550 ,
		  width: 550,
		  padding: '10px' ,
		  title:  '查看',
		  lock: true,
		  content: 'url:<?=$this->baseurl?>&m=get_result_bs_log&gameid='+gameid,//'<img  src="'+img[index]+'" width="100%" height="auto" />',
		//  cancelVal: '关闭',
		//  cancel: true /*为true等价于function(){}*/
  });
	
}
</script>
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
      <div class="header bordered-blue">幸运水果机->游戏记录</div>
      <div>
        <div class="form-inline"> <span>
          <form action="<?=$this->baseurl?>&m=index" method="post">
            <div class="form-group"> <span class="input-icon">
              <input type="text" name="keywords" value="" class="form-control input-sm">
              <i class="glyphicon glyphicon-search blue"></i> </span> </div>
            <div class="form-group">
              <input type="submit" name="submit" value=" 搜索 " class="btn btn-blue">
              <input type="button" value="游戏统计" class="btn btn-success" onclick="location.href='index.php?d=fruit&c=game_tj<?=$this->game_sign?>'">
            </div>
          </form>
          </span> </div>
        <table width="100%" border="0" cellpadding="3" cellspacing="0"
			class="table table-hover table-bordered" id="sortTable">
          <tr>
            <th width="30">游戏ID</th>
            <th>头像</th>
            <th align="left">微信昵称</th>
            <?php foreach($bet_arr as $k=>$v) {?>
            <th width="55"><?=$v.'<br>(x'.$k.')'?></th>
            <?php }?>
            <th>开奖结果</th>
            <th>参与时间</th>
          </tr>
          <?php foreach($list as $key=>$r) {?>
          <tr class="sortTr">
            <td data-id="<?=$r['id']?>" data-result="<?=str_replace(',', ',<br>', $r['result_log'])?>"  class="td_c result_log"><?=$r['id']?></td>
            <td width="40"  class="openID" data-openid='<?=$r['openID']?>'><img align="middle" src="<?=$r['head_img']?>" width="40" height="40" /></td>
            <td ><?=$r['nickname']?></td>
            <?php $k=1; foreach($bet_arr as $v) {?>
            <td class="td_c"><?=$r['bet'.$k] ? $r['bet'.$k] : '' ?></td>
            <?php $k++;}?>
            <td><?=$r['result_text']?></td>
            <td class="td_c" title="<?=times($r['addtime'],1)?>"><?=timeFromNow($r['addtime'])?></td>
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
