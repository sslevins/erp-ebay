<?php
include "include/config.php";


include "top.php";




	

	
	$id		= $_REQUEST["id"];

	
	if($_POST['submit']){
		
			
			$account	= $_POST['account'];
			$name		= $_POST['name'];
			$pass		= $_POST['pass'];
			$signature	= $_POST['signature'];
			$id			= $_POST['id'];
			$ebayaccount	= $_POST['ebayaccount'];
			$fees		= $_POST['fees']?$_POST['fees']:0;
			
			
			if($id == ""){
			
			
			$sql	= "insert into ebay_paypal(account,name,pass,signature,user,ebayaccount,fees) values('$account','$name','$pass','$signature','$user','$ebay_account','$fees')";
			}else{
			
			$sql	= "update ebay_paypal set account='$account',name='$name',pass='$pass',signature='$signature',ebayaccount='$ebayaccount',fees='$fees' where id=$id";
			}
		
			
			if($dbcon->execute($sql)){
			
			$status	= " -[<font color='#33CC33'>操作记录: Paypal帐号添加成功</font>]";
			
		}else{
		
			$status = " -[<font color='#FF0000'>操作记录: Paypal帐号添加失败</font>]";
		}
		
			
		
	}
	
	
		if($id	!= ""){
	
		
		$sql = "select * from ebay_paypal where id=$id";
		$sql = $dbcon->execute($sql);
		$sql = $dbcon->getResultArray($sql);
					
		$account	= $sql[0]['account'];
		$name		= $sql[0]['name'];
		$pass		= $sql[0]['pass'];
		$signature	= $sql[0]['signature'];
		$fees	= $sql[0]['fees'];
		$ebayaccount	= $sql[0]['ebayaccount'];
	
	}
	
	
	


?>

<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status;?></h2>
</div>
 
<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 <input name="hiddenuserid" type="hidden" value="" id="hiddenuserid" />
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
		
	<td nowrap="nowrap" scope="row" >&nbsp;</td>
	</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td width="26%">
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'>			
                      <form id="form" name="form" method="post" action="paypaladd.php?module=system&action=添加Paypal帐号">
                  <table width="70%" height="210" border="0" cellpadding="0" cellspacing="0">
                <input name="id" type="hidden" value="<?php echo $id;?>">
			      <tr>
                    <td width="41%" height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right">Paypal 帐号:</div></td>
                    <td width="3%" align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
                    <td width="56%" height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
                      <input name="account" type="text" id="account" value="<?php echo $account;?>">
                    </div></td>
                    </tr>
			      <tr>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right">API_UserName</div></td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="name" type="text" id="name" size="50" value="<?php echo $name;?>">
			        </div></td>
			        </tr>
			      <tr>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right">API_Password</div></td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="pass" type="text" id="pass" size="50" value="<?php echo $pass;?>">
			        </div></td>
			        </tr>
			      <tr>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right">API_Signature</div></td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="signature" type="text" id="signature" size="70" value="<?php echo $signature;?>">
			        </div></td>
			        </tr>
			      <tr>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right">所属eBay帐号</div></td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left"><select name="ebayaccount" id="ebayaccount">
                    <?php 
					
					$sql	 = "select * from ebay_account where ebay_user='$user'";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 
					 	$eaccount	= $sql[$i]['ebay_account'];
					 ?>
                      <option value="<?php echo $eaccount;?>" <?php if($eaccount == $ebayaccount) echo "selected=\"selected\""?>><?php echo $eaccount;?></option>
                    <?php } ?>
                    </select></div></td>
			        </tr>
			      <tr>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right">paypal费率</div></td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="center"></div></td>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <p>
			            <input name="fees" type="text" id="fees" size="10" value="<?php echo $fees;?>" />
			            请输入小数，请参考如下数据：</p>
			          <p>&nbsp;</p>
			        
                    $0.00 USD - $3,000.00 USD 3.4% + $0.30 USD <br />

$3,000.01 USD - $10,000.00 USD 2.9% + $0.30 USD <br />

$10,000.01 USD - $100,000.00 USD 2.7% + $0.30 USD <br />

> $100,000.00 USD 2.4% + $0.30 USD
                    
                    </div></td>
			        </tr>
                  <tr>				 
                    <td height="30" align="right" class="left_txt"><div align="right"></div></td>
                    <td align="right" class="left_txt">&nbsp;</td>
                    <td height="30" align="right" class="left_txt"><div align="left">
                      <input name="submit" type="submit" value="保存数据" onClick="return check()">
                    </div></td>
                    </tr>
                </table>
                 </form> 
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

<script language="javascript">
	
	function check(){
	
		var pas1	= document.getElementById('pass1').value;
		var pas2	= document.getElementById('pass2').value;
		
		if(pas1 == "" || pas2 == ""){
		
			alert('请输入密码');
			return false;
		}
		
		if(pas1 != pas2){
			
			alert('两次输入法的密码不一至');
			return false;
		
		}
	
	}



</script>
