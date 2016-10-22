<?php
include "include/config.php";


include "top.php";




	

	
	$id				= $_REQUEST["id"];
	$ordersn		= $_REQUEST["ordersn"];
	$add		= '0';
	if($_POST['submit']){
		
			$userid  			= $_POST['userid'];
			$mail	  			= $_POST['mail'];
			$ebay_username  	= str_rep($_POST['ebay_username']);
			$ebay_street  		= str_rep($_POST['ebay_street']);
			$ebay_street1  		= str_rep($_POST['ebay_street1']);
			$ebay_city  		= str_rep($_POST['ebay_city']);
			$ebay_state  		= str_rep($_POST['ebay_state']);
			$ebay_countryname  	= str_rep($_POST['ebay_countryname']);
			$ebay_postcode  	= str_rep($_POST['ebay_postcode']);
			$ebay_phone  		= str_rep($_POST['ebay_phone']);
			$notes  			= str_rep($_POST['notes']);
			$paypal_account  	= str_rep($_POST['paypal_account']);
			$status			  	= str_rep($_POST['status']);
			
			if($id != ''){
			$sql		= "update ebay_hackpeoles set userid ='$userid',mail='$mail',ebay_username='$ebay_username',ebay_street='$ebay_street',ebay_street1='$ebay_street1',ebay_city='$ebay_city',ebay_state='$ebay_state',ebay_countryname='$ebay_countryname',ebay_postcode='$ebay_postcode',ebay_phone='$ebay_phone',notes='$notes',paypal_account='$paypal_account',status='$status' where id=$id";
				
			}else{
				
				$add		= '1';
				
				$sql		= "insert into ebay_hackpeoles(userid,mail,ebay_username,ebay_street,ebay_street1,ebay_city,ebay_state,ebay_countryname,ebay_postcode,ebay_phone,notes,adduser,addtim,ebay_user,status) values('$userid','$mail','$ebay_username','$ebay_street','$ebay_street1','$ebay_city','$ebay_state','$ebay_countryname','$ebay_postcode', '$ebay_phone','$content','$truename','$nowtime','$user','$status') ";		
	
					
				
			
			}
	
			if($dbcon->execute($sql)){
			$statuss	= " -[<font color='#33CC33'>操作记录: 数据保存成功</font>]";
			
			if($add		=='1') $id			= mysql_insert_id();
			
			}else{
			$statuss = " -[<font color='#FF0000'>操作记录: 数据保存失败</font>]";
			}
		
			
		
	}
	
	
	if($id	!= ""){
		$sql = "select * from ebay_hackpeoles where id=$id";
	
		
		$sql = $dbcon->execute($sql);
		$sql = $dbcon->getResultArray($sql);
		$userid  			= $sql[0]['userid'];
		$mail	  			= $sql[0]['mail'];
		$ebay_username  	= $sql[0]['ebay_username'];
		$ebay_street  		= $sql[0]['ebay_street'];
		$ebay_street1  		= $sql[0]['ebay_street1'];
		$ebay_city  		= $sql[0]['ebay_city'];
		$ebay_state  		= $sql[0]['ebay_state'];
		$ebay_countryname  	= $sql[0]['ebay_countryname'];
		$ebay_postcode  	= $sql[0]['ebay_postcode'];
		$ebay_phone  		= $sql[0]['ebay_phone'];
		$notes  			= $sql[0]['notes'];
		$paypal_account  	= $sql[0]['paypal_account'];
		$status			  	= $sql[0]['status'];
	}else{
		
		$sql = "select * from ebay_order where ebay_ordersn ='$ordersn'";
		$sql = $dbcon->execute($sql);
		$sql = $dbcon->getResultArray($sql);
		$userid  			= $sql[0]['ebay_userid'];
		$mail	  			= $sql[0]['ebay_usermail'];
		$ebay_username  	= $sql[0]['ebay_username'];
		$ebay_street  		= $sql[0]['ebay_street'];
		$ebay_street1  		= $sql[0]['ebay_street1'];
		$ebay_city  		= $sql[0]['ebay_city'];
		$ebay_state  		= $sql[0]['ebay_state'];
		$ebay_countryname  	= $sql[0]['ebay_countryname'];
		$ebay_postcode  	= $sql[0]['ebay_postcode'];
		$ebay_phone  		= $sql[0]['ebay_phone'];
		$notes  			= $sql[0]['notes'];
		$paypal_account  	= $sql[0]['paypal_account'];
		$status			  	= 0;
		
	
	
	}
	
	
	


?>

<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$statuss;?></h2>
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
                      <form id="form" name="form" method="post" action="bookbackoreradd.php?module=customer&id=<?php echo $id?>&ordersn=<?php echo $_REQUEST['ordersn']; ?>">
                  <table width="90%" border="0" cellpadding="0" cellspacing="0">
                <input name="id" type="hidden" value="<?php echo $id;?>">
			      
			      <tr>
                    <td width="41%" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right"><span style="white-space: nowrap;">客户ID	 </span>:</div></td>
                    <td width="3%" align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
                    <td width="56%" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
                      <input name="userid" type="text" id="userid" value="<?php echo $userid;?>" />
                    </div></td>
                    </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right"><span style="white-space: nowrap;">邮箱</span></div></td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="mail" type="text" id="mail" value="<?php echo $mail;?>" />
			        </div></td>
			        </tr>
			      
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">姓名 </td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><input name="ebay_username" type="text" id="ebay_username" value="<?php echo $ebay_username;?>" /></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">地址一</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><input name="ebay_street" type="text" id="ebay_street" value="<?php echo $ebay_street;?>" /></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">地址二</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><input name="ebay_street1" type="text" id="ebay_street1" value="<?php echo $ebay_street1;?>" /></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">城市</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><input name="ebay_city" type="text" id="ebay_city" value="<?php echo $ebay_city;?>" /></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">洲</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><input name="ebay_state" type="text" id="ebay_state" value="<?php echo $ebay_state;?>" /></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">所在国家</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><input name="ebay_countryname" type="text" id="ebay_countryname" value="<?php echo $ebay_countryname;?>" /></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">邮编</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><input name="ebay_postcode" type="text" id="ebay_postcode" value="<?php echo $ebay_postcode;?>" /></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"> 客户电话 </td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="ebay_phone" type="text" id="ebay_phone" value="<?php echo $ebay_phone;?>" />
			        </div></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">Paypal帐号</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="paypal_account" type="text" id="paypal_account" value="<?php echo $paypal_account;?>" />
			        </div></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"> 原因 </td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <textarea name="notes" cols="60" rows="5" id="notes"><?php echo $notes;?></textarea>
			        </div></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"> 状态 </td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left"><select name="status" id="status">
			          <option value="0" <?php if($status == '0') echo 'selected="selected"';?>>开启</option>
			          <option value="1" <?php if($status == '1') echo 'selected="selected"';?>>关闭</option>
			        </select></div></td>
			        </tr>
			      
			      
			      
			      
			      
                  <tr>				 
                    <td align="right" class="left_txt"><div align="right"></div></td>
                    <td align="right" class="left_txt">&nbsp;</td>
                    <td align="right" class="left_txt"><div align="left">
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
