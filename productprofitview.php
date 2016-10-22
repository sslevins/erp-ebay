<?php
include "include/config.php";


include "top.php";


$sku		= $_REQUEST['sku'];

	$type	= $_REQUEST['type'];
	
	if($type == 'add'){
		
		$note		= $_REQUEST['keys'];
		$tim		= date('Y-m-d H:i:s');
		
		
		$truename		= $_SESSION['truename'];
		$ss			= "insert into productprofitview(sku,note,addtime,cpuser,ebay_user) values('$sku','$note','$tim','$truename','$user')";
		
		if($dbcon->execute($ss)){
			
			$status	= " -[<font color='#33CC33'>操作记录: 记录操作成功</font>]";
			
		}else{
		
			$status = " -[<font color='#FF0000'>操作记录: 记录操作失败</font>]";
		}
	
	
	
	}
	
	
	$id		= $_REQUEST['id'];
	
	$ss		= "delete from productprofitview where id ='$id' ";
	$dbcon->execute($ss);
	

		
		
	
	
	
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
	
	
		
	<td nowrap="nowrap" scope="row" >&nbsp;备注：
	  <textarea name="ordertype" cols="100" rows="5" id="ordertype"></textarea>
	<input type="button" value="添加" onclick="add()" /></td>
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
					<th scope='col' width='26%' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>编号	</div>			</th>
			
					<th scope='col' width='13%' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>备注</div>			</th>
			
					<th scope='col' width='13%' nowrap="nowrap">添加人</th>
	                <th scope='col' width='13%' nowrap="nowrap">操作时间</th>
	</tr>
		
   <?php 
				  
				  	$sql = "select * from productprofitview where ebay_user='$user' and sku = '$sku' order by id desc ";
					$sql = $dbcon->execute($sql);
					$sql = $dbcon->getResultArray($sql);
			
				
					
					for($i=0;$i<count($sql);$i++){
						
						$id				= $sql[$i]['id'];
						
						$note				= $sql[$i]['note'];
						$cpuser				= $sql[$i]['cpuser'];
						$addtime			= $sql[$i]['addtime'];
						
						
				  ?>
                  
                  
                  
		    
 
					<tr height='20' class='oddListRowS1'>
						<td scope='row' align='left' valign="top" ><?php echo $id; ?></td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $note; ?></td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $cpuser; ?>&nbsp;</td>
			                <td scope='row' align='left' valign="top" ><?php echo $addtime; ?>&nbsp;
                            
                            <?php if($_SESSION['truename'] == 'vipadmin'){ ?>
		                    <input name="input" type="button" value="删除"  onclick="location.href='productprofitview.php?sku=<?php echo $sku;?>&id=<?php echo $id;?>'" />
                            <?php } ?>
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
	
	function del(id){
		if(confirm('您确认删除此条记录吗')){
			
			location.href = 'systemuordertype.php?type=del&id='+id+"&module=system&action=订单类型";
			
		
		}
	
	
	}
	
	function add(){
		
		var keys		= document.getElementById('ordertype').value;
		location.href = 'productprofitview.php?type=add&keys='+keys+"&module=system&action=订单类型&sku=<?php echo $sku;?>";
		
	
	
	}



</script>