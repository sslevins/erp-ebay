<?php
include "include/config.php";


include "top.php";
$id		= $_REQUEST['id'];


if($_POST['submit']){

	$sql		= "select * from ebay_order as a where ebay_id='$id'";	
	$sql		= $dbcon->execute($sql);
	$sql		= $dbcon->getResultArray($sql);
	
	$userid		= $sql[0]['ebay_userid'];
	$tid		= $sql[0]['ebay_tid'];
	$ordersn	= $sql[0]['ebay_ordersn'];
	$oid		= $sql[0]['ebay_id'];
	$templateid	= $sql[0]['templateid'];
	$account	= $sql[0]['ebay_account'];
	$status		= $sql[0]['status'];
	
	
	$sql			= "select * from ebay_orderdetail as a where ebay_ordersn='$ordersn'";	
	$sql			= $dbcon->execute($sql);
	$sql			= $dbcon->getResultArray($sql);	
	$itemid			= $sql[0]['ebay_itemid'];
	
	$bb			= "select * from ebay_account where ebay_account='$account'";
	$bb			= $dbcon->execute($bb);
	$bb			= $dbcon->getResultArray($bb);
	$smail		= $bb[0]['mail'];
	
	
	$itemid			= $sql[0]['ebay_itemid'];
	$itemtitle		= $sql[0]['ebay_itemtitle'];
	$link			= "http://cgi.ebay.com/ws/eBayISAPI.dll?ViewItem&item=".$itemid;
	
	$feedbacklink		= "http://feedback.ebay.com/ws/eBayISAPI.dll?LeaveFeedbackShow&useridfrom={$userid}&useridto={$account}&item={$itemid}&transactid=$tid";
	$feedbacklink		=  str_replace("&","&amp;",$feedbacklink);
	
	
	
	$subject	= str_rep($_POST['subject']);
	$tempatestr	= str_rep($_POST['template']);
	$status		= str_rep($_POST['status']);
	
	if($subject !="" && $tempatestr !=""){
		
			
			$sql 			  = "select * from ebay_account where ebay_account='$account'";
 			$sql			  = $dbcon->execute($sql);
 			$sql			  = $dbcon->getResultArray($sql);
 			$userToken		  = $sql[0]['ebay_token'];
	    
			
			$link		=  str_replace("&","&amp;",$link);
			$tempatestr  = str_replace("{BUYERUSERNAME}",$userid,$tempatestr);
			$tempatestr  = str_replace("{TITLE}",$itemtitle,$tempatestr);
			$tempatestr  = str_replace("{ITEM#}",$itemid,$tempatestr);
			$tempatestr  = str_replace("{ITEMLINK}",$link,$tempatestr);
			$tempatestr  = str_replace("{SELLERUSERNAME}",$account,$tempatestr);
			$tempatestr  = str_replace("{TOTAL$}",$ebay_total,$tempatestr);
			$tempatestr  = str_replace("{SHIPPEDDATE}",$ebay_markettime,$tempatestr);
			$tempatestr  = str_replace("{SALESRECORDNUMBER}",$recordnumber,$tempatestr);
			$tempatestr  = str_replace("{B_COUNTRY}",$ebay_countryname,$tempatestr);
			$tempatestr  = str_replace("{S_EMAIL}",$smail,$tempatestr);
			$tempatestr  = str_replace("{FEEDBACKLINK}",$feedbacklink,$tempatestr);
			
			$tempatestr  = str_replace("&acute;","'",$tempatestr);
			$tempatestr  = str_replace("&quot;","\"",$tempatestr);
		
		
			
			$runstatus		  = addmessagetoparner($tempatestr,$userToken,$subject,$itemid,$userid);
			echo $runstatus;
			
			
			if($runstatus == "Success"){
			
				echo " -[<font color='#33CC33'>发送成功</font>]";
			
			}else{
			
				echo " -[<font color='#FF0000'>".$runstatus."</font>]";
			}			
			$addtime	= strtotime(date("Y-m-d H:i:s"));
		    $tempatestr		  = str_rep($tempatestr);
			if($status == 1){
			$se		= "insert into ebay_messagelog(order_id,ordernumber,messagetemplate,time,status) values('$id','2','$tempatestr','$addtime','$runstatus')";
			
			}else{
			$se		= "insert into ebay_messagelog(order_id,ordernumber,messagetemplate,time,status) values('$id','0','$tempatestr','$addtime','$runstatus')";
			
			}
			
			
			echo $se;
			
			
			$dbcon->execute($se);
	}



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
                      <form id="form" name="form" method="post" action="handelmessagereply.php?module=mail&action=回复Message&id=<?php echo $id; ?>">
                  <table width="100%" border="0" align="center" cellspacing="0" class="left_txt">
                    <tr>
                      <td width="14%">信件主题：</td>
                      <td colspan="2"><input name="subject" type="text" id="subject" value=>
&nbsp;</td>
                    </tr>
                    <tr>
                      <td>信件内容：</td>
                      <td width="67%"><textarea name="template" cols="100" rows="20" id="template"></textarea>
&nbsp;</td>
                      <td width="19%">
                      当前模板选择:
    <br />
    <br />

	<?php
	
	$su		= "select * from ebay_messagetemplate where ebay_user='$user' order by id desc";
	$su		= $dbcon->execute($su);
	$su		= $dbcon->getResultArray($su);
	for($o=0;$o<count($su);$o++){
		
		$name		= $su[$o]['name'];
		$content	= $su[$o]['content'];
		$mid	= $su[$o]['id'];

		
		echo "<input name=\"nc$mid\" type=\"radio\" value=\"$content\" onclick=ck(this) /> $name <br>";
		
		
	}
	
	
	
	?>    
                      
                      &nbsp;</td>
                    </tr>
                    <tr>
                      <td>是否为过程信</td>
                      <td><select name="status" id="status">
                        <option value="0" <?php if($status == '0') echo "selected=selected" ?>>请选择</option>
                        <option value="1" <?php if($status == '1') echo "selected=selected" ?>>是过程信</option>
                        <option value="2" <?php if($status == '2') echo "selected=selected" ?>>非过程信</option>

                      </select></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="3"><input name="submit" type="submit" value="提交" onClick="return check()">
                        &nbsp;</td>
                      </tr>
                  </table>
                  </form>
					  <p>&nbsp;</p>
				    <p>&nbsp;</p>
				    <p>&nbsp;</p>
				    <p>&nbsp;</p></td>
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
	
		var status	= document.getElementById('status').value;
		if(status == 0){
		
			alert("请选择是否为过程信");
			
			return false;
			
		
		}
	
	
	}
	
	function ck(icd){
		
		var content	= icd.value;
		document.getElementById('template').value		= content;
		
	
	
	
	}




</script>
