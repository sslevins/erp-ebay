<?php
include "include/config.php";


include "top.php";


	

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
	$dstatus	= $_REQUEST['dstatus'];
	$keys				= $_REQUEST['keys'];
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
<h2><?php echo $_REQUEST['action'].$status;?> &nbsp;
    
    <a href="instorefrompurchase.php?module=warehouse&action=待收货&stype=2&stockstatus=0">待收货(  
    <?php		
		$sql		= "select id from ebay_iostore where (io_status=3 or io_status=4) and type='2' and ebay_user='$user' and stockstatus = 0";		
		$sql			= $dbcon->execute($sql);
		$sql			= $dbcon->getResultArray($sql);	
		echo count($sql);
	?>
    )</a>&nbsp;&nbsp;&nbsp;
  
    <a href="instorefrompurchase.php?module=warehouse&action=待质检&stype=2&stockstatus=1">待质检(  
    <?php		
		$sql		= "select id from ebay_iostore where  ebay_user='$user' and stockstatus = 1";		
		$sql			= $dbcon->execute($sql);
		$sql			= $dbcon->getResultArray($sql);	
		echo count($sql);
	?>
    )</a>&nbsp;&nbsp;&nbsp;
    
     <a href="instorefrompurchase.php?module=warehouse&action=未完成&stype=2&stockstatus=2">未完成(  
    <?php		
		$sql		= "select id from ebay_iostore where  ebay_user='$user' and stockstatus = 2";		
		$sql			= $dbcon->execute($sql);
		$sql			= $dbcon->getResultArray($sql);	
		echo count($sql);
	?>
    )</a>&nbsp;&nbsp;&nbsp;
    
    
    <a href="instorefrompurchase.php?module=warehouse&action=已完成&stype=2&stockstatus=3">已完成(  
    <?php		
		$sql		= "select id from ebay_iostore where  ebay_user='$user' and stockstatus = 3";		
		$sql			= $dbcon->execute($sql);
		$sql			= $dbcon->getResultArray($sql);	
		echo count($sql);
	?>
    )</a>&nbsp;&nbsp;&nbsp;
    
    
    <a href="purchaseorderadd.php?action=采购订单&stype=2&module=purchase"; target="_parent"></a></h2>
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
  开始时间：
	  <input name="startdate" type="text" id="startdate" onClick="WdatePicker()" value="<?php echo $startdate;?>"/>
	  结束时间：
	  <input name="enddate" type="text" id="enddate" onClick="WdatePicker()" value="<?php echo $enddate;?>" />
	  <select name="times" id="times">
        <option value="0" <?php if($times == '0') echo 'selected="selected"';?>>添加时间</option>
        <option value="1" <?php if($times == '1') echo 'selected="selected"';?>>审核时间</option>

      </select>   
      <br />
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
  <option value="<?php echo $id;?>"><?php echo $store_name; ?></option>
  <?php
							}
							
							
							?>
