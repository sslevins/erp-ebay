<?php
@session_start();
error_reporting(0);
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
	$country['Estonia']					=	'爱沙尼亚';
	$country['USA']						=	'美国';
	$country['Bosnia and Herzegovina']	=	'波斯尼亚和黑塞哥维那';
	
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

	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', '图片');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', '数量');
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', '图片');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '数量');
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', '图片');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', '数量');
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', '图片');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', '数量');
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1', '图片');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1', '数量');
	


	
	
	$ertj		= "";

	$orders		= explode(",",$_REQUEST['ordersn']);
	$ostatus	= $_REQUEST['ostatus'];
	
	for($g=0;$g<count($orders);$g++){

		$sn 	=  $orders[$g];

		if($sn != ""){

				

					$ertj	.= " a.ebay_id='$sn' or";

		}

			

	}

	$ertj			 = substr($ertj,0,strlen($ertj)-3);

	if($ertj == ""){

	

	$sql	= "select ebay_amount AS total, b.ebay_itemtitle,ebay_itemurl from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn = b.ebay_ordersn  where a.ebay_user='$user' and a.ebay_status = '$ostatus' and a.ebay_combine!='1' ";	

	
	}else{	

	$sql	= "select ebay_amount AS total, b.ebay_itemtitle,ebay_itemurl,sku from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn = b.ebay_ordersn where ($ertj) and a.ebay_user='$user' and a.ebay_combine!='1' ";	
		

	}	

