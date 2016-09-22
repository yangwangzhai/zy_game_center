/**
 * Created by Administrator on 2016/3/24.
 */
var  FAIL_UI_SIZE = cc.size(292, 277);
var SettingUI = cc.Layer.extend({
    activate : false,
    
    winPanel : null,
    zzLayer : null,
    listener : null,
    firstReturn: true,
    helpTips:null,
    ctor : function () {
        this._super(cc.color(10,10,10,100),640,960);
        this.zzLayer = new cc.LayerColor(cc.color(10,10,10,100));

        var size = cc.winSize;
        var self = this;


        this.winPanel = new cc.Sprite(res.s_pop5);
        this.winPanel.x = (cc.winSize.width )/2 ;
        this.winPanel.anchorY = 0.5;
        this.winPanel.y = cc.winSize.height/2;
        //this.winPanel.scale = 0.6;

        

        


        this.zzLayer.addChild(this.winPanel);
        this.addChild( this.zzLayer);



        //使得下层的点击事情无效
        this.listener = cc.EventListener.create({
            event: cc.EventListener.TOUCH_ONE_BY_ONE,
            swallowTouches: true,
            onTouchBegan: function (touch, event) {
                return true;
            },
            onTouchEnded: function (touch, event) {
            }
        });
        cc.eventManager.addListener(this.listener, this);


    },
    onEnter : function () {
        this._super();
        var self = this;
        var miny = cc.winSize.height/2 - FAIL_UI_SIZE.height / 2;
        var size = cc.winSize;


        this.winPanel.removeAllChildren();

        var w = this.winPanel.width, h = this.winPanel.height;

        /*//背景音乐开关
        var bg_music = new cc.Sprite(res.s_list_bg);
        bg_music.attr({
            x:w/2+90,
            y:h/2
        });

        var musicLable = new cc.LabelTTF("音乐","Arial",20);
        musicLable.attr({
            x:bg_music.width/2,
            y:bg_music.height-50
        });
        musicLable.setRotation(90);
        musicLable.setColor(cc.color(104,60,9));
        bg_music.addChild(musicLable);*/

        var music_btn = new cc.Sprite(allowMusic?res.s_on:res.s_off);
        music_btn.attr({
            x:this.winPanel.width/2+43,
            y:140
        });
        //bg_music.addChild(music_btn);
        this.winPanel.addChild(music_btn);

        cc.eventManager.addListener({
            event: cc.EventListener.TOUCH_ONE_BY_ONE,
            onTouchBegan: function (touch, event) {
                var target = event.getCurrentTarget();
                // 获取当前触摸点相对于按钮所在的坐标
                var locationInNode = target.convertToNodeSpace(touch.getLocation());
                var s = target.getContentSize();
                var rect = cc.rect(0, 0, s.width, s.height);
                if (cc.rectContainsPoint(rect, locationInNode)) {       // 判断触摸点是否在按钮范围内
                    if(allowMusic){
                        target.initWithFile(res.s_off);
                        allowMusic = false;
                        cc.audioEngine.stopMusic(true);
                    }else{
                        target.initWithFile(res.s_on);
                        allowMusic = true;
                        socket.emit('getGameTime');
                        socket.on('getGameTime',function(obj){
                            cc.log(obj.time);
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
                        
                    }
					cc.log('audioSetting');
                    socket.emit("audioSetting",{openid:wx_info.openid,type:'Music',status:allowMusic});
                    return true;
                }
                return false;

            }
        }, music_btn);

        /*//音效开关
        var bg_effects = new cc.Sprite(res.s_list_bg);
        bg_effects.attr({
            x:w/2,
            y:h/2
        });

        var effectsLable = new cc.LabelTTF("音效","Arial",20);
        effectsLable.attr({
            x:bg_effects.width/2,
            y:bg_effects.height-50
        });
        effectsLable.setRotation(90);
        effectsLable.setColor(cc.color(104,60,9));
        bg_effects.addChild(effectsLable);*/

        var effects_btn = new cc.Sprite(allowEffects?res.s_on:res.s_off);
        effects_btn.attr({
            x:this.winPanel.width/2-30,
            y:140
        });
        //bg_effects.addChild(effects_btn);
        this.winPanel.addChild(effects_btn);

        cc.eventManager.addListener({
            event: cc.EventListener.TOUCH_ONE_BY_ONE,
            onTouchBegan: function (touch, event) {
                var target = event.getCurrentTarget();
                // 获取当前触摸点相对于按钮所在的坐标
                var locationInNode = target.convertToNodeSpace(touch.getLocation());
                var s = target.getContentSize();
                var rect = cc.rect(0, 0, s.width, s.height);
                if (cc.rectContainsPoint(rect, locationInNode)) {       // 判断触摸点是否在按钮范围内
                    if(allowEffects){
                        target.initWithFile(res.s_off);
                        allowEffects = false;
                        cc.audioEngine.pauseAllEffects();
                    }else{
                        target.initWithFile(res.s_on);
                        allowEffects = true;
                    }
					cc.log('audioSetting');
                    socket.emit("audioSetting",{openid:wx_info.openid,type:'Effects',status:allowMusic});
                    return true;
                }
                return false;

            }
        }, effects_btn);

       /* //游戏帮助
        var bg_help = new cc.Sprite(res.s_list_bg);
        bg_help.attr({
            x:w/2-90,
            y:h/2
        });

        var helpLable = new cc.LabelTTF("游戏帮助","Arial",20);
        helpLable.attr({
            x:bg_help.width/2,
            y:bg_help.height-50
        });
        helpLable.setRotation(90);
        helpLable.setColor(cc.color(104,60,9));
        bg_help.addChild(helpLable);*/

        var help_btn = new cc.Sprite(res.s_view_btn);
        help_btn.attr({
            x:this.winPanel.width/2-100,
            y:140
        });
        //bg_help.addChild(help_btn);
        this.winPanel.addChild(help_btn);

        cc.eventManager.addListener({
            event: cc.EventListener.TOUCH_ONE_BY_ONE,
            onTouchBegan: function (touch, event) {
                var target = event.getCurrentTarget();
                // 获取当前触摸点相对于按钮所在的坐标
                var locationInNode = target.convertToNodeSpace(touch.getLocation());
                var s = target.getContentSize();
                var rect = cc.rect(0, 0, s.width, s.height);
                if (cc.rectContainsPoint(rect, locationInNode)) {       // 判断触摸点是否在按钮范围内
                    self.helpTips = new cc.Sprite(res.s_pop6);
                    self.helpTips.attr({
                        x:size.width/2,
                        y:size.height/2
                    });
                    var helpOKbtn = new cc.Sprite(res.s_close);
                    helpOKbtn.x = w-12;
                    helpOKbtn.y = 50;

                    helpOKbtn.setTag(2);
                    self.helpTips.addChild(helpOKbtn);

                    var scrollView = new ccui.ScrollView();
                    //设置方向
                    scrollView.setDirection(ccui.ScrollView.DIR_VERTICAL);
                    //触摸的属性
                    scrollView.setTouchEnabled(true);
                    //弹回的属性
                    //scrollView.setBounceEnabled(true);
                    //滑动的惯性
                    //scrollView.setInertiaScrollEnabled(true);
                    //scrollView.setBackGroundImageScale9Enabled(true);
                    
                    scrollView.setContentSize(cc.size(self.helpTips.width+90, self.helpTips.height-220));
                    //设置容器的大小 这个容器就是存放scrollview添加的节点，需要设置他的位置，上面已经讲清楚
                    //scrollView.setInnerContainerSize(cc.size(self.helpTips.width, self.helpTips.height-110));
                    //可以添加触摸事件监听器
                    //scrollView.addTouchEventListener(this.scrollviewCall,this);
                    //锚点默认是 （0,0）
                    scrollView.setAnchorPoint(0.5,0.5);
                    scrollView.x = self.helpTips.width/2-30;
                    scrollView.y = self.helpTips.height/2;
                    scrollView.setRotation(90);
                    //自己新建一个节点
                    

                    var textView = new ccui.Text();
                    textView.setString("基本操作：\n玩家点击游戏名称后，等待和其他正在游戏的玩家一起开始游戏，如游戏未开始时，则默认进入等待界面，直到下一场开注时才能开始游戏。玩家决定是要做赛场主还是选择其他狗狗；当有一名玩家选择成为赛场主以后，其他玩家将可以根据自己的判断进行给狗狗下注和送礼。\n整个游戏共有4个送礼区域分别为：2号吉娃娃，3号萨摩，4号秋田，5号哈士奇。然后根据最后的名次和赛场主进行对比，计算输赢。赢的一方获得奖励。\n\n赔率：第一名5倍，第二名3倍，第三名2倍，第四名1倍；\n\n游戏开始后五只狗开始赛跑，结束后根据狗狗的达到终点的名次进行开奖。\n\n玩家选择狗狗：每局游戏所有玩家有一个30秒的选择时间，进行下注。 \n选择狗狗操作：在选择时间内，会出现选择狗狗界面，玩家选择相应金额按钮再点击喜欢的狗狗即可完成下注。\n\n赛场主申请说明：\n在选择时间内玩家可以申请做赛场主，做赛场主条件为身上持有"+ unit(SCZ_ZG_GOLD) +"烟豆，点击 <申请赛场主> 按钮，如当前无玩家坐庄且满足"+ unit(SCZ_ZG_GOLD) +"烟豆，则当前玩家直接上庄，如已经有玩家在坐庄时则后申请玩家进入队列等待。如当前玩家下庄后排第一个的玩家就可以上庄。 \n庄家下庄： \n庄家坐庄后，游戏过程中不需要任何操作，只有在一局结束时庄家轮换时间选择[取消赛场主]，或庄家游戏币不足时自动下庄。 如庄家烟豆不足"+ unit(SCZ_ZG_GOLD) +"，则自动下庄。");
                    textView.ignoreContentAdaptWithSize(false);
                    textView.setSize(cc.size(450, textView.height+500));
                    textView.setAnchorPoint(0.5,1);
                    textView.y = textView.height;
                    textView.x = scrollView.width/2;
                    textView.setColor(cc.color(244,202,71));

                    scrollView.addChild(textView);

                    

                    

                    var innerWidth = scrollView.width;
                    var innerHeight = textView.height;

                    scrollView.setInnerContainerSize(cc.size(innerWidth, innerHeight));
                    
                    self.helpTips.addChild(scrollView);

                    /*var text = new cc.LabelTTF("基本操作：\n玩家点击游戏名称后，等待\n和其他正在游戏的\n玩家一起开始游戏，\n如游戏未开始时，\n则默认进入旁观等待，\n直到下开注时才能开始游戏。\n玩家决定是要做赛场主还是选择其他狗狗；\n当有一名玩家选择成为赛\n场主以后，其他玩家将可以\n根据自己的判断进行给狗狗送礼。\n整个游戏共有4个送礼区域分别为：\n2号秋田，3号柯基犬，4号茶犬，5\n号八哥犬。\n然后根据最后的名次和赛场主进行对比，\n计算输赢。赢的一方获得奖励。\n赔率：第一名10倍，第二名8倍，第三名5倍，第四名3倍；\n游戏开始后五只狗开始赛跑，\n结束后根据狗狗的达到终点的名次进行开奖。\n玩家选择狗狗：每局游戏后会有一个5秒的\n准备赛场主轮换时间，\n此时赛场主可以选\n择下庄或继续坐庄。 \n在此之后所有玩家有一个\n20秒的选择时间，\n玩家可进行选择礼物\n送给喜爱的狗狗，\n进行下注。 \n选择狗狗操作：\n在选择时间内，\n会出现选择狗\n狗界面，玩家选择选择礼物购买的\n方式为鼠标左键选\n择对应图标点击购买。 \n鼠标点击图标后，\n鼠标指针即变成图标道具后，\n至选择狗狗区单击喜爱\n的狗狗即完成下注操作。下注操作后，\n指针保持显示图标道具，\n支持连续下注。","Arial",15);

                    text.attr({
                        x:self.helpTips.width/2,
                        y:self.helpTips.height/2
                    });
                    self.helpTips.addChild(text);*/

                    


                    self.addChild(self.helpTips);
                    cc.eventManager.addListener({
                        event: cc.EventListener.TOUCH_ONE_BY_ONE,
                        swallowTouches: true,
                        onTouchBegan: function (touch, event) {
                            var target = event.getCurrentTarget();
                         //   if (!target.activate) return;
                            // 获取当前触摸点相对于按钮所在的坐标
                            var locationInNode = target.convertToNodeSpace(touch.getLocation());
                            var s = target.getContentSize();
                            var rect = cc.rect(0, 0, s.width, s.height);
                            if (cc.rectContainsPoint(rect, locationInNode)) {       // 判断触摸点是否在按钮范围内
                                //cc.log("sprite OKbtn... x = " + locationInNode.x + ", y = " + locationInNode.y);
                            
                                self.helpTips.removeFromParent();
                                return true;
                            }
                            return false;

                        }
                    }, helpOKbtn);
                    return true;
                }
                return false;

            }
        }, help_btn);

        
        

        var OKbtn = new cc.MenuItemImage(
            res.s_close,
            res.s_close,
            function(){
                self.onExit();
            }
        );
        OKbtn.x = w - 45;
        OKbtn.y = 50;

        OKbtn.setTag(2);
        var menu = new cc.Menu(OKbtn);
        menu.x=0;
        menu.y=0;
        this.winPanel.addChild(menu);


        


        this.activate = true;
    },
    onExit : function () {
        this._super();
        this.activate = false;
        this.removeChild(this.winPanel);
        this.removeChild(this.zzLayer);
        cc.eventManager.removeListener(this.listener);
    }
});

var SettingUIScene = cc.Scene.extend({
    onEnter:function () {
        this._super();
        var layer = new SettingUI();
        this.addChild(layer);
    }
});
