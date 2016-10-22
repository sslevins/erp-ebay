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
	$sql			= "select * from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn=b.ebay_ordersn where ebay_userid !='' and ($ertj) group by a.ebay_id order by b.sku asc ";
	
	}	
	

	
		
	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);
	$a		= 1;
	
	for($i=0;$i<count($sql);$i++){
		
		$ebay_id				= $sql[$i]['ebay_id'];	
		$ordersn				= $sql[$i]['ebay_ordersn'];
		$paidtime				= date('Y-m-d',$sql[$i]['ebay_paidtime']);
		$ebay_usermail			= $sql[$i]['ebay_usermail'];
		$ebay_userid			= $sql[$i]['ebay_userid'];	
		$names					= strtoupper($sql[$i]['ebay_username']);
	    $street1				= @$sql[$i]['ebay_street'];
	    $street2 				= @$sql[$i]['ebay_street1'];
	    $city 					= $sql[$i]['ebay_city'];
	    $state					= $sql[$i]['ebay_state'];
	    $countryname 			= strtoupper($sql[$i]['ebay_countryname']);
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


		$addressline	= 'Send To: '.$names;
		if($tel){
			$addressline .= chr(13).'Tel: '.$tel;
		}
		if($street2 != ''){
			
				$addressline .= chr(13).$street1." , ".$street2;
		}else{
			$addressline .= chr(13).$street1;
		}
		
		
			
		$addressline .= chr(13).$city.",".$state.",".$zip.chr(13).$countryname.chr(13);
		$sl				= "select * from ebay_orderdetail where ebay_ordersn='$ordersn' order by sku asc ";
		$sl				= $dbcon->execute($sl);
		$sl				= $dbcon->getResultArray($sl);
		$skuline		= $recordnumber0;
		foreach($sl as $k=>$v){
			$sku = $v['sku'];
			$amount = $v['ebay_amount'];
			if($amount>1){
				if(($k+1)%3 == 1){
					$skuline .= chr(13).$sku.'*'.$amount;
				}else{
					$skuline .= ','.$sku.'*'.$amount;
				}
			}else{
				if(($k+1)%3 == 1){
					$skuline .= chr(13).$sku;
				}else{
					$skuline .= ','.$sku;
				}
			}
		}
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$a, '');
		if(($i+1)%2 == 1){
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$a, $skuline);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$a, $addressline);
		}else{
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$a, $skuline);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$a, $addressline);
		$a++;
		}
		}

	
		
		
		
		
	
		
		
		
		

	
	
	$objPHPExcel->getActiveSheet(0)->getStyle('B1:B500')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objPHPExcel->getActiveSheet(0)->getStyle('B1:B500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);
	
	$objPHPExcel->getActiveSheet(0)->getStyle('B1:B500')->getFont()->setSize(9);
	$objPHPExcel->getActiveSheet(0)->getStyle('B1:B500')->getFont()->setName("Calibri");
	
	
	
	$objPHPExcel->getActiveSheet(0)->getStyle('D1:D500')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objPHPExcel->getActiveSheet(0)->getStyle('D1:D500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);
	
	$objPHPExcel->getActiveSheet(0)->getStyle('D1:D500')->getFont()->setSize(9);
	$objPHPExcel->getActiveSheet(0)->getStyle('D1:D500')->getFont()->setName("Calibri");
	
	
	
	$objPHPExcel->getActiveSheet(0)->getStyle('C1:C500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$objPHPExcel->getActiveSheet(0)->getStyle('C1:C500')->getFont()->setSize(12);
	$objPHPExcel->getActiveSheet(0)->getStyle('C1:C500')->getFont()->setName("Calibri");
	
	
	$objPHPExcel->getActiveSheet(0)->getStyle('E1:E500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$objPHPExcel->getActiveSheet(0)->getStyle('E1:E500')->getFont()->setSize(12);
	$objPHPExcel->getActiveSheet(0)->getStyle('E1:E500')->getFont()->setName("Calibri");
	
	
	

//s$objPHPExcel->getActiveSheet(0)->getStyle('A1:N500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(0);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(12.99);		
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(37.92);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(12.99);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(37.92);

$objPHPExcel->getActiveSheet(0)->getStyle('A1:M500')->getAlignment()->setWrapText(true);




$title		= "max600".date('Y-m-d');
$titlename		= "max600".date('Y-m-d').".xls";

$objPHPExcel->getActiveSheet()->setTitle($title);

$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename={$titlename}");
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;


