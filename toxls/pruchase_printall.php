<?php
include "../include/config.php";

$orderid		= substr($_REQUEST['bill'],1);
$partners		= $_REQUEST['partner'];
$purchaseuser		= $_REQUEST['purchaseuser'];
$show			= $_REQUEST['show']?substr($_REQUEST['show'],1):'1,1,1,1,1,1,1';
$shows = explode(',',$show);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<body>
<table width="70%" border="0" align="center" cellpadding="3" cellspacing="1">  
<tr><td><input type='checkbox' value='1' name='partner' id='partner' onclick="fenzu();" <?php if($partners) echo "checked='checked'"?>/>按供应商分组 &nbsp;&nbsp;<input type='checkbox' value='1' name='purchaseuser' id='purchaseuser' onclick="fenzu();" <?php if($purchaseuser) echo "checked='checked'"?>/>按负责人分组 &nbsp;&nbsp;<a href="#" onclick="show()">显示设置</a>
<div id='showbox' style='height:30px;line-height:30px; width:100%; border:1px solid #000000; display:none'>
<input type='checkbox' value='1' name='shows'  <?php if($shows[0]) echo "checked='checked'";?>/>序号
<input type='checkbox' value='1' name='shows'  <?php if($shows[1]) echo "checked='checked'";?>/>产品编号
<input type='checkbox' value='1' name='shows'  <?php if($shows[2]) echo "checked='checked'";?>/>图片
<input type='checkbox' value='1' name='shows'  <?php if($shows[3]) echo "checked='checked'";?>/>产品名称
<input type='checkbox' value='1' name='shows'  <?php if($shows[4]) echo "checked='checked'";?>/>产品单位
<input type='checkbox' value='1' name='shows'  <?php if($shows[5]) echo "checked='checked'";?>/>采购单价
<input type='checkbox' value='1' name='shows'  <?php if($shows[6]) echo "checked='checked'";?>/>采购数量
<input type='button' value='确定' onclick='submitshow()'/>
</div>
</td></tr>
<?php


$sql			= "select io_partner,io_purchaseuser from  ebay_iostore where id in ($orderid)";
 if($partners && $purchaseuser){
	$sql .= " group by io_partner,io_purchaseuser ";
}elseif($purchaseuser && $partners!='1'){
	$sql .= " group by io_purchaseuser ";
}elseif($purchaseuser!='1' && $partners){
	$sql .= " group by io_partner ";
}else{
	$sql .= " limit 0,1";
}

