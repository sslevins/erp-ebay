<?php
@session_start();
error_reporting(0);

$user	= $_SESSION['user'];
include "include/dbconnect.php";	
date_default_timezone_set ("Asia/Chongqing");	
$dbcon	= new DBClass();
require_once 'Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->setActiveSheetIndex(0)->setTitle('fedex导出');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'Transaction ID');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Sender company name');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'Sender address 1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'Sender address 2');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'Sender City');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', 'Sender Country');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', 'Sender Phone Number');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', 'Sender postal code');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', "Sender's FedEx accout number");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', 'Sender Signature');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', "'Refernce Notes");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', "'Payment Type");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', "'Payer Account Number ");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1', "'Duty / Tax Paymernt Type");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1', "'Duty / Tax Payer Account Number");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q1', "'Package Weight");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R1', "'Number of Packages");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S1', "'Recipient Company Name");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T1', "'Recipient Contact Name");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U1', "'Recipient Address Line 1");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V1', "'Recipient Address Line 2");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W1', "'Recipient City");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X1', "'Recipient State");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y1', "'Recipient Zip Code");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z1', "'Receipient Tel #");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA1', "'Recipient Country Code");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB1', "Description 1");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC1', 'Harmonized code 1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD1', "'Commodity Unit Value 1");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AE1', "'Quantity 1");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AF1', "'Unit of Measure 1");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AG1', "'Country of Manufacture 1");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AH1', "'Admissibility Package Type");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AI1', 'Invoice Terms');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AJ1', 'CI Comments');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AK1', "'Packaging");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AL1', "'Service Type");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AM1', "'Sender Code ");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AL1', "'Currency");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AO1', "'Weight Type");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AP1', "'Document Shipment Flag");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AQ1', "'Dimension Unit of Measure ");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AR1', 'Package length');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AS1', 'Package width');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AT1', 'Package height');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AU1', 'Print commercail invoice (Y/N)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AV1', "'A null field");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AW1', '');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', '');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B2', '');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', '');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D2', '');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E2', '');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F2', '');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G2', '');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H2', '');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I2', '');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J2', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K2', '');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L2', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M2', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N2', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O2', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P2', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q2', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R2', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S2', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T2', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U2', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V2', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W2', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X2', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y2', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z2', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA2', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB2', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC2', '');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD2', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AE2', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AF2', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AG2', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AH2', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AI2', '');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AJ2', '');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AK2', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AL2', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AM2', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AL2', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AO2', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AP2', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AQ2', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AR2', '');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AS2', '');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AT2', '');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AU2', '');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AV2', "");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AW2', '');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', '0');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', '1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', '4');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', '5');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', '6');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F3', '7');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G3', '117');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H3', '183');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I3', '9');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J3', "10");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K3', '32');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L3', "25");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M3', "23");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N3', "20");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O3', "70");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P3', "71");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q3', "21");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R3', "116");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S3', "11");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T3', "12");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U3', "13");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V3', "14");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W3', "15");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X3', "16");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y3', "17");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z3', "18");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA3', "50");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB3', "79-1");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC3', '89-1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD3', "1030");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AE3', "82-1");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AF3', "414-1");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AG3', "80-1");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AH3', "1958");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AI3', '72');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AJ3', '418');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AK3', "1273");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AL3', "1274");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AM3', "31");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AL3', "68");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AO3', "75");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AP3', "190");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AQ3', "1116");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AR3', '59');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AS3', '58');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AT3', '57');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AU3', '113');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AV3', "99");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AW3', '');
	
	
$ordersn	= $_REQUEST['ordersn'];
$ordersn		= explode(",",$ordersn);
$Shipping		= $_REQUEST['Shipping'];
			$ostatus		= $_REQUEST['ostatus'];
			
			$keys		    = $_REQUEST['keys'];
			$searchtype		= $_REQUEST['searchtype'];
			$account		= $_REQUEST['acc'];
			$isnote		    = $_REQUEST['isnote'];
			$rcountry		= $_REQUEST['country'];
			$ebay_site		= $_REQUEST['ebay_site'];
			$start		    = $_REQUEST['start'];
			$end		    = $_REQUEST['end'];
			$ebay_ordertype	= $_REQUEST['ebay_ordertype'];
			$status		    = $_REQUEST['status'];
			$hunhe          =$_REQUEST['hunhe'];
	
	$tj		= '';
	for($i=0;$i<count($ordersn);$i++){
		
		
			if($ordersn[$i] != ""){
		
			 $sn			= $ordersn[$i];
			 
		$tj	.= "a.ebay_id='$sn' or ";
			}
			
		
	}
	
	
	$tj		= substr($tj,0,strlen($tj)-3);
	
	if($_REQUEST['ordersn'] == ''){
		
		$sql="select * from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn=b.ebay_ordersn where ebay_user='$user' and a.ebay_status='1' and a.ebay_combine!='1'";
		
	
	if($ostatus!=='100')
			{
			$sql.=" and ebay_status='$ostatus'";	
		 }
	 if($Shipping!='')
			{
				$sql.=" and ebay_carrier='$Shipping'";
			}
			if($hunhe=='3')
			{
				$sql.=" and (select COUNT( * ) AS cc   from ebay_orderdetail as c where c.ebay_ordersn = a.ebay_ordersn  ) <= 4 ";
			}
			
			if($hunhe=='4')
			{
				$sql.=" and (select COUNT( * ) AS cc   from ebay_orderdetail as c where c.ebay_ordersn = a.ebay_ordersn  ) >=5 and (select COUNT( * ) AS cc   from ebay_orderdetail as c where c.ebay_ordersn = a.ebay_ordersn  ) <= 8 ";
			}
			
			if($hunhe=='5')
			{
				$sql.=" and (select COUNT( * ) AS cc   from ebay_orderdetail as c where c.ebay_ordersn = a.ebay_ordersn  ) >=9 ";
			}
			
			if($hunhe=='0'){
				$sql.=" and (select COUNT( * ) AS cc   from ebay_orderdetail as c where c.ebay_ordersn = a.ebay_ordersn  ) >=2 ";
			}
			
			if($hunhe=='1'){
				$sql.="and (select  sum(ebay_amount) AS cc  from ebay_orderdetail as c where c.ebay_ordersn = a.ebay_ordersn  ) = 1 ";
			}
			
			if($hunhe=='2'){
				$sql.="and (select  sum(ebay_amount) AS cc  from ebay_orderdetail as c where c.ebay_ordersn = a.ebay_ordersn)   > 1  and (select count(*) AS cc from ebay_orderdetail as c where c.ebay_ordersn = a.ebay_ordersn) = 1 ";
			}
			
			
			
			    if($searchtype == '0' && $keys != ''){$sql	.= " and a.recordnumber		 = '$keys' ";}
				if($searchtype == '1' && $keys != ''){$sql	.= " and a.ebay_userid		 = '$keys' ";}
				if($searchtype == '2' && $keys != ''){$sql	.= " and a.ebay_username	 = '$keys' ";}
				if($searchtype == '3' && $keys != ''){$sql	.= " and a.ebay_usermail	 = '$keys' ";}
				if($searchtype == '4' && $keys != ''){$sql	.= " and a.ebay_ptid		 = '$keys' ";}
				if($searchtype == '5' && $keys != ''){$sql	.= " and a.ebay_tracknumber	 like  '%$keys%' ";}
				if($searchtype == '6' && $keys != ''){$sql	.= " and b.ebay_itemid		 = '$keys' ";}
				if($searchtype == '7' && $keys != ''){$sql	.= " and b.ebay_itemtitle	 = '$keys' ";}
				if($searchtype == '8' && $keys != ''){$sql	.= " and b.sku			 	 = '$keys' ";}
				if($searchtype == '9' && $keys != ''){$sql	.= " and a.ebay_id			 	 = '$keys'";}
				if($searchtype == '10' && $keys != ''){$sql	.= " and (a.ebay_username like '%$keys%' or a.ebay_street like '%$keys%' or a.ebay_street1 like '%$keys%' or a.ebay_city like '%$keys%' or a.ebay_state like '%$keys%' or a.ebay_countryname like '%$keys%' or a.ebay_postcode like '%$keys%' or a.ebay_phone like '%$keys%') ";}
                 if($ebay_ordertype =='申请退款'  ) {$sql.=" and a.moneyback='1'";$ebay_ordertype=-1;}
				if($ebay_ordertype =='同意退款'  ) {$sql.=" and a.moneyback='8'";$ebay_ordertype=-1;}
                if($ebay_ordertype =='取消退款'  ){ $sql.=" and a.moneyback='2'";$ebay_ordertype=-1;}
                if($ebay_ordertype =='同意付款'  ){ $sql.=" and a.moneyback='9'";$ebay_ordertype=-1;}
                if($ebay_ordertype =='完成退款'  ){ $sql.=" and a.moneyback='10'";$ebay_ordertype=-1;}
                if($ebay_ordertype =='追回退款'  ) {$sql.=" and a.moneyback='5'";$ebay_ordertype=-1;}
                if($ebay_ordertype =='查询退款'  ){ $sql.=" and a.moneyback='6'";$ebay_ordertype=-1;}
                if($ebay_ordertype =='确定收款'  ){ $sql.=" and a.moneyback='7'";$ebay_ordertype=-1;}
                if($ebay_ordertype =='无法追踪'  ){ $sql.=" and a.erp_op_id='7'";$ebay_ordertype=-1;}
                if($ebay_ordertype =='妥投错误'  ){ $sql.=" and a.erp_op_id='7'";$ebay_ordertype=-1;}
                if($ebay_ordertype =='中国妥投'  ){ $sql.=" and a.erp_op_id='7'";$ebay_ordertype=-1;}
                if($ebay_ordertype =='已回公司'  ){ $sql.=" and a.erp_op_id=2";$ebay_ordertype=-1;}
				
				

				if( $isnote == '1') 	$sql.=" and a.ebay_note	!=''";
				if( $isnote == '0') 	$sql.=" and a.ebay_note	=''";
				if( $ebay_site != '') 	$sql.=" and b.ebay_site	='$ebay_site'";
				
				if($account !="") $sql.= " and a.ebay_account='$account'";
				
				
				
				if($start !='' && $end != ''){
					
					$st00	= strtotime($start." 00:00:00");
					$st11	= strtotime($end." 23:59:59");
					$sql.= " and (a.ebay_paidtime>=$st00 and a.ebay_paidtime<=$st11)";
				
				}
				$sql.="group by a.ebay_id order by ebay_userid";
	}else{
		
		$sql			= "select * from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn=b.ebay_ordersn where ($tj) and a.ebay_user='$user' and a.ebay_combine!='1' group by a.ebay_id order by a.ebay_account,b.sku";
	}
			
	 $sql			= $dbcon->execute($sql);
	 $sql			= $dbcon->getResultArray($sql);
	 $a		= 4;
	 $s		= 1;
	for($i=0;$i<count($sql);$i++){
		$ordersn		= $sql[$i]['ebay_ordersn'];
		$ebay_usermail	= $sql[$i]['ebay_usermail'];
		$ebay_userid	= $sql[$i]['ebay_userid'];	
		$name			= $sql[$i]['ebay_username'];
		$name	 	 	= str_replace("&acute;","'",$name);
		$name  			= str_replace("&quot;","\"",$name);
		$isadd = 0;
		
	    $street1			= @$sql[$i]['ebay_street'];
	    $street2 			= @$sql[$i]['ebay_street1'];
	    $city 				= $sql[$i]['ebay_city'];
	    $state				= $sql[$i]['ebay_state'];
	    $countryname 		= $sql[$i]['ebay_countryname'];
	    $recordnumber		= $sql[$i]['recordnumber'];
	    $zip				= $sql[$i]['ebay_postcode'];
	    $tel				= $sql[$i]['ebay_phone'];
		$ebay_couny			= $sql[$i]['ebay_couny'];
		$ebay_account		= $sql[$i]['ebay_account'];
		$street1	  	= str_replace("&acute;","'",$street1);
		$street1  		= str_replace("&quot;","\"",$street1);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$a, '20');
		$objPHPExcel->setActiveSheetIndex(0)->getCell('B'.$a)->setValueExplicit('000'.$s, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$a, 'RUI TAI INDUSTRY');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$a, 'B2-101TONGREN GARDEN PU M RD');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$a, 'WEN ZHOU');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$a, 'CN');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$a, '15857776935');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$a, '325000');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$a, '298147971');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$a, 'Mr Zheng');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$a, '1');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$a, "2");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$a, "3.20");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$a, "1");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$a, "");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$a, "");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$a, $street1);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$a, $street2);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.$a, $city);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.$a, $state);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y'.$a, $zip);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z'.$a, $tel);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA'.$a, $ebay_couny);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB'.$a, "TOP-SHOP");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD'.$a, '10');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AE'.$a, "1");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AF'.$a, "PCS");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AG'.$a, "CN");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AH'.$a, "PKG");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AI'.$a, '6');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AK'.$a, "01");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AL'.$a, "3");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AN'.$a, "USD");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AO'.$a, "KGS");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AP'.$a, "N");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AU'.$a, 'Y');
	
		$a++;
		$s++;
	}
	
$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:N500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:M500')->getAlignment()->setWrapText(true);
$objPHPExcel->setActiveSheetIndex(0)->getRowDimension('A1:AW1')->setRowHeight(45);
$objPHPExcel->setActiveSheetIndex(0)->getRowDimension('A2:AW500')->setRowHeight(12);



$titlename		= "fedex".date('Y-m-d').".xls";


$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename={$titlename}");
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;


