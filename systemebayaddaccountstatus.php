<?php
include "include/config.php";


include "top.php";



$sessionid	= $_REQUEST['sessionid'];
$id			= $_REQUEST['id'];
$result		= GetToken($sessionid,$id);

 ?>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'];?></h2>
</div>
 
<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
		
	<td nowrap="nowrap" scope="row" >
	<input tabindex='2' title='关联eBay帐号' class='button' type="button" name='button' value='Search' id='search_form_submit'/>&nbsp;</td>
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
                    
                     <form method="post" action="systemebayaddaccount.php">   
                    	  <table width="317" height="84" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td colspan="2"><table width="62%" height="99" border="0" cellpadding="0" cellspacing="0">
			    <form method="post" action="addaccount.php">   
			      <tr>
                    <td width="41%" height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right">信息状态:</div></td>
                    <td width="3%" align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
                    <td width="56%" height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left"><?php echo $result['status']; ?></div></td>
                    </tr>
			      <tr>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">同步有效期:</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left"><?php echo $result['expirtime']; ?></div></td>
			        </tr>
                  <tr>
				 </form> 
                    <td height="30" align="right" class="left_txt"><div align="right"></div></td>
                    <td align="right" class="left_txt">&nbsp;</td>
                    <td height="30" align="right" class="left_txt"><div align="left">
                      
                    </div></td>
                    </tr>
				<tr>
				  <td height="30" colspan="3" nowrap="nowrap" class='paginationActionButtons'>帐号帮定成功后，您需要到系统管理 -&gt; 用户管理 -&gt; 修改，设置帐号管理权限，否则将会看不到任何信息。
				  <td height="30" align="right" class="left_txt">&nbsp;</td>
			  </tr>       
          </table></td>
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
		var url				= "systemebayaddaccount.php?sessionid="+sid+"&ebayaccount="+ebayaccount;
		location.href		= url;
	
	}

</script>

<?php

	
	if($_POST['submit']){
		
		$userid		= $_POST['ebayaccount'];	
		$sessionid	= GetSessionID($a);
	
	
		$sql = "https://signin.ebay.com/ws/eBayISAPI.dll?SignIn&runame=willmiss-willmiss-24c3-4-oulfrv&SessID=$sessionid";
		
		
		echo "<script>document.getElementById('hiddenuserid').value='".$sessionid."'</script>";
		echo "<script>document.getElementById('ebayaccount').value='".$userid."'</script>";
		echo "<script>window.open('".$sql."','_blank')</script>";
		
		
		echo "<a href='".$sql."' target=_blank><font color=red>如果您没有看到窗口打开，请点击此连接</font></a>";
		
		
		
	}







include "bottom.php";



?>




