/**
 * Created by Administrator on 2016/3/24.
 */
var  FAIL_UI_SIZE = cc.size(292, 277);
var ResultUI = cc.Layer.extend({
    activate : false,
    notifySprite :null,
    replaySprite :null,
    win : false,
    resultText : null,
    winPanel : null,
    losePanel : null,
    alldogs : null,
    resultGold: null,
    firstReturn: true,
    res_gold : 0,
    thisTimesAddGold : 0,
    rankingkey : 4,
    rankingLabels : null,
    rankingSprites : null,
    action : null,
    xhLabel : null, //消耗金币
    cgLabel : null, //成果金币
    zhdLabel : null, //总获得金币
    blLabel : null, //本轮
    yeLabel : null, //赢得或赔款
    yeydLabel : null , //赢得或赔款烟豆数
    ctor : function (win,bianhaoArray,czRanking) {
        this._super();

        this.win = win;
        this.resultText = bianhaoArray;
        var size = cc.winSize;
        var self = this;
        var multiples = [0,5,3,2,1];
        if (win) {
            this.winPanel = new cc.Sprite(res.s_SucceedTipBg);
            this.winPanel.x = (cc.winSize.width )/2 ;
            this.winPanel.anchorY = 0.5;
            this.winPanel.y = cc.winSize.height/2;
            this.winPanel.setScale(0.65);
            this.addChild(this.winPanel);
        }
        else {
            this.losePanel = new cc.Sprite(res.s_FailedTipBg);
            this.losePanel.x = cc.winSize.width/2;
            this.losePanel.anchorY = 0.5;
            this.losePanel.y = cc.winSize.height/2;
            this.addChild(this.losePanel);
        }

        var ts = new cc.Sprite(res.s_ts);//通杀图标
        ts.attr({
            x:size.width/2+70,
            y:size.height/2-250,
            scale:0.85
        });
        ts.setVisible(false);
        this.addChild(ts);
        var tp = new cc.Sprite(res.s_tp);//通赔图标
        tp.attr({
            x:size.width/2+70,
            y:size.height/2-250,
            scale:0.85
        });
        tp.setVisible(false);
        this.addChild(tp);

        //倒计时
       /* var timeLabel = new cc.LabelTTF("选择倒计时：15", "Arial", 20);
        timeLabel.x = size.width-30;
        timeLabel.y = size.height/2;
        timeLabel.setRotation(90);
        timeLabel.setColor(cc.color(255,203,25));
        this.addChild(timeLabel,10);*/

        //加载狗狗动画资源
        cc.spriteFrameCache.addSpriteFrames(res.s_win01_plist);
        cc.spriteFrameCache.addSpriteFrames(res.s_win02_plist);
        cc.spriteFrameCache.addSpriteFrames(res.s_win03_plist);
        cc.spriteFrameCache.addSpriteFrames(res.s_win04_plist);
        cc.spriteFrameCache.addSpriteFrames(res.s_win05_plist);

        this.alldogs = new Array(this.dog1, this.dog2,this.dog3, this.dog4, this.dog5);
        this.dognames = ['','1号藏獒','2号吉娃娃','3号萨摩','4号秋田','5号哈士奇'];
        //var heights = [0.155,0.328,0.502,0.674,0.848];
        var heights = [-270,-134,1,136,274];
        var i = 5;//初始化狗狗编号
        var objs = new Array();
        this.rankingLabels = new Array();
        this.rankingSprites = new Array();
        for(var key in this.alldogs) {

            var width = size.width / 2 - 67 ;
            var height =  size.height/2 + heights[key];
            
            this.alldogs[key] = new cc.Sprite("dognum" + i + ".png");
            this.alldogs[key].attr({
                bianhao: i,
                scale: 0.64,
                x: width,
                y: height,
            });
            this.addChild(this.alldogs[key], 1);


            for(var j  in bianhaoArray) {
                j = Number( j );
                if( Number( bianhaoArray[j] ) == i) {
                    var textColor = cc.color(166, 221, 66);
                    var pm = j+1;
                    var pm_text = "第" + pm + "名";
                    var text = "赢x(" + multiples[pm] + ")";
                    var beishu = multiples[pm];
                    if(pm == 1){
                        var animFrames = [];
                        for (var n = 1; n < 9; n++) { //循环加载每一帧图片 v
                            var frameName = "win0"+i+"_" + n + ".png";//图片命名为01-14.png,两位数即10以下为"0" + i,两位数以上为i
                            //animation.addSpriteFrameWithFile(frameName);
                            var frame = cc.spriteFrameCache.getSpriteFrame(frameName);
                            animFrames.push(frame);
                        }
                        var animation = new cc.Animation(animFrames, 1/8);                //定义图片播放间隔
                        //animation.setRestoreOriginalFrame(true); //设置动画播放完毕后，是否重置为原始帧
                        this.action = cc.Animate.create(animation);

                        //本轮
                        var  blText = this.dognames[i] + '获得冠军！';
                        self.blLabel = new cc.LabelTTF(blText, Font, 18);
                        self.blLabel.setColor(cc.color(245, 255, 135));
                        self.blLabel.x = size.width / 2 + 28;
                        self.blLabel.y = size.height / 2 + 90;
                        self.blLabel._setAnchorX(1);
                        self.blLabel.setRotation(90);
                        self.addChild(self.blLabel, 5);

                        var sczLabel = new cc.LabelTTF('赛场主1号藏獒', Font, 18);
                        sczLabel.setColor(cc.color(222,190,38));
                        sczLabel.x = size.width / 2 + 28;
                        sczLabel.y = size.height / 2 + 90;
                        sczLabel._setAnchorX(0);
                        sczLabel.setRotation(90);
                        self.addChild(sczLabel, 5);

                        //赢得或赔款
                        self.yeLabel = new cc.LabelTTF('赢\n得', Font, 18);
                        self.yeLabel.setColor(cc.color(227,225,93));
                        self.yeLabel.x = size.width / 2 + 28;
                        self.yeLabel.y = size.height / 2 - 35;
                        self.yeLabel._setAnchorX(0);
                        self.yeLabel.setRotation(90);
                        self.addChild(self.yeLabel, 5);

                        //赢得或赔款
                        self.yeydLabel = new cc.LabelTTF('0', Font, 18);
                        self.yeydLabel.setColor(cc.color(166, 221, 66));
                        self.yeydLabel.x = size.width / 2 + 28;
                        self.yeydLabel.y = size.height / 2 - 65;
                        self.yeydLabel._setAnchorX(0);
                        self.yeydLabel.setRotation(90);
                        self.addChild(self.yeydLabel, 5);

                    }
                    if(pm > czRanking) {
                        text = "输x(-" + multiples[czRanking] + ")";
                        beishu = Number(-multiples[czRanking]);
                        textColor = cc.color(255, 58, 29);
                    }

                    if(czRanking == 1 && pm != czRanking) {
                        text = "输x(-5)";
                        beishu = -5;
                        ts.setVisible(true);
                        textColor = cc.color(255, 58, 29);
                    }

                    if(czRanking == 5){
                        tp.setVisible(true);
                        textColor = cc.color(84, 150, 75);
                    }

                    if(pm == czRanking) {
                        text = "赛场主";
                        textColor = cc.color(222,190,38);
                    }

                    if(pm != czRanking){
                        //传人狗狗输赢倍数
                        var obj = {dog:bianhaoArray[j], bs:beishu};
                        objs.push(obj);
                    }



                    var rankLabel = new cc.LabelTTF(text, Font, 20);
                    rankLabel.setColor(textColor);
                    rankLabel.x = size.width / 2 - 120;
                    rankLabel.y = size.height/2 + heights[key];
                    rankLabel.setRotation(90);

                    



                    /*//排名
                    var pmLabel = new cc.LabelTTF( pm_text, "Arial", 20);
                    pmLabel.setColor(textColor);
                    pmLabel.x = size.width / 2;
                    pmLabel.y = size.height * heights[key];
                    pmLabel.setRotation(90);*/

                    var pmSprite = new cc.Sprite(pm+".png");
                    pmSprite.attr({
                        pm:pm,
                        key:key
                    });
                    pmSprite.x = size.width / 2 - 10;
                    pmSprite.y = size.height/2 + heights[key];
                    pmSprite.setScale(0.63);

                    this.rankingLabels.push(rankLabel);
                    this.rankingSprites.push(pmSprite);
                  //  this.addChild(rankLabel, 5);
                 //   this.addChild(pmSprite, 5);


                }
            }

            i --;

        }

        //总成绩
        self.resultGold = new cc.LabelTTF("0", Font, 22);
        self.resultGold.setColor(cc.color(166, 221, 66));
        self.resultGold.x = size.width / 2 +55;
        self.resultGold.y = size.height / 2 + 200;
        self.resultGold._setAnchorX(0);
        self.resultGold.setRotation(90);
        self.addChild(self.resultGold, 15);

        //消耗
        self.xhLabel = new cc.LabelTTF("0", Font, 18);
        self.xhLabel.setColor(cc.color(255,255,255));
        self.xhLabel.x = size.width / 2 + 103;
        self.xhLabel.y = size.height / 2 + 220;
        self.xhLabel._setAnchorX(0);
        self.xhLabel.setRotation(90);
        self.addChild(self.xhLabel, 5);

        //成果
        self.cgLabel = new cc.LabelTTF("0", Font, 18);
        self.cgLabel.setColor(cc.color(166, 221, 66));
        self.cgLabel.x = size.width / 2 + 81;
        self.cgLabel.y = size.height / 2 + 220;
        self.cgLabel._setAnchorX(0);
        self.cgLabel.setRotation(90);
        self.addChild(self.cgLabel, 5);


        //计算结果
        socket.emit('reckon', {openid:wx_info.openid});

  /*      var results = [{dog:2,last_gold:1000},{dog:3,last_gold:-1000},{dog:4,last_gold:1000},{dog:5,last_gold:-1000}];
        var ydY = [0.78,0.65,0.52,0.39];
        for(var i in results){
            var ydLabel = new cc.LabelTTF( results[i].dog+"号狗:+"  + results[i].last_gold , Font, 18);
            ydLabel.setColor(cc.color(166, 221, 66));
            ydLabel.x = size.width / 2 + 81;
            ydLabel.y = size.height * ydY[i];
            ydLabel._setAnchorX(0);
            ydLabel.setRotation(90);
            if( Number( results[i].last_gold ) < 0 ){
                ydLabel.setColor( cc.color(255, 58, 29) );
                ydLabel.setString(   results[i].dog+"号狗:"+ results[i].last_gold );
            }
            self.addChild(ydLabel, 5);


        }*/

        //
        socket.on('reckon_to_'+wx_info.openid, function(o) {
          //  cc.log("本次获得烟豆"+ wx_info.openid + "："+ o.gold);

            if(self.firstReturn) {
                self.cgLabel.setVisible(0);
                self.firstReturn = false;
                var xh = 0 ;//消耗
                var zhd = 0; //总获得
                var result = o.result;
                cc.log( result);
              //  var ydY = [0.8,0.72,0.63,0.54];
                var ydY = [0.78,0.65,0.52,0.39];
                for(var i in result){

                    xh += Number( result[i].gold );
                    zhd += Number( result[i].last_gold );

                    var ydLabel = new cc.LabelTTF( result[i].dog+"号狗:+"  + result[i].last_gold , Font, 18);
                    ydLabel.setColor(cc.color(166, 221, 66));
                    ydLabel.x = size.width / 2 + 81;
                    ydLabel.y = size.height * ydY[i];
                    ydLabel._setAnchorX(0);
                    ydLabel.setRotation(90);
                    if( Number( result[i].last_gold ) < 0 ){
                        ydLabel.setColor( cc.color(255, 58, 29) );
                        ydLabel.setString(   result[i].dog+"号狗:"+ result[i].last_gold );
                    }
                    self.addChild(ydLabel, 5);


                }


              //  wx_info.total_gold = o.new_gold == 0 ? "0" : o.new_gold;
              //  cc.log("xinde烟豆"+ wx_info.openid + "："+ o.new_gold);
                self.resultGold.setString( zhd );
                self.xhLabel.setString( xh );
                if( zhd < 0 ){
                    self.resultGold.setColor( cc.color(255, 58, 29) );
                }
                self.thisTimesAddGold += zhd;
                var thisgoldLable = self.getParent().getChildByTag(162).getChildByTag(163);
                var bc = thisTimesgold + zhd;
                thisgoldLable.setString('本次烟豆:'+ bc +'');
            }
			



        });
        //返回新的总烟豆
        socket.on('getsumDY_'+wx_info.openid, function(o) {
            wx_info.total_gold = o.new_gold == 0 ? "0" : o.new_gold;
            if(o.new_gold < 1) wx_info.total_gold = '0';
            var mygoldLable = self.getParent().getChildByTag(162).getChildByTag(164);
            mygoldLable.setString('我的烟豆:'+wx_info.total_gold+'');


            
        });
        //返回赛场主新的总烟豆
        socket.on('update_scz_yd', function(o) {
         //   cc.log(o);
            SCZ.SCZGold = o.gold;
            var caifunum = self.getParent().getChildByTag(165);
            caifunum.setString(''+SCZ.SCZGold+'');

            var result = o.SCZwingold;
            var czyd = 0; //场主赢得或赔款的烟豆
            for(var j in result){
                czyd += Number( result[j].last_gold );
            }

            if( czyd > 0 ){
                self.yeydLabel.setColor( cc.color(255, 58, 29) );
                self.yeLabel.setString("赔\n款");
            }
            self.yeydLabel.setString(-czyd);

          //  SCZ.SCZOpenid = 'woM0Mxs3oVcGxDn9vdeEKnL3HpdSotest';
            if(wx_info.openid == SCZ.SCZOpenid){
                self.cgLabel.setVisible(0);
                wx_info.total_gold = o.gold;
            //    cc.log(result);
                var zhd = 0; //总获得
                var ydY = [0.78,0.65,0.52,0.39];
                for(var i in result){
                    zhd += Number( result[i].last_gold );
                    var ydLabel = new cc.LabelTTF( result[i].dog+"号狗：+" + result[i].last_gold , Font, 18);
                    ydLabel.setColor(cc.color(166, 221, 66));
                    ydLabel.x = size.width / 2 + 81;
                    ydLabel.y = size.height * ydY[i];
                    ydLabel._setAnchorX(0);
                    ydLabel.setRotation(90);
                    if( Number( result[i].last_gold ) < 0 ){
                        ydLabel.setColor( cc.color(255, 58, 29) );
                        ydLabel.setString(   result[i].dog+"号狗："+result[i].last_gold );
                    }
                    self.addChild(ydLabel, 5);


                }


                //  wx_info.total_gold = o.new_gold == 0 ? "0" : o.new_gold;
                //  cc.log("xinde烟豆"+ wx_info.openid + "："+ o.new_gold);
                self.resultGold.setString( -zhd );
                if( zhd > 0 ){
                    self.resultGold.setColor( cc.color(255, 58, 29) );
                }

                self.thisTimesAddGold -= zhd;

                var thisgoldLable = self.getParent().getChildByTag(162).getChildByTag(163);
                var bc = thisTimesgold - zhd;
                thisgoldLable.setString('本次烟豆:'+ bc +'');


            }

        });

     //   cc.log('objs;'+objs);

        this.schedule(this.addRanking,0.5);
        this.notifySprite = null;


        this.replaySprite = null;

    },addRanking : function(){
        if(this.rankingkey == -1 ||this.rankingkey < 0 ) return;
        this.addChild(this.rankingSprites[this.rankingkey], 5);
        if(this.rankingSprites[this.rankingkey].pm == 1){
          //  this.alldogs[this.rankingSprites[this.rankingkey].key].setRotation(90);
            this.alldogs[this.rankingSprites[this.rankingkey].key].runAction(cc.RepeatForever.create(this.action));
        }
        this.addChild(this.rankingLabels[this.rankingkey], 5);
        this.rankingkey --;
    },
    onEnter : function () {
        this._super();
        var miny = cc.winSize.height/2 - FAIL_UI_SIZE.height / 2;

        var step = 10;//layers.game.step, percent;
        if (step < 4) percent = 99;
        else if (step < 10) percent = Math.round(95 + 4 * (10-step)/6);
        else if (step < 20) percent = Math.round(85 + 10 * (20-step)/10);
        else percent = 95 - step/2;

        if (this.win) {
            this.winPanel.removeAllChildren();

            var w = this.winPanel.width, h = this.winPanel.height;
            var label = new cc.LabelTTF(this.resultText, "宋体", 20);
            label.x = w/2;
            label.y = h/4;
            label.textAlign = cc.LabelTTF.TEXT_ALIGNMENT_CENTER;
            //label.boundingWidth = w;
            label.width = w;
            label.color = cc.color(0, 0, 0);
         //   this.winPanel.addChild(label);
        }
        else {
            this.losePanel.removeAllChildren();
            var w = this.losePanel.width, h = this.losePanel.height;
            label = new cc.LabelTTF("我滴小羊驼呀它又跑掉了\nT_T 快帮我抓回来！", "宋体", 20);
            label.x = w/2;
            label.y = h/4+5;
            label.textAlign = cc.LabelTTF.TEXT_ALIGNMENT_CENTER;
            //label.boundingWidth = w;
            label.width = w;
            label.color = cc.color(0, 0, 0);
            this.losePanel.addChild(label, 10);
        }

   /*     cc.eventManager.addListener({
            event: cc.EventListener.TOUCH_ONE_BY_ONE,
            onTouchBegan: function (touch, event) {
                var target = event.getCurrentTarget();
                    cc.log(target.getTag());
                if (!target.activate) return;

                var pos = touch.getLocation();
                if (pos.y > miny-20 && pos.y < miny + 100) {
                    if (pos.x > cc.winSize.width/2) {
                        cc.director.runScene(new PlayScene());
                    }
                    else {
                        // Share
                       cc.log('Share');
                    }
                }
            }
        }, this);*/

       /* cc.eventManager.addListener({
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
                    cc.director.runScene(new PlayScene());
                    cc.log('replay');
                    return true;
                }
                return false;

            }
        }, this.replaySprite);

        cc.eventManager.addListener({
            event: cc.EventListener.TOUCH_ONE_BY_ONE,
            onTouchBegan: function (touch, event) {
                var target = event.getCurrentTarget();
              //  if (!target.activate) return;

                // 获取当前触摸点相对于按钮所在的坐标
                var locationInNode = target.convertToNodeSpace(touch.getLocation());
                var s = target.getContentSize();
                var rect = cc.rect(0, 0, s.width, s.height);
                if (cc.rectContainsPoint(rect, locationInNode)) {       // 判断触摸点是否在按钮范围内
                    cc.log("sprite began... x = " + locationInNode.x + ", y = " + locationInNode.y);
                    cc.log('notify');
                    return true;
                }
                return false;
            }
        }, this.notifySprite);
*/
        this.activate = true;
    },
    onExit : function () {
        this._super();
        this.activate = false;
        thisTimesgold += this.thisTimesAddGold;
    }
});

var ResultScene = cc.Scene.extend({
    onEnter:function () {
        this._super();
        var layer = new ResultUI(true,[2,1,3,4,5],2);
        this.addChild(layer);
    }
});
