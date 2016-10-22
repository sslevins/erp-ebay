<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>A6地址打印</title>
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
<?php
@session_start();
$title	= "---";
error_reporting(0);
include "include/dbconnect.php";
$dbcon	= new DBClass();
$user	= $_SESSION['user'];
$ordersn	= $_REQUEST['bill'];
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
			 
		$tj	.= "ebay_id='$sn' or ";
			}
			
		
	}
	
	
	$tj		= substr($tj,0,strlen($tj)-3);
	
	if($_REQUEST['bill'] == ''){
		
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
		
		$sql			= "select * from ebay_order  where  ($tj)  order by ebay_id desc  ";
	}	
	
	

	
	 $sql			= $dbcon->execute($sql);
	 $sql			= $dbcon->getResultArray($sql);
	 
	$strat = 0;
	for($i=0;$i<count($sql);$i++){
	

		$ebay_id			= $sql[$i]['ebay_id'];	 
		$ebay_noteb			= $sql[$i]['ebay_noteb'];	 

		$sn			= $sql[$i]['ebay_ordersn'];
		$ebay_total			= $sql[$i]['ebay_total'];
			
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
			$ebay_currency 			= $sql[$i]['ebay_currency'];
			$countf_name 			= $country[$countryname];
			$ebay_account 			= $sql[$i]['ebay_account'];
			$zip					= $sql[$i]['ebay_postcode'];
			$recordnumber					= $sql[$i]['recordnumber'];
			$ebay_tracknumber					= $sql[$i]['ebay_tracknumber'];
			
			
			
			
			
			
			$sl	= "select * from ebay_orderdetail where ebay_ordersn='$sn'";
			$sl	= $dbcon->execute($sl);
			$sl	= $dbcon->getResultArray($sl);
			
			
			
			$linestr				= '';
			$totalsbjz				= 0 ;
			
		
			for($o=0;$o<count($sl);$o++){			
		
			$sku	= $sl[$o]['sku'];
			$amount	= $sl[$o]['ebay_amount'];
			$rr			= "select * from ebay_productscombine where ebay_user='$user' and goods_sn='$sku'";
			$rr			= $dbcon->execute($rr);
			$rr 	 	= $dbcon->getResultArray($rr);
			if(count($rr) > 0){
				
				
									$goods_sncombine	= $rr[0]['goods_sncombine'];
									$goods_sncombine    = explode(',',$goods_sncombine);	
									
									
									for($e=0;$e<count($goods_sncombine);$e++){
											$pline			= explode('*',$goods_sncombine[$e]);
											$goods_sn		= $pline[0];
											$goddscount     = $pline[1] * $amount;
											
											
											$yy			= "select * from ebay_goods where goods_sn='$goods_sn'";
											$yy			= $dbcon->execute($yy);
											$yy			= $dbcon->getResultArray($yy);
											$goods_name	= $yy[0]['goods_name'];
											$goods_ywsbmc	= $yy[0]['goods_ywsbmc'];
											$goods_location	= $yy[0]['goods_location'];
											$totalsbjz 	+= $yy[0]['goods_sbjz'];
											$linestr	.= $goods_ywsbmc.'*'.$goddscount.' ';
											
									}
									
									
			}else{
			
			
			$yy			= "select * from ebay_goods where goods_sn='$sku'";
			$yy			= $dbcon->execute($yy);
			$yy			= $dbcon->getResultArray($yy);
			
			$goods_ywsbmc	= $yy[0]['goods_ywsbmc'];
			$goods_location	= $yy[0]['goods_location'];
			$totalsbjz 	+= $yy[0]['goods_sbjz'];
			$linestr	.= $goods_ywsbmc.'*'.$amount.' ';
			
			}
			
			
			}
 ?>
	<div style="width:102mm;height:146mm;float:left;border:1px solid #000000;margin:3px;">
		<div style="width:100%;border-bottom:0px solid #000000; height:20mm; margin-left:20px">
        
        <div style="float:left;width:20%;height:5mm;line-height:4mm;border-right:0px solid #000000;text-align:  left; font-size:12px; margin-top:20px">Order No.<br><?php echo $ebay_id;?><BR><BR><span style="font-size:22px; font-weight:bold">TO:</span></div>
		<div style="float:left; text-align:center; color:red; width:59%;height:12mm;line-height:15mm;">	<img src='a.jpg' width="280" height="95" style='margin:1mm 1mm 0.5mm 1mm;'>		
            </div>
            			<div style='clear:both;'></div>

            
            </div>
		<div style='width:100%; height:282px; position:relative'>
			<div style='width:70%;float:left;margin-left:18px; margin-top:3px;  overflow:hidden;color:red; font-size:20px'>
				<ul style="margin:20px;">
					<li style="width:100%; line-height:6.5mm"><strong><?php echo $name; ?></strong></li>
					<li style="width:100%; line-height:6.5mm"><?php echo $street1;?></span></li>
					<?php if($street2){?>
					<li style="width:100%; line-height:6.5mm"><?php echo $street2;?></span></li>
					<?php } ?>
					<li style="width:100%; line-height:6.5mm"><?php echo $city;?> &nbsp;<?php echo $state.' '.$zip;?></li>
					<li style="width:100%; line-height:6.5mm"><?php echo $countryname?> &nbsp;</li>
					<?php if($tel != '' ){ ?> <li style="width:100%; line-height:6.5mm"><strong>TEL.<?php echo $tel?></strong></li> <?php } ?>
				</ul>
			</div>
			
			<div style='width:98%; height:105px; position:absolute; bottom:0px; left:0px;text-align:center;font-size:16px; border-bottom:0px solid #000000; border-top:0px solid #000000;border-right:0px solid #000000;'>
			<?php if($ebay_tracknumber){?>
			<img src="barcode128.class.php?data=<?php echo $ebay_tracknumber;?>" width="360" height="100" style='margin:20px 4px 5px 4px;' />
			<div style="font-size:16px; color:red"><strong> <?php echo $ebay_tracknumber;?></strong></div>
			<?php } ?>
			</div>
			<div style='clear:both;'></div>
		</div>
        <br />
<br />

        
        <div style="width:100%;border-bottom:0px solid #000000; height:20mm; font-size:13px; margin-left:21px">
    From：wengfengting ,zhenningdonglu177#,<br />
zhenhaiqu,ningbo,china,315200.
<br />
        Content: <?php echo $linestr;?><br />
        
        total price: <?php 
		
		if($totalsbjz >= 28 ) $totalsbjz = 28;
		
		echo $totalsbjz.' USD';?><br />

        
		 <?php
		 $bb		= "select sku,ebay_amount from ebay_orderdetail where ebay_ordersn ='$sn' ";
		 $gg		= $dbcon->execute($bb);
		 $gg		= $dbcon->getResultArray($gg);
		 $allnum = 0;
		 foreach($gg as $k=>$v){
			$sku = $v['sku'];
			$sss = "select goods_sncombine from ebay_productscombine where goods_sn='$sku' and ebay_user='$user'";
			$sss		= $dbcon->execute($sss);
			$sss		= $dbcon->getResultArray($sss);
			if(count($sss)>0){
				$goods_sncombine = explode(',',$sss[0]['goods_sncombine']);
				$allnum += count($goods_sncombine); 
			}else{
				$allnum++;
			}
		 }
		 $gg		= $dbcon->execute($bb);
		 $gg		= $dbcon->getResultArray($gg);
		 $z= 0;
		 if($allnum<=2){$height = 50;}else{if($allnum<=4){$height = 25;}else{$height=18;}}
		 foreach($gg as $k=>$v){
			$sku = $v['sku'];
			$sss = "select goods_name from ebay_goods where goods_sn='$sku' and ebay_user='$user'";
			$sss		= $dbcon->execute($sss);
			$sss		= $dbcon->getResultArray($sss);
			if(count($sss)>0){
				$goods_name = '';

				echo ' '.$sku.'+'.$goods_name.'*'.$v['ebay_amount'].'<input type="checkbox" />';
				$z++;
				if($z%2==0){
					if($z==$allnum){
						echo '</tr>';
					}else{
						echo '</tr><tr>';
					}
				}else{
					if($z==$allnum){
						echo '<td style="width:50%;height:18px;">&nbsp;</td></tr>';
					}
				}
			}else{
				$sss = "select goods_sncombine from ebay_productscombine where goods_sn='$sku' and ebay_user='$user'";
				$sss		= $dbcon->execute($sss);
				$sss		= $dbcon->getResultArray($sss);
				$goods_sncombine = explode(',',$sss[0]['goods_sncombine']);
				foreach($goods_sncombine as $kkk=>$vvv){
					$goods = explode('*',$vvv);
					$skucom = $goods[0];
					$amount = $v['ebay_amount']*$goods[1];
					$zzz = "select goods_name from ebay_goods where goods_sn='$skucom' and ebay_user='$user'";
					$zzz		= $dbcon->execute($zzz);
					$zzz		= $dbcon->getResultArray($zzz);
					$goods_name = '';

					echo ''.$skucom.' '.$goods_name.'*'.$amount.'<input type="checkbox" />';
					$z++;
					if($z%2==0){
						if($z==$allnum){
							echo '</tr>';
						}else{
							echo '</tr><tr>';
						}
					}else{
						if($z==$allnum){
							echo '  ';
						}
					}
				}
			}
			
		 }
		 ?>

</div>
        
	</div>
	
	
	<?php 
		if(($i+1)%2==0) echo "<div style='clear:both;'></div>";
		if(($i+1)%4==0)echo "<div style='page-break-after: always;'></div>";
}
?>
</div>
</body>
</html>