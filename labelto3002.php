<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>THG</title>
</head>
<style type="text/css">
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
<body>
<div style='width:103mm; margin:0 auto; font-family: Arial;'>
<?php
@session_start();
error_reporting(0);
include "include/dbconnect.php";
$dbcon	= new DBClass();
$user	= $_SESSION['user'];
$ordersn	= $_REQUEST['ordersn'];
$ordersn		= explode(",",$ordersn);
	
	$tj		= '';
	for($i=0;$i<count($ordersn);$i++){
		
		
			if($ordersn[$i] != ""){
		
			 $sn			= $ordersn[$i];
			 
		$tj	.= "a.ebay_id='$sn' or ";
			}
			
		
	}
	
	
	$tj		= substr($tj,0,strlen($tj)-3);
	
	if($_REQUEST['ordersn'] == ''){
		
		$status		= $_REQUEST['status'];
		
		$ss			= "select a.* from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn=b.ebay_ordersn where ebay_userid !='' and ebay_combine!='1' and ebay_status='$status' group by a.ebay_id order by b.sku asc ";
		
	}else{
		
		$ss			= "select a.* from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn=b.ebay_ordersn where ebay_userid !='' and ($tj) group by a.ebay_id order by b.sku asc ";
	}
	 $ss			= $dbcon->execute($ss);
	 $ss			= $dbcon->getResultArray($ss);
	$t=0;
	for($i=0;$i<count($ss);$i++){
	
		$ebay_noteb			= $ss[$i]['ebay_noteb'];	 

$sn			= $ss[$i]['ebay_ordersn'];
			
			$ebayid				= $ss[$i]['ebay_id'];
			//echo $ebayid;
			$ebay_usermail			= $ss[$i]['ebay_usermail'];
			$ebay_userid			= $ss[$i]['ebay_userid'];	
			$name					= $ss[$i]['ebay_username'];
			$street1				= @$ss[$i]['ebay_street'];
			$street2 				= @$ss[$i]['ebay_street1'];
			$city 					= $ss[$i]['ebay_city'];
			$state					= $ss[$i]['ebay_state'];
			$countryname1 			= $ss[$i]['ebay_countryname'];
			$countryname			= strtoupper($countryname1);
			$ebay_carrier				= $ss[$i]['ebay_carrier'];
			if($ebay_carrier=='IE1 RM Euro' || $ebay_carrier=='IE1 RM World'){$countryname1 = '<strong>'.$countryname.'</strong>';}
			$ebay_account 			= $ss[$i]['ebay_account'];
			$zip					= $ss[$i]['ebay_postcode'];
			$recordnumber					= $ss[$i]['recordnumber'];
			$ebay_tracknumber					= $ss[$i]['ebay_tracknumber'];
			$rr				= "select address from ebay_carrier where name='$ebay_carrier' and ebay_user='$user'";
		$rr				= $dbcon->execute($rr);
		$rr				= $dbcon->getResultArray($rr);
		$backaddress	= $rr[0]['address'];
			if($street2 == ''){
				
				$addressline	= $name."<br>".$street1.",<br>".$city.", ".$state.",<br>".$zip.',<br> '.$countryname1;
				
			}else{
				
				
				$addressline	= $name."<br>".$street1.", ".$street2.",<br>".$city.", ".$state.",<br>".$zip.',<br> '.$countryname1;
			}
		if($ebay_carrier=='PPF RM2' || $ebay_carrier=='PK0 RM2'){


 ?>
	<div style='width:102mm;height:70mm; position:relative;'>
		<div style='height:68mm; width:27mm;float:left;writing-mode:tb-rl;font-size:10px; padding-top:1mm'>
			<ul>
				<li style='width:4mm; height:68mm;float:left'><strong><?php echo $ebay_carrier;?></strong></li>
				<?php
					$vv = "select sku,ebay_amount from ebay_orderdetail where ebay_ordersn='$sn' limit $t,4";
					$vv					= $dbcon->execute($vv);
					$vv					= $dbcon->getResultArray($vv);
					for($k=0;$k<count($vv);$k++){
						$sku = $vv[$k]['sku'];
						$sql = "select goods_sncombine from ebay_productscombine where goods_sn='$sku'";
						$sql					= $dbcon->execute($sql);
						$sql					= $dbcon->getResultArray($sql);
						$count	 = 1;
						if(count($sql)>0){
							$goods = explode('*',$sql[0]['goods_sncombine']);
							$count = $goods[1];
							$sku = $goods[0];
						}
						$amount	= $vv[$k]['ebay_amount']*$count;
						$vvv = "select goods_weight,goods_location,goods_width,goods_height,goods_length from ebay_goods where goods_sn='$sku' and ebay_user='$user'";
						//echo $vvv;
						$vvv = $dbcon->execute($vvv);
						$vvv = $dbcon->getResultArray($vvv);
						$skuline = $sku.' / '.($vvv[0]['goods_weight']*$count).'kg /'.$vvv[0]['goods_length'].'x'.$vvv[0]['goods_width'].'x'.$vvv[0]['goods_height'].' * '.$amount.' / '.$vvv[0]['goods_location'];
				?>
				<li style='width:4mm; height:68mm;float:left'><?php echo $skuline;?></li>
				<?php } 
				if($k<4){
					for($tt=0;$tt<(4-$k);$tt++){
					echo "<li style='width:4mm; height:68mm;float:left'>&nbsp;</li>";
					}
				}
				?>
				<li style='width:4mm; height:68mm;float:left'><?php echo $backaddress;?></li>
			</ul>
		</div>
		<div style='width:56mm;height:26mm;float:right;position:relative;'><img src='print/rm21.jpg' style='width:31.8mm;height:14mm; margin:5mm 0mm'/>
		<div style='position:absolute; top:5mm; right:2mm; width:22mm; border:1px solid #000000; border-left:none;'><div style='font-size:12px;font-weight:bold;float:left; width:100%;height:25px;line-height:25px;text-align:center'>ROYAL MAIL</div><div style='font-size:7px;float:left; height:26px; line-height:12px;width:20mm;padding-left:1.5mm'>POSTAGE PAID GB <span style='font-size:9px'>HQ54267</span></div></div></div>
		<div style='width:65mm;float:right; padding-right:5mm; font-size:16px; line-height:6mm;position:relative;'><?php echo $addressline;?>
		<img src="barcode128.class.php?data=<?php echo $ebayid;?>" style="width:35mm;height:9mm; margin-left:15mm;margin-top:1mm"/>
		<?php echo $ebayid;?>
		</div>
	</div>
	<div style="clear:both"></div>
	<?php 
	}elseif($ebay_carrier=='PPF RM1' || $ebay_carrier=='PK9 RM1'){
	?>
	<div style='width:102mm;height:70mm; position:relative;'>
		<div style='width:27mm;height:68mm; float:left;writing-mode:tb-rl;font-size:10px; padding-top:1mm'>
			<ul>
				<li style='width:4mm; height:68mm;float:left'><strong><?php echo $ebay_carrier;?></strong></li>
				<?php
					$vv = "select sku,ebay_amount from ebay_orderdetail where ebay_ordersn='$sn' limit $t,4";
					$vv					= $dbcon->execute($vv);
					$vv					= $dbcon->getResultArray($vv);
					for($k=0;$k<count($vv);$k++){
						$sku = $vv[$k]['sku'];
						$sql = "select goods_sncombine from ebay_productscombine where goods_sn='$sku'";
						$sql					= $dbcon->execute($sql);
						$sql					= $dbcon->getResultArray($sql);
						$count	 = 1;
						if(count($sql)>0){
							$goods = explode('*',$sql[0]['goods_sncombine']);
							$count = $goods[1];
							$sku = $goods[0];
						}
						$amount	= $vv[$k]['ebay_amount']*$count;
						$vvv = "select goods_weight,goods_location,goods_width,goods_height,goods_length from ebay_goods where goods_sn='$sku' and ebay_user='$user'";
						//echo $vvv;
						$vvv = $dbcon->execute($vvv);
						$vvv = $dbcon->getResultArray($vvv);
						$skuline = $sku.' / '.($vvv[0]['goods_weight']*$count).'kg /'.$vvv[0]['goods_length'].'x'.$vvv[0]['goods_width'].'x'.$vvv[0]['goods_height'].' * '.$amount.' / '.$vvv[0]['goods_location'];
				?>
				<li style='width:4mm; height:68mm;float:left'><?php echo $skuline;?></li>
				<?php 
				}
				if($k<4){
					for($tt=0;$tt<(4-$k);$tt++){
					echo "<li style='width:4mm; height:68mm;float:left'>&nbsp;</li>";
					}
				}
				?>
				
				<li style='width:4mm; height:68mm;float:left'><?php echo $backaddress;?></li>
			</ul>
		</div>
		<div style='width:56mm;height:26mm;float:right;position:relative;'><img src='print/rm11.jpg' style='width:31.8mm;height:14mm; margin:5mm 0mm'/>
		<div style='position:absolute; top:5mm; right:2mm; width:22mm; border:1px solid #000000; border-left:none;'><div style='font-size:12px;font-weight:bold;float:left; width:100%;height:25px;line-height:25px;text-align:center'>ROYAL MAIL</div><div style='font-size:7px;float:left; height:26px; line-height:12px;width:20mm;padding-left:1.5mm'>POSTAGE PAID GB <span style='font-size:9px'>HQ54267</span></div>
		</div>
		</div>
		<div style='width:65mm;float:right; padding-right:5mm; font-size:16px; line-height:6mm;position:relative;'><?php echo $addressline;?>
		<img src="barcode128.class.php?data=<?php echo $ebayid;?>" style="width:35mm;height:9mm; margin-left:15mm;margin-top:1mm"/>
		<?php echo $ebayid;?>
		</div>
	</div>
	<div style="clear:both"></div>
	<?php 
	}elseif($ebay_carrier=='IE1 RM Euro' || $ebay_carrier=='IE1 RM World'){
	?>
	<div style='width:102mm;height:70mm; position:relative;'>
		<div style='width:27mm;height:68mm; float:left;writing-mode:tb-rl;font-size:10px; padding-top:1mm'>
			<ul>
				<li style='width:4mm; height:49mm; margin-top:20mm;float:left'><strong><?php echo $ebay_carrier;?></strong></li>
				<?php
					$vv = "select sku,ebay_amount from ebay_orderdetail where ebay_ordersn='$sn' limit $t,4";
					$vv					= $dbcon->execute($vv);
					$vv					= $dbcon->getResultArray($vv);
					for($k=0;$k<count($vv);$k++){
						$sku = $vv[$k]['sku'];
						$sql = "select goods_sncombine from ebay_productscombine where goods_sn='$sku'";
						$sql					= $dbcon->execute($sql);
						$sql					= $dbcon->getResultArray($sql);
						$count	 = 1;
						if(count($sql)>0){
							$goods = explode('*',$sql[0]['goods_sncombine']);
							$count = $goods[1];
							$sku = $goods[0];
						}
						$amount	= $vv[$k]['ebay_amount']*$count;
						$vvv = "select goods_weight,goods_location,goods_width,goods_height,goods_length from ebay_goods where goods_sn='$sku' and ebay_user='$user'";
						//echo $vvv;
						$vvv = $dbcon->execute($vvv);
						$vvv = $dbcon->getResultArray($vvv);
						$skuline = $sku.' / '.($vvv[0]['goods_weight']*$count).'kg /'.$vvv[0]['goods_length'].'x'.$vvv[0]['goods_width'].'x'.$vvv[0]['goods_height'].' * '.$amount.' / '.$vvv[0]['goods_location'];
				?>
				<li style='width:4mm; height:49mm; margin-top:20mm;float:left'><?php echo $skuline;?></li>
				<?php } 
				if($k<4){
					for($tt=0;$tt<(4-$k);$tt++){
					echo "<li style='width:4mm; height:49mm;margin-top:20mm;float:left'>&nbsp;</li>";
					}
				}
				?>
				<li style='width:4mm; height:69mm;float:left'><?php echo $backaddress;?></li>
			</ul>
		</div>
		<div style='width:38mm;height:24mm;float:right;position:relative;'><img src='print/ie1.jpg' style='width:14.8mm;height:14mm; margin:4mm 0mm'/>
		<div style='position:absolute; top:4mm; right:2mm; width:21mm; border:1px solid #000000; border-left:none;'><div style='font-size:12px;font-weight:bold;float:left; width:100%;height:25px;line-height:25px;text-align:center'>ROYAL MAIL</div><div style='font-size:7px;float:left; height:26px; line-height:12px;width:19mm;padding-left:1mm'>POSTAGE PAID GB <span style='font-size:9px'>HQ54267</span></div>
		</div>
		</div>
		<img src='print/rm1ie.png' style='width:34mm;height:16mm;position:absolute; top:2mm; left:14mm;display:block;' >
		<div style='width:65mm;float:right; padding-right:5mm; font-size:16px; line-height:6mm;position:relative;'><?php echo $addressline;?>
		<img src="barcode128.class.php?data=<?php echo $ebayid;?>" style="width:35mm;height:9mm; margin-left:15mm;margin-top:1mm"/>
		<?php echo $ebayid;?>
		</div>
		<div style="clear:both"></div>
	</div>
	<div style="clear:both"></div>
	<?php 
	}
	?>
	
 <?php 
	$vv = "select count(ebay_id) as goodsnumber from ebay_orderdetail where ebay_ordersn='$sn'";
	$vv					= $dbcon->execute($vv);
	$vv					= $dbcon->getResultArray($vv);
	$goodsnumber		= $vv[0]['goodsnumber'];
	if($goodsnumber>($t+4)){
		$t=$t+4;
		$i--;
	}else{
		$t = 0;
	}
	// if(($i+1)<count($ss)){
		// echo '<div style="page-break-after:always;">&nbsp;</div>';
	// }
 } 
 ?>
 </div>
</body>