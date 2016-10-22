<?php
include "include/config.php";
include "top.php";	
	/* 修改客户地址 */
	
	$stype	= $_REQUEST['stype'];
	if($_REQUEST['io_ordersn'] == ""){
	
		$io_ordersn	= "IO-".date('Y')."-".date('m')."-".date('d')."-".date("H").date('i').date('s'). mt_rand(100, 999);
		$issave = '0';
	}else{
		$io_ordersn	= $_REQUEST['io_ordersn'];
		$issave = '1';
	}
	
	if($_REQUEST['addtype'] == 'mod'){
	
	$goods_count	= $_REQUEST['goods_count'];
	$goods_cost		= $_REQUEST['goods_cost'];
	$modid			= $_REQUEST['modid'];
	$sql	= "update  ebay_iostoredetail set goods_count='$goods_count',goods_cost ='$goods_cost' where id=$modid";

					
		if($dbcon->execute($sql)){
			$status	= " -[<font color='#33CC33'>操作记录: 产品添加成功</font>]";
		}else{
			$status = " -[<font color='#FF0000'>操作记录: 产品添加失败</font>]";
		}
	
	
	}

	if($_REQUEST['addtype'] == 'del'){
	
		
		$id		= $_REQUEST['id'];
		$sql	= "delete from ebay_iostoredetail where id=$id";
					
		if($dbcon->execute($sql)){
			$status	= " -[<font color='#33CC33'>操作记录: 产品添加成功</font>]";
		}else{
			$status = " -[<font color='#FF0000'>操作记录: 产品添加失败</font>]";
		}
		
	
	}
	
	if($_REQUEST['addtype'] == 'save'){
		
		$sql			= "select * from  ebay_iostore where io_ordersn='$io_ordersn'";
		$sql			= $dbcon->execute($sql);
		$sql			= $dbcon->getResultArray($sql);
		$qc_user					= $_REQUEST['qc_user'];
		$in_type					= $_REQUEST['in_type'];
		$in_warehouse				= $_REQUEST['in_warehouse'];
		$note						= str_rep($_REQUEST['note']);
		$io_shipfee					=  $_REQUEST['io_shipfee'];
		$io_paymentmethod			=  $_REQUEST['io_paymentmethod'];
		$io_partner					=  $_REQUEST['io_partner'];
		$io_purchaseuser			=  $_REQUEST['io_purchaseuser'];
		$partner					=  $_REQUEST['partner'];
		$deliverytime				= '';
		if($_REQUEST['deliverytime'] != '')$deliverytime					=  strtotime($_REQUEST['deliverytime']);
		$partner					= str_rep($_REQUEST['partner']);
		$io_user					= $_REQUEST['io_user'];
		$trueusername				= $_SESSION['truename'];
		if(count($sql) == 0){
				$sql	= "insert into ebay_iostore(io_ordersn,io_addtime,io_warehouse,io_type,io_status,io_note,ebay_user,type,operationuser,io_user,io_paymentmethod,io_partner,io_purchaseuser,partner,deliverytime,io_shipfee,qc_user) values('$io_ordersn','$mctime','$in_warehouse','$in_type','0','$note','$user','$stype','$trueusername','$io_user','$io_paymentmethod','$io_partner','$io_purchaseuser','$partner','$deliverytime','$io_shipfee','$qc_user')";
			
		
		}else{
		
			
			$sql	= "update ebay_iostore set io_warehouse='$in_warehouse',io_type='$in_type',io_note='$note',partner='$partner',io_user='$io_user',io_paymentmethod='$io_paymentmethod',io_partner='$io_partner',io_purchaseuser='$io_purchaseuser',partner='$partner',deliverytime='$deliverytime',io_shipfee='$io_shipfee',qc_user='$qc_user' where io_ordersn='$io_ordersn'";
			
		}
		
		if($dbcon->execute($sql)){
			$status	.= " -[<font color='#33CC33'>操作记录:入库单保存成功</font>]";
			$addtype	= '';
			
		}else{
			$status .= " -[<font color='#FF0000'>操作记录: 入库单保存失败</font>]";
		}
		
		
		
		
		/*  添加产品数据 */
		
		
		$goods_sn		= trim($_REQUEST['goods_sn']);
		$goods_count	= $_REQUEST['goods_count'];
		$goods_cost		= $_REQUEST['cost'];
		
		if($goods_sn != '' && $goods_count !='' && $goods_cost != '' ){
		
		$sql			= "select * from ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
		$sql			= $dbcon->execute($sql);
		$sql			= $dbcon->getResultArray($sql);
		if(count($sql)  == 0){
			$status .= " -[<font color='#FF0000'>操作记录: 没有产品记录，请添加此产品</font>]";
		}else{
			$goods_name		= $sql[0]['goods_name'];
			$goods_sn		= $sql[0]['goods_sn'];
		//	$goods_price	= $sql[0]['goods_cost'];
			$goods_unit		= $sql[0]['goods_unit'];
			$goods_id		= $sql[0]['goods_id'];
			
			$sql		= "insert into ebay_iostoredetail(io_ordersn,goods_name,goods_sn,goods_cost,goods_unit,goods_count,goods_id) values('$io_ordersn','$goods_name','$goods_sn','$goods_cost','$goods_unit','$goods_count','$goods_id')";
		
			if($dbcon->execute($sql)){
				$status	.= " -[<font color='#33CC33'>操作记录: 产品添加成功</font>]";
			}else{
				$status .= " -[<font color='#FF0000'>操作记录: 产品添加失败</font>]";
			}
		
		}
		
		
		}
		
		/* 结束添加产品数据 */

	
	
	
	}
	
	
	
	
	$sql				= "select * from  ebay_iostore where io_ordersn='$io_ordersn'";
	$sql				= $dbcon->execute($sql);
	$sql				= $dbcon->getResultArray($sql);

	$in_type			= $sql[0]['io_type'];
	$in_warehouse		= $sql[0]['io_warehouse'];
	$iistatus			= $sql[0]['io_status'];
	
	if($_REQUEST['addtype'] == 'audit'){
		
		
			$astatus		= $_REQUEST['astatus'];
			if($iistatus != $astatus){
			if($astatus ==0 ){
				
			//	$runstatus  = addoroutstock($io_ordersn,$astatus,$in_warehouse);
			$esql			= "update ebay_iostore set io_status='$astatus',io_audittime ='',audituser='' where io_ordersn='$io_ordersn'";
				
			}else if($astatus ==1){
			//	$runstatus	 = addoroutstock($io_ordersn,$astatus,$in_warehouse);
			$esql			= "update ebay_iostore set io_status='$astatus',io_audittime ='$mctime',audituser='$truename' where io_ordersn='$io_ordersn'";
				
			}else if($astatus ==3){
			//	$runstatus	 = addoroutstock($io_ordersn,$astatus,$in_warehouse);
			$esql			= "update ebay_iostore set io_status='$astatus',io_audittime ='$mctime',audituser='$truename' where io_ordersn='$io_ordersn'";
			}
			if($dbcon->execute($esql)){
				$status	= " -[<font color='#33CC33'>操作记录: 单据审核成功</font>]";
			}else{
				$status	= " -[<font color='#FF0000'>操作记录: 单据审核失败</font>]";
			}
			}
	}
	
	$sql				= "select * from  ebay_iostore where io_ordersn='$io_ordersn'";
	$sql				= $dbcon->execute($sql);
	$sql				= $dbcon->getResultArray($sql);
	$io_user			= $sql[0]['io_user'];
	$in_type			= $sql[0]['io_type'];
	$in_warehouse		= $sql[0]['io_warehouse'];
	$note				= $sql[0]['io_note'];
	$iistatus			=  $sql[0]['io_status'];
	$partner			=  $sql[0]['partner'];
	$audituser			=  $sql[0]['audituser'];
	$operationuser		=  $sql[0]['operationuser'];
	$audituser			=  $sql[0]['audituser'];
	$io_addtime			=  $sql[0]['io_addtime'];
	$deliverytime			=  $sql[0]['deliverytime']?$sql[0]['deliverytime']:'';
	$io_paymentmethod			=  $sql[0]['io_paymentmethod'];
	$io_partner					=  $sql[0]['io_partner'];
	$io_purchaseuser			=  $sql[0]['io_purchaseuser'];
	$partner					=  $sql[0]['partner'];
	$io_shipfee					=  $sql[0]['io_shipfee'];
	if($io_addtime != '') $io_addtime	= date('Y-m-d H:i:s',$io_addtime);
	if($deliverytime != '' && $deliverytime != 0) $deliverytime	= date('Y-m-d',$deliverytime);
	$io_audittime			=  $sql[0]['io_audittime']?$sql[0]['io_audittime']:'';
	if($io_audittime != '' && $io_audittime != '0') $io_audittime	= date('Y-m-d H:i:s',$io_audittime);
	$qc_user			=  $sql[0]['qc_user'];
		

 ?>
