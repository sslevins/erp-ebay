<?php

include "include/config.php";
include "top2.php";	

	/* 修改客户地址 */
	

	
	$ordersn	= $_REQUEST['ordersn'];
	$type		= $_REQUEST['type'];
	if($_POST['uio']){
		$content 	= $_POST['content'];
		$addtime	= date('Y-m-d H:i:s');
		$truename	= $_SESSION['truename'];
		$sql		= "insert into ebay_ordernote(addtime,content,user,ordersn) values('$addtime','$content','$truename','$ordersn')";
		if($dbcon->execute($sql)){
					$status	= " -[<font color='#33CC33'>操作记录: 数据保存成功</font>]";
		}else{
					$status = " -[<font color='#FF0000'>操作记录: 数据保存成功</font>]";
		}
	}

	if($_POST['address']){
		$ebay_ordertype 		= str_rep($_POST['ebay_ordertype']);
		$name 					= str_rep($_POST['name']);
		$street1				= str_rep($_POST['street1']);
		$street2				= str_rep($_POST['street2']);
		$city					= str_rep($_POST['city']);
		$state					= str_rep($_POST['state']);
		$country				= str_rep($_POST['country']);
		$zip					= str_rep($_POST['zip']);
		$tel					= str_rep($_POST['tel']);
		$userid					= str_rep($_POST['userid']);
		$orderstatus		 	= $_POST['orderstatus'];
		$ebay_warehouse		 	= $_POST['ebay_warehouse'];
		$ebay_shipfee			= $_POST['ebay_shipfee'];
		$ebay_total				= $_POST["ebay_total"];
		$ebay_currency			= $_POST['ebay_currency'];
		$ebay_paidtime			= strtotime($_POST['ebay_paidtime']);
		$ebay_account			= $_POST['ebay_account'];
		$ebay_carrier			= $_POST['ebay_carrier'];
		$ebay_usermail			= $_POST['ebay_usermail'];
		$ebay_tracknumber		= $_POST['ebay_tracknumber'];
		$ebay_noteb				= str_rep($_POST['ebay_noteb']);
		$ebay_note				= str_rep($_POST['ebay_note']);
		$resendreason			= str_rep($_POST['resendreason']);
		$refundreason			= str_rep($_POST['refundreason']);
		$resendtime				= strtotime($_POST['resendtime']);
		$ebay_markettime		= strtotime($_POST['ebay_markettime']);
		$refundtime				= strtotime($_POST['refundtime']);
		$cancelreason			= str_rep($_POST['cancelreason']);
		$canceltime				= strtotime($_POST['canceltime']);
		$packingtype			= str_rep($_POST['packingtype']);
		$orderweight			= str_rep($_POST['orderweight']);
		$ordershipfee			= str_rep($_POST['ordershipfee']);
		$orderweight2			= str_rep($_POST['orderweight2']);
		$packinguser			= str_rep($_POST['packinguser']);
		$ebay_phone1			= str_rep($_POST['ebay_phone1']);
		$order_no			= str_rep($_POST['order_no']);
		
		
		if($resendtime == '') $resendtime = 0;
		if($refundtime == '') $refundtime = 0;
		if($canceltime == '') $canceltime = 0;
		if($ebay_markettime == '') $ebay_markettime = 0;
		


		

		

		if($type    == "addorder" && $name != ""){

			$ordersn				= date('Y')."-".date('m')."-".date('d')."-".date("H").date('i').date('s'). mt_rand(100, 999);
			while(true){
					$si		= "select ebay_ordersn from ebay_order where ebay_ordersn ='$ordersn'";
					$si		= $dbcon->execute($si);
					$si		= $dbcon->getResultArray($si);
					if(count($si)==0) break;
					$ordersn				= date('Y')."-".date('m')."-".date('d')."-".date("H").date('i').date('s'). mt_rand(100, 999);
			}
			$sql		= "insert into ebay_order(ebay_user,ebay_status,ebay_ordersn,ebay_username,ebay_street,ebay_street1,ebay_city,ebay_state,ebay_countryname,ebay_postcode,";
			$sql		.= "ebay_phone,ebay_shipfee,ebay_usermail,ebay_userid,ebay_ptid,ebay_total,ebay_currency,ebay_paidtime,ebay_account,ebay_tracknumber,ebay_noteb,ebay_carrier,ebay_note,resendreason,refundreason,resendtime,refundtime,ebay_ordertype,packingtype,orderweight,ordershipfee,packinguser,ebay_warehouse,order_no) values('$user','$orderstatus','$ordersn','$name','$street1','$street2','$city','$state','$country','$zip','$tel','$ebay_shipfee','$mail','$userid','$ctransactionid','$ebay_total','$ebay_currency','$ebay_paidtime','$ebay_account','$ebay_tracknumber','$ebay_noteb','$ebay_carrier','$ebay_note','$resendreason','$refundreason','$resendtime','$refundtime','$ebay_ordertype','$packingtype','$orderweight','$ordershipfee','$packinguser','$ebay_warehouse','$order_no')";
			$type		= "";
		}else{


		$sql		= "UPDATE `ebay_order` SET `ebay_ordertype` = '$ebay_ordertype', `ebay_username` = '$name',`ebay_street` = '$street1',`ebay_street1` = '$street2',";
		$sql	   .= "`ebay_city` = '$city',`ebay_state` = '$state',`ebay_countryname` = '$country',`ebay_postcode` = '$zip',";
		$sql	   .= "`ebay_phone` = '$tel',ebay_status='$orderstatus',ebay_userid='$userid',ebay_shipfee='$ebay_shipfee',ebay_phone1='$ebay_phone1' ,";
		$sql	.=    "ebay_total='$ebay_total',ebay_currency='$ebay_currency',ebay_paidtime='$ebay_paidtime',ebay_account='$ebay_account',ebay_carrier='$ebay_carrier',ebay_tracknumber='$ebay_tracknumber',ebay_noteb='$ebay_noteb',ebay_note='$ebay_note',resendreason='$resendreason',refundreason='$refundreason',resendtime='$resendtime',refundtime='$refundtime',canceltime='$canceltime',cancelreason='$cancelreason',ebay_usermail ='$ebay_usermail',ebay_markettime='$ebay_markettime',ordershipfee='$ordershipfee',orderweight='$orderweight',packingtype='$packingtype',orderweight2='$orderweight2',packinguser='$packinguser',ebay_warehouse='$ebay_warehouse',ismodifive
='1',order_no='$order_no' WHERE `ebay_ordersn` ='$ordersn' LIMIT 1 ";
		
		
		$ebay_id			= GetOrderID($ordersn);
		$porderstatus		= GetOrderStatusV2($ebay_id); /* 取得订单修改之前的状态 */
		$porderstatusf		= GetOrderStatusV2f($orderstatus);  // 取得修改后订单的状态
		if($porderstatus != $porderstatusf){
		$notes				= '订单修改之前的状态是:['.$porderstatus.'] 订单修改后的状态是: ['.$porderstatusf.'] 修改人是:'.$truename;
		addordernote($ebay_id,$notes);
		}


		}

			

		if($dbcon->execute($sql)){
			$status	= " -[<font color='#33CC33'>操作记录: 保存成功</font>]";
		}else{
			$status = " -[<font color='#FF0000'>操作记录: 保存失败</font>]";
		}

	}

	

	/*  删除客户中的产品 */

	

	if($_REQUEST['type'] == "del"){
		$ebay_id	= $_REQUEST['ebayid'];
		$sql		= "delete  from ebay_orderdetail where ebay_id='$ebay_id' and ebay_ordersn='$ordersn'";
		if($dbcon->execute($sql)){
			$status	= " -[<font color='#33CC33'>操作记录: 产品删除成功</font>]";
		}else{
			$status = " -[<font color='#FF0000'>操作记录: 产品删除失败</font>]";
		}
	}

	/* 修改客户中的产品 */

	

	if($_REQUEST['type'] == "mod"){

		$ebayid		= $_REQUEST['ebayid'];
		$pname		= mysql_escape_string($_REQUEST['pname']);
		$pqty		= $_REQUEST['pqty'];
		$pprice		= $_REQUEST['pprice'];
		$psku		= mysql_escape_string($_REQUEST['psku']);
		$pitemid	= $_REQUEST['pitemid'];
		$sspfee		= $_REQUEST['sspfee'];
		$notes		= str_rep($_REQUEST['notes']);
		$sql		= "";
		
		if($psku != '' && $pname != '' && $pqty > 0 ){
		
		$sql		= "update ebay_orderdetail set sku='$psku',notes='$notes',ebay_itemtitle='$pname',ebay_itemprice='$pprice',shipingfee='$sspfee',ebay_amount='$pqty',ebay_itemid='$pitemid' where ebay_id='$ebayid' and ebay_ordersn='$ordersn'";

		if($dbcon->execute($sql)){
			$status	= " -[<font color='#33CC33'>操作记录: 产品修改成功</font>]";
		}else{
			$status = " -[<font color='#FF0000'>操作记录: 产品修改失败</font>]";
		}
		
		}
		
		$ss			= "select sum(ebay_amount*ebay_itemprice) as cc from ebay_orderdetail where ebay_ordersn='$ordersn'";
		$ss			= $dbcon->execute($ss);
		$ss			= $dbcon->getResultArray($ss);
		$stotal		= $ss[0]['cc'];
		//$ss			= "update ebay_order set ebay_total='$stotal' where ebay_ordersn='$ordersn'";
	//	$dbcon->execute($ss);
		

		

	}

	

	/* 增加客户中的产品 */
	
	$tsku		 = trim($_REQUEST['tsku']);
	$tname		 = mysql_escape_string($_REQUEST['tname']);

	if($_REQUEST['type'] == "add" && $tsku != ''){
	
		

		$tqty		 = $_REQUEST['tqty'];
		$tprice	     = $_REQUEST['tprice'];
		$titemid	= $_REQUEST['titemid'];
		
		$vv			 = "select * from ebay_orderdetail where ebay_ordersn ='$ordersn' and sku ='$tsku' and sku != '' ";
		$vv			 = $dbcon->execute($vv);
		$vv			 = $dbcon->getResultArray($vv);
		
		$addrecordnumber = date('Y').date('m').date('d').date('H').date('i').date('s').rand(0,999);
		if(count($vv) == 0 ){
		$sql		 = "insert into ebay_orderdetail(recordnumber,ebay_ordersn,ebay_itemtitle,ebay_itemprice,ebay_amount,sku,ebay_itemid) values('$addrecordnumber','$ordersn','$tname','$tprice','$tqty','$tsku','$titemid')";
		if($dbcon->execute($sql) ){
			$status	= " -[<font color='#33CC33'>操作记录: 产品添加成功</font>]";
		}else{
			$status = " -[<font color='#FF0000'>操作记录: 产品添加失败</font>]";
		}
		}
		

	}

	

	

	$sql		= "select * from ebay_order where ebay_ordersn='$ordersn'";


