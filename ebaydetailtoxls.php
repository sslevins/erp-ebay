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
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', ' 序号');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', ' eBay账号');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', ' 费用日期 时间');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', ' 费用类型');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', ' 费用描述');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', ' 物品标题');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', ' Item Number');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', ' 售出金额');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', ' 费用金额');
		 						
				
				$accounts		= $_REQUEST['account'];
	$start			= $_REQUEST['start'];
	$end			= $_REQUEST['end'];
	$keys			= $_REQUEST['keywords'];
	
				

				$sql	= "select * from ebay_fee where user='$user' ";
				
				if($keys != ""){
					$sql.=" and (feetype like '%$keys%' or feetdescription  like '%$keys%' or title like '%$keys%' or itemid like '%$keys%' or account like '%$keys%')";
				}
				
				if($accounts != '' ) $sql.= " and account = '$accounts' ";
				if($start != '' && $end != ''){
				
					$st00	= strtotime($start." 00:00:00");
					$st11	= strtotime($end." 23:59:59");
					$sql	.= " and (feeddate1	>=$st00 and feeddate1	<=$st11)";
				}
				
				
				
				$sql	.=" order by feedate desc";

	
		
	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);
	$a		= 2;
	$date   = date("Y-m-d H:i");
	for($i=0;$i<count($sql);$i++){
		
		$account				= $sql[$i]['account'];	
		$paidtime				= date('Y-m-d',$sql[$i]['ebay_paidtime']);
		$feedate				= $sql[$i]['feedate'];
		$feetype				= $sql[$i]['feetype'];	
		$feetdescription		= $sql[$i]['feetdescription'];	
		$title					= $sql[$i]['title'];	
		$itemid					= $sql[$i]['itemid'];	
		$feeamount				= $sql[$i]['feeamount'];	
		
		
		
		$vv  	= "select ebay_itemprice from ebay_orderdetail where ebay_itemid ='$itemid'";
		$vv		= $dbcon->execute($vv);
		$vv		= $dbcon->getResultArray($vv);
		
		$ebay_itemprice			= $vv[0]['ebay_itemprice'];
		
		
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('A'.$a, $i+1, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('B'.$a, $account, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('C'.$a, $feedate, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('D'.$a, $feetype, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$a, $feetdescription, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('F'.$a, $title, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('G'.$a, $itemid, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('I'.$a, $feeamount, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('H'.$a, $ebay_itemprice, PHPExcel_Cell_DataType::TYPE_STRING);
		
		
		$a++;
		
	
	

}
$objPHPExcel->getActiveSheet(0)->getStyle('A1:N500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(5);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(15);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(20);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(15);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(15);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(30);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(50);
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


