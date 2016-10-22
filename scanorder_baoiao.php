<?php
include "include/config.php";
	include "top2.php";
	$value				= trim($_REQUEST['value']);
	$shiptype			= $_REQUEST['shiptype'];
	$tracknumber		= $_REQUEST['tracknumber'];
	if(strlen($value) >= 1 ){
	$ss					= "select * from ebay_order where (ebay_id='$value' or  ebay_tracknumber = '$value') and  ebay_status !='2' ";
	$ss					= $dbcon->execute($ss);
	$ss					= $dbcon->getResultArray($ss);
	if(count($ss)  == '0'){
		$status = " -[<font color='#FF0000'>操作记录:未找到订单</font>]";	
	}else{
		
		$ebay_ordersn	= $ss[0]['ebay_ordersn'];
		$ebay_carrier	= $ss[0]['ebay_carrier'];
		
		$status = " -[<font color='#33CC33'>操作记录订单核对成功</font>]";	
		
		$ss		= "update ebay_order set ebay_status='2',scantime='$mctime',ebay_tracknumber='$tracknumber' where   (ebay_id='$value' or  ebay_tracknumber = '$value') and  ebay_status !='2' ";
		$dbcon->execute($ss);
		//addoutstock($ebay_ordersn);
		
	}
	}




 ?><div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo "订单扫描".$status;?> </h2>
</div>

<div class='listViewBody'>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td width="65%">
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
				  <td nowrap="nowrap" class='paginationActionButtons'><form action="orderloadcsv.php" enctype="multipart/form-data" method="post" >
				    <table width="71%" border="1" align="center" cellpadding="5" bordercolor="#999999">
				      <tr>
				        <td width="21%">01. <a href="scan/scanorder_01.php" target="_blank">挂号扫描</a></td>
				        <td width="56%">&nbsp;</td>
			            <td width="23%">:</td>
				      </tr>
				      <tr>
				        <td>02. <a href="scan/scanorder_02.php" target="_blank">平邮扫描</a></td>
				        <td>&nbsp;</td>
				        <td>&nbsp;</td>
			          </tr>
				      <tr>
				        <td>03.  <a href="scan/scanorder_03.php" target="_blank">EUB系统扫描</a></td>
				        <td>&nbsp;</td>
				        <td>&nbsp;</td>
			          </tr>
                      <?php if($user != 'test'){ ?>
                      
				      <tr>
				        <td>04.<strong><a href="scanorder.php" target="_blank">扫描+称重+挂号</a></strong></td>
				        <td>&nbsp;</td>
				        <td>&nbsp;</td>
			          </tr>
				      <tr>
				        <td>05.<strong><a href="scanorder2.php" target="_blank">扫描+称重+平邮</a></strong></td>
				        <td>&nbsp;</td>
				        <td>&nbsp;</td>
			          </tr>
				      <tr>
				        <td>06.<strong><a href="scanorder3.php" target="_blank">扫描+称重+EUB</a></strong></td>
				        <td>&nbsp;</td>
				        <td>&nbsp;</td>
			          </tr>
					  <tr>
				        <td>07.<strong><a href="scanning.php" target="_blank">条码核对</a></strong></td>
				        <td>&nbsp;</td>
				        <td>&nbsp;</td>
			          </tr>
                      <?php }?>
                      
				      <tr>
				        <td colspan="2"><p><strong><br />
				          以上扫描功能，在扫描成功后，可自行定义转入到哪一个分类中（在系统管理-系统配置中），如不设置将扫描不成功</strong><br />
				          <br />
				          <br />
				          <br />
				          报表导出</p>
				          <p>第一步：选择eBay帐号<br />
			                <br />
			                <select name="account3" size="10" multiple="multiple" id="account3">
			                  <?php 
					
					$sql	 = "select * from ebay_account as a  where a.ebay_user='$user'   ";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 
					 	$account	= $sql[$i]['ebay_account'];
					 ?>
			                  <option value="<?php echo $account;?>"><?php echo $account;?></option>
			                  <?php } ?>
		                      </select>
				            <br />
				            第二步：选择扫描开始时间:
				            <?php
						
						$start1						= date('Y-m-d ').' 00:00:00';
						$start2						= date('Y-m-d ').' 23:59:59';
							
	
						
						
						?>
                            <input name="start" id="start" type="text" onclick="WdatePicker()" value="<?php echo $start1;?>" />
				            ~
				            <input name="end" id="end" type="text" onclick="WdatePicker()" value="<?php echo $start2;?>" />
				            <br />
				            <br />
				            第三步：请选择发货方式:
				            <select name="ebay_carrier" id="ebay_carrier">
                              <option value="" >所有发货方式</option>
                              <?php

						   	

							$tql	= "select * from ebay_carrier where ebay_user = '$user'";

							$tql	= $dbcon->execute($tql);

							$tql	= $dbcon->getResultArray($tql);

							for($i=0;$i<count($tql);$i++){

							

							$tname		= $tql[$i]['name'];

					

							

						   

						   ?>
                              <option value="<?php echo $tname;?>"  <?php if($tname == $ebay_carrier) echo "selected=selected" ?>><?php echo $tname;?></option>
                              <?php

						   }

						   

						   

						   ?>
                            </select>
				            <br />
				          </p>
				          <p><br />
				            <input type="button" value="导出到xls" onclick="xlsbaobiao()" />
                            <input type="button" value="速卖通发货表导出" onclick="xlsbaobiao2()" />
                            <br />
			                <br />
	                    </p></td>
				        <td>&nbsp;</td>
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
<?php

include "bottom.php";


?>
<script language="javascript">
	
	
	
	function xlsbaobiao(){
	
		var ebay_carrier		= document.getElementById('ebay_carrier').value;
		var start		= document.getElementById('start').value;
		var end			= document.getElementById('end').value;
		var account		= '';
		
		
		
		
		var len			= document.getElementById('account3').options.length;
		 for(var i = 0; i < len; i++){
		   if( document.getElementById('account3').options[i].selected){
			var e =  document.getElementById('account3').options[i];
			
			account	+= e.value+'#';
		
		   }
		  }
		
		
		var url			= 'xlsbaobiao.php?start='+start+"&end="+end+"&account="+encodeURIComponent(account)+"&ebay_carrier="+ebay_carrier;
		window.open(url,"_blank");
		
	
	}


	function xlsbaobiao2(){
		var ebay_carrier		= document.getElementById('ebay_carrier').value;
		var start		= document.getElementById('start').value;
		var end			= document.getElementById('end').value;
		var account		= '';
		var len			= document.getElementById('account3').options.length;
		 for(var i = 0; i < len; i++){
		   if( document.getElementById('account3').options[i].selected){
			var e =  document.getElementById('account3').options[i];
			
			account	+= e.value+'#';
		
		   }
		  }
		
		
		var url			= 'toxls/labelto0111.php?start='+start+"&end="+end+"&account="+encodeURIComponent(account)+"&ebay_carrier="+ebay_carrier;
		window.open(url,"_blank");
		
	
	}


</script>