<?php $this->load->view('admin/header');?>
<script type="text/javascript">
    jQuery.Huifold = function(obj,obj_c,speed,obj_type,Event){
    	if(obj_type == 2){
    		$(obj+":first").find("b").html("-");
    		$(obj_c+":first").show();
    	}
    	$(obj).bind(Event,function(){
    		if($(this).next().is(":visible")){
    			if(obj_type == 2){
    				return false;
    			}
    			else{
    				$(this).next().slideUp(speed).end().removeClass("selected");
    				$(this).find("b").html("+");
    			}
    		}
    		else{
    			if(obj_type == 3){
    				$(this).next().slideDown(speed).end().addClass("selected");
    				$(this).find("b").html("-");
    			}else{
    				$(obj_c).slideUp(speed);
    				$(obj).removeClass("selected");
    				$(obj).find("b").html("+");
    				$(this).next().slideDown(speed).end().addClass("selected");
    				$(this).find("b").html("-");
    			}
    		}
    	});
    }
$(function($)
{
	$.Huifold("#Huifold1 .item h4","#Huifold1 .item .info","fast",2,"click"); /*5个参数顺序不可打乱，分别是：相应区,隐藏显示的内容,速度,类型,事件*/
	
});
function requet(method, id, RoomID){
	if(method == 'delete'){
		if(confirm('您确定要删除此条信息吗？')){
		}else{
			return false;
		}
	}
	location.href="index.php?d=admin&c=gameopeningAPI&m="+method+"&ID="+id+"&RoomID="+RoomID;
}

</script>
<style type="text/css">
    .Huifold .item{ position:relative}
    .Huifold .item h4{margin:0;font-weight:bold;position:relative;border-top: 1px solid #fff;color: #fff;font-size:14px;line-height:22px;padding:7px 10px;background-color:#56a2cf;cursor:pointer;padding-right:30px}
    .Huifold .item h4 b{position:absolute;display: block; cursor:pointer;right:10px;top:7px;width:16px;height:16px; text-align:center; color:#fff}
    .Huifold .item .info{display:none;padding:10px}
	.info .title{margin: 5px 0;}
	.info .title span{ color:#00F;}
	.apicontent { background: #e9e9e9 none repeat scroll 0 0;  border-radius: 6px;  padding: 10px;}
	.label, .badge{display: inline-block;padding:4px 5px;font-size: 11.844px;line-height:14px;color: #fff;white-space: nowrap;vertical-align: baseline;background-color: #999}
/*圆角*/
.label.radius{border-radius: 3px}
	/*主要*/
.label-primary, .badge-primary{background-color: #5a98de}
.label-primary[href], .badge-primary[href]{background-color: #5a98de}
 
/*主要*/
.label-secondary, .badge-secondary{background-color: #3bb4f2}
.label-secondary[href], .badge-secondary[href]{background-color: #3bb4f2}
 
/*成功*/
.label-success, .badge-success{background-color:#5eb95e}
.label-success[href], .badge-success[href]{background-color: #5eb95e}
 
/*警告*/
.label-warning, .badge-warning{background-color: #f37b1d}
.label-warning[href], .badge-warning[href]{background-color: #f37b1d}
 
/*危险*/
.label-danger, .badge-danger{background-color: #dd514c}
.label-danger[href], .badge-danger[href]{background-color: #dd514c}
</style>
<div class="col-xs-12 col-md-12">
<div class="widget">
<div class="well with-header wellpadding">
<div class="header bordered-blue">开放接口管理</div> 
<div>
	<div class="form-inline">
		<span>
			<form action="<?=$this->baseurl?>&m=index&RoomID=<?=$RoomID?>" method="post">
				<div class="form-group">
					<span class="input-icon">
						<input type="text" name="keywords" value="" class="form-control input-sm"> 
						<i class="glyphicon glyphicon-search blue"></i>
					</span>
				</div>
				<div class="form-group">
					<input type="submit" name="submit" value=" 搜索 " class="btn btn-blue">
				</div>
			</form>
		</span> 
	    <?=zy_btn('GameopeningAPI_add',' + 添加 ','class="btn btn-success"  onclick="location.href=\'index.php?d=admin&c=gameopeningAPI&m=add&RoomID='.$RoomID.'\'" ');?>
	
    </div>    
  
 
 
     <ul id="Huifold1" class="Huifold" style="margin-top: 10px;">
     
     <?php foreach($list as $val){?>
      <li class="item">
        <h4><?=$val['ApiName']?><b>+</b></h4>
        <div class="info"> 
        <span style="float:right;">                                        
            <span class="label label-primary radius" onclick="requet('copyrow','<?=$val['ID']?>','<?=$val['RoomID']?>')"  style="cursor:pointer;">复制</span>
            <span class="label label-secondary radius" onclick="requet('edit','<?=$val['ID']?>','<?=$val['RoomID']?>')" style="cursor:pointer;">修改</span>
            <span class="label label-danger radius" onclick="requet('delete','<?=$val['ID']?>','<?=$val['RoomID']?>')" style="cursor:pointer;">删除</span>                                      
    
        </span>
        <p class="title"><span>所属游戏: </span><?=$val['GameName']?></p>
        <p class="title"><span>接口说明: </span><?=$val['ApiDesc']?></p>
        <p class="title"><span>接口地址: </span><?=$val['ApiUrl']?></p>
        <p class="title"><span>请求方式: </span><?=$val['ApiMethod']?></p>
        <p class="title"><span>请求参数: </span><div class="apicontent"><?=$val['ApiRequet']?></div></p>
        <p class="title"><span>返回参数: </span><div class="apicontent"><?=$val['ApiReturn']?></div></p>
        
        </div>
      </li>
     <?php }?>
    </ul>
 
 
 
    <div class="margintop">共：
      <?=$count?>
      条&nbsp;&nbsp;
      <?=$pages?>
    </div>
 
</div>
</div>
</div>
</div>
<?php $this->load->view('admin/footer');?>
