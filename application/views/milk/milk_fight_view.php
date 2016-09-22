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
<link href="static/gameroom/milk/css/style.css?r=444" rel="stylesheet" type="text/css">
<script src="static/gameroom/milk/js/jquery-1.7.1.min.js"></script>
<script src="static/gameroom/milk/js/jquery.touchSwipe.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
var timedown= <?=$game_time?>; 
var start_timedown = <?=$game_time?>; 
var countdown = 0;
var Isstart = false;
var has_save_info = '<?=$has_save_info?>';//是否保存过信息 
var endTime;
var time_left = 4;
var openID = '<?=$openid?>';
var headimgurl = '<?=$headimgurl?>';
var nickname = '<?=$nickname?>';
var sex = '<?=$sex?>';
var user_id = '<?=$user_id?>';
var game_sign = '<?=$game_sign?>';
/*music.addEventListener("playing", function(){
    audioStatus = "playing";
});
music.addEventListener("ended", function(){
    audioStatus = "paused";
});*/

 wx.config({
      debug: false,    
		appId: '<?php echo $signPackage["appId"];?>',
		timestamp: '<?php echo $signPackage["timestamp"];?>',
		nonceStr: '<?php echo $signPackage["nonceStr"];?>',
		signature: '<?php echo $signPackage["signature"];?>',
      jsApiList: [
        'checkJsApi',
        'onMenuShareTimeline',
        'onMenuShareAppMessage',
        'onMenuShareQQ',
        'onMenuShareWeibo',
        'onMenuShareQZone',
        'hideMenuItems',
        'showMenuItems',
        'hideAllNonBaseMenuItem',
        'showAllNonBaseMenuItem',
        'translateVoice',
        'startRecord',
        'stopRecord',
        'onVoiceRecordEnd',
        'playVoice',
        'onVoicePlayEnd',
        'pauseVoice',
        'stopVoice',
        'uploadVoice',
        'downloadVoice',
        'chooseImage',
        'previewImage',
        'uploadImage',
        'downloadImage',
        'getNetworkType',
        'openLocation',
        'getLocation',
        'hideOptionMenu',
        'showOptionMenu',
        'closeWindow',
        'scanQRCode',
        'chooseWXPay',
        'openProductSpecificView',
        'addCard',
        'chooseCard',
        'openCard'
      ]
  });
  
  wx.ready(function () {
    // 在这里调用 API
 
     
    wx.onMenuShareAppMessage({
        title: '喝奶大作战，为梦想加油！', // 分享标题
        desc: '我一共喝了<?=$max_score?>瓶牛奶，你能超过我吗？', // 分享描述
        link: 'http://h5game.gxtianhai.cn/mntvdb/gamecenter/index.php?d=milk&c=milk_fight', // 分享链接
        imgUrl: '<?=base_url('static/gameroom/milk/images/title.png');?>', // 分享图标
        type: '', // 分享类型,music、video或link，不填默认为link
        dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
        success: function () { 
            // 用户确认分享后执行的回调函数
        },
        cancel: function () { 
            // 用户取消分享后执行的回调函数
        }
    });
 });
 
</script>
<script type="text/javascript" src="static/gameroom/milk/js/milk_fight.js?version=20081112050246"></script>


</head>
<body>
<div class="main">
<div class="main_body">
<div class="title"><img src="static/gameroom/milk/images/title.png"/></div>
<div class="hd">
<div class="ren">
<img class="ren1" src="static/gameroom/milk/images/ren1.png"/>
<img style="display:none;" class="ren2" src="static/gameroom/milk/images/ren2.png"/>
</div>
<div class="nai"><img src="static/gameroom/milk/images/nai.png"/></div>
</div>
<div class="tai"><img src="static/gameroom/milk/images/tai.jpg"/>
<div class="strat"><input name="" type="button" value="开始游戏"  class="play" onClick="javascript:showGuideRead();"></div>
<div class="play_info"  style="display: none;">
<div class="time"><span id="fnTimeCountDown">00:00:000</span></div>
<div class="num"><span id="result">0瓶</span></div>
</div>

<div class="icon">
<div class="yxgz"><a href="#" onClick="javascript:showGZ();"><img src="static/gameroom/milk/images/yxgz.png"/></a></div>


<div class="about"><a href="#" onClick="javascript:showSM();"><img src="static/gameroom/milk/images/hdsm.png"/></a></div>

