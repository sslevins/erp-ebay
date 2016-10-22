<?php
include "include/config.php";


include "top.php";

$cpower	= explode(",",$_SESSION['power']);

$warehouse			= $_REQUEST['warehouse'];
$keys				= $_REQUEST['keys'];
$account			= $_REQUEST['acc'];
$start				= $_REQUEST['start'];
$end				= $_REQUEST['end'];
$isskusort				= $_REQUEST['isskusort'];
$goodssort					= $_REQUEST['goodssort'];
$sortwarehouse				= $_REQUEST['sortwarehouse'];
$ordertype				= $_REQUEST['ordertype'];

if($ordertype == '') $ordertype ='1';

 ?>
 
  <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>

<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status;?> </h2>
</div>

<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
		
	<td nowrap="nowrap" scope="row" >按编号查：
	  <input name="keys" type="text" id="keys" value=<?php echo $keys; ?> >
	  
	  eBay帐号
	  <select name="acc" id="acc" onchange="changeaccount()">
        <option value="">Please select</option>
        <?php 

					

					$sql	 = "select ebay_account from ebay_account as a where a.ebay_user='$user' and ($ebayacc) order by ebay_account desc ";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 	$acc	= $sql[$i]['ebay_account'];
					 ?>
        <option value="<?php echo $acc;?>" <?php if($account == $acc) echo "selected=selected" ?>><?php echo $acc;?></option>
        <?php } ?>
      </select>
	  
            仓库：
<select name="warehouse" id="warehouse">
                            <option value="0">Please select</option>
                            <?php 
							
							$sql = "select id,store_name from  ebay_store where ebay_user='$user'";									
							$sql = $dbcon->execute($sql);
							$sql = $dbcon->getResultArray($sql);
				
							for($i=0;$i<count($sql);$i++){
								$id					= $sql[$i]['id'];
								$store_name			= $sql[$i]['store_name'];	
							?>
                            <option value="<?php echo $id;?>" <?php if ($warehouse == $id) echo 'selected="selected"';?>><?php echo $store_name; ?></option>
                            <?php
							}
							
							
							?>
                            
                            
            </select>
出入时间:
<input name="start" id="start" type="text" onclick="WdatePicker()" value="<?php echo $start;?>" />
~
<input name="end" id="end" type="text" onclick="WdatePicker()" value="<?php echo $end;?>" />
<br />
汇总类型：
<select name="isskusort" id="isskusort">
  <option value="0" <?php if ($isskusort == '0') echo 'selected="selected"';?> >按sku出入库明细</option>
  <option value="1" <?php if ($isskusort == '1') echo 'selected="selected"';?>>按sku汇总统计</option>
  
  
</select>
单据类型

：
<select name="ordertype" id="ordertype">
 <option value="1" <?php if ($ordertype == '1') echo 'selected="selected"';?>>按出库单查</option>
  <option value="0" <?php if ($ordertype == '0') echo 'selected="selected"';?> >按入库单查</option>
 
</select>
<input type="button" value="查找" onclick="searchorder()" />
	<input type="button" value="导出查询结果" onclick="searchordertoxls()" />
	<br />
	<br /></td>
