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



	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '发货方式');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '服务');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '库存编码');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '客户备注Custom');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', 'Remark');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'Tracking Number');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', 'Declared Name');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', 'Declared Value(USD)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', 'Quantity');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', 'Weight');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', 'Packing');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', 'Name');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', 'Address Line1');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', 'Address Line2');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1', 'Town/City');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1', 'State/Province');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q1', 'Zip/Postal Code');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R1', 'Country');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S1', 'Phone Number');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T1', 'Email');
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
	
	


	$countrys	= $_REQUEST['country'];

	if($countrys != '' && $countrys !='0'){		

		$sql	.= " and a.ebay_countryname='$countrys' order by ebay_account,recordnumber";	

	}else{	

		$sql	.= "  order by ebay_paidtime desc";	

	}

	
		

	$sql	= $dbcon->execute($sql);

	$sql	= $dbcon->getResultArray($sql);
	
	


	$a		= 2;

	

	for($i=0;$i<count($sql);$i++){

		

		$ordersn				= $sql[$i]['ebay_ordersn'];
		@$paidtime				= date('Y-m-d',$sql[$i]['ebay_paidtime']);
		$ebay_usermail			= $sql[$i]['ebay_usermail'];
		$ebay_userid			= $sql[$i]['ebay_userid'];
		$name					= $sql[$i]['ebay_username'];
		$name	  	= str_replace("&acute;","'",$name);
		$name  		= str_replace("&quot;","\"",$name);
		
		
	    $street1				= @$sql[$i]['ebay_street'];
	    $street2 				= @$sql[$i]['ebay_street1'];
	    $city 					= $sql[$i]['ebay_city'];
	    $state					= $sql[$i]['ebay_state'];
	    $countryname 			= $sql[$i]['ebay_countryname'];
	    $zip					= $sql[$i]['ebay_postcode'];
	    $tel					= $sql[$i]['ebay_phone'];
		$ebay_shipfee			= $sql[$i]['ebay_shipfee'];
		$ebay_note				= $sql[$i]['ebay_note'];
		$ebay_total				= @$sql[$i]['ebay_total'];
		$ebay_tracknumber		= @$sql[$i]['ebay_tracknumber'];
		$ebay_account			= @$sql[$i]['ebay_account'];
		$ebay_carrier			= @$sql[$i]['ebay_carrier'];

		$city	  	= str_replace("&acute;","'",$city);
		$city  		= str_replace("&quot;","\"",$city);
		
		$state	  		= str_replace("&acute;","'",$state);
		$state  		= str_replace("&quot;","\"",$state);
		

		$orderweight2			= @$sql[$i]['orderweight2'];

		$addressline		= $street1." ".$street2;
		$addressline	  	= str_replace("&acute;","'",$addressline);
		$addressline  		= str_replace("&quot;","\"",$addressline);
		
		
		$s0		= '';
		$s1		= '';
		
		if(strlen($addressline) >= 50){
			
			$s8		= substr($addressline,0,50);
			$start	= strrpos($s8," ");
			
			$s0		= substr($s8,0,$start);
			$s1		= substr($addressline,$start);
			
			
			
			
		
		}else{
		
			
			$s0		= $addressline;
			$s1		= '';
			
		
		
		}

		$sl				= "select * from ebay_account where ebay_account='$ebay_account'";

		$sl				= $dbcon->execute($sl);
		$sl				= $dbcon->getResultArray($sl);
		$appname		= $sl[0]['appname'];

		$sl				= "select * from ebay_orderdetail where ebay_ordersn='$ordersn'";

		$sl				= $dbcon->execute($sl);

		$sl				= $dbcon->getResultArray($sl);





		for($o=0;$o<count($sl);$o++){			

		

			$recordnumber			= $sl[$o]['recordnumber'];
			$sku1					= $sl[$o]['sku']?$sl[$o]['sku']:'AA';
			$sku					= $sl[$o]['ebay_itemtitle'];
			$amount					= $sl[$o]['ebay_amount'];
			$ebay_itemprice			= $sl[$o]['ebay_itemprice'];
			$ebay_itemid			= $sl[$o]['ebay_itemid'];
			
			$vv = "select goods_ywsbmc,goods_sbjz,goods_weight from ebay_goods where goods_sn='$sku1' and ebay_user='$user'";
			$vv = $dbcon->execute($vv);
			$vv	= $dbcon->getResultArray($vv);
			$sbmc = $vv[0]['goods_ywsbmc']?$vv[0]['goods_ywsbmc']:'Clothes';
			$sbjz = $vv[0]['goods_sbjz']?$vv[0]['goods_sbjz']:'10';
			$weight = $vv[0]['goods_weight']?$vv[0]['goods_weight']:'2';
			
			
			

			
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$a, '');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$a, $sku1);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$a, $sbmc);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$a, $sbjz);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$a, $orderweight2);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$a, $name);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$a, $amount);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$a, $street1);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$a, $street2);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$a, $city);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$a, $state);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$a, $zip);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$a, $countryname);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$a, '2*2*2');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$a, $ebay_tracknumber);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('S'.$a, $tel,PHPExcel_Cell_DataType::TYPE_STRING);
			$a++;


			

	

		}

	

	



}






$title		= "专线订单导入";

$titlename		= "专线订单导入".date('Y-m-d').".xls";



$objPHPExcel->getActiveSheet()->setTitle($title);



$objPHPExcel->setActiveSheetIndex(0);





// Redirect output to a client’s web browser (Excel5)

header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename={$titlename}");
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>

