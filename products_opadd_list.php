<?php  

 include "include/config.php";
include "include/function.php";


include "top.php";


function orders_oper()
{
	 $options[] = array ('key'=>'45','text'=>'陶艳','color'=>'#ff9900');
	 $options[] = array ('key'=>'91','text'=>'田红兰','color'=>'#ff9900');
	 $options[] = array ('key'=>'94','text'=>'李新花','color'=>'#ff9900');
	 $options[] = array ('key'=>'78','text'=>'乐传炎','color'=>'#ff9900');
	 $options[] = array ('key'=>'7','text'=>'汤兰英','color'=>'#ff9900');
 	 $options[] = array ('key'=>'157','text'=>'解鲜丽','color'=>'#ff9900');
	 $options[] = array ('key'=>'146','text'=>'卢婷婷','color'=>'#ff9900');
 	 $options[] = array ('key'=>'161','text'=>'唐彭英','color'=>'#ff9900');
	 $options[] = array ('key'=>'162','text'=>'王丽梅','color'=>'#ff9900');
	 $options[] = array ('key'=>'164','text'=>'谭小丽','color'=>'#ff9900');
	 $options[] = array ('key'=>'165','text'=>'黄慧玲','color'=>'#ff9900');

 	  return $options;
}
$countrylist = orders_oper();


 $thisurl='products_opadd_list.php?code='.$_GET['code'].'&page='.$page.'&action=';
$text="产品开发列表";

