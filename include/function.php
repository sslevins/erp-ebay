<?php
 function replacetable($str,$value,$cid,$table)
{
   $rs=mysql_fetch_array(mysql_query("select $str from $table where $cid='".$value."'"));
   if (!empty($rs))
   $string = $rs[0];
 	  return $string;
	  
 }

function replacecostsv($str,$value)
{
if ($str=='cost')
   {
   $rs=mysql_fetch_array(mysql_query("select products_value from erp_products_data where products_sku='".$value."'"));
   if (!empty($rs))
   $string = $rs[0];
   }
elseif($str=='products_weight')
   {
   $rs=mysql_fetch_array(mysql_query("select products_weight from erp_products_data where products_sku ='".$value."'"));
   if (!empty($rs))
     $string =   get_shipping_fee_use_weight($rs[0]);
   }
   return $string;
}


function productcreategory($psku,$productsvalue)
{
$rs_acc=mysql_query("select * from erp_products_category");
  
  while (@$rb=mysql_fetch_array($rs_acc))
  {
  if ($rb['lower']<$productsvalue&&$productsvalue<=$rb['limit'])
  {
  $sqlll="update erp_products_data set productcategory=".$rb['id']." where products_sku='".$psku."'";
  mysql_query($sqlll);
   }
    }
}

function getproductcreategory($psku)
{
$rs_acc=mysql_query("select * from erp_products_category where id =".$psku);
  
  while (@$rb=mysql_fetch_array($rs_acc))
  {
  return $rb['name'];
  
    }
}

function jksku($products_sku)
{
$days=10;
//date(od.orders_export_time)  >= '".date('Y-m-d',time()-$seconds)."'
$seconds=$days*86400;
$sqlre= "select sum(orders_record_count) as  count from erp_orders_record  where  orders_record_time >= '".date('Y-m-d',time()-$seconds)."' and orders_record_status=1 and products_sku='".$products_sku."'";

//echo "select count(item_count) from erp_orders_products where orders_sku ='A512' and erp_orders_id 	in (select erp_orders_id from erp_orders where orders_export_time >= '".date('Y-m-d',time()-$seconds)."')";


 $sqlrec= "select sum(erp_orders_products.item_count) as count from erp_orders_products,erp_orders where     erp_orders_products.erp_orders_id =erp_orders.erp_orders_id and

 erp_orders_products.orders_sku ='".$products_sku."' and  erp_orders.orders_export_time >= '".date('Y-m-d',time()-$seconds)."'";
 
  $sqlrecd= "select erp_orders.orders_export_time from erp_orders_products,erp_orders where     erp_orders_products.erp_orders_id =erp_orders.erp_orders_id and

 erp_orders_products.orders_sku ='".$products_sku."' and  erp_orders.orders_export_time >= '".date('Y-m-d',time()-$seconds)."' order by erp_orders.orders_export_time desc limit 1";
 
   $sqlrecc= "select erp_orders.orders_export_time from erp_orders_products,erp_orders where     erp_orders_products.erp_orders_id =erp_orders.erp_orders_id and

 erp_orders_products.orders_sku ='".$products_sku."' and  erp_orders.orders_export_time >= '".date('Y-m-d',time()-$seconds)."' order by erp_orders.orders_export_time asc limit 1";
	  $rsd=   db_execute ($sqlrecd);
	  $rsc=   db_execute ($sqlrecc);
	  $tian=ceil((strtotime($rsd[0])-strtotime($rsc[0]))/3600/24);
	  if ($tian ==0 ){$tian=1;}
     $listc =mysql_query($sqlre);
	$listd =mysql_query($sqlrec);
	
		  while ($rs=mysql_fetch_array($listc))
	  {
	     //echo "ok<br>";
		 $menu=$rs['count'];
	  }
	  
	  		  while ($rsb=mysql_fetch_array($listd))
	  {
	     //echo "ok<br>";
		 $menub=$rsb['count'];
	  }
	  
	  //return $menu;
	$daysd=7;
//date(od.orders_export_time)  >= '".date('Y-m-d',time()-$seconds)."'
$secondsd=$daysd*86400;
	$spsql="select * from erp_purchasespecial where  datetime>= '".date('Y-m-d',time()-$secondsd)."' and sku= '".$products_sku."'";
	//echo $spsql;
	 	$spsqld =mysql_query($spsql);
	
		  while ($sp=mysql_fetch_array($spsqld))
	  {
	     //echo "ok<br>";
		 $spmber=$spmber+$sp['nmber'];
	  }
	  $menu=$menu- $spmber;
	 
	   $sqlpar="select products_cg  from erp_products_data where products_sku  ='".$products_sku."' " ;
	  $rs=   db_execute ($sqlpar);
	  if ($rs[0]==0)
	  {
	
	 $men= ceil(($menub+$menu)/$tian)*15;
}else
{
	 $men= ceil(($menub+$menu)/$tian)*($rs[0]+3);
}

//  $sqlpar="select *  from erp_products_data where products_sku  ='".$products_sku."' and products_unreal<".$men;
//echo $sqlpar;
//$lisd =mysql_query($sqlpar);
	
		//  while ($rsu=mysql_fetch_array($lisd))
	//  {
	     //echo "ok<br>";
		 $sqlpa="update erp_products_data set early=1 ,safety=".$men. " where products_sku  ='".$products_sku."' and products_printcount<".$men;
		  $sqlpab="update erp_products_data set early=2 ,safety=".$men. " where products_sku  ='".$products_sku."' and products_printcount>".$men;
 
		 mysql_query($sqlpa);
		  mysql_query($sqlpab);
	//  }
	  
 
//print_r($listc);
//echo $listc[0]['count'];

//$listcount =$listc[0]['count']+$listc[0]['count'];
}

function chksignin(){if ($_COOKIE["id"]!='' && $_COOKIE['username']!='') return true;}
function db_execute($sql_str){return mysql_fetch_array(mysql_query($sql_str));}
function formatstr($str){return $str;}
function p($str){if (!is_numeric($str)){if(!empty($str)){return "'".$str."'";}else{return "NULL";}}else{return $str;}}
function showusername($id){$rs=db_execute("select name from erp_manages where id=".$id);return $rs[0];}
function showuserinfo($fileds,$id){$rs=db_execute("select ".$fileds." from erp_manages where id=".$id);return $rs[0];}
function showsalesinfo($fileds,$id){$rs=db_execute("select ".$fileds." from erp_sales where ebayaccount='".$id."'");return $rs[0];}

function loadmenu($user_id)
{
$menu='';
if (is_numeric($user_id))
   {
      $rs_arr=mysql_query("select * from erp_user_permission as u_p,erp_permission as p where u_p.group_type='PUB' AND u_p.user_id=".$user_id." and p.permission_type=1 and p.permission_off_on=1 and u_p. group_permission_id=p.permission_id order by p.permission_order ");
	  while ($rs=mysql_fetch_array($rs_arr))
	  {
	     //echo "ok<br>";
		 $menu.='<li><a href="'.$rs['permission_url'].'" target="content">'.$rs['permission_name'].'</a></li>';
	  }
	  return $menu;
   }
}

function checkpermission($str,$type)
{
  if ($str!='')
  {
    $rs=db_execute("select count(*) as co from erp_user_permission where group_permission_id=".$str." and group_type='".$type."' and user_id=".$_COOKIE['id']."");
	if ($rs[0]>0) {return true;}
	else {return false;} 
  }
  else
  {
    return false;
  }
}

function url_rpls($url,$keysearch,$keyreplace)
{

if (is_numeric(strpos($url,$keysearch)))
{
$str=str_replace($keysearch,'',$url);
}
else
{
$str=$url;
}

//$str=str_replace($keysearch,'',$url);
//$str=str_replace('?&','?',$str);
$str=$str.$keyreplace;
$str=str_replace('?&','?',$str);
$str=str_replace('&&','&',$str);
return $str;
}

function get_category_name($id)
{
 $rs=db_execute("select category_name from erp_category where category_id=".$id);
 return $rs['category_name'];
}
//价格计算模块，为计算准确，在Ebay与网站的产品计算价格时，$v的值为产品成本价与运费之和。
function price_website($v)
{
$price=$v*(1+INTEREST_RATE_WEB)*(1+TAX_RATE)*(1+FEE_RATE);
$price = $price/EXCHANGE_RATE;
return $price;
}