<div class="view" <?php if (!$user_id) {?> style="display:none;" <?php }?>><a href="index.php?d=milk&c=my_fight&user_id=<?=$user_id?>&nickname=<?=$nickname?><?=$game_sign?>">
<img src="static/gameroom/milk/images/ckjl.png"/></a></div>
<div class="game_top" ><a href="index.php?d=milk&c=milk_fight&m=rank_result<?=$game_sign?>"><img src="static/gameroom/milk/images/game_top.png"/></a></div>
</div>


</div>

</div>
<!---弹框---->
<div class="agust-text yxjg" style="display: none;">
        <div class="scroll-mod">
        
            <div class="c_centent">
                <div class="box">
                 <div class="close-icon"><a href="javascript:hideGuideRead();"><img src="static/gameroom/milk/images/close.png"></a></div>
                <div class="box-text">
               <img src="<?=$headimgurl?>" class="userimg"/>
               <div class="box-txt">
                <p>恭喜你打败了<strong class="bfb">90%</strong>的选手</p>
                  <p>本次喝奶：<strong class="cur_count">0瓶</strong></p>
                    <p>最高记录：<strong class="max_count">0瓶</strong></p>
                    <p>当前排名：<strong class="cur_rank">0</strong></p>
                </div>
                <div class="box_btn">
                <img class="play" src="static/gameroom/milk/images/play_again.png"/>
                 <a href="index.php?d=milk&c=milk_fight&m=rank_result<?=$game_sign?>"><img src="static/gameroom/milk/images/top_btn.png"/></a>
                </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--
<div class="red-tc" id="fd">
		<div class="red-yzj">
			<div class="red-tc-k">
              <a href="#" class="close"></a>				
			</div>
			<div class="red-tc-btn">
				<p>请填写您的手机号码</p>
				<input id='tel' type="text" class="text">
				<button onClick="save_tel()">提 交</button>
			</div>
		</div>
</div>-->

<div class="agust-text over" style="display: none;">
<div class="timeUpImg"></div> 
</div>

<!---活动介绍---->
<div class="agust-text hdsm" style="display: none;">
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


<!---游戏规则---->
<div class="agust-text yxgz_div" style="display:none" >
<div class="about_body">
<div class="about_title"><img  src="static/gameroom/milk/images/yxgz_title.png"/></div>
<div class="close-icon"><a href="#" onClick="javascript:hideGZ();"><img src="static/gameroom/milk/images/close.png"></a></div>
<div class="about_text">
<p><b>游戏时间：</b><?=$game_time?>秒。</p>
<br/>
<p><b>游戏玩法：</b>进入游戏页面后，点开始游戏，用手指向上滑动屏幕人物喝奶，每向上滑动1次喝1瓶奶，向上滑动速度越快，人物喝奶速度越快，得分越高。<p>
<br/>
<p><b>游戏规则：</b>活动期间内，每人每天不限制玩游戏的次数，以单次游戏最高分计入游戏成绩排行榜中。游戏结束后，根据游戏成绩进行排名并公布中奖名单，如产生相同游戏成绩，以最先获得本成绩的用户为获奖者。</p>

</div>
</div>
</div>


<!--</div>  
</div>
-->




<!----倒计时提示--->
<div class="red-tc time_left_div"  style="display:none">
<div class="upbtn"><img src="static/gameroom/milk/images/up.png">
<img src="static/gameroom/milk/images/hand.png"/></div>
<div class="uptxt">向上滑动屏幕</div>
<div class="timeimg"><img class="time_left" src="static/gameroom/milk/images/5.png"/></div>
</div>	


<!--滑动音效--->
<div id="mc_play"><audio src="static/gameroom/milk/mp3/qie.mp3" id="audio"  ></audio></div>
<!--加分音效--->
<audio id="music" src="static/gameroom/milk/mp3/jiafen.mp3" preload="preload" ></audio>
<!--游戏结束音效--->
<audio id="over" src="static/gameroom/milk/mp3/over.wav" preload="preload" ></audio>
<audio id="start" src="static/gameroom/milk/mp3/go.mp3" preload="preload" ></audio>
<?php require_once 'cs.php';echo '<img src="'._cnzzTrackPageView(1257724482).'" width="0" height="0"/>';?>
</body>
</html>
