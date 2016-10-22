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
<table style="width:210mm;margin:0;" cellpadding='0' cellspacing='0'><tr>
<?php
@session_start();
error_reporting(0);
$user	= $_SESSION['user'];
include "include/dbconnect.php";
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
		$ebay_id	= $sql[$i]['ebay_id'];
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
	<td style="width:104mm;min-height:36mm;font-size:14px;">
		<div style="width:78.6mm;line-height:20px;height:36mm;float:left;border:1px solid #000000;">
		<ul style='padding:5px;'>
			<li><?php echo $name;?></li>
			<li><?php echo $street1.','.$street2;?></li>
			<li><?php echo $city.','.$state.','.$zip.' '.$countryname;?></li>
			<?php if($tel){
			 echo '<li>Tel :'.$tel.'</li>';	
			 }
			?>
		</ul>
		</div>
		<div style='width:25mm;height:36mm;float:left;border:1px solid #000000;border-left:none'>
			<div style='width:22mm;margin:10px 5px;text-align:center;font-size:12px;border-bottom: #000000 dashed 1px;'>
				<img src="barcode128.class.php?data=<?php echo $ebay_id;?>"  style="width:22mm;height:6mm; margin-bottom:3px;" />
				*<?php echo $ebay_id;?>*
			</div>
		</div>
	</td>
	
	
	<?php 
	$rrr ++;
	if($rrr%2==0){
		echo "</tr>";
		$hang++;
		if($hang==8 ){
			echo '</table><div style="page-break-after:always;"></div><table style="width:210mm; margin:0 auto"><tr>';
			$hang = 0;
			$rrr = 0;
		}else{
			$rrr = 0;
			echo "<tr>";
		}
	} 
}
if($rrr!=2){
	echo '<td>&nbsp;</td>';
}
?>

</tr>
</table>
</div>
</body>
</html>