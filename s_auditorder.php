<?php 
include "include/config.php";
	
	$value		= trim($_REQUEST['value']);
	
	$auditstatus = 0;
	
	
	
	echo $value;
	
	
	die();
	
	if($value >0){
		
		$ss		= "delete from shipping_checkorder";
		$dbcon->execute($ss);
		$ss		= "select * from ebay_order where ebay_id='$value'";	
		$ss		= $dbcon->execute($ss);
		$ss		= $dbcon->getResultArray($ss);
		$sorder	= $ss[0]['ebay_ordersn'];
		$ss		= "select * from ebay_orderdetail where ebay_ordersn='$sorder'";
		$ss		= $dbcon->execute($ss);
		$ss		= $dbcon->getResultArray($ss);
		for($i=0 ; $i<count($ss) ; $i++){
			
			$ebay_itemtitle		= str_rep($ss[$i]['ebay_itemtitle']);
			$sku				= trim(str_rep($ss[$i]['sku']));
			$ebay_itemprice		= $ss[$i]['ebay_itemprice'];
			$ebay_amount		= $ss[$i]['ebay_amount'];
			$ebay_ordersn		= $ss[$i]['ebay_ordersn'];
			$sh					= "insert into shipping_checkorder(ebay_products_sn,ebay_products_name,ebay_products_count,selectcount,ebay_products_order) values('$sku','$ebay_itemtitle','$ebay_amount','0','$ebay_ordersn')";
			$dbcon->execute($sh);
		}
		
	
	}else{
		
		$errorstatus= '';
		
		$qty		= $_REQUEST['qty'];
		$ss			= "select * from shipping_checkorder where ebay_products_sn='$value' and (ebay_products_count != selectcount)";
		$ss			= $dbcon->execute($ss);
		$ss			= $dbcon->getResultArray($ss);
		if(count($ss) > 0){
		
		$id			= $ss[0]['id'];
		
		$ssqty0		= $ss[0]['ebay_products_count'];
		$ssqty1		= $ss[0]['selectcount'];
		$ssqty2		= $ssqty0 - $ssqty1;
		if($qty > $ssqty2){
		
			$errorstatus= '<font color=red>产品数量有误，请核查</font>';
		
		}else{
		
				
				$ss		= "update shipping_checkorder set selectcount=selectcount+$qty where id='$id'";
				if($dbcon->execute($ss)){
						
						
						$errorstatus= '<font color=red>产品核对成功</font>';
						
					
				}
				
			
		
		}
		
		}else{
		
		
			$errorstatus= '<font color=red>SKU有误，请核查</font>';
			
		
		}
		
		
	
	}
	
	
	$ss		= "select * from shipping_checkorder where ebay_products_count != selectcount";
				$ss		= $dbcon->execute($ss);
				$ss		= $dbcon->getResultArray($ss);
				if(count($ss) == 0){
					
						
						
						$auditstatus = 1;
						
				}
				
				
	
	
	$ss		= "select * from shipping_checkorder";
	$ss		= $dbcon->execute($ss);
	$ss		= $dbcon->getResultArray($ss);
	$sorder	= $ss[0]['ebay_products_order'];
		
	if($value == '') $errorstatus = '';
	
	
	
 ?>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #F8F9FA;
}
-->
</style>

<link href="../images/skin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="../My97DatePicker/WdatePicker.js"></script>
<body>
<input name="hiddenuserid" type="hidden" value="" id="hiddenuserid" />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="17" height="29" valign="top" background="../images/mail_leftbg.gif">&nbsp;</td>
    <td width="1138" height="29" valign="top" background="../images/content-bg.gif"><table width="100%" height="31" border="0" cellpadding="0" cellspacing="0" class="left_topbg" id="table2">
      <tr>
        <td height="31"><div class="titlebt">订单核对</div></td>
      </tr>
    </table></td>
    <td width="21" valign="top" background="../images/mail_rightbg.gif"><img src="../images/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>
  <tr>
    <td height="71" valign="middle" background="../images/mail_leftbg.gif">&nbsp;</td>
    <td valign="top" bgcolor="#F7F8F9"><table width="100%" height="138" border="0" cellpadding="0" cellspacing="0">
      
      <tr>
        <td valign="top"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td class="left_txt">&nbsp;</td>
          </tr>
          <tr>
            <td height="20"><table width="100%" height="1" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
              <tr>
                <td></td>
              </tr>
            </table></td>
          </tr>
          
          <tr>
            <td><table width="100%" height="31" border="0" cellpadding="0" cellspacing="0" class="nowtable">
              <tr>
                <td class="left_bt2">订单号/物品编号：
                  <input name="order" type="text" id="order" onKeyPress="check()" value=""> 
                  产品数量：
                  <input name="qty" type="text" id="qty" onKeyPress="check()" value="1">
                  挂号条码：
                  <input name="tracknumber" type="text" id="tracknumber" onKeyPress="check()" >
                  
                  <?php echo $errorstatus;?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			      <td width="100%"><table width="100%" border="1" cellpadding="0" cellspacing="0">
                    <tr>
                      <td>客户ID</td>
                      <td>发货地址</td>
                      <td colspan="2" valign="top"><?php
                      
					  echo $addressline;
					  
					  
					  
					  ?>
                      &nbsp;</td>
                      </tr>
                    
                    <tr>
                      <td>物品编号</td>
                      <td>物品名称</td>
                      <td>等待核对数量</td>
                      <td>已核对数量</td>
                    </tr>
                    <?php
						
						
						$tracknumber		= $_REQUEST['tracknumber'];
						$shiptype			= $_REQUEST['shiptype'];
						if($tracknumber != ''){
						
							$sql	= "update ebay_order set ebay_tracknumber='$tracknumber' where ebay_ordersn='$sorder'";
							
						
							
							$dbcon->execute($sql);
							
						}
						
						
						
						
						$ss		= "select * from shipping_checkorder where ebay_products_order ='$sorder'";
						
						$ss		= $dbcon->execute($ss);
						$ss		= $dbcon->getResultArray($ss);
						for($i=0;$i<count($ss);$i++){
							
							$ebay_products_sn		= $ss[$i]['ebay_products_sn'];
							$ebay_products_name		= $ss[$i]['ebay_products_name'];
							$ebay_products_count	= $ss[$i]['ebay_products_count'];
							$selectcount			= $ss[$i]['selectcount'];
						
							$ff		= "select * from ebay_orderdetail where sku='$ebay_products_sn' and ebay_ordersn='$sorder'";
						
						
		
							
							$rr					= "select * from ebay_goods where goods_sn='$ebay_products_sn'";
							$rr 				= $dbcon->execute($rr);
							$rr					= $dbcon->getResultArray($rr);
							$goods_name			= $rr[0]['goods_name'];
								
								
							
							
						
							
					?>
                    
                    <tr>
                      <td><?php echo $ebay_products_sn;?>&nbsp;</td>
                      <td><?php echo $goods_name;?>&nbsp;</td>
                      <td><div style="font-size:36px; color:#FF0000"><?php echo $ebay_products_count;?></div> </td>
                      <td><div style="font-size:38px; color:#009900"><?php echo $selectcount;?></div> </td>
                    </tr>
                    
                    <?php } ?>
                    
                  </table>
			    <tr>
                <td width="80%" height="17" colspan="4" align="right" >&nbsp;</td>
              </tr>
            
            </table></td>
          </tr>
        </table>          </td>
      </tr>
    </table></td>
    <td background="../images/mail_rightbg.gif">&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle" background="../images/mail_leftbg.gif">&nbsp;</td>
    <td height="17" valign="top" background="../images/buttom_bgs.gif">&nbsp;</td>
    <td background="../images/mail_rightbg.gif"><img src="../images/buttom_right2.gif" width="16" height="17" /></td>
  </tr>
