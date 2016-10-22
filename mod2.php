<?php
include "include/config.php";


include "top.php";


$ordersn	= explode(",",$_REQUEST['bill']);
$totalcount	= count($ordersn)-1;
$status	    = "";



	
	if($_POST['submit']){
	
			
			$f_sku					= $_POST['f_sku']?$_POST['f_sku']:0;
			$f_status				= $_POST['f_status']?$_POST['f_status']:0;
			$f_style				= $_POST['f_style']?$_POST['f_style']:0;
			$f_warehouse			= $_POST['f_warehouse']?$_POST['f_warehouse']:0;
			
			
			$sku					= $_POST['sku']?$_POST['sku']:0;
			$status					= $_POST['status']?$_POST['status']:0;
			$style					= $_POST['style']?$_POST['style']:0;
			$warehouse				= $_POST['warehouse']?$_POST['warehouse']:0;

			
			for($i=0;$i<count($ordersn);$i++){
			
					
					$osn		= $ordersn[$i];
					if($ordersn != ''){
					
					
						$sql2		= "update ebay_order set mailstatus='' ";
						
						if($f_style == '1'){
						
							$sql2	.= ",ebay_carrier='$style' ";
							
						}
						
						if($f_status == '1'){
						
							$sql2	.= ",ebay_status='$status' ";
							
						}
						
						$sql2		.= " where ebay_id='$osn'";


						
							
							if($dbcon->execute($sql2)){
							
							
							$status0			= " -[<font color='#33CC33'>操作记录: 操作成功</font>]";							
							
							}
							
							


						
						
						
						
						
						
						
						
							
						
						
						
						
						
					
					
					}
			
			
			}
			
		
	
	}



	


?>

<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status0;?></h2>
</div>
 
<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 <input name="hiddenuserid" type="hidden" value="" id="hiddenuserid" />
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
		
	<td nowrap="nowrap" scope="row" >批量修改：您已经选择了<?php echo $totalcount;?>条记录，请在需要批量修改的地方输入新值</td>
	</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td width="26%">
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'>			
                      <form id="form" name="form" method="post" action="mod2.php?module=zencart&bill=<?php echo $_REQUEST['bill']; ?>">
                  <table width="70%" border="0" cellpadding="0" cellspacing="0">
                <input name="id" type="hidden" value="<?php echo $id;?>">
			      
			      <tr>
			        <td width="40%" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right"><span style="white-space: nowrap;">
			          <input name="f_status" type="checkbox" value="1" id="f_status">	
			        </span></div></td>
			        <td width="10%" align="right" bgcolor="#f2f2f2" class="left_txt">订单状态</td>
			        <td width="50%" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <select name="status" id="status">
                       
                            <option value="-1" <?php if($oost == "-1") echo "selected=selected" ?>>请选择</option>
                            <option value="1" <?php  if($oost == "0")  echo "selected=selected" ?>>ZenCart未处理</option>

                            <option value="2" <?php  if($oost == "1")  echo "selected=selected" ?>>ZenCart已处理</option>
            				 <option value="3" <?php  if($oost == "3")  echo "selected=selected" ?>>ZEN-CART待MARK SHIP</option>
                            <option value="4" <?php  if($oost == "4")  echo "selected=selected" ?>>ZenCart退款订单</option>
                            <option value="5" <?php  if($oost == "5")  echo "selected=selected" ?>>ZenCart取消订单</option>
                           <option value="6" <?php  if($oost == "6")  echo "selected=selected" ?>>ZenCart缺货订单</option>.
                           
                           <option value="7" <?php  if($oost == "7")  echo "selected=selected" ?>>ZenCart待打印订单</option>
                           <option value="8" <?php  if($oost == "8")  echo "selected=selected" ?>>ZenCart已打印订单</option>
                   
                      </select>
			        </div></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><span style="white-space: nowrap;">
			          <input name="f_style" type="checkbox" value="1" id="f_style">
			        </span></td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">发货方式</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <select name="style" id="style">
                        <option value="-1" >请选择</option>
                        <?php
						   	
							$tql	= "select * from ebay_carrier where ebay_user = '$user'";
							$tql	= $dbcon->execute($tql);
							$tql	= $dbcon->getResultArray($tql);
							for($i=0;$i<count($tql);$i++){
							
							$tname		= $tql[$i]['name'];
							$tvalue		= $tql[$i]['value'];
							
						   
						   ?>
                        <option value="<?php echo $tvalue;?>"  <?php if($tvalue == $ebay_carrier) echo "selected=selected" ?>><?php echo $tname;?></option>
                        <?php
						   }
						   
						   
						   ?>
                      </select>
			        </div></td>
			        </tr>
			      
			      
			      
			      
			      
                  <tr>				 
                    <td align="right" class="left_txt"><div align="right"></div></td>
                    <td align="right" class="left_txt">&nbsp;</td>
                    <td align="right" class="left_txt"><div align="left">
                      <input name="submit" type="submit" value="保存数据" onClick="return check()">
                    </div></td>
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
