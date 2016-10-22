<?php 

   include "include/config.php";
include "include/function.php";
include "top.php";
 

$sku= $_GET['sku'];
$text=$sku."提问";
 
 
 

if (isset($_POST['act']) && $_POST['act']=='add')
{       
 	 
	 
		   $sql="insert into erp_products_qs (title,
		   content,sku,addtime,adder)
		   
		   values (
		   '".$_POST['code_id']."',
		   '".$_POST['code_name']."','".$_POST['skub'] ."','"
		  .date('Y-m-d H:i:s',time())."','".$_COOKIE['id']. 
		 "')";
		// echo $sql;
 		   mysql_query($sql);
           $id=mysql_insert_id();
		   
		   mysql_query("update erp_products_data set  products_qs=1 where products_sku='".$_POST['sku']."'");
 //echo ("update erp_products_data set  products_qs=1 where products_sku='".$_POST['sku']."'");
$msg=($id>0) ? '<span style="color:#009900; font-weight:bold;">录入成功，进入<a href="qslist.php">[问题列表]</a>查看，或继续录入 。</span>' : '<span style="color:#CC0000; font-weight:bold;">录入失败，请检查数据的合理性或联系系统管理员。</span>';
$id='';
}


?>
<?php
$title='录入'.$text;
 ?>
<script src='js/ajax.js'></script>

<div id="main_frame_main">
<div class="back_page"><a href="#" onclick="javascript:history.back();"><font color="#FFFFFF"> 后 退 </font></a></div>
<div>
  <h3>当前位置：<?php echo $title;?></h3>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  
</div>
<form method="post" name="special_form" id="special_form" >
<?php if ($msg!=''){echo '<div>'.$msg.'</div>';}?>
<div class="box_content_style">
  <div class="box_title_style">  </div>
  <table width="100%" border="0" cellspacing="2" cellpadding="0">
   <tr>
      <td>sku ：</td>
      <td><input name="skub" id="skub" size="25"  lang="require"  title="问题标题为必填项" value="<? echo $sku;?>" /> </td>
    </tr>
    <tr>
      <td> 问题标题 ：</td>
      <td><input name="code_id" id="code_id" size="25"  lang="require"  title="问题标题为必填项" /> </td>
    </tr>
      <tr>
      <td>问题内容 ：</td>
      <td><textarea name="code_name" cols="45" rows="11" id="code_name" title="问题内容D为必填项" lang="require"> </textarea> </td>
    </tr>
	
 
	
  </table>
</div>
 
<!--<div class="box_content_style">
  <div class="box_title_style">付款信息</div>
付款方式：
        <select name="orders_pp_account" id="orders_pp_account"  style="width:160px;" lang="require"  title="付款方式为必选项" >
      <option value="">==选择==</option>
	   
    </select>
付款信息：
<input name="pay_info" id="pay_info" size="50"  lang="require"  title="付款信息为必填项" />
</div>-->


 
 
<div class="box_content_style">
 <table width="100%" border="0" cellspacing="2" cellpadding="0">
  
  
  
 
  <tr>
    <td valign="middle">
	<input name="act" type="hidden" id="act" value="add" />

	<input name="sku" type="hidden" id="sku" value="<? echo $sku;?>" />

	<input type="submit" name="Submit" value="确定提交" style=" margin-left:60px;"  onclick="return form_chk(this.form);"/>
    <input type="button" name="Submit2" value="全部重填" /></td>
  </tr>
</table>

</div>
</form>
</div>
<script>
function adddivfororder(num)
{ 
  number=parseInt(num)+1;
  str=document.getElementById('orders_list_box').innerHTML;
  //lang=document.getElementById('total_lang').value;
  string='<div id="input_groups_'+number+'">'+number+'.SKU <input name="web_orders_sku[]" type="text" id="web_orders_sku'+number+'" size="10" onblur="show_object('+number+',this,\'sku\')" /> 产品中文名 <input name="web_orders_nm_cn[]" type="text" id="web_orders_nm_cn'+number+'" size="30"  lang="require"  title="产品中文名为必填项" onblur="show_object('+number+',this,\'nm_cn\')" /> 数量 <input name="web_orders_count[]" type="text" id="web_orders_count_'+number+'" size="10"  lang="mustint"  onchange="EscrowPO_Recalculate();" title="产品数量为必填项且必须为数字"/>  <font style="cursor:pointer; color:#FF0000; font-family:\'宋体\'; font-size:14px;"><b onclick="clearinner(\'input_groups_'+number+'\');">×</b><nobr>=<span algin="center" id="POItemTotalSpan_'+number+'">0</span><input value="0" id="POItemTotal_'+number+'" name="POItemTotal" type="hidden"></nobr></font></div>';
  document.getElementById('orders_list_box').innerHTML=str+string;
  document.special_form.number_for_orders_list.value=number;
}
function clearinner(id)
{
document.getElementById(id).style.display='none';
document.getElementById(id).innerHTML='';
}
</script>
<script>
function EscrowPO_Recalculate()
	{

		var dblAllItemTotal = 0;
		var dblTotal = 0;
		for (var i = 0; i < document.special_form.elements.length; i++)
		{
	
		
			if (document.special_form.elements[i].name == 'POItemTotal')
			{
			//alert(document.getElementById('web_orders_count_' + document.special_form.elements[i].id.substr(12)).value);
				 eval('document.special_form.elements[i].value = Math.round(10000 * ' + document.getElementById('web_orders_count_' + document.special_form.elements[i].id.substr(12)).value * document.getElementById('web_orders_total_' + document.special_form.elements[i].id.substr(12)).value + ') / 10000');
				if (isNaN(document.special_form.elements[i].value))
				{
			
					document.special_form.elements[i].value = '0';
				}
				else
				{
				
					eval('dblAllItemTotal = dblAllItemTotal + ' + document.special_form.elements[i].value);
					eval('dblTotal = dblTotal + ' + document.special_form.elements[i].value);
					
				}//alert(dblTotal);
					//	alert(dblAllItemTotal);
				document.getElementById('POItemTotalSpan_' + document.special_form.elements[i].id.substr(12)).innerHTML = document.special_form.elements[i].value;
			}


			if (document.special_form.elements[i].name == 'shipping_fee')
			{
				eval('dblTotal = dblTotal + ' + document.special_form.elements[i].value * 1);
			}
		}

		document.getElementById('POAllItemTotal').value = dblAllItemTotal;
		document.getElementById('POAllItemTotalSpan').innerHTML = document.getElementById('POAllItemTotal').value;

		document.getElementById('POTotal').value = dblTotal;
		if (isNaN(document.getElementById('POTotal').value))
		{
			document.getElementById('POTotal').value = dblAllItemTotal;
		}
		document.getElementById('POTotalSpan').innerHTML = document.getElementById('POTotal').value;


		


	}</script>
   <?php

include "bottom.php";


?>