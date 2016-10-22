<?php
/**
 * 在线订单操作工具测试demo
 * @package
 * @license
 * @author seaqi
 * @contact 980522557@qq.com / xiayouqiao2008@163.com
 * @version $Id: orderonline_test.php 2011-07-20 15:56:00
 */

header ( "content-type:text/html;charset=utf-8" );
@ini_set("soap.wsdl_cache_enabled", "0"); // disabling WSDL cache
set_time_limit(600);

//【***】为必须参数，其它的可以为空或不写


include '4px/OrderOnlineTools.php';

$soap = new OrderOnlineTools();

/*
 * 运费试算
$arrs = array(
		//货物类型(默认：P)(Length = 1)
		"cargoCode" => 'P',
		//目的国家二字代码，参照国家代码表(Length = 2)
		"countryCode" => 'US',【***】
		//计费结果产品显示级别(默认：1)(Length = 1)
		"displayOrder" => '1',
		//邮编(Length <= 10)
		"postCode" => '518000',
		//产品代码,该属性不为空，只返回该产品计费结果，参照产品代码表(Length = 2)
		"productCode" => 'A1',
		//起运地ID，参照起运地ID表(Length <= 4)
		"startShipmentId" => '13',
		//计费体积，单位(c㎡)(0 < Amount <= [3,3])
		"volume" => '20',
		//计费重量，单位(kg)(0 < Amount <= [3,3])
		"weight" => '0.5'【***】
);
$result = $soap->chargeCalculateService($arrs);
*/



/*
 * 查询轨迹
//订单号码
$arrs = array('T20120705001', 'T20120705002', 'T20120705003');
$result = $soap->cargoTrackingService($arrs);
*/



/* 
 * 申请拦截
//订单号码
$arrs = array('T20120705001', 'T20120705002', 'T20120705003');
$result = $soap->cargoHoldService($arrs);
*/



/*
 * 查询跟踪号
//订单号码
$arrs = array('T20120705001', 'T20120705002', 'T20120705003');
$result = $soap->findTrackingNumberService($arrs);
*/




/* 
 * 打印标签【此接口还没有实现】
//订单号码
$arrs = array('T20120705001', 'T20120705002', 'T20120705003');
$result = $soap->printLableService($arrs);
*/




//运费测试


$arrs = array(
		//货物类型(默认：P)(Length = 1)
		"cargoCode" => 'P',
		//目的国家二字代码，参照国家代码表(Length = 2)
		"countryCode" => 'US',
		//计费结果产品显示级别(默认：1)(Length = 1)
		"displayOrder" => '1',
		//邮编(Length <= 10)
		"postCode" => '518000',
		//产品代码,该属性不为空，只返回该产品计费结果，参照产品代码表(Length = 2)
		"productCode" => 'A1',
		//起运地ID，参照起运地ID表(Length <= 4)
		"startShipmentId" => '13',
		//计费体积，单位(c㎡)(0 < Amount <= [3,3])
		"volume" => '20',
		//计费重量，单位(kg)(0 < Amount <= [3,3])
		"weight" => '0.5'
);

$result = $soap->chargeCalculateService($arrs);






echo '<pre>';
var_dump($result);
echo '</pre>';






