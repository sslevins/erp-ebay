<?php
include "include/config.php";
 	if ($_REQUEST['action']=='orders_log')
     {
	 $loger=$_REQUEST['loger'];
	 $oID=$_REQUEST['oID'];
   addordernote($oID,$loger); 
  	  	echo "ok";
		die();
	 }
	 
	 if (  $_REQUEST['action']=='orders_order')
     {
	 	 $logerx=" "+$_REQUEST['logerx'];
	 $loger=$_REQUEST['loger'];
	 $oID= $_REQUEST['oID'];
	 	 $sqlst="select * from ebay_order where ebay_id =$oID";
//$rsst=db_execute($sqlst);
//$erp_op_id=$rsst['erp_op_id'];
//print_r($rsst);
//echo $ebaycase;
 	 if ($loger==1){$logerr=" 无法追踪 ";$types=10;}
	 if ($loger==1 && $erp_op_id==1){$logerr=" 能够追踪 ";$types=0;} 
	 if ($loger==5){$logerr=" 没有妥投 ";$types=12;}	
	 if ($loger==6){$logerr=" 妥投错误 ";$types=11;}
	 	 if ($loger==6 && $erp_op_id==6){$logerr=" 妥投正确 ";$types=0;} 
	 	 if ($loger==5 && $erp_op_id==5){$logerr=" 已经妥投 ";$types=0;} 

	 if ($loger==7){$logerr=" 中国妥投 "; $types=12;}
	 if ($loger==2){$logerr=" 已回公司 ";$types=13;}
	 
   if ($erp_op_id==1 ){$loger=0;} 
   if ($erp_op_id==5){$loger=0;} 
   if ($erp_op_id==6){$loger=0;} 
   

	 	$dbcon->execute("update ebay_order  set  erp_op_id=".$loger." where ebay_id =".$oID);


 	 /*  mysql_query(
"INSERT INTO erp_ebay_log (
id,
erp_orders_id,
cotent,writetime,writeer,types
)
VALUES (
NULL , '".$oID."', '".$logerr."','".
date('Y-m-d H:i:s',time())."',".$_COOKIE['id'].",".$types.")");
   $loger_id=mysql_insert_id();
	 mysql_query("update erp_orders  set  erp_op_id=".$loger." where erp_orders_id =".$oID);
*/	
  // mysql_query( "update erp_ebay_log set cotent=concat(cotent,'" ." ".$_GET['logerx'] ."') where id =$loger_id");
    addordernotesf($oID,$logerr,$types); 
 
  	 echo "ok";
		die();
	 }
	 
	 
	 
	
		 if (  $_REQUEST['action']=='orders_moneyback')
	{	  $logerr=$_REQUEST['loger'];
	 $oID=$_REQUEST['oID'];
	  $uid=$_REQUEST['feedback'];
	 $logerx=$_REQUEST['logerx'];
	 $loger=0;
	 	if ( $uid==1){$logers=" 确认退款 ".$logerr." " .$logerx;$types=20;}
	 	 if ($loger==0 && $uid==2){$logers=" 取消退款 ".$logerr." " . $logerx;$types=26;}
		  if ($loger==0 && $uid==8){$logers=" 同意退款 ".$logerr." " . $logerx;$types=27;}
	 	 if ($loger==0 && $uid==9){$logers=" 同意付款 ".$logerr." " . $logerx;$types=28;}
		  if ($loger==0 && $uid==10){$logers=" 完成退款 ".$logerr." " . $logerx;$types=29;}
 	 
   if ($uid==1){
	 $dbcon->execute("update ebay_order  set  moneyback=2  where ebay_id =".$oID);
 	 } if ($uid==2){
	  $dbcon->execute("update ebay_order  set  moneyback=3 ,moneyback_total=".$logerr." where ebay_id =".$oID);
	 }
	if ($uid==8){
	$loger.=" 同退  ".$moneyback;
	  $dbcon->execute("update ebay_order  set  moneyback=8 ,moneyback_total=".$logerr." where ebay_id =".$oID);
	 }
	 if ($uid==9){
	  $dbcon->execute("update ebay_order  set  moneyback=9 ,moneyback_total=".$logerr." where ebay_id =".$oID);
	 }
	 if ($uid==10){
	  $dbcon->execute("update ebay_order  set  moneyback=10 ,moneyback_total=".$logerr." where ebay_id =".$oID);
 	 }
       addordernotesf($oID,$logers,$types); 

	 echo "ok";
		die();
		}

	 if (  $_REQUEST['action']=='orders_feedback')
     {
	 $loger=$_REQUEST['loger'];
	 $logerx=" "+$_REQUEST['logerx'];
	 $oID=$_REQUEST['oID'];
	  $uid=$_REQUEST['feedback'];
	  $moneyback=$_REQUEST['moneyback'];
 	  if ($uid==1){
	  $types=20;
	  //申请退款
	  $loger="申请退款 要退  ".$moneyback ." ".$loger;
   	 		 $dbcon->execute("update ebay_order  set  moneyback =1, moneyback_total ='".$moneyback."' where ebay_id =".$oID);

	 }
	 	  if ($uid==2){
 //$feedback=$rsst['feedback'];
   if ($feedback==0){$feedback=1; $loger="    登记中评 " .$loger; $types=21;}else{$feedback=0; $loger="    取消中评 ".$loger;$types=0;}
	 // mysql_query("update ebay_order  set  feedback=$feedback ,orders_feedback_time  = '".date('Y-m-d H:i:s',time())."'  where erp_orders_id =".$oID);
	 }
	 
	   if ($uid==20){   	 
//$sqlst="select * from ebay_order where ebay_id =$oID";
//$rsst=db_execute($sqlst);
//$feedback=$rsst['feedback'];
   if ($feedback==0){$feedback=10; $loger="    登记差评 " .$loger;$types=36;}else{$feedback=0; $loger="    取消差评 ".$loger;$types=0;}
	// mysql_query("update erp_orders  set  feedback=$feedback ,orders_feedback_time  = '".date('Y-m-d H:i:s',time())."'   where erp_orders_id =".$oID);
	 }
	 
	 if ($uid==18){
	  //$sqlst="select * from erp_orders where erp_orders_id =$oID";
//$rsst=db_execute($sqlst);
//$feedback=$rsst['erp_op_id'];
if ($feedback!=18){$feedback=18; $loger="    发送账单 " ; $types=55;}else{$feedback=0; $loger="    已发账单 ";$types=5;}
 	 $dbcon->execute("update ebay_order  set  erp_op_id=$feedback    where ebay_id =".$oID);
	 }
	 if ($uid==28){
	  
  //黑名单
//、$url="  bookbackoreradd.php?id=&module=customer&ordersn=2012-05-28-163653543202422";
 
	 }
 	 
	  if ($uid==8){
//   $sqlst="select * from erp_orders where erp_orders_id =$oID";
//$rsst=db_execute($sqlst);
//$feedbacks=$rsst['feedback'];
     if ($feedbacks!=8){$feedback=8; $loger="    修改链接 " .$loger; $types=8;}if ($feedbacks==8){$feedback=90; $loger="    浪费链接 ".$loger;$types=18;}
	// mysql_query("update ebay_order  set  feedback=$feedback ,orders_feedback_time  = '".date('Y-m-d H:i:s',time())."'  where erp_orders_id =".$oID);
 
  	 }
	   if ($uid==9){
	   
	//   $sqlst="select * from erp_orders where erp_orders_id =$oID";
//$rsst=db_execute($sqlst);
//$feedback=$rsst['feedback'];
    if ($feedback==0   ){$feedback=9; $loger="    等待处理 " ;$types=35;}else{$feedback=0; $loger="    完成处理 ";$types=95;}
   //	 mysql_query("update ebay_order  set  feedback=$feedback   where ebay_id =".$oID);
	 }
 	 	  if ($uid==3){
		  	  	   	 
// $sqlst="select * from erp_orders where erp_orders_id =$oID";
//$rsst=db_execute($sqlst);
//$ebaycase=$rsst['ebaycase'];
 
 
   if ($ebaycase==0){$ebaycase=1; $loger="    登记Ebay case " .$loger;$types=22;}else{$ebaycase=0; $loger="    取消Ebay case ".$loger;$types=0;}
	  $dbcon->execute("update ebay_order  set  ebay_case=$ebaycase ,orders_ecase_time  = '".$mctime."'    where  ebay_id =".$oID);
	 }
	 
	 	 if ($uid==38){
	  //$sqlst="select * from erp_orders where erp_orders_id =$oID";
//$rsst=db_execute($sqlst);
//$feedback=$rsst['erp_op_id'];
if ($feedback!=38){$feedback=38; $loger="    索要信息 " ; $types=66;}else{$feedback=0; $loger="    提供信息 ";$types=6;}
//	 mysql_query("update erp_orders  set  erp_op_id=".$feedback ."   where erp_orders_id =".$oID);
	 	 

	 }
	 
	 
	 	  if ($uid==4){
		  	  	   	 
// $sqlst="select * from erp_orders where erp_orders_id =$oID";
//$rsst=db_execute($sqlst);
//$paypalcases=$rsst['paypalcase'];
   if ($paypalcases==1){$paypalcase=2;  $loger ="  PayPalCase升级 " .$loger;$types=0;}

  if ($paypalcases==0){$paypalcase=1; $loger="  登记PaypalCase " .$loger;$types=23;}
       if ($paypalcases==2){$paypalcase=0;  $loger ="  取消PaypalCase " .$loger;$types=0;}

	  $dbcon->execute("update ebay_order  set  paypal_case=$paypalcase ,orders_pcase_time  = '".$mctime."'    where ebay_id =".$oID);
	 }
	 if ($uid==5){
 	  $loger ="  追回退款  ".$moneyback ." ".$loger;$types=30;
  $dbcon->execute("update ebay_order  set  moneyback=5,moneyback_total=".$moneyback." where ebay_id =".$oID);
  
	 }
	 	 if ($uid==6){
		 	  	   	  $loger ="  查询付款  ".$moneyback ." ".$loger;$types=31;

	  $dbcon->execute("update ebay_order  set  moneyback=6,moneyback_total=".$moneyback."    where ebay_id =".$oID);
	 }
	 	 if ($uid==7){
		 		 	  	   	  $loger ="  确定收款  ".$moneyback ." ";$types=32;

	 //mysql_query("update erp_orders  set  moneyback=7,moneyback_total=".$moneyback."   where erp_orders_id =".$oID);
		
	$sqlst="select * from erp_orders where erp_orders_id =$oID";
//$rsst=db_execute($sqlst);
//$currency_value=$rsst['currency_value'];
//$sales_account=$rsst['sales_account'];
	$isql=" INSERT INTO  `erp_reback_money` (
`id` ,
`erp_orders_id` ,
`sales_account` ,
`total` ,
`type` ,
`addtime` ,
`currency_value` 
)
VALUES (
NULL , '".$oID."', '".$sales_account."', '".$moneyback."', '7', '".date('Y-m-d H:i:s',time())."', '".$currency_value."'
)";
// mysql_query($isql);
	 }
	 if ($uid==11){
		 		 	  	   	  $loger ="  没有付款  ".$moneyback ." ".$loger;

	  $dbcon->execute("update ebay_order  set  moneyback=11,moneyback_total=".$moneyback."   where ebay_id =".$oID);
		
	$sqlst="select * from erp_orders where erp_orders_id =$oID";
//$rsst=db_execute($sqlst);
//$currency_value=$rsst['currency_value'];
//$sales_account=$rsst['sales_account'];
	$isql=" INSERT INTO  `erp_reback_money` (
`id` ,
`erp_orders_id` ,
`sales_account` ,
`total` ,
`type` ,
`addtime` ,
`currency_value` 
)
VALUES (
NULL , '".$oID."', '".$sales_account."', '".$moneyback."', '11', '".date('Y-m-d H:i:s',time())."', '".$currency_value."'
)";
// mysql_query($isql);
	 }
	 
        addordernotesf($oID,$loger,$types); 

   	   	echo "ok";
		die();
	 }
	 
	 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Message</title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/yui.css" />
