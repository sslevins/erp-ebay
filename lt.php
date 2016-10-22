<?php
	@session_start();
	error_reporting(0);
	date_default_timezone_set ("Asia/Chongqing");	
	include "include/dbconnect.php";
	include "include/eBaySession.php";
	include "include/xmlhandle.php";
	include "include/ebay_lib.php";
	include "include/cls_page.php";
	include "include/ebay_liblist.php";
	$dbcon	= new DBClass();
	
	$siteID = 0;  
    $detailLevel = 0;
	$nowtime	= date("Y-m-d H:i:s");
	$nowd		= date("Y-m-d");
	$Sordersn	= "eBay";
	$pagesize	=20;//每页显示的数据条目数
	$mctime		= strtotime($nowtime);
	
	
	$compatabilityLevel = 551;
	$devID		= "cddef7a0-ded2-4135-bd11-62db8f6939ac";
	$appID		= "Survyc487-9ec7-4317-b443-41e7b9c5bdd";
	$certID		= "b68855dd-a8dc-4fd7-a22a-9a7fa109196f";
	$serverUrl	= "https://api.ebay.com/ws/api.dll";


	
	
	
	$cc			= date("Y-m-d H:i:s");
	$end		= date('Y-m-d',strtotime("$cc +0 days")).'T'.date('H:i:s',strtotime($cc));
	
	$vv				= "select distinct user  from ebay_user where  user ='chineon'";
	$vv				= $dbcon->execute($vv);
	$vv				= $dbcon->getResultArray($vv);

	
	for($j=0;$j<count($vv);$j++){
		
		$user				= $vv[$j]['user'];
		
		
		$ss							= "select * from ebay_config WHERE `ebay_user` ='$user' LIMIT 1";
		$ss							= $dbcon->execute($ss);
		$ss							= $dbcon->getResultArray($ss);
		$defaultstoreid				= $ss[0]['storeid'];
		$notesorderstatus			= $ss[0]['notesorderstatus'];
		$auditcompleteorderstatus	= $ss[0]['auditcompleteorderstatus'];
		$hackorerstatus				= $ss[0]['hackorer'];
		$_SESSION['user']			=  $user;
		
		
		$sql 		 = "select ebay_token,ebay_account from ebay_account where ebay_user='$user' and ebay_token != '' ";
		$sql		 = $dbcon->execute($sql);
		$sql		 = $dbcon->getResultArray($sql);
		
		
		for($i=0;$i<count($sql);$i++){
		
			$token		= $sql[$i]['ebay_token'];
			$account	= $sql[$i]['ebay_account'];
		
				$start		= date('Y-m-d H:i:s',strtotime("$cc -500 minutes"));
				$start		= date('Y-m-d',strtotime($start)).'T'.date('H:i:s',strtotime($start));		
				echo $start."---";
				echo $end."\n";
				echo "\n $i : start: $account\n";
			//	GetSellerTransactions($start,$end,$token,$account,$type=1,10);
			//	GetSellerTransactions02($start,$end,$token,$account);
			
		}
		GetOrderSiptype($user);
	}
	
	
	

	
	
	
	
	
	
	
	
	function GetOrderSiptype($user){
		
		global $dbcon,$notesorderstatus;
		
	
					$sql		= "select * from ebay_order as a where ebay_user='$user' and  ebay_status = '1' and (ebay_carrier = '' or ebay_carrier is null) ";
					$sql		= "select * from ebay_order as a where ebay_id = '298664' ";
					
					
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
							$mail				= $sql[$i]['ebay_usermail'];
							/*检查是否有hei名单*/
							$ebay_username				= $sql[$i]['ebay_username'];
							$vv			= "select mail from ebay_hackpeoles where mail ='$mail' or userid ='$ebay_userid' or ebay_username ='$ebay_username' ";
							$vv			= $dbcon->execute($vv);
							$vv			= $dbcon->getResultArray($vv);
							if(count($vv) >= 1){
								
								if($hackorer >= 1){
								$ss				= "update ebay_order set ebay_status = '$hackorer' where ebay_id = '$ebay_id' ";
								$dbcon->execute($ss);
								$notes				= '系统自动将此订单转入黑名单';
								addordernote($ebay_id,$notes);
							
							
								}
							}
							
														
							$ss					= "select * from ebay_currency where currency = '$ebay_currency' and user = '$user'";
							$ss					= $dbcon->execute($ss);
							$ss					= $dbcon->getResultArray($ss);
		
							$rates				= $ss[0]['rates']?$ss[0]['rates']:1;
							$ebay_total			= $ebay_total * $rates;
							// 将有留言订单转到有留言订单分类中去
							if($ebay_note != '' && $notesorderstatus >= 1){
							$ss				= "update ebay_order set ebay_status = '$notesorderstatus' where ebay_id = '$ebay_id' ";
							$dbcon->execute($ss);
							
								$notes				= '系统自动将此订单转入有留言订单分类中';
								addordernote($ebay_id,$notes);
								
							}
							/* 取得订单总得重量 */
							$totalweight			= 0;
							$goods_cost				= 0;
							$st	= "select sku,ebay_amount,ebay_id from ebay_orderdetail where ebay_ordersn='$ebay_ordersn'";
							$st = $dbcon->execute($st);
							$st	= $dbcon->getResultArray($st);
							$shipstatus				= 0;
							for($t=0;$t<count($st);$t++){
								$sku						=  $st[$t]['sku'];
								$ebay_amount				=  $st[$t]['ebay_amount'];
								
								$ebay_id2					=  $st[$t]['ebay_id'];
								$sku						=  $st[$t]['sku'];
								if($user == 'vipshen') GetCountrytosku($ebay_countryname,$sku,$ebay_id2);
								
								
								
								$ss							= "select goods_weight,ebay_packingmaterial from ebay_goods where  goods_sn='$sku' and ebay_user ='$user' ";
								$ss							= $dbcon->execute($ss);
								$ss							= $dbcon->getResultArray($ss);
								if(count($ss) == 0){
									$vv			= "select goods_sncombine from ebay_productscombine where ebay_user='$user' and goods_sn='$sku'";
									$vv			= $dbcon->execute($vv);
									$vv 	 	= $dbcon->getResultArray($vv);
									if(count($vv) > 0){
									$goods_sncombine	= $vv[0]['goods_sncombine'];
									$goods_sncombine    = explode(',',$goods_sncombine);	
									for($e=0;$e<count($goods_sncombine);$e++){
											$pline			= explode('*',$goods_sncombine[$e]);
											$goods_sn		= $pline[0];
											$goddscount     = $pline[1] * $ebay_amount;
											$ee			= "SELECT goods_weight,ebay_packingmaterial FROM ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
											$ee			= $dbcon->execute($ee);
											$ee 	 	= $dbcon->getResultArray($ee);
											
											$ebay_packingmaterial	= $ee[0]['ebay_packingmaterial'];
											$kk			= " select * from ebay_packingmaterial where model ='$ebay_packingmaterial' and ebay_user='$user' ";
											$kk			= $dbcon->execute($kk);
											$kk 	 	= $dbcon->getResultArray($kk);
											$wweight	= $kk[0]['weight'];
											
											
											$totalweight		+=  $ee[0]['goods_weight'] * $goddscount + $wweight;
									}	
									}	
								}else{
						
								
											$ebay_packingmaterial	= $ss[0]['ebay_packingmaterial'];
											$kk			= " select * from ebay_packingmaterial where model ='$ebay_packingmaterial' and ebay_user='$user' ";
											$kk			= $dbcon->execute($kk);
											$kk 	 	= $dbcon->getResultArray($kk);
											$wweight	= $kk[0]['weight'];
											
											$goods_weight		=  $ss[0]['goods_weight'] * $ebay_amount + $wweight;
											$totalweight		+= $goods_weight;
								
								
								}
								
							}
							
						
				
							
							
				
							$ss				= "select * from  ebay_carrier where (($ebay_total between min and max) and  ($totalweight between weightmin and weightmax))  and ebay_account like '%$ebay_account%' and ebay_user ='$user'  ";
							/* 增加国家的过虑条件 */
							$ss				.= " and ( encounts like '%$ebay_countryname%' or encounts like '%,any,%' )";
							/* 增加SKU的过虑条件 */
							$ss				.= " and ( skus like '%$sku%' or skus like '%any,%' )";
							$ss				.= " order by Priority";
							
							echo $ss.'<br>';
							
							$ss = $dbcon->execute($ss);
							$ss	= $dbcon->getResultArray($ss);
							if(count($ss) > 0){
							
								$name			= 	$ss[0]['name'];
								$id				= 	$ss[0]['id'];
								$orderstatus	=   $ss[0]['orderstatus'];
								
								
								
								$totalshipfee  	=	shipfeecalc($id,$totalweight,$ebay_countryname);
								
								$rr				= 	"update ebay_order set ebay_carrier='$name',orderweight='$totalweight',ordershipfee='$totalshipfee'  ";								
								if($orderstatus > 0 ) $rr				.=   " ,ebay_status  ='$orderstatus' ";
								$rr				.=   " where ebay_id = '$ebay_id'";
								echo $rr;
								
								
								
								$dbcon->execute($rr);
								
							}
						
							
						
						}
	
	
	
	
	}
	
	

	
	
	
	
	
	
	
	
					
	
	
	
						
						
						?>
                        