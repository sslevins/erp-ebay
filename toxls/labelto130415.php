<?php
@session_start();
error_reporting(0);

$user	= $_SESSION['user'];
include "../include/dbconnect.php";	
date_default_timezone_set ("Asia/Chongqing");
$dbcon	= new DBClass();
require_once '../Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");
							 
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('A1','EPNumber', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('B1','Delivery', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('C1','weight(g)', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('D1','Currency', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('E1','Value', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('F1','中文品名', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('G1','备注', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('H1','多品名', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('I1','Sales Record Number', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('J1','User Id', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('K1','Buyer Fullname', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('L1','Buyer Phone Number', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('M1','Buyer Email', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('N1','Buyer Address 1', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('O1','Buyer Address 2', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('P1','Buyer City', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('Q1','Buyer State', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('R1','Buyer Zip', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('S1','Buyer Country', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('T1','Item Number', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('U1','Item Title', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('V1','Custom Label', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('W1','Quantity', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('X1','Sale Price', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('Y1','Shipping and Handling', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('Z1','US Tax', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AA1','Insurance', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AB1','', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AC1','Total Price', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AD1','Payment Method', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AE1','Sale Date', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AF1','Checkout Date', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AG1','Paid on Date', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AH1','Shipped on Date', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AI1','Feedback left', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AJ1','Feedback received', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AK1','Notes to yourself', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AL1','Listed On', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AM1','Sold On', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AN1','PayPal Transaction ID', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AO1','Shipping Service', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AP1','Transaction ID', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AQ1','Order ID', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AR1','declared value', PHPExcel_Cell_DataType::TYPE_STRING);
	


	
	
	$ertj		= "";
	$orders		= explode(",",$_REQUEST['ordersn']);
	for($g=0;$g<count($orders);$g++){
		$sn 	=  $orders[$g];
		if($sn != ""){
				
					$ertj	.= " a.ebay_id='$sn' or";
		}
			
	}
	$ertj			 = substr($ertj,0,strlen($ertj)-3);
	
	
	if($ertj == ""){
	echo "请选择订单！";
	//$sql	= "select a.*,b.sku,b.ebay_amount from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn = b.ebay_ordersn where ebay_user='$user' and a.ebay_combine!='1' order by a.ebay_username";	
	}else{	
	$sql	= "select a.*,b.sku,b.ebay_amount,b.recordnumber as bre,b.ebay_itemid,b.ebay_itemtitle,b.ebay_itemprice,b.sku,b.shipingfee from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn = b.ebay_ordersn where ($ertj) and a.ebay_user='$user' and a.ebay_combine!='1' order by a.ebay_username";	
	}
	
	
	

	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);
	$a		= 2;
	
	
	$firstname		= '';
	
	for($i=0;$i<count($sql);$i++){

		$name					= $sql[$i]['ebay_username'];
	    $street1				= @$sql[$i]['ebay_street'];
	    $street2 				= @$sql[$i]['ebay_street1'];
	    $city 					= $sql[$i]['ebay_city'];
	    $state					= $sql[$i]['ebay_state'];
	    $countryname 			= $sql[$i]['ebay_countryname'];
		
		
		
		$vv			= "select * from ebay_countrys where countryen='$countryname' and ebay_user ='$user'" ;

		$vv	= $dbcon->execute($vv);
		$vv	= $dbcon->getResultArray($vv);
		
		
		$countrycn			= $vv[0]['countrycn'];
	    $zip					= $sql[$i]['ebay_postcode'];

		$ebay_noteb				= $sql[$i]['ebay_noteb'];
		$sku					= $sql[$i]['sku'];
		$amount					= $sql[$i]['ebay_amount'];
		$pid					= $sql[$i]['ebay_ptid'];
		$ebay_carrier					= $sql[$i]['ebay_carrier'];
		
		$ebay_createdtime					= date('M-y-d',$sql[$i]['ebay_createdtime']);
		$ebay_paidtime						= date('M-y-d',$sql[$i]['ebay_paidtime']);
		
		
		
		
		
		$sku					= $sql[$i]['sku'];
		
		
		$addressline	= $name.chr(13).$street1;
		if($street2 != ''){
				$addressline .= " ".$street2;
		}
		$addressline	.= chr(13);
		
		if($city != ''){
				$addressline .= " ".$city;
		}
		
		
		
		if($state != ''){
				$addressline .= " ".$state;
		}
		if($zip != ''){
				$addressline .= " ".$zip;
		}
		
		
		
		
		$addressline .= chr(13).$countryname;
		
			$ee					= "SELECT * FROM ebay_goods where goods_sn='$sku' and ebay_user='$user'";
			$ee					= $dbcon->execute($ee);
			$ee 			 	= $dbcon->getResultArray($ee);
			$goods_weight		=  $ee[0]['goods_weight'];			
			$goods_sbjz			=  $ee[0]['goods_sbjz'];
			$goods_zysbmc		=  $ee[0]['goods_zysbmc'];
			
			
			
			
			$rr			= "select * from ebay_productscombine where ebay_user='$user' and goods_sn='$sku'";
			$rr			= $dbcon->execute($rr);
			$rr 	 	= $dbcon->getResultArray($rr);

				
			if(count($rr) > 0){
			
									$goods_sncombine	= $rr[0]['goods_sncombine'];
									$goods_sncombine    = explode(',',$goods_sncombine);	
									for($e=0;$e<count($goods_sncombine);$e++){
											$pline			= explode('*',$goods_sncombine[$e]);
											$goods_sn		= $pline[0];
											$goddscount     = $pline[1] * $amount;
											$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('D'.$a, $ebay_carrier, PHPExcel_Cell_DataType::TYPE_STRING);
											$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$a, $addressline, PHPExcel_Cell_DataType::TYPE_STRING);
											$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('L'.$a, $goods_sn, PHPExcel_Cell_DataType::TYPE_STRING);
											$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$a, $goddscount);
											$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('N'.$a, $pit, PHPExcel_Cell_DataType::TYPE_STRING);
											$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('O'.$a, $ebay_noteb, PHPExcel_Cell_DataType::TYPE_STRING);
											$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('B'.$a, $name, PHPExcel_Cell_DataType::TYPE_STRING);
			
			
									}
			}else{
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('B'.$a, $ebay_carrier, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('C'.$a, $goods_weight, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('D'.$a, 1, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$a, $goods_sbjz, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('F'.$a, $goods_zysbmc, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('I'.$a, $sql[$i]['ebay_id'], PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('J'.$a, $sql[$i]['ebay_userid'], PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('K'.$a, $sql[$i]['ebay_username'], PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('L'.$a, $sql[$i]['ebay_phone'], PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('M'.$a, $sql[$i]['ebay_usermail'], PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('N'.$a, $sql[$i]['ebay_street'], PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('O'.$a, $sql[$i]['ebay_street1'], PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('P'.$a, $sql[$i]['ebay_city'], PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('Q'.$a, $sql[$i]['state'], PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('R'.$a, $sql[$i]['ebay_postcode'], PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('S'.$a, $countrycn, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('T'.$a, $sql[$i]['ebay_itemid'], PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('U'.$a, $sql[$i]['ebay_itemtitle'], PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('V'.$a, $sql[$i]['sku'], PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('W'.$a, $sql[$i]['ebay_amount'], PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('X'.$a, '$'.$sql[$i]['ebay_itemprice'], PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('Y'.$a, '$'.$sql[$i]['shipingfee'], PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('Z'.$a, '$0.00', PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AA'.$a, '$0.00', PHPExcel_Cell_DataType::TYPE_STRING);
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AC'.$a, '$'.($sql[$i]['ebay_itemprice'] * $sql[$i]['ebay_amount']), PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AD'.$a, 'Paypal', PHPExcel_Cell_DataType::TYPE_STRING);
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AE'.$a, $ebay_createdtime, PHPExcel_Cell_DataType::TYPE_STRING);
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AF'.$a, $ebay_createdtime, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AG'.$a, $ebay_paidtime, PHPExcel_Cell_DataType::TYPE_STRING);




			
			
			
			
			
			
			
			
			}
		


		$firstname	= $name;
		$a++;
		
		
		


		
			
	
	

}
$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:O500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:O2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet(0)->getStyle('E1:E1000')->getAlignment()->setWrapText(true);

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(10);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(10);	

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(10);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(10);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(30);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(10);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(10);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth(10);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setWidth(10);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setWidth(15);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('K')->setWidth(15);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('L')->setWidth(12);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('M')->setWidth(12);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('O')->setWidth(12);

//$objPHPExcel->getActiveSheet(0)->getStyle('A1:O1000')->getAlignment()->setWrapText(true);




$title		= "燕文EbayExpress.xls".date('Y-m-d');
$titlename		= "燕文EbayExpress.xls".date('Y-m-d').".xls";

$objPHPExcel->getActiveSheet()->setTitle($title);

$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename={$titlename}");
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;


