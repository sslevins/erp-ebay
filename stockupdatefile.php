<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="style/cskt.css" />
</head>
<body>
<?php
	
	
	include "include/config.php";



	
	$uploadfile		= $_REQUEST['filename'];
	
	
	$fileName = 'images/'.$uploadfile;	
	$filePath = $fileName;

	require_once 'Classes/PHPExcel.php';





$PHPExcel = new PHPExcel(); 
$PHPReader = new PHPExcel_Reader_Excel2007();    
if(!$PHPReader->canRead($filePath)){      
$PHPReader = new PHPExcel_Reader_Excel5(); 
if(!$PHPReader->canRead($filePath)){      
echo 'no Excel';
return ;
}
}
$PHPExcel = $PHPReader->load($filePath);
$currentSheet = $PHPExcel->getSheet(0);
/**ȡһж*/


$c=2;


$runarry	= array();
$str		= "";


while(true){
	
	$aa	= 'A'.$c;
	$bb	= 'B'.$c;
	$cc	= 'C'.$c;
	$dd	= 'D'.$c;
	$ee	= 'E'.$c;
	$ff	= 'F'.$c;
	$gg	= 'G'.$c;
	$hh	= 'H'.$c;


	
		
	
		
	$goods_sn	 			= $currentSheet->getCell($aa)->getValue();
	$store_sn	 			= $currentSheet->getCell($bb)->getValue();
	$goods_sn1	 			= $currentSheet->getCell($cc)->getValue();
	$goods_count 			= $currentSheet->getCell($dd)->getValue();
	$goods_sx	 			= $currentSheet->getCell($ee)->getValue();
	$goods_xx	 			= $currentSheet->getCell($ff)->getValue();
	$goods_packlist	 		= $currentSheet->getCell($gg)->getValue();
	$goods_delivery	 		= $currentSheet->getCell($hh)->getValue();
	$line					= $goods_sn."   ".$store_sn."   ".$goods_sn1."   ".$goods_count."   ".$goods_sx."   ".$goods_xx."   ".$goods_packlist."   ".$goods_delivery;
	
	
	
	
	
	
	
	
	
	if($goods_sn == ''){

		break;
		
	}
	
	$c++;
	
}



	


?>
