<?php
include "include/config.php";


include "top.php";



$keys			= $_REQUEST['keys']?trim($_REQUEST['keys']):"";
$type			= $_REQUEST['type'];



if($type 	== "delsystem"){
	
	$ordersn = explode(",",$_REQUEST['id']);
	$status  = "";
	for($g=0;$g<count($ordersn);$g++){
		
		
		$sn 	=  $ordersn[$g];

		if($sn != ""){
			
			$sql		= "delete from  ebay_partner where id='$sn'";
		
			
			
		if($dbcon->execute($sql)){
	
	
					$status	= " -[<font color='#33CC33'>操作记录: 记录删除成功</font>]";

	}else{
	

					$status = " -[<font color='#FF0000'>操作记录: 记录删除失败</font>]";

	}

			
		}
	}
	
}


	
 ?>
  <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>


<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo '客户信息管理'.$status;?> </h2>
</div>

<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
		
	<td nowrap="nowrap" scope="row" >&nbsp;
	
          关键字：
          <input name="keys" type="text" size="10" id="keys" value="<?php echo $keys ?>">
          <input type="button" value="查找" onClick="searchorder()">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='10'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" width='2%' class='paginationActionButtons'>&nbsp;</td>
				  <td  nowrap='nowrap' width='1%' align="right" class='paginationChangeButtons'>				  </td>
				</tr>
			</table>		</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap">客户ID</th>
					<th scope='col' nowrap="nowrap">姓名</th>
		<th scope='col' nowrap="nowrap">邮件</th>
			
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>客户电话	</div>			</th>
			
					<th scope='col' nowrap="nowrap"><span style="white-space: nowrap;">所在国家</span></th>
		<th scope='col' nowrap="nowrap">原因</th>
		<th scope='col' nowrap="nowrap">登记人</th>
		<th scope='col' nowrap="nowrap">登记时间</th>
		<th scope='col' nowrap="nowrap">状态</th>
	    <th scope='col' nowrap="nowrap">编辑</th>
	</tr>
		


			  <?php
			  	
		
		
				
				
	
					
				$sql		= "SELECT * FROM ebay_hackpeoles where ebay_user='$user' ";
		
				if($keys != '') $sql .= " and(ebay_username like '%$keys%' or userid like '%$keys%' or mail like '%$keys%' or ebay_phone like '%$keys%' or ebay_countryname like '%$keys%' or notes like '%$keys%' )";
				
				
				$query		= $dbcon->query($sql);
				$total		= $dbcon->num_rows($query);
				
				$pageindex  =( isset($_GET['pageindex']) )?$_GET['pageindex']:1;
				$limit = " limit ".($pageindex-1)*$pagesize.",$pagesize";
		
				
				$page=new page(array('total'=>$total,'perpage'=>$pagesize));
				$sql = $sql.$limit;
				$sql		= $dbcon->execute($sql);
				$sql		= $dbcon->getResultArray($sql);
				for($i=0;$i<count($sql);$i++){
					
				 		 $ebay_username				= $sql[$i]['ebay_username'];
						 $userid					= $sql[$i]['userid'];
						 $ebay_usermail				= $sql[$i]['mail'];
						 $ebay_phone				= $sql[$i]['ebay_phone'];
						 $ebay_countryname			= $sql[$i]['ebay_countryname'];
						 $adduser					= $sql[$i]['adduser'];
						 $addtim					= $sql[$i]['addtim'];
						 $notes						= $sql[$i]['notes'];
						 $id						= $sql[$i]['id'];
						 $status						= $sql[$i]['status']?"关闭":"开启";
						 
						 
			  ?>
              
              
                  
         		<tr height='20' class='oddListRowS1'>
						<td scope='row' align='left' valign="top" >
							
						  <a href="orderindex.php?keys=<?php echo $userid	; ?>&account=&sku=&module=orders&action=%E6%89%80%E6%9C%89%E8%AE%A2%E5%8D%95&ostatus=100&note=&country=&start=&end=&shipping=&ebay_ordertype=-1&searchtype=1" target="_blank">
						  <?php echo $userid; ?></a></td>
						    <td scope='row' align='left' valign="top" ><?php echo $ebay_username; ?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" >
							<?php echo $ebay_usermail; ?>                            </td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $ebay_phone;?>&nbsp; </td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $ebay_countryname;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $notes;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $adduser;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $addtim;?>&nbsp;</td>
		                    <td scope='row' align='left' valign="top" ><?php echo $status;?>&nbsp;</td>
       		                <td scope='row' align='left' valign="top" ><a href="bookbackoreradd.php?id=<?php echo $id;?>&module=customer">编辑</a></td>
       		  </tr>
              
           
 
               <?php } ?>
		<tr class='pagination'>
		<td colspan='10'>
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
function searchorder()
{
  	
		var keys		= document.getElementById('keys').value;
		var url			= 's_customer2.php?keys='+keys+'&module=customer';
		location.href	= url;
}

</script>