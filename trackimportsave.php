<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="style/cskt.css" />
</head>
<body>
<?php
	
	
	include "include/config.php";
	
	
	echo "更新成功";
	
	
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
	
	
	$recordnumber	 			= str_rep(trim($currentSheet->getCell($aa)->getValue())); //订单号
	
	if($recordnumber != ''){
	
	$ebay_tracknumber				= str_rep(trim($currentSheet->getCell($bb)->getValue()));
	$ebay_carrier				= str_rep(trim($currentSheet->getCell($cc)->getValue()));   //买家选择物流
	
	
	if($ebay_carrier   == 'HK包挂号'){
	$ebay_carrier		= '香港小包挂号';
	}
	
	if($ebay_carrier   == 'UPS'){
	$ebay_carrier		= 'UPS';
	}
	
	if($ebay_carrier   == 'DHL'){
	$ebay_carrier		= 'DHL';
	}
	if($ebay_carrier   == 'FEDEX'){
	$ebay_carrier		= 'FEDEX';
	}
	
	if($ebay_carrier   == 'TNT'){
	$ebay_carrier		= 'TNT';
	}
	
	if($ebay_carrier   == 'EMS'){
	$ebay_carrier		= 'EMS';
	}
	
	if($ebay_carrier   == 'CN包挂号'){
	$ebay_carrier		= '中国邮政挂号';
	}
	
	
	
		$sql					= "update ebay_order set ebay_carrier='".$ebay_carrier."',ebay_tracknumber='".$ebay_tracknumber."' where ebay_id='".$recordnumber."'";

		if($dbcon->execute($sql)){
			echo '<br><font color=BLUE>'.$recordnumber.' 导入成功。</font>';
		}else{
			echo '<br><font color=RED>'.$recordnumber.' 导入失败。</font>';
		}			

	}
	$c++;
	
	

}





					

?>

<script language="javascript">
	
	alert('订单导入完成');



</script>





