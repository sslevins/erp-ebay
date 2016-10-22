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
		
		
		
		
		$AWS_ACCESS_KEY_ID		= $ss[$i]['AWS_ACCESS_KEY_ID'];
		$AWS_SECRET_ACCESS_KEY	= $ss[$i]['AWS_SECRET_ACCESS_KEY'];
		$MERCHANT_ID			= $ss[$i]['MERCHANT_ID'];
		$MARKETPLACE_ID			= $ss[$i]['MARKETPLACE_ID'];
		$serviceUrl				= $ss[$i]['serviceUrl'];
		$serviceUrl				= str_replace('https://','',$serviceUrl);
		
		$responseXml					= amazon_xml($serviceUrl,$starttime,$AWS_ACCESS_KEY_ID,$MERCHANT_ID,$MARKETPLACE_ID,$AWS_SECRET_ACCESS_KEY);
		$data=XML_unserialize($responseXml); 
		$Trans	 						= $data['ListOrdersResponse']['ListOrdersResult']['Orders'];  
		print_r($data).'cccccccccccc';

		
	}
	
	
	
	
	
	
	/* 同步订单数据。 */
 function amazon_xml($serviceUrl,$starttime,$AWS_ACCESS_KEY_ID,$MERCHANT_ID,$MARKETPLACE_ID,$AWS_SECRET_ACCESS_KEY) {
 
	$params = array(
     'AWSAccessKeyId' => $AWS_ACCESS_KEY_ID,
     'Action' => 'ListOrders',
     'SellerId' => $MERCHANT_ID,
 	 'MaxResultsPerPage' => 5,
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
	 
	 
	 
	 
$opts = array(
'http'=>array(
'method'=>'GET',
'timeout'=>15, //设置超时，单位是秒，可以试0.1之类的float类型数字
)
);
$context = stream_context_create($opts);

	 $info=file_get_contents($url,false,$context);
	 echo $info;
	 return $info;
	 
 }
 


	
	


?>
