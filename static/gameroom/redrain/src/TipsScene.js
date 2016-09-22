
var TipsLayer = cc.Layer.extend({
	bgSprite:null,
	scoreLabel:null,
	score:0,
	timeoutLabel:null,
	timeout:Number(setting.Game_time),
	SushiSprites:null,
	HeroSprites:null,
    spriteLeftRun:null,
    bigred:null,
    smallred:null,
    bomb:null,
	ctor:function () {
		//////////////////////////////
		// 1. super init first
		this._super();
		var size = cc.winSize;
		
		this.SushiSprites = [];
		this.HeroSprites = [];
       // cc.spriteFrameCache.addSpriteFrames(res.Left_plist);
		// add bg
		this.bgSprite = new cc.Sprite(res.s_BackGround_png);
		this.bgSprite.attr({
			x: size.width / 2,
			y: size.height / 2,
			scaleX: size.width/this.bgSprite.width,
			scaleY: size.height/this.bgSprite.height,
			//rotation: 180
		});
		this.addChild(this.bgSprite, 0);

		//背景动画
        var bg_animation = cc.Animation.create();//创建动画对象
        //for (var i = 0; i < 2; i++) { //循环加载每一帧图片 v
            
            bg_animation.addSpriteFrameWithFile(res.s_BackGround_png);
            bg_animation.addSpriteFrameWithFile(res.s_BackGround1_png);
        //}
        bg_animation.setDelayPerUnit(0.5); 
        var action = cc.Animate.create(bg_animation); 

        //重复运行Action，不断的转圈
        this.bgSprite.runAction(cc.RepeatForever.create(action));

		this.scoreLabel = new cc.LabelTTF("得分:0", "Arial", 38);
		this.scoreLabel.attr({
			x:size.width / 2 + 80,
			y:size.height - 50
		});
		this.addChild(this.scoreLabel, 5);

		this.timeoutLabel = cc.LabelTTF.create("时间:" + this.timeout, "Arial", 38);
		this.timeoutLabel.x = size.width/2-100;
		this.timeoutLabel.y = size.height - 50;
		this.addChild(this.timeoutLabel, 5);

		//主题霓虹灯闪烁
		cc.spriteFrameCache.addSpriteFrames(res.s_zhu_ti_plist);                  //引入plist
        var zhuti = new cc.Sprite("#zhu_ti_1.png");                            //选取其中一张图片定位
        zhuti.attr({
            anchorX:0.5,
            anchorY:0.5,
            x:size.width/2,
            y:size.height-180,
        });
        this.addChild(zhuti,1);
  
        var animFrames = [];
        // num equal to spriteSheet
        for (var i = 1; i < 5; i++) {                                             
            var str = "zhu_ti_" + i + ".png";
            var frame = cc.spriteFrameCache.getSpriteFrame(str);
            animFrames.push(frame);                                       //取出plist文件中所有sprite，加入数组
        }
        var animation = new cc.Animation(animFrames, 0.5);                //定义图片播放间隔
        var animationAction = new cc.Animate(animation);
        animationAction.retain();
        zhuti.runAction(animationAction.repeatForever());  

		// add "bigred" splash screen"
        this.bigred = new cc.Sprite(res.s_bigTips);

        this.bigred.setAnchorPoint(0.5, 0.5);
        this.bigred.setPosition(size.width/2-200, size.height-330);
        this.bigred.setScale(1);
        this.addChild(this.bigred, 5);

        /*this.bigLabel = new cc.LabelTTF("+30", "Arial", 15);
		this.bigLabel.attr({
			x:size.width / 2 -70,
			y:size.height/2 + 150
		});
		this.bigLabel.setColor(cc.color(255, 0, 0));
		this.addChild(this.bigLabel, 5);*/

        // add "smallred" splash screen"
        this.smallred = new cc.Sprite(res.s_smallTips);

        this.smallred.setAnchorPoint(0.5, 0.5);
        this.smallred.setPosition(size.width/2+180, size.height/2+180);
        this.smallred.setScale(1);
        this.addChild(this.smallred, 5);

        // add "bomb" splash screen"
        this.bomb = new cc.Sprite(res.s_bombTips);

        this.bomb.setAnchorPoint(0.5, 0.5);
        this.bomb.setPosition(size.width/2+50, size.height-150);
        this.bomb.setScale(1);
        this.addChild(this.bomb, 5);

        // add "hero" splash screen"
        this.spriteLeftRun = new cc.Sprite(res.s_hero);

        this.spriteLeftRun.setAnchorPoint(0.5, 0.5);
        this.spriteLeftRun.setPosition(size.width/2, size.height/2-20);
        this.spriteLeftRun.setScale(1);
        this.addChild(this.spriteLeftRun, 5);

        

        var tips = new cc.LayerColor(cc.color(4,4,4,200));
        var tipstext = new cc.Sprite(res.s_tips);
        tipstext.attr({
        	x:size.width / 2,
			y:size.height/2-420,
        });
        tips.addChild(tipstext);

        var shouzhi = new cc.Sprite(res.s_shouzhi);
        shouzhi.attr({
        	x:size.width / 2,
			y:size.height/2-270,
        });
        tips.addChild(shouzhi);

        
        var ok = new cc.MenuItemImage(
				res.s_ok,
				res.s_ok,
				function () {
					cc.log("Menu is clicked!");
					//cc.director.replaceScene(cc.TransitionFade(1.2, new PlayScene()));
					//cc.director.replaceScene( cc.TransitionPageTurn(1, new PlayScene(), false) );//浏览器不支持
					 cc.director.runScene(new PlayScene());
				}, this);
		ok.attr({
			x: size.width/2,
			y: ok.height/2+10,
		});

		var menu = new cc.Menu(ok);
		menu.x = 0;
		menu.y = 0;
		tips.addChild(menu, 1);

        this.addChild(tips);
        return true;
    },
	
	update : function() {

	},
	
	
 
	
	
	
	
		
});

var TipsScene = cc.Scene.extend({
	onEnter:function () {
		this._super();
		var layer = new TipsLayer();
		this.addChild(layer);
	}
});