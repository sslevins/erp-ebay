<?php
include "include/config.php";
$ebay_id = $_REQUEST['ebay_id'];





$ss		= "select ddbtoken4px,ddbid4px from ebay_config WHERE `ebay_user` ='$user' LIMIT 1";
$ss		= $dbcon->execute($ss);
$ss		= $dbcon->getResultArray($ss);
$authToken = $ss[0]['ddbtoken4px'];
$custmomerCode = $ss[0]['ddbid4px'];



 

//if($user != 'vip924') $authToken = '';

$code = array();
$ebay_id = substr($ebay_id,1);
$id = explode(',',$ebay_id);
foreach($id as $k=>$v){
	$sql = "select pxorderid from ebay_order where ebay_id='$v'";
	$sql = $dbcon->execute($sql);
	$sql = $dbcon->getResultArray($sql);
	if($sql[0]['pxorderid']>0){
		$pxid = $sql[0]['pxorderid'];
		$code[$pxid]['code'] = $pxid;
		$code[$pxid]['id'] = $v;
		
		$data = submit4px($v,$authToken,$custmomerCode);
	
	
	
	}else{
	$data = submit4px($v,$authToken,$custmomerCode);
	
	
	print_r($data).'cc';
	
	foreach($data as $key=>$val){
		 if($val['success']=='TRUE'){
			$code[$val['deliveryCode']]['code']= $val['deliveryCode'];
			$code[$val['deliveryCode']]['id']= $key;
			$vv = "update ebay_order set pxorderid='$k' where ebay_id=".$code[$k]['id'];
			if($dbcon->execute($vv)){
				echo '<font color="green">'.$key.'提交成功 订单号：'.$val['deliveryCode'].'</font><br>';
			}
		 }else{
			if(isset($val['error']['value'])){
				echo '<font color="red">'.$key.'提交失败：'.$val['error']['value'].'</font><br>';
			}else{
				if(isset($val['errors']['error'][0])){
					foreach($val['errors']['error'] as $kk=>$vv){
						echo '<font color="red">'.$key.'提交失败：'.$vv['errorMessage'].'</font><br>';
					}
				}else{
					echo '<font color="red">'.$key.'提交失败：'.$val['errors']['error']['errorMessage'].'</font><br>';
				}
			}
		 }
	}
	}
}

