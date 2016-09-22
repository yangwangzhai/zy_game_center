/**
 * Created by Administrator on 2016/3/24.
 */
var  FAIL_UI_SIZE = cc.size(292, 277);
var KillAllUI = cc.Layer.extend({
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
    ctor : function () {
        this._super();

        
        var size = cc.winSize;
        var self = this;

        var bg = new cc.Sprite(res.s_pop2);
        bg.attr({
            x: size.width/2,
            y:size.height/2
        });

        var dog = new cc.Sprite("dognum1.png");
        dog.attr({
            x:bg.width-130,
            y:bg.height/2
        });

        var crown = new cc.Sprite(res.s_crown);
        crown.attr({
            x:80,
            y:70
        });

        dog.addChild(crown);
        bg.addChild(dog);

        var bigLable = new cc.LabelTTF("本轮1号获得冠军","Arial",26);
        bigLable.attr({
            x:bg.width/2+10,
            y:bg.height/2
        });
        bigLable.setRotation(90);
        bigLable.setColor(cc.color(196,47,40));
        bg.addChild(bigLable);

        

        this.addChild(bg);
        

        


        //计算结果
        //socket.emit('reckon', objs);

        

        //
        socket.on('reckon_to_'+wx_info.openid, function(o) {
            cc.log("本次获得烟豆"+ wx_info.openid + "："+ o.gold);

            if(self.firstReturn) {
                self.firstReturn = false;
              //  wx_info.total_gold = o.new_gold == 0 ? "0" : o.new_gold;
              //  cc.log("xinde烟豆"+ wx_info.openid + "："+ o.new_gold);
                self.resultGold = new cc.LabelTTF("本次获得烟豆："+ o.gold, "Arial", 24);
                self.resultGold.setColor(cc.color(171,106,28));
                self.resultGold.x = size.width / 2 - 105;
                self.resultGold.y = size.height /2;
                self.resultGold.setRotation(90);
                self.addChild(self.resultGold, 5);
            }
			



        });
        //返回新的总烟豆
        socket.on('getsumDY_'+wx_info.openid, function(o) {
            wx_info.total_gold = o.new_gold == 0 ? "0" : o.new_gold;
        });

        //cc.log('objs;'+objs);

     
    },
    onEnter : function () {
        this._super();
        var miny = cc.winSize.height/2 - FAIL_UI_SIZE.height / 2;

        
        
        

   
    },
    onExit : function () {
        this._super();
    }
});

var KillAllScene = cc.Scene.extend({
    onEnter:function () {
        this._super();
        var layer = new KillAllUI();
        this.addChild(layer);
    }
});
