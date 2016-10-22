<?php
include 'include/config.php';
$api_address = 'http://yewu.chukou1.cn/client/ws/v2.1/ck1.asmx?wsdl';
$token = $ckytoken;
$user_key = $ckyuserkey;
// $api_address = 'http://demo.chukou1.cn/client/ws/v2.1/ck1.asmx?WSDL';
// $token = '887E99B5F89BB18BEA12B204B620D236';
// $user_key = 'wr5qjqh4gj';
$soap_client = new SoapClient($api_address);

$ids = substr($_REQUEST['ebay_id'],1);
$OrderDetail = array();
$sql = "select ebay_id,cky_item from ebay_order where ebay_id in ($ids) and ebay_user='$user' ";
$sql = $dbcon->execute($sql);
$sql = $dbcon->getResultArray($sql);
foreach($sql as $k=>$v){
$ebay_id = $v['ebay_id'];
$request = array
(
	'request' => array
	(
		'Token' => $token,	//系统验证字符串
		'UserKey' => $user_key,	//第三方验证字符串
		'ItemSign' => $v['cky_item'],
		'MessageID' => $ebay_id,	//客户请求号（可不填）
	)
);

$result = $soap_client->ExpressGetPackage($request);

//echo "<pre>";



if($result->ExpressGetPackageResult->Ack == 'Success'){
	$states = $result->ExpressGetPackageResult->PackageDetail->State;
	//if($states == 'Delivered'){
		$tracknumber = $result->ExpressGetPackageResult->PackageDetail->TrackCode;
		if($tracknumber){
			$updatesql = "update ebay_order set ebay_tracknumber = '$tracknumber' where ebay_id='$ebay_id'";
			
			echo $updatesql;
			$dbcon->execute($updatesql);
			echo $ebay_id.'订单状态为已完成  获取跟踪号成功！<br>';
		}else{
			
			
			echo $ebay_id.'订单状态为已完成  获取跟踪号为空！<br>';
		}
//	}
}else{
	
	
			
			echo '订单编号: '.$ebay_id.' 同步失败';
				
	
}
}
?>

