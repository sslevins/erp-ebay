<?php
include "include/config.php";


include "top.php";




	
	
	if($_POST['submit']){
		
		$pass		 = $_POST['pass1'];
		
		$sql		 = "UPDATE `ebay_user` SET password='$pass' WHERE `username` ='$truename' LIMIT 1";
		if($dbcon->execute($sql)){
			$status	= " -[<font color='#33CC33'>操作记录: 密码修改成功</font>]";
		}else{
			$status = " -[<font color='#FF0000'>操作记录: 密码修改失败</font>]";
		}
	}
	



 ?>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status;?></h2>
</div>
 
<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 <input name="hiddenuserid" type="hidden" value="" id="hiddenuserid" />
 
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
                      <form id="form" name="form" method="post" action="systemuserpass.php?module=system&action=密码修改">
                  <table width="52%" border="0" align="center" cellspacing="0" class="left_txt">
                    <tr>
                      <td>输入新密码:</td>
                      <td><input name="pass1" type="text" id="pass1" value="<?php echo $mail;?>">
&nbsp;</td>
                    </tr>
                    <tr>
                      <td>再次输入新密码:</td>
                      <td><input name="pass2" type="text" id="pass2" value=<?php echo $tel;?>>
&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2"><input name="submit" type="submit" value="提交" onClick="return check()">
                        &nbsp;</td>
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

<script language="javascript">
	
	function check(){
	
		var pas1	= document.getElementById('pass1').value;
		var pas2	= document.getElementById('pass2').value;
		
		if(pas1 == "" || pas2 == ""){
		
			alert('请输入密码');
			return false;
		}
		
		if(pas1 != pas2){
			
			alert('两次输入法的密码不一至');
			return false;
		
		}
	
	}



</script>
