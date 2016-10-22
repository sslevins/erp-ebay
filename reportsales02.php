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
 <table width="80%" border="1" align="center" cellpadding="1" cellspacing="1" bordercolor="#009999" bgcolor="#000000">
<tr>
          <td bgcolor="#FFFFFF"><div align="center">付款时间</div></td>
        <td colspan="3" bgcolor="#FFFFFF"><div align="center">收入</div></td>
        <td colspan="8" bgcolor="#FFFFFF"><div align="center">支出</div></td>
        <td bgcolor="#FFFFFF"><div align="center">商品销量</div></td>
      </tr>
<tr>
  <td bgcolor="#FFFFFF"><div align="center"></div></td>
  <td bgcolor="#FFFFFF"><div align="center">订单总金额</div></td>
  <td bgcolor="#FFFFFF"><div align="center">实收运费</div></td>
  <td bgcolor="#FFFFFF"><div align="center">小计</div></td>
  <td bgcolor="#FFFFFF"><div align="center">商品成本</div></td>
  <td bgcolor="#FFFFFF"><div align="center">实付运费</div></td>
  <td bgcolor="#FFFFFF"><div align="center">ebay交易费</div></td>
  <td bgcolor="#FFFFFF"><div align="center">paypal交易费</div></td>
  <td bgcolor="#FFFFFF"><div align="center">包材费</div></td>
  <td bgcolor="#FFFFFF"><div align="center">小计</div></td>
  <td bgcolor="#FFFFFF"><div align="center">利润</div></td>
  <td bgcolor="#FFFFFF"><div align="center">毛利率</div></td>
  <td bgcolor="#FFFFFF"><div align="center"></div></td>
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
				
				
				for($i=1;$i<= 10000000; $i++){
				
				
				
				$searchstartdate		= strtotime(date('Y-m-d',$sdate).' 00:00:00');
				$searchenddate		= strtotime(date('Y-m-d',$sdate).' 23:59:59');
				
	
				
				
				$ss		= "SELECT  sum(a.ebay_total) as total,sum(ebay_shipfee) as ebay_shipfee, ebay_currency FROM ebay_order  as a where a.ebay_combine!='1' and ebay_paidtime>=$searchstartdate and ebay_paidtime<=$searchenddate and ebay_user ='$user'  ";
				
				if($account != '' ) $ss .= " and a.ebay_account ='$account' ";
				
				$ss		.= " group by a.ebay_currency";
				
				$ss		= $dbcon->execute($ss);
				$ss		= $dbcon->getResultArray($ss);
				
				$total 	= 0;
				$ebay_shipfee	= 0;
				
				
				for($h=0;$h<count($ss);$h++){
				
								$ebay_currency	= $ss[$h]['ebay_currency'];
								$vv			= "select rates from ebay_currency where currency='$ebay_currency' and user='$user'";
								$vv			=  $dbcon->execute($vv);
								$vv			=  $dbcon->getResultArray($vv);
								$ssrates	=  $vv[0]['rates']?$vv[0]['rates']:1;
								$total		+= ($ss[$h]['total'] * $ssrates);
								$ebay_shipfee		+= ($ss[$h]['ebay_shipfee'] * $ssrates);
								
				}
				
				$totalsales	+= $total;
				$totalshipfee += $ebay_shipfee;
				
				
				
				
				/* 计算实收运费 vs 实付运费 */
				
				$ss		= "SELECT  sum(ebay_shipfee) as ebay_shipfee,sum(ordershipfee) as ordershipfee FROM ebay_order  as a where a.ebay_combine!='1' and ebay_paidtime>=$searchstartdate and ebay_paidtime<=$searchenddate and ebay_user ='$user' ";
				if($account != '' ) $ss .= " and a.ebay_account ='$account' ";
				
				$ss		= $dbcon->execute($ss);
				$ss		= $dbcon->getResultArray($ss);
				
				$ordershipfee	= $ss[0]['ordershipfee'];
				
				$totalordershipfee += $ordershipfee;

				
				/* 计算实际产品销量 */
				
				$dsql			= "SELECT sum(b.ebay_amount) as qty FROM ebay_order AS a JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn WHERE ";
				$dsql			.=    " a.ebay_combine!='1' and ebay_paidtime>=$searchstartdate and ebay_paidtime<=$searchenddate and a.ebay_user ='$user' ";
				if($account != '' ) $dsql .= " and a.ebay_account ='$account' ";
				
				$dsql			= $dbcon->execute($dsql);
				$dsql			= $dbcon->getResultArray($dsql);
				$qty			= $dsql[0]['qty'];
				
				$totalqty		+= $qty;
				
				/* 计算产品总成本 */
				
				$dsql			= "SELECT sum(b.ebay_amount) as qty,sku FROM ebay_order AS a JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn WHERE ";
				$dsql			.=    " a.ebay_combine!='1' and ebay_paidtime>=$searchstartdate and ebay_paidtime<=$searchenddate and a.ebay_user ='$user' ";
				
				if($account != '' ) $dsql .= " and a.ebay_account ='$account' ";
				$dsql			.= " group by b.sku ";
				
				$dsql			= $dbcon->execute($dsql);
				$dsql			= $dbcon->getResultArray($dsql);
				
				
				
				
				$totalgoods_cost = 0;
				$totalpackingcost = 0;
				
				for($h=0;$h<count($dsql);$h++){
								$pqty	= $dsql[$h]['qty'];
								$sku	= $dsql[$h]['sku'];
								$rr			= "select * from ebay_productscombine where ebay_user='$user' and goods_sn='$sku'";
								$rr			= $dbcon->execute($rr);
								$rr 	 	= $dbcon->getResultArray($rr);
								if(count($rr) > 0){
									$goods_sncombine	= $rr[0]['goods_sncombine'];
									$goods_sncombine    = explode(',',$goods_sncombine);	
									for($e=0;$e<count($goods_sncombine);$e++){
											$pline			= explode('*',$goods_sncombine[$e]);
											$goods_sn		= $pline[0];
											$goddscount     = $pline[1] * $pqty;
											$vv			= "select goods_cost from ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
											$vv			=  $dbcon->execute($vv);
											$vv			=  $dbcon->getResultArray($vv);
											$totalgoods_cost += $vv[0]['goods_cost']*$goddscount;
											
											

											
											
											$ebay_packingmaterial	= $vv[0]['ebay_packingmaterial'];
											$vv			= "select price from ebay_packingmaterial where model='$ebay_packingmaterial' and ebay_user='$user'";
											$vv			=  $dbcon->execute($vv);
											$vv			=  $dbcon->getResultArray($vv);
											$price		= $vv[0]['price'];
											$totalpackingcost		+= $price * $goddscount;
									
									
									}
								}else{
									$vv			= "select goods_cost from ebay_goods where goods_sn='$sku' and ebay_user='$user'";
									$vv			=  $dbcon->execute($vv);
									$vv			=  $dbcon->getResultArray($vv);
									$totalgoods_cost += $vv[0]['goods_cost']*$pqty;
									
									

									$ebay_packingmaterial	= $vv[0]['ebay_packingmaterial'];
									$vv			= "select price from ebay_packingmaterial where model='$ebay_packingmaterial' and ebay_user='$user'";
									$vv			=  $dbcon->execute($vv);
									$vv			=  $dbcon->getResultArray($vv);
									$price		= $vv[0]['price'];
									$totalpackingcost		+= $price * $pqty;
									
								}
								
								
				}
				
				
				
			
				
				
				


				
				$vv			= "select rates from ebay_currency where currency='RMB' and user='$user'";
				$vv			=  $dbcon->execute($vv);
				$vv			=  $dbcon->getResultArray($vv);
				$ssrates	=  $vv[0]['rates']?$vv[0]['rates']:1;
				$totalgoods_cost	= $totalgoods_cost * $ssrates;
				$totalpackingcost	= $totalpackingcost * $ssrates;
				
				
				$alltotalpackingcost	+= $totalpackingcost;
				$allproductcost			+= $totalgoods_cost;
				
				
				
				
			
					/* 计算 ebay fees */
					$ss			 = "SELECT  sum(b.FinalValueFee) as ebayfee,a.ebay_account  FROM ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn = b.ebay_ordersn where a.ebay_combine!='1'  ";
					$ss			.=    "   and ebay_paidtime>=$searchstartdate and ebay_paidtime<=$searchenddate and a.ebay_user ='$user' ";
					if($account != '' ) $ss .= " and a.ebay_account ='$account' ";
					$ss			.= " group by a.ebay_account ";
					$ss		= $dbcon->execute($ss);
					$ss		= $dbcon->getResultArray($ss);
					$totalebayfee		= 0;
					for($t=0;$t<count($ss);$t++){
								$ebayfee				= $ss[$t]['ebayfee'];
								$ebay_account			= $ss[$t]['ebay_account'];
								$vv						= "select ebay_currency from ebay_account where ebay_account='$ebay_account' and user='$user'";
								$vv						=  $dbcon->execute($vv);
								$vv						=  $dbcon->getResultArray($vv);
								$ebay_currency			=  $vv[0]['ebay_currency']?$vv[0]['ebay_currency']:'USD';
								$vv			= "select rates from ebay_currency where currency='$ebay_currency' and user='$user'";
								$vv			=  $dbcon->execute($vv);
								$vv			=  $dbcon->getResultArray($vv);
								$ssrates	=  $vv[0]['rates']?$vv[0]['rates']:1;
								$totalebayfee				+= $ebayfee * $ssrates;
					}
					
					$alltotalebayfee			+= $totalebayfee;
					
					
					/* 计算pp成功费 */
					
					$ss		= "SELECT a.ebay_id, a.ebay_currency, b.FeeOrCreditAmount FROM ebay_order AS a JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn WHERE  FeeOrCreditAmount >0
";
					$ss			.=    "   and ebay_paidtime>=$searchstartdate and ebay_paidtime<=$searchenddate and a.ebay_user ='$user' ";
					if($account != '' ) $ss .= " and a.ebay_account ='$account' ";
					$ss		.= " GROUP BY a.ebay_id ";
					$ss		= $dbcon->execute($ss);
					$ss		= $dbcon->getResultArray($ss);
					$totalpaypalfees	= 0;
					
					for($h=0;$h<count($ss);$h++){
								$ebay_currency	= $ss[$h]['ebay_currency'];
								$vv			= "select rates from ebay_currency where currency='$ebay_currency' and user='$user'";
								$vv			=  $dbcon->execute($vv);
								$vv			=  $dbcon->getResultArray($vv);
								$ssrates	=  $vv[0]['rates']?$vv[0]['rates']:1;
								$totalpaypalfees		+= ($ss[$h]['FeeOrCreditAmount'] * $ssrates);
					}
					
					$alltotalpaypalfees	+= $totalpaypalfees;
					
					
					$totalxiji		= $totalgoods_cost+$ordershipfee+$totalebayfee+$totalpaypalfees+$totalpackingcost;
					$alltotalxiji += $totalxiji;
					
					
					$profit			= $total - $totalebayfee - $totalpaypalfees - $totalgoods_cost - $ordershipfee;
					$allprofit		+= $profit;
					
					$mll		= number_format($profit/$total,2);
					$mll		= ($mll*100).'%';
					
?>

        <tr>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo date('Y-m-d',$sdate);?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo number_format($total,2);?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo number_format($ebay_shipfee,2);?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo number_format($total - $ebay_shipfee,2);?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo number_format($totalgoods_cost,2);?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo number_format($ordershipfee,2);?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo number_format($totalebayfee,2);?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo number_format($totalpaypalfees,2);?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo number_format($totalpackingcost,2);?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo number_format($totalxiji,2);?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo number_format($profit,2);?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo $mll;?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo $qty;?></div></td>
      </tr>
       
<?php
		
		
		
					$sdate		= strtotime(date('Y-m-d H:i:s',strtotime("$startdate +".$countjs." days")));
					
					if($sdate >= $edate ) break;
					
					$countjs ++ ;
				
		
		}
		
		
		}
		


