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
				$firstorder				= $orders[0];
				$sql					= "select * from ebay_order where ebay_id='$firstorder'";
				$sql					= $dbcon->execute($sql);
				$sql					= $dbcon->getResultArray($sql);
				$firstorder		    		=  $sql[0]['ebay_ordersn'];
				$ebay_notes					=  $sql[0]['ebay_note'];
				$ebay_noteb					=  $sql[0]['ebay_noteb'];
				$ebay_account				=  $sql[0]['ebay_account'];
				$ebay_userid				=  $sql[0]['ebay_userid'];
				$ebay_username			= mysql_escape_string($sql[0]['ebay_username']);
				$ebay_street			= mysql_escape_string($sql[0]['ebay_street']);
				$ebay_city				= mysql_escape_string($sql[0]['ebay_city']);
				$ebay_state				= mysql_escape_string($sql[0]['ebay_state']);
				$ebay_countryname		= $sql[0]['ebay_countryname'];
				$ebay_account			= $sql[0]['ebay_account'];
				$ebay_warehouse			= $sql[0]['ebay_warehouse'];
				
			
				$combineorder = "";
				echo "合并到当前订单号为：".$firstorder."    $url<br>";
				$totalprice	= 0;
				$totalship	= 0;

				for($i=1;$i<count($orders);$i++){

					$ordersn	= $orders[$i];
					$sql	= "select ebay_id,ebay_ordersn,ebay_total,ebay_note,ebay_noteb from ebay_order where ebay_id='$ordersn' and ebay_account ='$ebay_account' and ebay_userid ='$ebay_userid' and ebay_street ='$ebay_street' and ebay_username='$ebay_username' and  ebay_city='$ebay_city' and ebay_state='$ebay_state'  and ebay_combine ='0' ";
					
					
			
					

					
					$sql	= $dbcon->execute($sql);
					$sql	= $dbcon->getResultArray($sql);
					
					if(count($sql) > 0){
					
 					$sordersn		    	=  $sql[0]['ebay_ordersn'];
					$ebay_total		    	=  $sql[0]['ebay_total']?$sql[0]['ebay_total']:0;
					$ebay_shipfee		    =  $sql[0]['ebay_shipfee']?$sql[0]['ebay_shipfee']:0;
					
					$totalprice				+= $ebay_total;
					$totalship				+= $ebay_shipfee;
					
					$ebay_notes				.=  $sql[0]['ebay_note'];
					$ebay_noteb				.=   $sql[0]['ebay_noteb'];
					$sql	= "select * from ebay_orderdetail where ebay_ordersn='$sordersn'";
					$sql	= $dbcon->execute($sql);
					$sql	= $dbcon->getResultArray($sql);
					
					if(count($sql) == 0) return;

					for($q=0;$q<count($sql);$q++){					
						$tname		= mysql_escape_string($sql[$q]['ebay_itemtitle']);
						$tprice		= $sql[$q]['ebay_itemprice']?$sql[$q]['ebay_itemprice']:"";
						$tqty		= $sql[$q]['ebay_amount']?$sql[$q]['ebay_amount']:"";	
						$tsku		= $sql[$q]['sku']?$sql[$q]['sku']:"";	
						$titemid	= $sql[$q]['ebay_itemid']?$sql[$q]['ebay_itemid']:"";
$shipingfee	= $sql[$q]['shipingfee']?$sql[$q]['shipingfee']:"";
						$ebay_itemurl	= $sql[$q]['ebay_itemurl'];
						$attribute	= mysql_escape_string($sql[$q]['attribute']);
						$notes			= $sql[$q]['notes'];
						$recordnumber	= $sql[$q]['recordnumber'];
						$ebay_tid		= $sql[$q]['ebay_tid'];
						$FinalValueFee		= $sql[$q]['FinalValueFee'];
						$ebay_account		= $sql[$q]['ebay_account'];
						$FeeOrCreditAmount		= $sql[$q]['FeeOrCreditAmount'];
						
						$sq		 = "insert into ebay_orderdetail(ebay_ordersn,ebay_itemtitle,ebay_itemprice,ebay_amount,sku,ebay_itemid,ebay_itemurl,attribute,recordnumber,FinalValueFee,shipingfee,ebay_account,ebay_user,FeeOrCreditAmount) values('$firstorder','$tname','$tprice','$tqty','$tsku','$titemid','$ebay_itemurl','$attribute','$recordnumber','$FinalValueFee','$shipingfee','$ebay_account','$user','$FeeOrCreditAmount')";
						if($dbcon->execute($sq)){
						}else{
							echo "<font color=red>合并插入物品失败，请与管理员联系<br></font>";
						}
						
						
						
					}

					$usql	= "update ebay_order set ebay_combine='1',ebay_status='8888' where ebay_id='$ordersn'";
					if($dbcon->execute($usql)) {
						$combineorder	= $combineorder.$ordersn."##";
					}	
					
					
					}else{
					
					
					
					die('不符合条件');
					
					
					}	
				}

				

				

				
				$ebay_notes		= str_rep($ebay_notes);
				$usql	= "update ebay_order set ebay_combine='$combineorder',ebay_total=ebay_total+$totalprice,ebay_shipfee=ebay_shipfee+$totalship,ebay_note = '$ebay_notes',ebay_noteb ='$ebay_noteb' where ebay_ordersn='$firstorder' and ebay_user ='$user' ";
				if($dbcon->execute($usql)){
					echo "以将以下订单号合并成功:<br><br>";
					echo $combineorder;
				}

				

			

			}

		

			

		

		
		
		

		?>

        

        

        

        

        

        