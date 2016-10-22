<?php
	@session_start();
	error_reporting(0);
	$_SESSION['user']	= 'vipchen';
	
	$user	= $_SESSION['user'];
	
	include "include/config.php";
	
	$dbcon	= new DBClass();

	date_default_timezone_set ("Asia/Chongqing");	
	//date_default_timezone_set ( 'America/New_York' ); 
	date_default_timezone_set('UTC'); 
	



	
    $siteID = 0;  
    $detailLevel = 0;
	$nowtime	= date("Y-m-d H:i:s");
	$nowd		= date("Y-m-d");
	$Sordersn	= "eBay";
	$pagesize=20;//每页显示的数据条目数
	$mctime		= strtotime($nowtime);
	

						
						

				
						
				
						$sql 		 = "select * from errors_ack where status='0' ";
						$sql		 = $dbcon->execute($sql);
						$sql		 = $dbcon->getResultArray($sql);
			
						for($i=0;$i<count($sql);$i++){
						
						
							
							$ebay_account			= $sql[$i]['ebay_account'];
							$start					= $sql[$i]['starttime'];
							$end					= $sql[$i]['endtime'];
							$id						= $sql[$i]['id'];
							
							$rr						= "select * from ebay_account where ebay_account = '$ebay_account' ";
							$rr		 = $dbcon->execute($rr);
							$rr		 = $dbcon->getResultArray($rr);
							$token	 = $rr[0]['ebay_token'];							
							GetSellerTransactions($start,$end,$token,$ebay_account,$type=0,$id);
							
							
						
							
							
						}
						
						
						
						
						
						
						
				
					
						
					

						$sql		= "select * from ebay_order as a where ebay_user='$user'  and ebay_combine!='1' and (ebay_status = '1' or ebay_status = '593') and (ebay_carrier = '' or ebay_carrier is null)";
						
							
						$sql	= $dbcon->execute($sql);
						$sql	= $dbcon->getResultArray($sql);
						
		
		
						
						for($i=0;$i<count($sql);$i++){
					
						
							$ebay_countryname	= $sql[$i]['ebay_countryname'];
							$ebay_currency		= $sql[$i]['ebay_currency'];
							$ebay_total			= $sql[$i]['ebay_total'];
							$ebay_couny			= $sql[$i]['ebay_couny'];
							$ebay_id			= $sql[$i]['ebay_id'];
							$ebay_note			= $sql[$i]['ebay_note'];
							$ebay_ordersn		= $sql[$i]['ebay_ordersn'];
							$ebay_userid		= $sql[$i]['ebay_userid'];
							$ebay_account		= $sql[$i]['ebay_account'].',';
							
							
							
							
							$ss					= "select * from ebay_currency where currency = '$ebay_currency' and user = '$user'";
							$ss					= $dbcon->execute($ss);
							$ss					= $dbcon->getResultArray($ss);
							
						
							
							
							// 将有留言订单转到有留言订单分类中去
							
							if($ebay_note != '' && $notesorderstatus >= 1){
							
							$ss				= "update ebay_order set ebay_status = '$notesorderstatus' where ebay_id = '$ebay_id' ";
							echo $ss.'<br>';
							
							$dbcon->execute($ss);
							
							}
							
							
							
							
							/* 计算包装材料和订单总重量 */
							$st	= "select * from ebay_orderdetail where ebay_ordersn='$ebay_ordersn'";
							$st = $dbcon->execute($st);
							$st	= $dbcon->getResultArray($st);
							
							
							
							$iszuhe		= 0;
							
							for($f=0;$f<count($st); $f++){
								
								$sku		= $st[$f]['sku'];
								$rr			= "select * from ebay_productscombine where ebay_user='$user' and goods_sn='$sku'";
								$rr			= $dbcon->execute($rr);
								$rr 	 	= $dbcon->getResultArray($rr);
								if(count($rr) > 0) $iszuhe = 1;
							}
							
							if($iszuhe == '1') $rr= "update ebay_order set ebay_status ='606' where ebay_id = '$ebay_id' ";
							$totalweight				= 0;
							$totalweight2				= 0;
								
							
							if(count($st)  == 1){
								
								/* 计算订单中单个物品包材的重量 */
							
								
								$sku						=  $st[0]['sku'];
								$ebay_amount				=  $st[0]['ebay_amount'];
								
								/* 开始检查是否是组合产品 */
								$rr			= "select * from ebay_productscombine where ebay_user='$user' and goods_sn='$goodssn'";
								$rr			= $dbcon->execute($rr);
								$rr 	 	= $dbcon->getResultArray($rr);
		
				
								if(count($rr) > 0){
			
										$goods_sncombine	= $rr[0]['goods_sncombine'];
										$goods_sncombine    = explode(',',$goods_sncombine);
										for($e=0;$e<count($goods_sncombine);$e++){
												$pline			= explode('*',$goods_sncombine[$e]);
												$goods_sn		= $pline[0];
												$goddscount     = $pline[1] * $ebay_amount;
												$ee			= "SELECT * FROM ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
												$ee			= $dbcon->execute($ee);
												$ee 	 	= $dbcon->getResultArray($ee);
												$ebay_packingmaterial		=  $ee[0]['ebay_packingmaterial'];			
												$goods_weight				=  $ee[0]['goods_weight'];					// 产品重量子力学
												$capacity					=  $ee[0]['capacity'];						//产品容量
												$ss					= "select * from ebay_packingmaterial where  model='$ebay_packingmaterial' and ebay_user ='$user' ";
												$ss					= $dbcon->execute($ss);
												$ss					= $dbcon->getResultArray($ss);
												$pweight			= $ss[0]['weight'];
												if($goddscount <= $capacity){
													$totalweight			+= $pweight*$goddscount + ($goods_weight * $goddscount);
												}else{
													// 计算多个包材的重量   $ebay_amount 单个sku购买的数量 ebay_packingmaterial 包材的重量
													$totalweight2			+= $goods_weight*$ebay_amount + $pweight;
												}
										}
										if($totalweight2>0) $totalweight2			+= 0.6 * $pweight ;
								}else{
						
				
								
										$ss							= "select * from ebay_goods where  goods_sn='$sku' and ebay_user ='$user' ";
										$ss							= $dbcon->execute($ss);
										$ss							= $dbcon->getResultArray($ss);
										$ebay_packingmaterial		=  $ss[0]['ebay_packingmaterial'];			
										$goods_weight				=  $ss[0]['goods_weight'];					// 产品重量子力学
										$capacity					=  $ss[0]['capacity'];						//产品容量
										
										$ss					= "select * from ebay_packingmaterial where  model='$ebay_packingmaterial' and ebay_user ='$user' ";
										$ss					= $dbcon->execute($ss);
										$ss					= $dbcon->getResultArray($ss);
										$pweight			= $ss[0]['weight'];
										
										if($ebay_amount <= $capacity){
										
											$totalweight			+= $pweight + $goods_weight*$ebay_amount;
										
										}else{
											// 计算多个包材的重量   $ebay_amount 单个sku购买的数量 ebay_packingmaterial 包材的重量
											$totalweight2			+= $goods_weight*$ebay_amount + $pweight;	
											
											
										}
										if($totalweight2>0) $totalweight2			+= 0.6 * $pweight ;
							}
								

					
							
							
							}else{
								
								
								/* 计算订单中多个物品包材的重量 */
								$totalweight				= 0;		
								$totalweight2				= 0;
								
								
								for($f=0;$f<count($st); $f++){
									
									
										
										
										$sku						=  $st[$f]['sku'];
										$ebay_amount				=  $st[$f]['ebay_amount'];
										
										/* 开始检查是否是组合产品 */
										$rr			= "select * from ebay_productscombine where ebay_user='$user' and goods_sn='$goodssn'";
										$rr			= $dbcon->execute($rr);
										$rr 	 	= $dbcon->getResultArray($rr);
		
				
								if(count($rr) > 0){
			
									$goods_sncombine	= $rr[0]['goods_sncombine'];
									$goods_sncombine    = explode(',',$goods_sncombine);
					
					
					
									for($e=0;$e<count($goods_sncombine);$e++){
						
						
											$pline			= explode('*',$goods_sncombine[$e]);
											$goods_sn		= $pline[0];
											$goddscount     = $pline[1] * $ebay_amount;
						
											$ee			= "SELECT * FROM ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
											$ee			= $dbcon->execute($ee);
											$ee 	 	= $dbcon->getResultArray($ee);
											$ebay_packingmaterial		=  $ee[0]['ebay_packingmaterial'];			
											$goods_weight				=  $ee[0]['goods_weight'];					// 产品重量子力学
											$capacity					=  $ee[0]['capacity'];						//产品容量
											
											$ss					= "select * from ebay_packingmaterial where  model='$ebay_packingmaterial' and ebay_user ='$user' ";
											$ss					= $dbcon->execute($ss);
											$ss					= $dbcon->getResultArray($ss);
											$pweight			= $ss[0]['weight'];
											
											if($goddscount <= $capacity){
												$totalweight			+= $pweight + $goods_weight*$ebay_amount;
											}else{
											
												// 计算多个包材的重量   $ebay_amount 单个sku购买的数量 ebay_packingmaterial 包材的重量
												$totalweight2			+= $goods_weight*$ebay_amount + $pweight;	
												
												
											}
											
									}
									
									
							}else{
						
				
								
								$ss							= "select * from ebay_goods where  goods_sn='$sku' and ebay_user ='$user' ";
								$ss							= $dbcon->execute($ss);
								$ss							= $dbcon->getResultArray($ss);
								$ebay_packingmaterial		=  $ss[0]['ebay_packingmaterial'];			
								$goods_weight				=  $ss[0]['goods_weight'];					// 产品重量子力学
								$capacity					=  $ss[0]['capacity'];						//产品容量
								
								
								
								$ss					= "select * from ebay_packingmaterial where  model='$ebay_packingmaterial' and ebay_user ='$user' ";
								$ss					= $dbcon->execute($ss);
								$ss					= $dbcon->getResultArray($ss);
								$pweight			= $ss[0]['weight'];
								
								if($ebay_amount <= $capacity){
								
									$totalweight			+= $pweight + $goods_weight*$ebay_amount;
								
								}else{
									// 计算多个包材的重量   $ebay_amount 单个sku购买的数量 ebay_packingmaterial 包材的重量
									$totalweight2			+= $goods_weight*$ebay_amount + $pweight;	
									
								}
								
								
								
								
								}
								
								
								}
								if($totalweight2>0) $totalweight2			+= 0.6 * $pweight ;
							
							}
							
							
							$totalweight		= $totalweight2  + $totalweight;
							
							
							
							
							$fees								= calcshippingfee($totalweight,$ebay_countryname,$ebay_id,$ebay_account,$ebay_total);
							$ebay_carrier						= $fees[0];
							$fee								= $fees[1];
							$totalweight						= $fees[2];
							$bb						= "update ebay_order set ebay_carrier='$ebay_carrier',ordershipfee='$fee',orderweight ='$totalweight',packingtype ='$ebay_packingmaterial' where ebay_id ='$ebay_id' ";
							
							echo $bb.$ebay_userid;
							$dbcon->execute($bb);
							
							
							
							if($totalweight > 2){
							$bb						= "update ebay_order set ebay_status ='608' where ebay_id ='$ebay_id' ";
							$dbcon->execute($bb);
							}
							
						
							
								
								
								
								
							
						
							
							
							
						
						}
						
						
						
						 $dbcon->close(); 
						
						?>
						