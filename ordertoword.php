<?php
header("Content-type: text/html; charset=utf-8");
header("Content-Type:   application/msword");
date_default_timezone_set ("Asia/Chongqing");
header("Content-Disposition:   attachment;   filename=".date('Y').date('m').date('d').date('H').date('i').".doc");
header("Pragma:   no-cache");
header("Expires:   0");
@session_start();
error_reporting(0);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
<?php

$user	= $_SESSION['user'];
function str_rep($str){

		

		$str  = str_replace("'","&acute;",$str);

		$str  = str_replace("\"","&quot;",$str);

		return $str;	

}

date_default_timezone_set ("Asia/Chongqing");

function str_rep2($str){

		

		$str  = str_replace("&acute;","'",$str);

		$str  = str_replace("&quot;","\"",$str);

		return $str;	

}







include "include/dbconnect.php";	

date_default_timezone_set ("Asia/Chongqing");	

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

	$country['Estonia']					=	'爱沙尼亚';

	$country['USA']						=	'美国';

	$country['Bosnia and Herzegovina']	=	'波斯尼亚和黑塞哥维那';
	$country['South Korea']	=	'韩国';
	

	

	$dbcon	= new DBClass();



	function getmerge($ordersn){

		

		global $dbcon;	

		$sql	= "select * from ebay_orderdetail where ebay_ordersn='$ordersn' ";	

		$sql	= $dbcon->execute($sql);

		$sql	= $dbcon->getResultArray($sql);



		$skuary		= array();

		

		

		for($i=0;$i<count($sql);$i++){			

			

			$sku	= $sql[$i]['sku'];

			$count	= $sql[$i]['ebay_amount'];



			if(strstr($sku,'+')){

					$cstr		= explode('+',$sku);

					for($h=0;$h<count($cstr);$h++){

						

						$sku1	= trim($cstr[$h]);

						if(array_key_exists($sku1, $skuary)){		

							$skuary[$sku1]		= $skuary[$sku1] + $count;			

						}else{				

							$skuary[$sku1]		= $count;				

						}

									

					}

					

			}else{

				

				

						if(array_key_exists($sku, $skuary)){		

				

							$skuary[$sku]		= $skuary[$sku] + $count;			

						}else{				

							$skuary[$sku]		= $count;				

						}

						

			

			

			

			}

			

			



			

			

				

			

		}

		

		

		$ss			= "select * from ebay_order where ebay_ordersn='$ordersn' ";	

		$ss			= $dbcon->execute($ss);

		$ss			= $dbcon->getResultArray($ss);

		$country	= $ss[0]['ebay_countryname'];

		

		

		foreach($skuary as $key=>$value){

		

			

			

			$sku	= $key;

			$amount = $value;

			

			

			$ss					= "select * from ebay_goods where goods_sn='$sku'";			

			

			$ss					= $dbcon->execute($ss);

			$ss					= $dbcon->getResultArray($ss);

			$goods_name			= $ss[0]['goods_name'];

			$goods_id			= $ss[0]['goods_id'];

			

			$goods_register		= $ss[0]['goods_register']?$ss[0]['goods_register']:'1';

			

			

			$ss					= "select * from ebay_goodsrule where country='$country' and pid='$goods_id'";

			

			

			$ss					= $dbcon->execute($ss);

			$ss					= $dbcon->getResultArray($ss);

			$value				= $ss[0]['value'];

			

			

			if($goods_name != ''){

			

				

				$totalsku			.= $goods_name."*".($amount*$goods_register)." ".$value."<br>";

				

			}else{

			

				$totalsku			.= $sku."*".($amount*$goods_register)." ".$value."<br>";

				

			}

						

			

				

		

		

		}

		

		

		return  $totalsku;

		

		

		





		

		

	}

	

	$ss			= "delete from ebay_word";

	$dbcon->execute($ss);

	

	

	$ertj		= "";

	$orders		= explode(",",$_REQUEST['ordersn']);

	$iscombine  = $_REQUEST['iscombine']?$_REQUEST['iscombine']:'0';



	

	

	for($g=0;$g<count($orders);$g++){

		$sn 	=  $orders[$g];

		if($sn != ""){

				

					$ertj	.= " a.ebay_ordersn='$sn' or";

		}

			

	}

	$ertj			 = substr($ertj,0,strlen($ertj)-3);



	



	if($ertj == ""){

	$sql1	= "select sku,sum(b.ebay_amount) from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn = b.ebay_ordersn where a.ebay_user='$user' and a.ebay_status='1' and a.ebay_combine!='1' group by sku";



	$sql	= "select * from ebay_order as a where ebay_user='$user' and a.ebay_status='1' and a.ebay_combine!='1' ";	

	}else{	

	$sql	= "select * from ebay_order as a where ($ertj) and a.ebay_user='$user' and a.ebay_combine!='1' ";

	$sql1	= "select sku,sum(b.ebay_amount) from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn = b.ebay_ordersn where a.ebay_user='$user' and ($ertj) and a.ebay_combine!='1' group by sku";





	



	}

	

	if($iscombine == 1){

		

		$sql	.= " GROUP BY ebay_userid, ebay_username, ebay_street, ebay_street1,ebay_account ORDER BY ebay_userid";

		

	

	}

	





	

	$sql	= $dbcon->execute($sql);

	$sql	= $dbcon->getResultArray($sql);



	

	

	$output = '';

	

	

	for($i=0;$i<count($sql);$i++){

		

		$ordersn				= $sql[$i]['ebay_ordersn'];	

		

	

		

		

		@$paidtime				= date('Y-m-d',$sql[$i]['ebay_paidtime']);

		

		



		

		

		$ebay_status			= $sql[$i]['ebay_status'];

		$ebay_usermail			= $sql[$i]['ebay_usermail'];

		$ebay_userid			= $sql[$i]['ebay_userid'];	

		$name					= $sql[$i]['ebay_username'];

	    $street1				= @$sql[$i]['ebay_street'];

	    $street2 				= @$sql[$i]['ebay_street1'];

	    $city 					= $sql[$i]['ebay_city'];

	    $state					= $sql[$i]['ebay_state'];

	    $countryname 			= $sql[$i]['ebay_countryname'];

		$ebay_account 			= $sql[$i]['ebay_account'];

	    $zip					= $sql[$i]['ebay_postcode'];

	    $tel					= $sql[$i]['ebay_phone'];

		if($tel == 'Invalid Request') $tel = '';

		

		$ebay_shipfee			= $sql[$i]['ebay_shipfee'];

		$ebay_note				= $sql[$i]['ebay_note'];

		

		$ebay_note				= str_replace('<![CDATA[','',$ebay_note);

		$ebay_note				= str_replace(']]>','',$ebay_note);

		

		

	

		

		$ebay_total				= @$sql[$i]['ebay_total'];

		$ebay_tracknumber		= @$sql[$i]['ebay_tracknumber'];

		$ebay_account			= @$sql[$i]['ebay_account'];

		

		$recordnumber			= @$sql[$i]['recordnumber'];

		

		$addressline	= "TO".':'.$name.'<br>'.$street1." ".$street2.'<br>'.$city.", ".$state.'<br>'.$zip.'<br>'.$countryname."-".$country[$countryname].'<br>'.$tel;	

		$totalsku		=  $recordnumber.">".getmerge($ordersn);		

		if($iscombine == 1){

		

		if($ertj == ''){

		

		$ss							= "select * from ebay_order as a where ebay_status='$ebay_status' and ebay_userid='$ebay_userid' and ebay_username='$name' and ebay_street='$street1' and ebay_street1='$street2' and ebay_combine!='1' and ebay_ordersn!='$ordersn' and ebay_account='$ebay_account'";

		

		

		}else{

		

		$ss							= "select * from ebay_order as a where ebay_status='$ebay_status' and ebay_userid='$ebay_userid' and ebay_username='$name' and ebay_street='$street1' and ebay_street1='$street2' and ebay_combine!='1' and ebay_ordersn!='$ordersn' and ($ertj) and ebay_account='$ebay_account'";

		

		

		

		}

		



		

		

		

		$ss	= $dbcon->execute($ss);

		$ss	= $dbcon->getResultArray($ss);

		for($u=0;$u<count($ss);$u++){

			

			$uorder					= $ss[$u]['ebay_ordersn'];
			$uorder0				= $ss[$u]['recordnumber'];
			$ebay_note0				= $ss[$u]['ebay_note'];	
			$ebay_note0				= str_replace('<![CDATA[','',$ebay_note0);
			$ebay_note0				= str_replace(']]>','',$ebay_note0);
			
			$ebay_note				.= $ebay_note0;
			

			

			$totalsku		.=  $uorder0.">".getmerge($uorder);

		

			

			

		

		

		}

		}

		

		

		$ss			= "select * from ebay_orderdetail where ebay_ordersn='$ordersn' ";	

		$ss			= $dbcon->execute($ss);

		$ss			= $dbcon->getResultArray($ss);

		$sortsku	= $ss[0]['sku'];

		

		

		

		$addressline	= str_rep($addressline);

		$sku			= str_rep($sku);

		$sortsku		= str_rep($sortsku);

		$totalsku		= str_rep($totalsku);

		$note			= str_rep($ebay_note);

		

		

		$ss			= "insert into ebay_word(address,account,sku,sortsku,note) values('$addressline','$ebay_account','$totalsku','$sortsku','$note')";

		$dbcon->execute($ss);

		

		

		

	

	

		

		

		

		$rightstr					 = ($i+1).". ".$ebay_account."<br>".$totalsku;

		





		

		

	

	



}





	$ss		= "select * from ebay_word order by sortsku";

	$ss		= $dbcon->execute($ss);

	$ss		= $dbcon->getResultArray($ss);

	for($i=0;$i<count($ss);$i++){

		

		$addressline		= str_rep2($ss[$i]['address']);



		$rightstr			= ($i+1).".".$ss[$i]['account']."<br>".str_rep2($ss[$i]['sku']);

		$ebay_note			= str_rep2($ss[$i]['note']);

		

		

		

		

		

	

		$output						.='<span class="STYLE1"><table width="100%" height="180" border="0" style=" border-bottom:#000000 1px solid" align="center" cellpadding="0" cellspacing="0">



<tr><td width="59%" height="130" align="center" valign="top"><div align="left">'.$addressline.'</div></td>

  <td width="41%" align="center" valign="top"><div align="left">'.$rightstr.'</div></td>

</tr>

<tr>

  <td height="15" colspan="2" align="center" valign="top"><div align="left">'.$ebay_note.'</div></td>

  </tr>

</table></span>

';



	

	

	

	}

	

	

	

			







	

	$sql1		= $dbcon->execute($sql1);

	

	

	$sql1		= $dbcon->getResultArray($sql1);

	$total		= 0;

	

	$tsku		= array();

	

	

	for($i=0;$i<count($sql1);$i++){

		

			

			$sku		= $sql1[$i]['sku'];

			$qty		= $sql1[$i]['sum(b.ebay_amount)'];

			

			

			if(strstr($sku,'+')){

					$cstr		= explode('+',$sku);

					for($h=0;$h<count($cstr);$h++){

						

						$sku1	= trim($cstr[$h]);

						if(array_key_exists($sku1, $tsku)){		

							$tsku[$sku1]		= $tsku[$sku1] + $qty;			

						}else{				

							$tsku[$sku1]		= $qty;				

						}

									

					}

					

			}else{

				

				

						if(array_key_exists($sku, $tsku)){		

							$tsku[$sku]		= $tsku[$sku] + $qty;			

						}else{				

							$tsku[$sku]		= $qty;				

						}

						

			

			

			

			}

			

			

			

			

			/*

			

			$ss				= "select * from ebay_goods where goods_sn='$sku'";				

			$ss				= $dbcon->execute($ss);

			$ss				= $dbcon->getResultArray($ss);

			$goods_name		= $ss[0]['goods_name'];

			$goods_location		= $ss[0]['goods_location'];

			$goods_register	= $ss[0]['goods_register']?$ss[0]['goods_register']:'1';			

			$skulabel		= '';

			

			if($goods_name != ''){

				

				$skulabel	= $sku." / ".$goods_name;

				

			

			

			}else{

			

				$skulabel	= $sku;

				

			

			}

			

			

			

			

			$linestr	= $skulabel." / "."*".($qty*$goods_register)." / 货位:".$goods_location."<br>";

			$output		.= $linestr;

			*/

			

			

			

	}

	

	

	foreach($tsku as $key=>$value){

		

			

			

			$sku	= $key;

			$qty	 = $value;

			

			

			$ss				= "select * from ebay_goods where goods_sn='$sku'";				

			$ss				= $dbcon->execute($ss);

			$ss				= $dbcon->getResultArray($ss);

			$goods_name		= $ss[0]['goods_name'];

			$goods_location		= $ss[0]['goods_location'];

			$goods_register	= $ss[0]['goods_register']?$ss[0]['goods_register']:'1';			

			$skulabel		= '';

			

			if($goods_name != ''){

				

				$skulabel	= $sku." / ".$goods_name;

				

			

			

			}else{

			

				$skulabel	= $sku;}
$linestr	= $skulabel." / "."*".($qty*$goods_register)." / 货位:".$goods_location."<br>";
$output		.= $linestr;}
$dbcon->close();
echo   $output;
?>