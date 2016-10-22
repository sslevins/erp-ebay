<?php
include "include/dbconnect.php";	
	date_default_timezone_set ("Asia/Chongqing");	

$dbcon	= new DBClass();
//error_reporting(0);
@session_start();
$user	= $_SESSION['user'];
require_once 'Classes/PHPExcel.php';


	$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");

	$a		= 2;
	$b		= 2;
	$c		= 1;
	$d		= 1;
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '序号');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '收货人地址');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'custom label');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '发货状态');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', '发货方式');

	
	
	function getmerge($ordersn){
		
		global $dbcon;
	
		
	
		$sql	= "select * from ebay_orderdetail where ebay_ordersn='$ordersn' ";
		$sql	= $dbcon->execute($sql);
		$sql	= $dbcon->getResultArray($sql);

		
		
		
				$count		= 0;
		$skuarray	= array();
		$tj			= "";
		
		for($i=0;$i<count($sql);$i++){			
			
			$sku	= $sql[$i]['sku'];
			$count	+= $sql[$i]['ebay_amount'];
			$tj		= $sku;
			
				
			
		}
			
	
		return $tj;
	
		
	}

		function getcount($ordersn){
		
		global $dbcon;
		
		$sql	= "select * from ebay_orderdetail where ebay_ordersn='$ordersn'";
		$sql	= $dbcon->execute($sql);
		$sql	= $dbcon->getResultArray($sql);		
				$count		= 0;
		$skuarray	= array();
		$tj			= "";
		
		for($i=0;$i<count($sql);$i++){			
				
			$sku	= $sql[$i]['sku'];
			$count	+= $sql[$i]['ebay_amount'];
			$tj		= $sku."*".$count;	
			
		}
	
		return $count;
		
		
	}
	
	
	
	$ertj		= "";
	$orders		= explode(",",$_REQUEST['ordersn']);
	for($g=0;$g<count($orders);$g++){
		$sn 	=  $orders[$g];
		if($sn != ""){
				
					$ertj	.= " a.ebay_ordersn='$sn' or";
		}
			
	}
	$ertj			 = substr($ertj,0,strlen($ertj)-3);
	if($ertj == ""){
	
	$sql	= "select * from ebay_order as a where ebay_user='$user' and a.ebay_status='0' and a.ebay_combine='1' order by ebay_account,recordnumber";
	$sql1	= "select sku,sum(b.ebay_amount) from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn = b.ebay_ordersn where a.ebay_user='$user' and a.ebay_status='0' and a.ebay_combine='1' group by b.sku order by b.sku";

	
	
	}else{
	
	$sql	= "select * from ebay_order as a where ($ertj) and ebay_user='$user' and a.ebay_status='0' and a.ebay_combine='1' order by ebay_account,recordnumber";
	$sql1	= "select sku,sum(b.ebay_amount) from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn = b.ebay_ordersn where a.ebay_user='$user' and a.ebay_status='0' and ($ertj) and a.ebay_combine='1' GROUP BY b.sku ORDER BY b.sku";
	
	
	}

	

		


	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);
	
	$r		= 0;
	
	for($i=0;$i<count($sql);$i++){

			$ordersn		= $sql[$i]['ebay_ordersn'];	
			$ebayaccount	= $sql[$i]['ebay_account'];
			$ebay_usermail	= $sql[$i]['ebay_usermail'];
			$userid			= $sql[$i]['ebay_userid'];
			$name			= $sql[$i]['ebay_username'];
			$street1		= @$sql[$i]['ebay_street'];
			$street2 		= @$sql[$i]['ebay_street1'];
			$city 			= $sql[$i]['ebay_city'];
			$state			= $sql[$i]['ebay_state'];
			$countryname 	= $sql[$i]['ebay_countryname'];
			$zip0			= $sql[$i]['ebay_postcode'];
			$ebay_tracknumber			= $sql[$i]['ebay_tracknumber'];
			$ebay_noteb					= $sql[$i]['ebay_noteb'];
			$ebay_carrier					= $sql[$i]['ebay_carrier'];
			
	
			$zip			= $zip0;
			$tel			= $sql[$i]['ebay_phone'];
			$is_reg		   = $sql[$i]['is_reg'];
			
			if($tel =="") $tel = "";
			
			if($tel =="Invalid Request") $tel = "";
			if($tel !== ""){
			$tel1 = $tel;
			$tel = 'Tel:'.$tel;
			
			
			}
			
			
		
	
			 $ebay_note 			= $sql[$i]['ebay_note'];
		

	
			
			
			
			$sq		= "select * from ebay_orderdetail where ebay_ordersn='$ordersn'";

			
			$sq		= $dbcon->execute($sq);
			$sq		= $dbcon->getResultArray($sq);
			$quantity	= 0;
			$sku		= "";
			
			
			$aa			= 'A'.$a;
			$bb			= 'B'.$a;
			$cc			= 'C'.$a;
			$dd			= 'D'.$a;
			$ee			= 'E'.$a;		
			$skut		= "";
			
			for($t=0;$t<count($sq);$t++){
			
				
			
				$itemtitle		= $sq[$t]['ebay_itemtitle'];
				$sku			= $sq[$t]['sku'];				
				$itemcount		= $sq[$t]['ebay_amount'];				
			
				$skut	.= $sku."*".$itemcount.chr(10) ;
				
			}
					
			
			if($city != ""){
				$addressline	= $name.chr(10).$street1." ".$street2.chr(10).$city.", ".$state.' '.$zip.chr(10).$countryname.chr(10).$tel;
				$addressline1	= $name.chr(10).$street1." ".$street2.chr(10).$city.", ".$state.' '.$zip.chr(10).$countryname;
				
			
			
			}else{
				$addressline	= $name.chr(10).$street1." ".$street2.chr(10).", ".$state.' '.$zip.chr(10).$countryname.chr(10).$tel;
				$addressline1	= $name.chr(10).$street1." ".$street2.chr(10).$city.", ".$state.' '.$zip.chr(10).$countryname;
				
				
			
				
			}
				$addressline	= str_replace("&acute;","'",$addressline);
				$addressline1	= str_replace("&acute;","'",$addressline1);
				
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($aa, ''.$r+1);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($bb, ' '.$addressline);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cc, $skut);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($dd, ' ');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($ee, ' '.$ebay_carrier);
				
				$a		= $a+1;
				$r++;
				
			


		

	
	
	}
	
	$b	= $a+3;
	$c	= $a+1;
	
	
	$sql1		= $dbcon->execute($sql1);
	$sql1		= $dbcon->getResultArray($sql1);
	$total		= 0;
	
	for($i=0;$i<count($sql1);$i++){
		
			$aa			= 'A'.$b;
			$bb			= 'B'.$b;
			
			$sku		= $sql1[$i]['sku'];
			$qty		= $sql1[$i]['sum(b.ebay_amount)'];
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($aa, ' '.$sku);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($bb, ' '.$qty);
			
			$total	+= $qty;		
			$b++;
			
	
	
	
	}
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$c, ' 总计');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$c, ' '.$total);
			
	
	
	$objPHPExcel->getActiveSheet(0)->getStyle('A1:E500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


	
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(15);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(30);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(15);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(15);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(15);
	
	$objPHPExcel->getActiveSheet(0)->getStyle('A1:F500')->getAlignment()->setWrapText(true);

	$objPHPExcel->getActiveSheet(0)->getStyle('A1:N500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	$title		= "summary".date('Y-m-d');
	$titlename		= "summary".date('Y')."-".date('m')."-".date('d').".xls";
	
	
	$objPHPExcel->getActiveSheet()->setTitle($title);
	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	// Redirect output to a client’s web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
	header("Content-Disposition: attachment;filename={$titlename}");
	header('Cache-Control: max-age=0');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;

?>
