<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>
<body>
<?PHP

	include "include/config.php";


	$label	= '';
	$orders		= explode(",",$_REQUEST['bill']);
	
	$tkary		= array();
	$i = 0;
	for($g=0;$g<count($orders);$g++){
		$sn 	=  $orders[$g];
		if($sn != ""){
			
			$sql	= "select * from ebay_order as a where ebay_id='$sn' ";			
			$sql	= $dbcon->execute($sql);
			$sql	= $dbcon->getResultArray($sql);
			$ebay_ordersn				= $sql[0]['ebay_ordersn'];
			$ebay_carrier				= $sql[0]['ebay_carrier'];
			$ebay_orderid				= $sql[0]['ebay_orderid'];
			$ebay_username				= $sql[0]['ebay_username'];
			$ToAddress1					= $sql[0]['ebay_street'];
			$ToAddress2					= $sql[0]['ebay_street1'];
			
			
			
			$mm						= explode(' ',$ToAddress1);
			$mmr					= count($mm);
			$doornumber				= $mm[$mmr-1];
			$m = substr($doornumber,0,1);
			if(!intval($m)){
				$doornumber = explode('.',$doornumber);
				$doornumber	= $doornumber[1];
			}
		
		
		
			$ebay_state					= $sql[0]['ebay_state'];
			$ebay_postcode				= $sql[0]['ebay_postcode'];
			$ebay_phone					= $sql[0]['ebay_phone'];
			$ebay_city					= $sql[0]['ebay_city'];
			$ebay_usermail				= $sql[0]['ebay_usermail'];
			$ebay_countryname			= $sql[0]['ebay_countryname'];
			$ebay_id					= $sql[0]['ebay_id'];
			
			if($ebay_countryname == 'Deutschland') $ebay_countryname ='Germany';
			if($ebay_countryname == 'France') $ebay_countryname ='FR';
			if($ebay_countryname == 'FRANCE MéTROPOLITAINE') $ebay_countryname ='FR';
			
			//	if($ebay_countryname == 'GB') $ebay_countryname ='United Kiongdom';
			
			
			
			$credentials = "$bluserame:$blpassword";  //帐号：密码
$request_json='{
  "ContractId": 1,
  "OrderNumber": "'.$ebay_id.'",
  "RecipientName": "'.$ebay_username.'",
  "RecipientStreet": "'.$ToAddress1.$ToAddress2.'",
  "RecipientHouseNumber": "'.$doornumber.'",
  "RecipientBusnumber": "sample string 8",
  "RecipientZipCode": "'.$ebay_postcode.'",
  "RecipientCity": "'.$ebay_city.'",
  "RecipientState": "'.$ebay_state.'",
  "RecipientCountry": "'.strtoupper($ebay_countryname).'",
  "PhoneNumber": "'.$ebay_phone.'",
  "Email": "'.$ebay_usermail.'",
  "SenderName": "sample string 15",
  "SenderAddress": "sample string 16",
  "SenderSequence": "1",
  "Customs": [
    
  ';
 
		 
				 $cc			= "select (ebay_amount*ebay_itemprice) as cc  from ebay_orderdetail as a where a.ebay_ordersn='$ebay_ordersn' limit 1 ";
				 $cc			= $dbcon->execute($cc);
				 $cc			= $dbcon->getResultArray($cc);
				 
				 
				 $cctotal		= $cc[0]['cc'];
				 $isyes = 0;
				 if($cctotal >=22) $isyes = 1;
				 
	
		
				 $ee			= "select ebay_amount,sku,recordnumber,ebay_itemtitle,ebay_itemprice from ebay_orderdetail as a where a.ebay_ordersn='$ebay_ordersn'";
				 $ee			= $dbcon->execute($ee);
				 $ee			= $dbcon->getResultArray($ee);
				 
				 
				 
				  /* 计算总价 */
				 

				 
				 
				 
				 $cusomstr		= '';
				 
				 foreach($ee as $key=>$val){
					 
					 
					 
					 $ebay_itemtitle				= $val['ebay_itemtitle'];
					  $ebay_itemprice				= $val['ebay_itemprice'];
					 
					  $ebay_itemtitle				= str_replace('-','',$val['ebay_itemtitle']);
					  					  $ebay_itemtitle				= str_replace('"','',$val['ebay_itemtitle']);

					  
					 $ebay_amount				= $val['ebay_amount'];
					 $sku						= $val['sku'];
					 $recordnumber				= $val['recordnumber'];
					
					$rr			= "select goods_sncombine from ebay_productscombine where ebay_user='$user' and goods_sn='$sku'";
					$rr			= $dbcon->execute($rr);
					$rr 	 	= $dbcon->getResultArray($rr);
					
			
						
					if(count($rr) > 0){
						
						
						
						
						$goods_sncombine	= $rr[0]['goods_sncombine'];
									$goods_sncombine    = explode(',',$goods_sncombine);	
					
									//print_r($goods_sncombine);
									//echo count($goods_sncombine);
									for($v=0;$v<count($goods_sncombine);$v++){
						
						
											$pline			= explode('*',$goods_sncombine[$v]);
											//print_r($pline);
											$goods_sn		= $pline[0];
											//echo $goods_sn;
											$goddscount     = $pline[1] * $ebay_amount;
											$totalqty		= $totalqty + $goddscount;
											$uu			= "SELECT * FROM ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
											
								
											
								  			 $uu			= $dbcon->execute($uu);
											 $uu 	 	= $dbcon->getResultArray($uu);
											 
									
												  
												  
												  
												    $goods_zysbmc		= $uu[0]['goods_zysbmc']?$uu[0]['goods_zysbmc']:"None";
					  $goods_weight		= $uu[0]['goods_weight']?$uu[0]['goods_weight']*1000:1;
					  $goods_sbjz		= $uu[0]['goods_sbjz']?$uu[0]['goods_sbjz']:1;
					  $goods_name		= $uu[0]['goods_name'];
					  
					   $goods_sbjz		= $goods_sbjz;
					  
											 
					 $cusomstr .='{
      "Sku": "'.$goods_sn.'",
      "ChineseContentDescription": "'.$goods_zysbmc.'",
      "ItemContent": "'.$ebay_itemtitle.'",
      "ItemCount": '.$goddscount.',
      "Value": '.$goods_sbjz.',
      "Currency": "USD",
      "Weight": '.ceil($goods_weight).',
      "SkuInInvoice": "'.$goods_sn.'"
    },';
	
											 
											 
									}
									
						
						
					}else{
						
						  $uu			= "select * from ebay_goods where goods_sn='$sku'";
					  $uu			= $dbcon->execute($uu);
				 	  $uu			= $dbcon->getResultArray($uu);
					  $tqty							+= $ebay_amount;
					  $goods_zysbmc		= $uu[0]['goods_zysbmc']?$uu[0]['goods_zysbmc']:"None";
					  $goods_weight		= $uu[0]['goods_weight']?$uu[0]['goods_weight']*1000:1;
					  $goods_sbjz		= $uu[0]['goods_sbjz']?$uu[0]['goods_sbjz']:1;
					  $goods_name		= $uu[0]['goods_name'];
					  
					  
					  
					  
					  if($isyes == 1){
									
									 $goods_sbjz = 21.99/$ebay_amount;
									
									 
									 
								}else{
									
									 $goods_sbjz		= $goods_sbjz;
	
								}
											 
								
											 
					  
					  
					  $goods_location		= $uu[0]['goods_location'];
						
					 $cusomstr .='{
      "Sku": "'.$sku.'",
      "ChineseContentDescription": "'.$goods_zysbmc.'",
      "ItemContent": "'.$ebay_itemtitle.'",
      "ItemCount": '.$ebay_amount.',
      "Value": '.$goods_sbjz.',
      "Currency": "USD",
      "Weight": '.ceil($goods_weight).',
      "SkuInInvoice": "'.$goods_sn.'"
    },';
	
						
						
					}
					
					
				 }
				 
				 
				 $cusomstr		= substr($cusomstr,0,strlen($cusomstr) -1 );
				 
				  $request_json .= $cusomstr;	
	$request_json .= ']}';	

		
echo $request_json;




$url = "http://42.120.16.51/api/LvsParcels";
$page = "/api/LvsParcels";
$headers = array(
		//"POST ".$page." HTTP/1.0",
		"Content-type: text/json;charset=\"utf-8\"",
		"Accept: text/json",
		"Cache-Control: no-cache",
		"Pragma: no-cache",
		"SOAPAction: \"run\"",
		"Content-length: ".strlen($request_json),
		"Authorization: Basic " . base64_encode($credentials)////帐号：密码
);
 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $request_json);

$data = curl_exec($ch);

if (curl_errno($ch)) {
	print "Error: " . curl_error($ch);
} 
curl_close($ch);

$data = json_decode($data,true);
print_r($data);


$ProductBarcode			= $data['ProductBarcode'];


if($ProductBarcode != '' ){
	
	echo '订单编号:'.$ebay_id.'成功申请跟踪号, 跟踪号为: '.$ProductBarcode.'<br>';
	$sg			= "update ebay_order set ebay_tracknumber='$ProductBarcode'  where ebay_id = '$ebay_id' and ebay_user ='$user'";
				$dbcon->execute($sg);
}else{
	
	
	
	echo '订单编号:'.print_r($data).'<br>';
		
	
	
}

			
		}
	}
	




	?>

