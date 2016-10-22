<?php
include "include/config.php";


include "top.php";

$type	= $_REQUEST['type'];

if($type 	== "delsystem"){
	
	$ordersn = explode(",",$_REQUEST['ordersn']);

	
	$status  = "";
	for($g=0;$g<count($ordersn);$g++){
		
		
		$sn 	=  $ordersn[$g];

		if($sn != ""){
			
			$sql		= "delete  from  ebay_goods where goods_id='$sn'";
		
			
			
		if($dbcon->execute($sql)){
	
	
					$status	= " -[<font color='#33CC33'>操作记录: 记录删除成功</font>]";

	}else{
	

					$status = " -[<font color='#FF0000'>操作记录: 记录删除失败</font>]";

	}

			
		}
	}
	
}
	
				$startdate		= $_REQUEST['startdate'];
				$enddate		= $_REQUEST['enddate'];
				$account		= $_REQUEST['account'];
				$goodscategory	= $_REQUEST['goodscategory'];
			


	
	
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
	
	
	<td nowrap="nowrap" scope="row" >&nbsp;开始时间：
	  <input name="startdate" type="text" id="startdate" onClick="WdatePicker()" value="<?php echo $startdate;?>"/>
	  结束时间：
	  <input name="enddate" type="text" id="enddate" onClick="WdatePicker()" value="<?php echo $enddate;?>" />
	  货品类别：<select name="goodscategory" id="goodscategory">
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
<option value="-1">Please Select</option>
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
	  <input type="button" value="统计" onclick="searchorder()" /></td>
</tr>
</table>
</div>

