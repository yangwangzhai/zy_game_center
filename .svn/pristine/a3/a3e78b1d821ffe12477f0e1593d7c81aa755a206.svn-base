var RaceLayer = cc.Layer.extend({
    sprite:null,
    ctor:function () {
        //////////////////////////////
        // 1. super init first
        this._super();

        /////////////////////////////
        // 2. add a menu item with "X" image, which is clicked to quit the program
        //    you may modify it.
        // ask the window size
        var size = cc.winSize;

        /////////////////////////////
        // 3. add your codes below...
        // add a label shows "Hello World"
        // create and initialize a label
        var raceLabel = new cc.LabelTTF("这是比赛场景....", "Arial", 38);
        // position the label on the center of the screen
        raceLabel.x = size.width / 2;
        raceLabel.y = size.height / 2;
        // add the label as a child to this layer
        this.addChild(raceLabel, 5);



        return true;
    }
});

var RaceScene = cc.Scene.extend({
    onEnter:function () {
        this._super();
        var layer = new RaceLayer();
        this.addChild(layer);
    }
});

