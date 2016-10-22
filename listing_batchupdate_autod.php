<?php
	@session_start();
	error_reporting(0);
	
	$_SESSION['user']	= 'goodstrading';
	$user	= $_SESSION['user'];
	


	include "include/config.php";
	
		function ModbyItemIDPrice($StartPrice,$ebay_token,$ItemID,$ebay_account,$id){

			 global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$dbcon,$user,$nowtime,$truename;
			 
			 if($truename == '') $truename = $user;
			 $compatabilityLevel	= '741';
			 $verb = 'ReviseFixedPriceItem';
			 $xmlRequest		= '<?xml version="1.0" encoding="utf-8"?><ReviseFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
			 <ErrorLanguage>en_US</ErrorLanguage>
			 <WarningLevel>High</WarningLevel>
			 <Item>
			 <ItemID>'.$ItemID.'</ItemID>
			 <StartPrice>'.$StartPrice.'</StartPrice>
			 </Item>
			 <RequesterCredentials>
			 <eBayAuthToken>'.$ebay_token.'</eBayAuthToken>
			 </RequesterCredentials>
			 <WarningLevel>High</WarningLevel>
			 </ReviseFixedPriceItemRequest>';
			 
			
		echo $xmlRequest;
		
			 
			 $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
			 $responseXml = $session->sendHttpRequest($xmlRequest);

			 $runstatus	  = 0;
			 
			 if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';
			 $data	= XML_unserialize($responseXml);
			 
			 
			 print_r($data);
			 
			 $Ack		= $data['ReviseFixedPriceItemResponse']['Ack'];
			 if($Ack != 'Failure'){
					$logs	=  '编号: '.$ItemID.' SKU:'.$SKU.' 价格修改为:'.$StartPrice.' 状态: '.$Ack;
			 		$vv		= "update ebay_list set StartPrice='$StartPrice' where id ='$id' ";
					
					$dbcon->execute($vv);
					 $runstatus	  = 1;
					 
			 }else{
			 
			 		$errors =  $data['ReviseFixedPriceItemResponse']['Errors']['LongMessage'];
			 		$logs	=  '编号: '.$ItemID.' SKU:'.$SKU.' 价格修改为:'.$StartPrice.'状态: '.$Ack.' 原因:'.$errors;
			 }
			 
			 $sql			= "insert into ebay_listlog(itemid,account,logs,ebay_user,addtime,currentuser) values('$ItemID','$ebay_account','$logs','$user','$nowtime','$truename')";
			 $dbcon->execute($sql);
			 
			 return $runstatus;
			 

		}
		
		
		
		function ModbyItemIDsku($Quantity,$ebay_token,$ItemID,$ebay_account,$sku,$VariationSpecifics){

			 global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$dbcon,$user,$nowtime,$truename;
			 
			 if($truename == '') $truename = $user;


			 $VariationSpecifics					= $VariationSpecifics;
			$VariationSpecifics					= explode('++',$VariationSpecifics);
			$variationSpecificsstr				= '';
			for($n=0;$n<count($VariationSpecifics);$n++){
			
				
				$varia		= $VariationSpecifics[$n];
				if($varia != ''){
					
					$nameandvalue		= explode('**',$varia);
					$Nname				= $nameandvalue[0];
					$Nvalue				= $nameandvalue[1];
					$variationSpecificsstr .= '<NameValueList><Name>'.$Nname.'</Name><Value>'.$Nvalue.'</Value></NameValueList>';
				}
				
			}


			 
			 $compatabilityLevel	= '741';
			 $verb = 'ReviseFixedPriceItem';
			 $xmlRequest		= '<?xml version="1.0" encoding="utf-8"?><ReviseFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
			  <ErrorLanguage>en_US</ErrorLanguage>
			  <WarningLevel>High</WarningLevel>
			  <Item>
			  <ItemID>'.$ItemID.'</ItemID>
			  <Variations>
      		  <Variation>
        	  <SKU>'.$sku.'</SKU>';



			   if($SKU != '' ) $xmlRequest .= '<SKU>'.$SKU.'</SKU>';
	  if($variationSpecificsstr != '' ) $xmlRequest .= '<VariationSpecifics>'.$variationSpecificsstr.'</VariationSpecifics>';
    
			$xmlRequest	.= '<Quantity>'.$Quantity.'</Quantity>
			  </Variation>
    		  </Variations>
			  </Item>
			  <RequesterCredentials>
				<eBayAuthToken>'.$ebay_token.'</eBayAuthToken>
			  </RequesterCredentials>
			  <WarningLevel>High</WarningLevel>
			</ReviseFixedPriceItemRequest>';
			 $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
			 $responseXml = $session->sendHttpRequest($xmlRequest);

			 $runstatus	  = 0;
			 
			 if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';
			 $data	= XML_unserialize($responseXml);
			 $Ack		= $data['ReviseFixedPriceItemResponse']['Ack'];
			 if($Ack != 'Failure'){
					$logs	=  '编号: '.$ItemID.' SKU:'.$sku.' 把数量修改为:'.$Quantity.' 状态: '.$Ack;
			 	
					 $runstatus	  = 1;
					 
			 }else{
			 		$errors =  $data['ReviseFixedPriceItemResponse']['Errors']['LongMessage'];
			 		$logs	=  '编号: '.$ItemID.' SKU:'.$sku.' 把数量修改为:'.$Quantity.' 状态: '.$Ack.' 原因:'.$errors;
			 }
			 
			 $sql			= "insert into ebay_listlog(itemid,account,logs,ebay_user,addtime,currentuser) values('$ItemID','$ebay_account','$logs','$user','$nowtime','$truename')";
			 $dbcon->execute($sql);
			 
			 return $runstatus;
			 

		}
		
	
		function ModbyItemID($Quantity,$ebay_token,$ItemID,$ebay_account){

			 global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$dbcon,$user,$nowtime,$truename;
			 
			 if($truename == '') $truename = $user;
			 
			 $compatabilityLevel	= '741';
			 $verb = 'ReviseFixedPriceItem';
			 $xmlRequest		= '<?xml version="1.0" encoding="utf-8"?><ReviseFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
			 <ErrorLanguage>en_US</ErrorLanguage>
			 <WarningLevel>High</WarningLevel>
			 <Item>
			 <ItemID>'.$ItemID.'</ItemID>
			 <Quantity>'.$Quantity.'</Quantity>
			 </Item>
			 <RequesterCredentials>
			 <eBayAuthToken>'.$ebay_token.'</eBayAuthToken>
			 </RequesterCredentials>
			 <WarningLevel>High</WarningLevel>
			 </ReviseFixedPriceItemRequest>';
			 $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
			 $responseXml = $session->sendHttpRequest($xmlRequest);

			 $runstatus	  = 0;
			 
			 if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';
			 $data	= XML_unserialize($responseXml);
			 $Ack		= $data['ReviseFixedPriceItemResponse']['Ack'];
			 if($Ack != 'Failure'){
					$logs	=  '编号: '.$ItemID.' SKU:'.$SKU.' 把数量修改为:'.$Quantity.' 状态: '.$Ack;
			 		$vv		= "update ebay_list set QuantityAvailable='$Quantity' where id ='$id' ";
					
					$dbcon->execute($vv);
					 $runstatus	  = 1;
					 
			 }else{
			 		$errors =  $data['ReviseFixedPriceItemResponse']['Errors']['LongMessage'];
			 		$logs	=  '编号: '.$ItemID.' SKU:'.$SKU.' 把数量修改为:'.$Quantity.' 状态: '.$Ack.' 原因:'.$errors;
			 }
			 
			 $sql			= "insert into ebay_listlog(itemid,account,logs,ebay_user,addtime,currentuser) values('$ItemID','$ebay_account','$logs','$user','$nowtime','$truename')";
			 $dbcon->execute($sql);
			 
			 return $runstatus;
			 

		}
		function GetMyeBaySelling_auto($account,$token){
			
			 $verb = 'GetMyeBaySelling';
			 global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$dbcon,$user;
			 $currentpage				= 1;
			 
			 $jss		= 1;
			 
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
				
				$ss					= "select * from ebay_list where ebay_account ='$account' and ebay_user='$user' and ItemID='$ItemID' ";

				$ss					= $dbcon->execute($ss);
				$ss					= $dbcon->getResultArray($ss);
				if(count($ss) == 0 && $ListingType != 'Chinese' ){
				
						$ss		= "insert into ebay_list(status,ItemID,ViewItemURL,QuantitySold,Site,Quantity,Title,SKU,ListingType,StartPrice,ebay_account,ebay_user,QuantityAvailable,StartPricecurrencyID) value('0','$ItemID','$ViewItemURL','$QuantitySold','$Site','$Quantity','$Title','$SKU','$ListingType','$StartPrice','$account','$user','$QuantityAvailable','$StartPricecurrencyID')";


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


										if($SKU != ''){
										$ss = "select * from ebay_listvariations where ebay_account='$account' and itemid='$ItemID' and   SKU='$SKU' ";
									    }else{
										$ss = "select * from ebay_listvariations where ebay_account='$account' and itemid='$ItemID' and   VariationSpecifics='$tjstr' ";
									    }
										//$ss = "select * from ebay_listvariations where ebay_account='$account' and itemid='$ItemID' and (SKU='$SKU' or VariationSpecifics='$tjstr') and SKU != ''  ";
										$ss					= $dbcon->execute($ss);
										$ss					= $dbcon->getResultArray($ss);
										if(count($ss) == 0){
											$rr = "insert into ebay_listvariations(SKU,Quantity,StartPrice,itemid,ebay_account,QuantitySold,QuantityAvailable,VariationSpecifics) values('$SKU','$Quantity','$StartPrice','$ItemID','$account','$QuantitySold','$QuantityAvailable','$tjstr')";
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


								
								
								$QuantityAvailableold	= $ss[0]['QuantityAvailable'];
								$track_stock			= $ss[0]['track_stock'];  // 是否启用跟踪库存的
								$track_price			= $ss[0]['track_price'];  // 是否启用跟踪价格的
								$id						= $ss[0]['id'];  // 
								$addprice				= $ss[0]['addprice'];  // 
								$jianprice				= $ss[0]['jianprice'];  // 
								$hightprice				= $ss[0]['hightprice'];
								$lawprice				= $ss[0]['lawprice'];
								
								$Quantity				= $totalitems[$i]['Quantity'];
								$QuantityAvailable		= $totalitems[$i]['QuantityAvailable'];
								$StartPrice				= $totalitems[$i]['BuyItNowPrice'];
								$StartPricecurrencyID	= $totalitems[$i]['BuyItNowPrice attr']['currencyID'];
								


					
							

								/* 启用价格跟踪功能 */
								if($track_price  == 0 ){
									
									/* 取得所有指定监控下产品的Item Number  */
									
									
									/* 取得所有指定监控下产品的Item Number  */
									
									
									$vv		= "select * from ebay_tracklist where ebay_user ='$user' and trackid ='$id' order by CurrentPrice asc ";
									$vv		= $dbcon->execute($vv);
									$vv		= $dbcon->getResultArray($vv);
								
									
									
									for($v=0;$v<count($vv);$v++){
									
										$ItemIDs		= $vv[$v]['ItemID'];
										$vid			= $vv[$v]['id'];
										
										$url				= 'http://open.api.ebay.com/shopping?callname=GetSingleItem&responseencoding=XML&appid=Survyc487-9ec7-4317-b443-41e7b9c5bdd&siteid=0&ItemID='.$ItemIDs.'&version=781&IncludeSelector=Details';
										$data			= file_get_contents($url);
										$data			= XML_unserialize($data);
										
										$ack			= $data['GetSingleItemResponse']['Ack'];
										if($ack == 'Success'){
				
										$UserID							= $data['GetSingleItemResponse']['Item']['Seller']['UserID'];
										$FeedbackScore					= $data['GetSingleItemResponse']['Item']['Seller']['FeedbackScore'];
										$PositiveFeedbackPercent		= $data['GetSingleItemResponse']['Item']['Seller']['PositiveFeedbackPercent'];
										$TopRatedSeller					= $data['GetSingleItemResponse']['Item']['Seller']['TopRatedSeller'];
										$CurrentPrice					= $data['GetSingleItemResponse']['Item']['CurrentPrice'];
										$ListingStatus					= $data['GetSingleItemResponse']['Item']['ListingStatus'];
										$QuantitySold					= $data['GetSingleItemResponse']['Item']['QuantitySold'];
										$Site							= $data['GetSingleItemResponse']['Item']['Site'];
										$Title							= $data['GetSingleItemResponse']['Item']['Title'];
										$currencyID						= $data['GetSingleItemResponse']['Item']['CurrentPrice attr']['currencyID'];
										$ItemIDs						= $data['GetSingleItemResponse']['Item']['ItemID'];
										$vvs								= "update ebay_tracklist set currencyID='$currencyID',Site='$Site',CurrentPrice='$CurrentPrice',TopRatedSeller='$TopRatedSeller',FeedbackScore='$FeedbackScore',PositiveFeedbackPercent='$PositiveFeedbackPercent',ListingStatus='$ListingStatus',QuantitySold='$QuantitySold' where id ='$vid' ";
										
										echo $vvs.'<br>';
										
										$dbcon->execute($vvs);

										}

									}
									
									
									
									
									$vv		= "select * from ebay_tracklist where ebay_user ='$user' and trackid ='$id' order by CurrentPrice asc ";
									
								
									
									$vv		= $dbcon->execute($vv);
									$vv		= $dbcon->getResultArray($vv);
									
									
								
									
									if(count($vv) > 0 ){
									
								
						
									
											
										$CurrentPrice		= $vv[0]['CurrentPrice'];
										$changeprice		= 0;
										
								//		echo $CurrentPrice.' && '.$StartPrice;
										
										if($CurrentPrice  !=   $StartPrice ){
											$changeprice	= $CurrentPrice - $jianprice;
											
										//	echo 'cp='.$changeprice;
										//	echo 'lawprice='.$lawprice;
										//	echo 'hightprice='.$hightprice;
											if($changeprice >= $lawprice && $changeprice <=$hightprice ){
											$runstatus		= ModbyItemIDPrice($changeprice,$token,$ItemID,$account,$id);
											
										//	echo 'ggggggggggggg';
											
										    if($runstatus   == '1') $StartPrice = $changeprice;

											}
										}
						
								
									
									}
									
								
								
								}
								
								


								/* 检查是否需有对应的多属性 */
								$Variations		= $totalitems[$i]['Variations']['Variation'];
								if($Variations !=''){
										
										if($totalitems[$i]['Variations']['Variation']['StartPrice'] != '' ){
										$Variations		= array();
										$Variations[0]	= $totalitems[$i]['Variations']['Variation'];
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
										
										if($SKU != ''){
										$ss = "select * from ebay_listvariations where ebay_account='$account' and itemid='$ItemID' and   SKU='$SKU' ";
									    }else{
										$ss = "select * from ebay_listvariations where ebay_account='$account' and itemid='$ItemID' and   VariationSpecifics='$tjstr' ";
									    }
									    $ss					= $dbcon->execute($ss);
										$ss					= $dbcon->getResultArray($ss);
										
										if(count($ss) == 0){
											$rr = "insert into ebay_listvariations(SKU,Quantity,StartPrice,itemid,ebay_account,QuantitySold,QuantityAvailable,VariationSpecifics) values('$SKU','$Quantity','$StartPrice','$ItemID','$account','$QuantitySold','$QuantityAvailable','$tjstr')";
											$dbcon->execute($rr);

										}
										
								}
										
							}

					}			
				
				}
			 }

		
		if($currentpage > $totalpages) break;
		$currentpage++;
		if($currentpage>=20) break;
			 
		
		
		}
		
		
		}


	
		$ss			= "select * from ebay_account where ebay_user='$user' and ebay_token !=''  ";
		$ss			= $dbcon->execute($ss);
		$ss			= $dbcon->getResultArray($ss);
		
		for($i=0;$i<count($ss);$i++){
			$token				= $ss[$i]['ebay_token'];
			$ebay_account		= $ss[$i]['ebay_account'];
			echo " T=".$i."个帐号 \n\r ";
			GetMyeBaySelling_auto($ebay_account,$token);
		}
		
		
			
	$_SESSION['user']	= 'viptcyw';
	$user	= $_SESSION['user'];
		
		$ss			= "select * from ebay_account where ebay_user='$user' and ebay_token !=''  ";
		$ss			= $dbcon->execute($ss);
		$ss			= $dbcon->getResultArray($ss);
		
		
		
		
		for($i=0;$i<count($ss);$i++){
			$token				= $ss[$i]['ebay_token'];
			$ebay_account		= $ss[$i]['ebay_account'];
			echo " T=".$i."个帐号 \n\r ";
			GetMyeBaySelling_auto($ebay_account,$token);
		}
		
		
		$_SESSION['user']	= 'vipscott';
	$user	= $_SESSION['user'];
		
		$ss			= "select * from ebay_account where ebay_user='$user' and ebay_token !=''  ";
		$ss			= $dbcon->execute($ss);
		$ss			= $dbcon->getResultArray($ss);
		
		
		
		
		for($i=0;$i<count($ss);$i++){
			$token				= $ss[$i]['ebay_token'];
			$ebay_account		= $ss[$i]['ebay_account'];
			echo " T=".$i."个帐号 \n\r ";
			GetMyeBaySelling_auto($ebay_account,$token);
		}
		
	
	?>
	