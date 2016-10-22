<?php
include "include/config.php";
include "top.php";	
	/* 修改客户地址 */
	
	$stype	= $_REQUEST['stype'];
	
	
	/* 计算sku已经占用库存的SKU数量 */

	function GetStockedUsedSKU01($orderstatus,$goods_sn,$storeid){
			global $dbcon,$user;
			/* 检查此sku是否是组合产品 */
				$gsql			= "SELECT sum(b.ebay_amount) as qty FROM ebay_order AS a JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn WHERE sku =  '$goods_sn' and  b.istrue = '0' and a.ebay_warehouse = '$storeid' and ebay_combine!='1' and a.ebay_status='$orderstatus'";
				
				
				//echo $gsql.'<br>';
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
	
	
	
	function CheckOrdersStock($backoutoforders,$handleordersstatus){
		global $dbcon,$user;
		
		$distrubitestock		= $backoutoforders;			// 缺货订单
		$onstock				= $handleordersstatus;		// 有库存等待打印订单
		
		
		$vvsql		="select ebay_id,ebay_ordersn,ebay_warehouse from ebay_order as a where ebay_user = '$user' and ebay_status='$distrubitestock' and ebay_combine!='1' ";	
		


		
		$sql2=$dbcon->execute($vvsql);
		$sql2=$dbcon->getResultArray($sql2);
		$check=0;                //当check=0时,物品出库,当check=1时,物品缺货
		
		for($i=0;$i<count($sql2);$i++){

                $ebay_ordersn	= $sql2[$i]['ebay_ordersn'];
				$ebay_id		= $sql2[$i]['ebay_id'];
				$check			= 0;
				
				//echo ($i+1).': 开始检测订单编号:'.$ebay_id.'<br>';
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
											}else{									 
												$goods_count=$pp[0]['goods_count'];
												$stockused		= GetStockedUsedSKU02($onstock,$goods_sn,$storeid);
												$goods_amount	= $goods_amount + $stockused;

												/* 取得已经占用库存的产品数 */
												if($goods_count<$goods_amount){
													$check=1;
												
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
							}else{
			         
			                	$goods_count	=$pp[0]['goods_count'];
								$stockused		= GetStockedUsedSKU01($onstock,$goods_sn,$storeid);
								$goods_amount	= $goods_amount + $stockused;
								//echo $goods_sn.'**  需求量'.$goods_count.' 占用库存'.$goods_amount.'<br>';
			                	if($goods_count<$goods_amount){
			                		$check=1;
			                	}
			               }
			}               
		}
		


		if($check == '0'){
						$hsql="update ebay_order set ebay_status='$onstock' where ebay_user='$user' and ebay_id=$ebay_id";
						//echo $hsql.'<br><br><br><br>';
						$hsql=$dbcon->execute($hsql);
		}
	
	}
		
	
	}
	
	function addoroutstock($io_ordersn,$type,$storeid){
		
		// $type == 0 或为空 表示未审核 $type == B 表示已经审核
		
		global $dbcon,$user;
		$sql		= "select * from ebay_iostoredetail where io_ordersn='$io_ordersn' ";
		$sql			= $dbcon->execute($sql);
		$sql			= $dbcon->getResultArray($sql);
		
		$runstatus 		= 0;
		if($storeid != '' ){
		
		for($i=0;$i<count($sql);$i++){
					
			$id					= $sql[$i]['id'];
			$goods_sn			= $sql[$i]['goods_sn'];
			$goods_count		= $sql[$i]['goods_count'];
			$goods_id 			= $sql[$i]['goods_id'];
			$goods_sn 			= $sql[$i]['goods_sn'];
			$goods_name			= mysql_escape_string($sql[$i]['goods_name']);
		
			$seq				= "select goods_sn from ebay_onhandle where goods_sn='$goods_sn' and store_id='$storeid' and goods_id='$goods_id'";
			$seq				= $dbcon->execute($seq);
			$seq				= $dbcon->getResultArray($seq);
			if(count($seq) == 0){
			
				$sq			= "insert into ebay_onhandle(goods_id,goods_count,store_id,ebay_user,goods_name,goods_sn) values('$goods_id','$goods_count','$storeid','$user','$goods_name','$goods_sn')";
				if(!$dbcon->execute($sq)){
					$status .= " -[<font color='#FF0000'>操作记录: 产品编号:{$goods_sn}入库失败</font>]";
					$runstatus	= 1;
				}
			
			}else{
				
				if($type == 1){
					$sq			= "update ebay_onhandle set goods_count=goods_count+$goods_count where goods_sn='$goods_sn' and store_id='$storeid'  and goods_id='$goods_id'";
				}else{
					$sq			= "update ebay_onhandle set goods_count=goods_count-$goods_count where goods_sn='$goods_sn' and store_id='$storeid'  and goods_id='$goods_id'";
				
				}
				if(!$dbcon->execute($sq)){
				
					$status .= " -[<font color='#FF0000'>操作记录: 产品编号:{$goods_sn}入库失败</font>]";
					$runstatus	= 1;
					
				}
				
			
			}
		
						
			
			
		
		
		}
		
		}else{
		
		
		
		$status .= " -[<font color='#FF0000'>操作记录: 入库失败</font>]";
		$runstatus	= 1;
		
		}
		
		
		
		echo $status;
		return $runstatus;
		
	
	
	}
	
	if($_REQUEST['io_ordersn'] == ""){
	
		$io_ordersn	= "IO-".date('Y')."-".date('m')."-".date('d')."-".date("H").date('i').date('s'). mt_rand(100, 999);
	}else{
		$io_ordersn	= $_REQUEST['io_ordersn'];
	}

	
	/* 产品修改动作 */
	if($_REQUEST['addtype'] == 'mod'){
		$goods_count	= $_REQUEST['goods_count'];
		$goods_cost		= $_REQUEST['goods_cost'];
		$modid			= $_REQUEST['modid'];
		$sql	= "update  ebay_iostoredetail set goods_count='$goods_count',goods_cost ='$goods_cost' where id=$modid";
		if($dbcon->execute($sql)){
			$status	= " -[<font color='#33CC33'>操作记录: 产品修改成功</font>]";
		}else{
			$status = " -[<font color='#FF0000'>操作记录: 产品修改失败</font>]";
		}
	}
	
	/* 产品删除动作 */
	if($_REQUEST['addtype'] == 'del'){
		$id		= $_REQUEST['id'];
		$sql	= "delete from ebay_iostoredetail where id=$id  ";
		if($dbcon->execute($sql)){
			$status	= " -[<font color='#33CC33'>操作记录: 产品删除成功</font>]";
		}else{
			$status = " -[<font color='#FF0000'>操作记录: 产品删除失败</font>]";
		}
	}
	
	if($_REQUEST['addtype'] == 'save'){
		
		$sql			= "select io_ordersn from  ebay_iostore where io_ordersn='$io_ordersn'";
		$sql			= $dbcon->execute($sql);
		$sql			= $dbcon->getResultArray($sql);
		$in_type		= $_REQUEST['in_type'];
		$in_warehouse	= $_REQUEST['in_warehouse'];
		$note			= str_rep($_REQUEST['note']);
		$partner		= str_rep($_REQUEST['partner']);
		$io_user		= $_REQUEST['io_user'];
		$trueusername	= $_SESSION['truename'];
		
		if(count($sql) == 0){
			$sql	= "insert into ebay_iostore(partner,io_ordersn,io_addtime,io_warehouse,io_type,io_status,io_note,ebay_user,type,operationuser,io_user) values('$partner','$io_ordersn','$mctime','$in_warehouse','$in_type','0','$note','$user','0','$trueusername','$io_user')";
		}else{
			$sql	= "update ebay_iostore set io_warehouse='$in_warehouse',io_type='$in_type',io_note='$note',partner='$partner',io_user='$io_user' where io_ordersn='$io_ordersn'";
		}
		if($dbcon->execute($sql)){
			$status	.= " -[<font color='#33CC33'>操作记录:入库单保存成功</font>]";
		}else{
			$status .= " -[<font color='#FF0000'>操作记录: 入库单保存失败</font>]";
		}
		
		/*  添加产品数据 */
		
		
		$goods_sn		= trim($_REQUEST['goods_sn']);
		$goods_count	= $_REQUEST['goods_count'];
		$goods_cost		= $_REQUEST['cost'];
		
		if($goods_sn != '' && $goods_count !='' && $goods_cost != '' ){
		$sql			= "select goods_sn,goods_id,goods_name,goods_unit from ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
		$sql			= $dbcon->execute($sql);
		$sql			= $dbcon->getResultArray($sql);
		if(count($sql)  == 0){
			$status .= " -[<font color='#FF0000'>操作记录: 没有产品记录，请添加此产品</font>]";
		}else{
			$goods_name		= mysql_escape_string($sql[0]['goods_name']);
			$goods_sn		= mysql_escape_string($sql[0]['goods_sn']);
			$goods_unit		= mysql_escape_string($sql[0]['goods_unit']);
			$goods_id		= $sql[0]['goods_id'];
			$sql		= "insert into ebay_iostoredetail(io_ordersn,goods_name,goods_sn,goods_cost,goods_unit,goods_count,goods_id) values('$io_ordersn','$goods_name','$goods_sn','$goods_cost','$goods_unit','$goods_count','$goods_id')";
			if($dbcon->execute($sql)){
				$status	.= " -[<font color='#33CC33'>操作记录: 产品添加成功</font>]";
			}else{
				$status .= " -[<font color='#FF0000'>操作记录: 产品添加失败</font>]";
			}
		}
		
		}
		
		

	
	
	
	}
	
	
	
	
	$sql				= "select * from  ebay_iostore where io_ordersn='$io_ordersn' and ebay_user ='$user'";
	$sql				= $dbcon->execute($sql);
	$sql				= $dbcon->getResultArray($sql);

	$in_type			= $sql[0]['io_type'];
	$in_warehouse		= $sql[0]['io_warehouse'];
	$iistatus			= $sql[0]['io_status'];
	
	if($_REQUEST['addtype'] == 'audit'){
		
		
			$astatus		= $_REQUEST['astatus'];
			
			
			if($in_warehouse == '' ) die('程序内部出错');
			
			if($iistatus != $astatus){
			if($astatus ==0 ){
				
				$runstatus  = addoroutstock($io_ordersn,$astatus,$in_warehouse);
			
			}else if($astatus ==1){
				$runstatus	 = addoroutstock($io_ordersn,$astatus,$in_warehouse);

			}
			
			
			if($runstatus == '0'){
			
				if($astatus ==0 ){
				$esql			= "update ebay_iostore set io_status='$astatus',io_audittime ='',audituser='' where io_ordersn='$io_ordersn'";
				$esql2			= "update ebay_iostoredetail set status ='' where io_ordersn='$io_ordersn'";
				}else if($astatus ==1){
				$esql			= "update ebay_iostore set io_status='$astatus',io_audittime ='$mctime',audituser='$truename' where io_ordersn='$io_ordersn'";
				$esql2			= "update ebay_iostoredetail set status ='B' where io_ordersn='$io_ordersn'";
				}
				
				$dbcon->execute($esql);
				$dbcon->execute($esql2);
				
				$status	= " -[<font color='#33CC33'>操作记录: 单据审核成功</font>]";
				
				
				
				/* 开始检查缺货订单的物品，入库后是否有库存准备打印的。 */
			//	CheckOrdersStock($overtock,$onstock);		
			
			}else{
			
				$status	= " -[<font color='#FF0000'>操作记录: 单据审核失败</font>]";
			}
			}
			
		
	
	}
	

	
		
	
	$sql				= "select * from  ebay_iostore where io_ordersn='$io_ordersn' and ebay_user ='$user'";
	$sql				=  $dbcon->execute($sql);
	$sql				=  $dbcon->getResultArray($sql);
	$isadd				= count($sql);
	$io_user			=  $sql[0]['io_user'];
	$in_type			=  $sql[0]['io_type'];
	$in_warehouse		=  $sql[0]['io_warehouse'];
	$note				=  $sql[0]['io_note'];
	$iistatus			=  $sql[0]['io_status'];
	$partner			=  $sql[0]['partner'];
	$audituser			=  $sql[0]['audituser'];
	$operationuser		=  $sql[0]['operationuser'];
	$audituser			=  $sql[0]['audituser'];
	$io_addtime			=  $sql[0]['io_addtime'];
	if($io_addtime != '') $io_addtime	= date('Y-m-d H:i:s',$io_addtime);
	$io_audittime			=  $sql[0]['io_audittime']?$sql[0]['io_audittime']:'';
	if($io_audittime != '' && $io_audittime != '0') $io_audittime	= date('Y-m-d H:i:s',$io_audittime);
	
		

 ?>
