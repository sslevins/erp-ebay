<?php
include "include/config.php";
include "include/Aliexpress.class.php";
include "top2.php";
$start		= date('Y-m-d');
$end		= date('Y-m-d');
$start						= date('Y-m-d',strtotime("$end - 1 days"));

error_reporting(E_ALL);


		
		
 ?>
<div id="main">

    <div id="content" >

        <table style="width:100%"><tr><td><div class='moduleTitle'>

<h2><?php echo $_REQUEST['action'].$status;?> </h2>

</div>

 <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>
<div class='listViewBody'>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>

 

<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>

	<tr class='pagination'>

		<td width="65%">

			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>

				<tr>

					<td nowrap="nowrap" class='paginationActionButtons'><table width="100%" height="99" border="0" cellpadding="0" cellspacing="0">

                

			    <form method="post" action="orderloadsmt.php">   

			      <tr>

                    <td width="41%" height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right"> eBay帐号 </div></td>

                    <td width="3%" align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>

                    <td width="56%" height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">

                    <select name="account" id="account">
                    
                    <?php 
					$sql	 = "select ebay_account from ebay_account as a where a.ebay_user='$user' and ($ebayacc) and refresh_token != '' order by ebay_account desc ";
					$sqla	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sqla);
					$dbcon->free_result($sqla);
					
					for($i=0;$i<count($sql);$i++){					
					 	$account	= $sql[$i]['ebay_account'];
					 ?>
                      <option value="<?php echo $account;?>"><?php echo $account;?></option>
                    <?php } ?>
                    <option value="all">同步所有帐号</option>
                    </select></div></td>
                    </tr>

			      <tr>

			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">开始付款时间</td>

			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>

			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">

			          <input name="start" id="start" type="text" onClick="WdatePicker()"  value="<?php echo $start;?>" />

			          </div></td>
			        </tr>

			      <tr>

			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">结束付款时间</td>

			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>

			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="end" id="end" type="text" onClick="WdatePicker()"   value="<?php echo $end;?>" />
			        </div></td>
			        </tr>

			      <tr>

			        <td height="30" align="right" bgcolor="#FF0000" class="left_txt">&nbsp;</td>

			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>

			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        </tr>

                  <tr>
				 </form> 

                    <td height="30" align="right" class="left_txt"><div align="right"></div></td>

                    <td align="right" class="left_txt">&nbsp;</td>

                    <td height="30" align="right" class="left_txt"><div align="left"><input type="button" value="同步" onClick="check()">
                        <input type="button" value="重新分配等待处理的运送方式" onclick="check02()" />
                    </div></td>

                    </tr>       

                </table>

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