</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='9'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" width='2%' class='paginationActionButtons'>&nbsp;</td>
				  <td  nowrap='nowrap' width='1%' align="right" class='paginationChangeButtons'>				  </td>
				</tr>
			</table>		</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap">日期</th>
					<th scope='col' nowrap="nowrap">帐号</th>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>产品编号</div></th>
			
		            <th scope='col' nowrap="nowrap">产品名称</th>
        <th scope='col' nowrap="nowrap">&nbsp;
        
        <?php 
		
		if($ordertype == '1') echo '出库';
		if($ordertype == '0') echo '入库';
		
		 ?>数量</th>
        <th scope='col' nowrap="nowrap">币种</th>
	    <th scope='col' nowrap="nowrap"> <?php 
		
		if($ordertype == '1') echo '售价';
		if($ordertype == '0') echo '成本';
		
		 ?></th>
		<th scope='col' nowrap="nowrap">物品成本</th>
	    <th scope='col' nowrap="nowrap">邮费(ebay设置邮费)</th>
	    <th scope='col' nowrap="nowrap">总价</th>
	</tr>
		


			  <?php
			  	
				
			
				$sql = "select * from  ebay_iostore as a join ebay_iostoredetail as b on a.io_ordersn = b.io_ordersn where a.ebay_user='$user' and a.type='$ordertype' and a.io_status='1'  ";	
				$sql2 = "select sum(b.goods_count) as allcount,sum(b.goods_cost) as allcost,sum(b.goods_cost*b.goods_count) as allprice from  ebay_iostore as a join ebay_iostoredetail as b on a.io_ordersn = b.io_ordersn where a.ebay_user='$user' and a.type='$ordertype' and a.io_status='1' ";
				if($isskusort =='1'){
				$sql = "select a.io_audittime,a.ebay_account,sum(b.goods_count) as goods_count,goods_sn,goods_name,sum(goods_cost) as goods_cost,transactioncurrncy  from  ebay_iostore as a join ebay_iostoredetail as b on a.io_ordersn = b.io_ordersn where a.ebay_user='$user' and a.type='$ordertype' and a.io_status='1'  ";	
				}
				if($warehouse > 0){
					$sql	.= " and io_warehouse ='$warehouse'";
					$sql2  .= " and io_warehouse ='$warehouse'";
				}
				
				if($account != ''){
					$sql .= " and ebay_account ='$account' ";
					$sql2 .= " and io_warehouse ='$warehouse' ";
				}
				if($keys != ''){
					$sql.= " and b.goods_sn ='$keys' ";
					$sql2.= " and b.goods_sn ='$keys' ";
				}	
				
				if($start != '' && $end != '' ){
					
					$start		= strtotime($start.' 00:00:00');
					$end		= strtotime($end.' 23:59:59');
					$sql		.= " and (io_audittime >= $start and io_audittime	<= $end) ";
					$sql2		.= " and (io_audittime >= $start and io_audittime	<= $end) ";
				}

				if($isskusort !='1'){
				$sql	.= " order by a.io_audittime desc ";
				}else{
					
					$sql	.= " group by b.goods_sn";
				
				}


				
				$query		= $dbcon->query($sql);
				$total		= $dbcon->num_rows($query);
				
				$pageindex  =( isset($_GET['pageindex']) )?$_GET['pageindex']:1;
				$limit = " limit ".($pageindex-1)*$pagesize.",$pagesize";
		
				
				$page=new page(array('total'=>$total,'perpage'=>$pagesize));
				$sql = $sql.$limit;
				$sql		= $dbcon->execute($sql);
				$sql		= $dbcon->getResultArray($sql);
				//echo $sql2;
				$sql2		= $dbcon->execute($sql2);
				$sql2		= $dbcon->getResultArray($sql2);
				$namess = $ordertype? '售价':'成本';
				echo "<font style='font-size:16px;'>总数量：".$sql2[0]['allcount']."   总$namess ：".number_format($sql2[0]['allcost'],2)."  总价合计：".number_format($sql2[0]['allprice'],2)."</font>";
		
				
				for($i=0;$i<count($sql);$i++){
					
					$io_audittime			= date('Y-m-d H:i',$sql[$i]['io_audittime']);
					$goods_sn				= $sql[$i]['goods_sn'];
					$goods_count			= $sql[$i]['goods_count'];
					$ebay_account			= $sql[$i]['ebay_account'];
					$goods_name				= $sql[$i]['goods_name'];
					$vvcost ="select goods_cost from ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
					$vvcost		= $dbcon->execute($vvcost);
					$vvcost		= $dbcon->getResultArray($vvcost);
					$cost		= $vvcost[0]['goods_cost'];
					$goods_cost						= number_format($sql[$i]['goods_cost'],2);
					$transactioncurrncy				= $sql[$i]['transactioncurrncy'];
					
					
					
					$sourceorder				= $sql[$i]['sourceorder'];
					
					$vvshipfee					= "select b.shipingfee from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn = b.ebay_ordersn and a.ebay_id='$sourceorder' and b.sku='$goods_sn' and b.ebay_amount ='$goods_count' ";

					
					$vvshipfee		= $dbcon->execute($vvshipfee);
					$vvshipfee		= $dbcon->getResultArray($vvshipfee);
					$vvshipfee		= $vvshipfee[0]['ebay_shipfee']?$vvshipfee[0]['ebay_shipfee']:0;
					
					
					
					
			  ?>
              
              
                  
         		<tr height='20' class='oddListRowS1'>
         		  <td scope='row' align='left' valign="top" ><?php echo $io_audittime;?>&nbsp;</td>
						<td scope='row' align='left' valign="top" ><?php echo $ebay_account;?>&nbsp;</td>
						<td scope='row' align='left' valign="top" >
						  <?php echo $goods_sn; ?>                            </td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $goods_name;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $goods_count; ?>&nbsp;</td>
                            <td scope='row' align='left' valign="top" ><?php echo $transactioncurrncy;?>&nbsp;</td>
	                        <td scope='row' align='left' valign="top" ><?php echo $goods_cost;?>&nbsp;</td>
							<td scope='row' align='left' valign="top" ><?php echo $cost;?>&nbsp;</td>
	                        <td scope='row' align='left' valign="top" ><?php echo $vvshipfee;?>&nbsp;</td>
	                        <td scope='row' align='left' valign="top" ><?php echo $goods_cost * $goods_count + $vvshipfee;?>&nbsp;</td>
	  </tr>
              


 
               <?php } ?>
		<tr class='pagination'>
		<td colspan='9'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'><div align="center">
					一共有 <?php echo $total; ?> 个SKU
					
					<?    echo '<br><center>'.$page->show(2)."</center>";//输出分页 ?> 
                </div></td>
					</tr>
			</table>		</td>
	</tr></table>


    <div class="clear"></div>
<?php

include "bottom.php";


?>
<script language="javascript">


		function searchorder(){
	
		

		var content		 		= document.getElementById('keys').value;
		var acc			 		= document.getElementById('acc').value;
		var warehouse			= document.getElementById('warehouse').value;
		
		var start				= document.getElementById('start').value;
		var end					= document.getElementById('end').value;
		
		var isskusort					= document.getElementById('isskusort').value;
		var ordertype					= document.getElementById('ordertype').value;
		
		location.href= 'productreport01.php?keys='+encodeURIComponent(content)+"&module=warehouse&action=&acc="+acc+"&warehouse="+warehouse+"&start="+start+"&end="+end+"&isskusort="+isskusort+"&ordertype="+ordertype;
		
		
		
		
	}
	
		function searchordertoxls(){
	
		

		var content		 		= document.getElementById('keys').value;
		var acc			 		= document.getElementById('acc').value;
		var warehouse			= document.getElementById('warehouse').value;
		
		var start				= document.getElementById('start').value;
		var end					= document.getElementById('end').value;
		
		var isskusort					= document.getElementById('isskusort').value;
		var ordertype					= document.getElementById('ordertype').value;
		
		location.href= 'labeltocrkdetails.php?keys='+encodeURIComponent(content)+"&module=warehouse&action=&acc="+acc+"&warehouse="+warehouse+"&start="+start+"&end="+end+"&isskusort="+isskusort+"&ordertype="+ordertype;
		
		
		
		
	}

</script>