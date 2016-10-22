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
    输入关键字：<input name="keywords" id="keywords" type="text" value="<?php echo $keys;?>" />
    费用时间:
    <input name="start" id="start" type="text" onclick="WdatePicker()"  value="<?php echo $start;?>"  />
    ~
    <input name="end" id="end" type="text" onclick="WdatePicker()" value = "<?php echo $end;?>" />
    <select name="account" id="account">
    <option value="">所有eBay帐号</option>
      <?php 
					$sql	 = "select * from ebay_account where ebay_user='$user'";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 
					 	$account	= $sql[$i]['ebay_account'];
					 ?>
      <option value="<?php echo $account;?>" <?php if($accounts == $account ) echo 'selected="selected"';?>><?php echo $account;?></option>
      <?php } ?>
    </select>
	<input tabindex='2' class='button' type="button" name='button' value='查找' id='search_form_submit' onClick="searchtxt()"/>
	&nbsp;
	<input tabindex='2' class='button' type="button" name='search_form_submit' value='导出查询结果' id='search_form_submit2' onclick="toxls()"/></td>
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
    <th height="30" bgcolor="#eeeeee" class="left_txt">费用类型</th>
    <th bgcolor="#eeeeee" class="left_txt">费用描述</th>
    <th bgcolor="#eeeeee" class="left_txt">费用日期</th>
    <th bgcolor="#eeeeee" class="left_txt">费用金额</th>
    <th bgcolor="#eeeeee" class="left_txt">物品标题</th>
    <th bgcolor="#eeeeee" class="left_txt">Item Number</th>
    <th bgcolor="#eeeeee" class="left_txt">eBay帐号</th>
  </tr>
			<?php
			
			
				$sql	= "select * from ebay_fee where user='$user' ";
				
				if($keys != ""){
					$sql.=" and (feetype like '%$keys%' or feetdescription  like '%$keys%' or title like '%$keys%' or itemid like '%$keys%' or account like '%$keys%')";
				}
				
				if($accounts != '' ) $sql.= " and account = '$accounts' ";
				if($start != '' && $end != ''){
				
					$st00	= strtotime($start." 00:00:00");
					$st11	= strtotime($end." 23:59:59");
					$sql	.= " and (feeddate1	>=$st00 and feeddate1	<=$st11)";
				}
				
				
				
				$sql	.=" order by feedate desc";

			
				
				$tsql 	= $dbcon->query($sql);
				$total 	= $dbcon->num_rows($tsql);
				$pageindex  =( isset($_GET['pageindex']) )?$_GET['pageindex']:1;
				$limit = " limit ".($pageindex-1)*$pagesize.",$pagesize";
				$page=new page(array('total'=>$total,'perpage'=>$pagesize));
				$sql = $sql.$limit;
				
				$sql = $dbcon->execute($sql);
				$sql = $dbcon->getResultArray($sql);
				for($i=0;$i<count($sql);$i++){
					
					$feetype  			= $sql[$i]['feetype'];
					$feetdescription   	= $sql[$i]['feetdescription'];
					$feedate    	= $sql[$i]['feedate'];
					$feeamount   		= $sql[$i]['feeamount'];
					$title   			= $sql[$i]['title'];
					$itemid   			= $sql[$i]['itemid'];
					$account  			= $sql[$i]['account'];
					$id		  			= $sql[$i]['id'];
					
					

			?>
              
   	<tr height='20' class='oddListRowS1'>
      <td align="left" bgcolor="#FFFFFF" class="left_txt"><input name="ordersn" type="checkbox" id="ordersn" value="<?php echo $id;?>" >&nbsp;</td>
    <td align="left" bgcolor="#FFFFFF" class="left_txt" title=""><?php echo $feetype;?>&nbsp;</td>
    <td align="left" bgcolor="#FFFFFF" class="left_txt"><?php echo $feetdescription;?>&nbsp;</td>
    <td align="left" bgcolor="#FFFFFF" class="left_txt"><?php echo $feedate;?>&nbsp;</td>
    <td align="left" bgcolor="#FFFFFF" class="left_txt"><?php echo $feeamount;?>&nbsp;</td>
    <td align="left" bgcolor="#FFFFFF" class="left_txt"><?php echo $title;?>&nbsp;</td>
    <td align="left" bgcolor="#FFFFFF" class="left_txt"><?php echo $itemid;?>&nbsp;</td>
    <td align="left" bgcolor="#FFFFFF" class="left_txt"><?php echo $account;?>&nbsp;</td>
    </tr>
    
    
    <?php } ?>
    
    <tr align="center" class="0">
      <td colspan="7" align="left" bgcolor="#FFFFFF" class="left_txt"><div align="left">
          <div align="center"><?    echo '<br><center>'.$page->show(2)."</center>";//输出分页 ?> </td>
    </tr>
    

    
    <tr align="center" class="0">
      <td colspan="11" align="left" bgcolor="#FFFFFF">      </td>
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
	
	function marketyh(){
		
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
		
		if(confirm("确认将此条信息标为已回复")){
			
			location.href= "messageindex.php?type=mk&module=message&ostatus=<?php echo $os ?>&gstatus=1&bill="+bill;
		
		}	
		
	}
	
	function marketwh(){
		
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
	
		if(confirm("确认将此条记录标为未回复")){
			
			location.href= "messageindex.php?type=mk&module=message&ostatus=<?php echo $os ?>&gstatus=0&bill="+bill;
		}
		
		
	}
	
	function replyall(){
		
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
	
		var url	=  "ebaymessagereply.php?messageid="+bill;
		window.open(url,"_blank");
		
	}
	
	function replyone(){
		
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
	
		var url	=  "ebaymessagereplyone.php?messageid="+bill;
		window.open(url,"_blank");
		
	}
	
		
	function viewproblem(bill){
		
	

		if(bill == ""){
			
			alert("请选择订单号");
			return false;	
		}
	
		var url	=  "ebaymessagereplyone.php?messageid="+bill;
		window.open(url,"_blank");
		
	}
	
	
	function classid(name){
		
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
		
		var id 	= document.getElementById("mm").value;
		
		if(confirm("您确认将此分类，移动到所先分类中?")){
			
			location.href= "messageindex.php?type=mk&module=message&type=class&ostatus=<?php echo $os ?>&bill="+bill+"&classid="+id;
			
		
		}
	}
	
	
	function searchtxt(){
		
		var keys	= document.getElementById("keywords").value;
		var start	= document.getElementById("start").value;
		var end		= document.getElementById("end").value;
		var account	= document.getElementById("account").value;
		location.href= "ebaydetail.php?module=finance&keys="+keys+"&start="+start+"&end="+end+"&account="+account;
		
		
	
	
	}
	
	function toxls(){
		
		var keys	= document.getElementById("keywords").value;
		var start	= document.getElementById("start").value;
		var end		= document.getElementById("end").value;
		var account	= document.getElementById("account").value;
		location.href= "ebaydetailtoxls.php?module=finance&keys="+keys+"&start="+start+"&end="+end+"&account="+account;
		
		
	
	
	}
	


</script>