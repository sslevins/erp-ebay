<?php


	include "include/config.php";
	$ordersn		= $_REQUEST['osn'];
	$order		= explode(",",$ordersn);
	
	
	
	function addoutstock2($ordersn,$ebay_account){

		global $dbcon,$nowtime,$user;
		
		$ss			= "select a.ebay_ordersn,a.ebay_account as tt,a.ebay_account,a.ebay_currency,b.*  from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn = b.ebay_ordersn where a.ebay_ordersn='$ordersn' and a.ebay_combine!='1' AND b.istrue =  '0' and a.ebay_account='$ebay_account'";


		

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
					$sq			.= "`goodsnumber` , `ebay_user` ,`ebay_account`,`goods_category`,`ebay_currency` ) VALUES ('$nowtime', '$goods_id', '$goods_sn', '$goods_name', '$dstr', '$ebay_itemprice', '$instock', '$user','$account','$goods_category','$ebay_currency');";
					
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
	
	
	for($i=0;$i<count($order);$i++){
	
		
		if($order[$i] != ""){
				
				
			$ss					= "select * from ebay_order where ebay_id = '".$order[$i]."'";
			
			$ss				 	= $dbcon->execute($ss);
			$ss					= $dbcon->getResultArray($ss);
			$ebay_account 		= $ss[0]['ebay_account'];
			$ebay_ordersn	 	= $ss[0]['ebay_ordersn'];
			
			echo $ebay_ordersn."成功标记发出";
			
			addoutstock2($ebay_ordersn,$ebay_account);
			
			
		
				
			
		}
		
	}
	


?>