$filepath	=   dirname(dirname(__FILE__));
	
	$countrys	= $_REQUEST['country'];


	$deliverytime	= date('m')."月".date('d')."日";

	
	$sql		= $dbcon->execute($sql);
	$sql		= $dbcon->getResultArray($sql);
	$a			= 2;	
	
	$dd			= 0;
	
	
	for($i=0;$i<count($sql);$i++){
		

			$total		= $sql[$i]['total'];
			$pic			= $sql[$i]['ebay_itemurl'];
			$sku		= $sql[$i]['sku'];
			
			
			@$img 	= file_get_contents($pic);
			$pic	= date('Y').date('m').date('d').date('H').date('i').date('s').rand(1000,99999).$user.".jpg";

			file_put_contents($filepath."\\htdocs\images\\".$pic,$img);
			$pic	= 'images/'.$pic;
			if(filesize($pic)/1024 <=0){
				$pic	= "failure.jpg";
			}
			
			
			
			if($user == 'viphcx') $total		= $sku.' x '.$total;
			
			
			
			
			
			/* 第一列 */
			$objPHPExcel->setActiveSheetIndex(0)->getCell('B'.$a)->setValueExplicit($total, PHPExcel_Cell_DataType::TYPE_STRING);
			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setName('PHPExcel logo');
			$objDrawing->setDescription('PHPExcel logo');
			$objDrawing->setPath($pic);
			$objDrawing->setHeight(76);
			$objDrawing->setCoordinates('A'.$a);
			$objDrawing->setOffsetX($xlocation);
			$objDrawing->setRotation(25);
            $objDrawing->getShadow()->setVisible(true);
            $objDrawing->getShadow()->setDirection(45);
			$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
			
			
			$i++;
			/* 第二列 */
			$total		= $sql[$i]['total'];
			if($total != ''){
			$pic			= $sql[$i]['ebay_itemurl'];
			
			
			$sku		= $sql[$i]['sku'];
			if($user == 'viphcx') $total		= $sku.' x '.$total;
			@$img 	= file_get_contents($pic);
			$pic	= date('Y').date('m').date('d').date('H').date('i').date('s').rand(1000,99999).$user.".jpg";
			file_put_contents($filepath."\\htdocs\images\\".$pic,$img);
			$pic	= 'images/'.$pic;
			if(filesize($pic)/1024 <=0){
				$pic	= "failure.jpg";
			}
			
			
			
			$objPHPExcel->setActiveSheetIndex(0)->getCell('D'.$a)->setValueExplicit($total, PHPExcel_Cell_DataType::TYPE_STRING);
			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setName('PHPExcel logo');
			$objDrawing->setDescription('PHPExcel logo');
			$objDrawing->setPath($pic);
			$objDrawing->setHeight(76);
			$objDrawing->setCoordinates('C'.$a);
			$objDrawing->setOffsetX($xlocation);
			$objDrawing->setRotation(25);
            $objDrawing->getShadow()->setVisible(true);
            $objDrawing->getShadow()->setDirection(45);
			$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
			}
			
			$i++;
			/* 第三 列 */
			$total		= $sql[$i]['total'];
			if($total != ''){
			$pic			= $sql[$i]['ebay_itemurl'];
			
			$sku		= $sql[$i]['sku'];
			if($user == 'viphcx') $total		= $sku.' x '.$total;
			
			@$img 	= file_get_contents($pic);
			$pic	= date('Y').date('m').date('d').date('H').date('i').date('s').rand(1000,99999).$user.".jpg";
			file_put_contents($filepath."\\htdocs\images\\".$pic,$img);
			$pic	= 'images/'.$pic;
			if(filesize($pic)/1024 <=0){
				$pic	= "failure.jpg";
			}
			
			
			
			$objPHPExcel->setActiveSheetIndex(0)->getCell('F'.$a)->setValueExplicit($total, PHPExcel_Cell_DataType::TYPE_STRING);
			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setName('PHPExcel logo');
			$objDrawing->setDescription('PHPExcel logo');
			$objDrawing->setPath($pic);
			$objDrawing->setHeight(76);
			$objDrawing->setCoordinates('E'.$a);
			$objDrawing->setOffsetX($xlocation);
			$objDrawing->setRotation(25);
            $objDrawing->getShadow()->setVisible(true);
            $objDrawing->getShadow()->setDirection(45);
			$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
			}
			
			$i++;
			/* 第4列 */
			$total		= $sql[$i]['total'];
			if($total != ''){
			$pic			= $sql[$i]['ebay_itemurl'];
			$sku		= $sql[$i]['sku'];
			if($user == 'viphcx') $total		= $sku.' x '.$total;
			
			
			@$img 	= file_get_contents($pic);
			$pic	= date('Y').date('m').date('d').date('H').date('i').date('s').rand(1000,99999).$user.".jpg";
			file_put_contents($filepath."\\htdocs\images\\".$pic,$img);
			$pic	= 'images/'.$pic;
			if(filesize($pic)/1024 <=0){
				$pic	= "failure.jpg";
			}
			
			
			
			$objPHPExcel->setActiveSheetIndex(0)->getCell('H'.$a)->setValueExplicit($total, PHPExcel_Cell_DataType::TYPE_STRING);
			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setName('PHPExcel logo');
			$objDrawing->setDescription('PHPExcel logo');
			$objDrawing->setPath($pic);
			$objDrawing->setHeight(76);
			$objDrawing->setCoordinates('G'.$a);
			$objDrawing->setOffsetX($xlocation);
			$objDrawing->setRotation(25);
            $objDrawing->getShadow()->setVisible(true);
            $objDrawing->getShadow()->setDirection(45);
			$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
			}
			
			$i++;
			/* 第5列 */
			$total		= $sql[$i]['total'];
			if($total != ''){
			$pic			= $sql[$i]['ebay_itemurl'];
			$sku		= $sql[$i]['sku'];
			if($user == 'viphcx') $total		= $sku.' x '.$total;
			
			
			@$img 	= file_get_contents($pic);
			$pic	= date('Y').date('m').date('d').date('H').date('i').date('s').rand(1000,99999).$user.".jpg";
			file_put_contents($filepath."\\htdocs\images\\".$pic,$img);
			$pic	= 'images/'.$pic;
			if(filesize($pic)/1024 <=0){
				$pic	= "failure.jpg";
			}
			
			
			
			$objPHPExcel->setActiveSheetIndex(0)->getCell('J'.$a)->setValueExplicit($total, PHPExcel_Cell_DataType::TYPE_STRING);
			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setName('PHPExcel logo');
			$objDrawing->setDescription('PHPExcel logo');
			$objDrawing->setPath($pic);
			$objDrawing->setHeight(76);
			$objDrawing->setCoordinates('I'.$a);
			$objDrawing->setOffsetX($xlocation);
			$objDrawing->setRotation(25);
            $objDrawing->getShadow()->setVisible(true);
            $objDrawing->getShadow()->setDirection(45);
			$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
			}
			
			$objPHPExcel->setActiveSheetIndex(0)->getRowDimension($a)->setRowHeight(60);	
			
			if(($i+1) %5 == 0){
			
			$a++;
			
			
			}
			





}

$objPHPExcel->getActiveSheet(0)->getStyle('A1:B500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet(0)->getStyle('C1:C500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
$objPHPExcel->getActiveSheet(0)->getStyle('E1:E500')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(13);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(7);

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(13);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(7);	

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(13);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(7);	

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('G')->setWidth(13);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('H')->setWidth(7);	

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('I')->setWidth(13);	
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('J')->setWidth(7);	



$title			= "CG".date('Y-m-d');
$titlename		= "CG".date('Y-m-d').".xls";
$objPHPExcel->getActiveSheet()->setTitle($title);
$objPHPExcel->setActiveSheetIndex(0);

header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename={$titlename}");
header('Cache-Control: max-age=0');


$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

$objWriter->save('php://output');

exit;





