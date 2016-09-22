<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 <title>疯狂赛狗</title>   
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
		  .body{ background-image:url('static/raceDog/res/Normal/loading_bg.jpg') ;background-attachment:fixed;background-repeat:no-repeat;background-size:cover;-moz-background-size:cover;-webkit-background-size:cover;}
    </style>
</head>
<body style="padding:0; margin: 0; background: #000;">
<script src="http://119.29.21.84:3000/socket.io/socket.io.js"></script>
<script src="http://static.gxtianhai.cn/racedog/static/js/jquery-1.7.1.min.js"></script>
<script src="http://static.gxtianhai.cn/racedog/application/views/by/res/loading.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<canvas id="gameCanvas" width="320" height="480"></canvas>

<script>
    var wx_info = {openid:'<?=$openid?>',nickname:'<?=$nickname?>',headimgurl:'<?=$headimgurl?>',sex:'<?=$sex?>',total_gold:<?=$smokeBeansCount?>};
    var gift_score = {cooky:<?=$gift_score['cooky']?>,bone:<?=$gift_score['bone']?>,star:<?=$gift_score['star']?>,lolly:<?=$gift_score['lolly']?>,bell:<?=$gift_score['bell']?>,flower:<?=$gift_score['flower']?>};
    var audioSetting = {allowMusic:<?=$audioSetting['music_set']?>,allowEffects:<?=$audioSetting['effects_set']?>};
var loginInfo = {is_frist_time:'<?=$is_frist_time?>',is_read_rule:false};

	$(function(){
		check_id();
	})
	
	function check_id(){
		
		 $.ajax({
            type: "POST",
            url: "index.php?c=raceDog&m=check_id",
          //  contentType: "application/json", //必须有
            dataType: "json", //表示返回值类型，不必须
            data: {openid:wx_info.openid},  //相当于 //data: "{'str1':'foovalue', 'str2':'barvalue'}",
            success: function (jsonResult) {
              
			  	if(jsonResult.status == -1){
					 window.location.reload();
				}
			  
                if(jsonResult.status == -2){
					window.location.reload();
                  // window.location.href= 'http://h5game.gxtianhai.cn/racedog/index.php?c=raceDog&m=getUserInfo&nickName='+jsonResult.nickname+'&headPhoto='+jsonResult.head_img+'&openid='+jsonResult.openID+'&accept=true';				   
                }

            }
        });
		
	}
	

	 function postBetData(dataBet) {
		check_id();
        $.ajax({
            type: "POST",
            url: "index.php?c=raceDog&m=save_beton",
          //  contentType: "application/json", //必须有
            dataType: "json", //表示返回值类型，不必须
            data: "data=" + JSON.stringify(dataBet),  //相当于 //data: "{'str1':'foovalue', 'str2':'barvalue'}",
            success: function (jsonResult) {
              // alert(jsonResult);
                if(jsonResult == -1){
                    alert('提交数据异常，请重新进入游戏！');
					window.location.reload();
                    return false;
                }else if(jsonResult == -2){
                    alert('烟豆服务器繁忙，请稍后再试！')
                    return false;
                }else{
               	 socket.emit('beton', jsonResult);
				}

            }
        });
    }

    function postBetAgain(dataBet) {
		check_id();
        $.ajax({
            type: "POST",
            url: "index.php?c=raceDog&m=save_beton_again",
            //  contentType: "application/json", //必须有
            dataType: "json", //表示返回值类型，不必须
            data: {openid:dataBet},  //相当于 //data: "{'str1':'foovalue', 'str2':'barvalue'}",
            success: function (jsonResult) {
               // alert(jsonResult);
               if(jsonResult == -1){
                     alert('提交数据异常，请重新进入游戏！');
					 window.location.reload();
                    return false;
                }else if(jsonResult == -2){
                    alert('烟豆服务器繁忙，请稍后再试！')
                    return false;
                }else{
                	socket.emit('beton_again', jsonResult);
				}

            }
        });
    }

    function getSpeed(){
        socket.emit('dogInfo', '');
    }
	
	

     function postGift(data){
         $.ajax({
             type: "POST",
             url: "index.php?c=raceDog&m=save_gift",
             //  contentType: "application/json", //必须有
             dataType: "json", //表示返回值类型，不必须
             data: "data=" + JSON.stringify(data),  //相当于 //data: "{'str1':'foovalue', 'str2':'barvalue'}",
             success: function (jsonResult) {

                 if(jsonResult == -1){
                     alert('登录超时，请重新登录！')
                     return false;
                 }else if(jsonResult == -2){
                     alert('烟豆服务器繁忙，请稍后再试！')
                     return false;
                 }else{
                 	socket.emit('gift', jsonResult);
			 	}

             }
         });
     }

    function unit(number) {

        var w = 10000,
            sizes = '万',//['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
            i = Math.floor(Math.log(number) / Math.log(w));
        if (number < w) return number;

        var res = (number / Math.pow(w, i));
        if( (number % w) == 0 ){
            return res+ '' + sizes;;
        }
        if(number >= 100000){
            return res.toPrecision(4) + '' + sizes;//sizes[i];
        }

        return res.toPrecision(3) + '' + sizes;//sizes[i];
    }

	
	
	
	
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
        title: '疯狂赛狗', // 分享标题
        desc: '疯狂赛狗', // 分享描述
        link: 'http://h5game.gxtianhai.cn/racedog/index.php?c=raceDog', // 分享链接
        imgUrl: '<?=base_url('static/images/loadingBG.png');?>', // 分享图标
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
		link: 'http://h5game.gxtianhai.cn/racedog/index.php?c=raceDog',
		imgUrl: '<?=base_url('static/images/loadingBG.png');?>', // 分享图标
		success: function () { 
			// 用户确认分享后执行的回调函数
		},
		cancel: function () { 
			// 用户取消分享后执行的回调函数
		}
	});


	
 });
	
	
	
</script>
<script cocos src="application/views/by/game.min.js"></script>
<?php require_once 'cs.php';echo '<img src="'._cnzzTrackPageView(1259386050).'" width="0" height="0"/>';?>
</body>
</html>