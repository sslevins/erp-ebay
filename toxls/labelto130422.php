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
												 


							

	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '交易号');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '门店');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '发货仓库');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '运费');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', '其他支出');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', '其他收入');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', '付款方式');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', '币别');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', '备注');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', '业务员');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', '会员');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', '销售日期');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', '付款时间');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', '商品编码');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1', '挂单名称');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1', '商品数量');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q1', '单价');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R1', '公司名称');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S1', '发货方式');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T1', '客户名称');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U1', '电话');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V1', '街道1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W1', '街道2');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X1', '城市');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y1', '州');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z1', '国家');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA1', '邮编');

	
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

	


	$ssdate	= date('Y-m-d');


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
			$ebay_tracknumber					= $sql[$i]['ebay_tracknumber'];
			$ebay_phone						= $sql[$i]['ebay_phone'];
			$ebay_couny						= $sql[$i]['ebay_couny'];
			
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
			$tqty			= 0;
			
			
			for($v=0;$v<count($vv);$v++){
				
				$SKU						= $vv[$v]['sku'];
				$ebay_amount				= $vv[$v]['ebay_amount'];
				$recordnumber				= $vv[$v]['recordnumber'];
$ebay_shiptype				= $vv[$v]['ebay_shiptype'];
			//	$labelstr					= $SKU .'*'.$ebay_amount;
				
			
				//$tqty 					+= $ebay_amount;
				
						

				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('N'.$a, $SKU, PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('P'.$a, $ebay_amount, PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('T'.$a, $ebay_username, PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('U'.$a, $ebay_phone, PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('V'.$a, $ebay_street, PHPExcel_Cell_DataType::TYPE_STRING);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('W'.$a, $ebay_street1, PHPExcel_Cell_DataType::TYPE_STRING);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('X'.$a, $ebay_city, PHPExcel_Cell_DataType::TYPE_STRING);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('Y'.$a, $ebay_state, PHPExcel_Cell_DataType::TYPE_STRING);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('Z'.$a, $ebay_couny, PHPExcel_Cell_DataType::TYPE_STRING);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('AA'.$a, $ebay_postcode, PHPExcel_Cell_DataType::TYPE_STRING);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('R'.$a, $ebay_id, PHPExcel_Cell_DataType::TYPE_STRING);

					

								
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('S'.$a, $ebay_shiptype, PHPExcel_Cell_DataType::TYPE_STRING);
	$a++;		

			}
					
				

			
			
			
			
			
			
			
	}
	
	


	
	$objPHPExcel->getActiveSheet(0)->getStyle('A1:Z500')->getAlignment()->setWrapText(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('V')->setWidth(50);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('W')->setWidth(50);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('U')->setWidth(20);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('T')->setWidth(20);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('X')->setWidth(30);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('Y')->setWidth(30);


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
