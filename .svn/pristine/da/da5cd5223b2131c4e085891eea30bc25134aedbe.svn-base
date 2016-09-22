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
    ctor : function (obj) {
        this._super(cc.color(10,10,10,100),640,960);
        this.zzLayer = new cc.LayerColor(cc.color(10,10,10,100));
        if(typeof(obj) != "undefined" && obj != null && obj) {
            this.textObj = obj;
        }else{
            this.textObj = '提示';
        }

        var size = cc.winSize;
        var self = this;


        this.winPanel = new cc.Sprite( res.s_tip2 );
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



    },
    onEnter : function () {
        this._super();
        var self = this;
        var miny = cc.winSize.height/2 - FAIL_UI_SIZE.height / 2;
        this.winPanel.removeAllChildren();

        var w = this.winPanel.width;
        var h = this.winPanel.height;
        var label = this.numLabel = new cc.LabelTTF(this.textObj, "宋体", 30);
        label.x = w/2;
        label.y = h/2 + 20;
        label.textAlign = cc.LabelTTF.TEXT_ALIGNMENT_CENTER;
        label.color = cc.color(3,2,15);
        this.winPanel.addChild(label);

        var OKbtn = new cc.MenuItemImage(
            res.s_ok_btn,
            res.s_ok_btn,
            function(){
                cc.log('OKbtn');
                self.onExit();
            }
        );
        OKbtn.x = w/2 - 120;
        OKbtn.y = h/2 - 80;

        OKbtn.setTag(1);
        var Cancelbtn = new cc.MenuItemImage(
            res.s_cancel_btn,
            res.s_cancel_btn,
            function(){
                cc.log('Cancelbtn');
                    self.onExit();
            }
        );
        Cancelbtn.x =  w/2 + 120;
        Cancelbtn.y = h/2 - 80;
        Cancelbtn.setTag(2);
        var menu = new cc.Menu(OKbtn,Cancelbtn);
        menu.x=0;
        menu.y=0;
        this.winPanel.addChild(menu);
        this.activate = true;
    },
    onExit : function () {
        this._super();
        this.activate = false;
        this.removeChild(this.winPanel);
        this.removeChild(this.zzLayer);
        cc.eventManager.removeListener(this.listener);
    }
});

var ConfirmScene = cc.Scene.extend({
    onEnter:function () {
        this._super();
        var layer = new ConfirmBetUI();
        this.addChild(layer);
    }
});
