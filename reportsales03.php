<?php
include "include/config.php";
error_reporting(ALL);


include "top.php";


@$account	= $_REQUEST['account'];
@$startdate	= $_REQUEST['startdate'];
@$enddate	= $_REQUEST['enddate'];
@$ebay_site	= $_REQUEST['ebay_site'];
	
	function getdata($sql){
		
		
		global $dbcon;
		$sql			= $dbcon->execute($sql);
		$sql			= $dbcon->getResultArray($sql);	
		$array['net']	= $sql[0]['net']?$sql[0]['net']:0;
		$array['fee']	= $sql[0]['fee']?$sql[0]['fee']:0;
		$array['gross']	= $sql[0]['gross']?$sql[0]['gross']:0;		
		return $array;
		
	}
	
	
 ?>
  <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status;?> </h2>
</div>



<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
		
	<td nowrap="nowrap" scope="row" >付款时间：
	  <input name="startdate" type="text" id="startdate" onclick="WdatePicker()" value="<?php echo $startdate;?>"/>
~
<input name="enddate" type="text" id="enddate" onclick="WdatePicker()" value="<?php echo $enddate;?>" />
<select name="account" id="account">
  <option value="">所有帐号</option>
  <?php 
					
					$sql	 = "select * from ebay_account where ebay_user='$user'";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 
					 	$caccount	= $sql[$i]['ebay_account'];
					 ?>
  <option value="<?php echo $caccount;?>"  <?php if($account == $caccount) echo "selected=\"selected\""?>><?php echo $caccount;?></option>
  <?php } ?>
</select>
&nbsp;
<input type="button" value="确定" onclick="searchs()" />
<input type="button" value="下载EXCEL" onclick="toxls()" /></td>
	</tr>
</table>
</div>
</form>
 <table width="90%" border="1" align="center" cellpadding="1" cellspacing="1" bordercolor="#009999" bgcolor="#000000">
<tr>
          <td bgcolor="#FFFFFF"><div align="center">付款时间</div></td>
          <td colspan="6" bgcolor="#FFFFFF"><div align="center">基础信息</div></td>
        <td colspan="2" bgcolor="#FFFFFF"><div align="center">收入</div></td>
        <td colspan="6" bgcolor="#FFFFFF"><div align="center">支出</div></td>
      </tr>
<tr>
  <td bgcolor="#FFFFFF"><div align="center"></div></td>
  <td bgcolor="#FFFFFF"><div align="center">订单号</div></td>
  <td bgcolor="#FFFFFF">派送方式</td>
  <td bgcolor="#FFFFFF"><div align="center">客户ID</div></td>
  <td bgcolor="#FFFFFF"><div align="center">收件人国家</div></td>
  <td bgcolor="#FFFFFF"><div align="center">SKU</div></td>
  <td bgcolor="#FFFFFF"><div align="center">数量</div></td>
  <td bgcolor="#FFFFFF"><div align="center">订单总金额</div></td>
  <td bgcolor="#FFFFFF"><div align="center">实收运费</div></td>
  <td bgcolor="#FFFFFF"><div align="center">商品成本</div></td>
  <td bgcolor="#FFFFFF"><div align="center">实付运费</div></td>
  <td bgcolor="#FFFFFF"><div align="center">ebay交易费</div></td>
  <td bgcolor="#FFFFFF"><div align="center">paypal交易费</div></td>
  <td bgcolor="#FFFFFF"><div align="center">包材费</div></td>
  <td bgcolor="#FFFFFF"><div align="center">毛利率</div></td>
  </tr>


