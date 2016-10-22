<?php
include "include/config.php";
include "top.php";




$start		= date('Y-m-d');
$end		= date('Y-m-d');
$start						= date('Y-m-d',strtotime("$end - 1 days"));


function GetEBPCaseDetail($token,$account,$id,$type,$addid){
		
		global $dbcon,$user;


				$headers = array (
			//Regulates versioning of the XML interface for the API
			
			'X-EBAY-SOA-SERVICE-NAME: ' . 'ResolutionCaseManagementService',
			//set the keys
			'X-EBAY-SOA-OPERATION-NAME: ' . 'getEBPCaseDetail',
			'X-EBAY-SOA-SERVICE-VERSION: ' . '1.3.0',
			'X-EBAY-SOA-GLOBAL-ID: ' . 'EBAY-US',
			
			//the name of the call we are requesting
			'X-EBAY-SOA-SECURITY-TOKEN: ' . $token,			
			
			//SiteID must also be set in the Request's XML
			//SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
			//SiteID Indicates the eBay site to associate the call with
			'X-EBAY-SOA-REQUEST-DATA-FORMAT: ' . 'XML',
		);
		
			
			$requestXmlBody   = '<?xml version="1.0" encoding="utf-8"?>
<getEBPCaseDetailRequest xmlns="http://www.ebay.com/marketplace/resolution/v1/services">
   <caseId> 
    <id>'.$id.'</id>
    <type>'.$type.'</type>
  </caseId>
</getEBPCaseDetailRequest>
';
	//	echo $requestXmlBody;
		
		
		//initialise a CURL session
		$connection = curl_init();
		//set the server we are using (could be Sandbox or Production server)
		curl_setopt($connection, CURLOPT_URL, 'https://svcs.ebay.com/services/resolution/v1/ResolutionCaseManagementService');
		
		//stop CURL from verifying the peer's certificate
		curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);
		
		//set the headers using the array of headers
		curl_setopt($connection, CURLOPT_HTTPHEADER, $headers);
		
		//set method as POST
		curl_setopt($connection, CURLOPT_POST, 1);
		
		//set the XML body of the request
		curl_setopt($connection, CURLOPT_POSTFIELDS, $requestXmlBody);
		
		//set it to return the transfer as a string from curl_exec
		curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
		
		//Send the Request
		$response = curl_exec($connection);
		
		//close the connection
		curl_close($connection);
		$data=XML_unserialize($response); 



	//	print_r($data);

		$Transaction	 						= $data['getEBPCaseDetailResponse']['caseSummary'];  


			$caseId 				= $Transaction['caseId']['id'];	
			$casetype 			= $Transaction['caseId']['type'];
			$useruserId 		= $Transaction['user']['userId'];
			$userrole	 		= $Transaction['user']['role'];	
			$otherPartyuserId 	= $Transaction['otherParty']['userId'];	
			$otherPartyBUYER	= $Transaction['otherParty']['role'];	
			$UPIStatus			= $Transaction['status']['EBPINRStatus'];	


			if($casetype == 'EBP_SNAD') $UPIStatus			= $Transaction['status']['EBPSNADStatus'];	
			
			$itemId				= $Transaction['item']['itemId'];	
			$itemTitle			= mysql_escape_string($Transaction['item']['itemTitle']);	
			$transactionId		= $Transaction['item']['transactionId'];	
			
			$caseQuantity		= $Transaction['caseQuantity'];
			$currencyId			= $Transaction['caseAmount attr']['currencyId'];
			$caseAmount			= $Transaction['caseAmount'];
			$respondByDate		= strtotime($Transaction['respondByDate']);
			$creationDate		= strtotime($Transaction['creationDate']);
			
			$openReason			= $data['getEBPCaseDetailResponse']['caseDetail']['openReason'];
			$decision			= $data['getEBPCaseDetailResponse']['caseDetail']['decision'];
			$FVFCredited		= $data['getEBPCaseDetailResponse']['caseDetail']['FVFCredited'];
			$globalId			= $data['getEBPCaseDetailResponse']['caseDetail']['globalId'];
			$agreedRefundAmount			= $data['getEBPCaseDetailResponse']['caseDetail']['agreedRefundAmount'];

			$detailStatusInfo_code			= $data['getEBPCaseDetailResponse']['caseDetail']['detailStatusInfo']['code'];
			$detailStatusInfo_description	= mysql_escape_string($data['getEBPCaseDetailResponse']['caseDetail']['detailStatusInfo']['description']);
			$detailStatusInfo_content		= mysql_escape_string($data['getEBPCaseDetailResponse']['caseDetail']['detailStatusInfo']['content']);

			$initialBuyerExpectationDetail_code						= $data['getEBPCaseDetailResponse']['caseDetail']['initialBuyerExpectationDetail']['code'];
			$initialBuyerExpectationDetail_description				= mysql_escape_string($data['getEBPCaseDetailResponse']['caseDetail']['initialBuyerExpectationDetail']['description']);
			$initialBuyerExpectationDetail_content					= mysql_escape_string($data['getEBPCaseDetailResponse']['caseDetail']['initialBuyerExpectationDetail']['content']);


			$decisionReasonDetail_code			= $data['getEBPCaseDetailResponse']['caseDetail']['decisionReasonDetail']['code'];
			$decisionReasonDetail_description	= mysql_escape_string($data['getEBPCaseDetailResponse']['caseDetail']['decisionReasonDetail']['description']);
			$decisionReasonDetail_content		= mysql_escape_string($data['getEBPCaseDetailResponse']['caseDetail']['decisionReasonDetail']['content']);





				
					
					
					if($addid == '' ){
						$addsql		= "INSERT INTO `ebay_case` ( `caseId`, `casetype`, `useruserId`, `userrole`, `otherPartyuserId`, `otherPartyBUYER`, `UPIStatus`, `itemId`, `itemTitle`, 
						`transactionId`, `caseQuantity`, currencyId, `caseAmount`, `respondByDate`, `creationDate`, `ebay_account`, `ebay_user`, `openReason`, `decision`, `FVFCredited`, `globalId`, `agreedRefundAmount`, `detailStatusInfo_code`, `detailStatusInfo_description`, `detailStatusInfo_content`, `initialBuyerExpectationDetail_code`, `initialBuyerExpectationDetail_description`, `initialBuyerExpectationDetail_content`) VALUES ( '".$caseId."', '".$casetype."', '".$useruserId."', '".$userrole."', '".$otherPartyuserId."', '".$otherPartyBUYER."', '".$UPIStatus."', '".$itemId."', '".$itemTitle."', '$transactionId', '$caseQuantity', '$currencyId', '$caseAmount', '$respondByDate', '$creationDate', '$account', '$user', '$openReason','$decision','FVFCredited','$globalId','$agreedRefundAmount','$detailStatusInfo_code','$detailStatusInfo_description','$detailStatusInfo_content','$initialBuyerExpectationDetail_code','$initialBuyerExpectationDetail_description','$initialBuyerExpectationDetail_content');";	
						

						if($dbcon->execute($addsql)){
							echo $id.' 添加成功<br>';
						}else{
							echo $id.' 添加失败<br>';
						}

					}else{

						
						$updatesql	=  "update `ebay_case` set decisionReasonDetail_code='$decisionReasonDetail_code',decisionReasonDetail_description='$decisionReasonDetail_description' ,";
						$updatesql  .= "decisionReasonDetail_content='$decisionReasonDetail_content',UPIStatus='$UPIStatus' ";

						$updatesql	.= " where id ='$addid' ";

						echo $updatesql;

						
						if($dbcon->execute($updatesql)){
							echo $id.' 修改成功<br>';
						}else{
							echo $id.' 修改成功<br>';
						}






					}
						

					

						
						

						/* 添加明细表 */


						$responseHistory		= $data['getEBPCaseDetailResponse']['caseDetail']['responseHistory'];

						if($data['getEBPCaseDetailResponse']['caseDetail']['responseHistory'] != ''){


								if($data['getEBPCaseDetailResponse']['caseDetail']['responseHistory']['note'] != '' ){
												

												$responseHistory								= array();
												$responseHistory[0] 							= $data['getEBPCaseDetailResponse']['caseDetail']['responseHistory'];


								}


						foreach((array)$responseHistory as $espmessage){


								

								$note					= mysql_escape_string($espmessage['note']);
								$role					= $espmessage['author']['role'];
								$code					= $espmessage['activityDetail']['code'];
								$description			= mysql_escape_string($espmessage['activityDetail']['description']);
								$creationDate			= $espmessage['creationDate'];
								
								
									$ss		= "select id  from ebay_casedetail where caseId='$caseId' and ebay_account='$account' and creationDate ='$creationDate'";
									$ss		= $dbcon->execute($ss);
									$ss		= $dbcon->getResultArray($ss);

									if(count($ss) == 0){
													$addsql	 = "insert into ebay_casedetail(note,role,code,description,creationDate,caseId,ebay_account,ebay_user) values('$note','$role','$code','$description','$creationDate','$caseId','$account','$user')";
													$dbcon->execute($addsql);
									}


								

						}

						}




		


		
	
	
	
}

