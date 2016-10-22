<?PHP

	include "include/config.php";

	
	$type =		$_REQUEST['type'];



			
			
					
			if($user == 'vip492'){
					$apitoken  = 'MzAxNTI1OjE5OThsaXUxOTcy';
					$apiusid   = '301525';
			}
			
			
			
					
			if($user == 'vipking'){
					$apitoken  = 'NDAwMzA5OjQwMDMwOQ==';
					$apiusid   = '400309';
			}
			
			if($user == 'vipqw'){
					$apitoken  = 'MjAzMTM2OmFiYzIwMzEzNg==';
					$apiusid   = '203136';
			}
			
			
			if($user == 'vip778'){
					$apitoken  = 'MTAyODY3OmRkeDU5MDAxMTM=';
					$apiusid   = '102867';
			}
			
			$_post_url = 'http://online.yw56.com.cn/service/Users/'.$apiusid.'/Expresses'; 
			$post_header = array ();  
			$post_header [] = 'Authorization: basic '.$apitoken;  
			$post_header [] = 'Content-Type:text/xml; charset=utf-8';  




	$label	= '';
	$orders		= explode(",",$_REQUEST['bill']);
	
	$tkary		= array();
	$i = 0;





	if($type == 'tracknumber'){



		for($g=0;$g<count($orders);$g++){
		$sn 	=  $orders[$g];
		if($sn != ""){


			$sql	= "select * from ebay_order as a where ebay_id='$sn' ";			
			$sql	= $dbcon->execute($sql);
			$sql	= $dbcon->getResultArray($sql);
			$pxorderid				= $sql[0]['pxorderid'];
			
			$ebay_id				= $sql[0]['ebay_id'];
			
			
			$postdata = '<string>'.$pxorderid.'</string>';


			$_post_url = 'http://online.yw56.com.cn/service/Users/'.$apiusid.'/TrackingNos'; 

			
echo $_post_url;

			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $_post_url);

			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_HEADER, 1);
			curl_setopt($curl, CURLOPT_VERBOSE, 1);
			
			curl_setopt($curl, CURLOPT_HTTPHEADER, $post_header);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);

			$data = curl_exec($curl);
			curl_close($curl) ;			
			$len = strpos($data,'<?xml');			
			$data= substr($data,$len);
			$data=XML_unserialize($data); 	
			
			$status = $data['GetTrackingNoCollectionResponseType']['CallSuccess'];
			if($status == 'true'){
				
				$tracknumber	= $data['GetTrackingNoCollectionResponseType']['WaybillTrackingNos']['WaybillTrackingNo']['TrackingNo'];
				echo '订单编号:'.$ebay_id2.'成功同步, 跟踪号为: '.$tracknumber.'<br>';
				$sg			= "update ebay_order set ebay_tracknumber='$tracknumber'  where ebay_id = '$ebay_id' and ebay_user ='$user'";
				$dbcon->execute($sg);
				
				
			}


	

			
		}
		
		}

		die();


	}

	if($type =='track'){
	for($g=0;$g<count($orders);$g++){
		$sn 	=  $orders[$g];
		if($sn != ""){


			$sql	= "select * from ebay_order as a where ebay_id='$sn' ";			
			$sql	= $dbcon->execute($sql);
			$sql	= $dbcon->getResultArray($sql);
			$ebay_ordersn				= $sql[0]['ebay_ordersn'];
			$ebay_carrier				= $sql[0]['ebay_carrier'];
			$ebay_tracknumber			= $sql[0]['ebay_tracknumber'];
			$ebay_username				= $sql[0]['ebay_username'];
			$ToAddress1					= $sql[0]['ebay_street'];
			$ToAddress2					= $sql[0]['ebay_street1'];
			$ebay_state					= $sql[0]['ebay_state'];
			$ebay_postcode				= $sql[0]['ebay_postcode'];
			$ebay_phone					= $sql[0]['ebay_phone'];
			$ebay_city					= $sql[0]['ebay_city'];
			$ebay_usermail				= $sql[0]['ebay_usermail'];
			$ebay_countryname			= $sql[0]['ebay_countryname'];

			$ebay_id					= $user.'TB'.$sql[0]['ebay_id'];
			$ebay_id2					= $sql[0]['ebay_id'];
			
			/* 取得对应国家中文 */
			
			
			$vv			= "select * from ebay_countrys where countryen ='$ebay_countryname' and ebay_user ='$user' ";
			$vv			= $dbcon->execute($vv);
			$vv			= $dbcon->getResultArray($vv);
			
			if(count($vv) == 0){
				echo '订单编号:'.$ebay_id.' 未设置对应国家中文名称，请设置->系统管理，地区列表管理';
				die();
			}else{
				$cncountryname		= $vv[0]['countrycn'];
			}
			
			
		
	
	
			$post_data2 = '<ExpressType>';
			if($ebay_tracknumber != '' ) $post_data2 .= '<Epcode>'.$ebay_tracknumber.'</Epcode>';
		$post_data2 .='
	<Userid>'.$apiusid.'</Userid>
	<Channel>'.$ebay_carrier.'</Channel>
	<Package>无</Package>
	<UserOrderNumber>'.$ebay_id.'</UserOrderNumber>
	<SendDate>'.date('Y-m-d').'T'.date('H:i:s').'</SendDate>
	<Receiver><Userid>'.$apiusid.'</Userid>
	<Name>'.$ebay_username.'</Name>
	<Phone>'.$ebay_phone.'</Phone>
	<Mobile>'.$ebay_phone.'</Mobile>
	<Email>
	</Email>
	<Company>
	</Company>
	<Country>'.$cncountryname.'</Country>
	<Postcode>'.$ebay_postcode.'</Postcode>
	<State>'.$ebay_state.'</State>
	<City>'.$ebay_city.'</City>
	<Address1>'.$ToAddress1.'</Address1>
	<Address2>'.$ToAddress2.'</Address2>
	</Receiver>

';
	
			

	
		
				 $ee			= "select ebay_amount,sku,recordnumber,ebay_itemtitle,ebay_itemprice from ebay_orderdetail as a where a.ebay_ordersn='$ebay_ordersn'";
				 $ee			= $dbcon->execute($ee);
				 $ee			= $dbcon->getResultArray($ee);
				 
				 
		
				
				 
				 
				 
				 $cusomstr		= '';
				 $totalqty		= 0;

				 foreach($ee as $key=>$val){
					 
					 
						$ebay_itemtitle				= $val['ebay_itemtitle'];
					  $ebay_itemprice				= $val['ebay_itemprice'];
					 
					  $ebay_itemtitle				= str_replace('-','',$val['ebay_itemtitle']);
					  					  $ebay_itemtitle				= str_replace('"','',$val['ebay_itemtitle']);

					  
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
													  $goods_weight		= $uu[0]['goods_weight']?$uu[0]['goods_weight']*1000:1;
													  $goods_sbjz		= $uu[0]['goods_sbjz']?$uu[0]['goods_sbjz']:1;
													  $goods_name		= $uu[0]['goods_name'];
													  

											 $cusomstr	.= $goods_sn.'*'.$goddscount;

											 
									}
									
						
						
					}else{
						
						  $uu			= "select * from ebay_goods where goods_sn='$sku'";
					  $uu			= $dbcon->execute($uu);
				 	  $uu			= $dbcon->getResultArray($uu);
					  $totalqty							+= $ebay_amount;
					  $goods_zysbmc		= $uu[0]['goods_zysbmc']?$uu[0]['goods_zysbmc']:"None";
					  $goods_ywsbmc		= $uu[0]['goods_ywsbmc']?$uu[0]['goods_ywsbmc']:"None";

					  $goods_weight		= $uu[0]['goods_weight']?$uu[0]['goods_weight']*1000:1;
					  $goods_sbjz		= $uu[0]['goods_sbjz']?$uu[0]['goods_sbjz']:1;
					  $goods_name		= $uu[0]['goods_name'];
					  
					  
						 $cusomstr	.= $sku.'*'.$ebay_amount;

				

	
						
						
					}
					
					
				 }
				 
			$post_data2 .= '<Memo>'.$cusomstr.'</Memo><Quantity>'.$totalqty.'</Quantity>
			<GoodsName>
			<Userid>301911</Userid>
			<NameCh>'.$goods_zysbmc.'</NameCh>
			<NameEn>'.$goods_ywsbmc.'</NameEn>
			<Weight>'.$goods_weight.'</Weight>
			<DeclaredValue>'.$goods_sbjz.'</DeclaredValue>
			<DeclaredCurrency>USD</DeclaredCurrency><MoreGoodsName>'.$cusomstr.'</MoreGoodsName>
			</GoodsName>
			</ExpressType>';



	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $_post_url);

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_HEADER, 1);
	curl_setopt($curl, CURLOPT_VERBOSE, 1);
	
	curl_setopt($curl, CURLOPT_HTTPHEADER, $post_header);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data2);

	$data = curl_exec($curl);

	curl_close($curl) ;

	
	
	$len = strpos($data,'<?xml');
	
	$data= substr($data,$len);
	$data=XML_unserialize($data); 
		
		

		
		




