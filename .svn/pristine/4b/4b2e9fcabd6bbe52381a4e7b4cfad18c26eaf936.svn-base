/**
 * Created by Administrator on 2016/4/4 0004.
 */

var WaitingLayer = cc.Layer.extend({
    sprite:null,
    alldogs : null,
    dog1:null,
    dog2:null,
    dog3:null,
    dog4:null,
    dog5:null,
    dog11:null,
    dog12:null,
    dog13:null,
    dog14:null,
    dog15:null,
    selected:null,
    timeLabel: null,
    timeLeft : null,
    mygoldLable:null,
    xiazahu_array:null,
    bottom_bar_bg:null,
    mybet:[],
    musicBTN : null,
    ctor:function (time) {
        //////////////////////////////
        // 1. super init first
        this._super();
        var self = this;
        var jsColor = cc.color(255,203,25);//金色
        var ssColor = cc.color(249,208,84);//深色
        var bsColor = cc.color(255,255,255);//白色

        //加载狗狗动画资源
        cc.spriteFrameCache.addSpriteFrames(res.s_dog1_plist);
        cc.spriteFrameCache.addSpriteFrames(res.s_dog2_plist);
        cc.spriteFrameCache.addSpriteFrames(res.s_dog3_plist);
        cc.spriteFrameCache.addSpriteFrames(res.s_dog4_plist);
        cc.spriteFrameCache.addSpriteFrames(res.s_dog5_plist);



        /////////////////////////////
        // 2. add a menu item with "X" image, which is clicked to quit the program
        //    you may modify it.
        // ask the window size
        var size = cc.winSize;

        //添加背景
        var runbg = new cc.Sprite(scene_bg);
        runbg.setAnchorPoint(0, 1);
        runbg.setPosition(0, size.height);
        runbg.setScale(0.65);
        runbg.setTag(10);
        //this.sprite.setRotation(270);
        this.addChild(runbg, 0);



        //添加五只背景狗狗
        this.alldogs = new Array(this.dog1, this.dog2,this.dog3, this.dog4, this.dog5);
        var widths = [0.25,0.40,0.54,0.7,0.84];
        var i = 5;//初始化狗狗编号
        for(var key in this.alldogs) {

            var width = size.width * widths[key];
       //     cc.log(width);
            var height = size.height - 100;
            this.alldogs[key] =  new cc.Sprite("dog"+i+"_0.png");
            this.alldogs[key].attr({
                bianhao:i,
                isOver:0,
                scale: 0.5,
                x: width ,
                y: height ,
                anchorX:0.5,
                anchorY:0
            });
            this.addChild( this.alldogs[key], 1);
            i--;
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
                case 4:
                    this.dog4 = this.alldogs[key];
                    break;
                case 5:
                    this.dog5 = this.alldogs[key];
                    break;
                default:

            }

        }


        //赛场主信息
        //申请赛场主按钮
        var sq_btn = new cc.MenuItemImage(
            res.s_sqbtn,
            res.s_sqbtn,
            res.s_sqbtn_off,
            function () {
                cc.log("Menu is clicked!");
                if(wx_info.total_gold < SCZ_ZG_GOLD){
                    var tipUI = new TipUI("烟豆少于"+unit(SCZ_ZG_GOLD)+"不能申请赛场主！");
                    this.addChild(tipUI,100);
                    return;
                }
                cc.log({openid:wx_info.openid,nickname:wx_info.nickname});
                socket.emit('ApplyCZ', {openid:wx_info.openid,nickname:wx_info.nickname});
                var tipUI = new TipUI("申请赛场主成功！");
                    this.addChild(tipUI,100);
            }, this);
        sq_btn.attr({
            x: size.width-30,
            y: size.height-40,
            scale:0.6
        });

        //取消赛场主按钮
        var qx_btn = new cc.MenuItemImage(
            res.s_cancel_btn,
            res.s_cancel_btn,
            function () {
                cc.log("CancelCZ  is clicked!");
                
                cc.log({openid:wx_info.openid,nickname:wx_info.nickname});
                socket.emit('CancelCZ', {openid:wx_info.openid,nickname:wx_info.nickname});
                //var tipUI = new TipUI("该功能开发中！");
                //this.addChild(tipUI,100);

            }, this);
        qx_btn.attr({
            x: size.width-30,
            y: size.height-40,
            scale:0.6
        });
        qx_btn.setVisible(false);

        var menu = new cc.Menu(sq_btn,qx_btn);
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
        this.addChild(sczLable,100);

        var sczname = new cc.LabelTTF("超级狗庄", fontDefGreenStroke);
        sczname.attr({
            x: size.width-20,
            y: size.height-155,
            anchorX:0
        });
        sczname.setRotation(90);
        //sczname.setColor(cc.color(255,255,255));
        this.addChild(sczname,100);

        //累计财富
        var caifuImg = new cc.Sprite(res.s_coin);
        caifuImg.attr({
            x:size.width-50,
            y:size.height-88,
            anchorX:0,
            scale:0.7
        });
        this.addChild(caifuImg,5);

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
        this.addChild(caifuLable,100);

        var caifunum = new cc.LabelTTF("0", fontDefYellowStroke);
        caifunum.attr({
            x: size.width-40,
            y: size.height-165,
            anchorX:0
        });
        caifunum.setRotation(90);
        //caifunum.setColor(cc.color(255,255,255));
        this.addChild(caifunum,100);

        /*//音乐按钮旁边的时间
        var timebox = new cc.Sprite(res.s_timebox);
        timebox.attr({
            x: size.width-30,
            y: 200,
            scale:0.8
        });*/

        /*var longtime = new cc.LabelTTF("00:15:00", Font,20);
        longtime.attr({
            x: timebox.width/2-3,
            y: timebox.height/2-20
        });
        longtime.setRotation(90);
        longtime.setColor(cc.color(255,255,255));
        timebox.addChild(longtime,5);
        this.addChild(timebox);*/

        /*//声音图标
        var musicBTN = new cc.Sprite(res.s_musicbtn);
        musicBTN.attr({
            x: size.width-30,
            y: 100,
            scale:0.8
        });
        this.addChild(musicBTN);

        //设置图标
        var settingBTN = new cc.Sprite(res.s_settingbtn);
        settingBTN.attr({
            x: size.width-30,
            y: 50,
            scale:0.8
        });
        this.addChild(settingBTN);*/

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
                        
                        if(!cc.audioEngine.isMusicPlaying()){
                            cc.audioEngine.playMusic(res.s_bg_music_mp3, true);
                        }
                        
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

        //个人信息
        //个人信息背景
        var profile_bg = new cc.Sprite(res.s_profile_bg);
        profile_bg.attr({
            x:0,
            y:size.height-3,
            scale: 0.69
        });
        profile_bg.setAnchorPoint(0, 1);

        //个人头像
        var myavatar = new cc.Sprite(res.s_myavatar);
        myavatar.attr({
            x:profile_bg.width/2,
            y:profile_bg.height-myavatar.height/2-10,

        });

        //加载微信头像
        cc.loader.loadImg(wx_info.headimgurl, {isCrossOrigin : false }, function(err, img)
        {
            var sprite = new cc.Sprite(wx_info.headimgurl);
            sprite.x = this.width / 2 ;
            sprite.y = this.height / 2 ;
            //sprite.scale = 0.1;
            sprite.setRotation(90);
            myavatar.addChild(sprite);

        }.bind(myavatar));



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
        var mygoldLable = this.mygoldLable = new cc.LabelTTF("我的烟豆:"+wx_info.total_gold,fontDefBlackStroke);
        mygoldLable.attr({
            x:profile_bg.width/2+10,
            y:profile_bg.height/2+60,
            anchorX:0,
            anchorY:1
        });
        mygoldLable.setRotation(90);
        //mygoldLable.setColor(cc.color(220,220,220));
        profile_bg.addChild(mygoldLable);

        //本次金币数量
        var thisgoldLable = new cc.LabelTTF("本次烟豆:"+thisTimesgold,fontDefBlackStroke);
        thisgoldLable.attr({
            x:profile_bg.width/2-15,
            y:profile_bg.height/2+60,
            anchorX:0,
            anchorY:1
        });
        thisgoldLable.setRotation(90);
        //thisgoldLable.setColor(cc.color(220,220,220));
        profile_bg.addChild(thisgoldLable);

        /*//我的成绩图标
        var myscore = new cc.MenuItemImage(
            res.s_myscore,
            res.s_myscore,
            function () {
                cc.log("myscore is clicked!");
            }, this);
        myscore.attr({
            x:0,
            y:0
        });
        var myscoremenu = new cc.Menu(myscore);
        myscoremenu.x = profile_bg.width/2-5;
        myscoremenu.y = 40;
        profile_bg.addChild(myscoremenu, 1);*/

        this.addChild(profile_bg);

        //底部下注信息
        var bottom_bar = this.bottom_bar_bg = new cc.Sprite(res.s_bottom_bar);
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
            x:bottom_bar.width/2+15,
            y:bottom_bar.height-70,
            scale:1
        });
        bottom_bar.addChild(mybetImg,5);

        //总下注图标
        var allbetImg = new cc.Sprite(res.s_coin);
        allbetImg.attr({
            x:bottom_bar.width/2-15,
            y:bottom_bar.height-70,
            scale:1
        });
        bottom_bar.addChild(allbetImg,5);




        socket.emit('login', {openid:wx_info.openid,nickname:wx_info.nickname,headimgurl:wx_info.headimgurl,sex:wx_info.sex});
        var self = this;

        socket.on('CurrSCZ', function(o){
            cc.log(o);
            SCZ = o;
            sczname.setString(SCZ.SCZName);
            caifunum.setString(SCZ.SCZGold);

            if(wx_info.openid == SCZ.SCZOpenid){

                qx_btn.setVisible(true);
                sq_btn.setEnabled(false);
            }else{
                qx_btn.setVisible(false);
                sq_btn.setEnabled(true);
            }

        });
		
		//监听现在人数事件
        socket.on('onlineCount', function(o){
            onlineCount.setString("在线人数:"+o.onlineCount);
            CurrOnlineCount = o.onlineCount;

            
        });




        /*//个人信息
        //个人信息背景
        var profile_bg = new cc.Sprite(res.s_profile_bg);
        profile_bg.attr({
            x:3,
            y:size.height-5,
            scale: 0.6
        });
        profile_bg.setAnchorPoint(0, 1);

        //个人头像
        var myavatar = new cc.Sprite(res.s_myavatar);
        myavatar.attr({
            x:profile_bg.width/2,
            y:profile_bg.height-myavatar.height/2-10
        });




        cc.textureCache.addImageAsync("http://www.52ij.com/uploads/allimg/160317/1110104P8-4.jpg", function(texture)
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
         });

        profile_bg.addChild(myavatar);

        //用户名
        var myname = new cc.LabelTTF(wx_info.nickname,Font,20);
        myname.attr({
            x:profile_bg.width/2+35,
            y:profile_bg.height/2+25,
            anchorX:0.5,
            anchorY:1
        });
        myname.setRotation(90);
        myname.setColor(cc.color(0,0,0));
        profile_bg.addChild(myname);

        //我的金币图标
        var mygold = new cc.Sprite(res.s_mygold);
        mygold.attr({
            x:profile_bg.width/2-5,
            y:profile_bg.height-myavatar.height-mygold.height-10
        });
        profile_bg.addChild(mygold);

        //我的金币数量
        var mygoldLable = this.mygoldLable= new cc.LabelTTF("1254658",Font,20);
        mygoldLable.attr({
            x:profile_bg.width/2+4,
            y:profile_bg.height/2-10,
            anchorX:0.5,
            anchorY:1
        });
        mygoldLable.setRotation(90);
        mygoldLable.setColor(cc.color(220,220,220));
        profile_bg.addChild(mygoldLable);

        //我的成绩图标
        var myscore = new cc.MenuItemImage(
            res.s_myscore,
            res.s_myscore,
            function () {
                cc.log("myscore is clicked!");
            }, this);
        myscore.attr({
            x:0,
            y:0
        });
        var myscoremenu = new cc.Menu(myscore);
        myscoremenu.x = profile_bg.width/2-5;
        myscoremenu.y = 40;
        profile_bg.addChild(myscoremenu, 1);

        this.addChild(profile_bg);*/

        //监听服务端发送过来的开始赛跑命令
        socket.on('startRun', function(o){
          //  cc.log(o);
            cc.director.runScene(new PlayScene(o));
        });

        //监听服务端发送过来的开始结算命令
        socket.on('statement', function(o){
         //   cc.log(o);
            //   cc.director.runScene(new XiazhuScene(o));
        });

        //监听服务端发送过来的新的一局命令
        socket.on('newGame', function(o){
          //  cc.log(o);
         //   cc.director.runScene(new ChooseScene(o));
        });


        //监听新用户登录
        socket.on('login', function(o){
            self.mygoldLable.setString('我的烟豆:'+o.total_gold);
			wx_info.total_gold = o.total_gold;
            cc.log("sec:"+o.seconds);
            if(o.seconds < 30){
                cc.log(self.xiazahu_array);
                cc.director.runScene(new ChooseScene(o,self.xiazahu_array));
            }else{
                //遮罩层
                var SelectLayer = new cc.LayerColor(cc.color(10,10,10,100));

                //倒计时
                var timeLabel = self.timeLabel = new cc.LabelTTF("选择倒计时：" , Font, 20);
                timeLabel.x = size.width-30;
                timeLabel.y = size.height/2;
                timeLabel.setRotation(90);
                timeLabel.setColor(cc.color(255,203,25));
                //   SelectLayer.addChild(timeLabel);

                //选择狗狗背景图
                var selectBg = new cc.Sprite(res.s_pop1);
                selectBg.attr({
                    x : size.width/2,
                    y : size.height/2,
                  //  scale:0.6
                });


                var waitLabel = new cc.LabelTTF("比赛进行中，请稍候....", Font, 30);
                waitLabel.attr({
                    x:selectBg.width/2-20,
                    y:selectBg.height/2
                });
                waitLabel.setRotation(90);
                waitLabel.setColor(cc.color(249,233,87));
                selectBg.addChild(waitLabel);
                SelectLayer.addChild(selectBg);
                self.addChild(SelectLayer,10);

            }
        });

        socket.on('get_my_xiazhu', function(obj){
            var sum_xiazhu = Number(obj.xiazahu_array.dog2) +  Number(obj.xiazahu_array.dog3) + Number(obj.xiazahu_array.dog4) + Number(obj.xiazahu_array.dog5) ;
            myselfYD={sum:sum_xiazhu, dog2:obj.xiazahu_array.dog2, dog3:obj.xiazahu_array.dog3, dog4:obj.xiazahu_array.dog4, dog5:obj.xiazahu_array.dog5  }; //总的下注烟豆

            //我的本场下注
            var mybet = new cc.LabelTTF("我的本场下注："+ sum_xiazhu, Font, 25);
            mybet.attr({
                x:bottom_bar.width/2-2,
                y:bottom_bar.height-90,
                anchorX:0,
                anchorY:0

            });
            mybet.setRotation(90);
            mybet.setColor(bsColor);
            bottom_bar.addChild(mybet);

            //我的2号狗下注
            var mybet2 = new cc.LabelTTF("2号："+obj.xiazahu_array.dog2 , Font, 25);
            mybet2.attr({
                x:bottom_bar.width/2-2,
                y:bottom_bar.height/2+100,
                anchorX:0,
                anchorY:0
            });
            mybet2.setRotation(90);
            mybet2.setColor(bsColor);
            bottom_bar.addChild(mybet2);

            //我的3号狗下注
            var mybet3 = new cc.LabelTTF("3号："+obj.xiazahu_array.dog3 , Font, 25);
            mybet3.attr({
                x:bottom_bar.width/2-2,
                y:bottom_bar.height/2-50,
                anchorX:0,
                anchorY:0
            });
            mybet3.setRotation(90);
            mybet3.setColor(bsColor);
            bottom_bar.addChild(mybet3);

            //我的4号狗下注
            var mybet4 = new cc.LabelTTF("4号："+obj.xiazahu_array.dog4 , Font, 25);
            mybet4.attr({
                x:bottom_bar.width/2-2,
                y:bottom_bar.height/2-190,
                anchorX:0,
                anchorY:0
            });
            mybet4.setRotation(90);
            mybet4.setColor(bsColor);
            bottom_bar.addChild(mybet4);

            //我的5号狗下注
            var mybet5 = new cc.LabelTTF("5号："+obj.xiazahu_array.dog5 , Font, 25);
            mybet5.attr({
                x:bottom_bar.width/2-2,
                y:bottom_bar.height/2-340,
                anchorX:0,
                anchorY:0
            });
            mybet5.setRotation(90);
            mybet5.setColor(bsColor);
            bottom_bar.addChild(mybet5);
            self.addChild(bottom_bar);
        });


        socket.on('get_cur_xiazhu', function(o) {
            self.xiazahu_array = o.xiazahu_array;

            cc.log(o);
            //本场总下注
            var sum_xiazhu = Number(o.xiazahu_array.dog2) +  Number(o.xiazahu_array.dog3) + Number(o.xiazahu_array.dog4) + Number(o.xiazahu_array.dog5) ;
            sumYD={sum:sum_xiazhu, dog2:o.xiazahu_array.dog2, dog3:o.xiazahu_array.dog3, dog4:o.xiazahu_array.dog4, dog5:o.xiazahu_array.dog5  }; //总的下注烟豆
            var allbet = new cc.LabelTTF("本场下注总金额：" +sum_xiazhu, Font, 25);
            allbet.attr({
                x: self.bottom_bar_bg.width/2-35,
                y: self.bottom_bar_bg.height-90,
                anchorX:0,
                anchorY:0

            });
            allbet.setRotation(90);
            allbet.setColor(ssColor);
            self.bottom_bar_bg.addChild(allbet);

            //本场2号狗下注
            var allbet2 = new cc.LabelTTF("2号："+o.xiazahu_array.dog2 , Font, 25);
            allbet2.attr({
                x: self.bottom_bar_bg.width/2-35,
                y: self.bottom_bar_bg.height/2+100,
                anchorX:0,
                anchorY:0
            });
            allbet2.setRotation(90);
            allbet2.setColor(ssColor);
            self.bottom_bar_bg.addChild(allbet2);

            //本场3号狗下注
            var allbet3 = new cc.LabelTTF("3号：" +o.xiazahu_array.dog3, Font, 25);
            allbet3.attr({
                x: self.bottom_bar_bg.width/2-35,
                y: self.bottom_bar_bg.height/2-50,
                anchorX:0,
                anchorY:0
            });
            allbet3.setRotation(90);
            allbet3.setColor(ssColor);
            self.bottom_bar_bg.addChild(allbet3);

            //本场4号狗下注
            var allbet4 = new cc.LabelTTF("4号："+o.xiazahu_array.dog4, Font, 25);
            allbet4.attr({
                x: self.bottom_bar_bg.width/2-35,
                y: self.bottom_bar_bg.height/2-190,
                anchorX:0,
                anchorY:0
            });
            allbet4.setRotation(90);
            allbet4.setColor(ssColor);
            self.bottom_bar_bg.addChild(allbet4);

            //本场5号狗下注
            var allbet5 = new cc.LabelTTF("5号："+o.xiazahu_array.dog5 , Font, 25);
            allbet5.attr({
                x: self.bottom_bar_bg.width/2-35,
                y: self.bottom_bar_bg.height/2-340,
                anchorX:0,
                anchorY:0
            });
            allbet5.setRotation(90);
            allbet5.setColor(ssColor);
            self.bottom_bar_bg.addChild(allbet5);



        })

        if(wx_info.openid == SCZ.SCZOpenid){

            qx_btn.setVisible(true);
            sq_btn.setEnabled(false);
        }

        this.scheduleUpdate();
        return true;
    },

    update : function() {
        this.musicBTN.initWithFile((!allowMusic && !allowEffects)?res.s_musicbtn_off:res.s_musicbtn);
        
        
    },
});

var WaitingScene = cc.Scene.extend({
    _time:null,
    ctor:function(time){
        this._super();
        this._time = time;
    },
    onEnter:function () {
        this._super();
        var layer = new WaitingLayer(this._time);
        this.addChild(layer);
    }
});


