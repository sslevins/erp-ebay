<?php
	include "include/config.php";
	$ordersn	= substr($_REQUEST['ordersn'],1);
	$ordersn	= explode(",",$ordersn);
	
	
	
	
	
	
	$account 		= $_REQUEST['account'];
	$start	 		= strtotime($_REQUEST['start'].' 00:00:00');
	$end	 		= strtotime($_REQUEST['end'].' 23:59:59');
	$invoice_no	 	= $_REQUEST['invoice_no'];
	
	
	$sql		= "select * from ebay_order where ebay_combine!='1' and ebay_account='$account' and (ebay_paidtime>= $start and ebay_paidtime<= $end) order by ebay_id asc ";	
	$sql   	 	= $dbcon->execute($sql);
	$sql		= $dbcon->getResultArray($sql);
	
	
	$csd		= array();
	$csd['USD'] = "$";
	$csd['GBP'] = "£";
	

	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="zxml.js"></script>
<link rel="stylesheet" href="invoice.css" />
<title>Tracking Information</title>
<style media="print"> 
.noprint { display: none } 
</style> 
<style type="text/css">
<!--
-->

h1 {
	text-transform: uppercase;
	color: #CCCCCC;
	text-align: right;
	font-size: 24px;
	font-weight: normal;
	padding-bottom: 5px;
	margin-top: 0px;
	margin-bottom: 15px;
	border-bottom: 1px solid #CDDDDD;
}

#ic tr td {
	font-size: 10px;
}
#ic tr td table tr td table tr td p strong {
	text-align: right;
}
#ic tr td table tr td table tr td strong {
	font-size: 12px;
}
</style>

<script src="Scripts/AC_ActiveX.js" type="text/javascript"></script>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
</head>
<body>
<script type="text/javascript">
AC_AX_RunContent( 'classid','CLSID:8856F961-340A-11D0-A96B-00C04FD705A2','height','10','id','WB','width','10' ); //end AC code
</script><noscript><OBJECT classid=CLSID:8856F961-340A-11D0-A96B-00C04FD705A2 height=10 id=WB width=10></OBJECT></noscript> 
<script language="JavaScript"> 
self.moveTo(0,0);
self.resizeTo(screen.availWidth,screen.availHeight);
self.focus();
function doPrintSetup(){ 
//打印设置 
WB.ExecWB(8,1) 
} 
function doPrintPreview(){ 
//打印预览 
WB.ExecWB(7,1) 
} 
function doprint(){ 
//直接打印 
WB.ExecWB(6,6) 
} 


function window.onload() { 
idPrint2.disabled = false; 
} 
</script>

