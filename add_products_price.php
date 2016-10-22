<?php  
 include "include/config.php";
include "include/function.php";


include "top.php";


$sku= $_GET['sku'];
$text=$sku."产品优化";
 
 
 

if (isset($_POST['act']) && $_POST['act']=='add')
{       
 	 
	 
	  @$rs=db_execute( "select goods_weight from ebay_goods where goods_sn='".$_POST['sku']."'");
	  @$rsc=db_execute( "select goods_weight from ebay_goods where goods_sn='".$_POST['sku']."'");

	//  echo ( "select products_weight from erp_products_data where products_sku='".$_POST['sku']."'");
	//  echo $rs[0]."运费";
	
$sqlRMB="select * from ebay_currency where currency ='RMB'";
$sqlRMB = $dbcon->execute($sqlRMB);//  中国
		$rsRMB = $dbcon->getResultArray($sqlRMB);
		$RMB=1/$rsRMB[0]['rates'];
if ($_POST['catetry']==1) $T=0.11;
if ($_POST['catetry']==2) $T=0.07;
if ($_POST['catetry']==3) $T=0.1;
 

	if ($_POST['paypal']==1) $paypal=0.029;
	if ($_POST['paypal']==2)$paypal=0.032;
	if ($_POST['paypal']==3)	$paypal=0.034;
	if ($_POST['paypal']==4) $paypal=0.039;
	if ($_POST['paypal']==5)$paypal=0.06;
	
$m1d=$_POST['cprice'];	
	
$Aa=($_POST['price']+$_POST['aprice']);

$acount=$Aa;
//echo $acount;
if ($acount<50)
	{
	
  	  $m1c=$acount*$T;
	  	$m1c=round($m1c, 2); 
	 // echo "成交".$m1c."<br>";
	  	 // echo "成交".$paypal."<br>";
	$m1p=$acount*$paypal+0.3;
	if ($_POST['paypal']==5)$m1p=$acount*$paypal+0.05;
		//  echo "paypal".$m1p."<br>";

 	$m1p=round($m1p, 2); 
 	$m1=$m1d+$m1c+$m1p;
	//echo "实际".$m1."<br>";
	$mg=$m1c+$m1p;
	}
	else
	{
  	$m1c=($acount-50)*0.06+50*$T;
 	$m1c=round($m1c, 2); 
	$m1p=$acount*$paypal+0.3;
	if ($_GET['paypal']==5)$m1p=$acount*$paypal+0.05;
 	$m1p=round($m1p, 2); 
	$m1=$m1d+$m1c+$m1p;
	$mg=$m1c+$m1p;
  	}
//echo "a:".$m1."网站费";
//$ship=getproductsfieldsusesku("xiaobaofee",$_POST['sku']);
//if ($ship==0)$ship=get_shipping_fee_use_weight($rs['products_weight']);

//$a=getproductsfieldsusesku("products_value",$_POST['sku']);
$ss1=((round($RMB*$acount, 2)-round($RMB*$mg,2))*0.96-$RMB*$m1d-$ship);
$sss=((round($RMB*$acount, 2)-round($RMB*$mg,2))*0.96-$RMB*$m1d-$ship)-0.07*round($RMB*$acount, 2);
$sss1=((round($RMB*$acount, 2)-round($RMB*$mg,2))*0.96-$RMB*$m1d-$ship)-0.15*round($RMB*$acount, 2);

$ss2=$sss;
$ssf=(($RMB*$acount-$RMB*$mg)*0.96-$RMB*$m1d-$a-$ship);
$x1=((round($RMB*$acount, 2)-round($RMB*$mg,2))*0.96-$RMB*$m1d-$a-$ship)/(round($RMB*$acount, 2));
 $margin1=round($RMB*$x1, 2)*$acount;
 
	$sr="select  price from erp_products_op where sku='".$_POST['sku']."' and  status <>2 and  status <>3 order by price asc";
	$srpric=db_execute($sr);
 	$srprice=$srpric['price'];
 if ($sss1>$rsc['goods_cost'])
{
echo "<script>alert('您提交的价:".$sss1."高于成本价'".$rsc['goods_cost'].")</script>";
exit;
}

if ($sss<0)
{
echo "<script>alert('您提交的价:".$sss."成本为负')</script>";
exit;
}

if ($sss1>$srprice &&  $srprice>0)
{
echo "<script>alert('您提交的价:".$sss1."比之前的价格:".$srprice."高')</script>";

}
 
/*echo "<script>alert('您提交的价:".$sss1."比之前的价格:".$srprice."高')</script>";
 */
if ($sss1<=$srprice)
{

$sql="update erp_products_op  set keywords= '".$_POST['key']."', dprice='".$_POST['price']."' , aprice='".$_POST['aprice']."' ,  price='".$sss1."' ,price1='".$ss1."', price2 ='".$ss2."', link='".$_POST['link']."',addtime='".date('Y-m-d H:i:s',time())."',adder='".$_COOKIE['id']."',remark='".$_POST['remark']."',profit='".$ssf."' where  sku ='".$_POST['sku']."'";
//products_name_en
 
  $url = "add_products_price.php"; 
echo("<script>if(confirm('您提交的价比之前的价格低确定替换吗?')){}window.location.href='$url'</script>");
//products_name_en=concat(products_name_en,'" ." ".$_GET['key'] ."')
 //echo $sql;
		//   $sqlke="select * from erp_products_data where products_sku ='".$_POST['sku']."'";
//$rskey=db_execute($sqlke);
//$key=$rskey['products_name_en'];
if ($key==0)$key='';

$key=$key.",".$_POST['key'] ;
//mysql_query(	"update erp_products_data set products_name_en='".$key."' , opt=1,keywords= '".$_POST['key']."'where products_sku='".$_POST['sku']."'");

  //  mysql_query($sql);
}

if ($srprice==0){
		   $sql="insert into erp_products_op (sku,dprice,aprice,
		   price,price1,price2,link,addtime,adder,remark,profit,keywords,category,paypal,dl)
		   
		   values (
		   '".$_POST['sku']."','".$_POST['price']."','".$_POST['aprice']."',
		   '".$sss1."',
		   '".$ss1."',
		   '".$ss2."','".$_POST['link'] ."','"
		  .date('Y-m-d H:i:s',time())."','".$_COOKIE['id']. 
		 "','".$_POST['remark']."','".$ssf."','".$_POST['key']."','".$T."','".$paypal."','".$m1d."' )";
		//echo $sql;
 		   mysql_query($sql);
           $id=mysql_insert_id();
	//	   $sqlke="select * from erp_products_data where products_sku ='".$_POST['sku']."'";
//$rskey=db_execute($sqlke);
//$key=$rskey['products_name_en'];
if ($key==0)$key='';
$key=$key.",".$_POST['key'] ;
//mysql_query(	"update erp_products_data set products_name_en='".$key."' , opt=1,keywords= '".$_POST['key']."'where products_sku='".$_POST['sku']."'");
		   }
		   
		 //  mysql_query("update erp_products_data set  products_qs=1 where products_sku='".$_POST['sku']."'");
 //echo ("update erp_products_data set  products_qs=1 where products_sku='".$_POST['sku']."'");
$msg=($id>0) ? '<span style="color:#009900; font-weight:bold;">录入成功，进入<a href="products.php">[产品管理]</a>查看，或继续录入 。</span>' : '<span style="color:#CC0000; font-weight:bold;">录入失败，请检查数据的合理性或联系系统管理员。</span>';
$id='';
//$msg.=$sql;
}