<style type="text/css">
<!--
.STYLE1 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>

<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo '入库单'.$status;?> </h2>
</div>

<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
  <td nowrap="nowrap" scope="row" >
   <?php if($iistatus == '0' || $iistatus == ''){ ?><input name="input" type="button" value="保存单据" onclick="save()" /><?php } ?>
   
   <?php if(in_array("s_i_audit",$cpower)) {?>
   
   <?php if($iistatus == '0' || $iistatus == ''){ ?> <input name="input" type="button" value="审核单据" onclick="audit()"  /> <?php } ?>
   <?php if($iistatus == '1' ){ ?> <input name="input2" type="button" value="反审核单据" onclick="auditf()" /><?php } ?>
   
   <?php } ?>
   
    <input name="input4" type="button" value="打印单据" onclick="printorder()" /></td>
</tr>
<tr>
	
	
	
		
	<td nowrap="nowrap" scope="row" >&nbsp;<br />
	  1.填写基本资料
	  <br />
	  <br />
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
                      <td class="login_txt_bt"><table width="100%" border="1" cellspacing="3" cellpadding="0">
                        <tr>
                          <td width="8%">入库类型</td>
                          <td width="8%"><select name="in_type" id="in_type">
                            <option value="-1" >未设置</option>
                            <?php 
					
					$sql	 = "SELECT ebay_storename,id FROM `ebay_storetype` where ebay_user='$user' and ebay_storetype='0'";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 
					 	$ebay_storename	= $sql[$i]['ebay_storename'];
						$cid			=  $sql[$i]['id'];
					 ?>
                            <option value="<?php echo $cid;?>" <?php if($in_type == $cid) echo "selected=selected" ?>><?php echo $ebay_storename;?></option>
                            <?php } ?>
                          </select></td>
                          <td width="4%">仓库</td>
                          <td width="8%"><select name="in_warehouse" id="in_warehouse">
                            <option value="-1" >未设置</option>
                            <?php 
					
					$sql	 = "select store_name,id from ebay_store where ebay_user='$user'";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 
					 	$store_name	= $sql[$i]['store_name'];
						$cid			=  $sql[$i]['id'];
					 ?>
                            <option value="<?php echo $cid;?>" <?php if($in_warehouse == $cid) echo "selected=selected" ?>><?php echo $store_name;?></option>
                            <?php } ?>
                          </select>
                          (必填)</td>
                          <td colspan="2" rowspan="2">备注
                          <textarea name="note" cols="80" rows="3" id="note" ><?php echo $note;?></textarea></td>
                        </tr>
                        
                        <tr>
                          <td>经办人</td>
                          <td><select name="io_user" id="io_user">
                            <option value="-1" >未设置</option>
                            <?php 
					
					$sql	 = "select username from ebay_user where user='$user'";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 
					 	$iousername	= $sql[$i]['username'];
				
					 ?>
                            <option value="<?php echo $iousername;?>" <?php if($io_user == $iousername) echo "selected=selected" ?>><?php echo $iousername;?></option>
                            <?php } ?>
                          </select></td>
                          <td>单号</td>
                          <td><input name="io_ordersn" type="text" id="io_ordersn" value="<?php echo $io_ordersn;?>" size="30"   style="border-bottom :1 solid black; border-left :none; border-right :none; border-top :none; BACKGROUND: none transparent scroll repeat 0% 0%; "/>
                         </td>
                        </tr>
                </table></td>
              </tr>
                    <tr>
                      <td valign="top" class="left_txt">
                      
                      &nbsp;<br />
                      2.产品资料
                        <input name="input3" type="button" value=" 批量导入" onclick="battchtoxls()" />
                      <br />
                      <br /></td>
              </tr>
                    <tr>
                      <td class="login_txt_bt"><table width="100%" border="1" cellspacing="3" cellpadding="0">
                        <tr>
                          <td>序号</td>
                          <td>产品编号</td>
                          <td>产品名称</td>
                          <td>单位</td>
                          <td>近30天销量</td>
                          <td>近15天销量</td>
                          <td>近7天销量</td>
                          <td>实际库存</td>
                          <td>产品进货成本</td>
                          <td>数量</td>
                          <td>操作</td>
                        </tr>
                        
                        <?php
							
							$sql	= "select goods_sn,goods_name,goods_price,goods_cost,goods_unit,id,goods_count from ebay_iostoredetail where io_ordersn='$io_ordersn'";
						
							$totalprice		= 0;
							$totalqty		= 0;
							$sql	= $dbcon->execute($sql);
							$sql	= $dbcon->getResultArray($sql);
							for($i=0;$i<count($sql);$i++){
								
								$goods_sn			= $sql[$i]['goods_sn'];
								$goods_name 		= $sql[$i]['goods_name'];
								$goods_price 		= $sql[$i]['goods_price'];
								$goods_cost 		= $sql[$i]['goods_cost'];
								$goods_unit 		= $sql[$i]['goods_unit'];
								$id					= $sql[$i]['id'];
								$goods_count  		= $sql[$i]['goods_count'];
								$totalprice			+= ($goods_cost * $goods_count); 
								$totalqty			+= $goods_count;
								
						?>
                        
                        <tr>
                          <td><?php echo $i+1;?>&nbsp;</td>
                          <td><?php echo $goods_sn;?>&nbsp;</td>
                          <td><?php echo $goods_name;?>&nbsp;</td>
                          <td><?php echo $goods_unit;?>&nbsp;</td>
                          <td><?php
						  
						  $start1						= date('Y-m-d').'23:59:59';	
						  $start0						= date('Y-m-d',strtotime("$start1 -30 days")).' 00:00:00';
						  $qty1							= getProductsqty($start0,$start1,$goods_sn,$in_warehouse);
						  echo $qty1;
						  ?>                      &nbsp;</td>
                          <td><?php
						  
						  $start1						= date('Y-m-d').'23:59:59';	
						  $start0						= date('Y-m-d',strtotime("$start1 -15 days")).' 00:00:00';
						  $qty1							= getProductsqty($start0,$start1,$goods_sn,$in_warehouse);
						  echo $qty1;
						  
						  
						  ?>                            &nbsp;</td>
                          <td><?php
						  
						  $start1						= date('Y-m-d').'23:59:59';	
						  $start0						= date('Y-m-d',strtotime("$start1 -7 days")).' 00:00:00';
						  $qty1							= getProductsqty($start0,$start1,$goods_sn,$in_warehouse);
						  echo $qty1;
						  ?>                            &nbsp;</td>
                          <td>
						  
                          <?php
					
								 
					
									
							$seq				= "select goods_count from ebay_onhandle where goods_sn='$goods_sn' and store_id='$in_warehouse' ";
							$seq				= $dbcon->execute($seq);
							$seq				= $dbcon->getResultArray($seq);
							$truestock			= $seq[0]['goods_count']?$seq[0]['goods_count']:0;
							echo $truestock;
							
							?>                          </td>
                          <td>&nbsp;
                          <textarea name="goods_cost<?php echo $id ?>" cols="5" rows="1" id="goods_cost<?php echo $id ?>" ><?php echo $goods_cost;?></textarea></td>
                          <td>&nbsp;
                          <textarea name="goods_count<?php echo $id ?>" cols="6" rows="1" id="goods_count<?php echo $id ?>" ><?php echo $goods_count;?></textarea></td>
                          <td>
                          <?php if($iistatus != 1){ ?>
                          <a href="#" onclick="del('<?php echo $id;?>')">删除</a>&nbsp;&nbsp;
                          <a href="#" onclick="mod('<?php echo $id;?>')">修改</a>                          </td>
                          <?php } } ?>
						</tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td><?php echo $totalprice;?>&nbsp;</td>
                          <td><?php echo $totalqty;?>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="11">产品编号：
                            <input name="goods_sn" type="text" id="goods_sn" />
                          进货成本：
                          <input name="cost" type="text" id="cost" />
                          <input type="button" value="查看历史采购价格" onclick="historyprice()"  />
                          
                          数量：
                          <input name="goods_count" type="text" id="goods_count" />
                          <input type="button" value="添加" onclick="add()" <?php if($iistatus == 1) echo "disabled=\"false\"" ?> /></td>
                        </tr>
            
                      
                      
                      </table></td>
                    </tr>
                    <tr>
                      <td class="left_txt"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><br />
                              3.操作信息<br />
                            <br /></td>
                        </tr>
                        <tr>
                          <td><br />
