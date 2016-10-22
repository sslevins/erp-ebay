<?php 
include "include/config.php";


	$order		= $_REQUEST['ordersn'];

	$order		= explode(",",$order);
	$type		= $_REQUEST['type'];
	
	for($i=0;$i<count($order);$i++){
	
		
		if($order[$i] != ""){
		
			$sn			= $order[$i];
		
		
			$ss		= "update ebay_order set isprint ='1' where ebay_ordersn ='$sn'";
			
			echo $ss;
			
			
			
			

		
		
		}
	
	}
	


?>
