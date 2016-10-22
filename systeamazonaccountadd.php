<?php
include "include/config.php";


include "top.php";




	

	
	$id		= $_REQUEST["id"];

	
	if($_POST['submit']){
		
			
			$ebay_account							= trim($_POST['ebay_account']);
			$AWS_ACCESS_KEY_ID						= trim($_POST['AWS_ACCESS_KEY_ID']);
			$AWS_SECRET_ACCESS_KEY					= trim($_POST['AWS_SECRET_ACCESS_KEY']);
			$MERCHANT_ID							= trim($_POST['MERCHANT_ID']);
			$MARKETPLACE_ID							= trim($_POST['MARKETPLACE_ID']);
			$serviceUrl								= trim($_POST['serviceUrl']);
			if($id == ""){
			
			
			$sql	= "insert into ebay_account(ebay_account,AWS_ACCESS_KEY_ID,AWS_SECRET_ACCESS_KEY,MERCHANT_ID,MARKETPLACE_ID,ebay_user,serviceUrl) values('$ebay_account','$AWS_ACCESS_KEY_ID','$AWS_SECRET_ACCESS_KEY','$MERCHANT_ID','$MARKETPLACE_ID','$user','$serviceUrl')";
			}else{
			
			$sql	= "update ebay_account set ebay_account='$ebay_account',AWS_ACCESS_KEY_ID='$AWS_ACCESS_KEY_ID',AWS_SECRET_ACCESS_KEY='$AWS_SECRET_ACCESS_KEY',MERCHANT_ID='$MERCHANT_ID',MARKETPLACE_ID='$MARKETPLACE_ID',serviceUrl='$serviceUrl' where id=$id";
			}
	

		
			
			if($dbcon->execute($sql)){
			
			$status	= " -[<font color='#33CC33'>操作记录: 帐号添加成功</font>]";
			
		}else{
		
			$status = " -[<font color='#FF0000'>操作记录: 帐号添加失败</font>]";
		}
		
			
		
	}
	
	
		if($id	!= ""){
	
		
		$sql = "select * from ebay_account where id=$id";
		$sql = $dbcon->execute($sql);
		$sql = $dbcon->getResultArray($sql);
					
		$ebay_account					= $sql[0]['ebay_account'];
		$AWS_ACCESS_KEY_ID				= $sql[0]['AWS_ACCESS_KEY_ID'];
		$AWS_SECRET_ACCESS_KEY			= $sql[0]['AWS_SECRET_ACCESS_KEY'];
		$MERCHANT_ID					= $sql[0]['MERCHANT_ID'];
		$MARKETPLACE_ID					= $sql[0]['MARKETPLACE_ID'];
		$serviceUrl						= $sql[0]['serviceUrl'];


		
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
                      <form id="form" name="form" method="post" action="systeamazonaccountadd.php?module=system&action=Amazon帐号添加&id=<?php echo $id;?>">
                  <table width="70%" height="240" border="0" cellpadding="0" cellspacing="0">
                <input name="id" type="hidden" value="<?php echo $id;?>">
			      <tr>
                    <td width="41%" height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right">Aamzon 帐号名称</div></td>
                    <td width="3%" align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
                    <td width="56%" height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
                      <input name="ebay_account" type="text" id="ebay_account" value="<?php echo $ebay_account;?>" />
                    </div></td>
                    </tr>
			      <tr>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right">AWS_ACCESS_KEY_ID</div></td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="AWS_ACCESS_KEY_ID" type="text" id="AWS_ACCESS_KEY_ID" size="50" value="<?php echo $AWS_ACCESS_KEY_ID;?>">
			        </div></td>
			        </tr>
			      <tr>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right">AWS_SECRET_ACCESS_KEY</div></td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="AWS_SECRET_ACCESS_KEY" type="text" id="AWS_SECRET_ACCESS_KEY" size="50" value="<?php echo $AWS_SECRET_ACCESS_KEY;?>">
			        </div></td>
			        </tr>
			      <tr>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right">MERCHANT_ID</div></td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="MERCHANT_ID" type="text" id="MERCHANT_ID" size="70" value="<?php echo $MERCHANT_ID;?>">
			        </div></td>
			        </tr>
			      <tr>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">MARKETPLACE_ID</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="MARKETPLACE_ID" type="text" id="MARKETPLACE_ID" size="70" value="<?php echo $MARKETPLACE_ID;?>" />
			          </div></td>
			        </tr>
			      <tr>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">Amazon 站点</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td height="30" align="left" bgcolor="#f2f2f2" class="left_txt"><select name="serviceUrl" id="serviceUrl">
			          <option value="https://mws.amazonservices.com"    <?php if($serviceUrl == 'https://mws.amazonservices.com') 	echo 'selected="selected"';?>>United States</option>
                      <option value="https://mws.amazonservices.co.uk"  <?php if($serviceUrl == 'https://mws.amazonservices.co.uk') echo 'selected="selected"';?>>United Kingdom</option>
                      <option value="https://mws.amazonservices.de"		<?php if($serviceUrl == 'https://mws.amazonservices.de')	 echo 'selected="selected"';?>>Germany</option>
                      <option value="https://mws.amazonservices.fr"		<?php if($serviceUrl == 'https://mws.amazonservices.fr') echo 'selected="selected"';?>>France</option>
                      <option value="https://mws.amazonservices.jp"		<?php if($serviceUrl == 'https://mws.amazonservices.jp') echo 'selected="selected"';?> >Japan</option>
                      <option value="https://mws.amazonservices.com.cn" <?php if($serviceUrl == 'https://mws.amazonservices.com.cn') echo 'selected="selected"';?> >China</option>
                      <option value="https://mws.amazonservices.ca"		<?php if($serviceUrl == 'https://mws.amazonservices.ca') echo 'selected="selected"';?> >Canada</option>    
                      <option value="https://mws.amazonservices.in"	 	<?php if($serviceUrl == 'https://mws.amazonservices.in') echo 'selected="selected"';?> >India</option>    
                      <option value="https://mws.amazonservices.it"	 	<?php if($serviceUrl == 'https://mws.amazonservices.it') echo 'selected="selected"';?> >Italy</option>   
                       <option value="https://developer.amazonservices.es"	 	<?php if($serviceUrl == 'https://developer.amazonservices.es') echo 'selected="selected"';?> >Spain</option>   
                      
                       
			        </select>&nbsp;</td>
			        </tr>
			      
			      
                  <tr>				 
                    <td height="30" align="right" class="left_txt"><div align="right"></div></td>
                    <td align="right" class="left_txt">&nbsp;</td>
                    <td height="30" align="right" class="left_txt"><div align="left">
                      <input name="submit" type="submit" value="保存数据" onClick="return check()">
                    </div></td>
                    </tr>
                  <tr>
                    <td height="30" align="right" class="left_txt">&nbsp;</td>
                    <td align="right" class="left_txt">&nbsp;</td>
                    <td height="30" align="right" class="left_txt">&nbsp;</td>
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
