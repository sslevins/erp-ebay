<?php
/**
 * 在线订单操作测试demo
 * @package
 * @license
 * @author seaqi
 * @contact 980522557@qq.com / xiayouqiao2008@163.com
 * @version $Id: orderonline_test.php 2011-07-20 15:56:00
 */
@session_start();
header ( "content-type:text/html;charset=utf-8" );
@ini_set("soap.wsdl_cache_enabled", "0"); // disabling WSDL cache
set_time_limit(600);


include 'include/dbconnect.php';
$dbcon	= new DBClass();
$user	= $_SESSION['user'];
$ss		= "select token4px from ebay_config WHERE `ebay_user` ='$user' LIMIT 1";
$ss		= $dbcon->execute($ss);
$ss		= $dbcon->getResultArray($ss);
$token = $ss[0]['token4px'];
error_reporting(E_ALL);
//include '4px/OrderOnlineTools.php';
$apiurl = "http://api.4px.com/OrderOnlineService.dll?wsdl";
$soap = new SoapClient($apiurl);
$type = $_REQUEST['type'];
function print_rr($arr){
	echo "<pre>";
	print_r($arr);
	echo "</pre>";
}
$carrier = array(
	'DHL出口'=>'A1',
	'4PX专线优选'=>'AI',
	'4PX标准'=>'A2',
	'4PX专线ARMX'=>'A4',
	'4PX联邮通挂号'=>'A6',
	'4PX联邮通平邮'=>'A7',
	'小包裹美国DHL'=>'A9',
	'新加坡小包挂号'=>'B1',
	'新加坡小包平邮'=>'B2',
	'香港小包挂号'=>'B3',
	'香港小包平邮'=>'B4',
	'中国邮政小包(上海)'=>'B9',
	'中国EMS国际'=>'C1',
	'香港邮政EMS'=>'C2',
	'新加坡EMS'=>'C3',
	'香港空邮包裹'=>'C4',
	'香港邮政美国专线'=>'C5',
	'DHL小包裹特惠'=>'C8',
	'国际海运出口'=>'C7',
	'UPS特惠'=>'D2',
	'香港TNT特惠'=>'D2',
	'DC香港联邦IP'=>'D3',
	'DC香港联邦IE'=>'D4',
	'香港UPS'=>'D5',
	'大陆联邦快递优先型服务IP'=>'D6',
	'大陆联邦快递经济型服务IE'=>'D7',
	'联邮通空邮包裹服务'=>'E2',
	'香港联邦IP'=>'E4',
	'香港联邦IE'=>'E5',
	'香港联邦特惠IP'=>'E6',
	'香港联邦特惠IE'=>'E7',
	'北京小包平邮'=>'E8',
	'北京小包挂号'=>'E9',
	'华南小包平邮'=>'F3',
	'华南小包挂号'=>'F4',
	'新加坡小包挂号特惠'=>'F5',
	'联邦欧美速递袋IP优惠'=>'F8',
	'联邦欧美小包裹IE优惠'=>'F9',
	'4PX香港件'=>'H3',
	'香港TNT出口'=>'H4',
	'新加坡EMS特惠'=>'K9',
	'订单宝普货空运'=>'R1',
	'订单宝海运'=>'R2',
	'海外仓储中转'=>'R3',
	'中国EMS外围'=>'S1',
	'中国小包挂号华东外围'=>'S2',
	'俄罗斯联邮通平邮'=>'AZ'
	);
