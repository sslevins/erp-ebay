<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>订单信件发送结果</title>

<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/yui.css" />

<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/deprecated.css" />

<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/style.css" /> 
</head>
<body>

<?PHP

/*<input type="button" value="我需要清空发送数据，重新测试" style="width:300px; height:50px" onclick="cr()" />
*/
?>
<?php
include "include/config.php";


/*

{BuyerID}:指客户ID
{title}:产品标题
{itemlink}:产品链接
{item#}:产品编号
*/


function sendmessagetemplate($ordersn){
	
	global $dbcon,$user;
	$sql			= "select * from ebay_order as a where ebay_id='$ordersn'";	
	

	

	
	$sql			= $dbcon->execute($sql);
	$sql			= $dbcon->getResultArray($sql);
	
	$userid			= $sql[0]['ebay_userid'];
	$tid			= $sql[0]['ebay_tid'];
	$oid			= $sql[0]['ebay_id'];
	$ebay_carrier	= $sql[0]['ebay_carrier']; //templateid
	$ordersn		= $sql[0]['ebay_ordersn']; //templateid

	
	$ss				= "select * from ebay_fahuo where name='$ebay_carrier' and ebay_user='$user'";
	$ss				= $dbcon->execute($ss);
	$ss				= $dbcon->getResultArray($ss);
	$templateid		= $ss[0]['id'];



	
	
	
	$account	= $sql[0]['ebay_account'];
	$ebay_total	= $sql[0]['ebay_total'];
	$ebay_markettime	= date('Y-m-d',strtotime($sql[0]['ebay_markettime']));
	$recordnumber 		= $sql[0]['recordnumber'];
	$ebay_countryname  	= $sql[0]['ebay_countryname'];
	$ebay_tracknumber  	= $sql[0]['ebay_tracknumber'];
	$bb					= "select * from ebay_account where ebay_account='$account'";
	$bb					= $dbcon->execute($bb);
	$bb					= $dbcon->getResultArray($bb);
	$smail				= $bb[0]['mail'];
	$userToken			= $bb[0]['ebay_token'];
	
	$sql		= "select * from ebay_orderdetail as a where ebay_ordersn='$ordersn'";	
	
	$sql		= $dbcon->execute($sql);
	$sql		= $dbcon->getResultArray($sql);	
	$tjstr		= "";
	for($i=0;$i<count($sql);$i++){	
		$tjstr	.= "ItemID='".$sql[$i]['ebay_itemid']."'"." or ";
	}
	$itemid			= $sql[0]['ebay_itemid'];
	$itemtitle		= $sql[0]['ebay_itemtitle'];
	


	
	
	$tjstr		= substr($tjstr,0,strlen($tjstr)-3);
	
	$sql		= "select id from ebay_feedback where CommentingUser='$userid' and ($tjstr)";
	
	if($tid != '' ) $sql .= "  and TransactionID='$tid' ";
	
	

	$sql		= $dbcon->execute($sql);
	$sql		= $dbcon->getResultArray($sql);
	if(count($sql)>0){
		
		$postive	 = $sql[0]['CommentType'];
		
		
		echo "<br>客户已经留下好评";
		$sql	= "update ebay_order set mailstatus='2',postive='$postive' where ebay_ordersn='$ordersn'";
		$dbcon->execute($sql);
	
	}else{
	
		//将订单标记正在发信中的订单
		
		$sg			= "update ebay_order set mailstatus='1' where ebay_ordersn='$ordersn'";
		$dbcon->execute($sg);
		
		$sql		= "select * from ebay_messagelog where order_id='$oid' order by id desc";
		$sql		= $dbcon->execute($sql);
		$sql		= $dbcon->getResultArray($sql);
		
		
		$addtime	= strtotime(date("Y-m-d H:i:s"));
	    $runstatus	= "";
		
		if(count($sql) == 0){
			
			$st				= "select * from ebay_fahuoprocess where corder='1' and pid='$templateid'";
			$st				= $dbcon->execute($st);
			$st				= $dbcon->getResultArray($st);
		
		
		
			$mid			= $st[0]['template'];				
			$st				= "select * from ebay_messagetemplate where id='$mid'";
			$st				= $dbcon->execute($st);
			$st				= $dbcon->getResultArray($st);
			
			if(count($st) >= 1){
				
				$tempatestr 	= $st[0]['content'];		
				$tempatestr		= getmessageformatstr($ordersn,$tempatestr);
				$subject		= '';
				$ordernumber	=1;
				$runstatus		  = addmessagetoparner($tempatestr,$userToken,$subject,$itemid,$userid);
				if($runstatus == "Success"){
					echo " <br>-[<font color='#33CC33'>发送成功</font>]";
				}else{
					echo " <br>-[<font color='#FF0000'>发送失败：".$runstatus."</font>]";
				}
				$tempatestr		  = str_rep($tempatestr);			
				$se		= "insert into ebay_messagelog(order_id,ordernumber,messagetemplate,time,status) values('$oid','1','$tempatestr','$addtime','$runstatus')";
				$dbcon->execute($se);
			
			}else{
			
				
				echo '<font color=red>未设置信件流程</font>';
				
			
			}
			
						
		}else{
			
			$lastsendtime		= $sql[0]['time'];
			$ordernumber		= $sql[0]['ordernumber']+1;
			$st					= "select * from ebay_messagelog where order_id='$oid' and ordernumber='$ordernumber'";
			$st					= $dbcon->execute($st);
			$st					= $dbcon->getResultArray($st);
		
			
			if(count($st) == 0){	
		
					
				$st				= "select * from ebay_fahuoprocess where corder='$ordernumber' and pid='$templateid'";
				$st				= $dbcon->execute($st);
				$st				= $dbcon->getResultArray($st);
				$days			= $st[0]['days'];
				$mid			= $st[0]['template'];				
				$st				= "select * from ebay_messagetemplate where id='$mid'";
				$st				= $dbcon->execute($st);
				$st				= $dbcon->getResultArray($st);
				$tempatestr		= $st[0]['content'];	
				$tempatestr		= getmessageformatstr($ordersn,$tempatestr);			
				$subject		= '';
				$la				= date('Y-m-d H:i:s',$lastsendtime);
				
				$rundays		= date('Y-m-d',strtotime("$la +{$days} days"));
				$ctime			= strtotime(date('Y-m-d H:i:s'));		//当前系统日期
				$ltime			= strtotime($rundays);//上次执行日期，加上下次系统调用执行日期


				
				if($ctime >=$ltime && $tempatestr !=''){    //时间
				
	
					$runstatus	= addmessagetoparner($tempatestr,$userToken,$subject,$itemid,$userid);
					if($runstatus == "Success"){
			
						echo " <br>-[<font color='#33CC33'>发送成功</font>]";
					
					}else{
					
						echo " <br>-[<font color='#FF0000'>发送失败：".$runstatus."</font>]";
					}			
			
					$tempatestr		  = str_rep($tempatestr);
					$addtime = strtotime(date('Y-m-d H:i:s'));

					$se			= "insert into ebay_messagelog(order_id,ordernumber,messagetemplate,time,status) values('$oid','$ordernumber','$tempatestr','$addtime','$runstatus')";
					$dbcon->execute($se);
				
				}
				
				
				
			
			}
			
			
			/**/
			$st				= "select count(*) as cc from ebay_fahuoprocess where pid='$templateid' order by corder desc";			
			$st				= $dbcon->execute($st);
			$st				= $dbcon->getResultArray($st);
			$snumber		= $st[0]['cc'];			
			
			
			$st				= "select count(*) as cc from ebay_messagelog where order_id='$oid' order by id desc";
			$st				= $dbcon->execute($st);
			$st				= $dbcon->getResultArray($st);
			$snumber2		= $st[0]['cc'];			
		
		
			
			
			if($snumber == $snumber2){				
				$sql	= "update ebay_order set mailstatus='2' where ebay_ordersn='$ordersn'";
			
				$dbcon->execute($sql);
			}			
		
		}
		
			
	}
	
	
	
	
	
	
	

}

	
 ?>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status;?> </h2>
