<?php
include "include/config.php";
include "top.php";




	

	
	$id		= $_REQUEST["id"];

	
	if($_POST['submit']){
		
			$firstweight		= $_POST['firstweight'];
			$names				= $_POST['names'];
			$value				= $_POST['value'];
			$stnames				= $_POST['stnames'];
			$CompanyName				= $_POST['CompanyName'];
			
			$tjsku				= $_POST['tjsku'];
			$tjcountry			= $_POST['tjcountry'];
			$tjcarrier			= $_POST['tjcarrier'];
			$value1				= $_POST['value1'];
			$value2				= $_POST['value2'];
			$ebay_account			= $_POST['ebay_account'];
			$weightmin				= $_POST['weightmin'];
			$weightmax				= $_POST['weightmax'];
			$weighebay_country		= $_POST['weighebay_country'];
			$Priority			= $_POST['Priority'];
			$encounts			= $_POST['encounts'];
			$carrier_sn		= $_POST['carrier_sn'];
			$country		= $_POST['country'];
			$province		= $_POST['province'];
			$city			= $_POST['city'];
			$username		= $_POST['username'];
			$tel			= $_POST['tel'];
			$street			= $_POST['street'];
			$address			= $_POST['address'];
			$wyt_insurce			= $_POST['wyt_insurce'];
			$wyt_code			= $_POST['wyt_code'];
			$value3			= $_POST['value3'];
			
			$handlefee		= $_POST['handlefee'];
			$kg				= $_POST['kg'];
			$signature				= $_POST['signature'];
			$note									= $_POST['note'];
			$max									= $_POST['max'];
			$min									= $_POST['min'];
			$ebay_country							= $_POST['ebay_country'];
			$skus									= $_POST['skus'];
			$orderstatus							= $_POST['orderstatus'];
			$ebay_warehouse							= $_POST['ebay_warehouse'];
			$from_ebaycarrier							= $_POST['from_ebaycarrier'];
			$safetype							= $_POST['safetype'];
			$backtype							= $_POST['backtype'];
			$IsInsured							= $_POST['IsInsured'];
			$InsuredRate							= $_POST['InsuredRate'];
			$zip							= $_POST['zip'];
			$Location							= $_POST['Location'];
			$Point4Delivery							= $_POST['Point4Delivery'];
			$PickupType							= $_POST['PickupType'];
			$name				= $_FILES['upfile']['name'];		
			$filename			= date('Y').date('m').date('d').date('H').date('i').date('s').rand(100,999);
			$filetype			= substr($name,strpos($name,"."),4);
			$stamp_pic			= $filename.$filetype;	
			$isaddpic			= '';
			if (move_uploaded_file($_FILES['upfile']['tmp_name'], "images/".$stamp_pic)) {	
					$status	= "-[<font color='#33CC33'>The picture uploaded successful</font>]<br>";
					$isaddpic			= '1';
			}else{
		
			
			}
			
			if($id == ""){
			$sql	= "insert into ebay_carrier(name,value,ebay_user,country,province,city,username,tel,street,address,carrier_sn,handlefee,kg,signature,max,min,ebay_country,note,firstweight,ebay_account,weightmin,weightmax,weighebay_country,Priority,encounts,skus,orderstatus,ebay_warehouse,stamp_pic,from_ebaycarrier,tjsku,tjcountry,tjcarrier,backtype,safetype,CompanyName,value1,IsInsured,InsuredRate,value2,zip,Location,Point4Delivery,PickupType,stnames,wyt_insurce,wyt_code) values('$names','$value','$user','$country','$province','$city','$username','$tel','$street','$address','$carrier_sn','$handlefee','$kg','$signature','$max','$min','$ebay_country','$note','$firstweight','$ebay_account','$weightmin','$weightmax','$weighebay_country','$Priority','$encounts','$skus','$orderstatus','$ebay_warehouse','$stamp_pic','$from_ebaycarrier','$tjsku','$tjcountry','$tjcarrier','$backtype','$safetype','$CompanyName','$value1','$IsInsured','$InsuredRate','$value2','$zip','$Location','$Point4Delivery','$PickupType','$stnames','$wyt_insurce','$wyt_code')";
			}else{
			
			$sql	= "update ebay_carrier set name='$names',value='$value',country='$country',province='$province',city='$city',username='$username',tel='$tel',street='$street',address='$address',carrier_sn='$carrier_sn',handlefee='$handlefee',kg='$kg',signature='$signature',max='$max',min='$min',ebay_country='$ebay_country',note='$note',firstweight ='$firstweight',ebay_account='$ebay_account',weightmin='$weightmin',weightmax='$weightmax',weighebay_country='$weighebay_country',Priority='$Priority',encounts='$encounts',skus='$skus',orderstatus='$orderstatus',ebay_warehouse='$ebay_warehouse',from_ebaycarrier='$from_ebaycarrier',CompanyName='$CompanyName',tjcarrier='$tjcarrier',tjcountry='$tjcountry',tjsku ='$tjsku',backtype='$backtype',safetype='$safetype',value1='$value1',value2='$value2',IsInsured='$IsInsured',InsuredRate='$InsuredRate',zip='$zip',Location='$Location',Point4Delivery='$Point4Delivery',PickupType='$PickupType',stnames='$stnames', value3='$value3',wyt_code='$wyt_code',wyt_insurce='$wyt_insurce' ";
			if($isaddpic == '1') $sql .= " ,stamp_pic='$stamp_pic' ";
			$sql	.= "  where id=$id ";
			}
		
	
			if($dbcon->execute($sql)){
			
			$status	= " -[<font color='#33CC33'>操作记录: 数据保存成功</font>]";
		
			
		}else{
		
			$status = " -[<font color='#FF0000'>操作记录: 数据保存失败</font>]";
		}
		
			
		
	}
	
	
	if($id	!= ""){
	
		
		$sql = "select * from ebay_carrier where id=$id";
		$sql = $dbcon->execute($sql);
		$sql = $dbcon->getResultArray($sql);
					
		$names  	= $sql[0]['name'];
		$value 		= $sql[0]['value'];
		$Priority 		= $sql[0]['Priority'];
		$ebay_account 			= $sql[0]['ebay_account'];
		$weightmax 			= $sql[0]['weightmax'];
		$weighebay_country 			= $sql[0]['weighebay_country'];
		$weightmin 			= $sql[0]['weightmin'];
		$encounts 			= $sql[0]['encounts'];
		$country 			= $sql[0]['country'];
		$province			= $sql[0]['province'];
		$city 				= $sql[0]['city'];
		$username 			= $sql[0]['username'];
		$tel	 			= $sql[0]['tel'];
		$street 			= $sql[0]['street'];
		$address 			= $sql[0]['address'];
		$carrier_sn 			= $sql[0]['carrier_sn'];
		$handlefee 				= $sql[0]['handlefee'];
		$kg		 				= $sql[0]['kg'];
		$signature		 		= $sql[0]['signature'];
		$firstweight			 		= $sql[0]['firstweight'];
		$max			 		= $sql[0]['max'];
		$min		 			= $sql[0]['min'];
		$ebay_country		 	= $sql[0]['ebay_country'];
		$note				 				= $sql[0]['note'];
		$from_ebaycarrier				 	= $sql[0]['from_ebaycarrier'];
		$skus						 	= $sql[0]['skus'];
		$orderstatus				 	= $sql[0]['orderstatus'];
		$ebay_warehouse				 	= $sql[0]['ebay_warehouse'];
		$stamp_pic				 	= $sql[0]['stamp_pic'];
		$safetype				 	= $sql[0]['safetype'];
		$backtype				 	= $sql[0]['backtype'];
		$value1			= $sql[0]['value1'];
		$value2			= $sql[0]['value2'];
			$tjsku				= $sql[0]['tjsku'];
			$tjcountry			= $sql[0]['tjcountry'];
			$tjcarrier			= $sql[0]['tjcarrier'];
			$InsuredRate			= $sql[0]['InsuredRate'];
			$IsInsured			= $sql[0]['IsInsured'];
			$Location			= $sql[0]['Location'];
			$Point4Delivery			= $sql[0]['Point4Delivery'];
			$PickupType			= $sql[0]['PickupType'];
			$zip			= $sql[0]['zip'];
			$stnames			= $sql[0]['stnames'];
			$value3			= $sql[0]['value3'];
			
			$wyt_insurce			= $sql[0]['wyt_insurce'];
			$wyt_code				= $sql[0]['wyt_code'];
			
			
	}
	
	
	


