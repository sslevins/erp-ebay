<?php
include "include/config.php";
include "top.php";	
	
	function isplan($sku,$storeid){
		global $dbcon,$user;
		$plansql	= "select id from ebay_goods_newplan where sku ='$sku' and ebay_user='$user' and ebay_warehouse='$storeid'";
		$plansql	=$dbcon->execute($plansql);
		$plansql	=$dbcon->getResultArray($plansql);
		if(count($plansql)>0){
			return 0;
		}else{
			return 1;
		}
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
	
			$goods_sn		 				= $currentSheet->getCell('B'.$c)->getValue();
			$store_name		 				= $currentSheet->getCell('A'.$c)->getValue();			
			$goods_count		 			= $currentSheet->getCell("D".$c)->getValue();	
			$truename				 		= $currentSheet->getCell("C".$c)->getValue();	
			
			
			
			if($goods_sn != ''  ){
				$sql	 = "SELECT id FROM `ebay_store` where store_name='$store_name' ";
				$sql	 = $dbcon->execute($sql);
				$sql	 = $dbcon->getResultArray($sql);
				$storeid = $sql[0]['id'];
				$vv = "select goods_name,goods_suppliers,goods_developer,goods_price from ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
				$vv			= $dbcon->execute($vv);
				$vv			= $dbcon->getResultArray($vv);
				$goods_name = $vv[0]['goods_name'];
				$factory	= $vv[0]['goods_suppliers'];
				$kfuser		= $vv[0]['goods_developer'];
				$goods_price = $vv[0]['goods_price'];
				if(isplan($goods_sn,$storeid)){
				$addsql		= "insert into ebay_goods_newplan(sku,goods_name,ebay_warehouse,goods_count,ebay_user,type,partner,purchaseprice,kfuser) values('$goods_sn','$goods_name','$storeid','$goods_count','$user','1','$factory','$goods_price','$kfuser')";
				
				if($dbcon->execute($addsql)){
					echo "SKU: ".$goods_sn.' 保存成功<br>';
				}else{
					echo "SKU: ".$goods_sn.' 保存失败<br>';
				}
				}else{
					echo "SKU: ".$goods_sn.' 保存失败,计划已经存在<br>';
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
						<td valign="top">D</td>
                      </tr>
                      <tr>
                        <td width="114" valign="top"><p><strong>仓库 </strong></p></td>
                        <td width="114" valign="top"><p><strong>sku </strong></p></td>
						<td width="114" valign="top"><p><strong>添加人 </strong></p></td>
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