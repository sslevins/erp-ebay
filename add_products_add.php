<?php  
include "include/config.php";
include "include/function.php";


include "top.php";

 

$sku= $_GET['sku'];
$text=$sku."产品开发";
 
 
 

if (isset($_POST['act']) && $_POST['act']=='add')
{       
 	 
	 
	//  @$rs=db_execute( "select products_weight from erp_products_data where products_sku='".$_POST['sku']."'");
	//  echo ( "select products_weight from erp_products_data where products_sku='".$_POST['sku']."'");
	//  echo $rs[0]."运费";
	
$sqlRMB="select * from ebay_currency where currency ='RMB'";
$sqlRMB = $dbcon->execute($sqlRMB);//  中国
		$rsRMB = $dbcon->getResultArray($sqlRMB);
		$RMB=1/$rsRMB[0]['rates'];
if ($_POST['paypal']==1) $paypal=0.029;$sp=0;
	if ($_POST['paypal']==2)$paypal=0.032;$sp=0;
	if ($_POST['paypal']==3)	$paypal=0.034;$sp=0;
	if ($_POST['paypal']==4) $paypal=0.039;$sp=0;
	if ($_POST['paypal']==5)$paypal=0.06;$sp=0.05;
	
if ($_POST['catetry']==1) $T=0.11;
if ($_POST['catetry']==2) $T=0.07;
if ($_POST['catetry']==3) $T=0.1;
$Aa=($_POST['price']+$_POST['aprice']);
//	$sss=$RMB*($_POST['price']+$_POST['aprice'])*(0.861-0.15)-0.3*$RMB-get_shipping_fee_use_weight($rs['products_weight']*0.8421);
$sss=$RMB*$Aa-0.15*$RMB*$Aa-$paypal*$RMB*$Aa-$sp*$RMB-$T*$RMB*$Aa-0.3*$RMB-get_shipping_fee_use_weight($_POST['sku']);
$ss1=$RMB*$Aa-0.10*$RMB*$Aa-$paypal*$RMB*$Aa-$sp*$RMB-$T*$RMB*$Aa-0.3*$RMB-get_shipping_fee_use_weight($_POST['sku']);
$ss2=$RMB*$Aa-0.07*$RMB*$Aa-$paypal*$RMB*$Aa-$sp*$RMB-$T*$RMB*$Aa-0.3*$RMB-get_shipping_fee_use_weight($_POST['sku']);

 // C=6.3A-0.15*6.3A-0.029A*6.3-T*6.3A-0.3*6.3-P
  
	//$ss1=$RMB*($_POST['price']+$_POST['aprice'])*(0.861-0.15)-0.3*$RMB-get_shipping_fee_use_weight($rs['products_weight']*0.8421);
	//$ss2=$RMB*($_POST['price']+$_POST['aprice'])*(0.861-0.15)-0.3*$RMB-get_shipping_fee_use_weight($rs['products_weight']*0.8421);

	// echo "6.4*(".$_POST['price']."+".$_POST['aprice'].")*".(0.861-0.15)."-0.3*6.4-".get_shipping_fee_use_weight($rs['products_weight']);
	// echo $sss;
		   $sql="insert into erp_products_addop (sku,dprice,aprice,
		   price,price1,price2,link,addtime,adder,remark,keyds,pcategory)
		   
		   values (
		   '".$_POST['sku']."','".$_POST['price']."','".$_POST['aprice']."',
		   '".$sss."',
		   '".$ss1."',
		   '".$ss2."','".$_POST['link'] ."','"
		  .date('Y-m-d H:i:s',time())."','".$_COOKIE['id']. 
		 "','".$_POST['ckeditor1']."','".$_POST['key']."','".$_POST['pcatetry']."')";
		/// echo $sql;
 		   mysql_query($sql);
           $id=mysql_insert_id();
		   
		 //  mysql_query("update erp_products_data set  products_qs=1 where products_sku='".$_POST['sku']."'");
 //echo ("update erp_products_data set  products_qs=1 where products_sku='".$_POST['sku']."'");
$msg=($id>0) ? '<span style="color:#009900; font-weight:bold;">录入成功，进入<a href="products_opadd_list.php?status=1">[产品开发管理]</a>查看，或继续录入 。</span>' : '<span style="color:#CC0000; font-weight:bold;">录入失败，请检查数据的合理性或联系系统管理员。</span>';
$id='';
}


?>
 
<script src='js/ajax.js'></script>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
	<script src="js/sample.js" type="text/javascript"></script>
	
	<div id="main">
    <div id="content" >
	
	     <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status;?> </h2>
</div>



<div class='listViewBody'>

<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
		
	<td nowrap="nowrap" scope="row" >
	<input tabindex='2' title='上架的开发产品' class='button' type="button" name='button' value='上架的开发产品' id='search_form_submit' onClick="location.href='products_opadd_list.php?status=6&module=sale&action=上架的开发产品'"/>
	&nbsp;</td>
	</tr>
</table>
</div>


<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div> 
  
<form method="post" name="special_form" id="special_form" >
<?php if ($msg!=''){echo '<div>'.$msg.'</div>';}?>
    <table width="100%" border="0" cellspacing="2" cellpadding="0" class='list view'>
  <tr>
  <td>paypal类型</td>
  <td><select name="paypal">
     <option value="1">paypal2.9% </option>
     <option value="2">paypal3.2%</option>
     <option value="3">paypal3.4% </option>
	 <option value="4">paypal3.9% </option>
     <option value="5">小paypal6%+0.05 </option>
   </select></td>
  </tr>
  
   <tr>
   <td>类别</td>
   <td><select name="catetry">
     <option value="1">other </option>
     <option value="2">electronic*</option>
     <option value="3">colse </option>
   </select></td>
   </tr>
   
   <tr>
   <td>产品分类</td>
   <td><select name="pcatetry">
     <option value="L">LED灯激光类 </option>
     <option value="H">人体健康类</option>
     <option value="P">飞机模型类 </option>
	 <option value="C">平板电脑类 </option>
	 <option value="A">汽车配件类 </option>
	 <option value="G">游戏类 </option>
	 <option value="E">电子消费类 </option>
	 <option value="M">手机配件类 </option>
	 <option value="S">间谍类 </option>
    </select></td>
   </tr>
   <tr>
      <td>重量 ：</td>
      <td><input name="sku" id="sku" size="25"  lang="require"  title="sku" value="<? echo $sku;?>" /> </td>
    </tr>
    <tr>
      <td> 价格 ：</td>
      <td><input name="price" id="price" size="25"  lang="require"  title="价格" /> </td>
    </tr>
	    <tr>
      <td> 运费 ：</td>
      <td><input name="aprice" id="aprice" size="25"  lang="require"  title="价格" /> </td>
    </tr>
	 <tr>
      <td> 关键字 ：</td>
      <td><input name="key" id="key" size="25"  lang="require"  title="关键字" /> </td>
    </tr>
	    <tr>
      <td> 链接 ：</td>
      <td><input name="link" id="link" size="25"  lang="require"  title="链接" /> </td>
    </tr>
      <tr>
      <td>图片 ：</td>
      <td> 
	  
	  <textarea name="ckeditor1" class="ckeditor" cols="60" rows="5" id="ckeditor1"><? echo $rs['qc'];?>
	</textarea> </td>
    </tr>
	
   <tr>
    <td valign="middle" colspan="2">
	<input name="act" type="hidden" id="act" value="add" />
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