<?php 
include "include/config.php";
	$order		= $_REQUEST['bill'];
	$order		= explode(",",$order);
	for($i=0;$i<count($order);$i++){
	
		if($order[$i] != ""){
			$sn			= $order[$i];
			addoutorder($sn);
		}
	}
?>
