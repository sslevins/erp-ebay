<?php
include "include/config.php";







	$value				= trim($_REQUEST['value']);
	$shiptype			= $_REQUEST['shiptype'];
	$tracknumber		= $_REQUEST['tracknumber'];
	$weight				= substr($_REQUEST['weight'],7,15);
	
	if($value != ''){
	
	
	$ss					= "select * from ebay_order where (ebay_id='$value' or  ebay_tracknumber = '$value') and  ebay_status !='2' and scantime = '0' ";
	$ss					= $dbcon->execute($ss);
	$ss					= $dbcon->getResultArray($ss);
	if(count($ss)  == '0'){
		$status = " -[<font color='#FF0000'>操作记录:未找到订单</font>]";	
	}else{
		
		$ebay_ordersn	= $ss[0]['ebay_ordersn'];
		$ebay_carrier	= $ss[0]['ebay_carrier'];
		
		$status = " -[<font color='#33CC33'>操作记录订单核对成功</font>]";	
		
		$ss		= "update ebay_order set ebay_status='2',scantime='$mctime',ebay_tracknumber='$tracknumber',orderweight2='$weight' where ebay_ordersn='$ebay_ordersn' ";
		echo $ss.'<br>';
		$dbcon->execute($ss);
		addoutstock($ebay_ordersn);
		
	}
	}




 ?>
 
 <link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/yui.css" />
<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/deprecated.css" />
<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/style.css" /> 

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
				    <table width="90%" border="0" align="center">
				      <tr>
				        <td width="21%">订单号</td>
				        <td width="56%"><input name="order" type="text" id="order" onKeyDown="check01()"  style=" width:90%; font-size:55px; border:#CC0000 2px solid; height:60px; line-height:60px; font-weight:bold;" >&nbsp;</td>
			            <td width="23%"><input type="button" value="导出扫描结果" onclick="opens()" /></td>
				      </tr>
				      <tr>
				        <td>&nbsp;</td>
				        <td>&nbsp;</td>
				        <td width="23%" rowspan="2"><span style="font-size:180px">
                        
                        <?php
$sql	= "select count(*) as cc from ebay_order as a where a.ebay_status='589' and a.ebay_user='$user' and a.ebay_combine!='1' and a.ordertype is null  and ($ebayacc)";
$sql	= $dbcon->execute($sql);
$sql	= $dbcon->getResultArray($sql);
echo $sql[0]['cc'];
?>
                        
                        
                        
                        
                        </span></td>
				      </tr>
				      <tr>
				        <td>重量</td>
				        <td><input name="weight" type="text" id="weight" onkeydown="check03()"  style=" width:90%; font-size:55px; border:#CC0000 2px solid; height:60px; line-height:60px; font-weight:bold;"  /></td>
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
				document.getElementById('weight').focus();
				
			
						
		
			}
		
			
			
	
	
	
	}
	
	function check03(){
			
			var keyCode = event.keyCode;		
			var tracknumber		= document.getElementById('tracknumber').value;	
			var order	= document.getElementById('order').value;	
			var weight	= document.getElementById('weight').value;
			var keyCode=(navigator.appName=="Netscape")?event.which:event.keyCode; 
				
			if (keyCode == 13) {
			
				
				if(order == ''){
				
				alert("订单号不能为空");
				document.getElementById('order').focus();
				return false;
				}
				
				
				location.href	= 'scanorder.php?value='+order+"&tracknumber="+tracknumber+"&weight="+weight;
						
		
			}
		
			
			
	
	
	
	}
	 document.getElementById('order').select();	


</script>