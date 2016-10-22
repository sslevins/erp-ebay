<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/yui.css" />



<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/deprecated.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 


<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/style.css" /> 


<?php
include "include/config.php";






	$billstr		= $_REQUEST['billstr'];
	$billstr		= explode("@@",$billstr);
	for($i=0;$i<count($billstr);$i++){
	
		
		$linestr	= explode('*',$billstr[$i]);
	
		
		
		
		if(count($linestr) == 4){
			
			$id						= $linestr[0];
			$StartPrice				= $linestr[1];
			$Quantity				= $linestr[2];
			
			$SKUd					= $linestr[3];
			$vv						= "select * from ebay_list where id ='$id' ";
			$ss						= $dbcon->execute($vv);
			$ss						= $dbcon->getResultArray($ss);
			$SKU					= $ss[0]['SKU'];
			$ItemID					= $ss[0]['ItemID'];
			$ebay_account			= $ss[0]['ebay_account'];
			
			
			$StartPricecurrencyID	= $ss[0]['StartPricecurrencyID'];
			$siteID0				= 0;
			if($StartPricecurrencyID == 'AUD') $siteID0 = 15;
			if($StartPricecurrencyID == 'GBP') $siteID0 = 3;
			if($StartPricecurrencyID == 'EUR') $siteID0 = 77;
			
			
			
			
			$vv						= "select * from ebay_account where ebay_account ='$ebay_account' ";
			$ss						= $dbcon->execute($vv);
			$ss						= $dbcon->getResultArray($ss);
			$ebay_token				= $ss[0]['ebay_token'];
			$verb = 'ReviseFixedPriceItem';
			$xmlRequest		= '<?xml version="1.0" encoding="utf-8"?><ReviseFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
			  <ErrorLanguage>en_US</ErrorLanguage>
			  <WarningLevel>High</WarningLevel>
			  <Item>
				<ItemID>'.$ItemID.'</ItemID>
				<StartPrice>'.$StartPrice.'</StartPrice>
				 <Quantity>'.$Quantity.'</Quantity>
				 <SKU>'.$SKUd.'</SKU>
			  </Item>
			  <RequesterCredentials>
				<eBayAuthToken>'.$ebay_token.'</eBayAuthToken>
			  </RequesterCredentials>
			  <WarningLevel>High</WarningLevel>
			</ReviseFixedPriceItemRequest>';
			 $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID0, $verb);
			 $responseXml = $session->sendHttpRequest($xmlRequest);
			 if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';
			 $data	= XML_unserialize($responseXml);	

print_r($data);


			 $Ack		= $data['ReviseFixedPriceItemResponse']['Ack'];
			 if($Ack != 'Failure'){
			 	
					echo '<br>ebay Account.'.$ebay_account.' 物品编号: '.$ItemID.' SKU:'.$SKU.' ebay 返回状态: '.$Ack;
					
					
			 		$vv		= "update ebay_list set StartPrice='$StartPrice',QuantityAvailable='$Quantity',SKU='$SKUd' where id ='$id' ";
					$dbcon->execute($vv);
					
					$logs			=  '编号: '.$ItemID.' SKU:'.$SKU.'价格为:'.$StartPrice.' 数量是:'.$Quantity.' 状态: '.$Ack;
					$sql			= "insert into ebay_listlog(itemid,account,logs,ebay_user,addtime,currentuser) values('$ItemID','$ebay_account','$logs','$user','$nowtime','$truename')";
					$dbcon->execute($sql);
			 
					
			 }else{
			 
			 		echo '<br>ebay Account.'.$ebay_account.' 物品编号: '.$ItemID.' SKU:'.$SKU.' ebay 返回状态: '.$Ack;
					
					$logs			=  '编号: '.$ItemID.' SKU:'.$SKU.'价格为:'.$StartPrice.' 数量是:'.$Quantity.' 状态: '.$Ack;
					$sql			= "insert into ebay_listlog(itemid,account,logs,ebay_user,addtime,currentuser) values('$ItemID','$ebay_account','$logs','$user','$nowtime','$truename')";
					$dbcon->execute($sql);
					
					
			 }
			 
			
			
			
			
		
		}
		
		
	
	
	}
	

	
	$billstr		= $_REQUEST['billstr2'];

	$billstr		= explode("@@",$billstr);
	
	
	

	
	for($i=0;$i<count($billstr);$i++){
	
		
		$linestr	= explode('*',$billstr[$i]);



		
		if(count($linestr) == 4){
			
			$id						= $linestr[0];
			$StartPrice				= $linestr[1];
			$Quantity				= $linestr[2];
			
			
			$newsku					= $linestr[3];
			
			$vv						= "select * from ebay_listvariations where id ='$id' ";
			$ss						= $dbcon->execute($vv);
			$ss						= $dbcon->getResultArray($ss);
			$SKU					= $ss[0]['SKU'];
			$ItemID					= $ss[0]['itemid'];
			$ebay_account			= $ss[0]['ebay_account'];
			
			
			
			$VariationSpecifics					= $ss[$i]['VariationSpecifics'];
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
			
			
			
			
			
			
			$vv						= "select * from ebay_list where ItemID ='$ItemID' ";
			$ss						= $dbcon->execute($vv);
			$ss						= $dbcon->getResultArray($ss);
			$StartPricecurrencyID	= $ss[0]['StartPricecurrencyID'];
			$siteID0				= 0;
			if($StartPricecurrencyID == 'AUD') $siteID0 = 15;
			if($StartPricecurrencyID == 'GBP') $siteID0 = 3;
			if($StartPricecurrencyID == 'EUR') $siteID0 = 77;
			
			
			
		
			
			
			
			$vv						= "select * from ebay_account where ebay_account ='$ebay_account' ";
			$ss						= $dbcon->execute($vv);
			$ss						= $dbcon->getResultArray($ss);
			$ebay_token				= $ss[0]['ebay_token'];
			$verb = 'ReviseFixedPriceItem';
			$xmlRequest		= '<?xml version="1.0" encoding="utf-8"?><ReviseFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
			  <ErrorLanguage>en_US</ErrorLanguage>
			  <WarningLevel>High</WarningLevel>
			  <Item>
				<ItemID>'.$ItemID.'</ItemID>
					<Variations>
      <Variation>';
	  
	  
	  if($SKU !=  $newsku) $xmlRequest .= '<SKU>'.$newsku.'</SKU>';
	  
	  if($SKU ==  $newsku) $xmlRequest .= '<SKU>'.$SKU.'</SKU>';
	  
	  if($variationSpecificsstr != '' ) $xmlRequest .= '<VariationSpecifics>'.$variationSpecificsstr.'</VariationSpecifics>';
		$xmlRequest	.= '<StartPrice>'.$StartPrice.'</StartPrice>
				 			<Quantity>'.$Quantity.'</Quantity>
					</Variation>
    </Variations>
    
	
			  </Item>
			  <RequesterCredentials>
				<eBayAuthToken>'.$ebay_token.'</eBayAuthToken>
			  </RequesterCredentials>
			  <WarningLevel>High</WarningLevel>
			</ReviseFixedPriceItemRequest>';
			

	



			
			 $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID0, $verb);
			 $responseXml = $session->sendHttpRequest($xmlRequest);
			 if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';
			 $data	= XML_unserialize($responseXml);
			 $Ack		= $data['ReviseFixedPriceItemResponse']['Ack'];
			 
	
			 if($Ack != 'Failure'){
			 	
					echo '<br>ebay Account.'.$ebay_account.' 物品编号: '.$ItemID.' SKU:'.$SKU.' ebay 返回状态: '.$Ack;
			 		$vv		= "update ebay_listvariations set StartPrice='$StartPrice',QuantityAvailable='$Quantity',SKU='$newsku' where id ='$id' ";
					$dbcon->execute($vv);
					
					
					
					
					
			 }else{
			 
			 		echo '<br>ebay Account.'.$ebay_account.' 物品编号: '.$ItemID.' SKU:'.$SKU.' ebay 返回状态: '.$Ack;
			 }
			 
		}
	}
	die();
	
	$id		= $_REQUEST["id"];

	

		
			
			
			$ss		= "select * from ebay_list where ebay_user ='$user' and SKU ='$sku' and ListingType != 'Chinese '";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			for($i=0;$i<count($ss);$i++){
			$ebay_account		= $ss[$i]['ebay_account'];
			$id					= $ss[$i]['id'];
			
			
			$ItemID				= $ss[$i]['ItemID'];
			
			
			$price				= $accs[$ebay_account];
			$stock				= $accstock[$ebay_account];

			
			
			$token				= geteBayaccountToken($ebay_account);
			/* 开始修改状态 */
			$verb = 'ReviseFixedPriceItem';
			$xmlRequest		= '<?xml version="1.0" encoding="utf-8"?><ReviseFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
			  <ErrorLanguage>en_US</ErrorLanguage>
			  <WarningLevel>High</WarningLevel>
			  <Item>
				<ItemID>'.$ItemID.'</ItemID>
				<StartPrice>'.$price.'</StartPrice>
				<SKU>'.$SKU.'</SKU>
				 <Quantity>'.$stock.'</Quantity>
			  </Item>
			  <RequesterCredentials>
				<eBayAuthToken>'.$token.'</eBayAuthToken>
			  </RequesterCredentials>
			  <WarningLevel>High</WarningLevel>
			</ReviseFixedPriceItemRequest>';
			
			 $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
			 $responseXml = $session->sendHttpRequest($xmlRequest);
			 if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';
			 $data	= XML_unserialize($responseXml);
			 
			 print_r($data);
			 
			
			
			 $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
			 $responseXml = $session->sendHttpRequest($xmlRequest);
			 if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';
			 $data	= XML_unserialize($responseXml);
			 
			 
			 
			 
			 $status = $data['ReviseFixedPriceItemResponse']['Ack'];
			 
			 echo '<br> Item ID:'.$ItemID.' SKU: '.$sku.' 更新状态:'.$status;
			 if($status == 'Success') {
			 
			 $ss		= " update ebay_list set StartPrice	='$price' where id= '$id' ";
			 $dbcon->execute($ss);
			 
			 
			 }

			}
			
			/* 结束 */
			
			
			/* 检查主能源工业listing */
			
			
			$ss		= "select * from ebay_listvariations where SKU ='$sku' ";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			for($i=0;$i<count($ss);$i++){
			$ebay_account		= $ss[$i]['ebay_account'];
			
			
			$price				= $accs[$ebay_account];
			$stock				= $accstock[$ebay_account];
			
			
			
			
			
			$id					= $ss[$i]['id'];
			$SKU				= $ss[$i]['SKU'];
			$ItemID				= $ss[$i]['itemid'];
			$token				= geteBayaccountToken($ebay_account);
		
			
			/* 开始修改状态 */
			$verb = 'ReviseFixedPriceItem';
			$xmlRequest		= '<?xml version="1.0" encoding="utf-8"?><ReviseFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
			  <ErrorLanguage>en_US</ErrorLanguage>
			  <WarningLevel>High</WarningLevel>
			  <Item>
				<ItemID>'.$ItemID.'</ItemID>
					<Variations>
      <Variation>
    
				<StartPrice>'.$price.'</StartPrice>';
				
				
		   if($SKU != '') $xmlRequest   .= '<SKU>'.$SKU.'</SKU>';
				
			$xmlRequest	= '<Quantity>'.$stock.'</Quantity>
				</Variation>
    </Variations>
			  </Item>
			  <RequesterCredentials>
				<eBayAuthToken>'.$token.'</eBayAuthToken>
			  </RequesterCredentials>
			  <WarningLevel>High</WarningLevel>
			</ReviseFixedPriceItemRequest>';
			

			 $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
			 $responseXml = $session->sendHttpRequest($xmlRequest);
			 if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';
			 $data	= XML_unserialize($responseXml);
			 
			 
			 $status = $data['ReviseFixedPriceItemResponse']['Ack'];
			 
			 echo '<br>子 Item ID:'.$ItemID.' SKU: '.$sku.' 更新状态:'.$status;
			 if($status == 'Success') {
			 
			 $ss		= " update ebay_listvariations set StartPrice	='$price' where id= '$id' ";
			 $dbcon->execute($ss);
			 
			 
			 }

			}
			
			/* 结束 */
			
		
			