<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/deprecated.css" />
<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/style.css" /> 
<style type="text/css">
<!--
.STYLE1 {font-size: 14px}
-->
</style>
</head>
<body>

 <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" bordercolor="#999999" bgcolor="#CCCCCC">

  <tr>

    <td colspan="3" bgcolor="#FFFFFF">您所选批回复Message列表如下:</td>
  </tr>

  <?php

  		$messageid	= explode(",",$_REQUEST['messageid']);
		$g	= 0;	

		for($i=0;$i<count($messageid);$i++){		

			$mid	= $messageid[$i];
			if($mid	!= ""){

			$sql 			=	"select * from ebay_message where message_id='$mid'";
			$sql 			= 	$dbcon->execute($sql);
			$sql			= 	$dbcon->getResultArray($sql);
			$userid			=   $sql[0]['sendid'];
			$id				=   $sql[0]['id'];
			$subject		=   $sql[0]['subject'];
			$rtime			=   $sql[0]['createtime'];
			$recipientid 	=   $sql[0]['recipientid'];
			$body			=   $sql[0]['body'];
			$body		  	=   str_replace("&acute;","'",$body);
			$body  			=   str_replace("&quot;","\"",$body);
			$itemid			=   $sql[0]['itemid'];
			$title			=   $sql[0]['title'];
			$answer			=   $sql[0]['replaycontent'];
			$sts			=   $sql[0]['status']?"<font color=red>已回复</font>":"未回复";
			$classid		=   $sql[0]['classid'];
			$addmid			.= $mid."**";
			$g++;

						

  ?>

  <tr>

    <td colspan="3" bgcolor="#FFFFFF">


        <table width="100%" border="0" cellspacing="2" cellpadding="2" id="table<?php echo $mid;?>">

          <tr>

            <td><div class="STYLE1" style="width:70px">发件人</div></td>

            <td colspan="2"><span class="STYLE1"><?php echo $userid; ?> </span></td>
          </tr>
          <tr>
            <td colspan="3"><div style=" border-bottom:2px  solid #000000; height:1px"></div></td>
            </tr>

          <tr>

            <td width="67"><span class="STYLE1">收件人</span></td>

            <td colspan="2"><span class="STYLE1"><?php echo $recipientid; ?></span></td>
          </tr>
     <tr>
            <td colspan="3"><div style=" border-bottom:2px  solid #000000; height:1px"></div></td>
            </tr>
          <tr>

            <td width="67"><span class="STYLE1">产品：</span></td>

            <td width="733"><span class="STYLE1"><?php echo "<a href=http://cgi.ebay.com/ws/eBayISAPI.dll?ViewItem&item={$itemid} target=_blank>".$title."</a>"; ?></span></td>

            <td width="498"><span class="STYLE1"><?php echo "Itemid:".$itemid; ?></span></td>
          </tr>
     <tr>
            <td colspan="3"><div style=" border-bottom:2px  solid #000000; height:1px"></div></td>
            </tr>
          <tr>

            <td width="67"><span class="STYLE1">主题</span></td>

            <td colspan="2"><span class="STYLE1"><?php echo nl2br($subject); ?></span></td>
          </tr>
     <tr>
            <td colspan="3"><div style=" border-bottom:2px  solid #000000; height:1px"></div></td>
            </tr>
          <tr>

            <td width="67" valign="top"><span class="STYLE1">内容</span></td>

            <td valign="top">

<div style="height:300px; width:700px; overflow-x:auto; overflow-y:auto; border:1px">
<span class="STYLE1"><?php 

$body			= str_replace('<style type="text/css"/>','',$body);
$body			= str_replace('<style type="text/css" id="owaParaStyle"/>','',$body);
echo $body;

?></span></div>			</td>

            <td valign="top">
            
            <div style=" height:300px; width:500px; overflow-x:auto; overflow-y:auto; border:1px">
         <?php 

		

		
/*


		$sy 			=	"select * from ebay_message as a  where sendid='$userid' and id!=$id and ebay_account ='$recipientid'";


		echo $sy;
		
		
		$sy				= 	$dbcon->execute($sy);
		$sy				= 	$dbcon->getResultArray($sy);
		if(count($sy) != 0){			


			for($o=0;$o<count($sy);$o++){

				$body			= $sy[$o]['body'];
				$body		  	= str_replace("&acute;","'",$body);
				$body  			= str_replace("&quot;","\"",$body);
				$str			= "记录".($o+1)." 接收时间：".$sy[$o]['createtime']."Itemid:".$sy[$o]['itemid']." <br>产品标题:".$sy[$o]['title'];
				echo '<div style="border:1px dashed #CC00CC; height:50px"><h1><strong>'.$str.'</strong></h1></div>';
				echo "eBay Account: ".nl2br($sy[$o]['recipientid'])."<br>";
				echo "主题: ".nl2br($sy[$o]['subject'])."<br>";
				echo "内容: ".'<span class="STYLE1">'.nl2br($body)."</span><br>";
				echo "已回复内容:<br><font color=blue>".nl2br($sy[$o]['replaycontent'])."</font><br>";
				
			}
			
		}
		
		
		$an		= substr($answer,0,1);
		
		if($an		== '?') $answer		= substr($answer,1);
		
	

	*/
	

	?>
            </div></td>
          </tr>
     <tr>
            <td colspan="3"><div style=" border-bottom:2px  solid #000000; height:1px"></div></td>
            </tr>
          <tr>

            <td width="67"><span class="STYLE1">回复内容</span></td>

            <td colspan="2"><span class="STYLE1"><strong><font color="blue"><?php echo nl2br($answer) ?></font></span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>回复内容:<br />
                  <textarea name="content<?php echo $mid; ?>" cols="120" rows="15" id="content<?php echo $mid; ?>"></textarea>
                  <div name="mstatus<?php echo $mid;?>" id="mstatus<?php echo $mid;?>" style="font-size:24px; color:#0033CC"></div><br />
                  <input name="mailsent<?php echo $mid; ?>" type="checkbox" id="mailsent<?php echo $mid; ?>" value="1" checked="checked" />
抄送到卖家邮箱
<input name="submit2" type="button" value="回复" onclick="return check('<?php echo $mid;?>')"  />
<input name="input5" type="button" value="标为已回复" onclick="marketyh('<?php echo $mid;?>','3')" />
<input name="input2" type="button" value="保存为草稿" onclick="marketyh('<?php echo $mid;?>','2')" />
将此Message转到
<select name="mm2<?php echo $mid;?>" id="mm2<?php echo $mid;?>" onchange="classid('<?php echo $mid;?>')">
  <option value="0">请选择</option>
  <?php	

		$so	= "select category_name,id from ebay_messagecategory where ebay_user='$user'";	
		$so	= $dbcon->execute($so);
		$so = $dbcon->getResultArray($so);		
		for($ii=0;$ii<count($so);$ii++){			
			$cname		= $so[$ii]['category_name'];
			$cid		= $so[$ii]['id'];		
	   ?>
  <option <?php if($type == $cid) echo "selected" ?> value="<?php echo $cid;?>"><?php echo $cname; ?></option>
  <?php }  ?>
</select>
分类	&nbsp;
<input name="input" type="button" value="关闭" onclick="closes('<?php echo $mid;?>')" /></td>
                <td><p><br />
                  常用模板: <br />
  <br />
<?php
	$su		= "select name,content from ebay_messagetemplate where ebay_user='$user' and category='常用模板' order by ordersn desc";
	$su		= $dbcon->execute($su);
	$su		= $dbcon->getResultArray($su);
	for($o=0;$o<count($su);$o++){
		$name		= $su[$o]['name'];
		$content	= $su[$o]['content'];
		echo "<input name=\"nc$mid\" type=\"radio\" value=\"$content\" onclick=ck(this,'$mid','$userid') /> $name <br>";
	}
?>
                </p>
                  <p>一般模板</p>
                  <p>
                    <select name="category<?php echo $mid;?>" id="category<?php echo $mid;?>" onchange="ck(this,'<?php echo $mid ?>','<?php echo $userid; ?>')">
                      <option value="">请选择</option>
                      <?php

	

		$su		= "select name,content from ebay_messagetemplate where ebay_user='$user' and category='一般模板' order by ordersn desc";
		$su		= $dbcon->execute($su);
		$su		= $dbcon->getResultArray($su);
		for($o=0;$o<count($su);$o++){
			$name		= $su[$o]['name'];
			$content	= $su[$o]['content'];
		?>
                      <option value="<?php echo $content; ?>"><?php echo $name;?></option>
         <?php } ?>
                    </select>
                    <br />
                    <?php 
				  
				  	$kk = "select name,id from ebay_templatecategory  ";
					$kk = $dbcon->execute($kk);
					$kk = $dbcon->getResultArray($kk);
					for($k=0;$k<count($kk);$k++){
						$kname 	= $kk[$k]['name'];
						$kid 	= $kk[$k]['id'];
						echo "<br>".$kname;	
				  ?>
                    <br />
                    <select name="category<?php echo $mid;?>" id="category<?php echo $mid;?>" onchange="ck(this,'<?php echo $mid ?>','<?php echo $userid; ?>')">
                      <option value="">请选择</option>
                      <?php

		$su		= "select name,content from ebay_messagetemplate where ebay_user='$user' and category='$kname' order by ordersn desc";
		$su		= $dbcon->execute($su);
		$su		= $dbcon->getResultArray($su);
		for($o=0;$o<count($su);$o++){
			$name		= $su[$o]['name'];
			$content	= $su[$o]['content'];	

		?>
                      <option value="<?php echo $content; ?>"><?php echo $name;?></option>
                      <?php } ?>
                    </select>
                    <?php
				  
				  }
				  
				  ?>
                  </p><br />

                </td>
                <td>客户订单信息: :<a href="orderindex.php?keys=<?php echo $userid;?>&amp;account=&amp;sku=&amp;module=orders&amp;action=所有订单&amp;ostatus=100&amp;searchtype=1" target='_blank'>查看该客户的所有订单信息</a><br />
                  <table width="100%" border="0" cellpadding="3" cellspacing="1" bordercolor="#000000" bgcolor="#000000">
                    <tr>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">Sale record&nbsp;</td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">Buyer ID&nbsp;</td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">Item No&nbsp;</td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">Sku</td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">Qty</td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">总金额</td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">运送时间</td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">状态</td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">跟踪号</td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">付款</td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">评价</td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">操作</td>
                    </tr>
                    <?php

		$ss		= "select * from ebay_order as a  where a.ebay_userid = '$userid' and ebay_account ='$recipientid' and a.ebay_combine!='1' order by recordnumber desc";
		$ss		= $dbcon->execute($ss);
		$ss		= $dbcon->getResultArray($ss);		
		for($t=0;$t<count($ss);$t++){
			
			$ebay_shipfee				= $ss[$t]['ebay_shipfee'];
			$ebay_id 					= $ss[$t]['ebay_id'];
			$ebay_ordersn				= $ss[$t]['ebay_ordersn'];
			$ebay_userid				= $ss[$t]['ebay_userid'];
			$ebay_status				= $ss[$t]['ebay_status'];
			$icdd						= $ebay_userid;
			
			
			
			$orderstatus				= '';			
			if($ebay_status		== '0'){				
				$orderstatus		= '等待付款';			
			}elseif($ebay_status	== '1'){				
				$orderstatus		= '已付款';			
			}elseif($ebay_status	== '2'){			
				$orderstatus		= '已付款，已发出';
			}else{			
				$si						= "select * from ebay_topmenu where id='$ebay_status'";
				$si						= $dbcon->execute($si);
				$si						= $dbcon->getResultArray($si);
				$orderstatus			= $si[0]['name'];	
			}			
			$recordnumber				= $ss[$t]['recordnumber'];
			$ebay_account				= $ss[$t]['ebay_account'];
			$ebay_paidtime				= $ss[$t]['ebay_paidtime'];
			$ShippedTime				= $ss[$t]['ShippedTime'];
			$RefundAmoun				= $ss[$t]['RefundAmoun'];
			$ebay_tracknumber				= $ss[$t]['ebay_tracknumber'];		
			$ebay_ordersn				= $ss[$t]['ebay_ordersn'];
			$ebay_tracknumber				= $ss[$t]['ebay_tracknumber'];
			
			
			$moneyback_total= $ss[$t]['moneyback_total'];
			$ebay_paystatus			= trim($ss[$t]['ebay_paystatus']);
			$eBayPaymentStatus		= 		 $ss[$t]['eBayPaymentStatus'];
 			$ebay_currency			= trim($ss[$t]['ebay_currency']);
			$erp_op_id= $ss[$t]['erp_op_id'];
			$ebay_feedback		= $ss[$t]['ebay_feedback'];
			$imgsrc						= '';
			
					if($ebay_feedback == 'Positive') $imgsrc = '<img src="images/iconPos_16x16.gif" width="16" height="16" />';
					if($ebay_feedback == 'Negative') $imgsrc = '<img src="images/iconNeg_16x16.gif" width="16" height="16" />';
					if($ebay_feedback == 'Neutral')  $imgsrc = '<img src="images/iconNeu_16x16.gif" width="16" height="16" />';
					
					
			
			$paidsrc				= '';
					
					if($eBayPaymentStatus == 'PayPalPaymentInProcess' && $ebay_paystatus == 'Complete'){
					
					$paidsrc				= '<img src="images/pending.png" width="16" height="16" />';
					}
					
					if($eBayPaymentStatus == 'NoPaymentFailure' && $ebay_paystatus == 'Complete'){
					
					$paidsrc				= '<img src="images/paid.png" width="16" height="16" />';
					}
					
					if($eBayPaymentStatus == 'NoPaymentFailure' && $ebay_paystatus == 'Incomplete'){
					
					$paidsrc				= '<img src="images/notepaid.png" width="16" height="16" />';
					}
					$shipfee		= $sql[$i]['ebay_shipfee'];
					if($RefundAmount == '1'){
					
					$ss		= "select * from  ebay_orderpaypal where ebay_ordersn ='$ebay_ordersn' and PaymentOrRefundAmount < 0 ";
					$ss		= $dbcon->execute($ss);
					$ss		= $dbcon->getResultArray($ss);
					$sstotal	= $ss[0]['PaymentOrRefundAmount'];
					
					if($sstotal >= $total){
					
					$paidsrc				= '<img src="images/refundic.png" width="16" height="16" />';
					
					}else{
					
					$paidsrc				= '<img src="images/refundic2.png" width="16" height="16" />';
					
					}
					
					
					}	


			


			
						
			$urlno						="<a href='ordermodifive.php?ordersn=".$ebay_ordersn."&module=orders&action=Modifive%20Order' target='_blank'>".$recordnumber."</a>";	
			$rr							= "select * from ebay_orderdetail where ebay_ordersn='$ebay_ordersn'";
			

			$rr							= $dbcon->execute($rr);
			$rr							= $dbcon->getResultArray($rr);
			
			for($g=0; $g<count($rr);$g++){
			
				$recordnumber				= $rr[$g]['recordnumber'];		
				
			$ebay_itemid				= $rr[$g]['ebay_itemid'];		
			$sku						= $rr[$g]['sku'];	
			$ebay_amount						= $rr[$g]['ebay_amount'];	
			
			$ebay_itemprice						= $rr[$g]['ebay_itemprice'];	
			
			
		?>
                    <tr>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF"><a href="ordermodifive.php?ordersn=<?php echo $ebay_ordersn;?>&amp;module=orders&amp;ostatus=1&amp;action=Modifive%20Order" target="_blank"><?php echo $recordnumber; ?></a></td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF"><?php echo $ebay_userid; ?></td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF"><?php echo $ebay_itemid; ?></td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF"><?php echo $sku; ?></td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF"><?php echo $ebay_amount; ?></td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF"><?php echo $ebay_currency.($ebay_itemprice * $ebay_amount + $ebay_shipfee); ?></td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF"><?php echo date('Y-m-d ',$ShippedTime); ?></td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF"><?php 
	
	if($ebay_status == '0'){
				  
				  	
					echo '未付款订单';
					
				  
				  }else if($ebay_status == '1'){
				  
				  	
					echo '待处理订单';
					
				  
				  }else if($ebay_status == '2'){
				  
				  	
					echo '已经发货';
					
				  
				  }else{
				  
				  
				 $rrf		= "select * from ebay_topmenu where id='$ebay_status' ";
				 $rrf		= $dbcon->execute($rrf);
				 $rrf		= $dbcon->getResultArray($rrf);
				 echo $rrf[0]['name'];

				  
				  }
	
	 ?></td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF"><?php echo $ebay_ordersn.'<br><font color=red>'.$ebay_tracknumber.'</font>';?></td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF"><?php echo $paidsrc;?></td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF"><?php echo $imgsrc;?></td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF"><a href="#ddd<?php echo $mdi;?>" id="=&quot;ddd<?php echo $mdi;?>&quot;" onclick="view('<?php echo $ebay_ordersn; ?>','<?php echo $mid; ?>')">view</a><br /></td>
                    </tr>
					<tr><td colspan="12">
					
					<table width="400" border="0" cellpadding="2" cellspacing="1" bgcolor="#CCCCCC" >
		      <tr bgcolor="#ffffff">
			    <td width="120"><select style="width:103px;" name="feedback_<?php echo $ebay_id;?>">
                  <option value="==" selected="selected" >==== </option>
                   <option value="撤单" >撤单 </option>
				   <option value="业务助理漏单" >业务助理漏单 </option>
				   <option value="线下交易漏单" >线下交易漏单 </option>
                  <option value="中国妥投"  >中国妥投 </option>
                  <option value="已回公司"  >已回公司 </option>
				  <option value="清关有问题" > 清关有问题</option>
                  <option value="挂号(无法追踪)" >挂号(无法追踪) </option>
                  <option value="挂号(未妥投)" >挂号(未妥投) </option>
				  <option value="挂号(妥投错误)" >挂号(妥投错误) </option>
                  <option value="未收到物品(无挂号)" >未收到物品(无挂号) </option>
				  <option value="延误补偿长" >延误补偿</option>				  
                  <option value="已收到但时间太长" >已收到但时间太长</option>
				  <option value="公司缺货未发" >公司缺货未发 </option>
                   <option value="仓库漏发" >仓库漏发</option>
				  <option value="漏发无证据" >漏发无证据</option>
                  <option value="仓库发错" >仓库发错</option>
                  <option value="业务员描述错误" >业务员描述错误</option>
                  <option value="ERP描述错误" >ERP描述错误</option>
                  <option value="物品与描述不符" >物品与描述不符</option>
                  <option value="没达到期望值" >没达到期望值</option>
                  <option value="部分损坏-质量" >部分损坏-质量</option>
                  <option value="部分损坏-运输" >部分损坏-运输</option>
                  <option value="全部损坏-质量" >全部损坏-质量</option>
                  <option value="全部损坏-运输" >全部损坏-运输</option>
				  <option value="挂号费/运费/差价/" >挂号费/运费/差价/</option>
 				  <option value="还款">还款</option>
                  <option value="payapl调查" >payapl调查</option>
                  <option value="撤单但已收到物品" >撤单但已收到物品</option>
                </select>			      &nbsp; </td>
				
				<td><?				 if (1!=9) {?>
 <input type="button" name="Submit8" value="等待处理 " onclick="if(confirm('确定待处理个订单吗？')){edit_order_ajaxfeedback(<?php echo $ebay_id;?>,9);}else{return false;}" />
 <? } if (1==9) {?>
				 <input type="button" name="Submit8" value=" 完成处理 " onclick="if(confirm('确定待处理个订单吗？')){edit_order_ajaxfeedback(<?php echo $ebay_id;?>,9);}else{return false;}" />	
				 <? }?>	
				  
						    </td>
				 <td width="80">  &nbsp;   <?php if (  1!=1){
	
	  ?>
	  <input type="button" name="Submit5" value="亏本撤单" onclick="if(confirm('确定要撤销这个订单吗？')){chk_this_orders_status('canel',<?php echo $ebay_id;?>);}else{return false;}"/>
	  <?php  }?></td>
				  <td width="80">&nbsp; <?php if ( 1!=6){
	
	  ?>
	  <input type="button" name="Submit5" value="客服撤单" onclick="if(confirm('确定要撤销这个订单吗？')){chk_this_orders_status('canell',<?php echo $ebay_id;?>);}else{return false;}"/>
	  <?php  }?> </td>
				   <td width="80">&nbsp;<? if (2==1){
	    if (  1==1)
		{
?><input type="button" name="Submit62" value="修改订单" style="color:#CC0000; font-weight:bold;" onclick="update_orders_info('orders_get',<?php echo $ebay_id;?>,'edit_orders_info_<?php echo $ebay_id;?>')" />
 <?   } }?></td>
				    <td width="80">&nbsp;	  <?php if (1==1 ){
	 //   if ($rs['orders_status']!=4&&$rs['orders_status']!=6)
 
	  if (1==1 )
	  {		
	  ?>
	  <input type="button" name="Submit5" value="恢复订单" onclick="if(confirm('确定要恢复这个订单吗？')){chk_this_orders_status('pass',<?php echo $ebay_id;?>);}else{return false;}"/>
	  <?php }  }?>  </td>
					 <td width="80">  &nbsp;  
				      <input type="button" name="Submit8" value="补货订单" onclick="
					  
					  window.open('all_orders_manage.php?oID=<?php echo $ebay_id;?>&action=chk_this_orders_astatus&value=3','_self','')"
 					 />   </td>
			    </tr>
				
		      <tr bgcolor="#ffffff">
			    <td width="120" align="left">金额<input type="text" name="moneyback_<?php echo $ebay_id;?>" size="5" value="<?php echo $moneyback_total;?>"/>
&nbsp; </td>
				 <td width="80">&nbsp;
				 
<?				 if ($erp_op_id==1) {?>
<input type="button" name="Submit8" value="能够追踪" onclick="edit_order_ajax(<?php echo $ebay_id;?>,1);" /> 
<? }else {?>
				 <input type="button" name="Submit8" value="无法追踪" onclick="edit_order_ajax(<?php echo $ebay_id;?>,1);" /> 	<? }?>  </td>
	
				  <td width="80"> &nbsp;
				  
				  
				   
<?				 if ($erp_op_id==5) {?>
<input type="button" name="Submit8" value="已经妥投" onclick="edit_order_ajax(<?php echo $ebay_id;?>,5);" /> 
<? }else {?>
				<input type="button" name="Submit8" value="没有妥投" onclick="edit_order_ajax(<?php echo $ebay_id;?>,5);" />	<? }?>				  </td>
				   <td width="80">&nbsp;
				   
				   			 
<?				 if ($erp_op_id==6) {?>
  <input type="button" name="Submit8" value="妥投错误" onclick="edit_order_ajax(<?php echo $ebay_id;?>,6);" />
<? }else {?>
				  <input type="button" name="Submit8" value="妥投正确" onclick="edit_order_ajax(<?php echo $ebay_id;?>,6);" />	<? }?>				  </td>
				    <td width="80">&nbsp;<input type="button" name="Submit8" value="中国妥投" onclick="edit_order_ajax(<?php echo $ebay_id;?>,7);" /> </td>
					 <td width="80"> 	<?php if ( $erp_op_id==2 ){?><input type="button" name="Submit8" value="已回公司" onclick="edit_order_ajax(<?php echo $ebay_id;?>,2);" /> <? }?></td>
			    </tr>
				   <tr bgcolor="#ffffff"> <td width="120" rowspan="3"><textarea name="log_<?php echo $ebay_id;?>" cols="10" rows="3"></textarea>	
	   </td> 
			    <td width="120"> 	&nbsp; 
				
				
				<?	 if (1==0) {?>
<input type="button" name="Submit8" value="eBay case" onclick="if(confirm('确定EBAYCase这个订单吗？')){edit_order_ajaxfeedback(<?php echo $ebay_id;?>,3);}else{return false;}" />
<? }else {?>
				<input type="button" name="Submit8" value="取消eBay" onclick="if(confirm('确定取消EBAYCase这个订单吗？')){edit_order_ajaxfeedback(<?php echo $ebay_id;?>,3);}else{return false;}" />
	<? }?> 
				 
				 
				 </td>
				  <td width="80"><?	 if ($paypalcase==0) {?> <input type="button" name="Submit8" value="P Case" onclick="if(confirm('确定P Case这个订单吗？')){edit_order_ajaxfeedback(<?php echo $ebay_id;?>,4);}else{return false;}" />	<? }?> 
				  <?	 if ($paypalcase==1) {?> <input type="button" name="Submit8" value="PP Case" onclick="if(confirm('确定PP Case这个订单吗？')){edit_order_ajaxfeedback(<?php echo $ebay_id;?>,4);}else{return false;}" />	<? }?> 
				  <?	 if ($paypalcase==2) {?> <input type="button" name="Submit8" value="取消PP" onclick="if(confirm('确定取消PPCase这个订单吗？')){edit_order_ajaxfeedback(<?php echo $ebay_id;?>,4);}else{return false;}" />	<? }?> 
				   </td>
				
				    <td width="80"> <?	 if ($feedback!=1) {?>  <input type="button" name="Submit8" value=" 中  评 " onclick="if(confirm('确定中差评这个订单吗？')){edit_order_ajaxfeedback(<?php echo $ebay_id;?>,2);}else{return false;}" /><? }?><?	 if ($feedback==1) {?>  <input type="button" name="Submit8" value=" 取消中评 " onclick="if(confirm('确定中差评这个订单吗？')){edit_order_ajaxfeedback(<?php echo $ebay_id;?>,2);}else{return false;}" /><? }?>   </td>
						   <td width="80">	
						   
						      <?	 if ($feedback==10) {?> 
						   <input type="button" name="Submit8" value=" 取消差评 " onclick="if(confirm('确定取消差评评这个订单吗？')){edit_order_ajaxfeedback(<?php echo $ebay_id;?>,20);}else{return false;}" />  <? }?>
						   						      <?	 if ($feedback!=10) {?> 
						   <input type="button" name="Submit8" value=" 差  评 " onclick="if(confirm('确定差评这个订单吗？')){edit_order_ajaxfeedback(<?php echo $ebay_id;?>,20);}else{return false;}" />  <? }?> </td>
						  
				   <td width="80">	<?	 if ($feedback!=8) {?>  <input type="button" name="Submit8" value="修改链接 " onclick="if(confirm('确定修改链接这个订单吗？')){edit_order_ajaxfeedback(<?php echo $ebay_id;?>,8);}else{return false;}" /> <? }?>
				   
				   <?	 if ($feedback==8) {?>  <input type="button" name="Submit8" value="浪费链接 " onclick="if(confirm('确定浪费链接这个订单吗？')){edit_order_ajaxfeedback(<?php echo $ebay_id;?>,8);}else{return false;}" /> <? }?>
				   
				   </td>     <td width="80"> 
						 <?	 if (  1==1 ) {?> 	   <input type="button" name="Submit8" value="黑名单" onclick="
 					  window.open('bookbackoreradd.php?ordersn=<?php echo $ebay_ordersn;?>&module=customer&id=','_back','')"
 					 />  <? } ?>
							  </td>
        </tr>
 		<tr bgcolor="#ffffff">
	<td width="80"><input type="button" name="Submit8" value="申请退款" onclick="if(confirm('确定退款这个订单吗？')){edit_order_ajaxfeedback(<?php echo $ebay_id;?>,1);}else{return false;}" /> </td>
		 <td width="120"  ><input type="button" name="Submit8" value="取消退款" onclick="if(confirm('确定取消退款这个订单吗？')){edit_order_ajaxmoneyback(<?php echo $ebay_id;?>,2);}else{return false;}" />  </td>
				   <td width="80">
				   
			<?php if (  1==1 ){?>		   
				   <input type="button" name="Submit8" value="同意退款" onclick="if(confirm('确定同意退款这个订单吗？')){edit_order_ajaxmoneyback(<?php echo $ebay_id;?>,8);}else{return false;}" /> <? }?>	  </td>
				    <td width="80"><?php if ( 1==1 ){?>	<input type="button" name="Submit8" value="同意付款" onclick="if(confirm('确定同意付款这个订单吗？')){edit_order_ajaxmoneyback(<?php echo $ebay_id;?>,9);}else{return false;}" /><? }?></td>
					 <td width="80">	 <input type="hidden" name="moneybackremark_<?php echo $ebay_id;?>" cols="10" rows="3" value="0" /><input type="button" name="Submit8" value="完成退款" onclick="if(confirm('确定确认退款这个订单吗？')){edit_order_ajaxmoneyback(<?php echo $ebay_id;?>,10);}else{return false;}" />   </td>
					    <td width="80"> 
							
							  
							   <?				 if ($erp_op_id!=38) {?>
  <input type="button" name="Submit8" value="索要信息 " onclick="if(confirm('确定索要信息这个订单吗？')){edit_order_ajaxfeedback(<?php echo $ebay_id;?>,38);}else{return false;}" /> 	<? }else {?>
			  <input type="button" name="Submit8" value="提供信息 " onclick="if(confirm('确定提供信息这个订单吗？')){edit_order_ajaxfeedback(<?php echo $ebay_id;?>,38);}else{return false;}" /> 	<? }?> 
				
						    </td>
		</tr>
			<tr bgcolor="#ffffff">
		 <td width="80"> 	  	   <input type="button" name="Submit8" value="追回退款" onclick="if(confirm('确定追回退款这个订单吗？')){edit_order_ajaxfeedback(<?php echo $ebay_id;?>,5);}else{return false;}" /></td>
				    <td width="80"> 	   <input type="button" name="Submit8" value="查询付款" onclick="if(confirm('查询付款这个订单吗？')){edit_order_ajaxfeedback(<?php echo $ebay_id;?>,6);}else{return false;}" /></td>
					 <td width="80">		    <input type="button" name="Submit8" value="没有付款" onclick="if(confirm('没有付款这个订单吗？')){edit_order_ajaxfeedback(<?php echo $ebay_id;?>,11);}else{return false;}" /> </td>
				 <td width="80">  <?php if (  1==1 ){?> <input type="button" name="Submit8" value="确定收款" onclick="if(confirm('确定收款这个订单吗？')){edit_order_ajaxfeedback(<?php echo $ebay_id;?>,7);}else{return false;}" />	<? }?> </td>   
			
	  <td width="80">  <!--- <?				 if ($erp_op_id!=18) {?>
<input type="button" name="Submit8" value="发送账单" onclick="if(confirm('确发送账单这个订单吗？')){edit_order_ajaxfeedback(<?php echo $ebay_id;?>,18);}else{return false;}" />	<? }else {?>
				<input type="button" name="Submit8" value="已发账单" onclick="if(confirm('确定已发账单这个订单吗？')){edit_order_ajaxfeedback(<?php echo $ebay_id;?>,18);}else{return false;}" />		<? }?> 
				 --->
				    </td>   
				 <td width="80"><input type="button" name="Submit8" value="保存日志" onclick="edit_order_log_ajax(<?php echo $ebay_id;?>);" /> </td>
		</tr>
		    </table>
					</td></tr>
					
					
					  <?php

$hhh		= "select * from ebay_orderslog as a  where ebay_id = '$ebay_id'    order by id desc ";

 

$hhs		= $dbcon->execute($hhh);
$hhs 	= $dbcon->getResultArray($hhs);

for($hs=0;$hs<count($hhs);$hs++){


	
	$addtime			= date('Y-m-d ',$hhs[$hs]['operationtime']);
	$note				= $hhs[$hs]['notes'];
	$ebay_user			= $hhs[$hs]['operationuser'];
	
	

?>
                    <tr bgcolor="#FFFFFF">
					     <td  colspan="2"><?php echo $addtime; ?></td>
                      <td colspan="9"><strong><?php echo nl2br($note); ?></strong></td>
                      <td  ><?php echo $ebay_user; ?></td>
                 
                    </tr>
                    <?php



}


?>

					
                    <?php	

}


}  ?>
                  </table>
                  <div name="dstatus<?php echo $mid;?>" id="dstatus<?php echo $mid;?>"></div>
                  <div style=" border-bottom: #006666 solid 3px"></div>
                  Note:
                  <textarea name="Note<?php echo $mid; ?>" cols="90" rows="6" id="Note<?php echo $mid; ?>"></textarea>
                  <input name="submit" type="button" value="添加新备注" onclick="return addnote('<?php echo $mid;?>','<?php echo $recipientid; ?>','<?php echo $userid;?>')"  />
                  <table width="100%" border="1" align="bottom">
                    <tr>
                      <td>备注内容</td>
                      <td>添加人</td>
                      <td>添加时间</td>
                    </tr>
                    <?php

$hh		= "select * from ebay_messagenote as a  where ebay_account = '$recipientid' and ebay_userid ='$userid' and ($ebayacc) order by id desc ";




$hh		= $dbcon->execute($hh);
$hh 	= $dbcon->getResultArray($hh);

for($h=0;$h<count($hh);$h++){


	
	$addtime			=  $hh[$h]['addtime']  ;
	$note				= $hh[$h]['note'];
	$ebay_user			= $hh[$h]['ebay_user'];
	
	

?>
                    <tr>
                      <td><strong><?php echo nl2br($note); ?></strong></td>
                      <td><?php echo $ebay_user; ?></td>
                      <td><?php echo $addtime; ?></td>
                    </tr>
                    <?php



}


?>
                  </table></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td colspan="3"><div style="border:#000000 solid 2px; background: #009900"><font color="#009900"> <?php echo $i+1;?> </font></div></td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        </table>


    <br />

          </div>
    

  <tr>

    <td colspan="3" bgcolor="#FFFFFF"></td>
  </tr>

    

  <?php

  		}

		}

  ?>



  <tr>

    <td colspan="3" bgcolor="#FFFFFF">&nbsp;    </td>
  </tr>
