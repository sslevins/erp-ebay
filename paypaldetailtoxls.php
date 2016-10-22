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
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', ' Paypal账号');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', ' 交易创建时间');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', ' 客户Email');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', ' 客户姓名');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', ' 交易ID');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', ' 总金额');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', ' 费用');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', ' 净额');

				$accounts		= $_REQUEST['account'];
	$start			= $_REQUEST['start'];
	$end			= $_REQUEST['end'];
	$keys			= $_REQUEST['keywords'];
				
				
				$sql	= "select * from ebay_paypaldetail where user='$user' ";
				
				$keys 	= $_REQUEST['keys'];
				if($keys != ""){
				
					
					$sql.=" and (tid like '%$keys%' or name like '%$keys%' or mail like '%$keys%' ) ";
					
				}
				
				
				if($accounts != '' ) $sql.= " and account = '$accounts' ";
				if($start != '' && $end != ''){
				
					$st00	= strtotime($start." 00:00:00");
					$st11	= strtotime($end." 23:59:59");
					$sql	.= " and (time	>=$st00 and time	<=$st11)";
				}
				
				
				$sql	.=" order by time desc";
				
				

		
	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);
	$a		= 2;
	$date   = date("Y-m-d H:i");
	for($i=0;$i<count($sql);$i++){
		
		$account				= $sql[$i]['account'];	
		$paidtime				= date('Y-m-d H:i:s',$sql[$i]['time']);
		$mail				= $sql[$i]['mail'];
		$names				= $sql[$i]['name'];
		$tid				= $sql[$i]['tid'];
		$gross				= $sql[$i]['gross'];
		$fee				= $sql[$i]['fee'];
		$net				= $sql[$i]['net'];
		

		
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('A'.$a, $i+1, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('B'.$a, $account, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('C'.$a, $paidtime, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('D'.$a, $mail, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$a, $names, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('F'.$a, $tid, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('G'.$a, $gross, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('H'.$a, $fee, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('I'.$a, $net, PHPExcel_Cell_DataType::TYPE_STRING);
		
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


