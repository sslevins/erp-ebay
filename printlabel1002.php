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
.main{
	width:792px;
	margin:40px auto;
	font-size:12px;
	font-family: arial;
}
.leftbox{
	border:1px solid #000000;
	width:388px;
	height:410px;
	float:left;
}
.rightbox{
	border:1px solid #000000;
	width:388px;
	height:410px;
	float:right;
}
.leftbox .lnav1{
	border-bottom:1px solid #000000;
	width:100%;
	height:94px;
}
.leftbox .lnav1 .lf{
	width:73px;
	height:84px;
	float:left;
	margin:5px;
}
.leftbox .lnav1 .lf img{
	width:72px;
	heght:72px;
	margin-top:3px
}
.leftbox .lnav1 .lf span{
	margin:2px;
	font-size:11px;
}
.leftbox .lnav1 .cimg{
	width:160px;
	height:84px;
	float:left;
	margin:5px 0 0 15px;
	text-align:center;
}
.leftbox .lnav1 .cimg .llc1{
	width:106px;
	height:30px;
	margin-left:-20px;
}
.leftbox .lnav1 .cimg .llc3{
    width: 128px;
}
.leftbox .lnav1 .cimg .llc2{
	width:155px;
	height:33px;
}
.leftbox .lnav1 .rwz{
	border: 1px solid #000000;
    float: right;
    height: 36px;
    margin: 10px 17px 0 0;
    padding: 3px 0 3px 7px;
    width: 92px;
}
.leftbox .lnav1 .rwz li{
	line-height:12px;
}
.leftbox .lnav2{
	border-bottom:1px solid #000000;
	width:100%;
	height:97px;
}
.leftbox .lnav2 .l2l{
	border-right:1px solid #000000;
	width:55%;
	height:97px;
	float:left;
	position: relative;
	font-size:8px;
}
.leftbox .lnav2 .l2r{
	width:44%;
	height:97px;
	float:right;
}
.leftbox .lnav3{
	border-bottom:4px solid #000000;
	width:100%;
	height:84px;
}
.leftbox .lnav3 .tobox{
	border-right: 2px solid #000000;
    height: 85px;
    padding: 30px 0 0 20px;
    width: 15%;
	font-size:20px;
	float:left;
}
.leftbox .lnav3 .l3r{
	float:right;
	width:75%;
	height:84px;
}
.leftbox .lnav4{
	width:100%;
	height:118px;
	text-align:center;
	border-bottom:4px solid #000000;
}
.rightbox .rnav1{
	float:left;
	width:100%;
	height:192px;
	border-bottom:1px solid #000000;
}
.rightbox .rnav1 .rr1l{
	width:50%;
	float:left;
}
.rightbox .rnav1 .rr1l .rr1lt{
	height:170px;
	width:100%;
	border-bottom:1px solid #000000;
	position:relative;
}
.rightbox .rnav1 .rr1l .rr1lc{
	height:20px;
	width:100%;
	border-bottom:1px solid #000000;
}
.rightbox .rnav1 .rr1l .rr1lb{
	height:20px;
	width:100%;
}
.rightbox .rnav1 .rr1r{
	width:50%;
	float:right;
}
.rightbox .rnav1 .rr1r .rr1rt{
	height:90px;
	width:100%;
	border-bottom:1px solid #000000;
	position:relative;
}
.rightbox .rnav1 .rr1r .rr1rb{
	border-left: 1px solid #000000;
    font-size: 10px;
    height: 118px;
    padding: 5px 0 0 5px;
    width: 95%;
}
.rightbox .rnav2{
	float:left;
	width:100%;
	height:150px;
	border-bottom:1px solid #000000;
}
.rr1ltimg{
	float: left;
    height: 30px;
    margin: 7px 0 0 13px;
    width: 133px;
}
.rrul2{
	width:150x;;
	line-height:10px;	
	font-size:8px;
}
.rrul{
	font-size: 9px;
    line-height: 9px;
    margin-left: 3px;
    width: 100px;
}
.rightbox .rnav2 .borderb{
	border-bottom:1px solid #000000;
}
.rightbox .rnav2 .borderr{
	border-right:1px solid #000000;
}
.rightbox .rnav2 .borderbr{
	border-bottom:1px solid #000000;
	border-right:1px solid #000000;
}
.rightbox .rnav2 .bordertr{
	border-top:1px solid #000000;
	border-right:1px solid #000000;
}
.rightbox .rnav3{
	float:left;
	height:38px;
	width:100%;
}
.rrwz{
	border: 1px solid #000000;
    float: right;
    font-family: Arial;
    font-size: 18px;
    font-weight: bold;
    height: 29px;
    line-height: 29px;
    margin: 6px 49px 0 0;
    text-align: center;
    width: 31px;
}
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
	
	if($_REQUEST['ordersn'] == ''){
		
		$status		= $_REQUEST['status'];
		
		$ss			= "select * from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn=b.ebay_ordersn where ebay_userid !='' and ebay_combine!='1' and ebay_status='$status' group by a.ebay_id order by b.sku asc ";
		
	}else{
		
		$ss			= "select * from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn=b.ebay_ordersn where ebay_userid !='' and ($tj) group by a.ebay_id order by b.sku asc ";
	}
	 
	 $ss			= $dbcon->execute($ss);
	 $ss			= $dbcon->getResultArray($ss);
	 

	
	
	for($i=0;$i<count($ss);$i++){
	

			
		$ebay_noteb			= $ss[$i]['ebay_noteb'];	 

$sn			= $ss[$i]['ebay_ordersn'];
			
			 
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
<div class='main'>
	<div class = 'leftbox'>
		<div class='lnav1'>
			<div class='lf'>
				<img src='images/ff.jpg'/>
				<span>From:</span>
			</div>
			<div class='cimg'>
				<img src='01.jpg' class='llc1'/>
				<div class='llc3'>
				<hr/>
				</div>
				<img src='02.jpg' class='llc2'/>
				<font style="font-family:Arial, Helvetica, sans-serif"><strong>ePacket&#8482;</strong></font>
			</div>
			<div class='rwz'>
				<ul class='llrul'>
					<li>Aimail</li>
					<li>Postage Paid</li>
					<li>China Post</li>
				</ul>
			</div>
			<span style="float: right; font-family: Arial; font-size: 18px; font-weight: bold; height: 20px; margin: 10px 57px 0 0; width: 20px;"><?php echo $isd;?></span>
			<div style="clear:both;"></div>
		</div>
		<div class='lnav2'>
			<div class='l2l'> 	
				<ul style='padding-left:10px'>
					<li><?php echo $dname;?></li>
					<li><?php echo $dstreet;?></li>
					<li><?php echo $dcity;?>&nbsp; <?php echo $dprovince;?></li>
					<li>China <?php echo $dzip;?> </li>
				</ul>
				<div style="font-family:Arial, Helvetica, sans-serif; font-size:6.2px; position: absolute; bottom:0px; left:10px;"> Customs information avaliable on attached CN22.<br />
                USPS Personnel Scan barcode below for delivery event information </div>
			</div>
			<div class='l2r'>
				<img src="barcode128.class.php?data=<?php echo '420'.$zip;?>" width="150" height="55" style='margin:13px 9px 0 9px;' />
				<div style="font-size:12px;margin-left: 50px; margin-top: 5px;"><strong>ZIP <?php echo $zip;?></strong></div>
			</div>
			<div style="clear:both;"></div>
		</div>
		<div class='lnav3'>
			<div class='tobox'><b>TO</b></div>
			<div class='l3r'><div style="font-size:12px;line-height:15px"><?php echo $addressline; ?></div></div>
			<div style="clear:both;"></div>
		</div>
		<div class='lnav4'>
		<span style=" font-family: Arial, Helvetica, sans-serif; font-size:14px;display: block; margin:8px 0 0px 0"><strong>USPS DELIVERY CONFIRMATION</strong><span></span></span>
		<img src="barcode128.class.php?data=<?php echo $ebay_tracknumber;?>" width="340" height="63" />
		<div style="font-size:12px; margin-top:3px"><strong><?php echo $ebay_tracknumber;?></strong></div>
		</div>
		<div style="clear:both;"></div>
	</div>
	<div class = 'rightbox'>
		<div class='rnav1'>
			<div class='rr1l'>
				<div class='rr1lt'>
				 <img src='01.jpg' class='rr1ltimg'/>
				 <span class='rrwz'><?php echo $isd;?></span>
				  <ul class='rrul'>
				   <li>IMPORTANT:</li>
                   <li>The item/parcel may be </li>
                   <li>opened officially.</li>
                   <li>Please print in English</li>
                  </ul>
				  <ul style='padding-left:10px' class='rrul2'>
					<li><?php echo $dname;?></li>
					<li><?php echo $dstreet;?></li>
					<li><?php echo $dcity;?>&nbsp; <?php echo $dprovince;?></li>
					<li>China <?php echo $dzip;?></li>
				  </ul>
				  <div style=" font-size:12px; position:absolute; bottom:0px; left:10px; width: 184px;">PHONE: <?php echo $dtel;?></div>
				</div>
				<div class='rr1lc'>Fees(US $):</div>
				<div class='rr1lb'>Certificate No.</div>
				<div style="clear:both;"></div>
			</div>
			<div class='rr1r'>
				<div class='rr1rt'>
				<img src="barcode128.class.php?data=<?php echo $ebay_tracknumber;?>" width="232" height="50" style="position:absolute; left:-40px; top:15px;" />
				<div style="bottom: 5px;font-size: 12px; left: 30px; position: absolute;"><strong><?php echo $ebay_tracknumber;?></strong></div>
				</div>
				
				<div class='rr1rb'>SHIP TO:<br><?php echo $addressline; ?><br>TEL:<?php echo $tel;?></div>
			</div>
		</div>
		<div style="clear:both;"></div>
		<div class='rnav2'>
		<table cellspacing="0" width='100%'>
			<tr height='20' style='font-size:8px'>
				<td class='borderbr' width='15' align="center" style='line-height:20px;'>No</td>
				<td class='borderbr' align="center" style='line-height:20px;' width='20'>Qty</td>
				<td class='borderbr' align="center" style='line-height:20px;' width='150'>Description of Contents</td>
				<td class='borderbr' align="center" style='line-height:20px;' width='40'>Kg.</td>
				<td class='borderbr' align="center" style='line-height:20px;' width='50'>Val(us$)</td>
				<td class='borderb' align="center" style='line-height:20px;' width='60'>Goods Origin</td>
			</tr>
			<?php 
			  
			     $ee			= "select ebay_amount,sku,recordnumber,ebay_itemtitle from ebay_orderdetail as a where a.ebay_ordersn='$sn'";
				 
				 $ee			= $dbcon->execute($ee);
				 $ee			= $dbcon->getResultArray($ee);
				 
				 $tqty			= 0;
				 $tweight		= 0;
				 $tgoods_sbjz		= 0;
				 $tebay_itemprice	= 0;
				 
				 $strline		= '';
				 
				 
				 $stabline		= '';
				 
				 $countjs		= 1;
				 $countjs		= 1;
				 foreach($ee as $key=>$val){
					 
					 
					 
					 
					 $ebay_amount				= $val['ebay_amount'];
					 $sku						= $val['sku'];
					 $recordnumber				= $val['recordnumber'];
					
					$rr			= "select goods_sncombine from ebay_productscombine where ebay_user='$user' and goods_sn='$sku'";
					$rr			= $dbcon->execute($rr);
					$rr 	 	= $dbcon->getResultArray($rr);
					
			
						
					if(count($rr) > 0){
			
									$goods_sncombine	= $rr[0]['goods_sncombine'];
									$goods_sncombine    = explode(',',$goods_sncombine);	
					
									//print_r($goods_sncombine);
									//echo count($goods_sncombine);
									for($v=0;$v<count($goods_sncombine);$v++){
						
						
											$pline			= explode('*',$goods_sncombine[$v]);
											//print_r($pline);
											$goods_sn		= $pline[0];
											//echo $goods_sn;
											$goddscount     = $pline[1] * $ebay_amount;
											$totalqty		= $totalqty + $goddscount;
											$uu			= "SELECT * FROM ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
											
								
											
								  			 $uu			= $dbcon->execute($uu);
											 $uu 	 	= $dbcon->getResultArray($uu);
												  $tqty							+= $goddscount;
												  $goods_ywsbmc		= $uu[0]['goods_ywsbmc']." ".$uu[0]['goods_zysbmc'].' '.$sku;
												  $goods_weight		= $uu[0]['goods_weight'];
												  $goods_sbjz		= $uu[0]['goods_sbjz'];
												  $goods_name		= $uu[0]['goods_name'];
												  $goods_location	= $uu[0]['goods_location'];
												   
												  $goods_register		= $uu[0]['goods_register']?$uu[0]['goods_register']:1;
												  $tgoods_sbjz						+= $goods_sbjz;	
												  $tweight						    += (($goods_weight)*($goddscount*$goods_register));
												  $strline			.= '<br> ['.($goddscount*$goods_register).' * '.$goods_sn.'] '.$val['ebay_itemtitle'].'/ ';
									
									if($countjs<=6){
									//echo 1111;
									//echo $goods_sn;
									$text = $goods_ywsbmc.' '.$goods_sn.' '.$goods_location;
									$lenght = strlen($text);
									if($lenght>28){
										$countjs++;
									}
									$stabline = '  <tr height="20">
									<td align="center" style=" border-right:#000 1px solid; line-height:20px;">'.$countss.'&nbsp;</td>
									<td align="right" style=" border-right:#000 1px solid; line-height:20px;">'.$goddscount.'&nbsp;</td>
									<td height="20" align="center" style=" border-right:#000 1px solid; line-height:20px;">'.$goods_ywsbmc.' '.$goods_sn.' '.$goods_location.'&nbsp;</td>
									<td align="center" style=" border-right:#000 1px solid; line-height:20px;">'.number_format($goods_weight,2).'&nbsp;</td>
									<td align="right" style=" border-right:#000 1px solid; line-height:20px;">'.number_format($goods_sbjz,2).'&nbsp;</td>
									<td align="center">China&nbsp;</td>
									</tr>';
									echo $stabline;
									}
								
			  
			  $countjs++;
			   $countss++;
									}
		
						
					 }else{
						 

					  $uu			= "select * from ebay_goods where goods_sn='$sku'";
					  $uu			= $dbcon->execute($uu);
				 	  $uu			= $dbcon->getResultArray($uu);
					  $tqty							+= $ebay_amount;
					  $goods_ywsbmc		= $uu[0]['goods_ywsbmc']." ".$uu[0]['goods_zysbmc'];
					  $goods_weight		= $uu[0]['goods_weight'];
					  $goods_sbjz		= $uu[0]['goods_sbjz'];
					  $goods_name		= $uu[0]['goods_name'];
					  
					  $goods_location		= $uu[0]['goods_location'];
					  
					  
					  $goods_register		= $uu[0]['goods_register']?$uu[0]['goods_register']:1;
					  $tgoods_sbjz						+= $goods_sbjz;	
					  $tweight						    += ($goods_weight)*($ebay_amount*$goods_register);
			  		  $strline			.= '<br> ['.($ebay_amount*$goods_register).' * '.$sku.'] '.$val['ebay_itemtitle'].'/ ';
					  
					  
					  $sjchina				= 'China';
					  if($countjs<=6){
					  $text = $goods_ywsbmc.' '.$goods_sn.' '.$goods_location.' ';
						$lenght = strlen($text);
						if($lenght>28){
							$countjs++;
						}
					  	$stabline = '  <tr>
                <td align="center"  style=" border-right:#000 1px solid; line-height:20px;">'.$countss.'&nbsp;</td>
                <td align="right"  style=" border-right:#000 1px solid; line-height:20px;">'.$ebay_amount.'&nbsp;</td>
                <td height="20" align="center"  style=" border-right:#000 1px solid;font-size:12px; line-height:20px;">'.$goods_ywsbmc.' '.$sku.' '.$goods_location.'&nbsp;</td>
                <td align="center"  style=" border-right:#000 1px solid; line-height:20px;">'.number_format($goods_weight,2).'&nbsp;</td>
                <td align="right"  style=" border-right:#000 1px solid; line-height:20px;">'.number_format($goods_sbjz,2).'&nbsp;</td>
                <td align="center">'.$sjchina.'&nbsp;</td>
              </tr>';
			  echo $stabline;
					}
			  
			  $countjs++;
			  $countss++;
			  
					 }
					 
					  
					  
					
		

					


					  
			  ?>
                  <?php }  
			if($countjs<8){
				$t = 8-$countjs;
				for($rrr=1;$rrr<=$t;$rrr++){
					$stabline = '  <tr>
					<td height=20 align="center"  style=" border-right:#000 1px solid;border-bottom: 0px solid #000;">&nbsp;</td>
					<td align="right"  style=" border-right:#000 1px solid;border-bottom: 0px solid #000;">&nbsp;</td>
					<td height="100%" align="center"  style=" border-right:#000 1px solid;font-size:12px;border-bottom: 0px solid #000;">&nbsp;</td>
					<td align="center"  style=" border-right:#000 1px solid;border-bottom: 0px solid #000;">&nbsp;</td>
					<td align="right"  style=" border-right:#000 1px solid;border-bottom: 0px solid #000;">&nbsp;</td>
					<td align="center"  style=" ">&nbsp;</td>
				  </tr>';
				echo $stabline;
				}
			}
		  
		  	
	?>
			<tr height='20'>
				<td class='bordertr'>&nbsp;</td>
				<td class='bordertr' align="right"><?php echo $tqty;?>&nbsp;</td>
				<td style="border-top:1px #000 solid;font-size:10px;">Total Gross Weight (Kg.): &nbsp;</td>
				<td class='bordertr' align="center"><?php echo number_format($tweight,3);?>&nbsp;</td>
				<td class='bordertr' align="right"> <?php echo $tgoods_sbjz;?>&nbsp;</td>
				<td  style="border-top:1px #000 solid">&nbsp; </td>
			</tr>
		</table>
		</div>
		<div style="clear:both;"></div>
		<div class='rnav3'>
		<div style="font-family:Arial; font-size:6px; margin:5px 5px 0 5px">I certify the particulars given in this customs declaration are correct. This item does not contain any dangerous article, or articles prohibited by<br />
                legislation or by postal or customs regulations. I have met all applicable export filing requirements under the Foreign Trade Regulations. 
		</div>
		<div style="float: left;font-family: Arial;font-size: 8px; margin:5px 5px;width: 140px;"><strong>Sender's Signature &amp; Date Signed:</strong></div>
		<div style="float: right;font-family: Arial;font-size: 18.5px;margin-top: 0px;text-align: left;width: 60px;">CN22</div>
		<div style="clear:both;"></div>
		</div>
		<div style="clear:both;"></div>
	</div>
	<div style="clear:both"></div>
	<div style="margin:20px 0 60px 10px; float:left">
	<?php echo $recordnumber.' , '.$ebay_account.' , '.$ebay_userid.' , 配货信息:'.$strline; ?>
	</div>
</div>
<div style="clear:both"></div>
<?php 

if(($i+1)%2 == 0) echo '<div style="page-break-after:always;">&nbsp;</div>';


} ?>
</body>
</html>
