<?php
@session_start();
$title	= "---";
error_reporting(0);
include "dbconnect.php";
$dbcon	= new DBClass();
$user	= $_SESSION['user'];



if($user == ""){

echo "<script>location.href='login.php'</script>";
}



	if($user == 'Hng') {
		
		
		
		die('The time is expired ,Please conatct  	qq 287311025');
		
	}
	
	
			if($user == 'viphoeever') {
		
		
		
		die('The time is expired ,Please conatct  	qq 287311025,系统服务已过期');
		
	}
	
	
	
	if($user == 'viplinlin') {
		
		
		
		die('The time is expired ,Please conatct  	qq 287311025,系统服务已过期');
		
	}
	
	


	$redirectUrl	=	"xxx";
	$callback_url	=	"http://42.121.19.218/v3-sall/callback.php";
	$getTokenUrl1	=	"https://gw.api.alibaba.com/openapi/http/1/system.oauth2/getToken/".$appKey;
	$getTokenUrl2	=	"https://gw.api.alibaba.com/openapi/param2/1/system.oauth2/refreshToken/".$appKey;

//if($user == 'vipbin') die('请联系管理员QQ: 287311025');

include "eBaySession.php";
include "xmlhandle.php";
include "ebay_lib.php";
include "cls_page.php";
include "ebay_liblist.php";
date_default_timezone_set ("Asia/Chongqing");
$compatabilityLevel = 551;
$devID		= "cddef7a0-ded2-4135-bd11-62db8f6939ac";
$appID		= "Survyc487-9ec7-4317-b443-41e7b9c5bdd";
$certID		= "b68855dd-a8dc-4fd7-a22a-9a7fa109196f";




$mroot		= 'root';
$mpassword		= '123456';
$mdatabasenames		= 'v3-all';

$serverUrl	= "https://api.ebay.com/ws/api.dll";
$siteID = 0;  
$detailLevel = 0;
$nowtime	= date("Y-m-d H:i:s");
$nowd		= date("Y-m-d");
$Sordersn	= "eBay";
$pagesize=20;//每页显示的数据条目数
$mctime		= strtotime($nowtime);


$pagesize	= $_SESSION['pagesize'];
$truename	= $_SESSION['truename'];
/*   2012-04-19 根据登录名检索所在部门
	$getDept="select department from ebay_user where username='$truename'";
	$getDept=$dbcon->execute($getDept);
	$getDept=$dbcon->getResultArray($getDept);
	$deptName=$getDept[0]['department'];
	$sql		= "select * from ebay_user where username='$truename'";
	$sql		= $dbcon->execute($sql);
	$sql		= $dbcon->getResultArray($sql);
	$pagesize	= $sql[0]['record']?$sql[0]['record']:"20";end */
	
	
	


	/* 加载系统默认配置*/
	$ss		= "select * from ebay_config WHERE `ebay_user` ='$user' LIMIT 1";
	$ss		= $dbcon->execute($ss);
	$ss		= $dbcon->getResultArray($ss);
	$defaultstoreid				= $ss[0]['storeid'];
	$notesorderstatus			= $ss[0]['notesorderstatus'];
	$auditcompleteorderstatus	= $ss[0]['auditcompleteorderstatus'];
	$hackorerstatus				= $ss[0]['hackorer'];
	
	$overtock					= $ss[0]['overtock']; // 缺货订单分类
	$takeinventory				= $ss[0]['takeinventory']; // takeinventory
	
	$ckyuserid					= $ss[0]['ckyuserid'];
	$ckyuserkey					= $ss[0]['ckyuserkey'];
	$ckytoken					= $ss[0]['ckytoken'];
	
	
	$stapikey					 	= $ss[0]['stapikey'];
	$stapitoken					 	= $ss[0]['stapitoken'];	
	$stuserID					 	= $ss[0]['stuserID'];
	
	
	
	$wytuser						 	= $ss[0]['wytuser'];	
	$wytuserpass					 	= $ss[0]['wytuserpass'];
	
	
	$bluserame						 	= $ss[0]['bluserame'];	
	$blpassword						 	= $ss[0]['blpassword'];
	
	
	$ywuserid					= $ss[0]['ywuserid'];
	$ywpassword					= $ss[0]['ywpassword'];
	$days30						= $ss[0]['days30']?$ss[0]['days30']:0.5;
	$days15						= $ss[0]['days15']?$ss[0]['days15']:0.3;
	$days7						= $ss[0]['days7']?$ss[0]['days7']:0.2;
	$allowauditorderstatus						= $ss[0]['allowauditorderstatus']; // 加载允许扫描的订单状态
	
	
	$totalprofitstatus							= $ss[0]['totalprofitstatus'];
	$systemprofit								= $ss[0]['systemprofit'];
	$totalprofitstatus							= $ss[0]['totalprofitstatus'];
	$scaningorderstatus							= $ss[0]['scaningorderstatus'];
	
/* 帐号可见设置 */
	$ebayaccounts00		= $_SESSION['ebayaccounts'];
	$ebayaccounts00 	= explode(",",$ebayaccounts00);	
	$ebayacc		= '';	
	$ebayacc2		= '';
	
	for($i=0;$i<count($ebayaccounts00);$i++){		
		$ebayacc	.= "a.ebay_account='".$ebayaccounts00[$i]."' or ";	
		$ebayacc2	.= "account='".$ebayaccounts00[$i]."' or ";	
		
	}
	$ebayacc     = substr($ebayacc,0,strlen($ebayacc)-3);
	$ebayacc2    = substr($ebayacc2,0,strlen($ebayacc2)-3);
	/* 帐号可见设置 */
	$message00		= $_SESSION['messages'];
	$message00	 	= explode(",",$message00);	
	$ebaymes		= '';	
	for($i=0;$i<count($message00);$i++){		
		$ebaymes	.= "ebay_account='".$message00[$i]."' or ";	
	}
	$ebaymes     = substr($ebaymes,0,strlen($ebaymes)-3);
	
	
	/* 占用订单分类指定状态处理 */
	$takeinventorystr	 	= explode(",",$takeinventory);	
	$takeinventorysearch	= '';	
	for($i=0;$i<count($takeinventorystr);$i++){		
		if ( $takeinventorystr[$i] != '' ) $takeinventorysearch	.= "ebay_status='".$takeinventorystr[$i]."' or ";	
	}
	$takeinventorysearch     = substr($takeinventorysearch,0,strlen($takeinventorysearch)-3);
	?>