<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='10'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" width='2%' class='paginationActionButtons'>&nbsp;</td>
				  <td  nowrap='nowrap' width='1%' align="right" class='paginationChangeButtons'>				  </td>
				</tr>
			</table>		</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>操作</div></th>
			
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>产品编号</div></th>
			
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>产品名称</div>			</th>
			
					<th scope='col' nowrap="nowrap"><span class="left_bt2">产品售价</span></th>
		            <th scope='col' nowrap="nowrap"><span class="left_bt2">产品成本</span></th>
		<th scope='col' nowrap="nowrap">单位&nbsp;</th>
					<th scope='col' nowrap="nowrap">产品货位&nbsp;</th>
		            <th scope='col' nowrap="nowrap">实际库存</th>
                    <th scope='col' nowrap="nowrap">销售记录</th>
        <th scope='col' nowrap="nowrap">操作</th>
	</tr>
		


			  <?php
			  	
				
			
				$sql		= "select * from ebay_goods where ebay_user='$user'";
				
				
				
				
				if($goodscategory != "-1" && $goodscategory != '') $sql .= " and goods_category='$goodscategory'";				
				
				$query		= $dbcon->query($sql);
				$total		= $dbcon->num_rows($query);
				
				$pageindex  =( isset($_GET['pageindex']) )?$_GET['pageindex']:1;
				$limit = " limit ".($pageindex-1)*$pagesize.",$pagesize";
		
				
				$page=new page(array('total'=>$total,'perpage'=>$pagesize));
				$sql = $sql.$limit;
				$sql		= $dbcon->execute($sql);
				$sql		= $dbcon->getResultArray($sql);
				for($i=0;$i<count($sql);$i++){
					
								
					$goods_id		= $sql[$i]['goods_id'];
					$goods_sn		= $sql[$i]['goods_sn'];
					$goods_name		= $sql[$i]['goods_name'];
					$goods_price	= $sql[$i]['goods_price']?$sql[$i]['goods_price']:0;
					$goods_cost		= $sql[$i]['goods_cost']?$sql[$i]['goods_cost']:0;
					$goods_count	= $sql[$i]['goods_count']?$sql[$i]['goods_count']:0;
					$goods_unit		= $sql[$i]['goods_unit'];
					$goods_location	= $sql[$i]['goods_location'];
					
					
			  ?>
              
              
                  
         		<tr height='20' class='oddListRowS1'>
						<td scope='row' align='left' valign="top" ><input name="ordersn" type="checkbox" id="ordersn" value="<?php echo $goods_id;?>" ><?php echo $goods_id;?></td>
				
						    <td scope='row' align='left' valign="top" >
							<?php echo $goods_sn; ?>                            </td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $goods_name;?></td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $goods_price;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $goods_cost;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $goods_unit;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $goods_location; ?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $goods_count;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" >
                            <?php
							
							$dstr	= "";
							
							/*
							$dsql	= "select sum(ebay_amount) as amount,sum(ebay_itemprice*ebay_amount) as total,sum(shipingfee) as shipingfee from ebay_orderdetail where sku='$goods_sn'";
							
							
							if($account != "-1" && $account !='') $dsql .= " and ebay_account='$account'";
							if($startdate !='' && $enddate !='') $dsql .= " and (addtime>'".strtotime($startdate)."' && addtime<'".strtotime($enddate)."')";
							
							echo $dsql;
							
						
							
							
							$dsql				= $dbcon->execute($dsql);
							$dsql				= $dbcon->getResultArray($dsql);
							
							
							
							$totalamount		= $dsql[0]['amount'];
							$totalprice			= $dsql[0]['total'] + $dsql[0]['shipingfee'];
							
							*/
							
							
							
							
							$dsql	= "select * from ebay_orderdetail where sku='$goods_sn'";	
							  $dsql		= "SELECT * FROM ebay_order AS a JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn WHERE sku =  '$goods_sn'";
							
							if($account != "-1" && $account !='') $dsql .= " and a.ebay_account='$account'";
							if($startdate !='' && $enddate !='') $dsql .= " and (b.addtime>'".strtotime($startdate." 00:00:00")."' && b.addtime<'".strtotime($enddate." 23:59:59")."')";
					
						
		
						
							
							$dsql				= $dbcon->execute($dsql);
							$dsql				= $dbcon->getResultArray($dsql);
							
							
							  $totalprice	= 0;
						  $totalshipfee = 0;
						  $totalebayfee = 0;
						  $totalpaypalfee = 0;
						  $totalamount	=0;
		  
		  
							for($r=0;$r<count($dsql);$r++){
		  
								
								
		  
								$sku	= $sql[$r]['sku'];
								$ebay_itemtitle	= $dsql[$r]['ebay_itemtitle'];
								$ebay_amount	= $dsql[$r]['ebay_amount'];
								$ebay_itemprice	=  $dsql[$r]['ebay_itemprice'];
								$shipingfee	=  $dsql[$r]['shipingfee'];
								$ebay_itemid	= $dsql[$r]['ebay_itemid'];
								$ebay_ordersn 	= $dsql[$r]['ebay_ordersn'];
								
								
								
								$sqlebayfee		= "select min(feeamount) as cc from ebay_fee where itemid='$ebay_itemid' and feetype='FeeFinalValue'";
								$sqlebayfee		= $dbcon->execute($sqlebayfee);
								$sqlebayfee		= $dbcon->getResultArray($sqlebayfee);
								$sqlebayfee		= $sqlebayfee[0]['cc']?$sqlebayfee[0]['cc']:0;							
								$totalebayfee += $sqlebayfee*$ebay_amount;
								
								
								$sq		= "select * from ebay_order where ebay_ordersn='$ebay_ordersn'";
								$sq		= $dbcon->execute($sq);
								$sq		= $dbcon->getResultArray($sq);
								$sqaccount	= $sq[0]['ebay_account'];			
								$sq		= "select * from ebay_paypal where ebayaccount='$sqaccount'";			
								$sq		= $dbcon->execute($sq);
								$sq		= $dbcon->getResultArray($sq);		
								$pfees	= $sq[0]['fees']*($ebay_itemprice*$ebay_amount)+0.3;
								
								
								
								$totalprice 	+= $ebay_itemprice*$ebay_amount+$shipingfee;							
								$totalpaypalfee += $pfees;
								$totalamount	+= $ebay_amount;
													
								
							}
							
							 $sqo	= "select * from ebay_goods where goods_sn='$goods_sn'";
							  $sqo	= $dbcon->execute($sqo);
							  $sqo	= $dbcon->getResultArray($sqo);
					
							  $cost	= $sqo[0]['goods_cost']*$totalamount;
		
							$totalshipfee		= 0;
		  					/*
		  					echo "<br>成本：".$cost;
							echo "<br>产品总售价：".$totalprice;
							echo "<br>eBay费用：".$totalebayfee;
							echo "<br>Paypal费用：".$totalpaypalfee;
							echo "<br>总利润：".$profit;
							*/
							
							
		 				 $profit	= $totalprice - $totalebayfee - $totalpaypalfee - $cost;
		  					
						
							
							$dsql		= $dbcon->execute($dsql);
							$dsql		= $dbcon->getResultArray($dsql);
							
							
							$dstr		= "总数量：<strong><font color=red>".$totalamount."</font></strong>";
							$dstr		.= "总售价：<strong><font color=red>".number_format($totalprice,2)."</font></strong>";
							
							$dstr		.= "eBay费用:<strong><font color=green>".number_format($totalebayfee,2)."</font></strong> Paypal费用：<strong><font color=red>".number_format($totalpaypalfee,2)."</font></strong>";
							$dstr		.= "总利润:<strong><font color=green>".number_format($profit,2)."</font></strong>";
							
							
							echo $dstr;
							
							
							?>
                     
                            
                            
                            
                            
                            &nbsp;</td>
						    <td scope='row' align='left' valign="top" ><a href="productsale.php?pid=<?php echo $goods_id;?>&goodssn=<?php echo $goods_sn;?>&module=finance&action=销售记录" target="_blank">查看销售记录</a>&nbsp;</td>
	  </tr>

 
               <?php } ?>
		<tr class='pagination'>
		<td colspan='10'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'><div align="center"><?    echo '<br><center>'.$page->show(2)."</center>";//输出分页 ?> 
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
	
		

		var startdate 		= document.getElementById('startdate').value;	
		var enddate 		= document.getElementById('enddate').value;	
		var goodscategory 	= document.getElementById('goodscategory').value;	
		var account 	= document.getElementById('account').value;	
		
		var url = 'productprofit.php?startdate='+startdate+"&enddate="+enddate+"&account="+account+"&goodscategory="+goodscategory+"&module=finance&action=产品利润统计";
		
		location.href=url;
		
		
	}
	

	





</script>