<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #F8F9FA;
}
-->
</style>

<link href="../images/skin.css" rel="stylesheet" type="text/css" />

<script language="javascript" type="text/javascript" src="../My97DatePicker/WdatePicker.js"></script>
<style type="text/css">
<!--
.STYLE1 {color: #CCCCCC}
-->
</style>
<body>
<?php 
include "include/dbconnect.php";
	include "include/cls_page.php";
	$dbcon	= new DBClass();


@require 'MIC_query.inc.php';


function getaddress($ip){
	
	$mic = & MIC_query::open('mic.dat');
	@$ret = $mic->query($_GET['ip']);
	@$ret = $mic->query($ip);

	// ret2 (ip2zone)
	@$mic->open('ip2zone.dat');
	$ret2 = $mic->query($ip);

	// ret3 (coral.dat)
	@$mic->open('coral.dat');
	$ret3 = $mic->query($ip);


	
	
	if (!$ret || is_null($ret[0])) $str .= '<font color="red">*NOT FOUND*</font>';
	else
	{
		$str .= '' . implode (' ', $ret);
	
	}
	
	$version = $mic->version();
	$mic->close();
	return $str;
	
	}
?>

<input name="ostatus" type="hidden" value="<?php echo $ostatus;?>" id="ostatus" />
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="17" height="29" valign="top" background="../images/mail_leftbg.gif"><img src="../images/left-top-right.gif" width="17" height="29" /></td>
    <td width="1138" height="29" valign="top" background="../images/content-bg.gif"><table width="100%" height="31" border="0" cellpadding="0" cellspacing="0" class="left_topbg" id="table2">
      <tr>
        <td height="31"><div class="titlebt">基本设置</div></td>
      </tr>
    </table></td>
    <td width="21" valign="top" background="../images/mail_rightbg.gif"><img src="../images/nav-right-bg.gif" width="16" height="29" /></td>
  </tr>
  <tr>
    <td height="71" valign="middle" background="../images/mail_leftbg.gif">&nbsp;</td>
    <td valign="top" bgcolor="#F7F8F9"><table width="100%" height="138" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="13" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td class="left_txt">当前位置：&nbsp;&nbsp;访问人数查看<BR></td>
          </tr>
          <tr>
            <td height="20"><table width="100%" height="1" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
              <tr>
                <td></td>
              </tr>
            </table></td>
          </tr>
          
          <tr>
            <td><table width="100%" height="31" border="0" cellpadding="0" cellspacing="0" class="nowtable" >
              <tr class="left_bt2">
                <td width="4%" class="left_bt2">                操作</td>
                <td width="25%" class="left_bt2">IP地址</td>
                <td width="44%" class="left_bt2">所在地</td>
                <td width="27%" class="left_bt2">时间</td>
                </tr>
			  <?php
			  	$sql		= "select count(*) as cc from ebay_log";
				$sql		= $dbcon->execute($sql);
				$sql		= $dbcon->getResultArray($sql);
				$total		= $sql[0]['cc'];

				$pagesize	= 100;
				
				$sql		= "select * from ebay_log order by id desc ";
				$pageindex  =( isset($_GET['pageindex']) )?$_GET['pageindex']:1;
				$limit = " limit ".($pageindex-1)*$pagesize.",$pagesize";
				$page=new page(array('total'=>$total,'perpage'=>$pagesize));
				$sql = $sql.$limit;
				$sql		= $dbcon->execute($sql);
				$sql		= $dbcon->getResultArray($sql);
				for($i=0;$i<count($sql);$i++){
					
					$ip				= $sql[$i]['ip'];
					$time			= $sql[$i]['time'];
					
					
					$ipa			= getaddress($ip);
					$address		= iconv("gb2312","UTF-8",$ipa);
			  ?>
			  
              <tr onMouseOver="this.style.background='#CCCCCC'" onMouseOut="this.style.background='#ffffff';"  >
                <td  class="left_bt2"><input name="ordersn" type="checkbox" id="ordersn" value="<?php echo $ordersn;?>" >
                &nbsp;</td>
                <td  class="left_bt2"><?php echo $ip;	?>&nbsp;</td>
                <td  class="left_bt2"><?php echo $ipa;?>&nbsp;</td>
                <td  class="left_bt2"><?php echo $time;	?>&nbsp;</td>
                </tr>
			  <?php }
			  		$dbcon->close();
					
			   ?>
            </table></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			    <tr>
                <td width="80%" height="17" colspan="4" align="right" ><div align="center"><?    echo '<br><center>'.$page->show(2)."</center>";//输出分页 ?></div></td>
              </tr>
            
            </table></td>
          </tr>
        </table>
          </td>
      </tr>
    </table></td>
    <td background="../images/mail_rightbg.gif">&nbsp;</td>
  </tr>
  <tr>
    <td valign="middle" background="../images/mail_leftbg.gif"><img src="../images/buttom_left2.gif" width="17" height="17" /></td>
      <td height="17" valign="top" background="../images/buttom_bgs.gif"><img src="../images/buttom_bgs.gif" width="17" height="17" /></td>
    <td background="../images/mail_rightbg.gif"><img src="../images/buttom_right2.gif" width="16" height="17" /></td>
  </tr>
</table>
</body>
<script type="text/javascript">
function check_all(obj,cName)
{
    var checkboxs = document.getElementsByName(cName);
    for(var i=0;i<checkboxs.length;i++){
		if(checkboxs[i].checked == false){
			
			checkboxs[i].checked = true;
		}else{
			
			checkboxs[i].checked = false;
		}	
		
	}
}
function packsp(){
	
	var bill	= "";
	var checkboxs = document.getElementsByName("ordersn");
    for(var i=0;i<checkboxs.length;i++){
		if(checkboxs[i].checked == true){
			
			bill = bill + ","+checkboxs[i].value;
		
		}	
		
	}
	if(bill == ""){
		
		alert("请选择订单号");
		return false;
	
	}
	
	window.open("../print/packslip.php?ordersn="+bill,"_blank");
	

}

function address(){

	var bill	= "";
	var checkboxs = document.getElementsByName("ordersn");
    for(var i=0;i<checkboxs.length;i++){
		if(checkboxs[i].checked == true){
			
			bill = bill + ","+checkboxs[i].value;
		
		}	
		
	}
	if(bill == ""){
		
		alert("请选择订单号");
		return false;
	
	}
	window.open("../print/address.php?ordersn="+bill,"_blank");
	

}

function invoice(){
	
	
	
	var bill	= "";
	var checkboxs = document.getElementsByName("ordersn");
    for(var i=0;i<checkboxs.length;i++){
		if(checkboxs[i].checked == true){
			
			bill = bill + ","+checkboxs[i].value;
		
		}	
		
	}
	if(bill == ""){
		
		alert("请选择订单号");
		return false;
	
	}
	window.open("../print/invoice.php?ordersn="+bill,"_blank");
}

function market(){
	var bill	= "";
	var checkboxs = document.getElementsByName("ordersn");
    for(var i=0;i<checkboxs.length;i++){
		if(checkboxs[i].checked == true){			
			bill = bill + ","+checkboxs[i].value;		
		}		
	}
	if(bill == ""){
		
		alert("请选择订单号");
		return false;	
	}
	var os = document.getElementsByName("ostatus").value;
	location.href ="order.php?type=market&status=1&ordersn="+bill+"&ostatus=1";
}

function oos(){
	var bill	= "";
	var checkboxs = document.getElementsByName("ordersn");
    for(var i=0;i<checkboxs.length;i++){
		if(checkboxs[i].checked == true){			
			bill = bill + ","+checkboxs[i].value;		
		}		
	}
	if(bill == ""){
		
		alert("请选择订单号");
		return false;	
	}
	var os = document.getElementsByName("ostatus").value;
	location.href ="order.php?type=market&status=2&ordersn="+bill+"&ostatus=2";
	
}

function wws(){
	var bill	= "";
	var checkboxs = document.getElementsByName("ordersn");
    for(var i=0;i<checkboxs.length;i++){
		if(checkboxs[i].checked == true){			
			bill = bill + ","+checkboxs[i].value;		
		}		
	}
	if(bill == ""){
		
		alert("请选择订单号");
		return false;	
	}
	var os = document.getElementsByName("ostatus").value;
	location.href ="order.php?type=market&status=0&ordersn="+bill+"&ostatus=0";
	
}
function delordersn(sn){

	
	if(confirm('确认删除此条记录')){
		var os = document.getElementById('ostatus').value;
		location.href='order.php?type=del&sn='+sn+"&ostatus="+os;
		
	}

}

function ship(){

	var ship = document.getElementById('ship').value;
	if(ship !=""){
		
		location.href='order.php?ostatus=4';
		
	
	}
}





</script>
</head>



