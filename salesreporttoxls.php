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
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'ebay账号');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '订单数量');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'item数量');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '销售额($)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'ebay费用($)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'paypal费用($)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', '总成本(￥)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', '总重量(kg)');
	
	if($_REQUEST['start'] && $_REQUEST['end']){
		$start	 = strtotime($_REQUEST['start']);
		$end 	 = strtotime($_REQUEST['end']);
	}else{
		$end	 = strtotime(date('Y-m-d').' 00:00:00');
		$start	 = $end-(3600*24);
	}
	$ebay_account 	 = $_REQUEST['acc'];
	
	$sql	=  "select ebay_account,sum(ebay_total) as total,count(ebay_id) as ordernum from ebay_order where  ebay_user='$user' and ebay_combine!='1' and (ebay_paidtime>='$start' and  ebay_paidtime<='$end')";
	
	if($ebay_account != '') $sql .= " and ebay_account ='$ebay_account' ";
	
	
	$sql	.= "  group by ebay_account ";
	

	
	
	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);
	
	

	
	$value = array();
	if($sql){
	foreach($sql as $key=>$val){
		
		$sq	= "select ebay_ordersn from ebay_order where ebay_user='$user' and ebay_combine!='1' and (ebay_paidtime>='$start' and  ebay_paidtime<='$end') and ebay_account='".$val['ebay_account']."' ";


		$sq	= $dbcon->execute($sq);
		$sq	= $dbcon->getResultArray($sq);

		
		
		
		$value[$key]['user'] = $val['ebay_account'];
		$value[$key]['ordernum'] = $val['ordernum'];
		$value[$key]['price'] = number_format($val['total'],2);
		$cost = 0;
		$num = 0;
		$ebayfee = 0;
		$paypalfee = 0;
		
		$totalweight = 0;
		
	
		foreach($sq as $k=>$v){
			$ss = "select ebay_amount,sku,FinalValueFee,FeeOrCreditAmount from ebay_orderdetail where ebay_ordersn='".$v['ebay_ordersn']."'";
			$ss	= $dbcon->execute($ss);
			$ss	= $dbcon->getResultArray($ss);
			foreach($ss as $kk=>$vv){
				$num += $vv['ebay_amount'];
				$sss = "select goods_sncombine from ebay_productscombine where goods_sn='".$vv['sku']."'";
				$sss	= $dbcon->execute($sss);
				$sss	= $dbcon->getResultArray($sss);
				if($sss){
					$t = explode(',',$sss[0]['goods_sncombine']);
					$costt = 0;
					foreach($t as $kkkk=>$vvvv){
						$tt = explode('*',$vvvv);
						$ttnum = $tt[1];
						$ttsku = $tt[0];
						$ssss = "select goods_cost,goods_weight from ebay_goods where goods_sn='".$ttsku."'";
						$ssss	= $dbcon->execute($ssss);
						$ssss	= $dbcon->getResultArray($ssss);
						$costt += $ttnum*$ssss[0]['goods_cost'];
						
						$totalweight += $ttnum*$sss[0]['goods_weight'];
					}
					$cost += $vv['ebay_amount']*$costt;
				}else{
					$sss = "select goods_cost,goods_weight from ebay_goods where goods_sn='".$vv['sku']."'";
					$sss	= $dbcon->execute($sss);
					$sss	= $dbcon->getResultArray($sss);
					if($sss){
						$cost += $vv['ebay_amount']*$sss[0]['goods_cost'];
						$totalweight += $vv['ebay_amount']*$sss[0]['goods_weight'];
						
					}
				}
				$ebayfee += $vv['FinalValueFee'];
				$paypalfee	 += $vv['FeeOrCreditAmount'];
			}
		}
		$value[$key]['ebay'] = number_format($ebayfee,2);
		$value[$key]['paypal'] = number_format($paypalfee,2);
		$value[$key]['cost'] = number_format($cost,2);
		$value[$key]['qty'] = $num;
		$value[$key]['weight'] = number_format($totalweight,2);
		}
		
		
	
		foreach($value as $kkk=>$vvv){					
			$a = $kkk+2;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$a, $vvv['user']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$a, $vvv['ordernum']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$a, $vvv['qty']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$a, $vvv['price']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$a, $vvv['ebay']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$a, $vvv['paypal']);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$a, $vvv['cost']);	
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$a, $vvv['weight']);	
		}
}
		
		
		




	
			
	

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(15);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(15);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(15);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(15);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(15);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(15);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(15);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth(15);

$objPHPExcel->getActiveSheet(0)->getStyle('A1:N500')->getFont()->setSize(8);

$objPHPExcel->getActiveSheet(0)->getStyle('A1:A500')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet(0)->getStyle('D1:D500')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet(0)->getStyle('B1:B500')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet(0)->getStyle('F1:G500')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet(0)->getStyle('E1:E500')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet(0)->getStyle('G1:G500')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet(0)->getStyle('H1:H500')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



$title		= "Files_FHQD".date('Y-m-d',$start);
$titlename		= "Sales_report".date('Y-m-d',$start).".xls";

$objPHPExcel->getActiveSheet()->setTitle($title);

$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename={$titlename}");
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;


