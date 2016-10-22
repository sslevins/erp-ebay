<?php
include "include/config.php";
include "top.php";


/* 
用来统计，缺货订单分类中，是否有缺货的物品，如果有, 则生成 订单列表和对应的子sku的缺货信息列表.


 */
 
 

 if(!in_array("purchase_outstockorder",$cpower)){
 	
	die('无权限，请在系统管理，用户管理中设置');
 }

 
 
 
 if($overtock== '') die('[<font color="#33CC33">未设置缺货订单分类</font>]');
 
	$type	= $_REQUEST['type'];
	if($type == "del"){
		
		$id	 = $_REQUEST['id'];
		$sql = "select io_ordersn from ebay_iostore where id=$id";
		$sql = $dbcon->execute($sql);
		$sql = $dbcon->getResultArray($sql);
		$iosn	= $sql[0]['io_ordersn'];
		$sql1 = "delete from  ebay_iostoredetail where io_ordersn='$iosn' ";
		$sql = "delete from  ebay_iostore where id=$id and ebay_user ='$user' ";
		if($dbcon->execute($sql1) && $dbcon->execute($sql)){
			$status	= " -[<font color='#33CC33'>操作记录: 记录删除成功</font>]";
		}else{
			$status = " -[<font color='#FF0000'>操作记录: 记录删除失败</font>]";
		}
	}else{
		$status = "";
	}
	
	$viewtype				= $_REQUEST['viewtype']?$_REQUEST['viewtype']:0;
	$keys					= trim($_REQUEST['keys']);
	$warehouse				= $_REQUEST['warehouse'];
	$startdate				= $_REQUEST['startdate'];
	$enddate				= $_REQUEST['enddate'];
	
	$kfuser					= $_REQUEST['kfuser'];
	$cguser					= $_REQUEST['cguser'];
	
 ?>
    <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>

<div id="main">
    <div id="content" >
        <table style="width:100%"><tr>
          <td><div class='listViewBody'>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	<td nowrap="nowrap" scope="row" >
  查找：
  <input name="keys" type="text" id="keys" value="<?php echo $keys;?>"  />
  
  付款时间：
	  <input name="startdate" type="text" id="startdate" onClick="WdatePicker()" value="<?php echo $startdate;?>"  style="width:70px" />
	  ~
	  <input name="enddate" type="text" id="enddate" onClick="WdatePicker()" value="<?php echo $enddate;?>" style="width:70px" />
	  <select name="viewtype" id="viewtype">
        <option value="0" <?php if($viewtype == '0') echo 'selected="selected"';?>>单据表</option>
        <option value="1" <?php if($viewtype == '1') echo 'selected="selected"';?>>SKU汇总表</option>
        <option value="2" <?php if($viewtype == '2') echo 'selected="selected"';?>>SKU明细表</option>

      </select>   


      <select name="warehouse" id="warehouse">
  <option value="" selected="selected" >仓库</option>
  <?php 
							
							$sql = "select id,store_name from  ebay_store where ebay_user='$user'";									
							$sql = $dbcon->execute($sql);
							$sql = $dbcon->getResultArray($sql);
							for($i=0;$i<count($sql);$i++){
								$id					= $sql[$i]['id'];
								$store_name			= $sql[$i]['store_name'];	
							?>
  <option value="<?php echo $id;?>" <?php if($warehouse == $id) echo 'selected="selected"';?>><?php echo $store_name; ?></option>
  <?php }  ?>
</select>
      <select name="kfuser" id="kfuser">
      
       <option value="" selected="selected"  >产品开发人员</option>
       
        <?php
							$ss		= "select username from ebay_user   where user ='$user' ";
							$ss		= $dbcon->execute($ss);
							$ss		= $dbcon->getResultArray($ss);
							for($i=0;$i<count($ss); $i++){
											$usernames	= $ss[$i]['username'];
							?>
        <option value="<?php echo $usernames;?>" <?php if($kfuser == $usernames) echo 'selected="selected"'; ?>><?php echo $usernames;?></option>
        <?php
							}
							 ?>
      </select>
      <select name="cguser" id="cguser">
       <option value="" selected="selected"  >采购人员</option>
       
        <?php
							$ss		= "select username from ebay_user   where user ='$user' and username != '' ";
							$ss		= $dbcon->execute($ss);
							$ss		= $dbcon->getResultArray($ss);
							for($i=0;$i<count($ss); $i++){
											$usernames	= $ss[$i]['username'];
							?>
        <option value="<?php echo $usernames;?>" <?php if($cguser == $usernames) echo 'selected="selected"'; ?>><?php echo $usernames;?></option>
        <?php
							}
							 ?>
      </select>
