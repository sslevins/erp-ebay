<?php
include "include/config.php";


include "top.php";




	
	
	if($_POST['submit']){
		$feedbackstring						 = mysql_escape_string($_POST['feedbackstring']);			// 订单默认库存
		$storeid							 = $_POST['storeid'];			// 订单默认库存
		$notesorderstatus					 = $_POST['notesorderstatus'];  // 是否是有留言的订单
		$auditcompleteorderstatus			 = $_POST['auditcompleteorderstatus'];  // 是否是有留言的订单
		$scaningorderstatus			 		 = $_POST['scaningorderstatus'];  // 条码核对成功后 转入
		$overweightstatus					 = $_POST['overweightstatus'];  // 超重订单
		$systemprofit						 = $_POST['systemprofit'];			// 订单默认库存
		$days30								 = $_POST['days30'];			// 订单默认库存
		$days15								 = $_POST['days15'];			// 订单默认库存
		$days7								 = $_POST['days7'];			// 订单默认库存
		$hackorer							 = $_POST['hackorer'];			// 订单默认库存
		$overtock							 = $_POST['overtock'];			// 订单默认库存
		$totalprofitstatus					 = $_POST['totalprofitstatus'];			// 订单默认库存
		$onstock							 = $_POST['onstock'];			// 订单默认库存
		$ywpassword							 = $_POST['ywpassword'];
		$ywuserid							 = $_POST['ywuserid'];
		$paypalstatus						 = $_POST['paypalstatus'];
		$allowauditorderstatus				 = $_POST['allowauditorderstatus'];
		$distrubitestock					 = $_POST['distrubitestock'];
		$token4px					 		= $_POST['token4px'];
		$ddbtoken4px					 	= $_POST['ddbtoken4px'];
		$ddbid4px					 		= $_POST['ddbid4px'];
		$overqtys					 		= $_POST['overqtys'];
		
		$ckyuserid					 		= $_POST['ckyuserid'];
		$ckyuserkey					 		= $_POST['ckyuserkey'];
		$ckytoken					 		= $_POST['ckytoken'];
		$takeinventory					 	= $_POST['takeinventory'];
		
		
		$stapikey					 		= $_POST['stapikey'];
		$stapitoken					 		= $_POST['stapitoken'];	
		$stuserID					 		= $_POST['stuserID'];
		$wytuser					 		= $_POST['wytuser'];
		$wytuserpass					 	= $_POST['wytuserpass'];
		
		
		$bluserame					 		= $_POST['bluserame'];
		$blpassword						 	= $_POST['blpassword'];
		
		
		$sql		 = "UPDATE `ebay_config` SET storeid='$storeid',onstock='$onstock',notesorderstatus='$notesorderstatus',auditcompleteorderstatus='$auditcompleteorderstatus',days30='$days30',days15='$days15',days7='$days7',overweightstatus='$overweightstatus',overtock='$overtock',hackorer='$hackorer',totalprofitstatus ='$totalprofitstatus',systemprofit='$systemprofit',feedbackstring='$feedbackstring',scaningorderstatus='$scaningorderstatus',ywuserid='$ywuserid',ywpassword='$ywpassword',paypalstatus='$paypalstatus',allowauditorderstatus='$allowauditorderstatus',overqtys='$overqtys',distrubitestock='$distrubitestock',token4px='$token4px',ddbtoken4px='$ddbtoken4px',ddbid4px='$ddbid4px',ckyuserid='$ckyuserid',ckyuserkey='$ckyuserkey',ckytoken='$ckytoken',takeinventory='$takeinventory',stapikey='$stapikey',stapitoken='$stapitoken',stuserID='$stuserID',wytuser='$wytuser', wytuserpass='$wytuserpass',blpassword='$blpassword', bluserame='$bluserame' WHERE `ebay_user` ='$user' LIMIT 1";
		if($dbcon->execute($sql)){
			$status	= " -[<font color='#33CC33'>操作记录: 数据保存成功</font>]";
		}else{
			$status = " -[<font color='#FF0000'>操作记录: 数据保存失败</font>]";
		}
	}

	
	
	
	$ss		= "select * from ebay_config WHERE `ebay_user` ='$user' LIMIT 1";
	$ss		= $dbcon->execute($ss);
	$ss		= $dbcon->getResultArray($ss);
	
	
	//print_r($ss);
	
	$storeid						= $ss[0]['storeid'];			// 订单默认占用仓库:
	$notesorderstatus				= $ss[0]['notesorderstatus'];	// 订单默认占用仓库:
	$auditcompleteorderstatus		= $ss[0]['auditcompleteorderstatus']; //订单核对成功后，转入
	$scaningorderstatus				= $ss[0]['scaningorderstatus'];
	$days30							= $ss[0]['days30'];			// 订单默认占用仓库:
	$days15							= $ss[0]['days15'];			// 订单默认占用仓库:
	$days7							= $ss[0]['days7'];			// 订单默认占用仓库:
	$overweightstatus				= $ss[0]['overweightstatus'];			// 订单默认占用仓库:
	$overtock						= $ss[0]['overtock'];			// 订单默认占用仓库:
	$totalprofitstatus				= $ss[0]['totalprofitstatus'];			// 遇到有hei名单订单时，应该转入哪个分类
	$hackorer						= $ss[0]['hackorer'];			// 遇到有hei名单订单时，应该转入哪个分类
	$systemprofit					= $ss[0]['systemprofit'];			// 遇到有hei名单订单时，应该转入哪个分类
	$feedbackstring					= $ss[0]['feedbackstring'];
	$onstock					    = $ss[0]['onstock'];			//有库存时转入哪个分类
	$ywpassword						= $ss[0]['ywpassword'];
	$ywuserid						= $ss[0]['ywuserid'];
	$paypalstatus					= $ss[0]['paypalstatus'];
	$allowauditorderstatus			= $ss[0]['allowauditorderstatus'];
	$distrubitestock				= $ss[0]['distrubitestock'];
	$token4px						= $ss[0]['token4px'];
	
	$ddbtoken4px						= $ss[0]['ddbtoken4px'];
	$ddbid4px						= $ss[0]['ddbid4px'];
	$overqtys						= $ss[0]['overqtys'];
	
	
	$ckyuserid						= $ss[0]['ckyuserid'];
	$ckyuserkey						= $ss[0]['ckyuserkey'];
	$ckytoken						= $ss[0]['ckytoken'];
	$takeinventory					= $ss[0]['takeinventory']; // 占用库存
	
	
	$stapikey					 	= $ss[0]['stapikey'];
	$stapitoken					 	= $ss[0]['stapitoken'];	
	$stuserID					 	= $ss[0]['stuserID'];
	$wytuserpass					= $ss[0]['wytuserpass'];
	$wytuser					 	= $ss[0]['wytuser'];
	
	$bluserame						= $ss[0]['bluserame'];
	$blpassword					 	= $ss[0]['blpassword'];
	
 ?>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo '系统配置'.$status;?></h2>
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
                      <form id="form" name="form" method="post" action="systemconfig.php?module=system&action=系统配置">
                  <table width="73%" border="0" align="center" cellspacing="0" class="left_txt">
                    <tr>
                      <td width="35%">1.订单默认占用仓库：
                        <select name="storeid" id="storeid">
                          <option value="">未设置</option>
                          <?php 

							

							$sql = "select * from  ebay_store where ebay_user='$user'";									
							$sql = $dbcon->execute($sql);
							$sql = $dbcon->getResultArray($sql);
							for($i=0;$i<count($sql);$i++){

								$id					= $sql[$i]['id'];
								$store_name			= $sql[$i]['store_name'];
								$goods_sku			= $sql[$i]['goods_sku'];	
								$goods_sx			= $sql[$i]['goods_sx'];	
								$goods_xx			= $sql[$i]['goods_xx'];	
							?>
                          <option value="<?php echo $id;?>" <?php if($id ==$storeid) echo "selected=selected";?>><?php echo $store_name; ?></option>
                          <?php
							}
							?>
                        </select></td>
                    </tr>
                    <tr>
                      <td>2.有notes或有message，订单同步过来后进入：
                        <select name="notesorderstatus" id="notesorderstatus">
                          <option value="" <?php if($notesorderstatus == "") echo "selected=selected" ?>>未设置</option>
                          <option value="100" <?php if($notesorderstatus == "100")  echo "selected=selected" ?>>所有订单</option>
                          <option value="0" <?php   if($notesorderstatus == "0")  echo "selected=selected" ?>>未付款订单</option>
                          <option value="1" <?php   if($notesorderstatus == "1")  echo "selected=selected" ?>>待处理订单</option>
                          <?php

							$ss		= "select * from ebay_topmenu where ebay_user='$user' and name != '' order by ordernumber";
							$ss		= $dbcon->execute($ss);
							$ss		= $dbcon->getResultArray($ss);
							for($i=0;$i<count($ss);$i++){

								$ssid		= $ss[$i]['id'];
								$ssname		= $ss[$i]['name'];
							?>
                          <option value="<?php echo $ssid; ?>" <?php  if($notesorderstatus == $ssid)  echo "selected=selected" ?>><?php echo $ssname; ?></option>
                          <?php } ?>
                          <option value="2" <?php  if($notesorderstatus == '2')  echo "selected=selected" ?>>已经发货</option>
                        </select></td>
                    </tr>
                    <tr>
                      <td><p>3.只有订单订单状态为：
                          <select name="allowauditorderstatus" id="allowauditorderstatus">
                            <option value="" <?php if($allowauditorderstatus == "") echo "selected=selected" ?>>请配置订单状态</option>
                            <option value="0" <?php   if($allowauditorderstatus == "0")  echo "selected=selected" ?>>未付款订单</option>
                            <option value="1" <?php   if($allowauditorderstatus == "1")  echo "selected=selected" ?>>待处理订单</option>
                            <?php



				
							for($i=0;$i<count($ss);$i++){
								$ssid		= $ss[$i]['id'];
								$ssname		= $ss[$i]['name'];

								

							

							?>
                            <option value="<?php echo $ssid; ?>" <?php  if($allowauditorderstatus == $ssid)  echo "selected=selected" ?>><?php echo $ssname; ?></option>
                            <?php } ?>
                            <option value="2" <?php  if($allowauditorderstatus == '2')  echo "selected=selected" ?>>已经发货</option>
                          </select>
                        ，才可以扫描；订单核对成功后，转入：
                        <select name="auditcompleteorderstatus" id="auditcompleteorderstatus">
                          <option value="" <?php if($auditcompleteorderstatus == "") echo "selected=selected" ?>>未设置</option>
                          <option value="100" <?php if($auditcompleteorderstatus == "100")  echo "selected=selected" ?>>所有订单</option>
                          <option value="0" <?php   if($auditcompleteorderstatus == "0")  echo "selected=selected" ?>>未付款订单</option>
                          <option value="1" <?php   if($auditcompleteorderstatus == "1")  echo "selected=selected" ?>>待处理订单</option>
                          <?php



				
							for($i=0;$i<count($ss);$i++){
								$ssid		= $ss[$i]['id'];
								$ssname		= $ss[$i]['name'];

								

							

							?>
                          <option value="<?php echo $ssid; ?>" <?php  if($auditcompleteorderstatus == $ssid)  echo "selected=selected" ?>><?php echo $ssname; ?></option>
                          <?php } ?>
                          <option value="2" <?php  if($auditcompleteorderstatus == '2')  echo "selected=selected" ?>>已经发货</option>
                        </select>
