<?php
include "include/config.php";


include "top.php";




	$type	= $_REQUEST['type'];
	
	if($type == 'add'){
		
		$keys		= $_REQUEST['keys'];
		
		$ss			= "insert into ebay_ordertype(typename,ebay_user) values('$keys','$user')";
		
		
		if($dbcon->execute($ss)){
			
			$status	= " -[<font color='#33CC33'>操作记录: 记录删除成功</font>]";
			
		}else{
		
			$status = " -[<font color='#FF0000'>操作记录: 记录删除失败</font>]";
		}
	
	
	
	}
	
	
	if($type == "del"){
		
		$id	 = $_REQUEST['id'];
		$sql = "delete from ebay_ordertype where id=$id";
		if($dbcon->execute($sql)){
			
			$status	= " -[<font color='#33CC33'>操作记录: 记录删除成功</font>]";
			
		}else{
		
			$status = " -[<font color='#FF0000'>操作记录: 记录删除失败</font>]";
		}
		
		
		
	
	}else{
		
		$status = "";
		
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
	
	
		
	<td nowrap="nowrap" scope="row" >&nbsp;添加新类型：<input name="ordertype" type="text" id="ordertype" />
	<input type="button" value="添加" onclick="add()" /></td>
	</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='3'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" width='2%' class='paginationActionButtons'>&nbsp;</td>
				  <td  nowrap='nowrap' width='1%' align="right" class='paginationChangeButtons'>				  </td>
				</tr>
			</table>		</td>
	</tr><tr height='20'>
					<th scope='col' width='26%' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>编号	</div>			</th>
			
					<th scope='col' width='13%' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>订单类型</div>			</th>
			
					<th scope='col' width='13%' nowrap="nowrap">操作</th>
	</tr>
		
   <?php 
				  
				  	$sql = "select * from ebay_ordertype where ebay_user='$user'";
			
					
					$sql = $dbcon->execute($sql);
					$sql = $dbcon->getResultArray($sql);
			
				
					
					for($i=0;$i<count($sql);$i++){
						
						$typename	= $sql[$i]['typename'];
						$id			= $sql[$i]['id'];
						
						
				  ?>
                  
                  
                  
		    
 
					<tr height='20' class='oddListRowS1'>
						<td scope='row' align='left' valign="top" ><?php echo $id; ?></td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $typename; ?></td>
				
						    <td scope='row' align='left' valign="top" ><a href="#" onClick="del(<?php echo $id; ?>)">删除</a>&nbsp;</td>
			  </tr>
              
              
              
              <?php
			  
			  
			  }
			  ?>
              
		<tr class='pagination'>
		<td colspan='3'>
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
			
			location.href = 'systemuordertype.php?type=del&id='+id+"&module=system&action=订单类型";
			
		
		}
	
	
	}
	
	function add(){
		
		var keys		= document.getElementById('ordertype').value;
		location.href = 'systemuordertype.php?type=add&keys='+keys+"&module=system&action=订单类型";
		
	
	
	}



</script>