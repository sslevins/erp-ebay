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

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'eBay帐号');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '产品编号');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '产品名称');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '数量');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', '价格');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', '币种');
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', '发生时间');

	

	@$startdate		= $_REQUEST['startdate'];
	$enddate		= $_REQUEST['enddate'];
	$account		= $_REQUEST['account'];
	$goodscategory  = $_REQUEST['goodscategory'];
	$sku			= $_REQUEST['sku'];
	
	
	$type		= $_REQUEST['type'];
				
			
	$sql		= "select * from ebay_goodshistory where ebay_user='$user' and  stocktype='$type'";
	$keys		= $_REQUEST['keys'];
	if($keys != ""){
				
					$sql	.= " and(goodsname like '%$keys%' or goodsn like '%$keys%')";
					
	}
	
	if($startdate != "" && $enddate != ""){
				
				
					$sql	    .= " and(addtime>='$startdate 00:00:00' and addtime<='$enddate 23:59:59')";
				
				
	}
				
	if($account !="" && $account !='-1'){
					
					$sql		.=" and ebay_account='$account'";
				
				
	}
				
	if($sku !="" ){
					
					$sql		.=" and goodsn='$sku'";
				
				
	}
				
				
				
	if($goodscategory != "" && $goodscategory != "-1"){
				
					$sql		.= "and goods_category='$goodscategory'";
				
				
	}
				
			
		
	$sql			.= " order by id desc";
				
	

	

		

	$sql	= $dbcon->execute($sql);

	$sql	= $dbcon->getResultArray($sql);


	$a		= 2;

	

	for($i=0;$i<count($sql);$i++){
		
		
					$goodsid		= $sql[$i]['goodsid'];
					$goodsn			= $sql[$i]['goodsn'];
					$goodsname		= $sql[$i]['goodsname'];
				
					$goodsnumber	= $sql[$i]['goodsnumber'];
					$addtime 		= $sql[$i]['addtime'];
					$stocktype		= $sql[$i]['stocktype'];
					$ebay_account		= $sql[$i]['ebay_account'];
					$ebay_currency		= $sql[$i]['ebay_currency'];
					$goodsprice		= $sql[$i]['goodsprice'];
					


			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$a, "".$ebay_account);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$a, "".$goodsn);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$a, "".$goodsname);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$a, "".$goodsnumber);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$a, "".$goodsprice);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$a, "".$ebay_currency);
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$a, "".$addtime);
			$a++;

			

			



	



}

$objPHPExcel->getActiveSheet(0)->getStyle('A1:N500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(10);	

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(25);	

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(15);	

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(15);	

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(15);	










$title		= "Shippinglist".date('Y-m-d');

$titlename		= "Shippinglist".date('Y-m-d').".xls";



$objPHPExcel->getActiveSheet()->setTitle($title);



$objPHPExcel->setActiveSheetIndex(0);





// Redirect output to a client's web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename={$titlename}");
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>