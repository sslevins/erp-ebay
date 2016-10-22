<?php
/*
**11-28 添加盘点记录
**添加人：胡耀龙
*/
include "include/config.php";
$sku	= $_REQUEST['sku'];
$store	= $_REQUEST['store'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>出入库记录</title>
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
.main{
	width:100%;
	font-size:12px;
	text-align:center;
	padding:5px;
 }
 .you{
	border-right:1px solid #ccc;
 }
 .xia{
	border-bottom:1px solid #ccc;
 }
 .s{
	border-top:1px solid #ccc;
 }
 .l{
	border-left:1px solid #ccc;
 }
</style>
</head>
<body>
	<table cellspacing="0" class='main'>
		<tr>
			<td width='49%'>
				<table cellspacing="0" width='100%'>
					<tr height='19'>
						<td valign='middle'  width='40' class='s l you xia'>入库单号</td>
						<td valign='middle' width='20' class='s you xia'>添加时间</td>
						<td valign='middle' width='15' class='s you xia'>sku</td>
						<td valign='middle' width='15' class='s you xia'>仓库</td>
						<td valign='middle' width='15' class='s you xia'>数量</td>
						<td valign='middle' width='15' class='s you xia'>成本</td>
						<td valign='middle' width='15' class='s you xia'>总价</td>
						<td valign='middle' width='15' class='s you xia'>出库类型</td>
						<td valign='middle' width='15' class='s you xia'>审核人</td>
					</tr>
					<?php
						$vv = "select store_name from ebay_store where id=".$store;
						$vv = $dbcon->execute($vv);
						$vv = $dbcon->getResultArray($vv);
						$store_name = $vv[0]['store_name'];
						$sql = "select a.io_type,a.io_ordersn,a.io_addtime,b.goods_count,a.type,a.audituser,b.goods_cost,(b.goods_count*b.goods_cost) as allprice from ebay_iostoredetail as b LEFT JOIN ebay_iostore as a ON b.io_ordersn=a.io_ordersn where b.goods_sn='$sku' and a.io_warehouse='$store' and a.type in ('0','1')  and io_status ='1'";
						$sql		= $dbcon->execute($sql);
						$sql		= $dbcon->getResultArray($sql);
						if($sql){
							foreach($sql as $k=>$v){
								
								
								
								
								if($v['type'] =='0'){
									$type = '<span style="color:green">入库</span>';
								}else{
									$type = '<span style="color:red">出库</span>';
								}
								
								$io_typename	= '';
								
								if($v['io_type'] != ''){
								$st						= "select ebay_storename from ebay_storetype where id='".$v['io_type']."' ";
								

								
								$st 					= $dbcon->execute($st);
								$st 					= $dbcon->getResultArray($st);
								$io_typename			= $st[0]['ebay_storename'];
								}
								
								echo "<tr>";
								echo "<td valign='middle' class='l you xia'>".$v['io_ordersn']."</td>";
								echo "<td valign='middle' class='you xia'>".date('y-m-d',$v['io_addtime'])."</td>";
								echo "<td valign='middle' class='you xia'>".$sku."</td>";
								echo "<td valign='middle' class='you xia'>".$store_name."</td>";
								echo "<td valign='middle' class='you xia'>".$v['goods_count']."</td>";
								echo "<td valign='middle' class='you xia'>".$v['goods_cost']."</td>";
								echo "<td valign='middle' class='you xia'>".$v['allprice']."</td>";
								echo "<td valign='middle' class='you xia'>".$io_typename."</td>";
								echo "<td valign='middle' class='you xia'>".$v['audituser']."</td>";
								echo "</tr>";
							}
						}else{
							echo "<tr><td colspan='9' class='s l you xia'>".$sku."在".$store_name."中没有出入库记录</td></tr>";
						}
						$sql = "select a.pandian_sn,a.add_time,b.pandian_count,a.sh_user from ebay_pandiandetail as b LEFT JOIN ebay_pandian as a ON b.pandian_sn=a.pandian_sn where b.goods_sn='$sku' and a.store_id='$store' and a.status ='1' and a.ebay_user='$user'";
						//echo $sql;
						$sql		= $dbcon->execute($sql);
						$sql		= $dbcon->getResultArray($sql);
						$type = '<span style="color:blue">盘点</span>';
						if($sql){
							foreach($sql as $k=>$v){
								$count = $v['pandian_count']?$v['pandian_count']:0;
								echo "<tr>";
								echo "<td valign='middle' class='l you xia'>".$v['pandian_sn']."</td>";
								echo "<td valign='middle' class='you xia'>".date('y-m-d',$v['add_time'])."</td>";
								echo "<td valign='middle' class='you xia'>".$sku."</td>";
								echo "<td valign='middle' class='you xia'>".$store_name."</td>";
								echo "<td valign='middle' class='you xia'>".$count."</td>";
								echo "<td valign='middle' class='you xia'>0</td>";
								echo "<td valign='middle' class='you xia'>0</td>";
								echo "<td valign='middle' class='you xia'>".$io_typename."</td>";
								echo "<td valign='middle' class='you xia'>".$v['sh_user']."</td>";
								echo "</tr>";
							}
						}else{
							echo "<tr><td colspan='9' class='s l you xia'>".$sku."在".$store_name."中没有出盘点记录</td></tr>";
						}
					?>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>