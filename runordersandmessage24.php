<?php
	@session_start();
	error_reporting(0);
	$_SESSION['user']	= 'vipchen';
	
	$user	= $_SESSION['user'];
	
	include "include/config.php";
	
	$dbcon	= new DBClass();

	date_default_timezone_set ("Asia/Chongqing");	
	//date_default_timezone_set ( 'America/New_York' ); 
	date_default_timezone_set('UTC'); 
    $siteID = 0;  
    $detailLevel = 0;
	$nowtime	= date("Y-m-d H:i:s");
	$nowd		= date("Y-m-d");
	$Sordersn	= "eBay";
	$pagesize=20;//每页显示的数据条目数
	$mctime		= strtotime($nowtime);
	
	
                    	
			   			 $cc			= date("Y-m-d H:i:s");
						$start		= date('Y-m-d H:i:s',strtotime("$cc -24 hours"));
						$start		= date('Y-m-d',strtotime($start)).'T'.date('H:i:s',strtotime($start));
						$end		= date('Y-m-d',strtotime("$cc +0 days")).'T'.date('H:i:s',strtotime($cc));
			
						

						
						
						$sql 		 = "select * from ebay_account where ebay_user='vipchen' and ebay_token != '' order by id desc ";
						$sql		 = $dbcon->execute($sql);
						$sql		 = $dbcon->getResultArray($sql);
						for($i=0;$i<count($sql);$i++){
						
							$token			 = $sql[$i]['ebay_token'];
							$account		 = $sql[$i]['ebay_account'];
							echo '<br><br>系统正在同步'.$account.'<br><br>';
							
							
							
							GetSellerTransactions($start,$end,$token,$account,$type=0);
							GetMemberMessages($start,$end,$token,$account);
							
							
						
							
												
						}
						 $dbcon->close(); 
						
						?>
						