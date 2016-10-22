<?php
@session_start();
$title	= "---";
error_reporting(E_ALL);
include "dbconnect.php";
$dbcon	= new DBClass();



$user	= 'survy';



//if($user == 'vipbin') die('请联系管理员QQ: 287311025');

include "eBaySession.php";
include "xmlhandle.php";
include "ebay_lib.php";
include "cls_page.php";
include "ebay_liblist.php";
date_default_timezone_set ("Asia/Chongqing");
$compatabilityLevel = 551;
$devID		= "cddef7a0-ded2-4135-bd11-62db8f6939ac";
$appID		= "Survyc487-9ec7-4317-b443-41e7b9c5bdd";
$certID		= "b68855dd-a8dc-4fd7-a22a-9a7fa109196f";
$serverUrl	= "https://api.ebay.com/ws/api.dll";
$siteID = 0;  
$detailLevel = 0;
$nowtime	= date("Y-m-d H:i:s");
$nowd		= date("Y-m-d");
$Sordersn	= "eBay";
$pagesize=20;//每页显示的数据条目数
$mctime		= strtotime($nowtime);



$truename	= $_SESSION['truename'];
/*王民伟   2012-04-19 根据登录名检索所在部门*/
	$getDept="select department from ebay_user where username='$truename'";
	$getDept=$dbcon->execute($getDept);
	$getDept=$dbcon->getResultArray($getDept);
	$deptName=$getDept[0]['department'];
