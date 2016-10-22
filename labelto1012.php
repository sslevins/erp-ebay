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
			$pdf->AddPage('p',array(289,205),true);
			$pdf->SetFillColor(255, 255, 255);
			$pdf->setPageOrientation('P','false','0');
			
			
			
			
	for($i=0;$i<count($sql);$i++){
			
			$ebay_id					= $sql[$i]['ebay_id'];
			$name					= $sql[$i]['ebay_username'];
			$street1				= @$sql[$i]['ebay_street'];
			$street2 				= @$sql[$i]['ebay_street1'];
			$city 					= $sql[$i]['ebay_city'];
			$state					= $sql[$i]['ebay_state'];
			$countryname 			= $sql[$i]['ebay_countryname'];
			$zip					= $sql[$i]['ebay_postcode'];
			$tel					= $sql[$i]['ebay_phone'];
			$ebay_note				= $sql[$i]['ebay_note'];
			$ebay_phone				= $sql[$i]['ebay_phone'];
			$ebay_ordersn				= $sql[$i]['ebay_ordersn'];
			if($countryname == 'United Kingdom'){
			$addressline01			= 'TO:'.$name.'<br>'.$street1.' '.$street2.'<br>'.$city.' '.$state.' '.$zip.'<br>'.$countryname;
			}else{
			$addressline01			= 'TO:'.$name.'<br>'.$street1.' '.$street2.'<br>'.$city.' '.$state.' '.$zip.'<br>'.$countryname.'<br><br><br>small package air mail';
			}
			
			
			$tablline				= '';
			
			if($name != ''){
			
				/* 取得对应的sku */
					$vv  	 = "SELECT * from ebay_orderdetail WHERE ebay_ordersn = '$ebay_ordersn' ";
					$vv		 = $dbcon->execute($vv);
					$vv		 = $dbcon->getResultArray($vv);

					
					$tmpSku  = '';
					for($j=0;$j<count($vv);$j++){
						$tmpSku .= ">".$vv[$j]['sku']."  * ".$vv[$j]['ebay_amount'].'<br>  ';
					}
					
				$img = 't1.jpg';
				if($countryname == 'United Kingdom'){
					$img = 't2.jpg';
				}
				
				$tabline			= '<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>
    			<td width="52%" rowspan="2"><br>
    <br><br><br>'.$addressline01.'</td>
    			<td colspan="2" >     <img src="'.$img.'"  width="130" height="44"  /></td>
  				</tr>
  				<tr>
    			<td width="7%">&nbsp;</td>
  				<td width="40%" align="right"><br>
  				  <br>'.$tmpSku.'</td>
  </tr></table>';
				
				$pdf->setX(0);
				$pdf->setY($yy);
				$pdf->MultiCell(100, 88, $tabline, 1, 'L', 1, 0, '', '', true,0,true);
				
				$pdf->setXY(3,$yy+75);
				
				$pdf->SetFont('cid0jp', '', 8);
				$pdf->MultiCell(88, 10, 'If undelivered please return to: J LIANG, 20 Arras Close,Trowbridge, BA14 0QN, UK', 0, 'L', 1, 0, '', '', true,0,true);
				
				$pdf->SetFont('cid0jp', '', 13);
				
				$pdf->write1DBarcode($ebay_id, 'C128A',60, $yy+55, 40, 10, 0.4, $style, 'N');
				$pdf->setXY(68,$yy+65);
				$pdf->MultiCell(25, 5, $ebay_id, 0, 'L', 1, 0, '', '', true,0,true);
				$currentpage++;
		
			}
			
			$i++;
			$name2					= $sql[$i]['ebay_username'];
			$ebay_id					= $sql[$i]['ebay_id'];
			$street1				= @$sql[$i]['ebay_street'];
			$street2 				= @$sql[$i]['ebay_street1'];
			$city 					= $sql[$i]['ebay_city'];
			$state					= $sql[$i]['ebay_state'];
			$countryname 			= $sql[$i]['ebay_countryname'];
			$zip					= $sql[$i]['ebay_postcode'];
			$tel					= $sql[$i]['ebay_phone'];
			$ebay_note				= $sql[$i]['ebay_note'];
			$ebay_phone				= $sql[$i]['ebay_phone'];
			$ebay_ordersn				= $sql[$i]['ebay_ordersn'];
			
			if($countryname == 'United Kingdom'){
			$addressline02			= 'TO:'.$name2.'<br>'.$street1.' '.$street2.'<br>'.$city.' '.$state.' '.$zip.'<br>'.$countryname;
			}else{
			$addressline02			= 'TO:'.$name2.'<br>'.$street1.' '.$street2.'<br>'.$city.' '.$state.' '.$zip.'<br>'.$countryname.'<br><br><br>small package air mail';
			}
			
			if($name2 != ''){
				
					$vv  	 = "SELECT * from ebay_orderdetail WHERE ebay_ordersn = '$ebay_ordersn' ";
					$vv		 = $dbcon->execute($vv);
					$vv		 = $dbcon->getResultArray($vv);
					$tmpSku  = '';
					for($j=0;$j<count($vv);$j++){
						$tmpSku .= ">".$vv[$j]['sku']."  * ".$vv[$j]['ebay_amount'].'<br>  ';
					}
					
					
				$img = 't1.jpg';
				if($countryname == 'United Kingdom'){
					$img = 't2.jpg';
				}	
					
				$tabline			= '<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>
    			<td width="52%" rowspan="2"><br>
    <br><br><br>'.$addressline02.'</td>
    			<td colspan="2" >     <img src="'.$img.'"  width="130" height="44"  /></td>
  				</tr>
  				<tr>
    			<td width="7%">&nbsp;</td>
  				<td width="40%" align="right"><br>
  				  <br>'.$tmpSku.'</td>
  </tr></table>';
				
				$pdf->setXY(103,$yy);
				$pdf->MultiCell(100, 88, $tabline, 1, 'L', 1, 0, '', '', true,0,true);
				
				
				$pdf->setXY(104,$yy+75);
				
				$pdf->SetFont('cid0jp', '', 8);
				$pdf->MultiCell(88, 10, 'If undelivered please return to: J LIANG, 20 Arras Close,Trowbridge, BA14 0QN, UK', 0, 'L', 1, 0, '', '', true,0,true);
				$pdf->write1DBarcode($ebay_id, 'C128A',160, $yy+55, 40, 10, 0.4, $style, 'N');
				$pdf->SetFont('cid0jp', '', 13);
				$pdf->setXY(170,$yy+65);
				$pdf->MultiCell(20, 10, $ebay_id, 0, 'L', 1, 0, '', '', true,0,true);
				$name2 = '';
				$currentpage++;
				
			}
			$yy = $yy + 90;
			
			$imagey = $imagey + 70;
			
			$pdf->setY($yy);
			
			

			if($currentpage%6 == 0 && $currentpage < $totalcount){
				
				$pdf->AddPage('p',array(289,205),true);
				$yy = 4;
			}
	
	}
	





// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_008.pdf', 'I');

	 
	 ?>
     


