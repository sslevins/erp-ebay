<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<style type="text/css">
<!--
.STYLE1 {font-size: 12px}
-->
</style>
</head>
<?php
	
	include "include/config.php";
	
	$module		= $_REQUEST['module'];
	$ordersn		= $_REQUEST['ordersn'];
	if($module  == 'refund') $labelstr		= "退款";
	if($module  == 'resend') $labelstr		= "重寄";
	if($module  == 'calcenorder') $labelstr		= "取消";
	
	
	if($_POST['submit']){
	
		
		$reason		= $_POST['reason'];
		if($module  == 'refund'){
			$sql	= "update ebay_order set refundreason='$reason',ebay_status='993' where ebay_ordersn='$ordersn'";
		}elseif($module == 'resend'){
			$sql	= "update ebay_order set resendreason='$reason',ebay_status='990' where ebay_ordersn='$ordersn'";
		}elseif($module == 'calcenorder'){
			$sql	= "update ebay_order set cancelreason='$reason',ebay_status='996' where ebay_ordersn='$ordersn'";
		}
		
		
		if($dbcon->execute($sql)){
	
					$status	= " -[<font color='#33CC33'>操作记录: 申请成功</font>]";

		}else{
					$status = " -[<font color='#FF0000'>操作记录: 申请失败</font>]";

		}
		
		
		echo $status;
		
		
	
	
	}
	
	
	
	


?>

<body>


<form id="name" name="name" method="post" action="messageoperation.php?module=<?php echo $module; ?>&ordersn=<?php echo $ordersn;?>">
<table width="33%" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td><span class="STYLE1">原因：</span></td>
  </tr>
  <tr>
    <td width="88%"><span class="STYLE1">
      <textarea name="reason" cols="50" rows="10" id="reason"></textarea>
    &nbsp;</span></td>
  </tr>
  <tr>
    <td><span class="STYLE1"><input name="submit" type="submit" value="<?php echo $labelstr; ?>申请" />
    </span></td>
  </tr>
</table>
</form>
</body>
</html>
