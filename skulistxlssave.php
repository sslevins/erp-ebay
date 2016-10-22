<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="style/cskt.css" />
</head>
<body>
<?php
	
	
	include "include/config.php";


	$uploadfile = date("Y").date("m").date("d").rand(1,3009).".xls";
	
	

	

	if (move_uploaded_file($_FILES['upfile']['tmp_name'], 'images/'.$uploadfile)) {
	
		echo "<font color=BLUE>文件上传成功！</font><br>";
	
	}else {
   		
		echo "<font color=red> 文件上传失败！</font>  <a href='index.php'>返回</a><br>"; 	
	}
	echo $uploadfile;
	
	
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
/**取得一共有多少列*/


$c=2;





while(true){
	
	$aa	= 'A'.$c;
	$bb	= 'B'.$c;
	$cc	= 'C'.$c;
	$dd	= 'D'.$c;
	
	$sku	 			= str_rep(trim($currentSheet->getCell($aa)->getValue()));
	$namecn	 			= str_rep(trim($currentSheet->getCell($bb)->getValue()));
	
	$nameen	 			= str_rep(trim($currentSheet->getCell($cc)->getValue()));
	$account 			= str_rep(trim($currentSheet->getCell($dd)->getValue()));


	
	
	$sql		= "select id from ebay_skulist where nameen= '$nameen' and ebay_user='$user'";
	$sql		= $dbcon->execute($sql);
	$sql		= $dbcon->getResultArray($sql);
	if(count($sql) == 0){
		
		$sql	=  "insert into ebay_skulist(sku,namecn,nameen,account,ebay_user)values('$sku','$namecn','$nameen','$account','$user');";
	
	}else{
	
		$sql  =  "update ebay_skulist set ";
	
		if($namecn != '' ) 		 $sql .= " namecn='$namecn'";
		if($nameen != '' ) 		 $sql .= " , sku='$sku'";
		if($account != '' ) 		 $sql .= " , account='$account'";
		$sql .=  " where ebay_user='$user' and nameen='$nameen'";
				
	
	}

	
	
	if($sku == '') break;
	
	$c++;
	

	if($dbcon->execute($sql)){
	
	
					$status	= " -[<font color='#33CC33'>物品编号：$nameen 导入成功</font>]";

	}else{
	

					$status = " -[<font color='#FF0000'>物品编号：$nameen 导入失败</font>]";
					
				

	}
	echo $status.'<br>';
	

}
	
	echo "<script>alert('sku导入成功')</script>";
	

?>






