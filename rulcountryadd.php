<?php
include "include/config.php";
include "top.php";	
	/* 修改客户地址 */
	$sid	= $_REQUEST['id'];

	if($_POST['submit']){
	
		$country 			= str_rep($_POST['country']);
		$value				= str_rep($_POST['value']);
		
	
	
		if($sid == ""){
		
		$sql		=  "INSERT INTO `ebay_countryrule` (`country` ,`value` ,`ebay_user` ";
		$sql		.= ")VALUES ('$country', '$value','$user')";
		
		}else{
		
			
		$sql		= "UPDATE `ebay_countryrule` SET `country` = '$country',`value` = '$value' WHERE `id` =$sid ";
		
		}

	
		
		if($dbcon->execute($sql)){
			
			
			$status	= " -[<font color='#33CC33'>操作记录: 保存成功</font>]";
			
		}else{

			$status = " -[<font color='#FF0000'>操作记录: 保存失败</font>]";
			
		}
		
	
	}
	

	
	
	
	$sql		= "select * from ebay_countryrule where id='$sid'";	
	
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
					  	
				
							$country			= $sql[0]['country'];
							$value			= $sql[0]['value'];
							
						
							
						   
						   
					  ?>
                      &nbsp;<br>
                      <form id="ad" name="ad" method="post" action="rulcountryadd.php?id=<?php echo $sid;?>&module=warehouse&action=国家规则设置">
                    
                      <table width="89%" border="0" cellpadding="0" cellspacing="0" class="login_txt">
                        <tr>
                          <td width="13%">国家名称</td>
                          <td width="41%"><input name="country" type="text" id="country" value="<?php echo $country;?>"></td>
                          <td width="11%">&nbsp;</td>
                          <td width="35%">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>规格</td>
                          <td><input name="value" type="text" id="value" value="<?php echo $value; ?>"></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        
                        
                        <tr>
                          <td>&nbsp;</td>
                          <td><input name="submit" type="submit" value="保存" /></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td colspan="2">&nbsp;</td>
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