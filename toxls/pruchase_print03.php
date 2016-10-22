<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<body>
<?php

include "../include/config.php";

$ordersn		= $_REQUEST['ordersn'];
$sql			= "select * from  ebay_iostore where io_ordersn='$ordersn'";
	
	
$sql			= $dbcon->execute($sql);
$sql			= $dbcon->getResultArray($sql);





$in_type		= $sql[0]['io_type'];
$in_warehouse	= $sql[0]['io_warehouse'];


$vv	 = "select id,store_name from ebay_store where ebay_user='$user' and id = $in_warehouse";
$vv	 = $dbcon->execute($vv);
$vv	 = $dbcon->getResultArray($vv);
$warehousename		= $vv[0]['store_name'];

					
					
					
$note			= $sql[0]['io_note'];
$operationuser		=  $sql[0]['operationuser'];
$type		=  $sql[0]['type'];
$io_addtime		=  $sql[0]['io_addtime'];
$partner		=  $sql[0]['io_partner'];
$ordersn		=  $sql[0]['io_ordersn'];





?>

<table width="70%" border="0" align="center" cellpadding="3" cellspacing="2">
  
  
  <tr>
    <td><table width="100%" border="1" cellspacing="2" cellpadding="3">
      <tr>
        <td colspan="7" align="center"><strong style="font-size:28px">深圳市百纳数码科技有限公司</strong></td>
        </tr>
      <tr>
        <td colspan="7" align="center"><strong>采购入库单</strong></td>
      </tr>
      <tr>
        <td>单据日期：<?php echo  date('Y-m-d',$io_addtime);?></td>
        <td>&nbsp;</td>
        <td colspan="5">单号：<?php echo $ordersn;?>&nbsp;</td>
      </tr>
      <tr>
        <td>供应商:<?php echo $partner;?></td>
        <td>&nbsp;</td>
        <td colspan="5">入库仓库：<?php echo $warehousename;?></td>
        </tr>
      <tr>
        <td>商品代码</td>
        <td>商品名称</td>
        <td>规格</td>
        <td>采购数量</td>
        <td>入库数量</td>
        <td>采购单价</td>
        <td>金额</td>
        </tr>
      
         <?php
							
							$sql	= "select * from ebay_iostoredetail where io_ordersn='$ordersn'";
						
							
							$sql	= $dbcon->execute($sql);
							$sql	= $dbcon->getResultArray($sql);
							
							$totalproductscount	= 0;
							$totalproductsprice	= 0;
							$totalsprice	= 0;
							$t0	= 0;
							
							
							for($i=0;$i<count($sql);$i++){
								
								$goods_sn			= $sql[$i]['goods_sn'];
								$goods_name 		= $sql[$i]['goods_name'];
								$goods_price 		= $sql[$i]['goods_cost'];
								$goods_unit 		= $sql[$i]['goods_unit'];
								$id					= $sql[$i]['id'];
								$goods_count  		= $sql[$i]['goods_count'];
								
								$qty_01  		= $sql[$i]['qty_01'];
								$vv			= "select * from ebay_goods where ebay_user ='$user' and goods_sn ='$goods_sn'";
								$vv			= $dbcon->execute($vv);
								$vv			= $dbcon->getResultArray($vv);
								
								$goods_pic	= $vv[0]['goods_pic'];
								
								
								$pertotal			= $goods_count * $goods_price;
								$totalproductscount	+=$goods_count;
								$totalproductsprice	+=$pertotal;
								$t0+=$qty_01;
								
								
								
								
								
						?>
                        
                        
                        
      <tr>
        <td><?php echo $goods_sn;?></td>
        <td><?php echo $goods_name;?>&nbsp;</td>
        <td><?php echo $goods_name; ?>&nbsp;</td>
        <td>&nbsp;<?php echo $goods_count; ?></td>
        <td><?php echo $qty_01;?>&nbsp;</td>
        <td>&nbsp;<?php echo $goods_price; ?></td>
        <td><?php echo $goods_count*$goods_price; ?>&nbsp;</td>
        </tr>
        
        
           
      <?php
	  
	  }
	  
	  
	  ?>
      
      <tr>
        <td>合计</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><?php echo $totalproductscount;?>&nbsp;</td>
        <td><?php echo $t0;?>&nbsp;</td>
        <td>&nbsp;</td>
        <td><?php echo $totalproductsprice;?>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="7"><p>备注：
          </p>
          <p><br />
          </p>
<p>采购员签名 :   _______________________________________________仓库员签名:____________________________________________________</p></td>
        </tr>

      
   
      
      
    </table></td>
  </tr>
  
  <tr>
    <td>打印日间:<?php echo date('Y-m-d H:i:s'); ?> 单号:<?php echo $ordersn;?></td>
  </tr>
</table>
</body>
</html>
