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

<?php
	include "include/config.php";
?>



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
			$mmarket	 	=   $sql[0]['mmarket'];
			$recipientid	 	=   $sql[0]['recipientid'];
			
			$body			=   $sql[0]['body'];
			
			if($body == ''){
				$sqlr 			=	"select * from ebay_messagedetail where messageid='$id'";
				$sqlr 			= 	$dbcon->execute($sqlr);
				$sqlr			= 	$dbcon->getResultArray($sqlr);
				$body			= $sqlr[0]['body'];
			}
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

		

		


		if($userid != 'eBay'){
		$sy 			=	"select id,body,createtime,Itemid,recipientid,subject,replaycontent from ebay_message as a  where sendid='$userid' and id!=$id and ebay_account ='$recipientid'";
		$sy				= 	$dbcon->execute($sy);
		$sy				= 	$dbcon->getResultArray($sy);
		if(count($sy) != 0){			
			for($o=0;$o<count($sy);$o++){
				$body			= $sy[$o]['body'];
				
				$iiid			= $sy[$o]['id'];
					if($body == ''){
				$sqlr 			=	"select * from ebay_messagedetail where messageid='$iiid'";
				$sqlr 			= 	$dbcon->execute($sqlr);
				$sqlr			= 	$dbcon->getResultArray($sqlr);
				$body			= $sqlr[0]['body'];
			}
			
				
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
		
		}
		
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
                  <div name="mstatus<?php echo $mid;?>" id="mstatus<?php echo $mid;?>" style="font-size:24px; color:#0033CC"></div>
                  <br />
                  <input name="mailsent<?php echo $mid; ?>" type="checkbox" id="mailsent<?php echo $mid; ?>" value="1"/>
抄送到卖家邮箱<div id="img<?php echo $id;?>" onclick="changeimage('<?php echo $id;?>')"> <img border="0" src="images/<?php echo $mmarket;?>.gif" width="16px" height="16px" /></div>
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
				  
				  	$kk = "select name,id from ebay_templatecategory where ebay_user ='$user' ";
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
                  </p><br />                </td>
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
		
		echo $ss;
		$ss		= $dbcon->execute($ss);
		$ss		= $dbcon->getResultArray($ss);		
		for($t=0;$t<count($ss);$t++){
			
			$ebay_shipfee				= $ss[$t]['ebay_shipfee'];
			
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
			$ShippedTime				= $ss[$t]['ebay_markettime'];
			$RefundAmoun				= $ss[$t]['RefundAmoun'];
			$ebay_tracknumber				= $ss[$t]['ebay_tracknumber'];		
			$ebay_ordersn				= $ss[$t]['ebay_ordersn'];
			$ebay_tracknumber				= $ss[$t]['ebay_tracknumber'];
			
			
			
			$ebay_paystatus			= trim($ss[$t]['ebay_paystatus']);
			$eBayPaymentStatus		= 		 $ss[$t]['eBayPaymentStatus'];
			
			$ebay_currency			= trim($ss[$t]['ebay_currency']);
			
		
					
			
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
				$ebay_amount				= $rr[$g]['ebay_amount'];	
				$ebay_itemprice				= $rr[$g]['ebay_itemprice'];	
				$ebay_tid					= $rr[$g]['ebay_tid'];	
				$feedbacksql				= "select CommentType from ebay_feedback where CommentingUser = '$ebay_userid' and account ='$ebay_account' and ItemID='$ebay_itemid' and TransactionID='$ebay_tid' ";
				$feedbacksql				= $dbcon->execute($feedbacksql);
				$feedbacksql				= $dbcon->getResultArray($feedbacksql);
				$ebay_feedback				= $feedbacksql[0]['CommentType'];
					$imgsrc						= '';
					if($ebay_feedback == 'Positive') $imgsrc = '<img src="images/iconPos_16x16.gif" width="16" height="16" />';
					if($ebay_feedback == 'Negative') $imgsrc = '<img src="images/iconNeg_16x16.gif" width="16" height="16" />';
					if($ebay_feedback == 'Neutral')  $imgsrc = '<img src="images/iconNeu_16x16.gif" width="16" height="16" />';
					
					
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
				  
				  
				 $rrf		= "select name from ebay_topmenu where id='$ebay_status' ";
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
                    <?php	

}


}  ?>
                  </table>
                  <div name="dstatus<?php echo $mid;?>" id="dstatus<?php echo $mid;?>"></div>
                  <div style=" border-bottom: #006666 solid 3px"></div>
                 <strong> Note:<br /></strong>
                  <textarea name="Note<?php echo $mid; ?>" cols="90" rows="6" id="Note<?php echo $mid; ?>"></textarea>
                  <input name="submit" type="button" value="添加新备注" onclick="return addnote('<?php echo $mid;?>','<?php echo $recipientid; ?>','<?php echo $userid;?>')"  />
                  <table width="100%" border="1" align="bottom">
                    <tr>
                      <td>备注内容</td>
                      <td>添加人</td>
                      <td>添加时间</td>
                    </tr>
                    <?php

$hh		= "select addtime,note,ebay_user from ebay_messagenote as a  where ebay_account = '$recipientid' and ebay_userid ='$userid' and ($ebayacc) order by id desc ";




$hh		= $dbcon->execute($hh);
$hh 	= $dbcon->getResultArray($hh);

for($h=0;$h<count($hh);$h++){


	
	$addtime			= $hh[$h]['addtime'];
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
			
				
				
				var sl	= res.indexOf("success");
				
			
				if(res == 'AAsuccessAA' || sl >= 0 ){
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
	
	sordersn = '';
	
	function changeimage(ordersn){
	//	document.getElementById('img'+ordersn).innerHTML= ordersn;
		sordersn	= ordersn;
		var url		= "getajax.php";
		var param	= "type=market&ordersn="+ordersn;
		sendRequestPostce(url,param);
		
	
	
	}
	
	
	function sendRequestPostce(url,param){
		
		
        createXMLHttpRequest();  
        xmlHttpRequest.open("POST",url,true);  
        xmlHttpRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded");  
        xmlHttpRequest.onreadystatechange = processResponsece;  
        xmlHttpRequest.send(param);  
    }  
    //处理返回信息函数  
    function processResponsece(){
	

	
        if(xmlHttpRequest.readyState == 4){  
            if(xmlHttpRequest.status == 200){  
                var res = xmlHttpRequest.responseText;  
				
				document.getElementById('img'+sordersn).innerHTML= '<img border="0" src="images/'+res+'.gif" width="16px" height="16px" />';
				
            }else{  
                window.alert("请求页面异常");  
            }  
			
			
        }  
    }
	


</script>

