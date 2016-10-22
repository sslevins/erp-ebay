<?php

include "include/config.php";

	$ss		= "select * from ebay_config WHERE `ebay_user` ='$user' LIMIT 1";
	$ss		= $dbcon->execute($ss);
	$ss		= $dbcon->getResultArray($ss);
	$onstock					    = $ss[0]['onstock'];
	$overtock						= $ss[0]['overtock'];



	if($onstock <= 0 && $overtock <= 0){
		echo '<br> 程序运行结束，因为您没有设置 无库存和有库存对应的订单分类。<br>系统管理->系统配置中设置';
		die();
	}
	

	$chooseType=$_REQUEST['chooseType'];
	if($chooseType!='')
	{
	
	$sql2="select ebay_id,ebay_ordersn,ebay_warehouse from ebay_order as a where ebay_user = '$user' and ebay_status='$chooseType' and ebay_combine!='1' and ($ebayacc)";



	$sql2=$dbcon->execute($sql2);
	$sql2=$dbcon->getResultArray($sql2);

	$check=0;                //当check=0时,物品出库,当check=1时,物品缺货
	for($i=0;$i<count($sql2);$i++){
	
	
                $ebay_ordersn	= $sql2[$i]['ebay_ordersn'];
				$ebay_id		= $sql2[$i]['ebay_id'];
				$storeid		= $sql2[$i]['ebay_warehouse'];

				$sql3="select sku,sum(ebay_amount) as c from ebay_orderdetail where ebay_ordersn = '$ebay_ordersn' group by sku";
				$sql3=$dbcon->execute($sql3);
				$sql3=$dbcon->getResultArray($sql3);

			    for($a=0;$a<count($sql3);$a++){
				$goods_amount		= $sql3[$a]['c'];
				$goods_sn			= $sql3[$a]['sku'];
     			$bb				= "SELECT goods_sn FROM ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";   


			  $bb				= $dbcon->execute($bb);
			  $bb				= $dbcon->getResultArray($bb);
			  
			  if(count($bb)==0){

 						$rr			= "select * from ebay_productscombine where ebay_user='$user' and goods_sn='$goods_sn'";   
						$rr			= $dbcon->execute($rr);
						$rr 	 	= $dbcon->getResultArray($rr);
						if(count($rr)==0){

							$check=1;
						
						}else{
				
							$goods_sncombine	= $rr[0]['goods_sncombine'];
							$goods_sncombine    = explode(',',$goods_sncombine);
							
							for($b=0;$b<count($goods_sncombine);$b++){
							
											$pline			= explode('*',$goods_sncombine[$b]);
											
									
											
											$goods_sn		= $pline[0];
											$goods_number	= $pline[1];
											$goods_amount   =$goods_number*$goods_amount;      //订单中货品的数量乘以组合产品中的数量
											
											
											$pp="select b.goods_count from ebay_goods as a join ebay_onhandle as b on a.goods_id = b.goods_id where a.goods_sn='$goods_sn' and b.store_id='$storeid' and a.ebay_user ='$user'";
											
											$pp=$dbcon->execute($pp);
											$pp=$dbcon->getResultArray($pp);
							
											if(count($pp)==0){
												$check=1;
											
												
											}else{
									 
												$goods_count=$pp[0]['goods_count'];

												
												if($goods_count<$goods_amount){
													$check=1;
													
													echo $goods_sn.'**'.$check.'<br>';
													
												}
										   }

											

							}
				              	
						}
      
  }		
  
  else{
							$pp="select b.goods_count from ebay_goods as a join ebay_onhandle as b on a.goods_id = b.goods_id where a.goods_sn='$goods_sn' and b.store_id='$storeid' and a.ebay_user ='$user'";
							
							
			                $pp=$dbcon->execute($pp);
			                $pp=$dbcon->getResultArray($pp);
			                if(count($pp)==0){
								$check=1;
							}else{
			         
			                	$goods_count=$pp[0]['goods_count'];
			                	if($goods_count<$goods_amount){
			                		$check=1;
			                	}
			               }
			}	
			
  
                
}







               if($check==0)
                    {
                    	$sql="update ebay_order set ebay_status='$onstock' where ebay_user='$user' and ebay_id=$ebay_id";
                    	$sql=$dbcon->execute($sql);
                    	addoutorder($ebay_id);						
						$porderstatus		= GetOrderStatusV2f($onstock); /* 取得订单修改之前的状态 */
						$notes				= '订单出库动作,已完成，订单修改后的状态是: ['.$porderstatus.'] 修改人是:'.$truename;
						addordernote($ebay_id,$notes);                    	 
                    	 
                    	
                    }
                    else{
                         $sql="update ebay_order set ebay_status='$overtock' where ebay_user='$user' and ebay_id=$ebay_id";	
                         $sql=$dbcon->execute($sql);
                    	 $check=0;
						 
						 
						 $porderstatus		= GetOrderStatusV2f($overtock); /* 取得订单修改之前的状态 */
						 $notes				= '订单出库动作，未完成，无库存，订单修改后的状态是: ['.$porderstatus.'] 修改人是:'.$truename;
						 addordernote($ebay_id,$notes);
                   
                    }



}

}



							if($user == 'test'){
							$ss		= "select * from ebay_topmenu where ebay_user='$user' and name != '' and(id ='10' or id ='11' ) ";
							}else{
							$ss		= "select * from ebay_topmenu where ebay_user='$user' and name != '' order by ordernumber";
							}
					
							
 
?>
<style type="text/css">
<!--
.STYLE1 {font-size: 12px}
-->
</style>


<form action="screenorder.php?module=orders" method="post" name="outorder" class="STYLE1">
 选择需要分配库存的订单分类：
   <select name="chooseType" id="chooseType">
                         
                          <?php
							$ss		= $dbcon->execute($ss);
							$ss		= $dbcon->getResultArray($ss);

							for($i=0;$i<count($ss);$i++){
								$ssid		= $ss[$i]['id'];
								$ssname		= $ss[$i]['name'];
							?>
                          <option value="<?php echo $ssid; ?>" ><?php echo $ssname; ?></option>
                          <?php } ?>
 </select>
 <input name="submit" type="submit" value="提交"/>
 </br>
 <br />
 <br />
 <br />
 <br />
备注： 在系统管理  -&gt; 系统配置中，可以设置订单所对就的库存状态:<br />
<br />
<br />
当订单配货成功，有库存时，转入用户自定义的状态中。<br />
<br /> 
当订单无库存时，转入用户定义的无库存状态。
</form>