function GetUserCaes($account,$token,$start,$end){
				
				global $dbcon,$user;
				
				$headers = array (
			//Regulates versioning of the XML interface for the API
			
			'X-EBAY-SOA-SERVICE-NAME: ' . 'ResolutionCaseManagementService',
			//set the keys
			'X-EBAY-SOA-OPERATION-NAME: ' . 'getUserCases',
			'X-EBAY-SOA-SERVICE-VERSION: ' . '1.3.0',
			'X-EBAY-SOA-GLOBAL-ID: ' . 'EBAY-US',
			
			//the name of the call we are requesting
			'X-EBAY-SOA-SECURITY-TOKEN: ' . $token,			
			
			//SiteID must also be set in the Request's XML
			//SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
			//SiteID Indicates the eBay site to associate the call with
			'X-EBAY-SOA-REQUEST-DATA-FORMAT: ' . 'XML',
		);
		
		
		$pcount	= 1;
		
			while(true){
			$requestXmlBody   = '<?xml version="1.0" encoding="utf-8"?>
<getUserCasesRequest xmlns="http://www.ebay.com/marketplace/resolution/v1/services">
 <creationDateRangeFilter> DateRangeFilterType
    <fromDate>'.$start.'</fromDate>
    <toDate>'.$end.'</toDate>
  </creationDateRangeFilter>
  <caseTypeFilter>
    <caseType>EBP_INR</caseType>
	 <caseType>EBP_SNAD</caseType>
	  <caseType>INR</caseType>
	  <caseType>SNAD</caseType>
  </caseTypeFilter>
   <paginationInput>
      <entriesPerPage>100</entriesPerPage>
      <pageNumber>'.$pcount.'</pageNumber>
   </paginationInput>
   <sortOrder>CREATION_DATE_ASCENDING</sortOrder>
</getUserCasesRequest>
';
		
		
		
		//initialise a CURL session
		$connection = curl_init();
		//set the server we are using (could be Sandbox or Production server)
		curl_setopt($connection, CURLOPT_URL, 'https://svcs.ebay.com/services/resolution/v1/ResolutionCaseManagementService');
		
		//stop CURL from verifying the peer's certificate
		curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);
		
		//set the headers using the array of headers
		curl_setopt($connection, CURLOPT_HTTPHEADER, $headers);
		
		//set method as POST
		curl_setopt($connection, CURLOPT_POST, 1);
		
		//set the XML body of the request
		curl_setopt($connection, CURLOPT_POSTFIELDS, $requestXmlBody);
		
		//set it to return the transfer as a string from curl_exec
		curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
		
		//Send the Request
		$response = curl_exec($connection);
		
		//close the connection
		curl_close($connection);
		$data=XML_unserialize($response); 
		
	
		$totalPages		= $data['getUserCasesResponse']['paginationOutput']['totalPages'];
		
		

		

		if($data['getUserCasesResponse']['ack'] != 'Success') return;


		$Trans	 						= $data['getUserCasesResponse']['cases']['caseSummary'];  

		if($data['getUserCasesResponse']['cases']['caseSummary'] == '') break;




		if($data['getUserCasesResponse']['cases']['caseSummary']['caseId']['id'] != '' ){

				
				$Trans								= array();
				$Trans[0] 							= $data['getUserCasesResponse']['cases']['caseSummary'];



		}
		
	print_r($data);
	





		foreach((array)$Trans as $Transaction){
		
			
			$caseId 			= $Transaction['caseId']['id'];	
			$casetype 			= $Transaction['caseId']['type'];
			$useruserId 		= $Transaction['user']['userId'];
			$userrole	 		= $Transaction['user']['role'];	
			$otherPartyuserId 	= $Transaction['otherParty']['userId'];	
			$otherPartyBUYER	= $Transaction['otherParty']['role'];	
			$UPIStatus			= $Transaction['status']['UPIStatus'];	
			
			$itemId				= $Transaction['item']['itemId'];	
			$itemTitle			= mysql_escape_string($Transaction['item']['itemTitle']);	
			$transactionId		= $Transaction['item']['transactionId'];	
			
			$caseQuantity		= $Transaction['caseQuantity'];
			$currencyId			= $Transaction['caseAmount attr']['currencyId'];
			$caseAmount			= $Transaction['caseAmount'];
			$respondByDate		= $Transaction['respondByDate'];
			$creationDate		= $Transaction['creationDate'];
			
			
					
					$ss		= "select id  from ebay_case where caseId='$caseId' and ebay_account='$account'";
					$ss		= $dbcon->execute($ss);
					$ss		= $dbcon->getResultArray($ss);
					
					
					if(count($ss) == 0){
					GetEBPCaseDetail($token,$account,$caseId,$casetype);   // 添加case 
					}else{
					
					$id		= $ss[0]['id'];
					GetEBPCaseDetail($token,$account,$caseId,$casetype,$id);   // 修改case 
					
					}
					
			
			
			//echo $caseId;
			
			
			
			
		}
		
					
		if($pcount >= $totalPages){
			echo '退出了';
			break;
		 }
		 
		 $pcount	++;
		 
		 
		
			}
		
		}