?>

<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status;?></h2>
</div>
 
<div class='listViewBody'>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td width="26%">
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'>			
                      <form id="form" name="form" method="post" action="listing_batchupdate.php?module=list&action=">
                  <table width="78%" border="1" cellpadding="0" cellspacing="0">
                <input name="id" type="hidden" value="<?php echo $id;?>">
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">在线SKU：</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><input name="sku" type="text" id="sku" /></td>
			        </tr>
			      
			      <tr>
                    <td width="41%" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right"><span style="white-space: nowrap;">把价格调整为：	 </span>:</div></td>
                    <td width="3%" align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
                    <td width="56%" align="right" bgcolor="#f2f2f2" class="left_txt">
                      
                        <div align="left"></div></td>
                    </tr>
			      

			      
			      

			      
                  <tr>				 
                    <td align="right" class="left_txt"><div align="right"></div></td>
                    <td align="right" class="left_txt">&nbsp;</td>
                    <td align="right" class="left_txt"><div align="left">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td>店铺名称</td>
                          <td>价格(价格不能为空，否则将提交不成功)</td>
                          <td>在线数量</td>
                        </tr>
                        <?php
						
						
						$ss		= "select * from ebay_account where ebay_user ='$user' ";
						$ss		= $dbcon->execute($ss);
						$ss		= $dbcon->getResultArray($ss);
						for($i=0;$i<count($ss);$i++){
						
						
						
						$ebay_account		= $ss[$i]['ebay_account'];
						
						
						
						
						?>
                        
                        
                        <tr>
                          <td><?php echo $ebay_account;?>&nbsp;</td>
                          <td><input name="sale[]" type="text" id="sale[]" /></td>
                          <td><input name="stock[]" type="text" id="stock[]" /></td>
                        </tr>
                        
                        <?php
						
						
						}
						
						?>
                      </table>
                    </div></td>
                    </tr>
                  <tr>
                    <td align="right" class="left_txt">&nbsp;</td>
                    <td align="right" class="left_txt">&nbsp;</td>
                    <td align="left" class="left_txt"><input name="submit" type="submit" value="保存数据" onclick="return check()" /></td>
                  </tr>
                </table>
                 </form> 
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


    <div class="clear"></div>
