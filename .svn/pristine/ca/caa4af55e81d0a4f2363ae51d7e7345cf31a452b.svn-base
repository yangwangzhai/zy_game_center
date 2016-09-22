<?php $this->load->view('admin/header');?>


<div >
	
  <?php 
	 foreach($list as $key=>$r) {?>        
       
    <div class="gamelist" style="padding:0; margin:0;">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <th align="left"><strong><?=$r['GameName']?></strong></td>
    <th align="right" ><!--<i class="fa fa-folder"><?=zy_a('GameRegTable_view','资源','index.php?d=admin&c=gameRegTable&RoomID='.$r['RoomID']);?></i><i class="fa fa-navicon"><?=zy_a('GameRegNav_view','导航','index.php?d=admin&c=gameRegNav&RoomID='.$r['RoomID']);?></i><i class="fa fa-puzzle-piece"><?=zy_a('GameAPI_view','接口','index.php?d=admin&c=gameAPI&RoomID='.$r['RoomID']);?></i><i class="fa fa-edit"><?=zy_a('GameRoom_update','修改',$this->baseurl.'&m=edit&RoomID='.$r['RoomID']);?></i><i class="fa fa-trash"><?=zy_a('GameRoom_del','删除',$this->baseurl.'&m=delete&RoomID='.$r['RoomID'],'onclick="return confirm(\'确定要删除吗？\');"');?></i>--></th>
  </tr>
  <tr>
    <td width="200" rowspan="11" class="noborder"><?php $patharr = explode('|', $r['ScreenImages']);?>
					<img onclick="urlDialogCus('index.php?d=admin&c=vPics&path=<?=$r['ScreenImages']?>','游戏截图',800,550)" src="<?=$patharr[0]?>" width="220" class="gameimg"/></td>
    <td>ID库：<?=$r['RoomID']?></td>
  </tr>
  <tr>
    <td>游戏名称：<?=$r['GameName']?></td>
  </tr>
  <tr>
    <td>游戏类型：<?=$GameType[$r['GameType']]?></td>
  </tr>
  <tr>
    <td>游戏版本：<?=$r['Version']?></td>
  </tr>
  <tr>
    <td>被使用数：<?=$r['ActiveUseNum']?>次</td>
  </tr>
  <tr>
    <td>访问总数：<?=$r['VistNum']?>次</td>
  </tr>
  <tr>
    <td>游戏状态：<?php $Status = array(0=>'测试',1=>'开放',2=>'停用',3=>'维护中');?>
					<?=$Status[$r['Status']]?></td>
  </tr>
  <tr>
    <td>游戏备注：<?=str_cut($r['Remark'], 115 , '...')?>
    <?php if (strpos(str_cut($r['Remark'], 115 , '...'), '...') !== false) {?>
    
      <a href="javascript:;" onclick="dialog('<?=$r['Remark']?>','游戏备注',500,300)" >详细</a>
   <?php }?>
    
    
    </td>
  </tr>
  <tr>
    <td>游戏介绍：<?=str_cut($r['GameResume'], 115, '...')?>
    <?php if (strpos(str_cut($r['GameResume'], 115 , '...'), '...') !== false) {?>
    
    <a href="javascript:;" onclick="dialog('<?=$r['GameResume']?>','游戏介绍',500,300)" >详细</a>
       <?php }?>
    </td>
  </tr>
  <tr>
    <td class="noborder">最近更新：<?=getUserName($r['UID'])?>,<?=timeFromNow($r['UpdateTime'])?></td>
  </tr>
   <tr>
    <td class="noborder"></td>
  </tr>
</table>
</div>

<?php }?>
</div>
