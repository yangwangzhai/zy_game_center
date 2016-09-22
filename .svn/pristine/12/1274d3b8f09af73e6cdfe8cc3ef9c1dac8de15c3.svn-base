var MyLayer = cc.Layer.extend({
    helloLabel:null,
    sprite:null,
	spriteTopBg:null,
	spriteTai:null,
	spriteRen:null,
    spriteDogOne:null,
    groundSprite:null,
	//初始化其成员变量  
    isMouseDown:false,  
	curPos:null,  
    maxDistance:null, 
	prePos:null,

    timeElasped:0,
    m_positionDeltaY:null,
    m_startPosition:null,
    m_targetPosition:null,

    init:function () {
		//定义临时变量保存当前实例指针。  
        var selfPointer = this;  
        //////////////////////////////
        // 1. super init first
        this._super();
		this.maxDistance = 100.0;

        /////////////////////////////
        // 2. add a menu item with "X" image, which is clicked to quit the program
        //    you may modify it.
        // ask director the window size
        var size = cc.director.getWinSize();

        // add a "close" icon to exit the progress. it's an autorelease object
        var closeItem = new cc.MenuItemImage(
            s_CloseNormal,
            s_CloseSelected,
            function () {


                cc.director.runScene(new TestScene());
                cc.log("close");
            },this);
        closeItem.setAnchorPoint(0.5, 0.5);

        var menu = new cc.Menu(closeItem);
        menu.setPosition(0, 0);
        this.addChild(menu, 1);
        closeItem.setPosition(size.width - 20, 20);

        /////////////////////////////
        // 3. add your codes below...
        // add a label shows "Hello World"
        // create and initialize a label
        this.helloLabel = new cc.LabelTTF("Hello World", "Impact", 38);
        // position the label on the center of the screen
        this.helloLabel.setPosition(size.width / 2, size.height - 40);
        // add the label as a child to this layer
     //   this.addChild(this.helloLabel, 5);


        this.timeElasped = 0;
        this.m_positionDeltaY = 0;
        this.m_startPosition = cc.p(0, 0);
        this.m_targetPosition = cc.p(0, 0);


        // add "Helloworld" splash screen"
        this.sprite = new cc.Sprite(s_HelloWorld);
        this.sprite.setAnchorPoint(0.5, 0.5);
        this.sprite.setPosition(size.width / 2, size.height / 2);
        this.sprite.setScale(size.height / this.sprite.getContentSize().height);
        this.addChild(this.sprite, 0);
		
		 // add "topbg" splash screen"
        this.spriteTopBg = new cc.Sprite(s_TopBg);
		this.spriteTopBg.setAnchorPoint(0.5, 0.5);
        this.spriteTopBg.setPosition(size.width / 2, size.height - 60);
		this.spriteTopBg.setScale(size.width / this.spriteTopBg.getContentSize().width);
        this.addChild(this.spriteTopBg, 0);

		// add "tai" splash screen"
		this.spriteTai = new cc.Sprite(s_Tai);
		this.spriteTai.setAnchorPoint(0.5, 0.5);
		this.spriteTai.setPosition(size.width / 2, 50);
		this.spriteTai.setScale(size.width / this.spriteTai.getContentSize().width);
		this.addChild(this.spriteTai, 0);



        // add "dog" splash screen"
        this.spriteDogOne = new cc.Sprite(s_DogOne);
        this.spriteDogOne.setAnchorPoint(0.5, 0.5);
        this.spriteDogOne.setPosition(size.width, 160);
        this.spriteDogOne.setScale(0.6);
        this.addChild(this.spriteDogOne, 0,1);


        this.scheduleUpdate();//启动游戏循环，会自动调用update函数
        // 设置定时器，定时器每隔0.2秒调用一次addBullet方法
        this.schedule(this.dogMove,1);
        this.addDog();

        //背景移动
        this.groundSprite = cc.Sprite.create(s_Ground);
        var halfGroundW = this.groundSprite.getContentSize().width;
        var halfGroundH = this.groundSprite.getContentSize().height;
        this.groundSprite.setAnchorPoint(0.5, 0.5);
        this.groundSprite.setPosition(halfGroundW / 2, 0);
        this.groundSprite.setScale(0.9);
        this.addChild(this.groundSprite, 0);

        var action1 = cc.MoveTo.create(0.5, cc.p(halfGroundW / 2 + 20, this.groundSprite.getPositionY()));
        var action2 = cc.MoveTo.create(0, cc.p(halfGroundW / 2 - 200, this.groundSprite.getPositionY()));
        var actionTai = cc.Sequence.create(action1, action2);
        this.groundSprite.runAction(cc.RepeatForever.create(actionTai));


		var actionDog =  this.spriteDogOne;
		var animation = cc.Animation.create();//创建动画对象
		for (var i = 1; i < 6; i++) { //循环加载每一帧图片 v
			var frameName = "dog" + ((i < 10) ? ("0" + i) : i) + ".png";//图片命名为01-14.png,两位数即10以下为"0" + i,两位数以上为i
			animation.addSpriteFrameWithFile(frameName);
		}
		animation.setDelayPerUnit(2.8 / 14); //设置每一帧动画间隔时间,单位s,此处2.8 / 14表示，一共14帧动画, 播放时间2.8s;
	//	animation.setRestoreOriginalFrame(true); //设置动画播放完毕后，是否重置为原始帧
		var action = cc.Animate.create(animation); //cc.Animate是cc.Action动作类的子类，创建一个以animation为动画对象的动画动作
		//this.spriteTopBg.runAction(cc.Sequence.create(action, action.reverse())); //执行动画

        //重复运行Action，不断的转圈
        this.spriteTopBg.runAction(cc.RepeatForever.create(action));

//cc.Animate类的一些方法
	//	animation.clone();//创建新的动作实例，多次执行相同的动作，第二次以后执行，需要用此方法。
	//	animation.getAnimation();//得到动画对象
	//	animation.reverse();//与调用此方法动作相反的动作
	//	animation.setAnimation();//设置要播放的动画对象




		
		var sprite1 = new cc.Sprite("1.png");
		sprite1.setAnchorPoint(0.5, 0.5);
		//sprite1.x = size.width/2 - 80;
		//sprite1.y = size.height/2 + 80;
		sprite1.setPosition(size.width / 2, size.height/2 + 80);
		sprite1.setScale(0.2);
		this.addChild(sprite1, 10);

		var hide=cc.Hide.create();

		var show=cc.Show.create();//可以配合cc.Sequence实现组合动作

		cc.ToggleVisibility.create();//切换对象的可视性

		sprite1.runAction(show);


		//this.setTouchEnabled(true);  // 设置触摸模式为：可用

		// 创建一个事件监听器 OneByOne 为单点触摸
		var listener1 = cc.EventListener.create({
			event: cc.EventListener.TOUCH_ONE_BY_ONE,
			swallowTouches: true,                       // 设置是否吞没事件，在 onTouchBegan 方法返回 true 时吞掉事件，不再向下传递。
			onTouchBegan: function (touch, event) {     //实现 onTouchBegan 事件处理回调函数
				var target = event.getCurrentTarget();  // 获取事件所绑定的 target, 通常是cc.Node及其子类 
				
				// 获取当前触摸点相对于按钮所在的坐标
				var locationInNode = target.convertToNodeSpace(touch.getLocation());    
				var s = target.getContentSize();
				var rect = cc.rect(0, 0, s.width, s.height);
				
				var point = touch.getLocation();  
        		//this.curPos = point; 
				this.prePos = point;  
			//	cc.log(locationInNode);
			//	cc.log(this.curPos);  
				if(this.curPos != null){  
            		var sub = cc.pSub(this.curPos, this.prePos);  
            		if (Math.abs(sub.x) > Math.abs(sub.y)) {  
                		if (sub.x > this.maxDistance) {  
                   			cc.log("right");  
                		} else if(sub.x < -this.maxDistance){  
                    		cc.log("left");  
                		}  
            		} else {  
						if (sub.y > this.maxDistance) {  
							cc.log("up");  
						} else if(sub.y < -this.maxDistance){  
							cc.log("down");  
						}  
            		}  
            		this.curPos = null;  
       			}    
				
				
				if (cc.rectContainsPoint(rect, locationInNode)) {       // 判断触摸点是否在按钮范围内
					cc.log("sprite began... x = " + locationInNode.x + ", y = " + locationInNode.y);
					target.opacity = 180;


					var animation = cc.Animation.create();//创建动画对象
					for (var i = 1; i < 3; i++) { //循环加载每一帧图片 v
						//var frameName = "ren" + ((i < 10) ? ("" + i) : i) + ".png";//图片命名为01-14.png,两位数即10以下为"0" + i,两位数以上为i
                        var frameName = "dog" + ((i < 10) ? ("0" + i) : i) + ".png";
                        animation.addSpriteFrameWithFile(frameName);
					}
					animation.setDelayPerUnit(2.8 / 14); //设置每一帧动画间隔时间,单位s,此处2.8 / 14表示，一共14帧动画, 播放时间2.8s;
					animation.setRestoreOriginalFrame(true); //设置动画播放完毕后，是否重置为原始帧
					var action = cc.Animate.create(animation); //cc.Animate是cc.Action动作类的子类，创建一个以animation为动画对象的动画动作
					actionDog.runAction(cc.Sequence.create(action, action.reverse())); //执行动画
					return true;
				}
				return false;
			},
			onTouchMoved: function (touch, event) {         //实现onTouchMoved事件处理回调函数, 触摸移动时触发
				// 移动当前按钮精灵的坐标位置
				var target = event.getCurrentTarget();
				var delta = touch.getDelta();              //获取事件数据: delta,移动量
                var size = cc.director.getWinSize();
				target.x += delta.x;
				target.y += delta.y;
				
				var point = touch.getLocation();  
       		  //  cc.log(delta);


                var curPos = actionDog.getPosition();
              //  curPos= cc.pAdd(curPos, point);//当前位置+移动位置
                curPos.x = size.width;
                actionDog.setPosition(curPos);



            },
			onTouchEnded: function (touch, event) {         // 实现onTouchEnded事件处理回调函数
				var target = event.getCurrentTarget();
				cc.log("sprite onTouchesEnded.. ");
				target.setOpacity(255);
				if (target == sprite2) {                    
				//	sprite1.setLocalZOrder(100);            // 重新设置 ZOrder，显示的前后顺序将会改变
				} else if (target == sprite1) {
				//	sprite1.setLocalZOrder(0);
				}
			}
		});
		
		// 添加监听器到管理器
		cc.eventManager.addListener(listener1, sprite1);
	//	cc.eventManager.addListener(listener1.clone(), sprite2);
		//cc.eventManager.addListener(listener1.clone(), sprite3);
		
		 
    },

    update:function(dt){
       // cc.log(dt);
        this.timeElasped += dt;

    },

    addDog:function() {

        var winSize = cc.director.getWinSize();
        var origin =  cc.director.getVisibleOrigin();
        // 获得飞机的位置

        var dogPosition = this.spriteDogOne.getPosition();


        // 子弹穿越屏幕要花费的秒数
        var bulletDuration = 1;

        // 创建一个子弹
        var bullet =this.spriteDogOne;

        // 根据飞机的位置，初始化子弹的位置
      //  bullet.setPosition(cc.p(planePosition.x,planePosition.y+bullet.getContentSize().height));

        // 一个移动的动作
        // 第一个参数为移动到目标所需要花费的秒数，为了保持速度不变，需要按移动的距离与屏幕高度按比例计算出花费的秒数
       // var actionMove = cc.MoveTo.create(bulletDuration * ((winSize.height - planePosition.y - bullet.getContentSize().height/2)/winSize.height),
        //    cc.p(planePosition.x,
       //         origin.y + winSize.height + bullet.getContentSize().height/2));



        var animation = cc.Animation.create();//创建动画对象
        for (var i = 1; i <6; i++) { //循环加载每一帧图片 v
            //var frameName = "ren" + ((i < 10) ? ("" + i) : i) + ".png";//图片命名为01-14.png,两位数即10以下为"0" + i,两位数以上为i
            var frameName = "dog" + ((i < 10) ? ("0" + i) : i) + ".png";
            animation.addSpriteFrameWithFile(frameName);
        }
        animation.setDelayPerUnit(2 / 15); //设置每一帧动画间隔时间,单位s,此处2.8 / 14表示，一共14帧动画, 播放时间2.8s;
     //   animation.setRestoreOriginalFrame(true); //设置动画播放完毕后，是否重置为原始帧
        var action = cc.Animate.create(animation); //cc.Animate是cc.Action动作类的子类，创建一个以animation为动画对象的动画动作
      //  this.spriteDogOne.runAction(cc.Sequence.create(action, action.reverse())); //执行动画
        //重复运行Action，不断的转圈
        this.spriteDogOne.runAction(cc.RepeatForever.create(action));




      //  this.addChild(bullet,0);

    },
    dogMove:function() {
        var dogPosition = this.spriteDogOne.getPosition();
        dogPosition.x -= 30;
        cc.log(dogPosition);
        var actionMove = cc.MoveTo.create(1,dogPosition);
        // 设置一个回调函数，移动完毕后回调spriteMoveFinished（）方法。
        var actionMoveDone = cc.CallFunc.create(this.spriteMoveFinished,this);
        // 让子弹执行动作
        this.spriteDogOne.runAction(cc.Sequence.create(actionMove,actionMoveDone));





        // 为子弹设置标签，以后可以根据这个标签判断是否这个元素为子弹
        this.spriteDogOne.setTag(6);
    },

    spriteMoveFinished:function(sprite){

    },

	//当触屏按下并移动事件被响应时的处理。  
    onTouchesMoved:function (touches, event) {   cc.log("isMouseDown");
        //判断如果isMouseDown为ture。  
        if (this.isMouseDown) {  
            //如果触点有效.  
            if (touches) {  
                //这里本来是显示触点的，但屏蔽了。  
                //this.circle.setPosition(cc.p(touches[0].getLocation().x, touches[0].getLocation().y));  
				 cc.log("isMouseDown");
            }  
        }  
    }, 
	
	 
});


