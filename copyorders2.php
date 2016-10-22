<?php include "include/config.php"; 
	
	$ordersn	= $_REQUEST['ordersn'];
	$ordersn1	= $_REQUEST['ordersn'];

	
	if($_POST['submit']){
		
		
		$val				= $Sordersn."-".date('Y')."-".date('m')."-".date('d')."-".date("H").date('i').date('s'). mt_rand(100, 999);
		$val				=  mt_rand(100000000, 999999999). mt_rand(100, 999);
			


		while(true){

				$si		= "select * from ebay_rand where ordersn='$val'";
				$si		= $dbcon->execute($si);
				$si		= $dbcon->getResultArray($si);
				if(count($si)==0) break;
				$val				= $Sordersn."-".date('Y')."-".date('m')."-".date('d')."-".date("H").date('i').date('s'). mt_rand(100, 999);
				$val				=  mt_rand(100000000, 999999999). mt_rand(100, 999);
				
		}
			$so		= "insert into ebay_rand(ordersn) values('$val')";				
			$dbcon->query($so);
						
		
		$orderstatus	= $_POST['orderstatus'];
		
		$ss		= "select * from ebay_order where ebay_ordersn='$ordersn' ";
		$ss		= $dbcon->execute($ss);
		$ss		= $dbcon->getResultArray($ss);
		
		
		$ebay_paystatus			= $ss[0]['ebay_paystatus'];
		$recordnumber			= $ss[0]['recordnumber'];
		$ebay_tid				= $ss[0]['ebay_tid'];
		$ebay_ptid				= $ss[0]['ebay_ptid'];
		$ebay_warehouse				= $ss[0]['ebay_warehouse'];
		$ordershipfee				= $ss[0]['ordershipfee'];
		$orderweight				= $ss[0]['orderweight'];
		if($orderweight==0)
		{
		$orderweight='';}
		$ebay_orderid			= $ss[0]['ebay_orderid'];
		$ebay_orderid2          = mb_substr($ordersn,0,12,'utf-8');
		$ebay_ordersn			= $ebay_orderid2.'-'.$val;
		$ebay_createdtime			= strtotime($_POST['ebay_createdtime']);
		$ebay_paidtime			= strtotime($_POST['ebay_paidtime']);
		$ebay_userid			= $_POST['userid'];
		$ebay_username			= $_POST["name"];
		$ebay_street				= str_rep($_POST['street1']);
		$ebay_street1				= str_rep($_POST['street2']);
		$ebay_city				= str_rep($_POST['city']);
		$ebay_state				= str_rep($_POST['state']);
		$ebay_countryname				= $_POST['ebay_countryname'];
		$ebay_phone			= $_POST["tel"];
		$ebay_postcode			= $_POST["zip"];
		$ebay_usermail			= $_POST["ebay_usermail"];
		$ebay_couny				= $ss[0]['ebay_couny'];
		$ebay_currency			= $ss[0]['ebay_currency'];
		$ebay_total				= $ss[0]['ebay_total'];
		$ebay_status			= $orderstatus;
		$ebay_user				= $ss[0]['ebay_user'];
		$ebay_shipfee			= $ss[0]['ebay_shipfee'];
		$ebay_account			= $ss[0]['ebay_account'];
		$eBayPaymentStatus		= $ss[0]['eBayPaymentStatus'];
		$PayPalEmailAddress		= $ss[0]['PayPalEmailAddress'];
		$ebay_carrier					= $ss[0]['ebay_carrier'];
		$ebay_noteb				= "";
		$sq0	=  "insert into ebay_order(ebay_ordersn,ebay_paystatus,recordnumber,ebay_tid,ebay_ptid,ebay_orderid,ebay_createdtime,ebay_paidtime,ebay_userid,ebay_warehouse,orderweight,ordershipfee,";
		$sq0	.= "ebay_username,ebay_usermail,ebay_street,ebay_street1,ebay_city,ebay_state,ebay_couny,ebay_countryname,ebay_postcode,ebay_phone,ebay_currency,";
		$sq0	.= "ebay_total,ebay_status,ebay_user,ebay_shipfee,ebay_account,eBayPaymentStatus,PayPalEmailAddress,ebay_noteb,ebay_carrier)values(";
		$sq0    .= "'$ebay_ordersn','$ebay_paystatus','$recordnumber','$ebay_tid','$ebay_ptid','$ebay_orderid','$ebay_createdtime','$ebay_paidtime','$ebay_userid','$ebay_warehouse','$orderweight','$ordershipfee',";
		$sq0	.= "'$ebay_username','$ebay_usermail','$ebay_street','$ebay_street1','$ebay_city','$ebay_state','$ebay_couny','$ebay_countryname','$ebay_postcode','$ebay_phone','$ebay_currency',";
		$sq0	.= "'$ebay_total','$ebay_status','$ebay_user','$ebay_shipfee','$ebay_account','$eBayPaymentStatus','$PayPalEmailAddress','$ebay_noteb','$ebay_carrier')";
		$ss		= "select * from ebay_orderdetail where ebay_ordersn = '$ordersn1'";
		$ss		= $dbcon->execute($ss);
		$ss		= $dbcon->getResultArray($ss);
		$runstatus		= 0;
		for($i=0; $i<count($ss);$i++){
			$recordnumber					= $ss[$i]['recordnumber'];
			$ebay_itemid					= $ss[$i]['ebay_itemid'];
			$ebay_itemtitle					= mysql_escape_string($ss[$i]['ebay_itemtitle']);
			$ebay_itemurl					= $ss[$i]['ebay_itemurl'];
			$sku							= $ss[$i]['sku'];
			$ebay_itemprice					= $ss[$i]['ebay_itemprice'];
			$ebay_amount					= $ss[$i]['ebay_amount'];
			$ebay_createdtime				= $ss[$i]['ebay_createdtime'];
			$ebay_shiptype					= mysql_escape_string($ss[$i]['ebay_shiptype']);
			$ebay_user					= $ss[$i]['ebay_user'];
			$shipingfee					= $ss[$i]['shipingfee'];
			$ebay_account				= $ss[$i]['ebay_account'];
			$ebay_site					= $ss[$i]['ebay_site'];
			$FinalValueFee				= $ss[$i]['FinalValueFee'];
			$FeeOrCreditAmount			= $ss[$i]['FeeOrCreditAmount'];
			$attribute					= $ss[$i]['attribute'];
			$sourceorder				= $ss[$i]['sourceorder'];
			$ListingType				= $ss[$i]['ListingType'];
			$s2	= "insert into ebay_orderdetail(recordnumber,ebay_ordersn,ebay_itemid,ebay_itemtitle,ebay_itemurl,sku,ebay_itemprice,ebay_amount,";
			$s2.= "ebay_createdtime,ebay_shiptype,ebay_user,shipingfee,ebay_account,ebay_site,FinalValueFee,FeeOrCreditAmount,attribute,sourceorder,ListingType)";
			$s2.="values('$recordnumber','$ebay_ordersn','$ebay_itemid','$ebay_itemtitle','$ebay_itemurl','$sku','$ebay_itemprice','$ebay_amount','$ebay_createdtime','$ebay_shiptype','$ebay_user','$shipingfee','$ebay_account','$ebay_site','$FinalValueFee','$FeeOrCreditAmount','$attribute','$sourceorder','$ListingType')";
			if($dbcon->execute($s2)){
				
				$runstatus		= 1;
				
			
			}
			
			
		
		
		}
		
		if($runstatus == 1){
		
			
			if($dbcon->execute($sq0)){
			
				
				echo "订单copy 成功";
				
				$url		= "ordermodifive.php?ordersn=$val&module=orders&ostatus=1&action=Modifive%20Order";
				
				header("Location: $url");
				
			}else{
			
				
				echo "订单copy 失败";
			
			}
		
		}
		

		
	}




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>订单复制</title>
</head>

