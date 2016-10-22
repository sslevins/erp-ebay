<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>跟踪指定的Listing信息</title>

<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/yui.css" />
<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/deprecated.css" />
<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/style.css" /
<style type="text/css">
<!--
.STYLE2 {font-size: 12}
-->
</style>
</head>

<body>
<?php
	
	include "include/config.php";
	
	
	$delid		= $_REQUEST['delid'];
	if($delid > 0){
			$vv		= "delete from ebay_tracklist where id='$delid' and ebay_user ='$user'";
			$dbcon->execute($vv);
	}
	
	
	function GetSingleItem($ItemID){

			 global $devID,$appID,$certID,$serverUrl,$siteID,$detailLevel,$compatabilityLevel,$dbcon,$user,$nowtime,$truename;
			 
			 if($truename == '') $truename = $user;
			 
			 $compatabilityLevel	= '741';
			 $verb = 'GetSingleItem';
			 $xmlRequest		= '<?xml version="1.0" encoding="utf-8"?>
<GetSingleItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
  <IncludeSelector>Details</IncludeSelector>
  <ItemID>170786097936</ItemID>
</GetSingleItemRequest>';
			 $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
			 $responseXml = $session->sendHttpRequest($xmlRequest);

			 
			 if(stristr($responseXml, 'HTTP 404') || $responseXml == '') return 'id not found';
			 $data	= XML_unserialize($responseXml);
			 
			 
			 print_r($data);
			 
			

		}
	
	
	$type		= $_REQUEST['type'];
	$id			= $_REQUEST['id'];
	
	if($type == 'mod' ){
		
		$track_price		= $_REQUEST['track_price'];
		$track_stock		= $_REQUEST['track_stock'];
		$addprice			= $_REQUEST['addprice'];
		$hightprice			= $_REQUEST['hightprice'];
		$jianprice			= $_REQUEST['jianprice'];
		$lawprice			= $_REQUEST['lawprice'];
		
		
		
		$itemnumber			= $_REQUEST['itemnumber'];
		
		$url				= 'http://open.api.ebay.com/shopping?callname=GetSingleItem&responseencoding=XML&appid=Survyc487-9ec7-4317-b443-41e7b9c5bdd&siteid=0&ItemID='.$itemnumber.'&version=781&IncludeSelector=Details';
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
				$ItemID							= $data['GetSingleItemResponse']['Item']['ItemID'];
				
				$vv								= "insert into ebay_tracklist(UserID,FeedbackScore,PositiveFeedbackPercent,TopRatedSeller,CurrentPrice,ListingStatus,QuantitySold,Site,Title,currencyID,ebay_user,ItemID,trackid) values('$UserID','$FeedbackScore','$PositiveFeedbackPercent','$TopRatedSeller','$CurrentPrice','$ListingStatus','$QuantitySold','$Site','$Title','$currencyID','$user','$ItemID','$id')";
				$dbcon->execute($vv);
	
						
		}else{
			echo '取得指定的Item 信息失败';
			
		
		}

		
		$sql				= "update ebay_list set track_price ='$track_price',track_stock ='$track_stock',addprice='$addprice', hightprice='$hightprice',jianprice='$jianprice',lawprice='$lawprice' where id ='$id' ";
		$dbcon->execute($sql);
	}
	
	
	
	
	
	$sql		= "select * from ebay_list where ebay_user ='$user' and id ='$id' ";
	$sql		= $dbcon->execute($sql);
	$sql		= $dbcon->getResultArray($sql);
	
	$track_price	= $sql[0]['track_price'];
	$track_stock	= $sql[0]['track_stock'];
	
	$addprice		= $sql[0]['addprice'];
	$hightprice		= $sql[0]['hightprice'];
	$jianprice		= $sql[0]['jianprice'];
	$lawprice		= $sql[0]['lawprice'];
	$itemid			= $sql[0]['ItemID'];
	



