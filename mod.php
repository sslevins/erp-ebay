<?php
include "include/config.php";


include "top2.php";	


$ordersn	= explode(",",$_REQUEST['bill']);
$totalcount	= count($ordersn)-1;
$ostatus	= $_REQUEST['ostatus'];
$Shipping	= $_REQUEST['Shipping'];
if($_REQUEST['bill'] == ''){
	
	$sql			= "select ebay_id from ebay_order as a  where a.ebay_carrier='$Shipping' and a.ebay_status='$ostatus' and a.ebay_combine!='1' and ($ebayacc) ";
	$sql			= $dbcon->execute($sql);
	$sql			= $dbcon->getResultArray($sql);
	$totalcount		= count($sql);
	
}

$status	    = "";



	
	if($_POST['submit']){
	
			
			$f_sku					= $_POST['f_sku']?$_POST['f_sku']:0;
			$f_status				= $_POST['f_status']?$_POST['f_status']:0;
			$f_style				= $_POST['f_style']?$_POST['f_style']:0;
			$f_ebaywarehouse		= $_POST['f_ebaywarehouse']?$_POST['f_ebaywarehouse']:0;
			
			
			$sku					= $_POST['sku']?$_POST['sku']:0;
			$status					= $_POST['status']?$_POST['status']:0;
			$style					= $_POST['style']?$_POST['style']:0;
			$ebay_warehouse				= $_POST['ebay_warehouse'];
			

			if($_REQUEST['bill'] != ''){
			for($i=0;$i<count($ordersn);$i++){
			
					
						$osn		= $ordersn[$i];
						if($osn		 != ''){
							$sql2		= "update ebay_order set is_reg='0' ";
							if($f_style == '1'){
								$sql2	.= ",ebay_carrier='$style' ";
								
								$ebay_id			= $osn;
								$notes				= '订单修改了，运输方式['.$style.']，修改人是:'.$truename;
								addordernote($ebay_id,$notes);
								
								
								
							}
							if($f_status == '1'){
							
							
								/* 检查对应的sku, 在货品资料中是否能查找到，只针对  test 用户 */
								if($user =='test'  ){
								$vv		= "select ebay_ordersn from ebay_order where ebay_id ='$osn'";
								$vv		= $dbcon->execute($vv);
								$vv		= $dbcon->getResultArray($vv);
								
								$ebay_ordersn	= $vv[0]['ebay_ordersn'];
								$vv		= "select sku from ebay_orderdetail where ebay_ordersn ='$ebay_ordersn'";
								$vv		= $dbcon->execute($vv);
								$vv		= $dbcon->getResultArray($vv);
								$goodsisexit	= 0;
								for($j=0;$j<count($vv);$j++){
									$sku		= $vv[$j]['sku'];
									$cc			= "select * from ebay_goods where goods_sn='$sku' and ebay_user ='$user' ";
									
									$cc		= $dbcon->execute($cc);
									$cc		= $dbcon->getResultArray($cc);
									if(count($cc) <=  0 ){
										$goodsisexit	= 1;
										
										
										echo '<br>订单编号: '.$osn.' sku:'.$sku.' 匹配不成功，不能修改状态';
										
									}
								}
								
								
								
								if ( $goodsisexit == 0 ) $sql2	.= ",ebay_status='$status' ";
								
								}else{
								
								$sql2	.= ",ebay_status='$status' ";
								
								}
								
								
								$ebay_id			= $osn;
								$porderstatus		= GetOrderStatusV2($ebay_id); /* 取得订单修改之前的状态 */
								$porderstatusf		= GetOrderStatusV2f($status);  // 取得修改后订单的状态
								if($porderstatus != $porderstatusf){
								$notes				= '订单修改之前的状态是:['.$porderstatus.'] 订单修改后的状态是: ['.$porderstatusf.'] 修改人是:'.$truename;
								addordernote($ebay_id,$notes);
								}
								
							}
						
							if($f_ebaywarehouse == '1'){
							$sql2	.= ",ebay_warehouse='$ebay_warehouse' ";
							}
							
							
							$sql2		.= " where ebay_id='$osn' and ebay_user ='$user' ";
							
						
						if($dbcon->execute($sql2)){
						$status0			= " -[<font color='#33CC33'>操作记录: 操作成功</font>]";							
						}else{
						echo 'faiure';
						}
						
						
						}
						
						
					}
			}
			
			}else{
					
					
					
					$sql			= "select * from ebay_order as a   where a.ebay_carrier='$Shipping' and a.ebay_status='$ostatus' and a.ebay_combine!='1' and ($ebayacc) ";
					$sql			= $dbcon->execute($sql);
					$sql			= $dbcon->getResultArray($sql);
							
					for($i=0;$i<count($sql);$i++){
						
							
							$osn		= $sql[$i]['ebay_id'];
							
							if($osn		 != ''){
							$sql2		= "update ebay_order set is_reg='0' ";
						
						
							if($f_style == '1'){
								$sql2	.= ",ebay_carrier='$style' ";
							}
							if($f_status == '1'){
								$sql2	.= ",ebay_status='$status' ";
							}
							$sql2		.= " where ebay_id='$osn'";
							
							
							if($dbcon->execute($sql2)){
							$status0			= " -[<font color='#33CC33'>操作记录: 操作成功</font>]";							
							}else{
							echo 'faiure';
							}
							}
					
					}
			
			
			
			
			}
			

