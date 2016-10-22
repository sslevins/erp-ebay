<?php
include "../include/config.php";
	
	$io_ordersn		= $_REQUEST['io_ordersn'];
	if($_POST['submit']){
			
			$reason	= mysql_escape_string($_POST['reason']);
			$sql	= "update ebay_iostore set reason ='$reason', type = '98' where io_ordersn ='$io_ordersn' ";
			if($dbcon->execute($sql)){
			$status	= " -[<font color='#33CC33'>操作记录: 已经驳回成功</font>]";
			}else{
				$status = " -[<font color='#FF0000'>操作记录: 驳回失败</font>]";
			}			
			
	}
?>

<form method="post" name="ff" action="FinanceCheck_notaudit.php?io_ordersn=<?php echo $io_ordersn;?>">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2" align="right" valign="top"><div align="left"><?php echo $status;?>
      &nbsp;</div></td>
    </tr>
  <tr>
    <td width="14%" align="right" valign="top">驳回理由</td>
    <td width="86%"><textarea name="reason" cols="80" rows="10" id="reason"></textarea>
    &nbsp;</td>
  </tr>
  <tr>
    <td align="right" valign="top">&nbsp;</td>
    <td><input name="submit" type="submit" value="提交" /></td>
  </tr>
</table>
</form>

