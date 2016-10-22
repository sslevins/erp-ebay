<?php
	include "../include/config.php";
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
<title>Invoice</title>
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
		$sendusername			= $rr[0]['username'];
		$CompanyName			= $rr[0]['CompanyName'];
		$sendstreet				= $rr[0]['street'];
		$sendprovince			= $rr[0]['province'];
		$sendcountry			= $rr[0]['country'];
		$sendtel				= $rr[0]['tel'];
		
	    $city 					= $sql[0]['ebay_city'];
	    $state					= $sql[0]['ebay_state'];
	    $countryname 			= $sql[0]['ebay_countryname'];
	    $zip					= $sql[0]['ebay_postcode'];
	    $tel					= $sql[0]['ebay_phone'];
		
		$street1 					= $sql[0]['ebay_street'];
		$street2 					= $sql[0]['ebay_street1'];
		
		$ebay_tracknumber 					= $sql[0]['ebay_tracknumber'];
		$orderweight 					= $sql[0]['orderweight'];
		
		if($street2 != ''){
					$addressline	= $street1.",".$street2."<br>".$city.",".$state.",".$zip."<br>".$countryname;
				}else{
					$addressline	= $street1."<br>".$city.", ".$state.",".$zip."<br>".$countryname;
				}
				
		
				
				
		
$ebay_shipfee			= $sql[0]['ebay_shipfee'];?>
<table width="100%" align="center" cellpadding="0" cellspacing="0">
  <col width="72" />
  <col width="112" />
  <col width="72" />
  <col width="57" />
  <col width="93" />
  <col width="72" />
  <col width="117" />
  <tr height="25">
    <td width="773" height="25" colspan="4"><div align="center">
      <div align="center"><strong>INVOICE</strong></div>
    </div></td>
  </tr>
  <tr height="21">
    <td height="21" colspan="4" align="center"> 发 票
      <div align="center"></div></td>
  </tr>
  <tr height="21">
    <td height="21" colspan="4">               
      <table width="100%" border="0" cellspacing="0">
        <tr>
          <td><table width="100%" border="0" cellspacing="0">
            <tr>
              <td colspan="2" align="center">SHIPER'S INFORMATION 收件人资料



&nbsp;</td>
              </tr>
            <tr>
              <td width="14%">Name:</td>
              <td width="86%"><?php echo $sendusername;?>&nbsp;</td>
            </tr>
            <tr>
              <td>寄货人/&nbsp;</td>
              <td><?php echo $sendusername;?></td>
            </tr>
            <tr>
              <td>公司名称
&nbsp;</td>
              <td><?php echo $CompanyName;?></td>
            </tr>
            <tr>
              <td>地址</td>
              <td><?php echo $sendstreet.'<br>'.$sendprovince.' '.$sendcountry;?>&nbsp;</td>
            </tr>
            <tr>
              <td>电话TEL:&nbsp;</td>
              <td><?php echo $sendtel;?>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" align="center">RECEIVER'S  INFORMATION    收件人资料</td>
              </tr>
            <tr>
              <td>Name:</td>
              <td><?php echo $name;?>&nbsp;</td>
            </tr>
            <tr>
              <td>收货人/</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td> 公司名称</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Address:</td>
              <td><?php echo $addressline;?>&nbsp;</td>
            </tr>
            <tr>
              <td>电话</td>
              <td><span style="border-right: #000000 solid 0px;border-left:#000000 solid 0px"><?php echo $tel;?></span></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table></td>
          <td valign="top"><table width="100%" border="0" cellspacing="0">
            <tr>
              <td colspan="2" align="center" valign="middle">TRACKING NUMBER  运单号码</td>
              </tr>
            <tr>
              <td colspan="2" align="center"><?php echo $ebay_tracknumber;?>&nbsp;</td>
              </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" align="center">TOTAL NO.OF PIECES 总箱数：</td>
              </tr>
            <tr>
              <td colspan="2" align="center">1</td>
            </tr>
            <tr>
              <td colspan="2" align="center">TOTAL  WEIGHT   计费重量：</td>
            </tr>
            <tr>
              <td colspan="2" align="center">
              
              
              <?php
			  
			  			
	
	
			  
			  echo $orderweight.'kg';
			  
			  ?>
              
              
              &nbsp;</td>
            </tr>
          </table></td>
        </tr>
    </table>      <div align="center"></div></td>
  </tr>
  <tr height="22">
    <td height="22" colspan="4"><table width="100%" cellpadding="0" cellspacing="0"  >
   
      <tr height="50">
        <td style="border:1px solid #000000" width="184" height="50" >NO. OF UNIT     数量 </td>
        <td  style="border:1px solid #000000"width="129" >DESCRIPTION                    品名</td>
        <td style="border:1px solid #000000" width="165" >COUNTRY OF ORIGIN                原产地</td>
        <td  style="border:1px solid #000000"width="117" >UNIT VALUE     单价</td>
        <td  style="border:1px solid #000000"width="117" >TOTAL VALUE小计</td>
      </tr>
      <?php
	  		
			
			
				$ss			= "select * from ebay_orderdetail where ebay_ordersn = '$sn'";
				$ss			= $dbcon->execute($ss);
				$ss			= $dbcon->getResultArray($ss);
				
				
				$totalqty	= 0;
				$toalprice	= 0;
				
				
				for($gg=0;$gg<count($ss);$gg++){
		  		
						
						
						$ebay_itemtitle			= $ss[$gg]['ebay_itemtitle'];
						$ebay_itemprice			= $ss[$gg]['ebay_itemprice'];
						$ebay_amount			= $ss[$gg]['ebay_amount'];
						
						$sku			= $ss[$gg]['sku'];
						$ebay_itemprice			 = 5;
						$totalqty		+= $ebay_amount;
						$toalprice		+= $ebay_itemprice * $ebay_amount;
						$yy			= "select * from ebay_goods where goods_sn='$sku'";
						$yy			= $dbcon->execute($yy);
						$yy			= $dbcon->getResultArray($yy);
						$goods_ywsbmc	= $yy[0]['goods_ywsbmc'];
						
	  
	  ?>
      
      
      
      <tr height="50">
        <td  width="184" height="50" align="center" style="border:1px solid #000000" ><?php echo $ebay_amount;?>&nbsp;</td>
        <td align="center" style="border:1px solid #000000" ><?php echo $goods_ywsbmc;?></td>
        <td align="center" style="border:1px solid #000000"  >　China</td>
        <td  style="border:1px solid #000000" align="center" ><?php echo $ebay_itemprice;?>&nbsp;</td>
        <td  style="border:1px solid #000000" align="center" ><?php echo '$'.$ebay_itemprice*$ebay_amount;?>&nbsp;</td>
      </tr>
      
      <?php
	  			}
				
	  
	  
	  ?>
      
      
      <tr height="29">
        <td  height="29" colspan="4" style="border:1px solid #000000" >ONLY GIFT, NO COMMERCIALVALUE</td>
        <td style="border:1px solid #000000" align="right" >US$<?php echo $toalprice;?></td>
      </tr>
      <tr height="29">
        <td  height="29" colspan="5" style="border:1px solid #000000" >SHIPPER'S SIGNATURE：&nbsp;</td>
        </tr>
      <tr height="29">
        <td  height="29" colspan="4" style="border:1px solid #000000" > 寄件人签名 </td>
        <td  height="29" style="border:1px solid #000000" ><?php echo date('d/m/Y');?>&nbsp;</td>
      </tr>
    </table></td>
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