<?php
include "include/config.php";


include "top.php";



$os		= $_REQUEST['ostatus'];


	if($_REQUEST['type'] == "mk"){
		
		$ms  		= $_REQUEST['gstatus']; 
		$messageid	= explode(",",$_REQUEST['bill']);
		
		$status		= "";
		
		for($g=0;$g<count($messageid);$g++){
			
			$mid	= $messageid[$g];
			if($mid	!= ""){
				
				$sql			= "UPDATE `ebay_message` SET `status` = '".$ms."' WHERE `message_id` ='$mid'";
				if($dbcon->execute($sql)){
			
			$status	= " -[<font color='#33CC33'>操作记录: 记录操作成功</font>]";
			
		}else{
		
			$status = " -[<font color='#FF0000'>操作记录: 记录操作败</font>]";
		}
		
			
			}
			
		}
	
	
	}
	
	
	
		if($_REQUEST['type'] == "class"){
		
		$ms  		= $_REQUEST['status']; 
		$messageid	= explode(",",$_REQUEST['bill']);
		$classid		= $_REQUEST['classid'];
		$status		= "";
		
		for($g=0;$g<count($messageid);$g++){
			
			$mid	= $messageid[$g];
			if($mid	!= ""){
				
				
				$sql			= "UPDATE `ebay_message` SET `classid` = '".$classid."' WHERE `message_id` ='$mid'";

				
				if($dbcon->execute($sql)){
			
			$status	= " -[<font color='#33CC33'>操作记录: 记录操作成功</font>]";
			
		}else{
		
			$status = " -[<font color='#FF0000'>操作记录: 记录操作失败</font>]";
		}
		
			
			}
			
		}
	
	
	}
	
	
	
	

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
	
	
		
	<td nowrap="nowrap" scope="row" >
	<input tabindex='2' title='关联eBay帐号' class='button' type="button" name='button' value='添加模板' id='search_form_submit' onClick="location.href='addtemplate.php?module=message&action=Message模板'"/>
	&nbsp;</td>
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
            
		 <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" bordercolor="#999999" bgcolor="#CCCCCC">

  <tr>
    <th bgcolor="#eeeeee" class="left_txt">Select</th>
    <th height="30" bgcolor="#eeeeee" class="left_txt">From</th>
    <th width="66%" bgcolor="#eeeeee" class="left_txt">Subject</th>
    <th bgcolor="#eeeeee" class="left_txt">Received</th>
    <th bgcolor="#eeeeee" class="left_txt">Class</th>
    <th bgcolor="#eeeeee" class="left_txt">Status</th>
  </tr>
			<?php
			
			
			$cidtype	= $_REQUEST['cidtype'];
			
			if($cidtype !=""){
					
					$sql = "select * from ebay_message where status='$os' and classid='$cidtype' order by id desc";
				}else{
					$sql = "select * from ebay_message where status='$os' order by id desc";
				}
		
		
			
				
				$tsql 	= $dbcon->query($sql);
				$total 	= $dbcon->num_rows($tsql);
				$pageindex  =( isset($_GET['pageindex']) )?$_GET['pageindex']:1;
				$limit = " limit ".($pageindex-1)*$pagesize.",$pagesize";
				$page=new page(array('total'=>$total,'perpage'=>$pagesize));
				$sql = $sql.$limit;
				
				$sql = $dbcon->execute($sql);
				$sql = $dbcon->getResultArray($sql);
				for($i=0;$i<count($sql);$i++){
					
					$userid			= $sql[$i]['sendid'];
					$subject		= $sql[$i]['subject'];
					$rtime			= $sql[$i]['createtime'];
					$mstatus		= GetMessagestatus($sql[$i]['status']);
					$recipientid 	= $sql[$i]['recipientid'];
					$body			= $sql[$i]['body'];
					$itemid			= $sql[$i]['itemid'];
					$title			= $sql[$i]['title'];
					$mid			= $sql[$i]['message_id'];
					$classid		= $sql[$i]['classid'];
					
			?>
              
    <tr align="center" class="0">
      <td align="left" bgcolor="#FFFFFF" class="left_txt"><input name="ordersn" type="checkbox" id="ordersn" value="<?php echo $mid;?>" >&nbsp;</td>
    <td align="left" bgcolor="#FFFFFF" class="left_txt"><?php echo $userid;?>&nbsp;</td>
    <td align="left" bgcolor="#FFFFFF" class="left_txt"><div align="left"><b><?php echo $subject;?></b>&nbsp;</div></td>
    <td align="left" bgcolor="#FFFFFF" class="left_txt"><div align="center"><?php echo $rtime;?>&nbsp;</div></td>
    <td align="left" bgcolor="#FFFFFF" class="left_txt"><div align="center">
    <?php
    	$so	= "select * from ebay_messagecategory where id='$classid'";
		$so	= $dbcon->execute($so);
		$so = $dbcon->getResultArray($so);
		echo $so[0]['category_name'];
		
     
	 ?>
        
    
    </div></td>
    <td align="left" bgcolor="#FFFFFF" class="left_txt"><div align="center"><?php echo $mstatus;?></div></td>   
    </tr>
    
    
    <?php } ?>
    
    <tr align="center" class="0">
      <td colspan="6" align="left" bgcolor="#FFFFFF" class="left_txt"><div align="left">
          <input name="selectall" type="button" value="全选" onClick="check_all('ordersn','ordersn')">
          &nbsp;
          <input name="input" type="button" value="批量回复" onClick="replyall()" />
          <input name="input2" type="button" value="单个回复" onClick="replyone()" />
          <input name="input3" type="button" value="标为已回复" onClick="marketyh()" />
          <input name="input4" type="button" value="标为未回复" onClick="marketwh()" />
&nbsp;将选定的Message转到
<select name="mm" id="mm" onChange="classid('<?php echo $userid;?>')">
  <option value="0">请选择</option>
  <?php	
		$so	= "select * from ebay_messagecategory";	
		$so	= $dbcon->execute($so);
		$so = $dbcon->getResultArray($so);		
		for($ii=0;$ii<count($so);$ii++){			
			$cname		= $so[$ii]['category_name'];
			$cid		= $so[$ii]['id'];		
	   ?>
  <option <?php if($type == $cid) echo "selected" ?> value="<?php echo $cid;?>"><?php echo $cname; ?></option>
  <?php }  ?>
</select> 
分类
      
      <?    echo '<center>'.$page->show(2)."</center>";?>      
      </div></td>
    </tr>
    

    
    <tr align="center" class="0">
      <td colspan="10" align="left" bgcolor="#FFFFFF">      </td>
    </tr>
  </table>
            
            
            </td>
          </tr>
        
        </table>&nbsp;</td>
	</tr>
		
		  <?php 
				  
				  	$sql = "select * from ebay_messagetemplate where ebay_user='$user'";
					$sql = $dbcon->execute($sql);
					$sql = $dbcon->getResultArray($sql);
				
					
					for($i=0;$i<count($sql);$i++){
						
						$category_name	= $sql[$i]['name'];
						$ebay_note	= $sql[$i]['note'];
						$id				= $sql[$i]['id'];
						
						
				  ?>
                  
                  
                  
		    
              <?php
			  
			  
			  }
			  ?>
              
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
	


</script>