<!-- $Id: category_list.htm 14911 2008-09-23 05:18:39Z testyang $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Message</title>
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
	
	if($_REQUEST['type'] == "reply"){
	
		
		$content 	= $_REQUEST['content'];
		$mid		= $_REQUEST['mesid'];
		
		

	
		
		AddMemberMessageRTQ($mid,$content,$_SESSION['truename']);		
	
	}



?>

  <table width="95%" border="0" align="center" cellpadding="0" cellspacing="1" bordercolor="#999999" bgcolor="#CCCCCC">
  <tr>
    <td colspan="2" bgcolor="#FFFFFF">您所选批回复Message列表如下:</td>
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
        <?php 
	echo ($g)."、BuyerID:<a href=http://myworld.ebay.com/{$userid}/ target=_blank>".$userid."</a><br>";
		echo "eBay Account: ".$recipientid ."<br>";
	
	
	echo "主题: ".nl2br($subject)."<br>";
	echo "内容: ".nl2br($body)."<br>";
	echo "接收时间:".$rtime."<br>";
	echo "Itemid:".$itemid."<br>";
	echo "产品标题:<a href=http://cgi.ebay.com/ws/eBayISAPI.dll?ViewItem&item={$itemid} target=_blank>".$title."</a><br><br>";
	
	echo "已回复内容:<br><font color=blue>".$answer."</font><br>";
	
	
	echo "<br>Message 状态: $sts";
	
		echo "<br><br><div style=\"border:3px #990066 dotted\">历史记录<br>";

	$sy 			=	"select * from ebay_message where sendid='$userid' and id!=$id";
	$sy				= 	$dbcon->execute($sy);
	$sy				= 	$dbcon->getResultArray($sy);
	if(count($sy) == 0){
		
		echo "<font color=red>无历史记录</font>";
			
	}else{
	
	
		for($o=0;$o<count($sy);$o++){
		
			echo "eBay Account: ".nl2br($sy[$o]['recipientid'])."<br>";
			echo "主题: ".nl2br($sy[$o]['subject'])."<br>";
			echo "内容: ".nl2br($sy[$o]['body'])."<br>";
			echo "接收时间:".$sy[$o]['createtime']."<br>";
			echo "Itemid:".$sy[$o]['itemid']."<br>";
			echo "产品标题:".$sy[$o]['title']."<br><br>";
			echo "已回复内容:<br><font color=blue>".$sy[$o]['replaycontent']."</font><br>";
	
		
		}
		
		
	
	
	}
	
	echo "</div>";
	
	
	
		
	
	
	?>
        <br />
        <br />
        
        
        
          </div>
    <tr>
    <td width="71%" bgcolor="#FFFFFF"><div align="left">回复内容:<br />
        <textarea name="content<?php echo $mid; ?>" cols="80" rows="10" id="content<?php echo $mid; ?>"></textarea>
        <input name="submit" type="submit" value="提交回复" onclick="return check('<?php echo $mid;?>')"  />
    </div></td>
    <td width="29%" align="left" valign="top" bgcolor="#FFFFFF">
    所属分类：<?php
    	$so	= "select * from ebay_messagecategory where id='$classid'";
		$so	= $dbcon->execute($so);
		$so = $dbcon->getResultArray($so);
		echo $so[0]['category_name']?$so[0]['category_name']:"未分类";
		
     
	 ?>
	
    <br />

    
    当前模板选择:
    <br />
    <br />

	<?php
	
	$su		= "select * from ebay_messagetemplate where ebay_user='$user' order by id desc";
	$su		= $dbcon->execute($su);
	$su		= $dbcon->getResultArray($su);
	for($o=0;$o<count($su);$o++){
		
		$name		= $su[$o]['name'];
		$content	= $su[$o]['content'];
		
		echo "<input name=\"nc$mid\" type=\"radio\" value=\"$content\" onclick=ck(this,'$mid','$userid') /> $name <br>";
		
		
	}
	
	
	
	?>    </td>
  </tr>

  
    
    &nbsp;<td bgcolor="#FFFFFF"></td>
  <td bgcolor="#FFFFFF"></tr>
  <tr>
    <td colspan="2" bgcolor="#FFFFFF">---------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td>
  </tr>
    
  <?php
  		}
		}
  ?>


</table>
</div>


</body>
</html>
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
	


	
	function check(id){
		var oss	= document.getElementById('content'+id).value;
		if(oss == ""){
			
			alert("回复内容不能为空");
			document.getElementById('content'+id).focus();
			
			return false;
		
		}
		location.href= "ebaymessagereplyone.php?type=reply&messageid=<?php echo $_REQUEST['messageid']; ?>&mesid="+id+"&content="+encodeURIComponent(oss);	
	
	}
	
	function ck(ck,id,userid){
	
	
		var va	= ck.value;
		va		= va.replace("*buyerid*",userid)
		document.getElementById('content'+id).value = va;
	
	}

</script>
