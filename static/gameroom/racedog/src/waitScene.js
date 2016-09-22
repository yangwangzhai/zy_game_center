/**
 * Created by Administrator on 2016/4/4 0004.
 */
var _sioClient = null;
var SocketIO = io;

var WaitLayer = cc.Layer.extend({
    sprite:null,
    time:null,
    ctor:function () {
        //////////////////////////////
        // 1. super init first
        this._super();

        var self = this;

        /////////////////////////////
        // 2. add a menu item with "X" image, which is clicked to quit the program
        //    you may modify it.
        // ask the window size
        var size = cc.winSize;


        var waitL = this;
        //告诉服务器端有用户登录
        socket.emit('login', {userid:'lkl', username:'game'});

        //监听新用户登录
        socket.on('login', function(o){
            cc.log(o.seconds);
            if(o.seconds < 25){
                cc.director.runScene(new StartScene(o));
            }else{
                var waitLabel = new cc.LabelTTF("比赛进行中，请稍后....", "Arial", 38);
                waitLabel.x = size.width / 2;
                waitLabel.y = size.height / 2;
                // add the label as a child to this layer
                waitL.addChild(waitLabel, 5);

            }
        });

        //监听用户退出
        socket.on('logout', function(o){
            cc.log(o);
        });

        //监听开始命令
        socket.on('start', function(o){
            cc.log(o);
            cc.director.runScene(new XiazhuScene(o));
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



        //监听消息发送
        socket.on('message', function(obj){
           cc.log(obj);
        });

        return true;
    },


});

var WaitScene = cc.Scene.extend({
    onEnter:function () {
        this._super();
        var layer = new WaitLayer();
        this.addChild(layer);
    }
});

