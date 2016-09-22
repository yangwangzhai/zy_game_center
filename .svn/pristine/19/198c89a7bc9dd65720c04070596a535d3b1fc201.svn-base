// JavaScript Document
var layers = {};
var PlayLayer = cc.Layer.extend({
    isLeft:null,  
    isRight:null,
    dog1:null,
    dog2:null,
    dog3:null,
    dog4:null,
	dog5:null,
	dog6:null,
    alldogs:null,
    cameraStatue:null,  
    mapLength:null,  
    heroWidth:null,  
    heroSpeed:50,  
    cameraSpeed:50,
	closeBt:null,
    followAction:null,
	redline:null,
    stopFollowAction : false,
    ranking : 0,
	countRanking : 0,
    dogspeeds : null,
    resultText:'',
    bianhaoArray : null,
    czRanking:0,//场主排名
    longtime:null,
    longtext:null,
    longseconds:15,
    isOver: false,
    mapsize:null,
    ds:0,
    setting_status : false,
    musicBTN : null,
    isRunning : false,
    dog1_js_action:null,
    dog2_js_action:null,
    dog3_js_action:null,
    dog4_js_action:null,
    dog5_js_action:null,
    dog_js_actions:null,
    all_ranking:null,
    ctor:function () {
        this._super();
        var self = this;
        var size = cc.winSize;  
        this.isLeft = false;  
        this.isRight = false;  
        this.cameraStatue = 0;
	    this.bianhaoArray = new Array();
	  	  // add "Helloworld" splash screen"
        this.sprite = new cc.Sprite(scene_bg);
        this.sprite.setAnchorPoint(0, 1);
        this.sprite.setPosition(0, size.height);
        this.sprite.setScale(0.65);
        this.sprite.setTag(10);
		//this.sprite.setRotation(270);
        this.mapsize = this.sprite.getContentSize();
        this.addChild(this.sprite, 0);

		this.redline = new cc.Sprite(res.s_RedLine);
		//this.redline.setAnchorPoint(0, 1);
        this.redline.setRotation(90);
		this.redline.setPosition(size.width/2,size.height-(this.mapsize.height*0.65)+220);
        this.redline.setVisible(false);
		this.addChild(this.redline);

        var ssColor = cc.color(249,208,84);//深色
        var bsColor = cc.color(255,255,255);//白色

        //加载狗狗动画资源
        cc.spriteFrameCache.addSpriteFrames(res.s_dog1_plist);
        cc.spriteFrameCache.addSpriteFrames(res.s_dog2_plist);
        cc.spriteFrameCache.addSpriteFrames(res.s_dog3_plist);
        cc.spriteFrameCache.addSpriteFrames(res.s_dog4_plist);
        cc.spriteFrameCache.addSpriteFrames(res.s_dog5_plist);

        //申请赛场主按钮
        var sq_btn = new cc.MenuItemImage(
            res.s_sqbtn,
            res.s_sqbtn,
            res.s_sqbtn_off,
            function () {
               // cc.log("ApplyCZ  is clicked!");
                if(wx_info.total_gold < SCZ_ZG_GOLD){
                    var tipUI = new TipUI("烟豆少于"+unit(SCZ_ZG_GOLD)+"不能申请赛场主！");
                    this.addChild(tipUI,100);
                    return;
                }
                //cc.log({openid:wx_info.openid,nickname:wx_info.nickname});
                //socket.emit('ApplyCZ_run', {openid:wx_info.openid,nickname:wx_info.nickname});
            }, this);
        sq_btn.attr({
            x: size.width-30,
            y: size.height-40,
            scale:0.6
        });
        sq_btn.setEnabled(false);
        var menu = new cc.Menu(sq_btn);
        menu.x = 0;
        menu.y = 0;
        this.addChild(menu, 1);

        //当前赛场主
        //字体描边
        var fontDefGreenStroke = new cc.FontDefinition();
        fontDefGreenStroke.fontName = Font;
        fontDefGreenStroke.fontSize = 16;
        fontDefGreenStroke.textAlign = cc.TEXT_ALIGNMENT_CENTER;
        fontDefGreenStroke.verticalAlign = cc.VERTICAL_TEXT_ALIGNMENT_TOP;
        fontDefGreenStroke.fillStyle = cc.color(50,209,6);
        //fontDefGreenStroke.boundingWidth = size.width;
        //fontDefGreenStroke.boundingHeight = size.height;
        // stroke
        fontDefGreenStroke.strokeEnabled = true;
        fontDefGreenStroke.strokeStyle = cc.color(6,20,1);

        var sczLable = new cc.LabelTTF("当前狗庄: ", fontDefGreenStroke);
        sczLable.attr({
            x: size.width-20,
            y: size.height-80,
            anchorX:0
        });
        sczLable.setRotation(90);
        //sczLable.setColor(cc.color(255,203,25));
        this.addChild(sczLable);

        var sczname = new cc.LabelTTF(SCZ.SCZName, fontDefGreenStroke);
        sczname.attr({
            x: size.width-20,
            y: size.height-155,
            anchorX:0
        });
        sczname.setRotation(90);
        //sczname.setColor(cc.color(255,255,255));
        this.addChild(sczname);

        //累计财富
        var caifuImg = new cc.Sprite(res.s_coin);
        caifuImg.attr({
            x:size.width-50,
            y:size.height-88,
            anchorX:0,
            scale:0.7
        });
        this.addChild(caifuImg);

        //字体描边
        var fontDefYellowStroke = new cc.FontDefinition();
        fontDefYellowStroke.fontName = Font;
        fontDefYellowStroke.fontSize = 14;
        fontDefYellowStroke.textAlign = cc.TEXT_ALIGNMENT_CENTER;
        fontDefYellowStroke.verticalAlign = cc.VERTICAL_TEXT_ALIGNMENT_TOP;
        fontDefYellowStroke.fillStyle = cc.color(253,197,2);
        //fontDefYellowStroke.boundingWidth = size.width;
        //fontDefYellowStroke.boundingHeight = size.height;
        // stroke
        fontDefYellowStroke.strokeEnabled = true;
        fontDefYellowStroke.strokeStyle = cc.color(58,28,0);

        var caifuLable = new cc.LabelTTF("场主烟豆:", fontDefYellowStroke);
        caifuLable.attr({
            x: size.width-40,
            y: size.height-100,
            anchorX:0
        });
        caifuLable.setRotation(90);
        //caifuLable.setColor(cc.color(255,203,25));
        this.addChild(caifuLable);

        var caifunum = new cc.LabelTTF(SCZ.SCZGold, fontDefYellowStroke);
        caifunum.attr({
            x: size.width-40,
            y: size.height-165,
            anchorX:0
        });
        caifunum.setTag(165);
        caifunum.setRotation(90);
        //caifunum.setColor(cc.color(255,255,255));
        this.addChild(caifunum);

        //按钮旁边的时间
        var timebox = new cc.Sprite(res.s_timebox);
        timebox.attr({
            x: size.width-20,
            y: size.height/2,
            scale:0.7
        });

        //绿字黑边字体描边，时间
        var fontDefGreenBlackStroke = new cc.FontDefinition();
        fontDefGreenBlackStroke.fontName = Font;
        fontDefGreenBlackStroke.fontSize = 32;
        fontDefGreenBlackStroke.textAlign = cc.TEXT_ALIGNMENT_CENTER;
        fontDefGreenBlackStroke.verticalAlign = cc.VERTICAL_TEXT_ALIGNMENT_TOP;
        fontDefGreenBlackStroke.fillStyle = cc.color(255,229,13);

        // stroke
        fontDefGreenBlackStroke.strokeEnabled = true;
        fontDefGreenBlackStroke.strokeStyle = cc.color(0,0,0);

        //绿字黑边字体描边，文字
        var fontDefGreenBlackStroke1 = new cc.FontDefinition();
        fontDefGreenBlackStroke1.fontName = Font;
        fontDefGreenBlackStroke1.fontSize = 28;
        fontDefGreenBlackStroke1.textAlign = cc.TEXT_ALIGNMENT_CENTER;
        fontDefGreenBlackStroke1.verticalAlign = cc.VERTICAL_TEXT_ALIGNMENT_TOP;
        fontDefGreenBlackStroke1.fillStyle = cc.color(222,198,13);//255,229,13

        // stroke
        fontDefGreenBlackStroke1.strokeEnabled = true;
        fontDefGreenBlackStroke1.strokeStyle = cc.color(0,0,0);

        this.longtime = new cc.LabelTTF("15", fontDefGreenBlackStroke);
        this.longtime.attr({
            x: timebox.width/2-3,
            y: timebox.height/2-55
        });
        this.longtime.setRotation(90);
        timebox.addChild( this.longtime,5);

        this.longtext = new cc.LabelTTF("比赛时间", fontDefGreenBlackStroke1);
        this.longtext.attr({
            x: timebox.width/2-3,
            y: timebox.height/2+20
        });
        this.longtext.setRotation(90);
        timebox.addChild( this.longtext,5);

        this.addChild(timebox);

        //场主资格说明
        /*//字体描边
        var fontDefBlueStroke = new cc.FontDefinition();
        fontDefBlueStroke.fontName = Font;
        fontDefBlueStroke.fontSize = 14;
        fontDefBlueStroke.textAlign = cc.TEXT_ALIGNMENT_CENTER;
        fontDefBlueStroke.verticalAlign = cc.VERTICAL_TEXT_ALIGNMENT_TOP;
        fontDefBlueStroke.fillStyle = cc.color(253,55,2);
        //fontDefBlueStroke.boundingWidth = size.width;
        //fontDefBlueStroke.boundingHeight = size.height;
        // stroke
        fontDefBlueStroke.strokeEnabled = true;
        fontDefBlueStroke.strokeStyle = cc.color(28,8,1);*/

        var CZTips = new cc.LabelTTF("烟豆不足"+ unit(SCZ_ZG_GOLD) +",不能申请赛场主", fontDefYellowStroke);
        CZTips.attr({
            x: size.width-45,
            y: 200
        });
        CZTips.setRotation(90);
        //CZTips.setColor(cc.color(255,203,25));
        this.addChild(CZTips,1);
		
        //黄字黑边字体描边
        var fontDefYellowBlackStroke = new cc.FontDefinition();
        fontDefYellowBlackStroke.fontName = Font;
        fontDefYellowBlackStroke.fontSize = 16;
        fontDefYellowBlackStroke.textAlign = cc.TEXT_ALIGNMENT_CENTER;
        fontDefYellowBlackStroke.verticalAlign = cc.VERTICAL_TEXT_ALIGNMENT_TOP;
        fontDefYellowBlackStroke.fillStyle = cc.color(255,229,13);

        // stroke
        fontDefYellowBlackStroke.strokeEnabled = true;
        fontDefYellowBlackStroke.strokeStyle = cc.color(0,0,0);
		//在线人数
        var onlineCount = new cc.LabelTTF("在线人数:"+CurrOnlineCount, fontDefYellowBlackStroke);
        onlineCount.attr({
            x: size.width-20,
            y: 200
        });
        onlineCount.setRotation(90);
        //onlineCount.setColor(cc.color(255,203,25));
        this.addChild(onlineCount);


        //声音图标
        this.musicBTN = new cc.Sprite((!allowMusic && !allowEffects)?res.s_musicbtn_off:res.s_musicbtn);
        this.musicBTN.attr({
            x: size.width-30,
            y: 80,
            scale:0.8
        });
        this.addChild(this.musicBTN);

        cc.eventManager.addListener({
            event: cc.EventListener.TOUCH_ONE_BY_ONE,
            onTouchBegan: function (touch, event) {
                var target = event.getCurrentTarget();
                // 获取当前触摸点相对于按钮所在的坐标
                var locationInNode = target.convertToNodeSpace(touch.getLocation());
                var s = target.getContentSize();
                var rect = cc.rect(0, 0, s.width, s.height);
                if (cc.rectContainsPoint(rect, locationInNode)) {       // 判断触摸点是否在按钮范围内

                    if(!allowEffects && !allowMusic){
                        target.initWithFile(res.s_musicbtn);
                        allowEffects = true;
                        allowMusic = true;
                        socket.emit('getGameTime');
                        socket.on('getGameTime',function(obj){
                            
                            if(obj.time > 30 && obj.time < 45){
                                if(!cc.audioEngine.isMusicPlaying()){
                                    cc.audioEngine.playMusic(res.s_bg_music_run_mp3, true);
                                }
                                
                            }else{
                                if(!cc.audioEngine.isMusicPlaying()){
                                    cc.audioEngine.playMusic(res.s_bg_music_mp3, true);
                                }
                            }
                        });
                        
                    }else{
                        target.initWithFile(res.s_musicbtn_off);
                        allowMusic = false;
                        allowEffects = false;
                        cc.audioEngine.pauseAllEffects();
                        cc.audioEngine.stopMusic(true);
                    }
                    socket.emit("audioSetting",{openid:wx_info.openid,type:'All',status:allowMusic});
                    return true;
                }
                return false;

            }
        }, this.musicBTN);
        //设置图标

        var settingBTN = new cc.MenuItemImage(
            res.s_settingbtn,
            res.s_settingbtn,
            function(){
                if(!self.setting_status){
                    sceneBTN.setVisible(true);
                    setting_BTN.setVisible(true);
                    CZTips.setVisible(false);
					onlineCount.setVisible(false);
                    self.setting_status = true;
                }else{
                    sceneBTN.setVisible(false);
                    setting_BTN.setVisible(false);
                    CZTips.setVisible(true);
					onlineCount.setVisible(true);
                    self.setting_status = false;
                }
            }
        );
        settingBTN.attr({
            x: size.width-30,
            y: 30,
            scale:0.8
        });

        //场景切换图标
        var sceneBTN = new cc.MenuItemImage(
            res.s_scene_btn,
            res.s_scene_btn,
            function(){
                var SceneUI = new SceneUIScene();
                self.addChild(SceneUI,50);
            }
        );
        sceneBTN.attr({
            x: size.width-30,
            y: 210,
            scale:0.7
        });
        sceneBTN.setVisible(false);

        //系统设置图标
        var setting_BTN = new cc.MenuItemImage(
            res.s_setting_btn,
            res.s_setting_btn,
            function(){
                var SettingUI = new SettingUIScene();
                self.addChild(SettingUI,50);
            }
        );
        setting_BTN.attr({
            x: size.width-30,
            y: 140,
            scale:0.7
        });
        setting_BTN.setVisible(false);
        var menuSetting = new cc.Menu(settingBTN,sceneBTN,setting_BTN);
        menuSetting.x = 0;
        menuSetting.y = 0;
        this.addChild(menuSetting, 1);


        this.alldogs = new Array(this.dog1, this.dog2,this.dog3, this.dog4, this.dog5);
        var widths = [0.25,0.41,0.56,0.70,0.86];
        var i = 5;//初始化狗狗编号
        for(var key in this.alldogs) {

            var width = size.width * widths[key];
          //  cc.log(width);
            var height = size.height - 100;
            this.alldogs[key] =  new cc.Sprite("dog"+i+"_0.png");
            this.alldogs[key].attr({
                bianhao:i,
                isOver:0,
                scale: 0.6,
                x: width ,
                y: height ,
                anchorX:0.5,
                anchorY:0
            });
            this.addChild( this.alldogs[key], 1);

            switch(i)
            {
                case 1:
                    this.dog1 = this.alldogs[key];
                    break;
                case 2:
                    this.dog2 = this.alldogs[key];
                    break;
                case 3:
                    this.dog3 = this.alldogs[key];
                    break;
                case 4:
                    this.dog4 = this.alldogs[key];
                    break;
                case 5:
                    this.dog5 = this.alldogs[key];
                    break;
                default:

            }
            i--;
        }



        //个人信息
        //个人信息背景
        var profile_bg = new cc.Sprite(res.s_profile_bg);
        profile_bg.attr({
            x:0,
            y:size.height-3,
            scale: 0.69
        });
        profile_bg.setAnchorPoint(0, 1);
        profile_bg.setTag(162);
        //个人头像
        var myavatar = new cc.Sprite(res.s_myavatar);
        myavatar.attr({
            x:profile_bg.width/2,
            y:profile_bg.height-myavatar.height/2-10
        });

        //加载微信头像
        cc.loader.loadImg(wx_info.headimgurl, {isCrossOrigin : false }, function(err, img)
        {   //img.scale = 1;
            //img.height = '10%';
            var sprite = new cc.Sprite(img);
              sprite.x = this.width / 2 ;
              sprite.y = this.height / 2 ;
            //sprite.scale = 0.1;
            //sprite.width = 10;
            //sprite.height = 10;
            sprite.setRotation(90);
            myavatar.addChild(sprite);

        }.bind(myavatar));

        /* cc.textureCache.addImageAsync("http://www.52ij.com/uploads/allimg/160317/1110104P8-4.jpg", function(texture)
         {
         var myimg = new cc.Sprite(texture);
         myimg.x = myavatar.width / 2;
         myimg.y = myavatar.height / 2;
         myavatar.addChild(myimg);
         }, this);*/



        /*var url = "http://www.52ij.com/uploads/allimg/160317/1110104P8-4.jpg";
         cc.loader.loadImg(url, {isCrossOrigin : false}, function(err,img){
         /!*var texture2d = new cc.Texture2D();
         texture2d.initWithElement(img);
         texture2d.handleLoadedTexture();
         cc.log(texture2d);*!/
         var myimg = new cc.Sprite(img);
         myavatar.addChild(myimg);
         myimg.x = myavatar.width / 2;
         myimg.y = myavatar.height / 2;
         });*/

        profile_bg.addChild(myavatar);

        //用户名
        var myname = new cc.LabelTTF(wx_info.nickname,Font,20);
        myname.attr({
            x:profile_bg.width/2+25,
            y:profile_bg.height/2+55,
            anchorX:0,
            anchorY:0.5
        });
        myname.setRotation(90);
        myname.setColor(cc.color(0,0,0));
        profile_bg.addChild(myname);

        /*//我的金币图标
        var mygold = new cc.Sprite(res.s_mygold);
        mygold.attr({
            x:profile_bg.width/2-5,
            y:profile_bg.height-myavatar.height-mygold.height-10
        });
        profile_bg.addChild(mygold);*/

        //白字黑边字体描边
        var fontDefBlackStroke = new cc.FontDefinition();
        fontDefBlackStroke.fontName = Font;
        fontDefBlackStroke.fontSize = 20;
        fontDefBlackStroke.textAlign = cc.TEXT_ALIGNMENT_CENTER;
        fontDefBlackStroke.verticalAlign = cc.VERTICAL_TEXT_ALIGNMENT_TOP;
        fontDefBlackStroke.fillStyle = cc.color(255,255,255);
        //fontDefBlackStroke.boundingWidth = size.width;
        //fontDefBlackStroke.boundingHeight = size.height;
        // stroke
        fontDefBlackStroke.strokeEnabled = true;
        fontDefBlackStroke.strokeStyle = cc.color(0,0,0);

        //我的金币数量
        var mygoldLable = new cc.LabelTTF("我的烟豆:"+wx_info.total_gold,fontDefBlackStroke);
        mygoldLable.attr({
            x:profile_bg.width/2+10,
            y:profile_bg.height/2+55,
            anchorX:0,
            anchorY:1
        });
        mygoldLable.setTag(164);
        mygoldLable.setRotation(90);
        //mygoldLable.setColor(cc.color(220,220,220));
        profile_bg.addChild(mygoldLable);

        //本次金币数量
        var thisgoldLable = new cc.LabelTTF("本次烟豆:"+thisTimesgold,fontDefBlackStroke);
        thisgoldLable.attr({
            x:profile_bg.width/2-15,
            y:profile_bg.height/2+55,
            anchorX:0,
            anchorY:1
        });
        thisgoldLable.setTag(163);
        thisgoldLable.setRotation(90);
        //thisgoldLable.setColor(cc.color(220,220,220));
        profile_bg.addChild(thisgoldLable);

        

        this.addChild(profile_bg);



        //监听服务端发送过来的开始赛跑命令
        socket.on('startRun', function(o){
         //   cc.log(o);
            cc.director.runScene(new PlayScene(o));
        });

        //监听服务端发送过来的开始结算命令
        socket.on('statement', function(o){
         //   cc.log(o);
         //   cc.director.runScene(new XiazhuScene(o));
        });

        //监听服务端发送过来的新的一局命令
        socket.on('newGame', function(o){
         //   cc.log(o);
          //  cc.director.runScene(new ChooseScene(o));
        });
		
		//监听现在人数事件
        socket.on('onlineCount', function(o){
            onlineCount.setString("在线人数:"+o.onlineCount);
            CurrOnlineCount = o.onlineCount;

            
        });

         cc.eventManager.addListener({
         event: cc.EventListener.TOUCH_ONE_BY_ONE,
         onTouchBegan: function (touch, event) {
         var target = event.getCurrentTarget();
         //   if (!target.activate) return;
         // 获取当前触摸点相对于按钮所在的坐标
         var locationInNode = target.convertToNodeSpace(touch.getLocation());
         var s = target.getContentSize();
         var rect = cc.rect(0, 0, s.width, s.height);
         if (cc.rectContainsPoint(rect, locationInNode)) {       // 判断触摸点是否在按钮范围内
         cc.log("sprite began... x = " + locationInNode.x + ", y = " + locationInNode.y);
         //cc.director.runScene(new PlayScene());
      //   cc.log('replay');
         return true;
         }
         return false;

         }
         }, timebox);


        //底部下注信息
        var bottom_bar = new cc.Sprite(res.s_bottom_bar);
        bottom_bar.attr({
            scaleX:0.6,
            scaleY:0.5,
            x:0,
            y:0,
            anchorX:0,
            anchorY:0

        });

        //我的下注图标
        var mybetImg = new cc.Sprite(res.s_coin);
        mybetImg.attr({
            x:bottom_bar.width/2+10,
            y:bottom_bar.height-50,
            scale:1
        });
        bottom_bar.addChild(mybetImg,5);

        //总下注图标
        var allbetImg = new cc.Sprite(res.s_coin);
        allbetImg.attr({
            x:bottom_bar.width/2-20,
            y:bottom_bar.height-50,
            scale:1
        });
        bottom_bar.addChild(allbetImg,5);


        //我的本场下注
        var mycurGameSum = Number(myselfYD.dog2) + Number(myselfYD.dog3) + Number(myselfYD.dog4) + Number(myselfYD.dog5);
        var mybet = new cc.LabelTTF("本场下注:" + mycurGameSum.toString() , Font, 25);
        mybet.attr({
            x:bottom_bar.width/2-2,
            y:bottom_bar.height-70,
            anchorX:0,
            anchorY:0

        });
        mybet.setRotation(90);
        mybet.setColor(bsColor);
        bottom_bar.addChild(mybet);

        //我的2号狗下注
        var mybet2 = new cc.LabelTTF("2号:"+ myselfYD.dog2.toString() , Font, 25);
        mybet2.attr({
            x:bottom_bar.width/2-2,
            y:bottom_bar.height/2+180,
            anchorX:0,
            anchorY:0
        });
        mybet2.setRotation(90);
        mybet2.setColor(bsColor);
        bottom_bar.addChild(mybet2);

        //我的3号狗下注
        var mybet3 = new cc.LabelTTF("3号:" + myselfYD.dog3.toString(), Font, 25);
        mybet3.attr({
            x:bottom_bar.width/2-2,
            y:bottom_bar.height/2+10,
            anchorX:0,
            anchorY:0
        });
        mybet3.setRotation(90);
        mybet3.setColor(bsColor);
        bottom_bar.addChild(mybet3);

        //我的4号狗下注
        var mybet4 = new cc.LabelTTF("4号:" + myselfYD.dog4.toString(), Font, 25);
        mybet4.attr({
            x:bottom_bar.width/2-2,
            y:bottom_bar.height/2-160,
            anchorX:0,
            anchorY:0
        });
        mybet4.setRotation(90);
        mybet4.setColor(bsColor);
        bottom_bar.addChild(mybet4);

        //我的5号狗下注
        var mybet5 = new cc.LabelTTF("5号:"+ myselfYD.dog5.toString() , Font, 25);
        mybet5.attr({
            x:bottom_bar.width/2-2,
            y:bottom_bar.height/2-320,
            anchorX:0,
            anchorY:0
        });
        mybet5.setRotation(90);
        mybet5.setColor(bsColor);
        bottom_bar.addChild(mybet5);

        //本场总下注
        var curGameSum = sumYD.dog2 + sumYD.dog3 + sumYD.dog4 + sumYD.dog5;
        var allbet = new cc.LabelTTF("下注总数:"+ curGameSum.toString() , Font, 25);
        allbet.attr({
            x:bottom_bar.width/2-35,
            y:bottom_bar.height-70,
            anchorX:0,
            anchorY:0

        });
        allbet.setRotation(90);
        allbet.setColor(ssColor);
        bottom_bar.addChild(allbet);

        //本场2号狗下注
        var allbet2 = new cc.LabelTTF("2号:" + sumYD.dog2.toString(), Font, 25);
        allbet2.attr({
            x:bottom_bar.width/2-35,
            y:bottom_bar.height/2+180,
            anchorX:0,
            anchorY:0
        });
        allbet2.setRotation(90);
        allbet2.setColor(ssColor);
        bottom_bar.addChild(allbet2);

        //本场3号狗下注
        var allbet3 = new cc.LabelTTF("3号:" + sumYD.dog3.toString() , Font, 25);
        allbet3.attr({
            x:bottom_bar.width/2-35,
            y:bottom_bar.height/2+10,
            anchorX:0,
            anchorY:0
        });
        allbet3.setRotation(90);
        allbet3.setColor(ssColor);
        bottom_bar.addChild(allbet3);

        //本场4号狗下注
        var allbet4 = new cc.LabelTTF("4号:" + sumYD.dog4.toString() , Font, 25);
        allbet4.attr({
            x:bottom_bar.width/2-35,
            y:bottom_bar.height/2-160,
            anchorX:0,
            anchorY:0
        });
        allbet4.setRotation(90);
        allbet4.setColor(ssColor);
        bottom_bar.addChild(allbet4);

        //本场5号狗下注
        var allbet5 = new cc.LabelTTF("5号:" + sumYD.dog5.toString() , Font, 25);
        allbet5.attr({
            x:bottom_bar.width/2-35,
            y:bottom_bar.height/2-320,
            anchorX:0,
            anchorY:0
        });
        allbet5.setRotation(90);
        allbet5.setColor(ssColor);
        bottom_bar.addChild(allbet5);

        this.addChild(bottom_bar);


        this.scheduleOnce(this.runBg,0.5);
        this.schedule(this.dogMove,0.5);
        this.schedule(this.checkPZ,0.01);
        this.scheduleUpdate();

        //   this.addChild(layers.winUI);
        this.dog_js_actions = [this.dog2_js_action,this.dog3_js_action,this.dog4_js_action,this.dog5_js_action];
        //创建狗狗加速动画
        cc.spriteFrameCache.addSpriteFrames(res.s_dog1_js_plist);
        cc.spriteFrameCache.addSpriteFrames(res.s_dog2_js_plist);
        cc.spriteFrameCache.addSpriteFrames(res.s_dog3_js_plist);
        cc.spriteFrameCache.addSpriteFrames(res.s_dog4_js_plist);
        cc.spriteFrameCache.addSpriteFrames(res.s_dog5_js_plist);

        var animFrames = [];
        for (var i = 2; i < 10; i++) { //循环加载每一帧图片 v
            var frameName = "dog1_js_"+ i + ".png";
            var frame = cc.spriteFrameCache.getSpriteFrame(frameName);
            animFrames.push(frame);
        }
        var animation = new cc.Animation(animFrames, 1/8);                //定义图片播放间隔
        //var animationAction = new cc.Animate(animation);
        //animation.setDelayPerUnit(1 / 8); //设置每一帧动画间隔时间,单位s,此处2.8 / 14表示，一共14帧动画, 播放时间2.8s;
        //animation.setRestoreOriginalFrame(true); //设置动画播放完毕后，是否重置为原始帧
        
        this.dog1_js_action = cc.Animate.create(animation);
        
        var animFrames = [];
        for (var i = 2; i < 10; i++) { //循环加载每一帧图片 v
            var frameName = "dog2_js_"+ i + ".png";
            var frame = cc.spriteFrameCache.getSpriteFrame(frameName);
            animFrames.push(frame);
        }
        var animation = new cc.Animation(animFrames, 1/8);                //定义图片播放间隔
        //var animationAction = new cc.Animate(animation);
        //animation.setDelayPerUnit(1 / 8); //设置每一帧动画间隔时间,单位s,此处2.8 / 14表示，一共14帧动画, 播放时间2.8s;
        //animation.setRestoreOriginalFrame(true); //设置动画播放完毕后，是否重置为原始帧
        
        this.dog2_js_action = cc.Animate.create(animation);

        var animFrames = [];
        for (var i = 2; i < 10; i++) { //循环加载每一帧图片 v
            var frameName = "dog3_js_"+ i + ".png";
            var frame = cc.spriteFrameCache.getSpriteFrame(frameName);
            animFrames.push(frame);
        }
        var animation = new cc.Animation(animFrames, 1/8);                //定义图片播放间隔
        //var animationAction = new cc.Animate(animation);
        //animation.setDelayPerUnit(1 / 8); //设置每一帧动画间隔时间,单位s,此处2.8 / 14表示，一共14帧动画, 播放时间2.8s;
        //animation.setRestoreOriginalFrame(true); //设置动画播放完毕后，是否重置为原始帧
        
        this.dog3_js_action = cc.Animate.create(animation);

        var animFrames = [];
        for (var i = 2; i < 10; i++) { //循环加载每一帧图片 v
            var frameName = "dog4_js_"+ i + ".png";
            var frame = cc.spriteFrameCache.getSpriteFrame(frameName);
            animFrames.push(frame);
        }
        var animation = new cc.Animation(animFrames, 1/8);                //定义图片播放间隔
        //var animationAction = new cc.Animate(animation);
        //animation.setDelayPerUnit(1 / 8); //设置每一帧动画间隔时间,单位s,此处2.8 / 14表示，一共14帧动画, 播放时间2.8s;
        //animation.setRestoreOriginalFrame(true); //设置动画播放完毕后，是否重置为原始帧
        
        this.dog4_js_action = cc.Animate.create(animation);

        var animFrames = [];
        for (var i = 2; i < 10; i++) { //循环加载每一帧图片 v
            var frameName = "dog5_js_"+ i + ".png";
            var frame = cc.spriteFrameCache.getSpriteFrame(frameName);
            animFrames.push(frame);
        }
        var animation = new cc.Animation(animFrames, 1/8);                //定义图片播放间隔
        //var animationAction = new cc.Animate(animation);
        //animation.setDelayPerUnit(1 / 8); //设置每一帧动画间隔时间,单位s,此处2.8 / 14表示，一共14帧动画, 播放时间2.8s;
        //animation.setRestoreOriginalFrame(true); //设置动画播放完毕后，是否重置为原始帧
        
        this.dog5_js_action = cc.Animate.create(animation);
        
            

        return true;  
    },
	onEnter : function () {
		this._super();
        var dogspeedsobj = this;
        getSpeed();

        var self = this;
        xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange=function ()
        {
            if (xmlhttp.readyState==4)
              {// 4 = "loaded"
                if (xmlhttp.status==200)
                {// 200 = OK
                    var result = eval('(' + xmlhttp.responseText + ')'); 
                    self.all_ranking = result.rank;
                    cc.log(self.all_ranking);
                
                }
            }
        };
        xmlhttp.open("GET",'index.php?d=racedog&c=raceDog&m=getRank&ChannelID='+gameInfo.ChannelID+'&ActiveID='+gameInfo.ActiveID+'&RoomID='+gameInfo.RoomID);
        xmlhttp.send(null);
        
        //监听服务端发送过来的狗狗赛跑的速度信息
        socket.on('getDogInfo', function(obj){

         //   cc.log('dogspeeds:');
            obj = eval ("(" + obj + ")");
          //  cc.log(obj);
            dogspeedsobj.dogspeeds = obj;


            dogspeedsobj.scheduleUpdate();

            //  cc.director.runScene(new PlayScene(o));
        });

        this.schedule(this.updateLongTime,1);
	//	cc.log('onEnter');
	},
	onExit : function () {
		this._super();
		//cc.log('onExit');
	},runBg : function(){
        if(allowEffects){
            cc.audioEngine.playEffect(res.s_start_mp3,false);
        }
        for(var key in this.alldogs) {
            this.addDog(this.alldogs[key]);
        }
        var bg_pos = this.sprite.getPosition();
        bg_pos.y += 14;
        this.sprite.setPosition(bg_pos);
        this.schedule(this.check,0.05);
        this.isRunning = true;
    },
    updateLongTime:function(){
        if(this.longseconds > 0){
            this.longseconds --;
        }
        
        var i = this.longseconds;
        var newText = "" +  (i);
        this.longtime.setString(newText);

        //播放冲刺音效
        if(i == 3 && allowEffects){
            cc.audioEngine.playEffect(res.s_huhan_mp3,false);
        }

         if(this.longseconds < 1 && this.isOver){
          //  cc.log('lll');
          cc.log(this.bianhaoArray);
            this.gameOver(this.all_ranking);
             this.longseconds = 10;
             this.longtime.setString("10");
             this.longtext.setString("结算时间");
             this.schedule(this.updateResultTime,1);
         }
         //if( this.longseconds <1 ) this.unschedule(this.updateLongTime);


    },updateResultTime: function(){
        if(this.longseconds > 0){
            this.longseconds --;
        }

        var i = this.longseconds;
        var newText = "" +  (i);
        this.longtime.setString(newText);
    }
    ,
    update : function() {
        this.musicBTN.initWithFile((!allowMusic && !allowEffects)?res.s_musicbtn_off:res.s_musicbtn);
        
        
    },dogInfo:function(){
       //
        // cc.log(123);
    },
	check:function(){

		/*var dogs = new Array(this.dog2,this.dog3,this.dog4);
		for(var i in dogs){
			var dog = dogs[i];
			var distance = cc.pDistance(this.redline.getPosition(), dog.getPosition());
			var radiusSum = 50;
			//cc.log("distance:" + distance + "; radius:" + radiusSum);
			if(distance < radiusSum){
				//发生碰撞
				cc.log(dog.bianhao);
			}
		}*/

        var bg_pos = this.sprite.getPosition();
        bg_pos.y += 12;

        if(bg_pos.y < 3554 ) {
            this.sprite.setPosition(bg_pos);
            this.redline.y += 12;
           // cc.log( bg_pos.y);
        }

	},
    checkPZ:function(){
        var dogs = new Array(this.dog1,this.dog2,this.dog3,this.dog4,this.dog5);
        for(var i in dogs){
            var dog = dogs[i];
            //cc.log(dog.isOver);
            if(dog.isOver == 0){

                
                var dollRect = this.redline.getBoundingBox();
                var dollHeadRect = dog.getBoundingBox();
                if(cc.rectIntersectsRect(dollRect, dollHeadRect)){
                        //发生碰撞事件  
                        this.ranking ++;
						this.countRanking ++;
                     //   cc.log(dog.bianhao);
                    //    cc.log(dog.y);
                        dog.isOver = 1;
                        //把编号传入数组传给结果页面输出
                        var bh = dog.bianhao;
                        /*if(bh && bh != '' && bh != undefined) {
                            if(Number( bh ) ==1){ this.czRanking = this.ranking}
                            this.bianhaoArray.push(bh);
                        }*/



                        //输出排名



                       /* var rankLabel = new cc.LabelTTF("第"+ this.ranking + "名", Font, 35);
                        if(this.ranking == 1) rankLabel.setColor(cc.color(255,203,25));
                        rankLabel.x = dog.getPositionX()-33;
                        rankLabel.y =  280;
                        rankLabel.setRotation(90);*/

                        for(var r in this.all_ranking){
                            if(bh == this.all_ranking[r]){
                                this.ranking = Number(r)+1;
                            }
                        }

                        var rankLabel = new cc.Sprite("ranking"+ this.ranking + ".png");
                        //if(this.ranking == 1) rankLabel.setColor(cc.color(255,203,25));
                        rankLabel.x = dog.getPositionX()-20;
                        rankLabel.y =  280;
                        rankLabel.setScale(0.5);
                        //rankLabel.setRotation(90);

                        this.addChild(rankLabel, 2);

                        /*  //计算排名到第五后说明可以结束游戏
                        if( Number( this.ranking ) == 5 && !this.isOver){
                            this.isOver = true;
                            this.gameOver(this.bianhaoArray);
                           // cc.log(this.ranking);
                        }*/
                        dog.stopAllActions();
                        this.addDog_end(dog);
                        var actionMove = cc.MoveTo.create(1,cc.p( dog.x,50));
                        var actionMoveDone = cc.CallFunc.create(this.spriteMoveFinished,this);
                        dog.runAction(cc.Sequence.create(actionMove,actionMoveDone));
                        

                }
            }
                
        }

        
    },
	dogMove:function() {
        var self = this;
		var arrSimple2 = new Array();
		var dogSprites = this.alldogs;//new Array(this.dog2, this.dog3, this.dog4);
		var isExit = new Array(5);
        var bg_pos = this.sprite.getPosition();
        var speed = 0 ;
        for(var key in dogSprites){
          //  cc.log(this.dogspeeds[key]);
            if(dogSprites[key].isOver == 1) continue;
			var dogPosition =  dogSprites[key].getPosition();
			arrSimple2.push(dogPosition.y);
            var bh = dogSprites[key].bianhao;
			//大于1000过后放慢速度
			speed =Number( this.dogspeeds[bh-1][this.ds] ); //arrSimple2[0] < 500 ? this.dogSpeed(0,30,isExit) : this.dogSpeed(0,60,isExit);// //arrSimple2[0] > 1000 ? 5 : this.dogSpeed(10,25,isExit);
			//cc.log(speed);
            if( isNaN(speed) ) speed=0;
            isExit.push(speed);
			dogPosition.y -= speed;

            if(speed > 30 ){
              //  cc.log("速度：");
              //  cc.log(speed);
                
                switch(dogSprites[key].bianhao){
                    case 1:
                        dogSprites[key].stopAllActions();
                        dogSprites[key].runAction(cc.Sequence.create(this.dog1_js_action,cc.CallFunc.create(function(obj){self.addDog(obj);},dogSprites[key])));
                        break;
                    case 2:
                        dogSprites[key].stopAllActions();
                        dogSprites[key].runAction(cc.Sequence.create(this.dog2_js_action,cc.CallFunc.create(function(obj){self.addDog(obj);},dogSprites[key])));
                        break;
                    case 3:
                        dogSprites[key].stopAllActions();
                        dogSprites[key].runAction(cc.Sequence.create(this.dog3_js_action,cc.CallFunc.create(function(obj){self.addDog(obj);},dogSprites[key])));
                        break;
                    case 4:
                        dogSprites[key].stopAllActions();
                        dogSprites[key].runAction(cc.Sequence.create(this.dog4_js_action,cc.CallFunc.create(function(obj){self.addDog(obj);},dogSprites[key])));
                        break;
                    case 5:
                        dogSprites[key].stopAllActions();
                        dogSprites[key].runAction(cc.Sequence.create(this.dog5_js_action,cc.CallFunc.create(function(obj){self.addDog(obj);},dogSprites[key])));
                        break;
                }
                
                
                
            }

			var actionMove = cc.MoveTo.create(1.5,dogPosition);
			// 设置一个回调函数，移动完毕后回调spriteMoveFinished（）方法。
			var actionMoveDone = cc.CallFunc.create(this.spriteMoveFinished2,dogSprites[key]);
			// 让子弹执行动作
			dogSprites[key].runAction(cc.Sequence.create(actionMove,actionMoveDone));
			// 为子弹设置标签，以后可以根据这个标签判断是否这个元素为子弹
			dogSprites[key].setTag(key);
           // cc.log(dogSprites);

		}
       // cc.log(dogSprites);
	/*	arrSimple2.sort(function(a,b){
			return a-b});
*/


/*

      //  cc.log(arrSimple2[0]);
		for(var key in dogSprites){
            if(dogSprites[key].isOver == 1) continue;
			var dogPositionY =  dogSprites[key].getPositionY();
			if(dogPositionY == arrSimple2[0]){
				/!*if(dogPositionY < 300){
                    //dogSprites[key].attr({isOver:1});
                  //  this.unscheduleAllCallbacks();
                    //输出排名
                    this.ranking ++;
                    var rankLabel = new cc.LabelTTF(" "+ this.ranking, Font, 38);
                    rankLabel.x = dogSprites[key].getPositionX();
                    rankLabel.y =  250;
                  //  this.addChild(rankLabel, 2);
                    //记录排名
                    this.resultText += "dog:"+dogSprites[key].bianhao + "---ranking:"+this.ranking + "     ";
                    //把编号传入数组传给结果页面输出
                    var bh = dogSprites[key].bianhao;
                    if(bh && bh != '' && bh != undefined) {
                        if(Number( bh ) ==1){ this.czRanking = this.ranking}
                        this.bianhaoArray.push(bh);
                    }

                    var dogPosition =  dogSprites[key].getPosition();
                 //   dogPosition.x =840;
                    var actionMove = cc.MoveTo.create(1,cc.p( dogPosition.x,100));
                    var actionMoveDone = cc.CallFunc.create(this.spriteMoveFinished,this);
                  //  dogSprites[key].runAction(cc.Sequence.create(actionMove,actionMoveDone));
                  //  dogSprites[key].stopAllActions();
					//cc.log(dogSprites[key]);
					//this.gameOver(key + 2);
				}*!/

		    }
        }*/



        this.ds ++;
	},
	spriteMoveFinished:function(dog){
        

        dog.stopAllActions();
        
            
            
        //dog.initWithFile("dog"+dog.bianhao+"_0.png");
        
        //计算排名到第五后说明可以结束游戏
        if( Number( this.countRanking ) == 5 && !this.isOver){
            this.isOver = true;
            //this.gameOver(this.bianhaoArray);
           // cc.log(this.ranking);
        }




	},
    gameOver:function(bianhaoArray){
        this.unscheduleAllCallbacks();
        //this.hero.stopAllActions();
        //this.hero1.stopAllActions();
       // this.hero2.stopAllActions();
       for(var r in this.all_ranking){
        if(this.all_ranking[r] == 1){

            this.czRanking = Number(r)+1;
        }
       }
        layers.winUI = new ResultUI(true,bianhaoArray, this.czRanking);
        this.addChild(layers.winUI,100);
        if(allowMusic){
            cc.audioEngine.stopMusic();
            if (!cc.audioEngine.isMusicPlaying()) {
                cc.audioEngine.playMusic(res.s_bg_music_mp3, true);
            }
        }
            

    },
	dogSpeed:function(Min,Max,isExit){
		var Range = Max - Min;   
		var Rand = Math.random();   
		var returnNum = Min + Math.round(Rand * Range);
		if(isExit.indexOf(returnNum) >-1 ){
			return returnNum + 2;
		}else{
			return  returnNum;   
		}
	},
	addDog:function(hero){
        //加载狗狗动画资源
        cc.spriteFrameCache.addSpriteFrames(res.s_dog1_plist);
        cc.spriteFrameCache.addSpriteFrames(res.s_dog2_plist);
        cc.spriteFrameCache.addSpriteFrames(res.s_dog3_plist);
        cc.spriteFrameCache.addSpriteFrames(res.s_dog4_plist);
        cc.spriteFrameCache.addSpriteFrames(res.s_dog5_plist);

		var actionDog =  this.spriteDogOne;
		//var animation = cc.Animation.create();//创建动画对象
        var bainhao = hero.bianhao;
        var ZL = [0,8,8,9,7,9];
        var animFrames = [];
		for (var i = 1; i < 9; i++) { //循环加载每一帧图片 v
			var frameName = "dog"+bainhao+"_" + i + ".png";//图片命名为01-14.png,两位数即10以下为"0" + i,两位数以上为i
			//animation.addSpriteFrameWithFile(frameName);
            var frame = cc.spriteFrameCache.getSpriteFrame(frameName);
            animFrames.push(frame);
		}
        var animation = new cc.Animation(animFrames, 1/8);                //定义图片播放间隔
        //var animationAction = new cc.Animate(animation);
		//animation.setDelayPerUnit(1 / 8); //设置每一帧动画间隔时间,单位s,此处2.8 / 14表示，一共14帧动画, 播放时间2.8s;
		animation.setRestoreOriginalFrame(true); //设置动画播放完毕后，是否重置为原始帧
		var action = cc.Animate.create(animation); //cc.Animate是cc.Action动作类的子类，创建一个以animation为动画对象的动画动作
		//this.spriteTopBg.runAction(cc.Sequence.create(action, action.reverse())); //执行动画

            //重复运行Action，不断的转圈
         hero.runAction(cc.RepeatForever.create(action));

	},
    addDog_end:function(hero){
        //加载狗狗动画资源
        cc.spriteFrameCache.addSpriteFrames(res.s_dog1_plist);
        cc.spriteFrameCache.addSpriteFrames(res.s_dog2_plist);
        cc.spriteFrameCache.addSpriteFrames(res.s_dog3_plist);
        cc.spriteFrameCache.addSpriteFrames(res.s_dog4_plist);
        cc.spriteFrameCache.addSpriteFrames(res.s_dog5_plist);

        var actionDog =  this.spriteDogOne;
        //var animation = cc.Animation.create();//创建动画对象
        var bianhao = hero.bianhao;
        var ZL = [0,8,8,8,8,8];
        var animFrames = [];
        for (var i = 1; i < 9; i++) { //循环加载每一帧图片 v
            var frameName = "dog"+bianhao+"_" + i + ".png";//图片命名为01-14.png,两位数即10以下为"0" + i,两位数以上为i
            //animation.addSpriteFrameWithFile(frameName);
            var frame = cc.spriteFrameCache.getSpriteFrame(frameName);
            animFrames.push(frame);
        }
        var animation = new cc.Animation(animFrames, 1/8);                //定义图片播放间隔
        //var animationAction = new cc.Animate(animation);
        animation.addSpriteFrameWithFile("dog"+bianhao+"_0.png");
        //animation.setDelayPerUnit(1 / 8); //设置每一帧动画间隔时间,单位s,此处2.8 / 14表示，一共14帧动画, 播放时间2.8s;
        animation.setRestoreOriginalFrame(true); //设置动画播放完毕后，是否重置为原始帧
        var action = cc.Animate.create(animation); //cc.Animate是cc.Action动作类的子类，创建一个以animation为动画对象的动画动作
        //this.spriteTopBg.runAction(cc.Sequence.create(action, action.reverse())); //执行动画


            //重复运行Action，不断的转圈
        hero.runAction(action);

    }
});  
   
var PlayScene = cc.Scene.extend({
    onEnter:function () {  
        this._super();  
        var layer = new PlayLayer();
        this.addChild(layer);  
    }  
});