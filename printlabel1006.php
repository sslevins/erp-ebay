<?
//header("Content-type:application/vnd.ms-doc;");
//header("Content-Disposition:filename=test.doc");
?> 

<?php

	include "include/config.php";
	
	
	

		$ertj		= "";
			$orders		= explode(",",$_REQUEST['ordersn']);
			for($g=0;$g<count($orders);$g++){
		
		
				$sn 	=  $orders[$g];
				if($sn != ""){
				
					$ertj	.= " ebay_id ='$sn' or";
				}
			
			}
			$ertj			 = substr($ertj,0,strlen($ertj)-3);
			
			$sql	= "select * from ebay_order where ($ertj) and ebay_user='$user'";
			$sql	= $dbcon->execute($sql);
			$sql	= $dbcon->getResultArray($sql);
				
		
			
		
?>
<style type="text/css">
<!--
.STYLE11 {font-family: C39HrP24DhTt; font-size: 36px; }
.table {border: 0px dotted #CCCCCC; }
.STYLE12 {
	font-size: 21px;
	font-weight: bold;
}
.STYLE13 {
	font-size: 21px;
	font-weight: bold;
}
.STYLE15 {
	font-size: 26px;
	font-weight: bold;
}

-->
</style>
<style media="print"> 
.noprint { display: none } 
</style> 

<script > 

self.moveTo(0,0);
self.resizeTo(screen.availWidth,screen.availHeight);
self.focus();
function doPrintSetup(){ 
//打印设置 
WB.ExecWB(8,1) 
} 
function doPrintPreview(){ 
//打印预览 
WB.ExecWB(7,1) 
} 
function doprint(){ 
//直接打印 
WB.ExecWB(6,6) 
} 



function window.onload() { 

//idPrint1.disabled = false; 
//idPrint3.disabled = false; 

} 
</script>
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td>编号</td>
    <td>包裹跟踪号</td>
    <td>寄件人</td>
    <td>内件信息</td>
    <td>数量</td>
    <td>重量（公斤）</td>
    <td>原产地<br /></td>
    <td>申报价值（美元）</td>
    <td> 收件人</td>
  </tr>
  
  <?php
  
  for($i=0;$i<count($sql);$i++){
  
  
  		
		$ebay_tracknumber		= $sql[$i]['ebay_tracknumber'];
	  	$ebay_username	    	= $sql[$i]['ebay_username'];
	    $ebay_account	    	= $sql[$i]['ebay_account'];
		
		
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
			
		$street22					= $dname.'<br>'.$dstreet.'<br>'.$dcity.'<br>'.$dprovince.'<br>China '.$dzip;
		
		
			
			
		$ebay_ordersn   		= $sql[$i]['ebay_ordersn'];
		
		
		$cname			= $sql[$i]['ebay_username'];
				$street1		= @$sql[$i]['ebay_street'];
				$street2 		= @$sql[$i]['ebay_street1']?@$sql[$i]['ebay_street1']:"";
				$city 			= $sql[$i]['ebay_city'];
				$state			= $sql[$i]['ebay_state'];
				$countryname 	= $sql[$i]['ebay_countryname'];
				$zip			= $sql[$i]['ebay_postcode'];
				$tel			= $sql[$i]['ebay_phone']?$sql[$i]['ebay_phone']:"";
				$is_reg		    = $sql[$i]['is_reg'];
				$ordersn		= $sql[$i]['ebay_ordersn'];	
				$ebay_noteb		= $sql[$i]['ebay_noteb']?$sql[$i]['ebay_noteb']:"&nbsp;&nbsp;";	
				
				if($street2 == ''){
					
					$addressline	= $cname."<br>".$street1."<br>".$city.", ".$state."<br>".$zip."<br>".$countryname;
					
				
				}else{
				
					$addressline	= $cname."<br>".$street1."<br>".$street2."<br>".$city.", ".$state."<br>".$zip."<br>".$countryname;
					
					
				}
				
				
		
	   
	   $ss		= "select * from ebay_account where ebay_account ='$ebay_account' ";
	   $ss		= $dbcon->execute($ss);
	   $ss		= $dbcon->getResultArray($ss);
	   $id		= $ss[0]['id'];
	   
	   $ss		= "select * from eub_account where pid ='$id' ";
	   $ss		= $dbcon->execute($ss);
	   $ss		= $dbcon->getResultArray($ss);
	   
	   $dname	= $ss[0]['dname'];
	   
	   
	   $ss		= "select * from ebay_orderdetail where ebay_ordersn ='$ebay_ordersn' ";
	   $ss		= $dbcon->execute($ss);
	   $ss		= $dbcon->getResultArray($ss);
	   $qty		= 0;
	   $goods_sbjz	= 0;
	   $goods_weight	= 0;
	   $goods_weight	= 0;
	   $goods_ywsbmc	= '';
	   
	   for($g=0;$g<count($ss);$g++){
	   	
			$qty		+= $ss[$g]['ebay_amount'];
			$sku		 = $ss[$g]['sku'];
	   		
			$gg		= "select * from ebay_goods where goods_sn ='$sku' and ebay_user ='$user'";
			$gg		= $dbcon->execute($gg);
	   		$gg		= $dbcon->getResultArray($gg);
			
			$goods_sbjz		 += $gg[0]['goods_sbjz'];
			$goods_weight	 += $gg[0]['goods_weight'];
			$goods_ywsbmc	 .= $gg[0]['goods_ywsbmc'].' ';
			
	   
	   
	   }
	   
	   
  ?>
  <tr>
    <td><?php echo $i+1;?></td>
    <td><?php echo $ebay_tracknumber;?>&nbsp;</td>
    <td><?php echo $street22;?>&nbsp;</td>
    <td><?php echo $goods_ywsbmc;?>&nbsp;</td>
    <td><?php echo $qty;?>&nbsp;</td>
    <td><?php echo $goods_weight;?>&nbsp;</td>
    <td>China</td>
    <td><?php echo $goods_sbjz;?>&nbsp;</td>
    <td><?php echo $addressline;?>&nbsp;</td>
  </tr>
  
  <?
  
  }
  ?>
</table>
