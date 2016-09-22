/**
 * Created by Administrator on 2016/3/24.
 */
var MyScoreUI = cc.Layer.extend({
    
    ctor : function () {
        this._super();
        var listView = new ccui.ListView();
        listView.setDirection(ccui.ScrollView.DIR_VERTICAL);
        listView.setTouchEnabled(true);
        listView.setBounceEnabled(true);
        //listView.setBackGroundImage(res.listviewBg);
        //listView.setBackGroundImageScale9Enabled(true);
        //设置listview可见区域
        listView.setContentSize(cc.size(300, 200));
        listView.x = (cc.winSize.width - listView.width) / 2;
        listView.y = (cc.winSize.height - listView.height) / 2 - 20;
        listView.addEventListener(this.selectedItemEvent, this);
        // create model
        var default_label =new cc.LabelTTF("第0关","Microsoft YaHei",24);
 
        var default_item = new ccui.Layout();
        default_item.setTouchEnabled(true);
        default_item.setContentSize(cc.size(300,35));
        default_item.width = listView.width;
        default_item.addChild(default_label);
        // set model
        listView.setItemModel(default_item);
 
        for (var i = 0; i < 10; ++i) {
            // add default item
            listView.pushBackDefaultItem();
            // add custom item
            var lblMenu=new cc.LabelTTF("第"+(i+1)+"关","Microsoft YaHei",24);
            lblMenu.x = 150;
            lblMenu.y = 35 * -1*i;
 
            var lblLayer=new ccui.Layout();
            lblLayer.width = listView.width;
            lblLayer.addChild(lblMenu);
 
            listView.insertCustomItem(lblLayer);
        }
        // 设置所有item重力方向
        //listView.setGravity(ccui.ListView.GRAVITY_CENTER_VERTICAL);
        this.addChild(listView);
        
    },
    onEnter : function () {
        this._super();
    },
    onExit : function () {
        this._super();
    }
});

var MyScoreScene = cc.Scene.extend({
    onEnter:function () {
        this._super();
        var layer = new MyScoreUI();
        this.addChild(layer);
    }
});
