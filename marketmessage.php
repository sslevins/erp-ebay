<?php
include "include/config.php";


	
	
	$orders		= explode(",",$_REQUEST['bill']);
	$type		= $_REQUEST['type'];
	
	for($g=0;$g<count($orders);$g++){

		

		

				$sn 	=  $orders[$g];

				if($sn != ""){

				

					$ertj	.= " message_id='$sn' or";

				}

			}
	
	
		
		
	$ertj			 = substr($ertj,0,strlen($ertj)-3);
	
	
	$sql			 = "select * from ebay_message where ebay_user ='$user' and ($ertj) ";
	$sql			 = $dbcon->execute($sql);
	$sql			 = $dbcon->getResultArray($sql);
	for($i=0;$i<count($sql);$i++){
			
			$message_id			= $sql[$i]['message_id'];
			$ebay_account		= $sql[$i]['ebay_account'];
			
			$sendid			= $sql[$i]['sendid'];
			
			$id					= $sql[$i]['id'];
			$ss			 = "select * from ebay_account where ebay_account ='$ebay_account'  ";
			$ss			 = $dbcon->execute($ss);
			$ss			 = $dbcon->getResultArray($ss);
			$token		 = $ss[0]['ebay_token'];
			$status 	 = ReviseMyMessages($token,$message_id,$type);
			
			if($status == 'Success'){
				
				if($type == 'Read')   $ss		= "update ebay_message set `Read`='1' where id ='$id'";
				if($type == 'UnRead') $ss		= "update ebay_message set `Read`='0' where id ='$id'";
				$dbcon->execute($ss);
			}else{
				
				$status = '<font color=red>标记失败</font>';
			
			}
			
			
			echo $sendid.' 同步状态:'.$status.'<br>';
			
			
			
				
	}
	
		
	if($dbcon->execute($sql)){
			
		$status	= " -[<font color='#33CC33'>操作记录: 记录删除成功</font>]";
			
	}else{
		
			$status = " -[<font color='#FF0000'>操作记录: 记录删除失败</font>]";
	}
	
 ?>