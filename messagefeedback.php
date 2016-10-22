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
	
	$ordersn		= $_REQUEST['ordersn'];
	
	if($_POST['submit']){
	
		
		
		
		$ss		= "select * from ebay_order where ebay_ordersn='$ordersn'";
		$ss		= $dbcon->execute($ss);
		$ss		= $dbcon->getResultArray($ss);
		$account	= $ss[0]['ebay_account'];
		
		
		$sql 		 = "select * from ebay_account where ebay_user='$user' and ebay_account='$account'";
		$sql		 = $dbcon->execute($sql);
		$sql		 = $dbcon->getResultArray($sql);
		$token		 = $sql[0]['ebay_token'];

		
		givefeedback($token,$ordersn);
		

	
	
	}
	
	
	
	


?>

<body>


<form id="name" name="name" method="post" action="messagefeedback.php?module=<?php echo $module; ?>&ordersn=<?php echo $ordersn;?>">
<table width="33%" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td><span class="STYLE1">Content:</span></td>
  </tr>
  <tr>
    <td width="88%"><span class="STYLE1">
      <textarea name="reason" cols="50" rows="10" id="reason">Wonderful buyer, very fast payment.</textarea>
    &nbsp;</span></td>
  </tr>
  <tr>
    <td><span class="STYLE1"><input name="submit" type="submit" value="Feedback" />
    </span></td>
  </tr>
</table>
</form>
</body>
</html>
