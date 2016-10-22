<?php
include "include/config.php";


include "top.php";




	

	
	$id		= $_REQUEST["id"];
	$isadd  = '';
	
	
	if($_POST['submit']){
		
			
			$password		= $_POST['password'];
			$username		= $_POST['username'];
			$record			= $_POST['record'];
			$truename		= $_POST['truename'];
			@$sale 			= $_POST['sale'];	
			$power			= implode(",",$sale);		
			
			@$message = $_POST['message'];			
			@$ebayaccounts = $_POST['ebayaccounts'];
			
			
			if($id == ""){
			
			
			$sql	= "insert into ebay_user(truename,username,password,user,power,record,message,ebayaccounts) values('$truename','$username','$password','$user','$power','$record','$message','$ebayaccounts')";
			
			$isadd = 1;
			
			}else{
			
			$sql	= "update ebay_user set truename ='$truename',username='$username',password='$password',power='$power',record='$record',message='$message',ebayaccounts ='$ebayaccounts' where id=$id";
			}
			


		
			if($dbcon->execute($sql)){
			
			if($isadd == 1) $id = mysql_insert_id();
			
			
			$status	= " -[<font color='#33CC33'>操作记录: 数据保存成功</font>]";
			
			
		}else{
		
			$status = " -[<font color='#FF0000'>操作记录: 数据保存失败</font>]";
		}
		
			
		
	}
	
	

		
		$sql = "select * from ebay_user where id=$id";
		

		
		$sql = $dbcon->execute($sql);
		$sql = $dbcon->getResultArray($sql);
		

					
		$username  	= $sql[0]['username'];
		$password 		= $sql[0]['password'];
		$power			= $sql[0]['power'];
		$record			= $sql[0]['record']?$sql[0]['record']:100;
		$po = explode(",",$power);
		$ebayaccounts			= $sql[0]['ebayaccounts'];
		$message			= $sql[0]['message'];
		$truename  = $sql[0]['truename'];
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
                      <form id="form" name="form" method="post" action="systemusersadd.php?module=system&action=用户管理">
                  <table width="81%" border="1" cellpadding="0" cellspacing="0">
                <input name="id" type="hidden" value="<?php echo $id;?>">
			      <tr>
                    <td width="41%" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right"><span style="white-space: nowrap;">用户名	 </span>:</div></td>
                    <td width="3%" align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
                    <td width="56%" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
                      <input name="username" type="text" id="username" value="<?php echo $username;?>">
                    </div></td>
                    </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right"><span style="white-space: nowrap;">密码:</span></div></td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="password" type="text" id="password" size="50" value="<?php echo $password;?>">
			        </div></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">权限设置</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">
                    
                      <div align="left">
                        <input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("orders",$po)) echo "checked" ?> value="orders" />
订单管理 
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("message",$po)) echo "checked" ?> value="message" />
消息管理 
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("customer",$po)) echo "checked" ?> value="customer" />
客户管理 <br />
<br />
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("feedback",$po)) echo "checked" ?> value="feedback" />
评价管理 
<br />
<br />
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("sales",$po)) echo "checked" ?> value="sales" />
销售分析<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("sale",$po)) echo "checked" ?> value="sale" />
业务管理
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("system",$po)) echo "checked" ?> value="system" />
系统管理 
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("dispute",$po)) echo "checked" ?> value="dispute" /> 
售后纠纷
<br />
<br />
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("kandeng",$po)) echo "checked" ?> value="kandeng" />
刊登管理
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("faxin",$po)) echo "checked" ?> value="faxin" />
订单发信管理 <input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("paypal",$po)) echo "checked" ?> value="paypal" />
paypal退款管理 
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("report",$po)) echo "checked" ?> value="report" />
统计报表<br />
                      </div></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">采购管理</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("purchase",$po)) echo "checked" ?> value="purchase" />
			          采购管理
                      <br />
                      
                      <input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("purchase_outstockorder",$po)) echo "checked" ?> value="purchase_outstockorder" />缺货订单
                      <input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("purchase_newplan",$po)) echo "checked" ?> value="purchase_newplan" />新建采购计划
                      <input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("purchase_newplanorders",$po)) echo "checked" ?> value="purchase_newplanorders" />采购计划单
                      <input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("purchase_productstockalarm",$po)) echo "checked" ?> value="purchase_productstockalarm" />智能预警
                      <input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("purchase_instocking",$po)) echo "checked" ?> value="purchase_instocking" />预订中订单
                      <input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("purchase_instock",$po)) echo "checked" ?> value="purchase_instock" />入库单订单
			          <br />
                       <input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("purchase_FinanceCheck",$po)) echo "checked" ?> value="purchase_FinanceCheck" />财务审核
                       <input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("purchase_qcorders",$po)) echo "checked" ?> value="purchase_qcorders" />质检审核
                       <input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("purchase_qcordersyc",$po)) echo "checked" ?> value="purchase_qcordersyc" />异常入库单
                       <input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("purchase_completeorders",$po)) echo "checked" ?> value="purchase_completeorders" />已完成订单
			        <br />

