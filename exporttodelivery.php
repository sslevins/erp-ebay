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

	

	
	$ss			= "delete from ebay_go01";
	$dbcon->execute($ss);
	
	
	$ertj		= "";

	$orders		= explode(",",$_REQUEST['bill']);

	for($g=0;$g<count($orders);$g++){

		$sn 	=  $orders[$g];

		if($sn != ""){

				

					$ertj	.= " a.ebay_id='$sn' or";

		}

			

	}

	$ertj			 = substr($ertj,0,strlen($ertj)-3);
	$ebay_status		= $_REQUEST['ostatus'];
	
	if($_REQUEST['bill'] == '' ){
	
	$sql	= "select * from ebay_order as a where   ebay_user='$user' and a.ebay_combine!='1' ";	
	}else{
	$sql	= "select * from ebay_order as a where ($ertj) and ebay_user='$user' and a.ebay_combine!='1' ";	
	}
	
	
	if($ebay_status != '100'){
		$sql	.= " and ebay_status ='$ebay_status' ";
	}
	
	
				$start				= $_REQUEST['start'];
				$end				= $_REQUEST['end'];
				
				if($start !='' && $end != ''){
					
					$start				= strtotime($_REQUEST['start']);
					$end				= strtotime($_REQUEST['end']);
				
					$sql	.= " and (a.ebay_paidtime>=$start and a.ebay_paidtime	<=$end) ";
					
				}
				


	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);
	
	
	
	$a		= 2;	

	for($i=0;$i<count($sql);$i++){
		

		$ordersn		= $sql[$i]['ebay_ordersn'];
		$sl				= "select * from ebay_orderdetail where ebay_ordersn='$ordersn' ";
		$sl				= $dbcon->execute($sl);
		$sl				= $dbcon->getResultArray($sl);
		
		for($o=0;$o<count($sl);$o++){			

			$sku				= $sl[$o]['sku'];
			$ebay_amount		= $sl[$o]['ebay_amount'];
			
			$sqlsku		= "select * from ebay_productscombine where goods_sn='$sku' and ebay_user ='$user'";
			$sqlsku		= $dbcon->execute($sqlsku);
			$sqlsku		= $dbcon->getResultArray($sqlsku);
			
			
			if(count($sqlsku) == 0){
			
				
				
				$ss			= "select * from ebay_goods where goods_sn='$sku' and ebay_user ='$user'";
				$ss			= $dbcon->execute($ss);
				$ss			= $dbcon->getResultArray($ss);
				$category	= $ss[0]['goods_category'];
				
				
				$ss			= " select * from ebay_go01 where sku='$sku' ";
				$ss			= $dbcon->execute($ss);
				$ss			= $dbcon->getResultArray($ss);
				
				if(count($ss) == 0){
				
				$ss		= "insert into ebay_go01(sku,category,amount) values('$sku','$category','$ebay_amount')";
				
				}else{
				
				$ss		= "update ebay_go01 set category='$category',amount=amount+$ebay_amount where sku='$sku'";
				}
				
				$dbcon->execute($ss);
				
				
				
			
			
			}else{
			
			
			$skktotal		= explode('，',$sqlsku[0]['goods_sncombine']);
			for($h=0;$h<count($skktotal);$h++){
				
				$csku		= explode('*',$skktotal[$h]);
				$ssku			= $csku[0];
				$sskuamount		= $csku[1]*$ebay_amount;
				
				
				$ss			= "select * from ebay_goods where goods_sn='$ssku' and ebay_user ='$user'";
				$ss			= $dbcon->execute($ss);
				$ss			= $dbcon->getResultArray($ss);
				$category	= $ss[0]['goods_category'];
				
				
				$ss			= " select * from ebay_go01 where sku='$ssku' ";
				$ss			= $dbcon->execute($ss);
				$ss			= $dbcon->getResultArray($ss);
				
				if(count($ss) == 0){
				
				$ss		= "insert into ebay_go01(sku,category,amount) values('$ssku','$category','$sskuamount')";
				
				}else{
				
				$ss		= "update ebay_go01 set category='$category',amount=amount+$sskuamount where sku='$ssku'";
				}
				
				$dbcon->execute($ss);
				
				
				
			}
			
			
		}

	

	}



}

			


	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '物品大类');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '型号');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '图片');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '出库数量');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', '金额');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', '重量');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', '');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', '物品大类');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', '型号');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', '图片');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', '出库数量');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', '金额');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', '重量');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', '');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1', '物品大类');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1', '型号');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q1', '图片');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R1', '出库数量');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S1', '金额');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T1', '重量');
	
	$ss		= "select * from ebay_go01 order by category desc ,sku desc  ";
	$ss		= $dbcon->execute($ss);
	$ss		= $dbcon->getResultArray($ss);
	$currentlinecc	= 2;
	$currentlineaa	= 2;
	$currentlinebb	= 2;
	$xun			= 1;
	$js				= 1;
	for($i=0;$i<count($ss);$i++){
	
		
		$sku		= $ss[$i]['sku'];
		$amount		= $ss[$i]['amount'];
		$category		= $ss[$i]['category'];
		$vv = "select goods_cost,goods_weight from ebay_goods where goods_sn='$sku'";
		$vv			= $dbcon->execute($vv);
		$vv			= $dbcon->getResultArray($vv);
		$cost = number_format(($vv[0]['goods_cost']*$amount),2);
		$weight = number_format(($vv[0]['goods_weight']*$amount),3);
			$rr			= "select name,pid from ebay_goodscategory where id='$category'";		
			$rr			= $dbcon->execute($rr);
			$rr			= $dbcon->getResultArray($rr);
			$category0	= $rr[0]['name'];
			$pid		= $rr[0]['pid'];

			
			if($pid>0){
			$rr			= "select name from ebay_goodscategory where id='$pid'";		
			$rr			= $dbcon->execute($rr);
			$rr			= $dbcon->getResultArray($rr);
			$category0	= $rr[0]['name'];
			}
			
		
		if(($js%10) == 0){
		
		  $js = 1;
		  }
		 
		  
		  if($xun >=4) {$xun = 1;$currentlineaa	++;}
		  
		if($xun == 1){
		
			
			$objPHPExcel->setActiveSheetIndex(0)->getCell('A'.$currentlineaa)->setValueExplicit($category0, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('B'.$currentlineaa)->setValueExplicit($sku, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('D'.$currentlineaa)->setValueExplicit($amount, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('E'.$currentlineaa)->setValueExplicit($cost, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('F'.$currentlineaa)->setValueExplicit($weight, PHPExcel_Cell_DataType::TYPE_STRING);
			
			
		}
		
		if($xun == 2){
		
			
			$objPHPExcel->setActiveSheetIndex(0)->getCell('H'.$currentlineaa)->setValueExplicit($category0, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('I'.$currentlineaa)->setValueExplicit($sku, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('K'.$currentlineaa)->setValueExplicit($amount, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('L'.$currentlineaa)->setValueExplicit($cost, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('M'.$currentlineaa)->setValueExplicit($weight, PHPExcel_Cell_DataType::TYPE_STRING);
			
		}
		
		
		if($xun == 3){
			
			$objPHPExcel->setActiveSheetIndex(0)->getCell('O'.$currentlineaa)->setValueExplicit($category0, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('P'.$currentlineaa)->setValueExplicit($sku, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('R'.$currentlineaa)->setValueExplicit($amount, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('S'.$currentlineaa)->setValueExplicit($cost, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('T'.$currentlineaa)->setValueExplicit($weight, PHPExcel_Cell_DataType::TYPE_STRING);
			
		
			
		}
		$xun++;
		$js++;
		
	
	}
	





$objPHPExcel->getActiveSheet(0)->getStyle('A1:N500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(10);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(10);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(10);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(10);	




$title		= "Address".date('Y-m-d');

$titlename		= "Address".date('Y-m-d').".xls";



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