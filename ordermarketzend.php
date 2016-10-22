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
	$type			= $_REQUEST['type'];
	

	
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
			$ebay_markettime	= $ss[0]['ebay_markettime'];
			$ebay_id		 	= $ss[0]['ebay_id'];
	
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
			$markarray[$b]['ebay_id']				=	$ebay_id;
			$markarray[$b]['ebay_account']			=	$ebay_account;
			$markarray[$b]['ebay_markettime']		=	$ebay_markettime;
			$b++;
			
		}
	
	}
	
	$osn		= '';
	for($i=0; $i<count($markarray);$i++){
		$ebay_ordersn					= $markarray[$i]['ebay_ordersn'];
		$host							= $markarray[$i]['host'];
		$root							= $markarray[$i]['root'];
		$password						= $markarray[$i]['password'];
		$dbname							= $markarray[$i]['dbname'];
		$ebay_tracknumber				= $markarray[$i]['ebay_tracknumber'];
		$ebay_account					= $markarray[$i]['ebay_account'];
		$ebay_id					= $markarray[$i]['ebay_id'];
		$ebay_markettime					= '';
		if($ebay_markettime == '' && $type =='0'){
		
			$status							= marketzend($ebay_ordersn,$ebay_tracknumber,$host,$root,$password,$dbname);
			
			echo $status."cc";
			if($status){
				$ss			="update ebay_order set ebay_status='2',ebay_markettime='$mctime' where ebay_account='$ebay_account' and   ebay_ordersn='$ebay_ordersn' ";
				echo "$ebay_ordersn  标记发出成功";
				$osn		.= $ebay_id.",";
				abcquery($ss);
			}
			
		}
		
	}
	
	
	if($type == '1'){
	$url	= 'ordermarketzend1.php?osn='.$ordersn;
	
	
	echo "<script language='javascript'>location.href='".$url."'</script>";
	}
	
	
	
	
	function abcquery($str){		
		
					$status = 0;		
					$abc	=  mysql_connect("localhost","ebaytools001","shop123456") or die("数据库连接失败");
					mysql_selectdb('samhuang_ebaytools') or die("数据连接失败");
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
		
	//	echo $ss;
		
		$result = mysql_query($ss,$did) or die("ݿѯʧ");
		
		
		$sq0			=  "update zen_orders set orders_status='3' where orders_id='$ordersid'";
		
		
	//	echo $sq0."<br>";
		$ebay_tracknumber	= mysql_escape_string($ebay_tracknumber);
		
		$sq1			=  "insert into zen_orders_status_history(orders_id,orders_status_id,date_added,customer_notified,comments)";
		$sq1		    .= " values('$ordersid','3','$nowtime','1','$ebay_tracknumber')";
		//echo $sq1."<br>";
		
		
		$status			= 0;
		
		if(mysql_query($sq0,$did) && mysql_query($sq1,$did)){
		
			$status     =1;
			
		}
		
		mysql_close($did);
		
							
		return $status;				
	
	
	
	
	}
	


?>
