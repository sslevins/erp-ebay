<?php
include "include/config.php";


include "top.php";




	

 ?>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo '系统配置'.$status;?></h2>
</div>
 
<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 <input name="hiddenuserid" type="hidden" value="" id="hiddenuserid" />
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
		
	<td nowrap="nowrap" scope="row" >&nbsp;</td>
	</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td width="26%">
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'>			
                      <form id="form" name="form" method="post" action="purchasemrprun.php?module=purchase&action=采购收货">
                  <table width="73%" border="0" align="center" cellspacing="0" class="left_txt">
                    <tr>
                      <td colspan="2">备注：<br />
                      <br />
                      由系统自动根椐产品实际库存情况，自动生成建议采购订单，生成条件有：<br />
                      <br />
                      1. 所有物品资料状态为上线的订单。<br />
                      2. 实际库存数量是小于  库存报警天数 。<br />
                      3. 第二点中的实际库存数量，包括已订购的数量(避免重复生成采购订单)，也就是已经生成采购订单，但未入库的采购单。<br />
                      4. 相同供应商的产品，生成在同一采购订单中(前提是，必须有在货品资料中设置好对应的货品供应商)。<br />
                      5. 所有由系统运算的生成的采购订单，在备注中已自动加上MRP运算生成。<br />
                      6. 生成的采购数量等于平均每天的销量*采购天数。<br />
                      7. 未设置供应供应商的产品将不能生成建议采购订单。<br /></td>
                    </tr>
                    <tr>
                      <td width="35%"><input name="submit" type="submit" value="开始生成"  /></td>
                      <td width="65%">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2">&nbsp;</td>
                      </tr>
                  </table>
                  </form>
					  <table width="73%" border="0" align="center" cellspacing="0" class="left_txt">
                        <tr>
                          <td width="100%" colspan="2">
                          
                          <?php
						  
						  
						  
						  if($_POST['submit']){
						  
				
							$dataarray	= array();
								$hh			= 0;
								
							
							$sql		= "select a.factory,a.goods_id,a.goods_sn,a.goods_name,b.goods_count from ebay_goods as a join  ebay_onhandle as b ON a.goods_id = b.goods_id where a.ebay_user='$user'";
							$sql		= $dbcon->execute($sql);
							$sql		= $dbcon->getResultArray($sql);
							
		
							
							
							for($i=0;$i<count($sql);$i++){
								
								$factory		= $sql[$i]['factory'];
								$goods_sx		= $sql[$i]['goods_sx'];
								$goods_id		= $sql[$i]['goods_id'];
								$goods_sn		= $sql[$i]['goods_sn'];
								$goods_name		= $sql[$i]['goods_name'];
								$goods_count	= $sql[$i]['goods_count']?$sql[$i]['goods_count']:0;
								$sqr	 		= "select store_name,id from ebay_store where ebay_user='$user'";
								$sqr			= $dbcon->execute($sqr);
								$sqr			= $dbcon->getResultArray($sqr);
								$strline	= '';
								for($e=0;$e<count($sqr);$e++){					
								 
									$store_name	= $sqr[$e]['store_name'];
									$storeid	= $sqr[$e]['id'];
									$seq				= "select goods_count,goods_days,purchasedays from ebay_onhandle where goods_sn='$goods_sn' and store_id='$storeid' and goods_id='$goods_id'";
									$seq				= $dbcon->execute($seq);
									$seq				= $dbcon->getResultArray($seq);
									$goods_count			= $seq[0]['goods_count']?$seq[0]['goods_count']:0;
									$goods_days				= $seq[0]['goods_days'];	
									$purchasedays				= $seq[0]['purchasedays']?$seq[0]['purchasedays']:1;	// 需要采购的天数数量
									/* 检查这个产品最早售出的时间 */
									
									$gg					= "select ebay_paidtime from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn = b.ebay_ordersn where b.sku='$goods_sn' order by a.ebay_id asc ";
									$gg					= $dbcon->execute($gg);
									$gg					= $dbcon->getResultArray($gg);
									
									if(count($gg) > 0){
									
										/* 如果days 是小于或等于30的话，统一按/每天的销量 */
										$ebay_paidtime		= $gg[0]['ebay_paidtime'];
										$time3 = $mctime - $ebay_paidtime;
										$day = floor($time3/(3600*24));
									//	echo '最近： '.$day.'天，平均每天销量是:';

										
										if($day < 30 ){    // 如果小于30 的，按取得小于30 天内的总销量，在除以指定的天数
											
											if($day == 0) $day = 1;
											$start1						= date('Y-m-d').'23:59:59';	
											$start0						= date('Y-m-d',strtotime("$start1 -$day days")).' 00:00:00';
											$qty0						= getProductsqty($start0,$start1,$goods_sn,$storeid)/$day;
											$stockused					= stockbookused($goods_sn,$storeid);					  //  取得已经预订的产品数量
											
											$needqty					= ceil($qty0 * $goods_days);  // 计算产品库存报警数量
											$goods_count				= $goods_count + $stockused;
											
											
											/*  如何实际库存,小于或等于预jin库存时,是生成采购订单 */
											 if($goods_count < $needqty && $factory != '' ){
												 $dataarray[$hh]['goods_sn']		= $goods_sn;
												 $dataarray[$hh]['factory']			= $factory;
												 $dataarray[$hh]['cgqty']			= $qty0 * $purchasedays;
												 $dataarray[$hh]['storeid']			= $storeid;
												  
												 $hh++;
											 }
											 
											
										
										}else{
										
											 $start1						= date('Y-m-d').'23:59:59';	
											 $start0						= date('Y-m-d H:i:s',strtotime("$start1 -7 days"));
											 $qty0							= (getProductsqty($start0,$start1,$goods_sn,$storeid)/7)*$days7;
											 
											 
											 $start1						= date('Y-m-d').'23:59:59';	
											 $start0						= date('Y-m-d H:i:s',strtotime("$start1 -15 days"));
											 $qty1							= (getProductsqty($start0,$start1,$goods_sn,$storeid)/15)*$days15;
											 
											 $start1						= date('Y-m-d').'23:59:59';	
											 $start0						= date('Y-m-d H:i:s',strtotime("$start1 -30 days"));
											 $qty2							= (getProductsqty($start0,$start1,$goods_sn,$storeid)/30)*$days30;
											 
											 $totalqty						= $qty0 + $qty1 + $qty2;  // 平均每天的销量
									
											  
											 //$stockused	= stockbookused($goods_sn);					  //  取得已经预订的产品数量
											 
											 $stockused					= stockbookused($goods_sn,$storeid);					  //  取得已经预订的产品数量
											 
											  
											 $needqty						= ceil($totalqty * $goods_days);  // 计算产品库存报警数量
								 			 $goods_count					= $goods_count + $stockused;
											 /*  如何实际库存,小于或等于预jin库存时,是生成采购订单 */
											 if($goods_count < $needqty && $factory != '' ){
												
												 $dataarray[$hh]['goods_sn']		= $goods_sn;
												 $dataarray[$hh]['factory']			= $factory;
												 $dataarray[$hh]['cgqty']			= $totalqty * $purchasedays;
												 $dataarray[$hh]['storeid']			= $storeid;
												 
												 $hh++;
												 
											 }
									 
									 
										
										
										
										}
										
									}
									
						
						  
							}
				
					
			  
						  
						  }
						  
						  }
						  
		
		
						  
						  
					
						  
						  
						  /* 开始生成建议采购订单 */
					
						  
						  for($i=0;$i<count($dataarray);$i++){
						  
						  		
								$goods_sn			= $dataarray[$i]['goods_sn'];
								$factory			= $dataarray[$i]['factory'];
								$cgqty				= $dataarray[$i]['cgqty'];
								$storeid			= $dataarray[$i]['storeid'];
								
								
								$sql	 = "SELECT company_name FROM `ebay_partner` where id='$factory' ";
								$sql	 = $dbcon->execute($sql);
								$sql	 = $dbcon->getResultArray($sql);
								$factory = $sql[0]['company_name'];
								
								if($factory != ''){
									
									
								
									$ss		= "select id from   ebay_iostore where io_partner ='$factory' and type ='2' and io_status	='0' and io_warehouse ='$storeid'";
									$ss	 	= $dbcon->execute($ss);
									$ss	 	= $dbcon->getResultArray($ss);
									if(count($ss) == 0){
									
										
										$io_ordersn	= "IO-".date('Y')."-".date('m')."-".date('d')."-".date("H").date('i').date('s'). mt_rand(100, 999);
										$sql	= "insert into ebay_iostore(io_ordersn,io_addtime,io_warehouse,io_type,io_status,io_note,ebay_user,type,operationuser,io_user,io_paymentmethod,io_partner,io_purchaseuser,partner,deliverytime) values('$io_ordersn','$mctime','$storeid','$in_type','0','MRP运算生成','$user','2','$truename','$truename','货到付款','$factory','$truename','$factory','$deliverytime')";
										
										if($dbcon->execute($sql)){
											
											
											
											$sql			= "select goods_name,goods_sn,goods_cost,goods_unit,goods_id from ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
											$sql			= $dbcon->execute($sql);
											$sql			= $dbcon->getResultArray($sql);
											if(count($sql)  == 0){
												$status .= " -[<font color='#FF0000'>操作记录: 没有产品记录，请添加此产品</font>]";
											}else{
												$goods_name		= $sql[0]['goods_name'];
												$goods_sn		= $sql[0]['goods_sn'];
												$goods_cost		= $sql[0]['goods_cost'];
												$goods_unit		= $sql[0]['goods_unit'];
												$goods_id		= $sql[0]['goods_id'];
												
												$sql		= "insert into ebay_iostoredetail(io_ordersn,goods_name,goods_sn,goods_cost,goods_unit,goods_count,goods_id) values('$io_ordersn','$goods_name','$goods_sn','$goods_cost','$goods_unit','$cgqty','$goods_id')";
												
												if($dbcon->execute($sql)){
													$status	.= " -[<font color='#33CC33'>操作记录: {$goods_sn} 生成成功</font>]";
												}else{
													$status .= " -[<font color='#FF0000'>操作记录: {$goods_sn} 生成失败</font>]";
												}
												echo $status.'<br>';
											}
										}
								
										
									
									}else{
									
										$io_ordersn		= $ss[0]['io_ordersn'];
		
										$sql			= "select  goods_name,goods_sn,goods_cost,goods_unit,goods_id from ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
										$sql			= $dbcon->execute($sql);
										$sql			= $dbcon->getResultArray($sql);
										if(count($sql)  == 0){
											$status .= " -[<font color='#FF0000'>操作记录: 没有产品记录，请添加此产品</font>]";
										}else{
											$goods_name		= $sql[0]['goods_name'];
											$goods_sn		= $sql[0]['goods_sn'];
											$goods_cost		= $sql[0]['goods_cost'];
											$goods_unit		= $sql[0]['goods_unit'];
											$goods_id		= $sql[0]['goods_id'];
											$sql		= "insert into ebay_iostoredetail(io_ordersn,goods_name,goods_sn,goods_cost,goods_unit,goods_count,goods_id) values('$io_ordersn','$goods_name','$goods_sn','$goods_cost','$goods_unit','$cgqty','$goods_id')";
										
											if($dbcon->execute($sql)){
												$status	.= " -[<font color='#33CC33'>操作记录: {$goods_sn} 生成成功</font>]";
											}else{
												$status .= " -[<font color='#FF0000'>操作记录: {$goods_sn} 生成失败</font>]";
											}
											
											echo $status.'<br>';
											
		
											}
									 }
						
									
						
									
									
									
								
								
								
								}
						  
						  
						  
						  }
						  
						  
						  ?>
                          
                          
                          
                          </td>
                        </tr>
                        
                        <tr>
                          <td colspan="2">&nbsp;</td>
                        </tr>
                      </table>
					  <p>&nbsp;</p>
				    <p>&nbsp;</p>
				    <p>&nbsp;</p>
				    <p>&nbsp;</p></td>
			    </tr>
			</table>		</td>
	</tr>

 </table>
