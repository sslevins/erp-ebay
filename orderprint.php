<?php 
include "include/config.php";


	$order		= $_REQUEST['ordersn'];

	$order		= explode(",",$order);
	$type		= $_REQUEST['type'];
	if($type=='add'){
		$types = 1;
	}else{
		$types = 0;
	}
	
	for($i=0;$i<count($order);$i++){
	
		
		if($order[$i] != ""){
		
			$sn			= $order[$i];
		
		
			$ss		= "update ebay_order set isprint ='$types' where ebay_id ='$sn'";
			
			
					if($dbcon->execute($ss)){

	

	

					$status	= " -[<font color='#33CC33'>操作记录: 记录操作成功</font>]";



	}else{

	



					$status = " -[<font color='#FF0000'>操作记录: 记录操作失败</font>]";



	}
echo $status.'<br>';

			
			
			
			

		
		
		}
	
	}
	


?>
