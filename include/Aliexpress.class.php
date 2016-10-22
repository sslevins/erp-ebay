<?php
class Aliexpress{

	var $server			=	'https://gw.api.alibaba.com';
	var $rootpath		=	'openapi';					//openapi,fileapi
	var $protocol		=	'param2';					//param2,json2,jsonp2,xml2,http,param,json,jsonp,xml
	var $ns				=	'aliexpress.open';
	var $version		=	1;
	var $appKey			=	'3333';					//���Լ���
	var $appSecret		=	'5534234234';				//���Լ���
	var $refresh_token	=	"962489-a34568-4333858-456-7d53d6678349b";//���Լ���
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
	
	//����ǩ��
	function Sign($vars){
		$str='';
		ksort($vars);
		foreach($vars as $k=>$v){
			$str.=$k.$v;
		}
		return strtoupper(bin2hex(hash_hmac('sha1',$str,$this->appSecret,true)));
	}
	
    //����ǩ��
	function getCode(){
		$getCodeUrl = $this->server .'/auth/authorize.htm?client_id='.$this->appKey .'&site=aliexpress&redirect_uri='.$this->callback_url.'&_aop_signature='.$this->Sign(array('client_id' => $this->appKey,'redirect_uri' =>$this->callback_url,'site' => 'aliexpress'));
		return '<a href="javascript:void(0)" onclick="window.open(\''.$getCodeUrl.'\',\'child\',\'width=500,height=380\');">���ȵ�½����Ȩ</a>';
	}
	
	//��ȡ��Ȩ
	function getToken(){
		if(!empty($this->refresh_token)){
			$getTokenUrl="{$this->server}/{$this->rootpath}/{$this->protocol}/{$this->version}/system.oauth2/refreshToken/{$this->appKey}";
			$data =array(
				'grant_type'		=>'refresh_token',		//��Ȩ����
				'client_id'			=>$this->appKey,				//appΨһ��ʾ
				'client_secret'		=>$this->appSecret,			//app��Կ
				'refresh_token'		=>$this->refresh_token,		//app��ڵ�ַ
			);
			$data['_aop_signature']=$this->Sign($data); 
			return json_decode($this->Curl($getTokenUrl,$data));
			
		}else{
			$getTokenUrl="{$this->server}/{$this->rootpath}/{$this->protocol}/{$this->version}/system.oauth2/getToken/{$this->appKey}";
			$data =array(
				'grant_type'		=>'authorization_code',	//��Ȩ����
				'need_refresh_token'=>'true',				//�Ƿ���Ҫ���س�Чtoken
				'client_id'			=>$this->appKey,				//appΨһ��ʾ
				'client_secret'		=>$this->appSecret,			//app��Կ
				'redirect_uri'		=>$this->redirectUrl,			//app��ڵ�ַ
				'code'				=>$_SESSION['code'],	//bug
			);
			return json_decode($this->Curl($getTokenUrl,$data));
		}
	}



	function genSign($info, $api_path = '') {
		// 生成签名
		ksort($info);
		foreach ($info as $key => $val) {
			if ($key == 'app_secret') {
				continue;
			}
			$sign .= $key.$val;
		}
		$sign = strtoupper(bin2hex(hash_hmac('sha1', $api_path.$sign, $info['app_secret'], true)));
		return $sign;
	}
	
	/**********************��ȡ������Ϣ**********************/
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



		$api_path = "param2/1/aliexpress.open/api.findOrderListQuery/$this->appKey";
		$vv = $this->genSign($data + array(
			'app_secret' => $this->appSecret ), $api_path);



