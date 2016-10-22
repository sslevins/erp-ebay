<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>A4/8</title>
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
<div style="width:195mm; font-family: arial;">
<?php
include "include/config.php";
	$country['Russia']					=   '俄羅斯';
	$country['Afghanistan']				=   '阿富汗';
	$country['Albania']					= 	'阿爾巴尼亞';
	$country['Algeria']					=	'阿爾及利亞';
	$country['American Samoa']			=	'美屬薩摩亞';
	$country['Andorra']					=	'安道​​爾共和國';
	$country['Angola']					=	'安哥拉';
	$country['Anguilla']				=	'安圭拉';
	$country['Antigua and Barbuda']		=	'安提瓜和巴布達';
	$country['Argentina']				=	'阿根廷';
	$country['Armenia']					=	'亞美尼亞';
	$country['Aruba']					=	'阿魯巴島';
	$country['Australia']				=	'澳大利亞';
	$country['Austria']					=	'奥地利';
	$country['Azerbaijan Republic']		=	'阿塞拜疆共和國';
	$country['Bahamas']					=	'巴哈馬';
	$country['Bahrain']					=	'巴林';
	$country['Bangladesh']				=	'孟加拉';
	$country['Barbados']				=	'巴巴多斯';
	$country['Belarus']					=	'白俄羅斯';
	$country['Belgium']					=	'比利時';
	$country['Belize']					=	'伯利兹';
	$country['Benin']					=	'貝寧';
	$country['Bermuda']					=	'百慕大群島';
	$country['Bhutan']					=	'不丹';
	$country['Bolivia']					=	'玻利維亞';
	$country['Botsnia and Herzegovina']	=	'波斯尼亞和黑塞哥維那';
	$country['Botswana']				=	'博茨瓦納';
	$country['Brazil']					=	'巴西';
	$country['British Virgin Islands']	=	'英屬維京群島';
	$country['Bruneui Darussalam']		=	'文萊達魯薩蘭';
	$country['Bulgaria']				=	'保加利亞';
	$country['Burkina Faso']			=	'布基納法索';
	$country['Burma']					=	'緬甸';
	$country['Burundi']					=	'布隆迪';
	$country['Cambodia']				=	'柬埔寨';
	$country['Cameroon']				=	'喀麥隆';
	$country['Canada']					=	'加拿大';
	$country['Cape Verde Islands']		=	'佛得角群島';
	$country['Cayman Islands']			=	'開曼群島';
	$country['Central African Republic']			=	'中非共和國';
	$country['Chad']					=	'乍得';
	$country['Chile']					=	'智利';
	$country['China']					=	'中國';
	$country['Colombia']				=	'哥倫比亞';
	$country['Comoros']					=	'科摩羅';
	$country['Congo, Democratic Republic of the']			=	'剛果民主共和國';
	$country['Congo, Republic of the']	=	'剛果共和國';
	$country['Cook Islands']			=	'庫克群島';
	$country['Costa Rica']				=	'哥斯達黎加';
	$country['Cote d Ivoire(Ivory Coast)']					=	'象牙海岸共和國';
	$country['Croatia, Republic of']	=	'克羅地亞';
	$country['Cyprus']					=	'塞浦路斯';
	$country['Czech Republic']			=	'捷克共和國';
	$country['Denmark']					=	'丹麥';
	$country['Djibouti']				=	'吉布提';
	$country['Dominica']				=	'多米尼加';
	$country['Dominican Republic']		=	'多米尼加共和國';
	$country['Ecuador']					=	'厄瓜多爾';
	$country['Egypt']					=	'埃及';
	$country['El Salvador']				=	'薩爾瓦多';
	$country['Equatorial Guinea	']		=	'赤道幾內亞';
	$country['Eritrea']					=	'厄立特裡亞';
	$country['Ethiopia']				=	'埃塞俄比亞';
	$country['Falkland Islands(Islas Malvinas)']			=	'福克蘭群島(馬爾維納斯群島)';
	$country['Fiji']					=	'斐濟';
	$country['Finland']					=	'芬蘭';
	$country['France']					=	'法國';
	$country['French Guiana	']			=	'法屬圭亞那';
	$country['Gambia']					=	'岡比亞';
	$country['Georgia']					=	'格魯吉亞';
	$country['Germany']					=	'德國';
	$country['Ghana']					=	'加納';
	$country['Gibraltar']				=	'直布羅陀';
	$country['Greece']					=	'希臘';
	$country['Greenland']				=	'格陵蘭';
	$country['Grenada']					=	'格林納達';
	$country['Guadeloupe']				=	'瓜德羅普';
	$country['Guam']					=	'關島';
	$country['Guatemala']				=	'危地馬拉';
	$country['Guernsey']				=	'根西島';
	$country['Guinea']					=	'幾內亞';
	$country['Guinea-Bissau']			=	'幾內亞比紹共和國';
	$country['Guyana']					=	'圭亞那';
	$country['Haiti']					=	'海地';
	$country['Honduras']				=	'洪都拉斯';
	$country['Hong Kong	']				=	'中國香港';
	$country['Hungary']					=	'匈牙利';
	$country['Iceland']					=	'冰島';
	$country['India']					=	'印度';
	$country['Indonesia	']				=	'印度尼西亞';
	$country['Ireland']					=	'愛爾蘭';
	$country['Israel']					=	'以色列';
	$country['Italy']					=	'意大利';
	$country['Jamaica']					=	'牙買加';
	$country['Jan Mayen']				=	'揚馬延島';
	$country['Japan']					=	'日本';
	$country['Jersey']					=	'澤西島';
	$country['Jordan']					=	'約旦';
	$country['Kazakhstan']				=	'哈薩克斯坦';
	$country['Kenya']					=	'肯尼亞';
	$country['Kiribati']				=	'基裡巴斯';
	$country['Korea, South']			=	'韓國';
	$country['Kuwait']					=	'科威特';
	$country['Kyrgyzstan']				=	'吉爾吉斯斯坦';
	$country['Laos']					=	'老撾';
	$country['Latvia']					=	'拉脫維亞';
	$country['Lebanon']					=	'黎巴嫩';
	$country['Liechtenstein']			=	'列支敦士登';
	$country['Lithuania']				=	'立陶宛';
	$country['Luxembourg']				=	'盧森堡';
	$country['Macau']					=	'中國澳門';
	$country['Macedonia']				=	'馬其頓';
	$country['Madagascar']				=	'馬達加斯加';
	$country['Malawi']					=	'馬拉維';
	$country['Malaysia']				=	'馬來西亞';
	$country['Maldives']				=	'馬爾代夫';
	$country['Mali']					=	'馬裡';
	$country['Malta']					=	'馬耳他';
	$country['Marshall Islands']		=	'馬紹爾群島';
	$country['Martinique']				=	'馬提尼克';
	$country['Mauritania']				=	'毛裡塔尼亞';
	$country['Mauritius']				=	'毛裡求斯';
	$country['Mayotte']					=	'馬約特';
	$country['Mexico']					=	'墨西哥';
	$country['Micronesia']				=	'密克羅尼西亞';
	$country['Moldova']					=	'摩爾多瓦';
	$country['Monaco']					=	'摩納哥';
	$country['Mongolia']				=	'蒙古';
	$country['Montenegro']				=	'門的內哥羅';
	$country['Montserrat']				=	'蒙特塞拉特';
	$country['Morocco']					=	'摩洛哥';
	$country['Mozambique']				=	'莫桑比克';
	$country['Namibia']					=	'納米比亞';
	$country['Nauru']					=	'瑙魯';
	$country['Nepal']					=	'尼泊爾';
	$country['Netherlands']				=	'荷蘭';
	$country['Netherlands Antilles']	=	'荷屬安的列斯群島';
	$country['New Caledonia']			=	'新喀裡多尼亞';
	$country['New Zealand']				=	'新西蘭';
	$country['Nicaragua']				=	'尼加拉瓜';
	$country['Niger']					=	'尼日爾';
	$country['Nigeria']					=	'尼日利亞';
	$country['Niue']					=	'紐埃';
	$country['Norway']					=	'挪威';
	$country['Oman']					=	'阿曼';
	$country['Pakistan']				=	'巴基斯坦';
	$country['Palau']					=	'帕勞';
	$country['Panama']					=	'巴拿馬';
	$country['Papua New Guinea']		=	'巴布亞新幾內亞';
	$country['Paraguay']				=	'巴拉圭';
	$country['Peru']					=	'秘魯';
	$country['Philippines']				=	'菲律賓共和國';
	$country['Poland']					=	'波蘭';
	$country['Portugal']				=	'葡萄牙';
	$country['Puerto Rico']				=	'波多黎各';
	$country['Qatar']					=	'卡塔爾';
	$country['Romania']					=	'羅馬尼亞';
	$country['Rwanda']					=	'盧旺達';
	$country['Saint Helena']			=	'聖赫勒拿';
	$country['Saint Kitts-Nevis']		=	'聖克裡斯多福尼維斯';
	$country['Saint Lucia']				=	'聖盧西亞';
	$country['Saint Pierre and Miquelon']			=	'聖皮埃爾和密克隆';
	$country['Saint Vincent and the Grenadines']			=	'聖文森特和格林納丁斯';
	$country['San Marino']				=	'聖馬力諾';
	$country['Saudi Arabia']			=	'沙特阿拉伯';
	$country['Senegal']					=	'塞內加爾';
	$country['Serbia']					=	'塞爾維亞';
	$country['Seychelles']				=	'塞舌爾';
	$country['Sierra Leone']			=	'塞拉利昂';
	$country['Singapore']				=	'新加坡';
	$country['Slovakia']				=	'斯洛伐克';
	$country['Slovenia']				=	'斯洛文利亞';
	$country['Solomon Islands']			=	'所羅門島';
	$country['Somalia']					=	'索馬裡';
	$country['South Africa']			=	'南非';
	$country['Spain']					=	'西班牙';
	$country['Sri Lanka']				=	'斯裡兰卡';
	$country['Suriname']				=	'蘇裡南';
	$country['Svalbard']				=	'斯瓦爾巴';
	$country['Swaziland	']				=	'斯威士蘭';
	$country['Sweden']					=	'瑞典';
	$country['Switzerland']				=	'瑞士';
	$country['Syria']					=	'敘利亞共和國';
	$country['Tahiti']					=	'塔希提島';
	$country['Taiwan']					=	'中國台灣';
	$country['Tajikistan']				=	'塔吉克斯坦';
	$country['Tanzania']				=	'坦桑尼亞';
	$country['Thailand']				=	'泰國';
	$country['Togo']					=	'多哥';
	$country['Trinidad and Tobago']		=	'特立尼達和多巴哥';
	$country['Tunisia']					=	'突尼斯';
	$country['Turkey']					=	'土耳其';
	$country['Turkmenistan']			=	'土庫曼斯坦';
	$country['Turks and Caicos Islands']=	'特克斯和凱科斯群島';
	$country['Tuvalu']					=	'圖瓦盧';
	$country['Uganda']					=	'烏干達';
	$country['Ukraine']					=	'烏克蘭';
	$country['United Arab Emirates']	=	'阿拉伯聯合酋長國';
	$country['United Kingdom']			=	'英國';
	$country['United States']			=	'美國';
	$country['US']						=	'美國';
	$country['Uruguay']					=	'烏拉圭';
	$country['Uzbekistan']				=	'烏茲別克斯坦';
	$country['Vanuatu']					=	'瓦努阿圖';
	$country['Vatican City State']		=	'梵蒂岡';
	$country['Venezuela']				=	'委内瑞拉';
	$country['Vietnam']					=	'越南';
	$country['Virgin Islands(U.S.)']	=	'美屬維爾京群島';
	$country['Wallis and Futuna']		=	'瓦利斯和富圖納';
	$country['Western Sahara']			=	'西撒哈拉';
	$country['Western Samoa']			=	'西薩摩亞';
	$country['Yemen']					=	'也門';
	$country['Zambia']					=	'贊比亞';
	$country['Zimbabwe']				=	'津巴布韋';
