<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TNT</title>
<style>
html, body, div, span, applet, object, iframe,h1, h2, h3, h4, h5, h6, p, blockquote, pre,a, abbr, acronym, address, big, cite, code,del, dfn, em, font, img, ins, kbd, q, s, samp,small, strike, strong, sub, sup, tt, var,b, u, i, center,dl, dt, dd, ol, ul, li,fieldset, form, label, legend,table, caption, tbody, tfoot, thead, tr, th, td,p {
 margin: 0;
 padding: 0;
 border: 0;
 outline: 0;
 font-size: 100%;
 vertical-align: baseline;
 background: transparent;
 list-style:none;
}
.noprint { display: none } 
.r{border-right:1px solid #000000;}
.l{border-left:1px solid #000000;}
.t{border-top:1px solid #000000;}
.b{border-bottom:1px solid #000000;}
.textc{text-align:center;}
</style>
 <body>
 <div style="width:152mm;font-size:14px; margin:0; font-family: arial;"> 
<?php
	@session_start();
	include "include/dbconnect.php";
	error_reporting(0);
	$dbcon	= new DBClass();
	$user	= $_SESSION['user'];
	$ertj		= "";
	$orders		= explode(",",$_REQUEST['ordersn']);
	for($g=0;$g<count($orders);$g++){
		$sn 	=  $orders[$g];
		if($sn != ""){
			$ertj	.= " ebay_id ='$sn' or";
		}
	}
	$ertj   = substr($ertj,0,strlen($ertj)-3);
	$sql	= "select * from ebay_order  where ($ertj) and ebay_user='$user' order by ebay_username asc ";
	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);	
 	for($i=0;$i<count($sql);$i++){	
				$ebayaccount	= $sql[$i]['ebay_account'];
				$recordnumber	= $sql[$i]['recordnumber'];
				$ebay_id		= $sql[$i]['ebay_id'];
				$ebay_total		= $sql[$i]['ebay_total'];
				$ebay_carrier	= $sql[$i]['ebay_carrier'];
				$ss = "select * from ebay_carrier where name='$ebay_carrier' and ebay_user='$user'";
				$ss	= $dbcon->execute($ss);
				$ss	= $dbcon->getResultArray($ss);
				$fname	= $ss[0]['username'];
				$fcity	= $ss[0]['city'];
				$fcountry	= $ss[0]['country'];
				$fzip		= $ss[0]['zip'];
				$ftel		= $ss[0]['tel'];
				$faddress		= $ss[0]['address'];
				$carrier_sn		= $ss[0]['carrier_sn'];
				$ebay_currency  = $sql[$i]['ebay_currency'];
				$tname			= $sql[$i]['ebay_username'];
				$tstreet1		= @$sql[$i]['ebay_street'];
				$tstreet2 		= @$sql[$i]['ebay_street1']?@$sql[$i]['ebay_street1']:"";
				$tcity 			= $sql[$i]['ebay_city'];
				$tstate			= $sql[$i]['ebay_state'];
				$tcountryname 	= $sql[$i]['ebay_countryname'];
				$tzip			= $sql[$i]['ebay_postcode'];
				$tracknumber	= $sql[$i]['ebay_tracknumber'];
				$ttel			= $sql[$i]['ebay_phone']?$sql[$i]['ebay_phone']:"";
				$recordnumber   = $sql[$i]['recordnumber'];
				$osn		    = $sql[$i]['ebay_ordersn'];
				$toaddress		= $tstreet1.$tstreet2.'<br>'.$tcity.','.$tstate.','.$tcountryname;
			
				
				
 
 
 
 
  ?>
 

<div style="width:152mm;height:241mm;font-size:14px; position:relative;">
	<div style="width:80px;height:20px;line-height:20px; left:80px;top:115px; position:absolute"><?php echo $fname; ?></div> 
	<div style="width:180px;height:20px;line-height:20px; left:180px;top:115px; position:absolute"><?php echo $ftel; ?></div> 
	<div style="width:105px;height:20px;line-height:20px; left:45px;top:140px; position:absolute"><?php echo $fcity; ?></div> 
	<div style="width:80px;height:20px;line-height:20px; left:240px;top:140px; position:absolute"><?php echo $fcountry; ?></div> 
	<div style="width:240px;line-height:20px; left:80px;top:175px; position:absolute"><?php echo $faddress; ?></div>
	<div style="width:105px;height:20px;line-height:20px; left:75px;top:230px; position:absolute"><?php echo $fzip; ?></div>
	<div style="width:80px;height:20px;line-height:20px; left:265px;top:230px; position:absolute"><?php echo $carrier_sn; ?></div>
	
	
	<div style="width:240px;height:20px;line-height:20px; left:430px;top:90px; position:absolute"><?php echo $tname; ?></div>
	<div style="width:150px;height:20px;line-height:20px; left:550px;top:120px; position:absolute"><?php echo $tcountryname; ?></div>
	<div style="width:365px;line-height:20px; left:375px;top:175px; position:absolute"><?php echo $toaddress; ?></div>
	<div style="width:120px;height:20px;line-height:20px; left:395px;top:230px; position:absolute"><?php echo $tzip; ?></div>
	<div style="width:140px;height:20px;line-height:20px; left:540px;top:230px; position:absolute"><?php echo $ttel; ?></div>
	<?php
		$dsql = "select sku,ebay_amount,shipingfee,ebay_itemprice from ebay_orderdetail where ebay_ordersn='$osn'";
		$dsql	= $dbcon->execute($dsql);
		$dsql	= $dbcon->getResultArray($dsql);
		$top1	= 400;
		foreach($dsql as $k=>$v){
			$price	= $v['ebay_itemprice']+ $v['shipingfee'];
			$top = $top1 + $k*20;
	?>
	<div style="width:175px;height:20px;line-height:20px;text-align:center; left:0px;top:<?php echo $top;?>px; position:absolute"><?php echo $v['sku']; ?></div>
	<div style="width:35px;height:20px;line-height:20px; text-align:center;left:175px;top:<?php echo $top;?>px; position:absolute"><?php echo $v['ebay_amount']; ?></div>
	<div style="width:65px;height:20px;line-height:20px; text-align:center;left:245px;top:<?php echo $top;?>px; position:absolute"><?php echo '$'.$price; ?></div>	
	<?php } ?>
</div>
<div style="page-break-after:always;">&nbsp;</div>

    <?php
	
	
}


?>
</div>
</body>
</html>
