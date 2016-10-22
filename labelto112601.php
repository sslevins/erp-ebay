<?php
@session_start();
error_reporting(0);

$user	= $_SESSION['user'];
include "include/dbconnect.php";
date_default_timezone_set ("Asia/Chongqing");
	
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

	$country['Russian Federation']		=   '俄罗斯联邦';

	$country['Afghanistan']				=   '阿富汗';

	$country['Albania']					= 	'阿尔巴尼亚';

	$country['Algeria']					=	'阿尔及利亚';
	
	
	$country['Estonia']					=	'爱沙尼亚';
	
	$country['Indonesia']				=	'印度尼西亚';
	$country['Bosnia and Herzegovina']				=	'波黑';
	$country['Brunei Darussalam']				=	'文莱';
	
	$country['Bosnia and Herzegovina']					=	'波斯尼亚和黑塞哥维那';

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
	$country['USA']					=	'美国';

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
	$country['Brunei Darussalam']       =	'文莱';
	$country['Indonesia']       		=	'印度尼西亚';
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
$country['Russia']				=	'俄国';
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
$country['turkey']					=	'土耳其';
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
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'paypal付款日期');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '邮件名');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '买家 ebay ID');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '物品名');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', '条码编码');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', '图片');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', 'SKU');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', 'SKU对应的中文名称');
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', '中文申报名称');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', '英文申报名称');
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1', '姓名、地址、电话');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', 'CODE');
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1', '数量');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', '价格');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O1', 'Paypal Notes');
	
	$ertj		= "";
	$orders		= explode(",",$_REQUEST['ordersn']);

	for($g=0;$g<count($orders);$g++){

		$sn 	=  $orders[$g];

		if($sn != ""){

				

					$ertj	.= " a.ebay_id='$sn' or";

		}

			

	}

	$ertj			 = substr($ertj,0,strlen($ertj)-3);

	if($ertj == ""){

	

	$sql	= "select * from ebay_order as a where ebay_user='$user' and a.ebay_status='0' and a.ebay_combine!='1' ";	

	}else{	

	$sql	= "select * from ebay_order as a where ($ertj) and ebay_user='$user' and a.ebay_combine!='1' order by  a.ebay_countryname";	

	}	
	


	$countrys	= $_REQUEST['country'];

	
	$sql		= $dbcon->execute($sql);
	$sql		= $dbcon->getResultArray($sql);
	
	
	$a			= 2;	
	
	$filepath	=   dirname(dirname(__FILE__));
	
	for($i=0;$i<count($sql);$i++){
		
		$ebay_id        = $sql[$i]['ebay_id'];
		$ordersn		= $sql[$i]['ebay_ordersn'];
		$paidtime		= date('Y-m-d',strtotime($sql[$i]['ebay_paidtime']));
		$ebay_usermail	= $sql[$i]['ebay_usermail'];
		$ebay_userid	= $sql[$i]['ebay_userid'];	
		$name			= $sql[$i]['ebay_username'];
		$name	 	 	= str_replace("&acute;","'",$name);
		$name  			= str_replace("&quot;","\"",$name);
		
		$paid_time		= @date('Y-m-d',$sql[$i]['ebay_paidtime']);
	    $street1			= @$sql[$i]['ebay_street'];
	    $street2 			= @$sql[$i]['ebay_street1'];
	    $city 				= $sql[$i]['ebay_city'];
	    $state				= $sql[$i]['ebay_state'];
	    $countryname 		= $sql[$i]['ebay_countryname'];

	    $zip				= $sql[$i]['ebay_postcode'];

	    $tel				= $sql[$i]['ebay_phone'];

		$ebay_shipfee		= $sql[$i]['ebay_shipfee'];

		$ebay_note			= $sql[$i]['ebay_note'];
		$ebay_total	 		= @$sql[$i]['ebay_total'];
		$recordnumber		= $sql[$i]['recordnumber'];
		$ebay_account		= $sql[$i]['ebay_account'];
		
		
		
		
		$ebay_currency		= $sql[$i]['ebay_currency'];
		$ebay_signalfh		= '$';
		
		if($ebay_currency == 'USD') $ebay_signalfh = '$';
		if($ebay_currency == 'GBP') $ebay_signalfh = '£';
		
		$totalprice					= $ebay_signalfh." ".$ebay_total;
		
		
		

		$addressline	= $name.chr(10).$street1." ".$street2.chr(10).$city.", ".$state.chr(10).$zip.chr(10).$countryname."(".$country[$countryname].")".chr(10).$tel;
		$addressline	  	= str_replace("&acute;","'",$addressline.chr(10));
		$addressline  		= str_replace("&quot;","\"",$addressline.chr(10));
		$objPHPExcel->setActiveSheetIndex(0)->getCell('A'.$a)->setValueExplicit($paid_time, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('B'.$a)->setValueExplicit($ebay_usermail, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('C'.$a)->setValueExplicit($ebay_userid, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('E'.$a)->setValueExplicit($ebay_id, PHPExcel_Cell_DataType::TYPE_STRING);
		
		$objPHPExcel->setActiveSheetIndex(0)->getCell('K'.$a)->setValueExplicit($addressline, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('L'.$a)->setValueExplicit('*'.$ebay_id.'*', PHPExcel_Cell_DataType::TYPE_STRING);

		$objPHPExcel->setActiveSheetIndex(0)->getCell('N'.$a)->setValueExplicit($totalprice, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->setActiveSheetIndex(0)->getCell('O'.$a)->setValueExplicit($ebay_note, PHPExcel_Cell_DataType::TYPE_STRING);

		$sl				= "select sku,ebay_itemtitle,ebay_amount,attribute,ebay_itemid,ebay_itemprice,ebay_itemurl from ebay_orderdetail where ebay_ordersn='$ordersn'";
		$sl				= $dbcon->execute($sl);

		$sl				= $dbcon->getResultArray($sl);
		
		$xlocation		= 10;
		
		$strline		= '';
		$strline2		= '';
		$strline3		= '';
		
		for($o=0;$o<count($sl);$o++){			

		
			$tt = $a+$o;
			$sku1			= $sl[$o]['sku'];
			$sku			= $sl[$o]['ebay_itemtitle'];
			$amount			= $sl[$o]['ebay_amount'];
			$attribute		= $sl[$o]['attribute'];
			$ebay_itemid			= $sl[$o]['ebay_itemid'];
			$ebay_itemprice	= $sl[$o]['ebay_itemprice'];	
			$pic			= $sl[$o]['ebay_itemurl'];
			
			$bb				= "SELECT * FROM ebay_goods where goods_sn='$sku1' ";   
			$bb				= $dbcon->execute($bb);
			$bb				= $dbcon->getResultArray($bb);
			

			if(count($bb)==0){
				
				$rr			= "select * from ebay_productscombine where ebay_user='$user' and goods_sn='$sku1'";   
				$rr			= $dbcon->execute($rr);
				$rr 	 	= $dbcon->getResultArray($rr);
				$goods_name = $rr[0]['notes'];
			}else{
				$goods_name 		= $bb[0]['goods_name'];
				$goods_ywsbmc	    = $bb[0]['goods_ywsbmc'];
				$goods_zysbmc	   = $bb[0]['goods_zysbmc'];
				
			}
			$objPHPExcel->setActiveSheetIndex(0)->getCell('D'.$tt)->setValueExplicit($sku, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('G'.$tt)->setValueExplicit($sku1, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('M'.$tt)->setValueExplicit($amount, PHPExcel_Cell_DataType::TYPE_STRING);
			
			
			
			$objPHPExcel->setActiveSheetIndex(0)->getCell('H'.$tt)->setValueExplicit($goods_name, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('I'.$tt)->setValueExplicit($goods_zysbmc, PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->setActiveSheetIndex(0)->getCell('J'.$tt)->setValueExplicit($goods_ywsbmc, PHPExcel_Cell_DataType::TYPE_STRING);
			
			
			
			
			
			
			if($user == 'vipyisi'){
			 $pic = $sku1.'.jpg';
			}else{
			
			@$img 	= file_get_contents($pic);
			$pic	= date('Y').date('m').date('d').date('H').date('i').date('s').rand(1000,99999).$user.".jpg";
			file_put_contents($filepath."\\v3-all\images\\".$pic,$img);
			}
			$pic	= 'images/'.$pic;
										
			if(filesize($pic)/1024 <=0){
				$pic	= "failure.jpg";
			}



			
			
			$earchprice		= $ebay_itemprice;
			$strline2		.= $sku1."*".$amount.chr(10);
			$strline		.= $sku.chr(10);
			
			$strline3		.= $ebay_itemid.chr(10);
			
			
			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setName('PHPExcel logo');
			$objDrawing->setDescription('PHPExcel logo');
			$objDrawing->setPath($pic);
			$objDrawing->setHeight(66);
			$objDrawing->setCoordinates('F'.$tt);
			$objDrawing->setOffsetX(10);
			$objDrawing->setRotation(25);
            $objDrawing->getShadow()->setVisible(true);
            $objDrawing->getShadow()->setDirection(45);
				
			$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
			
			
			
			

		}
		$a =$tt;
	
		$a++;
}

$objPHPExcel->getActiveSheet(0)->getStyle('A1:L500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(15);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(20);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(15);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(20);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('K')->setWidth(40);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(15);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(15);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setWidth(10);
$objPHPExcel->setActiveSheetIndex(0)->getRowDimension('F1:F500')->setRowHeight(50);

$objPHPExcel->getActiveSheet(0)->getStyle('L2:L500')->getFont()->setName('C39HrP24DhTt');


$title			= "Delivery_Packlist".date('Y-m-d');
$titlename		= "Delivery_Packlist".date('Y-m-d').".xls";
$objPHPExcel->getActiveSheet()->setTitle($title);
$objPHPExcel->setActiveSheetIndex(0);





	
	



	$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);




header('Content-Type: application/vnd.ms-excel');

header("Content-Disposition: attachment;filename={$titlename}");

header('Cache-Control: max-age=0');



$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

$objWriter->save('php://output');

exit;





