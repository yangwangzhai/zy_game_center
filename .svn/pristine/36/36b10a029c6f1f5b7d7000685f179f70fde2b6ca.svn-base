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
    isOver: false,
    ds:0,
    ctor:function () {
        this._super();  
        var size = cc.winSize;  
        this.isLeft = false;  
        this.isRight = false;  
        this.cameraStatue = 0;
        this.bianhaoArray = new Array();
          // add "Helloworld" splash screen"
        /*this.sprite = new cc.Sprite(res.s_RunBg);
        this.sprite.setAnchorPoint(0, 1);
        this.sprite.setPosition(0, size.height);
        this.sprite.setScale(0.65);*/
        //this.sprite.setRotation(270);

        var tiled = new cc.TMXTiledMap(res.s_bg_map);//直接加载路径下tmx文件
        tiled.setAnchorPoint(0,1);
        tiled.setPosition(0, size.height);
        tiled.setScale(0.7);
        //this.addChild(tiled);
        console.log(tiled);
        this.sprite = tiled;



        this.redline = new cc.Sprite(res.s_RedLine);
        this.redline.setRotation(90);
        this.redline.attr({
            x: size.width/2,
            y: 200,

        });
        this.addChild(this.redline, 100);

        this.addChild(this.sprite, 0);

        

        //申请赛场主按钮
        var sq_btn = new cc.MenuItemImage(
            res.s_sqbtn,
            res.s_sqbtn,
            function () {
                cc.log("Menu is clicked!");
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
        layers.loseUI = new ResultUI(false);

        this.schedule(this.check,0.05);
        this.schedule(this.checkPZ,0.01);

        //传跑道长，频率，狗狗数量
        socket.emit('dogInfo', {wholeplace:1000, frequency:0.2, dogs:3, minspeed :6});



        /* //开始游戏
        this.addDog(this.dog2);
        this.addDog(this.dog3);
        this.addDog(this.dog4);
        this.schedule(this.dogMove,0.2);
        this.scheduleUpdate();*/

        //监听服务端发送过来的开始赛跑命令
        socket.on('startRun', function(o){
         //   cc.log(o);
            cc.director.runScene(new PlayScene(o));
        });

        //监听服务端发送过来的开始结算命令
        socket.on('statement', function(o){
         //   cc.log(o);
         //   cc.director.runScene(new XiazhuScene(o));
        });

        //监听服务端发送过来的新的一局命令
        socket.on('newGame', function(o){
         //   cc.log(o);
            cc.director.runScene(new ChooseScene(o));
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



         //   this.addChild(layers.winUI);
        return true;  
    },
    onEnter : function () {
        this._super();
        var dogspeedsobj = this;
        //监听服务端发送过来的狗狗赛跑的速度信息
        socket.on('getDogInfo', function(obj){

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
        cc.log('onExit');
    },
    updateLongTime:function(){
        this.longseconds --;
        var i = this.longseconds;
        var newText = "00:00:" +  ((i < 10) ? ("0"+i) : i);
        this.longtime.setString(newText);
         if( this.longseconds ==0 ) this.unschedule(this.updateLongTime);




    }
    ,
    update : function(dt) {
        var bg_pos = this.sprite.getPosition();
    //  this.closeBt.x = hero_pos;
        //cc.log('移动:'+bg_pos);
        if(bg_pos.x < -350 && ! this.stopFollowAction){
           // cc.log('移动:'+bg_pos);
        //  this.stopAllActions();
          //  this.stopFollowAction = true ;
          //  this.stopAction(this.followAction);
        }


        
      //  this.setCamera(pos,150, 250, cc.winSize.width * 0.5, this.mapLength);  
    },dogInfo:function(){
       //
        // cc.log(123);
    },
    check:function(){

        
        var bg_pos = this.sprite.getPosition();
        bg_pos.y += 10;
        if(bg_pos.y < 3330) {
            this.sprite.setPosition(bg_pos);
        }

    },
    checkPZ:function(){
        var dogs = new Array(this.dog1,this.dog2,this.dog3,this.dog4,this.dog5);
        for(var i in dogs){
            var dog = dogs[i];
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
            }
        }
    },
    dogMove:function() {

        var arrSimple2 = new Array();
        var dogSprites = this.alldogs;//new Array(this.dog2, this.dog3, this.dog4);
        var isExit = new Array(5);
        var bg_pos = this.sprite.getPosition();
        var speed = 0 ;
        for(var key in dogSprites){
            if(dogSprites[key].isOver == 1) continue;
            var dogPosition =  dogSprites[key].getPosition();
            arrSimple2.push(dogPosition.y);
            //大于1000过后放慢速度
            speed =  arrSimple2[0] < 500 ? this.dogSpeed(0,30,isExit) : this.dogSpeed(0,60,isExit);// Number( this.dogspeeds[key][this.ds] );//arrSimple2[0] > 1000 ? 5 : this.dogSpeed(10,25,isExit);
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
        }
        arrSimple2.sort(function(a,b){
            return a-b});





       // cc.log(arrSimple2[0]);
        for(var key in dogSprites){
            if(dogSprites[key].isOver == 1) continue;
            var dogPositionY =  dogSprites[key].getPositionY();
            if(dogPositionY == arrSimple2[0]){
                if(dogPositionY < 150){
                    dogSprites[key].attr({isOver:1});
                  //  this.unscheduleAllCallbacks();
                    //输出排名
                    this.ranking ++;
                    var rankLabel = new cc.LabelTTF(" "+ this.ranking, "Arial", 38);
                    rankLabel.x = dogSprites[key].getPositionX();
                    rankLabel.y =  250;
                    this.addChild(rankLabel, 2);
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
                    var actionMove = cc.MoveTo.create(1,cc.p( dogPosition.x,100));
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
        layers.winUI = new ResultUI(true,bianhaoArray, this.czRanking);
     //   this.addChild(layers.winUI,10);

    },
    dogSpeed:function(Min,Max,isExit){
        var Range = Max - Min;   
        var Rand = Math.random();   
        var returnNum = Min + Math.round(Rand * Range);
        if(isExit.indexOf(returnNum) >-1 ){
            return returnNum + 2;
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
    }
});  
   
var PlayTestScene = cc.Scene.extend({
    onEnter:function () {  
        this._super();  
        var layer = new PlayLayer();
        this.addChild(layer);  
    }  
});