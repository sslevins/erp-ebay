<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>三态地址打印</title>
<style>
html, body, div, span, applet, object, iframe,h1, h2, h3, h4, h5, h6, p, blockquote, pre,a, abbr, acronym, address, big, cite, code,del, dfn, em, font, img, ins, kbd, q, s, samp,small, strike, strong, sub, sup, tt, var,b, u, i, center,dl, dt, dd, ol, ul, li,fieldset, form, label, legend,table, caption, tbody, tfoot, thead, tr, th, td,p {
 margin: 0;
 padding: 0;
 border: 0;
 outline: 0;
 font-size: 100%;
 vertical-align: baseline;
 background: transparent;
 list-style:none;
}
</style>
<style media=print>
.Noprint{display:none;}
.PageNext{page-break-after: always;}
</style>
</head>
<body style="padding:0;margin:0">
<div style="width:210mm; font-family: arial;">
<table style="width:100%;"><tr>
<?php
@session_start();
error_reporting(0);
$user	= $_SESSION['user'];
include "include/dbconnect.php";
$dbcon	= new DBClass();
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
	$country['Russia']					=   '俄罗斯';
	$country['Croatia']				=   '克罗地亚';
	$country['Croatia, Republic of']	=	'克罗地亚';
$ordersn	= explode(',',$_REQUEST['ordersn']);

