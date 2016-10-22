<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="style/cskt.css" />
</head>
<body>
<?php
	
	
	include "include/config.php";
	
	
	
	$account				= $_POST['account'];
	$orderstatus			= $_POST['orderstatus'];

	function CheckID($recordnumber,$account){
		global $dbcon;		
		$sql		= "select * from ebay_order where recordnumber='$recordnumber' and ebay_account='$account'";
		
		echo $sql.'<br>';
		$sql  = $dbcon->execute($sql);
		$sql  = $dbcon->getResultArray($sql);
		if(count($sql) == 0){
		$status			= "0";
		}else{
		$status 		= $sql[0]['ebay_ordersn'];
		}
		
		
		return $status;
	}
	



	
	$uploadfile = date("Y").date("m").date("d").rand(1,3009).".xls";
	

	

	if (move_uploaded_file($_FILES['upfile']['tmp_name'], 'images/'.$uploadfile)) {
	
		echo "<font color=BLUE>文件上传成功！</font><br>";
	
	}else {
   		
		echo "<font color=red> 文件上传失败！</font>  <a href='index.php'>返回</a><br>"; 	
	}
	echo $uploadfile;
	
	
	$fileName = 'images/'.$uploadfile;	
	$filePath = $fileName;

	require_once 'Classes/PHPExcel.php';





$PHPExcel = new PHPExcel(); 
$PHPReader = new PHPExcel_Reader_Excel2007();    
if(!$PHPReader->canRead($filePath)){      
$PHPReader = new PHPExcel_Reader_Excel5(); 
if(!$PHPReader->canRead($filePath)){      
echo 'no Excel';
return ;
}
}
$PHPExcel = $PHPReader->load($filePath);
$currentSheet = $PHPExcel->getSheet(0);
/**取得一共有多少列*/


$c=2;


