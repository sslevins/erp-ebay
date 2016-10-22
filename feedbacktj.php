<?php
include "include/config.php";


include "top.php";
	
	
	$accounts			= $_REQUEST['account'];
	

	
	
	function getPostiveCount($timestart,$timeend,$account,$type){
		
		global $dbcon,$user;
		$vv		= "select * from ebay_feedback where CommentType ='$type' and ebay_user ='$user' and ( feedbacktime	 >= $timestart and feedbacktime <= $timeend ) ";
		if($account != '' ) $vv .= "  and account ='$account' ";
		$vv		= $dbcon->execute($vv);
		$vv		= $dbcon->getResultArray($vv);
		return  count($vv);
	}
	


	
 ?>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status;?> </h2>
</div>

<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
		
	<td nowrap="nowrap" scope="row" >eBay帐号：
	  <select name="account" id="account">
        <option value=""  >所有帐号</option>
        <?php 

					

					$sql	 = "select * from ebay_account as a where a.ebay_user='$user' and ($ebayacc) order by ebay_account desc ";
					
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);

					for($i=0;$i<count($sql);$i++){					

					 

					 	$account	= $sql[$i]['ebay_account'];

					 ?>
        <option value="<?php echo $account;?>"  <?php if($account == $accounts) echo 'selected="selected"';?> ><?php echo $account;?></option>
        <?php } ?>
      </select>
<input type="button" value="Search" onclick="searchs()" />
	      <br />
	      <br />
	      <table width="50%" border="1" cellspacing="5">
            <tr>
              <td>&nbsp;</td>
              <td>1 month</td>
              <td>6 month</td>
              <td>12 month</td>
              </tr>
            <tr>
              <td><img src="images/iconPos_16x16.gif" width="16" height="16" /></td>
              <td>
              <?php
			    $start						= date('Y-m-d').'23:59:59';	
				$end						= date('Y-m-d',strtotime("$start1 -30 days")).' 00:00:00';
				$timestart					= strtotime($end);
				$timeend					= strtotime($start);
				$total = getPostiveCount($timestart,$timeend,$accounts,'Positive');
				echo $total;
				
			  
			  
			  ?>
              
              
              &nbsp;</td>
              <td><?php
			    $start						= date('Y-m-d').'23:59:59';	
				$end						= date('Y-m-d',strtotime("$start1 -180 days")).' 00:00:00';
				$timestart					= strtotime($end);
				$timeend					= strtotime($start);
				$total = getPostiveCount($timestart,$timeend,$accounts,'Positive');
				echo $total;
				
			  
			  
			  ?></td>
              <td><?php
			    $start						= date('Y-m-d').'23:59:59';	
				$end						= date('Y-m-d',strtotime("$start1 -365 days")).' 00:00:00';
				$timestart					= strtotime($end);
				$timeend					= strtotime($start);
				$total = getPostiveCount($timestart,$timeend,$accounts,'Positive');
				echo $total;
				
			  
			  
			  ?></td>
              </tr>
            <tr>
              <td><img src="images/iconNeu_16x16.gif" width="16" height="16" /></td>
              <td><?php
			    $start						= date('Y-m-d').'23:59:59';	
				$end						= date('Y-m-d',strtotime("$start1 -30 days")).' 00:00:00';
				$timestart					= strtotime($end);
				$timeend					= strtotime($start);
				$total = getPostiveCount($timestart,$timeend,$accounts,'Neutral');
				echo $total;
				
			  
			  
			  ?></td>
              <td><?php
			    $start						= date('Y-m-d').'23:59:59';	
				$end						= date('Y-m-d',strtotime("$start1 -180 days")).' 00:00:00';
				$timestart					= strtotime($end);
				$timeend					= strtotime($start);
				$total = getPostiveCount($timestart,$timeend,$accounts,'Neutral');
				echo $total;
				
			  
			  
			  ?></td>
              <td><?php
			    $start						= date('Y-m-d').'23:59:59';	
				$end						= date('Y-m-d',strtotime("$start1 -365 days")).' 00:00:00';
				$timestart					= strtotime($end);
				$timeend					= strtotime($start);
				$total = getPostiveCount($timestart,$timeend,$accounts,'Neutral');
				echo $total;
				
			  
			  
			  ?></td>
              </tr>
            <tr>
              <td><img src="images/iconNeg_16x16.gif" width="16" height="16" /></td>
              <td><?php
			    $start						= date('Y-m-d').'23:59:59';	
				$end						= date('Y-m-d',strtotime("$start1 -30 days")).' 00:00:00';
				$timestart					= strtotime($end);
				$timeend					= strtotime($start);
				$total = getPostiveCount($timestart,$timeend,$accounts,'Negative');
				echo $total;
				
			  
			  
			  ?></td>
              <td><?php
			    $start						= date('Y-m-d').'23:59:59';	
				$end						= date('Y-m-d',strtotime("$start1 -180 days")).' 00:00:00';
				$timestart					= strtotime($end);
				$timeend					= strtotime($start);
				$total = getPostiveCount($timestart,$timeend,$accounts,'Negative');
				echo $total;
				
			  
			  
			  ?></td>
              <td><?php
			    $start						= date('Y-m-d').'23:59:59';	
				$end						= date('Y-m-d',strtotime("$start1 -365 days")).' 00:00:00';
				$timestart					= strtotime($end);
				$timeend					= strtotime($start);
				$total = getPostiveCount($timestart,$timeend,$accounts,'Negative');
				echo $total;
				
			  
			  
			  ?></td>
              </tr>
          </table>
	      <br />
	      <br />
	      <br /></td>
	</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 



    <div class="clear"></div>
<?php

include "bottom.php";


?>
<script language="javascript">
	

	
	function searchs(){
		var account		= document.getElementById('account').value;
		var url		= 'feedbacktj.php?account='+account+'&module=feedback';
		location.href = url;
	
	}
	
	



</script>