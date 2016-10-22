<?php	
		function GetCountrytosku($countryname,$sku,$ebay_id,$ebay_amount){
			 
				global $dbcon,$user;
				$ss			 = "select * from ebay_skucountrynote where country='$countryname' and sku='$sku' and ebay_user='$user' ";
				$ss			 = $dbcon->execute($ss);
				$ss			 = $dbcon->getResultArray($ss);
				$note		 = $ss[0]['note'].$ebay_amount.' 个';
				if(count($ss) > 0 ){
				$updatesql	 = "update ebay_orderdetail set notes ='$note' where ebay_id='$ebay_id'";
				$dbcon->execute($updatesql);
				}		 
			 }
			 
		function GetPurchasePrice($goods_sn){
			global $dbcon, $user;
			
			/* 取得最新的采购价格 */
			$vvsql		= "select goods_cost from ebay_iostore as a join ebay_iostoredetail as b on a.io_ordersn	= b.io_ordersn	 where (a.type ='0' or a.type='2' or a.type ='99' or a.type ='98'  or a.type ='97' or a.type ='96' or a.type ='93') and b.goods_sn ='$goods_sn' order by    a.id desc  ";
			$vvsql	 = $dbcon->execute($vvsql);
			$vvsql	 = $dbcon->getResultArray($vvsql);
			$vvsqljs = count($vvsql);
			$lastpurchaseprice		= $vvsql[0]['goods_cost'];
			$lastnextpurchaseprice	= $vvsql[1]['goods_cost'];
			
			if($lastpurchaseprice > $lastnextpurchaseprice) $txtstr = "<font color=red>涨</font>";
			if($lastpurchaseprice == $lastnextpurchaseprice) $txtstr = "<font color=green>平</font>";
			if($lastpurchaseprice < $lastnextpurchaseprice) $txtstr = "<font color=gray>跌</font>";
			
			
			/* 取得最di采购价格 */
			
			$lowpurchaseprice		= $vvsql[$vvsqljs-1]['goods_cost'];
			/* 计算平均价 */
			$vvsql		= "select sum(goods_cost) as total from ebay_iostore as a join ebay_iostoredetail as b on a.io_ordersn	= b.io_ordersn	 where (a.type ='0' or a.type='2' or a.type ='99' or a.type ='98'  or a.type ='97' or a.type ='96' or a.type ='93') and b.goods_sn ='$goods_sn' order by    a.id desc  ";
			$vvsql	 = $dbcon->execute($vvsql);
			$vvsql	 = $dbcon->getResultArray($vvsql);
			
			$total	 = number_format($vvsql[0]['total'] / $vvsqljs,2);
			
			
			
			$dataarray				= array();
			$dataarray[0]			= $lastpurchaseprice;
			$dataarray[1]			= $lowpurchaseprice;
			$dataarray[2]			= $total;
			$dataarray[3]			= $txtstr;
			$dataarray[4]			= $lastnextpurchaseprice;
			return $dataarray;
		}
		
		/* 取得指定sku, 指定 仓库的产品当前数量 */
		function GetStockQtyBySku($storeid,$sku){
			global $dbcon, $user;
			$sql	= "select a.ebay_user,a.goods_cost,a.goods_unit,b.goods_count,b.goods_xx from ebay_goods as a  join ebay_onhandle as b on a.goods_id = b.goods_id where a.goods_sn ='$sku' and b.store_id ='$storeid'  and a.ebay_user ='$user' ";			
			
			$sql	=  $dbcon->execute($sql);
			$sql	=  $dbcon->getResultArray($sql);
			
			if(count($sql) == 0){
			$sql	= "select a.goods_cost,a.goods_unit from ebay_goods as a  where a.goods_sn ='$sku' and ebay_user ='$user' ";			
			
			$sql	=  $dbcon->execute($sql);
			$sql	=  $dbcon->getResultArray($sql);
			
			}
			
			
			
			$goods_count 		=  $sql[0]['goods_count'];
			$goods_xx 			=  $sql[0]['goods_xx'];
			$goods_unit 		=  $sql[0]['goods_unit'];
			$goods_cost 		=  $sql[0]['goods_cost'];
			
			$datarray		= array();
			$datarray[0]	= $goods_count;
			$datarray[1]	= $goods_xx;
			$datarray[2]	= $goods_unit;
			$datarray[3]	= $goods_cost;
			return $datarray;
			
		}		
		/* 获取采购数量
			@type 		string (Plan,Schedule,ForAcceptance,Aberrant)(计划，预定，待验收,异常)
			@sku		string
			@storeid	int
			return int
		*/
		function getPurchaseNumber($type,$sku,$storeid){
			global $dbcon, $user;
			
			/* 
			99  == 采购计划单
			
			93  == 预订中订单
			
			98  == 入库单列表
			
			97  == 财务审核
			
			96  == 质检审核
			
			95  == 异常入库单
			
			 */
			switch($type){
				case 'Plan':
					$status = ' a.type="99"';
					break;
				case 'Schedule':
					$status = ' a.type="93"';
					break;
				case 'ForAcceptance':
					$status = ' a.type in("98","97","96")';
					break;
				case 'Aberrant':
					$status = ' a.type ="95"';
					break;
				case 'all':
					$status = ' a.type in("98","97","96","99","93")';
					break;
			}
			$vvsql		= "select sum(b.goods_count) as count,sum(b.qty_01) as count2 from ebay_iostore as a join ebay_iostoredetail as b on a.io_ordersn	= b.io_ordersn	 where $status and b.goods_sn ='$sku' ";
			
		
			
			if($storeid>0){
				$vvsql .= " and a.io_warehouse='$storeid' ";
			}
			
			$vvsql	 = $dbcon->execute($vvsql);
			$vvsql	 = $dbcon->getResultArray($vvsql);
			if($vvsql[0]['count']){
				if($type=='Aberrant'){
					$count =  $vvsql[0]['count']-$vvsql[0]['count2'];
					return $count;
				}else{
					return $vvsql[0]['count'];
				}
			}else{
				return 0;
			}
		}
		/* 计算订单初步的利润 */
		
		function getOrderProfit($ebayid){
			global $dbcon;
			$vv				= "select ebay_currency,ebay_total,ebay_ordersn from ebay_order where ebay_id ='$ebayid' ";
			$vv				= $dbcon->execute($vv);
			$vv				= $dbcon->getResultArray($vv);
			$ebay_total 	= $vv[0]['ebay_total'];
			$ebay_currency  = $vv[0]['ebay_currency'];
			$ordersn	 	 = $vv[0]['ebay_ordersn'];
			$ss			= "select sum(FinalValueFee) as ebayfees,sum(FeeOrCreditAmount) as paypalfees from ebay_orderdetail where ebay_ordersn = '$ordersn'";
			$ss			=  $dbcon->execute($ss);
			$ss			=  $dbcon->getResultArray($ss);
			$ebayfees	= $ss[0]['ebayfees'];
			$paypalfees	= $ss[0]['paypalfees'];
			$profit		= $ebay_total - $ebayfees - $paypalfees;
			echo '总销售:'.$ebay_total.' 总ebay费用:'.$ebayfees.' 总paypal费用'.$paypalfees.'<br>';
			return $profit;
		}
		
		/* 记录订单操作日志 */
		function addordernote($ebayid,$notes){
			global $user,$dbcon,$mctime;
			$vv		= "insert into ebay_orderslog (operationuser,operationtime,notes,ebay_id) values('$user','$mctime','$notes','$ebayid')";
 			$dbcon->execute($vv);
		}
				/* 记录订单客服操作日志 */

			function addordernotesf($ebayid,$notes,$types){
			global $user,$dbcon,$mctime;
			$vv		= "insert into ebay_orderslog (operationuser,operationtime,notes,ebay_id,types) values('$user','$mctime','$notes','$ebayid','$types')";
 			$dbcon->execute($vv);
		}
		/* 取得订单的ID */
		function GetOrderID($ordersn){
			global $dbcon;
			$vv			= "select ebay_id from ebay_order where ebay_ordersn ='$ordersn' ";
			$vv			= $dbcon->execute($vv);
			$vv			= $dbcon->getResultArray($vv);
			$ebay_id 	= $vv[0]['ebay_id'];
			return $ebay_id;
		}
		
		/* 取得订单状态 */
		function GetOrderStatusV2($ebay_id){
			global $dbcon;
			$vv		= "select ebay_status from ebay_order where ebay_id ='$ebay_id' ";
			$vv		= $dbcon->execute($vv);
			$vv		= $dbcon->getResultArray($vv);
			$ebay_status = $vv[0]['ebay_status'];
			$returnstatus = '';
			if($ebay_status == '0'){
			$returnstatus	=  '未付款订单';
			}else if($ebay_status == '1'){
			$returnstatus = '待处理订单';
			}else if($ebay_status == '2'){
			$returnstatus =  '已经发货';
			}else{
			$rr		= "select name from ebay_topmenu where id='$ebay_status' ";
	
			
			$rr		= $dbcon->execute($rr);
			$rr		= $dbcon->getResultArray($rr);
			$returnstatus =  $rr[0]['name'];
			}
			return $returnstatus;
		}
		
		/* 取得订单状态对的名称 */
		function GetOrderStatusV2f($ebay_status){
			global $dbcon,$user;
			$returnstatus = '';
			if($ebay_status == '0'){
			$returnstatus	=  '未付款订单';
			}else if($ebay_status == '1'){
			$returnstatus = '待处理订单';
			}else if($ebay_status == '2'){
			$returnstatus =  '已经发货';
			}else{
			$rr		= "select name from ebay_topmenu where id='$ebay_status' and ebay_user ='$user' ";
			$rr		= $dbcon->execute($rr);
			$rr		= $dbcon->getResultArray($rr);
			$returnstatus =  $rr[0]['name'];
			}
			return $returnstatus;
		}
		
		
		
		function getProductsqty($start,$end,$goods_sn,$io_warehouse){
			global $dbcon,$user;
			/*

			$gsql			= "select  SUM( b.goods_count) as cc  from ebay_iostore as a join ebay_iostoredetail as b on a.io_ordersn = b.io_ordersn where b.goods_sn='$goods_sn' ";			$gsql		   .= "  and type ='1' ";
			if($start != '' && $end != '') $gsql .= " and (a.io_addtime	>'".strtotime($start)."' && a.io_addtime	<'".strtotime($end)."') ";
			if($io_warehouse > 0) $gsql .= " and a.io_warehouse ='$io_warehouse' ";
			$gsql			= $dbcon->execute($gsql);
			$gsql			= $dbcon->getResultArray($gsql);
			$qty1	=  $gsql[0]['cc']?$gsql[0]['cc']:0;
			*/
			
			/*
			单个SKU, 非组合SKU, 计算已经售出的数量
			*/
			$gsql			= "SELECT sum(b.ebay_amount) as qty FROM ebay_order AS a JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn WHERE sku =  '$goods_sn' and a.ebay_warehouse = '$io_warehouse' and a.ebay_combine!='1'";
			if($start != '' && $end != '') $gsql 			.= " and (a.ebay_paidtime	>=".strtotime($start)." and a.ebay_paidtime	<=".strtotime($end).")";
			
			
			
			$gsql			= $dbcon->execute($gsql);
			$gsql			= $dbcon->getResultArray($gsql);
			$qty1			=  $gsql[0]['qty']?$gsql[0]['qty']:0;
			
			/* 检查此sku 是否是组合产品, 包含当前子SKU 销售产品的信息的 */
			$vv				= "select goods_sn,goods_sncombine from ebay_productscombine where goods_sncombine	 like '%$goods_sn%' and ebay_user ='$user' ";
			$vv				= $dbcon->execute($vv);
			$vv				= $dbcon->getResultArray($vv);
			if(count($vv) > 0){
				for($i=0;$i<count($vv);$i++){
					$cgoods_sn			= $vv[$i]['goods_sn']; // => sold 中售出的物品编号，也就是组合产品编号
					$goods_sncombine	= $vv[$i]['goods_sncombine'];   // => 子sku号 和期对应的数量。
					$fxgoods_sncombine	= explode(',',$goods_sncombine);
					for($j=0; $j<count($fxgoods_sncombine);$j++){
						$fxlaberstr		= 'FF'.$fxgoods_sncombine[$j];
						if(strstr($fxlaberstr,$goods_sn)){							
							$fxlaberstr01	= explode('*',$fxgoods_sncombine[$j]);
							$fistamount		= $fxlaberstr01[1];							
							$gsql			= "SELECT sum(b.ebay_amount) as qty FROM ebay_order AS a JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn WHERE sku =  '$cgoods_sn'   and a.ebay_warehouse = '$io_warehouse' and ebay_combine!='1'";
							if($start != '' && $end != '') $gsql 			.= " and (a.ebay_paidtime	>=".strtotime($start)." and a.ebay_paidtime	<='".strtotime($end).")";
							$gsql			= $dbcon->execute($gsql);
							$gsql			= $dbcon->getResultArray($gsql);
							$usedqty1		=  $gsql[0]['qty']?$gsql[0]['qty']:0;							
							$qty1			+= $usedqty1 * $fistamount;					
						}					
					}			
				}		
			}
				

				
			
			
			return $qty1;
		}
		
		function getProductsqtyv3($start,$end,$goods_sn,$io_warehouse){
			global $dbcon,$user;
			
			$dataarray		= array();
			
			$gsql			= "SELECT sum(b.ebay_amount) as qty FROM ebay_order AS a JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn WHERE sku =  '$goods_sn' and a.ebay_warehouse = '$io_warehouse' and ebay_combine!='1'";
			if($start != '' && $end != '') $gsql 			.= " and (a.ebay_paidtime	>='".strtotime($start)."' and a.ebay_paidtime	<='".strtotime($end)."')";
			
			/*  销售频次*/
			
			$salesql		= "SELECT count(a.ebay_id) as cc FROM ebay_order AS a JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn WHERE sku =  '$goods_sn' and a.ebay_warehouse = '$io_warehouse' and ebay_combine!='1'";
			if($start != '' && $end != '') $salesql 			.= " and (a.ebay_paidtime	>='".strtotime($start)."' and a.ebay_paidtime	<='".strtotime($end)."')";
			
			$salesql		.= " Group by a.ebay_id ";
			$salesql			= $dbcon->execute($salesql);
			$salesql			= $dbcon->getResultArray($salesql);
			$salesql			= count($salesql);
			
			$gsql			= $dbcon->execute($gsql);
			$gsql			= $dbcon->getResultArray($gsql);
			$qty1			=  $gsql[0]['qty']?$gsql[0]['qty']:0;
			
			/* 检查此sku 是否是组合产品, 包含当前子SKU 销售产品的信息的 */
			$vv				= "select * from ebay_productscombine where goods_sncombine	 like '%$goods_sn%' and ebay_user ='$user' ";
			
			
			$vv				= $dbcon->execute($vv);
			$vv				= $dbcon->getResultArray($vv);
			if(count($vv) > 0){
				for($i=0;$i<count($vv);$i++){
					$cgoods_sn			= $vv[$i]['goods_sn']; // => sold 中售出的物品编号，也就是组合产品编号
					$goods_sncombine	= $vv[$i]['goods_sncombine'];   // => 子sku号 和期对应的数量。
					$fxgoods_sncombine	= explode(',',$goods_sncombine);
					
					for($j=0; $j<count($fxgoods_sncombine);$j++){
						
						$fxlaberstr		= 'FF'.$fxgoods_sncombine[$j];
						if(strstr($fxlaberstr,$goods_sn)){							
							$fxlaberstr01	= explode('*',$fxgoods_sncombine[$j]);
							$fistamount		= $fxlaberstr01[1];							
							$gsql			= "SELECT sum(b.ebay_amount) as qty FROM ebay_order AS a JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn WHERE sku =  '$cgoods_sn'   and a.ebay_warehouse = '$io_warehouse' and ebay_combine!='1'";
							if($start != '' && $end != '') $gsql 			.= " and (a.ebay_paidtime	>='".strtotime($start)."' and a.ebay_paidtime	<='".strtotime($end)."')";
							$gsql			= $dbcon->execute($gsql);
							$gsql			= $dbcon->getResultArray($gsql);
							$usedqty1		=  $gsql[0]['qty']?$gsql[0]['qty']:0;							
							$qty1			+= $usedqty1 * $fistamount;					
						}					
					}			
				}		
			}
			
			$dataarray[0]	= $salesql;
			$dataarray[1]	= $qty1;
			return $dataarray;
		}
		
		/* 建立出库单，并审核 */
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
			$shipfee		= $bnextweightamount * $kg + $vv[0]['ahandelfee2'];
			}else{
			$shipfee		= $vv[0]['ashipfee'] + $vv[0]['ahandlefee'] + $vv[0]['ahandelfee2'];
			
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
		
		function addoutorder($ebayid){
		
				global $dbcon,$user,$mctime;

				$returnstatus   = 0 ; // 0 表示出库失败，1，表示出库成功;

				$ss				= "select ebay_id,ebay_ordersn,ebay_userid,ebay_warehouse,ebay_account,ebay_currency from ebay_order where ebay_id = '$ebayid' ";
				$ss				= $dbcon->execute($ss);
				$ss				= $dbcon->getResultArray($ss);


				$isyy			= 0;
				$ebay_ordersn	= $ss[0]['ebay_ordersn'];
				$ebay_id		= $ss[0]['ebay_id'];
				$ebay_userid	= $ss[0]['ebay_userid'];
				$storeid		= $ss[0]['ebay_warehouse'];
				$ebay_account		= $ss[0]['ebay_account'];
				$ebay_currency		= $ss[0]['ebay_currency'];
				
				/*  start 验证整个订单中，对应的sku，是否在货品资料中存在 */
				$vv				= "select sku from ebay_orderdetail where ebay_ordersn = '$ebay_ordersn' ";
				$vv				= $dbcon->execute($vv);
				$vv				= $dbcon->getResultArray($vv);
				for($i=0;$i<count($vv);$i++){

					$sku		= $vv[$i]['sku'];
					$bb			= "SELECT goods_sn FROM ebay_goods where goods_sn='$sku' and ebay_user='$user'";
					$bb			= $dbcon->execute($bb);
					$bb 	 	= $dbcon->getResultArray($bb);
					
					if(count($bb) == 0){
						
						$rr			= "select * from ebay_productscombine where ebay_user='$user' and goods_sn='$sku'";
						$rr			= $dbcon->execute($rr);
						$rr 	 	= $dbcon->getResultArray($rr);
						
						if(count($rr) == 0){
							$isyy	= 1;
							echo "<br>订单编号:".$ebay_id."  客户ID:".$ebay_userid." -[<font color='#FF0000'>{$sku} : 未找到货品资料, 未能完成出库动作-0</font>]";
							return;
						}else{
							$goods_sncombine	= $rr[0]['goods_sncombine'];
							$goods_sncombine    = explode(',',$goods_sncombine);	
							for($e=0;$e<count($goods_sncombine);$e++){
											$pline			= explode('*',$goods_sncombine[$e]);
											$goods_sn		= $pline[0];
											
											$vv			= "SELECT goods_sn FROM ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
											
											echo $rr;
											$vv			= $dbcon->execute($vv);
											$vv 	 	= $dbcon->getResultArray($vv);
											if(count($vv) == 0){
												$isyy	= 1;
												echo "<br>订单编号:".$ebay_id."  客户ID:".$ebay_userid." -[<font color='#FF0000'>{$goods_sn} : 未找到货品资料, 未能完成出库动作-1</font>]";
												return;
											}
							}
							
						
						
						
						}
						
					}
				}
				
				/*  end */
				
				
				/* 检查订单是否设置了对应的仓库 */
				if($storeid <= 0){
				echo "<br>订单编号:".$ebay_id."  客户ID:".$ebay_userid." -[<font color='#FF0000'>未设置仓库</font>]";
				$isyy	= 1;	
				return;
				}
				
			
				if($isyy == 0){
					
					$ebay_ordersn	= $ss[0]['ebay_ordersn'];
					$in_warehouse	= $ss[0]['ebay_warehouse'];
					/* 查询订单默认出库类型 */
						$uusql		= "select * from ebay_storetype where ebay_user ='$user' and warehousetype =1 ";
						$uusql		= $dbcon->execute($uusql);
						$uusql		= $dbcon->getResultArray($uusql);
						$io_type	= $uusql[0]['id'];
					/* end */
					$io_ordersn	= "IO-".date('Y')."-".date('m')."-".date('d')."-".date("H").date('i').date('s'). mt_rand(100, 999).$ebayid;
					$sql	= "insert into ebay_iostore(ebay_account,partner,io_ordersn,io_addtime,io_warehouse,io_type,io_status,io_note,ebay_user,type,operationuser,io_user,sourceorder) values('$ebay_account','$partner','$io_ordersn','$mctime','$in_warehouse','$io_type','0','销售出库单，自动生成，对应销售编号:{$ebayid}','$user','1','$user','$user','$ebayid')";
					
					/* 检查此订单是否已经生成对应的出库单 */
					$ff				= "select * from ebay_iostore where sourceorder ='$ebayid' ";
					$ff				= $dbcon->execute($ff);
					$ff				= $dbcon->getResultArray($ff);
			
					if(count($ff) == 0 ){
						
						if($dbcon->execute($sql)){
				
							//echo '订单编号:'.$ebay_id.' 已经成功出库';
							$ss		= "select ebay_id,sku,ebay_amount,ebay_itemprice from ebay_orderdetail where ebay_ordersn='$ebay_ordersn'";
							$ss		= $dbcon->execute($ss);
							$ss		= $dbcon->getResultArray($ss);
							for($i=0;$i<count($ss);$i++){
					
								$iid				= $ss[$i]['ebay_id'];
								$goods_sn			= $ss[$i]['sku'];
								$ebay_amount		= $ss[$i]['ebay_amount'];
								$ebay_itemprice		= $ss[$i]['ebay_itemprice'];
								
								
								$sql				= "select *  from ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
								$sql				= $dbcon->execute($sql);
								$sql				= $dbcon->getResultArray($sql);
								if(count($sql)  == 0){
								
									$rr			= "select goods_sncombine from ebay_productscombine where ebay_user='$user' and goods_sn='$goods_sn'";
									$rr			= $dbcon->execute($rr);
									$rr 	 	= $dbcon->getResultArray($rr);
									
									if(count($rr) > 0){
									$goods_sncombine	= $rr[0]['goods_sncombine'];
									$goods_sncombine    = explode(',',$goods_sncombine);	
									for($e=0;$e<count($goods_sncombine);$e++){
											$pline			= explode('*',$goods_sncombine[$e]);
											$goods_sn		= $pline[0];
											$goddscount     = $pline[1] * $ebay_amount;
											$sql			= "select goods_name,goods_sn,goods_cost,goods_unit,goods_id from ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
											$sql			= $dbcon->execute($sql);
											$sql			= $dbcon->getResultArray($sql);
											$goods_name		= mysql_escape_string($sql[0]['goods_name']);
											$goods_sn		= $sql[0]['goods_sn'];
											$goods_price	= $sql[0]['goods_cost'];
											$goods_unit		= $sql[0]['goods_unit'];
											$goods_id		= $sql[0]['goods_id'];
											$sql		= "insert into ebay_iostoredetail(io_ordersn,goods_name,goods_sn,goods_cost,goods_unit,goods_count,goods_id,transactioncurrncy) values('$io_ordersn','$goods_name','$goods_sn','$ebay_itemprice','$goods_unit','$goddscount','$goods_id','$ebay_currency')";

						
											if($dbcon->execute($sql)){
												$status	.= " -[<font color='#33CC33'>操作记录: 产品添加成功</font>]";
												$sq			= "update ebay_onhandle set goods_count=goods_count-$goddscount where goods_sn='$goods_sn' and store_id='$in_warehouse'  and goods_id='$goods_id'";							
												$dbcon->execute($sq);
											}
									}
									}						
					}else{
						$goods_name		= mysql_escape_string($sql[0]['goods_name']);
						$goods_sn		= $sql[0]['goods_sn'];
						$goods_price	= $sql[0]['goods_cost'];
						$goods_unit		= $sql[0]['goods_unit'];
						$goods_id		= $sql[0]['goods_id'];
						$sql		= "insert into ebay_iostoredetail(io_ordersn,goods_name,goods_sn,goods_cost,goods_unit,goods_count,goods_id,transactioncurrncy) values('$io_ordersn','$goods_name','$goods_sn','$ebay_itemprice','$goods_unit','$ebay_amount','$goods_id','$ebay_currency')";
						if($dbcon->execute($sql)){
							$sq			= "update ebay_onhandle set goods_count=goods_count-$ebay_amount where goods_sn='$goods_sn' and store_id='$in_warehouse'  and goods_id='$goods_id'";
							$dbcon->execute($sq);
						}
					}
					
					
					
								$si			 = "update ebay_orderdetail set istrue='1' where ebay_id='$iid'";
								$dbcon->execute($si);
								echo '订单编号:'.$ebay_id.' 已经成功出库';
								
				}
				
				
				
				$esql			= "update ebay_iostore set io_status='1',io_audittime ='$mctime',audituser='$user' where io_ordersn='$io_ordersn'";
				$esql2			= "update ebay_iostoredetail set status ='B' where io_ordersn='$io_ordersn'";
				
				$dbcon->execute($esql);
				$dbcon->execute($esql2);
			}else{

				
				$returnstatus	= 0;


			}
			}else{
				echo '订单编号:'.$ebay_id.' 已经完成出库';
			}
			}
		}
		function addoutorderscan($ebayid){
		
				global $dbcon,$user,$mctime;

				$returnstatus   = 1 ; // 2 表示出库失败，1，表示出库成功;

				$ss				= "select ebay_id,ebay_ordersn,ebay_userid,ebay_warehouse,ebay_account,ebay_currency from ebay_order where ebay_id = '$ebayid' or ebay_tracknumber = '$ebayid'";
				$ss				= $dbcon->execute($ss);
				$ss				= $dbcon->getResultArray($ss);


				$isyy			= 0;
				$ebay_ordersn	= $ss[0]['ebay_ordersn'];
				$ebay_id		= $ss[0]['ebay_id'];
				$ebay_userid	= $ss[0]['ebay_userid'];
				$storeid		= $ss[0]['ebay_warehouse'];
				$ebay_account		= $ss[0]['ebay_account'];
				$ebay_currency		= $ss[0]['ebay_currency'];
				
				/*  start 验证整个订单中，对应的sku，是否在货品资料中存在 */
				$vv				= "select sku from ebay_orderdetail where ebay_ordersn = '$ebay_ordersn' ";
				$vv				= $dbcon->execute($vv);
				$vv				= $dbcon->getResultArray($vv);
				for($i=0;$i<count($vv);$i++){

					$sku		= $vv[$i]['sku'];
					$bb			= "SELECT goods_sn FROM ebay_goods where goods_sn='$sku' and ebay_user='$user'";
					$bb			= $dbcon->execute($bb);
					$bb 	 	= $dbcon->getResultArray($bb);
					
					if(count($bb) == 0){
						
						$rr			= "select * from ebay_productscombine where ebay_user='$user' and goods_sn='$sku'";
						$rr			= $dbcon->execute($rr);
						$rr 	 	= $dbcon->getResultArray($rr);
						
						if(count($rr) == 0){
							$isyy	= 1;
							$returnstatus   = 2 ;
						}else{
							$goods_sncombine	= $rr[0]['goods_sncombine'];
							$goods_sncombine    = explode(',',$goods_sncombine);	
							for($e=0;$e<count($goods_sncombine);$e++){
											$pline			= explode('*',$goods_sncombine[$e]);
											$goods_sn		= $pline[0];										
											$vv			= "SELECT goods_sn FROM ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
											$vv			= $dbcon->execute($vv);
											$vv 	 	= $dbcon->getResultArray($vv);
											if(count($vv) == 0){
												$isyy	= 1;
												$returnstatus   = 2 ;
											}
							}
							
						
						
						
						}
						
					}
				}
				
				/*  end */
				
				
				/* 检查订单是否设置了对应的仓库 */
				if($storeid <= 0){
					$isyy	= 1;
					$returnstatus   = 2 ;
				}
			
				if($isyy == 0){
					
					$ebay_ordersn	= $ss[0]['ebay_ordersn'];
					

					$in_warehouse	= $ss[0]['ebay_warehouse'];
					$io_ordersn	= "IO-".date('Y')."-".date('m')."-".date('d')."-".date("H").date('i').date('s'). mt_rand(100, 999).$ebayid;
					$sql	= "insert into ebay_iostore(ebay_account,partner,io_ordersn,io_addtime,io_warehouse,io_type,io_status,io_note,ebay_user,type,operationuser,io_user,sourceorder) values('$ebay_account','$partner','$io_ordersn','$mctime','$in_warehouse','112','0','销售出库单，自动生成，对应销售编号:{$ebayid}','$user','1','$user','$user','$ebayid')";
					
					/* 检查此订单是否已经生成对应的出库单 */
					$ff				= "select * from ebay_iostore where sourceorder ='$ebayid' ";
					$ff				= $dbcon->execute($ff);
					$ff				= $dbcon->getResultArray($ff);
			
					if(count($ff) == 0 ){
						
						if($dbcon->execute($sql)){
				
							//echo '订单编号:'.$ebay_id.' 已经成功出库';
							$ss		= "select ebay_id,sku,ebay_amount,ebay_itemprice from ebay_orderdetail where ebay_ordersn='$ebay_ordersn'";
							$ss		= $dbcon->execute($ss);
							$ss		= $dbcon->getResultArray($ss);
							for($i=0;$i<count($ss);$i++){
					
								$iid				= $ss[$i]['ebay_id'];
								$goods_sn			= $ss[$i]['sku'];
								$ebay_amount		= $ss[$i]['ebay_amount'];
								$ebay_itemprice		= $ss[$i]['ebay_itemprice'];
								
								
								$sql				= "select *  from ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
								
					
								
								$sql				= $dbcon->execute($sql);
								$sql				= $dbcon->getResultArray($sql);
								if(count($sql)  == 0){								
									$rr			= "select goods_sncombine from ebay_productscombine where ebay_user='$user' and goods_sn='$goods_sn'";
									$rr			= $dbcon->execute($rr);
									$rr 	 	= $dbcon->getResultArray($rr);
									
									if(count($rr) > 0){
									$goods_sncombine	= $rr[0]['goods_sncombine'];
									$goods_sncombine    = explode(',',$goods_sncombine);	
									for($e=0;$e<count($goods_sncombine);$e++){
											$pline			= explode('*',$goods_sncombine[$e]);
											$goods_sn		= $pline[0];
											$goddscount     = $pline[1] * $ebay_amount;
											$sql			= "select goods_name,goods_sn,goods_cost,goods_unit,goods_id from ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
											$sql			= $dbcon->execute($sql);
											$sql			= $dbcon->getResultArray($sql);
											$goods_name		= mysql_escape_string($sql[0]['goods_name']);
											$goods_sn		= $sql[0]['goods_sn'];
											$goods_price	= $sql[0]['goods_cost'];
											$goods_unit		= $sql[0]['goods_unit'];
											$goods_id		= $sql[0]['goods_id'];
											$sql		= "insert into ebay_iostoredetail(io_ordersn,goods_name,goods_sn,goods_cost,goods_unit,goods_count,goods_id,transactioncurrncy) values('$io_ordersn','$goods_name','$goods_sn','$ebay_itemprice','$goods_unit','$goddscount','$goods_id','$ebay_currency')";					
											if($dbcon->execute($sql)){
												$sq			= "update ebay_onhandle set goods_count=goods_count-$goddscount where goods_sn='$goods_sn' and store_id='$in_warehouse'  and goods_id='$goods_id'";						
												
												$dbcon->execute($sq);
											}
									}
									}						
					}else{
					
					
				
					
						$goods_name		= mysql_escape_string($sql[0]['goods_name']);
						$goods_sn		= $sql[0]['goods_sn'];
						$goods_price	= $sql[0]['goods_cost'];
						$goods_unit		= $sql[0]['goods_unit'];
						$goods_id		= $sql[0]['goods_id'];
						$sql		= "insert into ebay_iostoredetail(io_ordersn,goods_name,goods_sn,goods_cost,goods_unit,goods_count,goods_id,transactioncurrncy) values('$io_ordersn','$goods_name','$goods_sn','$ebay_itemprice','$goods_unit','$ebay_amount','$goods_id','$ebay_currency')";
						if($dbcon->execute($sql)){
							$sq			= "update ebay_onhandle set goods_count=goods_count-$ebay_amount where goods_sn='$goods_sn' and store_id='$in_warehouse'  and goods_id='$goods_id'";
							$dbcon->execute($sq);
						}
					}

					
						$si			 = "update ebay_orderdetail set istrue='1' where ebay_id='$iid'";
						$dbcon->execute($si);
								
				}
				
				
				
				$esql			= "update ebay_iostore set io_status='1',io_audittime ='$mctime',audituser='$user' where io_ordersn='$io_ordersn'";
				$esql2			= "update ebay_iostoredetail set status ='B' where io_ordersn='$io_ordersn'";
				
				$dbcon->execute($esql);
				$dbcon->execute($esql2);
			}else{

				$returnstatus	= 2;


			}
			}
			}
			return $returnstatus;
		}
	
		
		function GetSellingManagerSaleRecord(){
		
			
			 $verb = 'GetSellingManagerSaleRecord';
			 global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$dbcon;
			 
			 $compatabilityLevel	= 607;
			 
			 $token = 'AgAAAA**AQAAAA**aAAAAA**+Ss+Tw**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AEmYagDJeKpQudj6x9nY+seQ**GhMBAA**AAMAAA**mJuzZTbSUyWTRLHH1GiE8FicoMtUwgysxdTdoQ84vYBPNHV3ln489zpYtUecfsfRaN3G/sxILV3e4pswRP1HETEuSKjbmuwM3pbWrauS3GtUU6gnnH+BcAmtGDmvN6J82+7LZ2pw+bh/xKSsmVJ7pKF88uvUgHLrHt9xocZyZ+SfgFCGdeTUXAwUZ+0VLSkO3dN7hmodjnuU7Yw2wWJuOz4m+jWjLrvEEnODbC02Yr6z4urjTmRUwTgdZLtoe9GN1yKp62Hk37dnHVryVKmMYPN7ZCTtx/CtF/r4W8tgyVMOfDsE/GyyR2lWMwEEs+zw6cR3D5+8ABywrfK8GMycTRvnsFc4MS4KyfiXhoExPS4hldZZYUmm9bwY8GFOeK1ROaGm+qvwtHwn1GoktHbZ07m9wVhtQV+YT0v+osv1/Ko7RZ29EWtFHBctK4P+WzHzOKqQ82d7TBXolqGlaYJcShUPwMzQmuAl33Jexljo4Hbi626RdQIiKRU7w0iyRo/7TUi+hJCfw6y/BV5uKzIptXGYlNRql1q08pXtO+5p9snY+BqmgD2cRfnWn3Fh8OHEz1FseXItlN+dd9bFI8136eR8wPQw8aAyWSedgh8UzVnxOUFarCOb+gZQj2v8deSOZqLrj6537pUV2GhjsccI0Qe4Htk5EXo4ysCsYQqanmB28FHuj0NL8er/YwN+N9dvKOsfJipgEQhfiDtw6guHwb2rdc12A6+I+tNXLd7Bo8ZfpcUeDohWQJyBVcw7Jndo';
			 
			 $xmlRequest		= '<?xml version="1.0" encoding="utf-8"?>
<GetSellingManagerSaleRecordRequest xmlns="urn:ebay:apis:eBLBaseComponents">
  <RequesterCredentials>
    <eBayAuthToken>'.$token.'</eBayAuthToken>
  </RequesterCredentials>
  <Version>607</Version>
  <ItemID>120868042044</ItemID>
   <DetailLevel>ReturnAll</DetailLevel>		 
  <TransactionID>0</TransactionID>
</GetSellingManagerSaleRecordRequest>';
			 $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
			 $responseXml = $session->sendHttpRequest($xmlRequest);
			 if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';
			$data	= XML_unserialize($responseXml);
			print_r($data);
		
			
		
		}
		
		function addlogs($log_name,$log_operationtime,$log_orderid,$log_notes,$tname,$log_ebay_account,$start,$end,$type){
		
		global $dbcon,$nowtime;
		
		$ss		= "insert into system_log(log_name,log_operationtime,log_orderid,log_notes,ebay_user,currentime,log_ebay_account,starttime,endtime,type) values('$log_name','$log_operationtime','$log_orderid','$log_notes','$tname','$nowtime','$log_ebay_account','$start','$end','$type')";
		
		
		
		$dbcon->execute($ss);
		
		
		}
		function addlogsmessage($log_name,$log_operationtime,$log_orderid,$log_notes,$tname,$log_ebay_account,$start,$end,$type){
		
		global $dbcon,$nowtime;
		
		$ss		= "insert into system_logmessage(log_name,log_operationtime,log_orderid,log_notes,ebay_user,currentime,log_ebay_account,starttime,endtime,type) values('$log_name','$log_operationtime','$log_orderid','$log_notes','$tname','$nowtime','$log_ebay_account','$start','$end','$type')";
		
		
		
		$dbcon->execute($ss);
		
		
		}
		function getSaleProducts($start,$end,$goods_sn,$storeid){
			global $dbcon;
			
			

			
			
			$gsql			= "SELECT sum(b.ebay_amount) as qty FROM ebay_order AS a JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn WHERE sku =  '$goods_sn' and ( a.ebay_status !='0') and ebay_combine!='1'";
			$gsql .= " and (a.ebay_paidtime	>='".strtotime($end)."' && a.ebay_paidtime	<='".strtotime($start)."') and a.ebay_warehouse = '$storeid'";	

			
			
			
			$gsql			= $dbcon->execute($gsql);
			$gsql			= $dbcon->getResultArray($gsql);
			$qty1	=  $gsql[0]['qty']?$gsql[0]['qty']:0;
			return $qty1;
				
		}
		
		/* 已经占用库存 陈祥  Tel: 15051860453 2012-05-13 */
		function stockused($goods_sn,$storeid){
			global $dbcon,$user,$takeinventorysearch;
			 /* 正常情况下非组合产品 */
			$gsql			= "SELECT sum(b.ebay_amount) as qty FROM ebay_order AS a JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn WHERE sku =  '$goods_sn' and  b.istrue = '0' and a.ebay_warehouse = '$storeid' and ebay_combine!='1' and ebay_status !=2";
			
			if($takeinventorysearch != ''){
				$gsql			= "SELECT sum(b.ebay_amount) as qty FROM ebay_order AS a JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn WHERE sku =  '$goods_sn' and  b.istrue = '0' and a.ebay_warehouse = '$storeid' and ebay_combine!='1' and ($takeinventorysearch) ";
			}
			
			
			$gsql			= $dbcon->execute($gsql);
			$gsql			= $dbcon->getResultArray($gsql);
			$usedqty		=  $gsql[0]['qty']?$gsql[0]['qty']:0;
				

			
		
			 /* 检查组合产品是否包含此sku */	
				

				$vv				= "select goods_sn,goods_sncombine from ebay_productscombine where goods_sncombine	 like '%$goods_sn*%' and ebay_user ='$user' ";
				$vv				= $dbcon->execute($vv);
				$vv				= $dbcon->getResultArray($vv);
			
				
				for($i=0;$i<count($vv);$i++){
					$cgoods_sn			= $vv[$i]['goods_sn']; // => sold 中售出的物品编号，也就是组合产品编号
					$goods_sncombine	= $vv[$i]['goods_sncombine'];   // => 子sku号 和期对应的数量。
					$fxgoods_sncombine	= explode(',',$goods_sncombine);
					
					
					
					for($j=0; $j<count($fxgoods_sncombine);$j++){
						
						$fxlaberstr		= 'FF'.$fxgoods_sncombine[$j];
						if(strstr($fxlaberstr,$goods_sn)){
							
							$fxlaberstr01	= explode('*',$fxgoods_sncombine[$j]);
							
							$fistamount		= $fxlaberstr01[1];
							
							
							$gsql			= "SELECT sum(b.ebay_amount) as qty FROM ebay_order AS a JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn WHERE sku =  '$cgoods_sn' and  b.istrue = '0' and a.ebay_warehouse = '$storeid' and ebay_combine!='1' and ebay_status !=2";
							
							if($takeinventorysearch != ''){
								
								$gsql			= "SELECT sum(b.ebay_amount) as qty FROM ebay_order AS a JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn WHERE sku =  '$cgoods_sn' and  b.istrue = '0' and a.ebay_warehouse = '$storeid' and ebay_combine!='1' and ($takeinventorysearch)";
							}
							$gsql			= $dbcon->execute($gsql);
							$gsql			= $dbcon->getResultArray($gsql);
							$usedqty1		=  $gsql[0]['qty']?$gsql[0]['qty']:0;
							
							$usedqty		+= $usedqty1 * $fistamount;
							

						
						}
					
					
					}
					
					
				
				
				}
			
	

			
			
			return $usedqty;
		}
		
		/* 已订购库存, type =2 表示已经订购的订单， */
		function stockbookused($goods_sn,$storeid){
		
			global $dbcon;
			$gsql			= "SELECT sum(b.goods_count	) as qty FROM ebay_iostore AS a JOIN ebay_iostoredetail AS b ON a.io_ordersn	 = b.io_ordersn	 WHERE goods_sn	 =  '$goods_sn' and (a.io_status ='0' or a.io_status ='1' or a.io_status ='3') and type ='2' and a.io_warehouse='$storeid' ";
			$gsql			= $dbcon->execute($gsql);
			$gsql			= $dbcon->getResultArray($gsql);
			$usedqty		=  $gsql[0]['qty']?$gsql[0]['qty']:0;
			return $usedqty;
		}
		
		
		function ReviseMyMessages($token,$messageid,$type){
		
			
			 $verb = 'ReviseMyMessages';
			 global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$dbcon;
			 

			$xmlRequest		= '<?xml version="1.0" encoding="utf-8"?>
			<ReviseMyMessagesRequest xmlns="urn:ebay:apis:eBLBaseComponents">
  			<WarningLevel>High</WarningLevel>
  			<MessageIDs>
    		<MessageID>'.$messageid.'</MessageID>
  			</MessageIDs>';
			
		
			
			if($type == 'Read') $xmlRequest		.='<Read>true</Read>';
			if($type == 'UnRead') $xmlRequest		.='<Read>false</Read>';
			if($type == 'Flagged') $xmlRequest		.='<Read>true</Read>';
			if($type == 'Unflagged') $xmlRequest		.='<Read>false</Read>';
			
			$xmlRequest		.='
  			<RequesterCredentials>
    		<eBayAuthToken>'.$token.'</eBayAuthToken>
  			</RequesterCredentials>
  			<WarningLevel>High</WarningLevel>
			</ReviseMyMessagesRequest>
			';
			
			
		//	echo $xmlRequest;
			
			 $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
			 $responseXml = $session->sendHttpRequest($xmlRequest);
			 if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';
			$data	= XML_unserialize($responseXml);
		//	print_r($data);
			$ack	= $data['ReviseMyMessagesResponse'];

			$ack	= $ack['Ack'];
			return $ack;
			
			

		
		
		}
		
		function getmessageformatstr($ordersn,$content){
		
			global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$dbcon;
			
			
			 $ss			= "select * from ebay_order as a  where a.ebay_ordersn='$ordersn'";			 
			 $ss	= $dbcon->execute($ss);
			 $ss	= $dbcon->getResultArray($ss);
			 $cname			= $ss[0]['ebay_username'];
			 $street1		= $ss[0]['ebay_street'];
			 $street2 		= $ss[0]['ebay_street1']?@$ss[0]['ebay_street1']:"";
			 $city 			= $ss[0]['ebay_city'];
			 $state			= $ss[0]['ebay_state'];
			 $countryname 	= $ss[0]['ebay_countryname'];
			 $zip			= $ss[0]['ebay_postcode'];
			 $tel			= $ss[0]['ebay_phone']?$ss[0]['ebay_phone']:"";
			 $ordersn		= $ss[0]['ebay_ordersn'];
			 $account		= $ss[0]['ebay_account'];
			 $sendid		= $ss[0]['ebay_userid'];	
			 $ebay_ordersn		= $ss[0]['ebay_ordersn'];	
			 
			 $sql		= "select * from ebay_orderdetail as a where ebay_ordersn='$ebay_ordersn'";	

			$sql		= $dbcon->execute($sql);
			$sql		= $dbcon->getResultArray($sql);	
		
			$itmeid			= $sql[0]['ebay_itemid'];
			$title			= $sql[0]['ebay_itemtitle'];
			$ebay_amount			= $sql[0]['ebay_amount'];
			
		
		 
		 	 $addressline	= $cname." ".$street1." ".$street2." ".$city." ".$state." ".$zip." ".$countryname;
			 $ebay_markettime 	= $ss[0]['ShippedTime'];
			 if($ebay_markettime != '' && $ebay_markettime	!='0'){
		 	
				$ebay_markettime	= date('Y-m-d',$ebay_markettime);
			
			 }else{		 
		 	
				$ebay_markettime	= '';
			
			 }
		 
			 $ebay_paidtime 	= $ss[0]['ebay_paidtime'];
			 if($ebay_paidtime != '' && $ebay_paidtime	!='0'){
				
				$ebay_paidtime	= date('Y-m-d',$ebay_paidtime);
				
			 }else{		 
				
				$ebay_paidtime	= '';
				
			 }
		 
			 $ShippedTime 	= $ss[0]['ebay_markettime'];
			 
			 
			 if($ShippedTime != '' && $ShippedTime	!='0'){
				
				$ShippedTime	= date('Y-m-d',$ShippedTime);
				$ShippedTime7	= date('Y-m-d',strtotime("$ShippedTime +7days"));
				$ShippedTime9	= date('Y-m-d',strtotime("$ShippedTime +9days"));
				$ShippedTime14	= date('Y-m-d',strtotime("$ShippedTime +14days"));
				$ShippedTime21	= date('Y-m-d',strtotime("$ShippedTime +21days"));
				$ShippedTime30	= date('Y-m-d',strtotime("$ShippedTime +30days"));
				$content		= str_replace('{Post_Date}',$ShippedTime,$content);
				$content		= str_replace('{Post_Date_7}',$ShippedTime7,$content);
				$content		= str_replace('{Post_Date_9}',$ShippedTime9,$content);
				$content		= str_replace('{Post_Date_14}',$ShippedTime14,$content);
				$content		= str_replace('{Post_Date_21}',$ShippedTime21,$content);
				$content		= str_replace('{Post_Date_30}',$ShippedTime30,$content);
				
			 }else{		 
				
				$ShippedTime	= '';
				
			 }
		 
		
		  
		  
		 
		 $resendtime 	= $ss[0]['resendtime'];
		 if($resendtime != '' && $resendtime	!='0'){
		 	
			$resendtime	= date('Y-m-d',$resendtime);
			
			
		 }else{
		 $resendtime	='';
		 
		 
		 }
		 
		 $refundtime 	= $ss[0]['refundtime'];
		 if($refundtime != '' && $refundtime	!='0'){
		 	
			$refundtime	= date('Y-m-d',$refundtime);
			
			
		 }else{
		 	
			$refundtime	= '';
			
		 }
		 
		 $content		= str_replace('{RefundDate}',$refundtime,$content);
		 $content		= str_replace('{ReshipDate}',$resendtime,$content);
		 
		 
		 
		 
		
		 
		 
		 
		 $ebay_ptid 	= $ss[0]['ebay_ptid'];
		 $ebay_total 	= $ss[0]['ebay_total'];
		 $PayPalEmailAddress 	= $ss[0]['PayPalEmailAddress'];
		 $ebay_tracknumber	 	= $ss[0]['ebay_tracknumber'];
		 
		 
		 $currenttime	= date('Y-m-d');
		 $currenttime3	= date('Y-m-d',strtotime("$currenttime +3days"));
		 $currenttime5	= date('Y-m-d',strtotime("$currenttime +5days"));
		 $currenttime7	= date('Y-m-d',strtotime("$currenttime +7days"));
		 $currenttime10	= date('Y-m-d',strtotime("$currenttime +10days"));
	
		 
		 $content		= str_replace('{Today_10}',$currenttime10,$content);
		 $content		= str_replace('{Today_5}',$currenttime5,$content);
		 $content		= str_replace('{Today_7}',$currenttime7,$content);
		 $content		= str_replace('{Today_3}',$currenttime3,$content);
		 $content		= str_replace('{Track_Code}',$ebay_tracknumber,$content);
		 $content		= str_replace('{Today}',$currenttime,$content);
		 
		 $content		= str_replace('{Seller_Email}',$PayPalEmailAddress,$content);
		 $content		= str_replace('{Received_Amount}',$ebay_total,$content);
		 $content		= str_replace('{Paypal_Transaction_Id}',$ebay_ptid,$content);
		 $content		= str_replace('{Payment_Date}',$ebay_paidtime,$content);
		 $content		= str_replace('{Buyerid}',$sendid,$content);
		 $content		= str_replace('{Buyername}',$cname,$content);
		 $content		= str_replace('{Buyercountry}',$countryname,$content);
		 $content		= str_replace('{Sellerid}',$account,$content);
		 $content		= str_replace('{Itemnumber}',$itmeid,$content);
		 $content		= str_replace('{Itemtitle}',$title,$content);
		 $content		= str_replace('{Itemquantity}',$ebay_amount,$content);
		 $content		= str_replace('{Shipdate}',$ebay_markettime,$content);
		 $content		= str_replace('{Shippingaddress}',$addressline,$content);
		 $content		= str_replace("&","&amp;",$content);

		 
		 return $content;
		
		
		
		
		
		
		
		
		
		
		
		
		}
		
		
		function givefeedback($token,$ordersn){
		
		
			
			 $verb = 'CompleteSale';
			 global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$dbcon;
			 
			 $sql	= "select * from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn=b.ebay_ordersn where a.ebay_ordersn='$ordersn'";			
			 $sql	= $dbcon->execute($sql);
			 $sql	= $dbcon->getResultArray($sql);
		
			 
			 
			 $ebay_itemid		= $sql[0]['ebay_itemid'];
			 $ebay_tid			= $sql[0]['ebay_tid'];
			 $ebay_userid		= $sql[0]['ebay_userid'];
			 $ebay_orderid		= $sql[0]['ebay_orderid'];
			 
			 

			$xmlRequest		= '<?xml version="1.0" encoding="utf-8"?>
			<CompleteSaleRequest xmlns="urn:ebay:apis:eBLBaseComponents">
  			<WarningLevel>High</WarningLevel>
			
  			<FeedbackInfo>
   			<CommentType>Positive</CommentType>
    		<CommentText>Wonderful buyer, very fast payment.</CommentText>
    		<TargetUser>'.$ebay_userid.'</TargetUser>
  			</FeedbackInfo>
			<ItemID>'.$ebay_itemid.'</ItemID>';
			
			if($ebay_tid != ''){
			
			$xmlRequest .= '<TransactionID>'.$ebay_tid.'</TransactionID>';
			
			
			}
			
			if($ebay_orderid != ''){
			
			$xmlRequest .= '<OrderID>'.$ebay_orderid.'</OrderID>';
			
			
			}
			
			
			
			
			$xmlRequest .= '	
 			<RequesterCredentials>
    		<eBayAuthToken>'.$token.'</eBayAuthToken>
  			</RequesterCredentials>
  			</CompleteSaleRequest>';
			
			echo $xmlRequest;
			
die();

			
			 $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
			 $responseXml = $session->sendHttpRequest($xmlRequest);
			 if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';
			$data	= XML_unserialize($responseXml);
		//	print_r($data);
			
			$ack	= $data['CompleteSaleResponse'];

			$ack	= $ack['Ack'];
			echo $ack;
			
		
		
		
		
		}
		

		function addmessagetoparner($messagecontent,$userToken,$subject,$itemid,$userid){

			 $verb = 'AddMemberMessageAAQToPartner';

			 global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$dbcon;
			 $compatabilityLevel = 657;
			 

			$xmlRequest		= '<?xml version="1.0" encoding="utf-8"?>

			<AddMemberMessageAAQToPartnerRequest xmlns="urn:ebay:apis:eBLBaseComponents">

			<RequesterCredentials>

			<eBayAuthToken>'.$userToken.'</eBayAuthToken>

			</RequesterCredentials>

			<ItemID>'.$itemid.'</ItemID>
			<MemberMessage>
			<EmailCopyToSender>false</EmailCopyToSender>
			<Subject>'.$subject.'</Subject>
			<Body>'.$messagecontent.'</Body>

			<QuestionType>General</QuestionType>

			<RecipientID>'.$userid.'</RecipientID>

			</MemberMessage>

			</AddMemberMessageAAQToPartnerRequest>';

			

		

			

			 $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);

			 $responseXml = $session->sendHttpRequest($xmlRequest);		

			 if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';

			 $data=XML_unserialize($responseXml); 
			 $ack	= $data['AddMemberMessageAAQToPartnerResponse']['Ack'];

			 if($ack == 'Failure') $ack	= $data['AddMemberMessageAAQToPartnerResponse']['Errors']['LongMessage'];

			 return $ack;

			 

		}

			

		

		

		function GetFeedback($token,$account){

	

		 $verb = 'GetFeedback';
		 $pages			= 1;
		 $hasmore		= true;
		 
		 do{
		 
		 global $userToken,$devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID,$dbcon,$user;

		 $requestXmlBody = '<?xml version="1.0" encoding="utf-8"?> 
		 <GetFeedbackRequest xmlns="urn:ebay:apis:eBLBaseComponents"> 
		 <RequesterCredentials> 
		 <eBayAuthToken>'.$token.'</eBayAuthToken> 
		 </RequesterCredentials>
		 <Pagination>		 
		 <EntriesPerPage>200</EntriesPerPage>
		 <PageNumber>'.$pages.'</PageNumber>
		 </Pagination>
		 <FeedbackType>FeedbackReceived</FeedbackType>
		 <DetailLevel>ReturnAll</DetailLevel>		 
		 </GetFeedbackRequest>';
		 
		 
		 $session = new eBaySession($token, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
		 $responseXml = $session->sendHttpRequest($requestXmlBody);		
		 if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';
		 $data=XML_unserialize($responseXml); 
		 
		 
		 
		 $ack	= $data['GetFeedbackResponse']['Ack'];		 
		 $TotalNumberOfPages		= $data['GetFeedbackResponse']['PaginationResult']['TotalNumberOfPages'];
		 if($ack != "Success"){
			echo "<font color=red> loading falure \n\r </font>";
		 }
		 $feedback		= $data['GetFeedbackResponse']['FeedbackDetailArray']['FeedbackDetail'];
		 foreach($feedback as $li){
			$CommentingUser			= str_rep($li['CommentingUser']);
			$CommentingUserScore	= str_rep($li['CommentingUserScore']);
			$CommentText			= mysql_real_escape_string(str_rep($li['CommentText']));
			$CommentTime			= str_rep($li['CommentTime']);
			$feedbacktime			= strtotime($CommentTime);
			$CommentType			= str_rep($li['CommentType']);
			$ItemID					= str_rep($li['ItemID']);
			$FeedbackID				= str_rep($li['FeedbackID']);
			$TransactionID			= $li['TransactionID']?$li['TransactionID']:0;
			$ItemTitle				= str_rep($li['ItemTitle']);
			$currencyID				= str_rep($li['ItemPrice attr']['currencyID']);
			$ItemPrice				= str_rep($li['ItemPrice']);
			
			$ss			= "select ebay_ordersn from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn=b.ebay_ordersn where a.ebay_userid='$CommentingUser' and ebay_itemid='$ItemID' and b.ebay_tid ='$TransactionID'";
			$ss			= $dbcon->execute($ss);
			$ss			= $dbcon->getResultArray($ss);
			$sorder		= $ss[0]['ebay_ordersn'];
			$ss			= "update ebay_order set ebay_feedback='$CommentType' where ebay_ordersn='$sorder'";
			$dbcon->execute($ss);
			$sq		= "select FeedbackID from ebay_feedback where FeedbackID='$FeedbackID' and account ='$account'";
			$sq		= $dbcon->execute($sq);
			$sq		= $dbcon->getResultArray($sq);
			if(count($sq) == 0){
				$sql	= "INSERT INTO `ebay_feedback` (`CommentingUser` , `account` , `CommentingUserScore` , `CommentText` ,";
				$sql   .= "`CommentTime` , `CommentType` , `ItemID` , `FeedbackID` , `TransactionID` , `ItemTitle` , `currencyID` , `ItemPrice` , `status` ,`ebay_user`,`feedbacktime`)";
				$sql   .= "VALUES ('$CommentingUser', '$account', '$CommentingUserScore', '$CommentText', '$CommentTime', '$CommentType', ";
				$sql   .= "'$ItemID', '$FeedbackID', '$TransactionID', '$ItemTitle', '$currencyID', '$ItemPrice', '0','$user','$feedbacktime')";
				if($dbcon->execute($sql)){
					echo $CommentingUser." success \n\r ";
				}else{
					echo "<br><font color=red>Buyerid: $CommentingUser loading failure \n\r </font>";
				}
			}

		 }

		 
		 if($pages >= $TotalNumberOfPages){
		 $hasmore	= false;
		 }
		 $pages ++;
		 if($pages>=3){
		  break;
		  }
		}while($hasmore);
		
	

	

	

	}

		

		

		

		

		

		

		

		

		/* 取得ebay 的session ID */

		function GetSessionID($token){		

		global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel;
		$verb = 'GetSessionID';
		$requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>
		<GetSessionIDRequest xmlns="urn:ebay:apis:eBLBaseComponents">
		<RuName>Sure-Sure9f8a9-3061--gkpbas</RuName>
		</GetSessionIDRequest>
		';			
		$session = new eBaySession($token, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);   
		$responseXml = $session->sendHttpRequest($requestXmlBody);
		$responseDoc = new DomDocument();	
		$responseDoc->loadXML($responseXml);   
		$errors = $responseDoc->getElementsByTagName('Errors');
		$data=XML_unserialize($responseXml);
		$getdata = $data['GetSessionIDResponse']; 
		$sessionid = @$getdata['SessionID'];
		return $sessionid;
		}
		
		/* 标记发出的的函数 */
	
	function GiveUserFeedback($token,$ordersn,$type,$feedbackstr){
		global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$user,$dbcon,$mctime;
		$verb = 'CompleteSale';		
		$compatabilityLevel	= 705;
		
		
		$vv			= "select * from ebay_config where ebay_user ='$user' ";
		$sq			= $dbcon->execute($vv);
		$sq			= $dbcon->getResultArray($sq);
		$feedbackstring	= explode("&&",$sq[0]['feedbackstring']);
		$feedbackstring	= $feedbackstring[rand(0,count($feedbackstring))];
		
		
		
		$sq			= "select ebay_orderid,ebay_tid,ebay_account,ebay_tracknumber,ebay_carrier,ebay_userid from ebay_order where ebay_ordersn='$ordersn'";
		$sq			= $dbcon->execute($sq);
		$sq			= $dbcon->getResultArray($sq);
		$order		= $sq[0]['ebay_orderid']?$sq[0]['ebay_orderid']:"";
		$tid		= $sq[0]['ebay_tid']?$sq[0]['ebay_tid']:"0";	
		$ebay_account			= $sq[0]['ebay_account'];		
		$ebay_tracknumber		= $sq[0]['ebay_tracknumber'];
		$ebay_carrier			= $sq[0]['ebay_carrier'];
		$ebay_userid			= $sq[0]['ebay_userid'];
		$ss						= "select value from ebay_carrier where name='$ebay_carrier' and ebay_user='$user'";
		$ss						= $dbcon->execute($ss);
		$ss						= $dbcon->getResultArray($ss);
		$ebay_carrier			= $ss[0]['value'];
		$sq			= "SELECT DISTINCT ebay_ordersn, count( ebay_ordersn ) as cc,ebay_itemid,sku,ebay_amount,ebay_tid FROM `ebay_orderdetail` where ebay_ordersn='$ordersn' GROUP BY ebay_ordersn";
		$sq			= $dbcon->execute($sq);
		$sq			= $dbcon->getResultArray($sq);

		$total		= $sq[0]['cc'];


			$itemid			= $sq[0]['ebay_itemid'];
			$sku			= $sq[0]['sku'];
			$itemcount		= $sq[0]['ebay_amount'];
			$tid			= $sq[0]['ebay_tid']?$sq[0]['ebay_tid']:0;
			


			$requestXmlBody = '<?xml version="1.0" encoding="utf-8"?> 
							<CompleteSaleRequest xmlns="urn:ebay:apis:eBLBaseComponents"> 
							<RequesterCredentials> 
							<eBayAuthToken>'.$token.'</eBayAuthToken> 
							</RequesterCredentials>
							<FeedbackInfo>
							<CommentText>'.$feedbackstr.'</CommentText>
							<CommentType>Positive</CommentType>
							<TargetUser>'.$ebay_userid.'</TargetUser>
							</FeedbackInfo>
							<ItemID>'.$itemid.'</ItemID> 
							<TransactionID>'.$tid.'</TransactionID> 
							<OrderID>'.$ordersn.'</OrderID>';
							
			$requestXmlBody	.= '</CompleteSaleRequest>';

			
			
			$session = new eBaySession($token, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);   
			$responseXml = $session->sendHttpRequest($requestXmlBody);
			$responseDoc = new DomDocument();	
			$responseDoc->loadXML($responseXml);   
			$errors = $responseDoc->getElementsByTagName('Errors');	
			$data	= XML_unserialize($responseXml);

			$ack	= $data['CompleteSaleResponse'];
			$ack	= $ack['Ack'];
			if($ack == "Success"){
				echo "<br>订单号:$ordersn-- 评介成功";
			}
	}
	

	function CompleteSale($token,$ordersn,$type,$feedbackstr,$ebay_tracknumber,$ebay_carrier){
		
	
		global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$user,$dbcon,$mctime;
		$verb = 'CompleteSale';		
		$compatabilityLevel	= 705;
		
		
		if($user == 'silent'  ){
		 GiveUserFeedback($token,$ordersn,$type,$feedbackstr);
		}
		
		if($user == 'Hng'  ){
		 GiveUserFeedback($token,$ordersn,$type,$feedbackstr);
		}
		
		if($user == 'szvictor'  ){
		 GiveUserFeedback($token,$ordersn,$type,$feedbackstr);
		}
		
		if($user == 'm16'  ){
		 GiveUserFeedback($token,$ordersn,$type,$feedbackstr);
		}
		
		if($user == 'vip929'  ){
		 GiveUserFeedback($token,$ordersn,$type,$feedbackstr);
		}
		
		//需要考虑是一个产品,还是多个产品
		if($ordersn != ''){
		if($type == '0'){
		$sq			= "select ebay_orderid,ebay_tid,ebay_account,ebay_tracknumber,ebay_carrier,ebay_userid from ebay_order where ebay_ordersn='$ordersn'";
		$sq			= $dbcon->execute($sq);
		$sq			= $dbcon->getResultArray($sq);
		$order		= $sq[0]['ebay_orderid']?$sq[0]['ebay_orderid']:"";
		$tid		= $sq[0]['ebay_tid']?$sq[0]['ebay_tid']:"0";	
		$ebay_account			= $sq[0]['ebay_account'];		


		$ebay_userid			= $sq[0]['ebay_userid'];
		$ebay_orderid			= $sq[0]['ebay_orderid'];
		$ss						= "select value from ebay_carrier where name='$ebay_carrier' and ebay_user='$user'";
		$ss						= $dbcon->execute($ss);
		$ss						= $dbcon->getResultArray($ss);
		$ebay_carrier			= $ss[0]['value'];
		$sq			= "SELECT DISTINCT ebay_ordersn, count( ebay_ordersn ) as cc,ebay_itemid,sku,ebay_amount,ebay_tid FROM `ebay_orderdetail` where ebay_ordersn='$ordersn' GROUP BY ebay_ordersn";
		$sq			= $dbcon->execute($sq);
		$sq			= $dbcon->getResultArray($sq);

		$total		= $sq[0]['cc'];
		
		if($total	== "1"){

			$itemid			= $sq[0]['ebay_itemid'];
			
		
			
			$sku			= $sq[0]['sku'];
			$itemcount		= $sq[0]['ebay_amount'];
			$tid			= $sq[0]['ebay_tid']?$sq[0]['ebay_tid']:0;
			


			$requestXmlBody = '<?xml version="1.0" encoding="utf-8"?> 
							<CompleteSaleRequest xmlns="urn:ebay:apis:eBLBaseComponents"> 
							<RequesterCredentials> 
							<eBayAuthToken>'.$token.'</eBayAuthToken> 
							</RequesterCredentials>
							<ItemID>'.$itemid.'</ItemID> 
							<TransactionID>'.$tid.'</TransactionID> 
							<OrderID>'.$ebay_orderid.'</OrderID>
							<Paid>true</Paid>  
							<Shipped>true</Shipped>';			
			if($ebay_tracknumber != '' && $ebay_carrier != ''){
				$requestXmlBody	.= '<Shipment>
        		<ShipmentTrackingDetails>
      			<ShipmentTrackingNumber>'.$ebay_tracknumber.'</ShipmentTrackingNumber>
      			<ShippingCarrierUsed>'.$ebay_carrier.'</ShippingCarrierUsed>
    			</ShipmentTrackingDetails>
  				</Shipment>';
			}
			$requestXmlBody	.= '</CompleteSaleRequest>';
			
			
			
			
	
			if($itemid != ''){
			$session = new eBaySession($token, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);   
			$responseXml = $session->sendHttpRequest($requestXmlBody);
			$responseDoc = new DomDocument();	
			$responseDoc->loadXML($responseXml);   
			$errors = $responseDoc->getElementsByTagName('Errors');	
			$data	= XML_unserialize($responseXml);

			$ack	= $data['CompleteSaleResponse'];
			$ack	= $ack['Ack'];
			if($ack == "Success"){
				echo "<br>Ordersn:$ordersn--Item Number:$itemid  markt success \n\r";
				$sb		= "update ebay_order set ebay_markettime='$mctime',ShippedTime='$mctime' where ebay_ordersn='$ordersn'";
				$dbcon->execute($sb);
			}else{
				
				
				echo $data['CompleteSaleResponse']['Errors']['LongMessage'].' 客户id:'.$ebay_userid.'<br>';
			
			}
			
			}

		}else{
			$sq		= "select ebay_itemid,sku,ebay_amount,ebay_tid from ebay_orderdetail where ebay_ordersn='$ordersn'";
			$sq		= $dbcon->execute($sq);
			$sq		= $dbcon->getResultArray($sq);
			for($i=0;$i<count($sq);$i++){
			$itemid			= $sq[$i]['ebay_itemid'];
			
			
			
			
			
			$sku			= $sq[$i]['sku'];
			$itemcount		= $sq[$i]['ebay_amount'];
			$tid			= $sq[$i]['ebay_tid']?$sq[$i]['ebay_tid']:0;
			
			$requestXmlBody = '<?xml version="1.0" encoding="utf-8"?> 
							<CompleteSaleRequest xmlns="urn:ebay:apis:eBLBaseComponents"> 
							<RequesterCredentials> 
							<eBayAuthToken>'.$token.'</eBayAuthToken> 
							</RequesterCredentials> 
							<ItemID>'.$itemid.'</ItemID> 
							<TransactionID>'.$tid.'</TransactionID> 
							<OrderID>'.$ebay_orderid.'</OrderID>
							<Paid>true</Paid>  
							<Shipped>true</Shipped>';			
			if($ebay_tracknumber != '' && $ebay_carrier != ''){
				$requestXmlBody	.= '<Shipment>
        		<ShipmentTrackingDetails>
      			<ShipmentTrackingNumber>'.$ebay_tracknumber.'</ShipmentTrackingNumber>
      			<ShippingCarrierUsed>'.$ebay_carrier.'</ShippingCarrierUsed>
    			</ShipmentTrackingDetails>
  				</Shipment>';
			}
			
			if($itemid != '' ){
			$requestXmlBody	.= '</CompleteSaleRequest>';
			$session = new eBaySession($token, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);   
			$responseXml = $session->sendHttpRequest($requestXmlBody);
			$responseDoc = new DomDocument();	
			$responseDoc->loadXML($responseXml);   
			$errors = $responseDoc->getElementsByTagName('Errors');	
			$data	= XML_unserialize($responseXml);
			
			$ack	= $data['CompleteSaleResponse'];
			$ack	= $ack['Ack'];
			if($ack == "Success"){
				echo "<br>Ordersn:$ordersn--Item Number:$itemid  markt success \n\r";
				$sb		= "update ebay_order set  ebay_markettime='$mctime',ShippedTime='$mctime' where ebay_ordersn='$ordersn'";
				$dbcon->execute($sb);
				
			}
			}
			
			}

		

		}
		
		
		
		}else{
			addoutorder($ordersn);
		}
		
		
		
		
		

		}
		

	}

	

	

	/* eBay Token  */

	function GetToken($sessionid,$id){

		global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$user,$dbcon,$nowtime;
		$sessionid = $sessionid;		
		$verb = 'FetchToken';
		$requestxml	= '<?xml version="1.0" encoding="utf-8"?> 
		<FetchTokenRequest xmlns="urn:ebay:apis:eBLBaseComponents"> 
		<RequesterCredentials> 
		</RequesterCredentials> 
		<SessionID>'.$sessionid.'</SessionID> 
		</FetchTokenRequest>';	
		$session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);   
		$responseXml = $session->sendHttpRequest($requestxml);
		$responseDoc = new DomDocument();	
		$responseDoc->loadXML($responseXml);   
		$errors = $responseDoc->getElementsByTagName('Errors');	
		$data=XML_unserialize($responseXml);
		
		
	
		
		$getdata 	= $data['FetchTokenResponse'];
		$token   	= @$getdata['eBayAuthToken'];	  
		$expirtime	= @$getdata['HardExpirationTime'];	  
		$account	= $_REQUEST['ebayaccount'];
		$sqa        = "select * from ebay_account where ebay_account='$account' and ebay_user='$user'";
		$sqa		= $dbcon->query($sqa);
		$sqa		= $dbcon->num_rows($sqa);
		
		if($id >0 ) $sqa = 0;
		
		if($sqa==0){
		
			if($id >0){
			$sql 		 = "update ebay_account set ebay_token='$token',ebay_expirtime='$expirtime' where id='$id'";
			
			}else{
			$sql 		 = "insert into ebay_account(ebay_account,ebay_token,ebay_expirtime,ebay_addtime,ebay_user) values('$account'";
			$sql		.= ",'$token','$expirtime','$nowtime','$user')";
			
			}
			
			$result['expirtime']	= $expirtime;
			if($token !="" && $dbcon->execute($sql)){
					$result['status']		= "连接成功";
			}else{
			$result['status']		= "连接您的ebay帐户失败";
			}
		
		
		}else{
		$result['status']		= "帐户已经存，请重新添加";
		}
		$result['token']		= $token;
		$result['expirtime']	= $expirtime;
		return $result;
	}


	function getItem($token,$itemid,$picvalue){
		global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$user,$dbcon,$nowtime;
		$verb = 'GetItem';		
		$requestXmlBody	= '<?xml version="1.0" encoding="utf-8"?>
		<GetItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
		  <RequesterCredentials>
			<eBayAuthToken>'.$token.'</eBayAuthToken>
		  </RequesterCredentials>
		  <OutputSelector>Item.PayPalEmailAddress</OutputSelector>
		  <OutputSelector>Item.PictureDetails.GalleryURL</OutputSelector>
		  <OutputSelector>Item.Variations.Pictures</OutputSelector>
		  <ItemID>'.$itemid.'</ItemID>
		</GetItemRequest>';

		
		$session = new eBaySession($token, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);   
		$responseXml = $session->sendHttpRequest($requestXmlBody);
		$responseDoc = new DomDocument();	
		$responseDoc->loadXML($responseXml);   
		$errors = $responseDoc->getElementsByTagName('Errors');	
		$data	= XML_unserialize($responseXml);
		
		
		if($data['GetItemResponse']['Ack'] != 'Failure'){
		

		
		$resultpic			= '';
		
		
		$PayPalEmailAddress	= $data['GetItemResponse']['Item']['PayPalEmailAddress'];
		$PictureURL			= $data['GetItemResponse']['Item']['PictureDetails']['GalleryURL'];
		
		$Variations			= $data['GetItemResponse']['Item']['Variations'];

		$resultpic			= $PictureURL;
		
		if($picvalue != '' && $Variations != '' ){
			$picarray		= $data['GetItemResponse']['Item']['Variations']['Pictures'];
			$PictureURL		= '';
			if($picarray != ''){
					$PictureURL		= $data['GetItemResponse']['Item']['Variations']['Pictures']['VariationSpecificPictureSet'];
					for($i=0;$i<count($PictureURL);$i++){
						
						$VariationSpecificValue		= $PictureURL[$i]['VariationSpecificValue'];
						
						if($VariationSpecificValue == $picvalue){
							$PictureURL		= $PictureURL[$i]['PictureURL'];
						}
					}
			}
			
			if($PictureURL != '' ) $resultpic = $PictureURL;
			
			
		}
		
		}
		$data		= array();
		$data[0]	= $PayPalEmailAddress;
		$data[1]	= $resultpic;
		return $data;
	}

	/* 订单加载的程序 */
	
	function GetSellerTransactions($start,$end,$token,$account,$type,$id){
	
		global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$user,$dbcon,$nowtime,$Sordersn,$mctime,$defaultstoreid;
		$compatabilityLevel		=771;
		$start		= $start;
		$end		= $end;
		$verb = 'GetOrders';
		$pcount		= 1;
		
		$filepath	=   dirname(dirname(__FILE__));
		
		
		
		while(true){
		$requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>
		<GetOrdersRequest xmlns="urn:ebay:apis:eBLBaseComponents">
		<DetailLevel>ReturnAll</DetailLevel>
		<IncludeFinalValueFee>true</IncludeFinalValueFee>
		<OutputSelector>PaginationResult.TotalNumberOfPages</OutputSelector>
		<OutputSelector>PaginationResult.TotalNumberOfEntries</OutputSelector>
		<OutputSelector>OrderArray.Order.OrderID</OutputSelector>
		<OutputSelector>OrderArray.Order.BuyerCheckoutMessage</OutputSelector>
		<OutputSelector>OrderArray.Order.OrderStatus</OutputSelector>
		<OutputSelector>OrderArray.Order.AmountPaid</OutputSelector>
		<OutputSelector>OrderArray.Order.CheckoutStatus.eBayPaymentStatus</OutputSelector>
		<OutputSelector>OrderArray.Order.CheckoutStatus.Status</OutputSelector>
		<OutputSelector>OrderArray.Order.CheckoutStatus.Status</OutputSelector>
		<OutputSelector>OrderArray.Order.ShippingDetails.SellingManagerSalesRecordNumber</OutputSelector>
		<OutputSelector>OrderArray.Order.CreatedTime</OutputSelector>
		<OutputSelector>OrderArray.Order.ShippingAddress</OutputSelector>
		<OutputSelector>OrderArray.Order.ShippingServiceSelected</OutputSelector>
		<OutputSelector>OrderArray.Order.ExternalTransaction</OutputSelector>
		<OutputSelector>OrderArray.Order.BuyerUserID</OutputSelector>	 
		<OutputSelector>OrderArray.Order.PaidTime</OutputSelector>
		<OutputSelector>OrderArray.Order.ShippedTime</OutputSelector>	 
 		<OutputSelector>OrderArray.Order.TransactionArray.Transaction.Buyer.Email</OutputSelector>
		<OutputSelector>OrderArray.Order.TransactionArray.Transaction.ShippingDetails.SellingManagerSalesRecordNumber</OutputSelector>
		<OutputSelector>OrderArray.Order.TransactionArray.Transaction.CreatedDate</OutputSelector>
		<OutputSelector>OrderArray.Order.TransactionArray.Transaction.Item.ItemID</OutputSelector>
		<OutputSelector>OrderArray.Order.TransactionArray.Transaction.Item.Site</OutputSelector>
		<OutputSelector>OrderArray.Order.TransactionArray.Transaction.Item.Title</OutputSelector>
		<OutputSelector>OrderArray.Order.TransactionArray.Transaction.Item.SKU</OutputSelector>
		<OutputSelector>OrderArray.Order.TransactionArray.Transaction.QuantityPurchased</OutputSelector>
		<OutputSelector>OrderArray.Order.TransactionArray.Transaction.TransactionID</OutputSelector>
		<OutputSelector>OrderArray.Order.TransactionArray.Transaction.Variation</OutputSelector>
		<OutputSelector>OrderArray.Order.TransactionArray.Transaction.TransactionPrice</OutputSelector>
		<OutputSelector>OrderArray.Order.TransactionArray.Transaction.FinalValueFee</OutputSelector>
		<OutputSelector>OrderArray.Order.TransactionArray.Transaction.TransactionSiteID</OutputSelector>
		<OutputSelector>OrderArray.Order.TransactionArray.Transaction.ActualShippingCost</OutputSelector>
		<OutputSelector>OrderArray.Order.TransactionArray.Transaction.OrderLineItemID</OutputSelector>
		<RequesterCredentials>
    	<eBayAuthToken>'.$token.'</eBayAuthToken>
  		</RequesterCredentials>
  				 <ModTimeFrom>'.$start.'</ModTimeFrom>
			 <ModTimeTo>'.$end.'</ModTimeTo>
  		<OrderRole>Seller</OrderRole>
  		<OrderStatus>Completed</OrderStatus>
		<Pagination>
		<EntriesPerPage>99</EntriesPerPage>
		<PageNumber>'.$pcount.'</PageNumber>
		</Pagination>
		</GetOrdersRequest>';
		$session = new eBaySession($token, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
    	$responseXml = $session->sendHttpRequest($requestXmlBody);	
		

	
		
		$data=XML_unserialize($responseXml); 
		
		
		print_r($data);
		
		
		


	
	//	$ItemID		= '261053256300';
	//	$picvalue	= 'W522.B,White Strap';
	//	$data		= getItem($token,$ItemID,$picvalue);
	//	
	
	
		if($data['GetOrdersResponse']['OrderArray'] == '') break;
		$Trans	 						= $data['GetOrdersResponse']['OrderArray']['Order'];  
		$ReturnedOrderCountActual		= $data['GetOrdersResponse']['ReturnedOrderCountActual']; // 一共返回多少条记录
		$TotalNumberOfEntries			= $data['GetOrdersResponse']['PaginationResult']['TotalNumberOfEntries']; // 一共返回多少条记录
		$TotalNumberOfPages				= $data['GetOrdersResponse']['PaginationResult']['TotalNumberOfPages']; // 一共返回多少条记录
		echo 'ReturnedOrderCountActual='.$TotalNumberOfEntries."\n\r";
		if($TotalNumberOfEntries == 0){
			echo 'yes00oooo';
			break;
			
		}
		
		if($data['GetOrdersResponse']['OrderArray']['Order']['OrderID'] != '' ){
			$Trans								= array();
			$Trans[0] 							= $data['GetOrdersResponse']['OrderArray']['Order'];
		}
		
		
		if($TotalNumberOfEntries == 1){
			$Trans								= array();
			$Trans[0] 							= $data['GetOrdersResponse']['OrderArray']['Order'];
		
		}
		
		
		

		
		foreach((array)$Trans as $Transaction){
		
			
			$eBayPaymentStatus 		= $Transaction['CheckoutStatus']['eBayPaymentStatus'];	
			$CompleteStatus 		= $Transaction['CheckoutStatus']['Status'];		
			$AmountPaid				= $Transaction['AmountPaid'];
			$BuyerCheckoutMessage	= mysql_real_escape_string($Transaction['BuyerCheckoutMessage']);
			
			$OrderID				= $Transaction['OrderID'];
			$orderidary				= explode($OrderID,'-');
			$BuyerUserID			= $Transaction['BuyerUserID'];
			$OrderStatus			= $Transaction['OrderStatus'];
			$Currency				= $Transaction['AmountPaid attr']['currencyID'];
			$ShippingService		= $Transaction['ShippingServiceSelected']['ShippingService'];
			$ShippingServiceCost	= $Transaction['ShippingServiceSelected']['ShippingServiceCost'];
			$addrecordnumber		= $Transaction['ShippingDetails']['SellingManagerSalesRecordNumber'];
			$CreatedTime			= $Transaction['CreatedTime'];
			$Name					= mysql_real_escape_string($Transaction['ShippingAddress']['Name']);
			$Street1				= mysql_real_escape_string($Transaction['ShippingAddress']['Street1']);
			$Street2				= mysql_real_escape_string($Transaction['ShippingAddress']['Street2']);
			$CityName				= mysql_real_escape_string($Transaction['ShippingAddress']['CityName']);
			$StateOrProvince		= mysql_real_escape_string($Transaction['ShippingAddress']['StateOrProvince']);
			$Country				= mysql_real_escape_string($Transaction['ShippingAddress']['Country']);
			$CountryName			= mysql_real_escape_string($Transaction['ShippingAddress']['CountryName']);
			$Phone					= mysql_real_escape_string($Transaction['ShippingAddress']['Phone']);
			$PostalCode				= mysql_real_escape_string($Transaction['ShippingAddress']['PostalCode']);
			$Total					= $Transaction['Total'];
			$FeeOrCreditAmount		= $Transaction['ExternalTransaction']['FeeOrCreditAmount'];
			$ExternalTransactionID	= $Transaction['ExternalTransaction']['ExternalTransactionID'];
			$Email					= $Transaction['TransactionArray']['Transaction']['Buyer']['Email'];
			$Emails					= $Transaction['TransactionArray']['Transaction']['Buyer']['Email'];
			
			if($Emails == '' ) $Emails					= $Transaction['TransactionArray']['Transaction'][0]['Buyer']['Email'];
			
			$detailline				= $Transaction['TransactionArray']['Transaction'];
			
			$PaidTime				= strtotime($Transaction['PaidTime']);
			$ShippedTime			= strtotime($Transaction['ShippedTime']);
			$CreatedTime			= strtotime($Transaction['CreatedTime']);
			
			echo $ShippedTime.' & '.$BuyerUserID.'<br><br>';
			
			$orderstatus			= 0;
			if($PaidTime > 0){	$orderstatus		= 1;}
			if($ShippedTime >0) $orderstatus		= 2;
				
			if($orderstatus == '1' && $Name != '' ){
				echo $OrderID.' '.$BuyerUserID.' '.$currencyID.'<br>';
				/* 开始检查是否存在对应的订单记录 */
				$vv			= "select ebay_id from ebay_order where   ebay_account ='$account' and (recordnumber ='$addrecordnumber' or ebay_ordersn ='$OrderID') ";
				$vv			= $dbcon->execute($vv);
				$vv			= $dbcon->getResultArray($vv);
				
				if(count($vv) == 0 ){
					/* 添加订单主资料 */
					
					if($user == 'vipkevin' ) $order_no = getordersn();
					
					$sql			 = "INSERT INTO `ebay_order` (`ebay_paystatus`,`ebay_ordersn` ,`ebay_tid` ,`ebay_ptid` ,`ebay_orderid` ,";
					$sql			.= "`ebay_createdtime` ,`ebay_paidtime` ,`ebay_userid` ,`ebay_username` ,`ebay_usermail` ,`ebay_street` ,";
					$sql			.= "`ebay_street1` ,`ebay_city` ,`ebay_state` ,`ebay_couny` ,`ebay_countryname` ,`ebay_postcode` ,`ebay_phone`";
					$sql			.= " ,`ebay_currency` ,`ebay_total` ,`ebay_status`,`ebay_user`,`ebay_shipfee`,`ebay_account`,`recordnumber`,`ebay_addtime`,`ebay_note`,`ebay_site`,`eBayPaymentStatus`,`PayPalEmailAddress`,`ShippedTime`,`RefundAmount`,`ebay_warehouse`,`order_no`)VALUES ('$CompleteStatus','$OrderID', '$tid' , '$ExternalTransactionID' , '$OrderID' , '$CreatedTime' , '$PaidTime' , '$BuyerUserID' ,";
					$sql			.= " '$Name' , '$Emails' , '$Street1' , '$Street2' , '$CityName','$StateOrProvince' , '$Country' , '$CountryName' , '$PostalCode' , '$Phone' , '$Currency' , '$AmountPaid' , '$orderstatus','$user','$ShippingServiceCost','$account','$addrecordnumber','$mctime','$BuyerCheckoutMessage','$site','$eBayPaymentStatus','$PayPalEmailAddress','$ShippedTime','$RefundAmount','$defaultstoreid','$order_no')";
					if($dbcon->execute($sql)){
					if($Email != ''){
						$detailline		=  array();
						$detailline[0]		=  $Transaction['TransactionArray']['Transaction'];
					}
					
					
					$PayPalEmailAddress		= '';
					
					foreach((array)$detailline as $dline){
							$Email							= $dline['Buyer']['Email'];
							$SellingManagerSalesRecordNumber= $dline['ShippingDetails']['SellingManagerSalesRecordNumber'];
							$CreatedDate					= $dline['CreatedDate'];
							$ItemID							= $dline['Item']['ItemID'];
							$Site							= $dline['Item']['Site'];
							$Title							= mysql_real_escape_string($dline['Item']['Title']);
							$SKU							= $dline['Item']['SKU'];
							
							$arrribute		= '';
							if($dline['Variation'] != ''){
							$Title							= mysql_real_escape_string($dline['Variation']['VariationTitle']);
							$SKU							= mysql_real_escape_string($dline['Variation']['SKU']);
							
							$picvalue						= '';
							
							
							
						
							
							$aname			= $dline['Variation']['VariationSpecifics']['NameValueList']['Name'];
							$avalue			= $dline['Variation']['VariationSpecifics']['NameValueList']['Value'];
							
							$picvalue		= $avalue;
							
							$Variation		= $dline['Variation'];
							if($aname == ''){
								for($e=0;$e<count($Variation);$e++){
									$aname			= $dline['Variation']['VariationSpecifics']['NameValueList'][$e]['Name'];
									$avalue			= $dline['Variation']['VariationSpecifics']['NameValueList'][$e]['Value'];
									$picvalue		= $avalue;
									$arrribute	.= $avalue;
								}
							}else{
								$arrribute	= $avalue;
							}
						
							
							}
							$QuantityPurchased				= $dline['QuantityPurchased'];
							$TransactionID					= $dline['TransactionID'];
							$TransactionPrice				= $dline['TransactionPrice'];
							$FinalValueFee					= $dline['FinalValueFee'];
							$ActualShippingCost				= $dline['ActualShippingCost'];
							$OrderLineItemID				= $dline['OrderLineItemID'];
							$bb			= "select ebay_id from ebay_orderdetail where recordnumber ='$SellingManagerSalesRecordNumber' and ebay_account ='$account'";
							$bb			= $dbcon->execute($bb);
							$bb			= $dbcon->getResultArray($bb);
							if(count($bb) == 0 ){
									
									$data		= getItem($token,$ItemID,$picvalue);
									$arrribute	= mysql_real_escape_string($arrribute);
									
									
									
									$PayPalEmailAddress	= $data[0];
									$pic				= $data[1];
									
									if($user == 'test') $SKU	= substr($SKU,1);

									$esql	 = "INSERT INTO `ebay_orderdetail` (`ebay_ordersn` ,`ebay_itemid` ,`ebay_itemtitle` ,`ebay_itemprice` ,";
									$esql    .= "`ebay_amount` ,`ebay_createdtime` ,`ebay_shiptype` ,`ebay_user`,`sku`,`shipingfee`,`ebay_account`,`addtime`,`ebay_itemurl`,`ebay_site`,`recordnumber`,`storeid`,`ListingType`,`ebay_tid`,`FeeOrCreditAmount`,`FinalValueFee`,`attribute`,`notes`,`OrderLineItemID`,`PayPalEmailAddress`)VALUES ('$OrderID', '$ItemID' , '$Title' , '$TransactionPrice' , '$QuantityPurchased'";
									$esql	.= " , '$ctime' , '$ShippingService' , '$user','$SKU','$ActualShippingCost','$account','$mctime','$pic','$Site','$SellingManagerSalesRecordNumber','','$ListingType','$TransactionID','$FeeOrCreditAmount','$FinalValueFee','$arrribute','','$OrderLineItemID','$PayPalEmailAddress')";	
									
									
									
							
									
									if($dbcon->execute($esql)){
									echo '添加成功';
									}else{
									echo '添加失败，请与电话: 15051860453 联系';
									echo $esql;
									}	
							
							}else{
							
								
								echo '已经存在';
								
							
							}
					}
					
					/* 产品添加结束，验证PP地址 */
					
					if(strlen($ExternalTransactionID) >= 8 && ($user =='vip924' ||  $user =='survy' ||  $user =='feifei' ||  $user =='manwei' ) ){
						$nvpStr						="&TRANSACTIONID=$ExternalTransactionID";
						$details	 				= call_ebay("gettransactionDetails",$nvpStr,$PayPalEmailAddress);
						
					
						
						$COUNTRYCODE				= str_rep($details['COUNTRYCODE']);
						$SHIPTONAME					= str_rep($details['SHIPTONAME']);
						$SHIPTOSTREET				= str_rep($details['SHIPTOSTREET']);
						$SHIPTOSTREET2				= str_rep($details['SHIPTOSTREET2']);
						$SHIPTOCITY					= str_rep($details['SHIPTOCITY']);
						$SHIPTOSTATE				= str_rep($details['SHIPTOSTATE']);
						$SHIPTOCOUNTRYCODE			= str_rep($details['SHIPTOCOUNTRYCODE']);
						$SHIPTOCOUNTRYNAME			= str_rep($details['SHIPTOCOUNTRYNAME']);
						$SHIPTOZIP					= str_rep($details['SHIPTOZIP']);
						$Custom_Paypalemailaddress					= str_rep($details['EMAIL']);
						
						if($SHIPTONAME !=''){
							$sy	= "update ebay_order set ebay_username='$SHIPTONAME',ebay_street='$SHIPTOSTREET',ebay_street1='$SHIPTOSTREET2',ebay_city='$SHIPTOCITY',ebay_state='$SHIPTOSTATE',ebay_countryname='$SHIPTOCOUNTRYNAME',ebay_postcode='$SHIPTOZIP',Custom_Paypalemailaddress='$Custom_Paypalemailaddress' where ebay_ptid='$ExternalTransactionID'";
							$dbcon->execute($sy);
						}
					}
					
					}else{
					
						echo '添加失败';
						echo $sql;
						
					}
					
				}else{
					echo $BuyerUserID.' '.$PaidTime.' 已经存在';
				}
				
				
			}
		
		}
		
		
		
		
		if($pcount >= $TotalNumberOfPages){
		echo '退出了';
		 break;
		 }
		 
		 $pcount	++;
		 
		 
		
		}
	}
	

	

	

	function GetSellerTransactions02($start,$end,$token,$account,$type,$id){
		global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$user,$dbcon,$nowtime,$Sordersn,$mctime,$defaultstoreid;
		$compatabilityLevel = 741;
		$start		= $start;
		$end		= $end;
		$verb = 'GetSellerTransactions';
		$pcount		= 1;
		$hasmore	= '';
		$errors		= 1;
		
		do{
		$requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>
		<GetSellerTransactionsRequest xmlns="urn:ebay:apis:eBLBaseComponents">
		  <RequesterCredentials>
			<eBayAuthToken>'.$token.'</eBayAuthToken>
		  </RequesterCredentials>  
		     <DetailLevel>ReturnAll</DetailLevel>
		  <OutputSelector>TransactionArray.Transaction.Variation.SKU</OutputSelector>
		  <OutputSelector>TransactionArray.Transaction.Variat
		  ion.VariationSpecifics</OutputSelector>
		  <OutputSelector>PaginationResult</OutputSelector>
		  <OutputSelector>TransactionArray.Transaction.AmountPaid</OutputSelector>
		  <OutputSelector>TransactionArray.Transaction.Status.LastTimeModified</OutputSelector>
		  <OutputSelector>TransactionArray.Transaction.Status.eBayPaymentStatus</OutputSelector>
		  <OutputSelector>TransactionArray.Transaction.Status.CompleteStatus</OutputSelector>
		  <OutputSelector>TransactionArray.Transaction.PayPalEmailAddress</OutputSelector>
		  <OutputSelector>TransactionArray.Transaction.ExternalTransaction.ExternalTransactionID</OutputSelector>
		  <OutputSelector>TransactionArray.Transaction.ExternalTransaction.FeeOrCreditAmount</OutputSelector>
		  <OutputSelector>TransactionArray.Transaction.ShippingDetails.SellingManagerSalesRecordNumber</OutputSelector>
		  <OutputSelector>TransactionArray.Transaction.ShippingDetails.ShippingType</OutputSelector> 
		  <OutputSelector>TransactionArray.Transaction.TransactionID</OutputSelector> 
		  <OutputSelector>TransactionArray.Transaction.ContainingOrder.OrderID</OutputSelector>
		  <OutputSelector>TransactionArray.Transaction.ContainingOrder.ShippingDetails.SellingManagerSalesRecordNumber</OutputSelector> 
		  <OutputSelector>TransactionArray.Transaction.AmountPaid</OutputSelector>
		   <OutputSelector>TransactionArray.Transaction.FinalValueFee</OutputSelector>
		  <OutputSelector>TransactionArray.Transaction.Buyer.BuyerInfo</OutputSelector> 
		  <OutputSelector>TransactionArray.Transaction.Buyer.UserID</OutputSelector> 
		  <OutputSelector>TransactionArray.Transaction.Buyer.Email</OutputSelector> 
		  <OutputSelector>TransactionArray.Transaction.BuyerCheckoutMessage</OutputSelector> 
		  <OutputSelector>TransactionArray.Transaction.ShippingServiceSelected.ShippingService</OutputSelector>
		  <OutputSelector>TransactionArray.Transaction.ShippingServiceSelected.ShippingServiceCost</OutputSelector>
		  <OutputSelector>TransactionArray.Transaction.ShippedTime</OutputSelector>
		  <OutputSelector>TransactionArray.Transaction.CreatedDate</OutputSelector>
		  <OutputSelector>TransactionArray.Transaction.PaidTime</OutputSelector>
		  <OutputSelector>TransactionArray.Transaction.QuantityPurchased</OutputSelector>
		  <OutputSelector>TransactionArray.Transaction.SellingStatus.CurrentPrice</OutputSelector>
		  <OutputSelector>TransactionArray.Transaction.ExternalTransaction.ExternalTransactionID</OutputSelector>
		  <OutputSelector>TransactionArray.Transaction.Item.Currency</OutputSelector>
		  <OutputSelector>TransactionArray.Transaction.Item.ItemID</OutputSelector>
		  <OutputSelector>TransactionArray.Transaction.Item.Title</OutputSelector>
		  <OutputSelector>TransactionArray.Transaction.Item.Site</OutputSelector>
		  <OutputSelector>TransactionArray.Transaction.Item.SKU</OutputSelector>
		  <OutputSelector>TransactionArray.Transaction.Item.ListingType</OutputSelector>
		  <OutputSelector>TransactionArray.Transaction.Item.SellingStatus.CurrentPrice.currencyID</OutputSelector>
		  <OutputSelector>HasMoreTransactions</OutputSelector>
		  <OutputSelector>ReturnedTransactionCountActual</OutputSelector>
		  			 <ModTimeFrom>'.$start.'</ModTimeFrom>
			 <ModTimeTo>'.$end.'</ModTimeTo>
			  <Pagination>
				<EntriesPerPage>199</EntriesPerPage>
				<PageNumber>'.$pcount.'</PageNumber>
			  </Pagination>
				  <IncludeFinalValueFee>true</IncludeFinalValueFee>
			  <IncludeContainingOrder>true</IncludeContainingOrder>
		</GetSellerTransactionsRequest>';
		$session = new eBaySession($token, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
    	$responseXml = $session->sendHttpRequest($requestXmlBody);	
		$data=XML_unserialize($responseXml); 




		
		
		$getorder 						= $data['GetSellerTransactionsResponse'];  
		$TotalNumberOfPages	 							= @$getorder['PaginationResult']['TotalNumberOfPages'];
		$TotalNumberOfEntries	 						= @$getorder['PaginationResult']['TotalNumberOfEntries'];
		$hasmore 						= @$getorder['HasMoreTransactions'];
		$strline			= "".$TotalNumberOfPages.' /'.$TotalNumberOfEntries;
		$Ack	 						= @$getorder['Ack'];
		echo '\tRequest: '.$pcount.' pages,'." Total pages:".$TotalNumberOfPages.' Total records'.$TotalNumberOfEntries.' sys status:'.$Ack."\n\r";
		if($id == '' && $type == '1'){
			if($hasmore == '' || $Ack == '' ){
			$ss			= "insert into errors_ack(ebay_account,starttime,endtime,status,notes) values('$account','$start','$end','0','Ack False')";			$dbcon->execute($ss);
			}
		}
		if($id > 0 ){
		if($Ack == 'Success'){
			$gg		= "update errors_ack set status = 1 where id='$id' ";
		}else{
		
			$gg		= "update errors_ack set status = 0 where id='$id' ";
		}
		$dbcon->execute($gg);
		echo $gg.'<br>';
		}
		/**/
		//$log_name	 		= '';
		//$log_operationtime  = $mctime;
		//$log_notes	 	    = $account.',第'.$pcount.'页'.$strline.' Ack='.$Ack;
		//$tname			    = $user;
		//addlogs($log_name,$log_operationtime,$log_orderid,$log_notes,$tname,$account,$start,$end,$type);
		/**/
		$Trans							= @$getorder['TransactionArray']['Transaction'];
		$ReturnedTransactionCountActual = @$getorder['ReturnedTransactionCountActual'];
		
		$o = 0;
		
		
		if($ReturnedTransactionCountActual == 1){
			
			$Trans								= array();
			$Trans[0] 							= $getorder['TransactionArray']['Transaction'];
		}	

			foreach((array)$Trans as $Transaction){
				$recordnumber		= $Transaction['ShippingDetails']['SellingManagerSalesRecordNumber'];
				$LastTimeModified 	= strtotime($Transaction['Status']['LastTimeModified']);			
				$eBayPaymentStatus 	= $Transaction['Status']['eBayPaymentStatus'];
				$CompleteStatus 	= $Transaction['Status']['CompleteStatus'];		
				$CheckStatus 		= $Transaction['Status']['CompleteStatus'];
				$ptid 				= @$Transaction['ExternalTransaction']['ExternalTransactionID'];
				$pd 				= @$Transaction['ExternalTransaction'];	
				$FeeOrCreditAmount 				= @$Transaction['ExternalTransaction']['FeeOrCreditAmount'];
				$FinalValueFee					= $Transaction['FinalValueFee'];
				
				
				/*
				$val				= date('Y')."-".date('m')."-".date('d')."-".date("H").date('i').date('s'). mt_rand(100, 999);
				while(true){
					$si		= "select * from ebay_order where ebay_ordersn ='$val'";
					$si		= $dbcon->execute($si);
					$si		= $dbcon->getResultArray($si);
					if(count($si)==0){
					
					 break;
					}else{
					
					echo 'yes';
					
					
					}
					$val				= date('Y')."-".date('m')."-".date('d')."-".date("H").date('i').date('s'). mt_rand(100, 999);
					
				}*/
				
				
				$tid				= $Transaction['TransactionID'];
				$orderidary			= explode($orderid,'-');
				$AmountPaid  		= @$Transaction['AmountPaid'];
				$Buyer 				= str_rep(@$Transaction['Buyer']);
				$Email 				= str_rep(@$Buyer['Email']);          //email
				$UserID 			= str_rep(@$Buyer['UserID']);        //userid
				$BuyerInfo 			= $Buyer['BuyerInfo']['ShippingAddress'];
				$Name 				= str_rep($BuyerInfo['Name']);
				$Name				= mysql_real_escape_string($Name);
				$Street1 			= str_rep($BuyerInfo['Street1']);
				$Street2 			= str_rep(@$BuyerInfo['Street2']);
				$CityName 			= str_rep(@$BuyerInfo['CityName']);
				$StateOrProvince 	= str_rep(@$BuyerInfo['StateOrProvince']);
				$Country 			= str_rep(@$BuyerInfo['Country']);
				$CountryName 		= str_rep(@$BuyerInfo['CountryName']);
				$PostalCode 		= str_rep(@$BuyerInfo['PostalCode']);
				$Phone 				= @$BuyerInfo['Phone'];
				$Item 				= $Transaction['Item'];
				$CategoryID 		= $Item['PrimaryCategory']['CategoryID']; //ebay登录的种类编号，备用字段
				$Currency 			= $Item['Currency'];                            //货币类型
				$ItemID 			= $Item['ItemID'];                                // ebay产品id
				$ListingType 		= $Item['ListingType'];
				$Title 				= str_rep($Item['Title']);								  //产品标题名称
				$sku 				= str_rep($Item['SKU']);
				$site				= $Item['Site'];
				$CurrentPrice 		= $Item['SellingStatus']['CurrentPrice'];   //产品当前价格
				$QuantityPurchased 	= $Transaction['QuantityPurchased'];   //购买数量
				$PaidTime 			= strtotime($Transaction['PaidTime']);                     //付款时间
				$CreatedDate 		= strtotime($Transaction['CreatedDate']);               //交易创建时间...********多个产品订单每个产品的创建时间不同判依据
				$ShippedTime    	= strtotime($Transaction['ShippedTime']);				
				$shipingservice		= $Transaction['ShippingServiceSelected']['ShippingService'];
				$shipingfee			= $Transaction['ShippingServiceSelected']['ShippingServiceCost'];
				$recordnumber1		= @$Transaction['ContainingOrder']['ShippingDetails']['SellingManagerSalesRecordNumber']; //合并后的recordnumber
				
				$orderid 			= @$Transaction['ContainingOrder']['OrderID'];
				$BuyerCheckoutMessage					= str_rep($Transaction['BuyerCheckoutMessage']);
				$BuyerCheckoutMessage					= str_replace('<![CDATA[','',$BuyerCheckoutMessage);
				$BuyerCheckoutMessage					= str_replace(']]>','',$BuyerCheckoutMessage);
				$PayPalEmailAddress	= $Transaction['PayPalEmailAddress'];    
				$addrecordnumber    = $recordnumber;					
				if($recordnumber1 != ''){$addrecordnumber	= $recordnumber1;}
				$val				.= $addrecordnumber;
				
				$val				= $orderid;
				
				
				
				

				$orderstatus		= 0;				
				//if($CompleteStatus  == "Complete" && $eBayPaymentStatus == "NoPaymentFailure" && $PaidTime > 0){	$orderstatus		= 1;}
				
				if($eBayPaymentStatus == "NoPaymentFailure" && $PaidTime > 0){	$orderstatus		= 1;}
				if($ShippedTime >0) $orderstatus		= 2;
				$RefundAmount		= 0; //表示未垦退款
				if($orderstatus == '1' && $ShippedTime <=0 && $PaidTime >0 ){
				$status				= CheckOrderID($CompleteStatus,$addrecordnumber,$account,$orderid,$UserID,$ptid,$PaidTime);



				if($Transaction['Variation'] != '' ){
							$sku	= $Transaction['Variation']['SKU'];
				}
				
				
				if($status == "0" && $Name != ''){
					$status = $val;			
					
					
					if($user == 'vipkevin' ) $order_no = getordersn();
							
					$sql			 = "INSERT INTO `ebay_order` (`ebay_paystatus`,`ebay_ordersn` ,`ebay_tid` ,`ebay_ptid` ,`ebay_orderid` ,";
					$sql			.= "`ebay_createdtime` ,`ebay_paidtime` ,`ebay_userid` ,`ebay_username` ,`ebay_usermail` ,`ebay_street` ,";
					$sql			.= "`ebay_street1` ,`ebay_city` ,`ebay_state` ,`ebay_couny` ,`ebay_countryname` ,`ebay_postcode` ,`ebay_phone`";
					$sql			.= " ,`ebay_currency` ,`ebay_total` ,`ebay_status`,`ebay_user`,`ebay_shipfee`,`ebay_account`,`recordnumber`,`ebay_addtime`,`ebay_note`,`ebay_site`,`eBayPaymentStatus`,`PayPalEmailAddress`,`ShippedTime`,`RefundAmount`,`ebay_warehouse`,`order_no`)VALUES ('$CompleteStatus','$val', '$tid' , '$ptid' , '$orderid' , '$CreatedDate' , '$PaidTime' , '$UserID' ,";
					$sql			.= " '$Name' , '$Email' , '$Street1' , '$Street2' , '$CityName','$StateOrProvince' , '$Country' , '$CountryName' , '$PostalCode' , '$Phone' , '$Currency' , '$AmountPaid' , '$orderstatus','$user','$shipingfee','$account','$addrecordnumber','$mctime','$BuyerCheckoutMessage','$site','$eBayPaymentStatus','$PayPalEmailAddress','$ShippedTime','$RefundAmount','$defaultstoreid','$order_no')";
					$ss		= "select ebay_id from ebay_order where ebay_account ='$account' and recordnumber ='$addrecordnumber' ";
					$ss		= $dbcon->execute($ss);
					$ss		= $dbcon->getResultArray($ss);
					if(count($ss) == 0){
							if($dbcon->execute($sql)){
								echo "$val add success: UserID:$UserID"."$recordnumber   paid: $CompleteStatus   \n\r";
								AddorderDetail($val,$ItemID,$Title,$CurrentPrice,$QuantityPurchased,$CreatedDate,$shipingservice,$sku,$shipingfee,$account,$mctime,$pic,$site,$token,$recordnumber,$CountryName,$ListingType,$tid,$FeeOrCreditAmount,$FinalValueFee,$arrribute,$BuyerCheckoutMessage);
								
								
								if(strlen($ptid) >= 8 && ($user =='test' ||  $user =='survy' ||  $user =='luoxiaoming'  ||  $user =='vipshen' ) ){
						$nvpStr						="&TRANSACTIONID=$ptid";
						$details	 				= call_ebay("gettransactionDetails",$nvpStr,$PayPalEmailAddress);
						
					
						
						$COUNTRYCODE				= str_rep($details['COUNTRYCODE']);
						$SHIPTONAME					= str_rep($details['SHIPTONAME']);
						$SHIPTOSTREET				= str_rep($details['SHIPTOSTREET']);
						$SHIPTOSTREET2				= str_rep($details['SHIPTOSTREET2']);
						$SHIPTOCITY					= str_rep($details['SHIPTOCITY']);
						$SHIPTOSTATE				= str_rep($details['SHIPTOSTATE']);
						$SHIPTOCOUNTRYCODE			= str_rep($details['SHIPTOCOUNTRYCODE']);
						$SHIPTOCOUNTRYNAME			= str_rep($details['SHIPTOCOUNTRYNAME']);
						$SHIPTOZIP					= str_rep($details['SHIPTOZIP']);
						$Custom_Paypalemailaddress					= str_rep($details['EMAIL']);
						
						if($SHIPTONAME !=''){
							$sy	= "update ebay_order set ebay_username='$SHIPTONAME',ebay_street='$SHIPTOSTREET',ebay_street1='$SHIPTOSTREET2',ebay_city='$SHIPTOCITY',ebay_state='$SHIPTOSTATE',ebay_countryname='$SHIPTOCOUNTRYNAME',ebay_postcode='$SHIPTOZIP',Custom_Paypalemailaddress='$Custom_Paypalemailaddress' where ebay_ptid='$ptid' and ebay_user ='$user'";
							$dbcon->execute($sy);
						}
					}
					
					
							}else{
								echo $sql;
								echo "11 $val 加载失败: UserID:$UserID"."<br>";
							}
							
					}
				}else{
					$sql 		= "select ebay_id from ebay_orderdetail where  ebay_account='$account' and recordnumber='$recordnumber'";
					$sql	    = $dbcon->execute($sql);
					$sql	    = $dbcon->getResultArray($sql);
					if(count($sql) == 0){
					AddorderDetail($status,$ItemID,$Title,$CurrentPrice,$QuantityPurchased,$CreatedDate,$shipingservice,$sku,$shipingfee,$account,$mctime,$pic,$site,$token,$recordnumber,$CountryName,$ListingType,$tid,$FeeOrCreditAmount,$FinalValueFee,$arrribute,$BuyerCheckoutMessage);
					
					}
				}
				

				}
		}
	
		
		if($pcount>= $TotalNumberOfPages ){
			 echo $hasmore.'ccc'.'Erp exit, no more transactions'."\n\r";
			 break;
		}
		
		echo 'cc'."\n\r";
		$pcount++;
		}while($hasmore);

	}

	

	function GetTransactionID($tid,$userToken){

	

			$verb = 'GetOrders';

			global $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID;

			$requestXmlBody = '<?xml version="1.0" encoding="utf-8"?> 

		<GetOrdersRequest xmlns="urn:ebay:apis:eBLBaseComponents"> 

		 <DetailLevel>ReturnAll</DetailLevel>
		  <RequesterCredentials> 

			<eBayAuthToken>'.$userToken.'</eBayAuthToken> 

		  </RequesterCredentials> 

		  <OrderIDArray> 

			<OrderID>'.$orderid.'</OrderID>

		  </OrderIDArray>

		  <OrderRole>Seller</OrderRole> 

		  <OrderStatus>Completed</OrderStatus> 

		  <Pagination>

			  <EntriesPerPage>199</EntriesPerPage>

			  <PageNumber>1</PageNumber>

		  </Pagination>

		</GetOrdersRequest>'; 

			$session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);

			$responseXml = $session->sendHttpRequest($requestXmlBody);

			if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';

			$data=XML_unserialize($responseXml); 

			return $data['GetOrdersResponse']['OrderArray']['Order']['ExternalTransaction']['ExternalTransactionID'];	

	}

	

	function CheckOrderID($npaystatus,$recordnumber,$account,$orderid,$UserID,$ptid,$PaidTime){

		

		
		global $dbcon;		

		$sql		= "select * from ebay_order where recordnumber='$recordnumber' and ebay_account='$account'";
		

		
		$sql  = $dbcon->execute($sql);
		$sql  = $dbcon->getResultArray($sql);
		if(count($sql) == 0){
		$status			= "0";
		

		
		
		}else{
		$status 		= $sql[0]['ebay_ordersn'];
	
		}
		
		
		
		return $status;

		

	}

	

	function CheckMessageID($messageid,$recipientid	){

		

		global $dbcon;

		$sql  = "select * from ebay_message where (message_id='$messageid' or ExternalMessageID	='$messageid') and recipientid ='$recipientid'";

		

		$sql  = $dbcon->execute($sql);

		$sql  = $dbcon->getResultArray($sql);

		$status = "";		

		if(count($sql) == 0){		

			$status = "0";

		}else{		

			$status = "9";

		}		

		return $status;

	}

	

	function AddorderDetail($sn,$iid,$title,$price,$amount,$ctime,$shiptype,$sku,$shipingfee,$account,$mctime,$pic,$site,$token,$recordnumber,$CountryName,$ListingType,$tid,$FeeOrCreditAmount,$FinalValueFee,$arrribute,$BuyerCheckoutMessage){
		global $user,$dbcon;
		$title				 	 = mysql_escape_string($title);
		$arrribute			 	 = mysql_escape_string($arrribute);
		$shiptype			 	 = mysql_escape_string($shiptype);
		$BuyerCheckoutMessage	 = mysql_escape_string($BuyerCheckoutMessage);
		$sql 	 = "select ebay_id from ebay_orderdetail where  recordnumber='$recordnumber' and ebay_account ='$account'";
		$sql 	 = $dbcon->query($sql);
		$sql	 = $dbcon->num_rows($sql);
		if($sql == 0){			
				$ss				= "SELECT goods_location FROM  `ebay_goods` where ebay_user='$user' and goods_sn='$sku'";
				$ss				= $dbcon->execute($ss);
				$ss				= $dbcon->getResultArray($ss);
				$goods_location		= mysql_escape_string($ss[0]['goods_location']);
				
				
				
				$data		= getItem($token,$iid,$picvalue);
				$pic				= $data[1];
				
				
									/*
									$vv			= "select * from ebay_goods where goods_sn ='$SKU' and ebay_user ='$user' ";
									$vv			= $dbcon->execute($vv);
									$vv			= $dbcon->getResultArray($vv);
									if(count($vv) == 0 ){
										$data		= getItem($token,$iid);
										$pic		= $data[1];
										@$img 	= file_get_contents($pic);
										$pic	= $SKU.".jpg";
										file_put_contents($filepath."\images\\".$pic,$img);
									}
									*/
									
									if($user == 'test') $sku	= substr($sku,1);
									
									
									
									
				$esql	 = "INSERT INTO `ebay_orderdetail` (`ebay_ordersn` ,`ebay_itemid` ,`ebay_itemtitle` ,`ebay_itemprice` ,";
				$esql    .= "`ebay_amount` ,`ebay_createdtime` ,`ebay_shiptype` ,`ebay_user`,`sku`,`shipingfee`,`ebay_account`,`addtime`,`ebay_itemurl`,`ebay_site`,`recordnumber`,`storeid`,`ListingType`,`ebay_tid`,`FeeOrCreditAmount`,`FinalValueFee`,`attribute`,`notes`,`goods_location`)VALUES ('$sn', '$iid' , '$title' , '$price' , '$amount'";
				$esql	.= " , '$ctime' , '$shiptype' , '$user','$sku','$shipingfee','$account','$mctime','$pic','$site','$recordnumber','$storeid','$ListingType','$tid','$FeeOrCreditAmount','$FinalValueFee','$arrribute','$BuyerCheckoutMessage','$goods_location')";		
			if($dbcon->execute($esql)){				
				echo "$iid add success"."\n\r";			
			}else{
				echo "$iid 添加失败"."<br>";				
			}

		}
	

	}

		function addoutstock($ordersn){

		
			global $dbcon,$nowtime,$user;
			
			

		
		$iskucong		= 0;
		


		
		
		$ss			= "select a.ebay_ordersn,a.ebay_account as tt,a.ebay_currency,a.ebay_total,a.ebay_warehouse,b.*  from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn = b.ebay_ordersn where a.ebay_ordersn='$ordersn' and a.ebay_combine!='1' AND b.istrue =  '0'";

		$ss			= $dbcon->execute($ss);
		$ss 	 	= $dbcon->getResultArray($ss);
		$recordnumber	= $ss[0]['recordnumber'];
		$storeid	= $ss[0]['ebay_warehouse'];
		print_r($ss);
		
		
		echo $storeid.'ddd';
		
		if($storeid >= 1 ){
		
		for($i=0;$i<count($ss);$i++){
		
		$goodssn		= $ss[$i]['sku'];
		
		
	
		
		$account		= $ss[$i]['tt'];
		$ebay_id		= $ss[$i]['ebay_id'];
		$ebay_amount	= $ss[$i]['ebay_amount'];
		$ebay_total		= $ss[$i]['ebay_total'];
		
		$ebay_itemprice		= $ss[$i]['ebay_itemprice'] + $ebay_total;
		$ebay_currency		= $ss[$i]['ebay_currency'];
		
		$sql			= "SELECT * FROM ebay_goods where goods_sn='$goodssn' and ebay_user='$user'";
		$sql			= $dbcon->execute($sql);
		$sql 	 		= $dbcon->getResultArray($sql);
		
		if(count($sql) == 0){
				
				
				/**/
				$rr			= "select * from ebay_productscombine where ebay_user='$user' and goods_sn='$goodssn'";
				$rr			= $dbcon->execute($rr);
				$rr 	 	= $dbcon->getResultArray($rr);
				if(count($rr) == 0){
					
					echo "<br> -[<font color='#FF0000'>{$goodssn} : 未找到货品资料</font>]";
				}else{
					$goods_sncombine	= $rr[0]['goods_sncombine'];
					$goods_sncombine    = explode(',',$goods_sncombine);
					for($d=0;$d<count($goods_sncombine);$d++){
						
						
						$pline			= explode('*',$goods_sncombine[$d]);
						$goods_sn		= $pline[0];
						$goddscount     = $pline[1] * $ebay_amount;
						
						$sql2			= "SELECT * FROM ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
						$sql2			= $dbcon->execute($sql2);
						$sql2 	 		= $dbcon->getResultArray($sql2);
						$storeid		= $sql2[0]['storeid'];
						
						
						$goods_id		= $sql2[0]['goods_id'];
						$goods_name		= str_rep($sql2[0]['goods_name']);
						$goods_price	= $sql2[0]['goods_price'];
						$goods_cost		= $sql2[0]['goods_cost'];
						$goods_category	= $sql2[0]['goods_category'];
						$goods_register	= $sql2[0]['goods_register']?$sql2[0]['goods_register']:1;
						$instock		= $goddscount;
						
						
						
						
				$dstr				= "出库";
			
				$sq			= "update ebay_onhandle set goods_count=goods_count-$instock where goods_sn='$goods_sn' and store_id='$storeid' and ebay_user='$user'";
				
				if($storeid >0){
				if($dbcon->execute($sq)){

					$status	= "<br> -[<font color='#33CC33'>{$goods_sn}已成功出库</font>]";
					
					$sq			 = "INSERT INTO `ebay_goodshistory` (`addtime` , `goodsid` , `goodsn` , `goodsname` , `stocktype` , `goodsprice` ,";
					$sq			.= "`goodsnumber` , `ebay_user` ,`ebay_account`,`goods_category` ,`ebay_currency`) VALUES ('$nowtime', '$goods_id', '$goods_sn', '$goods_name', '$dstr', '$ebay_itemprice', '$instock', '$user','$account','$goods_category','$ebay_currency');";
					
					$si			 = "update ebay_orderdetail set istrue='1' where ebay_id='$ebay_id'";
					$dbcon->execute($sq);
					$dbcon->execute($si);
					
				
				}else{
					$status = "<br> -[<font color='#FF0000'>{$goods_sn} : 出库失败</font>]";
				}
				
				}else{
					$status = "<br> -[<font color='#FF0000'>eBay sku{$goods_sn} : 未设置对应仓库</font>]";
				}
				echo $status."<br>";
				
				}
				}
				
				
		}else{
			
				
				
				$goods_id		= $sql[0]['goods_id'];
				$goods_sn		= str_rep($sql[0]['goods_sn']);
				$goods_name		= str_rep($sql[0]['goods_name']);
				$goods_price	= $sql[0]['goods_price'];
				$goods_cost		= $sql[0]['goods_cost'];
				$goods_category	= $sql[0]['goods_category'];
				$goods_register	= $sql[0]['goods_register']?$sql[0]['goods_register']:1;
				$instock		= $ebay_amount;
				$dstr				= "出库";
			
				$sq			= "update ebay_onhandle set goods_count=goods_count-$instock where goods_sn='$goods_sn' and store_id='$storeid' and ebay_user='$user'";
				
				if($storeid >0){
				if($dbcon->execute($sq)){

					$status	= " -[<font color='#33CC33'>{$goods_sn}已成功出库</font>]";
					
					
					$sq			 = "INSERT INTO `ebay_goodshistory` (`addtime` , `goodsid` , `goodsn` , `goodsname` , `stocktype` , `goodsprice` ,";
					$sq			.= "`goodsnumber` , `ebay_user` ,`ebay_account`,`goods_category` ,`ebay_currency`) VALUES ('$nowtime', '$goods_id', '$goods_sn', '$goods_name', '$dstr', '$ebay_itemprice', '$instock', '$user','$account','$goods_category','$ebay_currency');";
					
					$si			 = "update ebay_orderdetail set istrue='1' where ebay_id='$ebay_id'";
					$dbcon->execute($sq);
					$dbcon->execute($si);
					
				
				}else{
					$status = "<br> -[<font color='#FF0000'>{$goods_sn}出库失败</font>]";
				}
				
				}else{
					$status = "<br> -[<font color='#FF0000'>eBay sku{$goods_sn} 未设置对应仓库</font>]";
				}
				echo $status."<br>";
				

	
		}
		
		
		}
		
		
		}else{
		
			
			
			 $status = "<br> -[<font color='#FF0000'>销售编号：{$recordnumber} 未设置对应仓库</font>]";
			 echo $status;
			 
		}
		
		


	}

	function addoutstockss($ordersn){

		global $dbcon,$nowtime,$user;
		
		$ss			= "select a.ebay_ordersn,a.ebay_account as tt,a.ebay_currency,b.*  from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn = b.ebay_ordersn where a.ebay_ordersn='$ordersn' and a.ebay_combine!='1' AND b.istrue =  '0'";




		$ss			= $dbcon->execute($ss);
		$ss 	 	= $dbcon->getResultArray($ss);
		for($i=0;$i<count($ss);$i++){
		
		$goodssn		= $ss[$i]['sku'];
		$account		= $ss[$i]['tt'];
		$ebay_id		= $ss[$i]['ebay_id'];
		$ebay_amount		= $ss[$i]['ebay_amount'];
		$ebay_itemprice		= $ss[$i]['ebay_itemprice'];
		$ebay_currency		= $ss[$i]['ebay_currency'];
		
		$sql			= "SELECT * FROM ebay_goods where goods_sn='$goodssn' and ebay_user='$user'";
		$sql			= $dbcon->execute($sql);
		$sql 	 		= $dbcon->getResultArray($sql);
		$storeid		= $sql[0]['storeid'];
		if(count($sql) == 0){

				echo "EbaySKU:{$goodssn}未找到货品资料";
		}else{
			
				
				$goods_id		= $sql[0]['goods_id'];
				$goods_sn		= str_rep($sql[0]['goods_sn']);
				$goods_name		= str_rep($sql[0]['goods_name']);
				$goods_price	= $sql[0]['goods_price'];
				$goods_cost		= $sql[0]['goods_cost'];
				$goods_category	= $sql[0]['goods_category'];
				$goods_register	= $sql[0]['goods_register']?$sql[0]['goods_register']:1;
				$instock		= $ebay_amount;
				$dstr				= "出库";
			
				$sq			= "update ebay_onhandle set goods_count=goods_count-$instock where goods_sn='$goods_sn' and store_id='$storeid' and ebay_user='$user'";
				
				if($storeid >0){
				if($dbcon->execute($sq)){

					$status	= " -[<font color='#33CC33'>{$goods_sn}已成功出库</font>]";
					
					$sq			 = "INSERT INTO `ebay_goodshistory` (`addtime` , `goodsid` , `goodsn` , `goodsname` , `stocktype` , `goodsprice` ,";
					$sq			.= "`goodsnumber` , `ebay_user` ,`ebay_account`,`goods_category` ,`ebay_currency`) VALUES ('$nowtime', '$goods_id', '$goods_sn', '$goods_name', '$dstr', '$ebay_itemprice', '$instock', '$user','$account','$goods_category','$ebay_currency');";
					
					$si			 = "update ebay_orderdetail set istrue='1' where ebay_id='$ebay_id'";
					$dbcon->execute($sq);
					$dbcon->execute($si);
					
				
				}else{
					$status = " -[<font color='#FF0000'>{$goods_sn}出库失败</font>]";
				}
				
				}else{
					$status = " -[<font color='#FF0000'>eBay sku{$goods_sn} 未设置对应仓库</font>]";
				}
				echo $status."<br>";
				
				

		}
		}
		

	}

	

	

	function getmessageconten(){

		

		

		

	

	

	

	}

	

	

	function GetMemberMessages($start,$end,$token,$account,$type,$id){
		global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$user,$dbcon,$nowtime,$Sordersn,$mctime,$notesorderstatus;
		$compatabilityLevel	= 743;
		
		$ic 		= 1;

		$verb = 'GetMyMessages';    
		$requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>
		<GetMyMessagesRequest xmlns="urn:ebay:apis:eBLBaseComponents">
 		<RequesterCredentials>
    	<eBayAuthToken>'.$token.'</eBayAuthToken>
  		</RequesterCredentials>  
   		<StartTime>'.$start.'</StartTime>	
   		<EndTime>'.$end.'</EndTime>
  		<DetailLevel>ReturnSummary</DetailLevel>
		 <Pagination> 
		 <EntriesPerPage>199</EntriesPerPage> 
		 <PageNumber>'.$ic.'</PageNumber> 
		 </Pagination> 
		</GetMyMessagesRequest>';
		$session = new eBaySession($token, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
		$responseXml = $session->sendHttpRequest($requestXmlBody);
		if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';
		$responseDoc = new DomDocument();
    	$responseDoc->loadXML($responseXml);
		$data	= XML_unserialize($responseXml);
		
		
		
	//	print_r($data);
		
		$Ack	= $data['GetMyMessagesResponse']['Ack'];
		/* 如果目录API返回失败，则写入失败表中。 */
		echo " status: ".$Ack." \n\r";
		if($Ack == '' || $Ack != 'Success' ){
			$ss			= "insert into errors_ackmessage(ebay_account,starttime,endtime,status,notes) values('$account','$start','$end','0','Ack False')";
			$dbcon->execute($ss);
		}
		/* 如果执行失败的API返回记录成功后，则列新失败的状态 */
		if($id > 0 ){
		if($Ack == 'Success'){
			$gg		= "update errors_ackmessage set status = 1 where id='$id' ";
			$dbcon->execute($gg);
		}
		}
		$FolorderID		= $data['GetMyMessagesResponse']['Summary']['FolderSummary'];
		

		
		
		for($i=0;$i<count($FolorderID);$i++){
			$FolderID				= $FolorderID[$i]['FolderID'];
			$TotalMessageCount		= $FolorderID[$i]['TotalMessageCount'];
			
			echo $TotalMessageCount;
			echo '开始同步文件ID: '.$FolderID.'<br>';
			
	
			
			/* 开始计算总页数 */
			$totalpages		= ceil($TotalMessageCount/199);
			$startpages		= 1;
			/*开始加载对应目录下的Message信息 FolderID = 1 表示是 sent 文件夹*/
			if($FolderID != 1){
			
				
				 while(true){
				$requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>
				<GetMyMessagesRequest xmlns="urn:ebay:apis:eBLBaseComponents">
				<RequesterCredentials>
				<eBayAuthToken>'.$token.'</eBayAuthToken>
				</RequesterCredentials>  
				<StartTime>'.$start.'</StartTime>	
				<EndTime>'.$end.'</EndTime>
				<DetailLevel>ReturnHeaders</DetailLevel>
				<Pagination> 
				<EntriesPerPage>199</EntriesPerPage> 
				<PageNumber>'.$startpages.'</PageNumber> 
				</Pagination> 
				<FolderID>'.$FolderID.'</FolderID>
				</GetMyMessagesRequest>';
				$session = new eBaySession($token, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
				$responseXml = $session->sendHttpRequest($requestXmlBody);
				if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';
				$responseDoc = new DomDocument();
    			$responseDoc->loadXML($responseXml);
				$data	= XML_unserialize($responseXml);
				
			
				
				$Ack	= $data['GetMyMessagesResponse']['Ack'];
				
				
				$datais	= $data['GetMyMessagesResponse']['Messages'];
				
				if($datais == '' ) return;
				
				
				$Trans = $data['GetMyMessagesResponse']['Messages']['Message'];  
				$Sender					= $data['GetMyMessagesResponse']['Messages']['Message']['Sender'];  
				if($Sender != '' ) {
				$Trans		= array();
				$Trans[0] = $data['GetMyMessagesResponse']['Messages']['Message'];  
				}
				
				foreach((array)$Trans as $Transaction){
					$Read					= $Transaction['Read']?1:0;
					$HighPriority			= $Transaction['HighPriority'];
					$Sender					= $Transaction['Sender'];
					$MessageID				= $Transaction['MessageID'];
					$RecipientUserID		= $Transaction['RecipientUserID'];
					$Subject				= mysql_escape_string($Transaction['Subject']);
					$MessageType			= $Transaction['MessageType'];
					$Replied				= $Transaction['Replied'];
					$ItemID					= $Transaction['ItemID'];
					$ExternalMessageID		= $Transaction['ExternalMessageID']; // 之前的id
					$ReceiveDate			= $Transaction['ReceiveDate'];
					$ItemTitle				= mysql_escape_string($Transaction['ItemTitle']);
					$createtime1			= strtotime($ReceiveDate);
					$ss						= "select id from ebay_message where message_id='$MessageID' and ebay_account='$account'";
					$ss		= $dbcon->execute($ss);
					$ss		= $dbcon->getResultArray($ss);
					if(count($ss) == 0 && $MessageID > 1000 ){
					
					
					$status		= 0;
					if($Replied == 'true') $status = 1;
					echo $Sender.' need add: '.$Replied.':'.$status.' <br>';
					$verb = 'GetMyMessages';    
					$requestXmlBody = '<?xml version="1.0" encoding="utf-8"?> 
					<GetMyMessagesRequest xmlns="urn:ebay:apis:eBLBaseComponents"> 
			  		<DetailLevel>ReturnMessages</DetailLevel>
			  		<RequesterCredentials> 
			   		<eBayAuthToken>'.$token.'</eBayAuthToken>
			  		</RequesterCredentials> 
			  		<MessageIDs><MessageID>'.$MessageID.'</MessageID> 
			  		</MessageIDs> 
					</GetMyMessagesRequest> ';
					$session = new eBaySession($token, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
					$responseXml = $session->sendHttpRequest($requestXmlBody);
					$data   	= XML_unserialize($responseXml);
					
					
					$Body	    = mysql_escape_string($data['GetMyMessagesResponse']['Messages']['Message']['Text']);  		
					$forms			= 0;
					if($Sender == 'eBay'){
						$forms		= 2;
					}
					if($HighPriority == 'true'){
						$forms		= 3;
					}
					$classid		= '0';
					if($Sender != 'eBay'){
						
					}
					/* 检查当前message应该属于哪一个分类中的 */
					$sql	 = "select id from ebay_messagecategory where category_name='$RecipientUserID'";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					if(count($sql) == 0){

						$sql	= "insert into ebay_messagecategory(category_name,ebay_note,ebay_user
) values('$RecipientUserID','$RecipientUserID','$user')";
						$dbcon->execute($sql);
						$sql	 = "select * from ebay_messagecategory where category_name='$RecipientUserID'";
						$sql	 = $dbcon->execute($sql);
						$sql	 = $dbcon->getResultArray($sql);
						$classid	= $sql[0]['id'];
					}else{
						$classid	= $sql[0]['id'];
					}

					
					$sql	 = "INSERT INTO `ebay_message` (`message_id` , `message_type` , `question_type` , `recipientid` ";
					$sql	.= ", `sendmail` , `sendid` , `subject` , `body` , `itemid` , `starttime` , `endtime` , `currentprice` , ";
					$sql	.= "`title` , `createtime` , `ebay_user` , `add_time` , `itemurl` , `ebay_account`,`classid`,`createtime1`,`status`,`forms`,`Read`,`ExternalMessageID`)VALUES ('$MessageID', '$MessageType' ,";
					$sql    .= " '$QuestionType' , '$RecipientUserID' , '$SenderEmail' , '$Sender' , '$Subject' , '$Body' , '$ItemID' , ";
					$sql	.= "'$starttime' , '$endtime' , '$price' , '$ItemTitle' , '$ReceiveDate' ,'$user' , $mctime,'$ViewItemURL','$account','$classid','$createtime1','$status','$forms','$Read','$ExternalMessageID') ";
					
					
			
					if($dbcon->execute($sql)){
						echo "<br>$MessageID addsuccess \n\r";
					}else{
						echo "<br>$MessageID addfailure \n\r";
						echo $sql;
						
					}
					}else{
					echo $Sender.' exit <br>';
					}
				
				
				}
				
				$startpages ++;
				if($startpages > $totalpages) break;
				
				
				}
				
				


			}
			
		}
	}
	

	function AddMemberMessageRTQ($msid,$content,$replyuser,$mailsent){
		 global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$user,$dbcon,$nowtime,$Sordersn,$mctime;
		 $compatabilityLevel		= 657;
		 $copystatus		= 'true';
		 if($mailsent == '1') $copystatus		= 'true';
		 $verb = 'AddMemberMessageRTQ';
		 $sql	= "select itemid,message_id,ExternalMessageID,sendid,ebay_account from ebay_message where message_id='$msid'";
		 $sql	= $dbcon->execute($sql);
		 $sql	= $dbcon->getResultArray($sql);
		 

		 
		 $itmeid				= $sql[0]['itemid'];
		 $message_id 			= $sql[0]['message_id'];
		 $ExternalMessageID 	= $sql[0]['ExternalMessageID'];
		 $replyid				= $message_id;
		 if($ExternalMessageID != '' ) $replyid				= $ExternalMessageID;
		 $sendid		= $sql[0]['sendid'];
		 $account		= $sql[0]['ebay_account'];
		 
		 $ss			= "select ebay_username,ebay_street,ebay_street1,ebay_city,ebay_state,ebay_countryname,ebay_postcode,ebay_phone,ebay_ordersn from ebay_order where ebay_userid='$sendid'";
		 $ss	= $dbcon->execute($ss);
		 $ss	= $dbcon->getResultArray($ss);
		 $cname			= $ss[0]['ebay_username'];
		 $street1		= $ss[0]['ebay_street'];
		 $street2 		= $ss[0]['ebay_street1']?@$ss[0]['ebay_street1']:"";
		 $city 			= $ss[0]['ebay_city'];
		 $state			= $ss[0]['ebay_state'];
		 $countryname 	= $ss[0]['ebay_countryname'];
		 $zip			= $ss[0]['ebay_postcode'];
		 $tel			= $ss[0]['ebay_phone']?$ss[0]['ebay_phone']:"";
		 $ordersn		= $ss[0]['ebay_ordersn'];	

		 $addressline		= $cname."\n\r".$street1."\n\r".$street2."\n\r".$city.", ".$state."\n\r".$zip;
		 $ebay_markettime 	= $ss[0]['ebay_markettime'];
		  $content			= str_replace('{Buyerid}',$sendid,$content);
		 $content			= str_replace('{Buyername}',$cname,$content);
		 $content			= str_replace('{Buyercountry}',$countryname,$content);
		 $content			= str_replace('{Sellerid}',$account,$content);
		 $content			= str_replace('{Itemnumber}',$itmeid,$content);
		 $content			= str_replace('{Itemtitle}',$title,$content);
		 $content			= str_replace('{Itemquantity}',"1",$content);
		 $content			= str_replace('{Shipdate}',$ebay_markettime,$content);		 
		 $content			= str_replace('{Shippingaddress}',$addressline,$content);
		 $content			= str_replace("&","&amp;",$content);
		 $content      		= str_replace("\\","",$content);
		 /* 取得token */
		$sq 	 = "select ebay_token from ebay_account where ebay_user='$user' and ebay_account='$account'";
		$sq		 = $dbcon->execute($sq);
		$sq		 = $dbcon->getResultArray($sq);
		$token	 = $sq[0]['ebay_token'];

		

		$status = "AAfailureAA";

    	 $requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>
		<AddMemberMessageRTQRequest xmlns="urn:ebay:apis:eBLBaseComponents">
		<ItemID>'.$itemid.'</ItemID>
		<MemberMessage>
		<Body><![CDATA['.$content.']]></Body>
		<EmailCopyToSender>'.$mailsent.'</EmailCopyToSender>
		<ParentMessageID>'.$replyid.'</ParentMessageID>
		<RecipientID>'.$sendid.'</RecipientID>
		</MemberMessage>
		<RequesterCredentials>
		<eBayAuthToken>'.$token.'</eBayAuthToken>
		</RequesterCredentials>
		</AddMemberMessageRTQRequest>';

		 if($user != '' ){
		 $session = new eBaySession($token, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
		 $responseXml = $session->sendHttpRequest($requestXmlBody);
		 if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';
		 $responseDoc = new DomDocument();
    	 $responseDoc->loadXML($responseXml);
	 	 $data	= XML_unserialize($responseXml);

		 
		 $reack	= $data['AddMemberMessageRTQResponse']['Ack'];
		 $error	= $data['AddMemberMessageRTQResponse']['Errors']['LongMessage'];
	     $content	= str_rep($content);

	  	 if($reack != 'Failure'){
			$exec = "update ebay_message set status=1,replaycontent='$content',replyuser='$replyuser',replytime='$mctime' where message_id='$msid'";
			if($dbcon->execute($exec)){
				//ReviseMyMessages($token,$msid,'Read');
				$status = "AAsuccessAA";
			}else{
				$status = "Error: ".$error;
			}	
		 }else{
			$status = "Error:".$error;
		 }
		 }else{
		 $status = "Error: Please re-login !!! ";
		 }
		$dbcon->close();
		return  $status;
	}

	

	function str_rep($str){

		

		$str  = str_replace("'","&acute;",$str);

		$str  = str_replace("\"","&quot;",$str);

		return $str;	

	}

	

	function Getstatus($status){

		

		$level	= "未处理";

		

		switch($status){

			

			case 0:

			$level = "我的订单";

			break;

			case 1:

			$level = "待发货订单";

			break;

			case 2:

			$level = "缺货订单";

			break;

			case 3:

			$level = "完成订单";

			break;

			default:

			$level = "未处理";

		}

		return $level;

	

	}

	

	function GetMessagestatus($status){

	

		$level	= "未回复";

		switch($status){

		

			case 0:

			$level	= "未回复";

			break;

			case 1:

			$level	= "已回复";

			break;

			case 2:

			$level	= "等待处理";

			break;

			default:

			$level = "未回复";

		

		}

		return $level;

	

	

	

	}

	/* 加载Paypal 线下订单交易 */
	
	function GetPaypalOrders($start,$end,$account){
		global $dbcon,$user;
		
		$vv			= "select * from ebay_config where ebay_user ='$user' ";
		$vv			= $dbcon->execute($vv);
		$vv			= $dbcon->getResultArray($vv);
		
		$paypalstatus	= $vv[0]['paypalstatus'];
		if($paypalstatus <= 0 ) die('请先在系统配置中，配置线下订单同步后来的状态');
		
		
		$start		= date('Y-m-d H:i:s',strtotime($start));		
		$time		= strtotime($start);
		$end		= date('Y-m-d H:i:s',strtotime($end." 23:59:59"));	
		$dba		= $start;
		$dbc		= $end;
		$start		= date('Y-m-d H:i:s',strtotime('-8 hour',strtotime($start)));
		$end		= date('Y-m-d H:i:s',strtotime('-8 hour',strtotime($end)));	
		$i = 0;
		while(true){
			if($i == 0){
				$tstart		= $start;
				$tend		= date('Y-m-d H:i:s',strtotime('+3 hour',strtotime($start)));					
			}else{				
				$tstart		= $tend;
				$tend		= date('Y-m-d H:i:s',strtotime('+3 hour',strtotime($tstart)));
			}			
			$astart	= date('Y-m-d',strtotime($tstart))."T".date('H:i:s',strtotime($tstart))."Z";
			$aend	= date('Y-m-d',strtotime($tend))."T".date('H:i:s',strtotime($tend))."Z";
			
			
		
			$nvpStr = "&STARTDATE=$astart&ENDDATE=$aend&TRANSACTIONCLASS=All";	
			$i = $i+1;			
			$ebayArray	=	call_ebay("TransactionSearch",$nvpStr,$account);
			
		
			
			GetPaypalOrderDetails($ebayArray,$account,$paypalstatus);			
			if(strtotime($tend)>strtotime($end)){
				echo 'pp销售额已经同步完成<br>';
				
				break;
			}
		}
	
	
	
	
	}
	
	
	
	function GetPaypalOrderDetails($ebayArray,$account,$paypalstatus){

		global $dbcon,$user,$defaultstoreid;
		$sure	= 0;
		
		
		while(true){    		
			
			if(array_key_exists('L_TRANSACTIONID'.$sure,$ebayArray)){
						$status		 = $ebayArray['L_STATUS'.$sure];						
						if($status == "Completed"){						
							$success	= $success+1;						
						}						
						$gross				 = $ebayArray['L_AMT'.$sure];
						$fee				 = $ebayArray['L_FEEAMT'.$sure];
						$net				 = $ebayArray['L_NETAMT'.$sure];						
						$type				 = $ebayArray['L_CURRENCYCODE'.$sure];	
						$time	    		 = $ebayArray['L_TIMESTAMP'.$sure]; 	
						$name	   			  = str_rep($ebayArray['L_NAME'.$sure]); 
						$time	    		 = $ebayArray['L_TIMESTAMP'.$sure];					
						$time				 = strtotime($time);					
						$tid				 = $ebayArray['L_TRANSACTIONID'.$sure];
						$L_CURRENCYCODE		 = $ebayArray['L_CURRENCYCODE'.$sure];
					    $Emails				 = $ebayArray['L_EMAIL'.$sure];
						$mail	     		 = $ebayArray['L_EMAIL'.$sure];						
						if($name != "Bank Account" && $name !='eBay, Inc' && ($status == "Completed" || $status == "Cleared" || $status == 'Completed - Funds not yet available')){
								
							
							
					//		$tid			= '13427964SF159073P';
							$nvpStr						="&TRANSACTIONID=$tid";
						
							
							$details	 				= call_ebay("gettransactionDetails",$nvpStr,$account);
							
							
					
							
							$COUNTRYCODE				= str_rep($details['COUNTRYCODE']);
							$Name						= str_rep($details['SHIPTONAME']);
							$Street1					= str_rep($details['SHIPTOSTREET']);
							$Street2					= str_rep($details['SHIPTOSTREET2']);
							$CityName					= str_rep($details['SHIPTOCITY']);
							$StateOrProvince			= str_rep($details['SHIPTOSTATE']);
							$Country					= str_rep($details['SHIPTOCOUNTRYCODE']);
							$CountryName				= str_rep($details['SHIPTOCOUNTRYNAME']);
							$PostalCode					= str_rep($details['SHIPTOZIP']);
							$NOTE						= mysql_escape_string($details['NOTE']);
							
							$TRANSACTIONTYPE					= str_rep($details['TRANSACTIONTYPE']);
							
							
							$vv			= "select ebay_id from ebay_order where ebay_ptid ='$tid' and ebay_user ='$user' ";
							$vv			= $dbcon->execute($vv);
							$vv			= $dbcon->getResultArray($vv);
							
					
							if(count($vv) == '0' && $TRANSACTIONTYPE == 'sendmoney'  ){
							
								$OrderID		 = date('Y')."-".date('m')."-".date('d')."-".date("H").date('i').date('s'). mt_rand(100, 999);
								
								$sql			 = "INSERT INTO `ebay_order` (`ebay_paystatus`,`ebay_ordersn` ,`ebay_ptid` ,";
								$sql			.= "`ebay_createdtime` ,`ebay_paidtime` ,`ebay_userid` ,`ebay_username` ,`ebay_usermail` ,`ebay_street` ,";
								$sql			.= "`ebay_street1` ,`ebay_city` ,`ebay_state` ,`ebay_couny` ,`ebay_countryname` ,`ebay_postcode` ,`ebay_phone`";
								$sql			.= " ,`ebay_currency` ,`ebay_total` ,`ebay_status`,`ebay_user`,`ebay_shipfee`,`ebay_account`,`recordnumber`,`ebay_addtime`,`ebay_note`,`ebay_site`,`eBayPaymentStatus`,`PayPalEmailAddress`,`ebay_warehouse`)VALUES ('Complete','$OrderID', '$tid'  , '$time' , '$time' , '$Name' ,";
								$sql			.= " '$Name' , '$Emails' , '$Street1' , '$Street2' , '$CityName','$StateOrProvince' , '$Country' , '$CountryName' , '$PostalCode' , '$Phone' , '$Currency' , '$AmountPaid' , '$paypalstatus','$user','$ShippingServiceCost','$account','$addrecordnumber','$mctime','$NOTE','$site','$eBayPaymentStatus','$PayPalEmailAddress','$defaultstoreid')";
								$dbcon->execute($sql);
								
							
							}
							
						}
					}else{					
						break;
					}
					$sure	= $sure +1;

				}

		}




	function getPaypalsales($start,$end,$account){
		$start		= date('Y-m-d H:i:s',strtotime($start));		
		$time		= strtotime($start);
		$end		= date('Y-m-d H:i:s',strtotime($end." 23:59:59"));	
		$dba		= $start;
		$dbc		= $end;
		$start		= date('Y-m-d H:i:s',strtotime('-8 hour',strtotime($start)));
		$end		= date('Y-m-d H:i:s',strtotime('-8 hour',strtotime($end)));	
		$i = 0;
		while(true){
			if($i == 0){
				$tstart		= $start;
				$tend		= date('Y-m-d H:i:s',strtotime('+12 hour',strtotime($start)));					
			}else{				
				$tstart		= $tend;
				$tend		= date('Y-m-d H:i:s',strtotime('+12 hour',strtotime($tstart)));
			}			
			$astart	= date('Y-m-d',strtotime($tstart))."T".date('H:i:s',strtotime($tstart))."Z";
			$aend	= date('Y-m-d',strtotime($tend))."T".date('H:i:s',strtotime($tend))."Z";
			$nvpStr = "&STARTDATE=$astart&ENDDATE=$aend&TRANSACTIONCLASS=Received";	
			$i = $i+1;			
			$ebayArray	=	call_ebay("TransactionSearch",$nvpStr,$account);
			
			
			print_r($ebayArray);
			
			getSales02($ebayArray,$account);			
			if(strtotime($tend)>strtotime($end)){
				echo 'pp销售额已经同步完成<br>';
				
				break;
			}
		}
	}

	

	function getSales02($ebayArray,$account){

		global $dbcon,$user;
									
				

				$sure	= 0;

				while(true){    		

					if(array_key_exists('L_TRANSACTIONID'.$sure,$ebayArray)){

						$status		 = $ebayArray['L_STATUS'.$sure];						

						if($status == "Completed"){						

							$success	= $success+1;						

						}						

						$gross		 = $ebayArray['L_AMT'.$sure];

						$fee		 = $ebayArray['L_FEEAMT'.$sure];

						$net		 = $ebayArray['L_NETAMT'.$sure];						

						$type		 = $ebayArray['L_CURRENCYCODE'.$sure];	

						$time	     = $ebayArray['L_TIMESTAMP'.$sure]; 	

						$name	     = str_rep($ebayArray['L_NAME'.$sure]); 
						$time	     = $ebayArray['L_TIMESTAMP'.$sure];					
						$time		 = strtotime($time);					
						$tid		 = $ebayArray['L_TRANSACTIONID'.$sure];
						$L_CURRENCYCODE		 = $ebayArray['L_CURRENCYCODE'.$sure];

			
					   $email		 = $ebayArray['L_EMAIL'.$sure];


						$mail	     = $ebayArray['L_EMAIL'.$sure];						

						if($name != "Bank Account" && $name !='eBay, Inc' && ($status == "Completed" || $status == "Cleared" || $status == 'Completed - Funds not yet available')){

							
							/*
							$vv		= "select * from ebay_currency where currency  ='$L_CURRENCYCODE' and user ='$user' ";
							$vv		= $dbcon->execute($vv);
							$vv		= $dbcon->getResultArray($vv);
							$rates	= $vv[0]['rates']?$vv[0]['rates']:1;
							$gross	= $rates * $gross;
*/

							$sql	= "insert into ebay_paypaldetail(gross,fee,net,tid,account,time,user,currency,name,mail) values($gross,$fee,$net,'$tid','$account','$time','$user','$L_CURRENCYCODE','$name','$email')";
							if($dbcon->execute($sql)){
								echo "交易ID：".$tid."  金额：".$gross." 币种：".$type." 汇率:".$sqtrates."<br>";
							}		
						}
					}else{					
						break;
					}
					$sure	= $sure +1;

				}

		}

		

	function checkexit($feetype,$feedate,$itemid){

		

		global $dbcon,$user;

		$status	= 0;

		$sql	= "select * from ebay_fee where feetype='$feetype' and feedate='$feedate' and itemid='$itemid' and user='$user' ";

		$sql	= $dbcon->execute($sql);

		$sql	= $dbcon->getResultArray($sql);

		if(count($sql) == 0){			

			$status		= 1;			

		}else{			

			$status		= 0;

		}

		

		return $status;

	}

	

	function getebayfees($startdate,$enddate,$token,$account){

	



	 global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$user,$dbcon,$nowtime,$Sordersn,$mctime;

		 $verb = 'GetAccount';

	 

	 

		echo "cccccccc";

		

	 

	  $pagenumber = 1;

	 do{

	 

			  $requestXmlBody = '<?xml version="1.0" encoding="utf-8"?>

			  <GetAccountRequest xmlns="urn:ebay:apis:eBLBaseComponents">

			  <RequesterCredentials>

			  <eBayAuthToken>'.$token.'</eBayAuthToken>

			  </RequesterCredentials>

			   <DetailLevel>ReturnAll</DetailLevel>

			  <AccountEntrySortType>AccountEntryFeeTypeAscending</AccountEntrySortType>

			  <AccountHistorySelection>BetweenSpecifiedDates</AccountHistorySelection>

			  <BeginDate>'.$startdate.'</BeginDate>

			  <EndDate>'.$enddate.'</EndDate>

			  <Pagination>

			  <EntriesPerPage>199</EntriesPerPage>

			  <PageNumber>'.$pagenumber.'</PageNumber>

			  </Pagination>

			  </GetAccountRequest>';  

			



			$session = new eBaySession($token, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);

			$responseXml = $session->sendHttpRequest($requestXmlBody);

			if(stristr($responseXml, 'HTTP 404') || $responseXml == '')

				die('<P>Error sending request');    

			$responseDoc = new DomDocument();

			$responseDoc->loadXML($responseXml);		

			$data=XML_unserialize($responseXml);				

			@$hasmore		= $data['GetAccountResponse']['HasMoreEntries'];		

			@$data			= $data['GetAccountResponse']['AccountEntries']['AccountEntry'];



		

			for($i=0;$i<count($data);$i++){	

				

				$AType		= $data[$i]['AccountDetailsEntryType'];

				$Description					= $data[$i]['Description'];

				$Date							= $data[$i]['Date'];

				$Date1							= strtotime($Date);

				$Gross							= $data[$i]['GrossDetailAmount'];

				$Title							= $data[$i]['Title'];

				$Title  						= str_replace("'","&acute;",$Title);

				$Title							= str_replace("\"","&quot;",$Title); 

				$ItemID							= $data[$i]['ItemID'];

						

		

				

			

				if(checkexit($AType,$Date,$ItemID)){				



					$sql	 = "insert into ebay_fee(feetype,feetdescription,feedate,feeddate1,feeamount,title,itemid,account,ebay_products_sn,user) ";

					$sql	.= "values('$AType','$Description','$Date','$Date1','$Gross','$Title','$ItemID','$account','$sn','$user')";

				

			

					if($dbcon->execute($sql)){

					

						

							echo $AType. " &nbsp;&nbsp;".$Description."&nbsp;&nbsp;".$Date."&nbsp;".$Gross."&nbsp;".$Title." 添加成功<br>";

					

					}

					

					

				}else{					

					

					

				}

							

			}		

			$pagenumber	++;

			echo $i."   ".$hasmore."<br>";			

			

	}while($hasmore == true);	

		

		

	

	

	

	

	}

	

	

	

	

	function call_ebay($methodName,$nvpStr,$account)

	{

		global $dbcon;

		define('API_ENDPOINT', 		'https://api-3t.paypal.com/nvp');	

		define('USE_PROXY',			FALSE);

		define('PROXY_HOST', 		'127.0.0.1');

		define('PROXY_PORT', 		'808');		

		define('PAYPAL_URL', 		'https://www.paypal.com/webscr&cmd=_express-checkout&token=');		

		define('VERSION', 			'57.0');

		$API_Endpoint 				=API_ENDPOINT;

		$version					=VERSION;		

		$sql			= "select * from ebay_paypal where account='$account'";
		$sql			= $dbcon->execute($sql);
		$sql			= $dbcon->getResultArray($sql);	
		
		if(count($sql) == 0 ) return;
		

		$API_UserName	= $sql[0]['name'];
		$API_Password	= $sql[0]['pass'];
		$API_Signature	= $sql[0]['signature'];	

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL,$API_Endpoint);

		curl_setopt($ch, CURLOPT_VERBOSE, 1);

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

		curl_setopt($ch, CURLOPT_POST, 1);

		if(USE_PROXY)

		curl_setopt ($ch, CURLOPT_PROXY, PROXY_HOST.":".PROXY_PORT); 

		$nvpreq="METHOD=".urlencode($methodName)."&VERSION=".urlencode($version)."&PWD=".urlencode($API_Password)."&USER=".urlencode($API_UserName)."&SIGNATURE=".urlencode($API_Signature).$nvpStr;

		curl_setopt($ch,CURLOPT_POSTFIELDS,$nvpreq);

		$response = curl_exec($ch);

		$nvpResArray=deformatNVP($response);

		$nvpReqArray=deformatNVP($nvpreq);

		$_SESSION['nvpReqArray']=$nvpReqArray;

		if (curl_errno($ch)) {

			$_SESSION['curl_error_no']=curl_errno($ch) ;

			$_SESSION['curl_error_msg']=curl_error($ch);

		}else{

			curl_close($ch);

		}

			return $nvpResArray;

	}
	
	function getordersn($ebayaccount){
	
		global $dbcon,$nowd,$user;
		
		$ss			= "select * from ebay_rand where time='$nowd' and ebay_user ='$user' order by id desc ";
		$ss			= $dbcon->execute($ss);
		$ss			= $dbcon->getResultArray($ss);
		if(count($ss) == 0){
			$value		= 1;
		}else{
			$value		= $ss[0]['value'];
			$value		= $value +1;
		}
		$sql		= "insert into ebay_rand(time,value,ebay_account,ebay_user) values('$nowd','$value','$ebayaccount','$user')";
		$dbcon->execute($sql);
		return $value;
	}

	

	

	function deformatNVP($nvpstr)

	{

		$intial=0;

		$nvpArray = array();	

		while(strlen($nvpstr)){				

			$keypos= strpos($nvpstr,'=');		

			$valuepos = strpos($nvpstr,'&') ? strpos($nvpstr,'&'): strlen($nvpstr);		

			$keyval=substr($nvpstr,$intial,$keypos);

			$valval=substr($nvpstr,$keypos+1,$valuepos-$keypos-1);				

			$nvpArray[urldecode($keyval)] =urldecode( $valval);

			$nvpstr=substr($nvpstr,$valuepos+1,strlen($nvpstr));

		}

		return $nvpArray;

	}		

	function getgoodsstatus($id){
		global $dbcon;
		if($id){
		$sql = "select status from ebay_goodsstatus where id = $id";
		$sql			= $dbcon->execute($sql);
		$sql			= $dbcon->getResultArray($sql);
		return $sql[0]['status'];
		}else{
			return '';
		}
	}

?>