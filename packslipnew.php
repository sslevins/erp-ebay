<?php
	include "include/config.php";
	$ordersn	= substr($_REQUEST['ordersn'],1);
	$ordersn	= explode(",",$ordersn);
	
	$country['Russian Federation']		=   '俄罗斯联邦';
	$country['Afghanistan']				=   '阿富汗';
	$country['Albania']					= 	'阿尔巴尼亚';
	$country['Algeria']					=	'阿尔及利亚';
	$country['American Samoa']			=	'美属萨摩亚';
	$country['Andorra']					=	'安道尔共和国';
	$country['Angola']					=	'安哥拉';
	$country['Anguilla']				=	'安圭拉';
	$country['Antigua and Barbuda']		=	'安提瓜和巴布达';
	$country['Argentina']				=	'阿根廷';
	$country['Armenia']					=	'亚美尼亚';
	$country['Aruba']					=	'阿鲁巴岛';
	$country['Australia']				=	'澳大利亚';
	$country['Austria']					=	'奥地利';
	$country['Azerbaijan Republic']		=	'阿塞拜疆共和国';
	$country['Bahamas']					=	'巴哈马';
	$country['Bahrain']					=	'巴林';
	$country['Bangladesh']				=	'孟加拉';
	$country['Barbados']				=	'巴巴多斯';
	$country['Belarus']					=	'白俄罗斯';
	$country['Belgium']					=	'比利时';
	$country['Belize']					=	'伯利兹';
	$country['Benin']					=	'贝宁';
	$country['Bermuda']					=	'百慕大群岛';
	$country['Bhutan']					=	'不丹';
	$country['Bolivia']					=	'玻利维亚';
	$country['Botsnia and Herzegovina']	=	'波斯尼亚和黑塞哥维那';
	$country['Botswana']				=	'博茨瓦纳';
	$country['Brazil']					=	'巴西';
	$country['British Virgin Islands']	=	'英属维京群岛';
	$country['Bruneui Darussalam']		=	'文莱达鲁萨兰';
	$country['Bulgaria']				=	'保加利亚';
	$country['Burkina Faso']			=	'布基纳法索';
	$country['Burma']					=	'缅甸';
	$country['Burundi']					=	'布隆迪';
	$country['Cambodia']				=	'柬埔寨';
	$country['Cameroon']				=	'喀麦隆';
	$country['Canada']					=	'加拿大';
	$country['Cape Verde Islands']		=	'佛得角群岛';
	$country['Cayman Islands']			=	'开曼群岛';
	$country['Central African Republic']			=	'中非共和国';
	$country['Chad']					=	'乍得';
	$country['Chile']					=	'智利';
	$country['China']					=	'中国';
	$country['Colombia']				=	'哥伦比亚';
	$country['Comoros']					=	'科摩罗';
	$country['Congo, Democratic Republic of the']			=	'刚果民主共和国';
	$country['Congo, Republic of the']	=	'刚果共和国';
	$country['Cook Islands']			=	'库克群岛';
	$country['Costa Rica']				=	'哥斯达黎加';
	$country['Cote d Ivoire(Ivory Coast)']					=	'象牙海岸共和国';
	$country['Croatia, Republic of']	=	'克罗地亚';
	$country['Cyprus']					=	'塞浦路斯';
	$country['Czech Republic']			=	'捷克共和国';
	$country['Denmark']					=	'丹麦';
	$country['Djibouti']				=	'吉布提';
	$country['Dominica']				=	'多米尼加';
	$country['Dominican Republic']		=	'多米尼加共和国';
	$country['Ecuador']					=	'厄瓜多尔';
	$country['Egypt']					=	'埃及';
	$country['El Salvador']				=	'萨尔瓦多';
	$country['Equatorial Guinea	']		=	'赤道几内亚';
	$country['Eritrea']					=	'厄立特里亚';
	$country['Ethiopia']				=	'埃塞俄比亚';
	$country['Falkland Islands(Islas Malvinas)']			=	'福克兰群岛(马尔维纳斯群岛)';
	$country['Fiji']					=	'斐济';
	$country['Finland']					=	'芬兰';
	$country['France']					=	'法国';
	$country['French Guiana	']			=	'法属圭亚那';
	$country['Gambia']					=	'冈比亚';
	$country['Georgia']					=	'格鲁吉亚';
	$country['Germany']					=	'德国';
	$country['Ghana']					=	'加纳';
	$country['Gibraltar']				=	'直布罗陀';
	$country['Greece']					=	'希腊';
	$country['Greenland']				=	'格陵兰';
	$country['Grenada']					=	'格林纳达';
	$country['Guadeloupe']				=	'瓜德罗普';
	$country['Guam']					=	'关岛';
	$country['Guatemala']				=	'危地马拉';
	$country['Guernsey']				=	'根西岛';
	$country['Guinea']					=	'几内亚';
	$country['Guinea-Bissau']			=	'几内亚比绍共和国';
	$country['Guyana']					=	'圭亚那';
	$country['Haiti']					=	'海地';
	$country['Honduras']				=	'洪都拉斯';
	$country['Hong Kong	']				=	'中国香港';
	$country['Hungary']					=	'匈牙利';
	$country['Iceland']					=	'冰岛';
	$country['India']					=	'印度';
	$country['Indonesia	']				=	'印度尼西亚';
	$country['Ireland']					=	'爱尔兰';
	$country['Israel']					=	'以色列';
	$country['Italy']					=	'意大利';
	$country['Jamaica']					=	'牙买加';
	$country['Jan Mayen']				=	'扬马延岛';
	$country['Japan']					=	'日本';
	$country['Jersey']					=	'泽西岛';
	$country['Jordan']					=	'约旦';
	$country['Kazakhstan']				=	'哈萨克斯坦';
	$country['Kenya']					=	'肯尼亚';
	$country['Kiribati']				=	'基里巴斯';
	$country['Korea, South']			=	'韩国';
	$country['Kuwait']					=	'科威特';
	$country['Kyrgyzstan']				=	'吉尔吉斯斯坦';
	$country['Laos']					=	'老挝';
	$country['Latvia']					=	'拉脱维亚';
	$country['Lebanon']					=	'黎巴嫩';
	$country['Liechtenstein']			=	'列支敦士登';
	$country['Lithuania']				=	'立陶宛';
	$country['Luxembourg']				=	'卢森堡';
	$country['Macau']					=	'中国澳门';
	$country['Macedonia']				=	'马其顿';
	$country['Madagascar']				=	'马达加斯加';
	$country['Malawi']					=	'马拉维';
	$country['Malaysia']				=	'马来西亚';
	$country['Maldives']				=	'马尔代夫';
	$country['Mali']					=	'马里';
	$country['Malta']					=	'马耳他';
	$country['Marshall Islands']		=	'马绍尔群岛';
	$country['Martinique']				=	'马提尼克';
	$country['Mauritania']				=	'毛利塔尼亚';
	$country['Mauritius']				=	'毛里求斯';
	$country['Mayotte']					=	'马约特';
	$country['Mexico']					=	'墨西哥';
	$country['Micronesia']				=	'密克罗尼西亚';
	$country['Moldova']					=	'摩尔多瓦';
	$country['Monaco']					=	'摩纳哥';
	$country['Mongolia']				=	'蒙古';
	$country['Montenegro']				=	'门的内哥罗';
	$country['Montserrat']				=	'蒙特塞拉特';
	$country['Morocco']					=	'摩洛哥';
	$country['Mozambique']				=	'莫桑比克';
	$country['Namibia']					=	'纳米比亚';
	$country['Nauru']					=	'瑙鲁';
	$country['Nepal']					=	'尼泊尔';
	$country['Netherlands']				=	'荷兰';
	$country['Netherlands Antilles']	=	'荷属安的列斯群岛';
	$country['New Caledonia']			=	'新喀里多尼亚';
	$country['New Zealand']				=	'新西兰';
	$country['Nicaragua']				=	'尼加拉瓜';
	$country['Niger']					=	'尼日尔';
	$country['Nigeria']					=	'尼日利亚';
	$country['Niue']					=	'纽埃';
	$country['Norway']					=	'挪威';
	$country['Oman']					=	'阿曼';
	$country['Pakistan']				=	'巴基斯坦';
	$country['Palau']					=	'帕劳';
	$country['Panama']					=	'巴拿马';
	$country['Papua New Guinea']		=	'巴布亚新几内亚';
	$country['Paraguay']				=	'巴拉圭';
	$country['Peru']					=	'秘鲁';
	$country['Philippines']				=	'菲律宾共和国';
	$country['Poland']					=	'波兰';
	$country['Portugal']				=	'葡萄牙';
	$country['Puerto Rico']				=	'波多黎各';
	$country['Qatar']					=	'卡塔尔';
	$country['Romania']					=	'罗马尼亚';
	$country['Rwanda']					=	'卢旺达';
	$country['Saint Helena']			=	'圣赫勒拿';
	$country['Saint Kitts-Nevis']		=	'圣克里斯多福尼维斯';
	$country['Saint Lucia']				=	'圣卢西亚';
	$country['Saint Pierre and Miquelon']			=	'圣皮埃尔和密克隆';
	$country['Saint Vincent and the Grenadines']			=	'圣文森特和格林纳丁斯';
	$country['San Marino']				=	'圣马力诺';
	$country['Saudi Arabia']			=	'沙特阿拉伯';
	$country['Senegal']					=	'塞内加尔';
	$country['Serbia']					=	'塞尔维亚';
	$country['Seychelles']				=	'塞舌尔';
	$country['Sierra Leone']			=	'塞拉利昂';
	$country['Singapore']				=	'新加坡';
	$country['Slovakia']				=	'斯洛伐克';
	$country['Slovenia']				=	'斯洛文尼亚';
	$country['Solomon Islands']			=	'所罗门岛';
	$country['Somalia']					=	'索马里';
	$country['South Africa']			=	'南非';
	$country['Spain']					=	'西班牙';
	$country['Sri Lanka']				=	'斯里兰卡';
	$country['Suriname']				=	'苏里南';
	$country['Svalbard']				=	'斯瓦尔巴';
	$country['Swaziland	']				=	'斯威士兰';
	$country['Sweden']					=	'瑞典';
	$country['Switzerland']				=	'瑞士';
	$country['Syria']					=	'叙利亚共和国';
	$country['Tahiti']					=	'塔希提岛';
	$country['Taiwan']					=	'中国台湾';
	$country['Tajikistan']				=	'塔吉克斯坦';
	$country['Tanzania']				=	'坦桑尼亚';
	$country['Thailand']				=	'泰国';
	$country['Togo']					=	'多哥';
	$country['Trinidad and Tobago']		=	'特立尼达和多巴哥';
	$country['Tunisia']					=	'突尼斯';
	$country['Turkey']					=	'土耳其';
	$country['Turkmenistan']			=	'土库曼斯坦';
	$country['Turks and Caicos Islands']=	'特克斯和凯科斯群岛';
	$country['Tuvalu']					=	'图瓦卢';
	$country['Uganda']					=	'乌干达';
	$country['Ukraine']					=	'乌克兰';
	$country['United Arab Emirates']	=	'阿拉伯联合酋长国';
	$country['United Kingdom']			=	'英国';
	$country['United States']			=	'美国';
	$country['US']						=	'美国';
	$country['Uruguay']					=	'乌拉圭';
	$country['Uzbekistan']				=	'乌兹别克斯坦';
	$country['Vanuatu']					=	'瓦努阿图';
	$country['Vatican City State']		=	'梵蒂冈';
	$country['Venezuela']				=	'委内瑞拉';
	$country['Vietnam']					=	'越南';
	$country['Virgin Islands(U.S.)']	=	'美属维尔京群岛';
	$country['Wallis and Futuna']		=	'瓦利斯和富图纳';
	$country['Western Sahara']			=	'西撒哈拉';
	$country['Western Samoa']			=	'西萨摩亚';
	$country['Yemen']					=	'也门';
	$country['Zambia']					=	'赞比亚';
	$country['Zimbabwe']				=	'津巴布韦';
	
	$csd		= array();
	$csd['USD'] = "$";
	$csd['GBP'] = "£";
	

	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="zxml.js"></script>
