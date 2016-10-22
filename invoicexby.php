<?php
include "include/config.php";
include "top.php";
$start		= date('Y-m-d');
$end		= date('Y-m-d');
$start						= date('Y-m-d',strtotime("$end - 1 days"));
 ?>
<div id="main">

    <div id="content" >

        <table style="width:100%"><tr><td><div class='moduleTitle'>

<h2><?php echo $_REQUEST['action'].$status;?> </h2>

</div>

 <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>



<div class='listViewBody'>

<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>

<div id='Accountssaved_viewsSearchForm' style='display: none';></div>

</form>

 

<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>

	<tr class='pagination'>

		<td width="65%">

			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>

				<tr>

					<td nowrap="nowrap" class='paginationActionButtons'><table width="100%" height="99" border="0" cellpadding="0" cellspacing="0">

                

			    <form method="post" action="printlabel249.php">   
			      <tr>
                    <td width="41%" height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right"> eBay帐号 </div></td>
                    <td width="3%" align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
                    <td width="56%" height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
                    <select name="account" id="account">
                    
                    <?php 
					$sql	 = "select ebay_account from ebay_account as a where a.ebay_user='$user' and ($ebayacc) and ebay_token != '' order by ebay_account desc ";
					$sqla	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sqla);
					$dbcon->free_result($sqla);
					
					for($i=0;$i<count($sql);$i++){					
					 	$account	= $sql[$i]['ebay_account'];
					 ?>
                      <option value="<?php echo $account;?>"><?php echo $account;?></option>
                    <?php } ?>
                    <option value="all">同步所有帐号</option>
                    </select></div></td>
                    </tr>

			      <tr>

			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">开始付款时间</td>

			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>

			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">

			          <input name="start" id="start" type="text" onClick="WdatePicker()"  value="<?php echo $start;?>" />

			          </div></td>
			        </tr>

			      <tr>

			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">结束付款时间</td>

			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>

			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="end" id="end" type="text" onClick="WdatePicker()"   value="<?php echo $end;?>" />
			        </div></td>
			        </tr>
			      <tr>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">发票好开始生成数</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="invoice_no" id="invoice_no" type="text"   value="" />
			          </div>
			          <div align="left">
			            <input  value="同步"  type="submit">
		              </div></td>
			        </tr>


                  <tr>
				 </form> 

                    <td height="30" align="right" class="left_txt"><div align="right"></div></td>

                    <td align="right" class="left_txt">&nbsp;</td>

                    <td height="30" align="right" class="left_txt"><div align="left">
                    </div></td>

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

	function check(){
		var start	= 	document.getElementById('start').value;
		var end		=	document.getElementById('end').value;
		if(start == ""){
			alert('请选择开始日期');
			return false;
		}
		if(end == ""){
			alert('请选择结束日期');
			return false;
		}
		var account = document.getElementById('account').value;	
		location.href='orderloadstatus.php?account='+account+"&module=orders&action=Loading Orders Results&start="+start+"&end="+end;
	}
	
	
	function check02(){
		var start	= 	document.getElementById('start').value;
		var end		=	document.getElementById('end').value;
		if(start == ""){
			alert('请选择开始日期');
			return false;
		}
		if(end == ""){
			alert('请选择结束日期');
			return false;
		}
		var account = document.getElementById('account').value;	
		location.href="orderloadstatus.php?type=resend&module=orders&action=Loading Orders Results&start="+start+"&end="+end;
	}

	function checkall(){
		var start	= 	document.getElementById('start').value;
		var end		=	document.getElementById('end').value;
		if(start == ""){
			alert('请选择开始日期');
			return false;
		}
		if(end == ""){
			alert('请选择结束日期');
			return false;
		}
		var url	= 'orderloadstatus.php?start='+start+"&end="+end+"&type=loadall&module=orders&action=Message同步";
		location.href = url;
	}

</script>