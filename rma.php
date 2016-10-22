<?php include "include/config.php";
	
	//rma.php?ebayid=1163&pid=1289

	
	
	$ebayid		= $_REQUEST['ebayid'];
	$pid		= $_REQUEST['pid'];
	
	
	if($_POST['submitrefund']){
	
		
		$ss			= "select * from ebay_rma where ebay_id='$ebayid' and ebay_pid='$pid'";
		$ss			= $dbcon->execute($ss);
		$ss			= $dbcon->getResultArray($ss);
		$ebay_account	= $ss[0]['ebay_account'];
	
	
		
		
		$paymentto_paypalaccount		= str_rep($_POST['paymentto_paypalaccount']);
		$REFUNDTYPE		= str_rep($_POST['REFUNDTYPE']);
		$ebay_refundamount		= str_rep($_POST['ebay_refundamount']);
		$ebay_currency		= str_rep($_POST['ebay_currency']);
		$ebay_ptid		= str_rep($_POST['ebay_ptid']);
		$sql		= "insert into ebay_paypalrefund(ebay_id,ebay_pid,ebay_refundamount,ebay_currency,ebay_ptid,paymentto_paypalaccount,REFUNDTYPE,addtime,ebay_user,addtimeuser,ebay_account) values('$ebayid','$pid','$ebay_refundamount','$ebay_currency','$ebay_ptid','$paymentto_paypalaccount','$REFUNDTYPE','$mctime','$user','$truename','$ebay_account')";
		
		$ss			= "select * from ebay_paypalrefund where ebay_id='$ebayid' and ebay_pid='$pid'";
			
			$ss			= $dbcon->execute($ss);
			$ss			= $dbcon->getResultArray($ss);
			$sscount	= count($ss);
			if($sscount == 0){
			
			
			
				if($dbcon->execute($sql)){
					$status	= " -[<font color='#33CC33'>操作记录: 退款请求已提交成功</font>]";
				}else{
					$status = " -[<font color='#FF0000'>操作记录: 退款提交失败</font>]";
				}
				
				
				echo $status;
				
				
				}else{
				
				echo " -[<font color='#FF0000'>操作记录: 退款提交失败，此请求已经存在</font>]";
				
				
				}
				
				
				
				
		
	
	}
	
	if($_POST['submit']){
		
			
			
			
			$ss			= "select * from ebay_ordersn where type='rma' order by id desc";
			$ss			= $dbcon->execute($ss);
			$ss			= $dbcon->getResultArray($ss);
			
			if(count($ss) == 0){
			$rmasn		= 1;
			}else{
			$rmasn		= $ss[0]['value']+1;
			}
			$rmasns			= $rmasn.'-'.date('d').date('m').date('y');
			
			
			$ss				= "select * from  ebay_order where ebay_id='$ebayid'";
			$ss				= $dbcon->execute($ss);
			$ss				= $dbcon->getResultArray($ss);
			$countrys		= $ss[0]['ebay_countryname'];
			$userid			= $ss[0]['ebay_userid'];
			$ebay_account			= $ss[0]['ebay_account'];
			$paymentto_paypalaccount			= $ss[0]['PayPalEmailAddress'];
			
			$ss				= "select * from  ebay_orderdetail where ebay_id='$pid'";
			$ss				= $dbcon->execute($ss);
			$ss				= $dbcon->getResultArray($ss);
			$sku			= $ss[0]['sku'];
			$recordnumber	= $ss[0]['recordnumber'];
			$serial			= $ss[0]['serial'];
			
			$ordernumber	= '';
			if($recordnumber == ''){
				$ordernumber	= $ebayid;
			}else{
				$ordernumber	= $ebayid;
			}
			$opendate		= date('Y-m-d');
			$AreaOwner		= $_SESSION['truename'];
			$rtatype		= str_rep($_POST['rtatype']);
			$duedate		= str_rep($_POST['duedate']);
			$status			= str_rep($_POST['status']);
			$Description	= str_rep($_POST['Description']);
			$rastatus		= str_rep($_POST['rastatus']);
			$nexthandleuser	= str_rep($_POST['nexthandleuser']);
			$ebay_refundamount		= str_rep($_POST['ebay_refundamount']);
			$ebay_currency		= str_rep($_POST['ebay_currency']);
			$ebay_ptid		= str_rep($_POST['ebay_ptid']);
			$paymentto_paypalaccount		= str_rep($_POST['paymentto_paypalaccount']);
			$REFUNDTYPE		= str_rep($_POST['REFUNDTYPE']);
			$ebay_refundnotes		= str_rep($_POST['ebay_refundnotes']);
			$sku					= str_rep($_POST['sku']);
						
			if($_POST['nexthandletime'] != '') $nexthandletime		= strtotime($_POST['nexthandletime']);
			
			$ss			= "select * from ebay_rma where ebay_id='$ebayid' and ebay_pid='$pid'";

			
			$ss			= $dbcon->execute($ss);
			$ss			= $dbcon->getResultArray($ss);
			$sscount	= count($ss);
			if($sscount == 0){
				
				
				$ss	 =  "insert into ebay_rma(rma_osn,ebay_id,ebay_pid,itemtitle,sku,SerialNumber,OpenDate,rtatype,AreaOwner,DueDate,status,Description,ordernumber,rastatus,countrys,userid,ebay_refundamount,ebay_account,ebay_status,ebay_user,ebay_currency,nexthandleuser,ebay_ptid,paymentto_paypalaccount,REFUNDTYPE,ebay_refundnotes,nexthandletime) values(";
				$ss  .= "'$rmasns','$ebayid','$pid','','$sku','$serial','$opendate','$rtatype','$AreaOwner','$duedate','$status','$Description','$ordernumber','$rastatus','$countrys','$userid','$ebay_refundamount','$ebay_account','0','$user','$ebay_currency','$nexthandleuser','$ebay_ptid','$paymentto_paypalaccount','$REFUNDTYPE','$ebay_refundnotes','$nexthandletime')";
				
				if($dbcon->execute($ss)){
					$status	= " -[<font color='#33CC33'>操作记录: 数据添加成功</font>]";
					$ss			= "insert into ebay_ordersn(type,value) values('rma','$rmasn')";
					$dbcon->execute($ss);
				}else{
					$status = " -[<font color='#FF0000'>操作记录: 保存失败1</font>]";
				}
				echo $status;
			}else{
				$ss	= "update ebay_rma set rtatype='$rtatype',DueDate='$duedate',status='$status',nexthandleuser='$nexthandleuser',Description='$Description',rastatus='$rastatus',countrys='$countrys',ebay_refundamount='$ebay_refundamount',nexthandletime='$nexthandletime',ebay_currency='$ebay_currency',sku='$sku',ebay_ptid='$ebay_ptid',REFUNDTYPE='$REFUNDTYPE',paymentto_paypalaccount='$paymentto_paypalaccount',ebay_refundnotes='$ebay_refundnotes' where ebay_id='$ebayid' and ebay_pid='$pid'";

				if($dbcon->execute($ss)){
					$status	= " -[<font color='#33CC33'>操作记录: 保存成功</font>]";
				}else{
					$status = " -[<font color='#FF0000'>操作记录: 保存失败0</font>]";
				}
				echo $status;
			}
			$Description2	= $_POST['Description2'];
			
			if($Description2 != ''){
				
				$su			= "insert into ebay_rmaactions(ebay_id,ebay_pid,content,wuser,tdate) values('$ebayid','$pid','$Description2','$AreaOwner','$opendate')";
				$dbcon->execute($su);
				
			}
			
	}
	
	$ss			= "select * from ebay_rma where ebay_id='$ebayid' and ebay_pid='$pid'";

	$ss			= $dbcon->execute($ss);
	$ss			= $dbcon->getResultArray($ss);
	if(count($ss) == 0){
		
		$ss			= "select * from ebay_ordersn where type='rma' order by id desc";
		$ss			= $dbcon->execute($ss);
		$ss			= $dbcon->getResultArray($ss);
		
		if(count($ss) == 0){
			$rmasn		= 1;
		}else{
			$rmasn		= $ss[0]['value']+1;
		}
		
		$rmasns			= $rmasn.'-'.date('d').date('m').date('y');
		
		
		
			$ss				= "select * from  ebay_order where ebay_id='$ebayid'";
			$ss				= $dbcon->execute($ss);
			$ss				= $dbcon->getResultArray($ss);
			$ebay_ptid		= $ss[0]['ebay_ptid'];
			$paymentto_paypalaccount			= $ss[0]['PayPalEmailAddress'];
			$ebay_currency						= $ss[0]['ebay_currency'];
			
			$ss				= "select * from  ebay_orderdetail where ebay_id='$pid'";
			$ss				= $dbcon->execute($ss);
			$ss				= $dbcon->getResultArray($ss);
			
			if($paymentto_paypalaccount == '' ) $paymentto_paypalaccount			= $ss[0]['PayPalEmailAddress'];
			$sku			= $ss[0]['sku'];
			$serial			= $ss[0]['serial'];
			$recordnumber	= $ss[0]['recordnumber'];
			$ordernumber	= '';
		
		if($recordnumber == ''){
				$ordernumber	= $ebayid;
		}else{
				$ordernumber	= $ebayid;
		}
		$OpenDate			= date('Y-m-d');
		$AreaOwner			= $_SESSION['truename'];
		$Description		= $_SESSION['Description'];
	
		
	}else{
		
						$nexthandletime 		= date('Y-m-d',$ss[0]['nexthandletime']);
						$rmasns 		= $ss[0]['rma_osn'];
						$sku	 		= $ss[0]['sku'];
						$OpenDate 		= $ss[0]['OpenDate'];
						$SerialNumber 	= $ss[0]['SerialNumber'];
						$AreaOwner		= $ss[0]['AreaOwner'];
						$ordernumber	= $ss[0]['ordernumber'];
						$status		 	= $ss[0]['status'];
						$Description 	= $ss[0]['Description'];
						$rtatype 		= $ss[0]['rtatype'];
						$DueDate 		= $ss[0]['DueDate'];
						$rastatus 		= $ss[0]['rastatus'];
						$ebay_refundamount 		= $ss[0]['ebay_refundamount'];
						$ebay_currency 			= $ss[0]['ebay_currency'];
						$nexthandleuser			= $ss[0]['nexthandleuser'];
						$ebay_ptid				= $ss[0]['ebay_ptid'];
						$paymentto_paypalaccount	= $ss[0]['paymentto_paypalaccount'];
						$REFUNDTYPE					= $ss[0]['REFUNDTYPE'];
						$ebay_refundnotes			= $ss[0]['ebay_refundnotes'];
	}
	






