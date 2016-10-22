<?php
include "include/config.php";
include "top2.php";


	
	if($_POST['submit']){
	
		include_once ('MarketplaceWebServiceOrders/Exception.php'); 
		include_once ('MarketplaceWebServiceOrders/Client.php'); 
		include_once ('MarketplaceWebServiceOrders/Interface.php'); 
			include_once ('MarketplaceWebServiceOrders/Model/ListOrdersRequest.php'); 
		include_once ('MarketplaceWebServiceOrders/Model/MarketplaceIdList.php'); 
		$account		= $_POST['account'];

		define('AWS_ACCESS_KEY_ID', 'AKIAINKJBTBF7YBRWUEA');
 	   	define('AWS_SECRET_ACCESS_KEY', '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');
		
		define ('MERCHANT_ID', 'ADZOW023KZ0J5');
    	define ('MARKETPLACE_ID', 'A1F83G8C2ARO7P');
		
		$serviceUrl = "https://mws.amazonservices.de/Orders/2011-01-01";
		$config = array (
		   'ServiceURL' => $serviceUrl,
		   'ProxyHost' => null,
		   'ProxyPort' => -1,
		   'MaxErrorRetry' => 3,
		 );
		 
	
		 $service = new MarketplaceWebServiceOrders_Client(
        AWS_ACCESS_KEY_ID,
        AWS_SECRET_ACCESS_KEY,
        APPLICATION_NAME,
        APPLICATION_VERSION,
        $config);

		
		
		 $request = new MarketplaceWebServiceOrders_Model_ListOrdersRequest();
 $request->setSellerId(MERCHANT_ID);

 // List all orders udpated after a certain date
 $request->setCreatedAfter(new DateTime('2011-01-01 12:00:00', new DateTimeZone('UTC')));

 // Set the marketplaces queried in this ListOrdersRequest
 $marketplaceIdList = new MarketplaceWebServiceOrders_Model_MarketplaceIdList();
 $marketplaceIdList->setId(array(MARKETPLACE_ID));
 $request->setMarketplaceId($marketplaceIdList);
 	
	invokeListOrders($service, $request);

                                        
/**
  * List Orders Action Sample
  * ListOrders can be used to find orders that meet the specified criteria.
  *   
  * @param MarketplaceWebServiceOrders_Interface $service instance of MarketplaceWebServiceOrders_Interface
  * @param mixed $request MarketplaceWebServiceOrders_Model_ListOrders or array of parameters
  */
  function invokeListOrders(MarketplaceWebServiceOrders_Interface $service, $request) 
  {
  
  
  echo 'ddddd';
  
      try {
              $response = $service->listOrders($request);
              
                echo ("Service Response\n");
                echo ("=============================================================================\n");

                echo("        ListOrdersResponse\n");
                if ($response->isSetListOrdersResult()) { 
                    echo("            ListOrdersResult\n");
                    $listOrdersResult = $response->getListOrdersResult();
                    if ($listOrdersResult->isSetNextToken()) 
                    {
                        echo("                NextToken\n");
                        echo("                    " . $listOrdersResult->getNextToken() . "\n");
                    }
                    if ($listOrdersResult->isSetCreatedBefore()) 
                    {
                        echo("                CreatedBefore\n");
                        echo("                    " . $listOrdersResult->getCreatedBefore() . "\n");
                    }
                    if ($listOrdersResult->isSetLastUpdatedBefore()) 
                    {
                        echo("                LastUpdatedBefore\n");
                        echo("                    " . $listOrdersResult->getLastUpdatedBefore() . "\n");
                    }
                    if ($listOrdersResult->isSetOrders()) { 
                        echo("                Orders\n");
                        $orders = $listOrdersResult->getOrders();
                        $orderList = $orders->getOrder();
                        foreach ($orderList as $order) {
                            echo("                    Order\n");
                            if ($order->isSetAmazonOrderId()) 
                            {
                                echo("                        AmazonOrderId\n");
                                echo("                            " . $order->getAmazonOrderId() . "\n");
                            }
                            if ($order->isSetSellerOrderId()) 
                            {
                                echo("                        SellerOrderId\n");
                                echo("                            " . $order->getSellerOrderId() . "\n");
                            }
                            if ($order->isSetPurchaseDate()) 
                            {
                                echo("                        PurchaseDate\n");
                                echo("                            " . $order->getPurchaseDate() . "\n");
                            }
                            if ($order->isSetLastUpdateDate()) 
                            {
                                echo("                        LastUpdateDate\n");
                                echo("                            " . $order->getLastUpdateDate() . "\n");
                            }
                            if ($order->isSetOrderStatus()) 
                            {
                                echo("                        OrderStatus\n");
                                echo("                            " . $order->getOrderStatus() . "\n");
                            }
                            if ($order->isSetFulfillmentChannel()) 
                            {
                                echo("                        FulfillmentChannel\n");
                                echo("                            " . $order->getFulfillmentChannel() . "\n");
                            }
                            if ($order->isSetSalesChannel()) 
                            {
                                echo("                        SalesChannel\n");
                                echo("                            " . $order->getSalesChannel() . "\n");
                            }
                            if ($order->isSetOrderChannel()) 
                            {
                                echo("                        OrderChannel\n");
                                echo("                            " . $order->getOrderChannel() . "\n");
                            }
                            if ($order->isSetShipServiceLevel()) 
                            {
                                echo("                        ShipServiceLevel\n");
                                echo("                            " . $order->getShipServiceLevel() . "\n");
                            }
                            if ($order->isSetShippingAddress()) { 
                                echo("                        ShippingAddress\n");
                                $shippingAddress = $order->getShippingAddress();
                                if ($shippingAddress->isSetName()) 
                                {
                                    echo("                            Name\n");
                                    echo("                                " . $shippingAddress->getName() . "\n");
                                }
                                if ($shippingAddress->isSetAddressLine1()) 
                                {
                                    echo("                            AddressLine1\n");
                                    echo("                                " . $shippingAddress->getAddressLine1() . "\n");
                                }
                                if ($shippingAddress->isSetAddressLine2()) 
                                {
                                    echo("                            AddressLine2\n");
                                    echo("                                " . $shippingAddress->getAddressLine2() . "\n");
                                }
                                if ($shippingAddress->isSetAddressLine3()) 
                                {
                                    echo("                            AddressLine3\n");
                                    echo("                                " . $shippingAddress->getAddressLine3() . "\n");
                                }
                                if ($shippingAddress->isSetCity()) 
                                {
                                    echo("                            City\n");
                                    echo("                                " . $shippingAddress->getCity() . "\n");
                                }
                                if ($shippingAddress->isSetCounty()) 
                                {
                                    echo("                            County\n");
                                    echo("                                " . $shippingAddress->getCounty() . "\n");
                                }
                                if ($shippingAddress->isSetDistrict()) 
                                {
                                    echo("                            District\n");
                                    echo("                                " . $shippingAddress->getDistrict() . "\n");
                                }
                                if ($shippingAddress->isSetStateOrRegion()) 
                                {
                                    echo("                            StateOrRegion\n");
                                    echo("                                " . $shippingAddress->getStateOrRegion() . "\n");
                                }
                                if ($shippingAddress->isSetPostalCode()) 
                                {
                                    echo("                            PostalCode\n");
                                    echo("                                " . $shippingAddress->getPostalCode() . "\n");
                                }
                                if ($shippingAddress->isSetCountryCode()) 
                                {
                                    echo("                            CountryCode\n");
                                    echo("                                " . $shippingAddress->getCountryCode() . "\n");
                                }
                                if ($shippingAddress->isSetPhone()) 
                                {
                                    echo("                            Phone\n");
                                    echo("                                " . $shippingAddress->getPhone() . "\n");
                                }
                            } 
                            if ($order->isSetOrderTotal()) { 
                                echo("                        OrderTotal\n");
                                $orderTotal = $order->getOrderTotal();
                                if ($orderTotal->isSetCurrencyCode()) 
                                {
                                    echo("                            CurrencyCode\n");
                                    echo("                                " . $orderTotal->getCurrencyCode() . "\n");
                                }
                                if ($orderTotal->isSetAmount()) 
                                {
                                    echo("                            Amount\n");
                                    echo("                                " . $orderTotal->getAmount() . "\n");
                                }
                            } 
                            if ($order->isSetNumberOfItemsShipped()) 
                            {
                                echo("                        NumberOfItemsShipped\n");
                                echo("                            " . $order->getNumberOfItemsShipped() . "\n");
                            }
                            if ($order->isSetNumberOfItemsUnshipped()) 
                            {
                                echo("                        NumberOfItemsUnshipped\n");
                                echo("                            " . $order->getNumberOfItemsUnshipped() . "\n");
                            }
                            if ($order->isSetPaymentExecutionDetail()) { 
                                echo("                        PaymentExecutionDetail\n");
                                $paymentExecutionDetail = $order->getPaymentExecutionDetail();
                                $paymentExecutionDetailItemList = $paymentExecutionDetail->getPaymentExecutionDetailItem();
                                foreach ($paymentExecutionDetailItemList as $paymentExecutionDetailItem) {
                                    echo("                            PaymentExecutionDetailItem\n");
                                    if ($paymentExecutionDetailItem->isSetPayment()) { 
                                        echo("                                Payment\n");
                                        $payment = $paymentExecutionDetailItem->getPayment();
                                        if ($payment->isSetCurrencyCode()) 
                                        {
                                            echo("                                    CurrencyCode\n");
                                            echo("                                        " . $payment->getCurrencyCode() . "\n");
                                        }
                                        if ($payment->isSetAmount()) 
                                        {
                                            echo("                                    Amount\n");
                                            echo("                                        " . $payment->getAmount() . "\n");
                                        }
                                    } 
                                    if ($paymentExecutionDetailItem->isSetSubPaymentMethod()) 
                                    {
                                        echo("                                SubPaymentMethod\n");
                                        echo("                                    " . $paymentExecutionDetailItem->getSubPaymentMethod() . "\n");
                                    }
                                }
                            } 
                            if ($order->isSetPaymentMethod()) 
                            {
                                echo("                        PaymentMethod\n");
                                echo("                            " . $order->getPaymentMethod() . "\n");
                            }
                            if ($order->isSetMarketplaceId()) 
                            {
                                echo("                        MarketplaceId\n");
                                echo("                            " . $order->getMarketplaceId() . "\n");
                            }
                            if ($order->isSetBuyerEmail()) 
                            {
                                echo("                        BuyerEmail\n");
                                echo("                            " . $order->getBuyerEmail() . "\n");
                            }
                            if ($order->isSetBuyerName()) 
                            {
                                echo("                        BuyerName\n");
                                echo("                            " . $order->getBuyerName() . "\n");
                            }
                            if ($order->isSetShipmentServiceLevelCategory()) 
                            {
                                echo("                        ShipmentServiceLevelCategory\n");
                                echo("                            " . $order->getShipmentServiceLevelCategory() . "\n");
                            }
                        }
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

 
    <form method="post" action="MarketplaceWebServiceOrders/Samples/ListOrdersSample.php" target="_blank">   

<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>

	<tr class='pagination'>

		<td width="65%">

			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>

				<tr>

					<td nowrap="nowrap" class='paginationActionButtons'><table width="100%" height="99" border="0" cellpadding="0" cellspacing="0">

                

			
			      <tr>

                    <td width="41%" height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right"> Amazon帐号 </div></td>

                    <td width="3%" align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>

                    <td width="56%" height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">

                    <select name="account" id="account">

                    <?php 

					

					$sql	 = "select * from ebay_account as a where a.ebay_user='$user' and AWS_ACCESS_KEY_ID != '' order by ebay_account desc ";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 	$account	= $sql[$i]['ebay_account'];
					 ?>

                      <option value="<?php echo $account;?>"><?php echo $account;?></option>

                    <?php } ?>
                    </select></div></td>
                    </tr>

			      <tr>

			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">开始时间</td>

			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>

			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">

			          <input name="start" id="start" type="text" onClick="WdatePicker()"  value="<?php echo $start;?>" />

			          </div></td>
			        </tr>

			      <tr>

			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">结束时间</td>

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
			
                    <td height="30" align="right" class="left_txt"><div align="right"></div></td>

                    <td align="right" class="left_txt">&nbsp;</td>

                    <td height="30" align="right" class="left_txt"><div align="left"><input name="submit" type="submit" onClick="check()" value="同步">
                        <input name="submit2" type="button" onclick="checkv2()" value="amV2.0同步" />
                    -&gt;内部测试中，速度更快，更稳定</div></td>

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


	 </form> 



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

		location.href='orderloadstatus.php?account='+account+"&module=orders&action=Loading Orders Results&start="+start+"&end="+end;

		

		

	}

	function checkall(){
		
	
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
		
		var url	= 'orderloadstatus.php?start='+start+"&end="+end+"&type=loadall&module=orders&action=Message同步";
		location.href = url;
		
		
	}
	
	
	
	
	
	
	function checkv2(){
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
		location.href='orderloadstatusv2.php?account='+account+"&module=orders&action=Loading Orders Results&start="+start+"&end="+end;
	}



</script>