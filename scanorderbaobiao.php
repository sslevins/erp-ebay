<?php
include "include/config.php";


include "top.php";



 ?>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo "订单扫描".$status.' '.$str;?> </h2>
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
				  <td nowrap="nowrap" class='paginationActionButtons'>
				    <table width="100%" border="0" align="center">
				      
				      <tr>
				        <td width="194%" colspan="4">第一步，选择帐号，可以多选<br />
				          <select name="account3" size="10" multiple="multiple" id="account3">
                          <?php 
					
					$sql	 = "select ebay_account from ebay_account as a  where a.ebay_user='$user'   ";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 
					 	$account	= $sql[$i]['ebay_account'];
					 ?>
                          <option value="<?php echo $account;?>"><?php echo $account;?></option>
                          <?php } ?>
                        </select>
				            <br />
				            <br />
				            第二步，选择扫描时间<br />
			              <?php
						
						$start1						= date('Y-m-d ').' 00:00:00';
						$start2						= date('Y-m-d ').' 23:59:59';
							
	
						
						
						?>
				          <input name="start" id="start" type="text" onclick="WdatePicker()" value="<?php echo $start1;?>" />
			            扫描结束时间:
			            <input name="end" id="end" type="text" onclick="WdatePicker()" value="<?php echo $start2;?>" />
			            <br />
			            <br />
			            第三步,选择物流方式：
			            <select name="ebay_carrier" id="ebay_carrier">
                          <option value="" >请选择</option>
                          <?php

						   	

							$tql	= "select name from ebay_carrier where ebay_user = '$user'";
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
			            <br />
			            <br />
			            <input type="button" value="导出到xls" onclick="xlsbaobiao()" />
			            <input type="button" value="每日发货清单导出xls" onclick="xlsbaobiao1()" /></td>
			          </tr>
				      <tr>
				        <td colspan="4"><br /></td>
			          </tr>
				      <tr>
				        <td colspan="4">&nbsp;</td>
			          </tr>
			        </table>
				
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
	
		
		var start		= document.getElementById('start').value;
		var end			= document.getElementById('end').value;
		var ebay_carrier			= document.getElementById('ebay_carrier').value;
		var account		= '';
		
		var len			= document.getElementById('account3').options.length;
		 for(var i = 0; i < len; i++){
		   if( document.getElementById('account3').options[i].selected){
			var e =  document.getElementById('account3').options[i];
			
			account	+= e.value+'#';
		
		   }
		  }
		
	
		
		var url			= 'xlsbaobiao.php?start='+start+"&end="+end+"&account="+encodeURIComponent(account)+"&ebay_carrier="+encodeURIComponent(ebay_carrier);
		

		window.open(url,"_blank");
		
	
	}

	function xlsbaobiao1(){
	
		
		var start		= document.getElementById('start').value;
		var end			= document.getElementById('end').value;
		var ebay_carrier			= document.getElementById('ebay_carrier').value;
		var account		= '';
		
		var len			= document.getElementById('account3').options.length;
		 for(var i = 0; i < len; i++){
		   if( document.getElementById('account3').options[i].selected){
			var e =  document.getElementById('account3').options[i];
			
			account	+= e.value+'#';
		
		   }
		  }
		
	
		
		var url			= 'xlsbaobiao04.php?start='+start+"&end="+end+"&account="+encodeURIComponent(account)+"&ebay_carrier="+encodeURIComponent(ebay_carrier);
		window.open(url,"_blank");
		
	
	}
</script>