echo "<br><hr><br>";
if($code){
	$codedata = submit4px1($code,$authToken);
	if(count($code)==1){
		if($codedata['success']=='TRUE'){
				$k = $codedata['deliveryCode'];
				$vv = "update ebay_order set pxorderid='$k' where ebay_id=".$code[$k]['id'];
				if($dbcon->execute($vv)){
					echo '<font color="green">'.$code[$k]['id'].'确认成功</font><br>';
				}else{
					echo '<font color="red">'.$code[$k]['id'].'确认失败</font><br>';
				}
			}else{
				echo '<font color="red">'.$code[$k]['id'].'确认失败：'.$codedata['errors']['error']['errorMessage'].'</font><br>';
			}
	}else{
		for($i=0;$i<count($code);$i++){
			if($codedata[$i]['success']=='TRUE'){
				$k = $codedata[$i]['deliveryCode'];
				$vv = "update ebay_order set pxorderid='$k' where ebay_id=".$code[$k]['id'];
				if($dbcon->execute($vv)){
					echo '<font color="green">'.$code[$k]['id'].'确认成功</font><br>';
				}else{
					echo '<font color="red">'.$code[$k]['id'].'确认失败</font><br>';
				}
			}else{
				echo '<font color="red">'.$code[$k]['id'].'确认失败：'.$codedata[$i]['errors']['error']['errorMessage'].'</font><br>';
			}
		}
	}
}
	function submit4px($ebay_id,$authToken,$custmomerCode){
		global $dbcon,$user;
		$data = array();
		$value = '<CreateDeliveryOrderRequest xmlns="http://wms.4px.cc/webservices/">
			<apiCredential>
				<authToken>{authToken}</authToken>
				<customerCode>{custmomerCode}</customerCode>
			</apiCredential>
			<warehouseCode>{warehouseCode}</warehouseCode>
			<referenceCode>{referenceCode}</referenceCode>
			<name>{name}</name>
			<carrier>{carrier}</carrier>
			<insureType>{insureType}</insureType>
			<country>{country}</country>
			<address1>{address1}</address1>
			<address2>{address2}</address2>
			<city>{city}</city>
			<state>{state}</state>
			<postalCode>{postalCode}</postalCode>
			<email>{email}</email>
			<phone>{phone}</phone>
			<eBayTransactionCode>{ebayTransantionCode}</eBayTransactionCode>
			<items></items>
		</CreateDeliveryOrderRequest>';
		$sql = "select * from ebay_order where ebay_id = $ebay_id";
		
		

		$sql = $dbcon->execute($sql);
		$sql = $dbcon->getResultArray($sql);
		
		
	
		
		$header = array();
		$header[] = "Content-Type:text/xml; charset=utf-8";
		$url =   "http://wms.4px.cc:6868/createDeliveryorder.xml";
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
			$value = str_replace('{warehouseCode}',$warehouseCode,$value);
			$referenceCode = $v['ebay_id'];
			$value = str_replace('{referenceCode}',$referenceCode,$value);
			$v['ebay_username'] = str_replace('&acute;',"'",$v['ebay_username']);
			$value = str_replace('{name}',$v['ebay_username'],$value);
			$carrier = $v['ebay_carrier'];
			$vv = "select value1 from ebay_carrier where name='$carrier' and ebay_user ='$user'";
			$vv = $dbcon->execute($vv);
			$vv = $dbcon->getResultArray($vv);
			if($vv[0]['value1']==''){ 
				 $data[$v['ebay_id']]['error']['value']="请设置运输方式对应4px代码";
				 break;
			}
			$value = str_replace('{carrier}',$vv[0]['value1'],$value);
			$value = str_replace('{insureType}','N',$value);
			$couny = $v['ebay_couny'];
			
			
			if($v['ebay_couny'] == 'UK' ) $couny ='GB';
			if($v['ebay_couny'] == 'United Kingdom' ) $couny ='GB';
			
			if(empty($couny)){
				$vv = "select ebay_couny from ebay_order where ebay_countryname='".$v['ebay_countryname']."' and ebay_couny is not null and ebay_couny!='' limit 0,1";
				
				

				$vv = $dbcon->execute($vv);
				$vv = $dbcon->getResultArray($vv);
				$couny = $vv[0]['ebay_couny'];
			}
			
			
			$ebay_street			= $v['ebay_street'];
			$ebay_street1			= $v['ebay_street1'];
			
			$ebay_street1			= str_replace('&acute;',"'",$ebay_street1);
			$ebay_street			= str_replace('&acute;',"'",$ebay_street);
			
			$value = str_replace('{country}',$couny,$value);
			$value = str_replace('{address1}',$ebay_street,$value);
			$value = str_replace('{address2}',$ebay_street1,$value);
			$value = str_replace('{city}',$v['ebay_city'],$value);
			$value = str_replace('{state}',$v['ebay_state'],$value);
			$value = str_replace('{postalCode}',$v['ebay_postcode'],$value);
			$value = str_replace('{email}',$v['ebay_usermail'],$value);
			$value = str_replace('{phone}',$v['ebay_phone'],$value);
			$value = str_replace('{ebayTransantionCode}','',$value);
			$vv = "select ebay_amount,sku,ebay_itemid from ebay_orderdetail where ebay_ordersn='".$v['ebay_ordersn']."'";
			$vv = $dbcon->execute($vv);
			$vv = $dbcon->getResultArray($vv);
			$text = "<items>";
			foreach($vv as $kk=>$vvv){
				$value1 = '
				<item>
					<imCode>{imCode}</imCode>
					<imQuantity>{imqty}</imQuantity>
					<englishName>{englishName}</englishName>
					<unitPrice>{unitPrice}</unitPrice>
					<currency>{currency}</currency>
				</item>
				';
				$value1 = str_replace('{imCode}',$vvv['sku'],$value1);
				$value1 = str_replace('{imqty}',$vvv['ebay_amount'],$value1);
				$ss = "select goods_ywsbmc,goods_sbjz from ebay_goods where goods_sn='".$vvv['sku']."'";
				$ss = $dbcon->execute($ss);
				$ss = $dbcon->getResultArray($ss);
				if($ss){
					 $value1 = str_replace('{englishName}',$ss[0]['goods_ywsbmc'],$value1);
					 $value1 = str_replace('{unitPrice}',$ss[0]['goods_sbjz'],$value1);
					 $value1 = str_replace('{currency}','USD',$value1);
				 }else{
					$value1 = str_replace('{englishName}','',$value1);
					$value1 = str_replace('{unitPrice}','',$value1);
					$value1 = str_replace('{currency}','',$value1);
				}
				$text .= $value1;
			}
			$text .= '</items>';
			$value = str_replace('<items></items>',$text,$value);
		echo $value.'cccccccccc';
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
			curl_setopt($curl, CURLOPT_POST, 1); 
			curl_setopt($curl, CURLOPT_POSTFIELDS, $value);
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
			$t = XML_unserialize($rs);
			$data[$v['ebay_id']] = $t['CreateDeliveryOrderResponse'];
			
		}
		return $data;
	}
	function submit4px1($code,$authToken){
		$url =   'http://wms.4px.cc:6868/releaseDeliveryorder.xml';
		$header = array();
		$header[] = "Content-Type:text/xml; charset=utf-8";
		$value = '<ReleaseDeliveryOrderRequest xmlns="http://wms.4px.cc/webservices/">
					<apiCredential>
						<authToken>'.$authToken.'</authToken>
					</apiCredential>
					<deliveryorderList>';
					foreach($code as $k=>$v){
					$value .='<deliveryorder>
							<deliveryCode>'.$v['code'].'</deliveryCode>
						</deliveryorder>';
					}	
					$value.='</deliveryorderList>
				  </ReleaseDeliveryOrderRequest>';
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
			curl_setopt($curl, CURLOPT_POST, 1); 
			curl_setopt($curl, CURLOPT_POSTFIELDS, $value);
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
			$data = XML_unserialize($rs);
			
			
			print_r($data);
			
			return $data['ReleaseDeliveryOrderResponse']['releaseResult']['deliveryorder'];
	}
