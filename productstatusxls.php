<?php
include "include/dbconnect.php";	
date_default_timezone_set ("Asia/Chongqing");	
set_time_limit(0);
$dbcon	= new DBClass();
error_reporting(0);
@session_start();
$user	= $_SESSION['user'];
require_once 'Classes/PHPExcel.php';
$cpower	= explode(",",$_SESSION['power']);

	$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");

	$c		= 2;
												 


	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '编号');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '产品状态');
	
	
	
	
	$sql	= "select * from ebay_goodsstatus where  ebay_user='$user' ";
	

	
	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);
	
	for($i=0;$i<count($sql);$i++){

				
			
			$aa	= 'A'.$c;
			$bb	= 'B'.$c;
			
			$sn				= $sql[$i]['id'];	
			$name				= $sql[$i]['status'];
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($aa, $sn);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($bb, $name);
			
					
				
			$c++;
			
			
				
	
	}

	$title		= "Products-status-".date('Y')."-".date('m')."-".date('d').".xls";
	
	
	$objPHPExcel->getActiveSheet()->setTitle($title);
	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	// Redirect output to a client’s web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
	header("Content-Disposition: attachment;filename={$title}");
	header('Cache-Control: max-age=0');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;

?>
