<?php
$ip = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
$url = $ip . '/gamecenter/index.php?c=crond';
if(isset($_GET['debug']) && $_GET['debug'] == 'yes'){
		$url .= '&debug=yes';
}
$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
@curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在   
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);//返回文本流,
$data = curl_exec($ch);
curl_close($ch);
echo $data;	

