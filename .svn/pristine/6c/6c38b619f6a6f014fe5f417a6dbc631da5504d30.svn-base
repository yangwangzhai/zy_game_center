/**
 * Created by Administrator on 2016/4/4 0004.
 */

var HelpLayer = cc.Layer.extend({
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
    timeLabel : null,
    timeLeft : null,
    mybet:[],
    betStatus:true,
    selectedbox:null,
    selectBg:null,
    mygold:null,
    myGoldLb:null,
    musicBTN : null,
    longtime:null,
    step:1,
    TipsLayer:null,
    ctor:function () {
        //////////////////////////////
        // 1. super init first
        this._super();
        var self = this;


        this.mygold = wx_info.total_gold;

        
        
        var size = cc.winSize;
        var ssColor = cc.color(171,106,28);//深色
        //添加背景
        var runbg = new cc.Sprite(scene_bg);
        
        runbg.setAnchorPoint(0, 1);
        runbg.setPosition(0, size.height);
        runbg.setScale(0.65);
        runbg.setTag(10);
        //this.sprite.setRotation(270);
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
            //cc.log(width);
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
                /*cc.log("ApplyCZ  is clicked!");
                if(wx_info.total_gold < SCZ_ZG_GOLD){
                    var tipUI = new TipUI("烟豆少于5W,不能申请赛场主！");
                    this.addChild(tipUI,100);
                    return;
                }
                cc.log({openid:wx_info.openid,nickname:wx_info.nickname});
                socket.emit('ApplyCZ', {openid:wx_info.openid,nickname:wx_info.nickname});
                var tipUI = new TipUI("申请赛场主成功！");
                    this.addChild(tipUI,100);*/

            }, this);
        sq_btn.attr({
            x: size.width-30,
            y: size.height-40,
            scale:0.6
        });

        
        

        var menu = new cc.Menu(sq_btn);
        menu.x = 0;
        menu.y = 0;
        this.addChild(menu, 20);

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
        this.addChild(sczLable,20);

        var sczname = new cc.LabelTTF(SCZ.SCZName, fontDefGreenStroke);
        sczname.attr({
            x: size.width-20,
            y: size.height-155,
            anchorX:0
        });
        sczname.setRotation(90);
        //sczname.setColor(cc.color(255,255,255));
        this.addChild(sczname,20);

        //累计财富
        var caifuImg = new cc.Sprite(res.s_coin);
        caifuImg.attr({
            x:size.width-50,
            y:size.height-88,
            anchorX:0,
            scale:0.7
        });
        this.addChild(caifuImg,20);
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
        this.addChild(caifuLable,20);

        var caifunum = new cc.LabelTTF(SCZ.SCZGold, fontDefYellowStroke);
        caifunum.attr({
            x: size.width-40,
            y: size.height-165,
            anchorX:0
        });
        caifunum.setRotation(90);
        //caifunum.setColor(cc.color(255,255,255));
        this.addChild(caifunum,20);

        

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
                            
                            if(obj.time > 25 && obj.time < 40){
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
        //fontDefBlackStroke.boundingWidth = size.width;
        //fontDefBlackStroke.boundingHeight = size.height;
        // stroke
        fontDefBlackStroke.strokeEnabled = true;
        fontDefBlackStroke.strokeStyle = cc.color(0,0,0);

        cc.log(wx_info);

        //我的金币数量
        var mygoldLable = this.myGoldLb = new cc.LabelTTF("我的烟豆:"+wx_info.total_gold,fontDefBlackStroke);
        mygoldLable.attr({
            x:profile_bg.width/2+10,
            y:profile_bg.height/2+55,
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
            y:profile_bg.height/2+55,
            anchorX:0,
            anchorY:1
        });
        thisgoldLable.setRotation(90);
        //thisgoldLable.setColor(cc.color(220,220,220));
        profile_bg.addChild(thisgoldLable);

        

        this.addChild(profile_bg,50);

        //添加背景层的菜单按钮


        //下注层
        var SelectLayer = new cc.LayerColor(cc.color(10,10,10,100));

        
        

        //按钮旁边的时间
        /*var timebox = new cc.Sprite(res.s_timebox);
        timebox.attr({
            x: size.width-20,
            y: size.height/2-75,
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

        this.longtime = new cc.LabelTTF('30', fontDefGreenBlackStroke);
        this.longtime.attr({
            x: SelectLayer.width-69,
            y: SelectLayer.height/2-30
        });
        this.longtime.setRotation(90);
        //this.longtime.setColor(cc.color(255,255,255));
        //timebox.addChild( this.longtime,5);
        SelectLayer.addChild(this.longtime,10);

        //选择狗狗背景图
        this.selectBg = new cc.Sprite(res.s_help_pop3);
        this.selectBg.attr({
            x : size.width/2,
            y : size.height/2,
            scale:0.6,
            scaleX:0.58
        });

        
        
        

        //重复下注按钮
        var aginbet_btn = new cc.MenuItemImage(
            res.s_againbet_btn,
            res.s_againbet_btn,
            function () {
                


            }, this);
        aginbet_btn.attr({
            x: this.selectBg.width/2-215,
            y: this.selectBg.height-160,
            scale:0.8
        });

        var bet_menu = new cc.Menu(aginbet_btn);
        bet_menu.x = 0;
        bet_menu.y = 0;
        this.selectBg.addChild(bet_menu, 1);

        SelectLayer.addChild(this.selectBg);




        var CZTips = new cc.LabelTTF("烟豆不足"+ unit(SCZ_ZG_GOLD) +",不能申请赛场主", fontDefYellowStroke);
        CZTips.attr({
            x: size.width-45,
            y: 200
        });
        CZTips.setRotation(90);
        //CZTips.setColor(cc.color(255,203,25));
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
        //onlineCount.setColor(cc.color(255,203,25));
        SelectLayer.addChild(onlineCount,5);

        this.addChild(SelectLayer,10);

        var self = this;

        this.TipsLayer = new cc.LayerColor(cc.color(5,5,5,150));

        //四只待选择的狗狗
        var dogs = new Array(this.dog12,this.dog13, this.dog14, this.dog15);
        var text_arr = [res.s_text1,res.s_text2,res.s_text3,res.s_text4];

        //var heights = [0.179,0.395,0.608,0.82];
        var heights = [-243,-80,82,243];
        var i = 5;//初始化狗狗编号
        for(var key in dogs) {

            var width = this.TipsLayer.width / 2+21;
            var height =  this.TipsLayer.height/2 + heights[key];
            dogs[key] = new cc.Sprite("dog" + i + "_off.png");
            dogs[key].attr({
                bianhao: i,
                scaleX: 0.589,
                scaleY: 0.59,
                x:width,
                y:height
            });

            var text = new cc.Sprite(text_arr[i-2]);
            text.attr({
                x:150,
                y:20,
                scale:0.589
            });
            //text.setRotation(90);
            text.setVisible(false);
            dogs[key].addChild(text,5,3);//3是tag,用于查找元素


            this.TipsLayer.addChild(dogs[key],-10);

            //下注总数背景
            var betbox = new cc.Sprite(res.s_betbox_off);
            betbox.attr({
                bianhao: 'allbet'+i,
                x:width-50,
                y:height,
                scale:0.95*0.589

            });
            betbox.setAnchorPoint(0.5, 0.5);
            
            var betLable = new cc.LabelTTF("0",Font, 22);
            betLable.attr({
                x:betbox.width/2-17,
                y:betbox.height/2,
                scale:1.3
            });
            betLable.setRotation(90);
            betLable.setColor(cc.color(245,226,15));
            betbox.addChild(betLable,5,4);
            this.TipsLayer.addChild(betbox,-5,2);

            
            //个人每个狗狗下注总数
            var my_betLable = new cc.LabelTTF("0",Font, 22);
            my_betLable.attr({
                x:betbox.width/2+8,
                y:betbox.height/2,
                scale:1.3
            });
            my_betLable.setRotation(90);
            betbox.addChild(my_betLable,5,5);
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


        var bet_10_1 = new cc.Sprite(res.s_bet_10_select);
        bet_10_1.attr({
            x: this.TipsLayer.width/2-82,
            y: this.TipsLayer.height/2+253,
            scale:0.7,
            num:10,
            type:'bet',
        });
        this.TipsLayer.addChild(bet_10_1);

        var bet_20_1 = new cc.Sprite(res.s_bet_20_on);
        bet_20_1.attr({
            x: this.TipsLayer.width/2-82,
            y: this.TipsLayer.height/2+135,
            scale:0.7,
            num:10,
            type:'bet',
        });
        this.TipsLayer.addChild(bet_20_1);

        var bet_30_1 = new cc.Sprite(res.s_bet_30_on);
        bet_30_1.attr({
            x: this.TipsLayer.width/2-82,
            y: this.TipsLayer.height/2+13,
            scale:0.7,
            num:10,
            type:'bet',
        });
        this.TipsLayer.addChild(bet_30_1);

        var bet_50_1 = new cc.Sprite(res.s_bet_50_on);
        bet_50_1.attr({
            x: this.TipsLayer.width/2-82,
            y: this.TipsLayer.height/2-108,
            scale:0.7,
            num:10,
            type:'bet',
        });
        this.TipsLayer.addChild(bet_50_1);

        var bet_100_1 = new cc.Sprite(res.s_bet_100_on);
        bet_100_1.attr({
            x: this.TipsLayer.width/2-82,
            y: this.TipsLayer.height/2-230,
            scale:0.7,
            num:10,
            type:'bet',
        });
        this.TipsLayer.addChild(bet_100_1);

        //送礼物按钮

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
        //this.TipsLayer.addChild(cookyItem,-5);

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
        //this.TipsLayer.addChild(boneItem,-5);

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
        //this.TipsLayer.addChild(starItem,-5);

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
        //this.TipsLayer.addChild(lollyItem,-5);

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
        //this.TipsLayer.addChild(bellItem,-5);

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
        //this.TipsLayer.addChild(flowerItem,-5);

        var step01 = new cc.Sprite(res.s_step01);
        step01.attr({
            x:this.TipsLayer.width/2-30,
            y:this.TipsLayer.height/2+40,
            scale:0.8
        });
        this.TipsLayer.addChild(step01,10);

        var step02 = new cc.Sprite(res.s_step02);
        step02.attr({
            x:this.TipsLayer.width/2+100,
            y:this.TipsLayer.height/2+40,
            scale:0.8
        });
        step02.setVisible(false);
        this.TipsLayer.addChild(step02,10);

        var step03 = new cc.Sprite(res.s_step03);
        step03.attr({
            x:200,
            y:this.TipsLayer.height/2-20,
            scale:0.8
        });
        step03.setVisible(false);
        this.TipsLayer.addChild(step03,10);

        var step04 = new cc.Sprite(res.s_step04);
        step04.attr({
            x:this.TipsLayer.width-70,
            y:this.TipsLayer.height-50,
            scale:0.8,
            anchorY:1,
            anchorX:0.5
        });
        step04.setVisible(false);
        this.TipsLayer.addChild(step04,10);

        //和一号狗对比提示
        var Tips_dog1 = new cc.Sprite(res.s_help_dog1);
        Tips_dog1.attr({
            x : this.TipsLayer.width-95,
            y : this.TipsLayer.height/2-115,
            scale:0.6,
            scaleX:0.58
        });
        this.TipsLayer.addChild(Tips_dog1,-5);

        var step05 = new cc.Sprite(res.s_step05);
        step05.attr({
            x:this.TipsLayer.width-155,
            y:this.TipsLayer.height/2,
            scale:0.8,
        });
        step05.setVisible(false);
        this.TipsLayer.addChild(step05,10);

        //赔率提示
        var Tips_pl = new cc.Sprite(res.s_help_pl);
        Tips_pl.attr({
            x : this.TipsLayer.width-130,
            y : this.TipsLayer.height/2-15,
            scale:0.6,
            scaleX:0.58
        });
        this.TipsLayer.addChild(Tips_pl,-5);

        var step06 = new cc.Sprite(res.s_step06);
        step06.attr({
            x:this.TipsLayer.width-230,
            y:this.TipsLayer.height/2,
            scale:0.8,
        });
        step06.setVisible(false);
        this.TipsLayer.addChild(step06,10);

        var step07 = new cc.Sprite(res.s_step07);
        step07.attr({
            x:130,
            y:this.TipsLayer.height/2,
            scale:0.8,
        });
        step07.setVisible(false);
        this.TipsLayer.addChild(step07,10);

        //下注按钮
        var btn_on_tops = new cc.Sprite(res.s_bet_btn);
        btn_on_tops.attr({
            x:115,
            y:this.TipsLayer.height/2-228,
            scale:0.48
        });
        this.TipsLayer.addChild(btn_on_tops,-5);


        var next_btn = new cc.MenuItemImage(
            res.s_nextbtn,
            res.s_nextbtn,
            function(){
                cc.log('next_btn is clicked');
                self.step++;
                switch(self.step){
                    case 2:
                        bet_10_1.setLocalZOrder(-10);
                        bet_20_1.setLocalZOrder(-10);
                        bet_30_1.setLocalZOrder(-10);
                        bet_50_1.setLocalZOrder(-10);
                        bet_100_1.setLocalZOrder(-10);
                        step01.setVisible(false);

                        self.dog13.initWithFile("dog3_on.png");
                        for(var i=2;i<6;i++){
                            var betbox1 = self.getboxBybianhao("allbet"+i);
                            betbox1.setLocalZOrder(15);
                        }
                        
                        self.dog12.setLocalZOrder(10);
                        self.dog13.setLocalZOrder(10);
                        self.dog14.setLocalZOrder(10);
                        self.dog15.setLocalZOrder(10);
                        step02.setLocalZOrder(10);
                        step02.setVisible(true);
                        break;
                    case 3:
                        
                        self.dog13.initWithFile("dog3_off.png");
                        for(var i=2;i<6;i++){
                            var betbox1 = self.getboxBybianhao("allbet"+i);
                            betbox1.setLocalZOrder(-10);
                        }
                        self.dog12.setLocalZOrder(-15);
                        self.dog13.setLocalZOrder(-15);
                        self.dog14.setLocalZOrder(-15);
                        self.dog15.setLocalZOrder(-15);
                        step02.setVisible(false);
                        bet_10_1.initWithFile(res.s_bet_10_on);

                        btn_on_tops.setLocalZOrder(10);
                        step03.setVisible(true);
                        break;
                    case 4:
                        
                        btn_on_tops.setLocalZOrder(-5);
                        step03.setVisible(false);

                        Tips_dog1.setLocalZOrder(10);
                        step05.setVisible(true);
                        break;
                    case 5:
                        
                        Tips_dog1.setLocalZOrder(-10);
                        step05.setVisible(false);

                        step06.setVisible(true);
                        Tips_pl.setLocalZOrder(10);
                        break;
                    case 6:
                        
                        Tips_pl.setLocalZOrder(-10);
                        step06.setVisible(false);

                        step04.setVisible(true);
                        menu.setLocalZOrder(150);
                        break;
                    case 7:
                        
                        menu.setLocalZOrder(20);
                        step04.setVisible(false);

                        step07.setVisible(true);
                        next_btn.setVisible(false);
                        known_btn.setVisible(true);
                        break;
                }

            });
        next_btn.attr({
            x:40,
            y:70,
            scale:0.8
        });

        var known_btn = new cc.MenuItemImage(
            res.s_knownbtn,
            res.s_knownbtn,
            function(){
                cc.log('known_btn is clicked');
				loginInfo.is_read_rule = true;
                cc.director.runScene(new WaitingScene());
                

            });
        known_btn.attr({
            x:40,
            y:70,
            scale:0.8
        });
        known_btn.setVisible(false);

        var btn_menu = new cc.Menu(next_btn,known_btn);
        btn_menu.attr({
            x:0,
            y:0,
        });
        this.TipsLayer.addChild(btn_menu);



        this.addChild(this.TipsLayer,50);



        

        //监听在线人数事件
        socket.on('onlineCount', function(o){
            onlineCount.setString("在线人数:"+o.onlineCount);
            CurrOnlineCount = o.onlineCount;

            
        });

        socket.emit('login', {openid:wx_info.openid,nickname:wx_info.nickname,headimgurl:wx_info.headimgurl,sex:wx_info.sex});

        socket.on('CurrSCZ', function(o){
            cc.log(o);
            SCZ = o;
            sczname.setString(SCZ.SCZName);
            caifunum.setString(SCZ.SCZGold);

            


        });


        

        //小喇叭
        var XLB_bg = new cc.Sprite(res.s_notice);
        XLB_bg.attr({
            x:size.width-30,
            y:size.height/2+135,
            scale:0.5
        });
        this.addChild(XLB_bg,40);

        var bgSize = cc.size(34,160);

        var scrollView = new ccui.ScrollView();
        scrollView.setDirection(ccui.ScrollView.DIR_VERTICAL);
        scrollView.setTouchEnabled(true);
        scrollView.setContentSize(cc.size(bgSize.width,bgSize.height-10));
        scrollView.x = size.width-38;
        scrollView.y = size.height/ 2 + 45;
        scrollView.setAnchorPoint(0,0.5);
        this.addChild(scrollView,40);

        
        //小喇叭字体描边
        var fontDefXLBStroke = new cc.FontDefinition();
        fontDefXLBStroke.fontName = Font;
        fontDefXLBStroke.fontSize = 16;
        fontDefXLBStroke.textAlign = cc.TEXT_ALIGNMENT_CENTER;
        fontDefXLBStroke.verticalAlign = cc.VERTICAL_TEXT_ALIGNMENT_TOP;
        fontDefXLBStroke.fillStyle = cc.color(255,0,0);
        //fontDefXLBStroke.boundingWidth = size.width;
        //fontDefXLBStroke.boundingHeight = size.height;
        // stroke
        fontDefXLBStroke.strokeEnabled = true;
        fontDefXLBStroke.strokeStyle = cc.color(245,226,15);

        //监听下喇叭内容
        socket.on("XLB",function(o){
            cc.log(o);
            scrollView.removeAllChildren();
            var text = new cc.LabelTTF(o.text,fontDefXLBStroke);
            text.attr({
                x:scrollView.width/2,
                y:-scrollView.height,
                anchorX:1,
                anchorY:1
            });
            //text.setColor(cc.color(219,21,21));
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
            //text.runAction(cc.RepeatForever.create(actionMove));
        });


        this.scheduleUpdate();
        return true;
    },
    update : function() {
        this.musicBTN.initWithFile((!allowMusic && !allowEffects)?res.s_musicbtn_off:res.s_musicbtn);
        
        
    },
    getboxBybianhao:function(bianhao){
        var childrens = this.TipsLayer.getChildren();

        for(var child in childrens){
            if(childrens[child].bianhao == bianhao){
                return childrens[child];
            }

        }
        return false;
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

var HelpScene = cc.Scene.extend({
    
    ctor:function(time,xiazahu_arrays){
        this._super();
    },
    onEnter:function () {
        this._super();
        var layer = new HelpLayer();
        this.addChild(layer);
    }
});

