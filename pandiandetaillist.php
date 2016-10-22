<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html> 
<head> 
<link rel="SHORTCUT ICON" href="themes/Sugar5/images/sugar_icon.ico?s=eae43f74f8a8f907c45061968d50157c&c=1"> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
<title>ISFES V3</title> 
<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/yui.css" />
<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/deprecated.css" />
<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/style.css" />
</head>
<body>
<?php
include "include/config.php";
	$sn = $_REQUEST['sn'];
	$status = $_REQUEST['status'];
	if($_POST['submit']){
		
		$totalrecorder		= $_POST['totalrecorder']; // 取得一共有多少行记录
		$totalrecorder		= explode(',',$totalrecorder);
		
		

		for($i=0;$i<count($totalrecorder);$i++){
			
			$selectid		= $totalrecorder[$i];
			if($selectid != '' ){
				
				$pandian_count				= $_POST['pandian_count'.$selectid];
				
				$addsql		= "update ebay_pandiandetail set pandian_count='$pandian_count' where id='$selectid'";
				if($dbcon->execute($addsql)){
					echo "序号: ".$selectid.' 修改成功<br>';
				}else{
					echo "序号: ".$selectid.' 修改失败<br>';
				}
			}
		}
	}

 ?>
    <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>

<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
				
</div>
 

		
   <?php 
				
	

				$sql		= "select * from ebay_pandiandetail where pandian_sn='$sn' ";
				
				$sql = $dbcon->execute($sql);
				$sql = $dbcon->getResultArray($sql);
				
			


				 ?>
                 
                 <form name="ff" method="post" action="pandiandetaillist.php"  >
             
            <table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
			<tr height='20'>
				<th scope='col' nowrap="nowrap"><span style="white-space: nowrap;">
				<input name="ordersn" type="checkbox" id="ordersn" value="0" onclick="check_all('ordersn','ordersn')" />
				<input name="sn" type="hidden" value="<?php echo $sn;?>" />
				<input name="status" type="hidden" value="<?php echo $status;?>" />
				</span>序号</th>
				<th scope='col' nowrap="nowrap">SKU</th>
				<th scope='col' nowrap="nowrap">名称</th>
				<th scope='col' nowrap="nowrap">单位</th>
				<th scope='col' nowrap="nowrap">实际库存</th>
				<th scope='col' nowrap="nowrap">可用量</th>
				<th scope='col' nowrap="nowrap">盘点可用量</th>
                    <?php
						
						for($i=0;$i<count($sql);$i++){
						$id						= $sql[$i]['id'];
						$goods_sn 				= $sql[$i]['goods_sn'];				
						$goods_name 			= $sql[$i]['goods_name'];								
						$goods_count 			= $sql[$i]['goods_count'];
						$goods_unit				= $sql[$i]['goods_unit'];
						$wait_count				= $sql[$i]['wait_count'];
						$use_count				= $goods_count-$wait_count;
						$pandian_count				= $sql[$i]['pandian_count'];
						
					
						
					
					
					?>
        </tr>
        
					<tr height='20' class='oddListRowS1'>
					  <td scope='row' align='left' valign="top" ><input name="ordersn" type="checkbox" id="ordersn" value="<?php echo $id;?>"   />
				      <?php echo $id;?>&nbsp;<span class="paginationActionButtons">
				      </span></td>							
						    <td scope='row' align='left' valign="top" >
							<?php echo $goods_sn;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $goods_name;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $goods_unit;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $goods_count;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $use_count;?>&nbsp;</td>
							 <td scope='row' align='left' valign="top" ><input name="pandian_count<?php echo $id;?>" type="text" id="goods_count<?php echo $id;?>" value="<?php echo $pandian_count;?>" style='width:30px'/>&nbsp;</td>
							  
					</tr>
					
              
              
              
              <?php
			  
			  
			  }
			  ?>
              
		<tr class='pagination'>
		<td colspan='19'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons' align="center">
                    <input name="totalrecorder" type="hidden" id="totalrecorder" value="<?php echo $i;?>" />
					<?php if($status=='0'){?>
                    <input name="submit" type="submit" onclick="return checkorders()" value="修改盘点数量" />
					<?php } ?>
				    </td>
			  </tr>
			</table>		</td>
	</tr>
</table>

</form>
<?php

include "bottom.php";


?>
<script>
function checkorders(){
		
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				bill = bill + ","+checkboxs[i].value;
			}	
		}
		if(bill == ""){
			alert("请选择物品");
			return false;
		}
		document.getElementById('totalrecorder').value = bill;
	}
	function check_all(obj,cName){

		var checkboxs = document.getElementsByName(cName);

		for(var i=0;i<checkboxs.length;i++){

			if(checkboxs[i].checked == false){

				

				checkboxs[i].checked = true;

			}else{

				

				checkboxs[i].checked = false;

			}	

			

		}
	}

</script>