function checksbjz($orderid){
	global $dbcon,$user;
	$avgsbjz = 0;
	$ouzhou = array('Albanien','Andorra','Belgien','Bosnien und Herzegowina','Bulgarien','Dänemark','Estland','Finnland','Frankreich','Griechenland','Großbritannien','Irland','Island','Italien','Serbien und Montenegro', 'Kroatien','Lettland','Liechtenstein', 'Litauen', 'Luxemburg', 'Makedonien','Malta','Monaco', 'Niederlande','Norwegen', 'Österreich','Polen','Portugal','Rumänien','San Marino', 'Schweden', 'Schweiz die','Slowakei die','Slowenien', 'Spanien','Tschechien','Ungarn','Vatikanstadt');
	$deguo = 'Deutschland';
	$carrier1 = array('DHL出口','新加坡EMS','中国EMS国际','联邦');
	$carrier2 = array('新加坡小包平邮','新加坡小包挂号','香港小包平邮','香港小包挂号','新加坡小包特惠挂号','华南小包平邮','华南小包挂号');
	$carrier3 = array('新加坡小包平邮','新加坡小包挂号','香港小包平邮','香港小包挂号','新加坡小包特惠挂号','华南小包平邮','华南小包挂号','EUB');
	$sql = "select ebay_countryname,ebay_carrier,ebay_ordersn from ebay_order where ebay_id='$orderid'";
	$sql = $dbcon->execute($sql);
	$sql = $dbcon->getResultArray($sql);
	$ordersn = $sql[0]['ebay_ordersn'];
	$carrier = $sql[0]['ebay_carrier'];
	$country	 = $sql[0]['ebay_countryname'];
	$sql = "select sum(a.ebay_amount) as count,sum(a.ebay_amount*b.goods_sbjz) as sbjz from ebay_orderdetail as a join ebay_goods as b on a.sku=b.goods_sn where a.ebay_ordersn='$ordersn'";
	//echo $sql;
	$sql = $dbcon->execute($sql);
	$sql = $dbcon->getResultArray($sql);
	if($sql){
		$goodscount = $sql[0]['count'];
		$sbjz = $sql[0]['sbjz'];
	}else{
		$goodscount = 0;
		$sbjz = 0;
	}
	if($country == $deguo){
		if(in_array($carrier,$carrier1)){
			if($goodscount>=1 && $goodscount<10 && $sbjz>=40){
				$avgsbjz = number_format((40/$goodscount),2);
			}
			if($goodscount>=10 && $goodscount<15 && $sbjz>=55){
				$avgsbjz = number_format((55/$goodscount),2);
			}
			if($goodscount>=15 && $sbjz>=60){
				$avgsbjz = number_format((60/$goodscount),2);
			}
		}
		if(in_array($carrier,$carrier2)){
			if($goodscount>=2 && $goodscount<4 && $sbjz>=18){
				$avgsbjz = number_format((18/$goodscount),2);
			}
			if($goodscount>=4 && $sbjz>=23){
				$avgsbjz = number_format((23/$goodscount),2);
			}
		}
	}elseif(in_array($country,$ouzhou)){
		if(in_array($carrier,$carrier1)){
			if($goodscount>=1 && $goodscount<5 && $sbjz>=30){
				$avgsbjz = number_format((30/$goodscount),2);
			}
			if($goodscount>=5 && $goodscount<10 && $sbjz>=35){
				$avgsbjz = number_format((35/$goodscount),2);
			}
			if($goodscount>=10 && $goodscount<15 && $sbjz>=40){
				$avgsbjz = number_format((40/$goodscount),2);
			}
			if($goodscount>=15 && $sbjz>=60){
				$avgsbjz = number_format((60/$goodscount),2);
			}
		}
		if(in_array($carrier,$carrier3)){
			if($goodscount>=2 && $goodscount<4 && $sbjz>=15){
				$avgsbjz = number_format((15/$goodscount),2);
			}
			if($goodscount>=4 && $sbjz>=20){
				$avgsbjz = number_format((20/$goodscount),2);
			}
		}
	}else{
		if(in_array($carrier,$carrier1)){
			if($goodscount>=1 && $goodscount<10 && $sbjz>=25){
				$avgsbjz = number_format((25/$goodscount),2);
			}
			if($goodscount>=10 && $goodscount<15 && $sbjz>=35){
				$avgsbjz = number_format((35/$goodscount),2);
			}
			if($goodscount>=15 && $sbjz>=60){
				$avgsbjz = number_format((60/$goodscount),2);
			}
		}
		if(in_array($carrier,$carrier3)){
			if($goodscount>=2 && $goodscount<4 && $sbjz>=15){
				$avgsbjz = number_format((15/$goodscount),2);
			}
			if($goodscount>=4 && $sbjz>=20){
				$avgsbjz = number_format((20/$goodscount),2);
			}
		}
	}
	return $avgsbjz;
}


