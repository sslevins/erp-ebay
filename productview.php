<?php
include "include/config.php";
error_reporting(ALL);


include "top.php";

$ebay_site		= $_REQUEST['ebay_site'];

	$goods_sn			= $_REQUEST['goods_sn'];
	$sku				= $_REQUEST['sku'];
	$ebay_account		= $_REQUEST['ebay_account'];
	if($sku != '') 		$goods_sn = $sku;
	
	
	
 ?>
  <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td>

<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
		
	<td nowrap="nowrap" scope="row" >
	 ebay帐号：
	   <select name="ebay_account" id="ebay_account">
       
        <option value=""  >所有帐号</option>
        
         <?php 

					

					$sql	 = "select * from ebay_account as a where a.ebay_user='$user' and ($ebayacc) and ebay_token != '' order by ebay_account desc ";
					
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);

					for($i=0;$i<count($sql);$i++){					

					 

					 	$account	= $sql[$i]['ebay_account'];

					 ?>
         <option value="<?php echo $account;?>"  <?php if($ebay_account == $account ) echo 'selected="selected"';?> ><?php echo $account;?></option>
         <?php } ?>
       </select>
	   选择销售时间：
	   <input name="date" type="text" id="date" onClick="WdatePicker()" value="<?php echo $_REQUEST['date']?$_REQUEST['date']:date('Y-m-d');?>" />
	sku:&nbsp;
	<input name="sku" type="text" id="sku" value="<?php echo $_REQUEST['goods_sn'];?>"  />
	站点:
	<select name="ebay_site" id="ebay_site">
      <option value="">Please select</option>
            <option value="US"  >US</option>
            <option value="UK"  >UK</option>
            <option value="Germany"  >Germany</option>
            <option value="France"  >France</option>
            <option value="eBayMotors"  >eBayMotors</option>
            <option value="Canada"  >Canada</option>
            <option value="Australia"  >Australia</option>

    </select>
	<input type="button" value="确定" onclick="changedate()" /></td>
	</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td width="13" colspan='5'>        
        <?php 
		$months				= array(31,28,31,30,31,30,31,31,30,31,30,31);	
		$afirstday			= strtotime(date('Y-m-01 H:i:s',$start));
		$bendday			= strtotime(date('Y-m-d',$start)." 23:59:59");
		$currentdate		= date('Y-m-d');
		$type				= $_REQUEST['type'];
		
		if($type 			== ''){
		
		$start			= strtotime($currentdate);
		$end			= strtotime($currentdate." 23:59:59");
			
		}else{	
		
			$start			= strtotime($_REQUEST['date']);
			$end			= strtotime($_REQUEST['date'].' 23:59:59');
		
		}
		
	
		$month				= date('n',$start)-1;

		$monthdays	= $months[$month];
		
		$ccstart			= strtotime(date('Y-m-01')." 00:00:00");
		$ssstart			= $start;
	
		if($ccstart <= $ssstart){
			 
			$cdays			= intval(date('j',strtotime(date('Y-m-d'))))-1;
	
		
		}else{
		
			$ccmonth		= date('n',$start);
			$cdays			= $months[$ccmonth-1];
		}
		

		@$account	= $_REQUEST['account'];
			
	require_once('libchart/classes/libchart.php');
	$chart = new VerticalBarChart(1500, 550);
	//参数表示需要创建的图像的宽和高
		
	
	$dataSet = new XYDataSet();
	$firstday	= date('Y-m-01 H:i:s',$start);
	$totalgross	= 0;

	
	$qj			=	0;
	
	
	for($i=0;$i<$monthdays;$i++){
		
		
		$pps	= $i+1;
		
		
		
		if($i!=0){
				
				$firstday	= date('Y-m-d',strtotime("$firstday +1 days"));
				$firstdaysend	= $firstday." 23:59:59";
			
				$ss				= strtotime($firstday);
				$ee				= strtotime($firstdaysend);
				
				
				
		}else{
			
				$firstdaystart	= $firstday;
				$firstdaysend	= date('Y-m-d',strtotime($firstday))." 23:59:59";
				
				
			
				
			
				$ss				= strtotime($firstdaystart);
				$ee				= strtotime($firstdaysend);
			
		}
		
		
//		echo date('Y-m-d H:i:s',$ss).' -- '.date('Y-m-d H:i:s',$ee);
		
		

		$gsql			= "SELECT sum(b.ebay_amount) as qty FROM ebay_order AS a JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn WHERE sku =  '$goods_sn'  and ebay_combine!='1'";
			$gsql 			.= " and (a.ebay_paidtime	>='".$ss."' and a.ebay_paidtime	<='".$ee."')";
			
			if($ebay_account != '') $gsql .= " and a.ebay_account ='$ebay_account' ";
			if($ebay_site != '') $gsql .= " and b.ebay_site='$ebay_site' ";
	
			
			$gsql			= $dbcon->execute($gsql);
			$gsql			= $dbcon->getResultArray($gsql);
			$qty1			=  $gsql[0]['qty']?$gsql[0]['qty']:0;
			
			/* 检查此sku 是否是组合产品, 包含当前子SKU 销售产品的信息的 */
			$vv				= "select * from ebay_productscombine where goods_sncombine	 like '%$goods_sn*%' and ebay_user ='$user' ";
			
			
			$vv				= $dbcon->execute($vv);
			$vv				= $dbcon->getResultArray($vv);
			if(count($vv) > 0){
				for($k=0;$k<count($vv);$k++){
					$cgoods_sn			= $vv[$k]['goods_sn']; // => sold 中售出的物品编号，也就是组合产品编号
					$goods_sncombine	= $vv[$k]['goods_sncombine'];   // => 子sku号 和期对应的数量。
					$fxgoods_sncombine	= explode(',',$goods_sncombine);
					for($j=0; $j<count($fxgoods_sncombine);$j++){
						
						$fxlaberstr		= 'FF'.$fxgoods_sncombine[$j];
						if(strstr($fxlaberstr,$goods_sn)){							
							$fxlaberstr01	= explode('*',$fxgoods_sncombine[$j]);
							$fistamount		= $fxlaberstr01[1];							
							$gsql			= "SELECT sum(b.ebay_amount) as qty FROM ebay_order AS a JOIN ebay_orderdetail AS b ON a.ebay_ordersn = b.ebay_ordersn WHERE sku =  '$cgoods_sn'   and ebay_combine!='1'";
							$gsql 			.= " and (a.ebay_paidtime	>='".$ss."' and a.ebay_paidtime	<='".$ee."')";
							
							if($ebay_account != '') $gsql .= " and a.gsql ='$ebay_account' ";
							if($ebay_site != '') 	$gsql .= " and b.gsql='$ebay_site' ";
							$gsql			= $dbcon->execute($gsql);
							$gsql			= $dbcon->getResultArray($gsql);
							$usedqty1		=  $gsql[0]['qty']?$gsql[0]['qty']:0;							
							$qty1			+= $usedqty1 * $fistamount;					
						}					
					}			
				}		
			}
		
   
		

			
			
			
			
		
		$totalgross		+= $qty1;
		$dataSet->addPoint(new Point($pps,  $qty1));
		@$totalgro		= intval($totalgross/$cdays);
		

		

		
		

        
		
	
		
	


		
	
		
	}
	

	@$totalgro		= intval($totalgross/$cdays);

	
	$chart->setDataSet($dataSet);
	$chart->setTitle("Average:".$totalgro."   Total:".$totalgross);
	$filename		= rand(100,99999).".jpg";
	
	$chart->render("libchart/$filename");//这里需要一个路径和文件名称



?>

        
        
        <img src="libchart/<?php echo "$filename"; ?>" width="1200" height="450" />&nbsp;</td>
	</tr>
		

              
		<tr class='pagination'>
		<td colspan='5'>
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
	

	
	function changedate(){
		var ebay_site	= document.getElementById('ebay_site').value;
		var date	= document.getElementById('date').value;
		var sku	= document.getElementById('sku').value;
		var ebay_account	= document.getElementById('ebay_account').value;
		if(date == ''){
			
			alert('请选择日期');
			return false;
			
		
		}
		
		location.href = 'productview.php?type=changedate&date='+date+"&module=warehouse&action=Paypal销售额统计&account=<?php echo $account;?>&goods_sn=<?php echo $goods_sn;?>&sku="+sku+"&ebay_account="+ebay_account+"&ebay_site="+ebay_site;
		
	
	
	
	}



</script>