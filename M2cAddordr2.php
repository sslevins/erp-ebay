<?php
include 'include/config.php';
$api_address = 'http://yewu.chukou1.cn/client/ws/v2.1/ck1.asmx?wsdl';
$token = $ckytoken;
$user_key = $ckyuserkey;
$soap_client = new SoapClient($api_address);

$ids = substr($_REQUEST['ebay_id'],1);
$sql = "select ebay_id,cky_item,cky_orderid,ebay_warehouse from ebay_order where ebay_id in ($ids) and ebay_user='$user' ";
//echo $sql;
$sql = $dbcon->execute($sql);
$sql = $dbcon->getResultArray($sql);
foreach($sql as $k=>$v){
$ebay_id = $v['ebay_id'];
$storeid = $v['ebay_warehouse'];
$ss = "select store_sn,store_name from ebay_store where id = $storeid";
$ss = $dbcon->execute($ss);
$ss = $dbcon->getResultArray($ss);
$request = array
(
	'request' => array
	(
		'Token' => $token,	//系统验证字符串
		'UserKey' => $user_key,	//第三方验证字符串
		'Sign' => $v['cky_item'],
		'Warehouse' => $ss[0]['store_sn'],
		'MessageID' => $ebay_id	//客户请求号（可不填）
	)
);

$result = $soap_client->M2CGetPackage($request);


if($result->M2CGetPackageResult->Ack == 'Success'){
	$states = $result->M2CGetPackageResult->PackageDetail->State;
	//if($states == 'Delivered'){
		$tracknumber = $result->M2CGetPackageResult->PackageDetail->TrackingNumber;
		if($tracknumber){
			$updatesql = "update ebay_order set ebay_tracknumber = '$tracknumber' where ebay_id='$ebay_id'";
			
			//echo $updatesql;
			$dbcon->execute($updatesql);
			echo $ebay_id.'订单状态为已完成  获取跟踪号成功！<br>';
		}
//	}
}
}
?>

