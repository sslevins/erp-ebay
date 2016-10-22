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
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '2');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '3');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '4');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', '5');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', '6');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', '7');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', '8');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', '9');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', '10');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', '11');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', '12');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', '13');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', '14');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1', '15');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1', '16');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q1', '17');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R1', '18');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S1', '19');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T1', '20');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U1', '21');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V1', '22');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:I2');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'DATOS DESTINATARIO');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('J2:U2');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J2', 'DATOS ENVÍO');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V2', 'DATOS REMITENTE');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', 'NOMBRE DESTINATARIO');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', 'DIRECCIÓN');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', 'LOCALIDAD');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', 'COD POSTAL');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', 'COD PROVINCIA');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', 'COD PAÍS');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', 'TELÉFONO');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', 'TELÉFONO MÓVIL');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', 'EMAIL');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', 'PRODUCTO');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K3', 'REFERENCIA');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3', 'OBSERVACIONES');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M3', 'PESO');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N3', 'ALTO');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O3', 'LARGO');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P3', 'ANCHO');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q3', 'IMP REEMBOLSO');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R3', 'IMP SEGURO');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S3', 'IMP VAL DECLAR');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T3', 'MODALIDAD ELEGIDA');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U3', 'OFICINA ELEGIDA');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V3', 'CIF');
	

	$type = $_REQUEST['type'];
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
	$a		= 4;
	
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
		$ebay_noteb				= $sql[$i]['ebay_noteb'];
		$ebay_total				= @$sql[$i]['ebay_total'];
		$ebay_tracknumber		= @$sql[$i]['ebay_tracknumber'];
		$ebay_account			= @$sql[$i]['ebay_account'];
		$recordnumber0			= @$sql[$i]['recordnumber'];
		$ebay_carrier			= @$sql[$i]['ebay_carrier'];
		$ebay_phone				= $sql[$i]['ebay_phone'];
		$ebay_currency			= $sql[$i]['ebay_currency'];
		$orderweight2			= number_format($sql[$i]['orderweight2']/1000,3);
		$ordershipfee			= $sql[$i]['ordershipfee'];
		if($type == '1'){
			$show = 'ST';
		}else{
			$show = 'OR';
		}
		$zip2					= substr($zip,0,2);
		$addressline	= $street1;
		if($street2 != ''){
			
				$addressline .= " , ".$street2;
		}

		
		
		

			
			
						
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$a, $names);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$a, $addressline);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$a, $city);
			
			
		
			
			
			$objPHPExcel->setActiveSheetIndex(0)->getCell('D'.$a)->setValueExplicit($zip, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('E'.$a)->setValueExplicit($zip2, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('G'.$a)->setValueExplicit($tel, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('H'.$a)->setValueExplicit($tel, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$a, $ebay_usermail);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$a, $ebay_noteb);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$a, 200);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$a, 1);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$a, 10);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$a, 15);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$a, $show);
			$a++;
		
		

		
		}

	
		
		
		
		
	
		
		
		
		

	
	


$objPHPExcel->getActiveSheet(0)->getStyle('A1:N500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(15);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(25);		
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(18);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(15);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(15);

$objPHPExcel->getActiveSheet(0)->getStyle('A1:M500')->getAlignment()->setWrapText(true);




$title		= "XIBANYA2".date('Y-m-d');
$titlename		= "XIBANYA2".date('Y-m-d').".xls";

$objPHPExcel->getActiveSheet()->setTitle($title);

$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename={$titlename}");
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;


