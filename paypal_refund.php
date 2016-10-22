<?php
include "include/config.php";


include "top.php";


	$ebayid		= $_REQUEST['ebayid'];
	$status		= $_REQUEST['status'];	
	if($ebayid > 0 ){
		$vv		= "delete from ebay_paypalrefund where ebay_id ='$ebayid' and ebay_user ='$user' ";
		

			if($dbcon->execute($vv)){
				$status	= " -[<font color='#33CC33'>操作记录: 保存成功</font>]";
			}else{
				$status = " -[<font color='#FF0000'>操作记录: 保存失败</font>]";
			}
			
			echo $status;
			
	}
	
	
	
	
	function PPHttpPost($methodName_, $nvpStr_ ,$account) {
	global $environment,$dbcon;
	
		$sql			= "select * from ebay_paypal where account='$account'";
		$sql			= $dbcon->execute($sql);
		$sql			= $dbcon->getResultArray($sql);	
		if(count($sql) == 0 ) return;
		$API_UserName	= $sql[0]['name'];
		$API_Password	= $sql[0]['pass'];
		$API_Signature	= $sql[0]['signature'];	
		
		
		// Set up your API credentials, PayPal end point, and API version.
		$API_UserName = urlencode($API_UserName);
		$API_Password = urlencode($API_Password);
		$API_Signature = urlencode($API_Signature);
		$API_Endpoint = "https://api-3t.paypal.com/nvp";
	
		$version = urlencode('51.0');
		// Set the curl parameters.
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
	 
		// Turn off the server and peer verification (TrustManager Concept).
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
	 
		// Set the API operation, version, and API signature in the request.
		$nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";
	 
		// Set the request as a POST FIELD for curl.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
	 
		// Get response from the server.
		$httpResponse = curl_exec($ch);
	 
		if(!$httpResponse) {
			exit("$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')');
		}
	 
		// Extract the response details.
		$httpResponseAr = explode("&", $httpResponse);
	 
		$httpParsedResponseAr = array();
		foreach ($httpResponseAr as $i => $value) {
			$tmpAr = explode("=", $value);
			if(sizeof($tmpAr) > 1) {
				$httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
			}
		}
	 
		if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
			exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
		}
	 
		return $httpParsedResponseAr;
}


	
	
	if($_REQUEST['type'] == 'audit'){
			
			$stype			= $_REQUEST['stype'];
			$ebay_id		= $_REQUEST['ebay_id'];
			
			/* 确定审核退款单据 */
			if($stype == '1'){
				$sql		= "update ebay_paypalrefund set status ='$stype',audittime='$mctime',audittimeuser='$truename' where ebay_id ='$ebay_id' and ebay_user ='$user' ";
				if($dbcon->execute($sql)){
				echo  " -[<font color='#33CC33'>操作记录: 审核成功</font>]";
				}else{
				echo  " -[<font color='#FF0000'>操作记录: 审核失败</font>]";
				}
				echo $status;
			}
			
			
			/* 反审核退款单据 */
			if($stype == '0'){
				$sql		= "update ebay_paypalrefund set status ='$stype',audittime='',audittimeuser='' where ebay_id ='$ebay_id' and ebay_user ='$user' ";
				if($dbcon->execute($sql)){
				echo  " -[<font color='#33CC33'>操作记录: 反审核成功</font>]";
				}else{
				echo " -[<font color='#FF0000'>操作记录: 反审核失败</font>]";
				}
				
			}
			
			
			/* 确认退款 */
			
			
			if($stype == '2'){
				
				$ss		= "select * from ebay_paypalrefund where ebay_id ='$ebay_id' and ebay_user ='$user' and status != '2'  ";
				$ss		= $dbcon->execute($ss);
				$ss		= $dbcon->getResultArray($ss);
				if(count($ss) == 0) die('系统错误，请联系管理员');
				
				$account			= $ss[0]['paymentto_paypalaccount'];
				$transactionID		= urlencode($ss[0]['ebay_ptid']);
				$refundType			= urlencode($ss[0]['REFUNDTYPE']);
				$currencyID			= urlencode($ss[0]['ebay_currency']);
				$amount				= $ss[0]['ebay_refundamount'];
				
				
				$nvpStr = "&TRANSACTIONID=$transactionID&REFUNDTYPE=$refundType&CURRENCYCODE=$currencyID";
				if($refundType == 'Full'){
				$nvpStr .= "&NOTE=$memo";
				}else{
				
				$nvpStr = $nvpStr."&AMT=$amount";
				}
				echo $nvpStr;
				
				
				$httpParsedResponseAr = PPHttpPost('RefundTransaction', $nvpStr , $account);
				
				
				print_r($httpParsedResponseAr);
				
				
				if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
					echo 'Refund Completed Successfully: ';
					print_r($httpParsedResponseAr, true);
					$sql		= "update ebay_paypalrefund set status ='2',refundtime='$mctime',refundtimeuser='$truename' where ebay_id ='$ebay_id' and ebay_user ='$user' ";
					if($dbcon->execute($sql)){
					echo  " -[<font color='#33CC33'>操作记录: 退款成功</font>]";
					
					
					
					$vvsql			= "update  ebay_rma set rastatus='关闭' where ebay_id ='$ebay_id' ";
					$dbcon->execute($vvsql);
					
					}
				} else  {
					echo "订单编号:<font color='#FF0000'> ". urldecode($httpParsedResponseAr['L_SHORTMESSAGE0']).'</font><br>';
					echo "订单编号<font color='#FF0000'>: ". urldecode($httpParsedResponseAr['L_LONGMESSAGE0']).'</font><br>';
					
				}
				
			}
	}
 ?>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
