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


$devID		= "3c8c9ee7-8f63-49c6-b7c8-12ed11031b6b";
$appID		= "Sure9f8a9-3061-4343-b880-bb52a1b4bf0";
$certID		= "647a790b-8af4-4509-bee3-49cce136b4e4";



$serverUrl	= "https://api.ebay.com/ws/api.dll";
$siteID = 0;  
$detailLevel = 0;
$nowtime	= date("Y-m-d H:i:s");
$nowd		= date("Y-m-d");
$Sordersn	= "eBay";
$pagesize=20;//每页显示的数据条目数
$mctime		= strtotime($nowtime);



$truename	= $_SESSION['truename'];
/*王民伟   2012-04-19 根据登录名检索所在部门*/
	$getDept="select department from ebay_user where username='$truename'";
	$getDept=$dbcon->execute($getDept);
	$getDept=$dbcon->getResultArray($getDept);
	$deptName=$getDept[0]['department'];
/*end */
$sql		= "select * from ebay_user where username='$truename'";
$sql		= $dbcon->execute($sql);
$sql		= $dbcon->getResultArray($sql);
$pagesize	= $sql[0]['record']?$sql[0]['record']:"20";

	/* 加载系统默认配置*/
	$ss		= "select * from ebay_config WHERE `ebay_user` ='$user' LIMIT 1";
	$ss		= $dbcon->execute($ss);
	$ss		= $dbcon->getResultArray($ss);
	$defaultstoreid				= $ss[0]['storeid'];
	$notesorderstatus			= $ss[0]['notesorderstatus'];
	$auditcompleteorderstatus	= $ss[0]['auditcompleteorderstatus'];
	$hackorerstatus				= $ss[0]['hackorer'];
	
	$overtock					= $ss[0]['overtock']; // 缺货订单分类
	
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
	
	/* 计算香港小包平邮的实际运费 */
	function calchkpost($totalweight,$countryname){
		
		global $dbcon;
		$ss		= "select * from ebay_hkpostcalcfee where countrys like '%$countryname%'";
		$ss		= $dbcon->execute($ss);
		$ss		= $dbcon->getResultArray($ss);
		
		$rate			= $ss[0]['discount']?$ss[0]['discount']:1;
		$kg				= $ss[0]['firstweight'];
		$handlefee		= $ss[0]['handlefee'];
		
		
		$shipfee		= $kg * $totalweight + $handlefee;
		if($rate > 0) $shipfee		= $shipfee * $rate;
		return $shipfee;
						
	
	
	}
	
	/* 计算香港小包挂号的费用 */
	function calchkghpost($totalweight,$countryname){
	
		global $dbcon;
		$ss		= "select * from ebay_hkpostghcalcfee where countrys like '%$countryname%'";
		$ss		= $dbcon->execute($ss);
		$ss		= $dbcon->getResultArray($ss);
		
		$rate			= $ss[0]['discount']?$ss[0]['discount']:1;
		$kg				= $ss[0]['firstweight'];
		$handlefee		= $ss[0]['handlefee'];
		$shipfee		= $kg * $totalweight + $handlefee;
		if($rate > 0) $shipfee		= $shipfee * $rate;
		return $shipfee;
	
	}
	
	
	function calcems($totalweight,$countryname){
		
		global $dbcon;
		$dd		= "SELECT * FROM  `ebay_emscalcfee` where countrys like '%$ebay_countryname%' ";
		$dd		= $dbcon->execute($dd);
		$dd		= $dbcon->getResultArray($dd);
		$firstweight	= $dd[0]['firstweight'];
		$nextweight		= $dd[0]['nextweight'];
		$handlefee		= $dd[0]['handlefee'];
		$discount		= $dd[0]['discount'];
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
		return $shipfee;							
	
	}
	
	
	function calceub($totalweight,$countryname){
		
		global $dbcon;
		
		$ss		= "select * from ebay_carrier where ebay_user ='$user' and name ='EUB' ";
		$ss		= $dbcon->execute($ss);
		$ss		= $dbcon->getResultArray($ss);
		$discount				= $ss[0]['discount']?$ss[0]['discount']:1;
		if($totalweight <= 0.05){
		$shipfee	= 6;
		}else{
		$shipfee	= $totalweight * $handlefee;
		}
		return $shipfee;
	}
	
	
	function calcchinapostgh($totalweight,$countryname){
	
			global $dbcon;
			
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
			    if($totalweight <= ($xx0/1000)){
				$shipfee	= $firstweight + $handlefee;
				}else{
				$shipfee	= ceil(((($totalweight*1000) -$xx0)/$xx1))*$nextweight + $firstweight + $handlefee;
				}
			}
			
			
			return $shipfee;
			
	}
	
	function calchkpypost($totalweight,$countryname){
	
			global $dbcon;
			
			$dd		= "SELECT * FROM  `ebay_cppycalcfee` where countrys like '%$ebay_countryname%' ";
			$dd		= $dbcon->execute($dd);
			$dd		= $dbcon->getResultArray($dd);
			if(count($dd)>=1){
				$firstweight	= $dd[0]['firstweight'];
				$nextweight		= $dd[0]['nextweight'];
				$handlefee		= $dd[0]['handlefee'];
				$discount		= $dd[0]['discount']?$dd[0]['discount']:1;
				$xx0			= $dd[0]['xx0'];
				$xx1			= $dd[0]['xx1'];
			    if($totalweight <= ($xx0/1000)){
				$shipfee	= $firstweight + $handlefee;
				}else{
				$shipfee	= ceil(((($totalweight*1000) -$xx0)/$xx1))*$nextweight + $firstweight + $handlefee;
				}
			}
			
			
			return $shipfee;
			
	}
	
	
	/* 计算香港小包挂号的费用 */
	
	
	
	
	function calcshippingfee($totalweight,$ebay_countryname,$orderid,$ebay_account,$ebay_total){
			global $dbcon,$user;
			
			echo "\n-------------------订单号:$orderid ----------$ebay_countryname------------\n";
							
			$ss		= "delete from ebay_lishicalcfee where orderid ='$orderid' ";
			$dbcon->execute($ss);
			
			
			
			$ss     = "select * from ebay_order where ebay_id ='$orderid' ";
			
			echo $ss.'dddd';
			
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			
			$ebay_ordersn = $ss[0]['ebay_ordersn'];
			
			$ss		= "select * from ebay_orderdetail where ebay_ordersn ='$ebay_ordersn'";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			
			$isdangerous = 0;
			if(count($ss) == 1){
			for($i=0;$i<count($ss);$i++){
				
				
				$sku		= $ss[$i]['sku'];
				if($sku == '2090' || $sku == '2091' || $sku == '2092' || $sku == '2095' || $sku == '2096' || $sku == '2083' || $sku == '2420'  || $sku == '2526'  || $sku == '2693'  || $sku == '306'  || $sku == '344'  || $sku == '829'  || $sku == '830'  || $sku == '831' || $sku == '1075'  || $sku == '1463'  || $sku == '1552'  || $sku == '1553'  || $sku == '2402' ){
				
				
				$isdangerous = 1;
				
				}
				
				
				
			
			
			}				
			echo $sku.'**'.$isdangerous;
			
			}
			
			
			
			$ss		= "select * from ebay_carrier where ebay_user ='$user' and country not like '%$ebay_countryname%'";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			
			
						
							
			$data	= array();
							
			for($i=0;$i<count($ss);$i++){
								
				$shipfee				= 0;
				
				$name					= $ss[$i]['name'];
				$kg						= $ss[$i]['kg'];
				$handlefee				= $ss[$i]['handlefee'];
				$id						= $ss[$i]['id'];
				$rate					= $ss[$i]['rate'];
				$min					= $ss[$i]['min']; // 是否满足挂号条件
				
				echo '<br><br>'.$name.' '.$ebay_total.' '.$min.'<br><br>';
				
				
				/* 计算是否有生理区间 */
				
				
				if($name  == '香港小包挂号' ){
					$shipfee		= calchkghpost($totalweight,$ebay_countryname);
					if($ebay_total >= $min ){					
						$gg	= "insert into ebay_lishicalcfee(name,value,shippingid,orderid,totalweight) 
								values('$name','$shipfee','$id','$orderid','$totalweight')";
						echo "$name : $shipfee\n";
						$dbcon->execute($gg);
					}
				}
				/****************************************************/
				if($name  == '香港小包平邮'){
					$shipfee		= calchkpost($totalweight,$ebay_countryname);
					echo $name.':'.$shipfee."\n";
					$gg				= "insert into ebay_lishicalcfee(name,value,shippingid,orderid,totalweight) values('$name','$shipfee','$id','$orderid','$totalweight')";
					$dbcon->execute($gg);
				}
								
				if($name  == 'EUB' && ($ebay_countryname == 'United States' || $ebay_countryname == 'US')){								
					$discount	= $ss[$i]['discount']?$ss[$i]['discount']:1;
					if($totalweight <= 0.05){
						$shipfee	= 6;
					}else{
						$shipfee	= $totalweight * $handlefee;
					}
					$shipfee		= $shipfee * $discount;
					$gg				= "insert into ebay_lishicalcfee(name,value,shippingid,orderid,totalweight) 
										values('$name','$shipfee','$id','$orderid','$totalweight')";
					$dbcon->execute($gg);
					echo $name.':'.$shipfee."\n";
				}
								
				if($name  == '中国邮政平邮'){
					$dd		= "SELECT * FROM  `ebay_cppycalcfee` where countrys like '%$ebay_countryname%' ";
					$dd		= $dbcon->execute($dd);
					$dd		= $dbcon->getResultArray($dd);
					if(count($dd)>=1){
						$xx0	= $dd[0]['xx0'];
						$xx1	= $dd[0]['xx1'];
						$firstweight	= $dd[0]['firstweight'];
						$nextweight		= $dd[0]['nextweight'];
						$discount		= $dd[0]['discount']?$dd[0]['discount']:1;
						$gg	= "select * from  ebay_carrierweight where $totalweight between min and max and shipping_id = '$id'";
						$gg		= $dbcon->execute($gg);
						$gg		= $dbcon->getResultArray($gg);
						if(count($gg) >=1){
							$totalweighte	= $gg[0]['weight'];
							if($totalweighte <= ($xx0/1000)){
								$shipfee	= $firstweight;
							}else{
								$shipfee	= ceil(((($totalweighte*1000) -$xx0)/$xx1))*$nextweight + $firstweight + $handlefee;
							}
							$shipfee	=$shipfee *$discount;
							$gg		= "insert into ebay_lishicalcfee(name,value,shippingid,orderid,totalweight) 
										values('$name','$shipfee','$id','$orderid','$totalweighte')";
							$dbcon->execute($gg);
						}else{
							if($totalweight <= ($xx0/1000)){
									$shipfee	= $firstweight;
							}else{
								//$shipfee	= floor((($totalweight*1000)/100))*$nextweight + $firstweight + $handlefee;
									$shipfee	= ceil(((($totalweight*1000) -$xx0)/$xx1))*$nextweight + $firstweight + $handlefee;
							}
							$shipfee	=$shipfee *$discount;
							$gg		= "insert into ebay_lishicalcfee(name,value,shippingid,orderid,totalweight) 
										values('$name','$shipfee','$id','$orderid','$totalweight')";
							$dbcon->execute($gg);
					
						}
					}
									
					echo $name.':'.$shipfee."满足重量区间: $totalweighte  如果有重量区间，则以后面重量计算\n";
				}
				if($name  == '中国邮政挂号'){
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
							$gg	= "select * from  ebay_carrierweight where $totalweight between min and max and shipping_id = '$id'";
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
								if($ebay_total >= $min ){
										$gg	= "insert into ebay_lishicalcfee(name,value,shippingid,orderid,totalweight)				
										values('$name','$shipfee','$id','$orderid','$totalweighte')";
									$dbcon->execute($gg);
								}
							}else{
									
								if($totalweight <= ($xx0/1000)){
									$shipfee	= $firstweight + $handlefee;
								}else{
									$shipfee	= ceil(((($totalweight*1000) -$xx0)/$xx1))*$nextweight + $firstweight + $handlefee;
								}
								if($ebay_total >= $min ){
									$shipfee	=$shipfee *$discount;
									$gg		= "insert into ebay_lishicalcfee(name,value,shippingid,orderid,totalweight) values('$name','$shipfee','$id','$orderid','$totalweight')";
									$dbcon->execute($gg);
								}
							}
									
									
						}
						echo $name.':'.$shipfee." 满足重量区间: $totalweighte 如果有重量区间，则以后面重量计算\n";
				}
				if($name  == 'EMS'){
					$dd		= "SELECT * FROM  `ebay_emscalcfee` where countrys like '%$ebay_countryname%' ";
					$dd		= $dbcon->execute($dd);
					$dd		= $dbcon->getResultArray($dd);
					$firstweight	= $dd[0]['firstweight'];
					$nextweight		= $dd[0]['nextweight'];
					$handlefee		= $dd[0]['handlefee'];
					$discount		= $dd[0]['discount'];
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
					if($totalweight > 0){
						$gg	= "insert into ebay_lishicalcfee(name,value,shippingid,orderid,totalweight) values('$name','$shipfee','$id','$orderid','$totalweight')";
						$dbcon->execute($gg);
					}
					echo $name.':'.$shipfee."\n";
				}		
			}
			$ss		= "select * from ebay_carrier where ebay_account like '%$ebay_account%'";
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			$ff		= 0;
			if(count($ss) > 0){
					$ff	= 1;
			}
			if($ff == 1 && ($ebay_countryname == 'United States' ||  $ebay_countryname == 'US')){
				$ss 	= "select * from ebay_lishicalcfee where name = 'EUB' and orderid ='$orderid' ";
			}else{
				$ss 	= "select * from ebay_lishicalcfee where orderid ='$orderid' and value != '0' and name !='EUB' order by value asc ";
			}
							
			$ss		= $dbcon->execute($ss);
			$ss		= $dbcon->getResultArray($ss);
			//print_r($ss);
							
			if($ebay_total >= 40 ){
							
				$ss 	= "select * from ebay_lishicalcfee where orderid ='$orderid' and value != '0' and (name ='香港小包挂号' or name = '中国邮政挂号') order by value asc ";
				$ss		= $dbcon->execute($ss);
				$ss		= $dbcon->getResultArray($ss);
				if(count($ss) == 0){
					$ss 	= "select * from ebay_lishicalcfee where orderid ='$orderid' and value != '0'  order by value asc ";
					$ss		= $dbcon->execute($ss);
					$ss		= $dbcon->getResultArray($ss);
				}
			}
			
			
			if($isdangerous ==1){
			
			
				if($ebay_total >= 70 ){
				
				$ss 	= "select * from ebay_lishicalcfee where orderid ='$orderid' and value != '0' and name ='香港小包挂号' or name order by value asc ";
				
				}else{
				$ss 	= "select * from ebay_lishicalcfee where orderid ='$orderid' and value != '0' and name = '香港小包平邮' or name order by value asc ";
				
				
				}
				
				echo $ss;
				
				$ss		= $dbcon->execute($ss);
				$ss		= $dbcon->getResultArray($ss);
			
			}
			echo '总价格:'.$min."\n";
			//echo $ss;
			$ssname	= $ss[0]['name'];
			$value	= $ss[0]['value'];
			$totalweight	= $ss[0]['totalweight'];
			$data	= array();
			$data[0]	= $ssname;
			$data[1]	= $value;
			$data[2]	= $totalweight;
			echo " -------------------end -----------------------\n";
			return $data;
						
	}
	
	
	
?>