<?php
		@session_start();
		error_reporting(0);
		
		
		
		include "include/dbconnect.php";
		$db		= new DBClass();		
		$name		 = trim($_POST['name']);
		
		
	
		$pass		 = trim($_POST['password']);		
		$sql		 = "select user,power,ebayaccounts,message,record from ebay_user where username='$name' and password='$pass'";
	
		$sqla		 = $db->execute($sql);
		$sql		 = $db->getResultArray($sqla);
		/* 释放mysql 系统资源 */
		
		
		
		$db->free_result($sqla);
		if($name !="" && $pass!=""){
		if(count($sql) >0){			
			$_SESSION['user']			= $sql[0]['user'];
			$_SESSION['power'] 			= $sql[0]['power'];
			$_SESSION['truename']		= $name;
			$_SESSION['ebayaccounts']	= $sql[0]['ebayaccounts'];
			$_SESSION['messages']		= $sql[0]['message'];
			$_SESSION['pagesize']		= $sql[0]['record']?$sql[0]['record']:25;
			
			date_default_timezone_set ("Asia/Chongqing");
			$ip					= $_SERVER["REMOTE_ADDR"];
			$time				= date('Y-m-d H:i:s');
			

			
			$vvsql				= "update ebay_user set logtime='$time',ip='$ip' where username	='$name' ";
			$db->execute($vvsql);
			
			
			$sql		 = "select * from ebay_config where ebay_user='".$sql[0]['user']."'";
			
			
			$sql		 = $db->execute($sql);
			$sql		 = $db->getResultArray($sql);
			
			$expriedate		= $sql[0]['expriedate'];
			
			
			if($expriedate != ''){
						
						$startdate			= strtotime(date('Y-m-d H:i:s'));
						$enddate			= strtotime($expriedate);
						
						if($startdate >= $enddate){
						echo '<font color=red>服务已经过期,请与管理员联系, 老用户价格不变</font>';
						die();
						}
			}
			
			echo "<script>location.href='orderindex.php?module=orders&ostatus=0&action=未付款'</script>";	
			
		}else{
		
			
			$errormessage	= "用户名或密码错误!";
			echo "<script>alert('".$errormessage."');history.go(-1);</script>";
		
		
		}
		}else{
		
		
			$errormessage	= "用户名或密码不能为空!";
			echo "<script>alert('".$errormessage."');history.go(-1);</script>";
		}
?>