</table>

<input type="hidden" name="addmid" id="addmid" value="<?php echo $addmid;?>" />








</body>

</html>
<script src='js/ajax.js'></script>

<script type="text/javascript" >



var msid	= 0;
var currentorder = '';

	function editorders(){
	
			
		var url		= "ordermodifive.php?ordersn="+currentorder+"&module=orders&action=Modifive%20Order";		
		openwindow(url,'00',1050,885);
	
	}
	
	function resend(){
	
			
		var url		= "messageoperation.php?ordersn="+currentorder+"&module=resend";		
		openwindow(url,'00',500,500);
	
	}
	
	function refund(){
	
			
		var url		= "messageoperation.php?ordersn="+currentorder+"&module=refund";		
		openwindow(url,'00',500,500);
	
	}
	
	function calcenorder(){
	
			
		var url		= "messageoperation.php?ordersn="+currentorder+"&module=calcenorder";		
		openwindow(url,'00',500,500);
	
	}
	
	
		function feedback(){
	
			
		var url		= "messagefeedback.php?ordersn="+currentorder+"&module=refund";		
		openwindow(url,'00',500,500);
	
	}

		function addnote(id,ebay_account,userid){
	
			
		var oss	= document.getElementById('Note'+id).value;
		
		
	
		if(oss == ""){

			

			alert("Note不能为空");
			document.getElementById('Note'+id).focus();
			return false;

		}
		
		
		var url		= "getajax.php";

		var param	= "type=addnote&id="+id+"&ebay_account="+ebay_account+"&note="+encodeURIComponent(oss)+"&userid="+userid;
		
		msid = id;
		sendRequestPostreply000(url,param);
	
	
	}

	function check_all(obj,cName)

	{

		var checkboxs = document.getElementsByName(cName);

		for(var i=0;i<checkboxs.length;i++){

			if(checkboxs[i].checked == false){

				

				checkboxs[i].checked = true;

			}else{

				

				checkboxs[i].checked = false;

			}	

			

		}

	}

	
	function view(ordersn,id){
		
		
	
		currentorder	= ordersn;
		
		var param	= "type=getorderdetails&ordersn="+ordersn;
		var url		= "getajax.php";
		document.getElementById('dstatus'+id).innerHTML="<img src=cx.gif />";
		msid = id;
		sendRequestPostview(url,param);
		
	
	
	
	}
	    function sendRequestPostview(url,param){
        createXMLHttpRequest();  
        xmlHttpRequest.open("POST",url,true); 
        xmlHttpRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
        xmlHttpRequest.onreadystatechange = processResponseview; 
        xmlHttpRequest.send(param); 
    }  
    //处理返回信息函数 
    function processResponseview(){
        if(xmlHttpRequest.readyState == 4){  
            if(xmlHttpRequest.status == 200){  
                var res = xmlHttpRequest.responseText;  
				document.getElementById('dstatus'+msid).innerHTML = res;
            }
			document.getElementById('dstatus'+msid).innerHTML = res;
			
			document.getElementById('content'+msid).focus();
			
			
        }  

    }  

	
	function classid(id){

		document.getElementById('mstatus'+id).innerHTML="<img src=cx.gif />";
		var url		= "getajax.php";
			msid = id;
			
		var categoryid		= document.getElementById('mm2'+id).value;
		
		var param	= "type=changecateogry&mid="+id+"&categoryid="+categoryid;
		
		
		if(confirm("确认移动到所选分类吗？")){
		
			
			sendRequestPostreply(url,param);
			
		
		}

	

	}
	
	
	
	function marketyh(id,status){
		document.getElementById('mstatus'+id).innerHTML="<img src=cx.gif />";
		var url		= "getajax.php";
			msid = id;
			
		var oss	= document.getElementById('content'+id).value;
		
		
		var param	= "type=changestatus&mid="+id+"&status="+status+"&body="+encodeURIComponent(oss);
		
		var str		= '';
		
		if(status == 1){
		str  = '确认标记已回复吗';
		}
		
		if(status == 3){
		str  = '确认标记不需要回复吗';
		}
		
		
		if(confirm(str)){
			sendRequestPostreply(url,param);
		}
		

		
		
		

		

	

	}
	




	

	function check(id){

		var oss	= document.getElementById('content'+id).value;
		var mailsent	= document.getElementById('mailsent'+id).checked;
		
		var copysender	= 0;
		
		if(mailsent){
		copysender		= 1;
		
		}
	
		if(oss == ""){

			

			alert("回复内容不能为空");
			document.getElementById('content'+id).focus();
			return false;

		

		}

		document.getElementById('mstatus'+id).innerHTML="<img src=cx.gif />";
		var url		= "getajax.php";
		var param	= "type=replymessage&mid="+id+"&body="+encodeURIComponent(oss)+"&mailsent="+copysender;
		msid = id;

	
		
		sendRequestPostreply(url,param);

		

		

		var url = "ebaymessagereplyone.php?type=reply&messageid=<?php echo $_REQUEST['messageid']; ?>&mesid="+id+"&content="+encodeURIComponent(oss);	

		//window.open(url,"_blank");

		

	

	}

	

	function ck(ck,id,userid){

	

		document.getElementById('mstatus'+id).innerHTML="<img src=cx.gif />";

		var va		= ck.value;		

		var url		= "getajax.php";

		var param	= "type=message&mid="+id+"&body="+encodeURIComponent(va);

		msid = id;



		sendRequestPost(url,param);

		

		

	

	}

	

	var xmlHttpRequest;  

    function createXMLHttpRequest(){  

        try  

        {  

       // Firefox, Opera 8.0+, Safari  

        xmlHttpRequest=new XMLHttpRequest();  

        }  

     catch (e)  

        {  

  

      // Internet Explorer  

       try  

          {  

           xmlHttpRequest=new ActiveXObject("Msxml2.XMLHTTP");  

          }  

       catch (e)  

          {  

  

          try  

             {  

              xmlHttpRequest=new ActiveXObject("Microsoft.XMLHTTP");  

             }  

          catch (e)  

             {  

             alert("您的浏览器不支持AJAX！");  

             return false;  

             }  

          }  

        }  

  

    }  

