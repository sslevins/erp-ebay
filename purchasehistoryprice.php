<?php
include "include/config.php";



$goods_sn	= $_REQUEST['goods_sn'];



	
	
 ?>
 <link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/yui.css" />

<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/deprecated.css" />

<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/style.css" /> 

        <table style="width:100%"><tr>
          <td></form>
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='6'>&nbsp;</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>产品编号</div></th>
			
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>产品名称</div>			</th>
			
		<th scope='col' nowrap="nowrap">产品进货成本&nbsp;</th>
					<th scope='col' nowrap="nowrap">进货数量</th>
					<th scope='col' nowrap="nowrap">单据添加日期</th>
		            <th scope='col' nowrap="nowrap">单据审核日期</th>
        </tr>
		


			  <?php
			  	
				
			
				$sql		= "select * from ebay_iostore as a join ebay_iostoredetail as b on a.io_ordersn = b.io_ordersn where a.ebay_user='$user' and b.goods_sn ='$goods_sn' and b.goods_cost != '' and a.type != '1' order by a.id desc ";
				
				
				$query		= $dbcon->query($sql);
				$total		= $dbcon->num_rows($query);
				
				$pageindex  =( isset($_GET['pageindex']) )?$_GET['pageindex']:1;
				$limit = " limit ".($pageindex-1)*$pagesize.",$pagesize";
		
				
				$page=new page(array('total'=>$total,'perpage'=>$pagesize));
				$sql = $sql.$limit;
				$sql		= $dbcon->execute($sql);
				$sql		= $dbcon->getResultArray($sql);
			
				
				for($i=0;$i<count($sql);$i++){
					
					$goods_sn			= $sql[$i]['goods_sn'];
					$goods_name			= $sql[$i]['goods_name'];	
					$goods_cost			= $sql[$i]['goods_cost'];
					$goods_count			= $sql[$i]['goods_count'];
					
					$io_addtime			= $sql[$i]['io_addtime'];
					if($io_addtime != '') $io_addtime	= date('Y-m-d H:i:s',$io_addtime);
					
					$io_audittime		= $sql[$i]['io_audittime'];
					if($io_audittime != '' && $io_audittime != '0') $io_audittime	= date('Y-m-d H:i:s',$io_audittime);
					
					
					
					
					
			  ?>
              
              
                  
         		<tr height='20' class='oddListRowS1'>
						<td scope='row' align='left' valign="top" >
						  <?php echo $goods_sn; ?>                            </td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $goods_name;?></td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $goods_cost;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $goods_count;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $io_addtime; ?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" >
                          <?php echo $io_audittime; ?>
                            
                  &nbsp;</td>
      </tr>
              


 
               <?php } ?>
		<tr class='pagination'>
		<td colspan='6'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'>&nbsp;</td>
					</tr>
			</table>		</td>
	</tr></table>


<?php

include "bottom.php";


?>
<script language="javascript">


function edits(itemid,tsku,tname,price)
{


qty	=	1;
window.opener.titemid.value = itemid;
window.opener.tsku.value 	= tsku;
window.opener.tname.value = tname;
window.opener.tprice.value = price;
window.opener.tqty.value = qty;



	
	
   
   
}




		function searchorder(){
	
		

		var content		 	= document.getElementById('keys').value;
		var goodscategory 	= document.getElementById('goodscategory').value;	
		var warehouse 	= document.getElementById('warehouse').value;	
		
		
		
		location.href= 'productslist.php?keys='+encodeURIComponent(content)+"&goodscategory="+goodscategory+"&module=warehouse&action=货品资料管理&warehouse="+warehouse;
		
	}
	





</script>