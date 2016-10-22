<?php


include 'include/config.php';
error_reporting(E_ALL);

$code	=	$_REQUEST['code'];
if(!empty($code)){
	$json	=	getToken2($appKey, $appSecret, $redirectUrl, $code, $getTokenUrl1);
	
	$refresh_token  = $json['refresh_token'];
	
	if(isset($json['refresh_token'])){
		$json	=	refreshToken($appKey, $appSecret, $json['refresh_token'], $getTokenUrl2);
		$ebay_account 	= $json['resource_owner'];
		$access_token  	= $json['access_token'];
		
		$vvsql			= "select * from ebay_account where ebay_account = '$ebay_account' and ebay_user ='$user' ";
		$vvsql			= $dbcon->execute($vvsql);
		$vvsql			= $dbcon->getResultArray($vvsql);
		if(count($vvsql) == 0 ){
			$updatesql		= "insert into ebay_account (ebay_account,ebay_user,refresh_token,access_token) values('$ebay_account','$user','$refresh_token','$access_token') ";
		}else{
			$updatesql		= "update ebay_account set refresh_token='$refresh_token',access_token='$access_token' where ebay_account = '$ebay_account' and ebay_user ='$user' ";
		}
		
		if($dbcon->execute($updatesql)){
			
			
			$status = '<font color="#009900">帐号帮定成功</font>';	
			
		}else{
			
			$status = '<font color=" color="#FF0000"">帐号帮定失败,请联系: 287311025 QQ</font>';	
		}
		
		
		echo $status;
		

	}else{
		echo "cann't get the refresh_token\n";
	}
}else{
	echo getCode($appKey, $appSecret, $callback_url);
}

function Curl($url,$vars=''){
	$ch=curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_POST,1);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 
	curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($vars));
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
	$content=curl_exec($ch);
	curl_close($ch);
	return $content;
}

/***********************************************************
 *	获取临时token
 */
function getToken2($appKey, $appSecret, $redirectUrl, $code, $getTokenUrl){
	
	$data =array(
		'grant_type'		=>'authorization_code',	
		'need_refresh_token'=>'true',				
		'client_id'			=>$appKey,				
		'client_secret'		=>$appSecret,			
		'redirect_uri'		=>$redirectUrl,			
		'code'				=>$code,
	);
	
	
	
	//过期时间， 一小时
	return	json_decode(Curl($getTokenUrl,$data),true);
}


/************************************************************
 *	获取长效token
 */
function refreshToken($appKey, $appSecret, $refresh_token, $getTokenUrl){
	$data =array(
		'grant_type'		=>'refresh_token',			
		'client_id'			=>$appKey,			
		'client_secret'		=>$appSecret,			
		'refresh_token'		=>$refresh_token,		
	);
	$data['_aop_signature']	=	Sign($data,$appSecret); 
	return json_decode(Curl($getTokenUrl,$data),true);
}


function Sign($vars, $appSecret){
	$str='';
	ksort($vars);
	foreach($vars as $k=>$v){
		$str.=$k.$v;
	}
	return strtoupper(bin2hex(hash_hmac('sha1',$str,$appSecret,true)));
}


function getCode($appKey,$appSecret, $callback_url){
	$getCodeUrl		=	"https://gw.api.alibaba.com/auth/authorize.htm?client_id=".$appKey ."&site=aliexpress&redirect_uri=".$callback_url."&_aop_signature=".Sign(array('client_id' => $appKey,'redirect_uri' =>$callback_url,'site' => 'aliexpress'),$appSecret);
		
	return "<a href='".$getCodeUrl."'>Login</a>";
}
?>