<!-- $Id: category_list.htm 14911 2008-09-23 05:18:39Z testyang $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>message管理</title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="../style.css" type="text/css" />
</head>
<style type="text/css">
body {
	font-family: Arial, Helvetica, sans-serif;
	font-size:12px;
	text-align:center;
	margin-top: 0px;
}

</style>
<body>
<?php
	
	include "include/config.php";
	
	if($_POST['submit']){
	
		
		$content 	= $_POST['content'];
		$messageid	= $_POST['mesid'];		
		$messageid	= explode(",",$messageid);
		
		for($i=0;$i<count($messageid);$i++){
			
			$msid	= $messageid[$i];
			if($msid != ""){
				
				AddMemberMessageRTQ($msid,$content,$_SESSION['truename']);
			}
			
		
		}
	
		
	
			
		
	
	}



?>
  <table width="95%" border="0" align="center" cellpadding="0" cellspacing="1" bordercolor="#999999" bgcolor="#CCCCCC">
  <tr>
    <td colspan="2" bgcolor="#FFFFFF"><div align="left">您所选批回复Message列表如下:</div></td>
  </tr>
  <?php
  		$messageid	= explode(",",$_REQUEST['messageid']);
		$g	= 0;
		
		for($i=0;$i<count($messageid);$i++){
			$mid	= $messageid[$i];
			
			if($mid	!= ""){
			$sql 			=	"select * from ebay_message where message_id='$mid'";
			$sql 			= 	$dbcon->execute($sql);
			$sql			= 	$dbcon->getResultArray($sql);
			$id			= $sql[0]['id'];
			$userid			= $sql[0]['sendid'];
			$subject		= $sql[0]['subject'];
			$rtime			= $sql[0]['createtime'];
			$recipientid 	= $sql[0]['recipientid'];
			$body			= $sql[0]['body'];
			$body		  	= str_replace("&acute;","'",$body);
			$body  			= str_replace("&quot;","\"",$body);
			
			
			$itemid			= $sql[0]['itemid'];
			$title			= $sql[0]['title'];
			$answer			= $sql[0]['replaycontent'];
			$sts		= $sql[0]['status']?"<font color=red>已回复</font>":"未回复";		
			$classid		= $sql[0]['classid'];
			
			$g++;
						
  ?>
  <tr>
    <td colspan="2" bgcolor="#FFFFFF">
      <div align="left">
        <table width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td width="7%">发件人</td>
            <td width="93%" colspan="3"><div align="left"><?php echo $userid; ?>
              &nbsp;</div></td>
          </tr>
          <tr>
            <td>收件人</td>
            <td colspan="3"><div align="left"><?php echo $recipientid; ?></div></td>
          </tr>
          <tr>
            <td>产品：</td>
            <td><?php echo "<a href=http://cgi.ebay.com/ws/eBayISAPI.dll?ViewItem&item={$itemid} target=_blank>".$title."</a>"; ?>;&nbsp;</td>
            <td>产品Item Number</td>
            <td><?php echo "Itemid:".$itemid; ?>&nbsp;</td>
          </tr>
          <tr>
            <td>主题</td>
            <td colspan="3"><div align="left"><?php echo nl2br($subject); ?></div></td>
          </tr>
          <tr>
            <td>内容</td>
            <td colspan="3"><div align="left"><?php echo nl2br($body); ?></div></td>
          </tr>
          <tr>
            <td>回复内容</td>
            <td colspan="3"><div align="left"><font color=blue><?php echo $answer ?></font></div></td>
          </tr>
        </table>
        <?php 
		
	
	
	
	
	
	
	

	$sy 			=	"select * from ebay_message where sendid='$userid' and id!=$id";
	$sy				= 	$dbcon->execute($sy);
	$sy				= 	$dbcon->getResultArray($sy);
	if(count($sy) == 0){
		
	//	echo "<font color=red>无历史记录</font>";
			
	}else{
	echo "<br><br><div style=\"border:3px #CCCCCC dotted\">历史记录<br>";
		for($o=0;$o<count($sy);$o++){
			$body			= $sy[$o]['body'];
			
			$body		  	= str_replace("&acute;","'",$body);
			$body  			= str_replace("&quot;","\"",$body);
			
			
			echo "eBay Account: ".nl2br($sy[$o]['recipientid'])."<br>";
			echo "主题: ".nl2br($sy[$o]['subject'])."<br>";
			echo "内容: ".nl2br($body)."<br>";
			echo "接收时间:".$sy[$o]['createtime']."<br>";
			echo "Itemid:".$sy[$o]['itemid']."<br>";
			echo "产品标题:".$sy[$o]['title']."<br><br>";
			echo "已回复内容:<br><font color=blue>".$sy[$o]['replaycontent']."</font><br>";
	
		}
		
	echo "</div>";
	}
	
	
	
	
	?>
   
        
    &nbsp;
    <table width="100%" border="0"  cellspacing="0" cellpadding="0">
      <tr>
        <td width="65%">&nbsp;</td>
        <td width="4%">&nbsp;</td>
        <td width="31%">&nbsp;</td>
      </tr>
    </table>
    </div></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#FFFFFF"></td>
  </tr>
    
  <?php
  		}
		}
  ?>
  <form method="post" action="ebaymessagereply.php?messageid=<?php echo $_REQUEST['messageid']; ?>" name="listForm">
  <input type="hidden" name="mesid" value="<?php echo $_REQUEST['messageid']; ?>" />
  
  <tr>
    <td width="71%" bgcolor="#FFFFFF"><div align="left">批量回复内容:<br />
        <textarea name="content" cols="80" rows="10" id="content"></textarea>
        <input name="submit" type="submit" value="提交回复" onclick="return check()"  />
    </div></td>
    <td width="29%" valign="top" bgcolor="#FFFFFF">
        <br />
        <p>常用模板: <br />
            <br />
            <?php
	
	$su		= "select * from ebay_messagetemplate where ebay_user='$user' and category='常用模板' order by ordersn desc";
	$su		= $dbcon->execute($su);
	$su		= $dbcon->getResultArray($su);
	for($o=0;$o<count($su);$o++){
		
		$name		= $su[$o]['name'];
		$content	= $su[$o]['content'];
		
		echo "<input name=\"nc$mid\" type=\"radio\" value=\"$content\" onclick=ck(this,'$mid','$userid') /> $name <br>";
		
		
	}
	
	
	
	?>
        </p>
        <p>一般模板</p>
        <p>
          <select name="category<?php echo $mid;?>" id="category<?php echo $mid;?>" onchange="ck(this,'<?php echo $mid ?>','<?php echo $userid; ?>')">
            <option value="">请选择</option>
            <?php
	
		$su		= "select * from ebay_messagetemplate where ebay_user='$user' and category='一般模板' order by ordersn desc";
		$su		= $dbcon->execute($su);
		$su		= $dbcon->getResultArray($su);
		for($o=0;$o<count($su);$o++){
			
			$name		= $su[$o]['name'];
			$content	= $su[$o]['content'];
			
		?>
            <option value="<?php echo $content; ?>"><?php echo $name;?></option>
            <?php } ?>
          </select>
        </p><br />
