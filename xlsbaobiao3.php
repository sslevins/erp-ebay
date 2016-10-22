<?php
@session_start();

error_reporting(0);




	/* 计算香港小包平邮的实际运费 */
	function calchkpost($totalweight,$countryname){
		
		global $dbcon;
		$ss		= "select * from ebay_hkpostcalcfee where countrys like '%$countryname%'";
		$ss		= $dbcon->execute($ss);
		$ss		= $dbcon->getResultArray($ss);
		
		$rate			= $ss[0]['discount']?$ss[0]['discount']:1;
		$kg				= $ss[0]['firstweight'];
		$handlefee		= $ss[0]['handlefee'];
		
		
		$shipfee		= $kg * $totalweight + $handlefee;
		if($rate > 0) $shipfee		= $shipfee * $rate;
		return $shipfee;
						
	
	
	}
	
	/* 计算香港小包挂号的费用 */
	function calchkghpost($totalweight,$countryname){
	
		global $dbcon;
		$ss		= "select * from ebay_hkpostghcalcfee where countrys like '%$countryname%'";
		$ss		= $dbcon->execute($ss);
		$ss		= $dbcon->getResultArray($ss);
		
		$rate			= $ss[0]['discount']?$ss[0]['discount']:1;
		$kg				= $ss[0]['firstweight'];
		$handlefee		= $ss[0]['handlefee'];
		$shipfee		= $kg * $totalweight + $handlefee;
		if($rate > 0) $shipfee		= $shipfee * $rate;
		return $shipfee;
	
	}
	
	
	function calcems($totalweight,$countryname){
		
		global $dbcon;
		$dd		= "SELECT * FROM  `ebay_emscalcfee` where countrys like '%$ebay_countryname%' ";
		$dd		= $dbcon->execute($dd);
		$dd		= $dbcon->getResultArray($dd);
		$firstweight	= $dd[0]['firstweight'];
		$nextweight		= $dd[0]['nextweight'];
		$handlefee		= $dd[0]['handlefee'];
		$discount		= $dd[0]['discount'];
		$firstweight0	= $dd[0]['firstweight0'];
		$files			= $dd[0]['files'];
									
		if($files == '1' && $totalweight <= 0.5){
										
		$firstweight	= $firstweight0;
		}
									
		if($totalweight <= 0.5){
							
		$shipfee	= $firstweight;
						
		}else{
								
		$shipfee	= ceil((($totalweight*1000)/500))*$nextweight + $firstweight + $handlefee;
		}
		
		$shipfee	= $shipfee *$discount;
		return $shipfee;							
	
	}
	
	
	function calceub($totalweight,$countryname){
		
		global $dbcon;
		
		$ss		= "select * from ebay_carrier where ebay_user ='$user' and name ='EUB' ";
		$ss		= $dbcon->execute($ss);
		$ss		= $dbcon->getResultArray($ss);
		$discount				= $ss[0]['discount']?$ss[0]['discount']:1;
		if($totalweight <= 0.05){
		$shipfee	= 6;
		}else{
		$shipfee	= $totalweight * $handlefee;
		}
		return $shipfee;
	}
	
	
	function calcchinapostgh($totalweight,$countryname){
	
			global $dbcon;
			
			$dd		= "SELECT * FROM  `ebay_cpghcalcfee` where countrys like '%$countryname%' ";
			$dd		= $dbcon->execute($dd);
			$dd		= $dbcon->getResultArray($dd);

	
			
			if(count($dd)>=1){
				$firstweight	= $dd[0]['firstweight'];
				$nextweight		= $dd[0]['nextweight'];
				$handlefee		= $dd[0]['handlefee'];
				$discount		= $dd[0]['discount']?$dd[0]['discount']:1;
				$xx0			= $dd[0]['xx0'];
				$xx1			= $dd[0]['xx1'];
			    if($totalweight <= ($xx0/1000)){
				$shipfee	= $firstweight + $handlefee;
				}else{
				$shipfee	= ceil(((($totalweight*1000) -$xx0)/$xx1))*$nextweight + $firstweight + $handlefee;
				}
			}
	

			
			
			return $shipfee;
			
	}
	
	function calchkpypost($totalweight,$countryname){
	
			global $dbcon;
			
			$dd		= "SELECT * FROM  `ebay_cppycalcfee` where countrys like '%$countryname%' ";

			$dd		= $dbcon->execute($dd);
			$dd		= $dbcon->getResultArray($dd);
			

			
			if(count($dd)>=1){
				$firstweight	= $dd[0]['firstweight'];
				$nextweight		= $dd[0]['nextweight'];
				$handlefee		= $dd[0]['handlefee'];
				$discount		= $dd[0]['discount']?$dd[0]['discount']:1;
				$xx0			= $dd[0]['xx0'];
				$xx1			= $dd[0]['xx1'];
			    if($totalweight <= ($xx0/1000)){
				$shipfee	= $firstweight + $handlefee;
				}else{
				$shipfee	= ceil(((($totalweight*1000) -$xx0)/$xx1))*$nextweight + $firstweight + $handlefee;
				}
			}
	
			
			
			return $shipfee;
			
	}
	

