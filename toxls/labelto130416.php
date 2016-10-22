<?php
@session_start();
error_reporting(0);

$user	= $_SESSION['user'];
include "../include/dbconnect.php";	
date_default_timezone_set ("Asia/Chongqing");	
$dbcon	= new DBClass();
	function escapeCSV($str){
	  $str = str_replace(array(',','"',"\n\r"),array('','""',''),$str);
	  if($str == ""){
		$str = '""';
	  }
	  return $str;
	}
	
	function iconvstr($str){
		return iconv('utf-8','gb2312',escapeCSV($str));
	}
	

	
	$ertj		= "";
	$orders		= explode(",",$_REQUEST['ordersn']);
	for($g=0;$g<count($orders);$g++){
		$sn 	=  $orders[$g];
		if($sn != ""){
				
					$ertj	.= " a.ebay_id='$sn' or";
		}
			
	}
	$ertj			 = substr($ertj,0,strlen($ertj)-3);
	
	
	if($ertj == ""){
	$sql	= "select * from ebay_order as a where ebay_user='$user' and a.ebay_status='1' and a.ebay_combine!='1' ";	
	}else{	
	$sql	= "select a.*,b.ebay_amount from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn = b.ebay_ordersn where ($ertj) and a.ebay_user='$user' and a.ebay_combine!='1' group by a.ebay_id order by   b.sku desc , b.ebay_amount desc ";	
	}

	

	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);
	$a		= 2;
	
	$dataforcsv  = array();
	$ii = 1;
	
	
	for($i=0;$i<count($sql);$i++){
		
		$ordersn				= $sql[$i]['ebay_ordersn'];	
		$paidtime				= date('Y-m-d',$sql[$i]['ebay_paidtime']);
		
		
		
		
		
		
		$ebay_ptid				= $sql[$i]['ebay_ptid'];
		
		$orderid				= $sql[$i]['ebay_id'];
		$ebay_usermail			= $sql[$i]['ebay_usermail'];
		$ebay_userid			= $sql[$i]['ebay_userid'];	
		
		$name					= escapeCSV($sql[$i]['ebay_username']);
	    $street1				= escapeCSV(@$sql[$i]['ebay_street']);
	    $street2 				= escapeCSV(@$sql[$i]['ebay_street1']);
	    $city 					= escapeCSV($sql[$i]['ebay_city']);
	    $state					= escapeCSV($sql[$i]['ebay_state']);
	    $countryname 			= escapeCSV($sql[$i]['ebay_countryname']);
		$cncountryname			= $country[$countryname];
	    $zip					= escapeCSV($sql[$i]['ebay_postcode']);
	    $tel					= escapeCSV($sql[$i]['ebay_phone']);
		$ebay_shipfee			= $sql[$i]['ebay_shipfee'];
		$ebay_total				= @$sql[$i]['ebay_total'];
		$ebay_tracknumber		= @$sql[$i]['ebay_tracknumber'];
		$ebay_currency			= $sql[$i]['ebay_currency'];
		$ebay_account			= @$sql[$i]['ebay_account'];
		$recordnumber0			= @$sql[$i]['recordnumber'];
		$ebay_carrier			= @$sql[$i]['ebay_carrier'];
		$ebay_paidtime			= $sql[$i]['ebay_paidtime']?date('Y-m-d',$sql[$i]['ebay_paidtime']):'';
		if($ebay_currency=='USD'){
			$ebay_currency = '$';
		}

		$addressline	= $name.chr(13).$street1;
		if($street2 != ''){
			
				$addressline .= " ".$street2;
		}
		
		$addressline	.= chr(13);

		if($city != ''){
			
				$addressline .= $city;
		}
		if($state != ''){
			
				$addressline .= ", ".$state;
		}
		if($zip != ''){
			
				$addressline .= ", ".$zip;
		}
		$addressline .= chr(13).$countryname.'('.$cncountryname.')';
	
		if($tel && $tel !='Invalid Request') $addressline .= chr(13).'Tel:'.$tel;
		


			$labelstr = '';
		
		
		$sl				= "select * from ebay_orderdetail where ebay_ordersn='$ordersn'";
		$sl				= $dbcon->execute($sl);
		$sl				= $dbcon->getResultArray($sl);
		for($o=0;$o<count($sl);$o++){	
			$recordnumber			= $sl[$o]['recordnumber'];
			$sku					= $sl[$o]['sku'];
			$amount					= $sl[$o]['ebay_amount'];
			$ebay_itemprice			= $sl[$o]['ebay_itemprice'];	
			$ebay_itemid			= $sl[$o]['ebay_itemid'];
			$shipfee				= $sl[$o]['shipingfee'];
			$ebay_itemtitle			= escapeCSV($sl[$o]['ebay_itemtitle']);
			$vvv = "select goods_weight from ebay_goods where goods_sn='$sku' and ebay_user='$user'";
			$vvv = $dbcon->execute($vvv);
			$vvv = $dbcon->getResultArray($vvv);
			
			
			
			
		
			$goods_weight = 0;
			
			
		
			
			

			if(count($vvv)>0){
				
				$labelstr .= $sku.'('.$amount.')';
				
									$ebay_packingmaterial	= $vvv[0]['ebay_packingmaterial'];
									$kk			= " select * from ebay_packingmaterial where model ='$ebay_packingmaterial' and ebay_user='$user' ";
									$kk			= $dbcon->execute($kk);
									$kk 	 	= $dbcon->getResultArray($kk);
									$model		= $kk[0]['model'];	
									$goods_weight = $vvv[0]['goods_weight']*$amount;
				
				
			}else{
				$ssr	= "select goods_sncombine,ebay_packingmaterial  from ebay_productscombine where ebay_user='$user' and goods_sn='$sku'";
				
				$ssr 	= $dbcon->execute($ssr);
				$ssr	= $dbcon->getResultArray($ssr);
				$goods_sncombine	= $ssr[0]['goods_sncombine'];
				$model				= $ssr[0]['ebay_packingmaterial'];	
				
				$goods_sncombine    = explode(',',$goods_sncombine);
				$goods_weight = 0;
				
				
				
				for($e=0;$e<count($goods_sncombine);$e++){
					$pline			= explode('*',$goods_sncombine[$e]);
					$goods_sn		= $pline[0];
					
					$goddscount     = $pline[1] * $amount;
					$ee			= "SELECT goods_weight FROM ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";

					
					$ee			= $dbcon->execute($ee);
					$ee 	 	= $dbcon->getResultArray($ee);
					$sweight = $ee[0]['goods_weight']*$goddscount;
					$goods_weight		+= $goods_weight + $sweight;
					$labelstr .= $goods_sn.'('.$goddscount.')';
					
				}
			}
			
			
			
	
			

		
		}


					$linearray				= array($recordnumber,$ebay_userid,$name,$tel,$ebay_usermail,$street1,$street2,$city,$state,$zip,$countryname,$ebay_itemid,$ebay_itemtitle,$sku,$amount,$ebay_paidtime,'',$ebay_ptid,$orderid,$ebay_carrier,$goods_weight,$model,$labelstr);
			$dataforcsv[$ii]  		= $linearray;
			$ii++;
			
			
	
	

}
	


	
$filename = date('YmdHis').'.csv';
$data = "\"Sales Record Number\",User Id,Buyer Fullname,Buyer Phone Number,Buyer Email,Buyer Address 1,Buyer Address 2,Buyer Town/City,Buyer State,Buyer Postcode,Buyer Country,Item Number,Item Title,Custom Label,Quantity,Paid on Date,Notes to yourself,PayPal Transaction ID,Selling360 Number,Shipping Method,Total Weight,Package Material,Contents"."\n";
foreach($dataforcsv as $r) {
	
	
	$data .= $r[0].','.iconvstr($r[1]).','.iconvstr($r[2]).','.$r[3].','.$r[4].','.$r[5].','.$r[6].','.$r[7].','.$r[8].','.$r[9].','.$r[10].','.$r[11].','.$r[12].','.$r[13].','.$r[14].','.$r[15].','.$r[16].','.$r[17].','.$r[18].','.$r[19].','.$r[20].','.$r[21].','.$r[22].','.$r[23]."\n";
}



header("Content-type: text/csv");
header ("Content-Disposition: attachment; filename=" . $filename);
header('Cache-Control:   must-revalidate,   post-check=0,   pre-check=0');
header('Expires:   0');
header('Pragma:   public');
echo $data;




?>
