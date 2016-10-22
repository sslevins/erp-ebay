<?php
class Aliexpress{

	var $server			=	'https://gw.api.alibaba.com';
	var $rootpath		=	'openapi';					//openapi,fileapi
	var $protocol		=	'param2';					//param2,json2,jsonp2,xml2,http,param,json,jsonp,xml
	var $ns				=	'aliexpress.open';
	var $version		=	1;
	var $appKey			=	'3333';					//填自己的
	var $appSecret		=	'5534234234';				//填自己的
	var $refresh_token	=	"962489-a34568-4333858-456-7d53d6678349b";//填自己的
	var $callback_url	=	"http://www.xxx.com/aliexpress/callback.php";

	//var $access_token = 'd43bc953-7b74-4bc4-9ec6-7176bf5288a5';
	var $access_token ;

	function __construct() {
	}

	function setConfig($appKey,$appSecret,$refresh_token,$access_token){
		$this->appKey		=	$appKey;
		$this->appSecret	=	$appSecret;
		$this->refresh_token=	$refresh_token;
		$this->access_token=	$access_token;
	}	

	function doInit(){
		$token	=	$this->getToken();
		$this->access_token	=	$token->access_token;
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
	
	//生成签名
	function Sign($vars){
		$str='';
		ksort($vars);
		foreach($vars as $k=>$v){
			$str.=$k.$v;
		}
		return strtoupper(bin2hex(hash_hmac('sha1',$str,$this->appSecret,true)));
	}
	
    //生成签名
	function getCode(){
		$getCodeUrl = $this->server .'/auth/authorize.htm?client_id='.$this->appKey .'&site=aliexpress&redirect_uri='.$this->callback_url.'&_aop_signature='.$this->Sign(array('client_id' => $this->appKey,'redirect_uri' =>$this->callback_url,'site' => 'aliexpress'));
		return '<a href="javascript:void(0)" onclick="window.open(\''.$getCodeUrl.'\',\'child\',\'width=500,height=380\');">请先登陆并授权</a>';
	}
	
	//获取授权
	function getToken(){
		if(!empty($this->refresh_token)){
			$getTokenUrl="{$this->server}/{$this->rootpath}/{$this->protocol}/{$this->version}/system.oauth2/refreshToken/{$this->appKey}";
			$data =array(
				'grant_type'		=>'refresh_token',		//授权类型
				'client_id'			=>$this->appKey,				//app唯一标示
				'client_secret'		=>$this->appSecret,			//app密钥
				'refresh_token'		=>$this->refresh_token,		//app入口地址
			);
			$data['_aop_signature']=$this->Sign($data); 
			return json_decode($this->Curl($getTokenUrl,$data));
			
		}else{
			$getTokenUrl="{$this->server}/{$this->rootpath}/{$this->protocol}/{$this->version}/system.oauth2/getToken/{$this->appKey}";
			$data =array(
				'grant_type'		=>'authorization_code',	//授权类型
				'need_refresh_token'=>'true',				//是否需要返回长效token
				'client_id'			=>$this->appKey,				//app唯一标示
				'client_secret'		=>$this->appSecret,			//app密钥
				'redirect_uri'		=>$this->redirectUrl,			//app入口地址
				'code'				=>$_SESSION['code'],	//bug
			);
			return json_decode($this->Curl($getTokenUrl,$data));
		}
	}
	
	/**********************获取订单信息**********************/
	function findOrderListQuery(){
		$data	=	array(
			'access_token'	=>$this->access_token,
			'page'			=>'1',
			'pageSize'		=>'50',
			//'createDateStart'	=>	'04/14/2013',
			//'createDateEnd'	=>	'04/17/2013',
			'orderStatus'	=>'WAIT_SELLER_SEND_GOODS'
			//'orderStatus'	=>'WAIT_BUYER_ACCEPT_GOODS'
		);




		
		$url		=	"{$this->server}/{$this->rootpath}/{$this->protocol}/{$this->version}/{$this->ns}/api.findOrderListQuery/{$this->appKey}";




		$List		=	json_decode($this->Curl($url,$data),true);




		$orderList	=	array();
		if(!empty($List["orderList"])){
			foreach($List["orderList"] as $k=>$v){
				$orderId	=	$v["orderId"];
				$orderList[$orderId]['detail']	=	$this->findOrderById($orderId);
				$orderList[$orderId]['v']		=	$v;
			}
			
			for($i=2;$i<=ceil($List["totalItem"]/$data['pageSize']);$i++){
				$data['page']=$i;
				$List=json_decode($this->Curl($url,$data),true);
				foreach($List["orderList"] as $k=>$v){
					$orderId	=	$v["orderId"];
					$orderList[$orderId]['detail']	=	$this->findOrderById($orderId);
					$orderList[$orderId]['v']		=	$v;
				}
			}
			
		}
		unset($List);
		return $orderList;
		
	}
	
	function findOrderById($orderId){
		$data=array(
			'access_token'	=>$this->access_token,
			'orderId'			=>$orderId,
		);
		$url="{$this->server}/{$this->rootpath}/{$this->protocol}/{$this->version}/{$this->ns}/api.findOrderById/{$this->appKey}";
		return json_decode($this->Curl($url,$data),true);
	}
	/**********************获取商品信息**********************/
	function findProductInfoListQuery(){
		$data=array(
			'access_token'	=>$this->access_token,
			'page'			=>'1',
			'pageSize'		=>'100',
			'productStatusType'	=>'onSelling',
		);
		$url="{$this->server}/{$this->rootpath}/{$this->protocol}/{$this->version}/{$this->ns}/api.findProductInfoListQuery/{$this->appKey}";
		$List=json_decode($this->Curl($url,$data));
		$ProductList='';
		if(!empty($List->aeopAEProductDisplayDTOList)){
			foreach($List->aeopAEProductDisplayDTOList as $k=>$v){
				$ProductList[]=$this->findAeProductById($v->productId);
			}
			
			for($i=2;$i<=$List->totalPage;$i++){
				$data['page']=$i;
				$List=json_decode($this->Curl($url,$data));
				foreach($List->aeopAEProductDisplayDTOList as $k=>$v){
					$ProductList[]=$this->findAeProductById($v->productId);
				}
			}
			
		}
		return $ProductList;
	}
	
	
	function findAeProductById($productId){
		$data=array(
			'access_token'	=>$this->access_token,
			'productId'		=>$productId,
		);
		$url="{$this->server}/{$this->rootpath}/{$this->protocol}/{$this->version}/{$this->ns}/api.findAeProductById/{$this->appKey}";
		return json_decode($this->Curl($url,$data));
	}

	
	/********************************************************
	 *	对对应订单标记发放， 支持全部发货， 部分发货
	 *	
	 */
	function sellerShipment($serviceName, $logisticsNo, $sendType, $outRef, $description=""){
		$data	=	array(
			'serviceName'	=>	$serviceName,
			'logisticsNo'	=>	$logisticsNo,
			'sendType'		=>	$sendType,
			'outRef'	=>	$outRef,
			'access_token'	=>	$this->access_token
		);
		
		if(!empty($description)){
			$data['description']	=	$description;
		}
		
		$url	=	"{$this->server}/{$this->rootpath}/{$this->protocol}/{$this->version}/{$this->ns}/api.sellerShipment/{$this->appKey}";
		return json_decode($this->Curl($url,$data));	
	}
}
?>
