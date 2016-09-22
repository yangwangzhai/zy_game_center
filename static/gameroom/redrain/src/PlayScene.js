
var PlayLayer = cc.Layer.extend({
	bgSprite:null,
	scoreLabel:null,
	score:0,
	timeoutLabel:null,
	timeout:Number(setting.Game_time),
	SushiSprites:null,
	HeroSprites:null,
    spriteLeftRun:null,
    SpriteArr:['bigred','smallred','bomb'],
    SOUND_ON: 'true',
    TouchListener:null,
    Play:null,
    daojishi : null,
    _Gameover : null,
    bombAction: null,
    heroAction: null,
	ctor:function () {
		//////////////////////////////
		// 1. super init first
		this._super();
		var size = cc.winSize;

		//播放背景音乐
		if(this.SOUND_ON){
			cc.audioEngine.playMusic(res.s_bg_audio, true);

		}

		
		//倒计时
		cc.spriteFrameCache.addSpriteFrames(res.s_daojishi_plist);                  //引入plist
        this.daojishi = new cc.Sprite("#1.png");                            //选取其中一张图片定位
        this.daojishi.attr({
            anchorX:0.5,
            anchorY:0.5,
            x:size.width/2,
            y:size.height/2,
        });
        this.addChild(this.daojishi,1);
  
        var animFrames = [];
        // num equal to spriteSheet
        for (var i = 5; i > 0; i--) {                                             
            var str = i + ".png";
            var frame = cc.spriteFrameCache.getSpriteFrame(str);
            animFrames.push(frame);                                       //取出plist文件中所有sprite，加入数组
        }
        var animation = new cc.Animation(animFrames, 1);                //定义图片播放间隔
        var animationAction = new cc.Animate(animation);
        animationAction.retain();
        this.daojishi.runAction(animationAction);  

        //创建鞭炮爆炸动画
		this.bombAction = cc.Animation.create();//创建动画对象
        //for (var i = 0; i < 2; i++) { //循环加载每一帧图片 v
            //var frameName = "static/gameroom/redrain/res/bomb_N"+i+".png";//图片命名为01-14.png,两位数即10以下为"0" + i,两位数以上为i
            this.bombAction.addSpriteFrameWithFile(res.s_bomb_N0);
            this.bombAction.addSpriteFrameWithFile(res.s_bomb_N1);
        //}
        this.bombAction.setDelayPerUnit(0.2); //设置每一帧动画间隔时间,单位s,此处2.8 / 14表示，一共14帧动画, 播放时间2.8s;
        
        //小龙人被炸动画
        this.heroAction = cc.Animation.create();//创建动画对象
        //for (var i = 0; i < 2; i++) { //循环加载每一帧图片 v
            var frameName = res.s_heroAction_png;//图片命名为01-14.png,两位数即10以下为"0" + i,两位数以上为i
            this.heroAction.addSpriteFrameWithFile(frameName);
            this.heroAction.addSpriteFrameWithFile(res.s_hero);
        //}
        this.heroAction.setDelayPerUnit(0.5);
        //this.heroAction.setRestoreOriginalFrame(true);
		
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
		
		
		//得分标签
		this.scoreLabel = new cc.LabelTTF("得分:0", "Arial", 38);
		this.scoreLabel.attr({
			x:size.width / 2 + 80,
			y:size.height - 50
		});
		this.addChild(this.scoreLabel, 5);

        
		// 游戏时间 
		this.timeoutLabel = cc.LabelTTF.create("时间:" + this.timeout, "Arial", 38);
		this.timeoutLabel.x = size.width/2-100;
		this.timeoutLabel.y = size.height - 50;
		this.addChild(this.timeoutLabel, 5);

		this.schedule(this.startPlay,0,0,5);
		
		// this.leftRun();
		return true;
	},

	startPlay : function(){
		this.Play = true;
		var size = cc.winSize;
		this.daojishi.removeFromParent();

		this.SushiSprites = [];
		this.HeroSprites = [];
		

		// add "left" splash screen"
        this.spriteLeftRun = new cc.Sprite(res.s_hero);

        this.spriteLeftRun.setAnchorPoint(0.5, 0.5);
        this.spriteLeftRun.setPosition(size.width/2, 150);
        this.spriteLeftRun.setScale(1);
        this.addChild(this.spriteLeftRun, 5);

        //schedule(callback_fn, interval, repeat, delay)
		this.schedule(this.update,1,16*1024,1);

        var actionLeft =  this.spriteLeftRun;
		//timer倒计时
		this.schedule(this.timer,1,this.timeout,1);
		this.schedule(this.collideCheck,0.1);//0.1秒检测一次碰撞
		//this.schedule(this.myupdate,0.2);

		 // 创建一个事件监听器 OneByOne 为单点触摸
        this.TouchListener = cc.EventListener.create({
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


                if (cc.rectContainsPoint(rect, locationInNode)) {       // 判断触摸点是否在按钮范围内
                   // cc.log("sprite began... x = " + locationInNode.x + ", y = " + locationInNode.y);
                    //target.opacity = 180;


                  /*  var animation = cc.Animation.create();//创建动画对象
                    for (var i = 1; i < 24; i++) { //循环加载每一帧图片 v
                        var frameName = "res/right" + ((i < 10) ? ("0" + i) : i) + ".png";//图片命名为01-14.png,两位数即10以下为"0" + i,两位数以上为i
                        animation.addSpriteFrameWithFile(frameName);
                    }
                    animation.setDelayPerUnit(1 / 24); //设置每一帧动画间隔时间,单位s,此处2.8 / 14表示，一共14帧动画, 播放时间2.8s;
                    //	animation.setRestoreOriginalFrame(true); //设置动画播放完毕后，是否重置为原始帧
                    var action = cc.Animate.create(animation); //cc.Animate是cc.Action动作类的子类，创建一个以animation为动画对象的动画动作
                  //  actionLeft.runAction(cc.Sequence.create(action, action.reverse())); //执行动画*/
				   return true;
               }
                return false;
            },
            onTouchMoved: function (touch, event) {         //实现onTouchMoved事件处理回调函数, 触摸移动时触发
                // 移动当前按钮精灵的坐标位置
                var target = event.getCurrentTarget();
                //var delta = touch.getDelta();  
                var pos = touch.getLocation();            //获取事件数据: delta,移动量
                var size = cc.director.getWinSize();
                target.x = pos.x;
                target.y = pos.y;
			//	cc.log(delta);

				

            },
            onTouchEnded: function (touch, event) {         // 实现onTouchEnded事件处理回调函数
                var target = event.getCurrentTarget();
                //cc.log("sprite onTouchesEnded.. ");
                target.setOpacity(255);
				isRuning = false;
				actionLeft.stopAllActions();
              //  if (target == sprite2) {
                    //	sprite1.setLocalZOrder(100);            // 重新设置 ZOrder，显示的前后顺序将会改变
              //  } else if (target == sprite1) {
                    //	sprite1.setLocalZOrder(0);
             //   }
             //   actionLeft.setLocalZOrder(0);
            }
        });

        // 添加监听器到管理器
        cc.eventManager.addListener(this.TouchListener, actionLeft);
      //  cc.eventManager.addListener(listener1.clone(), this.bgSprite);

	},

	/*myupdate : function(){
		if(this.Play){
			this.addSushi();
			this.removeSushi();
		}
	},*/
	
	update : function() {
		if(this.Play){
			this.addSushi();
			this.removeSushi();
		}
		
		
	},
	
	timer : function() {

		if (this.timeout == 0) {
			this.submitScore();
			cc.audioEngine.stopMusic();
			//alert('游戏结束');
			var gameOver = this._Gameover = new cc.LayerColor(cc.color(4,4,4,200));
			var size = cc.winSize;
			var gameOver_bg = new cc.Sprite(res.s_gameOver_bg);
			gameOver_bg.attr({
				x:size.width/2,
				y:size.height/2,
			});
			this.addChild(gameOver_bg, 10);

			var gold = new cc.Sprite(res.s_gold);
			gold.attr({
				x:size.width/2,
				y:size.height/2+80,
				scale:2
			});
			this.addChild(gold, 10);

			var staticLabel = new cc.LabelTTF("恭喜您获得", "Arial", 30);
			staticLabel.attr({
				x:size.width / 2 ,
				y:size.height / 2-5
			});
			staticLabel.setColor(cc.color(219, 158, 52));
			this.addChild(staticLabel, 10);


			var scoreLabel = new cc.LabelTTF(this.score+"个龙币", "Arial", 32);
			scoreLabel.attr({
				x:size.width / 2 ,
				y:size.height / 2-50
			});
			scoreLabel.setColor(cc.color(255, 0, 0));
			this.addChild(scoreLabel, 10);

			
			this.addChild(gameOver,5);
			
			this.unschedule(this.update);
			this.unschedule(this.timer);
			this.unschedule(this.collideCheck);
			this.unschedule(this.myupdate);
			cc.eventManager.removeListener(this.TouchListener);
			return;
		}

		this.timeout -=1;
		this.timeoutLabel.setString("时间:" + this.timeout);

	},
	
	addSushi : function() {
		var rednum = 0;
		for(j=0;j<5;j++){
			var i = 0;
			var sushi = null;
			//var sushi = new cc.Sprite("#sushi_1n.png");
			var size = cc.winSize;

			//生成不同的分数
			var fen = 0;
			var index = Math.floor((Math.random()*100));
			if(index >= 0 && index < 20){
				i = 0;
				rednum += 1;
			}else if(index >=20 && index < 50){
				i= 1;
				rednum += 1;
			}else if(index >=50 && index <100){
				i=2;
			}

			if(rednum >= 3){
				i = 2;
			}
			
			//alert(index);
			switch(this.SpriteArr[i]){
				case 'bigred':
					sushi = new SushiSprite(res.s_big_red);
					fen = Number(setting.Bigred);
					red_scale = 0.8;
					break;
				case 'smallred':
					sushi = new SushiSprite(res.s_small_red);
					fen = Number(setting.Smallred);
					red_scale = 1;
					break;
				case 'bomb':
					sushi = new SushiSprite(res.s_bomb);
					fen = Number(setting.Bomb);
					red_scale = 1;

			}

			

			var x = (size.width-sushi.width/2)*cc.random0To1();
			sushi.attr({
				x: x,
				y:(size.height) -20*cc.random0To1(),
	            scale: red_scale,
	            fensu: fen,
	            type: this.SpriteArr[i],
			});
			
			//sushi.retain();

			this.SushiSprites.push(sushi);
			sushi.index = this.SushiSprites.length;
			
			this.addChild(sushi,5);
			var dorpAction = cc.MoveTo.create(1.5, cc.p(sushi.x,-100));
			sushi.runAction(dorpAction);
		}

        
        
	},

	collideCheck: function(){
		for(i in this.SushiSprites) { 
			var sprite = this.SushiSprites[i];  
		    var distance = cc.pDistance(this.spriteLeftRun.getPosition(), sprite.getPosition());  
		    var radiusSum = 100;//sprite.radius + this.spriteLeftRun.radius;  
		    //cc.log("distance:" + distance + "; radius:" + radiusSum);  
		    if(distance < radiusSum){  
		        //发生碰撞 
		        this.addScore(this.SushiSprites[i].fensu);
                //this.removeSushiByindex(i);
                var hero = this.spriteLeftRun;
                if(this.SushiSprites[i].type == 'bomb'){
                	
                	this.SushiSprites[i].runAction(cc.sequence(
			            cc.animate(this.bombAction),
			            cc.callFunc(this.scheduleOnce(function(){
			            	//this.scheduleOnce(callback, 0.1); 
			            	//cc.log('remove');
			            	if(this.SushiSprites[i] != undefined){
			            		this.SushiSprites[i].removeFromParent();
			            	}
			            	
                			
			            },0.000001))
			        ));
			        var say = new cc.Sprite(res.s_hurt);
			        say.attr({
			        	x: this.spriteLeftRun.getPositionX()+30,
			        	y: this.spriteLeftRun.getPositionY()+150
			        });
			        //say.setColor(cc.color(219, 158, 52));
			        var upAction = cc.MoveTo.create(0.5, cc.p(hero.x+20,hero.y+200));
					say.runAction(cc.sequence(
			            upAction,
			            cc.FadeTo.create(0.1,0),
			            cc.callFunc(function(){
			            	say.removeFromParent();
			            })
			        ));
			        this.addChild(say,10);
			        this.spriteLeftRun.runAction(cc.sequence(
			            cc.animate(this.heroAction)
			        ));
			        cc.audioEngine.playEffect(res.s_bomb_audio);
                }else if(sprite.type == 'bigred' || sprite.type == 'smallred'){
                	var say = new cc.Sprite(res.s_get);
			        say.attr({
			        	x: this.spriteLeftRun.getPositionX()-30,
			        	y: this.spriteLeftRun.getPositionY()+150
			        });
			        //say.setColor(cc.color(219, 158, 52));
			        var upAction = cc.MoveTo.create(0.5, cc.p(hero.x-20,hero.y+200));
					say.runAction(cc.sequence(
			            upAction,
			            cc.FadeTo.create(0.1,0),
			            cc.callFunc(function(){
			            	say.removeFromParent();
			            })
			        ));
			        this.addChild(say,10);
                	cc.audioEngine.playEffect(res.s_red_audio);
                	sprite.removeFromParent();
                	//sprite = undefined;
                	
                }
                
                
                this.SushiSprites.splice(i,1);
                i= i-1; 
		    }  
		      
		      
		    //针对第三三种方法又加深了一下，使得对矩形类的精灵也能有好的判断，  
		    //主要就是分别对X和Y方向设置不同的Radius，然后去进行分别判断  
		   /* var distanceX = Math.abs(this.spriteLeftRun.getPositionX() - sprite.getPositionX());  
		    var distanceY = Math.abs(this.spriteLeftRun.getPositionY() - sprite.getPositionY());  
		    var radiusYSum = sprite.radiusY + this.spriteLeftRun.radius;  
		    if(distanceX < sprite.radiusX && distanceY < radiusYSum){  
		        this.catchDollSucceed(sprite);  
		        return;  
		    }  */
		}
	},

		
	removeSushiByindex : function(dx) {

		if(isNaN(dx)||dx>this.SushiSprites.length){return false;}  
		for(var i=0,n=0;i<this.length;i++)  
		{  
			if(this.SushiSprites[i]!=this[dx])  
			{  
				//cc.log("--------------");
				this.SushiSprites[n++]=this.SushiSprites[i]  
			}  
		}  
		this.SushiSprites.length-=1 
	},
	
	removeSushi : function() {
		
		//移除到屏幕底部的sushi
		for (var i = 0; i < this.SushiSprites.length; i++) {
			//cc.log("removeSushi.........");
			if(-100 == this.SushiSprites[i].y) {
				//cc.log("==============remove:"+i);
				this.SushiSprites[i].removeFromParent();
				this.SushiSprites[i] = undefined;
				this.SushiSprites.splice(i,1);
				i= i-1;
			}
		}
	},
	
	addScore:function(fen){
		this.score +=fen;
		if(this.score < 0){
			this.score = 0;
		}
		this.scoreLabel.setString("分数:" + this.score);
	},

	//提交游戏结果
	submitScore:function(){
		var self = this;
		xmlhttp=new XMLHttpRequest();
		xmlhttp.onreadystatechange=function ()
		{
		if (xmlhttp.readyState==4)
		  {// 4 = "loaded"
		  if (xmlhttp.status==200)
		    {// 200 = OK
		    // ...our code here...
		    var result = eval('(' + xmlhttp.responseText + ')'); 
		    if(result.code == 1){
		    	var size = cc.winSize;
			    var lj = new cc.MenuItemImage(
					res.s_lj_N_png,
					res.s_lj_S_png,
					function () {
						cc.log("Menu is clicked!");
						window.location.href=setting.GetLongBiUrl+udata.openid;
					}, self);
				lj.attr({
					x: size.width/2,
					y: size.height / 2 - 150,
					anchorX: 0.5,
					anchorY: 0.5,
					scale:0.8
				});

				var menu = new cc.Menu(lj);
				menu.x = 0;
				menu.y = 0;
				self.addChild(menu, 20);
		    }else{
		    	alert(result.error);
		    	window.location.href=setting.ActiveUrl;
		    	}
			    
		    //alert('恭喜您获取'+xmlhttp.responseText+'');
		    }else{
		    alert("提交数据失败");
		    window.location.href=setting.ActiveUrl;
		    }
		  }
		};
  		xmlhttp.open("POST",'index.php?d=redrain&c=redrain&m=recore',true);
  		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  		xmlhttp.send('score='+this.score+'&openid='+udata.openid+'&img_url='+udata.img_url+'&nickname='+udata.nickname+'&gamesign='+my_md5(udata.gamesign+this.score)+'&ChannelID='+udata.ChannelID+'&ActiveID='+udata.ActiveID+'&RoomID='+udata.RoomID);
	},
	//state_Change:
		
});

var PlayScene = cc.Scene.extend({
	onEnter:function () {
		this._super();
		var layer = new PlayLayer();
		this.addChild(layer);
	}
});