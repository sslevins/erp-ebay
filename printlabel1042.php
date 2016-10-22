<?
//header("Content-type:application/vnd.ms-doc;");
//header("Content-Disposition:filename=test.doc");
?> 

<?php

	include "include/config.php";
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
	
	

		$ertj		= "";
			$orders		= explode(",",$_REQUEST['ordersn']);
			for($g=0;$g<count($orders);$g++){
		
		
				$sn 	=  $orders[$g];
				if($sn != ""){
				
					$ertj	.= " a.ebay_id ='$sn' or";
				}
			
			}
			$ertj			 = substr($ertj,0,strlen($ertj)-3);
			
			$sql	= "select a.*,count(b.ebay_id) as cc  from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn = b.ebay_ordersn  where ($ertj) and a.ebay_user='$user' group by a.ebay_id  order by  cc asc ,sku asc ";

			$sql	= $dbcon->execute($sql);
			$sql	= $dbcon->getResultArray($sql);
				
		
			
		
?>
<style type="text/css">
<!--
.table {border: 0px dotted #CCCCCC; }
.STYLE16 {font-size: 10px}

-->
</style>
<style media="print"> 
.noprint { display: none } 
</style> 

<script > 

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

//idPrint1.disabled = false; 
//idPrint3.disabled = false; 
} 
</script>
<table style="width:105mm" border="0" cellpadding="0" cellspacing="0">

 
 
  <tr>   
  
   <?php
 	for($i=0;$i<count($sql);$i++){
			
				
				$ebayaccount	= $sql[$i]['ebay_account'];
				$recordnumber	= $sql[$i]['recordnumber'];
				$ebay_id		= $sql[$i]['ebay_id'];
								
				
				$userid			= $sql[$i]['ebay_userid'];
				$barcode		= $userid.$recordnumber;
				
				$cname			= $sql[$i]['ebay_username'];
				$street1		= @$sql[$i]['ebay_street'];
				$street2 		= @$sql[$i]['ebay_street1']?@$sql[$i]['ebay_street1']:"";
				$city 			= $sql[$i]['ebay_city'];
				$state			= $sql[$i]['ebay_state'];
				$countryname 	= $sql[$i]['ebay_countryname'];
				$zip			= $sql[$i]['ebay_postcode'];
				$tel			= $sql[$i]['ebay_phone']?$sql[$i]['ebay_phone']:"";
				$recordnumber   = $sql[$i]['recordnumber'];
				$is_reg		    = $sql[$i]['is_reg'];
				$ordersn		= $sql[$i]['ebay_ordersn'];	
				$ebay_noteb		= $sql[$i]['ebay_noteb'].' '.$sql[$i]['ebay_note'];
				
				
				$addressline	= $cname."<br>".$street1."<br>".$street2."<br>".$city.", ".$state."<br>".$zip;
				
				$ebay_carrier			= $sql[$i]['ebay_carrier'];

				
				$ss				= "select * from ebay_carrier where  name ='$ebay_carrier'";
				
				$ss				= $dbcon->execute($ss);
				$ss				= $dbcon->getResultArray($ss);
				$address		= $ss[0]['address'];
					
			//	$dsql	= "update ebay_order set ebay_status='6' where ebay_ordersn='$ordersn'";
			//	$dbcon->execute($dsql);	
				
				
 
 
 
 
  ?>
 
    <td width="657" align="center" valign="middle"><span class="table"> 
    <table width="100%" border="0" cellpadding="0" cellspacing="0" >


  <tr>   
  

 
    <td>
    <table width="400px" height="180px"   border="0" cellpadding="0" cellspacing="0"  >


      <tr>
        <td width="94%" height="35" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000" style="border:2px  solid #000000">
          
          
          <tr style="border:#000000 1px">
            <td >
            <img src="barcode128.class.php?data=<?php echo $ebay_id ?>" alt="" width="209" height="59"/>
            <br />
<?php
	 echo "<strong>".$cname."</strong><br>";
		
		 echo $street1."<br> ".$street2;

		  echo $city.", ".$state."<br>".$zip."<br>";
		  	echo $country[$countryname]."  (".$countryname.")<br>";
			if($tel !="" && $tel !="Invalid Request"){
		echo "Tel: ".$tel;
		}else{
		
		echo '&nbsp;';
		
		
		}

		
		 
		 
		 
		 ?>              &nbsp;</td>
            </tr>
          

          
          
          <tr>
            <td align="center"><div style="text-align:center; margin-bottom:3px; border-top:1px solid #000000"></div></td>
            </tr>
          <tr>
            <td align="left"><span class="STYLE16">&nbsp;
            
            
            




	            <?php
		
		
			  
			  $ss			= "select * from ebay_orderdetail where ebay_ordersn = '$ordersn'";
				$ss			= $dbcon->execute($ss);
				$ss			= $dbcon->getResultArray($ss);
		
		$bb = 1;
		
		for($g=0;$g<count($ss);$g++){
		  		
				
				
					
			$ebay_itemtitle				= $ss[$g]['ebay_itemtitle'];
			$ebay_amount				= $ss[$g]['ebay_amount'];
			$attribute				= $ss[$g]['attribute'];
			$sku				= $ss[$g]['sku'];
			
			echo $bb.'. '.$ebay_itemtitle.' '.$attribute.'*'.$ebay_amount.' '.$sku.'<br>';
			
			$bb++;
			
			}
			
	echo $ebay_noteb;
	
	
	?>            
	            </span></td>
          </tr>
          
          
          
 
        </table></td>
        <td width="6%" valign="top">&nbsp;</td>
      </tr>
    </table></td>
  </tr>


  
  

  <td height="0px" ></td>
  </tr>

</table>

    </span></td>
    <td width="2" align="center" valign="middle"></td>
    <?php



	if(($i+1)%2 == 0 && $i !=0) echo "</tr>";
	if(($i+1)%10 == 0 && $i !=0) echo '</tr></table><div style="PAGE-BREAK-AFTER: always">&nbsp;&nbsp;</div><table  style="width:105mm" border="0" cellpadding="0" cellspacing="0"><tr>';
	
	

}



?>
</tr>
</table>
