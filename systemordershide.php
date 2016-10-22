<?php
include "include/config.php";


include "top.php";




	
	
	
	$hideorders			= $_REQUEST['type'];
	
	if($hideorders == 'hideorders'){
	
			
			$times		= date('Y-m-d H:i:s');
			
			$firstday	= date('Y-m-d H:i:s',strtotime("$times -90 days"));
			$firstday	= strtotime($firstday);
			
			$rr			= "SELECT * FROM  `ebay_order` where  ebay_createdtime	<= $firstday ";
			
			$rr			= $dbcon->execute($rr);
			$rr			= $dbcon->getResultArray($rr);
			
			for($i=0;$i<count($rr);$i++){
			
				
				$ebay_id		= $rr[$i]['ebay_id'];
				$ebay_createdtime	= date('Y-m-d',$rr[$i]['ebay_createdtime']);
				
				$ss					= "update ebay_order set ishide ='1' where ebay_id='$ebay_id' ";
				$dbcon->execute($ss);
				
			
			}


				
	}
	
	
	if($hideorders == 'hidemessages'){
	
			
			$times		= date('Y-m-d H:i:s');
			
			$firstday	= date('Y-m-d H:i:s',strtotime("$times -90 days"));
			$firstday	= strtotime($firstday);
			
			$rr			= "SELECT * FROM  `ebay_message` where  createtime1	<= $firstday ";
			
			$rr			= $dbcon->execute($rr);
			$rr			= $dbcon->getResultArray($rr);
			
			for($i=0;$i<count($rr);$i++){
			
				
				$id		= $rr[$i]['id'];
				$ss					= "update ebay_message set ishide ='1' where id='$id' ";
				$dbcon->execute($ss);
			
			}


				
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
                  <table width="52%" border="0" align="center" cellspacing="0" class="left_txt">
                    <tr>
                      <td>&nbsp;
                        <input name="submit" type="button" value="清除三个月之前的订单数据" onclick="return check()" />                      
                      :系统只作隐藏处理，但不实际删除，在查询时，任然可以查到</td>
                    </tr>
                    
                    <tr>
                      <td>&nbsp;
                        <input name="submit2" type="button" value="清除三个月之前的Message数据" onclick="return check02()" />
:系统只作隐藏处理，但不实际删除，在查询时，任然可以查到</td>
                    </tr>
                  </table>
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

<script language="javascript">
	
	function check(){
	
		
		var url		= 'systemordershide.php?module=system&action=订单清理&type=hideorders';
		location.href	= url;
		
	}


function check02(){
	
		
		var url		= 'systemordershide.php?module=system&action=Message清理&type=hidemessages';
		location.href	= url;
		
	}
</script>
