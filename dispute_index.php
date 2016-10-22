<?php
include "include/config.php";


include "top.php";


$searchtype		= $_REQUEST['searchtype'];
$keys			= $_REQUEST['keys'];	
$account			= $_REQUEST['account'];	
	$UPIStatus			= $_REQUEST['UPIStatus'];	
	
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
	
	
		
	<td nowrap="nowrap" scope="row" >查找：
	  <input name="keys" type="text" id="keys" value="<?php echo $keys;?>" />
	  <select name="searchtype" id="searchtype" style="width:90px">
            <option value="1" <?php if($searchtype == '1') echo 'selected="selected"' ?>>纠纷编号</option>
            <option value="2" <?php if($searchtype == '2') echo 'selected="selected"' ?>>客户ID</option>
            <option value="3" <?php if($searchtype == '3') echo 'selected="selected"' ?>>Item Titel</option>
            <option value="4" <?php if($searchtype == '4') echo 'selected="selected"' ?>>Item ID</option>
          </select>帐号:
      <select name="account" id="account">
      <option value="">同步所有帐号</option>
        <?php 
					$sql	 = "select ebay_account from ebay_account as a where a.ebay_user='$user' and ($ebayacc) and ebay_token != '' order by ebay_account desc ";
					$sqla	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sqla);
					$dbcon->free_result($sqla);
					
					for($i=0;$i<count($sql);$i++){					
					 	$accounts	= $sql[$i]['ebay_account'];
					 ?>
        <option value="<?php echo $accounts;?>" <?php if($accounts == $account) echo 'selected="selected"' ?>><?php echo $accounts;?></option>
        <?php } ?>
        
      </select>
      <span style="white-space: nowrap;">
 状态:
 <select name="UPIStatus" id="UPIStatus">
   <option value="">所有状态</option>
   <?php 
					$sql	 = "select distinct UPIStatus from ebay_case as a where ebay_user ='$user' ";
					$sqla	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sqla);
					$dbcon->free_result($sqla);
					
					for($i=0;$i<count($sql);$i++){					
					 	$UPIStatuss	= $sql[$i]['UPIStatus'];
					 ?>
   <option value="<?php echo $UPIStatuss;?>" <?php if($UPIStatuss == $UPIStatus) echo 'selected="selected"' ?>><?php echo $UPIStatuss;?></option>
   <?php } ?>
 </select>
      </span>
      <input type="button" value="查找" onclick="searchs()" />
