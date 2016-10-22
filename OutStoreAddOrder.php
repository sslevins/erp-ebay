<?php
include 'include/config.php';

error_reporting(E_ALL);

$api_address = 'http://yewu.chukou1.cn/client/ws/v2.1/ck1.asmx?wsdl';
$token = $ckytoken;
$user_key = $ckyuserkey;
$soap_client = new SoapClient($api_address);

$ids = substr($_REQUEST['ebay_id'],1);
$OrderDetail = array();
$sql = "select ebay_warehouse from ebay_order where ebay_id in ($ids) and ebay_user='$user' group by ebay_warehouse";
$sql = $dbcon->execute($sql);
$sql = $dbcon->getResultArray($sql);
$storesn = array('US','AU','UK','MA');
foreach($sql as $k=>$v){
	$storeid = $v['ebay_warehouse'];
	$ss = "select store_sn,store_name from ebay_store where id = $storeid";
	$ss = $dbcon->execute($ss);
	$ss = $dbcon->getResultArray($ss);
	$OrderDetail['State'] = 'Initial';
	$OrderDetail['Remark'] = '';
	if(in_array($ss[0]['store_sn'],$storesn)){
		$OrderDetail['Warehouse'] = $ss[0]['store_sn'];
	}else{
		echo $ss[0]['store_name']."---错误的仓库编码！";
	}
	$OrderDetail['PackageList'] = array();
	$ss = $sql = "select * from ebay_order where ebay_id in ($ids) and ebay_warehouse='$storeid'";
	$ss = $dbcon->execute($ss);
	$ss = $dbcon->getResultArray($ss);
	foreach($ss as $kk=>$vv){
		$ordersn = $vv['ebay_ordersn'];
		$ebay_id = $vv['ebay_id'];
		$OrderDetail['PackageList'][$kk]['State'] = 'Initial';
		$OrderDetail['PackageList'][$kk]['Shipping'] = 'None'; 
		$OrderDetail['PackageList'][$kk]['Custom'] = $ebay_id;
		$ordercarrier = $vv['ebay_carrier'];
	
		
		$rr = "select value2,IsInsured,InsuredRate from ebay_carrier where name = '$ordercarrier' and ebay_user='$user'";
		$rr = $dbcon->execute($rr);
		$rr = $dbcon->getResultArray($rr);
		$OrderDetail['PackageList'][$kk]['ShippingV2_1'] = $rr[0]['value2'];
		if($rr[0]['IsInsured']){
			$OrderDetail['PackageList'][$kk]['IsInsured'] = TRUE;
			$OrderDetail['PackageList'][$kk]['InsuredRate'] = $rr[0]['InsuredRate'];
		}else{
			$OrderDetail['PackageList'][$kk]['IsInsured'] = FAlSE;
			$OrderDetail['PackageList'][$kk]['InsuredRate'] = $rr[0]['InsuredRate'];
		}
		$OrderDetail['PackageList'][$kk]['ProductList'] = array();
		$sl = "select sku,ebay_amount from ebay_orderdetail where ebay_ordersn='$ordersn'";
		$sl = $dbcon->execute($sl);
		$sl = $dbcon->getResultArray($sl);
		$tt = 0;
		foreach($sl as $kkk=>$vvv){
			$sku = $vvv['sku'];
			$amount = $vvv['ebay_amount'];
			$rr = "select goods_sbjz,goods_ywsbmc from ebay_goods where goods_sn='$sku' and ebay_user='$user'";
			$rr = $dbcon->execute($rr);
			$rr = $dbcon->getResultArray($rr);
			
			if($rr){
				$OrderDetail['PackageList'][$kk]['ProductList'][$tt]['Quantity'] = $amount;
				$OrderDetail['PackageList'][$kk]['ProductList'][$tt]['SKU'] = $sku;
				//$OrderDetail['PackageList'][$kk]['ProductList'][$tt]['DeclareName'] = $rr[0]['goods_ywsbmc'];
				//$OrderDetail['PackageList'][$kk]['ProductList'][$tt]['DeclareValue']= $rr[0]['goods_sbjz'];
				
				$tt++;
			}else{
				$rr = "select goods_sncombine from ebay_productscombine where goods_sn='$sku' and ebay_user='$user'";
				$rr = $dbcon->execute($rr);
				$rr = $dbcon->getResultArray($rr);
				$goods_sncombine = explode(',',$rr[0]['goods_sncombine']);
				for($t = 0;$t<count($goods_sncombine);$t++){
					$goods = explode('*',$goods_sncombine[$t]);
					$goods_sn = $goods[0];
					$goods_count = $amount*$goods[1];
					$ee = "select goods_sbjz,goods_ywsbmc from ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
					$ee = $dbcon->execute($ee);
					$ee = $dbcon->getResultArray($ee);
					$OrderDetail['PackageList'][$kk]['ProductList'][$tt]['Quantity'] = $goods_count;
					$OrderDetail['PackageList'][$kk]['ProductList'][$tt]['SKU'] = $goods_sn;
					//$OrderDetail['PackageList'][$kk]['ProductList'][$tt]['DeclareName'] = $ee[0]['goods_ywsbmc'];
					//$OrderDetail['PackageList'][$kk]['ProductList'][$tt]['DeclareValue']= $ee[0]['goods_sbjz'];
					$tt++;
				}
			}
		}
		
		$OrderDetail['PackageList'][$kk]['ShipToAddress']= array(
														'Company' => '',
														'City' => $vv['ebay_city'],	//城市	
														'Contact' => $vv['ebay_username'],		//联系人
														'Country' => $vv['ebay_countryname'],	//国家
														'Email' => $vv['ebay_usermail'],	//电子邮箱
														'Phone' => $vv['ebay_phone'],	//手机
														'PostCode' => $vv['ebay_postcode'],	//邮政编码,对格式有验证，必须为真实的邮政编码！
														'Province' => $vv['ebay_state'],	//省份
														'Street1' => $vv['ebay_street'],	//街道1
														'Street2' => $vv['ebay_street1']		//街道2
													);
	}

$request = array
    (
        'request' => array
        (
            'Token' => $token,
            'UserKey' => $user_key,	
            'MessageID' => '132374outAOtest',
            'Submit' => false,
			'OrderDetail' => $OrderDetail
        )
    );
	
	
	


	print_r($request);
$result = $soap_client->OutStoreAddOrder($request);



print_r($result);


if($result->OutStoreAddOrderResult->Ack =='Success'){
	$OrderSign = $result->OutStoreAddOrderResult->OrderSign;
	$request2 = array
	(
		'request' => array
		(
			'Token' => $token,
			'UserKey' => $user_key,
			'ActionType' =>	'Submit',
			'OrderSign' => $OrderSign
		)
	);
	$result2 = $soap_client->OutStoreCompleteOrder($request2);
	

	
	if($result2->OutStoreCompleteOrderResult->Ack =='Success'){
		
		$cky_item = $result->OutStoreAddOrderResult->Packages->FeedBackItem->ItemSign;
		$cky_id = $result->OutStoreAddOrderResult->Packages->FeedBackItem->Custom;
		
		if($cky_id != ''){
		$updatesql = "update ebay_order set cky_orderid = '$OrderSign',cky_item = '$cky_item' where ebay_id='$cky_id'";
		echo $updatesql;
		$dbcon->execute($updatesql);
		echo $cky_id.'提审成功！<br>';
		}else{
			
			
				
				$items		= $result->OutStoreAddOrderResult->Packages->FeedBackItem;
				for($i=0;$i<count($items);$i++){
						
								
								$cky_item = $result->OutStoreAddOrderResult->Packages->FeedBackItem[$i]->ItemSign;
								$cky_id = $result->OutStoreAddOrderResult->Packages->FeedBackItem[$i]->Custom;
								
								$updatesql = "update ebay_order set cky_orderid = '$OrderSign',cky_item = '$cky_item' where ebay_id='$cky_id'";
								echo $updatesql;
								$dbcon->execute($updatesql);
								echo $cky_id.'提审成功！<br>';
				
				}
		
		}
		
		
		
	}
}else{
	echo $result->OutStoreAddOrderResult->Message;
}
}
?>

