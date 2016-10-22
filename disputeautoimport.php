<?php


		
		@session_start();
	error_reporting(0);
	date_default_timezone_set ("Asia/Chongqing");	
	include "include/dbconnect.php";
	include "include/eBaySession.php";
	include "include/xmlhandle.php";
	include "include/ebay_lib.php";
	include "include/cls_page.php";
	include "include/ebay_liblist.php";
	$dbcon	= new DBClass();
	
	$siteID = 0;  
    $detailLevel = 0;
	$nowtime	= date("Y-m-d H:i:s");
	$nowd		= date("Y-m-d");
	$Sordersn	= "eBay";
	$pagesize	=20;//每页显示的数据条目数
	$mctime		= strtotime($nowtime);
	
	
	$compatabilityLevel = 551;
	$devID		= "cddef7a0-ded2-4135-bd11-62db8f6939ac";
	$appID		= "Survyc487-9ec7-4317-b443-41e7b9c5bdd";
	$certID		= "b68855dd-a8dc-4fd7-a22a-9a7fa109196f";
	$serverUrl	= "https://api.ebay.com/ws/api.dll";



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



		


	$cc			= date("Y-m-d H:i:s");
	$start		= date('Y-m-d H:i:s',strtotime("$cc -10080 minutes"));
	$start		= date('Y-m-d',strtotime($start)).'T'.date('H:i:s',strtotime($start));		
	
	$end		= date('Y-m-d',strtotime("$cc +0 days")).'T'.date('H:i:s',strtotime($cc));
	echo $start.'<br>'.$end;
	
	$vv				= "select distinct user  from ebay_user where user ='vipadmin' or user ='guangpai' or user = 'vipchi' or user = 'vipzz' ";
	
	
	echo $vv;
	
	$vv				= $dbcon->execute($vv);
	$vv				= $dbcon->getResultArray($vv);

	
	for($j=0;$j<count($vv);$j++){
		
		$user				= $vv[$j]['user'];
		
		
	
	
		$_SESSION['user']			=  $user;		
		$sql 		 = "select ebay_token,ebay_account from ebay_account where ebay_user='$user' and ebay_token != '' ";
		$sql		 = $dbcon->execute($sql);
		$sql		 = $dbcon->getResultArray($sql);
		
		
		for($i=0;$i<count($sql);$i++){
			
			
								 $token		 = $sql[$i]['ebay_token'];
								 $account	 = $sql[$i]['ebay_account'];
								 if($token != ""){
									 
										
										
										echo 'start:'.$account."\n\r";
										GetUserCaes($account,$token,$start,$end);
										
									 
								 }
								 
								 
			
			
			
		}
		
		
	}


			
		
				


				
				

			
 ?>


