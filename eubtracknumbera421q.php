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

	
	
	for($i=0;$i<count($ordersn);$i++){
	
		
		if($ordersn[$i] != ""){
		
			 $sn			= $ordersn[$i];
		     $ss			= "select * from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn=b.ebay_ordersn where a.ebay_ordersn='$sn'";
			
			 

		
			 $ss			= $dbcon->execute($ss);
			 $ss			= $dbcon->getResultArray($ss);
			 
			$ebay_usermail			= $ss[0]['ebay_usermail'];
			$ebay_userid			= $ss[0]['ebay_userid'];	
			$name					= $ss[0]['ebay_username'];
			$street1				= @$ss[0]['ebay_street'];
			$street2 				= @$ss[0]['ebay_street1'];
			$city 					= $ss[0]['ebay_city'];
			$state					= $ss[0]['ebay_state'];
			$countryname 			= $ss[0]['ebay_countryname'];
			$ebay_account 			= $ss[0]['ebay_account'];
			$zip					= $ss[0]['ebay_postcode'];
			$recordnumber					= $ss[0]['recordnumber'];
			$ebay_tracknumber					= $ss[0]['ebay_tracknumber'];
			
			
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
			
			$tel					= $ss[0]['ebay_phone'];
			if($tel == 'Invalid Request') $tel = '';
			
			if($street2 == ''){
				
				$addressline	= $name."<br>".$street1."<br>".$city." ".$state."<br>".$countryname." ".$zip;
				
			}else{
				
				
				$addressline	= $name."<br>".$street1."<br>".$street2."<br>".$city." ".$state."<br>".$countryname." ".$zip;
			}
			
			
			


 ?>
<table width="56%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="370"><table width="554" border="0" cellspacing="0" cellpadding="0" style="border:#000000 1px solid; width:96mm; height:115mm">
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0" style=" margin-left:5px">
          <tr>
            <td width="20%" style=" margin-right:120px"><table width="84%" height="74" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #000; text-align:center; margin-right:">
              <tr>
                <td width="100" height="72" ><font style="font-family:Arial; font-size:74px">F</font>&nbsp;</td>
                </tr>
              </table></td>
            <td width="54%" align="center"><table width="78%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center"><img src="01.jpg" width="109" height="31" ></td>
                </tr>
              <tr>
                <td align="center">&nbsp;</td>
                </tr>
              <tr>
                <td align="center"><img src="02.jpg" width="177" height="30" />&nbsp;</td>
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
          <div style="font-family:Arial, Helvetica, sans-serif; font-size:7px"></div>
</td>
      </tr>
      <tr>
        <td height="105"><table width="100%" border="0" cellspacing="0" cellpadding="2" style=" border-bottom:#000 1px solid; border-top:#000 1px solid">
          <tr>
            <td width="59%" valign="top" style="border-right:#000 1px solid">
              
              
              
  <div style="font-family:Arial, Helvetica, sans-serif; font-size:8px; margin-left:5px">
    VIVIAN FAN E015<br />
    117 QIPU RD ZHABEI<br />
    SHANGHAI SHANGHAI<br />
    CHINA 200085                      </div></td>
            <td width="41%" rowspan="2" valign="top"><table width="100%" border="0" cellspacing="3" cellpadding="0"><tr><td align="center"><table width="100%" border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td align="center"><div style=" font-family: Code 128; font-size:48px"><?php echo '420'.$zip;?> </div></td>
              </tr>
              <tr>
                <td align="center"><div style="font-size:12px"><strong>ZIP <?php echo $zip;?></strong></div></td>
              </tr>
            </table></td>
              </tr>
            </table></td>
            </tr>
          <tr>
            <td height="43" valign="bottom" style="border-right:#000 1px solid"><div style="font-family:Arial, Helvetica, sans-serif; font-size:5.2px; margin-top:10px ;margin-left:5px; vertical-align:bottom"> Customs information avaliable on attached CN22.<br />
              USPS Personnel Scan barcode below for delivery event information </div></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td height="33" valign="top"><table width="100%" height="106" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="15%" height="106" style=" border-right: 1px solid #000
            "><div style="font-family:Arial, Helvetica, sans-serif; font-size:16px; margin-left:5px">To:</div>
              &nbsp;</td>
            <td width="85%"><div style="font-family:Arial; font-size:10px"><?php echo $addressline; ?> </div>
              &nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td valign="bottom" style="border-bottom:0px"><table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-bottom:#000 5px solid; border-top:#000 5px solid">
          <tr>
            <td height="109" style="border-right:#000 1px solid; font-size: 9px;"><table width="100%" border="0" cellspacing="5" cellpadding="0">
              <tr>
                  <td align="center"><span style=" font-family: Arial, Helvetica, sans-serif; font-size:16px"><strong>USPS DELIVERY CONFIRMATION</strong></span>&reg;</td>
                </tr>
                <tr>
                  <td align="center"><div style=" font-family: Code 128; font-size:48px"><?php echo $ebay_tracknumber;?> </div></td>
                </tr>
                <tr>
                  <td align="center"><div style="font-size:12px"><strong><?php echo $ebay_tracknumber;?></strong></div></td>
                </tr>
            </table></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td width="369" valign="top"><table width="554" height="449" border="0" cellpadding="0" cellspacing="0" style="border:#000000 1px solid; width:96mm; height:115mm; font-size: 9px; font-family: Arial, Helvetica, sans-serif;">
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
                  </div>
                  </td>
                  <td><table width="70%" height="32" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #000; text-align:center; margin-right:">
                    <tr>
                      <td width="100" height="20" ><font style="font-family:Arial; font-size:24px"><?php echo $isd;?></font>&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
              </table></td>
              <td width="47%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="center"><div style=" font-family: Code 128; font-size:48px"><?php echo $ebay_tracknumber;?> </div></td>
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
            <td width="52%" style="border-bottom: 1px solid #000; border-right: 1px #000 solid"><div style="font-family:Arial; font-size:11px; "> FROM:VIVIAN FAN E015<br />
              117 QIPU RD ZHABEI<br />
              SHANGHAI SHANGHAI<br />
              CHINA  200085 <br />
              <br />
              <br />
              PHONE:18603006655</div></td>
            <td width="48%" rowspan="2" valign="top" style="border-top:#000 solid 1px"><div style=" font-size:12px">SHIP TO:John <?php echo $addressline; ?></div></td>
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
                <td align="center"  style="border-bottom: 1px solid #000; border-right:#000 1px solid">Val(No Qty (US $)</td>
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
				 
				 for($e=0;$e<count($ee);$e++){
					 
					 $ebay_amount				= @$ss[$e]['ebay_amount'];
					 $sku						= @$ss[$e]['sku'];
					 $recordnumber				= @$ss[$e]['recordnumber'];
					   
					  
					  $uu			= "select * from ebay_goods where goods_sn='$sku'";
					  $uu			= $dbcon->execute($uu);
				 	  $uu			= $dbcon->getResultArray($uu);
					  
					  
					  $tqty							+= $ebay_amount;
					  
					  
					  $goods_ywsbmc		= $uu[0]['goods_ywsbmc']." ".$uu[0]['goods_zysbmc'];
					  $goods_weight		= $uu[0]['goods_weight'];
					  $goods_sbjz		= $uu[0]['goods_sbjz'];
					  $goods_name		= $uu[0]['goods_name'];
					  $goods_register		= $uu[0]['goods_register']?$uu[0]['goods_register']:1;
					  $tgoods_sbjz						+= $goods_sbjz;	
					  $tweight						    += (($goods_weight)*($ebay_amount*$goods_register));
				
					  
					  
			  		  $strline			.= $recordnumber.".".$sku."=".$goods_name.'*'.($ebay_amount*$goods_register)."/";
					  
			  ?>
              
              <tr>
                <td align="center"  style=" border-right:#000 1px solid"><?php echo $e+1;?>&nbsp;</td>
                <td align="center"  style=" border-right:#000 1px solid"><?php echo $ebay_amount;?>&nbsp;</td>
                <td height="100%" align="center"  style=" border-right:#000 1px solid"><?php echo $goods_ywsbmc;?>&nbsp;</td>
                <td align="center"  style=" border-right:#000 1px solid"><?php echo $goods_weight;?>&nbsp;</td>
                <td align="center"  style=" border-right:#000 1px solid"><?php echo $goods_sbjz;?>&nbsp;</td>
                <td align="center"  style=" ">China&nbsp;</td>
              </tr>
              <?php } ?>
              
              <tr>
                <td align="center"  style="border-right:#000 1px solid; border-top: #000 1px solid;">&nbsp;</td>
                <td align="center"  style="border-right:#000 1px solid; border-top: #000 1px solid;"><?php echo $tqty;?>&nbsp;</td>
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
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td><div style="font-family:Arial; font-size:6px">I certify the particulars given in this customs declaration are correct. This item does not contain any dangerous article, or articles prohibited by<br />
          legislation or by postal or customs regulations. I have met all applicable export filing requirements under the Foreign Trade Regulations. </div>        </td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><div style="font-family:Arial; font-size:8px"><strong>Sender's Signature &amp; Date Signed:</strong></div></td>
              <td align="left"><div style="font-family:Arial; font-size:18.5px; text-align:left">CN22</div></td>
            </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><?php echo substr($strline,0,strlen($strline)-1); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
</table>

<?php 

if($i%2 == 0) echo '<div style="page-break-after:always;">&nbsp;</div>';


}} ?>
</body>
</html>