function edit_order_log_ajax(oID)
{

var loger=  document.getElementsByName('log_'+oID);
var loger_values=new Array();
for (i=0;i<loger.length;i++)
{
 
loger_values=loger_values.concat(loger[i].value);
}

//	var icount=document.getElementsByName('icount_'+oID);
xmlllHttp=GetXmlHttpObject();
if (xmlllHttp==null){alert ("Browsers that are currently running may not support AJAX,please change other browsers.");return;}

var url="0ebaymessagereplyone.php?oID="+oID+"&action=orders_log&loger="+loger_values;
url=encodeURI(url);
 alert(loger_values);
 alert(url);
xmlllHttp.onreadystatechange=function (){edit_orders_log_ajax_result(oID);};
xmlllHttp.open("GET",url,true);
xmlllHttp.send(null);

}

function edit_orders_log_ajax_result(oID)
{

   	if(xmlllHttp.readyState==4)
	{
		if(xmlllHttp.status==200){
		alert('修改成功,请刷新界面查看.');
	 		                     if (xmlllHttp.responseText=='ok'){alert('修改成功,请刷新界面查看.');}
 		                       }
	}	
}
function edit_orders_logs_ajax_result(oID)
{

   	if(xmlllHttp.readyState==4)
	{
		if(xmlllHttp.status==200){
		alert('修改成功,请刷新界面查看.');
	 		                     if (xmlllHttp.responseText=='ok'){alert('修改成功,请刷新界面查看.');}
 		                       }
	}	
}

