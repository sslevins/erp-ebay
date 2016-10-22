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

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Shipping');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'Service');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Account');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'Date');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'From Email Address');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'Transaction ID');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', 'Shipping Address');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', 'Name');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', 'Address Line 1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', 'Address Line 2');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', 'Town/City');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', 'State/Province');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', 'Zip/Postal Code');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', 'Country');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1', 'Contact Phone Number');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1', 'Item ID');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q1', 'Auction Site');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R1', 'Buyer ID');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S1', 'Remark');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T1', 'Code1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U1', 'Item Title1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V1', 'Quantity1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W1', 'Code2');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X1', 'Quantity2');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y1', 'Item Title3');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z1', 'Quantity3');
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

	

	$sql	= "select * from ebay_order as a where a.ebay_user='$user' and a.ebay_status='1' and a.ebay_combine!='1' ";	

	}else{	

	$sql	= "select * from ebay_order as a where ($ertj) and a.ebay_user='$user' and a.ebay_combine!='1' ";	

	}

		

	$sql	= $dbcon->execute($sql);

	$sql	= $dbcon->getResultArray($sql);

	$a		= 2;

	

	for($i=0;$i<count($sql);$i++){

		

		$ordersn				= $sql[$i]['ebay_ordersn'];
		@$paidtime				= date('Y-m-d',$sql[$i]['ebay_paidtime']);
		$ebay_usermail			= $sql[$i]['ebay_usermail'];
		$ebay_userid			= $sql[$i]['ebay_userid'];
		$name					= $sql[$i]['ebay_username'];
		$name	  	= str_replace("&acute;","'",$name);
		$name  		= str_replace("&quot;","\"",$name);
		
		
	    $street1				= @$sql[$i]['ebay_street'];
	    $street2 				= @$sql[$i]['ebay_street1'];
	    $city 					= $sql[$i]['ebay_city'];
	    $state					= $sql[$i]['ebay_state'];
	    $countryname 			= $sql[$i]['ebay_countryname'];
	    $zip					= $sql[$i]['ebay_postcode'];
	    $tel					= $sql[$i]['ebay_phone'];
		$ebay_shipfee			= $sql[$i]['ebay_shipfee'];
		$ebay_note				= $sql[$i]['ebay_note'];
		$ebay_total				= @$sql[$i]['ebay_total'];
		$ebay_tracknumber		= @$sql[$i]['ebay_tracknumber'];
		$ebay_account			= @$sql[$i]['ebay_account'];
		$ebay_carrier			= @$sql[$i]['ebay_carrier'];

		$city	  	= str_replace("&acute;","'",$city);
		$city  		= str_replace("&quot;","\"",$city);
		
		$state	  		= str_replace("&acute;","'",$state);
		$state  		= str_replace("&quot;","\"",$state);
		

		

		$addressline		= $street1." ".$street2;
		$addressline	  	= str_replace("&acute;","'",$addressline);
		$addressline  		= str_replace("&quot;","\"",$addressline);
		

		$sl				= "select * from ebay_orderdetail where ebay_ordersn='$ordersn'";

		$sl				= $dbcon->execute($sl);

		$sl				= $dbcon->getResultArray($sl);

		
		$otarray = array('W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY');
		$ot = 0;

					if($countryname == 'United Kingdom' ){
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$a, "UKNRM");
			}else{
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$a, "UKNIR");
			}

			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$a, 'UK');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$a, $ebay_account);
			
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$a, date('Y').'/'.date('m').'/'.date('d'));
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$a, $name);
			//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$a, $ebay_usermail);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$a, $street1);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$a, $street2);
			
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$a, $city);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$a, $state);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('M'.$a, $zip, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$a, $countryname);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('O'.$a, $tel, PHPExcel_Cell_DataType::TYPE_STRING);
		for($o=0;$o<count($sl);$o++){			

		

			$recordnumber			= $sl[$o]['recordnumber'];
			$sku					= $sl[$o]['sku'];
			$title					= $sl[$o]['ebay_itemtitle'];
			$amount					= $sl[$o]['ebay_amount'];
			$ebay_itemprice			= $sl[$o]['ebay_itemprice'];
			$ebay_itemid			= $sl[$o]['ebay_itemid'];
			
		//	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$a, $sku);
			
			if($o==0){
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('T'.$a, $sku, PHPExcel_Cell_DataType::TYPE_STRING);
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('P'.$a, $ebay_itemid, PHPExcel_Cell_DataType::TYPE_STRING);
							
							
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$a, $ebay_userid);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$a, $title);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$a, $amount);
			}else{
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($otarray[$ot].$a, $sku);
				$ot++;
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($otarray[$ot].$a, $amount);
				$ot++;
			}
			
			$a++;

			

			

	

		}
$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('P'.$a, $sku, PHPExcel_Cell_DataType::TYPE_STRING);
	

	



}
$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('P1', 'StockShare', PHPExcel_Cell_DataType::TYPE_STRING);
$objPHPExcel->getActiveSheet(0)->getStyle('A1:N500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(10);	

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(25);	

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(15);	

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(15);	

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(15);	

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(30);

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(15);

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(25);

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(60);

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth(25);

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setWidth(45);

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setWidth(15);

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('M')->setWidth(15);

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('N')->setWidth(30);

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('K')->setWidth(45);



$objPHPExcel->getActiveSheet(0)->getStyle('A1:M500')->getAlignment()->setWrapText(true);









$title		= "产品出库表";


$titlename		= "产品出库表".date('Y-m-d').".xls";



$objPHPExcel->getActiveSheet()->setTitle($title);



$objPHPExcel->setActiveSheetIndex(0);





// Redirect output to a client’s web browser (Excel5)

header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename={$titlename}");
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>

