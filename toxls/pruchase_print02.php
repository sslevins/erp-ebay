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
$operationuser		=  $sql[0]['operationuser'];
$type		=  $sql[0]['type'];
$io_addtime		=  $sql[0]['io_addtime'];
$partner		=  $sql[0]['io_partner'];
$ordersn		=  $sql[0]['io_ordersn'];



$ss				= "select * from ebay_partner where company_name='$partner'";
$ss				= $dbcon->execute($ss);
$ss				= $dbcon->getResultArray($ss);
$tel			= $ss[0]['tel'];
$fax			= $ss[0]['fax'];

?>

<table width="70%" border="0" align="center" cellpadding="3" cellspacing="2">
  
  
  <tr>
    <td><table width="100%" border="1" cellspacing="2" cellpadding="3">
      <tr>
        <td colspan="6" align="center"><strong style="font-size:28px">深圳市百纳数码科技有限公司</strong></td>
        </tr>
      <tr>
        <td colspan="4" align="center"><strong>采购订单</strong></td>
        <td colspan="2">采购日期：<?php echo  date('Y-m-d',$io_addtime);?></td>
        </tr>
      <tr>
        <td>审核人：</td>
        <td><?php echo $operationuser;?>&nbsp;</td>
        <td colspan="4">单据编号：<?php echo $ordersn;?>&nbsp;</td>
        </tr>
      <tr>
        <td>供应商电话：</td>
        <td><?php echo $tel;?>&nbsp;</td>
        <td colspan="4">供应商传真：<?php echo $fax;?></td>
        </tr>
      <tr>
        <td>商品代码</td>
        <td>商品名称</td>
        <td>规格</td>
        <td>采购数量</td>
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
        <td><?php echo $goods_sn;?></td>
        <td><?php echo $goods_name;?>&nbsp;</td>
        <td><?php echo $goods_name; ?>&nbsp;</td>
        <td>&nbsp;<?php echo $goods_count; ?></td>
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
        <td>&nbsp;</td>
        <td><?php echo $totalproductsprice;?>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="6"><p>备注：
          </p>
          <p>1：供应商需提供&quot;产品质量保证书&quot;;<br />
            2: 必须在要求的时间内安排发货，对于延误或异常造成的经济损失会收取相应的滞纳金或赔偿金；<br />
            3：发货是必须开具送货单，单上写明我公司的采购单与、物料名称、型号、数量、放入清单箱子，必须<br />
            用大头笔在外上写上&quot;内有清单&quot;。</p>
          <p>电话：0755-83745064    传真： 0755-83584302</p>
          <p>交货地址： 深圳福田区兰光路桑达小区405栋本座402室<br />
          </p>
          <p>采购签名 :   _______________________________________________供应商签名:____________________________________________________</p></td>
        </tr>

      
   
      
      
    </table></td>
  </tr>
  
  <tr>
    <td>打印日间:<?php echo date('Y-m-d H:i:s'); ?> 单号:<?php echo $ordersn;?></td>
  </tr>
</table>
</body>
</html>
