<?php
/*
**11月27日 添加评价人id搜索条件
**添加人：胡耀龙
*/
include "include/config.php";


include "top.php";



$account			= $_REQUEST['account'];
$itemnumber		= $_REQUEST['itemnumber'];
$strat			= $_REQUEST['strat'];
$end			= $_REQUEST['end'];
	
 ?>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status;?> </h2>
</div>

<div class='listViewBody'>

<script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>
<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
		
	<td nowrap="nowrap" scope="row" >eBay帐号
	  <select name="account" id="account">
      <option value="">无</option>
                    <?php 
					
					$sql	 = "select * from ebay_account as a where ebay_user='$user' and ($ebayacc) order by ebay_account desc ";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 
					 	$accounts	= $sql[$i]['ebay_account'];
					 ?>
                      <option value="<?php echo $accounts;?>" <?php if($account == $accounts) echo 'selected="selected"'; ?>><?php echo $accounts;?></option>
                    <?php } ?>
                    </select>
		&nbsp; itemnumber：
	    <input id='itemnumber' name='itemnumber' value="<?php echo $itemnumber;?>" type='text'/>
		时间段：
		<input name="start" id="start" type="text" onclick="WdatePicker()" value="<?php echo $strat;?>" />
	~
	<input name="end" id="end" type="text" onclick="WdatePicker()" value="<?php echo $end;?>" />
	   <input name="" type="button" value="查找" onclick="searchorders()" /> &nbsp;&nbsp;<input name="" type="button" value="查询结果导出" onclick="searchtoxls()" /></td>
</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='8'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" width='2%' class='paginationActionButtons'>&nbsp;</td>
				  <td  nowrap='nowrap' width='1%' align="right" class='paginationChangeButtons'>				  </td>
				</tr>
			</table>		</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>itemnumber</div></th>
					
					<th scope='col' nowrap="nowrap">eBay帐号</th>
			
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>好评</div></th>
			
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>中评</div>			</th>
			
					<th scope='col' nowrap="nowrap"><span class="left_bt2">差评</span></th>
                    <th scope='col' nowrap="nowrap">SKU</th>
			
		</tr>
		 <?php 
          
          $sql			= "select * from ebay_feedback where 1";
		  
		 
		  
		  if($account != '') 		 $sql .= " and account='$account' ";
		  if($itemnumber != '')	 $sql .= " and ItemID='$itemnumber' ";
		  //if($strat && $end)  $sql .= " and feedbacktime>='".strtotime($strat.' 00:00:00')."' and feedbacktime>='".strtotime($end.' 23:59:59')."'";
		  
		  $sql .= ' and ebay_user=\''.$user.'\' and ('.$ebayacc2.') group by ItemID,account';
		 // echo $sql;
          $query		= $dbcon->query($sql);
          $total		= $dbcon->num_rows($query);
          
          $pageindex  	= ( isset($_GET['pageindex']) )?$_GET['pageindex']:1;
		  $limit 		= " limit ".($pageindex-1)*$pagesize.",$pagesize";
		  $page			= new page(array('total'=>$total,'perpage'=>$pagesize));
		  $sql 			= $sql.$limit;
		  $sql			= $dbcon->execute($sql);
		  $sql			= $dbcon->getResultArray($sql);
		  for($i=0;$i<count($sql);$i++){
		  	
			$ItemID	= $sql[$i]['ItemID'];
			$account= $sql[$i]['account'];
			$vv	= "select count(*) as cc from ebay_feedback where ItemID='$ItemID' and account='$account' and CommentType='Positive' and ebay_user='$user'";
			if($strat && $end)  $vv .= " and feedbacktime>='".strtotime($strat.' 00:00:00')."' and feedbacktime<='".strtotime($end.' 23:59:59')."'";
			//echo $vv;
			$vv			= $dbcon->execute($vv);
			$vv			= $dbcon->getResultArray($vv);
			$Positivenumber = $vv[0]['cc']?$vv[0]['cc']:0;
			$vv	= "select count(*) as cc from ebay_feedback where ItemID='$ItemID' and account='$account' and CommentType='Neutral' and ebay_user='$user'";
			if($strat && $end)  $vv .= " and feedbacktime>='".strtotime($strat.' 00:00:00')."' and feedbacktime<='".strtotime($end.' 23:59:59')."'";
			$vv			= $dbcon->execute($vv);
			$vv			= $dbcon->getResultArray($vv);
			$Neutralnumber = $vv[0]['cc']?$vv[0]['cc']:0;
			$vv	= "select count(*) as cc from ebay_feedback where ItemID='$ItemID' and account='$account' and CommentType='Negative' and ebay_user='$user'";
			if($strat && $end)  $vv .= " and feedbacktime>='".strtotime($strat.' 00:00:00')."' and feedbacktime<='".strtotime($end.' 23:59:59')."'";
			$vv			= $dbcon->execute($vv);
			$vv			= $dbcon->getResultArray($vv);
			$Negativenumber = $vv[0]['cc']?$vv[0]['cc']:0;
			
			
			$vv = "select sku from ebay_orderdetail where ebay_itemid ='$ItemID'";
			$vv			= $dbcon->execute($vv);
			$vv			= $dbcon->getResultArray($vv);
			$sku		= $vv[0]['sku'];
			
          ?>
          
              
              
                  
         		<tr height='20' class='oddListRowS1'>
						<td scope='row' align='left' valign="top" ><?php echo $ItemID;?></td>
						
						<td scope='row' align='left' valign="top" ><?php echo $account;?>&nbsp;</td>
						<td scope='row' align='left' valign="top" ><?php echo $Positivenumber;?>&nbsp;</td>			
						<td scope='row' align='left' valign="top" ><?php echo $Neutralnumber;?>&nbsp;</td>
						<td scope='row' align='left' valign="top" ><?php echo $Negativenumber;?>&nbsp;</td>
                        <td scope='row' align='left' valign="top" ><?php echo $sku;?>&nbsp;</td>
              </tr>
       
 
               <?php } ?>
		<tr class='pagination'>
		<td colspan='8'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'><div align="center"><?    echo '<br><center>'.$page->show(2)."</center>";//输出分页 ?> 
                </div></td>
					</tr>
			</table>		</td>
	</tr></table>


    <div class="clear"></div>
<?php

include "bottom.php";


?>
<script language="javascript">






	function searchorders(){
	
		

		var account 		= document.getElementById('account').value;
		var itemnumber	 	= document.getElementById('itemnumber').value;
		var strat 			= document.getElementById('start').value;
		var end			 	= document.getElementById('end').value;
		
		location.href		= 'feedbackitbb.php?account='+account+'&itemnumber='+itemnumber+'&end='+end+'&strat='+strat+"&module=feedback&action=Feedback管理";
		
		
		
		
	}

	function searchtoxls(){
	
		

		var account 		= document.getElementById('account').value;
		var itemnumber	 	= document.getElementById('itemnumber').value;
		var strat 			= document.getElementById('start').value;
		var end			 	= document.getElementById('end').value;
		
		location.href		= 'feedbackitbbxls.php?account='+account+'&itemnumber='+itemnumber+'&end='+end+'&strat='+strat+"&module=feedback&action=Feedback管理";
		
		
		
		
	}
	
	




</script>