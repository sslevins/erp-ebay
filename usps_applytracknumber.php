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
	


	$strGetLabelURL = "https://labelserver.endicia.com/LabelService/EwsLabelService.asmx/GetPostageLabelXML";



	for($g=0;$g<count($orders);$g++){
		$sn 	=  $orders[$g];
		if($sn != ""){
			


			$sql	= "select * from ebay_order as a where ebay_id='$sn' ";			
			$sql	= $dbcon->execute($sql);
			$sql	= $dbcon->getResultArray($sql);
			
			
			
			

			
			$ebay_ordersn			= $sql[0]['ebay_ordersn'];
			$ebay_carrier			= $sql[0]['ebay_carrier'];
			
			
			if($ebay_carrier == '' ) $ebay_carrier = 'first';
			
			$ebay_username			= $sql[0]['ebay_username'];
			$ToAddress1				= $sql[0]['ebay_street'];
			$ToAddress2				= $sql[0]['ebay_street1'];


			$ebay_state				= $sql[0]['ebay_state'];
			$ebay_postcode			= $sql[0]['ebay_postcode'];
			$ebay_phone				= $sql[0]['ebay_phone'];
			$ebay_city				= $sql[0]['ebay_city'];


			$sql	= "select sku,ebay_amount from ebay_orderdetail as a where a.ebay_ordersn='$ebay_ordersn' ";
			$sql	= $dbcon->execute($sql);
			$sql	= $dbcon->getResultArray($sql);

			$linestr	= '';
			$weight		= 0;
			for($j=0;$j<count($sql);$j++){
				
				$sku				= $sql[$j]['sku'];
				$ebay_amount		= $sql[$j]['ebay_amount'];
				$linestr			= $sku.' * '.$ebay_amount.', ';


				$si		= "select * from ebay_goods where ebay_user = '$user' and goods_sn='$sku'";
				$si			= $dbcon->execute($si);
				$si			= $dbcon->getResultArray($si);		
				$weight		= $si[0]['goods_weight']?$si[0]['goods_weight']:0.1;
				$weight		+= $weight * $ebay_amount;



			}


			$weight		= number_format($weight,2);








			$request = '
			<LabelRequest ImageFormat="GIF" Test="YES" LabelType="Default" LabelSize="4x6">
			<RequesterID>abcd</RequesterID>
			<AccountID>793929</AccountID>
			<PassPhrase>abcabc123456</PassPhrase>
			<PartnerTransactionID>abcabc123456</PartnerTransactionID>
			<MailClass>'.$ebay_carrier.'</MailClass>
			<ContentsType>Gift</ContentsType>
			<DateAdvance>0</DateAdvance>
			<WeightOz>'.$weight.'</WeightOz>
			<Stealth>FALSE</Stealth>
			<Services InsuredMail="OFF" SignatureConfirmation="OFF" />
			<Value>0</Value>
			<RubberStamp1>'.$linestr.'</RubberStamp1>
			<ToName>'.$ebay_username.'</ToName>
			<ToCompany>'.$ebay_username.'</ToCompany>
			<ToAddress1>'.$ToAddress1.'</ToAddress1>.
			<ToAddress1>'.$ToAddress2.'</ToAddress1>
			<ToCity>'.$ebay_city.'</ToCity>
			<ToState>'.$ebay_state.'</ToState>
			<ToPostalCode>'.$ebay_postcode.'</ToPostalCode>
			<ToPhone>'.$ebay_phone.'</ToPhone>
			<FromName>huawei yang</FromName>
			<FromCompany>flyworld LLC</FromCompany>
			<ReturnAddress1>60 Dane St.</ReturnAddress1>
			<FromCity>Sayreville</FromCity>
			<FromState>New Jersey</FromState>
			<FromPostalCode>08872</FromPostalCode>
			<FromZIP4>1104</FromZIP4>
			<FromPhone>9176176858</FromPhone>
			</LabelRequest>';


			echo $request;




			$params = array('http' => array(
							  'method' => 'POST',
			'content' => 'labelRequestXML='.$request,
			'header' => 'Content-Type: application/x-www-form-urlencoded'));
			$ctx = stream_context_create($params);
			$fp = fopen($strGetLabelURL, 'rb', false, $ctx);
			if (!$fp) {
			print "Problem with $strGetLabelURL";
			}
			$response = stream_get_contents($fp);
			if ($response === false) {
			print "Problem reading data from $url, $php_errormsg";
			}
			$data	= XML_unserialize($response);
			$TrackingNumber		= $data['LabelRequestResponse']['TrackingNumber'];
			$FinalPostage		= $data['LabelRequestResponse']['FinalPostage'];


			if($TrackingNumber != ''){

			$file= $TrackingNumber.'.JPG';
			$Base64LabelImage			= base64_decode($data['LabelRequestResponse']['Base64LabelImage']);
			file_put_contents("images/".$file,$Base64LabelImage);

			$addsql				= "update ebay_order set ebay_tracknumber ='$TrackingNumber' where ebay_id ='$sn'";
			$dbcon->execute($addsql);

			echo $sn.' 订单编号 ，USPS单号申请成功，跟踪号是: '.$TrackingNumber.'<br>';

			}else{

			echo $sn.' 订单编号 ，USPS单号申请失败,失败原因是: <font color=red>'.$data['LabelRequestResponse']['ErrorMessage'].'</font><br>';
			}
	



		}
	}
