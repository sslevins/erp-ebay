<?php
include "include/config.php";
include "top.php";	
	/* 修改客户地址 */
	$pid	= $_REQUEST['pid'];
	$type	= $_REQUEST['type'];
	if($type == "in"){
		
		$dstr				= "入库";
		
		
		}else{
		
		$dstr				= "出库";
	
		
	}
	

	if($_POST['submit']){
	
		$goods_name 		= str_rep($_POST['goods_name']);
		$goods_sn			= str_rep($_POST['goods_sn']);
		$goods_price		= str_rep($_POST['goods_price']);
		$goods_cost			= str_rep($_POST['goods_cost']);
		$goods_count		= str_rep($_POST['goods_count']);
		$goods_unit			= str_rep($_POST['goods_unit']);
		$goods_location		= str_rep($_POST['goods_location']);
		$warehousesx		= str_rep($_POST['warehousesx']);
		$instock		= $_POST['instock']?$_POST['instock']:0;
		
		$sql	= "select * from ebay_goods where goods_sn='$goods_sn'";
		
		
		$sql	= $dbcon->execute($sql);
		$sql  = $dbcon->getResultArray($sql);
		
		
		$goods_category	= $sql[0]['goods_category'];
		$dstr				= "";
		if($type == "in"){
		
		$dstr				= "入库";
		$sq2		 = "update ebay_goods set goods_count=goods_count+$instock where goods_id=$pid";
		
		}else{
		
		$dstr				= "出库";
		$sq2		 = "update ebay_goods set goods_count=goods_count-$instock where goods_id=$pid";
		
		}
	
		$sq			 = "INSERT INTO `ebay_goodshistory` (`addtime` , `goodsid` , `goodsn` , `goodsname` , `stocktype` , `goodsprice` ,";
		$sq			.= "`goodsnumber` , `ebay_user`,`goods_category` ) VALUES ('$nowtime', '$pid', '$goods_sn', '$goods_name', '$dstr', '$goods_price', '$instock', '$user','$goods_category');";
		
		
		
		if($dbcon->execute($sq) && $dbcon->execute($sq2)){
			
			
			$status	= " -[<font color='#33CC33'>操作记录: 保存成功</font>]";
			
		}else{

			$status = " -[<font color='#FF0000'>操作记录: 保存失败</font>]";
			
		}
		
	
	}
	$sql		= "select * from ebay_goods where goods_id='$pid'";	
	$sql		= $dbcon->execute($sql);
	$sql		= $dbcon->getResultArray($sql);	

	
	
	
	
	



 ?>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status;?> </h2>
</div>

