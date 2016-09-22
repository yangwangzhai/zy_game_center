<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class fruit extends CI_Controller
{
    private $url_appid = 'wxb22508fbae4f4ef4';//'wxb22508fbae4f4ef4'; //wx5442329a3bf072a0
    private $yrurl = 'zl.haiyunzy.com';  //生产环境    wx93024a4137666ab3   wx.zhenlong.wang
    private $openid = '';

    public $ActiveID = 0;
    public $ChannelID = 0;
    public $RoomID = 0;

    function __construct()
    {
        parent::__construct();
        $this->ActiveID = $this->input->get('ActiveID') ? $this->input->get('ActiveID') : $this->input->get('AID');
        $this->ChannelID = $this->input->get('ChannelID') ? $this->input->get('ChannelID') : $this->input->get('CID');
        $this->RoomID = $this->input->get('RoomID') ? $this->input->get('RoomID') : $this->input->get('RID');
		
		$this->ActiveID = intval($this->ActiveID);
		$this->ChannelID = intval($this->ChannelID);
		$this->RoomID = intval($this->RoomID);
		
		if($this->ActiveID && !$this->ChannelID){
			$this->content_model->set_table( 'zy_active_main' );
			$row = $this->content_model->get_one($this->ActiveID, 'ActiveID');			
			$this->ChannelID = $row['ChannelID'];
			$this->RoomID    = $row['RoomID'];
		}
		
        $this->game_sign = "&AID=$this->ActiveID&CID=$this->ChannelID&RID=$this->RoomID";
        $this->game_sign_sql = addslashes("  ActiveID=$this->ActiveID AND ChannelID=$this->ChannelID AND RoomID=$this->RoomID");
        $this->load->model('my_common_model', 'common');
        $this->load->model('lb_model');
		
    }


    public function index()
    {
		$this->check_game_rule();
        if (isset($_GET['test'])) {
		
            $session_id = session_id();
            $phone_os = $_SERVER['HTTP_USER_AGENT'];
            $headurl = "http://wx.qlogo.cn/mmopen/GQfdS1CPWRJWI6Xu0Rn6mUqL3tICLeRiazbwFtr6pC3E5wxM5hM4Efw2CSo17Ow6ibPVns0otmphxY62BibVuBP4Y3743NEFkVO/0";
            $wx_info = array('openid' => 'woM0Mxs3oVcGxDn9vdeEKnL3HpdSo', 'nickname' => '牵着你手陪你看日出', 'headimgurl' => $headurl, 'sex' => 1);
            $filename = 'static/wxheadimg/' . $wx_info['openid'] . '.jpg';
            //  $img_local_url = $this->getImg($wx_info['headimgurl'], $filename);
            //   $headPhoto = base_url() . $img_local_url;

            $data['first_time'] = 'no';
            $data['openid'] = $wx_info['openid'];
            $data['nickname'] = $wx_info['nickname'];
            // $data['headimgurl'] = $headPhoto;//$wx_info['headimgurl'];
            $this->openid = $data['openid'];
            $isexit = $this->db->query("select count(*) as num,nickname,head_img, local_img, score,allowMusic  from zy_fruit_player where openID='" . $data['openid'] . "' AND $this->game_sign_sql ")->row_array();

            if ($isexit['num'] > 0) {
                if (!file_exists($filename) || $isexit['head_img'] != $headurl) {
                    $img_local_url = $this->getImg($headurl, $filename);
                    $headLocalPhoto = base_url() . $img_local_url;
                    $data['headimgurl'] = $headLocalPhoto;
                } else {
                    $data['headimgurl'] = $isexit['local_img'] ? $isexit['local_img'] : base_url() . $filename;
                }
                $update_nickname = "";
                if ($isexit['nickname'] != $data['nickname']) $update_nickname = "  nickname='" . $data['nickname'] . "' , ";
                //total_gold =".$data['smokeBeansCount']."  ,
                $this->db->query("update zy_fruit_player set {$update_nickname}  lasttime= " . time() . " ,head_img = '" . $headPhoto . "' ,session_id = '" . $session_id . "',phone_os = '" . $phone_os . "' ,local_img = '" . base_url() . $filename . "' where openID= '" . $data['openid'] . "' AND $this->game_sign_sql");//更新烟豆
                $data['smokeBeansCount'] = $isexit['score'];
                $data['allowMusic'] = $isexit['allowMusic'];
                //最后一次游戏未退的比倍数
                $last_result_info = $this->get_last_result_gold($data['openid']);
                $data['last_result_gold'] = $last_result_info['last_result_gold'];
                $data['last_game_id'] = $last_result_info['last_gameid'];
                $data['allowMusic'] = $isexit['allowMusic'];
            } else {
                $img_local_url = $this->getImg($headurl, $filename);
                $headLocalPhoto = base_url() . $img_local_url;

                $data['headimgurl'] = $headLocalPhoto;

                $user_data['openID'] = $data['openid'];
                $user_data['nickname'] = $data['nickname'];
                $user_data['head_img'] = $data['headimgurl'];
                $user_data['local_img'] = $headLocalPhoto;
                $user_data['sex'] = 0;
                $user_data['addtime'] = time();
                $user_data['lasttime'] = time();
                $user_data['score'] = 10000;
                $user_data['session_id'] = $session_id;
                $user_data['phone_os'] = $phone_os;
                $user_data['ActiveID'] = $this->ActiveID;
                $user_data['ChannelID'] = $this->ChannelID;
                $user_data['RoomID'] = $this->RoomID;

                $insert_sql = $this->db->insert_string('zy_fruit_player', $user_data);
                $insert_sql = str_replace('INSERT', 'INSERT ignore ', $insert_sql);
                $this->db->query($insert_sql);
                $data['smokeBeansCount'] = $user_data['score'];
                $data['last_result_gold'] = 0;
                $data['last_game_id'] = 0;
                $data['allowMusic'] = 1;
                $data['first_time'] = 'yes';
            }


        } else {
            $this->ActiveID = $this->input->get('ActiveID') ? $this->input->get('ActiveID') : $this->input->get('AID');
            $this->ChannelID = $this->input->get('ChannelID') ? $this->input->get('ChannelID') : $this->input->get('CID');
            $this->RoomID = $this->input->get('RoomID') ? $this->input->get('RoomID') : $this->input->get('RID');
            $game_sign = "&AID=$this->ActiveID&CID=$this->ChannelID&RID=$this->RoomID";
            $this->game_sign = $game_sign;
            $state_base64 = base64_encode('http://h5game.gxtianhai.cn/mntvdb/gamecenter/index.php?d=fruit&c=fruit&m=getUserInfo&ActiveID=' . $this->ActiveID);
            header('Location: https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $this->url_appid . '&redirect_uri=http://' . $this->yrurl . '/thirdInterface/thirdInterface!autoLogin2.action&response_type=code&scope=snsapi_base&state=' . $state_base64 . '#wechat_redirect');
            exit;
            /*   $ActiveID = $this->input->get('ActiveID');
               $ChannelID = $this->input->get('ChannelID');
               $RoomID = $this->input->get('RoomID');

               //判断活动、游戏状态
               $isRun = $this->common->get_active_game_status($ActiveID,$RoomID);
               if(!$isRun['status']) {
                   $data['msg'] = $isRun['msg'];
                   $this->load->view('tip', $data);
                   return;
               }

               if($ActiveID && $ChannelID && $RoomID){
                   $state_base64 = base64_encode('http://h5game.gxtianhai.cn/fruit/index.php?c=fruit&m=getUserInfo&CID='.$ChannelID.'&AID='.$ActiveID.'&RID='.$RoomID);
                   $this->load->model('ChannelApi_model');
                   $apiUrl = $this->ChannelApi_model->getApi($ChannelID,'GetUserInfo');
                   $temp = sprintf($apiUrl,$state_base64);
                   if(empty($temp)) show_msg('渠道接口获取失败ChannelID：'.$ChannelID.'！');
                   header("Location: ".$temp);

                   return;
               }else{
                   show_msg('非法访问！');
                   exit;
               }*/
        }
        //添加游戏访问量
        $this->common->add_game_VistNum($this->RoomID, $this->ChannelID, $this->ActiveID, trim($this->openid));
        $this->common->add_game_user($this->RoomID, $this->ChannelID, $this->ActiveID, trim($this->openid), $data['nickname'], $data['smokeBeansCount']);
        $this->load->view('index', $data);
    }

    function getUserInfo()
    {
		$this->check_game_rule('');
        $session_id = session_id();
        $phone_os 	= addslashes($_SERVER['HTTP_USER_AGENT']);
        $openid 	= addslashes($_REQUEST['openid']);
        $nickname 	= addslashes($_REQUEST['nickName']);
        $headPhoto 	= addslashes($_REQUEST['headPhoto']);
        $data = array();
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

      
        $data['openid'] 	= $openid;
        $data['nickname'] 	= $nickname;
        $data['sex'] 		= 0;
        $data['first_time'] = 'no';
        //查询龙币
        $lb_num = $this->lb_model->get_lb_num($openid, $this->ActiveID, $this->ChannelID, $this->RoomID);
        if (!$lb_num) return false;
        if ($lb_num['returncode'] == '000000') {
            $dcurrency 					= $lb_num['dcurrency']; //龙币数
            $data['smokeBeansCount'] 	= $dcurrency;
            $isexit = $this->db->query("select count(*) as num,nickname,head_img, local_img,score,allowMusic  from zy_fruit_player where openID='" . $openid . "' AND $this->game_sign_sql ")->row_array();
            $filename = 'static/wxheadimg/' . $openid . '.jpg';

            if ($isexit['num'] > 0) {
                if (!file_exists($filename) || $isexit['head_img'] != $headPhoto) {
                    $img_local_url 		= $this->getImg($headPhoto, $filename);
                    $headLocalPhoto 	= base_url() . $img_local_url;
                    $data['headimgurl'] = $headLocalPhoto;
                } else {
                    $data['headimgurl'] = $isexit['local_img'] ? $isexit['local_img'] : base_url() . $filename;
                }
                $update_nickname 		= "";
                if ($isexit['nickname'] != $nickname) $update_nickname = "  nickname='" . $nickname . "' , ";
               
                $this->db->query("update zy_fruit_player set {$update_nickname} score =" . $data['smokeBeansCount'] . "  ,  lasttime= " . time() . " ,head_img = '" . $headPhoto . "' ,session_id = '" . $session_id . "',phone_os = '" . $phone_os . "' ,local_img = '" . base_url() . $filename . "' where openID= '" . $openid . "' AND $this->game_sign_sql ");//更新烟豆

                $data['allowMusic'] 	= $isexit['allowMusic'];
                //最后一次游戏未退的比倍数
                //$last_result_info 		= $this->get_last_result_gold($data['openid']);
                $data['last_result_gold'] = 0;//$last_result_info['last_result_gold'];
                $data['last_game_id'] 	= 0;//$last_result_info['last_gameid'];
            } else {
                $img_local_url 			= $this->getImg($headPhoto, $filename);
                $headLocalPhoto 		= base_url() . $img_local_url;

                $data['headimgurl'] 	= $headLocalPhoto;

                $user_data['openID'] 	= $openid;
                $user_data['nickname'] 	= $nickname;
                $user_data['head_img'] 	= $headPhoto;
                $user_data['local_img'] = $headLocalPhoto;
                $user_data['sex'] 		= 0;
                $user_data['addtime'] 	= time();
                $user_data['lasttime'] 	= time();
                $user_data['score'] 	= $dcurrency;
                $user_data['session_id']= $session_id;
                $user_data['phone_os'] 	= $phone_os;
                $user_data['ActiveID'] 	= $this->ActiveID;
                $user_data['ChannelID'] = $this->ChannelID;
                $user_data['RoomID'] 	= $this->RoomID;
                $insert_sql = $this->db->insert_string('zy_fruit_player', $user_data);
                $insert_sql = str_replace('INSERT', 'INSERT ignore ', $insert_sql);
                $this->db->query($insert_sql);
                $data['last_result_gold']	= 0;
                $data['last_game_id'] 		= 0;
                $data['allowMusic'] 		= 1;
                $data['first_time'] 		= 'yes';
            }
			//微信分享用到的信息
            $signPackage = $this->common->getSignPackage();
            $data['signPackage'] = $signPackage;
			//获取游戏UI
			$data['GameUI'] =  $this->common->get_game_ui($this->ActiveID, 'fruit');
			
            //添加游戏访问量
            $this->common->add_game_VistNum($this->RoomID, $this->ChannelID, $this->ActiveID, trim($openid));
            $this->common->add_game_user($this->RoomID, $this->ChannelID, $this->ActiveID, trim($openid), $data['nickname'], $data['smokeBeansCount']);
            $this->load->view('fruit/index', $data);

        } else {
            if ($lb_num['returncode'] == '300001') {
                $data['msg'] = '请先扫码关注《真龙服务号》公众号，并在公众号的积分商城绑定手机号注册成用户！';
				
            } else {
               $data['msg'] = $lb_num['returncode'].'<br>'.$lb_num['returnmsg'];
            }
			$this->load->view('tip', $data);

        }

    }

    //押大押小
    function big_small()
    {
        $game_id = $this->input->post('gameId');
        $openid  = $this->input->post('openid');
        $type 	 = $this->input->post('type');
        //判断是否有session
        $session_id_exit = $this->check_seesion_id($openid, 0);
        if (!$session_id_exit) {
            $return['status'] = -1;
            echo json_encode($return);
			//添加异常记录
			$content = '押大小时seesion_id验证不对';
			$this->common->addErrLog($openid, $this->ChannelID, $this->ActiveID, $this->RoomID, $content);
            exit;
        }
        $sql = "SELECT * FROM zy_fruit_game WHERE id=$game_id AND openid='{$openid}' AND status=1 AND $this->game_sign_sql";
        $cur_game = $this->db->query($sql)->row_array();
        //判断游戏id和提交的openid是否和数据库里一直
        if ($cur_game) {
            $result_bs_sql = "SELECT * FROM zy_fruit_result_bs_log WHERE gameid=$game_id AND $this->game_sign_sql ORDER BY id DESC limit 1";
            $cur_result_bs = $this->db->query($result_bs_sql)->row_array();
            if ($cur_result_bs) {//如果之前加减倍过，原来的值就等于上次的值
                $result_bs_data['old_gold'] = $cur_result_bs['cur_gold'];
            } else {
                $result_bs_data['old_gold'] = $cur_game['result_gold'];
            }
            //如果前一次的比倍为0，要么是为中奖或者已经退币
            if ($result_bs_data['old_gold'] < 1) {
                $return['status'] = -2;
                echo json_encode($return);
				//添加异常记录
				$content = '押大小时比倍龙币归零后还押';
				$this->common->addErrLog($openid, $this->ChannelID, $this->ActiveID, $this->RoomID, $content);
                return;
            }
			
			$cur_gold = $result_bs_data['cur_gold'];
			if($cur_gold == 1){
				$gaiuv = 40;
			}else if($cur_gold == 2){
				$gaiuv = 30;
			}else{
				$gaiuv = 20;
			}
			
            $big_small = 0;
            //如果押小，开小的概率为20%
            if ($type == 'small') {
                $big_small = $this->get_rand(array(7 => $gaiuv, 14 => (100-$gaiuv) ));
            } else {
                $big_small = $this->get_rand(array(7 => (100-$gaiuv), 14 => $gaiuv));
            }

            if ($big_small == 7) {
                $result_bs_data['result_num'] = rand(1, 7);//大小结果随机生成
            } else {
                $result_bs_data['result_num'] = rand(8, 14);//大小结果随机生成
            }


            //开小
            if ($result_bs_data['result_num'] < 8 && $type == 'small') {
                $result_bs_data['cur_gold'] = $result_bs_data['old_gold'] * 2;
                $result_bs_data['result_status'] = 1;
                $result_bs_data['real_trade_gold'] = $result_bs_data['old_gold'];
            } else if ($result_bs_data['result_num'] > 7 && $type == 'big') {
                $result_bs_data['cur_gold'] = $result_bs_data['old_gold'] * 2;
                $result_bs_data['result_status'] = 1;
                $result_bs_data['real_trade_gold'] = $result_bs_data['old_gold'];
            } else {
                $result_bs_data['cur_gold'] = 0;
                $result_bs_data['real_trade_gold'] = -$result_bs_data['old_gold'];
            }


            $result_bs_data['type'] = $type;
            $result_bs_data['trade_gold'] = $result_bs_data['cur_gold'] - $result_bs_data['old_gold'];
            $result_bs_data['addtime'] = time();
            $result_bs_data['gameid'] = $game_id;

            $result_bs_data['ActiveID'] = $this->ActiveID;
            $result_bs_data['ChannelID'] = $this->ChannelID;
            $result_bs_data['RoomID'] = $this->RoomID;

            //保存金额进出
            $this->save_player_result($result_bs_data, $openid);
            $query = $this->db->insert('zy_fruit_result_bs_log', $result_bs_data);
            if ($query) {
                //更新玩家表的烟豆
                 $this->db->query( "UPDATE zy_fruit_player SET score=score-".$result_bs_data['trade_gold']." WHERE  openid='{$openid}'" );
            }

            $return['status'] = 1;
            $return['result_num'] = $result_bs_data['result_num'];//开大小的数字
            $return['result_gold'] = $result_bs_data['cur_gold'];
            echo json_encode($return);

        } else {
            $return['status'] = -1;
            echo json_encode($return);
			//添加异常记录
			$content = '押大小时查询不到要押的游戏局数';
			$this->common->addErrLog($openid, $this->ChannelID, $this->ActiveID, $this->RoomID, $content);
        }


    }

    //保存下注
    function save_bet()
    {
        $bet_id = $this->input->post('betId');
        $game_id = $this->input->post('gameId');
        $openid = $this->input->post('openid');
        //判断是否有session
        $session_id_exit = $this->check_seesion_id($openid);
        if (!$session_id_exit) {
            $return['status'] = -1;
            echo json_encode($return);
            exit;
        }
        $field = 'bet' . ($bet_id + 1);
        $return = array('sum' => 0, 'game_id' => 0);
        if ($game_id > 0) {
            $this->db->query("UPDATE zy_fruit_game SET $field = $field + 1 where id=$game_id AND $this->game_sign_sql");
            $game_new_id = $game_id;
        } else {
            $data[$field] = 1;
            $data['addtime'] = time();
            $data['openid'] = $openid;
            $data['ActiveID'] = $this->ActiveID;
            $data['ChannelID'] = $this->ChannelID;
            $data['RoomID'] = $this->RoomID;
            $this->db->insert('zy_fruit_game', $data);
            $game_new_id = $this->db->insert_id();
        }

        $sql = "SELECT * FROM zy_fruit_game WHERE id=$game_new_id AND $this->game_sign_sql";
        $cur_game = $this->db->query($sql)->row_array();
        $return['sum'] = $cur_game[$field];
        $return['game_id'] = $game_new_id;
        $return['openid'] = $this->openid;
        $return['status'] = 1;
        echo json_encode($return);
        $result_arr = $this->result_arr();
        $result_rand_id = $this->get_rand_num($game_new_id);

        $field = $result_arr[$result_rand_id]['field'];
        $re_data['result_index'] = $result_rand_id;
        $re_data['result_bs'] = $result_arr[$result_rand_id]['bs'];
        $re_data['result_gold'] = intval($cur_game[$field]) * intval($re_data['result_bs']);
        $this->db->update('zy_fruit_game', $re_data, array('id' => $game_new_id));

    }

    //加减倍，退币
    function play_bet()
    {
        $type = $this->input->post('type');
        $game_id = $this->input->post('gameId');
        $openid = $this->input->post('openid');
        //判断是否有session
        $session_id_exit = $this->check_seesion_id($openid, 0);
        if (!$session_id_exit) {
            $return['status'] = -1;
            echo json_encode($return);
			//添加异常记录
			$content = '加减倍，退币时session_id不对';
			$this->common->addErrLog($openid, $this->ChannelID, $this->ActiveID, $this->RoomID, $content);
            exit;
        }
        $sql = "SELECT * FROM zy_fruit_game WHERE id=$game_id AND openid='{$openid}' AND status=1 AND $this->game_sign_sql";
        $cur_game = $this->db->query($sql)->row_array();
        //判断游戏id和提交的openid是否和数据库里一直
        if ($cur_game) {
            $result_bs_sql = "SELECT * FROM zy_fruit_result_bs_log WHERE gameid=$game_id AND $this->game_sign_sql ORDER BY id DESC limit 1";
            $cur_result_bs = $this->db->query($result_bs_sql)->row_array();
            if ($cur_result_bs) {//如果之前加减倍过，原来的值就等于上次的值
                $result_bs_data['old_gold'] = $cur_result_bs['cur_gold'];
            } else {
                $result_bs_data['old_gold'] = $cur_game['result_gold'];
            }
            //如果前一次的比倍为0，要么是为中奖或者已经退币
            if ($result_bs_data['old_gold'] < 1) {
                $return['status'] = -2;
                echo json_encode($return);
				//添加异常记录
				$content = '押大小时比倍龙币归零后还可加减倍';
				$this->common->addErrLog($openid, $this->ChannelID, $this->ActiveID, $this->RoomID, $content);
                return;
            }

            //减倍
            if ($type == 'right') {
                $result_bs_data['cur_gold'] = floor($result_bs_data['old_gold'] / 2);
            }
            //加倍
            if ($type == 'left') {
				//判断是否够币加倍
				$isexit = $this->db->query("select score from zy_fruit_player where openID='" . $openid . "' ")->row_array();
				if($result_bs_data['cur_gold'] > $isexit['score']){
					 $return['status'] = -2;
            		 echo json_encode($return);
					 //添加异常记录
					 $content = '押大小时比倍龙币超过剩余的龙币';
					 $this->common->addErrLog($openid, $this->ChannelID, $this->ActiveID, $this->RoomID, $content);
					 return;
				}
                $result_bs_data['cur_gold'] = $result_bs_data['old_gold'] * 2;
            }
            //退币
            if ($type == 'return') {
                $result_bs_data['cur_gold'] = 0;
            }


            $result_bs_data['type'] = $type;
            $result_bs_data['trade_gold'] = $result_bs_data['cur_gold'] - $result_bs_data['old_gold'];
            $result_bs_data['addtime'] = time();
            $result_bs_data['gameid'] = $game_id;

            $result_bs_data['ActiveID'] = $this->ActiveID;
            $result_bs_data['ChannelID'] = $this->ChannelID;
            $result_bs_data['RoomID'] = $this->RoomID;

            $query = $this->db->insert('zy_fruit_result_bs_log', $result_bs_data);
            if ($query) {
                //更新玩家表的龙币
                $this->db->query("UPDATE zy_fruit_player SET score=score-" . $result_bs_data['trade_gold'] . " WHERE  openid='{$openid}'  AND $this->game_sign_sql");
            }
            $return['status'] = 1;
            echo json_encode($return);
        } else {
            $return['status'] = -2;
            echo json_encode($return);
			//添加异常记录
			$content = '查不到加减倍，退币的游戏局数';
			$this->common->addErrLog($openid, $this->ChannelID, $this->ActiveID, $this->RoomID, $content);
        }
    }

    //一起保存下注
    function save_bet_more()
    {	
		$this->check_game_rule('ajax');
        $bet_on_gold = $this->input->post('bet_on_gold');
        $bet_on_gold = rtrim(trim($bet_on_gold), ',');
        $openid = $this->input->post('openid');
        if ( empty($bet_on_gold)) {
            $return['status'] = -1;
            echo json_encode($return);
			//添加异常记录
			$content = '提交下注时下注数为空';
			$this->common->addErrLog($openid, $this->ChannelID, $this->ActiveID, $this->RoomID, $content);
            exit;
        }
        $bet_on_golds = explode(',', $bet_on_gold);
        $sum_gold = 0;//总共下注的龙币数
        $data = array();
        foreach($bet_on_golds as $gold) {
            if (empty($gold)) continue;
            $golds = explode(':', trim($gold));
            $sum_gold += $golds[1];
            $data[$golds[0]] = $golds[1];
        }

        //判断是否有session和龙币数是否够用
        $session_id_exit = $this->check_seesion_id($openid, $sum_gold);
        if (!$session_id_exit || empty($bet_on_gold)) {
            $return['status'] = -1;
            echo json_encode($return);
			//添加异常记录
			$content = '提交下注时session_id不对';
			$this->common->addErrLog($openid, $this->ChannelID, $this->ActiveID, $this->RoomID, $content);
            exit;
        }

        $return = array('sum' => 0, 'game_id' => 0);

        $data['addtime'] = time();
        $data['openid'] = $openid;
        $data['ActiveID'] = $this->ActiveID;
        $data['ChannelID'] = $this->ChannelID;
        $data['RoomID'] = $this->RoomID;
        $this->db->insert('zy_fruit_game', $data);
        $game_new_id = $this->db->insert_id();


        $sql = "SELECT * FROM zy_fruit_game WHERE id=$game_new_id AND $this->game_sign_sql";
        $cur_game = $this->db->query($sql)->row_array();

        $result_arr = $this->result_arr();
        $result_rand_id = $this->get_rand_num($game_new_id);

        $field = $result_arr[$result_rand_id]['field'];
        $re_data['result_index'] = $result_rand_id;
        $re_data['result_bs'] = $result_arr[$result_rand_id]['bs'];
        $re_data['result_gold'] = intval($cur_game[$field]) * intval($re_data['result_bs']);
        $this->db->update('zy_fruit_game', $re_data, array('id' => $game_new_id));

        $this->get_result($game_new_id, $openid);
    }



    function get_result($gameId, $openid)
    {
        $game_id = $gameId;//$this->input->get('gameId');
        //$openid = $openid;//$this->input->get('openid');
        //判断是否有session
       /* $session_id_exit = $this->check_seesion_id($openid,0);
        if (!$session_id_exit) {
            $return['status'] = -1;
            echo json_encode($return);
            exit;
        }*/
        $sql = "SELECT * FROM zy_fruit_game WHERE id=$game_id AND openid='{$openid}' AND status=0  AND $this->game_sign_sql";
        $cur_game = $this->db->query($sql)->row_array();
        //判断游戏id和提交的openid是否和数据库里一直
        if ($cur_game) {
            $result_arr = $this->result_arr();
            $coordinate = $result_arr[$cur_game['result_index']]['coordinate'];
            $field = $result_arr[$cur_game['result_index']]['field'];
            $return['xhr_stop_margin'] = $coordinate[0];
            $return['xhr_stop_num'] = $coordinate[1];
            if ($field == 'goodluck') {
                $return['result_gold'] = 0;
            } else {
                $field_num = intval($cur_game[$field]);
                $result_bs = intval($cur_game['result_bs']);

                $return['result_gold'] = $field_num * $result_bs;
            }

            $bet_on_sum = 0;
            for ($i = 1; $i < 9; $i++) {
                $bet_on_sum += intval($cur_game['bet' . $i]);
            }

            //下注金额的框位置
            $bet_index = intval(str_replace('bet', '', $field)) - 1;
            $return['bet_index'] = $bet_index;
            $return['result_index'] = $cur_game['result_index'];
            $return['status'] = 1;
            $return['gameid'] = $game_id;
            echo json_encode($return);

            if ($field != 'goodluck') {
                //更改开奖字段状态为已经开奖
                $this->db->query("UPDATE zy_fruit_game SET status=1 WHERE id=$game_id AND openid='{$openid}'  AND $this->game_sign_sql");

                $result_bs_data['type'] = 'result';
                $result_bs_data['old_gold'] = 0;
                $result_bs_data['cur_gold'] = $return['result_gold'];
                $result_bs_data['trade_gold'] = $result_bs_data['cur_gold'] - $result_bs_data['old_gold'];
                $result_bs_data['real_trade_gold'] = $return['result_gold'] - $bet_on_sum;
                $result_bs_data['addtime'] = time();
                $result_bs_data['gameid'] = $game_id;

                $result_bs_data['ActiveID'] = $this->ActiveID;
                $result_bs_data['ChannelID'] = $this->ChannelID;
                $result_bs_data['RoomID'] = $this->RoomID;
                if ($result_bs_data['cur_gold'] > 0) $result_bs_data['result_status'] = 1;

                //保存金额进出
               $this->save_player_result($result_bs_data, $openid);
                $query = $this->db->insert('zy_fruit_result_bs_log', $result_bs_data);
                if ($query) {
                    //更新玩家表的龙币
                    $this->db->query("UPDATE zy_fruit_player SET score=score-$bet_on_sum WHERE  openid='{$openid}'  AND $this->game_sign_sql");
                }
            } else {

                $result_arr = $this->result_arr();
                $result_rand_id = $this->get_rand_num($game_id);
				//如果再跑到goodluck那就再来一次
				if($result_rand_id == 9 || $result_rand_id == 21){
					 $result_rand_id = $this->get_rand_num($game_id);
				}
                $field = $result_arr[$result_rand_id]['field'];
                $re_data['result_index'] = $result_rand_id;
                $re_data['result_bs'] = $result_arr[$result_rand_id]['bs'];
                $re_data['result_gold'] = intval($cur_game[$field]) * intval($re_data['result_bs']);
                $this->db->update('zy_fruit_game', $re_data, array('id' => $game_id));

            }
        } else {
            $return['status'] = -2;
            echo json_encode($return);
			//添加异常记录
			$content = '获取结果时没查到相关局数';
			$this->common->addErrLog($openid, $this->ChannelID, $this->ActiveID, $this->RoomID, $content);
        }

    }

    /*
     *获取最后一次未退币的比倍数
     * *
     */
    function get_last_result_gold($openid)
    {
        $data['last_gameid'] = 0;
        $data['last_result_gold'] = 0;
        if (empty($openid)) return $data;
        $sql = "SELECT * FROM zy_fruit_game WHERE  openid='{$openid}' AND status=1  AND $this->game_sign_sql ORDER BY id DESC limit 1";
        $cur_game = $this->db->query($sql)->row_array();
        //判断游戏id和提交的openid是否和数据库里一直
        if ($cur_game) {
            $game_id = $cur_game['id'];
            $result_bs_sql = "SELECT * FROM zy_fruit_result_bs_log WHERE gameid=$game_id  AND $this->game_sign_sql ORDER BY id DESC limit 1";
            $cur_result_bs = $this->db->query($result_bs_sql)->row_array();
            if ($cur_result_bs) {
                if ($cur_result_bs['cur_gold'] > 0) {
                    $data['last_gameid'] = $game_id;
                    $data['last_result_gold'] = $cur_result_bs['cur_gold'];
                    return $data;
                } else {
                    return $data;
                }
            } else {
                return $data;
            }
        } else {
            return $data;
        }
    }

    //保存声音开关
    function  set_music()
    {
        $status = $this->input->get('status');
        $openid = $this->input->get('openid');
        $allowMusic = 1;
        if ($status == 'off') $allowMusic = 0;
        $sql = "UPDATE zy_fruit_player SET allowMusic=$allowMusic WHERE openid='{$openid}'  AND $this->game_sign_sql";
        $cur_game = $this->db->query($sql)->row_array();
    }

    //保存金额进出统计
    function save_player_result($data, $openid)
    {

        $return = array();
        //大于0说明赢
        if ($data['real_trade_gold'] > 0) {
            $return = $this->lb_model->recharge_lb($data['real_trade_gold'], 902, $openid, $data['ActiveID'], $data['ChannelID'], $data['RoomID'], $data['gameid']);
        } else {
            $return = $this->lb_model->consume_lb(abs($data['real_trade_gold']), 903, $openid, $data['ActiveID'], $data['ChannelID'], $data['RoomID'], $data['gameid']);
        }

        $result_bs_data['gold'] = $data['real_trade_gold'];
        $result_bs_data['addtime'] = time();
        $result_bs_data['gameid'] = $data['gameid'];
        $result_bs_data['openid'] = $openid;
        $result_bs_data['ActiveID'] = $data['ActiveID'];
        $result_bs_data['ChannelID'] = $data['ChannelID'];
        $result_bs_data['RoomID'] = $data['RoomID'];
		$result_bs_data['type'] = $data['type'];
        $result_bs_data['status'] = $return['returncode'] == '000000' ? 1 : 0;
        $query = $this->db->insert('zy_fruit_player_result', $result_bs_data);
    }

	function check_game_rule($checkType = 'visit'){
		$game_set_start = $this->common->getRule('start_time',$this->ChannelID,$this->ActiveID,$this->RoomID);
		$game_set_end   = $this->common->getRule('end_time',$this->ChannelID,$this->ActiveID,$this->RoomID);
		$game_stop = $this->common->getRule('is_stop',$this->ChannelID,$this->ActiveID,$this->RoomID);
		$game_stop_text   = $this->common->getRule('stop_text',$this->ChannelID,$this->ActiveID,$this->RoomID);
		
		$now_time =  strtotime(date('Y-m-d H:i'));	
		$start_time_text = '07:30';
		$end_time_text = '23:30';
		
		if($game_set_start && $game_set_end){
			$start_time_text =  $game_set_start ;
			$end_time_text   =  $game_set_end ;
		}
		$start_time = strtotime( date( 'Y-m-d ' . $start_time_text ) );
		$end_time   = strtotime( date( 'Y-m-d '. $end_time_text ) );


		//如果在维护时间内则进入维护页面
		if($now_time > $start_time || $now_time < $end_time ){
			$data['msg'] = '游戏维护时间从'.$start_time_text.'到次日'.$end_time_text;
			if($checkType == 'ajax'){
				echo json_encode( array('status'=>-9,'text'=>$data['msg'] ) );
				exit;
			}			
			header('location: index.php?d=fruit&c=fruit&m=repaired&msg='.$data['msg']);	
			exit;			
		}
		if(trim($game_stop) == 1){
			$data['msg'] = $game_stop_text;
			if($checkType == 'ajax'){
				echo json_encode( array('status'=>-9,'text'=>$data['msg'] ) );
				exit;
			}			
			header('location: index.php?d=fruit&c=fruit&m=repaired&msg='.$data['msg']);	
			exit;
		}
		
		
	}
	function repaired(){
		$data['msg'] = $_GET['msg'];
		$this->load->view('tip', $data);
	}

    function result_arr()
    {
        /*
        field 表zy_fruit_game的下注字段bet1：苹果，bet2：橙子，bet3：木瓜，bet4：铃铛，bet5：西瓜，bet6：双星，
        bet7：双七，bet8：BAR
        bs 当前图标的倍数,和背景图对应
        coordinate 当前图标的坐标
        */
        /*	$result_arr = array(  //旧版按APP来排的
                1 => array('field' => 'bet4', 'bs' => 15, 'coordinate' => array(1,1)),
                2 => array('field' => 'bet8', 'bs' => 50, 'coordinate' => array(1,2)),
                3 => array('field' => 'bet8', 'bs' => 120, 'coordinate' => array(1,3)),
                4 => array('field' => 'bet1', 'bs' => 5, 'coordinate' => array(1,4)),
                5 => array('field' => 'bet1', 'bs' => 3, 'coordinate' => array(1,5)),
                6 => array('field' => 'bet3', 'bs' => 10, 'coordinate' => array(1,6)),

                7 => array('field' => 'bet5', 'bs' => 20, 'coordinate' => array(2,1)),
                8 => array('field' => 'bet5', 'bs' => 3, 'coordinate' => array(2,2)),
                9 => array('field' => 'goodluck', 'bs' => 0, 'coordinate' => array(2,3)),
                10 => array('field' => 'bet1', 'bs' => 5, 'coordinate' => array(2,4)),
                11 => array('field' => 'bet2', 'bs' => 3, 'coordinate' => array(2,5)),
                12 => array('field' => 'bet2', 'bs' => 10, 'coordinate' => array(2,6)),

                13 => array('field' => 'bet4', 'bs' => 15, 'coordinate' => array(3,1)),
                14 => array('field' => 'bet7', 'bs' => 3, 'coordinate' => array(3,2)),
                15 => array('field' => 'bet7', 'bs' => 40, 'coordinate' => array(3,3)),
                16 => array('field' => 'bet1', 'bs' => 5, 'coordinate' => array(3,4)),
                17 => array('field' => 'bet3', 'bs' => 3, 'coordinate' => array(3,5)),
                18 => array('field' => 'bet3', 'bs' => 10, 'coordinate' => array(3,6)),

                19 => array('field' => 'bet6', 'bs' => 30, 'coordinate' => array(4,1)),
                20 => array('field' => 'bet6', 'bs' => 3, 'coordinate' => array(4,2)),
                21 => array('field' => 'goodluck', 'bs' => 0, 'coordinate' => array(4,3)),
                22 => array('field' => 'bet1', 'bs' => 5, 'coordinate' => array(4,4)),
                23 => array('field' => 'bet4', 'bs' => 3, 'coordinate' => array(4,5)),
                24 => array('field' => 'bet2', 'bs' => 10, 'coordinate' => array(4,6)),
            );*/

        $result_arr = array(
            1 => array('field' => 'bet4', 'bs' => 20, 'coordinate' => array(1, 1)),
            2 => array('field' => 'bet8', 'bs' => 40, 'coordinate' => array(1, 2)),
            3 => array('field' => 'bet8', 'bs' => 20, 'coordinate' => array(1, 3)),
            4 => array('field' => 'bet1', 'bs' => 5, 'coordinate' => array(1, 4)),
            5 => array('field' => 'bet1', 'bs' => 2, 'coordinate' => array(1, 5)),
            6 => array('field' => 'bet3', 'bs' => 15, 'coordinate' => array(1, 6)),

            7 => array('field' => 'bet5', 'bs' => 25, 'coordinate' => array(2, 1)),
            8 => array('field' => 'bet5', 'bs' => 2, 'coordinate' => array(2, 2)),
            9 => array('field' => 'goodluck', 'bs' => 0, 'coordinate' => array(2, 3)),
            10 => array('field' => 'bet1', 'bs' => 5, 'coordinate' => array(2, 4)),
            11 => array('field' => 'bet2', 'bs' => 2, 'coordinate' => array(2, 5)),
            12 => array('field' => 'bet2', 'bs' => 10, 'coordinate' => array(2, 6)),

            13 => array('field' => 'bet4', 'bs' => 20, 'coordinate' => array(3, 1)),
            14 => array('field' => 'bet7', 'bs' => 2, 'coordinate' => array(3, 2)),
            15 => array('field' => 'bet7', 'bs' => 35, 'coordinate' => array(3, 3)),
            16 => array('field' => 'bet1', 'bs' => 5, 'coordinate' => array(3, 4)),
            17 => array('field' => 'bet3', 'bs' => 2, 'coordinate' => array(3, 5)),
            18 => array('field' => 'bet3', 'bs' => 15, 'coordinate' => array(3, 6)),

            19 => array('field' => 'bet6', 'bs' => 30, 'coordinate' => array(4, 1)),
            20 => array('field' => 'bet6', 'bs' => 2, 'coordinate' => array(4, 2)),
            21 => array('field' => 'goodluck', 'bs' => 0, 'coordinate' => array(4, 3)),
            22 => array('field' => 'bet1', 'bs' => 5, 'coordinate' => array(4, 4)),
            23 => array('field' => 'bet4', 'bs' => 2, 'coordinate' => array(4, 5)),
            24 => array('field' => 'bet2', 'bs' => 10, 'coordinate' => array(4, 6)),
        );

        return $result_arr;

    }

    /**
     * 生成缩略图函数  剪切
     *
     * @param $imgurl 图片路径
     * @param $width 缩略图宽度
     * @param $height 缩略图高度
     * @return string 生成图片的路径 类似：./uploads/201203/img_100_80.jpg
     */
    function thumb($imgurl, $width = 100, $height = 100)
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
    function getImg($url = "", $filename = "")
    {
        //去除URL连接上面可能的引号
        //$url = preg_replace( '/(?:^['"]+|['"/]+$)/', '', $url );
		if(!strstr($url,"wx.qlogo.cn"))  return '';
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
        $this->thumb($filename, 84, 84);
        return $filename;
    }

    function get_rand_num($game_id)
    {

        $sql = "SELECT * FROM zy_fruit_game WHERE id=$game_id ";
        $cur_game = $this->db->query($sql)->row_array();
        //判断游戏id和提交的openid是否和数据库里一直
        $bet_field_sum = 0;//下注字段的总数，即各个水果下注的总数
        $bet_on_sum = 0;//下注龙币的总数，即各个水果下注数的总数
        if ($cur_game) {
            for ($i = 1; $i < 9; $i++) {
                if (intval($cur_game['bet' . $i]) > 0) $bet_field_sum++;
                $bet_on_sum += $cur_game['bet' . $i];
            }
        }
        $result_log = [];
        for ($i = 1; $i < 25; $i++) {
            $result_arr = $this->result_arr();
            $result_rand_id = $i;
            $field = $result_arr[$result_rand_id]['field'];
            $re_data['result_index'] = $result_rand_id;
            $re_data['result_bs'] = $result_arr[$result_rand_id]['bs'];
            $re_data['result_gold'] = intval($cur_game[$field]) * intval($re_data['result_bs']) - $bet_on_sum;
            $result_log[$i] = $re_data['result_gold'];
        }
        arsort($result_log);
        $data['result_log'] = array2string($result_log);
        $this->db->update("zy_fruit_game", $data, array("id" => $game_id));


        $grade_arr = array(
            1 => array('index_arr' => array(5, 8, 11, 14, 17, 20, 23), 'v' => 67),
            2 => array('index_arr' => array(4, 10, 16, 22), 'v' => 8),
            3 => array('index_arr' => array(12, 24), 'v' => 5),
            4 => array('index_arr' => array(6, 18), 'v' => 5),
            5 => array('index_arr' => array(1, 3, 13), 'v' => 5),
            6 => array('index_arr' => array(7), 'v' => 3),
            7 => array('index_arr' => array(19), 'v' => 1),
            8 => array('index_arr' => array(15), 'v' => 1),
            9 => array('index_arr' => array(2), 'v' => 1),
            10 => array('index_arr' => array(9, 21), 'v' => 3)
        );
        $arr = [];
        foreach ($grade_arr as $key => $val) {
            $arr[$key] = $val['v'];
        }
        $index = $this->get_rand($arr);
        $index_arr = $grade_arr[$index]['index_arr'];
        $rand_num = rand(0, count($index_arr) - 1);
        $prize_index = $index_arr[$rand_num];
        return $prize_index;
    }

    function check_seesion_id($openid, $score)
    {
        $isexit = $this->db->query("select session_id ,score from zy_fruit_player where openID='" . $openid . "' ")->row_array();

        if ($isexit['score'] > ($score-1) && $isexit['session_id'] == $_COOKIE['PHPSESSID']) {
            return true;
        } else {
            return false;
        }
    }

    //检查session_id和$_COOKIE['PHPSESSID'] 是否一致
    function check_id()
    {
        $openid = $_GET['openid'];
        if (empty($openid)) {
            echo json_encode(array('status' => -1));
            exit;
        }
        //判断是否有session
        $isexit = $this->db->query("select session_id,openID  from zy_fruit_player where openID='" . $openid . "' ")->row_array();
        if (!$isexit) {
            echo json_encode(array('status' => -1));
            exit;
        }
        if ($isexit['session_id'] != $_COOKIE['PHPSESSID']) {
            $this->db->query("update zy_fruit_player set session_id = '" . $_COOKIE['PHPSESSID'] . "' where openID= '" . $openid . "' ");
            exit;
        }
        echo json_encode(array('status' => 0));
    }

    function get_ranks()
    {
        // 2->  5,8,11,14,17,20,23  =>9  ==63
        // 5->  4,10,16,22          =>4   ==16
        // 10-> 12,24               =>2   ==4
        // 15-> 6,18                =>2   ==4
        // 20-> 1,3,13,             =>2   ==6
        // 25-> 7                   =>1   ==1
        // 30-> 19                  =>1   ==1
        // 35-> 15                  =>1   ==1
        // 40-> 2                   =>1   ==1
        // gl-> 9,21                =>1   ==1
        $grade_arr = array(
            1 => array('index_arr' => array(5, 8, 11, 14, 17, 20, 23), 'v' => 67),
            2 => array('index_arr' => array(4, 10, 16, 22), 'v' => 8),
            3 => array('index_arr' => array(12, 24), 'v' => 5),
            4 => array('index_arr' => array(6, 18), 'v' => 5),
            5 => array('index_arr' => array(1, 3, 13), 'v' => 5),
            6 => array('index_arr' => array(7), 'v' => 3),
            7 => array('index_arr' => array(19), 'v' => 1),
            8 => array('index_arr' => array(15), 'v' => 1),
            9 => array('index_arr' => array(2), 'v' => 1),
            10 => array('index_arr' => array(9, 21), 'v' => 3)
        );
        $prize_arr = array(
            1 => array('name' => '石榴', 'field' => 'bet4', 'bs' => 20, 'coordinate' => array(1, 1), 'v' => 3),
            2 => array('name' => 'BAR', 'field' => 'bet8', 'bs' => 40, 'coordinate' => array(1, 2), 'v' => 1),
            3 => array('name' => '小BAR', 'field' => 'bet8', 'bs' => 20, 'coordinate' => array(1, 3), 'v' => 3),
            4 => array('name' => '苹果', 'field' => 'bet1', 'bs' => 5, 'coordinate' => array(1, 4), 'v' => 4),
            5 => array('name' => '小苹果', 'field' => 'bet1', 'bs' => 2, 'coordinate' => array(1, 5), 'v' => 8),
            6 => array('name' => '橙子', 'field' => 'bet3', 'bs' => 15, 'coordinate' => array(1, 6), 'v' => 3),

            7 => array('name' => '西瓜', 'field' => 'bet5', 'bs' => 25, 'coordinate' => array(2, 1), 'v' => 2),
            8 => array('name' => '小西瓜', 'field' => 'bet5', 'bs' => 2, 'coordinate' => array(2, 2), 'v' => 8),
            9 => array('name' => 'goodluck', 'field' => 'goodluck', 'bs' => 0, 'coordinate' => array(2, 3), 'v' => 1),
            10 => array('name' => '苹果', 'field' => 'bet1', 'bs' => 5, 'coordinate' => array(2, 4), 'v' => 4),
            11 => array('name' => '小柠檬', 'field' => 'bet2', 'bs' => 2, 'coordinate' => array(2, 5), 'v' => 8),
            12 => array('field' => '柠檬', 'bs' => 10, 'coordinate' => array(2, 6), 'v' => 3),

            13 => array('name' => '石榴', 'field' => 'bet4', 'bs' => 20, 'coordinate' => array(3, 1), 'v' => 3),
            14 => array('name' => '小双7', 'field' => 'bet7', 'bs' => 2, 'coordinate' => array(3, 2), 'v' => 8),
            15 => array('name' => '双7', 'field' => 'bet7', 'bs' => 35, 'coordinate' => array(3, 3), 'v' => 1),
            16 => array('name' => '苹果', 'field' => 'bet1', 'bs' => 5, 'coordinate' => array(3, 4), 'v' => 4),
            17 => array('name' => '小橙子', 'field' => 'bet3', 'bs' => 2, 'coordinate' => array(3, 5), 'v' => 8),
            18 => array('name' => '橙子', 'field' => 'bet3', 'bs' => 15, 'coordinate' => array(3, 6), 'v' => 3),

            19 => array('name' => '樱桃', 'field' => 'bet6', 'bs' => 30, 'coordinate' => array(4, 1), 'v' => 2),
            20 => array('name' => '小樱桃', 'field' => 'bet6', 'bs' => 2, 'coordinate' => array(4, 2), 'v' => 8),
            21 => array('name' => 'goodluck', 'field' => 'goodluck', 'bs' => 0, 'coordinate' => array(4, 3), 'v' => 1),
            22 => array('name' => '苹果', 'field' => 'bet1', 'bs' => 5, 'coordinate' => array(4, 4), 'v' => 4),
            23 => array('name' => '小石榴', 'field' => 'bet4', 'bs' => 2, 'coordinate' => array(4, 5), 'v' => 8),
            24 => array('name' => '柠檬', 'field' => 'bet2', 'bs' => 10, 'coordinate' => array(4, 6), 'v' => 3),

        );
        $sum = 0;
        foreach ($grade_arr as $key => $val) {
            $arr[$key] = $val['v'];
            $sum += $val['v'];
        }


    }

    function get_rand($proArr)
    {
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


}

?>