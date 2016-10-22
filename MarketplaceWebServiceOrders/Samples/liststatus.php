<?php
@session_start();
	error_reporting(0);
	
	$_SESSION['user']	= 'cncheng';
	$user	= $_SESSION['user'];

	include "include/config.php";	
	
	//error_reporting(E_ALL);	
		$account = $_REQUEST['account'];	

		if($account != ''){

		$ss			= "select * from ebay_account where ebay_user='$user' and ebay_account ='$account'  ";
		}else{

		$ss			= "select * from ebay_account where ebay_user='$user' and ebay_token != '' ";

		}
		
		$ss			= $dbcon->execute($ss);
		$ss			= $dbcon->getResultArray($ss);
		
		
		$start1						= date('Y-m-d H:i:s');	
		$start0						= date('Y-m-d H:i:s',strtotime("$start1 -9 hours"));  // -8 
		$start0						= date('Y-m-d',strtotime($start0)).'T'.date('H:i:s',strtotime($start0)).'.000Z';
		
		for($i=0; $i<count($ss);$i++){
			$token			= $ss[$i]['ebay_token'];
			$account		= $ss[$i]['ebay_account'];

			echo "\n\r".'number: '.$i.'    '.$account."\n\r";

			 GetSellerEventsv2($account,$token,$start0,$end);
		}
		
		
		function getEbaysiteid($country){
			
			$siteid	= 0;
			
			if($country == 'Australia') $siteid = 15;
			if($country == 'Austria') 	$siteid = 16;
			if($country == 'Belgium_Dutch') 	$siteid = 123;
			if($country == 'Belgium_French') 	$siteid = 23;
			if($country == 'Canada') 	$siteid = 2;
			if($country == 'CanadaFrench') 	$siteid = 210;
			if($country == 'France') 	$siteid = 71;
			if($country == 'Germany') 	$siteid = 77;
			if($country == 'HongKong') 	$siteid = 201;
			if($country == 'US') 	$siteid = 0;
			if($country == 'UK') 	$siteid = 3;
			if($country == 'Switzerland') 	$siteid = 193;
			if($country == 'Sweden') 	$siteid = 218;
			if($country == 'Spain') 	$siteid = 186;
			if($country == 'Singapore') 	$siteid = 216;
			if($country == 'Malaysia') 	$siteid = 207;
			if($country == 'Netherlands') 	$siteid = 146;
			if($country == 'Philippines') 	$siteid = 211;
			if($country == 'Poland') 	$siteid = 212;
			if($country == 'Italy') 	$siteid = 101;
			if($country == 'Ireland') 	$siteid = 205;
			if($country == 'India') 	$siteid = 203;
			return $siteid;
		
		}

		function ModbyItemIDsku($Quantity,$ebay_token,$ItemID,$ebay_account,$sku,$VariationSpecifics,$SiteIDS){

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
			 $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $SiteIDS, $verb);
			 $responseXml = $session->sendHttpRequest($xmlRequest);

			 $runstatus	  = 0;
			 
			 if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';
			 $data	= XML_unserialize($responseXml);
			 $Ack		= $data['ReviseFixedPriceItemResponse']['Ack'];
			  $errors		= $data['ReviseFixedPriceItemResponse']['Errors']['LongMessage'].$xmlRequest;
			 
			 if($Ack != 'Failure'){
					$logs	=  '编号: '.$ItemID.' SKU:'.$sku.' 把数量修改为:'.$Quantity.' 状态: '.$Ack;
			 	
					 $runstatus	  = 1;
					 
			 }else{
			 		$errors =  $data['ReviseFixedPriceItemResponse']['Errors']['LongMessage'];
			 		$logs	=  mysql_escape_string('编号: '.$ItemID.' SKU:'.$sku.' 把数量修改为:'.$Quantity.' 状态: '.$Ack.' 原因:'.$errors);
			 }
			 
			 $sql			= "insert into ebay_listlog(itemid,account,logs,ebay_user,addtime,currentuser) values('$ItemID','$ebay_account','$logs','$user','$nowtime','$truename')";
			 $dbcon->execute($sql);
			 
			 return $runstatus;
			 

		}
		
	
		function ModbyItemID($Quantity,$ebay_token,$ItemID,$ebay_account,$SiteIDS){

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
			 $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $SiteIDS, $verb);
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






		function GetSellerEventsv2($account,$token,$start,$end){
			
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
			 
			 


			if($data['GetSellerEventsResponse']['ItemArray'] == '' ) return;

			
			 $totalitems = @$data['GetSellerEventsResponse']['ItemArray']['Item'];
			 
			 if(@$data['GetSellerEventsResponse']['ItemArray']['Item']['ItemID'] != ''){
			 	$totalitems		= array();
				$totalitems[0]  = $data['GetSellerEventsResponse']['ItemArray']['Item'];
			 }
			 
			  for($i=0;$i<count($totalitems);$i++){
			 
			 	
				$ItemID					= $totalitems[$i]['ItemID'];


			 	$ViewItemURL			= $totalitems[$i]['ListingDetails']['ViewItemURL'];
				$ListingType			= $totalitems[$i]['ListingType'];
				$Quantity				= $totalitems[$i]['Quantity'];
				$QuantitySold			= $totalitems[$i]['SellingStatus']['QuantitySold'];
				$ListingStatus			= $totalitems[$i]['SellingStatus']['ListingStatus'];
				$StartPrice				= $totalitems[$i]['SellingStatus']['CurrentPrice'];
				$StartPricecurrencyID	= $totalitems[$i]['CurrentPrice attr']['currencyID'];
				$Site					= $totalitems[$i]['Site'];		
				
				
				$SiteIDS				= getEbaysiteid($Site);
				

				$Title					= $totalitems[$i]['Title'];
				$SKU					= $totalitems[$i]['SKU'];
				$QuantityAvailable		= $Quantity - $QuantitySold;
				$ss					= "select * from ebay_list where ebay_account ='$account' and ebay_user='$user' and ItemID='$ItemID' ";
				$ss					= $dbcon->execute($ss);
				$ss					= $dbcon->getResultArray($ss);
				/* 更新现有的Listing 数量 */
				if(count($ss) >= 1){

							if($ListingStatus !='Active'){
							$vv		= " update ebay_list set status ='1' where ebay_account ='$account' and ebay_user='$user' and ItemID='$ItemID' ";
							$dbcon->execute($vv);							
							}else{

								$QuantityAvailableold	= $ss[0]['QuantityAvailable'];
								$track_stock			= $ss[0]['track_stock'];  // 是否启用跟踪库存的
								$track_price			= $ss[0]['track_price'];  // 是否启用跟踪价格的
								$id						= $ss[0]['id'];  // 
								$addprice				= $ss[0]['addprice'];  // 
								$jianprice				= $ss[0]['jianprice'];  // 
								$hightprice				= $ss[0]['hightprice'];
								$lawprice				= $ss[0]['lawprice'];

								$newolqty				= $QuantityAvailableold - $QuantityAvailable;

								if($newolqty > 0  && $track_stock == 0  && $totalitems[$i]['Variations']['Variation'] == '' ){
										$runstatus		= ModbyItemID($QuantityAvailable + $newolqty ,$token,$ItemID,$account,$SiteIDS);
										if($runstatus   == '1') $QuantityAvailable = $QuantityAvailable + $newolqty;
										echo $i.': RUN: TO EBAY: '.$ItemID."\n\r";
								}else{										
										echo $i.': RUN: NO EBAY: '.$ItemID."\n\r";
								}
								
								$vv						= "update ebay_list set QuantityAvailable = '$QuantityAvailable',StartPrice='$StartPrice',QuantitySold='$QuantitySold',Site	='$Site' where id ='$id' ";
								$dbcon->execute($vv);
								
								/* 开始检查是否有多属性物品 */
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
										
										if(count($ss) > 0){
									

											$VariationSpecifics		= $ss[0]['VariationSpecifics'];
											$newolqty				= $ss[0]['QuantityAvailable'];
											$newolqty1				=  $QuantityAvailable; 		  // 现在同步进来的数量
											$nowqty					= $newolqty - $newolqty1 ;					  // 共出几个
											echo 'OLD='.$newolqty.' NEW= '.$newolqty1.' changeqty= '.$nowqty.' Item  ID:'.$ItemID.'<br>';

											if($nowqty > 0 && $track_stock == 0 ){
												$chageqty			= $nowqty + $newolqty1;
												$runstatus			= ModbyItemIDsku($chageqty,$token,$ItemID,$account,$SKU,$VariationSpecifics,$SiteIDS);
												if($runstatus == 1) $QuantityAvailable = $chageqty;
											}
											$rr	= "update ebay_listvariations set Quantity ='$Quantity' , QuantitySold ='$QuantitySold' , StartPrice='$StartPrice',QuantityAvailable='$QuantityAvailable',VariationSpecifics='$tjstr' where ebay_account ='$account' and ItemID ='$ItemID' and SKU='$SKU' ";
											$dbcon->execute($rr);
											
										}
										
								}
										
							}




						




							}
				}else{
					
					echo '<br>not found';


				}

			 }
		
		}
	   
	   
 ?>

            
