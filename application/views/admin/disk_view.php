<?php $this->load->view('admin/header');?>
<style>
	.alert tr {border:0;}
	.alert .table tr td  {border:0;color:#fff;}
</style>
<div class="col-xs-12 col-md-12">
	<div class="widget">
		<div class="well with-header wellpadding">
			<div class="header bordered-blue">服务器空间使用情况</div>   
			<div >
				<div class="alert alert-success" role="alert">
					<table width="40%" border="0" cellpadding="3" style="background-color:rgba(0,0,0,0);" cellspacing="0" class="table">
						<tr>
							<td>总容量：</td>
							<td><?=$system_space['real_total_size']?> 字节</td>
							<td><?=$system_space['total_size']?></td>
						</tr>
						<tr>
							<td>已用空间：</td>
							<td><?=$system_space['real_yiyong']?> 字节</td>
							<td><?=$system_space['yiyong']?></td>
						</tr>
						<tr>
							<td>可用空间：</td>
							<td><?=$system_space['real_free_size']?> 字节</td>
							<td><?=$system_space['free_size']?></td>
						</tr>
					</table>
				</div>
				<div class="progress">
				  	<div class="progress-bar progress-bar-danger" style="width: <?=100-$system_space['percent']?>%;">
				    	已用空间<?=100-$system_space['percent']?>%
				  	</div>
				  	<div class="progress-bar progress-bar-success" style="width: <?=$system_space['percent']?>%">
				    	可用空间<?=$system_space['percent']?>%
				  	</div>
				</div>
			</div> 
		</div>
	</div>
</div>

<div class="col-xs-12 col-md-12">
	<div class="widget">
		<div class="well with-header wellpadding">
			<div class="header bordered-blue">系统空间使用情况</div>   
			<div >
				<div class="alert alert-success" role="alert">
					<table width="40%" border="0" cellpadding="3" style="background-color:rgba(0,0,0,0);" cellspacing="0" class="table">
						<tr>
							<td>系统占用空间：</td>
							<td><?=$GC_dir['realSize']?> 字节</td>
							<td><?=$GC_dir['size']?></td>
						</tr>
						<!-- <tr>
							<td>系统占用率：</td>
							<td><?=round($GC_dir['realSize']/$system_space['real_total_size']*100,2).'%'?></td>
							<td></td>
						</tr> -->
					</table>
				</div>
				<table width="100%" border="0" cellpadding="3" cellspacing="0" class="table table-hover table-bordered" id="sortTable">
					<tr>
						<th width="30">排序</th>
						<th>目录名称</th>
						<th>占用空间</th>
						<th>占用率</th>
						

					</tr>

				    <?php foreach($dirArray as $key=>$r) {?>
				    <tr class="sortTr">
						<td><?=$key+1?></td>
						<td class="td_c"><?=$r['dir']?></td>
						<td class="td_c"><?=$r['size']?></td>
						<td class="td_c"><?=round($r['realSize']/$GC_dir['realSize']*100,2),'%'?></td>
						
					</tr>
				    <?php }?>
				</table>
			</div> 
		</div>
	</div>
</div>




<?php $this->load->view('admin/footer');?>