<?php
include "include/dbconnect.php";	
$dbcon	= new DBClass();
error_reporting(0);
@session_start();
$user	= $_SESSION['user'];
require_once 'Classes/PHPExcel.php';

$objPHPExcel = new PHPExcel();


$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");

	$a		= 2;
	$b		= 2;
	$c		= 1;
	$d		= 1;
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'EBAY ID');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'Buyer Country');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Buyer Fullname');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'Buyer Phone Number');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'Buyer Address 1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'Buyer Address 2');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', 'Buyer City');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', 'Buyer State');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', 'Buyer Zip');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', 'Item Title');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', 'Quantity');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', 'Shipping Service');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', 'declared value');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', 'isreturn');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1', 'Notes');

	function getmerge($ordersn){
		
		global $dbcon;
	
		
	
		$sql	= "select * from ebay_orderdetail where ebay_ordersn='$ordersn' and ebay_user='$user'";
		$sql	= $dbcon->execute($sql);
		$sql	= $dbcon->getResultArray($sql);

		
		
		
				$count		= 0;
		$skuarray	= array();
		$tj			= "";
		
		for($i=0;$i<count($sql);$i++){			
				
			$sku	= $sql[$i]['sku'];
			$count	+= $sql[$i]['ebay_amount'];
			$tj		= $sku;
			
				
			
		}
			
	
		return $tj;
		
			
		
		
	}
	
	
		function getcount($ordersn){
		
		global $dbcon;
	
		
	
		$sql	= "select * from ebay_orderdetail where ebay_ordersn='$ordersn'";
		$sql	= $dbcon->execute($sql);
		$sql	= $dbcon->getResultArray($sql);

		
		
		
				$count		= 0;
		$skuarray	= array();
		$tj			= "";
		
		for($i=0;$i<count($sql);$i++){			
				
			$sku	= $sql[$i]['sku'];
			$count	+= $sql[$i]['ebay_amount'];
			$tj		= $sku."*".$count;	
				
			
		}
			
	
		return $count;
		
			
		
		
	}
	
	
	
	
	
	
	$sql	= "select * from ebay_order where ebay_status='1' and ebay_user='$user'";
	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);
	
	for($i=0;$i<count($sql);$i++){
		

		$aa			= 'A'.$a;
		$bb			= 'B'.$a;
		$cc			= 'C'.$a;
		$dd			= 'D'.$a;
		$ee			= 'E'.$a;
		$ff			= 'F'.$a;
		$gg			= 'G'.$a;
		$hh			= 'H'.$a;
		$ii			= 'I'.$a;
		$jj			= 'J'.$a;
		$kk			= 'K'.$a;
		$ll			= 'L'.$a;
		$mm			= 'M'.$a;
		$oo			= 'o'.$a;
	
		$ebayaccount	= $sql[$i]['ebay_account'];
		$userid			= $sql[$i]['ebay_userid'];
		$name			= $sql[$i]['ebay_username'];
	    $street1		= @$sql[$i]['ebay_street'];
	    $street2 		= @$sql[$i]['ebay_street1'];
	    $city 			= $sql[$i]['ebay_city'];
	    $state			= $sql[$i]['ebay_state'];
	    $countryname 	= $sql[$i]['ebay_countryname'];
	    $zip0			= $sql[$i]['ebay_postcode'];
		$zip			= "";
		if($countryname=='United States'){
		
		$zip			= $zip0;
		$objPHPExcel->setActiveSheetIndex(0)->getStyle($ii)->getNumberFormat()->setFormatCode('00000');

		}else{
		
		$zip			= " ".$zip0;
		}
		
	    $tel			= $sql[$i]['ebay_phone'];
		$recordnumber   = $sql[$i]['recordnumber'];
		$is_reg		   = $sql[$i]['is_reg'];
		
		if($tel =="") $tel = "";
		$ordersn		= $sql[$i]['ebay_ordersn'];
	
		 $ebay_note 			= $sql[$i]['ebay_note'];
		
		if($tel	!= ""){
		
			
			$addressline	= $name.chr(10).$street1." ".$street2.chr(10).$city.", ".$state.chr(10).$zip.chr(10).$countryname.chr(10).$tel."     $merge ";
			
		}else{
		
			
			$addressline	= $name.chr(10).$street1." ".$street2.chr(10).$city.", ".$state.chr(10).$zip.chr(10).$countryname."     $merge ";
			
		}
	
		$addressline	= str_replace("&acute","'",$addressline);
		$itemtitle		= getmerge($ordersn);
		$itemcount		= getcount($ordersn);
		
		
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($aa, $userid);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($bb, $countryname);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cc, $name);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($dd, " ".$tel);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($ee, " ".$street1);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($ff, " ".$street2);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($gg, " ".$city);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($hh, " ".$state);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($ii, $zip);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($jj, " ".$itemtitle);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kk, $itemcount);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($ll, " ".'HKBAM');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($mm, " ".'10');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($oo, $ebay_note);
		
		$a		= $a+1;
		
	}
	
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(15);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(20);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(20);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(20);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(25);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(20);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(20);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth(20);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setWidth(15);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setWidth(20);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('K')->setWidth(8);


$title		= "Address".date('Y-m-d');
$titlename		= "Address".date('Y-m-d').".xls";

$objPHPExcel->getActiveSheet()->setTitle($title);


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename={$titlename}");
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;










?>
