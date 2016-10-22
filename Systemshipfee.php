<?php
include "include/config.php";


include "top.php";




	$type	= $_REQUEST['type'];
	if($type == "del"){
		
		$id	 = $_REQUEST['id'];
		$sql = "delete from ebay_systemshipfee where id=$id";
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
	<input tabindex='2' title='添加新的发货方式' class='button' type="button" name='button' value='添加新的运费规则' id='search_form_submit' onClick="location.href='Systemshipfeeadd.php?module=system&shippingid=<?php echo $_REQUEST['shippingid'];?>&action=添加新的发货方式户'"/>
	&nbsp;<br /></td>
	</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='5'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" width='2%' class='paginationActionButtons'>&nbsp;</td>
				  <td  nowrap='nowrap' width='1%' align="right" class='paginationChangeButtons'>				  </td>
				</tr>
			</table>		</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap">
		<div style='white-space: nowrap;'width='100%' align='left'>编号	</div>			</th>
			
  <th scope='col' nowrap="nowrap">
	    <div style='white-space: nowrap;'width='100%' align='left'>名称	</div>			</th>
			
  <th scope='col' nowrap="nowrap">
<div style='white-space: nowrap;'width='100%' align='left'>
        包含国家</div>			</th>
			
		<th scope='col' nowrap="nowrap">备注</th>
		<th scope='col' nowrap="nowrap">操作</th>
	</tr>
<?php 
				  	
					$shippingid		= $_REQUEST['shippingid'];
					
					
				  	$sql = "select * from ebay_systemshipfee where shippingid='$shippingid'  ";
					$sql = $dbcon->execute($sql);
					$sql = $dbcon->getResultArray($sql);
			
					
					for($i=0;$i<count($sql);$i++){
						
						$name	 		= $sql[$i]['name'];
						$value			= $sql[$i]['value'];						
						$id				= $sql[$i]['id'];
						$note			= $sql[$i]['note'];
						
						
						
				  ?>
                  
                  
                  
		    
 
									<tr height='20' class='oddListRowS1'>
						<td scope='row' align='left' valign="top" ><?php echo $id; ?></td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $name; ?></td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $value;?> </td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $note;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" >
                            <a href="Systemshipfee.php?id=<?php echo $id; ?>&module=system&action=发货理&type=del&shippingid=<?php echo $shippingid; ?>">删除</a>
                            
                            <a href="Systemshipfeeadd.php?id=<?php echo $id; ?>&module=system&action=发货理">修改</a></td>
	  </tr>
              
              
              
              <?php
			  
			  
			  }
			  ?>
              
		<tr class='pagination'>
		<td colspan='5'>
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
			
			location.href = 'systemcarrier.php?type=del&id='+id+"&module=system&action=发货方式管理";
			
		
		}
	
	
	}



</script>