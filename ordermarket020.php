<?php

include "include/config.php";

$ordersn	= $_REQUEST['ordersn'];


?>

<style type="text/css">
<!--
.STYLE1 {font-size: 12px}
-->
</style>
<form id="form" name="form" method="post" action="ordermarket02.php?ordersn=<?php echo $ordersn;?>">

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="68" valign="top"><span class="STYLE1">恢复内容：</span></td>
    <td><span class="STYLE1"></span>
    <textarea name="content" cols="60" rows="15" id="content"></textarea></td>
  </tr>
  <tr>
    <td height="64" valign="top"><span class="STYLE1">Message模板</span></td>
    <td valign="top"><span class="STYLE1">
      <select name="category<?php echo $mid;?>" id="category" onchange="ck(this)">
        <option value="">请选择</option>
        <?php
	
		$su		= "select * from ebay_messagetemplate where ebay_user='$user' order by ordersn desc";
		$su		= $dbcon->execute($su);
		$su		= $dbcon->getResultArray($su);
		for($o=0;$o<count($su);$o++){
			
			$name		= $su[$o]['name'];
			$content	= $su[$o]['content'];
			
		?>
        <option value="<?php echo $content; ?>"><?php echo $name;?></option>
        <?php } ?>
      </select>
    <input name="submit" type="submit" value="Reply" id="submit" />
    </span></td>
  </tr>
</table>
</form>


<?php
	
	if($_POST['submit']){
	
	
		$order		= explode(",",$ordersn);
		$content	= $_POST['content'];
		
	
	
	
	
	for($i=0;$i<count($order);$i++){
	
		
		if($order[$i] != ""){
		
			 $sn			= $order[$i];
		     $ss			= "select * from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn=b.ebay_ordersn where a.ebay_ordersn='$sn'";
			 

			 
			 $ss			= $dbcon->execute($ss);
			 $ss			= $dbcon->getResultArray($ss);
			 
			 $itmeid			= $ss[0]['ebay_itemid'];
			 $account			= $ss[0]['ebay_account'];
		
			 $sendid			= $ss[0]['ebay_userid'];
			 $title				= $ss[0]['ebay_itemtitle'];
			 
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
			
			$messagecontent	= $_POST['content'];
			 $messagecontent		= str_replace("&","&amp;",$messagecontent);

			
			echo addmessagetoparner($messagecontent,$token,'',$itmeid,$sendid);
			

		
		}
	
	}
	
	
		
		
	
	
	}


?>

<script>
	
		
	function ck(ck){
	
	
		var va		= ck.value;
		document.getElementById('content').value	= va;
		

		
		
	
	}
	

</script>
