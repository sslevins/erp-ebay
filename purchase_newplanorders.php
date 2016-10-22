<?php
include "include/config.php";


include "top.php";


	

	$type	= $_REQUEST['type'];
		if($type == "del"){
		
		
		$id	 = $_REQUEST['id'];
		$ids = explode(',',$id);
		foreach($ids as $k=>$v){
		
					$sql = "select io_ordersn from ebay_iostore where id=$v";
					$sql = $dbcon->execute($sql);
					$sql = $dbcon->getResultArray($sql);
					$iosn	= $sql[0]['io_ordersn'];
					$sql1 = "delete from  ebay_iostoredetail where io_ordersn='$iosn' ";
					$sql = "delete from  ebay_iostore where id=$v and ebay_user ='$user' ";
					if($dbcon->execute($sql1) && $dbcon->execute($sql)){
						$status	= " -[<font color='#33CC33'>操作记录: 记录删除成功</font>]";
					}else{
						$status = " -[<font color='#FF0000'>操作记录: 记录删除失败</font>]";
					}
		}
		
		
	}else if($type == 'instock'){
		
		$id	 = $_REQUEST['id'];
		$vvsql		= "update ebay_iostore set type ='98' where id='$id'";
		if($dbcon->execute($vvsql)){
			$status	= " -[<font color='#33CC33'>操作记录: 已经成功转入</font>]";
		}else{
			$status = " -[<font color='#FF0000'>操作记录: 转入失败</font>]";
		}
	}else if($type == 'plinstock'){
		
		$id	 = substr($_REQUEST['bill'],1);
		$ids = explode(',',$id);
		foreach($ids as $k=>$v){
		
			$typestatus = $_REQUEST['typestatus'];
			$vvsql		= "update ebay_iostore set type ='$typestatus' where id='$v'";
			if($dbcon->execute($vvsql)){
				$status	= " -[<font color='#33CC33'>操作记录: $v 已经成功转入</font>]<br>";
			}else{
				$status = " -[<font color='#FF0000'>操作记录: $v 转入失败</font>]<br>";
			}
			
		}
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
  <option value="<?php echo $id;?>" <?php if($id == $warehouse) echo 'selected="selected"';?>><?php echo $store_name; ?></option>
  <?php
							}
							
							
							?>
