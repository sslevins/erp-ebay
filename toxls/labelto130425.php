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
												 
																


	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '日期');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '订单编号');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '购买时间');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '姓名');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', '销售总价');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', '运费');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', '净价');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', '利润');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', '库存数量');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', '标题');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', '街道');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', '城市');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', '州');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', '邮编');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1', '国家');

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1', 'SKU/型号');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q1', '数量');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R1', '备注');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S1', '帐号');
	

	
	
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
	$sql	= "select *  from ebay_order as a   where ($ertj) and a.ebay_user='$user' and a.ebay_combine!='1' order by a.ebay_paidtime asc ";	
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
$ebay_paidtime					= $sql[$i]['ebay_paidtime'];
			$vv			= "select * from ebay_account where ebay_account='$ebay_account' ";
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
				$ebay_amount				= $vv[$v]['ebay_amount'];
$ebay_itemtitle					= $vv[$v]['ebay_itemtitle'];				
				
				$jj			= "select * from ebay_goods where ebay_user ='$user' and goods_sn='$SKU' ";
				$jj			= $dbcon->execute($jj);
				$jj			= $dbcon->getResultArray($jj);

				
				 $goods_sbjz	= $jj[0]['goods_sbjz'];
				$totalweight += $jj[0]['goods_weight'];
				$goods_ywsbmc	= $jj[0]['goods_ywsbmc'];
				$goods_namestr	.= $jj[0]['goods_zysbmc'];
				
				$itemstr		.=  $jj[0]['goods_name'];
				
				
				
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('A'.$a, date('Y-m-d H:i:s').sprintf("%04d", $i+1), PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('B'.$a, $ebay_id, PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('C'.$a, date('Y-m-d H:i:s',$ebay_paidtime), PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('D'.$a, $ebay_username, PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$a, $ebay_total, PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('J'.$a, $ebay_itemtitle, PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('K'.$a, $ebay_street.' '.$ebay_street1, PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('L'.$a, $ebay_city, PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('M'.$a, $ebay_state, PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('N'.$a, $ebay_postcode, PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('O'.$a, $ebay_couny, PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('P'.$a, $SKU, PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('Q'.$a, $ebay_amount, PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('S'.$a, $ebay_account, PHPExcel_Cell_DataType::TYPE_STRING);
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