?>
<style type="text/css">
<!--
.STYLE1 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>


<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status;?></h2>
</div>
 
<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 <input name="hiddenuserid" type="hidden" value="" id="hiddenuserid" />
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
		
	<td nowrap="nowrap" scope="row" >&nbsp;</td>
	</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td width="26%">
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'>			
                      <form id="form" name="form" method="post" action="systemcarrieradd.php?module=system&action=运送方式设置" enctype="multipart/form-data">
                  <table width="90%" border="0" cellpadding="0" cellspacing="0">
                <input name="id" type="hidden" value="<?php echo $id;?>">
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">支持哪些eBay帐号：:</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><textarea name="ebay_account" cols="70" rows="5" id="ebay_account"><?php echo $ebay_account;?></textarea>
			          <br />
			          <span class="STYLE1">在最后面需要加是英文,号结束</span></td>
			        </tr>
			      <tr>
                    <td width="41%" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right"><span style="white-space: nowrap;">发货方式名称	 </span>:</div></td>
                    <td width="3%" align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
                    <td width="56%" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
                      <input name="names" type="text" id="names" value="<?php echo $names;?>">
                    </div></td>
                    </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right"><span style="white-space: nowrap;">上传到ebay的方式名称:</span></div></td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="value" type="text" id="value" size="50" value="<?php echo $value;?>">
			          上传到eBay的运送方式</div></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">上传到速卖通的方式名称</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="value3" type="text" id="value3" size="50" value="<?php echo $value3;?>" />
			          请填写缩写如 CPAM表示Chin Post Air mail </div></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><span style="white-space: nowrap;">对应三态服务代码:</span></td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="stnames" type="text" id="stnames" size="50" value="<?php echo $stnames;?>" />
			          </div></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">对应万邑通服务代码</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><input name="wyt_code" type="text" id="wyt_code" size="50" value="<?php echo $wyt_code;?>" /></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">对应万邑通保险代码</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><input name="wyt_insurce" type="text" id="wyt_insurce" size="50" value="<?php echo $wyt_insurce;?>" /></td>
			        </tr>
					 <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right"><span style="white-space: nowrap;">4px保险类型:</span></div></td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
					<select name='safetype' id='safetype'>
						<option value=''>请选择</option>
						<option value='5Y' <?php if($safetype=='5Y') echo "selected='selected'"?>>5Y</option>
						<option value='8Y' <?php if($safetype=='8Y') echo "selected='selected'"?>>8Y</option>
						<option value='6p' <?php if($safetype=='6p') echo "selected='selected'"?>>6p</option>
					</select>
			        </div></td>
			        </tr>
					 <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right"><span style="white-space: nowrap;">4px是否退件:</span></div></td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
					<select name='backtype' id='backtype'>
						<option value='Y' <?php if($backtype=='Y') echo "selected='selected'"?>>Y</option>
						<option value='N' <?php if($backtype=='N') echo "selected='selected'"?>>N</option>
					</select>
					
			         </div></td>
			        </tr>
			      
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">4px代码</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><input name="value1" type="text" id="value1" value="<?php echo $value1;?>" /></td>
			        </tr>
					<tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">对应出口易代码</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><input name="value2" type="text" id="value2" value="<?php echo $value2;?>" /></td>
			        </tr>
					 <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">出口易是否保价</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><select name='IsInsured' id='IsInsured'>
						<option value='0' <?php if($IsInsured=='0') echo "selected='selected'"?>>否</option>
						<option value='1' <?php if($IsInsured=='1') echo "selected='selected'"?>>是</option>
						
					</select></td>
			        </tr>
					 <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">出口易保价系数</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><input name="InsuredRate" type="text" id="InsuredRate" value="<?php echo $InsuredRate;?>" /></td>
			        </tr>
					<tr>
					<td align="right" bgcolor="#f2f2f2" class="left_txt">出口易专线处理点</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><select name='Location' id='Location'>
						<option value='SZ' <?php if($Location=='SZ') echo "selected='selected'"?>>深圳</option>
						<option value='GZ' <?php if($Location=='GZ') echo "selected='selected'"?>>广州</option>
						<option value='SH' <?php if($Location=='SH') echo "selected='selected'"?>>上海</option>
                        <option value='DG' <?php if($Location=='DG') echo "selected='selected'"?>>东莞</option>
					</select></td>
					</tr>
					<tr>
					<td align="right" bgcolor="#f2f2f2" class="left_txt">出口易专线收货点</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><select name='Point4Delivery' id='Point4Delivery'>
						<option value='SZ' <?php if($Point4Delivery=='SZ') echo "selected='selected'"?>>深圳</option>
						<option value='GZ' <?php if($Point4Delivery=='GZ') echo "selected='selected'"?>>广州</option>
						<option value='SH' <?php if($Point4Delivery=='SH') echo "selected='selected'"?>>上海</option>
                        <option value='DG' <?php if($Point4Delivery=='DG') echo "selected='selected'"?>>东莞</option>
                        
					</select></td>
					</tr>
					<tr>
					<td align="right" bgcolor="#f2f2f2" class="left_txt">出口易专线收获类型</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><select name='PickupType' id='PickupType'>
						<option value='0' <?php if($PickupType=='0') echo "selected='selected'"?>>上门揽收</option>
						<option value='1' <?php if($PickupType=='1') echo "selected='selected'"?>>卖家自送</option>
						
					</select></td>
					</tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        </tr>
			      
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">联系人国家</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="country" type="text" id="country" value="<?php echo $country;?>" />
			        </div></td>
			        </tr>
					<tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">联系人邮编</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="zip" type="text" id="zip" value="<?php echo $zip;?>" />
			        </div></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">联系人省份</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="province" type="text" id="province" value="<?php echo $province;?>" />
			        </div></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">联系人城市</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="city" type="text" id="city" value="<?php echo $city;?>" />
			        </div></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">联系人姓名</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="username" type="text" id="username" value="<?php echo $username;?>" />
			        </div></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">联系人电话</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="tel" type="text" id="tel" value="<?php echo $tel;?>" />
			        </div></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">联系人街道</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="street" type="text" id="street" value="<?php echo $street;?>" />
			        </div></td>
			        </tr>
					<tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">4px发件人公司名</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><input name="CompanyName" type="text" id="CompanyName" value="<?php echo $CompanyName;?>" /></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">回邮地址</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <textarea name="address" cols="70" rows="5" id="address"><?php echo $address;?></textarea>
			        </div></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">物流公司代号</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="carrier_sn" type="text" id="carrier_sn" value="<?php echo $carrier_sn;?>" />
			          </div></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">签名</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><input name="signature" type="text" id="signature" value="<?php echo $signature;?>" /></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">金额：</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><input name="min" type="text" id="min" value="<?php echo $min;?>" />
			        ~
			          <input name="max" type="text" id="max"  value="<?php echo $max;?>" />
			          USD</td>
			      </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">重量：</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><input name="weightmin" type="text" id="weightmin" value="<?php echo $weightmin;?>" />