while(true){
	
	$aa	= 'A'.$c;
	$bb	= 'B'.$c;
	$cc	= 'C'.$c;
	$dd	= 'D'.$c;
	$ee	= 'E'.$c;
	$ff	= 'F'.$c;
	$gg	= 'G'.$c;
	$hh	= 'H'.$c;
	$ii	= 'I'.$c;
	$jj	= 'J'.$c;
	$kk	= 'K'.$c;
	$ll	= 'L'.$c;
	$mm	= 'M'.$c;
	$nn	= 'N'.$c;
	$oo	= 'O'.$c;
	$pp	= 'P'.$c;
	$qq	= 'Q'.$c;
	$rr	= 'R'.$c;
	$ss	= 'S'.$c;
	$tt	= 'T'.$c;
	$uu	= 'U'.$c;
	$vv	= 'V'.$c;
	$ww	= 'W'.$c;
	$zz	= 'Z'.$c;
	$xx	= 'X'.$c;
	$gb	= 'AA'.$c;
	$val				= date('Y')."-".date('m')."-".date('d')."-".date("H").date('i').date('s'). mt_rand(100, 999);
				
	while(true){
					$si		= "select * from ebay_order where ebay_ordersn='$val'";
					$si		= $dbcon->execute($si);
					$si		= $dbcon->getResultArray($si);
					if(count($si)==0) break;
					$val				= date('Y')."-".date('m')."-".date('d')."-".date("H").date('i').date('s'). mt_rand(100, 999);

	}
				
	
	
	
	$recordnumber	 			= str_rep(trim($currentSheet->getCell($aa)->getValue())); //订单号
	
	
	

	
	if($recordnumber != ''){
	
	
	$ebay_userid				= str_rep(trim($currentSheet->getCell($bb)->getValue())); //买家名称
	$ebay_username				= str_rep(trim($currentSheet->getCell($bb)->getValue())); //买家名称
	$ebay_countryname			= str_rep(trim($currentSheet->getCell($ee)->getValue()));
	$ebay_total					= str_rep(trim($currentSheet->getCell($ff)->getValue()));   //订单金额
	$ebay_currency				= str_rep(trim($currentSheet->getCell($gg)->getValue()));   //订单金额
	$ebay_street				= str_rep(trim($currentSheet->getCell($hh)->getValue()));
	$ebay_street1				= str_rep(trim($currentSheet->getCell($ii)->getValue()));
	$ebay_carrier				= str_rep(trim($currentSheet->getCell($jj)->getValue()));   //买家选择物流
	
	
	if($ebay_carrier   == 'HK包挂号'){
	$ebay_carrier		= '香港小包挂号';
	}
	
	if($ebay_carrier   == 'UPS'){
	$ebay_carrier		= 'UPS';
	}
	
	if($ebay_carrier   == 'DHL'){
	$ebay_carrier		= 'DHL';
	}
	if($ebay_carrier   == 'FEDEX'){
	$ebay_carrier		= 'FEDEX';
	}
	
	if($ebay_carrier   == 'TNT'){
	$ebay_carrier		= 'TNT';
	}
	
	if($ebay_carrier   == 'EMS'){
	$ebay_carrier		= 'EMS';
	}
	
	if($ebay_carrier   == 'CN包挂号'){
	$ebay_carrier		= '中国邮政挂号';
	}
	
	
	
	$ebay_city					= str_rep(trim($currentSheet->getCell($kk)->getValue()));   //买家选择物流
	$ebay_state					= str_rep(trim($currentSheet->getCell($ll)->getValue()));
	$ebay_postcode				= str_rep(trim($currentSheet->getCell($mm)->getValue()));
	$ebay_phone					= str_rep(trim($currentSheet->getCell($nn)->getValue()));
	$ebay_paidtime					= $mctime;
	$ebay_createdtime				= $mdtimee;
	
	$productsinformation					= str_rep(trim($currentSheet->getCell('C'.$c)->getValue()));   //订单金额
	$productsinformation 		= explode(',',$productsinformation);

	$dataarray					= '';
	$jj							= 0;
	
	for($j=0; $j<count($productsinformation);$j++){
	
			
			$labelstr		= $productsinformation[$j];
			if($labelstr != '' ){
			
			
				$data 		= explode('*',$labelstr);
				$sku		= $data[0];
				$qty		= $data[1];
				
				if($qty == '') $qty					= trim($currentSheet->getCell($dd)->getValue());   //订单金额
				
				
				$dataarray[$jj]['sku']	= $sku;
				$dataarray[$jj]['qty']	= $qty;
				$jj++;
				
			}
	
	
	}


		

	


	
	$vv			= CheckID($recordnumber,$account);
	echo $recordnumber.' 添加状态：  ';
	
	if($vv == '0'){
		
		
		$sql					= "insert into  ebay_order(ebay_ordersn,ebay_paystatus,recordnumber,ebay_tid,ebay_ptid,ebay_orderid,ebay_createdtime,ebay_paidtime,ebay_userid,ebay_username,ebay_usermail,ebay_street,ebay_street1,ebay_city,ebay_state,ebay_countryname,ebay_postcode,ebay_phone,ebay_total,ebay_status,ebay_user,ebay_addtime,ebay_shipfee,ebay_account,ebay_note,ebay_carrier,ebay_warehouse,ebay_currency) values('$val','Complete','$recordnumber','$ebay_tid','$ebay_ptid','$ebay_orderid','$ebay_createdtime','$ebay_paidtime','$ebay_userid','$ebay_username','$ebay_usermail','$ebay_street','$ebay_street1','$ebay_city','$ebay_state','$ebay_countryname','$ebay_postcode','$ebay_phone','$ebay_total','$orderstatus','$user','$mctime','$ebay_shipfee','$account','$ebay_note','$ebay_carrier','$defaultstoreid','$ebay_currency')";

		if($dbcon->execute($sql)){
						echo "$val 添加成功: UserID:$UserID  <br>";
						$sql = "select * from ebay_orderdetail where ebay_ordersn='$val' and recordnumber='$recordnumber'";
		$sql = $dbcon->query($sql);
		$sql	 = $dbcon->num_rows($sql);

		if($sql == 0){			

		
		/* 开始添加产品数据 */
		for($j=0;$j<count($dataarray);$j++){
		
		
		print_r($dataarray);
		
		
			$sku						= $dataarray[$j]['sku'];
			$amount						= $dataarray[$j]['qty'];
			$title						= $dataarray[$j]['title'];
			
			
				$ss				= "SELECT * FROM  `ebay_goods` where ebay_user='$user' and goods_sn='$sku'";
				$ss				= $dbcon->execute($ss);
				$ss				= $dbcon->getResultArray($ss);
				$goods_location		= $ss[0]['goods_location'];
				
				$esql	 = "INSERT INTO `ebay_orderdetail` (`ebay_ordersn` ,`ebay_itemid` ,`ebay_itemtitle` ,`ebay_itemprice` ,";
				$esql    .= "`ebay_amount` ,`ebay_createdtime` ,`ebay_shiptype` ,`ebay_user`,`sku`,`shipingfee`,`ebay_account`,`addtime`,`ebay_itemurl`,`ebay_site`,`recordnumber`,`storeid`,`ListingType`,`ebay_tid`,`FeeOrCreditAmount`,`FinalValueFee`,`attribute`,`notes`,`goods_location`)VALUES ('$val', '$iid' , '$title' , '$ebay_itemprice' , '$amount'";

				$esql	.= " , '$ctime' , '$shiptype' , '$user','$sku','$shipingfee','$account','$mctime','$pic','$site','$recordnumber','$storeid','$ListingType','$tid','$FeeOrCreditAmount','$FinalValueFee','$arrribute','$BuyerCheckoutMessage','$goods_location')";	
				
				
				echo '<br>'.$esql.'<br>';
				

				
				
			if($dbcon->execute($esql)){				
				echo "$iid 添加成功"."<br>";			
			}else{
				echo '<font color=red>添加失败</font>';
			}
		
		}
		
		}
		}

		
	
	
		
		
		
		
	}
	

	
	$c++;

	
	
	}
	if($recordnumber == '') break;
	
	

}





						$sql		= "select * from ebay_order as a where ebay_user='$user'  and ebay_combine!='1' and ebay_status = '620'  ";
						$sql	= $dbcon->execute($sql);
						$sql	= $dbcon->getResultArray($sql);
		
					
						
						for($i=0;$i<count($sql);$i++){
						
						
					
							$ebay_carrier		= $sql[$i]['ebay_carrier'];
							$ebay_countryname	= $sql[$i]['ebay_countryname'];
							$ebay_currency		= $sql[$i]['ebay_currency'];
							$ebay_total			= $sql[$i]['ebay_total'];
							$ebay_couny			= $sql[$i]['ebay_couny'];
							$ebay_id			= $sql[$i]['ebay_id'];
							$ebay_note			= $sql[$i]['ebay_note'];
							$ebay_ordersn		= $sql[$i]['ebay_ordersn'];
							$ebay_userid		= $sql[$i]['ebay_userid'];
							$ebay_account		= $sql[$i]['ebay_account'].',';
							$ebay_total			= $sql[$i]['ebay_total'];
							
	
							
							
							// 将有留言订单转到有留言订单分类中去
							/*
							if($ebay_note != '' && $notesorderstatus >= 1){
							
							$ss				= "update ebay_order set ebay_status = '$notesorderstatus' where ebay_id = '$ebay_id' ";
							echo $ss.'<br>';
							$dbcon->execute($ss);
							
							}
							*/
							
							
							
							
							/* 计算包装材料和订单总重量 */
							$st	= "select * from ebay_orderdetail where ebay_ordersn='$ebay_ordersn'";
							$st = $dbcon->execute($st);
							$st	= $dbcon->getResultArray($st);
							
							
							
							$iszuhe		= 0;
							
							for($f=0;$f<count($st); $f++){
								
								$sku		= $st[$f]['sku'];
								$rr			= "select * from ebay_productscombine where ebay_user='$user' and goods_sn='$sku'";
								$rr			= $dbcon->execute($rr);
								$rr 	 	= $dbcon->getResultArray($rr);
								if(count($rr) > 0) $iszuhe = 1;
							}
							
							if($iszuhe == '1') $rr= "update ebay_order set ebay_status ='606' where ebay_id = '$ebay_id' ";
							$totalweight				= 0;
							$totalweight2				= 0;
								
							
							if(count($st)  == 1){
								
								/* 计算订单中单个物品包材的重量 */
							
								
								$sku						=  $st[0]['sku'];
								$ebay_amount				=  $st[0]['ebay_amount'];
								
								/* 开始检查是否是组合产品 */
								$rr			= "select * from ebay_productscombine where ebay_user='$user' and goods_sn='$goodssn'";
								$rr			= $dbcon->execute($rr);
								$rr 	 	= $dbcon->getResultArray($rr);
		
				
								if(count($rr) > 0){
			
										$goods_sncombine	= $rr[0]['goods_sncombine'];
										$goods_sncombine    = explode(',',$goods_sncombine);
										for($e=0;$e<count($goods_sncombine);$e++){
												$pline			= explode('*',$goods_sncombine[$e]);
												$goods_sn		= $pline[0];
												$goddscount     = $pline[1] * $ebay_amount;
												$ee			= "SELECT * FROM ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
												$ee			= $dbcon->execute($ee);
												$ee 	 	= $dbcon->getResultArray($ee);
												$ebay_packingmaterial		=  $ee[0]['ebay_packingmaterial'];			
												$goods_weight				=  $ee[0]['goods_weight'];					// 产品重量子力学
												$capacity					=  $ee[0]['capacity'];						//产品容量
												$ss					= "select * from ebay_packingmaterial where  model='$ebay_packingmaterial' and ebay_user ='$user' ";
												$ss					= $dbcon->execute($ss);
												$ss					= $dbcon->getResultArray($ss);
												$pweight			= $ss[0]['weight'];
												if($goddscount <= $capacity){
													$totalweight			+= $pweight*$goddscount + ($goods_weight * $goddscount);
												}else{
													// 计算多个包材的重量   $ebay_amount 单个sku购买的数量 ebay_packingmaterial 包材的重量
													$totalweight2			+= $goods_weight*$ebay_amount + $pweight;
												}
										}
										if($totalweight2>0) $totalweight2			+= 0.6 * $pweight ;
								}else{
						
				
								
										$ss							= "select * from ebay_goods where  goods_sn='$sku' and ebay_user ='$user' ";
										$ss							= $dbcon->execute($ss);
										$ss							= $dbcon->getResultArray($ss);
										$ebay_packingmaterial		=  $ss[0]['ebay_packingmaterial'];			
										$goods_weight				=  $ss[0]['goods_weight'];					// 产品重量子力学
										$capacity					=  $ss[0]['capacity'];						//产品容量
										
										$ss					= "select * from ebay_packingmaterial where  model='$ebay_packingmaterial' and ebay_user ='$user' ";
										$ss					= $dbcon->execute($ss);
										$ss					= $dbcon->getResultArray($ss);
										$pweight			= $ss[0]['weight'];
										
										if($ebay_amount <= $capacity){
										
											$totalweight			+= $pweight + $goods_weight*$ebay_amount;
										
										}else{
											// 计算多个包材的重量   $ebay_amount 单个sku购买的数量 ebay_packingmaterial 包材的重量
											$totalweight2			+= $goods_weight*$ebay_amount + $pweight;	
											
											
										}
										if($totalweight2>0) $totalweight2			+= 0.6 * $pweight ;
							}
								

					
							
							
							}else{
								
								
								/* 计算订单中多个物品包材的重量 */
								$totalweight				= 0;		
								$totalweight2				= 0;
								
								
								for($f=0;$f<count($st); $f++){
									
									
										
										
										$sku						=  $st[$f]['sku'];
										$ebay_amount				=  $st[$f]['ebay_amount'];
										
										/* 开始检查是否是组合产品 */
										$rr			= "select * from ebay_productscombine where ebay_user='$user' and goods_sn='$goodssn'";
										$rr			= $dbcon->execute($rr);
										$rr 	 	= $dbcon->getResultArray($rr);
		
				
								if(count($rr) > 0){
			
									$goods_sncombine	= $rr[0]['goods_sncombine'];
									$goods_sncombine    = explode(',',$goods_sncombine);
					
					
					
									for($e=0;$e<count($goods_sncombine);$e++){
						
						
											$pline			= explode('*',$goods_sncombine[$e]);
											$goods_sn		= $pline[0];
											$goddscount     = $pline[1] * $ebay_amount;
						
											$ee			= "SELECT * FROM ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
											$ee			= $dbcon->execute($ee);
											$ee 	 	= $dbcon->getResultArray($ee);
											$ebay_packingmaterial		=  $ee[0]['ebay_packingmaterial'];			
											$goods_weight				=  $ee[0]['goods_weight'];					// 产品重量子力学
											$capacity					=  $ee[0]['capacity'];						//产品容量
											
											$ss					= "select * from ebay_packingmaterial where  model='$ebay_packingmaterial' and ebay_user ='$user' ";
											$ss					= $dbcon->execute($ss);
											$ss					= $dbcon->getResultArray($ss);
											$pweight			= $ss[0]['weight'];
											
											if($goddscount <= $capacity){
												$totalweight			+= $pweight + $goods_weight*$ebay_amount;
											}else{
											
												// 计算多个包材的重量   $ebay_amount 单个sku购买的数量 ebay_packingmaterial 包材的重量
												$totalweight2			+= $goods_weight*$ebay_amount + $pweight;	
												
												
											}
											
									}
									
									
							}else{
						
				
								
								$ss							= "select * from ebay_goods where  goods_sn='$sku' and ebay_user ='$user' ";
								$ss							= $dbcon->execute($ss);
								$ss							= $dbcon->getResultArray($ss);
								$ebay_packingmaterial		=  $ss[0]['ebay_packingmaterial'];			
								$goods_weight				=  $ss[0]['goods_weight'];					// 产品重量子力学
								$capacity					=  $ss[0]['capacity'];						//产品容量
								
								
								
								$ss					= "select * from ebay_packingmaterial where  model='$ebay_packingmaterial' and ebay_user ='$user' ";
								$ss					= $dbcon->execute($ss);
								$ss					= $dbcon->getResultArray($ss);
								$pweight			= $ss[0]['weight'];
								
								if($ebay_amount <= $capacity){
								
									$totalweight			+= $pweight + $goods_weight*$ebay_amount;
								
								}else{
									// 计算多个包材的重量   $ebay_amount 单个sku购买的数量 ebay_packingmaterial 包材的重量
									$totalweight2			+= $goods_weight*$ebay_amount + $pweight;	
									
								}
								
								
								
								
								}
								
								
								}
								if($totalweight2>0) $totalweight2			+= 0.6 * $pweight ;
							
							}
							
							$totalweight						= $totalweight2  + $totalweight;
							
							
							
							
							
							if($ebay_carrier == '香港小包挂号') $shipfee							= calchkghpost($totalweight,$ebay_countryname);
							if($ebay_carrier == '香港小包平邮') $shipfee							= calchkpost($totalweight,$ebay_countryname);
							if($ebay_carrier == '中国邮政挂号') {
							
							
							
							$dd		= "SELECT * FROM  `ebay_cpghcalcfee` where countrys like '%$ebay_countryname%' ";
									$dd		= $dbcon->execute($dd);
									$dd		= $dbcon->getResultArray($dd);
									if(count($dd)>=1){
									$firstweight	= $dd[0]['firstweight'];
									$nextweight		= $dd[0]['nextweight'];
									$handlefee		= $dd[0]['handlefee'];
									$discount		= $dd[0]['discount']?$dd[0]['discount']:1;
									$xx0			= $dd[0]['xx0'];
									$xx1			= $dd[0]['xx1'];
									$gg					= "select * from  ebay_carrierweight where $totalweight between min and max and shipping_id = '$id'";
									$gg		= $dbcon->execute($gg);
									$gg		= $dbcon->getResultArray($gg);
									

					
						
									if(count($gg) >=1){
									
									
										$totalweighte	= $gg[0]['weight'];
										if($totalweighte <= ($xx0/1000)){
										$shipfee	= $firstweight + $handlefee;
										}else{
										$shipfee	= ceil(((($totalweighte*1000) -$xx0)/$xx1))*$nextweight + $firstweight + $handlefee;
										}
										$shipfee	= $shipfee * $discount;
									}else{
									
										if($totalweight <= ($xx0/1000)){
										$shipfee	= $firstweight + $handlefee;
										}else{
										$shipfee	= ceil(((($totalweight*1000) -$xx0)/$xx1))*$nextweight + $firstweight + $handlefee;
										}
									}
									}
									
							
							
							
							
							}
							
							
							if($ebay_carrier  == 'EMS'){
								
									$dd		= "SELECT * FROM  `ebay_emscalcfee` where countrys like '%$ebay_countryname%' ";
									$dd		= $dbcon->execute($dd);
									$dd		= $dbcon->getResultArray($dd);
									$firstweight	= $dd[0]['firstweight'];
									$nextweight		= $dd[0]['nextweight'];
									$handlefee		= $dd[0]['handlefee'];
									$discount		= $dd[0]['discount']?$dd[0]['discount']:1;
									$firstweight0	= $dd[0]['firstweight0'];
									$files			= $dd[0]['files'];
									
									if($files == '1' && $totalweight <= 0.5){
										
										$firstweight	= $firstweight0;
									}
									
									if($totalweight <= 0.5){
							
									$shipfee	= $firstweight;
						
									}else{
								
									$shipfee	= ceil((($totalweight*1000)/500))*$nextweight + $firstweight + $handlefee;
									}
								
									$shipfee	= $shipfee *$discount;
								
								}
							
						
			
							$bb									= "update ebay_order set ordershipfee='$shipfee',orderweight ='$totalweight',packingtype ='$ebay_packingmaterial' where ebay_id ='$ebay_id' ";
							
							
							
							$dbcon->execute($bb);
							if($totalweight > 2){
							$bb						= "update ebay_order set ebay_status ='608' where ebay_id ='$ebay_id' ";
							$dbcon->execute($bb);
							}
							
						
							
								
						
							
							
							
						
						}
						

?>

<script language="javascript">
	
	alert('订单导入完成');



</script>





