<?php
@session_start();
error_reporting(0);

$user	= $_SESSION['user'];

include "include/dbconnect.php";	
date_default_timezone_set ("Asia/Chongqing");	
$dbcon	= new DBClass();
require_once 'Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();
$ebayaccounts00		= $_SESSION['ebayaccounts'];
$ebayaccounts00 	= explode(",",$ebayaccounts00);
$ebayacc2		= '';
for($i=0;$i<count($ebayaccounts00);$i++){
	$ebayacc2	.= "account='".$ebayaccounts00[$i]."' or ";	
}
$ebayacc2    = substr($ebayacc2,0,strlen($ebayacc2)-3);
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'itemnumber');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'ebay账号');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '好评');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '中评');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', '差评');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', 'SKU');
	$account			= $_REQUEST['account'];
	$itemnumber		= $_REQUEST['itemnumber'];
	$strat			= $_REQUEST['strat'];
	$end			= $_REQUEST['end'];
	$sql			= "select * from ebay_feedback where 1";
		  
		 
		  
		  if($account != '') 		 $sql .= " and account='$account' ";
		  if($itemnumber != '')	 $sql .= " and ItemID='$itemnumber' ";
		  //if($strat && $end)  $sql .= " and feedbacktime>='".strtotime($strat.' 00:00:00')."' and feedbacktime>='".strtotime($end.' 23:59:59')."'";
		  
		  $sql .= ' and ebay_user=\''.$user.'\' and ('.$ebayacc2.') group by ItemID,account';
		  //echo $sql;
		  $sql			= $dbcon->execute($sql);
		  $sql			= $dbcon->getResultArray($sql);
		  $a = 2;
		  for($i=0;$i<count($sql);$i++){
		  	
			$ItemID	= $sql[$i]['ItemID'];
			$account= $sql[$i]['account'];
			$vv	= "select count(*) as cc from ebay_feedback where ItemID='$ItemID' and account='$account' and CommentType='Positive' and ebay_user='$user'";
			if($strat && $end)  $vv .= " and feedbacktime>='".strtotime($strat.' 00:00:00')."' and feedbacktime<='".strtotime($end.' 23:59:59')."'";
			//echo $vv;
			$vv			= $dbcon->execute($vv);
			$vv			= $dbcon->getResultArray($vv);
			$Positivenumber = $vv[0]['cc']?$vv[0]['cc']:0;
			$vv	= "select count(*) as cc from ebay_feedback where ItemID='$ItemID' and account='$account' and CommentType='Neutral' and ebay_user='$user'";
			if($strat && $end)  $vv .= " and feedbacktime>='".strtotime($strat.' 00:00:00')."' and feedbacktime<='".strtotime($end.' 23:59:59')."'";
			$vv			= $dbcon->execute($vv);
			$vv			= $dbcon->getResultArray($vv);
			$Neutralnumber = $vv[0]['cc']?$vv[0]['cc']:0;
			$vv	= "select count(*) as cc from ebay_feedback where ItemID='$ItemID' and account='$account' and CommentType='Negative' and ebay_user='$user'";
			if($strat && $end)  $vv .= " and feedbacktime>='".strtotime($strat.' 00:00:00')."' and feedbacktime<='".strtotime($end.' 23:59:59')."'";
			$vv			= $dbcon->execute($vv);
			$vv			= $dbcon->getResultArray($vv);
			$Negativenumber = $vv[0]['cc']?$vv[0]['cc']:0;
			
			
			
			$vv = "select sku from ebay_orderdetail where ebay_itemid ='$ItemID'";
			$vv			= $dbcon->execute($vv);
			$vv			= $dbcon->getResultArray($vv);
			$sku		= $vv[0]['sku'];
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('A'.$a, $ItemID, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('B'.$a, $account, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('C'.$a, $Positivenumber, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('D'.$a, $Neutralnumber, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$a, $Negativenumber, PHPExcel_Cell_DataType::TYPE_STRING);	
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('F'.$a, $sku, PHPExcel_Cell_DataType::TYPE_STRING);	
			
			
			$a++;
			
					

		
		


		
			
	
	

}
$objPHPExcel->getActiveSheet(0)->getStyle('A1:N500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(20);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(25);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(20);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(20);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(22);


$objPHPExcel->getActiveSheet(0)->getStyle('A1:M500')->getAlignment()->setWrapText(true);




$title		= "feedbackitem".date('Y-m-d');
$titlename		= "feedbackitem".date('Y-m-d').".xls";

$objPHPExcel->getActiveSheet()->setTitle($title);

$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename={$titlename}");
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;