</select>
&nbsp;&nbsp;
<input type="button" value="查找" onclick="searchorder()" />
<input type="button" value="批量删除" onclick="deleteallorders()" /></td>
</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='6'>&nbsp;			</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap"><span style="white-space: nowrap;">
				    <input name="ordersn" type="checkbox" id="ordersn" value="<?php echo $ordersn;?>" onclick="check_all('ordersn','ordersn')" />
					</span></th>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>编号</div>			</th>
			
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>单号</div>			</th>
					<th scope='col' nowrap="nowrap">总金额</th>
					<th scope='col' nowrap="nowrap">添加时间</th>
		            <th scope='col' nowrap="nowrap">添加用户/采购员</th>
					<th scope='col' nowrap="nowrap">仓库</th>
					<th scope='col' nowrap="nowrap">供应商</th>
					<th scope='col' nowrap="nowrap">外部链接</th>
                    <th scope='col' nowrap="nowrap">备注</th>
        <th scope='col'  nowrap="nowrap">操作</th>
	</tr>
		
   <?php 
				  
				  	$sql = "select * from  ebay_iostore as a  where a.ebay_user='$user' and a.type='99' and a.io_status='0'";	
					  
					if($keys != '') $sql = "select a.*,b.goods_sn from  ebay_iostore as a join ebay_iostoredetail as b on a.io_ordersn = b.io_ordersn where a.ebay_user='$user' and a.type='99' and a.io_status='0' and (b.goods_sn='$keys' or a.io_ordersn like '%$keys%') ";	
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
						$io_status				= $sql[$i]['io_status'];
						$operationuser			= $sql[$i]['operationuser'];
						$audituser				= $sql[$i]['audituser'];
						$io_note				= $sql[$i]['io_note'];
						$partner				= $sql[$i]['io_partner'];
						
						
						$io_purchaseuser			= $sql[$i]['io_purchaseuser'];
						
						
						
						$st						= "select store_name from ebay_store where id='$io_warehouse'";
						$st 					= $dbcon->execute($st);
						$st 					= $dbcon->getResultArray($st);
						$stwarehousename		= $st[0]['store_name'];
						
						
						$dsql			= "select sum(pay_money) as total from  ebay_iostorepay where io_ordersn='$io_ordersn'";
 						$dsql			= $dbcon->execute($dsql);
						$dsql			= $dbcon->getResultArray($dsql);
						$pay_moeny= $dsql[0][total];
			
						
						$ss			= "select sum(goods_cost*goods_count) as price from ebay_iostoredetail where io_ordersn ='$io_ordersn'";
						$ss		 	= $dbcon->execute($ss);
						$ss 		= $dbcon->getResultArray($ss);
						$price		= $ss[0]['price'];
						
				  ?>
					<tr height='20' class='oddListRowS1'>
							<td scope='row' align='left' valign="top" ><input name="ordersn" type="checkbox" id="ordersn" value="<?php echo $id;?>"   /></td>
						    <td scope='row' align='left' valign="top" ><?php echo $id; ?></td>				
						    <td scope='row' align='left' valign="top" >
							<a href="purchaseorderaddv3.php?storeid=<?php echo $id; ?>&module=purchase&io_ordersn=<?php echo $io_ordersn;?>&stype=newplan" target="_parent"><?php echo $io_ordersn;?></a></td>				
							<td scope='row' align='left' valign="top" ><?php echo number_format($price,2);?></td>
						    <td scope='row' align='left' valign="top" ><?php echo date('Y-m-d H:i:s',$io_addtime);?></td>
						    <td scope='row' align='left' valign="top" ><?php echo $operationuser.' / '.$io_purchaseuser;?>&nbsp;</td>
							<td scope='row' align='left' valign="top" ><?php echo $stwarehousename;?>&nbsp;</td>
							<td scope='row' align='left' valign="top" ><?php echo $partner;?>&nbsp;</td>
							<td scope='row' align='left' valign="top" ><a href="template.php?io_ordersn=<?php echo $io_ordersn;?>" target="_blank">打开</a>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $io_note;?></td>
						    <td scope='row' align='left' valign="top" ><a href="purchaseorderaddv3.php?storeid=<?php echo $id; ?>&module=purchase&io_ordersn=<?php echo $io_ordersn;?>&stype=newplan" target="_parent">编辑计划单</a>
                            
                            <?php 	if(in_array("purchase_deleteorders",$cpower)){	 ?> 

                            <a href="#" onClick="del(<?php echo $id; ?>)">删除</a>
                            <?php } ?>
                            <a href="#" onClick="instock(<?php echo $id; ?>)">转为入库单</a>
                            
                            <a href="toxls/pruchase_print.php?id=<?php echo $id;?>"   target="_blank">打印</a>
                            
						&nbsp;</td>
			 		</tr>
              <?php
			  }
			  ?>
              
		<tr class='pagination'>
		<td colspan='10'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons' align="center"><input name="submit1" type="button" onclick="saveorders('98')" value="批量转为入库单" />
					  <input name="submit3" type="button" onclick="saveorders('93')" value="批量转为预订中订单" />
					  <input name="submit2" type="button" onclick="printorders()" value="批量打印" />
					<?    echo '<br><center>'.$page->show(2)."</center>";//输出分页 ?></td>
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
			location.href = 'purchase_newplanorders.php?module=purchase&action=&stype=<?php echo $stype; ?>&id='+id+'&type=del&dstatus=<?php echo $dstatus; ?>';
		}
	}

	function searchorder(){
		var keys	 	= document.getElementById('keys').value;
		var startdate 	= document.getElementById('startdate').value;
		var enddate 	= document.getElementById('enddate').value;
		var warehouse 	= document.getElementById('warehouse').value;
		location.href	= 'purchase_newplanorders.php?keys='+keys+"&module=purchase&action=&stype=<?php echo $stype; ?>&dstatus=<?php echo $dstatus; ?>&warehouse="+warehouse+"&startdate="+startdate+"&enddate="+enddate;
		
	}
	function saveorders(type){
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				bill = bill + ","+checkboxs[i].value;
			}	
		}
		if(bill == ""){
			alert("请选择要转入的计划单");
			return false;
		}
		var url = 'purchase_newplanorders.php?module=purchase&bill='+bill+"&type=plinstock&typestatus="+type;
		location.href	= url;
	}
	function printorders(){
		
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				bill = bill + ","+checkboxs[i].value;
			}	
		}
		if(bill == ""){
			alert("请选择要打印的计划单");
			return false;
		}
		var url = 'toxls/pruchase_printall.php?bill='+bill;
		window.open(url,'_blank');
	}
	function instock(id){
		var url = 'purchase_newplanorders.php?module=purchase&id='+id+"&type=instock";
		location.href	= url;
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

	function deleteallorders(){
	
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				bill = bill + ","+checkboxs[i].value;
			}	
		}
		if(bill == ""){
			alert("请选择要打印的计划单");
			return false;
		}
		var url = 'purchase_newplanorders.php?module=purchase&action=采购计划单&id='+bill+'&type=del';
		location.href = url;
		
	}

	
</script>