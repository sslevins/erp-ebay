<?php
include "include/config.php";


include "top.php";


	
	$shippingid				= $_REQUEST['shippingid'];
	
	
	
	$id						= $_REQUEST['id'];
	
	if($_POST['submit']){
	
		
		$name						= $_POST['name'];
		$aweightstart				= $_POST['aweightstart'];
		$aweightend					= $_POST['aweightend'];
		$ahandlefee					= $_POST['ahandlefee'];
		$acountrys					= $_POST['acountrys'];
		$type						= $_POST['type'];
		$ashipfee					= $_POST['ashipfee'];
		$bfirstweight				= $_POST['bfirstweight'];
		$bnextweight				= $_POST['bnextweight'];
		$bfirstweightamount			= $_POST['bfirstweightamount'];
		$bnextweightamount			= $_POST['bnextweightamount'];
		$bhandlefee					= $_POST['bhandlefee'];
		$bdiscount					= $_POST['bdiscount'];
		$bcountrys					= $_POST['bcountrys'];
		$adiscount					= $_POST['adiscount'];
		$ahandelfee2				= $_POST['ahandelfee2'];
		if($id == ''){
		$sql						= "insert into ebay_systemshipfee(type,aweightstart,aweightend,ahandlefee,acountrys,bfirstweight,bnextweight,bfirstweightamount,bnextweightamount,bhandlefee,bdiscount,bcountrys,name,shippingid,ashipfee,adiscount,ahandelfee2) values('$type','$aweightstart','$aweightend','$ahandlefee','$acountrys','$bfirstweight','$bnextweight','$bfirstweightamount','$bnextweightamount','$bhandlefee','$bdiscount','$bcountrys','$name','$shippingid','$ashipfee','$adiscount','$ahandelfee2')";
		
		}else{
		
		
		$sql		= "update ebay_systemshipfee set type='$type',aweightstart='$aweightstart',aweightend='$aweightend',ahandlefee='$ahandlefee',acountrys='$acountrys',bfirstweight='$bfirstweight',bnextweight='$bnextweight',bfirstweightamount='$bfirstweightamount',bnextweightamount='$bnextweightamount',bhandlefee='$bhandlefee',bdiscount='$bdiscount',bcountrys='$bcountrys',name='$name',ashipfee='$ashipfee',ahandelfee2='$ahandelfee2',adiscount='$adiscount' where id='$id'";
		}
		
		
		if($dbcon->execute($sql)){
			
			$status	= " -[<font color='#33CC33'>操作记录: 操作记录成功</font>]";
			
			if($id =='') $id		= mysql_insert_id();
			
		}else{
		
			$status = " -[<font color='#FF0000'>操作记录: 操作记录失败</font>]";
		}
		
		
	
	}
	
	$ss			= "select * from ebay_systemshipfee where id ='$id' ";
	$ss			= $dbcon->execute($ss);
	$ss			= $dbcon->getResultArray($ss);
	
	$type				= $ss[0]['type'];
	$aweightstart		= $ss[0]['aweightstart'];
	$aweightend			= $ss[0]['aweightend'];
	$ahandlefee			= $ss[0]['ahandlefee'];
	$acountrys			= $ss[0]['acountrys'];
	$bfirstweight		= $ss[0]['bfirstweight'];
	$bnextweight		= $ss[0]['bnextweight'];
	$bfirstweightamount	= $ss[0]['bfirstweightamount'];
	$bnextweightamount	= $ss[0]['bnextweightamount'];
	$bhandlefee			= $ss[0]['bhandlefee'];
	$bdiscount			= $ss[0]['bdiscount'];
	$bcountrys			= $ss[0]['bcountrys'];
	$name				= $ss[0]['name'];
	$ashipfee			= $ss[0]['ashipfee'];
	
	$adiscount			= $ss[0]['adiscount'];
	$ahandelfee2		= $ss[0]['ahandelfee2'];
	
	
 ?>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2>运费管理<?php echo $status;?> </h2>
</div>