</select>
&nbsp;&nbsp;
<input type="button" value="查找" onclick="searchorder()" />
<br />
<br />
实际到货： 实际收到的货和预订的数量，有可能一样，比如说是多了或者少了。<br />
质检：质检的数量不能大于实际到货的数量。 报损：报损的数量，不能大于质检的数量，否则通不过。 实际到货/质检/报损 每次只能输入一个框，否则都将不成功！</td>
</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='8'>&nbsp;			</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>编号</div>			</th>
			
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>单号</div>			</th>
			
					<th scope='col' nowrap="nowrap">下单时间</th>
		            <th scope='col' nowrap="nowrap">入仓</th>
                    <th scope='col' nowrap="nowrap">添加用户</th>
                    <th scope='col' nowrap="nowrap">审核用户</th>
                    <th scope='col' nowrap="nowrap">总金额</th>
                    <th scope='col' nowrap="nowrap">备注</th>
        </tr>
		
   <?php 
				  	
					$stockstatus	= $_REQUEST['stockstatus'];
					
					if($stockstatus == 0){
					
					$sql = "select * from  ebay_iostore as a  where a.ebay_user='$user' and a.type='$stype' and (io_status=3 or io_status=4) and stockstatus = 0 ";	
					}else{
					$sql = "select * from  ebay_iostore as a  where a.ebay_user='$user' and a.type='$stype' and stockstatus = '$stockstatus' ";	
					}
					if($searchs == '1') $sql = "select * from  ebay_iostore as a join ebay_iostoredetail as b on a.io_ordersn = b.io_ordersn where a.ebay_user='$user' and a.type='$stype' and stockstatus = '$stockstatus' and b.goods_sn='$keys' ";	
					if($searchs == '2') $sql .= " and a.io_user ='$keys'";
					if($searchs == '3') $sql .= " and a.note like '%$keys%'";
					if($startdate != '' && $startdate != '') {
						$start		= strtotime($startdate.' 00:00:00');
						$end		= strtotime($startdate.' 23:59:59');
						if($times == '0')  $sql	.= " and (a.io_addtime>='$start' and a.io_addtime<='$end') ";
						if($times == '1')  $sql	.= " and (a.io_audittime>='$start' and a.io_audittime<='$end') ";
						
					
					}
					if($searchs == '4') $sql .= " and a.io_ordersn	 ='$keys'";
					
					
					if($datype == '1'){
					
							$sql	.= " and a.deliverytime <= $mctime  ";
					}
				$sql 	.= " group by a.id  order by io_addtime desc ";
					$query		= $dbcon->query($sql);

				$total		= $dbcon->num_rows($query);

				$totalpages = $total;

				

				
				//echo $sql;
				$pageindex  =( isset($_GET['pageindex']) )?$_GET['pageindex']:1;

				$limit = " limit ".($pageindex-1)*$pagesize.",$pagesize";

