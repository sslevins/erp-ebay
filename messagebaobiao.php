<?php
include "include/config.php";


include "top.php";



	
	$start		= $_REQUEST['start'];
	$end		= $_REQUEST['end'];

	
	
	die('暂未启用');
	
 ?>
 
 <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>


<div id="main">
    <div id="content" >
        <table style="width:100%"><tr>
          <td><div class='listViewBody'>
  <div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='4'>按时间查找<br />
	    <br />
	    Message接收开始时间：
	    <input name="start" id="start" type="text" onclick="WdatePicker()" value="<?php echo $start;?>" /> 
	    Message接收结束时间:
	    <input name="end" id="end" type="text" onclick="WdatePicker()" value="<?php echo $end;?>" />
	    <input type="button" value="显示" onclick="check()" />
	    <br />
	    <br /></td>
	</tr><tr height='20'>
					<th scope='col' width='26%' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>Message信息统计	</div>			</th>
			
					<th scope='col' width='13%' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'></div>			</th>
			
					<th scope='col' width='13%' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'></div>			</th>
			
		<th scope='col' width='13%' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'></div>			</th>
			
					</tr>
		
		
                  
                  
                  
		    
 
									<tr height='20' class='oddListRowS1'>
						              <td height="63" colspan="4" align='left' valign="top" scope='row' ><table width="100%" border="1" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="9%">eBay account</td>
                                          <td width="64%">未回复</td>
                                          <td width="27%">已回复</td>
                                        </tr>
                                        
                                        
                                          <?php 
										  
										  
										  if($start != '' && $end != '' ){
										  
										  	
											$start		= strtotime($start.' 00:00:00');
											$end		= strtotime($end.' 23:59:59');
											
										  
										  
										  }
										  
				  
											$sql = "select * from ebay_account where ebay_user='$user' and ebay_token != ''";
											$sql = $dbcon->execute($sql);
											$sql = $dbcon->getResultArray($sql);
										
											
											for($i=0;$i<count($sql);$i++){
												
												$account	= $sql[$i]['ebay_account'];
												$regidate	= $sql[$i]['ebay_addtime'];
												$expirtime	= $sql[$i]['ebay_expirtime'];
												$id			= $sql[$i]['id'];
												
												$appname	= $sql[$i]['appname'];
												$mail		= $sql[$i]['mail'];
												$storeid		= $sql[$i]['storeid'];
												$appname		= $sql[$i]['appname'];
						
										  ?>
                                        <tr>
                                          <td><?php echo $account;?>&nbsp;</td>
                                          <td>
                                          <?php
	$ss		= "select count(id) as cc from ebay_message where status=0 and ebay_account ='$account'  ";
	
	if($start != '' && $end != '' ){
			$ss .= " and (createtime1 >= $start and createtime1 <= $end)";
	}
	 
	$ss		= $dbcon->execute($ss);
	$ss		= $dbcon->getResultArray($ss);
	$ss		= $ss[0]['cc'];
	echo $ss;
	
	?>
                                          
                                          
                                          &nbsp;</td>
                                          <td>                                          <?php
	$ss		= "select count(id) as cc from ebay_message where status=1 and ebay_account ='$account'  ";
	
	if($start != '' && $end != '' ){
			$ss .= " and (createtime1 >= $start and createtime1 <= $end)";
	}
	
	
	$ss		= $dbcon->execute($ss);
	$ss		= $dbcon->getResultArray($ss);
	$ss		= $ss[0]['cc'];
	echo $ss;
	
	?>&nbsp;</td>
                                        </tr>
                                        
                                        
                                        <?php } ?>
                                        
                                      </table>
					                    <br />
				                        <strong>回复人员统计</strong><br />
			                            <table width="100%" border="1" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td width="9%">eBay account</td>
                                            <td width="91%">已回复</td>
                                          </tr>
                                          <?php 
				  
											$sql = "select distinct replyuser from ebay_message where ebay_user='$user' and replyuser != '' ";
											$sql = $dbcon->execute($sql);
											$sql = $dbcon->getResultArray($sql);
										
											
											for($i=0;$i<count($sql);$i++){
												
												$replyuser	= $sql[$i]['replyuser'];
									
						
										  ?>
                                          <tr>
                                            <td><?php echo $replyuser;?>&nbsp;</td>
                                            <td>
											
											<?php
	$ss		= "select count(id) as cc from ebay_message where status=1 and replyuser ='$replyuser'";
	if($start != '' && $end != '' ){
			$ss .= " and (createtime1 >= $start and createtime1 <= $end)";
	}

	
	$ss		= $dbcon->execute($ss);
	$ss		= $dbcon->getResultArray($ss);
	$ss		= $ss[0]['cc'];
	echo $ss;
	
	?>
                                              &nbsp;</td>
                                          </tr>
                                          <?php } ?>
                                        </table>
		                              <br /></td>
	  </tr>


              
		<tr class='pagination'>
		<td colspan='4'>	<div align='left' style='white-space: nowrap;'width='100%'><br />
		  <br />
		</div>		</td>
	</tr>
		<tr class='pagination'>
		  <td colspan='4'>&nbsp;</td>
	  </tr>
</table>


    <div class="clear"></div>
    <script language="javascript">


	
	
	function check(id){
	
		var 	start		= document.getElementById('start').value;
		var 	end			= document.getElementById('end').value;
		
		var url		= 'messagebaobiao.php?type=storeid&end='+end+"&module=message&action=Message报表&start="+start;
		
		
		if(start == ''){
		
		
		alert('请选择日期');
		return false;
		
		
		}
		if(end == ''){
		
		
		alert('请选择日期');
		return false;
		
		
		}
		
		location.href	= url;
		
	
	
	
	}
</script>