<style type="text/css">
<!--
.STYLE1 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
 <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>

<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo '采购订单'.$status;?> </h2>
</div>

<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
  <td nowrap="nowrap" scope="row" >
   <?php if($iistatus == '0' || $iistatus == ''){ ?><input name="input" type="button" value="保存单据" onclick="save()" /><?php } ?>
   <?php if($iistatus == '0' || $iistatus == ''){ ?> <input name="input" type="button" value="审核单据" onclick="audit()"  /> <?php } ?>
   <?php if($iistatus == '1' ){ ?> <input name="input2" type="button" value="反审核单据" onclick="auditf()" />
   <input name="input5" type="button" value="审核到在途订单" onclick="audittozaitong()" />
   <?php } ?>
   
   
   <?php if($iistatus == '3' ){ ?>
   <input name="input5" type="button" value="反审核在途订单" onclick="naudittozaitong()" />
   <?php } ?>
   
   
   
    <input name="input4" type="button" value="打印单据" onclick="printorder()" /></td>
</tr>
<tr>
	
	
	
		
	<td nowrap="nowrap" scope="row" >&nbsp;<br />
	  1.填写基本资料
	  <br />
	  <br />
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
                      <td class="login_txt_bt"><table width="100%" border="1" cellspacing="10" cellpadding="0">
                        <tr>
                          <td width="8%">供应商</td>
                          <td width="8%"><select name="io_partner" id="io_partner">
                            <option value="" >未设置</option>
                            <?php 
					
					$sql	 = "SELECT company_name FROM `ebay_partner` where ebay_user='$user' ";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 
					 	$company_name1	= $sql[$i]['company_name'];
						
					 ?>
                            <option value="<?php echo $company_name1;?>" <?php if($company_name1 == $io_partner) echo "selected=selected" ?>><?php echo $company_name1;?></option>
                            <?php } ?>
                          </select></td>
                          <td width="4%">仓库</td>
                          <td width="8%"><select name="in_warehouse" id="in_warehouse">
                            <option value="" >未设置</option>
                            <?php 
					
					$sql	 = "select id,store_name
					 from ebay_store where ebay_user='$user'";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 
					 	$store_name	= $sql[$i]['store_name'];
						$cid			=  $sql[$i]['id'];
					 ?>
                            <option value="<?php echo $cid;?>" <?php if($in_warehouse == $cid) echo "selected=selected" ?>><?php echo $store_name;?></option>
                            <?php } ?>
                          </select>
