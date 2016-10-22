<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 



<html> 

<head> 

<link rel="SHORTCUT ICON" href="themes/Sugar5/images/sugar_icon.ico?s=eae43f74f8a8f907c45061968d50157c&c=1"> 



<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
<title>ISFES V3</title> 
<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/yui.css" />
<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/deprecated.css" />
<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/style.css" />
</head>
<body>
<?php
include "include/config.php";
	$keys					= trim($_REQUEST['keys']);
	$cguser					= $_REQUEST['cguser'];
	$kfuser					= $_REQUEST['kfuser'];
	$goodscategory			= $_REQUEST['goodscategory'];
	$store_id				= $_REQUEST['store_id'];
	function getstorename($id){
		global $dbcon;
		if($id){
		$sql = "select store_name from ebay_store where id = $id ";
		$sql			= $dbcon->execute($sql);
		$sql			= $dbcon->getResultArray($sql);
		return $sql[0]['store_name'];
		}else{
			return '';
		}
	}
	function isplan($sku,$storeid){
		global $dbcon,$user;
		$plansql	= "select id from ebay_goods_newplan where sku ='$sku' and ebay_user='$user' and ebay_warehouse='$storeid'";
		$plansql	=$dbcon->execute($plansql);
		$plansql	=$dbcon->getResultArray($plansql);
		if(count($plansql)>0){
			return 0;
		}else{
			return 1;
		}
	}
	if($_POST['submit']){
		
		$totalrecorder		= $_POST['totalrecorder']; // 取得一共有多少行记录
		$totalrecorder		= explode(',',$totalrecorder);
		
		

		for($i=0;$i<count($totalrecorder);$i++){
			
			$selectid		= $totalrecorder[$i];
			if($selectid != '' ){
				
				$goods_sn					= $_POST['goods_sn'.$selectid];
				$vv = "select goods_name,goods_unit,factory,kfuser,cguser from ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
				$vv			= $dbcon->execute($vv);
				$vv			= $dbcon->getResultArray($vv);
				$goods_name = $vv[0]['goods_name'];
				$unit 		= $vv[0]['goods_unit'];
				$factory	= $vv[0]['factory'];
				$kfuser		= $vv[0]['kfuser'];
				$cguser		= $vv[0]['cguser'];
				$storeid					= $_POST['store_id'.$selectid];
				$purchaseqty				= $_POST['purchaseqty'.$selectid];
				$purchaseprice				= $_POST['purchaseprice'.$selectid];
				if(isplan($goods_sn,$storeid)){
				$addsql		= "insert into ebay_goods_newplan(sku,goods_name,unit,ebay_warehouse,goods_count,ebay_user,type,partner,purchaseprice,kfuser,cguser) values('$goods_sn','$goods_name','$unit','$storeid','$purchaseqty','$user','1','$factory','$purchaseprice','$kfuser','$cguser')";
				
				if($dbcon->execute($addsql)){
					echo "SKU: ".$goods_sn.' 保存成功<br>';
				}else{
					echo "SKU: ".$goods_sn.' 保存失败<br>';
				}
				}else{
					echo "SKU: ".$goods_sn.' 保存失败,计划已经存在<br>';
				}
			}
		}
	}
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$storeid					= $_GET['store_id'];
		$purchaseqty				= $_GET['purchaseqty'];
		$purchaseprice				= $_GET['purchaseprice'];
		$vv = "select goods_name,goods_unit,goods_sn,factory,kfuser,cguser from ebay_goods where goods_id='$id' and ebay_user='$user'";
		$vv			= $dbcon->execute($vv);
		$vv			= $dbcon->getResultArray($vv);
		$goods_name = $vv[0]['goods_name'];
		$unit 		= $vv[0]['goods_unit'];
		$goods_sn 	= $vv[0]['goods_sn'];
		$factory 	= $vv[0]['factory'];
		$kfuser		= $vv[0]['kfuser'];
		$cguser		= $vv[0]['cguser'];

		
		if(isplan($goods_sn,$storeid)){
		$addsql		= "insert into ebay_goods_newplan(sku,goods_name,unit,ebay_warehouse,goods_count,ebay_user,type,partner,purchaseprice,kfuser,cguser) values('$goods_sn','$goods_name','$unit','$storeid','$purchaseqty','$user','1','$factory','$purchaseprice','$kfuser','$cguser')";

		
		if($dbcon->execute($addsql)){
			echo '<script>alert("'.$goods_sn.'保存成功");</script>';
		}else{
			echo '<script>alert("'.$goods_sn.'保存失败");</script>';
		}
		}else{
			echo '<script>alert("'.$goods_sn.'保存失败，计划已经存在");</script>';
		}
	}
 ?>
    <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>

