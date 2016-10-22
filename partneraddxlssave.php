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
	$ss	= 'S'.$c;
	$tt	= 'T'.$c;
	$uu	= 'U'.$c;
	$vv	= 'V'.$c;
	$ww	= 'W'.$c;
	$zz	= 'Z'.$c;
	$xx	= 'X'.$c;
	
	
	$company_name	 			= mysql_escape_string(trim($currentSheet->getCell($aa)->getValue()));
	$username   	 			= mysql_escape_string(trim($currentSheet->getCell($bb)->getValue()));
	$tel		   	 			= mysql_escape_string(trim($currentSheet->getCell($cc)->getValue()));
	$mobile		   	 			= mysql_escape_string(trim($currentSheet->getCell($ee)->getValue()));
	$fax		   	 			= mysql_escape_string(trim($currentSheet->getCell($dd)->getValue()));
	$mail		   	 			= mysql_escape_string(trim($currentSheet->getCell($ff)->getValue()));
	$address		   	 		= mysql_escape_string(trim($currentSheet->getCell($hh)->getValue()));
	$note		   	 			= mysql_escape_string(trim($currentSheet->getCell($ii)->getValue()));
	$city		   	 			= mysql_escape_string(trim($currentSheet->getCell($gg)->getValue()));
	$url		   	 			= mysql_escape_string(trim($currentSheet->getCell($jj)->getValue()));
	$bankaccountaddress		   	= mysql_escape_string(trim($currentSheet->getCell($kk)->getValue()));
	$bankaccountname		   	= mysql_escape_string(trim($currentSheet->getCell($ll)->getValue()));
	$bankaccountnumber		   	= mysql_escape_string(trim($currentSheet->getCell($mm)->getValue()));
	$QQ		   	 				= mysql_escape_string(trim($currentSheet->getCell($nn)->getValue()));
	$code		   	 			= mysql_escape_string(trim($currentSheet->getCell($oo)->getValue()));
		
	$sql		= "select * from ebay_partner where company_name= '$company_name' and ebay_user='$user'";
	$sql		= $dbcon->execute($sql);
	$sql		= $dbcon->getResultArray($sql);
	if(count($sql) == 0){
	
	
		
		$sql	=  "insert into ebay_partner(company_name,username,tel,mobile,fax,mail,";
		$sql	.= "address,note,ebay_user,code,city,url,bankaccountaddress,bankaccountname,bankaccountnumber,QQ) values('$company_name','$username','$tel','$mobile','$fax','$mail','$address','$note','$user','$code','$city','$url','$bankaccountaddress','$bankaccountname','$bankaccountnumber','$QQ')";
	
	}else{
	
		$sql  =  "update ebay_partner set company_name='$company_name' ";
	
		if($username != '' ) 		 $sql .= " , username='$username'";
		if($tel != '' ) 		 $sql .= " , tel='$tel'";
		if($mobile != '' )		 $sql .= " , mobile='$mobile' ";
		if($fax != '' ) 		 $sql .= " , fax='$fax'";
		if($mail != '' )   $sql .= " , mail='$mail'";
		if($address != '' ) 	 $sql .= " , address='$address'";
		if($note != '' ) 		 $sql .= " , note='$note'";
		if($code != '' ) 		 $sql .= " , code='$code'";
		if($city != '' ) 		 $sql .= " , city='$city'";
		if($url != '' ) 		 $sql .= " , url='$url'";
		
		if($QQ	 != '' ) 		 $sql .= " , QQ='$QQ'";
		
		if($bankaccountaddress != '' ) 		 $sql .= " , bankaccountaddress='$bankaccountaddress'";
		if($bankaccountname != '' ) 		 $sql .= " , bankaccountname='$bankaccountname'";
		if($bankaccountnumber != '' ) 		 $sql .= " , bankaccountnumber='$bankaccountnumber'";
		
		$sql .=  " where ebay_user='$user' and company_name='$company_name'";
	
	}
	
	


	if($company_name == '') break;
	$c++;
	if($dbcon->execute($sql)){
				$status	= " -[<font color='#33CC33'>供应商:$company_name 导入成功 </font>]";
	}else{
				$status	= " -[<font color='red'>供应商:$company_name 导入失败 </font>]";
	}
	echo $status.'<br>';
}
	echo "<script>alert('导入成功')</script>";
	

?>






