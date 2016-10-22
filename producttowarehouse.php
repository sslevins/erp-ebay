<?php
include "include/dbconnect.php";	
	date_default_timezone_set ("Asia/Chongqing");	

$dbcon	= new DBClass();
error_reporting(0);
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

	$c		= 2;
												 


	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '货品编号');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '对应仓库编码');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '实际库存数量');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '库存上限');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', '库存下限');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', '库存报警天数 ');

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', '采购天数 ');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', '物品名称 ');
	
	$storeid	= $_REQUEST['storeid'];
	$factory    = $_REQUEST['factory'];
	$ss		= "select * from ebay_store where id='$storeid'";
	$ss		= $dbcon->execute($ss);
	$ss		= $dbcon->getResultArray($ss);
	$storesn= $ss[0]['store_sn'];
	
	
	
	
	
	$sql	= "select a.goods_sn as a,a.goods_name as bb,b.* from ebay_goods as a join ebay_onhandle as b on a.goods_id = b.goods_id where a.ebay_user='$user' and b.store_id='$storeid'  and a.goods_sn = b.goods_sn";
	if($factory){
		$sql .= " and a.factory='$factory' ";
	}

	$sql	.= " group by b.goods_id";
	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);

	$r		= 0;
	$reg	= 1;
	$combine	= 0;
	
	for($i=0;$i<count($sql);$i++){

				
			
			$aa	= 'A'.$c;
			$bb	= 'B'.$c;
			$cc	= 'C'.$c;
			$dd	= 'D'.$c;
			$ee	= 'E'.$c;
			$ff	= 'F'.$c;
			$gg	= 'G'.$c;
			$hh	= 'H'.$c;
			$ii	= 'I'.$c;
			
			$goods_sn				= $sql[$i]['a'];
			$goods_sn1				= $sql[$i]['goods_sn'];
			$goods_name				= $sql[$i]['bb'];
			
			$goods_sx				= $sql[$i]['goods_sx'];
			$goods_xx				= $sql[$i]['goods_xx'];
			$goods_packlist			= $sql[$i]['goods_packlist'];
			$goods_delivery			= $sql[$i]['goods_delivery'];
			$goods_count			= $sql[$i]['goods_count'];
			$purchasedays			= $sql[$i]['purchasedays'];
			$goods_days			= $sql[$i]['goods_days'];
			
			$objPHPExcel->setActiveSheetIndex(0)->getCell('A'.$c)->setValueExplicit($goods_sn, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('B'.$c)->setValueExplicit($storesn, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('C'.$c)->setValueExplicit($goods_count, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('D'.$c)->setValueExplicit($goods_sx, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('E'.$c)->setValueExplicit($goods_xx, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('F'.$c)->setValueExplicit($goods_days, PHPExcel_Cell_DataType::TYPE_STRING);

			$objPHPExcel->setActiveSheetIndex(0)->getCell('G'.$c)->setValueExplicit($purchasedays, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('H'.$c)->setValueExplicit($goods_name, PHPExcel_Cell_DataType::TYPE_STRING);
			$c++;
			
			
				
	
	}



	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(18);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(22);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(22);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(22);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(22);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(22);
	


	$title		= "ProductsStock-".date('Y')."-".date('m')."-".date('d').".xls";
	
	
	$objPHPExcel->getActiveSheet()->setTitle($title);
	$objPHPExcel->setActiveSheetIndex(0);
	// Redirect output to a client’s web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
	header("Content-Disposition: attachment;filename={$title}");
	header('Cache-Control: max-age=0');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;

?>
