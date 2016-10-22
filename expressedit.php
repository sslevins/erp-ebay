<?php include "include/config.php"; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Print</title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Cache-Control" content="public">
<script language="javascript" src="js/utils.js"></script>
<script language="javascript" src="js/transport.js"></script>
<script language="javascript" src="js/common.js"></script>


<style type="text/css">
body
{
  background-color: #ffffff;
  padding: 0px;
  margin: 0px;
}

body, td
{
  font-family: Arial, Verdana, sans-serif;
  font-size: 12px;
}

.table_box
{
  border:#77776F 1px solid;
  table-layout: fixed;
}

.table_line
{
  border:#77776F 1px solid;
}

.select_box
{
  margin:-2;
  width:150px;
  background:#FFFFFF;
  line-height:18px;
  border:0px;
  border-style: none;
  font-size:16px;
}

.display_no
{
  display:none;
}

.div_play_aray
{
  border-style:#77776F 1px solid;
  margin:0;
  height:100%;
  width:100%;
  overflow:auto;
}
</style>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
</head>
<?php

$id			= $_REQUEST['id'];



if($_POST['act'] == 'do_edit_print_template'){

	$config_lable		 = $_POST['config_lable'];
	$sql				 = "update ebay_carrier set config_lable='$config_lable' where id='$id'";
	
	
	$dbcon->execute($sql);
	
	
		$name				= $_FILES['bg']['name'];		
		$filename			= date('Y').date('m').date('d').date('H').date('i').date('s').rand(100,999);
		$filetype			= substr($name,strpos($name,"."),4);
		$goods_pic			= $filename.$filetype;	
		
		if (move_uploaded_file($_FILES['bg']['tmp_name'], $goods_pic) && $_FILES['bg']['tmp_name'] != '') {	
				
	 			$status	= "-[<font color='#33CC33'>The picture uploaded successful</font>]<br>";
				echo $status;
				$sql				 = "update ebay_carrier set print_bg='$goods_pic' where id='$id'";
				$dbcon->execute($sql);
		}
	
}

if($_REQUEST['type'] == 'del'){

	
	$ss		= "update ebay_carrier set print_bg='' where id='$id'";
	$dbcon->execute($ss);
	
}



$ss			= "select * from ebay_carrier where id='$id'";
$ss			= $dbcon->execute($ss);
$ss			= $dbcon->getResultArray($ss);


$print_bg		= $ss[0]['print_bg'];
$config_lable	= $ss[0]['config_lable'];
?>


<body>
  <table width="100%" cellpadding="0" cellspacing="0" border="0" class="table_box">
  <form action="expressedit.php?id=<?php echo $id; ?>" enctype="multipart/form-data" method="post" name="theForm" id="theForm" onSubmit="return validate();">
  <input type="hidden" name="act" value="">
  <input type="hidden" name="shipping" value="{$shipping_id}">
  <input type="hidden" name="config_lable" value="">
  <input type="hidden" name="print_model" value="2">
  <input type="hidden" name="shipping_name" value="{$shipping.shipping_name}">
    <!--菜单栏 start-->
    <tr>
      <td style="overflow:hidden; background-color:#EFEFDE; padding-left:8px;">
        <table width="100%" cellpadding="0" cellspacing="0" border="0" height="46">
          <tr>
            <td height="26" align="left">
              <select name="lable" id="lable" class="select_box" onChange="javascript:call_flash('lable_add', this);">
                
                <option value="" selected="selected">--选择插入标签--</option>
                <option value="carrier_sn">物流公司代号</option>
                <option value="shop_country">联系人-国家</option>
                <option value="shop_province">联系人-省份</option>
                <option value="shop_city">联系人-城市</option>
                <option value="shop_name">联系人-名称</option>
                <option value="shop_district">联系人-区/县</option>
                <option value="shop_tel">联系人-联系电话</option>
                <option value="shop_address">联系人-地址</option>
                <option value="customer_country">收件人-国家</option>
                <option value="customer_province">收件人-省份</option>
                <option value="customer_city">收件人-城市</option>
                <option value="customer_district">收件人-区/县</option>
                <option value="customer_tel">收件人-电话</option>
                <option value="customer_post">收件人-邮编</option>
                <option value="customer_address">收件人-详细地址</option>
                <option value="customer_name">收件人-姓名</option>
                <option value="year">年-当日日期</option>
                <option value="months">月-当日日期</option>
                <option value="day">日-当日日期</option>
                <option value="order_no">订单号-订单</option>
                <option value="order_postscript">备注-订单</option>
                <option value="order_best_time">送货时间-订单</option>
                <option value="pigeon">√-对号</option>   
              </select>
              <input type="button" name="del" id="del" value="删除标签" onClick="javascript:call_flash('lable_del', this);">
            </td>
            <td id="pic_control_upload" >
              <input type="file" name="bg" id="bg" >
            
              <iframe id="bg_upload_hidden" name="bg_upload_hidden" frameborder="0" scrolling="no" class="display_no"></iframe>
            </td>
            <td id="pic_control_del" >
              <input type="button" name="upload_del" id="upload_del" onClick="javascript:bg_del();" value="删除图片" >
            </td>
            <td align="right"><input type="button" value="保存设置" onClick="javascript:save();">&nbsp;&nbsp;</td>
          </tr>
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td style="overflow: hidden;">
        <table width="100%" cellpadding="0" cellspacing="0" border="0" class="table_line">
          <tr style="display: none">
            <td colspan="3"></td>
          </tr>
        </table>
      </td>
    </tr>
    <!--菜单栏 end-->

    <!--编辑区 start-->
    <tr>
        <td id="xEditingArea" valign="top" height="620" width="100%"><div class="div_play_aray"><script type="text/javascript">
