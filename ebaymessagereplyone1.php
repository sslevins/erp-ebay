<!-- $Id: category_list.htm 14911 2008-09-23 05:18:39Z testyang $ -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<title>Message</title>

<meta name="robots" content="noindex, nofollow">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/yui.css" />

<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/deprecated.css" />

<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/style.css" /> 

<style type="text/css">
<!--
.STYLE1 {font-size: 14px}
-->
</style>
</head>



<body>

<?php

	

	include "include/config.php";

	

	if($_REQUEST['type'] == "reply"){

	

		

		$content 	= $_REQUEST['content'];

		$mid		= $_REQUEST['mesid'];

		

		



	

		

		AddMemberMessageRTQ($mid,$content,$_SESSION['truename']);		

	

	}

	

	

	$addmid		= "";

	





?>



<form name="ddd" method="post" action="rp.php" target="_blank">



  <table width="80%" border="0" align="center" cellpadding="0" cellspacing="1" bordercolor="#999999" bgcolor="#CCCCCC">

  <tr>

    <td colspan="3" bgcolor="#FFFFFF">您所选批回复Message列表如下:</td>

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
			$userid			= $sql[0]['sendid'];
			$id			= $sql[0]['id'];
			$subject		= $sql[0]['subject'];
			$rtime			= $sql[0]['createtime'];
			$recipientid 	= $sql[0]['recipientid'];
			$body			= $sql[0]['body'];
			$body		  	= str_replace("&acute;","'",$body);
			$body  			= str_replace("&quot;","\"",$body);
			$itemid			= $sql[0]['itemid'];
			$title			= $sql[0]['title'];
			$answer			= $sql[0]['replaycontent'];
			$sts			= $sql[0]['status']?"<font color=red>已回复</font>":"未回复";
			$classid		= $sql[0]['classid'];
			$addmid			.= $mid."**";
			$g++;

						

  ?>

  <tr>

    <td colspan="3" bgcolor="#FFFFFF">

      <div align="left">

        <table width="100%" border="0" cellspacing="2" cellpadding="2">

          <tr>

            <td><div class="STYLE1" style="width:70px">发件人</div></td>

            <td colspan="2"><span class="STYLE1"><?php echo $userid; ?> &nbsp;</span></td>
          </tr>
          <tr>
            <td colspan="3"><div style="border:1px dashed #CC00CC; height:1px"></div></td>
            </tr>

          <tr>

            <td width="60"><span class="STYLE1">收件人</span></td>

            <td colspan="2"><span class="STYLE1"><?php echo $recipientid; ?></span></td>
          </tr>
     <tr>
            <td colspan="3"><div style="border:1px dashed #CC00CC; height:1px"></div>&nbsp;</td>
            </tr>
          <tr>

            <td width="60"><span class="STYLE1">产品：</span></td>

            <td width="3%"><span class="STYLE1"><?php echo "<a href=http://cgi.ebay.com/ws/eBayISAPI.dll?ViewItem&item={$itemid} target=_blank>".$title."</a>"; ?></span></td>

            <td width="3%"><span class="STYLE1"><?php echo "Itemid:".$itemid; ?>&nbsp;</span></td>
          </tr>
     <tr>
            <td colspan="3"><div style="border:1px dashed #CC00CC; height:1px"></div>&nbsp;</td>
            </tr>
          <tr>

            <td width="60"><span class="STYLE1">主题</span></td>

            <td colspan="2"><span class="STYLE1"><?php echo nl2br($subject); ?></span></td>
          </tr>
     <tr>
            <td colspan="3"><div style="border:1px dashed #CC00CC; height:1px"></div>&nbsp;</td>
            </tr>
          <tr>

            <td width="60" valign="top"><span class="STYLE1">内容</span></td>

            <td valign="top">

