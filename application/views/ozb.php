<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>2016欧洲杯竞猜</title>

	<style>
		.team{float: left;}
		.pl{font-size: 12px;}
	</style>
</head>
<body>
	<ul>
		<li><img src="<?=$user['head_img']?>" width="50px"></li>
		<li>用户名：<?=$user['nickname']?></li>
		<li>我的龙币： <span id='mygold'><?=$user['total_gold']?></span></li>
	</ul>

	<div id="wrap">
		<ul>
			<?php foreach($list as $v){?>
			<li>
				<div>
					<?=date('m月d日 H:i',$v['starttime'])?>
				</div>
				<div class="team">
					<img src="<?=$v['team1_logo']?>" alt="" width="60px">
					<div><?=$v['team1_name']?></div>
					<div>
						<span id="zc-<?=$v['id']?>-<?=$v['team1_id']?>"><?=$v['team1_ZC']?></span>人支持
					</div>
					<div>
						已投<span id="order-<?=$v['id']?>-<?=$v['team1_id']?>"><?=$v['team1_yitou']?></span>
					</div>
					<div>
						<input <?=$v['over']?'disabled="disabled"':''?> type="button" onclick="bet_on(<?=$v['id']?>,<?=$v['team1_id']?>)" value="猜TA赢">
					</div>
					<div class="pl">
						预计赔率<?=$v['team1_pl']?>
					</div>
				</div>
				<div class="team">
					<?php if($v['over']) {?>
					<div>
						已结束
					</div>
					<?php }?>
					vs
					<div>
						已投<span id="order-<?=$v['id']?>-0"><?=$v['pj_yitou']?></span>
					</div>
					<div>
						<input <?=$v['over']?'disabled="disabled"':''?> type="button" onclick="bet_on(<?=$v['id']?>,0)" value="猜平局">
					</div>
					<div class="pl">
						预计赔率<?=$v['pj_pl']?>
					</div>
				</div>
				<div class="team">
					<img src="<?=$v['team2_logo']?>" alt="" width="60px">
					<div><?=$v['team2_name']?></div>
					<div>
						<span id="zc-<?=$v['id']?>-<?=$v['team1_id']?>"><?=$v['team2_ZC']?></span>人支持
					</div>
					<div>
						已投<span id="order-<?=$v['id']?>-<?=$v['team2_id']?>"><?=$v['team2_yitou']?></span>
					</div>
					<div>
						<input <?=$v['over']?'disabled="disabled"':''?> type="button" onclick="bet_on(<?=$v['id']?>,<?=$v['team2_id']?>)" value="猜TA赢">
					</div>
					<div class="pl">
						预计赔率<?=$v['team2_pl']?>
					</div>
				</div>
				<div style="clear:both;"></div>
				<div>
					下注金额
					<select name="num" id="gold-<?=$v['id']?>">
						<option value="10">10龙币</option>
						<option value="20">20龙币</option>
						<option value="50">50龙币</option>
						<option value="100">100龙币</option>
						<option value="1000">1000龙币</option>
					</select>
				</div>
				
			</li>
			<?php }?>
		</ul>
	</div>
	
	<div id="my_JC">
		<?php if($my_JC){?>
		<ul>
			<?php foreach ($my_JC as $m) {?>
			<li>
				<?=getrace($m['race_id'])?>&nbsp;&nbsp;<?=($m['country_id']==0)?'平局':getname($m['country_id'])?>&nbsp;&nbsp;<?=$m['gold']?>
			</li>
			<?php }?>
		</ul>
		<?php }?>
	</div>

	
</body>

<script src="static/js/jquery-1.10.2.min.js"></script>
<script>
	$(function(){

	});


function bet_on(race_id,cid){
	var openid = '<?=$user['openID']?>';
	var gold = $('#gold-'+race_id).val();
	var my_gold = Number($('#mygold').text());
	var order_num = Number($('#order-'+race_id+'-'+cid).text());
	$.ajax({
		url:'index.php?c=ozb&m=bet',
		type:'post',
		dataType:'json',
		data:{openid:openid,race_id:race_id,country_id:cid,gold:gold},
		success:function(res){
			if(res.code == 0){
				$('#mygold').text(my_gold-Number(gold));
				$('#order-'+race_id+'-'+cid).text(order_num+Number(gold));
			}
			alert(res.msg);
		}
	})
}
</script>

</html>