</table>
</body>
<?php

$focuss	= 0;

	
	if($auditstatus == 1){
	
		
		$ss		= "select * from ebay_order where ebay_ordersn='$sorder'";
		$ss		= $dbcon->execute($ss);
		$ss		= $dbcon->getResultArray($ss);
		$ebay_carrier	 = $ss[0]['ebay_carrier'];
		$ebay_tracknumber	 = $ss[0]['ebay_tracknumber'];
		
		
		$ss		= "select * from ebay_carrier where name='$ebay_carrier' and ebay_user ='$user'";


		
		$ss		= $dbcon->execute($ss);
		$ss		= $dbcon->getResultArray($ss);
		$is_reg	 = $ss[0]['is_reg'];
		
	
		
	
		
		
		if($is_reg == '1'){
			
			
			if($ebay_tracknumber == ''){
			echo '<script language="javascript">alert('."'Please enter tracknumber'".');</script>';
			$focuss =1;
			}else{
				
				
				$ss		= "delete from shipping_checkorder";
				$dbcon->execute($ss);
				$ss		= "update ebay_order set ebay_status='11' where ebay_ordersn ='$sorder'";
				$dbcon->execute($ss);
				$ss		= "select * from ebay_orderdetail where ebay_ordersn='$sorder'";
				$ss		= $dbcon->execute($ss);
				$ss		= $dbcon->getResultArray($ss);
				for($i=0;$i<count($ss);$i++){
						$sku				= $ss[$i]['sku'];
						$ebay_amount		= $ss[$i]['ebay_amount'];
						//$st					= "update ebay_goods set goods_count=goods_count-$ebay_amount where goods_sn='$sku'";
						//$dbcon->execute($st);
				}
				
				$errorstatus= '<font color=Blue>此订单已经核对完成，订单已经转入下一步</font>';
				echo $errorstatus;
			
				
				
				
			}
			
			
			
			
			
		}else{
			
			
			$ss		= "delete from shipping_checkorder";
			$dbcon->execute($ss);
			$ss		= "update ebay_order set ebay_status='11' where ebay_ordersn ='$sorder'";
			$dbcon->execute($ss);
			$ss		= "select * from ebay_orderdetail where ebay_ordersn='$sorder'";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			for($i=0;$i<count($ss);$i++){
					$sku				= $ss[$i]['sku'];
					$ebay_amount		= $ss[$i]['ebay_amount'];
					//$st					= "update ebay_goods set goods_count=goods_count-$ebay_amount where goods_sn='$sku'";
					//$dbcon->execute($st);
			}
			
			$errorstatus= '<font color=Blue>此订单已经核对完成，订单已经转入下一步</font>';
			echo $errorstatus;
			
			
		}
		
	}
?>



<script language="javascript">

	
	function check(){
		
		var order	= document.getElementById('order').value;	
		var keyCode = event.keyCode;
		var qty		= document.getElementById('qty').value;	
		var tracknumber		= document.getElementById('tracknumber').value;	
		var shiptype		= '';
		
		
		
		
		if (keyCode == 13) {
		
			
		
			location.href	= 's_auditorder.php?value='+order+"&sorder=<?php echo $sorder;?>&qty="+qty+"&shiptype="+shiptype+"&tracknumber="+tracknumber;
					
		
		}
		
		
	}
	
	
	 document.getElementById('order').select();	
	 document.getElementById('order').focus();
	 
	



	var focuss	= "<?php echo $focuss;?>";
	if(focuss == "1")  document.getElementById('tracknumber').focus();
	

</script>