<div style="height:300px; width:700px; overflow-x:auto; overflow-y:auto; border:1px">
<span class="STYLE1"><?php echo $body;?></span></div>

			</td>

            <td valign="top">
            
            <div style=" height:300px; width:800px; overflow-x:auto; overflow-y:auto; border:1px">
            
      
            <?php 

		

		



		$sy 			=	"select * from ebay_message where sendid='$userid' and sendid !='eBay' and id!=$id";
		$sy				= 	$dbcon->execute($sy);
		$sy				= 	$dbcon->getResultArray($sy);
		if(count($sy) != 0){			


	//		echo "<div style=\"border:3px #CCCCCC dotted\">历史记录<br>";
			for($o=0;$o<count($sy);$o++){

				$body			= $sy[$o]['body'];
				$body		  	= str_replace("&acute;","'",$body);
				$body  			= str_replace("&quot;","\"",$body);
				$str			= "记录".($o+1)." 接收时间：".$sy[$o]['createtime']."Itemid:".$sy[$o]['itemid']." <br>产品标题:".$sy[$o]['title'];
				echo '<div style="border:1px dashed #CC00CC; height:50px"><h1><strong>'.$str.'</strong></h1></div>';
				echo "eBay Account: ".nl2br($sy[$o]['recipientid'])."<br>";
				echo "主题: ".nl2br($sy[$o]['subject'])."<br>";
				echo "内容: ".''.nl2br($body)."<br>";
				echo "已回复内容:<br><font color=blue>".$sy[$o]['replaycontent']."</font><br>";
		//		echo "</div>";
				
			}
	//		echo "</div>";
			
		}
	

	

	?>

    
            
           </div></td>
          </tr>
     <tr>
            <td colspan="3"><div style="border:1px dashed #CC00CC; height:1px"></div>&nbsp;</td>
            </tr>
          <tr>

            <td width="60"><span class="STYLE1">回复内容</span></td>

            <td colspan="2"><span class="STYLE1"><font color="blue"><?php echo $answer ?></font></span></td>
          </tr>
        </table>


        <br />

        <br />

          </div>

    <tr>

    <td align="left" valign="top" bgcolor="#FFFFFF"><div align="left">回复内容:<br />

        <textarea name="content<?php echo $mid; ?>" cols="70" rows="10" id="content<?php echo $mid; ?>"></textarea>
<BR>
        <input name="submit" type="button" value="Reply" onclick="return check('<?php echo $mid;?>')"  />
        <input name="input5" type="button" value="标为已回复" onclick="marketyh('<?php echo $mid;?>')" />
    将此Message转到
    <select name="mm2<?php echo $mid;?>" id="mm2<?php echo $mid;?>" onchange="classid('<?php echo $mid;?>')">
      <option value="0">请选择</option>
      <?php	

		$so	= "select * from ebay_messagecategory where ebay_user='$user'";	

		$so	= $dbcon->execute($so);

		$so = $dbcon->getResultArray($so);		

		for($ii=0;$ii<count($so);$ii++){			

			$cname		= $so[$ii]['category_name'];

			$cid		= $so[$ii]['id'];		

	   ?>
      <option <?php if($type == $cid) echo "selected" ?> value="<?php echo $cid;?>"><?php echo $cname; ?></option>
      <?php }  ?>
    </select>