<?php	
		
		if($startdate != '' && $enddate != '' ){
		
				$sdate		= strtotime($startdate.' 00:00:00');
				$edate		= strtotime($enddate.' 23:59:59');
			
		
				
				
				
				$countjs	= 1;
				
				$totalsales		= 0;
				$totalshipfee   = 0;
				$totalqty		= 0;
				
				$allproductcost = 0;
				
				$totalordershipfee = 0; // 实付运费
				$alltotalebayfee   = 0 ; // 一共有ebayfees
				
				$alltotalpaypalfees	= 0; // 一共有多少pp成功费
				$alltotalpackingcost	= 0;// 一巫有多少个包材费用
				
				
				$alltotalxiji			= 0;
				$allprofit				= 0;
				
				$allmll					= 0;
				
				
				for($i=1;$i<= 10000000; $i++){
				
				
				
				$searchstartdate		= strtotime(date('Y-m-d',$sdate).' 00:00:00');
				$searchenddate		= strtotime(date('Y-m-d',$sdate).' 23:59:59');
				
	
				
				
				$ss		= "SELECT  count(a.ebay_id) as totalqty,a.ebay_carrier,a.ordershipfee,a.ebay_id,a.ebay_ordersn,a.ebay_currency,a.ebay_total,a.ebay_userid,a.ebay_countryname,b.sku,b.ebay_amount,b.ebay_itemprice,b.shipingfee,b.FinalValueFee,b.FeeOrCreditAmount FROM ebay_order  as a  join ebay_orderdetail as b on a. ebay_ordersn = b.ebay_ordersn where a.ebay_combine!='1' and ebay_paidtime>=$searchstartdate and ebay_paidtime<=$searchenddate and a.ebay_user ='$user'  ";
				
				if($account != '' ) $ss .= " and a.ebay_account ='$account' ";
				$ss		.= " group by a.ebay_id";
				
				
				$ss		= $dbcon->execute($ss);
				$ss		= $dbcon->getResultArray($ss);
				$total 	= 0;
				for($h=0;$h<count($ss);$h++){
				
								
								$totalqty		= $ss[$h]['totalqty'];
								$ebay_ordersn		= $ss[$h]['ebay_ordersn'];
							
								$ebay_carrier		= $ss[$h]['ebay_carrier'];
								$ebay_countryname		= $ss[$h]['ebay_countryname'];
								$ebay_userid			= $ss[$h]['ebay_userid'];
								$ebay_id				= $ss[$h]['ebay_id'];
								$ebay_currency			= $ss[$h]['ebay_currency'];
								$sku					= $ss[$h]['sku'];
								$ebay_amount			= $ss[$h]['ebay_amount'];
								$shipingfee				= $ss[$h]['shipingfee'];
								$ebay_itemprice			= $ss[$h]['ebay_itemprice'];
								$FinalValueFee			= $ss[$h]['FinalValueFee'];
								$FeeOrCreditAmount		= $ss[$h]['FeeOrCreditAmount'];
								$ordershipfee			= $ss[$h]['ordershipfee'];
								$vv						= "select rates from ebay_currency where currency='$ebay_currency' and user='$user'";
								$vv						=  $dbcon->execute($vv);
								$vv						=  $dbcon->getResultArray($vv);
								$ssrates				=  $vv[0]['rates']?$vv[0]['rates']:1;
								
								

								
								$productcost		= 0;
								$productweight		= 0;
								$ebay_packingmaterialprice = 0;
								
								
								
								$vvg					= "select * from ebay_orderdetail where ebay_ordersn ='$ebay_ordersn'";
								$vvg 					= $dbcon->execute($vvg);
								$vvg					= $dbcon->getResultArray($vvg);
								
								
								$totalline			= 0 ;
								$totalshipfeezj		= 0;
								$FinalValueFeezj	= 0;
								$FeeOrCreditAmountzj	= 0;
								
								
								for($v=0;$v<count($vvg);$v++){
										
										
										$sku				= $vvg[$v]['sku'];
										$ebay_amount		= $vvg[$v]['ebay_amount'];
										$shipingfee			= $vvg[$v]['shipingfee'];
										$ebay_itemprice		= $vvg[$v]['ebay_itemprice'];
										$FinalValueFeezj		+= $vvg[$v]['FinalValueFee']* $ssrates;
										$FeeOrCreditAmountzj		= $vvg[$v]['FeeOrCreditAmount']* $ssrates;
										
										
										
										$totalline			+= ($ebay_itemprice * $ebay_amount + $shipingfee) * $ssrates;
										$totalshipfeezj		+= $shipingfee * $ssrates;
										
										$ssr			= "select goods_weight,goods_cost,ebay_packingmaterial from ebay_goods where goods_sn= '$sku' and ebay_user='$user'";
										
										
										$ssr 				= $dbcon->execute($ssr);
										$ssr				= $dbcon->getResultArray($ssr);
										
										
										
										if(count($ssr)>0){
											$sweight			= $ssr[0]['goods_weight'] * $ebay_amount;
											$scost				= $ssr[0]['goods_cost'] * $ebay_amount;
											$productcost		+= $scost;
											
											
											$productweight		= $productweight + $sweight;
											$ebay_packingmaterial			= $ssr[0]['ebay_packingmaterial'];
											$vv								= "select price from ebay_packingmaterial where model='$ebay_packingmaterial' and ebay_user='$user'";
											$vv								=  $dbcon->execute($vv);
											$vv								=  $dbcon->getResultArray($vv);
											$ebay_packingmaterialprice		+= $vv[0]['price'];
										
										
										}else{
											$ssr	= "select * from ebay_productscombine where ebay_user='$user' and goods_sn='$sku'";
											$ssr 	= $dbcon->execute($ssr);
											$ssr	= $dbcon->getResultArray($ssr);
											$goods_sncombine	= $ssr[0]['goods_sncombine'];
											$goods_sncombine    = explode(',',$goods_sncombine);	
											for($e=0;$e<count($goods_sncombine);$e++){
												$pline			= explode('*',$goods_sncombine[$e]);
												$goods_sn		= $pline[0];
												$goddscount     = $pline[1] * $ebay_amount;
												$ee			= "SELECT goods_cost,goods_weight,ebay_packingmaterial FROM ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
												$ee			= $dbcon->execute($ee);
												$ee 	 	= $dbcon->getResultArray($ee);
												$scost = $ee[0]['goods_cost']*$goddscount;
												$sweight = $ee[0]['goods_weight']*$goddscount;
												$productcost		+=  $scost;
												$productweight		= $productweight + $sweight;
												
												
												$ebay_packingmaterial			= $ee[0]['ebay_packingmaterial'];
												$vv								= "select price from ebay_packingmaterial where model='$ebay_packingmaterial' and ebay_user='$user'";
												$vv								=  $dbcon->execute($vv);
												$vv								=  $dbcon->getResultArray($vv);
												$ebay_packingmaterialprice		+= $vv[0]['price'];
											
											
											}
										}
								
								
								}
								
								
								$total	+= $totalline;
								$shipingfee	= $totalshipfeezj;
								$FinalValueFee	= $FinalValueFeezj;
								$FeeOrCreditAmount			= $FeeOrCreditAmountzj;
								
								
								
								$vv			= "select rates from ebay_currency where currency='RMB' and user='$user'";
								$vv			=  $dbcon->execute($vv);
								$vv			=  $dbcon->getResultArray($vv);
								$ssrates	=  $vv[0]['rates']?$vv[0]['rates']:1;
								$productcost				= $productcost * $ssrates;
								
								
								
								$ebay_packingmaterialprice	= $ebay_packingmaterialprice * $ssrates;
								
								$allproductcost		+= $productcost;
								$totalsales			+= $total;
								$totalshipfee		+= $shipingfee;
								
								
								
								
								
								if($ordershipfee <=0 && $ebay_carrier != ''){
								
									$ssr			= "select * from ebay_carrier  where name = '$ebay_carrier' and ebay_user='$user'";
									$ssr			=  $dbcon->execute($ssr);
									$ssr			=  $dbcon->getResultArray($ssr);
									$ebay_carrier	= $ssr[0]['name'];
									$id				= $ssr[0]['id'];
									$ordershipfee		= shipfeecalc($id,$productweight,$ebay_countryname);
								}
								
							//	$ordershipfee				= $ordershipfee * $ssrates;
								
								
								$mll				= $totalline - $productcost - $FinalValueFee - $FeeOrCreditAmount - $ordershipfee;
								$totalordershipfee	+= $ordershipfee;
								$alltotalebayfee	+= $FinalValueFee;
								$alltotalpaypalfees	+= $FeeOrCreditAmount;
								$alltotalpackingcost	+= $ebay_packingmaterialprice;
								
								$allmll				+= $mll;
								
								
								?>
                                

        <tr>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo date('Y-m-d',$sdate);?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo $ebay_id;?>&nbsp;</div></td>
          <td bgcolor="#FFFFFF"><?php echo $ebay_carrier;?>&nbsp;</td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo $ebay_userid;?>&nbsp;</div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo $ebay_countryname;?>&nbsp;</div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo $sku;?>&nbsp;</div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo $ebay_amount;?>&nbsp;</div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo number_format($totalline,2);
		  
		  ?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo number_format($shipingfee,2);?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo number_format($productcost,2);?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo number_format($ordershipfee,2);?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo number_format($FinalValueFee,2);?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo number_format($FeeOrCreditAmount,2);?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo number_format($ebay_packingmaterialprice,2);?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo $mll;?></div></td>
      </tr>
       
<?php
		
		}
		
					$sdate		= strtotime(date('Y-m-d H:i:s',strtotime("$startdate +".$countjs." days")));
					
					if($sdate >= $edate ) break;
					
					$countjs ++ ;
				
		
		}
		
		
		}
		


