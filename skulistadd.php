<?php

include "include/config.php";

include "top.php";	
$cpower	= explode(",",$_SESSION['power']);

	/* 修改客户地址 */

	$ids	= $_REQUEST['ids'];


		if($_POST['submit']){
		$sku			 	= str_rep($_POST['sku']);
		$namecn			 	= str_rep($_POST['namecn']);
		$nameen 			= str_rep($_POST['nameen']);
		$account			= str_rep($_POST['account']);

		if($ids == ""){

		

			$sql			= "INSERT INTO `ebay_skulist` (`sku` ,`namecn` ,`nameen` ,`account` ,`ebay_user`) values('$sku','$namecn','$nameen','$account','$user');";

		}else{

		

			

			$sql			= "UPDATE `ebay_skulist` SET `namecn` = '$namecn',`sku` = '$sku',`account` = '$account'";
			
			
			$sql			.= " WHERE id='$ids'";
			
			 

			

		}

		

		if($ids == "" && $sku!=''){

			

			$sjsql			= "select id from ebay_skulist where nameen='$nameen' and ebay_user='$user'";
			$sjsql			= $dbcon->execute($sjsql);

			$sjsql			= $dbcon->getResultArray($sjsql);

			if(count($sjsql) >0){

				$sql = '';

				$status	= " -[<font color='#33CC33'>操作记录: 存在相同的货品编号</font>]";


			}else{

			

			

			

			}


		}
		if($dbcon->execute($sql)){
				$skus = $sku;
				$status	= " -[<font color='green'>操作记录: sku对照记录保存成功</font>]";
			}else{
				$status	= " -[<font color='red'>操作记录: sku对照记录保存失败</font>]";
			}
	}





 ?>
 <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>

<div id="main">

    <div id="content" >

        <table style="width:100%"><tr><td><div class='moduleTitle'>

<h2>sku中英文对照<?php echo $status;?> </h2>

</div>



<div class='listViewBody'>





<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">

 

<form id="ad" name="ad" method="post" action="skulistadd.php?ids=<?php echo $ids;?>&module=warehouse&action=sku中英文对照">


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
							
							$sql = "select * from ebay_skulist where id='$ids' and ebay_user='$user'";
							$sql		= $dbcon->execute($sql);
							$sql		= $dbcon->getResultArray($sql);
							$sku		= $sql[0]['sku'];
							$namecn		= $sql[0]['namecn'];
							$nameen		= $sql[0]['nameen'];
							$account	= $sql[0]['account'];

					  ?>&nbsp;<br>

                      <table width="100%" border="1" cellpadding="0" cellspacing="0" class="login_txt">

                        <tr>

                          <td>sku</td>

                          <td><input name="sku" type="text" id="sku" value="<?php echo $sku;?>">
                          </td>
                        </tr>
						<tr>

                          <td>中文名称</td>

                          <td><input name="namecn" type="text" id="namecn" value="<?php echo $namecn;?>">
                          </td>
                        </tr>
						<tr>

                          <td>itemtitle</td>

                          <td><input name="nameen" type="text" id="nameen" value="<?php echo $nameen;?>">
                          </td>
                        </tr>
						<tr>

                          <td>account</td>

                          <td><input name="account" type="text" id="account" value="<?php echo $account;?>">
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
		
		var goods_sn		= document.getElementById('goods_sn').value;
		if(goods_sn == ''){
			
			alert('产品编号不能为空');
			document.getElementById('goods_sn').focus();
			return false;
			
		
		}
		
	
	
	}
</script>