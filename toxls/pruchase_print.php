<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<body>
<?php

include "../include/config.php";

$ordersn		= $_REQUEST['id'];
$sql			= "select * from  ebay_iostore where id='$ordersn'";
	
	
$sql			= $dbcon->execute($sql);
$sql			= $dbcon->getResultArray($sql);
$in_type		= $sql[0]['io_type'];
$in_warehouse	= $sql[0]['io_warehouse'];
$note			= $sql[0]['io_note'];
$iistatus		=  $sql[0]['io_status'];
$type		=  $sql[0]['type'];
$io_addtime		=  $sql[0]['io_addtime'];
$partner		=  $sql[0]['io_partner'];
$ordersn		=  $sql[0]['io_ordersn'];


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
    <td><table width="100%" border="1" cellspacing="1" cellpadding="3">
      <tr>
        <td>序号</td>
        <td>产品编号</td>
        <td>图片</td>
        <td>产品名称</td>
        <td>产品单位</td>
        <td>采购单价</td>
        <td>采购数量</td>
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
        <td><?php echo $i+1;?>&nbsp;</td>
        <td><?php echo $goods_sn;?></td>
        <td><img src="../images/<?php echo $goods_pic; ?>" width="50" height="50" />&nbsp;</td>
        <td><?php echo $goods_name;?>&nbsp;</td>
        <td><?php echo $goods_unit; ?>&nbsp;</td>
        <td><?php echo $goods_price; ?>&nbsp;</td>
        <td><?php echo $goods_count; ?>&nbsp;</td>
        </tr>

      
      
      <?php
	  
	  }
	  
	  
	  ?>
      
      
    </table></td>
  </tr>
  
  <tr>
    <td>打印日间:<?php echo date('Y-m-d H:i:s'); ?> 单号:<?php echo $ordersn;?></td>
  </tr>
</table>
</body>
</html>
