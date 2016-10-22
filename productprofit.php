<?php
include "include/config.php";


include "top.php";
$virifydays		= $_REQUEST['virifydays'];
$type	= $_REQUEST['type'];
$sorts		= $_REQUEST['sorts'];

	
				$startdate		= $_REQUEST['startdate'];
				$enddate		= $_REQUEST['enddate'];
				$account		= $_REQUEST['account'];
				$goodscategory	= $_REQUEST['goodscategory'];
				$skus			= $_REQUEST['sku'];
				$startdate2		= $_REQUEST['startdate2'];
				$enddate2		= $_REQUEST['enddate2'];
$ebay_site		= $_REQUEST['ebay_site'];

	
	
 ?>
  <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>
  
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status;?> </h2>
</div>

<div class='listViewBody'>

<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
	<td nowrap="nowrap" scope="row" >&nbsp;产品销售时间：
	  <input name="startdate" type="text" id="startdate" onClick="WdatePicker()" value="<?php echo $startdate;?>"/>
	  ~
	  <input name="enddate" type="text" id="enddate" onClick="WdatePicker()" value="<?php echo $enddate;?>" />
	  
	  
	  产品开发时间：
	  <input name="startdate2" type="text" id="startdate2" onclick="WdatePicker()" value="<?php echo $startdate2;?>"/>
	  ~
      <input name="enddate2" type="text" id="enddate2" onclick="WdatePicker()" value="<?php echo $enddate2;?>" />
<br />
	  <br />
	  产品编号：
	  <input name="sku" type="text" id="sku" value='<?php echo $skus;?>'/>
	  货品类别：
<select name="goodscategory" id="goodscategory">
                            <option value="-1">Please Select</option>
                            <?php
							
							$tsql		= "select * from ebay_goodscategory where ebay_user='$user'";
							$tsql		= $dbcon->execute($tsql);
							$tsql		= $dbcon->getResultArray($tsql);
							for($i=0;$i<count($tsql);$i++){
								
								$categoryid		= $tsql[$i]['id'];
								$categoryname	= $tsql[$i]['name'];								
								
								
							?>
                            
                            <option value="<?php echo $categoryid;?>"  <?php if($categoryid == $goodscategory) echo "selected=\"selected\""?>><?php echo $categoryname; ?></option>
                            
                            <?php
							
							}
							
							
							?>
                            
            </select>
	  帐号：<select name="account" id="account">
<option value="">Please Select</option>
                    <?php 
					
					$sql	 = "select ebay_account from ebay_account where ebay_user='$user'";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 
					 	$caccount	= $sql[$i]['ebay_account'];
					 ?>
                      <option value="<?php echo $caccount;?>"  <?php if($account == $caccount) echo "selected=\"selected\""?>><?php echo $caccount;?></option>
                    <?php } ?>
                    </select>
	  <select name="sortart" id="sortart">
	    <option value="-1">Please Select</option>
        <option value="1" <?php if($sorts == '1') echo 'selected="selected"';?>>按销售数量排序</option>
        <option value="2" <?php if($sorts == '2') echo 'selected="selected"';?>>按总售价排序</option>
        <option value="3" <?php if($sorts == '3') echo 'selected="selected"';?>>按总利润排序</option>
    
	    </select>
	  站点:

      <select name="ebay_site" id="ebay_site" style="width:90px" >
            <option value="">选择</option>
            <option value="US" <?php if($ebay_site == 'US' ) echo 'selected="selected"';?> >US</option>
            <option value="UK" <?php if($ebay_site == 'UK' ) echo 'selected="selected"';?> >UK</option>
            <option value="Germany" <?php if($ebay_site == 'Germany' ) echo 'selected="selected"';?> >Germany</option>
            <option value="France" <?php if($ebay_site == 'France' ) echo 'selected="selected"';?> >France</option>
            <option value="eBayMotors" <?php if($ebay_site == 'eBayMotors' ) echo 'selected="selected"';?> >eBayMotors</option>
            <option value="Canada" <?php if($ebay_site == 'Canada' ) echo 'selected="selected"';?> >Canada</option>
            <option value="Australia" <?php if($ebay_site == 'Australia' ) echo 'selected="selected"';?> >Australia</option>
          </select>
          
          
<input type="button" value="统计" onclick="searchorder()" />
<input type="button" value="查询结果导出" onclick="searchordertoxls()" /></td>
</tr>
</table>
</div>

