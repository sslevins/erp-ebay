<?php  
 include "include/config.php";
include "include/function.php";


include "top.php";

 $thisurl='products_op_list.php?code='.$_GET['code'].'&page='.$page.'&status='.$_GET['status'];
$text="优化列表";


	$action=$_GET['action'];
 
 if (isset($_GET['action']) && $_GET['action']=='orders_log')
     {
 	 $oID=replace_code($_GET['oID']);

 				 mysql_query("update erp_products_op set status =1    where id = ".$oID);
 	echo "ok";
		die();
	}
	
   if (isset($_GET['pID']) && $_GET['pID']!=''&&$action=='movedata' )
   {
  
     $p_arr=$_GET['pID'];
	 
	 $p_sku=$_GET['psku'];
	 $dprice=$_GET['dprice'];
	 $aprice=$_GET['aprice'];
  	 for ($i=0;$i<sizeof($p_arr);$i++)
	 {
 
		if ($_GET['pass_change']!=0)
		{
		 if ($_GET['pass_change']==200)
		 {
$reb=$_GET['reb'];
if ($reb==""){$reb=" ";}
		 mysql_query("update erp_products_op set status =3,reb='".$reb."' where id = ".$p_arr[$i]);
 		 }
		 else{

 				 mysql_query("update erp_products_op set status =1  ,passtime  ='".date('Y-m-d H:i:s',time())."' where id = ".$p_arr[$i]);
			 
			 if($_GET['sort_for_change']==100){ 		
			 
			 echo 
			  
	  @$rs=db_execute( "select goods_weight from ebay_goods where products_sku='".$p_sku[$i]."'");
	//  echo ( "select products_weight from erp_products_data where products_sku='".$_GET['sku']."'");
	//  echo $rs[0]."运费";
	$sss=6.4*($aprice[$i]+$dprice[$i])*(0.861-0.10)-0.3*6.4-get_shipping_fee_use_weight($rs['goods_weight']*0.8421);
	
			 		 mysql_query("update erp_products_op set price=" .$sss."where id = ".$p_arr[$i]);
			 }
 		}
		
		
	    }
	  }
 
 
  
  }



 $page=(int)$_GET['page'];
 if ($page==0){$page=1;}
  $from=($page-1)*ROWS_PERPAGE; 
   $to=$from+ROWS_PERPAGE;
 
	//ROWS_PERPAGE=100;
	 $sql="select  erp_products_op.id as id ,erp_products_op.*,erp_products_op.opreb,erp_products_op.aprice,erp_products_op.dprice,erp_products_op.reb, erp_products_op.sku,erp_products_op.price,erp_products_op.opprice,erp_products_op.addtime,erp_products_op.link,erp_manages.name,erp_products_data.products_value,erp_products_data.products_imagess,erp_products_data.products_name_cn from  erp_products_op,erp_manages,ebay_goods  where erp_manages.id =erp_products_op.adder and erp_products_data.products_sku =erp_products_op.sku";

	 if ($_GET['code']!=""){$sql.=" and  erp_products_op.sku ='".$_GET['code']."'   ";
	 $code=$_GET['code'];$text=$code.$text;
	 }
	  if ($_GET['code']!=""){$sql.=" and  erp_products_op.sku ='".$_GET['code']."'   ";
	 $code=$_GET['code'];$text=$code.$text;
	 }

	  if ($_GET['status']==0 && $_GET['status']==""){$sql.=" and  erp_products_op.status =0";
	 $code=$_GET['code'];$text=$code.$text;
	 }
	   if ($_GET['status']==1){$sql.=" and  erp_products_op.status =1";
	 $code=$_GET['code'];$text=$code.$text;
	 }
	    if ($_GET['status']==3){$sql.=" and  erp_products_op.status =3";
	 $code=$_GET['code'];$text=$code.$text;
	 }
	     if ($_GET['status']==2){$sql.=" and  erp_products_op.status =2 and optime>='". date("Y-m-d",time())."'";
	 $code=$_GET['code'];$text=$code.$text;
	 }
	 	     if ($_GET['status']==4){$sql.=" and  erp_products_op.status =2";
	 $code=$_GET['code'];$text=$code.$text;
	 }
	 
					 	 	 	 	  //   if ($_GET['code']!=""){$sql.=" and  erp_products_op.status =2" ;}
	 
	 
	 	 	 	     if ($_GET['status']!=""){
					 
					 	 	 	 	     if ($_GET['status']==4){$sql.=" and  erp_products_op.status =2" ;}
										 else{

					 $sql.=" and  erp_products_op.status =".$_GET['status'];}
 	 }
		 
		     if (isset($_GET['datefrom']) && $_GET['datefrom']!="" )
				   {
				   $sql.=" and   date(erp_products_op.addtime)  >='".$_GET['datefrom']."'";
				   }
		   		   if (isset($_GET['dateto']) && $_GET['dateto']!="" )
				   {
				   $sql.="    and date(erp_products_op.addtime)   <='".$_GET['dateto']."'";
				   }
			
			
			$sql.= " order by id desc";	   
 //echo $sql;
 
    $c_p_arro=   mysql_query($sql);
	 while ( $c_p_aro=mysql_fetch_array($c_p_arro))
	  {
	  
		   $c_p_arr[] = array('id'=>$c_p_aro['id'],
		    'name'=>$c_p_aro['name'],
			'price'=>$c_p_aro['price'],
			'price1'=>$c_p_aro['price1'],
			'price2'=>$c_p_aro['price2'],
			'sku'=>$c_p_aro['sku'],
			'products_name_cn'=>$c_p_aro['products_name_cn'],
			'products_value'=>$c_p_aro['products_value'],
			'products_imagess'=>$c_p_aro['products_imagess'],
 			'link'=>$c_p_aro['link'],
			'opprice'=>$c_p_aro['opprice'],
			'aprice'=>$c_p_aro['aprice'],
			'dprice'=>$c_p_aro['dprice'],
			'dl'=>$c_p_aro['dl'],
			'reb'=>$c_p_aro['reb'],
			'opreb'=>$c_p_aro['opreb'],
				'category'=>$c_p_aro['category'],
					'paypal'=>$c_p_aro['paypal'],
						'dl'=>$c_p_aro['dl'],
			'profit'=>$c_p_aro['profit'],
			'keywords'=>$c_p_aro['keywords'],
 			'addtime'=>$c_p_aro['addtime']
);
												 
		}
 
   $page_total=ceil(sizeof($c_p_arr)/ROWS_PERPAGE);
   
   $page_prev=$page-1;
   $page_next=($page<$page_total) ? $page+1 : $page;
   
      if ($to>=sizeof($c_p_arr)){$to=sizeof($c_p_arr);}

   for ($i=$from;$i<$to;$i++)
   {
    
   $string.='  <tr bgcolor="#C1FEA5" style=" font-weight:bold;">
        <td height="25" align="left"><input type="hidden" value="'.$c_p_arr[$i]['sku'].'" name="psku[]" />
		<input type="hidden" value="'.$c_p_arr[$i]['dprice'].'" name="dprice[]" />
		<input type="hidden" value="'.$c_p_arr[$i]['aprice'].'" name="aprice[]" />
		<input type="checkbox" value="'.$c_p_arr[$i]['id'].'" name="pID[]" />'.$c_p_arr[$i]['id'].'</td>


     <td height="25" align="center" bgcolor="#C1FEA5"> '.$c_p_arr[$i]['sku'].' </td>
	  <td align="left">'.$c_p_arr[$i]['products_name_cn'].'</td>
	   <td align="left"><img width="100" height="100" border="0"src="files/'.$c_p_arr[$i]['products_imagess'].'" /></td>
	    <td align="left"><a  target="_blank" href="'.$c_p_arr[$i]['link'].'">查看</a></td>
		 <td align="left">'. $c_p_arr[$i]['keywords']  .'</td><td align="left">'.number_format($c_p_arr[$i]['dprice'], 2, '.', '') .'</td><td align="left">'.number_format($c_p_arr[$i]['aprice'], 2, '.', '') .'</td><td align="left">'.number_format($c_p_arr[$i]['dl'], 2, '.', '') .'</td> <td align="left">'.number_format($c_p_arr[$i]['price1'], 2, '.', '') .'</td> <td align="left">'.number_format($c_p_arr[$i]['price2'], 2, '.', '') .'</td><td align="left">'.number_format($c_p_arr[$i]['price'], 1, '.', '') .'</td>';
if( $_GET['status']==3){$string.='<td align="left">'.$c_p_arr[$i]['reb'].'</td>'; }
 if($_GET['status']==20||$_GET['status']==40) {$string.='<td align="left">'.$c_p_arr[$i]['opreb'].'</td>'; }

	  
	    $string.=   '<td align="left">'.number_format($c_p_arr[$i]['profit'], 2, '.', '').'</td>';
		$T=$c_p_arr[$i]['category'];
		$paypal=$c_p_arr[$i]['paypal'];
		$dl=$c_p_arr[$i]['dl'];
			$sqlRMB="select * from erp_currency_info where currency_type ='￥'";
$rsRMB=db_execute($sqlRMB);
$RMB=$rsRMB['currency_value'];
		$C=getproductsfieldsusesku('products_value',$c_p_arr[$i]['sku']);
$fee=getproductsfieldsusesku('xiaobaofee',$c_p_arr[$i]['sku']);
if (($C+$fee)>0.85*50*$RMB){ }
$guahaofee=getproductsfieldsusesku('guahaofee',$c_p_arr[$i]['sku']);
$eubfee=getproductsfieldsusesku('eubfee',$c_p_arr[$i]['sku']);
if ($paypal==0.06){$oth=0.05;}else{$oth=0.3;}
$sales1=($RMB*0.96*$oth+1*$C+1*$fee+$dl*$RMB)/($RMB*0.96-0.07*$RMB-$RMB*0.96*$T-$RMB*((0.96*$paypal)));
//$sales2=($RMB*0.96*0.3+1*$C+1*$guahaofee+$dl*$RMB)/($RMB*0.96-0.07*$RMB-$RMB*0.96*$T-$RMB*0.96*$paypal);
$sales3=($RMB*0.96*$oth+1*$C+1*$eubfee+$dl*$RMB)/($RMB*0.96-0.07*$RMB-$RMB*0.96*$T-$RMB*(0.96*$paypal));
// 0.96坏货率 0.07为利润率 $oth 为paypal附加费 $fee为运费，$c 为成本 $paypal为paypal类型费用，$T为种类费用
   $times=explode(' ',$c_p_arr[$i]['addtime']); 
		 $string.=   '<td align="left">'.number_format($sales1, 2, '.', '').'</td>';
		  $string.=   '<td align="left">'.number_format($sales3, 2, '.', '').'</td>';
		   if($_GET['status']==2||$_GET['status']==4) {
		   if (   $c_p_arr[$i]['opprice']>=$c_p_arr[$i]['products_value']){
		   $string.='<td align="left"> <font color="#FF0000">'.number_format($c_p_arr[$i]['opprice'], 1, '.', '') .'</font></td>';
		   }else{$string.='<td align="left">'.number_format($c_p_arr[$i]['opprice'], 1, '.', '') .'</td>';}
		   
		    }
 $string.=   '<td align="left">'.$c_p_arr[$i]['products_value'].'</td><td align="left">'.$c_p_arr[$i]['name'].'</td>
	  <td align="left">'.
	  $times[0] 
	  .'</td>
    
	 <td align="left">
	 <input type="button" name="Submit8" value="暂无优化" onclick="edit_buyer_info('. $c_p_arr[$i]['id'].');" />
	  <a  href="add_products_op.php?cid='.$c_p_arr[$i]['id'].'"> 优化</a>';
		 if (  chkuserper(206,'PUB',$_COOKIE['id'])==1 ){  $string.= '<a  href="qdsdel.php?cid='.$c_p_arr[$i]['id'].'"> 删除</a>';}
	 $string.=' </td>
     </tr>';
	 
   }
 
		
		
	