$sql			= $dbcon->execute($sql);
$sql			= $dbcon->getResultArray($sql);
foreach($sql as $k=>$v){
if($partners){
	if($purchaseuser){
		echo "<tr><td> 供应商：".$v['io_partner']." &nbsp;&nbsp; 采购人员：".$v['io_purchaseuser']."</td></tr>";
	}else{
		echo "<tr><td> 供应商：".$v['io_partner']." &nbsp;&nbsp;</td></tr>";
	}
}else{
	if($purchaseuser){
		echo "<tr><td> 采购人员：".$v['io_purchaseuser']."</td></tr>";
	}
}
$a = 0;
?>
	<tr>
    <td><table width="100%" border="1" cellspacing="1" cellpadding="3">
      <tr>
       <?php if($shows[0]){?> <td>序号</td>
	   <?php } ?>
	   <?php if($shows[1]){?>
        <td>产品编号</td>
		<?php } ?>
	   <?php if($shows[2]){?>
        <td>图片</td>
		<?php } ?>
	   <?php if($shows[3]){?>
        <td>产品名称</td>
		<?php } ?>
	   <?php if($shows[4]){?>
        <td>产品单位</td>
		<?php } ?>
	   <?php if($shows[5]){?>
        <td>采购单价</td>
		<?php } ?>
	   <?php if($shows[6]){?>
        <td>采购数量</td>
		<?php } ?>
        </tr>
      
         <?php
		 $sss			= "select * from  ebay_iostore where id in ($orderid) ";
		 if($partners){
			$sss .= " and io_partner = '".$v['io_partner']."'";
		 }
		 if($purchaseuser){
			$sss .= " and io_purchaseuser = '".$v['io_purchaseuser']."'";
		 }
		// echo $sss;
		 $sss			= $dbcon->execute($sss);
		 $sss			= $dbcon->getResultArray($sss);
		 foreach($sss as $kk=>$vv){
			$in_warehouse	= $vv['io_warehouse'];
			$note			= $vv['io_note'];
			$iistatus		=  $vv['io_status'];
			$type		=  $vv['type'];
			$io_addtime		=  $vv['io_addtime'];
			$partner		=  $vv['io_partner'];
			$ordersn		=  $vv['io_ordersn'];


			$ss				= "select * from ebay_store where id='$in_warehouse'";
			$ss				= $dbcon->execute($ss);
			$ss				= $dbcon->getResultArray($ss);
			$warehousename	= $ss[0]['store_name'];


			$ss				= "select * from ebay_storetype where id='$in_type'";


			$ss				= $dbcon->execute($ss);
			$ss				= $dbcon->getResultArray($ss);
			$iotype			= $ss[0]['ebay_storename'];
			
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
				
				$goods_pic	= $vv[0]['goods_pic']?$vv[0]['goods_pic']:$goods_sn.'.jpg';
				
				
				$pertotal			= $goods_count * $goods_price;
				$totalproductscount	+=$goods_count;
				$totalproductsprice	+=$pertotal;
				
		?>
                        
                        
                        
      <tr>
	   <?php if($shows[0]){?>
        <td><?php echo $a+1;?>&nbsp;</td>
	 <?php } ?>
	   <?php if($shows[1]){?>
        <td><?php echo $goods_sn;?></td>
	 <?php } ?>
	   <?php if($shows[2]){?>
        <td><img src="../images/<?php echo $goods_pic; ?>" width="50" height="50" />&nbsp;</td>
	 <?php } ?>
	   <?php if($shows[3]){?>
        <td><?php echo $goods_name;?>&nbsp;</td>
	 <?php } ?>
	   <?php if($shows[4]){?>
        <td><?php echo $goods_unit; ?>&nbsp;</td>
	 <?php } ?>
	   <?php if($shows[5]){?>
        <td><?php echo $goods_price; ?>&nbsp;</td>
	 <?php } ?>
	   <?php if($shows[6]){?>
        <td><?php echo $goods_count; ?>&nbsp;</td>
	 <?php } ?>
        </tr>

      
      
      <?php
	  $a++;
	  }
	}
?>
    </table></td>
  </tr>
<?php

}
?>
  <tr>
    <td>打印日间:<?php echo date('Y-m-d H:i:s'); ?></td>
  </tr>
</table>
</body>
</html>
<script>
function fenzu(){
	var partner = document.getElementById('partner').checked;
	var purchaseuser = document.getElementById('purchaseuser').checked;
	if(partner){
		var pa = 1;
	}else{
		var pa = 0;
	}
	if(purchaseuser){
		var pu = 1;
	}else{
		var pu = 0;
	}
	var url = "?bill=,<?php echo $orderid?>&partner="+pa+"&purchaseuser="+pu+"&show=,<?php echo $show;?>";
	location.href	= url;
}
function show(){
	document.getElementById('showbox').style.display='';
}
function submitshow(){
	var bill = '';
	var checkboxs = document.getElementsByName("shows");
	for(var i=0;i<checkboxs.length;i++){
		if(checkboxs[i].checked == false){
			bill = bill + ",0";
		}else{
			bill = bill + ",1";
		}	
	}
	var url = "?bill=,<?php echo $orderid?>&partner=<?php echo $partner;?>&purchaseuser=<?php echo $purchaseuser?>&show="+bill;
	location.href	= url;
}
</script>