<?php
include "include/config.php";


include "top.php";



    $cpower	= explode(",",$_SESSION['power']); 
	$type	= $_REQUEST['type'];
	if($type == "del"){
		
		$id	 = $_REQUEST['id'];
		$sql = "delete from  ebay_packingmaterial where id=$id";
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
<?php if(in_array("s_mm_add",$cpower)){?>	<input tabindex='2' title='关联eBay帐号' class='button' type="button" name='button' value='添加' id='search_form_submit' onClick="location.href='packingmaterialadd.php?module=warehouse&action=包装材料管理'"/><?php }?>
	&nbsp;</td>
	</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='7'>&nbsp;			</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>编号</div>			</th>
			
					<th scope='col' nowrap="nowrap">型号</th>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>包材规格</div>			</th>
			
					<th scope='col' nowrap="nowrap">包材重量</th>
					<th scope='col' nowrap="nowrap">价格</th>
					<th scope='col' nowrap="nowrap">备注</th>
					<th scope='col'  nowrap="nowrap">操作</th>
	</tr>
		
   <?php 
				  
				  	$sql = "select * from  ebay_packingmaterial where ebay_user='$user'";									
					$sql = $dbcon->execute($sql);
					$sql = $dbcon->getResultArray($sql);
				
					for($i=0;$i<count($sql);$i++){
						
						$id						= $sql[$i]['id'];
						$model					= $sql[$i]['model'];						
						$rules					= $sql[$i]['rules'];
						$notes					= $sql[$i]['notes'];
						$weight					= $sql[$i]['weight'];
						$price					= $sql[$i]['price'];
						
						
						
				  ?>
                  
                  
                  
		    
 
					<tr height='20' class='oddListRowS1'>
						    <td scope='row' align='left' valign="top" ><?php echo $id; ?></td>				
						    <td scope='row' align='left' valign="top" ><?php echo $model;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $rules;?>&nbsp;</td>				
						    <td scope='row' align='left' valign="top" ><?php echo $weight;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $price;?></td>
						    <td scope='row' align='left' valign="top" ><?php echo $notes;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php if(in_array("s_mm_modify",$cpower)){?><a href="packingmaterialadd.php?storeid=<?php echo $id; ?>&module=warehouse&action=包装材料管理">修改</a><?php }?> <?php if(in_array("s_mm_delete",$cpower)){?><a href="#" onClick="del(<?php echo $id; ?>)">删除</a><?php }?>&nbsp;</td>
			 		</tr>
              
              
              
              <?php
			  
			  
			  }
			  ?>
              
		<tr class='pagination'>
		<td colspan='7'>
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
			
			location.href = 'packingmaterial.php?type=del&id='+id+"&module=warehouse&action=包装材料管理";
			
		
		}
	
	
	}



</script>