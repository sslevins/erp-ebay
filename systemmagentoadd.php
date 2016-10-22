<?php

include "include/config.php";





include "top.php";









	



	

	$id		= $_REQUEST["id"];



	

	if($_POST['submit']){

		

			

			$zen_name						= $_POST['zen_name'];

			$zen_server						= $_POST['zen_server'];

			$zen_username					= $_POST['zen_username'];

			$zen_password					= $_POST['zen_password'];

			$zen_dh					= $_POST['zen_dh'];

			$zen_database					= $_POST['zen_database'];

			

			$zen_tablename						= $_POST['zen_tablename'];

			$zen_loadingstatus					= $_POST['zen_loadingstatus'];

			$zen_marketstatus					= $_POST['zen_marketstatus'];

			$orderstatus					= $_POST['orderstatus'];

			if($id == ""){

			

			

			$sql	= "insert into ebay_magento(zen_name,zen_server,zen_username,zen_password,user,zen_database,zen_tablename,zen_loadingstatus,zen_marketstatus,zen_dh,orderstatus) values('$zen_name','$zen_server','$zen_username','$zen_password','$user','$zen_database','$zen_tablename','$zen_loadingstatus','$zen_marketstatus','$zen_dh','$orderstatus')";

			}else{

			

			$sql	= "update ebay_magento set zen_name='$zen_name',zen_server='$zen_server',zen_password='$zen_password',zen_database='$zen_database',zen_tablename='$zen_tablename',zen_loadingstatus='$zen_loadingstatus',zen_marketstatus='$zen_marketstatus',zen_dh='$zen_dh',orderstatus='$orderstatus',zen_username='$zen_username' where id=$id";

			}

			

			if($dbcon->execute($sql)){

			

			$status	= " -[<font color='#33CC33'>操作记录: 帐号添加成功</font>]";

			

		}else{

		

			$status = " -[<font color='#FF0000'>操作记录: 帐号添加失败</font>]";

		}

		

			

		

	}

	

	

		if($id	!= ""){

	

		

		$sql = "select * from ebay_magento where id=$id";

		$sql = $dbcon->execute($sql);

		$sql = $dbcon->getResultArray($sql);

					$orderstatus			= $sql[0]['orderstatus'];

		$zen_name			= $sql[0]['zen_name'];

		$zen_server			= $sql[0]['zen_server'];

		$zen_username		= $sql[0]['zen_username'];

		$zen_password		= $sql[0]['zen_password'];

		$zen_database		= $sql[0]['zen_database'];

		$zen_tablename		= $sql[0]['zen_tablename'];

		$zen_loadingstatus	= $sql[0]['zen_loadingstatus'];

		$zen_tablename		= $sql[0]['zen_tablename'];

		$zen_dh		= $sql[0]['zen_dh'];

		$zen_marketstatus		= $sql[0]['zen_marketstatus'];

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

                      <form id="form" name="form" method="post" action="systemmagentoadd.php?module=system&action=Zendcart帐号添加&id=<?php echo $id;?>">

                  <table width="70%" height="330" border="0" cellpadding="0" cellspacing="0">

                <input name="id" type="hidden" value="<?php echo $id;?>">

			      <tr>

                    <td width="41%" height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right">网店名称</div></td>

                    <td width="3%" align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>

                    <td width="56%" height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">

                      <input name="zen_name" type="text" id="zen_name" value="<?php echo $zen_name;?>" />

                    </div></td>

                    </tr>

			      <tr>

			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right">数据库服务器地址</div></td>

			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>

			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">

			          <input name="zen_server" type="text" id="zen_server" size="50" value="<?php echo $zen_server;?>">

			        </div></td>

			        </tr>

			      <tr>

			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right">数据库用户名</div></td>

			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>

			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">

			          <input name="zen_username" type="text" id="zen_username" size="50" value="<?php echo $zen_username;?>">

			        </div></td>

			        </tr>

			      <tr>

			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right">数据库密码</div></td>

			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>

			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">

			          <input name="zen_password" type="text" id="zen_password" size="70" value="<?php echo $zen_password;?>">

			        </div></td>

			        </tr>

			      <tr>

			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">数据库名</td>

			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>

			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">

			          <input name="zen_database" type="text" id="zen_database" size="70" value="<?php echo $zen_database;?>" />

			          </div></td>

			        </tr>

			      <tr>

			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">数据库前缀</td>

			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>

			        <td height="30" align="left" bgcolor="#f2f2f2" class="left_txt"><input name="zen_tablename" type="text" id="zen_tablename" value="<?php echo $zen_tablename;?>" />

			          没有前缀，写空</td>

			        </tr>

			      <tr>

			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">同步订单状态</td>

			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>

			        <td height="30" align="left" bgcolor="#f2f2f2" class="left_txt"><textarea name="zen_loadingstatus" cols="100" id="zen_loadingstatus"><?php echo $zen_loadingstatus;?></textarea>

			          <br />

			          每个帐号之间,请用逗号分开</td>

			        </tr>

			      <tr>

			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">标记发出状态:</td>

			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>

			        <td height="30" align="left" bgcolor="#f2f2f2" class="left_txt"><input name="zen_marketstatus" type="text" id="zen_marketstatus" value="<?php echo $zen_marketstatus;?>" /></td>

			        </tr>

			      <tr>

			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">订单代号</td>

			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>

			        <td height="30" align="left" bgcolor="#f2f2f2" class="left_txt"><input name="zen_dh" type="text" id="zen_dh" value="<?php echo $zen_dh;?>" /></td>

			        </tr>

			      <tr>

			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">订单类型</td>

			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>

			        <td height="30" align="left" bgcolor="#f2f2f2" class="left_txt"><select name="orderstatus" id="orderstatus">

                      <option value="-1" <?php if($oost == "-1") echo "selected=selected" ?>>请选择</option>

                      <?php if($_REQUEST['module'] =='zencart'){ ?>

                      <option value="1" <?php  if($oost == "1")  echo "selected=selected" ?>>ZenCart未处理</option>

                      <option value="2" <?php  if($oost == "2")  echo "selected=selected" ?>>ZenCart已处理</option>

                      <option value="3" <?php  if($oost == "3")  echo "selected=selected" ?>>ZEN-CART待MARK SHIP</option>

                      <option value="4" <?php  if($oost == "4")  echo "selected=selected" ?>>ZenCart退款订单</option>

                      <option value="5" <?php  if($oost == "5")  echo "selected=selected" ?>>ZenCart取消订单</option>

                      <option value="6" <?php  if($oost == "6")  echo "selected=selected" ?>>ZenCart缺货订单</option>

                      <option value="7" <?php  if($oost == "7")  echo "selected=selected" ?>>ZenCart待打印订单</option>

                      <option value="8" <?php  if($oost == "8")  echo "selected=selected" ?>>ZenCart已打印订单</option>

                      <?php }else{ ?>

                      <?php

                            $ss		= "select * from ebay_ordertype where ebay_user='$user' ";

							$ss		= $dbcon->execute($ss);

							$ss		= $dbcon->getResultArray($ss);

							for($i=0;$i<count($ss);$i++){

								$ssid		= $ss[$i]['id'];

								$typename		= $ss[$i]['typename'];

							?>

                      <option value="<?php echo $typename; ?>" <?php  if($orderstatus == $typename)  echo "selected=selected" ?>><?php echo $typename; ?></option>

                      <?php } ?>

                      <?php } ?>

                    </select></td>

			        </tr>

			      

			      

                  <tr>				 

                    <td height="30" align="right" class="left_txt"><div align="right"></div></td>

                    <td align="right" class="left_txt">&nbsp;</td>

                    <td height="30" align="right" class="left_txt"><div align="left">

                      <input name="submit" type="submit" value="保存数据" onClick="return check()">

                    </div></td>

                    </tr>

                </table>

                 </form> 

               </td>

               

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