<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("purchase_deleteorders",$po)) echo "checked" ?> value="purchase_deleteorders" />删除采购订单

                    
                    </div></td>
			        </tr>
			      </br></br>
<tr>
<td align="right" valign="top" bgcolor="#f2f2f2" class="left_txt">库存权限</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">
			        </br>
			        <div align="left">
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("warehouse",$po)) echo "checked" ?> value="warehouse" />
库存管理
</br>			        
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("w_stockmanage",$po)) echo "checked" ?> value="w_stockmanage" />
			  仓库管理 :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("s_w_add",$po)) echo "checked" ?> value="s_w_add" />
增加
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("s_w_delete",$po)) echo "checked" ?> value="s_w_delete" />
删除 
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("s_w_modify",$po)) echo "checked" ?> value="s_w_modify" />
修改 <br />
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("w_iostore",$po)) echo "checked" ?> value="w_iostore" />
                                出入库类型:  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("s_io_add",$po)) echo "checked" ?> value="s_io_add" />
增加
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("s_io_delete",$po)) echo "checked" ?> value="s_io_delete" />
删除 
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("s_io_modify",$po)) echo "checked" ?> value="s_io_modify" />
修改 
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("s_io_audit",$po)) echo "checked" ?> value="s_io_audit" />
审核 <br />
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("w_instore",$po)) echo "checked" ?> value="w_instore" />      
                               入库单:  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("s_i_add",$po)) echo "checked" ?> value="s_i_add" />
增加
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("s_i_delete",$po)) echo "checked" ?> value="s_i_delete" />
删除 
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("s_i_modify",$po)) echo "checked" ?> value="s_i_modify" />
修改 
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("s_i_audit",$po)) echo "checked" ?> value="s_i_audit" />
审核 <br />
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("w_outstore",$po)) echo "checked" ?> value="w_outstore" />
                                出库单:  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("s_o_add",$po)) echo "checked" ?> value="s_o_add" />
增加
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("s_o_delete",$po)) echo "checked" ?> value="s_o_delete" />
删除 
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("s_o_modify",$po)) echo "checked" ?> value="s_o_modify" />
修改 
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("s_o_audit",$po)) echo "checked" ?> value="s_o_audit" />
审核 <br />
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("w_allocate",$po)) echo "checked" ?> value="w_allocate" />
                                调拨单:  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("s_aoc_add",$po)) echo "checked" ?> value="s_aoc_add" />
增加
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("s_aoc_delete",$po)) echo "checked" ?> value="s_aoc_delete" />
删除 
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("s_aoc_modify",$po)) echo "checked" ?> value="s_aoc_modify" />
修改 
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("s_aoc_audit",$po)) echo "checked" ?> value="s_aoc_audit" />
审核 <br />
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("w_goodstype",$po)) echo "checked" ?> value="w_goodstype" />
                                     货品类别管理:  &nbsp;
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("s_gt_add",$po)) echo "checked" ?> value="s_gt_add" />
增加
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("s_gt_delete",$po)) echo "checked" ?> value="s_gt_delete" />
删除 
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("s_gt_modify",$po)) echo "checked" ?> value="s_gt_modify" />
修改 
 <br />
 <input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("w_goodsmanage",$po)) echo "checked" ?> value="w_goodsmanage" />
                                       货品资料管理:  &nbsp;
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("s_gm_add",$po)) echo "checked" ?> value="s_gm_add" />
增加
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("s_gm_delete",$po)) echo "checked" ?> value="s_gm_delete" />
删除 
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("s_gm_modify",$po)) echo "checked" ?> value="s_gm_modify" />
修改 

