<?php
@session_start();
error_reporting(E_ALL);

$user	= $_SESSION['user'];
include "../include/dbconnect.php";	
date_default_timezone_set ("Asia/Chongqing");
$dbcon	= new DBClass();
require_once '../Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:F1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'PostNL Manifest');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'Shipper Name:');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', 'C02');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', 'DATE:');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', date('Y/m/d'));
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', 'Parcel Tracking#');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B4', 'Box number');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4', 'Cust.Ref.#');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D4', 'Consignee Name');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E4', 'Street/Apt.#');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F4', 'Postal Code');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G4', 'Country');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H4', 'Detailed Commodity Description');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I4', 'Declared Value in €');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J4', 'Commodity Code (if known)');
	$sss = "select rates from ebay_currency where currency='GBP' and ebay_user='$user'";
	$sss	= $dbcon->execute($sss);
	$sss	= $dbcon->getResultArray($sss);
	if(count($sss)>0){
		$rates	= $sss[0]['rates']?$sss[0]['rates']:1;
	}else{
		$rates = 1.5;
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
	
	
	
		$sql			= "select * from ebay_order as a  where a.ebay_userid !=''  and ebay_status='$ostatus' and ebay_combine!='1' group by a.ebay_id ";
			
			
			
			
	}else{	
	$sql	= "select * from ebay_order as a where ($ertj) and ebay_user='$user' and a.ebay_combine!='1' ";
	
			
	}	
	


		
	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);
	$a		= 5;
	
	for($i=0;$i<count($sql);$i++){
		
		$ebay_id				= $sql[$i]['ebay_id'];	
		$ebay_ordersn			= $sql[$i]['ebay_ordersn'];	
		$ebay_usermail			= $sql[$i]['ebay_usermail'];
		$ebay_userid			= $sql[$i]['ebay_userid'];	
		$names					= $sql[$i]['ebay_username'];
	    $street1				= @$sql[$i]['ebay_street'];
	    $street2 				= @$sql[$i]['ebay_street1'];
	    $city 					= $sql[$i]['ebay_city'];
	    $state					= $sql[$i]['ebay_state'];
	    $countryname 			= $sql[$i]['ebay_countryname'];
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
		$addressline	= $street1;
		if($street2 != ''){
			
				$addressline .= " , ".$street2;
		}

		
		
		

			$ss = "select sku,ebay_amount from ebay_orderdetail where ebay_ordersn='$ebay_ordersn'";
			$ss	= $dbcon->execute($ss);
			$ss	= $dbcon->getResultArray($ss);
			foreach($ss as $k=>$v){	
				$sku = $v['sku'];
				$amount = $v['ebay_amount'];
				$sq3	= "select * from ebay_goods where goods_sn='$sku' and ebay_user='$user'";
				$sq3	= $dbcon->execute($sq3);
				$sq3	= $dbcon->getResultArray($sq3);
				if(count($sq3)>0){
					$ywsbmc = $sq3[0]['goods_ywsbmc'];
					$sbjz	= $sq3[0]['goods_sbjz'] * $amount * $rates;
					if($sbjz>=15){
						$sbjz = rand(130,145);
						$sbjz = $sbjz/10;
					}

					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$a, $ebay_carrier);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$a, $names);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$a, $addressline.chr(13).$city);
					$objPHPExcel->setActiveSheetIndex(0)->getCell('F'.$a)->setValueExplicit($zip, PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->setActiveSheetIndex(0)->getCell('G'.$a)->setValueExplicit($countryname, PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$a, $ywsbmc);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$a, $sbjz);
					
					$a++;
				}else{
					$rr			= "select * from ebay_productscombine where ebay_user='$user' and goods_sn='$sku'";
					$rr			= $dbcon->execute($rr);
					$rr 	 	= $dbcon->getResultArray($rr);

					if(count($rr) > 0){
						$goods_sncombine	= $rr[0]['goods_sncombine'];
						$goods_sncombine    = explode(',',$goods_sncombine);	
						for($e=0;$e<count($goods_sncombine);$e++){
							$pline			= explode('*',$goods_sncombine[$e]);
							$goods_sn		= $pline[0];
							$goddscount     = $pline[1] * $amount;
							$sq3	= "select * from ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
							$sq3	= $dbcon->execute($sq3);
							$sq3	= $dbcon->getResultArray($sq3);
							$ywsbmc = $sq3[0]['goods_ywsbmc'];
							$sbjz	= $sq3[0]['goods_sbjz'] * $goddscount * $rates;
							if($sbjz>=15){
								$sbjz = rand(130,145);
								$sbjz = $sbjz/10;
							}	
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$a, $ebay_carrier);
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$a, $names);
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$a, $addressline.chr(13).$city);
							$objPHPExcel->setActiveSheetIndex(0)->getCell('F'.$a)->setValueExplicit($zip, PHPExcel_Cell_DataType::TYPE_STRING);
							$objPHPExcel->setActiveSheetIndex(0)->getCell('G'.$a)->setValueExplicit($countryname, PHPExcel_Cell_DataType::TYPE_STRING);
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$a, $ywsbmc);
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$a, $sbjz);		
							$a++;								
						}
					}else{
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$a, $ebay_carrier);
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$a, $names);
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$a, $addressline.chr(13).$city);
							$objPHPExcel->setActiveSheetIndex(0)->getCell('F'.$a)->setValueExplicit($zip, PHPExcel_Cell_DataType::TYPE_STRING);
							$objPHPExcel->setActiveSheetIndex(0)->getCell('G'.$a)->setValueExplicit($countryname, PHPExcel_Cell_DataType::TYPE_STRING);
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$a, '未设置资料');
							$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$a, '未设置资料');		
							$a++;
					}
				}
			}

		
		}

	
		
		
		
		
	
		
		
		
		

	
	


$objPHPExcel->getActiveSheet(0)->getStyle('A1:N500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(15);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(15);		
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(20);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(15);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(35);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(15);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(15);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth(15);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setWidth(15);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setWidth(15);
$objPHPExcel->getActiveSheet(0)->getStyle('A1:M500')->getAlignment()->setWrapText(true);




$title		= "C02 Manifest".date('m-d');
$titlename		= "C02 Manifest".date('m-d').".xls";

$objPHPExcel->getActiveSheet()->setTitle($title);

$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename={$titlename}");
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;


