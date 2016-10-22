<?php 

include "include/config.php";
include "include/function.php";
include "top.php";

   $thisurl='qs_list.php?code='.$_GET['code'].'&page='.$page.'&action=';
$text="问题列表";
 $page=(int)$_GET['page'];
 if ($page==0){$page=1;}
  $from=($page-1)*ROWS_PERPAGE; 
   $to=$from+ROWS_PERPAGE;
 
	//ROWS_PERPAGE=100;
	 $sql="select  erp_products_qs.id as id , erp_products_qs.title,erp_products_qs.sku,erp_products_qs.addtime as name,ebay_user.username from  erp_products_qs,ebay_user       ";
 	 if ($_GET['code']!=""){$sql.=" where  sku ='".$_GET['code']."' and  ebay_user.id =erp_products_qs.adder";
	 $code=$_GET['code'];$text=$code.$text;
	 }
	 	  	 if ($_GET['code']==""){$sql.=" where    ebay_user.id =erp_products_qs.adder";
	 $code=$_GET['code'];$text=$code.$text;
	 }
	 if ($_POST['code']!="") {$code=$_POST['code'];
	
	if ($code!=""){$sql.=" where sku like'%".$code."%'  and  ebay_user.id =erp_products_qs.adder"; $text=$code.$text;}
	}
	 
	  echo $sql;
	  
    $c_p_arro=   mysql_query($sql);
	 print_r ($c_p_arro);
	 while ( $c_p_aro=mysql_fetch_array($c_p_arro))
	  {
	  echo "进入";
	  print_r($c_p_arro);
	  exit;

		   $c_p_arr[] = array('id'=>$c_p_aro['id'],
		    'code'=>$c_p_aro['title'],
			'codename'=>$c_p_aro['name'],
			'sku'=>$c_p_aro['sku'],
			'addtime'=>$c_p_aro['addtime']
);

 		}
	
	
//	print_r($c_p_arr);
   $page_total=ceil(sizeof($c_p_arr)/ROWS_PERPAGE);
   
   $page_prev=$page-1;
   $page_next=($page<$page_total) ? $page+1 : $page;
   
      if ($to>=sizeof($c_p_arr)){$to=sizeof($c_p_arr);}

   for ($i=$from;$i<$to;$i++)
   {
  
  
   
   
	 
	// while ( $c_p_aro=mysql_fetch_array($c_p_arr))
	//  {
 //	   $sqll="select  * from  erp_products_qsh where  qs_id =".$c_p_arr[$i]['id'];
				//	$c_pl=   mysql_query($sqll);
				//	echo $sqll;
		//		 $codede="<table width='100%'>";
				//	 while ( $c_pls=mysql_fetch_array($c_pl))
				//	  {
					  
					  
					  
				//   $codede.='  <tr bgcolor="#C1FEA5" style=" font-weight:bold;">
				//	 <td height="25" align="center" bgcolor="#C1FEA5"> '.$c_pls['sku'].' </td>
				//	 <td align="left">'.$c_pls['codename'].'</td>
				//	 <td align="right">'.$c_pls['number'].'</td>
					// </tr>';
					 
			//	   }
    //$codede.="</table>";
	  
   $string.='  <tr bgcolor="#C1FEA5" style=" font-weight:bold;">
     <td height="25" align="left" bgcolor="#C1FEA5"> <a href="qs.php?id='.$c_p_arr[$i]['id'].'&code='.$c_p_arr[$i]['sku'].'">'.$c_p_arr[$i]['code'].' </a></td>
     <td align="left">'.$c_p_arr[$i]['codename'].'</td>
	  <td align="left">'.$c_p_arr[$i]['addtime'].'</td>
    
	 <td align="right"> <a href="qsdel.php?cid='.$c_p_arr[$i]['id'].'"> 删除</a></td>
     </tr>';
	 
   }
 
 	 
	 
		// }

?>
<?php
$title=''.$text;
 

?>
  <h3>当前位置：<?php echo $title;?></h3>
<script src='js/ajax.js'></script>
 <table width="100%" border="0" cellpadding="3" cellspacing="1">
   
   <form action="?action=movedata" method="post" name="form_list" id="form_list" > 
   <tr bgcolor="#C1FEA5">
     <td height="25" colspan="4" align="right"><a href="javascript:void(0);" onclick="chkall(document.form_list,'all');" >
       <input name="code" type="text" id="code" value=""  style="width:120px;"/>
      <input type="submit" name="Submit6" value="筛选" />全选</a><input name="insert_new2" type="button" id="insert_new2" value="提问"  onclick="window.open('add_qs.php?sku=<? echo $code;?>','_self','')"  />| <a href="javascript:void(0);"  onclick="chkall(document.form_list,'none');">全不选</a> &nbsp;&nbsp;<a href="<?php echo url_rpls($thisurl,'page='.$page,'&page='.($page-1));?>">上一页</a> <a href="<?php echo url_rpls($thisurl,'page='.$page,'&page='.$page_next);?>">下一页</a></td>
   </tr>
   <tr bgcolor="#C1FEA5" style=" font-weight:bold;">
     <td height="25" align="center" bgcolor="#C1FEA5">问题标题 </td>
     <td align="left"> 提问人</td>
     <td align="right">提问时间</td>
	   <td align="right">操作</td>
     </tr>
   <?php echo $string;?>

   <tr bgcolor="#C1FEA5">
      <td height="25" colspan="4" align="center"><a href="<?php echo url_rpls($thisurl,'page='.$page,'&page='.($page-1));?>">上一页</a> <a href="<?php echo url_rpls($thisurl,'page='.$page,'&page='.$page_next);?>">下一页</a>  共 <font color="#FF0000" style="font-size:16px; font-weight:bold;"><?php echo $page_total;?></font></td>
    </tr>
	</form>
</table>



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