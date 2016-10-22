<?php 
include "include/config.php";
$ordersn	= explode(",",$_REQUEST['ordersn']);


 ?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #F8F9FA;
}
-->
</style>


   <?php
			
			$orders	= array();
			for($i=0;$i<count($ordersn);$i++){
				$sn		= $ordersn[$i];
				if($sn	!= ""){					
					$orders[]	= $sn;
				}		
			}
			
			
			if(count($orders)<2){
				
				echo "订单数量错误";
			
			
			}else{
				
				$firstorder	= $orders[0];
				$combineorder = "";
				
			
				echo "合并到当前订单号为：".$firstorder."    $url<br>";
				
				for($i=1;$i<count($orders);$i++){
				
					
					$ordersn	= $orders[$i];
					$sql	= "select * from ebay_orderdetail where ebay_ordersn='$ordersn'";
					$sql	= $dbcon->execute($sql);
					$sql	= $dbcon->getResultArray($sql);
				
					
					for($q=0;$q<count($sql);$q++){					
						
						$tname		= $sql[$q]['ebay_itemtitle']?$sql[$q]['ebay_itemtitle']:"";
						$tprice		= $sql[$q]['ebay_itemprice']?$sql[$q]['ebay_itemprice']:"";
						$tqty		= $sql[$q]['ebay_amount']?$sql[$q]['ebay_amount']:"";	
						$tsku		= $sql[$q]['sku']?$sql[$q]['sku']:"";	
						$titemid	= $sql[$q]['ebay_itemid']?$sql[$q]['ebay_itemid']:"";
						$ebay_itemurl	= $sql[$q]['ebay_itemurl'];
						
											
						$sq		 = "insert into ebay_orderdetail(ebay_ordersn,ebay_itemtitle,ebay_itemprice,ebay_amount,sku,ebay_itemid,ebay_itemurl) values('$firstorder','$tname','$tprice','$tqty','$tsku','$titemid','$ebay_itemurl')";
						
						
						
						$dbcon->execute($sq);
						
					}
					
					$usql	= "update ebay_order set ebay_combine='1' where ebay_ordersn='$ordersn'";
					if($dbcon->execute($usql)) {
						
						$combineorder	= $combineorder.$ordersn."##";
										
					}		
				}
				
				
				
				$usql	= "update ebay_order set ebay_combine='$combineorder' where ebay_ordersn='$firstorder'";
				if($dbcon->execute($usql)){
					
					echo "以将以下订单号合并成功:<br><br>";
					echo $combineorder;
					
				
				
				}
				
			
			}
		
			
		
		
		
		?>
        
        
        
        
        
        