<link rel="stylesheet" href="invoice.css" />
<title>Tracking Information</title>
<style media="print"> 
.noprint { display: none } 
</style> 
<style type="text/css">
<!--
-->

h1 {
	text-transform: uppercase;
	color: #CCCCCC;
	text-align: right;
	font-size: 24px;
	font-weight: normal;
	padding-bottom: 5px;
	margin-top: 0px;
	margin-bottom: 15px;
	border-bottom: 1px solid #CDDDDD;
}

#ic tr td {
	font-size: 10px;
}
#ic tr td table tr td table tr td p strong {
	text-align: right;
}
#ic tr td table tr td table tr td strong {
	font-size: 12px;
}
.STYLE4 {
	font-size: 9px;
	font-family:Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.STYLE5 {font-size: 9px}
</style>

<script src="Scripts/AC_ActiveX.js" type="text/javascript"></script>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
</head>
<body>
<script type="text/javascript">
AC_AX_RunContent( 'classid','CLSID:8856F961-340A-11D0-A96B-00C04FD705A2','height','10','id','WB','width','10' ); //end AC code
</script><noscript><OBJECT classid=CLSID:8856F961-340A-11D0-A96B-00C04FD705A2 height=10 id=WB width=10></OBJECT></noscript> 
<script language="JavaScript"> 
self.moveTo(0,0);
self.resizeTo(screen.availWidth,screen.availHeight);
self.focus();
function doPrintSetup(){ 
//打印设置 
WB.ExecWB(8,1) 
} 
function doPrintPreview(){ 
//打印预览 
WB.ExecWB(7,1) 
} 
function doprint(){ 
//直接打印 
WB.ExecWB(6,6) 
} 


function window.onload() { 
idPrint2.disabled = false; 
} 
</script>

<?php
	for($g=0;$g<count($ordersn);$g++){
		
		
		$sn 	=  $ordersn[$g];
		if($sn != ""){
		$sql	= "select * from ebay_order where ebay_id='$sn'";
		$sql    = $dbcon->execute($sql);
		$sql	= $dbcon->getResultArray($sql);
		 $sn		= $sql[0]['ebay_ordersn'];
		 $note	= substr($sql[0]['ebay_note'],0);
		 $ebay_account		= $sql[0]['ebay_account'];
		 $ebay_userid		= $sql[0]['ebay_userid'];
		  $ebay_usermail		= $sql[0]['ebay_usermail'];
		  $name		= $sql[0]['ebay_username'];
	   $ebay_id		= $sql[0]['ebay_id'];
  $street1		= @$sql[0]['ebay_street'];
   $ebay_carrier			= $sql[0]['ebay_carrier'];
  
  		$rr						= "select * from ebay_carrier where name='$ebay_carrier' and ebay_user ='$user' ";
		$rr						= $dbcon->execute($rr);
		$rr						= $dbcon->getResultArray($rr);
		$stamp_pic				= $rr[0]['stamp_pic'];
		
		
	$recordnumber 	= @$sql[0]['recordnumber'];
	   $street2 	= @$sql[0]['ebay_street1'];
	   $city 		= $sql[0]['ebay_city'];
	   $state		= $sql[0]['ebay_state'];
	   $countryname = $sql[0]['ebay_countryname'];
	   $zip			= $sql[0]['ebay_postcode'];
	   $tel			= $sql[0]['ebay_phone'];
$ebay_shipfee			= $sql[0]['ebay_shipfee'];?>


<table id="ic" width="100%"  border="0" align="center" cellpadding="0" cellspacing="0"   >
<tr>
  <td><table width="100%" border="0" cellspacing="5" cellpadding="0">
    <tr>
      <td width="28%"><div align="left"><strong>CHANNEL ID:</strong></div></td>
      <td width="28%" colspan="3"><div align="left"><?php echo $ebay_account;?>&nbsp;</div></td>
      <td width="15%"><div align="left"><strong>BUYER ID:</strong></div></td>
      <td width="29%"><div align="left"><?php echo $ebay_userid;?>&nbsp;</div></td>
    </tr>
    <tr>
      <td><strong>CUSTOMER NAME:</strong></td>
      <td colspan="3"><?php echo $name;?>&nbsp;</td>
      <td><strong>CUSTOMER ADDRESS</strong></td>
      <td><?php   echo $street1." ".$street2; ?>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>ORDER DATE</strong></td>
      <td><?php
				
				$time	= $sql[0]['ebay_createdtime'];
				
				echo date("d-m-Y",$time);
				
			
			
			?></td>
      <td><strong>PAYMENT DATE</strong></td>
      <td><?php
				
				$time	= $sql[0]['ebay_paidtime'];
				
				echo date("d-m-Y",$time);
				
			
			
			?></td>
      <td><strong>POST CODE</strong></td>
      <td><?php echo $zip;?></td>
    </tr>
    
  </table></td>
</tr>


<tr>
  <td height="50" valign="top"><table width="100%" height="110" border="0" cellpadding="0" cellspacing="0" style="margin-top:15px;">
    <tr>
      <td width="59%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="56%" valign="top"><font size="3px">
              <strong>TO</strong><b><strong>:</strong></b>
              <?php
	   
	   
	 
	   echo '<strong>'.$name."</strong><br>";
	   echo $street1." ".$street2."<br>";
	   if($city !="") echo $city."<br>";
	   if($state != "") echo $state."<br>";
	   if($zip != "") echo $zip."<br>";
	   echo '<strong>'.$countryname.'&nbsp;&nbsp;&nbsp;'.$country[$countryname]."</strong><br>";
	 
	   
	  
	   $currency	= $sql[0]['ebay_currency'];
	  
	   ?>
              <?php   if($tel !="") echo $tel;?>
            </font></td>
          </tr>
          <tr>
            <td valign="top">&nbsp;</td>
          </tr>
      </table></td>
      <td width="2%">&nbsp;</td>
      <td width="41%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><img src="barcode128.class.php?data=<?php echo $ebay_id;?>" alt=""/> <?php echo $ebay_id;?></td>
          </tr>
          <tr>
            <td height="10" valign="bottom" class="heading">&nbsp;</td>
          </tr>
          <tr>
            <td valign="top">&nbsp;</td>
          </tr>
      </table></td>
    </tr>
  </table></td>
</tr>
<tr>
  <td></td>
</tr>
<tr>
  <td></td>
</tr>

<tr>
  <td height="30" valign="bottom"><table width="100%" border="1" cellpadding="5" cellspacing="0" >
    <tr class="heading">
      <td width="7%"><b>Qty</b></td>
      <td width="15%">Pic</td>
      <td width="10%"><b>ITEM<strong>#</strong></b></td>
      <td width="8%"><strong>属性</strong></td>
      <td width="12%">SKU</td>
      <td width="32%" align="left"><b>PRODUCT</b></td>
      <td width="5%" align="right"><b>UNIT PRICE</b></td>
      <td width="4%" align="right"><strong>TOTAL</strong></td>
	  <td width="7%"><strong>RO.</strong></td>
    </tr>
    <?php
	$st	= "select * from ebay_orderdetail where ebay_ordersn='$sn'";
	$st = $dbcon->execute($st);
	$st	= $dbcon->getResultArray($st);
	$total	= 0;
	$tttt= 0;
	for($i=0;$i<count($st);$i++){
	
		$qty		= $st[$i]['ebay_amount'];
		$sku		= $st[$i]['sku'];
		$qname		= $st[$i]['ebay_itemtitle'];
		$qprice		= $st[$i]['ebay_itemprice'];
		$qitemid	= $st[$i]['ebay_itemid'];
		$attribute	= $st[$i]['attribute'];
		$imagepic	= $st[$i]['ebay_itemurl'];
		$recordnumber	= $st[$i]['recordnumber'];
		$total		+= $qty*$qprice;
		
		
		
		
		
		 			$rr			= "select goods_sncombine from ebay_productscombine where ebay_user='$user' and goods_sn='$sku'";
					 $rr			= $dbcon->execute($rr);
					 $rr 	 	= $dbcon->getResultArray($rr);
					 
					 
					 	$goods_sncombine	= $rr[0]['goods_sncombine'];
						

									
	

	
									
?>

    
     <tr>
      <td align="center"><span class="STYLE5"><?php echo $qty;?></span></td>
      <td align="center"> <span class="STYLE5"><img src="<?php echo $imagepic; ?>" border="0" width="55" height="41" />&nbsp;</span></td>
      <td><span class="STYLE5"><?php echo $qitemid;?></span></td>
      <td>
        <span class="STYLE5">
      <?php
	  	
		
		
						
	  
	  echo $attribute.$goods_sncombine;
	  
	  ?>
      
      
      
      &nbsp;</span></td>
      <td><span class="STYLE4"><?php echo $sku;?></span><span class="STYLE5"><br />
          <img src="barcode128.class.php?data=<?php echo $sku ?>" alt=""/>&nbsp;</span></td>
      <td align="left"><span class="STYLE5"><?php echo $qname;?></span></td>
      <td align="right"><span class="STYLE5"><?php echo $currency;?><?php echo $qprice;?></span></td>
      <td align="right"><span class="STYLE5"><?php echo $currency;?><?php echo $qty*$qprice;?></span></td>
	  <td><span class="heading STYLE5">
        <?PHP
		  	
				echo $recordnumber;
				
								
								?>
      </span></td>
    </tr>
    
    
    
    
    
    <?php } ?>
    
    
    
    <?php
	if($i>1 && $tttt==0){
		echo '<tr style="page-break-after:always;">
  <td height="2"></td>
</tr>';
		$tttt =1;
	}

	

		
	
	?>
    <tr>
      <td align="right" colspan="8"><b>SHIPPING METHOD:<?php echo $st[0]['ebay_shiptype'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SUB-TOTAL:</b></td>
      <td align="right"><?php echo $currency;?><?php echo $total;?></td>
    </tr>
    
    <tr>
      <td align="right" colspan="8"><strong>SHIPPING CHARAGE:</strong></td>
      <td align="right"><?php echo $currency;?><?php echo $ebay_shipfee;?>&nbsp;</td>
    </tr>
    <tr>
      <td align="right" colspan="8"><b>ORDER TOTAL:</b></td>
      <td align="right" style=""><?php echo $currency;?><?php echo $total+$shipfee;?></td>
    </tr>
  </table>
    <center>
		<p align="left"><strong>Buyer Note: </strong><strong>
        <?php
				
				echo nl2br($note);?>
		</strong></p>
		<p align="center">______________________________________________________________________________________</p>
    </center></td>
</tr>
<tr>
  <td height="30" valign="bottom">
      <div align="center">拣 货人_________________  二次分检_________________  扫描_________________  包货人_________________<br />
        <br />
      操作人：<?php echo $truename;?></div>
    </div>
    </p></td>
</tr>
</table>
<?php if(($g+1)!=count($ordersn)){?>
<div style="page-break-after:always;">&nbsp;</div>

<?
    }    
		
  }
  
  }

  ?>
</body>
</html>
<script language="javascript">
function change(){
var sl = document.getElementById('idPrint2').value;
var table = document.getElementById('ic');
table.className=sl;
}
</script>