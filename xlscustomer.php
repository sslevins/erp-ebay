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

	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '姓名');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '邮件');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '客户电话');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '所在国家');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', '总购买金额');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', '总购买次数');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', '客户id');
	
	$ebay_account	= $_REQUEST['ebay_account'];
	
	$start		= strtotime($_REQUEST['start'].' 00:00:00');
$end		= strtotime($_REQUEST['end'].' 23:59:59');
			$ertj		= "";

			$orders		= explode(",",$_REQUEST['customerid']);
			
			
			for($g=0;$g<count($orders);$g++){
				$sn 	=  $orders[$g];
				if($sn != ""){
					$ertj	.= " ebay_id='$sn' or";
				}
			}

	$ertj			 = substr($ertj,0,strlen($ertj)-3);
	$sql		= "SELECT ebay_username,ebay_id, COUNT( * ) AS cc, SUM( ebay_total ) as total,ebay_countryname,ebay_phone,ebay_usermail,ebay_account,ebay_userid FROM ebay_order where ebay_user='$user' ";		
	
	if($_REQUEST['start'] != '' && $_REQUEST['end'] != ''){
		
			
			$sql.= " and ( ebay_createdtime>=$start and ebay_createdtime<=$end )";
			
		
	}
	
	
	
	if($_REQUEST['customerid'] != '') $sql .= " and ($ertj)";
	if($ebay_account != '' ) $sql .= " and ebay_account='$ebay_account' ";
	
	$sql		.= " GROUP BY ebay_username ORDER BY  `total` desc ";

	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);
	$a		= 2;	

	for($i=0;$i<count($sql);$i++){
		
			
			 $ebay_username		= $sql[$i]['ebay_username'];
						 $ebay_id			= $sql[$i]['ebay_id'];
						 $ebay_usermail			= $sql[$i]['ebay_usermail'];
						$ebay_phone			= $sql[$i]['ebay_phone'];
						$cc			= $sql[$i]['cc'];
						$total			= $sql[$i]['total'];
						$ebay_countryname			= $sql[$i]['ebay_countryname'];
						$ebay_account			= $sql[$i]['ebay_account'];
		$ebay_userid			= $sql[$i]['ebay_userid'];
			$objPHPExcel->setActiveSheetIndex(0)->getCell('A'.$a)->setValueExplicit($ebay_username, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('B'.$a)->setValueExplicit($ebay_usermail, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('C'.$a)->setValueExplicit($ebay_phone, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('D'.$a)->setValueExplicit($ebay_countryname, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('E'.$a)->setValueExplicit($total, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('F'.$a)->setValueExplicit($cc, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('G'.$a)->setValueExplicit($ebay_userid, PHPExcel_Cell_DataType::TYPE_STRING);
			

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







$title		= "Customer_".date('Y-m-d');
$titlename		= "Customer_".date('Y-m-d').".xls";


$objPHPExcel->getActiveSheet()->setTitle($title);



$objPHPExcel->setActiveSheetIndex(0);





// Redirect output to a client’s web browser (Excel5)

header('Content-Type: application/vnd.ms-excel');

header("Content-Disposition: attachment;filename={$titlename}");

header('Cache-Control: max-age=0');



$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

$objWriter->save('php://output');

exit;