$user	= $_SESSION['user'];
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
	
$dbcon	= new DBClass();
require_once 'Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1','序号');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1','交易类型');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1','订单日期');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1','订单号');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1','料号(SKU)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1','订单数量（PCS)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1','仓位号');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1','付款币别');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1','付款金额');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1','实收金额');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1','实时汇率');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1','" 收入折算RMB总额 "');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1','客户国家');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1','客户名称联系地址');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1','email地址');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1','买家note');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q1','发货日期');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R1','货运方式');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S1','货运单号');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T1','重量(Kg)');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U1','邮费');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V1','产品单价RMB/PCS');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W1','包材规格');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X1','包材费用');
	
	
	$start			= strtotime($_REQUEST['start']);
	$end			= strtotime($_REQUEST['end']);
	$account		= $_REQUEST['account'];
	

	$sql	= "select * from ebay_order as a where ebay_user='$user'  and a.ebay_combine!='1' and (a.scantime >=$start and a.scantime <=$end) and ebay_account = '$account' ";



	
		
	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);
	$a		= 2;
	
	for($i=0;$i<count($sql);$i++){
		
		$ordersn				= $sql[$i]['ebay_ordersn'];	
		$paidtime				= date('Y-m-d',$sql[$i]['ebay_paidtime']);
		$scantime				= date('Y-m-d',$sql[$i]['scantime']);
		
		$ebay_usermail			= $sql[$i]['ebay_usermail'];
		$ebay_userid			= $sql[$i]['ebay_userid'];	
		$name					= $sql[$i]['ebay_username'];
	    $street1				= @$sql[$i]['ebay_street'];
	    $street2 				= @$sql[$i]['ebay_street1'];
	    $city 					= $sql[$i]['ebay_city'];
	    $state					= $sql[$i]['ebay_state'];
	    $countryname 			= $sql[$i]['ebay_countryname'];
		$cnname					= $country[$countryname];
	    $zip					= $sql[$i]['ebay_postcode'];
	    $tel					= $sql[$i]['ebay_phone'];
		$ebay_shipfee			= $sql[$i]['ebay_shipfee'];
		$ebay_note				= $sql[$i]['ebay_note'];
		$ebay_total				= @$sql[$i]['ebay_total'];
		$ebay_tracknumber		= @$sql[$i]['ebay_tracknumber'];
		$ebay_account			= @$sql[$i]['ebay_account'];
		$recordnumber0			= @$sql[$i]['recordnumber'];
		
		$strrecordnumber0		= substr($recordnumber0,0,3);
		
		$ebay_carrier			= @$sql[$i]['ebay_carrier'];
		$ebay_phone				= $sql[$i]['ebay_phone'];
		$ebay_currency			= $sql[$i]['ebay_currency']?$sql[$i]['ebay_currency']:'USD';
		
		if($ebay_currency == '-1') $ebay_currency = 'USD';
		
		
		$ss		= "select * from ebay_currency where user ='$user'  and currency ='$ebay_currency'";
		

		
		$ss		= $dbcon->execute($ss);
		$ss		= $dbcon->getResultArray($ss);
		
	
		$rates				= $ss[0]['rates'];
		
		$ebay_ordertype			= $sql[$i]['ebay_ordertype'];
		$packingtype			= $sql[$i]['packingtype'];
		$orderweight2			= $sql[$i]['orderweight2']/1000;
		
		$totalweight			= $orderweight2;
		$ordershipfee			= 0;
		
		if($ebay_carrier == 'EMS'){
		$ordershipfee		= calcems($totalweight,$countryname);
		}
		
		if($ebay_carrier == '香港小包平邮	'){
		$ordershipfee		= calchkpost($totalweight,$countryname);
		}

		if($ebay_carrier == '香港小包挂号'){
		$ordershipfee		= calchkghpost($totalweight,$countryname);
		}
		
		if($ebay_carrier == '中国邮政平邮'){
		$ordershipfee		= calchkpypost($totalweight,$countryname);
		}
		
		if($ebay_carrier == '中国邮政挂号'){
		$ordershipfee		= calcchinapostgh($totalweight,$countryname);
		}
		
		if($ebay_carrier == 'EUB'){
		$ordershipfee		= calceub($totalweight,$countryname);
		}
		
		
		
		
		$ss		= "select * from ebay_packingmaterial where model ='$packingtype' ";
		
		
	
		$ss		= $dbcon->execute($ss);
		$ss		= $dbcon->getResultArray($ss);
		$price	= $ss[0]['price'];
		
		$addressline	= $name.chr(13).$street1." ".$street2.chr(13).$city.' '.$state.chr(13).$countryname;
		
	
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$a, $i+1);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$a, date('Y-m-d'));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$a, $recordnumber0);
		if($strrecordnumber0 == 'CYBS'){
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$a, '线下批发');
		}else{
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$a, '线上交易');
		}
		
		
		$ss		= "select * from ebay_orderdetail where ebay_ordersn ='$ordersn' ";
		$ss		= $dbcon->execute($ss);
		$ss		= $dbcon->getResultArray($ss);
		$strline = '';
		$totalqty = 0;
		$tgoods_cost	= 0;
		$tgoods_price	= 0;
		$goods_location	= '';
		
		if(count($ss) >1){
		for($j=0;$j<count($ss);$j++){
			$sku				= $ss[$j]['sku'];
			$ebay_amount		= $ss[$j]['ebay_amount'];
			$totalqty			+= $ebay_amount;
			$gg 	= "select * from ebay_goods where ebay_user ='$user' and goods_sn ='$sku'";
			$gg		= $dbcon->execute($gg);
			$gg		= $dbcon->getResultArray($gg);
			$goods_price	= $gg[0]['goods_price'];
			$goods_cost		= $gg[0]['goods_cost'];
			$goods_location		= $gg[0]['goods_location'];
			
			$tgoods_cost		+= $goods_cost;
			$tgoods_price		+= $goods_price;
			$strline	.= $sku.' * '.$ebay_amount.' ';
			
			$tgoods_price			= '';
			$goods_cost			= '';
			
			$totalqty			= 1;
			
		}
		}else{
		
		for($j=0;$j<count($ss);$j++){
			$sku				= $ss[$j]['sku'];
			$ebay_amount		= $ss[$j]['ebay_amount'];
			$totalqty			+= $ebay_amount;
			$gg 	= "select * from ebay_goods where ebay_user ='$user' and goods_sn ='$sku'";
			$gg		= $dbcon->execute($gg);
			$gg		= $dbcon->getResultArray($gg);
			$goods_price	= $gg[0]['goods_price'];
			$goods_cost		= $gg[0]['goods_cost'];
			$goods_location		= $gg[0]['goods_location'];
			
			$tgoods_cost		+= $goods_cost;
			$tgoods_price		+= $goods_price;
			$strline	.= $sku ;
		}
		
		}
		
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$a, $strline);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$a, $totalqty);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$a, $goods_location);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$a, $ebay_currency);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$a, $ebay_total);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$a, $countryname);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$a, $addressline);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$a, $ebay_usermail);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$a, $scantime);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$a, $ebay_carrier);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$a, $ebay_tracknumber);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$a, $orderweight2);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$a, $ordershipfee);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$a, $ebay_note);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.$a, $packingtype);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.$a, $price);
		
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$a, $goods_cost);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$a, $rates);
	
	$a++;

}
$objPHPExcel->getActiveSheet(0)->getStyle('A1:N500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(10);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(25);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(15);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(18);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(15);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(15);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(10);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(15);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(10);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth(25);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setWidth(10);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setWidth(15);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('M')->setWidth(15);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('K')->setWidth(10);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('L')->setWidth(10);

$objPHPExcel->getActiveSheet(0)->getStyle('A1:M500')->getAlignment()->setWrapText(true);




$title		= "Files_FHQD".date('Y-m-d');
$titlename		= "Files_FHQD".date('Y-m-d').".xls";

$objPHPExcel->getActiveSheet()->setTitle($title);

$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename={$titlename}");
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;


