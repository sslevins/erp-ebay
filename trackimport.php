<?php
include "include/config.php";


include "top.php";




	
	$type	= $_REQUEST['type'];
	if($type == "del"){
		
		$id	 = $_REQUEST['id'];
		$sql = "delete from ebay_account where id=$id";
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
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td width="65%">
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'><form action="trackimportsave.php" enctype="multipart/form-data" method="post" target="_blank">
<table border="0"  cellpadding="10" cellspacing="1" bgcolor="#c0ccdd" id="content">
 
  <tr>
    <td>上传文件:</td>
    <td><input name="upfile" type="file" class="button" style="height:22px;"   size=35/>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    
    <td><input name="提交" type="submit" class="button" value="更新" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

                    </form>
					  <p><br />
				    订单导入模板:分为这三列 三列都是必填项 数据从第二行开始<br />
					  </p>
					  <p>A:订单号-内</p>
					  <p>B:跟踪号</p>
					  <p>C:运输方式</p></td>
			    </tr>
			</table>		</td>
	</tr>
		

              
		<tr class='pagination'>
		<td>
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