<body>

<form id="ad" name="ad" method="post" action="copyorders2.php?ordersn=<?php echo $ordersn;?>">
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td>复制后的订单状态为：</td>
    <td><select name="orderstatus">
    
    
     <option value="0" <?php  if($oost == "0")  echo "selected=selected" ?>>待付款订单</option>
                            <option value="1" <?php  if($oost == "1")  echo "selected=selected" ?>>待处理订单</option>
                                                     
                            <?php
                            $ss		= "select * from ebay_topmenu where ebay_user='$user' and name!= '' order by ordernumber";
							$ss		= $dbcon->execute($ss);
							$ss		= $dbcon->getResultArray($ss);
							for($i=0;$i<count($ss);$i++){
								$ssid		= $ss[$i]['id'];
								$ssname		= $ss[$i]['name'];
							?>
                            <option value="<?php echo $ssid; ?>" <?php  if($oost == $ssid)  echo "selected=selected" ?>><?php echo $ssname; ?></option>
                            <?php } ?> 
                             <option value="2" <?php  if($oost == "2")  echo "selected=selected" ?>>已经发货</option>
                            
                            
    </select></td>
    <td><input name="submit" type="submit" value="确认复制" id="address" onclick="return check()" /></td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="100%" cellspacing="5">
  <tr>
    <td>Full name</td>
    <td><input name="name" type="text" id="name" value="" /></td>
    <td>客户ID</td>
    <td><input name="userid" type="text" id="userid" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Street1</td>
    <td><input name="street1" type="text" id="street1" /></td>
    <td>Mail</td>
    <td><input name="ebay_usermail" type="text" id="ebay_usermail" value="" style="width:250px"  /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Street2</td>
    <td><input name="street2" type="text" id="street2" /></td>
    <td>购买时间</td>
    <td><input name="ebay_createdtime" type="text" id="ebay_createdtime" onclick="WdatePicker()" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>City</td>
    <td><input name="city" type="text" id="city" /></td>
    <td>Postcode</td>
    <td><input name="zip" type="text" id="zip" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>State</td>
    <td><input name="state" type="text" id="state" /></td>
    <td>Tel</td>
    <td><input name="tel" type="text" id="tel" /></td>
    <td rowspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Country</td>
    <td><input name="ebay_countryname" type="text" id="ebay_countryname" /></td>
    <td>支付时间</td>
    <td><input name="ebay_paidtime" type="text" id="ebay_paidtime" onclick="WdatePicker()" /></td>
  </tr>
</table>
</form>
 <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>
</body>
</html>
