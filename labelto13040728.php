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
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '销售编号');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '收件人姓名');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '收件人地址第一行');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '收件人地址第二行');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', '城市');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', '州');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', '邮编');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', '收件人国家');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', '电话号码');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', '物品及数量(1*sku1;2*sku2;3*sku3)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', '运输方式');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', '跟踪号码');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', '报关类型');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', '申报价值币种');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1', '承载物品名1(英文)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1', '承载物品名1(中文)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q1', '数量1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R1', '重量1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S1', '价值1');
	$ertj		= "";

	$orders		= explode(",",$_REQUEST['ordersn']);

	for($g=0;$g<count($orders);$g++){

		$sn 	=  $orders[$g];

		if($sn != ""){

				

					$ertj	.= " a.ebay_id='$sn' or";

		}

			

	}

	$ertj			 = substr($ertj,0,strlen($ertj)-3);

	if($ertj == ""){

	

	$sql	= "select * from ebay_order as a where ebay_user='$user' and a.ebay_status='0' and a.ebay_combine!='1' ";	

	}else{	

	$sql	= "select * from ebay_order as a where ($ertj) and ebay_user='$user' and a.ebay_combine!='1' order by ebay_id desc ";	

	}	
		
		

	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);
	
	

	$a		= 2;	

	for($i=0;$i<count($sql);$i++){
		
		$ebay_id		= $sql[$i]['ebay_id'];
		$ordersn		= $sql[$i]['ebay_ordersn'];
		$paidtime		= date('Y-m-d',strtotime($sql[$i]['ebay_paidtime']));
		$ebay_usermail	= $sql[$i]['ebay_usermail'];
		$ebay_userid	= $sql[$i]['ebay_userid'];	
		$name			= $sql[$i]['ebay_username'];
		$name	  	= str_replace("&acute;","'",$name);
		$name  		= str_replace("&quot;","\"",$name);
		
		
	    $street1		= @$sql[$i]['ebay_street'];
	    $street2 		= @$sql[$i]['ebay_street1'];
		$ebay_couny		= $sql[$i]['ebay_couny']?$sql[$i]['ebay_couny']:'US';
	    $city 				= $sql[$i]['ebay_city'];
	    $state				= $sql[$i]['ebay_state'];
		$PaymentMethodUsed 		= $sql[$i]['PaymentMethodUsed'];
	    $countryname 		= $sql[$i]['ebay_countryname'];

	    $zip				= $sql[$i]['ebay_postcode'];
 $ebay_tracknumber				= $sql[$i]['ebay_tracknumber'];
	    $tel				= $sql[$i]['ebay_phone'];

		$ebay_shipfee		= $sql[$i]['ebay_shipfee'];

		$ebay_note			= $sql[$i]['ebay_note'];

		$ebay_total	 		= @$sql[$i]['ebay_total'];
		$recordnumber		= $sql[$i]['recordnumber'];
		$ebay_account		= $sql[$i]['ebay_account'];
		$ebay_ptid			= $sql[$i]['ebay_ptid'];
		$ebay_tid			= $sql[$i]['ebay_tid'];	
		$ebay_phone					= $sql[$i]['ebay_phone'];
		$ebay_carrier					= $sql[$i]['ebay_carrier'];
		$ebay_currency					= $sql[$i]['ebay_currency'];
		$ebay_createdtime				= @date('Y-m-d',$sql[$i]['ebay_createdtime']);
		$ebay_paidtime					= @date('Y-m-d',$sql[$i]['ebay_paidtime']);

		$addressline	= $street1." ".$street2;
		$addressline	  	= str_replace("&acute;","'",$addressline);
		$addressline  		= str_replace("&quot;","\"",$addressline);
		 $ebay_id 				= $sql[$i]['ebay_id'];
		

		$sl				= "select * from ebay_orderdetail where ebay_ordersn='$ordersn' ";

		$sl				= $dbcon->execute($sl);

		$sl				= $dbcon->getResultArray($sl);
		
		
		$lstr			= '';
		
		for($o=0;$o<count($sl);$o++){			

		
			$sku1	= $sl[$o]['sku'];	
			$xynumber = 'JY-'.date('Ymd').'-'.$ebay_id;
			$sku	= $sl[$o]['ebay_itemtitle'];

			$amount	= $sl[$o]['ebay_amount'];

			$pic	= $sl[$o]['ebay_itemurl'];			
			$ebay_itemid			= $sl[$o]['ebay_itemid'];	
			$ebay_itemprice	= $sl[$o]['ebay_itemprice'];	
			$shipingfee			= $sl[$o]['shipingfee'];
			$recordnumber		= $sl[$o]['recordnumber'];
			$total				= $ebay_itemprice + $shipingfee;
			$sq3	= "select * from ebay_goods where goods_sn='$sku1' and ebay_user='$user'";
			$sq3	= $dbcon->execute($sq3);
			$sq3	= $dbcon->getResultArray($sq3);
			$goods_weight = $sq3[0]['goods_weight'];
			$goods_ywsbmc = $sq3[0]['goods_ywsbmc'];
			$goods_zysbmc = $sq3[0]['goods_zysbmc'];
			$goods_sbjz = $sq3[0]['goods_sbjz'];
			
			$lstr		.= $amount.' * '.$sku1;
			
		}

	
	
			$objPHPExcel->setActiveSheetIndex(0)->getCell('A'.$a)->setValueExplicit($ebay_id, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('B'.$a)->setValueExplicit($name, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('C'.$a)->setValueExplicit($street1, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('D'.$a)->setValueExplicit($street2, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('E'.$a)->setValueExplicit($city, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('F'.$a)->setValueExplicit($state, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('G'.$a)->setValueExplicit($zip, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('H'.$a)->setValueExplicit($countryname, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('I'.$a)->setValueExplicit($ebay_phone, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('J'.$a)->setValueExplicit($lstr, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('K'.$a)->setValueExplicit($ebay_carrier, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('L'.$a)->setValueExplicit($ebay_tracknumber, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('M'.$a)->setValueExplicit(0, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('N'.$a)->setValueExplicit('USD', PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('O'.$a)->setValueExplicit($goods_ywsbmc, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('P'.$a)->setValueExplicit($goods_zysbmc, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('Q'.$a)->setValueExplicit($amount, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('R'.$a)->setValueExplicit($goods_weight, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('R'.$a)->setValueExplicit($goods_sbjz, PHPExcel_Cell_DataType::TYPE_STRING);
			$a++;



}

$objPHPExcel->getActiveSheet(0)->getStyle('A1:N500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);








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







$title		= "KU_system".date('Y-m-d');

$titlename		= "KU_system".date('Y-m-d').".xls";



$objPHPExcel->getActiveSheet()->setTitle($title);



$objPHPExcel->setActiveSheetIndex(0);





// Redirect output to a client’s web browser (Excel5)

header('Content-Type: application/vnd.ms-excel');

header("Content-Disposition: attachment;filename={$titlename}");

header('Cache-Control: max-age=0');



$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

$objWriter->save('php://output');

exit;





