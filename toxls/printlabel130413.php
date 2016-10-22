<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>系统sample</title>
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
</style>
<style media=print>
.Noprint{display:none;}
.PageNext{page-break-after: always;}
</style>
</head>
<body style="padding:0;margin:0">
<div style="width:210mm; font-family: arial;">
<table style="width:200mm;margin:5px auto;" cellpadding='0' cellspacing='0'><tr>
<?php
@session_start();
error_reporting(0);
$user	= $_SESSION['user'];
include "../include/dbconnect.php";
$dbcon	= new DBClass();
$ordersn	= explode(',',$_REQUEST['ordersn']);

$ostatus		= $_REQUEST['ostatus'];
$tj = '';
	for($i=0;$i<count($ordersn);$i++){
		
		
			if($ordersn[$i] != ""){
		
			 $sn			= $ordersn[$i];
			 
		$tj	.= "a.ebay_id='$sn' or ";
			}
			
		
	}
	
	
	$tj		= substr($tj,0,strlen($tj)-3);
	
	if($_REQUEST['ordersn'] == ''){
		$sql			= "select * from ebay_order as a where a.ebay_user='$user' and ebay_combine!='1' ";
		$sql.=" and ebay_status='$ostatus'";
	}else{
		
		
		$sql			= "select a.*,b.sku from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn=b.ebay_ordersn where ($tj) group by a.ebay_id order by a.ebay_carrier,a.ebay_countryname,b.sku ";
		
		
		
	}	
	//echo $sql;
	//exit;
	 $sql			= $dbcon->execute($sql);
	 $sql			= $dbcon->getResultArray($sql);
	$hang = 0;
	$rrr = 0;
	for($i=0;$i<count($sql);$i++){ 
		$line = 0;

		$sn			= $sql[$i]['ebay_ordersn'];
		$carrier				= $sql[$i]['ebay_carrier'];
		$ebay_usermail			= $sql[$i]['ebay_usermail'];
		$ebay_userid			= $sql[$i]['ebay_userid'];	
		$name					= $sql[$i]['ebay_username'];
		$street1				= @$sql[$i]['ebay_street'];
		$street2 				= @$sql[$i]['ebay_street1'];
		$city 					= $sql[$i]['ebay_city'];
		$state					= $sql[$i]['ebay_state'];
		$countryname 			= $sql[$i]['ebay_countryname'];
		$countf_name 			= $country[$countryname];
		$ebay_account 			= $sql[$i]['ebay_account'];
		$zip					= $sql[$i]['ebay_postcode'];
		$recordnumber					= $sql[$i]['recordnumber'];
		$tel					= $sql[$i]['ebay_phone'];
		
 ?>
	<td style="width:33%;min-height:41mm;border:1px solid #000000;padding:4px;font-size:12px;">
		<div style="width:100%;line-height:16px;height:41mm;">
		<ul>
			<li><?php echo $carrier;?></li>
			<li><?php echo $name;?></li>
			<li><?php echo $street1.','.$street2;?></li>
			<li><?php echo $city;?></li>
			<li><?php echo $state;?></li>
			<li><?php echo $zip;?></li>
			<li><?php echo $countryname;?></li>
			<li><?php echo 'Ref :'.$recordnumber.'@';
				$ss = "select ebay_amount,sku from ebay_orderdetail where ebay_ordersn='$sn'";
				$ss			= $dbcon->execute($ss);
				$ss			= $dbcon->getResultArray($ss);
				$zzz = 0;
				foreach($ss as $k=>$v){
					$sku = $v['sku'];
					$amount = $v['ebay_amount'];
					$rr			= "select * from ebay_productscombine where ebay_user='$user' and goods_sn='$sku'";
					$rr			= $dbcon->execute($rr);
					$rr 	 	= $dbcon->getResultArray($rr);
					
	
								if(count($rr) > 0){
			
									$goods_sncombine	= $rr[0]['goods_sncombine'];
									$notes				= $rr[0]['notes'];
									$goods_sncombine    = explode(',',$goods_sncombine);	
									
									
									for($e=0;$e<count($goods_sncombine);$e++){
						
											$pline			= explode('*',$goods_sncombine[$e]);
											$goods_sn		= $pline[0];
											$goddscount     = $pline[1] * $amount;
											if($goddscount>1){ echo $goods_sn.'('.$goddscount.'),';}else{ echo $goods_sn.',';}
												
									}
									
									
								}else{
								
								
										
										if($amount>1){ echo $sku.'('.$amount.'),';}else{ echo $sku.',';}
					
								
								}
					
				}
			?></li>
		</ul>
		</div>
	</td>
	
	
	<?php 
	$rrr ++;
	if($rrr%3==0){
		echo "</tr>";
		$hang++;
		if($hang==7 ){
			echo '</table><div style="page-break-after:always;"></div><table style="width:200mm; margin:5px auto"><tr>';
			$hang = 0;
			$rrr = 0;
		}else{
			$rrr = 0;
			echo "<tr>";
		}
	} 
}
if($rrr!=3){
	for($r=1;$r<=(3-$rrr);$r++){
		echo '<td>&nbsp;</td>';
	}
}
?>

</tr>
</table>
</div>
</body>
</html>