<?php
include "include/config.php";
include "top.php";	
	/* 修改客户地址 */
	$partnerid	= $_REQUEST['partnerid'];  // 供应商的ID号
	$id			= $_REQUEST['id'];  // 供应商的ID号

	if($_POST['ad']){
	
		$sku 		= str_rep($_POST['sku']);
		$partner_sku			= mysql_escape_string($_POST['partner_sku']);
		$goods_name				= mysql_escape_string($_POST['goods_name']);
		$goods_cost				= mysql_escape_string($_POST['goods_cost']);
		$goods_note				= mysql_escape_string($_POST['goods_note']);
		
		$purchase_time						= mysql_escape_string($_POST['purchase_time']);
		$purchase_smallquantity				= mysql_escape_string($_POST['purchase_smallquantity']);
		
		

		$addormod				= 0;
		if($sku != ''){
		if($id == ""){
				$sql	= "insert into partner_skuprice(sku,partner_sku,goods_name,goods_cost,goods_note,addtime,adduser,ebay_user,partnerid,purchase_time,purchase_smallquantity) 			values('$sku','$partner_sku','$goods_name','$goods_cost','$goods_note','$nowtime','$truename','$user','$partnerid','$purchase_time','$purchase_smallquantity')";
				$addormod		= 1;
				
		}else{
				$sql	= "update partner_skuprice set sku='$sku',partner_sku='$partner_sku',goods_name='$goods_name',goods_cost='$goods_cost',goods_note='$goods_note',purchase_time='$purchase_time',purchase_smallquantity='$purchase_smallquantity' where partner_id='$id'";
		}
		
		
		
			if($dbcon->execute($sql)){
				$status	= " -[<font color='#33CC33'>操作记录: 保存成功</font>]";
				if($addormod == '1'){
					
					$id		= mysql_insert_id();
					
				}
			}else{
				$status = " -[<font color='#FF0000'>操作记录: 保存失败</font>]";
			}
			
			
		}else{
		
			$status = " -[<font color='#FF0000'>操作记录: 保存失败</font>]";
		}
	}
	
	
	
	
	
	
	$sql		= "select sku,partner_sku,goods_name,goods_cost,goods_note,purchase_time,purchase_smallquantity from partner_skuprice where partner_id='$id'";
	$sql		= $dbcon->execute($sql);
	$sql		= $dbcon->getResultArray($sql);


 ?>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'><?php echo $status;?></div>


 
 
<table width="90%" cellspacing="0" cellpadding="0" border="0">
<tr>
	<td nowrap="nowrap" scope="row" ><table width="100%" border="0" cellpadding="0" cellspacing="0">

                    <tr>
                      <td valign="top" class="left_txt">
                      <?php
						   $sku					= $sql[0]['sku'];
						   $partner_sku			= $sql[0]['partner_sku'];
						   $goods_name			= $sql[0]['goods_name'];
						   $goods_cost			= $sql[0]['goods_cost'];
						   $goods_note			= $sql[0]['goods_note'];
						   $purchase_time			= $sql[0]['purchase_time'];
						   $purchase_smallquantity			= $sql[0]['purchase_smallquantity'];
						   
						   
					  ?>
                      &nbsp;<br>
                      <form id="ad" name="ad" method="post" action="partnerskupriceadd.php?partnerid=<?php echo $partnerid;?>&module=purchase&action=价格清单管理&id=<?php echo $_REQUEST['id']; ?>">
                      <input type="hidden" value="<?php echo $_REQUEST['type'];?>" name="type" />
                      
                      <table width="89%" border="1" cellpadding="0" cellspacing="0" class="login_txt">
                        <tr>
                          <td width="17%">产品编号：</td>
                          <td width="20%"><input name="sku" type="text" id="sku" value="<?php echo $sku;?>">
                          (必填)</td>
                          <td width="63%">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>供应商编号：</td>
                          <td><input name="partner_sku" type="text" id="partner_sku" value="<?php echo $partner_sku; ?>" /></td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td><p >采购交期：</p></td>
                          <td><input name="purchase_time" type="text" id="purchase_time" value="<?php echo $purchase_time; ?>" />
                            （天）</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>最小起订量：</td>
                          <td><input name="purchase_smallquantity" type="text" id="purchase_smallquantity" value="<?php echo $purchase_smallquantity; ?>" /></td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>产品成本：</td>
                          <td><input name="goods_cost" type="text" id="goods_cost" value="<?php echo $goods_cost; ?>" /></td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>产品名称： </td>
                          <td colspan="2"><textarea name="goods_name" cols="100" id="goods_name"><?php echo $goods_name; ?></textarea></td>
                        </tr>
                        
                        
                        
                        
                        <tr>
                          <td>备注</td>
                          <td colspan="2"><textarea name="goods_note" cols="100" rows="8" id="goods_note"><?php echo $goods_note;?></textarea></td>
                        </tr>
                        
                        <tr>
                          <td colspan="3"><input name="ad" type="submit" value="保存" id="address">
                          <input name="address" type="button" value="返回" id="address2" onclick="goback()"  /></td>
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
        <div class="clear"></div>
<?php

include "bottom.php";


?>
<script language="javascript">
	

	

	

	function goback(){
		var url	= 'partnerskuprice.php?module=system&action=价格清单&partnerid=<?php echo $_REQUEST['partnerid']; ?>';
		location.href = url;
	}
	


</script>