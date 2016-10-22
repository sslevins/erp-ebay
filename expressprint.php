<?php
	include "include/config.php";
	$id					= $_REQUEST['id'];
	$ss					= "select * from ebay_order where ebay_id='$id'";
	$ss					= $dbcon->execute($ss);
	$ss					= $dbcon->getResultArray($ss);
	$ebay_countryname	= $ss[0]['ebay_countryname'];
	
	
	if(strlen($ebay_countryname) <= 3) {
		$vsql = "select * from ebay_countrys where ebay_user='$user' and countrysn='$ebay_countryname' ";
		
		
		$vsql					= $dbcon->execute($vsql);
		$vsql					= $dbcon->getResultArray($vsql);
		$ebay_countryname		= $vsql[0]['countryen'];
	}
	
	
	$ebay_state			= $ss[0]['ebay_state'];
	$ebay_city			= $ss[0]['ebay_city'];
	$ebaystreet			= $ss[0]['ebay_street']." ".$ss[0]['ebay_street1'];
	$ebay_phone			= $ss[0]['ebay_phone'];
	$ebay_postcode		= $ss[0]['ebay_postcode'];
	$ebay_username		= $ss[0]['ebay_username'];
	$ebay_noteb			= $ss[0]['ebay_noteb'];
	
	
	$ebay_carrier		= $ss[0]['ebay_carrier'];
	
	$ss					= "select * from ebay_carrier where name='$ebay_carrier' and ebay_user='$user'";
	
	$ss					= $dbcon->execute($ss);
	$ss					= $dbcon->getResultArray($ss);
	$config_lable		= $ss[0]['config_lable'];
	$print_bg			= $ss[0]['print_bg'];
	$print_bg			= $ss[0]['print_bg'];
	
	$country 			= $ss[0]['country'];
	$province			= $ss[0]['province'];
	$city 				= $ss[0]['city'];
	$username 			= $ss[0]['username'];
	$tel	 			= $ss[0]['tel'];
	$street 			= $ss[0]['street'];
	$address 			= $ss[0]['address'];
	$carrier_sn 			= $ss[0]['carrier_sn'];

	
	
	$width				= 1024;
	$height				= 600;
	
	if($print_bg != ''){
		
		$_size = @getimagesize($print_bg);
		$width				= $_size[0];
		$height				= $_size[1];
	
	
	}
	

	$lable_box = array();
	
	$lable_box['t_shop_country'] 		= $country;
    $lable_box['t_shop_city'] 			= $city;
    $lable_box['t_shop_province'] 		= $province; //网店-省份
    $lable_box['t_shop_name'] 			= $username; //网店-名称
    $lable_box['t_shop_district'] 		= $street; //网店-区/县
	
	
	$address							= str_replace(",",'@@',$address);
	
	
    $lable_box['t_shop_tel'] 			= $tel; //网店-联系电话
    $lable_box['t_shop_address'] 		= $address; //网店-地址
	
	

	
	$lable_box['t_customer_country'] 	= $ebay_countryname;
	
	
	$lable_box['t_customer_province'] 	= $ebay_state; //收件人-省份
    $lable_box['t_customer_city'] 		= $ebay_city; //收件人-城市
    $lable_box['t_customer_district'] 	= $ebaystreet; //收件人-区/县
    $lable_box['t_customer_tel'] 		= $ebay_phone; //收件人-电话
	
	
    
    $lable_box['t_customer_post'] 		= $ebay_postcode; //收件人-邮编
    $lable_box['t_customer_address']	= $ebaystreet; //收件人-详细地址
    $lable_box['t_customer_name'] 		= $ebay_username; //收件人-姓名
	
	 $lable_box['t_carrier_sn'] 		= $carrier_sn; //收件人-姓名
	
	
    $gmtime_utc_temp 					= strtotime(date('Y-m-d')); //获取 UTC 时间戳
    $lable_box['t_year'] 				= date('Y', $gmtime_utc_temp); //年-当日日期
    $lable_box['t_months'] 				= date('m', $gmtime_utc_temp); //月-当日日期
    $lable_box['t_day'] 				= date('d', $gmtime_utc_temp); //日-当日日期

    $lable_box['t_pigeon'] 				= '√'; //√-对号
	$lable_box['t_order_postscript'] 	= $ebay_noteb; //备注-订单
	
	
	
	
	//标签替换
    $temp_config_lable = explode('||,||', $config_lable);
    if (!is_array($temp_config_lable))
    {
    
	    $temp_config_lable[] = $config_lable;
    }
	
	foreach ($temp_config_lable as $temp_key => $temp_lable)
    {
        $temp_info = explode(',', $temp_lable);
        if (is_array($temp_info))
        {
                    $temp_info[1] = $lable_box[$temp_info[0]];
    
	    }
    	$temp_config_lable[$temp_key] = implode(',', $temp_info);
    }
	$sarray = implode('||,||',  $temp_config_lable);
	



