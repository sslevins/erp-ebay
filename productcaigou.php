<?php
@session_start();
$user	= $_SESSION['user'];
include "include/dbconnect.php";	
date_default_timezone_set ("Asia/Chongqing");	
error_reporting(0);

	
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
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'SKU');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '产品图片');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '产品名称');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '产品成本');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', '采购数量');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', '供应商');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', '供应商代码');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', '所属城市');
	

	
	     
	
				$sql		= "SELECT a.goods_pic,a.goods_id as bb,a.goods_sn as asn,a.goods_name as aname,a.goods_price,a.goods_cost,a.goods_unit,a.factory,b.* FROM ebay_goods AS a
JOIN ebay_onhandle AS b ON a.goods_id = b.goods_id where b.goods_count not BETWEEN goods_xx AND goods_sx and a.ebay_user='$user' ";


				$keys		= $_REQUEST['keys'];
				if($keys != ""){
				$sql	.= " and(a.goods_name like '%$keys%' or a.goods_sn like '%$keys%' or a.goods_unit like '%$keys%')";
				}
				
								
				
				$a = 2;
				
				
				$sql		= $dbcon->execute($sql);
				$sql		= $dbcon->getResultArray($sql);
				for($i=0;$i<count($sql);$i++){					
		
					$goods_id		= $sql[$i]['goods_id'];
					$goods_sn		= $sql[$i]['asn'];
					$goods_name		= $sql[$i]['aname'];
					$goods_price	= $sql[$i]['goods_price']?$sql[$i]['goods_price']:0;
					$goods_cost		= $sql[$i]['goods_cost']?$sql[$i]['goods_cost']:0;
					$pic			= 'images/'.$sql[$i]['goods_pic'];
					$goods_count	= $sql[$i]['goods_count']?$sql[$i]['goods_count']:0;
					$goods_unit		= $sql[$i]['goods_unit'];
					$goods_location	= $sql[$i]['goods_location'];
					$warehousesx	= $sql[$i]['goods_sx'];
					$warehousexx	= $sql[$i]['goods_xx'];
					$goods_location	= $sql[$i]['goods_location'];
					$goods_note	= $sql[$i]['goods_note'];
					$factory		= $sql[$i]['factory'];
					$ss		= "select * from ebay_partner where id='$factory'";
					$sl				= abs($warehousesx - $goods_count);
					
					
					
					$ss		= $dbcon->execute($ss);
					$ss		= $dbcon->getResultArray($ss);
	
					
					$company_name	= $ss[0]['company_name'];
					$city			= $ss[0]['city'];
					$code			= $ss[0]['code'];
					
				
					
						
			
					if($goods_count>$warehousesx) $dstr	= "库存数量过多".$goods_count." sx:".$warehousesx." xx:".$warehousexx;
				//	if($goods_count<$warehousesx) $dstr	= "需要紧急备货".$goods_count." sx:".$warehousesx." xx:".$warehousexx;
					
					
					if($goods_count<$warehousesx){
						
					$objPHPExcel->setActiveSheetIndex(0)->getCell('A'.$a)->setValueExplicit($goods_sn, PHPExcel_Cell_DataType::TYPE_STRING);


						
						if(filesize($pic)/1024 <=0 || $sql[$i]['goods_pic'] == ''){			
						$pic	= "failure.jpg";				
						}
				
						
			
	$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setName('PHPExcel logo');
			$objDrawing->setDescription('PHPExcel logo');
			$objDrawing->setPath($pic);
			$objDrawing->setHeight(66);
			$objDrawing->setCoordinates('B'.$a);
			$objDrawing->setOffsetX($xlocation);
			$objDrawing->setRotation(25);
            $objDrawing->getShadow()->setVisible(true);
            $objDrawing->getShadow()->setDirection(45);
			$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
			
			
			
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$a, "".$goods_name);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$a, "".$goods_cost);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$a, "".$sl);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$a, "".$company_name);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$a, "".$code);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$a, "".$city);
						
						$objPHPExcel->setActiveSheetIndex(0)->getRowDimension($a)->setRowHeight(50);
						
						$a++;
					
					
					}
					
					
					
					
			
			

	

}
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(20);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(25);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(35);	

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(10);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(10);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(30);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(25);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(10);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth(25);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setWidth(45);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setWidth(15);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('M')->setWidth(15);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('N')->setWidth(30);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('K')->setWidth(45);




$title		= "Caigoudan".date('Y-m-d');
$titlename		= "Caigoudan".date('Y-m-d').".xls";

$objPHPExcel->getActiveSheet()->setTitle($title);

$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename={$titlename}");
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;


