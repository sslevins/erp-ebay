<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<?php
include "include/config.php";

	
	
	
	$id				= $_REQUEST['id'];
	$goods_count0	= $_REQUEST['goods_count0'];
	$goods_count1	= $_REQUEST['goods_count1'];
	$goods_count2	= $_REQUEST['goods_count2'];
	
	
	$ss			= "select a.io_warehouse,b.goods_sn,b.goods_count,b.stockqty,a.io_ordersn,b.goods_count0,b.goods_count1,b.goods_count2 from ebay_iostore as a join ebay_iostoredetail as b on a.io_ordersn = b.io_ordersn where b.id ='$id'";
	$ss			= $dbcon->execute($ss);
	$ss			= $dbcon->getResultArray($ss);
	
	$io_warehouse		= $ss[0]['io_warehouse'];
	$goods_sn			= $ss[0]['goods_sn'];
	$goods_count		= $ss[0]['goods_count'];
	$io_ordersn			= $ss[0]['io_ordersn'];
	
	$goodscount0			= $ss[0]['goods_count0'];
	$goodscount1			= $ss[0]['goods_count1']; // 已经质检的数量，
	$goodscount2			= $ss[0]['goods_count2'];

	
	$needqty1			= $goodscount0  - $goodscount1;  // 计算还有多少质检数量。
	
	$stockstatus		= 0;
	
	/* 计算本次实际收货，实际收货有可能多，也有可能少， 
	if($goods_count0 != 0 ){
	if($goods_count0 >  $needqty0  ){
		echo '进货数量不对，本次最多可以入: '.$needqty0;
	}else{
		$vv		= "update ebay_iostoredetail set goods_count0 = goods_count0 + '$goods_count0' where id ='$id' ";
		if($dbcon->execute($vv)){			
			echo '操作成功';			
		}else{
			echo '操作失败';
		}
		if($goods_count0 > 0 ) $stockstatus = 1;
	}
	}*/
	
	if($goods_count0 != 0 ){
		$vv		= "update ebay_iostoredetail set goods_count0 = goods_count0 + '$goods_count0' where id ='$id' ";
		if($dbcon->execute($vv)){			
			echo '操作成功: SKU：'.$goods_sn.' 增加收货数量:'.$goods_count0;
					
		}else{
			echo '操作失败';
		}
		if($goods_count0 > 0 ) $stockstatus = 1;
	}
	

	
	if($goods_count1 != 0 && $needqty1 >= 0 ){
	if($goods_count1 > $needqty1  ){
		echo '质检数量不对，请重新检查1';
	}else{
		$vv		= "update ebay_iostoredetail set goods_count1 = goods_count1 + '$goods_count1' where id ='$id' ";
		if($dbcon->execute($vv)){			
			echo '操作成功: SKU：'.$goods_sn.' 增加质检数量:'.$goods_count1;
		}else{
			echo '操作失败';
		}
		if($goods_count1 > 0 ) $stockstatus = 2;
			
	}
	}
	
	echo $goods_count2+$goodscount2;
	
	if($goods_count2 != 0 ){
	if(($goods_count2+$goodscount2) >  $goodscount1 ){   // 如果报保数量大于质检数量则表示失败。
		echo '报损数量不对，请重新检查';
	}else{
		$vv		= "update ebay_iostoredetail set goods_count2 = goods_count2 + '$goods_count2' where id ='$id' ";
		
		if($dbcon->execute($vv)){			
			echo '操作成功: SKU：'.$goods_sn.' 增加质检数量:'.$goods_count2;
		}else{
			echo '操作失败';
		}
	}
	}
	
	if($stockstatus > 0){
		$ddsql		= "update ebay_iostore set stockstatus = '$stockstatus' where io_ordersn ='$io_ordersn'";
		$dbcon->execute($ddsql);
	}
	
	/* 如果已经收到货，则将采购模块中的采购订单转入到未完成中 */
	if($goods_count0 > 0 ) {
		$ddsql		= "update ebay_iostore set io_status = '4' where io_ordersn ='$io_ordersn'";
		$dbcon->execute($ddsql);
	}
	
	
	/* 开始检查采购订单是否已经全部入库 */
	$ss			= "select * from ebay_iostoredetail where io_ordersn ='$io_ordersn'";
	$ss			= $dbcon->execute($ss);
	$ss			= $dbcon->getResultArray($ss);
	
	$status		= 1;
	 
	for($i=0;$i<count($ss);$i++){
		
		$goods_count0			= $ss[$i]['goods_count0'];
		$goods_count1			= $ss[$i]['goods_count1'];
		$goods_count2			= $ss[$i]['goods_count2'];
		
		$goods_count			= $ss[$i]['goods_count'];
		
		$bjqty					= $goods_count1 + $goods_count2;
		

		if($goods_count0 != $bjqty) $status	= 0;  
		if($goods_count2 > 0 ) $status = 0;
	}
	if($status == '1'){
		$ddsql		= "update ebay_iostore set stockstatus = '3', io_status = '2' where io_ordersn ='$io_ordersn'";
		$dbcon->execute($ddsql);
		echo '采购订单已经全部入库完成';
	}
?>
