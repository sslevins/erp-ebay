<?php
include "include/config.php";
$ordersn	= $_REQUEST['bill'];
$ordersn		= explode(",",$ordersn);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>EUB</title>
</head>

<body>

<?php

	
	$tj		= '';
	for($i=0;$i<count($ordersn);$i++){
		
		
			if($ordersn[$i] != ""){
		
			 $sn			= $ordersn[$i];
			 
		$tj	.= "a.ebay_id='$sn' or ";
			}
			
		
	}
	
	
	$tj		= substr($tj,0,strlen($tj)-3);
	
	if($_REQUEST['bill'] == ''){
		
		$status		= $_REQUEST['status'];
		
		$ss			= "select * from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn=b.ebay_ordersn where ebay_userid !='' and ebay_combine!='1' and ebay_status='$status' group by a.ebay_id order by b.sku asc ";
		
	}else{
		
		$ss			= "select * from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn=b.ebay_ordersn where ebay_userid !='' and ($tj) group by a.ebay_id order by b.sku asc ";
	}
	 
	 $ss			= $dbcon->execute($ss);
	 $ss			= $dbcon->getResultArray($ss);
	 

	
	
	for($i=0;$i<count($ss);$i++){
	

			
			 

$sn			= $ss[$i]['ebay_ordersn'];
			 
			$ebay_usermail			= $ss[$i]['ebay_usermail'];
			$ebay_userid			= $ss[$i]['ebay_userid'];	
			$name					= $ss[$i]['ebay_username'];
			$street1				= @$ss[$i]['ebay_street'];
			$street2 				= @$ss[$i]['ebay_street1'];
			$city 					= $ss[$i]['ebay_city'];
			$state					= $ss[$i]['ebay_state'];
			$countryname 			= $ss[$i]['ebay_countryname'];
			$ebay_account 			= $ss[$i]['ebay_account'];
			$zip					= $ss[$i]['ebay_postcode'];
			$recordnumber					= $ss[$i]['recordnumber'];
			$ebay_tracknumber					= $ss[$i]['ebay_tracknumber'];
			
			
			
		$rr				= "select * from ebay_account where ebay_account='$ebay_account'";
		$rr				= $dbcon->execute($rr);
		$rr				= $dbcon->getResultArray($rr);
		$id				= $rr[0]['id'];
		$rr				= "select * from eub_account where pid='$id'";
		$rr					= $dbcon->execute($rr);
		$rr					= $dbcon->getResultArray($rr);
		$dname					= $rr[0]['dname'];
		$dstreet					= $rr[0]['dstreet'];
		$dcity					= $rr[0]['dcity'];
		$dprovince					= $rr[0]['dprovince'];
			$dzip					= $rr[0]['dzip'];
			$dtel					= $rr[0]['dtel'];
			
			$zip0					= explode("-",$zip);
			if(count($zip0) >=2){
				
				$zip				= $zip0[0];
				
				
			}
			
			
			$isd					= substr($zip,0,1);
			if($isd>=6){
			
			$isd		= '2';
				
				
			}else{
				
			$isd		= '1';	
			}
			
			$tel					= $ss[$i]['ebay_phone'];
			if($tel == 'Invalid Request') $tel = '';
			
			if($street2 == ''){
				
				$addressline	= "<strong>".$name."</strong><br>".$street1."<br>".$city." ".$state."<br>".$countryname." ".$zip;
				
			}else{
				
				
				$addressline	= "<strong>".$name."</strong><br>".$street1." ".$street2."<br>".$city." ".$state."<br>".$countryname." ".$zip;
			}
			
			
			


 ?>
<table  border="0" cellspacing="0" cellpadding="0" style="border:#000000 1px solid; width:110mm; height:100mm">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style=" margin-left:5px">
      <tr>
        <td width="20%" style=" margin-right:120px"><table width="84%" height="70" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #000; text-align:center; margin-right:">
          <tr>
            <td width="100" height="72" ><font style="font-family:Arial; font-size:74px">F</font>&nbsp;</td>
          </tr>
        </table></td>
        <td width="54%" align="center"><table width="78%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center"><img src="01.jpg" width="109" height="31" /></td>
          </tr>
          <tr>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td align="center"><img src="02.jpg" width="177" height="30" /></td>
          </tr>
        </table></td>
        <td width="26%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center"><table width="66" border="0" cellspacing="4" cellpadding="0" style="border:1px solid #000; text-align:center; margin-top:5px; margin-right:5px">
              <tr>
                <td width="47" height="45" align="left"><span style="font-family:Arial, Helvetica, sans-serif; font-size:7px; line-height:10px">Aimail<br />
                  Postage Paid<br />
                  China Post </span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="center"><font style="font-family:Arial; font-size:16px"><?php echo $isd;?></font>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="7" colspan="3" valign="top" style=" margin-right:120px"><span style="font-family:Arial, Helvetica, sans-serif; font-size:7px">From:</span></td>
      </tr>
    </table>
        <div style="font-family:Arial, Helvetica, sans-serif; font-size:7px"></div></td>
  </tr>
  <tr>
    <td height="100"><table width="100%" border="0" cellspacing="0" cellpadding="2" style=" border-bottom:#000 1px solid; border-top:#000 1px solid">
      <tr>
        <td width="59%" valign="top" style="border-right:#000 1px solid"><div style="font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-left:2px"> <?php echo $dname;?><br />
                  <?php echo $dstreet;?><br />
                  <?php echo $dcity;?>&nbsp; <?php echo $dprovince;?><br />
          CHINA <?php echo $dzip.'-'.$recordnumber.'('.$ebay_userid.')';?> </div></td>
        <td width="41%" rowspan="2" valign="top"><table width="100%" border="0" cellspacing="3" cellpadding="0">
          <tr>
            <td align="center"><table width="100%" border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td align="center"><div style=" "> <img src="barcode128.class.php?data=<?php echo '420'.$zip;?>" width="140" height="52" /> </div></td>
              </tr>
              <tr>
                <td align="center"><div style="font-size:12px"><strong>ZIP <?php echo $zip;?></strong></div></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="43" valign="bottom" style="border-right:#000 1px solid"><div style="font-family:Arial, Helvetica, sans-serif; font-size:6.2px; margin-top:6px ;margin-left:5px; vertical-align:bottom"> Customs information avaliable on attached CN22.<br />
          USPS Personnel Scan barcode below for delivery event information </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="33" valign="top"><table width="100%" height="106" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="15%" height="106" style=" border-right: 1px solid #000
            "><div style="font-family:Arial, Helvetica, sans-serif; font-size:14px; margin-left:5px">To:</div>
           
        </td>
        <td width="85%"><div style="font-family:Arial; font-size:15px"><strong><?php echo $addressline; ?></strong></div>
          </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="bottom" style="border-bottom:0px"><table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-bottom:#000 5px solid; border-top:#000 5px solid">
      <tr>
        <td height="109" style="border-right:#000 1px solid; font-size: 9px;"><table width="100%" border="0" cellspacing="5" cellpadding="0">
          <tr>
            <td align="center"><span style=" font-family: Arial, Helvetica, sans-serif; font-size:14px"><strong>USPS DELIVERY CONFIRMATION</strong></span>&reg;</td>
          </tr>
          <tr>
            <td align="center"><div > <img src="barcode128.class.php?data=<?php echo $ebay_tracknumber;?>" width="241" height="56" /></div></td>
          </tr>
          <tr>
            <td align="center"><div style="font-size:12px"><strong><?php echo $ebay_tracknumber;?></strong></div></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<div style="page-break-after:always;">&nbsp;</div>
<table width="554" height="396" border="0" cellpadding="0" cellspacing="0" style="border:#000000 1px solid; width:110mm; height:115mm; font-size: 9px; font-family: Arial, Helvetica, sans-serif;">
  <tr>
    <td height="85" valign="top"><div style="font-family:Arial, Helvetica, sans-serif; font-size:7px">
      <table width="100%" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td colspan="2" valign="top"><img src="01.jpg" alt="" width="120" height="32" /></td>
            </tr>
            <tr>
              <td valign="top"><div style="font-family:Arial; font-size:7px">IMPORTANT:
                The item/parcel may be<br />
                opened officially.<br />
                Please print in English<br />
              </div></td>
              <td><table width="70%" height="32" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #000; text-align:center; margin-right:">
                <tr>
                  <td width="100" height="20" ><font style="font-family:Arial; font-size:24px"><?php echo $isd;?></font>&nbsp;</td>
                </tr>
              </table></td>
            </tr>
          </table></td>
          <td width="47%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="center"><div style=""><img src="barcode128.class.php?data=<?php echo $ebay_tracknumber;?>" alt="" width="233" height="60" /></div></td>
            </tr>
            <tr>
              <td align="center"><div style="font-size:12px"><strong><?php echo $ebay_tracknumber;?></strong></div></td>
            </tr>
          </table></td>
        </tr>
      </table>
    </div></td>
  </tr>
  <tr>
    <td height="91" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="52%" style="border-bottom: 1px solid #000; border-right: 1px #000 solid"><div style="font-family:Arial; font-size:10px; "> FROM:<?php echo $dname;?><br />
                  <?php echo $dstreet;?><br />
                  <?php echo $dcity;?>&nbsp; <?php echo $dprovince;?><br />
          CHINA <?php echo $dzip;?> <br />
          <br />
          <br />
          PHONE:<?php echo $dtel;?></div></td>
        <td width="48%" rowspan="2" valign="top" style="border-top:#000 solid 1px"><div style=" font-size:12px">SHIP TO: <?php echo $addressline; ?></div></td>
      </tr>
      <tr >
        <td style="border-bottom: 1px solid #000; border-right:#000 solid 1px"><div style=" font-size:12px">Fees(US $):</div></td>
      </tr>
      <tr >
        <td height="16" style="border-bottom: 1px solid #000; border-right:#000 solid 1px"><div style="font-family:Arial; font-size:12px">Certificate No.</div></td>
        <td style="border-bottom: 1px solid #000"><div style=" font-size:12px">PHONE: <?php echo $tel;?></div></td>
      </tr>
      <tr >
        <td height="16" colspan="2" style="border-bottom: 1px solid #000; border-right:#000 solid 1px"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center"  style="border-bottom: 1px solid #000; border-right:#000 1px solid">No</td>
            <td align="center"  style="border-bottom: 1px solid #000; border-right:#000 1px solid">Qty</td>
            <td align="center"  style="border-bottom: 1px solid #000; border-right:#000 1px solid">Description of Contents</td>
            <td align="center"  style="border-bottom: 1px solid #000; border-right:#000 1px solid">Kg.</td>
            <td align="center"  style="border-bottom: 1px solid #000; border-right:#000 1px solid">Val（us$）
</td>
            <td align="center"  style="border-bottom: 1px solid #000; ">Goods Origin</td>
          </tr>
          <?php 
			  
			     $ee			= "select * from ebay_orderdetail as a where a.ebay_ordersn='$sn'";
				 
				 $ee			= $dbcon->execute($ee);
				 $ee			= $dbcon->getResultArray($ee);
				 
				 $tqty			= 0;
				 $tweight		= 0;
				 $tgoods_sbjz		= 0;
				 $tebay_itemprice	= 0;
				 
				 $strline		= '';
				 
				 
				 $stabline		= '';
				 
				 $countjs		= 1;
				 
				 for($e=0;$e<count($ee);$e++){
					 
					 
					 
					 
					 $ebay_amount				= @$ee[$e]['ebay_amount'];
					 $sku						= @$ee[$e]['sku'];
					 $recordnumber				= @$ee[$e]['recordnumber'];
					 if(strstr($sku,'+')){
						 
						 $cstr		= explode('+',$sku);
						 
						for($h=0;$h<count($cstr);$h++){						
								
									$sku		= $cstr[$h];
									
									if($sku != ''){
								 $uu			= "select * from ebay_goods where goods_sn='$sku' and ebay_user='$user'";
								 
							
								 
								  $uu			= $dbcon->execute($uu);
								  $uu			= $dbcon->getResultArray($uu);
								  
							
								  
								  $tqty							+= $ebay_amount;
								  $goods_ywsbmc		= $uu[0]['goods_ywsbmc']." ".$uu[0]['goods_zysbmc'].' '.$sku;
								  $goods_weight		= $uu[0]['goods_weight'];
								  $goods_sbjz		= $uu[0]['goods_sbjz'];
								  $goods_name		= $uu[0]['goods_name'];
								  $goods_register		= $uu[0]['goods_register']?$uu[0]['goods_register']:1;
								  $tgoods_sbjz						+= $goods_sbjz;	
								  $tweight						    += (($goods_weight)*($ebay_amount*$goods_register));
			  				  	  $strline			.= $recordnumber.".".$sku."=".$goods_name.'*'.($ebay_amount*$goods_register)."/";
								
		
									$stabline.= '  <tr>
                <td align="center"  style=" border-right:#000 1px solid;border-bottom: 1px solid #000;">'.$countjs.'&nbsp;</td>
                <td align="center"  style=" border-right:#000 1px solid;border-bottom: 1px solid #000;">'.$ebay_amount.'&nbsp;</td>
                <td height="100%" align="center"  style=" border-right:#000 1px solid;border-bottom: 1px solid #000;">'.$goods_name.$sku.'&nbsp;</td>
                <td align="center"  style=" border-right:#000 1px solid;border-bottom: 1px solid #000;">'.number_format($goods_weight,2).'&nbsp;</td>
                <td align="center"  style=" border-right:#000 1px solid;border-bottom: 1px solid #000;">'.number_format($goods_sbjz,2).'&nbsp;</td>
                <td align="center"  style=" ">China&nbsp;</td>
              </tr>';
			  
			  
			  $countjs++;
			  
									}
						}		
						 
						
					 }else{
						 

					  $uu			= "select * from ebay_goods where goods_sn='$sku'";
					  
					  
					  $uu			= $dbcon->execute($uu);
				 	  $uu			= $dbcon->getResultArray($uu);
					  $tqty							+= $ebay_amount;
					  $goods_ywsbmc		= $uu[0]['goods_ywsbmc']." ".$uu[0]['goods_zysbmc'];
					  $goods_weight		= $uu[0]['goods_weight'];
					  $goods_sbjz		= $uu[0]['goods_sbjz'];
					  $goods_name		= $uu[0]['goods_name'];
					  
					  $goods_location		= $uu[0]['goods_location'];
					  
					  
					  $goods_register		= $uu[0]['goods_register']?$uu[0]['goods_register']:1;
					  $tgoods_sbjz						+= $goods_sbjz;	
					  $tweight						    += (($goods_weight)*($ebay_amount*$goods_register));
			  		  $strline			.= $recordnumber.".".$sku."=".$goods_name.'*'.($ebay_amount*$goods_register)."/";
					  
					  
					  
					  	$stabline.= '  <tr>
                <td align="center"  style=" border-right:#000 1px solid;border-bottom: 1px solid #000;">'.$countjs.'&nbsp;</td>
                <td align="center"  style=" border-right:#000 1px solid;border-bottom: 1px solid #000;"><strong>'.$ebay_amount.'</strong>&nbsp;</td>
                <td height="100%" align="center"  style=" border-right:#000 1px solid;font-size:12px;border-bottom: 1px solid #000;"><strong>'.$goods_name.' '.$sku.'</strong>&nbsp;</td>
                <td align="center"  style=" border-right:#000 1px solid;border-bottom: 1px solid #000;">'.$goods_weight.'&nbsp;</td>
                <td align="center"  style=" border-right:#000 1px solid;border-bottom: 1px solid #000;">'.$goods_sbjz.'&nbsp;</td>
                <td align="center"  style=" ">China&nbsp;</td>
              </tr>';
			  
			  
			  $countjs++;
			  
			  
					 }
					 
					  
					  
					
		

					


					  
			  ?>
          <?php }  	echo $stabline;
	?>
          <tr>
            <td align="center"  style="border-right:#000 1px solid; border-top: #000 1px solid;">&nbsp;</td>
            <td align="center"  style="border-right:#000 1px solid; border-top: #000 1px solid;"><strong><?php echo $tqty;?></strong>&nbsp;</td>
            <td align="left"  style="border-top: #000 1px solid; "><div style=" font-size:10px">Total Gross Weight (Kg.):</div></td>
            <td align="center"  style=" border-right:#000 1px solid;border-top: #000 1px solid; "><?php echo $tweight;?>&nbsp;</td>
            <td align="center"  style= "border-right:#000 1px solid; border-top: #000 1px solid;"><?php echo $tgoods_sbjz;?>&nbsp;</td>
            <td align="center"  style=" border-top: #000 1px solid;">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="12" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="35"><div style="font-family:Arial; font-size:6px">I certify the particulars given in this customs declaration are correct. This item does not contain any dangerous article, or articles prohibited by<br />
      legislation or by postal or customs regulations. I have met all applicable export filing requirements under the Foreign Trade Regulations. </div></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div style="font-family:Arial; font-size:8px"><strong>Sender's Signature &amp; Date Signed:</strong></div></td>
        <td align="left"><div style="font-family:Arial; font-size:18.5px; text-align:left">CN22</div></td>
      </tr>
    </table></td>
  </tr>
</table>
<?php 

if(($i+1)%1 == 0 && $i != (count($ss) -1)) echo '<div style="page-break-after:always;">&nbsp;</div>';


} ?>
</body>
</html>