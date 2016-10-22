<?php
	include "include/config.php";
	
	$solution				= $_REQUEST['solution'];
	$solutionmessage		= $_REQUEST['solutionmessage'];
	$shipdate				= $_REQUEST['shipdate'];
	$shipcarrier				= $_REQUEST['shipcarrier'];
	$id						= $_REQUEST['id'];
	
	
	$sql			= "select * from ebay_case where id='$id' and ebay_user = '$user' ";
	$sql			= $dbcon->execute($sql);
	$sql			= $dbcon->getResultArray($sql);
	$caseId		 	= $sql[0]['caseId'];
	$casetype		= $sql[0]['casetype'];
	$ebay_account		= $sql[0]['ebay_account'];
	
	
	
	$sql			= "select * from ebay_account where ebay_account='$ebay_account' and ebay_user = '$user' ";
	$sql			= $dbcon->execute($sql);
	$sql			= $dbcon->getResultArray($sql);
	
	$token		= $sql[0]['ebay_token'];
	
	
	if($solution == 'provideShippingInfo'){
		
			$headers = array (
			//Regulates versioning of the XML interface for the API
			
			'X-EBAY-SOA-SERVICE-NAME: ' . 'ResolutionCaseManagementService',
			//set the keys
			'X-EBAY-SOA-OPERATION-NAME: ' . 'provideShippingInfo',
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
<provideShippingInfoRequest xmlns="http://www.ebay.com/marketplace/resolution/v1/services">
<RequesterCredentials>
        <eBayAuthToken>'.$token.'</eBayAuthToken>
   </RequesterCredentials>
   <caseId> 
    <id>'.$caseId.'</id>
    <type>'.$casetype.'</type>
  </caseId>
  <carrierUsed>'.$shipcarrier.'</carrierUsed>
  <shippedDate>'.$shipdate.'</shippedDate>
  <comments><![CDATA['.$solutionmessage.']]></comments>
</provideShippingInfoRequest>
';


echo $requestXmlBody;
die();

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
		
		
		
		$ack			= $data['provideShippingInfoResponse']['ack'];
		
		if($ack == 'Success'){
				 GetEBPCaseDetail($token,$ebay_account,$caseId,$casetype,$id);
				 echo '成功提交到ebay';
				 
		}else{
			
				 echo '提交失败';
		}

		print_r($data);
	}
	
	
	
	
	
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
		echo $requestXmlBody;
		
		
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



		print_r($data);

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
			$respondByDate		= $Transaction['respondByDate'];
			$creationDate		= $Transaction['creationDate'];
			
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
						$addsql		= "INSERT INTO `v3-all`.`ebay_case` ( `caseId`, `casetype`, `useruserId`, `userrole`, `otherPartyuserId`, `otherPartyBUYER`, `UPIStatus`, `itemId`, `itemTitle`, 
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

	
	
	$dbcon->close();
?>