var MyHelloWorld = cc.Layer.extend({
    init: function () {
        this._super();

        var s = cc.director.getWinSize();

        //新建一个黄色的纯色层
        var layer1 = cc.LayerColor.create(cc.color(255, 255, 0, 255), s.width, s.height);
        //创建菜单文字菜单要用到的Label
        var menuLabel1=cc.LabelTTF.create("menuItem1","Arial",20);

        // add a "close" icon to exit the progress. it's an autorelease object
        var closeItem = new cc.MenuItemImage(
            s_CloseNormal,
            s_CloseSelected,
            function () {
                cc.log("close");
                cc.director.runScene(new MyScene());//浏览器不支持

            },this);
        closeItem.setAnchorPoint(0.5, 0.5);

        var menu = new cc.Menu(closeItem);
        menu.setPosition(0, 0);
        this.addChild(menu, 1);
        closeItem.setPosition(s.width - 20, 20);


        this.addChild(layer1);

        return true;
    }


});


var GameOverLayer = cc.LayerColor.extend({
    init:function(){
        this._super();
        this.setColor(cc.color(126, 126, 126, 126));
        var winSize = cc.director.getWinSize();
        var _label = cc.LabelTTF.create("GameOver","Arial", 60);
        _label.setPosition(cc.p(winSize.width / 2,winSize.height / 2));
        this.addChild(_label);
        return true;
    }
});


var MyHelloScene = cc.Scene.extend({
    onEnter:function () {
        this._super();
        var layer = new MyHelloWorld();
        this.addChild(layer);
        layer.init();
    }
});

var PlayScene = cc.Scene.extend({
    onEnter:function () {
        this._super();
        var layer = new GameOverLayer();
        this.addChild(layer);
        layer.init();
    }
});

var MyScene = cc.Scene.extend({
    onEnter:function () {
        this._super();
        var layer = new TestLayer();
        this.addChild(layer);
        layer.init();
    }
});