function edit_order_ajax(oID,cid)
{
var loger=  document.getElementsByName('log_'+oID);
var loger_values=new Array();
for (i=0;i<loger.length;i++)
{
 
loger_values=loger_values.concat(loger[i].value);
}


//	var icount=document.getElementsByName('icount_'+oID);
xmlllHttp=GetXmlHttpObject();
if (xmlllHttp==null){alert ("Browsers that are currently running may not support AJAX,please change other browsers.");return;}

var url="0ebaymessagereplyone.php?oID="+oID+"&action=orders_order&logerx="+loger_values+"&loger="+cid;
url=encodeURI(url);
//alert(loger_values);
//alert(url);
xmlllHttp.onreadystatechange=function (){edit_orders_logs_ajax_result(oID);};
xmlllHttp.open("GET",url,true);
xmlllHttp.send(null);

}

function edit_order_ajaxmoneyback(oID,uid)
{
var loger=  document.getElementsByName('moneyback_'+oID);
var loger_values=new Array();
var logerx=  document.getElementsByName('log_'+oID);
var loger_valuesx=new Array();

for (i=0;i<loger.length;i++)
{
  loger_valuesx=loger_valuesx.concat(logerx[i].value);

loger_values=loger_values.concat(loger[i].value);
}
 //	var icount=document.getElementsByName('icount_'+oID);
xmlllHttp=GetXmlHttpObject();
if (xmlllHttp==null){alert ("Browsers that are currently running may not support AJAX,please change other browsers.");return;}

var url="0ebaymessagereplyone.php?oID="+oID+"&loger="+loger_values+"&logerx="+loger_valuesx+"&feedback="+uid+"&action=orders_moneyback";
url=encodeURI(url);
//alert(loger_values);
//alert(url);
xmlllHttp.onreadystatechange=function (){edit_orders_log_ajax_result(oID);};
xmlllHttp.open("GET",url,true);
xmlllHttp.send(null);

}

