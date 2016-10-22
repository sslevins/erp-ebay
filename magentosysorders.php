<?php



		





include "include/config.php";











include "top.php";







	$start		= date('Y-m-d')."T00:00:00";

	$end		= date('Y-m-d')."T23:59:59";

	



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



 <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>







<div class='listViewBody'>



<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>



<div id='Accountssaved_viewsSearchForm' style='display: none';></div>



</form>



 



<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>



	<tr class='pagination'>



		<td width="65%">



			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>



				<tr>



					<td nowrap="nowrap" class='paginationActionButtons'><table width="100%" height="99" border="0" cellpadding="0" cellspacing="0">



                



			    <form method="post" action="addaccount.php">   



			      <tr>



                    <td width="41%" height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right"> Account</div></td>



                    <td width="3%" align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>



                    <td width="56%" height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">



                    <select name="account" id="account">



                    <?php 



					



					$sql	 = "select * from ebay_magento where user='$user'";



					$sql	 = $dbcon->execute($sql);



					$sql	 = $dbcon->getResultArray($sql);



					for($i=0;$i<count($sql);$i++){					



					 



					 	$zen_name	= $sql[$i]['zen_name'];



					 ?>



                      <option value="<?php echo $zen_name;?>"><?php echo $zen_name;?></option>



                    <?php } ?>

                    </select>

                    <input type="button" value="Loading Orders" onclick="check()" />

                    </div></td>

                    </tr>

                  </form> 



                    <td height="30" colspan="3" align="right" class="left_txt"><div align="left">

                    <?php

					

						



						if($_REQUEST['account'] != ''){

							

							$laccount		= $_REQUEST['account'];

							$sql = "select * from ebay_magento where zen_name='$laccount'";

							

							$sql = $dbcon->execute($sql);

							$sql = $dbcon->getResultArray($sql);
							
							print_r($sql);
							

							$zen_name		= $sql[0]['zen_name'];

							$zen_server		= $sql[0]['zen_server'];

							$zen_username	= $sql[0]['zen_username'];

							$zen_password	= $sql[0]['zen_password'];

							$zen_database	= $sql[0]['zen_database'];

							$zen_tablename	= $sql[0]['zen_tablename'];

							$zen_loadingstatus	= $sql[0]['zen_loadingstatus'];

							

							

							$zen_loadingstatus	= explode(',',$zen_loadingstatus);

							

							$tjstatus			= '';

							

							

							for($i=0;$i<count($zen_loadingstatus);$i++){

							

								

								$sysstatus		= $zen_loadingstatus[$i];

								if($sysstatus != ''){

									$tjstatus	.= " status ='".$sysstatus."' or ";

								}

							

							}

							

							$tjstatus			= substr($tjstatus,0,strlen($tjstatus) - 3);

	

							

							$ebay_ordertype		= $sql[0]['orderstatus'];

							

							

							$host=$zen_server;

							$root=$zen_username;

							$password=$zen_password;

							$dbname=$zen_database;

			

							

		

							

							

							

							$did		= mysql_connect($host,$root,$password) or die("webstore 数据库连接失败00000");
							mysql_selectdb($zen_database) or die("数据连接失败00");
							$ss				= "select * from ".$zen_tablename."sales_flat_order where $tjstatus order by entity_id desc  limit 50 ";
							echo '<br>'.$ss;
							
							mysql_query("SET NAMES utf8");

							

							$result = mysql_query($ss) or die("数据库查询失败-");	

							$billcount = 0;

							

							while($row = mysql_fetch_assoc($result)){

				

								

		

									

								$ebay_ordersn 			= $row['entity_id'];

								$ebay_paystatus      	= 'Complete';

								$recordnumber 			= $row['entity_id'];

								$ebay_paidtime 			= strtotime($row['updated_at']);

								$ebay_usermail 			= str_rep($row['customer_email']);

								$ebay_createdtime 		= strtotime($row['created_at']);

								$ebay_currency			= $row['base_currency_code'];

								$ebay_total				= $row['base_grand_total'];

								$ebay_carrier				= $row['shipping_description'];

								$increment_id				= $row['increment_id'];

								$shipping_invoiced					= $row['base_shipping_amount'];

								$ebay_status			= '1';

								

								$dd0			= "SELECT * FROM  ".$zen_tablename."sales_flat_quote WHERE  `reserved_order_id` =$increment_id ";

									

								echo $dd0;

								

								$dd0				=  mysql_query($dd0,$did) or die("数据库查询失败11s");	

								if($ddrow0 = mysql_fetch_assoc($dd0)){

								

							

								

								

								

								$entity_id		 = $ddrow0['entity_id'];

								$customer_email		 = $ddrow0['customer_email'];

								$dd1			 = "select * from  sales_flat_quote_address where quote_id ='$entity_id' and address_type ='shipping' ";

								

							

								

						echo $dd1;
						

								$dd1			 =  mysql_query($dd1,$did) or die("数据库查询失败11g");

								if($dd1row			 = mysql_fetch_assoc($dd1)){

			


								

									$ebay_username			= $dd1row['firstname'].' '.$dd1row['middlename'].' '.$dd1row['lastname'];

									$ebay_street			= str_rep($dd1row['street']);

									$ebay_city				= str_rep($dd1row['city']);

									$ebay_phone				= $dd1row['telephone'];

									$ebay_countryname		= $dd1row['country_id'];

									

									$ebay_countryname		= getcountry($ebay_countryname);

									

									

									

									$postcode				= str_rep($dd1row['postcode']);

									$ebay_state				= str_rep($dd1row['region']);

									$ebay_company				= str_rep($dd1row['company']);

									

									$ss						= "select * from ebay_order where zencartid='$ebay_ordersn' and ebay_account='$laccount'";

									if(queryrows($ss)){

									

									

									echo $ebay_ordersn.'已经存在<br>';

									

									}else{

									/*添加订单资料*/

									$val				= mt_rand(100000000, 999999999).$ebay_ordersn;

									$addsql		 =  "insert into ebay_order(zencartid,ebay_paystatus,recordnumber,ebay_createdtime,ebay_paidtime,ebay_userid,ebay_username,ebay_usermail,";

									$addsql		.= "ebay_street,ebay_street1,ebay_city,ebay_state,ebay_countryname,ebay_postcode,ebay_phone,ebay_currency,ebay_total,ebay_status,ebay_user,";

									$addsql		.= "ebay_addtime,ebay_account,ebay_ordersn,ebay_shipfee,ebay_ordertype,ebay_carrier,ebay_company,ebay_warehouse) values('$ebay_ordersn','$ebay_paystatus','$increment_id','$ebay_createdtime','$ebay_paidtime','$ebay_username',";

									$addsql		.= "'$ebay_username','$customer_email','$ebay_street','$ebay_street1','$ebay_city','$ebay_state','$ebay_countryname','$postcode','$ebay_phone'";

									$addsql	    .= ",'$ebay_currency','$ebay_total','$ebay_status','$user','$mctime','$laccount','$val','$shipping_invoiced','$ebay_ordertype','$ebay_carrier','$ebay_company','$defaultstoreid')";

									

									echo $addsql;

									

											/**/	

												

												if(abcquery($addsql)){

								

									echo $ebay_username." 订单同步成功<br>";

								//	$bddsql		= "select * from ".$zen_tablename."sales_flat_order_item where order_id='$ebay_ordersn' and product_type ='configurable'";

									

									$bddsql		= "select * from ".$zen_tablename."sales_flat_order_item where order_id='$ebay_ordersn' and parent_item_id	 is null ";

									echo '<br>'.$bddsql;
									

									

									$bbresult			=  mysql_query($bddsql,$did) or die("数据库查询失败f22");	

									while($bbrow = mysql_fetch_assoc($bbresult)){

											

											

											print_r($bbrow);

											

											$product_id			= $bbrow['product_id'];

											

											/* 检查产品所对应的连接 */

											

											$vvsql				= "select * from catalog_product_flat_1 where entity_id ='$product_id' ";

											$vvsqlresult		= mysql_query($vvsql,$did) or die("数据库查询失败f22");

											if($vvrow	= mysql_fetch_assoc($vvsqlresult) ) $url_path	= $vvrow['url_path'];

											

											

											$ebay_itemid		= $bbrow['item_id'];

											$sku				= str_rep($bbrow['sku']);

											$ebay_itemtitle				= str_rep($bbrow['name']);

											$ebay_itemprice				= str_rep($bbrow['base_price']);

											$ebay_amount					= str_rep($bbrow['qty_ordered']);

											$ss					= "select * from ebay_orderdetail where recordnumber='$ebay_itemid' and ebay_account='$laccount'";

											if(queryrows($ss)){
											
											
											echo $ss.'<br>';
											

											}else{

												$bbsql				=  "insert into  ebay_orderdetail(recordnumber,ebay_ordersn,ebay_itemid,ebay_itemtitle,sku,ebay_itemprice,ebay_amount,ebay_createdtime,ebay_user";

												$bbsql				.= ",ebay_account,addtime,ebay_itemurl) values('$orders_products_id','$val','$ebay_itemid','$ebay_itemtitle','$sku','$ebay_itemprice','$ebay_amount','$mctime','$ebay_user','$laccount','$mctime','$url_path')";

												

												if(abcquery($bbsql)){echo $ebay_itemtitle." 产品添加成功<br>";}

											}

											

									

											

									

									}

									

									

								

								}else{

								

								

										

										echo '同步完成';

										

								

								

								}

								

								/**/

									

									}

									

									

						

			

								

				

								

									

								}

								

								

								

								

								}

				

							

							

								

								

								

							

								

								

								

							}

							

		

							

							

						

						

						

						

						}

					

					

					function getcountry($countryid){

						

						global $mroot,$mpassword,$mdatabasenames,$user;

						$abc	= mysql_connect("localhost",$mroot,$mpassword) or die("数据库连接失败");

						mysql_selectdb($mdatabasenames) or die("数据连接失败");

						mysql_query("SET NAMES utf8");

						$ss				= "SELECT * FROM  `ebay_countrys` where ebay_user='$user' and countrysn='$countryid'";

						$ss1				=  mysql_query($ss,$abc) or die("数据库查询失败f22");	

						if($ss1row = mysql_fetch_assoc($ss1)){

						return $ss1row['countryen'];

						}

					}

						

					function abcquery($str){		

					

					global $mroot,$mpassword,$mdatabasenames;

					

					$status = 0;		

					$abc	= mysql_connect("localhost",$mroot,$mpassword) or die("数据库连接失败");

					mysql_selectdb($mdatabasenames) or die("数据连接失败");

					mysql_query("SET NAMES utf8");

					if(mysql_query($str,$abc)){				

						$status = 1;		

					}else{			

						$status = 0;			

					}		

					return $status;		

				   }

						

						

						

					function queryrows($str){		

						

						global $mroot,$mpassword,$mdatabasenames;

	

						

						$status = 0;			

						$ab	=  mysql_connect("localhost",$mroot,$mpassword) or die("数据库连接失败");

						mysql_selectdb($mdatabasenames) or die("数据连接失败");

						

						mysql_query("SET NAMES utf8");

						$result = mysql_query($str,$ab);

						$result = mysql_num_rows($result);		

						

						

			

						

						return $result;

							

					}

					

					

					

					function getresults($sku){		

						

						global $dbcon,$user;

						$ss				= "SELECT * FROM  `ebay_productscombine` where ebay_user='$user' and goods_sncombine='$sku'";

						

						echo $ss;

						

						$ss				= $dbcon->execute($ss);

						$ss				= $dbcon->getResultArray($ss);

						$data		= array();

						if(count($ss) >0){

					

						$sku		= $ss[0]['goods_sn'];

						$amount		= $ss[0]['notes'];

						

						

						

							$data[0]	= $sku;

						$data[1]	= $amount;

						

						

						

						}

						

						

						

					

						

						return $data;

							

					}

	

	

	

						

					

					

					

					

					?>

                    

                    

                    

                    

                    

                    

                    </div>

                      <div align="left"></div></td>



                    </tr>       



                </table>



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











