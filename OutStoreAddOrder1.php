<?php
include 'include/config.php';


error_reporting(E_ALL);

$api_address = 'http://yewu.chukou1.cn/client/ws/v2.1/ck1.asmx?wsdl';
$token = $ckytoken;
$user_key = $ckyuserkey;
$soap_client = new SoapClient($api_address);

$ids = substr($_REQUEST['ebay_id'],1);
$OrderDetail = array();
$sql = "select ebay_id,cky_item from ebay_order where ebay_id in ($ids) and ebay_user='$user' ";
$sql = $dbcon->execute($sql);
$sql = $dbcon->getResultArray($sql);



//print_r($sql);

foreach($sql as $k=>$v){
$ebay_id = $v['ebay_id'];
$request = array
(
	'request' => array
	(
		'Token' => $token,	//系统验证字符串
		'UserKey' => $user_key,	//第三方验证字符串
		'Sign' => $v['cky_item'],
		//'MessageID' => $ebay_id,	//客户请求号（可不填）
	)
);
//print_r($request);


$result = $soap_client->OutStoreGetPackage($request);



//print_r($result);

if($result->OutStoreGetPackageResult->Ack == 'Success'){
	$states = $result->OutStoreGetPackageResult->PackageDetail->State;
	//if($states == 'Delivered'){
		$tracknumber = $result->OutStoreGetPackageResult->PackageDetail->TrackingNumber;
		if($tracknumber){
			$updatesql = "update ebay_order set ebay_tracknumber = '$tracknumber' where ebay_id='$ebay_id'";
			
			echo $updatesql;
			$dbcon->execute($updatesql);
			echo $ebay_id.'订单状态为已完成  获取跟踪号成功！<br>';
		}
//	}
}
}
?>

