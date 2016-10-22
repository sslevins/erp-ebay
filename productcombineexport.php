<?php
include "include/config.php";


include "top.php";

$uploadfile = date("Y").date("m").date("d").rand(1,3009).".xls";
	
	

	if($_POST['submit']){
	
	

	if (move_uploaded_file($_FILES['upfile']['tmp_name'], 'images/'.$uploadfile)) {
	
		echo "<font color=BLUE>文件上传成功！</font><br>";
	
	}else {
   		
		echo "<font color=red> 文件上传失败！</font>  <a href='index.php'>返回</a><br>"; 	
	}
	
	
	$fileName = 'images/'.$uploadfile;	
	$filePath = $fileName;

	require_once 'Classes/PHPExcel.php';





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
/*取得一共有多少列*/


$c=2;



while(true){
	
	$aa	= 'A'.$c;
	$bb	= 'B'.$c;
	$cc	= 'C'.$c;
	$dd	= 'D'.$c;
	$ee	= 'E'.$c;
	$ff	= 'F'.$c;
	$gg	= 'G'.$c;
	
	
	$goods_sn	 					= $currentSheet->getCell($aa)->getValue();
	$goods_sncombine		 		= $currentSheet->getCell($bb)->getValue();
	$notes		 					= $currentSheet->getCell($cc)->getValue();
	
	$ss		= "select * from ebay_productscombine where goods_sn='$goods_sn' and ebay_user='$user' ";
	

	$ss		= $dbcon->execute($ss);
	$ss		= $dbcon->getResultArray($ss);
	if(count($ss) == 0){
		
		
		$ss		= "insert into ebay_productscombine(goods_sn,goods_sncombine,notes,ebay_user) values('$goods_sn','$goods_sncombine','$notes','$user')";	
		
	
	}else{
	
		
		$ss		= "update ebay_productscombine set goods_sn='$goods_sn',goods_sncombine='$goods_sncombine',notes='$notes' where ebay_user='$user' and goods_sn='$goods_sn'";
	
	}


	
	
	
	if($goods_sn == '' ) break;
	if($dbcon->execute($ss)){
		echo '<br><font color=BLUE>'.$goods_sn.' 保存成功 </font>';
	}else{
		echo '<br><font color=red>'.$goods_sn.' 保存失败 </font>';
	}
	$c++;
	
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
					<td nowrap="nowrap" class='paginationActionButtons'><form action="productcombineexport.php" enctype="multipart/form-data" method="post" >
<table border="0"  cellpadding="3" cellspacing="1" bgcolor="#c0ccdd" id="content">
  <tr>
    <td>上传文件:</td>
    <td><input name="upfile" type="file" class="button" style="height:22px;"   size=35/>&nbsp;</td>
    <td><input name="submit" type="submit" class="button" value="更新" />
    &nbsp;</td>
    <td><a href="CombineProducts.xls">导入模板下载</a></td>
  </tr>
</table>

                    </form>
					 				  <br />
A:  产品编号   <br />
B:  组合产品编码   <br />
C:  备注 <br />
</td>
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