<?php $this->load->view('admin/header');?>
<script type="text/javascript">

</script>
<div class="col-xs-12 col-md-12">
<div class="widget">
<div class="well with-header wellpadding">
<div class="header bordered-blue">游戏记录</div> 
<div>
	<div class="form-inline">
		<span>
			<form action="<?=$this->baseurl?>&m=index" method="post">
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
	    </div>      
 
        
	<form action="<?=$this->baseurl?>&m=delete" method="post">
		<table width="100%" border="0" cellpadding="3" cellspacing="0" class="table table-hover table-bordered"  id="sortTable">
			<tr>
				<th width="30"></th>
				<th width="30">排序</th>

				<th width="80">头像</th>
                <th  align="left">微信昵称</th>
				<th  align="left">积分</th>
                <th  align="left">游戏时间</th>
                <th  align="left">具体时间</th>
                <th width="150"  align="left">浏览器</th>
                <th  align="left">ip</th>
                 <th width="150"  align="left">来源地址</th>
				<th >操作</th>

			</tr>

    <?php  foreach($list as $key=>$r) {?>
    <tr class="sortTr">
		<td><?php if(!$r['islock']){?>
				<input type="checkbox" name="delete[]" value="<?=$r['id']?>"class="checkbox" />
			<?php }?>
		</td>

				<td><?=$key+1 ?></td>
				<td><img src="<?=$r['head_img']?>" width="40" height="40" /></td>
                <td><?=$r['nickname']?></td>
                <td><?=$r['score']?></td>
				<td title="<?=date('Y-m-d H:i:s',$r['addtime'])?>"><?=timeFromNow($r['addtime'])?></td>
<td title="<?=date('Y-m-d H:i:s',$r['addtime'])?>"><?=date('Y-m-d H:i:s',$r['addtime'])?></td>
 
                <td style="word-break:break-all"><?=$r['browser']?></td>
                  <td><?=$r['ip']?></td>
                    <td style="word-break:break-all"><?=$r['comefrom']?></td>
				<td>
                <?php if(!$r['islock']){?>
                <a href="<?=$this->baseurl?>&m=delete&catid=<?=$catid?>&id=<?=$r['id']?>" onclick="return confirm('确定要删除吗？');">删除</a>
                <?php }?>
                </td>
			</tr>
    <?php }?>
			<tr>
				<td colspan="11"><input type="checkbox" name="chkall" id="chkall"onclick="checkall('delete[]')" class="checkbox" /><label for="chkall">全选/反选</label>&nbsp; <input type="submit" value=" 删除 "class="btn" onclick="return confirm('确定要删除吗？');" /> &nbsp;</td>
			</tr>
		</table>

		<div class="margintop">共：<?=$count?>条&nbsp;&nbsp;<?=$pages?></div>

	</form>

</div>
</div>
</div>
</div>


<?php $this->load->view('admin/footer');?>