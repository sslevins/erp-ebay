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
	
	$barCode	 			= str_rep(trim($currentSheet->getCell($aa)->getValue()));     //获取Excel中的条形码号
  if($barCode=='')
	{
		$c++;
		break;
	}
	$barCode=strtoupper($barCode);
	$vv="select code from ebay_barcode where code='$barCode'";                            //查找数据库中是否已存在相同的条形码
	   
	$vv=$dbcon->execute($vv);
	
	
	$vv=$dbcon->getResultArray($vv);
	
	if(count($vv)!=0) 
	{
		echo '<br><font color=RED>'.$barCode.' 导入失败</font>';
		$c++;
		continue;
	}
	else{
		
		
		if($user == '' ) die('系统出错，请联系管理员');
		
	$sql	= "insert into ebay_barcode (code,exist,ebay_user) values ('$barCode','1',$user)";            //插入有效条形码,并将其状态设为1

		if($dbcon->execute($sql)){
			echo '<br><font color=BLUE>'.$barCode.' 导入成功。</font>';
			
		}else{
			
			echo '<br><font color=RED>'.$barCode.' 导入失败。</font>';
			
			
			echo $sql;
			die();
			
		}			

	}
	  $c++;
	
	

}





					

?>

<script language="javascript">
	
	alert('导入完成');



</script>