$actionl=$_GET['action'];
	$action=$_POST['action'];
 if ($actionl=='chk_this_orders_status' )
 { 

	mysql_query("update erp_products_addop set status ='6',psku= '".$_GET['value']."' where  id=".$_GET['oID']);  
 die("ok");
 }
 
   if (isset($_POST['pID']) && $_POST['pID']!=''&&$action=='movedata' )
   {
  
     $p_arr=$_POST['pID'];
	 
	 $p_sku=$_POST['psku'];
	 $dprice=$_POST['dprice'];
	 $aprice=$_POST['aprice'];
  	 for ($i=0;$i<sizeof($p_arr);$i++)
	 {
 
		if ($_POST['pass_change']!=0)
		{
		 if ($_POST['pass_change']==200)
		 {
$reb=$_POST['reb'];
if ($reb==""){$reb=" ";}
		 mysql_query("update erp_products_addop set status =3,reb='".$reb."' where id = ".$p_arr[$i]);
 		 }
		 else{

			  				 mysql_query("update erp_products_addop set oper =".$_POST['pass_change']."  ,passtime  ='".date('Y-m-d H:i:s',time())."' where id = ".$p_arr[$i]);

		//	 echo ("update erp_products_addop set status =4  ,passtime  ='".date('Y-m-d H:i:s',time())."' where id = ".$p_arr[$i]);
			 if($_POST['sort_for_change']==100){ 		
			 
			  
	//  @$rs=db_execute( "select products_weight from erp_products_data where products_sku='".$p_sku[$i]."'");
	//  echo ( "select products_weight from erp_products_data where products_sku='".$_POST['sku']."'");
	//  echo $rs[0]."运费";
	//$sss=6.4*($aprice[$i]+$dprice[$i])*(0.861-0.10)-0.3*6.4-get_shipping_fee_use_weight($rs['products_weight']*0.8421);
	
			 		// mysql_query("update erp_products_addop set price=" .$sss."where id = ".$p_arr[$i]);
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
	 $sql="select  erp_products_addop.id as id ,erp_products_addop.oper ,erp_products_addop.*,erp_products_addop.opreb,erp_products_addop.aprice,erp_products_addop.dprice,erp_products_addop.reb, erp_products_addop.sku,erp_products_addop.price,erp_products_addop.opprice,erp_products_addop.addtime,erp_products_addop.link,erp_manages.name  from  erp_products_addop,erp_manages  where erp_manages.id =erp_products_addop.adder ";
	 
	  for($i=0;$i<sizeof($countrylist);$i++)
{
   
 		if( $_COOKIE['id']== $countrylist[$i]['key'] && $_COOKIE['id'] !=45 ) {$sql.="and  erp_products_addop.oper =".$_COOKIE['id'];  }
 }
 

 
   if ($_POST['opper']!=''){$sql.=" and  erp_manages.name ='".$_POST['opper']."'";}
$status==$_POST['status'];
if ($status==1)$status=0;
if ($status==4)$status=4;
	 if ($_POST['code']!=""){$sql.=" and  erp_products_addop.sku ='".$_POST['code']."'   ";
	 $code=$_POST['code'];$text=$code.$text;
	 }
	  if ($_GET['status']==0 && $_POST['status']==""){$sql.=" and  erp_products_addop.status =0";
	 $code=$_GET['code'];$text=$code.$text;
	 }
	   if ($_GET['status']==1){$sql.=" and  erp_products_addop.status =0";
	 $code=$_GET['code'];$text=$code.$text;
	 }
	    if ($_GET['status']==3){$sql.=" and  erp_products_addop.status =3";
	 $code=$_GET['code'];$text=$code.$text;
	 }
	 
	  if ($_GET['status']==6){$sql.=" and  erp_products_addop.status =6";
	 $code=$_GET['code'];$text=$code.$text;
	 }
	 
	     if ($_GET['status']==2){$sql.=" and  erp_products_addop.status =2 and optime>='". date("Y-m-d",time())."'";
	 $code=$_GET['code'];$text=$code.$text;
	 }
	 	     if ($_GET['status']==4){$sql.=" and  erp_products_addop.status =2";
	 $code=$_GET['code'];$text=$code.$text;
	 }
	 
					 	 	 	 	  //   if ($_POST['code']!=""){$sql.=" and  erp_products_addop.status =2" ;}
	 
	 
	 	 	 	     if ($_POST['status']!=""){
					 
					 	 	 	 	     if ($_POST['status']==4){$sql.=" and  erp_products_addop.status =4" ;}
										 else{

					 $sql.=" and  erp_products_addop.status =".$_POST['status'];}
 	 }
		 
		     if (isset($_POST['datefrom']) && $_POST['datefrom']!="" )
				   {
				   $sql.=" and   date(erp_products_addop.addtime)  >='".$_POST['datefrom']."'";
				   }
		   		   if (isset($_POST['dateto']) && $_POST['dateto']!="" )
				   {
				   $sql.="    and date(erp_products_addop.addtime)   <='".$_POST['dateto']."'";
				   }
				   $sqlorder=" order by id ,pcategory desc";
				   $sql.=$sqlorder;
 //echo $sql;
    $c_p_arro=   mysql_query($sql);
	 while ( $c_p_aro=mysql_fetch_array($c_p_arro))
	  {
	  
		   $c_p_arr[] = array('id'=>$c_p_aro['pcategory'].$c_p_aro['id'],
		   'iid'=> $c_p_aro['id'],
		    'cname'=> showuserinfo('name',$c_p_aro['oper'] ) ,
		    'name'=>$c_p_aro['name'],
			'price'=>$c_p_aro['price'],
			'price1'=>$c_p_aro['price1'],
			'price2'=>$c_p_aro['price2'],
			'sku'=>$c_p_aro['sku'],
			'remark'=>$c_p_aro['remark'],
			'products_name_cn'=>$c_p_aro['products_name_cn'],
			'products_value'=>$c_p_aro['products_value'],
			'products_imagess'=>$c_p_aro['products_imagess'],
 			'link'=>$c_p_aro['link'],
			'opprice'=>$c_p_aro['opprice'],
			'aprice'=>$c_p_aro['aprice'],
			'dprice'=>$c_p_aro['dprice'],
			'reb'=>$c_p_aro['reb'],
			'key'=>$c_p_aro['keyds'],
			'opreb'=>$c_p_aro['opreb'],
			'psku'=>$c_p_aro['psku'],
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
        <td height="25" align="center"><input type="hidden" value="'.$c_p_arr[$i]['sku'].'" name="psku[]" />
		<input type="hidden" value="'.$c_p_arr[$i]['dprice'].'" name="dprice[]" />
		<input type="hidden" value="'.$c_p_arr[$i]['aprice'].'" name="aprice[]" />
		<input type="checkbox" value="'.$c_p_arr[$i]['id'].'" name="pID[]" />'.$c_p_arr[$i]['id'].'</td>


     <td height="25" align="left" bgcolor="#C1FEA5"> '.$c_p_arr[$i]['sku'].' </td>
	  <td align="left">'.$c_p_arr[$i]['dprice'].'</td>
	   <td align="left">'.$c_p_arr[$i]['aprice'].'</td>
	    <td align="left"><a  target="_blank" href="'.$c_p_arr[$i]['link'].'">'.$c_p_arr[$i]['key'].'</a></td>
		 <td align="left">'.number_format($c_p_arr[$i]['price'], 1, '.', '') .'</td> <td align="left">'.number_format($c_p_arr[$i]['price1'], 1, '.', '') .'</td> <td align="left">'.number_format($c_p_arr[$i]['price2'], 1, '.', '') .'</td>';
		 $string.='<td align="left">'.$c_p_arr[$i]['remark'].'</td>'; 
if( $_GET['status']==3){$string.='<td align="left">'.$c_p_arr[$i]['reb'].'</td>'; }
 if($_GET['status']==2||$_GET['status']==4) {$string.='<td align="left">'.$c_p_arr[$i]['opreb'].'</td>'; }

 if($_GET['status']==6 ) {
	   $string.='<td align="left">'. $c_p_arr[$i]['psku']  .'</td>'; 
}
 
 $string.=   '<td align="left"><font color="red">'.$c_p_arr[$i]['opprice'].'</font></td><td align="left">'.$c_p_arr[$i]['cname'].'</td><td align="left">'.$c_p_arr[$i]['name'].'</td>
	  <td align="left">'.$c_p_arr[$i]['addtime'].'</td>
    
	 <td align="left"> <a  href="add_products_addop.php?cid='.$c_p_arr[$i]['id'].'"> 开发</a>';
	 		 $string.='  <div id="orders_status_name_'.$c_p_arr[$i]['id'].'" class="back_rz_box"></div>';

if  (chkuserper(213,'PUB',$_COOKIE['id'])==1&& $_GET['status']==4 ){
$string.= '<input type="button" name="Submit5" value="上架" onclick="chk_this_orders_status('.$c_p_arr[$i][id].')  "/>';
}  
			
	  $string.=   ' <a  href="qdsdel.php?uid='.$c_p_arr[$i]['iid'].'"> 删除</a></td>
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
   
   <form action="?action=movedata" method="post" name="form_list" id="form_list" > 
   <tr bgcolor="#C1FEA5">
     <td height="25" colspan="14" align="right">
 提交人   		  <input type="text" size="6" value="" name="opper" />
      时间 
		  <input type="hidden" value="<? echo $status;?>" name="status" />
	   <input name="datefrom" type="text" size="10" onclick="calendar.show(this);"  />
	   至
	   <input name="dateto" type="text" size="10" onclick="calendar.show(this);" />重量<input name="code" type="text" id="code" value=""  style="width:120px;"/>
      <input type="submit" name="Submit6" value="筛选" /><a href="javascript:void(0);" onclick="chkall(document.form_list,'all');" >全选</a> | <a href="javascript:void(0);"  onclick="chkall(document.form_list,'none');">全不选</a> &nbsp;&nbsp;<a href="<?php echo url_rpls($thisurl,'page='.$page,'&page='.($page-1));?>">上一页</a> <a href="<?php echo url_rpls($thisurl,'page='.$page,'&page='.$page_next);?>">下一页</a></td>
   </tr>
   <tr bgcolor="#C1FEA5" style=" font-weight:bold;">
   <td height="25" align="center" bgcolor="#C1FEA5">id </td>
     <td height="25" align="center" bgcolor="#C1FEA5">重量 </td>
	      <td height="25" align="center" bgcolor="#C1FEA5">销售价格 </td>
		  	      <td height="25" align="center" bgcolor="#C1FEA5">运费</td>
     <td align="left"> 链接</td>
     <td align="right">提交价15%</td>
	      <td align="right">提交价10%</td>
		       <td align="right">提交价7%</td>
			    <td align="right">备注</td>
	 <? if( $_GET['status']==3)  {?>	 <td align="right">不通过原因</td><? }?>
	 <? if( $_GET['status']==2||$_GET['status']==4)  {?>	 <td align="right">开发备注</td><? }?>

<? if( $_GET['status']==6 )  {?>	 <td align="right">SKU</td><? }?>
	  <td align="right">开发价</td>
	  <td align="right">采购员</td>
	  <td align="right">提交人</td>
<td align="right">时间</td>	  
	   <td align="right">操作</td>
     </tr>
   <?php echo $string;?>

   <tr bgcolor="#C1FEA5">
      <td height="25" colspan="14" align="center"><a href="javascript:void(0);" onclick="chkall(document.form_list,'all');" >全选</a> | <a href="javascript:void(0);"  onclick="chkall(document.form_list,'none');">全不选</a><a id="bottom"></a><a href="<?php echo url_rpls($thisurl,'page='.$page,'&page='.($page-1));?>">上一页</a> <a href="<?php echo url_rpls($thisurl,'page='.$page,'&page='.$page_next);?>">下一页</a>  共 <font color="#FF0000" style="font-size:16px; font-weight:bold;"><?php echo $page_total;?></font>  <?php if (chkuserper(174,'PUB',$_COOKIE['id'])){?>
	    <input type="submit" name="Submit71" value="分配" onclick="if(!confirm('确定要将选中项的所属状态改变吗？\r\n请留意，若下拉框的值包含在选中数据中状态时，将不作任何改变。')){return false;}" />
		
	 <select name="sort_for_change">
	    <option value="">采购</option>
		<?  for($i=0;$i<sizeof($countrylist);$i++)
{
?>   
 		<option value="<? echo $countrylist[$i]['key'];?>"><? echo $countrylist[$i]['text'];?></option>
<? 
 }
?>
	    </select>
 
 
 

		
	 
		
		  <?php }?>	 
	    不通请写原因<input name="reb" id="reb"     type="text"   style="width:60px;"   /> <input type="hidden" name="action" value="movedata" /></td>
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
	function chk_this_orders_statusb( oID)
	{
	  var content=document.getElementById('back_reason_'+oID).value;
   document.getElementById('orders_status_name_'+oID).innerHTML='';

	}
	function chk_this_orders_statuss( oID)
{
  var content=document.getElementById('back_reason_'+oID).value;
   document.getElementById('orders_status_name_'+oID).innerHTML='';
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null){alert ("Browsers that are currently running may not support AJAX,please change other browsers.");return;}
 var url="products_opadd_list.php?oID="+oID+"&action=chk_this_orders_status&value="+replace_code(content);
    url=encodeURI(url);
    xmlHttp.onreadystatechange=function (){edit_orders_log_ajax_result(oID);};
    xmlHttp.open("GET",url,true);

    xmlHttp.send(null);
 }
	function chk_this_orders_status( oID)
{
  
  document.getElementById('orders_status_name_'+oID).innerHTML='<div class="bak_rz"><table border="0" cellspacing="4" cellpadding="0" width="100%"><tr><td colspan="2"><textarea name="back_reason_'+oID+'" id="back_reason_'+oID+'" style="width:180px; height:60px;"></textarea></td></tr>  <tr><td align="left">SKU</td>    <td><input type="button" name="Submit" value="确定" onclick="chk_this_orders_statuss('+oID+');"><input type="button" name="Submit2" value="放弃" onclick="chk_this_orders_statusb('+oID+');"></td></tr></table></div>';
 
}

function edit_orders_log_ajax_result(oID)
{

	if(xmlHttp.readyState==4)
	{
		if(xmlHttp.status==200){
 		                     if (xmlHttp.responseText=='ok'){alert('成功,请刷新界面查看.'); }
							  if (xmlHttp.responseText=='okkkkk'){alert('订单状态不允许操作.');}
							  if (xmlHttp.responseText=='iiii'){alert('重量大于2KG.');}
							   if (xmlHttp.responseText=='oks'){alert('挂号码为空.');}
							   if (xmlHttp.responseText=='okkkk'){alert('挂号修改成功.请刷新界面查看.');}
		                       }
	}	 
}

	</script>
<?php require_once('template/html_bottom.php');?>
