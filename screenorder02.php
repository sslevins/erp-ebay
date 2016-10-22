<?php

include "include/config.php";


	

	
	if($_POST['submit']){
	
		$orderstatus01		= $_REQUEST['orderstatus01'];
		$orderstatus02		= $_REQUEST['orderstatus02'];
		$orderstatus03		= $_REQUEST['orderstatus03'];
		
		if($orderstatus01 == '') die('您没有选择需要检测的缺货的订单分类');
		if($orderstatus02 == '') die('您没有选择缺货的订单应该转入哪个分类');
		if($orderstatus03 == '') die('您没有设置已经分配好的订单，也就是占用库存的订单');
		
		
		$vvsql		="select ebay_id,ebay_ordersn,ebay_warehouse from ebay_order as a where ebay_user = '$user' and ebay_status='$orderstatus01' and ebay_combine!='1' and ($ebayacc)";	
		$sql2=$dbcon->execute($vvsql);
		$sql2=$dbcon->getResultArray($sql2);
		$check=0;                //当check=0时,物品出库,当check=1时,物品缺货
		
		for($i=0;$i<count($sql2);$i++){

                $ebay_ordersn	= $sql2[$i]['ebay_ordersn'];
				$ebay_id		= $sql2[$i]['ebay_id'];
				echo ($i+1).': 开始检测订单编号:'.$ebay_id.'<br>';

				$check			= 0;

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
											$goods_amount   =$goods_number*$goods_amount;      //订单中货品的数量乘以组合产品中的
											
											$pp="select b.goods_count from ebay_goods as a join ebay_onhandle as b on a.goods_id = b.goods_id where a.goods_sn='$goods_sn' and b.store_id='$storeid' and a.ebay_user ='$user'";											
											$pp=$dbcon->execute($pp);
											$pp=$dbcon->getResultArray($pp);							
											if(count($pp)==0){
												$check=1;
												echo $goods_sn.'**  缺货'.$check.'<br>';
											}else{									 
												$goods_count=$pp[0]['goods_count'];
												$stockused		= GetStockedUsedSKU02($orderstatus03,$goods_sn,$storeid);
												$goods_amount	= $goods_amount + $stockused;

												/* 取得已经占用库存的产品数 */
												if($goods_count<$goods_amount){
													$check=1;
													echo $goods_sn.'**  缺货'.$check.'<br>';
												}
										   }
										   }
				              	
						}
      
				}else{
							$pp="select b.goods_count from ebay_goods as a join ebay_onhandle as b on a.goods_id = b.goods_id where a.goods_sn='$goods_sn' and b.store_id='$storeid' and a.ebay_user ='$user'";
			                $pp=$dbcon->execute($pp);
			                $pp=$dbcon->getResultArray($pp);
			                if(count($pp)==0){
								$check=1;
								echo $goods_sn.'**  缺货'.$check.'<br>';
							}else{
			         
			                	$goods_count	=$pp[0]['goods_count'];
								$stockused		= GetStockedUsedSKU01($orderstatus03,$goods_sn,$storeid);
								$goods_amount	= $goods_amount + $stockused;

			                	if($goods_count<$goods_amount){
			                		$check=1;
									echo $goods_sn.'**  缺货'.$check.' 占用库存'.$stockused.'<br>';
			                	}
			               }
			}               
		}


		if($check == '1'){


						$hsql="update ebay_order set ebay_status='$orderstatus02' where ebay_user='$user' and ebay_id=$ebay_id";
						$hsql=$dbcon->execute($hsql);
						echo "订单编号: ".$ebay_id.' 因缺货 ,转入对应分类中<br>';



		}







		
		
	
	}

	}



	/* 计算sku已经占用库存的SKU数量 */

	function GetStockedUsedSKU01($orderstatus,$goods_sn,$storeid){
			global $dbcon,$user;
			/* 检查此sku是否是组合产品 */
				$gsql			= "SELECT sum(b.ebay_amount) as qty FROM ebay_order AS a JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn WHERE sku =  '$goods_sn' and  b.istrue = '0' and a.ebay_warehouse = '$storeid' and ebay_combine!='1' and a.ebay_status='$orderstatus'";
				$gsql			= $dbcon->execute($gsql);
				$gsql			= $dbcon->getResultArray($gsql);
				$usedqty		=  $gsql[0]['qty']?$gsql[0]['qty']:0;
				return $usedqty;
	}

	

	function GetStockedUsedSKU02($orderstatus,$goods_sn,$storeid){
			global $dbcon,$user;
			/* 检查此sku是否是组合产品 */
	
				
				$vv				= "select * from ebay_productscombine where goods_sncombine	 like '%$goods_sn%' and ebay_user ='$user' ";
				$vv				= $dbcon->execute($vv);
				$vv				= $dbcon->getResultArray($vv);
				$usedqty		= 0;
				
				for($i=0;$i<count($vv);$i++){
					$cgoods_sn			= $vv[$i]['goods_sn']; // => sold 中售出的物品编号，也就是组合产品编号
					$goods_sncombine	= $vv[$i]['goods_sncombine'];   // => 子sku号 和期对应的数量。
					$fxgoods_sncombine	= explode(',',$goods_sncombine);
					
					for($j=0; $j<count($fxgoods_sncombine);$j++){
						
						$fxlaberstr		= 'FF'.$fxgoods_sncombine[$j];
						if(strstr($fxlaberstr,$goods_sn)){
							
							$fxlaberstr01	= explode('*',$fxgoods_sncombine[$j]);						
							$fistamount		= $fxlaberstr01[1];							
							$gsql			= "SELECT sum(b.ebay_amount) as qty FROM ebay_order AS a JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn WHERE sku =  '$cgoods_sn' and  b.istrue = '0' and a.ebay_warehouse = '$storeid' and ebay_combine!='1' and a.ebay_status='$orderstatus' ";
							$gsql			= $dbcon->execute($gsql);
							$gsql			= $dbcon->getResultArray($gsql);
							$usedqty1		=  $gsql[0]['qty']?$gsql[0]['qty']:0;							
							$usedqty		+= $usedqty1 * $fistamount;			
						
						
						}
					
					}				
				}

			 return $usedqty;

	}
	
	
	
	
							
 
