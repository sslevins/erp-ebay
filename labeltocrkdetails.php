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
							 
							 
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '日期');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '账号名');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '产品编号');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '产品名称');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', '数量');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', '币种');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', '售价');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', '物品成本');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', '运费');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', '总价');
	

	$warehouse			= $_REQUEST['warehouse'];
	$keys				= $_REQUEST['keys'];
	$account			= $_REQUEST['acc'];
	$start				= $_REQUEST['start'];
	$end				= $_REQUEST['end'];
	$isskusort				= $_REQUEST['isskusort'];
	$goodssort					= $_REQUEST['goodssort'];
	$sortwarehouse				= $_REQUEST['sortwarehouse'];
	$ordertype				= $_REQUEST['ordertype'];
	
	if($ordertype == '') $ordertype ='1';
	
	
	
	$sql = "select * from  ebay_iostore as a join ebay_iostoredetail as b on a.io_ordersn = b.io_ordersn where a.ebay_user='$user' and a.type='$ordertype' and a.io_status='1'  ";	
				
				if($isskusort =='1'){
				$sql = "select a.io_audittime,a.ebay_account,sum(b.goods_count) as goods_count,goods_sn,goods_name,sum(goods_cost) as goods_cost,transactioncurrncy  from  ebay_iostore as a join ebay_iostoredetail as b on a.io_ordersn = b.io_ordersn where a.ebay_user='$user' and a.type='$ordertype' and a.io_status='1'  ";	
				}
				if($warehouse > 0){
					$sql	.= " and io_warehouse ='$warehouse'";
				}
				
				if($account != '') $sql.= " and ebay_account ='$account' ";
				if($keys != '') $sql.= " and b.goods_sn ='$keys' ";
				
				
				if($start != '' && $end != '' ){
					
					$start		= strtotime($start.' 00:00:00');
					$end		= strtotime($end.' 23:59:59');
					$sql		.= " and (io_audittime >= $start and io_audittime	<= $end) ";
				}

				if($isskusort !='1'){
				$sql	.= " order by a.io_audittime desc ";
				}else{
					
					$sql	.= " group by b.goods_sn";
				
				}




		
				$sql	= $dbcon->execute($sql);
				$sql	= $dbcon->getResultArray($sql);
	$a		= 2;
	
	for($i=0;$i<count($sql);$i++){
			
			
			
					$io_audittime			= date('Y-m-d H:i',$sql[$i]['io_audittime']);
					$goods_sn				= $sql[$i]['goods_sn'];
					
					
	
					
					
					$goods_count			= $sql[$i]['goods_count'];
					$ebay_account			= $sql[$i]['ebay_account'];
					$goods_name				= $sql[$i]['goods_name'];
					$vvcost ="select goods_cost from ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
					$vvcost		= $dbcon->execute($vvcost);
					$vvcost		= $dbcon->getResultArray($vvcost);
					$cost		= $vvcost[0]['goods_cost'];
					$goods_cost						= $sql[$i]['goods_cost'];
					$transactioncurrncy				= $sql[$i]['transactioncurrncy'];
					$sourceorder					= $sql[$i]['sourceorder'];
					
					
					$vvshipfee					= "select b.shipingfee from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn = b.ebay_ordersn and a.ebay_id='$sourceorder' and b.sku='$goods_sn' and b.ebay_amount ='$goods_count' ";

					
					$vvshipfee		= $dbcon->execute($vvshipfee);
					$vvshipfee		= $dbcon->getResultArray($vvshipfee);
					$vvshipfee		= $vvshipfee[0]['ebay_shipfee']?$vvshipfee[0]['ebay_shipfee']:0;
					
					
					
		
		
		
		
		
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('A'.$a, $io_audittime, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('B'.$a, $ebay_account, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('C'.$a, $goods_sn, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('D'.$a, $goods_name, PHPExcel_Cell_DataType::TYPE_STRING);

		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$a, $goods_count, PHPExcel_Cell_DataType::TYPE_STRING);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('F'.$a, $transactioncurrncy, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('G'.$a, $goods_cost, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('H'.$a, $cost, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('I'.$a, $vvshipfee, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('J'.$a, $vvshipfee + ($goods_count * $goods_cost), PHPExcel_Cell_DataType::TYPE_STRING);



		$a++;
			
	
	

}
$objPHPExcel->getActiveSheet(0)->getStyle('A1:N500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(10);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(25);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(15);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(15);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(15);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(30);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(15);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(25);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(20);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth(25);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setWidth(45);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setWidth(15);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('M')->setWidth(15);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('K')->setWidth(30);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('L')->setWidth(55);

$objPHPExcel->getActiveSheet(0)->getStyle('A1:M500')->getAlignment()->setWrapText(true);




$title		= "Files_FHQD".date('Y-m-d');
$titlename		= "Files_FHQD".date('Y-m-d').".xls";

$objPHPExcel->getActiveSheet()->setTitle($title);

$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename={$titlename}");
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;


