<?php
include "include/config.php";
include "top.php";
		$id			= $_REQUEST['id'];
		$pid		= $_REQUEST['pid'];
		if($_POST['submit']){
		
				$name		= $_POST['name'];
				$type		= $_POST['type'];
				$itemid		= $_POST['itemid'];
				$site		= $_POST['site'];
				$sku		= $_POST['sku'];
				$url		= $_POST['url'];
				$salemodule		= $_POST['salemodule'];
				$displaysort		= $_POST['displaysort'];
				$ispicinsert = 0;
				$isadd		 = 0;
				
				$filename			= date('Y').date('m').date('d').date('H').date('i').date('s').rand(100,999);
				$names				= $_FILES['upfile']['name'];		
				$filetype			= substr($names,strpos($names,"."),4);
				$picurl				= $filename.$filetype;
				if (move_uploaded_file($_FILES['upfile']['tmp_name'], "images/".$picurl)) {
						$ispicinsert = 1;
						$status	= "-[<font color='#33CC33'>The picture uploaded successful</font>]<br>";
						echo $status;				
				}
				
				if($id != '' ){
					
					$sql		=  "update ebay_advancenamedetail set name ='$name', type='$type' , itemid ='$itemid' , site='$site' , sku='$sku', url='$url',salemodule='$salemodule',displaysort='$displaysort' ";
					if($ispicinsert == '1' ) $sql		.= " , picurl='$picurl' ";
					$sql		.= "  where id ='$id ' and ebay_user ='$user ' ";
					
				}else{
					$isadd		= 1;
					$sql		= "insert into ebay_advancenamedetail(name,type,itemid,site,sku,picurl,ebay_user,pid,url,salemodule,displaysort) values('$name','$type','$itemid','$site','$sku','$picurl','$user','$pid','$url','$salemodule','$displaysort')";
				}
				if($dbcon->execute($sql)){
					if($isadd == 1) $id = mysql_insert_id();
					$status	= " -[<font color='#33CC33'>操作记录: 数据保存成功</font>]";
				}else{
					$status = " -[<font color='#FF0000'>操作记录: 数据保存失败</font>]";
				}
		
				
				
				
		}
		
		
		if($id != ''){
	
		
		$sql			= "select * from ebay_advancenamedetail where id ='$id' and ebay_user ='$user' ";
		$sql			= $dbcon->execute($sql);
		$sql			= $dbcon->getResultArray($sql);
		
		
		$name					= $sql[0]['name'];
		$type					= $sql[0]['type'];
		$itemid					= $sql[0]['itemid'];
		$site					= $sql[0]['site'];
		$sku					= $sql[0]['sku'];
		$picurl					= $sql[0]['picurl'];
		$url					= $sql[0]['url'];
		$salemodule				= $sql[0]['salemodule'];
		$displaysort			= $sql[0]['displaysort'];
		
	}
		
	
	
 ?>
<style type="text/css">
<!--
.STYLE1 {	color: #FF0000;
	font-weight: bold;
}
-->
</style>

<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div id='Accountssaved_viewsSearchForm' style='display: none';></div>
<form id="ad" name="ad" method="post" action="advance_indextemplateadd.php?pid=<?php echo $pid;?>&module=advance&id=<?php echo $id;?>" enctype="multipart/form-data">

<table width="80%" border="0" cellspacing="3" cellpadding="0">
  <tr>
    <td colspan="2"><?php echo $status;?>&nbsp;</td>
    </tr>
  <tr>
    <td><div align="right">广告名称： </div></td>
    <td><input type="text" name="name" id="name"  value="<?php echo $name;?>"/>
      <span class="STYLE1">*</span></td>
  </tr>
  <tr>
    <td><div align="right">广告类型：&nbsp;</div></td>
    <td><select name="type" id="type">
      <option value="0" <?php if($type == '0' ) echo 'selected="selected"';?>>链接至商品 </option>
      <option value="1" <?php if($type == '1' ) echo 'selected="selected"';?>>其他链接</option>
    </select>
      <span class="STYLE1">*</span></td>
  </tr>
  <tr>
    <td><div align="right">上传图片： </div></td>
    <td><span class="STYLE1">
      <input name="upfile" type="file" id="upfile" />
      *</span>
      （图片尺寸必须为：190x150）
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tbody>
          
          <tr id="trProductId"></tr>
        </tbody>
      </table>      </td>
  </tr>
  <tr>
    <td><div align="right">商品ItemID：	&nbsp;</div></td>
    <td><input type="text" name="itemid" id="itemid" value="<?php echo $itemid;?>" />
      <span class="STYLE1">*</span></td>
  </tr>
  <tr>
    <td><div align="right">链接地址：</div></td>
    <td><input type="text" name="url" id="url" value="<?php echo $url;?>" />
      <span class="STYLE1">*</span></td>
  </tr>
  <tr>
    <td><div align="right">商品链接站点： </div></td>
    <td><span class="STYLE1">
      <select name="site" id="site">
        <option value="0" <?php if($site == '0' ) echo 'selected="selected"';?>>美国站 </option>
        <option value="1" <?php if($site == '1' ) echo 'selected="selected"';?>>英国站</option>
        <option value="2" <?php if($site == '2' ) echo 'selected="selected"';?>>澳大利亚</option>
        <option value="3" <?php if($site == '3' ) echo 'selected="selected"';?>>德国</option>
        <option value="4" <?php if($site == '4' ) echo 'selected="selected"';?>>法国</option>
        <option value="5" <?php if($site == '5' ) echo 'selected="selected"';?>>意大利</option>
        <option value="6" <?php if($site == '6' ) echo 'selected="selected"';?>>西班牙</option>
      </select>
      *</span></td>
  </tr>
  <tr>
    <td><div align="right">SKU：	&nbsp;</div></td>
    <td><input type="text" name="sku" id="sku" value="<?php echo $sku;?>" />
      <span class="STYLE1">*</span></td>
  </tr>
  <tr>
    <td><div align="right">广告类型：</div></td>
    <td><span class="STYLE1">
      <select name="salemodule" id="salemodule">
        <option value="0" <?php if($salemodule == '0' ) echo 'selected="selected"';?>>顶部广告</option>
        <option value="1" <?php if($salemodule == '1' ) echo 'selected="selected"';?>>秒杀广告</option>
        <option value="2" <?php if($salemodule == '2' ) echo 'selected="selected"';?>>推荐广告</option>
        <option value="3" <?php if($salemodule == '3' ) echo 'selected="selected"';?>>分类广告</option>
        <option value="4" <?php if($salemodule == '4' ) echo 'selected="selected"';?>>TOP 5广告</option>
        <option value="5" <?php if($salemodule == '5' ) echo 'selected="selected"';?>>新品广告 </option>
      </select>
    </span></td>
  </tr>
  <tr>
    <td><div align="right">显示顺序：</div></td>
    <td><input type="text" name="displaysort" id="displaysort" value="<?php echo $displaysort;?>" /> 
      0 表示最大，显示在最前面 </td>
  </tr>
  <tr>
    <td><div align="right"></div></td>
    <td><input name="submit" type="submit" value="保存数据" onclick="return check()" /></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    </tr>
</table>

</form>

<?php

include "bottom.php";


?>
<script language="javascript">

		function delaccount(id){
		if(confirm('您确认删除此条记录吗')){
			
			location.href = 'messagecategory.php?type=del&id='+id+"&module=message&action=Message分类";
			
		
		}
	
	
	}
</script>