</div>

<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
		
	<td nowrap="nowrap" scope="row" > 订单编号/Paypal交易号：
	  <input name="keys" type="text" id="keys" />
	      状态：
	      <select name="searchstatus" id="searchstatus">
            <option value="">所有状态</option>
            <option value="0" <?php if($status == '0') echo 'selected="selected"';?> >待退款</option>
            <option value="1" <?php if($status == '1') echo 'selected="selected"';?>>待审核</option>
            <option value="2" <?php if($status == '2') echo 'selected="selected"';?>>已完成</option>
          </select>
	      <input type="button" value="查找" onclick="searchs()" /></td>
</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='10'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" width='2%' class='paginationActionButtons'>&nbsp;</td>
				  <td  nowrap='nowrap' width='1%' align="right" class='paginationChangeButtons'>				  </td>
				</tr>
			</table>		</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap">操作</th>
					<th scope='col' nowrap="nowrap">状态</th>
					<th scope='col' nowrap="nowrap">订单编号</th>
					<th scope='col' nowrap="nowrap">退款金额</th>
					<th scope='col' nowrap="nowrap">总金额</th>
                    <th scope='col' nowrap="nowrap">收款帐号</th>
                    <th scope='col' nowrap="nowrap">Paypal交易号</th>
        <th scope='col' nowrap="nowrap">提交日期/提交人</th>
					<th scope='col' nowrap="nowrap">审核日期/审核人</th>
					<th scope='col' nowrap="nowrap">退款日期/退款人</th>
					<th scope='col' nowrap="nowrap">操作</th>
	</tr>
   <?php 
				    
					if($status == ''){
					$sql = "select * from ebay_paypalrefund where  ebay_id > 0";
					
					}else{
					$sql = "select * from ebay_paypalrefund where  status = '$status' ";
					
					}
					if($_REQUEST['keys']!= ''){
						$keys	= trim($_REQUEST['keys']);
						$sql.= " and (ebay_id like '%$keys%' or ebay_ptid like '%$keys%' )";
					}
					$sql		.= " and ebay_user ='$user' ";
					
					
					$query		= $dbcon->query($sql);
					$total		= $dbcon->num_rows($query);
					$totalpages = $total;
					$pageindex  =( isset($_GET['pageindex']) )?$_GET['pageindex']:1;
					$limit = " limit ".($pageindex-1)*$pagesize.",$pagesize";


				$page=new page(array('total'=>$total,'perpage'=>$pagesize));

				$sql = $sql.$limit;
				$sql		= $dbcon->execute($sql);
				$sql		= $dbcon->getResultArray($sql);

			
					
					for($i=0;$i<count($sql);$i++){
						
						$status 		= $sql[$i]['status'];
						
						$ebayid 		= $sql[$i]['ebay_id'];
						
						/* 取得订单总金额 */
						
						
						$ss		= "select ebay_total from ebay_order where ebay_id ='$ebayid' ";
						$ss		= $dbcon->execute($ss);
						$ss		= $dbcon->getResultArray($ss);
				
						$ebay_total		= $ss[0]['ebay_total'];
						
						
						$pid 		= $sql[$i]['ebay_pid'];
						
						if($status == 0 ) $status = '待审核';
						if($status == 1 ) $status = '已审核';
						if($status == 2 ) $status = '已完成';
						
						$ebay_id 		= $sql[$i]['ebay_id'];
						$ebay_refundamount 		= $sql[$i]['ebay_refundamount'];
							
						$addtime 			= $sql[$i]['addtime'];
						$audittime	 		= $sql[$i]['audittime'];
						$refundtime 		= $sql[$i]['refundtime'];
						
						$addtimeuser 			= $sql[$i]['addtimeuser'];
						$audittimeuser	 		= $sql[$i]['audittimeuser'];
						$refundtimeuser 		= $sql[$i]['refundtimeuser'];
						
						$ebay_ptid		 		= $sql[$i]['ebay_ptid'];
						
						$paymentto_paypalaccount		 		= $sql[$i]['paymentto_paypalaccount'];
						if($addtime > 0 ){
						 $addtime			= date('Y-m-d H:i:s',$addtime);
						}else{
						$addtime = '';
						}
						
						if($audittime > 0 ){
						 $audittime			= date('Y-m-d H:i:s',$audittime);
						}else{
						$audittime = '';
						}
						
						
						if($refundtime > 0 ){
						 $refundtime			= date('Y-m-d H:i:s',$refundtime);
						}else{
						$refundtime = '';
						}
						
											
				  ?>
                  
                  
                  
		    
 
									<tr height='20' class='oddListRowS1'>
									  <td scope='row' align='left' valign="top" ><input name="ordersn" type="checkbox" id="ordersn" value="<?php echo $ebay_id;?>" /></td>
						              <td scope='row' align='left' valign="top" ><?php echo $status;?>&nbsp;</td>
						              <td scope='row' align='left' valign="top" ><?php echo $ebay_id;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $ebay_refundamount;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $ebay_total;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $paymentto_paypalaccount;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $ebay_ptid;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $addtime.' / '.$addtimeuser;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $audittime.' / '.$audittimeuser;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $refundtime.' / '.$refundtimeuser;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" >
                            <a href="#" onclick="rta('<?php echo $ebayid;?>','<?php echo $pid;?>')">查看RMA 申请</a>
                            
                            
                           <?php if($_REQUEST['status'] == '0' ){ ?> <a href="#" onclick="deletes('<?php echo $ebayid;?>','<?php echo $pid;?>')">清除此申请</a>   <?php } ?>
                            
                            
                            &nbsp;       
                              <?php if($_REQUEST['status'] == '0' ){ ?><input type="button" value="通过审核"  onclick="audit('1','<?php echo $sql[$i]['ebay_id'];?>')" /> <?php } ?>
                              <?php if($_REQUEST['status'] == 1 ){ ?><input type="button" value="反审核"   onclick="audit('0','<?php echo $sql[$i]['ebay_id'];?>')" />
                       <input type="button" value="确定退款"   onclick="audit('2','<?php echo $sql[$i]['ebay_id'];?>')"  /> <?php } ?></td>
			  </tr>
              <?php
			  }
			  ?>
              
                                    
                                    <tr height='20' class='oddListRowS1'>
									  <td colspan="10" align='left' valign="top" scope='row' ><?    echo '<br><center>'.$page->show(2)."</center>";//输出分页 ?></td>
	  </tr>
              
              

              
		<tr class='pagination'>
		<td colspan='10'>
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
	
	function deletes(id){
		if(confirm('您确认删除此条记录吗')){
			location.href = 'paypal_refund.php?type=del&ebayid='+id+"&module=paypalrefund";
		}
	}
	
	
	
	function audit(type,id){
	
	
		if(type == 1){
		if(confirm('确定审核通过吗') ){
			location.href = 'paypal_refund.php?type=audit&stype='+type+"&module=paypalrefund&status=<?php echo $_REQUEST['status']; ?>&ebay_id="+id;
		}
		}
		
		
		if(type == 0){
		if(confirm('确定反审核') ){
			location.href = 'paypal_refund.php?type=audit&stype='+type+"&module=paypalrefund&status=<?php echo $_REQUEST['status']; ?>&ebay_id="+id;
		}
		}
		
		if(type == 2){
		if(confirm('确定现在退款吗')  ){
			location.href = 'paypal_refund.php?type=audit&stype='+type+"&module=paypalrefund&status=<?php echo $_REQUEST['status']; ?>&ebay_id="+id;
		}
		}
	
	
	}
	
	
	function searchs(){
		var keys				= document.getElementById('keys').value;
		var searchstatus		= document.getElementById('searchstatus').value;
		var url		= 'paypal_refund.php?keys='+keys+'&module=paypalrefund&status='+searchstatus;
		location.href = url;
	}
	
	
	function rta(ebayid,pid){
		
		
		
		var url		= 'rma.php?ebayid='+ebayid+"&pid="+pid;
	
		openwindow(url,'',600,685);
	
	
	
	}
	
	
	
		
//设定打开窗口并居中
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



function exportxls(){


		var bill = '';
		
		
		var checkboxs = document.getElementsByName("ordersn");

    for(var i=0;i<checkboxs.length;i++){

		if(checkboxs[i].checked == true){

			
			bill = bill + ","+checkboxs[i].value;


		}	

		

	}

	if(bill == ""){
		alert("如果不选择任何记录，将会导出所有数据。");
	}
	
	var url = "labeltoxls.php?bill="+bill;
	window.open(url,"_blank");
		



}

</script>