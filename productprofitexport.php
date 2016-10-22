<?php
				@session_start();
				error_reporting(0);
				include "include/dbconnect.php";
				//include "include/ebay_lib.php";
				date_default_timezone_set ("Asia/Chongqing");
				require_once 'Classes/PHPExcel.php';
				$objPHPExcel = new PHPExcel();
				$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
												->setLastModifiedBy("Maarten Balliauw")
												->setTitle("Office 2007 XLSX Test Document")
												->setSubject("Office 2007 XLSX Test Document")
												->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
												->setKeywords("office 2007 openxml php")
												->setCategory("Test result file");
				$dbcon	= new DBClass();
 				function getProductsqty($start,$end,$goods_sn,$io_warehouse){ 						global $dbcon;
					$gsql			= "select  SUM( b.goods_count) as cc  from ebay_iostore as a join ebay_iostoredetail as b on a.io_ordersn = b.io_ordersn where b.goods_sn='$goods_sn' ";
						$gsql		   .= "  and type ='1' ";
 						if($start != '' && $end != '') $gsql .= " and (a.io_addtime	>'".strtotime($start)."' && a.io_addtime	<'".strtotime($end)."') ";
 						if($io_warehouse > 0) $gsql .= " and a.io_warehouse ='$io_warehouse' ";
						$gsql			= $dbcon->execute($gsql);
						$gsql			= $dbcon->getResultArray($gsql);
						//print_r($gsql);
						$qty1	=  $gsql[0]['cc']?$gsql[0]['cc']:0;
						return $qty1;
 				}
	
	function shipfeecalc($shippingid,$kg,$ebay_countryname){
			
			global $dbcon;
			
			$ss				= " select * from ebay_systemshipfee where shippingid ='$shippingid'";
			$ss				= $dbcon->execute($ss);
			$ss				= $dbcon->getResultArray($ss);
			$kg				= $kg * 1000;
			
			$type			= $ss[0]['type'];
			if($type 		== 0){
			$vv				= "select * from ebay_systemshipfee where $kg between aweightstart and aweightend and acountrys like '%$ebay_countryname%' and shippingid ='$shippingid'";
			$vv				= $dbcon->execute($vv);
			$vv				= $dbcon->getResultArray($vv);
			$shipfee		= $vv[0]['ashipfee'] + $vv[0]['ahandlefee'];
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
			
				if($kg <= ($bfirstweight)){
				$shipfee	= $bfirstweightamount + $bhandlefee;
				}else{
				$shipfee	= ceil((($kg-$bfirstweight)/$bnextweight))*$bnextweightamount + $bfirstweightamount + $bhandlefee;
				}
				
				
				$shipfee				= $shipfee * $bdiscount;
				
			
			}
			

			return $shipfee;
			
		
		
		}
				
				$user=$_SESSION['user'];
				$virifydays		= @$_REQUEST['virifydays'];
				$type			= @$_REQUEST['type'];
				$sorts			= $_REQUEST['sorts'];
				$startdate		= $_REQUEST['startdate'];
				$enddate		= $_REQUEST['enddate'];
				$account		= $_REQUEST['account'];
				$goodscategory	= $_REQUEST['goodscategory'];
				$skus			= $_REQUEST['sku'];
				$startdate2		= $_REQUEST['startdate2'];
				$enddate2		= $_REQUEST['enddate2'];
				$ebay_site		= @$_REQUEST['ebay_site'];
				
				if($sorts =='-1' or $sorts ==''){
					
					$vv			= "delete from ebay_goodssort ";
					$dbcon->query($vv);
					
					
					/* 写入排序表 */
					
					if($skus){
					$sql2		= "select goods_sn,goods_name,goods_cost,goods_weight	 from ebay_goods where ebay_user='$user' and goods_sn='$skus'";
					
					$sql2		= $dbcon->execute($sql2);
					$sql2		= $dbcon->getResultArray($sql2);
					
					$goods_sn		= $sql2[0]['goods_sn'];
					$goods_name		= $sql2[0]['goods_name'];
					$goods_cost		= $sql2[0]['goods_cost'];
					
					$goods_weight	= $sql2[0]['goods_weight'];
					$accsql		= "select ebay_account from ebay_orderdetail where sku='$goods_sn' group by ebay_account ";
					$accsql		= $dbcon->execute($accsql);
					$accsql		= $dbcon->getResultArray($accsql);
							
					for($i=0;$i<count($accsql);$i++){
							$accountname = $accsql[$i]['ebay_account'];
							$dsql			= "SELECT sum(b.ebay_amount) as qty,sum(FinalValueFee) as FinalValueFee,sum(FeeOrCreditAmount) as FeeOrCreditAmount,sum(b.ebay_amount * b.ebay_itemprice) as totalprice,ebay_currency,ebay_carrier,ebay_countryname FROM ebay_order AS a JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn WHERE sku =  '$goods_sn'";
							$dsql .= " and a.ebay_account='$accountname'";
							if($startdate !='' && $enddate !='') $dsql .= " and (a.ebay_paidtime>'".strtotime($startdate." 00:00:00")."' && a.ebay_paidtime<'".strtotime($enddate." 23:59:59")."')";						
							
							if($ebay_site != '' ) $dsql	.= " and b.ebay_site ='$ebay_site' ";	
							$dsql			.= " group by a.ebay_carrier,a.ebay_currency ";
							
		
					
							$dsql			= $dbcon->execute($dsql);
							$dsql			= $dbcon->getResultArray($dsql);
							$totalqty		= 0;
							$totalprice		= 0;
							$totalFinalValueFee	= 0;
							$totalFeeOrCreditAmount		= 0;
							$totalshipfee				= 0;
							for($v=0;$v<count($dsql);$v++){
							
								$ebay_countryname				= $dsql[$v]['ebay_countryname'];
								$ebay_carrier					= $dsql[$v]['ebay_carrier'];
								$qty							= $dsql[$v]['qty'];
								$totalweight					= $goods_weight*$qty;
								
								if($ebay_carrier != ''){
								$vv		= "select id from ebay_carrier where name = '$ebay_carrier' ";
								
						
								
								$vv		= $dbcon->execute($vv);
								$vv		= $dbcon->getResultArray($vv);
								$id				= $vv[0]['id'];
								if($ebay_carrier != ''){
								 $totalshipfee	+= shipfeecalc($id,$totalweight,$ebay_countryname);
								}
								
								
								}
								
								$totalqty	= $totalqty + $qty;
								
								$total					= $dsql[$v]['totalprice'];
								$ebay_currency			= $dsql[$v]['ebay_currency'];
								$FinalValueFee			= $dsql[$v]['FinalValueFee'];
								$FeeOrCreditAmount		= $dsql[$v]['FeeOrCreditAmount'];
								
								$vv			= "select * from ebay_currency where currency='$ebay_currency' and user='$user'";
								$vv			=  $dbcon->execute($vv);
								$vv			=  $dbcon->getResultArray($vv);
								$ssrates	=  $vv[0]['rates']?$vv[0]['rates']:1;
								
								$totalprice				+= $total * $ssrates;			// 总销售额
								$totalFinalValueFee		+= $FinalValueFee * $ssrates;	// 成交费用
								$totalFeeOrCreditAmount	+= $FeeOrCreditAmount * $ssrates;	// 成交费用
								
								
							}
							
							/* 计算产品总成本 */
							
							$totalgoods_cost			= $goods_cost * $totalqty;
							$vv			= "select * from ebay_currency where currency='RMB' and user='$user'";
							$vv			=  $dbcon->execute($vv);
							$vv			=  $dbcon->getResultArray($vv);
							$ssrates	=  $vv[0]['rates']?$vv[0]['rates']:1;
							$totalgoods_cost	 = $totalgoods_cost * $ssrates;
							$totalshipfee  = $totalshipfee * $ssrates;
							
							/* 计算退款总金额 */
							$vv					= "select sum(ebay_refundamount) as cc from ebay_rma where `sku` = '$goods_sn' and  rtatype = '退款'";
							$vv					= $dbcon->execute($vv);
							$vv					= $dbcon->getResultArray($vv);
							$vvrefundcost		= $vv[0]['cc']?$vv[0]['cc']:0 ;
							
							
							/* 计算重寄总金额 */
							$vv					= "select sum(ebay_refundamount) as cc from ebay_rma where `sku` = '$goods_sn' and  rtatype = '重寄'";
							$vv					= $dbcon->execute($asql);
							$vv					= $dbcon->getResultArray($vv);
							$vvresendfundcost	= $vv[0]['cc']?$vv[0]['cc']:0 ;
							
							/* 总的利润 */
							$totalprofit		= $totalprice - $totalFinalValueFee - $totalFeeOrCreditAmount - $totalgoods_cost - $vvrefundcost - $vvresendfundcost - $totalshipfee;
							$ss		= "insert into ebay_goodssort(goods_sn,qty,totalprice,totalprofit,totalgoods_cost,goods_name,shipfee,ebayfee,paypalfee,account,goods_cost) values('$goods_sn','$totalqty','$totalprice','$totalprofit','$totalgoods_cost','$goods_name','$totalshipfee','$totalFinalValueFee','$totalFeeOrCreditAmount','$accountname','$goods_cost')";
							
							
								$ss		= "insert into ebay_goodssort(goods_sn,qty,totalprice,totalprofit,goods_cost,goods_name,ebay_user) values('$goods_sn','$totalqty','$totalprice','$totalprofit','$goods_cost','$goods_name','$user')";
								
								
			
							
							$dbcon->execute($ss);
							
					
					}
					
					}else{
					$sql2		= "select goods_sn,goods_name,goods_cost,goods_weight	 from ebay_goods where ebay_user='$user'";
					
					$sql2		= $dbcon->execute($sql2);
					$sql2		= $dbcon->getResultArray($sql2);
					
					for($i=0;$i<count($sql2);$i++){
					$goods_sn		= $sql2[$i]['goods_sn'];
					$goods_name		= $sql2[$i]['goods_name'];
					$goods_cost		= $sql2[$i]['goods_cost'];
					$goods_weight	= $sql2[$i]['goods_weight'];
					
		
							
							
							
							$dsql			= "SELECT sum(b.ebay_amount) as qty,sum(FinalValueFee) as FinalValueFee,sum(FeeOrCreditAmount) as FeeOrCreditAmount,sum(b.ebay_amount * b.ebay_itemprice) as totalprice,ebay_currency,ebay_carrier,ebay_countryname FROM ebay_order AS a JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn WHERE sku =  '$goods_sn'";
							if($account != "-1" && $account !=''){ $dsql .= " and a.ebay_account='$account'";}
							if($startdate !='' && $enddate !='') $dsql .= " and (a.ebay_paidtime>'".strtotime($startdate." 00:00:00")."' && a.ebay_paidtime<'".strtotime($enddate." 23:59:59")."')";						
							
							if($ebay_site != '' ) $dsql	.= " and b.ebay_site ='$ebay_site' ";
				
								$dsql			.= " group by a.ebay_carrier,a.ebay_currency ";
					
							
		
					
							$dsql			= $dbcon->execute($dsql);
							$dsql			= $dbcon->getResultArray($dsql);
							$totalqty		= 0;
							$totalprice		= 0;
							$totalFinalValueFee	= 0;
							$totalFeeOrCreditAmount		= 0;
							$totalshipfee				= 0;
							
							for($v=0;$v<count($dsql);$v++){
							
								$ebay_countryname				= $dsql[$v]['ebay_countryname'];
								$ebay_carrier					= $dsql[$v]['ebay_carrier'];
								$qty							= $dsql[$v]['qty'];
								$totalweight					= $goods_weight*$qty;
								
								if($ebay_carrier != ''){
								$vv		= "select id from ebay_carrier where name = '$ebay_carrier' ";
								
						
								
								$vv		= $dbcon->execute($vv);
								$vv		= $dbcon->getResultArray($vv);
								$id				= $vv[0]['id'];
								
								$totalshipfee	+= shipfeecalc($id,$totalweight,$ebay_countryname);
								
								
								}
								
								$totalqty	= $totalqty + $qty;
								
								$total					= $dsql[$v]['totalprice'];
								$ebay_currency			= $dsql[$v]['ebay_currency'];
								$FinalValueFee			= $dsql[$v]['FinalValueFee'];
								$FeeOrCreditAmount		= $dsql[$v]['FeeOrCreditAmount'];
								
								$vv			= "select rates from ebay_currency where currency='$ebay_currency' and user='$user'";
								$vv			=  $dbcon->execute($vv);
								$vv			=  $dbcon->getResultArray($vv);
								$ssrates	=  $vv[0]['rates']?$vv[0]['rates']:1;
								$totalprice				+= $total * $ssrates;			// 总销售额
								$totalFinalValueFee		+= $FinalValueFee * $ssrates;	// 成交费用
								$totalFeeOrCreditAmount	+= $FeeOrCreditAmount * $ssrates;	// 成交费用
								
								
							}
							/* 计算产品总成本 */
							$totalgoods_cost			= $goods_cost * $totalqty;
							$vv			= "select rates from ebay_currency where currency='RMB' and user='$user'";
							$vv			=  $dbcon->execute($vv);
							$vv			=  $dbcon->getResultArray($vv);
							$ssrates	=  $vv[0]['rates']?$vv[0]['rates']:1;
							$totalgoods_cost = $totalgoods_cost * $ssrates;
							$totalshipfee  = $totalshipfee * $ssrates;
							
							
							/* 计算退款总金额 */
							$vv					= "select sum(ebay_refundamount) as cc from ebay_rma where `sku` = '$goods_sn' and  rtatype = '退款'";
							$vv					= $dbcon->execute($vv);
							$vv					= $dbcon->getResultArray($vv);
							$vvrefundcost		= $vv[0]['cc']?$vv[0]['cc']:0 ;
							
							
							/* 计算重寄总金额 */
							$vv					= "select sum(ebay_refundamount) as cc from ebay_rma where `sku` = '$goods_sn' and  rtatype = '重寄'";
							$vv					= $dbcon->execute($asql);
							$vv					= $dbcon->getResultArray($vv);
							$vvresendfundcost	= $vv[0]['cc']?$vv[0]['cc']:0 ;
							
							/* 总的利润 */
							$totalprofit		= $totalprice - $totalFinalValueFee - $totalFeeOrCreditAmount - $totalgoods_cost - $vvrefundcost - $vvresendfundcost - $totalshipfee;
							$ss		= "insert into ebay_goodssort(goods_sn,qty,totalprice,totalprofit,totalgoods_cost,goods_name,shipfee,ebayfee,paypalfee,account,goods_cost) values('$goods_sn','$totalqty','$totalprice','$totalprofit','$totalgoods_cost','$goods_name','$totalshipfee','$totalFinalValueFee','$totalFeeOrCreditAmount','','$goods_cost')";

								$ss		= "insert into ebay_goodssort(goods_sn,qty,totalprice,totalprofit,goods_cost,goods_name,ebay_user) values('$goods_sn','$totalqty','$totalprice','$totalprofit','$goods_cost','$goods_name','$user')";
								
								
								
							$dbcon->execute($ss);
							
					
					}
				
					
					}
					/*结束*/
				
				}
					
				
				
				$sql		= "select *	 from ebay_goodssort where ebay_user='$user' ";
					
				if($sorts	== '1') $sql .= "  order by qty desc ";
				if($sorts	== '2') $sql .= "  order by totalprice desc";
				if($sorts	== '3') $sql .= "  order by totalprofit desc ";
				$sql		= $dbcon->execute($sql);
				$sql		= $dbcon->getResultArray($sql);
				if($skus){
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('A1', "Sku", PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('B1', "产品名称", PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('C1', "产品成本", PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('D1', "销售账号", PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('E1', "总销量", PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('F1', "总销售额", PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('G1', "总ebay费用", PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('H1', "总paypal费用", PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('I1', "总成本", PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('J1', "退款总金额", PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('K1', "重寄总成本", PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('L1', "总运费", PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('M1', "总利润", PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('N1', "利润率", PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('O1', "差评/重寄/垦款", PHPExcel_Cell_DataType::TYPE_STRING);
				
				}else{
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('A1', "Sku", PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('B1', "产品名称", PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('C1', "产品成本", PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('D1', "总销量", PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('E1', "总销售额", PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('F1', "总ebay费用", PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('G1', "总paypal费用", PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('H1', "总成本", PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('I1', "退款总金额", PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('J1', "重寄总成本", PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('K1', "总运费", PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('L1', "总利润", PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('M1', "利润率", PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('N1', "差评/重寄/垦款", PHPExcel_Cell_DataType::TYPE_STRING);
				}
				$a=2;

				for($i=0;$i<count($sql);$i++){
					$goods_sn		= $sql[$i]['goods_sn'];
					$goods_name		= $sql[$i]['goods_name'];
					$goods_cost		= $sql[$i]['goods_cost'];
					$totalgoods_cost		= $sql[$i]['totalgoods_cost'];
					$totalqty   	= $sql[$i]['qty'];
					$totalprice   	= $sql[$i]['totalprice'];
					$totalprofit   	= $sql[$i]['totalprofit'];
					$totalshipfee   	= $sql[$i]['shipfee'];
					$totalFinalValueFee   	= $sql[$i]['ebayfee'];
					$totalFeeOrCreditAmount = $sql[$i]['paypalfee'];
					$ebay_account 	= $sql[$i]['account'];
							
							
							/* 计算退款总金额 */
							$vv					= "select sum(ebay_refundamount) as cc from ebay_rma where `sku` = '$goods_sn' and  rtatype = '退款'";
							$vv					= $dbcon->execute($vv);
							$vv					= $dbcon->getResultArray($vv);
							$vvrefundcost		= $vv[0]['cc']?$vv[0]['cc']:0 ;
							
							
							/* 计算重寄总金额 */
							$vv					= "select sum(ebay_refundamount) as cc from ebay_rma where `sku` = '$goods_sn' and  rtatype = '重寄'";
							$vv					= $dbcon->execute($vv);
							$vv					= $dbcon->getResultArray($vv);
							$vvresendfundcost	= $vv[0]['cc']?$vv[0]['cc']:0 ;
							
							
				
							$nn				= "select count(*) as cc from ebay_rma where `sku` = '$goods_sn' and  rtatype = '差评'";
							$nn				= $dbcon->execute($nn);
							$nn				= $dbcon->getResultArray($nn);
							$nnstr=$nn[0]['cc'].'/';
							
							$nn				= "select count(*) as cc from ebay_rma where `sku` = '$goods_sn' and  rtatype = '重寄'";
							$nn				= $dbcon->execute($nn);
							$nn				= $dbcon->getResultArray($nn);
							$nnstr.=$nn[0]['cc'].'/';
						
							$nn				= "select count(*) as cc from ebay_rma where `sku` = '$goods_sn' and  rtatype = '垦款'";
							$nn				= $dbcon->execute($nn);
							$nn				= $dbcon->getResultArray($nn);
							$nnstr.=$nn[0]['cc'];
							if($skus){
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('A'.$a, $goods_sn, PHPExcel_Cell_DataType::TYPE_STRING);
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('B'.$a, $goods_name, PHPExcel_Cell_DataType::TYPE_STRING);
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('C'.$a, $goods_cost, PHPExcel_Cell_DataType::TYPE_STRING);
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('D'.$a, $ebay_account, PHPExcel_Cell_DataType::TYPE_STRING);
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$a, $totalqty, PHPExcel_Cell_DataType::TYPE_STRING);
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('F'.$a, number_format($totalprice,2), PHPExcel_Cell_DataType::TYPE_STRING);
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('G'.$a, number_format($totalFinalValueFee,2), PHPExcel_Cell_DataType::TYPE_STRING);
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('H'.$a, number_format($totalFeeOrCreditAmount,2), PHPExcel_Cell_DataType::TYPE_STRING);
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('I'.$a, $totalgoods_cost, PHPExcel_Cell_DataType::TYPE_STRING);
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('J'.$a, $vvrefundcost, PHPExcel_Cell_DataType::TYPE_STRING);
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('K'.$a, $vvresendfundcost, PHPExcel_Cell_DataType::TYPE_STRING);
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('L'.$a, number_format($totalshipfee,2), PHPExcel_Cell_DataType::TYPE_STRING);
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('M'.$a, number_format($totalprofit,2), PHPExcel_Cell_DataType::TYPE_STRING);
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('N'.$a, number_format($totalprofit/($totalgoods_cost+$totalshipfee ),5), PHPExcel_Cell_DataType::TYPE_STRING);
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('O'.$a, $nnstr, PHPExcel_Cell_DataType::TYPE_STRING);
							}else{
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('A'.$a, $goods_sn, PHPExcel_Cell_DataType::TYPE_STRING);
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('B'.$a, $goods_name, PHPExcel_Cell_DataType::TYPE_STRING);
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('C'.$a, $goods_cost, PHPExcel_Cell_DataType::TYPE_STRING);
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('D'.$a, $totalqty, PHPExcel_Cell_DataType::TYPE_STRING);
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$a, number_format($totalprice,2), PHPExcel_Cell_DataType::TYPE_STRING);
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('F'.$a, number_format($totalFinalValueFee,2), PHPExcel_Cell_DataType::TYPE_STRING);
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('G'.$a, number_format($totalFeeOrCreditAmount,2), PHPExcel_Cell_DataType::TYPE_STRING);
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('H'.$a, $totalgoods_cost, PHPExcel_Cell_DataType::TYPE_STRING);
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('I'.$a, $vvrefundcost, PHPExcel_Cell_DataType::TYPE_STRING);
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('J'.$a, $vvresendfundcost, PHPExcel_Cell_DataType::TYPE_STRING);
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('K'.$a, number_format($totalshipfee,2), PHPExcel_Cell_DataType::TYPE_STRING);
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('L'.$a, number_format($totalprofit,2), PHPExcel_Cell_DataType::TYPE_STRING);
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('M'.$a, number_format($totalprofit/($totalgoods_cost+$totalshipfee ),5), PHPExcel_Cell_DataType::TYPE_STRING);
									$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('N'.$a, $nnstr, PHPExcel_Cell_DataType::TYPE_STRING);
							}
                  $a++;
                  
                 

				
				} 
				
				$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(15);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(30);	


$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(15);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(15);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(15);


				$title			= "productprofitexport".date('Y-m-d');
				$titlename		= "productprofitexport".date('Y-m-d').".xls";
				$objPHPExcel->getActiveSheet()->setTitle($title);
				
				$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
				
				
				
				header('Content-Type: application/vnd.ms-excel');
				//$titlename		= "productprofitimport".date('Y-m-d').".xls";
				header("Content-Disposition: attachment;filename={$titlename}");
				
				header('Cache-Control: max-age=0');
				
				header("Content-Type:text/html;charset=utf-8");
				$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:F500')->getAlignment()->setWrapText(true);
				
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
				
				$objWriter->save('php://output');
				
				exit;
