<?php
include "include/config.php";


include "top.php";

	
	$pid		= $_REQUEST['id'];
	


	
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
        <table style="width:100%"><tr><td><div class='moduleTitle'></div>

<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
		
	<td nowrap="nowrap" scope="row" >
	<input  type="button" name='button' value='添加广告' id='search_form_submit' onClick="location.href='advance_indextemplateadd.php?module=advance&pid=<?php echo $_REQUEST['id'];?>'"/>
	&nbsp;</td>
</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='9'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" width='2%' class='paginationActionButtons'>&nbsp;</td>
				  <td  nowrap='nowrap' width='1%' align="right" class='paginationChangeButtons'>				  </td>
				</tr>
			</table>		</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>广告名称</div>			</th>
			
		            <th scope='col' nowrap="nowrap">广告类型</th>
        <th scope='col' nowrap="nowrap">SKU</th>
		<th scope='col' nowrap="nowrap">链接类型</th>
		<th scope='col' nowrap="nowrap">图片</th>
		<th scope='col' nowrap="nowrap">Item Number</th>
		<th scope='col' nowrap="nowrap">连接</th>
  <th scope='col'  nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>显示顺序</div>			</th>
			
					<th scope='col'  nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'> 操作 </div>			</th>
			
					</tr>
		
		  <?php 
				  
				  	$sql = "select * from ebay_advancenamedetail  where ebay_user='$user' and pid = '$pid' order by salemodule desc  ";
					$sqla = $dbcon->execute($sql);
					$sql = $dbcon->getResultArray($sqla);
					$dbcon->free_result($sqla);
						
						
				
					
					for($i=0;$i<count($sql);$i++){
						
						$name					= $sql[$i]['name'];
						$sku					= $sql[$i]['sku'];
						$type					= $sql[$i]['type']?'链接至商品':'其它链接';
						$picurl					= $sql[$i]['picurl'];
						$itemid					= $sql[$i]['itemid'];
						$id						= $sql[$i]['id'];
						$salemodule				= $sql[$i]['salemodule'];
						$displaysort			= $sql[$i]['displaysort'];
						
						if($salemodule == '0' ) $salemodule = '顶部广告';
						if($salemodule == '1' ) $salemodule = '秒杀广告';
						if($salemodule == '2' ) $salemodule = '推荐广告';
						if($salemodule == '3' ) $salemodule = '分类广告';
						if($salemodule == '4' ) $salemodule = 'TOP 5广告';
						if($salemodule == '5' ) $salemodule = '新品广告';
						
						 
						
						
				  ?>
                  
                  
                  
		    
 
									<tr height='20' class='oddListRowS1'>
							<td scope='row' align='left' valign="top" ><?php echo $name;?>&nbsp;</td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $salemodule;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $sku;?></td>
					    <td scope='row' align='left' valign="top" ><?php echo $type ?></td>
					    <td scope='row' align='left' valign="top" >
    &nbsp;&nbsp;<img src="images/<?php echo $picurl;?>" width="50" height="50" /></td>
					    <td scope='row' align='left' valign="top" ><?php echo $itemid;?></td>
						    <td scope='row' align='left' valign="top" >&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $displaysort;?>&nbsp;</td>
				
						    <td scope='row' align='left' valign="top" ><a href="#" onClick="delaccount(<?php echo $id; ?>)"></a>
                            
                            <a href="advance_indextemplateadd.php?module=advance&id=<?php echo $id;?>">更新</a>                                      </td>
		      </tr>
              
              
              
              <?php
			  
			  
			  }
			  ?>
              
		<tr class='pagination'>
		<td colspan='9'>
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