$ostatus		= $_REQUEST['ostatus'];
$tj = '';
	for($i=0;$i<count($ordersn);$i++){
		
		
			if($ordersn[$i] != ""){
		
			 $sn			= $ordersn[$i];
			 
		$tj	.= "a.ebay_id='$sn' or ";
			}
			
		
	}
	
	
	$tj		= substr($tj,0,strlen($tj)-3);
	
	if($_REQUEST['ordersn'] == ''){
		$sql			= "select * from ebay_order as a where a.ebay_user='$user' and ebay_combine!='1' ";
		$sql.=" and ebay_status='$ostatus'";
	}else{
		$sql			= "select * from ebay_order as a where ($tj)  ";
		
		
		$sql			= "select a.*,b.sku from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn=b.ebay_ordersn where ($tj) group by a.ebay_id order by b.sku ";
		
		
		
	}	
	 $sql			= $dbcon->execute($sql);
	 $sql			= $dbcon->getResultArray($sql);
	$hang = 0;
	$rrr = 0;
	for($i=0;$i<count($sql);$i++){ 
		$line = 0;

		$sn			= $sql[$i]['ebay_ordersn'];
		$carrier				= $sql[$i]['ebay_carrier'];
		$ebay_usermail			= $sql[$i]['ebay_usermail'];
		$ebay_userid			= $sql[$i]['ebay_userid'];	
		$name					= $sql[$i]['ebay_username'];
		$street1				= @$sql[$i]['ebay_street'];
		$street2 				= @$sql[$i]['ebay_street1'];
		$city 					= $sql[$i]['ebay_city'];
		$state					= $sql[$i]['ebay_state'];
		$countryname 			= $sql[$i]['ebay_countryname'];
		$countf_name 			= $country[$countryname];
		$ebay_account 			= $sql[$i]['ebay_account'];
		$zip					= $sql[$i]['ebay_postcode'];
		$recordnumber					= $sql[$i]['recordnumber'];
		$tel					= $sql[$i]['ebay_phone'];
		$street					= $street1.' '.$street2;
		$citystate				= $city.','.$state.','.$zip;
		if(strlen($street)>33){
			$line++;
		}
		if(strlen($citystate)>33){
			$line++;
		}
		$skunum = 0;
		$ss = "select ebay_amount,sku from ebay_orderdetail where ebay_ordersn='$sn'";
		$ss			= $dbcon->execute($ss);
		$ss			= $dbcon->getResultArray($ss);
		foreach($ss as $k=>$v){
			$sku = $v['sku'];
			$rr			= "select * from ebay_productscombine where ebay_user='$user' and goods_sn='$sku'";
			$rr			= $dbcon->execute($rr);
			$rr 	 	= $dbcon->getResultArray($rr);
			if(count($rr) > 0){
				$goods_sncombine	= $rr[0]['goods_sncombine'];
				$notes				= $rr[0]['notes'];
				for($e=0;$e<count($goods_sncombine);$e++){
					$skunum++;
				}
			}else{
				$skunum++;
			}
		}
		if($skunum>2) $line++;
		if($line>0) $next++;
		if($tel == 'Invalid Request') $tel = '';
		
 ?>
	<td <?php if($line>0) echo 'rowspan="2"' ;?> style="width:50mm;min-height:38mm;border:1px solid #000000;padding:2px;font-size:12px; margin:1px;">
		<div style="width:100%;line-height:20px;">
		<ul>
			<li>R0401 &nbsp;&nbsp;755497783 &nbsp;&nbsp;<?php echo $ebay_account;?><?php echo $recordnumber?></li>
			<li><strong>TO:<?php echo $name;?></strong></li>
			<li><?php echo $street;?></li>
			<li><?php echo $citystate;?></li>
			<li><strong><?php echo $countryname.'('.$countf_name.')';?></strong></li>
			<li><strong><?php echo $carrier;?></strong></li>
			<li><?php
				$ss = "select ebay_amount,sku from ebay_orderdetail where ebay_ordersn='$sn'";
				$ss			= $dbcon->execute($ss);
				$ss			= $dbcon->getResultArray($ss);
				foreach($ss as $k=>$v){
					$sku = $v['sku'];
					$amount = $v['ebay_amount'];
					$sss = "select goods_note from ebay_goods where goods_sn='$sku' and ebay_user='$user'";
					$sss			= $dbcon->execute($sss);
					$sss			= $dbcon->getResultArray($sss);
					
					
					
					$rr			= "select * from ebay_productscombine where ebay_user='$user' and goods_sn='$sku'";
					$rr			= $dbcon->execute($rr);
					$rr 	 	= $dbcon->getResultArray($rr);
					
	
								if(count($rr) > 0){
			
									$goods_sncombine	= $rr[0]['goods_sncombine'];
									$notes				= $rr[0]['notes'];
									$goods_sncombine    = explode(',',$goods_sncombine);	
									
									
									for($e=0;$e<count($goods_sncombine);$e++){
						
											$pline			= explode('*',$goods_sncombine[$e]);
											$goods_sn		= $pline[0];
											$goddscount     = $pline[1] * $amount;
											
											
											if($goods_sn != ''){
													
													$ee			= "SELECT * FROM ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
													$ee			= $dbcon->execute($ee);
													$ee 	 	= $dbcon->getResultArray($ee);
													
													if($notes){
														echo $goods_sn.'*'.$goddscount.'('.$notes.'),';
													}else{
														echo $goods_sn.'*'.$goddscount.',';
													}
													
													if(($e+1)%2 ==0 ) echo '<br>';
											}
											
											
									}
									
									
								}else{
								
								
										
										if($sss[0]['goods_note']){
											echo $sku.'*'.$amount.'('.$sss[0]['goods_note'].'),';
										}else{
											echo $sku.'*'.$amount.',';
										}
										
										if(($k+1)%2 ==0 && ($k+1)!= count($ss)) echo '<br>';
					
								
								}
					
				}
			?></li>
		</ul>
		</div>
	</td>
	
	
	<?php 
	$rrr ++;
	if($rrr%4==0){
		echo "</tr>";
		$hang++;
		if($hang==7 ){
			echo '</table><div style="page-break-after:always;"></div>------------------------------<table style="width:100%;"><tr>';
			$hang = 0;
			$rrr = 0;
		}else{
			$rrr = $next;
			echo "<tr>";
		}
		$next = 0;
	} 
}
if($rrr!=4){
	for($r=1;$r<=(4-$rrr);$r++){
		echo '<td>&nbsp;</td>';
	}
}
?>

</tr>
</table>
</div>
</body>
</html>