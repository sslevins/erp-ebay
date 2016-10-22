<?php
include "include/config.php";
include "top.php";	
	/* 修改客户地址 */
	$id	= $_REQUEST['id'];

	if($_POST['ad']){
	
		$company_name 		= str_rep($_POST['company_name']);
		$username			= str_rep($_POST['username']);
		$tel				= str_rep($_POST['tel']);
		$mobile				= str_rep($_POST['mobile']);
		$fax				= str_rep($_POST['fax']);
		$mail				= str_rep($_POST['mail']);
		$address			= str_rep($_POST['address']);
		$note				= str_rep($_POST['note']);
		$city				= str_rep($_POST['city']);
		$code				= str_rep($_POST['code']);
		$QQ				= str_rep($_POST['QQ']);
		$url							= str_rep($_POST['url']);
		$bankaccountaddress				= str_rep($_POST['bankaccountaddress']);
		$bankaccountname				= str_rep($_POST['bankaccountname']);
		$bankaccountnumber				= str_rep($_POST['bankaccountnumber']);
		
		
		if($company_name != ''){
		
		if($id == ""){
				$sql	= "insert into ebay_partner(company_name,username,tel,mobile,fax,mail,address,note,ebay_user,city,code,url,bankaccountaddress,bankaccountname,bankaccountnumber,QQ) values('$company_name','$username','$tel','$mobile','$fax','$mail','$address','$note','$user','$city','$code','$url','$bankaccountaddress','$bankaccountname','$bankaccountnumber','$QQ')";
		}else{
				$sql	= "update ebay_partner set city='$city',company_name='$company_name',username='$username',code='$code',tel='$tel',mobile='$mobile',fax='$fax',mail='$mail',address='$address',note='$note',bankaccountnumber='$bankaccountnumber',bankaccountname ='$bankaccountname',bankaccountnumber='$bankaccountnumber',url='$url',bankaccountaddress='$bankaccountaddress',QQ='$QQ' where id='$id'";
		}
	
		
		
	
			if($dbcon->execute($sql)){
				$status	= " -[<font color='#33CC33'>操作记录: 保存成功</font>]";
			}else{
				$status = " -[<font color='#FF0000'>操作记录: 保存失败</font>]";
			}
			
			if($id == '' ) $id = mysql_insert_id();
			
		}else{
		
		
			$status = " -[<font color='#FF0000'>操作记录: 保存失败</font>]";
		}
		
	
	}
	
	
	
	
	
	
	$sql		= "select * from ebay_partner where id='$id'";

	
	$sql		= $dbcon->execute($sql);
	$sql		= $dbcon->getResultArray($sql);

	


 ?>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status;?> </h2>
</div>


 
 
