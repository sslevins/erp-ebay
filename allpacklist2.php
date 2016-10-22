<?php
@session_start();
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

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'paypal付款日期');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '邮件名');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '买家 ebay ID');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '物品名');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', '图片');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'Label');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', '姓名、地址、电话');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', '数量');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', '价格');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', 'Paypal Notes');
	$ertj		= "";
	$orders		= explode(",",$_REQUEST['ordersn']);
	for($g=0;$g<count($orders);$g++){
		$sn 	=  $orders[$g];
		if($sn != ""){
				
					$ertj	.= " a.ebay_ordersn='$sn' or";
		}
			
	}
	$ertj			 = substr($ertj,0,strlen($ertj)-3);
	if($ertj == ""){
	
	$sql	= "select * from ebay_order as a where ebay_user='$user' and a.ebay_status='0' and a.ebay_combine!='1' ";	
	}else{	
	$sql	= "select * from ebay_order as a where ($ertj) and ebay_user='$user' and a.ebay_combine!='1' ";	
	}	
	$country	= $_REQUEST['country'];
	if($country != '' && $country !='0'){		
		$sql	.= " and a.ebay_countryname='$country' order by ebay_account,recordnumber";	
	}else{	
		$sql	.= "  order by ebay_paidtime desc";	
	}
	
		
	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);
	$a		= 2;
	
	for($i=0;$i<count($sql);$i++){
		
		$ordersn		= $sql[$i]['ebay_ordersn'];	
		$paidtime		= date('Y-m-d',strtotime($sql[$i]['ebay_paidtime']));
		$ebay_usermail	= $sql[$i]['ebay_usermail'];
		$ebay_userid	= $sql[$i]['ebay_userid'];	
		$name			= $sql[$i]['ebay_username'];
	    $street1		= @$sql[$i]['ebay_street'];
	    $street2 		= @$sql[$i]['ebay_street1'];
	    $city 			= $sql[$i]['ebay_city'];
	    $state			= $sql[$i]['ebay_state'];
	    $countryname 	= $sql[$i]['ebay_countryname'];
	    $zip			= $sql[$i]['ebay_postcode'];
	    $tel			= $sql[$i]['ebay_phone'];
		$ebay_shipfee			= $sql[$i]['ebay_shipfee'];
		$ebay_note		= $sql[$i]['ebay_note'];
		 $ebay_total	 		= @$sql[$i]['ebay_total'];
		
		$addressline	= $name.chr(10).$street1." ".$street2.chr(10).$city.", ".$state.chr(10).$zip.chr(10).$countryname.chr(10).$tel;
		
		$sl				= "select * from ebay_orderdetail where ebay_ordersn='$ordersn'";
		$sl				= $dbcon->execute($sl);
		$sl				= $dbcon->getResultArray($sl);
		$aa			= 'A'.$a;
			$bb			= 'B'.$a;
			$cc			= 'C'.$a;
			$dd			= 'D'.$a;
			$ee			= 'E'.$a;		
			$ff			= 'F'.$a;		
			$gg			= 'G'.$a;
			$hh			= 'H'.$a;
			$ii			= 'I'.$a;
		$ii			= 'J'.$a;
		for($o=0;$o<count($sl);$o++){			
		
			$sku1	= $sl[$o]['sku'];	
			$sku	= $sl[$o]['ebay_itemtitle'];
			$amount	= $sl[$o]['ebay_amount'];
			$pic	= $sl[$o]['ebay_itemurl'];			
			$ebay_itemprice	= $sl[$o]['ebay_itemprice'];	
			if(filesize($pic)/1024 <=0){			
				$pic	= "failure.jpg";				
			}
			
			if($o>0){
				
				$paidtime		= '';
				$ebay_usermail	= '';
				$ebay_userid	= '';
				
			
			}
			
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$a, "".$paidtime);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$a, "".$ebay_usermail);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$a, "".$ebay_userid);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$a, "".$sku);
			//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$a, "".$amount);
			
			
			
			
			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setName('PHPExcel logo');
			$objDrawing->setDescription('PHPExcel logo');
			$objDrawing->setPath($pic);
			$objDrawing->setHeight(66);
			$objDrawing->setCoordinates('E'.$a);
			$objDrawing->setOffsetX(10);
			$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
			
			

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$a, "".$sku1);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$a, "".$addressline);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$a, "".$amount);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$a, "".$ebay_total);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$a, "".$ebay_note);
			
			
			$a++;
			
			
	
		}
	
	

}
$objPHPExcel->getActiveSheet(0)->getStyle('A1:N500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(15);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(20);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(20);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(20);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(15);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(50);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(32);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth(5);



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



$title		= "Address".date('Y-m-d');
$titlename		= "Address".date('Y-m-d').".xls";

$objPHPExcel->getActiveSheet()->setTitle($title);

$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename={$titlename}");
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;


