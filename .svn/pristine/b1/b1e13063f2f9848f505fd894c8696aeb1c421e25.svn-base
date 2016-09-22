// JavaScript Document
var layers = {};
var TestLayer = cc.Layer.extend({  
    isLeft:null,  
    isRight:null,  
    hero:null, 
	hero1:null,
	hero2:null,  
    cameraStatue:null,  
    mapLength:null,  
    heroWidth:null,  
    heroSpeed:50,  
    cameraSpeed:50,
	closeBt:null,
    followAction:null,
    ctor:function (camera, space, statistics, settings) {  
        this._super();  
        var size = cc.winSize;  
        this.isLeft = false;  
        this.isRight = false;  
        this.cameraStatue = 0;  
         
     //   var tiled = new cc.TMXTiledMap("res/test1111.tmx");  
      //  this.addChild(tiled);  
	  
	   
	   // add a "close" icon to exit the progress. it's an autorelease object
		var closeItem = new cc.MenuItemImage(
				res.s_CloseNormal,
				res.s_CloseSelected,
				function () {
					this.addDog(this.hero);
					this.addDog(this.hero1);
					this.addDog(this.hero2);
					this.schedule(this.dogMove,0.2);
					this.scheduleUpdate();
					cc.log("close");
				},this);
		closeItem.setAnchorPoint(0.5, 0.5);

        var menu = new cc.Menu(closeItem);
        menu.setPosition(0, 0);
        this.addChild(menu, 1);
        closeItem.setPosition(size.width - 20, 20);
	    this.closeBt = closeItem;
	  
	  	  // add "Helloworld" splash screen"
        this.sprite = new cc.Sprite(res.s_RunBg);
        this.sprite.setAnchorPoint(0.5, 0.5);
        this.sprite.setPosition(600, size.height / 2);
        this.sprite.setScale(1);
        this.addChild(this.sprite, 0);
	  	
		/*this.tiled = new cc.Sprite(s_Ground);
        this.tiled.setAnchorPoint(0.5, 0.5);
        this.tiled.setPosition(120 , 0);
        this.tiled.setScale(1.1);
        this.addChild(this.tiled, 0);*/
		var tiled =  this.sprite;

		this.hero = new cc.Sprite("dog00.png");
        this.hero.scale = 0.6;  
        this.hero.setPosition(60, size.height * 0.46);
        this.addChild(this.hero, 1);  
        this.mapLength = tiled.getContentSize().width;  
        this.heroWidth = this.hero._getWidth() * 0.2;  
       // cc.log(this.hero._getWidth()*0.2*0.5);  
         
		this.hero1 = new cc.Sprite("dog00.png");  
        this.hero1.scale = 0.6;  
        this.hero1.setPosition(60, size.height * 0.3);
        this.addChild(this.hero1, 2);  
		    
		this.hero2 = new cc.Sprite("dog00.png");  
        this.hero2.scale = 0.6;  
        this.hero2.setPosition(60, size.height * 0.15);
        this.addChild(this.hero2, 2);  
       
			
		var actionDog =  this.spriteDogOne;
		var animation = cc.Animation.create();//创建动画对象
		for (var i = 1; i < 6; i++) { //循环加载每一帧图片 v
			var frameName = "dog" + ((i < 10) ? ("0" + i) : i) + ".png";//图片命名为01-14.png,两位数即10以下为"0" + i,两位数以上为i
			animation.addSpriteFrameWithFile(frameName);
		}
		animation.setDelayPerUnit(2.8 / 14); //设置每一帧动画间隔时间,单位s,此处2.8 / 14表示，一共14帧动画, 播放时间2.8s;
		animation.setRestoreOriginalFrame(true); //设置动画播放完毕后，是否重置为原始帧
		var action = cc.Animate.create(animation); //cc.Animate是cc.Action动作类的子类，创建一个以animation为动画对象的动画动作
		//this.spriteTopBg.runAction(cc.Sequence.create(action, action.reverse())); //执行动画

        //重复运行Action，不断的转圈
     //   this.hero.runAction(cc.RepeatForever.create(action));




      //  var followAction = cc.Follow.create(this.hero, cc.rect(0, 0, 0, size.height));
     //   this.runAction(followAction);

	//	var fun1 = this.dogMove(this.hero,10);
		
		//this.schedule(this.dogMove(this.hero1,20),0.5);
		//this.schedule(this.dogMove(this.hero2,30),0.5);
        this.followAction = cc.follow(this.hero, cc.rect(0, 0, size.width * 2 - 100, size.height));
		this.runAction(this.followAction);
       
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
				if (cc.rectContainsPoint(rect, locationInNode)) {       // 判断触摸点是否在按钮范围内
					cc.log("sprite began... x = " + locationInNode.x + ", y = " + locationInNode.y);
					target.opacity = 180;


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


                var curPos = target.getPosition();
              //  curPos= cc.pAdd(curPos, point);//当前位置+移动位置
              //  curPos.x = size.width;
              //  actionDog.setPosition(curPos);
 				


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
		cc.eventManager.addListener(listener1, this.hero);

		layers.loseUI = new ResultUI(false);

        //开始游戏
        this.addDog(this.hero);
        this.addDog(this.hero1);
        this.addDog(this.hero2);
        this.schedule(this.dogMove,0.2);
        this.scheduleUpdate();

        //监听服务端发送过来的开始赛跑命令
        socket.on('startRun', function(o){
            cc.log(o);
            cc.director.runScene(new PlayScene(o));
        });

        //监听服务端发送过来的开始结算命令
        socket.on('statement', function(o){
            cc.log(o);
            cc.director.runScene(new XiazhuScene(o));
        });

        //监听服务端发送过来的新的一局命令
        socket.on('newGame', function(o){
            cc.log(o);
            cc.director.runScene(new StartScene(o));
        });

     //   this.addChild(layers.winUI);
        return true;  
    },
	onEnter : function () {
		this._super();
		cc.log('onEnter');
	},
	onExit : function () {
		this._super();
		cc.log('onExit');
	},
    update : function(dt) {  
        var hero_pos = this.hero.getPositionX();
 		var bg_pos = this.getPositionX();
	//	this.closeBt.x = hero_pos;
		if(bg_pos < -240){
          //  cc.log('移动:'+bg_pos);
		//	this.stopAllActions();
            this.stopAction(this.followAction);
		}
		
		
        if (this.isLeft && !this.isRight) {  
            if ((pos - this.heroWidth *0.5) > 0  )   
                this.hero.setPositionX(pos - this.heroSpeed);  
        }  
        if (this.isRight && !this.isLeft) {  
            if ( (this.mapLength ) > (pos + this.heroWidth))   
                this.hero.setPositionX(pos + this.heroSpeed);  
        }  
        if(hero_pos < 10){
			 var size = cc.winSize;  
			this.hero.setPosition(600, size.height * 0.3);
			this.hero1.setPosition(500, size.height * 0.2);
			this.hero2.setPosition(500, size.height * 0.1);
			// this.hero.stopAllActions();
		}
 
		
      //  this.setCamera(pos,150, 250, cc.winSize.width * 0.5, this.mapLength);  
    },  
    setCamera : function(targetPositionX, offsetLeft, offsetRight, windowWidthHalf,tiledW) {  
        var cameraX = this.getPositionX();  
		if(cameraX < -100){
            this.hero.stopAllActions();
            return false;
        }
		
        var isOut = Math.abs(targetPositionX - (-cameraX));  
	//	cc.log(tiledW);
        var ofx = windowWidthHalf - 105;  
        if (targetPositionX >  (ofx) && (targetPositionX < (tiledW -windowWidthHalf +25))) {  
            if (isOut < offsetLeft) {  
                this.cameraStatue = 1;  
            }  
            if (isOut  >= offsetLeft && isOut <= offsetRight) {  
                this.cameraStatue = 0;  
            }  
            if (isOut > offsetRight) {  
                this.cameraStatue = 2;  
            }  
            if (this.cameraStatue == 1) {  
                this.setPositionX(cameraX + this.cameraSpeed);
            }  
            if (this.cameraStatue == 2) {  
                this.setPositionX(cameraX - this.cameraSpeed);
            }  
        }  
    }  ,
	dogMove:function() {


        var arrSimple2 = new Array();
        var dogSprites = new Array(this.hero, this.hero1, this.hero2);
        var isExit = new Array(5);
        for(var key in dogSprites){
            var dogPosition =  dogSprites[key].getPosition();
            arrSimple2.push(dogPosition.x);
            //大于1000过后放慢速度
            var speed = arrSimple2[0] > 1000 ? 5 : this.dogSpeed(10,25,isExit);
            isExit.push(speed);
            dogPosition.x += speed;
            // cc.log(dogPosition);
            var actionMove = cc.MoveTo.create(1,dogPosition);
            // 设置一个回调函数，移动完毕后回调spriteMoveFinished（）方法。
            var actionMoveDone = cc.CallFunc.create(this.spriteMoveFinished,this);
            // 让子弹执行动作
            dogSprites[key].runAction(cc.Sequence.create(actionMove,actionMoveDone));
            // 为子弹设置标签，以后可以根据这个标签判断是否这个元素为子弹
            dogSprites[key].setTag(key);
        }
        arrSimple2.sort(function(a,b){
            return b-a});
        for(var key in dogSprites){
            var dogPositionX =  dogSprites[key].getPositionX();
            if(dogPositionX == arrSimple2[0]){
                if(dogPositionX > 1050){
                    cc.log(key + 2);
                    this.gameOver(key + 2);
                }
            }
        }


		//cc.log( "dog3:" + actionMove2.getSpeed() );
		//cc.log('speed:' + speed + ' ,speed1:' + speed1 + ' ,speed2:' + speed2);
		
		
    },
	spriteMoveFinished:function(){

	},
    gameOver:function(dog){
        this.unscheduleAllCallbacks();
        this.hero.stopAllActions();
        this.hero1.stopAllActions();
        this.hero2.stopAllActions();
        layers.winUI = new ResultUI(true,dog);
        this.addChild(layers.winUI);

    },
	dogSpeed:function(Min,Max,isExit){
		var Range = Max - Min;   
		var Rand = Math.random();   
		var returnNum = Min + Math.round(Rand * Range);
	//	if(isExit.indexOf(returnNum) >-1 ){
	//		return returnNum + 5;
	//	}else{
			return  returnNum;   
	//	}
	},
	addDog:function(hero){
		var actionDog =  this.spriteDogOne;
		var animation = cc.Animation.create();//创建动画对象
		for (var i = 1; i < 6; i++) { //循环加载每一帧图片 v
			var frameName = "dog" + ((i < 10) ? ("0" + i) : i) + ".png";//图片命名为01-14.png,两位数即10以下为"0" + i,两位数以上为i
			animation.addSpriteFrameWithFile(frameName);
		}
		animation.setDelayPerUnit(2.8 / 14); //设置每一帧动画间隔时间,单位s,此处2.8 / 14表示，一共14帧动画, 播放时间2.8s;
		animation.setRestoreOriginalFrame(true); //设置动画播放完毕后，是否重置为原始帧
		var action = cc.Animate.create(animation); //cc.Animate是cc.Action动作类的子类，创建一个以animation为动画对象的动画动作
		//this.spriteTopBg.runAction(cc.Sequence.create(action, action.reverse())); //执行动画

        //重复运行Action，不断的转圈
        hero.runAction(cc.RepeatForever.create(action));
	}
});  
   
var PlayScene = cc.Scene.extend({
    onEnter:function () {  
        this._super();  
        var layer = new TestLayer();  
        this.addChild(layer);  
    }  
});