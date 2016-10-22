<?php
include "include/config.php";


include "top.php";



    $cpower	= explode(",",$_SESSION['power']);
	$type	= $_REQUEST['type'];
	if($type == "del"){
		
		$id	 = $_REQUEST['id'];
		$sql = "delete from  ebay_productscombine where id=$id";
	if($dbcon->execute($sql)){
			
			$status	= " -[<font color='#33CC33'>操作记录: 记录删除成功</font>]";
			
		}else{
		
			$status = " -[<font color='#FF0000'>操作记录: 记录删除失败</font>]";
		}
		
		
		
	
	}else{
		
		$status = "";
		
	}
	$keys		= trim($_REQUEST['keys']);
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
	关键字查找:
	  <input name="keys" type="text" id="keys" value="<?php echo $keys;?>" /><input type="button" value="查找" onclick="serarchs()" />
<?php if(in_array("s_gc_add",$cpower)){?>	  <input tabindex='2' class='button' type="button" name='button' value='添加组合产品' id='search_form_submit' onClick="location.href='productcombineadd.php?module=warehouse&action= 添加组合产品'"/><?php }?>
	&nbsp;
<?php if(in_array("s_gc_add",$cpower)){?>	<input tabindex='2' class='button' type="button" name='search_form_submit' value='组合产品批量导入' id='search_form_submit2' onclick="location.href='productcombineexport.php?module=warehouse&amp;action= 组合产品批量导入'"/><?php }?>
	<input tabindex='2' class='button' type="button" name='search_form_submit2' value='组合产品批量导出' id='search_form_submit3' onclick="exports()"/>
	(和导入格式一样)</td>
	</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='5'>&nbsp;			</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>编号</div>			</th>
			
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>产品编号	</div>			</th>
			
					<th scope='col' nowrap="nowrap">组合产品编码</th>
					<th scope='col' nowrap="nowrap">备注</th>
					<th scope='col'  nowrap="nowrap">操作</th>
	</tr>
		
   <?php 		
				  
				  	$sql = "select * from  ebay_productscombine where ebay_user='$user'";	
					
					if($keys != '') $sql	.= " and (goods_sn like '%$keys%' or  goods_sncombine like '%$keys%' or notes like '%$keys%') ";
					$query		= $dbcon->query($sql);
					
					$total		= $dbcon->num_rows($query);
				$totalpages = $total;

				

				

				$pageindex  =( isset($_GET['pageindex']) )?$_GET['pageindex']:1;

				$limit = " limit ".($pageindex-1)*$pagesize.",$pagesize";
				
				

				$page=new page(array('total'=>$total,'perpage'=>$pagesize));
				$sql	.= " order by goods_sn desc ";
				
				$sql = $sql.$limit;
				
					$sql = $dbcon->execute($sql);
					$sql = $dbcon->getResultArray($sql);
				
					for($i=0;$i<count($sql);$i++){
						
						$id							= $sql[$i]['id'];
						$goods_sn					= $sql[$i]['goods_sn'];						
						$goods_sncombine			= $sql[$i]['goods_sncombine'];
						$notes						= $sql[$i]['notes'];
				
						
				  ?>
                  
                  
                  
		    
 
					<tr height='20' class='oddListRowS1'>
						    <td scope='row' align='left' valign="top" ><?php echo $id; ?></td>				
						    <td scope='row' align='left' valign="top" ><?php echo $goods_sn;?>&nbsp;</td>				
						    <td scope='row' align='left' valign="top" ><?php echo $goods_sncombine;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $notes;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php if(in_array("s_gc_modify",$cpower)){?><a href="productcombineadd.php?storeid=<?php echo $id; ?>&module=warehouse&action=添加组合产品">修改</a><?php }?> <?php if(in_array("s_gc_delete",$cpower)){?><a href="#" onClick="del(<?php echo $id; ?>)">删除</a><?php }?>&nbsp;</td>
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
	</tr>
		<tr class='pagination'>
		  <td colspan='5'><?    echo '<br><center>'.$page->show(2)."</center>";//输出分页 ?></td>
	  </tr>
</table>


    <div class="clear"></div>
<?php

include "bottom.php";


?>
<script language="javascript">
	
	function del(id){
		if(confirm('您确认删除此条记录吗')){
			
			location.href = 'productcombine.php?type=del&id='+id+"&module=warehouse&action=货品类别管理";
			
		
		}
	
	
	}

function serarchs(){
		
		var keys		= document.getElementById('keys').value;
		var url			= "productcombine.php?keys="+keys+"&module=warehouse&action=组合产品管理";
		location.href	= url;
		
	
	
	}
	
	function exports(){
	
		
		var keys		= document.getElementById('keys').value;
		var url			= "productcombinetoxls.php?keys="+keys+"&module=warehouse&action=组合产品管理";
		location.href	= url;
		
	
	}

</script>