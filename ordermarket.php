<?php 
include "include/config.php";
include "MarketplaceWebService/Samples/S.php";
error_reporting(0);


	$order		= $_REQUEST['ordersn'];
	$order		= explode(",",$order);
	$type		= $_REQUEST['type'];
	
	for($i=0;$i<count($order);$i++){
	
		
		if($order[$i] != ""){
		
			$sn			= $order[$i];
			$sq			= "select ebay_combine,ebay_id,ebay_tracknumber,ebay_carrier,ebay_account,ebay_ordersn,ebay_markettime from ebay_order where ebay_id='$sn'";
			$sqa		= $dbcon->execute($sq);
			$sq			= $dbcon->getResultArray($sqa);
			$dbcon->free_result($sqa);
			
			
			$corder		 = $sq[0]['ebay_combine'];			
			$corder		 = explode('#',$corder);
			
			$ebay_id					= $sq[0]['ebay_id'];		
			$ebay_tracknumber			= $sq[0]['ebay_tracknumber'];
			$ebay_carrier				= $sq[0]['ebay_carrier'];
			
			$account					= $sq[0]['ebay_account'];
			$osn						= $sq[0]['ebay_ordersn'];		
			$ebay_markettime			= $sq[0]['ebay_markettime'];	
			
			$ebay_markettime	= '';
			if($ebay_markettime == ''){


			
			$sql 		 = "select ebay_token,AWS_ACCESS_KEY_ID from ebay_account where ebay_user='$user' and ebay_account='$account'";
			$sqla		 = $dbcon->execute($sql);
			$sql		 = $dbcon->getResultArray($sqla);
			$dbcon->free_result($sqla);
			
			$token					 = $sql[0]['ebay_token'];   // ebay toekn
			$AWS_ACCESS_KEY_ID		 = $sql[0]['AWS_ACCESS_KEY_ID']; // amazon key
			
			
			
			/* 取得评介内容 */
			$vv			 = "select feedbackstring from ebay_config where ebay_user ='$user' ";
			$vva		 = $dbcon->execute($vv);
			$vv			 = $dbcon->getResultArray($vva);
			$dbcon->free_result($vva);
			
			$feedbackstring		= $vv[0]['feedbackstring'];
			$feedbackstring     = explode('&&',$feedbackstring);
			$feedbackstring		= $feedbackstring[rand(0,count($feedbackstring) - 1 )];
			if($feedbackstring == '' ) $feedbackstring = 'Good Buyer ';
			
			
			
			if($AWS_ACCESS_KEY_ID == ''){
			CompleteSale($token,$osn,$type,$feedbackstring,$ebay_tracknumber,$ebay_carrier);
			}else{
			markettoamazon($ebay_id);
			}
			
			for($p=0;$p<count($corder);$p++){
			
		
				if($corder[$p] != "" && $corder[$p] != "0"){
				
					$sn			= $corder[$p];
		
					$sq			= "select ebay_account,ebay_ordersn from ebay_order where ebay_id='$sn'";
					
					
					$sq			= $dbcon->execute($sq);
					$sq			= $dbcon->getResultArray($sq);
					$account	= $sq[0]['ebay_account'];		
					$osn		= $sq[0]['ebay_ordersn'];
					$sql 		 = "select ebay_token from ebay_account where ebay_user='$user' and ebay_account='$account'";
					$sql		 = $dbcon->execute($sql);
					$sql		 = $dbcon->getResultArray($sql);
					$token		 = $sql[0]['ebay_token'];
				
					CompleteSale($token,$osn,$type,$feedbackstring,$ebay_tracknumber,$ebay_carrier);
					
				
				}
			
			}
			}else{
				
				
				echo "<br>订单已经出库";
				
				
			}
			
			
			
			
		
		
		
		}
	
	}
	


?>
