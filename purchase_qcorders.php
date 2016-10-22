<?php
include "include/config.php";


include "top.php";


	

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
	
	$stype				= $_REQUEST['stype'];
	$dstatus			= $_REQUEST['dstatus'];
	$keys				= trim($_REQUEST['keys']);
	$searchs			= $_REQUEST['searchs'];
	$warehouse			= $_REQUEST['warehouse'];
	$startdate			= $_REQUEST['startdate'];
	$enddate			= $_REQUEST['enddate'];
	$times				= $_REQUEST['times'];
	$datype				= $_REQUEST['datype'];
 ?>
    <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>

<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo '采购计划单'.$status;?> &nbsp;</h2>
</div>

<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
		
	<td nowrap="nowrap" scope="row" ></a>
    
    
    <br />
  查找：
  <input name="keys" type="text" id="keys" value="<?php echo $keys;?>"  />
  单据添加时间：
	  <input name="startdate" type="text" id="startdate" onClick="WdatePicker()" value="<?php echo $startdate;?>"/>
	  ~
	  <input name="enddate" type="text" id="enddate" onClick="WdatePicker()" value="<?php echo $enddate;?>" />
	  
      仓库：

      <select name="warehouse" id="warehouse">
  <option value="">Please select</option>
  <?php 
							
							$sql = "select id,store_name from  ebay_store where ebay_user='$user'";									
							$sql = $dbcon->execute($sql);
							$sql = $dbcon->getResultArray($sql);
				
							for($i=0;$i<count($sql);$i++){
						
								$id					= $sql[$i]['id'];
								$store_name			= $sql[$i]['store_name'];	
						
							
							?>
  <option value="<?php echo $id;?>"><?php echo $store_name; ?></option>
  <?php
							}
							
							
							?>
