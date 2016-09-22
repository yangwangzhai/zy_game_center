<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport">
<title>游戏规则</title>
<script type="text/javascript">
	function pageResponse(d){var c=navigator.userAgent,o=c.match(/Windows Phone ([\d.]+)/),e=c.match(/(Android);?[\s\/]+([\d.]+)?/),b=document.documentElement.clientWidth,n=document.documentElement.clientHeight,g=b/n,q=d.width||320,l=d.height||504,a=q/l,m=document.querySelectorAll(d.selectors),k=m.length,h=d.mode||"auto",j=d.origin||"left top 0",f=(h=="contain")?(g>a?n/l:b/q):(h=="cover")?(g<a?n/l:b/q):b/q;function p(t,s,r){var i=s.style;i.width=q+"px";i.height=l+"px";i.webkitTransformOrigin=j;i.transformOrigin=j;i.webkitTransform="scale("+r+")";i.transform="scale("+r+")";if(t=="auto"&&e){document.body.style.height=l*r+"px"}else{if(t=="contain"||t=="cover"){i.position="absolute";i.left=(b-q)/2+"px";i.top=(n-l)/2+"px";i.webkitTransformOrigin="center center 0";i.transformOrigin="center center 0";if(o){document.body.style.msTouchAction="none"}else{document.ontouchmove=function(u){u.preventDefault()}}}}}while(--k>=0){p(h,m[k],f)}};
</script>
<script type="text/javascript" src="static/system/js/jquery-1.7.1.min.js"></script>
<style>
*{margin:0; padding:0;}
html,body{width:100%;height:100%;}
body{ width:100%; height:100%;background:url(static/gameroom/racedog/images/rule_bg.jpg) no-repeat 0 center ; background-size:100% auto}

.box{position:absolute; top:400px;left:0;width:527px; height:601px;background:url(static/gameroom/racedog/images/box.png) no-repeat;}


label {
	display: inline;
}

.regular-checkbox {
	display: none;
}

.regular-checkbox + label {
	background:#f4eeb7;
	border:#000 3px solid;
	width:29px; height:29px;
	
	box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05);
	border-radius: 6px;
	display: inline-block;
	position: relative;
}

.regular-checkbox + label:active, .regular-checkbox:checked + label:active {
	box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px 1px 3px rgba(0,0,0,0.1);
}

.regular-checkbox:checked + label {

}

.regular-checkbox:checked + label:after {
	content: '';
	font-size: 14px;
	position: absolute;
	top: 0px;
	left: 0px;
	color: #99a1a7;
	background:url(static/gameroom/racedog/images/check_on.png) no-repeat;
	background-size:100% 100%;
	width:24px;
	height:28px;
}


.check_txt_l { position:absolute; top:400px; left:185px; background:url(static/gameroom/racedog/images/check_txt1.png) no-repeat; width:27px; height:335px; }
.check_txt_r { position:absolute; top:820px; left:185px; background:url(static/gameroom/racedog/images/check_txt2.png) no-repeat; width:27px; height:334px; }


.check_l{position:absolute; top:353px; left:180px;}
.check_txt_l2{position:absolute; top:400px; left:188px; background:url(static/gameroom/racedog/images/check_txt1.png) no-repeat; width:20px; height:334px;}

.check_r{position:absolute; top:774px; left:180px;}
.check_txt_r2{position:absolute; top:820px; left:188px; background:url(static/gameroom/racedog/images/check_txt2.png) no-repeat; width:20px; height:334px;}
.enter_btn{position:absolute; top:655px; left:92px; background:url(static/gameroom/racedog/images/enter_btn.png) no-repeat; width:46px; height:224px; border:none}
.enter_btn:active{ background-position: -46px 0 }
.quit_btn{position:absolute; top:376px; left:92px; background:url(static/gameroom/racedog/images/quit_btn.png) no-repeat; width:46px; height:224px; border:none}
.quit_btn:active{ background-position: -46px 0 }
</style>
</head>

<body>
<div id="page">
<div class="check_l"><input type="checkbox" id="checkbox1" class="regular-checkbox" /><label for="checkbox1"></label></div>
<div class="check_txt_l"></div>
<div class="check_r"><input type="checkbox" id="checkbox2" class="regular-checkbox" /><label for="checkbox2"></label></div>
<div class="check_txt_r"></div>


<input name="" type="button" onclick="window.location.href='http://wx.zhenlong.wang/integral/wxFans!toGameCenter.action?openid=<?=$openid?>';" class="quit_btn">
<input name="" type="button" onclick="enter_game();" class="enter_btn">
</div>

<audio id="myaudio" src="static/gameroom//racedog/res/Normal/audio/woof.mp3" controls="controls"   hidden="true"  >
</audio>

<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>



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
        wx.ready(function() {
           playMP3();
		     
    wx.onMenuShareAppMessage({
        title: '疯狂赛狗', // 分享标题
        desc: '疯狂赛狗', // 分享描述
        link: 'http://h5game.gxtianhai.cn/mntvdb/gamecenter/index.php?d=racedog&c=raceDog&ChannelID=<?=$ChannelID?>&ActiveID=<?=$ActiveID?>&RoomID=<?=$RoomID?>', // 分享链接
        imgUrl: '<?=base_url('static/gameroom/racedog/images/loadingBG.png');?>', // 分享图标
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
		title: '疯狂赛狗', // 分享标题
		link: 'http://h5game.gxtianhai.cn/mntvdb/gamecenter/index.php?d=racedog&c=raceDog&ChannelID=<?=$ChannelID?>&ActiveID=<?=$ActiveID?>&RoomID=<?=$RoomID?>',
		imgUrl: '<?=base_url('static/gameroom/racedog/images/loadingBG.png');?>', // 分享图标
		success: function () { 
			// 用户确认分享后执行的回调函数
		},
		cancel: function () { 
			// 用户取消分享后执行的回调函数
		}
	});
        });

window.onload = window.onresize = function(){
    pageResponse({
        selectors : '#page',     //模块选择器，使用querySelectorAll的方法
        mode : 'cover',     // auto || contain || cover ，默认模式为auto 
        width : '750',      //输入页面的宽度，只支持输入数值，默认宽度为320px
        height : '1334'      //输入页面的高度，只支持输入数值，默认高度为504px
    })
}
function enter_game(){
	var isaccept = $('#checkbox1').is(':checked');
	var bzxs = $('#checkbox2').is(':checked');//不再显示

	if(isaccept){
		var curr = window.location.href;
		
		if(bzxs){
			curr = curr+'&bzxs=1';
		}
		window.location.href=curr+"&accept=true&is_frist_time=<?=$is_frist_time?>";
	}
}

function playMP3(){
	var myAuto = document.getElementById('myaudio');
	myAuto.play();
	setTimeout("playMP3()",5000);
}

// 添加监听器，在title里显示状态变化
document.addEventListener("visibilitychange", function(){	
    //document.title = document.hidden ? "用户离开了" : "用户回来了";
	
	
});

</script>
</body>
</html>