?>
<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/yui.css" />
<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/deprecated.css" />
<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/style.css" /> 
 <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>
<table cellpadding='0' cellspacing='0' width='100%' border='0' >
	<tr class='pagination'>
		<td width="26%">
			<table cellpadding='0' cellspacing='0' width='100%' border='0' >
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'>			
                      <form id="form" name="form" method="post" action="rma.php?ebayid=<?php echo $ebayid;?>&pid=<?php echo $pid ;?>">
                  <table width="100%" border="1" align="center" cellpadding="10" cellspacing="5">
                <input name="id" type="hidden" value="<?php echo $id;?>">
			      <tr>
                    <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt"><div align="right">原订单号：</div></td>
                    <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt"><div align="left"><?php echo $ordernumber;?>&nbsp;</div></td>
                    <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
                    <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			      </tr>
			      <tr>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">SKU：</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt"><div align="left"><?php echo $sku;?>&nbsp;
			          <input name="sku" id="sku" type="text"  value="<?php echo $sku;?>" />
			        </div></td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        </tr>
			      
			      <tr>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">CASE类型：</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <select name="rtatype" id="rtatype">
					  <?php
						$vv = "select name from ebay_rmatype where type='1' and ebay_user='$user'";
						$vv				= $dbcon->execute($vv);
						$vv				= $dbcon->getResultArray($vv);
						foreach($vv as $k=>$v){
							if($rtatype == $v['name']){
								echo '<option value="'.$v['name'].'"	 selected=\"selected\">'.$v['name'].'</option>';
							}else{
								echo '<option value="'.$v['name'].'">'.$v['name'].'</option>';
							}
						}
					  ?>
					  </select>
		            </div></td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
		            <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			      </tr>
			      <tr>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">CASE原因：</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <select name="status" id="status">
			            <?php
						$vv = "select name from ebay_rmatype where type='2' and ebay_user='$user'";
						$vv				= $dbcon->execute($vv);
						$vv				= $dbcon->getResultArray($vv);
						foreach($vv as $k=>$v){
							if($status == $v['name']){
								echo '<option value="'.$v['name'].'"	 selected=\"selected\">'.$v['name'].'</option>';
							}else{
								echo '<option value="'.$v['name'].'">'.$v['name'].'</option>';
							}
						}
					  ?>
		              </select>
		            </div></td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        </tr>
			      <tr>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">Case日期：</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt"><div align="left"><?php echo $OpenDate;?>&nbsp;</div></td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        </tr>
			      <tr>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">Case状态：</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <select name="rastatus" id="rastatus">
			            <option value="开启"	 <?php if($rastatus == "开启") echo 'selected="selected"';?>>开启</option>
			            <option value="跟进"	 <?php if($rastatus == "跟进") echo 'selected="selected"';?>>跟进</option>
			            <option value="退款" 	 <?php if($rastatus == '退款') echo 'selected="selected"';?>>退款</option>
			            <option value="重寄"	 <?php if($rastatus == '重寄') echo 'selected="selected"';?>>重寄</option>
			            <option value="关闭"	 <?php if($rastatus == '关闭') echo 'selected="selected"';?>>关闭</option>
		              </select>
		            </div></td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			      </tr>
			      <tr>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">处理完成日期：</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="duedate" id="duedate" type="text" onclick="WdatePicker()" value="<?php echo $DueDate;?>" />
		            </div></td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        </tr>
			      <tr>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">退款金额：</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="ebay_refundamount" id="ebay_refundamount" type="text"   value="<?php echo $ebay_refundamount;?>" />
		            币种:
		            <select name="ebay_currency" id="ebay_currency">
                      <option value="" >请选择</option>
                      <?php

							$tql	= "select * from ebay_currency where user = '$user'";
							$tql	= $dbcon->execute($tql);
							$tql	= $dbcon->getResultArray($tql);
							for($i=0;$i<count($tql);$i++){

							$currency1		= $tql[$i]['currency'];

						   

						   ?>
                      <option value="<?php echo $currency1;?>"  <?php if($ebay_currency == $currency1) echo "selected=selected" ?>><?php echo $currency1;?></option>
                      <?php

						   }

						   


						   ?>
                    </select>
			        Paypal 交易ID：
			        <input name="ebay_ptid" id="ebay_ptid" type="text"   value="<?php echo $ebay_ptid;?>" />
			        <br />
			        </div></td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			      </tr>
			      <tr>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">收款帐号：</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="paymentto_paypalaccount" id="paymentto_paypalaccount" type="text"  value="<?php echo $paymentto_paypalaccount;?>" />
		              
		              退款类型： 
		            <select name="REFUNDTYPE" id="REFUNDTYPE">
                      <option value="" >请选择</option>
                      <option value="Full"  <?php if($REFUNDTYPE == 'Full') echo "selected=selected" ?>>全额退款</option>
                      <option value="Partial"  <?php if($REFUNDTYPE == 'Partial') echo "selected=selected" ?>>部分退款</option>
                    </select>
			        </div></td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        </tr>
			      <tr>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">退款留言：</td>
			        <td align="left" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">
                    
                    
                    <textarea name="ebay_refundnotes" cols="50" rows="3" id="ebay_refundnotes"><?php echo $ebay_refundnotes;?></textarea>
			          <strong>不能超过255个字符</strong></td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        </tr>
			      <tr>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">Case 下次处理时间</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="nexthandletime" id="nexthandletime" type="text" onclick="WdatePicker()" value="<?php echo $nexthandletime;?>" />
		            </div></td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        </tr>
				<tr>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">Case 下次处理人</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="nexthandleuser" id="nexthandleuser" type="text" value="<?php echo $nexthandleuser;?>" />
		            </div></td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        </tr>
			      <tr>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">添加人：</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt"><div align="left"><?php echo $AreaOwner;?>&nbsp;</div></td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        </tr>
			      <tr>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">描述：</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <textarea name="Description" cols="50" rows="3" id="Description"><?php echo $Description;?></textarea>
		            </div></td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        </tr>
			      <tr>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">添加备注：</td>
			        <td colspan="3" align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt"><table width="100%" border="1" cellspacing="1" cellpadding="5" style="border-color:#06C">
			          <tr>
			            <td>评论</td>
			            <td>添加人</td>
			            <td>日期</td>
		              </tr>
                      
                      <?php 
					  	
						
						$ss	= "select * from ebay_rmaactions where ebay_id='$ebayid' and ebay_pid='$pid'";
						$ss = $dbcon->execute($ss);
						$ss = $dbcon->getResultArray($ss);
						for($i=0;$i<count($ss);$i++){
							
								
								$content		= $ss[$i]['content'];
								$wuser			= $ss[$i]['wuser'];
								$tdate			= $ss[$i]['tdate'];
								
					  
					  ?>
			          <tr>
			            <td><?php echo $content;?>&nbsp;</td>
			            <td><?php echo $wuser;?>&nbsp;</td>
			            <td><?php echo $tdate;?>&nbsp;</td>
		              </tr>
                      
                      
                      <?php } ?>
			          <tr>
			            <td><textarea name="Description2" cols="50" rows="3" id="Description2"></textarea></td>
			            <td>&nbsp;</td>
			            <td>&nbsp;</td>
		              </tr>
		            </table></td>
			        </tr>
			      <tr>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td colspan="3" align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt"><div align="left">&nbsp;
			          <?php if($rastatus != '关闭') { ?>
                      <input type="submit" name="submit" value="保存" />
			          <input type="submit" name="submitrefund" onclick="return openpayment('<?php echo $ebayid;?>','<?php echo $pid;?>')" value="提交退款申请" />
			          (请选择选择保存，在提交)
			        -&gt; 请联系技术开通, API直接退款，无需要登陆paypal
                     <?php } ?>
                    
                    
                    </div></td>
			        </tr>
			      
                  <tr>				 
                    <td colspan="4" align="right" bordercolor="#666666" class="left_txt"><div align="right"></div>                      <div align="left"></div></td>
                    </tr>
                </table>
                 </form> 
               </td>
               
	    </tr>
			</table>		</td>
	</tr>

              
		<tr class='pagination'>
		<td>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'></td>
					</tr>
			</table>		</td>
	</tr></table>


    <div class="clear"></div>


<script language="javascript">
	
	function openpayment(ebayid,ebay_pid){
	
		
			var ebay_refundamount				= document.getElementById('ebay_refundamount').value;
			var ebay_currency					= document.getElementById('ebay_currency').value;
			var ebay_ptid						= document.getElementById('ebay_ptid').value;
			var paymentto_paypalaccount			= document.getElementById('paymentto_paypalaccount').value;
			var REFUNDTYPE						= document.getElementById('REFUNDTYPE').value;
			
			if(ebay_refundamount == '' ) {
				alert('请输入退款金额');
				return false;
			}

			if(ebay_currency == '' ) {
				alert('请选择币种');
				return false;
			}

			
			if(ebay_ptid == '' ) {
				alert('请输入本次订单的Paypal交易号码');
				return false;
			}
			
			
			if(paymentto_paypalaccount == '' ) {
				alert('本次收款Paypal帐号不能为空');
				return false;
			}
			
			if(REFUNDTYPE == '' ) {
				alert('退款类型不能为空');
				return false;
			}
			
			var url ="paypal_refundadd.php?ebay_id="+ebayid+"&ebay_pid="+ebay_pid;
	
	}




</script>