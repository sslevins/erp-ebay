<?php
	@session_start();
	error_reporting(0);
	
	
	$_SESSION['user']	= 'vipadmin';
	$user	= $_SESSION['user'];
	include "include/dbconnect.php";
	$dbcon	= new DBClass();
	date_default_timezone_set ("Asia/Chongqing");	

	include "include/eBaySession.php";
	include "include/xmlhandle.php";
	include "include/ebay_lib.php";
	include "include/cls_page.php";
	$compatabilityLevel = 551;
	

	date_default_timezone_set('UTC'); 
	
	$devID		= "cddef7a0-ded2-4135-bd11-62db8f6939ac";
	$appID		= "Survyc487-9ec7-4317-b443-41e7b9c5bdd";
	$certID		= "b68855dd-a8dc-4fd7-a22a-9a7fa109196f";
	
	
	$serverUrl	= "https://api.ebay.com/ws/api.dll";
	
    $siteID = 0;  
    $detailLevel = 0;
	$nowtime	= date("Y-m-d H:i:s");
	$nowd		= date("Y-m-d");
	$Sordersn	= "eBay";
	$pagesize=20;//每页显示的数据条目数
	$mctime		= strtotime($nowtime);
	
	

                    	$cc			= date("Y-m-d H:i:s");
	
						
				
	
					 	
						$sql 		 = "select * from ebay_account where ebay_user='vipadmin' and ebay_token != '' and ebay_account = 'dealex2011'";
						//$sql 		 = "select * from ebay_account where ebay_user='vipadmin' and ebay_token != ''  ";
						
						$sql		 = $dbcon->execute($sql);
						$sql		 = $dbcon->getResultArray($sql);
			
						for($i=0;$i<count($sql);$i++){
						
						$token			 = $sql[$i]['ebay_token'];
					    $account		 = $sql[$i]['ebay_account'];
						GetFeedback($token,$account);
						
						
						}
						
			


					
					?>    
                    
                    
                    &nbsp;				  </td>
			    </tr>
			</table>		</td>
	</tr>
		

              
		<tr class='pagination'>
		<td>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'></td>
					</tr>
			</table>		</td>
	</tr></table>


    <div class="clear"></div>
<?php

include "bottom.php";

echo date('Y-m-d H:i:s');

?>