</div>

<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
		
	<td nowrap="nowrap" scope="row" >&nbsp;
    <br>&&系统正在检查待处理订单列表
    <?php
		
		if($_REQUEST['ordersn']!= ''){
			
			$order		= $_REQUEST['ordersn'];
			$order		= explode(",",$order);
			$tj			= "";			
			for($i = 0;$i<count($order);$i++){			
				if($order[$i] != ""){			
					$tj	.= " ebay_id='".$order[$i]."' or ";					
				}				
			}			
			$tj			= substr($tj,0,strlen($tj)-3);
			$sql		= "select * from ebay_order as a where ebay_user='$user' and (ebay_status='10' or ebay_status='11' or ebay_status='12' or ebay_status='13')  and ebay_combine!='1' and postive='0' and (mailstatus='0' or mailstatus='') and ($tj)";	

	
		}else{
				
			$sql		= "select * from ebay_order as a where ebay_user='$user' and ebay_status='2'  and ebay_combine!='1' and postive='0' and (mailstatus='0' or mailstatus='' or mailstatus='1')  ";
			
		}
		

		
		$sql		= $dbcon->execute($sql);
		$sql		= $dbcon->getResultArray($sql);
		
	
		
		
		for($i=0;$i<count($sql);$i++){
			
			$ordersn	= $sql[$i]['ebay_ordersn'];
			$oid		= $sql[$i]['ebay_id'];
			echo "<br>-------------------------------------------------------------------";
			
			echo "<br>"." 订单号:".($i+1).$ordersn;
			echo "<br>检查当前订单信件发送状态：";
			$st		= "select * from ebay_messagelog where order_id='$oid'";
			$st		= $dbcon->execute($st);
			$st		= $dbcon->getResultArray($st);
			for($t=0;$t<count($st);$t++){
				
				$tordernumber			= $st[$t]['ordernumber'];
				$tmessagetemplate 		= $st[$t]['messagetemplate'];
				$ttime			 		= $st[$t]['time'];
				$tstatus		 		= $st[$t]['status'];
				
				echo "<br>".$tordernumber."&nbsp;&nbsp;".date('Y-m-d H:i:s',$ttime)."&nbsp;&nbsp;".$tstatus;
				
				 
			
			}
			 sendmessagetemplate($oid);
			echo "<br>-------------------------------------------------------------------";
			
			
		}
	?>
    </td>
</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
<div class="clear"></div>
<?php

include "bottom.php";


?>
<script language="javascript">


function cr()
{

	var url = 'clear.php';
	window.open(url,"_blank");
	

   
}
	


</script>