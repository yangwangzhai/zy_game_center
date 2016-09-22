<?php 
//error_reporting(0);
define('BASEPATH',true);
define('DEBUG',false);  //是否调试
define('ROOTDIR','/phpstudy/www/gamecenter/');
include(ROOTDIR."./application/config/database.php");
$_CONN = mysql_connect($db['default']['hostname'], $db['default']['username'], $db['default']['password']);
mysql_select_db($db['default']['database'], $_CONN);

class Crond 
{
    function __construct ()
    {    
		global $_CONN;    
		$this->link_identifier = $_CONN;		
		$this->host            = 'http://119.29.87.142/gamecenter/';  //获取附件的服务器地址 
		$this->ip 			   = '119.29.56.43'; //需同步的IP，执行计划任务的IP
    }
	
	function index () {
		$interval = 30;
		//print_r($_SERVER);
		$ip = $this->ip;//isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
		$searchsql = "  SELECT * FROM  zy_attachment WHERE id NOT IN(SELECT attachment_id FROM zy_attachment_log WHERE fromIP ='{$ip}') "; //FIND_IN_SET('{$ip}',updateIP)
	
		$result = $this->query( $searchsql );	
		if(isset($_GET['debug']) || DEBUG){
			var_dump($result);
		}
		
		$i = 0;
		foreach($result as $key=>$val){
			$path =  $val['filepath'];	
			if($this->file_exit($this->host . $path)){
				$i ++;
				$data = file_get_contents($this->host . $path);
				$path2 = dirname(ROOTDIR.$path);	
				if(!empty( $data )){		
					if (!file_exists($path2)){ 	
						 $this->createDir($path2);	
					}					
					file_put_contents(ROOTDIR.$path, $data);
					if(file_exists(ROOTDIR.$path)){ 
					//插入同步记录
					$data_log['addtime'] = time();
					$data_log['fromIP'] = $ip;
					$data_log['attachment_id'] = $val['id'];
					$this->inserttable('zy_attachment_log', $data_log,1);		
					}
					
				}
			}
		}
		
		if(!isset($_GET['debug'])) echo 'Update files : '.$i;	

    } 	
	
	/*
	* 功能：循环检测并创建文件夹
	* 参数：$path 文件夹路径
	* 返回：
	*/
	function createDir($path){
		if (!file_exists($path)){
			$this->createDir(dirname($path));
			mkdir($path, 0777);
		}
	} 

    function file_exit($url){
		$exit = true;
		$ch = curl_init(); 
		$timeout = 10; 
		curl_setopt ($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_HEADER, 1); 
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout); 		
		$contents = curl_exec($ch);		
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);  	
		if($http_code != 200) {
			$exit = false;
		}
		return $exit;
	}
	
	/*---------------db start------------------*/

	function query($sql){
		$rearr = array();
		$rs = mysql_query($sql);
		while($row = mysql_fetch_array($rs)){
			$rearr[] = $row;
		}
		return $rearr;
	}

	function inserttable($tablename, $insertsqlarr, $returnid=0, $replace = false, $silent=0) {
		$insertkeysql = $insertvaluesql = $comma = '';
		foreach ($insertsqlarr as $insert_key => $insert_value) {
			$insertkeysql .= $comma.'`'.$insert_key.'`';
			$insertvaluesql .= $comma.'\''.$insert_value.'\'';
			$comma = ', ';
		}
		$method = $replace?'REPLACE':'INSERT';
		mysql_query($method.' INTO '.$this->tname($tablename).' ('.$insertkeysql.') VALUES ('.$insertvaluesql.') ');
		if($returnid && !$replace) {
			return $this->insert_id();
		}
	}

	function insert_id() {
		return ($id = mysql_insert_id($this->link_identifier)) >= 0 ? $id : $this->result($this->query("SELECT last_insert_id()"), 0);
	}

	function result($query, $row) {
		$query = @mysql_result($query, $row);
		return $query;
	}
	function tname($tablename){
		return $tablename;
	}
}

//同步开始...
$run = new Crond();
$run->index();

?>
