var BackgroundLayer = cc.Layer.extend({
    map00:null,
    map01:null,
    mapWidth:0,
    mapIndex:0,
    space:null,
    spriteSheet:null,
    objects:[],
    redline:null,

    ctor:function (space) {
        this._super();

        // clean old array here
        this.objects = [];
        this.space = space;

        this.init();
    },

    init:function () {
        this._super();

        var size = cc.winSize;

        this.map00 = new cc.TMXTiledMap(res.s_bg_map);
        this.map00.setScale(0.7);
        this.map00.setAnchorPoint(0.5,1);
        this.map00.setPosition(cc.p(size.width/2, size.height));
        this.addChild(this.map00);

        this.mapsize = this.map00.getContentSize();
        cc.log(size);

        this.map01 = new cc.TMXTiledMap(res.s_bg_map);
        this.map01.setScale(0.7);
        this.map01.setAnchorPoint(0.5,1);
        this.map01.setPosition(cc.p(size.width/2, size.height-this.mapsize.height*0.7));
        this.addChild(this.map01);

        this.redline = new cc.Sprite(res.s_RedLine);
        //this.redline.setAnchorPoint(0.5, 0.5);
        this.redline.setRotation(90);
        //this.redline.setPosition(0,342);
        this.redline.attr({
            x: size.width/2,
            y: size.height-(this.mapsize.height*0.7)+220
        });
        this.addChild(this.redline, 100);

        // create sprite sheet
        //cc.spriteFrameCache.addSpriteFrames(res.background_plist);
        this.spriteSheet = new cc.SpriteBatchNode(res.s_coin);
        this.addChild(this.spriteSheet);


        //this.loadObjects(this.map00, 0);
        //this.loadObjects(this.map01, 1);

        this.scheduleUpdate();
    },

    checkAndReload:function () {
        /*var newMapIndex = parseInt(eyeX / this.mapheight);
        if (this.mapIndex == newMapIndex) {
            return false;
        }

        if (0 == newMapIndex % 2) {
            // change mapSecond
            this.map01.setPositionX(this.mapWidth * (newMapIndex + 1));
            this.loadObjects(this.map01, newMapIndex + 1);

        } else {
            // change mapFirst
            this.map00.setPositionX(this.mapWidth * (newMapIndex + 1));
            this.loadObjects(this.map00, newMapIndex + 1);

        }

        this.removeObjects(newMapIndex - 1);
        this.mapIndex = newMapIndex;*/

        this.map00.y += 10;
        this.map01.y += 10;
        this.redline.y += 10;

        return true;
    },

    update:function (dt) {
        //var animationLayer = this.getParent().getChildByTag(TagOfLayer.Animation);
        //var eyeX = animationLayer.getEyeX();
        this.checkAndReload();

    }
});
var BackgroundScene = cc.Scene.extend({
    onEnter:function () {  
        this._super();  
        var layer = new BackgroundLayer();
        this.addChild(layer);  
    }  
});