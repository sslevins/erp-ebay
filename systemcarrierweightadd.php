<?php
include "include/config.php";


include "top.php";


	$id				= $_REQUEST['id'];
	$shippingid				= $_REQUEST['shippingid'];
	
	if($_POST['submit']){
	
		
		$weight		= $_POST['weight'];
		$min		= $_POST['min'];
		$max		= $_POST['max'];
		
		
		if($id == ""){
			
			
			$sql	= "insert into ebay_carrierweight(max,min,weight,shipping_id) values('$max','$min','$weight','$shippingid')";
			}else{
			
			$sql	= "update ebay_carrierweight set max='$max',min='$min',weight='$weight' where id=$id";
			}
			

	
			if($dbcon->execute($sql)){
			
			$status	= " -[<font color='#33CC33'>操作记录: 数据保存成功</font>]";
		
			
		}else{
		
			$status = " -[<font color='#FF0000'>操作记录: 数据保存失败</font>]";
		}
		
		
		if($id == '') $ebay_carrierweight		= mysql_insert_id();
		
		
	
	
	}

		
		
			if($id	!= ""){
	
		
				$sql = "select * from ebay_carrierweight where id=$id";
				$sql = $dbcon->execute($sql);
				$sql = $dbcon->getResultArray($sql);
				$max  		= $sql[0]['max'];
				$min  		= $sql[0]['min'];
				$weight  	= $sql[0]['weight'];
		
		
		
		}
		
 ?>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status;?> </h2>
</div>

<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
    <form id="form" name="form" method="post" action="systemcarrierweightadd.php?module=system&action=<?php echo $_REQUEST['action'];?>&shippingid=<?php echo $shippingid;?>">
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
		
	<td nowrap="nowrap" scope="row" ><table width="90%" border="0" cellpadding="0" cellspacing="0">
  <input name="id" type="hidden" value="<?php echo $id;?>" />
  <tr>
    <td width="41%" align="right" bgcolor="#f2f2f2" class="left_txt">重量区间</td>
    <td width="3%" align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
    <td width="56%" align="left" bgcolor="#f2f2f2" class="left_txt"><input name="min" type="text" id="min" value="<?php echo $min;?>" />
      ~
      <input name="max" type="text" id="max"  value="<?php echo $max;?>" />
      kg</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#f2f2f2" class="left_txt">设置生理为</td>
    <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
    <td align="left" bgcolor="#f2f2f2" class="left_txt"><input name="weight" type="text" id="weight" value="<?php echo $weight;?>" /></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
    <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
    <td align="left" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
    <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
    <td align="left" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" class="left_txt"><div align="right"></div></td>
    <td align="right" class="left_txt">&nbsp;</td>
    <td align="right" class="left_txt"><div align="left">
      <input name="submit" type="submit" value="保存数据" onclick="return check()" />
    </div></td>
  </tr>
</table></td>
	</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>

<div class="clear"></div>
<?php

include "bottom.php";


?>
<script language="javascript">
	
	function del(id){
		if(confirm('您确认删除此条记录吗')){
			
			location.href = 'systemcarrier.php?type=del&id='+id+"&module=system&action=发货方式管理";
			
		
		}
	
	
	}



</script>