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
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '系统索引');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '导出时间');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '库存号');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '数量');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'Country');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', '发货时间');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', 'Tracking/ROYALMAIL');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', 'Combine');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', 'Area');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', 'Weekday');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', 'Item description');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', 'Commercial value in GBP');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', 'Name');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', 'House Number and Street');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1', 'District');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1', 'Town');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q1', 'County');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R1', 'serial No.');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S1', 'Postcode');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T1', 'SORT');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U1', '地址格式化');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V1', '订单重量');

	
	
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
	
	$sql	= "select * from ebay_order as a where ebay_user='$user' and a.ebay_status='0' and a.ebay_combine!='1' ";
	$sql1	= "select a.*,b.* from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn = b.ebay_ordersn where a.ebay_user='$user' and a.ebay_status='0' and a.ebay_combine!='1' ";

	
	
	}else{
	
	$sql	= "select * from ebay_order as a where ($ertj) and ebay_user='$user' and a.ebay_combine!='1' ";
	$sql1	= "select a.*,b.* from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn = b.ebay_ordersn where a.ebay_user='$user' and ($ertj) and a.ebay_combine!='1' ";
	
	
	}
	
	$storeid	= $_REQUEST['country'];
	if($storeid != '' && $storeid !='0'){
		
		$sql	.= " and b.storeid='$storeid' order by ebay_account,recordnumber";
		$sql1   .= " and b.storeid='$storeid' GROUP BY a.ebay_ordersn";
		
	
	}else{
	
	
		$sql	.= "  order by ebay_account,recordnumber";
		$sql1   .= "  GROUP BY a.ebay_ordersn";
	}
	if($storeid == "0"){
	
		
		die("Please select import warehouse.");
		
	
	}else{
	
		
		$ss		= "select * from ebay_store where id='$storeid'";
		$ss		= $dbcon->execute($ss);
		$ss		= $dbcon->getResultArray($ss);
		$storename = $ss[0]['store_name'];
		
	
	}
	


	

	$sql	= $dbcon->execute($sql1);
	$sql	= $dbcon->getResultArray($sql);

	$r		= 0;
	$reg	= 1;
	
	
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
			 $ebay_paidtime	 		= $sql[$i]['ebay_paidtime'];
			 $ebay_markettime		= $sql[$i]['ebay_markettime'];
			 $ebay_total			= $sql[$i]['ebay_total'];
			 $istracking			= "";
			 if($ebay_total >=15) {
			 
			 $istracking	= 'T'.$reg;
			 $reg++;
			 
			 
			 }
			
			
			
			$sq		= "select * from ebay_orderdetail where ebay_ordersn='$ordersn' and storeid='$storeid'";

			
			$sq		= $dbcon->execute($sq);
			$sq		= $dbcon->getResultArray($sq);
			$quantity	= 0;
			$sku		= "";
			
			
			$aa			= 'A'.$a;
			$bb			= 'B'.$a;
			$cc			= 'C'.$a;
			$dd			= 'D'.$a;
			$ee			= 'E'.$a;		
			$ff			= 'F'.$a;		
			$gg			= 'G'.$a;
			$hh			= 'H'.$a;
			$ii			= 'I'.$a;
			$jj			= 'J'.$a;
			$kk			= 'K'.$a;
			$ll			= 'L'.$a;
			$mm			= 'M'.$a;
			$nn			= 'N'.$a;
			$oo			= 'O'.$a;
			$pp			= 'P'.$a;
			$qq			= 'Q'.$a;
			$rr			= 'R'.$a;
			$ss			= 'S'.$a;
			$tt			= 'T'.$a;
			$uu			= 'U'.$a;
			$vv			= 'V'.$a;
			
			$skut		= "";
			$quantity	= 0;
			$itemtitle  = "";
			$combine	= 0;
			$skut1      = '';
			$yes		= 0;
			
			
			for($t=0;$t<count($sq);$t++){
				$itemtitle		.= $sq[$t]['ebay_itemtitle']." ";
				$sku			= $sq[$t]['sku'];				
				$itemcount		= $sq[$t]['ebay_amount'];
				
				$strsku			= explode("_",$sku);
				$strskustr		= $strsku[0];
				$strskunumber	= $strsku[2]?$strsku[2]:1;
				echo $strskustr;
				
				if(strstr($strskustr,'+')){
					$yes			= 1;
					
					$cstr		= explode('+',$strskustr);
					for($h=0;$h<count($cstr);$h++){
						
						
						$quantity	+= $itemcount*$strskunumber;
						$skut	.= $cstr[$h]."*".($itemcount*$strskunumber).chr(10) ;
						
					}					
					
					print_r($cstr);
					
				
				
				}else{
				
					$skut	.= $strskustr."*".($itemcount*$strskunumber).chr(10) ;
					$quantity	+= $itemcount*$strskunumber;
					
					
				}
				
				
				
				
				
				
				
			}
	
	echo $skut;
	
			
			if($t>1 || $yes==1){
					$skut1 = $skut;
					
				 $skut = "CC".($combine+1);
				 
				 
			
			}else{
			
				
				$sku			= $sq[0]['sku'];
				$strsku			= explode("_",$sku);
				 $skut			= $strsku[0];
				 
			
			}
			
			

	
	
			if($city != ""){
				$addressline	= $name.chr(10).$street1." ".$street2.chr(10).$city.", ".$state.' '.chr(10).$zip.chr(10).$countryname.chr(10).$tel;
				$addressline1	= $name.chr(10).$street1." ".$street2.chr(10).$city.", ".$state.' '.chr(10).$zip.chr(10).$countryname;
			}else{
				$addressline	= $name.chr(10).$street1." ".$street2.chr(10).", ".$state.' '.chr(10).$zip.chr(10).$countryname.chr(10).$tel;
				$addressline1	= $name.chr(10).$street1." ".$street2.chr(10).$city.", ".$state.' '.chr(10).$zip.chr(10).$countryname;
				
			}
				$addressline	= str_replace("&acute;","'",$addressline);
				$addressline1	= str_replace("&acute;","'",$addressline1);
				
				$serilnumber	= $r+1;
				$serilnumber	= sprintf("%04d", $serilnumber);
				$ordernumber	= date('Y').date('m').date('d').$serilnumber;
				
				
				
				
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($aa, $ordernumber);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($bb, $ebay_paidtime);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cc, $skut);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($dd, $quantity);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($ee, $countryname);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($ff, $ebay_markettime);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($gg, $istracking);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($hh, $skut1);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($ii, '');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($jj, date('w'));
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kk, $itemtitle);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($ll, $ebay_total);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($mm, $name);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($nn, $street1." ".$street2);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($oo, '');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($pp, $city);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($qq, $countryname);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($rr, '');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($ss, $zip);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($tt, '');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($uu, $addressline1);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($vv, '');
				
				
				
				$a		= $a+1;
				$r++;
				
	
	}


	die();
	
	
	$objPHPExcel->getActiveSheet(0)->getStyle('A1:E500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


	
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(15);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(25);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(38);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(10);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(15);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('K')->setWidth(38);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('U')->setWidth(43);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(15);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(20);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('L')->setWidth(25);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('N')->setWidth(25);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('V')->setWidth(15);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('M')->setWidth(15);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('P')->setWidth(15);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('Q')->setWidth(15);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth(20);
	
	$objPHPExcel->getActiveSheet(0)->getStyle('A1:Z500')->getAlignment()->setWrapText(true);

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
