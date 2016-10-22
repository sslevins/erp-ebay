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
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', ' Date');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', ' SKU');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', ' Quantity');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', ' Name');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', ' Address Line 1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', ' Address Line 2');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', ' Town/City');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', ' State/County/');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', ' Postcode');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', ' County');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', ' Postage Service');


	
	
									

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
	$date   = date("Y-m-d H:i");
	for($i=0;$i<count($sql);$i++){
		
		$ordersn				= $sql[$i]['ebay_ordersn'];	
		$paidtime				= date('Y-m-d',$sql[$i]['ebay_paidtime']);
		$name					= $sql[$i]['ebay_username'];
	    $street1				= @$sql[$i]['ebay_street'];
	    $street2 				= @$sql[$i]['ebay_street1'];
	    $city 					= $sql[$i]['ebay_city'];
	    $state					= $sql[$i]['ebay_state'];
	    $countryname 			= $sql[$i]['ebay_countryname'];
	    $zip					= $sql[$i]['ebay_postcode'];

		$ebay_carrier			= @$sql[$i]['ebay_carrier'];
		
		
		
		
		
		
		$sl				= "select sku,ebay_amount from ebay_orderdetail where ebay_ordersn='$ordersn'";
		$sl				= $dbcon->execute($sl);
		$sl				= $dbcon->getResultArray($sl);
		
		for($o=0;$o<count($sl);$o++){					
			$sku					= $sl[$o]['sku'];	
			$amount					= $sl[$o]['ebay_amount'];

			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('A'.$a, $date, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('B'.$a, $sku, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('C'.$a, $amount, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('D'.$a, $name, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$a, $street1, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('F'.$a, $street2, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('G'.$a, $city, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('H'.$a, $state, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('I'.$a, $zip, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('J'.$a, $countryname, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('L'.$a, $ebay_carrier, PHPExcel_Cell_DataType::TYPE_STRING);
			$a++;
		}
		
		

		
		
		
		



		
			
	
	

}
$objPHPExcel->getActiveSheet(0)->getStyle('A1:N500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(25);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(15);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(15);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(15);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(15);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(30);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(30);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(15);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(15);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth(15);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setWidth(15);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setWidth(15);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('L')->setWidth(20);

$objPHPExcel->getActiveSheet(0)->getStyle('A1:M500')->getAlignment()->setWrapText(true);




$title		= "store1".date('Y-m-d');
$titlename		= "store1".date('Y-m-d').".xls";

$objPHPExcel->getActiveSheet()->setTitle($title);

$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename={$titlename}");
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;


