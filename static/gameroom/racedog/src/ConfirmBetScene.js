/**
 * Created by Administrator on 2016/3/24.
 */
var  FAIL_UI_SIZE = cc.size(292, 277);
var ConfirmBetUI = cc.Layer.extend({
    activate : false,
    notifySprite :null,
    replaySprite :null,
    win : false,
    tipText : null,
    winPanel : null,
    zzLayer : null,
    listener : null,
    maxTime: 300,
    numLabel:null,
    firstReturn: true,
    num : 1,
    sumGold : 0,
    giftObj : null,
    isClickCancel : false,
    isAgainBeton : false, //是否是重复下注
    djsLabel : null,
    Ptime : '0',
    ctor : function (obj, isAgain) {
        this._super(cc.color(10,10,10,100),640,960);
        check_id();//更新sessionid
        this.zzLayer = new cc.LayerColor(cc.color(10,10,10,100));
        if(typeof(isAgain) != "undefined" && isAgain != null && isAgain) {
            this.isClickCancel = true;
            this.isAgainBeton = true;
        }
        this.betonObj = obj;
        var size = cc.winSize;
        var self = this;

        var obj_bg = {cooky:res.s_cooky_bg, bone:res.s_bone_bg, star:res.s_star_bg, lolly:res.s_lolly_bg, bell:res.s_bell_bg, flower:res.s_flower_bg};

        this.winPanel = new cc.Sprite( res.s_confirm_beton_bg );
        this.winPanel.x = (cc.winSize.width )/2 ;
        this.winPanel.anchorY = 0.5;
        this.winPanel.y = cc.winSize.height/2;
        this.winPanel.scale = 0.8;
        this.addChild(this.winPanel,5);
        this.addChild( this.zzLayer,1);

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
        this.winPanel.removeAllChildren();

        var w = this.winPanel.width;
        var h = this.winPanel.height;
        var label = this.numLabel = new cc.LabelTTF('1', "宋体", 20);
        label.x = w/2;
        label.y = h/2;
        label.textAlign = cc.LabelTTF.TEXT_ALIGNMENT_CENTER;

        label.setRotation(90);
        label.color = cc.color(255,255,255);
      //  this.winPanel.addChild(label);

        var OKbtn = new cc.MenuItemImage(
            res.s_beton_ok,
            res.s_beton_ok,
            function(){
                self.getParent().betStatus = false;//设置为已经下注过
               // check_id();//更新sessionid
               // postGift( self.giftObj );
                if(self.isAgainBeton){
                    postBetAgain(wx_info.openid);//重复下注
                }else{
                    var r_val = postBetData(self.betonObj);//正常下注


                }
                self.isClickCancel = true;
                self.onExit();
            }
        );
        OKbtn.x =  w/9;
        OKbtn.y =  OKbtn.width + 150;

        OKbtn.setTag(1);
        //倒计时
        this.Ptime = this.getParent().timeLeft;
        var seconds = 30 - this.Ptime;
        var djs = this.djsLabel = new cc.LabelTTF(seconds, "宋体", 24);
        djs.x = w/9;
        djs.y = OKbtn.width + 75;
        djs.textAlign = cc.LabelTTF.TEXT_ALIGNMENT_CENTER;

        djs.setRotation(90);
        djs.color = cc.color(226,223,71);
        this.winPanel.addChild(djs,10,100);
        var Cancelbtn = new cc.MenuItemImage(
            res.s_beton_cancel,
            res.s_beton_cancel,
            function(){
              //  self.onExit();
                self.isClickCancel = true;
                if(self.isAgainBeton){
                    self.getParent().isFirstReturn = true;//设置为
                    self.onExit();
                }else{
                    self.clear();
                }


            }
        );
        Cancelbtn.x =  w/9;
        Cancelbtn.y = h - Cancelbtn.width - 80;

        Cancelbtn.setTag(2);

        var menu = new cc.Menu(OKbtn,Cancelbtn);
        menu.x=0;
        menu.y=0;
        this.winPanel.addChild(menu);

        var arr_y = [ 260, 85, -100, -270];
        var sum_gold = 0;
        for(i in arr_y){
            var golds;
            for(j in  this.betonObj){
                var dog = Number(this.betonObj[j].dog);
                var index = dog - i;
                if(index == 2){
                    golds = this.betonObj[j].gold;
                    break;
                }else{
                    golds = "0";
                }
            }
            sum_gold += Number(golds);
            var goldLabel = new cc.LabelTTF(golds, Font, 24);
            goldLabel.setColor(cc.color(255,255,255));
            goldLabel.x = w / 2 - 25;
            goldLabel.y = h / 2 + arr_y[i];
         //   goldLabel._setAnchorX(0.5);
            goldLabel._setAnchorY(0.5);
            goldLabel.setRotation(90);
            this.winPanel.addChild(goldLabel, 5);

        }



        this.sumGold = sum_gold;
        this.sumLabel = new cc.LabelTTF(sum_gold.toString(), Font, 36);
        this.sumLabel.setColor(cc.color(255,255,255));
        this.sumLabel.x = w / 2 - 80;
        this.sumLabel.y = h / 2 - 60;
        this.sumLabel._setAnchorX(0.5);
        this.sumLabel._setAnchorY(0.5);
        this.sumLabel.setRotation(90);
        this.winPanel.addChild(this.sumLabel, 5);



        this.schedule(this.updateLongTime,0.5);

        this.activate = true;
    },
    onExit : function () {
        this._super();
        this.activate = false;
        if(!this.isClickCancel){
            this.clear();
        }
        this.removeChild(this.winPanel);
        this.removeChild(this.zzLayer);
        cc.eventManager.removeListener(this.listener);
        this.unschedule(this.updateLongTime);
    },clear:function(){
        //我的烟豆
      //  var mygoldLable = this.getParent().getChildByTag(161).getChildByTag(162);
      //  wx_info.total_gold = wx_info.total_gold + this.sumGold
      //  mygoldLable.setString('我的烟豆:'+wx_info.total_gold+'');
        this.getParent().mygold = this.getParent().mygold + this.sumGold;

        //还原我的下注
        for(j in  this.betonObj){
            var dog = Number(this.betonObj[j].dog);
            var golds = this.betonObj[j].gold;
            switch(dog) {
                case 2:
                    myselfYD.dog2 = myselfYD.dog2 - golds;
                    break;
                case 3:
                    myselfYD.dog3 = myselfYD.dog3 - golds;
                    break;
                case 4:
                    myselfYD.dog4 = myselfYD.dog4 - golds;
                    break;
                case 5:
                    myselfYD.dog5 = myselfYD.dog5 - golds;
                    break;
            }
        }

        //获取个人下注烟豆的label
        var childrens = this.getParent().getChildByTag(160).getChildByTag(159).getChildren();//.getChildByTag(2);//.getChildren();
        for(var child in childrens) {
            switch(childrens[child].bianhao) {
                case "allbet5":
                    var selfYDLabel = childrens[child].getChildByTag(5);
                    selfYDLabel.setString(myselfYD.dog5);
                    break;
                case "allbet4":
                    var selfYDLabel = childrens[child].getChildByTag(5);
                    selfYDLabel.setString(myselfYD.dog4);
                    break;
                case "allbet3":
                    var selfYDLabel = childrens[child].getChildByTag(5);
                    selfYDLabel.setString(myselfYD.dog3);
                    break;
                case "allbet2":
                    var selfYDLabel = childrens[child].getChildByTag(5);
                    selfYDLabel.setString(myselfYD.dog2);
                    break;
            }
        }





        this.removeChild(this.winPanel);
        this.removeChild(this.zzLayer);
        cc.eventManager.removeListener(this.listener);

    }, updateLongTime:function(){
        this.Ptime = this.getParent().timeLeft;
        var seconds = 30 - this.Ptime;
        this.djsLabel.setString(seconds);


    }
});

var ConfirmBetScene = cc.Scene.extend({
    onEnter:function () {
        this._super();
        var send_obj = {openid:wx_info.openid,dog:3,gift_type:'flower',gold:gift_score.flower};
        var layer = new ConfirmBetUI(send_obj);
        this.addChild(layer);
    }
});
