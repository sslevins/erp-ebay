<?php
@session_start();
error_reporting(0);


function shipfeecalc($shippingid,$kg,$ebay_countryname){
			global $dbcon;
			
			$vvsql			= "select name from ebay_carrier where id='$shippingid' ";
			$vvsql			= $dbcon->execute($vvsql);
			$vvsql			= $dbcon->getResultArray($vvsql);
			$name			= $vvsql[0]['name'];
		
			
			
			$ss				= " select * from ebay_systemshipfee where shippingid ='$shippingid'";
			$ss				= $dbcon->execute($ss);
			$ss				= $dbcon->getResultArray($ss);
			
		
			
			$kg				= $kg * 1000;
			$type			= $ss[0]['type'];
			$shipfee		= 0;
			if($type 		== 0  ){
			$vv				= "select * from ebay_systemshipfee where $kg between aweightstart and aweightend and (acountrys like '%$ebay_countryname%' or acountrys like '%,any,%') and shippingid ='$shippingid'";
			$vv				= $dbcon->execute($vv);
			$vv				= $dbcon->getResultArray($vv);
			$bnextweightamount	= $vv[0]['bnextweightamount'];
			if($bnextweightamount > 0){
			$shipfee		= $bnextweightamount * $kg;
			}else{
			$shipfee		= $vv[0]['ashipfee'] + $vv[0]['ahandlefee'] + $vv[0]['ahandlefee2'];
			
			}
	
			
			
			$adiscount		= $ss[0]['adiscount'];
			if($adiscount<=0) $adiscount = 1;
			$shipfee		= $shipfee * $adiscount;	
			
			
			}else{
			$vv				= "select * from ebay_systemshipfee where  (bcountrys like '%$ebay_countryname%' or bcountrys like '%,any,%') and shippingid ='$shippingid'";
			
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
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '基础信息');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', '收入');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', '支出');
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B1:G1');  

	
	@$account	= $_REQUEST['account'];
	@$startdate	= $_REQUEST['startdate'];
	@$enddate	= $_REQUEST['enddate'];
	@$ebay_site	= $_REQUEST['ebay_site'];
	
	
	
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', '订单号');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', '派送方式');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D2', '客户ID');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E2', '收件人国家');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F2', 'SKU');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G2', '数量');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H2', '订单总金额');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I2', '实收运费');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J2', '商品成本');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K2', '实付运费');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L2', 'ebay交易费');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M2', 'paypal交易费');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N2', '包材费');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O2', '毛利');
			
			


		
		if($startdate != '' && $enddate != '' ){
		
				$sdate		= strtotime($startdate.' 00:00:00');
				$edate		= strtotime($enddate.' 23:59:59');
			
		
				
				
				
				$countjs	= 1;
					$countryjs = 3;
				
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
				
				
				for($i=1;$i<= 10000000; $i++){
				
				
				
				$searchstartdate		= strtotime(date('Y-m-d',$sdate).' 00:00:00');
				$searchenddate		= strtotime(date('Y-m-d',$sdate).' 23:59:59');
				
	
				
				
				$ss		= "SELECT  count(a.ebay_id) as totalqty,a.ebay_carrier,a.ordershipfee,a.ebay_id,a.ebay_currency,a.ebay_total,a.ebay_userid,a.ebay_countryname,b.sku,b.ebay_amount,b.ebay_itemprice,b.shipingfee,b.FinalValueFee,b.FeeOrCreditAmount,a.ebay_ordersn FROM ebay_order  as a  join ebay_orderdetail as b on a. ebay_ordersn = b.ebay_ordersn where a.ebay_combine!='1' and ebay_paidtime>=$searchstartdate and ebay_paidtime<=$searchenddate and a.ebay_user ='$user'  ";
				
				if($account != '' ) $ss .= " and a.ebay_account ='$account' ";
				$ss		.= " group by a.ebay_id";
				
				
				$ss		= $dbcon->execute($ss);
				$ss		= $dbcon->getResultArray($ss);
				$total 	= 0;
				for($h=0;$h<count($ss);$h++){
				
								
								$ebay_ordersn		= $ss[$h]['ebay_ordersn'];
								$ebay_carrier		= $ss[$h]['ebay_carrier'];
								$ebay_countryname		= $ss[$h]['ebay_countryname'];
								$ebay_userid			= $ss[$h]['ebay_userid'];
								$ebay_id				= $ss[$h]['ebay_id'];
								$ebay_currency			= $ss[$h]['ebay_currency'];
								$sku					= $ss[$h]['sku'];
								$ebay_amount			= $ss[$h]['ebay_amount'];
								$shipingfee				= $ss[$h]['shipingfee'];
								$ebay_itemprice			= $ss[$h]['ebay_itemprice'];
								$FinalValueFee			= $ss[$h]['FinalValueFee'];
								$FeeOrCreditAmount		= $ss[$h]['FeeOrCreditAmount'];
								$ordershipfee			= $ss[$h]['ordershipfee'];
								$vv						= "select rates from ebay_currency where currency='$ebay_currency' and user='$user'";
								$vv						=  $dbcon->execute($vv);
								$vv						=  $dbcon->getResultArray($vv);
								$ssrates				=  $vv[0]['rates']?$vv[0]['rates']:1;
								
								$productcost		= 0;
								$productweight		= 0;
								$ebay_packingmaterialprice = 0;
								
								
								
								$totalline			= 0 ;
								$totalshipfeezj		= 0;
								$FinalValueFeezj	= 0;
								$FeeOrCreditAmountzj	= 0;
								
								
								
								
								$vvg					= "select * from ebay_orderdetail where ebay_ordersn ='$ebay_ordersn'";
								$vvg 				= $dbcon->execute($vvg);
								$vvg					= $dbcon->getResultArray($vvg);
								
								
								
			
								
								for($v=0;$v<count($vvg);$v++){
										
										
										$sku				= $vvg[$v]['sku'];
										$ebay_amount		= $vvg[$v]['ebay_amount'];
										$shipingfee			= $vvg[$v]['shipingfee'];
										$ebay_itemprice		= $vvg[$v]['ebay_itemprice'];
										$FinalValueFeezj		+= $vvg[$v]['FinalValueFee']* $ssrates;
										$FeeOrCreditAmountzj		= $vvg[$v]['FeeOrCreditAmount']* $ssrates;
										
										
										
										$totalline			+= ($ebay_itemprice * $ebay_amount + $shipingfee) * $ssrates;
										$totalshipfeezj		+= $shipingfee * $ssrates;
									
								
								
								$ssr				= "select goods_weight,goods_cost,ebay_packingmaterial from ebay_goods where goods_sn= '$sku' and ebay_user='$user'";
								$ssr 				= $dbcon->execute($ssr);
								$ssr				= $dbcon->getResultArray($ssr);
								if(count($ssr)>0){
									$sweight			= $ssr[0]['goods_weight'] * $ebay_amount;
									$scost				= $ssr[0]['goods_cost'] * $ebay_amount;
									$productcost		= $productcost + $scost;
									$productweight		= $productweight + $sweight;
									
									
									$ebay_packingmaterial			= $ssr[0]['ebay_packingmaterial'];
									$vv								= "select price from ebay_packingmaterial where model='$ebay_packingmaterial' and ebay_user='$user'";
									$vv								=  $dbcon->execute($vv);
									$vv								=  $dbcon->getResultArray($vv);
									$ebay_packingmaterialprice		+= $vv[0]['price'];
								
								
								}else{
									$ssr	= "select * from ebay_productscombine where ebay_user='$user' and goods_sn='$sku'";
									$ssr 	= $dbcon->execute($ssr);
									$ssr	= $dbcon->getResultArray($ssr);
									$goods_sncombine	= $ssr[0]['goods_sncombine'];
									$goods_sncombine    = explode(',',$goods_sncombine);	
									for($e=0;$e<count($goods_sncombine);$e++){
										$pline			= explode('*',$goods_sncombine[$e]);
										$goods_sn		= $pline[0];
										$goddscount     = $pline[1] * $ebay_amount;
										$ee			= "SELECT goods_cost,goods_weight,ebay_packingmaterial FROM ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
										$ee			= $dbcon->execute($ee);
										$ee 	 	= $dbcon->getResultArray($ee);
										$scost = $ee[0]['goods_cost']*$goddscount;
										$sweight = $ee[0]['goods_weight']*$goddscount;
										$productcost		= $productcost + $scost;
										$productweight		= $productweight + $sweight;
										
										
										$ebay_packingmaterial			= $ee[0]['ebay_packingmaterial'];
										$vv								= "select price from ebay_packingmaterial where model='$ebay_packingmaterial' and ebay_user='$user'";
										$vv								=  $dbcon->execute($vv);
										$vv								=  $dbcon->getResultArray($vv);
										$ebay_packingmaterialprice		+= $vv[0]['price'];
									
									
									}
								}
								
								
								}
								
								
								
								$total	+= $totalline;
								$shipingfee	= $totalshipfeezj;
								$FinalValueFee	= $FinalValueFeezj;
								$FeeOrCreditAmount			= $FeeOrCreditAmountzj;
								
								
								
								
								$vv			= "select rates from ebay_currency where currency='RMB' and user='$user'";
								$vv			=  $dbcon->execute($vv);
								$vv			=  $dbcon->getResultArray($vv);
								$ssrates	=  $vv[0]['rates']?$vv[0]['rates']:1;
								$productcost				= $productcost * $ssrates;
								$ebay_packingmaterialprice	= $ebay_packingmaterialprice * $ssrates;
								
								
								if($ordershipfee <=0 && $ebay_carrier != ''){
								
									$ssr			= "select * from ebay_carrier  where name = '$ebay_carrier' and ebay_user='$user'";
									$ssr			=  $dbcon->execute($ssr);
									$ssr			=  $dbcon->getResultArray($ssr);
									$ebay_carrier	= $ssr[0]['name'];
									$id				= $ssr[0]['id'];
									$ordershipfee		= shipfeecalc($id,$productweight,$ebay_countryname);
								}
								
								$ordershipfee				= $ordershipfee * $ssrates;
								
								$mll			= $totalline - $productcost - $FinalValueFee - $FeeOrCreditAmount - $ordershipfee;
								
								
								
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$countryjs, date('Y-m-d',$sdate));
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$countryjs, $ebay_id);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$countryjs, $ebay_carrier);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$countryjs, $ebay_userid);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$countryjs, $ebay_countryname);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$countryjs, $sku);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$countryjs, $ebay_amount);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$countryjs, $totalline);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$countryjs, $shipingfee);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$countryjs, $productcost);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$countryjs, $ordershipfee);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$countryjs, $FinalValueFee);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$countryjs, $FeeOrCreditAmount);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$countryjs, $ebay_packingmaterialprice);
								$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$countryjs, $mll);
								$countryjs++;
							
		}
		
					$sdate		= strtotime(date('Y-m-d H:i:s',strtotime("$startdate +".$countjs." days")));
					
					if($sdate >= $edate ) break;
					
					$countjs ++ ;
					
				
		
		}
		
		
		}
		






$objPHPExcel->getActiveSheet(0)->getStyle('A1:N500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(12);	

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





