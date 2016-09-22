<?php $this->load->view('admin/header');?>
<script src="static/system/js/highcharts/highcharts.js" type="text/javascript"></script>
<script type="text/javascript">
var series_data = "[<?=$series?>]";
var categories_data = <?=json_encode($categories)?>;
series_data = eval('(' + series_data + ')');
var cur_year;
var type;

//转换成饼图的数据格式
var series_count = series_data.length;
var pie_series_data = [];
for(series in series_data[0]['data']){
	var series_sum = 0;
	var pie_data = [];
	for(var i=0; i < series_count; i++){
		series_sum += Number(series_data[i]['data'][series]);		
	}
	pie_data.push(categories_data[series]);
	pie_data.push(series_sum);
	pie_series_data.push(pie_data);
}


$(function($)
{
	   $("input[name=bm][value='<?=$showtype?>']").attr("checked",true);
	    type = $("#selecttype").find("option:selected").text();
	   var timetype = $('#selectTimetype').val();
	    cur_year = $('#selectYear').val();
		
	   if(timetype == '7days'){
		   $('#time_content').hide();
	   }else{
		   $('#time_content').show();
	   }
	   
	   if('<?=$showtype?>' == 'all'){
		   $('.highcharts_content').css("display",'');
		   container_a();
		   container_b()
		   container_c()
	   }else{
		    $('.highcharts_content').css("display",'none');
			$('#container_<?=$showtype?>').css("display",'');
			if('<?=$showtype?>' == 'a')  container_a();
			if('<?=$showtype?>' == 'b')  container_b();
			if('<?=$showtype?>' == 'c')  container_c();
	   }
	
	
	 
	//切换显示图表
	$("input[name=bm]").click(function(){
		var cur_val = $(this).val();
		if(cur_val == 'all'){
		   $('.highcharts_content').css("display",'');
		   container_a();
		   container_b()
		   container_c()
	   }else{
		    $('.highcharts_content').css("display",'none');
			$('#container_'+cur_val).css("display",'');
			if(cur_val == 'a')  container_a();
			if(cur_val == 'b')  container_b();
			if(cur_val == 'c')  container_c();
	   }
	}) 
	
	 
	 	
		
});
	function selectType(){
		var type = $('#selecttype').val();
		var timetype = $('#selectTimetype').val();
		var year = $('#selectYear').val();
		var month = $('#selectMonth').val();
		var showtype=$('input:radio[name="bm"]:checked').val();
		if(cur_year != year){
			$('#selectMonth').val('-1');
			month = -1;
		}
		if('<?=$timetype?>' == '7days' && timetype == 'custom'){
			$('#selectMonth').val('-1');
			month = -1;
		}
		window.location.href="<?=$this->baseurl?>&type="+type+"&timetype="+timetype+"&year="+year+"&month="+month+"&showtype="+showtype;
	}

function container_a(){
	$('#container_a').highcharts({
     	  chart: {
            type: 'column'
        },
        title: {
            text: '<?=$title?>-柱状图'
        },
        subtitle: {
            text: '按<span style="color:red">'+ type +'</span>统计'
        },
        xAxis: {
            categories: categories_data
        },
        yAxis: {
            min: 0,
            title: {
                text: '个数'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y} 个</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: series_data,
        credits: {
            enabled: false
        }

    });
}
function container_b(){
	
	$('#container_b').highcharts({
        title: {
            text: '<?=$title?>-曲线图',
            x: -20 //center
        },
        subtitle: {
            text: '按<span style="color:red">'+ type +'</span>统计',
            x: -20
        },
        xAxis: {
            categories: categories_data
        },
        yAxis: {
            title: {
                text: '个数'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: '个'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: series_data,
        credits: {
            enabled: false
        }

    });
	
}
function container_c(){
	
	 $('#container_c').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: '<?=$title?>-饼图'
        },
        tooltip: {
    	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                    format: '<b>{point.name}</b>: {point.y} 个'
                }
            }
        },
        series: [{
            type: 'pie',
            name: '百分比',
            data: pie_series_data
        }]
		,
        credits: {
            enabled: false
        }

    });
}
</script>


<div class="col-xs-12 col-md-12">
<div class="widget">
<div class="well with-header wellpadding">
<div class="header bordered-blue">游戏访问统计</div>   
<div >
<div class="form-inline">
 按   	
 <select id="selecttype" style="padding:2px;" onchange="selectType()">
    	<option <?php if ($type == 'channel') echo "selected=selected" ?> value="channel">渠道</option>
        <option <?php if ($type == 'active') echo "selected=selected" ?> value="active">活动</option> 
        <option <?php if ($type == 'room') echo "selected=selected" ?> value="room">游戏库</option>   	
    </select>
  
  <select id="selectTimetype" style="padding:2px;" onchange="selectType()">
    	<option <?php if ($timetype == '7days') echo "selected=selected" ?> value="7days">近七天</option>
        <option <?php if ($timetype == 'custom') echo "selected=custom" ?> value="custom">自定义</option>         	
    </select>  
  
  <span id="time_content" style="display:none;">
  
   <select id="selectYear" style="padding:2px;" onchange="selectType()">
     <?php for($y = date('Y') ; $y>=2015;$y --){?>
    	<option <?php if ($y == $year) echo "selected=selected" ?> value="<?=$y?>"><?=$y?>年</option>
     <?php }?>    	
    </select> 
    
    <select id="selectMonth" style="padding:2px;" onchange="selectType()">
   		<option <?php if ($m == '-1') echo "selected=selected" ?> value="-1">全部</option>   	
     <?php for($m = 1 ; $m<=$months;$m ++){?>
    	<option <?php if ($m == $month) echo "selected=selected" ?> value="<?=$m?>"><?=$m?>月</option>
     <?php }?>    	
    </select>  
  
  
  </span>
    

   
   	<input type="radio" name="bm" value="a"/>柱状图
	<input name="bm" type="radio" value="b"/> 曲线图
    <input name="bm" type="radio" value="c"/>  饼图
    <input name="bm" type="radio" value="all"/> 全部
 </div>
<div id="container_a" class="highcharts_content" style="min-width: 500px; height: 400px; margin: 0 auto 15px 0; border:#ddd 1px solid;"></div>
<div style="clear:both;"></div>
<div id="container_b" class="highcharts_content" style="min-width:  500px; height: 400px; margin: 0 auto 15px 0; border:#ddd 1px solid;"></div>
<div style="clear:both;"></div>
<div id="container_c" class="highcharts_content" style="min-width:  500px;  height: 400px; margin: 0 auto 15px 0; border:#ddd 1px solid;"></div>
</div>
</div>
</div>
</div>
<?php $this->load->view('admin/footer');?>
