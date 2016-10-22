<?php
include "include/config.php";
include "top.php";
	$type	= $_REQUEST['type'];
	if($type == "del"){
		
			$id	 = $_REQUEST['id'];
			$totalrecorder		= explode(',',$id);
			for($i=0;$i<count($totalrecorder);$i++){
				$selectid		= $totalrecorder[$i];
				if($selectid != ''){
				$sql = "delete from  ebay_goods_newplan where id=$selectid and ebay_user ='$user' ";
				if($dbcon->execute($sql)){
					$status	= " -[<font color='#33CC33'>操作记录: 记录删除成功</font>]";
				}else{
					$status = " -[<font color='#FF0000'>操作记录: 记录删除失败</font>]";
				}
				}
			}
	}
	
	$viewtype				= $_REQUEST['viewtype']?$_REQUEST['viewtype']:0;
	$keys					= trim($_REQUEST['keys']);
	$warehouse				= $_REQUEST['warehouse'];
	$startdate				= $_REQUEST['startdate'];
	$enddate				= $_REQUEST['enddate'];
	
	$kfuser					= $_REQUEST['kfuser'];
	$cguser					= $_REQUEST['cguser'];
	
	
	
	if(isset($_POST['addtype'])){
		$totalrecorder		= $_POST['totalrecorder']; // 取得一共有多少行记录
		$totalrecorder		= explode(',',$totalrecorder);
		$addtype					= $_POST['addtype'];
		if($addtype){
			$types = '93';
		}else{
			$types = '99';			// 采购计划单
		}
		//echo $types;

		for($i=0;$i<count($totalrecorder);$i++){
			
			$selectid		= $totalrecorder[$i];
			if($selectid != '' ){
				
				$goods_sn					= $_POST['goods_sn'.$selectid];
				$storeid					= $_POST['ebay_warehouse'.$selectid];
				$purchaseqty				= $_POST['purchaseqty'.$selectid];
				$purchaseprice				= $_POST['purchaseprice'.$selectid];
				$notes						= mysql_escape_string($_POST['notes'.$selectid]);
				
				
				
				$factory					= $_POST['factory'.$selectid];
				$updatesql					= "update ebay_goods_newplan set goods_count='$purchaseqty',notes='$notes',purchaseprice='$purchaseprice',partner='$factory' where id ='$selectid'";	
				$dbcon->execute($updatesql);
				/* 生成采购单 */
				
				$sql	 = "SELECT company_name FROM `ebay_partner` where id='$factory' ";
				$sql	 = $dbcon->execute($sql);
				$sql	 = $dbcon->getResultArray($sql);
				$factory = $sql[0]['company_name'];
				if($factory != ''){
					$ss		= "select id , io_ordersn from   ebay_iostore where io_partner ='$factory' and type ='$types' and io_status	='0' and io_warehouse ='$storeid'";
					$ss	 	= $dbcon->execute($ss);
					$ss	 	= $dbcon->getResultArray($ss);
					
									if(count($ss) == 0){
																			
										$io_ordersn	= "IO-".date('Y')."-".date('m')."-".date('d')."-".date("H").date('i').date('s'). mt_rand(1000, 9999);
										$sql	= "insert into ebay_iostore(io_ordersn,io_addtime,io_warehouse,io_type,io_status,io_note,ebay_user,type,operationuser,io_user,io_paymentmethod,io_partner,io_purchaseuser,partner,deliverytime) values('$io_ordersn','$mctime','$storeid','','0','采购计划生成','$user','$types','$truename','$truename','货到付款','$factory','$truename','$factory','$deliverytime')";
										if($dbcon->execute($sql)){
											$sql			= "select goods_name,goods_sn,goods_cost,goods_unit,goods_id,goods_cost from ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";							$sql			= $dbcon->execute($sql);
											$sql			= $dbcon->getResultArray($sql);
											
											if(count($sql)  > 0){
												$goods_name		= mysql_escape_string($sql[0]['goods_name']);
												$goods_sn		= $sql[0]['goods_sn'];
												$goods_unit		= $sql[0]['goods_unit'];
												$goods_id		= $sql[0]['goods_id'];
												$purchaseprice		= $sql[0]['goods_cost'];
												
												$sql		= "insert into ebay_iostoredetail(io_ordersn,goods_name,goods_sn,goods_cost,goods_unit,goods_count,goods_id,notes) values('$io_ordersn','$goods_name','$goods_sn','$purchaseprice','$goods_unit','$purchaseqty','$goods_id','$notes')";												
												if($dbcon->execute($sql)){
													
													$vvsql		= "delete from ebay_goods_newplan where id ='$selectid'";
													$dbcon->execute($vvsql);
												}
											}
										}
									}else{
									
										$io_ordersn		= $ss[0]['io_ordersn'];
										$sql			= "select  goods_name,goods_sn,goods_cost,goods_unit,goods_id,goods_cost from ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
										$sql			= $dbcon->execute($sql);
										$sql			= $dbcon->getResultArray($sql);
										if(count($sql)  == 0){
											$status .= " -[<font color='#FF0000'>操作记录: 没有产品记录，请添加此产品</font>]";
										}else{
											$goods_name		= mysql_escape_string($sql[0]['goods_name']);
											$goods_sn		= $sql[0]['goods_sn'];
											$goods_unit		= $sql[0]['goods_unit'];
											$goods_id		= $sql[0]['goods_id'];
											$purchaseprice		= $sql[0]['goods_cost'];
											$sql		= "insert into ebay_iostoredetail(io_ordersn,goods_name,goods_sn,goods_cost,goods_unit,goods_count,goods_id,notes) values('$io_ordersn','$goods_name','$goods_sn','$purchaseprice','$goods_unit','$purchaseqty','$goods_id','$notes')";
											
											if($dbcon->execute($sql)){
												$vvsql		= "delete from ebay_goods_newplan where id ='$selectid'";
												$dbcon->execute($vvsql);
											}
											}
									 }
								}else{
									echo "$goods_sn -<font color='red'>请选择供应商！</font><br>";
								
								}
			}
		}
	}
 ?>
    <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>