/*end */
$sql		= "select * from ebay_user where username='$truename'";
$sql		= $dbcon->execute($sql);
$sql		= $dbcon->getResultArray($sql);
$pagesize	= $sql[0]['record']?$sql[0]['record']:"20";
relist();


		function relist($token,$ordersn){
		
		
			 global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$dbcon;
			
			 $verb = 'RelistItem';
			$xmlRequest		= '<?xml version="1.0" encoding="utf-8"?>
<RelistItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
  <RequesterCredentials>
    <eBayAuthToken>AgAAAA**AQAAAA**aAAAAA**pRHrTw**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AEkoelC5eEpgydj6x9nY+seQ**GhMBAA**AAMAAA**Rc7qqvUloA/1t8fpu5kQzrFMXKat5fvvZ6KOi2oLw9sWA80CkP+ybwlBhd6fy9IvXKriR/mltp4qPEmZSvoD3QMvYtc0lRulisft57ASvp/mH27ZG6HssKV1zZ392jGGWqRISzIB09pnSkt2JHo5ZLTmz1YDGTary3RYW1ip5gxwNaLapl7PsHZTWOQzdzfyJ5KKW3AuLNLxCIxbRP6HOxsWsHDu/QgcyLkzigo6B3w/JbuyQ+gFF4v5ndh+VWBeSifwS3Lk3chJVpGrov2rYzgxVUn+V1i/ZHpJZ+qISGXOnGhNCymYTmw0KzYdHcYZ4Nlhyh6UE+s9nUz9auUNHdXOGvbRIL3gv3v1myi+px7Aygct8UyQZch3jZ8KKTRhbrDVPWmM6CU/ffsq/odQXRDymhGLrVdvyQCzX9X0+i4J1aNpsmIjMaWAu19/JmyR9S1phfJollqinyMUal8zKZHYwAPSeTYvXpakIF8EyvnU3Jbc9c6/LPpO6AFIi1tBjL+z2XCXjwfIupW7s0aGv20S8m+gG8M2a3tuB5M9CRH4F1z8rwfT1rjHFzLoSOhwBWOmhFYzYUG02rue0M0UV5EipD5taQzYrTWTx18w6ZiA+o/PIPOpoN6Wcg8bhymzj7/0HVAG/atUGVGsDjZLyrOdaH13in7x6rsciOao6F+ywIDxeffE9ZBAXhDavABqfg/CHVlsjMKa6YL9KzyZ3DO3eDvL52UmaGKWh5UcBiAz+CLXksY3xuerzJKtJOSQ</eBayAuthToken>
  </RequesterCredentials>
  <Item>
    <ItemID>170899089619</ItemID>
  </Item>
</RelistItemRequest>';
			
			echo $xmlRequest;

			
			 $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
			 $responseXml = $session->sendHttpRequest($xmlRequest);
			 if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';
			$data	= XML_unserialize($responseXml);
		print_r($data);
	
		
		
		
		
		}
		
		
		
		function liststatusf($id){
			

			global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$dbcon;
			
			$ss					= "select * from ebay_list where id='$id'";
			$ss					= $dbcon->execute($ss);
			$ss					= $dbcon->getResultArray($ss);
			$ebay_account		= $ss[0]['ebay_account'];	
			$token				= geteBayaccountToken($ebay_account);
			$ItemID				= $ss[0]['ItemID'];	
			
			$verb = 'GetItem';		


$token = 'AgAAAA**AQAAAA**aAAAAA**pRHrTw**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AEkoelC5eEpgydj6x9nY+seQ**GhMBAA**AAMAAA**Rc7qqvUloA/1t8fpu5kQzrFMXKat5fvvZ6KOi2oLw9sWA80CkP+ybwlBhd6fy9IvXKriR/mltp4qPEmZSvoD3QMvYtc0lRulisft57ASvp/mH27ZG6HssKV1zZ392jGGWqRISzIB09pnSkt2JHo5ZLTmz1YDGTary3RYW1ip5gxwNaLapl7PsHZTWOQzdzfyJ5KKW3AuLNLxCIxbRP6HOxsWsHDu/QgcyLkzigo6B3w/JbuyQ+gFF4v5ndh+VWBeSifwS3Lk3chJVpGrov2rYzgxVUn+V1i/ZHpJZ+qISGXOnGhNCymYTmw0KzYdHcYZ4Nlhyh6UE+s9nUz9auUNHdXOGvbRIL3gv3v1myi+px7Aygct8UyQZch3jZ8KKTRhbrDVPWmM6CU/ffsq/odQXRDymhGLrVdvyQCzX9X0+i4J1aNpsmIjMaWAu19/JmyR9S1phfJollqinyMUal8zKZHYwAPSeTYvXpakIF8EyvnU3Jbc9c6/LPpO6AFIi1tBjL+z2XCXjwfIupW7s0aGv20S8m+gG8M2a3tuB5M9CRH4F1z8rwfT1rjHFzLoSOhwBWOmhFYzYUG02rue0M0UV5EipD5taQzYrTWTx18w6ZiA+o/PIPOpoN6Wcg8bhymzj7/0HVAG/atUGVGsDjZLyrOdaH13in7x6rsciOao6F+ywIDxeffE9ZBAXhDavABqfg/CHVlsjMKa6YL9KzyZ3DO3eDvL52UmaGKWh5UcBiAz+CLXksY3xuerzJKtJOSQ';
		

		$requestXmlBody	= '<?xml version="1.0" encoding="utf-8"?>

		<GetItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
		<OutputSelector>Item.SellingStatus.ListingStatus</OutputSelector>
		<IncludeItemSpecifics>true</IncludeItemSpecifics>
		<RequesterCredentials>
		<eBayAuthToken>'.$token.'</eBayAuthToken>
		</RequesterCredentials>
		<ItemID>170899086051</ItemID>
		<DetailLevel>ReturnAll</DetailLevel>		 
		</GetItemRequest>';
		$compatabilityLevel	= '739';

		$session = new eBaySession($token, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);   

		$responseXml = $session->sendHttpRequest($requestXmlBody);

		$responseDoc = new DomDocument();	

		$responseDoc->loadXML($responseXml);   

		$errors = $responseDoc->getElementsByTagName('Errors');	

		$data	= XML_unserialize($responseXml);
		
print_r($data);
die();


		$ListingStatus		= $data['GetItemResponse']['Item']['SellingStatus']['ListingStatus'];
		
		if($ListingStatus != 'Active'){
				
				$id	 = $ss[0]['id'];
				$ss	 = "update ebay_list set status='1' where id='$id'";
				$dbcon->execute($ss);
				echo "<br>Item number: 状态更新成功";
				
		}
		
	
			
		}
	
?>