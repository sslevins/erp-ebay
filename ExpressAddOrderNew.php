<?php
include 'include/config.php';
error_reporting(E_ALL);
$api_address = 'http://yewu.chukou1.cn/client/ws/v2.1/ck1.asmx?wsdl';
$token = $ckytoken;
$user_key = $ckyuserkey;
// $api_address = 'http://demo.chukou1.cn/client/ws/v2.1/ck1.asmx?WSDL';
// $token = '887E99B5F89BB18BEA12B204B620D236';
// $user_key = 'wr5qjqh4gj';
$soap_client = new SoapClient($api_address);

$ids = substr($_REQUEST['ebay_id'],1);
$OrderDetail = array();
$sql = "select ebay_carrier from ebay_order where ebay_id in ($ids) and ebay_user='$user' group by ebay_carrier";
$sql = $dbcon->execute($sql);
$sql = $dbcon->getResultArray($sql);
foreach($sql as $k=>$v){
	$ebay_carrier = $v['ebay_carrier'];
	$rr = "select * from ebay_carrier where name = '$ebay_carrier' and ebay_user='$user'";
	$rr = $dbcon->execute($rr);
	$rr = $dbcon->getResultArray($rr);
	$OrderDetail['ExpressType'] = 'UNKNOWN';
	$OrderDetail['IsTracking'] = TRUE;
	$OrderDetail['Location'] = $rr[0]['Location'];
	$OrderDetail['Point4Delivery'] = $rr[0]['Point4Delivery'];
	$OrderDetail['PickupType'] = $rr[0]['PickupType'];
	$OrderDetail['Remark'] = '';
	
	
	
	
	$coutrycode		= $rr[0]['ebay_countryname'];
	$vv="select *  from ebay_countrys where  ebay_user ='$user' and countryen='$coutrycode'";
	$vv = $dbcon->execute($vv);
	$vv = $dbcon->getResultArray($vv);
	$countryname		= $rr[0]['country'];
	if(count($vv) > 0 ){
		$countryname		= $vv[0]['countrysn'];
	}
	
	
	$OrderDetail['PickUpAddress'] = array(
		'City' => $rr[0]['city'],
		'Contact' => $rr[0]['username'],
		'Province' => $rr[0]['province'],
		'Street1' => $rr[0]['address'],
		'Country' => $countryname,
		'PostCode' => $rr[0]['zip'],
		'Phone' => $rr[0]['tel']		
	);
	$value2 =  $rr[0]['value2'];
	$OrderDetail['PackageList'] = array();
	$ss = $sql = "select * from ebay_order where ebay_id in ($ids) and ebay_carrier='$ebay_carrier'";
	$ss = $dbcon->execute($ss);
	$ss = $dbcon->getResultArray($ss);
	foreach($ss as $kk=>$vv){
		$ordersn = $vv['ebay_ordersn'];
		$ebay_id = $vv['ebay_id'];
		$OrderDetail['PackageList'][$kk]['Status'] = 'Initial';
		$OrderDetail['PackageList'][$kk]['Remark'] =$ebay_id; 
	
		$OrderDetail['PackageList'][$kk]['ProductList'] = array();
		$sl = "select sku,ebay_amount from ebay_orderdetail where ebay_ordersn='$ordersn'";
		$sl = $dbcon->execute($sl);
		$sl = $dbcon->getResultArray($sl);
		$tt = 0;
		$allweight = 0;
		
		
		
		$lstr	= '';
		
		foreach($sl as $kkk=>$vvv){
			$sku = $vvv['sku'];
			$amount = $vvv['ebay_amount'];
			$rr = "select goods_sbjz,goods_ywsbmc,goods_zysbmc,goods_weight,goods_name from ebay_goods where goods_sn='$sku' and ebay_user='$user'";
			
			
			
			
			
			//echo $rr;
			
			$rr = $dbcon->execute($rr);
			$rr = $dbcon->getResultArray($rr);
			$goods_name		= $rr[0]['goods_name'];
			if($user =='vipzz'){
				$lstr   .= $sku.' ['.$goods_name.'] *'.$amount.'  ';
			}else{
				$lstr   .= $sku.' *'.$amount.'  ';
			}
			
			if($rr){
				$OrderDetail['PackageList'][$kk]['ProductList'][$tt]['Quantity'] = $amount;
				$OrderDetail['PackageList'][$kk]['ProductList'][$tt]['SKU'] = $sku;
				$OrderDetail['PackageList'][$kk]['ProductList'][$tt]['CustomsTitleCN'] = $rr[0]['goods_zysbmc'];
				$OrderDetail['PackageList'][$kk]['ProductList'][$tt]['CustomsTitleEN'] = $rr[0]['goods_ywsbmc'];
				$OrderDetail['PackageList'][$kk]['ProductList'][$tt]['Weight'] = $rr[0]['goods_weight']*1000;
				$allweight = $allweight + $rr[0]['goods_weight']*1000;
				$OrderDetail['PackageList'][$kk]['ProductList'][$tt]['DeclareValue']= $rr[0]['goods_sbjz'];
				
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
					$ee = "select goods_sbjz,goods_ywsbmc,goods_zysbmc,goods_weight from ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
					$ee = $dbcon->execute($ee);
					$ee = $dbcon->getResultArray($ee);
					$OrderDetail['PackageList'][$kk]['ProductList'][$tt]['Quantity'] = $goods_count;
					$OrderDetail['PackageList'][$kk]['ProductList'][$tt]['SKU'] = $goods_sn;
					$OrderDetail['PackageList'][$kk]['ProductList'][$tt]['CustomsTitleCN'] = $ee[0]['goods_zysbmc'];
					$OrderDetail['PackageList'][$kk]['ProductList'][$tt]['CustomsTitleEN'] = $ee[0]['goods_ywsbmc'];
					$OrderDetail['PackageList'][$kk]['ProductList'][$tt]['Weight'] = $ee[0]['goods_weight']*1000;
					$allweight = $allweight + $ee[0]['goods_weight']*1000;
					$OrderDetail['PackageList'][$kk]['ProductList'][$tt]['DeclareValue']= $ee[0]['goods_sbjz'];
					$tt++;
				}
			}
		}
		
		
			$OrderDetail['PackageList'][$kk]['Custom'] = $lstr;
			
			
			
		$OrderDetail['PackageList'][$kk]['Weight'] = $allweight;
		$OrderDetail['PackageList'][$kk]['Packing'] = array
                    (
                        'Length' => '10',
                        'Width' => '10',
                        'Height' => '10',
                    );
		$OrderDetail['PackageList'][$kk]['ShipToAddress']= array(
														'City' => $vv['ebay_city']?$vv['ebay_city']:',',	//城市	
														'Contact' => $vv['ebay_username'],		//联系人
														'Country' => $vv['ebay_countryname'],	//国家
														'Email' => $vv['ebay_usermail'],	//电子邮箱
														'Phone' => $vv['ebay_phone'],	//手机
														'PostCode' => $vv['ebay_postcode']?$vv['ebay_postcode']:',',	//邮政编码,对格式有验证，必须为真实的邮政编码！
														'Province' => $vv['ebay_state']?$vv['ebay_state']:',',	//省份
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
			'ExpressTypeNew' => $value2,
            'Submit' => false,
			'OrderDetail' => $OrderDetail
        )
    );
	
	
	
