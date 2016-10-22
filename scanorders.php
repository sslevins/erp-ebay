<?php

include "include/config.php";





include "top.php";



	$start		= date('Y-m-d');

	$end		= date('Y-m-d');
	$start						= date('Y-m-d',strtotime("$end - 1 days"));



	

	$type	= $_REQUEST['type'];

	if($type == "del"){

		

		$id	 = $_REQUEST['id'];

		$sql = "delete from ebay_account where id=$id";

		if($dbcon->execute($sql)){

			

			$status	= " -[<font color='#33CC33'>操作记录: 记录删除成功</font>]";

			

		}else{

		

			$status = " -[<font color='#FF0000'>操作记录: 记录删除失败</font>]";

		}

		

		

		

	

	}else{

		

		$status = "";

		

	}

	

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

					<td nowrap="nowrap" class='paginationActionButtons'><div> <img src="scanorders_WI55$R9N5~WXL`~Q%}FF14H.png" /> </div>
					<table width="100%" height="99" border="0" cellpadding="0" cellspacing="0">

                

			    <form method="post" action="addaccount.php">   

			      <tr>

                    <td width="41%" height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right">运送方式</div></td>

                    <td width="3%" align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>

                    <td width="56%" height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
                      <select name="ebay_carrier" id="ebay_carrier">
                        <option value="" >请选择</option>
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
                    </div></td>
                    </tr>

			      <tr>

			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">小包还是平邮</td>

			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>

			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <select name="packingtype" id="packingtype">
     
                        <option value="0">小包</option>
                    	<option value="1">挂号</option>
                      </select>
			        </div></td>
			        </tr>
			      <tr>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">是否开启默认分配运输方式</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <select name="shipping" id="shipping">
                        <option value="0">否</option>
                        <option value="1">是</option>
                      </select>
			        </div></td>
			        </tr>
			      <tr>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">EUB扫描，请选择这里： <a href="scanordereub.php" target="_blank">进入</div></td>
			        </tr>



                  <tr>
				 </form> 

                    <td height="30" align="right" class="left_txt"><div align="right"></div></td>

                    <td align="right" class="left_txt">&nbsp;</td>

                    <td height="30" align="right" class="left_txt"><div align="left"><input type="button" value="开始扫描" onClick="check()">
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

		

		var ebay_carrier	= 	document.getElementById('ebay_carrier').value;
		var packingtype		= 	document.getElementById('packingtype').value;
		var shipping		= 	document.getElementById('shipping').value;
		var url				= '';
		
		if(packingtype == '0'){
			
			url		= "scanorder2.php?ebay_carrier="+ebay_carrier+"&shipping="+shipping;			
		}
		
		if(packingtype == '1'){
		
			url		= "scanorder.php?ebay_carrier="+ebay_carrier+"&shipping="+shipping;			
		}
		
		//location.href='orderloadstatus.php?account='+account+"&module=orders&action=Loading Orders Results&start="+start+"&end="+end;

		window.open(url);
		

		

	}

	

</script>