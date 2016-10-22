<?php
@session_start();
error_reporting(0);
$user	= $_SESSION['user'];
include "../include/dbconnect.php";	

require_once('../tcpdf/config/lang/eng.php');
require_once('../tcpdf/tcpdf.php');

$dbcon	= new DBClass();

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
	
	$sql	= "select * from ebay_order as a where ebay_user='$user' and a.ebay_status='1' and a.ebay_combine!='1' ";	
	}else{	
	$sql	= "select * from ebay_order as a where ($ertj) and ebay_user='$user' and a.ebay_combine!='1' ";	
	}	

		
	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);

	
	
	
date_default_timezone_set ("Asia/Chongqing");	

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);


$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetLeftMargin(0);
$pdf->SetTopMargin(0);
	
	$xx		= 0;
	$yy		= 4;
	
	$currentpage = 0;
	
			
		
	for($i=0;$i<count($sql);$i++){
			$pdf->SetFont('cid0jp', '', 13);
			$pdf->AddPage('mm',array(102,70),true);
			$pdf->setPageOrientation('mm','false','0');
			$name					= $sql[$i]['ebay_username'];
			$ebayid					= $sql[$i]['ebay_id'];
			$street1				= @$sql[$i]['ebay_street'];
			$street2 				= @$sql[$i]['ebay_street1'];
			$city 					= $sql[$i]['ebay_city'];
			$state					= $sql[$i]['ebay_state'];
			$countryname 			= $sql[$i]['ebay_countryname'];
			$zip					= $sql[$i]['ebay_postcode'];
			$tel					= $sql[$i]['ebay_phone'];
			$ebay_note				= $sql[$i]['ebay_note'];
			$ebay_phone				= $sql[$i]['ebay_phone'];
			$addressline01			= $name.'<br>'.$street1.', <br>'.$city.', '.$state.',<br>'.$zip.',<br> '.$countryname;
			$html	= '<div style="border:1px solid #000000; width:28mm;height:66mm"><img src="rm1.jpg" style="width:44mm;height:14mm;-webkit-transform: rotate(-90deg);-moz-transform: rotate(-90deg);filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3); display:block;"/>';
			$html 	.= '<div style="writing-mode:tb-rl;">sku/weight/qty/huoweihao</div>';
			//echo $html;
			//exit;
			$pdf->SetFillColor(255, 255, 255);
			$pdf->Image('rm1.jpg', 42, 2,54,14, 'jpg', 'http://www.tcpdf.org', '', true, 150, '', false, false, 0, false, false, false);
			$pdf->writeHTML($html, true, false, true, false, '');
			$pdf->setXY(42,25);
			$pdf->MultiCell(56,30, $addressline01, 1, 'L', 1, 0, '', '', true,0,true);
			
	}
	





// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_008.pdf', 'I');

	 
	 ?>
     


