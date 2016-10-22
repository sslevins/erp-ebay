<?php
include "include/config.php";
include "top.php";	
	/* 修改客户地址 */
	
	$stype	= $_REQUEST['stype'];
	
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
			$goods_name			= $sql[$i]['goods_name'];
			
			$seq				= "select * from ebay_onhandle where goods_sn='$goods_sn' and store_id='$storeid' and goods_id='$goods_id'";
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
		$in_type		= $_REQUEST['in_type'];
		$in_warehouse	= $_REQUEST['in_warehouse'];
		$note			= str_rep($_REQUEST['note']);
		
		$io_paymentmethod			=  $_REQUEST['io_paymentmethod'];
		$io_partner					=  $_REQUEST['io_partner'];
		$io_purchaseuser			=  $_REQUEST['io_purchaseuser'];
		$partner					=  $_REQUEST['partner'];
		$deliverytime				= '';
		if($_REQUEST['deliverytime'] != '')$deliverytime					=  strtotime($_REQUEST['deliverytime']);
	
		$partner			= str_rep($_REQUEST['partner']);
		$io_user		= $_REQUEST['io_user'];
		$trueusername		= $_SESSION['truename'];
		
		if(count($sql) == 0){
		
			
			$sql	= "insert into ebay_iostore(partner,io_ordersn,io_addtime,io_warehouse,io_type,io_status,io_note,ebay_user,type,operationuser,io_user,io_paymentmethod,io_partner,io_purchaseuser,partner,deliverytime,in_warehouse) values('$partner','$io_ordersn','$mctime','$in_warehouse','$in_type','0','$note','$user','$stype','$trueusername','$io_user','$io_paymentmethod','$io_partner','$io_purchaseuser','$partner','$deliverytime','$in_warehouse')";
			
		
		}else{
		
			
			$sql	= "update ebay_iostore set io_warehouse='$in_warehouse',io_type='$in_type',io_note='$note',partner='$partner',io_user='$io_user',io_paymentmethod='$io_paymentmethod',io_partner='$io_partner',io_purchaseuser='$io_purchaseuser',partner='$partner',deliverytime='$deliverytime' where io_ordersn='$io_ordersn'";
			
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
		
		$sql			= "select * from ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
		$sql			= $dbcon->execute($sql);
		$sql			= $dbcon->getResultArray($sql);
		if(count($sql)  == 0){
			$status .= " -[<font color='#FF0000'>操作记录: 没有产品记录，请添加此产品</font>]";
		}else{
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
		
		}
		
		
		}
		
		/* 结束添加产品数据 */

	
	
	
	}
	
	
	
	
	
	$sql				= "select * from  ebay_iostore where io_ordersn='$io_ordersn'";
	$sql				= $dbcon->execute($sql);
	$sql				= $dbcon->getResultArray($sql);

	$in_type			= $sql[0]['io_type'];
	$in_warehouse		= $sql[0]['io_warehouse'];
	$iistatus			= $sql[0]['io_status'];
	$io_purchaseorder	= $sql[0]['io_purchaseorder'];
	
	
	if($_REQUEST['addtype'] == 'audit'){
		
		
			$astatus		= $_REQUEST['astatus'];
			if($iistatus != $astatus){
			if($astatus ==0 ){
				
			$runstatus  = addoroutstock($io_ordersn,$astatus,$in_warehouse);
			$esql			= "update ebay_iostore set io_status='$astatus',io_audittime ='',audituser='' where io_ordersn='$io_ordersn'";
			$esql2			= "update ebay_iostore set io_status='1'  where io_ordersn='$io_purchaseorder'";
			
				
			}else if($astatus ==1){
			$runstatus	 = addoroutstock($io_ordersn,$astatus,$in_warehouse);
			$esql			= "update ebay_iostore set io_status='$astatus',io_audittime ='$mctime',audituser='$truename' where io_ordersn='$io_ordersn'";
			$esql2			= "update ebay_iostore set io_status='2'  where io_ordersn='$io_purchaseorder'";
			
			}
			
			
		
			
			
			if($dbcon->execute($esql)){
				$status	= " -[<font color='#33CC33'>操作记录: 单据审核成功</font>]";
				$dbcon->execute($esql2);
				
				
			
			}else{
				$status	= " -[<font color='#FF0000'>操作记录: 单据审核失败</font>]";
			}
			}
			
		
	
	}
	

	
	
	$io_purchaseorder	= $_REQUEST['io_purchaseorder'];
	
	if($io_purchaseorder != ''){
		
		/* 调用原有采购订单的资料 */
		$sql				= "select * from  ebay_iostore where io_ordersn='$io_purchaseorder'";
		$sql				= $dbcon->execute($sql);
		$sql				= $dbcon->getResultArray($sql);
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
		$deliverytime		=  $sql[0]['deliverytime']?$sql[0]['deliverytime']:'';
		$io_paymentmethod	=  $sql[0]['io_paymentmethod'];
		$io_partner			=  $sql[0]['io_partner'];
		$io_purchaseuser	=  $sql[0]['io_purchaseuser'];
		$partner			=  $sql[0]['io_partner'];
		/* 结束 */
		
		$ss			= "select * from  ebay_iostore where  io_purchaseorder	='$io_purchaseorder'";
		$ss			= $dbcon->execute($ss);
		$ss			= $dbcon->getResultArray($ss);
		
		if(count($ss) == 0){
			
			$sql	= "insert into ebay_iostore(io_ordersn,io_addtime,io_warehouse,io_type,io_status,io_note,ebay_user,type,operationuser,io_user,io_paymentmethod,io_partner,io_purchaseuser,partner,deliverytime,io_purchaseorder) values('$io_ordersn','$mctime','$in_warehouse','$in_type','0','$note','$user','$stype','$truename','$io_user','$io_paymentmethod','$io_partner','$io_purchaseuser','$partner','$deliverytime','$io_purchaseorder')";
			
			
			
		
		}else{
		
			$io_ordersn		= $ss[0]['io_ordersn'];
			$sql	= "update ebay_iostore set io_warehouse='$in_warehouse',io_type='$in_type',io_note='$note',partner='$partner',io_user='$io_user',io_paymentmethod='$io_paymentmethod',io_partner='$io_partner',io_purchaseuser='$io_purchaseuser',partner='$partner',deliverytime='$deliverytime',io_purchaseorder='$io_purchaseorder' where io_ordersn='$io_ordersn'";
			
			
			
		}

		if($dbcon->execute($sql)){
			$status	.= " -[<font color='#33CC33'>操作记录:入库单保存成功</font>]";
			/* 取得物品资料 */
			
			$ss		= "select * from ebay_iostoredetail where io_ordersn ='$io_purchaseorder' ";
	
			
			$ss			= $dbcon->execute($ss);
			$ss			= $dbcon->getResultArray($ss);
			for($i=0;$i<count($ss);$i++){
			
				
				
				$goods_name		=$ss[$i]['goods_name'];
				$goods_id		=$ss[$i]['goods_id'];
				$goods_sn		=$ss[$i]['goods_sn'];
				$goods_cost		=$ss[$i]['goods_cost'];
				$goods_unit		=$ss[$i]['goods_unit'];
				$goods_count	=$ss[$i]['goods_count'];
				$goods_id		=$ss[$i]['goods_id'];
				$id				=$ss[$i]['id'];
				$pid			=$ss[$i]['pid'];
				
				$rr				= "select * from ebay_iostoredetail where io_ordersn ='$io_ordersn' and pid ='$id'";
				$rr				= $dbcon->execute($rr);
				$rr				= $dbcon->getResultArray($rr);
				
				if(count($rr) == 0){
					$sql		= "insert into ebay_iostoredetail(io_ordersn,goods_name,goods_sn,goods_cost,goods_unit,goods_count,goods_id,pid) values('$io_ordersn','$goods_name','$goods_sn','$goods_cost','$goods_unit','$goods_count','$goods_id','$id')";
					$dbcon->execute($sql);
					
				
				}
			
			
			
			
			}
			
			
		}else{
			$status .= " -[<font color='#FF0000'>操作记录: 入库单保存失败</font>]";
		}
	
	}

	
	$sql				= "select * from  ebay_iostore where io_ordersn='$io_ordersn'";
	$sql				= $dbcon->execute($sql);
	$sql				= $dbcon->getResultArray($sql);
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
	$io_purchaseorder					=  $sql[0]['io_purchaseorder'];
	$in_warehouse			=  $sql[0]['io_warehouse'];
	
	if($io_addtime != '') $io_addtime	= date('Y-m-d H:i:s',$io_addtime);
	if($deliverytime != '' && $deliverytime != 0) $deliverytime	= date('Y-m-d',$deliverytime);
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
 <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>