~
  <input name="weightmax" type="text" id="weightmax"  value="<?php echo $weightmax;?>" />
  KG</td>
			      </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">备注：</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><input name="note" type="text" id="note" value="<?php echo $note;?>" /></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">优先级：</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><input name="Priority" type="text" id="Priority" value="<?php echo $Priority;?>" />
			          数字小，优先级高。如 0. 1, </td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">包含国家：</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><textarea name="encounts" cols="70" rows="5" id="encounts"><?php echo $encounts;?></textarea>
			          <input name="tjcountry" type="checkbox" id="tjcountry" value="1" <?php if($tjcountry =='1') echo 'checked="checked"';?>/>
			          支持指定包含国家的
			          <br />
			          <span class="STYLE1">在最后面需要加是英文,号结束</span>，如何支持所有，请输入 ,any,<br /></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">对应eBay运送方式：</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><textarea name="from_ebaycarrier" cols="70" rows="5" id="from_ebaycarrier"><?php echo $from_ebaycarrier;?></textarea>
			          <input name="tjcarrier" type="checkbox" id="tjcarrier" value="1"  <?php if($tjcarrier =='1') echo 'checked="checked"';?> />
支持指定包含运送方式 <br />
			          <br />
			          <span class="STYLE1">在最后面需要加是英文,号结束</span>，如何支持所有，请输入 ,any,</td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">包含SKU：</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><textarea name="skus" cols="70" rows="5" id="skus"><?php echo $skus;?></textarea>
			          <input name="tjsku" type="checkbox" id="tjsku" value="1" <?php if($tjsku =='1') echo 'checked="checked"';?> />
