 <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>

<?php

	include "include/config.php";
	
			$ertj		= "";
			$orders		= explode(",",$_REQUEST['bill']);
			for($g=0;$g<count($orders);$g++){
		
		
				$sn 	=  $orders[$g];
				if($sn != ""){
				
					$ertj	.= " id='$sn' or";
				}
			
			}
			$ertj			 = substr($ertj,0,strlen($ertj)-3);
			$sql			 = "select * from ebay_case where ($ertj) and ebay_user = '$user' ";
			$sql	= $dbcon->execute($sql);
			$sql	= $dbcon->getResultArray($sql);
			
			for($i=0;$i<count($sql);$i++){
			$itemId			 			= $sql[$i]['itemId'];
				$id			 			= $sql[$i]['id'];
				$otherPartyuserId			 			= $sql[$i]['otherPartyuserId'];
				$caseId		 			= $sql[$i]['caseId'];
				$openReason		 		= $sql[$i]['openReason'];
				$initialBuyerExpectationDetail_description		 		= $sql[$i]['initialBuyerExpectationDetail_description'];
				$detailStatusInfo_description		 		= $sql[$i]['detailStatusInfo_description'];
				$detailStatusInfo_content		 		= $sql[$i]['detailStatusInfo_content'];
				$ebay_account		 			= $sql[$i]['ebay_account'];
				$decisionReasonDetail_description		= $sql[$i]['decisionReasonDetail_description'];
				$decisionReasonDetail_content	 		= $sql[$i]['decisionReasonDetail_content'];
				
?>
    
<table width="80%" border="1" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td colspan="2">第<font color="#FF0000" size="22px"><?php echo $i+1;?></font>个纠纷: 纠纷编号：<?php echo $caseId;?> 开启原因：<?php echo $openReason;?></td>
  </tr>
  <tr>
    <td>裁决描述</td>
    <td><?php echo $decisionReasonDetail_description;?>&nbsp;</td>
  </tr>
  <tr>
    <td> 裁决标记 </td>
    <td><?php echo $decisionReasonDetail_content;?>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="7%"> 纠纷详情	</td>
    <td width="93%"><?php echo $detailStatusInfo_description;?>&nbsp;</td>
  </tr>
  <tr>
    <td>纠纷描述</td>
    <td><?php echo $detailStatusInfo_content;?>&nbsp;</td>
  </tr>
  <tr>
    <td>买家期待</td>
    <td><?php echo $initialBuyerExpectationDetail_description;?>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">处理方案:</td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="1" cellspacing="0" cellpadding="0">
      <tr>
        <td>处理方</td>
        <td> 处理内容 </td>
        <td>处理时间</td>
      </tr>
      
      <?php
	  
	  $vv		= "select * from ebay_casedetail where caseId='$caseId' and ebay_account='$ebay_account' ";
	  $vv		= $dbcon->execute($vv);
	  $vv		= $dbcon->getResultArray($vv);
	  
	  for($j=0;$j<count($vv);$j++){
	  		
			$creationDate		= $vv[$j]['creationDate'];
			$role				= $vv[$j]['role'];
			$note				= $vv[$j]['note'];
			$description		= $vv[$j]['description'];
			
			
			$color		= '';
			
			if($role == 'BUYER'){
				$color = '#CCCCCC';
				
				
			}
	   ?>
      <tr bgcolor="<?php echo $color;?>">
        <td><?php echo $role;?>&nbsp;</td>
        <td><?php echo nl2br($note);?>&nbsp;</td>
        <td><?php echo $creationDate;?>&nbsp;</td>
      </tr>
      
      <?php } ?>
      
    </table></td>
  </tr>
  <tr>
    <td colspan="2">订单信息:<br /><table width="100%" border="0" cellpadding="3" cellspacing="1" bordercolor="#000000" bgcolor="#000000">
                    <tr>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">Sale record&nbsp;</td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">Buyer ID&nbsp;</td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">Item No&nbsp;</td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">Sku</td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">Qty</td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">总金额</td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">运送</td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">运送时间</td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">状态</td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">跟踪号</td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">付款</td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">评价</td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">操作</td>
                    </tr>
                    <?php

		$ss		= "select * from ebay_order as a  where a.ebay_userid = '$otherPartyuserId' and ebay_account ='$ebay_account' and a.ebay_combine!='1' order by recordnumber desc";
		
		
		$ss		= $dbcon->execute($ss);
		$ss		= $dbcon->getResultArray($ss);		
		for($t=0;$t<count($ss);$t++){
			
			$ebay_shipfee				= $ss[$t]['ebay_shipfee'];
			$ebay_carrier				= $ss[$t]['ebay_carrier'];
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
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF"><?php echo $ebay_carrier;?>&nbsp;</td>
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
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF"><?php echo '<br><font color=red>'.$ebay_tracknumber.'</font>';?></td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF"><?php echo $paidsrc;?></td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF"><?php echo $imgsrc;?></td>
                      <td bordercolor="#FFFFFF" bgcolor="#FFFFFF"><a href="#ddd<?php echo $mdi;?>" id="=&quot;ddd<?php echo $mdi;?>&quot;" onclick="view('<?php echo $ebay_ordersn; ?>','<?php echo $mid; ?>')">view</a><br /></td>
                    </tr>
                    <?php	

}


}  ?>
                  </table>
                  
                  
                  
                  </td>
  </tr>
  <tr>
    <td colspan="2">Case Item number: <?php echo $itemId;?></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>解决方案01</td>
          <td>解决方案02</td>
          <td>解决方案03</td>
        </tr>
        <tr>
          <td valign="top"><p>
            <select name="solution<?php echo $id;?>" id="solution<?php echo $id;?>">
              <option value="offerOtherSolution">01. offerOtherSolution[提供其他方案]</option>
              <option value="provideRefundInfo ">02. provideRefundInfo[提供退款信息]</option>
              <option value="issueFullRefund">03. issueFullRefund[发出全额退款]</option>
              <option value="offerPartialRefund">04. offerPartialRefund  [发出部分退款沟通]</option>
              <option value="issuePartialRefund">05. issuePartialRefund[发出部分退款]</option>
              <option value="offerRefundUponReturn">06. 描述不符，退回包裹后，退全款</option>
              
            </select>
            <br />
            Notes to buyer<br />
            <textarea cols="30" rows="5" id="solutionmessage<?php echo $id;?>0" name="solutionmessage<?php echo $id;?>0"></textarea>
            <br />
            退款金额:
            <input name="totalamount<?php echo $id;?>" id="totalamount<?php echo $id;?>" type="text"  value="" />
            </p>
            <table width="302" border="1">
              <tr>
                <td colspan="2">06项，必填</td>
              </tr>
              <tr>
                <td>姓名</td>
                <td><input name="name<?php echo $id;?>" id="name<?php echo $id;?>" type="text"  value="" /></td>
              </tr>
              <tr>
                <td>地址1</td>
                <td><input name="street1<?php echo $id;?>" id="street1<?php echo $id;?>" type="text"  value="" /></td>
              </tr>
              <tr>
                <td>地址2</td>
                <td><input name="street2<?php echo $id;?>" id="street2<?php echo $id;?>" type="text"  value="" /></td>
              </tr>
              <tr>
                <td>城市</td>
                <td><input name="city<?php echo $id;?>" id="city<?php echo $id;?>" type="text"  value="" /></td>
              </tr>
              <tr>
                <td>省份</td>
                <td><input name="province<?php echo $id;?>" id="province<?php echo $id;?>" type="text"  value="" /></td>
              </tr>
              <tr>
                <td>邮编</td>
                <td><input name="postcode<?php echo $id;?>" id="postcode<?php echo $id;?>" type="text"  value="" /></td>
              </tr>
              <tr>
                <td>国家</td>
                <td><input name="country<?php echo $id;?>" id="country<?php echo $id;?>" type="text"  value="" /></td>
              </tr>
            </table>
            <p><br />
              <input name="" type="button" value="保存" onclick="submitsolution('<?php echo $id;?>')" />
              <br />
          </p></td>
          <td valign="top"> <p>provideShippingInfo[提供运输信息] <br />
            运送时间:
                <input name="shipdate<?php echo $id;?>" id="shipdate<?php echo $id;?>" type="text" onclick="WdatePicker()"  value="" />
              <br />
              承运商:
              <input name="shipcarrier<?php echo $id;?>" id="shipcarrier<?php echo $id;?>" type="text"  value="" />
              <br />
          Notes to buyer<br />
          <textarea cols="30" rows="5" id="provideShippingInfomessage<?php echo $id;?>1" name="provideShippingInfomessage<?php echo $id;?>1"></textarea>
          </p>
