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

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Tracking Number');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'Date/Time');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Postage Amount');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'Amount');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'Custom Label');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'Quantity');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', 'Contents');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', 'Total Weight');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', 'Shipping Method');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', 'Package Material');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', 'Internal Sort');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', 'Sales Record Number');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', 'Paid on Date');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', 'Notes to yourself');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1', 'User Id');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1', 'Buyer Fullname');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q1', 'Buyer Phone Number');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R1', 'Buyer Email');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S1', 'Buyer Address 1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T1', 'Buyer Address 2');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U1', 'Buyer Town/City');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V1', 'Buyer State');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W1', 'Buyer Postcode');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X1', 'Buyer Country');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y1', 'Item Number');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z1', 'Item Title');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA1', 'Test List');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB1', 'PayPal Transaction ID');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC1', 'Sale price');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD1', 'Postage and Packaging');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AE1', 'Total price');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AF1', 'Selling360 Number');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AG1', 'Shipping');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AH1', 'Account');
	
	
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
		
$ebay_id		= $sql[$i]['ebay_id'];
		$ordersn		= $sql[$i]['ebay_ordersn'];
		$paidtime		= date('Y-m-d',strtotime($sql[$i]['ebay_paidtime']));
		$ebay_usermail	= $sql[$i]['ebay_usermail'];
		$ebay_userid	= $sql[$i]['ebay_userid'];	
		$name			= $sql[$i]['ebay_username'];
		$name	  	= str_replace("&acute;","'",$name);
		$name  		= str_replace("&quot;","\"",$name);
	    $street1		= @$sql[$i]['ebay_street'];
	    $street2 		= @$sql[$i]['ebay_street1'];

	    $city 				= $sql[$i]['ebay_city'];
		
	    $state				= $sql[$i]['ebay_state'];
		$PaymentMethodUsed 		= $sql[$i]['PaymentMethodUsed'];
	    $countryname 		= $sql[$i]['ebay_countryname'];

	    $zip				= $sql[$i]['ebay_postcode'];
 $ebay_account				= $sql[$i]['ebay_account'];
	    $tel				= $sql[$i]['ebay_phone'];

		$ebay_shipfee		= $sql[$i]['ebay_shipfee'];
		$ebay_id		= $sql[$i]['ebay_id'];

		$ebay_note			= $sql[$i]['ebay_note'];
		$ebay_noteb			= $sql[$i]['ebay_noteb'];
		$ebay_total	 		= @$sql[$i]['ebay_total'];
		$recordnumber		= $sql[$i]['recordnumber'];
		$ebay_account		= $sql[$i]['ebay_account'];
		$ebay_ptid			= $sql[$i]['ebay_ptid'];
		$ebay_tid			= $sql[$i]['ebay_tid'];
		if($ebay_account =='enjoyhobbies'){
			
				$ebayaccount			= "ej.";
				
		}else{
			
				$ebayaccount			= substr($ebay_account,0,5);
				
		}
		
		
		
		$ebay_phone					= $sql[$i]['ebay_phone'];
		$ebay_carrier					= $sql[$i]['ebay_carrier'];
		$ebay_createdtime				= @date('Y-m-d',$sql[$i]['ebay_createdtime']);
		$ebay_paidtime					= @date('Y-m-d',$sql[$i]['ebay_paidtime']);

		$addressline	= $street1." ".$street2;
		$addressline	  	= str_replace("&acute;","'",$addressline);
		$addressline  		= str_replace("&quot;","\"",$addressline);
		 $ebay_id 				= $sql[$i]['ebay_id'];

			$labelstr = '';


				$labelstr2 = '';

			$ebay_packingmaterialzh = '';
			
