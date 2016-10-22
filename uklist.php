<?php
	@session_start();
	header('Content-Type:text/html;charset=utf-8');
	$user	= $_SESSION['user'];	
	include "include/dbconnect.php";	
	$dbcon	= new DBClass();
	
	function strstring($str,$strlen){
	
	
		$returnstring	= '';
		
		if(strlen($str) == $strlen){
			
			$returnstring	= $str;
					
		}
		
		if(strlen($str) >$strlen){
			
			$returnstring	= substr($str,0,$strlen);
					
		}
		
		if(strlen($str) < $strlen){
		
			$addspace		= $strlen - strlen($str);
			
			for($i=0;$i<$addspace;$i++){
				
				
				$str	.= " ";
				
			
			}
			$returnstring	= $str;
		
		}
		
		return $returnstring;
		
	}
	
	
	$filename = date('Y-m-d H:i:s').".txt";
	if(file_exists($filename)){
		unlink($filename); //ɾļ
	}
	$handle = fopen($filename,"a");
	
	$sql	= "select * from ebay_order where ebay_status='0' and ebay_user='$user' and ebay_site='UK'";
	
	
	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);
	
	for($i=0;$i<count($sql);$i++){
	
			$ebayaccount	= $sql[$i]['ebay_account'];
			$recordnumber	= $sql[$i]['recordnumber'];
			$ebay_usermail	= $sql[$i]['ebay_usermail'];
			$userid			= $sql[$i]['ebay_userid'];
			$name			= $sql[$i]['ebay_username'];
			$street1		= @$sql[$i]['ebay_street'];
			$street2 		= @$sql[$i]['ebay_street1'];
			$city 			= $sql[$i]['ebay_city'];
			$state			= $sql[$i]['ebay_state'];
			$countryname 	= $sql[$i]['ebay_countryname'];
			$postcode		= $sql[$i]['ebay_postcode'];
			$ordersn		= $sql[$i]['ebay_ordersn'];
			$telephone		= $sql[$i]['ebay_phone'];
			$service		= $sql[$i]['ebay_carrier'];
			
				$sq		= "select * from ebay_orderdetail where ebay_ordersn='$ordersn'";

				$sq		= $dbcon->execute($sq);
				$sq		= $dbcon->getResultArray($sq);
				$quantity	= 0;
				$sku		= "";
				
				for($t=0;$t<count($sq);$t++){
				
					$itemtitle		= $sq[$t]['sku'];
					$quantity		= $sq[$t]['ebay_amount'];
					
					$cust_order_ref		= $ebayaccount.$recordnumber;
					
					$cust_order_ref	 	= strstring($cust_order_ref,50);
					$addr_code			= strstring($addr_code,50);
					$invoicename		= strstring($name,50);
					$inv_addr1			= strstring($street1,50);
					$inv_addr2			= strstring($street2,50);
					$inv_addr3			= strstring($city,50);
					$inv_addr4			= strstring($state,50);
					$inv_addr5			= strstring($countryname,50);
					$postcode			= strstring($postcode,20);					
					$contact			= strstring($name,50);					
					$inv_addr1			= strstring($street1,50);
					$inv_addr2			= strstring($street2,50);
					$inv_addr3			= strstring($city,50);
					$inv_addr4			= strstring($state,50);
					$inv_addr5			= strstring($countryname,50);
					$postcode			= strstring($postcode,50);					
					$telephone			= strstring($telephone,20);					
					$customer_ref		= strstring($customer_ref,100);
					$service			= strstring($service,3);
					$gift_type			= strstring($gift_type,3);
					$gift_message		= strstring($gift_message,350);
					$product_code		= strstring($itemtitle,50);
					$quantity			= strstring($quantity,8);
					$order_due_date		= strstring('',8);
					$gift_card_type		= strstring('',3);
					$line_price			= strstring('',8);
					$sub_total			= strstring('',8);
					$vat_deducted		= strstring('',8);
					$discount			= strstring('',8);
					$total				= strstring($quantity,8);
					$postage_amount		= strstring($postage_amount,8);
					$type				= strstring('001',3);
					$wsql				= "select * from ebay_goods where goods_sn='$itemtitle'";
					$wsql				= $dbcon->execute($wsql);
					$wsql				= $dbcon->getResultArray($wsql);
					$postage_weight		= $wsql[0]['goods_weight']?$wsql[0]['goods_weight']:'0';
					
					
					
					$postage_weight		= strstring($postage_weight,10);
					
					$linestr			= $cust_order_ref.$addr_code.$invoicename.$inv_addr1.$inv_addr2.$inv_addr3.$inv_addr4.$inv_addr5.$postcode.$contact;
					$linestr		   .= $inv_addr1.$inv_addr2.$inv_addr3.$inv_addr4.$inv_addr5.$postcode.$telephone.$customer_ref.$service.$gift_type;
					$linestr		   .= $gift_message.$product_code.$quantity.$order_due_date.$gift_card_type.$line_price.$sub_total.$vat_deducted.$discount.$total.$postage_amount.$type.$postage_weight."\r\n";
					fwrite($handle,$linestr);
					
				}
				
				
			
			
			
	
	
	
	
	
	
	
	}
	
	
	$file   =   fopen($filename,"rb");
    Header("Content-type:   application/octet-stream");
    Header("Accept-Ranges:   bytes");
    Header("Accept-Length:   ".   filesize($filename));
    Header("Content-Disposition:   attachment;   filename="   .   basename($filename));
	echo   fread($file,filesize($filename));   
	 fclose($file);   
      exit;   
	







?>