AC_FL_RunContent( 'codebase','http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0','width','1024','height','600','id','test','src','flash/pint','wmode','transparent','flashvars','bcastr_config_bg=<?php echo $print_bg; ?>&swf_config_lable=<?php echo $config_lable;?>','menu','false','quality','high','pluginspage','http://www.macromedia.com/go/getflashplayer','allowscriptaccess','sameDomain','name','test','swliveconnect','true','movie','flash/pint' ); //end AC code
</script><noscript><object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="1024" height="600" id="test">
      <param name="movie" value="flash/pint.swf">
      <param name="quality" value="high">
      <param name="menu" value="false">
      <param name="wmode" value="transparent">
      <param name="FlashVars" value="bcastr_config_bg=<?php echo $print_bg; ?>&swf_config_lable=<?php echo $config_lable;?>">
      <param name="allowScriptAccess" value="sameDomain"/>
      <embed src="flash/pint.swf" wmode="transparent" FlashVars="bcastr_config_bg=<?php echo $print_bg; ?>&swf_config_lable=<?php echo $config_lable;?>" menu="false" quality="high" width="1024" height="600" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" allowScriptAccess="sameDomain" name="test" swLiveConnect="true"/>
      </object></noscript></div></td>
    </tr>
    <!--编辑区 end-->
  </form>
  </table>
</body>
</html>

<script type="text/javascript">
<!--
var display_yes = (Browser.isIE) ? 'block' : 'table-row-group';

window.onload = function()
{

  //callFromFlash();


}

/**
 * 恢复默认
 */
function recovery_default()
{
  //获取表单对象
  var the_form = this_obj("theForm");
  if (typeof(the_form) == "undefined")
  {
    return false; //程序错误
  }

  if (!confirm(recovery_default_suer))
  {
    return false; //中止执行
  }

  the_form.target = '_parent';
  the_form.act.value = 'recovery_default_template';

  the_form.submit();

  return true;
}

/**
 * 保存
 */
function save()
{
  //获取表单对象
  var the_form = this_obj("theForm");
  if (typeof(the_form) == "undefined")
  {
    return false; //程序错误
  }

  the_form.config_lable.value = call_flash('lable_Location_info', '');

  the_form.target = '_parent';
  the_form.act.value = 'do_edit_print_template';
  the_form.submit();

  return true;
}

/**
 * 打印单背景图片删除
 */
function bg_del()
{
  //获取表单对象
 var		url = 'expressedit.php?id=<?php echo $id;?>&type=del';
 location.href	= url;
 
 

}

function bg_del_call_back(result)
{
  //==0 成功
  if (result.error == 0)
  {
    call_flash('bg_delete', '');
  }

}

/**
 * 打印单背景图片上传
 */
function bg_upload()
{
  //获取表单对象
  var the_form = this_obj("theForm");
  if (typeof(the_form) == "undefined")
  {
    return false; //程序错误
  }

  //判断是否选取了上传文件
  if (the_form.bg.value == '')
  {
    alert(no_select_upload);

    return false;
  }

  the_form.target = 'bg_upload_hidden';
  the_form.act.value = 'print_upload';

  the_form.submit();

  return true;

}

/**
 * 与模板Flash编辑器通信
 */
function call_flash(type, currt_obj)
{
  //获取flash对象
  var obj = this_obj("test");

  //执行操作
  switch (type)
  {
    case 'bg_delete': //删除打印单背景图片

      var result_del = obj.bg_delete();

      //执行成功 修改页面上传窗口为显示 生效
      if (result_del)
      {
        document.getElementById('pic_control_upload').style.display = display_yes;
        document.getElementById('pic_control_del').style.display = 'none';

        var the_form = this_obj("theForm");
        the_form.bg.disabled = "";
        the_form.bg.value = "";
        the_form.upload.disabled = "";
        the_form.upload_del.disabled = "disabled";
      }

    break;

    case 'bg_add': //添加打印单背景图片

      var result_add = obj.bg_add(currt_obj);

      //执行成功 修改页面上传窗口为隐藏 失效
      if (result_add)
      {
        document.getElementById('pic_control_upload').style.display = 'none';
        document.getElementById('pic_control_del').style.display = display_yes;

        var the_form = this_obj("theForm");
        the_form.bg.disabled = "disabled";
        the_form.upload.disabled = "disabled";
        the_form.upload_del.disabled = "";
      }

    break;

    case 'lable_add': //插入标签

      if (typeof(currt_obj) != 'object')
      {
        return false;
      }

      if (currt_obj.value == '')
      {
        alert(no_select_lable);

        return false;
      }

      var result = obj.lable_add('t_' + currt_obj.value, currt_obj.options[currt_obj.selectedIndex].text, 150, 50, 20, 100, 'b_' + currt_obj.value);
      if (!result)
      {
        alert('请不要重复添加');

        return false;
      }

    break;

    case 'lable_del': //删除标签

      var result_del = obj.lable_del();

      if (result_del)
      {
        //alert("删除成功！");
      }
      else
      {
        alert(no_select_lable_del);
      }

    break;

    case 'lable_Location_info': //获取标签位置信息

      var result_info = obj.lable_Location_info();

      return result_info;

    break;
  }

  return true;

}

/**
 * 获取页面Flash编辑器对象
 */
function this_obj(flash_name)
{
  var _obj;

  if (Browser.isIE)
  {
      _obj = window[flash_name];
  }
  else
  {
      _obj = document[flash_name];
  }

  if (typeof(_obj) == "undefined")
  {
    _obj = document[flash_name];
  }
  
  return _obj;

}
//-->
</script>