制单人：
  <input type="text" value="<?php echo $operationuser; ?>" style="border-bottom :1 solid black; border-left :none; border-right :none; border-top :none; BACKGROUND: none transparent scroll repeat 0% 0%; " />
  审核人：
  <input type="text" value="<?php echo $audituser;?>" style="border-bottom :1 solid black; border-left :none; border-right :none; border-top :none; BACKGROUND: none transparent scroll repeat 0% 0%; " />
制作时间：
<input type="text" value="<?php echo $io_addtime;?>" style="border-bottom :1 solid black; border-left :none; border-right :none; border-top :none; BACKGROUND: none transparent scroll repeat 0% 0%; " />
审核时间：
<input type="text" value="<?php echo $io_audittime;?>" style="border-bottom :1 solid black; border-left :none; border-right :none; border-top :none; BACKGROUND: none transparent scroll repeat 0% 0%; "  />
<br /></td>
                        </tr>
                      </table></td>
                    </tr>
          </table></td>
	</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td width="65%">&nbsp;</td>
	</tr>
              
              
              

              
		<tr class='pagination'>
		<td>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'></td>
					</tr>
			</table>		</td>
	</tr></table>


    <div class="clear"></div>
<?php

include "bottom.php";


?>
<script language="javascript">
document.getElementById('goods_sn').focus();
	function printorder(){
	
		var url = 'productinoutprint.php?ordersn=<?php echo $io_ordersn;?>';
		window.open(url);
		
		
	
	
	
	}
	
	function del(id){
	
	
		
		if(confirm("确认删除此条记录吗")){
			
		location.href="instoreadd.php?&module=orders&io_ordersn=<?php echo $io_ordersn;?>&addtype=del&stype=<?php echo $stype;?>&id="+id;
			
			
			
		
		
		}
		
	
	
	}
	
	
	function mod(id){
	
		var goods_cost				= document.getElementById('goods_cost'+id).value;
		var goods_count				= document.getElementById('goods_count'+id).value;
		
		if(confirm("确认修改吗")){
		
		
		var url					= "instoreadd.php?addtype=mod&module=warehouse&io_ordersn=<?php echo $io_ordersn;?>&stype=<?php echo $stype;?>&goods_count="+goods_count+"&goods_cost="+goods_cost+"&modid="+id;
		
		location.href			= url;
		
		
		
		}
		
	
	}
	

	function add(){
		
		
		var in_type				= document.getElementById('in_type').value;
		var in_warehouse		= document.getElementById('in_warehouse').value;
		var note				= document.getElementById('note').value;
		var io_user				= document.getElementById('io_user').value;
		if(in_type <0) {
		alert('请选择入库类型');
		return false
		};
		if(in_warehouse <0) {alert('请选择入库仓库');return false;}
		if(io_user == '') {
		alert('请选择经办人');
		return false
		};
		
		
		
		var goods_sn		= document.getElementById('goods_sn').value;
		var goods_count		= document.getElementById('goods_count').value;
		var cost			= document.getElementById('cost').value;
		
		
		if( goods_sn == ""){
				
				alert("产品编号：不能为空");
				document.getElementById('goods_sn').select();
				return false;		
		}
		
		
		if(isNaN(cost) || cost == ""){
				
				alert("成本:只能输入数字");
				document.getElementById('cost').select();
				return false;		
		}
		

		if(isNaN(goods_count) || goods_count == ""){
				
				alert("数量:只能输入数字");
				document.getElementById('goods_count').select();
				return false;		
		}
		
				
		location.href="instoreadd.php?&module=warehouse&io_ordersn=<?php echo $io_ordersn;?>&goods_sn="+encodeURIComponent(goods_sn)+"&goods_count="+goods_count+"&stype=<?php echo $stype;?>&cost="+cost+"&addtype=save&in_type="+in_type+"&in_warehouse="+in_warehouse+"&note="+note+"&io_user="+io_user;
		
			
	}
	
	function save(){
		
		var in_type				= document.getElementById('in_type').value;
		var in_warehouse		= document.getElementById('in_warehouse').value;
		var note				= document.getElementById('note').value;
		var io_user				= document.getElementById('io_user').value;
		if(in_type <0) {alert('请选择入库类型');return false};
		if(in_warehouse <0) {alert('请选择入库仓库');return false;}
		
		
		var url					= "instoreadd.php?addtype=save&in_type="+in_type+"&in_warehouse="+in_warehouse+"&note="+note+"&module=warehouse&io_ordersn=<?php echo $io_ordersn;?>&stype=<?php echo $stype;?>&io_user="+io_user;
		location.href			= url;
		
	
	}
	
	function audit(){
	
		
		var url					= "instoreadd.php?addtype=audit&astatus=1&io_ordersn=<?php echo $io_ordersn;?>&module=warehouse&stype=<?php echo $stype;?>";
		location.href			= url;
		
	
	
	}
	
	function auditf(){
	
		
		var url					= "instoreadd.php?addtype=audit&astatus=0&io_ordersn=<?php echo $io_ordersn;?>&module=warehouse&stype=<?php echo $stype;?>";
		location.href			= url;
		
	
	
	}
	
	
	
	function wcustomer0(){
	
	
		
			openwindow("productslistinout.php",'',850,400);
	
	
	}
	
	
	
		function openwindow(url,name,iWidth,iHeight)

