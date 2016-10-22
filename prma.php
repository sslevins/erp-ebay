<?php include "include/config.php";
	
	//rma.php?ebayid=1163&pid=1289

	
	
	$ebayid		= $_REQUEST['ebayid'];
	$pid		= $_REQUEST['pid'];
	
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
			
			
		
			$sku		= str_rep($_POST['sku']);
			
			$ordernumber	= '';
			if($recordnumber == ''){
				$ordernumber	= $ebayid;
			}else{
				$ordernumber	= 'A'.$ebayid;
			}
			$opendate		= date('Y-m-d');
			$AreaOwner		= $_SESSION['truename'];
			$rtatype		= str_rep($_POST['rtatype']);
			$duedate		= str_rep($_POST['duedate']);
			$status			= str_rep($_POST['status']);
			$Description	= str_rep($_POST['Description']);
			$rastatus		= str_rep($_POST['rastatus']);
			$ebay_refundamount		= str_rep($_POST['ebay_refundamount']);
			
			if($_POST['nexthandletime'] != '') $nexthandletime		= strtotime($_POST['nexthandletime']);
			
			$ss			= "select * from ebay_rma where id='$ebayid'";

			
			$ss			= $dbcon->execute($ss);
			$ss			= $dbcon->getResultArray($ss);
			$sscount	= count($ss);
			if($sscount == 0){
				
				
				$ss	 =  "insert into ebay_rma(rma_osn,ebay_id,ebay_pid,itemtitle,sku,SerialNumber,OpenDate,rtatype,AreaOwner,DueDate,status,Description,ordernumber,rastatus,countrys,userid,ebay_refundamount,ebay_account,ebay_status) values(";
				$ss  .= "'$rmasns','$ebayid','$pid','','$sku','$serial','$opendate','$rtatype','$AreaOwner','$duedate','$status','$Description','$ordernumber','$rastatus','$countrys','$userid','$ebay_refundamount','$ebay_account','1')";
echo $ss;

				
				if($dbcon->execute($ss)){

					$status	= " -[<font color='#33CC33'>操作记录: 保存成功</font>]";
					$ss			= "insert into ebay_ordersn(type,value) values('rma','$rmasn')";
					$dbcon->execute($ss);
					
					
				}else{
					$status = " -[<font color='#FF0000'>操作记录: 保存失败1</font>]";
				}
				echo $status;
				
				
			}else{
				
				
				$ss	= "update ebay_rma set rtatype='$rtatype',DueDate='$duedate',status='$status',Description='$Description',rastatus='$rastatus',countrys='$countrys',ebay_refundamount='$ebay_refundamount',nexthandletime='$nexthandletime',sku='$sku' where  id='$ebayid'";

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
	
	$ss			= "select * from ebay_rma where id='$ebayid' ";

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
		
		$ss				= "select * from  ebay_orderdetail where ebay_id='$pid'";

		
		$ss				= $dbcon->execute($ss);
		$ss				= $dbcon->getResultArray($ss);
		

		$sku			= $ss[0]['sku'];
		$serial			= $ss[0]['serial'];
		$recordnumber	= $ss[0]['recordnumber'];
		$ordernumber	= '';
		
		if($recordnumber == ''){
				$ordernumber	= "B".$ebayid;
		}else{
				$ordernumber	= 'A'.$ebayid;
		}
		$OpenDate			= date('Y-m-d');
		$AreaOwner			= $_SESSION['truename'];
		$Description		= $_SESSION['Description'];
	
		
	}else{
		
						if($ss[0]['nexthandletime'] > 0) $nexthandletime 		= date('Y-m-d',$ss[0]['nexthandletime']);
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
                      <form id="form" name="form" method="post" action="prma.php?ebayid=<?php echo $ebayid;?>&pid=<?php echo $pid ;?>">
                  <table width="100%" border="1" align="center" cellpadding="10" cellspacing="0">
                <input name="id" type="hidden" value="<?php echo $id;?>">
			      <tr>
                    <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt"><div align="right">Case单号：</div></td>
                    <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt"><div align="left"><?php echo $rmasns;?>&nbsp;</div></td>
                    <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt"><div align="right"></div></td>
                    <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			      </tr>
			      <tr>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        </tr>
			      
			      <tr>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">SKU：</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="sku" id="sku" type="text"  value="<?php echo $sku;?>" />
			          &nbsp;</div></td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">CASE类型：</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			            <select name="rtatype" id="rtatype">
			              <option value="加急"	 <?php if($rtatype == '加急') echo 'selected="selected"';?>>加急</option>
			              <option value="急" 	 <?php if($rtatype == '急') echo 'selected="selected"';?>>急</option>
			              <option value="一般"	 <?php if($rtatype == '一般') echo 'selected="selected"';?>>一般</option>
		                </select>
	                &nbsp;</div></td>
			      </tr>
			      <tr>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">CASE原因:</td>
			        <td align="left" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">
                    
                    <select name="status" id="">
                      <option value="一星" 		<?php if($status == '一星') echo 'selected="selected"';?>>一星</option>
                      <option value="二星"	<?php if($status == '二星') echo 'selected="selected"';?>>二星</option>
                      <option value="三星"	<?php if($status == '三星') echo 'selected="selected"';?>>三星</option>
                      
                      <option value="四星"	<?php if($status == '四星') echo 'selected="selected"';?>>四星</option>
                       <option value="五星"	<?php if($status == '五星') echo 'selected="selected"';?>>五星</option>
                    </select></td>
			        </tr>
			      <tr>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        </tr>
			      <tr>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt"><div align="left">&nbsp;</div></td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt"><div align="right">添加人：</div></td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt"><div align="left"><?php echo $AreaOwner;?>&nbsp;</div></td>
			      </tr>
			      <tr>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        </tr>
			      <tr>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">Case日期:</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt"><div align="left"><?php echo $OpenDate;?>&nbsp;</div></td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">处理完成日期：</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt"><div align="left">&nbsp;
			          <input name="duedate" id="duedate" type="text" onclick="WdatePicker()" value="<?php echo $DueDate;?>" />
			        </div></td>
			        </tr>
			      <tr>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        </tr>
			      <tr>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">:</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt"><div align="left"></div></td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">Case状态</td>
			        <td align="left" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">
                    
                    <select name="rastatus" id="rastatus">
                      <option value="开启"	 <?php if($rastatus == "开启") echo 'selected="selected"';?>>开启</option>
			          <option value="已回复"	 <?php if($rastatus == "已回复") echo 'selected="selected"';?>>已回复</option>
			          <option value="关闭" 	 <?php if($rastatus == '关闭') echo 'selected="selected"';?>>关闭</option>
                      
                      <option value="新产品" 	 <?php if($rastatus == '新产品') echo 'selected="selected"';?>>新产品</option>
                      <option value="采购成功" 	 <?php if($rastatus == '采购成功') echo 'selected="selected"';?>>采购成功</option>
                      <option value="采购失败" 	 <?php if($rastatus == '采购失败') echo 'selected="selected"';?>>采购失败</option>
                      
		            </select></td>
			        </tr>
			      <tr>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="left" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        </tr>
			      <tr>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">销售金额</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt"><input name="ebay_refundamount" id="ebay_refundamount" type="text"   value="<?php echo $ebay_refundamount;?>" /></td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">Case 下次处理时间</td>
			        <td align="left" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt"><input name="nexthandletime" id="nexthandletime" type="text" onclick="WdatePicker()" value="<?php echo $nexthandletime;?>" /></td>
			        </tr>
			      <tr>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        </tr>
			      <tr>
			        <td align="right" valign="top" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">描述</td>
			        <td colspan="3" align="right" valign="top" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <textarea name="Description" cols="50" rows="5" id="Description"><?php echo $Description;?></textarea>
			        </div></td>
			        </tr>
			      <tr>
			        <td align="right" valign="top" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td colspan="3" align="right" valign="top" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        </tr>
			      <tr>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">添加备注</td>
			        <td colspan="3" align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt"><table width="100%" border="1" cellspacing="1" cellpadding="5" style="border-color:#06C">
			          <tr>
			            <td>评论</td>
			            <td>添加人</td>
			            <td>日期</td>
		              </tr>
                      
                      <?php 
					  	
						
						$ss	= "select * from ebay_rmaactions where ebay_id='$ebayid' and ebay_pid='$pid' and ebay_id != ''";
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
			            <td><textarea name="Description2" cols="50" rows="5" id="Description2"></textarea></td>
			            <td>&nbsp;</td>
			            <td>&nbsp;</td>
		              </tr>
		            </table></td>
			        </tr>
			      <tr>
			        <td align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td colspan="3" align="right" bordercolor="#666666" bgcolor="#f2f2f2" class="left_txt"><div align="left">&nbsp;
			          <input type="submit" name="submit" value="Save" />
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