<input type="button" value="批量处理" onclick="battch_handle()" />
<input name="input" type="button" value="全选" onclick="check_all('ordersn','ordersn')" /></td>
	</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='11'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" width='2%' class='paginationActionButtons'>&nbsp;</td>
				  <td  nowrap='nowrap' width='1%' align="right" class='paginationChangeButtons'>				  </td>
				</tr>
			</table>		</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap">操作</th>
					<th scope='col' nowrap="nowrap">建立日期</th>
					<th scope='col' nowrap="nowrap">纠纷编号</th>
					<th scope='col' nowrap="nowrap">ebay 帐号</th>
					<th scope='col' nowrap="nowrap">客户ID</th>
					<th scope='col' nowrap="nowrap">争议原因</th>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>状态</div>			</th>
			
					<th scope='col' nowrap="nowrap">Item Titel</th>
					<th scope='col' nowrap="nowrap">Item ID</th>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'> 数量 </div>			</th>
					<th scope='col' nowrap="nowrap"> 金额 </th>
        </tr>
   <?php 
				  
				  	$sql = "select * from ebay_case where id>0  ";
					
					if($keys != '' ){
						if($searchtype == '1') 	$sql .= " and caseId='$keys' ";
						if($searchtype == '2') 	$sql .= " and otherPartyuserId='$keys' ";
						if($searchtype == '3') 	$sql .= " and itemTitle like '%$keys%' ";
						if($searchtype == '4') 	$sql .= " and itemId='$keys' ";
					}
					
					if($account != '' ) $sql .= " and ebay_account ='$account' ";
					if($UPIStatus != '' ) $sql .= " and UPIStatus ='$UPIStatus' ";
					
					
					$sql		.= " and ebay_user ='$user' ";
					
					$sql		.= " order by creationDate desc ";
					
					$query		= $dbcon->query($sql);
					$total		= $dbcon->num_rows($query);
					$totalpages = $total;
					$pageindex  =( isset($_GET['pageindex']) )?$_GET['pageindex']:1;
					$limit = " limit ".($pageindex-1)*$pagesize.",$pagesize";


				$page=new page(array('total'=>$total,'perpage'=>$pagesize));

				$sql = $sql.$limit;
				$sql		= $dbcon->execute($sql);
				$sql		= $dbcon->getResultArray($sql);

			
					
					for($i=0;$i<count($sql);$i++){
						$creationDate			 		= date('Y-m-d H:i:s',$sql[$i]['creationDate']);
						$id			 		= $sql[$i]['id'];
						$openReason 		= $sql[$i]['openReason'];
						$caseId		 		= $sql[$i]['caseId'];
						$transactionId 		= $sql[$i]['transactionId'];
						$otherPartyuserId 	= $sql[$i]['otherPartyuserId'];
						$ebay_account	 	= $sql[$i]['ebay_account'];
						$UPIStatus	 		= $sql[$i]['UPIStatus'];
						$itemId		 		= $sql[$i]['itemId'];
						$itemTitle		 	= $sql[$i]['itemTitle'];
						$caseQuantity		= $sql[$i]['caseQuantity'];
						$currencyId			= $sql[$i]['currencyId'].' : '.$sql[$i]['caseAmount'];
				  ?>
                  
                  
                  
		    
 
									<tr height='20' class='oddListRowS1'>
									  <td scope='row' align='left' valign="top" ><input name="ordersn" type="checkbox" id="ordersn" value="<?php echo $id;?>" /></td>
									  <td scope='row' align='left' valign="top" ><?php echo $creationDate;?>&nbsp;</td>
						              <td scope='row' align='left' valign="top" ><a href="dispute_reply.php?bill=<?php echo $id;?>"  target="_blank"><?php echo $caseId;?></a>&nbsp;</td>
						              <td scope='row' align='left' valign="top" ><?php echo $ebay_account;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" >
                            
                            <?php
								
								echo $otherPartyuserId;
								
							
							
							?>
                            
                            
                            
                            
                            &nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $openReason;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $UPIStatus; ?></td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $itemTitle;?>&nbsp;</td>
							<td scope='row' align='left' valign="top" ><a target="_blank" href="http://cgi.ebay.com/ws/eBayISAPI.dll?ViewItem&item=<?php echo $itemId;?>"><?php echo $itemId;?></a>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $caseQuantity; ?></td>
						    <td scope='row' align='left' valign="top" ><?php echo $currencyId;?>&nbsp;</td>
		      </tr>
									
                                                  
              <?php
			  
			  
			  }
			  ?>
              
                                    
                                    <tr height='20' class='oddListRowS1'>
									  <td colspan="11" align='left' valign="top" scope='row' ><?    echo '<br><center>'.$page->show(2)."</center>";//输出分页 ?></td>
	  </tr>
              
              

              
		<tr class='pagination'>
		<td colspan='11'>
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
	


	function searchs(type){
		var keys			= document.getElementById('keys').value;
		var searchtype		= document.getElementById('searchtype').value;
		var account		= document.getElementById('account').value;
		var UPIStatus		= document.getElementById('UPIStatus').value;
		
		
		var url		= 'dispute_index.php?keys='+keys+'&module=dispute&action=售后纠纷&searchtype='+searchtype+"&account="+account+"&UPIStatus="+UPIStatus;
		location.href = url;
	}
	
	
	
	
	
		


function battch_handle(){


		var bill = '';
		var checkboxs = document.getElementsByName("ordersn");
   		 for(var i=0;i<checkboxs.length;i++){

			if(checkboxs[i].checked == true){
			bill = bill + ","+checkboxs[i].value;
		}	
		}


	var url = "dispute_reply.php?bill="+bill;
	window.open(url,"_blank");
}


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

</script>