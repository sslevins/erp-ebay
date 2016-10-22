<?php
include "include/config.php";


include "top.php";
	if(!in_array("14",$cpower)){	
	
			echo "<font color=red>对不起，您没有出入库单明细表的的权限。</font>";
	
			die();		
	
			}
	
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
	
	
		
	<td nowrap="nowrap" scope="row" >查找：单据类型：
	  <select name="dtype" id="dtype">
        <option value="">请选择</option>
	    <option value="0">入库单</option>
	    <option value="1">出库单</option>
	    </select>
	  &nbsp;&nbsp;单据状态
	  <select name="dstatus" id="dstatus">
        <option value="">请选择</option>
	    <option value="0">未审核</option>
	    <option value="1">已审核</option>
	    </select>
	   关键字： 
	   <input name="dkeys" type="text" id="dkeys" />
	   开始时间
	   <input name="start" id="start" type="text" onclick="WdatePicker()" />
	   结束时间
	   <input name="end" id="end" type="text" onclick="WdatePicker()" />
	   <select name="in_warehouse" id="in_warehouse">
         <option value="-1" >未设置</option>
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
	   <input type="button" value="查找" onclick="searchtj()"/></td>
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
					<th scope='col' nowrap="nowrap">出库库类型</th>
					<th scope='col' nowrap="nowrap">供应商</th>
					<th scope='col' nowrap="nowrap">仓库</th>
					<th scope='col' nowrap="nowrap">添加时间</th>
		            <th scope='col' nowrap="nowrap">单据状态</th>
                    <th scope='col' nowrap="nowrap">添加用户</th>
        <th scope='col'  nowrap="nowrap">操作</th>
	</tr>
		
   <?php 			
   					$type		= $_REQUEST['type'];
					if($type	== 'search'){
						
						$dstatus				= $_REQUEST['dstatus'];
						$dkeys					= $_REQUEST['dkeys'];
						$dtype					= $_REQUEST['dtype'];
						$start					= $_REQUEST['start'];
						$end					= $_REQUEST['end'];
						$in_warehouse			= $_REQUEST['in_warehouse'];
					}
					
				  
				  	$sql = "select * from  ebay_iostore where ebay_user='$user'";
					if($dstatus != "") $sql .= " and io_status='$dstatus'";
					if($dtype != "")  $sql .= " and type='$dtype'";
					
					if($start !='' && $end != ''){
						
						$start	= strtotime($start);
						$end	= strtotime($end);
						
						$sql.= " and(io_addtime>=$start and io_addtime<=$end) ";
						
						
					
					}
					
					if($in_warehouse !='' && $in_warehouse !='-1'){
					
						
						$sql.= " and io_warehouse ='$in_warehouse'";
						
					
					}
					

					
					
					if($dkeys != ""){
						
				
				
				
					$sql	= "select a.*,b.* from ebay_iostore as a join ebay_iostoredetail as b on a.io_ordersn=b.io_ordersn where (b.goods_sn like '%$dkeys%' or b.goods_name like '%$dkeys%') and ebay_user='$user'";
					if($dstatus != "") $sql .= " and a.io_status='$dstatus'";
					if($dtype != "")  $sql .= " and a.type='$dtype'";
					
					
					
					
					if($start !='' && $end != ''){
						
						$start	= strtotime($start);
						$end	= strtotime($end);
						
						$sql.= " and(aio_addtime>=$start and a.io_addtime<=$end) ";
						
						
					
					}
					
					if($in_warehouse !='' && $in_warehouse !='-1'){
					
						
						$sql.= " and aio_warehouse ='$in_warehouse'";
						
					
					}
					
					$sql    .= " group by a.io_ordersn";
					
					
					

				
					
					}
					
			
						$query		= $dbcon->query($sql);

				$total		= $dbcon->num_rows($query);

				$totalpages = $total;

				

				

				$pageindex  =( isset($_GET['pageindex']) )?$_GET['pageindex']:1;

				$limit = " limit ".($pageindex-1)*$pagesize.",$pagesize";

		

				

				$page=new page(array('total'=>$total,'perpage'=>$pagesize));

				$sql = $sql.$limit;
				
			
					$sql = $dbcon->execute($sql);
					$sql = $dbcon->getResultArray($sql);
				
					for($i=0;$i<count($sql);$i++){
						
						$id					= $sql[$i]['id'];
						$io_ordersn 			= $sql[$i]['io_ordersn'];
						$io_type 			= $sql[$i]['io_type'];
						$operationuser				= $sql[$i]['operationuser'];
						$ss	 = "SELECT * FROM `ebay_storetype` where id='$io_type'";
						$ss	 = $dbcon->execute($ss);
						$ss	 = $dbcon->getResultArray($ss);
						$sstype	= $ss[0]['ebay_storename'];
						
						
								
						$io_addtime 			= $sql[$i]['io_addtime'];								
						$io_warehouse 			= $sql[$i]['io_warehouse'];
						$io_status				= $sql[$i]['io_status'];
						$type					= $sql[$i]['type'];
						$partner					= $sql[$i]['partner'];
						
						if($type == "0"){
							
							$stype				= "入库";
						
						}else{
						
							$stype				= "出库";
						}
						
						$st			= "select * from ebay_store where id='$io_warehouse'";
						$st = $dbcon->execute($st);
						$st = $dbcon->getResultArray($st);
						$stwarehousename		= $st[0]['store_name'];
						
						
						$st			= "select * from ebay_partner where id='$partner'";
						$st = $dbcon->execute($st);
						$st = $dbcon->getResultArray($st);
						$company_name		= $st[0]['company_name'];
						
				  ?>
                  
                  
                  
		    
 
					<tr height='20' class='oddListRowS1'>
						    <td scope='row' align='left' valign="top" ><?php echo $id; ?></td>				
						    <td scope='row' align='left' valign="top" ><?php echo $io_ordersn;?>&nbsp;</td>				
						    <td scope='row' align='left' valign="top" ><?php echo $stype;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $sstype;?></td>
						    <td scope='row' align='left' valign="top" ><?php echo $company_name;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $stwarehousename;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo date('Y-m-d H:i:s',$io_addtime);?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $io_status?"已审核":"未审核";?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $operationuser;?></td>
						    <td scope='row' align='left' valign="top" >
                            
                            <?php if($type == '0'){ ?>
                            
                            <a href="instoreadd.php?storeid=<?php echo $id; ?>&module=warehouse&action=入库&io_ordersn=<?php echo $io_ordersn;?>&stype=<?php echo $stype; ?>" target="_parent">修改</a> 
                            
                            <?php }else{ ?>
                            <a href="outstoreadd.php?storeid=<?php echo $id; ?>&module=warehouse&action=出库&io_ordersn=<?php echo $io_ordersn;?>&stype=<?php echo $stype; ?>" target="_parent">修改</a> 
                            
                            <?php } ?>
                            
                            
                            <?php if($dstatus =='0'){ ?>
                            <a href="#" onClick="del(<?php echo $id; ?>)">删除</a>
						    <?php } ?>
                            <a href="productinoutprint.php?ordersn=<?php echo $io_ordersn;?>" target='_blank'>打印</a>
                            &nbsp;</td>
			 		</tr>
              
              
              
              <?php
			  
			  
			  }
			  ?>
              
		<tr class='pagination'>
		<td colspan='10'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'><?    echo '<br><center>'.$page->show(2)."</center>";//输出分页 ?></td>
					</tr>
			</table>		</td>
	</tr></table>


    <div class="clear"></div>
<?php

include "bottom.php";


?>
<script language="javascript">
	
	function searchtj(id){
		
		
		var 	dtype		= document.getElementById('dtype').value;
		var 	dstatus		= document.getElementById('dstatus').value;
		var 	dkeys		= document.getElementById('dkeys').value;
		
		var 	end		= document.getElementById('end').value;
		var 	start		= document.getElementById('start').value;
		var 	in_warehouse		= document.getElementById('in_warehouse').value;
		var 	url			= "inandoutbiao.php?module=warehouse&action=出入库单明细表&type=search&dtype="+dtype+"&dstatus="+dstatus+"&dkeys="+dkeys+"&start="+start+"&end="+end+"&in_warehouse="+in_warehouse;
		
		location.href		= url;
		
	
	}



</script>