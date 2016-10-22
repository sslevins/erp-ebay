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
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', '商品销量');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B1:D1');  

	
	@$account	= $_REQUEST['account'];
	@$startdate	= $_REQUEST['startdate'];
	@$enddate	= $_REQUEST['enddate'];
	@$ebay_site	= $_REQUEST['ebay_site'];
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', '订单总额');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', '实收运费');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D2', '小计');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E2', '商品成本');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F2', '实付运费');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G2', 'ebay费');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H2', 'paypal费');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I2', '包材费');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J2', '小计');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K2', '利润');
	
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L2', '毛利率');
	

			
			

		
		if($startdate != '' && $enddate != '' ){
		
				$sdate		= strtotime($startdate.' 00:00:00');
				$edate		= strtotime($enddate.' 23:59:59');
			
		
				
				
				
				$countjs	= 1;
				
				$totalsales		= 0;
				$totalshipfee   = 0;
				$totalqty		= 0;
				
				$allproductcost = 0;
				
				$totalordershipfee = 0; // 实付运费
				$alltotalebayfee   = 0 ; // 一共有ebayfees
				
				$alltotalpaypalfees	= 0; // 一共有多少pp成功费
				$alltotalpackingcost	= 0;// 一巫有多少个包材费用
				
				
				$alltotalxiji			= 0;
				$allprofit				= 0;
				
				$countryjs = 3;
				
				
				for($i=1;$i<= 10000000; $i++){
				
				
				
				$searchstartdate		= strtotime(date('Y-m-d',$sdate).' 00:00:00');
				$searchenddate		= strtotime(date('Y-m-d',$sdate).' 23:59:59');
				
	
				
				
				$ss		= "SELECT  sum(a.ebay_total) as total,sum(a.ebay_shipfee) as ebay_shipfee, ebay_currency FROM ebay_order  as a where a.ebay_combine!='1' and ebay_paidtime>=$searchstartdate and ebay_paidtime<=$searchenddate and ebay_user ='$user'  ";
				
				if($account != '' ) $ss .= " and a.ebay_account ='$account' ";
				
				$ss		.= " group by a.ebay_currency";
				
				$ss		= $dbcon->execute($ss);
				$ss		= $dbcon->getResultArray($ss);
				
				$total 	= 0;
				
				for($h=0;$h<count($ss);$h++){
				
					$ebay_currency	= $ss[$h]['ebay_currency'];
								$vv					= "select rates from ebay_currency where currency='$ebay_currency' and user='$user'";
								$vv					=  $dbcon->execute($vv);
								$vv					=  $dbcon->getResultArray($vv);
								$ssrates			=  $vv[0]['rates']?$vv[0]['rates']:1;
								$total				+= ($ss[$h]['total'] * $ssrates);
								$ebay_shipfee		+= ($ss[$h]['ebay_shipfee'] * $ssrates);
								
								
				}
				
				$totalsales	+= $total;
				
				
				
				/* 计算实收运费 vs 实付运费 */
				
				$ss		= "SELECT  sum(ebay_shipfee) as ebay_shipfee,sum(ordershipfee) as ordershipfee FROM ebay_order  as a where a.ebay_combine!='1' and ebay_paidtime>=$searchstartdate and ebay_paidtime<=$searchenddate and ebay_user ='$user' ";
				if($account != '' ) $ss .= " and a.ebay_account ='$account' ";
				
				$ss		= $dbcon->execute($ss);
				$ss		= $dbcon->getResultArray($ss);
				
				$ordershipfee	= $ss[0]['ordershipfee'];
				$totalshipfee += $ebay_shipfee;
				$totalordershipfee += $ordershipfee;

				
				/* 计算实际产品销量 */
				
				$dsql			= "SELECT sum(b.ebay_amount) as qty FROM ebay_order AS a JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn WHERE ";
				$dsql			.=    " a.ebay_combine!='1' and ebay_paidtime>=$searchstartdate and ebay_paidtime<=$searchenddate and a.ebay_user ='$user' ";
				if($account != '' ) $dsql .= " and a.ebay_account ='$account' ";
				
				$dsql			= $dbcon->execute($dsql);
				$dsql			= $dbcon->getResultArray($dsql);
				$qty			= $dsql[0]['qty'];
				
				$totalqty		+= $qty;
				
				/* 计算产品总成本 */
				
				$dsql			= "SELECT sum(b.ebay_amount) as qty,sku FROM ebay_order AS a JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn WHERE ";
				$dsql			.=    " a.ebay_combine!='1' and ebay_paidtime>=$searchstartdate and ebay_paidtime<=$searchenddate and a.ebay_user ='$user' ";
				
				if($account != '' ) $dsql .= " and a.ebay_account ='$account' ";
				$dsql			.= " group by b.sku ";
				
				

				
				$dsql			= $dbcon->execute($dsql);
				$dsql			= $dbcon->getResultArray($dsql);
				
				$totalgoods_cost = 0;
				$totalpackingcost = 0;
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
											$vv			= "select goods_cost,ebay_packingmaterial from ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";											
											$vv			=  $dbcon->execute($vv);										
											$vv			=  $dbcon->getResultArray($vv);
																						
											$totalgoods_cost += $vv[0]['goods_cost']*$goddscount;
											
											

											
											
											$ebay_packingmaterial	= $vv[0]['ebay_packingmaterial'];
											$vv			= "select price from ebay_packingmaterial where model='$ebay_packingmaterial' and ebay_user='$user'";
											$vv			=  $dbcon->execute($vv);
											$vv			=  $dbcon->getResultArray($vv);
											$price		= $vv[0]['price'];
											$totalpackingcost		+= $price * $goddscount;
									
									
									}
								}else{
									$vv			= "select goods_cost,ebay_packingmaterial from ebay_goods where goods_sn='$sku' and ebay_user='$user'";
									$vv			=  $dbcon->execute($vv);
									$vv			=  $dbcon->getResultArray($vv);
									$totalgoods_cost += $vv[0]['goods_cost']*$pqty;
									
									

									
									$ebay_packingmaterial	= $vv[0]['ebay_packingmaterial'];
									$vv			= "select price from ebay_packingmaterial where model='$ebay_packingmaterial' and ebay_user='$user'";
									$vv			=  $dbcon->execute($vv);
									$vv			=  $dbcon->getResultArray($vv);
									$price		= $vv[0]['price'];
									$totalpackingcost		+= $price * $pqty;
								
									
									
								}
				}
				
	
	
				
				
				$vv			= "select rates from ebay_currency where currency='RMB' and user='$user'";
				$vv			=  $dbcon->execute($vv);
				$vv			=  $dbcon->getResultArray($vv);
				$ssrates	=  $vv[0]['rates']?$vv[0]['rates']:1;
				$totalgoods_cost	= $totalgoods_cost * $ssrates;
				$totalpackingcost	= $totalpackingcost * $ssrates;
				
				
				
				$alltotalpackingcost	+= $totalpackingcost;
				$allproductcost			+= $totalgoods_cost;
				
			
					/* 计算 ebay fees */
					$ss			 = "SELECT  sum(b.FinalValueFee) as ebayfee,a.ebay_account  FROM ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn = b.ebay_ordersn where a.ebay_combine!='1'  ";
					$ss			.=    "   and ebay_paidtime>=$searchstartdate and ebay_paidtime<=$searchenddate and a.ebay_user ='$user' ";
					if($account != '' ) $ss .= " and a.ebay_account ='$account' ";
					$ss			.= " group by a.ebay_account ";
					$ss		= $dbcon->execute($ss);
					$ss		= $dbcon->getResultArray($ss);
					$totalebayfee		= 0;
					for($t=0;$t<count($ss);$t++){
								$ebayfee				= $ss[$t]['ebayfee'];
								$ebay_account			= $ss[$t]['ebay_account'];
								$vv						= "select ebay_currency from ebay_account where ebay_account='$ebay_account' and user='$user'";
								$vv						=  $dbcon->execute($vv);
								$vv						=  $dbcon->getResultArray($vv);
								$ebay_currency			=  $vv[0]['ebay_currency']?$vv[0]['ebay_currency']:'USD';
								$vv			= "select rates from ebay_currency where currency='$ebay_currency' and user='$user'";
								$vv			=  $dbcon->execute($vv);
								$vv			=  $dbcon->getResultArray($vv);
								$ssrates	=  $vv[0]['rates']?$vv[0]['rates']:1;
								$totalebayfee				+= $ebayfee * $ssrates;
					}
					
					$alltotalebayfee			+= $totalebayfee;
					
					
					/* 计算pp成功费 */
					
					$ss		= "SELECT a.ebay_id, a.ebay_currency, b.FeeOrCreditAmount FROM ebay_order AS a JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn WHERE  FeeOrCreditAmount >0