支持指定包含指定SKU<br />
			          <span class="STYLE1">在最后面需要加是英文,号结束</span>，如何支持所有，请输入 ,any,</td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">选择分类：</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><select name="orderstatus" id="orderstatus">
                      <option value="1" <?php  if($orderstatus == "1")  echo "selected=selected" ?>>待处理订单</option>
                      <option value="2" <?php  if($orderstatus == "2")  echo "selected=selected" ?>>已经发货</option>
                      <?php
                            $ss		= "select * from ebay_topmenu where ebay_user='$user' and name != '' order by ordernumber";
							$ss		= $dbcon->execute($ss);
							$ss		= $dbcon->getResultArray($ss);
							for($i=0;$i<count($ss);$i++){
								$ssid		= $ss[$i]['id'];
								$ssname		= $ss[$i]['name'];
							?>
                      <option value="<?php echo $ssid; ?>" <?php  if($orderstatus == $ssid)  echo "selected=selected" ?>><?php echo $ssname; ?></option>
                      <?php } ?>
                
                    </select></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">对应仓库：</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><select name="ebay_warehouse" id="ebay_warehouse">
                      <option value="">未设置</option>
                      <?php 

							

							$sql = "select * from  ebay_store where ebay_user='$user'";									
							$sql = $dbcon->execute($sql);
							$sql = $dbcon->getResultArray($sql);
				

							for($i=0;$i<count($sql);$i++){

						

								$iid					= $sql[$i]['id'];

								$store_name			= $sql[$i]['store_name'];

								$goods_sku			= $sql[$i]['goods_sku'];	

								$goods_sx			= $sql[$i]['goods_sx'];	

								$goods_xx			= $sql[$i]['goods_xx'];	

						

							

							?>
                      <option value="<?php echo $iid;?>" <?php if($iid ==$ebay_warehouse) echo "selected=selected";?>><?php echo $store_name; ?></option>
                      <?php

							}

							

							

							?>
                    </select></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">设置打印邮票：</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bgcolor="#f2f2f2" class="left_txt"><input name="upfile" type="file" id="upfile" /><img src="images/<?php echo $stamp_pic;?>"   /></td>
			        </tr>
			      
			      
			      
			      
			      
                  <tr>				 
                    <td align="right" class="left_txt"><div align="right"></div></td>
                    <td align="right" class="left_txt">&nbsp;</td>
                    <td align="right" class="left_txt"><div align="left">
                      <input name="submit" type="submit" value="保存数据" onClick="return check()">
                    </div></td>
                    </tr>
                </table>
                 </form> 
               </td>
               
	    </tr>
			</table>		</td>
	</tr>

              
		<tr class='pagination'>
		<td>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'></td>
					</tr>
			</table>		</td>
	</tr></table>


    <div class="clear"></div>
