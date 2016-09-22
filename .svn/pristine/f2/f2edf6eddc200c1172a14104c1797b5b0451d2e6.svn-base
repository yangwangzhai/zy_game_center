<?php $this->load->view('admin/header');?>

<style>
.flexslider {
	margin: 0px auto 20px;
	position: relative;
	width: 100%;
	height: 500px;
	overflow: hidden;
	zoom: 1;
	
}

.flexslider .slides li {
	width: 100%;
	height: 100%;
	text-align: center;
}

.flex-direction-nav a {
	width: 70px;
	height: 70px;
	line-height: 99em;
	overflow: hidden;
	margin: -35px 0 0;
	display: block;
	background: url(static/system/images/ad_ctr.png) no-repeat;
	position: absolute;
	top: 50%;
	z-index: 10;
	cursor: pointer;
	opacity: 0;
	filter: alpha(opacity=0);
	-webkit-transition: all .3s ease;
	border-radius: 35px;
}

.flex-direction-nav .flex-next {
	background-position: 0 -70px;
	right: 0;
}

.flex-direction-nav .flex-prev {
	left: 0;
}

.flexslider:hover .flex-next {
	opacity: 0.8;
	filter: alpha(opacity=25);
}

.flexslider:hover .flex-prev {
	opacity: 0.8;
	filter: alpha(opacity=25);
}

.flexslider:hover .flex-next:hover,
.flexslider:hover .flex-prev:hover {
	opacity: 1;
	filter: alpha(opacity=50);
}

.flex-control-nav {
	width: 100%;
	position: absolute;
	bottom: 10px;
	text-align: center;
}

.flex-control-nav li {
	margin: 0 2px;
	display: inline-block;
	zoom: 1;
	*display: inline;
}

.flex-control-paging li a {
	background: url(static/system/images/dot.png) no-repeat 0 -16px;
	display: block;
	height: 16px;
	overflow: hidden;
	text-indent: -99em;
	width: 16px;
	cursor: pointer;
}

.flex-control-paging li a.flex-active,
.flex-control-paging li.active a {
	background-position: 0 0;
}

.flexslider .slides img {
	height:100%;
	
}
</style>
<script type="text/javascript">
$(function($)
{
	
	
});

</script>
<div class="mainbox">

	<div id="banner_tabs" class="flexslider">
	<ul class="slides">
		<?php foreach($path_arr as $v){?>
		<li>
			<img  alt="" style="background: url(<?=$v?>) no-repeat center / contain; " src="static/system/images/alpha.png">
		</li>
		<?php }?>
	</ul>
	<ul class="flex-direction-nav">
		<li><a class="flex-prev" href="javascript:;">Previous</a></li>
		<li><a class="flex-next" href="javascript:;">Next</a></li>
	</ul>
	<ol id="bannerCtrl" class="flex-control-nav flex-control-paging">
		<?php foreach($path_arr as $k => $v){?>
		<li><a><?=$k+1?></a></li>
		<?php }?>
	</ol>
</div>
	
</div>

<script src="static/system/js/slider.js"></script>
<script type="text/javascript">
$(function() {
	var bannerSlider = new Slider($('#banner_tabs'), {
		time: 5000,
		delay: 400,
		event: 'hover',
		auto: false,
		mode: 'fade',
		controller: $('#bannerCtrl'),
		activeControllerCls: 'active'
	});
	$('#banner_tabs .flex-prev').click(function() {
		bannerSlider.prev()
	});
	$('#banner_tabs .flex-next').click(function() {
		bannerSlider.next()
	});


	
})
</script>

