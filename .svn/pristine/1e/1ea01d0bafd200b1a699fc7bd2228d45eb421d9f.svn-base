/**
 * Created by Administrator on 2016/3/29.
 */
var UserList  = cc.Layer.extend({
    m_tableView:null,
    ctor : function (type) {
        this._super();
        this.showTableView();
    },

    showTableView : function( ) {
        this._tableView = new MultiColTableView(this, cc.size(800, 600), null);
        this._tableView.setDirection(cc.SCROLLVIEW_DIRECTION_HORIZONTAL);
        this._tableView.setVerticalFillOrder(cc.TABLEVIEW_FILL_TOPDOWN);
        this._tableView.setMultiTableViewDelegate(this);
        this._tableView.ignoreAnchorPointForPosition(false);
        this._tableView.setAnchorPoint(cc.p(0.5, 0.5));
        this.addChild(this._tableView);
        this._tableView.reloadData();
    },

    scrollViewDidScroll : function( view) {
    },

    gridAtIndex : function(multiTable,  idx) {

        var cell = multiTable.dequeueGrid();
        if(!cell){
            cell = new cc.Layer();
        }
        return cell;
    } ,

    numberOfCellsInTableView : function(multiTable) {
        return 3;
    },

    numberOfGridsInCell : function(multiTable) {
        return 3;
    },

    gridSizeForTable : function(table) {
       return cc.size(100,100);
    },

    gridTouched : function( table, grid) {
        cc.log("gridTouched");

    }

}) ;