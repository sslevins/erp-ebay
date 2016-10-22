<?php
include "include/config.php";
include "top.php";


error_reporting(0);

if($_POST['submit']){

	
	$start		= $_POST['start'].'T00:00:00.000Z';
	$end		= $_POST['end'].'T23:59:59.000Z';
	$account	= $_POST['account'];
	
	$ss			= "select * from ebay_account where ebay_user='$user' and ebay_account ='$account'";
	$ss			= $dbcon->execute($ss);
	$ss			= $dbcon->getResultArray($ss);
	$token		= $ss[0]['ebay_token'];
	//GetMyeBaySelling($account,$token);
	GetSellerList($account,$token,$start,$end);
}
	
	$type		= $_REQUEST['type'];
	$account	= $_REQUEST['account'];
	
	

	if($type =='load'){
	
	
		$ss			= "select * from ebay_account where ebay_user='$user' and ebay_account ='$account'";
		$ss			= $dbcon->execute($ss);
		$ss			= $dbcon->getResultArray($ss);
		$token		= $ss[0]['ebay_token'];
		GetMyeBaySelling($account,$token);
	}
	



	

 ?>
 <link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/yui.css" />

<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/deprecated.css" />
 <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>

<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/style.css" /> 
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr>
          <td><div class='listViewBody'>
            <div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
  <div id='Accountssaved_viewsSearchForm' style='display: none';></div>
  </form>
            
  <table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
    <tr class='pagination'>
      <td width="26%">
        <table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
          <tr>
            <td nowrap="nowrap" class='paginationActionButtons'>			
              
              <form method="post" action="listingimportproducts.php">   
                <table width="100%" height="84" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td colspan="2">01. 按产品的刊登时间同步:</td>
                    </tr>
                  <tr>
                    <td> <div align="right">选择帐号: </div></td>
                          <td><select name="account" id="account">
                            <?php 
					
					$sql	 = "select * from ebay_account as a  where ebay_user='$user' and ($ebayacc)";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 
					 	$account	= $sql[$i]['ebay_account'];
					 ?>
                            <option value="<?php echo $account;?>"><?php echo $account;?></option>
                            <?php } ?>
                          </select>
                            &nbsp;</td>
                    </tr>
                  <tr>
                    <td align="right">商品刊登开始时间</td>
                    <td><div align="left">
                      <input name="start" id="start" type="text" onclick="WdatePicker()" value="<?php echo $start0;?>" />
                    </div></td>
                  </tr>
                  <tr>
                    <td align="right">商品刊登结束时间</td>
                    <td><input name="end" id="end" type="text" onClick="WdatePicker()" value="<?php echo $start1;?>" />
Each of the time ranges must be a value less than 120 days. </td>
                  </tr>
                  <tr>
                    <td align="right">&nbsp;</td>
                    <td><input name="submit" type="submit" id="submit" onClick="return check()" value="导入eBay在线商品"></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="right"><div align="left">02. 一键导入所有在线物品</div></td>
                    </tr>
                  <tr>
                    <td colspan="2" align="right"><div align="left">
                      <input name="submit2" type="button" id="button" onclick="check02()" value="导入eBay在线商品" />
                    </div></td>
                    </tr>
                  <tr>
                    <td colspan="2" align="right">&nbsp;</td>
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
		
		var name = document.getElementById('account').value;
		if(name == ""){
			
			alert("请输入ebay帐号名称");
			document.getElementById('account').focus();
			return false;
		
		}
		
		var start = document.getElementById('start').value;
		var end = document.getElementById('end').value;
		
		
		if(start == ""){
			alert("请选择开始时间");
			document.getElementById('start').focus();
			return false;
		}
		
		
		if(end == ""){
			alert("请选择结束时间");
			document.getElementById('end').focus();
			return false;
		}
		
		
	}
	
	function check02(){
	
		
		var name 	= document.getElementById('account').value;
		var url		= "listingimportproducts.php?module=list&type=load&account="+name;
		location.href	= url;
			
	
	}
	



</script>
            
  <?php

	







include "bottom.php";



?>
            
            
            
            