function edit_order_ajaxfeedback(oID,uid)
{
  var logerx=  document.getElementsByName('log_'+oID);
var loger=  document.getElementsByName('feedback_'+oID);
var moneyback=  document.getElementsByName('moneyback_'+oID);
var loger_values=new Array();
var loger_valuesx=new Array();
var moneyback_values=new Array();
 for (i=0;i<loger.length;i++)
{
 loger_valuesx=loger_valuesx.concat(logerx[i].value);
loger_values=loger_values.concat(loger[i].value);
moneyback_values=moneyback_values.concat(moneyback[i].value);
}
//	var icount=document.getElementsByName('icount_'+oID);
if (loger_valuesx ==''){loger_valuesx=" ";}
xmlllHttp=GetXmlHttpObject();
if (xmlllHttp==null){alert ("Browsers that are currently running may not support AJAX,please change other browsers.");return;}

var url="0ebaymessagereplyone.php?oID="+oID+"&action=orders_feedback&logerx="+loger_valuesx+"&loger="+loger_values+"&feedback="+uid+"&moneyback="+moneyback_values;
url=encodeURI(url);
//alert(loger_values);
// alert(url);
xmlllHttp.onreadystatechange=function (){edit_orders_log_ajax_result(oID);};
xmlllHttp.open("GET",url,true);
xmlllHttp.send(null);

}

    //发送请求函数  

    function sendRequestPost(url,param){
        createXMLHttpRequest();  
        xmlHttpRequest.open("POST",url,true); 
        xmlHttpRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
        xmlHttpRequest.onreadystatechange = processResponse; 
        xmlHttpRequest.send(param); 
    }  
    //处理返回信息函数 
    function processResponse(){
        if(xmlHttpRequest.readyState == 4){  
            if(xmlHttpRequest.status == 200){  
                var res = xmlHttpRequest.responseText;  
		
				document.getElementById('content'+msid).value = res;
            }
			document.getElementById('mstatus'+msid).innerHTML="";
        }  

    }  

	

	

	

	

	 function sendRequestPostreply(url,param){

		

		

        createXMLHttpRequest();  

        xmlHttpRequest.open("POST",url,true);  

        xmlHttpRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded");  

        xmlHttpRequest.onreadystatechange = processResponsereply;  

        xmlHttpRequest.send(param);  

    }  
	
	
	 function sendRequestPostreply000(url,param){

		

		

        createXMLHttpRequest();  

        xmlHttpRequest.open("POST",url,true);  

        xmlHttpRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded");  

        xmlHttpRequest.onreadystatechange = processResponsereply000;  

        xmlHttpRequest.send(param);  

    }  
	

    //处理返回信息函数  

    function processResponsereply(){
		

        if(xmlHttpRequest.readyState == 4){  

            if(xmlHttpRequest.status == 200){  

                var res = xmlHttpRequest.responseText;  
				if(res == 'AAsuccessAA'){
					document.getElementById('mstatus'+msid).innerHTML='<font color="#006600"> Success</font>';
				}else{
					document.getElementById('mstatus'+msid).innerHTML='<h1><font color="red">Message Sent Failure</font></h1>'+res;
				}
            }else{  
                window.alert("请求页面异常");  
            }  

			//document.getElementById('mstatus'+msid).innerHTML="";
        }  

    } 
	
	
	 function processResponsereply000(){
		

        if(xmlHttpRequest.readyState == 4){  

            if(xmlHttpRequest.status == 200){  

                var res = xmlHttpRequest.responseText;  
		
				


				if(res.indexOf("0")){

					

					document.getElementById('mstatus'+msid).innerHTML='<font color="#006600"> note add Success</font>';

				}else{

				

					document.getElementById('mstatus'+msid).innerHTML='<font color="red"> Failure</font>';

					

				}


            }else{  
                window.alert("请求页面异常");  
            }  

			//document.getElementById('mstatus'+msid).innerHTML="";

			

			

        }  

    } 
	
	
	function openwindow(url,name,iWidth,iHeight)

{

var url; //转向网页的地址;

var name; //网页名称，可为空;

var iWidth; //弹出窗口的宽度;

var iHeight; //弹出窗口的高度;

var iTop = (window.screen.availHeight-30-iHeight)/2; //获得窗口的垂直位置;

var iLeft = (window.screen.availWidth-10-iWidth)/2; //获得窗口的水平位置;

window.open(url,name,'height='+iHeight+',,innerHeight='+iHeight+',width='+iWidth+',innerWidth='+iWidth+',top='+iTop+',left='+iLeft+',toolbar=no,menubar=no,scrollbars=auto,resizeable=no,location=no,status=no');

}


	function win(vaurl){
	

		
		openwindow(url,'00',550,385);
	
	
	}



	
	function closes(mid){
	
		document.getElementById('table'+mid).style.display = 'none'
	
	
	
	}


</script>

