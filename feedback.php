<?php
/*
**11月27日 添加评价人id搜索条件
**添加人：胡耀龙
*/
include "include/config.php";


include "top.php";



 $account			= $_REQUEST['account'];
		  $feedbacktype		= $_REQUEST['feedbacktype'];
		  $sorts			= $_REQUEST['sorts'];
		  $userid			= $_REQUEST['userid'];
		
	
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
	  &nbsp; 评介类型：
	  <select name="feedbacktype" id="feedbacktype">
		<option value="">所有类型</option>
	    <option value="Positive" <?php if($feedbacktype == 'Positive') echo 'selected="selected"';?>>Positive</option>
         <option value="Neutral" <?php if($feedbacktype == 'Neutral') echo 'selected="selected"';?>>Neutral</option>
          <option value="Negative" <?php if($feedbacktype == 'Negative') echo 'selected="selected"';?>>Negative</option>
          

	    </select> 
		&nbsp; FROM：

	    <input id='userid' name='userid' value="<?php echo $userid;?>" type='text'/>
	   order by
	   <select name="sorts" id="sorts">
	     <option value="">无</option>
	     <option value="order by feedbacktime desc" <?php if($sorts == 'order by feedbacktime desc') echo 'selected="selected"';?>>orderby feedbacktime desc</option>
	     <option value="order by feedbacktime asc" <?php if($sorts == 'order by feedbacktime asc') echo 'selected="selected"';?>>orderby feedbacktime asc</option>
	     </select><input name="" type="button" value="查找" onclick="searchorders()" /></td>
</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='7'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" width='2%' class='paginationActionButtons'>&nbsp;</td>
				  <td  nowrap='nowrap' width='1%' align="right" class='paginationChangeButtons'>				  </td>
				</tr>
			</table>		</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>编号</div></th>
					<th scope='col' nowrap="nowrap">eBay帐号</th>
			
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>Feedback</div></th>
			
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>From/Price</div>			</th>
			
					<th scope='col' nowrap="nowrap"><span class="left_bt2">Date / Time</span></th>
		<th scope='col' nowrap="nowrap"><span class="left_bt2">状态</span></th>
		<th scope='col' nowrap="nowrap">
		  <div style='white-space: nowrap;'width='100%' align='left'></div>			</th>
			
		</tr>
		 <?php 
          
          $sql			= "select * from ebay_feedback where ebay_user='$user' and ($ebayacc2)";
		  
		 
		  
		  if($account != '') 		 $sql .= " and account='$account' ";
		  if($feedbacktype != '')	 $sql .= " and CommentType='$feedbacktype' ";
		   if($userid != '')	 $sql .= " and CommentingUser='$userid' ";
		  if($sorts != '') 			 $sql .= $sorts;
		  if($sorts == '') 			 $sql .= " order by CommentTime  desc ";
	
		   
		  
		  
		  
          $query		= $dbcon->query($sql);
          $total		= $dbcon->num_rows($query);
          
          $pageindex  	= ( isset($_GET['pageindex']) )?$_GET['pageindex']:1;
		  $limit 		= " limit ".($pageindex-1)*$pagesize.",$pagesize";
		  $page			= new page(array('total'=>$total,'perpage'=>$pagesize));
		  $sql 			= $sql.$limit;
		  $sql			= $dbcon->execute($sql);
		  $sql			= $dbcon->getResultArray($sql);
		  for($i=0;$i<count($sql);$i++){
		  	
			$CommentType	= $sql[$i]['CommentType'];
			$image			= "";
			
			if($CommentType  == "Negative"){
				
				$image		= "images/iconNeg_16x16.gif";
				
			}else if($CommentType == "Neutral"){
				
				$image		= "images/iconNeu_16x16.gif";
			}else if($CommentType == "Positive"){
				
				$image		= "images/iconPos_16x16.gif";
			
			}
          	
			$CommentText		 = $sql[$i]['CommentText'];
			$ItemTitle 			 = $sql[$i]['ItemTitle'];
			$CommentingUser		 = $sql[$i]['CommentingUser'];
			$currencyID			 = $sql[$i]['currencyID'];
			$ItemPrice			 = $sql[$i]['ItemPrice'];
			$CommentTime	 	 = $sql[$i]['CommentTime'];
			$ItemID				 = $sql[$i]['ItemID'];
			$account			 = $sql[$i]['account'];
			
			$FeedbackID			 = $sql[$i]['FeedbackID'];
			
			
			$id					 = $sql[$i]['id'];
			
			$buyerstatus			 = $sql[$i]['buyerstatus']?"images/iconFdbkPosBlu_20x20.gif": "../images/iconFdbkPosBlu_20x20.gif";
			$sellerstatus			 = $sql[$i]['sellerstatus']?"images/iconFdbkBlu_16x16.gif": "../images/iconFdbkGry_20x20.gif";
			
          ?>
          
              
              
                  
         		<tr height='20' class='oddListRowS1'>
						<td scope='row' align='left' valign="top" ><?php echo $FeedbackID;?></td>
						<td scope='row' align='left' valign="top" ><?php echo $account;?>&nbsp;</td>
				
						    <td scope='row' align='left' valign="top" >
							<?php echo $CommentText; ?>                            </td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $CommentingUser."<br>".$currencyID."&nbsp;&nbsp;".$ItemPrice; ?></td>
				
						    <td scope='row' align='left' valign="top" ><?php echo date('Y-m-d H:i:s',strtotime($CommentTime)); ?><BR>
            <a href="http://cgi.ebay.com/ws/eBayISAPI.dll?ViewItem&item=<?php echo $ItemID; ?>" target="_blank">View Item</a>
            
            &nbsp;</td>
						    <td scope='row' align='left' valign="top" >
                            <img src="<?php echo $image;?>" width="20" height="20" />
                            </td>
						    <td scope='row' align='left' valign="top" >&nbsp;</td>
              </tr>
       
 
               <?php } ?>
		<tr class='pagination'>
		<td colspan='7'>
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
		var feedbacktype 	= document.getElementById('feedbacktype').value;
		var userid 	= document.getElementById('userid').value;
		var sorts		 	= document.getElementById('sorts').value;
		
		location.href		= 'feedback.php?account='+account+'&feedbacktype='+feedbacktype+'&sorts='+sorts+'&userid='+userid+"&module=feedback&action=Feedback管理";
		
		
		
		
	}

	
	
	




</script>