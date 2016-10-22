<?php
include "include/config.php";

	
	$io_ordersn	= $_REQUEST['io_ordersn'];
	
	
	if($io_ordersn == '' ){
		
		die('系统导入初始化失败，请重新操作');
		
	
	}
	
	
	
	if($_POST['submit']){
	$uploadfile = date("Y").date("m").date("d").rand(1,3009).".xls";
	
	$fstatus		= 0;

	

	

	if (move_uploaded_file($_FILES['upfile']['tmp_name'], 'images/'.$uploadfile)) {
	
		echo "<font color=BLUE>文件上传成功！</font><br>";
		$fstatus		= 1;
		
	
	}else {
   		
	//	echo "<font color=red> 文件上传失败！</font>  <a href='index.php'>返回</a><br>"; 	
	}

	
	
	$fileName = 'images/'.$uploadfile;	
	$filePath = $fileName;

	require_once 'Classes/PHPExcel.php';








	if($fstatus == 1){
	$PHPExcel = new PHPExcel(); 
$PHPReader = new PHPExcel_Reader_Excel2007();    
if(!$PHPReader->canRead($filePath)){      
$PHPReader = new PHPExcel_Reader_Excel5(); 
if(!$PHPReader->canRead($filePath)){      
echo 'no Excel';
return ;
}
}
$PHPExcel = $PHPReader->load($filePath);
$currentSheet = $PHPExcel->getSheet(0);



/**取得一共有多少列*/


		$c=2;

		
		while(true){
	
			$goods_sn		 				= $currentSheet->getCell('A'.$c)->getValue();	
			$goods_count		 			= $currentSheet->getCell("C".$c)->getValue();	
			$goods_cost				 		= $currentSheet->getCell("B".$c)->getValue();	
			
			
			
			if($goods_sn != ''  ){
			$sql			= "select * from ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
			$sql			= $dbcon->execute($sql);
			$sql			= $dbcon->getResultArray($sql);
			if(count($sql)  == 0){
				$status .= " -[<font color='#FF0000'>操作记录: 没有产品记录，请添加此产品</font>]";
			}else{
				$goods_name		= $sql[0]['goods_name'];
				$goods_sn		= $sql[0]['goods_sn'];
				$goods_unit		= $sql[0]['goods_unit'];
				$goods_id		= $sql[0]['goods_id'];
				$sql		= "insert into ebay_iostoredetail(io_ordersn,goods_name,goods_sn,goods_cost,goods_unit,goods_count,goods_id) values('$io_ordersn','$goods_name','$goods_sn','$goods_cost','$goods_unit','$goods_count','$goods_id')";
				if($dbcon->execute($sql)){
					$status	.= " -[<font color='#33CC33'>操作记录: $goods_sn 产品添加成功</font>]";
				}else{
					$status .= " -[<font color='#FF0000'>操作记录: $goods_sn 产品添加失败</font>]";
				}
			
			}
			
			
			}
		
			
			
			if($goods_sn == '') break;	
			$c++;


			
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
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td width="65%">
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'><form action="battchuploadps.php?io_ordersn=<?php echo $_REQUEST['io_ordersn'];?>" enctype="multipart/form-data" method="post">
                      <table border="0" align="center"  cellpadding="3" cellspacing="1" bgcolor="#c0ccdd" id="content">
  <tr>
    <td>上传文件:</td>
    <td><input name="upfile" type="file" class="button" style="height:22px;"   size=35/>&nbsp;</td>
    <td><input name="submit" type="submit" class="button" value="更新" /></td>
  </tr>
</table>

                    </form>
					 				  
					<p>文件格式:</p>
					<p>&nbsp;</p>
					<table border="1" cellspacing="0" cellpadding="0">
                      <tr>
                        <td valign="top">A</td>
                        <td valign="top">B</td>
                        <td valign="top">C</td>
                      </tr>
                      <tr>
                        <td width="114" valign="top"><p><strong>产品编号 </strong></p></td>
                        <td width="114" valign="top"><p><strong>进货成本 </strong></p></td>
                        <td width="114" valign="top"><p><strong>数量 </strong></p></td>
                      </tr>
                    </table>
					<p><a href="images/upload_goods.xls">下载模板</a> 注: 表格中的内容从第二行开始，第一行为列头名称。<br />
			          </p></td>
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

document.getElementById('ordersn').focus();	

	function check(){
		
		var days	= document.getElementById('days').value;	
		var account = document.getElementById('account').value;	
		location.href='orderloadstatus.php?days='+days+'&account='+account+"&module=orders&action=同步订单结果";
		
		
	}

</script>