//echo "<pre>";
//print_r($request);
//exit;	
$result = $soap_client->ExpressAddOrderNew($request);

//echo "<pre>";
//print_r($result);



if($result->ExpressAddOrderNewResult->Ack =='Success'){
	$OrderSign = $result->ExpressAddOrderNewResult->OrderSign;
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
	$result2 = $soap_client->ExpressCompleteOrder($request2);
	

	
	if($result2->ExpressCompleteOrderResult->Ack =='Success'){
		
		$cky_item = $result->ExpressAddOrderNewResult->Packages->FeedBackItem->ItemSign;
		$cky_id = $result->ExpressAddOrderNewResult->Packages->FeedBackItem->Remark;
		
		if($cky_id != ''){
		$updatesql = "update ebay_order set cky_orderid = '$OrderSign',cky_item = '$cky_item' where ebay_id='$cky_id'";
		echo $updatesql;
		$dbcon->execute($updatesql);
		echo $cky_id.'提审成功！<br>';
		}else{
			
			
				
				$items		= $result->ExpressAddOrderNewResult->Packages->FeedBackItem;
				for($i=0;$i<count($items);$i++){
						
								
								$cky_item = $result->ExpressAddOrderNewResult->Packages->FeedBackItem[$i]->ItemSign;
								$cky_id = $result->ExpressAddOrderNewResult->Packages->FeedBackItem[$i]->Remark;
								
								$updatesql = "update ebay_order set cky_orderid = '$OrderSign',cky_item = '$cky_item' where ebay_id='$cky_id'";
								echo $updatesql;
								$dbcon->execute($updatesql);
								echo $cky_id.'提审成功！<br>';
				
				}
		
		}
		
		
		
	}
}else{
	echo $result->ExpressAddOrderNewResult->Message;
}
}
?>