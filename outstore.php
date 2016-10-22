<?php
include "include/config.php";


include "top.php";

    
    $cpower	= explode(",",$_SESSION['power']);
   
	$type	= $_REQUEST['type'];
	if($type == "del"){
		
		$id	 = $_REQUEST['id'];
		$sql = "delete from  ebay_iostore where id=$id and ebay_user ='$user' ";
		
		
	if($dbcon->execute($sql)){
			
			$status	= " -[<font color='#33CC33'>操作记录: 记录删除成功</font>]";
			
		}else{
		
			$status = " -[<font color='#FF0000'>操作记录: 记录删除失败</font>]";
		}
		
		
		
	
	}else{
		
		$status = "";
		
	}
	
	$stype		= $_REQUEST['stype'];
	if($stype   == '0') $strtype	= "入库";
	$dstatus	= $_REQUEST['dstatus'];
	
	$keys				= trim($_REQUEST['keys']);
	$searchs			= $_REQUEST['searchs'];
	$warehouse			= $_REQUEST['warehouse'];
	$startdate			= $_REQUEST['startdate'];
	$enddate			= $_REQUEST['enddate'];
	$times				= $_REQUEST['timess'];
	
	
 ?>
    <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>

<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo '出库单'.$status;?> &nbsp;<?php if(in_array("s_o_audit",$cpower)) {?><a href="outstore.php?module=warehouse&stype=1&dstatus=0">未审核(
    <?php
		
		$sql		= "select id from ebay_iostore where (io_status=0 or io_status='') and type='1' and ebay_user='$user'";	
		$sql			= $dbcon->execute($sql);
		$sql			= $dbcon->getResultArray($sql);	
		echo count($sql);
		
		
	
	
	?>
    
    
    
    
    )</a><?php }?>&nbsp;&nbsp;&nbsp;<?php if(in_array("s_o_audit",$cpower)) {?> <a href="outstore.php?module=warehouse&stype=1&dstatus=1">已审核(
    
    <?php
		$sql		= "select id from ebay_iostore where io_status=1 and type='1' and ebay_user='$user'";
		
				
		$sql			= $dbcon->execute($sql);
		$sql			= $dbcon->getResultArray($sql);	
		echo count($sql);
	?>
    
    )</a><?php }?>&nbsp;&nbsp;&nbsp;<?php if(in_array("s_o_add",$cpower)){ ?><a href="outstoreadd.php?stype=<?php echo $stype;?>&module=warehouse&action="; target="_parent">添加出库单</a><?php }?></h2>
</div>

<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
		
	<td nowrap="nowrap" scope="row" ></a>
    
    
    <br />
  查找：
  <input name="keys" type="text" id="keys" value="<?php echo $keys;?>"  />
  <select name="searchs" id="searchs" >
   <option value="" selected="selected">请选择</option>
    <option value="1" <?php if($searchs == '1') echo 'selected="selected"';?>>物品编号(SKU)</option>
    <option value="2" <?php if($searchs == '2') echo 'selected="selected"';?>>经办人</option>
    <option value="3" <?php if($searchs == '3') echo 'selected="selected"';?>>备注</option>
    <option value="4" <?php if($searchs == '4') echo 'selected="selected"';?>>单号</option>
    <option value="5" <?php if($searchs == '5') echo 'selected="selected"';?>>订单管理-订单编号</option>
    
  </select>
  开始时间：
	  <input name="startdate" type="text" id="startdate" onClick="WdatePicker()" value="<?php echo $startdate;?>"/>
	  结束时间：
	  <input name="enddate" type="text" id="enddate" onClick="WdatePicker()" value="<?php echo $enddate;?>" />
	  <select name="times" id="times">
        <option value="0" <?php if($times == '0') echo 'selected="selected"';?>>添加时间</option>
        <option value="1" <?php if($times == '1') echo 'selected="selected"';?>>审核时间</option>

      </select>   
