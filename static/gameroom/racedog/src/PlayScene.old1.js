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
    dogspeeds : null,
    resultText:'',
    bianhaoArray : null,
    czRanking:0,//场主排名
    longtime:null,
    longseconds:15,
    collidable :null,
    isOver: false,
    mapsize:null,
    ds:0,
    ctor:function () {
        this._super();  
        var size = cc.winSize;  
        this.isLeft = false;  
        this.isRight = false;  
        this.cameraStatue = 0;
	    this.bianhaoArray = new Array();
	  	  // add "Helloworld" splash screen"
       /* this.sprite = new cc.Sprite(res.s_RunBg);
        this.sprite.setAnchorPoint(0, 1);
        this.sprite.setPosition(0, size.height);
        this.sprite.setScale(0.65);
		//this.sprite.setRotation(270);
        this.addChild(this.sprite, 0);*/

        var tiled = new cc.TMXTiledMap(res.s_bg_map);//直接加载路径下tmx文件
        tiled.setAnchorPoint(0,1);
        tiled.setPosition(0, size.height);
        tiled.setScale(0.7);
        this.mapsize = tiled.getContentSize();
        this.addChild(tiled);
        console.log(tiled);
        this.sprite = tiled;

       var  _tileMap = tiled;



        var group = tiled.getObjectGroup("dogs");
        //var spawnPoint = group.getObject("ninja"); //JSB可以 Web不能用
        var array = group.getObjects();
        cc.log(array);
        for (var i = 0, len = array.length; i < len; i++) {
            var spawnPoint = array[i];
            var name = spawnPoint["name"];
            if (name == "dog1") {
                var x = spawnPoint["x"];
                var y = spawnPoint["y"];
                this.dog6 = new cc.Sprite("dog00.png");
                this.dog6.x = x;
                this.dog6.y = y;
                this.dog6.setScale(0.5);
                this.sprite.addChild(this.dog6, 2, 200);
                break;
            }
        }

     //   this.setViewpointCenter(this.dog6.getPosition());
        var dog6Pos = this.dog6.getPosition();
        cc.log(this.tileCoordFromPosition(dog6Pos));
       cc.log(dog6Pos);

        this.redline = new cc.Sprite(res.s_RedLine);
        //this.redline.setAnchorPoint(0.5, 0.5);
        this.redline.setRotation(90);
        //this.redline.setVisible(false);
        this.redline.attr({
            x: size.width/2,
            y: size.height-(this.mapsize.height*0.7)+220
        });
		this.addChild(this.redline, 100);

        var ssColor = cc.color(171,106,28);//深色

        //申请赛场主按钮
        var sq_btn = new cc.MenuItemImage(
            res.s_sqbtn,
            res.s_sqbtn,
            function () {
                cc.log("Menu is clicked!");

                var  dog6 =  this.dog6.getPosition();
                dog6.y -= this.sprite.getTileSize().height;
                this.dog6.setPosition(dog6);
              //  this.setViewpointCenter(this.dog6.getPosition());
                var point = this.redline.convertToNodeSpace(this.dog6.getPosition());
                cc.log(point);
            }, this);
        sq_btn.attr({
            x: size.width-30,
            y: size.height-40,
            scale:0.6
        });
        var menu = new cc.Menu(sq_btn);
        menu.x = 0;
        menu.y = 0;
        this.addChild(menu, 1);

        //按钮旁边的时间
        var timebox = new cc.Sprite(res.s_timebox);
        timebox.attr({
            x: size.width-30,
            y: 200,
            scale:0.8
        });

        this.longtime = new cc.LabelTTF("00:00:15", "Arial",24);
        this.longtime.attr({
            x: timebox.width/2-3,
            y: timebox.height/2-25
        });
        this.longtime.setRotation(90);
        this.longtime.setColor(cc.color(255,255,255));
        timebox.addChild( this.longtime,5);
        this.addChild(timebox);




        this.alldogs = new Array(this.dog1, this.dog2,this.dog3, this.dog4, this.dog5);
        var widths = [0.25,0.41,0.57,0.7,0.86];
        var i = 5;//初始化狗狗编号
        for(var key in this.alldogs) {

            var width = size.width * widths[key];
          //  cc.log(width);
            var height = size.height - 60;
            this.alldogs[key] =  new cc.Sprite("dog"+i+"_1.png");
            this.alldogs[key].attr({
                bianhao:i,
                isOver:0,
                scale: 0.6,
                x: width ,
                y: height ,
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

        //加载微信头像
        cc.loader.loadImg(wx_info.headimgurl, {isCrossOrigin : false }, function(err, img)
        {
            var sprite = new cc.Sprite(wx_info.headimgurl);
              sprite.x = this.width / 2 ;
              sprite.y = this.height / 2 ;
            sprite.scale = 0.1;
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
        var myname = new cc.LabelTTF(wx_info.nickname,"Arial",20);
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
        var mygoldLable = new cc.LabelTTF(wx_info.total_gold,"Arial",20);
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

        this.addChild(profile_bg);


        //背景跟随镜头移动
       /* 左边界：-300
        右边界：300
        上边界：400
        下边界：-400
        表达的意思就是这个对象在cc.Rect {-300,-400,600,800}这个矩形范围内都是会被跟拍的。*/
       // var followheight = 1730;
      //  this.followAction = new cc.follow(this.dog2, cc.rect(0, -950, size.width, followheight ));
		//this.sprite.runAction(this.followAction);

        //结果弹出框
		//layers.loseUI = new ResultUI(false);

		//this.mySchedule(this.check,0.05);
        //this.mySchedule(this.checkPZ,0.01);

        //传跑道长，频率，狗狗数量
        socket.emit('dogInfo', {wholeplace:800, frequency:0.5, dogs:5, minspeed :1});





        /* //开始游戏
		this.addDog(this.dog2);
		this.addDog(this.dog3);
		this.addDog(this.dog4);
		this.schedule(this.dogMove,0.2);
		this.scheduleUpdate();*/

        //监听服务端发送过来的开始赛跑命令
        socket.on('startRun', function(o){
         //   cc.log(o);
          //  cc.director.runScene(new PlayScene(o));
        });

        //监听服务端发送过来的开始结算命令
        socket.on('statement', function(o){
         //   cc.log(o);
         //   cc.director.runScene(new XiazhuScene(o));
        });

        //监听服务端发送过来的新的一局命令
        socket.on('newGame', function(o){
         //   cc.log(o);
           // cc.director.runScene(new ChooseScene(o));
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
         cc.log('replay');
         return true;
         }
         return false;

         }
         }, timebox);


        //底部下注信息
        var bottom_bar = new cc.Sprite(res.s_bottom_bar);
        bottom_bar.attr({
            scale:0.6,
            x:3,
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


        //我的本场下注
        var mybet = new cc.LabelTTF("我的本场下注：000" , "Arial", 25);
        mybet.attr({
            x:bottom_bar.width/2-2,
            y:bottom_bar.height-90,
            anchorX:0,
            anchorY:0

        });
        mybet.setRotation(90);
        mybet.setColor(ssColor);
        bottom_bar.addChild(mybet);

        //我的2号狗下注
        var mybet2 = new cc.LabelTTF("2号：0" , "Arial", 25);
        mybet2.attr({
            x:bottom_bar.width/2-2,
            y:bottom_bar.height/2+100,
            anchorX:0,
            anchorY:0
        });
        mybet2.setRotation(90);
        mybet2.setColor(ssColor);
        bottom_bar.addChild(mybet2);

        //我的3号狗下注
        var mybet3 = new cc.LabelTTF("3号：0" , "Arial", 25);
        mybet3.attr({
            x:bottom_bar.width/2-2,
            y:bottom_bar.height/2-50,
            anchorX:0,
            anchorY:0
        });
        mybet3.setRotation(90);
        mybet3.setColor(ssColor);
        bottom_bar.addChild(mybet3);

        //我的4号狗下注
        var mybet4 = new cc.LabelTTF("4号：0" , "Arial", 25);
        mybet4.attr({
            x:bottom_bar.width/2-2,
            y:bottom_bar.height/2-190,
            anchorX:0,
            anchorY:0
        });
        mybet4.setRotation(90);
        mybet4.setColor(ssColor);
        bottom_bar.addChild(mybet4);

        //我的5号狗下注
        var mybet5 = new cc.LabelTTF("5号：0" , "Arial", 25);
        mybet5.attr({
            x:bottom_bar.width/2-2,
            y:bottom_bar.height/2-340,
            anchorX:0,
            anchorY:0
        });
        mybet5.setRotation(90);
        mybet5.setColor(ssColor);
        bottom_bar.addChild(mybet5);

        //本场总下注
        var allbet = new cc.LabelTTF("本场下注总金额：000000" , "Arial", 25);
        allbet.attr({
            x:bottom_bar.width/2-35,
            y:bottom_bar.height-90,
            anchorX:0,
            anchorY:0

        });
        allbet.setRotation(90);
        allbet.setColor(ssColor);
        bottom_bar.addChild(allbet);

        //本场2号狗下注
        var allbet2 = new cc.LabelTTF("2号：0" , "Arial", 25);
        allbet2.attr({
            x:bottom_bar.width/2-35,
            y:bottom_bar.height/2+100,
            anchorX:0,
            anchorY:0
        });
        allbet2.setRotation(90);
        allbet2.setColor(ssColor);
        bottom_bar.addChild(allbet2);

        //本场3号狗下注
        var allbet3 = new cc.LabelTTF("3号：0" , "Arial", 25);
        allbet3.attr({
            x:bottom_bar.width/2-35,
            y:bottom_bar.height/2-50,
            anchorX:0,
            anchorY:0
        });
        allbet3.setRotation(90);
        allbet3.setColor(ssColor);
        bottom_bar.addChild(allbet3);

        //本场4号狗下注
        var allbet4 = new cc.LabelTTF("4号：0" , "Arial", 25);
        allbet4.attr({
            x:bottom_bar.width/2-35,
            y:bottom_bar.height/2-190,
            anchorX:0,
            anchorY:0
        });
        allbet4.setRotation(90);
        allbet4.setColor(ssColor);
        bottom_bar.addChild(allbet4);

        //本场5号狗下注
        var allbet5 = new cc.LabelTTF("5号：0" , "Arial", 25);
        allbet5.attr({
            x:bottom_bar.width/2-35,
            y:bottom_bar.height/2-340,
            anchorX:0,
            anchorY:0
        });
        allbet5.setRotation(90);
        allbet5.setColor(ssColor);
        bottom_bar.addChild(allbet5);

        this.addChild(bottom_bar);

        //声音图标
        var musicBTN = new cc.Sprite(res.s_musicbtn);
        musicBTN.attr({
            x: size.width-30,
            y: 100,
            scale:0.8
        });
        this.addChild(musicBTN,100);

        //设置图标
        var settingBTN = new cc.Sprite(res.s_settingbtn);
        settingBTN.attr({
            x: size.width-30,
            y: 50,
            scale:0.8
        });
        this.addChild(settingBTN,100);

        this.collidable = tiled.getLayer("end_line");
        cc.log(this.collidable);


        //   this.addChild(layers.winUI);
        return true;  
    },
	onEnter : function () {
		this._super();
        var dogspeedsobj = this;
        //监听服务端发送过来的狗狗赛跑的速度信息
        socket.on('getDogInfo', function(obj){

            cc.log('dogspeeds'+obj);
            dogspeedsobj.dogspeeds = obj;
            for(var key in dogspeedsobj.alldogs) {
                dogspeedsobj.addDog(dogspeedsobj.alldogs[key]);
            }
            dogspeedsobj.schedule(dogspeedsobj.dogMove,0.5);
            dogspeedsobj.scheduleUpdate();

            //  cc.director.runScene(new PlayScene(o));
        });

        this.schedule(this.updateLongTime,1);
		cc.log('onEnter');
	},
	onExit : function () {
		this._super();
        this.unschedule(this.check);
        this.unschedule(this.checkPZ);
		cc.log('onExit');
	},
    updateLongTime:function(){
        this.longseconds --;
        var i = this.longseconds;
        var newText = "00:00:" +  ((i < 10) ? ("0"+i) : i);
        this.longtime.setString(newText);
         if( this.longseconds <1 ) this.unschedule(this.updateLongTime);




    }
    ,
    update : function(dt) {
        var bg_pos = this.sprite.getPosition();
	//	this.closeBt.x = hero_pos;
		//cc.log('移动:'+bg_pos);
		if(bg_pos.x < -350 && ! this.stopFollowAction){
           // cc.log('移动:'+bg_pos);
		//	this.stopAllActions();
          //  this.stopFollowAction = true ;
          //  this.stopAction(this.followAction);
		}


		
      //  this.setCamera(pos,150, 250, cc.winSize.width * 0.5, this.mapLength);  
    },dogInfo:function(){

    } ,
    setPlayerPosition: function (pos) {
     /*   var SpritePos = pos.getPosition();
    //从像素点坐标转化为瓦片坐标
    var tileCoord =  this.tileCoordFromPosition(SpritePos);
        if ( tileCoord.y > 174 || tileCoord.y == 174) { //碰撞检测成功
            cc.log("碰撞检测成功:" + pos.bianhao);
            pos.attr({isOver:1});

            var actionMove = cc.MoveTo.create(1,cc.p( SpritePos.x,55));
            var actionMoveDone = cc.CallFunc.create(this.dosMoveFinished,this);
            pos.runAction(cc.Sequence.create(actionMove,actionMoveDone));




              cc.log(  SpritePos);
            //  cc.log(  this.sprite.getPosition());
            // cc.audioEngine.playEffect("res/empty.wav");
            return;
        }*/
      /* cc.log(  tileCoord);
    //获得瓦片的GID
    var tileGid = this.collidable.getTileGIDAt(tileCoord);
      //  cc.log( "tileGid:"+ tileGid);
    if (tileGid > 0) {
        var prop = this.sprite.getPropertiesForGID(tileGid);
        var collision = prop["Collidable"];

        if (collision == "true") { //碰撞检测成功
            cc.log("碰撞检测成功:" + pos.bianhao);
            pos.attr({isOver:1});
          //  cc.log(  SpritePos);
          //  cc.log(  this.sprite.getPosition());
           // cc.audioEngine.playEffect("res/empty.wav");
            return;
        }
    }*/
    //移动精灵

},dosMoveFinished:function(pos){
        pos.stopAllActions();

    },tileCoordFromPosition: function (pos) {
        var _tileMap = this.sprite;
        var x = pos.x / _tileMap.getTileSize().width;
        //float 转为为 int
        x = parseInt(x, 10);
        var y = ((_tileMap.getMapSize().height * _tileMap.getTileSize().height) - pos.y) / _tileMap.getTileSize().height;
        //float 转为为 int
        y = parseInt(y, 10);
        return cc.p(x, y);
    },
	check:function(){

        var bg_pos = this.sprite.getPosition();
        var  dog6 =  this.dog6.getPosition();
        dog6.y -= this.sprite.getTileSize().height;
        bg_pos.y += this.sprite.getTileSize().height  /2;
        
        if(bg_pos.y < 3800) {
           this.sprite.setPosition(bg_pos);
           this.redline.y += this.sprite.getTileSize().height  /2;
        }

        /*var dollRect = this.redline.getBoundingBox();  
        for(var dog in this.alldogs){
            var dollHeadRect = this.alldogs[dog].getBoundingBox();  
            if(cc.rectIntersectsRect(dollRect, dollHeadRect)){  
                  //发生碰撞事件  
                  cc.log(this.alldogs[dog].bianhao);
            } 
        }*/
        
     //   this.dog6.setPosition(dog6);
   //      this.setViewpointCenter(this.dog6.getPosition());
      //  this.setPlayerPosition(this.dog6);
	},
    checkPZ:function(){
        cc.log('红线y轴：'+this.redline.y);
        var dogs = new Array(this.dog1,this.dog2,this.dog3,this.dog4,this.dog5);
        for(var i in dogs){
            var dog = dogs[i];
            if(!dog.isOver){

                /*var distance = cc.pDistance(this.redline.getPosition(), dog.getPosition());
                var radiusSum = 50;
                //cc.log("distance:" + distance + "; radius:" + radiusSum);
                if(distance < radiusSum){
                    //发生碰撞
                    cc.log(dog.bianhao);
                }*/
                var dollRect = this.redline.getBoundingBox();
                var dollHeadRect = dog.getBoundingBox();
                if(cc.rectIntersectsRect(dollRect, dollHeadRect)){
                      //发生碰撞事件  
                      cc.log(dog.bianhao);
                      cc.log(dog.y);
                      dog.isOver = 1;

                }
            }
                
        }

        /*var dog5_pos = this.dog5.getPosition();
        var coll2 = this.collidable.getPositionAt(2,174);
        //cc.log(coll2);
        if(dog5_pos.y <= coll2.y){
            cc.log('pz');
        }*/
    },
	dogMove:function() {

		var arrSimple2 = new Array();
		var dogSprites = this.alldogs;//new Array(this.dog2, this.dog3, this.dog4);
		var isExit = new Array();
        var bg_pos = this.sprite.getPosition();
        var speed = 0 ;
        for(var key in dogSprites){
            if(dogSprites[key].isOver == 1) continue;
			var dogPosition =  dogSprites[key].getPosition();
			arrSimple2.push(dogPosition.y);
			//大于1000过后放慢速度
			speed =  Number( this.dogspeeds[key][this.ds] ); //arrSimple2[0] < 500 ? this.dogSpeed(0,30,isExit) : this.dogSpeed(0,60,isExit);// //arrSimple2[0] > 1000 ? 5 : this.dogSpeed(10,25,isExit);
			//cc.log(speed);
            if( isNaN(speed) ) speed=0;
            isExit.push(speed);
			dogPosition.y -= speed;

			var actionMove = cc.MoveTo.create(1,dogPosition);
			// 设置一个回调函数，移动完毕后回调spriteMoveFinished（）方法。
			var actionMoveDone = cc.CallFunc.create(this.spriteMoveFinished2,dogSprites[key]);
			// 让子弹执行动作
			dogSprites[key].runAction(cc.Sequence.create(actionMove,actionMoveDone));
			// 为子弹设置标签，以后可以根据这个标签判断是否这个元素为子弹
			dogSprites[key].setTag(key);
            this.setPlayerPosition(dogSprites[key]);
		}
		arrSimple2.sort(function(a,b){
			return a-b});



       // cc.log(arrSimple2[0]);
		for(var key in dogSprites){
            if(dogSprites[key].isOver == 1) continue;
			var dogPositionY =  dogSprites[key].getPositionY();
			if(dogPositionY == arrSimple2[0]){
				if(dogPositionY < -550){
                    dogSprites[key].attr({isOver:1});
                  //  this.unscheduleAllCallbacks();
                    //输出排名
                    this.ranking ++;
                    var rankLabel = new cc.LabelTTF(" "+ this.ranking, "Arial", 38);
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
                    var actionMove = cc.MoveTo.create(1,cc.p( dogPosition.x,-650));
                    var actionMoveDone = cc.CallFunc.create(this.spriteMoveFinished,this);
                    dogSprites[key].runAction(cc.Sequence.create(actionMove,actionMoveDone));
                  //  dogSprites[key].stopAllActions();
					//cc.log(dogSprites[key]);
					//this.gameOver(key + 2);
				}

		    }
        }



        this.ds ++;
	},
	spriteMoveFinished:function(dog){

        dog.stopAllActions();
     //   dog.initWithFile("dog00.png");

        //计算排名到第五后说明可以结束游戏
        if( Number( this.ranking ) == 5 && !this.isOver){
            this.isOver = true;
            this.gameOver(this.bianhaoArray);
           // cc.log(this.ranking);
        }
	},
    gameOver:function(bianhaoArray){
        this.unscheduleAllCallbacks();
        //this.hero.stopAllActions();
        //this.hero1.stopAllActions();
       // this.hero2.stopAllActions();

        cc.audioEngine.stopMusic();
        if (!cc.audioEngine.isMusicPlaying()) {
            cc.audioEngine.playMusic(res.s_bg_music_mp3, true);
        }


        layers.winUI = new ResultUI(true,bianhaoArray, this.czRanking);
        this.addChild(layers.winUI,10);

    },
	dogSpeed:function(Min,Max,isExit){
		var Range = Max - Min;   
		var Rand = Math.random();   
		var returnNum = Min + Math.round(Rand * Range);
		if(isExit.indexOf(returnNum) >-1 ){
			return returnNum ;
		}else{
			return  returnNum;   
		}
	},
	addDog:function(hero){
		var actionDog =  this.spriteDogOne;
		var animation = cc.Animation.create();//创建动画对象
        var bainhao = hero.bianhao;
		for (var i = 1; i < 8; i++) { //循环加载每一帧图片 v
			var frameName = "dog"+bainhao+"_" + ((i < 10) ? (i) : i) + ".png";//图片命名为01-14.png,两位数即10以下为"0" + i,两位数以上为i
			animation.addSpriteFrameWithFile(frameName);
		}
		animation.setDelayPerUnit(1 / 8); //设置每一帧动画间隔时间,单位s,此处2.8 / 14表示，一共14帧动画, 播放时间2.8s;
		animation.setRestoreOriginalFrame(true); //设置动画播放完毕后，是否重置为原始帧
		var action = cc.Animate.create(animation); //cc.Animate是cc.Action动作类的子类，创建一个以animation为动画对象的动画动作
		//this.spriteTopBg.runAction(cc.Sequence.create(action, action.reverse())); //执行动画

        //重复运行Action，不断的转圈
        hero.runAction(cc.RepeatForever.create(action));
	},
    setViewpointCenter: function (pos) {
        cc.log("setViewpointCenter");
        var _tileMap = this.sprite;
        var size = cc.director.getWinSize();
        //可以防止，视图左边超出屏幕之外。
        var x = 0;
        var y = Math.max(pos.y, size.height / 2);

        //可以防止，视图右边超出屏幕之外。
        x = 0;
        y = Math.min(y, (_tileMap.getMapSize().height * _tileMap.getTileSize().height)
            - size.height / 2);

        //屏幕中心点
        var pointA = cc.p(0, size.height / 2);
        //使精灵处于屏幕中心，移动地图目标位置
        var pointB = cc.p(0, y);

        //地图移动偏移量
        var offset = cc.pSub(pointB, pointA);
        cc.log(pointA);
        cc.log(pointB);
        cc.log(offset);
        cc.log(this.sprite.getPosition());
        // log("offset (%f ,%f) ",offset.x, offset.y);
       // offset.y += 100;
        if(pointB.y == pointA.y) {
            var pos = this.sprite.getPosition();
            pos.y += _tileMap.getTileSize().height ;
           // this.sprite.setPosition(pos);
        }
    },
    setCamera : function(targetPositionX, offsetLeft, offsetRight, windowWidthHalf,tiledW) {
        var cameraX = this.getPositionX();
        var isOut = Math.abs(targetPositionX - (-cameraX));
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
    },
    mySchedule:function(callbanck,interval){
        var then = Date.now();
        console.log(then);
        interval = interval*1000;
        //bind 传参数this
        this.schedule(function(){
            var now = Date.now();
            var delta = now - then;
            if(delta>interval){
                then = now - (delta%interval);
                callbanck.call(this);
            }
        }.bind(this),0);  //此处的0表示每帧都触发
    }
});  
   
var PlayScene = cc.Scene.extend({
    onEnter:function () {  
        this._super();  
        var layer = new PlayLayer();
        this.addChild(layer);  
    }  
});