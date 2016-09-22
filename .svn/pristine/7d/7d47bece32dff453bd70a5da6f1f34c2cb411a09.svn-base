<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>摇骰子</title>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="full-screen" content="yes"/>
    <meta name="screen-orientation" content="portrait"/>
    <meta name="x5-fullscreen" content="true"/>
    <meta name="360-fullscreen" content="true"/>
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta http-equiv="Cache" content="no-cache">
    <style>
        body, canvas, div {
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
            -khtml-user-select: none;
            -webkit-tap-highlight-color: rgba(255, 255, 255, 0);
        }

        .bodycss{ background:url('static/gameroom/craps/res/beijing.png') no-repeat center center;
            background-attachment:fixed;
            /* background-repeat:no-repeat;*/
            background-size:cover;
            -moz-background-size:cover;
            -webkit-background-size:cover;

        }
    </style>
</head>
<body style="padding:0; margin: 0;">
<script>
    var wx_info = {openid:'<?=$wx_info["Openid"]?>',nickname:'<?=$wx_info["NickName"]?>',imgUrl:'<?=$wx_info["Local_img"]?>',total_gold:<?=$wx_info["TotalGold"]?>,gamekey:'<?=$wx_info["gamekey"]?>',musicSet:<?=$musicSet?>,firsttime:'<?=$wx_info['FirstTime']?>',ChannelID:<?=$ChannelID?>,ActiveID:<?=$ActiveID?>,RoomID:<?=$RoomID?>,musicSet:<?=$musicSet?>};
    var resource = <?=$resources?>;
</script>
<script src="static/gameroom/craps/res/loading.js"></script>
<canvas id="gameCanvas" width="320" height="480"></canvas>
<script cocos src="static/gameroom/craps/game.min.js"></script>
</body>
</html>
