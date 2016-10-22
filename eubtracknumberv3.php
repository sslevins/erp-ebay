<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EUB</title>
</head>

<body>

<?PHP

	include "include/config.php";
	

	error_reporting(E_ALL);
	
	$label	= '';
	$orders		= explode(",",$_REQUEST['bill']);
	
	$tkary		= array();
	$i = 0;
	
	for($g=0;$g<count($orders);$g++){
		$sn 	=  $orders[$g];
		if($sn != ""){
					eubtracknumber($sn);
		}
	}
	echo "<script>alert('程序运行结束')</script>";
	
	function eubtracknumber($ordersn){
	
	
		global $dbcon,$user;
		
		$ss			= "select * from ebay_order where ebay_id = '$ordersn' and ebay_user ='$user'  ";
		$ss				= $dbcon->execute($ss);
		$ss				= $dbcon->getResultArray($ss);
		$ebay_account	= $ss[0]['ebay_account'];
		$ebay_username	= $ss[0]['ebay_username'];
		$ebay_usermail	= $ss[0]['ebay_usermail'];
		
		
		if($ebay_usermail == '' || $ebay_usermail == 'Invalid Request') $ebay_usermail = 'a@a.com';
		
		$ebay_phone		= $ss[0]['ebay_phone'];
		$ebay_street	= $ss[0]['ebay_street']." ".$ss[0]['ebay_street1'];
		$ebay_city		= $ss[0]['ebay_city'];
		$ebay_state		= $ss[0]['ebay_state']?$ss[0]['ebay_state']:'.';
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
		$ebay_ordersn			= $ss[0]['ebay_ordersn'];
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
		
		/* return address */
		$rname			 		  = $ss[0]['rname'];	
		$rcompany			 	  = $ss[0]['rcompany'];	
		$rcountry			 	  = $ss[0]['rcountry'];	
		$rprovince			 	  = $ss[0]['rprovince'];	
		$rdis			 	  	  = $ss[0]['rdis'];	
		$rstreet			 	  = $ss[0]['rstreet'];	
		$rcity			 	 	  = $ss[0]['rcity'];	
		
		$ReturnAddress		= array(
			'Contact' => $rname,
			'Company' => $rcompany,
			'Street' => $rstreet,
			'District' => $rdis,
			'City' => $rcity,
			'Province' => $rprovince,
			'Postcode' => $pzip,
			'Country' => '中国',

		);
		
		
		
		
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
			'CountryCode' => $ebay_couny
		);
		
		
		
		$PickUpAddress		= array(
		'Contact' => $pname,
		'Company' => $pcompany,
		'Street' => $pstreet,
		'District' => $pdis,
		'City' => $pcity,
		'Province' => $pprovince,
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
	
		
		$ss			= "select * from  ebay_orderdetail where ebay_ordersn = '$ebay_ordersn'";
		$ss			= $dbcon->execute($ss);
		$ss			= $dbcon->getResultArray($ss);
		for($i=0;$i<count($ss);$i++){
		
		$ebay_itemid		= $ss[$i]['ebay_itemid'];
		$ebay_itemtitle		= $ss[$i]['ebay_itemtitle'];
		$ebay_amount		= $ss[$i]['ebay_amount'];
		$recordnumber1		= $ss[$i]['recordnumber'];
		$ebay_itemprice		= $ss[$i]['ebay_itemprice'];
		$sku				= $ss[$i]['sku'];
		$ebay_tid				= $ss[$i]['ebay_tid']? $ss[$i]['ebay_tid']:0;

		
		/*
		$si		= "select * from ebay_goods where ebay_user = '$user' and goods_sn='$sku'";
		$si			= $dbcon->execute($si);
		$si			= $dbcon->getResultArray($si);
		
		
		$weight		= $si[0]['goods_weight']?$si[0]['goods_weight']:0.1;
		$goods_ywsbmc		= $si[0]['goods_ywsbmc']?$si[0]['goods_ywsbmc']:$ebay_itemtitle;
		$goods_zysbmc		= $si[0]['goods_zysbmc']?$si[0]['goods_zysbmc']:$ebay_itemtitle;
		$goods_sbjz			= $si[0]['goods_sbjz']?$si[0]['goods_sbjz']:1;
		
		*/
		
		
		$si		= "select * from ebay_goods where ebay_user = '$user' and goods_sn='$sku'";
		$si			= $dbcon->execute($si);
		$si			= $dbcon->getResultArray($si);
		
		if(count($si) > 0){
		$weight		= $si[0]['goods_weight']?$si[0]['goods_weight']:0.1;
		
		$weight		= $weight * $ebay_amount;
		
		$goods_ywsbmc		= $si[0]['goods_ywsbmc']?$si[0]['goods_ywsbmc']:$ebay_itemtitle;
		$goods_zysbmc		= $si[0]['goods_zysbmc']?$si[0]['goods_zysbmc']:$ebay_itemtitle;
		
		if($user == 'vipyisi') $goods_zysbmc =$si[0]['goods_name'];
		
		$goods_sbjz			= $si[0]['goods_sbjz']?$si[0]['goods_sbjz']:1;
		$goods_location		= $si[0]['goods_location'];
		if($user == 'chineon') $sku .= $si[0]['goods_note'];
		
		if($user == 'survy') $sku .= ' ['.$goods_location.']';
		
		
		
		}else{
			$rr			= "select * from ebay_productscombine where ebay_user='$user' and goods_sn='$sku'";
			$rr			= $dbcon->execute($rr);
			$rr 	 	= $dbcon->getResultArray($rr);

			
			if(count($rr) > 0){
				$goods_sbjz = 0;
				$weight  = 0;
				if($user == 'chineon') $sku = '';
				$goods_sncombine	= $rr[0]['goods_sncombine'];
				$notes				= $rr[0]['notes'];
				$goods_sncombine    = explode(',',$goods_sncombine);	
				for($z=0;$z<count($goods_sncombine);$z++){
					$pline			= explode('*',$goods_sncombine[$z]);
					$goods_sn		= $pline[0];
					$goddscount     = $pline[1]  * $ebay_amount;
					$ee			= "SELECT * FROM ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
					$ee			= $dbcon->execute($ee);
					$si 	 	= $dbcon->getResultArray($ee);
					$weights		= $si[0]['goods_weight']?$si[0]['goods_weight']:0.01;

					if($user =='survy') $weights = 0.01;

					$weight += ($weights*$goddscount);
					$goods_ywsbmc		= $si[0]['goods_ywsbmc']?$si[0]['goods_ywsbmc']:$ebay_itemtitle;
					$goods_zysbmc		= $si[0]['goods_zysbmc']?$si[0]['goods_zysbmc']:$ebay_itemtitle;
					$goods_location			= $si[0]['goods_location'];
					$sbjz			= $si[0]['goods_sbjz']?$si[0]['goods_sbjz']:1;
					$goods_sbjz += ($sbjz*$goddscount);
					if($goods_sn != '' ) $sku .= $goods_sn.'*'.$goddscount.'['.$goods_location.']';
					if($user == 'chineon') $sku .= $notes;
					
					if($user == 'survy' || $user == 'vip297' ) $sku .= ' ['.$goods_location.']';
					
					
				}
			}else{
				$weight		= $si[0]['goods_weight']?$si[0]['goods_weight']:0.01;
				$goods_ywsbmc		= $si[0]['goods_ywsbmc']?$si[0]['goods_ywsbmc']:$ebay_itemtitle;
				$goods_zysbmc		= $si[0]['goods_zysbmc']?$si[0]['goods_zysbmc']:$ebay_itemtitle;
				$goods_sbjz			= $si[0]['goods_sbjz']?$si[0]['goods_sbjz']:1;
				$goods_location		= $si[0]['goods_location'];
				if($user =='survy') $weight = 0.001;

				
				if($user == 'survy' || $user == 'vip297' ) $sku .= ' ['.$goods_location.']';
				
					
					
			}
		}
		
		if($user == 'vipcz') $goods_ywsbmc .= $recordnumber;

		if($user == 'pete' && $ss[$i]['sku'] == '' ){
		$weight		= '0.1';
		$goods_ywsbmc = 'TOY';
		$goods_zysbmc = '玩具 ';
		$goods_sbjz   = '7';
		}
		
		
		
		if($user == 'survy'){
		$weight		= '0.01';
		//$goods_ywsbmc = 'Electronics ';
$goods_ywsbmc   = substr($ebay_itemtitle,0,10);

		$goods_zysbmc = '电子元器件 ';
		$goods_sbjz   = '1';
		}
		
		
		
		
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
	
		'SKUID' => $ss[$i]['sku'],
		'Weight' => $weight ,
		'CustomsTitleCN' => $goods_zysbmc,
		'CustomsTitleEN' => $goods_ywsbmc.' '.$sku,
		'DeclaredValue' => $goods_sbjz*$ebay_amount,
		'OriginCountryName' => "China",
		'OriginCountryCode' => "CN",
		)
		);
		
		
		
		}
		
		
		
	
	

		$soapclient = new soapclient("orderservice.asmx");
		$params		= array(
    	'Version' => "3.0.0",
    	'APIDevUserID' => $APIDevUserID,
    	'APIPassword' => $APIPassword,
    	'APISellerUserID' => $APISellerUserID,
    	'MessageID' => "135625622432",
		"OrderDetail"=> array("PickUpAddress"=>$PickUpAddress,"ShipFromAddress"=>$ShipFromAddress,"ShipToAddress"=>$ShipToAddress,"ItemList"=>array("Item"=>$item),"EMSPickUpType"=>$shiptype,"ReturnAddress"=>$ReturnAddress));







		
		$functions = $soapclient->AddAPACShippingPackage(array("AddAPACShippingPackageRequest"=>$params));
		

		
		foreach($functions as $aa){
			
			$bb   = (array)$aa;
			
			$ack		= $bb['Ack'];
			
			if($ack     != 'Failure'){
				
				
				$TrackCode	= $bb['TrackCode'];
				
				$sg			= "update ebay_order set ebay_tracknumber='$TrackCode' where ebay_id = '$ordersn'";
				$dbcon->execute($sg);
				echo "<br>订单编号".$ordersn." EUB订单上传成功";
				
			}else{
				$Message	= $bb['Message'];
				echo "<br>订单编号:".$ordersn." EUB订单上传失败，失败原因是：<font color='#FF0000'>".$Message."</font>";
			}
		}
		
		echo 'ccccc';
		
	}
	
	











?>



</body>
</html>
