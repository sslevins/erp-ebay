<?php
include "include/config.php";




			$ebay_ordersn		= $_REQUEST["ebayid"];
			$ertj		= "";
			$orders		= explode(",",$_REQUEST['ebayid']);
			for($g=0;$g<count($orders);$g++){
		
		
				$sn 	=  $orders[$g];
				if($sn != ""){
				
					
					
					$sql			= "update ebay_order set mailstatus='2' where ebay_id='$sn' and ebay_user ='$user'";
					if($dbcon->execute($sql)){
						$status	= " -[<font color='#33CC33'>操作记录: 订单编号: {$sn} 数据保存成功</font>]";
					}else{
					
						$status = " -[<font color='#FF0000'>操作记录: 订单编号: {$sn} 数据保存失败</font>]";
					}
					
					echo $status.'<br>';
		
		
				}
			
			}
			
			
		
		
		

	
?>
