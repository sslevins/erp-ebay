<?php
@session_start();
error_reporting(E_ALL);
$user	= $_SESSION['user'];
include "../include/dbconnect.php";	

require_once('../tcpdf/config/lang/eng.php');
require_once('../tcpdf/tcpdf.php');

$dbcon	= new DBClass();

	$ertj		= "";
	$orders		= explode(",",$_REQUEST['bill']);
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



	$totalcount = count($sql);
	
	
	
date_default_timezone_set ("Asia/Chongqing");	

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);




// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);


$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetLeftMargin(1);
$pdf->SetTopMargin(2);
	
	$xx		= 0;
	$yy		= 4;
	$imagey		= 4;
			$currentpage = 0;
	
			$pdf->SetFont('cid0jp', '', 13);
			$pdf->AddPage('p',array(101,151),true);
			$pdf->SetFillColor(255, 255, 255);
			$pdf->setPageOrientation('P','false','0');
			
			
			
			
	for($i=0;$i<count($sql);$i++){
			
				$ebay_tracknumber					= $sql[$i]['ebay_tracknumber'];			
				$img = '../images/'.$ebay_tracknumber.'.jpg';



				

				$tabline			= '<table width="100%" border="0" cellspacing="0" cellpadding="0">
  				<tr>
    			<td><img src="'.$img.'" width="280" height="395">&nbsp;</td>
				</tr></table';


				
				$pdf->setXY(0,0);
				$pdf->MultiCell(205, 10, $tabline, 1, 'L', 1, 0, '', '', true,0,true);


				if($i < (count($sql)-1)){
				$pdf->AddPage('p',array(101,151),true);
				}



		
			

			}
$pdf->Output('example_008.pdf', 'I');

	 
	 ?>