		$data	=	array(
			'access_token'	=>$this->access_token,
			'page'			=>'1',
			'pageSize'		=>'50',
			//'createDateStart'	=>	'04/14/2013',
			//'createDateEnd'	=>	'04/17/2013',
			'_aop_signature'	=> $vv,
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
				
				
				$data	=	array(
				'access_token'	=>$this->access_token,
				'page'			=>$i,
				'pageSize'		=>'50',
			
				'orderStatus'	=>'WAIT_SELLER_SEND_GOODS'
			
			);



			


				
				$vv = $this->genSign($data + array(
				'app_secret' => $this->appSecret ), $api_path);

				$data['_aop_signature'] = $vv;






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




		$api_path = "param2/1/aliexpress.open/api.findOrderById/$this->appKey";





		

		$vv = $this->genSign($data + array(
			'app_secret' => $this->appSecret ), $api_path);


		$data=array(
			'access_token'		=>$this->access_token,
			'orderId'			=>$orderId,
			'_aop_signature'	=>$vv,
		);






		$url="{$this->server}/{$this->rootpath}/{$this->protocol}/{$this->version}/{$this->ns}/api.findOrderById/{$this->appKey}";
		return json_decode($this->Curl($url,$data),true);
	}
	/**********************��ȡ��Ʒ��Ϣ**********************/
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
	 *	�Զ�Ӧ������Ƿ��ţ� ֧��ȫ�������� ���ַ���
	 *	
	 */
	function sellerShipment($serviceName, $logisticsNo, $sendType, $outRef, $description="",$weisite){
		$data	=	array(
			'serviceName'	=>	$serviceName,
			'logisticsNo'	=>	$logisticsNo,
			'sendType'		=>	$sendType,
			'outRef'	=>	$outRef,
			'access_token'	=>	$this->access_token,
		);
		
		if(!empty($description)){
			$data['description']	=	$description;
		}
		if(!empty($weisite)){
			$data['trackingWebsite']	=	$weisite;
		}

		$api_path = "param2/1/aliexpress.open/api.sellerShipment/$this->appKey";
		
		
		

		$vv = $this->genSign($data + array(
			'app_secret' => $this->appSecret ), $api_path);


		$data	=	array(
			'serviceName'	=>	$serviceName,
			'logisticsNo'	=>	$logisticsNo,
			'sendType'		=>	$sendType,
			'outRef'	=>	$outRef,
			'access_token'	=>	$this->access_token,
			'_aop_signature'	=>	$vv
		);
		
		
			if(!empty($description)){
			$data['description']	=	$description;
		}
		if(!empty($weisite)){
			$data['trackingWebsite']	=	$weisite;
		}





print_r($data);



		
		$url	=	"{$this->server}/{$this->rootpath}/{$this->protocol}/{$this->version}/{$this->ns}/api.sellerShipment/{$this->appKey}";
		return json_decode($this->Curl($url,$data));	
	}


	/********************************************************
	 *	对就订单进行线上发货操作
	 *	
	 */
	 
	 
	 function Smttracknmber($ebay_id){
		 
		 global $dbcon;
		 
		 
		 
			$sq			= "select * from ebay_order where ebay_ordersn='$ebay_id'";
			$sqa		= $dbcon->execute($sq);
			$sq			= $dbcon->getResultArray($sqa);
			
			$orderid		= $sq[0]['ebay_id'];
			$ebay_city		= $sq[0]['ebay_city'];
			$ebay_couny		= $sq[0]['ebay_couny'];
			$ebay_username		= $sq[0]['ebay_username'];
			$recordnumber				= $sq[0]['recordnumber'];		
			$ebay_postcode				= $sq[0]['ebay_postcode'];
		 	$ebay_state				= $sq[0]['ebay_state'];
		    $ebay_street				= $sq[0]['ebay_street'].' '.$sq[0]['ebay_street1'];
		    $ebay_phone				= $sq[0]['ebay_phone'];
			
		 
		 $reciver		= array(
		'city'			=> $ebay_city,
		'country'		=> $ebay_couny,
		'mobile'		=> $ebay_phone,
		'name'		=> $ebay_username,
		'phone'		=> $ebay_phone,
		'postcode'		=> $ebay_postcode,
		'province'		=> $ebay_state,
		'streetAddress'		=> $ebay_street
		
		);
	
	
		$sender		= array(
		
		'city'			=> 'Hangzhou',
		'country'		=> 'CN',
		'county'		=> 'Binjiang',
		'name'		=> 'lisi',
		'phone'		=> '0571358421474',
		'postcode'		=> '310052',
		'province'		=> 'Zhejiang',
		'streetAddress'		=> 'dong da jie No.123'
		);
		
			$pickup		= array(
		
		'city'			=> '杭州市',
		'county'		=> '滨江区',
		'country'		=> 'CN',
		'phone'		=> '0571358421474',
		'name'		=> '阿里测试',
		'postcode'		=> '310052',
'province'		=> '浙江省',
'province'		=> '网商路699号'
		);
		
	
	
	
	$data =array(
		'grant_type'		=>'authorization_code',	
		'need_refresh_token'=>'true',				
		'client_id'			=>$appKey,				
		'client_secret'		=>$appSecret,			
		'redirect_uri'		=>$redirectUrl,			
		'code'				=>$code
	);
	
	
	$prpductdetail	=array(
		
		'categoryCnDesc'	=> '小米手机',
		'categoryEnDesc'	=> 'Clothes',
		'isContainsBattery'	=> 1,
		'productDeclareAmount'	=> 1,
		'productNum'	=> 1,
		'productWeight'	=> 1,
		'productId'	=> 0
		
	);
	
	
		 
		 
		 $data	=	array(
		    'access_token'	=>	$this->access_token,
			'tradeOrderId'	=>	$recordnumber,
			'tradeOrderFrom'	=>	'ESCROW',
			'domesticLogisticsCompanyId'	=>	'-1',
			'domesticLogisticsCompany'	=>	'OTHER',
			'domesticTrackingNo	'	=>	'NONE',
			'addressDTOs' => array('receiver' => $reciver, 'sender' =>$sender,'pickup' => $pickup),
			'warehouseCarrierService'	=> 'YANWENJYT_WLB_CPAMSZ',
			'declareProductDTOs' =>$prpductdetail
			
		);
		 


		
		
 
		 $url0	=	"{$this->server}/{$this->rootpath}/{$this->protocol}/{$this->version}/{$this->ns}/api.createWarehouseOrder/{$this->appKey}?";
		 
		 $url = '';
		 
		
		
		$addrss		= '{"receiver":{"city":"'.$ebay_city.'","country":"'.$ebay_couny.'","fax":"'.$ebay_phone.'","mobile":"'.$ebay_phone.'","name":"'.$ebay_username.'","phone":"'.$ebay_phone.'","postcode":"'.$ebay_postcode.'","province":"'.$ebay_state.'","streetAddress":"'.$ebay_street.' "},"sender":{"city":"Hangzhou","country":"CN","county":"Binjiang","name":"lisi","phone":"123123123","postcode":"310052","province":"Zhejiang","streetAddress":"dong da jie No.123"},"pickup":{"city":"杭州市","county":"滨江区","country":"CN","phone":"0571358421474","name":"LIUZHEN","postcode":"310052","province":"浙江省","streetAddress":"网商路699号"}}	&remark=erer';

		$url	.= "tradeOrderId=".$recordnumber."&tradeOrderFrom=ESCROW&domesticLogisticsCompanyId=-1&domesticLogisticsCompany=OTHER&domesticTrackingNo=NONE&addressDTOs=".urlencode($addrss);
		
		
		
		$productdetail  = '[{"categoryCnDesc":"配件","categoryEnDesc":"Electronics","isContainsBattery":1,"productDeclareAmount":1,"productNum":1,"productWeight":1,productId:0}]';
		
		$url	.= "&declareProductDTOs=".urlencode($productdetail).'&warehouseCarrierService=YANWENJYT_WLB_CPAMSZ';
		
		
		
		$url2   = "&access_token=".$this->access_token;
		
		
		
		
		
		$url	= $url0.$url.$url2;
		
	
		 
		$result			=  json_decode($this->Curl($url));	
		
		$success		= $result->success;
		
		
		
		if($success  == '1'){
			echo '<br>订单号:'.$orderid.' 线上发货提交成功';
			
			
		}else{
			
			
			echo '<br><font color="red">订单号:'.$orderid.' 线上发货提交失败</font>';
			
	
			
			 print_r($result).'ccc';
		 
		 
		}
		
		
	
		 
		 
		 
	 }
	 
	 
	 
	 
	 