";
					$ss			.=    "   and ebay_paidtime>=$searchstartdate and ebay_paidtime<=$searchenddate and a.ebay_user ='$user' ";
					if($account != '' ) $ss .= " and a.ebay_account ='$account' ";
					$ss		.= " GROUP BY a.ebay_id ";
					$ss		= $dbcon->execute($ss);
					$ss		= $dbcon->getResultArray($ss);
					$totalpaypalfees	= 0;
					
					for($h=0;$h<count($ss);$h++){
								$ebay_currency	= $ss[$h]['ebay_currency'];
								$vv			= "select rates from ebay_currency where currency='$ebay_currency' and user='$user'";
								$vv			=  $dbcon->execute($vv);
								$vv			=  $dbcon->getResultArray($vv);
								$ssrates	=  $vv[0]['rates']?$vv[0]['rates']:1;
								$totalpaypalfees		+= ($ss[$h]['FeeOrCreditAmount'] * $ssrates);
					}
					
					$alltotalpaypalfees	+= $totalpaypalfees;
					
					
					$totalxiji		= $totalgoods_cost+$ordershipfee+$totalebayfee+$totalpaypalfees+$totalpackingcost;
					$alltotalxiji += $totalxiji;
					
					
					$profit			= $total - $totalebayfee - $totalpaypalfees - $totalgoods_cost - $ordershipfee;
					$allprofit		+= $profit;
					
					
					
					$mll		= number_format($profit/$total,2);
					
					
					$mll		= ($mll*100).'%';
					
					
					
					
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$countryjs, date('Y-m-d',$sdate));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$countryjs, $total);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$countryjs, $ebay_shipfee);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$countryjs, $total);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$countryjs, $totalgoods_cost);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$countryjs, $ordershipfee);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$countryjs, $totalebayfee);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$countryjs, $totalpaypalfees);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$countryjs, $alltotalpackingcost);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$countryjs, $totalxiji);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$countryjs, $profit);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$countryjs, $mll);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$countryjs, $qty);
					
					$sdate		= strtotime(date('Y-m-d H:i:s',strtotime("$startdate +".$countjs." days")));
					
					if($sdate >= $edate ) break;
					
					$countjs ++ ;
					$countryjs++;
					
				
		
		}
		
		
		}
		




$countryjs++;

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$countryjs, $totalsales);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$countryjs, $totalshipfee);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$countryjs, $totalsales-$totalshipfee);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$countryjs, $allproductcost);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$countryjs, $totalordershipfee);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$countryjs, $alltotalebayfee);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$countryjs, $alltotalpaypalfees);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$countryjs, $alltotalpackingcost);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$countryjs, $alltotalxiji);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$countryjs, $allprofit);


$objPHPExcel->getActiveSheet(0)->getStyle('A1:N500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(10);	

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(10);	

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(10);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(8);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(10);

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(10);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(8);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth(8);







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





