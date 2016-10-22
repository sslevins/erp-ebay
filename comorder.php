<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>

<?php

include "include/config.php";


	function GetOrderSiptype($user,$ebay_id){
		
		global $dbcon,$notesorderstatus;
	
						$sql		= "select * from ebay_order as a where ebay_ordersn = '$ebay_id' ";
						$sql	= $dbcon->execute($sql);
						$sql	= $dbcon->getResultArray($sql);
						
						
						$ebay_id		= $sql[0]['ebay_id'];
						
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
					
							
														
							$ss					= "select * from ebay_currency where currency = '$ebay_currency' and user = '$user'";
							$ss					= $dbcon->execute($ss);
							$ss					= $dbcon->getResultArray($ss);
		
							$rates				= $ss[0]['rates']?$ss[0]['rates']:1;
							$ebay_total			= $ebay_total * $rates;
						
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
								$rr				.=   " where ebay_id = '$ebay_id'";
								echo $rr;
								$dbcon->execute($rr);
								
							}
						
							
						
						}
	
	
	
	
	}
	
	

	echo "开始检查未处理中的订单，是否有相同ID，相同地址的订单<br>";
	
	$ebay_status = $_REQUEST['ostatus'];
	
	
	if($ebay_status == '2') die('条件不符合， 不允许在已经发货下面合并订单.');
	
	$sr		= "select * from ebay_order as a where ebay_user='$user' and ebay_combine!='1' and a.ebay_status='$ebay_status' and ($ebayacc)";
	$sr		= $dbcon->execute($sr);
	$sr		= $dbcon->getResultArray($sr);
	$comorderid	= '';
	$sstatus	= 0;
	
	
	for($e=0;$e<count($sr);$e++){
		
		$comorderid				= '';
		$firstorder				= $sr[$e]['ebay_ordersn'];
		$ebay_id				= $sr[$e]['ebay_id'];
		$ebay_userid			= $sr[$e]['ebay_userid'];
		$ebay_username			= mysql_escape_string($sr[$e]['ebay_username']);
		$ebay_street			= mysql_escape_string($sr[$e]['ebay_street']);
		
				
		$ebay_city				= mysql_escape_string($sr[$e]['ebay_city']);
		$ebay_state				= mysql_escape_string($sr[$e]['ebay_state']);
		$ebay_countryname		= $sr[$e]['ebay_countryname'];
		$ebay_account			= $sr[$e]['ebay_account'];
		$ebay_warehouse			= $sr[$e]['ebay_warehouse'];
		$totalprice				= 0;

		
		$ss				= "select * from ebay_order where ebay_id!='$ebay_id' and ebay_userid='$ebay_userid' and ebay_account='$ebay_account'  and ebay_combine ='0' and  ebay_status='$ebay_status' and ebay_username='$ebay_username' and  ebay_city='$ebay_city' and ebay_state='$ebay_state' and ebay_street='$ebay_street'  and ebay_user ='$user' ";
		
		if($ebay_warehouse > 0 ) $ss .= " and ebay_warehouse ='$ebay_warehouse' ";		
		$ss				= $dbcon->execute($ss);
		$ss				= $dbcon->getResultArray($ss);
		
		
		$comorderid			.= $ebay_id.",";
		
		
		if(count($ss) > 0){
				
				echo "<br>当前客户ID: {$ebay_userid} <br>";
			
				for($y=0;$y<count($ss); $y++){
					$aebay_id				= $ss[$y]['ebay_id'];
					$comorderid	.=$aebay_id.",";
				}
				$ordersn	= explode(",",$comorderid);
				$orders	= array();

				for($t=0;$t<count($ordersn);$t++){
					$sn		= $ordersn[$t];
					if($sn	!= ""){					
						$orders[]	= $sn;
					}		
				}
				$firstorder				= $orders[0];
				$sql					= "select * from ebay_order where ebay_id='$firstorder'";
				$sql					= $dbcon->execute($sql);
				$sql					= $dbcon->getResultArray($sql);
				$firstorder		    	=  $sql[0]['ebay_ordersn'];
				$ebay_notes				=  $sql[0]['ebay_note'];
				$ebay_noteb				=  $sql[0]['ebay_noteb'];
				
				$combineorder = "";
			//	echo "合并到当前订单号为：".$firstorder."    $url<br>";
				$totalprice	= 0;
				$totalship	= 0;
				for($i=1;$i<count($orders);$i++){
					$ordersn	= $orders[$i];
					$sql	= "select * from ebay_order where ebay_id='$ordersn'";
					$sql	= $dbcon->execute($sql);
					$sql	= $dbcon->getResultArray($sql);
					$sordersn		    	=  $sql[0]['ebay_ordersn'];
					$ebay_total		    	=  $sql[0]['ebay_total']?$sql[0]['ebay_total']:0;
					
					$ebay_shipfee		    =  $sql[0]['ebay_shipfee']?$sql[0]['ebay_shipfee']:0;
					$totalship				+= $ebay_shipfee;
					$totalprice				+= $ebay_total;
					
					
					$ebay_notes				.=  $sql[0]['ebay_note'];
					$ebay_noteb				.=   $sql[0]['ebay_noteb'];
					
					$sql	= "select * from ebay_orderdetail where ebay_ordersn='$sordersn'";
					$sql	= $dbcon->execute($sql);
					$sql	= $dbcon->getResultArray($sql);
					for($q=0;$q<count($sql);$q++){					
						$tname		= mysql_escape_string($sql[$q]['ebay_itemtitle']);
						
						$tprice		= $sql[$q]['ebay_itemprice']?$sql[$q]['ebay_itemprice']:"";
						$tqty		= $sql[$q]['ebay_amount']?$sql[$q]['ebay_amount']:"";	
						$tsku		= $sql[$q]['sku']?$sql[$q]['sku']:"";	
						$titemid	= $sql[$q]['ebay_itemid']?$sql[$q]['ebay_itemid']:"";
						$ebay_itemurl	= $sql[$q]['ebay_itemurl'];
						
						
						$attribute			= mysql_escape_string($sql[$q]['attribute']);



						$recordnumber	= $sql[$q]['recordnumber'];
						$ebay_tid	= $sql[$q]['ebay_tid'];
						$notes			= mysql_escape_string($sql[$q]['notes']);
						$ebay_shiptype	= $sql[$q]['ebay_shiptype'];
						$shipingfee	= $sql[$q]['shipingfee']?$sql[$q]['shipingfee']:"";
						
						$ebayfee		= $sql[$q]['FinalValueFee'];
						$paypalfee		= $sql[$q]['FeeOrCreditAmount'];
						$sq		 = "insert into ebay_orderdetail(ebay_ordersn,ebay_itemtitle,ebay_itemprice,ebay_amount,sku,ebay_itemid,ebay_itemurl,attribute,recordnumber,ebay_tid,notes,shipingfee,ebay_user,ebay_shiptype,FeeOrCreditAmount,FinalValueFee) values('$firstorder','$tname','$tprice','$tqty','$tsku','$titemid','$ebay_itemurl','$attribute','$recordnumber','$ebay_tid','$notes','$shipingfee','$user','$ebay_shiptype','$paypalfee','$ebayfee')";
						if($dbcon->execute($sq)){
						}else{
							echo "<font color=red>合并插入物品失败，请与管理员联系<br></font>";
							
							
							echo $sq;
							
						}
					}
					$usql	= "update ebay_order set ebay_combine='1',ebay_status='8888' where ebay_id='$ordersn'";
					
					echo "订单号  $ordersn  客户ID:{$ebay_userid}  合并成功<br>";
					
					if($dbcon->execute($usql)) {
						$combineorder	= $combineorder.$ordersn."##";
					}		
				}
				
				$ebay_notes		= str_rep($ebay_notes);
				
				
				if($combineorder != '' ){
					
					
						$usql	= "update ebay_order set ebay_combine='$combineorder',ebay_total=ebay_total+$totalprice,ebay_note = '$ebay_notes',ebay_noteb='$ebay_noteb',ebay_shipfee=ebay_shipfee+$totalship where ebay_ordersn='$firstorder' and ebay_user ='$user' ";



						
						$vv = "insert into ebay_orderslog(notes,operationuser,operationtime,ebay_id,types) values('$usql','$user','$mctime','$firstorder','88')";
						$dbcon->execute($vv);



				if($dbcon->execute($usql)){
				
				
					GetOrderSiptype($user,$firstorder);
					echo "以将以下订单号合并成功:<br><br>";
					echo $combineorder;
				}
				
				
				}
				
		}	
		
	}
	
	
	
	echo '<br> 检查完成';
	

	
?>

</html>
