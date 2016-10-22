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
							 
							 
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Order Date');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'Order Time');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Time Zone');
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'Customer Name (Paypal)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'Type');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'Paypal Status');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', 'Currency');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', 'Gross');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', 'Fee');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', 'Net');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', 'From Email Address');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', 'To Email Address');
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', 'Transaction ID');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', 'Counterparty Status');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1', 'Address Status');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1', 'Item Title');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q1', 'Ebay Item ID');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R1', 'Postage and Packing');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S1', 'Insurance Amount');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T1', 'VAT');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U1', 'Option 1 Name');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V1', 'Option 1 Value');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W1', 'Option 2 Name');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X1', 'Option 2 Value');
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y1', 'Auction Site');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z1', 'Buyer ID');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA1', 'Item URL');
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB1', 'Closing Date');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC1', 'Escrow ID');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD1', 'Invoice ID');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AE1', 'Reference Txn ID');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AF1', 'Invoice Number');
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AG1', 'Custom Number');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AH1', 'Receipt ID');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AI1', 'Balance');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AJ1', 'Address Line 1 (Paypal)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AK1', 'Address Line 2  (Paypal)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AL1', 'Town/City  (Paypal)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AM1', 'State/Province/Region  (Paypal)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AN1', 'Postcode  (Paypal)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AO1', 'Country (Paypal)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AP1', 'Socket Type');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AQ1', 'Contract Phone Number  (Paypal)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AR1', 'Customer Name (Ebay)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AS1', 'Item Code (SKU)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AT1', 'Qty');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AU1', 'Shipping Date');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AV1', 'Express Type');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AW1', 'Customer Order Note');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AX1', 'Remarks on Bag Labels');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AY1', 'Remarks');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AZ1', 'Category');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BA1', 'Customs Fee');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BB1', 'Weight');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BC1', 'Shop ID');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BD1', 'Paypal Account');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BE1', 'UK Order Shipment Date');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BF1', 'US Order');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BG1', 'AU Order');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BH1', 'WE US Order');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BI1', 'Refund');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BJ1', 'Refund Type');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BK1', 'Refund Reason');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BL1', 'Currency');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BM1', 'Gross');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BN1', 'Refund HKD');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BO1', 'Date');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BP1', 'Resend Item Code');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BQ1', 'Quantity');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BR1', 'Resend Date');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BS1', 'Resend Express Type');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('BT1', 'Resend Reason');
	
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
	$a		= 2;
	
	for($i=0;$i<count($sql);$i++){
		
		$ebay_id				= $sql[$i]['ebay_id'];	
		$ordersn				= $sql[$i]['ebay_ordersn'];
		$paidtime				= date('Y-m-d',$sql[$i]['ebay_paidtime']);
		$paidtime1				= date('H:i:s',$sql[$i]['ebay_paidtime']);
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
		$ebay_ptid				= $sql[$i]['ebay_ptid'];
		
		
		
		
		
		/* 取得paypal fee */
		
		$sl				= "SELECT * FROM  ebay_paypaldetail where tid ='$ebay_ptid' ";
		$sl				= $dbcon->execute($sl);
		$sl				= $dbcon->getResultArray($sl);
		$gross			= $sl[0]['gross'];
		$net			= $sl[0]['net'];
		$fee			= $sl[0]['fee'];
		
		
		
		$sl				= "select * from ebay_orderdetail where ebay_ordersn='$ordersn' order by sku asc ";
		$sl				= $dbcon->execute($sl);
		$sl				= $dbcon->getResultArray($sl);
		
		for($j=0;$j<count($sl);$j++){
		
				$ebay_itemid				= $sl[$j]['ebay_itemid'];
				$ebay_itemtitle				= $sl[$j]['ebay_itemtitle'];
				$sku						= $sl[$j]['sku'];
				$ebay_amount						= $sl[$j]['ebay_amount'];
				
				
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$a, $paidtime);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$a, $paidtime1);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$a, 'GTM +8:00');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$a, $names);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$a, '-');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$a, 'Completed');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$a, $ebay_currency);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$a, '-');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$a, '-');
				
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$a, $ebay_itemtitle);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$a, $ebay_itemid);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$a, '-');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$a, '-');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$a, '-');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$a, '-');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$a, '-');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.$a, '-');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.$a, '-');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y'.$a, 'ebay');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z'.$a, $ebay_userid);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA'.$a, 'http://cgi.ebay.com/ws/eBayISAPI.dll?ViewItem&item='.$ebay_itemid);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB'.$a, $paidtime);
				
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC'.$a, '-');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD'.$a, '-');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AE'.$a, '-');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AF'.$a, '-');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AG'.$a, '-');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AH'.$a, '-');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AI'.$a, '-');
				
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AJ'.$a, $street1);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AK'.$a, $street2);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AL'.$a, $city);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AM'.$a, $state);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AN'.$a, $zip);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AO'.$a, $countryname);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AP'.$a, '-');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AR'.$a, $names);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AS'.$a, $sku);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AT'.$a, $ebay_amount);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AU'.$a, '-');
				
				
				
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$a, $gross);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$a, $net);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$a, $fee);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$a, $ebay_usermail);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$a, $ebay_ptid);
				$PayPalEmailAddress			= $sl[$i]['PayPalEmailAddress'];
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$a, $PayPalEmailAddress);
				
				
				$a++;
				
		
		
		}
		
		

	
		
		}
		
		
		
		
		
	/*
	
	
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
	
	*/
	
	

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


