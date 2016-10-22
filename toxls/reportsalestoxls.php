<?php
@session_start();
error_reporting(0);
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

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '付款时间');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '收入');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', '支出');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', '商品销量');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B1:D1');  

	
	@$account	= $_REQUEST['account'];
	@$startdate	= $_REQUEST['startdate'];
	@$enddate	= $_REQUEST['enddate'];
	@$ebay_site	= $_REQUEST['ebay_site'];
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', '订单总金额');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', '实收运费');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D2', '小计');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E2', '商品成本');
	
	
	

			
			
			
			
			if($startdate != '' && $enddate != '' ){
		
				$sdate		= strtotime($startdate.' 00:00:00');
				$edate		= strtotime($enddate.' 23:59:59');
			
		
				
				
				
				$countjs	= 1;
				
				$totalsales		= 0;
				$totalshipfee   = 0;
				$totalqty		= 0;
				
				$allproductcost = 0;
				
				$countryjs		= 3;
				
				for($i=1;$i<= 10000000; $i++){
				
				
				
				$searchstartdate		= strtotime(date('Y-m-d',$sdate).' 00:00:00');
				$searchenddate		= strtotime(date('Y-m-d',$sdate).' 23:59:59');
				
	
				
				
				
				$ss		= "SELECT  sum(a.ebay_total) as total,sum(ebay_shipfee) as ebay_shipfee, ebay_currency FROM ebay_order  as a where a.ebay_combine!='1' and ebay_paidtime>=$searchstartdate and ebay_paidtime<=$searchenddate and ebay_user ='$user'  ";
				
				
				
				
				
				if($account != '' ) $ss .= " and a.ebay_account ='$account' ";
				$ss		.= " group by a.ebay_currency";

				$ss		= $dbcon->execute($ss);
				$ss		= $dbcon->getResultArray($ss);
	
				
				$total 	= 0;
				$ordershipfee	= 0;
				
				for($h=0;$h<count($ss);$h++){
				
								$ebay_currency	= $ss[$h]['ebay_currency'];
								$vv			= "select rates from ebay_currency where currency='$ebay_currency' and user='$user'";
								$vv			=  $dbcon->execute($vv);
								$vv			=  $dbcon->getResultArray($vv);
								$ssrates	=  $vv[0]['rates']?$vv[0]['rates']:1;
								$ordershipfee		+= ($ss[$h]['ebay_shipfee'] * $ssrates);
								
					$total		+= ($ss[$h]['total'] * $ssrates);
				}
				
				
				
				
				
				/* 计算实际产品销量 */
				
				$dsql			= "SELECT sum(b.ebay_amount) as qty FROM ebay_order AS a JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn WHERE ";
				$dsql			.=    " a.ebay_combine!='1' and ebay_paidtime>=$searchstartdate and ebay_paidtime<=$searchenddate and a.ebay_user ='$user' ";
				if($account != '' ) $dsql .= " and a.ebay_account ='$account' ";
				
				$dsql			= $dbcon->execute($dsql);
				$dsql			= $dbcon->getResultArray($dsql);
				$qty			= $dsql[0]['qty'];
				
				/* 计算产品总成本 */
				
				$dsql			= "SELECT sum(b.ebay_amount) as qty,sku FROM ebay_order AS a JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn WHERE ";
				$dsql			.=    " a.ebay_combine!='1' and ebay_paidtime>=$searchstartdate and ebay_paidtime<=$searchenddate and a.ebay_user ='$user' ";
				
				if($account != '' ) $dsql .= " and a.ebay_account ='$account' ";
				$dsql			.= " group by b.sku ";
				
				
				$dsql			= $dbcon->execute($dsql);
				$dsql			= $dbcon->getResultArray($dsql);
				
				$totalgoods_cost = 0;
				
				for($h=0;$h<count($dsql);$h++){
								$pqty	= $dsql[$h]['qty'];
								$sku	= $dsql[$h]['sku'];
								$rr			= "select * from ebay_productscombine where ebay_user='$user' and goods_sn='$sku'";
								$rr			= $dbcon->execute($rr);
								$rr 	 	= $dbcon->getResultArray($rr);
								if(count($rr) > 0){
									$goods_sncombine	= $rr[0]['goods_sncombine'];
									$goods_sncombine    = explode(',',$goods_sncombine);	
									for($e=0;$e<count($goods_sncombine);$e++){
											$pline			= explode('*',$goods_sncombine[$e]);
											$goods_sn		= $pline[0];
											$goddscount     = $pline[1] * $pqty;
											$vv			= "select goods_cost from ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
											$vv			=  $dbcon->execute($vv);
											$vv			=  $dbcon->getResultArray($vv);
											$totalgoods_cost += $vv[0]['goods_cost']*$goddscount;
									}
								}else{
									$vv			= "select goods_cost from ebay_goods where goods_sn='$sku' and ebay_user='$user'";
									$vv			=  $dbcon->execute($vv);
									$vv			=  $dbcon->getResultArray($vv);
									$totalgoods_cost += $vv[0]['goods_cost']*$pqty;
								}
				}
				
		
				
				$vv			= "select rates from ebay_currency where currency='RMB' and user='$user'";
				$vv			=  $dbcon->execute($vv);
				$vv			=  $dbcon->getResultArray($vv);
				$ssrates	=  $vv[0]['rates']?$vv[0]['rates']:1;
				$totalgoods_cost	= $totalgoods_cost * $ssrates;
				
			
				
				
				
								
				$totalsales		+= $total;
				$totalshipfee	+= $ordershipfee;
				$totalqty		+= $qty;
				$allproductcost	+= $totalgoods_cost;
				
				
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$countryjs, date('Y-m-d',$sdate));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$countryjs, $total);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$countryjs, $ordershipfee);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$countryjs, $total - $ordershipfee,2);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$countryjs, $totalgoods_cost);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$countryjs, $qty);

				$countryjs ++ ;
				
		
					$sdate		= strtotime(date('Y-m-d H:i:s',strtotime("$startdate +".$countjs." days")));
					if($sdate >= $edate ) break;
					$countjs ++ ;
				
		
		}
		
		
		}
		





	




$objPHPExcel->getActiveSheet(0)->getStyle('A1:N500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(10);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(10);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(10);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(10);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(10);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(10);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(10);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth(10);


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







$title		= "ISFES_REPROTSALES".date('Y-m-d');

$titlename		= "ISFES_REPROTSALES".date('Y-m-d').".xls";



$objPHPExcel->getActiveSheet()->setTitle($title);



$objPHPExcel->setActiveSheetIndex(0);





// Redirect output to a client’s web browser (Excel5)

header('Content-Type: application/vnd.ms-excel');

header("Content-Disposition: attachment;filename={$titlename}");

header('Cache-Control: max-age=0');



$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

$objWriter->save('php://output');

exit;





