<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php
	
	
	include "include/config.php";
	
	
	
	$account				= $_POST['account'];
	$orderstatus			= $_POST['orderstatus'];

	function CheckID($ebay_ordersn,$account,$ebay_userid){
		global $dbcon;		
		$sql		= "select * from ebay_order where ebay_ordersn='$ebay_ordersn' and ebay_account='$account' and ebay_userid='$ebay_userid'";
		$sql  = $dbcon->execute($sql);
		$sql  = $dbcon->getResultArray($sql);
		if(count($sql) == 0){
		$status			= "0";
		}else{
		$status 		= $sql[0]['ebay_ordersn'];
		}
		
		
		return $status;
	}
	



	
	$uploadfile = date("Y").date("m").date("d").rand(1,3009).".csv";
	

	

	if (move_uploaded_file($_FILES['upfile']['tmp_name'], 'images/'.$uploadfile)) {
	
		echo "<font color=BLUE>文件上传成功！</font><br>";
	
	}else {
   		
		echo "<font color=red> 文件上传失败！</font>  <a href='index.php'>返回</a><br>"; 	
	}
	echo $uploadfile;
	
	
	$fileName = 'images/'.$uploadfile;	
	$filePath = $fileName;




$opts = array('file' => array('encoding' => 'utf-8')); 
$ctxt = stream_context_create($opts);
$file = fopen($filePath,'r',false,$ctxt); 
while ($data = fgetcsv($file)){
$goods_list[] = $data;
}
fclose($file);
//echo "<pre>";

$goods_list = eval('return '.iconv('gbk','utf-8',var_export($goods_list,true)).';');
//print_r($goods_list);
for($i=1;$i<count($goods_list);$i++){
	
	$ebay_ordersn	 			= substr($goods_list[$i][0],1); //订单号
	
	if($ebay_ordersn != ''){
	
	$recordnumber				= $ebay_ordersn;
	$ebay_ordersn				=$user.$ebay_ordersn;
	$ebay_userid				= $goods_list[$i][1]; //买家名称
	$ebay_username				= $goods_list[$i][12]; //买家名称
	$ebay_createdtime			= $goods_list[$i][17]; // 下单时间
	$ebay_paidtime				= $goods_list[$i][18]; // 付款时间
	$ebay_paidtime					= strtotime($ebay_paidtime);
	$ebay_createdtime				= strtotime($ebay_createdtime);
	
	
	$ebay_itemprice				= $goods_list[$i][3];   //产品总金额
	$ebay_shipfee				= $goods_list[$i][4];   // 物流费用
	$ebay_total					= $goods_list[$i][6];   //订单金额


	$ebay_note					= $goods_list[$i][11];	//订单备注
	$ebay_noteb					= str_replace("'",'',$goods_list[$i][23]);	//订单备注
	$ebay_tracknumber			= substr($goods_list[$i][21],3);	//订单备注
	$ebay_countryname			= '中国';
	$ebay_state					= '';
	$ebay_city					= '';
	$ebay_street				= $goods_list[$i][13];
	$ebay_postcode				= '';
	$ebay_phone					= $goods_list[$i][16];
	if($ebay_phone){
		$ebay_phone					= substr($ebay_phone,1);
	}
	$ebay_carrier				= $goods_list[$i][22];   //买家选择物流
	$sku						= $goods_list[$i][45];
	$title				= $goods_list[$i][37];
	$amount		= $goods_list[$i][39];
	$vv			= CheckID($ebay_ordersn,$account,$ebay_userid);
	
	
	echo $ebay_ordersn.' 添加状态：  ';
	
	
	
	if($vv == '0'){
		
		
		$sql					= "insert into  ebay_order(ebay_ordersn,recordnumber,ebay_createdtime,ebay_paidtime,ebay_userid,ebay_username,ebay_street,ebay_street1,ebay_city,ebay_state,ebay_countryname,ebay_postcode,ebay_phone,ebay_total,ebay_status,ebay_user,ebay_addtime,ebay_shipfee,ebay_account,ebay_note,ebay_carrier,ebay_warehouse,ebay_currency,ebay_noteb) values('$ebay_ordersn','$recordnumber','$ebay_createdtime','$ebay_paidtime','$ebay_userid','$ebay_username','$ebay_street','$ebay_street1','$ebay_city','$ebay_state','$ebay_countryname','$ebay_postcode','$ebay_phone','$ebay_total','$orderstatus','$user','$mctime','$ebay_shipfee','$account','$ebay_note','$ebay_carrier','$defaultstoreid','RMB','$ebay_noteb')";
	

		//echo $sql.'<br>';
		
		if($dbcon->execute($sql)){
						echo " 添加成功: UserID:$ebay_userid  <br>";
						$sql = "select * from ebay_orderdetail where ebay_ordersn='$ebay_ordersn' and sku='$sku'";
		$sql = $dbcon->query($sql);
		$sql	 = $dbcon->num_rows($sql);

		if($sql == 0){
			
			
			
				$ss				= "SELECT * FROM  `ebay_goods` where ebay_user='$user' and goods_sn='$sku'";
				$ss				= $dbcon->execute($ss);
				$ss				= $dbcon->getResultArray($ss);
				$goods_location		= $ss[0]['goods_location'];
				
				$esql	 = "INSERT INTO `ebay_orderdetail` (`ebay_ordersn` ,`ebay_itemtitle` ,`ebay_itemprice` ,";
				$esql    .= "`ebay_amount` ,`ebay_user`,`sku`,`shipingfee`,`ebay_account`,`addtime`,`recordnumber`,`goods_location`)VALUES ('$ebay_ordersn', '$title' , '$ebay_itemprice' , '$amount'";

				$esql	.= " ,'$user','$sku','$shipingfee','$account','$mctime','$recordnumber','$goods_location')";	
			//	echo $esql.'<br>';
			if($dbcon->execute($esql)){				
				echo "$sku 添加成功"."<br>";			
			}else{
				echo '<font color=red>添加失败</font>';
				
				
				echo $esql;
				
			}
		
		}
		
		}

		
	
	
		
		
		
		
	}else{
		
		
		
		$sql     = "select * from ebay_orderdetail where ebay_ordersn='$vv' and sku='$sku'";
		
		$sql     = $dbcon->query($sql);
		$sql	 = $dbcon->num_rows($sql);

		if($sql == 0){			

		
		/* 开始添加产品数据 */
			
			
			
				$ss				= "SELECT * FROM  `ebay_goods` where ebay_user='$user' and goods_sn='$sku'";
				$ss				= $dbcon->execute($ss);
				$ss				= $dbcon->getResultArray($ss);
				$goods_location		= $ss[0]['goods_location'];
				
				$recordnumber = $recordnumber.$i;
				$esql	 = "INSERT INTO `ebay_orderdetail` (`ebay_ordersn` ,`ebay_itemtitle` ,`ebay_itemprice` ,";
				$esql    .= "`ebay_amount` ,`ebay_user`,`sku`,`shipingfee`,`ebay_account`,`addtime`,`recordnumber`,`goods_location`)VALUES ('$ebay_ordersn', '$title' , '$ebay_itemprice' , '$amount'";

				$esql	.= " ,'$user','$sku','$shipingfee','$account','$mctime','$recordnumber','$goods_location')";	
			if($dbcon->execute($esql)){				
				echo "$sku 添加成功"."<br>";			
			}else{
				echo '<font color=red>添加失败</font>';
			}
		
		}
		

	
	}
	
	}else{
		break;
	}
	

}

?>

<script language="javascript">
	
	alert('订单导入完成');



</script>





