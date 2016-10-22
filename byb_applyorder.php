<?PHP

	include "include/config.php";

	error_reporting(0);
	
	
	$type =		$_REQUEST['type'];
	
$apitoken	= '';

			
		
$apitoken	= '052838f370bfc55ec7b2335ec2ceff3b778';
$mark		= '';

			

			


			$label	= '';
			$orders		= explode(",",$_REQUEST['bill']);
			
			$tkary		= array();
			$i = 0;



	for($g=0;$g<count($orders);$g++){
		$sn 	=  $orders[$g];
		if($sn != ""){

			$sql	= "select * from ebay_order as a where ebay_id='$sn'  ";			
			$sql	= $dbcon->execute($sql);
			$sql	= $dbcon->getResultArray($sql);
			
			
			$ebay_ordersn				= $sql[0]['ebay_ordersn'];
			$ebay_carrier				= $sql[0]['ebay_carrier'];
			$ebay_tracknumber			= $sql[0]['ebay_tracknumber'];
			$ebay_username				= $sql[0]['ebay_username'];
			$ToAddress1					= $sql[0]['ebay_street'];
			$ToAddress2					= ' '.$sql[0]['ebay_street1'];
			$ebay_state					= $sql[0]['ebay_state']?$sql[0]['ebay_state']:',';
			$ebay_postcode				= $sql[0]['ebay_postcode']?$sql[0]['ebay_postcode']:'00000';
			$ebay_phone					= $sql[0]['ebay_phone']?$sql[0]['ebay_phone']:'626883690';
			$ebay_city					= $sql[0]['ebay_city'];
			$ebay_usermail				= $sql[0]['ebay_usermail'];
			$ebay_countryname			= $sql[0]['ebay_countryname'];
			$ebay_id2					= $sql[0]['ebay_id'];
			$ebay_account				= $sql[0]['ebay_account'];
			$ebay_couny					= $sql[0]['ebay_couny'];
			
			
			
			$vv	= "select * from ebay_countrys as a where countrysn='$ebay_couny' and ebay_user ='$user' ";			
	
			$vv	= $dbcon->execute($vv);
			$vv	= $dbcon->getResultArray($vv);
		
			
		
			
			
			if(count($vv) >0  ){
				
				$ebay_countryname		= $vv[0]['countryen'];	
			}



			if($ebay_countryname == 'Russian Federation') $ebay_countryname = 'Russia';
			if($sql[0]['ebay_countryname']  == 'France') $ebay_countryname = 'France';
	
			$vv	= "select * from ebay_account where ebay_account='$ebay_account' and ebay_user ='$user' ";			
			$vv	= $dbcon->execute($vv);
			$vv	= $dbcon->getResultArray($vv);
			$appname			= $vv[0]['appname'];
			
			$vv	= "select * from ebay_carrier as a where name='$ebay_carrier' and ebay_user ='$user' ";			
			$vv	= $dbcon->execute($vv);
			$vv	= $dbcon->getResultArray($vv);
			
			

		
			$fromusername	= $vv[0]['username'];
			$province		= $vv[0]['province'];
			$fromcity		= $vv[0]['city'];
			$fromstreet		= $vv[0]['street'];


			
		
			
	
			 $xmlRequest		='<?xml version="1.0" encoding="UTF-8"?><orders><api_key>'.$apitoken.'</api_key><mark>'.$mark.'</mark><bid>'.$g.'</bid><order>';
$xmlRequest		.='<trade_amount>1</trade_amount>';

$xmlRequest		.='<trande_no>sdfsf</trande_no>';
			 $xmlRequest		.='<from_country>China</from_country>';
			 $xmlRequest		.='<guid>'.$ebay_id2.'</guid>';
			 $xmlRequest		.='<otype>'.$type.'</otype>';
			 $xmlRequest		.='<from>'.$fromusername.'</from>';
			 $xmlRequest		.='<sender_addres>'.$fromstreet.'</sender_addres>';
			 $xmlRequest		.='<sender_province>'.$province.'ddd</sender_province>';
			 $xmlRequest		.='<sender_city>'.$fromcity.'</sender_city>';
			 $xmlRequest		.='<sender_phone>'.$ebay_phone.'</sender_phone>';
			 $xmlRequest		.='<to>'.$ebay_username.'</to>';
			  $xmlRequest		.='<to_local>'.$ebay_username.'</to_local>';
			  $xmlRequest		.='<recipient_addres>'.$ToAddress1.','.$ToAddress2.'</recipient_addres>';
			  $xmlRequest		.='<recipient_addres_local>'.$ToAddress1.','.$ToAddress2.'</recipient_addres_local>';
			 $xmlRequest		.='<recipient_country>'.$ebay_countryname.'</recipient_country>';
			 
			 $xmlRequest		.='<recipient_country_local>'.$ebay_countryname.'</recipient_country_local>';
			 $xmlRequest		.='<recipient_province>'.$ebay_state.'</recipient_province>';
			 
			  $xmlRequest		.='<recipient_province_local>'.$ebay_state.'</recipient_province_local>';
			 $xmlRequest		.='<recipient_city_local>'.$ebay_city.'</recipient_city_local>';
			 $xmlRequest		.='<recipient_city>'.$ebay_city.'</recipient_city>';
			  $xmlRequest		.='<recipient_postcode>'.$ebay_postcode.'</recipient_postcode>';

			$xmlRequest		.='<recipient_phone>'.$ebay_phone.'</recipient_phone>';





		





			
			
			
			
		
				 $ee			= "select ebay_amount,sku,recordnumber,ebay_itemtitle,ebay_itemprice from ebay_orderdetail as a where a.ebay_ordersn='$ebay_ordersn'";
				 $ee			= $dbcon->execute($ee);
				 $ee			= $dbcon->getResultArray($ee);
				 
				 
				 
				 
	
				
			
			$skuline	= '';


				 foreach($ee as $key=>$val){
					 
					 $ebay_amount				= $val['ebay_amount'];
					 $sku						= $val['sku'];
					 $recordnumber				= $val['recordnumber'];
						$rr			= "select goods_sncombine from ebay_productscombine where ebay_user='$user' and goods_sn='$sku'";
						$rr			= $dbcon->execute($rr);
						$rr 	 	= $dbcon->getResultArray($rr);
					
			
						
					if(count($rr) > 0){
						
						$goods_sncombine	= $rr[0]['goods_sncombine'];
									$goods_sncombine    = explode(',',$goods_sncombine);	
					
									//print_r($goods_sncombine);
									//echo count($goods_sncombine);
									for($v=0;$v<count($goods_sncombine);$v++){
						
						
											$pline			= explode('*',$goods_sncombine[$v]);
											$goods_sn		= $pline[0];
											$goddscount     = $pline[1] * $ebay_amount;
											$totalqty		= $totalqty + $goddscount;
											$uu			= "SELECT * FROM ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";			
											
								  			 $uu			= $dbcon->execute($uu);
											 $uu 	 	= $dbcon->getResultArray($uu);
											 
									
												      $goods_ywsbmc		= $uu[0]['goods_ywsbmc']?$uu[0]['goods_ywsbmc']:"None";
												      $goods_zysbmc		= $uu[0]['goods_zysbmc']?$uu[0]['goods_zysbmc']:"None";
													  $goods_weight		= $uu[0]['goods_weight']?$uu[0]['goods_weight']*1:1;
													  $goods_sbjz		= $uu[0]['goods_sbjz']?$uu[0]['goods_sbjz']:1;
													  $goods_name		= $uu[0]['goods_name'];
													  

													 $cusomstr	.= $goods_sn.'*'.$goddscount.' '.$goods_name;

													 $zzz++;
													$skuline .= $goods_sn.'*'.$goddscount.',';
									}
									
						
						
					}else{
						
						  $uu			= "select * from ebay_goods where goods_sn='$sku'";
					  $uu			= $dbcon->execute($uu);
				 	  $uu			= $dbcon->getResultArray($uu);
					  $totalqty							+= $ebay_amount;
					  $goods_zysbmc		= $uu[0]['goods_zysbmc']?$uu[0]['goods_zysbmc']:"None";
					  $goods_ywsbmc		= $uu[0]['goods_ywsbmc']?$uu[0]['goods_ywsbmc']:"None";

					  $goods_weight		= $uu[0]['goods_weight']?$uu[0]['goods_weight']*1:1;
					  $goods_sbjz		= $uu[0]['goods_sbjz']?$uu[0]['goods_sbjz']:1;
					  $goods_name		= $uu[0]['goods_name'];
					  
					   $goods_location		= $uu[0]['goods_location'];
						 $cusomstr	.= $sku.'*'.$ebay_amount.' '.$goods_name;

	
						 $zzz++;
													$skuline .= $ebay_id.' '.$sku.'*'.$ebay_amount.',';
					}
					
					
				 }





				
$skuline = substr($skuline,0,99);


					$xmlRequest		.='<content>'.$goods_ywsbmc.'</content>';
					$xmlRequest		.='<type_no>1</type_no>';
					$xmlRequest		.='<weight>'.$goods_weight.'</weight>';
					$xmlRequest		.='<single_price>'.$goods_sbjz.'</single_price>';
					$xmlRequest		.='<num>'.$ebay_amount.'</num>';
					$xmlRequest		.='<user_desc>'.$skuline.'</user_desc></order></orders>';

if($ebay_tracknumber == '' ){
	




$header[] = "Content-type: text/xml";
$url		= 'https://www.ppbyb.com/api_v2.asp';
$ch = curl_init();
 $res= curl_setopt ($ch, CURLOPT_URL,$url);
 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
 curl_setopt ($ch, CURLOPT_HEADER, 0);
 curl_setopt($ch, CURLOPT_POST, 1);
 curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlRequest);
 curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
 curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
 $data = curl_exec ($ch);
 curl_close($ch);


 



				
				$data=XML_unserialize($data); 
				$barcode				= $data['root']['barcode'];
				if($barcode != ''){
					 $upsql			= "update ebay_order set ebay_tracknumber ='$barcode' where ebay_id ='$ebay_id2'";
					 $dbcon->execute($upsql);	
					 echo '<br>'.($g).': 订单编号:'.$ebay_id2.' 提交成功: '.$barcode;
					 
					 $mark			= $data['root']['mark'];
					 	
				}else{
					 echo '<br><font color="#FF0000">'.($g).': 订单编号:'.$ebay_id2.' 提交失败</font>';
				}
				
				$PDF_A4_EN_URL			= $data['root']['PDF_A4_EN_URL'];
				$PDF_10_EN_URL			= $data['root']['PDF_10_EN_URL'];
				$PDF_A4_LCL_URL			= $data['root']['PDF_A4_LCL_URL'];
				$PDF_10_LCL_URL			= $data['root']['PDF_10_LCL_URL'];
				
				
}




		}




	}
				 


	
	if($PDF_10_EN_URL != '' ){
		
		
		echo '<br><br><a href="'.$PDF_A4_EN_URL.'" target="_blank"">打印格式01: PDF_A4_EN_URL</a><br>';
		echo '<a href="'.$PDF_10_EN_URL.'" target="_blank"">打印格式02: PDF_10_EN_URL</a><br>';
		echo '<a href="'.$PDF_A4_LCL_URL.'" target="_blank"">打印格式03: PDF_A4_LCL_URL</a><br>';
		echo '<a href="'.$PDF_10_LCL_URL.'" target="_blank"">打印格式04: PDF_10_LCL_URL</a><br></div>';
		
			
		
		
		
	}

	



		
		

?>
