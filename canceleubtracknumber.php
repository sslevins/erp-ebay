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
				
					getshiplabel($sn);
		}
			
	}
	
	
	
	function getshiplabel($ordersn){
		
		global $dbcon,$user;
		
		$ss					= "select * from ebay_order where ebay_id = '$ordersn' ";
		$ss					= $dbcon->execute($ss);
		$ss					= $dbcon->getResultArray($ss);
		$ebay_tracknumber	= $ss[0]['ebay_tracknumber'];
		$ebay_account	= $ss[0]['ebay_account'];
		$ebay_usermail	= $ss[0]['ebay_usermail'];
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
		
		
		
		
		$soapclient = new soapclient("orderservice.asmx");
		$params		= array(
    	'Version' => "3.0.0",
    	'APIDevUserID' => $APIDevUserID,
    	'APIPassword' => $APIPassword,
    	'APISellerUserID' => $APISellerUserID,
    	'MessageID' => "135625622432",
		'TrackCode' =>$ebay_tracknumber
		);
		
		
		print_r($params);
		
		$functions = $soapclient->CancelAPACShippingPackage(array("CancelAPACShippingPackageRequest"=>$params));

		
		
		foreach($functions as $aa){
			
			$bb   = (array)$aa;
			
			$ack		= $bb['Ack'];
			

			if($ack     != 'Failure'){
				
				echo "<br>".$ebay_usermail." EUB 取消包裹跟踪号成功";
			}else{
				$Message	= $bb['Message'];
				echo "<br>".$ebay_usermail." EUB 取消包裹跟踪号失败：<font color='#FF0000'>".$Message."</font>";
			}
				
			
		}
		
		
	}
	
	








?>



</body>
</html>
