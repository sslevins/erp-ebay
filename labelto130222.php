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
							 
							 
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Chinese content description');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'Order Number');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Product barcode');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'Recipient name');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'Recipient street');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'Recipient housenumber');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', 'Recipient busnumber');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', 'Recipient zipcode');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', 'Recipient city');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', 'Recipient state');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', 'Recipient country');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', 'Item content');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', 'Item count');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', 'Value');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1', 'Currency');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1', 'Weight');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q1', 'SKU Required');
	
	
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
	$sql	= "select * from ebay_order as a where ebay_user='$user' and a.ebay_status='1' and a.ebay_combine!='1' ";	
	}else{	
	$sql	= "select a.*,b.ebay_itemid,b.ebay_itemtitle,b.recordnumber as brecordnumberb,b.sku,b.ebay_amount from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn = b.ebay_ordersn where ($ertj) and a.ebay_user='$user' and a.ebay_combine!='1'  order by  b.sku desc,b.ebay_amount desc ";	
	
	
	$sql	= "select * from ebay_order as a where ebay_user='$user'   and a.ebay_combine!='1' and ($ertj) ";	
	
	
	
	}


	

	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);
	$a		= 2;
	
	for($i=0;$i<count($sql);$i++){
		
		$ordersn				= $sql[$i]['ebay_ordersn'];	
		$paidtime				= date('Y-m-d',$sql[$i]['ebay_paidtime']);
		
		$ebay_id				= $sql[$i]['ebay_id'];	

		
		$recordnumber			= $sql[$i]['recordnumber'];
		
		$ebay_usermail			= $sql[$i]['ebay_usermail'];
		$ebay_userid			= $sql[$i]['ebay_userid'];	
		$name					= $sql[$i]['ebay_username'];
	    $street1				= @$sql[$i]['ebay_street'];
		$mm						= explode(' ',$street1);
		$mmr					= count($mm);
		$doornumber				= $mm[$mmr-1];
		$m = substr($doornumber,0,1);
		if(!intval($m)){
			$doornumber = explode('.',$doornumber);
			$doornumber	= $doornumber[1];
		}
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
		$ebay_couny				= @$sql[$i]['ebay_couny'];
		$ebay_currency				= @$sql[$i]['ebay_currency'];

		



		
					$st = "select * from ebay_orderdetail where ebay_ordersn='$ordersn'";
					$st			= $dbcon->execute($st);
					$st			= $dbcon->getResultArray($st);
					
					

					$goods_weight = 0;
					
					
					$totalgoodscount = 0;
					$lindstr		 = '';
					
					
					for($t=0;$t<count($st);$t++){
					
					
								$sku					= $st[$t]['ebay_itemtitle'];
								
								
								
								$amount					= $st[$t]['ebay_amount'];
								
								$ebay_itemid			= $st[$t]['ebay_itemid'];
								$sku1			= $st[$t]['sku'];
								$lindstr			.= $sku1;
									$sq3	= "select * from ebay_goods where goods_sn='$sku1' and ebay_user='$user'";
									
									
									
		$sq3			= $dbcon->execute($sq3);
		$sq3			= $dbcon->getResultArray($sq3);

		
		
		
		
		if(count($sq3) >0 ){
		
		$goods_ywsbmc		= $sq3[0]['goods_ywsbmc'];
		$goods_weight		+= $sq3[0]['goods_weight']*1000;
		$goods_sbjz			= $sq3[0]['goods_sbjz'];
		$goods_name			= $sq3[0]['goods_name'];
		$goods_location		= $sq3[0]['goods_location'];
		$goods_zysbmc		= $sq3[0]['goods_zysbmc'];
		$goddscount			= $amount;
		
		
		
		
		
		$totalgoodscount	= $totalgoodscount + $amount;
		
		}else{
		
			
			$rr			= "select * from ebay_productscombine where ebay_user='$user' and goods_sn='$sku1'";
			$rr			= $dbcon->execute($rr);
			$rr 	 	= $dbcon->getResultArray($rr);
			
			$goods_sncombine	= $rr[0]['goods_sncombine'];
			$goods_sncombine    = explode(',',$goods_sncombine);	
			
			$pline				= explode('*',$goods_sncombine[0]);
			
			$goods_sn			= $pline[0];
			$goddscount     	= $pline[1] * $amount;
			
			
			$totalgoodscount	= $totalgoodscount + $goddscount;
			
			
			$sq3				= "select * from ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
			$sq3				= $dbcon->execute($sq3);
			$sq3				= $dbcon->getResultArray($sq3);
			
			
			$goods_ywsbmc		= $sq3[0]['goods_ywsbmc'];
			$goods_zysbmc		= $sq3[0]['goods_zysbmc'];
			$goods_weight		+= $sq3[0]['goods_weight']*1000;
			$goods_sbjz			= $sq3[0]['goods_sbjz'];
			$goods_name			= $sq3[0]['goods_name'];

		
		}
					
					
					
					
					}
					
					
					
		
	
	

		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('A'.$a, $goods_zysbmc, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('B'.$a, $ebay_id, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('C'.$a, $ebay_tracknumber, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('D'.$a, $name, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$a, $street1.' '.$street2, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('F'.$a, $doornumber, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('G'.$a, '', PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('H'.$a, $zip, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('I'.$a, $city, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('J'.$a, $state, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('K'.$a, $ebay_couny, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('L'.$a, substr($sku,0,50), PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('M'.$a, $totalgoodscount, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('N'.$a, $ebay_total, PHPExcel_Cell_DataType::TYPE_STRING);
				
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('O'.$a, $ebay_currency, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('P'.$a, $goods_weight, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('Q'.$a, $lindstr, PHPExcel_Cell_DataType::TYPE_STRING);
		
		$a++;
		
}
$objPHPExcel->getActiveSheet(0)->getStyle('A1:Q500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(10);	

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(10);	

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(10);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(10);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(25);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(10);

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(10);

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth(10);

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setWidth(10);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setWidth(10);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('K')->setWidth(10);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('L')->setWidth(10);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('M')->setWidth(10);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('N')->setWidth(10);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('O')->setWidth(10);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('P')->setWidth(10);
$objPHPExcel->getActiveSheet(0)->getStyle('A1:M1000')->getAlignment()->setWrapText(true);




$title		= "bilishi".date('Y-m-d');
$titlename		= "bilishi".date('Y-m-d').".xls";

$objPHPExcel->getActiveSheet()->setTitle($title);

$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename={$titlename}");
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;


