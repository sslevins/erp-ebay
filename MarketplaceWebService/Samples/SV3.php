<?php
/** 
 *  PHP Version 5
 *
 *  @category    Amazon
 *  @package     MarketplaceWebService
 *  @copyright   Copyright 2009 Amazon Technologies, Inc.
 *  @link        http://aws.amazon.com
 *  @license     http://aws.amazon.com/apache2.0  Apache License, Version 2.0
 *  @version     2009-01-01
 */
/******************************************************************************* 

 *  Marketplace Web Service PHP5 Library
 *  Generated: Thu May 07 13:07:36 PDT 2009
 * 
 */

/**
 * Submit Feed  Sample
 */

include_once ('.config.inc.php'); 
error_reporting(E_ALL);

/************************************************************************
* Uncomment to configure the client instance. Configuration settings
* are:
*
* - MWS endpoint URL
* - Proxy host and port.
* - MaxErrorRetry.
***********************************************************************/
// IMPORTANT: Uncomment the approiate line for the country you wish to
// sell in:
// United States:

// United Kingdom
//$serviceUrl = "https://mws.amazonservices.co.uk";
// Germany
//$serviceUrl = "https://mws.amazonservices.de";
// France
//$serviceUrl = "https://mws.amazonservices.fr";
// Italy
//$serviceUrl = "https://mws.amazonservices.it";
// Japan
//$serviceUrl = "https://mws.amazonservices.jp";
// China
//$serviceUrl = "https://mws.amazonservices.com.cn";
// Canada
//$serviceUrl = "https://mws.amazonservices.ca";
// India
//$serviceUrl = "https://mws.amazonservices.in";


/************************************************************************
 * Instantiate Implementation of MarketplaceWebService
 * 
 * AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY constants 
 * are defined in the .config.inc.php located in the same 
 * directory as this sample
 ***********************************************************************/

 
/************************************************************************
 * Uncomment to try out Mock Service that simulates MarketplaceWebService
 * responses without calling MarketplaceWebService service.
 *
 * Responses are loaded from local XML files. You can tweak XML files to
 * experiment with various outputs during development
 *
 * XML files available under MarketplaceWebService/Mock tree
 *
 ***********************************************************************/
 // $service = new MarketplaceWebService_Mock();

/************************************************************************
 * Setup request parameters and uncomment invoke to try out 
 * sample for Submit Feed Action
 ***********************************************************************/
 // @TODO: set request. Action can be passed as MarketplaceWebService_Model_SubmitFeedRequest
 // object or array of parameters

// Note that PHP memory streams have a default limit of 2M before switching to disk. While you
// can set the limit higher to accomidate your feed in memory, it's recommended that you store
// your feed on disk and use traditional file streams to submit your feeds. For conciseness, this
// examples uses a memory stream.




function markettoamazon($Itemstr,$ebay_id){


	global $MERCHANT_ID,$request,$service,$dbcon,$user,$nowtime;
	
	
	
	$serviceUrl = "https://mws.amazonservices.com";


 

	$start0						= strtotime("$nowtime -16 hours");
	$shiptime					= date('Y-m-d',$start0).'T'.date('H:i:s',$start0).'-00:00';



	$sq			 = "select * from ebay_order where ebay_id='$ebay_id'";
	

	
	$sq			 = $dbcon->execute($sq);
	$sq			 = $dbcon->getResultArray($sq);
	$account						= $sq[0]['ebay_account'];


	$sql 					 = "select * from ebay_account where ebay_user='$user' and ebay_account='$account'";
	

	
	$sql					 = $dbcon->execute($sql);
	$sql					 = $dbcon->getResultArray($sql);
	$token					 = $sql[0]['ebay_token'];     // ebay toekn
	$MERCHANT_ID			 = $sql[0]['MERCHANT_ID'];    // amazon key
	$MARKETPLACE_ID			 = $sql[0]['MARKETPLACE_ID']; // amazon key
	$AWS_ACCESS_KEY_ID		 = $sql[0]['AWS_ACCESS_KEY_ID']; // amazon key
	$AWS_SECRET_ACCESS_KEY	 = $sql[0]['AWS_SECRET_ACCESS_KEY']; // amazon key
	
	$serviceUrl				 = 	$sql[0]['serviceUrl']; // amazon key
	$config = array (
	  'ServiceURL' => $serviceUrl,
	  'ProxyHost' => null,
	  'ProxyPort' => -1,
	  'MaxErrorRetry' => 3,
	);



	$service = new MarketplaceWebService_Client(
     $AWS_ACCESS_KEY_ID, 
     $AWS_SECRET_ACCESS_KEY, 
     $config,
     APPLICATION_NAME,
     APPLICATION_VERSION);
	 
	 

	
	







$feed = <<<EOD
<?xml version="1.0" encoding="UTF-8"?>
<AmazonEnvelope xsi:noNamespaceSchemaLocation="amzn-envelope.xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
    <Header>
        <DocumentVersion>1.01</DocumentVersion>
        <MerchantIdentifier>$MERCHANT_ID</MerchantIdentifier>
    </Header>
    <MessageType>OrderFulfillment</MessageType>
    $Itemstr
</AmazonEnvelope>
EOD;






$marketplaceIdArray = array("Id" => array($MARKETPLACE_ID));
     

$feedHandle = @fopen('php://temp', 'rw+');
fwrite($feedHandle, $feed);
rewind($feedHandle);
$parameters = array (
  'Merchant' => $MERCHANT_ID,
  'MarketplaceIdList' => $marketplaceIdArray,
  'FeedType' => '_POST_ORDER_FULFILLMENT_DATA_',
  'FeedContent' => $feedHandle,
  'PurgeAndReplace' => false,
  'ContentMd5' => base64_encode(md5(stream_get_contents($feedHandle), true)),
);



rewind($feedHandle);





$request = new MarketplaceWebService_Model_SubmitFeedRequest($parameters);


invokeSubmitFeed($service, $request,$ebay_id);

@fclose($feedHandle);
                                        
 }



 
  function invokeSubmitFeed(MarketplaceWebService_Interface $service, $request,$ebay_id) 
  {
  
  		global $dbcon,$mctime;
        
      try {
              $response = $service->submitFeed($request);




               if ($response->isSetSubmitFeedResult()) { 
                    $submitFeedResult = $response->getSubmitFeedResult();
                    if ($submitFeedResult->isSetFeedSubmissionInfo()) { 
                        $feedSubmissionInfo = $submitFeedResult->getFeedSubmissionInfo();
                        if ($feedSubmissionInfo->isSetFeedSubmissionId()) 
                        {
                            echo("                        " . $feedSubmissionInfo->getFeedSubmissionId() . "\n");

						//	$sb		= "update ebay_order set ebay_markettime='$mctime',ShippedTime='$mctime' where ebay_id='$ebay_id'";
                            
                            echo '所有订单已经成功提交到amazon'.'<br>';
                            
						//	$dbcon->execute($sb);

                        }
            
                    } 
                } 
                

             //   echo("            ResponseHeaderMetadata: " . $response->getResponseHeaderMetadata() . "\n");
     } catch (MarketplaceWebService_Exception $ex) {
         echo("Caught Exception: " . $ex->getMessage() . "\n");
         echo("Response Status Code: " . $ex->getStatusCode() . "\n");
         echo("Error Code: " . $ex->getErrorCode() . "\n");
         echo("Error Type: " . $ex->getErrorType() . "\n");
         echo("Request ID: " . $ex->getRequestId() . "\n");
         echo("XML: " . $ex->getXML() . "\n");
         echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");
     }

 
														  

														  }
?>
