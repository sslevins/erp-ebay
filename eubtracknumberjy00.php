<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EUB</title>
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
				
					jiaoyun($sn);
					
				
					
						
						
					
					
					
					
		}
			
	}

	function jiaoyun($ordersn){
		
		
		global $dbcon,$user;
		
		$ss					= "select * from ebay_order where ebay_ordersn = '$ordersn' ";
		$ss					= $dbcon->execute($ss);
		$ss					= $dbcon->getResultArray($ss);
		$ebay_tracknumber	= $ss[0]['ebay_tracknumber'];
		$ebay_account	    = $ss[0]['ebay_account'];
		$ss				   = "select * from ebay_account where ebay_account='$ebay_account'";
		
	
		
		$ss				  = $dbcon->execute($ss);
		$ss			 	= $dbcon->getResultArray($ss);
		$id				= $ss[0]['id'];
		
		$ss				= "select * from eub_account where pid='$id'";
		
		
		$ss					= $dbcon->execute($ss);
		$ss					= $dbcon->getResultArray($ss);
		$APIDevUserID		= $ss[0]['ebay_account'];
		$APISellerUserID	= $ss[0]['dev_id'];
		$APIPassword		= $ss[0]['dev_sig'];
		
	
		
		
		
		$soapclient = new soapclient("http://shippingapi.ebay.cn/production/v2/orderservice.asmx?wsdl");
		$params		= array(
    	'Version' => "2.0.0",
    	'APIDevUserID' => $APIDevUserID,
    	'APIPassword' => $APIPassword,
    	'APISellerUserID' => $APISellerUserID,
    	'MessageID' => "135625622432",
		'TrackCode' =>$ebay_tracknumber
		
		);
		
	

		
	
		$functions = $soapclient->ConfirmAPACShippingPackage(array("ConfirmAPACShippingPackageRequest"=>$params));
		
		
		
		
		foreach($functions as $aa){
			
			$bb   = (array)$aa;
			
			$ack		= $bb['Ack'];
			
			if($ack     != 'Failure' &&  $ack     != 'Warning'){
				
				
			//	$sql		= "update ebay_order set ebay_status='7' where ebay_ordersn='$ordersn'";
			//	 $dbcon->execute($sql);
				$Label	= $bb['Label'];
				return $Label;
				
				
			}else{
				$Message	= $bb['Message'];
				echo "<br>".$ebay_usermail." EUB交运失败，失败原因是：<font color='#FF0000'>".$Message."</font>";
				
			}
				
			
		}
		
		
		

		
		
	}
	
	
	
	function getshiplabel($ordersn,$tkary){
		
		global $dbcon,$user;
		
		$ss					= "select * from ebay_order where ebay_ordersn = '$ordersn' ";
		$ss					= $dbcon->execute($ss);
		$ss					= $dbcon->getResultArray($ss);
		$ebay_tracknumber	= $ss[0]['ebay_tracknumber'];
		$ebay_account	= $ss[0]['ebay_account'];
		$ss				= "select * from ebay_account where ebay_account='$ebay_account'";
		$ss				= $dbcon->execute($ss);
		$ss				= $dbcon->getResultArray($ss);
		$id				= $ss[0]['id'];
		
		$ss				= "select * from eub_account where pid='$id'";
		
		
		$ss					= $dbcon->execute($ss);
		$ss					= $dbcon->getResultArray($ss);
		$APIDevUserID		= $ss[0]['ebay_account'];
		$APISellerUserID	= $ss[0]['dev_id'];
		$APIPassword		= $ss[0]['dev_sig'];
		
		$TrackCodeList		= array('LK060828240CN','LK060828253CN' );
		$Tk					= array('TrackCode'=>$TrackCodeList);
		
		
		
		$soapclient = new soapclient("http://shippingapi.ebay.cn/production/v2/orderservice.asmx?wsdl");
		$params		= array(
    	'Version' => "2.0.0",
    	'APIDevUserID' => $APIDevUserID,
    	'APIPassword' => $APIPassword,
    	'APISellerUserID' => $APISellerUserID,
    	'MessageID' => "135625622432",
		'TrackCodeList' =>$tkary,
		'PageSize' => 0
		);
		
	
		
	
	
		$functions = $soapclient->GetAPACShippingLabels(array("GetAPACShippingLabelRequest"=>$params));
		
		
		
		foreach($functions as $aa){
			
			$bb   = (array)$aa;
			
			$ack		= $bb['Ack'];
			
			if($ack     != 'Failure'){
				
				
				$Label	= $bb['Label'];
				return $Label;
			}else{
				$Message	= $bb['Message'];
				echo "<br>".$ebay_usermail." EUB订单标签取得失败，失败原因是：<font color='#FF0000'>".$Message."</font>";
				
			}
				
			
		}
		
		
	}
	
	
	
	function eubtracknumber($ordersn){
	
	
		global $dbcon,$user;
		
		$ss			= "select * from ebay_order where ebay_ordersn = '$ordersn' ";
		$ss				= $dbcon->execute($ss);
		$ss				= $dbcon->getResultArray($ss);
		$ebay_account	= $ss[0]['ebay_account'];
		$ebay_username	= $ss[0]['ebay_username'];
		$ebay_usermail	= $ss[0]['ebay_usermail'];
		$ebay_phone		= $ss[0]['ebay_phone'];
		$ebay_street	= $ss[0]['ebay_street']." ".$ss[0]['ebay_street1'];
		$ebay_city		= $ss[0]['ebay_city'];
		$ebay_state		= $ss[0]['ebay_state'];
		$ebay_postcode	= $ss[0]['ebay_postcode'];
		$ebay_countryname	= $ss[0]['ebay_countryname'];
		$ebay_couny		= $ss[0]['ebay_couny'];
		$ebay_currency		= $ss[0]['ebay_currency'];
		$ebay_userid		= $ss[0]['ebay_userid'];
		$ebay_note			= $ss[0]['ebay_note'];
		$ebay_tid			= $ss[0]['ebay_tid']?$ss[0]['ebay_tid']:0;
		$ebay_noteb			= $ss[0]['ebay_noteb'];
		$recordnumber		= $ss[0]['recordnumber'];
		$ebay_total			= $ss[0]['ebay_total'];
		$ebay_paidtime		= date('Y-m-d',$ss[0]['ebay_paidtime'])."T".date('H:i:s',$ss[0]['ebay_paidtime']);
		$ebay_createdtime	= date('Y-m-d',$ss[0]['ebay_createdtime'])."T".date('H:i:s',$ss[0]['ebay_createdtime']);
		
		
		
		
		$ss				= "select * from ebay_account where ebay_account='$ebay_account'";
		$ss				= $dbcon->execute($ss);
		$ss				= $dbcon->getResultArray($ss);
		$id				= $ss[0]['id'];
		
		$ss				= "select * from eub_account where pid='$id'";
		
		
		$ss					= $dbcon->execute($ss);
		$ss					= $dbcon->getResultArray($ss);
		$APIDevUserID		= $ss[0]['ebay_account'];
		$APISellerUserID	= $ss[0]['dev_id'];
		$APIPassword		= $ss[0]['dev_sig'];
		
		$pname					= $ss[0]['pname'];
		$pcompany				= $ss[0]['pcompany'];
		$pcountry				= $ss[0]['pcountry'];
		$pprovince				= $ss[0]['pprovince'];
		$pcity					= $ss[0]['pcity'];
		$pdis					= $ss[0]['pdis'];
		$pstreet				= $ss[0]['pstreet'];
		$pzip					= $ss[0]['pzip'];
		$ptel					= $ss[0]['ptel'];
		$pte1					= $ss[0]['pte1'];
		$pemail					= $ss[0]['pemail'];
		
		
		
		$ShipToAddress		= array(
			'Email' => $ebay_usermail,
			'Company' => '',
			'Contact' => $ebay_username,
			'Phone' => $ebay_phone,
			'Street' => $ebay_street,
			'City' => $ebay_city,
			'Province' => $ebay_state,
			'Postcode' => $ebay_postcode,  
			'Country' => $ebay_countryname,  
			'CountryCode' => 'US'
		);
		
		
		
		$PickUpAddress		= array(
		'Contact' => $pname,
		'Company' => $pcompany,
		'Street' => $pstreet,
		'District' => "320113",
		'City' => "320100",
		'Province' => '320000',
		'Postcode' => $pzip,
		'Country' => $pcountry,  
		'Email' => $pemail,  
		'Mobile' => $ptel,
		'Phone' => $pte1
		
		);
		
		
		$dname					= $ss[0]['dname'];
		$dcompany				= $ss[0]['dcompany'];
		$dcountry				= $ss[0]['dcountry'];
		$dprovince				= $ss[0]['dprovince'];
		$dcity					= $ss[0]['dcity'];
		$ddis					= $ss[0]['ddis'];
		$dstreet				= $ss[0]['dstreet'];
		$dzip					= $ss[0]['dzip'];
		$dtel					= $ss[0]['dtel'];
		$demail					= $ss[0]['demail'];
		$shiptype				= $ss[0]['shiptype'];
		
		
		/* ShipFromAddress */
		$ShipFromAddress		= array(
		 "Contact" => $dname,
		 "Company" => $dcompany,
		 "Street"  => $dstreet,
		 "District" => $ddis,
		 "City" => $dcity,
		 "Province" => $dprovince,
		 "Postcode" => $dzip,
		 "Country" => $dcountry,
		 "Email" => $demail,
		 "Mobile" => $dtel,	
		);
		
		$skums		= array(
	
		'SKUID' => "sdfsdfsdf",
		'Weight' => "0.1",
		'CustomsTitleCN' => "sdfsdfsdf",
		'CustomsTitleEN' => "sdfsdfsdf",
		'DeclaredValue' => "1.0000",
		'OriginCountryName' => "China",
		'OriginCountryCode' => "CN",
	
		);
	
		
		$ss			= "select * from  ebay_orderdetail where ebay_ordersn = '$ordersn'";
		$ss			= $dbcon->execute($ss);
		$ss			= $dbcon->getResultArray($ss);
		for($i=0;$i<count($ss);$i++){
		
		$ebay_itemid		= $ss[$i]['ebay_itemid'];
		$ebay_itemtitle		= $ss[$i]['ebay_itemtitle'];
		$ebay_amount		= $ss[$i]['ebay_amount'];
		$recordnumber1		= $ss[$i]['recordnumber'];
		$ebay_itemprice		= $ss[$i]['ebay_itemprice'];
		$sku				= $ss[$i]['sku'];
		
		$si		= "select * from ebay_goods where ebay_user = '$user' and goods_sn='$sku'";
	
		
		$si			= $dbcon->execute($si);
		$si			= $dbcon->getResultArray($si);
		
		
		$weight		= $si[0]['goods_weight']?$si[0]['goods_weight']:0.1;
		
		
		$item[$i]		= array(
		'CurrencyCode' => $ebay_currency,
		'EBayEmail' => $ebay_usermail,
		'EBayBuyerID' => $ebay_userid,
		'EBayItemID' => $ebay_itemid,
		'EBayItemTitle' => $ebay_itemtitle,
		'EBayMessage' => $ebay_note,
		'EBaySiteID' => "0",
		'EBayTransactionID' => $ebay_tid,  
		'Note' => $ebay_noteb,  
		'OrderSalesRecordNumber' => $recordnumber,
		'PaymentDate' => $ebay_paidtime,
		'PayPalEmail' => "0",
		'PayPalMessage' => $ebay_note,
		'PostedQTY' => $ebay_amount,
		'ReceivedAmount' => $ebay_total,
		'SalesRecordNumber' => $recordnumber1,
		'SoldDate'			=> $ebay_createdtime,
		'SoldPrice'			=> $ebay_itemprice,
		'SoldQTY' 			=> $ebay_amount,
		'SKU'				=>array(
	
		'SKUID' => $sku,
		'Weight' => $weight,
		'CustomsTitleCN' => $ebay_itemtitle,
		'CustomsTitleEN' => $ebay_itemtitle,
		'DeclaredValue' => "1.0000",
		'OriginCountryName' => "China",
		'OriginCountryCode' => "CN",
		)
		);
		
		
		
		}
		
		
		
	
	
		
		

		
		
		
		
		$soapclient = new soapclient("http://shippingapi.ebay.cn/production/v2/orderservice.asmx?wsdl");
		$params		= array(
    	'Version' => "2.0.0",
    	'APIDevUserID' => $APIDevUserID,
    	'APIPassword' => $APIPassword,
    	'APISellerUserID' => $APISellerUserID,
    	'MessageID' => "135625622432",
		"OrderDetail"=> array("PickUpAddress"=>$PickUpAddress,"ShipFromAddress"=>$ShipFromAddress,"ShipToAddress"=>$ShipToAddress,"ItemList"=>array("Item"=>$item),"EMSPickUpType"=>0));
		
		
	
	
		$functions = $soapclient->AddAPACShippingPackage(array("AddAPACShippingPackageRequest"=>$params));
	
		
		foreach($functions as $aa){
			
			$bb   = (array)$aa;
			
			$ack		= $bb['Ack'];
			
			if($ack     != 'Failure'){
				
				
				$TrackCode	= $bb['TrackCode'];
				
				$sg			= "update ebay_order set ebay_tracknumber='$TrackCode', ebay_carrier='EUB' where ebay_ordersn = '$ordersn'";
				//echo $sg;
				$dbcon->execute($sg);
				echo "<br>".$ebay_usermail." EUB订单上传成功";
				
				
				
			}else{
				
				$Message	= $bb['Message'];
				echo "<br>".$ebay_usermail." EUB订单上传失败，失败原因是：<font color='#FF0000'>".$Message."</font>";
				
			}
			
		
			
				
			
		}
		
	
	
	
	
	
	
	}
	
	











?>



</body>
</html>
