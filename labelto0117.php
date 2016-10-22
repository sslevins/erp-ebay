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
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'order-id');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'order-item-id');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'payments-date');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'promise-date');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'days-past-promise');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', 'buyer-email');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', 'buyer-name');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', 'buyer-phone-number');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', 'sku');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', 'product-name');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', 'quantity-purchased');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', 'quantity-shipped');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', 'quantity-to-ship');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1', 'ship-service-level');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1', 'recipient-name');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q1', 'ship-address-1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R1', 'ship-address-2');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S1', 'ship-address-3');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T1', 'ship-city');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U1', 'ship-state');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V1', 'ship-postal-code');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W1', 'ship-country');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X1', '发货方式');
	
	$ertj		= "";
	$orders		= explode(",",$_REQUEST['ordersn']);
	$status		= $_REQUEST['ostatus'];
	for($g=0;$g<count($orders);$g++){

		$sn 	=  $orders[$g];

		if($sn != ""){

				

					$ertj	.= " a.ebay_id='$sn' or";

		}

			

	}

	$ertj			 = substr($ertj,0,strlen($ertj)-3);

	if($ertj == ""){

	

	$sql	= "select a.*,b.sku,b.ebay_amount,b.ebay_itemid,b.ebay_itemtitle,b.shipingfee as shipfee from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn = b.ebay_ordersn where a.ebay_user='$user' and a.ebay_status='$status' and a.ebay_combine!='1' ";	

	}else{	

	$sql	= "select a.*,b.sku,b.ebay_amount,b.ebay_itemid,b.ebay_itemtitle,b.shipingfee as shipfee from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn = b.ebay_ordersn where ($ertj) and a.ebay_user='$user' and a.ebay_combine!='1' order by  a.ebay_ordersn ";	

	}	
	
//echo $sql;
//exit;

	//$countrys	= $_REQUEST['country'];

	
	$sql		= $dbcon->execute($sql);
	$sql		= $dbcon->getResultArray($sql);
	
	
	$a			= 2;	
	
	$filepath	=   dirname(dirname(__FILE__));
	
	for($i=0;$i<count($sql);$i++){
		
		$ebay_id        = $sql[$i]['ebay_id'];
		$ordersn		= $sql[$i]['ebay_ordersn'];
		$itemid		= $sql[$i]['ebay_itemid'];
		$itemtitle		= $sql[$i]['ebay_itemtitle'];
		$sku		= $sql[$i]['sku'];
		$amount		= $sql[$i]['ebay_amount'];
		$shipfee		= $sql[$i]['shipfee'];
		//$paidtime		= date('Y-m-d',strtotime($sql[$i]['ebay_paidtime']));
		$ebay_usermail	= $sql[$i]['ebay_usermail'];
		$ebay_userid	= $sql[$i]['ebay_userid'];	
		$name			= $sql[$i]['ebay_username'];
		$name	 	 	= str_replace("&acute;","'",$name);
		$name  			= str_replace("&quot;","\"",$name);
		
		$paid_time		= @date('Y-m-d',$sql[$i]['ebay_paidtime']);
	    $street1			= @$sql[$i]['ebay_street'];
	    $street2 			= @$sql[$i]['ebay_street1'];
	    $city 				= $sql[$i]['ebay_city'];
	    $state				= $sql[$i]['ebay_state'];
	    $countryname 		= $sql[$i]['ebay_countryname'];

	    $zip				= $sql[$i]['ebay_postcode'];

	    $tel				= $sql[$i]['ebay_phone'];

		$ebay_shipfee		= $sql[$i]['ebay_shipfee'];

		$ebay_note			= $sql[$i]['ebay_note'];
		$ebay_total	 		= @$sql[$i]['ebay_total'];
		$recordnumber		= $sql[$i]['recordnumber'];
		$ebay_account		= $sql[$i]['ebay_account'];
		$ebay_carrier		= $sql[$i]['ebay_carrier'];

		$objPHPExcel->setActiveSheetIndex(0)->getCell('A'.$a)->setValueExplicit($ebay_id, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('B'.$a)->setValueExplicit($ordersn, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('C'.$a)->setValueExplicit($itemid, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('D'.$a)->setValueExplicit($paid_time, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('G'.$a)->setValueExplicit($ebay_usermail, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('H'.$a)->setValueExplicit($ebay_userid, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('I'.$a)->setValueExplicit($tel, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('J'.$a)->setValueExplicit($sku, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('K'.$a)->setValueExplicit($itemtitle, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('L'.$a)->setValueExplicit($amount, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('O'.$a)->setValueExplicit($shipfee, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('P'.$a)->setValueExplicit($name, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('Q'.$a)->setValueExplicit($street1, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('R'.$a)->setValueExplicit($street2, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('T'.$a)->setValueExplicit($city, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('U'.$a)->setValueExplicit($state, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('V'.$a)->setValueExplicit($zip, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('W'.$a)->setValueExplicit($countryname, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('X'.$a)->setValueExplicit($ebay_carrier, PHPExcel_Cell_DataType::TYPE_STRING);
		$a++;
}

$objPHPExcel->getActiveSheet(0)->getStyle('A1:X500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('Q')->setWidth(30);

$title			= "AM".date('Y-m-d');
$titlename		= "AM".date('Y-m-d').".xls";
$objPHPExcel->getActiveSheet()->setTitle($title);
$objPHPExcel->setActiveSheetIndex(0);





	
	



	$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);




header('Content-Type: application/vnd.ms-excel');

header("Content-Disposition: attachment;filename={$titlename}");

header('Cache-Control: max-age=0');



$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

$objWriter->save('php://output');

exit;





