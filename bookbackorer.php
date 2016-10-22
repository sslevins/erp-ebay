<?php

include "include/config.php";

$ordersn	= $_REQUEST['ordersn'];

			


?>




<?php
	
	if($_POST['submit']){
			$sq			= "select ebay_userid,ebay_account,ebay_usermail,ebay_street,ebay_street1,ebay_city,ebay_state,ebay_countryname,ebay_postcode,ebay_phone,ebay_username from ebay_order where ebay_id='$ordersn'";
			$sq			= $dbcon->execute($sq);
			$sq			= $dbcon->getResultArray($sq);
			$account	= $sq[0]['ebay_account'];
			$content	= str_rep($_POST['content']);
			$mail					= $sq[0]['ebay_usermail'];
			$ebay_street			= $sq[0]['ebay_street'];
			$ebay_street1			= $sq[0]['ebay_street1'];
			$ebay_city				= $sq[0]['ebay_city'];
			$ebay_countryname		= $sq[0]['ebay_countryname'];
			$ebay_postcode			= $sq[0]['ebay_postcode'];
			$ebay_phone				= $sq[0]['ebay_phone'];
			$ebay_username			= $sq[0]['ebay_username'];
			$userid					= $sq[0]['ebay_userid'];
			
			/* 检查是否已经存在hei名单*/
			$vv			= "select mail from ebay_hackpeoles where mail ='$mail' or userid ='$userid' or ebay_username ='$ebay_username' ";
			$vv			= $dbcon->execute($vv);
			$vv			= $dbcon->getResultArray($vv);
			if(count($vv) == 0){
				
				$vv		= "insert into ebay_hackpeoles(userid,mail,ebay_username,ebay_street,ebay_street1,ebay_city,ebay_state,ebay_countryname,ebay_postcode,ebay_phone,notes,adduser,addtim,ebay_user) values('$userid','$mail','$ebay_username','$ebay_street','$ebay_street1','$ebay_city','$ebay_state','$ebay_countryname','$ebay_postcode', '$ebay_phone','$content','$truename','$nowtime','$user') ";		
					if($dbcon->execute($vv)){
					$status	= " -[<font color='#33CC33'>操作记录: 保存成功</font>]";
					}else{
 					$status = " -[<font color='#FF0000'>操作记录: 保存失败</font>]";
					}
				
			}else{
				
				$status = " -[<font color='#FF0000'>操作记录: 保存失败,已经存在</font>]";
				
			}
			
			
			
				
	}
?>


<style type="text/css">
<!--
.STYLE1 {font-size: 12px}
-->
</style>
<form id="form" name="form" method="post" action="bookbackorer.php?ordersn=<?php echo $ordersn;?>">
<?php echo $status;?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  
  <tr>
    <td height="68"><span class="STYLE1">请填写登记黑名单的原因</span></td>
  </tr>
  <tr>
    <td height="64" valign="top"><textarea name="content" cols="60" rows="15" id="content"></textarea>
      <span class="STYLE1">
      <input name="submit" type="submit" value="保存" id="submit" onclick="return check()" />
      </span></td>
  </tr>
</table>
</form>


<script>
	
		
	function check(){
	
		
		var content = document.getElementById('content').value;
		if(content == ''){
			
			alert('请输入原因');
			document.getElementById('content').focus();
			return false;
		}
		

		
		
	
	}
	

</script>
