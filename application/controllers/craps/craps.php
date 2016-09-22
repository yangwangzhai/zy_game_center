<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// 通用页 默认控制器

class craps extends CI_Controller
{
	private $url_appid = 'wxb22508fbae4f4ef4';//'wxb22508fbae4f4ef4'; //wx5442329a3bf072a0
    private $yrurl = 'zl.haiyunzy.com';  //生产环境    wx93024a4137666ab3   wx.zhenlong.wang
    private $openid = '';

    public $ActiveID = 0;
    public $ChannelID = 0;
    public $RoomID = 0;

	function __construct ()
    {    
        parent::__construct();
        $this->ChannelID = $_REQUEST['ChannelID'] ? intval($_REQUEST['ChannelID']) : intval($_REQUEST['CID']);
        $this->ActiveID = $_REQUEST['ActiveID'] ? intval($_REQUEST['ActiveID']) : intval($_REQUEST['AID']);
        $this->RoomID = $_REQUEST['RoomID'] ? intval($_REQUEST['RoomID']) : intval($_REQUEST['RID']);
        $this->sql_where = " AND ChannelID={$this->ChannelID} AND ActiveID={$this->ActiveID} AND RoomID={$this->RoomID} ";	
        $this->load->model('lb_model');
		
	}
	
    public function index () {	
	
	
		/*$state_base64 = base64_encode('http://h5game.gxtianhai.cn/mntvdb/gamecenter/index.php?d=craps&c=craps&m=game&CID='.$this->ChannelID.'&AID='.$this->ActiveID.'&RID='.$this->RoomID);
        $this->load->model('ChannelApi_model');
        $apiUrl = $this->ChannelApi_model->getApi($this->ChannelID,'GetUserInfo');
        if(!$apiUrl){
            $data['msg']='渠道接口未开启';
            $this->load->view('tip', $data);
            return;
        }
        //$temp = sprintf($apiUrl,$state_base64);

        $temp = 'http://192.168.1.178/gamecenter/index.php?d=craps&c=craps&m=game&test=1&CID='.$this->ChannelID.'&AID='.$this->ActiveID.'&RID='.$this->RoomID;
        
        header("Location: ".$temp);*/
        $state_base64 = base64_encode('http://h5game.gxtianhai.cn/mntvdb/gamecenter/index.php?d=craps&c=craps&m=game&CID='.$this->ChannelID.'&AID='.$this->ActiveID.'&RID='.$this->RoomID);
        header('Location: https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $this->url_appid . '&redirect_uri=http://' . $this->yrurl . '/thirdInterface/thirdInterface!autoLogin2.action&response_type=code&scope=snsapi_base&state=' . $state_base64 . '#wechat_redirect');
    } 

	function game() {
	    $data = array();
	    
	    $phone_os = addslashes($_SERVER['HTTP_USER_AGENT']);
	    if (strpos($phone_os, 'MicroMessenger') === false) {
            // 非微信浏览器禁止浏览
           // $this->load->view('tip', $data);
          //  return;
        } else {

            if (strpos($phone_os, 'Windows Phone') === false) {
                // 非微信浏览器禁止浏览
                // $this->load->view('tip', $data);return;
            }

        }

	    $isRun = $this->my_common_model->get_active_game_status($this->ActiveID,$this->RoomID);
        if(!$isRun['status']) {
            $data['msg'] = $isRun['msg'];
            $this->load->view('tip', $data);
            return;
        }

	    if(isset($_GET['test'])){
	        $data['wx_info'] = array(
	            'Openid' => "lkl",
	            'NickName' => '测试',
	            'HeadImg' => 'static/gameroom/craps/res/oREekjljkTwZVmxiNYUHMkDxQjPc.jpg',
	            'FirstTime'=>'yes'
	        );
	    }else{
	        $data['wx_info'] = array(
                'Openid' => addslashes($_REQUEST['openid']),
                'NickName' => addslashes($_REQUEST['nickName']),
                'HeadImg' => addslashes($_REQUEST['headPhoto'])
            );
	    }

	    $data['ChannelID'] = $this->ChannelID;
	    $data['ActiveID'] = $this->ActiveID;
	    $data['RoomID'] = $this->RoomID;

	    if(!$data['wx_info']['Openid']){
	    	$this->load->view('tip',array('msg'=>'没有获取到用户信息！'));
	        return;
	    }

	    //添加游戏访问量
        $this->my_common_model->add_game_VistNum($data['RoomID'],$data['ChannelID'],$data['ActiveID'],trim($data['wx_info']['Openid']));
        $this->my_common_model->add_game_user($data['RoomID'],$data['ChannelID'],$data['ActiveID'],trim($data['wx_info']['Openid']),trim($data['wx_info']['NickName']));
        


        //查询龙币
        $lb_num = $this->lb_model->get_lb_num($data['wx_info']['Openid'], $this->ActiveID, $this->ChannelID, $this->RoomID);
        if (!$lb_num) return false;

        if ($lb_num['returncode'] == '000000') {
        	$filename = 'static/wxheadimg/' . $data['wx_info']['Openid'] . '_105_100.jpg';
	        $isexit = $this->db->get_where('zy_craps_player',array('Openid'=>$data['wx_info']['Openid'],'ChannelID'=>$this->ChannelID,'ActiveID'=>$this->ActiveID,'RoomID'=>$this->RoomID))->row_array();

	        if($isexit){

	        	if (!file_exists($filename) || $isexit['HeadImg'] != $data['wx_info']['HeadImg']) {
	                $img_local_url = $this->getImg($data['wx_info']['HeadImg'], $filename);
	                $headLocalPhoto = base_url() . $img_local_url;
	                
	            } else {
	                $headLocalPhoto = $isexit['local_img'] ? $isexit['local_img'] : base_url() . $filename;
	            }
	            $Udata['HeadImg'] = $data['wx_info']['HeadImg'];
	            $Udata['Local_img'] = $headLocalPhoto;
	            $Udata['UpdateTime'] = time();
	            $Udata['TotalGold'] = $lb_num['dcurrency'];
	            $this->updateUser($Udata,array('Openid'=>$data['wx_info']['Openid'],'ChannelID'=>$data['ChannelID'],'ActiveID'=>$data['ActiveID'],'RoomID'=>$data['RoomID']));
	            $data['wx_info']['FirstTime'] = 'no';
	        }else{
	        	$img_local_url = $this->getImg($data['wx_info']['HeadImg'], $filename);
	            $headLocalPhoto = base_url() . $img_local_url;

	            $Udata['Openid'] = $data['wx_info']['Openid'];
	            $Udata['NickName'] = $data['wx_info']['NickName'];
	            $Udata['HeadImg'] = $data['wx_info']['HeadImg'];
	            $Udata['Local_img'] = $headLocalPhoto;
	            $Udata['AddTime'] = time();
	            $Udata['TotalGold'] = $lb_num['dcurrency'];
	            $Udata['UpdateTime'] = time();
	            $Udata['ChannelID'] = $data['ChannelID'];
	            $Udata['ActiveID'] = $data['ActiveID'];
	            $Udata['RoomID'] = $data['RoomID'];
	            $this->addUser($Udata);
	            $data['wx_info']['FirstTime'] = 'yes';
	        }

	        $data['wx_info']['Local_img'] = $headLocalPhoto;
	        $gamekey = $this->getKey();

	        //存验证码
			$this->saveGameKey($data['wx_info']['Openid'],$gamekey);

	        $data['wx_info']['TotalGold'] = $Udata['TotalGold'];
			$data['wx_info']['gamekey'] = $gamekey;

			//获取该活动自定义资源
	        $Resources_arr = $this->db->query("SELECT VarName,ReSrc FROM zy_gamelist_resources WHERE ChannelID = {$data['ChannelID']} and ActiveID = {$data['ActiveID']} and RoomID = {$data['RoomID']}")->result_array();
	        
	        $Resources = array();
	        foreach ($Resources_arr as $k => $v) {
	            $Resources[$v['VarName']] = str_replace('static/gameroom/craps/', '', $v['ReSrc']);
	        }
	        $data['resources'] = json_encode($Resources);

	        $this->db->select('MusicSet');
			$musicSet = $this->db->get_where('zy_craps_player',array('Openid'=>$data['wx_info']['Openid']))->row_array();

			$data['musicSet'] = $musicSet['MusicSet'];


			$this->load->view('craps/craps',$data);
        }else {
            if ($lb_num['returncode'] == '300001') {
                echo '请先扫码关注《真龙服务号》公众号，并在公众号的积分商城绑定手机号注册成用户！';
            } else {
                var_dump($lb_num['returncode']);
            }

        }

	        
	}

	/*
	*下注
	*Code : 0 成功， -1 gamekey验证失败， -2 龙币不足 -3 其他 -4 结算失败
	*返回结果 : json格式  {Code:错误码,Count:骰子点数,Msg:提示信息,My_YD:结算后我的总龙币,result:每个下注输赢情况}
	*/
	public function betOn() {

		$openid = addslashes(trim($_POST['openid']));
		
		if($this->checkGameKey()){//验证gamekey

			$betdata['Bet1'] = intval($_POST['1']);
			$betdata['Bet2'] = intval($_POST['2']);
			$betdata['Bet3'] = intval($_POST['3']);
			$betdata['Bet4'] = intval($_POST['4']);
			$betdata['Bet5'] = intval($_POST['5']);
			$betdata['Bet6'] = intval($_POST['6']);
			$betdata['BetBig'] = intval($_POST['big']);
			$betdata['BetSmall'] = intval($_POST['small']);
			$betdata['BetSingle'] = intval($_POST['single']);
			$betdata['BetDouble'] = intval($_POST['double']);

			

			//验证龙币是否够下注
        	$lb_num = $this->lb_model->get_lb_num($openid, $this->ActiveID, $this->ChannelID, $this->RoomID);

        	if ($lb_num['returncode'] != '000000') {
        		$result = array('Code'=>-3,'Msg'=>'获取龙币失败');
                //$this->addErrorLog(-2,'获取龙币失败');//添加记录
                $this->my_common_model->addErrLog($openid, $this->ChannelID, $this->ActiveID, $this->RoomID, '获取龙币失败', $Type = 1);
                echo json_encode($result);
                exit();
        	}

			$sum = 0;
			foreach($betdata as $v){
				$sum += $v;
			}


			if($lb_num['dcurrency'] < $sum){
				$result = array('Code'=>-2,'Msg'=>'龙币不足');
                //$this->addErrorLog(-2,'龙币不足');//添加记录
                echo json_encode($result);
                exit();
			}

			//$count = $this->getCount();//随机生成点数

			$count = $this->getCountByProbability($betdata);//控制概率生成点数

			//结算
			$jiesuan = array();
			$betCount = $betdata['Bet'.$count];//猜点数下注结算
			foreach($betdata as $k => $b){
				if($k == 'Bet'.$count){
					$jiesuan[$k] = $b * 5;
				}else{
					$jiesuan[$k] = -$b;
				}
			}

			//猜单双下注结算
			if($count % 2 == 0){
				//双
				$jiesuan['BetDouble'] = $betdata['BetDouble'];
				$jiesuan['BetSingle'] = -$betdata['BetSingle'];
			}else {
				//单
				$jiesuan['BetSingle'] = $betdata['BetSingle'];
                $jiesuan['BetDouble'] = -$betdata['BetDouble'];
			}

			//猜大小下注结算
			if($count >= 1 && $count <=3){
				//小
				$jiesuan['BetSmall'] = $betdata['BetSmall'];
                $jiesuan['BetBig'] = -$betdata['BetBig'];
			}else{
				//大
				$jiesuan['BetBig'] = $betdata['BetBig'];
                $jiesuan['BetSmall'] = -$betdata['BetSmall'];
			}

			//var_dump($jiesuan);

			//扣除龙币
			$YDsum = 0;
			foreach($jiesuan as $v){
				$YDsum += $v;
			}

			/*if($YDsum >0){
				$My_YD = $this->addYD($openid,abs($YDsum));
			}else{
				$My_YD = $this->subYD($openid,abs($YDsum));
			}*/

			//下注信息写入数据库
			$BetOndata = $betdata;
			$BetOndata['Openid'] = $openid;
			$BetOndata['Result'] = $YDsum;
			$BetOndata['Count'] = $count;
			$BetOndata['Rmark'] = array2string($jiesuan);
			$BetOndata['AddTime'] = time();
			$BetOndata['ChannelID'] = $this->ChannelID;
			$BetOndata['ActiveID'] = $this->ActiveID;
			$BetOndata['RoomID'] = $this->RoomID;
			$BetOndata['Status'] = 0;

			$this->db->insert('zy_craps_bet_on',$BetOndata);
			$gameid = $this->db->insert_id();

			if ($YDsum > 0) {
	            $return = $this->lb_model->recharge_lb($YDsum, 904, $openid, $this->ActiveID, $this->ChannelID, $this->RoomID, $gameid);
	            //var_dump($return);
	        } else {
	            $return = $this->lb_model->consume_lb(abs($YDsum), 905, $openid, $this->ActiveID, $this->ChannelID, $this->RoomID, $gameid);
	            //var_dump($return);
	        }

	        if($return['returncode'] == '000000'){
	        	$My_YD = isset($return['rechargeafter'])?$return['rechargeafter']:$return['consumeafter'];
	        	$this->db->update('zy_craps_bet_on',array('Status'=>1),array('id'=>$gameid));
	        	$this->db->update('zy_craps_player',array('TotalGold'=>$My_YD),array('Openid'=>$openid));
	        	$result = array('Code'=>0,'Count'=>$count,'Msg'=>'成功','My_YD'=>$My_YD,'result'=>$jiesuan);
	        }else{
	        	$My_YD = $this->db->get_where('zy_craps_player',array('Openid'=>$openid))->row_array();
	        	$result = array('Code'=>-4,'My_YD'=>$My_YD['TotalGold'],'Msg'=>'结算失败，本局游戏没有扣除龙币！');
	        	//$this->addErrorLog(-1,'Gamekey不正确');//添加记录
	        	$this->my_common_model->addErrLog($openid, $this->ChannelID, $this->ActiveID, $this->RoomID, '增减龙币失败', $Type = 1);
	        }

		}else{
			$result = array('Code'=>-1,'Msg'=>'数据异常,请刷新游戏页面！');
			//$this->addErrorLog(-1,'Gamekey不正确');//添加记录
			$this->my_common_model->addErrLog($openid, $this->ChannelID, $this->ActiveID, $this->RoomID, 'Gamekey不正确', $Type = 0);
		}


		echo json_encode($result);
	}

	//随机获取骰子点数
	private function getCount(){

		$rand = mt_rand(1, 6);

		return $rand;

	}

	//根据概率获取点数,待完善
	private function getCountByProbability($betdata){

		$temp_arr = array();//6种推算结果
		$tuisuan = array();
		for($i=1;$i<7;$i++){
			$sum = 0;
			$betCount = $betdata['Bet'.$i];//猜点数下注结算
			foreach($betdata as $k => $b){
				if($k == 'Bet'.$i){
					$temp_arr[$i][$k] = $b * 5;

				}else{
					$temp_arr[$i][$k] = -$b;
				}
				switch ($k)
                {
                case 'Bet1':
                case 'Bet2':
                case 'Bet3':
                case 'Bet4':
                case 'Bet5':
                case 'Bet6':
                	$sum += $temp_arr[$i][$k];
                }

			}

			//猜单双下注结算
			if($i % 2 == 0){
				//双
				$temp_arr[$i]['BetDouble'] = $betdata['BetDouble'];
				$temp_arr[$i]['BetSingle'] = -$betdata['BetSingle'];
			}else {
				//单
				$temp_arr[$i]['BetSingle'] = $betdata['BetSingle'];
				$temp_arr[$i]['BetDouble'] = -$betdata['BetDouble'];
			}

			$sum += $temp_arr[$i]['BetSingle'];
			$sum += $temp_arr[$i]['BetDouble'];

			//猜大小下注结算
			if($i >= 1 && $i <=3){
				//小
				$temp_arr[$i]['BetSmall'] = $betdata['BetSmall'];
				$temp_arr[$i]['BetBig'] = -$betdata['BetBig'];
			}else{
				//大
				$temp_arr[$i]['BetBig'] = $betdata['BetBig'];
				$temp_arr[$i]['BetSmall'] = -$betdata['BetSmall'];
			}

			$sum += $temp_arr[$i]['BetBig'];
			$sum += $temp_arr[$i]['BetSmall'];

			$temp_arr[$i]['sum'] = $sum;
			$tuisuan[$i] = $sum;
		}
		arsort($tuisuan);
		//var_dump($tuisuan);

		$prize_arr = array(
			'0' => array('id'=>1,'prize'=>'1','v'=>100),
			'1' => array('id'=>2,'prize'=>'2','v'=>100),
			'2' => array('id'=>3,'prize'=>'3','v'=>100),
			'3' => array('id'=>4,'prize'=>'4','v'=>100),
			'4' => array('id'=>5,'prize'=>'5','v'=>100),
			'5' => array('id'=>6,'prize'=>'6','v'=>100),
		);

		$j = $this->my_common_model->getRule('v_base',$this->ChannelID,$this->ActiveID,$this->RoomID);
		$inc = $this->my_common_model->getRule('v_inc',$this->ChannelID,$this->ActiveID,$this->RoomID);
		foreach($tuisuan as $k =>$v){
			$prize_arr[$k-1]['v'] = $prize_arr[$k-1]['v']*$j;
			$j += $inc;
		}


		foreach ($prize_arr as $key => $val) {
			$arr[$val['id']] = $val['v'];
		}

		$rid = $this->get_rand($arr); //根据概率获取奖项id

		$res['yes'] = $prize_arr[$rid-1]['prize']; //中奖项

		//echo $res['yes'];
		return $res['yes'];

	}

	private function addUser($Udata){
	    if(!$Udata){
	        return false;
	    }
	    
        return $this->db->insert('zy_craps_player',$Udata);
	}

	private function updateUser($Udata,$where){
        if(!$Udata){
            return false;
        }

       	return $this->db->update('zy_craps_player', $Udata, $where);
    }

    private function getYD($openid) {//获取龙币接口
        if(!$openid){
            return false;
        }

        $Pdata = $this->db->get_where('zy_craps_player',array('Openid'=>$openid,'ChannelID'=>$this->ChannelID,'ActiveID'=>$this->ActiveID,'RoomID'=>$this->RoomID))->row_array();

        return $Pdata['TotalGold'];
    }

	//添加龙币
    private function addYD($openid,$num){
    	if(!is_numeric($num) || $sum < 0){
    		return false;
    	}

    	$this->db->set('TotalGold', 'TotalGold+'.$num, FALSE);
    	$this->db->update('zy_craps_player',array('Openid'=>$openid,'ChannelID'=>$this->ChannelID,'ActiveID'=>$this->ActiveID,'RoomID'=>$this->RoomID));

    	return $this->getYD($openid);

    }

    //扣除龙币
	private function subYD($openid,$num){
		if(!is_numeric($num) || $sum < 0){
			return false;
		}

		$this->db->set('TotalGold', 'TotalGold-'.$num, FALSE);
		$this->db->update('zy_craps_player',array('Openid'=>$openid,'ChannelID'=>$this->ChannelID,'ActiveID'=>$this->ActiveID,'RoomID'=>$this->RoomID));

		return $this->getYD($openid);
	}

    private function getKey(){
    	$src_str = "abcdefghijklmnopqrstuvwxyz0123456789";
    	return substr(str_shuffle($src_str),1,10);
    }

	//存gamekey
    private function saveGameKey($openid,$gamekey){
    	if(!$openid){
			return false;
		}
    	$num = $this->db->get_where('zy_craps_session',array('Openid'=>$openid,'ChannelID'=>$this->ChannelID,'ActiveID'=>$this->ActiveID,'RoomID'=>$this->RoomID))->num_rows();

    	if($num){
    		$this->db->update('zy_craps_session', array('GameKey'=>$gamekey,'AddTime'=>time()), array('Openid'=>$openid,'ChannelID'=>$this->ChannelID,'ActiveID'=>$this->ActiveID,'RoomID'=>$this->RoomID));

    	}else{
    		$this->db->insert('zy_craps_session',array('Openid'=>$openid,'GameKey'=>$gamekey,'AddTime'=>time(),'ChannelID'=>$this->ChannelID,'ActiveID'=>$this->ActiveID,'RoomID'=>$this->RoomID));
    	}

    	//删除过期session 24小时
    	$time = time();
    	$this->db->delete('zy_craps_session',"AddTime < ".($time - 24*3600));
    }

    //验证gamekey
   	private function checkGameKey(){
   		$key = trim($_POST['gamekey']);
   		$openid = trim($_POST['openid']);
   		$res = false;
   		if($this->db->get_where('zy_craps_session',array('Openid'=>$openid,'GameKey'=>$key,'ChannelID'=>$this->ChannelID,'ActiveID'=>$this->ActiveID,'RoomID'=>$this->RoomID))->num_rows()){
   			$res = true;
   		}

   		return $res;

   	}

   	//根据概率随机生成结果
   	function get_rand($proArr) {
        $result = '';

        //概率数组的总概率精度
        $proSum = array_sum($proArr);

        //概率数组循环
        foreach ($proArr as $key => $proCur) {
            $randNum = mt_rand(1, $proSum);
            if ($randNum <= $proCur) {
                $result = $key;
                break;
            } else {
                $proSum -= $proCur;
            }
        }
        unset ($proArr);

        return $result;
    }

    function setMusic(){
		$MusicSet = intval($_GET['MusicSet']);
		$Openid = addslashes($_GET['Openid']);
		if($Openid){
			$res = $this->db->update('zy_craps_player',array('MusicSet'=>$MusicSet),array('Openid'=>$Openid,'ChannelID'=>$this->ChannelID,'ActiveID'=>$this->ActiveID,'RoomID'=>$this->RoomID));
		}
		if($res){
			$arr = array('Code'=>0,'Msg'=>'设置成功');
		}else{
			$arr = array('Code'=>-1,'Msg'=>'设置失败');
		}

		echo json_encode($arr);
    }

    /**
     * 生成缩略图函数  剪切
     *
     * @param $imgurl 图片路径
     * @param $width 缩略图宽度
     * @param $height 缩略图高度
     * @return string 生成图片的路径 类似：./uploads/201203/img_100_80.jpg
     */
    private function thumb($imgurl, $width = 100, $height = 100)
    {
        if (empty($imgurl))
            return '不能为空';

        include_once 'application/libraries/image_moo.php';
        $moo = new Image_moo();
        $moo->load($imgurl);
        $moo->resize_crop($width, $height);
        $moo->save_pa('', '', true);
    }


    /*
    *@通过curl方式获取指定的图片到本地
    *@ 完整的图片地址
    *@ 要存储的文件名
    */
    private function getImg($url = "", $filename = "")
    {
        //去除URL连接上面可能的引号
        //$url = preg_replace( '/(?:^['"]+|['"/]+$)/', '', $url );
        $hander = curl_init();
        $fp = fopen($filename, 'wb');
        curl_setopt($hander, CURLOPT_URL, $url);
        curl_setopt($hander, CURLOPT_FILE, $fp);
        curl_setopt($hander, CURLOPT_HEADER, 0);
        curl_setopt($hander, CURLOPT_FOLLOWLOCATION, 1);
        //curl_setopt($hander,CURLOPT_RETURNTRANSFER,false);//以数据流的方式返回数据,当为false是直接显示出来
        curl_setopt($hander, CURLOPT_TIMEOUT, 60);
        curl_exec($hander);
        curl_close($hander);
        fclose($fp);
        $this->thumb($filename, 105, 100);
        return $filename;
    }
    

    




}