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
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '订单编号');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'Sales Record Number');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'user id');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'sku');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', '产品中文名称');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', '数量');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', '收件人');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', '运输方式');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', '账号');
				

									
	
	$ostatus	= $_REQUEST['ostatus'];
	
	$ertj		= "";
	$orders		= explode(",",$_REQUEST['ordersn']);
	for($g=0;$g<count($orders);$g++){
		$sn 	=  $orders[$g];
		if($sn != ""){
				
					$ertj	.= " a.ebay_id='$sn' or";
		}
			
	}
	
	/*
	
	id, goods_sn,goods_name,goods_amount, 
	
	*/
	
	
	$ertj			 = substr($ertj,0,strlen($ertj)-3);
	if($ertj == ""){
	
	$sql	= "SELECT * FROM ebay_order AS a where a.ebay_user='$user'  and a.ebay_combine!='1' and ebay_status ='$ostatus' ";	
	}else{	
	$sql	= "SELECT * FROM ebay_order AS a where a.ebay_user='$user'   and a.ebay_combine!='1' and ($ertj) ";	

	}	
	

	
		
	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);

	
	$a		= 2;
	
	
	$sn		= 1;
	
	for($i=0;$i<count($sql);$i++){
		
		$ordersn				= $sql[$i]['ebay_ordersn'];	
		$ebay_id				= $sql[$i]['ebay_id'];	
		$recordnumber			= $sql[$i]['recordnumber'];	
		$user_id			= $sql[$i]['ebay_userid'];		
		$name					= $sql[$i]['ebay_username'];
		$ebay_carrier			= @$sql[$i]['ebay_carrier'];
		$ebay_account			= @$sql[$i]['ebay_account'];
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('A'.$a, $ebay_id, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('B'.$a, $recordnumber, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('C'.$a, $user_id, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('G'.$a, $name, PHPExcel_Cell_DataType::TYPE_STRING);		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('H'.$a, $ebay_carrier, PHPExcel_Cell_DataType::TYPE_STRING);	
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('I'.$a, $ebay_account, PHPExcel_Cell_DataType::TYPE_STRING);	
		$sl				= "select * from ebay_orderdetail where ebay_ordersn='$ordersn'";
		$sl				= $dbcon->execute($sl);
		$sl				= $dbcon->getResultArray($sl);
		
		for($o=0;$o<count($sl);$o++){					
			$sku					= $sl[$o]['sku'];	
			$amount					= $sl[$o]['ebay_amount'];	
			$sq3	= "select goods_name from ebay_goods where goods_sn='$sku' and ebay_user='$user'";
			$sq3	= $dbcon->execute($sq3);
			$sq3	= $dbcon->getResultArray($sq3);
			if($sq3){
				$goods_name = $sq3[0]['goods_name'];
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('D'.$a, $sku, PHPExcel_Cell_DataType::TYPE_STRING);		
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$a, $goods_name, PHPExcel_Cell_DataType::TYPE_STRING);	
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('F'.$a, $amount, PHPExcel_Cell_DataType::TYPE_STRING);
				$a++;
			}else{
				$ssr	= "select goods_sncombine from ebay_productscombine where ebay_user='$user' and goods_sn='$sku'";
				$ssr 	= $dbcon->execute($ssr);
				$ssr	= $dbcon->getResultArray($ssr);
				$goods_sncombine	= $ssr[0]['goods_sncombine'];
				$goods_sncombine    = explode(',',$goods_sncombine);	
				for($e=0;$e<count($goods_sncombine);$e++){
					$pline			= explode('*',$goods_sncombine[$e]);
					$goods_sn		= $pline[0];
					$goddscount     = $pline[1] * $amount;
					$ee			= "SELECT goods_name FROM ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
					$ee			= $dbcon->execute($ee);
					$ee 	 	= $dbcon->getResultArray($ee);
					$goods_name = $ee[0]['goods_name'];
					$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('D'.$a, $goods_sn, PHPExcel_Cell_DataType::TYPE_STRING);		
					$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$a, $goods_name, PHPExcel_Cell_DataType::TYPE_STRING);	
					$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('F'.$a, $goddscount, PHPExcel_Cell_DataType::TYPE_STRING);
					$a++;
				}
			}
	}

}


$objPHPExcel->getActiveSheet(0)->getStyle('A1:N500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(15);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(15);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(15);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(15);	

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(15);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(15);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(15);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth(15);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setWidth(15);

$title		= "".date('Y-m-d');
$titlename		= "".date('Y-m-d').".xls";

$objPHPExcel->getActiveSheet()->setTitle($title);

$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename={$titlename}");
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;


