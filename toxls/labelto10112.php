<?php
include "../include/dbconnect.php";	
	date_default_timezone_set ("Asia/Chongqing");	
set_time_limit(0);
$dbcon	= new DBClass();
error_reporting(0);
@session_start();
$user	= $_SESSION['user'];
require_once '../Classes/PHPExcel.php';
$cpower	= explode(",",$_SESSION['power']);

	$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");

	$c		= 2;
												 


	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '货品编号');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '货品名称');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '货品成本');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '货品价格');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', '货品单位');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', '货位号');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', '产品重量');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', '产品备注');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', '产品性质');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', '英文申报名称');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', '海关编码');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', '中文申报名称');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', '申报价值USD');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', '产品长');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1', '产品宽');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1', '产品高');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q1', '货品类别');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R1', '父类');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S1', '对应出库仓库');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T1', '销售人员');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U1', '采购人员');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V1', '包装材料');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W1', '包装容量');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X1', '供应商');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y1', 'BtoB编号');
	
	
	
	
	$sql	= "select b.sku from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn = b.ebay_ordersn where ebay_status != '2' and a.ebay_user='$user' and a.ebay_combine!='1' group by a.ebay_id order by   b.sku desc  ";	
	
	
	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);
	$c = 2;
	
	
	for($i=0;$i<count($sql);$i++){
		
			
			$aa	= 'A'.$c;
			
			
			
			$sku1			= $sql[$i]['sku'];
			$sq3	= "select * from ebay_goods where goods_sn='$sku1' and ebay_user='$user'";
			$sq3			= $dbcon->execute($sq3);
			$sq3			= $dbcon->getResultArray($sq3);
			if(count($sq3) >=1 ){
			
			}else{
			
			
				
				$rr			= "select * from ebay_productscombine where ebay_user='$user' and goods_sn='$sku1'";
				$rr			= $dbcon->execute($rr);
				$rr 	 	= $dbcon->getResultArray($rr);
				
				if(count($rr) == 0 ){
				
						$objPHPExcel->setActiveSheetIndex(0)->getCell($aa)->setValueExplicit($sku1, PHPExcel_Cell_DataType::TYPE_STRING);
						$c++;
				
				
				}else{
				
						
						$goods_sncombine	= $rr[0]['goods_sncombine'];			
						$goods_sncombine    = explode(',',$goods_sncombine);				
						for($e=0;$e<count($goods_sncombine);$e++){
													$pline			= explode('*',$goods_sncombine[$e]);
													$goods_sn		= $pline[0];
													$goddscount     = $pline[1] * $ebay_amount;
													$ee			= "SELECT goods_location FROM ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
													$ee			= $dbcon->execute($ee);
													$ee 	 	= $dbcon->getResultArray($ee);
													
													
													if(count($ee) == 0){
													
													
													$objPHPExcel->setActiveSheetIndex(0)->getCell($aa)->setValueExplicit($sku1, PHPExcel_Cell_DataType::TYPE_STRING);
													$c++;
													
													}
						}
				
				
				
				
				}
				
				
				
				
									
									
			}
	}
	
	


	
	$objPHPExcel->getActiveSheet(0)->getStyle('A1:E500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$objPHPExcel->getActiveSheet(0)->getStyle('A1:Z500')->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet(0)->getStyle('A1:N500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


	$title		= "Products-".date('Y')."-".date('m')."-".date('d').".xls";
	
	
	$objPHPExcel->getActiveSheet()->setTitle($title);
	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	// Redirect output to a client’s web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
	header("Content-Disposition: attachment;filename={$title}");
	header('Cache-Control: max-age=0');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;

?>
