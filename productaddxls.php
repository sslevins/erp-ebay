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
					<td nowrap="nowrap" class='paginationActionButtons'><form action="productaddxlssave.php" enctype="multipart/form-data" method="post" target="_blank">
<table border="0"  cellpadding="3" cellspacing="1" bgcolor="#c0ccdd" id="content">
  <tr>
    <td>上传文件:</td>
    <td><input name="upfile" type="file" class="button" style="height:22px;"   size=35/>&nbsp;</td>
    <td><input name="提交" type="submit" class="button" value="更新" />
    &nbsp;</td>
    <td><a href="example.xls">导入模板下载</a></td>
  </tr>
</table>
<br />
<br />
A1:货品编号<br />
B1:货品名称<br />
C1:货品成本<br />
D1:货品价格<br />
E1:货品单位<br />
F1: 货位号<br />
G1:产品重量<br />
H1:产品备注<br />
I1:产品性质<br />
J1:英文申报名称<br />
K1:海关编码<br />
L1:中文申报名称<br />
M1:申报价值USD<br />
N1:产品长<br />
O1:产品宽<br />
P1:产品高<br />
Q1:货品类别<br />
R1:父类<br />
S1:对应出库仓库<br />
T1:销售人员<br />
U1:采购人员<br />
V1:包装材料<br />
W1:包装容量<br />
X1:供应商<br />
AA1:BtoB编号<br/>
AB1:产品开发人员<br/>
AC1:产品包装人员<br/>
AD1:产品状态<br/>
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