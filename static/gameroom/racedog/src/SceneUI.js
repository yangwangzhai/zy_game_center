/**
 * Created by Administrator on 2016/3/24.
 */
var  FAIL_UI_SIZE = cc.size(292, 277);
var SceneUI = cc.Layer.extend({
    activate : false,
    
    winPanel : null,
    zzLayer : null,
    listener : null,
    firstReturn: true,
    ctor : function () {
        this._super(cc.color(10,10,10,100),640,960);
        this.zzLayer = new cc.LayerColor(cc.color(10,10,10,100));

        var size = cc.winSize;
        var self = this;


        this.winPanel = new cc.Sprite(res.s_pop4);
        this.winPanel.x = (cc.winSize.width )/2 ;
        this.winPanel.anchorY = 0.5;
        this.winPanel.y = cc.winSize.height/2;

        

        


        this.zzLayer.addChild(this.winPanel);
        this.addChild( this.zzLayer);



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
        var size = cc.winSize;
        var miny = cc.winSize.height/2 - FAIL_UI_SIZE.height / 2;



        this.winPanel.removeAllChildren();

        var w = this.winPanel.width, h = this.winPanel.height;

        

        

        var scene1 = new cc.Sprite(res.s_scene1);
        scene1.attr({
            x: w*0.6,
            y: h*0.8,
            scale:0.7,
            bg : 'runbg.jpg'
        });
        var selected = new cc.Sprite(res.s_ok);
        selected.x = 10;
        selected.y = 10;
        if(scene_bg == scene1.bg){
            scene1.addChild(selected);
        }
        
        this.winPanel.addChild(scene1);

        var scene2 = new cc.Sprite("scene2.png");
        scene2.attr({
            x: w*0.6,
            y: h*0.5,
            scale:0.7,
            bg : 'runbg01.jpg'
        });
        var selected = new cc.Sprite(res.s_ok);
        selected.x = 10;
        selected.y = 10;
        if(scene_bg == scene2.bg){
            scene2.addChild(selected);
        }
        
        this.winPanel.addChild(scene2);

        var scenes = [scene1,scene2];

        

        var listener = cc.EventListener.create({
            event: cc.EventListener.TOUCH_ONE_BY_ONE,
            onTouchBegan: function (touch, event) {
                var target = event.getCurrentTarget();
             //   if (!target.activate) return;
                // 获取当前触摸点相对于按钮所在的坐标
                var locationInNode = target.convertToNodeSpace(touch.getLocation());
                var s = target.getContentSize();
                var rect = cc.rect(0, 0, s.width, s.height);
                if (cc.rectContainsPoint(rect, locationInNode)) {       // 判断触摸点是否在按钮范围内
                    
                    target.removeAllChildren();
                    for(key in scenes){
                        scenes[key].removeAllChildren();
                    }
                    var selected = new cc.Sprite(res.s_ok);
                    selected.x = 10;
                    selected.y = 10;
                    target.addChild(selected);

                    scene_bg = target.bg;
                    var runbg = self.getParent().getParent().getChildByTag(10);
                    var pos = runbg.getPosition();
                    runbg.initWithFile(scene_bg);
                    runbg.setAnchorPoint(0, 1);
                    runbg.setPosition(pos);
                    runbg.setScale(0.65);
                    runbg.setTag(10);
                
                    return true;
                }
                return false;

            }
        });

        cc.eventManager.addListener(listener, scene1);
        cc.eventManager.addListener(listener.clone(), scene2);
        

        var OKbtn = new cc.MenuItemImage(
            res.s_close,
            res.s_close,
            function(){
                self.onExit();
            }
        );
        OKbtn.x = w - 47;
        OKbtn.y = 50;

        OKbtn.setTag(2);
        var menu = new cc.Menu(OKbtn);
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

var SceneUIScene = cc.Scene.extend({
    onEnter:function () {
        this._super();
        var layer = new SceneUI();
        this.addChild(layer);
    }
});
