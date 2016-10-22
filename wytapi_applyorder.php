<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EUB</title>
</head>

<body>

<?PHP

	include "include/config.php";

error_reporting(E_ALL);


	function apiCall($requestXml){
	//API 请求地址
	//test:http://202.170.134.64:9936/ADInterface/services/ModelADService
	//live:http://210.75.6.134:9936/ADInterface/services/ModelADService
	$requestUrl = "http://210.75.6.134:9936/ADInterface/services/ModelADService";
	//$requestUrl = "http://192.168.130.2:8081/ADInterface/services/ModelADService";
	$requestHeader = array ('Content-Type: text/xml;charset=utf-8');
	// init curl
	$connection = curl_init();

	//setting for curl send to Adempire Web Service
	curl_setopt($connection, CURLOPT_URL, $requestUrl);
	curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($connection, CURLOPT_HTTPHEADER, $requestHeader);
	curl_setopt($connection, CURLOPT_POST, 1);
	curl_setopt($connection, CURLOPT_POSTFIELDS, $requestXml);
	curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);

	// run it
	$response = curl_exec($connection); //此处返回结果数据，格式为XML

	// close curl connection
	curl_close($connection);




	$xml = simplexml_load_string($response);
	$req = $xml->children("http://schemas.xmlsoap.org/soap/envelope/")->children("http://3e.pl/ADInterface")->children("")->StandardResponse;
	if($req->Error){
		print_r($req->Error);
		print_r($requestXml);
		exit;
	}else{
		return $req;
	}
}


	



	$type = $_REQUEST['type'];



	

	if($type == 'create'){

	$label	= '';
	$orders		= explode(",",$_REQUEST['bill']);
	
	$tkary		= array();
	$i = 0;
	


	$strGetLabelURL = "https://labelserver.endicia.com/LabelService/EwsLabelService.asmx/GetPostageLabelXML";



	for($g=0;$g<count($orders);$g++){
		$sn 	=  $orders[$g];
		if($sn != ""){
			
			$sql	= "select * from ebay_order as a where ebay_id='$sn' ";			
			$sql	= $dbcon->execute($sql);
			$sql	= $dbcon->getResultArray($sql);
			$ebay_id				= $sql[0]['ebay_id'];
			$ebay_ordersn			= $sql[0]['ebay_ordersn'];
			$ebay_carrier			= $sql[0]['ebay_carrier'];
			$ebay_warehouse			= $sql[0]['ebay_warehouse'];
			$recordnumber			= $sql[0]['recordnumber'];
			/*  取得发货方式代码和服务保险代码 */
			$vv	= "select * from ebay_carrier  where ebay_user='$user' and name='$ebay_carrier' ";			
			$vv	= $dbcon->execute($vv);
			$vv	= $dbcon->getResultArray($vv);
			$wyt_insurce	= $vv[0]['wyt_insurce'];
			$wyt_code		= $vv[0]['wyt_code'];
			
			if($ebay_carrier =='') {
				echo '订单编号:'.$ebay_id.'订单对应的万邑通发货方式名称不能为空<br>';
			}
			
			


			if($wyt_insurce =='') {
				echo '订单编号:'.$ebay_id.'订单对应的万邑通服务保险代码不能为空<br>';
			}
			
			if($wyt_code =='') {
				echo '订单编号:'.$ebay_id.'订单对应的万邑通发货方式代码不能为空<br>';
			}
			
			
			/*  取得对应仓库代码 */
			$vv				= "select * from ebay_store  where ebay_user='$user' and id='$ebay_warehouse' ";	
			
	
			$vv				= $dbcon->execute($vv);
			$vv				= $dbcon->getResultArray($vv);
			$store_sn		= $vv[0]['store_sn'];
			
			if($store_sn =='') {
				echo '订单编号:'.$ebay_id.'订单对应万邑通仓库代码不能为空';
			}
			
			$ebay_orderid			= $sql[0]['ebay_orderid'];
			$ebay_username			= $sql[0]['ebay_username'];
			$ToAddress1				= $sql[0]['ebay_street'];
			$ToAddress2				= $sql[0]['ebay_street1'];
			$ebay_state				= $sql[0]['ebay_state'];
			$ebay_postcode			= $sql[0]['ebay_postcode'];
			$ebay_phone				= $sql[0]['ebay_phone'];
			$ebay_city				= $sql[0]['ebay_city'];
			$ebay_usermail			= $sql[0]['ebay_usermail'];
			$ebay_countryname		= $sql[0]['ebay_countryname'];
						$recordnumber			= $sql[0]['recordnumber'];

			

				//创建出库单
$outXml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:adin="http://3e.pl/ADInterface">
   <soapenv:Header/>
   <soapenv:Body>
      <adin:createData>
         <adin:ModelCRUDRequest>
            <adin:ModelCRUD>
               <adin:serviceType>create:WT_ExWarehouse</adin:serviceType>
               <adin:RecordID>0</adin:RecordID>
               <adin:Action>Create</adin:Action>
               <!--Optional:-->
               <adin:DataRow>
                  <!--Zero or more repetitions:-->
                  <adin:field column="M_Warehouse_ID" >
                     <adin:val>'.$store_sn.'</adin:val>
                  </adin:field>
                    <adin:field column="EBayOrderID" >
                     <adin:val>'.$recordnumber.'</adin:val>
                  </adin:field>
				  <adin:field column="SellerOrderNo" >
                     <adin:val>'.$ebay_id.'</adin:val>
                  </adin:field>
                  <adin:field column="IsRepeat" >
                     <adin:val>N</adin:val>
                  </adin:field>
                  <adin:field column="WT_Warehouse_DeliveryWay_ID" >
                     <adin:val>'.$wyt_code.'</adin:val>
                  </adin:field>
                  <adin:field column="WT_Delivery_InsuranceType_ID" >
                     <adin:val>'.$wyt_insurce.'</adin:val>
                  </adin:field>
               </adin:DataRow>
            </adin:ModelCRUD>
            <adin:ADLoginRequest>
               <adin:user>'.$wytuser.'</adin:user>
               <adin:pass>'.$wytuserpass.'</adin:pass>
               <adin:lang>zh_CN</adin:lang>
               <adin:ClientID>11</adin:ClientID>
               <adin:RoleID>1000074</adin:RoleID>
               <adin:OrgID>1000000</adin:OrgID>
               <adin:WarehouseID>1000005</adin:WarehouseID>
               <adin:stage>0</adin:stage>
            </adin:ADLoginRequest>
         </adin:ModelCRUDRequest>
      </adin:queryData>
   </soapenv:Body>
</soapenv:Envelope>';

echo $outXml;

$outReturn = apiCall($outXml);


print_r($outReturn);





//更新出库单发货信息
$updateOutXml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:adin="http://3e.pl/ADInterface">
   <soapenv:Header/>
   <soapenv:Body>
      <adin:updateData>
         <adin:ModelCRUDRequest>
            <adin:ModelCRUD>
               <adin:serviceType>update:WT_ExWarehouse</adin:serviceType>
               <adin:TableName>WT_ExWarehouse</adin:TableName>
               <adin:RecordID>'.$outReturn['RecordID'].'</adin:RecordID>
               <adin:Filter/>
               <adin:Action>Update</adin:Action>
               <!--Optional:-->
               <adin:DataRow>
                  <!--Zero or more repetitions:-->
                  <adin:field column="Name" >
                     <adin:val>'.$ebay_username.'</adin:val>
                  </adin:field>
                  <adin:field column="Phone" >
                     <adin:val>'.$ebay_phone.'</adin:val>
                  </adin:field>
                  <adin:field column="Postal" >
                     <adin:val>'.$ebay_postcode.'</adin:val>
                  </adin:field>
                  <adin:field column="EMail" >
                     <adin:val>'.$ebay_usermail.'</adin:val>
                  </adin:field>
                  <adin:field column="CountryName" >
                     <adin:val>'.$ebay_countryname.'</adin:val>
                  </adin:field>
                  <adin:field column="RegionName" >
                     <adin:val>'.$ebay_state.'</adin:val>
                  </adin:field>
                  <adin:field column="Address1" >
                     <adin:val>'.$ToAddress1.'</adin:val>
                  </adin:field>
                  <adin:field column="Address2" >
                     <adin:val>'.$ToAddress2.'</adin:val>
                  </adin:field>
                  <adin:field column="Status" >
                     <adin:val>DR</adin:val>
                  </adin:field>
			      <adin:field column="City" >
                     <adin:val>'.$ebay_city.'</adin:val>
                  </adin:field>
               </adin:DataRow>
            </adin:ModelCRUD>
            <adin:ADLoginRequest>
             <adin:user>'.$wytuser.'</adin:user>
               <adin:pass>'.$wytuserpass.'</adin:pass>
               <adin:lang>zh_CN</adin:lang>
               <adin:ClientID>11</adin:ClientID>
               <adin:RoleID>1000074</adin:RoleID>
               <adin:OrgID>1000000</adin:OrgID>
               <adin:WarehouseID>1000005</adin:WarehouseID>
               <adin:stage>0</adin:stage>
            </adin:ADLoginRequest>
         </adin:ModelCRUDRequest>
      </adin:queryData>
   </soapenv:Body>
</soapenv:Envelope>';
$addOutProducReturn = apiCall($updateOutXml);


echo $outReturn['RecordID'].'cc';



			$sql	= "select sku,ebay_amount,ebay_itemid,ebay_tid from ebay_orderdetail as a where a.ebay_ordersn='$ebay_ordersn' ";
			$sql	= $dbcon->execute($sql);
			$sql	= $dbcon->getResultArray($sql);

			$linestr	= '';
			$weight		= 0;
			for($j=0;$j<count($sql);$j++){
				
				$sku				= $sql[$j]['sku'];
				$ebay_amount		= $sql[$j]['ebay_amount'];
				
				$ebay_itemid				= $sql[$j]['ebay_itemid'];
				
				$ebay_tid				= $sql[$j]['ebay_tid'];
				
				$linestr			= $sku.' * '.$ebay_amount.', ';


				$si		= "select * from ebay_goods where ebay_user = '$user' and goods_sn='$sku'";
				$si			= $dbcon->execute($si);
				$si			= $dbcon->getResultArray($si);		
				$weight		= $si[0]['goods_weight']?$si[0]['goods_weight']:0.1;
				$weight		+= $weight * $ebay_amount;




				//添加出库产品
$addOutProductXml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:adin="http://3e.pl/ADInterface">
    <soapenv:Header/>
    <soapenv:Body>
       <adin:createData>
          <adin:ModelCRUDRequest>
             <adin:ModelCRUD>
                <adin:serviceType>create:WT_ExWarehouseProduct</adin:serviceType>
                <adin:TableName>WT_ExWarehouseProduct</adin:TableName>
                <adin:RecordID>0</adin:RecordID>
                <adin:Action>Create</adin:Action>
                <adin:DataRow>
				<adin:field column="WT_ExWarehouse_ID"><adin:val>'.$outReturn['RecordID'].'</adin:val></adin:field>           
				<adin:field column="EBayTransactionID" >
				<adin:val>'.$ebay_tid.'</adin:val></adin:field>
                <adin:field column="EBayItemID" ><adin:val>'.$ebay_itemid.'</adin:val></adin:field>           
            	<adin:field column="Value"><adin:val>'.$sku.'</adin:val></adin:field>
				<adin:field column="Specification"><adin:val></adin:val></adin:field>
				<adin:field column="Qty"><adin:val>'.$ebay_amount.'</adin:val></adin:field>
                </adin:DataRow>
             </adin:ModelCRUD>
             <adin:ADLoginRequest>
      	 <adin:user>'.$wytuser.'</adin:user>
               <adin:pass>'.$wytuserpass.'</adin:pass>
             <adin:lang>zh_CN</adin:lang>
             <adin:ClientID>11</adin:ClientID>
             <adin:RoleID>1000074</adin:RoleID>
             <adin:OrgID>1000000</adin:OrgID>
             <adin:WarehouseID>1000005</adin:WarehouseID>
             <adin:stage>0</adin:stage>
             </adin:ADLoginRequest>
          </adin:ModelCRUDRequest>
       </adin:createData>
    </soapenv:Body>
</soapenv:Envelope>';

$addOutProducReturn = apiCall($addOutProductXml);



print_r($addOutProducReturn);




			}





			//修改出库单状态（确认发货/作废出库单）
			$outConfirmXml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:adin="http://3e.pl/ADInterface">
			   <soapenv:Header/>
			   <soapenv:Body>
				  <adin:updateData>
					 <adin:ModelCRUDRequest>
						<adin:ModelCRUD>
						   <adin:serviceType>update:WT_ExWarehouse</adin:serviceType>
						   <adin:TableName>WT_ExWarehouse</adin:TableName>
							<!--创建出库单后获取的出库单ID-->
						   <adin:RecordID>'.$outReturn['RecordID'].'</adin:RecordID>
						   <adin:Action>Update</adin:Action>
						   <adin:DataRow>
							  <adin:field column="Status" >
								 <adin:val>CFI</adin:val>
							  </adin:field>
						   </adin:DataRow>
						</adin:ModelCRUD>
						<adin:ADLoginRequest>
						  <adin:user>'.$wytuser.'</adin:user>
               <adin:pass>'.$wytuserpass.'</adin:pass>
						   <adin:lang>zh_CN</adin:lang>
						   <adin:ClientID>11</adin:ClientID>
						   <adin:RoleID>1000074</adin:RoleID>
						   <adin:OrgID>1000000</adin:OrgID>
						   <adin:WarehouseID>1000005</adin:WarehouseID>
						   <adin:stage>0</adin:stage>
						</adin:ADLoginRequest>
					 </adin:ModelCRUDRequest>
				  </adin:queryData>
			   </soapenv:Body>
			</soapenv:Envelope>';
			//exit;
			$outConfirmReturn = apiCall($outConfirmXml);

			if($outConfirmReturn['RecordID'] != ''){
				echo '<br> 订单编号: '.$sn.' 提交确认成功';				
				$upsql = "update ebay_order set pxorderid='".$outConfirmReturn['RecordID']."' where ebay_ordersn='".$ebay_ordersn."' and ebay_user = '$user' ";
				

				
				$dbcon->execute($upsql);
			}else{
				echo '<br> 订单编号: '.$sn.' 提交确认失败';

			}

			
		}
	}
	}







	if($type == 'delete'){

	$label	= '';
	$orders		= explode(",",$_REQUEST['bill']);
	
	$tkary		= array();
	$i = 0;
	


	$strGetLabelURL = "https://labelserver.endicia.com/LabelService/EwsLabelService.asmx/GetPostageLabelXML";



	for($g=0;$g<count($orders);$g++){
		$sn 	=  $orders[$g];
		if($sn != ""){
			
			$sql	= "select * from ebay_order as a where ebay_id='$sn' ";			
			$sql	= $dbcon->execute($sql);
			$sql	= $dbcon->getResultArray($sql);
			
			$ebay_ordersn			= $sql[0]['ebay_ordersn'];
		$pxorderid			= $sql[0]['pxorderid'];





			//修改出库单状态（确认发货/作废出库单）
			$outConfirmXml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:adin="http://3e.pl/ADInterface">
			   <soapenv:Header/>
			   <soapenv:Body>
				  <adin:updateData>
					 <adin:ModelCRUDRequest>
						<adin:ModelCRUD>
						   <adin:serviceType>update:WT_ExWarehouse</adin:serviceType>
						   <adin:TableName>WT_ExWarehouse</adin:TableName>
							<!--创建出库单后获取的出库单ID-->
						   <adin:RecordID>'.$pxorderid.'</adin:RecordID>
						   <adin:Action>Update</adin:Action>
						   <adin:DataRow>
							  <adin:field column="Status" >
								 <adin:val>VO</adin:val>
							  </adin:field>
						   </adin:DataRow>
						</adin:ModelCRUD>
						<adin:ADLoginRequest>
						  <adin:user>'.$wytuser.'</adin:user>
               <adin:pass>'.$wytuserpass.'</adin:pass>
						   <adin:lang>zh_CN</adin:lang>
						   <adin:ClientID>11</adin:ClientID>
						   <adin:RoleID>1000074</adin:RoleID>
						   <adin:OrgID>1000000</adin:OrgID>
						   <adin:WarehouseID>1000005</adin:WarehouseID>
						   <adin:stage>0</adin:stage>
						</adin:ADLoginRequest>
					 </adin:ModelCRUDRequest>
				  </adin:queryData>
			   </soapenv:Body>
			</soapenv:Envelope>';
			//exit;
			$outConfirmReturn = apiCall($outConfirmXml);
			if($outConfirmReturn['RecordID'] != ''){

				echo '<br> 订单编号: '.$sn.' 提交作废成功';			
			}else{

				echo '<br> 订单编号: '.$sn.' 提交作废失败';

			}

			

	}
	}
	}






		if($type == 'track'){
	$label	= '';
	$orders		= explode(",",$_REQUEST['bill']);
	
	$tkary		= array();
	$i = 0;
	


	$strGetLabelURL = "https://labelserver.endicia.com/LabelService/EwsLabelService.asmx/GetPostageLabelXML";



	for($g=0;$g<count($orders);$g++){
		$sn 	=  $orders[$g];
		if($sn != ""){
			
			$sql	= "select * from ebay_order as a where ebay_id='$sn' ";			
			$sql	= $dbcon->execute($sql);
			$sql	= $dbcon->getResultArray($sql);
			
			$ebay_ordersn			= $sql[0]['ebay_ordersn'];
		$pxorderid			= $sql[0]['pxorderid'];





			//修改出库单状态（确认发货/作废出库单）
			$outConfirmXml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:adin="http://3e.pl/ADInterface">
   <soapenv:Header/>
   <soapenv:Body>
      <adin:queryData>
         <adin:ModelCRUDRequest>
            <adin:ModelCRUD>
               <adin:serviceType>query:WT_ExWarehouse</adin:serviceType>
               <adin:TableName>WT_ExWarehouse</adin:TableName>
               <adin:RecordID>'.$pxorderid.'</adin:RecordID>
               <adin:Action>Read</adin:Action>
               <adin:Where>
			   <adin:WhereExp LogicalOperators="" PrefixParentheses="" ColumnName="WT_ExWarehouse_ID" ComparisonOparators="=" Value="1006047" SuffixParentheses=""/>
			   </adin:Where>
               <adin:OrderBy>
               <adin:OrderExp ColumnName="WT_ExWarehouse_ID" OrderingRule="" />
              </adin:OrderBy>
	     <adin:Pagination StartRow="1" PageSize="10" />
            </adin:ModelCRUD>
           <adin:ADLoginRequest>
						 <adin:user>'.$wytuser.'</adin:user>
               <adin:pass>'.$wytuserpass.'</adin:pass>
						   <adin:lang>zh_CN</adin:lang>
						   <adin:ClientID>11</adin:ClientID>
						   <adin:RoleID>1000074</adin:RoleID>
						   <adin:OrgID>1000000</adin:OrgID>
						   <adin:WarehouseID>1000005</adin:WarehouseID>
						   <adin:stage>0</adin:stage>
						</adin:ADLoginRequest>
         </adin:ModelCRUDRequest>
      </adin:queryData>
   </soapenv:Body>
</soapenv:Envelope>
';
			//exit;
			$outConfirmReturn = apiCall($outConfirmXml);



			print_r($outConfirmReturn);

			if($outConfirmReturn['RecordID'] != ''){
				echo '<br> 订单编号: '.$sn.' 跟踪号同步成功';			
			}else{
				echo '<br> 订单编号: '.$sn.' 跟踪号同步失败';

			}

			

	}
	}
	}






	?>