?>


 <tr>
          <td bgcolor="#FFFFFF"><div align="center">合计</div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo number_format($totalsales,2);?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo number_format($totalshipfee,2);?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo number_format($totalsales-$totalshipfee,2);?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo number_format($allproductcost,2);?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo number_format($totalordershipfee,2);?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo number_format($alltotalebayfee,2);?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo number_format($alltotalpaypalfees,2);?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo number_format($alltotalpackingcost,2);?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo number_format($alltotalxiji,2);?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo number_format($allprofit,2);?></div></td>
          <td bgcolor="#FFFFFF"><div align="center"></div></td>
          <td bgcolor="#FFFFFF"><div align="center"><?php echo $totalqty;?></div></td>
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
		
		location.href = 'reportsales02.php?startdate='+startdate+'&enddate='+enddate+"&account="+account+"&module=report&ebay_site="+ebay_site;
	
	
	
	}

function toxls(){
		var startdate		= document.getElementById('startdate').value;
		var enddate			= document.getElementById('enddate').value;
		var account			= document.getElementById('account').value;
		var ebay_site		= '';
		
		location.href = 'toxls/reportsalestoxls02.php?startdate='+startdate+'&enddate='+enddate+"&account="+account+"&module=report&ebay_site="+ebay_site;
	
	
	
	}


</script>