?>

<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status0;?></h2>
</div>
 
<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 <input name="hiddenuserid" type="hidden" value="" id="hiddenuserid" />
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
		
	<td nowrap="nowrap" scope="row" >批量修改：您已经选择了<?php echo $totalcount;?>条记录，请在需要批量修改的地方输入新值</td>
	</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td width="26%">
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'>			
                      <form id="form" name="form" method="post" action="mod.php?module=orders&bill=<?php echo $_REQUEST['bill']; ?>&ostatus=<?php echo $ostatus;?>&Shipping=<?php echo $Shipping;?>">
                  <table width="70%" border="0" cellpadding="0" cellspacing="0">
                <input name="id" type="hidden" value="<?php echo $id;?>">
			      
			      <tr>
			        <td width="40%" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right"><span style="white-space: nowrap;">
			          <input name="f_status" type="checkbox" value="1" id="f_status">	
			        </span></div></td>
			        <td width="10%" align="right" bgcolor="#f2f2f2" class="left_txt">订单状态</td>
			        <td width="50%" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <select name="status" id="status">
                            <option value="" <?php if($oost == "-1") echo "selected=selected" ?>>请选择</option>
							<option value="0" <?php  if($oost == "0")  echo "selected=selected" ?>>未付款订单</option>
                            <option value="1" <?php  if($oost == "1")  echo "selected=selected" ?>>待处理订单</option>
                           
                            <?php


							$ss		= "select * from ebay_topmenu where ebay_user='$user' and name != '' order by ordernumber";

							$ss		= $dbcon->execute($ss);

							$ss		= $dbcon->getResultArray($ss);

							for($i=0;$i<count($ss);$i++){

							

								$ssid		= $ss[$i]['id'];
								$ssname		= $ss[$i]['name'];
								
								
						

							?>

                            

                            <option value="<?php echo $ssid; ?>" <?php  if($oost == $ssid)  echo "selected=selected" ?>><?php echo $ssname; ?></option>

                            

                            <?php } ?> 
                             <option value="2" <?php  if($oost == '2')  echo "selected=selected" ?>>已经发货</option>
                      </select>
			        </div></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><span style="white-space: nowrap;">
			          <input name="f_style" type="checkbox" value="1" id="f_style" />
			        </span></td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">发货方式</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <select name="style" id="style">
                        <option value="" >请选择</option>
                        <?php
						   	
							$tql	= "select * from ebay_carrier where ebay_user = '$user'";
							$tql	= $dbcon->execute($tql);
							$tql	= $dbcon->getResultArray($tql);
							for($i=0;$i<count($tql);$i++){
							
							$tname		= $tql[$i]['name'];
							$tvalue		= $tql[$i]['value'];
							
						   
						   ?>
                        <option value="<?php echo $tname;?>"  <?php if($tname == $ebay_carrier) echo "selected=selected" ?>><?php echo $tname;?></option>
                        <?php
						   }
						   
						   
						   ?>
                      </select>
			        </div></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><span style="white-space: nowrap;">
			          <input name="f_ebaywarehouse" type="checkbox" value="1" id="f_ebaywarehouse" />
			        </span></td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">出库仓库</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><select name="ebay_warehouse" id="ebay_warehouse">
                      <option value="">未设置</option>
                      <?php 
							$sql = "select * from  ebay_store where ebay_user='$user'";									
							$sql = $dbcon->execute($sql);
							$sql = $dbcon->getResultArray($sql);
							for($i=0;$i<count($sql);$i++){
								$iid					= $sql[$i]['id'];
								$store_name			= $sql[$i]['store_name'];
						
							?>
                      <option value="<?php echo $iid;?>" ><?php echo $store_name; ?></option>
                      <?php
							}
							?>
                    </select></td>
			        </tr>
			      
			      
			      
			      
			      
                  <tr>				 
                    <td align="right" class="left_txt"><div align="right"></div></td>
                    <td align="right" class="left_txt">&nbsp;</td>
                    <td align="right" class="left_txt"><div align="left">
                      <input name="submit" type="submit" value="保存数据" onClick="return check()">
                    </div></td>
                    </tr>
                </table>
                 </form> 
               </td>
               
	    </tr>
			</table>		</td>
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
    <script language="javascript">
	
	function check(){
	
		
		var f_status			= document.getElementById('f_status').checked;
		var f_style				= document.getElementById('f_style').checked;
		var f_ebaywarehouse		= document.getElementById('f_ebaywarehouse').checked;
		
		if(f_status == true){
			var status			= document.getElementById('status').value;
			if(status == ''){
				alert('请选择要转移到哪个订单分类');
				return false;
			}
		}
		
		if(f_style == true){
			var style			= document.getElementById('style').value;
			if(style == ''){
				alert('请选择要修改的运输方式');
				return false;
			}
		}
		
		if(f_ebaywarehouse == true){
			var ebay_warehouse			= document.getElementById('ebay_warehouse').value;
			if(ebay_warehouse == ''){
				alert('请选择要批量修改的仓库');
				return false;
			}
		}
		
		
			
	
	
	} 
	
	
	
	
	</script>
