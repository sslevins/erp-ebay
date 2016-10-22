<?php
include "include/config.php";
include "top.php";
$keys		= $_REQUEST['keys'];
$searchs	= $_REQUEST['searchs'];
$sort		= $_REQUEST['sort'];
$type		= $_REQUEST['type'];
if($type=='del'){
	$bill= explode(',',$_REQUEST['bill']);
	foreach($bill as $k=>$v){
		if($v){
			$sql= "delete from ebay_skulist where id=$v";
			if($dbcon->execute($sql)){
				$status = "删除成功";
			}
		}
	}
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
	
	
		
	<td nowrap="nowrap" scope="row" >查找：
	  <input name="keys" type="text" id="keys" value=<?php echo $keys; ?> >
	  <select name="searchs" id="searchs" >
        <option value="0" <?php if($searchs == '0') echo 'selected="selected"';?>>关键字</option>
        <option value="1" <?php if($searchs == '1') echo 'selected="selected"';?>>SKU</option>
        <option value="2" <?php if($searchs == '2') echo 'selected="selected"';?>>中文名称</option>
        <option value="3" <?php if($searchs == '3') echo 'selected="selected"';?>>itemtitle</option>
        <option value="4" <?php if($searchs == '4') echo 'selected="selected"';?>>account</option>
      </select>

        排序：
       <select name="sort" id="sort">
         <option value="">Please Select</option>
         <option value="1" <?php if($sort == '1') echo 'selected="selected"';?>>按itemtitle升序</option>
         <option value="2" <?php if($sort == '2') echo 'selected="selected"';?>>按itemtitle降序</option>
		 <option value="3" <?php if($sort == '3') echo 'selected="selected"';?>>按sku升序</option>
		 <option value="4" <?php if($sort == '4') echo 'selected="selected"';?>>按sku降序</option>
        
       </select>
    
    
    <input type="button" value="查找" onclick="searchorder()" />
	<br />
	操作：
	<input class='button' type="button" name='search_form_submit' value='删除' id='search_form_submit2' onclick="del()" />
		<input class='button' type="button" name='button' value='添加对照sku' id='search_form_submit' onclick="javascript:location.href='skulistadd.php?module=warehouse&action=sku中英文对照'" />
		<input class='button' type="button" name='button' value='对照sku导入' id='search_form_submit1' onclick="javascript:location.href='skulistaddxls.php?module=warehouse&action=sku中英文对照'" />
       <input class='button' type="button" name='button' value='全选' id='search_form_submit' onclick="check_all('ordersn','ordersn')" />
       <br />
</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='16'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" width='2%' class='paginationActionButtons'>&nbsp;</td>
				  <td  nowrap='nowrap' width='1%' align="right" class='paginationChangeButtons'>				  </td>
				</tr>
			</table>		</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>&nbsp;</div></th>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>sku</div></th>
			
					<th scope='col' nowrap="nowrap">中文名称</th>
					<th scope='col' nowrap="nowrap">itemtitle</th>
					<th scope='col' nowrap="nowrap">account</th>
					<th scope='col' nowrap="nowrap">操作</th>
	</tr>
		


			  <?php
			  	
				
			
				$sql		= "select * from ebay_skulist as a where ebay_user='$user'";

				if($searchs == '0') {
				
				$sql	.= " and(a.namecn like '%$keys%' or a.nameen like '%$keys%' or a.sku like '%$keys%' or a.account='$keys')";
				}
				
				if($searchs == '1'){
					 $sql	.= " and a.sku = '$keys' ";
				}
				
				if($searchs == '2'){
				 $sql	.= " and a.namecn = '$keys' ";
				}
				
				if($searchs == '3'){
				 $sql	.= " and a.nameen = '$keys' ";
				}
				
				if($searchs == '4'){
				 $sql	.= " and a.account = '$keys' ";
				}
				
				if($sort == '1'){
				
				 $sql	.= " order by nameen asc ";
				}else if($sort == '2'){
				
				$sql	.= " order by nameen  desc ";
				}else if($sort =='3'){
				$sql	.= " order by sku  ";
				}else{
				$sql	.= " order by sku desc ";
				}
				
				$query		= $dbcon->query($sql);
				$total		= $dbcon->num_rows($query);
				
				$pageindex  =( isset($_GET['pageindex']) )?$_GET['pageindex']:1;
				$limit = " limit ".($pageindex-1)*$pagesize.",$pagesize";
		
				
				$page=new page(array('total'=>$total,'perpage'=>$pagesize));
				$sql = $sql.$limit;
				$sql		= $dbcon->execute($sql);
				$sql		= $dbcon->getResultArray($sql);
				for($i=0;$i<count($sql);$i++){
					
					$id		= $sql[$i]['id'];			
					$sku		= $sql[$i]['sku'];
					$namecn		= $sql[$i]['namecn'];
					$nameen		= $sql[$i]['nameen'];
					$account	= $sql[$i]['account'];
					
			  ?>
              
              
                  
         		<tr height='20' class='oddListRowS1'>
					<td scope='row' align='left' valign="top" ><input name="ordersn" type="checkbox" id="ordersn" value="<?php echo $id;?>" ><?php echo $id;?></td>
					<td scope='row' align='left' valign="top" ><?php echo $sku;?></td>
					<td scope='row' align='left' valign="top" ><?php echo $namecn;?></td>
					<td scope='row' align='left' valign="top" ><?php echo $nameen;?></td>
					<td scope='row' align='left' valign="top" ><?php echo $account;?></td>
	                <td scope='row' align='left' valign="top" ><a href="skulistadd.php?ids=<?php echo $id;?>&amp;&amp;module=warehouse&amp;action=sku名称中英文对照表" target="_blank">修改</a>&nbsp;</td>
	  </tr>
              


 
               <?php } ?>
		<tr class='pagination'>
		<td colspan='16'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'><div align="center">
					一共有 <?php echo $total; ?> 个SKU
					
					<?    echo '<br><center>'.$page->show(2)."</center>";//输出分页 ?> 
                </div></td>
					</tr>
			</table>		</td>
	</tr></table>


    <div class="clear"></div>
<?php

include "bottom.php";


?>
<script language="javascript">


function check_all(obj,cName)
{
    var checkboxs = document.getElementsByName(cName);
    for(var i=0;i<checkboxs.length;i++){
		if(checkboxs[i].checked == false){
			
			checkboxs[i].checked = true;
		}else{
			
			checkboxs[i].checked = false;
		}	
		
	}
}


	function searchorder(){
	
		

		var content		 		= document.getElementById('keys').value;
		var searchs 			= document.getElementById('searchs').value;	
		var sort 			= document.getElementById('sort').value;	
		location.href= 'skulist.php?keys='+encodeURIComponent(content)+"&sort="+sort+"&module=warehouse&action=sku中英文对照表&searchs="+searchs;
		
		
	}
	function del(){
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				
				bill = bill + ","+checkboxs[i].value;
			
			}	
			
		}
		if(bill == ""){
			alert("请选择编号");
		}
		if(confirm("您确认将这些记录删除吗")){
			location.href= 'skulist.php?bill='+bill+"&module=warehouse&action=sku中英文对照表&type=del";
		}
	}
</script>