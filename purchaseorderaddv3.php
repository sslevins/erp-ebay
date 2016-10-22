<?php
include "include/config.php";
include "top.php";	
	/* 修改客户地址 */
	
	
	
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
	function CheckSourceorder($sourceorder,$io_ordersn){
		global $dbcon,$user;
		
		
		return 1;
		
		$vvsql		="select id from ebay_iostore where sourceorder='$sourceorder' and ebay_user='$user' and type!='1' and io_ordersn != '$io_ordersn'";	
		$sql2=$dbcon->execute($vvsql);
		$sql2=$dbcon->getResultArray($sql2);
		if(count($sql2)>0){
			return 0;
		}else{
			return 1;
		}
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
	
	$stype	= $_REQUEST['stype'];
	if($_REQUEST['io_ordersn'] == ""){
	
		$io_ordersn	= "IO-".date('Y')."-".date('m')."-".date('d')."-".date("H").date('i').date('s'). mt_rand(100,999);
		$issave = '0';
	}else{
		$io_ordersn	= $_REQUEST['io_ordersn'];
		$issave = '1';
	}
	
	if($_REQUEST['addtype'] == 'mod'){
	
	$goods_count	= $_REQUEST['goods_count'];
	$goods_cost		= $_REQUEST['goods_cost'];
	$modid			= $_REQUEST['modid'];
	$sql	= "update  ebay_iostoredetail set goods_count='$goods_count',goods_cost ='$goods_cost' where id=$modid";

					
		if($dbcon->execute($sql)){
			$status	= " -[<font color='#33CC33'>操作记录: 产品添加成功</font>]";
		}else{
			$status = " -[<font color='#FF0000'>操作记录: 产品添加失败</font>]";
		}
	
	
	}

	if($_REQUEST['addtype'] == 'del'){
	
		
		$id		= $_REQUEST['id'];
		$sql	= "delete from ebay_iostoredetail where id=$id";
					
		if($dbcon->execute($sql)){
			$status	= " -[<font color='#33CC33'>操作记录: 产品添加成功</font>]";
		}else{
			$status = " -[<font color='#FF0000'>操作记录: 产品添加失败</font>]";
		}
		
	
	}
	
	if($_REQUEST['addtype'] == 'save'){
		
		$sql			= "select * from  ebay_iostore where io_ordersn='$io_ordersn'";
		$sql			= $dbcon->execute($sql);
		$sql			= $dbcon->getResultArray($sql);
		$qc_user					= $_REQUEST['qc_user'];
		$in_type					= $_REQUEST['in_type'];
		$in_warehouse				= $_REQUEST['in_warehouse'];
		$note						= str_rep($_REQUEST['note']);
		$io_shipfee					=  $_REQUEST['io_shipfee'];
		$io_paymentmethod			=  $_REQUEST['io_paymentmethod'];
		$io_partner					=  $_REQUEST['io_partner'];
		$io_purchaseuser			=  $_REQUEST['io_purchaseuser'];
		$partner					=  $_REQUEST['partner'];
		$sourceorder				=  $_REQUEST['sourceorder'];
		$check = 1;
		if($stype == 'stocktofinace'){
			$check = CheckSourceorder($sourceorder,$io_ordersn);
		}
		if($check){
		$deliverytime				= '';
		if($_REQUEST['deliverytime'] != '')$deliverytime =  strtotime($_REQUEST['deliverytime']);
		$partner					= str_rep($_REQUEST['partner']);
		$io_user					= $_REQUEST['io_user'];
		$trueusername				= $_SESSION['truename'];
		if(count($sql) == 0){
				$sql	= "insert into ebay_iostore(io_ordersn,io_addtime,io_warehouse,io_type,io_status,io_note,ebay_user,type,operationuser,io_user,io_paymentmethod,io_partner,io_purchaseuser,partner,deliverytime,io_shipfee,qc_user) values('$io_ordersn','$mctime','$in_warehouse','$in_type','0','$note','$user','98','$trueusername','$io_user','$io_paymentmethod','$io_partner','$io_purchaseuser','$partner','$deliverytime','$io_shipfee','$qc_user')";
			
		
		}else{
		
			
			$sql	= "update ebay_iostore set io_warehouse='$in_warehouse',io_type='$in_type',io_note='$note',partner='$io_partner',io_user='$io_user',io_paymentmethod='$io_paymentmethod',io_partner='$io_partner',io_purchaseuser='$io_purchaseuser',sourceorder='$sourceorder',deliverytime='$deliverytime',io_shipfee='$io_shipfee',qc_user='$qc_user' where io_ordersn='$io_ordersn'";
			
		}
		
		
		
		
		
		if($dbcon->execute($sql)){
			$status	.= " -[<font color='#33CC33'>操作记录:入库单保存成功</font>]";
			$addtype	= '';
			
		}else{
			$status .= " -[<font color='#FF0000'>操作记录: 入库单保存失败</font>]";
		}
		
		
		
		
		/*  添加产品数据 */
		
		
		$goods_sn		= trim($_REQUEST['goods_sn']);
		$goods_count	= $_REQUEST['goods_count'];
		$goods_cost		= $_REQUEST['cost'];
		
		if($goods_sn != '' && $goods_count !='' && $goods_cost != '' ){
		
		$sql			= "select * from ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
		$sql			= $dbcon->execute($sql);
		$sql			= $dbcon->getResultArray($sql);
		if(count($sql)  == 0){
			$status .= " -[<font color='#FF0000'>操作记录: 没有产品记录，请添加此产品</font>]";
		}else{
		
		
		
			/* 检查是否存在重复sku */
			
			$vvs	= "select * from ebay_iostoredetail where io_ordersn='$io_ordersn' and goods_sn='$goods_sn' ";
			$vvs			= $dbcon->execute($vvs);
			$vvs			= $dbcon->getResultArray($vvs);
			
			if(count($vvs) == 0){
			
			
			$goods_name		= $sql[0]['goods_name'];
			$goods_sn		= $sql[0]['goods_sn'];
		//	$goods_price	= $sql[0]['goods_cost'];
			$goods_unit		= $sql[0]['goods_unit'];
			$goods_id		= $sql[0]['goods_id'];
			
			$sql		= "insert into ebay_iostoredetail(io_ordersn,goods_name,goods_sn,goods_cost,goods_unit,goods_count,goods_id) values('$io_ordersn','$goods_name','$goods_sn','$goods_cost','$goods_unit','$goods_count','$goods_id')";
		
			if($dbcon->execute($sql)){
				$status	.= " -[<font color='#33CC33'>操作记录: 产品添加成功</font>]";
			}else{
				$status .= " -[<font color='#FF0000'>操作记录: 产品添加失败</font>]";
			}
			
			
			}else{
				$status .= " -[<font color='#FF0000'>操作记录: 产品添加失败,已经存在相同物品</font>]";
			}
			
			
		
		}
			
		}
		
		/* 结束添加产品数据 */

	
	}else{
		$status .= " -[<font color='#FF0000'>操作记录: 保存失败，已存在的入库单号</font>]";
	}
	
	}
	
	
	
	
	$sql				= "select * from  ebay_iostore where io_ordersn='$io_ordersn'";
	$sql				= $dbcon->execute($sql);
	$sql				= $dbcon->getResultArray($sql);

	$in_type			= $sql[0]['io_type'];
	$in_warehouse		= $sql[0]['io_warehouse'];
	$iistatus			= $sql[0]['io_status'];
	
	if($_REQUEST['addtype'] == 'audit'){
			$astatus		= $_REQUEST['astatus'];
			
			$esql			= '';
			
			if($stype == 'FinanceCheck'){
			$esql			= "update ebay_iostore set type='96',io_audittime ='$mctime',audituser='$truename' where io_ordersn='$io_ordersn' and type !='94' ";
			}
			
			if($stype == 'newplan'){
			$esql			= "update ebay_iostore set type='98',io_audittime ='$mctime',audituser='$truename' where io_ordersn='$io_ordersn' and type !='94' ";
			}
			
			if($stype == 'stocktofinace'){
			$esql			= "update ebay_iostore set type='97',io_audittime ='$mctime',audituser='$truename' where io_ordersn='$io_ordersn' and type !='94' ";
			}
			
			if($stype == 'qcorders'){
			$esql			= "update ebay_iostore set type='95',io_audittime ='$mctime',audituser='$truename' where io_ordersn='$io_ordersn' and type !='94' ";
			}
			
			
			if($dbcon->execute($esql)){
				echo "<script>
						alert('审核成功');
						history.go(-2);
					</script>";
			}else{
				$status	= " -[<font color='#FF0000'>操作记录: 单据审核失败</font>]";
			}
			
			
	}
	if($_REQUEST['addtype'] == 'overorders'){
		$overtype	= $_REQUEST['overtype'];
		if($overtype=='1'){
			$esql			= "update ebay_iostore set type='101',io_audittime ='$mctime',audituser='$truename' where io_ordersn='$io_ordersn' and type !='94' ";
		}
		if($overtype=='2'){
			$esql			= "update ebay_iostore set type='102',io_audittime ='$mctime',audituser='$truename' where io_ordersn='$io_ordersn' and type !='94' ";
		}
		if($dbcon->execute($esql)){
				echo "<script>
						alert('审核成功');
						history.go(-2);
					</script>";
		}else{
			$status	= " -[<font color='#FF0000'>操作记录: 单据审核失败</font>]";
		}
	}
	if($_REQUEST['addtype'] == 'addovertype'){
		$changevalue	= $_REQUEST['changevalue'];
		$detailid		= $_REQUEST['detailid'];
		$esql			= "update ebay_iostoredetail set overtype='$changevalue' where id='$detailid'";

		if($dbcon->execute($esql)){
		}else{
			$status	= " -[<font color='#FF0000'>操作记录: 单据审核失败</font>]";
		}
	}
	
	$sql				= "select * from  ebay_iostore where io_ordersn='$io_ordersn'";
	$sql				= $dbcon->execute($sql);
	$sql				= $dbcon->getResultArray($sql);
	$isadd				= count($sql);
	
	$io_user			= $sql[0]['io_user'];
	$in_type			= $sql[0]['io_type'];
	$in_warehouse		= $sql[0]['io_warehouse'];
	$note				= $sql[0]['io_note'];
	$iistatus			=  $sql[0]['io_status'];
	$partner			=  $sql[0]['partner'];
	$audituser			=  $sql[0]['audituser'];
	$operationuser		=  $sql[0]['operationuser'];
	$audituser			=  $sql[0]['audituser'];
	$io_addtime			=  $sql[0]['io_addtime'];
	$deliverytime			=  $sql[0]['deliverytime']?$sql[0]['deliverytime']:'';
	$io_paymentmethod			=  $sql[0]['io_paymentmethod'];
	$io_partner					=  $sql[0]['io_partner'];
	$io_purchaseuser			=  $sql[0]['io_purchaseuser'];
	$partner					=  $sql[0]['partner'];
	$sourceorder				=  $sql[0]['sourceorder'];
	$io_shipfee					=  $sql[0]['io_shipfee'];
	if($io_addtime != '') $io_addtime	= date('Y-m-d H:i:s',$io_addtime);
	if($deliverytime != '' && $deliverytime != 0) $deliverytime	= date('Y-m-d',$deliverytime);
	$io_audittime			=  $sql[0]['io_audittime']?$sql[0]['io_audittime']:'';
	if($io_audittime != '' && $io_audittime != '0') $io_audittime	= date('Y-m-d H:i:s',$io_audittime);
	$qc_user			=  $sql[0]['qc_user'];
	
	
	if($_POST['checktostock']){
	
	
		$ss		= "select overtock,onstock,distrubitestock from ebay_config WHERE `ebay_user` ='$user' LIMIT 1";
		$ss		= $dbcon->execute($ss);
		$ss		= $dbcon->getResultArray($ss);
	
		$overtock							= $ss[0]['overtock']; // 缺货订单分类
		$onstock							= $ss[0]['onstock']; // 有库存时，应该转入
		if($overtock == '') die('您未定义缺货订单分类');
		if($onstock == '') die('您未定义，有货时，订单应该转入哪个分类');
		
		
		
		
		$vv				= "select id,goods_count,qty_01,goods_sn,goods_id from ebay_iostoredetail where io_ordersn ='".$_REQUEST['io_ordersn']."'";
		$vv				= $dbcon->execute($vv);
		$vv				= $dbcon->getResultArray($vv);
		
		for($i=0;$i<count($vv);$i++){
			$goods_id			= $vv[$i]['goods_id'];
			$goods_sn			= $vv[$i]['goods_sn'];
			$id					= $vv[$i]['id'];
			$goods_count		= $vv[$i]['goods_count']; // 进货数量
			$qty_01				= $vv[$i]['qty_01']; // 已通过数量，直接入库
			$checkqty			= $_POST['goods_count'.$id];
			
			$totalqty			= $qty_01 + $checkqty;
			
			//echo $i.': '.$totalqty.' : '.$goods_count.'<br>';
			
			if($totalqty <= $goods_count){
			
				if($qty_01<= 0 || $qty_01 == '' ){
				$runsql			= "update ebay_iostoredetail set qty_01 = $checkqty  where id=$id ";
				
				}else{
				$runsql			= "update ebay_iostoredetail set qty_01 = qty_01 + $checkqty where id=$id ";
				
				}
				$dbcon->execute($runsql);
				/* 检查入库 */
				$seq				= "select goods_sn from ebay_onhandle where goods_sn='$goods_sn' and store_id='$in_warehouse' and goods_id='$goods_id'";
				$seq				= $dbcon->execute($seq);
				$seq				= $dbcon->getResultArray($seq);
				if(count($seq) == 0){
					$sq			= "insert into ebay_onhandle(goods_id,goods_count,store_id,ebay_user,goods_name,goods_sn) values('$goods_id','$checkqty','$in_warehouse','$user','$goods_name','$goods_sn')";
				}else{
					$sq			= "update ebay_onhandle set goods_count=goods_count+$checkqty where goods_sn='$goods_sn' and store_id='$in_warehouse'  and goods_id='$goods_id'";
				}
				$dbcon->execute($sq);
			}
		}
		
		
		$vv				= "select id,goods_count,qty_01,goods_sn,goods_id from ebay_iostoredetail where io_ordersn ='".$_REQUEST['io_ordersn']."'";
		$vv				= $dbcon->execute($vv);
		$vv				= $dbcon->getResultArray($vv);
		$iscomplete		= 0;
		
		for($i=0;$i<count($vv);$i++){
			$goods_count		= $vv[$i]['goods_count']; // 进货数量
			$qty_01				= $vv[$i]['qty_01']; // 已通过数量，直接入库
			if($qty_01 < $goods_count) $iscomplete = 1;
		}
		
		if($iscomplete == 0){   // 转到已完成
		
			$esql			= "update ebay_iostore set type='94',io_audittime ='$mctime',audituser='$truename' where io_ordersn='$io_ordersn' and type !='94' ";
			$dbcon->execute($esql);
			
		}
		/* 开始检查缺货订单的物品，入库后是否有库存准备打印的。 */
		CheckOrdersStock($overtock,$onstock);		
	}
 ?>
<style type="text/css">
<!--
.STYLE1 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
 <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>

<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo ''.$status;?> </h2>
</div>



 
 
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
  <td nowrap="nowrap" scope="row" >
  
  <?php
	if($stype == 'FinanceCheck'){
   ?>
 		 <input name="input" type="button" value="通过审核" onclick="audit()" /> 
         <input name="input" type="button" value="驳回" onclick="FinanceChecknot()"  /> 
    <?php } ?>
    
    
     <?php
	if($stype == 'stocktofinace'){
   ?>
 		 <input name="input" type="button" value="提交审核" onclick="audit()" /> 
         <input name="input3" type="button" value="保存单据" onclick="save()" />
    <?php } ?>
    
    
    
    <?php
	if($stype == 'newplan'){
   ?>
    <input name="input3" type="button" value="保存单据" onclick="save()" />
    <input name="input4" type="button" value="转为入库单" onclick="audit()" />
    <?php } ?>
    
    
    <?php
	if($stype == 'qcorders'){
   ?>
         <input name="input" type="button" value="驳回" onclick="FinanceChecknot()"  /> 
         
         <?php if($user == 'vipallen'){ ?>
          <input name="input" type="button" value="打印" onclick="printorder()"  /> 
         <?php }?> 
    <?php } ?>
	<?php
	if($stype == 'qcorderssyc'){
   ?>
         <input name="input" type="button" value="驳回" onclick="FinanceChecknot()"  /> 
    <?php } ?>
    
    </td>
</tr>
<tr>
	<td nowrap="nowrap" scope="row" >&nbsp;<br />
	  1.填写基本资料
	  <br />
	  <br />
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
                      <td class="login_txt_bt"><table width="100%" border="1" cellspacing="10" cellpadding="0">
                        <tr>
                          <td width="8%">供应商</td>
                          <td width="8%"><select name="io_partner" id="io_partner">
                            <option value="" >未设置</option>
                            <?php 
					
						$sql	 = "SELECT company_name FROM `ebay_partner` where ebay_user='$user' ";
						$sql	 = $dbcon->execute($sql);
						$sql	 = $dbcon->getResultArray($sql);
						for($i=0;$i<count($sql);$i++){					
					 
					 	$company_name1	= $sql[$i]['company_name'];
						
					 ?>
                            <option value="<?php echo $company_name1;?>" <?php if($company_name1 == $io_partner) echo "selected=selected" ?>><?php echo $company_name1;?></option>
                            <?php } ?>
                          </select></td>
                          <td width="4%">仓库</td>
                          <td width="8%"><select name="in_warehouse" id="in_warehouse">
                            <option value="" >未设置</option>
                            <?php 
					
					$sql	 = "select id,store_name
					 from ebay_store where ebay_user='$user'";
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
                          <td colspan="2">备注
                            ：
                            <input name="note" type="text" id="note" value="<?php echo $note;?>" /></td>
						<td width="45%"><?php
							if($stype == 'newplan'){
							?>
						<input name="sourceorder" type="hidden" id="sourceorder" value="<?php echo $sourceorder;?>"/>
						 <?php }else{ ?>
						 供应商单号:
						 <input name="sourceorder" type="text" id="sourceorder" value="<?php echo $sourceorder;?>" size="30"   style="border-bottom :1 solid black; border-left :none; border-right :none; border-top :none; BACKGROUND: none transparent scroll repeat 0% 0%; "/>
						  <?php } ?>
						&nbsp;</td>
                        </tr>
                        
                        <tr>
						    
                          <td>单号</td>
                          <td>
						  <input name="io_ordersn" type="text" id="io_ordersn" value="<?php echo $io_ordersn;?>" size="30"   style="border-bottom :1 solid black; border-left :none; border-right :none; border-top :none; BACKGROUND: none transparent scroll repeat 0% 0%; "/>
						  
						  </td>
						  
                          <td>采购员</td>
                          <td><select name="io_purchaseuser" id="io_purchaseuser">
                            <option value="" >未设置</option>
                            <?php 
					
					$sql	 = "select username from ebay_user where user='$user'";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 
					 	$iousername	= $sql[$i]['username'];
				
					 ?>
                            <option value="<?php echo $iousername;?>" <?php if($iousername == $io_purchaseuser) echo "selected=selected" ?>><?php echo $iousername;?></option>
                            <?php } ?>
                          </select></td>
                          <td colspan="2">验收员
                            <select name="qc_user" id="qc_user">
                              <option value="" >未设置</option>
                              <?php 
					
					$sql	 = "select username from ebay_user where user='$user'";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 
					 	$iousername	= $sql[$i]['username'];
				
					 ?>
                              <option value="<?php echo $iousername;?>" <?php if($iousername == $qc_user) echo "selected=selected" ?>><?php echo $iousername;?></option>
                              <?php } ?>
                            </select></td>
							<td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>付款方式</td>
                          <td><select name="io_paymentmethod" id="io_paymentmethod">
                            <option value="" >未设置</option>
         
                            <option value="货到付款" 		<?php if($io_paymentmethod == '货到付款') echo "selected=selected" ?>>货到付款</option>
                            <option value="银行转帐" 		<?php if($io_paymentmethod == '银行转帐') echo "selected=selected" ?>>银行转帐</option>
                            <option value="电子支票" 	<?php if($io_paymentmethod == '电子支票') echo "selected=selected" ?>>电子支票</option>
                            <option value="支付宝付款" <?php if($io_paymentmethod == '支付宝付款') echo "selected=selected" ?>>支付宝付款</option>
                            <option value="未付款" <?php if($io_paymentmethod == '未付款') echo "selected=selected" ?>>未付款</option>
                            <option value="银行存款" <?php if($io_paymentmethod == '银行存款') echo "selected=selected" ?>>银行存款</option>
                            <option value="现金" <?php if($io_paymentmethod == '现金') echo "selected=selected" ?>>现金</option>
 
                            
                        
                          </select></td>
                          <td>到货日期</td>
                          <td><input name="deliverytime" type="text" id="deliverytime" value="<?php echo $deliverytime;?>" size="30"   style="border-bottom :1 solid black; border-left :none; border-right :none; border-top :none; BACKGROUND: none transparent scroll repeat 0% 0%; " onClick="WdatePicker()" /></td>
                          <td colspan="2">运费：
                          <input name="io_shipfee" type="text" id="io_shipfee" value="<?php echo $io_shipfee;?>" size="30"   style="border-bottom :1 solid black; border-left :none; border-right :none; border-top :none; BACKGROUND: none transparent scroll repeat 0% 0%; "  /></td>
						  <td>&nbsp;</td>
                        </tr>
                </table></td>
              </tr>
                    <tr>
                      <td valign="top" class="left_txt">
                      
                      &nbsp;<br />
                      2.产品资料
                      
                      <input name="input2" type="button" value=" 批量导入" onclick="battchtoxls()" />
                      <br />
                      <br /></td>
              </tr>
                    <tr>
                      <td  >
                      <form name="cc" id="cc" action="purchaseorderaddv3.php?module=purchase&io_ordersn=<?php echo $io_ordersn;?>&stype=qcorders" method="post">
                      <table width="100%" border="1" cellpadding="0" cellspacing="1" bordercolor="#000000" bgcolor="#000000">
                        <tr>
                          <td bgcolor="#FFFFFF">序号</td>
                          <td bgcolor="#FFFFFF">编号</td>
                          <td bgcolor="#FFFFFF">图片</td>
                          <td bgcolor="#FFFFFF">名称</td>
                          <td bgcolor="#FFFFFF">单位</td>
                          <td bgcolor="#FFFFFF">实际库存</td>
                          <td bgcolor="#FFFFFF">占用库存</td>
                          <td bgcolor="#FFFFFF">已订购</td>
                          <td bgcolor="#FFFFFF">可用库存</td>
                          <td bgcolor="#FFFFFF">成本行情</td>
                          <td bgcolor="#FFFFFF">预设进价</td>
                          <td bgcolor="#FFFFFF">平均价</td>
                          <td bgcolor="#FFFFFF">最新采购价</td>
                          <td bgcolor="#FFFFFF">本次采购价</td>
                          <td bgcolor="#FFFFFF">进货数量</td>
                          <td bgcolor="#FFFFFF">检测通过</td>
                          <td bgcolor="#FFFFFF">已入库</td>
                          <td bgcolor="#FFFFFF">备注</td>
                          <td bgcolor="#FFFFFF">操作</td>
                        </tr>
                        <?php
							
							$sql	= "select goods_sn,goods_name,goods_price,goods_cost,goods_unit,id,goods_count,notes,qty_01,overtype from ebay_iostoredetail where io_ordersn='$io_ordersn'";
						
							$totalprice		= 0;
							$totalqty		= 0;
							
							
							$sql	= $dbcon->execute($sql);
							$sql	= $dbcon->getResultArray($sql);
							for($i=0;$i<count($sql);$i++){
								
								$goods_sn			= $sql[$i]['goods_sn'];
								$goods_name 		= $sql[$i]['goods_name'];
								$goods_price 		= $sql[$i]['goods_price'];
								$goods_cost1 		= $sql[$i]['goods_cost'];
								$goods_unit 		= $sql[$i]['goods_unit'];
								$id					= $sql[$i]['id'];
								$goods_count2  		= $sql[$i]['goods_count'];
								$notes		  		= $sql[$i]['notes'];
								$qty_01		  		= $sql[$i]['qty_01'];
								$overtype			= $sql[$i]['overtype'];
								$dataarray				= GetStockQtyBySku($in_warehouse,$goods_sn);
								$goods_count			= $dataarray[0];
								$goods_xx				= $dataarray[1];
								$goods_cost				= $dataarray[3];
								
								$dataarray				= GetPurchasePrice($goods_sn);
								
								
								$seq				= "select goods_pic from ebay_goods where goods_sn='$goods_sn' and ebay_user='$user' ";
								$seq				= $dbcon->execute($seq);
								$seq				= $dbcon->getResultArray($seq);
								$goods_pic			= $seq[0]['goods_pic'];
								
								
								$totalprice			+= ($goods_cost1 * $goods_count2); 
								$totalqty			+= $goods_count2;
								
						?>
                        <tr >
                          <td bgcolor="#FFFFFF"><?php echo  $i+1;?>. &nbsp;</td>
                          <td bgcolor="#FFFFFF"><?php echo $goods_sn;?>&nbsp;</td>
                          <td bgcolor="#FFFFFF"><img src="images/<?php echo $goods_pic; ?>" alt="" width="50" height="50" /></td>
                          <td bgcolor="#FFFFFF"><?php echo $goods_name;?>&nbsp;</td>
                          <td bgcolor="#FFFFFF"><?php echo $goods_unit;?>&nbsp;</td>
                          <td bgcolor="#FFFFFF"><?php
								echo $goods_count;
							?></td>
                          <td bgcolor="#FFFFFF"><?php
						 $stockused	= stockused($goods_sn,$in_warehouse);
						 echo $stockused;
						  ?>
                            &nbsp;</td>
                          <td bgcolor="#FFFFFF"><?php
						  
						 // $stockbookused	= stockbookused($goods_sn,$in_warehouse);
						   $stockbookused	= getPurchaseNumber('all',$goods_sn,$in_warehouse);
						  
						  echo $stockbookused;
						  ?></td>
                          <td bgcolor="#FFFFFF"><?php
								
								
								echo $truestock - $stockused;
							
							
							?></td>
                          <td bgcolor="#FFFFFF"><?php echo $dataarray[3];?></td>
                          <td bgcolor="#FFFFFF"><?php echo $goods_cost;?></td>
                          <td bgcolor="#FFFFFF"><?php echo $dataarray[2];?>&nbsp;</td>
                          <td bgcolor="#FFFFFF"><?php echo $dataarray[4];?>&nbsp;</td>
                          <td bgcolor="#FFFFFF">&nbsp;
                              <textarea name="goods_cost" cols="5" rows="1" id="goods_cost<?php echo $id ?>" ><?php echo $goods_cost1;?></textarea></td>
                          <td bgcolor="#FFFFFF">&nbsp;
                              <textarea name="goods_count" cols="6" rows="1" id="goods_count<?php echo $id ?>" ><?php echo $goods_count2;?></textarea></td>
                          <td bgcolor="#FFFFFF"><textarea name="goods_count<?php echo $id;?>" cols="6" rows="1" id="goods_count<?php echo $id;?>" ></textarea></td>
                          <td bgcolor="#FFFFFF"><?php echo $qty_01;?>&nbsp;</td>
                          <td bgcolor="#FFFFFF"><?php echo $notes;?>&nbsp;</td>
                          <td bgcolor="#FFFFFF">
						  
						  <?php if($stype == 'newplan' || $stype == 'stocktofinace'){ ?>
                              <a href="#" onclick="del('<?php echo $id;?>')">删除</a>&nbsp;&nbsp; <a href="#" onclick="mod('<?php echo $id;?>')">修改</a> <?php } ?>
						  <?php if($stype == 'qcorderssyc'){ ?>
						  <select id='overtype<?php echo $id;?>'onchange='changeovertype("<?php echo $id;?>")'>
						    <option value='0'>正常</option>
							<option value='1' <?php if($overtype=='1') echo "selected='selected'";?>>结束订单</option>
							<option value='2' <?php if($overtype=='2') echo "selected='selected'";?>>正常报损</option>
						  </select>
						  <?php } ?>
						  <?php if($stype == 'completeorders'){
								if($overtype=='1'){
									echo "结束订单";
								}elseif($overtype=='2'){
									echo "正常报损";
								}else{
									echo "正常";
								}
						  }?>
						  </td>
                         
                        </tr>
						 <?php }  ?>
                        <tr>
                          <td colspan="8" rowspan="3" bgcolor="#FFFFFF">&nbsp;</td>
                          <td bgcolor="#FFFFFF">&nbsp;</td>
                          <td bgcolor="#FFFFFF">&nbsp;</td>
                          <td bgcolor="#FFFFFF">&nbsp;</td>
                          <td bgcolor="#FFFFFF">&nbsp;</td>
                          <td bgcolor="#FFFFFF">&nbsp;</td>
                          <td bgcolor="#FFFFFF">&nbsp;<?php echo $totalprice;?></td>
                          <td bgcolor="#FFFFFF"><?php echo $totalqty;?>&nbsp;</td>
                       <td colspan="4" bgcolor="#FFFFFF"><span class="left_txt">
                            
                             <?php if($stype == 'qcorders'){ ?>
                            <input name="checktostock" type="submit" value="检测通过" />
                            <br />
                            <input name="input5" type="button" value="审核到异常采购" onclick="audit()" />
                            <?php } ?>
							<?php if($stype == 'qcorderssyc'){ ?>
                            <input name="checktostock" type="submit" value="检测通过" />
                            <br />
                            <input name="input" type="button" value="结束订单" onclick="overorders('1')"  /><br />
							<input name="input" type="button" value="正常报损" onclick="overorders('2')"  /> 
                            <?php } ?>
                          </span></td>
                        </tr>
                        <tr>
                          <td bgcolor="#FFFFFF">&nbsp;</td>
                          <td bgcolor="#FFFFFF">&nbsp;</td>
                          <td bgcolor="#FFFFFF">&nbsp;</td>
                          <td bgcolor="#FFFFFF">&nbsp;</td>
                          <td bgcolor="#FFFFFF">&nbsp;</td>
                          <td bgcolor="#FFFFFF">&nbsp;</td>
                          <td bgcolor="#FFFFFF">&nbsp;</td>
                          <td bgcolor="#FFFFFF">&nbsp;</td>
                          <td bgcolor="#FFFFFF">&nbsp;</td>
                          <td bgcolor="#FFFFFF">&nbsp;</td>
                          <td bgcolor="#FFFFFF">&nbsp;</td>
                        </tr>
                        <tr>
                          <td bgcolor="#FFFFFF">&nbsp;</td>
                          <td bgcolor="#FFFFFF">&nbsp;</td>
                          <td bgcolor="#FFFFFF">&nbsp;</td>
                          <td bgcolor="#FFFFFF">&nbsp;</td>
                          <td bgcolor="#FFFFFF">&nbsp;</td>
                          <td bgcolor="#FFFFFF">&nbsp;</td>
                          <td bgcolor="#FFFFFF">&nbsp;</td>
                          <td bgcolor="#FFFFFF">&nbsp;</td>
                          <td bgcolor="#FFFFFF">&nbsp;</td>
                          <td bgcolor="#FFFFFF">&nbsp;</td>
                          <td bgcolor="#FFFFFF">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="19" bgcolor="#FFFFFF"><?php if($stype == 'stocktofinace'){ ?>
                            产品编号：
                            <input name="goods_sn" type="text" id="goods_sn" />
                            进货成本：
                            <input name="cost" type="text" id="cost" />
                            <input type="button" value="查看历史采购价格" onclick="historyprice()"  />
                            数量：
                            <input name="goods_count" type="text" id="goods_count" />
                            <input type="button" value="添加" onclick="add()" <?php if($iistatus == 1) echo "disabled=\"false\"" ?> />
                            <input type="button" value="打开产品列表" onclick="opengoods()" <?php if($iistatus == 1 || $issave== '0') echo "disabled=\"false\"" ?> />
                            <?php }?>                          </td>
                        </tr>
                      </table>
                      
                      </form>
                      </td>
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

	function printorder(){
		var url = 'toxls/pruchase_print03.php?ordersn=<?php echo $io_ordersn;?>';
		window.open(url);
	}
	
	
	function del(id){
		if(confirm("确认删除此条记录吗")){
		location.href="purchaseorderaddv3.php?&module=purchase&action=采购订单&io_ordersn=<?php echo $io_ordersn;?>&addtype=del&stype=<?php echo $stype;?>&id="+id;
		}
	}
	
	
	function mod(id){
	
		var goods_cost				= document.getElementById('goods_cost'+id).value;
		var goods_count				= document.getElementById('goods_count'+id).value;
		
		if(confirm("确认修改此条记录吗")){
		
		
		var url					= "purchaseorderaddv3.php?addtype=mod&module=purchase&action=采购订单&io_ordersn=<?php echo $io_ordersn;?>&stype=<?php echo $stype;?>&goods_count="+goods_count+"&goods_cost="+goods_cost+"&modid="+id;
		
		location.href			= url;
		
		
		
		}
		
	
	}
	

	function add(){
		var io_shipfee					= document.getElementById('io_shipfee').value;
		var io_partner					= document.getElementById('io_partner').value;
		var note						= document.getElementById('note').value;
		var io_purchaseuser				= document.getElementById('io_purchaseuser').value;
		var deliverytime				= document.getElementById('deliverytime').value;
		var io_paymentmethod			= document.getElementById('io_paymentmethod').value;
		var in_warehouse				= document.getElementById('in_warehouse').value;
		var qc_user						= document.getElementById('qc_user').value;
		var sourceorder						= document.getElementById('sourceorder').value;
		if(io_partner =='') {alert('请选择供应商');return false};
		if(io_purchaseuser =='') {alert('请选择采购员');return false};
		
		if(io_paymentmethod =='') {alert('请选择付款方式');return false};
		if(in_warehouse =='') {alert('请选择入库仓库');return false};
		
		
		
		
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
		

	
				
		location.href="purchaseorderaddv3.php?&module=purchase&sourceorder="+sourceorder+"&io_ordersn=<?php echo $io_ordersn;?>&goods_sn="+encodeURIComponent(goods_sn)+"&goods_count="+goods_count+"&stype=<?php echo $stype;?>&cost="+cost+"&addtype=save&io_partner="+encodeURIComponent(io_partner)+"&io_purchaseuser="+io_purchaseuser+"&note="+encodeURIComponent(note)+"&deliverytime="+deliverytime+"&io_paymentmethod="+io_paymentmethod+"&in_warehouse="+in_warehouse+"&io_shipfee="+io_shipfee+"&qc_user="+qc_user;
		
			
	}
	
	function save(){
		
		var io_partner					= document.getElementById('io_partner').value;
		var note						= document.getElementById('note').value;
		var io_purchaseuser				= document.getElementById('io_purchaseuser').value;
		var deliverytime				= document.getElementById('deliverytime').value;
		var io_paymentmethod			= document.getElementById('io_paymentmethod').value;
		var in_warehouse				= document.getElementById('in_warehouse').value;
		var io_shipfee					= document.getElementById('io_shipfee').value;
		var qc_user					= document.getElementById('qc_user').value;
		var sourceorder					= document.getElementById('sourceorder').value;
		
		
		
		<?php if($stype == 'stocktofinace'){ ?>
		if(sourceorder =='') {alert('请输入供应商单号');return false};
		<?php } ?>
		if(in_warehouse =='') {alert('请选择入库仓库');return false};
		
		if(io_partner =='') {alert('请选择供应商');return false};
		if(io_purchaseuser =='') {alert('请选择采购员');return false};
		
		if(io_paymentmethod =='') {alert('请选择付款方式');return false};
	
		
		var url					= "purchaseorderaddv3.php?addtype=save&io_partner="+encodeURIComponent(io_partner)+"&io_purchaseuser="+io_purchaseuser+"&note="+encodeURIComponent(note)+"&module=purchase&action=采购订单&io_ordersn=<?php echo $io_ordersn;?>&stype=<?php echo $stype;?>&deliverytime="+deliverytime+"&io_paymentmethod="+encodeURIComponent(io_paymentmethod)+"&deliverytime="+deliverytime+"&in_warehouse="+in_warehouse+"&io_shipfee="+io_shipfee+"&qc_user="+encodeURIComponent(qc_user)+'&sourceorder='+sourceorder;
		location.href			= url;
		
	
	}
	
	function FinanceChecksave(){
		
		var io_partner					= document.getElementById('io_partner').value;
		var note						= document.getElementById('note').value;
		var io_purchaseuser				= document.getElementById('io_purchaseuser').value;
		var deliverytime				= document.getElementById('deliverytime').value;
		var io_paymentmethod			= document.getElementById('io_paymentmethod').value;
		var in_warehouse				= document.getElementById('in_warehouse').value;
		var io_shipfee					= document.getElementById('io_shipfee').value;
		var qc_user					= document.getElementById('qc_user').value;
		if(in_warehouse =='') {alert('请选择入库仓库');return false};
		
		if(io_partner =='') {alert('请选择供应商');return false};
		if(io_purchaseuser =='') {alert('请选择采购员');return false};
		
		if(io_paymentmethod =='') {alert('请选择付款方式');return false};
	
		
		var url					= "purchaseorderaddv3.php?addtype=save&io_partner="+encodeURIComponent(io_partner)+"&io_purchaseuser="+io_purchaseuser+"&note="+encodeURIComponent(note)+"&module=purchase&action=采购订单&io_ordersn=<?php echo $io_ordersn;?>&stype=<?php echo $stype;?>&io_paymentmethod="+encodeURIComponent(io_paymentmethod)+"&deliverytime="+deliverytime+"&in_warehouse="+in_warehouse+"&io_shipfee="+io_shipfee+"&qc_user="+qc_user;
		location.href			= url;
		
	
	}
	
	
	function audit(){
		var sourceorder					= document.getElementById('sourceorder').value;
		<?php if($stype == 'stocktofinace'){ ?>
		if(sourceorder =='') {alert('请输入入库单号');return false};
		<?php } ?>
		var url					= "purchaseorderaddv3.php?addtype=audit&astatus=1&action=&io_ordersn=<?php echo $io_ordersn;?>&module=purchase&stype=<?php echo $stype;?>";
		location.href			= url;
	}
	
	function auditf(){
		var url					= "purchaseorderaddv3.php?addtype=audit&astatus=0&action=&io_ordersn=<?php echo $io_ordersn;?>&module=purchase&stype=<?php echo $stype;?>";
		location.href			= url;
	}
