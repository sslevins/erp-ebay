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
	
	$sql	= "select a.*,b.sku from ebay_order  as a join ebay_orderdetail as b on a.ebay_ordersn=b.ebay_ordersn   where ($ertj) and a.ebay_user='$user' group  by a.ebay_id order by b.ebay_itemtitle asc ";

	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);

	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'LETTLE', true, 'UTF-8', false);
	$pdf->setPageOrientation('P', FALSE,0);
	
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
	$pdf->SetFont('cid0jp','B',10);
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);
	$pdf->SetMargins(0,0,0);
	$pdf->AddPage();
	
	$xx		= 105;
	$yy		= 5;
	$currentpage = 0;
	
	$styleCode = array(
				'position' => '',
				'align' => 'C',
				'stretch' => false,
				'fitwidth' => true,
				'cellfitalign' => '',
				'border' => false,
				'hpadding' => 'auto',
				'vpadding' => 'auto',
				'fgcolor' => array(0,0,0),
				'bgcolor' => false, //array(255,255,255),
				'text' => false,
				'font' => 'helvetica',
				'fontsize' => 8,
				'stretchtext' => 4
	);
	
	for($i = 0;$i<count($sql);$i++){
			$name = $sql[$i]['ebay_username'];
			$street1 = @$sql[$i]['ebay_street'];
			$street2  = @$sql[$i]['ebay_street1'];
			$ebay_state = $sql[$i]['ebay_city'].$sql[$i]['ebay_state'];
			$countryname  = $sql[$i]['ebay_countryname'];
			$zip = $sql[$i]['ebay_postcode'];
			$ebay_orderid = $sql[$i]['ebay_id'];
			
			$recordnumber = $sql[$i]['recordnumber'];
			if($name !=''){
				$pdf->SetFont('cid0jp','B',18);
				$pdf->SetXY(5,$yy);
				$pdf->Write(5, 'POST TO:', '', 0, '', false, 0, false, false, 0);
				
				$yy = $yy + 6 ;
				$pdf->SetFont('cid0jp','B',14);
				$pdf->SetXY(5+5,$yy);
				$pdf->Write(5, $name, '', 0, '', false, 0, false, false, 0);
				
				$yy = $yy + 5.5 ;
				$pdf->SetFont('cid0jp','',14);
				$pdf->SetXY(5+5,$yy);
				$pdf->Write(5, $street1, '', 0, '', false, 0, false, false, 0);
				
				if($street2==''&&$ebay_state==''){
					$yy = $yy + 5.5 ;
					$pdf->SetXY(5+5,$yy);
					$pdf->Write(5, $countryname, '', 0, '', false, 0, false, false, 0);
					$yy = $yy+11;
				}else if($street2==''&&$ebay_state!=''){
					$yy = $yy + 5.5 ;
					$pdf->SetXY(5+5,$yy);
					$pdf->Write(5, $ebay_state, '', 0, '', false, 0, false, false, 0);
					
					$yy = $yy + 5.5 ;
					$pdf->SetXY(5+5,$yy);
					$pdf->Write(5, $countryname, '', 0, '', false, 0, false, false, 0);
					
					$yy = $yy + 5.5 ;
				}else if($street2!=''&&$ebay_state==''){
					$yy = $yy + 5.5 ;
					$pdf->SetXY(5+5,$yy);
					$pdf->Write(5, $street2, '', 0, '', false, 0, false, false, 0);
					
					$yy = $yy + 5.5 ;
					$pdf->SetXY(5+5,$yy);
					$pdf->Write(5, $countryname, '', 0, '', false, 0, false, false, 0);
					$yy = $yy + 5.5 ;
				}else{
					$yy = $yy + 5.5 ;
					$pdf->SetXY(5+5,$yy);
					$pdf->Write(5, $street2, '', 0, '', false, 0, false, false, 0);
					
					$yy = $yy + 5.5 ;
					$pdf->SetXY(5+5,$yy);
					$pdf->Write(5, $ebay_state, '', 0, '', false, 0, false, false, 0);
					
					$yy = $yy + 5.5 ;
					$pdf->SetXY(5+5,$yy);
					$pdf->Write(5, $countryname, '', 0, '', false, 0, false, false, 0);
				}
				
				$pdf->write1DBarcode($ebay_orderid, 'C128', $xx-103, $yy+4, 55, 15, 0.6, $styleCode, 'N');
				
				$pdf->SetFont('cid0jp','B',32);
				$yy = $yy + 3.5;
				$pdf->SetXY($xx-80,$yy);
				$pdf->Cell (70, $h=15, $txt=$zip, $border=0, $ln=0, $align='R', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M');
				
				$style = array('width'=>0.8,'cap'=>'butt','join'=>'miter','dish'=>'0','color'=>array(0,0,0));
				$pdf->SetLineStyle($style);
				$yy = $yy + 15;
				$pdf->Line(0,$yy,$xx-2,$yy);
				
				$pdf->SetFont('cid0jp','B',8);
				$pdf->SetXY(4,$yy);
				$pdf->Write(5, 'Label made by CRAZY APPLE STORE', '', 0, '', false, 0, false, false, 0);
				
				$pdf->SetXY(strlen("Label made by CRAZY APPLE STORE")*2+2,$yy);
				$pdf->Write(5, ($currentpage+1), '', 0, '', false, 0, false, false, 0);
				
				$pdf->SetXY(strlen("Label made by CRAZY APPLE STORE")*2+5+10,$yy);
				$pdf->Write(5, $recordnumber, '', 0, '', false, 0, false, false, 0);
				
				$pdf->SetFont('cid0jp',$style,7);
				
				$yy = $yy + 3.5;
				$pdf->SetXY(4,$yy);
				$pdf->Write(5, 'Aviation Security and Dangerous Goods Declaration', '', 0, '', false, 0, false, false, 0);
				
				$pdf->SetFont('cid0jp','I',7);
				$yy = $yy + 3.5;
				$pdf->SetXY(4,$yy);
				$pdf->Write(5, 'The sender acknowledges that this article may be carried by air and will be', '', 0, '', false, 0, false, false, 0);
				
				$yy = $yy + 3.5;
				$pdf->SetXY(4,$yy);
				$pdf->Write(5, 'subject to aviation security and clearing procedures and the sender declares that', '', 0, '', false, 0, false, false, 0);
				
				$yy = $yy + 3.5;
				$pdf->SetXY(4,$yy);
				$pdf->Write(5, 'the article does not contain any dangerous or prohibited goods,', '', 0, '', false, 0, false, false, 0);
				
				$currentpage++;
			}
			$i++;
			$name2 = $sql[$i]['ebay_username'];
			$street1 = @$sql[$i]['ebay_street'];
			$street2  = @$sql[$i]['ebay_street1'];
			$ebay_state = $sql[$i]['ebay_city'].$sql[$i]['ebay_state'];
			$countryname  = $sql[$i]['ebay_countryname'];
			$zip = $sql[$i]['ebay_postcode'];
			$ebay_orderid = $sql[$i]['ebay_id'];
			$recordnumber = $sql[$i]['recordnumber'];
			
			$yy = $yy - 60.5;
			if($name2 !=''){
				$pdf->SetFont('cid0jp','B',18);
				$pdf->SetXY($xx+5,$yy);
				$pdf->Write(5, 'POST TO:', '', 0, '', false, 0, false, false, 0);
				
				$yy = $yy + 6 ;
				$pdf->SetFont('cid0jp','B',13);
				$pdf->SetXY($xx+5+5,$yy);
				$pdf->Write(5, $name2, '', 0, '', false, 0, false, false, 0);
				
				$yy = $yy + 5.5 ;
				$pdf->SetXY($xx+5+5,$yy);
				$pdf->Write(5, $street1, '', 0, '', false, 0, false, false, 0);
				
				if($street2==''&&$ebay_state==''){
					$yy = $yy + 5.5;
					$pdf->SetXY($xx+5+5,$yy);
					$pdf->Write(5, $countryname, '', 0, '', false, 0, false, false, 0);
					$yy = $yy+11;
				}else if($street2==''&&$ebay_state!=''){
					$yy = $yy + 5.5 ;
					$pdf->SetXY($xx+5+5,$yy);
					$pdf->Write(5, $ebay_state, '', 0, '', false, 0, false, false, 0);
					
					$yy = $yy + 5.5 ;
					$pdf->SetXY($xx+5+5,$yy);
					$pdf->Write(5, $countryname, '', 0, '', false, 0, false, false, 0);
					
					$yy = $yy + 5.5 ;
				}else if($street2!=''&&$ebay_state==''){
					$yy = $yy + 5.5 ;
					$pdf->SetXY($xx+5+5,$yy);
					$pdf->Write(5, $street2, '', 0, '', false, 0, false, false, 0);
					
					$yy = $yy + 5.5 ;
					$pdf->SetXY($xx+5+5,$yy);
					$pdf->Write(5, $countryname, '', 0, '', false, 0, false, false, 0);
					$yy = $yy + 5.5 ;
				}else{
					$yy = $yy + 5.5 ;
					$pdf->SetXY($xx+5+5,$yy);
					$pdf->Write(5, $street2, '', 0, '', false, 0, false, false, 0);
					
					$yy = $yy + 5.5 ;
					$pdf->SetXY($xx+5+5,$yy);
					$pdf->Write(5, $ebay_state, '', 0, '', false, 0, false, false, 0);
					
					$yy = $yy + 5.5 ;
					$pdf->SetXY($xx+5+5,$yy);
					$pdf->Write(5, $countryname, '', 0, '', false, 0, false, false, 0);
				}
				
				$pdf->write1DBarcode($ebay_orderid, 'C128', $xx-0, $yy+4, 55, 15, 0.6, $styleCode, 'N');
				
				$pdf->SetFont('cid0jp','B',32);
				$yy = $yy + 3.5 ;
				$pdf->SetXY($xx+26,$yy);
				$pdf->Cell (70, $h=15, $txt=$zip, $border=0, $ln=0, $align='R', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M');
				
				$pdf->SetLineStyle($style);
				$yy = $yy + 15 ;
				$pdf->Line($xx,$yy,215,$yy);
				
				$pdf->SetFont('cid0jp','B',8);
				$pdf->SetXY($xx+3,$yy);
				$pdf->Write(5, 'Label made by CRAZY APPLE STORE', '', 0, '', false, 0, false, false, 0);
				
				$pdf->SetXY($xx+3+strlen("Label made by CRAZY APPLE STORE")*2,$yy);
				$pdf->Write(5, ($currentpage+1), '', 0, '', false, 0, false, false, 0);
				
				$pdf->SetXY($xx+3+strlen("Label made by CRAZY APPLE STORE")*2+15,$yy);
				$pdf->Write(5, $recordnumber, '', 0, '', false, 0, false, false, 0);
				$pdf->SetFont('cid0jp',$style,7);
				$yy = $yy + 3.5;
				$pdf->SetXY($xx+3,$yy);
				$pdf->Write(5, 'Aviation Security and Dangerous Goods Declaration', '', 0, '', false, 0, false, false, 0);
				
				$pdf->SetFont('cid0jp','I',7);
				$yy = $yy + 3.5;
				$pdf->SetXY($xx+2,$yy);
				$pdf->Write(5, 'The sender acknowledges that this article may be carried by air and will be', '', 0, '', false, 0, false, false, 0);
				
				$yy = $yy + 3.5;
				$pdf->SetXY($xx+2,$yy);
				$pdf->Write(5, 'subject to aviation security and clearing procedures and the sender declares that', '', 0, '', false, 0, false, false, 0);
				
				$yy = $yy + 3.5;
				$pdf->SetXY($xx+2,$yy);
				$pdf->Write(5, 'the article does not contain any dangerous or prohibited goods,', '', 0, '', false, 0, false, false, 0);
				$name2 = '';
				$currentpage++;
			}
			$yy = $yy + 15;
			$pdf->setY($yy);
			
			if($currentpage%8 == 0){
				$pdf->AddPage();
				$yy = 5;
			}
	}
	
	$pdf->Output('superseller.pdf', 'I');
?>