?>
<?php
$title=''.$text;
require_once('template/html_top.php');


?>
  <h3>当前位置：<?php echo $title;?></h3>
  <script src='js/calendar.js'></script>

<script src='js/ajax.js'></script>
 <table width="100%" border="0" cellpadding="3" cellspacing="1">
   
   <form action="?action=movedata" method="get" name="form_list" id="form_list" > 
   <tr bgcolor="#C1FEA5">
     <td height="25" colspan="24" align="right">
          时间 
		  <input type="hidden" value="<? echo $status;?>" name="status" />
	   <input name="datefrom" type="text" size="10" onclick="calendar.show(this);"  />
	   至
	   <input name="dateto" type="text" size="10" onclick="calendar.show(this);" />SKU<input name="code" type="text" id="code" value=""  style="width:120px;"/>
      <input type="submit" name="Submit6" value="筛选" /><a href="javascript:void(0);" onclick="chkall(document.form_list,'all');" >全选</a> | <a href="javascript:void(0);"  onclick="chkall(document.form_list,'none');">全不选</a> &nbsp;&nbsp;<a href="<?php echo url_rpls($thisurl,'status='.$_GET['status'],'&page='.($page-1));?>">上一页</a> <a href="<?php echo url_rpls($thisurl,'status='.$_GET['status'],'&page='.$page_next);?>">下一页</a></td>
   </tr>
   <tr bgcolor="#C1FEA5" style=" font-weight:bold;">
   <td height="25" align="center" bgcolor="#C1FEA5">id </td>
     <td height="25" align="center" bgcolor="#C1FEA5">SKU </td>
	      <td height="25" align="center" bgcolor="#C1FEA5">中文名称 </td>
		  	      <td height="25" align="center" bgcolor="#C1FEA5">图片</td>
     <td align="center"> 链接</td>
     <td align="center"><strong>关键词</strong></td>
	 <td align="center">提交销价</td>
				<td align="center">运费</td>
				<td align="center">登陆费</td>
	      <td align="center">提交价0%</td>
		       <td align="center">提交价7%</td>
			    <td align="center">提交价15%</td>
			   <td align="center">公司现利润</td>
			   <td align="center">美国指导价</td>
			   <td align="center">美国EUB</td>
	 <? if( $_GET['status']==3)  {?>	 <td align="center">不通过原因</td><? }?>
	 <? if( $_GET['status']==20||$_GET['status']==40)  {?>	 <td align="center">优化备注</td><? }?>

