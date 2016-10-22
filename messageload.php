<?php
include "include/config.php";


include "top.php";




	
	$type	= $_REQUEST['type'];
	if($type == "del"){
		
		$id	 = $_REQUEST['id'];
		$sql = "delete from ebay_account where id=$id";
		if($dbcon->execute($sql)){
			
			$status	= " -[<font color='#33CC33'>操作记录: 记录删除成功</font>]";
			
		}else{
		
			$status = " -[<font color='#FF0000'>操作记录: 记录删除失败</font>]";
		}
		
	
	}else{
		
		$status = "";
		
	}
	
	
	
	$saccount					= $_REQUEST['account'];
	$start1						= date('Y-m-d');	
	$start0						= date('Y-m-d',strtotime("$start1 -1 days"));
	
 ?>
 <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status;?> </h2>
</div>

<div class='listViewBody'>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td width="65%">
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'><table width="100%" height="99" border="0" cellpadding="0" cellspacing="0">
                
			    <form method="post" action="addaccount.php">   
			      <tr>
                    <td width="41%" height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right">eBay帐号:</div></td>
                    <td width="3%" align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
                    <td width="56%" height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
                    <select name="account" id="account">
                    <option value="all">同步所有帐号</option>
                    <?php 
					
					$sql	 = "select * from ebay_account where ebay_user='$user' and ($ebaymes) and ebay_token != '' order by ebay_account desc ";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 
					 	$account	= $sql[$i]['ebay_account'];
					 ?>
                      <option value="<?php echo $account;?>"><?php echo $account;?></option>
                    <?php } ?>
                    </select></div></td>
                    </tr>
			      <tr>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">开始时间:</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
                    <input name="start" id="start" type="text" onClick="WdatePicker()" value="<?php echo $start0;?>" />
			        </div></td>
			        </tr>
			      <tr>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right">结束时间</div></td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">  <div align="left">
			          <input name="end" id="end" type="text" onClick="WdatePicker()" value="<?php echo $start1;?>" />
			          &nbsp;</div></td>
			        </tr>
                  <tr>
				 </form> 
                    <td height="30" align="right" class="left_txt"><div align="right"></div></td>
                    <td align="right" class="left_txt">&nbsp;</td>
                    <td height="30" align="right" class="left_txt"><div align="left"><input type="button" value="同步" onClick="check()">
                    </div></td>
                    </tr>       
                </table>
					 <?php
					 
					 
						
						if($_REQUEST['type'] == 'load'){
						
								$start		= $_REQUEST['start']."T00:00:00";
								$end		= $_REQUEST['end']."T23:59:59";
								
								if($saccount == 'all'){
								$sql 		 = "select * from ebay_account where ebay_user='$user' and ($ebaymes)";
								
								}else{
								
								$sql 		 = "select * from ebay_account where ebay_user='$user' and ebay_account ='$saccount'";
								}
								$sql		 = $dbcon->execute($sql);
								$sql		 = $dbcon->getResultArray($sql);
								for($i=0;$i<count($sql);$i++){
									 $token		 = $sql[$i]['ebay_token'];
									 $account	 = $sql[$i]['ebay_account'];
									 if($token != ""){
										GetMemberMessages($start,$end,$token,$account);
									}
									echo $account.'message load complete';
								}
						}
					 ?>
                     
                     
                     
                     
                     
                     </td>
			    </tr>
			</table>		</td>
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
	function check(){
		
		var account =	document.getElementById('account').value;
		var start	= 	document.getElementById('start').value;
		var end		=	document.getElementById('end').value;
		
		if(account == -1){
			
			alert("请选择要加载的eBay帐号");
			return false;
			
		}
		
		if(start == ""){
			
			alert('请选择开始日期');
			return false;
			
		}
		
		if(end == ""){
			
			alert('请选择结束日期');
			return false;
		}
		
		var url	= 'messageload.php?account='+account+"&start="+start+"&end="+end+"&type=load&module=message&action=Message同步";
		location.href = url;
		
		
	}


</script>