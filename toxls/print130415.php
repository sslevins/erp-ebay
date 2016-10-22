<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- saved from url=(0031)http://print.4px.com/printlabel -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title></title>
<link href="tableS.css" rel="stylesheet" type="text/css">
</head>
<body>
<center>


 <table cellspacing="15">
    
    
       <tbody>
       
       
<?php

	
	include "../include/config.php";
	
	
			$ertj		= "";
	$orders		= explode(",",$_REQUEST['ordersn']);
	for($g=0;$g<count($orders);$g++){
		$sn 	=  $orders[$g];
		if($sn != ""){
				
					$ertj	.= " a.ebay_id='$sn' or";
		}
			
	}
	$ertj			 = substr($ertj,0,strlen($ertj)-3);
	
	
	if($ertj == ""){
	$sql	= "select * from ebay_order as a where ebay_user='$user' and a.ebay_status='1' and a.ebay_combine!='1' ";	
	}else{	
	$sql	= "select *  from ebay_order as a   where ($ertj) and a.ebay_user='$user' and a.ebay_combine!='1'  ";	
	}
	

	
	
	$sql	= $dbcon->execute($sql);
	$sql	= $dbcon->getResultArray($sql);




	$a = 2;
	
	
	
	$coujtjs		= 0;
	
	
	for($i=0;$i<count($sql);$i++){
		
			
			$ebay_username				= $sql[$i]['ebay_username'];	
			$recordnumber				= $sql[$i]['recordnumber'];	
			$ebay_phone					= $sql[$i]['ebay_phone'];	
			$ebay_id					= $sql[$i]['ebay_id'];	
			$ebay_ordersn				= $sql[$i]['ebay_ordersn'];	
			$ebay_total					= $sql[$i]['ebay_total'];	
			$ebay_usermail				= $sql[$i]['ebay_usermail'];
			$ebay_street				= $sql[$i]['ebay_street'];
			$ebay_street1				= $sql[$i]['ebay_street1'];
			$ebay_city					= $sql[$i]['ebay_city'];
			$ebay_state					= $sql[$i]['ebay_state'];
			$ebay_postcode					= $sql[$i]['ebay_postcode'];
			$ebay_couny					= $sql[$i]['ebay_couny'];
			$ebay_countryname					= $sql[$i]['ebay_countryname'];
			$ebay_carrier					= $sql[$i]['ebay_carrier'];
			$ebay_account					= $sql[$i]['ebay_account'];
			$ebay_currency					= $sql[$i]['ebay_currency'];
			$detailstreet				= $ebay_street.'<br>'.$ebay_street1.'<br>'.$ebay_city.' , '.$ebay_state.' , '.$ebay_postcode;
						$ebay_userid					= $sql[$i]['ebay_userid'];

		
			
			$coujtjs					= $coujtjs + 1;
			

?>
<tr>
    
    <td class="tab_td" valign="top" style="border-left: 1px;border: 1px;table-layout: fixed;word-wrap:break-word;border-bottom-style: dashed;border-left-style: dashed;border-right-style: dashed;border-top-style: dashed;"><table cellpadding="0" cellspacing="0" class="tabBq">
      <tbody>
        <tr>
          <td valign="top" align="left" style="border: 0px; font-size: 8px; padding: 0px; width: 2.5cm; font-style: italic;"><b>Return Mail Address:</b> <br></td>
          <td align="right" valign="top" style="width: 4.5cm; font-size: 25px"><b><?php echo $ebay_couny;?></b>
            <div style="font-size: 18px"> <b> </b> </div></td>
        </tr>
        <tr>
          <td valign="top" colspan="2" style="border: 0px; border-top: 0px; border-top-style: dashed; width: 7cm; padding: 1px; height: 1.5cm" align="left"><div style="font-size: 15px; float: left; word-spacing: normal; width: 6.5cm;"> <b style="font-size: 13px;">To:&nbsp;</b> <b style="font-size: 13px;"> <?php echo $ebay_username;?></b> <br>
            <?php echo $detailstreet;?> &nbsp; <br>
            <strong><?php echo $ebay_countryname;
			
			
			$hh		= "select * from ebay_countrys where countryen='$ebay_countryname' and ebay_user ='$user'";
			
			$hh		= $dbcon->execute($hh);
			$hh		= $dbcon->getResultArray($hh);
			echo '&nbsp;&nbsp;&nbsp;&nbsp;'.$hh[0]['countrycn'];
			?></strong></div></td>
        </tr>
        <tr>
          <td style="border: 0px" colspan="2"><table border="0" cellpadding="1" cellspacing="1" style="border-bottom: 0; border-left: 0; border-right: 0; border-top: 0; font-size: 8px; width: 7cm; table-layout: fixed;">
            <tbody>
              <tr>
                <td style="width: 7cm;" align="center" colspan="2"><table cellpadding="0" cellspacing="0">
                  <tbody>
                    <tr>
                      <td align="center" valign="top" style="font-size: 10px"><b> <?php echo $ebay_id; ?> </b></td>
                      </tr>
                    <tr>
                      <td align="center"><img src="../barcode128.class.php?data=<?php echo $ebay_id; ?>" alt="" width="159" height="38"/></td>
                      </tr>
                    </tbody>
                  </table></td>
              </tr>
              <tr>
                <td style="font-size: 6px; border: 0px" colspan="2" align="left"><div style="font-size: 8px; border: 0px" colspan="2" align="left">
                  <?php
				
				
				
						  	$sl	= "select * from ebay_orderdetail where ebay_ordersn='$ebay_ordersn'";
						$sl	= $dbcon->execute($sl);
						$sl	= $dbcon->getResultArray($sl);
					
						for($o=0;$o<count($sl);$o++){			
						
							$imagepic = $sl[$o]['ebay_itemurl'];
							$sku	= $sl[$o]['sku'];
							$amount	= $sl[$o]['ebay_amount'];
							
								$ssr			= "select goods_name from ebay_goods where goods_sn='$sku' and ebay_user ='$user'";
								$ssr	= $dbcon->execute($ssr);
								$ssr	= $dbcon->getResultArray($ssr);
						
						
								$goods_location   = $ssr[0]['goods_location'];
								$goods_name   = $ssr[0]['goods_name'];
								
						
						
						
							echo $sku.' '.$ssr[0]['goods_name'].' * '.$amount.' '.$goods_location.' ';
						
                            
						}
						
						
						echo '<br>'.$ebay_carrier.' '.$ebay_userid;
							?>
                  
                  
                  
                  
                  
                  
                  </div></td>
              </tr>
            </tbody>
          </table></td>
        </tr>
      </tbody>
    </table>      &nbsp;</td>
    
    
        
    
    
    <td class="tab_td" valign="top" style="border-left: 1px;border: 1px;table-layout: fixed;word-wrap:break-word;border-bottom-style: dashed;border-left-style: dashed;border-right-style: dashed;border-top-style: dashed;">
    
    <?php
			$i++;
			$ebay_username				= $sql[$i]['ebay_username'];	
			
			
			if($ebay_username != '' ){
				
				
			$coujtjs					= $coujtjs + 1;

			$recordnumber				= $sql[$i]['recordnumber'];	
			$ebay_phone					= $sql[$i]['ebay_phone'];	
			$ebay_id					= $sql[$i]['ebay_id'];	
			$ebay_ordersn				= $sql[$i]['ebay_ordersn'];	
			$ebay_total					= $sql[$i]['ebay_total'];	
			$ebay_usermail				= $sql[$i]['ebay_usermail'];
			$ebay_street				= $sql[$i]['ebay_street'];
			$ebay_street1				= $sql[$i]['ebay_street1'];
			$ebay_city					= $sql[$i]['ebay_city'];
			$ebay_state					= $sql[$i]['ebay_state'];
			$ebay_postcode					= $sql[$i]['ebay_postcode'];
			$ebay_couny					= $sql[$i]['ebay_couny'];
			$ebay_countryname				= $sql[$i]['ebay_countryname'];
			$ebay_carrier					= $sql[$i]['ebay_carrier'];
			$ebay_userid					= $sql[$i]['ebay_userid'];
			
			$ebay_account					= $sql[$i]['ebay_account'];
			$ebay_currency					= $sql[$i]['ebay_currency'];
			$detailstreet				= $ebay_street.'<br>'.$ebay_street1.'<br>'.$ebay_city.' , '.$ebay_state.' , '.$ebay_postcode;
	
			
	
	 ?>
    <table cellpadding="0" cellspacing="0" class="tabBq">
	<tbody><tr>
		<td valign="top" align="left" style="border: 0px; font-size: 8px; padding: 0px; width: 2.5cm; font-style: italic;">
			<b>Return Mail Address:</b> <br> 
			
		</td>
		<td align="right" valign="top" style="width: 4.5cm; font-size: 25px">
			<b><?php echo $ebay_couny;?></b> 
			<div style="font-size: 18px">
				<b>     
			    </b>
			</div>
		</td>
	</tr>
	<tr>
		<td valign="top" colspan="2" style="border: 0px; border-top: 0px; border-top-style: dashed; width: 7cm; padding: 1px; height: 2.5cm" align="left">
			<div style="font-size: 15px; float: left; word-spacing: normal; width: 6.5cm;">
				<b style="font-size: 13px;">To:&nbsp;</b> 
				<b style="font-size: 13px;"> <?php echo $ebay_username;?></b>
			    <br>
				<?php echo $detailstreet;?>
				
			       &nbsp;
			    <br>
			    <strong><?php echo $ebay_countryname;
			$hh		= "select * from ebay_countrys where countryen='$ebay_countryname' and ebay_user ='$user'";
			$hh		= $dbcon->execute($hh);
			$hh		= $dbcon->getResultArray($hh);
			echo '&nbsp;&nbsp;&nbsp;&nbsp;'.$hh[0]['countrycn'];
			?></strong></div>
		</td>
	</tr>
	<tr>
		<td style="border: 0px" colspan="2">
			<table border="0" cellpadding="1" cellspacing="1" style="border-bottom: 0; border-left: 0; border-right: 0; border-top: 0; font-size: 8px; width: 7cm; table-layout: fixed;">
				<tbody><tr>
				  
				  <td style="width: 7cm;" align="center" colspan="2">
				    <table cellpadding="0" cellspacing="0">
				      <tbody><tr>
				        <td align="center" valign="top" style="font-size: 10px"><b>
				          <?php echo $ebay_id; ?>
				          </b>
				          </td>
				        </tr>
				        <tr>
				          <td align="center">
				            <img src="../barcode128.class.php?data=<?php echo $ebay_id; ?>" alt="" width="159" height="38"/>
				            
				            </td>
				          </tr>
				        </tbody></table>
				    </td>
				  </tr>
				<tr>
				  <td style="font-size: 6px; border: 0px" colspan="2" align="left">
				    <div style="font-size: 8px; border: 0px" colspan="2" align="left">
				      <?php
				
				
				
						  	$sl	= "select * from ebay_orderdetail where ebay_ordersn='$ebay_ordersn'";
						$sl	= $dbcon->execute($sl);
						$sl	= $dbcon->getResultArray($sl);
					
						for($o=0;$o<count($sl);$o++){			
						
							$imagepic = $sl[$o]['ebay_itemurl'];
							$sku	= $sl[$o]['sku'];
							$amount	= $sl[$o]['ebay_amount'];
							
								$ssr			= "select goods_name from ebay_goods where goods_sn='$sku' and ebay_user ='$user'";
								$ssr	= $dbcon->execute($ssr);
								$ssr	= $dbcon->getResultArray($ssr);
						
						
								$goods_location   = $ssr[0]['goods_location'];
								$goods_name   = $ssr[0]['goods_name'];
								
						
						
						
							echo $sku.' '.$ssr[0]['goods_name'].' * '.$amount.' '.$goods_location.' ';
						
                            
						}
						
						
						echo '<br>'.$ebay_carrier.' '.$ebay_userid;
							?>
				      </div>
				    </td>
				  </tr>
				</tbody></table>
			</td>
		  </tr>
	</tbody></table>
    
    
    
    
    <?php
	
	
	
	 } ?>
    
    &nbsp;</td>
    
    
     </tr>
 <?php 
 	
	
if($coujtjs % 6 == 0  && $i != 0 ) echo '</tbody></table> <div style="page-break-after:always;">&nbsp;</div><table cellspacing="15"><tbody>';
	
 
 
 }   ?>
            
        
    
 </tbody></table>
</center>
</body></html>