&nbsp;&nbsp;
<input type="button" value="查找" onclick="searchorder()" />
<br />
<br />
按照SKU 信息汇总后可直接加入采购计划列表中</td>
</tr>
</table>
 

		
   <?php 
				
				if($viewtype == '1'){   // 汇总表
					
					$sql	= "SELECT ebay_id,`ebay_orderinfo_id`,`sku`,`goods_name`,sum(`goods_count`) as goods_count ,`goods_note`,`last_purchaseprice`,`kfuser`,`ebay_warehouse` ,`goods_id` FROM `ebay_goods_outstock` as a    where ebay_user ='$user' ";
					if($keys != '') $sql .= " and ( a.ebay_id like '%$keys%' or a.sku like '%$keys%' or a.goods_name like '%$keys%' or a.goods_note like '%$keys%' or a.kfuser like '%$keys%')";		
					if($warehouse > 0 ) $sql .=" and a.ebay_warehouse='$warehouse' ";
					$sql	.= ' group by sku, `ebay_warehouse` ';
					
				}
				
				
				if($viewtype == '0'){   // 缺货订单表
					
					$sql		= "select ebay_id,ebay_paidtime,ebay_userid,ebay_username,ebay_countryname, ebay_carrier,ebay_tracknumber,ebay_warehouse,ebay_ordersn	from ebay_order as a  where ebay_user ='$user' and ebay_status='$overtock' and ebay_combine != '1'  ";
					
					if($keys != '') $sql .= " and ( a.ebay_id like '%$keys%' or a.ebay_userid like '%$keys%' or a.ebay_username like '%$keys%' or a.ebay_countryname like '%$keys%' or a.ebay_carrier like '%$keys%' or a.ebay_tracknumber like '%$keys%' )";
					
					if($startdate !='' && $enddate != ''){
					$st00	= strtotime($startdate." 00:00:00");
					$st11	= strtotime($enddate." 23:59:59");
					$sql	.= " and (a.ebay_paidtime>=$st00 and a.ebay_paidtime<=$st11)";
					}
					if($warehouse > 0 ) $sql .=" and ebay_warehouse='$warehouse' ";
					
					
					/* 清空已经生成的缺货单据表 */
					
					$vvsql		= "delete from ebay_goods_outstock where ebay_user ='$user' ";
					$dbcon->execute($vvsql);
					/* 结束 */
		
					$sql = $dbcon->execute($sql);
					$sql = $dbcon->getResultArray($sql);
					
					
				
					
					for($i=0;$i<count($sql);$i++){
							
							$ebay_ordersn	 = $sql[$i]['ebay_ordersn'];
							$storeid		 = $sql[$i]['ebay_warehouse'];
							$ebay_id		 = $sql[$i]['ebay_id'];
							
							
							
					//		echo '开始检查订单编号:'.$ebay_id.'<br>';
							
							
							$vvsql		    = "select sku,ebay_amount,ebay_id from ebay_orderdetail where ebay_ordersn='$ebay_ordersn' and ebay_user ='$user'";
							$vvsql 			= $dbcon->execute($vvsql);
							$vvsql 			= $dbcon->getResultArray($vvsql);
							for($j=0;$j<count($vvsql);$j++){
							
								$goods_sn			= $vvsql[$j]['sku'];
								$goods_amount		= $vvsql[$j]['ebay_amount'];
								$ebay_orderinfo_id	= $vvsql[$j]['ebay_id'];
								
								
								/* 取得缺货订单中，已经存在对应sku$osql		= "select sum(ebay_amount) as cc from ebay_orderdetail where  sku='$goods_sn' and ebay_user='$user' and ebay_ordersn ='$ebay_ordersn' and ebay_id !=$ebay_orderinfo_id and ebay_status='$overtock' ";的数量 */
									$osql		= "select a.ebay_id,sum(b.ebay_amount) as cc from ebay_order as a join  ebay_orderdetail as b on a.ebay_ordersn = b.ebay_ordersn  where  b.sku='$goods_sn' and a.ebay_user='$user' and a.ebay_status='$overtock' ";
									$osql		=$dbcon->execute($osql);
									$osql		=$dbcon->getResultArray($osql);
									$oscount	= $osql[0]['cc'];

								$bb				= "SELECT goods_sn FROM ebay_goods where goods_sn='$goods_sn' and ebay_user = '$user'";   
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
											
										
											
											$pp				="select goods_count from ebay_onhandle as b where b.goods_sn='$goods_sn' and b.store_id='$storeid' and b.ebay_user ='$user'";
											$pp				=$dbcon->execute($pp);
											$pp				=$dbcon->getResultArray($pp);
											$goods_count	=$pp[0]['goods_count'];
								
											
											$pp="select a.goods_id,a.goods_name,a.goods_note,a.kfuser,a.cguser from ebay_goods as a where a.goods_sn='$goods_sn'  and a.ebay_user ='$user'";
											$pp=$dbcon->execute($pp);
											$pp=$dbcon->getResultArray($pp);
											
											
											$goods_name		=$pp[0]['goods_name'];
											$goods_note		=$pp[0]['goods_note'];
											$kfuser			=$pp[0]['kfuser'];
											$cguser			=$pp[0]['cguser'];
											$goods_id		=$pp[0]['goods_id'];
								
											
									
															
											if(count($pp)==0){
												$check=1;
											//	echo $goods_sn.'**  缺货'.$check.' zh<br>';
												
												$outsql		= "insert into ebay_goods_outstock(ebay_id,ebay_orderinfo_id,sku,goods_name,goods_note,last_purchaseprice,kfuser,ebay_user,goods_count,ebay_warehouse,cguser,goods_id) values('$ebay_id','$ebay_orderinfo_id','$goods_sn','$goods_name','$goods_note','','$kfuser','$user','$goods_amount','$storeid','$cguser','$goods_id')";
												
								
												$dbcon->execute($outsql);
									
									
											}else{									 
												//$goods_count=$pp[0]['goods_count'];
												//$stockused		= GetStockedUsedSKU02($orderstatus03,$goods_sn,$storeid);
												//$goods_amount	= $goods_amount + $stockused;

												
												
												/* end */
												if($goods_count< ($goods_amount + ($oscount * $goods_number))){
													//$check=1;
												//	echo $goods_sn.'**  缺货'.$check.'<br>';
													
													$outsql		= "insert into ebay_goods_outstock(ebay_id,ebay_orderinfo_id,sku,goods_name,goods_note,last_purchaseprice,kfuser,ebay_user,goods_count,ebay_warehouse,cguser,goods_id) values('$ebay_id','$ebay_orderinfo_id','$goods_sn','$goods_name','$goods_note','','$kfuser','$user','$goods_amount','$storeid','$cguser','$goods_id')";
													$dbcon->execute($outsql);
													
													
												//	echo '缺货<br>';
													
												}else{
													
												//	echo '*'.$oscount.'*';
												//	echo '不缺货<br>';
												
												}
										   }
										   }
									}
      
							}else{
							
								
								$pp				="select goods_count from ebay_onhandle as b where b.goods_sn='$goods_sn' and b.store_id='$storeid' and b.ebay_user ='$user'";
							
								$pp				=$dbcon->execute($pp);
								$pp				=$dbcon->getResultArray($pp);
								$goods_count	=$pp[0]['goods_count']?$pp[0]['goods_count']:0;
											

							
							
								$pp="select a.goods_id,a.goods_name,a.goods_note,a.kfuser,a.cguser from ebay_goods as a where a.goods_sn='$goods_sn'  and a.ebay_user ='$user'";
								
						
								$pp=$dbcon->execute($pp);
								$pp=$dbcon->getResultArray($pp);
								
								
								$goods_name		=$pp[0]['goods_name'];
								$goods_note		=$pp[0]['goods_note'];
								$kfuser			=$pp[0]['kfuser'];
								$cguser			=$pp[0]['cguser'];
								$goods_id		=$pp[0]['goods_id'];
									
								if(count($pp)==0){
									$check=1;
							///		echo $goods_sn.'**  缺货'.$check.'<br>';
									
									$outsql		= "insert into ebay_goods_outstock(ebay_id,ebay_orderinfo_id,sku,goods_name,goods_note,last_purchaseprice,kfuser,ebay_user,goods_count,ebay_warehouse,cguser,goods_id) values('$ebay_id','$ebay_orderinfo_id','$goods_sn','$goods_name','$goods_note','','$kfuser','$user','$goods_amount','$storeid','$cguser','$goods_id')";
									$dbcon->execute($outsql);
											
											
								}else{
						 
									
									//$stockused		= GetStockedUsedSKU01($orderstatus03,$goods_sn,$storeid);
									//$goods_amount	= $goods_amount + $stockused;
									
								
									echo $goods_count.'ccc';
									
									echo $goods_amount + $oscount;
									
									

									if($goods_count< ( $goods_amount + $oscount ) ){
										//$check=1;
									//	echo $goods_sn.'**  缺货'.$check.' 占用库存'.$stockused.'<br>';
										$outsqlck	= "select ebay_id from ebay_goods_outstock where ebay_id ='$ebay_id' and ebay_orderinfo_id='$ebay_orderinfo_id' and sku='$goods_sn'";
										$outsqlck	=$dbcon->execute($outsqlck);
										$outsqlck	=$dbcon->getResultArray($outsqlck);
										
								

										if(count($outsqlck) == 0){
											$outsql		= "insert into ebay_goods_outstock(ebay_id,ebay_orderinfo_id,sku,goods_name,goods_note,last_purchaseprice,kfuser,ebay_user,goods_count,ebay_warehouse,cguser,goods_id) values('$ebay_id','$ebay_orderinfo_id','$goods_sn','$goods_name','$goods_note','','$kfuser','$user','$goods_amount','$storeid','$cguser','$goods_id')";
											$dbcon->execute($outsql);
										}
														
										
									}
							   }
							} 

							}
					}
					
					
					
					
					$sql		= "select ebay_id,ebay_paidtime,ebay_userid,ebay_username,ebay_countryname, ebay_carrier,ebay_tracknumber,ebay_warehouse	from ebay_order as a  where ebay_user ='$user' and ebay_status='$overtock' and ebay_combine != '1' ";
					
					if($keys != '') $sql .= " and ( a.ebay_id like '%$keys%' or a.ebay_userid like '%$keys%' or a.ebay_username like '%$keys%' or a.ebay_countryname like '%$keys%' or a.ebay_carrier like '%$keys%' or a.ebay_tracknumber like '%$keys%' )";
					
					if($startdate !='' && $enddate != ''){
					$st00	= strtotime($startdate." 00:00:00");
					$st11	= strtotime($enddate." 23:59:59");
					$sql	.= " and (a.ebay_paidtime>=$st00 and a.ebay_paidtime<=$st11)";
					}
					if($warehouse > 0 ) $sql .=" and ebay_warehouse='$warehouse' ";
					
					
					


				}
				
				if($viewtype == '2'){   // 明细表
				
					
					$sql		= "select  ebay_id,ebay_warehouse, ebay_ordersn	from ebay_order as a  where ebay_user ='$user' and ebay_status='$overtock' ";
					
					if($keys != '') $sql .= " and ( a.ebay_id like '%$keys%' or a.ebay_userid like '%$keys%' or a.ebay_username like '%$keys%' or a.ebay_countryname like '%$keys%' or a.ebay_carrier like '%$keys%' or a.ebay_tracknumber like '%$keys%' )";
					
					
					if($startdate !='' && $enddate != ''){
					$st00	= strtotime($startdate." 00:00:00");
					$st11	= strtotime($enddate." 23:59:59");
					$sql	.= " and (a.ebay_paidtime>=$st00 and a.ebay_paidtime<=$st11)";
					}
					if($warehouse > 0 ) $sql .=" and ebay_warehouse='$warehouse' ";
					
					
					
					$sql	= "select * from ebay_goods_outstock as a  where ebay_user ='$user' ";
					if($keys != '') $sql .= " and ( a.ebay_id like '%$keys%' or a.sku like '%$keys%' or a.goods_name like '%$keys%' or a.goods_note like '%$keys%' or a.kfuser like '%$keys%')";
					if($warehouse > 0 ) $sql .=" and a.ebay_warehouse='$warehouse' ";
					
		
					
					
				}
				
				
		
				
				$query		= $dbcon->query($sql);
				$total		= $dbcon->num_rows($query);
				$totalpages = $total;

				$pageindex  =( isset($_GET['pageindex']) )?$_GET['pageindex']:1;
				$limit = " limit ".($pageindex-1)*$pagesize.",$pagesize";
				$page=new page(array('total'=>$total,'perpage'=>$pagesize));
				$sql = $sql.$limit;
				//echo $sql;
				$sql = $dbcon->execute($sql);
				$sql = $dbcon->getResultArray($sql);
				$totalcost		= 0;
				
				if($viewtype== '0'){
				 ?>
                  <table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='10'>&nbsp;			</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap">序号</th>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>订单编号</div>			</th>
			
					<th scope='col' nowrap="nowrap">发货仓库</th>
					<th scope='col' nowrap="nowrap">付款时间</th>
					<th scope='col' nowrap="nowrap">客户ID</th>
		            <th scope='col' nowrap="nowrap">收件人姓名</th>
                    <th scope='col' nowrap="nowrap">国家</th>
                    <th scope='col' nowrap="nowrap">运输</th>
                    <th scope='col' nowrap="nowrap">业务员</th>
                    <th scope='col' nowrap="nowrap">包装员</th>
                    
                    <?php
						
						for($i=0;$i<count($sql);$i++){
					
						$ebay_id				= $sql[$i]['ebay_id'];
						$ebay_paidtime			= $sql[$i]['ebay_paidtime'];
						$ebay_userid			= $sql[$i]['ebay_userid'];
						$ebay_username			= $sql[$i]['ebay_username'];
						$ebay_countryname		= $sql[$i]['ebay_countryname'];
						$ebay_carrier			= $sql[$i]['ebay_carrier'];
						$ebay_tracknumber		= $sql[$i]['ebay_tracknumber'];
						$ebay_warehouse			= $sql[$i]['ebay_warehouse'];
						
						
						
							$outsqlck	= "select ebay_ordersn from ebay_order where ebay_id ='$ebay_id' ";
							
							
							$outsqlck	=$dbcon->execute($outsqlck);
							$outsqlck	=$dbcon->getResultArray($outsqlck);
							$ebay_ordersn			= $outsqlck[0]['ebay_ordersn'];
			
							
							
						
						
						    $vv = "select store_name from  ebay_store where ebay_user='$user' and id ='$ebay_warehouse'";									
							$vv = $dbcon->execute($vv);
							$vv = $dbcon->getResultArray($vv);
							$warehousename	= $vv[0]['store_name'];
							
					
					
					?>
        </tr>
        
					<tr height='20' class='oddListRowS1'>
					  <td scope='row' align='left' valign="top" ><?php echo $i+1;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><a href="ordermodifive.php?ordersn=<?php echo $ebay_ordersn;?>&module=orders&ostatus=1&action=Modifive Order"  target="_blank"><?php echo $ebay_id;?></a></td>				
						    <td scope='row' align='left' valign="top" ><?php echo $warehousename;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo date('Y-m-d H:i:s',$ebay_paidtime);?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $ebay_userid;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $ebay_username;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $ebay_countryname;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $ebay_carrier;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $operationuser;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $audituser;?></td>
				    </tr>
					
              
              
              
              <?php
			  
			  
			  }
			  ?>
              
		<tr class='pagination'>
		<td colspan='10'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons' align="center"><?    echo '<br><center>'.$page->show(2)."</center>";//输出分页 ?></td>
			  </tr>
			</table>		</td>
	</tr>
</table>
<?php } 

				if($viewtype== '2'){
				 ?>
                  <table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='13'>&nbsp;			</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap">序号</th>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>订单编号</div>			</th>
					<th scope='col' nowrap="nowrap">缺货仓库</th>
					<th scope='col' nowrap="nowrap">SKU</th>
					<th scope='col' nowrap="nowrap">商品名称</th>
					<th scope='col' nowrap="nowrap">备注</th>
		            <th scope='col' nowrap="nowrap">商品数量</th>
                    <th scope='col' nowrap="nowrap">预设进价</th>
                    <th scope='col' nowrap="nowrap">平均价</th>
                    <th scope='col' nowrap="nowrap">最新采购价</th>
        <th scope='col' nowrap="nowrap">开发人员</th>
                    <?php
						
						for($i=0;$i<count($sql);$i++){
					
						$ebay_id				= $sql[$i]['ebay_id'];
						$sku					= $sql[$i]['sku'];
						$goods_name				= $sql[$i]['goods_name'];
						$goods_count			= $sql[$i]['goods_count'];
						$goods_note				= $sql[$i]['goods_note'];
						$last_purchaseprice		= $sql[$i]['last_purchaseprice'];
						$kfuser					= $sql[$i]['kfuser'];
						$ebay_warehouse			= $sql[$i]['ebay_warehouse'];
						
						$dataarray				= GetStockQtyBySku($ebay_warehouse,$sku);
						$goods_cost				= $dataarray[3];
						$purchasearray			= GetPurchasePrice($sku);
						    $vv = "select store_name from  ebay_store where ebay_user='$user' and id ='$ebay_warehouse'";									
							$vv = $dbcon->execute($vv);
							$vv = $dbcon->getResultArray($vv);
							$warehousename	= $vv[0]['store_name'];
							
					
					
					?>
        </tr>
        
					<tr height='20' class='oddListRowS1'>
					  <td scope='row' align='left' valign="top" ><?php echo $i+1;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $ebay_id;?>&nbsp;</td>
                            <td scope='row' align='left' valign="top" ><?php echo $warehousename;?>&nbsp;</td>								
						    <td scope='row' align='left' valign="top" ><a href="productadd.php?sku=<?php echo $sku;?>&module=warehouse&type=view" target="_blank"><?php echo $sku;?></a>&nbsp;</td>
				      <td scope='row' align='left' valign="top" ><?php echo $goods_name;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $last_purchaseprice;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $goods_count;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $goods_cost;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $purchasearray[2];?></td>
						    <td scope='row' align='left' valign="top" ><?php echo $purchasearray[4];?></td>
						    <td scope='row' align='left' valign="top" ><?php echo $kfuser;?>&nbsp;</td>
				    </tr>
					
              
              
              <?php
			  
			  
			  }
			  ?>
              
		<tr class='pagination'>
		<td colspan='13'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons' align="center"><?    echo '<br><center>'.$page->show(2)."</center>";//输出分页 ?></td>
			  </tr>
			</table>		</td>
	</tr>
</table>
<?php } ?>