//	$orderweight		= getOrderweight($ordersn);
//	$vv					= "update ebay_order set orderweight ='$orderweight' where ebay_ordersn='$ordersn'";
//	$dbcon->execute($vv);
	
	
	$sql		= $dbcon->execute($sql);
	$sql		= $dbcon->getResultArray($sql);
	$oost		= $sql[0]['ebay_status'];
	$ebay_id	= $sql[0]['ebay_id'];




 ?>
 <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>
 <style type="text/css">
<!--
.STYLE1 {color: #FF0000}
-->
 </style>
 

<div id="main">

    <div id="content" >

        <table style="width:100%"><tr><td><div class='moduleTitle'>

<h2><?php echo $_REQUEST['action'].$status;?> </h2>

</div>



<div class='listViewBody'>





<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">

 
                    <form id="ad" name="ad" method="post" action="ordermodifive.php?ordersn=<?php echo $ordersn;?>&module=<?php echo $_REQUEST['module'];?>&type=<?php echo $type;?>&action=新增订单">

 

<table width="100%" cellspacing="0" cellpadding="0" border="0">

<tr>

	

	

	

		

	<td nowrap="nowrap" scope="row" >&nbsp;
    
    <?php 	if(in_array("orders_modifive",$cpower)){	 ?> 
    <input name="address" type="submit" value="保存单据" onclick="return check()" />
    <?php 	}	 ?> 
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>

                      <td class="login_txt_bt">第一步：地址输入完成后，请先将地址保存</td>
              </tr>

                    <tr>

                      <td valign="top" class="left_txt">

                      <?php
							$ebay_phone1		= $sql[0]['ebay_phone1'];
							$packingtype		= $sql[0]['packingtype'];
							$orderweight		= $sql[0]['orderweight'];
							$ordershipfee		= $sql[0]['ordershipfee'];
							$ebay_warehouse		= $sql[0]['ebay_warehouse'];
							$ebay_ptid		= $sql[0]['ebay_ptid'];
							
					  	   $ebay_markettime		= $sql[0]['ebay_markettime'];
							$ebay_total		= $sql[0]['ebay_total'];
						   $name		= $sql[0]['ebay_username'];

						   $street1		= @$sql[0]['ebay_street'];

						   $street2 	= @$sql[0]['ebay_street1'];

						   $city 		= $sql[0]['ebay_city'];
						    $order_no 		= $sql[0]['order_no'];

						   $state		= $sql[0]['ebay_state'];

						   $countryname = $sql[0]['ebay_countryname'];

						   $zip			= $sql[0]['ebay_postcode'];
							$packinguser			= $sql[0]['packinguser'];
						   $tel			= $sql[0]['ebay_phone'];

						   $fee = $sql[0]['ebay_shipfee'];

						   $userid		= $sql[0]['ebay_userid'];

						   $ebay_shipfee = $sql[0]['ebay_shipfee'];

						   $ebay_total	 = $sql[0]['ebay_total'];

					  	   $ebay_currency	= $sql[0]['ebay_currency'];
						    $ebay_ordertype	= $sql[0]['ebay_ordertype'];
						   
						   $scy			= "select * from ebay_currency where currency='$ebay_currency' and user='$user' ";
						   $scy			= $dbcon->execute($scy);
						   $scy			= $dbcon->getResultArray($scy);
						   
						   if(count($scy) == 0 && $ebay_currency !='' && $ebay_currency !='-1'){
						   		
								$scy	= "insert into ebay_currency(currency,user) values('$ebay_currency','$user')";
						   		$dbcon->execute($scy);
						   }

						   $ebay_paidtime	= $sql[0]['ebay_paidtime'];
						   
						   if($ordersn =='' ) $ebay_paidtime	= $mctime;
						   

						   $ebay_account	= $sql[0]['ebay_account'];

						   $ebay_carrier	= $sql[0]['ebay_carrier'];

						   $ebay_noteb			= $sql[0]['ebay_noteb'];

						    $ebay_note			= $sql[0]['ebay_note'];

						   $ebay_tracknumber			= $sql[0]['ebay_tracknumber'];
						   
						   $resendtime			= $sql[0]['resendtime'];
						   if($resendtime != '' && $resendtime !='0'){
						   		
								$resendtime		= date('Y-m-d',$resendtime);
								
						   }else{
						   
						   		$resendtime		= '';
								
						   }
						    $ebay_usermail			= $sql[0]['ebay_usermail'];
						   $refundtime			= $sql[0]['refundtime'];
						   if($refundtime != '' && $refundtime !='0'){
						   		
								$refundtime		= date('Y-m-d',$refundtime);
								
						   }else{
						   		
								$refundtime		= '';
								
						   }
						    $canceltime			= $sql[0]['canceltime'];
						   if($canceltime != '' && $canceltime !='0'){
						   		
								$canceltime		= date('Y-m-d',$canceltime);
								
						   }else{
						   		
								$canceltime		= '';
								
						   }
						   
						   
						   
						   if($ebay_markettime != '' && $ebay_markettime !='0'){
						   		
								$ebay_markettime		= date('Y-m-d',$ebay_markettime);
								
						   }else{
						   		
								$ebay_markettime		= '';
								
						   }
						   
						   $resendreason			= $sql[0]['resendreason'];
						   $refundreason			= $sql[0]['refundreason'];
 						   $cancelreason			= $sql[0]['cancelreason'];
						   $orderweight2			= $sql[0]['orderweight2'];
$ebay_warehouse			= $sql[0]['ebay_warehouse'];
					  ?>

                      &nbsp;<br>

  
                     

                      

                      <table width="89%" border="0" cellpadding="0" cellspacing="0" class="login_txt" style="border:1px solid #000000">

                        <tr>

                          <td width="13%">Full name</td>

                          <td width="37%"><input name="name" type="text" id="name" value="<?php echo $name;?>">
                          (必填) <strong></strong></td>

                          <td width="15%">订单状态</td>

                          <td width="35%"><select name="orderstatus" id="orderstatus">
                          
                            <?php if($_REQUEST['module'] =='zencart'){ ?>
                            
                              <option value="1" <?php  if($oost == "1")  echo "selected=selected" ?>>ZenCart未处理</option>

                            <option value="2" <?php  if($oost == "2")  echo "selected=selected" ?>>ZenCart已处理</option>
                            <option value="3" <?php  if($oost == "3")  echo "selected=selected" ?>>ZEN-CART待MARK SHIP</option>
                            <option value="4" <?php  if($oost == "4")  echo "selected=selected" ?>>ZenCart退款订单</option>
                            <option value="5" <?php  if($oost == "5")  echo "selected=selected" ?>>ZenCart取消订单</option>
                             <option value="6" <?php  if($oost == "6")  echo "selected=selected" ?>>ZenCart缺货订单</option>
                             
                              <option value="7" <?php  if($oost == "7")  echo "selected=selected" ?>>ZenCart待打印订单</option>
                             <option value="8" <?php  if($oost == "8")  echo "selected=selected" ?>>ZenCart已打印订单</option>
                            
            
                           
                            
                            <?php }else{ ?>

                            <option value="0" <?php  if($oost == "0")  echo "selected=selected" ?>>待付款订单</option>
                            <option value="1" <?php  if($oost == "1")  echo "selected=selected" ?>>待处理订单</option>
                            <option value="2" <?php  if($oost == "2")  echo "selected=selected" ?>>已经发货</option>                          
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
                            
                            
                            <?php } ?>

                          </select>
                            (必填)                            <span class="STYLE1"><strong></strong></span></td>
                        </tr>

                        <tr>

                          <td>Street1</td>

                          <td><input name="street1" type="text" id="street1" value="<?php echo $street1; ?>">
                          (必填) <strong></strong></td>

                          <td>客户ID</td>

                          <td><input name="userid" type="text" id="userid" value="<?php echo $userid; ?>"></td>
                        </tr>

                        <tr>

                          <td>Street2</td>

                          <td><input name="street2" type="text" id="street2" value="<?php echo $street2; ?>"></td>

                          <td>总运费</td>

                          <td><input name="ebay_shipfee" type="text" id="ebay_shipfee" value="<?php echo $ebay_shipfee; ?>"></td>
                        </tr>

                        <tr>

                          <td>City</td> 

                          <td><input name="city" type="text" id="city" value="<?php echo $city;?>"></td>

                          <td>总金额</td>

                          <td><input name="ebay_total" type="text" id="ebay_total" value="<?php echo $ebay_total; ?>"></td>
                        </tr>

                        <tr>

                          <td>State</td>

                          <td><input name="state" type="text" id="state" value="<?php echo $state;?>"></td>

                          <td>币种</td>

                          <td><select name="ebay_currency" id="ebay_currency">
                              <option value="-1" >请选择</option>
                              <?php

							$tql	= "select * from ebay_currency where user = '$user'";
							$tql	= $dbcon->execute($tql);
							$tql	= $dbcon->getResultArray($tql);
							for($i=0;$i<count($tql);$i++){

							$currency1		= $tql[$i]['currency'];

						   

						   ?>
                              <option value="<?php echo $currency1;?>"  <?php if($ebay_currency == $currency1) echo "selected=selected" ?>><?php echo $currency1;?></option>
                              <?php

						   }

						   

						   

						   ?>
                            </select></td>
                        </tr>

                        <tr>

                          <td>Country</td>

                          <td><input name="country" type="text" id="country" value="<?php echo $countryname;?>"></td>

                          <td>付款时间</td>

                          <td><input name="ebay_paidtime" type="text" id="ebay_paidtime" value="<?php echo date('Y-m-d',$ebay_paidtime); ?>" onclick="WdatePicker()" ></td>
                        </tr>
                        <tr>
                          <td>Payapal交易ID</td>
                          <td><?php echo $ebay_ptid;?>&nbsp;</td>
                          <td>发货时间</td>
                          <td><input name="ebay_markettime" type="text" id="ebay_markettime" value="<?php echo $ebay_markettime; ?>" onclick="WdatePicker()" /></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>重寄时间</td>
                          <td><input name="resendtime" type="text" id="resendtime" value="<?php echo $resendtime; ?>" onclick="WdatePicker()" /></td>
                        </tr>
                        <tr>
                          <td>手机</td>
                          <td><input name="ebay_phone1" type="text" id="ebay_phone1" value="<?php echo $ebay_phone1;?>" /></td>
                          <td>退款时间</td>
                          <td><input name="refundtime" type="text" id="refundtime" value="<?php echo $refundtime; ?>" onclick="WdatePicker()" /></td>
                        </tr>

                        <tr>

                          <td>Postcode</td>

                          <td><input name="zip" type="text" id="zip" value="<?php echo $zip;?>"></td>

                          <td>ebay帐号</td>

                          <td><select name="ebay_account" id="ebay_account">

                          

                          <option value="" >未设置</option>

                           <?php if($_REQUEST['module'] !='zencart'){ ?>

                    <?php 
					$sql	 = "select * from ebay_account as a  where a.ebay_user='$user' and ($ebayacc) order by ebay_account desc ";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 	$account	= $sql[$i]['ebay_account'];
					 ?>
                    <option value="<?php echo $account;?>" <?php if($ebay_account == $account) echo "selected=selected" ?>><?php echo $account;?></option>
                    <?php }
					
					}else{
					 ?>
                    
                         <?php 
					$sql	 = "select * from ebay_zen where user='$user'";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 	$account	= $sql[$i]['zen_name'];
					 ?>
                    <option value="<?php echo $account;?>" <?php if($ebay_account == $account) echo "selected=selected" ?>><?php echo $account;?></option>
                    <?php } ?>
                    
                    
                    
                    <?php } ?>
                    
         
                    
                    
                    </select>
                          (必填) <strong></strong></td>
                        </tr>

                        <tr>

                          <td>Tel</td>

                          <td><input name="tel" type="text" id="tel" value="<?php echo $tel;?>"></td>

                          <td>跟踪号</td>

                          <td><input name="ebay_tracknumber" type="text" id="ebay_tracknumber" value="<?php echo $ebay_tracknumber ;?>" /></td>
                        </tr>

                        <tr>

                          <td> Shipping Methods </td>

                          <td><select name="ebay_carrier">

                          <option value="" >请选择</option>

                          

                           <?php

						   	

							$tql	= "select * from ebay_carrier where ebay_user = '$user'";

							$tql	= $dbcon->execute($tql);

							$tql	= $dbcon->getResultArray($tql);

							for($i=0;$i<count($tql);$i++){

							

							$tname		= $tql[$i]['name'];

					

							

						   

						   ?>

                            <option value="<?php echo $tname;?>"  <?php if($tname == $ebay_carrier) echo "selected=selected" ?>><?php echo $tname;?></option>

                           <?php

						   }

						   

						   

						   ?>

                          </select>                         </td>
                          <td>订单类型：</td>
                          <td><select name="ebay_ordertype" id="ebay_ordertype">
                            <option value="-1" >请选择</option>
                            <?php

							$tql	= "select * from ebay_ordertype where ebay_user = '$user'";
							$tql	= $dbcon->execute($tql);
							$tql	= $dbcon->getResultArray($tql);
							for($i=0;$i<count($tql);$i++){

							$typename1		= $tql[$i]['typename'];

						   

						   ?>
                            <option value="<?php echo $typename1;?>"  <?php if($ebay_ordertype == $typename1) echo "selected=selected" ?>><?php echo $typename1;?></option>
                            <?php

						   }

						   

						   

						   ?>
                          </select></td>
                        </tr>
                        <tr>
                          <td>User Mail</td>
                          <td><input name="ebay_usermail" type="text" id="ebay_usermail" value="<?php echo $ebay_usermail;?>" style="width:250px"  /></td>
                          <td>订单对应出库仓库</td>
                          <td><select name="ebay_warehouse" id="ebay_warehouse">
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
                          </select>
                          (必填) <strong></strong></td>
                        </tr>

                        <tr>

                          <td>Mynote</td>

                          <td><textarea name="ebay_noteb" cols="50" rows="3" id="ebay_noteb"><?php echo $ebay_noteb;?></textarea></td>

                          <td>ebay note</td>

                          <td><textarea name="ebay_note" cols="50" rows="3" id="ebay_note"><?php echo $ebay_note;?></textarea></td>
                        </tr>
                        <tr>
                          <td>包装材料:</td>
                          <td><select name="packingtype" id ="packingtype">
                            <option value="-1">Please Select</option>
                            <?php

							

							$tsql		= "select * from ebay_packingmaterial where ebay_user='$user'";

							$tsql		= $dbcon->execute($tsql);

							$tsql		= $dbcon->getResultArray($tsql);

							for($i=0;$i<count($tsql);$i++){

								
								$models	= $tsql[$i]['model'];								

								

								

							?>
                            <option value="<?php echo $models;?>"  <?php if($models == $packingtype) echo "selected=\"selected\""?>><?php echo $models; ?></option>
                            <?php

							

							}

							

							

							?>
                          </select></td>
                          <td>包裹计算重量</td>
                          <td><input name="orderweight" type="text" id="orderweight" value="<?php echo $orderweight;?>" /></td>
                        </tr>
                        <tr>
                          <td>实际运费:</td>
                          <td><input name="ordershipfee" type="text" id="ordershipfee" value="<?php echo $ordershipfee;?>" /></td>
                          <td>包裹实际重量</td>
                          <td><input name="orderweight2" type="text" id="orderweight2" value="<?php echo $orderweight2;?>" />
                            *电子称同步重量</td>
                        </tr>
                        <tr>
                          <td>国外-发票号</td>
                          <td><input name="order_no" type="text" id="order_no" value="<?php echo $order_no;?>" /></td>
                          <td>包裹扫描人</td>
                          <td><input name="packinguser" type="text" id="packinguser" value="<?php echo $packinguser;?>" /></td>
                        </tr>

                        <tr>

                          <td colspan="4">&nbsp;</td>
                        </tr>
                      </table>

                     

                      <p><br>

                      第二步：地址保存 完成后，请在添加订单中的产品</p>

                      <p><br>
                        </p></td>
                    </tr>

                    <tr>

                      <td class="login_txt_bt">&nbsp;</td>
                    </tr>

                    <tr>

                      <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="left_txt" style="border:#000000 1px solid">

                        <tr>

                          <td>ItemID</td>

                          <td>Customer Label</td>

                          <td>Item Title</td>

                          <td>Price</td>

                          <td>Shipping Fee</td>
                          <td>Quantity</td>

                          <td>单件重量</td>
                          <td>Total</td>

                          <td>备注</td>
                          <td>Operation</td>
                        </tr>

                        <?php

							

							$st	= "select * from ebay_orderdetail where ebay_ordersn='$ordersn' and ebay_ordersn!=''";

							$st = $dbcon->execute($st);

							$st	= $dbcon->getResultArray($st);

							$total	= 0;

							

							

							for($i=0;$i<count($st);$i++){

							

								$qty		= $st[$i]['ebay_amount'];
								$shipingfee		= $st[$i]['shipingfee'];
								

								$qname		= $st[$i]['ebay_itemtitle'];

								$qprice		= $st[$i]['ebay_itemprice'];

								$qitemid	= $st[$i]['ebay_itemid'];

								$sku		= $st[$i]['sku'];
								$notes		= $st[$i]['notes'];
								$total		+= $qty*$qprice;

								

								$ebayid		= $st[$i]['ebay_id'];

							
								$sq3	= "select * from ebay_goods where goods_sn='$sku' and ebay_user='$user'";
		
			
			$sq3	= $dbcon->execute($sq3);
			$sq3	= $dbcon->getResultArray($sq3);
			$goods_weight = $sq3[0]['goods_weight'];


						?>

                        <tr>

                          <td>&nbsp;

                            <input id="pitemid<?php echo $ebayid;?>" name="pitemid<?php echo $ebayid;?>" type="text" size="10" value="<?php echo $qitemid;?>"></td>

                          <td><input id="psku<?php echo $ebayid;?>" name="psku<?php echo $ebayid;?>" type="text" value="<?php echo $sku;?>" size="20" />&nbsp;</td>

                          <td><input id="pname<?php echo $ebayid;?>" name="pname<?php echo $ebayid;?>" type="text" value="<?php echo $qname;?>" size="60"></td>

                          <td><input id="pprice<?php echo $ebayid;?>" name="pprice<?php echo $ebayid;?>" type="text" size="3" value="<?php echo $qprice;?>"></td>

                          <td><input id="sspfee<?php echo $ebayid;?>" name="sspfee<?php echo $ebayid;?>"type="text" size="3" value="<?php echo $shipingfee;?>" /></td>
                          <td>

                            <input id="pqty<?php echo $ebayid;?>" name="pqty<?php echo $ebayid;?>" type="text" size="3" value="<?php echo $qty;?>">                            

                            &nbsp;</td>

                          <td><?php echo $goods_weight;?>&nbsp;</td>
                          <td>
<?php echo $qty*$qprice + $shipingfee;?>              
                          </td>

                          <td><textarea name="notes<?php echo $ebayid;?>" cols="10" rows="3" id="notes<?php echo $ebayid;?>"><?php echo $notes;?></textarea></td>
                          <td>
                          <?php 	if(in_array("orders_modifive",$cpower)){	 ?> 
                          <a href="#" onClick="del('<?php echo $ordersn ?>','<?php echo $ebayid; ?>')">删除</a> 

						      <a href="#" onClick="mod('<?php echo $ordersn ?>','<?php echo $ebayid; ?>')">保存</a>
                          <?php }?>    
                              
                              </td>
                        </tr>

                        

                        <?php 

						}

						?>

                        <tr>

                          <td colspan="7"><div align="right">Postage</div></td>

                          <td><?php echo $fee;?>&nbsp;</td>

                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>

                        <tr>

                          <td colspan="7"><div align="right">Total:</div></td>

                          <td><?php echo $total+$fee;?></td>

                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>

                        <tr>

                          <td colspan="7">添加产品</td>

                          <td>&nbsp;</td>

                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>

                        <tr>
                          <td>ItemId</td>
                          <td>Customer Label</td>
                          <td>Item Title </td>
                          <td>Price</td>
                          <td>Shipping Fee</td>
                          <td>Quantity</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>

                          <td><input name="titemid" type="text" id="titemid" width="20px" /></td>

                          <td><input name="tsku" type="text" id="tsku" size="20" /></td>

                          <td><input name="tname" type="text" id="tname" size="60" /></td>

                          <td><input name="tprice" type="text" id="tprice" size="5" /></td>

                          <td>&nbsp;</td>
                          <td><input name="tqty" type="text" id="tqty" size="5" /></td>

                          <td>&nbsp;</td>
                          <td>&nbsp;</td>

                          <td>&nbsp;</td>
                          <td>
                          
                          <?php 	if(in_array("orders_modifive",$cpower)){	 ?> 
                          <input name="input" onclick="add('<?php echo $ordersn ?>')" type="reset" value="添加新产品" />
                          
                          <?php } ?>
                          <!--<input name="address2" type="button" value="打开产品表" id="address3" onclick="wcustomer0()" />--></td>
                        </tr>

                        <tr>

                          <td colspan="10">订单操作日志：</td>
                        </tr>
                        <tr>
                          <td colspan="10"><table width="100%" border="1">
                            <tr>
                              <td>订单号</td>
                              <td>操作人</td>
                              <td>操作时间</td>
                              <td>备注</td>
                            </tr>
                            <?php
							
							$vv		= "select * from ebay_orderslog where ebay_id ='$ebay_id' and ebay_id != '' order by  operationtime desc ";
							
							
							
							$vv		= $dbcon->execute($vv);
							$vv		= $dbcon->getResultArray($vv);
							for($v=0;$v<count($vv);$v++){
								$operationuser		= $vv[$v]['operationuser'];
								$operationtime		= date('Y-m-d H:i:s',$vv[$v]['operationtime']);
								$notes				= $vv[$v]['notes'];
								$ebay_id			= $vv[$v]['ebay_id'];
							?>
                            <tr>
                              <td><?php echo $ebay_id; ?>&nbsp;</td>
                              <td><?php echo $operationuser; ?>&nbsp;</td>
                              <td><?php echo $operationtime; ?>&nbsp;</td>
                              <td><?php echo $notes; ?>&nbsp;</td>
                            </tr>
                           <?php
						   }
						   ?>
                          </table></td>
                        </tr>

                      </table></td>
                    </tr>
          </table></td>
	</tr>
