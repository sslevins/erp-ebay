<?php
@session_start();
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

	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'eBay帐号');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '产品编号');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '产品名称');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '产品数量');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', '产品售价');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', '产品成本');
	
	
	$start			= strtotime($_REQUEST['startdate']." 00:00:00");
	$enddate		= strtotime($_REQUEST['enddate']." 23:59:59");
	$account		= $_REQUEST['account'];
	
	$ss				= "SELECT sku, COUNT( * ) AS cc,SUM( ebay_amount) as tt ,ebay_itemtitle from ebay_orderdetail as b join ebay_order as a on b.ebay_ordersn = a.ebay_ordersn where a.ebay_createdtime>=$start and (a.ebay_createdtime<=$enddate) and a.ebay_account='$account' GROUP BY b.sku";
	


	$sql	= $dbcon->execute($ss);
	$sql	= $dbcon->getResultArray($sql);
	$a		= 2;	

	for($i=0;$i<count($sql);$i++){
		

	
			
			$sku				= $sql[$i]['sku'];
			$ebay_itemtitle		= $sql[$i]['ebay_itemtitle'];
			$tt					= $sql[$i]['tt'];
			
			$dd					= "select * from ebay_goods where ebay_user='$user' and goods_sn='$sku'";

			
			$dd					= $dbcon->execute($dd);
			$dd					= $dbcon->getResultArray($dd);
			$goods_price		= @$dd[0]['goods_price'];
			$goods_cost			= @$dd[0]['goods_cost'];
		
			
			
			$objPHPExcel->setActiveSheetIndex(0)->getCell('A'.$a)->setValueExplicit($account, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('B'.$a)->setValueExplicit($sku, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('C'.$a)->setValueExplicit($ebay_itemtitle, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('D'.$a)->setValueExplicit($tt, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('E'.$a)->setValueExplicit($goods_price, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('E'.$a)->setValueExplicit($goods_cost, PHPExcel_Cell_DataType::TYPE_STRING);
			
		
			$a++;


	



}

$objPHPExcel->getActiveSheet(0)->getStyle('A1:N500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(15);	

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(20);	

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(20);	

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(20);

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(15);

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(50);

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(32);

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth(35);







/*

$objDrawing = new PHPExcel_Worksheet_Drawing();

$objDrawing->setName('PHPExcel logo');

$objDrawing->setDescription('PHPExcel logo');

$objDrawing->setPath('20110218091244858.jpg');

$objDrawing->setHeight(66);

$objDrawing->setCoordinates('D24');

$objDrawing->setOffsetX(10);

$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());





$objDrawing = new PHPExcel_Worksheet_Drawing();

$objDrawing->setName('PHPExcel logo');

$objDrawing->setDescription('PHPExcel logo');

$objDrawing->setPath('20110218091244858.jpg');

$objDrawing->setHeight(66);

$objDrawing->setCoordinates('D25');

$objDrawing->setOffsetX(10);

$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());





*/







$title		= "Sales".date('Y-m-d');

$titlename		= "Sales".date('Y-m-d').".xls";



$objPHPExcel->getActiveSheet()->setTitle($title);



$objPHPExcel->setActiveSheetIndex(0);





// Redirect output to a client’s web browser (Excel5)

header('Content-Type: application/vnd.ms-excel');

header("Content-Disposition: attachment;filename={$titlename}");

header('Cache-Control: max-age=0');



$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

$objWriter->save('php://output');

exit;





