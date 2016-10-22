<?php
	include "../include/config.php";
	$value				= trim($_REQUEST['value']);
	$shiptype			= $_REQUEST['shiptype'];
	$tracknumber		= $_REQUEST['tracknumber'];
	
	if($value != ''){
	
	
	$ss					= "select * from ebay_order where ebay_id='$value' and ebay_user ='$user' ";
	$ss					= $dbcon->execute($ss);
	$ss					= $dbcon->getResultArray($ss);
	if(count($ss)  == '0'){
		
		$status = " -[<font color='#FF0000'>操作记录:未找到订单</font>]";	
		
	}else{
		
		
		if(count($ss) == 1){
			$ebay_ordersn	= $ss[0]['ebay_ordersn'];
			$ebay_carrier	= $ss[0]['ebay_carrier'];
			$status = " -[<font color='#33CC33'>操作记录订单核对成功</font>]";	
			
			if($auditcompleteorderstatus > 0 ){
			$ss		= "update ebay_order set ebay_status='$auditcompleteorderstatus',scantime='$mctime',ebay_tracknumber='$tracknumber' where   ebay_id='$value'  ";
			$dbcon->execute($ss);
			
			$notes				= '订单通过挂号扫描 扫描人是:'.$truename;
			addordernote($value,$notes);
		
			}else{
			$status = " -[<font color='#FF0000'>操作记录:未设置核对成功后转入的状态</font>]";	
			}
			}else{
			$status = " -[<font color='#FF0000'>操作记录:未找到订单</font>]";	
		}
		
	}
	
	}
	

 ?>
<style type="text/css">
<!--
.STYLE1 {
	font-size: larger;
	font-weight: bold;
}
-->
</style>

<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo "订单扫描".$status;?> </h2>
</div>

<div class='listViewBody'>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td width="65%">
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
				  <td nowrap="nowrap" class='paginationActionButtons'><form action="orderloadcsv.php" enctype="multipart/form-data" method="post" >
				    <table width="71%" border="0" align="center">
				      <tr>
				        <td width="21%">订单号</td>
				        <td width="56%"><input name="order" type="text" id="order" onKeyDown="check01()" style="font-size:86px; width:500px ; height:90px ">&nbsp;</td>
			            <td width="23%">:</td>
				      </tr>
				      <tr>
				        <td>跟踪号</td>
				        <td><input name="tracknumber" type="text" id="tracknumber" onkeydown="check02()"  style="font-size:86px; width:800px ; height:90px "></td>
		                <td width="23%"><span style="font-size:180px">
                        
                        </span></td>
				      </tr>
				      <tr>
				        <td colspan="3">&nbsp;</td>
			          </tr>
			        </table>
				  </form>
				  </td>
			    </tr>
			</table>		</td>
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
	function check01(){
		
		var order	= document.getElementById('order').value;	
		
		var tracknumber		= document.getElementById('tracknumber').value;	
		var shiptype		= '';	
		
		var keyCode=(navigator.appName=="Netscape")?event.which:event.keyCode; 
		
		
		if (keyCode == 13) {
			
			
			document.getElementById('tracknumber').focus();
			
				
		
		}
		
		
	}
	
	
	function check02(){
			
			var keyCode = event.keyCode;		
			var tracknumber		= document.getElementById('tracknumber').value;	
			var order	= document.getElementById('order').value;	
			var shiptype		= '';
			
			
			var keyCode=(navigator.appName=="Netscape")?event.which:event.keyCode; 
				
			if (keyCode == 13) {
			
				
				if(order == ''){
				
				alert("订单号不能为空");
				document.getElementById('order').focus();
				return false;
				}
				location.href	= 'scanorder_01.php?value='+order+"&shiptype="+shiptype+"&tracknumber="+tracknumber+"&module=orders";
						
		
			}
		
			
			
	
	
	
	}
	
	
	

	
	 document.getElementById('order').select();	


</script>