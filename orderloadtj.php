<?php
include "include/config.php";


include "top.php";



	
	/* 建立订单分类 */
	
	$ordermenuarry		= array();
	

	
	$ordermenuarry[0]['value']		= '0';
	$ordermenuarry[0]['name']		= '未付款';
	
	$ordermenuarry[1]['value']		= '1';
	$ordermenuarry[1]['name']		= '待处理';
	
	
	$ss		= "select id,name from ebay_topmenu where ebay_user='$user' and name!='' order by ordernumber";
	$ssa		= $dbcon->execute($ss);
	$ss		= $dbcon->getResultArray($ssa);
	
	/* 释放mysql 系统资源 */
	$dbcon->free_result($ssa);
		
	$dd		= 2;
	
	for($i=0;$i<count($ss);$i++){
		
		$ssid		= $ss[$i]['id'];
		$ssname		= $ss[$i]['name'];
		
		$ordermenuarry[$dd]['value']		= $ssid;
		$ordermenuarry[$dd]['name']			= $ssname;
		$dd++;
		
		
		
	}

	
	
	
	
 ?>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr>
          <td><div class='listViewBody'>
  <div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='4'>&nbsp;</td>
	</tr><tr height='20'>
					<th scope='col' width='26%' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>销售订单统计：	</div>			</th>
			
					<th scope='col' width='13%' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'></div>			</th>
			
					<th scope='col' width='13%' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'></div>			</th>
			
		<th scope='col' width='13%' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'></div>			</th>
			
					</tr>
		
		  <?php 
				  
				  	$sql = "select id,ebay_account from ebay_account where ebay_user='$user'  and ($ebaymes) ";
					$sqla = $dbcon->execute($sql);
					$sql = $dbcon->getResultArray($sqla);
					
					/* 释放mysql 系统资源 */
					$dbcon->free_result($sqla);
	
				
					
					for($i=0;$i<count($sql);$i++){
						
						$account	= $sql[$i]['ebay_account'];
						$id			= $sql[$i]['id'];
						
						
				  ?>
                  
                  
                  
		    
 
									<tr height='20' class='oddListRowS1'>
						<td height="206" colspan="4" align='left' valign="top" scope='row' ><table width="100%" border="1" cellspacing="0" cellpadding="0">
                        
                        
                        
                          <tr>
                            <td>eBay帐号</td>
                            
                  			<?php
							
							
		
							
							 for($t=0;$t<count($ordermenuarry);$t++){
							
								
								$name			= $ordermenuarry[$t]['name'];
								

							
							
							?>
                            <td><?php echo  $name; ?></td>
                   			<?php } ?> 
                          </tr>
                          
                          <?php
						  
						  
						$ss	 = "select ebay_account from ebay_account as a  where ebay_user='$user' and ($ebayacc) ";
	
						
						$ssa	 = $dbcon->execute($ss);
						$ss	 = $dbcon->getResultArray($ssa);
						/* 释放mysql 系统资源 */
						$dbcon->free_result($ssa);
						
						for($i=0;$i<count($ss);$i++){					
					
							
							$acc	= $ss[$i]['ebay_account'];
							
						  
						  
						  ?>
                          
                          <tr>
                            <td><?php echo $acc;?></td>
                            
                            <?php
							
							
							
							 for($t=0;$t<count($ordermenuarry);$t++){
							
								
								$id				= $ordermenuarry[$t]['value'];
								$name			= $ordermenuarry[$t]['name'];
			
						
							
							?>        
                            
                            <td>
                            
                              <span style="white-space:nowrap;"><a href="orderindex.php?module=orders&ostatus=<?php echo $id;?>&action=<?php echo $name;?>&account=<?php echo $acc;?>"><span><font color="#FF0000">
                          
                            <span><font color="#FF0000"><?php
$sql	= "select count(ebay_id) as cc from ebay_order where ebay_status='$id'  and ebay_combine!='1'  and ebay_account='$acc'";


$sql	= $dbcon->execute($sql);
$sql	= $dbcon->getResultArray($sql);
echo $sql[0]['cc'];

?></font></span></td>

<?php } ?> 
                          </tr>
                          <tr>
                          
                          
                          
                          <?php
						  
						  }
						  
						  
						  ?>
                          
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          
                        </table></td>
		      </tr>
              
              
              
              <?php
			  
			  
			  }
			  $dbcon->close();
			  ?>
		<tr class='pagination'>
		<td height="220" colspan='4'>
	  <table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'></td>
					</tr>
			</table>		</td>
	</tr></table>


    <div class="clear"></div>
    <script language="javascript">

		function delaccount(id){
		if(confirm('您确认删除此条记录吗')){
			
			location.href = 'systemebay.php?type=del&id='+id+"&module=system&action=eBay帐号管理";
			
		
		}
	
	
	}
	
	
	function modaccount(id){
	
		var 	name		= document.getElementById('name'+id).value;
		var url		= 'systemebay.php?type=storeid&name='+name+"&module=system&action=eBay帐号管理&id="+id;
		
		location.href	= url;
		
	
	
	
	}
</script>