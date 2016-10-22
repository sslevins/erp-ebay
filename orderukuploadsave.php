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
	echo '<br/>'.$filePath."<br/>";
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
	
	
	/*
	$ssy='SELECT DISTINCT ebay_couny, ebay_countryname FROM `ebay_order`WHERE ebay_countryname != ""';
	$ssy = $dbcon->execute($ssy);
	$ssy = $dbcon->getResultArray($ssy);
	$countryarr=array();
	for($i=0;$i<count($ssy);$i++){
		$key=$ssy[$i]['ebay_couny'];
		$value=$ssy[$i]['ebay_countryname'];
		$countryarr[$key]=$value;
	}
	*/
	
	$t='orderid,orderitemid,purchasedate,paymentsdate,buyeremail,buyername,buyerphonenumber,sku,productname,quantitypurchased,currency,itemprice,itemtax,shippingprice,shippingtax,shipservicelevel,recipientname,shipaddress1,shipaddress2,shipaddress3,shipcity,shipstate,shippostalcode,shipcountry,shipphonenumber';
	$ta=explode(',',$t);
	$nav="A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y";
	$s=explode(',',$nav);

	$arr=array();
	for($i=0;;$i++){
				$recordnumber	 = trim($currentSheet->getCell('A'.($i+2))->getValue());			//订单号
				
				if($recordnumber != ''){
						for($j=0;$j<count($s);$j++){
							if($j==2 ||$j==3){
								$arr[$i][$ta[$j]]=strtotime(trim($currentSheet->getCell($s[$j].($i+2))->getValue()));
							}else{
								$arr[$i][$ta[$j]]=mysql_escape_string(trim($currentSheet->getCell($s[$j].($i+2))->getValue()));
							}
							$arr[$i]['ebay_account']=$account;
							$arr[$i]['ebay_status']=$orderstatus;
						}
						
				}else{
						break;
				}
		}	
		
		
		for($i=0,$len=count($arr);$i<$len;$i++){
				$a=$arr[$i];
				


				$orderid=trim($a['orderid']);
				
				$orderitemid=trim($a['orderitemid']);
				$ebay_account=$a['ebay_account'];
				$vv	= trim(CheckID($orderid,$ebay_account));
				if($vv==0){
					insert_order($a);
					
					insert_orderdetail($a);
				}else{
					$sql     = "select ebay_id from ebay_orderdetail where ebay_ordersn='$vv' and ebay_itemid='$orderitemid'";
					$sql     = $dbcon->query($sql);
					$sql	 = $dbcon->num_rows($sql);
					
					if($sql==0){
						insert_orderdetail($a);
					}
					
				
				
				}
		}
		
		//插入到ebay_order订单表 函数
		function  insert_order($a){
				global $dbcon,$user,$defaultstoreid,$countryarr;
				extract($a);
				$countrynmae= $shipcountry;
				

				
				
				$sql	= "insert into  ebay_order
												(ebay_userid,ebay_ordersn,recordnumber,ebay_createdtime,ebay_paidtime,
													ebay_usermail,ebay_username,ebay_phone,ebay_street,ebay_street1,ebay_city,
													ebay_state,ebay_postcode,ebay_couny,ebay_countryname,ebay_account,ebay_status,ebay_user,ebay_warehouse,ebay_currency
									)
									values('$buyername','$orderid','$orderid','$purchasedate','$paymentsdate','$buyeremail',
												'$buyername','$buyerphonenumber','$shipaddress1','$shipaddress2','$shipcity',
												'$shipstate','$shippostalcode','$shipcountry','$countrynmae','$ebay_account','$ebay_status','$user','82','$currency')";




				if($dbcon->execute($sql)){			
				
				
					
						echo "$iid 添加成功"."<br>";			
				}else{
							//echo '<pre>';
						print_r( mysql_error());
						echo '<font color=red>添加失败</font><br/>';
					
				}
		
		}
		
		//插入到订单详细表函数 $a为一条插入记录
		function insert_orderdetail($a){
			
				global $dbcon,$user;
				extract($a);
				
				
				if($user == 'yuzugang'){
					
					$sku  = substr($sku,3,5);
					
				}
				
				
				//$tatolfee=$itemprice*$quantitypurchased+$shippingprice;
				$sql	= "insert into  ebay_orderdetail
												(ebay_ordersn,recordnumber,ebay_itemid,ebay_itemtitle,
													ebay_account,ebay_user,sku,ebay_amount,ebay_site,ebay_itemprice
												
									)
												
										values('$orderid','$orderitemid','$orderitemid','$productname',
													'$ebay_account','$user','$sku','$quantitypurchased','$ebay_site','$itemprice'
								
									)";
									
									
					
				
				if($dbcon->execute($sql)){				
						echo "$orderid 添加成功"."<br>";	
						
				}else{
						print_r( mysql_error());
						echo "<font color=red> $orderid 添加失败</font><br/>";
					
				}
				
	
				
				
		}
		
		
		
		
	
							$sql="select ebay_ordersn,ebay_note,ebay_id from ebay_order where ebay_status=1 or ebay_status = $orderstatus ";
							$sql		 = $dbcon->execute($sql);
							$sql	 = $dbcon->getResultArray($sql);
							for($i=0;$i<count($sql);$i++){
								
								
					
								
								$yy="select sum(ebay_itemprice) as totalprice from ebay_orderdetail where ebay_ordersn = '".$sql[$i]['ebay_ordersn']."' group by ebay_ordersn";
								
								
								$yy		 = $dbcon->execute($yy);
								$yy      = $dbcon->getResultArray($yy);
								$totalprice = $yy[0]['totalprice'];
								if(count($yy)>0){
										$zz="update ebay_order set ebay_total = '$totalprice' where ebay_ordersn='".$sql[$i]['ebay_ordersn']."'";
										$zz= $dbcon->execute($zz);

										
								}
				
								
								
							}
		
		

?>



