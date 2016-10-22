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
	
	if($type == "storeid"){
		
		
		$storeid		= $_REQUEST['storeid'];
		$id				= $_REQUEST['id'];
		$sql			= "update ebay_account set storeid='$storeid' where id='$id'";
		
		if($dbcon->execute($sql)){
			
			$status	= " -[<font color='#33CC33'>操作记录: 保存成功</font>]";
			
		}else{
		
			$status = " -[<font color='#FF0000'>操作记录: 保存成功</font>]";
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
	<input tabindex='2' title='关联eBay帐号' class='button' type="button" name='button' value='关联eBay帐号' id='search_form_submit' onclick="location.href='systemebayaddaccount.php?module=system&action=关联eBay帐号'"/>&nbsp;</td>
	</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='4'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" width='2%' class='paginationActionButtons'>&nbsp;</td>
				  <td  nowrap='nowrap' width='1%' align="right" class='paginationChangeButtons'>				  </td>
				</tr>
			</table>		</td>
	</tr><tr height='20'>
					<th scope='col' width='26%' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>eBay帐号</div>			</th>
			
					<th scope='col' width='13%' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>
                                                                                        注册日期</div>			</th>
			
					<th scope='col' width='13%' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>
                                                                                       token 有效期</div>			</th>
			
					<th scope='col' width='13%' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'> 操作 </div>			</th>
			
					</tr>
		
		  <?php 
				  
				  	$sql = "select * from ebay_account where ebay_user='$user'";
					$sql = $dbcon->execute($sql);
					$sql = $dbcon->getResultArray($sql);
				
					
					for($i=0;$i<count($sql);$i++){
						
						$account	= $sql[$i]['ebay_account'];
						$regidate	= $sql[$i]['ebay_addtime'];
						$expirtime	= $sql[$i]['ebay_expirtime'];
						$id			= $sql[$i]['id'];
						
						$appname	= $sql[$i]['appname'];
						$mail		= $sql[$i]['mail'];
						$storeid		= $sql[$i]['storeid'];
						
						
				  ?>
                  
                  
                  
		    
 
									<tr height='20' class='oddListRowS1'>
						<td scope='row' align='left' valign="top" ><?php echo $account;?></td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $regidate; ?></td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $expirtime;?> </td>
				
						    <td scope='row' align='left' valign="top" ><a href="#" onclick="delaccount(<?php echo $id; ?>)">删除 </a>
                            <a href="systemeubsetup.php?id=<?php echo $id; ?>&module=system&action=EUB授权设置">EUB授权设置</a>
                            
                            </td>
              </tr>
              
              
              
              <?php
			  
			  
			  }
			  ?>
              
		<tr class='pagination'>
		<td height="2" colspan='4'>
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

		function delaccount(id){
		if(confirm('您确认删除此条记录吗')){
			
			location.href = 'systemebay.php?type=del&id='+id+"&module=system&action=eBay帐号管理";
			
		
		}
	
	
	}
	
	
	function ce(id){
	
		var 	storeid		= document.getElementById('in_warehouse'+id).value;
		if(storeid	== -1){ alert('请选择要设置的仓库');return false;}
		var url		= 'systemebay.php?type=storeid&id='+id+"&module=system&action=eBay帐号管理&storeid="+storeid;
		
		location.href	= url;
		
	
	
	
	}
</script>