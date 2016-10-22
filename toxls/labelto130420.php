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
												 



	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '投保易网邮保险服务');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '参考号');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '收件人姓名');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '收件人地址');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', '收件人电话');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', '收件人国家(二字编码)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', '邮编');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', '件数');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', '重量(kg)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', '海关品名');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', '物品数量');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', '申报单价');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', '币种');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', '产品标识(配货信息)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1', '运输方式');

	
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
			
				
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('A'.$a, 'N', PHPExcel_Cell_DataType::TYPE_STRING);
		//	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('B'.$a, $goods_namestr, PHPExcel_Cell_DataType::TYPE_STRING);

			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('C'.$a, $ebay_username, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('D'.$a, $ebay_street.' '.$ebay_street1.' '.$ebay_city.' '.$ebay_state, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$a, $ebay_phone, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('F'.$a, $ebay_couny, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('G'.$a, $ebay_postcode, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('H'.$a, count($vv), PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('I'.$a, $totalweight, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('J'.$a, $goods_ywsbmc, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('K'.$a, $totalqty, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('L'.$a, $goods_sbjz, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('M'.$a, $ebay_currency, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('N'.$a, $goods_namestr, PHPExcel_Cell_DataType::TYPE_STRING);

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