<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr >
		<td colspan='14'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' >
				<tr>
					<td nowrap="nowrap" width='2%' >&nbsp;</td>
				  <td  nowrap='nowrap' width='1%' align="right" class='paginationChangeButtons'>				  </td>
				</tr>
			</table>		</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>Sku</div></th>
			
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>产品名称</div>			</th>
				<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>产品状态</div>			</th>
			
					<th scope='col' nowrap="nowrap"><span class="left_bt2">产品成本</span></th>
		            <th scope='col' nowrap="nowrap">总销量</th>
	                <th scope='col' nowrap="nowrap">总销售额</th>
	                <th scope='col' nowrap="nowrap">总ebay费用</th>
	                <th scope='col' nowrap="nowrap"> 总paypal费用</th>
	                <th scope='col' nowrap="nowrap">总成本</th>
	                <th scope='col' nowrap="nowrap">退款总金额</th>
	                <th scope='col' nowrap="nowrap">重寄总成本</th>
	                <th scope='col' nowrap="nowrap">总运费</th>
	                <th scope='col' nowrap="nowrap">总利润</th>
	                <th scope='col' nowrap="nowrap">差评/重寄/垦款</th>
	                <th scope='col' nowrap="nowrap">备注</th>
	</tr>
		


			  <?php
			  	
	
				


				$type		= $_REQUEST['type'];
				

				
				if(($sorts != '' && $sorts != '-1') || isset($_REQUEST['pageindex'])){
				

				}else{
					
					
					$vv			= "delete from ebay_goodssort where ebay_user='$user'";
					$dbcon->query($vv);
					
					
					/* 写入排序表 */
					
					$sql2		= "select goods_sn,goods_name,goods_cost,goods_weight from ebay_goods where ebay_user='$user'";
					if($skus	!= '') $sql2 .= " and goods_sn = '$skus'";
					if($goodscategory!="" && $goodscategory !="-1"){
						$ss				= "select * from ebay_goodscategory where pid ='$goodscategory' ";
						$ss				= $dbcon->execute($ss);
						$ss				= $dbcon->getResultArray($ss);

						if(count($ss) == 0){
							$sql2	.= " and goods_category='$goodscategory' ";
						}else{
							$strline		= '';
							for($i=0;$i<count($ss);$i++){
								$pid		= $ss[$i]['id'];
								$strline	.= " goods_category='$pid' or ";
							}
							$strline		= substr($strline,0,strlen($strline)-3);
							$sql2	.= " and ( $strline )";
						}
					}
					$sql2		= $dbcon->execute($sql2);
					$sql2		= $dbcon->getResultArray($sql2);
					
					for($i=0;$i<count($sql2);$i++){
					$goods_sn		= $sql2[$i]['goods_sn'];
					$goods_name		= $sql2[$i]['goods_name'];
					$goods_cost		= $sql2[$i]['goods_cost'];
					$goods_weight	= $sql2[$i]['goods_weight'];
					
						/**/
							
							
							
							
							
							$dsql			= "SELECT sum(b.ebay_amount) as qty,sum(FinalValueFee) as FinalValueFee,sum(FeeOrCreditAmount) as FeeOrCreditAmount,sum(b.ebay_amount * b.ebay_itemprice) as totalprice,ebay_currency,ebay_carrier,ebay_countryname FROM ebay_order AS a JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn WHERE sku =  '$goods_sn'";
							if($account != "-1" && $account !=''){ $dsql .= " and a.ebay_account='$account'";}
							if($startdate !='' && $enddate !='') $dsql .= " and (a.ebay_paidtime>'".strtotime($startdate." 00:00:00")."' && a.ebay_paidtime<'".strtotime($enddate." 23:59:59")."')";						
							
							if($ebay_site != '' ) $dsql	.= " and b.ebay_site ='$ebay_site' ";
						
							
							$dsql			.= " group by a.ebay_carrier,a.ebay_currency ";
							$dsql			= $dbcon->execute($dsql);
							$dsql			= $dbcon->getResultArray($dsql);
							$totalqty		= 0;
							$totalprice		= 0;
							$totalFinalValueFee	= 0;
							$totalFeeOrCreditAmount		= 0;
							$totalshipfee				= 0;
							
							for($v=0;$v<count($dsql);$v++){
							
								$ebay_countryname				= $dsql[$v]['ebay_countryname'];
								$ebay_carrier					= $dsql[$v]['ebay_carrier'];
								$qty							= $dsql[$v]['qty'];
								
								$totalweight					= $goods_weight * $qty;
								
								if($ebay_carrier != ''){
								$vv		= "select id from ebay_carrier where name = '$ebay_carrier' ";
								
						
								
								$vv		= $dbcon->execute($vv);
								$vv		= $dbcon->getResultArray($vv);
								$id				= $vv[0]['id'];
								if($ebay_carrier != ''){
								 $totalshipfee	+= shipfeecalc($id,$totalweight,$ebay_countryname);
								}
								
								
								}
								
								$totalqty	= $totalqty + $qty;
								
								$total					= $dsql[$v]['totalprice'];
								$ebay_currency			= $dsql[$v]['ebay_currency'];
								$FinalValueFee			= $dsql[$v]['FinalValueFee'];
								$FeeOrCreditAmount		= $dsql[$v]['FeeOrCreditAmount'];
								
								$vv			= "select rates from ebay_currency where currency='$ebay_currency' and user='$user'";
								$vv			=  $dbcon->execute($vv);
								$vv			=  $dbcon->getResultArray($vv);
								$ssrates	=  $vv[0]['rates']?$vv[0]['rates']:1;
								
								$totalprice				+= $total * $ssrates;			// 总销售额
								$totalFinalValueFee		+= $FinalValueFee * $ssrates;	// 成交费用
								$totalFeeOrCreditAmount	+= $FeeOrCreditAmount * $ssrates;	// 成交费用
								
								
							}
							// $sqlsku = "select goods_sn,goods_sncombine from ebay_productscombine where goods_sncombine like '%$goods_sn%'";
							// $sqlsku = $dbcon->execute($sqlsku);
							// $sqlsku = $dbcon->getResultArray($sqlsku);
							// if(count($sqlsku)>0){
							// foreach($sqlsku as $k=>$v){
								// $sku = $v['goods_sn'];
								// $goods_sncombine = explode(',',$v['goods_sncombine']);
								// $goods_count = 0;
								// foreach($goods_sncombine as $kkk=>$vvv){
									// if(strpos($vvv,$goods_sn)>-1){
										// $goods = explode('*',$vvv);
										// $goods_count = $goods[1];
									// }
								// }
								// $vsql = "select sum(ebay_amount*$goods_count) as goods_count from ebay_orderdetail where sku='$sku'";
								// $vsql = $dbcon->execute($vsql);
								// $vsql = $dbcon->getResultArray($vsql);
								// $totalqty +=$vsql[0]['goods_count'];
							// }
							// }
							/* 计算产品总成本 */
							
							$vv			= "select rates from ebay_currency where currency='RMB' and user='$user'";
							$vv			=  $dbcon->execute($vv);
							$vv			=  $dbcon->getResultArray($vv);
							$ssrates	=  $vv[0]['rates']?$vv[0]['rates']:1;
							$allcost			= $vv[0]['goods_cost'] * $totalqty;
							$allcost		= $allcost*$ssrates;
							$allshipfee		= $totalshipfee*$ssrates;
							
							
							/* 计算退款总金额 */
							$vv					= "select sum(ebay_refundamount) as cc from ebay_rma where `sku` = '$goods_sn' and  rtatype = '退款'";
							$vv					= $dbcon->execute($vv);
							$vv					= $dbcon->getResultArray($vv);
							$vvrefundcost		= $vv[0]['cc']?$vv[0]['cc']:0 ;
							
							
							/* 计算重寄总金额 */
							$vv					= "select sum(ebay_refundamount) as cc from ebay_rma where `sku` = '$goods_sn' and  rtatype = '重寄'";
							$vv					= $dbcon->execute($vv);
							$vv					= $dbcon->getResultArray($vv);
							$vvresendfundcost	= $vv[0]['cc']?$vv[0]['cc']:0 ;
							
							
							/* 总的利润 */
														
							$totalprofit		= ($totalprice - $totalFinalValueFee - $totalFeeOrCreditAmount)/$ssrates - $allcost - $vvrefundcost - $vvresendfundcost - $allshipfee;
							
							$ss		= "insert into ebay_goodssort(goods_sn,qty,totalprice,totalprofit,goods_cost,goods_name,ebay_user) values('$goods_sn','$totalqty','$totalprice','$totalprofit','$goods_cost','$goods_name','$user')";
							$dbcon->execute($ss);
							
						
						/**/
					
					
					}
				
					
					
					/*结束*/
				
				}
			
				
				$sql		= "select goods_sn,goods_name,goods_cost,qty,totalprice,totalprofit from ebay_goodssort where ebay_user='$user'";
				if($sorts	== '1') $sql .= "  order by qty desc ";
				if($sorts	== '2') $sql .= "  order by totalprice desc";
				if($sorts	== '3') $sql .= "  order by totalprofit desc ";

				$query		= $dbcon->query($sql);
				$total		= $dbcon->num_rows($query);
				
				
				$pagesizes		= 20;
				
				$pageindex  =( isset($_GET['pageindex']) )?$_GET['pageindex']:1;
				$limit = " limit ".($pageindex-1)*$pagesizes.",$pagesizes";
		
				
				$page=new page(array('total'=>$total,'perpage'=>$pagesizes));
				$sql = $sql.$limit;

				
				
				$sql		= $dbcon->execute($sql);
				$sql		= $dbcon->getResultArray($sql);
		
				for($i=0;$i<count($sql);$i++){
					$goods_sn		= $sql[$i]['goods_sn'];
					$goods_name		= $sql[$i]['goods_name'];
					$goods_cost		= $sql[$i]['goods_cost'];
					$totalqty			= $sql[$i]['qty'];
					$totalprice			= $sql[$i]['totalprice'];
					$totalprofit		= $sql[$i]['totalprofit'];
					$vv						= "select goods_weight,goods_status from ebay_goods where goods_sn ='$goods_sn' ";
					//echo $vv;
					//exit;
					$vv						= $dbcon->execute($vv);
					$vv						= $dbcon->getResultArray($vv);
					$goods_weight			= $vv[0]['goods_weight'];
					$goods_status			= $vv[0]['goods_status'];
?>

				
		
                  
         		<tr height='20' class='oddListRowS1'>
						<td scope='row' align='left' valign="top" >
                        
                        <a href="productview.php?goods_sn=<?php echo $goods_sn;?>&ebay_site=<?php echo $ebay_site;?>" target="_blank">
                        
                        
						  <?php echo $goods_sn; ?>         </a>                   </td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $goods_name;?></td>
							<td scope='row' align='left' valign="top" ><?php echo $goods_status;?></td>
						    <td scope='row' align='left' valign="top" ><?php  if(in_array('s_gm_vcost',$cpower)) echo $goods_cost;?>&nbsp;</td>
                            <td scope='row' align='left' valign="top" ><?php
                            
							
							
							
							
							$dsql			= "SELECT sum(b.ebay_amount) as qty,sum(FinalValueFee) as FinalValueFee,sum(FeeOrCreditAmount) as FeeOrCreditAmount,ebay_currency,ebay_carrier,ebay_countryname FROM ebay_order AS a JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn WHERE sku =  '$goods_sn'  ";
							if($account != "-1" && $account !=''){ $dsql .= " and a.ebay_account='$account'";}
							if($startdate !='' && $enddate !='') $dsql .= " and (a.ebay_paidtime>='".strtotime($startdate." 00:00:00")."' && a.ebay_paidtime<='".strtotime($enddate." 23:59:59")."')";						
							
							if($startdate2 !='' && $enddate2 !='') $sql .= " and (a.addtim>'".strtotime($startdate2." 00:00:00")."' && a.addtim<'".strtotime($enddate2." 23:59:59")."')";						
					
					
					
							
							
							if($ebay_site != '' ) $dsql	.= " and b.ebay_site ='$ebay_site' ";
							$dsql			.= " group by a.ebay_carrier,a.ebay_currency ";
							
							$dsql			= $dbcon->execute($dsql);
							$dsql			= $dbcon->getResultArray($dsql);
							
							
							//die();
							
							//$totalqty		= 0;
							//$totalprice		= 0;
							$totalFinalValueFee	= 0;
							$totalFeeOrCreditAmount		= 0;
							$totalshipfee				= 0;
							
							for($v=0;$v<count($dsql);$v++){
							
								$ebay_countryname				= $dsql[$v]['ebay_countryname'];
								$ebay_carrier					= $dsql[$v]['ebay_carrier'];
								$qty							= $dsql[$v]['qty'];
								
								$totalweight					= $goods_weight * $qty;
								
								if($ebay_carrier != ''){
								$vv		= "select id from ebay_carrier where name = '$ebay_carrier' ";
								
						
								
								$vv		= $dbcon->execute($vv);
								$vv		= $dbcon->getResultArray($vv);
								$id				= $vv[0]['id'];
								if($ebay_carrier != ''){
								 $totalshipfee	+= shipfeecalc($id,$totalweight,$ebay_countryname);
								}
								
								
								}
								
								//$totalqty	= $totalqty + $qty;
								
								//$total					= $dsql[$v]['totalprice'];
								$ebay_currency			= $dsql[$v]['ebay_currency'];
								$FinalValueFee			= $dsql[$v]['FinalValueFee'];
								$FeeOrCreditAmount		= $dsql[$v]['FeeOrCreditAmount'];
								
								$vv			= "select rates from ebay_currency where currency='$ebay_currency' and user='$user'";
								$vv			=  $dbcon->execute($vv);
								$vv			=  $dbcon->getResultArray($vv);
								$ssrates	=  $vv[0]['rates']?$vv[0]['rates']:1;
								
								//$totalprice				+= $total * $ssrates;			// 总销售额
								$totalFinalValueFee		+= $FinalValueFee * $ssrates;	// 成交费用
								$totalFeeOrCreditAmount	+= $FeeOrCreditAmount * $ssrates;	// 成交费用
								
								
							}
							// $sqlsku = "select goods_sn,goods_sncombine from ebay_productscombine where goods_sncombine like '%$goods_sn%'";
							// $sqlsku = $dbcon->execute($sqlsku);
							// $sqlsku = $dbcon->getResultArray($sqlsku);
							// if(count($sqlsku)>0){
							// foreach($sqlsku as $k=>$v){
								// $sku = $v['goods_sn'];
								// $goods_sncombine = explode(',',$v['goods_sncombine']);
								// $goods_count = 0;
								// foreach($goods_sncombine as $kkk=>$vvv){
									// if(strpos($vvv,$goods_sn)>-1){
										// $goods = explode('*',$vvv);
										// $goods_count = $goods[1];
									// }
								// }
								// $vsql = "select sum(ebay_amount*$goods_count) as goods_count from ebay_orderdetail where sku='$sku'";
								// $vsql = $dbcon->execute($vsql);
								// $vsql = $dbcon->getResultArray($vsql);
								// $totalqty +=$vsql[0]['goods_count'];
							// }
							// }
							/* 计算产品总成本 */
							echo $totalqty;
							
							
							/* 计算退款总金额 */
							$vv					= "select sum(ebay_refundamount) as cc from ebay_rma where `sku` = '$goods_sn' and  rtatype = '退款'";
							$vv					= $dbcon->execute($vv);
							$vv					= $dbcon->getResultArray($vv);
							$vvrefundcost		= $vv[0]['cc']?$vv[0]['cc']:0 ;
							
							
							/* 计算重寄总金额 */
							$vv					= "select sum(ebay_refundamount) as cc from ebay_rma where `sku` = '$goods_sn' and  rtatype = '重寄'";
							$vv					= $dbcon->execute($vv);
							$vv					= $dbcon->getResultArray($vv);
							$vvresendfundcost	= $vv[0]['cc']?$vv[0]['cc']:0 ;
							
							
							/* 总的利润 */
							
							
							
							
			
							
							?>&nbsp;</td>
                            <td scope='row' align='left' valign="top" ><?php echo number_format($totalprice,2);?>&nbsp;</td>
                            <td scope='row' align='left' valign="top" ><?php echo number_format($totalFinalValueFee,2);?>&nbsp;</td>
                            <td scope='row' align='left' valign="top" ><?php if(in_array('s_gm_vcost',$cpower)) echo number_format($totalFeeOrCreditAmount,2);?>&nbsp;</td>
                            <td scope='row' align='left' valign="top" ><?php if(in_array('s_gm_vcost',$cpower)) echo $goods_cost;?>&nbsp;</td>
                  <td scope='row' align='left' valign="top" ><?php echo $vvrefundcost;?>&nbsp;</td>
	              <td scope='row' align='left' valign="top" ><?php echo $vvresendfundcost;?></td>
	              <td scope='row' align='left' valign="top" ><?php if(in_array('s_gm_vcost',$cpower)) echo $totalshipfee;?>&nbsp;</td>
	              <td scope='row' align='left' valign="top" ><?php
				  
				 if(in_array('s_gm_vcost',$cpower)) echo number_format($totalprofit,2);
				  
				  
				  ?>&nbsp;</td>
	              <td scope='row' align='left' valign="top" >
                  <?php
				  	
					
					$nn				= "select count(*) as cc from ebay_rma where `sku` = '$goods_sn' and  rtatype = '差评'";
					$nn				= $dbcon->execute($nn);
					$nn				= $dbcon->getResultArray($nn);
				  	echo $nn[0]['cc'].'/';
					
					$nn				= "select count(*) as cc from ebay_rma where `sku` = '$goods_sn' and  rtatype = '重寄'";
					$nn				= $dbcon->execute($nn);
					$nn				= $dbcon->getResultArray($nn);
				  	echo $nn[0]['cc'].'/';
				
					$nn				= "select count(*) as cc from ebay_rma where `sku` = '$goods_sn' and  rtatype = '垦款'";
					$nn				= $dbcon->execute($nn);
					$nn				= $dbcon->getResultArray($nn);
				  	echo $nn[0]['cc'];
					
				  
				  ?>
                  
                  
                  
                  
                  &nbsp;</td>
	              <td scope='row' align='left' valign="top" ><strong>
                  <a href="productprofitview.php?sku=<?php echo $goods_sn;?>" target="_blank">
                  添加备注                  </a>
                  
                  </strong></td>
	  </tr>
      


 <?php } ?>
        
		<tr class='pagination'>
		<td colspan='14'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'><div align="center">
					  <?    echo '<br><center>'.$page->show(2)."</center>";//输出分页 ?>
					</div></td>
					</tr>
			</table>		</td>
	</tr></table>


    <div class="clear"></div>
