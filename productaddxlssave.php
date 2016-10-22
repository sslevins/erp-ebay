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
	$goods_name	 			= str_rep(trim($currentSheet->getCell($bb)->getValue()));
	
	

	
	$goods_cost	 			= str_rep(trim($currentSheet->getCell($cc)->getValue()));
	
	if($goods_cost == '') $goods_cost = 0;
	
	$goods_price 			= str_rep(trim($currentSheet->getCell($dd)->getValue()));
	
	if($goods_price == '') $goods_price = 0;
	
	
	$goods_unit	 			= str_rep(trim($currentSheet->getCell($ee)->getValue()));
	$goods_location			= str_rep(trim($currentSheet->getCell($ff)->getValue()));
	
	
	$goods_weight	 		= trim($currentSheet->getCell($gg)->getValue());
	$goods_note		 		= str_rep(trim($currentSheet->getCell($hh)->getValue()));
		

	if($goods_weight == '') $goods_weight = 0;
	$goods_attribute		= str_rep(trim($currentSheet->getCell($ii)->getValue()));
	$goods_ywsbmc	 		= str_rep(trim($currentSheet->getCell($jj)->getValue()));
	$goods_hgbm	 			= str_rep(trim($currentSheet->getCell($kk)->getValue()));
	$goods_zysbmc	 		= str_rep(trim($currentSheet->getCell($ll)->getValue()));
	$goods_sbjz	 			= str_rep(trim($currentSheet->getCell($mm)->getValue()));
	$goods_length	 		= str_rep(trim($currentSheet->getCell($nn)->getValue()));
	$goods_width	 		= str_rep(trim($currentSheet->getCell($oo)->getValue()));
	$goods_height	 		= str_rep(trim($currentSheet->getCell($pp)->getValue()));
	
	$goods_category	 		= str_rep(trim($currentSheet->getCell($qq)->getValue()));
	$storeid		 		= str_rep(trim($currentSheet->getCell($ss)->getValue()));
	
	$salesuser		 		= str_rep(trim($currentSheet->getCell($tt)->getValue()));
	$cguser			 		= str_rep(trim($currentSheet->getCell($uu)->getValue()));
	$ebay_packingmaterial	= str_rep(trim($currentSheet->getCell($vv)->getValue()));
	$capacity				= str_rep(trim($currentSheet->getCell($ww)->getValue()));
	$factor					= str_rep(trim($currentSheet->getCell($xx)->getValue()));
    $btb_number			    = str_rep(trim($currentSheet->getCell($aa1)->getValue()));
	$kfuser				    = str_rep(trim($currentSheet->getCell($ab1)->getValue()));
	$bzuser				    = str_rep(trim($currentSheet->getCell($ac1)->getValue()));
	$goods_status				    = str_rep(trim($currentSheet->getCell($ad1)->getValue()));
	
	if($warehousesx == '') $warehousesx = 0;
	if($warehousexx == '') $warehousexx = 0;
	if($goods_length == '') $goods_length = 0;
	if($goods_width == '') $goods_width = 0;
	if($goods_height == '') $goods_height = 0;
	
	/* 仓库对应的IDfactory	 */
	
	$ss						= "select * from ebay_store where store_name='$storeid' and ebay_user='$user'";
	$ss						= $dbcon->execute($ss);
	$ss						= $dbcon->getResultArray($ss);
	$storeid				= $ss[0]['id'];
		
	
	/* 货品类别 */
	$ss						= "select * from ebay_goodscategory where name='$goods_category' and ebay_user='$user'";
	$ss						= $dbcon->execute($ss);
	$ss						= $dbcon->getResultArray($ss);
	$goods_category			= $ss[0]['id'];
	
	
	/* 货品类别 */
	$ss						= "select * from ebay_partner where company_name='$factor' and ebay_user='$user'";
	$ss						= $dbcon->execute($ss);
	$ss						= $dbcon->getResultArray($ss);
	$factor					= $ss[0]['id'];
	

	
	
	$sql		= "select * from ebay_goods where goods_sn= '$goods_sn' and ebay_user='$user'";
	$sql		= $dbcon->execute($sql);
	$sql		= $dbcon->getResultArray($sql);
	if(count($sql) == 0){
	
	
		
		$sql	=  "insert into ebay_goods(goods_sn,goods_name,goods_cost,goods_price,goods_unit,goods_location,";
		$sql	.= "warehousesx,warehousexx,goods_weight,goods_note,goods_attribute,goods_ywsbmc,goods_hgbm,goods_zysbmc,";
		$sql	.= "goods_sbjz,goods_register,goods_length,goods_width,goods_height,ebay_user,goods_category,storeid,salesuser,cguser,capacity,factory,BtoBnumber,kfuser,bzuser,isuse) values('$goods_sn','$goods_name','$goods_cost',";
		$sql	.= "'$goods_price','$goods_unit','$goods_location','$warehousesx','$warehousexx','$goods_weight',";
		$sql	.= "'$goods_note','$goods_attribute','$goods_ywsbmc','$goods_hgbm','$goods_zysbmc','$goods_sbjz',";
		$sql	.= "'$goods_register','$goods_length','$goods_width','$goods_height','$user','$goods_category','$storeid','$salesuser','$cguser','$capacity','$factor','$btb_number','$kfuser','$bzuser','$goods_status')";
		
		
		
	
	
	}else{
	
		$sql  =  "update ebay_goods set color=''";
	
		if($factor != '' ) 		 $sql .= " , factory='$factor'";
		if($goods_name != '' ) 		 $sql .= " , goods_name='$goods_name'";
		if($goods_cost != '' ) 		 $sql .= " , goods_cost='$goods_cost'";
		if($goods_price != '' )		 $sql .= " , goods_price='$goods_price'";
		if($goods_unit != '' ) 		 $sql .= " , goods_unit='$goods_unit'";
		if($goods_location != '' )   $sql .= " , goods_location='$goods_location'";
		if($goods_weight != '' ) 	 $sql .= " , goods_weight='$goods_weight'";
		if($goods_note != '' ) 		 $sql .= " , goods_note='$goods_note'";
		if($goods_attribute != '' )  $sql .= " , goods_attribute='$goods_attribute'";
		if($goods_ywsbmc != '' ) 	 $sql .= " , goods_ywsbmc='$goods_ywsbmc'";
		if($goods_hgbm != '' ) 		 $sql .= " , goods_hgbm='$goods_hgbm'";
		if($goods_ywsbmc != '' ) 	 $sql .= " , goods_ywsbmc='$goods_ywsbmc'";
		if($goods_zysbmc != '' ) 	 $sql .= " , goods_zysbmc='$goods_zysbmc'";
		if($goods_ywsbmc != '' ) 	 $sql .= " , goods_ywsbmc='$goods_ywsbmc'";
		if($goods_sbjz != '' ) 		 $sql .= " , goods_sbjz='$goods_sbjz'";
		if($cguser != '' ) 		 	 $sql .= " , cguser='$cguser'";
		if($salesuser != '' ) 		 $sql .= " , salesuser='$salesuser'";
		if($goods_register != '' )   $sql .= " , goods_register='$goods_register'";
		if($goods_length != '' ) 	 $sql .= " , goods_length='$goods_length'";
		if($goods_width != '' ) 	 $sql .= " , goods_width='$goods_width'";
		if($goods_height != '' ) 	 $sql .= " , goods_height='$goods_height'";
		if($goods_category != '' )   $sql .= " , goods_category='$goods_category'";
		if($storeid != '' ) 		 $sql .= " , storeid='$storeid'";
		if($salesuser != '' ) 		 $sql .= " , salesuser='$salesuser'";
		if($cguser != '' ) 			 $sql .= " , cguser='$cguser'";
		if($bzuser != '' ) 			 $sql .= " , bzuser='$bzuser'";
		if($kfuser != '' ) 			 $sql .= " , kfuser='$kfuser'";
		if($goods_status != '' ) 			 $sql .= " , isuse='$goods_status'";
		if($ebay_packingmaterial != '' ) 			 $sql .= " , ebay_packingmaterial='$ebay_packingmaterial'";
		if($capacity != '' ) 			 $sql .= " , capacity='$capacity'";
		if($btb_number != '' ) 			 $sql .= " , BtoBnumber='$btb_number'";
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






