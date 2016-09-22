<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>维护中</title>
<script>
/* 
 * 名称 ：移动端响应式框架
 * 作者 ：白树 http://peunzhang.cnblogs.com
 * 版本 ：v2.1
 * 日期 ：2015.10.13
 * 兼容 ：ios 5+、android 2.3.5+、winphone 8+
 */
function pageResponse(d){var c=navigator.userAgent,o=c.match(/Windows Phone ([\d.]+)/),e=c.match(/(Android);?[\s\/]+([\d.]+)?/),b=document.documentElement.clientWidth,n=document.documentElement.clientHeight,g=b/n,q=d.width||320,l=d.height||504,a=q/l,m=document.querySelectorAll(d.selectors),k=m.length,h=d.mode||"auto",j=d.origin||"left top 0",f=(h=="contain")?(g>a?n/l:b/q):(h=="cover")?(g<a?n/l:b/q):b/q;function p(t,s,r){var i=s.style;i.width=q+"px";i.height=l+"px";i.webkitTransformOrigin=j;i.transformOrigin=j;i.webkitTransform="scale("+r+")";i.transform="scale("+r+")";if(t=="auto"&&e){document.body.style.height=l*r+"px"}else{if(t=="contain"||t=="cover"){i.position="absolute";i.left=(b-q)/2+"px";i.top=(n-l)/2+"px";i.webkitTransformOrigin="center center 0";i.transformOrigin="center center 0";if(o){document.body.style.msTouchAction="none"}else{document.ontouchmove=function(u){u.preventDefault()}}}}}while(--k>=0){p(h,m[k],f)}};

</script>
<script src="static/system/js/jquery-1.7.1.min.js"></script>

<style>

*{margin:0; padding:0;}
html,body{width:100%;height:100%;}
.bg_a{ width:100%; height:100%;background:url(static/gameroom/racedog/images/bg.jpg) no-repeat; background-size:100% 100%}
.bg_b{ width:100%; height:100%;background:url(static/gameroom/racedog/images/bg2.jpg) no-repeat; background-size:100% 100%}
.box{position:absolute; top:400px;left:0;width:527px; height:601px;background:url(static/gameroom/racedog/images/box.png) no-repeat;}

.weihu
{
width:100%;
height:100%;
right:100px;
position:absolute;
font-size:48px;
text-align:center;
color:#c75316;
transform:rotate(90deg);
-ms-transform:rotate(90deg); /* Internet Explorer */
-moz-transform:rotate(90deg); /* Firefox */
-webkit-transform:rotate(90deg); /* Safari 和 Chrome */
-o-transform:rotate(90deg); /* Opera */
z-index:100
}
.time{font-size:34px;}		

</style>
</head>

<body class="<?=$body_class?>">
<div id="page">
<div class="box"><div class="weihu">
<p>&nbsp;</p>
<p>系统维护中</p>
<p style="line-height:15px;">&nbsp;</p>
<p class="time"><?=$text ?></p>
</div></div>

</div>
<script type="text/javascript">
window.onload = window.onresize = function(){
    pageResponse({
        selectors : '#page',     //模块选择器，使用querySelectorAll的方法
        mode : 'cover',     // auto || contain || cover ，默认模式为auto 
        width : '750',      //输入页面的宽度，只支持输入数值，默认宽度为320px
        height : '1334'      //输入页面的高度，只支持输入数值，默认高度为504px
    })
}
</script>
</body>
</html>