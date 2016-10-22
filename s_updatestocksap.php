<?

	


  
  
  die();
  
  

  date_default_timezone_set('Asia/Chongqing');
  set_time_limit(0);
  @session_start();
  
  $doc = array();

  $user = $_SESSION['user'];
  header('Content-Type:text/html;charset=utf-8');
  require ("conn_init.php");
  include "db/dbconnect0.php";	
  
  $db = new dbclass();
  $update0 = "update shipping_store set count = 0";
  $db->execute($update0);
  
  $db->__set("host,dbname","localhost:3306,".$o_db);
  $dbqueryx = "TRUNCATE TABLE `shippingstation_stock` ";
  $db->query($dbqueryx); 
  
  $count = 0;
  $query   =   "SELECT * FROM TEST"; 
  
  $conn=mssql_connect("192.168.3.11","sa","1A2B3C459s");
  $rs = mssql_query($query,$conn);
  while($row=mssql_fetch_array($rs)){
	  
	  $ItemCode		= $row['ItemCode'];
	  
	  
	  
	  
	  echo $ItemCode."<br>";
	  
	  
	  
  }
  
  

  
  $query   =   "SELECT ItemCode, convert(text,UserText) as UserText FROM SureElectronics.dbo.OITM ";
  $conn=mssql_connect("192.168.3.11","sa","1A2B3C459s");
  mssql_select_db('SureElectronics', $conn);
  $rs = mssql_query($query,$conn);
  
    $ii	= 0;
  $ss	= 0;
  $ff	= 0;
  
  
  
  while($row=mssql_fetch_array($rs)){
	  
	  $ItemCode		= $row['ItemCode'];
	  $UserText		= $row['UserText'];
	  $ss			= "SELECT OnHand FROM SureElectronics.dbo.OITW WHERE ItemCode = '$ItemCode' and WhsCode = 'FW01' ";
	  
	  $str0			=  strpos($UserText,'<<-');
	  $str1			=  strpos($UserText,'->>');
	  
	  $location		= substr($UserText,$str0,$str1);
	  $location		= explode('&',$location);
	  @$location		= $location[1];
	  
	  $ss	    = mssql_query($ss,$conn);
	  if($ss=mssql_fetch_array($ss)){
			$OnHand		= ceil($ss['OnHand']);
	  }else{

			$OnHand		= 0;
	  }
	  
	  
	  
	    $dbquery = "insert into shippingstation_stock (count,sn)values(".floor($rs->realqty).",'".$rs->code."')";
		  if($db->execute($dbquery)){
			
			echo "本地产品编号: ".$rs->code."  数量: ".$rs->realqty."   库存同步成功<br>";
			$ss++;
		  }else{
			
			$ff++;
			
			echo "本地产品编号: ".$rs->code."  数量: ".$rs->realqty."   库存同步失败<br>";
		  }
  
  			$sql = "select hpmc,weight from ebay_products where hpbh = '$rs->code'";
			$sql = $db->query($sql);
			$rs1 = $db->fetch_object($sql);
			@$name = $rs1->hpmc;
			$goodssn = $rs->code;		
			$doc[$ii]['goodsn']	= $goodssn;
			$doc[$ii]['qty']	= $rs->realqty;
			$doc[$ii]['name']	= sql_str($name);
			$doc[$ii]['weight']	= $rs1->weight?$rs1->weight:0;
			$doc[$ii]['location']	= $rs->guserdef4;



			$ii++;	
 			$count = $count +1;
			
			
			
  }
  



  echo "成功数量为:".$ss."  失败数量为:".$ff;
  

print_r($doc);


	die();
	
  echo "---------------------------------------------------------开始更新库存物料---------------------------------------------------------------------------------------";
  $db->close();
  $db->__set("host,dbname",$s_host.",".$s_db);
			
 
  for($aa=0;$aa<count($doc);$aa++){
  	
	$goodssn	= $doc[$aa]['goodsn'];
	$goodsname	= $doc[$aa]['name'];
	$qty		= $doc[$aa]['qty'];
	$weight		= $doc[$aa]['weight'];
	$location		= $doc[$aa]['location'];

	$s			= "select * from shipping_store where sn='$goodssn'";	
	$s			= $db->query($s);
	$s			= $db->getResultArray($s);
	
	
	if(count($s)>0){
		
		$ins		= "update shipping_store set count = '$qty',weight=$weight,location='$location' where sn = '$goodssn'";
		
	}else{
		
		$ins 		= "insert into shipping_store(sn,name,count,weight,location) value('".$goodssn."','".$goodsname."','".$qty."',$weight,'$location')";
	}
	
	if($db->execute($ins)){
		
		echo "产品编号:$goodssn   数量: $qty   location: $location 库存同步成功<br>";
	}else{
		echo $ins;
		echo "<font color=\"red\">$goodssn 库存同步失败</font><br>";
	}
	if($weight == 0){
		
		echo "<font color=red>重量为0 可能没有添加编号.</font><br><br>";
	}

  	
  }

   $db->__set("host,dbname","localhost:3306,".$o_db);
  $content =  "用户$user 做了发货工作站库存更新，更新时间为。$date";
  $sql = "insert into ebay_note(content,user) values('$content','$user')";
  @$db->query($sql);
  echo "同步库存成功，已同步库存种类数量".$count;
$db->close();
?>