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
			
			$id			= $sql[$i]['id'];
			$sendid			= $sql[$i]['sendid'];
			
			
			$ss   =" update ebay_message set status='$type' , replytime ='$mctime' , replyuser ='$truename' where id ='$id'";
			
			if($dbcon->execute($ss)){
			
				$status	= " -[<font color='#33CC33'>操作记录: {$sendid} 操作成功</font>]";
					
			}else{
				
					$status = " -[<font color='#FF0000'>操作记录: {$sendid}  操作成功</font>]";
			}
			
			echo $status.'<br>';
			
				
	}
	
		
	
	
 ?>