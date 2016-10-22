<?php
include "include/config.php";
$ebay_id = $_REQUEST['ebay_id'];

error_reporting(E_ALL);


$ss		= "select ddbtoken4px,ddbid4px from ebay_config WHERE `ebay_user` ='$user' LIMIT 1";
$ss		= $dbcon->execute($ss);
$ss		= $dbcon->getResultArray($ss);
$authToken = $ss[0]['ddbtoken4px'];
$custmomerCode = $ss[0]['ddbid4px'];



 

function objtoarr($obj){
	$ret = array();
	foreach($obj as $key =>$value){
		if(gettype($value) == 'array' || gettype($value) == 'object'){
			$ret[$key] = objtoarr($value);
		}
		else{
			$ret[$key] = $value;
		}
	}
	return $ret;
}


$code = array();
$ebay_id = substr($ebay_id,1);
$id = explode(',',$ebay_id);
foreach($id as $k=>$v){
	$sql = "select pxorderid from ebay_order where ebay_id='$v'";
	
	
	echo $sql;
	
	$sql = $dbcon->execute($sql);
	$sql = $dbcon->getResultArray($sql);
	
	

		
	if($sql[0]['pxorderid'] == ''){
		
		echo 'fff';
		
	$data = submit4px($v,$authToken,$custmomerCode);
print_r($data);

	$data = json_decode($data);
	$data	= objtoarr($data);
	$ack	= $data['data']['ack'];	
	if($ack == 'Y'){			
			echo '<font color="green">提交成功 订单号：'.$v.'</font><br>';
			$documentCode	= $data['data']['documentCode'];
			$vv = "update ebay_order set pxorderid='$documentCode' where ebay_id=".$v." and ebay_user ='$user'";
			$dbcon->execute($vv);

	}else{			
			echo '<font color="red">提交失败   订单号：'.$v.'</font><br>失败原因如下:<br>'.$data['data']['errors'][0]['code'].'<br>';
			
	}
	}

	
	
	
}


	function submit4px($ebay_id,$authToken,$custmomerCode){
		global $dbcon,$user;
		$data = array();
		
		
		$pxdata = '{"warehouseCode": "{warehouseCode}","referenceCode": "{referenceCode}","carrierCode": "{carrier}","insureType": "NI","sellCode": "{sellCode}","remoteArea": "Y","platformCode": "E","description": "","consignee": {"state": "{state}","fullName": "{fullName}","email": "{email}","countryCode": "{countryCode}","street": "{street}","city": "{city}","postalCode": "{postalCode}","phone": "{phone}","company": "","doorplate": ""},"items":[{sku}]}';
	
		

	
		$sql = "select * from ebay_order where ebay_id = $ebay_id";
		$sql = $dbcon->execute($sql);
		$sql = $dbcon->getResultArray($sql);
		
	//	$custmomerCode	='100800';
	//	$authToken		= 'oDuCfVi88b40oOuMYQUOcTh2b/T+uJdDBsJ+VOrlG6Q=1';
		
		$header = array();
		$header[] = "Content-Type:text/xml; charset=utf-8";
		$url =   "http://openapi.4px.com/api/service/woms/order/createDeliveryOrder?format=json&customerId=".$custmomerCode."&token=".$authToken."&language=en_US";
		
		foreach($sql as $k=>$v){
			
			
			
			$value = str_replace('{authToken}',$authToken,$value);
			$value = str_replace('{custmomerCode}',$custmomerCode,$value);
			$store_id = $v['ebay_warehouse'];
			if(!$store_id){
				$data[$v['ebay_id']]['error']['value']="请设置出货仓库";
				break;
			};
			
			
			
			$vv = "select store_sn from ebay_store where id='$store_id'";
			
			
			$vv = $dbcon->execute($vv);
			$vv = $dbcon->getResultArray($vv);
			$warehouseCode = $vv[0]['store_sn'];
			$pxdata = str_replace('{warehouseCode}',$warehouseCode,$pxdata);
			

			
			
			
			$referenceCode = $v['ebay_id'];
			$pxdata = str_replace('{referenceCode}',$referenceCode,$pxdata);
			
			
			
			$carrier = $v['ebay_carrier'];
			$vv = "select value1 from ebay_carrier where name='$carrier' and ebay_user ='$user'";
			$vv = $dbcon->execute($vv);
			$vv = $dbcon->getResultArray($vv);
			if($vv[0]['value1']==''){ 
				 $data[$v['ebay_id']]['error']['value']="请设置运输方式对应4px代码";
				 break;
			}
			$pxdata = str_replace('{carrier}',$vv[0]['value1'],$pxdata);
			
		//	$pxdata = str_replace('{insureType}','N',$pxdata);
			
			$recordnumber = $v['recordnumber'];
			
			$pxdata = str_replace('{sellCode}',$recordnumber,$pxdata);
			
			
	
			$pxdata = str_replace('{state}',$v['ebay_state'],$pxdata);
			$v['ebay_username'] = str_replace('&acute;',"'",$v['ebay_username']);
			$pxdata = str_replace('{name}',$v['ebay_username'],$pxdata);
			$pxdata = str_replace('{fullName}',$v['ebay_username'],$pxdata);
			$pxdata = str_replace('{email}',$v['ebay_usermail'],$pxdata);
			
			
			
			
			$couny = $v['ebay_couny'];
			if($v['ebay_couny'] == 'UK' ) $couny ='GB';
			if($v['ebay_couny'] == 'United Kingdom' ) $couny ='GB';
			if(empty($couny)){
				$vv = "select ebay_couny from ebay_order where ebay_countryname='".$v['ebay_countryname']."' and ebay_couny is not null and ebay_couny!='' limit 0,1";
				$vv = $dbcon->execute($vv);
				$vv = $dbcon->getResultArray($vv);
				$couny = $vv[0]['ebay_couny'];
			}
			
			
			$pxdata = str_replace('{countryCode}',$couny,$pxdata);
			
			
			
			$ebay_street			= $v['ebay_street'];
			$ebay_street1			= $v['ebay_street1'];
			
			$ebay_street1			= str_replace('&acute;',"'",$ebay_street1);
			$ebay_street			= str_replace('&acute;',"'",$ebay_street);
			
			
			$pxdata = str_replace('{street}',$ebay_street.' '.$ebay_street1,$pxdata);
			$pxdata = str_replace('{city}',$v['ebay_city'],$pxdata);
			$pxdata = str_replace('{postalCode}',$v['ebay_postcode'],$pxdata);
			$pxdata = str_replace('{phone}',$v['ebay_phone'],$pxdata);
			
			
			
			$vv = "select ebay_amount,sku,ebay_itemid from ebay_orderdetail where ebay_ordersn='".$v['ebay_ordersn']."'";
			
			

			
			$vv = $dbcon->execute($vv);
			$vv = $dbcon->getResultArray($vv);
			$text = "<items>";
			
			
			$text	= '';
			
			foreach($vv as $kk=>$vvv){
				
				$sku				= $vvv['sku'];
				$ebay_amount		= $vvv['ebay_amount'];
		
		
			//	$sku = 'TEST01';
				$text .= '{"sku": "'.$sku.'","quantity": '.$ebay_amount.'},';
			}
			
			
			
			$text		= substr($text,0,strlen($text)-1);
			$pxdata = str_replace('{sku}',$text,$pxdata);
			
			
			
		//	$value = '{"warehouseCode": "USLA","referenceCode": "123456789","carrierCode": "USLAFEDEX","insureType": "NI","sellCode": "123456","remoteArea": "Y","platformCode": "E","description": "","consignee": {"state": "FEWAF","fullName": "fewafewaferagrefwe","email": "123456789@qq.com","countryCode": "US","street": "FEWAFE","city": "EAF","postalCode": "43227","phone": "123456789","company": "","doorplate": ""},"items":[{"sku": "WANGLING001","quantity": 1},{"sku": "TEST01","quantity": 10}]}';
	

	
			$header = array();
			$header[] = "Content-Type:application/json; charset=utf-8";
		
			echo $url;
			
		//	$url =   "http://apisandbox.4px.com/api/service/woms/order/getOrderCarrier?customerId=100800&token=oDuCfVi88b40oOuMYQUOcTh2b/T+uJdDBsJ+VOrlG6Q=1&language=en_US";
	
		//	$value = '{"warehouseCode": "USLA"}';
		//	$value  = json_encode($value);
		
		
		
		echo $pxdata;
		
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
			curl_setopt($curl, CURLOPT_POST, 1); 
			curl_setopt($curl, CURLOPT_POSTFIELDS, $pxdata);
			curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); 
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //不直接显示回传结果
			$rs = curl_exec($curl); 
			if(curl_errno($curl))
			{
				print_r(curl_error($curl));
			}
			curl_close($curl);


			return $rs;
			
			
		}
		
	}