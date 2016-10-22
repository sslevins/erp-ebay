
<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/yui.css" />



<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/deprecated.css" />



<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/style.css" /> 


<?php
include "include/config.php";







	

	
	$id		= $_REQUEST["tid"];
	$sql		= "select * from ebay_paypalorder as a where ebay_user='$user' and TRANSACTIONID='$id'";
	
				$sql		= $dbcon->execute($sql);

				$sql		= $dbcon->getResultArray($sql);
$i	= 0;

	
	$TRANSACTIONID		= $sql[$i]['TRANSACTIONID'];
						$ORDERTIME			= date('Y-m-d H:i:s',$sql[$i]['ORDERTIME']);
						$CURRENCYCODE		= $sql[$i]['CURRENCYCODE'];
						$dollar				= '$';
						
						if($CURRENCYCODE == 'USD'){
							
							$dollar				= '$';
						}elseif($CURRENCYCODE == 'EUR'){
							
							$dollar				= '€';
						}elseif($CURRENCYCODE == 'AUD'){
							
							$dollar				= '$';
						}elseif($CURRENCYCODE == 'GBP'){
							
							$dollar				= '￡';
						}
						$NETFEE		= $dollar.($sql[$i]['AMT'] - $sql[$i]['FEEAMT']);
						

								
						$ss					= "select * from  ebay_paypalorderdetail where TRANSACTIONID ='$TRANSACTIONID'";
						$ss					= $dbcon->execute($ss);
						$ss					= $dbcon->getResultArray($ss);
						
						$EMAIL		= $sql[$i]['EMAIL'];
						$BUYERID		= $sql[$i]['BUYERID'];
						$PAYMENTSTATUS		= $sql[$i]['PAYMENTSTATUS'];
						$PAYERSTATUS		= $sql[$i]['PAYERSTATUS'];
						$NOTE		= $sql[$i]['NOTE'];
						
						$SHIPTONAME			= $sql[$i]['SHIPTONAME'];
						$SHIPTOSTREET		= $sql[$i]['SHIPTOSTREET'];
						$SHIPTOSTREET2		= $sql[$i]['SHIPTOSTREET2'];
						$SHIPTOCITY			= $sql[$i]['SHIPTOCITY'];						
						$SHIPTOSTATE		= $sql[$i]['SHIPTOSTATE'];						
						$SHIPTOZIP			= $sql[$i]['SHIPTOZIP'];
						$SHIPTOCOUNTRYNAME	= $sql[$i]['SHIPTOCOUNTRYNAME'];
						$RECEIVEREMAIL	= $sql[$i]['RECEIVEREMAIL'];
						
						$addressline		= $SHIPTONAME."<br>".$SHIPTOSTREET."<br>".$SHIPTOSTREET2."<br>".$SHIPTOCITY." ".$SHIPTOSTATE."<br>".$SHIPTOZIP."<br>".$SHIPTOCOUNTRYNAME;
						
	
	


?>

<div id="main">
    <div id="content" >

                        <table width="100%" border="1" align="center" cellpadding="0" cellspacing="3" bordercolor="#1941A5">
            
			      <tr>
                    <td colspan="6" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="center">交易详情</div></td>
                    </tr>
			      <tr>
			        <td colspan="6" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="center">eBay已收金额（ID#<?php echo $TRANSACTIONID;?>）</div></td>
			        </tr>
			      <tr>
			        <td colspan="6" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">日期：<?php echo $ORDERTIME;?></div></td>
			        </tr>
			      <tr>
			        <td colspan="6" align="right" bgcolor="#f2f2f2" class="left_txt"><table width="100%" border="1" cellspacing="0" cellpadding="0">
                      <tr>
                        <td>物品号</td>
                        <td>标题</td>
                        <td>数量</td>
                      </tr>
                      
                      <?php 
					  	
						$ss		= "select * from ebay_paypalorderdetail where TRANSACTIONID='$TRANSACTIONID'";
	
						$ss		= $dbcon->execute($ss);
						$ss		= $dbcon->getResultArray($ss);
						for($y=0;$y<count($ss);$y++){
					  
					  		
							$L_NAME		= $ss[$y]['L_NAME'];		
							$L_NUMBER		= $ss[$y]['L_NUMBER'];
							$L_QTY		= $ss[$y]['L_QTY'];		
							$L_QTY		= $ss[$y]['L_QTY'];			
					  
					  ?>
                      
                      
                      
                      <tr>
                        <td><?php echo $L_NUMBER;?>&nbsp;</td>
                        <td><?php echo $L_NAME;?>&nbsp;</td>
                        <td><?php echo $L_QTY;?>&nbsp;</td>
                      </tr>
                      
                      <?php
					  
					  }
					  
					  ?>
                      
                      <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                    </table></td>
			        </tr>
			      <tr>
			        <td colspan="6" align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">净额</div></td>
			        <td width="89%" colspan="5" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left"><?php echo $dollar.$sql[$i]['AMT'];?></div></td>
			      </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">Paypal费用</div></td>
			        <td colspan="5" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left"><?php echo $dollar.$sql[$i]['FEEAMT'];?></div></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">净额</div></td>
			        <td colspan="5" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left"><?php echo $NETFEE;?></div></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">寄货地址</div></td>
			        <td colspan="5" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left"><?php echo $addressline;?></div></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">留言</div></td>
			        <td colspan="5" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left"><?php echo $NOTE;?></div></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">付款人</div></td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left"><?php echo $SHIPTONAME; ?></div></td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">付款人状态</div></td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left"><?php echo $PAYERSTATUS; ?></div></td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">买家</div></td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left"><?php echo $BUYERID; ?></div></td>
			      </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">买家邮件</div></td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left"><?php echo $EMAIL; ?></div></td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">付款给</div></td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left"><?php echo $RECEIVEREMAIL; ?></div></td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">付款状态</div></td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left"><?php echo $PAYMENTSTATUS; ?></div></td>
			        </tr>
			      <tr>
			        <td colspan="6" align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        </tr>
                </table>
              


    <div class="clear"></div>
