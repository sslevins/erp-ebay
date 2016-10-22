<?php
	@session_start();
	error_reporting(0);
	date_default_timezone_set ("Asia/Chongqing");	
	include "include/dbconnect.php";
	include "include/eBaySession.php";
	include "include/xmlhandle.php";
	include "include/ebay_lib.php";
	include "include/cls_page.php";
	include "include/ebay_liblist.php";
	$dbcon	= new DBClass();
	
	$siteID = 0;  
    $detailLevel = 0;
	$nowtime	= date("Y-m-d H:i:s");
	$nowd		= date("Y-m-d");
	$Sordersn	= "eBay";
	$pagesize	=20;//每页显示的数据条目数
	$mctime		= strtotime($nowtime);
	
	
	$compatabilityLevel = 551;
	$devID		= "cddef7a0-ded2-4135-bd11-62db8f6939ac";
	$appID		= "Survyc487-9ec7-4317-b443-41e7b9c5bdd";
	$certID		= "b68855dd-a8dc-4fd7-a22a-9a7fa109196f";
	$serverUrl	= "https://api.ebay.com/ws/api.dll";


	
	
	
	$cc			= date("Y-m-d H:i:s");
	$end		= date('Y-m-d',strtotime("$cc +0 days")).'T'.date('H:i:s',strtotime($cc));
	
	$vv				= "select distinct user  from ebay_user where   user = 'vipchi'  or user = 'vipmt' or user = 'silent' or user = 'viphong' or user = 'vip929' or user = 'yy2894' or user = 'survy' or user = 'viperp' or user = 'vipyx' or user ='vipfjadm'  or user ='vipnick'  or user ='vip492'  or user ='sz108' ";
	$vv				= $dbcon->execute($vv);
	$vv				= $dbcon->getResultArray($vv);
	
	for($j=0;$j<count($vv);$j++){
		$user				= $vv[$j]['user'];
		$ss							= "select * from ebay_config WHERE `ebay_user` ='$user' LIMIT 1";
		$ss							= $dbcon->execute($ss);
		$ss							= $dbcon->getResultArray($ss);
		$defaultstoreid				= $ss[0]['storeid'];
		$notesorderstatus			= $ss[0]['notesorderstatus'];
		$auditcompleteorderstatus	= $ss[0]['auditcompleteorderstatus'];
		$hackorerstatus				= $ss[0]['hackorer'];
		$_SESSION['user']			=  $user;
		$sql 		 = "select ebay_token,ebay_account from ebay_account where ebay_user='$user' and ebay_token != '' ";
		$sql		 = $dbcon->execute($sql);
		$sql		 = $dbcon->getResultArray($sql);
		
		
		for($i=0;$i<count($sql);$i++){
			$token		= $sql[$i]['ebay_token'];
			$account	= $sql[$i]['ebay_account'];
				$start		= date('Y-m-d H:i:s',strtotime("$cc -1200 minutes"));
				$start		= date('Y-m-d',strtotime($start)).'T'.date('H:i:s',strtotime($start));		
				GetMemberMessages($start,$end,$token,$account,$type=1);
				
				
		}

	}

	
	
	

	
	
	
	
					
	
	
	
						