if($data['CreateExpressResponseType']['CallSuccess'] =='true'){
	
	
	$Epcode		= $data['CreateExpressResponseType']['CreatedExpress']['Epcode'];
	
	echo '订单编号:'.$ebay_id2.'成功申请跟踪号, 跟踪号为: '.$Epcode.'<br>';
	$sg			= "update ebay_order set ebay_tracknumber='$Epcode',pxorderid='$Epcode'  where ebay_id = '$ebay_id2' and ebay_user ='$user'";
	$dbcon->execute($sg);
	
}else{
	
	echo '<font color="#FF0000">订单编号: '.$ebay_id2.' 出现错误: '.$data['CreateExpressResponseType']['Response']['Reason'].'</font><br>None	没有错误;<br />
V000	对象为空;<br />
V001	用户验证失败;<br />
V100	快递单号不可以为空;<br />
V101	渠道不正确;<br />
V102	此国家不能走欧洲[挂号]小包;<br />
V103	运单编号不可修改;<br />
V104	运单编号已经存在;<br />
V199	该快件不存在;<br />
V105	此国家不能走HDNL英国;<br />
V106	此国家不能走澳洲专线;<br />
V107	此国家不能走燕文美国专线;<br />
V108	此国家不能走该渠道;<br />
V200	编号不可以为空;<br />
V201	此单号已下过查单;<br />
V202	此单已经受理不能更改/删除;<br />
V203	运单编号已经存在;<br />
V204	查单状态不可为空;<br />
V205	操作时间不可为空;<br />
V299	该查单不存在;<br />
V300	编号不可以为空;<br />
V301	中文品名不可以为空;<br />
V302	英文品名不可以为空;<br />
V303	中文品名已经存在;<br />
V304	英文品名已经存在;<br />
V305	货币类型不正确;<br />
V306	申报价值格式不正确;<br />
V307	申报重量格式不正确;<br />
V308	申报物品数量格式不正确;<br />
V309	该渠道下选择的货币类型不正确;<br />
V310	多品名不可为空;<br />
V311	此渠道下申报价值不能超过500人民币<br />
V312	此渠道下重量不可超过750g<br />
V313	此渠道下重量不可超过2000g<br />
V314	此渠道下重量不可超过1000g<br />
V399	该品名不存在;<br />
V400	编号不可以为空;<br />
V401	姓名不可以为空;<br />
V402	电话不可以为空;<br />
V403	Email不可以为空;<br />
V404	国家不可以为空;<br />
V405	邮编不可以为空;<br />
V406	州编码/州不可以为空;<br />
V407	城市不可以为空;<br />
V408	地址不可以为空;<br />
V409	不符合美国邮编格式;<br />
V499	该收件人不存在;<br />
V410	收件人姓名已经存在;<br />
V500	编号不可以为空;<br />
V501	联系人不可以为空;<br />
V502	手机或座机不可以为空;<br />
V503	Email不可以为空;<br />
V504	取件地址不可以为空;<br />
V505	该用户信息不存在;<br />
V506	客户籍贯不可为空;<br />
V507	身份证号不可为空;<br />
V508	营业执照登记号不可为空;<br />
V509	公司名称不可为空;<br />
V599	联系人已经存在;<br />
V600	此追踪记录已经存在;<br />
V601	地址不可为空;<br />
V602	时间不可为空;<br />
V603	追踪号不可为空;<br />
V604	序列号不可为空;<br />
S1	系统错误;<br />
D1	数据处理错误;<br />';
	

	
}

			
		}
	}
	



	}else{


			


			/* 调用打印接口*/


echo $type;

$ordersn	= $_REQUEST['bill'];
$ordersn		= explode(",",$ordersn);

	for($i=0;$i<count($ordersn);$i++){
		
		
			if($ordersn[$i] != ""){
		
			 $sn			= $ordersn[$i];
			 
		$tj	.= "a.ebay_id='$sn' or ";
			}
			
		
	}
	
	
			$tj		= substr($tj,0,strlen($tj)-3);

			$sql			= "select a.*,b.sku from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn=b.ebay_ordersn where    ($tj) group by a.ebay_id order by b.sku ";

	 $sql			= $dbcon->execute($sql);
	 $sql			= $dbcon->getResultArray($sql);
	 
$tk	= '';

	for($i=0;$i<count($sql);$i++){
	

			
		$tk			.= $sql[$i]['ebay_tracknumber'].',';	 

	}




	$tk		= substr($tk,0,strlen($tk)-1);
	


	$post_data2		= '<string>'.$tk.'</string>';

echo $post_data2;
	$_post_url = 'http://online.yw56.com.cn/service/Users/'.$apiusid.'/Expresses/'.$type.'Label'; 
echo $_post_url;

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $_post_url);

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_HEADER, 1);
	curl_setopt($curl, CURLOPT_VERBOSE, 1);
	
	curl_setopt($curl, CURLOPT_HTTPHEADER, $post_header);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data2);

	$data = curl_exec($curl);

	curl_close($curl) ;



	
	$len = strpos($data,'%PDF');
	
	$data= substr($data,$len);
		
				$file= date('Y').date('m').date('d').date('H').date('i').date('s').$user.rand(100,9999).'eub.pdf';
			    file_put_contents("images/".$file,$data);
				$filenames = "images/".$file;

			



			echo "<a href='http://42.121.19.218/v3-all/".$filenames."'>下载</a>";



	}


	?>