<table width="90%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
	
		
	<td nowrap="nowrap" scope="row" >&nbsp;<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
                      <td class="login_txt_bt">&nbsp;</td>
              </tr>
                    <tr>
                      <td valign="top" class="left_txt">
                      <?php
					  	
						   $company_name		= $sql[0]['company_name'];
						   $username		= @$sql[0]['username'];
						    $tel		= @$sql[0]['tel'];
							 $mobile		= @$sql[0]['mobile'];
							  $fax		= @$sql[0]['fax'];
							   $mail		= @$sql[0]['mail'];
							    $address		= @$sql[0]['address'];
								 $note		= @$sql[0]['note'];
						  $city		= @$sql[0]['city'];
							$code				= @$sql[0]['code'];
						    $QQ		= @$sql[0]['QQ'];
						   $url						= @$sql[0]['url'];
						   $bankaccountaddress		= @$sql[0]['bankaccountaddress'];
						   $bankaccountname			= @$sql[0]['bankaccountname'];
						   $bankaccountnumber		= @$sql[0]['bankaccountnumber'];
					  ?>
                      &nbsp;<br>
                      <form id="ad" name="ad" method="post" action="partneradd.php?id=<?php echo $id;?>&module=purchase&action=供应商管理">
                      <input type="hidden" value="<?php echo $_REQUEST['type'];?>" name="type" />
                      
                      <table width="89%" border="1" cellpadding="0" cellspacing="0" class="login_txt">
                        <tr>
                          <td width="13%">单位名称</td>
                          <td width="41%"><input name="company_name" type="text" id="company_name" value="<?php echo $company_name;?>">
                          (必填)</td>
                          <td width="8%">供应商代码</td>
                          <td width="38%"><input name="code" type="text" id="code" value="<?php echo $code; ?>" /></td>
                        </tr>
                        <tr>
                          <td>姓名</td>
                          <td><input name="username" type="text" id="username" value="<?php echo $username; ?>"></td>
                          <td>电话</td>
                          <td><input name="tel" type="text" id="tel" value="<?php echo $tel; ?>"></td>
                        </tr>
                        <tr>
                          <td>移动电话</td>
                          <td><input name="mobile" type="text" id="mobile" value="<?php echo $mobile; ?>"></td>
                          <td>传真</td>
                          <td><input name="fax" type="text" id="fax" value="<?php echo $fax; ?>"></td>
                        </tr>
                        <tr>
                          <td>邮件</td> 
                          <td><input name="mail" type="text" id="mail" value="<?php echo $mail;?>"></td>
                          <td>客户地址</td>
                          <td><input name="address" type="text" id="address" value="<?php echo $address; ?>"></td>
                        </tr>
                        <tr>
                          <td>所属城市 </td>
                          <td><input name="city" type="text" id="city" value="<?php echo $city; ?>" /></td>
                          <td>QQ：</td>
                          <td><input name="QQ" type="text" id="QQ" value="<?php echo $QQ; ?>" /></td>
                        </tr>
                        <tr>
                          <td>网址：</td>
                          <td><input name="url" type="text" id="url" style="width:300px"  value="<?php echo $url; ?>" /></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td><p >开户行：</p></td>
                          <td><input name="bankaccountaddress" type="text" id="bankaccountaddress"  style="width:300px" value="<?php echo $bankaccountaddress; ?>" /></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td><p >开户名：</p></td>
                          <td><input name="bankaccountname" type="text" id="bankaccountname" style="width:300px" value="<?php echo $bankaccountname; ?>" /></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td><p >账号：</p></td>
                          <td><input name="bankaccountnumber" type="text" id="bankaccountnumber" style="width:300px"  value="<?php echo $bankaccountnumber; ?>" /></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>备注</td>
                          <td colspan="3"><textarea name="note" cols="100" rows="8" id="note"><?php echo $note;?></textarea></td>
                        </tr>
                        
                        <tr>
                          <td><input name="ad" type="submit" value="保存" id="address"></td>
                          <td colspan="3">&nbsp;</td>
                        </tr>
                      </table>
                      </form>
                      <p>&nbsp;</p>
    <p><br>
                                          </p></td>
                    </tr>
                    <tr>
                      <td class="login_txt_bt">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="left_txt">&nbsp;</td>
                    </tr>
          </table></td>
	</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td width="65%">&nbsp;</td>
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
<?php

include "bottom.php";


?>
<script language="javascript">
	
	function del(ordersn,ebayid){
	
	
		
		if(confirm("确认删除此条记录吗")){
			
			location.href="ordermodifive.php?ordersn=<?php echo $ordersn ?>&ebayid=<?php echo $ebayid;?>&type=del&module=orders&action=新增订单";
			
		
		
		}
		
	
	
	}
	
	function mod(ordersn,ebayid){
	
		
		
		
		if(confirm("确认修改此条记录吗")){
			
			
			var pname	 = document.getElementById('pname'+ebayid).value;
			var pprice	 = document.getElementById('pprice'+ebayid).value;
			var pqty	 = document.getElementById('pqty'+ebayid).value;
			var psku	 = document.getElementById('psku'+ebayid).value;
			var pitemid	 = document.getElementById('pitemid'+ebayid).value;
			
			
			if(isNaN(pqty)){
				
				alert("数量只能输入数字");
				
			
			}else if(isNaN(pprice)){
				
				alert("价格只能输入数字");
			
			}else{
			
				location.href="ordermodifive.php?ordersn=<?php echo $ordersn ?>&ebayid="+ebayid+"&type=mod&pname="+encodeURIComponent(pname)+"&pprice="+pprice+"&pqty="+pqty+"&psku="+psku+"&pitemid="+pitemid+"&module=orders&action="+urlencode(新增订单);
			
			}
					
		}
		
	}
	
	function add(ordersn){
	
		
		var tname		= document.getElementById('tname').value;
		var tprice		= document.getElementById('tprice').value;
		var tqty		= document.getElementById('tqty').value;
		var tsku		= document.getElementById('tsku').value;
		var titemid		= document.getElementById('titemid').value;
		
		if(tname == ""){
		
				
				alert("请输入产品名称");
				document.getElementById('tname').select();
				return false;
				
		}
		
		if(isNaN(tprice) || tprice == ""){
				
				alert("数量只能输入数字");
				document.getElementById('tprice').select();
				return false;		
				
			
		}
		
		if(isNaN(tqty)){
				
				alert("价格只能输入数字");
				document.getElementById('tqty').select();
				return false;
			
		}			
		location.href="ordermodifive.php?ordersn=<?php echo $ordersn ?>&type=add&tname="+encodeURIComponent(tname)+"&tprice="+tprice+"&tqty="+tqty+"&tsku="+tsku+"&titemid="+titemid+"&module=orders&action=新增订单";
			
	}
	


</script>