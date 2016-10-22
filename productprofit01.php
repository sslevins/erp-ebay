<?php
include "include/config.php";


include "top.php";
$virifydays		= $_REQUEST['virifydays'];
$type	= $_REQUEST['type'];
$sorts		= $_REQUEST['sorts'];
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
	  产品编号：
	  <input name="sku" type="text" id="sku" />
	  帐号：
	  <select name="account" id="account">
<option value="">Please Select</option>
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
	  <select name="sortart" id="sortart">
	    <option value="-1">Please Select</option>
        <option value="1" <?php if($sorts == '1') echo 'selected="selected"';?>>按销售数量排序</option>
        <option value="2" <?php if($sorts == '2') echo 'selected="selected"';?>>按总售价排序</option>
        <option value="3" <?php if($sorts == '3') echo 'selected="selected"';?>>按总利润排序</option>
    
	    </select>
	  :
	  
<input type="button" value="统计" onclick="searchorder()" /></td>
</tr>
</table>
</div>

<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr >
		<td colspan='4'>
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
			
					<th scope='col' nowrap="nowrap">总销量</th>
	                <th scope='col' nowrap="nowrap">总销售额</th>
	                </tr>
		


			  <?php
			  	
	
				

			
				
				$sql		= "select a.ebay_account,b.sku,sum(b.ebay_amount) as totalqty,sum(b.shipingfee) as totalfee,sum(b.ebay_amount * b.ebay_itemprice) as totalprice from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn = b. ebay_ordersn where a.ebay_user ='$user' group by b.sku  ";
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
					$sku		= $sql[$i]['sku'];
					
					
							$vv						= "select * from ebay_goods where goods_sn ='$sku' and ebay_user ='$user'";
							
	
							$vv						= $dbcon->execute($vv);
							$vv						= $dbcon->getResultArray($vv);
							$goods_name				= $vv[0]['goods_name'];
							
							
							$ebay_amount		= $sql[$i]['ebay_amount'];
							$totalqty		= $sql[$i]['totalqty'];
							$shipingfee		= $sql[$i]['shipingfee'];
							$totalprice		= $sql[$i]['totalprice'];
?>

				
		

                  
         		<tr height='20' class='oddListRowS1'>
						<td scope='row' align='left' valign="top" >
                        
                        <a href="productview.php?goods_sn=<?php echo $goods_sn;?>&ebay_site=<?php echo $ebay_site;?>" target="_blank">
                        
                        
						  <?php echo $sku; ?>         </a>                   </td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $goods_name;?></td>
				
						    <td scope='row' align='left' valign="top" ><?php
                            
							
							echo $totalqty;
							
						
			
							
							?>&nbsp;</td>
                            <td scope='row' align='left' valign="top" ><?php echo number_format($totalprice,2);?>&nbsp;</td>
      </tr>
      


 <?php } ?>
        
		<tr class='pagination'>
		<td colspan='4'>
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
		
		var url = 'productprofit.php?startdate='+startdate+"&enddate="+enddate+"&account="+account+"&goodscategory="+goodscategory+"&module=finance&action=产品利润统计&sku="+sku+"&sorts="+sortart+"&enddate2="+enddate2+"&startdate2="+startdate2+"&ebay_site="+ebay_site;
		
		
		location.href=url;
		
		
	}
	


	function exportorder(){
	
		

		var startdate 		= document.getElementById('startdate').value;	
		var enddate 		= document.getElementById('enddate').value;	
		var goodscategory 	= document.getElementById('goodscategory').value;	
		var account 	= document.getElementById('account').value;	
		var sku			 	= document.getElementById('sku').value;	
		
		var url = 'productprofitxls.php?startdate='+startdate+"&enddate="+enddate+"&account="+account+"&goodscategory="+goodscategory+"&module=finance&action=产品利润统计&sku="+sku;
		
		location.href=url;
		
		
	}
	
	
	





</script>