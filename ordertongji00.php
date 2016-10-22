<?php
include "include/config.php";


include "top.php";




	

	
	$id		= $_REQUEST["id"];

	
	if($_POST['submit']){
		
			
			$name		= $_POST['name'];
			$order		= $_POST['order'];
		
			if($id == ""){
			
			
			$sql	= "insert into ebay_topmenu(name,ordernumber,ebay_user) values('$name','$order','$user')";
			}else{
			
			$sql	= "update ebay_topmenu set name='$name',ordernumber='$order' where id=$id";
			}
			


	
			if($dbcon->execute($sql)){
			
			$status	= " -[<font color='#33CC33'>Success</font>]";
		
			
		}else{
		
			$status = " -[<font color='#FF0000'>Error</font>]";
		}
		
			
		
	}
	
	
	if($id	!= ""){
	
		
		$sql = "select * from ebay_topmenu where id=$id";
		$sql = $dbcon->execute($sql);
		$sql = $dbcon->getResultArray($sql);
					
		$name 	 	= $sql[0]['name'];
		$order 		= $sql[0]['ordernumber'];
		
	
	}
	
	
	


?>
<script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>

<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status;?></h2>
</div>
 
<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 <input name="hiddenuserid" type="hidden" value="" id="hiddenuserid" />
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
		
	<td nowrap="nowrap" scope="row" >&nbsp;</td>
	</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td width="26%">
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'>			
                      <form id="form" name="form" method="post" action="ordertongji.php?module=finance&action=Custom Menu">
                  <table width="70%" border="0" align="center" cellpadding="0" cellspacing="0">
                <input name="id" type="hidden" value="<?php echo $id;?>">
			      <tr>
                    <td width="41%" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right">eBay帐号:</div></td>
                    <td width="3%" align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
                    <td width="56%" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
                      <select name="account" id="account">
                        <option value="all">All account</option>
                        <?php 
					
					$sql	 = "select * from ebay_account where ebay_user='$user'";
				
					
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 
					 	$account	= $sql[$i]['ebay_account'];
					 ?>
                        <option value="<?php echo $account;?>"><?php echo $account;?></option>
                        <?php } ?>
                      </select>
                    </div></td>
                    </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right">时间</div></td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><div id="gt-res-listen" role="button" tabindex="0">
			          <input name="start" id="start" type="text" onclick="WdatePicker()" />
