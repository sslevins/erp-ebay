<?php
include "include/config.php";
include "top.php";	
	/* 修改客户地址 */
	$sid	= $_REQUEST['storeid'];
	
	$isadd	= 0;
	

	if($_POST['submit']){
	
		$store_name 		= str_rep($_POST['store_name']);
		$store_sn			= str_rep($_POST['store_sn']);
		$store_location		= str_rep($_POST['store_location']);
		$store_note			= str_rep($_POST['store_note']);
		
		if($store_sn != '' && $store_name != ''){
		if($sid == ""){
		
		$sql		=  "INSERT INTO `ebay_store` (`store_name` ,`store_sn` ,`store_location` ,`store_note` ,";
		$sql		.= "`ebay_user`)VALUES ('$store_name', '$store_sn', '$store_location', '$store_note', '$user')";
		$isadd		= 1;
		
		}else{
		
			
		$sql		= "UPDATE `ebay_store` SET `store_name` = '$store_name',`store_sn` = '$store_sn',`store_location` = '$store_location',";
		$sql	   .= "`store_note` = '$store_note' WHERE `ebay_store`.`id` =$sid ";
		
		}

	
		
		if($dbcon->execute($sql)){
			$status	= " -[<font color='#33CC33'>操作记录: 保存成功</font>]";
			if($isadd == 1 ) $sid		= mysql_insert_id();
			
		}else{

			$status = " -[<font color='#FF0000'>操作记录: 保存失败</font>]";
			
		}
		
		}else{
			
			$status = " -[<font color='#FF0000'>操作记录: 保存失败</font>]";
		
		
		}
		
	
	}
	

	
	
	
	$sql		= "select * from ebay_store where id='$sid'";	
	$sql		= $dbcon->execute($sql);
	$sql		= $dbcon->getResultArray($sql);	
	



 ?>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status;?> </h2>
</div>

<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
<table width="86%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
	
	
	
		
	<td nowrap="nowrap" scope="row" >&nbsp;<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
                <td class="login_txt_bt">&nbsp;</td>
              </tr>
                    <tr>
                      <td valign="top" class="left_txt">
                      <?php
					  	
				
							$store_name			= $sql[0]['store_name'];
							$store_sn			= $sql[0]['store_sn'];
							$store_location		= $sql[0]['store_location'];
							$store_note			= $sql[0]['store_note'];
						
							
						   
						   
					  ?>
                      &nbsp;<br>
                      <form id="ad" name="ad" method="post" action="productwarehouseadd.php?storeid=<?php echo $sid;?>&module=warehouse&action=货品资料添加">
                      <input type="hidden" value="<?php echo $_REQUEST['type'];?>" name="type" />
                      
                      <table width="60%" border="0" cellpadding="0" cellspacing="0" class="login_txt">
                        <tr>
                          <td>仓库名称</td>
                          <td><input name="store_name" type="text" id="store_name" value="<?php echo $store_name;?>"></td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>仓库编码</td>
                          <td><input name="store_sn" type="text" id="store_sn" value="<?php echo $store_sn; ?>"></td>
                          <td>用来关联产品数量导入的到系统中的，请不要填写以0开关的编号</td>
                        </tr>
                        <tr>
                          <td>仓库位置</td>
                          <td><input name="store_location" type="text" id="store_location" value="<?php echo $store_location; ?>"></td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>备注</td> 
                          <td><input name="store_note" type="text" id="store_note" value="<?php echo $store_note;?>"></td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td><input name="submit" type="submit" value="保存" /></td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                      </table>
                      </form>
                      <p>&nbsp;</p>
                      <p><br>
                        </p></td>
                    </tr>
                    <tr>
                      <td class="login_txt_bt">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="left_txt">&nbsp;</td>
                    </tr>
          </table></td>
	</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td width="65%">&nbsp;</td>
	</tr>
              
              
              

              
		<tr class='pagination'>
		<td>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'></td>
			  </tr>
			</table>		</td>
	</tr></table>


    <div class="clear"></div>
<?php

include "bottom.php";


?>
<script language="javascript">
	
	function del(ordersn,ebayid){
	
	
		
		if(confirm("确认删除此条记录吗")){
			
			location.href="ordermodifive.php?ordersn=<?php echo $ordersn ?>&ebayid=<?php echo $ebayid;?>&type=del&module=orders&action=新增订单";
			
		
		
		}
		
	
	
	}
	
	function mod(ordersn,ebayid){
	
		
		
		
		if(confirm("确认修改此条记录吗")){
			
			
			var pname	 = document.getElementById('pname'+ebayid).value;
			var pprice	 = document.getElementById('pprice'+ebayid).value;
			var pqty	 = document.getElementById('pqty'+ebayid).value;
			var psku	 = document.getElementById('psku'+ebayid).value;
			var pitemid	 = document.getElementById('pitemid'+ebayid).value;
			
			
			if(isNaN(pqty)){
				
				alert("数量只能输入数字");
				
			
			}else if(isNaN(pprice)){
				
				alert("价格只能输入数字");
			
			}else{
			
				location.href="ordermodifive.php?ordersn=<?php echo $ordersn ?>&ebayid="+ebayid+"&type=mod&pname="+encodeURIComponent(pname)+"&pprice="+pprice+"&pqty="+pqty+"&psku="+psku+"&pitemid="+pitemid+"&module=orders&action="+urlencode(新增订单);
			
			}
					
		}
		
	}
	
	function add(ordersn){
	
		
		var tname		= document.getElementById('tname').value;
		var tprice		= document.getElementById('tprice').value;
		var tqty		= document.getElementById('tqty').value;
		var tsku		= document.getElementById('tsku').value;
		var titemid		= document.getElementById('titemid').value;
		
		if(tname == ""){
		
				
				alert("请输入产品名称");
				document.getElementById('tname').select();
				return false;
				
		}
		
		if(isNaN(tprice) || tprice == ""){
				
				alert("数量只能输入数字");
				document.getElementById('tprice').select();
				return false;		
				
			
		}
		
		if(isNaN(tqty)){
				
				alert("价格只能输入数字");
				document.getElementById('tqty').select();
				return false;
			
		}			
		location.href="ordermodifive.php?ordersn=<?php echo $ordersn ?>&type=add&tname="+encodeURIComponent(tname)+"&tprice="+tprice+"&tqty="+tqty+"&tsku="+tsku+"&titemid="+titemid+"&module=orders&action=新增订单";
			
	}
	


</script>