<?php
include "include/config.php";


include "top.php";


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
					<td nowrap="nowrap" class='paginationActionButtons'><form action="stockupdatesave.php" enctype="multipart/form-data" method="post" target="_blank">
<table border="0"  cellpadding="3" cellspacing="1" bgcolor="#c0ccdd" id="content">
  <tr>
    <td>上传文件:</td>
    <td><input name="upfile" type="file" class="button" style="height:22px;"   size=35/>&nbsp;</td>
    <td><input name="提交" type="submit" class="button" value="更新" />
    &nbsp;<a href='updatestore.xls' target="_blank">模板下载</a></td>
  </tr>
</table>

                    </form>
					 				  <br />
A.货品编号	<br />
B.对应仓库编码 <br />
C.实际库存数量	<br />
D.库存上限	<br />
E.库存下限	<br />	
F.  库存报警天数  <br />
G.采购天数<br />
<br />
<br />
<strong>注: A列不能为空，B列不能为空，C、D、E、F、G，如果数据列为空则不更新原有数据。</strong></td>
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
