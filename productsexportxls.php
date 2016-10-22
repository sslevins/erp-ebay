<?php
include "include/dbconnect.php";	
	date_default_timezone_set ("Asia/Chongqing");	
set_time_limit(0);
$dbcon	= new DBClass();
error_reporting(0);
@session_start();
$user	= $_SESSION['user'];
require_once 'Classes/PHPExcel.php';
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
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA1', 'BtoB编号');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB1', '产品开发人员');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC1', '产品包装人员');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD1', '产品状态');
	
	
	
	$sql	= "select * from ebay_goods where ebay_user='$user' ";
	
	
	
	
				$goodscategory	= $_REQUEST['goodscategory'];
				/* 检查是否有子类 */
				$ss				= "select * from ebay_goodscategory where pid ='$goodscategory' ";
				$ss				= $dbcon->execute($ss);
				$ss				= $dbcon->getResultArray($ss);
				if($goodscategory!="" && $goodscategory !="-1"){
					if(count($ss) == 0){
						 $sql	.= " and goods_category='$goodscategory' ";
					}else{
						$strline		= '';
						for($i=0;$i<count($ss);$i++){
							$pid		= $ss[$i]['id'];
							$strline	.= " goods_category='$pid' or ";
						}
						$strline		= substr($strline,0,strlen($strline)-3);
						 $sql	.= " and ( $strline )";
					}
				}
				
				
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
			$jj	= 'J'.$c;
			$kk	= 'K'.$c;
			$ll	= 'L'.$c;
			$mm	= 'M'.$c;
			$nn	= 'N'.$c;
			$oo	= 'O'.$c;
			$pp	= 'P'.$c;
			$qq	= 'Q'.$c;
			$rr	= 'R'.$c;
			$sss	= 'S'.$c;
			$tt	= 'T'.$c;
			$uu	= 'U'.$c;
			$vv	= 'V'.$c;
			$ww	= 'W'.$c;
			$xx	= 'X'.$c;
			$yy	= 'Y'.$c;
			$zz	= 'Z'.$c;
			$aa1= 'AA'.$c;
			$ab1= 'AB'.$c;
			$ac1= 'AC'.$c;
			$ad1= 'AD'.$c;
			
			
			$goods_sn				= $sql[$i]['goods_sn'];	
			$goods_name				= $sql[$i]['goods_name'];
			$goods_price			= $sql[$i]['goods_price'];
			$goods_unit				= $sql[$i]['goods_unit'];
			$goods_location			= @$sql[$i]['goods_location'];
			$warehousesx 			= @$sql[$i]['warehousesx'];
			$warehousexx 			= $sql[$i]['warehousexx'];
			$goods_weight	 		= $sql[$i]['goods_weight'];
			$goods_note				= $sql[$i]['goods_note'];
			$goods_attribute		= $sql[$i]['goods_attribute'];
			$goods_ywsbmc			= $sql[$i]['goods_ywsbmc'];
			$goods_hgbm				= $sql[$i]['goods_hgbm'];
			$goods_zysbmc			= $sql[$i]['goods_zysbmc'];
			$goods_sbjz				= $sql[$i]['goods_sbjz'];
			$goods_register			= $sql[$i]['goods_register'];
			$goods_length			= $sql[$i]['goods_length'];
			$goods_width			= $sql[$i]['goods_width'];
			$goods_height			= $sql[$i]['goods_height'];
			$goods_cost				= $sql[$i]['goods_cost'];
			
			$factory				= $sql[$i]['factory'];
			$btb_number				= $sql[$i]['BtoBnumber'];
			
			$ebay_packingmaterial	= $sql[$i]['ebay_packingmaterial'];
			$capacity				= $sql[$i]['capacity'];
			
			$salesuser							= $sql[$i]['salesuser'];
			$cguser								= $sql[$i]['cguser'];
			$kfuser								= $sql[$i]['kfuser'];
			$bzuser								= $sql[$i]['bzuser'];
			$goods_status								= $sql[$i]['isuse'];
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($vv, $ebay_packingmaterial);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($tt, $salesuser);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($uu, $cguser);
			
			
			$objPHPExcel->setActiveSheetIndex(0)->getCell($aa)->setValueExplicit($goods_sn, PHPExcel_Cell_DataType::TYPE_STRING);
			//$objPHPExcel->setActiveSheetIndex(0)->setValueExplicit($aa, $goods_sn);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($bb, $goods_name);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cc, $goods_cost);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($dd, $goods_price);
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($ee, $goods_unit);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($ff, $goods_location);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($gg, $goods_weight);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($hh, $goods_note);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($ii, $goods_attribute);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($jj, $goods_ywsbmc);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($kk, $goods_hgbm);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($ll, $goods_zysbmc);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($mm, $goods_sbjz);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($nn, $goods_length);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($oo, $goods_width);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($pp, $goods_height);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($ww, $capacity);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($aa1, $btb_number);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($ab1, $kfuser);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($ac1, $bzuser);
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($ad1, $goods_status);
			
			$goods_category			= $sql[$i]['goods_category'];
			
			$ss			= "select * from ebay_goodscategory where id='$goods_category'";		
			$ss			= $dbcon->execute($ss);
			$ss			= $dbcon->getResultArray($ss);
			$category0	= $ss[0]['name'];
			$pid		= $ss[0]['pid'];
			
			$ss			= "select * from ebay_goodscategory where id='$pid'";		
			$ss			= $dbcon->execute($ss);
			$ss			= $dbcon->getResultArray($ss);
			$category1	= $ss[0]['name'];
			
			$storeid			= $sql[$i]['storeid'];
			$ss			= "select * from ebay_store where id='$storeid'";
			$ss			= $dbcon->execute($ss);
			$ss			= $dbcon->getResultArray($ss);
			$store_name	= $ss[0]['store_name'];
			
			$ss				= "select * from ebay_partner where id='$factory'";
			$ss				= $dbcon->execute($ss);
			$ss				= $dbcon->getResultArray($ss);
			$company_name	= $ss[0]['company_name'];

	
			$objPHPExcel->setActiveSheetIndex(0)->getCell($qq)->setValueExplicit($category0, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell($rr)->setValueExplicit($category1, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($xx, $company_name);
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($sss, $store_name);
				
				
				
			$c++;
			
			
				
	
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
