<?php
include "include/config.php";


include "top.php";




	
	$type	= $_REQUEST['type'];
	if($type == "del"){
		
		$id	 = $_REQUEST['id'];
		$sql = "delete from ebay_messagetemplate where id=$id";
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
	<input tabindex='2' title='关联eBay帐号' class='button' type="button" name='button' value='添加模板' id='search_form_submit' onClick="location.href='addtemplate.php?module=message&action=Message模板'"/>
	&nbsp;</td>
	</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='4'>&nbsp;</td>
	</tr><tr height='20'>
					<th scope='col' width='26%' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>编号</div>			</th>
			
					<th scope='col' width='13%' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>模板名称</div>			</th>
			
					<th scope='col' width='13%' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'></div>			</th>
			
					<th scope='col' width='13%' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'> 操作 </div>			</th>
			
					</tr>
		
		  <?php 
		  
		  		  	$sqlr = "select name from ebay_templatecategory where ebay_user ='$user' ";
					$sqlr = $dbcon->execute($sqlr);
					$sqlr = $dbcon->getResultArray($sqlr);
			
					
					for($j=0;$j<count($sqlr);$j++){
						$name 	= $sqlr[$j]['name'];
						  
				  
				  	$sql = "select name,id,ordersn from ebay_messagetemplate where ebay_user='$user' and category='$name' ";
					$sql = $dbcon->execute($sql);
					$sql = $dbcon->getResultArray($sql);
				?>
					<tr><td> <? echo $name;?></td>	</tr>
						<?
					for($i=0;$i<count($sql);$i++){
						
						$category_name		= $sql[$i]['name'];
						$id					= $sql[$i]['id'];
						$ordersn			= $sql[$i]['ordersn'];
				  ?>
                  
                  
                  
		    
 
				<tr height='20' class='oddListRowS1'>
							<td scope='row' align='left' valign="top" ><?php echo $ordersn;?></td>
						    <td scope='row' align='left' valign="top" ><?php echo $category_name; ?></td>
						    <td scope='row' align='left' valign="top" >&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><a href="#" onClick="delaccount(<?php echo $id; ?>)">删除</a>
                            <a href="addtemplate.php?id=<?php echo $id;?>&module=message&action=Message模板分类">修改</a>
                            </td>
		      </tr>
              <?php
			  }
			  }
			  ?>
              
              <?php
              		$sql = "select name,id,ordersn from ebay_messagetemplate where ebay_user='$user' and category='常用模板' ";
					$sql = $dbcon->execute($sql);
					$sql = $dbcon->getResultArray($sql);
				?>
					<tr><td>常用模板</td>	</tr>
					<?
					for($i=0;$i<count($sql);$i++){
						
						$category_name		= $sql[$i]['name'];
						$ebay_note			= $sql[$i]['note'];
						$id					= $sql[$i]['id'];
						$ordersn			= $sql[$i]['ordersn'];
				  ?>
                  
                  
                  
		    
 
				<tr height='20' class='oddListRowS1'>
							<td scope='row' align='left' valign="top" ><?php echo $ordersn;?></td>
						    <td scope='row' align='left' valign="top" ><?php echo $category_name; ?></td>
						    <td scope='row' align='left' valign="top" >&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><a href="#" onClick="delaccount(<?php echo $id; ?>)">删除</a>
                            <a href="addtemplate.php?id=<?php echo $id;?>&module=message&action=Message模板分类">修改</a>
                            </td>
		      </tr>
              <?php
			  }
			  ?>
              
              
              
               <?php
              		$sql = "select name,id,ordersn from ebay_messagetemplate where ebay_user='$user' and category='一般模板' ";
					$sql = $dbcon->execute($sql);
					$sql = $dbcon->getResultArray($sql);
				?>
					<tr><td>一般模板</td>	</tr>
					<?
					for($i=0;$i<count($sql);$i++){
						
						$category_name		= $sql[$i]['name'];
						$ebay_note			= $sql[$i]['note'];
						$id					= $sql[$i]['id'];
						$ordersn			= $sql[$i]['ordersn'];
				  ?>
                  
                  
                  
		    
 
				<tr height='20' class='oddListRowS1'>
							<td scope='row' align='left' valign="top" ><?php echo $ordersn;?></td>
						    <td scope='row' align='left' valign="top" ><?php echo $category_name; ?></td>
						    <td scope='row' align='left' valign="top" >&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><a href="#" onClick="delaccount(<?php echo $id; ?>)">删除</a>
                            <a href="addtemplate.php?id=<?php echo $id;?>&module=message&action=Message模板分类">修改</a>
                            </td>
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

		function delaccount(id){
		if(confirm('您确认删除此条记录吗')){
			
			location.href = 'messagetemplate.php?type=del&id='+id+"&module=message&action=Message模板分类";
			
		
		}
	
	
	}
</script>