<?php
@session_start();
error_reporting(0);
$user	= $_SESSION['user'];
$status			= $_REQUEST['status'];
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

	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '单位名称');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '姓名');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '电话');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '传真');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', '移动电话');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', '邮件');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', '所属城市');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', '地址');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', '备注');
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', '网址');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', '开户行');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', '开户名');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', '帐号');
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', 'QQ');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1', '供应商代码');
	

	         
	
	$ertj		= "";

	$orders		= explode(",",$_REQUEST['id']);

	for($g=0;$g<count($orders);$g++){

		$sn 	=  $orders[$g];

		if($sn != ""){

				

					$ertj	.= " id='$sn' or";

		}

			

	}

	$ertj			 = substr($ertj,0,strlen($ertj)-3);


	
	if($_REQUEST['id'] != ''){
	$sql	= "select * from ebay_partner  where ($ertj) ";
	}else{
	
	$sql	= "select * from ebay_partner  where ebay_user ='$user' and status ='$status' ";
	}
		
	


	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);
	$a		= 2;	

	for($i=0;$i<count($sql);$i++){
		

		$company_name		= $sql[$i]['company_name'];
		$username			= $sql[$i]['username'];
		$tel				= $sql[$i]['tel'];
		$mobile				= $sql[$i]['mobile'];
		$fax				= $sql[$i]['fax'];
		$mail				= $sql[$i]['mail'];
		$address			= $sql[$i]['address'];
		$note				= $sql[$i]['note'];
		$city				= $sql[$i]['city'];
		
		$url							= $sql[$i]['url'];
		$bankaccountaddress				= $sql[$i]['bankaccountaddress'];
		$bankaccountname				= $sql[$i]['bankaccountname'];
		$bankaccountnumber				= $sql[$i]['bankaccountnumber'];
		
		$code							= $sql[$i]['code'];
		$QQ								= $sql[$i]['QQ'];
		
		
		
		$objPHPExcel->setActiveSheetIndex(0)->getCell('A'.$a)->setValueExplicit($company_name, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('B'.$a)->setValueExplicit($username, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('C'.$a)->setValueExplicit($tel, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('D'.$a)->setValueExplicit($fax, PHPExcel_Cell_DataType::TYPE_STRING);
		
		$objPHPExcel->setActiveSheetIndex(0)->getCell('E'.$a)->setValueExplicit($mobile, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('F'.$a)->setValueExplicit($mail, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('G'.$a)->setValueExplicit($city, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('H'.$a)->setValueExplicit($address, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('I'.$a)->setValueExplicit($note, PHPExcel_Cell_DataType::TYPE_STRING);
		
		$objPHPExcel->setActiveSheetIndex(0)->getCell('J'.$a)->setValueExplicit($url, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('K'.$a)->setValueExplicit($bankaccountaddress, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('L'.$a)->setValueExplicit($bankaccountname, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('M'.$a)->setValueExplicit($bankaccountnumber, PHPExcel_Cell_DataType::TYPE_STRING);
		
		$objPHPExcel->setActiveSheetIndex(0)->getCell('N'.$a)->setValueExplicit($QQ, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('O'.$a)->setValueExplicit($code, PHPExcel_Cell_DataType::TYPE_STRING);
		
		
		
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







$title		= "Partner".date('Y-m-d');
$titlename		= "Partner".date('Y-m-d').".xls";
$objPHPExcel->getActiveSheet()->setTitle($title);
$objPHPExcel->setActiveSheetIndex(0);




// Redirect output to a client’s web browser (Excel5)

header('Content-Type: application/vnd.ms-excel');

header("Content-Disposition: attachment;filename={$titlename}");

header('Cache-Control: max-age=0');



$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

$objWriter->save('php://output');

exit;