$totalweight = 0;

		$sl				= "select * from ebay_orderdetail where ebay_ordersn='$ordersn' ";

		$sl				= $dbcon->execute($sl);

		$sl				= $dbcon->getResultArray($sl);

		for($o=0;$o<count($sl);$o++){			
			$sku1	= $sl[$o]['sku'];	



			$labelstr2 .= $sku1.' ';

			$sku	= $sl[$o]['ebay_itemtitle'];
			$amount	= $sl[$o]['ebay_amount'];

			$pic					= $sl[$o]['ebay_itemurl'];			
			$ebay_itemid			= $sl[$o]['ebay_itemid'];	
			$ebay_itemprice			= $sl[$o]['ebay_itemprice'];	
			$ebay_shiptype			= $sl[$o]['ebay_shiptype'];
			$recordnumber			= $sl[$o]['recordnumber'];
			$InsuranceFee			= $sl[$o]['InsuranceFee'];
			if($InsuranceFee == '11') $InsuranceFee = '0.00';
			$sq3	= "select * from ebay_goods where goods_sn='$sku1' and ebay_user='$user'";
			$sq3	= $dbcon->execute($sq3);
			$sq3	= $dbcon->getResultArray($sq3);


			if(count($sq3) > 0 ){
				
				
				
					$labelstr .= $sku1.'('.$amount.')';
					$goods_name = $sq3[0]['goods_name'];
					$goods_weight = $sq3[0]['goods_weight'];





					$ebay_packingmaterial	= $sq3[0]['ebay_packingmaterial'];
					$kk			= " select * from ebay_packingmaterial where model ='$ebay_packingmaterial' and ebay_user='$user' ";
					$kk			= $dbcon->execute($kk);
					$kk 	 	= $dbcon->getResultArray($kk);
					$model		= $kk[0]['model'];		
					$weight		= $kk[0]['weight'];	
											$totalweight		+= ($goods_weight*$amount + $weight);



			}else{


				/* 是否是组合产品 */


				$rr			= "select * from ebay_productscombine where ebay_user='$user' and goods_sn='$sku1'";
				$rr			= $dbcon->execute($rr);
				$rr 	 	= $dbcon->getResultArray($rr);
				if(count($rr) > 0){



					
						

									$goods_sncombine		= $rr[0]['goods_sncombine'];
								
	$ebay_packingmaterialzh		= $rr[0]['ebay_packingmaterial'];
									

									$goods_sncombine    = explode(',',$goods_sncombine);
						
						$totalqty	 = 0;
		

									for($e=0;$e<count($goods_sncombine);$e++){

											$pline			= explode('*',$goods_sncombine[$e]);
											$goods_sn		= $pline[0];
											$goddscount     = $pline[1] * $amount;
											$totalqty		= $totalqty + $goddscount;
											$labelstr .= $goods_sn.'('.$goddscount.')';
											$ee					= "SELECT * FROM ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
											$ee					= $dbcon->execute($ee);
											$ee 	 			= $dbcon->getResultArray($ee);
											
										    $ebay_packingmaterial	= $ee[0]['ebay_packingmaterial'];
											
											$kk			= " select * from ebay_packingmaterial where model ='$ebay_packingmaterial' and ebay_user='$user' ";
											$kk			= $dbcon->execute($kk);
											$kk 	 	= $dbcon->getResultArray($kk);
											
											
			
											
											$weight		= $kk[0]['weight'];		




											$goods_weight		=  $ee[0]['goods_weight'];
											$totalweight		+= (($goods_weight*$goddscount)+$weight);
									}






			}


			}

		}


if($ebay_packingmaterialzh != '' ) $ebay_packingmaterial = $ebay_packingmaterialzh;



												$objPHPExcel->setActiveSheetIndex(0)->getCell('E'.$a)->setValueExplicit($labelstr2, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('F'.$a)->setValueExplicit($amount, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('G'.$a)->setValueExplicit($labelstr, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('H'.$a)->setValueExplicit($totalweight, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('I'.$a)->setValueExplicit($ebay_carrier, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('J'.$a)->setValueExplicit($ebay_packingmaterial, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('L'.$a)->setValueExplicit($recordnumber, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('M'.$a)->setValueExplicit($ebay_paidtime, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('N'.$a)->setValueExplicit($ebay_noteb, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('O'.$a)->setValueExplicit($ebay_userid, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('P'.$a)->setValueExplicit($name, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('Q'.$a)->setValueExplicit($ebay_phone, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('R'.$a)->setValueExplicit($ebay_usermail, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('S'.$a)->setValueExplicit($street1, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('T'.$a)->setValueExplicit($street2, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('U'.$a)->setValueExplicit($city, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('V'.$a)->setValueExplicit($state, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('W'.$a)->setValueExplicit($zip, PHPExcel_Cell_DataType::TYPE_STRING);

			$objPHPExcel->setActiveSheetIndex(0)->getCell('X'.$a)->setValueExplicit($countryname, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('Y'.$a)->setValueExplicit($ebay_itemid, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('Z'.$a)->setValueExplicit($sku, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('AB'.$a)->setValueExplicit($ebay_ptid, PHPExcel_Cell_DataType::TYPE_STRING);

			$objPHPExcel->setActiveSheetIndex(0)->getCell('AC'.$a)->setValueExplicit($ebay_itemprice, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('AD'.$a)->setValueExplicit($ebay_shipfee, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('AE'.$a)->setValueExplicit($ebay_total, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('AF'.$a)->setValueExplicit($ebay_id, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('AH'.$a)->setValueExplicit($ebay_account, PHPExcel_Cell_DataType::TYPE_STRING);

									$a++;






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







$title		= "Files_eBayCSV".date('Y-m-d');

$titlename		= "Files_eBayCSV".date('Y-m-d').".xls";



$objPHPExcel->getActiveSheet()->setTitle($title);



$objPHPExcel->setActiveSheetIndex(0);





// Redirect output to a client’s web browser (Excel5)

header('Content-Type: application/vnd.ms-excel');

header("Content-Disposition: attachment;filename={$titlename}");

header('Cache-Control: max-age=0');



$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

$objWriter->save('php://output');

exit;





