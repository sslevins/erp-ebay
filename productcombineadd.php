<?php
include "include/config.php";
include "top.php";	
	/* 修改客户地址 */
	$sid	= $_REQUEST['storeid'];

	if($_POST['submit']){
	
		$goods_sn		 		= str_rep($_POST['goods_sn']);
		$goods_sncombine	= str_rep($_POST['goods_sncombine']);
		$notes				= str_rep($_POST['notes']);
		$ebay_packingmaterial				= str_rep($_POST['ebay_packingmaterial']);
		
		$addstatus 			= 0;
		
	
		if($sid == ""){
		
		$sql		=  "INSERT INTO `ebay_productscombine` (`goods_sn` ,`goods_sncombine` ,`notes` ,";
		$sql		.= "`ebay_user`,`ebay_packingmaterial`)VALUES ( '$goods_sn', '$goods_sncombine', '$notes', '$user','$ebay_packingmaterial')";
		
		$ss			= "select * from ebay_productscombine where goods_sn = '$goods_sn' and ebay_user = '$user'";
		$ss 		= $dbcon->execute($ss);
		$ss			= $dbcon->getResultArray($ss);
		if(count($ss) >0 ){
			$addstatus	= 1;
		}
		
		
		$ss			= "select * from ebay_goods where goods_sn = '$goods_sn' and ebay_user = '$user'";
		$ss 		= $dbcon->execute($ss);
		$ss			= $dbcon->getResultArray($ss);
		if(count($ss) >0 ){
			$addstatus	= 1;
		}
		
		}else{
		
			
		$sql		= "UPDATE `ebay_productscombine` SET `goods_sn` = '$goods_sn',`goods_sncombine` = '$goods_sncombine',`notes` = '$notes',ebay_packingmaterial='$ebay_packingmaterial' ";
		$sql	   .= " WHERE `id` =$sid ";
		
		}

	
		if($addstatus == 0){
		if($dbcon->execute($sql)){
			
			
			$status	= " -[<font color='#33CC33'>操作记录: 保存成功</font>]";
			
		}else{

			$status = " -[<font color='#FF0000'>操作记录: 保存失败</font>]";
			
		}
		}else{
			$status = " -[<font color='#FF0000'>操作记录: 保存失败,产品编号已存在</font>]";
		}
		
	
	}
	

	
	
	
	$sql		= "select * from ebay_productscombine where id='$sid'";	
	
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
                <td class="login_txt_bt">&nbsp;</td>
              </tr>
                    <tr>
                      <td valign="top" class="left_txt">
                      <?php
					  	
				
							$goods_sncombine				= $sql[0]['goods_sncombine'];
							$goods_sn						= $sql[0]['goods_sn'];
							$notes							= $sql[0]['notes'];
						$ebay_packingmaterial							= $sql[0]['ebay_packingmaterial'];
						
							
						   
						   
					  ?>
                      &nbsp;<br>
                      <form id="ad" name="ad" method="post" action="productcombineadd.php?storeid=<?php echo $sid;?>&module=warehouse&action=货品资料添加">
                      <input type="hidden" value="<?php echo $_REQUEST['type'];?>" name="type" />
                      
                      <table width="89%" border="0" cellpadding="0" cellspacing="0" class="login_txt">
                        <tr>
                          <td width="13%">产品编号</td>
                          <td width="41%"><input name="goods_sn" type="text" id="goods_sn" value="<?php echo $goods_sn;?>"></td>
                          <td width="11%">&nbsp;</td>
                          <td width="35%">&nbsp;</td>
                        </tr>
                        <tr>
                          <td>组合产品</td>
                          <td><textarea name="goods_sncombine" cols="50" rows="5" id="goods_sncombine"><?php echo $goods_sncombine; ?></textarea></td>
                          <td colspan="2">如产品A有产品B，5个和产品D1个组成，请填写<br />
                            B*5,D*1，每个产品编号之间用逗号分隔。</td>
                        </tr>
                        <tr>
                          <td>备注</td> 
                          <td><input name="notes" type="text" id="notes" value="<?php echo $notes;?>"></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>包装型号</td>
                          <td><select name="ebay_packingmaterial" id ="ebay_packingmaterial">
                            <option value="">Please Select</option>
                            <?php
							$tsql		= "select model from ebay_packingmaterial where ebay_user='$user'";
							$tsql		= $dbcon->execute($tsql);
							$tsql		= $dbcon->getResultArray($tsql);
							for($i=0;$i<count($tsql);$i++){
								$models	= $tsql[$i]['model'];								
							?>
                            <option value="<?php echo $models;?>"  <?php if($models == $ebay_packingmaterial) echo "selected=\"selected\""?>><?php echo $models; ?></option>
                            <?php
							}
							?>
                          </select></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td><input name="submit" type="submit" value="保存" /></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td colspan="2">&nbsp;</td>
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