</select>
&nbsp;&nbsp;
<input type="button" value="查找" onclick="searchorder()" /></td>
</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='13'>&nbsp;			</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>序号</div>			</th>
			
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>单号</div>			</th>
			
					<th scope='col' nowrap="nowrap"> 单据号 </th>
					<th scope='col' nowrap="nowrap">添加时间</th>
		            <th scope='col' nowrap="nowrap">应付金额</th>
                    <th scope='col' nowrap="nowrap">实付金额</th>
                    <th scope='col' nowrap="nowrap">备注</th>
                    <th scope='col' nowrap="nowrap">供应商</th>
                    <th scope='col' nowrap="nowrap"> 驳回理由 </th>
                    <th scope='col' nowrap="nowrap">采购人员</th>
                    <th scope='col' nowrap="nowrap">验收人员</th>
                    <th scope='col' nowrap="nowrap">仓库</th>
        <th scope='col'  nowrap="nowrap">操作</th>
	</tr>
		
   <?php 
				  
				  	$sql = "select * from  ebay_iostore as a  where a.ebay_user='$user' and a.type='96' and a.io_status='0'";	
					
					
					if($keys != '') $sql = "select * from  ebay_iostore as a join ebay_iostoredetail as b on a.io_ordersn = b.io_ordersn where a.ebay_user='$user' and a.type='96' and a.io_status='0' and b.goods_sn='$keys' ";	
					if($startdate != '' && $startdate != '') {
						$start		= strtotime($startdate.' 00:00:00');
						$end		= strtotime($startdate.' 23:59:59');
						$sql	.= " and (a.io_addtime>='$start' and a.io_addtime<='$end') ";
					}
					
					if($warehouse != '') $sql .=" and io_warehouse='$warehouse'";
					$sql 		.= " group by a.id  order by io_addtime desc ";
				

				
	
				
				$query		= $dbcon->query($sql);
				$total		= $dbcon->num_rows($query);
				$totalpages = $total;

				$pageindex  =( isset($_GET['pageindex']) )?$_GET['pageindex']:1;
				$limit = " limit ".($pageindex-1)*$pagesize.",$pagesize";
				$page=new page(array('total'=>$total,'perpage'=>$pagesize));
				$sql = $sql.$limit;
					$sql = $dbcon->execute($sql);
					$sql = $dbcon->getResultArray($sql);
					$totalcost		= 0;
					
					for($i=0;$i<count($sql);$i++){
						$io_paidtotal			= $sql[$i]['io_paidtotal'];
						$id						= $sql[$i]['id'];
						$io_ordersn 			= $sql[$i]['io_ordersn'];				
						$io_addtime 			= $sql[$i]['io_addtime'];								
						$io_warehouse 			= $sql[$i]['io_warehouse'];
						
						$vv 					= "select store_name from  ebay_store where ebay_user='$user' and id ='$io_warehouse'";									
						$vv 					= $dbcon->execute($vv);
						$vv 					= $dbcon->getResultArray($vv);
						$warehousename			= $vv[0]['store_name'];
						
						
						$io_status				= $sql[$i]['io_status'];
						$operationuser			= $sql[$i]['operationuser'];
						$audituser				= $sql[$i]['audituser'];
						$io_note				= $sql[$i]['io_note'];
						$io_partner				= $sql[$i]['io_partner'];
						$io_purchaseuser		= $sql[$i]['io_purchaseuser'];
						$qc_user				= $sql[$i]['qc_user'];
						$io_purchaseuser		= $sql[$i]['io_purchaseuser'];
						$sourceorder			= $sql[$i]['sourceorder'];
						$st	 = "SELECT company_name FROM `ebay_partner` where ebay_user='$user' and company_name ='$io_partner' ";
						$st	 = $dbcon->execute($st);
						$st	 = $dbcon->getResultArray($st);
						$company_name	= $st[0]['company_name'];
					
						$st						= "select store_name from ebay_store where id='$io_warehouse'";
						$st 					= $dbcon->execute($st);
						$st 					= $dbcon->getResultArray($st);
						$stwarehousename		= $st[0]['store_name'];
						
						
						$dsql			= "select sum(pay_money) as total from  ebay_iostorepay where io_ordersn='$io_ordersn'";
 						$dsql			= $dbcon->execute($dsql);
						$dsql			= $dbcon->getResultArray($dsql);
						$pay_moeny= $dsql[0][total];
			
						
						$ss			= "select goods_cost,goods_count from ebay_iostoredetail where io_ordersn ='$io_ordersn'";
						$ss		 	= $dbcon->execute($ss);
						$ss 		= $dbcon->getResultArray($ss);
						
				  ?>
					<tr height='20' class='oddListRowS1'>
						    <td scope='row' align='left' valign="top" ><?php echo $i+1; ?></td>				
						    <td scope='row' align='left' valign="top" ><a href="purchaseorderaddv3.php?storeid=<?php echo $id; ?>&module=purchase&action=&io_ordersn=<?php echo $io_ordersn;?>&stype=qcorders" target="_parent"><?php echo $io_ordersn;?></a></td>				
						    <td scope='row' align='left' valign="top" ><?php echo $sourceorder;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo date('Y-m-d H:i:s',$io_addtime);?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo number_format($io_paidtotal,2);?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><font color="#009933"><?php echo number_format($pay_moeny,2);?></font></td>
						    <td scope='row' align='left' valign="top" ><?php echo $io_note;?></td>
						    <td scope='row' align='left' valign="top" ><?php echo $company_name;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" >&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $io_purchaseuser;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $qc_user;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $warehousename;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><a href="purchaseorderaddv3.php?storeid=<?php echo $id; ?>&module=purchase&action=&io_ordersn=<?php echo $io_ordersn;?>&stype=qcorders" target="_parent">审核</a>&nbsp;</td>
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


    <div class="clear"></div>
<?php

include "bottom.php";


?>
<script language="javascript">
	
	function del(id){
		if(confirm('您确认删除此条记录吗')){
			location.href = 'purchaseorder.php?module=purchase&action=采购订单&stype=<?php echo $stype; ?>&id='+id+'&type=del&dstatus=<?php echo $dstatus; ?>';
		}
	}

	function searchorder(){
		
		
		var keys	 	= document.getElementById('keys').value;
		var startdate 	= document.getElementById('startdate').value;
		var enddate 	= document.getElementById('enddate').value;
		var warehouse 	= document.getElementById('warehouse').value;
		location.href	= 'purchase_qcorders.php?keys='+keys+"&module=purchase&action=&stype=<?php echo $stype; ?>&dstatus=<?php echo $dstatus; ?>&warehouse="+warehouse+"&startdate="+startdate+"&enddate="+enddate;
	}
	
	function instock(id){
		var url = 'purchase_newplanorders.php?module=purchase&id='+id;
		location.href	= url;
	}
	
	
	


	

</script>