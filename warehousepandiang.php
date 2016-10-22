<?php
include "include/config.php";


include "top.php";




	
	
	if($_POST['submit']){
		
		
		
		$in_warehouse2		= $_POST['in_warehouse2'];
		
		$name				= $_FILES['upfile']['name'];		
		$filename			= date('Y').date('m').date('d').date('H').date('i').date('s').rand(100,999);
		$filetype			= substr($name,strpos($name,"."),4);
		$goods_pic			= $filename.$filetype;	
		
		if (move_uploaded_file($_FILES['upfile']['tmp_name'], "images/".$goods_pic)) {	
				
	 			$status	= "-[<font color='#33CC33'>The picture uploaded successful</font>]<br>";
				echo $status;				
		}
		$fileName = 'images/'.$goods_pic;	
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
		/**取得一共有多少列*/



		
		$c		= 1;
		$status	= 0;
		while(true){
			
			$aa	= 'A'.$c;
			$bb	= 'B'.$c;
		
			
			
			$goods_sn		 		= $currentSheet->getCell($aa)->getValue();
			$goods_count	 		= $currentSheet->getCell($bb)->getValue();
			
		
			if($goods_sn != ''){
			
			$ss		= "update ebay_onhandle set goods_count='$goods_count'  where goods_sn='$goods_sn' and store_id='$in_warehouse2' and ebay_user='$user'";
			echo $ss;
			
			$dbcon->execute($ss);
			echo $goods_sn ."更新成功<br>";
			$status = 1;
			
			}
			
			
			
			$c++;
			
			
			if($c>=300) break;
				
			
			
		}
		if($status>=1){
			
			$sql		= "insert into ebay_operation(name,addtime,note) values('".$_SESSION['truename']."','".date('Y-m-d H:i:s')."','')";
			$dbcon->execute($sql);
			
		
		}
		
			
				
}
			



 ?>
  <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>

<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2>盘点管理<?php echo $status;?></h2>
</div>
 
<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 <input name="hiddenuserid" type="hidden" value="" id="hiddenuserid" />
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
		
	<td nowrap="nowrap" scope="row" >&nbsp;</td>
	</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td width="26%">
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'>			
                  <table width="100%" border="0" align="center" cellspacing="0" class="left_txt">
                    
                    
                      <form id="ad" name="ad" method="post" action="warehousepandiang.php?module=warehouse&action=盘点管理" enctype="multipart/form-data">
                    <tr>
                      <td>导入盘点数据：</td>
                      <td><input name="upfile" type="file" id="upfile" />
                        对仓库:
                          <select name="in_warehouse2" id="in_warehouse2">
                          <option value="-1" >未设置</option>
                          <?php 
					
					$sql	 = "select * from ebay_store where ebay_user='$user'";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 
					 	$store_name	= $sql[$i]['store_name'];
						$cid			=  $sql[$i]['id'];
					 ?>
                          <option value="<?php echo $cid;?>" <?php if($in_warehouse == $cid) echo "selected=selected" ?>><?php echo $store_name;?></option>
                          <?php } ?>
                        </select>
                      <input name="submit" type="submit" id="submit" value="提交" /></td>
                    </tr>
                    </form>
                    <tr>
                      <td colspan="2">&nbsp;</td>
                    </tr>
                  </table>
					  <p>&nbsp;</p>
				    <p>&nbsp;</p>
				    <p>&nbsp;</p>
				    <p>&nbsp;</p></td>
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

<script language="javascript">
	
	function exports(){
	
		var start	= document.getElementById('start').value;
		var end		= document.getElementById('end').value;
		var in_warehouse		= document.getElementById('in_warehouse').value;
		
		if(start == ''){
		
			alert('请输入开始日期');
			return false;
		
		}
		
		if(end == ''){
		
			alert('请输入结束日期');
			return false;
		
		}
		
		var url		= "warehousepandiangxls.php?start="+start+"&end="+end+"&in_warehouse="+in_warehouse;
		window.open(url,"_blank");
	
	}



</script>