<?php

include "bottom.php";


?>
<script language="javascript">


function check_all(obj,cName)
{
    var checkboxs = document.getElementsByName(cName);
    for(var i=0;i<checkboxs.length;i++){
		if(checkboxs[i].checked == false){
			
			checkboxs[i].checked = true;
		}else{
			
			checkboxs[i].checked = false;
		}	
		
	}
}




function searchorder(){
	
		var startdate2			 	= document.getElementById('startdate2').value;
			var enddate2			 	= document.getElementById('enddate2').value;
		
var ebay_site			 	= document.getElementById('ebay_site').value;
		var startdate 		= document.getElementById('startdate').value;	
		var enddate 		= document.getElementById('enddate').value;	
		var goodscategory 	= document.getElementById('goodscategory').value;	
		var account 	= document.getElementById('account').value;	
		var sku			 	= document.getElementById('sku').value;	
		var sortart			 	= document.getElementById('sortart').value;	
		var virifydays			 	='';
		
		var url = 'productprofit.php?startdate='+startdate+"&enddate="+enddate+"&account="+account+"&goodscategory="+goodscategory+"&module=finance&action=产品利润统计&sku="+encodeURIComponent(sku)+"&sorts="+sortart+"&enddate2="+enddate2+"&startdate2="+startdate2+"&ebay_site="+ebay_site;
		
		
		location.href=url;
		
		
	}
	