function price_ebay($v)
{
$price_rate_1=(1-(CUSTOM_RATE_1+CUSTOM_RATE_2)*(1+INTEREST_RATE_EBAY));
$price_rate_2=(CUSTOM_RATE_3*EXCHANGE_RATE+1/DEAL_RATE*FEE_REGISTER*EXCHANGE_RATE+$v)*(1+INTEREST_RATE_EBAY);
$price=$price_rate_2/$price_rate_1;
$price = $price/EXCHANGE_RATE;
return $price;
}

function price_ali($v)
{
$price = $v*(1+INTEREST_RATE_ALI)*(1+TAX_RATE);
$price = $price/EXCHANGE_RATE;
return $price;
}

function shipping_fee($weight)
{
  $price = SHIPPING_FEE * $weight;
  return $price;
}

function run_sql_with($array,$action,$table)
{
  $n=sizeof($array);
  $sql='';
  $sql_keys=array_keys($array);
  $sql_values=array_values($array);
  
  if ($action=='insert')
  {
    $sql_1=" insert into ".$table." ( ";
	$sql_2=" values ( ";
    for ($i=1;$i<$n;$i++)
	{	  
	    if ($i<$n-1)
		{$sql_1.= $sql_keys[$i].' , ';}
	    else
		{$sql_1.= $sql_keys[$i];}
			  
	    if ($i<$n-1)
		{$sql_2.= p($sql_values[$i]).' , ';}
	    else
		{$sql_2.= p($sql_values[$i]);}			  
	}
	$sql=$sql_1." ) ".$sql_2." ) ";
  }
  elseif ($action=='update')
  { 
    $sql_1=" update ".$table." set ";
    for ($i=1;$i<$n;$i++)
	{  
	    if ($i<$n-1)
		{$sql_1.= $sql_keys[$i].' = '.p($sql_values[$i]).' , ';}
	    else
		{$sql_1.= $sql_keys[$i].' = '.p($sql_values[$i]).' ';}
	}	
	$sql=$sql_1." where ". $sql_keys[0]." = " .p($sql_values[0]);
  }
  return $sql;
}
function getproductsfields($fields,$key)
{
  if (is_numeric($key) && $key!=0)
  {
    $rs=db_execute("select ".$fields." from erp_products_data where products_id=".$key);
	return $rs[0];
  }
  else{return '';}
}

function getproductsfieldsusesku($fields,$sku)
{
    $rs=db_execute("select ".$fields." from erp_products_data where products_sku='".$sku."'");
	return $rs[0];
}

function getsystemfields($fields,$key)
{
  if (is_numeric($key) && $key!=0)
  {
    $rs=db_execute("select ".$fields." from erp_system where system_value_id=".$key);
	return $rs[0];
  }
  else{return '';}
}

function getmanagefields($fields,$key)
{
  if (is_numeric($key) && $key!=0)
  {
    $rs=db_execute("select ".$fields." from erp_manages where id=".$key);
	return $rs[0];
  }
  else{return '';}
}

function chkuserper($id,$typ,$usr)
{
$rb=db_execute("select count(*) as co from erp_user_permission where group_permission_id=".$id." and group_type='".$typ."' and user_id=".$usr);
if ($rb['co']>0){return true;}
}

function chkcatecount($cID)
{
@$rs=db_execute("select count(*) as co from erp_category where category_parent_id=".$cID);
if ($rs['co']>0 ){return true;}else{return false;}
}

function showcategorylist($cate_id,$left,$forcheck)
{
  
  $left+=2;
  $rs_arr=mysql_query("select * from erp_category where category_parent_id =".(int)$cate_id);
  while ($rs=mysql_fetch_array($rs_arr))
  {
  $cID=(isset($_GET['cID']) && $_GET['cID']!='') ?  (int)$_GET['cID'] : 0;
  $checked= (chkuserper($rs['category_id'],'PRO',$cID)) ? 'checked' : '';
  $text='<div style="padding-left:'.$left.'em;">';
  $text .= '<div><input name="permission_id_pro[]" type="checkbox" id="'.$forcheck.$rs['category_id'].'" value="'. $rs['category_id'].'" '.$checked.' onclick="checkthisall(\''.$forcheck.$rs['category_id'].'_\',this);" /><label for="'.$forcheck.$rs['category_id'].'">'.$rs['category_name'].'</label></div>';
  $text.='</div>';
  echo $text;
  if (chkcatecount($rs['category_id']))
     { 
	   showcategorylist($rs['category_id'],$left,$forcheck.$rs['category_id'].'_');
	 } 
  }
}

function keywd_setting($str)
{
$str_arr=explode(' ',$str);
$str_new_arr = array();
for ($i=0;$i<sizeof($str_arr);$i++)
    {
	 if (strlen($str_arr[$i])>=KEYWORD_MIN)
	    {
		$str_new_arr[] = array('keywd'=>$str_arr[$i]);
		}
	}
$str_arr_2 = array_values($str_new_arr);
return ($str_arr_2);
}

function sql_setting($get,$fields)
{
$str_new_arr=keywd_setting($get);
if (sizeof($str_new_arr)>0)
{
for ($o=0;$o<sizeof($str_new_arr);$o++)
    {
		  if ($o<sizeof($str_new_arr)-1)
		     {
			   $sql.=$fields." like '%".$str_new_arr[$o]['keywd']."%' and ";
			 }
		  else
		     {
			   $sql.=$fields." like '%".$str_new_arr[$o]['keywd']."%' ";
			 }  
	}
$sql=' where '.$sql;
}
else
{
$sql='';
}
return $sql;
}


function rplscolor($rpls,$search)
{ 

$str_new_arr=keywd_setting($rpls);
$str=$search;
if (sizeof($str_new_arr)>0)
{
for ($o=0;$o<sizeof($str_new_arr);$o++)
    {
      $str_rpls='<font color="#ff0000"><b>'.$str_new_arr[$o]['keywd'].'</b></font>';
      $str=str_ireplace($str_new_arr[$o]['keywd'],$str_rpls,$str); 
	}
}
return $str;
}

function chkpsd($str)
{
@$rs=db_execute("select password from erp_manages where id=".$_COOKIE['id']);
if (md5($str)==$rs['password']){return true;}else{return false;}
}

function get_totals_fields($fields,$id)
{
@$rs=db_execute("select ".$fields." from erp_get_totals where get_totals_id=".$id);
return $rs[0];
}

function get_totals_fields_use_sku($fields,$sku)
{
$rs=db_execute("select ".$fields." from erp_get_totals where get_totals_sku='".$sku."' order by get_totals_time desc limit 0,1");
return $rs[0];
}
//function get_totals_prev($sku)
//{
//@$rs=db_execute("select (get_totals_storage_real+get_totals_add_count) as co from erp_get_totals where get_totals_sku='".$sku."' order by get_totals_id desc limit 0,1");
//return (int)$rs[0];
//}


function get_totals_unreal($sku)
{
@$rs_input=db_execute("select sum(orders_record_count) from erp_orders_record where products_sku='".$sku."'  and orders_record_status=1 and orders_record_time >= '".get_totals_fields_usesku_1('get_totals_time',$sku)."'");
@$rs_output=db_execute("select sum(orders_record_count) from erp_orders_record where products_sku='".$sku."' and orders_record_status=2 and orders_record_time >= '".get_totals_fields_usesku_1('get_totals_time',$sku)."'");
$storage=getproductsfieldsusesku('products_storage',$sku)+$rs_input[0]-$rs_output[0];
return $storage;
}

function get_totals_unreal_bb($sku,$count)
{
 
// echo "#####".$count."###";

$storage=getproductsfieldsusesku('products_storage',$sku)-$count;
 //echo "%%%%%".$storage."%%%";
return $storage;
}
function get_totals_unreal_print($sku,$count)
{
 
// echo "#####".$count."###";
$storage=getproductsfieldsusesku('products_printcount',$sku)-$count;
 //echo "%%%%%".$storage."%%%";
return $storage;
}


