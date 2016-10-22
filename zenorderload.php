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

                    <td width="41%" height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right">eBay Account</div></td>

                    <td width="3%" align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>

                    <td width="56%" height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">

                    <select name="account" id="account">

                    <?php 

					

					$sql	 = "select * from ebay_zen where user='$user'";

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
							$sql = "select * from ebay_zen where zen_name='$laccount'";
							
							$sql = $dbcon->execute($sql);
							$sql = $dbcon->getResultArray($sql);
							
							
							$zen_name		= $sql[0]['zen_name'];
							$zen_server		= $sql[0]['zen_server'];
							$zen_username	= $sql[0]['zen_username'];
							$zen_password	= $sql[0]['zen_password'];
							$zen_database	= $sql[0]['zen_database'];
							
						
						
						
						print_r($sql);
						
							
							$host=$zen_server;
							$root=$zen_username;
							$password=$zen_password;
							$dbname=$zen_database;
							$did		= mysql_connect($host,$root,$password) or die("webstore 数据库连接失败");
							mysql_selectdb($zen_database) or die("数据连接失败00");
							
							$ss				= "select * from zen_orders where orders_status='2' order by orders_id desc";
							$result = mysql_query($ss) or die("数据库查询失败");	
							$billcount = 0;
							
							while($row = mysql_fetch_assoc($result)){
							
								
								$ebay_ordersn 			= $row['orders_id'];
								$ebay_paystatus      	= 'Complete';
								$recordnumber 			= $row['orders_id'];
								$recordnumber 			= $row['orders_id'];
								$ebay_paidtime 			= strtotime($row['date_purchased']);
								$ebay_userid 			= str_rep($row['delivery_name']);
								$ebay_username 			= str_rep($row['delivery_name']);
								$ebay_usermail 			= str_rep($row['customers_email_address']);
								$ebay_street 			= str_rep($row['delivery_street_address']);
								$ebay_street1 			= str_rep($row['delivery_suburb']);
								$ebay_city	 			= str_rep($row['delivery_city']);
								$ebay_state	 			= str_rep($row['delivery_state']);
								
								$ebay_countryname		= $row['delivery_country'];
								$ebay_postcode			= $row['delivery_postcode'];
								$ebay_phone				= $row['customers_telephone'];
								$ebay_currency			= $row['currency'];
								$ebay_total				= $row['order_total'];
								$ebay_status			= '1';
								
								
								
								$ss						= "select * from ebay_order where ebay_ordersn='$ebay_ordersn' and ebay_account='$laccount'";
								
							
								
								if(queryrows($ss)){
								
									
									
												
												
								
								}else{
								
								/*添加订单资料*/
								
								$addsql		 =  "insert into ebay_order(ebay_ordersn,ebay_paystatus,recordnumber,ebay_createdtime,ebay_paidtime,ebay_userid,ebay_username,ebay_usermail,";
								$addsql		.= "ebay_street,ebay_street1,ebay_city,ebay_state,ebay_countryname,ebay_postcode,ebay_phone,ebay_currency,ebay_total,ebay_status,ebay_user,";
								$addsql		.= "ebay_addtime,ebay_account,ordertype) values('$ebay_ordersn','$ebay_paystatus','$recordnumber','$mctime','$ebay_paidtime','$ebay_userid',";
								$addsql		.= "'$ebay_username','$ebay_usermail','$ebay_street','$ebay_street1','$ebay_city','$ebay_state','$ebay_countryname','$ebay_postcode','$ebay_phone'";
								$addsql	    .= ",'$ebay_currency','$ebay_total','$ebay_status','$user','$mctime','$laccount','1')";
								
								
							
								
								if(abcquery($addsql)){
								
									echo $ebay_userid." 订单同步成功<br>";
									
									
									$bddsql		= "select * from zen_orders_products where orders_id='$ebay_ordersn'";
									$bbresult = mysql_query($bddsql,$did) or die("数据库查询失败");	
									while($bbrow = mysql_fetch_assoc($bbresult)){
											$ebay_itemid		= $bbrow['products_id'];
											$ebay_itemtitle		= str_rep($bbrow['products_name']);
											$sku				= str_rep($bbrow['products_model']);
											$ebay_itemprice		= $bbrow['final_price'];
											$ebay_amount		= $bbrow['products_quantity'];
											$orders_products_id		= $bbrow['orders_products_id'];
											
											
											$ss					= "select * from ebay_orderdetail where recordnumber='$orders_products_id' and ebay_account='$laccount'";
											if(queryrows($ss)){
								
							
								
											}else{
												
												
												$bbsql				=  "insert into  ebay_orderdetail(recordnumber,ebay_ordersn,ebay_itemid,ebay_itemtitle,sku,ebay_itemprice,ebay_amount,ebay_createdtime,ebay_user";
												$bbsql				.= ",ebay_account,addtime) values('$orders_products_id','$ebay_ordersn','$ebay_itemid','$ebay_itemtitle','$sku','$ebay_itemprice','$ebay_amount','$mctime','$ebay_user','$laccount','$mctime')";
											
												if(abcquery($bbsql)){echo $ebay_itemtitle." 产品添加成功<br>";}
											
											}
											
									
											
									
									}
									
									
								
								}
								
								
								}
								
								
								
							
								
								
								
							}
							
		
							
							
						
						
						
						
						}
						
						
					function abcquery($str){		
		
					$status = 0;		
					$abc	= mysql_connect("localhost","ebaytools001","shop123456") or die("数据库连接失败");
					mysql_selectdb('samhuang_ebaytools') or die("数据连接失败");
					if(mysql_query($str,$abc)){				
						$status = 1;		
					}else{			
						$status = 0;			
					}		
					return $status;		
				   }
	
						
						
						
					function queryrows($str){		
		
						$status = 0;			
						$ab	=  mysql_connect("localhost","ebaytools001","shop123456") or die("数据库连接失败");
					mysql_selectdb('samhuang_ebaytools') or die("数据连接失败");
						$result = mysql_query($str,$ab);
						$result = mysql_num_rows($result);		
						return $result;
							
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



include "bottom.php";




?>

<script language="javascript">

	function check(){

		

	
		

		var account = document.getElementById('account').value;	

		location.href='zenorderload.php?account='+account+"&module=zencart";

		

		

	}



</script>