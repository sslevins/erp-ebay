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
							 
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:B1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('A1','买家信息', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('A2','Ebay Buyer Id', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('B2','Buyer Email', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C1:D1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('C1','Shipping Service', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('C2','是否挂号', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('D2','派送方式', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E1:K1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('E1','Shipping Address', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('E2','收件人或完整的地址', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('F2',' Address Line 1', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('G2',' Address Line 2/District/Neighborhood', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('H2',' Town/City', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('I2',' State/Province', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('J2',' Zip/Postal Code', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('K2',' Country', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('L1:L2');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('L1','产品代码', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('M1:M2');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('M1','数量', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('N1:N2');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('N1','Paypal Transaction Id', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('O1:O2');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('O1','自定义数据', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('P1','是否重复', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('Q1','电话号码', PHPExcel_Cell_DataType::TYPE_STRING);
	
	
	
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
	echo "请选择订单！";
	//$sql	= "select a.*,b.sku,b.ebay_amount from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn = b.ebay_ordersn where ebay_user='$user' and a.ebay_combine!='1' order by a.ebay_username";	
	}else{	
	$sql	= "select a.*,b.sku,b.ebay_amount from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn = b.ebay_ordersn where ($ertj) and a.ebay_user='$user' and a.ebay_combine!='1' order by a.ebay_username";	
	}

	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);
	$a		= 3;
	
	
	$firstname		= '';
	
	for($i=0;$i<count($sql);$i++){
		$ebay_usermail			= $sql[$i]['ebay_usermail'];
		$ebay_userid			= $sql[$i]['ebay_userid'];	
		$name					= $sql[$i]['ebay_username'];
	    $street1				= @$sql[$i]['ebay_street'];
	    $street2 				= @$sql[$i]['ebay_street1'];
	    $city 					= $sql[$i]['ebay_city'];
	    $state					= $sql[$i]['ebay_state'];
	    $countryname 			= $sql[$i]['ebay_countryname'];
	    $zip					= $sql[$i]['ebay_postcode'];
	    $tel					= $sql[$i]['ebay_phone'];
		$ebay_noteb				= $sql[$i]['ebay_noteb'];
		$sku					= $sql[$i]['sku'];
		$amount					= $sql[$i]['ebay_amount'];
		$pid					= $sql[$i]['ebay_ptid'];
		$ebay_carrier					= $sql[$i]['ebay_carrier'];
		
		$sku					= $sql[$i]['sku'];
		
		
		$addressline	= $name.chr(13).$street1;
		if($street2 != ''){
				$addressline .= " ".$street2;
		}
		$addressline	.= chr(13);
		
		if($city != ''){
				$addressline .= " ".$city;
		}
		
		
		
		if($state != ''){
				$addressline .= " ".$state;
		}
		if($zip != ''){
				$addressline .= " ".$zip;
		}
		
		
	//	if($tel != '' )$addressline .= chr(13).'Tel: '.$tel;
		
		
		
		
		$addressline .= chr(13).$countryname;
		
			$ee					= "SELECT * FROM ebay_goods where goods_sn='$sku' and ebay_user='$user'";
			$ee					= $dbcon->execute($ee);
			$ee 			 	= $dbcon->getResultArray($ee);
			$goods_location		=  $ee[0]['goods_location'];			

			$rr			= "select * from ebay_productscombine where ebay_user='$user' and goods_sn='$sku'";
			$rr			= $dbcon->execute($rr);
			$rr 	 	= $dbcon->getResultArray($rr);

				
			if(count($rr) > 0){
			
									$goods_sncombine	= $rr[0]['goods_sncombine'];
									$goods_sncombine    = explode(',',$goods_sncombine);	
									for($e=0;$e<count($goods_sncombine);$e++){
											$pline			= explode('*',$goods_sncombine[$e]);
											$goods_sn		= $pline[0];
											$goddscount     = $pline[1] * $amount;
											$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('D'.$a, $ebay_carrier, PHPExcel_Cell_DataType::TYPE_STRING);
											$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$a, $addressline, PHPExcel_Cell_DataType::TYPE_STRING);
											$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('L'.$a, $goods_sn, PHPExcel_Cell_DataType::TYPE_STRING);
											$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$a, $goddscount);
											$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('N'.$a, $pit, PHPExcel_Cell_DataType::TYPE_STRING);
											$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('O'.$a, $ebay_noteb, PHPExcel_Cell_DataType::TYPE_STRING);
											$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('B'.$a, $ebay_usermail, PHPExcel_Cell_DataType::TYPE_STRING);
			
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('Q'.$a, $tel, PHPExcel_Cell_DataType::TYPE_STRING);

									}
			}else{
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('D'.$a, $ebay_carrier, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$a, $addressline, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('L'.$a, $sku, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$a, $amount);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('N'.$a, $pit, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('O'.$a, $ebay_noteb, PHPExcel_Cell_DataType::TYPE_STRING);
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('B'.$a, $ebay_usermail, PHPExcel_Cell_DataType::TYPE_STRING);
			
						$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('Q'.$a, $tel, PHPExcel_Cell_DataType::TYPE_STRING);

			
			}
	//	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(true);
		
		
		
		
		if($i >= 1){
				
				
				if($firstname  == $name) {
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('P'.$a, '重复', PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('P'.($a-1), '重复', PHPExcel_Cell_DataType::TYPE_STRING);
		
				}
		
		}	
		
		$firstname	= $name;
		$a++;
		
		
		


		
			
	
	

}
$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:O500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:O2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet(0)->getStyle('E1:E1000')->getAlignment()->setWrapText(true);

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(10);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(10);	

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(10);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(10);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(30);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(10);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(10);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth(10);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setWidth(10);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setWidth(15);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('K')->setWidth(15);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('L')->setWidth(12);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('M')->setWidth(12);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('O')->setWidth(12);

//$objPHPExcel->getActiveSheet(0)->getStyle('A1:O1000')->getAlignment()->setWrapText(true);




$title		= "速达".date('Y-m-d');
$titlename		= "速达".date('Y-m-d').".xls";

$objPHPExcel->getActiveSheet()->setTitle($title);

$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename={$titlename}");
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;


