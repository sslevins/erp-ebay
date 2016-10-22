<?php
include "include/config.php";


include "top.php";




	$type	= $_REQUEST['type'];
	if($type == "del"){
		
		$id	 = $_REQUEST['id'];
		$sql = "delete from ebay_topmenu where id=$id";
		
		
		$ss	= "select ebay_id from ebay_order where ebay_status ='$id'  and ebay_combine!='1'";
		$ss	= $dbcon->execute($ss);
		$ss	= $dbcon->getResultArray($ss);
		
		
		if(count($ss) > 0){
		
			
			echo "[<font color='#FF0000'>此分类中有数据，不能删除，请先移掉订单数据</font>";
			die();
			
		
		}

		
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
	
	
		
	<td nowrap="nowrap" scope="row" >
	<input tabindex='2' class='button' type="button" name='button' value='添加新分类' id='search_form_submit' onClick="location.href='systemcustommenuadd.php?module=system&action=Custom Menu'"/>
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
					<th scope='col' width='13%' nowrap="nowrap">订单状态ID</th>
					<th scope='col' width='13%' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>排序</div>			</th>
			
					<th scope='col' width='13%' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>分类名称</div>			</th>
			
					<th scope='col' width='13%' nowrap="nowrap">操作</th>
	</tr>
   <?php 
				  
				  	$sql = "select name,ordernumber,id from ebay_topmenu where ebay_user='$user' and name != '' order by ordernumber ";
					$sql = $dbcon->execute($sql);
					$sql = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){
						$name	 	= $sql[$i]['name'];
						$order		= $sql[$i]['ordernumber'];						
						$id			= $sql[$i]['id'];
				  ?>
									<tr height='20' class='oddListRowS1'>
									  <td scope='row' align='left' valign="top" ><?php echo $id;?>&nbsp;</td>
						<td scope='row' align='left' valign="top" ><?php echo $order; ?></td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $name;?> </td>
				
						    <td scope='row' align='left' valign="top" >
                            
                            
                            <a href="systemcustommenuadd.php?id=<?php echo $id; ?>&module=system&action=添加订单分类">编辑</a> <a href="#" onClick="del(<?php echo $id; ?>)">删除</a>&nbsp;</td>
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
		if(confirm('Do you want to delete?')){
			
			location.href = 'systemcustommenu.php?type=del&id='+id+"&module=system&action=Custom Menu";
			
		
		}
	
	
	}



</script>