分类	&nbsp;</div></td>

    <td align="left" valign="top" bgcolor="#FFFFFF"><p><br />

      常用模板:

      <br />

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
        
        
           <br />
		<?php 
				  
				  	$kk = "select * from ebay_templatecategory ";
					
					
			
					
					$kk = $dbcon->execute($kk);
					$kk = $dbcon->getResultArray($kk);
			
					
					for($k=0;$k<count($kk);$k++){
						
						$kname 	= $kk[$k]['name'];
						$kid 	= $kk[$k]['id'];
						
						
						echo "<br>".$kname;	
				  ?>
                  <br />

                  <select name="category<?php echo $mid;?>" id="category<?php echo $mid;?>" onchange="ck(this,'<?php echo $mid ?>','<?php echo $userid; ?>')">
<option value="">请选择</option>
<?php

	

		$su		= "select * from ebay_messagetemplate where ebay_user='$user' and category='$kname' order by ordersn desc";
		$su		= $dbcon->execute($su);
		$su		= $dbcon->getResultArray($su);
		for($o=0;$o<count($su);$o++){
			$name		= $su[$o]['name'];
			$content	= $su[$o]['content'];	

		?>
          <option value="<?php echo $content; ?>"><?php echo $name;?></option>

       

      <?php } ?>

        </select>
                  
                  
                  <?php
				  
				  }
				  
				  ?>

        
        <div name="mstatus<?php echo $mid;?>" id="mstatus<?php echo $mid;?>"></div>

        <br />

        </p></td>

    <td align="left" valign="top" bgcolor="#FFFFFF">客户订单信息: :<a href="orderindex.php?keys=<?php echo $userid;?>&account=&sku=&module=orders&action=Sold&ostatus=100" target='_blank'>查看该客户的所有订单信息</a><br />
    
    	<table width="100%" border="0" cellpadding="3" cellspacing="1" bordercolor="#000000" bgcolor="#000000">
        
          <tr>
    <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">Sale record&nbsp;</td>
    <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">Item No&nbsp;</td>
    <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">Ship Date</td>
    <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">Seller&nbsp;</td>
    <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">付款&nbsp;</td>
    <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">寄送&nbsp;</td>
    <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">重寄&nbsp;</td>
    <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">退款&nbsp;</td>
    <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">Tracking&nbsp;</td>
    <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">操作&nbsp;</td>
  </tr>


        

      <?php

		$ss		= "select * from ebay_order where ebay_userid = '$userid' order by recordnumber desc";
		$ss		= $dbcon->execute($ss);
		$ss		= $dbcon->getResultArray($ss);		
		for($t=0;$t<count($ss);$t++){
	
			$ebay_ordersn				= $ss[$t]['ebay_ordersn'];
			$ebay_userid				= $ss[$t]['ebay_userid'];
			$ebay_status				= $ss[$t]['ebay_status'];
			$orderstatus				= '';			
			if($ebay_status		== '0'){				
				$orderstatus		= '等待付款';			
			}elseif($ebay_status	== '1'){				
				$orderstatus		= '已付款';			
			}elseif($ebay_status	== '2'){			
				$orderstatus		= '已付款，已发出';
			}else{			
				$si						= "select * from ebay_topmenu where id='$ebay_status'";
				$si						= $dbcon->execute($si);
				$si						= $dbcon->getResultArray($si);
				$orderstatus			= $si[0]['name'];	
			}			
			$recordnumber				= $ss[$t]['recordnumber'];
			$ebay_account				= $ss[$t]['ebay_account'];
			$ebay_paidtime				= $ss[$t]['ebay_paidtime'];
			$ShippedTime				= $ss[$t]['ShippedTime'];
			$RefundAmoun				= $ss[$t]['RefundAmoun'];
			$ebay_tracknumber				= $ss[$t]['ebay_tracknumber'];			
			$paidbj						= '';
			$shipbj						= '';
			$refubj						= '';
			$tackbj						= '';			
			if($ebay_tracknumber != ''){				
				$tackbj					= '√';				
			}else{			
				$tackbj					= 'X';
			}			
			if($ebay_paidtime >0){
				
				$paidbj					= '√';
				
			}else{
			
				$paidbj					= 'X';
			}
			
			
			if($ShippedTime >0){
				
				$shipbj					= '√';
				
			}else{
			
				$shipbj					= 'X';
			}
			
			
			
		
			if($RefundAmoun >0){
				
				$refubj					= '√';
				
			}else{
			
				$refubj					= 'X';
			}
			
			
						
			$urlno						="<a href='ordermodifive.php?ordersn=".$ebay_ordersn."&module=orders&action=Modifive%20Order' target='_blank'>".$recordnumber."</a>";	
			
			$rr							= "select * from ebay_orderdetail where ebay_ordersn='$ebay_ordersn'";
			$rr							= $dbcon->execute($rr);
			$rr							= $dbcon->getResultArray($rr);
			$ebay_itemid				= $rr[0]['ebay_itemid'];			
		?>
        
  <tr>
    <td bordercolor="#FFFFFF" bgcolor="#FFFFFF"><?php echo $urlno; ?>&nbsp;</td>
    <td bordercolor="#FFFFFF" bgcolor="#FFFFFF"><?php echo $ebay_itemid; ?>&nbsp;</td>
    <td bordercolor="#FFFFFF" bgcolor="#FFFFFF"><?php 
	
	if($ShippedTime >0){ 
	echo date('Y-m-d',$ShippedTime);
	
	}
	
	
	
	
	?>&nbsp;</td>
    <td bordercolor="#FFFFFF" bgcolor="#FFFFFF"><?php echo $ebay_account;?>&nbsp;</td>
    <td bordercolor="#FFFFFF" bgcolor="#FFFFFF"><?php echo $paidbj; ?>&nbsp;</td>
    <td bordercolor="#FFFFFF" bgcolor="#FFFFFF"><?php echo $shipbj; ?>&nbsp;</td>
    <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">
    <?php
		
		
		if($ebay_status == '992'){
				
				echo '√';
				
		}else{
			
				echo  'X';
		}
			
	
	
	
	?>    </td>
    <td bordercolor="#FFFFFF" bgcolor="#FFFFFF"><?php 

		
		if($ebay_status == '995'){
				
				echo '√';
				
		}else{
			
				echo  'X';
		}
			
	
	
	
	?>
    &nbsp;</td>
    <td bordercolor="#FFFFFF" bgcolor="#FFFFFF"><?php echo $tackbj; ?>&nbsp;</td>
    <td bordercolor="#FFFFFF" bgcolor="#FFFFFF"><a href="#ddd<?php echo $mdi;?>" id=="ddd<?php echo $mdi;?>" onClick="view('<?php echo $ebay_ordersn; ?>','<?php echo $mid; ?>')">view</a><br>&nbsp;</td>
  </tr>
<?php	}  ?>    
      </table> 
      <div name="dstatus<?php echo $mid;?>" id="dstatus<?php echo $mid;?>"></div>
      
      
      </td>

    </tr>



  

    

    &nbsp;<tr><td bgcolor="#FFFFFF"></td>

  <td bgcolor="#FFFFFF">  

  <td bgcolor="#FFFFFF">  

    </tr>

  <tr>

    <td colspan="3" bgcolor="#FFFFFF"></td>

  </tr>

    

  <?php

  		}

		}

  ?>



  <tr>

    <td colspan="3" bgcolor="#FFFFFF">&nbsp;</td>

  </tr>

