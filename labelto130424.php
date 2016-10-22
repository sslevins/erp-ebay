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
												 



	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '寄件人參考 – 條碼');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '寄件人參考 – 其他文字資料');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '投保易網郵保險服務');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '服務級別');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', '列印 CN23');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', '郵袋編號');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', '寄件人名稱');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', '寄件人地址第一行');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', '寄件人地址第二行');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', '寄件人地址第三行');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', '寄件人地址第四行');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', '寄件人地址第五行');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', '收件人姓名');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', '收件人地址第一行');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1', '收件人地址第二行');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1', '收件人地址第三行');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q1', '收件人地址第四行');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R1', '收件人地址第五行');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S1', '收件人目的地國家代號');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T1', '物品類別');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U1', '物品類別內容');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V1', '內載物品詳情(第一行)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W1', '數量(第一行)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X1', '淨重(千克)(第一行)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y1', '貨幣(第一行)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z1', '價值(第一行)');
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA1', '協制編號(第一行)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB1', '物品原產地(第一行)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC1', '內載物品詳情(第二行)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD1', '數量(第二行)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AE1', '淨重(千克)(第二行)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AF1', '貨幣(第二行)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AG1', '價值(第二行)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AH1', '協制編號(第二行)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AI1', '物品原產地(第二行)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AJ1', '內載物品詳情(第三行)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AK1', '數量(第三行)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AL1', '淨重(千克)(第三行)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AM1', '貨幣(第三行)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AN1', '價值(第三行)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AO1', '協制編號(第三行)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AP1', '物品原產地(第三行)');

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AQ1', '內載物品詳情(第四行)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AR1', '數量(第四行)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AS1', '淨重(千克)(第四行)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AT1', '貨幣(第四行)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AU1', '價值(第四行)');	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AV1', '協制編號(第四行)');	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AW1', '物品原產地(第四行)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AX1', '總重量(千克)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AY1', '貨幣(總值)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AZ1', '總值');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BA1', '郵費');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BB1', '其他費用');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BC1', '寄件人的海關檔案');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BD1', '進口商檔案');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BE1', '進口商電話 / 傳真 / 電郵');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BF1', '註釋');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BG1', '牌照編號');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BH1', '證明文件編號');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BI1', '發貸單編號');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BJ1', '原寄地');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BK1', '投寄日期');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BL1', '郵件編號');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BM1', '城市 (互換局) - 只供已向香港郵政提供預計每月投寄量的寄件人填寫');
	
	
	

	
			$ertj		= "";
	$orders		= explode(",",$_REQUEST['ordersn']);
	for($g=0;$g<count($orders);$g++){
		$sn 	=  $orders[$g];
		if($sn != ""){
				
					$ertj	.= " a.ebay_id='$sn' or";
		}
			
	}
	$ertj			 = substr($ertj,0,strlen($ertj)-3);
	
	
	
	
	$ebayaccounts00		= $_SESSION['ebayaccounts'];
	$ebayaccounts00 	= explode(",",$ebayaccounts00);	
	$ebayacc		= '';	
	$ebayacc2		= '';
	
	for($i=0;$i<count($ebayaccounts00);$i++){		
		$ebayacc	.= "a.ebay_account='".$ebayaccounts00[$i]."' or ";	
		$ebayacc2	.= "account='".$ebayaccounts00[$i]."' or ";	
		
	}
	
	
		$ebayacc     = substr($ebayacc,0,strlen($ebayacc)-3);

	
	if($ertj == ""){
	$sql	= "select * from ebay_order as a where ebay_user='$user' and a.ebay_status='1' and a.ebay_combine!='1' and ($ebayacc)";	
	}else{	
	$sql	= "select *  from ebay_order as a   where ($ertj) and a.ebay_user='$user' and a.ebay_combine!='1'  ";	
	}
	


	
	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);



	$a = 2;
	
	
	for($i=0;$i<count($sql);$i++){
		
			
			$ebay_username			= $sql[$i]['ebay_username'];	
			$recordnumber			= $sql[$i]['recordnumber'];	
			$ebay_phone				= $sql[$i]['ebay_phone'];	
			$ebay_id				= $sql[$i]['ebay_id'];	
			$ebay_ordersn			= $sql[$i]['ebay_ordersn'];	
			$ebay_total			= $sql[$i]['ebay_total'];	
			$ebay_usermail				= $sql[$i]['ebay_usermail'];
			$ebay_street				= $sql[$i]['ebay_street'];
			$ebay_street1				= $sql[$i]['ebay_street1'];
			$ebay_city					= $sql[$i]['ebay_city'];
			$ebay_state					= $sql[$i]['ebay_state'];
			$ebay_postcode					= $sql[$i]['ebay_postcode'];
			$ebay_couny					= $sql[$i]['ebay_couny'];
			$ebay_countryname					= $sql[$i]['ebay_countryname'];
			$ebay_carrier					= $sql[$i]['ebay_carrier'];
			$ebay_account					= $sql[$i]['ebay_account'];
			$ebay_currency					= $sql[$i]['ebay_currency'];
			$ebay_couny					= $sql[$i]['ebay_couny'];

			
			
			$vv			= "select * from ebay_orderdetail where ebay_ordersn='$ebay_ordersn' ";
			$vv			= $dbcon->execute($vv);
			$vv			= $dbcon->getResultArray($vv);
			
			
			$itemstr	= '';
			$itemsku	= '';
			$totalsbjz	= 0;
			
			
			$totalweight	= 0;
			$goods_ywsbmc	= '';
			$totalqty		= 0;
			$goods_sbjz		= 0;
			
			
			$labelstr		= '';
			$goods_namestr	= '';
			
			
			for($v=0;$v<count($vv);$v++){
				
				$SKU					= $vv[$v]['sku'];
				$totalqty				+= $vv[$v]['ebay_amount'];
				$labelstr		.=$SKU;
				
				
				$jj			= "select * from ebay_goods where ebay_user ='$user' and goods_sn='$SKU' ";
				$jj			= $dbcon->execute($jj);
				$jj			= $dbcon->getResultArray($jj);

				
				 $goods_sbjz	= $jj[0]['goods_sbjz'];
				$totalweight += $jj[0]['goods_weight'];
				$goods_ywsbmc	= $jj[0]['goods_ywsbmc'];
				$goods_namestr	.= $jj[0]['goods_zysbmc'];
				
				$itemstr		.=  $jj[0]['goods_name'];
			}
			
				

			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('B'.$a, $SKU, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('A'.$a, $ebay_account.$ebay_id, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('C'.$a, 'N', PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('D'.$a, 'E', PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$a, 'Y', PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('G'.$a, 'Terry Ho ', PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('H'.$a, 'Rm11,8F,BlockA,Vigor Ind Bldg', PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('I'.$a, '14Cheung Tat Road', PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('M'.$a, $ebay_username, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('N'.$a, $ebay_street, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('O'.$a, $ebay_street1, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('S'.$a, $ebay_couny, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('T'.$a, 'S', PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('V'.$a, 'bicycle accessories', PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('W'.$a, '1', PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('Y'.$a, 'USD', PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('Z'.$a, '8', PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AB'.$a, 'ZN', PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AX'.$a, '0.12', PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AY'.$a, 'USD', PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AZ'.$a, '8', PHPExcel_Cell_DataType::TYPE_STRING);

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
