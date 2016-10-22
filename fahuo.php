<?php
include "include/config.php";


include "top.php";




	$type	= $_REQUEST['type'];
	if($type == "del"){
		
		$id	 = $_REQUEST['id'];
		$sql = "delete from ebay_fahuo where id=$id";
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
	
	
		
	<td nowrap="nowrap" scope="row" ><input tabindex='2' title='关联eBay帐号' class='button' type="button" name='button' value='添加发货流程' id='search_form_submit' onclick="location.href='fahuoadd.php?module=fahuo&action=添加发货流程'"/></td>
	</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='4'>&nbsp;			</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>编号	</div>			</th>
			
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>发货流程名称</div>			</th>
			
					<th scope='col' width='13%' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>备注	</div>			</th>
			
					<th scope='col' nowrap="nowrap">操作&nbsp;</th>
					</tr>
		
   <?php 
				  
				  	$sql = "select * from ebay_fahuo where ebay_user='$user'";
					$sql = $dbcon->execute($sql);
					$sql = $dbcon->getResultArray($sql);
				
					
					for($i=0;$i<count($sql);$i++){
						
						$id	= $sql[$i]['id'];
						$name	= $sql[$i]['name'];
						$note		= $sql[$i]['note'];
			
						
				  ?>
                  
                  
                  
		    
 
					<tr height='20' class='oddListRowS1'>
						    <td scope='row' align='left' valign="top" ><?php echo $id;?>&nbsp;</td>				
						    <td scope='row' align='left' valign="top" ><?php echo $name;?>&nbsp;</td>				
						    <td scope='row' align='left' valign="top" ><?php echo $note;?>&nbsp;</td>				
						    <td scope='row' align='left' valign="top" ><a href="fahuoadd.php?id=<?php echo $id; ?>&module=mail&action=管理流程">修改</a>&nbsp;&nbsp;&nbsp; <a href="#" onClick="del(<?php echo $id; ?>)">删除</a>&nbsp;&nbsp;&nbsp;<a href="fahuo_process.php?pid=<?php echo $id;?>&module=mail&action=管理流程" target="_blank">管理流程</a></td>
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
			
			location.href = 'fahuo.php?type=del&id='+id+"&module=fahuo&action=发货流程";
			
		
		}
	
	
	}



</script>