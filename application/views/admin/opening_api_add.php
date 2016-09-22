<?php $this->load->view('admin/header');?>
<script>
KindEditor.ready(function(K) {
	K.create('#ApiRequet',{urlType :'relative', items : [
    'source', '|', 'fontname', 'fontsize', '|', 'textcolor', 'bgcolor', 'bold', 'italic', 'underline',
    'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
    'insertunorderedlist', '|', 'emoticons', 'image', 'link']});
	K.create('#ApiReturn',{urlType :'relative',items : [
    'source', '|', 'fontname', 'fontsize', '|', 'textcolor', 'bgcolor', 'bold', 'italic', 'underline',
    'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
    'insertunorderedlist', '|', 'emoticons', 'image', 'link']});
});
</script>

<div class="col-xs-12 col-md-12">
<div class="widget">
<div class="well with-header">
<div class="header bordered-blue">添加/修改开放接口</div>   
  <form action="<?=$this->baseurl?>&m=save" method="post">
    <input type="hidden" name="RoomID" value="<?=$RoomID?>">
    <input type="hidden" name="ID" value="<?=$ID?>">
    <table class="table" width="100%">
     <tr>
        <td width="90">游戏名称</td>
        <td><?=$GameName?></td>
      </tr>
      <tr>
        <td width="90">接口名称</td>
        <td><input name="value[ApiName]" type="text" class="form-control" value="<?=$value[ApiName]?>"></td>
      </tr>
      <tr>
        <td width="90">接口说明</td>
        <td><input  name="value[ApiDesc]" type="text" class="form-control" value="<?=$value[ApiDesc]?>"></td>
      </tr>
      <tr>
        <td width="90">接口地址</td>
        <td><input name="value[ApiUrl]"  type="text" class="form-control" value="<?=$value[ApiUrl]?>"></td>
      </tr>
      <tr>
        <td width="90">请求方式</td>
        <td><select name="value[ApiMethod]" id="">
            <?php $Status = array('GET','POST','GET/POST');?>            
            <?php foreach($Status as $k => $v){?>
            <option <?=($k==$value['ApiMethod'])?'selected="selected"':''?> value="<?=$v?>">
            <?=$v?>
            </option>
            <?php }?>
          </select></td>
      </tr>
      <tr>
        <td>请求参数</td>
        <td><textarea name="value[ApiRequet]" id="ApiRequet"><?=$value[ApiRequet]?>
</textarea></td>
      </tr>
      <tr>
        <td>返回参数</td>
        <td><textarea name="value[ApiReturn]" id="ApiReturn"><?=$value[ApiReturn]?>
</textarea></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
       <td><input type="submit" name="submit" value=" 提 交 " class="btn btn-blue"
					tabindex="3" /> &nbsp;&nbsp;&nbsp;<input type="button"
					name="submit" value=" 取消 " class="btn"
					onclick="javascript:history.back();" /></td>
      </tr>
    </table>
  </form>
</div>
</div>
</div>

<?php $this->load->view('admin/footer');?>
