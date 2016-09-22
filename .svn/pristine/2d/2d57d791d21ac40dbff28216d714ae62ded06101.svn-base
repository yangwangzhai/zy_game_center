
var StartLayer = cc.Layer.extend({
	bgSprite:null,
	scoreLabel:null,
	ctor:function () {
		//////////////////////////////
		// 1. super init first
		this._super();

		var size = cc.winSize;

		// add bg
		this.bgSprite = new cc.Sprite(res.s_BackGround_png);
		this.bgSprite.attr({
			x: size.width / 2,
			y: size.height / 2,
			scaleX: size.width/this.bgSprite.width,
			scaleY: size.height/this.bgSprite.height,
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
		
		//add start menu
		var startItem = new cc.MenuItemImage(
				res.s_Start_N_png,
				res.s_Start_S_png,
				function () {
					cc.log("Menu is clicked!");
					//cc.director.replaceScene(cc.TransitionFade(1.2, new PlayScene()));
					//cc.director.replaceScene( cc.TransitionPageTurn(1, new PlayScene(), false) );//浏览器不支持
					 cc.director.runScene(new TipsScene());
				}, this);
		startItem.attr({
			x: size.width/2,
			y: size.height/2,
			anchorX: 0.5,
			anchorY: 0.5,
			scale: 1
		});

		var menu = new cc.Menu(startItem);
		menu.x = 0;
		menu.y = 0;
		this.addChild(menu, 1);

		return true;
	}
});

var StartScene = cc.Scene.extend({
	onEnter:function () {
		this._super();
		var layer = new StartLayer();
		this.addChild(layer);
	}
});