<div id="main">
    <div id="content" >
        <table style="width:100%"><tr>
          <td><div class='listViewBody'>
  <div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	<td nowrap="nowrap" scope="row" >
  查找：
  <input name="keys" type="text" id="keys" value="<?php echo $keys;?>"  />
  <select name="warehouse" id="warehouse">
  <option value="" selected="selected">请选择仓库 </option>
  <?php 
							$sql = "select id,store_name from  ebay_store where ebay_user='$user'";									
							$sql = $dbcon->execute($sql);
							$sql = $dbcon->getResultArray($sql);
							for($i=0;$i<count($sql);$i++){
								$id					= $sql[$i]['id'];
								$store_name			= $sql[$i]['store_name'];	
							?>
  <option value="<?php echo $id;?>" <?php if($warehouse == $id) echo 'selected="selected"';?>><?php echo $store_name; ?></option>
  <?php }  ?>
</select>
&nbsp;
<select name="kfuser" id="kfuser">
  <option value="" selected="selected"  >产品开发人员</option>
  <?php
							$ss		= "select username from ebay_user   where user ='$user' ";
							$ss		= $dbcon->execute($ss);
							$ss		= $dbcon->getResultArray($ss);
							for($i=0;$i<count($ss); $i++){
											$usernames	= $ss[$i]['username'];
							?>
  <option value="<?php echo $usernames;?>" <?php if($kfuser == $usernames) echo 'selected="selected"'; ?>><?php echo $usernames;?></option>
  <?php
							}
							 ?>
