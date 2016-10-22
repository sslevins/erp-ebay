<?php 
	include "include/config.php";

		$io_ordersn=$_GET['io_ordersn'];
                
                $sql	= "select a.id,a.goods_sn,a.goods_name,a.goods_cost,a.goods_count,b.goods_pic,c.ebay_itemurl 
				from ebay_iostoredetail as a 
				left join ebay_goods as b on a.goods_sn = b.goods_sn 
				left join ebay_orderdetail as c on a.goods_sn = c.sku 
				where io_ordersn='$io_ordersn' order by id";													
							
                $query	= $dbcon->execute($sql);
                $result	= $dbcon->getResultArray($query);

                $data = array();
                $result = array_reverse($result);
                foreach($result as $vo){
                    $data[$vo['goods_sn']] = $vo;
                }
                
                $iostore_sql				= "select * from  ebay_iostore where io_ordersn='$io_ordersn'";
                $iostore_query				= $dbcon->execute($iostore_sql);
                $iostore_result				= $dbcon->getResultArray($iostore_query);
                $in_warehouse		= $iostore_result[0]['io_warehouse'];
                $purchase_user		= $iostore_result[0]['io_purchaseuser'];
                             
		if($_SERVER['REQUEST_METHOD']=='GET'&&$_GET['print']){
			//print_R($_GET['checkbox2']);
			$chek=serialize($_GET['checkbox2']);
			header("Location:barCode1.php?chek=$chek");
		} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>

<body>


	
	
<table width="879" height="58" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td width=40%>单号：<?php echo $io_ordersn;?></td><td width=15%>采购人：<?php echo $purchase_user;?></td><td>&nbsp;</td>
    </tr>
</table>

<form name="aa" id="aa" method="post" action="purchase_print2.php">
<table width="879" height="58" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="93" bgcolor="#CCCCCC" scope="col"><span style="white-space: nowrap;">
      <input name="ordersn2" type="checkbox" id="ordersn2" value="<?php echo $ordersn;?>" onclick="check_all('ordersn','ordersn')" />
    </span>操作</td>

        <td width="93" bgcolor="#CCCCCC" scope="col">sku</td>
        <td width="93" bgcolor="#CCCCCC" scope="col">产品名称</td>
        <td width="93" bgcolor="#CCCCCC" scope="col">图片</td>
        <td width="65" bgcolor="#CCCCCC" scope="col">实际库存</td>
        <td width="70" bgcolor="#CCCCCC" scope="col">采购单价</td>
        <td width="100" bgcolor="#CCCCCC" scope="col">进货数量</td>
        <td width="100" bgcolor="#CCCCCC" scope="col">本次入库数量</td>
  </tr>
<?php
foreach($data as $vo){
    $dataarray   = GetStockQtyBySku($in_warehouse,$vo['goods_sn']);
    $goods_count = $dataarray[0];

	$sql = "select serial_number from ebay_mini_label_record where sku='".$vo['goods_sn']."' limit 1";
	$tmp_data = $dbcon->execute($sql);
	$tmp_row=$dbcon->fetch_assoc($tmp_data);
	if(empty($tmp_row)) $tmp_row['serial_number'] = '';
	
?>
  <tr>
    <td><input name="ordersn" type="checkbox" id="ordersn" value="<?php echo $vo['id'];?>"  />
    
    
    
    <input name="sku<?php echo $vo['id'];?>" id="sku<?php echo $vo['id'] ?>" type="hidden" value="<?php echo $vo['goods_sn'];?>" />
    
    
    
    </td>

        <td><?php echo $vo['goods_sn'];?></td>
        <td><?php echo $vo['goods_name'];?></td>
        <td><img src="<?php echo empty($vo['goods_pic'])?$vo['ebay_itemurl']:$vo['goods_pic'];?>" width="50" height="50" /></td>
        <td><?php echo $goods_count;?></td>
        <td><?php echo $vo['goods_cost'];?></td>
        <td><?php echo $vo['goods_count'];?></td>
        <td><input name="goods_count<?php echo $vo['id'] ?>" type="text" id="goods_count<?php echo $vo['id'] ?>" />
      &nbsp;</td>
  </tr>
 
<?php	
  }
?>




 <tr>
    <td colspan="8"><input name="" type="submit" value="生成出库单" onclick="return check()" />
    &nbsp;<br />
    <br />
    <br />
    操作一栏，选择本次生成出库单的sku, 在本次入库数量中，可以输入入货的数量。</td>
  </tr>
</table>
</form>

</body>
</html>

<script language="javascript">

	
	function check_all(obj,cName)
	{
    var checkboxs = document.getElementsByName(cName);
	for(var i=0;i<checkboxs.length;i++){
		if(checkboxs[i].checked == false){
			checkboxs[i].checked = true;
		}else{
			checkboxs[i].checked = false;
		}
	}
	}

	function check(){
	var bill	= "";
	var g		= 0;
	var checkboxs = document.getElementsByName("ordersn");
	
	
	
	var linestr = '';
	
    for(var i=0;i<checkboxs.length;i++){

		if(checkboxs[i].checked == true){
			bill = bill + ","+checkboxs[i].value;
			
			
			var sku  = document.getElementById("sku"+checkboxs[i].value).value;
			var goods_count  = document.getElementById("goods_count"+checkboxs[i].value).value;
			
			linestr		+= 'SKU: '+sku+' 本次入库数量为:'+goods_count+" \n\r";
			
			
			g++;
		}	
	}
	if(bill == ""){
		alert("请选择订单号");
		return false;
	}
	
	
	
	if(confirm("您确认下列sku和数量吗，生成出库单吗? \n\r"+linestr)){
	
	
	
	
	
	}else{
	
	
	
	return false;
	
	}
	
	
	
	
	
	}
</script>