<br />
<br />
<br />
<table width="648" height="209">
  <tr>
    <td width="66">仓库</td>
    <td width="272">派送方式</td>
    <td width="97">派送方式代码</td>
    <td width="193">无保险代码</td>
  </tr>
  <tr>
    <td width="66">AU</td>
    <td width="272">Au Post eParcel</td>
    <td width="97">1000019</td>
    <td width="193">1000009</td>
  </tr>
  <tr>
    <td width="66">AU</td>
    <td width="272">eParcel</td>
    <td width="97">1000020</td>
    <td width="193">1000010</td>
  </tr>
  <tr>
    <td width="66">AU</td>
    <td width="272">Au Post Parcel Post</td>
    <td width="97">1000021</td>
    <td width="193">1000011</td>
  </tr>
  <tr>
    <td width="66">AU</td>
    <td width="272">Au Post Large Letter(No Registration)</td>
    <td width="97">1000023</td>
    <td width="193">1000012</td>
  </tr>
  <tr>
    <td width="66">AU</td>
    <td width="272">Au Post Parcel Post(No Registration)</td>
    <td width="97">1000024</td>
    <td width="193">1000013</td>
  </tr>
  <tr>
    <td width="66">AU</td>
    <td width="272">Toll Priority</td>
    <td width="97">1000027</td>
    <td width="193">1000018</td>
  </tr>
  <tr>
    <td width="66">AU</td>
    <td width="272">Toll IPEC</td>
    <td width="97">1000025</td>
    <td width="193">1000016</td>
  </tr>
  <tr>
    <td width="66">USW</td>
    <td width="272">Standard Shipping</td>
    <td width="97">1000030</td>
    <td width="193">1000021</td>
  </tr>
  <tr>
    <td width="66">USW</td>
    <td width="272">Economic Shipping</td>
    <td width="97">1000028</td>
    <td width="193">1000019</td>
  </tr>
  <tr>
    <td width="66">USW</td>
    <td width="272">Express Shipping</td>
    <td width="97">1000029</td>
    <td width="193">1000020</td>
  </tr>
</table>
<p>01. 仓库代码，库存管理, 仓库管理，仓库编码</p>
<p>02. 发货方式代码， 系统管理， 发货方式管理,对应万邑通服务代码和无保险代码。</p>
