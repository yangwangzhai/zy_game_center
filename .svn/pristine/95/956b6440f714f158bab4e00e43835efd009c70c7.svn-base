var layers = {};
var StartLayer = cc.Layer.extend({
	bgSprite:null,
	scoreLabel:null,
    _tabelNumber:null,
    _tableView :null,
    wsServer:null,
    ws:null,
    isConnect : null,
    userid : null,
    username : null,
    timeLabel : null,
    timeLeft : null,
	ctor:function (time) {
		//////////////////////////////
		// 1. super init first
		this._super();

		var size = cc.winSize;

		// add bg
		this.bgSprite = new cc.Sprite(res.s_RunBg);
		this.bgSprite.attr({
			x: size.width / 2,
			y: size.height / 2,
            type: 'n'
           // scale: 0.5,
		});
		this.addChild(this.bgSprite, 0);
		
		//add start menu
		var startItem = new cc.MenuItemImage(
				res.s_Start_N,
				res.s_Start_S,
				function () {
					cc.log("Menu is clicked!");
					//cc.director.replaceScene(cc.TransitionFade(1.2, new PlayScene()));
					//cc.director.replaceScene( cc.TransitionPageTurn(1, new PlayScene(), false) );//浏览器不支持
					 cc.director.runScene(new PlayScene());
				}, this);
		startItem.attr({
			x: size.width/2,
			y: size.height/2,
			anchorX: 0.5,
			anchorY: 0.5
		});





		var menu = new cc.Menu(startItem);
		menu.x = 0;
		menu.y = 0;
		this.addChild(menu, 1);






        //	layers.UserList = new UserList();
	//	this.addChild(layers.UserList);


        this._tabelNumber = 10;
        var tableView = new cc.TableView(this, cc.size(600, 360));

        tableView.setDirection(cc.SCROLLVIEW_DIRECTION_HORIZONTAL);  //设置table 方向,横向
        tableView.setDirection( cc.SCROLLVIEW_DIRECTION_VERTICAL); //众向
        tableView.x = 20;
        tableView.y = size.height / 2 - 150;
        tableView.setDelegate(this);
     //   this.addChild(tableView);

        tableView.reloadData();  //加载table

        this._tableView = tableView;

       /* var socket = io.connect('http://localhost:88');
        this.ws = socket;
        this.userid = this.genUid();
        this.username = "wb2";
        socket.emit('login', {userid:this.userid, username:this.username});
        socket.on('login', function(o){
           cc.log(o);
        });
        socket.on('message', function (data) {
           cc.log(data);
        });
*/



        //create the list view
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
        listView.setGravity(ccui.ListView.GRAVITY_CENTER_VERTICAL);
        this.addChild(listView);




        //监听服务端发送过来的开始赛跑命令
        socket.on('startRun', function(o){
            cc.log(o);
            cc.director.runScene(new PlayScene(o));
        });

        //监听服务端发送过来的开始结算命令
        socket.on('statement', function(o){
            cc.log(o);
            cc.director.runScene(new XiazhuScene(o));
        });

        //监听服务端发送过来的新的一局命令
        socket.on('newGame', function(o){
            cc.log(o);
            cc.director.runScene(new StartScene(o));
        });


        var seconds = 25 - 2;
        this.timeLabel = new cc.LabelTTF("时间："+ seconds, "Arial", 38);
        this.timeLabel.x = size.width / 2;
        this.timeLabel.y = size.height - 50;
        this.addChild(this.timeLabel, 5);
        this.schedule(this.countDown,1);
        this.timeLeft = 25;
        return true;
	},genUid:function() {
        return new Date().getTime() + "" + Math.floor(Math.random() * 899 + 100);
    } ,
    countDown:function(){

        this.timeLeft ++;
        var seconds = 25 - this.timeLeft;
        this.timeLabel.setString("时间："+ seconds);
    }, selectedItemEvent: function (sender, type) {
        switch (type) {
            case ccui.ListView.EVENT_SELECTED_ITEM:
                var listViewEx = sender;
                cc.log("select child index = " + listViewEx.getCurSelectedIndex());
                break;
            default:
                break;
        }
    },
    scrollViewDidScroll:function (view) {
    },
    scrollViewDidZoom:function (view) {
    },
    //每个cell 触摸事件
    tableCellTouched:function (table, cell) {

        var obj = {
            userid: this.userid,
            username: this.username,
            content: cell.getIdx()
        };
        this.ws.emit('message', obj);


        cc.log("cell touched at index: " + cell.getIdx());
        this._tableView.removeCellAtIndex(cell.getIdx());
        this._tabelNumber = this._tabelNumber-1;

       // this.bgSprite.s = new cc.Sprite(res.s_Start_N);



    },

    //设置编号为 idx 的cell的大小
    tableCellSizeForIndex:function (table, idx) {
        //if (idx == 2) {
        //    return cc.size(100, 100);
        //}
     //   console.log("tableCellSizeForIndex: "+idx);
        return cc.size(50, 60);

    },
    // 由于tableview是动态获取数据的，该方法在初始化时会被调用一次，之后在每个隐藏的cell显示出来的时候都会调用
    tableCellAtIndex:function (table, idx) {

     //   console.log("tableCellAtIndex|:  "+idx);

        var strValue = idx.toFixed(0);
        var cell = table.dequeueCell();
        var label;
        if (!cell) {
            cell = new cc.TableViewCell();

            var sprite = new cc.Sprite(res.s_RunBg);
            sprite.anchorX = 0;
            sprite.anchorY = 0;
            sprite.x = 0;
            sprite.y = 0;
            cell.addChild(sprite);

            label = new cc.LabelTTF(strValue, "Helvetica", 20.0);
            label.x = 0;
            label.y = 0;
            label.anchorX = 0;
            label.anchorY = 0;
            label.tag = 123;
            cell.addChild(label);
        } else {
            label = cell.getChildByTag(123);
            label.setString(strValue);
        }

        return cell;
    },

    numberOfCellsInTableView:function (table) {    // 设置 tabelview  的cell 个数
        return this._tabelNumber;
        //   return 10;
    },menuItemStartCallback:function(){
        this.bgSprite.initWithFile(res.s_RunBg);
        this.bgSprite.type = "s";
        cc.log(this.bgSprite.type);
    }
});

var StartScene = cc.Scene.extend({
    _time:null,
    ctor:function(time){
        this._super();
        this._time = time;
    },
	onEnter:function () {
		this._super();
		var layer = new StartLayer(this._time);
		this.addChild(layer);
	}
});