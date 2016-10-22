<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="style/cskt.css" />
</head>
<body>
<?php
	
	
	include "include/config.php";

	
error_reporting(E_ALL);

	
	$uploadfile = date("Y").date("m").date("d").rand(1,3009).".xls";
	
	

	

	if (move_uploaded_file($_FILES['upfile']['tmp_name'], 'images/'.$uploadfile)) {
	
		echo "<font color=BLUE>File uploads success</font><br>";
	
	}else {
   		
		echo "<font color=red> File upload failure</font><br>"; 	
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


$runarry	= array();
$str		= "";



while(true){
	

	
		
	
		
	$goods_sn	 			= trim($currentSheet->getCell('A'.$c)->getValue());
	$store_sn	 			= trim($currentSheet->getCell('B'.$c)->getValue());
	$goods_count 			= trim($currentSheet->getCell('C'.$c)->getValue());
	$goods_sx	 			= trim($currentSheet->getCell('D'.$c)->getValue());
	$goods_xx	 			= trim($currentSheet->getCell('E'.$c)->getValue());
	$goods_days	 			= trim($currentSheet->getCell('F'.$c)->getValue());
	$purchasedays	 		= trim($currentSheet->getCell('G'.$c)->getValue());
	
	
	$ss						= "select * from ebay_store where store_sn='$store_sn' and ebay_user='$user'";

	
	$ss						= $dbcon->execute($ss);
	$ss						= $dbcon->getResultArray($ss);

	if(count($ss) >=1 && $goods_sn != '' ){
	
		$storeid				= $ss[0]['id'];
		
		$goods_id				= "select * from ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
		$goods_id				= $dbcon->execute($goods_id);
		$goods					= $dbcon->getResultArray($goods_id);
		
		
	
		
		if(count($goods) >=1){
		

		
			$goods_id				= $goods[0]['goods_id'];
			$goods_name				= $goods[0]['goods_name'];	
			
			$seq				= "select * from ebay_onhandle where goods_id='$goods_id' and store_id='$storeid'";
			$seq				= $dbcon->execute($seq);
			$seq				= $dbcon->getResultArray($seq);
			
			
			if(count($seq) == 0){
					
		
						$sq			= "insert into ebay_onhandle(goods_id,goods_count,store_id,ebay_user,goods_name,goods_sn,goods_sx,goods_xx,goods_days,purchasedays) values('$goods_id','$goods_count','$storeid','$user','$goods_name','$goods_sn','$goods_sx','$goods_xx','$goods_days','$purchasedays')";
				
			   }else{
					
					
						$sq			= "update ebay_onhandle set goods_count='$goods_count' ";
						
						
						if($goods_xx != '') $sq .= " , goods_xx='$goods_xx' ";
						if($goods_sx != '') $sq .= " , goods_sx='$goods_sx' ";
						if($goods_days != '') $sq .= " , goods_days='$goods_days' ";
						if($purchasedays != '') $sq .= " , purchasedays='$purchasedays' ";
						
						$sq			.= " where goods_id='$goods_id' and store_id='$storeid'";
		
								
								
				}
				
				echo $sq.'<br>';
				
	
	
				
				if($dbcon->execute($sq)){
			
				}else{
				
					$status = " -[<font color='#FF0000'>操作记录:产品编号:{$goods_sn} 记录更新失败，请手工检查</font>]";
					echo $status.'<br>';
				}
		
		}
		
		
	
	
	}
	
	
	
	



	

	
	
	if($goods_sn == ''){

		break;
		
	}
	
	$c++;
	
}




echo '<br>库存更新完成。';




	


?>








