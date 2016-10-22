<?php
include "include/config.php";


include "top.php";




	

	
	$id		= $_REQUEST["id"];

	
	if($_POST['submit']){
		
			$firstweight		= $_POST['firstweight'];
			$names		= $_POST['names'];
			$value		= $_POST['value'];
			
			$ebay_account			= $_POST['ebay_account'];
			$weightmin				= $_POST['weightmin'];
			$weightmax				= $_POST['weightmax'];
			$weighebay_country		= $_POST['weighebay_country'];
			$Priority			= $_POST['Priority'];
			$encounts			= $_POST['encounts'];
			$carrier_sn		= $_POST['carrier_sn'];
			$country		= $_POST['country'];
			$province		= $_POST['province'];
			$city			= $_POST['city'];
			$username		= $_POST['username'];
			$tel			= $_POST['tel'];
			$street			= $_POST['street'];
			$address			= $_POST['address'];
			
			$handlefee		= $_POST['handlefee'];
			$kg				= $_POST['kg'];
			$signature				= $_POST['signature'];
			$note									= $_POST['note'];
			$max									= $_POST['max'];
			$min									= $_POST['min'];
			$ebay_country							= $_POST['ebay_country'];
			$skus									= $_POST['skus'];
			$orderstatus							= $_POST['orderstatus'];
			$ebay_warehouse							= $_POST['ebay_warehouse'];
			if($id == ""){
			
			
			$sql	= "insert into ebay_carrier(name,value,ebay_user,country,province,city,username,tel,street,address,carrier_sn,handlefee,kg,signature,max,min,ebay_country,note,firstweight,ebay_account,weightmin,weightmax,weighebay_country,Priority,encounts,skus,orderstatus,ebay_warehouse) values('$names','$value','$user','$country','$province','$city','$username','$tel','$street','$address','$carrier_sn','$handlefee','$kg','$signature','$max','$min','$ebay_country','$note','$firstweight','$ebay_account','$weightmin','$weightmax','$weighebay_country','$Priority','$encounts','$skus','$orderstatus','$ebay_warehouse')";
			}else{
			
			$sql	= "update ebay_carrier set name='$names',value='$value',country='$country',province='$province',city='$city',username='$username',tel='$tel',street='$street',address='$address',carrier_sn='$carrier_sn',handlefee='$handlefee',kg='$kg',signature='$signature',max='$max',min='$min',ebay_country='$ebay_country',note='$note',firstweight ='$firstweight',ebay_account='$ebay_account',weightmin='$weightmin',weightmax='$weightmax',weighebay_country='$weighebay_country',Priority='$Priority',encounts='$encounts',skus='$skus',orderstatus='$orderstatus',ebay_warehouse='$ebay_warehouse' where id=$id";
			}

	
			if($dbcon->execute($sql)){
			
			$status	= " -[<font color='#33CC33'>操作记录: 数据保存成功</font>]";
		
			
		}else{
		
			$status = " -[<font color='#FF0000'>操作记录: 数据保存失败</font>]";
		}
		
			
		
	}
	
	
	if($id	!= ""){
	
		
		$sql = "select * from ebay_carrier where id=$id";
		$sql = $dbcon->execute($sql);
		$sql = $dbcon->getResultArray($sql);
					
		$names  	= $sql[0]['name'];
		$value 		= $sql[0]['value'];
		$Priority 		= $sql[0]['Priority'];
		$ebay_account 			= $sql[0]['ebay_account'];
		$weightmax 			= $sql[0]['weightmax'];
		$weighebay_country 			= $sql[0]['weighebay_country'];
		$weightmin 			= $sql[0]['weightmin'];
		$encounts 			= $sql[0]['encounts'];
		$country 			= $sql[0]['country'];
		$province			= $sql[0]['province'];
		$city 				= $sql[0]['city'];
		$username 			= $sql[0]['username'];
		$tel	 			= $sql[0]['tel'];
		$street 			= $sql[0]['street'];
		$address 			= $sql[0]['address'];
		$carrier_sn 			= $sql[0]['carrier_sn'];
		$handlefee 				= $sql[0]['handlefee'];
		$kg		 				= $sql[0]['kg'];
		$signature		 		= $sql[0]['signature'];
		$firstweight			 		= $sql[0]['firstweight'];
		$max			 		= $sql[0]['max'];
		$min		 			= $sql[0]['min'];
		$ebay_country		 	= $sql[0]['ebay_country'];
		$note				 	= $sql[0]['note'];
		
		$skus						 	= $sql[0]['skus'];
		$orderstatus				 	= $sql[0]['orderstatus'];
		$ebay_warehouse				 	= $sql[0]['ebay_warehouse'];
		
	}
	
	
	


?>

<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status;?></h2>
</div>
 
