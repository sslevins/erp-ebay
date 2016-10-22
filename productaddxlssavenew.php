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
	$aa1	= 'AA'.$c;	
	$ab1	= 'AB'.$c;	
	$ac1	= 'AC'.$c;	
	$ad1	= 'AD'.$c;	
	
	
	$goods_sn	 			= str_rep(trim($currentSheet->getCell($aa)->getValue()));
	$goods_status	 			= str_rep(trim($currentSheet->getCell($bb)->getValue()));
	
	

	
	$goods_category 			= str_rep(trim($currentSheet->getCell($cc)->getValue()));
	
	
	$goods_name 			= str_rep(trim($currentSheet->getCell($dd)->getValue()));
	
	
	
	$goods_guige	 			= str_rep(trim($currentSheet->getCell($ee)->getValue()));
	$goods_color			= str_rep(trim($currentSheet->getCell($ff)->getValue()));
	
	
	$goods_moq	 		= trim($currentSheet->getCell($gg)->getValue());
	$goods_delivery		 		= str_rep(trim($currentSheet->getCell($hh)->getValue()));
	$goods_price		= str_rep(trim($currentSheet->getCell($ii)->getValue()));
	$goods_cost	 		= str_rep(trim($currentSheet->getCell($jj)->getValue()));
	$goods_weight 			= str_rep(trim($currentSheet->getCell($kk)->getValue()));
	$goods_volume	 		= str_rep(trim($currentSheet->getCell($ll)->getValue()));
	$goods_length 			= str_rep(trim($currentSheet->getCell($mm)->getValue()));
	$goods_width	 		= str_rep(trim($currentSheet->getCell($nn)->getValue()));
	$goods_height	 		= str_rep(trim($currentSheet->getCell($oo)->getValue()));
	$accessories_detail	 		= str_rep(trim($currentSheet->getCell($pp)->getValue()));
	
	$goods_certification	 		= str_rep(trim($currentSheet->getCell($qq)->getValue()));
	$goods_addtime		 		= str_rep(trim($currentSheet->getCell($rr)->getValue()));
	
	$goods_developer		 		= str_rep(trim($currentSheet->getCell($ss)->getValue()));
	$sample_inspectors			 		= str_rep(trim($currentSheet->getCell($tt)->getValue()));
	$goods_suppliers	= str_rep(trim($currentSheet->getCell($uu)->getValue()));
	$goods_upc				= str_rep(trim($currentSheet->getCell($vv)->getValue()));
	$goods_esin					= str_rep(trim($currentSheet->getCell($ww)->getValue()));
		
	
	/* 货品类别 */
	$ss						= "select * from ebay_goodscategory where name='$goods_category' and ebay_user='$user'";
	$ss						= $dbcon->execute($ss);
	$ss						= $dbcon->getResultArray($ss);
	$goods_category			= $ss[0]['id'];
	
	
	/* 货品类别 */
	$ss						= "select * from ebay_partner where company_name='$goods_suppliers' and ebay_user='$user'";
	$ss						= $dbcon->execute($ss);
	$ss						= $dbcon->getResultArray($ss);
	$goods_suppliers					= $ss[0]['id'];
	

	
	
	$sql		= "select * from ebay_newgoods where goods_sn= '$goods_sn' and ebay_user='$user'";
	$sql		= $dbcon->execute($sql);
	$sql		= $dbcon->getResultArray($sql);
	if(count($sql) == 0){
	
	
		
		$sql	=  "insert into ebay_newgoods(goods_sn,goods_status,goods_category,goods_name,goods_guige,goods_color,";
		$sql	.= "goods_moq,goods_delivery,goods_price,goods_cost,goods_weight,goods_volume,goods_length,goods_width,";
		$sql	.= "goods_height,accessories_detail,goods_certification,goods_addtime,goods_developer,sample_inspectors,goods_suppliers,goods_upc,goods_esin,ebay_user) values('$goods_sn','$goods_status','$goods_category',";
		$sql	.= "'$goods_name','$goods_guige','$goods_color','$goods_moq','$goods_delivery','$goods_price',";
		$sql	.= "'$goods_cost','$goods_weight','$goods_volume','$goods_length','$goods_width','$goods_height',";
		$sql	.= "'$accessories_detail','$goods_certification','$goods_addtime','$goods_developer','$sample_inspectors','$goods_suppliers','$goods_upc','$goods_esin','$user')";	
	}else{
	
		$sql  =  "update ebay_newgoods set ebay_user='$user'";
	
		if($goods_status != '' ) 		 $sql .= " , goods_status='$goods_status'";
		if($goods_name != '' ) 		 $sql .= " , goods_name='$goods_name'";
		if($goods_cost != '' ) 		 $sql .= " , goods_cost='$goods_cost'";
		if($goods_price != '' )		 $sql .= " , goods_price='$goods_price'";
		if($goods_category != '' ) 		 $sql .= " , goods_category='$goods_category'";
		if($goods_guige != '' )   $sql .= " , goods_guige='$goods_guige'";
		if($goods_weight != '' ) 	 $sql .= " , goods_weight='$goods_weight'";
		if($goods_color != '' ) 		 $sql .= " , goods_color='$goods_color'";
		if($goods_moq != '' )  $sql .= " , goods_moq='$goods_moq'";
		if($goods_delivery != '' ) 	 $sql .= " , goods_delivery='$goods_delivery'";
		if($accessories_detail != '' ) 		 $sql .= " , accessories_detail='$accessories_detail'";
		if($goods_certification != '' ) 	 $sql .= " , goods_certification='$goods_certification'";
		if($goods_volume != '' ) 	 $sql .= " , goods_volume='$goods_volume'";
		if($goods_addtime != '' ) 	 $sql .= " , goods_addtime='$goods_addtime'";
		if($goods_developer != '' ) 		 $sql .= " , goods_developer='$goods_developer'";
		if($sample_inspectors != '' ) 		 	 $sql .= " , sample_inspectors='$sample_inspectors'";
		if($goods_suppliers != '' ) 		 $sql .= " , goods_suppliers='$goods_suppliers'";
		if($goods_upc != '' )   $sql .= " , goods_upc='$goods_upc'";
		if($goods_esin != '' ) 	 $sql .= " , goods_esin='$goods_esin'";
		if($goods_height != '' ) 	 $sql .= " , goods_height='$goods_height'";
		if($goods_length != '' ) 	 $sql .= " , goods_length='$goods_length'";
		if($goods_width != '' ) 	 $sql .= " , goods_width='$goods_width'";
		$sql .=  " where ebay_user='$user' and goods_sn='$goods_sn'";
		
		

		
				
	
	}

	echo $sql;
	
	
	if($goods_sn == '') break;
	
	$c++;
	

	if($dbcon->execute($sql)){
	
	
				//	$status	= " -[<font color='#33CC33'>物品编号：$goods_sn 导入成功,重量是:".$goods_weight."</font>]";

	}else{
	

					$status = " -[<font color='#FF0000'>物品编号：$goods_sn 导入失败</font>]";
					
				

	}
	echo $status.'<br>';
	

}
	
	echo "<script>alert('物品导入成功')</script>";
	

?>