?>
 
<script src='js/ajax.js'></script>
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
	<input tabindex='2' title='待优化' class='button' type="button" name='button' value='待优化' id='search_form_submit' onClick="location.href='products_op_list.php?module=sale&action=待优化'"/>
	&nbsp;</td>
	</tr>
</table>
</div>

<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div> 
<form method="post" name="special_form" id="special_form" >
<?php if ($msg!=''){echo '<div>'.$msg.'</div>';}?>
   <table width="100%" border="0" cellspacing="2" cellpadding="0" class='list view'>
     <tr  >
	  <td  >paypal类型</td>
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
      <td>sku ：</td>
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
      <td> 登陆费 ：</td>
      <td><input name="cprice" id="cprice" size="25"  lang="require"  title="价格" /> </td>
    </tr>
	    <tr>
      <td> 链接 ：</td>
      <td><input name="link" id="link" size="25"  lang="require"  title="链接" /> </td>
    </tr>
	    <tr>
      <td> 关键字 ：</td>
      <td><input name="key" id="key" size="25"   lang="require"   title="关键字" /> </td>
    </tr>
      <tr>
      <td>备注 ：</td>
      <td><textarea name="remark" cols="45" rows="11" id="remark" title="备注项" lang="require"> </textarea> </td>
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
	    <div class="clear"></div>

  <?php

include "bottom.php";


?>