?>
<style type="text/css">
<!--
.STYLE1 {font-size: 12px}
-->
</style>


<form action="screenorder02.php?module=orders" method="post" name="outorder" class="STYLE1">
  <p>01. 选择需要检测有库存的订单分类
    <select name="orderstatus01" id="orderstatus01">
      
      <?php
	  						$ss		= "select * from ebay_topmenu where ebay_user='$user' and name != '' order by ordernumber";
							
							if($user == 'test') $ss		= "select * from ebay_topmenu where id=166";
							$ss		= $dbcon->execute($ss);
							$ss		= $dbcon->getResultArray($ss);

							for($i=0;$i<count($ss);$i++){
								$ssid		= $ss[$i]['id'];
								$ssname		= $ss[$i]['name'];
							?>
      <option value="<?php echo $ssid; ?>" ><?php echo $ssname; ?></option>
      <?php } ?>
       </select>
    <br />
    <br />
   02. 当检测对应的订单，无库存后，应该转入
   <select name="orderstatus02" id="orderstatus02">
     <?php
	 
	 						$ss		= "select * from ebay_topmenu where ebay_user='$user' and name != '' order by ordernumber";
							
							if($user == 'test') $ss		= "select * from ebay_topmenu where id=505";
							$ss		= $dbcon->execute($ss);
							$ss		= $dbcon->getResultArray($ss);
							
							
							for($i=0;$i<count($ss);$i++){
								$ssid		= $ss[$i]['id'];
								$ssname		= $ss[$i]['name'];
							?>
     <option value="<?php echo $ssid; ?>" ><?php echo $ssname; ?></option>
     <?php } ?>
   </select>
  </p>
  <p>03. 此分类 中
    <select name="orderstatus03" id="orderstatus03">
      <?php					
	  
	  $ss		= "select * from ebay_topmenu where ebay_user='$user' and name != '' order by ordernumber";
	  if($user == 'test') $ss		= "select * from ebay_topmenu where id=508";
	  $ss		= $dbcon->execute($ss);
							$ss		= $dbcon->getResultArray($ss);
	  
	  
	  
							for($i=0;$i<count($ss);$i++){
								$ssid		= $ss[$i]['id'];
								$ssname		= $ss[$i]['name'];
							?>
      <option value="<?php echo $ssid; ?>" ><?php echo $ssname; ?></option>
      <?php } ?>
    </select>
    的是已经分配的库存订单，也就是已经占用的订单，但没有出库的订单。<br />
    <br />
    <br />
    <input name="submit" type="submit" value="提交"/>
    </br>
    <br />
    <br />
    <br />
    <br />
    <br />
  </p>
</form>
