<?php
include "include/config.php";
include "top.php";	
	/* 修改客户地址 */
	$sid	= $_REQUEST['storeid'];

	if($_POST['submit']){
	
		$zjcz		 		= str_rep($_POST['zjcz']);
		$notes				= str_rep($_POST['notes']);
	
		if($sid == ""){
		
		$sql		=  "INSERT INTO `ebay_goodscz` (`zjcz` ,`notes`,";
		$sql		.= "`ebay_user`)VALUES ('$zjcz', '$notes', '$user')";
		
		}else{
		
			
		$sql		= "UPDATE `ebay_goodscz` SET `zjcz` = '$zjcz',`notes` = '$notes'";
		$sql	   .= " WHERE `id` =$sid ";
		
		}


		
		if($dbcon->execute($sql)){
			
			
			$status	= " -[<font color='#33CC33'>操作记录: 保存成功</font>]";
			
		}else{

			$status = " -[<font color='#FF0000'>操作记录: 保存失败</font>]";
			
		}
		
	
	}
	

	
	
	
	$sql		= "select * from ebay_goodscz where id='$sid'";	
	
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
					  	
				
							$zjcz			= $sql[0]['zjcz'];							
							$notes   		= $sql[0]['notes'];

						   
					  ?>
                      &nbsp;<br>
                      <form id="ad" name="ad" method="post" action="productsczadd.php?storeid=<?php echo $sid;?>&module=warehouse&action=产品材质管理">
                      
                      <table width="89%" border="0" cellpadding="0" cellspacing="0" class="login_txt">
                        <tr>
                          <td width="13%">产品材质</td>
                          <td width="41%"><input name="zjcz" type="text" id="zjcz" value="<?php echo $zjcz;?>"></td>
                        </tr>
                        <tr>
                          <td>备注</td> 
                          <td><input name="notes" type="text" id="store_note" value="<?php echo $notes;?>"></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td><input name="submit" type="submit" value="保存" /></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
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