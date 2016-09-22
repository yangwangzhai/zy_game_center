/**
 * Created by Administrator on 2016/3/29.
 */
cc.MultiColTableViewDelegate = cc.Class.extend({
    gridTouched:function(table,grid){

    }
});
cc.MultiColTableViewDataSource = cc.Class.extend({
    gridAtIndex:function(table,idx){
        return null;
    },
    numberOfCellsInTableView:function(table){
        return 0;
    },
    numberOfGridsInCell:function(table){
        return 0;
    },
    gridSizeForTable:function(table){
        return cc.size(0,0);
    }
});
//最后实现多行多列控件：
cc.TABLEVIEW_FILL_LEFT_RIGHT = 0;
cc.TABLEVIEW_FILL_RIGHT_LEFT = 0;

/**
 * Sole purpose of this delegate is to single touch event in this version.
 */
cc.MultiColTableViewDelegate = cc.Class.extend(/** @lends cc.MultiColTableViewDelegate# */{
    gridTouched:function(table,grid){
    }
});

/**
 * Data source that governs table backend data.
 */
cc.MultiColTableViewDataSource = cc.Class.extend(/** @lends cc.TableViewDataSource# */{
    gridAtIndex:function(table,idx){
        return null;
    },
    numberOfCellsInTableView:function(table){
        return 0;
    },
    numberOfGridsInCell:function(table, idx){
        return 0;
    },
    gridSizeForTable:function(table, idx){
        return cc.size(0,0);
    }
});

