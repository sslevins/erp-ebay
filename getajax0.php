<?php
	include "include/config.php";
	$type		= $_POST['type'];
	$mid		= $_POST['mid'];
	$content	= $_POST['body'];	
	if($type == 'message'){
		 $sql	= "select * from ebay_message where message_id='$mid'";
		 $sql	= $dbcon->execute($sql);
		 $sql	= $dbcon->getResultArray($sql);
		 $itmeid		= $sql[0]['itemid'];
		 $title			= $sql[0]['title'];
		 
		 $message_id 	= $sql[0]['message_id'];
		 $sendid		= $sql[0]['sendid'];
		 $account		= $sql[0]['ebay_account'];
		 $ss			= "select * from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn=b.ebay_ordersn where a.ebay_userid='$sendid'";

		 $ss	= $dbcon->execute($ss);
		 $ss	= $dbcon->getResultArray($ss);
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
		 echo trim($content.$ss0);
	}else if($type == 'replymessage'){		
		$content	= $_POST['body'];
		$mid		= $_POST['mid'];
		$status 	= AddMemberMessageRTQ($mid,$content,$_SESSION['truename']);
		echo $status;
	}else if($type == 'getorderdetails'){
		$ordersn		= $_POST['ordersn'];
		$ss				= "select * from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn=b.ebay_ordersn where a.ebay_ordersn='$ordersn'";
		$ss				= $dbcon->execute($ss);
		$ss				= $dbcon->getResultArray($ss);
		$account			= $ss[0]['ebay_account'];
		$ebay_itemprice		= $ss[0]['ebay_itemprice'];
		$ebay_username		= $ss[0]['ebay_userid'];
		$ebay_shipfee		= $ss[0]['ebay_shipfee'];
		$ebay_ordersn		= $ss[0]['ebay_ordersn'];
		$ebay_itemtitle		= $ss[0]['ebay_itemtitle'];
		$ebay_itemid		= $ss[0]['ebay_itemid'];
		$ebay_total			= $ss[0]['ebay_total'];
		$ebay_tracknumber	= $ss[0]['ebay_tracknumber'];
		$ebay_carrier		= $ss[0]['ebay_carrier'];
		$ebay_amount		= $ss[0]['ebay_amount'];
		$street1			= @$ss[0]['ebay_street'];
	    $street2 			= @$ss[0]['ebay_street1'];
	    $city 				= $ss[0]['ebay_city'];
	    $state				= $ss[0]['ebay_state'];
	    $countryname 		= $ss[0]['ebay_countryname'];
	    $zip				= $ss[0]['ebay_postcode'];
	    $tel				= $ss[0]['ebay_phone'];
		if($street2 == ''){
			$addressline		= $ebay_username."<br>".$street1."<br>".$city."<br>".$state."<br>".$zip."<br>".$countryname;
		}else{
			$addressline		= $ebay_username."<br>".$street1."<br>".$street2."<br>".$city."<br>".$state."<br>".$zip."<br>".$countryname;
		}		
		$ebay_noteb				= $ss[0]['ebay_noteb'];
		$ebay_note				= $ss[0]['ebay_note'];		
		$shiptime				= $ss[0]['ShippedTime'] ;
		$ebay_paidtime			= $ss[0]['ebay_paidtime'] ;
		$ebay_createdtime			= $ss[0]['ebay_createdtime'] ;		
		if($ebay_createdtime != '' && $ebay_createdtime != '0'){			
			$ebay_createdtime		= date('Y-m-d',$ss[0]['ebay_createdtime']);	
		}else{		
			$ebay_createdtime		= '';		
		}
		if($shiptime != '' && $shiptime != '0'){			
			$ShippedTime		= date('Y-m-d',$ss[0]['ShippedTime']);	
		}else{		
			$ShippedTime		= '';		
		}
				
		if($ebay_paidtime != ''){			
			$ebay_paidtime		= date('Y-m-d',$ebay_paidtime);	
		}else{			
			$ebay_paidtime		= '';
		}
		
		$resendtime				= $ss[0]['resendtime'];
		$refundtime				= $ss[0]['refundtime'];
		
		if($resendtime != '' && $resendtime != '0'){			
			$resendtime		= date('Y-m-d',$resendtime);	
		}else{			
			$resendtime		= '';
		}
		
		if($refundtime != '' && $refundtime != '0'){			
			$refundtime		= date('Y-m-d',$refundtime);	
		}else{			
			$refundtime		= '';
		}
		
		$resendreason				= $ss[0]['resendreason'];
		$refundreason				= $ss[0]['refundreason'];
		
		
		$cancelreason				= $ss[0]['cancelreason'];
		$canceltime					= $ss[0]['canceltime'];
		if($canceltime != '' && $canceltime != '0'){			
			$canceltime		= date('Y-m-d',$canceltime);	
		}else{			
			$canceltime		= '';
		}
		
		
		
		
		$xml			= '<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" bgcolor="#000000">
  <tr>
    <td width="11%" bgcolor="#FFFFFF">Account:</td>
    <td width="34%" bgcolor="#FFFFFF">'.$account.'&nbsp;</td>
    <td width="10%" bgcolor="#FFFFFF">Buyer</td>
    <td width="45%" bgcolor="#FFFFFF">'.$ebay_username.'&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">Item No</td>
    <td bgcolor="#FFFFFF">'.$ebay_itemid.'&nbsp;</td>
    <td bgcolor="#FFFFFF">Total</td>
    <td bgcolor="#FFFFFF">'.$ebay_total.'&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">Price</td>
    <td bgcolor="#FFFFFF">'.$ebay_itemprice."*".$ebay_amount.'份&nbsp;</td>
    <td bgcolor="#FFFFFF">Postage</td>
    <td bgcolor="#FFFFFF">'.$ebay_shipfee.'&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">Item Name</td>
    <td bgcolor="#FFFFFF">'.$ebay_itemtitle.'&nbsp;</td>
    <td bgcolor="#FFFFFF">Sale Date&nbsp;</td>
    <td bgcolor="#FFFFFF">'.$ebay_createdtime.'&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">Paid Date</td>
    <td bgcolor="#FFFFFF">'.$ebay_paidtime.'&nbsp;</td>
    <td bgcolor="#FFFFFF">Ship Date&nbsp;</td>
    <td bgcolor="#FFFFFF">'.$ShippedTime.'&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="2" valign="top" bgcolor="#FFFFFF">Address</td>
    <td rowspan="2" valign="top" bgcolor="#FFFFFF">'.$addressline.'&nbsp;</td>
    <td bgcolor="#FFFFFF">eBay Note</td>
    <td bgcolor="#FFFFFF">'.$ebay_note.'&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">Our Note</td>
    <td bgcolor="#FFFFFF">'.$ebay_noteb.'&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">Reship Date&nbsp;</td>
    <td bgcolor="#FFFFFF">'.$resendtime.'&nbsp;</td>
    <td bgcolor="#FFFFFF">Refund Date</td>
    <td bgcolor="#FFFFFF">'.$refundtime.'&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">重寄原因</td>
    <td bgcolor="#FFFFFF">'.$resendreason.'&nbsp;</td>
    <td bgcolor="#FFFFFF">退款原因</td>
    <td bgcolor="#FFFFFF">'.$refundreason.'&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">Tracking No.&nbsp;</td>
    <td bgcolor="#FFFFFF">'.$ebay_tracknumber.'&nbsp;</td>
    <td bgcolor="#FFFFFF">Carrier&nbsp;</td>
    <td bgcolor="#FFFFFF">'.$ebay_carrier.'&nbsp;</td>
  </tr>
    <tr>
    <td bgcolor="#FFFFFF">取消时间</td>
    <td bgcolor="#FFFFFF">'.$canceltime.'</td>
    <td bgcolor="#FFFFFF">取消原因</td>
    <td bgcolor="#FFFFFF">'.$cancelreason.'</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">操作</td>
    <td colspan="3" bgcolor="#FFFFFF"><input type="button" value="编辑订单"  onclick="editorders()" />
    <input name="input" type="button" value="重寄订单"  onclick="resend()" />
    <input name="input2" type="button" value="退款订单" onclick="refund()"/>
	<input name="input2" type="button" value="取消订单" onclick="calcenorder()"/>
    <input name="input3" type="button" value="评价"  onclick="feedback()" /></td>
  </tr>
</table>
';
echo $xml;
}
$dbcon->close();
?>