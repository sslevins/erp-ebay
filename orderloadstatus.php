<?php

include "include/config.php";





include "top.php";



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

					<td nowrap="nowrap" class='paginationActionButtons'>

                    

             <?php	
			 
			 
			 			
						
                    	    $start			= $_REQUEST['start'].'T00:00:00';
					 		$end			= $_REQUEST['end'].'T23:59:59';
							$account		= $_REQUEST['account'];
							$type		= $_REQUEST['type'];
							
							
							
							if($type == ''){
							if($account 	== 'all'){
							$sql 		 = "select ebay_token,ebay_account from ebay_account as a where a.ebay_user='$user' and ($ebayacc) ";
							}else{
							$sql 		 = "select ebay_token,ebay_account from ebay_account as a where a.ebay_user='$user' and ebay_account ='$account' ";
							}
							$sqla		 = $dbcon->execute($sql);
							$sql		 = $dbcon->getResultArray($sqla);
							$dbcon->free_result($sqla);
							
							
							for($i=0;$i<count($sql);$i++){
								 $token		 = $sql[$i]['ebay_token'];
								 $account	 = $sql[$i]['ebay_account'];
								 if($token != ""){
								GetSellerTransactions($start,$end,$token,$account);
									GetSellerTransactions02($start,$end,$token,$account);
								 }
								echo $account.' 同步成功';
							}
							}
							
							
							
						
						if($type == '' ){
						
						$sql		= "select * from ebay_order as a where ebay_user='$user'  and  ebay_status = '1' and (ebay_carrier = '' or ebay_carrier is null) ";
						
						}else{
						
						$sql		= "select * from ebay_order as a where ebay_user='$user'   and  ebay_status = '1'  ";
						
						}
					//	$sql		= "select * from ebay_order as a where ebay_id = 2147033 ";
						
						
					//	echo $sql;
						$sqla	= $dbcon->execute($sql);
						$sql	= $dbcon->getResultArray($sqla);
						
						$dbcon->free_result($sqla);
						
						
						for($i=0;$i<count($sql);$i++){
							$ebay_countryname	= $sql[$i]['ebay_countryname'];
							$ebay_carrier		= $sql[$i]['ebay_carrier'];
							
							$ebay_currency		= $sql[$i]['ebay_currency'];
							$ebay_total			= $sql[$i]['ebay_total'];
							$ebay_couny			= $sql[$i]['ebay_couny'];
							$ebay_id			= $sql[$i]['ebay_id'];
							$ebay_note			= $sql[$i]['ebay_note'];
							$ebay_ordersn		= $sql[$i]['ebay_ordersn'];
							$ebay_userid		= $sql[$i]['ebay_userid'];
							$ebay_account		= $sql[$i]['ebay_account'].',';
							$mail				= $sql[$i]['ebay_usermail'];
							/*检查是否有hei名单*/
							$ebay_username				= $sql[$i]['ebay_username'];
							$vv			= "select mail from ebay_hackpeoles where mail ='$mail' or userid ='$ebay_userid' or ebay_username ='$ebay_username' ";
							$vv			= $dbcon->execute($vv);
							$vv			= $dbcon->getResultArray($vv);
							if(count($vv) >= 1){
								
								if($hackorer >= 1){
								$ss				= "update ebay_order set ebay_status = '$hackorer' where ebay_id = '$ebay_id' ";
								$dbcon->execute($ss);
								$notes				= '系统自动将此订单转入黑名单';
								addordernote($ebay_id,$notes);
							
							
								}
							}
							
														
							$ss					= "select rates from ebay_currency where currency = '$ebay_currency' and user = '$user'";
							$ss					= $dbcon->execute($ss);
							$ss					= $dbcon->getResultArray($ss);
		
							$rates				= $ss[0]['rates']?$ss[0]['rates']:1;
							$ebay_total			= $ebay_total * $rates;
							// 将有留言订单转到有留言订单分类中去
							if($ebay_note != '' && $notesorderstatus >= 1){
							$ss				= "update ebay_order set ebay_status = '$notesorderstatus' where ebay_id = '$ebay_id' ";
							$dbcon->execute($ss);
							
								$notes				= '系统自动将此订单转入有留言订单分类中';
								addordernote($ebay_id,$notes);
								
							}
							/* 取得订单总得重量 */
							$totalweight			= 0;
							$goods_cost				= 0;
							$st	= "select sku,ebay_amount,ebay_shiptype,ebay_id from ebay_orderdetail where ebay_ordersn='$ebay_ordersn'";
							$st = $dbcon->execute($st);
							$st	= $dbcon->getResultArray($st);
							$shipstatus				= 0;
							for($t=0;$t<count($st);$t++){
								
								
								$ebay_id2					=  $st[$t]['ebay_id'];
								$sku						=  $st[$t]['sku'];
								
								
								if($user == 'vipshen') GetCountrytosku($ebay_countryname,$sku,$ebay_id2);
								
								
								
								$ebay_shiptype				=  $st[$t]['ebay_shiptype'];
								$ebay_amount				=  $st[$t]['ebay_amount'];
								$ss							= "select goods_weight,ebay_packingmaterial from ebay_goods where  goods_sn='$sku' and ebay_user ='$user' ";
								$ss							= $dbcon->execute($ss);
								$ss							= $dbcon->getResultArray($ss);
								if(count($ss) == 0){
									$vv			= "select goods_sncombine from ebay_productscombine where ebay_user='$user' and goods_sn='$sku'";
									$vv			= $dbcon->execute($vv);
									$vv 	 	= $dbcon->getResultArray($vv);
									if(count($vv) > 0){
									$goods_sncombine	= $vv[0]['goods_sncombine'];
									$goods_sncombine    = explode(',',$goods_sncombine);	
									for($e=0;$e<count($goods_sncombine);$e++){
											$pline			= explode('*',$goods_sncombine[$e]);
											$goods_sn		= $pline[0];
											$goddscount     = $pline[1] * $ebay_amount;
											$ee			= "SELECT goods_weight,ebay_packingmaterial FROM ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
											$ee			= $dbcon->execute($ee);
											$ee 	 	= $dbcon->getResultArray($ee);
											
											$ebay_packingmaterial	= $ee[0]['ebay_packingmaterial'];
											$kk			= " select * from ebay_packingmaterial where model ='$ebay_packingmaterial' and ebay_user='$user' ";
											$kk			= $dbcon->execute($kk);
											$kk 	 	= $dbcon->getResultArray($kk);
											$wweight	= $kk[0]['weight'];
											
											
											$totalweight		+=  $ee[0]['goods_weight'] * $goddscount + $wweight;
									}	
									}	
								}else{
						
								
											$ebay_packingmaterial	= $ss[0]['ebay_packingmaterial'];
											$kk			= " select * from ebay_packingmaterial where model ='$ebay_packingmaterial' and ebay_user='$user' ";
											$kk			= $dbcon->execute($kk);
											$kk 	 	= $dbcon->getResultArray($kk);
											$wweight	= $kk[0]['weight'];
											
											$goods_weight		=  $ss[0]['goods_weight'] * $ebay_amount + $wweight;
											$totalweight		+= $goods_weight;
								
								
								}
								
							}
							
						
				
							
							if($ebay_shiptype == '' ) $ebay_shiptype = $ebay_carrier;
							
				
							$ss				= "select * from  ebay_carrier where (($ebay_total between min and max) and  ($totalweight between weightmin and weightmax))  and ebay_account like '%$ebay_account%' and ebay_user ='$user'  ";
							/* 增加国家的过虑条件 */
							$ss				.= " and ( encounts like '%$ebay_countryname,%' or encounts like '%,any,%' )";
							/* 增加SKU的过虑条件 */
							$ss				.= " and ( skus like '%$sku%' or skus like '%any,%' )";
							
							/* 增加 from_ebaycarrier 的过虑条件 */
							$ss				.= " and ( from_ebaycarrier like '%$ebay_shiptype%' or from_ebaycarrier like '%any,%' )";
							
							
							
							$ss				.= " order by Priority asc  ";
							
				
		echo $ss;
		
							
							$ss = $dbcon->execute($ss);
							$ss	= $dbcon->getResultArray($ss);
							if(count($ss) > 0){
							
								$name			= 	$ss[0]['name'];
								$id				= 	$ss[0]['id'];
								$orderstatus	=   $ss[0]['orderstatus'];
								$ebay_warehouse	=   $ss[0]['ebay_warehouse'];
								
								
								$totalshipfee  	=	shipfeecalc($id,$totalweight,$ebay_countryname);
								
								$rr				= 	"update ebay_order set ebay_carrier='$name',orderweight='$totalweight',ordershipfee='$totalshipfee',packingtype='$ebay_packingmaterial'  ";								
								if($orderstatus > 0 ) $rr				.=   " ,ebay_status  ='$orderstatus' ";
								
								if($ebay_warehouse > 0 ) $rr				.=   " ,ebay_warehouse  ='$ebay_warehouse' ";
								
								
								$rr				.=   " where ebay_id = '$ebay_id'";
								$dbcon->execute($rr);
								
							}
						
							
						
						}
						
						?>
                        
						
                    

                    

                    &nbsp;				  </td>

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

		location.href='loadorder.php?days='+days+'&account='+account;

		

		

	}



</script>