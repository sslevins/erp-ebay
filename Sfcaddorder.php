<?php 
include "include/config.php";
include "top.php";
$orderid = substr($_REQUEST['bill'],1);
$type = $_REQUEST['type'];
$printtype = $_REQUEST['printtype'];

if($type=='creat'){
	$sql 		= "select * from ebay_order where ebay_id in ($orderid)";
	$sql		= $dbcon->execute($sql);
	$sql		= $dbcon->getResultArray($sql);
	$orderinfo = array();
	foreach($sql as $key=>$val){
		$isnot = 0;
		$account	= $val['ebay_account'];
		$ss = "select appname from ebay_account where ebay_account='$account' and ebay_user='$user'";
		$ss		= $dbcon->execute($ss);
		$ss		= $dbcon->getResultArray($ss);
		$appname = $ss[0]['appname'];
		$orderinfo['customerOrderNo'] = $appname.$val['recordnumber'];
		$orderinfo['shipperAddressType'] = 2;
		$carrier		= $val['ebay_carrier'];
		$ss = "select * from ebay_carrier where name='$carrier' and ebay_user='$user'";
		//echo $ss;
		$ss		= $dbcon->execute($ss);
		$ss		= $dbcon->getResultArray($ss);
		$orderinfo['shipperName'] 		= $ss[0]['username'];
		$orderinfo['shipperEmail'] 		= $ss[0]['email'];
		$orderinfo['shipperAddress'] 	= $ss[0]['address'];
		$orderinfo['shipperZipCode'] 	= $ss[0]['zip'];
		$orderinfo['shippingMethod'] 	= $ss[0]['stnames'];
		
		
		
				if($val['ebay_countryname'] == 'Croatia, Republic of'){
		
		$orderinfo['recipientCountry'] 	= 'Croatia';
		
		}else if($val['ebay_countryname'] == 'España'){
		
		$orderinfo['recipientCountry'] 	= 'Spain';
		
		
		}else if($val['ebay_countryname'] == 'Deutschland'){
		
		$orderinfo['recipientCountry'] 	= 'Germany';
		}else{
		$orderinfo['recipientCountry'] 	= $val['ebay_countryname'];
		
		}
		
		
		

		
		
	
		$isadd= 0;
		
		if(strlen($val['ebay_username']) >= 35){
		
		$isadd= 1;
		
		
		$orderinfo['recipientAddress'] 	= substr($val['ebay_username'],30).$val['ebay_street'].' '.$val['ebay_street1'];
		
		
		$orderinfo['recipientName']	   	= substr($val['ebay_username'],0,30);
		}else{
		
		$orderinfo['recipientName']	   	= $val['ebay_username'];
		$orderinfo['recipientAddress'] 	= $val['ebay_street'].' '.$val['ebay_street1'];
		
		}
		
		
		
		
		if(strlen($val['ebay_phone']) >= 20){
		
		$orderinfo['recipientAddress'] 	= '(Tel:'.$val['ebay_phone'].')'.$val['ebay_street'].' '.$val['ebay_street1'];
		
		if($isadd == 1) $orderinfo['recipientAddress'] 	= substr($val['ebay_username'],30).'(Tel:'.$val['ebay_phone'].')'.$val['ebay_street'].' '.$val['ebay_street1'].$val['ebay_phone'];
		}else{
		
		$orderinfo['recipientPhone'] 	= $val['ebay_phone'];
		}
		
		
		
		
		
		$orderinfo['recipientState'] 	= $val['ebay_state'];
		$orderinfo['recipientCity'] 	= $val['ebay_city'];
		$orderinfo['recipientZipCode'] 	= $val['ebay_postcode'];
		
		$orderinfo['recipientEmail'] 	= $val['ebay_usermail'];
		$ss = "select sku,ebay_amount from ebay_orderdetail where ebay_ordersn = '".$val['ebay_ordersn']."'";
		$ss		= $dbcon->execute($ss);
		$ss		= $dbcon->getResultArray($ss);
		$orderinfo['goodsQuantity']   = count($ss);
		$a = 0;
		$goodsdetail = array();
		$skus = '';
		$allsbjz = 0;
		$allnumber = 0;
		foreach($ss as $k=>$v){
			$skus .= $v['sku'].',';
			$allnumber += $v['ebay_amount'];
			$gsql = "select goods_name,goods_sbjz,goods_ywsbmc,goods_weight,goods_zysbmc from ebay_goods where goods_sn='".$v['sku']."' and ebay_user='$user'";
			$gsql		= $dbcon->execute($gsql);
			$gsql		= $dbcon->getResultArray($gsql);
			if(count($gsql)>0){
				$goodsdetail[$a]['detailDescription'] = $gsql[0]['goods_ywsbmc'];
				$goodsdetail[$a]['detailDescriptionCN'] = $gsql[0]['goods_zysbmc'];
				$goodsdetail[$a]['detailQuantity'] 	  = $v['ebay_amount'];			
				if(($k+1)== count($ss)){
					$goodsdetail[$a]['detailCustomLabel'] = '('.$v['sku'].','.$gsql[0]['goods_name'].')*'.$v['ebay_amount'].'; T'.$allnumber;
				}else{
					$goodsdetail[$a]['detailCustomLabel'] = '('.$v['sku'].','.$gsql[0]['goods_name'].')*'.$v['ebay_amount'].';';
				}
				$goodsdetail[$a]['detailWorth'] 	 = $gsql[0]['goods_sbjz'];
				$goodsdetail[$a]['detailWeight'] 	 = $gsql[0]['goods_weight'];
				$allsbjz = $allsbjz + ($v['ebay_amount']*$gsql[0]['goods_sbjz']);
				$a++;
			}else{
				$gsql = "select goods_sncombine from ebay_productscombine where goods_sn='".$v['sku']."' and ebay_user='$user'";
				$gsql		= $dbcon->execute($gsql);
				$gsql		= $dbcon->getResultArray($gsql);
				if(count($gsql)>0){
					$goods_sncombine	= $gsql[0]['goods_sncombine'];
					$goods_sncombine    = explode(',',$goods_sncombine);	
					for($e=0;$e<count($goods_sncombine);$e++){
						$pline			= explode('*',$goods_sncombine[$e]);
						$goods_sn		= $pline[0];
						$goddscount     = $pline[1] * $v['ebay_amount'];
						$pgsql			= "select goods_name,goods_sbjz,goods_ywsbmc,goods_weight,goods_zysbmc from ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
						$pgsql			= $dbcon->execute($pgsql);
						$pgsql			= $dbcon->getResultArray($pgsql);
						$goodsdetail[$a]['detailDescription'] = $pgsql[0]['goods_ywsbmc'];
						$goodsdetail[$a]['detailDescriptionCN'] = $pgsql[0]['goods_zysbmc'];
						$goodsdetail[$a]['detailQuantity'] 	  = $goddscount;
						if(($k+1)== count($ss)){
						if(($e+1) == count($goods_sncombine)){
							$goodsdetail[$a]['detailCustomLabel'] = '('.$goods_sn.'*'.$pline[1].','.$pgsql[0]['goods_name'].')*'.$v['ebay_amount'].'; T'.$allnumber;
						}else{
							$goodsdetail[$a]['detailCustomLabel'] = '('.$goods_sn.'*'.$pline[1].','.$pgsql[0]['goods_name'].')*'.$v['ebay_amount'].';';
						}
						}else{
							$goodsdetail[$a]['detailCustomLabel'] = '('.$goods_sn.'*'.$pline[1].','.$pgsql[0]['goods_name'].')*'.$v['ebay_amount'].';';
						}
						$goodsdetail[$a]['detailWorth'] 	 = $pgsql[0]['goods_sbjz'];
						$goodsdetail[$a]['detailWeight'] 	 = $pgsql[0]['goods_weight'];
						$allsbjz = $allsbjz + ($goddscount*$pgsql[0]['goods_sbjz']);
						$a++;
					}
				}else{
					$isnot = 1;
				}
			}
		}
		if($isnot){
			echo '订单编号:'.$val['ebay_id'].'中sku:'.$v['sku'].'未找到货品资料<br>';
			continue;
		}else{
		$orderinfo['goodsDescription'] = $skus;
		$orderinfo['goodsDeclareWorth'] =  $allsbjz + 3;
		$orderinfo['orderStatus']		= 'sumbmitted';
		$orderinfo['evaluate']			= $allsbjz + 3;
		$orderinfo['goodsDetails'] = $goodsdetail;
		$client=new SoapClient('http://www.sendfromchina.com/ishipsvc/web-service?wsdl'); 
		try{ 
		$parameter = array( 
				'HeaderRequest' => array( 
				'appKey' => $stapikey, 
				'token' => $stapitoken, 
				'userId' => $stuserID
				)
			); 
		//echo'<pre>';
		$parameter['addOrderRequestInfo'] = $orderinfo;
		//调用getCountries 
	//	print_r($parameter);
	//	exit;
		$result=$client->addOrder($parameter);
		
		print_r($result);
		if($result->orderActionStatus == 'Y'){
			$upsql = "update ebay_order set ebay_tracknumber='".$result->orderCode."' where ebay_id=".$val['ebay_id'];
			if($dbcon->execute($upsql)){
				echo '订单编号:'.$val['ebay_id'].'上传成功！<br>';
			}
		}else{
			echo '订单编号:'.$val['ebay_id'].'上传失败！原因：'.$result->note.'<br>';
		}
		}catch(SoapFault$e){ 
		print"Sorry an error was caught executing your request:{$e->getMessage()}"; 
		}

		}
	}
}elseif($type=='print'){
	$sql 		= "select ebay_tracknumber from ebay_order where ebay_id = ".$_REQUEST['bill'];
	$sql		= $dbcon->execute($sql);
	$sql		= $dbcon->getResultArray($sql);
	$url = 'http://www.sendfromchina.com/api/label?orderCodeList='.$sql[0]['ebay_tracknumber'].'&printType='.$printtype;
	//echo $url;
	echo "<script> location.href ='".$url."'; </script>";
}
?> 