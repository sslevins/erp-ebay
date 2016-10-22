<?PHP

	include "include/config.php";

	error_reporting(E_ALL);
	
	
	$type =		$_REQUEST['type'];
	

$apitoken	= '052838f370bfc55ec7b2335ec2ceff3b778';

			
			
	
			

			
			$apiusid   = '302353';
			$_post_url = 'http://online.yw56.com.cn/service/Users/'.$apiusid.'/Expresses'; 
			$post_header = array ();  
			$post_header [] = 'Authorization: basic '.$apitoken;  
			$post_header [] = 'Content-Type:text/xml; charset=utf-8';  




			$label	= '';
			$orders		= explode(",",$_REQUEST['bill']);
			
			$tkary		= array();
			$i = 0;




			$mark		= date('Y').date('m').date('d').date('H').date('i').date('s').rand(0,999);



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
			$ebay_postcode				= $sql[0]['ebay_postcode'];
			$ebay_phone					= $sql[0]['ebay_phone']?$sql[0]['ebay_phone']:'626883690';
			$ebay_city					= $sql[0]['ebay_city'];
			$ebay_usermail				= $sql[0]['ebay_usermail'];
			$ebay_countryname			= $sql[0]['ebay_countryname'];
			$ebay_id2					= $sql[0]['ebay_id'];
			$ebay_account				= $sql[0]['ebay_account'];
			$ebay_couny					= $sql[0]['ebay_couny'];
			$ebay_tracknumber					= $sql[0]['ebay_tracknumber'];
			
			
			$vv	= "select * from ebay_countrys as a where countrysn='$ebay_couny' and ebay_user ='$user' ";			
			$vv	= $dbcon->execute($vv);
			$vv	= $dbcon->getResultArray($vv);
			
			

		
			
			
			if(count($vv) != 0 ){
				
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



				$goods_ywsbmc		= str_replace('&','',$goods_ywsbmc);
				
		if($goods_weight>=2) $goods_weight = 0.5;
				
				
				$ebay_countryname			= str_replace(' ','+',$ebay_countryname);
				$ebay_city					= str_replace(' ','+',$ebay_city);
				$ToAddress1					= str_replace(' ','+',$ToAddress1);
				$ToAddress2					= str_replace(' ','+',$ToAddress2);
				$ebay_username				= str_replace(' ','+',$ebay_username);
				$province					= str_replace(' ','+',$province);
				
				
				if(strlen($skuline) >= 100){
					$skuline = substr($skuline,0,99);
					
				}
				
				
				

				 //original code
				 //$curlPost = 'api_key=baa7c55a3f371c3a486ffbfd39497e0f&mark='.$mark.'&otype=1&to='.$ebay_username.'&recipient_country='.$ebay_countryname.'&recipient_province='.$ebay_state.'&recipient_city='.$ebay_city.'&recipient_addres='.$ToAddress1.' '.$ToAddress2.'&recipient_postcode='.$ebay_postcode.'&recipient_phone='.$ebay_phone.'&type_no=1&from_country=China&content='.$goods_ywsbmc.'&num='.$ebay_amount.'&weight='.$goods_weight.'&single_price='.$goods_sbjz.'&from='.$fromusername.'&sender_province='.$province.'&sender_city='.$fromcity.'&sender_addres='.$fromstreet.'&sender_phone='.$ebay_phone.'&user_desc='.$skuline;
				 // the following is new code (2014-04-03 16:03)
				   $curlPost = 'api_key='.$apitoken.'&mark='.$mark.'&otype='.$type.'&to='.$ebay_username.'&recipient_country='.$ebay_countryname.'&recipient_province='.$ebay_state.'&recipient_city='.$ebay_city.'&recipient_addres='.$ToAddress1.' '.$ToAddress2.'&recipient_postcode='.$ebay_postcode.'&recipient_phone='.$ebay_phone.'&type_no=1&from_country=China&content='.$goods_ywsbmc.'&num='.$ebay_amount.'&weight='.$goods_weight.'&single_price='.$goods_sbjz.'&from='.$fromusername.'&sender_province='.$province.'&sender_city='.$fromcity.'&sender_addres='.$fromstreet.'&sender_phone='.$ebay_phone.'&user_desc='.$skuline.'&to_local='.$ebay_username.'&recipient_country_local='.$ebay_countryname.'&recipient_province_local='.$ebay_state.'&recipient_city_local='.$ebay_city.'&recipient_addres_local='.$ToAddress1.' '.$ToAddress2;
				 
				 echo $curlPost;


				if($ebay_tracknumber == '' ){
				$ch = curl_init();//ʼcurl
				curl_setopt($ch,CURLOPT_URL,'http://www.ppbyb.com/api.asp');//ץȡָҳ
				curl_setopt($ch, CURLOPT_HEADER, 0);//header
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//ҪΪַĻ
				curl_setopt($ch, CURLOPT_POST, 1);//postύʽ
				curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
				$data = curl_exec($ch);//curl
				
				
			
				curl_close($ch);
				$data=XML_unserialize($data); 
				
				print_r($data);
				
				
				$barcode				= $data['root']['barcode'];
				
				
				
				if($barcode != ''){
					
					
					$upsql			= "update ebay_order set ebay_tracknumber ='$barcode' where ebay_id ='$ebay_id2'";
					 $dbcon->execute($upsql);		
					
				}
				
				
				
				$PDF_A4_EN_URL			= $data['root']['PDF_A4_EN_URL'];
				$PDF_10_EN_URL			= $data['root']['PDF_10_EN_URL'];
				$PDF_A4_LCL_URL			= $data['root']['PDF_A4_LCL_URL'];
				$PDF_10_LCL_URL			= $data['root']['PDF_10_LCL_URL'];
				
				
				}
				



		}




	}
				 


	
	if($PDF_10_EN_URL != '' ){
		
		
		echo '<div style="position:absolute; top:0px; left:0px; width:250px; height:120px; background:#CCCCCC; z-index:6"><a href="'.$PDF_A4_EN_URL.'" target="_blank"">打印格式01: PDF_A4_EN_URL</a><br>';
		echo '<a href="'.$PDF_10_EN_URL.'" target="_blank"">打印格式02: PDF_10_EN_URL</a><br>';
		echo '<a href="'.$PDF_A4_LCL_URL.'" target="_blank"">打印格式03: PDF_A4_LCL_URL</a><br>';
		echo '<a href="'.$PDF_10_LCL_URL.'" target="_blank"">打印格式04: PDF_10_LCL_URL</a><br></div>';
		
			
		
		
		
	}

	



		
		

?>
