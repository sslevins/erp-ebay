<?php
include "include/config.php";


include "top.php";

    $cpower	= explode(",",$_SESSION['power']);
	$type	= $_REQUEST['type'];
	if($type == "del"){
		$id	 = $_REQUEST['id'];
		$sql = "delete from  ebay_iostore where id=$id";
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
	
	$keys				= $_REQUEST['keys'];
	$searchs			= $_REQUEST['searchs'];
	$warehouse			= $_REQUEST['warehouse'];
	$startdate			= $_REQUEST['startdate'];
	$enddate			= $_REQUEST['enddate'];
	$times				= $_REQUEST['times'];
	$in_warehouseto				= $_REQUEST['in_warehouseto'];
	
	
	
 ?>
    <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>

<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status;?> &nbsp; <?php if(in_array("s_aoc_audit",$cpower)){?><a href="wtowarehouse.php?module=warehouse&action=未审核&stype=<?php echo $_REQUEST['stype'];?>&&dstatus=0">未审核(
    <?php
		
		$sql		= "select id from ebay_iostore where (io_status=0 or io_status='') and type='$stype' and ebay_user='$user'";		
		$sql			= $dbcon->execute($sql);
		$sql			= $dbcon->getResultArray($sql);	
		echo count($sql);
	?>
    
    
    
    
    )</a><?php }?>&nbsp;&nbsp;&nbsp; 
    
  <?php if(in_array("s_aoc_audit",$cpower)){?>  <a href="wtowarehouse.php?module=warehouse&action=已审核&stype=<?php echo $_REQUEST['stype'];?>&dstatus=1">已审核(
    <?php
		$sql		= "select id from ebay_iostore where io_status=1 and type='$stype' and ebay_user='$user'";		
		$sql			= $dbcon->execute($sql);
		$sql			= $dbcon->getResultArray($sql);	
		echo count($sql);
	?>
    )</a>&nbsp;&nbsp;&nbsp;
    
     <a href="wtowarehouse.php?module=warehouse&action=已调拨&stype=<?php echo $_REQUEST['stype'];?>&&dstatus=2">已调拨(
    <?php
		$sql		= "select id from ebay_iostore where io_status=2 and type='$stype' and ebay_user='$user'";		
		$sql			= $dbcon->execute($sql);
		$sql			= $dbcon->getResultArray($sql);	
		echo count($sql);
	?>
    )</a><?php }?>&nbsp;&nbsp;&nbsp;
    
    
    
 <?php if(in_array("s_aoc_add",$cpower)){?>    <a href="wtowarehouseadd.php?action=入库&stype=<?php echo $stype;?>&module=warehouse&action=入库"; target="_parent">添加调拨单</a><?php }?></h2>
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
  </select>
  调往仓库：
  <select name="in_warehouseto" id="in_warehouseto">
    <option value="-1" >未设置</option>
    <?php 
							$sql	 = "select store_name,id from ebay_store where ebay_user='$user'";
							$sql	 = $dbcon->execute($sql);
							$sql	 = $dbcon->getResultArray($sql);
							
							for($i=0;$i<count($sql);$i++){					
							$store_name	= $sql[$i]['store_name'];
							$cid			=  $sql[$i]['id'];
					 		?>
    <option value="<?php echo $cid;?>" <?php if($in_warehouseto == $cid) echo "selected=selected" ?>><?php echo $store_name;?></option>
    <?php } ?>
  </select>
  开始时间：
	  <input name="startdate" type="text" id="startdate" onClick="WdatePicker()" value="<?php echo $startdate;?>"/>
	  结束时间：
	  <input name="enddate" type="text" id="enddate" onClick="WdatePicker()" value="<?php echo $enddate;?>" />
	  <select name="times" id="times">
        <option value="0" <?php if($times == '0') echo 'selected="selected"';?>>添加时间</option>
        <option value="1" <?php if($times == '1') echo 'selected="selected"';?>>审核时间</option>

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
		<td colspan='10'>&nbsp;			</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>编号</div>			</th>
			
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>单号</div>			</th>
			
					<th scope='col' nowrap="nowrap">单据类型</th>
					<th scope='col' nowrap="nowrap">仓库</th>
					<th scope='col' nowrap="nowrap">添加时间</th>
		            <th scope='col' nowrap="nowrap">单据状态</th>
                    <th scope='col' nowrap="nowrap">添加用户</th>
                    <th scope='col' nowrap="nowrap">审核用户</th>
                    <th scope='col' nowrap="nowrap">总成本</th>
        <th scope='col'  nowrap="nowrap">操作</th>
	</tr>
		
   <?php 
				  
				  	$sql = "select id,io_ordersn,io_addtime,io_warehouse,io_status,operationuser,audituser from  ebay_iostore as a  where a.ebay_user='$user' and a.type='$stype' and a.io_status='$dstatus'";	
					  
					if($searchs == '1') $sql = "select a.id,a.io_ordersn,io_addtime,io_warehouse,io_status,operationuser,audituser from  ebay_iostore as a join ebay_iostoredetail as b on a.io_ordersn = b.io_ordersn where a.ebay_user='$user' and a.type='$stype' and a.io_status='$dstatus' and b.goods_sn='$keys' ";	
					
					if($searchs == '2') $sql .= " and a.io_user ='$keys'";
					if($searchs == '3') $sql .= " and a.io_note like '%$keys%'";
					if($startdate != '' && $startdate != '') {
						$start		= strtotime($startdate.' 00:00:00');
						$end		= strtotime($startdate.' 23:59:59');
						if($times == '0')  $sql	.= " and (a.io_addtime>='$start' and a.io_addtime<='$end') ";
						if($times == '1')  $sql	.= " and (a.io_audittime>='$start' and a.io_audittime<='$end') ";
					}
					if($searchs == '4') $sql .= " and a.io_ordersn	 ='$keys'";
					if($in_warehouseto > 0 ) $sql .= " and in_warehouseto='$in_warehouseto' ";
					 

					
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
						
						
						$id						= $sql[$i]['id'];
						$io_ordersn 			= $sql[$i]['io_ordersn'];				
						$io_addtime 			= $sql[$i]['io_addtime'];								
						$io_warehouse 			= $sql[$i]['io_warehouse'];
						$io_status				= $sql[$i]['io_status'];
						$operationuser			= $sql[$i]['operationuser'];
						$audituser				= $sql[$i]['audituser'];
						$st						= "select store_name from ebay_store where id='$io_warehouse'";
						$st 					= $dbcon->execute($st);
						$st 					= $dbcon->getResultArray($st);
						$stwarehousename		= $st[0]['store_name'];
						
						$ss			= "select goods_price,goods_count from ebay_iostoredetail where io_ordersn ='$io_ordersn'";
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
						    <td scope='row' align='left' valign="top" ><?php echo $strtype;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $stwarehousename;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo date('Y-m-d H:i:s',$io_addtime);?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $io_status?"已审核":"未审核";?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $operationuser;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $audituser;?></td>
						    <td scope='row' align='left' valign="top" ><?php echo number_format($totalss,2);?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" > <?php if(in_array("s_aoc_modify",$cpower)){?><a href="wtowarehouseadd.php?storeid=<?php echo $id; ?>&module=warehouse&action=入库&io_ordersn=<?php echo $io_ordersn;?>&stype=<?php echo $stype; ?>" target="_parent">修改</a> <?php }?>
                            <?php if($dstatus =='0'){ ?>
                       <?php if(in_array("s_aoc_delete",$cpower)){?>      <a href="#" onClick="del(<?php echo $id; ?>)">删除</a><?php }?>
						    <?php } ?>&nbsp;</td>
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


    <div class="clear"></div>
<?php

include "bottom.php";


?>
<script language="javascript">
	
	function del(id){
		if(confirm('您确认删除此条记录吗')){
			location.href = 'wtowarehouse.php?module=warehouse&action=入库单&stype=<?php echo $stype; ?>&id='+id+'&type=del&dstatus=<?php echo $dstatus; ?>';
		}
	}

	function searchorder(){
		var keys	 	= document.getElementById('keys').value;
		var searchs 	= document.getElementById('searchs').value;
		var startdate 	= document.getElementById('startdate').value;
		var enddate 	= document.getElementById('enddate').value;
		var warehouse 	='';
		
		var times	 	= document.getElementById('times').value;
		var in_warehouseto	 	= document.getElementById('in_warehouseto').value;
		
		
		location.href	= 'wtowarehouse.php?keys='+keys+"&module=warehouse&action=入库单&stype=<?php echo $stype; ?>&dstatus=<?php echo $dstatus; ?>&warehouse="+warehouse+"&startdate="+startdate+"&enddate="+enddate+"&searchs="+searchs+"&times="+times+"&in_warehouseto="+in_warehouseto;
	}

</script>