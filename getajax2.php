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

		 $ss			= "select * from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn=b.ebay_ordersn where a.ebay_userid='$sendid' and b.ebay_itemid ='$itmeid'";

		

		 //$ss			= "select * from ebay_order as a  where a.ebay_userid='$sendid'";



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



		 

		 echo $content;

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

		$ebay_username		= $ss[0]['ebay_username'];

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

    <td width="10%" bgcolor="#FFFFFF">Buyer full name </td>

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

}else if($type == 'changestatus'){



	$sql			= "UPDATE `ebay_message` SET `status` = '1' WHERE `message_id` ='$mid'";

	$sql	= $dbcon->execute($sql);

	echo "0";

	









}else if($type == 'changecateogry'){

	

	

	$classid		= $_REQUEST['categoryid'];

	

	$sql			= "UPDATE `ebay_message` SET `classid` = '".$classid."' WHERE `message_id` ='$mid'";

	$sql	= $dbcon->execute($sql);

	echo "0";

	









}else if($type == 'address'){

	

	$cstatus			= $_REQUEST['cstatus'];

	$ordersn			= $_REQUEST['ordersn'];

	$sql		= "select * from ebay_order where ebay_ordersn='$ordersn'";

	

	$sql		= $dbcon->execute($sql);

	$sql		= $dbcon->getResultArray($sql);

	



	

	if($cstatus         == 0){

				

				 $ebay_username				= str_rep($sql[0]['eebay_username']);

				 $ebay_usermail				= str_rep($sql[0]['eebay_usermail']);

				 $ebay_street				= str_rep($sql[0]['eebay_street']);

				 $ebay_street1				= str_rep($sql[0]['eebay_street1']);

				 $ebay_city					= str_rep($sql[0]['eebay_city']);

				 $ebay_state				= str_rep($sql[0]['eebay_state']);

				 $ebay_countryname			= str_rep($sql[0]['eebay_countryname']);

				 $ebay_postcode				= str_rep($sql[0]['eebay_postcode']);

				 

	}else{

				$ebay_username				= str_rep($sql[0]['PayPal_username']);

				$ebay_street				= str_rep($sql[0]['PayPal_street']);

				$ebay_street1				= str_rep($sql[0]['PayPal_street1']);

				$ebay_city					= str_rep($sql[0]['PayPal_city']);

				$ebay_state					= str_rep($sql[0]['PayPal_state']);

				$ebay_countryname			= str_rep($sql[0]['PayPal_countryname']);

				$ebay_postcode				= str_rep($sql[0]['PayPal_postcode']);

				$ebay_usermail				= str_rep($sql[0]['PaypPal_usermail']);

	}

	$ebay_phone				= $sql[0]['eebay_phone'];

	

	$sql		= "update ebay_order set ebay_username='$ebay_username',ebay_street='$ebay_street',ebay_street1='$ebay_street1',ebay_city='$ebay_city',ebay_state='$ebay_state',ebay_countryname='$ebay_countryname',ebay_postcode='$ebay_postcode',ebay_usermail='$ebay_usermail' where  ebay_ordersn='$ordersn'";

	

	if($dbcon->execute($sql)){

	

		

		$addressline		= $ebay_username."**".$ebay_street."**".$ebay_street1."**".$ebay_city."**".$ebay_state."**".$ebay_countryname."**".$ebay_postcode."**".$ebay_usermail;

		

		echo $addressline;

		

	

	}else{

	

		

		echo "0";

		

	

	}

	



}else if($type == 'checkorder'){
	$ebayid				= $_REQUEST['ebayid'];
	$ss					= "select * from ebay_order where ebay_id='$ebayid' and ebay_user ='$user' and scantime<=0 ";
	$ss					= $dbcon->execute($ss);
	$ss					= $dbcon->getResultArray($ss);
	$status = '0';
	if(count($ss)  >0 ){
		$status = '1';
	}
	echo $status;
}else if($type == 'checkorder02'){

	$ebayid				= $_REQUEST['ebayid'];
	
	if(strlen($ebayid) >= 5){
	$ss					= "select * from ebay_order where ebay_tracknumber='$ebayid'  and ebay_user ='$user' and ebay_tracknumber != ''  and scantime<=0  ";
	$ss					= $dbcon->execute($ss);
	$ss					= $dbcon->getResultArray($ss);
	$status = '0';
	if(count($ss)  >0 ){
		$status = '1';
	}
	}
	
	echo $status;
}else if($type == 'updateweight'){





	$ebayid		= $_REQUEST['ebayid'];

	$currentweight		= $_REQUEST['currentweight'];



	$ss	= "update ebay_order set orderweight2 = '$currentweight'  where ebay_id='$ebayid' ";

	$status = '0';

	if($dbcon->execute($ss)){

	$status = '1';

	}



	echo $status;





}else if($type == 'listshipfee'){





}else if($type == 'tracknumber'){

$ebayid				= $_REQUEST['ebayid'];
$packagingstaff		= $_REQUEST['packagingstaff'];
$tracknumber		= $_REQUEST['tracknumber'];
$ss					= "update ebay_order set ebay_tracknumber = '$tracknumber',ebay_status='$auditcompleteorderstatus',packinguser='$truename',scantime='$mctime',packagingstaff='$packagingstaff'  where ebay_id='$ebayid' ";

$status = '0';

	if($dbcon->execute($ss)){

				$status = addoutorderscan($ebayid);


	}



echo $status;

			

}else if($type == 'changemethod'){





$ebayid				= $_REQUEST['ebayid'];

$packingby		= $_REQUEST['packingby'];

$ss					= "update ebay_order set ebay_carrier = '$packingby' where ebay_id='$ebayid' ";



$status = '0';

	if($dbcon->execute($ss)){

	$status = '1';

	}



	echo $status;

			

			

			

			

}else if($type == 'getpweight'){

	

	
	$ebayid				 = $_REQUEST['ebayid'];
	$ss 				 = "select ebay_ordersn from ebay_order where ebay_id ='$ebayid' or  ebay_tracknumber='$ebayid' ";
	$ss					 = $dbcon->execute($ss);
	$ss					 = $dbcon->getResultArray($ss);

	$ordersn			 = $ss[0]['ebay_ordersn'];

	

	$ss		= "select * from ebay_orderdetail where ebay_ordersn ='$ordersn' ";
	$ss					 = $dbcon->execute($ss);
	$ss					 = $dbcon->getResultArray($ss);
	

	$tt		= 0;

	

	for($i=0;$i<count($ss);$i++){

	

			
			$ebay_amount		= $ss[$i]['ebay_amount'];
			$sku		= $ss[$i]['sku'];
			$vv			= "select * from ebay_goods where goods_sn ='$sku' and ebay_user = '$user' ";
			$vv			= $dbcon->execute($vv);
			$vv			= $dbcon->getResultArray($vv);
			
			if(count($vv) == 0 ){
			
					
					$rr			= "select * from ebay_productscombine where ebay_user='$user' and goods_sn='$sku'";
						$rr			= $dbcon->execute($rr);
						$rr 	 	= $dbcon->getResultArray($rr);
						if(count($rr) > 0){
									$goods_sncombine	= $rr[0]['goods_sncombine'];
									$goods_sncombine    = explode(',',$goods_sncombine);	
									for($e=0;$e<count($goods_sncombine);$e++){
											$pline			= explode('*',$goods_sncombine[$e]);
											$goods_sn		= $pline[0];
											$goddscount     = $pline[1] * $ebay_amount;
											$sql			= "select * from ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
											$sql			= $dbcon->execute($sql);
											$sql			= $dbcon->getResultArray($sql);
											$goods_weight		= $sql[0]['goods_weight'] * $goddscount;
											$tt			+= $goods_weight;
									}
						}
						
			
			
			}else{
			
			$tt			+= $vv[0]['goods_weight'];
			
			}
			
			

	}

	

	$tt		= number_format($tt*1000,0).' g';


	

	echo $tt;

	

				



			

}else if($type == 'tracknumber2'){





$ebayid				= $_REQUEST['ebayid'];

$currentweight		= $_REQUEST['currentweight'];



if($ebayid != '' && $auditcompleteorderstatus > 0){
	
	$packagingstaff		= $_REQUEST['packagingstaff'];

	$ss					= "update ebay_order set ebay_status='$auditcompleteorderstatus',packinguser='$truename',scantime='$mctime',packagingstaff='$packagingstaff',orderweight2 = '$currentweight' where  ebay_id='$ebayid'  ";
	$status = '0';
	if($dbcon->execute($ss)){
				$status = addoutorderscan($ebayid);
	}

}else{
$status = '0';

}



echo $status;



			

			

			

			

}else if($type == 'tracknumber3'){





$ebayid				= $_REQUEST['ebayid'];
$currentweight		= $_REQUEST['currentweight'];



if($ebayid != '' && $auditcompleteorderstatus >0 ){

$packagingstaff		= $_REQUEST['packagingstaff'];

$ss					= "update ebay_order set ebay_status='$auditcompleteorderstatus',packinguser='$truename',scantime='$mctime',packagingstaff='$packagingstaff',orderweight2 = '$currentweight' where ebay_tracknumber ='$ebayid' and ebay_tracknumber != ''  and ebay_user ='$user' ";



$status = '0';

	if($dbcon->execute($ss)){
	
				
				$vvv		= "select ebay_id from ebay_order where ebay_tracknumber = '$ebayid'  and ebay_user ='$user' ";
				$vvv		= $dbcon->execute($vvv);
				$vvv		= $dbcon->getResultArray($vvv);
				$ebayid		= $vvv[0]['ebay_id'];
				
				$status = addoutorderscan($ebayid);

	}

}else{
$status = '0';

}



echo $status;



			

			

			

			

}else if($type=='changesku'){
	$id = $_REQUEST['id'];
	$sku = $_REQUEST['sku'];
	$vv = "update ebay_orderdetail set sku='$sku' where ebay_id = '$id'";
	if($dbcon->execute($vv)){
		echo 0;
	}else{
		echo 1;
	}


}







$dbcon->close();

?>