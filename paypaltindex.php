<?php
include "include/config.php";


include "top.php";

$start = $_REQUEST['start'];
$end   = $_REQUEST['end'];
	
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
	<input tabindex='2' title='关联eBay帐号' class='button' type="button" name='button' value='添加Paypal帐号' id='search_form_submit' onClick="location.href='paypaladd.php?module=system&action=添加Paypal帐号'"/>
	&nbsp;
	<br>
	<input name="start" id="start" type="text" onclick="WdatePicker()" value="<?php echo $start;?>" />
	~
	<input name="end" id="end" type="text" onclick="WdatePicker()" value="<?php echo $end;?>" />
	<input tabindex='2' title='查询' class='button' type="button" name='button' value='查询' id='search_form_submit1' onclick="search()"/>
	</td>
	</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='5'>&nbsp;			</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>帐号</div>			</th>
			
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>API username</div>			</th>
			
					<th scope='col' width='13%' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>
                                                                                       API password</div>			</th>
			
					<th scope='col' nowrap="nowrap">累计销售金额&nbsp;</th>
					<th scope='col'  nowrap="nowrap">操作</th>
	</tr>
		
   <?php 
				  
				  	$sql = "select * from ebay_paypal where user='$user'";
					$sql = $dbcon->execute($sql);
					$sql = $dbcon->getResultArray($sql);
				
					
					for($i=0;$i<count($sql);$i++){
						
						$account	= $sql[$i]['account'];
						$name		= $sql[$i]['name'];
						$pass		= $sql[$i]['pass'];
						$signature	= $sql[$i]['signature'];
						
						
						$id			= $sql[$i]['id'];
						$sqltotal	= "select sum(gross) as gross,sum(net) as net,sum(fee) as fee,currency from ebay_paypaldetail where account='$account' ";
						
						if($start && $end) $sqltotal .= " and time>='".strtotime($start.'00:00:00')."' and time<='".strtotime($end.'23:59:59')."'";
	
						$sqltotal	.= ' group by currency';
						//echo $sqltotal.'<br>';
						$sqltotal 	= $dbcon->execute($sqltotal);
						$sqltotal 	= $dbcon->getResultArray($sqltotal);
						
						$gosstotal 	= 0;
						$feetotal 	= 0;
						$nettotal 	= 0;
						
						for($e=0;$e<count($sqltotal);$e++){
						
							$currency		= $sqltotal[$e]['currency'];
							
							$rates			= "select * from ebay_currency where currency='$currency' and user='$user'";
							$rates 			= $dbcon->execute($rates);
							$rates 			= $dbcon->getResultArray($rates);
							$rates			= $rates[0]['rates']?$rates[0]['rates']:1;
							
							$gosstotal		+= ($sqltotal[$e]['gross'] * $rates);
							$feetotal		+= ($sqltotal[$e]['fee'] * $rates);
							$nettotal		+= ($sqltotal[$e]['net'] * $rates);
						
						}
						
						$dstr		= "总金额:".$gosstotal." 总费用：".$feetotal." 总净额：".$nettotal;
						
						
				  ?>
                  
                  
                  
		    
 
					<tr height='20' class='oddListRowS1'>
						    <td scope='row' align='left' valign="top" ><?php echo $account; ?></td>				
						    <td scope='row' align='left' valign="top" ><?php echo $name; ?></td>				
						    <td scope='row' align='left' valign="top" ><?php echo $pass;?> </td>				
						    <td scope='row' align='left' valign="top" ><?php echo $dstr;?>&nbsp;</td>
		                    <td scope='row' align='left' valign="top" ><a href="paypalstaticschat.php?account=<?php echo $account; ?>&module=finance&action=paypal统计图表">查看统计图表</a>&nbsp;</td>
			 		</tr>
              
              
              
              <?php
			  
			  
			  }
			  ?>
              
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
	function search(){
	
		

		var start 		= document.getElementById('start').value;
		var end 		= document.getElementById('end').value;	
		location.href= 'paypaltindex.php?module=finance&action=Paypal销售额统计&start='+start+"&end="+end;
		
		
	}



</script>