function chkskuisnotnull($sku)
{
@$rs=db_execute("select count(*) as co from erp_products_data where products_sku='".$sku."'");
return (int)$rs[0];
}
function chkskusuccess()
{
global $sku_arr;
global $count_arr;
global $reason_arr;

$string='<table width="100%" border="0" cellspacing="1" cellpadding="3"><tr bgcolor="#dddddd"><td>SKU号</td><td>操作结果</td><td>操作说明</td>';
for ($o=0;$o<sizeof($sku_arr);$o++)
    {
	   //$err_string='';
       if($sku_arr[$o]!='')
	     {
		    $string.='<tr bgcolor="#eeeeee"><td>'.$sku_arr[$o].'</td>';
			if (chkskuisnotnull($sku_arr[$o])>0 && is_numeric($count_arr[$o]) && (int)$count_arr[$o]>0 && $reason_arr[$o]!='')
			   {
			   $string.='<td><font color="#009900">成功!</font></td><td>';
			   }
			else{
			      $string.='<td><font color="#ff0000">失败!</font></td><td>';
				  
			      if(chkskuisnotnull($sku_arr[$o])<=0)
			        {
			         $string.='<li>SKU号不存在</li>';
			        }
				  if((int)$count_arr[$o]<=0)
			        {
			         $string.='<li>出/入库数量值为空或不是数字</li>';
			        }
				  if($reason_arr[$o]=='')
			        {
			         $string.='<li>出/入库原因为必填</li>';
			        }
			    }
			  $string.='</td></tr>';
		 }
    }
 $string.='<tr><td colspan="3"><font color="red">*请不要刷新页面，立刻记录失败操作的SKU号，根据失败原因检查数据，并重新对失败的数据进行出/入库操作(已自动过滤SKU号留空的记录)。</font></td></tr></table>';
 return $string;
}

function get_totals_fields_usesku($fields,$sku)
{
@$rs=db_execute("select ".$fields." from erp_get_totals where get_totals_sku='".$sku."'");
return $rs[0];
}

function get_totals_fields_usesku_1($fields,$sku)
{
@$rs=db_execute("select ".$fields." from erp_get_totals where get_totals_sku='".$sku."' and get_totals_add_count=1 order by get_totals_time desc limit 0,1 ");
return $rs[0];
}

function update_products_unreal($sku)
{
mysql_query("update erp_products_data set products_unreal=".get_totals_unreal($sku)." where products_sku='".$sku."'");
}

function get_totals_id($sku)
{
if(get_totals_fields_usesku(' count(*) as co ',$sku)<=0)
  {
  /*mysql_query("insert into erp_get_totals (get_totals_sku,get_totals_time,get_totals_storage_real,get_totals_storage_unreal,get_totals_reason,get_totals_year,get_totals_month,user_id,get_totals_add_count) values 
  ('".$sku."','".date('Y-m-d H:i:s',time())."',".getproductsfieldsusesku('products_storage',$sku).",".getproductsfieldsusesku('products_storage',$sku).",'库存初使化',".idate('Y',time()).",".idate('m',time()).",'".$_COOKIE['id']."',1)");
  */
  }

if (getproductsfieldsusesku('products_unreal',$sku)!= get_totals_unreal($sku)){update_products_unreal($sku);}

@$rs=db_execute("select get_totals_id from erp_get_totals where get_totals_sku='".$sku."' order by get_totals_id desc limit 0,1 ");
return (int)$rs[0];
}

function get_totals_id_for_export($sku)
{
@$rs=db_execute("select get_totals_id from erp_get_totals where get_totals_sku='".$sku."' order by get_totals_id desc limit 0,1 ");
return (int)$rs[0];
}

function lockstorage($value){mysql_query("update erp_system set system_value=".$value." where system_value_id=17");}
function chkstoragestatus(){if (UPDATE_STORAGE!=1){die('盘点呢，过会儿再过来，等不急了就去找录入盘点值的那位问一下。');}}
function spe_status_select()
{
     $options[] = array ('key'=>'1','view'=>'先不发货，等确认','color'=>'#006600');
	 $options[] = array ('key'=>'2','view'=>'永不发货，已撤单','color'=>'#FF6600');
	 $options[] = array ('key'=>'3','view'=>'其它要求或说明:','color'=>'#CC0000');
	 return $options;
}
function orders_status_back()
{
	 $options[] = array ('key'=>'1','text'=>'无法追踪','color'=>'#ff9900');
	 $options[] = array ('key'=>'5','text'=>'未妥投','color'=>'#ff9900');
	 $options[] = array ('key'=>'6','text'=>'妥投错误','color'=>'#ff9900');
	 $options[] = array ('key'=>'7','text'=>'中国妥投','color'=>'#ff9900');

	 $options[] = array ('key'=>'2','text'=>'已回公司','color'=>'#ff9900');
	 $options[] = array ('key'=>'3','text'=>'买家退回','color'=>'#ff9900');
	  $options[] = array ('key'=>'4','text'=>'仓库返单','color'=>'#ff9900');
	  return $options;
}
function orders_status_select()
{
	 $options[] = array ('key'=>'1','text'=>'新录入','color'=>'#ff9900');
	 $options[] = array ('key'=>'2','text'=>'不通过','color'=>'#ff0000');
	 $options[] = array ('key'=>'3','text'=>'已通过','color'=>'#009900');
	 $options[] = array ('key'=>'4','text'=>'已打印','color'=>'#000000');
	 $options[] = array ('key'=>'5','text'=>'已发货','color'=>'#666666');
	 $options[] = array ('key'=>'6','text'=>'亏本撤单','color'=>'#0000FF');
	 $options[] = array ('key'=>'8','text'=>'缺货','color'=>'red');
	 $options[] = array ('key'=>'9','text'=>'满货','color'=>'#000000');
     $options[] = array ('key'=>'10','text'=>'等待主管审核','color'=>'#000000');
	 $options[] = array ('key'=>'16','text'=>'库存撤单','color'=>'#0000FF');
	 	 $options[] = array ('key'=>'17','text'=>'客服撤单','color'=>'#0000FF');
	 	 $options[] = array ('key'=>'15','text'=>'亏本撤单','color'=>'#0000FF');
 	// $options[] = array ('key'=>'26','text'=>'客服处理','color'=>'#000000');
	// $options[] = array ('key'=>'24','text'=>'待打印','color'=>'#000000');
	 $options[] = array ('key'=>'28','text'=>'已发货时间','color'=>'#000000');
	  $options[] = array ('key'=>'18','text'=>'黑名单','color'=>'#000000');
	  	 // $options[] = array ('key'=>'23','text'=>'邮局退回','color'=>'#000000');

	 return $options;
}
function orders_status_tracking()
{
/*
$options[] = array ('key'=>'Israel','text'=>'1','color'=>'#ff9900');
$options[] = array ('key'=>'Russian Federation','text'=>'2','color'=>'#ff9900');
$options[] = array ('key'=>'Portugal','text'=>'3-fly','color'=>'#ff9900');
$options[] = array ('key'=>'Greece','text'=>'4-fly','color'=>'#ff9900');
$options[] = array ('key'=>'Norway','text'=>'5-fly','color'=>'#ff9900');
$options[] = array ('key'=>'Czech Republic','text'=>'6-fly','color'=>'#ff9900');
$options[] = array ('key'=>'Lithuania','text'=>'7-fly','color'=>'#ff9900');
$options[] = array ('key'=>'Ukraine','text'=>'8-fly','color'=>'#ff9900');
$options[] = array ('key'=>'Cyprus','text'=>'7-fly','color'=>'#ff9900');
$options[] = array ('key'=>'Singapore, Republic of','text'=>'8-fly','color'=>'#ff9900');
$options[] = array ('key'=>'Estonia','text'=>'9-fly','color'=>'#ff9900');
$options[] = array ('key'=>'Malta','text'=>'10-fly','color'=>'#ff9900');
$options[] = array ('key'=>'Sri Lanka','text'=>'11-fly','color'=>'#ff9900');
$options[] = array ('key'=>'Malaysia','text'=>'12-fly','color'=>'#ff9900');
$options[] = array ('key'=>'Mexico','text'=>'13-fly','color'=>'#ff9900');
$options[] = array ('key'=>'Latvia','text'=>'14-fly','color'=>'#ff9900');
$options[] = array ('key'=>'Slovakia','text'=>'15-fly','color'=>'#ff9900');
$options[] = array ('key'=>'Indonesia','text'=>'15-fly','color'=>'#ff9900');
$options[] = array ('key'=>'South Africa','text'=>'15-fly','color'=>'#ff9900');
$options[] = array ('key'=>'Philippines','text'=>'15-fly','color'=>'#ff9900');
$options[] = array ('key'=>'Peru','text'=>'15-fly','color'=>'#ff9900');
$options[] = array ('key'=>'United Arab Emirates','text'=>'15-fly','color'=>'#ff9900');
$options[] = array ('key'=>'Brunei Darussalam','text'=>'15-fly','color'=>'#ff9900');
$options[] = array ('key'=>'APO/FPO','text'=>'15-fly','color'=>'#ff9900');
$options[] = array ('key'=>'Japan','text'=>'16-fly','color'=>'#ff9900');*/
$options[] = array ('key'=>'ACB','text'=>'16-fly','color'=>'#ff9900');
 return $options;
}
function orders_status_selectsku()
{/*
$options[] = array ('key'=>'BR419','text'=>'tywseller','color'=>'#ff9900');
$options[] = array ('key'=>'L493','text'=>'planemodel55','color'=>'#ff9900');
$options[] = array ('key'=>'Y528','text'=>'wholesale_xq','color'=>'#ff9900');
$options[] = array ('key'=>'J502','text'=>'Onzway2010','color'=>'#ff9900');
$options[] = array ('key'=>'BS313','text'=>'BQY99','color'=>'#ff9900');
$options[] = array ('key'=>'Y589','text'=>'Demon99','color'=>'#ff9900');
$options[] = array ('key'=>'KOKO-D011','text'=>'uklight','color'=>'#ff9900');
$options[] = array ('key'=>'Y527','text'=>'uklight','color'=>'#ff9900');
$options[] = array ('key'=>'BR420','text'=>'uklight','color'=>'#ff9900');
$options[] = array ('key'=>'AH409','text'=>'uklight','color'=>'#ff9900');
$options[] = array ('key'=>'BR413','text'=>'uklight','color'=>'#ff9900');
$options[] = array ('key'=>'BR430','text'=>'uklight','color'=>'#ff9900');
$options[] = array ('key'=>'BR414','text'=>'uklight','color'=>'#ff9900');
$options[] = array ('key'=>'BS314','text'=>'uklight','color'=>'#ff9900');
$options[] = array ('key'=>'Y529','text'=>'uklight','color'=>'#ff9900');
$options[] = array ('key'=>'BY531','text'=>'uklight','color'=>'#ff9900');
$options[] = array ('key'=>'BR431','text'=>'uklight','color'=>'#ff9900');*/
$options[] = array ('key'=>'BR40001','text'=>'uklight','color'=>'#ff9900');
  	 return $options;
}
function orders_status_selecteub()
{
/*
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'ukligkts','color'=>'#ff9900');
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'e_zorro','color'=>'#ff9900');
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'uklight','color'=>'#ff9900');
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'tywseller','color'=>'#ff9900');
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'planemodel55','color'=>'#ff9900');
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'wholesale_xq','color'=>'#ff9900');
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'Onzway2010','color'=>'#ff9900');
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'BQY99','color'=>'#ff9900');
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'Demon99','color'=>'#ff9900');
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'uklight','color'=>'#ff9900');
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'market989','color'=>'#ff9900');
 $options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'hola-fly','color'=>'#ff9900');
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'seemmy999','color'=>'#ff9900');
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'tosell7','color'=>'#ff9900');
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'goetc','color'=>'#ff9900');
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'cityin168','color'=>'#ff9900');
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'usa-pha','color'=>'#ff9900');
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'YKS-battery','color'=>'#ff9900');
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'planemodel99','color'=>'#ff9900');
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'paq999','color'=>'#ff9900');
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'toymodel888','color'=>'#ff9900');
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'toymodel99','color'=>'#ff9900');
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'supermarket235','color'=>'#ff9900');
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'Demon-1','color'=>'#ff9900');
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'Demon-2','color'=>'#ff9900');
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'demonerrr','color'=>'#ff9900');
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'Abeyerr','color'=>'#ff9900');
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'2xcheap2010','color'=>'#ff9900');
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'epatchpark','color'=>'#ff9900');
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'hotzone2009','color'=>'#ff9900');
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'fast_ship11','color'=>'#ff9900');		 
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'danke-fly','color'=>'#ff9900');
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'tosell22','color'=>'#ff9900');
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'helipad000','color'=>'#ff9900');
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'cicipark2010','color'=>'#ff9900');
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'ego-2010','color'=>'#ff9900');
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'hkpowerseller','color'=>'#ff9900');
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'tosell66','color'=>'#ff9900');
$options[] = array ('key'=>'United States,USA,US,Puerto Rico,APO/FPO','text'=>'wanshishun8882010','color'=>'#ff9900');
*/
$sql="select * from erp_eub_account where 1=1";
 $rs_acc=mysql_query( $sql);
  while (@$rb=mysql_fetch_array($rs_acc))
  {
 
  $options[] = array ('key'=>$rb[country],'text'=>$rb[account],'color'=>'#ff9900');

  }


	 return $options;
}

