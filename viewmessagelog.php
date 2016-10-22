<?php
include "include/config.php";


include "top.php";

$id		= $_REQUEST['id'];



	
 ?>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'];?> </h2>
</div>

<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
		
	<td nowrap="nowrap" scope="row" >
	<input tabindex='2' title='关联eBay帐号' class='button' type="button" name='button' value='添加用户' id='search_form_submit' onClick="location.href='systemusersadd.php?module=system&action=添加用户'"/>
	&nbsp;</td>
	</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='4'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" width='2%' class='paginationActionButtons'>&nbsp;</td>
				  <td  nowrap='nowrap' width='1%' align="right" class='paginationChangeButtons'>				  </td>
				</tr>
			</table>		</td>
	</tr><tr height='20'>
					<th scope='col' width='26%' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>执行序号</div>			</th>
			
					<th scope='col' width='13%' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>发送信件内容		</div>			</th>
			
					<th scope='col' width='13%' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>
                                                                                       执行状态</div>			</th>
			
					<th scope='col' width='13%' nowrap="nowrap">执行时间</th>
	</tr>
   <?php 
				  
				  	$sql = "select * from ebay_messagelog where order_id=$id";
				
					
					
					$sql = $dbcon->execute($sql);
					$sql = $dbcon->getResultArray($sql);
			
					
					for($i=0;$i<count($sql);$i++){
						
						$ordernumber 				= $sql[$i]['ordernumber'];
						$messagetemplate			= nl2br($sql[$i]['messagetemplate']);
						$time						= $sql[$i]['time'];			
						$status						= $sql[$i]['status'];
						
						
				  ?>
                  
                  
                  
		    
 
						<tr height='20' class='oddListRowS1'>
						<td scope='row' align='left' valign="top" ><?php echo $ordernumber;?>&nbsp;</td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $messagetemplate;?>&nbsp;</td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $status;?>&nbsp;</td>
				
						    <td scope='row' align='left' valign="top" ><?php echo date('Y-m-d H:i:s',$time);?>&nbsp;</td>
	  </tr>
              
              
              
              <?php
			  
			  
			  }
			  ?>
              
		<tr class='pagination'>
		<td colspan='4'>
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
	
	function del(id){
		if(confirm('您确认删除此条记录吗')){
			
			location.href = 'systemusers.php?type=del&id='+id+"&module=system&action=汇率设置";
			
		
		}
	
	
	}



</script>