?>


 <tr>
          <td bgcolor="#FFFFFF"><div align="center">合计</div></td>
          <td bgcolor="#FFFFFF"><div align="center"></div></td>
          <td bgcolor="#FFFFFF">&nbsp;</td>
          <td bgcolor="#FFFFFF"><div align="center"></div></td>
          <td bgcolor="#FFFFFF"><div align="center"></div></td>
          <td bgcolor="#FFFFFF"><div align="center"></div></td>
          <td bgcolor="#FFFFFF"><div align="center"></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo number_format($total,2);?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo number_format($totalshipfee,2);?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo number_format($allproductcost,2);?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo number_format($totalordershipfee,2);?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo number_format($alltotalebayfee,2);?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo number_format($alltotalpaypalfees,2);?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo number_format($alltotalpackingcost,2);?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo number_format($allmll,2);?></div></td>
        </tr>
      </table>
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
	  <td></td>
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
	

	
	function searchs(){
		var startdate		= document.getElementById('startdate').value;
		var enddate			= document.getElementById('enddate').value;
		var account			= document.getElementById('account').value;
		var ebay_site		= '';
		
		location.href = 'reportsales03.php?startdate='+startdate+'&enddate='+enddate+"&account="+account+"&module=report&ebay_site="+ebay_site;
	
	
	
	}

function toxls(){
		var startdate		= document.getElementById('startdate').value;
		var enddate			= document.getElementById('enddate').value;
		var account			= document.getElementById('account').value;
		var ebay_site		= '';
		
		location.href = 'toxls/reportsalestoxls03.php?startdate='+startdate+'&enddate='+enddate+"&account="+account+"&module=report&ebay_site="+ebay_site;
	
	
	
	}


</script>