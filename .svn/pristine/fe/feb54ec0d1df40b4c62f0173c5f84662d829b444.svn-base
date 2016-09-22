<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta content="telephone=no" name="format-detection">
<title>喝奶大作战，为梦想加油！</title>
<link href="static/gameroom/milk/css/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="static/gameroom/milk/js/jquery-1.7.1.min.js"></script>
<!---弹框---->
<script>
   
	function showSM(){
		$('.hdsm').show();
	}
	function hideSM(){
		$('.hdsm').hide();
	}
	
	function showHJ(){
		$('.lj').show();
	}
	function hideHJ(){
		$('.lj').hide();
	}
	
</script>
</head>
<body>
<div class="main">
<div class="main_body">
<div class="title"><img src="static/gameroom/milk/images/title.png"/></div>
<div class="hd">
<div class="ren"><img src="static/gameroom/milk/images/ren1.png"/></div>
<div class="nai"><img src="static/gameroom/milk/images/nai.png"/></div>
</div>

<div class="tai"><img src="static/gameroom/milk/images/tai.jpg"/>
<div class="zjtxt">
<?=$result_txt?>
<?php if ($is_winning == 1) {?>
<input name="" type="button"  style="width:90%;" onClick="javascript:showHJ();" class="okbtn" value="我要领奖">
<?php }?>
</div>

<div class="icon">
<div class="about"><a href="#" onClick="javascript:showSM();"><img src="static/gameroom/milk/images/hdsm.png"/></a></div>
<?php if ($user_id) {?>
<div class="view"><a href="index.php?d=milk&c=my_fight&user_id=<?=$user_id?>&nickname=<?=$nickname?><?=$game_sign?>">
<img src="static/gameroom/milk/images/ckjl.png"/></a>
</div>
<?php }?>
<div <?php if (!$user_id) {?>  style="top:-70%;"<?php }?> class="zjmd"><a href="index.php?d=milk&c=milk_fight&m=winner_result<?=$game_sign?>"><img src="static/gameroom/milk/images/zjmd.png"/></a></div>

<?php if ($is_winning == 1) {?>
<!--<div class="about"><a href="#" onClick="javascript:showHJ();"><img src="static/images/djlj.png"/></a></div>-->
<?php }?>

</div>

</div>

</div>  
</div>

<!---活动介绍---->
<div class="agust-text hdsm" style="display:none" >
<div class="about_body">
<div class="about_title"><img  src="static/gameroom/milk/images/about_title.png"/></div>
<div class="close-icon"><a href="#" onClick="javascript:hideSM();"><img src="static/gameroom/milk/images/close.png"></a></div>
<div class="about_text">
<p><strong>一、活动时间：</strong></p>
<p>2016年3月1日至2016年3月4日</p>
<p>2、活动结束后，将在活动页面中公布中奖名单，请参与者自行进入页面查看中奖情况；</p>
<p>3、仅限广西区域用户参与活动。</p>
<p><strong>二、活动奖品：</strong></p>
<p>1、一等奖1名，奖励10件摩拉菲尔·清养水牛纯牛奶</p>
<p>2、二等奖5名，奖励5件摩拉菲尔·清养水牛纯牛奶</p>
<p>3、三等奖1000名，奖励1件摩拉菲尔·清养水牛纯牛奶</p>
<p><strong>三、奖品兑换：</strong></p>
<p> 领奖时间：3月5日——3月20日，南宁市内用户凭借中奖姓名、手机号码和地址前往指定皇氏新鲜屋领取奖品；南宁市外用户的奖品将于活动结束后10个工作日（不含周末）内陆续寄出。
若超过时间未领取，则视为放弃领奖。皇氏新鲜屋参与领奖门店如下：
<img  src="static/gameroom/milk/images/milk_address.jpg"/>
</p></div>
</div>
</div>


<div class="red-tc lj">
<div class="red-yzj">
<div class="red-tc-k">
<a href="#" class="close"  onClick="javascript:hideHJ();"></a>温馨提示</div>
<div class="red-tc-btn">
<p align="center">领取奖品，请先关注"皇氏新鲜订"公众号，本次活动由皇氏乳业统一对礼品进行配送。</p>
<p><input name="" type="button" onclick="location.href='https://mp.weixin.qq.com/s?__biz=MzAxMTAzMTczMg==&mid=430998682&idx=1&sn=e9385d159ccc2fb810797f649258cf0d&scene=1&srcid=02292qZZsoAZM4hSZGrdmhxD&pass_ticket=A%2BA7CkFgvOz3KO3dKPyU3qgctgHuAc3nBPvIVPSGl3I%3D#rd'" class="okbtn" value="马上去关注"></p>
</div>
</div>
</div>

</body>
</html>