<?php if($stype == 'qcorderssyc'){ ?>
	function overorders(type){
		var url					= "purchaseorderaddv3.php?addtype=overorders&astatus=0&action=&io_ordersn=<?php echo $io_ordersn;?>&module=purchase&stype=<?php echo $stype;?>&overtype="+type;
		location.href			= url;
	}
	function changeovertype(id){
		var value				= document.getElementById('overtype'+id).value;
		var url					= "purchaseorderaddv3.php?addtype=addovertype&astatus=0&action=&io_ordersn=<?php echo $io_ordersn;?>&module=purchase&stype=<?php echo $stype;?>&changevalue="+value+"&detailid="+id;
		location.href			= url;
	}
<?php } ?>	
	
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
	
	function addstock(id){
	
		
		var stockqty		= document.getElementById('goods_count2'+id).value;
		var url				= "purchaseorderinstok.php?id="+id+"&stockqty="+stockqty+"&in_warehouse=<?php echo $in_warehouse;?>";
		openwindow(url,'',850,400);
		
	
	
	}
	function opengoods(){
		var url				= "goodslist.php?io_ordersn=<?php echo $io_ordersn;?>";
		openwindow(url,'',1000,600);
	}
	
	function FinanceChecknot(){
	
		var url				= "toxls/FinanceCheck_notaudit.php?io_ordersn=<?php echo $io_ordersn;?>";
		openwindow(url,'',1000,600);
	}
	
	
	function battchtoxls(){
		var isadd		= "<?php echo $isadd;?>";
		if(isadd == 0){
		alert('请先保存单据');
		return false;
		}
		openwindow("battchuploadps.php?io_ordersn=<?php echo $io_ordersn;?>",'',850,400);
	}
</script>