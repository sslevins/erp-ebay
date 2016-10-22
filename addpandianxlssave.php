<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="style/cskt.css" />
</head>
<body>
<?php
	
	
	include "include/config.php";
	$store_id = $_REQUEST['store_id'];

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
	
	
	$goods_sn	 			= str_rep(trim($currentSheet->getCell($aa)->getValue()));
	$goods_count	 			= str_rep(trim($currentSheet->getCell($bb)->getValue()));
	
	if($goods_sn == '') break;
	if($goods_count == '') $goods_count = 0;
	
	$sql		= "select goods_name,goods_unit from ebay_goods where goods_sn= '$goods_sn' and ebay_user='$user'";
	$sql		= $dbcon->execute($sql);
	$sql		= $dbcon->getResultArray($sql);
	$goods_count1 = 0;
		if(count($sql>0)){
			$goods_name = $sql[0]['goods_name'];
			$unit 		= $sql[0]['goods_unit'];
			$vv = "select goods_count from ebay_onhandle where goods_sn= '$goods_sn' and store_id='$store_id'";
			$vv		= $dbcon->execute($vv);
			$vv		= $dbcon->getResultArray($vv);
			$goods_count1 = $vv[0]['goods_count'];
			$stockused				= stockused($goods_sn,$store_id);
		}	
	$addsql		= "insert into ebay_pandiandetail(goods_sn,goods_name,goods_unit,goods_count,status,pandian_count,user,wait_count) values('$goods_sn','$goods_name','$unit','$goods_count1','0','$goods_count','$user','$stockused')";

	
	
	
	
	$c++;
	echo $addsql.'<br>';

	if($dbcon->execute($addsql)){
	
	
				//	$status	= " -[<font color='#33CC33'>物品编号：$goods_sn 导入成功,重量是:".$goods_weight."</font>]";

	}else{
	

					$status = " -[<font color='#FF0000'>物品编号：$goods_sn 导入失败</font>]";
					
				

	}
	echo $status.'<br>';
	

}
	
	echo "<script>alert('导入完成')</script>";
	

?>






