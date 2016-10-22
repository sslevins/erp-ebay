<?php

include "include/config.php";

					$bill		= isset($_GET['bill'])?$_GET['bill']:'';
					$sql		= "select * from ebay_order as a where ebay_user='$user' and ebay_status='2' and ebay_combine!='1'";
					$sql	.= " and  a.profitstatus ='0'  ";
					if($bill){
						$orderid = substr($bill,1);
						$sql	.= " and a.ebay_id in ($orderid) ";
					}
					$sql 		.= ' limit 0,50000 ';
					$sql		= $dbcon->execute($sql);
					$sql		= $dbcon->getResultArray($sql);
					

				for($i=0;$i<count($sql);$i++){
					
	
					
					

	
					$ebayid		= $sql[$i]['ebay_id'];
					$ebay_ordertype		= $sql[$i]['ebay_ordertype'];
					$ebay_ptid	= $sql[$i]['ebay_ptid'];
					$ordersn	= $sql[$i]['ebay_ordersn'];
					$total		= $sql[$i]['ebay_total'];
					$currency	= $sql[$i]['ebay_currency'];
					$paidtime	= $sql[$i]['ebay_paidtime'];
					$ebay_combine	= $sql[$i]['ebay_combine'];
					



					

					$RefundAmount	= $sql[$i]['RefundAmount'];

					


					$ebay_countryname		= $sql[$i]['ebay_countryname'];
					$country		= $sql[$i]['ebay_countryname'];
					$isprint		= $sql[$i]['isprint'];

					$status			= Getstatus($sql[$i]['ebay_status']);

					$account		= $sql[$i]['ebay_account'];

					$shipfee		= $sql[$i]['ebay_shipfee'];

					$ebay_paystatus	= trim($sql[$i]['ebay_paystatus']);



					$ebaynote	= $sql[$i]['ebay_note'];

					

					$ebay_carrier				= $sql[$i]['ebay_carrier'];

					$recordnumber				= $sql[$i]['recordnumber'];
					$orderweight2				= $sql[$i]['orderweight2'];

								$orderweight				= $sql[$i]['orderweight'];

							   
							   $st	= "select sku,ebay_itemtitle,ebay_amount from ebay_orderdetail where ebay_ordersn='$ordersn'";

								$st = $dbcon->execute($st);
								$st	= $dbcon->getResultArray($st);

						
							$productcost		= 0;
							$productweight		= 0;
							

							

							for($t=0;$t<count($st);$t++){

								$sku					= $st[$t]['sku'];
								$ebay_itemtitle			= $st[$t]['ebay_itemtitle'];
								$ebay_amount			= $st[$t]['ebay_amount'];
								
								$ssr				= "select goods_weight,goods_cost from ebay_goods where goods_sn= '$sku' and ebay_user='$user'";
								$ssr 				= $dbcon->execute($ssr);
								$ssr				= $dbcon->getResultArray($ssr);
								
								if(count($ssr)>0){
									$sweight			= $ssr[0]['goods_weight'] * $ebay_amount;
									$scost				= $ssr[0]['goods_cost'] * $ebay_amount;
									$productcost		= $productcost + $scost;
									$productweight		= $productweight + $sweight;
								}else{
									$ssr	= "select goods_sncombine from ebay_productscombine where ebay_user='$user' and goods_sn='$sku'";
									$ssr 	= $dbcon->execute($ssr);
									$ssr	= $dbcon->getResultArray($ssr);
									$goods_sncombine	= $ssr[0]['goods_sncombine'];
									$goods_sncombine    = explode(',',$goods_sncombine);	
									for($e=0;$e<count($goods_sncombine);$e++){
										$pline			= explode('*',$goods_sncombine[$e]);
										$goods_sn		= $pline[0];
										$goddscount     = $pline[1] * $ebay_amount;
										$ee			= "SELECT goods_cost,goods_weight FROM ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
										$ee			= $dbcon->execute($ee);
										$ee 	 	= $dbcon->getResultArray($ee);
										$scost = $ee[0]['goods_cost']*$goddscount;
										$sweight = $ee[0]['goods_weight']*$goddscount;
										$productcost		= $productcost + $scost;
										$productweight		= $productweight + $sweight;
									}
								}
								
							}
							
							
					
							
							if($orderweight >0) $productweight = $orderweight;
							if($orderweight2 >0 )  $productweight	= $orderweight2/1000;
							

							/* 物品成本  productcost */
							$ss			= "select rates from ebay_currency where currency='RMB' and user='$user'";
							$ss			=  $dbcon->execute($ss);
							$ss			=  $dbcon->getResultArray($ss);
							$ssrates	=  $ss[0]['rates']?$ss[0]['rates']:1;
							$productcost = $productcost * $ssrates;
							
							
							
							if($ordercopst >0 )  $productcost   = $ordercopst;
							/* 物品运费 */

							
							$productweight	= $productweight;
							$shipfee		= 0;
											
							$vv				= " select id from ebay_carrier where name='$ebay_carrier' and ebay_user ='$user' ";
						
							
							$vv				= $dbcon->execute($vv);
							$vv				= $dbcon->getResultArray($vv);
							$id				= $vv[0]['id'];
							$value		= shipfeecalc($id,$productweight,$ebay_countryname);
							
							
							$shipfee		= $value * $ssrates;	
									
									
									
									
			$rr		= "update ebay_order set ordershipfee='$shipfee',ordercopst='$productcost',orderweight='$productweight',profitstatus='1' where ebay_id ='$ebayid'";
			
			//echo $rr;
			
		$dbcon->execute($rr);

	echo $ebayid.'------Success<br>';
		
					
		
							}
							

	
?>