<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td nowrap="nowrap" scope="row" >
				产品类别
				<select name="goodscategory" id="goodscategory" style='width:100px'>
					<option value="">Please Select</option>
					<?php 
					$sql		= "select * from ebay_goodscategory where ebay_user='$user' and pid	= 0";
					$sql		= $dbcon->execute($sql);
					$sql		= $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){

						$id			= $sql[$i]['id'];
						$name		= $sql[$i]['name'];
						$pid		= $sql[$i]['pid'];
						
						echo "<option value=\"{$id}\">$name</option>";
						
						/*第二层目录*/
						$sq2		= "select * from ebay_goodscategory where ebay_user='$user' and pid	= '$id'";						
						$sq2		= $dbcon->execute($sq2);
						$sq2		= $dbcon->getResultArray($sq2);
						if(count($sq2) >0){
							for($a=0;$a<count($sq2);$a++){
								
								$id2	= $sq2[$a]['id'];
								$iname2	= $sq2[$a]['name'];
								$pid2	= $sq2[$a]['pid'];
													
								echo "<option value=\"{$id2}\">&nbsp;&nbsp {$iname2}</option>";
								
								/* 第三导目录 */
								
								$sq3		= "select * from ebay_goodscategory where ebay_user='$user' and pid	= '$id2'";						
								$sq3		= $dbcon->execute($sq3);
								$sq3		= $dbcon->getResultArray($sq3);
								if(count($sq3) >0){
									for($b=0;$b<count($sq3);$b++){
										$id3	= $sq3[$b]['id'];
										$iname3	= $sq3[$b]['name'];
										$pid3	= $sq3[$b]['pid'];				
										echo "<option value=\"{$id3}\">&nbsp;&nbsp;&nbsp;&nbsp;{$iname3}</option>";
									}
								}
							}
						}
					}
					?>
				</select>
				采购人员
				<select name="cguser" id="cguser" style='width:100px'>
					<option value="" >Please Select</option>
					<?php
					$ss		= "select username from ebay_user   where user ='$user' ";
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
				开发人员
				<select name="kfuser" id="kfuser" style='width:100px'>
					<option value="" >Please Select</option>
					<?php
					
					$ss		= "select username from ebay_user where user ='$user' ";
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
				仓库
				  <select name="store_id" id="store_id" style='width:100px'>
					<?php 
							$sql = "select id,store_name from  ebay_store where ebay_user='$user'";									
							$sql = $dbcon->execute($sql);
							$sql = $dbcon->getResultArray($sql);
							if($store_id=='')$store_id = $sql[0]['id'];
							for($i=0;$i<count($sql);$i++){
								$id					= $sql[$i]['id'];
								$store_name			= $sql[$i]['store_name'];	
							?>
				<option value="<?php echo $id;?>" <?php if($store_id == $id) echo 'selected="selected"';?>><?php echo $store_name; ?></option>
				<?php }  ?>
				</select>
				关键字：
				<input name="keys" type="text" id="keys" value="<?php echo $keys;?>" style='width:100px' />
				&nbsp;&nbsp;
				<input type="button" value="查找" onclick="searchorder()" />
			</td>
		</tr>
	</table>
