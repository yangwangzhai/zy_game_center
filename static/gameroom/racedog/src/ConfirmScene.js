/**
 * Created by Administrator on 2016/3/24.
 */
var  FAIL_UI_SIZE = cc.size(292, 277);
var ConfirmUI = cc.Layer.extend({
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
    giftObj : null,
    ctor : function (obj,time) {
        this._super(cc.color(10,10,10,100),640,960);
        this.zzLayer = new cc.LayerColor(cc.color(10,10,10,100));
        if(typeof(time) != "undefined" && time != null)  this.maxTime = time;

        this.giftObj = obj;
        var size = cc.winSize;
        var self = this;

        var obj_bg = {cooky:res.s_cooky_bg, bone:res.s_bone_bg, star:res.s_star_bg, lolly:res.s_lolly_bg, bell:res.s_bell_bg, flower:res.s_flower_bg};

        this.winPanel = new cc.Sprite(obj_bg[ obj['gift_type'] ] );
        this.winPanel.x = (cc.winSize.width )/2 ;
        this.winPanel.anchorY = 0.5;
        this.winPanel.y = cc.winSize.height/2;
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
        this.schedule(this.countDown,1);


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
            res.s_buy_bg,
            res.s_buy_bg,
            function(){
                postGift( self.giftObj );
                self.onExit();
            }
        );
        OKbtn.x =  w/7;
        OKbtn.y =  OKbtn.width + 80;

        OKbtn.setTag(1);

        var Cancelbtn = new cc.MenuItemImage(
            res.s_cancel_bg,
            res.s_cancel_bg,
            function(){
                self.onExit();
            }
        );
        Cancelbtn.x =  w/7;
        Cancelbtn.y = h - Cancelbtn.width - 80;

        Cancelbtn.setTag(2);

        var menu = new cc.Menu(OKbtn,Cancelbtn);
        menu.x=0;
        menu.y=0;
        this.winPanel.addChild(menu);



        /*var OKbtn = new cc.Sprite(res.s_buy_bg);
        OKbtn.x = w/7;
        OKbtn.y = h - OKbtn.width - 80;
        OKbtn.setTag(1);
        this.winPanel.addChild(OKbtn);

        var Cancelbtn = new cc.Sprite(res.s_cancel_bg);
        Cancelbtn.x = w/7;
        Cancelbtn.y = Cancelbtn.width + 80;
        Cancelbtn.setTag(2);
        this.winPanel.addChild(Cancelbtn);*/







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
                 //   cc.log("sprite OKbtn... x = " + locationInNode.x + ", y = " + locationInNode.y);
                   // postGift( self.giftObj );
                  //  self.onExit();
                    return true;
                }
                return false;

            }
        }, OKbtn);


        //取消
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
                //    cc.log("sprite Cancelbtn... x = " + locationInNode.x + ", y = " + locationInNode.y);

                   // self.onExit();
                    return true;
                }
                return false;

            }
        }, Cancelbtn);






        this.activate = true;
    },
    onExit : function () {
        this._super();
        this.activate = false;
        this.removeChild(this.winPanel);
        this.removeChild(this.zzLayer);
        cc.eventManager.removeListener(this.listener);
    },countDown:function(){
        this.maxTime --;
        if(this.maxTime == 0){
            this.onExit();
        }

    }
});

var ConfirmScene = cc.Scene.extend({
    onEnter:function () {
        this._super();
        var send_obj = {openid:wx_info.openid,dog:3,gift_type:'flower',gold:gift_score.flower};
        var layer = new ConfirmUI(send_obj);
        this.addChild(layer);
    }
});