function web_orders_status_select()
{
     $options[] = array ('key'=>'1','view'=>'线下交易','color'=>'#006600','box'=>'pay');
	 $options[] = array ('key'=>'2','view'=>'补货','color'=>'#FF6600','box'=>'resend');
	 $options[] = array ('key'=>'3','view'=>'阿里巴巴','color'=>'#CC0000','box'=>'pay');
	 $options[] = array ('key'=>'4','view'=>'efox','color'=>'#CC0000','box'=>'pay');
	 return $options;
}

function shipped_servers_select()
{
     $options[] = array ('key'=>'1','view'=>'八卦岭邮局','color'=>'#006600','box'=>'ba');
	 $options[] = array ('key'=>'2','view'=>'坂田邮局','color'=>'#FF6600','box'=>'ban');
	// $options[] = array ('key'=>'3','view'=>'香港平邮小包','color'=>'#CC0000','box'=>'xiang');
	 $options[] = array ('key'=>'5','view'=>'沙河邮局','color'=>'#CC0000','box'=>'sha');
	 // $options[] = array ('key'=>'6','view'=>'彩联平邮','color'=>'#CC0000','box'=>'cai');

	 $options[] = array ('key'=>'4','view'=>'其它方式','color'=>'#CC0000','box'=>'qi');
	 return $options;
}
function shipped_serversh_select()
{
//香港平邮小包
     $options[] = array ('key'=>'7','view'=>'英国','color'=>'#006600','box'=>'ba');
	 $options[] = array ('key'=>'8','view'=>'美国','color'=>'#FF6600','box'=>'ban');
 	 $options[] = array ('key'=>'9','view'=>'其它国家','color'=>'#CC0000','box'=>'sha');
  	 return $options;
}
function shipped_servershcb_select()
{
//香港平邮小包
     $options[] = array ('key'=>'90','view'=>'英国','color'=>'#006600','box'=>'ba');
	 $options[] = array ('key'=>'91','view'=>'美国','color'=>'#FF6600','box'=>'ban');
 	 $options[] = array ('key'=>'92','view'=>'其它国家','color'=>'#CC0000','box'=>'sha');
  	 return $options;
}

