<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta content="telephone=no" name="format-detection">
<title>填写领奖信息</title>
<link href="static/gameroom/milk/css/style.css" rel="stylesheet" type="text/css">
<script src="static/gameroom/milk/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="static/gameroom/milk/js/jquery.cityselect.js"></script>
<script type="text/javascript">
$(function(){
	$(".address").citySelect({
		prov:"广西",
		city:'<?=$city ? $city : '南宁'?>',
		dist:"<?=$dist ? $dist : '武鸣县'?>", //区县 
		nodata:"none"
	});
	/*$('.dist').change(function(){
		var dist = $.trim($(".dist").val());
		var dist_in_arr = ['兴宁区','青秀区','江南区','西乡塘区','良庆区','邕宁区'];
		
		if($.inArray(dist, dist_in_arr) != -1){
			alert('南宁市内的请前往指定皇氏新鲜屋领取奖品！');
			$(this).val('武鸣县');
			$('#save_btn').hide();
		}else{
			$('#save_btn').show();
		}
	})*/
	$('.prov').change(function(){
		if($(this).val() != '广西'){
			$(this).val('广西');
			alert('仅限填写广西区内的地址！');
			$(".address").citySelect({
				prov:"广西",
				city:'南宁',
				dist:'武鸣县', //区县 
				nodata:"none"
			});
			//return false;
		}
	})	
	
	$("input:radio[name='received']").change(function (){ //拨通
		var curVal = $(this).val();
		if(curVal == 0){
			$('.yj').show();
			$('.zt').hide();
		}
		if(curVal == 1){
			$('.zt').show();
			$('.yj').hide();
		}
	});
		
});

function save_address(){
	var prov = $.trim($(".prov").val());
	var city = $.trim($(".city").val());
	var dist = $.trim($(".dist").val());
	var code = $.trim($("#yb").val());
	var address = $.trim($("#address").val());
	var name = $.trim($("#name").val());
	var received = $('input:radio[name=received]:checked').val();
	var tip ='';
	
	var dist_in_arr = ['兴宁区','青秀区','江南区','西乡塘区','良庆区','邕宁区'];
	if($.inArray(dist, dist_in_arr) != -1){
			 alert("南宁市内只能选择自提！");
		 return false;
			
	}else{
			
	}
	
	if(received == 1){
			tip = '南宁市内用户凭借中奖姓名、手机号码前往指定皇氏新鲜屋领取奖品！';
			prov = '';
			city = '';
			dist = '';
			address = '';
			code = '';
			
	}else if(received == 0){
		tip = '您的奖品将在10个工作日内寄出！';	
	}
	
	
	if(typeof(received) == "undefined")
	{
		 alert("请选择您的领奖方式！");
		 return false;
	}
	
	if(received == 0){
	
		if(address == "")
		{
		 alert("您的详细地址不能为空！");
		 return false;
		}
	}
	
	if( name == "")
	{
	 alert("您的姓名不能为空！");
	 return false;
	}
	var mob=$.trim($("#tel").val());

	if($.trim($("#tel").val())=="")
	{
	 alert("手机号码不能为空！");
	 return false;
	}
	if($.trim($("#tel").val())!="")
	{
	 var reg = /^1[3|4|5|8|7][0-9]\d{4,8}$/;
	 if(!reg.test($.trim($('#tel').val())))
	 {
	  alert("手机号码格式不对！");
	  return false;
	 }
	 
	 if ($.trim($("#tel").val()).length != 11) {
		  alert("手机号码格式不对！");
	  		return false;
	 }
	 
	 
	}

	$.ajax({
		url:'index.php?d=milk&c=receive_prize&m=save_address<?=$game_sign?>',
		type:'post',
		dataType:'json',
		data:{address:address,openid:'<?=$openid?>',name:name,tel:mob,prov:prov,city:city,dist:dist,code:code,received:received},
		success:function(res){	
			if(res == '0'){
				alert('恭喜您领奖成功，'+ tip);
				$('#save_btn').val('修改信息');
			}
			if(res == '-1' || res == '1'){
				alert('提交失败！');
			
			}
		}
	})
}
</script>
</head>

<body>

<div class="main">
<div class="address_text">
<?=$tip?></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="address">
  <tr>
    <td align="right">您的姓名<span>*</span></td>
    <td><input name="" id='name' value="<?=$name?>" type="text" class="text"  placeholder="您的姓名"></td>
  </tr>
  <tr>
    <td align="right">手机号码<span>*</span></td>
    <td width="75%"><input name="" type="text" id="tel" class="text" value="<?=$tel?>" placeholder="您的手机号码"></td>
  </tr>
   <tr>
    <td align="right">领奖方式<span>*</span></td>
    <td><input name="received"  <?php if($received == 1 || $received == 2) echo "checked"?> type="radio"  value="1"> 南宁市内需自提 <input  <?php if($received == 0) echo "checked"?> name="received" type="radio" value="0"> 南宁市外邮寄</td>
  </tr>
    <tr class="zt" style="display:<?php if($received == 0) echo "none"?>">
   
    <td colspan="2">皇氏新鲜屋参与领奖门店如下：
      <img  src="static/gameroom/milk/images/milk_address.jpg"/></td>
  </tr>

   <tr  class="yj" style="display:<?php if($received == 1 || $received == 2) echo "none"?>;">
    <td align="right">所在省份<span>*</span></td>
    <td><select style="display:none;" class="prov"></select> 
        <select  class=""><option>广西</option></select> 
    </td>
  </tr>
   <tr class="yj" style="display:<?php if($received == 1 || $received == 2) echo "none"?>;">
    <td align="right">所在城市<span>*</span></td>
    <td><select class="city" disabled="disabled"></select></td>
  </tr>
   <tr class="yj" style="display:<?php if($received == 1 || $received == 2) echo "none"?>;">
    <td align="right">所在区县<span>*</span></td>
    <td><select class="dist" disabled="disabled"></select></td>
  </tr>
   <tr class="yj" style="display:<?php if($received == 1 || $received == 2) echo "none"?>;">
    <td align="right">详细地址<span>*</span></td>
    <td><textarea name="" id='address' cols="" rows="" class="text" placeholder="收货地址"><?=$address?></textarea></td>
  </tr>
   <tr class="yj" style="display:<?php if($received == 1 || $received == 2) echo "none"?>;">
    <td align="right">邮政编码</td>
    <td><input name="" id="yb" type="text"   value="<?=$code?>" class="text"></td>
  </tr>
  <tr>
    <td colspan="2" align="right">
    <?php if ($tel) {?>
    <input name="" type="button" value="修改信息" id="save_btn" onClick="save_address()" class="okbtn">
      <?php }else{?>
     <input name="" type="button" value="提交" id="save_btn" onClick="save_address()" class="okbtn">
    <?php }?>
    </td>
    </tr>
</table>

</div>
</body>
</html>