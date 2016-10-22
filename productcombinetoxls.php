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

	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '产品编号');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '组合产品编码');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '备注');

	
	$sql = "select * from  ebay_productscombine where ebay_user='$user'";	
	$keys		= trim($_REQUEST['keys']);
	if($keys != '') $sql	.= " and (goods_sn like '%$keys%' or  goods_sncombine like '%$keys%' or notes like '%$keys%') ";
					


	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);
	$a		= 2;	

	for($i=0;$i<count($sql);$i++){
		

		$id							= $sql[$i]['id'];
		$goods_sn					= $sql[$i]['goods_sn'];						
		$goods_sncombine			= $sql[$i]['goods_sncombine'];
		$notes						= $sql[$i]['notes'];
				
		$objPHPExcel->setActiveSheetIndex(0)->getCell('A'.$a)->setValueExplicit($goods_sn, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('B'.$a)->setValueExplicit($goods_sncombine, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('C'.$a)->setValueExplicit($notes, PHPExcel_Cell_DataType::TYPE_STRING);
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







$title		= "Address".date('Y-m-d');

$titlename		= "Address".date('Y-m-d').".xls";



$objPHPExcel->getActiveSheet()->setTitle($title);



$objPHPExcel->setActiveSheetIndex(0);





// Redirect output to a client’s web browser (Excel5)

header('Content-Type: application/vnd.ms-excel');

header("Content-Disposition: attachment;filename={$titlename}");

header('Cache-Control: max-age=0');



$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

$objWriter->save('php://output');

exit;





