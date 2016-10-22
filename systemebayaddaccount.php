<?php
include "include/config.php";


include "top.php";




	
	$id		= $_REQUEST['id'];
	
	
	
	$buttontitle		= '添加新的eBay帐号';
	if($id > 0 ){
	
		$vv		= "select * from ebay_account where id='$id' ";
		$vv 	= $dbcon->execute($vv);
		$vv 	= $dbcon->getResultArray($vv);
	
		$ebay_account	= $vv[0]['ebay_account'];
		$buttontitle		= '更新Token';
	
	}
	
 ?>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'];?></h2>
</div>
 
<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 <input name="hiddenuserid" type="hidden" value="" id="hiddenuserid" />
  <input name="accountid" type="hidden" value="" id="accountid" />
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
		
	<td nowrap="nowrap" scope="row" >&nbsp;</td>
	</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td width="26%">
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'>			
                    
                     <form method="post" action="systemebayaddaccount.php?id=<?php echo $id;?>">   
                    	  <table width="620" height="242" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td> <div align="right">第一步: 输入您的ebay 帐号: </div></td>
                        <td><input name="ebayaccount" type="text" id="ebayaccount" value="<?php echo $ebay_account;?>">
                      <input name="submit" type="submit" id="submit" onClick="return check()" value="<?php echo $buttontitle;?>">
                    &nbsp;</td>
                        <td>输入帐号，选择关联eBay按钮后，系统将会打印ebay的登陆连接，如果没有打开，请选择下方的红字的连接，打开，打开页后，授权成功后，在回到软件中，选择完成注册。</td>
                      </tr>
                      <tr>
                        <td><div align="right">第二步: 完成注册:</div></td>
                        <td><input name="input3" type="button" value="完成注册" onClick="com()"></td>
                        <td>&nbsp;</td>
                      </tr>
                    </table>
                    </form> 
					  <p>&nbsp;</p>
				    <p>&nbsp;</p>
				    <p>&nbsp;</p>
				    <p>&nbsp;</p></td>
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

<script>
	
	function check(){
		
		var name = document.getElementById('ebayaccount').value;
		if(name == ""){
			
			alert("请输入ebay帐号名称");
			document.getElementById('ebayaccount').focus();
			return false;
		
		}	
	}
	
	
	function com(){
		
		var sid				= document.getElementById('hiddenuserid').value;			
		var ebayaccount		= document.getElementById('ebayaccount').value;
		var url				= "systemebayaddaccountstatus.php?sessionid="+sid+"&ebayaccount="+ebayaccount+"&module=system&action=关联eBay帐号状态&id=<?php echo $id;?>";
		location.href		= url;
	
	}
	
	



</script>

<?php

	
	if($_POST['submit']){
		
		$userid		= trim($_POST['ebayaccount']);	
		$sessionid	= GetSessionID($a);
	
		$sql = "https://signin.ebay.com/ws/eBayISAPI.dll?SignIn&runame=Survy-Survyc487-9ec7--nbhygx&SessID=$sessionid";
		
		
		echo "<script>document.getElementById('hiddenuserid').value='".$sessionid."'</script>";
		echo "<script>document.getElementById('ebayaccount').value='".$userid."'</script>";
		echo "<script>window.open('".$sql."','_blank')</script>";
		
		
		echo '<font size="88px">'."<a href='".$sql."' target=_blank><h1><font color=red>如果您没有看到窗口打开，请点击此连接</font></h1></a></font>";
		
		
		
	}







include "bottom.php";



?>




