<?php 
include "include/config.php";
error_reporting(E_ALL);

include "MarketplaceWebService/Samples/SV3.php";



	$order		= $_REQUEST['ordersn'];
	$order		= explode(",",$order);
	$type		= $_REQUEST['type'];
	
	
	$start0						= strtotime("$nowtime -16 hours");
	$shiptime					= date('Y-m-d',$start0).'T'.date('H:i:s',$start0).'-00:00';
	
	$Itemstr					= '';
	
	
	for($i=0;$i<count($order);$i++){
	
		
		if($order[$i] != ""){
		
			$sn			= $order[$i];
			$sq			= "select ebay_combine,ebay_id,ebay_tracknumber,ebay_carrier,ebay_account,ebay_ordersn,ebay_markettime from ebay_order where ebay_id='$sn'";
			

			
			$sqa		= $dbcon->execute($sq);
			$sq			= $dbcon->getResultArray($sqa);
			$dbcon->free_result($sqa);
			
			
			$corder		 = $sq[0]['ebay_combine'];			
			$corder		 = explode('#',$corder);
			
			$ebay_id					= $sq[0]['ebay_id'];		
			$ebay_tracknumber			= $sq[0]['ebay_tracknumber'];
			$ebay_carrier				= $sq[0]['ebay_carrier'];
			
			$ss						= "select value from ebay_carrier where name='$ebay_carrier' and ebay_user='$user'";
			$ss						= $dbcon->execute($ss);
			$ss						= $dbcon->getResultArray($ss);
			$ebay_carrier			= $ss[0]['value'];
			
			
						
			$account					= $sq[0]['ebay_account'];
			$osn						= $sq[0]['ebay_ordersn'];		
			$ebay_markettime			= $sq[0]['ebay_markettime'];	
	
			
			$sql 		 = "select ebay_token,AWS_ACCESS_KEY_ID from ebay_account where ebay_user='$user' and ebay_account='$account'";
			$sqla		 = $dbcon->execute($sql);
			$sql		 = $dbcon->getResultArray($sqla);
			
			$token					 = $sql[0]['ebay_token'];   // ebay toekn
			$AWS_ACCESS_KEY_ID		 = $sql[0]['AWS_ACCESS_KEY_ID']; // amazon key
			
			
			
		//	$sq			 = "select * from ebay_orderdetail where ebay_ordersn='$osn' and Combine_orderid ='0'";
			
			$sq			 = "select * from ebay_orderdetail where ebay_ordersn='$osn' ";
			
			
			
			$sq			 = $dbcon->execute($sq);
			$sq			 = $dbcon->getResultArray($sq);
			$Itemstr	 .= "<Message>
        <MessageID>$i</MessageID>
        <OperationType>Update</OperationType>
        <OrderFulfillment>
        <AmazonOrderID>$osn</AmazonOrderID>
        <FulfillmentDate>$shiptime</FulfillmentDate>
		<FulfillmentData> 
		<CarrierName>$ebay_carrier</CarrierName> 
		<ShippingMethod>$ebay_carrier</ShippingMethod> 
		<ShipperTrackingNumber>$ebay_tracknumber</ShipperTrackingNumber> 
		</FulfillmentData>";
		
			for($j=0;$j<count($sq);$j++){
				
				$recordnumber		= $sq[$j]['recordnumber'];
				$ebay_amount		= $sq[$j]['ebay_amount'];
				$Itemstr	.= '<Item><AmazonOrderItemCode>'.$recordnumber.'</AmazonOrderItemCode><Quantity>'.$ebay_amount.'</Quantity></Item>';
			}
			$Itemstr	 .= '</OrderFulfillment></Message>';
		
			
			
			
			//markettoamazon($ebay_id);
		}
	
	}
	
	echo $Itemstr;
	
	
	
	markettoamazon($Itemstr,$ebay_id);

?>