<div name="mstatus<?php echo $mid;?>" id="mstatus<?php echo $mid;?>"></div></td>
  </tr>
  </form>
</table>
</div>


</body>
</html>
<script type="text/javascript">
var msid	= 0;

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
		window.open("ebayaddress.php?ordersn="+bill,"_blank");
		
	
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
		window.open("ebayinvoice.php?ordersn="+bill,"_blank");
	}
	
	function market0(){
		var bill	= "";
		var checkboxs 	= document.getElementsByName("ordersn");
		
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){			
				bill = bill + ","+checkboxs[i].value;		
			}		
		}
		if(bill == ""){
			
			alert("请选择订单号");
			return false;	
		}
		
		var oss	= document.getElementById('ostatus').value;
		location.href ="ebayworder.php?type=market&orderstatus=0&ordersn="+bill+"&ostatus="+oss;
	}
	

	function market(){
		var bill	= "";
		var checkboxs 	= document.getElementsByName("ordersn");
		
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){			
				bill = bill + ","+checkboxs[i].value;		
			}		
		}
		if(bill == ""){
			
			alert("请选择订单号");
			return false;	
		}
		
		var oss	= document.getElementById('ostatus').value;
		location.href ="ebayworder.php?type=market&orderstatus=1&ordersn="+bill+"&ostatus="+oss;
	}
	
	function market2(){
		var bill	= "";
		var checkboxs 	= document.getElementsByName("ordersn");
		
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){			
				bill = bill + ","+checkboxs[i].value;		
			}		
		}
		if(bill == ""){
			
			alert("请选择订单号");
			return false;	
		}
		
		var oss	= document.getElementById('ostatus').value;
		location.href ="ebayworder.php?type=market&orderstatus=2&ordersn="+bill+"&ostatus="+oss;
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
		var os = document.getElementsById("ostatus").value;
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
			location.href='ebayworder.php?type=del&sn='+sn+"&ostatus="+os;
			
		}
	
	}

	function ship(){
	
		var ship = document.getElementById('ship').value;
		if(ship !=""){
			
			location.href='order.php?ostatus=4';
			
		
		}
	}

	function searchorder(){
	
		
		
		var content 	= document.getElementById('keys').value;
		location.href= 'ebayworder.php?keys='+content;
		
	}
	
	function ebaymarket(){
		
		
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
				
		var oss	= document.getElementById('ostatus').value;
		location.href ="ebayworder.php?type=marketship&orderstatus=2&ordersn="+bill+"&ostatus="+oss;	
	}
	
	function ems(){
		
		
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
				
		var oss	= document.getElementById('ostatus').value;
		var url	= "ebayems.php?ordersn="+bill;
		window.open(url,"_blank");
	}
	
	function check(){
		var oss	= document.getElementById('content').value;
		if(oss == ""){
			
			alert("回复内容不能为空");
			return false;
		
		}
	
	}
	
	function ck(ck,id,userid){
	
	
		var va		= ck.value;		
		var url		= "getajax.php";
		var param	= "type=message&mid="+id+"&body="+va;
		msid = id;
		
		sendRequestPost(url,param);
		
		
	
	}
	
	var xmlHttpRequest;  
    function createXMLHttpRequest(){  
        try  
        {  
       // Firefox, Opera 8.0+, Safari  
        xmlHttpRequest=new XMLHttpRequest();  
        }  
     catch (e)  
        {  
  
      // Internet Explorer  
       try  
          {  
           xmlHttpRequest=new ActiveXObject("Msxml2.XMLHTTP");  
          }  
       catch (e)  
          {  
  
          try  
             {  
              xmlHttpRequest=new ActiveXObject("Microsoft.XMLHTTP");  
             }  
          catch (e)  
             {  
             alert("您的浏览器不支持AJAX！");  
             return false;  
             }  
          }  
        }  
  
    }  
    //发送请求函数  
    function sendRequestPost(url,param){
		document.getElementById('mstatus'+msid).innerHTML="<img src=cx.gif />";
		
        createXMLHttpRequest();  
        xmlHttpRequest.open("POST",url,true);  
        xmlHttpRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded");  
        xmlHttpRequest.onreadystatechange = processResponse;  
        xmlHttpRequest.send(param);  
    }  
    //处理返回信息函数  
    function processResponse(){
	

	
        if(xmlHttpRequest.readyState == 4){  
            if(xmlHttpRequest.status == 200){  
                var res = xmlHttpRequest.responseText;  
			
				
				document.getElementById('content').value = res;
            }else{  
                window.alert("请求页面异常");  
            }  
			//document.getElementById('mstatus'+msid).innerHTML="";
			document.getElementById('mstatus'+msid).innerHTML="";
			
        }  
    }  
	

</script>