var MultiColTableView = cc.LayerColor.extend({
    _multiTableViewDataSource: null,
    _multiTableViewDelegate: null,
    _horizontalOrder: cc.TABLEVIEW_FILL_LEFT_RIGHT,
    _gridsFreed: null,
    _curTouchLocation: null,

    _tableView: null,
    _touchNode: null,

    /**
     * @param dataSource
     * @param {cc.Size} size
     * @param container
     */
    ctor: function (dataSource, size, container) {
        this._super(cc.color(0, 0, 255, 0), size.width, size.height);
        this._gridsFreed = [];
        this.setMultiTableViewDataSource(dataSource);
        this._tableView = new cc.TableView(this, size, container);
        this._tableView.setDelegate(this);
        this.addChild(this._tableView);
        this._touchNode = new cc.Node();
        this._tableView.addChild(this._touchNode,1);
    },

    onEnter: function () {
        this._super();
        cc.eventManager.addListener({
            event: cc.EventListener.TOUCH_ONE_BY_ONE,
            swallowTouches: false,
            onTouchBegan: this.onTouchBegan.bind(this)
        }, this._touchNode);
    },

    dequeueGrid: function () {
        if (this._gridsFreed.length == 0) {
            return null;
        } else {
            return this._gridsFreed.shift();
        }
    },

    tableCellSizeForIndex: function (table, idx) {
        var size = this.getMultiTableViewDataSource().gridSizeForTable(this, idx);

        if (table.getDirection() === cc.SCROLLVIEW_DIRECTION_HORIZONTAL) {
            size.height *= this.getMultiTableViewDataSource().numberOfGridsInCell(this, idx);
        } else {
            size.width *= this.getMultiTableViewDataSource().numberOfGridsInCell(this, idx);
        }
        return size;
    },

    tableCellAtIndex: function (table, idx) {
        var grid;
        var numberOfGridsInCell = this.getMultiTableViewDataSource().numberOfGridsInCell(this, idx);
        var cell = table.dequeueCell();
        if (!cell) {
            cell = new cc.TableViewCell();
        } else {
            var children = cell.getChildren();
            for (var i = children.length - 1; i >= 0; --i) {
                grid = children[i];
                if (grid instanceof cc.TableViewCell) {
                    this._gridsFreed.push(grid);
                    grid.visible = false;
                }
            }
        }
        var startIndex = 0;
        for (var localIdx = 0; localIdx < idx; ++localIdx) {
            startIndex += this.getMultiTableViewDataSource().numberOfGridsInCell(this, localIdx);
        }
        var gridSize = this.getMultiTableViewDataSource().gridSizeForTable(this, idx);
        for (var gridIdx = startIndex, colIdx = 0; gridIdx < (numberOfGridsInCell + startIndex); gridIdx++, colIdx++) {
            grid = this.getMultiTableViewDataSource().gridAtIndex(this, gridIdx);
            if (grid) {
                grid.setIdx(gridIdx);
                grid.setAnchorPoint(cc.p(0, 0));
                if (table.getDirection() === cc.SCROLLVIEW_DIRECTION_HORIZONTAL) {
                    if (table.getVerticalFillOrder() === cc.TABLEVIEW_FILL_TOPDOWN) {
                        grid.setPosition(cc.p(0, gridSize.height * (numberOfGridsInCell - colIdx - 1)));
                    } else {
                        grid.setPosition(cc.p(0, gridSize.height * colIdx));
                    }
                } else {
                    grid.setPosition(cc.p(gridSize.width * colIdx, 0));
                }
                if (grid.getParent()) {
                    grid.retain();
                    grid.removeFromParent(false);
                    cell.addChild(grid);
                    grid.release();
                } else {
                    cell.addChild(grid);
                }
            } else {
                cc.log("grid is null");
            }
        }
        return cell;
    },

    numberOfCellsInTableView: function (table) {
        return this.getMultiTableViewDataSource().numberOfCellsInTableView(this);
    },

    tableCellTouched: function (table, cell) {
        if (!this.getMultiTableViewDelegate()) {
            return;
        }
        for (var i = 0; i < cell.getChildren().length; i++) {
            var grid = cell.getChildren()[i];
            grid.setContentSize(this.getMultiTableViewDataSource().gridSizeForTable(this, cell.getIdx()));
            if (grid != null && this.isTouchInside(grid, this._curTouchLocation)) {
                this.getMultiTableViewDelegate().gridTouched(this, grid);
                break;
            }
        }
    },

    scrollViewDidScroll: function (view) {
        if (this._multiTableViewDelegate && this._multiTableViewDelegate.scrollViewDidScroll) {
            this._multiTableViewDelegate.scrollViewDidScroll(this);
        }
    },

    tableCellWillRecycle: function (table, cell) {
    },

    tableCellHighlight:function(table, cell){
    },

    tableCellUnhighlight:function(table, cell){
    },

    onTouchBegan: function (touch, event) {
        this._curTouchLocation = touch.getLocation();
        return false;
    },

    getMultiTableViewDataSource: function () {
        return this._multiTableViewDataSource;
    },
    setMultiTableViewDataSource: function (dataSource) {
        this._multiTableViewDataSource = dataSource;
    },

    getMultiTableViewDelegate: function () {
        return this._multiTableViewDelegate;
    },

    setMultiTableViewDelegate: function (delegate) {
        this._multiTableViewDelegate = delegate;
    },

    setHorizontalOrder: function (order) {
        this._horizontalOrder = order;
    },
    getHorizontalOrder: function () {
        return this._horizontalOrder;
    },

    isTouchInside: function (owner, touchLocation) {
        if (!owner || !owner.getParent()) {
            return false;
        }
        touchLocation = owner.getParent().convertToNodeSpace(touchLocation);
        return cc.rectContainsPoint(owner.getBoundingBox(), touchLocation);
    },

    reloadData: function () {
        this._tableView.reloadData();
    },

    setContentOffset: function (offset, animated) {
        return this._tableView.setContentOffset(offset, animated);
    },

    getContentOffset:function () {
        return this._tableView.getContentOffset();
    },

    minContainerOffset:function () {
        return this._tableView.minContainerOffset();
    },

    maxContainerOffset:function () {
        return this._tableView.maxContainerOffset();
    },

    setDirection:function (direction) {
        this._tableView.setDirection(direction);
    },

    /**
     * determines how cell is ordered and filled in the view.
     */
    setVerticalFillOrder: function (fillOrder) {
        this._tableView.setVerticalFillOrder(fillOrder);
    },

    setContentOffsetInDuration: function (offset, dt) {
        this._tableView.setContentOffsetInDuration(offset, dt);
    }
});