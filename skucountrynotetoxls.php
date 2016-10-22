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
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'sku');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '国家');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '备注');				
	if($_REQUEST['bill']){
	$ids		= substr($_REQUEST['bill'],1);
	$ids		= explode(',',$ids);
	$ids		= implode("','",$ids);
	}else{
	$ids = '';
	}
	if($ids != ""){
	
	$sql	= "select * from ebay_skucountrynote where id in ('$ids') ";	
	}else{	
	$sql	= "select * from ebay_skucountrynote where ebay_user='$user' ";	
	}	

		
	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);
	$a		= 2;
	
	for($i=0;$i<count($sql);$i++){
		
		$sku				= $sql[$i]['sku'];	
		$country				= $sql[$i]['country'];
		$note			= $sql[$i]['note'];
		
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('A'.$a, $sku, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('B'.$a, $country, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('C'.$a, $note, PHPExcel_Cell_DataType::TYPE_STRING);
		
		
		
		



		$a++;
			
	
	

}
$objPHPExcel->getActiveSheet(0)->getStyle('A1:N500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(15);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(15);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(45);	

$objPHPExcel->getActiveSheet(0)->getStyle('A1:C500')->getAlignment()->setWrapText(true);




$title		= "skucountrynote".date('Y-m-d');
$titlename		= "skucountrynote".date('Y-m-d').".xls";

$objPHPExcel->getActiveSheet()->setTitle($title);

$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename={$titlename}");
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;


