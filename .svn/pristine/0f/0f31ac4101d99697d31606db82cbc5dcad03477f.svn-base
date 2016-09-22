//连接websocket后端服务器
var socket = io.connect('ws://192.168.1.178:'+SocketPort);//h5game.gxziyun.com
var SCZ = {};//赛场主的信息
var sumYD={sum:0, dog2:0, dog3:0, dog4:0, dog5:0  }; //总的下注烟豆
var myselfYD={sum:0, dog2:0, dog3:0, dog4:0, dog5:0,  };//个人下注烟豆

var thisTimesgold = 0;
var CurrOnlineCount = 0;
var SCZ_ZG_GOLD = '20000';//申请赛场主资格最低金币

var allowMusic = audioSetting.allowMusic;
var allowEffects = audioSetting.allowEffects;
var Font = "楷体";
var scene_bg = 'runbg.jpg';


cc.game.onStart = function(){
    if(!cc.sys.isNative && document.getElementById("cocosLoading")) //If referenced loading.js, please remove it
        document.body.removeChild(document.getElementById("cocosLoading"));

    var designSize = cc.size(480,960);
    var screenSize = cc.view.getFrameSize();

   /* if(!cc.sys.isNative && screenSize.height < 800){
        designSize = cc.size(480,960);*/
       cc.loader.resPath = "static/gameroom/racedog/res/Normal";
    /*}else{
     cc.loader.resPath = "static/raceDog/res/HD";
    }*/
    cc.log(cc.director.getWinSize());
    cc.view.setDesignResolutionSize(designSize.width, designSize.height, cc.ResolutionPolicy.FIXED_WIDTH);

	cc.view.enableAutoFullScreen(true);
    cc.view.adjustViewPort(true);
	cc.director.setDisplayStats(false);//去掉左下角的帧数
	cc.view.resizeWithBrowserSize(true);//设置canvas大小是否随浏览器的大小改变而自动调整.

    //load resources
    cc.LoaderScene.preload(g_resources, function () {
        //背景音乐
        if(allowMusic){
          if (!cc.audioEngine.isMusicPlaying()) {
              cc.audioEngine.playMusic(res.s_bg_music_mp3, true);
          }
          cc.audioEngine.setMusicVolume(0.5);
        }



        //监听服务端发送过来的开始赛跑命令
        socket.on('startRun', function(o){
              cc.log("mainstartRun:" +o);

              
              if(allowMusic){
                cc.audioEngine.stopMusic();
                  if (!cc.audioEngine.isMusicPlaying()) {
                      cc.audioEngine.playMusic(res.s_bg_music_run_mp3, true);
                  }
              }
                
			  if(loginInfo.is_frist_time == 'no'){
				  cc.director.runScene(new PlayScene(o));
			  }		

			  if(loginInfo.is_frist_time == 'yes' && loginInfo.is_read_rule == true){
				  cc.director.runScene(new PlayScene(o));
			  }	

              
        });

        //监听服务端发送过来的停止游戏命令
        socket.on('repaired', function(o){
            window.location.href="index.php?c=raceDog&m=repaired";
        });

        //监听服务端发送过来的新的一局命令
        socket.on('newGame', function(o){
            //  cc.log("mainnewGame:" +o);
            //初始化
             sumYD={sum:0, dog2:0, dog3:0, dog4:0, dog5:0  }; //总的下注烟豆
             myselfYD={sum:0, dog2:0, dog3:0, dog4:0, dog5:0,  };//个人下注烟豆
			 if(loginInfo.is_frist_time == 'no'){
				cc.director.runScene(new ChooseScene(o,myselfYD));
			 }
			  if(loginInfo.is_frist_time == 'yes' && loginInfo.is_read_rule == true){
				  cc.director.runScene(new ChooseScene(o,myselfYD));
			  }

        });

		if(loginInfo.is_frist_time == 'yes'){
			cc.director.runScene(new HelpScene());
		}else{
            var send_obj = [{dog:2,gold:10},{dog:3,gold:0},{dog:4,gold:10},{dog:5,gold:100}];
			cc.director.runScene(new WaitingScene());
		}
        
       // cc.director.pushScene(new PlayScene());

    }, this);
};
cc.game.run();