<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #F8F9FA;
}
-->
</style>

<link href="../images/skin.css" rel="stylesheet" type="text/css" />
<?php

	include "../include/config.php";
	$type	= $_REQUEST['type'];
	if($type == "del"){
		
		$id	 = $_REQUEST['id'];
		$sql = "delete from ebay_user where id=$id";
	if($dbcon->execute($sql)){
			
			$status	= " -[<font color='#33CC33'>操作记录: 记录删除成功</font>]";
			
		}else{
		
			$status = " -[<font color='#FF0000'>操作记录: 记录删除失败</font>]";
		}
		
		
		
	
	}else{
		
		$status = "";
		
	}






	
	
 ?>


<script language="javascript" type="text/javascript" src="../My97DatePicker/WdatePicker.js"></script>
<style type="text/css">
<!--
.STYLE1 {color: #CCCCCC}
-->
</style>
<body>
<input name="ostatus" type="hidden" value="<?php echo $ostatus;?>" id="ostatus" />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="17" height="29" valign="top" background="../images/mail_leftbg.gif"><img src="../images/left-top-right.gif" width="17" height="29" /></td>
    <td width="1138" height="29" valign="top" background="../images/content-bg.gif"><table width="100%" height="31" border="0" cellpadding="0" cellspacing="0" class="left_topbg" id="table2">
      <tr>
        <td height="31"><div class="titlebt"><?php echo $status0;?></div></td>
      </tr>
    </table></td>
    <td width="21" valign="top" background="../images/mail_rightbg.gif"><img src="../images/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>
  <tr>
    <td height="71" valign="middle" background="../images/mail_leftbg.gif">&nbsp;</td>
    <td valign="top" bgcolor="#F7F8F9"><table width="100%" height="138" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="13" valign="top"><input tabindex='2' class='button' type="button" name='button' value='添加用户' id='search_form_submit' onClick="location.href='systemusersadd.php?module=system&action=添加用户'"/>
          <br>
<?php echo $status0;?>
</td>
      </tr>
      <tr>
        <td valign="top"><table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" bordercolor="#999999" bgcolor="#CCCCCC">
          <tr>
            <td bgcolor="#eeeeee" class="left_txt">编号</td>
            <td bgcolor="#eeeeee" class="left_txt"><span style="white-space: nowrap;">用户名</span></td>
            <td bgcolor="#eeeeee" class="left_txt"><span style="white-space: nowrap;">密码</span></td>
            <td bgcolor="#eeeeee" class="left_txt">操作</td>
            </tr>
      
			    <?php 
				  
				  	$sql = "select * from ebay_user where user='$user'";
			
					
					$sql = $dbcon->execute($sql);
					$sql = $dbcon->getResultArray($sql);
			
					
					for($i=0;$i<count($sql);$i++){
						
						$username 	= $sql[$i]['username'];
						$password		= $sql[$i]['password'];						
						$id			= $sql[$i]['id'];
						
						
				  ?>
                  
          <tr>
            <td bgcolor="#FFFFFF" class="left_txt"><?php echo $i+1;?>&nbsp;</td>
            <td bgcolor="#FFFFFF" class="left_txt"><?php echo $username; ?></td>
            <td bgcolor="#FFFFFF" class="left_txt">***</td>
            <td bgcolor="#FFFFFF" class="left_txt"><a href="s_usersadd.php?id=<?php echo $id; ?>&module=system&action=汇率设置">修改</a> <a href="#" onClick="del(<?php echo $id; ?>)">删除</a>&nbsp;</td>
            </tr>

          
          <?php 
		  }
          ?>

          <tr>
            <td colspan="4" bgcolor="#FFFFFF" class="left_txt"><div align="left"><br />

			
            &nbsp;</div></td>
          </tr>
      </table>
          </td>
      </tr>
    </table></td>
    <td background="../images/mail_rightbg.gif">&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle" background="../images/mail_leftbg.gif"><img src="../images/buttom_left2.gif" width="17" height="17" /></td>
      <td height="17" valign="top" background="../images/buttom_bgs.gif"><img src="../images/buttom_bgs.gif" width="17" height="17" /></td>
    <td background="../images/mail_rightbg.gif"><img src="../images/buttom_right2.gif" width="16" height="17" /></td>
  </tr>
</table>

</body>
<script language="javascript">
	
	function del(id){
		if(confirm('您确认删除此条记录吗')){
			
			location.href = 's_users.php?type=del&id='+id+"&module=system";
			
		
		}
	
	
	}



</script>