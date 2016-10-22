<?php
include "include/config.php";


	
	$bill		= $_REQUEST['id'];
	$bill		= explode(',',$bill);
	
	for($i=0;$i<count($bill);$i++){
		
		$id		= $bill[$i];
		
		if($id != ''){
			$ss		= "select * from ebay_list where id='$id' ";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			
			$ebay_account		= $ss[0]['ebay_account'];
			$ItemID				= $ss[0]['ItemID'];
			$status				= EndItem($ebay_account,$ItemID,$id);
			echo $status;
		}
	
	
	}
	
	
	
	
	
?>