(必填)</td>
                          <td colspan="2">备注
                            ：
                            <input name="note" type="text" id="note" value="<?php echo $note;?>" /></td>
                        </tr>
                        
                        <tr>
                          <td>单号</td>
                          <td><input name="io_ordersn" type="text" id="io_ordersn" value="<?php echo $io_ordersn;?>" size="30"   style="border-bottom :1 solid black; border-left :none; border-right :none; border-top :none; BACKGROUND: none transparent scroll repeat 0% 0%; "/></td>
                          <td>采购员</td>
                          <td><select name="io_purchaseuser" id="io_purchaseuser">
                            <option value="" >未设置</option>
                            <?php 
					
					$sql	 = "select username from ebay_user where user='$user'";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 
					 	$iousername	= $sql[$i]['username'];
				
					 ?>
                            <option value="<?php echo $iousername;?>" <?php if($iousername == $io_purchaseuser) echo "selected=selected" ?>><?php echo $iousername;?></option>
                            <?php } ?>
                          </select></td>
                          <td colspan="2">验收员
                            <select name="qc_user" id="qc_user">
                              <option value="" >未设置</option>
                              <?php 
					
					$sql	 = "select username from ebay_user where user='$user'";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 
					 	$iousername	= $sql[$i]['username'];
				
					 ?>
                              <option value="<?php echo $iousername;?>" <?php if($iousername == $qc_user) echo "selected=selected" ?>><?php echo $iousername;?></option>
                              <?php } ?>
                            </select></td>
                        </tr>
                        <tr>
                          <td>付款方式</td>
                          <td><select name="io_paymentmethod" id="io_paymentmethod">
                            <option value="" >未设置</option>
         
                            <option value="货到付款" 		<?php if($io_paymentmethod == '货到付款') echo "selected=selected" ?>>货到付款</option>
                            <option value="银行转帐" 		<?php if($io_paymentmethod == '银行转帐') echo "selected=selected" ?>>银行转帐</option>
                             <option value="电子支票" 	<?php if($io_paymentmethod == '电子支票') echo "selected=selected" ?>>电子支票</option>
                              <option value="支付宝付款" <?php if($io_paymentmethod == '支付宝付款') echo "selected=selected" ?>>支付宝付款</option>
                            
                        
                          </select></td>
                          <td>到货日期</td>
                          <td><input name="deliverytime" type="text" id="deliverytime" value="<?php echo $deliverytime;?>" size="30"   style="border-bottom :1 solid black; border-left :none; border-right :none; border-top :none; BACKGROUND: none transparent scroll repeat 0% 0%; " onClick="WdatePicker()" /></td>
                          <td colspan="2">运费：
                          <input name="io_shipfee" type="text" id="io_shipfee" value="<?php echo $io_shipfee;?>" size="30"   style="border-bottom :1 solid black; border-left :none; border-right :none; border-top :none; BACKGROUND: none transparent scroll repeat 0% 0%; "  /></td>
                        </tr>
                </table></td>
              </tr>
                    <tr>
                      <td valign="top" class="left_txt">
                      
                      &nbsp;<br />
                      2.产品资料
                      
                      <br />
                      <br /></td>
              </tr>
                    <tr>
                      <td class="login_txt_bt"><table width="100%" border="1" cellspacing="3" cellpadding="0">
                        <tr>
                          <td>序号</td>
                          <td>产品编号</td>
                          <td>图片</td>
                          <td>产品名称</td>
                          <td>单位</td>
                          <td>30/15/7销量</td>
                          <td>实际库存</td>
                          <td>占用库存</td>
                          <td>已订购</td>
                          <td>可用库存</td>
                          <td>进货成本</td>
                          <td>数量</td>
                          <td>操作</td>
                        </tr>
                        
                        <?php
							
							$sql	= "select goods_sn,goods_name,goods_price,goods_cost,goods_unit,id,goods_count from ebay_iostoredetail where io_ordersn='$io_ordersn'";
						
							$totalprice		= 0;
							$totalqty		= 0;
							
							
							$sql	= $dbcon->execute($sql);
							$sql	= $dbcon->getResultArray($sql);
							for($i=0;$i<count($sql);$i++){
								
								$goods_sn			= $sql[$i]['goods_sn'];
								$goods_name 		= $sql[$i]['goods_name'];
								$goods_price 		= $sql[$i]['goods_price'];
								$goods_cost 		= $sql[$i]['goods_cost'];
								$goods_unit 		= $sql[$i]['goods_unit'];
								$id					= $sql[$i]['id'];
								$goods_count  		= $sql[$i]['goods_count'];
								$totalprice			+= ($goods_cost * $goods_count); 
								$totalqty			+= $goods_count;
								
						?>
                        
                        <tr >
                          <td><?php echo  $i+1;?>. &nbsp;</td>
                          <td><?php echo $goods_sn;?>&nbsp;</td>
                          <td><img src="images/<?php echo $goods_sn.'.jpg'; ?>" alt="" width="50" height="50" /></td>
                          <td><?php echo $goods_name;?>&nbsp;</td>
                          <td><?php echo $goods_unit;?>&nbsp;</td>
                          <td><?php
						  
						  $start1						= date('Y-m-d').'23:59:59';	
						  $start0						= date('Y-m-d',strtotime("$start1 -30 days")).' 00:00:00';
						 $qty1							= getProductsqty($start0,$start1,$goods_sn,$in_warehouse);
						  echo $qty1;
						  
						  
						  
						  ?>                            &nbsp;/
                          <?php
						  
						  $start1						= date('Y-m-d').'23:59:59';	
						  $start0						= date('Y-m-d',strtotime("$start1 -15 days")).' 00:00:00';
						  $qty1							= getProductsqty($start0,$start1,$goods_sn,$in_warehouse);
						  echo $qty1;
						  
						  
						  ?>/
                          <?php
						  
						  $start1						= date('Y-m-d').'23:59:59';	
						  $start0						= date('Y-m-d',strtotime("$start1 -7 days")).' 00:00:00';
						  $qty1							= getProductsqty($start0,$start1,$goods_sn,$in_warehouse);
						  echo $qty1;
						  ?></td>
                          <td><?php
					
								$seq				= "select goods_count from ebay_onhandle where goods_sn='$goods_sn' and store_id='$in_warehouse' ";
								$seq				= $dbcon->execute($seq);
								$seq				= $dbcon->getResultArray($seq);
								$truestock			= $seq[0]['goods_count']?$seq[0]['goods_count']:0;
								echo $truestock;
							
							
							?></td>
                          <td><?php
						 $stockused	= stockused($goods_sn,$in_warehouse);
						 echo $stockused;
						  ?>                            &nbsp;</td>
                          <td><?php
						  
						  $stockbookused	= stockbookused($goods_sn,$in_warehouse);
						  echo $stockbookused;
						  ?></td>
                          <td><?php
								
								
								echo $truestock - $stockused;
							
							
							
							?></td>
                          <td>&nbsp;
                          <textarea name="goods_cost" cols="5" rows="1" id="goods_cost<?php echo $id ?>" ><?php echo $goods_cost;?></textarea></td>
                          <td>&nbsp;
                          <textarea name="goods_count" cols="6" rows="1" id="goods_count<?php echo $id ?>" ><?php echo $goods_count;?></textarea></td>
                          <td>
                          <?php if($iistatus != 2){ ?>
                          <a href="#" onclick="del('<?php echo $id;?>')">删除</a>&nbsp;&nbsp;
                          <a href="#" onclick="mod('<?php echo $id;?>')">修改</a>                          </td>
                          <?php } } ?>
						</tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>总成本：&nbsp;</td>
                          <td><?php echo $totalprice;?>&nbsp;</td>
                          <td><?php echo $totalqty;?>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>总运费：</td>
                          <td><?php echo $io_shipfee;?>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>总计：</td>
                          <td><?php echo $io_shipfee +$totalprice;
						  
						  /* 更新订单应付款的总金额 */
						  $io_paidtotal	= $io_shipfee +$totalprice;		  
						  $vv			= "update ebay_iostore set io_paidtotal ='$io_paidtotal' where io_ordersn ='$io_ordersn'";
						  $dbcon->execute($vv);
						  
						  ?>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="13">
                          <?php if($iistatus != 2){ ?>
                          
                          产品编号：
                            <input name="goods_sn" type="text" id="goods_sn" />
                          进货成本：
                          <input name="cost" type="text" id="cost" />
                          <input type="button" value="查看历史采购价格" onclick="historyprice()"  />
                          
                          数量：
                          <input name="goods_count" type="text" id="goods_count" />
                          
                          
                          <input type="button" value="添加" onclick="add()" <?php if($iistatus == 1) echo "disabled=\"false\"" ?> />
						   <input type="button" value="打开产品列表" onclick="opengoods()" <?php if($iistatus == 1 || $issave== '0') echo "disabled=\"false\"" ?> />
                           
                           
                           <?php }?>
						  </td>
                        </tr>
            
                      
                      
                      </table></td>
                    </tr>
                    <tr>
                      <td class="left_txt"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><br />
                              3.操作信息<br />
                            <br /></td>
                        </tr>
                        <tr>
                          <td><br />