?>
<table width="100%" border="1" cellspacing="3">
  <tr>
    <td width="26%" valign="top"><span class="STYLE2">1.是否启用价格跟踪：</span></td>
    <td width="74%"><span class="STYLE2">
      <select name="track_price" id="track_price">
        <option value="0" <?php if($track_price == '0') echo 'selected="selected"';?>>启用</option>
        <option value="1" <?php if($track_price == '1') echo 'selected="selected"';?>>不启用</option>
        </select>
    &nbsp;<br />
    
    价格变动基数：
    <input name="jianprice" type="text" id="jianprice" value="<?php echo $jianprice;?>" />
    </span><br />
    最高上限：
    <input name="hightprice" type="text" id="hightprice" value="<?php echo $hightprice;?>" />
    最低下限：    
    <input name="lawprice" type="text" id="lawprice" value="<?php echo $lawprice;?>" />
    <br /></td>
  </tr>
  <tr>
    <td><span class="STYLE2">2.是否启用数量自动调整：</span></td>
    <td><span class="STYLE2">
      <select name="track_stock" id="track_stock">
        <option value="0" <?php if($track_stock == '0') echo 'selected="selected"';?>>启用</option>
        <option value="1" <?php if($track_stock == '1') echo 'selected="selected"';?>>不启用</option>
      </select>
    </span></td>
  </tr>
  <tr>
    <td colspan="2"><span class="STYLE2">3.监控指定Item ID的价格，(在下表中，系统会以最低的一个产品价格为准，进行自动变换价格)</span></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="1">
      <tr>
        <td class="STYLE2">编号</td>
        <td class="STYLE2">eBay帐号/好评数/好评率</td>
        <td class="STYLE2">是否Top帐号</td>
        <td class="STYLE2">物品编号</td>
        <td class="STYLE2">售出数量</td>
        <td class="STYLE2">当前售价</td>
        <td class="STYLE2">操作</td>
      </tr>
      <?php
	  		
			
			$sql		= "select * from ebay_tracklist where ebay_user ='$user' and trackid ='$id' ";
			$sql		= $dbcon->execute($sql);
			$sql		= $dbcon->getResultArray($sql);
			
			for($i=0;$i<count($sql);$i++){
				
				$id								= $sql[$i]['id'];
				$UserID							= $sql[$i]['UserID'];
				$FeedbackScore					= $sql[$i]['FeedbackScore'];
				$PositiveFeedbackPercent		= $sql[$i]['PositiveFeedbackPercent'];
				$CurrentPrice					= $sql[$i]['CurrentPrice'];
				$ListingStatus					= $sql[$i]['ListingStatus'];
			  	$QuantitySold					= $sql[$i]['QuantitySold'];
			  	$Site							= $sql[$i]['Site'];
			    $Title							= $sql[$i]['Title'];
			    $currencyID						= $sql[$i]['currencyID'];
			    $ItemID							= $sql[$i]['ItemID'];
				$TopRatedSeller					= $sql[$i]['TopRatedSeller'];
	  ?>
      
      <tr>
        <td class="STYLE2"><?php echo $i+1;?>&nbsp;</td>
        <td class="STYLE2"><?php echo $UserID;?>(<?php echo $FeedbackScore;?>) <?php echo $PositiveFeedbackPercent.'%';?>&nbsp;</td>
        <td class="STYLE2"><?php echo $TopRatedSeller;?>&nbsp;</td>
        <td class="STYLE2"><?php echo  $ItemID;?>&nbsp;</td>
        <td class="STYLE2"><?php echo $QuantitySold;?>&nbsp;</td>
        <td class="STYLE2"><?php echo $currencyID.': '.$CurrentPrice;?>&nbsp;</td>
        <td class="STYLE2"><a href="#" onclick="delitems('<?php echo $id; ?>')">删除</a>&nbsp;</td>
      </tr>
      <?php } ?>
      <tr>
        <td colspan="7" class="STYLE2">添加一个ItemNumber：
          <input name="itemnumber" type="text" id="itemnumber" />&nbsp;
          <input type="button" value="保存设置" onclick="save2()" /></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2"><span class="STYLE2"><br />
      <br />
    List 操作日志</span></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="1" cellspacing="0" cellpadding="0">
      <tr>
        <td>操作时间</td>
        <td>物品编号</td>
        <td>操作记录</td>
        <td>操作人</td>
        </tr>
      
      <?php
	  	
		
		$sql		= "select * from ebay_listlog where ebay_user ='$user' and itemid ='$itemid' order by id desc ";
		$sql		= $dbcon->execute($sql);
		$sql		= $dbcon->getResultArray($sql);
	  	
		for($i=0;$i<count($sql);$i++){
			
			$itemid			= $sql[$i]['itemid'];
			$account		= $sql[$i]['account'];
			$logs			= $sql[$i]['logs'];
			$addtime		= $sql[$i]['addtime'];
			$currentuser	= $sql[$i]['currentuser'];
			
		
	  ?>
      <tr>
        <td><?php echo $addtime;?>&nbsp;</td>
        <td><?php echo $itemid;?>&nbsp;</td>
        <td><?php echo $logs;?>&nbsp;</td>
        <td><?php echo $currentuser;?>&nbsp;</td>
        </tr>
        
      <?php
	  
	  }
	  
	  
	  ?>
      
    </table></td>
  </tr>
</table>
</body>
</html>
<script language="javascript">
	
	function save2(){
	
		
		var 	track_price		= document.getElementById('track_price').value;
		var 	track_stock		= document.getElementById('track_stock').value;
		
		var 	addprice		= '';
		var 	hightprice		= document.getElementById('hightprice').value;
		var 	jianprice		= document.getElementById('jianprice').value;
		var 	lawprice		= document.getElementById('lawprice').value;
		var 	itemnumber		= document.getElementById('itemnumber').value;
		
		
		var 	url				= 'track_list.php?id=<?php echo $_REQUEST['id']; ?>&track_price='+track_price+'&track_stock='+track_stock+'&addprice='+addprice+'&hightprice='+hightprice+'&jianprice='+jianprice+'&lawprice='+lawprice+'&itemnumber='+itemnumber+"&type=mod";
		location.href		= url;
	}
	
	function delitems(id){
			var url			= 'track_list.php?id=<?php echo $_REQUEST['id']; ?>&delid='+id;
			
			if(confirm('是否确认删除此条功能')){
			location.href		= url;
			
			}
			
			
	}



</script>