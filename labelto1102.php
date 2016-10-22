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

$filePath='4PX订单模板.xls';
//$PHPExcel = new PHPExcel();

	$ertj		= "";

	$orders		= explode(",",$_REQUEST['ordersn']);

	for($g=0;$g<count($orders);$g++){

		$sn 	=  $orders[$g];

		if($sn != ""){
					$ertj	.= " a.ebay_id='$sn' or";

		}

			

	}

	$ertj			 = substr($ertj,0,strlen($ertj)-3);
	$ostatus	= $_REQUEST['ostatus'];
	if($ertj == ""){
	$sql	= "select * from ebay_order as a where  a.ebay_user='$user' and a.ebay_status = '$ostatus' and a.ebay_combine!='1' ";	

	}else{	

	$sql	= "select * from ebay_order as a where ($ertj) and ebay_user='$user' and a.ebay_combine!='1' order by  a.ebay_countryname";	

	}	

	$sql		= $dbcon->execute($sql);
	$sql		= $dbcon->getResultArray($sql);
	$a			= 2;	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('A1', '仓库代码', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('B1', '参考编号', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('C1', '派送方式', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('D1', '保险类型', PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('E1', '收件人国家', PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('F1', '收件人姓名', PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('G1', '街道1', PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('H1', '街道2', PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('I1', '街道3', PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('J1', '收件人公司', PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('K1', '城市'	, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('L1', '州', PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('M1', '邮政编码', PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('N1', '收件人Email', PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('O1', '收件人电话', PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('P1', 'eBay交易号', PHPExcel_Cell_DataType::TYPE_STRING);
	
	for($i=0;$i<count($sql);$i++){
		

		$ordersn		= $sql[$i]['ebay_ordersn'];
		$ebay_usermail	= $sql[$i]['ebay_usermail'];
		//$ebay_userid	= $sql[$i]['ebay_userid'];	
		$name			= $sql[$i]['ebay_username'];
		$name	 	 	= str_replace("&acute;","'",$name);
		$name  			= str_replace("&quot;","\"",$name);
		
		
	    $street1			= @$sql[$i]['ebay_street'];
	    $street2 			= @$sql[$i]['ebay_street1'];
	    $city 				= $sql[$i]['ebay_city'];
	    $state				= $sql[$i]['ebay_state'];
	    $ebay_couny				= $sql[$i]['ebay_couny'];
	    $countryname 		= $sql[$i]['ebay_countryname'];
	    $recordnumber		= $sql[$i]['recordnumber'];
	    $zip				= $sql[$i]['ebay_postcode'];

	    $tel				= $sql[$i]['ebay_phone'];
		$ebay_ptid			=$sql[$i]['ebay_ptid'];
		$ebay_account		= $sql[$i]['ebay_account'];
		
		
		
		
			
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('B'.$a, $ebay_account, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$a, $ebay_couny	, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('F'.$a, $name, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('G'.$a, $street1, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('H'.$a, $street2, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('K'.$a, $city	, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('L'.$a, $state, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('M'.$a, $zip, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('N'.$a, $ebay_usermail, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('O'.$a, $tel, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('P'.$a, $ebay_ptid, PHPExcel_Cell_DataType::TYPE_STRING);
		
		$vv="select sku,ebay_amount from ebay_orderdetail where ebay_user='$user' and ebay_ordersn='$ordersn'";
		//echo $vv;
		$vv		= $dbcon->execute($vv);
		$vv		= $dbcon->getResultArray($vv);
		$tarr=array('Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS',
				'AT','AU','AV','AW','AX','AY','AZ');
		$b=0;
		for($j=0,$jlen=count($vv);$j<$jlen;$j++){
			$c=$j+1;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit($tarr[$b].'1', '产品编号'.$c, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit($tarr[$b+1].'1', '数量'.$c, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit($tarr[$b].$a, $vv[$j]['sku'], PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit($tarr[$b+1].$a, $vv[$j]['ebay_amount'], PHPExcel_Cell_DataType::TYPE_STRING);
			$b+=2;
		}
		
		
		
		$a++;
	}

	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(15);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(15);
	
	
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(35.5);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(10);
	
	
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(15);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(15);
	
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('P')->setWidth(25);
$title			= "4PX订单".date('Y-m-d');
$titlename		= "4PX订单".date('Y-m-d').".xls";
//$objPHPExcel->getActiveSheet()->setTitle($title);

$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);


header('Content-Type: application/vnd.ms-excel');

header("Content-Disposition: attachment;filename={$titlename}");

header('Cache-Control: max-age=0');

header("Content-Type:text/html;charset=utf-8");

//$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:F500')->getAlignment()->setWrapText(true);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('B1:B500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('D1:D500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('F1:F500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

$objWriter->save('php://output');

exit;





