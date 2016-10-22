<?php
/** 
 *  PHP Version 5
 *
 *  @category    Amazon
 *  @package     MarketplaceWebServiceOrders
 *  @copyright   Copyright 2008-2009 Amazon.com, Inc. or its affiliates. All Rights Reserved.
 *  @link        http://aws.amazon.com
 *  @license     http://aws.amazon.com/apache2.0  Apache License, Version 2.0
 *  @version     2011-01-01
 */
/******************************************************************************* 
 *  Marketplace Web Service Orders PHP5 Library
 *  Generated: Fri Jan 21 18:53:17 UTC 2011
 * 
 */

/**
 * List Orders  Sample
 */

		
	@session_start();
	error_reporting(E_ALL);
	date_default_timezone_set ("Asia/Chongqing");	
	include "dbconnect.php";

	echo 'ddd';


	$dbcon	= new DBClass();
	
	echo 'ccc';
	
	
require_once ('Client.php');
require_once ('Address.php');

require_once ('Error.php');
require_once ('ErrorResponse.php');
require_once ('FulfillmentChannelList.php');
require_once ('GetOrderRequest.php');
require_once ('GetOrderResponse.php');

require_once ('GetOrderResult.php');
require_once ('GetServiceStatusRequest.php');
require_once ('GetServiceStatusResponse.php');
require_once ('GetServiceStatusResult.php');
require_once ('Interface.php');
require_once ('ListOrderItemsByNextTokenRequest.php');
require_once ('ListOrderItemsByNextTokenResponse.php');
require_once ('ListOrderItemsByNextTokenResult.php');
require_once ('ListOrderItemsRequest.php');
require_once ('ListOrderItemsResponse.php');
require_once ('ListOrderItemsResult.php');
require_once ('ListOrdersByNextTokenRequest.php');
require_once ('ListOrdersByNextTokenResponse.php');
require_once ('ListOrdersByNextTokenResult.php');
require_once ('ListOrdersRequest.php');
require_once ('ListOrdersResponse.php');
require_once ('ListOrdersResult.php');
require_once ('MarketplaceIdList.php');
require_once ('MaxResults.php');
require_once ('Message.php');
require_once ('MessageList.php');
require_once ('Order.php');
require_once ('OrderIdList.php');
require_once ('OrderItem.php');
require_once ('OrderItemList.php');
require_once ('OrderList.php');
require_once ('OrderStatusList.php');



	
	
	$end						= date('Y-m-d H:i:s');	
	
	//$start		= date('Y-m-d H:i:s',strtotime('-0 hour',strtotime($start)));
	//$end		= date('Y-m-d H:i:s',strtotime('-0 hour',strtotime($end.date('H:i:s'))));	
	$astart						= date('Y-m-d H:i:s',strtotime("$end -600 minutes"));
	$vv				= "select distinct user  from ebay_user where user ='vipzwm' ";
	$vv				= $dbcon->execute($vv);
	$vv				= $dbcon->getResultArray($vv);

	for($j=0;$j<count($vv);$j++){
		$user				= $vv[$j]['user'];
		
		
		$ss							= "select * from ebay_config WHERE `ebay_user` ='$user' LIMIT 1";
		$ss							= $dbcon->execute($ss);
		$ss							= $dbcon->getResultArray($ss);
		$defaultstoreid				= $ss[0]['storeid'];
		$notesorderstatus			= $ss[0]['notesorderstatus'];
		$auditcompleteorderstatus	= $ss[0]['auditcompleteorderstatus'];
		$hackorerstatus				= $ss[0]['hackorer'];
		$_SESSION['user']			=  $user;
		
		
		$sql 		 = "select * from ebay_account where ebay_user='$user' and AWS_ACCESS_KEY_ID != '' ";
		$sql		 = $dbcon->execute($sql);
		$sql		 = $dbcon->getResultArray($sql);
		
		
		for($i=0;$i<count($sql);$i++){
		
			$account				= $sql[$i]['ebay_account'];			
			
			
			
			echo '开始同步帐号'.$account.'<br>';
			
			$AWS_ACCESS_KEY_ID		= $sql[$i]['AWS_ACCESS_KEY_ID'];
			$AWS_SECRET_ACCESS_KEY	= $sql[$i]['AWS_SECRET_ACCESS_KEY'];
			$MERCHANT_ID			= $sql[$i]['MERCHANT_ID'];
			$MARKETPLACE_ID			= $sql[$i]['MARKETPLACE_ID'];
			$serviceUrl				= $sql[$i]['serviceUrl'].'/Orders/2011-01-01';

			
			define('AWS_ACCESS_KEY_ID', $AWS_ACCESS_KEY_ID);
			define('AWS_SECRET_ACCESS_KEY', $AWS_SECRET_ACCESS_KEY);  
			define('MERCHANT_ID', $MERCHANT_ID);
			define('MARKETPLACE_ID', $MARKETPLACE_ID);
			
			
			$config = array (
		   'ServiceURL' => $serviceUrl,
		   'ProxyHost' => null,
		   'ProxyPort' => -1,
		   'MaxErrorRetry' => 3,
			);
			
			
			
			 $service = new MarketplaceWebServiceOrders_Client(
			$AWS_ACCESS_KEY_ID,
			$AWS_SECRET_ACCESS_KEY,
			APPLICATION_NAME,
			APPLICATION_VERSION,
			$config);
			
			echo 'TTTT'.AWS_ACCESS_KEY_ID;
			
			
	
			
			
			$request = new MarketplaceWebServiceOrders_Model_ListOrdersRequest();
			$request->setSellerId($MERCHANT_ID);
  
  
			
		
			$marketplaceIdList = new MarketplaceWebServiceOrders_Model_MarketplaceIdList();
			$marketplaceIdList->setId(array($MARKETPLACE_ID));
			$request->setMarketplaceId($marketplaceIdList);
			 
			 
			$orderStatuses = new MarketplaceWebServiceOrders_Model_OrderStatusList();
			$orderStatuses->setStatus(array('Unshipped','PartiallyShipped'));
			$request->setOrderStatus($orderStatuses);
			
			
			echo $astart.'<br>';
			echo $aend;
			echo $account;
			
			
			$request->setCreatedAfter(new DateTime($astart, new DateTimeZone('UTC')));
			$errorstatus	=  invokeListOrders($service, $request);
			
			
			sleep(30);
	
			
		}
		
	}

	
	
	










  





 



 
