<?php
include "include/config.php";


include "top.php";


    $cpower	= explode(",",$_SESSION['power']);
	$type	= $_REQUEST['type'];
	if($type == "del"){
		
		$id	 = $_REQUEST['id'];
		$sql = "delete from ebay_goodscategory where id=$id";
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
<?php if(in_array("s_gt_add",$cpower)){?>	<input tabindex='2' title='关联eBay帐号' class='button' type="button" name='button' value='添加货品类别' id='search_form_submit' onClick="location.href='productcategoryadd.php?module=warehouse&action=添加货品类别'"/><?php }?>
	&nbsp;</td>
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
				<div style='white-space: nowrap;'width='100%' align='left'>编号</div>			</th>
			
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>类别名称</div>			</th>
			
					<th scope='col' nowrap="nowrap">所属分类</th>
					<th scope='col'  nowrap="nowrap">操作</th>
	</tr>
		
   <?php 
				  
				  	$sql = "select * from ebay_goodscategory where ebay_user='$user'";									
					$sql = $dbcon->execute($sql);
					$sql = $dbcon->getResultArray($sql);
				
					for($i=0;$i<count($sql);$i++){
						
					
						$name		= $sql[$i]['name'];						
						$id			= $sql[$i]['id'];
						
						$pid			= $sql[$i]['pid'];
						
						$pstr		= "父类";
						
						if($pid		!= '0'){
							
							$ss		= "select * from ebay_goodscategory where   id='$pid'";
							
							
							$ss		= $dbcon->execute($ss);
							$ss		= $dbcon->getResultArray($ss);
							$pstr	= $ss[0]['name'];
					
							
						}
				  ?>
                  
                  
                  
		    
 
					<tr height='20' class='oddListRowS1'>
						    <td scope='row' align='left' valign="top" ><?php echo $id; ?></td>				
						    <td scope='row' align='left' valign="top" ><?php echo $name; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;物品个数:
                            <?php
							
								
								$rsql		= "select count(*) as cc from  ebay_goods where goods_category='$id' and ebay_user='$user'";
								$rsql		= $dbcon->execute($rsql);
								$rsql		= $dbcon->getResultArray($rsql);
								echo $rsql[0]['cc'];
								
								
								
								
							
							?>                            </td>				
						    <td scope='row' align='left' valign="top" ><?php echo $pstr;?>
                            
                            
                            &nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php if(in_array("s_gt_modify",$cpower)){?><a href="productcategoryadd.php?id=<?php echo $id; ?>&module=warehouse&action=货品类别管理">修改</a><?php }?> <?php if(in_array("s_gt_delete",$cpower)){?><a href="#" onClick="del(<?php echo $id; ?>)">删除</a><?php }?>&nbsp;</td>
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
			
			location.href = 'productcategory.php?type=del&id='+id+"&module=warehouse&action=货品类别管理";
			
		
		}
	
	
	}



</script>