制单人：
  <input type="text" value="<?php echo $operationuser; ?>" style="border-bottom :1 solid black; border-left :none; border-right :none; border-top :none; BACKGROUND: none transparent scroll repeat 0% 0%; " />
  审核人：
  <input type="text" value="<?php echo $audituser;?>" style="border-bottom :1 solid black; border-left :none; border-right :none; border-top :none; BACKGROUND: none transparent scroll repeat 0% 0%; " />
制作时间：
<input type="text" value="<?php echo $io_addtime;?>" style="border-bottom :1 solid black; border-left :none; border-right :none; border-top :none; BACKGROUND: none transparent scroll repeat 0% 0%; " />
审核时间：
<input type="text" value="<?php echo $io_audittime;?>" style="border-bottom :1 solid black; border-left :none; border-right :none; border-top :none; BACKGROUND: none transparent scroll repeat 0% 0%; "  />
<br /></td>
                        </tr>
                      </table></td>
                    </tr>
          </table></td>
	</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td width="65%">&nbsp;</td>
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
<?php

include "bottom.php";


?>
<script language="javascript">

	function printorder(){
	
		var url = 'productinoutprint.php?ordersn=<?php echo $io_ordersn;?>';
		window.open(url);
		
		
	
	
	
	}
	
	function del(id){
	
	
		
		if(confirm("确认删除此条记录吗")){
			
		location.href="purchaseorderadd.php?&module=purchase&action=采购订单&io_ordersn=<?php echo $io_ordersn;?>&addtype=del&stype=<?php echo $stype;?>&id="+id;
			
			
			
		
		
		}
		
	
	
	}
	
	
	function mod(id){
	
		var goods_cost				= document.getElementById('goods_cost'+id).value;
		var goods_count				= document.getElementById('goods_count'+id).value;
		
		if(confirm("确认删除此条记录吗")){
		
		
		var url					= "purchaseorderadd.php?addtype=mod&module=purchase&action=采购订单&io_ordersn=<?php echo $io_ordersn;?>&stype=<?php echo $stype;?>&goods_count="+goods_count+"&goods_cost="+goods_cost+"&modid="+id;
		
		location.href			= url;
		
		
		
		}
		
	
	}
	

	function add(){
		var io_shipfee					= document.getElementById('io_shipfee').value;
		var io_partner					= document.getElementById('io_partner').value;
		var note						= document.getElementById('note').value;
		var io_purchaseuser				= document.getElementById('io_purchaseuser').value;
		var deliverytime				= document.getElementById('deliverytime').value;
		var io_paymentmethod			= document.getElementById('io_paymentmethod').value;
		var in_warehouse				= document.getElementById('in_warehouse').value;
		var qc_user						= document.getElementById('qc_user').value;
		
		if(io_partner =='') {alert('请选择供应商');return false};
		if(io_purchaseuser =='') {alert('请选择采购员');return false};
		
		if(io_paymentmethod =='') {alert('请选择付款方式');return false};
		if(in_warehouse =='') {alert('请选择入库仓库');return false};
		
		
		
		
		var goods_sn		= document.getElementById('goods_sn').value;
		var goods_count		= document.getElementById('goods_count').value;
		var cost			= document.getElementById('cost').value;
		
		
		if( goods_sn == ""){
				
				alert("产品编号：不能为空");
				document.getElementById('goods_sn').select();
				return false;		
		}
		
		
		if(isNaN(cost) || cost == ""){
				
				alert("成本:只能输入数字");
				document.getElementById('cost').select();
				return false;		
		}
		

		if(isNaN(goods_count) || goods_count == ""){
				
				alert("数量:只能输入数字");
				document.getElementById('goods_count').select();
				return false;		
		}
		

	
				
		location.href="purchaseorderadd.php?&module=purchase&action=采购订单&io_ordersn=<?php echo $io_ordersn;?>&goods_sn="+encodeURIComponent(goods_sn)+"&goods_count="+goods_count+"&stype=<?php echo $stype;?>&cost="+cost+"&addtype=save&io_partner="+io_partner+"&io_purchaseuser="+io_purchaseuser+"&note="+note+"&deliverytime="+deliverytime+"&io_paymentmethod="+io_paymentmethod+"&in_warehouse="+in_warehouse+"&io_shipfee="+io_shipfee+"&qc_user="+qc_user;
		
			
	}
	
	function save(){
		
		var io_partner					= document.getElementById('io_partner').value;
		var note						= document.getElementById('note').value;
		var io_purchaseuser				= document.getElementById('io_purchaseuser').value;
		var deliverytime				= document.getElementById('deliverytime').value;
		var io_paymentmethod			= document.getElementById('io_paymentmethod').value;
		var in_warehouse				= document.getElementById('in_warehouse').value;
		var io_shipfee					= document.getElementById('io_shipfee').value;
		var qc_user					= document.getElementById('qc_user').value;
		if(in_warehouse =='') {alert('请选择入库仓库');return false};
		
		if(io_partner =='') {alert('请选择供应商');return false};
		if(io_purchaseuser =='') {alert('请选择采购员');return false};
		
		if(io_paymentmethod =='') {alert('请选择付款方式');return false};
	
		
		var url					= "purchaseorderadd.php?addtype=save&io_partner="+io_partner+"&io_purchaseuser="+io_purchaseuser+"&note="+note+"&module=purchase&action=采购订单&io_ordersn=<?php echo $io_ordersn;?>&stype=<?php echo $stype;?>&deliverytime="+io_paymentmethod+"&io_paymentmethod="+io_paymentmethod+"&deliverytime="+deliverytime+"&in_warehouse="+in_warehouse+"&io_shipfee="+io_shipfee+"&qc_user="+qc_user;
		location.href			= url;
		
	
	}
	
	function audit(){
	
		
		var url					= "purchaseorderadd.php?addtype=audit&astatus=1&action=采购订单&io_ordersn=<?php echo $io_ordersn;?>&module=purchase&stype=<?php echo $stype;?>";
		location.href			= url;
		
	
	
	}
	
	function auditf(){
	
		
		var url					= "purchaseorderadd.php?addtype=audit&astatus=0&action=采购订单&io_ordersn=<?php echo $io_ordersn;?>&module=purchase&stype=<?php echo $stype;?>";
		location.href			= url;
		
	
	
	}
	
	
	function audittozaitong(){
	
		
		var url					= "purchaseorderadd.php?addtype=audit&astatus=3&action=采购订单&io_ordersn=<?php echo $io_ordersn;?>&module=purchase&stype=<?php echo $stype;?>";
		location.href			= url;
		
	
	
	}
	
	function naudittozaitong(){
	
		
		var url					= "purchaseorderadd.php?addtype=audit&astatus=1&action=采购订单&io_ordersn=<?php echo $io_ordersn;?>&module=purchase&stype=<?php echo $stype;?>";
		location.href			= url;
		
	
	
	}
	function wcustomer0(){
	
	
		
			openwindow("productslistinout.php",'',850,400);
	
	
	}
	
	
	
		function openwindow(url,name,iWidth,iHeight)