<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("s_gm_export",$po)) echo "checked" ?> value="s_gm_export" />
货品资料导出

<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("s_gm_bexport",$po)) echo "checked" ?> value="s_gm_bexport" />
批量更新库存

<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("s_gm_sexport",$po)) echo "checked" ?> value="s_gm_sexport" />
货品库存导出

<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("s_gm_vcost",$po)) echo "checked" ?> value="s_gm_vcost" />
查看产品成本

<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("s_gm_vprice",$po)) echo "checked" ?> value="s_gm_vprice" />
查看产品售价


 <br />
 <input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("w_goodscombine",$po)) echo "checked" ?> value="w_goodscombine" />
                                        组合产品管理:  &nbsp;
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("s_gc_add",$po)) echo "checked" ?> value="s_gc_add" />
增加
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("s_gc_delete",$po)) echo "checked" ?> value="s_gc_delete" />
删除 
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("s_gc_modify",$po)) echo "checked" ?> value="s_gc_modify" />
修改 
 <br />
 <input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("w_material",$po)) echo "checked" ?> value="w_material" />
                                      包装管理:  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("s_mm_add",$po)) echo "checked" ?> value="s_mm_add" />
增加
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("s_mm_delete",$po)) echo "checked" ?> value="s_mm_delete" />
删除 
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("s_mm_modify",$po)) echo "checked" ?> value="s_mm_modify" />
修改 
 <br />

 <input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("w_mbaobiao01",$po)) echo "checked" ?> value="w_mbaobiao01" />
 进销存汇总表管理  &nbsp;<br />
                      </div></td>
</tr>
<tr>
  <td align="right" valign="top" bgcolor="#f2f2f2" class="left_txt">RMA管理</td>
  <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
  <td align="left" bgcolor="#f2f2f2" class="left_txt"><input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("rma_index",$po)) echo "checked" ?> value="rma_index" />
RMA管理
  
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("rma_del",$po)) echo "checked" ?> value="rma_del" />
删除
<input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("rma_view",$po)) echo "checked" ?> value="rma_view" /> 
查看</td>
</tr>
<tr>
  <td align="right" valign="top" bgcolor="#f2f2f2" class="left_txt">订单管理</td>
  <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
  <td align="left" bgcolor="#f2f2f2" class="left_txt"><input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("orders_warehouse",$po)) echo "checked" ?> value="orders_warehouse" />
    是否有分配库存的权限<br />
    <input name="sale[]" type="checkbox" id="sale[]" <?php if(in_array("orders_modifive",$po)) echo "checked" ?> value="orders_modifive" />
订单修改<br /></td>
</tr>			      
				   
				   <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">组</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="truename" type="text" id="truename" value="<?php echo $truename;?>" />
			          <br />
			          <br />
			        </div></td>
			        </tr>
					  
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">记录显示条数</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="record" type="text" id="record" value="<?php echo $record;?>" />
			          <br />
			          <br />
			        </div></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">Message可见帐号设置	&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><textarea name="message" cols="50" id="message"><?php echo $message;?></textarea>
账号间请用英文逗号分开</td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">订单可见帐号设置</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><textarea name="ebayaccounts" cols="50" id="ebayaccounts"><?php echo $ebayaccounts;?></textarea>
账号间请用英文逗号分开</td>
			        </tr>
			      
			      
			      
			      
                  <tr>				 
                    <td align="right" class="left_txt"><div align="right"></div></td>
                    <td align="right" class="left_txt">&nbsp;</td>
                    <td align="right" class="left_txt"><div align="left">
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
