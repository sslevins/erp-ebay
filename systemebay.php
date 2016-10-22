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
		
		
		$name		= $_REQUEST['name'];
		$id				= $_REQUEST['id'];
		$sql			= "update ebay_account set appname='$name' where id='$id'";
		
		if($dbcon->execute($sql)){
			
			$status	= " -[<font color='#33CC33'>操作记录: 保存成功</font>]";
			
		}else{
		
			$status = " -[<font color='#FF0000'>操作记录: 保存成功</font>]";
		}
		
	
	
	}
	
	if($type == 'addaccount'){
		$account		= $_REQUEST['account'];
		$secret			= $_REQUEST['secret'];
		$appkey			= $_REQUEST['appkey'];
		$ss				= "insert into ebay_account(ebay_account,ebay_user,appkey,secret) values('$account','$user','$appkey','$secret')";
		
		
		echo $ss;
		if($dbcon->execute($ss)){
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
	<input tabindex='2' title='关联eBay帐号' class='button' type="button" name='button' value='关联eBay帐号' id='search_form_submit' onclick="location.href='systemebayaddaccount.php?module=system&action=关联eBay帐号'"/>
	&nbsp;<br />
	<br />
	添加SMT帐号:
	<input name="account" type="text" id="account" />
	appkey:
	<input name="appkey" type="text" id="appkey" />
	签名串:
	<input name="secret" type="text" id="secret" />
	<br />
	<br />	
	(SMT: 需要添加后面两个,如果是smt,帐号名请填写cn开头的那个帐号,添加完成后，在到下面列表中找到对应帐号选择SMT 授权)
	<input type="button" value="添加" onclick="addebayaccount()" /></td>
</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='5'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" width='2%' class='paginationActionButtons'>&nbsp;</td>
				  <td  nowrap='nowrap' width='1%' align="right" class='paginationChangeButtons'>				  </td>
				</tr>
			</table>		</td>
	</tr><tr height='20'>
					<th scope='col' width='26%' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>eBay帐号</div>			</th>
				
				<th scope='col' width='26%' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>Mail</div>			</th>
			
					<th scope='col' width='13%' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>
                                                                                        注册日期</div>			</th>
			
					<th scope='col' width='13%' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>
                                                                                       token 有效期</div>			</th>
			
					<th scope='col' width='13%' nowrap="nowrap">简称</th>
					<th scope='col' width='13%' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'> 操作 </div>			</th>
			
					</tr>
		
		  <?php 
				  
				  	$sql = "select * from ebay_account where ebay_user='$user' order by ebay_account desc ";
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
						$appname		= $sql[$i]['appname'];
						
				  ?>
                  
                  
                  
		    
 
									<tr height='20' class='oddListRowS1'>
						<td scope='row' align='left' valign="top" ><?php echo $account;?></td>
						<td scope='row' align='left' valign="top" ><?php echo $mail;?></td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $regidate; ?></td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $expirtime;?> </td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $appname;?>
						    &nbsp;</td>
						    <td scope='row' align='left' valign="top" >
                            <a href="systemebayedit.php?module=system&action=eBay帐号管理&id=<?php echo $id; ?>">修改 </a>&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="#" onclick="delaccount(<?php echo $id; ?>)">删除 </a> <br />
                            <br />
	
<a href="systemeubsetup.php?id=<?php echo $id; ?>&amp;module=system&amp;action=EUB授权设置">EUB授权设置</a><br /><br />
<a href="systemeubsetup1.php?id=<?php echo $id; ?>&amp;module=system&amp;action=线下EUB设置">线下EUB设置</a><br /><br />


                      <a href="systemsmtaddaccount.php?id=<?php echo $id; ?>&amp;module=system&amp;action=SMT授权">SMT授权</a><br /><br />      
                            
                            <a href="systemebayaddaccount.php?module=system&action=关联eBay帐号&id=<?php echo $id; ?>">更新Token</a></td>
      </tr>
              
              
              
              <?php
			  
			  
			  }
			  ?>
              
		<tr class='pagination'>
		<td height="2" colspan='5'>
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
	
	
	
	function addebayaccount(){
		
		var 	account		= document.getElementById('account').value;
		var 	appkey		= document.getElementById('appkey').value;
		var 	secret		= document.getElementById('secret').value;
		
		var url				= 'systemebay.php?type=addaccount&account='+account+"&appkey="+appkey+"&secret="+secret+"&module=system&action=eBay帐号管理";
		location.href	= url;
	
	
	}
</script>