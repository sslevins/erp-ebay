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
					<td nowrap="nowrap" class='paginationActionButtons'><form action="productaddxlssave.php" enctype="multipart/form-data" method="post" target="_blank">
<table border="0"  cellpadding="3" cellspacing="1" bgcolor="#c0ccdd" id="content">
  <tr>
    <td>上传文件:</td>
    <td><input name="upfile" type="file" class="button" style="height:22px;"   size=35/>&nbsp;</td>
    <td><input name="提交" type="submit" class="button" value="更新" />
    &nbsp;</td>
    <td><a href="example1.xls">导入模板下载</a></td>
  </tr>
</table>
<br />
<br />
A1:SKU<br />
B1:产品状态<br />
C1:产品类别<br />
D1:产品名称<br />
E1:规格描述<br />
F1:颜色<br />
G1:MOQ<br />
H1:交期<br />
I1:采购单价<br />
J1:产品成本<br />
K1:重量<br />
L1:体积<br />
M1:长<br />
N1:宽<br />
O1:高<br />
P1:配件明细<br />
Q1:产品认证<br />
R1:录入时间<br />
S1:产品开发员<br />
T1:样品检测员<br />
U1:默认供应商<br />
V1:UPC码<br />
W1:ESIN码<br />
<br />
<strong>以上列中，如果指定列无数据，指定列将不会更新，如果有数据，指定列将被更新成功。</strong><br />
<br />
                    </form></td>
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
<script language="javascript">
	function check(){
		
		var days	= document.getElementById('days').value;	
		var account = document.getElementById('account').value;	
		location.href='orderloadstatus.php?days='+days+'&account='+account+"&module=orders&action=同步订单结果";
		
		
	}

</script>