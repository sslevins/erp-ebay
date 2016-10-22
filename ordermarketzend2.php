<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 



<html> 



<head> 



<link rel="SHORTCUT ICON" href="themes/Sugar5/images/sugar_icon.ico?s=eae43f74f8a8f907c45061968d50157c&c=1"> 



<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 



<title>eBay</title> 



<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/yui.css" />



<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/deprecated.css" />



<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/style.css" /> 



</head><body> 


<?php 
include "include/config.php";

	
	$ordersn		= $_REQUEST['ordersn'];
	

	$order		= explode(",",$ordersn);
	
	
	
	$markarray	=  array();
	
	$b			= 0;
	
	for($i=0;$i<count($order);$i++){
	
		
		if($order[$i] != ""){
		
			$sn					= $order[$i];
			$ss					= "select * from ebay_order where ebay_id = '$sn'";
			$ss				 	= $dbcon->execute($ss);
			$ss					= $dbcon->getResultArray($ss);
			$ebay_account 		= $ss[0]['ebay_account'];
			$ebay_tracknumber 	= $ss[0]['ebay_tracknumber'];
			$ebay_ordersn	 	= $ss[0]['ebay_ordersn'];
			$ebay_markettime	 	= $ss[0]['ebay_markettime'];
			
	
			$sql = "select * from ebay_zen where zen_name='$ebay_account'";
			
			
			$sql = $dbcon->execute($sql);
			$sql = $dbcon->getResultArray($sql);
		
		

			
			$host			= $sql[0]['zen_server'];
			$root			= $sql[0]['zen_username'];
			$password		= $sql[0]['zen_password'];
			$dbname			= $sql[0]['zen_database'];
			
			
			$sql				= "select * from ebay_ordernote where ordersn='$ebay_ordersn'";
			$sql 				= $dbcon->execute($sql);
			$sql				 = $dbcon->getResultArray($sql);
			$ebay_tracknumber	= $sql[0]['content'];
			
			
		

			
			
			
			$markarray[$b]['ebay_ordersn']			=	$ebay_ordersn;
			$markarray[$b]['host']					=	$host;
			$markarray[$b]['root']					=	$root;
			$markarray[$b]['password']				=	$password;
			$markarray[$b]['dbname']				=	$dbname;
			$markarray[$b]['ebay_tracknumber']		=	$ebay_tracknumber;
			
			$markarray[$b]['ebay_account']			=	$ebay_account;
			$markarray[$b]['ebay_markettime']			=	$ebay_markettime;
		//	$
			
			$b++;
			
	
			
		
		
		
		}
	
	}
	

	
	for($i=0; $i<count($markarray);$i++){
	
		$ebay_ordersn					= $markarray[$i]['ebay_ordersn'];
	
		$host							= $markarray[$i]['host'];
		$root							= $markarray[$i]['root'];
		$password						= $markarray[$i]['password'];
		$dbname							= $markarray[$i]['dbname'];
		$ebay_tracknumber				= $markarray[$i]['ebay_tracknumber'];
		$ebay_account					= $markarray[$i]['ebay_account'];
		$ebay_markettime					= $markarray[$i]['ebay_markettime'];
	
		
		if($ebay_markettime == ''){
		
		addoutstocks($ebay_ordersn,$ebay_account);
		$status							= marketzend($ebay_ordersn,$ebay_tracknumber,$host,$root,$password,$dbname);
		if($status){
			$ss			="update ebay_order set ebay_status='2',ebay_markettime='$mctime' where ebay_account='$ebay_account' and   ebay_ordersn='$ebay_ordersn' ";
			echo "$ebay_ordersn  标记发出成功";
			abcquery($ss);
		}
		}else{
			
			
			
			echo "订单已经标记发出";
				
			
		}
		
		
		
	}
	
	
	function addoutstocks($str,$ebay_account){		
		
		global $user,$nowtime;
		
		$abc	= mysql_connect("127.0.0.1:3306","root","123456") or die("ݿʧ");
		mysql_selectdb('testshop') or die("false");
		mysql_query("SET names utf8", $abc);

		$ss		= "select * from ebay_orderdetail where ebay_ordersn='$str'";
		$dstr		= "出库";
		

		
		$result = mysql_query($ss) or die("数据库查询失败");	

		while($row = mysql_fetch_assoc($result)){
		
			$sku 					= $row['sku'];
			$ebay_amount 			= $row['ebay_amount'];
			//$sku	= '9958-04';
			
			$sql		= "SELECT * FROM ebay_goods where goods_sn='$sku' and ebay_user='$user'";
			$sql	 	= mysql_query($sql) or die("数据库查询失败");	
			if($rows = mysql_fetch_assoc($sql)){
			
				$storeid		= $rows['storeid'];
				$goods_id		= $rows['goods_id'];
				$goods_sn		= str_rep($rows['goods_sn']);
				$goods_name		= str_rep($rows['goods_name']);
				$goods_price	= $rows['goods_price'];
				$goods_cost		= $rows['goods_cost'];
				$goods_category	= $rows['goods_category'];
				
				
				$sq			 = "INSERT INTO `ebay_goodshistory` (`addtime` , `goodsid` , `goodsn` , `goodsname` , `stocktype` , `goodsprice` ,";
				$sq			.= "`goodsnumber` , `ebay_user` ,`ebay_account`,`goods_category` ) VALUES ('$nowtime', '$goods_id', '$goods_sn', '$goods_name', '$dstr', '$goods_price', '$ebay_amount', '$user','$ebay_account','$goods_category');";
				echo $sq;
				
				
				$sq2			= "update ebay_onhandle set goods_count=goods_count-$ebay_amount where goods_sn='$goods_sn' and store_id='$storeid'";
				
				mysql_query($sq);
				mysql_query($sq2);
				
				
				
				
			
			
			}
			
		
		}
		
	
		
					
	}
				   
				   
	
	
	function abcquery($str){		
		
					$status = 0;		
					$abc	= mysql_connect("127.0.0.1:3306","root","123456") or die("ݿʧ");
					mysql_selectdb('testshop') or die("ʧ");
					if(mysql_query($str,$abc)){				
						$status = 1;		
					}else{			
						$status = 0;			
					}		
					return $status;		
				   }
	
	
	
	function marketzend($ordersid,$ebay_tracknumber,$host,$root,$password,$dbname){
		
		
		global $nowtime;
		$did		= mysql_connect($host,$root,$password) or die("webstore ݿʧ");
		mysql_selectdb($dbname,$did) or die("ʧ");
		
		$ss				= "select * from zen_orders where orders_id='$ordersid'";
		
		
		$result = mysql_query($ss,$did) or die("ݿѯʧ");
		
		
		$sq0			=  "update zen_orders set orders_status='3' where orders_id='$ordersid'";
		$sq1			=  "insert into zen_orders_status_history(orders_id,orders_status_id,date_added,customer_notified,comments)";
		$sq1		    .= " values('$ordersid','3','$nowtime','1','$ebay_tracknumber')";
		
		$status			= 0;
		
		if(mysql_query($sq0,$did) && mysql_query($sq1,$did)){
		
			$status     =1;
			
		}
		
		mysql_close($did);
		
							
		return $status;				
	
	
	
	
	}
	


?>
