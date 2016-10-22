<?php
@session_start();
error_reporting(0);

$user	= $_SESSION['user'];
include "../include/dbconnect.php";	



require_once('../tcpdf/config/lang/eng.php');
require_once('../tcpdf/tcpdf.php');
$dbcon	= new DBClass();


	$ss		= "select * from ebay_user WHERE `username` ='$user' LIMIT 1";
	

	
	$ss		= $dbcon->execute($ss);
	$ss		= $dbcon->getResultArray($ss);
	

	
	$defaultstoreid				= $ss[0]['storeid'];
	$notesorderstatus			= $ss[0]['notesorderstatus'];
	$auditcompleteorderstatus	= $ss[0]['auditcompleteorderstatus'];
	$hackorerstatus					= $ss[0]['hackorer'];
	$days30						= $ss[0]['days30'];
	$days15						= $ss[0]['days15'];
	$days7						= $ss[0]['days7'];
	
	$ad01						= $ss[0]['ad01'];
	$ad02						= $ss[0]['ad02'];
	
	
	$ertj		= "";
	$orders		= explode(",",$_REQUEST['ordersn']);
	for($g=0;$g<count($orders);$g++){
		$sn 	=  $orders[$g];
		if($sn != ""){
			$ertj	.= " a.ebay_id='$sn' or";
		}
			
	}
	$ertj			 = substr($ertj,0,strlen($ertj)-3);
	if($ertj == ""){
		$sql	= "select distinct a.* from ebay_order AS a
			JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn where ebay_user='$user' and a.ebay_status='1' and a.ebay_combine!='1' order by ORDER BY b.sku";	
	}else{	
		$sql	= "select distinct a.* from ebay_order AS a
	JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn where ($ertj) and a.ebay_user='$user' and a.ebay_combine!='1'  ORDER BY b.sku ";	
	}
	//echo $sql;	
	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);
	
	date_default_timezone_set ("Asia/Chongqing");	
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);
	$pdf->SetLeftMargin(5);
	$pdf->SetTopMargin(10);
	
	$xx		= 0;
	$yy		= 4;
	
	$currentpage = 0;
	
	$pdf->SetFont('arialms', 'B', 12);
	$pdf->AddPage();
	$pdf->SetFillColor(255, 255, 255);
	$pdf->setPageOrientation('P','false','0');
	$width='64.5';
	$height="33.8";	
	$x=1;
	$y=3;
	$a=0;
	for($i=0;$i<count($sql);$i++){
			
			$name					= $sql[$i]['ebay_username'];
			$street1				= @$sql[$i]['ebay_street'];
			$street2 				= @$sql[$i]['ebay_street1'];
			$city 					= $sql[$i]['ebay_city'];
			$state					= $sql[$i]['ebay_state'];
			$countryname 			= $sql[$i]['ebay_countryname'];
			$zip					= $sql[$i]['ebay_postcode'];
			$tel					= $sql[$i]['ebay_phone'];
			$ebay_code              = $sql[$i]['ebay_id'];
			$ebay_ordersns          = $sql[$i]['ebay_ordersn'];
			$ebay_account			= $sql[$i]['ebay_account'];
			$vv="SELECT appname FROM `ebay_account` where ebay_account='$ebay_account'";
			$vv		= $dbcon->execute($vv);
			$vv		= $dbcon->getResultArray($vv);
			$appnamestr=$vv[0]['appname'];
			
			if($street2 == ''){
				$addressline	= $name."<br>".$street1."<br>".$city." ".$state." ".$zip."<br>".$countryname;
			}else{
				$addressline	= $name."<br>".$street1." ".$street2."<br>".$city." ".$state."  ".$zip."<br>".$countryname;
			}
			if($name != ''){
				if($a%3==0){
					if($a!=0){
						$y+=$height+3;
						$x=1;
					}
				}else{
					$x+=$width+7;
				}
			
				$pdf->SetFont('arialms', 'B', 12);
				$html = "
				<style>
				div {
					
				width:0.5;
				Line-height:1;
				}
				</style>";
				$html.="<div>".'TO:'.$addressline."</div>";
				$pdf->writeHTMLCell(64.5, 33.5, $x, $y,$html, 1, false, false, false, '' );
				
				//$pdf->MultiCell(64.5, 33.5, 'TO:'.$addressline, $border=1, $align='L', $fill=false, $ln=1, $x, $y, $reseth=true, $stretch=0, $ishtml=TRUE, $autopadding=true, $maxh=0, $valign='T', $fitcell=FALSE);
				$pdf->SetFont('arialms', 'B', 6);
				$pdf->MultiCell(10, 5, $appnamestr.($i+1), $border=0, $align='R', $fill=false, $ln=1, $x+54, $y+1, $reseth=true, $stretch=0, $ishtml=TRUE, $autopadding=true, $maxh=0, $valign='T', $fitcell=FALSE);
				
				$a++;
			}

			
			
			if($a%24==0 ){
				$pdf->AddPage();
				$y = 3;
				$x=1;
				$a=0;
			}
	}
	
	$pdf->Output('shipping.pdf', 'I');

?>
     

