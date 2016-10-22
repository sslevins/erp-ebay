<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EUB</title>
</head>

<body>

<?PHP

		
		include "include/xmlhandle.php";
		
		error_reporting(E_ALL);
		
		
		$headers = array (
			//Regulates versioning of the XML interface for the API
			'X-EBAY-SOA-SERVICE-NAME: ' . 'ResolutionCaseManagementService',
			
			//set the keys
			'X-EBAY-SOA-OPERATION-NAME: ' . 'getEBPCaseDetail',
			'X-EBAY-SOA-SERVICE-VERSION: ' . '1.1.0',
			'X-EBAY-SOA-GLOBAL-ID: ' . 'EBAY-US',
			
			//the name of the call we are requesting
			'X-EBAY-SOA-SECURITY-TOKEN: ' . 'AgAAAA**AQAAAA**aAAAAA**HXy9UA**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AEkoelC5eEpgydj6x9nY+seQ**1a4BAA**AAMAAA**pMLL7heNBHPomrM/6ljaUJDVVKQrvOKPGFPcyZvWSL+fpw7DV/AAtALNKM1EHBofgnpw/za5KrdJFMpIONQLCGh6QQMhJGsHELUwTQh6xiILbZjvf3sfhfsELDghoEKn1HMjDyqZh6bsK3hY0Ha873bIiuEz/FK6HtruMRGZRfUNWT5Jm8AeSouUOZ8z3gejF3jTSuP8jhxuWQoHNWVLJ66J5McsLgWPO45iWslw+Vdim66iwdmpw2j0m71+J8lx5grKarSgthkD/qifbM9HIOR8Nwxg78v5l+DMIRRsuWoo5DEpbrDggFVfK6Sl31KJJthIsTYlmkk2COVc67zr7JQN+biyxeaCdfdjwS3cKpLVvCBMyVX+MKxyHwZ4YksAKXF43ZsTO5YP8wy1fe25IBhWyoxuQXauRVaoard//z4vu1XeNc3BvJQHF4LqTQm5E79yRalhWz46GoP8ReLFrbVCngnANgoVp5QRGPipp3WdBlc/aSHh94ejiM061AfSe+qsJebjM4XmnY31Yhs1mX/RG3Odhr1WDp+4+gprUlLTpWdwQE/CGV8q9XyI65H/6kxom2w46sfZdJSq8Bv9lKkfhPQ3pshm+HtB2+BYJCGZzh+LDznk7KctAtEzu7lJpQUmV/UqZDh76Wi2XIm208yPg/OJ9NW24Xmx2F9/rDqLT9rZ1cwdeu/yZuzBojI/1EhR5b/SL4QANdI4O/HDXx3qES9nFaSQY2iqPHP2W7e3lN0zgDOFyCj19/nLZ/Bt',			
			
			//SiteID must also be set in the Request's XML
			//SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
			//SiteID Indicates the eBay site to associate the call with
			'X-EBAY-SOA-REQUEST-DATA-FORMAT: ' . 'XML',
		);
		
		
		
		
		$requestXmlBody	= '<?xml version="1.0" encoding="utf-8"?>
<getEBPCaseDetailRequest xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:ser="http://www.ebay.com/marketplace/resolution/v1/services">  
   <caseId>
      <id>5025268853</id>
      <type>EBP_SNAD</type>
   </caseId>
</getEBPCaseDetailRequest>';
		
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
		
	
print_r($response).'dddd';






?>



</body>
</html>