</table>

          </form>

 

<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>

	<tr class='pagination'>

		<td width="65%"><table width="100%" border="0" cellspacing="1" cellpadding="3">

          <tr>

            <td>编号</td>

            <td>添加时间</td>

            <td>备注</td>

            <td>添加人</td>

            </tr>

            

            <?php 

			

			$sql		= "select * from ebay_ordernote where ordersn='$ordersn' and ordersn != '' ";



	

			$sql		= $dbcon->execute($sql);

			$sql		= $dbcon->getResultArray($sql);

			for($i=0;$i<count($sql);$i++){



				$addtime		= $sql[$i]['addtime'];
				$content			= nl2br($sql[$i]['content']);
				$user			= $sql[$i]['user'];

			?>

            

          <tr>

            <td><?php echo $i+1;?>&nbsp;</td>

            <td><?php echo $addtime;?>&nbsp;</td>

            <td><?php echo $content;?>&nbsp;</td>

            <td><?php echo $user;?>&nbsp;</td>

          </tr>

          <?php

		  

		  }

		  

		  ?>

          <tr>

            <td colspan="4" valign="top">

            <form action="ordermodifive.php?ordersn=<?php echo $ordersn;?>&module=orders&type=<?php echo $type;?>" method="post">

            备注：

              <textarea name="content" cols="60" rows="3" id="content"></textarea>

              <input name="uio" type="submit" id="uio" value="添加">

            </form>

            </td>

            

            </tr>

        </table>&nbsp;</td>

	</tr>

              

		<tr class='pagination'>

		<td>

			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>

				<tr>

					<td nowrap="nowrap" class='paginationActionButtons'></td>

					</tr>

			</table>		</td>

	</tr></table>



 </form>

    <div class="clear"></div>

