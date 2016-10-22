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

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Nombre');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'Apellido 1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Apellido 2');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'Empresa');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'Tipo documento');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'Número de documento');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', 'Teléfono');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', 'E-mail');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', 'Idioma');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', 'Tipo Vía');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', 'Nombre vía');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', 'Número');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', 'Bloque');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', 'Portal');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1', 'Escalera');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1', 'Piso');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q1', 'Puerta');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R1', 'Dirección');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S1', 'CP');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T1', 'Localidad');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U1', 'Provincia');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V1', 'Pais');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W1', 'Apartado postal');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X1', 'Alias ');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y1', 'Fin De registro');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z1', 'NOTES');
	
	$ertj		= "";
	$orders		= explode(",",$_REQUEST['ordersn']);
	$status		= $_REQUEST['ostatus'];
	for($g=0;$g<count($orders);$g++){

		$sn 	=  $orders[$g];

		if($sn != ""){

				

					$ertj	.= " a.ebay_id='$sn' or";

		}

			

	}

	$ertj			 = substr($ertj,0,strlen($ertj)-3);

	if($ertj == ""){

	

	$sql	= "select a.* from ebay_order as a where a.ebay_user='$user' and a.ebay_status='$status' and a.ebay_combine!='1' ";	

	}else{	

	$sql	= "select a.* from ebay_order as a  where ($ertj) and a.ebay_user='$user' and a.ebay_combine!='1' order by  a.ebay_id desc ";	

	}	
	
//echo $sql;
//exit;

	//$countrys	= $_REQUEST['country'];

	
	$sql		= $dbcon->execute($sql);
	$sql		= $dbcon->getResultArray($sql);
	
	
	$a			= 2;	
	
	$filepath	=   dirname(dirname(__FILE__));
	
	for($i=0;$i<count($sql);$i++){
		
		$ebay_id        = $sql[$i]['ebay_id'];
		//$paidtime		= date('Y-m-d',strtotime($sql[$i]['ebay_paidtime']));
		$ebay_usermail	= $sql[$i]['ebay_usermail'];
		$ebay_userid	= $sql[$i]['ebay_userid'];	
		$name			= $sql[$i]['ebay_username'];
		$name	 	 	= str_replace("&acute;","'",$name);
		$name  			= str_replace("&quot;","\"",$name);
		
		$paid_time		= @date('Y-m-d',$sql[$i]['ebay_paidtime']);
	    $street1			= @$sql[$i]['ebay_street'];
	    $street2 			= @$sql[$i]['ebay_street1'];
	    $city 				= $sql[$i]['ebay_city'];
	    $state				= $sql[$i]['ebay_state'];
	    $countryname 		= $sql[$i]['ebay_countryname'];

	    $zip				= $sql[$i]['ebay_postcode'];

	    $tel				= $sql[$i]['ebay_phone'];
		 $ordersn				= $sql[$i]['ebay_ordersn'];
		
		
			$sl				= "select sku,ebay_amount from ebay_orderdetail where ebay_ordersn='$ordersn'";
			$sl				= $dbcon->execute($sl);
			$sl				= $dbcon->getResultArray($sl);
	
			$qty			= 0;
			$tprice			= 0;
			$labelstr		= '';
			
			for($o=0;$o<count($sl);$o++){					
				$sku1					= $sl[$o]['sku'];	
				$amount					= $sl[$o]['ebay_amount'];
				$labelstr				.= $sku1.' * '.$amount;
			}

		$objPHPExcel->setActiveSheetIndex(0)->getCell('A'.$a)->setValueExplicit($name, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('G'.$a)->setValueExplicit($tel, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('H'.$a)->setValueExplicit($ebay_usermail, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('J'.$a)->setValueExplicit('C', PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('K'.$a)->setValueExplicit($street1.$street2, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('S'.$a)->setValueExplicit($zip, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('T'.$a)->setValueExplicit($city, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('U'.$a)->setValueExplicit($state, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('V'.$a)->setValueExplicit($countryname, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('Z'.$a)->setValueExplicit($labelstr, PHPExcel_Cell_DataType::TYPE_STRING);
		$a++;
}

$objPHPExcel->getActiveSheet(0)->getStyle('A1:X500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('Q')->setWidth(30);

$title			= "SP".date('Y-m-d');
$titlename		= "SP".date('Y-m-d').".xls";
$objPHPExcel->getActiveSheet()->setTitle($title);
$objPHPExcel->setActiveSheetIndex(0);





	
	



	$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);




header('Content-Type: application/vnd.ms-excel');

header("Content-Disposition: attachment;filename={$titlename}");

header('Cache-Control: max-age=0');



$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

$objWriter->save('php://output');

exit;





