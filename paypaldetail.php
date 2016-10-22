<?php
include "include/config.php";


include "top.php";


$accounts		= $_REQUEST['account'];
	$start			= $_REQUEST['start'];
	$end			= $_REQUEST['end'];
	$keys			= $_REQUEST['keywords'];

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
	
	&nbsp;输入关键字：
	<input name="keywords" id="keywords" type="text" value="<?php echo $keys;?>" />
费用时间:
<input name="start" id="start" type="text" onclick="WdatePicker()"  value="<?php echo $start;?>"  />
~
<input name="end" id="end" type="text" onclick="WdatePicker()" value = "<?php echo $end;?>" />
<select name="account" id="account">
                    
                    <option value="">同步所有帐号</option>
                    <?php 
					
					$sql	 = "select * from ebay_paypal where user='$user'";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 
					 	$account	= $sql[$i]['account'];
					 ?>
                      <option value="<?php echo $account;?>"><?php echo $account;?></option>
                    <?php } ?>
                    </select>
<input tabindex='2' class='button' type="button" name='search_form_submit' value='查找' id='search_form_submit2' onclick="searchtxt()"/>
&nbsp;
<input tabindex='2' class='button' type="button" name='search_form_submit' value='导出查询结果' id='search_form_submit3' onclick="toxls()"/></td>
	</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td width="13%" colspan='4'><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
          
          <tr>
            <td height="20"><table width="100%" height="1" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
              <tr>
                <td><?php echo $status; ?></td>
              </tr>
            </table></td>
          </tr>
          
          <tr>
            <td>
            
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
  <tr>
    <th bgcolor="#eeeeee" class="left_txt">Select</th>
    <th height="30" bgcolor="#eeeeee" class="left_txt">Paypal帐号</th>
    <th bgcolor="#eeeeee" class="left_txt">客户Email</th>
    <th bgcolor="#eeeeee" class="left_txt">客户姓名</th>
    <th bgcolor="#eeeeee" class="left_txt">交易ID</th>
    <th bgcolor="#eeeeee" class="left_txt">净额</th>
    <th bgcolor="#eeeeee" class="left_txt">费用</th>
    <th bgcolor="#eeeeee" class="left_txt">总金额</th>
    <th bgcolor="#eeeeee" class="left_txt">交易创建时间</th>
  </tr>
			<?php
			
			
				$sql	= "select * from ebay_paypaldetail where user='$user' ";
				
				$keys 	= $_REQUEST['keys'];
				if($keys != ""){
				
					
					$sql.=" and (tid like '%$keys%' or name like '%$keys%' or mail like '%$keys%' ) ";
					
				}
				
				
				if($accounts != '' ) $sql.= " and account = '$accounts' ";
				if($start != '' && $end != ''){
				
					$st00	= strtotime($start." 00:00:00");
					$st11	= strtotime($end." 23:59:59");
					$sql	.= " and (time	>=$st00 and time	<=$st11)";
				}
				
				
				$sql	.=" order by time desc";
				
			
				$tsql 	= $dbcon->query($sql);
				$total 	= $dbcon->num_rows($tsql);
				$pageindex  =( isset($_GET['pageindex']) )?$_GET['pageindex']:1;
				$limit = " limit ".($pageindex-1)*$pagesize.",$pagesize";
				$page=new page(array('total'=>$total,'perpage'=>$pagesize));
				$sql = $sql.$limit;
				
				$sql = $dbcon->execute($sql);
				$sql = $dbcon->getResultArray($sql);
				for($i=0;$i<count($sql);$i++){
					
					$gross			= $sql[$i]['gross'];
					$fee		= $sql[$i]['fee'];
					$net			= $sql[$i]['net'];
			
					$tid 	= $sql[$i]['tid'];
					$account			= $sql[$i]['account'];
					$time			= $sql[$i]['time'];
					

			?>
              
   	<tr height='20' class='oddListRowS1'>
      <td align="left" bgcolor="#FFFFFF" class="left_txt"><input name="ordersn" type="checkbox" id="ordersn" value="<?php echo $mid;?>" >&nbsp;</td>
    <td align="left" bgcolor="#FFFFFF" class="left_txt" title=""><?php echo $account;?>&nbsp;</td>
    <td align="left" bgcolor="#FFFFFF" class="left_txt" title="">
    
    <?php echo $sql[$i]['mail']; ?>
    &nbsp;</td>
    <td align="left" bgcolor="#FFFFFF" class="left_txt" title="">
    
    <?php echo $sql[$i]['name']; ?>
    &nbsp;</td>
    <td align="left" bgcolor="#FFFFFF" class="left_txt"><?php echo $tid;?>&nbsp;</td>
    <td align="left" bgcolor="#FFFFFF" class="left_txt"><?php echo $net;?>&nbsp;</td>
    <td align="left" bgcolor="#FFFFFF" class="left_txt"><?php echo $fee;?>&nbsp;</td>
    <td align="left" bgcolor="#FFFFFF" class="left_txt"><?php echo $gross;?>&nbsp;</td>
    <td align="left" bgcolor="#FFFFFF" class="left_txt"><?php echo date('Y-m-d H:i:s',$time);?>&nbsp;</td>
    </tr>
    
    
    <?php } ?>
    
    <tr align="center" class="0">
      <td colspan="9" align="left" bgcolor="#FFFFFF" class="left_txt"><div align="left">
          <div align="center"><?    echo '<br><center>'.$page->show(2)."</center>";//输出分页 ?> </td>
    </tr>
    

    
    <tr align="center" class="0">
      <td colspan="13" align="left" bgcolor="#FFFFFF">      </td>
    </tr>
  </table>
            
            
            </td>
          </tr>
        
        </table>&nbsp;</td>
	</tr>
		

		<tr class='pagination'>
		<td colspan='4'>
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
	
		function searchtxt(){
		
		var keys	= document.getElementById("keywords").value;
		var start	= document.getElementById("start").value;
		var end		= document.getElementById("end").value;
		var account	= document.getElementById("account").value;
		location.href= "paypaldetail.php?module=finance&keys="+keys+"&start="+start+"&end="+end+"&account="+account;
		
	
	
	}
	
	function toxls(){
		
		var keys	= document.getElementById("keywords").value;
		var start	= document.getElementById("start").value;
		var end		= document.getElementById("end").value;
		var account	= document.getElementById("account").value;
		location.href= "paypaldetailtoxls.php?module=finance&keys="+keys+"&start="+start+"&end="+end+"&account="+account;
		
		
	
	
	}

	


</script>