<br />
                        <br />
                        订单条码拣货产品扫描核对成功后： 
                        <select name="scaningorderstatus" id="scaningorderstatus">
                          <option value="" <?php if($scaningorderstatus == "") echo "selected=selected" ?>>未设置</option>
                          <option value="100" <?php if($scaningorderstatus == "100")  echo "selected=selected" ?>>所有订单</option>
                          <option value="0" <?php   if($scaningorderstatus == "0")  echo "selected=selected" ?>>未付款订单</option>
                          <option value="1" <?php   if($scaningorderstatus == "1")  echo "selected=selected" ?>>待处理订单</option>
                          <?php



				
							for($i=0;$i<count($ss);$i++){
								$ssid		= $ss[$i]['id'];
								$ssname		= $ss[$i]['name'];

								

							

							?>
                          <option value="<?php echo $ssid; ?>" <?php  if($scaningorderstatus == $ssid)  echo "selected=selected" ?>><?php echo $ssname; ?></option>
                          <?php } ?>
                          <option value="2" <?php  if($scaningorderstatus == '2')  echo "selected=selected" ?>>已经发货</option>
                        </select>
                      </p>
                      <p>&nbsp;</p>                      </td>
                    </tr>
					<tr>
                      <td><br />
                     4.燕文userid<input name="ywuserid" type="text" id="ywuserid" value="<?php echo $ywuserid;?>" />&nbsp;&nbsp;燕文密码<input name="ywpassword" type="text" id="ywpassword" value="<?php echo $ywpassword;?>" /></td>
                    </tr>
                    <tr>
                      <td><br />
                      5.单个产品，平均每天销量计算公式，用于系统MRP计算,由系统自身，生成采购建议订单：</td>
                    </tr>
                    <tr>
                      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="39%">过去7天， 平均每天销量占</td>
                          <td width="61%"><input name="days7" type="text" id="days7" value="<?php echo $days7;?>" />
                            &nbsp;假设是50%,请输入 0.5 小数。</td>
                        </tr>
                        <tr>
                          <td>过去15天，平均每天销量占</td>
                          <td><input name="days15" type="text" id="days15" value="<?php echo $days15;?>" /></td>
                        </tr>
                        <tr>
                          <td>过去30天，平均每天销量占</td>
                          <td><input name="days30" type="text" id="days30" value="<?php echo $days30;?>" /></td>
                        </tr>
                        <tr>
                          <td colspan="2">单个产品每天销量 = 7天平均每天销量 * 百分比 +  15天平均每天销量 * 百分比 +  30天平均每天销量 * 百分比，每个产品的库存报警天数可在货品资料中去设置</td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td>6.当订单中的产品超过2kg 的时候，应该转入
                        <select name="overweightstatus" id="overweightstatus">
                          <option value="" <?php if($overweightstatus == "") echo "selected=selected" ?>>未设置</option>
                          <option value="100" <?php if($overweightstatus == "100")  echo "selected=selected" ?>>所有订单</option>
                          <option value="0" <?php   if($overweightstatus == "0")  echo "selected=selected" ?>>未付款订单</option>
                          <option value="1" <?php   if($overweightstatus == "1")  echo "selected=selected" ?>>待处理订单</option>
                          <?php
							for($i=0;$i<count($ss);$i++){
								$ssid		= $ss[$i]['id'];
								$ssname		= $ss[$i]['name'];
							?>
                          <option value="<?php echo $ssid; ?>" <?php  if($overweightstatus == $ssid)  echo "selected=selected" ?>><?php echo $ssname; ?></option>
                          <?php } ?>
                          <option value="2" <?php  if($overweightstatus == '2')  echo "selected=selected" ?>>已经发货</option>
                        </select></td>
                    </tr>
                    <tr>
                      <td>7.配货订单分类为：
                        <select name="distrubitestock" id="distrubitestock">
                          <option value="" <?php if($distrubitestock == "") echo "selected=selected" ?>>未设置</option>
                          <option value="1" <?php   if($distrubitestock == "1")  echo "selected=selected" ?>>待处理订单</option>
                          <?php



							for($i=0;$i<count($ss);$i++){
								$ssid		= $ss[$i]['id'];
								$ssname		= $ss[$i]['name'];
							?>
                          <option value="<?php echo $ssid; ?>" <?php  if($distrubitestock == $ssid)  echo "selected=selected" ?>><?php echo $ssname; ?></option>
                          <?php } ?>
                          <option value="2" <?php  if($distrubitestock == '2')  echo "selected=selected" ?>>已经发货</option>
                        </select>  
                        当订单中的物品，进行配货，无库存时，应该转入
                        <select name="overtock" id="overtock">
                          <option value="" <?php if($overtock == "") echo "selected=selected" ?>>未设置</option>
                          <option value="100" <?php if($overtock == "100")  echo "selected=selected" ?>>所有订单</option>
                          <option value="0" <?php   if($overtock == "0")  echo "selected=selected" ?>>未付款订单</option>
                          <option value="1" <?php   if($overtock == "1")  echo "selected=selected" ?>>待处理订单</option>
                          <?php



							for($i=0;$i<count($ss);$i++){
								$ssid		= $ss[$i]['id'];
								$ssname		= $ss[$i]['name'];
							?>
                          <option value="<?php echo $ssid; ?>" <?php  if($overtock == $ssid)  echo "selected=selected" ?>><?php echo $ssname; ?></option>
                          <?php } ?>
                          <option value="2" <?php  if($overtock == '2')  echo "selected=selected" ?>>已经发货</option>
                        </select>
                      ，有库存时转入
                      <select name="onstock" id="onstock">
                        <option value="" <?php if($onstock == "") echo "selected=selected" ?>>未设置</option>
                        <option value="100" <?php if($onstock == "100")  echo "selected=selected" ?>>所有订单</option>
                        <option value="0" <?php   if($onstock == "0")  echo "selected=selected" ?>>未付款订单</option>
                        <option value="1" <?php   if($onstock == "1")  echo "selected=selected" ?>>待处理订单</option>
                        <?php



							for($i=0;$i<count($ss);$i++){
								$ssid		= $ss[$i]['id'];
								$ssname		= $ss[$i]['name'];
							?>
                        <option value="<?php echo $ssid; ?>" <?php  if($onstock == $ssid)  echo "selected=selected" ?>><?php echo $ssname; ?></option>
                        <?php } ?>
                        <option value="2" <?php  if($onstock == '2')  echo "selected=selected" ?>>已经发货</option>
                      </select></td>
                    </tr>
                    
                    <tr>
                      <td>9.当遇到黑名单订单时，自动转入
                        <select name="hackorer" id="hackorer">
                          <option value=""     <?php   if($hackorer == "")     echo "selected=selected" ?>>未设置</option>
                          <option value="100"  <?php   if($hackorer == "100")  echo "selected=selected" ?>>所有订单</option>
                          <option value="0"    <?php   if($hackorer == "0")    echo "selected=selected" ?>>未付款订单</option>
                          <option value="1"    <?php   if($hackorer == "1")    echo "selected=selected" ?>>待处理订单</option>
                          <?php



							for($i=0;$i<count($ss);$i++){
								$ssid		= $ss[$i]['id'];
								$ssname		= $ss[$i]['name'];
							?>
                          <option value="<?php echo $ssid; ?>" <?php  if($hackorer == $ssid)  echo "selected=selected" ?>><?php echo $ssname; ?></option>
                          <?php } ?>
                          <option value="2" <?php  if($hackorer == '2')  echo "selected=selected" ?>>已经发货</option>
                        </select></td>
                    </tr>
                    <tr>
                      <td>10.当利润小于
                        <input name="systemprofit" type="text" id="systemprofit" value="<?php echo $systemprofit;?>" />
                        时，自动转入
                        <select name="totalprofitstatus" id="totalprofitstatus">
                          <option value=""     <?php   if($totalprofit == "")     echo "selected=selected" ?>>未设置</option>
                          <option value="100"  <?php   if($totalprofit == "100")  echo "selected=selected" ?>>所有订单</option>
                          <option value="0"    <?php   if($totalprofit == "0")    echo "selected=selected" ?>>未付款订单</option>
                          <option value="1"    <?php   if($totalprofit == "1")    echo "selected=selected" ?>>待处理订单</option>
                          <?php

							for($i=0;$i<count($ss);$i++){
								$ssid		= $ss[$i]['id'];
								$ssname		= $ss[$i]['name'];
							?>
                          <option value="<?php echo $ssid; ?>" <?php  if($totalprofitstatus == $ssid)  echo "selected=selected" ?>><?php echo $ssname; ?></option>
                          <?php } ?>
                          <option value="2" <?php  if($totalprofit == '2')  echo "selected=selected" ?>>已经发货</option>
                        </select></td>
                    </tr>
                    <tr>
                      <td>11.当订单标记发出时，立即给客户留下评价,每句评介请用&amp;&amp;分开：<br />
                        <textarea name="feedbackstring" cols="100" rows="10" id="feedbackstring"><?php echo $feedbackstring;?></textarea>
                        <br />
                      <br /></td>
                    </tr>
                    <tr>
                      <td>12. 当同步pp线下订单时，应该进入：
                        <select name="paypalstatus" id="paypalstatus">
                          <option value="" <?php if($paypalstatus == "") echo "selected=selected" ?>>未设置</option>
                          <option value="100" <?php if($paypalstatus == "100")  echo "selected=selected" ?>>所有订单</option>
                          <option value="0" <?php   if($paypalstatus == "0")  echo "selected=selected" ?>>未付款订单</option>
                          <option value="1" <?php   if($paypalstatus == "1")  echo "selected=selected" ?>>待处理订单</option>
                          <?php

							$ss		= "select * from ebay_topmenu where ebay_user='$user' and name != '' order by ordernumber";
							$ss		= $dbcon->execute($ss);
							$ss		= $dbcon->getResultArray($ss);
							for($i=0;$i<count($ss);$i++){

								$ssid		= $ss[$i]['id'];
								$ssname		= $ss[$i]['name'];
							?>
                          <option value="<?php echo $ssid; ?>" <?php  if($paypalstatus == $ssid)  echo "selected=selected" ?>><?php echo $ssname; ?></option>
                          <?php } ?>
                          <option value="2" <?php  if($paypalstatus == '2')  echo "selected=selected" ?>>已经发货</option>
                        </select></td>
                    </tr>
					<tr>
                      <td>13.4px AUTHTOKEN：<br />
                        <input name="token4px" type='text' id="token4px" value="<?php echo $token4px;?>"/>
                         请联系4px要取TOKEN<br />
                      <br /></td>
                    </tr>
					<tr>
                      <td>14.订单宝 TOKEN：<br />
                        <input name="ddbtoken4px" type='text' id="ddbtoken4px" value="<?php echo $ddbtoken4px;?>"/>
                         订单宝的TOKEN<input name="ddbid4px" type='text' id="ddbid4px" value="<?php echo $ddbid4px;?>"/>
                         订单宝的数字ID<br />
                      <br /></td>
                    </tr>
					<tr>
					  <td>15. 当客户订购的产品数量超过
					    <input name="overqtys" type="text" id="overqtys" value="<?php echo $overqtys;?>" />
				      不参与智能预警</td>
				    </tr>
					<tr>
					  <td>16. 出口易  Token
                        <input name="ckytoken" type='text' id="ckytoken" value="<?php echo $ckytoken;?>"/>