<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
<table width="86%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
	
	
	
		
	<td nowrap="nowrap" scope="row" >&nbsp;<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
                <td class="login_txt_bt">输入产品资料：</td>
                    </tr>
                    <tr>
                      <td valign="top" class="left_txt">
                      <?php
					  	
				
							$goods_id		= $sql[0]['goods_id'];
							$goods_sn		= $sql[0]['goods_sn'];
							$goods_name		= $sql[0]['goods_name'];
							$goods_price	= $sql[0]['goods_price'];
							$goods_cost		= $sql[0]['goods_cost'];
							$goods_count	= $sql[0]['goods_count'];
							$goods_unit		= $sql[0]['goods_unit'];
							$goods_location	= $sql[0]['goods_location'];
							$warehousesx 	= $sql[0]['warehousesx'];
							$warehousexx	= $sql[0]['warehousexx'];
							
							
						   
						   
					  ?>
                      &nbsp;<br>
                      <form id="ad" name="ad" method="post" action="productinstock.php?pid=<?php echo $pid;?>&type=<?php echo $type ?>&module=warehouse&action=货品资料添加">
                      <input type="hidden" value="<?php echo $_REQUEST['type'];?>" name="type" />
                      
                      <table width="89%" border="0" cellpadding="0" cellspacing="0" class="login_txt">
                        <tr>
                          <td width="13%">货品编号</td>
                          <td width="41%"><input name="goods_sn" type="text" id="goods_sn" value="<?php echo $goods_sn;?>"></td>
                          <td width="11%">库存上限</td>
                          <td width="35%"><input name="warehousesx" type="text" id="warehousesx" value="<?php echo $warehousesx;?>"></td>
                        </tr>
                        <tr>
                          <td>货品名称</td>
                          <td><input name="goods_name" type="text" id="goods_name" value="<?php echo $goods_name; ?>"></td>
                          <td>库存下限</td>
                          <td><input name="warehousexx" type="text" id="warehousexx" value="<?php echo $warehousexx;?>"></td>
                        </tr>
                        <tr>
                          <td>货品成本</td>
                          <td><input name="goods_cost" type="text" id="goods_cost" value="<?php echo $goods_cost; ?>"></td>
                          <td>类型</td>
                          <td><?php echo $dstr;?></td>
                        </tr>
                        <tr>
                          <td>货品价格</td> 
                          <td><input name="goods_price" type="text" id="goods_price" value="<?php echo $goods_price;?>"></td>
                          <td>数量</td>
                          <td><input name="instock" type="text" id="instock" value="0"></td>
                        </tr>
                        <tr>
                          <td>实际库存</td>
                          <td><input disabled="false" name="goods_count" type="text" id="goods_count" value="<?php echo $goods_count;?>"></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>货品单位</td>
                          <td><input name="goods_unit" type="text" id="goods_unit" value="<?php echo $goods_unit;?>"></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>货位号</td>
                          <td><input name="goods_location" type="text" id="goods_location" value="<?php echo $goods_location;?>"></td>
                          <td colspan="2"><input name="submit" type="submit" value="保存">
                          &nbsp;</td>
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
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td width="65%">&nbsp;</td>
	</tr>
              
              
              

              
		<tr class='pagination'>
		<td>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'></td>
			  </tr>
			</table>		</td>
	</tr></table>


    <div class="clear"></div>
<?php

include "bottom.php";


?>
<script language="javascript">
	
	function del(ordersn,ebayid){
	
	
		
		if(confirm("确认删除此条记录吗")){
			
			location.href="ordermodifive.php?ordersn=<?php echo $ordersn ?>&ebayid=<?php echo $ebayid;?>&type=del&module=orders&action=新增订单";
			
		
		
		}
		
	
	
	}
	
	function mod(ordersn,ebayid){
	
		
		
		
		if(confirm("确认修改此条记录吗")){
			
			
			var pname	 = document.getElementById('pname'+ebayid).value;
			var pprice	 = document.getElementById('pprice'+ebayid).value;
			var pqty	 = document.getElementById('pqty'+ebayid).value;
			var psku	 = document.getElementById('psku'+ebayid).value;
			var pitemid	 = document.getElementById('pitemid'+ebayid).value;
			
			
			if(isNaN(pqty)){
				
				alert("数量只能输入数字");
				
			
			}else if(isNaN(pprice)){
				
				alert("价格只能输入数字");
			
			}else{
			
				location.href="ordermodifive.php?ordersn=<?php echo $ordersn ?>&ebayid="+ebayid+"&type=mod&pname="+encodeURIComponent(pname)+"&pprice="+pprice+"&pqty="+pqty+"&psku="+psku+"&pitemid="+pitemid+"&module=orders&action="+urlencode(新增订单);
			
			}
					
		}
		
	}
	
	function add(ordersn){
	
		
		var tname		= document.getElementById('tname').value;
		var tprice		= document.getElementById('tprice').value;
		var tqty		= document.getElementById('tqty').value;
		var tsku		= document.getElementById('tsku').value;
		var titemid		= document.getElementById('titemid').value;
		
		if(tname == ""){
		
				
				alert("请输入产品名称");
				document.getElementById('tname').select();
				return false;
				
		}
		
		if(isNaN(tprice) || tprice == ""){
				
				alert("数量只能输入数字");
				document.getElementById('tprice').select();
				return false;		
				
			
		}
		
		if(isNaN(tqty)){
				
				alert("价格只能输入数字");
				document.getElementById('tqty').select();
				return false;
			
		}			
		location.href="ordermodifive.php?ordersn=<?php echo $ordersn ?>&type=add&tname="+encodeURIComponent(tname)+"&tprice="+tprice+"&tqty="+tqty+"&tsku="+tsku+"&titemid="+titemid+"&module=orders&action=新增订单";
			
	}
	


</script>