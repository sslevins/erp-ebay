<?php
include "include/config.php";


include "top.php";




	
	$type	= $_REQUEST['type'];
	if($type == "del"){
		
		$id	 = $_REQUEST['id'];
		$sql = "delete from ebay_messagecategory where id=$id";
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
	<input tabindex='2' title='关联eBay帐号' class='button' type="button" name='button' value='添加分类' id='search_form_submit' onClick="location.href='addcategory.php?module=message&action=Message分类'"/>
	&nbsp;
    
    &nbsp;&nbsp;&nbsp;</td>
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
				<div style='white-space: nowrap;'width='100%' align='left'>编号</div>			</th>
			
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>分类名称	</div>			</th>
			
					<th scope='col' nowrap="nowrap">规则</th>
					<th scope='col'  nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>备注</div>			</th>
			
					<th scope='col'  nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'> 操作 </div>			</th>
			
					</tr>
		
		  <?php 
		  
		  
		  
		   			$sqll = "select * from ebay_user where truename ='客服' order by id desc ";
					$sqll = $dbcon->execute($sqll);
					$sqll = $dbcon->getResultArray($sqll);
				
					
					for($j=0;$j<count($sqll);$j++){
						
						$username 	= $sqll[$j]['username'];
						$ss1=0;
						$ss2=0;
						$ss3=0;
						$ss4=0;
						?>
						<tr><td colspan="4">
					 
						</td></tr>
						
						<?
						//-----------------------------------------------------
				  
				  	$sql = "select * from ebay_messagecategory where ebay_user='$user' and category_name ='$username' order by category_name desc ";
					$sql = $dbcon->execute($sql);
					$sql = $dbcon->getResultArray($sql);
				
					
					for($i=0;$i<count($sql);$i++){
						
						$category_name	= $sql[$i]['category_name'];
						$ebay_note	= $sql[$i]['ebay_note'];
						$id				= $sql[$i]['id'];
						$rules				= nl2br($sql[$i]['rules']);
						if ($i>0){
						$idd=strval($idd).",". strval($id);
						}else{$idd=$id;}
 				  ?>
                  
                  
                  
		    
 
							 
	<?php
	$ss		= "select count(1) as cc from ebay_message where classid = '$id' and status=1 and ($ebaymes) and ishide ='0'";
	$ss		= $dbcon->execute($ss);
	$ss		= $dbcon->getResultArray($ss);
	$ss		= $ss[0]['cc'];
	$ss1=$ss1+$ss;
 	?>
 
     
 	<?php
	$ss		= "select count(1) as cc from ebay_message where classid = '$id' and status=3 and ($ebaymes) and ishide ='0'";
	$ss		= $dbcon->execute($ss);
	$ss		= $dbcon->getResultArray($ss);
	$ss		= $ss[0]['cc'];
	$ss2=$ss2+$ss;
 	?>
     
    
 	<?php
	$ss		= "select count(1) as cc from ebay_message where classid = '$id' and status=2 and ($ebaymes) and ishide ='0'";
	$ss		= $dbcon->execute($ss);
	$ss		= $dbcon->getResultArray($ss);
	$ss		= $ss[0]['cc'];
	
	$ss3=$ss3+$ss;
 	?>
     
    
 	<?php
	$ss		= "select count(1) as cc from ebay_message where classid = '$id' and status=0 and ($ebaymes) and ishide ='0'";
	$ss		= $dbcon->execute($ss);
	$ss		= $dbcon->getResultArray($ss);
	$ss		= $ss[0]['cc'];
	$ss4=$ss4+$ss;
 	
	 
				
	?>
 
              
              
              <?php
			  
			  
			  }
			  ?>
			  
			  
			  	<tr height='20' class='oddListRowS1'>
						<td scope='row' align='left' valign="top" ><?php echo $id;?></td>
				
						    <td scope='row' align='left' valign="top" >
							<?php echo $category_name;?>&nbsp;&nbsp;&nbsp;  
	<a href="0messageindex.php?cidtype=<?php echo $id ?>&module=message&action=已回复Message&ostatus=1"> 已回复
	(<? echo $ss1; ?>)</a> &nbsp;&nbsp;
    	
	     <a href="0messageindex.php?cidtype=<?php echo $id ?>&module=message&action=标记已回复Message&ostatus=3">标记已回复(<? echo $ss2; ?>)
</a> &nbsp;&nbsp;
    	
	  	<a href="0messageindex.php?cidtype=<?php echo $id ?>&&module=message&action=未回复Message&ostatus=0">未回复(<? echo $ss4; ?>)
</a> &nbsp;&nbsp;
    	
 <a href="0messageindex.php?cidtype=<?php echo $id ?>&module=message&action=草稿Message&ostatus=2">草稿( <? echo $ss3; ?>)
	</a>  &nbsp;&nbsp;
    	  </td>  <td></td><td></td><td></td><td></td>  </tr>
              <? 						
						
						}?>
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

		function delaccount(id){
		if(confirm('您确认删除此条记录吗')){
			
			location.href = 'messagecategory.php?type=del&id='+id+"&module=message&action=Message分类";
			
		
		}
	
	
	}
</script>