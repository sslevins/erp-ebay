<?php
include "include/config.php";
include "top.php";

	$id		= $_REQUEST['id'];

if($_POST['submit']){
	
	$template_name			= $_POST['template_name'];
	$ebay_account			= $_POST['ebay_account'];
	$notice					= $_POST['notice'];
	$notice2				= $_POST['notice2'];
	$notice3				= $_POST['notice3'];
	
	@$salemodule 		= $_POST['salemodule'];	
	$salemodule			= implode(",",$salemodule);
	
	$shippingdescription				= $_POST['shippingdescription'];
	$paymentdescription					= $_POST['paymentdescription'];
	$policydescription					= $_POST['policydescription'];
	$addnotice							= $_POST['addnotice'];
	$sql				= "insert into ebay_advancename(template_name,ebay_account,notice,salemodule,shippingdescription,paymentdescription,policydescription,addnotice,ebay_user,notice2,notice3) ";
	$sql				.="values('$template_name','$ebay_account','$notice','$salemodule','$shippingdescription','$paymentdescription','$policydescription','$addnotice','$user','$notice2','$notice3')";
	
	$isadd				= 1;
	
	if($id != ''){
		
		$isadd				= 0;
		$sql			 = "update ebay_advancename set template_name ='$template_name', ebay_account ='$ebay_account' , notice ='$notice' , salemodule ='$salemodule' , notice3='$notice3',notice2='$notice2', ";
		$sql			.= "shippingdescription ='$shippingdescription', paymentdescription='$paymentdescription', policydescription='$policydescription', addnotice='$addnotice' ";
		$sql			.= " where  id ='$id' and ebay_user ='$user' ";
	}
	
	
		if($dbcon->execute($sql)){
			if($isadd == 1) $id = mysql_insert_id();
			$status	= " -[<font color='#33CC33'>操作记录: 数据保存成功</font>]";
		}else{
			$status = " -[<font color='#FF0000'>操作记录: 数据保存失败</font>]";
		}
	
}
	
	if($id != ''){
	
		
		$sql			= "select * from ebay_advancename where id ='$id' and ebay_user ='$user' ";
		$sql			= $dbcon->execute($sql);
		$sql			= $dbcon->getResultArray($sql);
		
		
		$template_name			= $sql[0]['template_name'];
		$ebay_account			= $sql[0]['ebay_account'];
		$notice					= $sql[0]['notice'];
		$salemodule				= $sql[0]['salemodule'];
		
		$salemodule				= explode(",",$salemodule);
		
		$shippingdescription	= $sql[0]['shippingdescription'];
		$paymentdescription		= $sql[0]['paymentdescription'];
		$policydescription		= $sql[0]['policydescription'];
		$addnotice				= $sql[0]['addnotice'];
		
		$notice					= $sql[0]['notice'];
		$notice2				= $sql[0]['notice2'];
		$notice3				= $sql[0]['notice3'];
		
		
		
	}
 ?>
<style type="text/css">
<!--
.STYLE1 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>

<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>

<form name="post" action="advance_indexadd.php?id=<?php echo $_REQUEST['id'];?>" method="post">
<table width="80%" border="0" cellspacing="3" cellpadding="0">
  <tr>
    <td colspan="2"><?php echo $status;?>&nbsp;</td>
    </tr>
  <tr>
    <td> <div align="right">模板名称： </div></td>
    <td><div align="left">
      <input type="text" name="template_name" id="template_name" value="<?php echo $template_name;?>" />
      <span class="STYLE1">*</span></div></td>
  </tr>
  <tr>
    <td><div align="right">ebay 帐号：</div></td>
    <td><div align="left">
      <select name="ebay_account" id="ebay_account">
        <?php 
					$sql	 = "select ebay_account from ebay_account as a where a.ebay_user='$user' and ($ebayacc)  order by ebay_account desc ";
					$sqla	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sqla);
					$dbcon->free_result($sqla);
					
					for($i=0;$i<count($sql);$i++){					
					 	$account	= $sql[$i]['ebay_account'];
					 ?>
        <option value="<?php echo $account;?>" <?php if($ebay_account == $account ) echo 'selected="selected"';?>><?php echo $account;?></option>
        <?php } ?>
      </select>
      <span class="STYLE1">*</span></div></td>
  </tr>
  <tr>
    <td> <div align="right">客服说明第一行： </div></td>
    <td><div align="left">
      <input type="text" name="notice" id="notice" value="<?php echo $notice;?>" />
    </div></td>
  </tr>
  <tr>
    <td><div align="right">客服说明第二行：</div></td>
    <td><input type="text" name="notice2" id="notice2" value="<?php echo $notice2;?>" /></td>
  </tr>
  <tr>
    <td><div align="right">客服说明第三行：</div></td>
    <td><input type="text" name="notice3" id="notice3" value="<?php echo $notice3;?>" /></td>
  </tr>
  <tr>
    <td><div align="right">广告模块：</div></td>
    <td><div align="left">
       <input name="salemodule[]" type="checkbox" id="salemodule[]" <?php if(in_array("0",$salemodule)) echo "checked" ?> value="0" />顶部广告&nbsp;
       <input name="salemodule[]" type="checkbox" id="salemodule[]" <?php if(in_array("1",$salemodule)) echo "checked" ?> value="1" />秒杀广告&nbsp;
       <input name="salemodule[]" type="checkbox" id="salemodule[]" <?php if(in_array("2",$salemodule)) echo "checked" ?> value="2" />推荐广告&nbsp;
       <input name="salemodule[]" type="checkbox" id="salemodule[]" <?php if(in_array("3",$salemodule)) echo "checked" ?> value="3" />分类广告&nbsp;
       <input name="salemodule[]" type="checkbox" id="salemodule[]" <?php if(in_array("4",$salemodule)) echo "checked" ?> value="4" />TOP 5广告&nbsp;
       <input name="salemodule[]" type="checkbox" id="salemodule[]" <?php if(in_array("5",$salemodule)) echo "checked" ?> value="5" />新品广告&nbsp;
    </div></td>
  </tr>
  <tr>
    <td> <div align="right">配送说明： </div></td>
    <td><div align="left">
      <textarea name="shippingdescription" cols="100" rows="6" id="shippingdescription"><?php echo $shippingdescription;?></textarea>
    </div></td>
  </tr>
  <tr>
    <td> <div align="right">付款方式说明： </div></td>
    <td><div align="left">
      <textarea name="paymentdescription" cols="100" rows="6" id="paymentdescription"><?php echo $paymentdescription;?></textarea>
    </div></td>
  </tr>
  <tr>
    <td> <div align="right">政策说明： </div></td>
    <td><div align="left">
      <textarea name="policydescription" cols="100" rows="6" id="policydescription"><?php echo $policydescription;?></textarea>
    </div></td>
  </tr>
  <tr>
    <td> <div align="right">补充内容：</div></td>
    <td><div align="left">
      <textarea name="addnotice" cols="100" rows="6" id="addnotice"><?php echo $addnotice;?></textarea>
    </div></td>
  </tr>
  <tr>
    <td><div align="right"></div></td>
    <td><input name="submit" type="submit" value="保存数据" onclick="return check()" /></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
<?php

include "bottom.php";


?>
<script language="javascript">

	function check(id){
		
		var template_name		= document.getElementById('template_name').value;
		if(template_name == ''){
			alert('模板名称不能为空');
			document.getElementById('template_name').focus();
			return false;
		}
		
		
	
		
	
	}
</script>