$ordersn	= $_REQUEST['ordersn'];
$ordersn		= explode(",",$ordersn);
$Shipping		= $_REQUEST['Shipping'];
			$ostatus		= $_REQUEST['ostatus'];
			
			$keys		    = $_REQUEST['keys'];
			$searchtype		= $_REQUEST['searchtype'];
			$account		= $_REQUEST['acc'];
			$isnote		    = $_REQUEST['isnote'];
			$rcountry		= $_REQUEST['country'];
			$ebay_site		= $_REQUEST['ebay_site'];
			$start		    = $_REQUEST['start'];
			$end		    = $_REQUEST['end'];
			$ebay_ordertype	= $_REQUEST['ebay_ordertype'];
			$status		    = $_REQUEST['status'];
			$hunhe          =$_REQUEST['hunhe'];
	
	$tj		= '';
	for($i=0;$i<count($ordersn);$i++){
		
		
			if($ordersn[$i] != ""){
		
			 $sn			= $ordersn[$i];
			 
		$tj	.= "a.ebay_id='$sn' or ";
			}
			
		
	}
	
	
	$tj		= substr($tj,0,strlen($tj)-3);
	
	if($_REQUEST['ordersn'] == ''){
		
		$status		= $_REQUEST['status'];
		
		$sql			= "select * from ebay_order as a join ebay_orderdetail as b  on a.ebay_ordersn=b.ebay_ordersn where a.ebay_user='$user' and ebay_combine!='1' ";
		
	
	if($ostatus!=='100')
			{
			$sql.=" and ebay_status='$ostatus'";	
		 }
	 if($Shipping!='')
			{
				$sql.=" and ebay_carrier='$Shipping'";
			}
			if($hunhe=='3')
			{
				$sql.=" and (select COUNT( * ) AS cc   from ebay_orderdetail as c where c.ebay_ordersn = a.ebay_ordersn  ) <= 4 ";
			}
			
			if($hunhe=='4')
			{
				$sql.=" and (select COUNT( * ) AS cc   from ebay_orderdetail as c where c.ebay_ordersn = a.ebay_ordersn  ) >=5 and (select COUNT( * ) AS cc   from ebay_orderdetail as c where c.ebay_ordersn = a.ebay_ordersn  ) <= 8 ";
			}
			
			if($hunhe=='5')
			{
				$sql.=" and (select COUNT( * ) AS cc   from ebay_orderdetail as c where c.ebay_ordersn = a.ebay_ordersn  ) >=9 ";
			}
			
			if($hunhe=='0'){
				$sql.=" and (select COUNT( * ) AS cc   from ebay_orderdetail as c where c.ebay_ordersn = a.ebay_ordersn  ) >=2 ";
			}
			
			if($hunhe=='1'){
				$sql.="and (select  sum(ebay_amount) AS cc  from ebay_orderdetail as c where c.ebay_ordersn = a.ebay_ordersn  ) = 1 ";
			}
			
			if($hunhe=='2'){
				$sql.="and (select  sum(ebay_amount) AS cc  from ebay_orderdetail as c where c.ebay_ordersn = a.ebay_ordersn)   > 1  and (select count(*) AS cc from ebay_orderdetail as c where c.ebay_ordersn = a.ebay_ordersn) = 1 ";
			}
			
			
			
			    if($searchtype == '0' && $keys != '')    {$sql	.= " and a.recordnumber			 = '$keys' ";}
				if($searchtype == '1' && $keys != ''){$sql	.= " and a.ebay_userid		 = '$keys' ";}
				if($searchtype == '2' && $keys != ''){$sql	.= " and a.ebay_username	 = '$keys' ";}
				if($searchtype == '3' && $keys != ''){$sql	.= " and a.ebay_usermail	 = '$keys' ";}
				if($searchtype == '4' && $keys != ''){$sql	.= " and a.ebay_ptid		 = '$keys' ";}
				if($searchtype == '5' && $keys != ''){$sql	.= " and a.ebay_tracknumber	 like  '%$keys%' ";}
				if($searchtype == '6' && $keys != ''){$sql	.= " and b.ebay_itemid		 = '$keys' ";}
				if($searchtype == '7' && $keys != ''){$sql	.= " and b.ebay_itemtitle	 = '$keys' ";}
				if($searchtype == '8' && $keys != ''){$sql	.= " and b.sku			 	 = '$keys' ";}
				if($searchtype == '9' && $keys != ''){$sql	.= " and a.ebay_id			 	 = '$keys'";}
				if($searchtype == '10' && $keys != ''){$sql	.= " and (a.ebay_username like '%$keys%' or a.ebay_street like '%$keys%' or a.ebay_street1 like '%$keys%' or a.ebay_city like '%$keys%' or a.ebay_state like '%$keys%' or a.ebay_countryname like '%$keys%' or a.ebay_postcode like '%$keys%' or a.ebay_phone like '%$keys%') ";}
                 if($ebay_ordertype =='申请退款'  ) {$sql.=" and a.moneyback='1'";$ebay_ordertype=-1;}
				if($ebay_ordertype =='同意退款'  ) {$sql.=" and a.moneyback='8'";$ebay_ordertype=-1;}
                if($ebay_ordertype =='取消退款'  ){ $sql.=" and a.moneyback='2'";$ebay_ordertype=-1;}
                if($ebay_ordertype =='同意付款'  ){ $sql.=" and a.moneyback='9'";$ebay_ordertype=-1;}
                if($ebay_ordertype =='完成退款'  ){ $sql.=" and a.moneyback='10'";$ebay_ordertype=-1;}
                if($ebay_ordertype =='追回退款'  ) {$sql.=" and a.moneyback='5'";$ebay_ordertype=-1;}
                if($ebay_ordertype =='查询退款'  ){ $sql.=" and a.moneyback='6'";$ebay_ordertype=-1;}
                if($ebay_ordertype =='确定收款'  ){ $sql.=" and a.moneyback='7'";$ebay_ordertype=-1;}
                if($ebay_ordertype =='无法追踪'  ){ $sql.=" and a.erp_op_id='7'";$ebay_ordertype=-1;}
                if($ebay_ordertype =='妥投错误'  ){ $sql.=" and a.erp_op_id='7'";$ebay_ordertype=-1;}
                if($ebay_ordertype =='中国妥投'  ){ $sql.=" and a.erp_op_id='7'";$ebay_ordertype=-1;}
                if($ebay_ordertype =='已回公司'  ){ $sql.=" and a.erp_op_id=2";$ebay_ordertype=-1;}
				if($ebay_ordertype !='' && $ebay_ordertype !='-1'  ) $sql.=" and a.ebay_ordertype='$ebay_ordertype'";
				
				

				if( $isnote == '1') 	$sql.=" and a.ebay_note	!=''";
				if( $isnote == '0') 	$sql.=" and a.ebay_note	=''";
				if( $ebay_site != '') 	$sql.=" and b.ebay_site	='$ebay_site'";
				
				if($account !="") $sql.= " and a.ebay_account='$account'";
				
				
				
				if($start !='' && $end != ''){
					
					$st00	= strtotime($start." 00:00:00");
					$st11	= strtotime($end." 23:59:59");
					$sql.= " and (a.ebay_paidtime>=$st00 and a.ebay_paidtime<=$st11)";
					
				
				
				}
				$sql.=' group by a.ebay_id ';
	}else{
		
		$sql			= "select * from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn=b.ebay_ordersn where ebay_userid !='' and ($tj) group by a.ebay_id  ";
	}	
	 $sql			= $dbcon->execute($sql);
	 $sql			= $dbcon->getResultArray($sql);
	 
	
	for($i=0;$i<count($sql);$i++){
	

			
		$ebay_noteb			= $sql[$i]['ebay_noteb'];	 

		$sn			= $sql[$i]['ebay_ordersn'];
			
			$carrier				= $sql[$i]['ebay_carrier'];
			$carriersql = "select carrier_sn from ebay_carrier where name='$carrier' and ebay_user='$user'";
			$carriersql			= $dbcon->execute($carriersql);
			$carriersql			= $dbcon->getResultArray($carriersql);
			$carriernumber		= $carriersql[0]['carrier_sn'];
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
			$ebay_tracknumber					= $sql[$i]['ebay_tracknumber'];
			$rr				= "select username,address from ebay_carrier where name='$carrier' and ebay_user='$user'";
			$rr				= $dbcon->execute($rr);
			$rr				= $dbcon->getResultArray($rr);
			$address		= explode('/',$rr[0]['address']);
			$fromuser		=$rr[0]['username'];
			$zip0					= explode("-",$zip);
			if(count($zip0) >=2){
				
				$zip				= $zip0[0];
				
				
			}
			
			
			$isd					= substr($zip,0,1);
			if($isd>=6){
			
			$isd		= '2';
				
				
			}else{
				
			$isd		= '1';	
			}
			
			$tel					= $sql[$i]['ebay_phone'];
			if($tel == 'Invalid Request') $tel = '';
			$street = substr($street1,0,36);
			$citystate = $city.' '.$state;
			$citystate = substr($citystate,0,36);
			switch($countryname){
				case 'USA':
					$number = explode('-',$zip);
					if($number[0]>=0 && $number[0]<=39999){
						$countf_name .= '/JFK';
						break;
					}elseif($number[0]>=40000 && $number[0]<=79999){
						$countf_name .= '/ORD';
						break;
					}else{
						if(($number[0] >= 85000 && $number[0]<= 89199) || ($number[0] >= 90000 && $number[0]<= 89199)){
							$countf_name .= '/LAX';
							break;
						}elseif(($number[0] >= 96700 && $number[0]<= 96899)){
							$countf_name .= '/HNL';
							break;
						}else{
							$countf_name .= '/SFO';
							break;
						}
					}
				case 'United States':
					$number = explode('-',$zip);
					if($number[0]>=0 && $number[0]<=39999){
						$countf_name .= '/JFK';
						break;
					}elseif($number[0]>=40000 && $number[0]<=79999){
						$countf_name .= '/ORD';
						break;
					}else{
						if(($number[0] >= 85000 && $number[0]<= 89199) || ($number[0] >= 90000 && $number[0]<= 89199)){
							$countf_name .= '/LAX';
							break;
						}elseif(($number[0] >= 96700 && $number[0]<= 96899)){
							$countf_name .= '/HNL';
							break;
						}else{
							$countf_name .= '/SFO';
							break;
						}
					}
				case 'Australia':

					$t = substr($zip,0,1);
					if($t>=0 && $t<=2){
						$countf_name .= '/SYD';
						break;
					}elseif($t== 3 || $t== 5 || $t==7 || $t==8){
						$countf_name .= '/MEL';
						break;
					}elseif($t==6){
						$countf_name .= '/PER';
						break;
					}else{
						$countf_name .= '/BNE';
						break;
					}
				case 'Japan':
					$t = substr($zip,0,2);
					if($t >=52 && $t<=93){
						$countf_name .= '/KIX';
						break;
					}else{
						$countf_name .= '/NRT';
						break;
					}
				case 'Canada':
					$t = substr($zip,0,1);
					if($t>='A' && $t <='P'){
						$countf_name .= '/YTO';
						break;
					}elseif($t>='R' && $t <='Y'){
						$countf_name .= '/YVR';
						break;
					}
				case 'India':
					$number = explode('-',$zip);
					if($number[0] == 400){
						$countf_name .= '/BOM';
						break;
					}else{
						$countf_name .= '/CCU';
						break;
					}
			}
 ?>
	<div style="width:91mm;height:66mm;float:left;border:2px solid #000000;padding:2mm;font-size:12px; margin:1px;">
		<div style="width:100%;height:10mm;border-left:1px dashed #000000;border-right:1px dashed #000000;border-bottom:1px solid #000000">
			<?php
				$ee			= "select ebay_amount,sku,ebay_itemtitle from ebay_orderdetail where ebay_ordersn='$sn'";
				 
				$ee			= $dbcon->execute($ee);
				$ee			= $dbcon->getResultArray($ee);

				foreach($ee as $key=>$val){
					 $ebay_amount				= $val['ebay_amount'];
					 $sku						= $val['sku'];
					 $goods_name				= $val['ebay_itemtitle'];
					 $rr			= "select goods_sncombine from ebay_productscombine where ebay_user='$user' and goods_sn='$sku'";
					 $rr			= $dbcon->execute($rr);
					 $rr 	 	= $dbcon->getResultArray($rr);

					if(count($rr) > 0){
						$goods_name = $rr[0]['notes'];
					}else{
					  $uu			= "select goods_name,goods_notes from ebay_goods where goods_sn='$sku' and ebay_user = '$user'";
					  $uu			= $dbcon->execute($uu);
				 	  $uu			= $dbcon->getResultArray($uu);
					  $goods_name = $uu[0]['goods_name'].' '.$uu[0]['notes'];
					}
					echo '<strong>-'.$sku.' '.$goods_name.' 共'.$ebay_amount.'件;</strong> &nbsp;&nbsp; &nbsp;&nbsp;';
				}
			?>
		</div>
		<div style="width:100%;height:3mm;border-bottom:1px solid #000000; line-height:3mm">
			<span style="float:left">B:<?php echo $ebay_userid?></span><span style="float:right">sn: <?php echo date('d-m-Y').' &nbsp;'.($i+1) ;?>/<?php echo count($sql); ?></span>
		</div>
		<div style="width:100%;height:20mm;padding-top:3mm;">
			<div style="width:50%;height:20mm;float:left;">
				<ul style="width:100%;">
					<li style="width:100%; height:4mm; line-height:4mm">From:<?php echo $fromuser;?></li>
					<li style="width:100%; height:4mm; line-height:4mm"><?php echo $address[0];?></li>
					<li style="width:100%; height:4mm; line-height:4mm"><?php echo $address[1];?></li>
					<li style="width:100%; height:4mm; line-height:4mm"><?php echo $address[2];?></li>
				</ul>
			</div>
			<div style="width:45%;height:13mm;float:right">
				<div style="width:96%;height:96%; border:1px solid #000000;font-size:12px;text-align:center">
					<div style="float:left;width:5%; height:100%; line-height:13mm; border-right:1px solid #000000">
						1
					</div>
					<div style="float:left;width:57%; height:100%; line-height:4mm; border-right:1px solid #000000;">
						POSTAGE<br>
						PAID<br>
						HONG KONG
					</div>
					<div style="float:left;width:35%; height:100%; line-height:4mm;">
						PERMIT<br>
						NO.<br>
						<?php echo $carriernumber;?>
					</div>
				</div>
			</div>
		</div>
		<div style='width:100%; position:relative'>
			<div style='width:95%;float:left; font-size:16px; overflow:hidden;'>
				<ul style="margin-left:5px;">
					<li style="width:100%; height:5mm; line-height:5mm"><strong>TO:<span style='margin-left:10px;'><?php echo $name; ?></span></strong></li>
					<li style="width:100%; height:5mm; line-height:5mm"><strong>TEL:</strong><span style='font-size:12px'><?php echo $tel;?></span></li>
					<li style="width:100%; height:5mm; line-height:5mm"><span style='margin-left:38px; font-size:12px'><?php echo $street;?></span></li>
					<li style="width:100%; height:5mm; line-height:5mm"><span style='margin-left:38px; font-size:12px'><?php echo $citystate;?></span></li>
					<li style="width:100%; height:5mm; line-height:5mm"><span style='margin-left:38px; font-size:12px'><?php echo $zip;?></span></li>
					<li style="width:100%; height:5mm; line-height:5mm"><span style='margin-left:38px;'><strong><?php echo $countryname?></strong></span></li>
				</ul>
			</div>
			
			<div style='width:120px; height:20px; position:absolute; bottom:-6px; right:5px;text-align:center;font-size:16px; padding-top:3px'>
			<?php echo $countf_name;?>
			</div>
			<div style='clear:both;'></div>
		</div>
	</div>
	
	
	<?php 
	if(($i+1)%2==0){
		echo "<div style='clear:both;'></div>";
	}
}
?>
</div>
</body>
</html>