<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo '采购订单'.$status;?> </h2>
</div>

<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
  <td nowrap="nowrap" scope="row" >
   <?php if($iistatus == '0' || $iistatus == ''){ ?><input name="input" type="button" value="保存单据" onclick="save()" /><?php } ?>
   <?php if(($iistatus == '0' || $iistatus == '')  && $in_warehouse != ''){ ?> <input name="input" type="button" value="审核单据" onclick="audit()"  /> <?php } ?>
   <?php if($iistatus == '1' ){ ?> <input name="input2" type="button" value="反审核单据" onclick="auditf()" /><?php } ?>
    <input name="input4" type="button" value="打印单据" onclick="printorder()" /></td>
</tr>
<tr>
	
	
	
		
	<td nowrap="nowrap" scope="row" >&nbsp;<br />
	  1.填写基本资料
	    
	    (只能调用已审核中的采购订单)<br />
	  <br />
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
                      <td class="login_txt_bt"><table width="100%" border="1" cellspacing="3" cellpadding="0">
                          <tr>
                            <td>调用采购订单</td>
                            <td><select name="io_purchaseorder" id="io_purchaseorder" onchange="chagegorder()">
                              <option value="" >未设置</option>
                              <?php 
					
					$sql	 = "SELECT * FROM `ebay_iostore` where ebay_user='$user' and type = '2' and io_status = '1'";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 
					 	$iio_ordersn	= $sql[$i]['io_ordersn'];
						
					 ?>
                              <option value="<?php echo $iio_ordersn;?>" <?php if($io_purchaseorder == $iio_ordersn) echo "selected=selected" ?>><?php echo $iio_ordersn;?></option>
                              <?php } ?>
                            </select></td>
                            <td>仓库</td>
                            <td><select name="in_warehouse" id="in_warehouse">
                              <option value="" >未设置</option>
                              <?php 
					
					$sql	 = "select * from ebay_store where ebay_user='$user'";
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
                            <td colspan="2" rowspan="3">备注
                            <textarea name="note" cols="80" rows="3" id="note" ><?php echo $note;?></textarea></td>
                          </tr>
                        <tr>
                          <td width="8%">供应商</td>
                          <td width="8%"><select name="io_partner" id="io_partner">
                            <option value="" >未设置</option>
                            <?php 
					
					$sql	 = "SELECT * FROM `ebay_partner` where ebay_user='$user' ";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 
					 	$company_name1	= $sql[$i]['company_name'];
						
					 ?>
                            <option value="<?php echo $company_name1;?>" <?php if($company_name1 == $io_partner) echo "selected=selected" ?>><?php echo $company_name1;?></option>
                            <?php } ?>
                          </select></td>
                          <td width="4%">付款方式</td>
                          <td width="8%"><select name="io_paymentmethod" id="io_paymentmethod">
                            <option value="" >未设置</option>
                            <option value="货到付款" 		<?php if($io_paymentmethod == '货到付款') echo "selected=selected" ?>>货到付款</option>
                            <option value="银行转帐" 		<?php if($io_paymentmethod == '银行转帐') echo "selected=selected" ?>>银行转帐</option>
                            <option value="电子支票" 	<?php if($io_paymentmethod == '电子支票') echo "selected=selected" ?>>电子支票</option>
                            <option value="支付宝付款" <?php if($io_paymentmethod == '支付宝付款') echo "selected=selected" ?>>支付宝付款</option>
                          </select></td>
                        </tr>
                        
                        <tr>
                          <td>采购员</td>
                          <td><select name="io_purchaseuser" id="io_purchaseuser">
                            <option value="" >未设置</option>
                            <?php 
					
					$sql	 = "select * from ebay_user where user='$user'";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 
					 	$iousername	= $sql[$i]['username'];
				
					 ?>
                            <option value="<?php echo $iousername;?>" <?php if($iousername == $io_purchaseuser) echo "selected=selected" ?>><?php echo $iousername;?></option>
                            <?php } ?>
                          </select></td>
                          <td>采购收货单号</td>
                          <td><input name="io_ordersn" type="text" id="io_ordersn" value="<?php echo $io_ordersn;?>" size="30"   style="border-bottom :1 solid black; border-left :none; border-right :none; border-top :none; BACKGROUND: none transparent scroll repeat 0% 0%; "/>                         </td>
                        </tr>
                        
                </table></td>
              </tr>
                    <tr>
                      <td valign="top" class="left_txt">
                      
                      &nbsp;<br />
                      2.产品资料
                      
                      <br />
                      <br /></td>
              </tr>
                    <tr>
                      <td class="login_txt_bt"><table width="100%" border="1" cellspacing="3" cellpadding="0">
                        <tr>
                          <td>产品编号</td>
                          <td>产品名称</td>
                          <td>单位</td>
                          <td>近30天销量</td>
                          <td>近15天销量</td>
                          <td>近7天销量</td>
                          <td>实际库存</td>
                          <td>占用库存</td>
                          <td>已订购</td>
                          <td>可用库存</td>
                          <td>产品进货成本</td>
                          <td>数量</td>
                          <td>操作</td>
                        </tr>
                        
                        <?php
							
							$sql	= "select * from ebay_iostoredetail where io_ordersn='$io_ordersn'";
						
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
                          <td><?php echo $goods_sn;?>&nbsp;</td>
                          <td><?php echo $goods_name;?>&nbsp;</td>
                          <td><?php echo $goods_unit;?>&nbsp;</td>
                          <td>
                          <?php
						  
						  $start1						= date('Y-m-d').'23:59:59';	
						  $start0						= date('Y-m-d',strtotime("$start1 -30 days")).' 00:00:00';
						  
						  $qty1							= getSaleProducts($start1,$start0,$goods_sn,$in_warehouse);
						  echo $qty1;
						  
						  
						  
						  ?>
                          
                          
                          &nbsp;</td>
                          <td>
                          
                          <?php
						  
						  $start1						= date('Y-m-d').'23:59:59';	
						  $start0						= date('Y-m-d',strtotime("$start1 -15 days")).' 00:00:00';
						  
						  $qty1							= getSaleProducts($start1,$start0,$goods_sn,$in_warehouse);
						  echo $qty1;
						  
						  
						  ?>
                          &nbsp;</td>
                          <td>
                          <?php
						  
						  $start1						= date('Y-m-d').'23:59:59';	
						  $start0						= date('Y-m-d',strtotime("$start1 -7 days")).' 00:00:00';
						  $qty1							= getSaleProducts($start1,$start0,$goods_sn,$in_warehouse);
						  echo $qty1;
						  ?>
                          
                          &nbsp;</td>
                          <td><?php
			
							$seq				= "select * from ebay_onhandle where goods_sn='$goods_sn' and store_id='$in_warehouse' ";
							$seq				= $dbcon->execute($seq);
							$seq				= $dbcon->getResultArray($seq);
							$truestock			= $seq[0]['goods_count']?$seq[0]['goods_count']:0;
							echo $truestock;
			
			
							
							
							
							?></td>
                          <td><?php
						  
						  
												
 $stockused	= stockused($goods_sn,$storeid);
							
							
						
						  
						  ?>                            &nbsp;</td>
                          <td><?php
						  
						  $stockbookused	= stockbookused($goods_sn,$in_warehouse);
						  echo $stockbookused;
						  
						  ?></td>
                          <td><?php
								echo $truestock - $stockused;

							
							
							
							?></td>
                          <td>&nbsp;
                          <textarea name="goods_cost" cols="5" rows="1" id="goods_cost<?php echo $id ?>" ><?php echo $goods_cost;?></textarea></td>
                          <td>&nbsp;
                          <textarea name="goods_count" cols="6" rows="1" id="goods_count<?php echo $id ?>" ><?php echo $goods_count;?></textarea></td>
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
                          <td>&nbsp;</td>
                          <td>总成本&nbsp;</td>
                          <td><?php echo $totalprice;?>&nbsp;</td>
                          <td><?php echo $totalqty;?>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="13">产品编号：
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

	function printorder(){
	
		var url = 'productinoutprint.php?ordersn=<?php echo $io_ordersn;?>';
		window.open(url);
		
		
	
	
	
	}
	
	function del(id){
	
	
		
		if(confirm("确认删除此条记录吗")){
			
		location.href="purchasecomeorderadd.php?&module=purchase&action=采购订单&io_ordersn=<?php echo $io_ordersn;?>&addtype=del&stype=<?php echo $stype;?>&id="+id;
		
		
		}
		
	
	
	}
	
	
	function mod(id){
	
		var goods_cost				= document.getElementById('goods_cost'+id).value;
		var goods_count				= document.getElementById('goods_count'+id).value;
		
		if(confirm("确认删除此条记录吗")){
		
		
		var url					= "purchasecomeorderadd.php?addtype=mod&module=purchase&action=采购订单&io_ordersn=<?php echo $io_ordersn;?>&stype=<?php echo $stype;?>&goods_count="+goods_count+"&goods_cost="+goods_cost+"&modid="+id;
		
		location.href			= url;
		
		
		
		}
		
	
	}
	

	function add(){
		
		
		var io_partner					= document.getElementById('io_partner').value;
		var note						= document.getElementById('note').value;
		var io_purchaseuser				= document.getElementById('io_purchaseuser').value;
		var deliverytime				= '';
		var io_paymentmethod			= document.getElementById('io_paymentmethod').value;
		var in_warehouse				= document.getElementById('in_warehouse').value;
		if(io_partner =='') {alert('请选择供应商');return false};
		if(io_purchaseuser =='') {alert('请选择采购员');return false};
		if(io_paymentmethod =='') {alert('请选择付款方式');return false};
		if(in_warehouse =='') {alert('请选择仓库');return false};
		
		
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
		
				
		location.href="purchasecomeorderadd.php?&module=purchase&action=采购订单&io_ordersn=<?php echo $io_ordersn;?>&goods_sn="+encodeURIComponent(goods_sn)+"&goods_count="+goods_count+"&addtype=add&stype=<?php echo $stype;?>&cost="+cost+"&addtype=save&io_partner="+io_partner+"&io_purchaseuser="+io_purchaseuser+"&note="+note+"&deliverytime="+deliverytime+"&io_paymentmethod="+io_paymentmethod+"&in_warehouse="+in_warehouse;
		
			
	}
	
	function save(){
		
		var io_partner					= document.getElementById('io_partner').value;
		var note						= document.getElementById('note').value;
		var io_purchaseuser				= document.getElementById('io_purchaseuser').value;
		var deliverytime				= '';
		var io_paymentmethod			= document.getElementById('io_paymentmethod').value;
		var in_warehouse				= document.getElementById('in_warehouse').value;
		
		
		if(io_partner =='') {alert('请选择供应商');return false};
		if(io_purchaseuser =='') {alert('请选择采购员');return false};
		
		if(io_paymentmethod =='') {alert('请选择付款方式');return false};
		if(in_warehouse =='') {alert('请选择仓库');return false};
		
		var url					= "purchasecomeorderadd.php?addtype=save&io_partner="+io_partner+"&io_purchaseuser="+io_purchaseuser+"&note="+note+"&module=purchase&action=采购订单&io_ordersn=<?php echo $io_ordersn;?>&stype=<?php echo $stype;?>&deliverytime="+io_paymentmethod+"&io_paymentmethod="+io_paymentmethod+"&deliverytime="+deliverytime+"&in_warehouse="+in_warehouse;
		location.href			= url;
		
	
	}
	
	function audit(){
		
		
		var io_partner					= document.getElementById('io_partner').value;
		var note						= document.getElementById('note').value;
		var io_purchaseuser				= document.getElementById('io_purchaseuser').value;
		var deliverytime				= '';
		var io_paymentmethod			= document.getElementById('io_paymentmethod').value;
		var in_warehouse				= document.getElementById('in_warehouse').value;
		
		
		if(io_partner =='') {alert('请选择供应商');return false};
		if(io_purchaseuser =='') {alert('请选择采购员');return false};
		
		if(io_paymentmethod =='') {alert('请选择付款方式');return false};
		if(in_warehouse =='') {alert('请选择仓库');return false};
		
		
		
		var url					= "purchasecomeorderadd.php?addtype=audit&astatus=1&action=采购订单&io_ordersn=<?php echo $io_ordersn;?>&module=purchase&stype=<?php echo $stype;?>";
		location.href			= url;
		
	
	
	}
	
	function auditf(){
	
		
		
		
		var io_partner					= document.getElementById('io_partner').value;
		var note						= document.getElementById('note').value;
		var io_purchaseuser				= document.getElementById('io_purchaseuser').value;
		var deliverytime				= '';
		var io_paymentmethod			= document.getElementById('io_paymentmethod').value;
		var in_warehouse				= document.getElementById('in_warehouse').value;
		
		
		if(io_partner =='') {alert('请选择供应商');return false};
		if(io_purchaseuser =='') {alert('请选择采购员');return false};
		
		if(io_paymentmethod =='') {alert('请选择付款方式');return false};
		if(in_warehouse =='') {alert('请选择仓库');return false};
		
		
		var url					= "purchasecomeorderadd.php?addtype=audit&astatus=0&action=采购订单&io_ordersn=<?php echo $io_ordersn;?>&module=purchase&stype=<?php echo $stype;?>";
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
	
	function chagegorder(){
		
		var io_purchaseorder		= document.getElementById('io_purchaseorder').value;
		
		if(io_purchaseorder ==''){
				
				alert("采购订单编号：不能为空");
				return false;		
		}
		
		var url ='purchasecomeorderadd.php?action=采购收货单&stype=3&module=purchase&io_purchaseorder='+io_purchaseorder;
			
		location.href = url;
		
	
	}

</script>