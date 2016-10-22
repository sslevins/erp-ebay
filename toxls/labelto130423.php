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
												 



	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '版本7_1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '目的地国家(必填)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '货运方式(必填)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '收件人(必填)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', '包裹详情_英文1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', '包裹详情_中文1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', '数量1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', '币种1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', '单价1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', '包裹详情_英文2');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', '包裹详情_中文2');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', '数量2');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', '币种2');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', '单价2');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1', '包裹详情_英文3');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1', '包裹详情_中文3');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q1', '数量3');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R1', '币种3');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S1', '单价3');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T1', '包裹详情_英文4');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U1', '包裹详情_中文4');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V1', '数量4');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W1', '币种4');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X1', '单价4');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y1', '包裹详情_英文5');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z1', '包裹详情_中文5');
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA1', '数量5');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB1', '币种5');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC1', '单价5');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD1', '收件人Email');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AE1', '地址1(必填)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AF1', '地址2');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AG1', '州(省)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AH1', '城市(必填)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AI1', '邮编(必填)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AJ1', '电话');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AK1', 'remark');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AL1', 'packinfo1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AM1', 'packinfo2');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AN1', 'packinfo3');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AO1', 'USPS3Days是否挂号');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AP1', '客户订单编号');


	
	

	
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

			
				$vv			= "select * from ebay_account where ebay_account='$ebay_account' and ebay_user ='$user' ";
			$vv			= $dbcon->execute($vv);
			$vv			= $dbcon->getResultArray($vv);
			
			$appname		= $vv[0]['appname'];
			
			
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
				$labelstr		.=$SKU.' * '.$vv[$v]['ebay_amount'];
				
				$jj			= "select * from ebay_goods where ebay_user ='$user' and goods_sn='$SKU' ";
				$jj			= $dbcon->execute($jj);
				$jj			= $dbcon->getResultArray($jj);

				
				 $goods_sbjz	= $jj[0]['goods_sbjz'];
				$totalweight += $jj[0]['goods_weight'];
				$goods_ywsbmc	= $jj[0]['goods_ywsbmc'];
				$goods_namestr	.= $jj[0]['goods_zysbmc'];
				
				$itemstr		.=  $jj[0]['goods_name'];
			}
			
				

			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('B'.$a, $ebay_countryname, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('D'.$a, $ebay_username, PHPExcel_Cell_DataType::TYPE_STRING);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('C'.$a, 'FGMSN', PHPExcel_Cell_DataType::TYPE_STRING);

			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$a, 'eyeliner', PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('F'.$a, '眼线笔', PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('G'.$a, '1', PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('H'.$a, 'USD', PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('I'.$a, '1', PHPExcel_Cell_DataType::TYPE_STRING);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AE'.$a, $ebay_street, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AF'.$a, $ebay_street1, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AG'.$a, $ebay_state, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AH'.$a, $ebay_city, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AI'.$a, '^'.$ebay_postcode, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AJ'.$a, '^'.$ebay_phone, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AK'.$a, $ebay_id, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AP'.$a, $appname.$recordnumber, PHPExcel_Cell_DataType::TYPE_STRING);

			$a++;
													
				

			
			
			
			
			
			
			
	}
	
	


	
	$objPHPExcel->getActiveSheet(0)->getStyle('A1:E500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$objPHPExcel->getActiveSheet(0)->getStyle('A1:Z500')->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet(0)->getStyle('A1:N500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


	$title		= "flyta_v7_1.xls";
	
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