//创建并预报订单
if($type == 'creat'){
	$orderid = substr($_REQUEST['bill'],1);
	$sql = "select * from ebay_order where ebay_id in($orderid)";
	$sql = $dbcon->execute($sql);
	$sql = $dbcon->getResultArray($sql);
	foreach($sql as $key=>$val){
		//$sbjz = checksbjz($val['ebay_id']);
		$arrs = array();
		$countryname = $val['ebay_countryname'];
		$arrs['buyerId'] 		= $val['ebay_userid'];
		$arrs['cargoCode'] 		= 'P';
		$arrs['city'] 			= $val['ebay_city'];
		
		
		$arrs['street'] 		= $val['ebay_street'].' '.$val['ebay_street1'];
		
		$arrs['consigneeCompanyName'] 		= '';
		$arrs['consigneeEmail'] = $val['ebay_usermail'];
		$arrs['consigneeFax'] 	= '';
		$arrs['consigneeName'] 	= $val['ebay_username'];
		$arrs['consigneePostCode'] 			= $val['ebay_postcode'];
		$arrs['consigneeTelephone'] 		= $val['ebay_phone'];
		$arrs['stateOrProvince'] 			= $val['ebay_state'];

		if($val['ebay_couny'] && strlen($val['ebay_couny'])<= 2  ){
			$arrs['destinationCountryCode'] 	= $val['ebay_couny'];
			
			if($val['ebay_couny'] == 'UK') $arrs['destinationCountryCode'] = 'GB';
			
			
			
		}else{
		
			
			
			
			if(count($vv) == 0 ){
				$vv="select * from ebay_countrys where countryen='$countryname' and ebay_user ='$user'";
				$vv = $dbcon->execute($vv);
				$vv = $dbcon->getResultArray($vv);
			
				$arrs['destinationCountryCode'] 	= $vv[0]['countrysn'];
			}
			
			
		}
		$arrs['initialCountryCode'] 		= 'CN';
		$arrs['orderNo'] 					= 'A'.$user.$val['ebay_id'];
		$arrs['orderNote'] 					= $val['ebay_noteb'];
		$arrs['paymentCode'] 				= 'P';

	$arrs['mctCode'] 				= '1';


		if(isset($val['ebay_carrier'])){
			$arrs['productCode'] 				= $carrier[$val['ebay_carrier']];
		}else{
			echo '订单编号:'.$val['ebay_id'].'<font color="red">运输方式错误</font><br>';
			continue;
		}
		
		$arrs['trackingNumber']				= $val['ebay_tracknumber'];
		$arrs['transactionId']				= $val['ebay_tid'];
		$vv = "select * from ebay_carrier where name='".$val['ebay_carrier']."' and ebay_user='$user'";
		$vv = $dbcon->execute($vv);
		$vv = $dbcon->getResultArray($vv);
		if($vv){
		
		if($vv[0]['safetype']){
			$arrs['insurType'] 					= $vv[0]['safetype'];
			$arrs['insurValue'] 				= $val['ebay_total'];
		}
		
		
		if($vv[0]['backtype']=='N'){
			$arrs['returnSign'] 				= 'N';
		}else{
			$arrs['returnSign'] 				= 'Y';
		}
		$arrs['shipperAddress'] 			= $vv[0]['address'];
		$arrs['shipperCompanyName'] 		= $vv[0]['CompanyName'];
		$arrs['shipperName'] 				= $vv[0]['username'];
		$arrs['shipperPostCode'] 			= '';
		$arrs['shipperTelephone'] 			= $vv[0]['tel'];
		
		}
		$vv = "select sku,ebay_amount,notes from ebay_orderdetail where ebay_ordersn='".$val['ebay_ordersn']."'";
		$vv = $dbcon->execute($vv);
		$vv = $dbcon->getResultArray($vv);
		
		
		
		
		$arrs['pieces'] 					= count($vv);
		$goods_weight						= 0;
		
		foreach($vv as $kkk=>$vvv){
			$goods_sn = $vvv['sku'];
			$goods_count = $vvv['ebay_amount'];
			$notes		 = $vvv['notes'];
			
					
					
			$ss = "select goods_location,goods_name,goods_sbjz,goods_ywsbmc,goods_zysbmc,goods_unit,goods_weight from ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
			$ss = $dbcon->execute($ss);
			$ss = $dbcon->getResultArray($ss);
			if(count($ss)>0){


			$goods_location = $ss[0]['goods_location'];
			$sbjz = $ss[0]['goods_sbjz'];
			
			$goods_weight += $ss[0]['goods_weight'];
			
			
			
					
			
			
			$arrs["declareInvoice"][]=array(
						"declareNote" =>$goods_sn.' '.$notes, //配货备注
						"declarePieces" =>$goods_count,//件数(默认: 1)
						"declareUnitCode" =>"PCE",//申报单位类型代码(默认:  PCE)，参照申报单位类型代码表
						"eName" =>$ss[0]['goods_ywsbmc'],//海关申报英文品名
						"name" =>$goods_sn.' '.$ss[0]['goods_zysbmc'].$goods_location,//海关申报中文品名
						"unitPrice" =>$sbjz,//单价 0 < Amount <= [10,2]【***】
				);
			}else{
				$rr			= "select * from ebay_productscombine where ebay_user='$user' and goods_sn='$goods_sn'";
				$rr			= $dbcon->execute($rr);
				$rr 	 	= $dbcon->getResultArray($rr);
				$goods_sncombine	= $rr[0]['goods_sncombine'];
				$goods_sncombine    = explode(',',$goods_sncombine);	
				for($e=0;$e<count($goods_sncombine);$e++){
					$pline			= explode('*',$goods_sncombine[$e]);
					$goods_sns		= $pline[0];
					$goods_counts	= $pline[1]*$goods_count;
					
				
					
		
					$ss = "select goods_location,goods_name,goods_sbjz,goods_ywsbmc,goods_zysbmc,goods_unit,goods_weight from ebay_goods where goods_sn='$goods_sns' and ebay_user='$user'";
					$ss = $dbcon->execute($ss);
					$ss = $dbcon->getResultArray($ss);
					if(count($ss)>0){
						$sbjz = $ss[0]['goods_sbjz'];
						
						$goods_location = $ss[0]['goods_location'];
						$goods_unit = $ss[0]['goods_unit'];
						$goods_weight += $ss[0]['goods_weight'];
						$arrs["declareInvoice"][]=array(
							"declareNote" =>$goods_sns.' '.$notes, //配货备注
							"declarePieces" =>$goods_counts,//件数(默认: 1)
							"declareUnitCode" =>"PCE",//申报单位类型代码(默认:  PCE)，参照申报单位类型代码表
							"eName" =>$ss[0]['goods_ywsbmc'],//海关申报英文品名
							"name" =>$goods_sns.' '.$ss[0]['goods_zysbmc'].$goods_location,//海关申报中文品名
							"unitPrice" =>$sbjz,//单价 0 < Amount <= [10,2]【***】
						);
					}else{
						echo $goods_sns."未找到货品资料<br>";
					}
				}
			}
		}
		
		$arrs['customerWeight'] 			= '';
		
		
	$request = array(
		'arg0'=>$token,
		'arg1'=>$arrs
	);
	print_r($request);
	

	
	$result = $soap->createAndPreAlertOrderService($request);
	
	
	print_r($result);
	if($result->return->ack =='Success'){
		$pxorderid = 'pxx'.$val['ebay_id'];
	//	if(isset($result->trackingNumber)){
			$tracknumber = $result->return->trackingNumber;
		//}else{
			//$tracknumber = '';
		//}
		$time = time();
		$upsql = "update ebay_order set pxorderid='$pxorderid',ebay_tracknumber='$tracknumber',pxordertime='$time' where ebay_id=".$val['ebay_id'];
		
		
		//echo $upsql;
		
		if($dbcon->execute($upsql)){
			echo '订单编号:'.$val['ebay_id']."-<font color='green'>上传并确认成功！</font><br>";
		}else{
			echo '订单编号:'.$val['ebay_id']."-<font color='green'>上传并确认成功！</font><font color='red'>-系统更新数据失败!</font><br>";
		}
	}else{
		//print_rr($result);
		echo '订单编号:'.$val['ebay_id'].'<font color="red">-'.$result->return->errors->cnMessage.'</font><br>';
	}
	}
}
if($type =='search'){
	 $orderid = $_REQUEST['bill'];
	 $orderid = substr($_REQUEST['bill'],1);
	 $orderid = explode(',',$orderid);
	 foreach($orderid as $key=>$val){
		$pxorderid[] = 'pxx'.$val;
	 }
	if($pxorderid){
		 $arrs = array(
			 'orderNo' => $pxorderid,//订单号码【可以同时查询多个】【***】
			 'startTime' => '',//开始时间,默认为创建订单时间结合订单状态(Status)查询
			 'endTime' => '',//结束时间,默认为创建订单时间，结合订单状态(Status)查询
			 'status' => ''//订单状态，参照订单状态表
		 ); 
		$result = $soap->findOrderService($arrs);
		
			echo '<pre>';
			print_r($result);
			echo '</pre>';

	}
}




