<?php
include "include/config.php";


include "top.php";



	
	$id		= $_REQUEST['id'];
	
	
	
	
	
		$vv		= "select * from ebay_account where id='$id' ";
		$vv 	= $dbcon->execute($vv);
		$vv 	= $dbcon->getResultArray($vv);
		
		$appKey   		= $vv[0]['appkey'];
		$appSecret  	= $vv[0]['secret'];
		$ebay_account   = $vv[0]['ebay_account'];
		
		
		
			$redirectUrl	=	"xxx";
			$callback_url	=	"http://120.24.65.152/callback.php?id=".$ebay_account;
			$getTokenUrl1	=	"https://gw.api.alibaba.com/openapi/http/1/system.oauth2/getToken/".$appKey;
			$getTokenUrl2	=	"https://gw.api.alibaba.com/openapi/param2/1/system.oauth2/refreshToken/".$appKey;
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
                    
                     <form method="post" action="systemsmtaddaccount.php?id=<?php echo $id;?>">   
                    	  <table width="620" height="242" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td> <div align="right">第一步: 输入您的速卖通 帐号: </div></td>
                        <td><input name="ebayaccount" type="text" id="ebayaccount" value="<?php echo $ebay_account;?>">
                      <input name="submit" type="submit" id="submit" onClick="return check()" value="登陆帐号">
                    &nbsp;</td>
                        <td>输入帐号，选择关联速卖通按钮后，系统将会打印速卖通的登陆连接，如果没有打开，请选择下方的红字的连接.</td>
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
	
	
	
	



</script>

<?php

	
	if($_POST['submit']){
		
		
		
		
		echo 'dfdfdfdf';
		
		$getCodeUrl		=	"https://gw.api.alibaba.com/auth/authorize.htm?client_id=".$appKey ."&site=aliexpress&redirect_uri=".$callback_url."&_aop_signature=".Sign(array('client_id' => $appKey,'redirect_uri' =>$callback_url,'site' => 'aliexpress'),$appSecret);
		
		
		echo $getCodeUrl;
		
		echo '<font size="88px">'."<a href='".$getCodeUrl."' target=_blank><h1><font color=red>如果您没有看到窗口打开，请点击此连接</font></h1></a></font>";
		
		
		echo 'cccc';
		
		
	}
	
	
	function Sign($vars, $appSecret){
	$str='';
	ksort($vars);
	foreach($vars as $k=>$v){
		$str.=$k.$v;
	}
	return strtoupper(bin2hex(hash_hmac('sha1',$str,$appSecret,true)));
}







include "bottom.php";



?>




