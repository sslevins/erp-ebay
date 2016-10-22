<?php

include "include/config.php";

include "top.php";	

$id		= $_REQUEST['id'];





if($_POST['submit']){



	

	$name					= str_rep($_POST['name']);

	$note					= str_rep($_POST['note']);

	$subject				= str_rep($_POST['subject']);

	$order					= $_POST['order']?$_POST['order']:0;

	$category				= str_rep($_POST['category']);

	

	

	if($id == ""){

	

		$sql	= "insert into ebay_messagetemplate(name,content,ebay_user,subject,ordersn,category) values('$name','$note','$user','$subject','$order','$category')";

	

	}else{

	

		$sql	= "update ebay_messagetemplate set name='$name',content='$note',subject='$subject',category='$category',ordersn='$order' where id='$id'";

	

	}

	



	

	





		if($dbcon->execute($sql)){

			

			$status	= " -[<font color='#33CC33'>操作记录: 记录保存成功</font>]";

			

		}else{

		

			$status = " -[<font color='#FF0000'>操作记录: 记录保存失败</font>]";

		}





}



$sql	= "select * from ebay_messagetemplate  where id='$id'";

$sql	= $dbcon->execute($sql);

$sql	= $dbcon->getResultArray($sql);

$name	= $sql[0]['name'];

$note			= $sql[0]['content'];

$subject			= $sql[0]['subject'];

$order				= $sql[0]['ordersn'];

$category			= $sql[0]['category'];





 ?>

<div id="main">

    <div id="content" >

        <table style="width:100%"><tr><td><div class='moduleTitle'>

<h2><?php echo $_REQUEST['action'].$status;?> </h2>

</div>



<div class='listViewBody'>





<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">

 

 

<table width="90%" cellspacing="0" cellpadding="0" border="0">

<tr>

	

	

	

		

	<td nowrap="nowrap" scope="row" >&nbsp;<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>

                      <td class="login_txt_bt">&nbsp;</td>

              </tr>

                    <tr>

                      <td valign="top" class="left_txt">



                      &nbsp;<br>

                     <form method="post" action="addtemplate.php?id=<?php echo $id;?>&module=message&action=Message模板分类" name="listForm">

<!-- start ad position list -->

 <form id="f" name="f" method="post" action="addtemplate.php">

 <input type="hidden" name="id" value="<?php echo $id;?>">

  <table width="70%" height="81" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr>

      <td width="16%">标题</td>

      <td width="84%"><div align="left">

        <textarea name="name" cols="80" id="name"><?php echo $name; ?></textarea>

      </div></td>

      <td width="84%" rowspan="5">提示: 输入 {Buyername}将自动替换成客户的{Buyername} : 客户的姓名<br />
 {Buyerid}：客户的ID<br />
{Buyercountry}：客户的国家<br />
{Sellerid} ：卖家帐号<br />
{Itemnumber} ：物品编号<br />
{Itemtitle} ：物品标题<br />
{Itemquantity} ：数量<br />
{Post_Date} ：标记发出时间<br />
{Shippingaddress}：收件地址<br />
{Payment_Date}：付款时间<br />
{Paypal_Transaction_Id}：Paypal交易ID<br />
{Track_Code}：跟踪号<br />
{Today}：今天时间<br />
{Today_3}：3天后时间<br />
{Today_5}：5天后时间<br />
{Today_7}：7天后时间<br />
{Today_10}：10天后时间<br />
{Post_Date_7}：邮递时间+7天时间<br />
{Post_Date_9}：邮递时间+9天时间<br />
{Post_Date_14}：邮递时间+14天时间<br />
{Post_Date_21}：邮递时间+21天时间<br />
{Post_Date_30}：邮递时间+30天时间<br />
{Post_Date_today}：邮递时间到今天时间<br />
{seller_email_address}：卖家邮箱地址<br />
</td>
    </tr>

    <tr>

      <td>主题</td>

      <td><div align="left">

        <textarea name="subject" cols="80" id="subject"><?php echo $subject; ?></textarea>

      </div></td>
      </tr>

    <tr>

      <td>模板内容</td>

      <td><div align="left">

        <textarea name="note" cols="80" rows="15" id="note"><?php echo $note;?></textarea>

      </div></td>
      </tr>

    <tr>

      <td>模板显示序号</td>

      <td><input name="order" type="text" id="order" value="<?php echo $order;?>"/>

        &nbsp;</td>
      </tr>

    <tr>

      <td>模板分类</td>

      <td>

      <select name="category" id="category">

        

        <option value="常用模板" <?php if($category== '常用模板') echo "selected=\"selected\"" ?>>常用模板</option>

        <option value="一般模板" <?php if($category== '一般模板') echo "selected=\"selected\"" ?>>一般模板</option>
        
        <?php
				  	$sql = "select * from ebay_templatecategory where ebay_user ='$user' ";
					$sql = $dbcon->execute($sql);
					$sql = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){
						$name 	= $sql[$i]['name'];
						$id 	= $sql[$i]['id'];
									
		?>
        <option value="<?php echo $name;?>" <?php if($category== $name) echo "selected=\"selected\"" ?>><?php echo $name;?></option>
		<?php } ?>
      </select>

      &nbsp;<a href="messagecategorys.php?module=message" target="_blank">自定义模板分类</a></td>
      </tr>

    <tr>

      <td>&nbsp;</td>

      <td><input name="submit" type="submit" value="提交" onClick="return check()">&nbsp;<br />

      <br />
      <br />





<br /></td>

      <td>&nbsp;</td>
    </tr>

    <tr>

      <td>&nbsp;</td>

      <td>&nbsp;</td>

      <td>&nbsp;</td>
    </tr>
</table>

</form>

                      <p>&nbsp;</p>

    <p><br>

                                          </p></td>

                    </tr>

                    

          </table></td>

	</tr>

</table>

</div>

<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>

<div id='Accountssaved_viewsSearchForm' style='display: none';></div>

</form>

 

<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>

	<tr class='pagination'>

		<td width="65%">&nbsp;</td>

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