/************************************************************************
 * Uncomment to try out Mock Service that simulates MarketplaceWebServiceOrders
 * responses without calling MarketplaceWebServiceOrders service.
 *
 * Responses are loaded from local XML files. You can tweak XML files to
 * experiment with various outputs during development
 *
 * XML files available under MarketplaceWebServiceOrders/Mock tree
 *
 ***********************************************************************/
 // $service = new MarketplaceWebServiceOrders_Mock();

/************************************************************************
 * Setup request parameters and uncomment invoke to try out 
 * sample for List Orders Action
 ***********************************************************************/

 
 if($user == 'amdd99'){

 // List all orders udpated after a certain date
 $request->setCreatedAfter(new DateTime($start.' 00:00:00', new DateTimeZone('UTC')));
 //$request->setCreatedBefore(new DateTime($end.' 23:59:59', new DateTimeZone('UTC')));
 // Set the marketplaces queried in this ListOrdersRequest
 $marketplaceIdList = new MarketplaceWebServiceOrders_Model_MarketplaceIdList();
 $marketplaceIdList->setId(array(MARKETPLACE_ID));
 $request->setMarketplaceId($marketplaceIdList);
 invokeListOrders($service, $request);
 
 
	
	
 }else{
 	
	
	
	

	
	
	
	
	   


	
	




	
	
	
	
	}
	echo '已经同步完成';
	

 

 // Set the order statuses for this ListOrdersRequest (optional)
 // $orderStatuses = new MarketplaceWebServiceOrders_Model_OrderStatusList();
 // $orderStatuses->setStatus(array('Shipped'));
 // $request->setOrderStatus($orderStatuses);

 // Set the Fulfillment Channel for this ListOrdersRequest (optional)
 //$fulfillmentChannels = new MarketplaceWebServiceOrders_Model_FulfillmentChannelList();
 //$fulfillmentChannels->setChannel(array('MFN'));
 //$request->setFulfillmentChannel($fulfillmentChannels);

 // @TODO: set request. Action can be passed as MarketplaceWebServiceOrders_Model_ListOrdersRequest
 // object or array of parameters
 
 
 


                                        
