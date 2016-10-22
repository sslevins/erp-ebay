<?php

include "include/config.php";

$ordersn	= $_REQUEST['ordersn'];
$order		= explode(",",$ordersn);


$str		= '';

for($i=0;$i<count($order);$i++){
	
		
		if($order[$i] != ""){
		
			$sn			= $order[$i];
			$sq			= "select * from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn=b.ebay_ordersn where a.ebay_id='$sn'";
			
			
			$sq			= $dbcon->execute($sq);
			$sq			= $dbcon->getResultArray($sq);
			$account	= $sq[0]['ebay_account'];		
			$ebay_userid	= $sq[0]['ebay_userid'];
			$recordnumber	= $sq[0]['recordnumber'];
			$str .= "({$recordnumber})".$ebay_userid."<br>";
			
			
		}
		
		
		
}

			


?>

<style type="text/css">
<!--
.STYLE1 {font-size: 12px}
-->
</style>
<form id="form" name="form" method="post" action="ordermarket02.php?ordersn=<?php echo $ordersn;?>">

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  
  <tr>
    <td height="68" valign="top"><span class="STYLE1">发信内容：</span></td>
    <td><span class="STYLE1"></span>
    <textarea name="content" cols="60" rows="15" id="content"></textarea></td>
  </tr>
  <tr>
    <td height="64" valign="top"><span class="STYLE1">Message模板</span></td>
    <td valign="top"><span class="STYLE1">
      <select name="category<?php echo $mid;?>" id="category" onchange="ck(this)">
        <option value="">请选择</option>
        <?php
	
		$su		= "select * from ebay_messagetemplate where ebay_user='$user' order by ordersn desc";
		$su		= $dbcon->execute($su);
		$su		= $dbcon->getResultArray($su);
		for($o=0;$o<count($su);$o++){
			
			$name		= $su[$o]['name'];
			$content	= $su[$o]['content'];
			
		?>
        <option value="<?php echo $content; ?>"><?php echo $name;?></option>
        <?php } ?>
      </select>
    <input name="submit" type="submit" value="发送" id="submit" />
    </span></td>
  </tr>
</table>
</form>


<?php
	
	if($_POST['submit']){
	
	
		$order		= explode(",",$ordersn);
	
	
	
	
	
	for($i=0;$i<count($order);$i++){
	
		
		if($order[$i] != ""){
		
			$sn			= $order[$i];
			$sq			= "select a.*,b.ebay_itemid,b.ebay_itemtitle from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn=b.ebay_ordersn where a.ebay_id='$sn'";
			
			
			$sq			= $dbcon->execute($sq);
			$sq			= $dbcon->getResultArray($sq);
			$account	= $sq[0]['ebay_account'];		
			$ebay_userid= $sq[0]['ebay_userid'];
			$itemid		= $sq[0]['ebay_itemid'];		
			$title		= $sq[0]['ebay_itemtitle'];		
			$cname		= $sq[0]['ebay_username'];
			$ebay_tracknumber		= $sq[0]['ebay_tracknumber'];
			$ShippedTime 	= $sq[0]['ebay_markettime'];
			
			
			$sql 		 = "select * from ebay_account where ebay_user='$user' and ebay_account='$account'";
			
			
			$sql		 = $dbcon->execute($sql);
			$sql		 = $dbcon->getResultArray($sql);
			$token		 = $sql[0]['ebay_token'];
			
	
			
			$messagecontent	= $_POST['content'];
			$ShippedTime	= date('Y-m-d',$ShippedTime);
				$ShippedTime7	= date('Y-m-d',strtotime("$ShippedTime +7days"));
				$ShippedTime9	= date('Y-m-d',strtotime("$ShippedTime +9days"));
				$ShippedTime14	= date('Y-m-d',strtotime("$ShippedTime +14days"));
				$ShippedTime21	= date('Y-m-d',strtotime("$ShippedTime +21days"));
				$ShippedTime30	= date('Y-m-d',strtotime("$ShippedTime +30days"));
				$messagecontent		= str_replace('{Post_Date}',$ShippedTime,$messagecontent);
				$messagecontent		= str_replace('{Post_Date_7}',$ShippedTime7,$messagecontent);
				$messagecontent		= str_replace('{Post_Date_9}',$ShippedTime9,$messagecontent);
				$messagecontent		= str_replace('{Post_Date_14}',$ShippedTime14,$messagecontent);
				$messagecontent		= str_replace('{Post_Date_21}',$ShippedTime21,$messagecontent);
				$messagecontent		= str_replace('{Post_Date_30}',$ShippedTime30,$messagecontent);
				$messagecontent		= str_replace('{Today}',date('Y-m-d'),$messagecontent);
			$messagecontent		= str_replace('{Track_Code}',$ebay_tracknumber,$messagecontent);
			$messagecontent		= str_replace('{Buyerid}',$ebay_userid,$messagecontent);
			$messagecontent		= str_replace('{Buyername}',$cname,$messagecontent);
		 	$messagecontent		= str_replace('{Buyercountry}',$countryname,$messagecontent);
		 	$messagecontent		= str_replace('{Sellerid}',$account,$messagecontent);
			$messagecontent		= str_replace('{Itemnumber}',$itmeid,$messagecontent);
		 	$messagecontent		= str_replace('{Itemtitle}',$title,$messagecontent);
		 	$messagecontent		= str_replace('{Itemquantity}',"1",$messagecontent);
			$messagecontent		= str_replace('{Shipdate}',$ebay_markettime,$messagecontent);
			$messagecontent		= str_replace('{Shippingaddress}',$addressline,$messagecontent);
			$messagecontent		= str_replace("&","&amp;",$messagecontent);	

					
			$status	=  addmessagetoparner($messagecontent,$token,'',$itemid,$ebay_userid);
			echo $ebay_userid." 回复状态：".$status."<br>";
		}
	
	}
	
	
		
		
	
	
	}


?>

<script>
	
		
	function ck(ck){
	
	
		var va		= ck.value;
		document.getElementById('content').value	= va;
		

		
		
	
	}
	

</script>
