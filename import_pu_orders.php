<?php
require_once('includes/config.inc.php');
 
 
function formatdata($data)
{
$data=str_replace("'","''",$data);
return $data;
}

$filestype=explode('.',$_FILES["csvfiles"]["name"]);
if ($filestype[sizeof($filestype)-1]=='csv' || $filestype[1]=='CSV'){}
else
{
die('<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />上传文件的格式有误，请上传CSV格式的订单表格');
}
$csvfiles=$_FILES["csvfiles"]["tmp_name"];
$row = 0;
$handle = fopen($csvfiles,"r");

$erp_orders_id='';
$sale_account=explode('--',$_FILES["csvfiles"]["name"]);
 
$str_err='<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#CCCCCC"><tr bgcolor="#ffffff" ><td>SKU</td><td>盘点数据</td><td>导入结果</td><td>说明</td></tr>';
if (isset($_POST['act']) && $_POST['act']=='add')
{
$year= idate('Y',time());
$month= idate('m',time());;
 
 
 $totals_time=date('Y-m-d H:i:s',time());
 while (($data = fgetcsv($handle, 10000, ",")) !== FALSE)
{
     $num = count($data);
     $row++;
	 
	 $get_totals_add_count=1;
$get_totals_reason="盘点";

$storage_real= formatdata($data[1]);
$totals_sku= formatdata($data[0]);
	 if (isset($totals_sku))
	 {
/*$sqldata="insert into erp_get_totals(get_totals_sku,get_totals_time,get_totals_storage_real,get_totals_storage_unreal,get_totals_reason,get_totals_year,get_totals_month,
get_totals_add_count,user_id)values('".$totals_sku."','".$totals_time."','".$storage_real."','".$storage_unreal."','".$get_totals_reason ."','".$year."','".$month."','".$get_totals_add_count."','" .$userid."')";
*/
 //echo  $sqldata."<br>";

// mysql_query($sqldata);
$sqlupdate="update ebay_goods  set   goods_location='".$storage_real."' where goods_sn='".$totals_sku ."'";
  // $sqlupdate="update erp_products_data set   oper='".$storage_real."' where products_sku='".$totals_sku ."'";


// echo  $sqlupdate."<br>";
mysql_query($sqlupdate);

$str_err.='<tr bgcolor="#ffffff" ><td>'.$data[0].'</td><td>'.$data[1].'</td><td>成功</td><td>订单已正常导入。</td></tr>';

	  }
 }
  
fclose($handle);
  
 
$msg=($erp_orders_id>0) ? '<span style="color:#009900; font-weight:bold;">盘点成功，进入<a href="all_orders_manage.php">[全部订单管理]</a>查看。</span>' : '<span style="color:#CC0000; font-weight:bold;">>盘点失败，请检查数据的合理性或联系系统管理员。</span>';
$erp_orders_id='';
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'.$str_err.'<tr bgcolor="#CC0000"  style="font-size:14px; font-weight:bold; color:#FFFFFF;"><td colspan="4">若存在导入失败的订单，那么请不要刷新本页，请先将导入失败的订单全部整理好后，再进行重新导入操作。</td></tr></table>';
}

?>