function searchordertoxls(){
	
		var startdate2			 	= document.getElementById('startdate2').value;
			var enddate2			 	= document.getElementById('enddate2').value;
		
var ebay_site			 	= document.getElementById('ebay_site').value;
		var startdate 		= document.getElementById('startdate').value;	
		var enddate 		= document.getElementById('enddate').value;	
		var goodscategory 	= document.getElementById('goodscategory').value;	
		var account 	= document.getElementById('account').value;	
		var sku			 	= document.getElementById('sku').value;	
		var sortart			 	= document.getElementById('sortart').value;	
		var virifydays			 	='';
		
		var url = 'productprofitexport.php?startdate='+startdate+"&enddate="+enddate+"&account="+account+"&goodscategory="+goodscategory+"&module=finance&action=产品利润统计&sku="+encodeURIComponent(sku)+"&sorts="+sortart+"&enddate2="+enddate2+"&startdate2="+startdate2+"&ebay_site="+ebay_site;
		
		
		location.href=url;
		
		
	}
	
	function exportorder(){
	
		

		var startdate 		= document.getElementById('startdate').value;	
		var enddate 		= document.getElementById('enddate').value;	
		var goodscategory 	= document.getElementById('goodscategory').value;	
		var account 	= document.getElementById('account').value;	
		var sku			 	= document.getElementById('sku').value;	
		
		var url = 'productprofitxls.php?startdate='+startdate+"&enddate="+enddate+"&account="+account+"&goodscategory="+goodscategory+"&module=finance&action=产品利润统计&sku="+encodeURIComponent(sku);
		
		location.href=url;
		
		
	}
	
	
	





</script>