<?php

		
		$smtaccount		= $_REQUEST['account'];

		if($smtaccount != ''){
			
			$sql		= "select * from ebay_account where ebay_account='$smtaccount' and ebay_user ='$user'";
			if($smtaccount == 'all'){
			$sql		= "select * from ebay_account where refresh_token!='' and ebay_user ='$user'";
			}
			$sql		= $dbcon->execute($sql);
			$sql		= $dbcon->getResultArray($sql);
			for($i=0;$i<count($sql);$i++){
				
				
				$refresh_token		= $sql[$i]['refresh_token'];
				$ebay_account		= $sql[$i]['ebay_account'];
				$access_token		= $sql[$i]['access_token'];


				$json	=	refreshToken($appKey, $appSecret, $refresh_token, $getTokenUrl2);

				$access_token		= $json['access_token'];





				$aliexpress = new Aliexpress();
				$aliexpress->setConfig($appKey,$appSecret,$refresh_token,$access_token);

				$orderList = $aliexpress->findOrderListQuery();
				$totalDataNum	=	sizeof($orderList);


				$index	=	0;
				if($totalDataNum > 0){
					foreach($orderList as $order){
						$orderDetail2	=	$order['v'];
						$order			=	$order['detail'];
						$pay_time		=	time_shift($order["gmtPaySuccess"]);
						
						$val			=	$ebay_account.$order["id"];
						$val0			=	$order["id"];




						$recordnumber	=	$order["id"];
						$sql	=	"select ebay_id from ebay_order where recordnumber='{$order["id"]}' and ebay_account ='$ebay_account' ";
						$sql	=	$dbcon->execute($sql);
						$res	=	$dbcon->fetch_one($sql);
						if(!empty($res)){
							continue;
						}

						$BuyerUserID			=	$order["buyerSignerFullname"];//$order["buyerInfo"]["loginId"];
						$Emails					=	$order["buyerInfo"]["email"];
						$CreatedTime			=	time_shift($order["gmtCreate"]);
						$PaidTime				=	$pay_time[0];
						$AmountPaid				=	$orderDetail2["payAmount"]["amount"];//付款总金额
						$ShippingServiceCost	=	$order["logisticsAmount"]["amount"]; // 物流费用
						$Currency				=	$order["orderAmount"]["currencyCode"]; 
						$Name					=	$order["receiptAddress"]["contactPerson"];
						$ebay_warehouse			=	$defaultstoreid;
						$eBayPaymentStatus		=	$order["orderStatus"]; //订单状态
						$ebay_addtime			=	time();
						$Street1				=	$order["receiptAddress"]["detailAddress"];
						$Street2				=	isset($order["receiptAddress"]["address2"]) ? $order["receiptAddress"]["address2"] : "";
						$CountryName			=	get_country_name($order["receiptAddress"]["country"]);

						$country				=   $order["receiptAddress"]["country"];
						$PostalCode				=	$order["receiptAddress"]["zip"];
						$StateOrProvince		=	$order["receiptAddress"]["province"];
						$CityName				=	$order["receiptAddress"]["city"];
						if(isset($order["receiptAddress"]["phoneNumber"])){
							if(isset($order["receiptAddress"]["phoneArea"])){
								$Phone			 = $order["receiptAddress"]["phoneCountry"]."-".$order["receiptAddress"]["phoneArea"]."-".$order["receiptAddress"]["phoneNumber"];
								$Phone1			 = isset($order["receiptAddress"]["mobileNo"]) ? $order["receiptAddress"]["mobileNo"]: "";
							}else{
								$Phone			 = $order["receiptAddress"]["phoneNumber"];
								$Phone1			 = isset($order["receiptAddress"]["mobileNo"]) ? $order["receiptAddress"]["mobileNo"]: "";
							}
						}else{
							$Phone				 = $order["receiptAddress"]["mobileNo"];
						}


						$ebay_carrier	=	array();
						$item_notes		=	array();
						$ebay_noteb		=	array();

						foreach($orderDetail2['productList'] as $product){
							$item_notes[$product['orderId']]	=	htmlentities($product['memo'], ENT_QUOTES); //买家留言
							if(!empty($product['memo'])){
								$ebay_noteb[]	=	$item_notes[$product['orderId']];
							}
							if(!in_array($product["logisticsServiceName"],$ebay_carrier)){
								$ebay_carrier[] = $product["logisticsServiceName"];
							}
						}
						$BuyerCheckoutMessage		=	implode(" ",$ebay_noteb);
						$ebay_carrier	= $ebay_carrier[0];


						$sql			 = "INSERT INTO `ebay_order` (`ebay_paystatus`,`ebay_ordersn` ,`ebay_tid` ,`ebay_ptid` ,`ebay_orderid` ,";
						$sql			.= "`ebay_createdtime` ,`ebay_paidtime` ,`ebay_userid` ,`ebay_username` ,`ebay_usermail` ,`ebay_street` ,";
						$sql			.= "`ebay_street1` ,`ebay_city` ,`ebay_state` ,`ebay_couny` ,`ebay_countryname` ,`ebay_postcode` ,`ebay_phone`";
						$sql			.= " ,`ebay_currency` ,`ebay_total` ,`ebay_status`,`ebay_user`,`ebay_shipfee`,`ebay_account`,`recordnumber`,`ebay_addtime`,`ebay_note`,`ebay_site`,`eBayPaymentStatus`,`PayPalEmailAddress`,`ShippedTime`,`RefundAmount`,`ebay_warehouse`,`order_no`)VALUES ('Complete','$val', '$tid' , '$ExternalTransactionID' , '$val0' , '$CreatedTime' , '$PaidTime' , '$BuyerUserID' ,";
						$sql			.= " '$Name' , '$Emails' , '$Street1' , '$Street2' , '$CityName','$StateOrProvince' , '$Country' , '$CountryName' , '$PostalCode' , '$Phone' , '$Currency' , '$AmountPaid' , '1','$user','$ShippingServiceCost','$account','$val0','$mctime','$BuyerCheckoutMessage','$site','$eBayPaymentStatus','$PayPalEmailAddress','$ShippedTime','$RefundAmount','$defaultstoreid','$order_no')";


						echo $sql;
						die();







					}

				}






				$log	=	"-----此次共同步 ".$totalDataNum." 条数据\n";



			}


		}









		function Curl($url,$vars=''){
	$ch=curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_POST,1);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 
	curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($vars));
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
	$content=curl_exec($ch);
	curl_close($ch);
	return $content;
}

