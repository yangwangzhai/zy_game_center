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
<link href="static/gameroom/milk/css/style.css" rel="stylesheet" type="text/css">
</head>
<body>

<div class="main">
<div class="top_body">
<div class="top_title"><img src="static/gameroom/milk/images/user.jpg" class="userimg"/><img  src="static/gameroom/milk/images/zjmd_title.png"/></div>
<div class="top_list">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th>奖项</th>
     <th>用户</th>
    <th>成绩</th>
  </tr> 
   <?php $txt = array('','一','二','三');foreach($list as $val){?> 
  <tr>
  <td><strong><?=$txt[$val['is_winning']]?>等奖</strong></td>
   <td style="text-align:left; padding-left:25px;"><img src="<?=$val['head_img']?>"/> <?=mb_substr($val['nickname'],0,10)?></td>
   <td><strong><?=$val['MaxS']?>瓶</strong></td>
  </tr>
<?php }?>
</table>


</div>
<div class="pages">
<?=$pages?>

<a href="index.php?d=milk&c=milk_fight<?=$game_sign?>" class="next">返回</a>
</div>
</div> 
</div>
</body>
</html>