$ss			= "select ebay_countryname, ebay_ordersn,ebay_id,ebay_carrier from ebay_order where ebay_status ='631'   ";

			

						

						$ss			= $dbcon->execute($ss);

						$ss			= $dbcon->getResultArray($ss);

						

	

				

						

						for($i=0;$i<count($ss);$i++){

						

							$ebay_countryname		= $ss[$i]['ebay_countryname'];

							$ebay_ordersn			= $ss[$i]['ebay_ordersn'];

							$ebay_id			= $ss[$i]['ebay_id'];

							$ebay_shiptype			= $ss[$i]['ebay_carrier'];

							

							

							$nn						= "select  * from ebay_carrier where encounts like '%$ebay_countryname%' and ebay_shiptype like '%$ebay_shiptype%'";

							

							

							$nn						= $dbcon->execute($nn);

							$nn						= $dbcon->getResultArray($nn);

							

							

				

							if(count($nn) > 0){

								

								

								$ebay_carrier		= $nn[0]['name'];

								

								$nn		= "update ebay_order set ebay_carrier ='$ebay_carrier' where ebay_id='$ebay_id' ";

								

								$dbcon->execute($nn);

								

								

							

							

							}

							

						

						

						

						}

						

						

include "bottom.php";









?>



<script language="javascript">



	function check(){



		var account = document.getElementById('account').value;	

		location.href='magentosysorders.php?account='+account+"&module=orders";

		



	}







</script>