User id
<input name="ckyuserid" type='text' id="ckyuserid" value="<?php echo $ckyuserid;?>"/>
Userkey
<input name="ckyuserkey" type="text" id="ckyuserkey" value="<?php echo $ckyuserkey;?>" /></td>
				    </tr>
					<tr>
					  <td>17. 哪些状态下面计算占用库存数量: 
				      <input name="takeinventory" type="text" id="takeinventory" value="<?php echo $takeinventory;?>" />
				      (请填写订单状态ID, 可以系统管理-&gt;订单分类中查看到, 用英文, 分开)</td>
				    </tr>
					<tr>
					  <td><br />
18.三态 appkey
  <input name="stapikey" type="text" id="stapikey" value="<?php echo $stapikey;?>" />
  &nbsp;&nbsp;token
  <input name="stapitoken" type="text" id="stapitoken" value="<?php echo $stapitoken;?>" />
  &nbsp;&nbsp;userID
  <input name="stuserID" type="text" id="stuserID" value="<?php echo $stuserID;?>" /></td>
				    </tr>
					<tr>
					  <td>19.万邑通用户名:
					    <input name="wytuser" type="text" id="wytuser" value="<?php echo $wytuser;?>" /> 
				      万邑通密码:
				      <input name="wytuserpass" type="text" id="wytuserpass" value="<?php echo $wytuserpass;?>" /></td>
				    </tr>
					<tr>
					  <td>20.比利时邮政用户名:
					    <input name="bluserame" type="text" id="bluserame" value="<?php echo $bluserame;?>" /> 
					    密码:
					    <input name="blpassword" type="text" id="blpassword" value="<?php echo $blpassword;?>" /></td>
				    </tr>
                    <tr>
                      <td><input name="submit" type="submit" value="提交" onClick="return check()">
                        &nbsp;</td>
                      </tr>
                  </table>
                  </form>
					  <p>&nbsp;</p>
				    <p>&nbsp;</p>
				    <p>&nbsp;</p>
				    <p>&nbsp;</p></td>
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
	
		var pas1	= document.getElementById('pass1').value;
		var pas2	= document.getElementById('pass2').value;
		
		if(pas1 == "" || pas2 == ""){
		
			alert('请输入密码');
			return false;
		}
		
		if(pas1 != pas2){
			
			alert('两次输入法的密码不一至');
			return false;
		
		}
	
	}



</script>