到
<input name="end" id="end" type="text" onclick="WdatePicker()" />
<br />
</div></td>
			        </tr>
			      <tr>
			        <td colspan="3" align="right" bgcolor="#f2f2f2" class="left_txt">
                    
                    <div style="border:#009900 dashed 1px"></div>
                    &nbsp;</td>
			        </tr>
			      <tr>
			        <td colspan="3" align="right"  ><table width="100%" border="1" cellspacing="2" cellpadding="3">
                        <tr>
                          <td>eBay帐号</td>
                          <td>总销售额  </td>
                          <td>退款额 </td>
                          <td>ebay成交费</td>
                          <td>paypal手续费</td>
                          <td>货品总成本 </td>
                          <td>重寄订单总成本</td>
                          <td>毛利/毛利率</td>
                          <td>总运费 </td>
                          <td>时间段</td>
                        </tr>
                        
                        <?php
						
						$ac				= $_REQUEST['account'];
						$start			= $_REQUEST['start'];
						$end			= $_REQUEST['end'];
						
						$start1			= strtotime($_REQUEST['start']);
						$end1			= strtotime($_REQUEST['end']);
						
						
						$account		= '';
						
						$totalsales		= 0;	//总的销售额;
						$totalorders	= 0;	//总的订单数量

						
						if($ac		 	== 'all'){
						
								$sql		= "select * from ebay_account where ebay_user='$user'";
								$sql		= $dbcon->execute($sql);
								$sql		= $dbcon->getResultArray($sql);
								for($i=0;$i<count($sql);$i++){
									
									$account	.= $sql[$i]['ebay_account']."#";			
									
								}
							
				
							
						
						}else{
						
							
							$account	= $ac;
							
						
						}
						
					$accounts		= explode("#",$account);
				    $arr			= array(); // 正常销售订单
					$arr2			= array(); // 重寄销售订单
					$arr3			= array(); // 退款销售订单
					$arr4			= array(); // paypal销售订单
					
					
					$totalebayfee		= 0;
					$totalebaycost		= 0; // 总成本
					$totalebayshipfee	= 0; // 总运费
					
					$totalresendordercopst	= 0; // 重寄订单物品总成本
					
					
					
					
					for($i=0;$i<count($accounts);$i++){
					
							
							$accountsname	= $accounts[$i];
							if($accountsname != ''){
							
							
							/* 正常销售订单 */
							$ss		= "SELECT SUM( ebay_total ) AS total, ebay_currency FROM ebay_order where (ebay_addtime>=$start1 and ebay_addtime<=$end1) and ebay_account='$accountsname' and ebay_status='2' and profitstatus='1'  GROUP BY ebay_currency";
							$ss		= $dbcon->execute($ss);
							$ss		= $dbcon->getResultArray($ss);
							$strline	= '';
							
							$ebaytotal	= 0;
							
							for($t=0;$t<count($ss);$t++){
								$total				= $ss[$t]['total'];
								$ebay_currency		= $ss[$t]['ebay_currency'];
								$arr[$t][$ebay_currency] = $total;
								$strline .= $ebay_currency." : ".number_format($total,2)."<br>";
								
								
								$rr			= "select * from ebay_currency where currency='$ebay_currency' and user='$user'";
								$rr			=  $dbcon->execute($rr);
								$rr			=  $dbcon->getResultArray($rr);
								$ssrates	=  $rr[0]['rates']?$rr[0]['rates']:1;
							
								$ebaytotal	+= $total * $ssrates;
							
							}
							
							
						
							
							
							/* 正常销售订单结束 */
							
							
							/* 重寄销售订单 */
							$ss		= "SELECT SUM( ebay_total ) AS total, ebay_currency FROM ebay_order where (ebay_addtime>=$start1 and ebay_addtime<=$end1) and ebay_account='$accountsname' and ebay_status='2' and ebay_ordertype ='重寄订单'  GROUP BY ebay_currency";
							$ss		= $dbcon->execute($ss);
							$ss		= $dbcon->getResultArray($ss);
							$strline2	= '';
							for($t=0;$t<count($ss);$t++){
								$total				= $ss[$t]['total'];
								$ebay_currency		= $ss[$t]['ebay_currency'];
								$arr2[$i][$ebay_currency] = $total;
								$strline2 .= $ebay_currency." : ".$total."<br>";
							}
							/* 重寄销售订单总成本 */
							
							$ss		= "SELECT SUM( ebay_total ) AS total, ebay_currency FROM ebay_order where (ebay_addtime>=$start1 and ebay_addtime<=$end1) and ebay_account='$accountsname' and ebay_status='2' and ebay_ordertype ='重寄订单'  GROUP BY ebay_currency";
							$ss		= $dbcon->execute($ss);
							$ss		= $dbcon->getResultArray($ss);
							$strline3	= '';
							for($t=0;$t<count($ss);$t++){
								$total				= $ss[$t]['total'];
								$ebay_currency		= $ss[$t]['ebay_currency'];
								$arr3[$i][$ebay_currency] = $total;
								$strline3 .= $ebay_currency." : ".$total."<br>";
							}
							
							
							
							/* 退款销售订单 */
							$ss		= "SELECT SUM( ebay_total ) AS total, ebay_currency FROM ebay_order where (refundtime>=$start1 and refundtime<=$end1) and ebay_account='$accountsname' and ebay_status='2' and ebay_ordertype ='退款订单'  GROUP BY ebay_currency";
							$ss		= $dbcon->execute($ss);
							$ss		= $dbcon->getResultArray($ss);
							$strline3	= '';
							for($t=0;$t<count($ss);$t++){
								$total				= $ss[$t]['total'];
								$ebay_currency		= $ss[$t]['ebay_currency'];
								$arr3[$t][$ebay_currency] = $total;
								$strline3 .= $ebay_currency." : ".number_format($total,2)."<br>";
							}
							/* 退款销售订单结束 */
							
							
							
							/* 成交费 */
							$ss		= "SELECT SUM(b.FinalValueFee) AS total FROM ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn = b.ebay_ordersn  where (a.ebay_addtime>=$start1 and a.ebay_addtime<=$end1) and a.ebay_account='$accountsname' and a.ebay_status='2' and profitstatus='1' ";
							
							$ss		= $dbcon->execute($ss);
							$ss		= $dbcon->getResultArray($ss);
							
							$ebayfee	= $ss[0]['total'];
							$totalebayfee	+= $ebayfee;
							
							/* 计算paypal 手续费 */
							$ss		= "select sum(b.fee) as total,a.ebay_currency from ebay_order as a join ebay_paypaldetail as b on a.ebay_ptid = b.tid where (a.ebay_addtime>=$start1 and a.ebay_addtime<=$end1) and a.ebay_account='$accountsname' and a.ebay_status='2' and a.profitstatus='1'   GROUP BY a.ebay_currency";
							$ss		= $dbcon->execute($ss);
							$ss		= $dbcon->getResultArray($ss);
							
							$strline4	= '';
							
							$pfee		= 0;
							
							for($t=0;$t<count($ss);$t++){
								$total				= $ss[$t]['total'];
								$ebay_currency		= $ss[$t]['ebay_currency'];
								$arr4[$t][$ebay_currency] = $total;
								$strline4 .= $ebay_currency." : ".$total."<br>";
								
								
									$rr			= "select * from ebay_currency where currency='$ebay_currency' and user='$user'";
								$rr			=  $dbcon->execute($rr);
								$rr			=  $dbcon->getResultArray($rr);
								$ssrates	=  $rr[0]['rates']?$rr[0]['rates']:1;
							
								$pfee		+= $total * $ssrates;
								
								
							}
							
							/* 计算总成本和总运费 */
							$ss		= "SELECT SUM( ordercopst ) AS ordercopst, SUM( ordershipfee ) AS ordershipfee FROM ebay_order where (ebay_addtime>=$start1 and ebay_addtime<=$end1) and ebay_account='$accountsname' and ebay_status='2'  and profitstatus='1'    GROUP BY ebay_currency";
							$ss		= $dbcon->execute($ss);
							$ss		= $dbcon->getResultArray($ss);
							
							$ordercopst		= $ss[0]['ordercopst'];
							$ordershipfee	= $ss[0]['ordershipfee'];
							
							$totalebaycost		+= $ordercopst; // 总成本
							$totalebayshipfee	+= $ordershipfee; // 总运费
							
							
							
								/* 计算总重寄订单总 */
							$ss		= "SELECT SUM( ordercopst ) AS ordercopst, SUM( ordershipfee ) AS ordershipfee FROM ebay_order where (resendtime>=$start1 and resendtime<=$end1) and ebay_account='$accountsname' and ebay_status='2'  and profitstatus='1' ";
							$ss		= $dbcon->execute($ss);
							$ss		= $dbcon->getResultArray($ss);
							
							$resendordercopst		= $ss[0]['ordercopst'];
							
							$totalresendordercopst		+= $resendordercopst;

					
						
						?>
                        
                        <tr>
                          <td><?php echo $accountsname; ?>&nbsp;</td>
                          <td><?php echo $strline; ?>&nbsp;</td>
                          <td><?php echo $strline3; ?>&nbsp;</td>
                          <td>USD:<?php echo number_format($ebayfee,2); ?>&nbsp;</td>
                          <td><?php echo $strline4;?>&nbsp;</td>
                          <td>USD<?php echo number_format($ordercopst,2);?> &nbsp;</td>
                          <td>USD:<?php echo number_format($resendordercopst,2);?>&nbsp;</td>
                          <td>
                          <?php
						  
						  $ml			= $ebaytotal - $ebayfee - $pfee - $ordercopst - $ordershipfee;
						  
						  
						  
						  $mll		= number_format(($ml/$ebaytotal),2);
							
							echo number_format($ml,2).' / '.($mll*100).'%';
						  
						  
						  ?>
                          
                          
                          
                          &nbsp;</td>
                          <td>USD<?php echo number_format($ordershipfee,2);?>&nbsp;</td>
                          <td><?php echo $start."  --  ".$end;?>&nbsp;</td>
                        </tr>             
                                   <?php
						}
						
						}
						
						
						
						
						?>
                        <tr>
                          <td colspan="10"> <div style="border:#009900 dashed 1px"></div></td>
                          </tr>
           
                        
                        <tr>
                          <td>汇总</td>
                          <td><?php 
						  
						  $aud	= 0;
						  $cad	= 0;
						  $gbp	= 0;
						  $usd	= 0;
						  $eur	= 0;
						  for($i=0;$i<(count($arr) + 1);$i++){
							  $aud	+= $arr[$i]['AUD'];
							  $cad	+= $arr[$i]['CAD'];
							  $gbp	+= $arr[$i]['GBP'];
							  $usd	+= $arr[$i]['USD'];
							  $eur	+= $arr[$i]['EUR'];
						  }
						  
						 
						  $totalline	= "Total AUD:{".number_format($aud,2)."} <br> Total CAD:{".number_format($cad,2)."} <br> Total GBP:{".number_format($gbp,2)."} <br> Total USD:{".number_format($usd,2)."} <br> Total EUR:{".number_format($eur,2)."}";
						  echo $totalline;
						  
						  
						  $s0					= "select * from ebay_currency where currency='AUD'";
						  $s0					= $dbcon->execute($s0);
						  $s0					= $dbcon->getResultArray($s0);
						  $audrate				= $s0[0]['rates']?$s0[0]['rates']:1;
						  
						  $s0					= "select * from ebay_currency where currency='CAD'";
						  $s0					= $dbcon->execute($s0);
						  $s0					= $dbcon->getResultArray($s0);
						  $cadrate				= $s0[0]['rates']?$s0[0]['rates']:1;
						  
						  $s0					= "select * from ebay_currency where currency='GBP'";
						  $s0					= $dbcon->execute($s0);
						  $s0					= $dbcon->getResultArray($s0);
						  $gbprate				= $s0[0]['rates']?$s0[0]['rates']:1;
						  
						  $s0					= "select * from ebay_currency where currency='USD'";
						  $s0					= $dbcon->execute($s0);
						  $s0					= $dbcon->getResultArray($s0);
						  $usdrate				= $s0[0]['rates']?$s0[0]['rates']:1;
						  
						  $s0					= "select * from ebay_currency where currency='EUR'";
						  $s0					= $dbcon->execute($s0);
						  $s0					= $dbcon->getResultArray($s0);
						  $eurdrate				= $s0[0]['rates']?$s0[0]['rates']:1;

						  $aud	= $aud * $audrate;
						  $cad	= $cad * $cadrate;
						  $gbp	= $gbp * $gbprate;
						  $usd	= $usd * $usdrate;
						  $eur	= $eur * $eurrate;
						  
					
						  $totalrmb		= $aud + $cad + $gbp + $usd + $eur;
						  echo "<br>Total USD :".number_format($totalrmb,2);
						  
						  
						  ?>&nbsp;</td>
                          <td><?php 
						  
						  $aud	= 0;
						  $cad	= 0;
						  $gbp	= 0;
						  $usd	= 0;
						  $eur	= 0;
						  for($i=0;$i<(count($arr3)+1);$i++){
							  
							  $aud	+= $arr3[$i]['AUD'];
							  $cad	+= $arr3[$i]['CAD'];
							  $gbp	+= $arr3[$i]['GBP'];
							  $usd	+= $arr3[$i]['USD'];
							  $eur	+= $arr3[$i]['EUR'];
							  
							  
						  }
						  
						 
						  
  $totalline	= "Total AUD:{".number_format($aud,2)."} <br> Total CAD:{".number_format($cad,2)."} <br> Total GBP:{".number_format($gbp,2)."} <br> Total USD:{".number_format($usd,2)."} <br> Total EUR:{".number_format($eur,2)."}";
  
						  echo $totalline;
						  
						  
						  $s0					= "select * from ebay_currency where currency='AUD'";
						  $s0					= $dbcon->execute($s0);
						  $s0					= $dbcon->getResultArray($s0);
						  $audrate				= $s0[0]['rates']?$s0[0]['rates']:1;
						  
						  $s0					= "select * from ebay_currency where currency='CAD'";
						  $s0					= $dbcon->execute($s0);
						  $s0					= $dbcon->getResultArray($s0);
						  $cadrate				= $s0[0]['rates']?$s0[0]['rates']:1;
						  
						  $s0					= "select * from ebay_currency where currency='GBP'";
						  $s0					= $dbcon->execute($s0);
						  $s0					= $dbcon->getResultArray($s0);
						  $gbprate				= $s0[0]['rates']?$s0[0]['rates']:1;
						  
						  $s0					= "select * from ebay_currency where currency='USD'";
						  $s0					= $dbcon->execute($s0);
						  $s0					= $dbcon->getResultArray($s0);
						  $usdrate				= $s0[0]['rates']?$s0[0]['rates']:1;
						  
						  $s0					= "select * from ebay_currency where currency='EUR'";
						  $s0					= $dbcon->execute($s0);
						  $s0					= $dbcon->getResultArray($s0);
						  $eurdrate				= $s0[0]['rates']?$s0[0]['rates']:1;

						  $aud	= $aud * $audrate;
						  $cad	= $cad * $cadrate;
						  $gbp	= $gbp * $gbprate;
						  $usd	= $usd * $usdrate;
						  $eur	= $eur * $eurrate;
						  
					
						  $totalrmb		= $aud + $cad + $gbp + $usd + $eur;
						  echo "<br>Total USD :".$totalrmb;
						  
						  
						  ?></td>
                          <td>USD:<?php echo $totalebayfee;?></td>
                          <td><?php 
						  
						  $aud	= 0;
						  $cad	= 0;
						  $gbp	= 0;
						  $usd	= 0;
						  $eur	= 0;
					
						  
						  for($i=0;$i<(count($arr4)+1);$i++){
							  
							  $aud	+= $arr4[$i]['AUD'];
							  $cad	+= $arr4[$i]['CAD'];
							  $gbp	+= $arr4[$i]['GBP'];
							  $usd	+= $arr4[$i]['USD'];
							  $eur	+= $arr4[$i]['EUR'];
							  
							  
						  }
						  
						 
  $totalline	= "Total AUD:{".number_format($aud,2)."} <br> Total CAD:{".number_format($cad,2)."} <br> Total GBP:{".number_format($gbp,2)."} <br> Total USD:{".number_format($usd,2)."} <br> Total EUR:{".number_format($eur,2)."}";						  
						 						  echo $totalline;
 
						  $s0					= "select * from ebay_currency where currency='AUD'";
						  $s0					= $dbcon->execute($s0);
						  $s0					= $dbcon->getResultArray($s0);
						  $audrate				= $s0[0]['rates']?$s0[0]['rates']:1;
						  
						  $s0					= "select * from ebay_currency where currency='CAD'";
						  $s0					= $dbcon->execute($s0);
						  $s0					= $dbcon->getResultArray($s0);
						  $cadrate				= $s0[0]['rates']?$s0[0]['rates']:1;
						  
						  $s0					= "select * from ebay_currency where currency='GBP'";
						  $s0					= $dbcon->execute($s0);
						  $s0					= $dbcon->getResultArray($s0);
						  $gbprate				= $s0[0]['rates']?$s0[0]['rates']:1;
						  
						  $s0					= "select * from ebay_currency where currency='USD'";
						  $s0					= $dbcon->execute($s0);
						  $s0					= $dbcon->getResultArray($s0);
						  $usdrate				= $s0[0]['rates']?$s0[0]['rates']:1;
						  
						  $s0					= "select * from ebay_currency where currency='EUR'";
						  $s0					= $dbcon->execute($s0);
						  $s0					= $dbcon->getResultArray($s0);
						  $eurdrate				= $s0[0]['rates']?$s0[0]['rates']:1;

						  $aud	= $aud * $audrate;
						  $cad	= $cad * $cadrate;
						  $gbp	= $gbp * $gbprate;
						  $usd	= $usd * $usdrate;
						  $eur	= $eur * $eurrate;
						  
					
						  $totalrmb		= $aud + $cad + $gbp + $usd + $eur;
						  echo "<br>Total USD :".number_format($totalrmb,2);
						  
						  
						  ?></td>
                          <td>USD<?php echo number_format($totalebaycost,2);?> &nbsp;</td>
                          <td>USD<?php echo number_format($totalresendordercopst,2);?>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>USD<?php echo number_format($totalebayshipfee,2);?>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
         
                        
             
                        
                      </table>
			           </td>
			        </tr>
			      
			      
			      
			      
			      
                  <tr>				 
                    <td align="right" class="left_txt"><div align="right"></div></td>
                    <td align="right" class="left_txt">&nbsp;</td>
                    <td align="right" class="left_txt"><div align="left">
                      <input name="submit" type="submit" value="Save">
                    </div></td>
                    </tr>
                </table>
                 </form> 
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
<script language="javascript">

	
	function check(){
		
		var start	= document.getElementById('start').value;
		var end		= document.getElementById('end').value;
		var account = document.getElementById('account').value;
		
		if(start == ""){
			
			alert('请输入开始日期');
			
			return false;
		}
		
		if(end == ""){
			
			alert("请输入结束日期");
			return false;
		}
		
	
		location.href='ordertongji.php?start='+start+'&end='+end+'&account='+account;
		
	}



</script>