<?php 

				if($viewtype== '1'){
				 ?>
                 
                 <form name="a" id="a" method="post" action="toxls/newplan.php" target="_blank">
                  <table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='18'>&nbsp;			</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap"><span style="white-space: nowrap;">
					  <input name="ordersn2" type="checkbox" id="ordersn2" value="<?php echo $ordersn;?>" onclick="check_all('ordersn','ordersn')" />
					</span></th>
					<th scope='col' nowrap="nowrap">序号</th>
                    <th scope='col' nowrap="nowrap">操作</th>
					<th scope='col' nowrap="nowrap">仓库</th>
		<th scope='col' nowrap="nowrap">SKU</th>
					<th scope='col' nowrap="nowrap">名称</th>
		<th scope='col' nowrap="nowrap">备注</th>
		            <th scope='col' nowrap="nowrap">实际库存</th>
		            <th scope='col' nowrap="nowrap">可用库存</th>
		            <th scope='col' nowrap="nowrap">下限</th>
        <th scope='col' nowrap="nowrap">7天/销频</th>
        <th scope='col' nowrap="nowrap">15天/销频</th>
          <th scope='col' nowrap="nowrap">30天/销频</th>
        <th scope='col' nowrap="nowrap">订单需求量</th>
					<th scope='col' nowrap="nowrap">计划数量</th>
					<th scope='col' nowrap="nowrap">预定数量</th>
					<th scope='col' nowrap="nowrap">验收量</th>
		  <th scope='col' nowrap="nowrap">异常量</th>
          <th scope='col' nowrap="nowrap">预设价</th>
          <th scope='col' nowrap="nowrap">平均价</th>
                    <th scope='col' nowrap="nowrap">最新采购价</th>
        <?php
						for($i=0;$i<count($sql);$i++){
						$ebay_orderinfo_id				= $sql[$i]['ebay_orderinfo_id'];
						$ebay_id						= $sql[$i]['ebay_id'];
						$sku							= $sql[$i]['sku'];
						$goods_name						= $sql[$i]['goods_name'];
						$goods_count1					= $sql[$i]['goods_count'];
						
						
						$goods_note						= $sql[$i]['goods_note'];
						$last_purchaseprice				= $sql[$i]['last_purchaseprice'];
						$kfuser							= $sql[$i]['kfuser'];
						$ebay_warehouse			= $sql[$i]['ebay_warehouse'];
						$goods_id				= $sql[$i]['goods_id'];
						
						$stockused				= stockused($sku,$ebay_warehouse);
						$plancount				= getPurchaseNumber('Plan',$sku,$ebay_warehouse);
						$Schedulecount			= getPurchaseNumber('Schedule',$sku,$ebay_warehouse);
						$ForAcceptancecount		= getPurchaseNumber('ForAcceptance',$sku,$ebay_warehouse);
						$Aberrantcount			= getPurchaseNumber('Aberrant',$sku,$ebay_warehouse);
						
						
						$vv 					= "select store_name from  ebay_store where ebay_user='$user' and id ='$ebay_warehouse'";									
						$vv 					= $dbcon->execute($vv);
						$vv 					= $dbcon->getResultArray($vv);
						$warehousename			= $vv[0]['store_name'];
						$dataarray				= GetStockQtyBySku($ebay_warehouse,$sku);
						$goods_count			= $dataarray[0];
						$goods_xx				= $dataarray[1];
						$goods_cost				= $dataarray[3];
						
						$purchasearray			= GetPurchasePrice($sku);
						
						$isadd					= $goods_count1-($plancount+$Schedulecount+$ForAcceptancecount)  -  $goods_count;
						
				
						
					?>
        </tr>
        
					<tr height='20' class='oddListRowS1'>
					  <td scope='row' align='left' valign="top" ><input name="ordersn" type="checkbox" id="ordersn" value="<?php echo $sku;?>"   /></td>
					  <td scope='row' align='left' valign="top" ><?php echo $i+1;?>&nbsp;</td>
                       <td scope='row' align='left' valign="top" ><?php if($isadd>0){?><a href="#" onclick="addnewplan('<?php echo $sku;?>')">添加计划</a><?php }else{ echo "添加计划";}?></td>
                      <td scope='row' align='left' valign="top" ><?php echo $warehousename;?>&nbsp;</td>								
						    <td scope='row' align='left' valign="top" ><a href="productadd.php?pid=<?php echo $goods_id;?>&&module=warehouse&action=view" target="_blank"><?php echo $sku;?></a>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $goods_name;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $goods_note;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $goods_count;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $goods_count - $stockused;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $goods_xx;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" >
                            
                            <?php							
									$start1						= date('Y-m-d').'23:59:59';	
						  			$start0						= date('Y-m-d',strtotime("$start1 -7 days")).' 00:00:00';
						  			$qtyarray					= getProductsqtyv3($start0,$start1,$sku,$ebay_warehouse);
									echo $qtyarray[1].' / '.$qtyarray[0];
							?>                            
                            &nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php							
									$start1						= date('Y-m-d').'23:59:59';	
						  			$start0						= date('Y-m-d',strtotime("$start1 -15 days")).' 00:00:00';
						  			$qtyarray							= getProductsqtyv3($start0,$start1,$sku,$ebay_warehouse);
							
									echo $qtyarray[1].' / '.$qtyarray[0];
							?></td>
				      <td scope='row' align='left' valign="top" ><?php							
									$start1						= date('Y-m-d').'23:59:59';	
						  			$start0						= date('Y-m-d',strtotime("$start1 -30 days")).' 00:00:00';
						  			$qtyarray							= getProductsqtyv3($start0,$start1,$sku,$ebay_warehouse);
							
									echo $qtyarray[1].' / '.$qtyarray[0];
							?></td>
				      <td scope='row' align='left' valign="top" ><?php echo $goods_count1;?>&nbsp;</td>
							<td scope='row' align='left' valign="top" ><?php echo $plancount;?>&nbsp;</td>
							<td scope='row' align='left' valign="top" ><?php echo $Schedulecount;?>&nbsp;</td>
							<td scope='row' align='left' valign="top" ><?php echo $ForAcceptancecount;?>&nbsp;</td>
							<td scope='row' align='left' valign="top" ><?php echo $Aberrantcount;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $goods_cost;?>&nbsp;</td>
			                <td scope='row' align='left' valign="top" ><?php echo $purchasearray[2];?></td>
			          <td scope='row' align='left' valign="top" ><?php echo $purchasearray[4];?>&nbsp;</td>
					</tr>
					
              
              
              <?php
			  
			  
			  }
			  ?>
              
		<tr class='pagination'>
		<td colspan='18'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons' align="center"><?    echo '<br><center>'.$page->show(2)."</center>";//输出分页 ?>
				    <input name="addproducts" id="addproducts" type="submit" onclick="return check()"  value="将所有选定订单添加到采购订单" />
				    <input name="totalrecorder" type="hidden" id="totalrecorder" value="<?php echo $i;?>" /></td>
			  </tr>
			</table>		</td>
	</tr>
</table>

</form>
<?php } ?>

    <div class="clear"></div>
