<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>label 80</title>
<style>
 html, body, div, span, p, blockquote,a, font, img, strong, ul, li,fieldset, form, label, table,  tbody, tr, th, td {
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
</head>
<body style="padding:0;margin:0">
<div style="width:80mm; font-family: arial;">
<?php
@session_start();
error_reporting(0);
include "include/dbconnect.php";	
$dbcon	= new DBClass();
$user	= $_SESSION['user'];
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
				$sql.= " group by a.ebay_id ";
	}else{
		
		$sql			= "select * from ebay_order as a where ebay_userid !='' and ($tj)";
	}	
	 $sql			= $dbcon->execute($sql);
	 $sql			= $dbcon->getResultArray($sql);
	 
	
	for($i=0;$i<count($sql);$i++){
	
		$t = $i+1;
		$ebay_note		= $sql[$i]['ebay_note'];	 
		$ebay_id			= $sql[$i]['ebay_id'];	
		$sn			= $sql[$i]['ebay_ordersn'];
		$tx = $ebay_id.'-'.$t;	
			$carrier				= $sql[$i]['ebay_carrier'];
			$ebay_usermail			= $sql[$i]['ebay_usermail'];
			$ebay_userid			= $sql[$i]['ebay_userid'];	
			$name					= $sql[$i]['ebay_username'];
			$street1				= @$sql[$i]['ebay_street'];
			$street2 				= @$sql[$i]['ebay_street1'];
			$city 					= $sql[$i]['ebay_city'];
			$state					= $sql[$i]['ebay_state'];
			$countryname 			= $sql[$i]['ebay_countryname'];
			$countrynamef 			= $country[$countryname];
			$ebay_account 			= $sql[$i]['ebay_account'];
			$zip					= $sql[$i]['ebay_postcode'];
			$tel					= $sql[$i]['ebay_phone'];
			$recordnumber					= $sql[$i]['recordnumber'];
			$ebay_tracknumber					= $sql[$i]['ebay_tracknumber'];
 ?>
	<div style="width:79mm;float:left;border-left:2px solid #000000;padding:0mm;font-size:14px;">
		<div style="width:100%;height:40mm;border-bottom:2px solid #000000;">
			<div><?php echo $ebay_tracknumber;?><span style='font-weight:bold;font-size:16px; margin-top:12px; margin-right:25px;float: right;'><?php echo $tx;?></span>
			<div style="clear:both;"></div></div>
			<img src="barcode128.class.php?data=<?php echo $ebay_id;?>" width="220" height="40" style='margin-top:20px;margin-left:35px;' />
			<div style="margin-left:105px;"><?php echo $ebay_id;?></div>
		</div>
		<div style="width:100%;">
			<ul>
				<li style='border-bottom:2px solid #000000;height:10mm;line-height:10mm;'>
					<div style='width:33%;text-align:center;float:left'>商品编号</div>
					<div style='width:33%;text-align:center;float:left'>品名/规格</div>
					<div style='width:33%;text-align:center;float:left'>数量</div>
				</li>
				<?php
					$totalqty = 0;
					$vv = "select sku,ebay_amount from ebay_orderdetail where ebay_ordersn='$sn'";
					$vv	= $dbcon->execute($vv);
					$vv	= $dbcon->getResultArray($vv);
					foreach($vv as $k=>$v){
						$sku = $v['sku'];
						$amount = $v['ebay_amount'];
						$ss = "select goods_name from ebay_goods where goods_sn='$sku' and ebay_user='$user'";
						$ss	= $dbcon->execute($ss);
						$ss	= $dbcon->getResultArray($ss);
						if(count($ss)>0){
							$totalqty		= $totalqty + $amount;
							echo "<li style='width:100%;height:25px;height:6mm;line-height:6mm'>
									<div style='width:33%;line-height:25px;text-align:center;float:left'> $sku &nbsp;</div>
									<div style='width:33%;line-height:25px;text-align:center;float:left'> ".$ss[0]['goods_name']."/</div>
									<div style='width:33%;line-height:25px;text-align:center;float:left'> $amount &nbsp;</div>
								</li>";
						}else{
							$rr			= "select goods_sncombine from ebay_productscombine where ebay_user='$user' and goods_sn='$sku'";
							$rr			= $dbcon->execute($rr);
							$rr 	 	= $dbcon->getResultArray($rr);
							$goods_sncombine	= $rr[0]['goods_sncombine'];
							$goods_sncombine    = explode(',',$goods_sncombine);	
							for($v=0;$v<count($goods_sncombine);$v++){
								$pline			= explode('*',$goods_sncombine[$v]);
								$goods_sn		= $pline[0];
								$goddscount     = $pline[1] * $amount;
								$totalqty		= $totalqty + $goddscount;
								$uu			= "SELECT goods_name FROM ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
								$uu	= $dbcon->execute($uu);
								$uu	= $dbcon->getResultArray($uu);
								echo "<li style='width:100%;height:25px;'>
									<div style='width:33%;line-height:25px;text-align:center;float:left'> $goods_sn &nbsp;</div>
									<div style='width:33%;line-height:25px;text-align:center;float:left'> ".$uu[0]['goods_name']."/</div>
									<div style='width:33%;line-height:25px;text-align:center;float:left'> $goddscount &nbsp;</div>
								</li>";
							}
						}
					}
				?>
				<li style='width:100%;border-bottom:1px solid #000000; height:20px;'></li>
				<li style='width:100%;border-bottom:2px solid #000000; height:40px;line-height:40px;'>&nbsp;总数：<?php echo $totalqty;?></li>
			</ul>
		</div>
		<div style="width:100%;height:40mm;line-height:25px;">
			&nbsp;客户备注：<?php echo $ebay_note;?>
			<div style='width:100%;margin:40px 5px 0 0; font-size:12px;'>制单时间：<?php echo date('Y-m-d H:i:s');?></div>
		</div>
		
	</div>
	
	
	<?php 
	if(($i+1)!=count($sql)){
		echo "<div style='clear:both;'></div>";
	}
}
?>
</div>
</body>
</html>