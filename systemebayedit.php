<?php
include "include/config.php";


include "top.php";




	

	
	$id		= $_REQUEST["id"];
	$isadd  = '';
	
	
	if($_POST['submit']){
		
			
			$account		= $_POST['account'];
			$mail			= $_POST['mail'];
			$appname		= $_POST['appname'];
			$ebay_currency		= $_POST['ebay_currency'];
			if($id == ""){
			// $sql	= "insert into ebay_user(truename,username,password,user,power,record,message,ebayaccounts) values('$truename','$username','$password','$user','$power','$record','$message','$ebayaccounts')";
			// $isadd = 1;
			}else{
			$sql	= "update ebay_account set ebay_account ='$account',mail='$mail',appname='$appname',ebay_currency='$ebay_currency' where id=$id";
			}
			if($dbcon->execute($sql)){
			// if($isadd == 1) $id = mysql_insert_id();
			$status	= " -[<font color='#33CC33'>操作记录: 数据保存成功</font>]";
		}else{
			$status = " -[<font color='#FF0000'>操作记录: 数据保存失败</font>]";
		}
		
	}
	
	

		
		$sql = "select * from ebay_account where id=$id";
		

		
		$sql = $dbcon->execute($sql);
		$sql = $dbcon->getResultArray($sql);
		

		$ebay_currency  	= $sql[0]['ebay_currency'];
		$account  			= $sql[0]['ebay_account'];
		$appname 			= $sql[0]['appname'];
		$mail				= $sql[0]['mail'];
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
                      <form id="form" name="form" method="post" action="systemebayedit.php?module=system&action=ebay账号管理">
                  <table width="70%" border="1" cellpadding="0" cellspacing="0">
                <input name="id" type="hidden" value="<?php echo $id;?>">
			      <tr>
                    <td width="41%" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right"><span style="white-space: nowrap;">ebay账号	 </span>:</div></td>
                    <td width="3%" align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
                    <td width="56%" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
                      <input name="account" type="text" id="account" value="<?php echo $account;?>">
                    </div></td>
                    </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right"><span style="white-space: nowrap;">简称</span>:</div></td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
					<input name="appname" type="text" id="appname" value="<?php echo $appname;?>">
					 </div></td>
			        </tr>		
					<tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right"><span style="white-space: nowrap;">Mail</span>:</div></td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
					<input name="mail" type="text" id="mail" value="<?php echo $mail;?>">
					 </div></td>
			        </tr>
					<tr>
					  <td align="right" bgcolor="#f2f2f2" class="left_txt">ebay费用结算币种</td>
					  <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
					  <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
					    <select name="ebay_currency" id="ebay_currency">
                          <option value="-1" >请选择</option>
                          <?php
							$tql	= "select * from ebay_currency where user = '$user'";
							$tql	= $dbcon->execute($tql);
							$tql	= $dbcon->getResultArray($tql);
							for($i=0;$i<count($tql);$i++){

							$currency1		= $tql[$i]['currency'];
						   

						   ?>
                          <option value="<?php echo $currency1;?>"  <?php if($ebay_currency == $currency1) echo "selected=selected" ?>><?php echo $currency1;?></option>
                          <?php

						   }

						   

						   

						   ?>
                        </select>
					  系统管理，汇率管理中，可以设置。</div></td>
				    </tr>		
                  <tr>				 
                    <td align="right" class="left_txt"><div align="right"></div></td>
                    <td align="right" class="left_txt">&nbsp;</td>
                    <td align="right" class="left_txt"><div align="left">
                      <input name="submit" type="submit" value="保存数据">
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
