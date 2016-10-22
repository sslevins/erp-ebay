<?php

include "include/config.php";

include "top.php";	
$cpower	= explode(",",$_SESSION['power']);

	/* 修改客户地址 */

	$ids	= $_REQUEST['ids'];


		if($_POST['submit']){
		$sku			 	= str_rep($_POST['sku']);
		$country			= str_rep($_POST['country']);
		$note 				= str_rep($_POST['note']);

		if($ids == ""){

		

			$sql			= "INSERT INTO `ebay_skucountrynote` (`sku` ,`country` ,`note` ,`ebay_user`) values('$sku','$country','$note','$user');";

		}else{

		

			

			$sql			= "UPDATE `ebay_skucountrynote` SET `note` = '$note',country='$country'";
			
			
			$sql			.= " WHERE id='$ids'";
			
			 

			

		}

		//echo $sql;
		

		if($ids == "" && $sku!=''){

			

			$sjsql			= "select id from ebay_skucountrynote where sku='$sku' and country='$country' and ebay_user='$user'";
			$sjsql			= $dbcon->execute($sjsql);

			$sjsql			= $dbcon->getResultArray($sjsql);

			if(count($sjsql) >0){

				$sql = '';

				$status	= " -[<font color='#33CC33'>操作记录: 货品编号国家备注已经存在</font>]";


			}


		}
		if($dbcon->execute($sql)){
				$status	= " -[<font color='green'>操作记录: sku国家备注保存成功</font>]";
			}else{
				$status	= " -[<font color='red'>操作记录: sku国家备注保存失败</font>]";
			}
	}





 ?>
 <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>

<div id="main">

    <div id="content" >

        <table style="width:100%"><tr><td><div class='moduleTitle'>

<h2>sku国家备注<?php echo $status;?> </h2>

</div>



<div class='listViewBody'>





<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">

 

<form id="ad" name="ad" method="post" action="skucountrynoteadd.php?ids=<?php echo $ids;?>&module=warehouse&action=sku国家备注">


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

<tr>

	

	

	

		

	<td nowrap="nowrap" scope="row" >&nbsp;<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>

                <td class="login_txt_bt">
                <input name="submit" type="submit" value="保存" onclick="return check()" />
                <br />
                </td>
              </tr>

                    <tr>

                      <td valign="top" class="left_txt">

                      <?php
							
							$sql = "select * from ebay_skucountrynote where id='$ids' and ebay_user='$user'";
							$sql		= $dbcon->execute($sql);
							$sql		= $dbcon->getResultArray($sql);
							$sku		= $sql[0]['sku'];
							$country		= $sql[0]['country'];
							$note		= $sql[0]['note'];

					  ?>

                      <table width="100%" border="1" cellpadding="0" cellspacing="0" class="login_txt">

                        <tr>

                          <td>sku</td>

                          <td><input name="sku" type="text" id="sku" value="<?php echo $sku;?>">
                          </td>
                        </tr>
						<tr>

                          <td>国家</td>

                          <td><input name="country" type="text" id="country" value="<?php echo $country;?>">
                          </td>
                        </tr>
						<tr>

                          <td>备注</td>
							
                          <td><input name="note" type="text" id="note" value="<?php echo $note;?>">
                          </td>
                        </tr>
                      </table>

              </tr>



                   

          </table></td>

	</tr>

</table>

<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>

<div id='Accountssaved_viewsSearchForm' style='display: none';></div>

</form>

 

<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>

	<tr class='pagination'>

		<td width="65%">&nbsp;</td>

	</tr>

              

              

              



              

		<tr class='pagination'>

		<td>

			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>

				<tr>

					<td nowrap="nowrap" class='paginationActionButtons'></td>

			  </tr>

			</table>		</td>

	</tr></table>


</form>


    <div class="clear"></div>

<?php



include "bottom.php";





?>

<script language="javascript">

	function check(){
		
		var goods_sn		= document.getElementById('sku').value;
		if(goods_sn == ''){
			
			alert('产品编号不能为空');
			document.getElementById('sku').focus();
			return false;
			
		
		}
		
	
	
	}
</script>