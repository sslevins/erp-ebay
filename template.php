<?php
include "include/config.php";
$temp = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
    <script src="/js/jquery.js"></script>
    <script src="/js/jquery.artDialog.js?skin=blue"></script>
    <script src="/js/artDialog.iframeTools.js"></script>
    <script src="/js/erpmain.js"></script>
    <script type="text/javascript" src="/js/jquery.poshytip.js"></script>
    <link rel="Stylesheet" type="text/css" href="/js/pg.css" />
</head>
<body>
    <table  style="margin: 0 auto">
   
</table>
<table style="margin: 0 auto">';
$io_ordersn = $_REQUEST['io_ordersn'];
$sql				= "select * from  ebay_iostore where io_ordersn='$io_ordersn'";
$sql				= $dbcon->execute($sql);
$sql				= $dbcon->getResultArray($sql);
$partner 			= $sql[0]['io_partner'];
$vv					= "select * from ebay_partner where company_name='$partner' and ebay_user='$user'";
$vv					= $dbcon->execute($vv);
$vv					= $dbcon->getResultArray($vv);
$temp .= '
 <tr>
        <th  colspan="3">
            单号：'.$io_ordersn.'
        </th>
        <th colspan="4">
            生成日期：'.date("Y-m-d",$sql[0]['io_addtime']).'
        </th>
    </tr>
    <tr>
        <th colspan="3">
            供应商：'.$partner.'
        </th>
        <th colspan="4">
            负责人：'.$sql[0]['io_purchaseuser'].'
        </th>
    </tr>
    <tr>
        <th colspan="3">
            负责人：'.$vv[0]['username'].'
        </th>
        <th colspan="4">
            电话：
        </th>
    </tr>
    <tr>
        <th colspan="3">
            电话：'.$vv[0]['mobile'].'
        </th>
        <th colspan="4">
        </th>
    </tr>
    <tr>
        <th colspan="3">
            交易地址：'.$vv[0]['address'].'
        </th>
        <th colspan="4">
        </th>
    </tr>
    <tr>
        <th>
            序号
        </th>
        <th>
            商品编号
        </th>
        <th>
            图片
        </th>
        <th>
            名称
        </th>
        <th>
            单位
        </th>
        <th>
            数量
        </th>
        <th>
            备注
        </th>
    </tr>';
	$sql	= "select goods_sn,goods_name,goods_unit,goods_count,notes from ebay_iostoredetail where io_ordersn='$io_ordersn'";
	$sql				= $dbcon->execute($sql);
	$sql				= $dbcon->getResultArray($sql);
	foreach($sql as $k=>$v){
		$ss = "select goods_pic,goods_sn from ebay_goods where goods_sn='".$v['goods_sn']."' and  ebay_user='$user'";
		$ss				= $dbcon->execute($ss);
		$ss				= $dbcon->getResultArray($ss);
		$pic			= $ss[0]['goods_pic'];
		if($pic){
		$goods_pic		= "/v3-all/images/".$pic;
		}else{
		$goods_pic		= "/v3-all/images/".$v['goods_sn'].'.jpg';
		}
		$keys = $k+1;
		$temp .= '
        <tr>
            <td>'.$keys.'
            </td>
            <td>'.$v['goods_sn'].'
            </td>
            <td class="img" title="'.$goods_pic.'\' onerror=\'goodsimgerror(this)\'  >">
                <img src="'.$goods_pic.'" width=\'100\' height=\'100\' onerror="goodsimgerror(this)" />
            </td>
            <td class="left">'.$v['goods_name'].'
            </td>
            <td>'.$v['goods_unit'].'
            </td>
            <td>'.$v['goods_count'].'
            </td>
            <td class="left">
				'.$v['notes'].'
            </td>
        </tr>
		';
    }
$temp .= "
</table>
<script>
 $('.img').poshytip({
         className: 'tip-yellowsimple',
         showTimeout: 1,
         alignTo: 'target',
		alignX: 'right',
		alignY: 'center'
     });
  
</script>
</body>
</html>
";
$fielname = '../purchase/'.$io_ordersn.'.html';
$fp = fopen($fielname,'w'); 
fwrite($fp,$temp);
fclose($fp);
echo "<script>location.href	='".$fielname."';</script>";