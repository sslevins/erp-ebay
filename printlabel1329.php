<?php
include "include/config.php";
$line = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TNT</title>
<style>
html, body, div, span, applet, object, iframe,h1, h2, h3, h4, h5, h6, p, blockquote, pre,a, abbr, acronym, address, big, cite, code,del, dfn, em, font, img, ins, kbd, q, s, samp,small, strike, strong, sub, sup, tt, var,b, u, i, center,dl, dt, dd, ol, ul, li,fieldset, form, label, legend,table, caption, tbody, tfoot, thead, tr, th, td,p {
 margin: 0;
 padding: 0;
 border: 0;
 outline: 0;
 font-size: 100%;
 background: transparent;
 vertical-align: baseline;
 list-style:none;
}
.noprint { display: none } 
.r{border-right:1px solid #000000;}
.l{border-left:1px solid #000000;}
.t{border-top:1px solid #000000;}
.b{border-bottom:1px solid #000000;}
.textc{text-align:center;}
</style>
 <body style="width:210mm; height:297mm;">
 <div style="width:210mm; height:297mm;">';
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
		
		$sql			= "select * from ebay_order as a where ebay_userid !='' and ($tj)  group by a.ebay_id ";
	}	
	 $sql			= $dbcon->execute($sql);
	 $sql			= $dbcon->getResultArray($sql);
	 //echo '<pre>';
	//print_r($sql);
	for($i=0;$i<count($sql);$i++){
	

			
		$ebay_noteb			= $sql[$i]['ebay_noteb'];	 

		$sn			= $sql[$i]['ebay_ordersn'];
			
			$carrier				= $sql[$i]['ebay_carrier'];
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
			$addressline = '&nbsp;TO:'.$name.'<br><br>&nbsp;'.$street1;
			$dsql = "select sku from ebay_orderdetail where ebay_ordersn='$sn'";
			$dsql	= $dbcon->execute($dsql);
			$dsql	= $dbcon->getResultArray($dsql);
			$skuline = '';
			foreach($dsql as $k=>$v){
				if($k==0){
					$skuline = $v['sku'];
				}else{
					$skuline .= ','.$v['sku'];
				}
			}
			if($street2){
				$addressline .= '<br>&nbsp;'.$street2;
			}
			if($city){
				$addressline .= '<br>&nbsp;'.$city;
			}
			if($state){
				$addressline .= '<br>&nbsp;'.$state;
			}
			$addressline .= '<br>&nbsp;'.$zip.'<br>&nbsp;'.$countryname;
			if($i==0){
				$line .= "<table><tr>";
			}
	$line .= "<td style='width:69mm; height:70mm;'>
	<div style='width:57mm; height:58mm; margin-left:20px;margin-right:10px; border:1px solid #ccc; font-size:15px;font-weight:bold;'>
		<div style='width:100%; height:25px; text-align:right;border-bottom:1px solid #ccc;line-height:30px;'> $skuline&nbsp;</div>
		<div style='width:100%; height:45mm; line-height:20px;border-bottom:1px solid #ccc'> $addressline </div>
		<div style='width:100%; height:10px; '>&nbsp;</div>
	</div></td>";
	if(($i+1)%3==0){
		$line .= "</tr><tr>";
	}
	if(($i+1)%12 ==0){
		$line .= '</tr></table><div style="page-break-after:always;"></div><table><tr>';
	}
}
$line .= '</tr></table></div></body></html>';
//echo $line;
?>
<?php
 $file = fopen("EU Letter_2.doc","w");
 fwrite($file,$line);
 fclose($file);

?>
<script>
	location.href='EU Letter_2.doc';
	//window.close();
</script>