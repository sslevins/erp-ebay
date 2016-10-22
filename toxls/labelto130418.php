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
												 



	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '销售订单号');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '收件人姓');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '收件人名');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '收件人电话');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', '地址1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', '地址2');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', '城市');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', '省/州');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', '邮编');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', '国家代码');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', 'SKU');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', '销售数量');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', '销售单价');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', '发货方式');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1', '订单备注');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1', '跟踪号');
	
	
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
			
			if($ebay_state == '') $ebay_state = $ebay_city;
			$ebay_postcode					= $sql[$i]['ebay_postcode'];
			$ebay_couny					= $sql[$i]['ebay_couny'];
			$ebay_countryname					= $sql[$i]['ebay_countryname'];
			$ebay_carrier					= $sql[$i]['ebay_carrier'];
			$ebay_account					= $sql[$i]['ebay_account'];
			$ebay_currency					= $sql[$i]['ebay_currency'];
				$ebay_tracknumber					= $sql[$i]['ebay_tracknumber'];
				
			
			
			
				$ss					= "select * from ebay_carrier where name='$ebay_carrier' and ebay_user ='$user'";
				
				
;
		
				
				$ss					= $dbcon->execute($ss);
				$ss					= $dbcon->getResultArray($ss);
				

				
				
				$stnames			= $ss[0]['stnames'];
				
			
			
				$ss					= "select * from ebay_currency where currency='$ebay_currency' and user ='$user'";
				$ss					= $dbcon->execute($ss);
				$ss					= $dbcon->getResultArray($ss);	
		
		$ssrates		= $ss[0]['rates']?$ss[0]['rates']:1;
		
		
		
			
					$ss					= "select * from ebay_account where ebay_account='$ebay_account'";
		$ss	= $dbcon->execute($ss);
		$ss	= $dbcon->getResultArray($ss);		
		$headstr			=$ss[0]['appname'];

$MERCHANT_ID		= $ss[0]['MERCHANT_ID'];

			if($MERCHANT_ID != '' ) 	$ebay_id				= $sql[$i]['ebay_ordersn'];	

			
			$vv			= "select countrysn from ebay_countrys where countryen='$ebay_countryname' and ebay_user ='$user' ";
			
			
			
			$vv			= $dbcon->execute($vv);
			$vv			= $dbcon->getResultArray($vv);
			$countrysn	= $vv[0]['countrysn'];
			
			
			
			
			
			$vv			= "select * from ebay_orderdetail where ebay_ordersn='$ebay_ordersn' ";
			$vv			= $dbcon->execute($vv);
			$vv			= $dbcon->getResultArray($vv);
			
			
			$itemstr	= '';
			$itemsku	= '';
			$totalsbjz	= 0;
			
			
			for($v=0;$v<count($vv);$v++){
				
				$SKU					= $vv[$v]['sku'];
				$ebay_amount			= $vv[$v]['ebay_amount'];
				$ebay_itemprice			= $vv[$v]['ebay_itemprice'];
				
		//		$ebay_itemprice			= ($vv[$v]['ebay_itemprice']+ $vv[$v]['shipingfee']) * $ssrates;
				
				$ebay_itemprice			= number_format(($ebay_itemprice + $vv[$v]['shipingfee']) * $ssrates ,2);
				
				
				$SKU					= str_replace('-1','',$SKU);
				$SKU					= str_replace('-2','',$SKU);
				$SKU					= str_replace('-N','',$SKU);
				$SKU					= str_replace('==','',$SKU);

				
				
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('A'.$a, $ebay_id, PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('B'.$a, $ebay_username, PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('D'.$a, $ebay_phone, PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$a, $ebay_street, PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('F'.$a, $ebay_street1, PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('G'.$a, $ebay_city, PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('H'.$a, $ebay_state, PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('I'.$a, $ebay_postcode, PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('J'.$a, $countrysn, PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('K'.$a, $SKU, PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('L'.$a, $ebay_amount, PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('M'.$a, $ebay_itemprice, PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('N'.$a, $stnames, PHPExcel_Cell_DataType::TYPE_STRING);
				
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('O'.$a, $ebay_tracknumber, PHPExcel_Cell_DataType::TYPE_STRING);

				$a++;
													
				
			}
			
			
			
			
			
			
			
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
