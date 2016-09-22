<?php $this->load->view('admin/header');?>

<style>
#sortTable td{vertical-align:middle; text-align:center;}
#sortTable td a{ cursor:pointer;}
</style>
<div class="col-xs-12 col-md-12">
  <div class="widget">
    <div class="well with-header wellpadding">
      <div class="header bordered-blue">幸运水果机->比倍记录</div>
      <div>
     
        <div class="form-inline">  </div>
        <table width="100%" border="0" cellpadding="3" cellspacing="0"
			class="table table-hover table-bordered" id="sortTable">
          <tr>
            <th width="30">排序</th>
            <th>原比倍数</th>
            <th>现比倍数</th>          
            <th>类型</th>
            <th>押大小开奖数</th>
            <th>押大小结果</th>
            <th>发生时间</th>
           
          </tr>
          <?php foreach($list as $key=>$r) {?>
          <tr class="sortTr">
            <td class="td_c"><?=$key+1?></td>
           <td><?=$r['old_gold']?></td>
           <td><?=$r['cur_gold']?></td>
           <td><?=$type[$r['type']]?></td>
           <td><?=$r['result_num']?></td>
           <td><?=$r['result_status']?></td>
           <td title="<?=times($r['addtime'],1)?>"><?=timeFromNow($r['addtime'])?></td>
          
          </tr>
          <?php }?>
        </table>
       
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('admin/footer');?>
