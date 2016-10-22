<?php
    error_reporting(E_ALL);
	@session_start();
	
	$_SESSION['user']	= 'vipliang';
	
	$user	= $_SESSION['user'];
	
	include "include/dbconnect.php";
	
	$dbcon	= new DBClass();

	

	include "include/eBaySession.php";
	include "include/xmlhandle.php";
	include "include/ebay_lib.php";
	include "include/cls_page.php";
	date_default_timezone_set ("Asia/Chongqing");	
	$compatabilityLevel = 551;

	
	

	
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
	
	






 ?>

<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status;?> </h2>
</div>

<div class='listViewBody'>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td width="65%">
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'>
                    
             <?php
			 
			 			$cc			= date("Y-m-d");
						
                    	$start		= date('Y-m-d',strtotime("$cc -1 days"))."T00:00:00";
					 	$end		= date('Y-m-d')."T23:59:59";
						
				
						
						
				
						$sql 		 = "select * from ebay_account where ebay_user='vipliang'";
						$sql		 = $dbcon->execute($sql);
						$sql		 = $dbcon->getResultArray($sql);
			
						for($i=0;$i<count($sql);$i++){
						
						
							$token			 = $sql[$i]['ebay_token'];
							$account		 = $sql[$i]['ebay_account'];
							
							GetSellerTransactions($start,$end,$token,$account);
							GetMemberMessages($start,$end,$token,$account);
							GetFeedback($token,$account);
							
							//echo $account.$token."<br>";
							
							
						
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


?>
<script language="javascript">
	function check(){
		
		var days	= document.getElementById('days').value;	
		var account = document.getElementById('account').value;	
		location.href='loadorder.php?days='+days+'&account='+account;
		
		
	}

</script>