function shipped_serverss_select()
{
//赛维博
     $options[] = array ('key'=>'10','view'=>'10克-100克','color'=>'#006600','box'=>'ba');
	 $options[] = array ('key'=>'11','view'=>'101克-200克','color'=>'#FF6600','box'=>'ban');
	 $options[] = array ('key'=>'12','view'=>'201克-300克','color'=>'#CC0000','box'=>'xiang');
	 $options[] = array ('key'=>'13','view'=>'301克-400克','color'=>'#CC0000','box'=>'sha');
	 $options[] = array ('key'=>'14','view'=>'401克-500克','color'=>'#CC0000','box'=>'cai');
	  $options[] = array ('key'=>'15','view'=>'501克-600克','color'=>'#CC0000','box'=>'sai');
	 $options[] = array ('key'=>'16','view'=>'601克-700克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'17','view'=>'701克-800克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'18','view'=>'801克-900克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'19','view'=>'901克-1000克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'20','view'=>'1001克-1100克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'21','view'=>'1101克-1200克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'22','view'=>'1201克-1300克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'23','view'=>'1301克-1400克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'24','view'=>'1401克-1500克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'25','view'=>'1501克-1600克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'26','view'=>'1601克-1700克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'27','view'=>'1701克-1800克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'28','view'=>'1801克-1900克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'29','view'=>'1901克-2000克','color'=>'#CC0000','box'=>'qi');
	 return $options;
}



function shipped_serversb_select()
{
//万色速递
     $options[] = array ('key'=>'30','view'=>'10克-100克','color'=>'#006600','box'=>'ba');
	 $options[] = array ('key'=>'31','view'=>'101克-200克','color'=>'#FF6600','box'=>'ban');
	 $options[] = array ('key'=>'32','view'=>'201克-300克','color'=>'#CC0000','box'=>'xiang');
	 $options[] = array ('key'=>'33','view'=>'301克-400克','color'=>'#CC0000','box'=>'sha');
	 $options[] = array ('key'=>'34','view'=>'401克-500克','color'=>'#CC0000','box'=>'cai');
	  $options[] = array ('key'=>'35','view'=>'501克-600克','color'=>'#CC0000','box'=>'sai');
	 $options[] = array ('key'=>'36','view'=>'601克-700克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'37','view'=>'701克-800克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'38','view'=>'801克-900克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'39','view'=>'901克-1000克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'40','view'=>'1001克-1100克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'41','view'=>'1101克-1200克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'42','view'=>'1201克-1300克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'43','view'=>'1301克-1400克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'44','view'=>'1401克-1500克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'45','view'=>'1501克-1600克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'46','view'=>'1601克-1700克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'47','view'=>'1701克-1800克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'48','view'=>'1801克-1900克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'49','view'=>'1901克-2000克','color'=>'#CC0000','box'=>'qi');
	 return $options;
}

function shipped_serversd_select()
{
//建设路邮局
     $options[] = array ('key'=>'50','view'=>'10克-100克','color'=>'#006600','box'=>'ba');
	 $options[] = array ('key'=>'51','view'=>'101克-200克','color'=>'#FF6600','box'=>'ban');
	 $options[] = array ('key'=>'52','view'=>'201克-300克','color'=>'#CC0000','box'=>'xiang');
	 $options[] = array ('key'=>'53','view'=>'301克-400克','color'=>'#CC0000','box'=>'sha');
	 $options[] = array ('key'=>'54','view'=>'401克-500克','color'=>'#CC0000','box'=>'cai');
	  $options[] = array ('key'=>'55','view'=>'501克-600克','color'=>'#CC0000','box'=>'sai');
	 $options[] = array ('key'=>'56','view'=>'601克-700克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'57','view'=>'701克-800克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'58','view'=>'801克-900克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'59','view'=>'901克-1000克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'60','view'=>'1001克-1100克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'61','view'=>'1101克-1200克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'62','view'=>'1201克-1300克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'63','view'=>'1301克-1400克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'64','view'=>'1401克-1500克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'65','view'=>'1501克-1600克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'66','view'=>'1601克-1700克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'67','view'=>'1701克-1800克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'68','view'=>'1801克-1900克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'69','view'=>'1901克-2000克','color'=>'#CC0000','box'=>'qi');
	 return $options;
}
function shipped_serverscc_select()
{
//cailian
     $options[] = array ('key'=>'70','view'=>'10克-100克','color'=>'#006600','box'=>'ba');
	 $options[] = array ('key'=>'71','view'=>'101克-200克','color'=>'#FF6600','box'=>'ban');
	 $options[] = array ('key'=>'72','view'=>'201克-300克','color'=>'#CC0000','box'=>'xiang');
	 $options[] = array ('key'=>'73','view'=>'301克-400克','color'=>'#CC0000','box'=>'sha');
	 $options[] = array ('key'=>'74','view'=>'401克-500克','color'=>'#CC0000','box'=>'cai');
	  $options[] = array ('key'=>'75','view'=>'501克-600克','color'=>'#CC0000','box'=>'sai');
	 $options[] = array ('key'=>'76','view'=>'601克-700克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'77','view'=>'701克-800克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'78','view'=>'801克-900克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'79','view'=>'901克-1000克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'80','view'=>'1001克-1100克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'81','view'=>'1101克-1200克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'82','view'=>'1201克-1300克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'83','view'=>'1301克-1400克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'84','view'=>'1401克-1500克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'85','view'=>'1501克-1600克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'86','view'=>'1601克-1700克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'87','view'=>'1701克-1800克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'88','view'=>'1801克-1900克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'89','view'=>'1901克-2000克','color'=>'#CC0000','box'=>'qi');
	 return $options;
}


function shipped_servershg_select()
{
//haiguan
     $options[] = array ('key'=>'100','view'=>'10克-100克','color'=>'#006600','box'=>'ba');
	 $options[] = array ('key'=>'101','view'=>'101克-200克','color'=>'#FF6600','box'=>'ban');
	 $options[] = array ('key'=>'102','view'=>'201克-300克','color'=>'#CC0000','box'=>'xiang');
	 $options[] = array ('key'=>'103','view'=>'301克-400克','color'=>'#CC0000','box'=>'sha');
	 $options[] = array ('key'=>'104','view'=>'401克-500克','color'=>'#CC0000','box'=>'cai');
	  $options[] = array ('key'=>'105','view'=>'501克-600克','color'=>'#CC0000','box'=>'sai');
	 $options[] = array ('key'=>'106','view'=>'601克-700克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'107','view'=>'701克-800克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'108','view'=>'801克-900克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'109','view'=>'901克-1000克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'110','view'=>'1001克-1100克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'111','view'=>'1101克-1200克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'112','view'=>'1201克-1300克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'113','view'=>'1301克-1400克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'114','view'=>'1401克-1500克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'115','view'=>'1501克-1600克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'116','view'=>'1601克-1700克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'117','view'=>'1701克-1800克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'118','view'=>'1801克-1900克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'119','view'=>'1901克-2000克','color'=>'#CC0000','box'=>'qi');
	 return $options;
}
function shipped_serverscailiangh_select()
{
//haiguan
     $options[] = array ('key'=>'120','view'=>'10克-100克','color'=>'#006600','box'=>'ba');
	 $options[] = array ('key'=>'121','view'=>'101克-200克','color'=>'#FF6600','box'=>'ban');

	 $options[] = array ('key'=>'122','view'=>'201克-300克','color'=>'#CC0000','box'=>'xiang');
	 $options[] = array ('key'=>'123','view'=>'301克-400克','color'=>'#CC0000','box'=>'sha');
	 $options[] = array ('key'=>'124','view'=>'401克-500克','color'=>'#CC0000','box'=>'cai');
	  $options[] = array ('key'=>'125','view'=>'501克-600克','color'=>'#CC0000','box'=>'sai');
	 $options[] = array ('key'=>'126','view'=>'601克-700克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'127','view'=>'701克-800克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'128','view'=>'801克-900克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'129','view'=>'901克-1000克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'130','view'=>'1001克-1100克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'131','view'=>'1101克-1200克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'132','view'=>'1201克-1300克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'133','view'=>'1301克-1400克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'134','view'=>'1401克-1500克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'135','view'=>'1501克-1600克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'136','view'=>'1601克-1700克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'137','view'=>'1701克-1800克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'138','view'=>'1801克-1900克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'139','view'=>'1901克-2000克','color'=>'#CC0000','box'=>'qi');
	 return $options;
}

function shipped_serverscailianghs_select()
{
//haiguan
     $options[] = array ('key'=>'220','view'=>'10克-100克','color'=>'#006600','box'=>'ba');
	 $options[] = array ('key'=>'221','view'=>'101克-200克','color'=>'#FF6600','box'=>'ban');

	 $options[] = array ('key'=>'222','view'=>'201克-300克','color'=>'#CC0000','box'=>'xiang');
	 $options[] = array ('key'=>'223','view'=>'301克-400克','color'=>'#CC0000','box'=>'sha');
	 $options[] = array ('key'=>'224','view'=>'401克-500克','color'=>'#CC0000','box'=>'cai');
	  $options[] = array ('key'=>'225','view'=>'501克-600克','color'=>'#CC0000','box'=>'sai');
	 $options[] = array ('key'=>'226','view'=>'601克-700克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'227','view'=>'701克-800克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'228','view'=>'801克-900克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'229','view'=>'901克-1000克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'230','view'=>'1001克-1100克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'231','view'=>'1101克-1200克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'232','view'=>'1201克-1300克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'233','view'=>'1301克-1400克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'234','view'=>'1401克-1500克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'235','view'=>'1501克-1600克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'236','view'=>'1601克-1700克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'237','view'=>'1701克-1800克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'238','view'=>'1801克-1900克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'239','view'=>'1901克-2000克','color'=>'#CC0000','box'=>'qi');
	 return $options;
}

function shipped_serverscailianghss_select()
{
//haiguan
     $options[] = array ('key'=>'240','view'=>'10克-100克','color'=>'#006600','box'=>'ba');
	 $options[] = array ('key'=>'241','view'=>'101克-200克','color'=>'#FF6600','box'=>'ban');

	 $options[] = array ('key'=>'242','view'=>'201克-300克','color'=>'#CC0000','box'=>'xiang');
	 $options[] = array ('key'=>'243','view'=>'301克-400克','color'=>'#CC0000','box'=>'sha');
	 $options[] = array ('key'=>'244','view'=>'401克-500克','color'=>'#CC0000','box'=>'cai');
	  $options[] = array ('key'=>'245','view'=>'501克-600克','color'=>'#CC0000','box'=>'sai');
	 $options[] = array ('key'=>'246','view'=>'601克-700克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'247','view'=>'701克-800克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'248','view'=>'801克-900克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'249','view'=>'901克-1000克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'250','view'=>'1001克-1100克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'251','view'=>'1101克-1200克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'252','view'=>'1201克-1300克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'253','view'=>'1301克-1400克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'254','view'=>'1401克-1500克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'255','view'=>'1501克-1600克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'256','view'=>'1601克-1700克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'257','view'=>'1701克-1800克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'258','view'=>'1801克-1900克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'259','view'=>'1901克-2000克','color'=>'#CC0000','box'=>'qi');
	 return $options;
}

function shipped_serversbantiangh_select()
{
//haiguan
     $options[] = array ('key'=>'140','view'=>'10克-100克','color'=>'#006600','box'=>'ba');
	 $options[] = array ('key'=>'141','view'=>'101克-200克','color'=>'#FF6600','box'=>'ban');
	 $options[] = array ('key'=>'142','view'=>'201克-300克','color'=>'#CC0000','box'=>'xiang');
	 $options[] = array ('key'=>'143','view'=>'301克-400克','color'=>'#CC0000','box'=>'sha');
	 $options[] = array ('key'=>'144','view'=>'401克-500克','color'=>'#CC0000','box'=>'cai');
	  $options[] = array ('key'=>'145','view'=>'501克-600克','color'=>'#CC0000','box'=>'sai');
	 $options[] = array ('key'=>'146','view'=>'601克-700克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'147','view'=>'701克-800克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'148','view'=>'801克-900克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'149','view'=>'901克-1000克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'150','view'=>'1001克-1100克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'151','view'=>'1101克-1200克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'152','view'=>'1201克-1300克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'153','view'=>'1301克-1400克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'154','view'=>'1401克-1500克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'155','view'=>'1501克-1600克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'156','view'=>'1601克-1700克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'157','view'=>'1701克-1800克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'158','view'=>'1801克-1900克','color'=>'#CC0000','box'=>'qi');
	 $options[] = array ('key'=>'159','view'=>'1901克-2000克','color'=>'#CC0000','box'=>'qi');
	 return $options;
}


function countrys_select()
{
 


   //  $options[] = array ('key'=>'1','view'=>'香港','color'=>'#006600','box'=>'');
	// $options[] = array ('key'=>'2','view'=>'台湾','color'=>'#FF6600','box'=>'');
	 $options[] = array ('key'=>'3','view'=>'中国大陆','color'=>'#CC0000','box'=>'');
	// $options[] = array ('key'=>'4','view'=>'澳门','color'=>'#CC00FF','box'=>'');
	 $options[] = array ('key'=>'5','view'=>'墨西哥','color'=>'#CC00FF','box'=>'');
	 $options[] = array ('key'=>'6','view'=>'阿根廷','color'=>'#CC00FF','box'=>'');
	 $options[] = array ('key'=>'7','view'=>'智利','color'=>'#CC00FF','box'=>'');
	 $options[] = array ('key'=>'8','view'=>'巴西','color'=>'#CC00FF','box'=>'');
	 $options[] = array ('key'=>'9','view'=>'秘鲁','color'=>'#CC00FF','box'=>'');
/*	 $options[] = array ('key'=>'10','view'=>'匈牙利','color'=>'#CC00FF','box'=>'');	
	 $options[] = array ('key'=>'11','view'=>'爱尔兰','color'=>'#CC00FF','box'=>'');	
	 $options[] = array ('key'=>'12','view'=>'冰岛','color'=>'#CC00FF','box'=>'');	
	 $options[] = array ('key'=>'13','view'=>'立陶宛','color'=>'#CC00FF','box'=>'');	
	 $options[] = array ('key'=>'14','view'=>'卢森堡','color'=>'#CC00FF','box'=>'');	
	 $options[] = array ('key'=>'15','view'=>'拉脱维亚','color'=>'#CC00FF','box'=>'');	
	 $options[] = array ('key'=>'16','view'=>'摩尔多瓦','color'=>'#CC00FF','box'=>'');	
	 $options[] = array ('key'=>'17','view'=>'马耳他','color'=>'#CC00FF','box'=>'');	
	 $options[] = array ('key'=>'18','view'=>'葡萄牙','color'=>'#CC00FF','box'=>'');	
	 $options[] = array ('key'=>'19','view'=>'罗马尼亚','color'=>'#CC00FF','box'=>'');	
	 $options[] = array ('key'=>'20','view'=>'塞尔维亚','color'=>'#CC00FF','box'=>'');	
	 $options[] = array ('key'=>'21','view'=>'瑞典','color'=>'#CC00FF','box'=>'');
	 $options[] = array ('key'=>'22','view'=>'斯洛文尼亚','color'=>'#CC00FF','box'=>'');
	 $options[] = array ('key'=>'23','view'=>'斯洛伐克','color'=>'#CC00FF','box'=>'');
 */
	 return $options;
}

 



function countrylist_select()
{
 


     $options[] = array ('key'=>'1','view'=>'俄罗斯','color'=>'#006600','box'=>'');
	 $options[] = array ('key'=>'2','view'=>'白俄罗斯','color'=>'#FF6600','box'=>'');
	 $options[] = array ('key'=>'3','view'=>'乌克兰','color'=>'#CC0000','box'=>'');
	 $options[] = array ('key'=>'4','view'=>'立陶宛','color'=>'#CC00FF','box'=>'');
	 $options[] = array ('key'=>'5','view'=>'阿根廷','color'=>'#CC00FF','box'=>'');
	 $options[] = array ('key'=>'6','view'=>'巴西','color'=>'#CC00FF','box'=>'');
	 $options[] = array ('key'=>'7','view'=>'智利','color'=>'#CC00FF','box'=>'');
	 /*	 $options[] = array ('key'=>'8','view'=>'澳大利亚','color'=>'#CC00FF','box'=>'');
	 $options[] = array ('key'=>'9','view'=>'德国','color'=>'#CC00FF','box'=>'');
	 	 $options[] = array ('key'=>'10','view'=>'美国','color'=>'#CC00FF','box'=>'');
 
	 $options[] = array ('key'=>'8','view'=>'巴西','color'=>'#CC00FF','box'=>'');
	 $options[] = array ('key'=>'9','view'=>'秘鲁','color'=>'#CC00FF','box'=>'');
 	 $options[] = array ('key'=>'10','view'=>'匈牙利','color'=>'#CC00FF','box'=>'');	
	 $options[] = array ('key'=>'11','view'=>'爱尔兰','color'=>'#CC00FF','box'=>'');	
	 $options[] = array ('key'=>'12','view'=>'冰岛','color'=>'#CC00FF','box'=>'');	
	 $options[] = array ('key'=>'13','view'=>'立陶宛','color'=>'#CC00FF','box'=>'');	
	 $options[] = array ('key'=>'14','view'=>'卢森堡','color'=>'#CC00FF','box'=>'');	
	 $options[] = array ('key'=>'15','view'=>'拉脱维亚','color'=>'#CC00FF','box'=>'');	
	 $options[] = array ('key'=>'16','view'=>'摩尔多瓦','color'=>'#CC00FF','box'=>'');	
	 $options[] = array ('key'=>'17','view'=>'马耳他','color'=>'#CC00FF','box'=>'');	
	 $options[] = array ('key'=>'18','view'=>'葡萄牙','color'=>'#CC00FF','box'=>'');	
	 $options[] = array ('key'=>'19','view'=>'罗马尼亚','color'=>'#CC00FF','box'=>'');	
	 $options[] = array ('key'=>'20','view'=>'塞尔维亚','color'=>'#CC00FF','box'=>'');	
	 $options[] = array ('key'=>'21','view'=>'瑞典','color'=>'#CC00FF','box'=>'');
	 $options[] = array ('key'=>'22','view'=>'斯洛文尼亚','color'=>'#CC00FF','box'=>'');
	 $options[] = array ('key'=>'23','view'=>'斯洛伐克','color'=>'#CC00FF','box'=>'');
 */
	 return $options;
}







function money_back_select()
{
     $options[] = array ('key'=>'1','view'=>'协商后主动退款','color'=>'#006600','box'=>'');
	 $options[] = array ('key'=>'2','view'=>'Ebay争议','color'=>'#FF6600','box'=>'');
	 $options[] = array ('key'=>'3','view'=>'PP争议','color'=>'#CC0000','box'=>'');
	 $options[] = array ('key'=>'4','view'=>'客户撤单不发','color'=>'#CC00FF','box'=>'');
	 return $options;
}

function get_web_orders_info($fields,$id)
{
@$rs=db_execute("select ".$fields." from erp_web_orders where web_orders_id=".$id." ");
return $rs[0];
}

function totals_web_orders($id)
{
@$rs=db_execute("select sum(web_orders_detial_total) as s from erp_web_orders_detial where web_orders_detial_orders_id=".$id);
return $rs[0];
}

function get_money_back_info($fields,$id)
{
@$rs=db_execute("select ".$fields." from erp_money_back where web_orders_id=".$id." ");
return $rs[0];
}

function totals_money_back($id)
{
@$rs=db_execute("select sum(web_orders_detial_total) as s from erp_money_back_detial where web_orders_detial_orders_id=".$id);
return $rs[0];
}

function recordcount($table,$status,$lie='web_orders_status')
{
@$rs=mysql_fetch_array(mysql_query("select count(*) as co from ".$table." where ".$lie." = ".$status.""));
return $rs[0];
}


function get_saller_use_email($email)
{
@$rs=mysql_fetch_array(mysql_query("select saller from erp_saller_email where email = '".$email."'"));
return $rs[0];
}

function chk_currency($values,$type=3)
{
$values=str_replace(',','',$values);
$sql="select * from erp_currency_info order by currency_id desc";
$rs_arr=mysql_query($sql);
$currencyinfo=array();
while ($rs=mysql_fetch_array($rs_arr))
      {
          $currencyinfo[]=array('currency_type'=>$rs['currency_type'],'currency_value'=>$rs['currency_value']);
      }
for ($i=0;$i<sizeof($currencyinfo);$i++)
    {
	      
		  $test=explode($currencyinfo[$i]['currency_type'],trim($values));
		  if (sizeof($test)>=2)
		     {
				 $currency_type=$currencyinfo[$i]['currency_type'];
				 $currency_value=$currencyinfo[$i]['currency_value'];
				 $return_value=str_replace($currencyinfo[$i]['currency_type'],'',trim($values));
				 break;
			 }
	}
  if ($type==2){return trim((float)$currency_value);}elseif($type==1){return trim($currency_type);}else{return trim((float)$return_value);}
}

function get_currency_list()
{
$listarr=array();
$sql="select * from erp_currency_info order by currency_id desc";
$rs_arr=mysql_query($sql);
$currencyinfo=array();
while (@$rs=mysql_fetch_array($rs_arr))
      {
	     $listarr[]=array('code'=>$rs['currency_type'],'value'=>$rs['currency_value'],'name'=>$rs['currency_name']);
	  }
   return $listarr;
}

function get_ebay_orders_info($fileds,$sID)
{
@$rs=db_execute("select ".$fileds." from erp_orders where erp_orders_id=".$sID);
return $rs[0];
}

function get_ebay_email_info($fileds,$sID)
{
@$rs=db_execute("select ".$fileds." from erp_orders where orders_mail_code='".$sID."'");
return $rs[0];
}

function get_orders_products_info($fileds,$sID)
{
@$rs=db_execute("select ".$fileds." from erp_orders_products where orders_products_id=".$sID);
return $rs[0];
}

function get_orders_total_price($sID)
{
@$rs=db_execute("select sum(item_price) as tal from erp_orders_products where erp_orders_id=".$sID);
return $rs[0];
}

function chk_str_is_unknow_code($str)
{
$strarr=explode('?',$str);
if (sizeof($strarr)>=2){ return true;}else{return false;}
}

////////////////////////////////////////////////////////////////////////////////////////////
function split_sku($string,$count=1)
{
$array=array();
$str=$string;
if (strlen($string) > 0){
///////////////////////////////////////////////////////////////////////////  
   if (sizeof(explode(')',$str))>1)/////如果带有括号运算
      {
         $str_1=explode(')',$str);
		 for ($i=0;$i<sizeof($str_1);$i++)
		     {
			     $str_1_1=stristr($str_1[$i],'(');//取到括号里的字符
				 if ($str_1_1)
				    {
					   $str_1_1=str_replace('(','',$str_1_1);//当括号中的字符不为空时执行筛选
					   $str=str_replace($str_1_1,'arr+|+'.$i,$str);//将筛选值替换到原始字符串中,直到替换结束
					   $str_info[]=array('arr+|+'.$i=>$str_1_1);					   
					}
			 }
		  $str=str_replace('(','',$str);$str=str_replace(')','',$str);//剥去括号,全部转化为AAA或AAA X N格式
		  //echo $str;
		  //////////////////////////开始分解为长字符串
		  $str_2=explode(' + ',$str);
		  $str_2_info=array();
		  $str_2_new=array();
		  for ($o=0;$o<sizeof($str_2);$o++)
		      {
			      $str_2_1=trim($str_2[$o]);
				  if ($str_2_1 !='' && sizeof(explode(' X ',$str_2_1))>1)//带有X即乘号时
				     {  
					    $str_2_1_arr=explode(' X ',$str_2_1);
						if (sizeof(explode('+|+',$str_2_1_arr[0]))>1)
						   {
						       $str_2_new=array($str_2_1_arr[0]=>$str_2_1_arr[1]);
						   }
						else
						   {
						       $str_2_content.=$str_2_1_arr[0].' X '.$str_2_1_arr[1].' + ';
						   }
					    //$str_2_info =array_merge($str_2_info,$str_2_new);//将数量信息存储于数组中
					 }
				  else
				     {
					    $str_2_content.=$str_2_1.' X 1 + ';
						//$str_2_info =array_merge($str_2_info,array($str_2_1=>1));//将数量信息存储于数组中
					 }	
				  $str_2_info = array_merge($str_2_info,$str_2_new);	 
			  }
		  	  	  
		  //print_r ($str_2_info);
		  for ($ii=0;$ii<sizeof($str_info);$ii++)
		      {
			     $str_3=$str_info[$ii];
				 $str_3_keys=array_keys($str_3);
				 for ($iii=0;$iii<sizeof($str_3_keys);$iii++)
				     {
					     $last_str=$str_3[$str_3_keys[$iii]];
						 $last_str_1=explode(' + ',$last_str);
						 $count_per=$str_2_info[$str_3_keys[$iii]];
						 for ($iiii=0;$iiii<sizeof($last_str_1);$iiii++)
						     {
							    $last_str_0.=$last_str_1[$iiii].' X '.$count_per.' + ';								
							 }
					 }
				 //$str=str_replace(,,$str);//通过存储原字符串的数组，将字符串还原 
			  }
			  $str = $last_str_0.$str_2_content;	  
		  //$array=explode(' + ',$str);
      }
   else//不带括号运算
      {
        if (sizeof(explode(' + ',$str))>1 || sizeof(explode(' X ',$str))>1 )
		   {
		      $str_1=explode(' + ',$str);
		      for ($i=0;$i<sizeof($str_1);$i++)
		          {
		             if (sizeof(explode(' X ',$str_1[$i]))>1)
					    {
						   $last_str.=$str_1[$i].' + ';
						}
					 else
					    {
						   $last_str.=$str_1[$i].' X 1 + ';
						}
		          }
			  $str=$last_str;
		   }
		 else
		   {
		      $str=$str.' X 1 ';
		   }
      }
///////////////////////////////////////////////////////////////////////////

}
if (substr($str,strlen($str)-2,2)=='+ '){$str=substr($str,0,strlen($str)-2);}
//echo $str;
////////////////////////////////由统一格式后的$str进行扣数动作///////////////////////////////////////////
$str_1=explode(' + ',$str);
for ($i=0;$i<sizeof($str_1);$i++)
    { 
			$str_1_1=explode(' X ',$str_1[$i]);
			//$reason_arr='产品销售出库';
			//$result_string.='<tr bgcolor="#eeeeee"><td>'.$ods_id.'</td><td>'.$str_1_1[0].'</td>';
			if ( is_numeric(($str_1_1[1]*$count)) && ((int)$str_1_1[1]*$count)>0 )
			   {
			   
			   $array[]=array(0=>$str_1_1[0],
			                  1=>($str_1_1[1]*$count));
			   //mysql_query("insert into erp_orders_products (erp_orders_id,ebay_orders_id,orders_sku,orders_item,item_price,item_count,item_cost)");
			   //echo $str_1_1[0].'--'.($str_1_1[1]*$count).'<br>';
			   }

    }
	return $array;
///////////////////////////////////////////////////////////////////////////
}

function get_cost($sku)
{
   $string=strtoupper($sku);
   //$sku2=strtoupper($sku);
   $cost=0;
   $sku_arr=split_sku($sku);
   for($i=0;$i<=sizeof($sku_arr);$i++)
      {	    
		$cost+=getproductsfieldsusesku('products_value',$sku_arr[$i][0]);
	  }
   return $cost;
}

function replace_code($str)
{
$str1=str_replace('[|]','+',$str);
$str1=str_replace('[||]','&',$str1);
$str1=str_replace('[|||]','#',$str1);
return $str1;
}

function get_sales_total($sku,$account='')
{
$count=0;
//if ($account!=''){$wh=" and (o.sales_account='planemodel55' or o.sales_account='yks-battery' ) ";}
@$rs_arr=mysql_query("select p.item_count,p.orders_sku from erp_orders as o,erp_orders_products as p where o.erp_orders_id=p.erp_orders_id and o.orders_out_time >='".get_totals_fields_use_sku('get_totals_time',$sku)."' and p.orders_sku = '".$sku."' and o.orders_status=5 ".$wh);
while (@$rs=mysql_fetch_array($rs_arr))
{
$skusarr=split_sku($rs[1],$rs[0]);
//$count+=sizeof($skusarr);
 for ($i=0;$i<sizeof($skusarr);$i++)
     {
	   if ($skusarr[$i][0]==$sku){$count+=$skusarr[$i][1];}
	 }
}
return $count;
}

function get_ebay_sales_total($sku,$account='',$f,$t,$tp='')
{
$count=0;
$wh='';$whtp='';
$sku=strtoupper($sku);
if ($account!=''){$wh=" and o.sales_account like '%".$account."%' ";}
if ($tp!=''){$whtp=" and o.orders_type = ".$tp." ";}
@$rs_arr=mysql_query("select p.item_count,p.orders_sku from erp_orders as o,erp_orders_products as p where o.erp_orders_id=p.erp_orders_id and o.orders_out_time >='".$f." 00:00:00' and o.orders_out_time <='".$t." 23:59:59' and p.orders_sku like '%".$sku."%' and o.orders_status=5 ".$wh.$whtp);
while (@$rs=mysql_fetch_array($rs_arr))
{
$skusarr=split_sku($rs[1],$rs[0]);
//$count+=sizeof($skusarr);
 for ($i=0;$i<sizeof($skusarr);$i++)
     {
	   if ($skusarr[$i][0]==$sku){$count+=$skusarr[$i][1];}
	 }
}
		unset($skusarr);
		unset($rs);
		
return $count;
}

function get_web_sales_total($sku,$account='')
{
$count=0;
if ($account!=''){$wh=" and o.web_orders_saler_account not like 'SMT%' and o.web_orders_saler_account not like 'KOKO%' ";}
@$rs_arr=mysql_query("select p.web_orders_detial_count,p.web_orders_detial_sku from erp_web_orders as o,erp_web_orders_detial as p where o.web_orders_id=p.web_orders_detial_orders_id and o.web_orders_datetime >='2011-1-1 00:00:00' and o.web_orders_datetime <='2011-1-31 23:59:59' and p.web_orders_detial_sku like '%".$sku."%' and o.web_orders_status=2 and web_orders_type=1 ".$wh);
while (@$rs=mysql_fetch_array($rs_arr))
{
$skusarr=split_sku($rs[1],$rs[0]);
//$count+=sizeof($skusarr);
 for ($i=0;$i<sizeof($skusarr);$i++)
     {
	   if ($skusarr[$i][0]==$sku){$count+=$skusarr[$i][1];}
	 }
}
return $count;
}

function output_ebay_products($id)
{
@$rs_arr=mysql_query("select p.item_count,p.orders_sku from erp_orders as o,erp_orders_products as p where o.erp_orders_id=p.erp_orders_id and o.erp_orders_id=".$id);
while (@$rs=mysql_fetch_array($rs_arr))
{
$skusarr=split_sku($rs[1],$rs[0]);
//$count+=sizeof($skusarr);
 for ($i=0;$i<sizeof($skusarr);$i++)
     {
	   if ($skusarr[$i][1]>0 && $skusarr[$i][0]!='' )
	      {
		      mysql_query("update erp_products_data set products_unreal=(products_unreal-".$skusarr[$i][1].") where products_sku='".$skusarr[$i][0]."'");
		  }
	 }
}
}

function get_shipped_count($d,$t)
{
@$rs=db_execute("select shipped_count from erp_shipped_count where shipped_postoffice=".$t." and shipped_date='".$d."'");
return (int)$rs[0];
}

function get_shipping_fee_from_orders($oID)
{
$weight=0;
$fee=0;
@$rs_arr=mysql_query("select p.item_count,p.orders_sku,o.orders_total,o.currency_value,o.orders_is_tracking  from erp_orders as o,erp_orders_products as p where o.erp_orders_id=p.erp_orders_id and o.erp_orders_id=".$oID);
while (@$rs=mysql_fetch_array($rs_arr))
{
@$total=$rs[2]/$rs[3];
$skusarr=split_sku($rs[1],$rs[0]);
$istracking=$rs['orders_is_tracking'];
//$count+=sizeof($skusarr);
 for ($i=0;$i<sizeof($skusarr);$i++)
     {
	   if ($skusarr[$i][1]>0 && $skusarr[$i][0]!='' )
	      {
		      $weight+=getproductsfieldsusesku('products_weight',$skusarr[$i][0])*$skusarr[$i][1];
			  //mysql_query("update erp_products_data set products_unreal=(products_unreal-".$skusarr[$i][1].") where products_sku='".$skusarr[$i][0]."'");
		  }
	 }
}

if ($weight<0.08 || ($weight >= 0.11 && $weight <=0.16)){$fee=$weight*80;}else
{
 if ($weight<2){$fee=(ceil($weight*10)*5.7+1.05);}
 else{
 $fee=(280+(ceil($weight*2)-1)*75)*0.47+6;
 }
}
if ($istracking==1 || ($total>=TRACK_SERVICE_MIN && $istracking==0) ){$fee+=5;}
return $fee;
}


function get_shipping_fee_use_weight($weight)
{
$weight=$weight/1000;
/*if ($weight<0.08 || ($weight >= 0.11 && $weight <=0.16)){$fee=$weight*80;}else
{
 if ($weight<2){$fee=(ceil($weight*10)*5.7+1.05);$fee=($fee/38)*32;}else{$fee=(280+(ceil($weight*2)-1)*75)*0.47+6;}
}*/
 if ($weight>2){$fee=(280+(ceil($weight*2)-1)*75)*0.47+6;}else{
 if ($weight<=0.05){
 $fee=5*0.72;}
 if ($weight>0.05){
$fee=5*0.72+($weight-0.05)*85*0.72;}
 }
return $fee;
}
function get_shipping_fee_use_weights($weight)
{
$weight=$weight/1000;
/*if ($weight<0.08 || ($weight >= 0.11 && $weight <=0.16)){$fee=$weight*80;}else
{
 if ($weight<2){$fee=(ceil($weight*10)*5.7+1.05);$fee=($fee/38)*32;}else{$fee=(280+(ceil($weight*2)-1)*75)*0.47+6;}
}*/
 
 if ($weight<=0.05){
 $fee=5*0.72;}
 if ($weight>0.05){
$fee=5*0.72+($weight-0.05)*85*0.72;}
 
return $fee;
}


function show_category_select($cID,$rank=0)
{ 
  $front='|-';
  if ($rank>0)
  {
     for ($i=0;$i<$rank;$i++)
	     {
		   $front=' | '.$front;
		 }  
  }
  $rs_arr=mysql_query("select * from erp_category where  category_status=1 and  category_parent_id =".$cID);
  while ($rs=mysql_fetch_array($rs_arr))
  {
     $string.='<option value="'.$rs['category_id'].'">'.$front.$rs['category_name'].'</option>';
	 if (chkcatecount($rs['category_id']))
	    {
		   $string.=show_category_select($rs['category_id'],$rank+1);
		}
  }
  return $string;
}

function get_update_in_7days($t='count')
{
$sql="select count(*) as co from erp_products_data where date(products_times_last)>='".date("Y-m-d",(time()-7*24*3600))."'";
$rs=db_execute($sql);
return $rs[0];
}
?>