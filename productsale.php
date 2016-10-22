<?php
include "include/config.php";


include "top.php";

$goodssn	= $_REQUEST['goodssn'];
$startdate		= $_REQUEST['start'];
$enddate		= $_REQUEST['enddate'];



	
	
 ?>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status;?> </h2>
</div>

<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
		
	<td nowrap="nowrap" scope="row" ><table width="80%" border="0" align="center" cellpadding="3" cellspacing="1">
      <tr>
        <td>产品销售记录：</td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="1" cellpadding="3"  class='list view'>
          <tr>
            <td>序号</td>
            <td>销售日期</td>
            <td>客户ID</td>
            <td>产品编号</td>
            <td>产品名称</td>
            <td>销售编号</td>
            <td>销售数量</td>
            <td>币种</td>
            <td>销售价格</td>
            <td>邮费</td>
            <td>eBay费用&nbsp;</td>
            <td>Paypal费用</td>
          </tr>
          <?php
		  
		  $sql		= "SELECT * FROM ebay_order AS a JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn WHERE sku =  '$goodssn' and a.ebay_userid !=''";
		  if($startdate !='' && $enddate !='') $sql .= " and (b.addtime>'".strtotime($startdate." 00:00:00")."' && b.addtime<'".strtotime($enddate." 23:59:59")."')";					
		
		
		  
		  $sql		= $dbcon->execute($sql);
		  $sql		= $dbcon->getResultArray($sql);
		  
		  
		  $totalprice	= 0;
					$totalshipfee = 0;
					$totalebayfee = 0;
					$totalpaypalfee = 0;
					$totalamount	=0;
					$tcost			= 0;
		  
		  
		  for($i=0;$i<count($sql);$i++){
		  
		  	$sku	= $sql[$i]['sku'];
			$ebay_itemtitle	= $sql[$i]['ebay_itemtitle'];
			$ebay_amount	= $sql[$i]['ebay_amount'];
		  	$ebay_itemprice	=  $sql[$i]['ebay_itemprice'];
			$shipingfee	=  $sql[$i]['shipingfee'];
			$ebay_itemid	= $sql[$i]['ebay_itemid'];
			$ebay_ordersn 	= $sql[$i]['ebay_ordersn'];
			$ebay_currency 	= $sql[$i]['ebay_currency'];
			
			$ebay_userid 	= $sql[$i]['ebay_userid'];
			$ebay_createdtime 	= date('Y-m-d',$sql[$i]['ebay_createdtime']);
			
			
		  ?>
          
          
          <tr>
            <td><?php echo $i+1;?>&nbsp;</td>
            <td><?php echo $ebay_createdtime;?>&nbsp;</td>
            <td><?php echo $ebay_userid;?>&nbsp;</td>
            <td><?php echo $sku;?>&nbsp;</td>
            <td><?php echo $ebay_itemtitle;?>&nbsp;</td>
            <td><?php echo $ebay_itemid;?>&nbsp;</td>
            <td><?php echo $ebay_amount;?>&nbsp;</td>
            <td><?php echo $ebay_currency;?></td>
            <td><?php echo $ebay_itemprice*$ebay_amount;?>&nbsp;</td>
            <td><?php echo $shipingfee;?>&nbsp;</td>
            <td>
            
            <?php 
			
								$sqlebayfee		= "select min(feeamount) as cc from ebay_fee where itemid='$ebay_itemid' and feetype='FeeFinalValue'";
								$sqlebayfee		= $dbcon->execute($sqlebayfee);
								$sqlebayfee		= $dbcon->getResultArray($sqlebayfee);
								$sqlebayfee		= $sqlebayfee[0]['cc']?$sqlebayfee[0]['cc']:0;							
								$efees			= $sqlebayfee*$ebay_amount;
								
			echo $efees;
			
								
								$gg				= "select * from ebay_currency where currency='$ebay_currency' and user='$user'";
								$gg	= $dbcon->execute($gg);
								$gg	= $dbcon->getResultArray($gg);
								$rates	= $gg[0]['rates']?$gg[0]['rates']:'1';
						


								
								$sq		= "select * from ebay_order where ebay_ordersn='$ebay_ordersn'";
								$sq		= $dbcon->execute($sq);
								$sq		= $dbcon->getResultArray($sq);
								$sqaccount	= $sq[0]['ebay_account'];			
								$sq		= "select * from ebay_paypal where ebayaccount='$sqaccount'";			
								$sq		= $dbcon->execute($sq);
								$sq		= $dbcon->getResultArray($sq);		
								$pfees	= ($sq[0]['fees']*($ebay_itemprice*$ebay_amount)+0.3)*$rates;
								
								
								$totalprice 	+= (($ebay_itemprice*$ebay_amount+$shipingfee)*$rates);
								
								
								$totalpaypalfee += $pfees;
								
								
								$gg				= "select * from ebay_currency where currency='USD' and user='$user'";
								$gg	= $dbcon->execute($gg);
								$gg	= $dbcon->getResultArray($gg);
								$rates	= $gg[0]['rates']?$gg[0]['rates']:'1';
								$totalebayfee	+= ($efees*$rates);
								
								
								
								$totalamount	+= $ebay_amount;
								
								
						
			
			?>
            

            
            

            &nbsp;</td>
            <td>

            <?php echo $sq[0]['fees']*($ebay_itemprice*$ebay_amount)+0.3; ?>
            
            &nbsp;</td>
          </tr>
          <?php
		  
		  
		  
		
			
		
	
			
		  
		  }
		  
		
		  		echo "<br>".$totalprice;
						
			 $sqo	= "select * from ebay_goods where goods_sn='$goodssn'";

			 
					 $sqo	= $dbcon->execute($sqo);
					 $sqo	= $dbcon->getResultArray($sqo);
					 $cost	= $sqo[0]['goods_cost']*$totalamount;
					
					
				
		 $profit	= $totalprice - $totalebayfee - $totalpaypalfee - $cost;
		  
		  ?>
          
          
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>总计</td>
            <td>&nbsp;</td>
            <td><?php echo $totalprice;?>&nbsp;</td>
            <td><?php echo $totalshipfee;?>&nbsp;</td>
            <td><?php echo $totalebayfee;?>&nbsp;</td>
            <td><?php echo $totalpaypalfee;?>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="12"><div align="right">
            
            <h5>
            利润 = eBay销售总金额 - eBay费用 - Paypal费用 - 物品邮费 - 产品单位成本=<font color="#FF0000"><?php echo number_format($profit,2);?>            </h5>
             </div></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td>产品费用记录：</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
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


function deleteallsystem(){

	var bill	= "";
	var checkboxs = document.getElementsByName("ordersn");
    for(var i=0;i<checkboxs.length;i++){
		if(checkboxs[i].checked == true){			
			bill = bill + ","+checkboxs[i].value;		
		}		
	}
	if(bill == ""){
		
		alert("请选择订单号");
		return false;	
	}
	
	if(confirm('确认删除此条记录')){
	
		location.href='productindex.php?module=warehouse&action=货品资料管理&type=delsystem&ordersn='+bill;
		
		
	}

}


		function searchorder(){
	
		

		var content 	= document.getElementById('keys').value;	
		location.href= 'productindex.php?keys='+content+"&module=warehouse&action=货品资料管理";
		
	}
	
	
	function instock(pid){
	
		
		var url	= "productinstock.php?pid="+pid+"&module=warehouse&action=货品入库&type=in";
		window.open(url,"_blank");
		
	
	
	}
	
	
	function outstock(pid){
	
		
		var url	= "productinstock.php?pid="+pid+"&module=warehouse&action=货品入库&type=out";
		window.open(url,"_blank");
		
	
	
	}
	
	





</script>