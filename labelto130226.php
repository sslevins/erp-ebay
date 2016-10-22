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
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'Nombre');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', 'Apellidos');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', 'Dirección');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D2', 'C.P.');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E2', 'Las pegatina');
	


$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Relación de certificados');
	
	
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:E1'); 
	$ertj		= "";
	$orders		= explode(",",$_REQUEST['ordersn']);
	for($g=0;$g<count($orders);$g++){
		$sn 	=  $orders[$g];
		if($sn != ""){
				
					$ertj	.= " a.ebay_id='$sn' or";
		}
			
	}
	$ertj			 = substr($ertj,0,strlen($ertj)-3);
	$ostatus		= $_REQUEST['ostatus'];
	
	if($ertj == ""){
	
	
	
		$sql			= "select * from ebay_order as a  where a.ebay_userid !=''  and ebay_status='$ostatus' and ebay_combine!='1' group by a.ebay_id ";
			
			
			
			
	}else{	
	$sql	= "select * from ebay_order as a where ($ertj) and ebay_user='$user' and a.ebay_combine!='1' ";
	
			
	}	
	

	
		
	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);
	$a		= 3;
	
	for($i=0;$i<count($sql);$i++){
		
		$ebay_id				= $sql[$i]['ebay_id'];	
		
		$paidtime				= date('Y-m-d',$sql[$i]['ebay_paidtime']);
		$ebay_usermail			= $sql[$i]['ebay_usermail'];
		$ebay_userid			= $sql[$i]['ebay_userid'];	
		$names					= $sql[$i]['ebay_username'];
	    $street1				= @$sql[$i]['ebay_street'];
	    $street2 				= @$sql[$i]['ebay_street1'];
	    $city 					= $sql[$i]['ebay_city'];
	    $state					= $sql[$i]['ebay_state'];
	    $countryname 			= $sql[$i]['ebay_countryname'];
		$cnname					= $country[$countryname];
	    $zip					= $sql[$i]['ebay_postcode'];
	    $tel					= $sql[$i]['ebay_phone'];
		$ebay_shipfee			= $sql[$i]['ebay_shipfee'];
		$ebay_note				= $sql[$i]['ebay_note'];
		$ebay_total				= @$sql[$i]['ebay_total'];
		$ebay_tracknumber		= @$sql[$i]['ebay_tracknumber'];
		$ebay_account			= @$sql[$i]['ebay_account'];
		$recordnumber0			= @$sql[$i]['recordnumber'];
		$ebay_carrier			= @$sql[$i]['ebay_carrier'];
		$ebay_phone				= $sql[$i]['ebay_phone'];
		$ebay_currency			= $sql[$i]['ebay_currency'];
		$orderweight2			= number_format($sql[$i]['orderweight2']/1000,3);
		$ordershipfee			= $sql[$i]['ordershipfee'];


		$addressline	= $street1;
		if($street2 != ''){
			
				$addressline .= " , ".$street2;
		}
		
		if($city != ''){
			
				$addressline .= " , ".$city;
		}
		
		if($state != ''){
			
				$addressline .= " , ".$state." , ".$countryname;
		}
		
		
		

			
			
						
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$a, $names);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$a, $names);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$a, $addressline);
			
			
		
			
			$objPHPExcel->setActiveSheetIndex(0)->getCell('D'.$a)->setValueExplicit($zip, PHPExcel_Cell_DataType::TYPE_STRING);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$a, '');

		
			
			$a++;
		
		

		
		}

	
		
		
		
		
	
		
		
		
		

	
	


$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:A1')->getFont()->setSize(22);

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(15);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(15);		
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(28);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(15);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(15);

$objPHPExcel->getActiveSheet(0)->getStyle('A1:M500')->getAlignment()->setWrapText(true);




$title		= "XIBANYA".date('Y-m-d');
$titlename		= "XIBANYA".date('Y-m-d').".xls";

$objPHPExcel->getActiveSheet()->setTitle($title);

$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename={$titlename}");
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;