<?php
	for($i=0;$i<count($sql);$i++){
		
		
		
		 $sn				= $sql[$i]['ebay_ordersn'];
		 $note				= substr($sql[$i]['ebay_note'],0);
		 $ebay_account		= $sql[$i]['ebay_account'];
		 $ebay_userid		= $sql[$i]['ebay_userid'];
		 $ebay_usermail		= $sql[$i]['ebay_usermail'];
		 $name				= $sql[$i]['ebay_username'];
		 $ebay_id			= $sql[$i]['ebay_id'];
  		$street1			= @$sql[$i]['ebay_street'];
   		$ebay_carrier		= $sql[$i]['ebay_carrier'];
		$ebay_paidtime		= @$sql[$i]['ebay_paidtime'];
		
		
			
		
		$order_no = sprintf("%09d", $invoice_no);
		
		$ebay_paidtime		= date('m/d/Y',$ebay_paidtime);
  
  		$rr						= "select * from ebay_carrier where name='$ebay_carrier' and ebay_user ='$user' ";
		$rr						= $dbcon->execute($rr);
		$rr						= $dbcon->getResultArray($rr);
		$stamp_pic				= $rr[0]['stamp_pic'];
		
		
		$recordnumber 	= @$sql[$i]['recordnumber'];
	   $street2 	= @$sql[$i]['ebay_street1'];
	   $city 		= $sql[$i]['ebay_city'];
	   $state		= $sql[$i]['ebay_state'];
	   $countryname = $sql[$i]['ebay_countryname'];
	   $zip			= $sql[$i]['ebay_postcode'];
	   $tel			= $sql[$i]['ebay_phone'];
$ebay_shipfee			= $sql[$i]['ebay_shipfee'];?>
<table width="100%" align="center" cellpadding="0" cellspacing="0">
  <col width="72" />
  <col width="112" />
  <col width="72" />
  <col width="57" />
  <col width="93" />
  <col width="72" />
  <col width="117" />
  <tr height="25">
    <td width="940" height="25" colspan="4">                   
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><img src="images/yougobay.JPG" width="372" height="112" /></td>
          <td><strong>yoyoBey,S.L.(C.I.F.:B86378700)</strong><br />
            C/Lago salado Numero9 Piso3 Puerta13<br />
            Madrid 28017 Madrid<br />
            España<br />
            Nº de IVA ES B86378700<br />
            http://www.yoyobey.com / http://www.compraloya.es<br />
          servicio@yoyobey.com</td>
        </tr>
      </table>
    <div align="center"></div></td>
  </tr>
  <tr height="21">
    <td height="21" colspan="4">                 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><strong><?php echo $ebay_userid;?></strong></td>
          <td><strong>Nº de factura: <?php echo $order_no;?></strong></td>
        </tr>
        <tr>
          <td>
          <div style="font-size:16px">
          <?php
		  
		  echo $name.' ';
		  echo $street1.' '.$street2.'<br>';
		  echo $city.' '.$state.' '.$zip.'<br>'.$countryname;
		  
		  
		  ?>
          </div>
          &nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
    <div align="center"></div></td>
  </tr>
  <tr height="21">
    <td height="21" colspan="4">               
      <div align="right">
        <table width="30%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td>Fecha</td>
            <td>Nº de historial de ventas</td>
          </tr>
          <tr>
            <td><?php echo $ebay_paidtime;?>&nbsp;</td>
            <td><?php echo $recordnumber;?></td>
          </tr>
        </table>
      </div>
    <div align="center"></div></td>
  </tr>
  <tr height="19">
    <td colspan="4" height="38"><table width="100%" border="1" cellspacing="0" cellpadding="0">
      <tr>
        <td><div align="center"><strong>Cantidad</strong></div></td>
        <td><div align="center"><strong>Nº de artículo</strong></div></td>
        <td><div align="center"><strong>Nombre del artículo</strong></div></td>
        <td><div align="center"><strong>Importe sin IVA</strong></div></td>
        <td><div align="center"><strong>IVA</strong></div></td>
        <td><div align="center"><strong>Precio</strong></div></td>
        <td><div align="center"><strong>Subtotal</strong></div></td>
      </tr>
      <?php
	  
	  		
				$ss			= "select * from ebay_orderdetail where ebay_ordersn = '$sn'";
				$ss			= $dbcon->execute($ss);
				$ss			= $dbcon->getResultArray($ss);
				$totalqty	= 0;
				$toalprice	= 0;
				
				
				$totalincludenot	= 0;
				$totalincludeyes	= 0;
				
				$kk					= 0;
				
				
				for($gg=0;$gg<count($ss);$gg++){
		  		
						$ebay_itemtitle			= $ss[$gg]['ebay_itemtitle'];
						
						
						$ebay_itemprice			= $ss[$gg]['ebay_itemprice'];
						$shipingfee				= $ss[$gg]['shipingfee'];
						$ebay_amount			= $ss[$gg]['ebay_amount'];
						$includenot				= ( $shipingfee + $ebay_itemprice ) / 1.21;
						
						$totalincludenot		+= $includenot;
						
						
						
						$includeyes				= $includenot * 0.21 + $includenot;
						$kk						+= $includenot * 0.21 ;
						
						$totalincludeyes		+= $includeyes * $ebay_amount ;
						
						$ebay_itemid			= $ss[$gg]['ebay_itemid'];
						
						$toalprice				+= $ebay_amount * $ebay_itemprice;
						
						
	  
	  ?>
      
      <tr>
        <td><?php echo $ebay_amount;?>&nbsp;</td>
        <td><?php echo $ebay_itemid;?>&nbsp;</td>
        <td><?php echo $ebay_itemtitle;?>&nbsp;</td>
        <td><?php echo number_format($includenot,2);?>&nbsp;</td>
        <td>21%</td>
        <td><?php echo $includeyes;?></td>
        <td><?php echo $includeyes;?>&nbsp;</td>
      </tr>
          <?php
	  
	  	
		}
		
	  
	  ?>
      
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3"><div align="right">Importe total sin IVA</div></td>
        <td><?php echo number_format($totalincludenot,2);?>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3"><div align="right">Importe del IVA</div></td>
        <td><?php echo number_format($kk,2);?>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3"><div align="right">Cargos (+) o descuentos (-) del vendedor:</div></td>
        <td>0.00</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3"><div align="right">Total incl. IVA</div></td>
        <td><?php echo number_format($totalincludeyes,2);?></td>
      </tr>
      
  
      
    </table></td>
  </tr>
  
  
  
  <tr height="22">
    <td height="22" colspan="4">&nbsp;</td>
  </tr>
</table>
<?php if(($g+1)!=count($sql)){?>
<div style="page-break-after:always;">&nbsp;</div>

<?
    }    
		
		
		
		$invoice_no	= $invoice_no+1;
		
  
  }

  ?>
</body>
</html>
<script language="javascript">
function change(){
var sl = document.getElementById('idPrint2').value;
var table = document.getElementById('ic');
table.className=sl;
}
</script>