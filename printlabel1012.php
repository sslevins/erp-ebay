<?php
include "include/config.php";
$ordersn	= $_REQUEST['ordersn'];
$ordersn		= explode(",",$ordersn);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EUB</title>
<style type="text/css">
<!--
.STYLE5 {font-size: 10px}
-->
</style>
</head>

<body>

<?php

	
	$tj		= '';
	for($i=0;$i<count($ordersn);$i++){
		
		
			if($ordersn[$i] != ""){
		
			 $sn			= $ordersn[$i];
			 
		$tj	.= "a.ebay_id='$sn' or ";
			}
			
		
	}
	
	
	$tj		= substr($tj,0,strlen($tj)-3);

	
	
			$Shipping		= $_REQUEST['Shipping'];
			$ostatus		= $_REQUEST['ostatus'];

if($_REQUEST['ordersn'] != ''){
			
			$sql			= "select a.*,b.sku from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn=b.ebay_ordersn where a.ebay_userid !=''  and ($tj) group by a.ebay_id order by b.goods_location,b.sku ";
		
			}else{
			
			
			$sql			= "select a.*,b.sku from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn=b.ebay_ordersn where a.ebay_userid !='' and ebay_carrier='$Shipping' and ebay_status='$ostatus' and ebay_combine!='1' and ($ebayacc) group by a.ebay_id order by b.goods_location,b.sku ";
			
			}
		
			
			
			
			
			
	 $ss			= $dbcon->execute($sql);
	 $ss			= $dbcon->getResultArray($ss);
	 

	
	
	for($i=0;$i<count($ss);$i++){
	

			
		$ebay_noteb			= $ss[$i]['ebay_noteb'];	 

$ordersn			= $ss[$i]['ebay_ordersn'];



 $bb		= "select * from ebay_orderdetail where ebay_ordersn ='$ordersn'";

		 
		 $gg		= $dbcon->execute($bb);
		 $gg		= $dbcon->getResultArray($gg);
		 
		 $totalqty	= 0;
		 
		 $ebay_itemtitle	= '';
		 
		 $goods_sbjz		= 0;
		 
		 for($t=0;$t<count($gg);$t++){
		 	
			$sku			= $gg[$t]['sku'];
			$ebay_amount	= $gg[$t]['ebay_amount'];
			$ebay_itemtitle			.= $gg[$t]['ebay_itemtitle'].'<br>';
			$totalqty		= $totalqty + $ebay_amount;
			
			
			
			$ee					= "SELECT * FROM ebay_goods where goods_sn='$sku' and ebay_user='$user'";
			$ee					= $dbcon->execute($ee);
			$ee 			 	= $dbcon->getResultArray($ee);
			$goods_sbjz			+=  $ee[0]['goods_sbjz'];			
			
			
			}
			
			$ebay_id			= $ss[$i]['ebay_id'];		
			 $ebay_total			= $ss[$i]['ebay_total'];
			$ebay_usermail			= $ss[$i]['ebay_usermail'];
			$ebay_userid			= $ss[$i]['ebay_userid'];	
			$name					= $ss[$i]['ebay_username'];
			$street1				= @$ss[$i]['ebay_street'];
			$street2 				= @$ss[$i]['ebay_street1'];
			$city 					= $ss[$i]['ebay_city'];
			$state					= $ss[$i]['ebay_state'];
			$countryname 			= $ss[$i]['ebay_countryname'];
			$ebay_account 			= $ss[$i]['ebay_account'];
			$zip					= $ss[$i]['ebay_postcode'];
			$recordnumber					= $ss[$i]['recordnumber'];
			$ebay_tracknumber					= $ss[$i]['ebay_tracknumber'];
					$rr				= "select * from ebay_account where ebay_account='$ebay_account'";
		$rr				= $dbcon->execute($rr);
		$rr				= $dbcon->getResultArray($rr);
		$id				= $rr[0]['id'];
		$rr				= "select * from eub_account where pid='$id'";
		$rr					= $dbcon->execute($rr);
		$rr					= $dbcon->getResultArray($rr);
		$dname					= $rr[0]['dname'];
		$dstreet					= $rr[0]['dstreet'];
		$dcity					= $rr[0]['dcity'];
		$dprovince					= $rr[0]['dprovince'];
			$dzip					= $rr[0]['dzip'];
			$dtel					= $rr[0]['dtel'];
			
			$zip0					= explode("-",$zip);
			if(count($zip0) >=2){
				
				$zip				= $zip0[0];
				
				
			}
			
			
			$isd					= substr($zip,0,1);
			if($isd>=6){
			
			$isd		= '2';
				
				
			}else{
				
			$isd		= '1';	
			}
			
			$tel					= $ss[$i]['ebay_phone'];
			if($tel == 'Invalid Request') $tel = '';
			
			if($street2 == ''){
				
				$addressline	= $name."<br>".$street1."<br>".$city." ".$state."<br>".$countryname." ".$zip;
				
			}else{
				
				
				$addressline	= $name."<br>".$street1."<br>".$street2."<br>".$city." ".$state."<br>".$countryname." ".$zip;
			}
			
		


 ?>
<table width="100%" height="100" border="0" cellpadding="0" cellspacing="0" style="border:1px dashed #999999; ">
  <tr>
    <td width="189" valign="top"  style="border-right:#000000 1px dashed"><table width="142" border="0" cellpadding="0" cellspacing="0" style="table-layout:fixed; overflow: scroll;word-break:break-all;">
      <tr>
        <td><span class="STYLE5"><?php echo '订单号:'.$ebay_id;?>&nbsp;</span></td>
      </tr>
      <tr>
        <td><span class="STYLE5"><?php echo '运输方式:'.$ebay_carrier;?>&nbsp;</span></td>
      </tr>
      <tr>
        <td><span class="STYLE5">重量:</span><span class="STYLE5">
          <?php
				echo $orderweight;
				
				
			
			
			?>
          &nbsp;</span></td>
      </tr>
      <tr>
        <td><span class="STYLE5">客户:<?php echo $ebay_userid;?></span></td>
      </tr>
      <tr>
        <td><span class="STYLE5">帐号:</span><span class="STYLE5"><?php echo $ebay_account;?></span></td>
      </tr>
      <tr>
        <td>总金额:<span class="STYLE5"><?php echo $ebay_total;?></span></td>
      </tr>
      <tr>
        <td>申报价值:<span class="STYLE5"><?php echo $goods_sbjz; ?></span></td>
      </tr>
      <tr>
        <td><?php echo $appname;
			echo '<br>'.($i+1).'/'.$totalpages;
			
			
			?>&nbsp;</td>
      </tr>
    </table></td>
    <td width="442" valign="top" style="border-right:#000000 1px dashed" ><table width="100%" border="0" cellspacing="0" cellpadding="0" style="word-break:break-all;">
      <?php
		 $bb		= "select * from ebay_orderdetail where ebay_ordersn ='$ordersn'";

		 
		 $gg		= $dbcon->execute($bb);
		 $gg		= $dbcon->getResultArray($gg);
		 
		 $totalqty	= 0;
		 
		 $ebay_itemtitle	= '';
		 
		 
		 for($t=0;$t<count($gg);$t++){
		 	
			$sku			= $gg[$t]['sku'];
			$ebay_amount	= $gg[$t]['ebay_amount'];
			$ebay_itemtitle			.= ($t+1).'. '.$gg[$t]['ebay_itemtitle'].'<br>';

			
			
			
			
			
			$ee					= "SELECT * FROM ebay_goods where goods_sn='$sku' and ebay_user='$user'";
			$ee					= $dbcon->execute($ee);
			$ee 			 	= $dbcon->getResultArray($ee);
			$goods_location		=  $ee[0]['goods_location'];			
			
			$rr			= "select * from ebay_productscombine where ebay_user='$user' and goods_sn='$sku'";
			$rr			= $dbcon->execute($rr);
			$rr 	 	= $dbcon->getResultArray($rr);
				
			if(count($rr) > 0){
			
									$goods_sncombine	= $rr[0]['goods_sncombine'];
									$goods_sncombine    = explode(',',$goods_sncombine);	
									
									
									for($e=0;$e<count($goods_sncombine);$e++){
						
						
											$pline			= explode('*',$goods_sncombine[$e]);
											$goods_sn		= $pline[0];
											$goddscount     = $pline[1] * $ebay_amount;
											$totalqty		= $totalqty + $goddscount;
											$ee			= "SELECT * FROM ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
											$ee			= $dbcon->execute($ee);
											$ee 	 	= $dbcon->getResultArray($ee);
											$goods_location		=  $ee[0]['goods_location'];			
								
												
			
		 
		 ?>
      <tr>
        <td><strong><?php echo '['.$goods_location.']';?>&nbsp;<?php echo $goods_sn.'*'.$goddscount; ?></strong></td>
      </tr>
      <?php
	   
	   }
	
	   }else{
	   
	   
	   $totalqty		= $totalqty + $ebay_amount;
	   
	   ?>
      <tr>
        <td><strong><?php echo '['.$goods_location.']';?>&nbsp;<?php echo $sku.'*'.$ebay_amount; ?></strong></td>
      </tr>
      <?php } } ?>
      <tr>
        <td><?php 
			
			if(strlen($ebay_noteb) >= 3 ) echo $ebay_noteb.'<br>';
			echo ' Total Qty:'.$totalqty.'<br>';
		
			
			?></td>
      </tr>
    </table>
      <span class="STYLE5">
      <?php 
			
			if($ebay_carrier == '中国邮政平邮') {
			$dd		= "SELECT * FROM  `ebay_cppycalcfee` where countrys like '%$countryname%' ";
			$dd		= $dbcon->execute($dd);
			$dd		= $dbcon->getResultArray($dd);
			$discount		= $dd[0]['discount'];
			$ordershipfee		= $ordershipfee / $discount;
			}
			echo $ordershipfee;
			
			?>
    </span></td>
    <td width="246" valign="top" style="border-right:#000000 1px dashed" >
    <?php
	
	
	echo $ebay_itemtitle;
	
	
	
	?>
    
    
    
    &nbsp;</td>
    <td width="438" valign="top"><table width="95%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><img src="barcode128.class.php?data=<?php echo $ebay_id; ?>" alt="" width="137" height="40"/></td>
        <td><?php echo $ebay_id; ?>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><div style="font-size:15px; font-weight:bold"><?php echo $addressline;?></div></td>
      </tr>
    </table></td>
  </tr>
</table>
<?php 

if(($i+1)%2 == 0) echo '<div style="page-break-after:always;">&nbsp;</div>';


} ?>
</body>
</html>