<? if( $_GET['status']==2||$_GET['status']==4)  {?>	 <td align="center">优化价</td><? }?>
	  <td align="center">成本价</td>
	  <td align="center">提交人</td>
<td align="center">时间</td>	  
	   <td align="center">操作</td>
     </tr>
   <?php echo $string;?>

   <tr bgcolor="#C1FEA5">
      <td height="25" colspan="24" align="center"><a href="javascript:void(0);" onclick="chkall(document.form_list,'all');" >全选</a> | <a href="javascript:void(0);"  onclick="chkall(document.form_list,'none');">全不选</a><a id="bottom"></a><a href="<?php echo url_rpls($thisurl,'page='.$_GET['status'],'&page='.($page-1));?>">上一页</a> <a href="<?php echo url_rpls($thisurl,'page='.$page,'&page='.$page_next);?>">下一页</a>  共 <font color="#FF0000" style="font-size:16px; font-weight:bold;"><?php echo $page_total;?></font>  <?php if (chkuserper(174,'PUB',$_COOKIE['id'])){?>
	    <input type="submit" name="Submit71" value="审核" onclick="if(!confirm('确定要将选中项的所属状态改变吗？\r\n请留意，若下拉框的值包含在选中数据中状态时，将不作任何改变。')){return false;}" />
		
		<select name="sort_for_change">
	    <option value="0">利润</option>
 		<option value="100">10%</option>

	    </select>
		
		<select name="pass_change">
	    <option value="0">请选择</option>
	    <option value="100">通过</option>
		 <option value="200">不通过</option>
	    </select>
		
		
		  <?php }?>	 
	    不通请写原因<input name="reb" id="reb"     type="text"   style="width:60px;"   /> <input type="hidden" name="action" value="movedata" /><a href="export_op.php">导出已完成优化</a></td>
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


		


	}
	
	
	function edit_buyer_info(oID)
{
var loger=  document.getElementsByName('log_'+oID);
var loger_values=new Array();
for (i=0;i<loger.length;i++)
{
 
loger_values=loger_values.concat(loger[i].value);
}

//	var icount=document.getElementsByName('icount_'+oID);
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null){alert ("Browsers that are currently running may not support AJAX,please change other browsers.");return;}

var url="products_op_list.php?oID="+oID+"&action=orders_log";
url=encodeURI(url);
//alert(loger_values);
alert(url);
xmlHttp.onreadystatechange=function (){edit_orders_log_ajax_result(oID);};
xmlHttp.open("GET",url,true);
xmlHttp.send(null);

}

function edit_orders_log_ajax_result(oID)
{


	if(xmlHttp.readyState==4)
	{
		if(xmlHttp.status==200){
	 		                     if (xmlHttp.responseText=='ok'){alert('修改成功,请刷新界面查看.');}
						
		                       }
	}	
}	
	function chkall(f,t)
{
  els=f.elements;
  if (t=='all'){chked=true;}
  if (t=='none'){chked=false;}
  for (i=0;i<els.length;i++)
  {
     if (els[i].type=='checkbox'){els[i].checked=chked;}
  }
}
	
	
	
	</script>
<?php require_once('template/html_bottom.php');?>
