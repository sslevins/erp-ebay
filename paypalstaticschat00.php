<?php
include "include/config.php";
error_reporting(ALL);


include "top.php";



	
	
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

<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
		
	<td nowrap="nowrap" scope="row" >
	<input tabindex='2' title='关联eBay帐号' class='button' type="button" name='button' value='添加Paypal帐号' id='search_form_submit' onClick="location.href='paypaladd.php?module=system&action=添加Paypal帐号'"/> 选择时间：<input name="date" type="text" id="date" onClick="WdatePicker()" />
	&nbsp;<input type="button" value="确定" onclick="changedate()" /></td>
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
	//	echo $firstday." && ".$firstdaysend."<br>";
		
		
   
		


	
					
			$sql			= "select sum(net) as net,sum(fee) as fee, sum(gross) as gross from ebay_paypaldetail where time>=$ss and time<=$ee and account='$account'";
		
			
		
			$result			= getdata($sql);	
				if($result['gross']!= 0){
			
			@$pj++;
		
			}

		$totalgross		+=intval($result['gross']);
		$dataSet->addPoint(new Point($pps,  intval($result['gross'])));
		@$totalgro		= intval($totalgross/$cdays);

	
		

		

		
		

        
		
	
		
	


		
	
		
	}
	

	@$totalgro		= intval($totalgross/$cdays);

	
	$chart->setDataSet($dataSet);
	$chart->setTitle("Average:".$totalgro."   Total:".$totalgross);
	$filename		= rand(100,99999).".jpg";
	echo $filename;
	
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
	
	function del(id){
		if(confirm('您确认删除此条记录吗')){
			
			location.href = 'paypalindex.php?type=del&id='+id+"&module=system&action=paypal帐号管理";
			
		
		}
	
	
	}
	
	function changedate(){
		
		var date	= document.getElementById('date').value;
		location.href = 'paypalstaticschat.php?type=changedate&date='+date+"&module=finance&action=Paypal销售额统计&account=<?php echo $account;?>";
		
	
	
	
	}



</script>