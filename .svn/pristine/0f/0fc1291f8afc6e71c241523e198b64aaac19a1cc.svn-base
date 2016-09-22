<?php $this->load->view('admin/header');?>
<script src="static/system/js/highcharts/highcharts.js"></script>
<script type="text/javascript">
$(function(){
	$('#container').highcharts({
		title: {
			text: '游戏访问统计', 
			x: -20 //center 
		}, 
		subtitle: { 
			text: '<font color="red"><?=$subtitle?></font>', 
			x: -20 ,
			useHTML : true
		}, 
		xAxis: { 
			categories: <?=json_encode($categories)?>//['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun','Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] 
		}, 
		yAxis: { 
			title: { text: '访问量' }, 
			plotLines: [{ value: 0, width: 1, color: '#808080' }] 
		}, 
		tooltip: { valueSuffix: '人' }, 
		legend: { layout: 'vertical', align: 'right', verticalAlign: 'middle', borderWidth: 0 }, 
		series: <?=json_encode($series)?>
	});
});

</script>

<div class="mainbox">

	<!-- <span style="float: right">
		<form action="<?=$this->baseurl?>&m=index" method="post">
			<input type="text" name="keywords" value=""> <input type="submit"
				name="submit" value=" 搜索 " class="btn">
		</form>
	</span> 
	    <?=zy_btn('Channel_add',' + 添加渠道 ','class="btn"  onclick="location.href=\'index.php?d=admin&c=channel&m=add\'" ');?>
	     -->

    <div id="container" style="min-width:700px;height:400px"></div>
	
	

</div>


<?php $this->load->view('admin/footer');?>