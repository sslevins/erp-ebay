<?php
include "include/config.php";


include "top.php";


$start			= $_REQUEST['start'];
						$end			= $_REQUEST['end'];
	
	


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
                      <form id="form" name="form" method="post" action="ordertongji2.php?module=finance&action=eBay 销售额统计">
                  <table width="70%" border="0" align="center" cellpadding="0" cellspacing="0">
                <input name="id" type="hidden" value="<?php echo $id;?>">
			      <tr>
                    <td width="41%" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right">eBay帐号:</div></td>
                    <td width="3%" align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
                    <td width="56%" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
                      <select name="account" size="5" multiple="multiple" id="account">
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
			          <input name="start" id="start" type="text" onclick="WdatePicker()" value="<?php echo $_REQUEST['start'];?>" />
到
<input name="end" id="end" type="text" onclick="WdatePicker()" value="<?php echo $_REQUEST['end'];?>" />
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
                          <td>帐号</td>
                          <td>总销售额</td>
                          <td>Paypal费用</td>
                          <td>eBay费用</td>
                          <td>重寄总金额</td>
                          <td>退款总金额</td>
                          <td>成功退款总金额</td>
                          <td>时间段</td>
                        </tr>
                        
                        <?php
						
						$ac				= $_REQUEST['account'];
						
				
				
	
						
						$start1			= strtotime($_REQUEST['start'].'00:00:00');
						$end1			= strtotime($_REQUEST['end'].'23:59:59');
						
						$account		= $_REQUEST['account'];
						
						$totalsales		= 0;	//总的销售额;
						$totalorders	= 0;	//总的订单数量
	
						
					$accounts		= explode("#",$account);
				    $arr			= array(); // 正常销售订单
					$arr2			= array(); // 重寄销售订单
					$arr3			= array(); // 退款销售订单
					$arr4			= array(); // paypal销售订单
					
					
					$totalebayfee		= 0;
					$totalebaycost		= 0; // 总成本
					$totalebayshipfee	= 0; // 总运费
					
					$totalresendordercopst	= 0; // 重寄订单物品总成本
					$mltotal			= 0;
					$mlltotal			= 0;
					
					
					$total0js			= 0;
					$total1js			= 0;
					$total2js			= 0;
					$total3js			= 0;
					$total4js			= 0;
					
					
					$totalrefund		= 0 ;
					
					
					
					for($i=0;$i<count($accounts);$i++){
					
							
							$accountsname	= $accounts[$i];
							if($accountsname != ''){
							
							
							/* 正常销售订单 */
							$ss		= "SELECT  a.ebay_total, ebay_currency,sum(b.FinalValueFee) as ebayfee,sum(b.FeeOrCreditAmount) as paypalfee  FROM ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn = b.ebay_ordersn where a.ebay_combine!='1' and a.ebay_account='$accountsname' ";
							if($end && $start) $ss.= " and ebay_paidtime>=$start1 and ebay_paidtime<=$end1 ";
							$ss .= "group by a.ebay_id";
					

							$ss		= $dbcon->execute($ss);
							$ss		= $dbcon->getResultArray($ss);
							
							
							/* ebay 成交费用 */
							
							
							$strline	= '';
							
							$ebaytotal	= 0;
							$ebayfee	= 0;
							$paypalfee	= 0;
							
							
							for($t=0;$t<count($ss);$t++){
								$total				= $ss[$t]['ebay_total'];
								
								$ebayfee			= $ss[$t]['ebayfee'];
								
								$ebay_currency		= $ss[$t]['ebay_currency'];
								
								
						//		if($accountsname == 'hkseller*2011') $ebay_currency = 'HKD';
								
								$rr			= "select * from ebay_currency where currency='$ebay_currency' and user='$user'";
								$rr			=  $dbcon->execute($rr);
								$rr			=  $dbcon->getResultArray($rr);
								$ssrates	=  $rr[0]['rates']?$rr[0]['rates']:1;
								$ebaytotal	+= $total * $ssrates;
								//$ebayfee	 += $ebayfee * $ssrates;
								$paypalfee			+= $ss[$t]['paypalfee'] * $ssrates;
								
							}
							
							
							$total0js	+= $ebaytotal;
							$total1js	+= $paypalfee;
							$total2js	+= $ebayfee;
							
						
							
							
							
							/* 计算退款总金额 */
							$vv					= "select sum(ebay_refundamount) as cc from ebay_rma where ebay_account = '$accountsname' and  rtatype = '退款'";
							if($start  && $end){
								
								$vv		.= " and (addtime>=$start1 and addtime<=$end1) ";
							
							}
							
							
			
							
							$vv					= $dbcon->execute($vv);
							$vv					= $dbcon->getResultArray($vv);
							$vvrefundcost		= $vv[0]['cc']?$vv[0]['cc']:0 ;
							$total3js	+= $vvrefundcost;
							
							
							
							/* 计算重寄总金额 */
							$vv					= "select sum(ebay_refundamount) as cc from ebay_rma where `ebay_account` = '$accountsname' and  rtatype = '重寄'";
							if($start && $end){
								
								$vv		.= " and (addtime>=$start1 and addtime<=$end1) ";
							
							}
	
							
							$vv					= $dbcon->execute($vv);
							$vv					= $dbcon->getResultArray($vv);
							$vvresendfundcost	= $vv[0]['cc']?$vv[0]['cc']:0 ;			
							$total4js	+= $vvresendfundcost;	
							
							
							
							/* 计算成功退款的总金额 */
							
							$vv  = "select * from ebay_paypalrefund where ebay_user ='$user' and status='2' and ebay_account ='$accountsname'";
							if($start && $end){
								$vv		.= " and (refundtime>=$start1 and refundtime<=$end1) ";
							}
							$vv					= $dbcon->execute($vv);
							$vv					= $dbcon->getResultArray($vv);
							
							$vrefundtotal		= 0;
							
							for($t=0;$t<count($vv);$t++){
								$ebay_refundamount				= $vv[$t]['ebay_refundamount'];
								$ebay_currency					= $vv[$t]['ebay_currency'];
								
								$rr			= "select * from ebay_currency where currency='$ebay_currency' and user='$user'";
								$rr			=  $dbcon->execute($rr);
								$rr			=  $dbcon->getResultArray($rr);
								$ssrates	=  $rr[0]['rates']?$rr[0]['rates']:1;
								$vrefundtotal	+= $ebay_refundamount * $ssrates;
							}
							
							$totalrefund	+= $vrefundtotal;
							
						
						?>
                        
                        <tr>
                          <td><?php echo $accountsname; ?>&nbsp;</td>
                          <td><?php echo number_format($ebaytotal,2);?>&nbsp;</td>
                          <td><?php echo number_format($paypalfee,2);?>&nbsp;</td>
                          <td><?php echo number_format($ebayfee,2);?>&nbsp;</td>
                          <td><?php echo $vvresendfundcost;?></td>
                          <td><?php echo $vvrefundcost;?>&nbsp;</td>
                          <td><?php echo $vrefundtotal;?>&nbsp;</td>
                          <td><?php echo $start."  --  ".$end;?>&nbsp;</td>
                        </tr>
                          
                       <?php
						}
						
						}
						
						
						
						
						?>
                        
                        
                         <tr>
                          <td>汇总&nbsp;</td>
                          <td><?php echo $total0js;?>&nbsp;</td>
                          <td><?php echo $total1js;?>&nbsp;</td>
                          <td><?php echo $total2js;?>&nbsp;</td>
                          <td><?php echo $total4js;?>&nbsp;</td>
                          <td><?php echo $total3js;?>&nbsp;</td>
                          <td><?php echo $totalrefund;?>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>          
                        <tr>
                          <td colspan="8"> <div style="border:#009900 dashed 1px"></div></td>
                          </tr>
           
                        

         
                        
                      </table>
			           </td>
			        </tr>
			      
			      
			      
			      
			      
                  <tr>				 
                    <td align="right" class="left_txt"><div align="right"></div></td>
                    <td align="right" class="left_txt">&nbsp;</td>
                    <td align="right" class="left_txt"><div align="left">
                      <input name="submit" type="button" value="Save" onclick="check()">
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
		var account =  '';
		
		
		if(start == ""){
			
			alert('请输入开始日期');
			
			return false;
		}
		
		if(end == ""){
			
			alert("请输入结束日期");
			return false;
		}
		
		
		 var len			= document.getElementById('account').options.length;
		 for(var i = 0; i < len; i++){
		   if( document.getElementById('account').options[i].selected){
			var e =  document.getElementById('account').options[i];
			account	+= e.value+'#';
		   }
		  }
		location.href='ordertongji2.php?start='+start+'&end='+end+'&account='+encodeURIComponent(account)+"&module=finance";
		
	}



</script>
