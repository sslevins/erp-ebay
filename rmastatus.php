<?php
include "include/config.php";
include "top.php";
$type = $_REQUEST['type'];
$actiontype = $_REQUEST['actiontype'];
$id  = $_REQUEST['id'];
if($actiontype =='del'){
	$vv="delete from ebay_rmatype where id='$id'";
	if($dbcon->execute($vv)){
		$status = "<font color='green'>删除成功</font>";
	}else{
		$status = "<font color='red'>删除失败</font>";
	}
}
if($actiontype =='mod'){
	$name = $_REQUEST['name'];
	$note = $_REQUEST['note'];
	$vv="update ebay_rmatype set name='$name',note='$note' where id='$id'";
	if($dbcon->execute($vv)){
		$status = "<font color='green'>修改成功</font>";
	}else{
		$status = "<font color='red'>修改失败</font>";
	}
}
if($actiontype =='add'){
	$name = $_REQUEST['name'];
	$note = $_REQUEST['note'];
	$vv="insert into ebay_rmatype (id,name,note,type,ebay_user) values ('','$name','$note','$type','$user');";
	if($dbcon->execute($vv)){
		$status = "<font color='green'>添加成功</font>";
	}else{
		$status = "<font color='red'>添加失败</font>";
	}
}
if($type=='1'){
	$case = 'case类型自定义';
}else{
	$case = 'case类型自定义';
}
?>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status;?> </h2>
</div>

<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</div>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='15'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" width='2%' class='paginationActionButtons'>&nbsp;</td>
				  <td  nowrap='nowrap' width='1%' align="right" class='paginationChangeButtons'>				  </td>
				</tr>
			</table>		</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap">编号</th>
					<th scope='col' nowrap="nowrap">名称</th>
					<th scope='col' nowrap="nowrap">备注</th>
					<th scope='col' nowrap="nowrap">操作</th>
	</tr>
   <?php 
				  
				$sql = "select * from ebay_rmatype where type='$type' and ebay_user = '$user' order by id ";
				//echo $sql;
				$sql		= $dbcon->execute($sql);
				$sql		= $dbcon->getResultArray($sql);

			//print_r($sql);
					
					for($i=0;$i<count($sql);$i++){
						
						$id 		= $sql[$i]['id'];
						$name	 		= $sql[$i]['name'];
						$note 		= $sql[$i]['note'];
						 
						
						
				  ?>
                  
                  
                  
		    
 
									<tr height='20' class='oddListRowS1'>
									  <td scope='row' align='left' valign="top" ><?php echo $id;?></td>
						              <td scope='row' align='left' valign="top" ><input name="name<?php echo $id;?>" type="text" id="name<?php echo $id;?>" value="<?php echo $name;?>" /></td>
						              <td scope='row' align='left' valign="top" ><input name="note<?php echo $id;?>" type="text" id="note<?php echo $id;?>" value="<?php echo $note;?>" /></td>
						    <td scope='row' align='left' valign="top" >
                            <a href="#" onclick="mod(<?php echo $id?>)">修改</a>
                            <a href="rmastatus.php?module=case&action=<?php echo $case;?>&type=<?php echo $type;?>&id=<?php echo $id?>&actiontype=del">删除</a>
                            </td>
			  </tr>
              <?php
			  }
			  ?>
		<tr class='pagination'>
		<td colspan='4'>
			<table border='0' cellpadding='0' cellspacing='0' width='60%' class='paginationTable'>
				<tr>
					<td>
						名称：<input name="namenew" type="text" id="namenew" value="" /></td>
					<td>
						备注：<input name="notenew" type="text" id="notenew" value="" />
					</td>
					<td>
					<input name="button" type="button" value="添加" onclick="mod('new')" />
					</td>
					</tr>
			</table>		</td>
	</tr></table>


    <div class="clear"></div>
<?php

include "bottom.php";


?>
<script language="javascript">
	
	function mod(id){
		var name = document.getElementById('name'+id).value;
		var note = document.getElementById('note'+id).value;
		if(id=='new'){
			location.href = 'rmastatus.php?module=case&action=<?php echo $case;?>&name='+name+'&note='+note+'&type=<?php echo $type;?>&id='+id+"&actiontype=add";
		}else{
			location.href = 'rmastatus.php?module=case&action=<?php echo $case;?>&name='+name+'&note='+note+'&type=<?php echo $type;?>&id='+id+"&actiontype=mod";
		}
	}
	
	


</script>