{

var url; //转向网页的地址;

var name; //网页名称，可为空;

var iWidth; //弹出窗口的宽度;

var iHeight; //弹出窗口的高度;

var iTop = (window.screen.availHeight-30-iHeight)/2; //获得窗口的垂直位置;

var iLeft = (window.screen.availWidth-10-iWidth)/2; //获得窗口的水平位置;

window.open(url,name,'height='+iHeight+',,innerHeight='+iHeight+',width='+iWidth+',innerWidth='+iWidth+',top='+iTop+',left='+iLeft+',toolbar=yes,menubar=yes,scrollbars=yes,resizeable=yes,location=no,status=no');

}
	
	
	
	function historyprice(){
		
		var goods_sn		= document.getElementById('goods_sn').value;
		if( goods_sn == ""){
				
				alert("产品编号：不能为空,否则不能查年原有采购价格");
				document.getElementById('goods_sn').select();
				return false;		
		}
		openwindow("purchasehistoryprice.php?goods_sn="+goods_sn,'',850,400);
		
	
	
	}
	
	function addstock(id){
	
		
		var stockqty		= document.getElementById('goods_count2'+id).value;
		var url				= "purchaseorderinstok.php?id="+id+"&stockqty="+stockqty+"&in_warehouse=<?php echo $in_warehouse;?>";
		
		openwindow(url,'',850,400);
		
	
		
	
	
	}
	function opengoods(){
		var url				= "goodslist.php?io_ordersn=<?php echo $io_ordersn;?>";
		openwindow(url,'',1000,600);
	}

</script>