<?php



include "bottom.php";





?>

<script language="javascript">

	


	function del(ordersn,ebayid){

	

	

		

		if(confirm("确认删除此条记录吗")){

			

			location.href="ordermodifive.php?ordersn=<?php echo $ordersn ?>&ebayid="+ebayid+"&type=del&module=<?php echo $_REQUEST['module'];?>&action=新增订单";

			

		

		

		}

		

	

	

	}

	

	function mod(ordersn,ebayid){

	

		

		

		

		if(confirm("确认修改此条记录吗")){

			

			

			var pname	 = document.getElementById('pname'+ebayid).value;

			var pprice	 = document.getElementById('pprice'+ebayid).value;

			var pqty	 = document.getElementById('pqty'+ebayid).value;

			var psku	 = document.getElementById('psku'+ebayid).value;

			var pitemid	 = document.getElementById('pitemid'+ebayid).value;
			var sspfee	 = document.getElementById('sspfee'+ebayid).value;
			var notes	 = document.getElementById('notes'+ebayid).value;

			

			if(isNaN(pqty)){

				

				alert("数量只能输入数字");

				

			

			}else if(isNaN(pprice)){

				

				alert("价格只能输入数字");


			}else{

			

				location.href="ordermodifive.php?ordersn=<?php echo $ordersn ?>&ebayid="+ebayid+"&type=mod&pname="+encodeURIComponent(pname)+"&pprice="+pprice+"&pqty="+pqty+"&psku="+encodeURIComponent(psku)+"&pitemid="+pitemid+"&module=<?php echo $_REQUEST['module'];?>&action=&sspfee="+sspfee+'&notes='+notes

				

			

			}

					

		}

		

	}

	

	function add(ordersn){

	

		

		var tname		= document.getElementById('tname').value;

		var tprice		= document.getElementById('tprice').value;

		var tqty		= document.getElementById('tqty').value;

		var tsku		= document.getElementById('tsku').value;

		var titemid		= document.getElementById('titemid').value;

		

		if(tsku == ""){

				alert("请输入产品编号");
				document.getElementById('tsku').select();
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

		location.href="ordermodifive.php?ordersn=<?php echo $ordersn ?>&type=add&tname="+encodeURIComponent(tname)+"&tprice="+tprice+"&tqty="+tqty+"&tsku="+encodeURIComponent(tsku)+"&titemid="+titemid+"&module=<?php echo $_REQUEST['module'];?>&action=新增订单";

			

	}

	
	function wcustomer0(){
	
	
		
			openwindow("productslist.php",'',850,785);
	
	
	}
	
	
	
		function openwindow(url,name,iWidth,iHeight)

{

var url; //转向网页的地址;

var name; //网页名称，可为空;

var iWidth; //弹出窗口的宽度;

var iHeight; //弹出窗口的高度;

var iTop = (window.screen.availHeight-30-iHeight)/2; //获得窗口的垂直位置;

var iLeft = (window.screen.availWidth-10-iWidth)/2; //获得窗口的水平位置;

window.open(url,name,'height='+iHeight+',,innerHeight='+iHeight+',width='+iWidth+',innerWidth='+iWidth+',top='+iTop+',left='+iLeft+',toolbar=yes,menubar=yes,scrollbars=yes,resizeable=yes,location=no,status=no');

}
	
		
		function checkwindow(ordersn){
			
			
			
			openwindow("recalcorderweight.php?ordersn="+ordersn,'',300,300);
			
		
		
		
		
		}

function check(){

	
	
	
	var name		= document.getElementById('name').value;
	if(name == ''){
		alert('姓名不能为空');
		document.getElementById('name').value;
		document.getElementById('name').focus();
		return false;
	}
	
	var street1		= document.getElementById('street1').value;
	if(street1 == ''){
		alert('地址一不能为空');
		document.getElementById('street1').value;
		document.getElementById('street1').focus();
		return false;
	}
	

	
	var orderstatus		= document.getElementById('orderstatus').value;
	
	

	if(orderstatus == '' || orderstatus == '-1'){
		alert('订单状态不能为空');
		document.getElementById('orderstatus').value;
		document.getElementById('orderstatus').focus();
		return false;
	}
	
	var ebay_account		= document.getElementById('ebay_account').value;
	if(ebay_account == '' || ebay_account == '-1'){
		alert('订单帐号不能为空');
		document.getElementById('ebay_account').value;
		document.getElementById('ebay_account').focus();
		return false;
	}
	var ebay_warehouse		= document.getElementById('ebay_warehouse').value;
	if(ebay_warehouse == '' || ebay_warehouse == '-1'){
		alert('订单对应出库仓库不能为空');
		document.getElementById('ebay_warehouse').value;
		document.getElementById('ebay_warehouse').focus();
		return false;
	}

}


</script>