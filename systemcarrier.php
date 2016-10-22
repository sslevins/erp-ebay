<?php
include "include/config.php";


include "top.php";




	$type	= $_REQUEST['type'];
	if($type == "del"){
		
		$id	 = $_REQUEST['id'];
		$sql = "delete from ebay_carrier where id=$id";
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
	<input tabindex='2' title='添加新的发货方式' class='button' type="button" name='button' value='添加新的发货方式' id='search_form_submit' onClick="location.href='systemcarrieradd.php?module=system&action=添加新的发货方式户'"/>
	&nbsp;<br /></td>
	</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='6'>
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
	    <div style='white-space: nowrap;'width='100%' align='left'>名称</div>			</th>
			
  <th scope='col' nowrap="nowrap">
<div style='white-space: nowrap;'width='100%' align='left'>
        代码</div>			</th>
			
		<th scope='col' nowrap="nowrap">优先级</th>
		<th scope='col' nowrap="nowrap">备注</th>
		<th scope='col' nowrap="nowrap">操作</th>
	</tr>
   <?php 
				  
				  	$sql = "select * from ebay_carrier where ebay_user='$user' order by name desc ";
			
					
					$sql = $dbcon->execute($sql);
					$sql = $dbcon->getResultArray($sql);
			
					
					for($i=0;$i<count($sql);$i++){
						
						$name	 	= $sql[$i]['name'];
						$value		= $sql[$i]['value'];						
						$id			= $sql[$i]['id'];
						$note			= $sql[$i]['note'];
						$Priority			= $sql[$i]['Priority'];
						$fielname		= '';
						
						if($name == 'EMS'){
							$fielname = 'emsshipfeelist.php?module=system&action=发货方式管理&type='.$value;
						}
						
						
						if($name == '香港小包挂号' || $name == '香港小包平邮' ){
							$fielname = 'hkpostregister.php?module=system&action=发货方式管理&type='.$value.'&id='.$id;
						}
						
						if($name == '中国邮政挂号'){
							$fielname = 'cpghshipfeelist.php?module=system&action=发货方式管理&type='.$value;
						}
						
						if($name == '中国邮政平邮'){
							$fielname = 'cppyshipfeelist.php?module=system&action=发货方式管理&type='.$value;
						}
						
						if($name == 'EUB'){
							$fielname = 'eubpostregister.php?module=system&action=发货方式管理&type='.$value.'&id='.$id;
						}
						
	
						if($name == '香港小包平邮' ){
							$fielname = 'hkpostshipfeelist.php?module=system&action=发货方式管理&type='.$value;
							
						}
						
						
						if($name == '香港小包挂号' ){
							$fielname = 'hkpostghshipfeelist.php?module=system&action=发货方式管理&type='.$value;
							
						}
				  ?>
                  
                  
                  
		    
 
									<tr height='20' class='oddListRowS1'>
						<td scope='row' align='left' valign="top" ><?php echo $id; ?></td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $name; ?></td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $value;?> </td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $Priority;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $note;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><a href="systemcarrieradd.php?id=<?php echo $id; ?>&module=system&action=encodeURIComponent('发货方式管理')">修改</a> <a href="#" onClick="del(<?php echo $id; ?>)">删除</a>&nbsp;<a href="expressedit.php?id=<?php echo $id; ?>">编辑快递单</a>
                            
                            <a href="<?php echo $fielname;?>" target="_parent"></a>
                            
                            <a href="systemcarrierweight.php?shippingid=<?php echo $id; ?>&module=system&action=<?php echo $name;?>"></a>
                            
                            <a href="Systemshipfee.php?module=system&shippingid=<?php echo $id;?>">运费</a></td>
	  </tr>
              
              
              
              <?php
			  
			  
			  }
			  ?>
              
		<tr class='pagination'>
		<td colspan='6'>
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