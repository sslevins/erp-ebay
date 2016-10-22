<?php 
include "include/config.php";
include "include/Aliexpress.class.php";
error_reporting(E_ALL);


	$order		= $_REQUEST['ordersn'];
	$order		= explode(",",$order);
	$type		= $_REQUEST['type'];
	
	
	
	$firstaccount = '';
	
	
	for($i=0;$i<count($order);$i++){
	
		
		if($order[$i] != ""){
		
			$sn			= $order[$i];
			$sq			= "select ebay_combine,ebay_id,ebay_tracknumber,ebay_carrier,ebay_account,ebay_ordersn,ebay_markettime , recordnumber from ebay_order where ebay_id='$sn'";
			$sqa		= $dbcon->execute($sq);
			$sq			= $dbcon->getResultArray($sqa);
			$dbcon->free_result($sqa);
			
			
			$corder		 = $sq[0]['ebay_combine'];			
			$corder		 = explode('#',$corder);
			
			$ebay_id					= $sq[0]['ebay_id'];		
			$logisticsNo				= $sq[0]['ebay_tracknumber'];
			$recordnumber				= $sq[0]['recordnumber'];		
			$ebay_carrier				= mysql_escape_string($sq[0]['ebay_carrier']);
			
			$ss							= "select value3,note from ebay_carrier where name='$ebay_carrier' and ebay_user='$user'";
			

			$ss							= $dbcon->execute($ss);
			$ss							= $dbcon->getResultArray($ss);
			
			
	
		
			
			$serviceName				= $ss[0]['value3'];
			
			
			
			if($serviceName == '' ) $serviceName ='other';
			
			$weisite					= $ss[0]['note'];
			
			


			$account					= $sq[0]['ebay_account'];
			$osn						= $sq[0]['ebay_ordersn'];		
			$ebay_markettime			= $sq[0]['ebay_markettime'];	
			$ebay_markettime	= '';
			


			
			$sql 		 = "select * from ebay_account where ebay_user='$user' and ebay_account='$account'";
			$sqla		 = $dbcon->execute($sql);
			$sql		 = $dbcon->getResultArray($sqla);
			$dbcon->free_result($sqla);
			
			
				$refresh_token		= $sql[0]['refresh_token'];
				$access_token		= $sql[0]['access_token'];
				$id					= $sql[0]['id'];
				
				
					$vv		= "select * from ebay_account where id='$id'  and appKey != '' ";
					$vv 	= $dbcon->execute($vv);
					$vv 	= $dbcon->getResultArray($vv);
					
					
					if(count($vv)>0){
					
					$appKey   		= $vv[0]['appkey'];
					$appSecret  	= $vv[0]['secret'];
					$getTokenUrl1	=	"https://gw.api.alibaba.com/openapi/http/1/system.oauth2/getToken/".$appKey;
					$getTokenUrl2	=	"https://gw.api.alibaba.com/openapi/param2/1/system.oauth2/refreshToken/".$appKey;
					
					
					
					}
					
				

			/* 取得新的token /
			if($account != $firstaccount){
				$json	=	refreshToken($appKey, $appSecret, $refresh_token, $getTokenUrl2);
				$access_token		= $json['access_token'];
			}
			*/
			
			$aliexpress = new Aliexpress();
			$aliexpress->setConfig($appKey,$appSecret,$refresh_token,$access_token);
			$dataarray	= $aliexpress->sellerShipment($serviceName, $logisticsNo, 'all', $recordnumber, $description="",$weisite);
			$error_message	=  $dataarray->error_message;
			
			
			if($error_message != ''){
				echo $ebay_id.' 订单标记发出失败,'.$error_message;
			}else{
				echo $ebay_id.' 订单标记发出成功,'.$error_message;
				
				
				$sb		= "update ebay_order set  ebay_markettime='$mctime',ShippedTime='$mctime' where ebay_id='$ebay_id'";
				$dbcon->execute($sb);
				
			}
			
			
			/* 检查一下是否有合并订单 */
			
			
				for($p=0;$p<count($corder);$p++){
			
		
				if($corder[$p] != "" && $corder[$p] != "0"){
				
					$sn			= $corder[$p];
		
					$sq			= "select ebay_account,ebay_ordersn ,recordnumber from ebay_order where ebay_id='$sn'";
					$sq			= $dbcon->execute($sq);
					$sq			= $dbcon->getResultArray($sq);
					$account	= $sq[0]['ebay_account'];		
					$osn		= $sq[0]['ebay_ordersn'];
					$recordnumber		= $sq[0]['recordnumber'];
					
					
					
					$sql 		 = "select * from ebay_account where ebay_user='$user' and ebay_account='$account'";
					$sqla		 = $dbcon->execute($sql);
					$sql		 = $dbcon->getResultArray($sqla);
					$dbcon->free_result($sqla);
					
					
					
					$id					= $sql[0]['id'];
				
				
					$vv		= "select * from ebay_account where id='$id'  and appKey != '' ";
					$vv 	= $dbcon->execute($vv);
					$vv 	= $dbcon->getResultArray($vv);
					
					
					if(count($vv)>0){
					
					$appKey   		= $vv[0]['appkey'];
					$appSecret  	= $vv[0]['secret'];
					
					
				
		
					
					
					}
					
					
					
					
					
						$refresh_token		= $sql[0]['refresh_token'];
						$access_token		= $sql[0]['access_token'];
						
		
						
						
					
					$aliexpress = new Aliexpress();
					$aliexpress->setConfig($appKey,$appSecret,$refresh_token,$access_token);
					$dataarray	= $aliexpress->sellerShipment($serviceName, $logisticsNo, 'all', $recordnumber, $description="",$weisite);
					$error_message	=  $dataarray->error_message;
					
					
					if($error_message != ''){
						echo $ebay_id.' 订单标记发出失败,'.$error_message;
					}else{
						echo $ebay_id.' 订单标记发出成功,'.$error_message;
						
						
						$sb		= "update ebay_order set  ebay_markettime='$mctime',ShippedTime='$mctime' where ebay_id='$ebay_id'";
						$dbcon->execute($sb);
						
					}
			
			
			
	
				
					
				
				}
			
			}
			
			
			
			echo '<br>';
			

			
		}
	
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
