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

	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Sales Record Number');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'User Id');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Buyer Fullname');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'Buyer Phone Number');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'Buyer Email');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'Buyer Address 1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', 'Buyer Address 2');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', 'Buyer City');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', 'Buyer State');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', 'Buyer Zip');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', 'Buyer Country');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', 'Item Number');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', 'Item Title');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', 'Custom Label');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1', 'isreturn');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1', 'category');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q1', 'Quantity');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R1', 'Sale Price');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S1', 'Shipping and Handling');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T1', 'US Tax');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U1', 'Insurance');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V1', 'Total Price');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W1', 'Payment Method');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X1', 'Sale Date');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y1', 'Checkout Date');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z1', 'Paid on Date');
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA1', 'Shipped on Date');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB1', 'Feedback left');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC1', 'Feedback received');
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD1', 'Notes to yourself');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AE1', 'Listed On');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AF1', 'Sold On');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AG1', 'PayPal Transaction ID');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AH1', 'Shipping Service');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AI1', 'Transaction ID');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AJ1', 'Order ID');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AK1', 'declared value');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AL1', 'weight');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AM1', 'is_insurance');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AN1', 'Length');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AO1', 'Width');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AP1', 'Height');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AQ1', 'company');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AR1', 'with_battery');
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AS1', 'Paypal Transaction ID');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AT1', '跟踪号');
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AU1', '重量');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AV1', '运费');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AW1', '扫描日期');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AX1', 'ebay 帐号');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AY1', '币种');
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AZ1', '订单编号');
	
	
	
		function shipfeecalc($shippingid,$kg,$ebay_countryname){
			global $dbcon;
			$ss				= " select * from ebay_systemshipfee where shippingid ='$shippingid'";
			$ss				= $dbcon->execute($ss);
			$ss				= $dbcon->getResultArray($ss);
			
			
			$kg				= $kg * 1000;
			$type			= $ss[0]['type'];
			
			$shipfee		= 0;
			
			
			if($type 		== 0){
			$vv				= "select * from ebay_systemshipfee where $kg between aweightstart and aweightend and acountrys like '%$ebay_countryname%' and shippingid ='$shippingid'";
			$vv				= $dbcon->execute($vv);
			$vv				= $dbcon->getResultArray($vv);
			$shipfee		= $vv[0]['ashipfee'] + $vv[0]['ahandlefee'] + $vv[0]['ahandlefee2'];
			$adiscount		= $ss[0]['adiscount'];
			if($adiscount<=0) $adiscount = 1;
			$shipfee		= $shipfee * $adiscount;	
			
			}else{
			$vv				= "select * from ebay_systemshipfee where  bcountrys like '%$ebay_countryname%' and shippingid ='$shippingid'";
			$vv				= $dbcon->execute($vv);
			$vv				= $dbcon->getResultArray($vv);
			$bfirstweight				= $vv[0]['bfirstweight'];
			$bfirstweightamount			= $vv[0]['bfirstweightamount'];
			$bnextweight				= $vv[0]['bnextweight'];
			$bnextweightamount			= $vv[0]['bnextweightamount'];
			$bhandlefee					= $vv[0]['bhandlefee'];
			$bdiscount					= $vv[0]['bdiscount']?$vv[0]['bdiscount']:1;
			
			if($bdiscount<=0) $bdiscount = 1;
			
			
			//echo 'KG='.$kg.' First weigth='.$bfirstweight;
			
			
				if($kg <= ($bfirstweight)){
				$shipfee	= $bfirstweightamount + $bhandlefee;
				}else{
				$shipfee	+= ceil((($kg-$bfirstweight)/$bnextweight))*$bnextweightamount ;
				
				$shipfee	 = $shipfee + $bfirstweightamount + $bhandlefee;
				
				}
				$shipfee				= $shipfee * $bdiscount;

				
			}
			return $shipfee;
		}
	
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

	

	$sql	= "select * from ebay_order as a where ebay_user='$user' and a.ebay_status='0' and a.ebay_combine!='1' ";	

	}else{	

	$sql	= "select * from ebay_order as a where ($ertj) and ebay_user='$user' and a.ebay_combine!='1' order by ebay_id desc ";	

	}	


	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);
	$a		= 2;	

	for($i=0;$i<count($sql);$i++){
		

		$ordersn		= $sql[$i]['ebay_ordersn'];
		$paidtime		= date('Y-m-d',strtotime($sql[$i]['ebay_paidtime']));
		$scantime		= date('Y-m-d',$sql[$i]['scantime']);
		$ebay_usermail	= $sql[$i]['ebay_usermail'];
		$ebay_userid	= $sql[$i]['ebay_userid'];	
		$name			= $sql[$i]['ebay_username'];
		$name	  	= str_replace("&acute;","'",$name);
		$name  		= str_replace("&quot;","\"",$name);
		
		
	    $street1		= @$sql[$i]['ebay_street'];
	    $street2 		= @$sql[$i]['ebay_street1'];

	    $city 				= $sql[$i]['ebay_city'];
		
	    $state				= $sql[$i]['ebay_state'];

	    $countryname 		= $sql[$i]['ebay_countryname'];
		$ebay_carrier 		= $sql[$i]['ebay_carrier'];
		$ebay_currency 		= $sql[$i]['ebay_currency'];
		$ss				= "select * from  ebay_carrier where name ='$ebay_carrier' ";
		$ss = $dbcon->execute($ss);
							$ss	= $dbcon->getResultArray($ss);
							
							
							$ids	= $ss[0]['id'];
							

	    $zip				= $sql[$i]['ebay_postcode'];

	    $tel				= $sql[$i]['ebay_phone'];

		$ebay_shipfee		= $sql[$i]['ebay_shipfee'];
		$ebay_ptid		= $sql[$i]['ebay_ptid'];
		$ebay_note			= $sql[$i]['ebay_note'];

		$ebay_total	 		= @$sql[$i]['ebay_total'];
		$recordnumber		= $sql[$i]['recordnumber'];
		$ebay_account		= $sql[$i]['ebay_account'];
		$ebay_tracknumber		= $sql[$i]['ebay_tracknumber'];
		
		$ss		= " select * from ebay_account where ebay_account='$ebay_account' and ebay_user='$user' ";
		$ss		= $dbcon->execute($ss);
		$ss		= $dbcon->getResultArray($ss);
		$appname= $ss[0]['appname'];
			

		
		
		if($ebay_account =='enjoyhobbies'){
			
				$ebayaccount			= "ej.";
				
		}else{
			
				$ebayaccount			= substr($ebay_account,0,5);
				
		}
		
		
		
		$ebay_phone				= $sql[$i]['ebay_phone'];
		$ebay_carrier				= $sql[$i]['ebay_carrier'];
		$ebay_createdtime				= date('Y-m-d',$sql[$i]['ebay_createdtime']);


		$addressline	= $street1." ".$street2;
		$addressline	  	= str_replace("&acute;","'",$addressline);
		$addressline  		= str_replace("&quot;","\"",$addressline);
		 $ebay_id 				= $sql[$i]['ebay_id'];

		

		$sl				= "select * from ebay_orderdetail where ebay_ordersn='$ordersn' ";
		$sl				= $dbcon->execute($sl);
		$sl				= $dbcon->getResultArray($sl);
		foreach($sl as $k=>$v){
			if($k==0){
			$linstr			= $appname.'-'.$v['recordnumber'];
			}else{
			$linstr			.= '+'.$appname.'-'.$v['recordnumber'].$key;
			}
		}


		for($o=0;$o<count($sl);$o++){			

		

			$sku1		= $sl[$o]['sku'];	
			$shipingfee	= $sl[$o]['shipingfee'];	
			$vv = "select goods_weight,goods_sbjz from ebay_goods where goods_sn='$sku1' and ebay_user='$user'";
			$vv				= $dbcon->execute($vv);
			$vv				= $dbcon->getResultArray($vv);
			$weight		= $vv[0]['goods_weight'];
			
			$totalshipfee  	=	shipfeecalc($ids,$weight,$countryname);
			
			$sbjz		= $vv[0]['goods_sbjz'];
			$sku	= $sl[$o]['ebay_itemtitle'];

			$amount	= $sl[$o]['ebay_amount'];

			$pic	= $sl[$o]['ebay_itemurl'];			
			$ebay_itemid			= $sl[$o]['ebay_itemid'];	
			$ebay_itemprice	= $sl[$o]['ebay_itemprice'];	

			$recordnumber	= $sl[$o]['recordnumber'];
			


			$ebaytoo		= number_format($amount*$ebay_itemprice,2);
			
			
			
			$objPHPExcel->setActiveSheetIndex(0)->getCell('A'.$a)->setValueExplicit($linstr, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('B'.$a)->setValueExplicit($ebay_userid, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('C'.$a)->setValueExplicit($name, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('D'.$a)->setValueExplicit($ebay_phone, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('E'.$a)->setValueExplicit($ebay_usermail, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('F'.$a)->setValueExplicit($street1, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('G'.$a)->setValueExplicit($street2, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('H'.$a)->setValueExplicit($city, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('I'.$a)->setValueExplicit($state, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('J'.$a)->setValueExplicit($zip, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('K'.$a)->setValueExplicit($countryname, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('L'.$a)->setValueExplicit($ebay_itemid, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('M'.$a)->setValueExplicit($sku, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('N'.$a)->setValueExplicit($sku1, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('Q'.$a)->setValueExplicit($amount, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('R'.$a)->setValueExplicit($ebay_itemprice, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('S'.$a)->setValueExplicit($ebay_shipfee, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('V'.$a)->setValueExplicit(number_format($ebaytoo+$shipingfee,2), PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('X'.$a)->setValueExplicit($ebay_createdtime, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('Y'.$a)->setValueExplicit($ebay_createdtime, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('Z'.$a)->setValueExplicit($ebay_createdtime, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('AK'.$a)->setValueExplicit($sbjz, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('AH'.$a)->setValueExplicit($ebay_carrier, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('AL'.$a)->setValueExplicit($weight, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('AS'.$a)->setValueExplicit($ebay_ptid, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('AT'.$a)->setValueExplicit($ebay_tracknumber, PHPExcel_Cell_DataType::TYPE_STRING);
			
			$objPHPExcel->setActiveSheetIndex(0)->getCell('AU'.$a)->setValueExplicit($weight, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('AV'.$a)->setValueExplicit($shipfee, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('AW'.$a)->setValueExplicit($scantime, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('AX'.$a)->setValueExplicit($ebay_account, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('AY'.$a)->setValueExplicit($ebay_currency, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('AZ'.$a)->setValueExplicit($ebay_id, PHPExcel_Cell_DataType::TYPE_STRING);
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

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth(35);







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







$title		= "Files_SD".date('Y-m-d');

$titlename		= "Files_SD".date('Y-m-d').".xls";



$objPHPExcel->getActiveSheet()->setTitle($title);



$objPHPExcel->setActiveSheetIndex(0);





// Redirect output to a client’s web browser (Excel5)

header('Content-Type: application/vnd.ms-excel');

header("Content-Disposition: attachment;filename={$titlename}");

header('Cache-Control: max-age=0');



$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

$objWriter->save('php://output');

exit;