{

var url; //转向网页的地址;

var name; //网页名称，可为空;

var iWidth; //弹出窗口的宽度;

var iHeight; //弹出窗口的高度;

var iTop = (window.screen.availHeight-30-iHeight)/2; //获得窗口的垂直位置;

var iLeft = (window.screen.availWidth-10-iWidth)/2; //获得窗口的水平位置;

window.open(url,name,'height='+iHeight+',,innerHeight='+iHeight+',width='+iWidth+',innerWidth='+iWidth+',top='+iTop+',left='+iLeft+',toolbar=yes,menubar=yes,scrollbars=yes,resizeable=yes,location=no,status=no');

}
	
	
	
	function historyprice(){
		
		var goods_sn		= document.getElementById('goods_sn').value;
		if( goods_sn == ""){
				
				alert("产品编号：不能为空,否则不能查年原有采购价格");
				document.getElementById('goods_sn').select();
				return false;		
		}
		openwindow("purchasehistoryprice.php?goods_sn="+goods_sn,'',850,400);
		
	
	
	}
function battchtoxls(){
		
		
		var isadd		= "<?php echo $isadd;?>";
	if(isadd == 0){
		
		alert('请先保存单据');
		return false;
	
	}
	openwindow("battchuploadps.php?io_ordersn=<?php echo $io_ordersn;?>",'',850,400);
		
	}
		
		
	if(ref == 1){
	
		var url					= "instoreadd.php?io_ordersn=<?php echo $io_ordersn;?>&module=warehouse&stype=<?php echo $stype;?>";
		location.href			= url;
	
	}	
</script>