?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title></title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Cache-Control" content="public">
<script language="javascript" src="js/utils.js"></script>
<style type="text/css">
body
{
  background-color: #ffffff;
  padding: 0px;
  margin: 0px;
  text-align:left;
  font-size:18px
}
.table_box
{
  table-layout: fixed;
  text-align:center;
}
.display_no
{
  display:none;
}
</style>
</head>
<body id="print">
<!--打印区 start-->


<!--打印区 end-->
</body>
</html>
<script type="text/javascript">
<!--
onload = function()
{
  _create_shipping_print();
}

/**
 * 创建快递单打印内容
 */
function _create_shipping_print()
{
  //创建快递单
  var print_bg = _create_print_bg();

  //创建文本
  var config_lable = "<?php echo $sarray; ?>";

  var lable = config_lable.split("||,||");

  if (lable.length <= 0)
  {
    return false; //未设置打印内容
  }

  for (var i = 0; i < lable.length; i++)
  {
    //获取标签参数
    var text = lable[i].split(",");
    if (text.length <= 0 || text[0] == null || typeof(text[0]) == "undefined" || text[0] == '')
    {
      continue;
    }

    text[4] -= 10;
    text[5] -= 10;

    _create_text_box(print_bg, text[0], text[1], text[2], text[3], text[4], text[5]);
  }
}

/**
 * 创建快递单背景
 */
function _create_print_bg()
{
  var print_bg = document.createElement('div');

  print_bg.setAttribute('id', 'print_bg');

  var print = document.getElementById('print');

  print.appendChild(print_bg);

  //测试打印效果
  //print_bg.style.background = '{$shipping.print_bg}';

  //设置快递单样式
  print_bg.style.width = '<?php echo $width;?>px';
  print_bg.style.height = '<?php echo $height;?>px';
  
  print_bg.style.zIndex = 1;
  print_bg.style.border = "solid 1px #FFF";
  print_bg.style.padding = "0";
  print_bg.style.position = "relative";
  print_bg.style.margin = "0";

  return print_bg;
}

/**
 * 创建快递单文本
 */
function _create_text_box(print_bg, id, text_content, text_width, text_height, x, y)
{//alert(id + '|' + text_content + '|' + text_width + '|' + text_height + '|' + x + '|' + y);
  var text_box = document.createElement('div');

  //设置属性
  text_box.setAttribute('id', id);

  print_bg.appendChild(text_box);

  //设置样式
  text_box.style.width = text_width + "px";
  text_box.style.height = text_height + "px";
  text_box.style.border = "0";
  text_box.style.padding = "0";
  text_box.style.margin = "0 auto";

  text_box.style.position = "absolute";
  text_box.style.top = y + "px";
  text_box.style.left = x + "px";

  text_box.style.wordBreak = 'break-all'; //内容自动换行 严格断字
  text_box.style.textAlign = 'left';

  //赋值
  
  var text_content = text_content.replace(/@@/,',');
  
  text_box.innerHTML = text_content;

  return true;
}
//-->
</script>
