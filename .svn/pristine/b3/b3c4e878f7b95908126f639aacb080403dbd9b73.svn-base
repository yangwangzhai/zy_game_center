// JavaScript Document
var logoData = "data:image/jpeg;base64,/9............."; //图片的base64数据

MyLoading = cc.Scene.extend({
	_interval : null,
	_length : 0,
	_count : 0,
	_label : null,
	_winSize : null,
	_className:"MyLoading",
	_processLayer: null, 
	_processLayerLength: null,
	
	init : function(){
		var self = this;

		//logo
		var logoWidth = 160;
		var logoHeight = 200;

		// bg
		var bgLayer = self._bgLayer = cc.LayerColor.create(cc.color(32, 32, 32, 255));
		bgLayer.setPosition(cc.visibleRect.bottomLeft);
		self.addChild(bgLayer, 0);

		//image move to CCSceneFile.js
		var fontSize = 24, lblHeight =  -logoHeight / 2 + 100;
		if(cc._loaderImage){
			//loading logo
			cc.loader.loadImg(logoData, {isCrossOrigin : false }, function(err, img){
				logoWidth = img.width;
				logoHeight = img.height;
				self._initStage(img, cc.visibleRect.center);
			});
			fontSize = 14;
			lblHeight = -logoHeight / 2 - 10;
		}
		//loading percent
		var label = self._label = cc.LabelTTF.create("Loading... 0%", "Arial", fontSize);
		label.setPosition(cc.pAdd(cc.visibleRect.center, cc.p(0, lblHeight)));
		label.setColor(cc.color(180, 180, 180));
		bgLayer.addChild(this._label, 10);
		
		// 定义进度条层
		this._winSize = cc.director.getWinSize();
		var centerPos = cc.p(this._winSize.width / 2, this._winSize.height / 2);
		self._processLayerLength = 500;
		self._processLayer = cc.LayerColor.create(cc.color(255, 100, 100, 128), 1, 30);
		self._processLayer.setPosition(cc.pAdd(centerPos, cc.p(- this._processLayerLength / 2, -logoHeight / 2 - 50)));

		self._bgLayer.addChild(this._processLayer);		
		return true;
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

	onEnter: function () {
		var self = this;
		cc.Node.prototype.onEnter.call(self);
		self.schedule(self._startLoading, 0.3);
	},

	onExit: function () {
		cc.Node.prototype.onExit.call(this);
		var tmpStr = "Loading... 0%";
		this._label.setString(tmpStr);
	},

	/*
	 * init with resources
	 * @param {Array} resources
	 * @param {Function|String} cb
	 */
	initWithResources: function (resources, cb) {
		if(typeof resources == "string") resources = [resources];
		this.resources = resources || [];
		this.cb = cb;
	},

	_startLoading: function () {
		var self = this;
		self.unschedule(self._startLoading);
		var res = self.resources;
		self._length = res.length;
		self._count = 0;
		cc.loader.load(res, function(result, count){ self._count = count; }, function(){
			if(self.cb)
				self.cb();
		});
		self.schedule(self._updatePercent);
	},

	_updatePercent: function () {
		var self = this;
		var count = self._count;
		var length = self._length;
		var percent = (count / length * 100) | 0;
		percent = Math.min(percent, 100);
		self._label.setString("Loading... " + percent + "%");
		
		// 更新进度条的长度
		this._processLayer.changeWidth(this._processLayerLength * percent / 100);
		
		if(count >= length) self.unschedule(self._updatePercent);	
	}
});

MyLoading.preload = function(resources, cb){
	var _cc = cc;
	if(!_cc.myLoading) {
		_cc.myLoading = new MyLoading();
		_cc.myLoading.init();
	}
	_cc.myLoading.initWithResources(resources, cb);

	cc.director.runScene(_cc.myLoading);
	return _cc.myLoading;
};