<!DOCTYPE HTML>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>幸运水果机</title>
    <meta name="viewport" content="initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="full-screen" content="yes"/>
    <meta name="screen-orientation" content="portrait"/>
    <meta name="x5-fullscreen" content="true"/>
    <meta name="360-fullscreen" content="true"/>
    <style>
body, canvas, div {
	-moz-user-select: none;
	-webkit-user-select: none;
	-ms-user-select: none;
	-khtml-user-select: none;
	-webkit-tap-highlight-color: rgba(0, 0, 0, 0);
	
   
}
 body{ background:url('static/gameroom/fruit/res/loading_bg.png') no-repeat center center;
	 background-attachment:fixed;
	/* background-repeat:no-repeat;*/
	 background-size:cover;
	 -moz-background-size:cover;
	 -webkit-background-size:cover;
   
}
 .bodycss{ background:url('static/gameroom/fruit/res/loading_bg.png') no-repeat center center;
	 background-attachment:fixed;
	/* background-repeat:no-repeat;*/
	 background-size:cover;
	 -moz-background-size:cover;
	 -webkit-background-size:cover;
   
}
</style>
    </head>

    <body>
  
<script src="static/gameroom/fruit/loading.js"></script>
<canvas id="gameCanvas" width="320" height="480"></canvas>
<script src="http://static.gxtianhai.cn/racedog/static/js/jquery-1.7.1.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
 var wx_info = {
     openid:'<?=$openid?>',
     nickname:'<?=$nickname?>',
     headimgurl:'<?=$headimgurl?>',
     total_gold:<?=$smokeBeansCount?>,
     last_result_gold:<?=$last_result_gold?>,
     last_game_id:<?=$last_game_id?>,
     allowMusic:<?=$allowMusic?>,
     first_time:'<?=$first_time?>'
 };
 var resources = <?=$GameUI?>;
 
 var base_url = './index.php?d=fruit&c=fruit<?=$this->game_sign?>';
    (function () {
        var nav = window.navigator;
        var ua = nav.userAgent.toLowerCase();
        var uaResult = /android (\d+(?:\.\d+)+)/i.exec(ua) || /android (\d+(?:\.\d+)+)/i.exec(nav.platform);
        if (uaResult) {
            var osVersion = parseInt(uaResult[1]) || 0;
            var browserCheck = ua.match(/(qzone|micromessenger|qqbrowser)/i);
            if (browserCheck) {
                var gameCanvas = document.getElementById("gameCanvas");
                var ctx = gameCanvas.getContext('2d');
                ctx.fillStyle = '#000000';
                ctx.fillRect(0, 0, 1, 1);
            }
        }
    })();
	

</script>


    
</body>
<script cocos src="static/gameroom/fruit/game.min.js"></script>  
<script type="text/javascript">

wx.config({
      	debug: false,    
		appId: '<?php echo $signPackage["appId"];?>',
		timestamp: <?php echo $signPackage["timestamp"];?>,
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
        title: '幸运水果机', // 分享标题
        desc: '幸运水果机', // 分享描述
        link: 'http://h5game.gxtianhai.cn/mntvdb/gamecenter/index.php?d=fruit&c=fruit<?=$this->game_sign?>', // 分享链接
        imgUrl: '<?=base_url('static/gameroom/fruit/images/share_ico.png');?>', // 分享图标
        type: '', // 分享类型,music、video或link，不填默认为link
        dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
        success: function () { 
            // 用户确认分享后执行的回调函数
        },
        cancel: function () { 
            // 用户取消分享后执行的回调函数
        }
    });
	
	wx.onMenuShareTimeline({
		title: '幸运水果机', // 分享标题
		link: 'http://h5game.gxtianhai.cn/mntvdb/gamecenter/index.php?d=fruit&c=fruit<?=$this->game_sign?>',
		imgUrl: '<?=base_url('static/gameroom/fruit/images/share_ico.png');?>', // 分享图标
		success: function () { 
			// 用户确认分享后执行的回调函数
		},
		cancel: function () { 
			// 用户取消分享后执行的回调函数
		}
	});
});	
</script>




</html>