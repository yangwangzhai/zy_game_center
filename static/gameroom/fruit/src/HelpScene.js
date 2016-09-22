/**
 * Created by Administrator on 2016/3/24.
 */
var  FAIL_UI_SIZE = cc.size(600, 900);
var HelpUI = cc.Layer.extend({
    activate : false,
    notifySprite :null,
    replaySprite :null,
    win : false,
    tipText : null,
    winPanel : null,
    zzLayer : null,
    listener : null,
    maxTime: 300,
    firstReturn: true,
    ctor : function (tip,time) {
        this._super(cc.color(10,10,10,100),640,960);
        this.zzLayer = new cc.LayerColor(cc.color(10,10,10,100));
        if(typeof(time) != "undefined" && time != null)  this.maxTime = time;

        this.tipText = tip;
        var size = cc.winSize;
        var self = this;


        this.winPanel = new cc.Sprite(res.s_rule_bg);
        this.winPanel.x = (cc.winSize.width )/2 ;
        this.winPanel.anchorY = 0.5;
        this.winPanel.y = cc.winSize.height/2;
       // this.addChild(this.winPanel,5);
        this.addChild( this.zzLayer,1);


        self.helpTips = new cc.Sprite(res.s_rule_bg);
        self.helpTips.attr({
            x:size.width/2,
            y:size.height/2
        });
        var scrollView = new ccui.ScrollView();
        //设置方向
        scrollView.setDirection(ccui.ScrollView.DIR_VERTICAL);
        //触摸的属性
        scrollView.setTouchEnabled(true);
        //弹回的属性
        //scrollView.setBounceEnabled(true);
        //滑动的惯性
        //scrollView.setInertiaScrollEnabled(true);
        //scrollView.setBackGroundImageScale9Enabled(true);

        scrollView.setContentSize(cc.size(self.helpTips.width+90, self.helpTips.height-110));
        //设置容器的大小 这个容器就是存放scrollview添加的节点，需要设置他的位置，上面已经讲清楚
        //scrollView.setInnerContainerSize(cc.size(self.helpTips.width, self.helpTips.height-110));
        //可以添加触摸事件监听器
        //scrollView.addTouchEventListener(this.scrollviewCall,this);
        //锚点默认是 （0,0）
        scrollView.setAnchorPoint(0.5,0.5);
        scrollView.x = self.helpTips.width/2-30;
        scrollView.y = self.helpTips.height/2 - 30;

        //自己新建一个节点


        var textView = new ccui.Text();
        var ruleText = "游戏介绍：\n";
            ruleText +="       游戏中的物品有八种，分别为：苹果、柠檬、橙子、石榴、西瓜、樱桃、双7，这些物品又分为大小两种，还有BAR图标，共有3种。";
            ruleText +="\n       正方形游戏区下方为押注区，押注区中列出各种物品和其相关的赔率。每种物品下方有“押注”按钮，每次点击增加1个龙币注金，每种物品的押注上限都为99。点击开始后跑灯停留在对应押注水果，则赢取的龙币是下注数乘以倍率。如果转到GoodLucky，系统会自动重新跑一次。";
            ruleText +="\n       猜大小，玩家中奖之后都可以进行猜大小，1-7 为小 ， 8-14为大。玩家可以点击“大”或者“小”按钮进行猜大小。如果猜中，则会赢取玩家在“奖金”区中一样的龙币。玩家猜中大小之后仍然可以再次猜大小。";
            ruleText +="\n       玩家如果中奖之后，可以将“财富”区中的龙币划拨进“奖金”区。划拨的上限为“财富”区的龙币。相对的，玩家也可以将“奖金”区的龙币划拨入“财富”区。当玩家猜中大小后，还可以再次划拨进行猜大小。";
            ruleText +="\n       赔率：以下为所有固定赔率物品的赔率。所有其他小的物品（小77、小樱桃、小西瓜、小石榴、小橙子、小柠檬、小苹果）为 1:2 ，苹果 1:5，柠檬 1:10，橙子 1:15，石榴 1:20，西瓜 1:25，樱桃 1:30，77 1:35，小BAR 1:20，大BAR 1:40 。";
        textView.setString(ruleText);
        textView.fontSize = 30;
        textView.fontName = '楷体';
        textView.ignoreContentAdaptWithSize(false);
        textView.setSize(cc.size(420, textView.height+1200));
        textView.setAnchorPoint(0.5,1);
        textView.y = textView.height;
        textView.x = scrollView.width/2 + 30;
        textView.setColor(cc.color(3, 2, 15));//255, 242, 93

        scrollView.addChild(textView);
        var innerWidth = scrollView.width;
        var innerHeight = textView.height;

        scrollView.setInnerContainerSize(cc.size(innerWidth, innerHeight));
        self.helpTips.addChild(scrollView);
        self.addChild(self.helpTips,10);





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
        cc.eventManager.addListener(this.listener, this.zzLayer);



    },
    onEnter : function () {
        this._super();
        var self = this;
        var miny = cc.winSize.height/2 - FAIL_UI_SIZE.height / 2;

        this.winPanel.removeAllChildren();
        var w = this.winPanel.width, h = this.winPanel.height;
        var OKbtn = new cc.MenuItemImage(
            res.s_close_btn,
            res.s_close_btn,
            function(){
                self.onExit();
            }
        );
        OKbtn.x = w - 52;
        OKbtn.y = h - 41;
        OKbtn.scale = 1.12;

        OKbtn.setTag(2);
        var menu = new cc.Menu(OKbtn);
        menu.x=0;
        menu.y=0;
        this.helpTips.addChild(menu,20);

        this.activate = true;
    },
    onExit : function () {
        this._super();
        this.activate = false;
        this.removeChild(this.winPanel);
        this.removeChild(this.helpTips);
        this.removeChild(this.zzLayer);
        cc.eventManager.removeListener(this.listener);
        this.getParent().isFirstReturn = true;//设置为
        return false;
    }
});

var HelpScene = cc.Scene.extend({
    onEnter:function () {
        this._super();
        var layer = new HelpUI();
        this.addChild(layer);
    }
});
