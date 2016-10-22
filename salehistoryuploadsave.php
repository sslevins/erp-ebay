<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="style/cskt.css" />
</head>
<body>
<?php
	/* 亚马逊订单导入  杨录义  2012-05-22 */
	
	include "include/config.php";
	
	
	//error_reporting('ALL');
	$account				= $_POST['account'];
	$orderstatus			= $_POST['orderstatus'];
	
	/* 检查订单是否重复 */
	
	function CheckID($recordnumber,$account){
		global $dbcon;		
		$sql		= "select ebay_ordersn from ebay_order where recordnumber='$recordnumber' and ebay_account='$account'"; 
		//echo $sql.'<br>';
		$sql  = $dbcon->execute($sql);
		$sql  = $dbcon->getResultArray($sql);
		if(count($sql) == 0){
			$status			= "0";
		}else{
			$status 		= $sql[0]['ebay_ordersn'];
		}
		return $status;
	}
	


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

	$SalesRecordNumber="";
	for($i=2;;$i++){
		echo $i;
				$recordnumber	 = trim($currentSheet->getCell('A'.$i)->getValue());			//订单号
				echo $i;
				if($recordnumber != ''){
					
					if($recordnumber!=$SalesRecordNumber){
						$ordersn				= date('Y')."-".date('m')."-".date('d')."-".date("H").date('i').date('s'). mt_rand(100, 999);
						while(true){
							$si		= "select * from ebay_order where ebay_ordersn ='$ordersn'";
							$si		= $dbcon->execute($si);
							$si		= $dbcon->getResultArray($si);
							if(count($si)==0) break;
							$ordersn				= date('Y')."-".date('m')."-".date('d')."-".date("H").date('i').date('s'). mt_rand(100, 999);
						}
						$SalesRecordNumber=str_rep(trim($currentSheet->getCell('A'.$i)->getValue()));
						$SaleDate=strtotime(str_rep(trim($currentSheet->getCell('W'.$i)->getValue())));
						$PaidonDate=strtotime(str_rep(trim($currentSheet->getCell('Y'.$i)->getValue())));
						$BuyerEmail=str_rep(trim($currentSheet->getCell('E'.$i)->getValue()));
						$UserId=str_rep(trim($currentSheet->getCell('B'.$i)->getValue()));
						$BuyerFullname=str_rep(trim($currentSheet->getCell('C'.$i)->getValue()));
						$BuyerPhoneNumber=str_rep(trim($currentSheet->getCell('D'.$i)->getValue()));
						$BuyerAddress1=str_rep(trim($currentSheet->getCell('F'.$i)->getValue()));
						$BuyerAddress2=str_rep(trim($currentSheet->getCell('G'.$i)->getValue()));
						$BuyerCity=str_rep(trim($currentSheet->getCell('H'.$i)->getValue()));
						$BuyerState=str_rep(trim($currentSheet->getCell('I'.$i)->getValue()));
						$BuyerZip=str_rep(trim($currentSheet->getCell('J'.$i)->getValue()));
						$BuyerCountry=str_rep(trim($currentSheet->getCell('K'.$i)->getValue()));
						$ebay_account=$account;
						$ebay_status=$orderstatus;
						$TransactionID=str_rep(trim($currentSheet->getCell('AG'.$i)->getValue()));
						$PayPalTransactionID=str_rep(trim($currentSheet->getCell('AD'.$i)->getValue()));
						$orderdetailrecodernumber=str_rep(trim($currentSheet->getCell('L'.$i)->getValue()));
						$Shipping=str_rep(trim($currentSheet->getCell('Q'.$i)->getValue()));
						$totalprice=str_rep(trim($currentSheet->getCell('U'.$i)->getValue()));
						
						$vv	= trim(CheckID($SalesRecordNumber,$ebay_account));
						if($vv==0){
							
							$sql	= "insert into  ebay_order
							(ebay_ordersn,recordnumber,ebay_createdtime,ebay_paidtime,
							ebay_usermail,ebay_userid,ebay_username,ebay_phone,ebay_street,ebay_street1,ebay_city,
							ebay_state,ebay_postcode,ebay_countryname,ebay_account,ebay_status,ebay_user,ebay_warehouse,
							ebay_tid,ebay_ptid,ebay_total,ebay_shipfee
							
							)
							
							values('$ordersn','$SalesRecordNumber','$SaleDate','$PaidonDate','$BuyerEmail',
							'$UserId','$BuyerFullname','$BuyerPhoneNumber','$BuyerAddress1','$BuyerAddress2','$BuyerCity',
							'$BuyerState','$BuyerZip','$BuyerCountry','$ebay_account','$ebay_status','$user','$defaultstoreid',
							'$TransactionID','$PayPalTransactionID','$totalprice','$Shipping'
								
							)";
							if($dbcon->execute($sql)){
								echo "$val 添加成功: UserID:$UserId  <br>";
								if($orderdetailrecodernumber==""){
									continue;		
								}
						
								$sql     = "select ebay_id from ebay_orderdetail where ebay_ordersn='$vv' and recordnumber='$orderdetailrecodernumber'";
								$sql     = $dbcon->query($sql);
								$sql	 = $dbcon->num_rows($sql);
								if($sql==0){
									$ItemTitle=str_rep(trim($currentSheet->getCell('M'.$i)->getValue()));
									$CustomLabel=str_rep(trim($currentSheet->getCell('N'.$i)->getValue()));
									$SalePrice=str_rep(trim($currentSheet->getCell('P'.$i)->getValue()));
									$Quantity=str_rep(trim($currentSheet->getCell('O'.$i)->getValue()));
									$CheckoutDate=strtotime(str_rep(trim($currentSheet->getCell('X'.$i)->getValue())));
									
									$sql	= "insert into  ebay_orderdetail
										(ebay_ordersn,recordnumber,ebay_itemid,ebay_itemtitle,
										ebay_account,ebay_user,sku,ebay_itemprice,ebay_amount,
										shipingfee,ebay_createdtime,addtime,ebay_tid	
										)
										
										values('$ordersn','$orderdetailrecodernumber','$orderdetailrecodernumber','$ItemTitle',
										'$ebay_account','$user','$CustomLabel','$SalePrice','$Quantity',
										'$Shipping','$SaleDate','$CheckoutDate','$TransactionID'
										
											
											
									)";
									if($dbcon->execute($sql)){
										echo "$ordersn 添加详细订单成功"."<br>";
									//计算总价及总运费
										$sql1="select ebay_id,ebay_total,ebay_shipfee from ebay_order where  ebay_ordersn='$ordersn'";
										$rs=$dbcon->execute($sql1);
										
									}else{
										print_r( mysql_error());
										echo "<font color=red> $orderid 添加详细订单失败</font><br/>";
											
									}
								}
								}		
							}else{
								
								echo "添加订单$SalesRecordNumber失败";
							}
						}else{
								
								$orderdetailrecodernumber=str_rep(trim($currentSheet->getCell('L'.$i)->getValue()));
								$sql     = "select ebay_id from ebay_orderdetail where ebay_ordersn='$vv' and recordnumber='$orderdetailrecodernumber'";
								$sql     = $dbcon->query($sql);
								$sql	 = $dbcon->num_rows($sql);
								if($sql==0){
									$ItemTitle=str_rep(trim($currentSheet->getCell('M'.$i)->getValue()));
									$CustomLabel=str_rep(trim($currentSheet->getCell('N'.$i)->getValue()));
									$SalePrice=str_rep(trim($currentSheet->getCell('P'.$i)->getValue()));
									$Quantity=str_rep(trim($currentSheet->getCell('O'.$i)->getValue()));
									
									$CheckoutDate=strtotime(str_rep(trim($currentSheet->getCell('X'.$i)->getValue())));
									
									$sql	= "insert into  ebay_orderdetail
										(ebay_ordersn,recordnumber,ebay_itemid,ebay_itemtitle,
										ebay_account,ebay_user,sku,ebay_itemprice,ebay_amount,
										shipingfee,ebay_createdtime,addtime,ebay_tid	
										)
										
										values('$ordersn','$orderdetailrecodernumber','$orderdetailrecodernumber','$ItemTitle',
										'$ebay_account','$user','$CustomLabel','$SalePrice','$Quantity',
										'$Shipping','$SaleDate','$CheckoutDate','$TransactionID'
										
											
											
									)";
									if($dbcon->execute($sql)){
									echo "$ordersn 添加详细订单成功"."<br>";
									//计算总价及总运费
										$sql1="select ebay_id,ebay_total,ebay_shipfee from ebay_order where  ebay_ordersn='$ordersn'";
										$rs=$dbcon->execute($sql1);
										
										}else{
										print_r( mysql_error());
										echo "<font color=red> $orderid 添加失败</font><br/>";
											
										}
							
								}else{
									echo "详细订单记录应经存在".$orderdetailrecodernumber."<br/>";
								}
										
						}	
						
	}else {
		break;
	}	
	}
		
?>