</div>
 

		
   <?php 
				
	

				$sql		= "select * from ebay_goods as a  where a.ebay_user ='$user' ";
				if($keys != '') $sql .= " and ( a.goods_sn like '%$keys%' or  a.goods_name like '%$keys%' or  a.goods_note like '%$keys%')";
				if($kfuser != '') $sql .= " and a.kfuser='$kfuser'";
				if($cguser != '') $sql .= " and a.cguser='$cguser'";
				if($goodscategory != '') $sql .= " and a.goods_category='$goodscategory'";
				$query		= $dbcon->query($sql);
				$total		= $dbcon->num_rows($query);
				$totalpages = $total;

				$pageindex  =( isset($_GET['pageindex']) )?$_GET['pageindex']:1;
				$limit = " limit ".($pageindex-1)*$pagesize.",$pagesize";
				$page=new page(array('total'=>$total,'perpage'=>$pagesize));
				$sql = $sql.$limit;
				//echo $sql;
				$sql = $dbcon->execute($sql);
				$sql = $dbcon->getResultArray($sql);
				
			


				 ?>
                 
                 <form name="myform" method="post" action="purchase_newplanadds.php"  >
             
            <table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
			<tr height='20'>
				<th scope='col' nowrap="nowrap"><span style="white-space: nowrap;">
				<input name="ordersn" type="checkbox" id="ordersn" value="<?php echo $ordersn;?>" onclick="check_all('ordersn','ordersn')" />
				</span>序号</th>
				<th scope='col' nowrap="nowrap">仓库</th>
				<th scope='col' nowrap="nowrap">SKU</th>
				<th scope='col' nowrap="nowrap">名称</th>
				<th scope='col' nowrap="nowrap">单位</th>
				<th scope='col' nowrap="nowrap">实际库存</th>
				<th scope='col' nowrap="nowrap">可用量</th>
				<th scope='col' nowrap="nowrap">下限</th>
				<th scope='col' nowrap="nowrap">采购量</th>
				<th scope='col' nowrap="nowrap">采购单价</th>
				<th scope='col' nowrap="nowrap">操作</th>
				</tr>
                    <?php
						
						for($i=0;$i<count($sql);$i++){
						$id						= $sql[$i]['goods_id'];
						$sku					= $sql[$i]['goods_sn'];
						$goods_name				= $sql[$i]['goods_name'];
						
						$goods_note				= $sql[$i]['goods_note'];
						$last_purchaseprice		= $sql[$i]['last_purchaseprice'];
						$kfuser					= $sql[$i]['kfuser'];
						$factory				= $sql[$i]['partner'];
						$purchaseprice			= $sql[$i]['purchaseprice'];
						
						$goods_xx				= $sql[$i]['goods_xx'];
						$goods_unit				= $sql[$i]['goods_unit'];
						
						$goods_cost				= $sql[$i]['goods_cost'];	
						
						//$dataarray				= GetPurchasePrice($sku);
						
						$vv = "select goods_count from ebay_onhandle where goods_sn='$sku' and store_id='$store_id' ";
						$vv = $dbcon->execute($vv);
						$vv = $dbcon->getResultArray($vv);
						$goods_count			= $vv[0]['goods_count'];
						$store_name 			= getstorename($store_id);
						$stockused				= stockused($sku,$store_id);
					?>
      
        
					<tr height='20' class='oddListRowS1'>
					  <td scope='row' align='left' valign="top" ><input name="ordersn" type="checkbox" id="ordersn" value="<?php echo $id;?>"   />
				      <?php echo $i+1;?>&nbsp;<span class="paginationActionButtons">
				      </span></td>
                       <td scope='row' align='left' valign="top" >
					   <input name="store_id<?php echo $id;?>" type="hidden" id="store_id<?php echo $id;?>" value="<?php echo $store_id;?>" />
					   <?php echo $store_name;?>&nbsp;</td>								
						    <td scope='row' align='left' valign="top" >
							<input name="goods_sn<?php echo $id;?>" type="hidden" id="goods_sn<?php echo $id;?>" value="<?php echo $sku;?>" />
							<?php echo $sku;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $goods_name;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $goods_unit;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $goods_count;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $goods_count - $stockused;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $goods_xx?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" >
					        <input name="purchaseqty<?php echo $i;?>" type="text" id="purchaseqty<?php echo $i;?>" value="0" style='width:30px' /></td>
				      <td scope='row' align='left' valign="top" >
			          <input name="purchaseprice<?php echo $i;?>" type="text" id="purchaseprice<?php echo $i;?>" value="<?php echo $goods_cost;?>" style='width:30px'/></td>
					        <td scope='row' align='left' valign="top" ><a href="#" onclick="addplan('<?php echo $id;?>','<?php echo $store_id;?>','<?php echo $i;?>')">添加</a></td>
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
                    <input name="submit" type="submit" onclick="return saveorders()" value="添加选中sku" />
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
		var kfuser 	= document.getElementById('kfuser').value;
		var cguser 	= document.getElementById('cguser').value;
		var goodscategory 	= document.getElementById('goodscategory').value;
		var store_id		= document.getElementById('store_id').value;
		location.href	= 'purchase_newplanadds.php?keys='+keys+"&kfuser="+kfuser+"&cguser="+cguser+"&goodscategory="+goodscategory+'&store_id='+store_id;
	}
	document.onkeydown=function(event){
		e = event ? event :(window.event ? window.event : null);
		if(e.keyCode==13){
		searchorder();
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
		document.getElementById('totalrecorder').value = bill;
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
function addplan(id,storeid,sorts){
	
	var purchaseqty = document.getElementById('purchaseqty'+sorts).value;
	var purchaseprice = document.getElementById('purchaseprice'+sorts).value;
	
	var url	= 'purchase_newplanadds.php?id='+id+'&purchaseqty='+purchaseqty+'&purchaseprice='+purchaseprice+'&store_id='+storeid;
	location.href = url;
}
</script>