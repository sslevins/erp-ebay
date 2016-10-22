<?php



include "include/config.php";











include "top.php";









$id		= $_REQUEST['id'];

if($id != ''){

$sql		= "delete  from  ebay_magento where id='$id'";

if($dbcon->execute($sql)){

$status	= " -[<font color='#33CC33'>操作记录: 记录操作成功</font>]";

}else{

$status = " -[<font color='#FF0000'>操作记录: 记录操作失败</font>]";

}

}





	



 ?>

 <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>



<style type="text/css">



<!--



.STYLE1 {font-size: xx-small}



-->



</style>







<div id="main">



    <div id="content" >



        <table style="width:100%"><tr><td>







<div class='listViewBody'>











<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">



 



 



<table width="100%" cellspacing="0" cellpadding="0" border="0">



<tr>



	



	



		



	<td nowrap="nowrap" scope="row" ><!--



               <input type="button" value="打印地址A4" onClick="detail2()">



               <input type="button" value="Label标签打印" onclick="detail3()" />-->

	  <input type="button" value="添加新的网店(仅支持magento)" onclick="location.href='systemmagentoadd.php?module=system'" /></td>

</tr>

</table>



</div>



<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>



<div id='Accountssaved_viewsSearchForm' style='display: none';></div>



</form>



 



<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>



	<tr class='pagination'>



		<td colspan='5'><div id="rows"></div> 		</td>

	</tr><tr height='20'>



					<th height="28" nowrap="nowrap" scope='col'><div align="left">网店名称</div></th>



  <th scope='col' nowrap="nowrap"><div align="left">数据库服务器地址</div></th>



			



					<th scope='col' nowrap="nowrap">

                      <div align="left">数据库用户名/密码</div></th>



			

                    <th scope='col' nowrap="nowrap"><div align="left">数据库</div></th>

        <th scope='col' nowrap="nowrap">操作</th>

	</tr>

			  <?php				



			

				$sql		= "select * from ebay_magento as a where user='$user'";

				$query		= $dbcon->query($sql);

				$total		= $dbcon->num_rows($query);

				$totalpages = $total;



				



				



				$pageindex  =( isset($_GET['pageindex']) )?$_GET['pageindex']:1;



				$limit = " limit ".($pageindex-1)*$pagesize.",$pagesize";



		



				



				$page=new page(array('total'=>$total,'perpage'=>$pagesize));



				$sql = $sql.$limit;



				$sql		= $dbcon->execute($sql);



				$sql		= $dbcon->getResultArray($sql);



				$dpage		= 0;





				for($i=0;$i<count($sql);$i++){



					

						$zen_name		= $sql[$i]['zen_name'];

						$zen_server		= $sql[$i]['zen_server'];

						$zen_username	= $sql[$i]['zen_username'];

						$zen_password	= $sql[$i]['zen_password'];

						$zen_database	= $sql[$i]['zen_database'];

						$id				= $sql[$i]['id'];

					

			  ?>



              



              



                  



         		<tr height='20' class='oddListRowS1'>



						<td scope='row' align='left' valign="top" ><div align="left"><?php echo $zen_name;?></div></td>

				  <td scope='row' align='left' valign="top" ><div align="left"><?php echo $zen_server;?></div></td>

			      <td scope='row' align='left' valign="top" ><div align="left"><?php echo $zen_username;?>/<?php echo $zen_password;?>&nbsp;</div></td>

		          <td scope='row' align='left' valign="top" ><div align="left"><?php echo $zen_database;?></div></td>

		          <td scope='row' align='left' valign="top" >

                  <a href="systemmagentoadd.php?id=<?php echo $id; ?>&module=system">修改</a>

                  

                  &nbsp;<a href="#" onclick="deleterows('<?php echo $id;?>')">删除</a>

                  

                    <a href="mailaccount.php?id=<?php echo $id; ?>&module=system&action=设置邮件发送帐号"></a>

                  </td>

       		  </tr>

         		<tr height='20' class='oddListRowS1'>

         		  <td colspan="5" align='left' valign="top" scope='row' > </td>

       		  </tr>



              



             <?php



			  



							$st	= "select * from ebay_orderdetail where ebay_ordersn='$ordersn'";



							$st = $dbcon->execute($st);



							$st	= $dbcon->getResultArray($st);



							$total	= 0;



							



							



							for($t=0;$t<count($st);$t++){



							



							



								$qname			= $st[$t]['ebay_itemtitle'];								



								$qitemid		= $st[$t]['ebay_itemid'];



								$sku			= $st[$t]['sku'];



								$imagepic		= $st[$t]['ebay_itemurl'];



								$ebay_amount	= $st[$t]['ebay_amount'];



								$qname			= $st[$t]['ebay_itemtitle'];



								$recordnumber	= $st[$t]['recordnumber'];



								$ebay_itemprice	= $st[$t]['ebay_itemprice'];



								$ListingType	= $st[$t]['ListingType'];



						



			  ?>







              



              

              <?php 



			  



			  if($ebaynote != ""){



			  



			  



			  $ebaynote					= str_replace('<![CDATA[','',$ebaynote);



			  $ebaynote					= str_replace(']]>','',$ebaynote);



			  ?>



              







              

               <?php } } } ?>



		<tr class='pagination'>



		<td colspan='5'>



			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>



				<tr>



					<td nowrap="nowrap" class='paginationActionButtons'>



                    本页订单条数为：<?php echo $dpage;?>



                   



                    Your search results is <?php echo $totalpages;?>



          



                    <div align="center"><?    echo '<br><center>'.$page->show(2)."</center>";//输出分页 ?> 

                </div></td>

					</tr>

			</table>		</td>

	</tr></table>











    <div class="clear"></div>



<?php







include "bottom.php";











?>



<script language="javascript">

	

	function deleterows(id){

	

			

			if(confirm("确认删除此条记录吗")){

			

			

				

				location.href	= 'systemmagento.php?id='+id+"&module=system";

				

			

			

			}

			

		

	

	

	

	}

	







</script>