<?php
include "include/config.php";


include "top.php";




	
	
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
	
			$aa	= 'A'.$c;	
			$ordersn	 		= $currentSheet->getCell($aa)->getValue();	
			$ebay_tracknumber	 		= $currentSheet->getCell("B".$c)->getValue();	
			$carrier				 	= $currentSheet->getCell("C".$c)->getValue();	
			if($ordersn == '') break;	
			$c++;
			$sql		= "update ebay_order set  ebay_tracknumber='$ebay_tracknumber',ebay_carrier ='$carrier' where ebay_id='$ordersn' and ebay_user ='$user'";
			
			
			$ss			= "select ebay_id from ebay_order where ebay_ordersn ='$ordersn' and ebay_user ='$user'  ";
			$ss			= $dbcon->execute($ss);
			$ss			= $dbcon->getResultArray($ss);
			
			if(count($ss) == 1 ){
				$sql		= "update ebay_order set  ebay_tracknumber='$ebay_tracknumber',ebay_carrier ='$carrier' where ebay_ordersn='$ordersn' and ebay_user ='$user'";
			}
	
			
			if($dbcon->execute($sql)){
							$status	= " -[<font color='#33CC33'>订单号：$ordersn 已经更新</font>]<br>";
						
					
							
							
			}else{		
							$status .= " -[<font color='#FF0000'>订单号：$ordersn 更新失败</font>]<br>";
							
							
			}
			
			
			
			echo $status.'<br>';
			
		}

	
	
	
	
	}
	
	
	
	

	
	}
	
	
 ?>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo '跟踪号上传'.$status;?> </h2>
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
					<td nowrap="nowrap" class='paginationActionButtons'><form action="orderuploadloader.php?module=orders" enctype="multipart/form-data" method="post">
<table border="0" align="center"  cellpadding="3" cellspacing="1" bgcolor="#c0ccdd" id="content">
  <tr>
    <td>上传文件:</td>
    <td><input name="upfile" type="file" class="button" style="height:22px;"   size=35/>&nbsp;</td>
    <td><input name="submit" type="submit" class="button" value="更新" /></td>
  </tr>
</table>

                    <br />
					<br />
					<br />
					A列是订单编号或AMAZON订单编号<br />
                    
					<br />
					B列是跟踪号<br /><br />

					C列是运输方式名称,一定要和系统内部设置对应上。
					</form>
					 				  <br /></td>
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