/**
  * List Orders Action Sample
  * ListOrders can be used to find orders that meet the specified criteria.
  *   
  * @param MarketplaceWebServiceOrders_Interface $service instance of MarketplaceWebServiceOrders_Interface
  * @param mixed $request MarketplaceWebServiceOrders_Model_ListOrders or array of parameters
  */
  function invokeListOrders(MarketplaceWebServiceOrders_Interface $service, $request) 
  {
  
  	  global $user,$account,$dbcon,$MERCHANT_ID;
	  
      try {
              $response = $service->listOrders($request);
              
			  
			  

			  

	
//print_r($response);



			
			  
              //  echo ("Service Response\n");
             //   echo ("=============================================================================\n");

                if ($response->isSetListOrdersResult()) { 
                  //  echo("            ListOrdersResult\n");
                    $listOrdersResult = $response->getListOrdersResult();
                    if ($listOrdersResult->isSetNextToken()) 
                    {
                 //       echo("                NextToken\n");
					       echo("                    " . $listOrdersResult->getNextToken() . "\n");

							  $tokens =  $listOrdersResult->getNextToken();
						   	 
							 
							  $gg	= 0 ;

							
							  while(true){
									
									 sleep(25);
									 
									 $request = new MarketplaceWebServiceOrders_Model_ListOrdersByNextTokenRequest();
									 $request->setSellerId($MERCHANT_ID);
									 $request->setNextToken($tokens);
									 $nexttokens	= invokeListOrdersByNextToken($service, $request,$tokens);
									 if(strlen($nexttokens) >= 10 ){

											
											$nexttokens	= invokeListOrdersByNextToken($service, $request,$nexttokens);
											$tokens		= $nexttokens;


									}else{

											 break;


									}
									
									
									
									
									

									$gg++;
									if($gg>=200) break;



							  }

							  echo '<br>'.$nexttokens.'ggggggggggg';



				

                    }
                    if ($listOrdersResult->isSetCreatedBefore()) 
                    {
                 //       echo("                CreatedBefore\n");
                //        echo("                    " . $listOrdersResult->getCreatedBefore() . "\n");
                    }
                    if ($listOrdersResult->isSetLastUpdatedBefore()) 
                    {
                   //     echo("                LastUpdatedBefore\n");
                  //      echo("                    " . $listOrdersResult->getLastUpdatedBefore() . "\n");
                    }
                    if ($listOrdersResult->isSetOrders()) { 
                 //       echo("                Orders\n");
                        $orders = $listOrdersResult->getOrders();
                        $orderList = $orders->getOrder();
						
						
						
						print_r($orderList);
				
						
                        foreach ($orderList as $order) {
							
							
							
							$val= '';


                            if ($order->isSetSellerOrderId()) 
                            {
                       //         echo("                        SellerOrderId\n");
                       //         echo("                            " . $order->getSellerOrderId() . "\n");
                            }
                            if ($order->isSetPurchaseDate()) 
                            {
              
								
								$CreatedDate						=  strtotime($order->getPurchaseDate()) ;
                            }
                            if ($order->isSetLastUpdateDate()) 
                            {
								$paidtime						=  strtotime($order->getLastUpdateDate()) ;
                            }

							$orderstatus						= '';

                            if ($order->isSetOrderStatus()) 
                            {
                           
								if($order->getOrderStatus() == 'Unshipped'){
								$orderstatus				= 1;
								}
								
                            }
							


							 if($order->isSetAmazonOrderId() && $orderstatus == '1' ) 
                            {
                        
								 $val							= $order->getAmazonOrderId();
								 $request = new MarketplaceWebServiceOrders_Model_ListOrderItemsRequest();
								 $request->setSellerId($MERCHANT_ID);
								 $request->setAmazonOrderId($val);


								  if($val != ''){

										$error_status = invokeListOrderItems($service, $request,$val,$account); 
										if($error_status == '99')  invokeListOrderItems($service, $request,$val,$account);
										if($error_status == '99')  invokeListOrderItems($service, $request,$val,$account);
										if($error_status == '99')  invokeListOrderItems($service, $request,$val,$account);

									 
								 }


                            }


							
							
							
                            if ($order->isSetFulfillmentChannel()) 
                            {
                               // echo("                        FulfillmentChannel\n");
                               // echo("                            " . $order->getFulfillmentChannel() . "\n");
                            }
                            if ($order->isSetSalesChannel()) 
                            {
                              //  echo("                        SalesChannel\n");
                              //  echo("                            " . $order->getSalesChannel() . "\n");
                            }
                            if ($order->isSetOrderChannel()) 
                            {
                              //  echo("                        OrderChannel\n");
                              //  echo("                            " . $order->getOrderChannel() . "\n");
                            }
                            if ($order->isSetShipServiceLevel()) 
                            {
                              //  echo("                        ShipServiceLevel\n");
                              //  echo("                            " . $order->getShipServiceLevel() . "\n");
                            }
							
							
							$Street1	= '';
							$Street2	= '';
							$CityName   = '';
							$StateOrProvince = '';
							
							
                            if ($order->isSetShippingAddress()) { 
                                $shippingAddress = $order->getShippingAddress();
                                if ($shippingAddress->isSetName()) 
                                {
									
									$Name	= mysql_escape_string($shippingAddress->getName()) ;
                                }
                                if ($shippingAddress->isSetAddressLine1()) 
                                {
									$Street1	= mysql_escape_string($shippingAddress->getAddressLine1()) ;
									
									
                                }
                                if ($shippingAddress->isSetAddressLine2()) 
                                {
									$Street2	= mysql_escape_string($shippingAddress->getAddressLine2()) ;
									
                                }
                                if ($shippingAddress->isSetAddressLine3()) 
                                {
                                //    echo("                                " . $shippingAddress->getAddressLine3() . "\n");
                                }
								
								
								
                                if ($shippingAddress->isSetCity()) 
                                {
                                  
									$CityName			= mysql_escape_string($shippingAddress->getCity());
									
                                }
                                if ($shippingAddress->isSetCounty()) 
                                {
									
									$CountryName				=  $shippingAddress->getCounty() ;
									
                                }
                                if ($shippingAddress->isSetDistrict()) 
                                {
                                //    echo("                                " . $shippingAddress->getDistrict() . "\n");
                                }
                                if ($shippingAddress->isSetStateOrRegion()) 
                                {
                               
									
									$StateOrProvince						=  $shippingAddress->getStateOrRegion();
                                }
                                if ($shippingAddress->isSetPostalCode()) 
                                {
									$PostalCode		=  $shippingAddress->getPostalCode();
									
                                }
                                if ($shippingAddress->isSetCountryCode()) 
                                {
									$Country				=  $shippingAddress->getCountryCode() ;
									
                                }
                                if ($shippingAddress->isSetPhone()) 
                                {
							
									$Phone			= $shippingAddress->getPhone() ;
									
                                }
                            } 
                            if ($order->isSetOrderTotal()) { 
                             
                                $orderTotal = $order->getOrderTotal();
                                if ($orderTotal->isSetCurrencyCode()) 
                                {
                                 
                     
									$Currency					= $orderTotal->getCurrencyCode();
									
									
									
                                }
                                if ($orderTotal->isSetAmount()) 
                                {
                            
									$AmountPaid	= $orderTotal->getAmount() ;
									
                                }
                            } 
                            if ($order->isSetNumberOfItemsShipped()) 
                            {
                          
                               // echo("                            " . $order->getNumberOfItemsShipped() . "\n");
                            }
                            if ($order->isSetNumberOfItemsUnshipped()) 
                            {
                             
                              //  echo("                            " . $order->getNumberOfItemsUnshipped() . "\n");
                            }
                            if ($order->isSetPaymentExecutionDetail()) { 
                             
                                $paymentExecutionDetail = $order->getPaymentExecutionDetail();
                                $paymentExecutionDetailItemList = $paymentExecutionDetail->getPaymentExecutionDetailItem();
                                foreach ($paymentExecutionDetailItemList as $paymentExecutionDetailItem) {
                                   // echo("                            PaymentExecutionDetailItem\n");
                                    if ($paymentExecutionDetailItem->isSetPayment()) { 
                                      //  echo("                                Payment\n");
                                        $payment = $paymentExecutionDetailItem->getPayment();
                                        if ($payment->isSetCurrencyCode()) 
                                        {
                                           // echo("                                    CurrencyCode\n");
                                           // echo("                                        " . $payment->getCurrencyCode() . "\n");
                                        }
                                        if ($payment->isSetAmount()) 
                                        {
                                          //  echo("                                    Amount\n");
                                           // echo("                                        " . $payment->getAmount() . "\n");
                                        }
                                    } 
                                    if ($paymentExecutionDetailItem->isSetSubPaymentMethod()) 
                                    {
                                      //  echo("                                SubPaymentMethod\n");
                                      //  echo("                                    " . $paymentExecutionDetailItem->getSubPaymentMethod() . "\n");
                                    }
                                }
                            } 
                            if ($order->isSetPaymentMethod()) 
                            {
                                //echo("                        PaymentMethod\n");
                                //echo("                            " . $order->getPaymentMethod() . "\n");
                            }
                            if ($order->isSetMarketplaceId()) 
                            {
                                //echo("                        MarketplaceId\n");
                               // echo("                            " . $order->getMarketplaceId() . "\n");
                            }
                            if ($order->isSetBuyerEmail()) 
                            {
                             //   echo("                        BuyerEmail\n");
                            //    echo("                            " . $order->getBuyerEmail() . "\n");
								
								$Email				=  $order->getBuyerEmail() ;
								
                            }
                            if ($order->isSetBuyerName()) 
                            {
								
								$UserID	= mysql_escape_string($order->getBuyerName());
								
								
                            }
                            if ($order->isSetShipmentServiceLevelCategory()) 
                            {
								
								$ebay_carrier				= $order->getShipmentServiceLevelCategory();

                            }
							
							
							
							
					$sql			 = "INSERT INTO `ebay_order` (`ebay_paystatus`,`ebay_ordersn` ,`ebay_tid` ,`ebay_ptid` ,`ebay_orderid` ,";
					$sql			.= "`ebay_createdtime` ,`ebay_paidtime` ,`ebay_userid` ,`ebay_username` ,`ebay_usermail` ,`ebay_street` ,";
					$sql			.= "`ebay_street1` ,`ebay_city` ,`ebay_state` ,`ebay_couny` ,`ebay_countryname` ,`ebay_postcode` ,`ebay_phone`";
					$sql			.= " ,`ebay_currency` ,`ebay_total` ,`ebay_status`,`ebay_user`,`ebay_shipfee`,`ebay_account`,`recordnumber`,`ebay_addtime`,`ebay_note`,`ebay_site`,`eBayPaymentStatus`,`PayPalEmailAddress`,`ShippedTime`,`RefundAmount`,`ebay_warehouse`,`order_no`,`ebay_carrier`)VALUES ('Complete','$val', '$tid' , '$ptid' , '$orderid' , '$CreatedDate' , '$CreatedDate' , '$UserID' ,";
					$sql			.= " '$Name' , '$Email' , '$Street1' , '$Street2' , '$CityName','$StateOrProvince' , '$Country' , '$Country' , '$PostalCode' , '$Phone' , '$Currency' , '$AmountPaid' , '$orderstatus','$user','$shipingfee','$account','$addrecordnumber','$mctime','$BuyerCheckoutMessage','$site','$eBayPaymentStatus','$PayPalEmailAddress','$ShippedTime','$RefundAmount','$defaultstoreid','$order_no','$ebay_carrier')";
					$sg				= "select * from ebay_order where ebay_ordersn ='$val'";
					$sg				= $dbcon->execute($sg);
					$sg				= $dbcon->getResultArray($sg);
					
					
					if($val != ''){
					if(count($sg) == 0){
						
						
						if($dbcon->execute($sql)){
							
							
							echo '<br>Amazon ID: '.$val.' 添加成功';
							
						
						}else{
						
							echo '<br>Amazon ID: '.$val.' 添加失败';
							
							echo $sql;
							
						
						}
					
					
					}else{


					echo '<br>Amazon ID: '.$val.'  已经存在<br>';
					}
					}else{


$sg				= "select * from ebay_order where ebay_ordersn ='$val'";

					}
					
		
					

								
                        }
                    } 
                } 
                if ($response->isSetResponseMetadata()) { 
                  //  echo("            ResponseMetadata\n");
                    $responseMetadata = $response->getResponseMetadata();
                    if ($responseMetadata->isSetRequestId()) 
                    {
                     //   echo("                RequestId\n");
                     //   echo("                    " . $responseMetadata->getRequestId() . "\n");
                    }
                } 

     } catch (MarketplaceWebServiceOrders_Exception $ex) {
         echo("Caught Exception: " . $ex->getMessage() . "\n");
         echo("Response Status Code: " . $ex->getStatusCode() . "\n");
         echo("Error Code: " . $ex->getErrorCode() . "\n");
         echo("Error Type: " . $ex->getErrorType() . "\n");
         echo("Request ID: " . $ex->getRequestId() . "\n");
         echo("XML: " . $ex->getXML() . "\n");
		 
		 
		 return 88;
		 
     }
 }
 
 
 
  function invokeListOrderItems(MarketplaceWebServiceOrders_Interface $service, $request,$val,$account) 
  {		
  
  		global $dbcon;
		
      try {
              $response = $service->listOrderItems($request);
            // print_r($response);
			 
			  
 
                if ($response->isSetListOrderItemsResult()) { 
                  //  echo("            ListOrderItemsResult\n");
                    $listOrderItemsResult = $response->getListOrderItemsResult();
                    if ($listOrderItemsResult->isSetNextToken()) 
                    {
                     //   echo("                NextToken\n");
                     //   echo("                    " . $listOrderItemsResult->getNextToken() . "\n");
                    }
                    if ($listOrderItemsResult->isSetAmazonOrderId()) 
                    {
                     //   echo("                AmazonOrderId\n");
                     //   echo("                    " . $listOrderItemsResult->getAmazonOrderId() . "\n");
                    }
                    if ($listOrderItemsResult->isSetOrderItems()) { 
                      //  echo("                OrderItems\n");
                        $orderItems = $listOrderItemsResult->getOrderItems();
                        $orderItemList = $orderItems->getOrderItem();
                        foreach ($orderItemList as $orderItem) {
                    //        echo("                    OrderItem\n");
                            if ($orderItem->isSetASIN()) 
                            {
                   //             echo("                        ASIN\n");
                                echo("                            " . $orderItem->getASIN() . "\n");
								
								$ebay_itemid			= $orderItem->getASIN() ;
								
                            }
                            if ($orderItem->isSetSellerSKU()) 
                            {
                     //           echo("                        SellerSKU\n");
                       //         echo("                            " . $orderItem->getSellerSKU() . "\n");
								
								$sku			= $orderItem->getSellerSKU();
																	$sku	= substr($sku,0,12);

																	
								
                            }
                            if ($orderItem->isSetOrderItemId()) 
                            {
                        //        echo("                        OrderItemId\n");
                        //        echo("                            " . $orderItem->getOrderItemId() . "\n");
								$recordnumber						= $orderItem->getOrderItemId();
								
                            }
                            if ($orderItem->isSetTitle()) 
                            {
                          //      echo("                        Title\n");
                         //       echo("                            " . $orderItem->getTitle() . "\n");
								
								$title			=mysql_escape_string( $orderItem->getTitle());
								
                            }
                            if ($orderItem->isSetQuantityOrdered()) 
                            {
                         //       echo("                        QuantityOrdered\n");
                       //        echo("                            " . $orderItem->getQuantityOrdered() . "\n");
								
								$amount			= $orderItem->getQuantityOrdered();
								
                            }
                            if ($orderItem->isSetQuantityShipped()) 
                            {
                      //          echo("                        QuantityShipped\n");
                     //           echo("                            " . $orderItem->getQuantityShipped() . "\n");
                            }
                            if ($orderItem->isSetItemPrice()) { 
                       //         echo("                        ItemPrice\n");
                                $itemPrice = $orderItem->getItemPrice();
                                if ($itemPrice->isSetCurrencyCode()) 
                                {
                      //              echo("                            CurrencyCode\n");
                      //              echo("                                " . $itemPrice->getCurrencyCode() . "\n");
                                }
                                if ($itemPrice->isSetAmount()) 
                                {
                          //          echo("                            Amount\n");
                          //          echo("                                " . $itemPrice->getAmount() . "\n");
									
									
									$ebayitemprice			= $itemPrice->getAmount();
									
                                }
                            } 
                            if ($orderItem->isSetShippingPrice()) { 
                            //    echo("                        ShippingPrice\n");
                                $shippingPrice = $orderItem->getShippingPrice();
                                if ($shippingPrice->isSetCurrencyCode()) 
                                {
                          //          echo("                            CurrencyCode\n");
                           //         echo("                                " . $shippingPrice->getCurrencyCode() . "\n");
                                }
                                if ($shippingPrice->isSetAmount()) 
                                {
                           //         echo("                            Amount\n");
                           //         echo("                                " . $shippingPrice->getAmount() . "\n");
							//		
									$shipingfee	= $shippingPrice->getAmount();
									
                                }
                            } 
                            if ($orderItem->isSetGiftWrapPrice()) { 
                          //      echo("                        GiftWrapPrice\n");
                                $giftWrapPrice = $orderItem->getGiftWrapPrice();
                                if ($giftWrapPrice->isSetCurrencyCode()) 
                                {
                                 //   echo("                            CurrencyCode\n");
                                //    echo("                                " . $giftWrapPrice->getCurrencyCode() . "\n");
                                }
                                if ($giftWrapPrice->isSetAmount()) 
                                {
                                 //   echo("                            Amount\n");
                                 //   echo("                                " . $giftWrapPrice->getAmount() . "\n");
									
									
								
                                }
                            } 
                            if ($orderItem->isSetItemTax()) { 
                               // echo("                        ItemTax\n");
                                $itemTax = $orderItem->getItemTax();
                                if ($itemTax->isSetCurrencyCode()) 
                                {
                              //      echo("                            CurrencyCode\n");
                             //      echo("                                " . $itemTax->getCurrencyCode() . "\n");
                                }
                                if ($itemTax->isSetAmount()) 
                                {
                             //       echo("                            Amount\n");
                            //        echo("                                " . $itemTax->getAmount() . "\n");
                                }
                            } 
                            if ($orderItem->isSetShippingTax()) { 
                              // echo("                        ShippingTax\n");
                                $shippingTax = $orderItem->getShippingTax();
                                if ($shippingTax->isSetCurrencyCode()) 
                                {
                              //      echo("                            CurrencyCode\n");
                              //      echo("                                " . $shippingTax->getCurrencyCode() . "\n");
                                }
                                if ($shippingTax->isSetAmount()) 
                                {
                                    //echo("                            Amount\n");
                                 //   echo("                                " . $shippingTax->getAmount() . "\n");
                                }
                            } 
                            if ($orderItem->isSetGiftWrapTax()) { 
                             //   echo("                        GiftWrapTax\n");
                                $giftWrapTax = $orderItem->getGiftWrapTax();
                                if ($giftWrapTax->isSetCurrencyCode()) 
                                {
                               //     echo("                            CurrencyCode\n");
                               //     echo("                                " . $giftWrapTax->getCurrencyCode() . "\n");
                                }
                                if ($giftWrapTax->isSetAmount()) 
                                {
                               //     echo("                            Amount\n");
                               //     echo("                                " . $giftWrapTax->getAmount() . "\n");
                                }
                            } 
                            if ($orderItem->isSetShippingDiscount()) { 
                              //  echo("                        ShippingDiscount\n");
                                $shippingDiscount = $orderItem->getShippingDiscount();
                                if ($shippingDiscount->isSetCurrencyCode()) 
                                {
                               //     echo("                            CurrencyCode\n");
                                    //echo("                                " . $shippingDiscount->getCurrencyCode() . "\n");
                                }
                                if ($shippingDiscount->isSetAmount()) 
                                {
                               //     echo("                            Amount\n");
                               //     echo("                                " . $shippingDiscount->getAmount() . "\n");
                                }
                            } 
                            if ($orderItem->isSetPromotionDiscount()) { 
                               // echo("                        PromotionDiscount\n");
                                $promotionDiscount = $orderItem->getPromotionDiscount();
                                if ($promotionDiscount->isSetCurrencyCode()) 
                                {
                                    //echo("                            CurrencyCode\n");
                                  //  echo("                                " . $promotionDiscount->getCurrencyCode() . "\n");
                                }
                                if ($promotionDiscount->isSetAmount()) 
                                {
                                    //echo("                            Amount\n");
                                   // echo("                                " . $promotionDiscount->getAmount() . "\n");
                                }
                            } 
                            if ($orderItem->isSetPromotionIds()) { 
                               // echo("                        PromotionIds\n");
                                $promotionIds = $orderItem->getPromotionIds();
                                $promotionIdList  =  $promotionIds->getPromotionId();
                                foreach ($promotionIdList as $promotionId) { 
                                 //   echo("                            PromotionId\n");
                                //    echo("                                " . $promotionId);
                                }    
                            } 
                            if ($orderItem->isSetCODFee()) { 
                                echo("                        CODFee\n");
                                $CODFee = $orderItem->getCODFee();
                                if ($CODFee->isSetCurrencyCode()) 
                                {
                                  //  echo("                            CurrencyCode\n");
                                  //  echo("                                " . $CODFee->getCurrencyCode() . "\n");
                                }
                                if ($CODFee->isSetAmount()) 
                                {
                                 //   echo("                            Amount\n");
                                 //   echo("                                " . $CODFee->getAmount() . "\n");
                                }
                            } 
                            if ($orderItem->isSetCODFeeDiscount()) { 
                               // echo("                        CODFeeDiscount\n");
                                $CODFeeDiscount = $orderItem->getCODFeeDiscount();
                                if ($CODFeeDiscount->isSetCurrencyCode()) 
                                {
                                 //   echo("                            CurrencyCode\n");
                                 //   echo("                                " . $CODFeeDiscount->getCurrencyCode() . "\n");
                                }
                                if ($CODFeeDiscount->isSetAmount()) 
                                {
                                 //   echo("                            Amount\n");
                                  //  echo("                                " . $CODFeeDiscount->getAmount() . "\n");
                                }
                            } 
                            if ($orderItem->isSetGiftMessageText()) 
                            {
                                //echo("                        GiftMessageText\n");
                                //echo("                            " . $orderItem->getGiftMessageText() . "\n");
                            }
                            if ($orderItem->isSetGiftWrapLevel()) 
                            {

							
                               // echo("                        GiftWrapLevel\n");
                               // echo("                            " . $orderItem->getGiftWrapLevel() . "\n");
                            }
							
							
							
							$esql	 = "INSERT INTO `ebay_orderdetail` (`ebay_ordersn` ,`ebay_itemid` ,`ebay_itemtitle` ,`ebay_itemprice` ,";
				$esql    .= "`ebay_amount` ,`ebay_createdtime` ,`ebay_shiptype` ,`ebay_user`,`sku`,`shipingfee`,`ebay_account`,`addtime`,`ebay_itemurl`,`ebay_site`,`recordnumber`,`storeid`,`ListingType`,`ebay_tid`,`FeeOrCreditAmount`,`FinalValueFee`,`attribute`,`notes`,`goods_location`)VALUES ('$val', '$ebay_itemid' , '$title' , '$ebayitemprice' , '$amount'";
				$esql	.= " , '$ctime' , '$shiptype' , '$user','$sku','$shipingfee','$account','$mctime','$pic','$site','$recordnumber','$storeid','$ListingType','$tid','$FeeOrCreditAmount','$FinalValueFee','$arrribute','$BuyerCheckoutMessage','$goods_location')";	
				
		
				
							
							$sg			= "select * from ebay_orderdetail where ebay_ordersn ='$val' and recordnumber ='$recordnumber' ";
							$sg			= $dbcon->execute($sg);
							$sg			= $dbcon->getResultArray($sg);
							
							if(count($sg) == 0){
						
								if($dbcon->execute($esql)){
									
									echo '<br>Amazon ID Products: '.$val.' 添加成功';
								}else{
									echo '<br>Amazon ID Products : '.$val.' 添加失败';


									echo $esql;

								}
							}
					
				
				
				
                        }
                    } 
                } 
                if ($response->isSetResponseMetadata()) { 
                  //  echo("            ResponseMetadata\n");
                    $responseMetadata = $response->getResponseMetadata();
                    if ($responseMetadata->isSetRequestId()) 
                    {
                     //   echo("                RequestId\n");
                     //   echo("                    " . $responseMetadata->getRequestId() . "\n");
                    }
                } 

     } catch (MarketplaceWebServiceOrders_Exception $ex) {
         echo("Caught Exception: " . $ex->getMessage() . "\n");
         echo("Response Status Code: " . $ex->getStatusCode() . "\n");
         echo("Error Code: " . $ex->getErrorCode() . "\n");
         echo("Error Type: " . $ex->getErrorType() . "\n");
         echo("Request ID: " . $ex->getRequestId() . "\n");
         echo("XML: " . $ex->getXML() . "\n");

		 return 99;

     }
 }
            
 function invokeListOrdersByNextToken(MarketplaceWebServiceOrders_Interface $service, $request,$tokens) 
  {	
	  global $user,$account,$dbcon,$MERCHANT_ID;

      try {


		



              $response = $service->listOrdersByNextToken($request);
echo '我执行了,,,';




           

                echo ("Service Response\n");
                echo ("=============================================================================\n");

                echo("        ListOrdersByNextTokenResponse\n");
                if ($response->isSetListOrdersByNextTokenResult()) { 
                    echo("            ListOrdersByNextTokenResult\n");
                    $listOrdersByNextTokenResult = $response->getListOrdersByNextTokenResult();


                   
                    if ($listOrdersByNextTokenResult->isSetCreatedBefore()) 
                    {
                        echo("                CreatedBefore\n");
                        echo("                    " . $listOrdersByNextTokenResult->getCreatedBefore() . "\n");
                    }
                    if ($listOrdersByNextTokenResult->isSetLastUpdatedBefore()) 
                    {
                        echo("                LastUpdatedBefore\n");
                        echo("                    " . $listOrdersByNextTokenResult->getLastUpdatedBefore() . "\n");
                    }
                    if ($listOrdersByNextTokenResult->isSetOrders()) { 
                        echo("                Orders\n");
                        $orders = $listOrdersByNextTokenResult->getOrders();
                        $orderList = $orders->getOrder();
                         foreach ($orderList as $order) {
							
							
							
							$val= '';


                            if ($order->isSetSellerOrderId()) 
                            {
                       //         echo("                        SellerOrderId\n");
                       //         echo("                            " . $order->getSellerOrderId() . "\n");
                            }
                            if ($order->isSetPurchaseDate()) 
                            {
              
								
								$CreatedDate						=  strtotime($order->getPurchaseDate()) ;
                            }
                            if ($order->isSetLastUpdateDate()) 
                            {
								$paidtime						=  strtotime($order->getLastUpdateDate()) ;
                            }

							$orderstatus						= '';

                            if ($order->isSetOrderStatus()) 
                            {
                           
								if($order->getOrderStatus() == 'Unshipped'){
								$orderstatus				= 1;
								}
								
                            }
							


							 if($order->isSetAmazonOrderId() && $orderstatus == '1' ) 
                            {
                        
								 $val							= $order->getAmazonOrderId();
								 $request = new MarketplaceWebServiceOrders_Model_ListOrderItemsRequest();
								 $request->setSellerId($MERCHANT_ID);
								 $request->setAmazonOrderId($val);
								 if($val != ''){

										$error_status = invokeListOrderItems($service, $request,$val,$account); 
										if($error_status == '99')  invokeListOrderItems($service, $request,$val,$account);
										if($error_status == '99')  invokeListOrderItems($service, $request,$val,$account);
										if($error_status == '99')  invokeListOrderItems($service, $request,$val,$account);

									 
								 }
                            }


							
							
							
                            if ($order->isSetFulfillmentChannel()) 
                            {
                               // echo("                        FulfillmentChannel\n");
                               // echo("                            " . $order->getFulfillmentChannel() . "\n");
                            }
                            if ($order->isSetSalesChannel()) 
                            {
                              //  echo("                        SalesChannel\n");
                              //  echo("                            " . $order->getSalesChannel() . "\n");
                            }
                            if ($order->isSetOrderChannel()) 
                            {
                              //  echo("                        OrderChannel\n");
                              //  echo("                            " . $order->getOrderChannel() . "\n");
                            }
                            if ($order->isSetShipServiceLevel()) 
                            {
                              //  echo("                        ShipServiceLevel\n");
                              //  echo("                            " . $order->getShipServiceLevel() . "\n");
                            }
							
							
							$Street1	= '';
							$Street2	= '';
							$CityName   = '';
							$StateOrProvince = '';
							
							
                            if ($order->isSetShippingAddress()) { 
                                $shippingAddress = $order->getShippingAddress();
                                if ($shippingAddress->isSetName()) 
                                {
									
									$Name	= mysql_escape_string($shippingAddress->getName()) ;
                                }
                                if ($shippingAddress->isSetAddressLine1()) 
                                {
									$Street1	= mysql_escape_string($shippingAddress->getAddressLine1()) ;
									
									
                                }
                                if ($shippingAddress->isSetAddressLine2()) 
                                {
									$Street2	= mysql_escape_string($shippingAddress->getAddressLine2()) ;
									
                                }
                                if ($shippingAddress->isSetAddressLine3()) 
                                {
                                //    echo("                                " . $shippingAddress->getAddressLine3() . "\n");
                                }
								
								
								
                                if ($shippingAddress->isSetCity()) 
                                {
                                  
									$CityName			= mysql_escape_string($shippingAddress->getCity());
									
                                }
                                if ($shippingAddress->isSetCounty()) 
                                {
									
									$CountryName				=  $shippingAddress->getCounty() ;
									
                                }
                                if ($shippingAddress->isSetDistrict()) 
                                {
                                //    echo("                                " . $shippingAddress->getDistrict() . "\n");
                                }
                                if ($shippingAddress->isSetStateOrRegion()) 
                                {
                               
									
									$StateOrProvince						=  $shippingAddress->getStateOrRegion();
                                }
                                if ($shippingAddress->isSetPostalCode()) 
                                {
									$PostalCode		=  $shippingAddress->getPostalCode();
									
                                }
                                if ($shippingAddress->isSetCountryCode()) 
                                {
									$Country				=  $shippingAddress->getCountryCode() ;
									
                                }
                                if ($shippingAddress->isSetPhone()) 
                                {
							
									$Phone			= $shippingAddress->getPhone() ;
									
                                }
                            } 
                            if ($order->isSetOrderTotal()) { 
                             
                                $orderTotal = $order->getOrderTotal();
                                if ($orderTotal->isSetCurrencyCode()) 
                                {
                                 
                     
									$Currency					= $orderTotal->getCurrencyCode();
									
									
									
                                }
                                if ($orderTotal->isSetAmount()) 
                                {
                            
									$AmountPaid	= $orderTotal->getAmount() ;
									
                                }
                            } 
                            if ($order->isSetNumberOfItemsShipped()) 
                            {
                          
                               // echo("                            " . $order->getNumberOfItemsShipped() . "\n");
                            }
                            if ($order->isSetNumberOfItemsUnshipped()) 
                            {
                             
                              //  echo("                            " . $order->getNumberOfItemsUnshipped() . "\n");
                            }
                            if ($order->isSetPaymentExecutionDetail()) { 
                             
                                $paymentExecutionDetail = $order->getPaymentExecutionDetail();
                                $paymentExecutionDetailItemList = $paymentExecutionDetail->getPaymentExecutionDetailItem();
                                foreach ($paymentExecutionDetailItemList as $paymentExecutionDetailItem) {
                                   // echo("                            PaymentExecutionDetailItem\n");
                                    if ($paymentExecutionDetailItem->isSetPayment()) { 
                                      //  echo("                                Payment\n");
                                        $payment = $paymentExecutionDetailItem->getPayment();
                                        if ($payment->isSetCurrencyCode()) 
                                        {
                                           // echo("                                    CurrencyCode\n");
                                           // echo("                                        " . $payment->getCurrencyCode() . "\n");
                                        }
                                        if ($payment->isSetAmount()) 
                                        {
                                          //  echo("                                    Amount\n");
                                           // echo("                                        " . $payment->getAmount() . "\n");
                                        }
                                    } 
                                    if ($paymentExecutionDetailItem->isSetSubPaymentMethod()) 
                                    {
                                      //  echo("                                SubPaymentMethod\n");
                                      //  echo("                                    " . $paymentExecutionDetailItem->getSubPaymentMethod() . "\n");
                                    }
                                }
                            } 
                            if ($order->isSetPaymentMethod()) 
                            {
                                //echo("                        PaymentMethod\n");
                                //echo("                            " . $order->getPaymentMethod() . "\n");
                            }
                            if ($order->isSetMarketplaceId()) 
                            {
                                //echo("                        MarketplaceId\n");
                               // echo("                            " . $order->getMarketplaceId() . "\n");
                            }
                            if ($order->isSetBuyerEmail()) 
                            {
                             //   echo("                        BuyerEmail\n");
                            //    echo("                            " . $order->getBuyerEmail() . "\n");
								
								$Email				=  $order->getBuyerEmail() ;
								
                            }
                            if ($order->isSetBuyerName()) 
                            {
								
								$UserID	= mysql_escape_string($order->getBuyerName());
								
								
                            }
                            if ($order->isSetShipmentServiceLevelCategory()) 
                            {
								
								$ebay_carrier			= $order->getShipmentServiceLevelCategory();

                            }
							
							
							
							
							
					$sql			 = "INSERT INTO `ebay_order` (`ebay_paystatus`,`ebay_ordersn` ,`ebay_tid` ,`ebay_ptid` ,`ebay_orderid` ,";
					$sql			.= "`ebay_createdtime` ,`ebay_paidtime` ,`ebay_userid` ,`ebay_username` ,`ebay_usermail` ,`ebay_street` ,";
					$sql			.= "`ebay_street1` ,`ebay_city` ,`ebay_state` ,`ebay_couny` ,`ebay_countryname` ,`ebay_postcode` ,`ebay_phone`";
					$sql			.= " ,`ebay_currency` ,`ebay_total` ,`ebay_status`,`ebay_user`,`ebay_shipfee`,`ebay_account`,`recordnumber`,`ebay_addtime`,`ebay_note`,`ebay_site`,`eBayPaymentStatus`,`PayPalEmailAddress`,`ShippedTime`,`RefundAmount`,`ebay_warehouse`,`order_no`,`ebay_carrier`)VALUES ('Complete','$val', '$tid' , '$ptid' , '$orderid' , '$CreatedDate' , '$CreatedDate' , '$UserID' ,";
					$sql			.= " '$Name' , '$Email' , '$Street1' , '$Street2' , '$CityName','$StateOrProvince' , '$Country' , '$Country' , '$PostalCode' , '$Phone' , '$Currency' , '$AmountPaid' , '$orderstatus','$user','$shipingfee','$account','$addrecordnumber','$mctime','$BuyerCheckoutMessage','$site','$eBayPaymentStatus','$PayPalEmailAddress','$ShippedTime','$RefundAmount','$defaultstoreid','$order_no','$ebay_carrier')";
					$sg				= "select * from ebay_order where ebay_ordersn ='$val'";
					$sg				= $dbcon->execute($sg);
					$sg				= $dbcon->getResultArray($sg);
					
					
					if($val != ''){
					if(count($sg) == 0){
						
						
						if($dbcon->execute($sql)){
							
							
							echo '<br>Amazon ID: '.$val.' 添加成功';
							
						
						}else{
						
							echo '<br>Amazon ID: '.$val.' 添加失败';
							
							echo $sql;
							
						
						}
					
					
					}else{


					echo '<br>Amazon ID: '.$val.'  已经存在<br>';
					}
					}else{


$sg				= "select * from ebay_order where ebay_ordersn ='$val'";
echo $sg;

					}
					
		
					

								
                        }
                    }
					


					 if ($listOrdersByNextTokenResult->isSetNextToken()) 
                    {
                        echo("                NextToken\n");
                        echo("                    " . $listOrdersByNextTokenResult->getNextToken() . "\n");

						$tokens			= $listOrdersByNextTokenResult->getNextToken() ;
						return $tokens;

                    }else{

						
						return 0;


					}

                } 
                if ($response->isSetResponseMetadata()) { 
                    echo("            ResponseMetadata\n");
                    $responseMetadata = $response->getResponseMetadata();
                    if ($responseMetadata->isSetRequestId()) 
                    {
                        echo("                RequestId\n");
                        echo("                    " . $responseMetadata->getRequestId() . "\n");
                    }
                } 

     } catch (MarketplaceWebServiceOrders_Exception $ex) {
         echo("Caught Exception: " . $ex->getMessage() . "\n");
         echo("Response Status Code: " . $ex->getStatusCode() . "\n");
         echo("Error Code: " . $ex->getErrorCode() . "\n");
         echo("Error Type: " . $ex->getErrorType() . "\n");
         echo("Request ID: " . $ex->getRequestId() . "\n");
         echo("XML: " . $ex->getXML() . "\n");
     }
 }