</select>
<select name="cguser" id="cguser">
  <option value="" selected="selected"  >采购人员</option>
  <?php
							$ss		= "select username from ebay_user   where user ='$user' and username != '' ";
							$ss		= $dbcon->execute($ss);
							$ss		= $dbcon->getResultArray($ss);
							for($i=0;$i<count($ss); $i++){
											$usernames	= $ss[$i]['username'];
							?>
  <option value="<?php echo $usernames;?>" <?php if($cguser == $usernames) echo 'selected="selected"'; ?>><?php echo $usernames;?></option>
  <?php
							}
							 ?>
</select>
&nbsp;&nbsp;&nbsp;
<input type="button" value="查找" onclick="searchorder()" />
<input type="button" value="删除选定产品" onclick="deleteselectorders()" />
<input type="button" value="添加产品" onclick="addnewplanorder()" /></td>
</tr>
</table>
</div>

 

		
   <?php 
				
	

				$sql		= "select * from ebay_goods_newplan where ebay_user ='$user' ";
				if($keys != '') $sql .= " and ( sku like '%$keys%' or  goods_name like '%$keys%' or  notes like '%$keys%' or  kfuser like '%$keys%')";		
				if($warehouse > 0 ) $sql .=" and ebay_warehouse='$warehouse' ";
				
				if($cguser != '' ) $sql .= " and cguser ='$cguser' ";
				if($kfuser != '' ) $sql .= " and kfuser ='$kfuser' ";
				
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
				
			


				 ?>
                 
                 <form name="myform" method="post" action="?&module=purchase"  >
             
            <table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='19'><?php echo $status;?>&nbsp;			</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap"><span style="white-space: nowrap;">
				    <input name="ordersn" type="checkbox" id="ordersn" value="<?php echo $ordersn;?>" onclick="check_all('ordersn','ordersn')" />
					</span>序号</th>
          <th scope='col' nowrap="nowrap">仓库</th>
					<th scope='col' nowrap="nowrap">SKU</th>
					<th scope='col' nowrap="nowrap">名称</th>
		<th scope='col' nowrap="nowrap">单位</th>
		            <th scope='col' nowrap="nowrap">实际库存</th>
		            <th scope='col' nowrap="nowrap">可用量</th>
                    <th scope='col' nowrap="nowrap">占用量</th>
                    <th scope='col' nowrap="nowrap">下限</th>
                    <th scope='col' nowrap="nowrap">需求量</th>
                    <th scope='col' nowrap="nowrap">采购量</th>
                    <th scope='col' nowrap="nowrap">预设进价</th>
          <th scope='col' nowrap="nowrap">最新采购价</th>
        <th scope='col' nowrap="nowrap">平均价</th>
                    <th scope='col' nowrap="nowrap">备注</th>
                    <th scope='col' nowrap="nowrap">供应商</th>
                    <th scope='col' nowrap="nowrap">操作</th>
                    <?php
						
						for($i=0;$i<count($sql);$i++){
						$id						= $sql[$i]['id'];
						$ebay_id				= $sql[$i]['ebay_id'];
						$sku					= $sql[$i]['sku'];
						$goods_name				= $sql[$i]['goods_name'];
						$goods_count1			= $sql[$i]['goods_count'];
						$goods_note				= $sql[$i]['goods_note'];
						$last_purchaseprice		= $sql[$i]['last_purchaseprice'];
						$kfuser					= $sql[$i]['kfuser'];
						$ebay_warehouse			= $sql[$i]['ebay_warehouse'];
						$typess					= $sql[$i]['type'];
						$stockused				= stockused($sku,$ebay_warehouse);
						$dataarray				= GetStockQtyBySku($ebay_warehouse,$sku);
						$goods_count			= $dataarray[0];
						$goods_xx				= $dataarray[1];
						$goods_cost				= $dataarray[3];
						
						
						
						$notes					= $sql[$i]['notes'];
						$factory				= $sql[$i]['partner'];
						
						$vv 					= "select store_name from  ebay_store where ebay_user='$user' and id ='$ebay_warehouse'";									
						$vv 					= $dbcon->execute($vv);
						$vv 					= $dbcon->getResultArray($vv);
						$warehousename			= $vv[0]['store_name'];
						$purchaseprice			= $sql[$i]['purchaseprice'];

						$dataarray				= GetStockQtyBySku($ebay_warehouse,$sku);
						$goods_count			= $dataarray[0];
						$goods_xx				= $dataarray[1];
						$goods_unit				= $dataarray[2];
						
						$dataarray				= GetPurchasePrice($sku);
						
						
					
						
					
					
					?>
        </tr>
        
					<tr height='20' class='oddListRowS1'>
					  <td scope='row' align='left' valign="top" <?php if($typess) echo "class='tdcolor'"?>><input name="ordersn" type="checkbox" id="ordersn" value="<?php echo $id;?>"   />
				      <?php echo $i+1;?>&nbsp;<span class="paginationActionButtons">
				      </span></td>
                       <td scope='row' align='left' valign="top" <?php if($typess) echo "class='tdcolor'"?>>
					   <input name="ebay_warehouse<?php echo $id;?>" type="hidden" id="ebay_warehouse<?php echo $id;?>" value="<?php echo $ebay_warehouse;?>" />
					   <?php echo $warehousename;?>&nbsp;</td>								
						    <td scope='row' align='left' valign="top" <?php if($typess) echo "class='tdcolor'"?>>
							<input name="goods_sn<?php echo $id;?>" type="hidden" id="goods_sn<?php echo $id;?>" value="<?php echo $sku;?>" />
							<?php echo $sku;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" <?php if($typess) echo "class='tdcolor'"?>><?php echo $goods_name;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" <?php if($typess) echo "class='tdcolor'"?>><?php echo $goods_unit;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" <?php if($typess) echo "class='tdcolor'"?>><?php echo $goods_count;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" <?php if($typess) echo "class='tdcolor'"?>><?php echo $goods_count - $stockused;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" <?php if($typess) echo "class='tdcolor'"?>><?php echo $stockused;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" <?php if($typess) echo "class='tdcolor'"?>><?php echo $goods_xx?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" <?php if($typess) echo "class='tdcolor'"?>><?php echo $goods_count1;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" <?php if($typess) echo "class='tdcolor'"?>>&nbsp;
					        <input name="purchaseqty<?php echo $id;?>" type="text" id="purchaseqty<?php echo $id;?>" value="<?php echo $goods_count1;?>" size="3" /></td>
				      <td scope='row' align='left' valign="top" <?php if($typess) echo "class='tdcolor'"?>>&nbsp;
			         <!-- <input name="purchaseprice<?php echo $id;?>" type="text" id="purchaseprice<?php echo $id;?>" value="<?php echo $purchaseprice;?>" size="3" />-->
                     
                     <?php echo $purchaseprice;?>
                     
                     </td>
						    <td scope='row' align='left' valign="top" <?php if($typess) echo "class='tdcolor'"?>><?php echo $dataarray[0];?>&nbsp;</td>
				            <td scope='row' align='left' valign="top" <?php if($typess) echo "class='tdcolor'"?>><?php echo $dataarray[2];?>&nbsp;</td>
					        <td scope='row' align='center' valign="middle" <?php if($typess) echo "class='tdcolor'"?>><textarea name="notes<?php echo $id;?>" cols="15" rows="2" id="notes<?php echo $id;?>"><?php echo $notes;?></textarea>
		              &nbsp;</td>
					        <td scope='row' align='left' valign="top" <?php if($typess) echo "class='tdcolor'"?>><select name="factory<?php echo $id;?>" id="factory<?php echo $id;?>">
                              <option value="0">Please select</option>
                              <?php 
							$vv = "select id,company_name from  ebay_partner where ebay_user='$user'";									
							$vv = $dbcon->execute($vv);
							$vv = $dbcon->getResultArray($vv);
							for($j=0;$j<count($vv);$j++){
								$pid					= $vv[$j]['id'];
								$company_name			= $vv[$j]['company_name'];
							?>
                              <option value="<?php echo $pid;?>" <?php if($pid ==$factory) echo "selected=selected";?>><?php echo $company_name; ?></option>
                              <?php
							}
							?>
                            </select></td>
					        <td scope='row' align='left' valign="top" <?php if($typess) echo "class='tdcolor'"?>><a href="#" onclick="delsingleplan('<?php echo $id;?>')">删除</a></td>
					</tr>
					
              
              
              
              <?php
			  
			  
			  }
			  ?>
              
		<tr class='pagination'>
		<td colspan='19'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons' align="center">
                    <input name="totalrecorder" type="hidden" id="totalrecorder" value="<?php echo $i;?>" />
					<input name="addtype" type="hidden" id="addtype" value="0" />
                    <input name="submit1" type="button" onclick="saveorders()" value="保存并生成采购计划单" />
					<input name="submit2" type="button" onclick="saveorders2()" value="保存并生成预定中订单" />
				    <?    echo '<br><center>'.$page->show(2)."</center>";//输出分页 ?></td>
			  </tr>
			</table>		</td>
	</tr>
