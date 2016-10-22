<?php
include "include/config.php";
$type = $_REQUEST['type'];
$ebayids = substr($_REQUEST['ebay_id'],1);
$ss		= "select ddbtoken4px,ddbid4px from ebay_config WHERE `ebay_user` ='$user' LIMIT 1";
$ss		= $dbcon->execute($ss);
$ss		= $dbcon->getResultArray($ss);
$authToken = $ss[0]['ddbtoken4px'];
$custmomerCode = $ss[0]['ddbid4px'];
$types = '0';
if($type=='status'){
	$sql = "select ebay_id,pxorderid,ebay_carrier from ebay_order where ebay_id in ($ebayids)";
	$sql = $dbcon->execute($sql);
	$sql = $dbcon->getResultArray($sql);
	foreach($sql as $k=>$v){
		if($v['pxorderid']){
			$data = submit4px3($v['pxorderid'],$authToken,$custmomerCode);
			if(isset($data['errors'])){
				echo $v['pxorderid'].'同步失败：'.$data['errors']['error']['errorMessage'];
			}else{
				$value = $data['deliveryorderList']['deliveryorder'];
				$ebay_id = $v['ebay_id'];
				$storesn = $value['warehouseCode'];
				$createtime = strtotime($value['createDate']);
				$pxorderid	= $value['deliveryCode'];
				$status		= $value['status'];
				$carrier	= $value['carrier'];
				$shippingno	= $value['shippingNO'];
				$shippingtime	= strtotime($value['shippingtime']);
				$weight	= $value['weight'];
				$ss = "select id from ebay_orderlog where orderid=".$ebay_id;
				$ss = $dbcon->execute($ss);
				$ss = $dbcon->getResultArray($ss);
				$statuss = '';
				if($ss){
					$insql = "update ebay_orderlog set status='$status',shippingno='$shippingno',shippingtime='$shippingtime',weight='$weight' where id=".$ss[0]['id'];
					if($shippingno!=''){	
						$upsql = "update ebay_order set ebay_tracknumber='$shippingno' where ebay_id=".$ebay_id;
						$dbcon->execute($upsql);
						$statuss = ' - 同步到跟踪号 '.$shippingno;
					}
				}else{
					$insql = "insert into ebay_orderlog (id,orderid,storesn,createtime,pxorderid,status,carrier,shippingno,shippingtime,weight) values ('','$ebay_id','$storesn','$createtime','$pxorderid','$status','$carrier','$shippingno','$shippingtime','$weight');";
				}
				if($dbcon->execute($insql)){
					echo $ebay_id.'同步成功'.$statuss.'<br>';
				}else{
					echo $ebay_id.'同步失败！<br>';
				}
			}
		}
	}
}
if($type == 'orderfee'){
	$ebay_id=$_REQUEST['id'];
	$sql = "select pxorderid from ebay_order where ebay_id='$ebay_id'";
	$sql = $dbcon->execute($sql);
	$sql = $dbcon->getResultArray($sql);
	if($sql){
		$pxid = $sql[0]['pxorderid'];
		$value = check4pxfee($pxid,$authToken,$custmomerCode);
		if(isset($value['errors'])){
			echo $ebay_id.'查看费用错误：'.$value['errors']['error']['errorMessage'];
		}
		$data = $value['feeList']['fees'];
			echo "<table border='1'><tr><td>4px订单号</td><td>".$data['code']."</td></tr>";
	echo "<tr><td>计算时间</td><td>".$data['date']."</td></tr>";
	echo "<tr><td>运费</td><td>".$data['shippingFee']."</td></tr>";
	echo "<tr><td>挂号费</td><td>".$data['registeredCharges']."</td></tr>";
	echo "<tr><td>仓储操作</td><td>".$data['handlingFee']."</td></tr>";
	echo "<tr><td>关税</td><td>".$data['tariff']."</td></tr>";
	echo "<tr><td>燃油费</td><td>".$data['fuelCharges']."</td></tr>";
	echo "<tr><td>物流杂费</td><td>".$data['otherCharges']."</td></tr>";
	echo "<tr><td>地面处置费</td><td>".$data['groundDisposalFee']."</td></tr>";
	echo "<tr><td>包装费</td><td>".$data['packageFee']."</td></tr>";
	echo "<tr><td>仓租费</td><td>".$data['rent']."</td></tr>";
	echo "<tr><td>陆运费</td><td>".$data['landFreight']."</td></tr>";
	echo "<tr><td>调整费</td><td>".$data['adjustmentCosts']."</td></tr>";
	echo "<tr><td>保险费</td><td>".$data['insurant']."</td></tr>";
	echo "<tr><td>退仓费</td><td>".$data['backstorageCharges']."</td></tr>";
	echo "<tr><td>入库费</td><td>".$data['instorageFee']."</td></tr>";
	echo "<tr><td>退件重新上架费</td><td>".$data['putWayCharges']."</td></tr>";
	echo "<tr><td>头程杂费</td><td>".$data['firstStepCharges']."</td></tr>";
	echo "<tr><td>扣仓费</td><td>".$data['holdingCharges']."</td></tr>";
	echo "<tr><td>提货费</td><td>".$data['pickUpCharges']."</td></tr>";
	echo "<tr><td>偏远地区附加费</td><td>".$data['remoteAreaCharges']."</td></tr>";
	echo "</table>";
	}else{
		echo "未找到4px订单号";
	}
}
	//同步4px订单状态
	function submit4px3($code,$authToken,$custmomerCode){
		 $url =   'http://wms.4px.cc:6868/getDeliveryorder.xml';
		 $header = array();
		 $header[] = "Content-Type:text/xml; charset=utf-8";
		 $value = '<GetDeliveryorderRequest xmlns="http://wms.4px.cc/webservices/">
   <apiCredential>
 <authToken>'.$authToken.'</authToken>
 <customerCode>'.$custmomerCode.'</customerCode>
   </apiCredential>
 <deliveryorderList>
     <deliveryorder>
 <deliveryCode>'.$code.'</deliveryCode>
 </deliveryorder>
   </deliveryorderList>
 </GetDeliveryorderRequest>';
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
			 return $data['GetDeliveryorderResponse'];
	 }
	//查询4px费用
	function check4pxfee($code,$authToken,$custmomerCode){
		$url = 'http://wms.4px.cc:6868/getFreightFee.xml';
		$header = array();
		$header[] = "Content-Type:text/xml; charset=utf-8";
		$value = '<GetFreightFeeRequest xmlns="http://wms.4px.cc/webservices/">
					<apiCredential>
						<authToken>'.$authToken.'</authToken>
					</apiCredential>
					<feeConditionList>
						<feeCondition>
							<code>'.$code.'</code>
							<customerCode>'.$custmomerCode.'</customerCode>
						</feeCondition>
					</feeConditionList>
				</GetFreightFeeRequest>';
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
	return $data['GetFreightFeeResponse'];
	}