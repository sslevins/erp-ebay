<?php
include "../include/config.php";
	$sku					= $_REQUEST['sku'];
	if($sku != '' )  addp($sku);
	
	
	
	
	if($_POST['addproducts']){
		
		$totalrecorder		= explode(",",$_POST['totalrecorder']);
		for($i=0;$i<count($totalrecorder);$i++){
			
			$sku		= $totalrecorder[$i];
			if($sku != '' ){
			
					 addp($sku);
					 
				
			}
		}
		
		
	
	
	
	
	}
	
	
	
	
	function addp($sku){
		
		global  $dbcon ,$user;
	
		/* 检查对应的 缺货物品的sku 是否已经加入采购计划中， */
	$plansql	= "select *  from ebay_goods_newplan where sku ='$sku' and ebay_user='$user'  group by sku, `ebay_warehouse`  ";
	$plansql	=$dbcon->execute($plansql);
	$plansql	=$dbcon->getResultArray($plansql);
	/* end */

	
	
	/* 检查采购计划列表中，当前sku一共登记了多少个数量计划 */
  	$outsqlck		 = "select sku,goods_name,goods_count,ebay_warehouse,sum(goods_count) as goods_count  from ebay_goods_outstock  where sku ='$sku' and ebay_user='$user'  group by sku, `ebay_warehouse`  ";
	$outsqlck		=$dbcon->execute($outsqlck);
	$outsqlck		=$dbcon->getResultArray($outsqlck);
	/* end */
	
	$sku				= mysql_escape_string($outsqlck[0]['sku']);
	$goods_name			= mysql_escape_string($outsqlck[0]['goods_name']);
	$goods_count		= $outsqlck[0]['goods_count'];		//订货数量
	$ebay_warehouse		= $outsqlck[0]['ebay_warehouse'];
	
	/* 取得供应商 */
	
	$ss					= "select factory,cguser,kfuser,goods_cost from ebay_goods where goods_sn ='$sku' and ebay_user ='$user' ";
	$ss					= $dbcon->execute($ss);
	$ss					= $dbcon->getResultArray($ss);
	$factory			= $ss[0]['factory'];
	$cguser				= $ss[0]['cguser'];
	$kfuser			= $ss[0]['kfuser'];
	$goods_cost			= $ss[0]['goods_cost'];
	
	
	$oversql		= "select overtock from ebay_config WHERE `ebay_user` ='$user' LIMIT 1";
	$oversql					= $dbcon->execute($oversql);
	$oversql					= $dbcon->getResultArray($oversql);
	$overtock		= $oversql[0]['overtock'];
	$ss = "select a.ebay_countryname,b.ebay_amount from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn=b.ebay_ordersn where a.ebay_user ='$user' and a.ebay_status='$overtock' and b.sku='$sku'";
	$ss					= $dbcon->execute($ss);
	$ss					= $dbcon->getResultArray($ss);
	$notes = '';
	$isnotes = 0;
	$allamount = 0;
	foreach($ss as $k=>$v){
		$countryname = $v['ebay_countryname'];
		$amount		= $v['ebay_amount'];
		$vvv = "select note from ebay_skucountrynote where country='$countryname' and sku='$sku' and ebay_user='$user'";
		$vvv			= $dbcon->execute($vvv);
		$vvv			= $dbcon->getResultArray($vvv);
		if(count($vvv)>0){
			$notes .= $vvv[0]['note'].'('.$amount.') ';
			$isnotes = 1;
			$allamount += $amount;
		}
	}
	if($isnotes){
		$notes = '总数:'.$allamount.' '.$notes;
	}
		
	if(count($plansql) <= 0  ){		
	
	
	$addsql		= "insert into ebay_goods_newplan(sku,goods_name,unit,ebay_id,ebay_orderinfo_id,ebay_warehouse,goods_count,ebay_user,partner,cguser,kfuser,notes,purchaseprice) values('$sku','$goods_name','$unit','$ebay_id','$ebay_orderinfo_id','$ebay_warehouse','$goods_count','$user','$factory','$cguser','$kfuser','$notes','$goods_cost')";
	if($dbcon->execute($addsql)){
				echo "SKU: ".$sku.' 保存成功<br>';
	}else{
				echo "SKU: ".$sku.' 保存失败<br>';
	}
	}else{


				echo "<font color=red>SKU: ".$sku.' 已经加入计划列表，请不要重复添加，<br> 可进入-> 新建采购计划表中修改</font><br>';

	}
	
	
	}
?>
