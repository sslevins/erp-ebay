<?php
include "include/config.php";


include "top.php";


$mstatus		= $_REQUEST['mstatus']?$_REQUEST['mstatus']:"0";
$keys			= $_REQUEST['keys']?trim($_REQUEST['keys']):"";
$sku			= $_REQUEST['sku']?trim($_REQUEST['sku']):"";
$account		= $_REQUEST['account'];
$acc2			= $_REQUEST['acc2'];
$type			= $_REQUEST['type'];




if($type 	== "del"){
	
	$ordersn = explode(",",$_REQUEST['ordersn']);
	$status  = "";
	for($g=0;$g<count($ordersn);$g++){
		
		
		$sn 	=  $ordersn[$g];

		if($sn != ""){
			
			$sql		= "update ebay_order set ebay_status='4' where ebay_ordersn='$sn'";
		
			
			
		if($dbcon->execute($sql)){
	
	
					$status	= " -[<font color='#33CC33'>操作记录: 记录删除成功</font>]";

	}else{
	

					$status = " -[<font color='#FF0000'>操作记录: 记录删除失败</font>]";

	}

			
		}
	}
	
}


if($type 	== "delsystem"){
	
	$ordersn = explode(",",$_REQUEST['ordersn']);
	$status  = "";
	for($g=0;$g<count($ordersn);$g++){
		
		
		$sn 	=  $ordersn[$g];

		if($sn != ""){
			
			$sql		= "delete  from  ebay_order where ebay_ordersn='$sn'";
		
			
			
		if($dbcon->execute($sql)){
	
	
					$status	= " -[<font color='#33CC33'>操作记录: 记录删除成功</font>]";

	}else{
	

					$status = " -[<font color='#FF0000'>操作记录: 记录删除失败</font>]";

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
	
	
		
	<td nowrap="nowrap" scope="row" >&nbsp;
	  <input class='button' type="button" name='button' value='全选' id='search_form_submit' onclick="check_all('ordersn','ordersn')" />
              
              
            
            
            ID/Name/Country/Email/发货方式：
    <input name="keys" type="text" size="10" id="keys" value="<?php echo $keys ?>">
                    CustomL/ItemN：
                    <input name="sku" type="text" id="sku">
                    帐号：<select name="acc" id="acc" onchange="changeaccount()">
                      <option value="">Please select</option>
                      <?php 
					
					$sql	 = "select * from ebay_account as a where ebay_user='$user' and ($ebayacc) order by ebay_account desc ";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 
					 	$acc	= $sql[$i]['ebay_account'];
					 ?>
                      <option value="<?php echo $acc;?>" <?php if($account == $acc) echo "selected=selected" ?>><?php echo $acc;?></option>
                      <?php } ?>
                    </select>
                    <select name="acc2" id="acc2" onchange="changeaccount()">
                      <option value="">Please select</option>
                   
                      <option value="1"    <?php if($acc2 == 1) echo "selected=selected" ?>>有跟踪号</option>
         			   <option value="2"   <?php if($acc2 == 2) echo "selected=selected" ?>>无跟踪号</option>
                    </select>
            <input type="button" value="查找" onClick="searchorder()">
            &nbsp;
            <input type="button" value="结束发信" onclick="endmails()" />
            &nbsp;
            <input type="button" value="手动检查" onclick="handlecheck()" /></td>
</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='12'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" width='2%' class='paginationActionButtons'>&nbsp;</td>
				  <td  nowrap='nowrap' width='1%' align="right" class='paginationChangeButtons'>				  </td>
				</tr>
			</table>		</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>操作</div></th>
			
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>帐号</div></th>
			
					<th scope='col' nowrap="nowrap">销售编号</th>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>Item Name</div>			</th>
			
					<th scope='col' nowrap="nowrap">SKU</th>
		            <th scope='col' nowrap="nowrap">Buyer </th>
        <th scope='col' nowrap="nowrap"> 发货方式&nbsp;</th>
					<th scope='col' nowrap="nowrap">跟踪号</th>
					<th scope='col' nowrap="nowrap">发货时间&nbsp;</th>
		<th scope='col' nowrap="nowrap">发信数量&nbsp;</th>
        <th scope='col' nowrap="nowrap">好评状态</th>
        <th scope='col' nowrap="nowrap">操作</th>
	</tr>
		


			  <?php
			  	
				
			  	
				if($mstatus == 0){
				
					
					$sql		= "select * from ebay_order as a where ebay_user='$user'   and ebay_combine!='1' and (mailstatus='0' or mailstatus='') and ebay_status='2'";
				
				
				}else{
					
				
					$sql		= "select * from ebay_order as a where ebay_user='$user'   and ebay_combine!='1' and mailstatus='$mstatus'  and ebay_status='2'";
				
				}
					

				$tj = "";
				
				if($keys != ""){
					
					$tj	= " and (ebay_carrierstyle like '%$keys%' or ebay_userid like '%$keys%' or ebay_ordersn like '%$keys%' or ebay_username like '%$keys%' or ebay_countryname like '%$keys%' or ebay_usermail like '%$keys%')";	
					$sql .= $tj;
					
				}
				
				
				if($acc2 == '1') $sql.=" and ebay_tracknumber != '' ";
				if($acc2 == '2') $sql.=" and ebay_tracknumber = '' ";
				
			
				
				$account = $_REQUEST['account'];
				
				if($account != '' ) $sql .= " and ebay_account ='$account' ";
				$sql .=" GROUP BY a.ebay_id desc";
				

echo $sql;


				
				
				
				$query		= $dbcon->query($sql);
				$total		= $dbcon->num_rows($query);
				
				$pageindex  =( isset($_GET['pageindex']) )?$_GET['pageindex']:1;
				$limit = " limit ".($pageindex-1)*$pagesize.",$pagesize";
		
				
				$page=new page(array('total'=>$total,'perpage'=>$pagesize));
				$sql = $sql.$limit;
				$sql		= $dbcon->execute($sql);
				$sql		= $dbcon->getResultArray($sql);
				for($i=0;$i<count($sql);$i++){
					
					$noteb		= $sql[$i]['ebay_noteb']?$sql[$i]['ebay_noteb']:"";
					$is_reg		= $sql[$i]['is_reg']?$sql[$i]['is_reg']:"0";
					
					$ebayid		= $sql[$i]['ebay_id'];
					$ordersn	= $sql[$i]['ebay_ordersn'];
					$userid		= $sql[$i]['ebay_userid'];
					$username	= $sql[$i]['ebay_username'];
					$email		= $sql[$i]['ebay_usermail'];
					$total		= $sql[$i]['ebay_total'];
					$currency	= $sql[$i]['ebay_currency'];
					$paidtime	= $sql[$i]['ebay_paidtime'];
					
					
					if($ostatus == 0) $paidtime	= $sql[$i]['ebay_createdtime'];
					
					$country	= $sql[$i]['ebay_countryname'];
					$status		= Getstatus($sql[$i]['ebay_status']);
					$account	= $sql[$i]['ebay_account'];
					$shipfee	= $sql[$i]['ebay_shipfee'];
					$paystatus	= trim($sql[$i]['ebay_paystatus']);					
					$isship		= $sql[$i]['market']?"<img src='../images/iconShipBlue_20x20.gif'/>":"<img title=未标记 src='../images/iconShipGry_20x20.gif'/>";
					
					
					$ispaid		= "<img src='../images/iconPaidBlue_20x20.gif'  width=\"20\" height=\"20\"/>";
					$ebaynote	= $sql[$i]['ebay_noteb'];
					
					if($paystatus == "Incomplete"){
					$ispaid		= "<img src='../images/iconPaidGry_20x20.gif'   width=\"20\" height=\"20\"/>";
					}
					
					$recordnumber	= $sql[$i]['recordnumber'];
					
					$ebay_carrier	= $sql[$i]['ebay_carrier'];
					$ebay_carrierstyle		= $sql[$i]['ebay_carrierstyle'];
					$ebay_markettime		= $sql[$i]['ebay_markettime'];
					$postive				= $sql[$i]['postive'];
					if($postive == '0') $postive	= '未留';
					$ebaynote				= $sql[$i]['ebay_noteb'];
					$$mynote				= $sql[$i]['ebay_note'];
					$templateid				= $sql[$i]['templateid'];
					$ebay_tracknumber				= $sql[$i]['ebay_tracknumber'];

					
					


					
					
							
			  ?>
              

                 
                 
                 
                 
                 
                 <tr height='20' class='oddListRowS1'>
						<td scope='row' align='left' valign="top" ><input name="ordersn" type="checkbox" id="ordersn" value="<?php echo $ebayid;?>" ></td>
				
						    <td scope='row' align='left' valign="top" >
							<?php echo $account; ?>                            </td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $recordnumber;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><a href="http://myworld.ebay.com/<?php echo $userid;?>" target="_blank"><?php echo $userid;?></a>&nbsp;(<?php echo $email;?>) </td>
				
						    <td scope='row' align='left' valign="top" >&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $username;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $ebay_carrier;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $ebay_tracknumber;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php  
							
							
							if($ebay_markettime != ''){
							
						echo 	date('Y-m-d',$ebay_markettime);
							}
							
							
							
							
							
							
							?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" >
                            <?php
								
								$se		= "select * from ebay_messagelog where order_id='$ebayid'";
								$se		= $dbcon->execute($se);
								$se		= $dbcon->getResultArray($se);
								echo count($se);
								
								
							
							
							
							?>
                            
                            &nbsp;</td>
       		                <td scope='row' align='left' valign="top" ><?php echo $postive;?>&nbsp;</td>
       		                <td scope='row' align='left' valign="top" >
                            <a href="templateset.php?ordersn=<?php echo $ebayid;?>&module=mail" target="_blank"></a>&nbsp;&nbsp;                            
                            <a href="viewmessagelog.php?id=<?php echo $ebayid; ?>&module=mail" target="_blank">查看</a>&nbsp;&nbsp;
                                                 <a href="#" onclick="endmails('<?php echo $ordersn;?>')" >结束发信</a>                            </td>
       		  </tr>
              

              
                 
                 
                 
                 
              <?php   } ?>
		<tr class='pagination'>
		<td colspan='12'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'><div align="center"><?    echo '<br><center>'.$page->show(2)."</center>";//输出分页 ?> 
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
	
		

		var content 	= document.getElementById('keys').value;
		var account 	= document.getElementById('acc').value;
		var acc2 	= document.getElementById('acc2').value;
		var sku 	= document.getElementById('sku').value;
		location.href= 'mailorderindex.php?keys='+content+"&account="+account+"&sku="+sku+"&module=mail&action=<?php echo $_REQUEST['action'];?>&mstatus=<?php echo $mstatus;?>&acc2="+acc2;
		
		
	}
	
	
	


function handlecheck(){
		
		
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
		
		if(confirm('您确认将选中订单进行手动信件检查吗?')){
		
		var url	 = "mailrun.php?ordersn="+bill;
		
		
		window.open(url,"_blank");
		}
	
}


function endmails(ebayid){
		
		
	
	
		
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
		
		if(confirm('您确认将选中订单进行手动信件检查吗?')){
		
			var url	 = "endmails.php?ebayid="+bill;
			window.open(url,"_blank");
		}
		
	
}

</script>