/**
 * Created by Administrator on 2016/4/4 0004.
 */

var ChooseLayer = cc.Layer.extend({
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
    selectedbet:null,
    timeLabel : null,
    timeLeft : null,
    mybet:[],
    betStatus:true,
    selectedbox:null,
    selectBg:null,
    mygold:null,
    isSetGift:false,//是否在送礼
    myGoldLb:null,
    xiazahu_array:null,
    isBetAgain:false,
    musicBTN : null,
    longtime:null,
    isFirstReturn : true,
    beton_again_sum : 0,
    WinPanlDjs : null,
    ctor:function (time,xiazahu_arrays) {
        //////////////////////////////
        // 1. super init first
        this._super();
        var self = this;

        this.isBetAgain = false;
        this.xiazahu_array = xiazahu_arrays;
        this.mygold = wx_info.total_gold;

        this.mybet = [{openid: wx_info.openid,dog: 2,gold: 0},{openid: wx_info.openid,dog: 3,gold: 0},{openid: wx_info.openid,dog: 4,gold: 0},{openid: wx_info.openid,dog: 5,gold: 0}];
       //判断下过注
        if(myselfYD.sum > 0){
            this.betStatus = false;
        }
        /////////////////////////////
        // 2. add a menu item with "X" image, which is clicked to quit the program
        //    you may modify it.
        // ask the window size
        var size = cc.winSize;
        var ssColor = cc.color(171,106,28);//深色
        //添加背景
        var runbg = new cc.Sprite(scene_bg);
        
        runbg.setAnchorPoint(0, 1);
        runbg.setPosition(0, size.height);
        runbg.setScale(0.65);
        runbg.setTag(10);
        this.addChild(runbg, 0);

        //加载狗狗动画资源
        cc.spriteFrameCache.addSpriteFrames(res.s_dog1_plist);
        cc.spriteFrameCache.addSpriteFrames(res.s_dog2_plist);
        cc.spriteFrameCache.addSpriteFrames(res.s_dog3_plist);
        cc.spriteFrameCache.addSpriteFrames(res.s_dog4_plist);
        cc.spriteFrameCache.addSpriteFrames(res.s_dog5_plist);


        //添加五只背景狗狗
        this.alldogs = new Array(this.dog1, this.dog2,this.dog3, this.dog4, this.dog5);
        var widths = [0.25,0.40,0.54,0.7,0.84];
        var i = 5;//初始化狗狗编号
        for(var key in this.alldogs) {

            var width = size.width * widths[key];
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
                if(wx_info.total_gold < SCZ_ZG_GOLD){
                    var tipUI = new TipUI("烟豆少于"+ unit(SCZ_ZG_GOLD) +",不能申请赛场主！");
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
                socket.emit('CancelCZ', {openid:wx_info.openid,nickname:wx_info.nickname});
            }, this);
        qx_btn.attr({
            x: size.width-31,
            y: size.height-40,
            scale:0.6
        });
        qx_btn.setVisible(false);
        

        var menu = new cc.Menu(sq_btn,qx_btn);
        menu.x = 0;
        menu.y = 0;
        this.addChild(menu, 100);

        //当前赛场主
        //字体描边
        var fontDefGreenStroke = new cc.FontDefinition();
        fontDefGreenStroke.fontName = Font;
        fontDefGreenStroke.fontSize = 16;
        fontDefGreenStroke.textAlign = cc.TEXT_ALIGNMENT_CENTER;
        fontDefGreenStroke.verticalAlign = cc.VERTICAL_TEXT_ALIGNMENT_TOP;
        fontDefGreenStroke.fillStyle = cc.color(50,209,6);
        fontDefGreenStroke.strokeEnabled = true;
        fontDefGreenStroke.strokeStyle = cc.color(6,20,1);

        var sczLable = new cc.LabelTTF("当前狗庄: ", fontDefGreenStroke);
        sczLable.attr({
            x: size.width-20,
            y: size.height-80,
            anchorX:0
        });
        sczLable.setRotation(90);
        this.addChild(sczLable,200);

        var sczname = new cc.LabelTTF(SCZ.SCZName, fontDefGreenStroke);
        sczname.attr({
            x: size.width-20,
            y: size.height-155,
            anchorX:0
        });
        sczname.setRotation(90);
        this.addChild(sczname,200);

        //累计财富
        var caifuImg = new cc.Sprite(res.s_coin);
        caifuImg.attr({
            x:size.width-50,
            y:size.height-88,
            anchorX:0,
            scale:0.7
        });
        this.addChild(caifuImg,110);
        //字体描边
        var fontDefYellowStroke = new cc.FontDefinition();
        fontDefYellowStroke.fontName = Font;
        fontDefYellowStroke.fontSize = 14;
        fontDefYellowStroke.textAlign = cc.TEXT_ALIGNMENT_CENTER;
        fontDefYellowStroke.verticalAlign = cc.VERTICAL_TEXT_ALIGNMENT_TOP;
        fontDefYellowStroke.fillStyle = cc.color(253,197,2);
        fontDefYellowStroke.strokeEnabled = true;
        fontDefYellowStroke.strokeStyle = cc.color(58,28,0);

        var caifuLable = new cc.LabelTTF("场主烟豆:", fontDefYellowStroke);
        caifuLable.attr({
            x: size.width-40,
            y: size.height-100,
            anchorX:0
        });
        caifuLable.setRotation(90);
        this.addChild(caifuLable,200);

        var caifunum = new cc.LabelTTF(SCZ.SCZGold, fontDefYellowStroke);
        caifunum.attr({
            x: size.width-40,
            y: size.height-165,
            anchorX:0
        });
        caifunum.setRotation(90);
        this.addChild(caifunum,200);

        

        //声音图标
        this.musicBTN = new cc.Sprite((!allowMusic && !allowEffects)?res.s_musicbtn_off:res.s_musicbtn);
        this.musicBTN.attr({
            x: size.width-30,
            y: 80,
            scale:0.8
        });
        this.addChild(this.musicBTN,20);

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
                self.addChild(SceneUI,55);
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
                self.addChild(SettingUI,55);
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
        this.addChild(menuSetting,20);

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
            y:profile_bg.height-myavatar.height/2-10
        });


        //加载微信头像
        cc.loader.loadImg(wx_info.headimgurl, {isCrossOrigin : false }, function(err, img)
        {
            var sprite = new cc.Sprite(wx_info.headimgurl);
             sprite.x = this.width / 2;
             sprite.y = this.height / 2;
             //sprite.scale = 0.1;
             sprite.setRotation(90);
             myavatar.addChild(sprite);

        }.bind(myavatar));

       

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


        //白字黑边字体描边
        var fontDefBlackStroke = new cc.FontDefinition();
        fontDefBlackStroke.fontName = Font;
        fontDefBlackStroke.fontSize = 20;
        fontDefBlackStroke.textAlign = cc.TEXT_ALIGNMENT_CENTER;
        fontDefBlackStroke.verticalAlign = cc.VERTICAL_TEXT_ALIGNMENT_TOP;
        fontDefBlackStroke.fillStyle = cc.color(255,255,255);

        // stroke
        fontDefBlackStroke.strokeEnabled = true;
        fontDefBlackStroke.strokeStyle = cc.color(0,0,0);

        //我的金币数量
        var mygoldLable = this.myGoldLb = new cc.LabelTTF("我的烟豆:"+wx_info.total_gold,fontDefBlackStroke);
        mygoldLable.attr({
            x:profile_bg.width/2+10,
            y:profile_bg.height/2+55,
            anchorX:0,
            anchorY:1
        });
        mygoldLable.setRotation(90);
        profile_bg.addChild(mygoldLable,100,162);

        //本次金币数量
        var thisgoldLable = new cc.LabelTTF("本次烟豆:"+thisTimesgold,fontDefBlackStroke);
        thisgoldLable.attr({
            x:profile_bg.width/2-15,
            y:profile_bg.height/2+55,
            anchorX:0,
            anchorY:1
        });
        thisgoldLable.setRotation(90);
        profile_bg.addChild(thisgoldLable);

        

        this.addChild(profile_bg,50,161);

        //添加背景层的菜单按钮


        //下注层
        var SelectLayer = new cc.LayerColor(cc.color(10,10,10,100));

        var second = 30 - Number( time.seconds );

        /*//按钮旁边的时间
        var timebox = new cc.Sprite(res.s_timebox);
        timebox.attr({
            x: size.width-60,
            y: size.height/2,
            scale:0.7
        });*/

        //红字黑边字体描边
        var fontDefGreenBlackStroke = new cc.FontDefinition();
        fontDefGreenBlackStroke.fontName = Font;
        fontDefGreenBlackStroke.fontSize = 24;
        fontDefGreenBlackStroke.textAlign = cc.TEXT_ALIGNMENT_CENTER;
        fontDefGreenBlackStroke.verticalAlign = cc.VERTICAL_TEXT_ALIGNMENT_TOP;
        fontDefGreenBlackStroke.fillStyle = cc.color(255,0,0);

        // stroke
        fontDefGreenBlackStroke.strokeEnabled = true;
        fontDefGreenBlackStroke.strokeStyle = cc.color(0,0,0);

        this.longtime = new cc.LabelTTF(second, fontDefGreenBlackStroke);
        this.longtime.attr({
            x: SelectLayer.width-69,
            y: SelectLayer.height/2-30
        });
        this.longtime.setRotation(90);
        //this.longtime.setColor(cc.color(255,255,255));
        //timebox.addChild( this.longtime,5);
        SelectLayer.addChild(this.longtime,1000);

        //选择狗狗背景图
        this.selectBg = new cc.Sprite(res.s_pop3);
        this.selectBg.attr({
            x : size.width/2,
            y : size.height/2,
            scale:0.6,
            scaleX:0.58
        });


        //四只待选择的狗狗
        var dogs = new Array(this.dog12,this.dog13, this.dog14, this.dog15);
        var text_arr = [res.s_text1,res.s_text2,res.s_text3,res.s_text4];

        var heights = [0.145,0.385,0.625,0.86];
        var i = 5;//初始化狗狗编号
        for(var key in dogs) {

            var width = this.selectBg.width / 2+40;
            var height =  this.selectBg.height * heights[key];
            dogs[key] = new cc.Sprite("dog" + i + "_off.png");
            dogs[key].attr({
                bianhao: i,
                scale: 1,
                x:width,
                y:height
            });

            var text = new cc.Sprite(text_arr[i-2]);
            text.attr({
                x:150,
                y:20,
                scale:1
            });
            //text.setRotation(90);
            text.setVisible(false);
            dogs[key].addChild(text,5,3);//3是tag,用于查找元素

            //添加下注提示框


          this.selectBg.addChild(dogs[key]);

            //下注总数背景
            var betbox = new cc.Sprite(res.s_betbox_off);
            betbox.attr({
                bianhao: 'allbet'+i,
                x:width-90,
                y:height,
                scale:0.95

            });
            betbox.setAnchorPoint(0.5, 0.5);
            //全部每个狗狗下注总数
            var xiazhu = 0;
            if(i == 2) xiazhu = this.xiazahu_array.dog2;
            if(i == 3) xiazhu = this.xiazahu_array.dog3;
            if(i == 4) xiazhu = this.xiazahu_array.dog4;
            if(i == 5) xiazhu = this.xiazahu_array.dog5;
            var betLable = new cc.LabelTTF(""+ xiazhu,Font, 22);
            betLable.attr({
                x:betbox.width/2-17,
                y:betbox.height/2,
                scale:1.3
            });
            betLable.setRotation(90);
            betLable.setColor(cc.color(245,226,15));
            betbox.addChild(betLable,5,4);



            //个人每个狗狗下注总数
            var myxiazhu = "0";
            if(i == 2) myxiazhu = myselfYD.dog2;
            if(i == 3) myxiazhu = myselfYD.dog3;
            if(i == 4) myxiazhu = myselfYD.dog4;
            if(i == 5) myxiazhu = myselfYD.dog5;

            var my_betLable = new cc.LabelTTF(myxiazhu.toString(), Font, 22);
            my_betLable.attr({
                x:betbox.width/2+8,
                y:betbox.height/2,
                scale:1.3,
                bianhao: i
            });
            my_betLable.setRotation(90);
            betbox.addChild(my_betLable,5,5);

            this.selectBg.addChild(betbox,5,2);
            //this.selectBg.addChild(my_betbox,5,3);



            switch(i)
            {

                case 2:
                    this.dog12 = dogs[key];
                    break;
                case 3:
                    this.dog13 = dogs[key];
                    break;
                case 4:
                    this.dog14 = dogs[key];
                    break;
                case 5:
                    this.dog15 = dogs[key];
                    break;
                default:

            }
            i -= 1;
        }

        

        //5个下注按钮

        //按钮标志
        var bet_flag = 1;
        var bet_x = 130;
        var bet_10 = new cc.Sprite(res.s_bet_10_select);
        bet_10.attr({
            x: this.selectBg.width/2-bet_x,
            y: this.selectBg.height/2+420,
            scale:1.2,
            num:10,
            type:'bet',
        });
        this.selectedbet = bet_10;
        this.selectBg.addChild(bet_10);


        var bet_20 = new cc.Sprite(res.s_bet_20_on);
        bet_20.attr({
            x: this.selectBg.width/2-bet_x,
            y: this.selectBg.height/2+220,
            scale:1.2,
            num:20,
            type:'bet'
        });
        this.selectBg.addChild(bet_20);

        var bet_30 = new cc.Sprite(res.s_bet_30_on);
        bet_30.attr({
            x: this.selectBg.width/2-bet_x,
            y: this.selectBg.height/2+20,
            scale:1.2,
            num:30,
            type:'bet'
        });
        this.selectBg.addChild(bet_30);

        var bet_50 = new cc.Sprite(res.s_bet_50_on);
        bet_50.attr({
            x: this.selectBg.width/2-bet_x,
            y: this.selectBg.height/2-180,
            scale:1.2,
            num:50,
            type:'bet'
        });
        this.selectBg.addChild(bet_50);

        var bet_100 = new cc.Sprite(res.s_bet_100_on);
        bet_100.attr({
            x: this.selectBg.width/2-bet_x,
            y: this.selectBg.height/2-380,
            scale:1.2,
            num:100,
            type:'bet'
        });
        this.selectBg.addChild(bet_100);

        //下注按钮
        var btn_on = new cc.MenuItemImage(
            res.s_bet_btn,
            res.s_bet_btn,
            function () {
                if(!self.betStatus){
                    var tipUI = new TipUI("您已下注过！");
                    self.addChild(tipUI,100);
                    return false;
                }
                var bet = [];
                for(var k in self.mybet){
                    switch(self.mybet[k].dog){
                        case 2:
                            myselfYD.dog2 += Number(self.mybet[k].gold);
                            break;
                        case 3:
                            myselfYD.dog3 += Number(self.mybet[k].gold);
                            break;
                        case 4:
                            myselfYD.dog4 += Number(self.mybet[k].gold);
                            break;
                        case 5:
                            myselfYD.dog5 += Number(self.mybet[k].gold);
                            break;
                    }

                    if(self.mybet[k].gold > 0){
                        bet.push(self.mybet[k]);
                        //self.mybet[k].gold = 0;
                    }

                }
                
                if(bet.length == 0){
                    var tipUI = new TipUI("请选择狗狗下注!");
                    self.addChild(tipUI,100);
                }else{
                  //  postBetData(bet);
                    var comfirmBeton = new ConfirmBetUI(bet, false);
                    self.addChild(comfirmBeton,1000,168);

                    self.mybet = [{openid: wx_info.openid,dog: 2,gold: 0},{openid: wx_info.openid,dog: 3,gold: 0},{openid: wx_info.openid,dog: 4,gold: 0},{openid: wx_info.openid,dog: 5,gold: 0}];
                }
                

            }, this);
        btn_on.attr({
            x: this.selectBg.width/2-210,
            y: this.selectBg.height/2-380,
            scale:0.8,
            scaleX:1.2
        });

        //重复下注按钮
        var aginbet_btn = new cc.MenuItemImage(
            res.s_againbet_btn,
            res.s_againbet_btn,
            res.s_aginbet_btn_off,
            function () {
                if(self.betStatus){
                    if(wx_info.total_gold > 0){
                       // postBetAgain(wx_info.openid);
                        socket.emit('select_beton_again', wx_info.openid);
                        socket.on('re_select_beton_again', function(obj) {
                            cc.log(obj.status);
                            if(self.isFirstReturn){
                                self.isFirstReturn = false;
                                if(obj.status == '-1'){
                                    var tipUI = new TipUI("您上一局未下注！");
                                    self.addChild(tipUI,100);
                                }else{

                                    var total_gold = 0;
                                    for(var i in obj.result){
                                        total_gold += Number(obj.result[i].gold);
                                    }
                                    if(total_gold > wx_info.total_gold){
                                        var tipUI1 = new TipUI('您现有的烟豆少于上一局下注数\n       无法重复下注！');
                                        self.addChild(tipUI1,100);
                                    }else{
                                        var comfirmBeton = new ConfirmBetUI(obj.result, true);
                                        self.addChild(comfirmBeton,1000,168);
                                    }
                                }
                            }
                        })
                    }else{
                        var tipUI = new TipUI("烟豆不足！");
                        self.addChild(tipUI,100);
                    }
                }else{
                    var tipUI = new TipUI("您已下注过！");
                    self.addChild(tipUI,100);
                }
                    


            }, this);
        aginbet_btn.attr({
            x: this.selectBg.width/2-210,
            y: this.selectBg.height-160,
            scale:0.8,
            scaleX:1.2
        });

        var bet_menu = new cc.Menu(aginbet_btn,btn_on);
        bet_menu.x = 0;
        bet_menu.y = 0;
        this.selectBg.addChild(bet_menu, 1);

        SelectLayer.addChild(this.selectBg,10,159);

        /*//送礼物按钮

        //饼干按钮
        var cookyItem = new cc.Sprite(res.s_gift_cooky);
        cookyItem.attr({
            x:25,
            y:size.height/2+140,
            scale:0.6,
            num:gift_score.cooky,
            type:'gift',
            gift_type:'cooky'
        });
      //  SelectLayer.addChild(cookyItem);

        //骨头按钮
        var boneItem = new cc.Sprite(res.s_gift_bone);
        boneItem.attr({
            x:25,
            y:size.height/2+70,
            scale:0.6,
            num:gift_score.bone,
            type:'gift',
            gift_type:'bone'
        });
      //  SelectLayer.addChild(boneItem);

        //星星按钮
        var starItem = new cc.Sprite(res.s_gift_star);
        starItem.attr({
            x:25,
            y:size.height/2,
            scale:0.6,
            num:gift_score.star,
            type:'gift',
            gift_type:'star'
        });
      //  SelectLayer.addChild(starItem);

        //棒棒糖按钮
        var lollyItem = new cc.Sprite(res.s_gift_lolly);
        lollyItem.attr({
            x:25,
            y:size.height/2-70,
            scale:0.6,
            num:gift_score.lolly,
            type:'gift',
            gift_type:'lolly'
        });
      //  SelectLayer.addChild(lollyItem);

        //铃铛按钮
        var bellItem = new cc.Sprite(res.s_gift_bell);
        bellItem.attr({
            x:25,
            y:size.height/2-140,
            scale:0.6,
            num:gift_score.bell,
            type:'gift',
            gift_type:'bell'
        });
      //  SelectLayer.addChild(bellItem);

        //花按钮
        var flowerItem = new cc.Sprite(res.s_gift_flower);
        flowerItem.attr({
            x:25,
            y:size.height/2-210,
            scale:0.6,
            num:gift_score.flower,
            type:'gift',
            gift_type:'flower'
        });
     //   SelectLayer.addChild(flowerItem);*/


        var CZTips = new cc.LabelTTF("烟豆不足"+ unit(SCZ_ZG_GOLD) +",不能申请赛场主", fontDefYellowStroke);
        CZTips.attr({
            x: size.width-45,
            y: 200
        });
        CZTips.setRotation(90);
        SelectLayer.addChild(CZTips,5);


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
        SelectLayer.addChild(onlineCount,5);

        this.addChild(SelectLayer,10,160);


        //创建选择狗狗点击事件

        var listener1 = cc.EventListener.create({
            event: cc.EventListener.TOUCH_ONE_BY_ONE,
            swallowTouches: true,                       // 设置是否吞没事件，在 onTouchBegan 方法返回 true 时吞掉事件，不再向下传递。
            onTouchBegan: function (touch, event) {     //实现 onTouchBegan 事件处理回调函数
                var target = event.getCurrentTarget();
                //   if (!target.activate) return;
                // 获取当前触摸点相对于按钮所在的坐标
                var locationInNode = target.convertToNodeSpace(touch.getLocation());
                var s = target.getContentSize();
                var rect = cc.rect(0, 0, s.width, s.height);
                if (cc.rectContainsPoint(rect, locationInNode)) {       // 判断触摸点是否在按钮范围内
                    var mybianhao = target.bianhao; //获取当前选择狗狗对应的下注背景

                    var num = self.selectedbet.num;//获取当前选择按钮的扣除烟豆数量
                    var type = self.selectedbet.type;//获取当前选择按钮的类型下注或送礼
                     //播放狗狗声音
                   // cc.audioEngine.playEffect(res.s_time_shout_mp3,false);
                    if(allowEffects){
                        cc.audioEngine.playEffect(res.s_woof_mp3,false);
                    }
                    //提示已经下注不能再下注
                    if(!self.betStatus){
                        var tipUI = new TipUI("您已下注过！");
                        self.addChild(tipUI,100);
                        return false;
                    }


                    var childrens = self.selectBg.getChildren();

                    for(var child in childrens){
                        if(childrens[child].bianhao == 'allbet'+mybianhao){

                            if(self.selected != null){
                                self.selected.initWithFile("dog"+self.selected.bianhao+"_off.png");
                                self.selectedbox.initWithFile(res.s_betbox_off);
                            }
                            target.initWithFile("dog"+target.bianhao+"_on.png");
                            childrens[child].initWithFile(res.s_betbox_on);
                            self.selected = target;
                            self.selectedbox = childrens[child];
                        }

                    }

                    //下注
                    if(type == 'bet'){

                        if(wx_info.openid == SCZ.SCZOpenid){
                            var tipUI = new TipUI("狗庄不能下注哦！");
                            self.addChild(tipUI,100);
                            return;

                        }


                        if(self.mygold < num){
                            var tipUI = new TipUI("烟豆不足！");
                            self.addChild(tipUI,100);
                            return;
                        }
                        var bianhao = self.selected.bianhao;
                        //var newbet = [{openid: wx_info.openid,dog: bianhao,gold: num}];
						//self.betStatus = false;

                        for(var k in self.mybet){
                            if(self.mybet[k].dog == bianhao){
                                self.mybet[k].gold += Number(num);
                                self.mygold -= Number(num);
                                /*switch(bianhao){
                                    case 2:
                                        myselfYD.dog2 += Number(num);
                                        break;
                                    case 3:
                                        myselfYD.dog3 += Number(num);
                                        break;
                                    case 4:
                                        myselfYD.dog4 += Number(num);
                                        break;
                                    case 5:
                                        myselfYD.dog5 += Number(num);
                                        break;
                                }*/
                                //postBetData(newbet);

                                var my_betLable = self.selectedbox.getChildByTag(5);//我的下注
                                var my_bet = Number(my_betLable.getString());

                                my_betLable.setString(self.unit(my_bet + num));
                              //  wx_info.total_gold -= Number(num);
                              //  mygoldLable.setString('我的烟豆:'+wx_info.total_gold);
                            }
                        }
                    }else if(type == 'gift'){//送礼
                        if(self.mygold < num){
                            var tipUI = new TipUI("烟豆不足！");
                            self.addChild(tipUI,100);
                            return;
                        }
                        var send_obj = {openid:wx_info.openid,dog:self.selected.bianhao,gift_type:self.selectedbet.gift_type,gold:num};

                        var  Confirmlayer = new ConfirmUI(send_obj);
                        self.addChild( Confirmlayer,100);
                        self.isSetGift = true;
                    }



                    /**/
                    return true;
                }
                return false;
            },

        });

        // 添加监听器到管理器
        cc.eventManager.addListener(listener1, dogs[0]);
        cc.eventManager.addListener(listener1.clone(), dogs[1]);
        cc.eventManager.addListener(listener1.clone(), dogs[2]);
        cc.eventManager.addListener(listener1.clone(), dogs[3]);

        //创建下注、送礼按钮点击事件

        var listener2 = cc.EventListener.create({
            event: cc.EventListener.TOUCH_ONE_BY_ONE,
            swallowTouches: true,                       // 设置是否吞没事件，在 onTouchBegan 方法返回 true 时吞掉事件，不再向下传递。
            onTouchBegan: function (touch, event) {     //实现 onTouchBegan 事件处理回调函数
                var target = event.getCurrentTarget();
                //   if (!target.activate) return;
                // 获取当前触摸点相对于按钮所在的坐标
                var locationInNode = target.convertToNodeSpace(touch.getLocation());
                var s = target.getContentSize();
                var rect = cc.rect(0, 0, s.width, s.height);
                if (cc.rectContainsPoint(rect, locationInNode)) {       // 判断触摸点是否在按钮范围内
                    var num = target.num; //获取当前选择按钮的下注数
                    var type = target.type; //获取当前选择按钮类型
                    if(self.selectedbet.type == 'bet'){
                        if(self.selectedbet != null){
                            self.selectedbet.initWithFile("bet_"+self.selectedbet.num+"_on.png");
                        }
                    }else if(self.selectedbet.type == 'gift'){
                        if(self.selectedbet != null){
                            var respath = '';
                            switch(self.selectedbet.gift_type){
                                case 'cooky':
                                    respath = res.s_gift_cooky;
                                    break;
                                case 'bone':
                                    respath = res.s_gift_bone;
                                    break;
                                case 'star':
                                    respath = res.s_gift_star;
                                    break;
                                case 'lolly':
                                    respath = res.s_gift_lolly;
                                    break;
                                case 'bell':
                                    respath = res.s_gift_bell;
                                    break;
                                case 'flower':
                                    respath = res.s_gift_flower;
                                    break;
                            }
                            self.selectedbet.initWithFile(respath);
                        }
                    }
                    if(type == 'bet'){
                        
                        target.initWithFile("bet_"+num+"_select.png");
                    }else if(type == 'gift'){
                        var respath = '';
                        switch(target.gift_type){
                            case 'cooky':
                                respath = res.s_gift_cooky_select;
                                break;
                            case 'bone':
                                respath = res.s_gift_bone_select;
                                break;
                            case 'star':
                                respath = res.s_gift_star_select;
                                break;
                            case 'lolly':
                                respath = res.s_gift_lolly_select;
                                break;
                            case 'bell':
                                respath = res.s_gift_bell_select;
                                break;
                            case 'flower':
                                respath = res.s_gift_flower_select;
                                break;
                        }

                        target.initWithFile(respath);
                    }
                        
                    self.selectedbet = target;
                    
                    

                    /**/
                    return true;
                }
                return false;
            },

        });

        // 添加监听器到管理器
        cc.eventManager.addListener(listener2, bet_10);
        cc.eventManager.addListener(listener2.clone(), bet_20);
        cc.eventManager.addListener(listener2.clone(), bet_30);
        cc.eventManager.addListener(listener2.clone(), bet_50);
        cc.eventManager.addListener(listener2.clone(), bet_100);
        /*cc.eventManager.addListener(listener2.clone(), cookyItem);
        cc.eventManager.addListener(listener2.clone(), boneItem);
        cc.eventManager.addListener(listener2.clone(), starItem);
        cc.eventManager.addListener(listener2.clone(), lollyItem);
        cc.eventManager.addListener(listener2.clone(), bellItem);
        cc.eventManager.addListener(listener2.clone(), flowerItem);*/


        this.timeLeft = time.seconds;

        //监听全部下注数的变化

        var self = this;

        socket.on('beton_return', function(o){
            cc.log(o);
            for(var i in o){
				if(o[i] == null) continue;
                switch(o[i].dog){
                    case 2:
                        var gold = self.getboxBybianhao('allbet2').getChildByTag(4).getString();
                        self.getboxBybianhao('allbet2').getChildByTag(4).setString(Number(gold) + Number(o[i].gold));
                        sumYD.dog2 = Number(gold) + Number(o[i].gold);
                        break;
                    case 3:
                        var gold = self.getboxBybianhao('allbet3').getChildByTag(4).getString();
                        self.getboxBybianhao('allbet3').getChildByTag(4).setString(Number(gold) + Number(o[i].gold));
                        sumYD.dog3 = Number(gold) + Number(o[i].gold);
                        break;
                    case 4:
                        var gold = self.getboxBybianhao('allbet4').getChildByTag(4).getString();
                        self.getboxBybianhao('allbet4').getChildByTag(4).setString(Number(gold) + Number(o[i].gold));
                        sumYD.dog4 = Number(gold) + Number(o[i].gold);
                        break;
                    case 5:
                        var gold = self.getboxBybianhao('allbet5').getChildByTag(4).getString();
                        self.getboxBybianhao('allbet5').getChildByTag(4).setString(Number(gold) + Number(o[i].gold));
                        sumYD.dog5 = Number(gold) + Number(o[i].gold);
                        break;
                }
            }
            if(o[0].openid == wx_info.openid){
                 mygoldLable.setString('我的烟豆:'+self.mygold);
                wx_info.total_gold = self.mygold;
            }
        });

        
        socket.on('set_gift', function(o){
                self.addGift(o.dog, o.gift_type);

            //如果是送礼本人就扣除其相应的烟豆
            if(wx_info.openid == o.openid){
                if(o.status == 1 && self.isSetGift) {
                    self.isSetGift = false;
                    self.mygold -= Number(o.gold);
                    wx_info.total_gold -= Number(o.gold);

                    self.myGoldLb.setString("我的烟豆:"+wx_info.total_gold);
                }

            }

            
        });
		
		//监听在线人数事件
        socket.on('onlineCount', function(o){
            onlineCount.setString("在线人数:"+o.onlineCount);
            CurrOnlineCount = o.onlineCount;

            
        });

        socket.on('beton_again_return_'+wx_info.openid, function(o){

            if(o.dog2 == '-1'){
                var tipUI1 = new TipUI('您现有的烟豆少于上一局下注数\n       无法重复下注！');
                self.addChild(tipUI1,100);
                return ;
            }
            var again = 0; //有上一轮的下注才显示“重复下注成功”
            var text_tip = "您上一局未下注！";
            var sum = 0;//上一局下注总数
            for(var bet in o){
                switch(bet){
                    case 'dog2':
                        if(o[bet] != null){
                            again ++;
                            self.getboxBybianhao('allbet2').getChildByTag(5).setString(o[bet]);
                            myselfYD.dog2 = Number(o[bet]);//赋值给个人下注
                            for(key in self.mybet){
                                if(self.mybet[key].dog == 2){
                                    self.mybet[key].gold = Number(o[bet]);
                                }
                            }
                            self.dog12.initWithFile("dog"+self.dog12.bianhao+"_on.png");
                            self.betStatus = false;
                            sum += Number(o[bet]);
                        }
                        break;
                    case 'dog3':
                        if(o[bet] != null){
                            again ++;
                            self.getboxBybianhao('allbet3').getChildByTag(5).setString(o[bet]);
                            myselfYD.dog3 = Number(o[bet]);//赋值给个人下注 
                            for(key in self.mybet){
                                if(self.mybet[key].dog == 3){
                                    self.mybet[key].gold = Number(o[bet]);
                                }
                            }
                            self.dog13.initWithFile("dog"+self.dog13.bianhao+"_on.png");                         
                            self.betStatus = false;
                            sum += Number(o[bet]);
                        }
                        break;
                    case 'dog4':
                        if(o[bet] != null){
                            again ++;
                            self.getboxBybianhao('allbet4').getChildByTag(5).setString(o[bet]);
                            myselfYD.dog4 = Number(o[bet]);//赋值给个人下注
                            for(key in self.mybet){
                                if(self.mybet[key].dog == 4){
                                    self.mybet[key].gold = Number(o[bet]);
                                }
                            }
                            self.dog14.initWithFile("dog"+self.dog14.bianhao+"_on.png");
                            self.betStatus = false;
                            sum += Number(o[bet]);
                        }
                        break;
                    case 'dog5':
                        if(o[bet] != null){
                            again ++;
                            self.getboxBybianhao('allbet5').getChildByTag(5).setString(o[bet]);
                            myselfYD.dog5 = Number(o[bet]);//赋值给个人下注
                            for(key in self.mybet){
                                if(self.mybet[key].dog == 5){
                                    self.mybet[key].gold = Number(o[bet]);
                                }
                            }
                            self.dog15.initWithFile("dog"+self.dog15.bianhao+"_on.png");
                            self.betStatus = false;
                            sum += Number(o[bet]);
                        }

                        break;
                }


            }

            if(again){
                self.beton_again_sum = sum;
                text_tip = "重复下注成功!";
                sq_btn.setEnabled(false);

                    
            }
            var tipUI = new TipUI(text_tip);
            self.addChild(tipUI,100);


        });

        //返回新的总烟豆
        socket.on('getsumDY_'+wx_info.openid, function(o) {

            wx_info.total_gold = o.new_gold == 0 ? "0" : o.new_gold;
            wx_info.total_gold -= self.beton_again_sum;
            if(o.new_gold < 1) wx_info.total_gold = '0';
            mygoldLable.setString('我的烟豆:'+wx_info.total_gold);
            
        });

        socket.on('CurrSCZ', function(o){
            SCZ = o;
            sczname.setString(SCZ.SCZName);
            caifunum.setString(SCZ.SCZGold);

            if(wx_info.openid == SCZ.SCZOpenid){

                qx_btn.setVisible(true);
                sq_btn.setEnabled(false);

                aginbet_btn.setEnabled(false);
            }else{
                qx_btn.setVisible(false);
                sq_btn.setEnabled(true);
                aginbet_btn.setEnabled(true);
            }


        });


        if(wx_info.openid == SCZ.SCZOpenid){

            //判断是否够五百万，不够就自动取消赛场主
            if(wx_info.total_gold < SCZ_ZG_GOLD){
                socket.emit('CancelCZ', {openid:wx_info.openid,nickname:wx_info.nickname});
            }
            qx_btn.setVisible(true);
            sq_btn.setEnabled(false);
            aginbet_btn.setEnabled(false);
        }

        //小喇叭
        var XLB_bg = new cc.Sprite(res.s_notice);
        XLB_bg.attr({
            x:size.width-30,
            y:size.height/2+120,
            scale:0.5
        });
        this.addChild(XLB_bg,40);

        var bgSize = cc.size(34,220);

        var scrollView = new ccui.ScrollView();
        scrollView.setDirection(ccui.ScrollView.DIR_VERTICAL);
        scrollView.setTouchEnabled(true);
        scrollView.setContentSize(cc.size(bgSize.width,bgSize.height-10));
        scrollView.x = size.width-38;
        scrollView.y = size.height/ 2;
        scrollView.setAnchorPoint(0,0.5);
        this.addChild(scrollView,40);

        
        //小喇叭字体描边
        var fontDefXLBStroke = new cc.FontDefinition();
        fontDefXLBStroke.fontName = Font;
        fontDefXLBStroke.fontSize = 16;
        fontDefXLBStroke.textAlign = cc.TEXT_ALIGNMENT_CENTER;
        fontDefXLBStroke.verticalAlign = cc.VERTICAL_TEXT_ALIGNMENT_TOP;
        fontDefXLBStroke.fillStyle = cc.color(255,0,0);
        // stroke
        fontDefXLBStroke.strokeEnabled = true;
        fontDefXLBStroke.strokeStyle = cc.color(245,226,15);

        //监听下喇叭内容
        socket.on("XLB",function(o){
            scrollView.removeAllChildren();
            var text = new cc.LabelTTF(o.text,fontDefXLBStroke);
            text.attr({
                x:scrollView.width/2,
                y:-scrollView.height,
                anchorX:1,
                anchorY:1
            });
            text.setRotation(90);
            scrollView.addChild(text);
            textSize = text.getContentSize();

            scrollView.setInnerContainerSize(cc.size(textSize.height,textSize.width+scrollView.width));

            //添加文字滚动动作
            var actionMove = cc.MoveTo.create(8,cc.p(scrollView.width/2,text.height+textSize.width+10));
            var actionMoveDone = cc.CallFunc.create(function(){
                text.setPosition(scrollView.width/2,-scrollView.height);
            },this);
            text.runAction(cc.RepeatForever.create(cc.Sequence.create(actionMove,actionMoveDone)));

        });


        this.scheduleUpdate();
        this.schedule(this.updateLongTime,1);
        this.schedule(this.addText,1.5);
        return true;
    },
    update : function() {
        this.musicBTN.initWithFile((!allowMusic && !allowEffects)?res.s_musicbtn_off:res.s_musicbtn);
        
        
    },
    getboxBybianhao:function(bianhao){
        var childrens = this.selectBg.getChildren();

        for(var child in childrens){
            if(childrens[child].bianhao == bianhao){
                return childrens[child];
            }

        }
        return false;
    },
    updateLongTime:function(){
        this.timeLeft ++;
        var seconds = 30 - this.timeLeft;
        if(seconds < 0){
            seconds = 0;
        }
        if(seconds < 5 || seconds == 5){
            if(allowEffects){
                cc.audioEngine.playEffect(res.s_time_shout_mp3,false);
            }
        }


        this.longtime.setString(seconds);
         

    },
    addGift:function(dog,giftIndex){
        var JinEbg = this.selectBg.getChildByTag(2);
        var giftObj = {cooky:res.s_gift_cooky_samll,bone:res.s_gift_bone_samll,star:res.s_gift_star_samll,lolly:res.s_gift_lolly_samll,bell:res.s_gift_bell_samll,flower:res.s_gift_flower_samll};
        //四只待选择的狗狗
        var dogs = new Array(this.dog12,this.dog13, this.dog14, this.dog15);
        for(var key in dogs) {
            if( dogs[key].bianhao == dog ){
                var width = dogs[key].width * Math.random()*0.8;
                var height = dogs[key].height * Math.random()  ;
                var new_height = height + 50;

                if( new_height >  (dogs[key].height-20) ) new_height -= 80;
                var gift = new cc.Sprite(giftObj[giftIndex]);
                gift.attr({
                    x:new_height  ,
                    y:width,
                    // scale:0.8
                });
                dogs[key].addChild(gift);
            }
        }
    },
    addText:function(){
        var dogs = new Array(this.dog12,this.dog13, this.dog14, this.dog15);
        var dog = dogs[Math.floor(Math.random()*dogs.length)];

        dog.getChildByTag(3).setVisible(true);
        for(var key in dogs){
            if(dogs[key].bianhao != dog.bianhao){
                dogs[key].getChildByTag(3).setVisible(false);
            }
        }
    },
    unit:function(number) {
        
        var w = 10000, 
            sizes = '万',//['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
            i = Math.floor(Math.log(number) / Math.log(w));
        if (number < w) return number;

        var res = (number / Math.pow(w, i));
        if( (number % w) == 0 ){
            return res+ '' + sizes;;
        }
        if(number >= 100000){
            return res.toPrecision(4) + '' + sizes;//sizes[i];
        }

        return res.toPrecision(3) + '' + sizes;//sizes[i];
    },onEnter:function(){
        this._super();
        var self = this;


    },onExit:function(){
        this._super();

    }
});

var ChooseScene = cc.Scene.extend({
    _time:null,
    _xiazahu_arrays:null,
    ctor:function(time,xiazahu_arrays){
        this._super();
        this._time = time;
        this._xiazahu_arrays = xiazahu_arrays;
    },
    onEnter:function () {
        this._super();
        var layer = new ChooseLayer(this._time,this._xiazahu_arrays);
        this.addChild(layer);
    }
});

