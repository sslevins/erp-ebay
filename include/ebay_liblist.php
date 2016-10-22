<?php
function VerifyAddItem($id){
			
			
			$verb = 'VerifyAddItem';
			global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$dbcon;
			
			
			$ss			= "select * from ebay_list where id='$id'";
			$ss			= $dbcon->execute($ss);
			$ss			= $dbcon->getResultArray($ss);
			$PayPalEmailAddress	= $ss[0]['PayPalEmailAddress'];

			$Title				= $ss[0]['Title'];
			$SKU				= $ss[0]['SKU'];
			$ItemID				= $ss[0]['ItemID'];
			$ListingType		= $ss[0]['ListingType'];
			$ListingDuration	= $ss[0]['ListingDuration'];
			$Description		= $ss[0]['Description'];
			$ebay_account		= $ss[0]['ebay_account'];
			$StartPrice			= $ss[0]['StartPrice'];
			$ReservePrice		= $ss[0]['ReservePrice'];
			$Quantity			= $ss[0]['Quantity'];
			$condition			= $ss[0]['ConditionID'];
			$Country			= $ss[0]['Country'];
			$BuyItNowPrice		= $ss[0]['BuyItNowPrice'];
			$CategoryID			= $ss[0]['CategoryID'];

			$StoreCategoryID	= $ss[0]['StoreCategoryID'];
			
			if($StoreCategoryID != ''){
				$StoreCategory	= '<Storefront><StoreCategoryID>'.$StoreCategoryID.'</StoreCategoryID></Storefront>';
			}
			$Location			= $ss[0]['Location'];
			$DispatchTimeMax							= $ss[0]['DispatchTimeMax']?$ss[0]['DispatchTimeMax']:1;
			$img001										= $ss[0]['PictureURL01'];
			$img002										= $ss[0]['PictureURL02'];
			$img003										= $ss[0]['PictureURL03'];
			$img004										= $ss[0]['PictureURL04'];
			$ebay_listingreturnmethodid					= $ss[0]['ebay_listingreturnmethodid'];
			$ebay_shippingtempate						= $ss[0]['ebay_listingshippingmethodid'];

			
			$ss		= "select * from ebay_listingreturnmethod where id='$ebay_listingreturnmethodid' ";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			
			$ReturnsAcceptedOption				= $ss[0]['ReturnsAcceptedOption'];
			$RefundOption						= $ss[0]['RefundOption'];
			$ReturnsWithinOption				= $ss[0]['ReturnsWithinOption'];
			$ShippingCostPaidByOption			= $ss[0]['ShippingCostPaidByOption'];
			$TDescription						= $ss[0]['Description'];
		
			
			
			$token				= geteBayaccountToken($ebay_account);
			
			
				/* 取得运费模板 */
			 $ss		= "select * from ebay_shippingtemplate where id='$ebay_shippingtempate' ";
			 $ss		= $dbcon->execute($ss);
			 $ss		= $dbcon->getResultArray($ss);
			 
			 $service0					= $ss[0]['service0'];
			 $serviceshippingfee		= $ss[0]['serviceshippingfee'];
			 $serviceshippingfeecost	= $ss[0]['serviceshippingfeecost'];
			 if($service0 !='' && $serviceshippingfee !='' && $serviceshippingfeecost !=''){
				
			 	$tstr		= '  <ShippingServiceOptions>
       			 <ShippingServicePriority>1</ShippingServicePriority>
        		<ShippingService>'.$service0.'</ShippingService>
       <ShippingServiceCost>'.$serviceshippingfeecost.'</ShippingServiceCost>
	   <ShippingServiceAdditionalCost>'.$serviceshippingfeecost.'</ShippingServiceAdditionalCost>
      </ShippingServiceOptions>';
	  
			 
			 }
			 
			 $service1					= $ss[0]['service1'];
			 $service1shippingfee		= $ss[0]['service1shippingfee'];
			 $service1shippingfeecost	= $ss[0]['service1shippingfeecost'];
			 if($service1 !='' && $service1shippingfee !='' && $service1shippingfeecost !=''){
			
			 	$tstr		.= '  <ShippingServiceOptions>
        <ShippingServicePriority>2</ShippingServicePriority>
        <ShippingService>'.$service1.'</ShippingService>
       <ShippingServiceCost>'.$service1shippingfee.'</ShippingServiceCost>
	   <ShippingServiceAdditionalCost>'.$service1shippingfeecost.'</ShippingServiceAdditionalCost>
      </ShippingServiceOptions>';
	  
			 
			 }
			 
			 $service2					= $ss[0]['service2'];
			 $service2shippingfee		= $ss[0]['service2shippingfee'];
			 $service2shippingfeecost	= $ss[0]['service2shippingfeecost'];
			 if($service2 !='' && $service2shippingfee !='' && $service2shippingfeecost !=''){
			
			 	$tstr		.= '  <ShippingServiceOptions>
        <ShippingServicePriority>3</ShippingServicePriority>
        <ShippingService>'.$service2.'</ShippingService>
       <ShippingServiceCost>'.$service2shippingfee.'</ShippingServiceCost>
	   <ShippingServiceAdditionalCost>'.$service2shippingfeecost.'</ShippingServiceAdditionalCost>
      </ShippingServiceOptions>';
	  
			 
			 }
			 
			 
			 $nservice0					= $ss[0]['nservice0'];
			 $nserviceshippingfee		= $ss[0]['nserviceshippingfee'];
			 $nserviceshippingfeecost	= $ss[0]['nserviceshippingfeecost'];
			 $d0						= $ss[0]['d0'];
			 $d1						= $ss[0]['d1'];
			 $d2						= $ss[0]['d2'];
			 $d3						= $ss[0]['d3'];
			 if($nservice0 !='' && $nserviceshippingfee !='' && $nserviceshippingfeecost !=''){
				
				
				$tline					= '';
				if($d0 != '') $tline	.= '<ShipToLocation>'.$d0.'</ShipToLocation>';
				if($d1 != '') $tline	.= '<ShipToLocation>'.$d1.'</ShipToLocation>';
				if($d2 != '') $tline	.= '<ShipToLocation>'.$d2.'</ShipToLocation>';
				if($d3 != '') $tline	.= '<ShipToLocation>'.$d3.'</ShipToLocation>';
				
			 	$ntstr		.= '<InternationalShippingServiceOption>
        <ShippingService>'.$nservice0.'</ShippingService>
        <ShippingServiceAdditionalCost>'.$nserviceshippingfeecost.'</ShippingServiceAdditionalCost>
        <ShippingServiceCost>'.$nserviceshippingfee.'</ShippingServiceCost>
        <ShippingServicePriority>1</ShippingServicePriority>
        '.$tline.'
      </InternationalShippingServiceOption>
    ';
	  
			 
			 }
			 
			 
			 $nservice1					= $ss[0]['nservice1'];
			 $nservices1hippingfee		= $ss[0]['nservices1hippingfee'];
			 $nservices1hippingfeecost	= $ss[0]['nservices1hippingfeecost'];
			 $dd0						= $ss[0]['dd0'];
			 $dd1						= $ss[0]['dd1'];
			 $dd2						= $ss[0]['dd2'];
			 $dd3						= $ss[0]['dd3'];
			 if($nservice1 !='' && $nservices1hippingfee !='' && $nservices1hippingfeecost !=''){
				
				
				$tline					= '';
				if($dd0 != '') $tline	.= '<ShipToLocation>'.$dd0.'</ShipToLocation>';
				if($dd1 != '') $tline	.= '<ShipToLocation>'.$dd1.'</ShipToLocation>';
				if($dd2 != '') $tline	.= '<ShipToLocation>'.$dd2.'</ShipToLocation>';
				if($dd3 != '') $tline	.= '<ShipToLocation>'.$dd3.'</ShipToLocation>';
				
			 	$ntstr		.= '<InternationalShippingServiceOption>
        <ShippingService>'.$nservice1.'</ShippingService>
        <ShippingServiceAdditionalCost>'.$nservices1hippingfeecost.'</ShippingServiceAdditionalCost>
        <ShippingServiceCost>'.$nservices1hippingfee.'</ShippingServiceCost>
        <ShippingServicePriority>1</ShippingServicePriority>
        '.$tline.'
      </InternationalShippingServiceOption>
    ';
	  
			 
			 }
			 
			 
			 $nservice2					= $ss[0]['nservice2'];
			 $nservice2shippingfee		= $ss[0]['nservice2shippingfee'];
			 $nservices2hippingfeecost	= $ss[0]['nservices2hippingfeecost'];
			 $ddd0						= $ss[0]['ddd0'];
			 $ddd1						= $ss[0]['ddd1'];
			 $ddd2						= $ss[0]['ddd2'];
			 $ddd3						= $ss[0]['ddd3'];
			 if($nservice2 !='' && $nservice2shippingfee !='' && $nservices2hippingfeecost !=''){
				
				
				$tline					= '';
				if($ddd0 != '') $tline	.= '<ShipToLocation>'.$ddd0.'</ShipToLocation>';
				if($ddd1 != '') $tline	.= '<ShipToLocation>'.$ddd1.'</ShipToLocation>';
				if($ddd2 != '') $tline	.= '<ShipToLocation>'.$ddd2.'</ShipToLocation>';
				if($ddd3 != '') $tline	.= '<ShipToLocation>'.$ddd3.'</ShipToLocation>';
				
			 	$ntstr		.= '<InternationalShippingServiceOption>
        <ShippingService>'.$nservice2.'</ShippingService>
        <ShippingServiceAdditionalCost>'.$nservices2hippingfeecost.'</ShippingServiceAdditionalCost>
        <ShippingServiceCost>'.$nservice2shippingfee.'</ShippingServiceCost>
        <ShippingServicePriority>1</ShippingServicePriority>
        '.$tline.'
      </InternationalShippingServiceOption>
    ';
	  
			 
			 }
			 
			
			 $l01						= $ss[0]['l01'];
			 $l02						= $ss[0]['l02'];
			 $l03						= $ss[0]['l03'];
			 $l04						= $ss[0]['l04'];
			 $l05						= $ss[0]['l05'];
			 $l06						= $ss[0]['l06'];
			 $l07						= $ss[0]['l07'];
			 $l08						= $ss[0]['l08'];
			 $l09						= $ss[0]['l09'];
			 $l10						= $ss[0]['l10'];
			 $lstr						= '';
			 
			 if($l01 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l01.'</ExcludeShipToLocation>';
			 if($l02 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l02.'</ExcludeShipToLocation>';
			 if($l03 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l03.'</ExcludeShipToLocation>';
			 if($l04 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l04.'</ExcludeShipToLocation>';
			 if($l05 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l05.'</ExcludeShipToLocation>';
			 if($l06 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l06.'</ExcludeShipToLocation>';
			 if($l07 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l07.'</ExcludeShipToLocation>';
			 if($l08 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l08.'</ExcludeShipToLocation>';
			 if($l09 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l09.'</ExcludeShipToLocation>';
			 if($l10 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l10.'</ExcludeShipToLocation>';
			 
			 /* 检查多属性产品 */
			$ss		= "select * from ebay_listvarious where sid='$id' ";
			
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			
			$name0	= $ss[0]['name0'];
			$name1	= $ss[0]['name1'];
			$name2	= $ss[0]['name2'];
			$name3	= $ss[0]['name3'];
			$name4	= $ss[0]['name4'];
			$pid	= $ss[0]['id'];
			$name0arry = array();
			$name1arry = array();
			$name2arry = array();
			$name3arry = array();
			$name4arry = array();
			
			
			/* 检查多属性产品的值 */
			
			$ss		= "select value0 from ebay_listvariousdetails where pid='$pid' group by value0";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			for($i=0;$i<count($ss);$i++){
				$name0arry[$i] = $ss[$i]['value0'];
			}
			
			$ss		= "select value1 from ebay_listvariousdetails where pid='$pid' group by value1";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			for($i=0;$i<count($ss);$i++){
				$name1arry[$i] = $ss[$i]['value1'];
			}
			
			$ss		= "select value2 from ebay_listvariousdetails where pid='$pid' group by value2";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			
			for($i=0;$i<count($ss);$i++){
				$name2arry[$i] = $ss[$i]['value2'];
			}
			
			$ss		= "select value3 from ebay_listvariousdetails where pid='$pid' group by value3";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			for($i=0;$i<count($ss);$i++){
				$name3arry[$i] = $ss[$i]['value3'];
			}
			
			$ss		= "select value0 from ebay_listvariousdetails where pid='$pid' group by value4";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			for($i=0;$i<count($ss);$i++){
				$name4arry[$i] = $ss[$i]['value4'];
			}
			
			

			
			$tvarname	= '';
			if($name0 != '' && count($name0arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name0arry);$i++){
					$tvarvalue	.= '<Value>'.$name0arry[$i].'</Value>';
				}
				$tvarname	= '<NameValueList><Name>'.$name0.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			
			if($name1 != '' && count($name1arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name1arry);$i++){
					$tvarvalue	.= '<Value>'.$name1arry[$i].'</Value>';
				}
				$tvarname	.= '<NameValueList><Name>'.$name1.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			
			if($name2 != '' && count($name2arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name2arry);$i++){
					$tvarvalue	.= '<Value>'.$name2arry[$i].'</Value>';
				}
				$tvarname	.= '<NameValueList><Name>'.$name2.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			
			if($name3 != '' && count($name3arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name3arry);$i++){
					$tvarvalue	.= '<Value>'.$name3arry[$i].'</Value>';
				}
				$tvarname	.= '<NameValueList><Name>'.$name3.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			
			if($name4 != '' && count($name4arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name4arry);$i++){
					$tvarvalue	.= '<Value>'.$name4arry[$i].'</Value>';
				}
				$tvarname	.= '<NameValueList><Name>'.$name4.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			$tvarname		= fstr_rep($tvarname);
			
			
			$ss		= "select * from ebay_listvariousdetails where pid='$pid' ";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			$varline	= '';
			$varpic		= '';
			
			
			for($i=0;$i<count($ss);$i++){
				
				$sku		= $ss[$i]['sku'];
				$value0		= $ss[$i]['value0'];
				$value1		= $ss[$i]['value1'];
				$value2		= $ss[$i]['value2'];
				$value3		= $ss[$i]['value3'];
				$value4		= $ss[$i]['value4'];
				$price		= $ss[$i]['price'];
				$picture	= $ss[$i]['picture'];
				$qty		= $ss[$i]['qty'];
			
				
				
				$tvar0		= " <Variation>
        		<SKU>".$sku."</SKU>
        		<StartPrice>".$price."</StartPrice>
        		<Quantity>".$qty."</Quantity>
				<VariationSpecifics>
				";
				
				$var1		= '';
				if($name0 != '' && $value0 != ''){
				
				$name0		 = fstr_rep($name0);
				$var1		.= "<NameValueList><Name>".$name0."</Name><Value>".$value0."</Value></NameValueList>";
				
				if($picture != ''){
				$varpic		 .= " 
        						 <VariationSpecificPictureSet>
          						 <VariationSpecificValue>".$value0."</VariationSpecificValue>
          						 <PictureURL>".$picture."</PictureURL>
        						 </VariationSpecificPictureSet>";
				}
				
				}
				
				if($name1 != '' && $value1 != ''){
				$name1		 = fstr_rep($name1);
				$var1		.= "<NameValueList><Name>".$name1."</Name><Value>".$value1."</Value></NameValueList>";
				}
				if($name2 != '' && $value2 != ''){
				$name2		 = fstr_rep($name2);
				$var1		.= "<NameValueList><Name>".$name2."</Name><Value>".$value2."</Value></NameValueList>";
				}
				
				if($name3 != '' && $value3 != ''){
				$name3		 = fstr_rep($name3);
				$var1		.= "<NameValueList><Name>".$name3."</Name><Value>".$value3."</Value></NameValueList>";
				}
				
				if($name4 != '' && $value4 != ''){
				$name4		 = fstr_rep($name4);
				$var1		.= "<NameValueList><Name>".$name4."</Name><Value>".$value4."</Value></NameValueList>";
				}
				
				
				$varline	.= $tvar0.$var1.'</VariationSpecifics></Variation>';
				
        		
        		
				
			}
			
			
			$varpic		= '<Pictures>'."<VariationSpecificName>".$name0."</VariationSpecificName>".$varpic.'</Pictures>';
			
			if($tvarname != ''){
				$variations				= "
			  <Variations>
      <VariationSpecificsSet>
    ".$tvarname."
      </VariationSpecificsSet>
    ".$varline.$varpic."
     
    </Variations>
			";
			}

			 $namevaluelist		= '';
			 $ss				= "select * from ebay_itemspecifics where sid ='$id'";
			 $ss				= $dbcon->execute($ss);
			 $ss				= $dbcon->getResultArray($ss);
			 
			for($i=0;$i<count($ss);$i++){
			 
				
				$keys			=$ss[$i]['name'];
				$value			= fstr_rep($ss[$i]['value']);
				/* 检查此keys是否存在于多属性当中 */
				
				$yy		= "select * from ebay_listvarious where name0='$keys' or name1='$keys' or name2='$keys' or name3='$keys' or name4='$keys' ";
			

				$yy				= $dbcon->execute($yy);
				$yy				= $dbcon->getResultArray($yy);
				$keys			= fstr_rep($ss[$i]['name']);
				if(count($yy) ==0 ){
				$namevaluelist		.= '<NameValueList>
			 	<Name>'.$keys.'</Name>
			 	<Value>'.$value.'</Value>
      			 </NameValueList>';
				}
				
				
			 } 
			 
			 

			 $itemspecific			= '<ItemSpecifics>'.$namevaluelist.'</ItemSpecifics>';

			
			$xmlRequest		= '<?xml version="1.0" encoding="utf-8"?>
			<VerifyAddItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
			<ErrorLanguage>en_US</ErrorLanguage>
  			<WarningLevel>High</WarningLevel>
  			<Item>
			'.$StoreCategory.'
    		<ItemID>'.$ItemID.'</ItemID>
    		<SKU>'.$SKU.'</SKU>
			<Title>'.$Title.'</Title>
   			<Description><![CDATA['.$Description.']]></Description>    		
		    <PrimaryCategory><CategoryID>'.$CategoryID.'</CategoryID></PrimaryCategory>
    		<StartPrice>'.$StartPrice.'</StartPrice>';
			if($ReservePrice != '') 		$xmlRequest .= '<ReservePrice currencyID="USD">'.$ReservePrice.'</ReservePrice>';
			if($ListingType == 'Chinese') 	$xmlRequest .= '<BuyItNowPrice currencyID="USD">'.$BuyItNowPrice.'</BuyItNowPrice> ';
			if($Quantity > 0) 				$xmlRequest .= '<Quantity>'.$Quantity.'</Quantity>';
			
			$xmlRequest	.= '			
    		<ConditionID>'.$condition.'</ConditionID>
   			<CategoryMappingAllowed>true</CategoryMappingAllowed>
    		<Country>'.$Country.'</Country>'.$itemspecific.$variations.'
    		<Currency>USD</Currency>
			<Location>'.$Location.'</Location>
    		<DispatchTimeMax>'.$DispatchTimeMax.'</DispatchTimeMax>
    		<ListingDuration>'.$ListingDuration.'</ListingDuration>
   			<ListingType>'.$ListingType.'</ListingType>
    		<PaymentMethods>PayPal</PaymentMethods>
   			<PayPalEmailAddress>'.$PayPalEmailAddress.'</PayPalEmailAddress>
	 		<PictureDetails>
	  		<GalleryType>Gallery</GalleryType>';
	  
	  
	  		if($img001 != '') $xmlRequest .= '<PictureURL>'.$img001.'</PictureURL>';
	 		if($img002 != '') $xmlRequest .= '<PictureURL>'.$img002.'</PictureURL>';
	 		if($img003 != '') $xmlRequest .= '<PictureURL>'.$img003.'</PictureURL>';
	 		if($img004 != '') $xmlRequest .= '<PictureURL>'.$img004.'</PictureURL>';
	  
	  		$xmlRequest .='
    		</PictureDetails>
    		<PostalCode>95125</PostalCode>
    		<ReturnPolicy>
      		<ReturnsAcceptedOption>'.$ReturnsAcceptedOption.'</ReturnsAcceptedOption>
      		<RefundOption>'.$RefundOption.'</RefundOption>
      		<ReturnsWithinOption>'.$ReturnsWithinOption.'</ReturnsWithinOption>
      		<Description>'.$TDescription.'</Description>
      		<ShippingCostPaidByOption>'.$ShippingCostPaidByOption.'</ShippingCostPaidByOption>
    		</ReturnPolicy>
	
   			<ShippingDetails>
      		<ShippingType>Flat</ShippingType>
    		'.$tstr.$ntstr.$lstr.'
   			 </ShippingDetails>
  			</Item>
  			<RequesterCredentials>
   			<eBayAuthToken>'.$token.'</eBayAuthToken>
  			</RequesterCredentials>
  			<WarningLevel>High</WarningLevel>
			</VerifyAddItemRequest>

			';

			
			 $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);

			 $responseXml = $session->sendHttpRequest($xmlRequest);		

			 if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';

			 $data=XML_unserialize($responseXml); 
			 
			 $ack		= $data['VerifyAddItemResponse']['Ack'];
			 echo '<br> ID: '.$id.'<br>';
			 if($ack != 'Failure'){
				 
				 if($data['VerifyAddItemResponse']['Errors']['LongMessage'] == ''){
					 
					 
					for($i=0;$i<count($data['VerifyAddItemResponse']['Errors']);$i++){
						
						$errors		= $data['VerifyAddItemResponse']['Errors'][$i]['LongMessage'];
						$errors		= str_replace('<','',$errors);
						$errors		= str_replace('>','',$errors);
						
						echo '<br><font color="#FF0000">'.$errors.'</font>';
					}
					 
				 }else{
					 
					 
					   $errors		= $data['VerifyAddItemResponse']['Errors']['LongMessage'];
						$errors		= str_replace('<','',$errors);
						$errors		= str_replace('>','',$errors);
						
					 echo '<br><font color="#FF0000">'.$errors.'</font>';
				 }
				 $ItemID			= $data['VerifyAddItemResponse']['ItemID'];
				 echo '可以成功上传。。。。<br>';
				 
				 
			 }else{
				 
				 
					
				 if($data['VerifyAddItemResponse']['Errors']['LongMessage'] == ''){
					for($i=0;$i<count($data['VerifyAddItemResponse']['Errors']);$i++){
						
						$errors		= $data['VerifyAddItemResponse']['Errors'][$i]['LongMessage'];
						$errors		= str_replace('<','',$errors);
						$errors		= str_replace('>','',$errors);
						
						echo '<br><font color="#FF0000">'.$errors.'</font>';
					}
					 
				 }else{
					 
						$errors		= $data['VerifyAddItemResponse']['Errors']['LongMessage'];
						$errors		= str_replace('<','',$errors);
						$errors		= str_replace('>','',$errors);
						
					 echo '<br><font color="#FF0000">'.$errors.'</font>';
				 }
				 
			
				 
				 
				 
			 }
			 
			 
		
		
		
		
		
		}
		


		function VerifyAddFixedPriceItem($id){
			
			
			$verb = 'VerifyAddFixedPriceItem';
			global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$dbcon;
			
			
			$ss			= "select * from ebay_list where id='$id'";
			$ss			= $dbcon->execute($ss);
			$ss			= $dbcon->getResultArray($ss);
			
			$PayPalEmailAddress	= $ss[0]['PayPalEmailAddress'];
			$Title				= $ss[0]['Title'];
			$SKU				= $ss[0]['SKU'];
			$ItemID				= $ss[0]['ItemID'];
			$ListingType		= $ss[0]['ListingType'];
			$ListingDuration	= $ss[0]['ListingDuration'];
			$Description		= $ss[0]['Description'];
			$ebay_account		= $ss[0]['ebay_account'];
			$StartPrice			= $ss[0]['StartPrice'];
			$ReservePrice		= $ss[0]['ReservePrice'];
			$Quantity			= $ss[0]['Quantity'];
			$condition			= $ss[0]['ConditionID'];
			$Country			= $ss[0]['Country'];
			$BuyItNowPrice		= $ss[0]['BuyItNowPrice'];
			$CategoryID			= $ss[0]['CategoryID'];

			$StoreCategoryID	= $ss[0]['StoreCategoryID'];
			
			if($StoreCategoryID != ''){
				$StoreCategory	= '<Storefront><StoreCategoryID>'.$StoreCategoryID.'</StoreCategoryID></Storefront>';
			}
			$Location			= $ss[0]['Location'];
			$DispatchTimeMax							= $ss[0]['DispatchTimeMax']?$ss[0]['DispatchTimeMax']:1;
			$img001										= $ss[0]['PictureURL01'];
			$img002										= $ss[0]['PictureURL02'];
			$img003										= $ss[0]['PictureURL03'];
			$img004										= $ss[0]['PictureURL04'];
			$ebay_listingreturnmethodid					= $ss[0]['ebay_listingreturnmethodid'];
			$ebay_shippingtempate						= $ss[0]['ebay_listingshippingmethodid'];

			
			$ss		= "select * from ebay_listingreturnmethod where id='$ebay_listingreturnmethodid' ";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			
			$ReturnsAcceptedOption				= $ss[0]['ReturnsAcceptedOption'];
			$RefundOption						= $ss[0]['RefundOption'];
			$ReturnsWithinOption				= $ss[0]['ReturnsWithinOption'];
			$ShippingCostPaidByOption			= $ss[0]['ShippingCostPaidByOption'];
			$TDescription						= $ss[0]['Description'];
		
			
			
			$token				= geteBayaccountToken($ebay_account);
			
			
				/* 取得运费模板 */
			 $ss		= "select * from ebay_shippingtemplate where id='$ebay_shippingtempate' ";
			 $ss		= $dbcon->execute($ss);
			 $ss		= $dbcon->getResultArray($ss);
			 
			 $service0					= $ss[0]['service0'];
			 $serviceshippingfee		= $ss[0]['serviceshippingfee'];
			 $serviceshippingfeecost	= $ss[0]['serviceshippingfeecost'];
			 if($service0 !='' && $serviceshippingfee !='' && $serviceshippingfeecost !=''){
				
			 	$tstr		= '  <ShippingServiceOptions>
       			 <ShippingServicePriority>1</ShippingServicePriority>
        		<ShippingService>'.$service0.'</ShippingService>
       <ShippingServiceCost>'.$serviceshippingfeecost.'</ShippingServiceCost>
	   <ShippingServiceAdditionalCost>'.$serviceshippingfeecost.'</ShippingServiceAdditionalCost>
      </ShippingServiceOptions>';
	  
			 
			 }
			 
			 $service1					= $ss[0]['service1'];
			 $service1shippingfee		= $ss[0]['service1shippingfee'];
			 $service1shippingfeecost	= $ss[0]['service1shippingfeecost'];
			 if($service1 !='' && $service1shippingfee !='' && $service1shippingfeecost !=''){
			
			 	$tstr		.= '  <ShippingServiceOptions>
        <ShippingServicePriority>2</ShippingServicePriority>
        <ShippingService>'.$service1.'</ShippingService>
       <ShippingServiceCost>'.$service1shippingfee.'</ShippingServiceCost>
	   <ShippingServiceAdditionalCost>'.$service1shippingfeecost.'</ShippingServiceAdditionalCost>
      </ShippingServiceOptions>';
	  
			 
			 }
			 
			 $service2					= $ss[0]['service2'];
			 $service2shippingfee		= $ss[0]['service2shippingfee'];
			 $service2shippingfeecost	= $ss[0]['service2shippingfeecost'];
			 if($service2 !='' && $service2shippingfee !='' && $service2shippingfeecost !=''){
			
			 	$tstr		.= '  <ShippingServiceOptions>
        <ShippingServicePriority>3</ShippingServicePriority>
        <ShippingService>'.$service2.'</ShippingService>
       <ShippingServiceCost>'.$service2shippingfee.'</ShippingServiceCost>
	   <ShippingServiceAdditionalCost>'.$service2shippingfeecost.'</ShippingServiceAdditionalCost>
      </ShippingServiceOptions>';
	  
			 
			 }
			 
			 
			 $nservice0					= $ss[0]['nservice0'];
			 $nserviceshippingfee		= $ss[0]['nserviceshippingfee'];
			 $nserviceshippingfeecost	= $ss[0]['nserviceshippingfeecost'];
			 $d0						= $ss[0]['d0'];
			 $d1						= $ss[0]['d1'];
			 $d2						= $ss[0]['d2'];
			 $d3						= $ss[0]['d3'];
			 if($nservice0 !='' && $nserviceshippingfee !='' && $nserviceshippingfeecost !=''){
				
				
				$tline					= '';
				if($d0 != '') $tline	.= '<ShipToLocation>'.$d0.'</ShipToLocation>';
				if($d1 != '') $tline	.= '<ShipToLocation>'.$d1.'</ShipToLocation>';
				if($d2 != '') $tline	.= '<ShipToLocation>'.$d2.'</ShipToLocation>';
				if($d3 != '') $tline	.= '<ShipToLocation>'.$d3.'</ShipToLocation>';
				
			 	$ntstr		.= '<InternationalShippingServiceOption>
        <ShippingService>'.$nservice0.'</ShippingService>
        <ShippingServiceAdditionalCost>'.$nserviceshippingfeecost.'</ShippingServiceAdditionalCost>
        <ShippingServiceCost>'.$nserviceshippingfee.'</ShippingServiceCost>
        <ShippingServicePriority>1</ShippingServicePriority>
        '.$tline.'
      </InternationalShippingServiceOption>
    ';
	  
			 
			 }
			 
			 
			 $nservice1					= $ss[0]['nservice1'];
			 $nservices1hippingfee		= $ss[0]['nservices1hippingfee'];
			 $nservices1hippingfeecost	= $ss[0]['nservices1hippingfeecost'];
			 $dd0						= $ss[0]['dd0'];
			 $dd1						= $ss[0]['dd1'];
			 $dd2						= $ss[0]['dd2'];
			 $dd3						= $ss[0]['dd3'];
			 if($nservice1 !='' && $nservices1hippingfee !='' && $nservices1hippingfeecost !=''){
				
				
				$tline					= '';
				if($dd0 != '') $tline	.= '<ShipToLocation>'.$dd0.'</ShipToLocation>';
				if($dd1 != '') $tline	.= '<ShipToLocation>'.$dd1.'</ShipToLocation>';
				if($dd2 != '') $tline	.= '<ShipToLocation>'.$dd2.'</ShipToLocation>';
				if($dd3 != '') $tline	.= '<ShipToLocation>'.$dd3.'</ShipToLocation>';
				
			 	$ntstr		.= '<InternationalShippingServiceOption>
        <ShippingService>'.$nservice1.'</ShippingService>
        <ShippingServiceAdditionalCost>'.$nservices1hippingfeecost.'</ShippingServiceAdditionalCost>
        <ShippingServiceCost>'.$nservices1hippingfee.'</ShippingServiceCost>
        <ShippingServicePriority>1</ShippingServicePriority>
        '.$tline.'
      </InternationalShippingServiceOption>
    ';
	  
			 
			 }
			 
			 
			 $nservice2					= $ss[0]['nservice2'];
			 $nservice2shippingfee		= $ss[0]['nservice2shippingfee'];
			 $nservices2hippingfeecost	= $ss[0]['nservices2hippingfeecost'];
			 $ddd0						= $ss[0]['ddd0'];
			 $ddd1						= $ss[0]['ddd1'];
			 $ddd2						= $ss[0]['ddd2'];
			 $ddd3						= $ss[0]['ddd3'];
			 if($nservice2 !='' && $nservice2shippingfee !='' && $nservices2hippingfeecost !=''){
				
				
				$tline					= '';
				if($ddd0 != '') $tline	.= '<ShipToLocation>'.$ddd0.'</ShipToLocation>';
				if($ddd1 != '') $tline	.= '<ShipToLocation>'.$ddd1.'</ShipToLocation>';
				if($ddd2 != '') $tline	.= '<ShipToLocation>'.$ddd2.'</ShipToLocation>';
				if($ddd3 != '') $tline	.= '<ShipToLocation>'.$ddd3.'</ShipToLocation>';
				
			 	$ntstr		.= '<InternationalShippingServiceOption>
        <ShippingService>'.$nservice2.'</ShippingService>
        <ShippingServiceAdditionalCost>'.$nservices2hippingfeecost.'</ShippingServiceAdditionalCost>
        <ShippingServiceCost>'.$nservice2shippingfee.'</ShippingServiceCost>
        <ShippingServicePriority>1</ShippingServicePriority>
        '.$tline.'
      </InternationalShippingServiceOption>
    ';
	  
			 
			 }
			 
			
			 $l01						= $ss[0]['l01'];
			 $l02						= $ss[0]['l02'];
			 $l03						= $ss[0]['l03'];
			 $l04						= $ss[0]['l04'];
			 $l05						= $ss[0]['l05'];
			 $l06						= $ss[0]['l06'];
			 $l07						= $ss[0]['l07'];
			 $l08						= $ss[0]['l08'];
			 $l09						= $ss[0]['l09'];
			 $l10						= $ss[0]['l10'];
			 $lstr						= '';
			 
			 if($l01 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l01.'</ExcludeShipToLocation>';
			 if($l02 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l02.'</ExcludeShipToLocation>';
			 if($l03 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l03.'</ExcludeShipToLocation>';
			 if($l04 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l04.'</ExcludeShipToLocation>';
			 if($l05 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l05.'</ExcludeShipToLocation>';
			 if($l06 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l06.'</ExcludeShipToLocation>';
			 if($l07 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l07.'</ExcludeShipToLocation>';
			 if($l08 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l08.'</ExcludeShipToLocation>';
			 if($l09 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l09.'</ExcludeShipToLocation>';
			 if($l10 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l10.'</ExcludeShipToLocation>';
			 
			 /* 检查多属性产品 */
			$ss		= "select * from ebay_listvarious where sid='$id' ";
			
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			
			$name0	= $ss[0]['name0'];
			$name1	= $ss[0]['name1'];
			$name2	= $ss[0]['name2'];
			$name3	= $ss[0]['name3'];
			$name4	= $ss[0]['name4'];
			$pid	= $ss[0]['id'];
			$name0arry = array();
			$name1arry = array();
			$name2arry = array();
			$name3arry = array();
			$name4arry = array();
			
			
			/* 检查多属性产品的值 */
			
			$ss		= "select value0 from ebay_listvariousdetails where pid='$pid' group by value0";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			for($i=0;$i<count($ss);$i++){
				$name0arry[$i] = $ss[$i]['value0'];
			}
			
			$ss		= "select value1 from ebay_listvariousdetails where pid='$pid' group by value1";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			for($i=0;$i<count($ss);$i++){
				$name1arry[$i] = $ss[$i]['value1'];
			}
			
			$ss		= "select value2 from ebay_listvariousdetails where pid='$pid' group by value2";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			
			for($i=0;$i<count($ss);$i++){
				$name2arry[$i] = $ss[$i]['value2'];
			}
			
			$ss		= "select value3 from ebay_listvariousdetails where pid='$pid' group by value3";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			for($i=0;$i<count($ss);$i++){
				$name3arry[$i] = $ss[$i]['value3'];
			}
			
			$ss		= "select value0 from ebay_listvariousdetails where pid='$pid' group by value4";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			for($i=0;$i<count($ss);$i++){
				$name4arry[$i] = $ss[$i]['value4'];
			}
			
			

			
			$tvarname	= '';
			if($name0 != '' && count($name0arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name0arry);$i++){
					$tvarvalue	.= '<Value>'.$name0arry[$i].'</Value>';
				}
				$tvarname	= '<NameValueList><Name>'.$name0.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			
			if($name1 != '' && count($name1arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name1arry);$i++){
					$tvarvalue	.= '<Value>'.$name1arry[$i].'</Value>';
				}
				$tvarname	.= '<NameValueList><Name>'.$name1.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			
			if($name2 != '' && count($name2arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name2arry);$i++){
					$tvarvalue	.= '<Value>'.$name2arry[$i].'</Value>';
				}
				$tvarname	.= '<NameValueList><Name>'.$name2.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			
			if($name3 != '' && count($name3arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name3arry);$i++){
					$tvarvalue	.= '<Value>'.$name3arry[$i].'</Value>';
				}
				$tvarname	.= '<NameValueList><Name>'.$name3.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			
			if($name4 != '' && count($name4arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name4arry);$i++){
					$tvarvalue	.= '<Value>'.$name4arry[$i].'</Value>';
				}
				$tvarname	.= '<NameValueList><Name>'.$name4.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			$tvarname		= fstr_rep($tvarname);
			
			
			$ss		= "select * from ebay_listvariousdetails where pid='$pid' ";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			$varline	= '';
			$varpic		= '';
			
			
			for($i=0;$i<count($ss);$i++){
				
				$sku		= $ss[$i]['sku'];
				$value0		= $ss[$i]['value0'];
				$value1		= $ss[$i]['value1'];
				$value2		= $ss[$i]['value2'];
				$value3		= $ss[$i]['value3'];
				$value4		= $ss[$i]['value4'];
				$price		= $ss[$i]['price'];
				$picture	= $ss[$i]['picture'];
				$qty		= $ss[$i]['qty'];
			
				
				
				$tvar0		= " <Variation>
        		<SKU>".$sku."</SKU>
        		<StartPrice>".$price."</StartPrice>
        		<Quantity>".$qty."</Quantity>
				<VariationSpecifics>
				";
				
				$var1		= '';
				if($name0 != '' && $value0 != ''){
				
				$name0		 = fstr_rep($name0);
				$var1		.= "<NameValueList><Name>".$name0."</Name><Value>".$value0."</Value></NameValueList>";
				
				if($picture != ''){
				$varpic		 .= " 
        						 <VariationSpecificPictureSet>
          						 <VariationSpecificValue>".$value0."</VariationSpecificValue>
          						 <PictureURL>".$picture."</PictureURL>
        						 </VariationSpecificPictureSet>";
				}
				
				}
				
				if($name1 != '' && $value1 != ''){
				$name1		 = fstr_rep($name1);
				$var1		.= "<NameValueList><Name>".$name1."</Name><Value>".$value1."</Value></NameValueList>";
				}
				if($name2 != '' && $value2 != ''){
				$name2		 = fstr_rep($name2);
				$var1		.= "<NameValueList><Name>".$name2."</Name><Value>".$value2."</Value></NameValueList>";
				}
				
				if($name3 != '' && $value3 != ''){
				$name3		 = fstr_rep($name3);
				$var1		.= "<NameValueList><Name>".$name3."</Name><Value>".$value3."</Value></NameValueList>";
				}
				
				if($name4 != '' && $value4 != ''){
				$name4		 = fstr_rep($name4);
				$var1		.= "<NameValueList><Name>".$name4."</Name><Value>".$value4."</Value></NameValueList>";
				}
				
				
				$varline	.= $tvar0.$var1.'</VariationSpecifics></Variation>';
				
        		
        		
				
			}
			
			
			$varpic		= '<Pictures>'."<VariationSpecificName>".$name0."</VariationSpecificName>".$varpic.'</Pictures>';
			
			if($tvarname != ''){
				$variations				= "
			  <Variations>
      <VariationSpecificsSet>
    ".$tvarname."
      </VariationSpecificsSet>
    ".$varline.$varpic."
     
    </Variations>
			";
			}

			 $namevaluelist		= '';
			 $ss				= "select * from ebay_itemspecifics where sid ='$id'";
			 $ss				= $dbcon->execute($ss);
			 $ss				= $dbcon->getResultArray($ss);
			 
			for($i=0;$i<count($ss);$i++){
			 
				
				$keys			=$ss[$i]['name'];
				$value			= fstr_rep($ss[$i]['value']);
				/* 检查此keys是否存在于多属性当中 */
				
				$yy		= "select * from ebay_listvarious where name0='$keys' or name1='$keys' or name2='$keys' or name3='$keys' or name4='$keys' ";
			

				$yy				= $dbcon->execute($yy);
				$yy				= $dbcon->getResultArray($yy);
				$keys			= fstr_rep($ss[$i]['name']);
				if(count($yy) ==0 ){
				$namevaluelist		.= '<NameValueList>
			 	<Name>'.$keys.'</Name>
			 	<Value>'.$value.'</Value>
      			 </NameValueList>';
				}
				
				
			 } 
			 
			 

			 $itemspecific			= '<ItemSpecifics>'.$namevaluelist.'</ItemSpecifics>';

			
			$xmlRequest		= '<?xml version="1.0" encoding="utf-8"?>
			<VerifyAddFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
			<ErrorLanguage>en_US</ErrorLanguage>
  			<WarningLevel>High</WarningLevel>
  			<Item>
			'.$StoreCategory.'
    		<ItemID>'.$ItemID.'</ItemID>
    		<SKU>'.$SKU.'</SKU>
			<Title>'.$Title.'</Title>
   			<Description><![CDATA['.$Description.']]></Description>    		
		    <PrimaryCategory><CategoryID>'.$CategoryID.'</CategoryID></PrimaryCategory>
    		<StartPrice>'.$StartPrice.'</StartPrice>';
			if($ReservePrice != '') 		$xmlRequest .= '<ReservePrice currencyID="USD">'.$ReservePrice.'</ReservePrice>';
			if($ListingType == 'Chinese') 	$xmlRequest .= '<BuyItNowPrice currencyID="USD">'.$BuyItNowPrice.'</BuyItNowPrice> ';
			if($Quantity > 0) 				$xmlRequest .= '<Quantity>'.$Quantity.'</Quantity>';
			
			$xmlRequest	.= '			
    		<ConditionID>'.$condition.'</ConditionID>
   			<CategoryMappingAllowed>true</CategoryMappingAllowed>
    		<Country>'.$Country.'</Country>'.$itemspecific.$variations.'
    		<Currency>USD</Currency>
			<Location>'.$Location.'</Location>
    		<DispatchTimeMax>'.$DispatchTimeMax.'</DispatchTimeMax>
    		<ListingDuration>'.$ListingDuration.'</ListingDuration>
   			<ListingType>'.$ListingType.'</ListingType>
    		<PaymentMethods>PayPal</PaymentMethods>
   			<PayPalEmailAddress>'.$PayPalEmailAddress.'</PayPalEmailAddress>
	 		<PictureDetails>
	  		<GalleryType>Gallery</GalleryType>';
	  
	  
	  		if($img001 != '') $xmlRequest .= '<PictureURL>'.$img001.'</PictureURL>';
	 		if($img002 != '') $xmlRequest .= '<PictureURL>'.$img002.'</PictureURL>';
	 		if($img003 != '') $xmlRequest .= '<PictureURL>'.$img003.'</PictureURL>';
	 		if($img004 != '') $xmlRequest .= '<PictureURL>'.$img004.'</PictureURL>';
	  
	  		$xmlRequest .='
    		</PictureDetails>
    		<PostalCode>95125</PostalCode>
    		<ReturnPolicy>
      		<ReturnsAcceptedOption>'.$ReturnsAcceptedOption.'</ReturnsAcceptedOption>
      		<RefundOption>'.$RefundOption.'</RefundOption>
      		<ReturnsWithinOption>'.$ReturnsWithinOption.'</ReturnsWithinOption>
      		<Description>'.$TDescription.'</Description>
      		<ShippingCostPaidByOption>'.$ShippingCostPaidByOption.'</ShippingCostPaidByOption>
    		</ReturnPolicy>
	
   			<ShippingDetails>
      		<ShippingType>Flat</ShippingType>
    		'.$tstr.$ntstr.$lstr.'
   			 </ShippingDetails>
  			</Item>
  			<RequesterCredentials>
   			<eBayAuthToken>'.$token.'</eBayAuthToken>
  			</RequesterCredentials>
  			<WarningLevel>High</WarningLevel>
			</VerifyAddFixedPriceItemRequest>

			';

			
			 $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);

			 $responseXml = $session->sendHttpRequest($xmlRequest);		

			 if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';

			 $data=XML_unserialize($responseXml); 
			 
			 $ack		= $data['VerifyAddFixedPriceItemResponse']['Ack'];
			 echo '<br> ID: '.$id.'<br>';
			 if($ack != 'Failure'){
				 
				 if($data['VerifyAddFixedPriceItemResponse']['Errors']['LongMessage'] == ''){
					 
					 
					for($i=0;$i<count($data['VerifyAddFixedPriceItemResponse']['Errors']);$i++){
						
						$errors		= $data['VerifyAddFixedPriceItemResponse']['Errors'][$i]['LongMessage'];
						$errors		= str_replace('<','',$errors);
						$errors		= str_replace('>','',$errors);
						
						echo '<br><font color="#FF0000">'.$errors.'</font>';
					}
					 
				 }else{
					 
					 
					   $errors		= $data['VerifyAddFixedPriceItemResponse']['Errors']['LongMessage'];
						$errors		= str_replace('<','',$errors);
						$errors		= str_replace('>','',$errors);
						
					 echo '<br><font color="#FF0000">'.$errors.'</font>';
				 }
				 $ItemID			= $data['ReviseFixedPriceItemResponse']['ItemID'];
				 echo '可以成功上传。。。。<br>';
				 
			 }else{
				 
				 
					
				 if($data['VerifyAddFixedPriceItemResponse']['Errors']['LongMessage'] == ''){
					for($i=0;$i<count($data['VerifyAddFixedPriceItemResponse']['Errors']);$i++){
						
						$errors		= $data['VerifyAddFixedPriceItemResponse']['Errors'][$i]['LongMessage'];
						$errors		= str_replace('<','',$errors);
						$errors		= str_replace('>','',$errors);
						
						echo '<br><font color="#FF0000">'.$errors.'</font>';
					}
					 
				 }else{
					 
						$errors		= $data['VerifyAddFixedPriceItemResponse']['Errors']['LongMessage'];
						$errors		= str_replace('<','',$errors);
						$errors		= str_replace('>','',$errors);
						
					 echo '<br><font color="#FF0000">'.$errors.'</font>';
				 }
				 
			
				 
				 
				 
			 }
			 
			 
		
		
		
		
		
		}
		
		
		
		function GetStore($ebay_account){
			
			
			 $verb = 'GetStore';
			 /* 取token */
			 $token		= geteBayaccountToken($ebay_account);
			 global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$dbcon,$user;
			 
			 $compatabilityLevel = 741;
			 $xmlRequest		= '<?xml version="1.0" encoding="utf-8"?>
<GetStoreRequest xmlns="urn:ebay:apis:eBLBaseComponents">
  <RequesterCredentials>
    <eBayAuthToken>'.$token.'</eBayAuthToken>
  </RequesterCredentials>
</GetStoreRequest>';

		


		
			 $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
			 $responseXml = $session->sendHttpRequest($xmlRequest);		
			 if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';
			 $data=XML_unserialize($responseXml);
	
	
			 $ack = $data['GetStoreResponse']['Ack'];
			 $picurl = '';
			 if($ack == 'Failure'){
			 $status = '<br><font color="#FF0000">'.$data['GetStoreResponse']['Errors']['LongMessage'].'</font>';
			 }else{
				 
				 
			$category = $data['GetStoreResponse']['Store']['CustomCategories']['CustomCategory'];
			
	
			
			for($i=0;$i<count($category);$i++){
				
				
				$CategoryID		= $category[$i]['CategoryID'];
				$Name			= $category[$i]['Name'];
				$Order			= $category[$i]['Order'];
				
				$ss				= "select * from ebay_storecategory where CategoryID ='$CategoryID' and ebay_user='$user' and ebay_account='$ebay_account'";
				

				$ss				= $dbcon->execute($ss);
				$ss				= $dbcon->getResultArray($ss);
				
				if(count($ss) > 0){
					
					$CategoryID			= $ss[0]['CategoryID'];
					$ss			= "delete from ebay_storecategory where CategoryID ='$CategoryID' and ebay_user='$user' and ebay_account='$ebay_account'";
					$dbcon->execute($ss);
				}
				
				$ss				= "insert into ebay_storecategory(CategoryID,Orders,Name,ebay_account,ebay_user) values('$CategoryID','$Order','$Name','$ebay_account','$user')";
				$dbcon->execute($ss);
				
			}
			
			
			 }
			 return $status;
		}
		
		
		
		function liststatus($id){
			

			global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$dbcon;
			
			$ss					= "select * from ebay_list where id='$id'";
			$ss					= $dbcon->execute($ss);
			$ss					= $dbcon->getResultArray($ss);
			$ebay_account		= $ss[0]['ebay_account'];	
			$token				= geteBayaccountToken($ebay_account);
			$ItemID				= $ss[0]['ItemID'];	
			
			$verb = 'GetItem';		



		

		$requestXmlBody	= '<?xml version="1.0" encoding="utf-8"?>

		<GetItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
		<IncludeItemSpecifics>true</IncludeItemSpecifics>
		<RequesterCredentials>
		<eBayAuthToken>'.$token.'</eBayAuthToken>
		</RequesterCredentials>
		<ItemID>'.$ItemID.'</ItemID>
		<DetailLevel>ReturnAll</DetailLevel>		 
		</GetItemRequest>';
		$compatabilityLevel	= '739';

		$session = new eBaySession($token, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);   

		$responseXml = $session->sendHttpRequest($requestXmlBody);

		$responseDoc = new DomDocument();	

		$responseDoc->loadXML($responseXml);   

		$errors = $responseDoc->getElementsByTagName('Errors');	

		$data	= XML_unserialize($responseXml);
		


		$ListingStatus		= $data['GetItemResponse']['Item']['SellingStatus']['ListingStatus'];
		
		if($ListingStatus != 'Active'){
				
				$id	 = $ss[0]['id'];
				$ss	 = "update ebay_list set status='1' where id='$id'";
				$dbcon->execute($ss);
				echo "<br>Item number: 状态更新成功";
				
		}
		
	
			
		}
		
		
		
		
		function EndItem($ebay_account,$itemid,$id){
			
			
			 $verb = 'EndItem';
			 /* 取token */
			 $token		= geteBayaccountToken($ebay_account);
			 global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$dbcon,$user;
			 
			 $compatabilityLevel = 739;
			 $xmlRequest		= '<?xml version="1.0" encoding="utf-8"?>
			<EndItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
 			<WarningLevel>High</WarningLevel>
  			<EndingReason>SellToHighBidder</EndingReason>
  			<RequesterCredentials>
    		<eBayAuthToken>'.$token.'</eBayAuthToken>
  			</RequesterCredentials>
  			<WarningLevel>High</WarningLevel>
  			<ItemID>'.$itemid.'</ItemID>
			</EndItemRequest>';
		
			 $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
			 $responseXml = $session->sendHttpRequest($xmlRequest);		
			 if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';
			 $data=XML_unserialize($responseXml);
	
			 $ack = $data['EndItemResponse']['Ack'];
			 $picurl = '';
			 if($ack == 'Failure'){
			 $status = '<br><font color="#FF0000">'.$data['EndItemResponse']['Errors']['LongMessage'].'</font>';
			 }else{
			 $status = '<br><font color="#00CC00">下架成功</font>';
			 $ss	 = "update ebay_list set status='1' where id='$id'";
			 $dbcon->execute($ss);
			 }
			 return $status;
		}
		
		function GetCategorySpecifics($ebay_account,$categoryid){
		
			 $verb = 'GetCategorySpecifics';
			 /* 取token */
			 $token		= geteBayaccountToken($ebay_account);
			 global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$dbcon,$user;
			 
			 $compatabilityLevel = 739;
			 $xmlRequest		= '<?xml version="1.0" encoding="utf-8"?>
			<GetCategorySpecificsRequest xmlns="urn:ebay:apis:eBLBaseComponents">
  <WarningLevel>High</WarningLevel>
  <CategorySpecific>
    <CategoryID>'.$categoryid.'</CategoryID>
  </CategorySpecific>
  <RequesterCredentials>
    <eBayAuthToken>'.$token.'</eBayAuthToken>
  </RequesterCredentials>
  <WarningLevel>High</WarningLevel>
</GetCategorySpecificsRequest>';
			 $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
			 $responseXml = $session->sendHttpRequest($xmlRequest);		
			 if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';
			 $data=XML_unserialize($responseXml);
			 
			 $ack = $data['GetCategorySpecificsResponse']['Ack'];
			 $picurl = '';
			 if($ack != 'Failure'){
			 $data = $data['GetCategorySpecificsResponse']['Recommendations']['NameRecommendation'];
			 
			
			for($i=0;$i<count($data);$i++){
			
				
				$name		= str_rep($data[$i]['Name']);
				$valueary	= $data[$i]['ValueRecommendation'];
				
				
				$ss			= "select * from ebay_attribute where ebay_user='$user' and ebay_account='$ebay_account' and categoryid='$categoryid' and name='$name' ";
				$ss			= $dbcon->execute($ss);
				$ss			= $dbcon->getResultArray($ss);
				if(count($ss) == 0){
				
					
				}else{
				
					$id		= $ss[0]['id'];
					$ss		= "delete from ebay_attribute where id='$id' ";
					$dbcon->execute($ss);
					
				}
				$ss		= "insert into ebay_attribute(name,categoryid,ebay_account,ebay_user) values('$name','$categoryid','$ebay_account','$user')";
				$dbcon->execute($ss);
					
				
				
				
				for($j=0;$j<count($valueary);$j++){
					
					$value		= $valueary[$j]['Value'];
					
					$ss			= "select * from ebay_attributevalue where ebay_user='$user' and ebay_account='$ebay_account' and categoryid='$categoryid' and name='$name' and value='$value' ";
					$ss			= $dbcon->execute($ss);
					$ss			= $dbcon->getResultArray($ss);
					if(count($ss) == 0){
					
					}else{
				
					$id		= $ss[0]['id'];
					$ss		= "delete from ebay_attributevalue where id='$id' ";
					$dbcon->execute($ss);
					
				
					}
					$ss		= "insert into ebay_attributevalue(name,value,categoryid,ebay_account,ebay_user) values('$name','$value','$categoryid','$ebay_account','$user')";
					$dbcon->execute($ss);
					
				}
					
			
			
			}
					 
			 //print_r($data);
			 
			 
			 }
			 
			 
			 

		}
		
		
		
		function GeteBayDetails($token,$code,$ebay_account,$ItemSite){
			
			
			$verb = 'GeteBayDetails';
			 global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$dbcon,$user;
			 $compatabilityLevel	= 601;
			 
			 
			 $ss	= "select * from  ebay_itemsite where site ='$ItemSite'";
			 
			 
			 
			 $ss	= $dbcon->execute($ss);
			 $ss	= $dbcon->getResultArray($ss);
			 $siteID	= $ss[0]['value'];
			
			if($ItemSite == 'eBayMotors'){
				
				
				$siteID	= '0';
				
				
			}
			 
			 
			 $xmlRequest		= '<?xml version="1.0" encoding="utf-8"?>
			 <GeteBayDetailsRequest xmlns="urn:ebay:apis:eBLBaseComponents">
  			<RequesterCredentials>
    		<eBayAuthToken>'.$token.'</eBayAuthToken>
 			</RequesterCredentials>
  			<WarningLevel>High</WarningLevel>
	
			</GeteBayDetailsRequest>';
			
			echo $xmlRequest;
			
			
			 $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
			 $responseXml = $session->sendHttpRequest($xmlRequest);		
			 if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';
			 $data=XML_unserialize($responseXml);

print_r($data);


			 $ack = $data['GeteBayDetailsResponse']['Ack'];
			 if($ack == 'Success'){
				 
				 
				 
			 }else{
				 
				 $ack = $data['GeteBayDetailsResponse']['Errors']['LongMessage'];
				 die('<font color="#FF0000">'.$ack.'</font>');
				 
				 
			 }
			 
			  $Trans = @$data['GeteBayDetailsResponse']['CountryDetails'];
			 
			 $ss		= "delete from ebay_itemcountry ";
			 $dbcon->execute($ss);
			 
			 foreach((array)$Trans as $Transaction){
			 
			 		 $Country			= $Transaction['Country'];
					 $Description		= $Transaction['Description'];
					 
					 $ss				= "insert into ebay_itemcountry(countrycode) values('$Country') ";
					 
					 $dbcon->execute($ss);
					 
					 
					 
					 
			}

			
					 
			 /* 取得国家代码 */
			 $Trans = @$data['GeteBayDetailsResponse']['ShippingLocationDetails'];
			 
			 $ss		= "delete from ebay_country where ebay_account='$ebay_account'";
			 $dbcon->execute($ss);
			 
			 foreach((array)$Trans as $Transaction){
			 
			 		 $Country			= $Transaction['ShippingLocation'];
					 $Description		= $Transaction['Description'];
				
			 		$ss		= "insert into ebay_country(Country,Description,ebay_account) values('$Country','$Description','$ebay_account')";
					$dbcon->execute($ss);
					
					
			 
			 }

			 
			 
			 $Trans = @$data['GeteBayDetailsResponse']['ShippingServiceDetails'];
			 foreach((array)$Trans as $Transaction){
				 
				 $Description			= str_rep($Transaction['Description']);
				 $InternationalService	= $Transaction['InternationalService'];
				 $ShippingService		= $Transaction['ShippingService'];
				 $ShippingServiceID		= $Transaction['ShippingServiceID'];
				 $ShippingTimeMax		= $Transaction['ShippingTimeMax'];
				 $ShippingTimeMin		= $Transaction['ShippingTimeMin'];
				 $ss		=  "insert into ebay_shipping(Description,InternationalService,ShippingService,ShippingServiceID,ebay_user,ebay_account,ItemSite) values(";
				 $ss		.= "'$Description','$InternationalService','$ShippingService','$ShippingServiceID','$user','$ebay_account','$ItemSite')";
				 
				 $sql			= "select * from ebay_shipping where ebay_account='$ebay_account' and ebay_user='$user' and  ShippingServiceID='$ShippingServiceID' and ItemSite='$ItemSite'";

				 
				 $sql			= $dbcon->execute($sql);
				 $sql			= $dbcon->getResultArray($sql);
				 if(count($sql) >0){
					 
					
					$id			= $sql[0]['id'];
					$sql		= "delete from ebay_shipping where id='$id'";
					 
					 
				 }
				 
				
				  $dbcon->execute($ss);
				 
				 
			 }
			 
			 echo '更新成功';
			 
		
		
		}
		
		
		function UploadSiteHostedPictures($imagename,$token){
		
			
			 $verb = 'UploadSiteHostedPictures';
			 global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$dbcon,$user;
			 $xmlRequest		= '<?xml version="1.0" encoding="utf-8"?>
			 <UploadSiteHostedPicturesRequest xmlns="urn:ebay:apis:eBLBaseComponents">
  			 <WarningLevel>High</WarningLevel>
  			 <ExternalPictureURL>'.$imagename.'</ExternalPictureURL>
  			 <PictureName>HarryPotterPic-1</PictureName>
  			 <RequesterCredentials>
    		 <eBayAuthToken>'.$token.'</eBayAuthToken>
  			 </RequesterCredentials>
  			 <WarningLevel>High</WarningLevel>
			 </UploadSiteHostedPicturesRequest>';
			 $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
			 $responseXml = $session->sendHttpRequest($xmlRequest);		
			 if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';
			 $data=XML_unserialize($responseXml);
			 
			// print_r($data);
			 
			 $ack = $data['UploadSiteHostedPicturesResponse']['Ack'];
			 $picurl = '';
			 if($ack != 'Failure'){
			 $picurl = $data['UploadSiteHostedPicturesResponse']['SiteHostedPictureDetails']['FullURL'];
			 }
			 return $picurl;
			 
		}
		
		function GetCategories($ebay_account,$SiteID){
			
			
			 $verb = 'GetCategories';
			 global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$dbcon,$user;
			 
			 /* 取token */
			 $token		= geteBayaccountToken($ebay_account);
		
			 $ss		= "select * from ebay_itemsite where site='$SiteID'";
			 $ss		= $dbcon->execute($ss);
			 $ss		= $dbcon->getResultArray($ss);
			 $SiteID2	= $ss[0]['value'];
			 

			$xmlRequest		= '<?xml version="1.0" encoding="utf-8"?>
			<GetCategoriesRequest xmlns="urn:ebay:apis:eBLBaseComponents">
  			<WarningLevel>High</WarningLevel>
 			<CategorySiteID>'.$SiteID2.'</CategorySiteID>
  			<DetailLevel>ReturnAll</DetailLevel>
  			<RequesterCredentials>
    		<eBayAuthToken>'.$token.'</eBayAuthToken>
  			</RequesterCredentials>
  			<WarningLevel>High</WarningLevel>
			</GetCategoriesRequest>';
			
			

			 $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
			 $responseXml = $session->sendHttpRequest($xmlRequest);		
			 if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';
			 $data=XML_unserialize($responseXml); 
			 $Trans = @$data['GetCategoriesResponse']['CategoryArray']['Category'];
			 $status		= 1;
			foreach((array)$Trans as $Transaction){
			
					$BestOfferEnabled		= $Transaction['BestOfferEnabled'];
					$CategoryID				= $Transaction['CategoryID'];
					$CategoryLevel			= $Transaction['CategoryLevel'];
					$CategoryName			= $Transaction['CategoryName'];
					$CategoryParentID		= $Transaction['CategoryParentID'];
					$LSD					= $Transaction['LSD'];
					$SellerGuaranteeEligible= $Transaction['SellerGuaranteeEligible'];
					$LeafCategory			= $Transaction['LeafCategory'];
					$AutoPayEnabled			= $Transaction['AutoPayEnabled'];
					$Virtual				= $Transaction['Virtual'];
					
					
					
					$sa		= "select * from ebay_category where SiteID='$SiteID' and CategoryID='$CategoryID'";
					$sa		= $dbcon->execute($sa);
					$sa		= $dbcon->getResultArray($sa);
					if(count($sa) == 0){
						
						$ss		= "insert into ebay_category(BestOfferEnabled,CategoryID,CategoryLevel,CategoryName,CategoryParentID,LSD,SellerGuaranteeEligible,LeafCategory,AutoPayEnabled,Virtual,SiteID) values('$BestOfferEnabled','$CategoryID','$CategoryLevel','$CategoryName','$CategoryParentID','$LSD','$SellerGuaranteeEligible','$LeafCategory','$AutoPayEnabled','$Virtual','$SiteID') ";				
						
						
					}else{
						
						$ss		= "delete from ebay_category where SiteID='$SiteID' and CategoryID='$CategoryID'";
						$dbcon->execute($ss);
						$ss		= "insert into ebay_category(BestOfferEnabled,CategoryID,CategoryLevel,CategoryName,CategoryParentID,LSD,SellerGuaranteeEligible,LeafCategory,AutoPayEnabled,Virtual,SiteID) values('$BestOfferEnabled','$CategoryID','$CategoryLevel','$CategoryName','$CategoryParentID','$LSD','$SellerGuaranteeEligible','$LeafCategory','$AutoPayEnabled','$Virtual','$SiteID') ";				
					}
		
					
					
					$dbcon->execute($ss);
					
					
					
			
			}
			
			
		
		
		
		
		}
		
		function geteBayaccountToken($account){
		
		
			global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$dbcon,$user;
			$ss		= "select * from ebay_account where ebay_account='$account' and ebay_user ='$user' ";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			return $ss[0]['ebay_token'];
			
		
		
		}
		
		

	
		
		
			function ReviseFixedPriceItem($id){
			
			
			$verb = 'ReviseFixedPriceItem';
			global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$dbcon;
			
			
			$ss			= "select * from ebay_list where id='$id'";
			$ss			= $dbcon->execute($ss);
			$ss			= $dbcon->getResultArray($ss);
			
			$PayPalEmailAddress	= $ss[0]['PayPalEmailAddress'];

			$Title				= $ss[0]['Title'];
			$SKU				= $ss[0]['SKU'];
			$ItemID				= $ss[0]['ItemID'];
			$ListingType		= $ss[0]['ListingType'];
			$ListingDuration	= $ss[0]['ListingDuration'];
			$Description		= $ss[0]['Description'];
			$ebay_account		= $ss[0]['ebay_account'];
			$StartPrice			= $ss[0]['StartPrice'];
			$ReservePrice		= $ss[0]['ReservePrice'];
			$Quantity			= $ss[0]['Quantity'];
			$condition			= $ss[0]['ConditionID'];
			$Country			= $ss[0]['Country'];
			$BuyItNowPrice		= $ss[0]['BuyItNowPrice'];
			$CategoryID			= $ss[0]['CategoryID'];

			$StoreCategoryID	= $ss[0]['StoreCategoryID'];
			
			if($StoreCategoryID != ''){
				$StoreCategory	= '<Storefront><StoreCategoryID>'.$StoreCategoryID.'</StoreCategoryID></Storefront>';
			}
			$Location			= $ss[0]['Location'];
			$DispatchTimeMax							= $ss[0]['DispatchTimeMax']?$ss[0]['DispatchTimeMax']:1;
			$img001										= $ss[0]['PictureURL01'];
			$img002										= $ss[0]['PictureURL02'];
			$img003										= $ss[0]['PictureURL03'];
			$img004										= $ss[0]['PictureURL04'];
			$ebay_listingreturnmethodid					= $ss[0]['ebay_listingreturnmethodid'];
			$ebay_shippingtempate						= $ss[0]['ebay_listingshippingmethodid'];

			
			$ss		= "select * from ebay_listingreturnmethod where id='$ebay_listingreturnmethodid' ";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			
			$ReturnsAcceptedOption				= $ss[0]['ReturnsAcceptedOption'];
			$RefundOption						= $ss[0]['RefundOption'];
			$ReturnsWithinOption				= $ss[0]['ReturnsWithinOption'];
			$ShippingCostPaidByOption			= $ss[0]['ShippingCostPaidByOption'];
			$TDescription						= $ss[0]['Description'];
		
			
			
			$token				= geteBayaccountToken($ebay_account);
			
			
				/* 取得运费模板 */
			 $ss		= "select * from ebay_shippingtemplate where id='$ebay_shippingtempate' ";
			 $ss		= $dbcon->execute($ss);
			 $ss		= $dbcon->getResultArray($ss);
			 
			 $service0					= $ss[0]['service0'];
			 $serviceshippingfee		= $ss[0]['serviceshippingfee'];
			 $serviceshippingfeecost	= $ss[0]['serviceshippingfeecost'];
			 if($service0 !='' && $serviceshippingfee !='' && $serviceshippingfeecost !=''){
				
			 	$tstr		= '  <ShippingServiceOptions>
       			 <ShippingServicePriority>1</ShippingServicePriority>
        		<ShippingService>'.$service0.'</ShippingService>
       <ShippingServiceCost>'.$serviceshippingfeecost.'</ShippingServiceCost>
	   <ShippingServiceAdditionalCost>'.$serviceshippingfeecost.'</ShippingServiceAdditionalCost>
      </ShippingServiceOptions>';
	  
			 
			 }
			 
			 $service1					= $ss[0]['service1'];
			 $service1shippingfee		= $ss[0]['service1shippingfee'];
			 $service1shippingfeecost	= $ss[0]['service1shippingfeecost'];
			 if($service1 !='' && $service1shippingfee !='' && $service1shippingfeecost !=''){
			
			 	$tstr		.= '  <ShippingServiceOptions>
        <ShippingServicePriority>2</ShippingServicePriority>
        <ShippingService>'.$service1.'</ShippingService>
       <ShippingServiceCost>'.$service1shippingfee.'</ShippingServiceCost>
	   <ShippingServiceAdditionalCost>'.$service1shippingfeecost.'</ShippingServiceAdditionalCost>
      </ShippingServiceOptions>';
	  
			 
			 }
			 
			 $service2					= $ss[0]['service2'];
			 $service2shippingfee		= $ss[0]['service2shippingfee'];
			 $service2shippingfeecost	= $ss[0]['service2shippingfeecost'];
			 if($service2 !='' && $service2shippingfee !='' && $service2shippingfeecost !=''){
			
			 	$tstr		.= '  <ShippingServiceOptions>
        <ShippingServicePriority>3</ShippingServicePriority>
        <ShippingService>'.$service2.'</ShippingService>
       <ShippingServiceCost>'.$service2shippingfee.'</ShippingServiceCost>
	   <ShippingServiceAdditionalCost>'.$service2shippingfeecost.'</ShippingServiceAdditionalCost>
      </ShippingServiceOptions>';
	  
			 
			 }
			 
			 
			 $nservice0					= $ss[0]['nservice0'];
			 $nserviceshippingfee		= $ss[0]['nserviceshippingfee'];
			 $nserviceshippingfeecost	= $ss[0]['nserviceshippingfeecost'];
			 $d0						= $ss[0]['d0'];
			 $d1						= $ss[0]['d1'];
			 $d2						= $ss[0]['d2'];
			 $d3						= $ss[0]['d3'];
			 if($nservice0 !='' && $nserviceshippingfee !='' && $nserviceshippingfeecost !=''){
				
				
				$tline					= '';
				if($d0 != '') $tline	.= '<ShipToLocation>'.$d0.'</ShipToLocation>';
				if($d1 != '') $tline	.= '<ShipToLocation>'.$d1.'</ShipToLocation>';
				if($d2 != '') $tline	.= '<ShipToLocation>'.$d2.'</ShipToLocation>';
				if($d3 != '') $tline	.= '<ShipToLocation>'.$d3.'</ShipToLocation>';
				
			 	$ntstr		.= '<InternationalShippingServiceOption>
        <ShippingService>'.$nservice0.'</ShippingService>
        <ShippingServiceAdditionalCost>'.$nserviceshippingfeecost.'</ShippingServiceAdditionalCost>
        <ShippingServiceCost>'.$nserviceshippingfee.'</ShippingServiceCost>
        <ShippingServicePriority>1</ShippingServicePriority>
        '.$tline.'
      </InternationalShippingServiceOption>
    ';
	  
			 
			 }
			 
			 
			 $nservice1					= $ss[0]['nservice1'];
			 $nservices1hippingfee		= $ss[0]['nservices1hippingfee'];
			 $nservices1hippingfeecost	= $ss[0]['nservices1hippingfeecost'];
			 $dd0						= $ss[0]['dd0'];
			 $dd1						= $ss[0]['dd1'];
			 $dd2						= $ss[0]['dd2'];
			 $dd3						= $ss[0]['dd3'];
			 if($nservice1 !='' && $nservices1hippingfee !='' && $nservices1hippingfeecost !=''){
				
				
				$tline					= '';
				if($dd0 != '') $tline	.= '<ShipToLocation>'.$dd0.'</ShipToLocation>';
				if($dd1 != '') $tline	.= '<ShipToLocation>'.$dd1.'</ShipToLocation>';
				if($dd2 != '') $tline	.= '<ShipToLocation>'.$dd2.'</ShipToLocation>';
				if($dd3 != '') $tline	.= '<ShipToLocation>'.$dd3.'</ShipToLocation>';
				
			 	$ntstr		.= '<InternationalShippingServiceOption>
        <ShippingService>'.$nservice1.'</ShippingService>
        <ShippingServiceAdditionalCost>'.$nservices1hippingfeecost.'</ShippingServiceAdditionalCost>
        <ShippingServiceCost>'.$nservices1hippingfee.'</ShippingServiceCost>
        <ShippingServicePriority>1</ShippingServicePriority>
        '.$tline.'
      </InternationalShippingServiceOption>
    ';
	  
			 
			 }
			 
			 
			 $nservice2					= $ss[0]['nservice2'];
			 $nservice2shippingfee		= $ss[0]['nservice2shippingfee'];
			 $nservices2hippingfeecost	= $ss[0]['nservices2hippingfeecost'];
			 $ddd0						= $ss[0]['ddd0'];
			 $ddd1						= $ss[0]['ddd1'];
			 $ddd2						= $ss[0]['ddd2'];
			 $ddd3						= $ss[0]['ddd3'];
			 if($nservice2 !='' && $nservice2shippingfee !='' && $nservices2hippingfeecost !=''){
				
				
				$tline					= '';
				if($ddd0 != '') $tline	.= '<ShipToLocation>'.$ddd0.'</ShipToLocation>';
				if($ddd1 != '') $tline	.= '<ShipToLocation>'.$ddd1.'</ShipToLocation>';
				if($ddd2 != '') $tline	.= '<ShipToLocation>'.$ddd2.'</ShipToLocation>';
				if($ddd3 != '') $tline	.= '<ShipToLocation>'.$ddd3.'</ShipToLocation>';
				
			 	$ntstr		.= '<InternationalShippingServiceOption>
        <ShippingService>'.$nservice2.'</ShippingService>
        <ShippingServiceAdditionalCost>'.$nservices2hippingfeecost.'</ShippingServiceAdditionalCost>
        <ShippingServiceCost>'.$nservice2shippingfee.'</ShippingServiceCost>
        <ShippingServicePriority>1</ShippingServicePriority>
        '.$tline.'
      </InternationalShippingServiceOption>
    ';
	  
			 
			 }
			 
			
			 $l01						= $ss[0]['l01'];
			 $l02						= $ss[0]['l02'];
			 $l03						= $ss[0]['l03'];
			 $l04						= $ss[0]['l04'];
			 $l05						= $ss[0]['l05'];
			 $l06						= $ss[0]['l06'];
			 $l07						= $ss[0]['l07'];
			 $l08						= $ss[0]['l08'];
			 $l09						= $ss[0]['l09'];
			 $l10						= $ss[0]['l10'];
			 $lstr						= '';
			 
			 if($l01 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l01.'</ExcludeShipToLocation>';
			 if($l02 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l02.'</ExcludeShipToLocation>';
			 if($l03 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l03.'</ExcludeShipToLocation>';
			 if($l04 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l04.'</ExcludeShipToLocation>';
			 if($l05 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l05.'</ExcludeShipToLocation>';
			 if($l06 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l06.'</ExcludeShipToLocation>';
			 if($l07 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l07.'</ExcludeShipToLocation>';
			 if($l08 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l08.'</ExcludeShipToLocation>';
			 if($l09 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l09.'</ExcludeShipToLocation>';
			 if($l10 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l10.'</ExcludeShipToLocation>';
			 
			 /* 检查多属性产品 */
			$ss		= "select * from ebay_listvarious where sid='$id' ";
			
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			
			$name0	= $ss[0]['name0'];
			$name1	= $ss[0]['name1'];
			$name2	= $ss[0]['name2'];
			$name3	= $ss[0]['name3'];
			$name4	= $ss[0]['name4'];
			$pid	= $ss[0]['id'];
			$name0arry = array();
			$name1arry = array();
			$name2arry = array();
			$name3arry = array();
			$name4arry = array();
			
			
			/* 检查多属性产品的值 */
			
			$ss		= "select value0 from ebay_listvariousdetails where pid='$pid' group by value0";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			for($i=0;$i<count($ss);$i++){
				$name0arry[$i] = $ss[$i]['value0'];
			}
			
			$ss		= "select value1 from ebay_listvariousdetails where pid='$pid' group by value1";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			for($i=0;$i<count($ss);$i++){
				$name1arry[$i] = $ss[$i]['value1'];
			}
			
			$ss		= "select value2 from ebay_listvariousdetails where pid='$pid' group by value2";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			
			for($i=0;$i<count($ss);$i++){
				$name2arry[$i] = $ss[$i]['value2'];
			}
			
			$ss		= "select value3 from ebay_listvariousdetails where pid='$pid' group by value3";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			for($i=0;$i<count($ss);$i++){
				$name3arry[$i] = $ss[$i]['value3'];
			}
			
			$ss		= "select value0 from ebay_listvariousdetails where pid='$pid' group by value4";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			for($i=0;$i<count($ss);$i++){
				$name4arry[$i] = $ss[$i]['value4'];
			}
			
			

			
			$tvarname	= '';
			if($name0 != '' && count($name0arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name0arry);$i++){
					$tvarvalue	.= '<Value>'.$name0arry[$i].'</Value>';
				}
				$tvarname	= '<NameValueList><Name>'.$name0.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			
			if($name1 != '' && count($name1arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name1arry);$i++){
					$tvarvalue	.= '<Value>'.$name1arry[$i].'</Value>';
				}
				$tvarname	.= '<NameValueList><Name>'.$name1.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			
			if($name2 != '' && count($name2arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name2arry);$i++){
					$tvarvalue	.= '<Value>'.$name2arry[$i].'</Value>';
				}
				$tvarname	.= '<NameValueList><Name>'.$name2.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			
			if($name3 != '' && count($name3arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name3arry);$i++){
					$tvarvalue	.= '<Value>'.$name3arry[$i].'</Value>';
				}
				$tvarname	.= '<NameValueList><Name>'.$name3.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			
			if($name4 != '' && count($name4arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name4arry);$i++){
					$tvarvalue	.= '<Value>'.$name4arry[$i].'</Value>';
				}
				$tvarname	.= '<NameValueList><Name>'.$name4.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			$tvarname		= fstr_rep($tvarname);
			
			
			$ss		= "select * from ebay_listvariousdetails where pid='$pid' ";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			$varline	= '';
			$varpic		= '';
			
			
			for($i=0;$i<count($ss);$i++){
				
				$sku		= $ss[$i]['sku'];
				$value0		= $ss[$i]['value0'];
				$value1		= $ss[$i]['value1'];
				$value2		= $ss[$i]['value2'];
				$value3		= $ss[$i]['value3'];
				$value4		= $ss[$i]['value4'];
				$price		= $ss[$i]['price'];
				$picture	= $ss[$i]['picture'];
				$qty		= $ss[$i]['qty'];
			
				
				
				$tvar0		= " <Variation>
        		<SKU>".$sku."</SKU>
        		<StartPrice>".$price."</StartPrice>
        		<Quantity>".$qty."</Quantity>
				<VariationSpecifics>
				";
				
				$var1		= '';
				if($name0 != '' && $value0 != ''){
				
				$name0		 = fstr_rep($name0);
				$var1		.= "<NameValueList><Name>".$name0."</Name><Value>".$value0."</Value></NameValueList>";
				
				if($picture != ''){
				$varpic		 .= " 
        						 <VariationSpecificPictureSet>
          						 <VariationSpecificValue>".$value0."</VariationSpecificValue>
          						 <PictureURL>".$picture."</PictureURL>
        						 </VariationSpecificPictureSet>";
				}
				
				}
				
				if($name1 != '' && $value1 != ''){
				$name1		 = fstr_rep($name1);
				$var1		.= "<NameValueList><Name>".$name1."</Name><Value>".$value1."</Value></NameValueList>";
				}
				if($name2 != '' && $value2 != ''){
				$name2		 = fstr_rep($name2);
				$var1		.= "<NameValueList><Name>".$name2."</Name><Value>".$value2."</Value></NameValueList>";
				}
				
				if($name3 != '' && $value3 != ''){
				$name3		 = fstr_rep($name3);
				$var1		.= "<NameValueList><Name>".$name3."</Name><Value>".$value3."</Value></NameValueList>";
				}
				
				if($name4 != '' && $value4 != ''){
				$name4		 = fstr_rep($name4);
				$var1		.= "<NameValueList><Name>".$name4."</Name><Value>".$value4."</Value></NameValueList>";
				}
				
				
				$varline	.= $tvar0.$var1.'</VariationSpecifics></Variation>';
				
        		
        		
				
			}
			
			
			$varpic		= '<Pictures>'."<VariationSpecificName>".$name0."</VariationSpecificName>".$varpic.'</Pictures>';
			
			if($tvarname != ''){
				$variations				= "
			  <Variations>
      <VariationSpecificsSet>
    ".$tvarname."
      </VariationSpecificsSet>
    ".$varline.$varpic."
     
    </Variations>
			";
			}

			 $namevaluelist		= '';
			 $ss				= "select * from ebay_itemspecifics where sid ='$id'";
			 $ss				= $dbcon->execute($ss);
			 $ss				= $dbcon->getResultArray($ss);
			 
			for($i=0;$i<count($ss);$i++){
			 
				
				$keys			=$ss[$i]['name'];
				$value			= fstr_rep($ss[$i]['value']);
				/* 检查此keys是否存在于多属性当中 */
				
				$yy		= "select * from ebay_listvarious where name0='$keys' or name1='$keys' or name2='$keys' or name3='$keys' or name4='$keys' ";
			

				$yy				= $dbcon->execute($yy);
				$yy				= $dbcon->getResultArray($yy);
				$keys			= fstr_rep($ss[$i]['name']);
				if(count($yy) ==0 ){
				$namevaluelist		.= '<NameValueList>
			 	<Name>'.$keys.'</Name>
			 	<Value>'.$value.'</Value>
      			 </NameValueList>';
				}
				
				
			 } 
			 
			 

			 $itemspecific			= '<ItemSpecifics>'.$namevaluelist.'</ItemSpecifics>';

			
			$xmlRequest		= '<?xml version="1.0" encoding="utf-8"?>
			<ReviseFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
			<ErrorLanguage>en_US</ErrorLanguage>
  			<WarningLevel>High</WarningLevel>
  			<Item>
			'.$StoreCategory.'
    		<ItemID>'.$ItemID.'</ItemID>
    		<SKU>'.$SKU.'</SKU>
			<Title>'.$Title.'</Title>
   			<Description><![CDATA['.$Description.']]></Description>    		
		    <PrimaryCategory><CategoryID>'.$CategoryID.'</CategoryID></PrimaryCategory>
    		<StartPrice>'.$StartPrice.'</StartPrice>';
			if($ReservePrice != '') 		$xmlRequest .= '<ReservePrice currencyID="USD">'.$ReservePrice.'</ReservePrice>';
			if($ListingType == 'Chinese') 	$xmlRequest .= '<BuyItNowPrice currencyID="USD">'.$BuyItNowPrice.'</BuyItNowPrice> ';
			if($Quantity > 0) 				$xmlRequest .= '<Quantity>'.$Quantity.'</Quantity>';
			
			$xmlRequest	.= '			
    		<ConditionID>'.$condition.'</ConditionID>
   			<CategoryMappingAllowed>true</CategoryMappingAllowed>
    		<Country>'.$Country.'</Country>'.$itemspecific.$variations.'
    		<Currency>USD</Currency>
			<Location>'.$Location.'</Location>
    		<DispatchTimeMax>'.$DispatchTimeMax.'</DispatchTimeMax>
    		<ListingDuration>'.$ListingDuration.'</ListingDuration>
   			<ListingType>'.$ListingType.'</ListingType>
    		<PaymentMethods>PayPal</PaymentMethods>
   			<PayPalEmailAddress>'.$PayPalEmailAddress.'</PayPalEmailAddress>
	 		<PictureDetails>
	  		<GalleryType>Gallery</GalleryType>';
	  
	  
	  		if($img001 != '') $xmlRequest .= '<PictureURL>'.$img001.'</PictureURL>';
	 		if($img002 != '') $xmlRequest .= '<PictureURL>'.$img002.'</PictureURL>';
	 		if($img003 != '') $xmlRequest .= '<PictureURL>'.$img003.'</PictureURL>';
	 		if($img004 != '') $xmlRequest .= '<PictureURL>'.$img004.'</PictureURL>';
	  
	  		$xmlRequest .='
    		</PictureDetails>
    		<PostalCode>95125</PostalCode>
    		<ReturnPolicy>
      		<ReturnsAcceptedOption>'.$ReturnsAcceptedOption.'</ReturnsAcceptedOption>
      		<RefundOption>'.$RefundOption.'</RefundOption>
      		<ReturnsWithinOption>'.$ReturnsWithinOption.'</ReturnsWithinOption>
      		<Description>'.$TDescription.'</Description>
      		<ShippingCostPaidByOption>'.$ShippingCostPaidByOption.'</ShippingCostPaidByOption>
    		</ReturnPolicy>
	
   			<ShippingDetails>
      		<ShippingType>Flat</ShippingType>
    		'.$tstr.$ntstr.$lstr.'
   			 </ShippingDetails>
  			</Item>
  			<RequesterCredentials>
   			<eBayAuthToken>'.$token.'</eBayAuthToken>
  			</RequesterCredentials>
  			<WarningLevel>High</WarningLevel>
			</ReviseFixedPriceItemRequest>

			';

			
			 $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);

			 $responseXml = $session->sendHttpRequest($xmlRequest);		


			 if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';

			 $data=XML_unserialize($responseXml); 

			 
			 $ack		= $data['ReviseFixedPriceItemResponse']['Ack'];
			 
			 if($ack != 'Failure'){
				 
				 $LongMessage		= $data['ReviseFixedPriceItemResponse']['Errors'];
				 if(is_array($LongMessage)){
					for($i=0;$i<count($LongMessage);$i++){
						echo '<br><font color="#FF0000">'.$data['ReviseFixedPriceItemResponse']['Errors'][$i]['LongMessage'].'</font>';
					}
					 
				 }else{
					 echo '<br><font color="#FF0000">'.$LongMessage.'</font>';
				 }
				 $ItemID			= $data['ReviseFixedPriceItemResponse']['ItemID'];
				 echo '<br>Item Number: '.$ItemID.' 提交修改到eBay 成功';
				 
			 }else{
				 
					
					 $LongMessage		= $data['ReviseFixedPriceItemResponse']['Errors'];
				 if($data['ReviseFixedPriceItemResponse']['Errors']['LongMessage'] == ''){
					for($i=0;$i<count($LongMessage);$i++){
						echo '<br><font color="#FF0000">'.$data['ReviseFixedPriceItemResponse']['Errors'][$i]['LongMessage'].'</font>';
					}
					 
				 }else{
					 echo '<br><font color="#FF0000">'.$data['ReviseFixedPriceItemResponse']['Errors']['LongMessage'].'</font>';
				 }
				 
				 
				 
			 }
			 
			 
		
		
		
		
		
		}
		
		
		
		/* */
		function ReviseItem($id){
			
			
			$verb = 'ReviseItem';
			global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$dbcon;
			
			
			$ss			= "select * from ebay_list where id='$id'";
			$ss			= $dbcon->execute($ss);
			$ss			= $dbcon->getResultArray($ss);
			$PayPalEmailAddress	= $ss[0]['PayPalEmailAddress'];
			$Title				= $ss[0]['Title'];
			$SKU				= $ss[0]['SKU'];
			$ItemID				= $ss[0]['ItemID'];
			$ListingType		= $ss[0]['ListingType'];
			$ListingDuration	= $ss[0]['ListingDuration'];
			$Description		= $ss[0]['Description'];
			$ebay_account		= $ss[0]['ebay_account'];
			$StartPrice			= $ss[0]['StartPrice'];
			$ReservePrice		= $ss[0]['ReservePrice'];
			$Quantity			= $ss[0]['Quantity'];
			$condition			= $ss[0]['ConditionID'];
			$Country			= $ss[0]['Country'];
			$BuyItNowPrice		= $ss[0]['BuyItNowPrice'];
			$CategoryID			= $ss[0]['CategoryID'];
			$StoreCategoryID	= $ss[0]['StoreCategoryID'];
			
			if($StoreCategoryID != ''){
				$StoreCategory	= '<Storefront><StoreCategoryID>'.$StoreCategoryID.'</StoreCategoryID></Storefront>';
			}
			
			
			$Location			= $ss[0]['Location'];
			$DispatchTimeMax							= $ss[0]['DispatchTimeMax']?$ss[0]['DispatchTimeMax']:1;
			$img001										= $ss[0]['PictureURL01'];
			$img002										= $ss[0]['PictureURL02'];
			$img003										= $ss[0]['PictureURL03'];
			$img004										= $ss[0]['PictureURL04'];
			$ebay_listingreturnmethodid					= $ss[0]['ebay_listingreturnmethodid'];
			$ebay_shippingtempate						= $ss[0]['ebay_listingshippingmethodid'];

			
			$ss		= "select * from ebay_listingreturnmethod where id='$ebay_listingreturnmethodid' ";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			
			$ReturnsAcceptedOption				= $ss[0]['ReturnsAcceptedOption'];
			$RefundOption						= $ss[0]['RefundOption'];
			$ReturnsWithinOption				= $ss[0]['ReturnsWithinOption'];
			$ShippingCostPaidByOption			= $ss[0]['ShippingCostPaidByOption'];
			$TDescription						= $ss[0]['Description'];
		
			
			
			$token				= geteBayaccountToken($ebay_account);
			
			
				/* 取得运费模板 */
			 $ss		= "select * from ebay_shippingtemplate where id='$ebay_shippingtempate' ";
			 $ss		= $dbcon->execute($ss);
			 $ss		= $dbcon->getResultArray($ss);
			 
			 $service0					= $ss[0]['service0'];
			 $serviceshippingfee		= $ss[0]['serviceshippingfee'];
			 $serviceshippingfeecost	= $ss[0]['serviceshippingfeecost'];
			 if($service0 !='' && $serviceshippingfee !='' && $serviceshippingfeecost !=''){
				
			 	$tstr		= '  <ShippingServiceOptions>
       			 <ShippingServicePriority>1</ShippingServicePriority>
        		<ShippingService>'.$service0.'</ShippingService>
       <ShippingServiceCost>'.$serviceshippingfeecost.'</ShippingServiceCost>
	   <ShippingServiceAdditionalCost>'.$serviceshippingfeecost.'</ShippingServiceAdditionalCost>
      </ShippingServiceOptions>';
	  
			 
			 }
			 
			 $service1					= $ss[0]['service1'];
			 $service1shippingfee		= $ss[0]['service1shippingfee'];
			 $service1shippingfeecost	= $ss[0]['service1shippingfeecost'];
			 if($service1 !='' && $service1shippingfee !='' && $service1shippingfeecost !=''){
			
			 	$tstr		.= '  <ShippingServiceOptions>
        <ShippingServicePriority>2</ShippingServicePriority>
        <ShippingService>'.$service1.'</ShippingService>
       <ShippingServiceCost>'.$service1shippingfee.'</ShippingServiceCost>
	   <ShippingServiceAdditionalCost>'.$service1shippingfeecost.'</ShippingServiceAdditionalCost>
      </ShippingServiceOptions>';
	  
			 
			 }
			 
			 $service2					= $ss[0]['service2'];
			 $service2shippingfee		= $ss[0]['service2shippingfee'];
			 $service2shippingfeecost	= $ss[0]['service2shippingfeecost'];
			 if($service2 !='' && $service2shippingfee !='' && $service2shippingfeecost !=''){
			
			 	$tstr		.= '  <ShippingServiceOptions>
        <ShippingServicePriority>3</ShippingServicePriority>
        <ShippingService>'.$service2.'</ShippingService>
       <ShippingServiceCost>'.$service2shippingfee.'</ShippingServiceCost>
	   <ShippingServiceAdditionalCost>'.$service2shippingfeecost.'</ShippingServiceAdditionalCost>
      </ShippingServiceOptions>';
	  
			 
			 }
			 
			 

			 $nservice0					= $ss[0]['nservice0'];
			 $nserviceshippingfee		= $ss[0]['nserviceshippingfee'];
			 $nserviceshippingfeecost	= $ss[0]['nserviceshippingfeecost'];
			 $d0						= $ss[0]['d0'];
			 $d1						= $ss[0]['d1'];
			 $d2						= $ss[0]['d2'];
			 $d3						= $ss[0]['d3'];
			 if($nservice0 !='' && $nserviceshippingfee !='' && $nserviceshippingfeecost !=''){
				
				
				$tline					= '';
				if($d0 != '') $tline	.= '<ShipToLocation>'.$d0.'</ShipToLocation>';
				if($d1 != '') $tline	.= '<ShipToLocation>'.$d1.'</ShipToLocation>';
				if($d2 != '') $tline	.= '<ShipToLocation>'.$d2.'</ShipToLocation>';
				if($d3 != '') $tline	.= '<ShipToLocation>'.$d3.'</ShipToLocation>';
				
			 	$ntstr		.= '<InternationalShippingServiceOption>
        <ShippingService>'.$nservice0.'</ShippingService>
        <ShippingServiceAdditionalCost>'.$nserviceshippingfeecost.'</ShippingServiceAdditionalCost>
        <ShippingServiceCost>'.$nserviceshippingfee.'</ShippingServiceCost>
        <ShippingServicePriority>1</ShippingServicePriority>
        '.$tline.'
      </InternationalShippingServiceOption>
    ';
	  
			 
			 }
			 
			 
			 $nservice1					= $ss[0]['nservice1'];
			 $nservices1hippingfee		= $ss[0]['nservices1hippingfee'];
			 $nservices1hippingfeecost	= $ss[0]['nservices1hippingfeecost'];
			 $dd0						= $ss[0]['dd0'];
			 $dd1						= $ss[0]['dd1'];
			 $dd2						= $ss[0]['dd2'];
			 $dd3						= $ss[0]['dd3'];
			 if($nservice1 !='' && $nservices1hippingfee !='' && $nservices1hippingfeecost !=''){
				
				
				$tline					= '';
				if($dd0 != '') $tline	.= '<ShipToLocation>'.$dd0.'</ShipToLocation>';
				if($dd1 != '') $tline	.= '<ShipToLocation>'.$dd1.'</ShipToLocation>';
				if($dd2 != '') $tline	.= '<ShipToLocation>'.$dd2.'</ShipToLocation>';
				if($dd3 != '') $tline	.= '<ShipToLocation>'.$dd3.'</ShipToLocation>';
				
			 	$ntstr		.= '<InternationalShippingServiceOption>
        <ShippingService>'.$nservice1.'</ShippingService>
        <ShippingServiceAdditionalCost>'.$nservices1hippingfeecost.'</ShippingServiceAdditionalCost>
        <ShippingServiceCost>'.$nservices1hippingfee.'</ShippingServiceCost>
        <ShippingServicePriority>1</ShippingServicePriority>
        '.$tline.'
      </InternationalShippingServiceOption>
    ';
	  
			 
			 }
			 
			 
			 $nservice2					= $ss[0]['nservice2'];
			 $nservice2shippingfee		= $ss[0]['nservice2shippingfee'];
			 $nservices2hippingfeecost	= $ss[0]['nservices2hippingfeecost'];
			 $ddd0						= $ss[0]['ddd0'];
			 $ddd1						= $ss[0]['ddd1'];
			 $ddd2						= $ss[0]['ddd2'];
			 $ddd3						= $ss[0]['ddd3'];
			 if($nservice2 !='' && $nservice2shippingfee !='' && $nservices2hippingfeecost !=''){
				
				
				$tline					= '';
				if($ddd0 != '') $tline	.= '<ShipToLocation>'.$ddd0.'</ShipToLocation>';
				if($ddd1 != '') $tline	.= '<ShipToLocation>'.$ddd1.'</ShipToLocation>';
				if($ddd2 != '') $tline	.= '<ShipToLocation>'.$ddd2.'</ShipToLocation>';
				if($ddd3 != '') $tline	.= '<ShipToLocation>'.$ddd3.'</ShipToLocation>';
				
			 	$ntstr		.= '<InternationalShippingServiceOption>
        <ShippingService>'.$nservice2.'</ShippingService>
        <ShippingServiceAdditionalCost>'.$nservices2hippingfeecost.'</ShippingServiceAdditionalCost>
        <ShippingServiceCost>'.$nservice2shippingfee.'</ShippingServiceCost>
        <ShippingServicePriority>1</ShippingServicePriority>
        '.$tline.'
      </InternationalShippingServiceOption>
    ';
	  
			 
			 }
			 
			
			 $l01						= $ss[0]['l01'];
			 $l02						= $ss[0]['l02'];
			 $l03						= $ss[0]['l03'];
			 $l04						= $ss[0]['l04'];
			 $l05						= $ss[0]['l05'];
			 $l06						= $ss[0]['l06'];
			 $l07						= $ss[0]['l07'];
			 $l08						= $ss[0]['l08'];
			 $l09						= $ss[0]['l09'];
			 $l10						= $ss[0]['l10'];
			 $lstr						= '';
			 
			 if($l01 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l01.'</ExcludeShipToLocation>';
			 if($l02 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l02.'</ExcludeShipToLocation>';
			 if($l03 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l03.'</ExcludeShipToLocation>';
			 if($l04 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l04.'</ExcludeShipToLocation>';
			 if($l05 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l05.'</ExcludeShipToLocation>';
			 if($l06 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l06.'</ExcludeShipToLocation>';
			 if($l07 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l07.'</ExcludeShipToLocation>';
			 if($l08 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l08.'</ExcludeShipToLocation>';
			 if($l09 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l09.'</ExcludeShipToLocation>';
			 if($l10 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l10.'</ExcludeShipToLocation>';
			 
			 /* 检查多属性产品 */
			$ss		= "select * from ebay_listvarious where sid='$id' ";
			
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			
			$name0	= $ss[0]['name0'];
			$name1	= $ss[0]['name1'];
			$name2	= $ss[0]['name2'];
			$name3	= $ss[0]['name3'];
			$name4	= $ss[0]['name4'];
			$pid	= $ss[0]['id'];
			$name0arry = array();
			$name1arry = array();
			$name2arry = array();
			$name3arry = array();
			$name4arry = array();
			
			
			/* 检查多属性产品的值 */
			
			$ss		= "select value0 from ebay_listvariousdetails where pid='$pid' group by value0";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			for($i=0;$i<count($ss);$i++){
				$name0arry[$i] = $ss[$i]['value0'];
			}
			
			$ss		= "select value1 from ebay_listvariousdetails where pid='$pid' group by value1";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			for($i=0;$i<count($ss);$i++){
				$name1arry[$i] = $ss[$i]['value1'];
			}
			
			$ss		= "select value2 from ebay_listvariousdetails where pid='$pid' group by value2";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			
			for($i=0;$i<count($ss);$i++){
				$name2arry[$i] = $ss[$i]['value2'];
			}
			
			$ss		= "select value3 from ebay_listvariousdetails where pid='$pid' group by value3";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			for($i=0;$i<count($ss);$i++){
				$name3arry[$i] = $ss[$i]['value3'];
			}
			
			$ss		= "select value0 from ebay_listvariousdetails where pid='$pid' group by value4";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			for($i=0;$i<count($ss);$i++){
				$name4arry[$i] = $ss[$i]['value4'];
			}
			
			

			
			$tvarname	= '';
			if($name0 != '' && count($name0arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name0arry);$i++){
					$tvarvalue	.= '<Value>'.$name0arry[$i].'</Value>';
				}
				$tvarname	= '<NameValueList><Name>'.$name0.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			
			if($name1 != '' && count($name1arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name1arry);$i++){
					$tvarvalue	.= '<Value>'.$name1arry[$i].'</Value>';
				}
				$tvarname	.= '<NameValueList><Name>'.$name1.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			
			if($name2 != '' && count($name2arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name2arry);$i++){
					$tvarvalue	.= '<Value>'.$name2arry[$i].'</Value>';
				}
				$tvarname	.= '<NameValueList><Name>'.$name2.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			
			if($name3 != '' && count($name3arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name3arry);$i++){
					$tvarvalue	.= '<Value>'.$name3arry[$i].'</Value>';
				}
				$tvarname	.= '<NameValueList><Name>'.$name3.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			
			if($name4 != '' && count($name4arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name4arry);$i++){
					$tvarvalue	.= '<Value>'.$name4arry[$i].'</Value>';
				}
				$tvarname	.= '<NameValueList><Name>'.$name4.'</Name>'.$tvarvalue.'</NameValueList>';
			}


			/* 开始检查下拉中的值 
				$variations				= "
			     <Variations>
      			<VariationSpecificsSet>
				 ".$tvarname."


	 </VariationSpecificsSet>
	  
	   <Variation>
        <SKU>sS0</SKU>
        <StartPrice>17.99</StartPrice>
        <Quantity>4</Quantity>
        <VariationSpecifics>
          <NameValueList>
            <Name>Color</Name>
            <Value>Pink</Value>
          </NameValueList>
          <NameValueList>
            <Name>Size</Name>
            <Value>S</Value>
          </NameValueList>
		
        </VariationSpecifics>
      </Variation>
	  
	  
	   <Variation>
        <SKU>sS1</SKU>
        <StartPrice>17.99</StartPrice>
        <Quantity>4</Quantity>
        <VariationSpecifics>
          <NameValueList>
            <Name>Color</Name>
            <Value>Pink</Value>
          </NameValueList>
          <NameValueList>
            <Name>Size</Name>
            <Value>M</Value>
          </NameValueList>
		
        </VariationSpecifics>
      </Variation>

	  

    </Variations>
			
			";
	
				
			$variationss				= "
			 <Variations>
     		 <VariationSpecificsSet>
       ".$tvarname."
	 </VariationSpecificsSet>
	  
	   <Variation>
        <SKU>RLauren_Wom_TShirt_Pnk_S</SKU>
        <StartPrice>17.99</StartPrice>
        <Quantity>4</Quantity>
        <VariationSpecifics>
          <NameValueList>
            <Name>Color</Name>
            <Value>Pink</Value>
          </NameValueList>
          <NameValueList>
            <Name>Size</Name>
            <Value>S</Value>
          </NameValueList>
        </VariationSpecifics>
      </Variation>
	  
	  
	  
	  <Variation>
        <SKU>RLaurendd_Wom_TShirt_Pnk_S</SKU>
        <StartPrice>15.99</StartPrice>
        <Quantity>4</Quantity>
        <VariationSpecifics>
          <NameValueList>
            <Name>Color</Name>
            <Value>Black</Value>
          </NameValueList>
          <NameValueList>
            <Name>Size</Name>
            <Value>M</Value>
          </NameValueList>
        </VariationSpecifics>
      </Variation>
	  
	  	  <Variation>
        <SKU>RLaurendd_Wom_TShirt_Pnk_S0</SKU>
        <StartPrice>15.99</StartPrice>
        <Quantity>4</Quantity>
        <VariationSpecifics>
          <NameValueList>
            <Name>Color</Name>
            <Value>Yellow</Value>
          </NameValueList>
          <NameValueList>
            <Name>Size</Name>
            <Value>M</Value>
          </NameValueList>
        </VariationSpecifics>
      </Variation>
	  
	
	  
	   <Pictures>
        <VariationSpecificName>Color</VariationSpecificName>
        <VariationSpecificPictureSet>
          <VariationSpecificValue>Yellow</VariationSpecificValue>
          <PictureURL>http://i12.ebayimg.com/03/i/04/8a/5f/a1_1_sbl.JPG</PictureURL>
          <PictureURL>http://i12.ebayimg.com/03/i/04/8a/5f/a1_1_sb2.JPG</PictureURL>
        </VariationSpecificPictureSet>

        <VariationSpecificPictureSet>
          <VariationSpecificValue>Black</VariationSpecificValue>
          <PictureURL>http://i4.ebayimg.ebay.com/01/i/000/77/3c/d88f_1_sbl.JPG</PictureURL>
        </VariationSpecificPictureSet>
      </Pictures>
	  
	  
    </Variations>
			
			";*/		
			$namevaluelist		= '';
			 $ss				= "select * from ebay_itemspecifics where sid ='$id'";
			 $ss				= $dbcon->execute($ss);
			 $ss				= $dbcon->getResultArray($ss);

			 
			for($i=0;$i<count($ss);$i++){
			 
				
				$keys			= fstr_rep($ss[$i]['name']);
				$value			= fstr_rep($ss[$i]['value']);
								
				$namevaluelist		.= '<NameValueList>
			 <Name>'.$keys.'</Name>
			 <Value>'.$value.'</Value>
      		 </NameValueList>';
				
				
			 } 
			 $itemspecific			= '<ItemSpecifics>'.$namevaluelist.'</ItemSpecifics>';
	
			
			$xmlRequest		= '<?xml version="1.0" encoding="utf-8"?>
			<ReviseItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
			<ErrorLanguage>en_US</ErrorLanguage>
  			<WarningLevel>High</WarningLevel>
  			<Item>
			'.$StoreCategory.'
    		<ItemID>'.$ItemID.'</ItemID>
    		<SKU>'.$SKU.'</SKU>
			<Title>'.$Title.'</Title>
   			<Description><![CDATA['.$Description.']]></Description>    		
		    <PrimaryCategory><CategoryID>'.$CategoryID.'</CategoryID></PrimaryCategory>
    		<StartPrice>'.$StartPrice.'</StartPrice>';
			if($ReservePrice != '') 		$xmlRequest .= '<ReservePrice currencyID="USD">'.$ReservePrice.'</ReservePrice>';
			if($ListingType == 'Chinese') 	$xmlRequest .= '<BuyItNowPrice currencyID="USD">'.$BuyItNowPrice.'</BuyItNowPrice> ';
			if($Quantity > 0) 				$xmlRequest .= '<Quantity>'.$Quantity.'</Quantity>';
			
			$xmlRequest	.= '			
    		<ConditionID>'.$condition.'</ConditionID>
   			<CategoryMappingAllowed>true</CategoryMappingAllowed>
    		<Country>'.$Country.'</Country>'.$itemspecific.$variations.'
    		<Currency>USD</Currency>
			<Location>'.$Location.'</Location>
    		<DispatchTimeMax>'.$DispatchTimeMax.'</DispatchTimeMax>
    		<ListingDuration>'.$ListingDuration.'</ListingDuration>
    		<PaymentMethods>PayPal</PaymentMethods>
   			<PayPalEmailAddress>'.$PayPalEmailAddress.'</PayPalEmailAddress>
	 		<PictureDetails>
	  		<GalleryType>Gallery</GalleryType>';
	  
	  
	  		if($img001 != '') $xmlRequest .= '<PictureURL>'.$img001.'</PictureURL>';
	 		if($img002 != '') $xmlRequest .= '<PictureURL>'.$img002.'</PictureURL>';
	 		if($img003 != '') $xmlRequest .= '<PictureURL>'.$img003.'</PictureURL>';
	 		if($img004 != '') $xmlRequest .= '<PictureURL>'.$img004.'</PictureURL>';
	  
	  		$xmlRequest .='
    		</PictureDetails>
    		<PostalCode>95125</PostalCode>
    		<ReturnPolicy>
      		<ReturnsAcceptedOption>'.$ReturnsAcceptedOption.'</ReturnsAcceptedOption>
      		<RefundOption>'.$RefundOption.'</RefundOption>
      		<ReturnsWithinOption>'.$ReturnsWithinOption.'</ReturnsWithinOption>
      		<Description>'.$TDescription.'</Description>
      		<ShippingCostPaidByOption>'.$ShippingCostPaidByOption.'</ShippingCostPaidByOption>
    		</ReturnPolicy>
	
   			<ShippingDetails>
      		<ShippingType>Flat</ShippingType>
    		'.$tstr.$ntstr.$lstr.'
   			 </ShippingDetails>
  			</Item>
  			<RequesterCredentials>
   			<eBayAuthToken>'.$token.'</eBayAuthToken>
  			</RequesterCredentials>
  			<WarningLevel>High</WarningLevel>
			</ReviseItemRequest>

			';


			
			 $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);

			 $responseXml = $session->sendHttpRequest($xmlRequest);		
	
			 if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';

			 $data=XML_unserialize($responseXml); 
		
			 
			 $ack		= $data['ReviseItemResponse']['Ack'];
			 
			 if($ack != 'Failure'){
				 
				 $LongMessage		= $data['ReviseItemResponse']['Errors'];
				 if(is_array($LongMessage)){
					for($i=0;$i<count($LongMessage);$i++){
						echo '<br><font color="#FF0000">'.$data['ReviseItemResponse']['Errors'][$i]['LongMessage'].'</font>';
					}
					 
				 }else{
					 echo '<br><font color="#FF0000">'.$LongMessage.'</font>';
				 }
				 $ItemID			= $data['ReviseItemResponse']['ItemID'];
				 echo '<br>Item Number: '.$ItemID.' 提交修改到eBay 成功';
				 
			 }else{
				 
					
					 $LongMessage		= $data['ReviseItemResponse']['Errors']['LongMessage'];
					 
				 if($LongMessage == ''){
					for($i=0;$i<count($LongMessage);$i++){
						echo '<br><font color="#FF0000">'.$data['ReviseItemResponse']['Errors'][$i]['LongMessage'].'</font>';
					}
					 
				 }else{
					 echo '<br><font color="#FF0000">'.$data['ReviseItemResponse']['Errors']['LongMessage'].'</font>';
				 }
				 
				 
				 
			 }
			 
			 
		
		
		
		
		
		}
		
		
		
		
		function AddItem($id){
			
			
			$verb = 'AddItem';
			global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$dbcon;
			
			
			$ss			= "select * from ebay_list where id='$id'";
			$ss			= $dbcon->execute($ss);
			$ss			= $dbcon->getResultArray($ss);
			
			
			$PayPalEmailAddress	= $ss[0]['PayPalEmailAddress'];
			$Title				= $ss[0]['Title'];
			$SKU				= $ss[0]['SKU'];
			$ItemID				= $ss[0]['ItemID'];
			$ListingType		= $ss[0]['ListingType'];
			$ListingDuration	= $ss[0]['ListingDuration'];
			$Description		= $ss[0]['Description'];
			$ebay_account		= $ss[0]['ebay_account'];
			$StartPrice			= $ss[0]['StartPrice'];
			$ReservePrice		= $ss[0]['ReservePrice'];
			$Quantity			= $ss[0]['Quantity'];
			$condition			= $ss[0]['ConditionID'];
			$Country			= $ss[0]['Country'];
			$BuyItNowPrice		= $ss[0]['BuyItNowPrice'];
			$CategoryID			= $ss[0]['CategoryID'];
			$StoreCategoryID	= $ss[0]['StoreCategoryID'];
			
			if($StoreCategoryID != ''){
				$StoreCategory	= '<Storefront><StoreCategoryID>'.$StoreCategoryID.'</StoreCategoryID></Storefront>';
			}
			
			
			$Location			= $ss[0]['Location'];
			$DispatchTimeMax							= $ss[0]['DispatchTimeMax']?$ss[0]['DispatchTimeMax']:1;
			$img001										= $ss[0]['PictureURL01'];
			$img002										= $ss[0]['PictureURL02'];
			$img003										= $ss[0]['PictureURL03'];
			$img004										= $ss[0]['PictureURL04'];
			$ebay_listingreturnmethodid					= $ss[0]['ebay_listingreturnmethodid'];
			$ebay_shippingtempate						= $ss[0]['ebay_listingshippingmethodid'];

			
			$ss		= "select * from ebay_listingreturnmethod where id='$ebay_listingreturnmethodid' ";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			
			$ReturnsAcceptedOption				= $ss[0]['ReturnsAcceptedOption'];
			$RefundOption						= $ss[0]['RefundOption'];
			$ReturnsWithinOption				= $ss[0]['ReturnsWithinOption'];
			$ShippingCostPaidByOption			= $ss[0]['ShippingCostPaidByOption'];
			$TDescription						= $ss[0]['Description'];
		
			
			
			$token				= geteBayaccountToken($ebay_account);
			
			
				/* 取得运费模板 */
			 $ss		= "select * from ebay_shippingtemplate where id='$ebay_shippingtempate' ";
			 $ss		= $dbcon->execute($ss);
			 $ss		= $dbcon->getResultArray($ss);
			 
			 $service0					= $ss[0]['service0'];
			 $serviceshippingfee		= $ss[0]['serviceshippingfee'];
			 $serviceshippingfeecost	= $ss[0]['serviceshippingfeecost'];
			 if($service0 !='' && $serviceshippingfee !='' && $serviceshippingfeecost !=''){
				
			 	$tstr		= '  <ShippingServiceOptions>
       			 <ShippingServicePriority>1</ShippingServicePriority>
        		<ShippingService>'.$service0.'</ShippingService>
       <ShippingServiceCost>'.$serviceshippingfeecost.'</ShippingServiceCost>
	   <ShippingServiceAdditionalCost>'.$serviceshippingfeecost.'</ShippingServiceAdditionalCost>
      </ShippingServiceOptions>';
	  
			 
			 }
			 
			 $service1					= $ss[0]['service1'];
			 $service1shippingfee		= $ss[0]['service1shippingfee'];
			 $service1shippingfeecost	= $ss[0]['service1shippingfeecost'];
			 if($service1 !='' && $service1shippingfee !='' && $service1shippingfeecost !=''){
			
			 	$tstr		.= '  <ShippingServiceOptions>
        <ShippingServicePriority>2</ShippingServicePriority>
        <ShippingService>'.$service1.'</ShippingService>
       <ShippingServiceCost>'.$service1shippingfee.'</ShippingServiceCost>
	   <ShippingServiceAdditionalCost>'.$service1shippingfeecost.'</ShippingServiceAdditionalCost>
      </ShippingServiceOptions>';
	  
			 
			 }
			 
			 $service2					= $ss[0]['service2'];
			 $service2shippingfee		= $ss[0]['service2shippingfee'];
			 $service2shippingfeecost	= $ss[0]['service2shippingfeecost'];
			 if($service2 !='' && $service2shippingfee !='' && $service2shippingfeecost !=''){
			
			 	$tstr		.= '  <ShippingServiceOptions>
        <ShippingServicePriority>3</ShippingServicePriority>
        <ShippingService>'.$service2.'</ShippingService>
       <ShippingServiceCost>'.$service2shippingfee.'</ShippingServiceCost>
	   <ShippingServiceAdditionalCost>'.$service2shippingfeecost.'</ShippingServiceAdditionalCost>
      </ShippingServiceOptions>';
	  
			 
			 }
			 
			 
			 $nservice0					= $ss[0]['nservice0'];
			 $nserviceshippingfee		= $ss[0]['nserviceshippingfee'];
			 $nserviceshippingfeecost	= $ss[0]['nserviceshippingfeecost'];
			 $d0						= $ss[0]['d0'];
			 $d1						= $ss[0]['d1'];
			 $d2						= $ss[0]['d2'];
			 $d3						= $ss[0]['d3'];
			 if($nservice0 !='' && $nserviceshippingfee !='' && $nserviceshippingfeecost !=''){
				
				
				$tline					= '';
				if($d0 != '') $tline	.= '<ShipToLocation>'.$d0.'</ShipToLocation>';
				if($d1 != '') $tline	.= '<ShipToLocation>'.$d1.'</ShipToLocation>';
				if($d2 != '') $tline	.= '<ShipToLocation>'.$d2.'</ShipToLocation>';
				if($d3 != '') $tline	.= '<ShipToLocation>'.$d3.'</ShipToLocation>';
				
			 	$ntstr		.= '<InternationalShippingServiceOption>
        <ShippingService>'.$nservice0.'</ShippingService>
        <ShippingServiceAdditionalCost>'.$nserviceshippingfeecost.'</ShippingServiceAdditionalCost>
        <ShippingServiceCost>'.$nserviceshippingfee.'</ShippingServiceCost>
        <ShippingServicePriority>1</ShippingServicePriority>
        '.$tline.'
      </InternationalShippingServiceOption>
    ';
	  
			 
			 }
			 
			 
			 $nservice1					= $ss[0]['nservice1'];
			 $nservices1hippingfee		= $ss[0]['nservices1hippingfee'];
			 $nservices1hippingfeecost	= $ss[0]['nservices1hippingfeecost'];
			 $dd0						= $ss[0]['dd0'];
			 $dd1						= $ss[0]['dd1'];
			 $dd2						= $ss[0]['dd2'];
			 $dd3						= $ss[0]['dd3'];
			 if($nservice1 !='' && $nservices1hippingfee !='' && $nservices1hippingfeecost !=''){
				
				
				$tline					= '';
				if($dd0 != '') $tline	.= '<ShipToLocation>'.$dd0.'</ShipToLocation>';
				if($dd1 != '') $tline	.= '<ShipToLocation>'.$dd1.'</ShipToLocation>';
				if($dd2 != '') $tline	.= '<ShipToLocation>'.$dd2.'</ShipToLocation>';
				if($dd3 != '') $tline	.= '<ShipToLocation>'.$dd3.'</ShipToLocation>';
				
			 	$ntstr		.= '<InternationalShippingServiceOption>
        <ShippingService>'.$nservice1.'</ShippingService>
        <ShippingServiceAdditionalCost>'.$nservices1hippingfeecost.'</ShippingServiceAdditionalCost>
        <ShippingServiceCost>'.$nservices1hippingfee.'</ShippingServiceCost>
        <ShippingServicePriority>1</ShippingServicePriority>
        '.$tline.'
      </InternationalShippingServiceOption>
    ';
	  
			 
			 }
			 
			 
			 $nservice2					= $ss[0]['nservice2'];
			 $nservice2shippingfee		= $ss[0]['nservice2shippingfee'];
			 $nservices2hippingfeecost	= $ss[0]['nservices2hippingfeecost'];
			 $ddd0						= $ss[0]['ddd0'];
			 $ddd1						= $ss[0]['ddd1'];
			 $ddd2						= $ss[0]['ddd2'];
			 $ddd3						= $ss[0]['ddd3'];
			 if($nservice2 !='' && $nservice2shippingfee !='' && $nservices2hippingfeecost !=''){
				
				
				$tline					= '';
				if($ddd0 != '') $tline	.= '<ShipToLocation>'.$ddd0.'</ShipToLocation>';
				if($ddd1 != '') $tline	.= '<ShipToLocation>'.$ddd1.'</ShipToLocation>';
				if($ddd2 != '') $tline	.= '<ShipToLocation>'.$ddd2.'</ShipToLocation>';
				if($ddd3 != '') $tline	.= '<ShipToLocation>'.$ddd3.'</ShipToLocation>';
				
			 	$ntstr		.= '<InternationalShippingServiceOption>
        <ShippingService>'.$nservice2.'</ShippingService>
        <ShippingServiceAdditionalCost>'.$nservices2hippingfeecost.'</ShippingServiceAdditionalCost>
        <ShippingServiceCost>'.$nservice2shippingfee.'</ShippingServiceCost>
        <ShippingServicePriority>1</ShippingServicePriority>
        '.$tline.'
      </InternationalShippingServiceOption>
    ';
	  
			 
			 }
			 
			
			 $l01						= $ss[0]['l01'];
			 $l02						= $ss[0]['l02'];
			 $l03						= $ss[0]['l03'];
			 $l04						= $ss[0]['l04'];
			 $l05						= $ss[0]['l05'];
			 $l06						= $ss[0]['l06'];
			 $l07						= $ss[0]['l07'];
			 $l08						= $ss[0]['l08'];
			 $l09						= $ss[0]['l09'];
			 $l10						= $ss[0]['l10'];
			 $lstr						= '';
			 
			 if($l01 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l01.'</ExcludeShipToLocation>';
			 if($l02 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l02.'</ExcludeShipToLocation>';
			 if($l03 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l03.'</ExcludeShipToLocation>';
			 if($l04 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l04.'</ExcludeShipToLocation>';
			 if($l05 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l05.'</ExcludeShipToLocation>';
			 if($l06 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l06.'</ExcludeShipToLocation>';
			 if($l07 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l07.'</ExcludeShipToLocation>';
			 if($l08 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l08.'</ExcludeShipToLocation>';
			 if($l09 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l09.'</ExcludeShipToLocation>';
			 if($l10 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l10.'</ExcludeShipToLocation>';
			 
			 /* 检查多属性产品 */
			$ss		= "select * from ebay_listvarious where sid='$id' ";
			
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			
			$name0	= $ss[0]['name0'];
			$name1	= $ss[0]['name1'];
			$name2	= $ss[0]['name2'];
			$name3	= $ss[0]['name3'];
			$name4	= $ss[0]['name4'];
			$pid	= $ss[0]['id'];
			$name0arry = array();
			$name1arry = array();
			$name2arry = array();
			$name3arry = array();
			$name4arry = array();
			
			
			/* 检查多属性产品的值 */
			
			$ss		= "select value0 from ebay_listvariousdetails where pid='$pid' group by value0";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			for($i=0;$i<count($ss);$i++){
				$name0arry[$i] = $ss[$i]['value0'];
			}
			
			$ss		= "select value1 from ebay_listvariousdetails where pid='$pid' group by value1";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			for($i=0;$i<count($ss);$i++){
				$name1arry[$i] = $ss[$i]['value1'];
			}
			
			$ss		= "select value2 from ebay_listvariousdetails where pid='$pid' group by value2";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			
			for($i=0;$i<count($ss);$i++){
				$name2arry[$i] = $ss[$i]['value2'];
			}
			
			$ss		= "select value3 from ebay_listvariousdetails where pid='$pid' group by value3";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			for($i=0;$i<count($ss);$i++){
				$name3arry[$i] = $ss[$i]['value3'];
			}
			
			$ss		= "select value0 from ebay_listvariousdetails where pid='$pid' group by value4";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			for($i=0;$i<count($ss);$i++){
				$name4arry[$i] = $ss[$i]['value4'];
			}
			
			

			
			$tvarname	= '';
			if($name0 != '' && count($name0arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name0arry);$i++){
					$tvarvalue	.= '<Value>'.$name0arry[$i].'</Value>';
				}
				$tvarname	= '<NameValueList><Name>'.$name0.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			
			if($name1 != '' && count($name1arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name1arry);$i++){
					$tvarvalue	.= '<Value>'.$name1arry[$i].'</Value>';
				}
				$tvarname	.= '<NameValueList><Name>'.$name1.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			
			if($name2 != '' && count($name2arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name2arry);$i++){
					$tvarvalue	.= '<Value>'.$name2arry[$i].'</Value>';
				}
				$tvarname	.= '<NameValueList><Name>'.$name2.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			
			if($name3 != '' && count($name3arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name3arry);$i++){
					$tvarvalue	.= '<Value>'.$name3arry[$i].'</Value>';
				}
				$tvarname	.= '<NameValueList><Name>'.$name3.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			
			if($name4 != '' && count($name4arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name4arry);$i++){
					$tvarvalue	.= '<Value>'.$name4arry[$i].'</Value>';
				}
				$tvarname	.= '<NameValueList><Name>'.$name4.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			$tvarname		= fstr_rep($tvarname);
			
			
			$ss		= "select * from ebay_listvariousdetails where pid='$pid' ";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			$varline	= '';
			$varpic		= '';
			
			
			for($i=0;$i<count($ss);$i++){
				
				$sku		= $ss[$i]['sku'];
				$value0		= $ss[$i]['value0'];
				$value1		= $ss[$i]['value1'];
				$value2		= $ss[$i]['value2'];
				$value3		= $ss[$i]['value3'];
				$value4		= $ss[$i]['value4'];
				$price		= $ss[$i]['price'];
				$picture	= $ss[$i]['picture'];
				$qty		= $ss[$i]['qty'];
			
				
				
				$tvar0		= " <Variation>
        		<SKU>".$sku."</SKU>
        		<StartPrice>".$price."</StartPrice>
        		<Quantity>".$qty."</Quantity>
				<VariationSpecifics>
				";
				
				$var1		= '';
				if($name0 != '' && $value0 != ''){
				
				$name0		 = fstr_rep($name0);
				$var1		.= "<NameValueList><Name>".$name0."</Name><Value>".$value0."</Value></NameValueList>";
				
				if($picture != ''){
				$varpic		 .= " 
        						 <VariationSpecificPictureSet>
          						 <VariationSpecificValue>".$value0."</VariationSpecificValue>
          						 <PictureURL>".$picture."</PictureURL>
        						 </VariationSpecificPictureSet>";
				}
				
				}
				
				if($name1 != '' && $value1 != ''){
				$name1		 = fstr_rep($name1);
				$var1		.= "<NameValueList><Name>".$name1."</Name><Value>".$value1."</Value></NameValueList>";
				}
				if($name2 != '' && $value2 != ''){
				$name2		 = fstr_rep($name2);
				$var1		.= "<NameValueList><Name>".$name2."</Name><Value>".$value2."</Value></NameValueList>";
				}
				
				if($name3 != '' && $value3 != ''){
				$name3		 = fstr_rep($name3);
				$var1		.= "<NameValueList><Name>".$name3."</Name><Value>".$value3."</Value></NameValueList>";
				}
				
				if($name4 != '' && $value4 != ''){
				$name4		 = fstr_rep($name4);
				$var1		.= "<NameValueList><Name>".$name4."</Name><Value>".$value4."</Value></NameValueList>";
				}
				
				
				$varline	.= $tvar0.$var1.'</VariationSpecifics></Variation>';
				
        		
        		
				
			}
			
			
			$varpic		= '<Pictures>'."<VariationSpecificName>".$name0."</VariationSpecificName>".$varpic.'</Pictures>';
			
			if($tvarname != ''){
				$variations				= "
			  <Variations>
      <VariationSpecificsSet>
    ".$tvarname."
      </VariationSpecificsSet>
    ".$varline.$varpic."
     
    </Variations>
			";
			}

			 $namevaluelist		= '';
			 $ss				= "select * from ebay_itemspecifics where sid ='$id'";
			 $ss				= $dbcon->execute($ss);
			 $ss				= $dbcon->getResultArray($ss);
			 
			for($i=0;$i<count($ss);$i++){
			 
				
				$keys			=$ss[$i]['name'];
				$value			= fstr_rep($ss[$i]['value']);
				/* 检查此keys是否存在于多属性当中 */
				
				$yy		= "select * from ebay_listvarious where name0='$keys' or name1='$keys' or name2='$keys' or name3='$keys' or name4='$keys' ";
			

				$yy				= $dbcon->execute($yy);
				$yy				= $dbcon->getResultArray($yy);
				$keys			= fstr_rep($ss[$i]['name']);
				if(count($yy) ==0 ){
				$namevaluelist		.= '<NameValueList>
			 	<Name>'.$keys.'</Name>
			 	<Value>'.$value.'</Value>
      			 </NameValueList>';
				}
				
				
			 } 
			 
			 

			 $itemspecific			= '<ItemSpecifics>'.$namevaluelist.'</ItemSpecifics>';
			
			$xmlRequest		= '<?xml version="1.0" encoding="utf-8"?>
			<AddItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
			<ErrorLanguage>en_US</ErrorLanguage>
  			<WarningLevel>High</WarningLevel>
  			<Item>
			'.$StoreCategory.'
    		<ItemID>'.$ItemID.'</ItemID>
    		<SKU>'.$SKU.'</SKU>
			<Title>'.$Title.'</Title>
   			<Description><![CDATA['.$Description.']]></Description>    		
		    <PrimaryCategory><CategoryID>'.$CategoryID.'</CategoryID></PrimaryCategory>
    		<StartPrice>'.$StartPrice.'</StartPrice>';
			if($ReservePrice != '') 		$xmlRequest .= '<ReservePrice currencyID="USD">'.$ReservePrice.'</ReservePrice>';
			if($ListingType == 'Chinese') 	$xmlRequest .= '<BuyItNowPrice currencyID="USD">'.$BuyItNowPrice.'</BuyItNowPrice> ';
			if($Quantity > 0) 				$xmlRequest .= '<Quantity>'.$Quantity.'</Quantity>';
			
			$xmlRequest	.= '			
    		<ConditionID>'.$condition.'</ConditionID>
   			<CategoryMappingAllowed>true</CategoryMappingAllowed>
    		<Country>'.$Country.'</Country>'.$itemspecific.$variations.'
    		<Currency>USD</Currency>
			<Location>'.$Location.'</Location>
    		<DispatchTimeMax>'.$DispatchTimeMax.'</DispatchTimeMax>
    		<ListingDuration>'.$ListingDuration.'</ListingDuration>
    		<PaymentMethods>PayPal</PaymentMethods>
   			<PayPalEmailAddress>'.$PayPalEmailAddress.'</PayPalEmailAddress>
	 		<PictureDetails>
	  		<GalleryType>Gallery</GalleryType>';
	  
	  
	  		if($img001 != '') $xmlRequest .= '<PictureURL>'.$img001.'</PictureURL>';
	 		if($img002 != '') $xmlRequest .= '<PictureURL>'.$img002.'</PictureURL>';
	 		if($img003 != '') $xmlRequest .= '<PictureURL>'.$img003.'</PictureURL>';
	 		if($img004 != '') $xmlRequest .= '<PictureURL>'.$img004.'</PictureURL>';
	  
	  		$xmlRequest .='
    		</PictureDetails>
    		<ReturnPolicy>
      		<ReturnsAcceptedOption>'.$ReturnsAcceptedOption.'</ReturnsAcceptedOption>
      		<RefundOption>'.$RefundOption.'</RefundOption>
      		<ReturnsWithinOption>'.$ReturnsWithinOption.'</ReturnsWithinOption>
      		<Description>'.$TDescription.'</Description>
      		<ShippingCostPaidByOption>'.$ShippingCostPaidByOption.'</ShippingCostPaidByOption>
    		</ReturnPolicy>
	
   			<ShippingDetails>
      		<ShippingType>Flat</ShippingType>
    		'.$tstr.$ntstr.$lstr.'
   			 </ShippingDetails>
  			</Item>
  			<RequesterCredentials>
   			<eBayAuthToken>'.$token.'</eBayAuthToken>
  			</RequesterCredentials>
  			<WarningLevel>High</WarningLevel>
			</AddItemRequest>

			';

			
			 $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);

			 $responseXml = $session->sendHttpRequest($xmlRequest);		
			 echo $xmlRequest;
			 
			 if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';

			 $data=XML_unserialize($responseXml); 
			
			 $ack		= $data['AddItemResponse']['Ack'];
			 
			 
		
			 
			 if($ack != 'Failure'){
				 
				 $LongMessage		= $data['AddItemResponse']['Errors'];
				 
				
				 if(is_array($LongMessage)){
					for($i=0;$i<count($LongMessage);$i++){
						echo '<br><font color="#FF0000">'.$data['AddItemResponse']['Errors'][$i]['LongMessage'].'</font>';
					}
					 
				 }else{
					 echo '<br><font color="#FF0000">'.$LongMessage.'</font>';
				 }
				  $ItemID			= $data['AddItemResponse']['ItemID'];
				  
				 echo '<br>Item Number: '.$ItemID.' 发布到eBay 成功';
				 
			 }else{
				 
					
					 $LongMessage		= $data['AddItemResponse']['Errors']['LongMessage'];
					 
				 if($LongMessage == ''){
				 
				 	
					for($i=0;$i<count($data['AddItemResponse']['Errors']);$i++){
						echo '<br><font color="#FF0000">'.$data['AddItemResponse']['Errors'][$i]['LongMessage'].'</font>';
					}
					
	

					 
				 }else{
					 echo '<br><font color="#FF0000">'.$data['AddItemResponse']['Errors']['LongMessage'].'</font>';
				 }
				 
				 
				 
			 }
			 
		}
		
		
		function LAddItem($id){
			
			
			$verb = 'AddItem';
			global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$dbcon;
			
			
			$ss			= "select * from ebay_list where id='$id'";
			$ss			= $dbcon->execute($ss);
			$ss			= $dbcon->getResultArray($ss);
			
			
			$PayPalEmailAddress	= $ss[0]['PayPalEmailAddress'];
			$Title				= $ss[0]['Title'];
			$SKU				= $ss[0]['SKU'];
			$ItemID				= $ss[0]['ItemID'];
			$ListingType		= $ss[0]['ListingType'];
			$ListingDuration	= $ss[0]['ListingDuration'];
			$Description		= $ss[0]['Description'];
			$ebay_account		= $ss[0]['ebay_account'];
			$StartPrice			= $ss[0]['StartPrice'];
			$ReservePrice		= $ss[0]['ReservePrice'];
			$Quantity			= $ss[0]['Quantity'];
			$condition			= $ss[0]['ConditionID'];
			$Country			= $ss[0]['Country'];
			$BuyItNowPrice		= $ss[0]['BuyItNowPrice'];
			$CategoryID			= $ss[0]['CategoryID'];
			$StoreCategoryID	= $ss[0]['StoreCategoryID'];
			
			if($StoreCategoryID != ''){
				$StoreCategory	= '<Storefront><StoreCategoryID>'.$StoreCategoryID.'</StoreCategoryID></Storefront>';
			}
			
			
			$Location			= $ss[0]['Location'];
			$DispatchTimeMax							= $ss[0]['DispatchTimeMax']?$ss[0]['DispatchTimeMax']:1;
			$img001										= $ss[0]['PictureURL01'];
			$img002										= $ss[0]['PictureURL02'];
			$img003										= $ss[0]['PictureURL03'];
			$img004										= $ss[0]['PictureURL04'];
			$ebay_listingreturnmethodid					= $ss[0]['ebay_listingreturnmethodid'];
			$ebay_shippingtempate						= $ss[0]['ebay_listingshippingmethodid'];

			
			$ss		= "select * from ebay_listingreturnmethod where id='$ebay_listingreturnmethodid' ";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			
			$ReturnsAcceptedOption				= $ss[0]['ReturnsAcceptedOption'];
			$RefundOption						= $ss[0]['RefundOption'];
			$ReturnsWithinOption				= $ss[0]['ReturnsWithinOption'];
			$ShippingCostPaidByOption			= $ss[0]['ShippingCostPaidByOption'];
			$TDescription						= $ss[0]['Description'];
		
			
			
			$token				= geteBayaccountToken($ebay_account);
			
			
				/* 取得运费模板 */
			 $ss		= "select * from ebay_shippingtemplate where id='$ebay_shippingtempate' ";
			 $ss		= $dbcon->execute($ss);
			 $ss		= $dbcon->getResultArray($ss);
			 
			 $service0					= $ss[0]['service0'];
			 $serviceshippingfee		= $ss[0]['serviceshippingfee'];
			 $serviceshippingfeecost	= $ss[0]['serviceshippingfeecost'];
			 if($service0 !='' && $serviceshippingfee !='' && $serviceshippingfeecost !=''){
				
			 	$tstr		= '  <ShippingServiceOptions>
       			 <ShippingServicePriority>1</ShippingServicePriority>
        		<ShippingService>'.$service0.'</ShippingService>
       <ShippingServiceCost>'.$serviceshippingfeecost.'</ShippingServiceCost>
	   <ShippingServiceAdditionalCost>'.$serviceshippingfeecost.'</ShippingServiceAdditionalCost>
      </ShippingServiceOptions>';
	  
			 
			 }
			 
			 $service1					= $ss[0]['service1'];
			 $service1shippingfee		= $ss[0]['service1shippingfee'];
			 $service1shippingfeecost	= $ss[0]['service1shippingfeecost'];
			 if($service1 !='' && $service1shippingfee !='' && $service1shippingfeecost !=''){
			
			 	$tstr		.= '  <ShippingServiceOptions>
        <ShippingServicePriority>2</ShippingServicePriority>
        <ShippingService>'.$service1.'</ShippingService>
       <ShippingServiceCost>'.$service1shippingfee.'</ShippingServiceCost>
	   <ShippingServiceAdditionalCost>'.$service1shippingfeecost.'</ShippingServiceAdditionalCost>
      </ShippingServiceOptions>';
	  
			 
			 }
			 
			 $service2					= $ss[0]['service2'];
			 $service2shippingfee		= $ss[0]['service2shippingfee'];
			 $service2shippingfeecost	= $ss[0]['service2shippingfeecost'];
			 if($service2 !='' && $service2shippingfee !='' && $service2shippingfeecost !=''){
			
			 	$tstr		.= '  <ShippingServiceOptions>
        <ShippingServicePriority>3</ShippingServicePriority>
        <ShippingService>'.$service2.'</ShippingService>
       <ShippingServiceCost>'.$service2shippingfee.'</ShippingServiceCost>
	   <ShippingServiceAdditionalCost>'.$service2shippingfeecost.'</ShippingServiceAdditionalCost>
      </ShippingServiceOptions>';
	  
			 
			 }
			 
			 
			 $nservice0					= $ss[0]['nservice0'];
			 $nserviceshippingfee		= $ss[0]['nserviceshippingfee'];
			 $nserviceshippingfeecost	= $ss[0]['nserviceshippingfeecost'];
			 $d0						= $ss[0]['d0'];
			 $d1						= $ss[0]['d1'];
			 $d2						= $ss[0]['d2'];
			 $d3						= $ss[0]['d3'];
			 if($nservice0 !='' && $nserviceshippingfee !='' && $nserviceshippingfeecost !=''){
				
				
				$tline					= '';
				if($d0 != '') $tline	.= '<ShipToLocation>'.$d0.'</ShipToLocation>';
				if($d1 != '') $tline	.= '<ShipToLocation>'.$d1.'</ShipToLocation>';
				if($d2 != '') $tline	.= '<ShipToLocation>'.$d2.'</ShipToLocation>';
				if($d3 != '') $tline	.= '<ShipToLocation>'.$d3.'</ShipToLocation>';
				
			 	$ntstr		.= '<InternationalShippingServiceOption>
        <ShippingService>'.$nservice0.'</ShippingService>
        <ShippingServiceAdditionalCost>'.$nserviceshippingfeecost.'</ShippingServiceAdditionalCost>
        <ShippingServiceCost>'.$nserviceshippingfee.'</ShippingServiceCost>
        <ShippingServicePriority>1</ShippingServicePriority>
        '.$tline.'
      </InternationalShippingServiceOption>
    ';
	  
			 
			 }
			 
			 
			 $nservice1					= $ss[0]['nservice1'];
			 $nservices1hippingfee		= $ss[0]['nservices1hippingfee'];
			 $nservices1hippingfeecost	= $ss[0]['nservices1hippingfeecost'];
			 $dd0						= $ss[0]['dd0'];
			 $dd1						= $ss[0]['dd1'];
			 $dd2						= $ss[0]['dd2'];
			 $dd3						= $ss[0]['dd3'];
			 if($nservice1 !='' && $nservices1hippingfee !='' && $nservices1hippingfeecost !=''){
				
				
				$tline					= '';
				if($dd0 != '') $tline	.= '<ShipToLocation>'.$dd0.'</ShipToLocation>';
				if($dd1 != '') $tline	.= '<ShipToLocation>'.$dd1.'</ShipToLocation>';
				if($dd2 != '') $tline	.= '<ShipToLocation>'.$dd2.'</ShipToLocation>';
				if($dd3 != '') $tline	.= '<ShipToLocation>'.$dd3.'</ShipToLocation>';
				
			 	$ntstr		.= '<InternationalShippingServiceOption>
        <ShippingService>'.$nservice1.'</ShippingService>
        <ShippingServiceAdditionalCost>'.$nservices1hippingfeecost.'</ShippingServiceAdditionalCost>
        <ShippingServiceCost>'.$nservices1hippingfee.'</ShippingServiceCost>
        <ShippingServicePriority>1</ShippingServicePriority>
        '.$tline.'
      </InternationalShippingServiceOption>
    ';
	  
			 
			 }
			 
			 
			 $nservice2					= $ss[0]['nservice2'];
			 $nservice2shippingfee		= $ss[0]['nservice2shippingfee'];
			 $nservices2hippingfeecost	= $ss[0]['nservices2hippingfeecost'];
			 $ddd0						= $ss[0]['ddd0'];
			 $ddd1						= $ss[0]['ddd1'];
			 $ddd2						= $ss[0]['ddd2'];
			 $ddd3						= $ss[0]['ddd3'];
			 if($nservice2 !='' && $nservice2shippingfee !='' && $nservices2hippingfeecost !=''){
				
				
				$tline					= '';
				if($ddd0 != '') $tline	.= '<ShipToLocation>'.$ddd0.'</ShipToLocation>';
				if($ddd1 != '') $tline	.= '<ShipToLocation>'.$ddd1.'</ShipToLocation>';
				if($ddd2 != '') $tline	.= '<ShipToLocation>'.$ddd2.'</ShipToLocation>';
				if($ddd3 != '') $tline	.= '<ShipToLocation>'.$ddd3.'</ShipToLocation>';
				
			 	$ntstr		.= '<InternationalShippingServiceOption>
        <ShippingService>'.$nservice2.'</ShippingService>
        <ShippingServiceAdditionalCost>'.$nservices2hippingfeecost.'</ShippingServiceAdditionalCost>
        <ShippingServiceCost>'.$nservice2shippingfee.'</ShippingServiceCost>
        <ShippingServicePriority>1</ShippingServicePriority>
        '.$tline.'
      </InternationalShippingServiceOption>
    ';
	  
			 
			 }
			 
			
			 $l01						= $ss[0]['l01'];
			 $l02						= $ss[0]['l02'];
			 $l03						= $ss[0]['l03'];
			 $l04						= $ss[0]['l04'];
			 $l05						= $ss[0]['l05'];
			 $l06						= $ss[0]['l06'];
			 $l07						= $ss[0]['l07'];
			 $l08						= $ss[0]['l08'];
			 $l09						= $ss[0]['l09'];
			 $l10						= $ss[0]['l10'];
			 $lstr						= '';
			 
			 if($l01 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l01.'</ExcludeShipToLocation>';
			 if($l02 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l02.'</ExcludeShipToLocation>';
			 if($l03 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l03.'</ExcludeShipToLocation>';
			 if($l04 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l04.'</ExcludeShipToLocation>';
			 if($l05 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l05.'</ExcludeShipToLocation>';
			 if($l06 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l06.'</ExcludeShipToLocation>';
			 if($l07 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l07.'</ExcludeShipToLocation>';
			 if($l08 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l08.'</ExcludeShipToLocation>';
			 if($l09 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l09.'</ExcludeShipToLocation>';
			 if($l10 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l10.'</ExcludeShipToLocation>';
			 
			 /* 检查多属性产品 */
			$ss		= "select * from ebay_listvarious where sid='$id' ";
			
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			
			$name0	= $ss[0]['name0'];
			$name1	= $ss[0]['name1'];
			$name2	= $ss[0]['name2'];
			$name3	= $ss[0]['name3'];
			$name4	= $ss[0]['name4'];
			$pid	= $ss[0]['id'];
			$name0arry = array();
			$name1arry = array();
			$name2arry = array();
			$name3arry = array();
			$name4arry = array();
			
			
			/* 检查多属性产品的值 */
			
			$ss		= "select value0 from ebay_listvariousdetails where pid='$pid' group by value0";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			for($i=0;$i<count($ss);$i++){
				$name0arry[$i] = $ss[$i]['value0'];
			}
			
			$ss		= "select value1 from ebay_listvariousdetails where pid='$pid' group by value1";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			for($i=0;$i<count($ss);$i++){
				$name1arry[$i] = $ss[$i]['value1'];
			}
			
			$ss		= "select value2 from ebay_listvariousdetails where pid='$pid' group by value2";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			
			for($i=0;$i<count($ss);$i++){
				$name2arry[$i] = $ss[$i]['value2'];
			}
			
			$ss		= "select value3 from ebay_listvariousdetails where pid='$pid' group by value3";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			for($i=0;$i<count($ss);$i++){
				$name3arry[$i] = $ss[$i]['value3'];
			}
			
			$ss		= "select value0 from ebay_listvariousdetails where pid='$pid' group by value4";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			for($i=0;$i<count($ss);$i++){
				$name4arry[$i] = $ss[$i]['value4'];
			}
			
			

			
			$tvarname	= '';
			if($name0 != '' && count($name0arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name0arry);$i++){
					$tvarvalue	.= '<Value>'.$name0arry[$i].'</Value>';
				}
				$tvarname	= '<NameValueList><Name>'.$name0.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			
			if($name1 != '' && count($name1arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name1arry);$i++){
					$tvarvalue	.= '<Value>'.$name1arry[$i].'</Value>';
				}
				$tvarname	.= '<NameValueList><Name>'.$name1.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			
			if($name2 != '' && count($name2arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name2arry);$i++){
					$tvarvalue	.= '<Value>'.$name2arry[$i].'</Value>';
				}
				$tvarname	.= '<NameValueList><Name>'.$name2.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			
			if($name3 != '' && count($name3arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name3arry);$i++){
					$tvarvalue	.= '<Value>'.$name3arry[$i].'</Value>';
				}
				$tvarname	.= '<NameValueList><Name>'.$name3.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			
			if($name4 != '' && count($name4arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name4arry);$i++){
					$tvarvalue	.= '<Value>'.$name4arry[$i].'</Value>';
				}
				$tvarname	.= '<NameValueList><Name>'.$name4.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			$tvarname		= fstr_rep($tvarname);
			
			
			$ss		= "select * from ebay_listvariousdetails where pid='$pid' ";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			$varline	= '';
			$varpic		= '';
			
			
			for($i=0;$i<count($ss);$i++){
				
				$sku		= $ss[$i]['sku'];
				$value0		= $ss[$i]['value0'];
				$value1		= $ss[$i]['value1'];
				$value2		= $ss[$i]['value2'];
				$value3		= $ss[$i]['value3'];
				$value4		= $ss[$i]['value4'];
				$price		= $ss[$i]['price'];
				$picture	= $ss[$i]['picture'];
				$qty		= $ss[$i]['qty'];
			
				
				
				$tvar0		= " <Variation>
        		<SKU>".$sku."</SKU>
        		<StartPrice>".$price."</StartPrice>
        		<Quantity>".$qty."</Quantity>
				<VariationSpecifics>
				";
				
				$var1		= '';
				if($name0 != '' && $value0 != ''){
				
				$name0		 = fstr_rep($name0);
				$var1		.= "<NameValueList><Name>".$name0."</Name><Value>".$value0."</Value></NameValueList>";
				
				if($picture != ''){
				$varpic		 .= " 
        						 <VariationSpecificPictureSet>
          						 <VariationSpecificValue>".$value0."</VariationSpecificValue>
          						 <PictureURL>".$picture."</PictureURL>
        						 </VariationSpecificPictureSet>";
				}
				
				}
				
				if($name1 != '' && $value1 != ''){
				$name1		 = fstr_rep($name1);
				$var1		.= "<NameValueList><Name>".$name1."</Name><Value>".$value1."</Value></NameValueList>";
				}
				if($name2 != '' && $value2 != ''){
				$name2		 = fstr_rep($name2);
				$var1		.= "<NameValueList><Name>".$name2."</Name><Value>".$value2."</Value></NameValueList>";
				}
				
				if($name3 != '' && $value3 != ''){
				$name3		 = fstr_rep($name3);
				$var1		.= "<NameValueList><Name>".$name3."</Name><Value>".$value3."</Value></NameValueList>";
				}
				
				if($name4 != '' && $value4 != ''){
				$name4		 = fstr_rep($name4);
				$var1		.= "<NameValueList><Name>".$name4."</Name><Value>".$value4."</Value></NameValueList>";
				}
				
				
				$varline	.= $tvar0.$var1.'</VariationSpecifics></Variation>';
				
        		
        		
				
			}
			
			
			$varpic		= '<Pictures>'."<VariationSpecificName>".$name0."</VariationSpecificName>".$varpic.'</Pictures>';
			
			if($tvarname != ''){
				$variations				= "
			  <Variations>
      <VariationSpecificsSet>
    ".$tvarname."
      </VariationSpecificsSet>
    ".$varline.$varpic."
     
    </Variations>
			";
			}

			 $namevaluelist		= '';
			 $ss				= "select * from ebay_itemspecifics where sid ='$id'";
			 $ss				= $dbcon->execute($ss);
			 $ss				= $dbcon->getResultArray($ss);
			 
			for($i=0;$i<count($ss);$i++){
			 
				
				$keys			=$ss[$i]['name'];
				$value			= fstr_rep($ss[$i]['value']);
				/* 检查此keys是否存在于多属性当中 */
				
				$yy		= "select * from ebay_listvarious where name0='$keys' or name1='$keys' or name2='$keys' or name3='$keys' or name4='$keys' ";
			

				$yy				= $dbcon->execute($yy);
				$yy				= $dbcon->getResultArray($yy);
				$keys			= fstr_rep($ss[$i]['name']);
				if(count($yy) ==0 ){
				$namevaluelist		.= '<NameValueList>
			 	<Name>'.$keys.'</Name>
			 	<Value>'.$value.'</Value>
      			 </NameValueList>';
				}
				
				
			 } 
			 
			 

			 $itemspecific			= '<ItemSpecifics>'.$namevaluelist.'</ItemSpecifics>';
			
			$xmlRequest		= '<?xml version="1.0" encoding="utf-8"?>
			<AddItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
			<ErrorLanguage>en_US</ErrorLanguage>
  			<WarningLevel>High</WarningLevel>
  			<Item>
			'.$StoreCategory.'
    		<ItemID>'.$ItemID.'</ItemID>
    		<SKU>'.$SKU.'</SKU>
			<Title>'.$Title.'</Title>
   			<Description><![CDATA['.$Description.']]></Description>    		
		    <PrimaryCategory><CategoryID>'.$CategoryID.'</CategoryID></PrimaryCategory>
    		<StartPrice>'.$StartPrice.'</StartPrice>';
			if($ReservePrice != '') 		$xmlRequest .= '<ReservePrice currencyID="USD">'.$ReservePrice.'</ReservePrice>';
			if($ListingType == 'Chinese') 	$xmlRequest .= '<BuyItNowPrice currencyID="USD">'.$BuyItNowPrice.'</BuyItNowPrice> ';
			if($Quantity > 0) 				$xmlRequest .= '<Quantity>'.$Quantity.'</Quantity>';
			
			$xmlRequest	.= '			
    		<ConditionID>'.$condition.'</ConditionID>
   			<CategoryMappingAllowed>true</CategoryMappingAllowed>
    		<Country>'.$Country.'</Country>'.$itemspecific.$variations.'
    		<Currency>USD</Currency>
			<Location>'.$Location.'</Location>
    		<DispatchTimeMax>'.$DispatchTimeMax.'</DispatchTimeMax>
    		<ListingDuration>'.$ListingDuration.'</ListingDuration>
    		<PaymentMethods>PayPal</PaymentMethods>
   			<PayPalEmailAddress>'.$PayPalEmailAddress.'</PayPalEmailAddress>
	 		<PictureDetails>
	  		<GalleryType>Gallery</GalleryType>';
	  
	  
	  		if($img001 != '') $xmlRequest .= '<PictureURL>'.$img001.'</PictureURL>';
	 		if($img002 != '') $xmlRequest .= '<PictureURL>'.$img002.'</PictureURL>';
	 		if($img003 != '') $xmlRequest .= '<PictureURL>'.$img003.'</PictureURL>';
	 		if($img004 != '') $xmlRequest .= '<PictureURL>'.$img004.'</PictureURL>';
	  
	  		$xmlRequest .='
    		</PictureDetails>
    		<ReturnPolicy>
      		<ReturnsAcceptedOption>'.$ReturnsAcceptedOption.'</ReturnsAcceptedOption>
      		<RefundOption>'.$RefundOption.'</RefundOption>
      		<ReturnsWithinOption>'.$ReturnsWithinOption.'</ReturnsWithinOption>
      		<Description>'.$TDescription.'</Description>
      		<ShippingCostPaidByOption>'.$ShippingCostPaidByOption.'</ShippingCostPaidByOption>
    		</ReturnPolicy>
	
   			<ShippingDetails>
      		<ShippingType>Flat</ShippingType>
    		'.$tstr.$ntstr.$lstr.'
   			 </ShippingDetails>
  			</Item>
  			<RequesterCredentials>
   			<eBayAuthToken>'.$token.'</eBayAuthToken>
  			</RequesterCredentials>
  			<WarningLevel>High</WarningLevel>
			</AddItemRequest>

			';

			
			 $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);

			 $responseXml = $session->sendHttpRequest($xmlRequest);		
			 
			 if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';

			 $data=XML_unserialize($responseXml); 
			
			 $ack		= $data['AddItemResponse']['Ack'];
			 
			 
		
			 
			 if($ack != 'Failure'){
				 
				 $LongMessage		= $data['AddItemResponse']['Errors'];
				 
				
				 if(is_array($LongMessage)){
					for($i=0;$i<count($LongMessage);$i++){
						echo '<br><font color="#FF0000">'.$data['AddItemResponse']['Errors'][$i]['LongMessage'].'</font>';
					}
					 
				 }else{
					 echo '<br><font color="#FF0000">'.$LongMessage.'</font>';
				 }
				  $ItemID			= $data['AddItemResponse']['ItemID'];
				  
				 echo '<br>Item Number: '.$ItemID.' 发布到eBay 成功';
				 				 $ss			= "update ebay_list set status='4' where id='$id'";
				 $dbcon->execute($ss);
				
				 
			 }else{
				 
					
					 $LongMessage		= $data['AddItemResponse']['Errors']['LongMessage'];
					 
				 if($LongMessage == ''){
				 
				 	
					for($i=0;$i<count($data['AddItemResponse']['Errors']);$i++){
						echo '<br><font color="#FF0000">'.$data['AddItemResponse']['Errors'][$i]['LongMessage'].'</font>';
					}
					
	

					 
				 }else{
					 echo '<br><font color="#FF0000">'.$data['AddItemResponse']['Errors']['LongMessage'].'</font>';
				 }
				 
				 
				 
			 }
			 
		}
		function AddFixedPriceItem($id){
			
			
			$verb = 'AddFixedPriceItem';
			global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$dbcon;
			
			
			$ss			= "select * from ebay_list where id='$id'";
			$ss			= $dbcon->execute($ss);
			$ss			= $dbcon->getResultArray($ss);
			$PayPalEmailAddress	= $ss[0]['PayPalEmailAddress'];
			$Title				= $ss[0]['Title'];
			$SKU				= $ss[0]['SKU'];
			$ItemID				= $ss[0]['ItemID'];
			$ListingType		= $ss[0]['ListingType'];
			$ListingDuration	= $ss[0]['ListingDuration'];
			$Description		= $ss[0]['Description'];
			$ebay_account		= $ss[0]['ebay_account'];
			$StartPrice			= $ss[0]['StartPrice'];
			$ReservePrice		= $ss[0]['ReservePrice'];
			$Quantity			= $ss[0]['Quantity'];
			$condition			= $ss[0]['ConditionID'];
			$Country			= $ss[0]['Country'];
			$BuyItNowPrice		= $ss[0]['BuyItNowPrice'];
			$CategoryID			= $ss[0]['CategoryID'];
			
			
			$StoreCategoryID	= $ss[0]['StoreCategoryID'];
			
			if($StoreCategoryID != ''){
				$StoreCategory	= '<Storefront><StoreCategoryID>'.$StoreCategoryID.'</StoreCategoryID></Storefront>';
			}
			
			
			$Location			= $ss[0]['Location'];
			$DispatchTimeMax							= $ss[0]['DispatchTimeMax']?$ss[0]['DispatchTimeMax']:1;
			$img001										= $ss[0]['PictureURL01'];
			$img002										= $ss[0]['PictureURL02'];
			$img003										= $ss[0]['PictureURL03'];
			$img004										= $ss[0]['PictureURL04'];
			$ebay_listingreturnmethodid					= $ss[0]['ebay_listingreturnmethodid'];
			$ebay_shippingtempate						= $ss[0]['ebay_listingshippingmethodid'];

			
			$ss		= "select * from ebay_listingreturnmethod where id='$ebay_listingreturnmethodid' ";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			
			$ReturnsAcceptedOption				= $ss[0]['ReturnsAcceptedOption'];
			$RefundOption						= $ss[0]['RefundOption'];
			$ReturnsWithinOption				= $ss[0]['ReturnsWithinOption'];
			$ShippingCostPaidByOption			= $ss[0]['ShippingCostPaidByOption'];
			$TDescription						= $ss[0]['Description'];
		
			
			
			$token				= geteBayaccountToken($ebay_account);
			
			
				/* 取得运费模板 */
			 $ss		= "select * from ebay_shippingtemplate where id='$ebay_shippingtempate' ";
			 $ss		= $dbcon->execute($ss);
			 $ss		= $dbcon->getResultArray($ss);
			 
			 $service0					= $ss[0]['service0'];
			 $serviceshippingfee		= $ss[0]['serviceshippingfee'];
			 $serviceshippingfeecost	= $ss[0]['serviceshippingfeecost'];
			 if($service0 !='' && $serviceshippingfee !='' && $serviceshippingfeecost !=''){
				
			 	$tstr		= '  <ShippingServiceOptions>
       			 <ShippingServicePriority>1</ShippingServicePriority>
        		<ShippingService>'.$service0.'</ShippingService>
       <ShippingServiceCost>'.$serviceshippingfeecost.'</ShippingServiceCost>
	   <ShippingServiceAdditionalCost>'.$serviceshippingfeecost.'</ShippingServiceAdditionalCost>
      </ShippingServiceOptions>';
	  
			 
			 }
			 
			 $service1					= $ss[0]['service1'];
			 $service1shippingfee		= $ss[0]['service1shippingfee'];
			 $service1shippingfeecost	= $ss[0]['service1shippingfeecost'];
			 if($service1 !='' && $service1shippingfee !='' && $service1shippingfeecost !=''){
			
			 	$tstr		.= '  <ShippingServiceOptions>
        <ShippingServicePriority>2</ShippingServicePriority>
        <ShippingService>'.$service1.'</ShippingService>
       <ShippingServiceCost>'.$service1shippingfee.'</ShippingServiceCost>
	   <ShippingServiceAdditionalCost>'.$service1shippingfeecost.'</ShippingServiceAdditionalCost>
      </ShippingServiceOptions>';
	  
			 
			 }
			 
			 $service2					= $ss[0]['service2'];
			 $service2shippingfee		= $ss[0]['service2shippingfee'];
			 $service2shippingfeecost	= $ss[0]['service2shippingfeecost'];
			 if($service2 !='' && $service2shippingfee !='' && $service2shippingfeecost !=''){
			
			 	$tstr		.= '  <ShippingServiceOptions>
        <ShippingServicePriority>3</ShippingServicePriority>
        <ShippingService>'.$service2.'</ShippingService>
       <ShippingServiceCost>'.$service2shippingfee.'</ShippingServiceCost>
	   <ShippingServiceAdditionalCost>'.$service2shippingfeecost.'</ShippingServiceAdditionalCost>
      </ShippingServiceOptions>';
	  
			 
			 }
			 
			 
			 $nservice0					= $ss[0]['nservice0'];
			 $nserviceshippingfee		= $ss[0]['nserviceshippingfee'];
			 $nserviceshippingfeecost	= $ss[0]['nserviceshippingfeecost'];
			 $d0						= $ss[0]['d0'];
			 $d1						= $ss[0]['d1'];
			 $d2						= $ss[0]['d2'];
			 $d3						= $ss[0]['d3'];
			 if($nservice0 !='' && $nserviceshippingfee !='' && $nserviceshippingfeecost !=''){
				
				
				$tline					= '';
				if($d0 != '') $tline	.= '<ShipToLocation>'.$d0.'</ShipToLocation>';
				if($d1 != '') $tline	.= '<ShipToLocation>'.$d1.'</ShipToLocation>';
				if($d2 != '') $tline	.= '<ShipToLocation>'.$d2.'</ShipToLocation>';
				if($d3 != '') $tline	.= '<ShipToLocation>'.$d3.'</ShipToLocation>';
				
			 	$ntstr		.= '<InternationalShippingServiceOption>
        <ShippingService>'.$nservice0.'</ShippingService>
        <ShippingServiceAdditionalCost>'.$nserviceshippingfeecost.'</ShippingServiceAdditionalCost>
        <ShippingServiceCost>'.$nserviceshippingfee.'</ShippingServiceCost>
        <ShippingServicePriority>1</ShippingServicePriority>
        '.$tline.'
      </InternationalShippingServiceOption>
    ';
	  
			 
			 }
			 
			 
			 $nservice1					= $ss[0]['nservice1'];
			 $nservices1hippingfee		= $ss[0]['nservices1hippingfee'];
			 $nservices1hippingfeecost	= $ss[0]['nservices1hippingfeecost'];
			 $dd0						= $ss[0]['dd0'];
			 $dd1						= $ss[0]['dd1'];
			 $dd2						= $ss[0]['dd2'];
			 $dd3						= $ss[0]['dd3'];
			 if($nservice1 !='' && $nservices1hippingfee !='' && $nservices1hippingfeecost !=''){
				
				
				$tline					= '';
				if($dd0 != '') $tline	.= '<ShipToLocation>'.$dd0.'</ShipToLocation>';
				if($dd1 != '') $tline	.= '<ShipToLocation>'.$dd1.'</ShipToLocation>';
				if($dd2 != '') $tline	.= '<ShipToLocation>'.$dd2.'</ShipToLocation>';
				if($dd3 != '') $tline	.= '<ShipToLocation>'.$dd3.'</ShipToLocation>';
				
			 	$ntstr		.= '<InternationalShippingServiceOption>
        <ShippingService>'.$nservice1.'</ShippingService>
        <ShippingServiceAdditionalCost>'.$nservices1hippingfeecost.'</ShippingServiceAdditionalCost>
        <ShippingServiceCost>'.$nservices1hippingfee.'</ShippingServiceCost>
        <ShippingServicePriority>1</ShippingServicePriority>
        '.$tline.'
      </InternationalShippingServiceOption>
    ';
	  
			 
			 }
			 
			 
			 $nservice2					= $ss[0]['nservice2'];
			 $nservice2shippingfee		= $ss[0]['nservice2shippingfee'];
			 $nservices2hippingfeecost	= $ss[0]['nservices2hippingfeecost'];
			 $ddd0						= $ss[0]['ddd0'];
			 $ddd1						= $ss[0]['ddd1'];
			 $ddd2						= $ss[0]['ddd2'];
			 $ddd3						= $ss[0]['ddd3'];
			 if($nservice2 !='' && $nservice2shippingfee !='' && $nservices2hippingfeecost !=''){
				
				
				$tline					= '';
				if($ddd0 != '') $tline	.= '<ShipToLocation>'.$ddd0.'</ShipToLocation>';
				if($ddd1 != '') $tline	.= '<ShipToLocation>'.$ddd1.'</ShipToLocation>';
				if($ddd2 != '') $tline	.= '<ShipToLocation>'.$ddd2.'</ShipToLocation>';
				if($ddd3 != '') $tline	.= '<ShipToLocation>'.$ddd3.'</ShipToLocation>';
				
			 	$ntstr		.= '<InternationalShippingServiceOption>
        <ShippingService>'.$nservice2.'</ShippingService>
        <ShippingServiceAdditionalCost>'.$nservices2hippingfeecost.'</ShippingServiceAdditionalCost>
        <ShippingServiceCost>'.$nservice2shippingfee.'</ShippingServiceCost>
        <ShippingServicePriority>1</ShippingServicePriority>
        '.$tline.'
      </InternationalShippingServiceOption>
    ';
	  
			 
			 }
			 
			
			 $l01						= $ss[0]['l01'];
			 $l02						= $ss[0]['l02'];
			 $l03						= $ss[0]['l03'];
			 $l04						= $ss[0]['l04'];
			 $l05						= $ss[0]['l05'];
			 $l06						= $ss[0]['l06'];
			 $l07						= $ss[0]['l07'];
			 $l08						= $ss[0]['l08'];
			 $l09						= $ss[0]['l09'];
			 $l10						= $ss[0]['l10'];
			 $lstr						= '';
			 
			 if($l01 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l01.'</ExcludeShipToLocation>';
			 if($l02 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l02.'</ExcludeShipToLocation>';
			 if($l03 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l03.'</ExcludeShipToLocation>';
			 if($l04 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l04.'</ExcludeShipToLocation>';
			 if($l05 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l05.'</ExcludeShipToLocation>';
			 if($l06 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l06.'</ExcludeShipToLocation>';
			 if($l07 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l07.'</ExcludeShipToLocation>';
			 if($l08 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l08.'</ExcludeShipToLocation>';
			 if($l09 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l09.'</ExcludeShipToLocation>';
			 if($l10 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l10.'</ExcludeShipToLocation>';
			 
			 /* 检查多属性产品 */
			$ss		= "select * from ebay_listvarious where sid='$id' ";
			
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			
			$name0	= $ss[0]['name0'];
			$name1	= $ss[0]['name1'];
			$name2	= $ss[0]['name2'];
			$name3	= $ss[0]['name3'];
			$name4	= $ss[0]['name4'];
			$pid	= $ss[0]['id'];
			$name0arry = array();
			$name1arry = array();
			$name2arry = array();
			$name3arry = array();
			$name4arry = array();
			
			
			/* 检查多属性产品的值 */
			
			$ss		= "select value0 from ebay_listvariousdetails where pid='$pid' group by value0";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			for($i=0;$i<count($ss);$i++){
				$name0arry[$i] = $ss[$i]['value0'];
			}
			
			$ss		= "select value1 from ebay_listvariousdetails where pid='$pid' group by value1";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			for($i=0;$i<count($ss);$i++){
				$name1arry[$i] = $ss[$i]['value1'];
			}
			
			$ss		= "select value2 from ebay_listvariousdetails where pid='$pid' group by value2";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			
			for($i=0;$i<count($ss);$i++){
				$name2arry[$i] = $ss[$i]['value2'];
			}
			
			$ss		= "select value3 from ebay_listvariousdetails where pid='$pid' group by value3";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			for($i=0;$i<count($ss);$i++){
				$name3arry[$i] = $ss[$i]['value3'];
			}
			
			$ss		= "select value0 from ebay_listvariousdetails where pid='$pid' group by value4";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			for($i=0;$i<count($ss);$i++){
				$name4arry[$i] = $ss[$i]['value4'];
			}
			
			

			
			$tvarname	= '';
			if($name0 != '' && count($name0arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name0arry);$i++){
					$tvarvalue	.= '<Value>'.$name0arry[$i].'</Value>';
				}
				$tvarname	= '<NameValueList><Name>'.$name0.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			
			if($name1 != '' && count($name1arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name1arry);$i++){
					$tvarvalue	.= '<Value>'.$name1arry[$i].'</Value>';
				}
				$tvarname	.= '<NameValueList><Name>'.$name1.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			
			if($name2 != '' && count($name2arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name2arry);$i++){
					$tvarvalue	.= '<Value>'.$name2arry[$i].'</Value>';
				}
				$tvarname	.= '<NameValueList><Name>'.$name2.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			
			if($name3 != '' && count($name3arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name3arry);$i++){
					$tvarvalue	.= '<Value>'.$name3arry[$i].'</Value>';
				}
				$tvarname	.= '<NameValueList><Name>'.$name3.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			
			if($name4 != '' && count($name4arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name4arry);$i++){
					$tvarvalue	.= '<Value>'.$name4arry[$i].'</Value>';
				}
				$tvarname	.= '<NameValueList><Name>'.$name4.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			$tvarname		= fstr_rep($tvarname);
			
			
			$ss		= "select * from ebay_listvariousdetails where pid='$pid' ";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			$varline	= '';
			$varpic		= '';
			
			
			for($i=0;$i<count($ss);$i++){
				
				$sku		= $ss[$i]['sku'];
				$value0		= $ss[$i]['value0'];
				$value1		= $ss[$i]['value1'];
				$value2		= $ss[$i]['value2'];
				$value3		= $ss[$i]['value3'];
				$value4		= $ss[$i]['value4'];
				$price		= $ss[$i]['price'];
				$picture	= $ss[$i]['picture'];
				$qty		= $ss[$i]['qty'];
			
				
				
				$tvar0		= " <Variation>
        		<SKU>".$sku."</SKU>
        		<StartPrice>".$price."</StartPrice>
        		<Quantity>".$qty."</Quantity>
				<VariationSpecifics>
				";
				
				$var1		= '';
				if($name0 != '' && $value0 != ''){
				
				$name0		 = fstr_rep($name0);
				$var1		.= "<NameValueList><Name>".$name0."</Name><Value>".$value0."</Value></NameValueList>";
				
				if($picture != ''){
				$varpic		 .= " 
        						 <VariationSpecificPictureSet>
          						 <VariationSpecificValue>".$value0."</VariationSpecificValue>
          						 <PictureURL>".$picture."</PictureURL>
        						 </VariationSpecificPictureSet>";
				}
				
				}
				
				if($name1 != '' && $value1 != ''){
				$name1		 = fstr_rep($name1);
				$var1		.= "<NameValueList><Name>".$name1."</Name><Value>".$value1."</Value></NameValueList>";
				}
				if($name2 != '' && $value2 != ''){
				$name2		 = fstr_rep($name2);
				$var1		.= "<NameValueList><Name>".$name2."</Name><Value>".$value2."</Value></NameValueList>";
				}
				
				if($name3 != '' && $value3 != ''){
				$name3		 = fstr_rep($name3);
				$var1		.= "<NameValueList><Name>".$name3."</Name><Value>".$value3."</Value></NameValueList>";
				}
				
				if($name4 != '' && $value4 != ''){
				$name4		 = fstr_rep($name4);
				$var1		.= "<NameValueList><Name>".$name4."</Name><Value>".$value4."</Value></NameValueList>";
				}
				
				
				$varline	.= $tvar0.$var1.'</VariationSpecifics></Variation>';
				
        		
        		
				
			}
			
			
			$varpic		= '<Pictures>'."<VariationSpecificName>".$name0."</VariationSpecificName>".$varpic.'</Pictures>';
			
			if($tvarname != ''){
				$variations				= "
			  <Variations>
      <VariationSpecificsSet>
    ".$tvarname."
      </VariationSpecificsSet>
    ".$varline.$varpic."
     
    </Variations>
			";
			}

			 $namevaluelist		= '';
			 $ss				= "select * from ebay_itemspecifics where sid ='$id'";
			 $ss				= $dbcon->execute($ss);
			 $ss				= $dbcon->getResultArray($ss);
			 
			for($i=0;$i<count($ss);$i++){
			 
				
				$keys			=$ss[$i]['name'];
				$value			= fstr_rep($ss[$i]['value']);
				/* 检查此keys是否存在于多属性当中 */
				
				$yy		= "select * from ebay_listvarious where name0='$keys' or name1='$keys' or name2='$keys' or name3='$keys' or name4='$keys' ";
			

				$yy				= $dbcon->execute($yy);
				$yy				= $dbcon->getResultArray($yy);
				$keys			= fstr_rep($ss[$i]['name']);
				if(count($yy) ==0 ){
				$namevaluelist		.= '<NameValueList>
			 	<Name>'.$keys.'</Name>
			 	<Value>'.$value.'</Value>
      			 </NameValueList>';
				}
				
				
			 } 
			 
			 

			 $itemspecific			= '<ItemSpecifics>'.$namevaluelist.'</ItemSpecifics>';
	
	
			
			$xmlRequest		= '<?xml version="1.0" encoding="utf-8"?>
			<AddFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
			<ErrorLanguage>en_US</ErrorLanguage>
  			<WarningLevel>High</WarningLevel>
  			<Item>
			'.$StoreCategory.'
    		<ItemID>'.$ItemID.'</ItemID>
    		<SKU>'.$SKU.'</SKU>
			<Title>'.$Title.'</Title>
   			<Description><![CDATA['.$Description.']]></Description>    		
		    <PrimaryCategory><CategoryID>'.$CategoryID.'</CategoryID></PrimaryCategory>
    		<StartPrice>'.$StartPrice.'</StartPrice>';
			if($ReservePrice != '') 		$xmlRequest .= '<ReservePrice currencyID="USD">'.$ReservePrice.'</ReservePrice>';
			if($ListingType == 'Chinese') 	$xmlRequest .= '<BuyItNowPrice currencyID="USD">'.$BuyItNowPrice.'</BuyItNowPrice> ';
			if($Quantity > 0) 				$xmlRequest .= '<Quantity>'.$Quantity.'</Quantity>';
			
			$xmlRequest	.= '			
    		<ConditionID>'.$condition.'</ConditionID>
   			<CategoryMappingAllowed>true</CategoryMappingAllowed>
    		<Country>'.$Country.'</Country>'.$itemspecific.$variations.'
    		<Currency>USD</Currency>
			<Location>'.$Location.'</Location>
    		<DispatchTimeMax>'.$DispatchTimeMax.'</DispatchTimeMax>
    		<ListingDuration>'.$ListingDuration.'</ListingDuration>
    		<PaymentMethods>PayPal</PaymentMethods>
   			<PayPalEmailAddress>'.$PayPalEmailAddress.'</PayPalEmailAddress>
	 		<PictureDetails>
	  		<GalleryType>Gallery</GalleryType>';
	  
	  
	  		if($img001 != '') $xmlRequest .= '<PictureURL>'.$img001.'</PictureURL>';
	 		if($img002 != '') $xmlRequest .= '<PictureURL>'.$img002.'</PictureURL>';
	 		if($img003 != '') $xmlRequest .= '<PictureURL>'.$img003.'</PictureURL>';
	 		if($img004 != '') $xmlRequest .= '<PictureURL>'.$img004.'</PictureURL>';
	  
	  		$xmlRequest .='
    		</PictureDetails>
    		<PostalCode>95125</PostalCode>
    		<ReturnPolicy>
      		<ReturnsAcceptedOption>'.$ReturnsAcceptedOption.'</ReturnsAcceptedOption>
      		<RefundOption>'.$RefundOption.'</RefundOption>
      		<ReturnsWithinOption>'.$ReturnsWithinOption.'</ReturnsWithinOption>
      		<Description>'.$TDescription.'</Description>
      		<ShippingCostPaidByOption>'.$ShippingCostPaidByOption.'</ShippingCostPaidByOption>
    		</ReturnPolicy>
	
   			<ShippingDetails>
      		<ShippingType>Flat</ShippingType>
    		'.$tstr.$ntstr.$lstr.'
   			 </ShippingDetails>
  			</Item>
  			<RequesterCredentials>
   			<eBayAuthToken>'.$token.'</eBayAuthToken>
  			</RequesterCredentials>
  			<WarningLevel>High</WarningLevel>
			</AddFixedPriceItemRequest>

			';

			
			 $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);

			 $responseXml = $session->sendHttpRequest($xmlRequest);		
			 
			 if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';

			 $data=XML_unserialize($responseXml); 
			 
			 $ack		= $data['AddFixedPriceItemResponse']['Ack'];
			 
			 if($ack != 'Failure'){
				 
				 $LongMessage		= $data['AddFixedPriceItemResponse']['Errors'];
				 if($data['AddFixedPriceItemResponse']['Errors']['LongMessage'] == ''){
					for($i=0;$i<count($LongMessage);$i++){
						echo '<br><font color="#FF0000">'.$data['AddFixedPriceItemResponse']['Errors'][$i]['LongMessage'].'</font>';
					}
					 
				 }else{
					 echo '<br><font color="#FF0000">'.$data['AddFixedPriceItemResponse']['Errors']['LongMessage'].'</font>';
				 }
				 $ItemID			= $data['AddFixedPriceItemResponse']['ItemID'];
				 echo '<br>Item Number: '.$ItemID.' 发布产品到eBay 成功';

				
				
				
			 }else{
				 
					
					 $LongMessage		= $data['AddFixedPriceItemResponse']['Errors']['LongMessage'];
					 
				 if($data['AddFixedPriceItemResponse']['Errors']['LongMessage'] == ''){
					for($i=0;$i<count($LongMessage);$i++){
						echo '<br><font color="#FF0000">'.$data['AddFixedPriceItemResponse']['Errors'][$i]['LongMessage'].'</font>';
					}
					 
				 }else{
					 echo '<br><font color="#FF0000">'.$data['AddFixedPriceItemResponse']['Errors']['LongMessage'].'</font>';
					 echo 'ggggggggg';
				 }
				 
				 
				 
			 }
			 
			 
		
		
		
		
		
		}
		
		function LAddFixedPriceItem($id){
			
			
			$verb = 'AddFixedPriceItem';
			global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$dbcon;
			
			
			$ss			= "select * from ebay_list where id='$id'";
			$ss			= $dbcon->execute($ss);
			$ss			= $dbcon->getResultArray($ss);
			
			
			$PayPalEmailAddress	= $ss[0]['PayPalEmailAddress'];
			$Title				= $ss[0]['Title'];
			$SKU				= $ss[0]['SKU'];
			$ItemID				= $ss[0]['ItemID'];
			$ListingType		= $ss[0]['ListingType'];
			$ListingDuration	= $ss[0]['ListingDuration'];
			$Description		= $ss[0]['Description'];
			$ebay_account		= $ss[0]['ebay_account'];
			$StartPrice			= $ss[0]['StartPrice'];
			$ReservePrice		= $ss[0]['ReservePrice'];
			$Quantity			= $ss[0]['Quantity'];
			$condition			= $ss[0]['ConditionID'];
			$Country			= $ss[0]['Country'];
			$BuyItNowPrice		= $ss[0]['BuyItNowPrice'];
			$CategoryID			= $ss[0]['CategoryID'];
			
			
			$StoreCategoryID	= $ss[0]['StoreCategoryID'];
			
			if($StoreCategoryID != ''){
				$StoreCategory	= '<Storefront><StoreCategoryID>'.$StoreCategoryID.'</StoreCategoryID></Storefront>';
			}
			
			
			$Location			= $ss[0]['Location'];
			$DispatchTimeMax							= $ss[0]['DispatchTimeMax']?$ss[0]['DispatchTimeMax']:1;
			$img001										= $ss[0]['PictureURL01'];
			$img002										= $ss[0]['PictureURL02'];
			$img003										= $ss[0]['PictureURL03'];
			$img004										= $ss[0]['PictureURL04'];
			$ebay_listingreturnmethodid					= $ss[0]['ebay_listingreturnmethodid'];
			$ebay_shippingtempate						= $ss[0]['ebay_listingshippingmethodid'];

			
			$ss		= "select * from ebay_listingreturnmethod where id='$ebay_listingreturnmethodid' ";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			
			$ReturnsAcceptedOption				= $ss[0]['ReturnsAcceptedOption'];
			$RefundOption						= $ss[0]['RefundOption'];
			$ReturnsWithinOption				= $ss[0]['ReturnsWithinOption'];
			$ShippingCostPaidByOption			= $ss[0]['ShippingCostPaidByOption'];
			$TDescription						= $ss[0]['Description'];
		
			
			
			$token				= geteBayaccountToken($ebay_account);
			
			
				/* 取得运费模板 */
			 $ss		= "select * from ebay_shippingtemplate where id='$ebay_shippingtempate' ";
			 $ss		= $dbcon->execute($ss);
			 $ss		= $dbcon->getResultArray($ss);
			 
			 $service0					= $ss[0]['service0'];
			 $serviceshippingfee		= $ss[0]['serviceshippingfee'];
			 $serviceshippingfeecost	= $ss[0]['serviceshippingfeecost'];
			 if($service0 !='' && $serviceshippingfee !='' && $serviceshippingfeecost !=''){
				
			 	$tstr		= '  <ShippingServiceOptions>
       			 <ShippingServicePriority>1</ShippingServicePriority>
        		<ShippingService>'.$service0.'</ShippingService>
       <ShippingServiceCost>'.$serviceshippingfeecost.'</ShippingServiceCost>
	   <ShippingServiceAdditionalCost>'.$serviceshippingfeecost.'</ShippingServiceAdditionalCost>
      </ShippingServiceOptions>';
	  
			 
			 }
			 
			 $service1					= $ss[0]['service1'];
			 $service1shippingfee		= $ss[0]['service1shippingfee'];
			 $service1shippingfeecost	= $ss[0]['service1shippingfeecost'];
			 if($service1 !='' && $service1shippingfee !='' && $service1shippingfeecost !=''){
			
			 	$tstr		.= '  <ShippingServiceOptions>
        <ShippingServicePriority>2</ShippingServicePriority>
        <ShippingService>'.$service1.'</ShippingService>
       <ShippingServiceCost>'.$service1shippingfee.'</ShippingServiceCost>
	   <ShippingServiceAdditionalCost>'.$service1shippingfeecost.'</ShippingServiceAdditionalCost>
      </ShippingServiceOptions>';
	  
			 
			 }
			 
			 $service2					= $ss[0]['service2'];
			 $service2shippingfee		= $ss[0]['service2shippingfee'];
			 $service2shippingfeecost	= $ss[0]['service2shippingfeecost'];
			 if($service2 !='' && $service2shippingfee !='' && $service2shippingfeecost !=''){
			
			 	$tstr		.= '  <ShippingServiceOptions>
        <ShippingServicePriority>3</ShippingServicePriority>
        <ShippingService>'.$service2.'</ShippingService>
       <ShippingServiceCost>'.$service2shippingfee.'</ShippingServiceCost>
	   <ShippingServiceAdditionalCost>'.$service2shippingfeecost.'</ShippingServiceAdditionalCost>
      </ShippingServiceOptions>';
	  
			 
			 }
			 
			 
			 $nservice0					= $ss[0]['nservice0'];
			 $nserviceshippingfee		= $ss[0]['nserviceshippingfee'];
			 $nserviceshippingfeecost	= $ss[0]['nserviceshippingfeecost'];
			 $d0						= $ss[0]['d0'];
			 $d1						= $ss[0]['d1'];
			 $d2						= $ss[0]['d2'];
			 $d3						= $ss[0]['d3'];
			 if($nservice0 !='' && $nserviceshippingfee !='' && $nserviceshippingfeecost !=''){
				
				
				$tline					= '';
				if($d0 != '') $tline	.= '<ShipToLocation>'.$d0.'</ShipToLocation>';
				if($d1 != '') $tline	.= '<ShipToLocation>'.$d1.'</ShipToLocation>';
				if($d2 != '') $tline	.= '<ShipToLocation>'.$d2.'</ShipToLocation>';
				if($d3 != '') $tline	.= '<ShipToLocation>'.$d3.'</ShipToLocation>';
				
			 	$ntstr		.= '<InternationalShippingServiceOption>
        <ShippingService>'.$nservice0.'</ShippingService>
        <ShippingServiceAdditionalCost>'.$nserviceshippingfeecost.'</ShippingServiceAdditionalCost>
        <ShippingServiceCost>'.$nserviceshippingfee.'</ShippingServiceCost>
        <ShippingServicePriority>1</ShippingServicePriority>
        '.$tline.'
      </InternationalShippingServiceOption>
    ';
	  
			 
			 }
			 
			 
			 $nservice1					= $ss[0]['nservice1'];
			 $nservices1hippingfee		= $ss[0]['nservices1hippingfee'];
			 $nservices1hippingfeecost	= $ss[0]['nservices1hippingfeecost'];
			 $dd0						= $ss[0]['dd0'];
			 $dd1						= $ss[0]['dd1'];
			 $dd2						= $ss[0]['dd2'];
			 $dd3						= $ss[0]['dd3'];
			 if($nservice1 !='' && $nservices1hippingfee !='' && $nservices1hippingfeecost !=''){
				
				
				$tline					= '';
				if($dd0 != '') $tline	.= '<ShipToLocation>'.$dd0.'</ShipToLocation>';
				if($dd1 != '') $tline	.= '<ShipToLocation>'.$dd1.'</ShipToLocation>';
				if($dd2 != '') $tline	.= '<ShipToLocation>'.$dd2.'</ShipToLocation>';
				if($dd3 != '') $tline	.= '<ShipToLocation>'.$dd3.'</ShipToLocation>';
				
			 	$ntstr		.= '<InternationalShippingServiceOption>
        <ShippingService>'.$nservice1.'</ShippingService>
        <ShippingServiceAdditionalCost>'.$nservices1hippingfeecost.'</ShippingServiceAdditionalCost>
        <ShippingServiceCost>'.$nservices1hippingfee.'</ShippingServiceCost>
        <ShippingServicePriority>1</ShippingServicePriority>
        '.$tline.'
      </InternationalShippingServiceOption>
    ';
	  
			 
			 }
			 
			 
			 $nservice2					= $ss[0]['nservice2'];
			 $nservice2shippingfee		= $ss[0]['nservice2shippingfee'];
			 $nservices2hippingfeecost	= $ss[0]['nservices2hippingfeecost'];
			 $ddd0						= $ss[0]['ddd0'];
			 $ddd1						= $ss[0]['ddd1'];
			 $ddd2						= $ss[0]['ddd2'];
			 $ddd3						= $ss[0]['ddd3'];
			 if($nservice2 !='' && $nservice2shippingfee !='' && $nservices2hippingfeecost !=''){
				
				
				$tline					= '';
				if($ddd0 != '') $tline	.= '<ShipToLocation>'.$ddd0.'</ShipToLocation>';
				if($ddd1 != '') $tline	.= '<ShipToLocation>'.$ddd1.'</ShipToLocation>';
				if($ddd2 != '') $tline	.= '<ShipToLocation>'.$ddd2.'</ShipToLocation>';
				if($ddd3 != '') $tline	.= '<ShipToLocation>'.$ddd3.'</ShipToLocation>';
				
			 	$ntstr		.= '<InternationalShippingServiceOption>
        <ShippingService>'.$nservice2.'</ShippingService>
        <ShippingServiceAdditionalCost>'.$nservices2hippingfeecost.'</ShippingServiceAdditionalCost>
        <ShippingServiceCost>'.$nservice2shippingfee.'</ShippingServiceCost>
        <ShippingServicePriority>1</ShippingServicePriority>
        '.$tline.'
      </InternationalShippingServiceOption>
    ';
	  
			 
			 }
			 
			
			 $l01						= $ss[0]['l01'];
			 $l02						= $ss[0]['l02'];
			 $l03						= $ss[0]['l03'];
			 $l04						= $ss[0]['l04'];
			 $l05						= $ss[0]['l05'];
			 $l06						= $ss[0]['l06'];
			 $l07						= $ss[0]['l07'];
			 $l08						= $ss[0]['l08'];
			 $l09						= $ss[0]['l09'];
			 $l10						= $ss[0]['l10'];
			 $lstr						= '';
			 
			 if($l01 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l01.'</ExcludeShipToLocation>';
			 if($l02 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l02.'</ExcludeShipToLocation>';
			 if($l03 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l03.'</ExcludeShipToLocation>';
			 if($l04 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l04.'</ExcludeShipToLocation>';
			 if($l05 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l05.'</ExcludeShipToLocation>';
			 if($l06 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l06.'</ExcludeShipToLocation>';
			 if($l07 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l07.'</ExcludeShipToLocation>';
			 if($l08 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l08.'</ExcludeShipToLocation>';
			 if($l09 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l09.'</ExcludeShipToLocation>';
			 if($l10 != '') $lstr   .= ' <ExcludeShipToLocation>'.$l10.'</ExcludeShipToLocation>';
			 
			 /* 检查多属性产品 */
			$ss		= "select * from ebay_listvarious where sid='$id' ";
			
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			
			$name0	= $ss[0]['name0'];
			$name1	= $ss[0]['name1'];
			$name2	= $ss[0]['name2'];
			$name3	= $ss[0]['name3'];
			$name4	= $ss[0]['name4'];
			$pid	= $ss[0]['id'];
			$name0arry = array();
			$name1arry = array();
			$name2arry = array();
			$name3arry = array();
			$name4arry = array();
			
			
			/* 检查多属性产品的值 */
			
			$ss		= "select value0 from ebay_listvariousdetails where pid='$pid' group by value0";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			for($i=0;$i<count($ss);$i++){
				$name0arry[$i] = $ss[$i]['value0'];
			}
			
			$ss		= "select value1 from ebay_listvariousdetails where pid='$pid' group by value1";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			for($i=0;$i<count($ss);$i++){
				$name1arry[$i] = $ss[$i]['value1'];
			}
			
			$ss		= "select value2 from ebay_listvariousdetails where pid='$pid' group by value2";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			
			for($i=0;$i<count($ss);$i++){
				$name2arry[$i] = $ss[$i]['value2'];
			}
			
			$ss		= "select value3 from ebay_listvariousdetails where pid='$pid' group by value3";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			for($i=0;$i<count($ss);$i++){
				$name3arry[$i] = $ss[$i]['value3'];
			}
			
			$ss		= "select value0 from ebay_listvariousdetails where pid='$pid' group by value4";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			for($i=0;$i<count($ss);$i++){
				$name4arry[$i] = $ss[$i]['value4'];
			}
			
			

			
			$tvarname	= '';
			if($name0 != '' && count($name0arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name0arry);$i++){
					$tvarvalue	.= '<Value>'.$name0arry[$i].'</Value>';
				}
				$tvarname	= '<NameValueList><Name>'.$name0.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			
			if($name1 != '' && count($name1arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name1arry);$i++){
					$tvarvalue	.= '<Value>'.$name1arry[$i].'</Value>';
				}
				$tvarname	.= '<NameValueList><Name>'.$name1.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			
			if($name2 != '' && count($name2arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name2arry);$i++){
					$tvarvalue	.= '<Value>'.$name2arry[$i].'</Value>';
				}
				$tvarname	.= '<NameValueList><Name>'.$name2.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			
			if($name3 != '' && count($name3arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name3arry);$i++){
					$tvarvalue	.= '<Value>'.$name3arry[$i].'</Value>';
				}
				$tvarname	.= '<NameValueList><Name>'.$name3.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			
			if($name4 != '' && count($name4arry)>0){
				$tvarvalue	= '';
				for($i=0;$i<count($name4arry);$i++){
					$tvarvalue	.= '<Value>'.$name4arry[$i].'</Value>';
				}
				$tvarname	.= '<NameValueList><Name>'.$name4.'</Name>'.$tvarvalue.'</NameValueList>';
			}
			$tvarname		= fstr_rep($tvarname);
			

			
			$ss		= "select * from ebay_listvariousdetails where pid='$pid' ";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			$varline	= '';
			$varpic		= '';
			
			
			for($i=0;$i<count($ss);$i++){
				
				$sku		= $ss[$i]['sku'];
				$value0		= $ss[$i]['value0'];
				$value1		= $ss[$i]['value1'];
				$value2		= $ss[$i]['value2'];
				$value3		= $ss[$i]['value3'];
				$value4		= $ss[$i]['value4'];
				$price		= $ss[$i]['price'];
				$picture	= $ss[$i]['picture'];
				$qty		= $ss[$i]['qty'];
			
				
				
				$tvar0		= " <Variation>
        		<SKU>".$sku."</SKU>
        		<StartPrice>".$price."</StartPrice>
        		<Quantity>".$qty."</Quantity>
				<VariationSpecifics>
				";
				
				$var1		= '';
				if($name0 != '' && $value0 != ''){
				
				$name0		 = fstr_rep($name0);
				$var1		.= "<NameValueList><Name>".$name0."</Name><Value>".$value0."</Value></NameValueList>";
				
				if($picture != ''){
				$varpic		 .= " 
        						 <VariationSpecificPictureSet>
          						 <VariationSpecificValue>".$value0."</VariationSpecificValue>
          						 <PictureURL>".$picture."</PictureURL>
        						 </VariationSpecificPictureSet>";
				}
				
				}
				
				if($name1 != '' && $value1 != ''){
				$name1		 = fstr_rep($name1);
				$var1		.= "<NameValueList><Name>".$name1."</Name><Value>".$value1."</Value></NameValueList>";
				}
				if($name2 != '' && $value2 != ''){
				$name2		 = fstr_rep($name2);
				$var1		.= "<NameValueList><Name>".$name2."</Name><Value>".$value2."</Value></NameValueList>";
				}
				
				if($name3 != '' && $value3 != ''){
				$name3		 = fstr_rep($name3);
				$var1		.= "<NameValueList><Name>".$name3."</Name><Value>".$value3."</Value></NameValueList>";
				}
				
				if($name4 != '' && $value4 != ''){
				$name4		 = fstr_rep($name4);
				$var1		.= "<NameValueList><Name>".$name4."</Name><Value>".$value4."</Value></NameValueList>";
				}
				
				
				$varline	.= $tvar0.$var1.'</VariationSpecifics></Variation>';
				
        		
        		
				
			}
			
			
			$varpic		= '<Pictures>'."<VariationSpecificName>".$name0."</VariationSpecificName>".$varpic.'</Pictures>';
			
			if($tvarname != ''){
				$variations				= "
			  <Variations>
      <VariationSpecificsSet>
    ".$tvarname."
      </VariationSpecificsSet>
    ".$varline.$varpic."
     
    </Variations>
			";
			}

			 $namevaluelist		= '';
			 $ss				= "select * from ebay_itemspecifics where sid ='$id'";
			 $ss				= $dbcon->execute($ss);
			 $ss				= $dbcon->getResultArray($ss);
			 
			for($i=0;$i<count($ss);$i++){
			 
				
				$keys			=$ss[$i]['name'];
				$value			= fstr_rep($ss[$i]['value']);
				/* 检查此keys是否存在于多属性当中 */
				
				$yy		= "select * from ebay_listvarious where name0='$keys' or name1='$keys' or name2='$keys' or name3='$keys' or name4='$keys' ";
			

				$yy				= $dbcon->execute($yy);
				$yy				= $dbcon->getResultArray($yy);
				$keys			= fstr_rep($ss[$i]['name']);
				if(count($yy) ==0 ){
				$namevaluelist		.= '<NameValueList>
			 	<Name>'.$keys.'</Name>
			 	<Value>'.$value.'</Value>
      			 </NameValueList>';
				}
				
				
			 } 
			 
			 

			 $itemspecific			= '<ItemSpecifics>'.$namevaluelist.'</ItemSpecifics>';
	
	
			
			$xmlRequest		= '<?xml version="1.0" encoding="utf-8"?>
			<AddFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
			<ErrorLanguage>en_US</ErrorLanguage>
  			<WarningLevel>High</WarningLevel>
  			<Item>
			'.$StoreCategory.'
    		<ItemID>'.$ItemID.'</ItemID>
    		<SKU>'.$SKU.'</SKU>
			<Title>'.$Title.'</Title>
   			<Description><![CDATA['.$Description.']]></Description>    		
		    <PrimaryCategory><CategoryID>'.$CategoryID.'</CategoryID></PrimaryCategory>
    		<StartPrice>'.$StartPrice.'</StartPrice>';
			if($ReservePrice != '') 		$xmlRequest .= '<ReservePrice currencyID="USD">'.$ReservePrice.'</ReservePrice>';
			if($ListingType == 'Chinese') 	$xmlRequest .= '<BuyItNowPrice currencyID="USD">'.$BuyItNowPrice.'</BuyItNowPrice> ';
			if($Quantity > 0) 				$xmlRequest .= '<Quantity>'.$Quantity.'</Quantity>';
			
			$xmlRequest	.= '			
    		<ConditionID>'.$condition.'</ConditionID>
   			<CategoryMappingAllowed>true</CategoryMappingAllowed>
    		<Country>'.$Country.'</Country>'.$itemspecific.$variations.'
    		<Currency>USD</Currency>
			<Location>'.$Location.'</Location>
    		<DispatchTimeMax>'.$DispatchTimeMax.'</DispatchTimeMax>
    		<ListingDuration>'.$ListingDuration.'</ListingDuration>
    		<PaymentMethods>PayPal</PaymentMethods>
   			<PayPalEmailAddress>'.$PayPalEmailAddress.'</PayPalEmailAddress>
	 		<PictureDetails>
	  		<GalleryType>Gallery</GalleryType>';
	  
	  
	  		if($img001 != '') $xmlRequest .= '<PictureURL>'.$img001.'</PictureURL>';
	 		if($img002 != '') $xmlRequest .= '<PictureURL>'.$img002.'</PictureURL>';
	 		if($img003 != '') $xmlRequest .= '<PictureURL>'.$img003.'</PictureURL>';
	 		if($img004 != '') $xmlRequest .= '<PictureURL>'.$img004.'</PictureURL>';
	  
	  		$xmlRequest .='
    		</PictureDetails>
    		<PostalCode>95125</PostalCode>
    		<ReturnPolicy>
      		<ReturnsAcceptedOption>'.$ReturnsAcceptedOption.'</ReturnsAcceptedOption>
      		<RefundOption>'.$RefundOption.'</RefundOption>
      		<ReturnsWithinOption>'.$ReturnsWithinOption.'</ReturnsWithinOption>
      		<Description>'.$TDescription.'</Description>
      		<ShippingCostPaidByOption>'.$ShippingCostPaidByOption.'</ShippingCostPaidByOption>
    		</ReturnPolicy>
	
   			<ShippingDetails>
      		<ShippingType>Flat</ShippingType>
    		'.$tstr.$ntstr.$lstr.'
   			 </ShippingDetails>
  			</Item>
  			<RequesterCredentials>
   			<eBayAuthToken>'.$token.'</eBayAuthToken>
  			</RequesterCredentials>
  			<WarningLevel>High</WarningLevel>
			</AddFixedPriceItemRequest>

			';

			
			 $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);

			 $responseXml = $session->sendHttpRequest($xmlRequest);		
			 
			 if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';

			 $data=XML_unserialize($responseXml); 
			 
			 $ack		= $data['AddFixedPriceItemResponse']['Ack'];
			 
			 if($ack != 'Failure'){
				 
				 $LongMessage		= $data['AddFixedPriceItemResponse']['Errors'];
				 if($data['AddFixedPriceItemResponse']['Errors']['LongMessage'] == ''){
					for($i=0;$i<count($LongMessage);$i++){
						echo '<br><font color="#FF0000">'.$data['AddFixedPriceItemResponse']['Errors'][$i]['LongMessage'].'</font>';
					}
					 
				 }else{
					 echo '<br><font color="#FF0000">'.$data['AddFixedPriceItemResponse']['Errors']['LongMessage'].'</font>';
				 }
				 $ItemID			= $data['AddFixedPriceItemResponse']['ItemID'];
				 echo '<br>Item Number: '.$ItemID.' 发布产品到eBay 成功';
				$ss			= "update ebay_list set status='4' where id='$id'";
				$dbcon->execute($ss);
				
				
				
			 }else{
				 
					
					 $LongMessage		= $data['AddFixedPriceItemResponse']['Errors']['LongMessage'];
					 
				 if($data['AddFixedPriceItemResponse']['Errors']['LongMessage'] == ''){
					for($i=0;$i<count($LongMessage);$i++){
						echo '<br><font color="#FF0000">'.$data['AddFixedPriceItemResponse']['Errors'][$i]['LongMessage'].'</font>';
					}
					 
				 }else{
					 echo '<br><font color="#FF0000">'.$data['AddFixedPriceItemResponse']['Errors']['LongMessage'].'</font>';
					 
					 
					 echo 'ggggggggg';
					 
				 }
				 
				 
				 
			 }
			 
			 
		
		
		
		
		
		}
		function GetMyeBaySellingsold($account,$token){
			 $verb = 'GetMyeBaySelling';
			 global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$dbcon;
			 $currentpage				= 1;
			 
			 
			 while(true){
			 

			$xmlRequest		= '<?xml version="1.0" encoding="utf-8"?>

			<GetMyeBaySellingRequest xmlns="urn:ebay:apis:eBLBaseComponents">
			  <UnsoldList> ItemListCustomizationType
   			<DurationInDays>10</DurationInDays>
		<Include>true</Include>
    <IncludeNotes>true</IncludeNotes>
    <Pagination> 
    <EntriesPerPage>200</EntriesPerPage>
     		<PageNumber>'.$currentpage.'</PageNumber>
    </Pagination>
  </UnsoldList>
  
  
  			<RequesterCredentials>
    		<eBayAuthToken>'.$token.'</eBayAuthToken>
 			</RequesterCredentials>
  			<WarningLevel>High</WarningLevel>
			</GetMyeBaySellingRequest>';


			 $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);

			 $responseXml = $session->sendHttpRequest($xmlRequest);		

			 if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';

			 $data=XML_unserialize($responseXml); 
	
		
		

			$getorder = $data['GetMyeBaySellingResponse'];  

			$totalpages		 = @$getorder['UnsoldList']['PaginationResult']['TotalNumberOfPages'];
		
			
			
			$Trans = @$getorder['UnsoldList']['ItemArray']['Item'];
			
			$status		= 1;
			
			foreach((array)$Trans as $Transaction){

			
			$StartPrice						= $Transaction['StartPrice'];
			$BuyItNowPricecurrencyID		= $Transaction['BuyItNowPrice attr']['currencyID'];
			$BuyItNowPrice					= $Transaction['BuyItNowPrice'];
			$ItemID							= $Transaction['ItemID'];
			
			

			
			$StartTime						= $Transaction['StartTime'];
			$ViewItemURL					= $Transaction['ViewItemURL'];
			$ExpressListing					= $Transaction['ExpressListing'];
			$ViewItemURLForNaturalSearch	= $Transaction['ViewItemURLForNaturalSearch'];
			$ListingDuration				= $Transaction['ListingDuration'];
			$ListingType					= $Transaction['ListingType'];
			$Quantity						= $Transaction['Quantity'];
			$Quantity						= $Transaction['Quantity'];
			$SellingStatuscurrencyID		= $Transaction['SellingStatus']['CurrentPrice']['currencyID'];
			$SellingStatusCurrentPrice		= $Transaction['SellingStatus']['CurrentPrice'];
			$SellingStatusPromotionalSaleDetailscurrencyID				= $Transaction['SellingStatus']['PromotionalSaleDetails']['OriginalPrice']['currencyID'];
			$SellingStatusPromotionalSaleDetailsOriginalPrice			= $Transaction['SellingStatus']['PromotionalSaleDetails']['OriginalPrice'];
			$SellingStatusPromotionalSaleDetailsOriginalPrice			= $Transaction['SellingStatus']['PromotionalSaleDetails']['OriginalPrice'];
			$SellingStatusPromotionalSaleDetailsStartTime				= $Transaction['SellingStatus']['PromotionalSaleDetails']['StartTime'];
			$SellingStatusPromotionalSaleDetailsEndTime					= $Transaction['SellingStatus']['PromotionalSaleDetails']['EndTime'];
			$ShippingDetailsShippingServiceCostcurrencyID				= $Transaction['ShippingDetails']['ShippingServiceOptions']['ShippingServiceCost attr']['currencyID'];
			$ShippingDetailsShippingServiceCostShippingServiceCost		= $Transaction['ShippingDetails']['ShippingServiceOptions']['ShippingServiceCost'];
			
			$TimeLeft													= $Transaction['TimeLeft'];
			$Title														= $Transaction['Title'];
			$WatchCount													= $Transaction['WatchCount'];
			$QuantityAvailable											= $Transaction['QuantityAvailable'];
			$SKU														= $Transaction['SKU'];
			$PictureDetailsGalleryURL									= $Transaction['PictureDetails']['GalleryURL'];
			
			$ss		= "select * from ebay_list where ItemID='$ItemID' and ebay_account='$account'";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			if(count($ss) == 0){
				
				$ss		  =  "insert into ebay_list(BuyItNowPricecurrencyID,BuyItNowPrice,ItemID,StartTime,ViewItemURL,ExpressListing,ViewItemURLForNaturalSearch,ListingDuration";
				$ss		  .= ",ListingType,Quantity,SellingStatuscurrencyID,SellingStatusCurrentPrice,ShippingServiceCost,TimeLeft,Title,QuantityAvailable,SKU,PictureDetailsGalleryURL";
				$ss		  .= ",status,ebay_account,StartPrice) values('$BuyItNowPricecurrencyID','$BuyItNowPrice','$ItemID','$StartTime','$ViewItemURL','$ExpressListing','$ViewItemURLForNaturalSearch',";
				$ss		  .= "'$ListingDuration','$ListingType','$Quantity','$SellingStatuscurrencyID','$SellingStatusCurrentPrice','$ShippingDetailsShippingServiceCostShippingServiceCost',";
				$ss		  .= "'$TimeLeft','$Title','$QuantityAvailable','$SKU','$PictureDetailsGalleryURL','$status','$account','$StartPrice')";
	
				
				$dbcon->execute($ss);
				
			
			}else{
				
				$ss		  = "update ebay_list set status='1' where ItemID='$ItemID' and ebay_account='$account'";
				$dbcon->execute($ss);
			}

			
		
		
		}
		
		
		
		if($currentpage > $totalpages) break;
		$currentpage++;
		if($currentpage>=20) break;
			 
		
		
		}
		
		
		}
		
		
		function GetSellerEvents($account,$token,$start,$end){
			
			 $verb = 'GetSellerEvents';
			 global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$dbcon,$user;
			 $currentpage				= 1;
			$xmlRequest		= '<?xml version="1.0" encoding="utf-8"?>
			<GetSellerEventsRequest xmlns="urn:ebay:apis:eBLBaseComponents">
			<RequesterCredentials>
			<eBayAuthToken>'.$token.'</eBayAuthToken>
			</RequesterCredentials>
			<HideVariations>false</HideVariations>
			<ModTimeFrom>'.$start.'</ModTimeFrom>
			<DetailLevel>ReturnAll</DetailLevel>
			</GetSellerEventsRequest>';



			 $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
			 $responseXml = $session->sendHttpRequest($xmlRequest);		
			 if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';
			 $data=XML_unserialize($responseXml); 
	
			 
			
			 $totalitems = @$data['GetSellerEventsResponse']['ItemArray']['Item'];
			 
			  for($i=0;$i<count($totalitems);$i++){
			 
			 	
				$ItemID					= $totalitems[$i]['ItemID'];
			 	$ViewItemURL			= $totalitems[$i]['ListingDetails']['ViewItemURL'];
				$ListingType			= $totalitems[$i]['ListingType'];
				$Quantity				= $totalitems[$i]['Quantity'];
				$QuantitySold			= $totalitems[$i]['SellingStatus']['QuantitySold'];
				$ListingStatus			= $totalitems[$i]['SellingStatus']['ListingStatus'];
				
				$Site					= $totalitems[$i]['Site'];
				$StartPricecurrencyID	= $totalitems[$i]['StartPrice attr']['currencyID'];
				$StartPrice				= $totalitems[$i]['StartPrice'];
				$Title					= $totalitems[$i]['Title'];
				$SKU					= $totalitems[$i]['SKU'];
				
				
				$ss					= "select * from ebay_list where ebay_account ='$account' and ebay_user='$user' and ItemID='$ItemID' ";
				


				
				$ss					= $dbcon->execute($ss);
				$ss					= $dbcon->getResultArray($ss);
			
				if(count($ss) >= 1){



							
							if($ListingStatus !='Active'){
							$vv		= " update ebay_list set status ='1' where ebay_account ='$account' and ebay_user='$user' and ItemID='$ItemID' ";
							$dbcon->execute($vv);
							}
							
					}			

			 }
			 
			 



		
		
		
		
		
		}
		

		function GetMyeBaySelling($account,$token){
			
			
			
			 $verb = 'GetMyeBaySelling';
			 global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$dbcon,$user;
			 $currentpage				= 1;
			 while(true){
			$xmlRequest		= '<?xml version="1.0" encoding="utf-8"?>
			<GetMyeBaySellingRequest xmlns="urn:ebay:apis:eBLBaseComponents">
  			<ActiveList>
   			<Sort>TimeLeft</Sort>
    		<Pagination>
      		<EntriesPerPage>199</EntriesPerPage>
     		<PageNumber>'.$currentpage.'</PageNumber>
    		</Pagination>
  			</ActiveList>
  			<RequesterCredentials>
    		<eBayAuthToken>'.$token.'</eBayAuthToken>
 			</RequesterCredentials>
  			<WarningLevel>High</WarningLevel>
			</GetMyeBaySellingRequest>';

			 $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
			 $responseXml = $session->sendHttpRequest($xmlRequest);		
			 if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';
			 $data=XML_unserialize($responseXml); 




	
			$getorder = $data['GetMyeBaySellingResponse'];  
			$totalpages		 = @$getorder['ActiveList']['PaginationResult']['TotalNumberOfPages'];
		
			$Trans = @$getorder['ActiveList']['ItemArray']['Item'];
			
			$ItemID		=  @$getorder['ActiveList']['ItemArray']['Item']['ItemID'];
			



			$totalitems		= $data['GetMyeBaySellingResponse']['ActiveList']['ItemArray']['Item'];
			 
			 for($i=0;$i<count($totalitems);$i++){
			 
			 	
				$ItemID					= $totalitems[$i]['ItemID'];
			 	$ViewItemURL			= $totalitems[$i]['ListingDetails']['ViewItemURL'];
				$ListingType			= $totalitems[$i]['ListingType'];
				$Quantity				= $totalitems[$i]['Quantity'];
				$QuantitySold			= $totalitems[$i]['SellingStatus']['QuantitySold'];
				$ListingStatus			= $totalitems[$i]['SellingStatus']['ListingStatus'];
				$Site					= $totalitems[$i]['Site'];
				$StartPricecurrencyID	= $totalitems[$i]['BuyItNowPrice attr']['currencyID'];
				$StartPrice				= $totalitems[$i]['BuyItNowPrice'];
				$Title					= mysql_escape_string($totalitems[$i]['Title']);
				$SKU					= $totalitems[$i]['SKU'];
				$QuantityAvailable		= $totalitems[$i]['QuantityAvailable'];
				
				
				$GalleryURL				= $totalitems[$i]['PictureDetails']['GalleryURL'];
				
				
				
				$ss					= "select * from ebay_list where ebay_account ='$account' and ebay_user='$user' and ItemID='$ItemID' ";

	

				$ss					= $dbcon->execute($ss);
				$ss					= $dbcon->getResultArray($ss);
				if(count($ss) == 0 && $ListingType != 'Chinese' ){
				
						$ss		= "insert into ebay_list(status,ItemID,ViewItemURL,QuantitySold,Site,Quantity,Title,SKU,ListingType,StartPrice,ebay_account,ebay_user,QuantityAvailable,StartPricecurrencyID,GalleryURL) value('0','$ItemID','$ViewItemURL','$QuantitySold','$Site','$Quantity','$Title','$SKU','$ListingType','$StartPrice','$account','$user','$QuantityAvailable','$StartPricecurrencyID','$GalleryURL')";


						if($dbcon->execute($ss)){
							echo $ItemID.'同步成功<br>';
							
							/* 检查是否有对应的子SKU  */
							$Variations		= $totalitems[$i]['Variations']['Variation'];
							if($Variations !=''){
								
								if($totalitems[$i]['Variations']['Variation']['StartPrice'] != '' ){
									$Variations		= array();
									$Variations[0]	= $totalitems[$i]['Variations']['Variation'];
								}


								for($j=0;$j<count($Variations);$j++){
										$SKU			= $Variations[$j]['SKU'];
										$Quantity		= $Variations[$j]['Quantity'];
										$StartPrice		= $Variations[$j]['StartPrice'];
										$QuantitySold	= $Variations[$j]['SellingStatus']['QuantitySold'];
										$tjstr			= '';
										$VariationSpecifics	= $Variations[$j]['VariationSpecifics'];
										if($VariationSpecifics != ''){
											$NameValueList	= $Variations[$j]['VariationSpecifics']['NameValueList']['Name'];
											if($NameValueList != ''){
												$NameValueList			= array();
												$NameValueList[0] 		= $Variations[$j]['VariationSpecifics']['NameValueList'];
											}else{
											
											$NameValueList	= $Variations[$j]['VariationSpecifics']['NameValueList'];
											}
											
											for($n=0;$n<count($NameValueList);$n++){
												$Nname		= $NameValueList[$n]['Name'];
												$Nvalue		= $NameValueList[$n]['Value'];
												$tjstr		.= $Nname.'**'.$Nvalue.'++';
											}
											$tjstr			= mysql_escape_string($tjstr);

										}
										$QuantityAvailable	= $Quantity - $QuantitySold;
										$ss = "select * from ebay_listvariations where ebay_account='$account' and itemid='$ItemID' and (SKU='$SKU' or VariationSpecifics='$tjstr') and SKU != ''  ";
										$ss					= $dbcon->execute($ss);
										$ss					= $dbcon->getResultArray($ss);
										if(count($ss) == 0){
											$rr = "insert into ebay_listvariations(SKU,Quantity,StartPrice,itemid,ebay_account,QuantitySold,QuantityAvailable,VariationSpecifics) values('$SKU','$Quantity','$StartPrice','$ItemID','$account','$QuantitySold','$QuantityAvailable','$tjstr')";
											
											echo $rr.'<br>';
											
											$dbcon->execute($rr);
										
										
										}
								}
										
							}
							
							
							
						}else{
							echo $ItemID.'同步失败<br>';
						}
				}else{
				
					
					/* 更新ID */
					if(count($ss) >= 1){
					
								$Quantity				= $totalitems[$i]['Quantity'];
								$QuantityAvailable		= $totalitems[$i]['QuantityAvailable'];
								$StartPrice				= $totalitems[$i]['BuyItNowPrice'];
									$StartPricecurrencyID	= $totalitems[$i]['BuyItNowPrice attr']['currencyID'];
							
								
								$vv	= " update ebay_list set StartPricecurrencyID='$StartPricecurrencyID',QuantityAvailable='$QuantityAvailable' , StartPrice ='$StartPrice',SKU='$SKU' where ebay_account ='$account' and ebay_user='$user' and ItemID='$ItemID' ";
								
								if($dbcon->execute($vv)){
									
									echo $ItemID.' 更新成功<br>';


								}

								/* 检查是否需有对应的多属性 */
								$Variations		= $totalitems[$i]['Variations']['Variation'];
								if($Variations !=''){

										if($totalitems[$i]['Variations']['Variation']['StartPrice'] != '' ){
											$Variations		= array();
											$Variations[0]		= $totalitems[$i]['Variations']['Variation'];
										}


									for($j=0;$j<count($Variations);$j++){
										$SKU				= $Variations[$j]['SKU'];
										$Quantity			= $Variations[$j]['Quantity'];
										$StartPrice			= $Variations[$j]['StartPrice'];
										$QuantitySold		= $Variations[$j]['SellingStatus']['QuantitySold'];


										$tjstr			= '';
										$VariationSpecifics	= $Variations[$j]['VariationSpecifics'];
										if($VariationSpecifics != ''){
											$NameValueList	= $Variations[$j]['VariationSpecifics']['NameValueList']['Name'];
											if($NameValueList != ''){
												$NameValueList			= array();
												$NameValueList[0] 		= $Variations[$j]['VariationSpecifics']['NameValueList'];
											}else{
											
											$NameValueList	= $Variations[$j]['VariationSpecifics']['NameValueList'];
											}
											
											for($n=0;$n<count($NameValueList);$n++){
												$Nname		= $NameValueList[$n]['Name'];
												$Nvalue		= $NameValueList[$n]['Value'];
												$tjstr		.= $Nname.'**'.$Nvalue.'++';
											}

											$tjstr			= mysql_escape_string($tjstr);
										}



										$QuantityAvailable	= $Quantity - $QuantitySold;
										$ss = "select * from ebay_listvariations where ebay_account='$account' and itemid='$ItemID' and SKU='$SKU'";
										$ss = "select * from ebay_listvariations where ebay_account='$account' and itemid='$ItemID' and (SKU='$SKU' or VariationSpecifics='$tjstr') and SKU != ''  ";

										$ss					= $dbcon->execute($ss);
										$ss					= $dbcon->getResultArray($ss);
										if(count($ss) == 0){
											$rr = "insert into ebay_listvariations(SKU,Quantity,StartPrice,itemid,ebay_account,QuantitySold,QuantityAvailable,VariationSpecifics) values('$SKU','$Quantity','$StartPrice','$ItemID','$account','$QuantitySold','$QuantityAvailable','$tjstr')";
										}else{
											$rr	= "update ebay_listvariations set Quantity ='$Quantity' , QuantitySold ='$QuantitySold' , StartPrice='$StartPrice',QuantityAvailable='$QuantityAvailable',VariationSpecifics='$tjstr',SKU='$SKU' where ebay_account ='$account' and ItemID ='$ItemID' and SKU='$SKU' ";
										}
										
										echo $rr.'<br>';
										
										$dbcon->execute($rr);

								}
										
							}

					}			
				
				}
			 }

		
		if($currentpage > $totalpages) break;
		$currentpage++;
		if($currentpage>=2000) break;
			 
		
		
		}
		
		
		}
		
		
		
		
			function GetSellerList($account,$token,$start,$end){
			
			
			
			 $verb = 'GetSellerList';
			 global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$dbcon,$user;
			 $currentpage				= 1;
			 $compatabilityLevel	= '741';
			 
			 
			 while(true){
			 

			$xmlRequest		= '<?xml version="1.0" encoding="utf-8"?>


<GetSellerListRequest xmlns="urn:ebay:apis:eBLBaseComponents">
  <RequesterCredentials>
    <eBayAuthToken>'.$token.'</eBayAuthToken>
  </RequesterCredentials>
  <ErrorLanguage>en_US</ErrorLanguage>
  
   <IncludeVariations>true</IncludeVariations>
  <OutputSelector>ItemArray.Item.ItemID</OutputSelector>
<OutputSelector>HasMoreItems</OutputSelector>
  <OutputSelector>ItemArray.Item.ListingType</OutputSelector>
  <OutputSelector>ItemArray.Item.SKU</OutputSelector>
  <OutputSelector>ItemArray.Item.StartPrice</OutputSelector>
  <OutputSelector>ItemArray.Item.Title</OutputSelector>
    <OutputSelector>ItemArray.Item.PictureDetails.GalleryURL</OutputSelector>
  <OutputSelector>ItemArray.Item.Site</OutputSelector>
  <OutputSelector>ItemArray.Item.Quantity</OutputSelector>
  <OutputSelector>ItemArray.Item.ListingDetails.ViewItemURL</OutputSelector>
  <OutputSelector>ItemArray.Item.SellingStatus.QuantitySold</OutputSelector>
  <OutputSelector>ItemArray.Item.Variations</OutputSelector>
  <OutputSelector>ItemArray.Item.SellingStatus.ListingStatus</OutputSelector>
  <WarningLevel>High</WarningLevel>
  <StartTimeFrom>'.$start.'</StartTimeFrom> 
  <StartTimeTo>'.$end.'</StartTimeTo> 
  <IncludeWatchCount>true</IncludeWatchCount> 
  
  <Pagination> 
    <EntriesPerPage>199</EntriesPerPage>
    <PageNumber>'.$currentpage.'</PageNumber>
  </Pagination> 
  <DetailLevel>ReturnAll</DetailLevel>
  
</GetSellerListRequest>';


			 $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);

			 $responseXml = $session->sendHttpRequest($xmlRequest);		

			 if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';
			 $data=XML_unserialize($responseXml); 

			 
			 $totalitems		= $data['GetSellerListResponse']['ItemArray']['Item'];
			 
			 for($i=0;$i<count($totalitems);$i++){
			 
			 	$GalleryURL					= $totalitems[$i]['PictureDetails']['GalleryURL'];
				$ItemID					= $totalitems[$i]['ItemID'];
			 	$ViewItemURL			= $totalitems[$i]['ListingDetails']['ViewItemURL'];
				$ListingType			= $totalitems[$i]['ListingType'];
				$Quantity				= $totalitems[$i]['Quantity'];
				$QuantitySold			= $totalitems[$i]['SellingStatus']['QuantitySold'];
				$ListingStatus			= $totalitems[$i]['SellingStatus']['ListingStatus'];
				
				$Site					= $totalitems[$i]['Site'];
				$StartPricecurrencyID	= $totalitems[$i]['StartPrice attr']['currencyID'];
				$StartPrice				= $totalitems[$i]['StartPrice'];
				//$Title					= $totalitems[$i]['Title'];
				$Title					= mysql_escape_string($totalitems[$i]['Title']);

				$SKU					= $totalitems[$i]['SKU'];
				
				
				$ss					= "select * from ebay_list where ebay_account ='$account' and ebay_user='$user' and ItemID='$ItemID' ";
				$ss					= $dbcon->execute($ss);
				$ss					= $dbcon->getResultArray($ss);
				if(count($ss) == 0 && $ListingStatus =='Active' && $ListingType != 'Chinese' ){
				
						$QuantityAvailable	= $Quantity - $QuantitySold;
						
				
						$ss		= "insert into ebay_list(status,ItemID,ViewItemURL,QuantitySold,Site,Quantity,Title,SKU,ListingType,StartPrice,ebay_account,ebay_user,QuantityAvailable,GalleryURL) value('0','$ItemID','$ViewItemURL','$QuantitySold','$Site','$Quantity','$Title','$SKU','$ListingType','$StartPrice','$account','$user','$QuantityAvailable','$GalleryURL')";
						
						if($dbcon->execute($ss)){
							echo $ItemID.'同步成功<br>';
							
							/* 检查是否有对应的子SKU  */
							$Variations		= $totalitems[$i]['Variations']['Variation'];
							if($Variations !=''){
								for($j=0;$j<count($Variations);$j++){
										$SKU			= $Variations[$j]['SKU'];
										$Quantity		= $Variations[$j]['Quantity'];
										$StartPrice		= $Variations[$j]['StartPrice'];
										$QuantitySold	= $Variations[$j]['SellingStatus']['QuantitySold'];
										$ss = "select * from ebay_listvariations where ebay_account='$account' and itemid='$ItemID' and SKU='$SKU'";
										$ss					= $dbcon->execute($ss);
										$ss					= $dbcon->getResultArray($ss);
										if(count($ss) == 0){
											$rr = "insert into ebay_listvariations(SKU,Quantity,StartPrice,itemid,ebay_account,QuantitySold) values('$SKU','$Quantity','$StartPrice','$ItemID','$account','$QuantitySold')";
											$dbcon->execute($rr);
											if($j== 0){
												//$gg		= "update ebay_list set  SKU='$SKU' where ItemID ='$ItemID' ";
												//$dbcon->execute($gg);
											}
										}
								}
										
							}
							
							
							
						}else{
							echo $ItemID.'同步失败<br>';
						}
				}else{
				
					
					/* 更新ID */
					if(count($ss) >= 1){
							
							if($ListingStatus ='Active'){
								
								$Quantity				= $totalitems[$i]['Quantity'];
								$QuantitySold			= $totalitems[$i]['SellingStatus']['QuantitySold'];
								$StartPrice				= $totalitems[$i]['StartPrice'];
								
								
								$QuantityAvailable		= $Quantity - $QuantitySold;
								
								
								$vv	= " update ebay_list set Quantity='$Quantity' , QuantitySold ='$QuantitySold' , StartPrice ='$StartPrice',QuantityAvailable='$QuantityAvailable' where ebay_account ='$account' and ebay_user='$user' and ItemID='$ItemID' ";
								if($dbcon->execute($vv)){
									
									echo $ItemID.' 更新成功<br>';


								}

								/* 检查是否需有对应的多属性 */
								$Variations		= $totalitems[$i]['Variations']['Variation'];
							if($Variations !=''){
								for($j=0;$j<count($Variations);$j++){
										$SKU			= $Variations[$j]['SKU'];
										$Quantity		= $Variations[$j]['Quantity'];
										$StartPrice		= $Variations[$j]['StartPrice'];
										$QuantitySold	= $Variations[$j]['SellingStatus']['QuantitySold'];
										$ss = "select * from ebay_listvariations where ebay_account='$account' and itemid='$ItemID' and SKU='$SKU'";
										$ss					= $dbcon->execute($ss);
										$ss					= $dbcon->getResultArray($ss);
										if(count($ss) == 0){
											$rr = "insert into ebay_listvariations(SKU,Quantity,StartPrice,itemid,ebay_account,QuantitySold) values('$SKU','$Quantity','$StartPrice','$ItemID','$account','$QuantitySold')";
										}else{

											$rr	= "update ebay_listvariations set Quantity ='$Quantity' , QuantitySold ='$QuantitySold' , StartPrice='$StartPrice' where ebay_account ='$ebay_account' and ItemID ='$ItemID' and SKU='$SKU' ";

										}
										$dbcon->execute($rr);

								}
										
							}

								
							
							}else{
							
							
							/* 将产品调为下线状态*/
							$vv		= " update ebay_list set status ='1' where ebay_account ='$account' and ebay_user='$user' and ItemID='$ItemID' ";
							$dbcon->execute($vv);
							
							}
					}			
				
				}
			 }
			 
			 
			 
			 


			 $currentpage ++;

			 $HasMoreItems = $data['GetSellerListResponse']['HasMoreItems'];
			 if($HasMoreItems == false || $HasMoreItems == '') break;
		
		}
		
		
		}
		

		

	function getItemdetails($ebay_account,$itemid){

		

		global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$user,$dbcon,$nowtime;


		$token				= geteBayaccountToken($ebay_account);
		/* 取得conditon id  */
		$verb = 'GetItem';
		

		
		
		
		global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$dbcon;
					 $compatabilityLevel ='741';
					 echo $compatabilityLevel;
					 
			$xmlRequest		= '<?xml version="1.0" encoding="utf-8"?>
<GetItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
  <ItemID>'.$itemid.'</ItemID>
  <RequesterCredentials>
    <eBayAuthToken>'.$token.'</eBayAuthToken>
  </RequesterCredentials>
  <WarningLevel>High</WarningLevel>
  <IncludeItemSpecifics>true</IncludeItemSpecifics>
   <DetailLevel>ReturnAll</DetailLevel>
</GetItemRequest>';



			 $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
			 $responseXml = $session->sendHttpRequest($xmlRequest);		
			 if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';

			 $it=XML_unserialize($responseXml); 



		
			


			 $data				=  $it['GetItemResponse']['Item'];
			 

	
			 
			 $ConditionID		= $data['GetItemResponse']['Item']['ConditionID'];
			 
		$Title				= $data['Title'];
		$SKU				= $data['SKU'];
		$ListingType		= $data['ListingType'];
		$ListingDuration	= $data['ListingDuration'];
		$TimeLeft			= $data['TimeLeft'];
		$StartPrice			= $data['StartPrice'];
		$Quantity			= $data['Quantity'];
		$Site				= $data['Site'];
		$GalleryType		= $data['PictureDetails']['GalleryType'];
		$GalleryURL			= $data['PictureDetails']['GalleryURL'];
		$BidCount			= $data['SellingStatus']['BidCount'];
		$QuantitySold		= $data['SellingStatus']['QuantitySold'];
		$ListingStatus		= $data['SellingStatus']['ListingStatus'];
		
		
		
		$qty				= $Quantity - $QuantitySold;
		
		$PictureDetails				= $data['PictureDetails']['PictureURL'];
		$HitCount					= $data['HitCount'];
		$Description				= mysql_real_escape_string($data['Description']);
		$CategoryID					= $data['PrimaryCategory']['CategoryID'];
		$PayPalEmailAddress			= $data['PayPalEmailAddress'];
		
		
		/* 取得类别所对应的specific */
				
		$Location			= $data['Location'];
		$BuyItNowPrice		= $data['BuyItNowPrice'];
		$DispatchTimeMax	= $data['DispatchTimeMax'];
		$ViewItemURL		= $data['ListingDetails']['ViewItemURL'];
		$ReservePrice		= $data['ReservePrice'];
		$ReturnsAcceptedOption			= $data['ReturnPolicy']['ReturnsAcceptedOption'];
		$RefundOption					= $data['ReturnPolicy']['RefundOption'];
		$ReturnsWithinOption			= $data['ReturnPolicy']['ReturnsWithinOption'];
		$ShippingCostPaidByOption		= $data['ReturnPolicy']['ShippingCostPaidByOption'];
		$rDescription					= str_rep($data['ReturnPolicy']['Description']);
		$Country						= $data['Country'];
		$ItemID							= $data['ItemID'];
		$SellingStatus					= $data['SellingStatus']['ListingStatus'];
		$status = '1';
		if($SellingStatus == 'Active'){
			
			
			 $status = '0';
		}
		
		
	
		
			
			
			
		/* 检查是否有对应的policy */
		$ss		= "select * from ebay_listingreturnmethod where ebay_user='$user' and ebay_account='$ebay_account' and ReturnsAcceptedOption='$ReturnsAcceptedOption' and RefundOption='$RefundOption' and ReturnsWithinOption='$ReturnsWithinOption' and ShippingCostPaidByOption='$ShippingCostPaidByOption' ";
		$ss					= $dbcon->execute($ss);
		$ss					= $dbcon->getResultArray($ss);
		if(count($ss) == 0){
			
			$ss				= "insert into ebay_listingreturnmethod(name,ReturnsAcceptedOption,RefundOption,ReturnsWithinOption,ShippingCostPaidByOption,Description,ebay_account,ebay_user) values('系统定义','$ReturnsAcceptedOption','$RefundOption','$ReturnsWithinOption','$ShippingCostPaidByOption','$rDescription','$ebay_account','$user')";
			$dbcon->execute($ss);
				
		
		}
		
		$ss		= "select * from ebay_listingreturnmethod where ebay_user='$user' and ebay_account='$ebay_account' and ReturnsAcceptedOption='$ReturnsAcceptedOption' and RefundOption='$RefundOption' and ReturnsWithinOption='$ReturnsWithinOption' and ShippingCostPaidByOption='$ShippingCostPaidByOption' ";
		$ss					= $dbcon->execute($ss);
		$ss					= $dbcon->getResultArray($ss);
		$ebay_listingreturnmethodid	= $ss[0]['id'];
		
		
		

		$PictureURL01		= $data['PictureDetails']['PictureURL'];

		
		if(strlen($PictureURL01) <= 10 ){
			
			$PictureURL01		= $data['PictureDetails']['PictureURL'][0];
			$PictureURL02		= $data['PictureDetails']['PictureURL'][1];
			$PictureURL03		= $data['PictureDetails']['PictureURL'][2];
			$PictureURL04		= $data['PictureDetails']['PictureURL'][3];
			
			
			
			
		}
		
		

		
		
		


		
		
		$ss					= "select * from ebay_list where ebay_account ='$ebay_account' and ebay_user='$user' and ItemID='$itemid' ";
		

		$ss					= $dbcon->execute($ss);
		$ss					= $dbcon->getResultArray($ss);
		
		if(count($ss) == 0){
			
			
			if($itemid != ''){
				GetCategorySpecifics($ebay_account,$CategoryID);
				
			$ss		= "insert into ebay_list(PayPalEmailAddress,status,ConditionID,ItemID,Country,ebay_listingreturnmethodid,ReservePrice,PictureURL01,PictureURL02,PictureURL03,PictureURL04,ViewItemURL,DispatchTimeMax,BuyItNowPrice,Location,CategoryID,Description,HitCount,QuantitySold,BidCount,Site,Quantity,Title,SKU,ListingType,ListingDuration,TimeLeft,StartPrice,GalleryType,GalleryURL,ebay_account,ebay_user) value('$PayPalEmailAddress','$status','$ConditionID','$ItemID','$Country','$ebay_listingreturnmethodid','$ReservePrice','$PictureURL01','$PictureURL02','$PictureURL03','$PictureURL04','$ViewItemURL','$DispatchTimeMax','$BuyItNowPrice','$Location','$CategoryID','$Description','$HitCount','$QuantitySold','$BidCount','$Site','$qty','$Title','$SKU','$ListingType','$ListingDuration','$TimeLeft','$StartPrice','$GalleryType','$GalleryURL','$ebay_account','$user')";
			
			
		    echo '<br>'.$ItemID.' 导入成功 ';
	
	
			$dbcon->execute($ss);
			$insertid	=  mysql_insert_id();
				/* ItemSpecifics */
			$Name					= $it['GetItemResponse']['Item']['ItemSpecifics']['NameValueList']['Name'];
			$Value					= $it['GetItemResponse']['Item']['ItemSpecifics']['NameValueList']['Value'];
			$Source					= $it['GetItemResponse']['Item']['ItemSpecifics']['NameValueList']['Source'];
			$ItemSpecifics			= $it['GetItemResponse']['Item']['ItemSpecifics']['NameValueList'];

			
			if($Name == ''){
				for($i=0;$i<count($ItemSpecifics);$i++){
					$Name			= 	$ItemSpecifics[$i]['Name'];
					$Value			= 	$ItemSpecifics[$i]['Value'];
					$Source			= 	$ItemSpecifics[$i]['Source'];
					$ss				=   "insert into ebay_itemspecifics(name,Value,Source,sid) values('$Name','$Value','$Source','$insertid')";
					$dbcon->execute($ss);
				}				
			}
			}
		}

		/* Variations */
		/* Variations */
		$variations					=  $it['GetItemResponse']['Item']['Variations']['Variation'];
		
		for($i=0;$i<count($variations);$i++){
			
			$SKU			= $variations[$i]['SKU'];
			$Quantity		= $variations[$i]['Quantity'];
			$StartPrice		= $variations[$i]['StartPrice'];
			$QuantitySold	= $variations[$i]['SellingStatus']['QuantitySold'];
			
			$qty			= $Quantity - $QuantitySold;
			
			
			
			$ss = "select * from ebay_listvariations where ebay_account='$ebay_account' and itemid='$itemid' and SKU='$SKU'";
			$ss					= $dbcon->execute($ss);
			$ss					= $dbcon->getResultArray($ss);
		
			if(count($ss) == 0){
				$rr = "insert into ebay_listvariations(SKU,Quantity,StartPrice,itemid,ebay_account) values('$SKU','$qty','$StartPrice','$itemid','$ebay_account')";
				$dbcon->execute($rr);
				
				
				if($i== 0){
					
					$gg		= "update ebay_list set  SKU='$SKU' where ItemID ='$ItemID' ";
					$dbcon->execute($gg);
				
				}
			
			
			
			}
			


			
			
		}

	}

	

	

	

	function fstr_rep($str){

		

		$str  = str_replace("&acute;","'",$str);

		$str  = str_replace("&quot;","\"",$str);

		return $str;	

	}


	

?>