</table>

</form>
<?php

include "bottom.php";


?>
<script language="javascript">
	


	function searchorder(){
		var keys	 	= document.getElementById('keys').value;
		var startdate 	= '';
		var enddate 	= '';
		var warehouse 	= document.getElementById('warehouse').value;
		var cguser	 	= document.getElementById('cguser').value;
		var kfuser	 	= document.getElementById('kfuser').value;
		location.href	= 'purchase_newplan.php?keys='+keys+"&module=purchase&warehouse="+warehouse+"&cguser="+cguser+"&kfuser="+kfuser;
	}
	
	document.onkeydown=function(event){
  	e = event ? event :(window.event ? window.event : null);
  	if(e.keyCode==13){
 	searchorder();
  	}
 	}
	
	function delsingleplan(id){
		
		if(confirm('确认删除吗')){
		
		
		var url	= 'purchase_newplan.php?id='+id+'&module=purchase&type=del';
		location.href = url;
		
		}
	
	}
	
	function saveorders(){
		
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				bill = bill + ","+checkboxs[i].value;
			}	
		}
		if(bill == ""){
			alert("请选择物品");
			return false;
		}
		myform.totalrecorder.value = bill;
		myform.submit();
	}
	function saveorders2(){
		
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				bill = bill + ","+checkboxs[i].value;
			}	
		}
		if(bill == ""){
			alert("请选择物品");
			return false;
		}
		myform.totalrecorder.value = bill;
		myform.addtype.value = 1;
		myform.submit();
	}
	function deleteselectorders(){
		
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				bill = bill + ","+checkboxs[i].value;
			}	
		}
		
		if(bill == ""){
			alert("请选择物品");
			return false;
		}
		
		if(confirm('确认删除这些记录吗')){
		
			var url	= 'purchase_newplan.php?id='+bill+'&module=purchase&type=del';
			location.href = url;
		
		}
		
		
		
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
function openwindow(url,name,iWidth,iHeight)
{
var url; //转向网页的地址;
var name; //网页名称，可为空;
var iWidth; //弹出窗口的宽度;
var iHeight; //弹出窗口的高度;
var iTop = (window.screen.availHeight-30-iHeight)/2; //获得窗口的垂直位置;
var iLeft = (window.screen.availWidth-10-iWidth)/2; //获得窗口的水平位置;
window.open(url,name,'height='+iHeight+',,innerHeight='+iHeight+',width='+iWidth+',innerWidth='+iWidth+',top='+iTop+',left='+iLeft+',toolbar=no,scrollbars=auto,resizeable=no,location=no,status=no');
}
 function addnewplanorder(){
	var url	= 'purchase_newplanadds.php';
	openwindow(url,'',1200,500);
 }

</script>