<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<body>
<?php

include "include/config.php";

$ordersn		= $_REQUEST['ordersn'];
$sql			= "select * from  ebay_iostore where io_ordersn='$ordersn'";
	
	
$sql			= $dbcon->execute($sql);
$sql			= $dbcon->getResultArray($sql);
$in_type		= $sql[0]['io_type'];
$in_warehouse	= $sql[0]['io_warehouse'];
$note			= $sql[0]['io_note'];
$iistatus		=  $sql[0]['io_status'];
$type		=  $sql[0]['type'];
$io_addtime		=  $sql[0]['io_addtime'];
$partner		=  $sql[0]['io_partner'];








$ss				= "select * from ebay_store where id='$in_warehouse'";
$ss				= $dbcon->execute($ss);
$ss				= $dbcon->getResultArray($ss);
$warehousename	= $ss[0]['store_name'];


$ss				= "select * from ebay_storetype where id='$in_type'";


$ss				= $dbcon->execute($ss);
$ss				= $dbcon->getResultArray($ss);
$iotype			= $ss[0]['ebay_storename'];


if($type == "0") $typestr = '入库单';
if($type == "1") $typestr = '出库单';

?>

<table width="70%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <td><div align="center"><?php echo $typestr;?></div></td>
  </tr>
  <tr>
    <td><p>单据日期：<?php echo date('Y-m-d',$io_addtime);?>&nbsp;&nbsp;</p>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="16%">单据类型</td>
          <td width="15%"><?php echo $typestr;?></td>
          <td width="7%">仓库</td>
          <td width="35%"><?php echo $warehousename;?></td>
          <td width="16%">单号</td>
          <td width="11%"><?php echo $ordersn;?>&nbsp;</td>
        </tr>
        <tr>
          <td>供应商代码</td>
          <td bordercolor="#55A0FF"><?php echo $partner; ?>&nbsp;</td>
          <td>备注</td>
          <td colspan="3"><?php echo $note; ?>&nbsp;</td>
        </tr>
      </table>      
    <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td><table width="100%" border="1" cellspacing="1" cellpadding="3">
      <tr>
        <td>产品编号</td>
        <td>图片</td>
        <td>产品名称</td>
        <td>产品单位</td>
        <td>产品数量</td>
        <td>单价</td>
        <td>总额</td>
        </tr>
      
         <?php
							
							$sql	= "select * from ebay_iostoredetail where io_ordersn='$ordersn'";
						
							
							$sql	= $dbcon->execute($sql);
							$sql	= $dbcon->getResultArray($sql);
							
							$totalproductscount	= 0;
							$totalproductsprice	= 0;
							$totalsprice	= 0;
							
							
							for($i=0;$i<count($sql);$i++){
								
								$goods_sn			= $sql[$i]['goods_sn'];
								$goods_name 		= $sql[$i]['goods_name'];
								$goods_price 		= $sql[$i]['goods_cost'];
								$goods_unit 		= $sql[$i]['goods_unit'];
								$id					= $sql[$i]['id'];
								$goods_count  		= $sql[$i]['goods_count'];
								
								
								$vv			= "select * from ebay_goods where ebay_user ='$user' and goods_sn ='$goods_sn'";
								$vv			= $dbcon->execute($vv);
								$vv			= $dbcon->getResultArray($vv);
								
								$goods_pic	= $vv[0]['goods_pic'];
								
								
								$pertotal			= $goods_count * $goods_price;
								$totalproductscount	+=$goods_count;
								$totalproductsprice	+=$pertotal;
								
								
								
								
								
						?>
                        
                        
                        
      <tr>
        <td><?php echo $goods_sn;?>&nbsp;</td>
        <td><img src="images/<?php echo $goods_pic; ?>" width="50" height="50" />&nbsp;</td>
        <td><?php echo $goods_name;?>&nbsp;</td>
        <td><?php echo $goods_unit; ?>&nbsp;</td>
        <td><?php echo $goods_count;?>&nbsp;</td>
        <td><?php echo $goods_price; ?>&nbsp;</td>
        <td><?php echo $pertotal; ?>&nbsp;</td>
        </tr>

      
      
      <?php
	  
	  }
	  
	  
	  ?>
      
      
            <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>总计</td>
        <td>&nbsp;</td>
        <td><?php echo $totalproductscount;?>&nbsp;</td>
        <td>&nbsp;</td>
        <td><?php echo $totalproductsprice;?>&nbsp;</td>
        </tr>
      
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25%">审核状态：</td>
        <td width="25%">
        <?php
			
			if($iistatus == 0){
			
				
				echo "未审核";
				
			
			}else if($iistatus == 1){
			
				
				echo "已审核";
				
			
			}
			
		
		
		
		?>
        
        
        &nbsp;</td>
        <td width="14%">主管签名：</td>
        <td width="31%">&nbsp;</td>
        <td width="5%">&nbsp;</td>
      </tr>
      <tr>
        <td>采购员签名：</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>仓库员签名：</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>打印日间:<?php echo date('Y-m-d H:i:s'); ?></td>
  </tr>
</table>
</body>
</html>
