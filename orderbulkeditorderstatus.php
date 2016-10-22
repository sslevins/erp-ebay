<?php

include "include/config.php";





include "top.php";





$ordersn	= explode(",",$_REQUEST['ordersn']);

$totalcount	= count($ordersn)-1;

$status	    = "";







	

	if($_POST['submit']){

	

			

			$f_status				= $_POST['f_status']?$_POST['f_status']:0;

			$f_style				= $_POST['f_style']?$_POST['f_style']:0;

			

			

			$status					= $_POST['status']?$_POST['status']:0;

			$style					= $_POST['style']?$_POST['style']:0;



			

			for($i=0;$i<count($ordersn);$i++){

			

					

					$osn		= $ordersn[$i];

					if($ordersn != ''){

					

					

						$sql2		= "update ebay_order set mailstatus='' ";						

						if($f_style == '1'){$sql2	.= ",ebay_carrier='$style' ";}						

						if($f_status == '1'){$sql2	.= ",ebay_status='$status' ";}						

						$sql2		.= " where ebay_ordersn='$osn'";

						

						

						

						if($dbcon->execute($sql2)){

			

			

							$status0	= " -[<font color='#33CC33'>Success</font>]";

							

						}else{

						

						

							$status0 = " -[<font color='#FF0000'>Failure</font>]";

				

						}

												

				    }

			}

			



	

	}







	





?>



<div id="main">

    <div id="content" >

        <table style="width:100%"><tr><td><div class='moduleTitle'>

<h2><?php echo $_REQUEST['action'].$status0;?></h2>

</div>

 

<div class='listViewBody'>





<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">

 <input name="hiddenuserid" type="hidden" value="" id="hiddenuserid" />

 

<table width="100%" cellspacing="0" cellpadding="0" border="0">

<tr>

	

	

		

	<td nowrap="nowrap" scope="row" >批量修改：您已经选择了<?php echo $totalcount;?>条记录，请在需要批量修改的地方输入新值</td>

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

                      <form id="form" name="form" method="post" action="orderbulkeditorderstatus.php?module=orders&ordersn=<?php echo $_REQUEST['ordersn']; ?>">

                  <table width="70%" border="0" cellpadding="0" cellspacing="0">

                <input name="id" type="hidden" value="<?php echo $id;?>">

			      

			      <tr>

			        <td width="43%" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right"><span style="white-space: nowrap;">

			          <input name="f_status" type="checkbox" value="1" id="f_status">	

			        </span></div></td>

			        <td width="15%" align="right" bgcolor="#f2f2f2" class="left_txt">Order Status</td>

			        <td width="42%" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">

			          <select name="status" id="status">

                        <option value="-1" <?php if($oost == "-1") echo "selected=selected" ?>>Please Select</option>

                            <option value="0" <?php  if($oost == "0")  echo "selected=selected" ?>>Awaiting Payment</option>

                            <option value="1" <?php  if($oost == "1")  echo "selected=selected" ?>>Awaiting Shipment</option>

                            <option value="2" <?php  if($oost == "2")  echo "selected=selected" ?>>Paid & Shipped</option>
                             <option value="990" <?php  if($oost == "990")  echo "selected=selected" ?>>重寄-待审核</option>
                            <option value="991" <?php  if($oost == "991")  echo "selected=selected" ?>>重寄-已审核</option>
							<option value="992" <?php  if($oost == "992")  echo "selected=selected" ?>>重寄-已重寄</option>
 							<option value="993" <?php  if($oost == "993")  echo "selected=selected" ?>>退款-待审核</option>
  							<option value="994" <?php  if($oost == "994")  echo "selected=selected" ?>>退款-已审核</option>
   							<option value="995" <?php  if($oost == "995")  echo "selected=selected" ?>>退款-已退款</option>
                            

                            <?php



							$ss		= "select * from ebay_topmenu where ebay_user='$user' order by ordernumber";

							$ss		= $dbcon->execute($ss);

							$ss		= $dbcon->getResultArray($ss);

							for($i=0;$i<count($ss);$i++){

							

								$ssid		= $ss[$i]['id'];

								$ssname		= $ss[$i]['name'];

								

							

							?>

                            

                            <option value="<?php echo $ssid;?>" <?php  if($oost == $ssid)  echo "selected=selected" ?>><?php echo $ssname; ?></option>

                            

                            <?php } ?> 

                      </select>

			        </div></td>

			        </tr>

			      <tr>

			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><span style="white-space: nowrap;">

			          <input name="f_style" type="checkbox" value="1" id="f_style">

			        </span></td>

			        <td align="right" bgcolor="#f2f2f2" class="left_txt">Shipping Method</td>

			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">

			          <select name="style" id="style">

                        <option value="-1" >请选择</option>

                        <?php

						   	

							$tql	= "select * from ebay_carrier where ebay_user = '$user'";

							$tql	= $dbcon->execute($tql);

							$tql	= $dbcon->getResultArray($tql);

							for($i=0;$i<count($tql);$i++){

							

							$tname		= $tql[$i]['name'];

							

							

						   

						   ?>

                        <option value="<?php echo $tname;?>"  ><?php echo $tname;?></option>

                        <?php

						   }

						   

						   

						   ?>

                      </select>

			        </div></td>

			        </tr>

			      

			      

			      

			      

			      

                  <tr>				 

                    <td align="right" class="left_txt"><div align="right"></div></td>

                    <td align="right" class="left_txt">&nbsp;</td>

                    <td align="right" class="left_txt"><div align="left">

                      <input name="submit" type="submit" value="Update" onClick="return check()">

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

