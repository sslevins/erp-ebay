<?php
include "include/config.php";
error_reporting(0);


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
<input type="button" value="确定" onclick="searchs()" /></td>
</tr>
</table>
</div>
</form>
 <table width="80%" border="1" align="center" cellpadding="1" cellspacing="1" bordercolor="#009999" bgcolor="#000000">
<tr>
          <td bgcolor="#FFFFFF">订单销销量走势图</td>
        <td bgcolor="#FFFFFF">销售额走势图</td>
</tr>
<tr>
  <td bgcolor="#FFFFFF"><img src="target.php?startdate=<?php echo $startdate;?>&enddate=<?php echo $enddate;?>&account=<?php echo $account;?>&type=orders" /></td>
  <td bgcolor="#FFFFFF"><img src="target.php?startdate=<?php echo $startdate;?>&enddate=<?php echo $enddate;?>&account=<?php echo $account;?>&type=amount" /></td>
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
		
		location.href = 'reportsales01.php?startdate='+startdate+'&enddate='+enddate+"&account="+account+"&module=report&ebay_site="+ebay_site;
	
	
	
	}




</script>