<p>
  <input name="input" type="button" value="保存" onclick="provideTrackingInfo('<?php echo $id;?>')" />
</p></td>
          <td valign="top">            <p>provideTrackingInfo[提供运输信息]<br />
            承运商:
<input name="provideTrackingInfoshipcarrier<?php echo $id;?>" id="provideTrackingInfoshipcarrier<?php echo $id;?>" type="text"  value="" />
              <br />
              跟踪号:
              <input name="provideTrackingInfotrackingNumber<?php echo $id;?>" id="provideTrackingInfotrackingNumber<?php echo $id;?>" type="text"  value="" />
              <br />
              Notes to buyer<br />
              <textarea cols="30" rows="5" id="provideTrackingInfomessage<?php echo $id;?>" name="provideTrackingInfomessage<?php echo $id;?>"></textarea>
              <br />
              <input name="input2" type="button" value="保存" onclick="provideTrackingInfo02('<?php echo $id;?>')" />
<br />
              <br />
          </p></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <p>&nbsp;</p>
      <p>&nbsp;</p></td>
  </tr>
</table>

	<?php } ?>
    
    
    <script language="javascript">
		
		function submitsolution(id){
			var solution				= document.getElementById('solution'+id).value;
			var solutionmessage			= document.getElementById('solutionmessage'+id+'0').value;
			var totalamount			= document.getElementById('totalamount'+id).value;
			
			
			var name				= document.getElementById('name'+id).value;
			var street1				= document.getElementById('street1'+id).value;
			var street2				= document.getElementById('street2'+id).value;
			var city				= document.getElementById('city'+id).value;
			var province			= document.getElementById('province'+id).value;
			var zip					= document.getElementById('postcode'+id).value;
			var country				= document.getElementById('country'+id).value;
			
			
			
			var url						= "dispute_handle.php?solution="+solution+"&solutionmessage="+encodeURIComponent(solutionmessage)+"&id="+id+"&totalamount="+totalamount+"&name="+name+"&street1="+street1+"&street2="+street2+"&city="+city+"&province="+province+"&zip="+zip+"&country="+country;
			
			
			alert(url);
			
			window.open(url,"_blank");
			
			
		}
		
		
		function provideTrackingInfo(id){
			var shipdate				= document.getElementById('shipdate'+id).value;
			var solutionmessage			= document.getElementById('provideShippingInfomessage'+id+'1').value;
			var shipcarrier				= document.getElementById('shipcarrier'+id).value;
			var url						= "dispute_handle.php?solution=provideShippingInfo&solutionmessage="+encodeURIComponent(solutionmessage)+"&id="+id+"&shipdate="+shipdate+"&shipcarrier="+shipcarrier;
			window.open(url,"_blank");
		}
		
		
		
		function provideTrackingInfo02(id){
			var tracknumber				= document.getElementById('provideTrackingInfotrackingNumber'+id).value;
			var solutionmessage			= document.getElementById('provideTrackingInfomessage'+id).value;
			var shipcarrier				= document.getElementById('provideTrackingInfoshipcarrier'+id).value;
			var url						= "dispute_handle.php?solution=provideTrackingInfo&solutionmessage="+encodeURIComponent(solutionmessage)+"&id="+id+"&tracknumber="+tracknumber+"&shipcarrier="+shipcarrier;
			window.open(url,"_blank");
		}
		
	
	
	
	</script>