<?php

include "bottom.php";


?>
<script language="javascript">
	


	function searchorder(){
	
		var keys	 	= document.getElementById('keys').value;
		var startdate 	= document.getElementById('startdate').value;
		var enddate 	= document.getElementById('enddate').value;
		var warehouse 	= document.getElementById('warehouse').value;
		var viewtype	= document.getElementById('viewtype').value;
		
		var cguser	= document.getElementById('cguser').value;
		var kfuser	= document.getElementById('kfuser').value;
		
		location.href	= 'purchase_outstockorder.php?keys='+keys+"&module=purchase&warehouse="+warehouse+"&startdate="+startdate+"&enddate="+enddate+"&viewtype="+viewtype+"&cguser="+cguser+"&kfuser="+kfuser;
	}
	
	document.onkeydown=function(event){
  	e = event ? event :(window.event ? window.event : null);
  	if(e.keyCode==13){
 	searchorder();
  	}
 	}
	
	function addnewplan(sku){
		var  url	= "toxls/newplan.php?sku="+sku;
		
		openwindow(url,'',500,500);
	}
	
	
	//设定打开窗口并居中
		function openwindow(url,name,iWidth,iHeight)
		{
		var url; //转向网页的地址;
		var name; //网页名称，可为空;
		var iWidth; //弹出窗口的宽度;
		var iHeight; //弹出窗口的高度;
		var iTop = (window.screen.availHeight-30-iHeight)/2; //获得窗口的垂直位置;
		var iLeft = (window.screen.availWidth-10-iWidth)/2; //获得窗口的水平位置;
		window.open(url,name,'height='+iHeight+',,innerHeight='+iHeight+',width='+iWidth+',innerWidth='+iWidth+',top='+iTop+',left='+iLeft+',toolbar=no,menubar=no,scrollbars=auto,resizeable=no,location=no,status=no');
		}
		
		
		function check_all(obj,cName)

{

    var checkboxs = document.getElementsByName(cName);

    for(var i=0;i<checkboxs.length;i++){

		if(checkboxs[i].checked == false){

			

			checkboxs[i].checked = true;

		}else{

			

			checkboxs[i].checked = false;

		}	

		

	}
}
	
	function check(){
				var ii = 0;
				var bill = '';
			 	var checkboxs = document.getElementsByName("ordersn");
				for(var i=0;i<checkboxs.length;i++){
					if(checkboxs[i].checked == false){
					}else{
					bill = bill + ","+checkboxs[i].value;
					ii	= ii+1;
					}	
				}
				if(ii == 0 ){
					alert("请选择产品");
					return false;
				}
				a.totalrecorder.value = bill;
	}
	
</script>