<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 <input name="hiddenuserid" type="hidden" value="" id="hiddenuserid" />
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
		
	<td nowrap="nowrap" scope="row" >&nbsp;</td>
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
                      <form id="form" name="form" method="post" action="systemcarrieradd.php?module=system&action=运送方式设置">
                  <table width="90%" border="0" cellpadding="0" cellspacing="0">
                <input name="id" type="hidden" value="<?php echo $id;?>">
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">管理帐号:</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><textarea name="ebay_account" cols="70" rows="5" id="ebay_account"><?php echo $ebay_account;?></textarea>
			          <br />
			          在最后面需要加是英文,号结束</td>
			        </tr>
			      <tr>
                    <td width="41%" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right"><span style="white-space: nowrap;">发货方式名称	 </span>:</div></td>
                    <td width="3%" align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
                    <td width="56%" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
                      <input name="names" type="text" id="names" value="<?php echo $names;?>">
                    </div></td>
                    </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right"><span style="white-space: nowrap;">对应导出值:</span></div></td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="value" type="text" id="value" size="50" value="<?php echo $value;?>">
			          上传到eBay的运送方式</div></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">首重</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><input name="firstweight" type="text" id="firstweight" value="<?php echo $firstweight;?>" /></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">每KG多少钱</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><input name="kg" type="text" id="kg" value="<?php echo $kg;?>" /></td>
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
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">处理费</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><input name="handlefee" type="text" id="handlefee" value="<?php echo $handlefee;?>" /></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">联系人国家</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="country" type="text" id="country" value="<?php echo $country;?>" />
			        </div></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">联系人省份</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="province" type="text" id="province" value="<?php echo $province;?>" />
			        </div></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">联系人城市</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="city" type="text" id="city" value="<?php echo $city;?>" />
			        </div></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">联系人姓名</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="username" type="text" id="username" value="<?php echo $username;?>" />
			        </div></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">联系人电话</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="tel" type="text" id="tel" value="<?php echo $tel;?>" />
			        </div></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">联系人街道</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="street" type="text" id="street" value="<?php echo $street;?>" />
			        </div></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">回邮地址</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <textarea name="address" cols="70" rows="5" id="address"><?php echo $address;?></textarea>
			        </div></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">物流公司代号</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="carrier_sn" type="text" id="carrier_sn" value="<?php echo $carrier_sn;?>" />
			          </div></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">签名</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><input name="signature" type="text" id="signature" value="<?php echo $signature;?>" /></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">金额：</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><input name="min" type="text" id="min" value="<?php echo $min;?>" />
			        ~
			          <input name="max" type="text" id="max"  value="<?php echo $max;?>" />			          ~ 
		               
		              选择<?php echo $name;?> 并国家是:
		              <select name="ebay_country" id="ebay_country">
		                <option value="" <?php if($ebay_country == '') echo 'selected="selected"';?> >请选择</option>
                         <option value="0" <?php if($ebay_country == '0') echo 'selected="selected"';?>>美国</option>
                          <option value="1" <?php if($ebay_country == '1') echo 'selected="selected"';?>>非美国</option>
		              </select></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">重量：</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><input name="weightmin" type="text" id="weightmin" value="<?php echo $weightmin;?>" />
~
  <input name="weightmax" type="text" id="weightmax"  value="<?php echo $weightmax;?>" />
~ 
		               
		              选择<?php echo $name;?> 并国家是:
                      <select name="weighebay_country" id="weighebay_country">
                        <option value="" <?php if($weighebay_country == '') echo 'selected="selected"';?> >请选择</option>
                        <option value="0" <?php if($weighebay_country == '0') echo 'selected="selected"';?>>美国</option>
                        <option value="1" <?php if($weighebay_country == '1') echo 'selected="selected"';?>>非美国</option>
                      </select></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">备注：</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><input name="note" type="text" id="note" value="<?php echo $note;?>" /></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">优先级</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><input name="Priority" type="text" id="Priority" value="<?php echo $Priority;?>" />
			          如果选择1,则是最高优先级</td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">包含国家</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><textarea name="encounts" cols="70" rows="5" id="encounts"><?php echo $encounts;?></textarea>
			          请使用英文逗号分隔</td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">包含SKU</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><textarea name="skus" cols="70" rows="5" id="skus"><?php echo $skus;?></textarea></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">选择分类</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><select name="orderstatus" id="orderstatus">
                      <option value="1" <?php  if($orderstatus == "1")  echo "selected=selected" ?>>待处理订单</option>
                      <option value="2" <?php  if($orderstatus == "2")  echo "selected=selected" ?>>已经发货</option>
                      <?php
                            $ss		= "select * from ebay_topmenu where ebay_user='$user' and name != '' order by ordernumber";
							$ss		= $dbcon->execute($ss);
							$ss		= $dbcon->getResultArray($ss);
							for($i=0;$i<count($ss);$i++){
								$ssid		= $ss[$i]['id'];
								$ssname		= $ss[$i]['name'];
							?>
                      <option value="<?php echo $ssid; ?>" <?php  if($orderstatus == $ssid)  echo "selected=selected" ?>><?php echo $ssname; ?></option>
                      <?php } ?>
                
                    </select></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">对应仓库</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><select name="ebay_warehouse" id="ebay_warehouse">
                      <option value="">未设置</option>
                      <?php 

							

							$sql = "select * from  ebay_store where ebay_user='$user'";									
							$sql = $dbcon->execute($sql);
							$sql = $dbcon->getResultArray($sql);
				

							for($i=0;$i<count($sql);$i++){

						

								$iid					= $sql[$i]['id'];

								$store_name			= $sql[$i]['store_name'];

								$goods_sku			= $sql[$i]['goods_sku'];	

								$goods_sx			= $sql[$i]['goods_sx'];	

								$goods_xx			= $sql[$i]['goods_xx'];	

						

							

							?>
                      <option value="<?php echo $iid;?>" <?php if($iid ==$ebay_warehouse) echo "selected=selected";?>><?php echo $store_name; ?></option>
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
