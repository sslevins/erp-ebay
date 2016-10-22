<?php

include "include/config.php";


	error_reporting(E_ALL);
	
	$account    = $_REQUEST['account'];
	$start	    = $_REQUEST['start'];
	
	
	$starttime	= date('Y-m-d\TH:i:s',strtotime($start));
	
	$ss			= "";
	
	$ss				= "select * from ebay_account where ebay_account ='$account' and ebay_user ='$user' ";
	$ss				= $dbcon->execute($ss);
	$ss				= $dbcon->getResultArray($ss);
	
	
	for($i=0;$i<count($ss);$i++){
		
		$account				= $ss[$i]['ebay_account'];
		$AWS_ACCESS_KEY_ID		= $ss[$i]['AWS_ACCESS_KEY_ID'];
		$AWS_SECRET_ACCESS_KEY	= $ss[$i]['AWS_SECRET_ACCESS_KEY'];
		$MERCHANT_ID			= $ss[$i]['MERCHANT_ID'];
		$MARKETPLACE_ID			= $ss[$i]['MARKETPLACE_ID'];
		$serviceUrl				= $ss[$i]['serviceUrl'];
		$serviceUrl				= str_replace('https://','',$serviceUrl);
		
		$responseXml					= amazon_xml($serviceUrl,$starttime,$AWS_ACCESS_KEY_ID,$MERCHANT_ID,$MARKETPLACE_ID,$AWS_SECRET_ACCESS_KEY);
		$data=XML_unserialize($responseXml); 
		
		
		
		
		
		
		
		$Trans	 						= $data['ListOrdersResponse']['ListOrdersResult']['Orders']['Order'];  
		
		
		if($data['ListOrdersResponse']['ListOrdersResult']['Orders']['Order']['AmazonOrderId'] != ''){
			
			
							$Trans								= array();
							$Trans[0] 							= $data['ListOrdersResponse']['ListOrdersResult']['Orders']['Order'];
							
		}
		

		
		
		foreach((array)$Trans as $Transaction){
		
			
			$shiptype					 		= $Transaction['ShipmentServiceLevelCategory'];	
			$val						 		= $Transaction['AmazonOrderId'];	
			$orderid					 		= $Transaction['AmazonOrderId'];	
			$CreatedDate					 	= strtotime($Transaction['PurchaseDate']);
			
			$UserID						 		= $Transaction['BuyerName'];
			$Name						 		= $Transaction['ShippingAddress']['Name'];
			$Email						 		= $Transaction['BuyerEmail'];
			$Street1						 		= $Transaction['ShippingAddress']['AddressLine1'];
			$Street2						 		= $Transaction['ShippingAddress']['AddressLine2'];
			
			$StateOrProvince				 		= $Transaction['ShippingAddress']['StateOrRegion'];
			$StateOrProvince						= $Transaction['ShippingAddress']['AddressLine2'];
			$Country								= $Transaction['ShippingAddress']['CountryCode'];
			$PostalCode								= $Transaction['ShippingAddress']['PostalCode'];
			$Phone									= $Transaction['ShippingAddress']['Phone'];
			$Currency									= $Transaction['OrderTotal']['CurrencyCode'];
			$AmountPaid									= $Transaction['OrderTotal']['Amount'];
			
			$orderstatus							= 1;
			
			echo $AmazonOrderId.' '.$ShipmentServiceLevelCategory.'<br>';
			
			
			
			
			/* 添加sql语句 */
			
					$sql			 = "INSERT INTO `ebay_order` (`ebay_paystatus`,`ebay_ordersn` ,`ebay_tid` ,`ebay_ptid` ,`ebay_orderid` ,";
					$sql			.= "`ebay_createdtime` ,`ebay_paidtime` ,`ebay_userid` ,`ebay_username` ,`ebay_usermail` ,`ebay_street` ,";
					$sql			.= "`ebay_street1` ,`ebay_city` ,`ebay_state` ,`ebay_couny` ,`ebay_countryname` ,`ebay_postcode` ,`ebay_phone`";
					$sql			.= " ,`ebay_currency` ,`ebay_total` ,`ebay_status`,`ebay_user`,`ebay_shipfee`,`ebay_account`,`recordnumber`,`ebay_addtime`,`ebay_note`,`ebay_site`,`eBayPaymentStatus`,`PayPalEmailAddress`,`ShippedTime`,`RefundAmount`,`ebay_warehouse`,`order_no`,`ebay_carrier`)VALUES ('Complete','$val', '$tid' , '$ptid' , '$orderid' , '$CreatedDate' , '$CreatedDate' , '$UserID' ,";
					$sql			.= " '$Name' , '$Email' , '$Street1' , '$Street2' , '$CityName','$StateOrProvince' , '$Country' , '$cname' , '$PostalCode' , '$Phone' , '$Currency' , '$AmountPaid' , '$orderstatus','$user','$shipingfee','$account','$addrecordnumber','$mctime','$BuyerCheckoutMessage','$site','$eBayPaymentStatus','$PayPalEmailAddress','$ShippedTime','$RefundAmount','$defaultstoreid','$order_no','$ebay_carrier')";
					
					
					
					
					$sg				= "select * from ebay_order where ebay_ordersn ='$val'";
					$sg				= $dbcon->execute($sg);
					$sg				= $dbcon->getResultArray($sg);
					
					

					print_r($sg);

					if($val != ''){
					if(count($sg) == 0){
								
						$orderdetail	= amazon_xml_detal($serviceUrl,$starttime,$AWS_ACCESS_KEY_ID,$MERCHANT_ID,$MARKETPLACE_ID,$AWS_SECRET_ACCESS_KEY,$val);
						$orderdetail    =XML_unserialize($orderdetail); 
						$orderTrans		= $orderdetail['ListOrderItemsResponse']['ListOrderItemsResult']['OrderItems']['OrderItem'];
						
						
						if($orderdetail['ListOrderItemsResponse']['ListOrderItemsResult']['OrderItems']['OrderItem']['OrderItemId'] != ''){
							$orderTrans								= array();
							$orderTrans[0] 							= $orderdetail['ListOrderItemsResponse']['ListOrderItemsResult']['OrderItems']['OrderItem'];
						}
						
						foreach((array)$orderTrans as $orderTransaction){
							
							
							$ebay_itemid		= $orderTransaction['ASIN'];
							$title				= $orderTransaction['Title'];
							$ebayitemprice		= $orderTransaction['ItemPrice']['Amount'];
							$amount				= $orderTransaction['QuantityOrdered'];
							$recordnumber		= $orderTransaction['OrderItemId'];
								
								
							
						$esql	 = "INSERT INTO `ebay_orderdetail` (`ebay_ordersn` ,`ebay_itemid` ,`ebay_itemtitle` ,`ebay_itemprice` ,";
						$esql    .= "`ebay_amount` ,`ebay_createdtime` ,`ebay_shiptype` ,`ebay_user`,`sku`,`shipingfee`,`ebay_account`,`addtime`,`ebay_itemurl`,`ebay_site`,`recordnumber`,`storeid`,`ListingType`,`ebay_tid`,`FeeOrCreditAmount`,`FinalValueFee`,`attribute`,`notes`,`goods_location`)VALUES ('$val', '$ebay_itemid' , '$title' , '$ebayitemprice' , '$amount'";
				        $esql	.= " , '$ctime' , '$shiptype' , '$user','$sku','$shipingfee','$account','$mctime','$pic','$site','$recordnumber','$storeid','$ListingType','$tid','$FeeOrCreditAmount','$FinalValueFee','$arrribute','$BuyerCheckoutMessage','$goods_location')";	
				
							



							$sg			= "select * from ebay_orderdetail where ebay_ordersn ='$val' and recordnumber ='$recordnumber' ";
							$sg			= $dbcon->execute($sg);
							$sg			= $dbcon->getResultArray($sg);
							
							if(count($sg) == 0){
						
								if($dbcon->execute($esql)){
									
									echo '<br>Amazon ID Products: '.$val.' 添加成功';
								}else{
									echo '<br>Amazon ID Products : '.$val.' 添加失败';


									echo $esql;

								}
							}


				
				
				
						}
						
						
						


						
					}else{


								
							


							$sg			= "select * from ebay_orderdetail where ebay_ordersn ='$val' ";
							$sg			= $dbcon->execute($sg);
							$sg			= $dbcon->getResultArray($sg);
							
							if(count($sg) == 0){



											


											$orderdetail	= amazon_xml_detal($serviceUrl,$starttime,$AWS_ACCESS_KEY_ID,$MERCHANT_ID,$MARKETPLACE_ID,$AWS_SECRET_ACCESS_KEY,$val);
						$orderdetail    =XML_unserialize($orderdetail); 
						$orderTrans		= $orderdetail['ListOrderItemsResponse']['ListOrderItemsResult']['OrderItems']['OrderItem'];
						
						
						if($orderdetail['ListOrderItemsResponse']['ListOrderItemsResult']['OrderItems']['OrderItem']['OrderItemId'] != ''){
							$orderTrans								= array();
							$orderTrans[0] 							= $orderdetail['ListOrderItemsResponse']['ListOrderItemsResult']['OrderItems']['OrderItem'];
						}
						
						foreach((array)$orderTrans as $orderTransaction){
							
							
							$ebay_itemid		= $orderTransaction['ASIN'];
							$title				= $orderTransaction['Title'];
							$ebayitemprice		= $orderTransaction['ItemPrice']['Amount'];
							$amount				= $orderTransaction['QuantityOrdered'];
							$recordnumber		= $orderTransaction['OrderItemId'];
								
								
							
						$esql	 = "INSERT INTO `ebay_orderdetail` (`ebay_ordersn` ,`ebay_itemid` ,`ebay_itemtitle` ,`ebay_itemprice` ,";
						$esql    .= "`ebay_amount` ,`ebay_createdtime` ,`ebay_shiptype` ,`ebay_user`,`sku`,`shipingfee`,`ebay_account`,`addtime`,`ebay_itemurl`,`ebay_site`,`recordnumber`,`storeid`,`ListingType`,`ebay_tid`,`FeeOrCreditAmount`,`FinalValueFee`,`attribute`,`notes`,`goods_location`)VALUES ('$val', '$ebay_itemid' , '$title' , '$ebayitemprice' , '$amount'";
				        $esql	.= " , '$ctime' , '$shiptype' , '$user','$sku','$shipingfee','$account','$mctime','$pic','$site','$recordnumber','$storeid','$ListingType','$tid','$FeeOrCreditAmount','$FinalValueFee','$arrribute','$BuyerCheckoutMessage','$goods_location')";	
				
							



							$sg			= "select * from ebay_orderdetail where ebay_ordersn ='$val' and recordnumber ='$recordnumber' ";
							$sg			= $dbcon->execute($sg);
							$sg			= $dbcon->getResultArray($sg);
							
							if(count($sg) == 0){
						
								if($dbcon->execute($esql)){
									
									echo '<br>Amazon ID Products: '.$val.' 添加成功';
								}else{
									echo '<br>Amazon ID Products : '.$val.' 添加失败';


									echo $esql;

								}
							}


				
				
				
						}
						





							}




								
						

					}



					}
					
					
					
					
					
					
					echo $sql;
					die(' 系统测试中，    ');
					
					
			
			
			
		
		}
		
		


		
	}
	
	
	
	
	
	
	/* 同步订单数据。 */
 function amazon_xml($serviceUrl,$starttime,$AWS_ACCESS_KEY_ID,$MERCHANT_ID,$MARKETPLACE_ID,$AWS_SECRET_ACCESS_KEY) {
 
	$params = array(
     'AWSAccessKeyId' => $AWS_ACCESS_KEY_ID,
     'Action' => 'ListOrders',
     'SellerId' => $MERCHANT_ID,
 	 'MaxResultsPerPage' => 10,
     'SignatureVersion' => '2',
     'Version'=> '2011-01-01',
 	 'OrderStatus.Status.1'=> 'Unshipped',
	 'OrderStatus.Status.2'=> 'PartiallyShipped',
     'SignatureMethod' => 'HmacSHA256',
     'CreatedAfter'=>$starttime,
     'MarketplaceId.Id.1' => $MARKETPLACE_ID,
    );


 

	$params['Timestamp'] = gmdate("Y-m-d\TH:i:s\Z");
	 $url_parts = array();
	 foreach(array_keys($params) as $key)
     $url_parts[] = $key . "=" . str_replace('%7E', '~', rawurlencode($params[$key]));
	 sort($url_parts);
 

	 $url_string = implode("&", $url_parts);
	 $url_string = trim($url_string, '&');
	 $string_to_sign = "GET" . "\n" .$serviceUrl."\n"."/Orders/2011-01-01"."\n" . $url_string;
	 

 
 	 $signature = hash_hmac("sha256", $string_to_sign, $AWS_SECRET_ACCESS_KEY, TRUE);
 

 	 $signature = base64_encode(hash_hmac("sha256", $string_to_sign, $AWS_SECRET_ACCESS_KEY, True));
 	 $signature = str_replace("%7E", "~", rawurlencode($signature));
 

	 $url = 'https://'.$serviceUrl.'/Orders/2011-01-01?' . $url_string . '&Signature=' . $signature;
	 
	 $img  =  readfile($url);

echo $img;




die('ff');

	 

	 echo $url;
	 
	$opts = array(
	'http'=>array(
	'method'=>'GET',
	'timeout'=>6, //设置超时，单位是秒，可以试0.1之类的float类型数字
	)
	);
	
	
	
	
	$context = stream_context_create($opts);
	 
	 
	 
	if(($info = file_get_contents($url,false,$context))=== false){
		
			$info		= 1;
	
	}
	 return $info;
	 
 }
 

	/* 同步订单明细数据。 */
 function amazon_xml_detal($serviceUrl,$starttime,$AWS_ACCESS_KEY_ID,$MERCHANT_ID,$MARKETPLACE_ID,$AWS_SECRET_ACCESS_KEY,$AmazonOrderId) {
 
	$params = array(
     'AWSAccessKeyId' => $AWS_ACCESS_KEY_ID,
     'Action' => 'ListOrderItems',
     'SellerId' => $MERCHANT_ID,
 	 'MaxResultsPerPage' => 30,
     'SignatureVersion' => '2',
     'Version'=> '2011-01-01',
     'SignatureMethod' => 'HmacSHA256',
     'AmazonOrderId'=>$AmazonOrderId,
    );


 

	$params['Timestamp'] = gmdate("Y-m-d\TH:i:s\Z");
	 $url_parts = array();
	 foreach(array_keys($params) as $key)
     $url_parts[] = $key . "=" . str_replace('%7E', '~', rawurlencode($params[$key]));
	 sort($url_parts);
 

	 $url_string = implode("&", $url_parts);
	 $url_string = trim($url_string, '&');
	 $string_to_sign = "GET" . "\n" .$serviceUrl."\n"."/Orders/2011-01-01"."\n" . $url_string;
	 

 
 	 $signature = hash_hmac("sha256", $string_to_sign, $AWS_SECRET_ACCESS_KEY, TRUE);
 

 	 $signature = base64_encode(hash_hmac("sha256", $string_to_sign, $AWS_SECRET_ACCESS_KEY, True));
 	 $signature = str_replace("%7E", "~", rawurlencode($signature));
 

	 $url = 'https://'.$serviceUrl.'/Orders/2011-01-01?' . $url_string . '&Signature=' . $signature;
	 
	 
	 
echo $url;

	 
	$opts = array(
	'http'=>array(
	'method'=>'GET',
	'timeout'=>6, //设置超时，单位是秒，可以试0.1之类的float类型数字
	)
	);
	$context = stream_context_create($opts);
	 
	 
	 
	if(($info = file_get_contents($url,false,$context))=== false){
		
			$info		= 1;
	
	}
	 return $info;
	 
 }
	
	

function getContent($url, $method = 'GET', $postData = array()) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; U; Linux i686; zh-CN; rv:1.9.1.2) Gecko/20120829 Firefox/3.5.2 GTB5');
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_REFERER, $url);
        $content = curl_exec($curl);

        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpCode == 200) {
                $content = mb_convert_encoding($content, "UTF-8", "GBK");
        }
         return $content;
        
    }
?>