$account	= $_REQUEST['account'];

			
			if($account != ''){
				
							
							$start0			= $_REQUEST['start'].'T00:00:00';
					 		$end0			= $_REQUEST['end'].'T23:59:59';
							
							
						
							if($account 	== 'all'){
							$sql 		 = "select ebay_token,ebay_account from ebay_account as a where a.ebay_user='$user' and ($ebayacc) ";
							}else{
							$sql 		 = "select ebay_token,ebay_account from ebay_account as a where a.ebay_user='$user' and ebay_account ='$account' ";
							}
							$sqla		 = $dbcon->execute($sql);
							$sql		 = $dbcon->getResultArray($sqla);
							for($i=0;$i<count($sql);$i++){
								 $token		 = $sql[$i]['ebay_token'];
								 $account	 = $sql[$i]['ebay_account'];
								 if($token != ""){
									 
									 	
										
										
										GetUserCaes($account,$token,$start0,$end0);
										
										
									 
								 }
							}
							
					
				
				
				
			}
			
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

                

			    <form method="post" action="addaccount.php">   

			      <tr>

                    <td width="41%" height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right"> eBay帐号 </div></td>

                    <td width="3%" align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>

                    <td width="56%" height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">

                    <select name="account" id="account">
                    
                    <?php 
					$sql	 = "select ebay_account from ebay_account as a where a.ebay_user='$user' and ($ebayacc) and ebay_token != '' order by ebay_account desc ";
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
		location.href='dispute_import.php?account='+account+"&module=dispute&action=Loading Orders Results&start="+start+"&end="+end;
	}
</script>