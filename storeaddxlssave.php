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
		
	
	echo "sss";
	$io_ordersn	 			= str_rep(trim($currentSheet->getCell($aa)->getValue()));
	$goods_sn	 			= str_rep(trim($currentSheet->getCell($bb)->getValue()));
	
	echo $io_ordersn	."单号";
	echo $goods_sn	.':SKu';
	
	$goods_count	 			= str_rep(trim($currentSheet->getCell($cc)->getValue()));
	
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

	
	if($warehousesx == '') $warehousesx = 0;
	if($warehousexx == '') $warehousexx = 0;
	if($goods_length == '') $goods_length = 0;
	if($goods_width == '') $goods_width = 0;
	if($goods_height == '') $goods_height = 0;
		if($goods_sn == '') break;
	/* 仓库对应的IDfactory	 */
	
//$ss						= "select * from ebay_store where store_name='$storeid' and ebay_user='$user'";
	//$ss						= $dbcon->execute($ss);
//	$ss						= $dbcon->getResultArray($ss);
	//$storeid				= $ss[0]['id'];
	$storeid =79;
	$in_warehouse=80;
	$stype=0;
		$sql	= "insert into ebay_iostore(partner,io_ordersn,io_addtime,io_warehouse,io_type,io_status,io_note,ebay_user,type,operationuser,io_user) values('$partner','$io_ordersn','$mctime','$in_warehouse','$in_type','1','$note','$user','$stype','$trueusername','$io_user')";
		echo $sql;
		$dbcon->execute($sql);
		
		$sql	= "select * from ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
		echo $sql;
		$sql				= $dbcon->execute($sql);
		$sqll				= $dbcon->getResultArray($sql);
			$goods_name =$sqll	  [0]['goods_name'];
			$goods_id   =$sqll [0]['goods_id'];
			$goods_cost =$sqll [0]['goods_cost'];
			$goods_unit =$sqll [0]['goods_unit'];
$sql		= "insert into ebay_iostoredetail(io_ordersn,goods_name,goods_sn,goods_cost,goods_unit,goods_count,goods_id) values('$io_ordersn','$goods_name','$goods_sn','$goods_cost','$goods_unit','$goods_count','$goods_id')";
$dbcon->execute($sql);
$seq				= "select * from ebay_onhandle where goods_sn='$goods_sn' and store_id='$storeid' and goods_id='$goods_id'";
			$seq				= $dbcon->execute($seq);
			$seq				= $dbcon->getResultArray($seq);
		echo "数据结构";
			print_r($seq);
			if(count($seq) == 0){
			

$sq= "insert into ebay_onhandle(goods_id,goods_count,store_id,ebay_user,goods_name,goods_sn) values('$goods_id','$goods_count','$storeid','$user','$goods_name','$goods_sn')";
echo $sq;
echo "进入";
if(!$dbcon->execute($sq)){
					$status .= " -[<font color='#FF0000'>操作记录: 产品编号:{$goods_sn}入库失败</font>]";
					$runstatus	= 1;
					
				}
			
			}else{
$type=$_REQUEST['type'];
	if($type == 1){
					$sq			= "update ebay_onhandle set goods_count=goods_count+$goods_count where goods_sn='$goods_sn' and store_id='$storeid'  and goods_id='$goods_id'";
				}else{
					$sq			= "update ebay_onhandle set goods_count=goods_count-$goods_count where goods_sn='$goods_sn' and store_id='$storeid'  and goods_id='$goods_id'";
				
				}
				echo $sq;
				$dbcon->execute($sq);

}


//------------------------------------------------------
	
 
	
	 

		
 

	echo $sql;
	
	

	
	$c++;
	

 
	echo $status.'<br>';
	

}
	
	echo "<script>alert('物品导入成功')</script>";
	

?>