<div class='listViewBody'>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<form name="ff" id="ff" method="post" action="Systemshipfeeadd.php?shippingid=<?php echo $shippingid;?>&id=<?php echo $id;?>&module=system"> 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
				  <td valign="top" nowrap="nowrap" class='paginationActionButtons'>名称：</td>
				  <td  nowrap='nowrap' align="right" class='paginationChangeButtons'><div align="left">
				    <input name="name" type="text" id="name" value="<?php echo $name;?>" />
			      </div></td>
			  </tr>
				<tr>
					<td width='16%' valign="top" nowrap="nowrap" class='paginationActionButtons'>重量计算规则</td>
				  <td  nowrap='nowrap' width='84%' align="right" class='paginationChangeButtons'>				  <div align="left"><select name="type" id="type">
				    <option value="0" <?php if($type == '0') echo 'selected="selected"';?>>按重量区间</option>
                    <option value="1" <?php if($type == '1') echo 'selected="selected"';?>>按首重，续重计算</option>
				  </select></div></td>
				</tr>
				<tr>
				  <td colspan="2" nowrap="nowrap" class='paginationActionButtons'><div align="left" style="border: #009900 dashed 2px"></div></td>
			  </tr>
				<tr>
				  <td valign="top" nowrap="nowrap" class='paginationActionButtons'>1、按重量区间计算</td>
				  <td  nowrap='nowrap' align="right" class='paginationChangeButtons'><div align="left">
				    <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#0033FF">
                      <tr>
                        <td>开始重量段</td>
                        <td><input name="aweightstart" type="text" id="aweightstart" value="<?php echo $aweightstart;?>" />
                        单位(g)</td>
                        <td>结束重量段</td>
                        <td><input name="aweightend" type="text" id="aweightend" value="<?php echo $aweightend;?>" />
                        单位(g)</td>
                      </tr>
                      <tr>
                        <td>邮费是：</td>
                        <td><input name="ashipfee" type="text" id="ashipfee" value="<?php echo $ashipfee;?>" />
                        或 每g的价格是
                        <input name="bnextweightamount" type="text" id="bnextweightamount" value="<?php echo $bnextweightamount;?>" /></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>处理费：</td>
                        <td><input name="ahandelfee2" type="text" id="ahandelfee2" value="<?php echo $ahandelfee2;?>" /></td>
                        <td>燃油附加费</td>
                        <td><input name="ahandlefee" type="text" id="ahandlefee" value="<?php echo $ahandlefee;?>" /> 
                          小数</td>
                      </tr>
                      <tr>
                        <td>折扣：</td>
                        <td><input name="adiscount" type="text" id="adiscount" value="<?php echo $adiscount;?>" /></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>对应国家列表：</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="4"><textarea name="acountrys" cols="100" rows="10" id="acountrys"><?php echo $acountrys;?></textarea>
                        支持所有国家请输入 ,any,</td>
                      </tr>
                    </table>
				  </div></td>
			  </tr>
				<tr>
				  <td colspan="2" nowrap="nowrap" class='paginationActionButtons'><div align="left" style="border: #009900 dashed 2px"></div></td>
			  </tr>
				<tr>
				  <td align="left" valign="top" nowrap="nowrap" class='paginationActionButtons'>2、按首重，续重计算</td>
				  <td  nowrap='nowrap' align="right" class='paginationChangeButtons'><div align="left">
				    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      
                      <tr>
                        <td>自定义首重：
                          <input name="bfirstweight" type="text" id="bfirstweight" value="<?php echo $bfirstweight;?>" />
                          单位(g)</td>
                        <td><input name="bfirstweightamount" type="text" id="bfirstweightamount" value="<?php echo $bfirstweightamount;?>" />
                          首重以内的费用</td>
                      </tr>
                      <tr>
                        <td> 自定义续重：
                          <input name="bnextweight" type="text" id="bnextweight" value="<?php echo $bnextweight;?>" />
                          单位(g)</td>
                        <td><input name="bnextweightamount" type="text" id="bnextweightamount" value="<?php echo $bnextweightamount;?>" />
                        续重每多少克或其零数的费用</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td><input name="bhandlefee" type="text" id="bhandlefee" value="<?php echo $bhandlefee;?>" />
                        处理费</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td><input name="bdiscount" type="text" id="bdiscount"  value="<?php echo $bdiscount;?>" />
                        折扣</td>
                      </tr>
                      <tr>
                        <td colspan="2">对应国家列表：</td>
                      </tr>
                      <tr>
                        <td colspan="2"><textarea name="bcountrys" cols="100" rows="10" id="bcountrys"><?php echo $bcountrys;?></textarea>
                          &nbsp;支持所有国家请输入 ,any,</td>
                      </tr>
                      <tr>
                        <td colspan="2"><input name="submit" type="submit" value="保存" />
                          &nbsp;</td>
                      </tr>
                    </table>
				  </div></td>
			  </tr>
			</table>		</td>
	</tr><tr height='20'>
		<th scope='col' nowrap="nowrap">
<div style='white-space: nowrap;'width='100%' align='left'></div>			</th>
			
		</tr>

		    
 
									<tr height='20' class='oddListRowS1'>
						<td scope='row' align='left' valign="top" > </td>
      </tr>
              
              

              
		<tr class='pagination'>
		<td>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'></td>
					</tr>
			</table>		</td>
	</tr></table>
</form>

    <div class="clear"></div>
<?php

include "bottom.php";


?>
<script language="javascript">
	
	function del(id){
		if(confirm('您确认删除此条记录吗')){
			
			location.href = 'systemcarrier.php?type=del&id='+id+"&module=system&action=发货方式管理";
			
		
		}
	
	
	}



</script>