$page=new page(array('total'=>$total,'perpage'=>$pagesize));

				$sql = $sql.$limit;
													
			
					$sql = $dbcon->execute($sql);
					$sql = $dbcon->getResultArray($sql);
					$totalcost		= 0;
					
					for($i=0;$i<count($sql);$i++){
						
						$id					= $sql[$i]['id'];
						$io_ordersn 			= $sql[$i]['io_ordersn'];				
						$io_addtime 			= $sql[$i]['io_addtime'];								
						$io_warehouse 			= $sql[$i]['io_warehouse'];
						$io_status				= $sql[$i]['io_status'];
						$operationuser			= $sql[$i]['operationuser'];
						$audituser				= $sql[$i]['audituser'];
						$io_note				= $sql[$i]['io_note'];
						$st						= "select store_name from ebay_store where id='$io_warehouse'";
						$st 					= $dbcon->execute($st);
						$st 					= $dbcon->getResultArray($st);
						$stwarehousename		= $st[0]['store_name'];
						
						
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
						    <td scope='row' align='left' valign="top" ><?php echo date('Y-m-d H:i:s',$io_addtime);?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php 
							
							
							$vv	 = "select store_name from ebay_store where ebay_user='$user' and id ='$io_warehouse'";
							$vv	 = $dbcon->execute($vv);
							$vv	 = $dbcon->getResultArray($vv);
							echo $vv[0]['store_name'];
							
							?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $operationuser;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $audituser;?></td>
						    <td scope='row' align='left' valign="top" ><?php echo number_format($totalss,2);?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $io_note;?></td>
				    </tr>
					<tr height='20' class='oddListRowS1'>
					  <td scope='row' align='left' valign="top" >&nbsp;</td>
					  <td scope='row' align='left' valign="top" >&nbsp;</td>
					  <td colspan="6" align='left' valign="top" scope='row' >
                        <table width="100%" border="1">
                        <tr>
                          <td>编号</td>
                          <td>SKU</td>
                          <td>订货数量</td>
                          <td>到货/质检/报损</td>
                          <td>实际到货</td>
                          <td>质检</td>
                          <td>报损</td>
                          <td>&nbsp;</td>
                        </tr>
                        <?php
						
							$vv	= "select id,goods_sn,goods_name,goods_price,goods_cost,goods_unit,id,goods_count,stockqty,goods_count0,goods_count1,goods_count2 
 from ebay_iostoredetail where io_ordersn='$io_ordersn'";
							$vv	= $dbcon->execute($vv);
							$vv	= $dbcon->getResultArray($vv);
							for($v=0;$v<count($vv);$v++){
								
								$goods_sn			= $vv[$v]['goods_sn'];
								$goods_name 		= $vv[$v]['goods_name'];
								$goods_price 		= $vv[$v]['goods_price'];
								$goods_cost 		= $vv[$v]['goods_cost'];
								$goods_unit 		= $vv[$v]['goods_unit'];
								$id					= $vv[$v]['id'];
								$goods_count  		= $vv[$v]['goods_count'];
								$goods_count0  			= $vv[$v]['goods_count0']?$vv[$v]['goods_count0']:0;
								$goods_count1  			= $vv[$v]['goods_count1']?$vv[$v]['goods_count1']:0;
								$goods_count2  			= $vv[$v]['goods_count2']?$vv[$v]['goods_count2']:0;
						?>
                        
                        <tr>
                          <td>
	
						  <?php echo $id;?></td>
                          <td><?php echo $goods_sn;?>&nbsp;</td>
                          <td><?php echo $goods_count;?>&nbsp;</td>
                          <td><?php echo '<font color="#FF0000">'.$goods_count0.'</font> / '.'<font color="#330000">'.$goods_count1.'</font> / '.'<font color="#CC6600">'.$goods_count2.'</font>';?>&nbsp;</td>
                          <td>&nbsp; <textarea name="goods_count0<?php echo $id ?>" cols="6" rows="1" id="goods_count0<?php echo $id ?>" ></textarea></td>
                          <td><textarea name="goods_count1<?php echo $id ?>" cols="6" rows="1" id="goods_count1<?php echo $id ?>" ></textarea></td>
                          <td><textarea name="goods_count2<?php echo $id ?>" cols="6" rows="1" id="goods_count2<?php echo $id ?>" ></textarea></td>
                          <td><input name="input3" type="button" value="保存" onclick="addstock('<?php echo $id; ?>')"  /></td>
                        </tr>
                      	<?php
								
								}
								
						?>
                      </table></td>
	  </tr>
              
              
              
              <?php
			  
			  
			  }
			  ?>
              
		<tr class='pagination'>
		<td colspan='8'>
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
	function searchorder(){
		var keys	 	= document.getElementById('keys').value;
		var searchs 	= document.getElementById('searchs').value;
		var startdate 	= document.getElementById('startdate').value;
		var enddate 	= document.getElementById('enddate').value;
		var warehouse 	= document.getElementById('warehouse').value;
		var times	 	= document.getElementById('times').value;
		
		location.href	= 'instorefrompurchase.php?keys='+keys+"&module=warehouse&action=采购订单&stype=<?php echo $stype; ?>&stockstatus=<?php echo $stockstatus; ?>&warehouse="+warehouse+"&startdate="+startdate+"&enddate="+enddate+"&searchs="+searchs+"&times="+times;
	}
	function addstock(id){
		
		var goods_count0	= document.getElementById('goods_count0'+id).value;
		var goods_count1	= document.getElementById('goods_count1'+id).value;
		var goods_count2	= document.getElementById('goods_count2'+id).value;
		var url				= "purchaseorderinstok.php?id="+id+"&goods_count0="+goods_count0+"&goods_count1="+goods_count1+"&goods_count2="+goods_count2+"&in_warehouse=<?php echo $in_warehouse;?>";
		openwindow(url,'',850,400);
	}
</script>