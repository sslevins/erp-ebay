<?php

	include "include/config.php";
	
	
	$orders		= explode(",",$_REQUEST['bill']);
	
	
	for($g=0;$g<count($orders);$g++){
		$sn 	=  $orders[$g];
		if($sn != ""){
			addBarCode($sn);
		}
		
	}
	
	
	
	
	
	
	
 //将条形码插入数据表中	
function addBarCode($ordersn)	{
	 global $dbcon,$user;
	
	 


    
    //获取条形码
    $qq         ="select code,exist from ebay_barcode where exist='1' and ebay_user='$user' LIMIT 0,1";
    $qq         =$dbcon->execute($qq);
    $qq         =$dbcon->getResultArray($qq);
  if(count($qq)==0){
  	echo  "<script>alert('已经不存在条形码')</script>";
  	return;
  }
  
  
  else{                                         //插入条形码
    $barnumber=$qq[0]['code'];
    
    $ss="update ebay_order set ebay_tracknumber='$barnumber' where ebay_id='$ordersn'"; 
    
    $ss         =$dbcon->execute($ss);	
    
    
    
    //将以使用过的条形码的状态改为0
    $vv="update ebay_barcode set exist=0 where code='$barnumber' ";
    $vv         =$dbcon->execute($vv);
	echo $ordersn.'<font color="green">该订单申请挂号成功 挂号为：'.$barnumber.'</font><br>';
   return;
   
}
}
echo  "<script>alert('申请结束')</script>";
?>