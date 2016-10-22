<?php
include "../include/config.php";
	
	$sku					= $_REQUEST['sku'];
	
	
	/* 检查对应的 缺货物品的sku 是否已经加入采购计划中， */
	$plansql	= "select *  from ebay_goods_newplan where sku ='$sku' and ebay_user='$user'  group by sku, `ebay_warehouse`  ";
	$plansql	=$dbcon->execute($plansql);
	$plansql	=$dbcon->getResultArray($plansql);
	/* end */
	
	
	/* 检查采购计划列表中，当前sku一共登记了多少个数量计划 */
  	$outsqlck		 = "select *  from ebay_goods_outstock  where sku ='$sku' and ebay_user='$user'  group by sku, `ebay_warehouse`  ";
	$outsqlck		=$dbcon->execute($outsqlck);
	$outsqlck		=$dbcon->getResultArray($outsqlck);
	/* end */
	
	$sku				= $outsqlck[0]['sku'];
	$goods_name			= $outsqlck[0]['goods_name'];
	$goods_count		= $outsqlck[0]['goods_count'];		//订货数量
	$ebay_warehouse		= $outsqlck[0]['ebay_warehouse'];
	
	
	/* 取得供应商 */
	
	$ss					= "select factory from ebay_goods where goods_sn ='$sku' and ebay_user ='$user' ";
	$ss					= $dbcon->execute($ss);
	$ss					= $dbcon->getResultArray($ss);
	$factory			= $ss[0]['factory'];




	
	if(count($plansql) <= 0  ){		
	$addsql		= "insert into ebay_goods_newplan(sku,goods_name,unit,ebay_id,ebay_orderinfo_id,ebay_warehouse,goods_count,ebay_user,partner) values('$sku','$goods_name','$unit','$ebay_id','$ebay_orderinfo_id','$ebay_warehouse','$goods_count','$user','$factory')";
	

	
	if($dbcon->execute($addsql)){
				echo "SKU: ".$sku.' 保存成功<br>';
	}else{
				echo "SKU: ".$sku.' 保存失败<br>';
	}
	}
?>
