<?php
include "../include/dbconnect.php";	
	date_default_timezone_set ("Asia/Chongqing");	
set_time_limit(0);
$dbcon	= new DBClass();
error_reporting(0);
@session_start();
$user	= $_SESSION['user'];
require_once '../Classes/PHPExcel.php';
$cpower	= explode(",",$_SESSION['power']);

	$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");

	$c		= 2;
												 


	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '1)PONO(销售订单号)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '2)SalerFullName(发件人姓名)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '3)BuyerFullName(收件人姓名)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '4)BuyerPhoneName(收件人电话)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', '5)Buyer Email(收件人邮箱)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', '6)BuyerAddress1(收件人地址)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', '7)BuyerCity(收件人城市)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', '8)BuyerState(收件人州/省)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', '9)BuyerZip(收件人邮编)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', '10)Buyer Country(收件人国家简码)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', '11)ItemTitle(商品描述 多个以分号隔开)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', '12)Custom Label(商品SKU)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', '13)Totle Price(申报价值$)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', '14)Transportation Company(管道名称 从右侧的下拉框中选择且不能更改)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1', '15)Box Model(箱子型号 从右侧的下拉框中选择且不能更改)	');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1', '16)IsPaulPrice(是否保价[Y/N])');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q1', '17)IsUserPoints(是否使用积分[Y/N])');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R1', '18)关税支付方式[C-发件人,D-收件人]');
	
	
	
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
	$sql	= "select * from ebay_order as a where ebay_user='$user' and a.ebay_status='1' and a.ebay_combine!='1' ";	
	}else{	
	$sql	= "select a.*,b.ebay_amount from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn = b.ebay_ordersn where ($ertj) and a.ebay_user='$user' and a.ebay_combine!='1' group by a.ebay_id order by   b.sku desc , b.ebay_amount desc ";	
	}
	
	
	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);




	$a = 2;
	
	
	for($i=0;$i<count($sql);$i++){
		
			
			$ebay_username			= $sql[$i]['ebay_username'];	
			$recordnumber			= $sql[$i]['recordnumber'];	
			$ebay_phone				= $sql[$i]['ebay_phone'];	
			
			$ebay_ordersn			= $sql[$i]['ebay_ordersn'];	
			
			$ebay_usermail				= $sql[$i]['ebay_usermail'];
			$ebay_street				= $sql[$i]['ebay_street'];
			$ebay_street1				= $sql[$i]['ebay_street1'];
			$ebay_city					= $sql[$i]['ebay_city'];
			$ebay_state					= $sql[$i]['ebay_state'];
			$ebay_postcode					= $sql[$i]['ebay_postcode'];
			$ebay_couny					= $sql[$i]['ebay_couny'];
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('A'.$a, $recordnumber, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('B'.$a, 'romantz', PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('C'.$a, $ebay_username, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('D'.$a, $ebay_phone, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$a, $ebay_usermail, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('F'.$a, $ebay_street.$ebay_street1, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('G'.$a, $ebay_city, PHPExcel_Cell_DataType::TYPE_STRING);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('H'.$a, $ebay_state, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('I'.$a, $ebay_postcode, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('J'.$a, $ebay_couny, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('N'.$a, $ebay_carrier, PHPExcel_Cell_DataType::TYPE_STRING);
			
			
			$vv			= "select * from ebay_orderdetail where ebay_ordersn='$ebay_ordersn' ";
			$vv			= $dbcon->execute($vv);
			$vv			= $dbcon->getResultArray($vv);
			
			
			$itemstr	= '';
			$itemsku	= '';
			$totalsbjz	= 0;
			
			
			for($v=0;$v<count($vv);$v++){
				
				$itemstr.= $vv[$v]['ebay_itemtitle'];
				$itemsku.= $vv[$v]['sku'];
													$ee			= "SELECT goods_sbjz FROM ebay_goods where goods_sn='".$vv[$v]['sku']."' and ebay_user='$user'";
													$ee			= $dbcon->execute($ee);
													$ee 	 	= $dbcon->getResultArray($ee);
													$totalsbjz	+= $goods_sbjz;
													
				
			}
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('K'.$a, $itemstr, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('L'.$a, $itemsku, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('M'.$a, $totalsbjz, PHPExcel_Cell_DataType::TYPE_STRING);
			
			
			$a++;
			
			
			
	}
	
	


	
	$objPHPExcel->getActiveSheet(0)->getStyle('A1:E500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$objPHPExcel->getActiveSheet(0)->getStyle('A1:Z500')->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet(0)->getStyle('A1:N500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


	$title		= "Products-".date('Y')."-".date('m')."-".date('d').".xls";
	
	
	$objPHPExcel->getActiveSheet()->setTitle($title);
	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	// Redirect output to a client's web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
	header("Content-Disposition: attachment;filename={$title}");
	header('Cache-Control: max-age=0');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;

?>
