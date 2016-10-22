<?php
include "include/config.php";


include "top.php";
	
 ?>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status;?> </h2>
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
					<td nowrap="nowrap" class='paginationActionButtons'><form action="orderuploadsave3.php" enctype="multipart/form-data" method="post" target="_blank">
<table border="0"  cellpadding="10" cellspacing="1" bgcolor="#c0ccdd" id="content">
  <tr>
    <td>选择帐号</td>
    <td><select name="account" id="account">
    
     <option value="">请选择导入帐号</option>
      <?php 

					

					$sql	 = "select * from ebay_account as a where ebay_user='$user' and ($ebayacc) ";

					$sql	 = $dbcon->execute($sql);

					$sql	 = $dbcon->getResultArray($sql);

					for($i=0;$i<count($sql);$i++){					

					 

					 	$account	= $sql[$i]['ebay_account'];

					 ?>
      <option value="<?php echo $account;?>"><?php echo $account;?></option>
      <?php } ?>
    </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>上传文件:</td>
    <td><input name="upfile" type="file" class="button" style="height:22px;"   size=35/>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>导入到哪个分类中</td>
    <td><select name="orderstatus" id="orderstatus">
      <option value="" <?php if($oost == "") echo "selected=selected" ?>>请选择</option>
     
      <option value="0" <?php  if($oost == "0")  echo "selected=selected" ?>>待付款订单</option>
      <option value="1" <?php  if($oost == "1")  echo "selected=selected" ?>>待处理订单</option>
      <option value="2" <?php  if($oost == "2")  echo "selected=selected" ?>>已经发货</option>
      <?php
                            $ss		= "select * from ebay_topmenu where ebay_user='$user' and name != '' order by ordernumber";
							$ss		= $dbcon->execute($ss);
							$ss		= $dbcon->getResultArray($ss);
							for($i=0;$i<count($ss);$i++){
								$ssid		= $ss[$i]['id'];
								$ssname		= $ss[$i]['name'];
							?>
      <option value="<?php echo $ssid; ?>" <?php  if($oost == $ssid)  echo "selected=selected" ?>><?php echo $ssname; ?></option>
      <?php } ?>
    </select></td>
    <td><input name="提交" type="submit" class="button" value="更新" onclick="return checkupdate()" /></td>
  </tr>
</table>

                    </form>
					  <p><br />
			            </p></td>
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
	function check(){
		
		var days	= document.getElementById('days').value;	
		var account = document.getElementById('account').value;	
		location.href='orderloadstatus.php?days='+days+'&account='+account+"&module=orders&action=同步订单结果";
		
		
	}
	
	function checkupdate(){
		
		var account	= document.getElementById('account').value;	
		var orderstatus	= document.getElementById('orderstatus').value;	
		if(account == ''){
			
			alert('请选择帐号导入');
			return false;
		
		}
	
		if(orderstatus == ''){
			
			alert('请选择要导入的订单分类');
			return false;
		
		}
	
	
	}
	

</script>