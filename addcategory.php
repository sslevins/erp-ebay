<?php
include "include/config.php";
include "top.php";	
$id		= $_REQUEST['id'];


if($_POST['submit']){

	$ebay_account		= $_POST['ebay_account'];
	$category_name		= $_POST['category_name'];
	$note				= $_POST['ebay_note'];
	$rules				= $_POST['rules'];
	if($id == ""){
	
		$sql	= "insert into ebay_messagecategory(category_name,ebay_note,ebay_user,rules,ebay_account) values('$category_name','$note','$user','$rules','$ebay_account')";
	
	}else{
	
		$sql	= "update ebay_messagecategory set category_name='$category_name',ebay_note='$note',rules='$rules',ebay_account='$ebay_account' where id='$id'";
	
	}

	

		if($dbcon->execute($sql)){
			
			$status	= " -[<font color='#33CC33'>操作记录: 记录保存成功</font>]";
			
		}else{
		
			$status = " -[<font color='#FF0000'>操作记录: 记录保存失败</font>]";
		}
		
	


}

$sql	= "select * from ebay_messagecategory  where id='$id'";
$sql	= $dbcon->execute($sql);
$sql	= $dbcon->getResultArray($sql);
$category_name	= $sql[0]['category_name'];
$note			= $sql[0]['ebay_note'];
$rules			= $sql[0]['rules'];
$ebay_account			= $sql[0]['ebay_account'];
 ?>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status;?> </h2>
</div>

<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
<table width="90%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
	
		
	<td nowrap="nowrap" scope="row" >&nbsp;<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
                      <td class="login_txt_bt">&nbsp;</td>
              </tr>
                    <tr>
                      <td valign="top" class="left_txt">

                      &nbsp;<br>
                      <form id="ad" name="ad" method="post" action="addcategory.php?id=<?php echo $id;?>&module=message&action=Message分类">
                      <input type="hidden" value="<?php echo $_REQUEST['type'];?>" name="type" />
                      
                      <table width="89%" border="0" cellpadding="0" cellspacing="0" class="login_txt">
                        <tr>
                          <td width="13%">分类名称：</td>
                          <td width="41%"><input name="category_name" type="text" id="category_name" value="<?php echo $category_name;?>"></td>
                        </tr>
                        <tr>
                          <td>分类规则：</td>
                          <td><textarea name="rules" cols="80" rows="8" id="rules" ><?php echo $rules;?></textarea>
                          &nbsp;<br />
                          每个字母或数字之前请使用英文状态下的逗号分开。</td>
                        </tr>
                        <tr>
                          <td>管理哪些帐号：</td>
                          <td><textarea name="ebay_account" cols="80" rows="8" id="ebay_account" ><?php echo $ebay_account;?></textarea>
                          <br />
                          每个eBay帐号请使用英文状态下的逗号分开</td>
                        </tr>
                        <tr>
                          <td>分类备注：</td>
                          <td><input name="ebay_note" type="text" id="ebay_note" value="<?php echo $note; ?>">
                          <input name="submit" type="submit" value="保存" id="submit" /></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                      </table>
                      </form>
                      <p>&nbsp;</p>
    <p><br>
                                          </p></td>
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