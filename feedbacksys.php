<?php
include "include/config.php";


include "top.php";




	
	$type	= $_REQUEST['type'];
	
	
 ?>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status;?> </h2>
</div>

<div class='listViewBody'>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td width="65%">
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'><table width="100%" height="99" border="0" cellpadding="0" cellspacing="0">
                
			    <form method="post" action="feedbacksys.php">   
			      <tr>
                    <td width="41%" height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right">eBay帐号:</div></td>
                    <td width="3%" align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
                    <td width="56%" height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
                      <select name="account" id="account">
                        <?php 
					
					$sql	 = "select ebay_account from ebay_account where ebay_user='$user' and ebay_token != '' ";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 
					 	$account	= $sql[$i]['ebay_account'];
					 ?>
                        <option value="<?php echo $account;?>"><?php echo $account;?></option>
                        <?php } ?>
                        <option value="loadingall">同步所有帐号</option>
                      </select>
                    </div></td>
                    </tr>
			      <tr>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left"></div></td>
			        </tr>
                  <tr>
				 </form> 
                    <td height="30" align="right" class="left_txt"><div align="right"></div></td>
                    <td align="right" class="left_txt">&nbsp;</td>
                    <td height="30" align="right" class="left_txt"><div align="left">
                      <input type="button" value="同步好评数据" onclick="check()" />
                    </div></td>
                    </tr>       
                </table>
				   				  </td>
			    </tr>
			</table>		</td>
	</tr>
		

              
		<tr class='pagination'>
		<td>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'></td>
					</tr>
			</table>		</td>
	</tr></table>


    <div class="clear"></div>
<?php

if($type == 'load'){
$account	 = $_REQUEST['account'];
if($account == 'loadingall'){
$sql 		 = "select ebay_token,ebay_account from ebay_account where ebay_user='$user' and ebay_token !=''";
}else{
$sql 		 = "select ebay_token,ebay_account from ebay_account where ebay_user='$user' and ebay_account='$account'";
}
$sql		 = $dbcon->execute($sql);
$sql		 = $dbcon->getResultArray($sql);



for($i=0;$i<count($sql);$i++){
$token			 = $sql[$i]['ebay_token'];
$account		 = $sql[$i]['ebay_account'];

echo $account .'<br>';


GetFeedback($token,$account);
}
}


include "bottom.php";


?>
<script language="javascript">
	function check(){
		var account = document.getElementById('account').value;	
		location.href='feedbacksys.php?account='+account+"&module=feedback&action=同步好评数据结果&type=load";
		
		
	}

</script>