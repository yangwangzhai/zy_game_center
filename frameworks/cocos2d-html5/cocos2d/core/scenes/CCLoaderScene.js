/****************************************************************************
 Copyright (c) 2011-2012 cocos2d-x.org
 Copyright (c) 2013-2014 Chukong Technologies Inc.

 http://www.cocos2d-x.org

 Permission is hereby granted, free of charge, to any person obtaining a copy
 of this software and associated documentation files (the "Software"), to deal
 in the Software without restriction, including without limitation the rights
 to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 copies of the Software, and to permit persons to whom the Software is
 furnished to do so, subject to the following conditions:

 The above copyright notice and this permission notice shall be included in
 all copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 THE SOFTWARE.
 ****************************************************************************/
/**
 * <p>cc.LoaderScene is a scene that you can load it when you loading files</p>
 * <p>cc.LoaderScene can present thedownload progress </p>
 * @class
 * @extends cc.Scene
 * @example
 * var lc = new cc.LoaderScene();
 */
cc.LoaderScene = cc.Scene.extend({
    _interval : null,
    _label : null,
    _className:"LoaderScene",
    _redSprite:[],
    /**
     * Contructor of cc.LoaderScene
     * @returns {boolean}
     */
    init : function(){
        var self = this;

        var size = cc.winSize;

        //logo
        var logoWidth = 160;
        var logoHeight = 200;

        // bg
        var bgLayer = self._bgLayer = new cc.LayerColor(cc.color(32, 32, 32, 255));
        bgLayer.setPosition(cc.visibleRect.bottomLeft);
        self.addChild(bgLayer, 0);

        //image move to CCSceneFile.js
        var fontSize = 24, lblHeight =  -logoHeight / 2 + 100;
        if(cc._loaderImage){
            //loading logo
            cc.loader.loadImg(res.s_jia_zai_bei_jing_jpg, {isCrossOrigin : false }, function(err, img){
                logoWidth = img.width;
                logoHeight = img.height;
                self._initStage(img, cc.visibleRect.center);
            });
            fontSize = 38;
            lblHeight = -logoHeight / 2 - 10;
        }
        //running
        //cc.spriteFrameCache.addSpriteFrames(res.run_plist);                  //引入plist
        var run = new cc.Sprite("static/gameroom/redrain/res/tiao_yue_dong_hua_1.png");                            //选取其中一张图片定位
        run.attr({
            anchorX:0.5,
            anchorY:0.5,
            x:size.width/2,
            y:460,
            scale: 0.8
        });
        this.addChild(run,100);

        var animation = cc.Animation.create();//创建动画对象
        for (var i = 1; i < 5; i++) { //循环加载每一帧图片 v
            var frameName = "static/gameroom/redrain/res/tiao_yue_dong_hua_" + i + ".png";//图片命名为01-14.png,两位数即10以下为"0" + i,两位数以上为i
            animation.addSpriteFrameWithFile(frameName);
        }
        animation.setDelayPerUnit(1 / 4); //设置每一帧动画间隔时间,单位s,此处2.8 / 14表示，一共14帧动画, 播放时间2.8s;
        animation.setRestoreOriginalFrame(true); //设置动画播放完毕后，是否重置为原始帧
        var action = cc.Animate.create(animation); //cc.Animate是cc.Action动作类的子类，创建一个以animation为动画对象的动画动作
        //this.spriteTopBg.runAction(cc.Sequence.create(action, action.reverse())); //执行动画

        //重复运行Action，不断的转圈
        run.runAction(cc.RepeatForever.create(action));

  
        

        //loading percent
        var label = self._label = cc.LabelTTF.create("红包雨正在来袭... 0%", "Arial", fontSize);
        label.setPosition(cc.pAdd(cc.visibleRect.center, cc.p(0, lblHeight-250)));
        label.setColor(cc.color(255, 255, 255));
        bgLayer.addChild(this._label, 20);

        this.schedule(this.addRed,0.1);
        this.schedule(this.removeRed,0.01);
        return true;
    },

    addRed : function(){
        var size = cc.winSize;
        var red = new cc.Sprite(res.small_red);                            //选取其中一张图片定位
        red.attr({
            anchorX:0.5,
            anchorY:0.5,
            x:size.width*cc.random0To1(),
            y:size.height,
            scale: 0.7
        });
        
        var dorpAction = cc.MoveTo.create(1, cc.p(red.x-150,500));
            red.runAction(dorpAction);
        this._redSprite.push(red);
        red.index = this._redSprite.length;
        this.addChild(red,100);

        
    },

    removeRed : function() {
        //移除到屏幕底部的sushi
        for (var i = 0; i < this._redSprite.length; i++) {
            //cc.log("removeSushi.........");
            if(550 > this._redSprite[i].y) {
                //cc.log("==============remove:"+i);
                this._redSprite[i].removeFromParent();
                this._redSprite[i] = undefined;
                this._redSprite.splice(i,1);
                i= i-1;
            }
        }
        
    },

    _initStage: function (img, centerPos) {
        var self = this;
        var texture2d = self._texture2d = new cc.Texture2D();
        texture2d.initWithElement(img);
        texture2d.handleLoadedTexture();
        var logo = self._logo = cc.Sprite.create(texture2d);
        logo.setScale(cc.contentScaleFactor());
        logo.x = centerPos.x;
        logo.y = centerPos.y;
        self._bgLayer.addChild(logo, 10);
    },
    /**
     * custom onEnter
     */
    onEnter: function () {
        var self = this;
        cc.Node.prototype.onEnter.call(self);
        self.schedule(self._startLoading, 0.3);
    },
    /**
     * custom onExit
     */
    onExit: function () {
        cc.Node.prototype.onExit.call(this);
        var tmpStr = "红包雨正在来袭... 0%";
        this._label.setString(tmpStr);
    },

    /**
     * init with resources
     * @param {Array} resources
     * @param {Function|String} cb
     */
    initWithResources: function (resources, cb) {
        if(cc.isString(resources))
            resources = [resources];
        this.resources = resources || [];
        this.cb = cb;
    },

    _startLoading: function () {
        var self = this;
        self.unschedule(self._startLoading);
        var res = self.resources;
        cc.loader.load(res,
            function (result, count, loadedCount) {
                var percent = (loadedCount / count * 100) | 0;
                percent = Math.min(percent, 100);
                self._label.setString("红包雨正在来袭... " + percent + "%");
            }, function () {
                if (self.cb)
                    self.cb();
            });
    }
});
/**
 * <p>cc.LoaderScene.preload can present a loaderScene with download progress.</p>
 * <p>when all the resource are downloaded it will invoke call function</p>
 * @param resources
 * @param cb
 * @returns {cc.LoaderScene|*}
 * @example
 * //Example
 * cc.LoaderScene.preload(g_resources, function () {
        cc.director.runScene(new HelloWorldScene());
    }, this);
 */
cc.LoaderScene.preload = function(resources, cb){
    var _cc = cc;
    if(!_cc.loaderScene) {
        _cc.loaderScene = new cc.LoaderScene();
        _cc.loaderScene.init();
    }
    _cc.loaderScene.initWithResources(resources, cb);

    cc.director.runScene(_cc.loaderScene);
    return _cc.loaderScene;
};