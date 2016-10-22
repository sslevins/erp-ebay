<?php
    error_reporting(E_ALL);
	@session_start();
	
	$_SESSION['user']	= 'vipliang';
	
	$user	= $_SESSION['user'];
	
	include "include/dbconnect.php";
	
	$dbcon	= new DBClass();

	

	include "include/eBaySession.php";
	include "include/xmlhandle.php";
	include "include/ebay_lib.php";
	include "include/cls_page.php";
	date_default_timezone_set ("Asia/Chongqing");	
	$compatabilityLevel = 551;

	
	

	
	$devID		= "cddef7a0-ded2-4135-bd11-62db8f6939ac";
	$appID		= "Survyc487-9ec7-4317-b443-41e7b9c5bdd";
	$certID		= "b68855dd-a8dc-4fd7-a22a-9a7fa109196f";
	
	
	$serverUrl	= "https://api.ebay.com/ws/api.dll";
	
    $siteID = 0;  
    $detailLevel = 0;
	$nowtime	= date("Y-m-d H:i:s");
	$nowd		= date("Y-m-d");
	$Sordersn	= "eBay";
	$pagesize=20;//每页显示的数据条目数
	$mctime		= strtotime($nowtime);
	
	






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
					<td nowrap="nowrap" class='paginationActionButtons'>
                    
             <?php
			 
			 			
						$cc 		= date('Y-m-d');
                    	$start		= date('Y-m-d',strtotime("$cc -10 days"))." 00:00:00";
					 	$start		= strtotime($start);
						
						$end		= date('Y-m-d',strtotime("$cc -20 days"))." 00:00:00";
					 	$end		= strtotime($end);
						
						$ss			= "";
						$sql	= "select * from ebay_messagetemplate  where id='35'";

						$sql	= $dbcon->execute($sql);
						
						$sql	= $dbcon->getResultArray($sql);
						
						
						
						$content			= $sql[0]['content'];
						$content1			= $content;
						

						
				
						////s:1303660800e:1302796800
						
				
						$ss			= "select * from ebay_order  as a  where (a.ShippedTime>=$end and a.ShippedTime<=$start) and ebay_feedback=0";
				
						
			     		$ss			= $dbcon->execute($ss);
						$ss			= $dbcon->getResultArray($ss);
			
						for($i=0;$i<count($ss);$i++){
							
							$sn		= $ss[$i]['ebay_ordersn'];			 
							
							
							$sr				= "select * from ebay_orderdetail where ebay_ordersn='$sn'";
							$sr			= $dbcon->execute($sr);
							$sr			= $dbcon->getResultArray($sr);
							$itmeid			= $sr[0]['ebay_itemid'];
							$title				= $sr[0]['ebay_itemtitle'];
							
							
							
							$account			= $ss[0]['ebay_account'];
						    $sendid			= $ss[0]['ebay_userid'];
							
							$cname			= $ss[0]['ebay_username'];
							 $street1		= $ss[0]['ebay_street'];
							 $street2 		= $ss[0]['ebay_street1']?@$ss[0]['ebay_street1']:"";
							 $city 			= $ss[0]['ebay_city'];
							 $state			= $ss[0]['ebay_state'];
							 $countryname 	= $ss[0]['ebay_countryname'];
							 $zip			= $ss[0]['ebay_postcode'];
							 $tel			= $ss[0]['ebay_phone']?$ss[0]['ebay_phone']:"";
							 $ordersn		= $ss[0]['ebay_ordersn'];
							 $addressline	= $cname." ".$street1." ".$street2." ".$city." ".$state." ".$zip." ".$countryname;
							 $ebay_markettime 	= $ss[0]['ShippedTime'];
						 if($ebay_markettime != '' && $ebay_markettime	!='0'){
							
							$ebay_markettime	= date('Y-m-d',$ebay_markettime);
							
						 }else{		 
							
							$ebay_markettime	= '';
							
						 }
		 
		 $ebay_paidtime 	= $ss[0]['ebay_paidtime'];
		 if($ebay_paidtime != '' && $ebay_paidtime	!='0'){
		 	
			$ebay_paidtime	= date('Y-m-d',$ebay_paidtime);
			
		 }else{		 
		 	
			$ebay_paidtime	= '';
			
		 }
		 
		 $ShippedTime 	= $ss[0]['ShippedTime'];
		 if($ShippedTime != '' && $ShippedTime	!='0'){
		 	
			$ShippedTime	= date('Y-m-d',$ShippedTime);
			$ShippedTime7	= date('Y-m-d',strtotime("$ShippedTime +7days"));
		 	$ShippedTime9	= date('Y-m-d',strtotime("$ShippedTime +9days"));
		 	$ShippedTime14	= date('Y-m-d',strtotime("$ShippedTime +14days"));
		 	$ShippedTime21	= date('Y-m-d',strtotime("$ShippedTime +21days"));
			$ShippedTime30	= date('Y-m-d',strtotime("$ShippedTime +30days"));
			$content		= str_replace('{Post_Date}',$ShippedTime,$content);
			$content		= str_replace('{Post_Date_7}',$ShippedTime7,$content);
			$content		= str_replace('{Post_Date_9}',$ShippedTime9,$content);
			$content		= str_replace('{Post_Date_14}',$ShippedTime14,$content);
			$content		= str_replace('{Post_Date_21}',$ShippedTime21,$content);
			$content		= str_replace('{Post_Date_30}',$ShippedTime30,$content);
			
		 }else{		 
		 	
			$ShippedTime	= '';
			
		 }
		 
		
		  
		  
		 
		 $resendtime 	= $ss[0]['resendtime'];
		 if($resendtime != '' && $resendtime	!='0'){
		 	
			$resendtime	= date('Y-m-d',$resendtime);
			
			
		 }else{
		 $resendtime	='';
		 
		 
		 }
		 
		 $refundtime 	= $ss[0]['refundtime'];
		 if($refundtime != '' && $refundtime	!='0'){
		 	
			$refundtime	= date('Y-m-d',$refundtime);
			
			
		 }else{
		 	
			$refundtime	= '';
			
		 }
		 
		 $content		= str_replace('{RefundDate}',$refundtime,$content);
		 $content		= str_replace('{ReshipDate}',$resendtime,$content);
		 
		 
		 
		 
		
		 
		 
		 
		 $ebay_ptid 	= $ss[0]['ebay_ptid'];
		 $ebay_total 	= $ss[0]['ebay_total'];
		 $PayPalEmailAddress 	= $ss[0]['PayPalEmailAddress'];
		 $ebay_tracknumber	 	= $ss[0]['ebay_tracknumber'];
		 
		 
		 $currenttime	= date('Y-m-d');
		 $currenttime3	= date('Y-m-d',strtotime("$currenttime +3days"));
		 $currenttime5	= date('Y-m-d',strtotime("$currenttime +5days"));
		 $currenttime7	= date('Y-m-d',strtotime("$currenttime +7days"));
		 $currenttime10	= date('Y-m-d',strtotime("$currenttime +10days"));
	
		 
		 $content		= str_replace('{Today_10}',$currenttime10,$content);
		 $content		= str_replace('{Today_5}',$currenttime5,$content);
		 $content		= str_replace('{Today_7}',$currenttime7,$content);
		 $content		= str_replace('{Today_3}',$currenttime3,$content);
		 $content		= str_replace('{Track_Code}',$ebay_tracknumber,$content);
		 $content		= str_replace('{Today}',$currenttime,$content);
		 
		 $content		= str_replace('{Seller_Email}',$PayPalEmailAddress,$content);
		 $content		= str_replace('{Received_Amount}',$ebay_total,$content);
		 $content		= str_replace('{Paypal_Transaction_Id}',$ebay_ptid,$content);
		 $content		= str_replace('{Payment_Date}',$ebay_paidtime,$content);
		 $content		= str_replace('{Buyerid}',$sendid,$content);
		 $content		= str_replace('{Buyername}',$cname,$content);
		 $content		= str_replace('{Buyercountry}',$countryname,$content);
		 $content		= str_replace('{Sellerid}',$account,$content);
		 $content		= str_replace('{Itemnumber}',$itmeid,$content);
		 $content		= str_replace('{Itemtitle}',$title,$content);
		 $content		= str_replace('{Itemquantity}',"1",$content);
		 $content		= str_replace('{Shipdate}',$ebay_markettime,$content);
		 $content		= str_replace('{Shippingaddress}',$addressline,$content);
		 $content		= str_replace("&","&amp;",$content);

		 

			
			$sql 		 = "select * from ebay_account where ebay_user='$user' and ebay_account='$account'";
			$sql		 = $dbcon->execute($sql);
			$sql		 = $dbcon->getResultArray($sql);
			$token		 = $sql[0]['ebay_token'];
	
			 $messagecontent		= str_replace("&","&amp;",$content);
	
			echo addmessagetoparner($messagecontent,$token,'',$itmeid,$sendid);
			
			$content				= $content1;
			

			
			
	}
							
						


					
						
						
						
					
					?>    
                    
                    
                    &nbsp;				  </td>
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

include "bottom.php";


?>
<script language="javascript">
	function check(){
		
		var days	= document.getElementById('days').value;	
		var account = document.getElementById('account').value;	
		location.href='loadorder.php?days='+days+'&account='+account;
		
		
	}

</script>