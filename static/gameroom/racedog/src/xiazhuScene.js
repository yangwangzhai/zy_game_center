/**
 * Created by Administrator on 2016/4/4 0004.
 */

var XiazhuLayer = cc.Layer.extend({
    sprite:null,
    ctor:function (time) {
        //////////////////////////////
        // 1. super init first
        this._super();

        /////////////////////////////
        // 2. add a menu item with "X" image, which is clicked to quit the program
        //    you may modify it.
        // ask the window size
        var size = cc.winSize;

        //告诉服务器端有用户登录
        socket.emit('xiazhu', {userid:'lkl', username:'game'});

        //监听新用户登录
      /*  socket.on('login', function(o){
            cc.log(o.seconds);
            if(o.seconds < 25){
                cc.director.runScene(new XiazhuScene());
            }
        });*/

        //监听用户退出
        socket.on('logout', function(o){
            cc.log(o);
        });

        //监听开始命令
        socket.on('start', function(o){
            cc.log(o);
            cc.director.runScene(new XiazhuScene());
        });

        //监听消息发送
        socket.on('message', function(obj){
            cc.log(obj);
        });

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

       // cc.log('传过来的时间是'+ time.msg);

        /////////////////////////////
        // 3. add your codes below...
        // add a label shows "Hello World"
        // create and initialize a label
        var xiazhuLabel = new cc.LabelTTF("结算中....", "Arial", 38);
        // position the label on the center of the screen
        xiazhuLabel.x = size.width / 2;
        xiazhuLabel.y = size.height / 2;
        // add the label as a child to this layer
        this.addChild(xiazhuLabel, 5);



        return true;
    }
});

var XiazhuScene = cc.Scene.extend({
    _time:null,
    ctor:function(time){
        this._super();
        this._time = time;
    },
    onEnter:function () {
        this._super();
        var layer = new XiazhuLayer(this._time);
        this.addChild(layer);
    }
});

