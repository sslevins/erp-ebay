<?php
include "include/config.php";


include "top.php";




	$type	= $_REQUEST['type'];
	
	if($type == 'add'){
		
		$keys		= $_REQUEST['keys'];
		
		$ss			= "insert into ebay_goodsstatus(status,ebay_user) values('$keys','$user')";
		
		
		if($dbcon->execute($ss)){
			
			$status	= " -[<font color='#33CC33'>操作记录: 记录添加成功</font>]";
			
		}else{
		
			$status = " -[<font color='#FF0000'>操作记录: 记录添加失败</font>]";
		}
	
	
	
	}
	if($type == 'mod'){
		
		$keys		= $_REQUEST['keys'];
		$id	 		= $_REQUEST['id'];
		$ss			= "update ebay_goodsstatus set status='$keys' where id = $id";
		
		
		if($dbcon->execute($ss)){
			
			$status	= " -[<font color='#33CC33'>操作记录: 记录修改成功</font>]";
			
		}else{
		
			$status = " -[<font color='#FF0000'>操作记录: 记录修改失败</font>]";
		}
	
	
	
	}
	
	if($type == "del"){
		
		$id	 = $_REQUEST['id'];
		$sql = "delete from ebay_goodsstatus where id=$id";
		if($dbcon->execute($sql)){
			
			$status	= " -[<font color='#33CC33'>操作记录: 记录删除成功</font>]";
			
		}else{
		
			$status = " -[<font color='#FF0000'>操作记录: 记录删除失败</font>]";
		}
		
		
		
	
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
	
	
		
	<td nowrap="nowrap" scope="row" >&nbsp;添加新类型：<input name="goodsstatus" type="text" id="goodsstatus" />
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
				<div style='white-space: nowrap;'width='100%' align='left'>物品状态</div>			</th>
			
					<th scope='col' width='13%' nowrap="nowrap">操作</th>
	</tr>
		
   <?php 
				  
				  	$sql = "select * from ebay_goodsstatus where ebay_user='$user'";
			
					
					$sql = $dbcon->execute($sql);
					$sql = $dbcon->getResultArray($sql);
			
				
					
					for($i=0;$i<count($sql);$i++){
						
						$status	= $sql[$i]['status'];
						$id			= $sql[$i]['id'];
						
						
				  ?>
                  
                  
                  
		    
 
					<tr height='20' class='oddListRowS1'>
						<td scope='row' align='left' valign="top" ><?php echo $id; ?></td>
				
						    <td scope='row' align='left' valign="top" ><input name="status<?php echo $id; ?>" type="text" id="status<?php echo $id; ?>" value="<?php echo $status; ?>"/></td>
							<td scope='row' align='left' valign="top" ><a href="#" onClick="mod(<?php echo $id; ?>)">修改</a>&nbsp;&nbsp;
						    <a href="#" onClick="del(<?php echo $id; ?>)">删除</a>&nbsp;</td>
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
			
			location.href = 'systemgoodsstatus.php?type=del&id='+id+"&module=system&action=物品类型定义";
			
		
		}
	
	
	}
	
	function add(){
		
		var keys		= document.getElementById('goodsstatus').value;
		location.href = 'systemgoodsstatus.php?type=add&keys='+keys+"&module=system&action=物品类型定义";
		
	
	
	}
	function mod(id){
		
		var keys		= document.getElementById('status'+id).value;
		location.href = 'systemgoodsstatus.php?type=mod&keys='+keys+"&id="+id+"&module=system&action=物品类型定义";
		
	
	
	}


</script>