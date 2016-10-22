<?php require_once('includes/config.inc.php');
$str='';
//
 

 
 
 $text="储位详情批量导入";
  

?>
<?php
$title='录入'.$text;
?>
<script src='js/ajax.js'></script>

<div id="main_frame_main">
<div class="back_page"><a href="#" onclick="javascript:history.back();"><font color="#FFFFFF"> 后 退 </font></a></div>
<div>
  <h3>当前位置：<?php echo $title;?></h3>
</div>
<form action="import_pu_orders.php" method="post" enctype="multipart/form-data" name="form_files" id="form_files">
   
<div class="box_content_style">
  <div class="box_title_style">
     盘点详情批量导入  </div>
	
  <table border="0" cellpadding="0" cellspacing="0">
<!--<form action="import_ali_orders.php" method="post" enctype="multipart/form-data" name="form_files" id="form_files">-->
  <tr>
    <td align="right">
	 
	  <input name="act" type="hidden" id="act" value="upload" />
      选择订单:
      <input name="csvfiles" type="file" id="csvfiles"  lang="require"  title="请选择一个订单原文件"/>
	<!--- <input type="checkbox" name="add_orders_for_ex" value='1'/>2月1日至10日订单补导-->
	  </td>
    <td align="left">
	<!---  <input type="submit" name="Submit" value="提交" onclick="return form_chk(this.form);"/>
      <input type="reset" name="Submit2" value="放弃" />---></td>
  </tr>
<!--</form>-->
</table> 
</div>
 
 
</td>
  </tr>
 
  
  <tr>
    <td valign="middle">
	<input name="act" type="hidden" id="act" value="add" />
	<input type="submit" name="Submit" value="确定提交" style=" margin-left:60px;"  onclick="return form_chk(this.form);"/>
     </td>
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
  string='<div id="input_groups_'+number+'">'+number+'.SKU <input name="web_orders_sku[]" type="text" id="web_orders_sku'+number+'" size="10" onblur="show_object('+number+',this,\'sku\')" /> 产品中文名 <input name="web_orders_nm_cn[]" type="text" id="web_orders_nm_cn'+number+'" size="30"  lang="require"  title="产品中文名为必填项" onblur="show_object('+number+',this,\'nm_cn\')" /> 数量 <input name="web_orders_count[]" type="text" id="web_orders_count'+number+'" size="10"  lang="mustint"  title="产品数量为必填项且必须为数字"/> 单价 <input name="web_orders_total[]" type="text" id="web_orders_total'+number+'" size="10"  lang="mustint"  title="订单总计金额为必填项且必须为数字" value="0"/> <font style="cursor:pointer; color:#FF0000; font-family:\'宋体\'; font-size:14px;"><b onclick="clearinner(\'input_groups_'+number+'\');">×</b></font></div>';
  document.getElementById('orders_list_box').innerHTML=str+string;
  document.special_form.number_for_orders_list.value=number;
}
function clearinner(id)
{
document.getElementById(id).style.display='none';
document.getElementById(id).innerHTML='';
}
</script>
 