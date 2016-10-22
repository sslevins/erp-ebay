<?php
include "include/config.php";
include "top.php";	
	/* 修改客户地址 */
	$sid	= $_REQUEST['storeid'];

	if($_POST['submit']){
	
		$ebay_storesn 		= str_rep($_POST['ebay_storesn']);
		$ebay_storename			= str_rep($_POST['ebay_storename']);
		$ebay_storetype		= str_rep($_POST['ebay_storetype']);
		$warehousetype		= str_rep($_POST['warehousetype']);
		if($ebay_storesn != '' && $ebay_storename != ''){
	
		if($sid == ""){
		
		$sql		=  "INSERT INTO `ebay_storetype` (`ebay_storesn` ,`ebay_storename` ,`ebay_storetype` ,`ebay_user`,`warehousetype` ";
		$sql		.= ")VALUES ('$ebay_storesn', '$ebay_storename', '$ebay_storetype', '$user','$warehousetype')";

		
		
		}else{
		
			
		$sql		=  "UPDATE `ebay_storetype` SET `ebay_storesn` = '$ebay_storesn',`ebay_storename` = '$ebay_storename',`ebay_storetype` = '$ebay_storetype',warehousetype='$warehousetype',";
		$sql		.= "`ebay_user` = '$user' WHERE `ebay_storetype`.`id` =$sid";
		
		}

		
		if($dbcon->execute($sql)){
			
			
			$status	= " -[<font color='#33CC33'>操作记录: 保存成功</font>]";
			
		}else{

			$status = " -[<font color='#FF0000'>操作记录: 保存失败</font>]";
			
		}
		}else{
		
		
			$status = " -[<font color='#FF0000'>操作记录: 保存失败</font>]";
		}
	
	}
	

	
	
	
	$sql		= "select * from ebay_storetype where id='$sid'";	
	
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
					  	
				
							$ebay_storesn 			= $sql[0]['ebay_storesn'];
							$ebay_storename 			= $sql[0]['ebay_storename'];
							$ebay_storetype 		= $sql[0]['ebay_storetype'];
							$warehousetype 		= $sql[0]['warehousetype'];
							
						   
						   
					  ?>
                      &nbsp;<br>
                      <form id="ad" name="ad" method="post" action="productwarehousetypeadd.php?storeid=<?php echo $sid;?>&module=warehouse&action=货品资料添加">
                      <input type="hidden" value="<?php echo $_REQUEST['type'];?>" name="type" />
                      
                      <table width="50%" border="0" cellpadding="0" cellspacing="0" class="login_txt">
                        <tr>
                          <td>编码</td>
                          <td><input name="ebay_storesn" type="text" id="ebay_storesn" value="<?php echo $ebay_storesn;?>"></td>
                          <td>*</td>
                        </tr>
                        <tr>
                          <td>名称</td>
                          <td><input name="ebay_storename" type="text" id="ebay_storename" value="<?php echo $ebay_storename; ?>"></td>
                          <td>*</td>
                        </tr>
                        <tr>
                          <td>出入库类型</td>
                          <td><select name="ebay_storetype" id="ebay_storetype">
                            <option value="0" <?php if($ebay_storetype == 0) echo 'selected="selected"';?>>入库类</option>
                            <option value="1" <?php if($ebay_storetype == 1) echo 'selected="selected"';?>>出库类</option>
</select>&nbsp;</td>
                          <td>*</td>
                        </tr>
                        <tr>
                          <td>是否默认</td>
                          <td><select name="warehousetype" id="warehousetype">
                            <option value="0" <?php if($warehousetype == 0) echo 'selected="selected"';?>>否</option>
                            <option value="1" <?php if($warehousetype == 1) echo 'selected="selected"';?>>是</option>
                          </select></td>
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