仓库:

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
  <option value="<?php echo $id;?>"  <?php if($id == $warehouse) echo 'selected="selected"';?>><?php echo $store_name; ?></option>
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
		<td colspan='11'>&nbsp;			</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>编号</div>			</th>
			
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>单号</div>			</th>
			
					<th scope='col' nowrap="nowrap">单据类型</th>
					<th scope='col' nowrap="nowrap">仓库</th>
					<th scope='col' nowrap="nowrap">添加时间</th>
		            <th scope='col' nowrap="nowrap">审核时间</th>
		            <th scope='col' nowrap="nowrap">单据状态</th>
                    <th scope='col' nowrap="nowrap">添加用户</th>
                    <th scope='col' nowrap="nowrap">审核用户</th>
                    <th scope='col' nowrap="nowrap">总成本</th>
        <th scope='col'  nowrap="nowrap">操作</th>
	</tr>
		
   <?php 
				  
				  	$sql = "select * from  ebay_iostore as a  where a.ebay_user='$user' and a.type='1' and a.io_status='$dstatus'";	
					  
					if($searchs == '1') $sql = "select * from  ebay_iostore as a join ebay_iostoredetail as b on a.io_ordersn = b.io_ordersn where a.ebay_user='$user' and a.type='1' and a.io_status='$dstatus' and b.goods_sn='$keys' ";	
					
					if($searchs == '2') $sql .= " and a.io_user ='$keys'";
					if($searchs == '3') $sql .= " and a.io_note like '%$keys%'";
					if($startdate != '' && $enddate != '') {
						$start		= strtotime($startdate.' 00:00:00');
						$end		= strtotime($enddate.' 23:59:59');
						if($times == '0')  $sql	.= " and (a.io_addtime>='$start' and a.io_addtime<='$end') ";
						if($times == '1')  $sql	.= " and (a.io_audittime>='$start' and a.io_audittime<='$end') ";
						
					
					}
					if($searchs == '4') $sql .= " and a.io_ordersn	 ='$keys'";
					if($warehouse > 0 ) 	$sql .= " and io_warehouse ='$warehouse' ";


	
					if($searchs == '5') $sql .= " and a.sourceorder = '$keys'";
					if($searchs == '4') $sql .= " and a.io_ordersn	 ='$keys'";
					$sql 	.= " order by io_addtime desc ";
				
			
			
										
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
						
						$id					= $sql[$i]['id'];
						$io_type				= $sql[$i]['io_type'];
						$io_ordersn 			= $sql[$i]['io_ordersn'];				
						$io_addtime 			= $sql[$i]['io_addtime'];								
						$io_warehouse 			= $sql[$i]['io_warehouse'];
						$io_status				= $sql[$i]['io_status'];
						$operationuser			= $sql[$i]['operationuser'];
						$audituser				= $sql[$i]['audituser'];
						
						$io_typename			= $st[0]['ebay_storename'];
						
						$io_audittime			=  $sql[$i]['io_audittime']?$sql[$i]['io_audittime']:'';
						if($io_audittime >0) $io_audittime = date('Y-m-d H:i',$io_audittime);
						
						
						$st						= "select * from ebay_store where id='$io_warehouse'";
						$st 					= $dbcon->execute($st);
						$st 					= $dbcon->getResultArray($st);
						$stwarehousename		= $st[0]['store_name'];
						
						$st						= "select ebay_storename from ebay_storetype where id='$io_type'";
						$st 					= $dbcon->execute($st);
						$st 					= $dbcon->getResultArray($st);
						$io_typename			= $st[0]['ebay_storename'];
						
						
						$ss			= "select goods_cost,goods_count from ebay_iostoredetail where io_ordersn ='$io_ordersn'";
						$ss		 	= $dbcon->execute($ss);
						$ss 		= $dbcon->getResultArray($ss);
						
					$totalss = 0;
					
						
						for($d=0;$d<count($ss);$d++){
							
							$goods_price				= $ss[$d]['goods_cost'];
							$goods_count				= $ss[$d]['goods_count'];
							
							$totalss					+= ($goods_price * $goods_count);
							 
						}
						$totalcost		+= $totalss;
						
						
				  ?>
					<tr height='20' class='oddListRowS1'>
						    <td scope='row' align='left' valign="top" ><?php echo $id; ?></td>				
						    <td scope='row' align='left' valign="top" ><?php echo $io_ordersn;?>&nbsp;</td>				
						    <td scope='row' align='left' valign="top" ><?php echo $io_typename;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $stwarehousename;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo date('Y-m-d H:i:s',$io_addtime);?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $io_audittime;?></td>
						    <td scope='row' align='left' valign="top" ><?php echo $io_status?"已审核":"未审核";?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $operationuser;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $audituser;?></td>
						    <td scope='row' align='left' valign="top" ><?php echo number_format($totalss,2);?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php if(in_array("s_o_modify",$cpower)){ ?><a href="outstoreadd.php?storeid=<?php echo $id; ?>&module=warehouse&action=入库&io_ordersn=<?php echo $io_ordersn;?>&stype=<?php echo $stype; ?>" target="_parent">修改</a> <?php }?>
                            <?php if($dstatus =='0'){ ?>
                       <?php if(in_array("s_o_delete",$cpower)){ ?>     <a href="#" onClick="del(<?php echo $id; ?>)">删除</a><?php }?>
						    <?php } ?>&nbsp;</td>
			 		</tr>
              
              
              
              <?php
			  
			  
			  }
			  ?>
              
		<tr class='pagination'>
		<td colspan='11'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons' align="center"><?    echo '<br><center>'.$page->show(2)."</center>";//输出分页 ?></td>
			  </tr>
			</table>		</td>
	</tr>
		<tr class='pagination'>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>总计</td>
		  <td>&nbsp;</td>
		  <td><?php echo number_format($totalcost,2); ?>&nbsp;</td>
		  <td>&nbsp;</td>
      </tr>
</table>


    <div class="clear"></div>
<?php

include "bottom.php";


?>
<script language="javascript">
	
	function del(id){
		if(confirm('您确认删除此条记录吗')){
			location.href = 'outstore.php?module=warehouse&action=入库单&stype=<?php echo $stype; ?>&id='+id+'&type=del&dstatus=<?php echo $dstatus; ?>';
		}
	}

	function searchorder(){
		var keys	 	= document.getElementById('keys').value;
		var searchs 	= document.getElementById('searchs').value;
		var startdate 	= document.getElementById('startdate').value;
		var enddate 	= document.getElementById('enddate').value;
		var warehouse 	= document.getElementById('warehouse').value;
		var times	 	= document.getElementById('times').value;
		
		location.href	= 'outstore.php?keys='+keys+"&module=warehouse&action=入库单&stype=<?php echo $stype; ?>&dstatus=<?php echo $dstatus; ?>&warehouse="+warehouse+"&startdate="+startdate+"&enddate="+enddate+"&searchs="+searchs+"&timess="+times;
	}

</script>