</table>

<input type="hidden" name="addmid" id="addmid" value="<?php echo $addmid;?>" />



 </form>



</div>





</body>

</html>

<script type="text/javascript">



var msid	= 0;
var currentorder = '';

	function editorders(){
	
			
		var url		= "ordermodifive.php?ordersn="+currentorder+"&module=orders&action=Modifive%20Order";		
		openwindow(url,'00',1050,885);
	
	}
	
	function resend(){
	
			
		var url		= "messageoperation.php?ordersn="+currentorder+"&module=resend";		
		openwindow(url,'00',500,500);
	
	}
	
	function refund(){
	
			
		var url		= "messageoperation.php?ordersn="+currentorder+"&module=refund";		
		openwindow(url,'00',500,500);
	
	}
	
	function calcenorder(){
	
			
		var url		= "messageoperation.php?ordersn="+currentorder+"&module=calcenorder";		
		openwindow(url,'00',500,500);
	
	}
	
	
		function feedback(){
	
			
		var url		= "messagefeedback.php?ordersn="+currentorder+"&module=refund";		
		openwindow(url,'00',500,500);
	
	}


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

	
	function view(ordersn,id){
		
		
	
		currentorder	= ordersn;
		
		var param	= "type=getorderdetails&ordersn="+ordersn;
		var url		= "getajax.php";
		document.getElementById('dstatus'+id).innerHTML="<img src=cx.gif />";
		msid = id;
		sendRequestPostview(url,param);
		
	
	
	
	}
	    function sendRequestPostview(url,param){
        createXMLHttpRequest();  
        xmlHttpRequest.open("POST",url,true); 
        xmlHttpRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
        xmlHttpRequest.onreadystatechange = processResponseview; 
        xmlHttpRequest.send(param); 
    }  
    //处理返回信息函数 
    function processResponseview(){
        if(xmlHttpRequest.readyState == 4){  
            if(xmlHttpRequest.status == 200){  
                var res = xmlHttpRequest.responseText;  
				document.getElementById('dstatus'+msid).innerHTML = res;
            }
			document.getElementById('dstatus'+msid).innerHTML = res;
			
			document.getElementById('content'+msid).focus();
			
			
        }  

    }  

	
	function classid(id){

		document.getElementById('mstatus'+id).innerHTML="<img src=cx.gif />";
		var url		= "getajax.php";
			msid = id;
			
		var categoryid		= document.getElementById('mm2'+id).value;
		
		var param	= "type=changecateogry&mid="+id+"&categoryid="+categoryid;
		
		
		if(confirm("确认移动到所选分类吗？")){
		
			
			sendRequestPostreply(url,param);
			
		
		}

	

	}
	
	
	
	function marketyh(id){


		document.getElementById('mstatus'+id).innerHTML="<img src=cx.gif />";
		var url		= "getajax.php";
			msid = id;
		var param	= "type=changestatus&mid="+id;
		
		if(confirm("确认标记已回复吗？")){
		
			
			sendRequestPostreply(url,param);
			
		
		}
		
		

		

	

	}
	




	

	function check(id){

		var oss	= document.getElementById('content'+id).value;

		if(oss == ""){

			

			alert("回复内容不能为空");

			document.getElementById('content'+id).focus();
			
			

			return false;

		

		}

		document.getElementById('mstatus'+id).innerHTML="<img src=cx.gif />";

		

		var url		= "getajax.php";

		var param	= "type=replymessage&mid="+id+"&body="+oss;

		msid = id;

		
	
		
		sendRequestPostreply(url,param);

		

		

		//var url = "ebaymessagereplyone.php?type=reply&messageid=<?php echo $_REQUEST['messageid']; ?>&mesid="+id+"&content="+encodeURIComponent(oss);	

		//window.open(url,"_blank");

		

	

	}

	

	function ck(ck,id,userid){

	

		document.getElementById('mstatus'+id).innerHTML="<img src=cx.gif />";

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
			
				
				document.getElementById('content'+msid).value = res;
            }
			document.getElementById('mstatus'+msid).innerHTML="";
        }  

    }  

	

	

	

	

	 function sendRequestPostreply(url,param){

		

		

        createXMLHttpRequest();  

        xmlHttpRequest.open("POST",url,true);  

        xmlHttpRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded");  

        xmlHttpRequest.onreadystatechange = processResponsereply;  

        xmlHttpRequest.send(param);  

    }  

    //处理返回信息函数  

    function processResponsereply(){
		

        if(xmlHttpRequest.readyState == 4){  

            if(xmlHttpRequest.status == 200){  

                var res = xmlHttpRequest.responseText;  
		
				
			

				

				if(res.indexOf("0") >0 ){

					

					document.getElementById('mstatus'+msid).innerHTML='<font color="#006600"> Success</font>';

				

				}else{

				

					document.getElementById('mstatus'+msid).innerHTML='<font color="red"> Failure</font>';

					

				}

				

				

				

            }else{  

                window.alert("请求页面异常");  

            }  

			//document.getElementById('mstatus'+msid).innerHTML="";

			

			

        }  

    } 
	
	
	function openwindow(url,name,iWidth,iHeight)

{

var url; //转向网页的地址;

var name; //网页名称，可为空;

var iWidth; //弹出窗口的宽度;

var iHeight; //弹出窗口的高度;

var iTop = (window.screen.availHeight-30-iHeight)/2; //获得窗口的垂直位置;

var iLeft = (window.screen.availWidth-10-iWidth)/2; //获得窗口的水平位置;

window.open(url,name,'height='+iHeight+',,innerHeight='+iHeight+',width='+iWidth+',innerWidth='+iWidth+',top='+iTop+',left='+iLeft+',toolbar=no,menubar=no,scrollbars=auto,resizeable=no,location=no,status=no');

}


	function win(vaurl){
	
		alert(vaurl);
		
		
		openwindow(url,'00',550,385);
	
	
	}



	



</script>

