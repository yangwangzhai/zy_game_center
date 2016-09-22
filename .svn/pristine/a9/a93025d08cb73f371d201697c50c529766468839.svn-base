<?php if (! defined('BASEPATH'))  exit('No direct script access allowed');

class Crond extends CI_Controller
{
   
    function __construct ()
    {    
        parent::__construct();            
        
        $this->baseurl = 'index.php?c=crond';
        $this->table = 'zy_attachment';               
		
    }
	public function index () {
		$interval = 30;
		$ip = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
		$searchsql = "  SELECT * FROM  $this->table WHERE id NOT IN(SELECT attachment_id FROM zy_attachment_log WHERE fromIP ='{$ip}') "; //FIND_IN_SET('{$ip}',updateIP)
	
		$result = $this->db->query( $searchsql )->result_array();	
		if(isset($_GET['debug']) && $_GET['debug'] == 'yes'){
			var_dump($result);	
		}
		
		$host = 'http://119.29.87.142/gamecenter/';
		$i = 0;
		foreach($result as $key=>$val){
			$path =  $val['filepath'];				
			if($this->file_exit($host . $path)){
				$i ++;
				$data = file_get_contents($host . $path);
				$path2 = dirname($path);	
					
				if(!empty( $data )){
					if (!file_exists($path2)){ 	
						 $this->createDir($path2);	
					}					
					var_dump(file_put_contents($path, $data));
					if(file_exists($path)){ 
					//插入同步记录
					$data_log['addtime'] = time();
					$data_log['fromIP'] = $ip;
					$data_log['attachment_id'] = $val['id'];
					$this->db->insert('zy_attachment_log', $data_log);		
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
		$timeout = 20; 
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
	


}


?>