/***********************************************************
 *	获取临时token
 */
function getToken2($appKey, $appSecret, $redirectUrl, $code, $getTokenUrl){
	
	$data =array(
		'grant_type'		=>'authorization_code',	
		'need_refresh_token'=>'true',				
		'client_id'			=>$appKey,				
		'client_secret'		=>$appSecret,			
		'redirect_uri'		=>$redirectUrl,			
		'code'				=>$code,
	);
	
	
	
	//过期时间， 一小时
	return	json_decode(Curl($getTokenUrl,$data),true);
}


/************************************************************
 *	获取长效token
 */
function refreshToken($appKey, $appSecret, $refresh_token, $getTokenUrl){
	$data =array(
		'grant_type'		=>'refresh_token',			
		'client_id'			=>$appKey,			
		'client_secret'		=>$appSecret,			
		'refresh_token'		=>$refresh_token,		
	);
	$data['_aop_signature']	=	Sign($data,$appSecret); 
	return json_decode(Curl($getTokenUrl,$data),true);
}


function Sign($vars, $appSecret){
	$str='';
	ksort($vars);
	foreach($vars as $k=>$v){
		$str.=$k.$v;
	}
	return strtoupper(bin2hex(hash_hmac('sha1',$str,$appSecret,true)));
}


function getCode($appKey,$appSecret, $callback_url){
	$getCodeUrl		=	"https://gw.api.alibaba.com/auth/authorize.htm?client_id=".$appKey ."&site=aliexpress&redirect_uri=".$callback_url."&_aop_signature=".Sign(array('client_id' => $appKey,'redirect_uri' =>$callback_url,'site' => 'aliexpress'),$appSecret);
		
	return "<a href='".$getCodeUrl."'>Login</a>";
}


function time_shift($origin_num) { //转换成时间戳
	$time_offset	=	0;
	$i	=	0;
	$i	=	strpos($origin_num,"-");
	
	if($i > 0){
		$temp	=	explode("-", $origin_num);
		$utc	=	intval(preg_replace("/0/","",$temp[1]));
		$time_offset	=	time() - 3600*(8+ $utc);	
	}
	$i	=	0;
	$i	=	strpos($origin_num,"+");
	if($i > 0){
		$temp	=	explode("+", $origin_num);
		$utc	=	intval(preg_replace("/0/","",$temp[1]));
		if($utc > 8){
			$time_offset	=	time() + 3600*($utc - 8);	
		}else{
			$time_offset	=	time() - 3600*(8 - $utc);	
		}
	}
	$time	=	strtotime(substr($origin_num,0,14));
	return array($time, $time_offset);

}

		



include "bottom.php";
?>

<script language="javascript">

	function check(){
		var start	= 	document.getElementById('start').value;
		var end		=	document.getElementById('end').value;
		if(start == ""){
			alert('请选择开始日期');
			return false;
		}
		if(end == ""){
			alert('请选择结束日期');
			return false;
		}
		var account = document.getElementById('account').value;	
		location.href='orderloadsmt.php?account='+account+"&module=orders&action=Loading Orders Results&start="+start+"&end="+end;
	}
	
	
	function check02(){
		var start	= 	document.getElementById('start').value;
		var end		=	document.getElementById('end').value;
		if(start == ""){
			alert('请选择开始日期');
			return false;
		}
		if(end == ""){
			alert('请选择结束日期');
			return false;
		}
		var account = document.getElementById('account').value;	
		location.href="orderloadstatus.php?type=resend&module=orders&action=Loading Orders Results&start="+start+"&end="+end;
	}

	function checkall(){
		var start	= 	document.getElementById('start').value;
		var end		=	document.getElementById('end').value;
		if(start == ""){
			alert('请选择开始日期');
			return false;
		}
		if(end == ""){
			alert('请选择结束日期');
			return false;
		}
		var url	= 'orderloadstatus.php?start='+start+"&end="+end+"&type=loadall&module=orders&action=Message同步";
		location.href = url;
	}

</script>