<?php
@session_start();
error_reporting(0);

$user	= $_SESSION['user'];
include "include/dbconnect.php";	
date_default_timezone_set ("Asia/Chongqing");	
$dbcon	= new DBClass();
require_once 'Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '订单编号');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '收件人');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '地址');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '品名(英文)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', '申报价值');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', '运输方式');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', '账号');


	
	
									

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
	
	$sql	= "select * from ebay_order as a where ebay_user='$user' and a.ebay_status='1' and a.ebay_combine!='1' ";	
	}else{	
	$sql	= "select * from ebay_order as a where ($ertj) and ebay_user='$user' and a.ebay_combine!='1' ";	
	}	

		
	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);
	$a		= 2;
	
	for($i=0;$i<count($sql);$i++){
		
		$ordersn				= $sql[$i]['ebay_ordersn'];	
		$paidtime				= date('Y-m-d',$sql[$i]['ebay_paidtime']);
		$ebay_id				= $sql[$i]['ebay_id'];	
		

		
		
		
		$ebay_usermail			= $sql[$i]['ebay_usermail'];
		$ebay_userid			= $sql[$i]['ebay_userid'];	
		$name					= $sql[$i]['ebay_username'];
	    $street1				= @$sql[$i]['ebay_street'];
	    $street2 				= @$sql[$i]['ebay_street1'];
	    $city 					= $sql[$i]['ebay_city'];
	    $state					= $sql[$i]['ebay_state'];
	    $countryname 			= $sql[$i]['ebay_countryname'];
	    $zip					= $sql[$i]['ebay_postcode'];
	    $tel					= $sql[$i]['ebay_phone'];
		$ebay_shipfee			= $sql[$i]['ebay_shipfee'];
		$ebay_note				= $sql[$i]['ebay_note'];
		$ebay_total				= @$sql[$i]['ebay_total'];
		$ebay_tracknumber		= @$sql[$i]['ebay_tracknumber'];
		$ebay_account			= @$sql[$i]['ebay_account'];
		$recordnumber0			= @$sql[$i]['recordnumber'];
		$ebay_carrier			= @$sql[$i]['ebay_carrier'];
		$ebay_phone				= $sql[$i]['ebay_phone'];
		$ebay_currency			= $sql[$i]['ebay_currency'];
		
		
		
		
		
		
		$reference				= $recordnumber0;
		

		$addressline	= $street1;
		if($street2 != ''){
			
				$addressline .= ",".$street2;
		}
		
		if($city != ''){
			
				$addressline .= ",".$city;
		}
		
		if($state != ''){
			
				$addressline .= ",".$state.",".$zip.",".$countryname;
		}
		
		
		
		
		
		$sl				= "select * from ebay_orderdetail where ebay_ordersn='$ordersn'";
		$sl				= $dbcon->execute($sl);
		$sl				= $dbcon->getResultArray($sl);

		$qty			= 0;
		$tprice			= 0;
		$labelstr		= '';
		$skustr		= '';
		$strstr2	= '';
		for($o=0;$o<count($sl);$o++){					
			$recordnumber			= $sl[$o]['recordnumber'];	
			$sku1					= $sl[$o]['sku'];	
			$sku					= $sl[$o]['ebay_itemtitle'];
			$amount					= $sl[$o]['ebay_amount'];
			
			$sq3	= "select * from ebay_goods where goods_sn='$sku1' and ebay_user='$user'";
		
			
			$sq3	= $dbcon->execute($sq3);
			$sq3	= $dbcon->getResultArray($sq3);
			$goods_name = $sq3[0]['goods_name'];
			
			
			
			
			$goods_ywsbmc = $sq3[0]['goods_ywsbmc'];
			$goods_sbjz = $sq3[0]['goods_sbjz'];
			
			$skustr				.= $goods_ywsbmc.' ';
			$strstr2			+= ($goods_sbjz*$amount);
			
			
			
			
		}
		
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('A'.$a, $ebay_id, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('B'.$a, $name, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('C'.$a, $addressline, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('D'.$a, $skustr, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$a, $strstr2, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('F'.$a, $ebay_carrier, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('G'.$a, $ebay_account, PHPExcel_Cell_DataType::TYPE_STRING);
		
		
		
		



		$a++;
			
	
	

}
$objPHPExcel->getActiveSheet(0)->getStyle('A1:N500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(10);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(20);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(25);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(25);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(15);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(15);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(15);

$objPHPExcel->getActiveSheet(0)->getStyle('A1:M500')->getAlignment()->setWrapText(true);




$title		= "Files_FHQD".date('Y-m-d');
$titlename		= "Files_FHQD".date('Y-m-d').".xls";

$objPHPExcel->getActiveSheet()->setTitle($title);

$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename={$titlename}");
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;


