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
	$storeid				= $_REQUEST['storeid'];
	$keys					= trim($_REQUEST['keys']);
	$cguser					= $_REQUEST['cguser'];
	$kfuser					= $_REQUEST['kfuser'];
	$goodscategory			= $_REQUEST['goodscategory'];
	
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
	if($_POST['submit']){
		
		$totalrecorder		= $_POST['totalrecorder']; // 取得一共有多少行记录
		$totalrecorder		= explode(',',$totalrecorder);
		
		

		for($i=0;$i<count($totalrecorder);$i++){
			
			$selectid		= $totalrecorder[$i];
			if($selectid != '' ){
				
				$goods_sn					= $_POST['goods_sn'.$selectid];
				$vv = "select goods_name,goods_unit from ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
				$vv			= $dbcon->execute($vv);
				$vv			= $dbcon->getResultArray($vv);
				$goods_name = $vv[0]['goods_name'];
				$unit 		= $vv[0]['goods_unit'];
				$goodscount				= $_POST['goodscount'.$selectid];
				$wait_count				= $_POST['waitcount'.$selectid];
				$sss = "select id from ebay_pandiandetail where goods_sn='$goods_sn' and status='0' and user='$user'";
				$sss			= $dbcon->execute($sss);
				$sss			= $dbcon->getResultArray($sss);
				$addsql = '';
				if(count($sss)==0){
				$addsql		= "insert into ebay_pandiandetail(goods_sn,goods_name,goods_unit,goods_count,status,wait_count,user) values('$goods_sn','$goods_name','$unit','$goodscount','0','$wait_count','$user')";
				}
				//echo $addsql;
				if($dbcon->execute($addsql)){
					echo "-[<font color='#33CC33'>SKU: ".$goods_sn.' 保存成功</font>]<br>';
				}else{
					echo " -[<font color='#FF0000'>SKU: ".$goods_sn.' 保存失败,已存在的盘点产品</font>]<br>';
				}
			}
		}
	}
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$goods_count				= $_GET['goodscount'];
		$waitcount				= $_GET['waitcount'];
		$time = time();
		$vv = "select goods_name,goods_unit,goods_sn from ebay_goods where goods_id='$id' and ebay_user='$user'";
		$vv			= $dbcon->execute($vv);
		$vv			= $dbcon->getResultArray($vv);
		$goods_name = $vv[0]['goods_name'];
		$unit 		= $vv[0]['goods_unit'];
		$goods_sn 	= $vv[0]['goods_sn'];
		$sss = "select id from ebay_pandiandetail where goods_sn='$goods_sn' and status='0' and user='$user'";
		$sss			= $dbcon->execute($sss);
		$sss			= $dbcon->getResultArray($sss);
		$addsql = '';
		if(count($sss)==0){
		$addsql		= "insert into ebay_pandiandetail(goods_sn,goods_name,goods_unit,goods_count,status,wait_count,user) values('$goods_sn','$goods_name','$unit','$goods_count','0','$waitcount','$user')";
		}
		if($dbcon->execute($addsql)){
			echo '<script>alert("'.$goods_sn.'保存成功");</script>';
		}else{
			echo '<script>alert("'.$goods_sn.'保存失败,已存在的盘点产品");</script>';
		}
	}
 ?>
    <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>

<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td nowrap="nowrap" scope="row" >
				产品类别
				<select name="goodscategory" id="goodscategory">
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
				<select name="cguser" id="cguser">
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
				<select name="kfuser" id="kfuser">
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
				关键字：
				<input name="keys" type="text" id="keys" value="<?php echo $keys;?>"  />
				&nbsp;&nbsp;
				<input type="button" value="查找" onclick="searchorder()" />
			</td>
		</tr>
	</table>
</div>
 

		
   <?php 
				
	

				$sql		= "select * from ebay_goods as a join ebay_onhandle as b on a.goods_sn=b.goods_sn where a.ebay_user ='$user' and b.store_id='$storeid' ";
				if($keys != '') $sql .= " and ( a.goods_sn like '%$keys%' or  a.goods_name like '%$keys%' or  a.goods_note like '%$keys%')";
				if($kfuser != '') $sql .= " and a.kfuser='$kfuser'";
				if($cguser != '') $sql .= " and a.cguser='$cguser'";
				if($goodscategory != '') $sql .= " and a.goods_category='$goodscategory'";
				$query		= $dbcon->query($sql);
				$total		= $dbcon->num_rows($query);
				$totalpages = $total;
				$pagesize   = 10;
				$pageindex  =( isset($_GET['pageindex']) )?$_GET['pageindex']:1;
				$limit = " limit ".($pageindex-1)*$pagesize.",$pagesize";
				$page=new page(array('total'=>$total,'perpage'=>$pagesize));
				$sql = $sql.$limit;
				//echo $sql;
				$sql = $dbcon->execute($sql);
				$sql = $dbcon->getResultArray($sql);
				
			


				 ?>
                 
                 <form name="ff" method="post" action="addpandiangoods.php"  >
             
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
				<th scope='col' nowrap="nowrap">操作</th>
                    <?php
						
						for($i=0;$i<count($sql);$i++){
						$id						= $sql[$i]['goods_id'];
						$sku					= $sql[$i]['goods_sn'];
						$goods_name				= $sql[$i]['goods_name'];
						$goods_count			= $sql[$i]['goods_count'];
						$store_id				= $sql[$i]['store_id'];
						$store_name 			= getstorename($store_id);
						$stockused				= stockused($sku,$store_id);
						$goods_unit				= $sql[$i]['goods_unit'];
						
						
						
					
						
					
					
					?>
        </tr>
        
					<tr height='20' class='oddListRowS1'>
					  <td scope='row' align='left' valign="top" ><input name="ordersn" type="checkbox" id="ordersn" value="<?php echo $id;?>"   />
				      <?php echo $i+1;?>&nbsp;<span class="paginationActionButtons">
				      </span></td>
                       <td scope='row' align='left' valign="top" >
					   <?php echo $store_name;?>&nbsp;</td>								
						    <td scope='row' align='left' valign="top" >
							<input name="goods_sn<?php echo $id;?>" type="hidden" id="goods_sn<?php echo $id;?>" value="<?php echo $sku;?>" />
							<?php echo $sku;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $goods_name;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $goods_unit;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><input name="goodscount<?php echo $id;?>" type="hidden" id="goodscount<?php echo $id;?>" value="<?php echo $goods_count;?>" /><?php echo $goods_count;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><input name="waitcount<?php echo $id;?>" type="hidden" id="waitcount<?php echo $id;?>" value="<?php echo $stockused;?>" /><?php echo $goods_count - $stockused;?>&nbsp;</td>
					        <td scope='row' align='left' valign="top" ><a href="#" onclick="addplan('<?php echo $id;?>')">添加</a></td>
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
		location.href	= 'addpandiangoods.php?keys='+keys+"&kfuser="+kfuser+"&cguser="+cguser+"&goodscategory="+goodscategory+"&storeid=<?php echo $storeid?>";
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
function addplan(id){
	
	var goodscount = document.getElementById('goodscount'+id).value;
	var waitcount = document.getElementById('waitcount'+id).value;
	var url	= 'addpandiangoods.php?id='+id+'&goodscount='+goodscount+'&waitcount='+waitcount+"&storeid=<?php echo $storeid?>";
	
	location.href = url;
}
</script>