	  function Smtsystracknumber($ebay_id){
		 
		 global $dbcon;
		 
		 
		 
			$sq			= "select * from ebay_order where ebay_ordersn='$ebay_id'";
			$sqa		= $dbcon->execute($sq);
			$sq			= $dbcon->getResultArray($sqa);
			
			$orderid		= $sq[0]['ebay_id'];
			$ebay_city		= $sq[0]['ebay_city'];
			$ebay_couny		= $sq[0]['ebay_couny'];
			$ebay_username		= $sq[0]['ebay_username'];
			$recordnumber				= $sq[0]['recordnumber'];		
			$ebay_postcode				= $sq[0]['ebay_postcode'];
		 	$ebay_state				= $sq[0]['ebay_state'];
		    $ebay_street				= $sq[0]['ebay_street'].' '.$sq[0]['ebay_street1'];
		    $ebay_phone				= $sq[0]['ebay_phone'];
			
			
			
			 $url0	=	"{$this->server}/{$this->rootpath}/{$this->protocol}/{$this->version}/{$this->ns}/api.getOnlineLogisticsInfo/{$this->appKey}?";
			 $url = '';
			$url	.= "orderId=".$recordnumber;
			$url2   = "&access_token=".$this->access_token;
		
		
		
		
		
		$url	= $url0.$url.$url2;
		
	
		 
		$result			=  json_decode($this->Curl($url));	
		
		$success		= $result->success;
		
	//	print_r($result);
		
		if($success == '1'){
			
			
			
			$tracknumber		= $result->result[0]->internationallogisticsId;
			if($tracknumber == '' ){
					$tracknumber		= $result->result->internationallogisticsId;
			}
			
			
			$upsql			= "update ebay_order set ebay_tracknumber ='$tracknumber' where ebay_id ='$orderid'  ";
			
			if($dbcon->execute($upsql)){
				echo '订单编号: '.$orderid.' 执行同步成功,跟踪号为:'.$tracknumber.'<br>';
			}
		}else{
			
			
			
			
			
			echo '<font color="#FF0000">订单编号: '.$orderid.' 执行同步失败</font><br>';
			
				
		}
		
		
		
		
		 
		 
	 }
}
?>
