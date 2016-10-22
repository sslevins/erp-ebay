<?php
include "include/config.php";
include "top.php";	
	/* 修改客户地址 */
	
	$stype	= $_REQUEST['stype'];
	
	function addoroutstock($io_ordersn,$type,$storeid){
		
		// $type == 0 或为空 表示未审核 $type == B 表示已经审核
		
		global $dbcon,$user;
		$sql		= "select * from ebay_iostoredetail where io_ordersn='$io_ordersn' ";
		$sql			= $dbcon->execute($sql);
		$sql			= $dbcon->getResultArray($sql);
		$runstatus 		= 0;
		if($storeid != '' ){
		
		for($i=0;$i<count($sql);$i++){
		
			
			$id					= $sql[$i]['id'];
			$goods_sn			= $sql[$i]['goods_sn'];
			$goods_count		= $sql[$i]['goods_count'];
			$goods_id 			= $sql[$i]['goods_id'];
			$goods_sn 			= $sql[$i]['goods_sn'];
			$goods_name			= $sql[$i]['goods_name'];
			
			/* 检查是否有对应的仓库编码 */
			
			$vv					= " select * from store_code where goods_sn='$goods_sn' and store_id = '$storeid' and goods_sn_now != '' ";
			$vv					= $dbcon->execute($vv);
			$vv					= $dbcon->getResultArray($vv);
			if(count($vv) > 0){
				$goods_sn			= $vv[0]['goods_sn'];
				$vv					= "select goods_id,goods_name from ebay_goods where goods_sn ='$goods_sn'";
				$vv					= $dbcon->execute($vv);
				$vv					= $dbcon->getResultArray($vv);
				$goods_id			= $vv[0]['goods_id'];
				$goods_name			= $vv[0]['goods_name'];
			}
			
			
			$seq				= "select goods_sn from ebay_onhandle where goods_sn='$goods_sn' and store_id='$storeid' and goods_id='$goods_id'";
			$seq				= $dbcon->execute($seq);
			$seq				= $dbcon->getResultArray($seq);
			if(count($seq) == 0){
			
				$sq			= "insert into ebay_onhandle(goods_id,goods_count,store_id,ebay_user,goods_name,goods_sn) values('$goods_id','0','$storeid','$user','$goods_name','$goods_sn')";
				if(!$dbcon->execute($sq)){
					$status .= " -[<font color='#FF0000'>操作记录: 产品编号:{$goods_sn}入库失败</font>]";
					$runstatus	= 1;
				}
			
			}
			
			
				
				if($type == 1){
					$sq			= "update ebay_onhandle set goods_count=goods_count+$goods_count where goods_sn='$goods_sn' and store_id='$storeid'  and goods_id='$goods_id'";
				}else{
					$sq			= "update ebay_onhandle set goods_count=goods_count-$goods_count where goods_sn='$goods_sn' and store_id='$storeid'  and goods_id='$goods_id'";
				
				}
				
				if(!$dbcon->execute($sq)){
					$status .= " -[<font color='#FF0000'>操作记录: 产品编号:{$goods_sn}入库失败</font>]";
					$runstatus	= 1;
				}
			}

		
		}else{
		
		
		
		$status .= " -[<font color='#FF0000'>操作记录: 入库失败</font>]";
		$runstatus	= 1;
		
		}
		
		
		
		echo $status;
		return $runstatus;
		
	
	
	}
	
	if($_REQUEST['io_ordersn'] == ""){
	
				$io_ordersn	= "IO-".date('Y')."-".date('m')."-".date('d')."-".date("H").date('i').date('s'). mt_rand(100, 999);
				while(true){
					$si		= "select * from ebay_iostore where io_ordersn='$io_ordersn'";
					$si		= $dbcon->execute($si);
					$si		= $dbcon->getResultArray($si);
					if(count($si)==0) break;
					$io_ordersn	= "IO-".date('Y')."-".date('m')."-".date('d')."-".date("H").date('i').date('s'). mt_rand(100, 999);
				}
				
	}else{
		$io_ordersn	= $_REQUEST['io_ordersn'];
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
		
		$sql			= "select io_ordersn from  ebay_iostore where io_ordersn='$io_ordersn'";
		$sql			= $dbcon->execute($sql);
		$sql			= $dbcon->getResultArray($sql);
		$in_type		= $_REQUEST['in_type'];
		$in_warehousefrom	= $_REQUEST['in_warehousefrom'];
		$in_warehouseto	= $_REQUEST['in_warehouseto'];
		$note			= str_rep($_REQUEST['note']);
		$partner		= str_rep($_REQUEST['partner']);
		$io_user		= $_REQUEST['io_user'];
		$trueusername	= $_SESSION['truename'];
		
		if(count($sql) == 0){
			$sql	= "insert into ebay_iostore(partner,io_ordersn,io_addtime,io_warehouse,io_type,io_status,io_note,ebay_user,type,operationuser,io_user,in_warehousefrom,in_warehouseto) values('$partner','$io_ordersn','$mctime','$in_warehouse','$in_type','0','$note','$user','$stype','$trueusername','$io_user','$in_warehousefrom','$in_warehouseto')";
		}else{
			$sql	= "update ebay_iostore set io_warehouse='$in_warehouse',io_type='$in_type',io_note='$note',partner='$partner',io_user='$io_user',in_warehousefrom='$in_warehousefrom',in_warehouseto='$in_warehouseto' where io_ordersn='$io_ordersn'";
		}
		
		if($dbcon->execute($sql)){
			$status	.= " -[<font color='#33CC33'>操作记录:入库单保存成功</font>]";
		}else{
			$status .= " -[<font color='#FF0000'>操作记录: 入库单保存失败</font>]";
		}
		
		/*  添加产品数据 */
		
		
		$goods_sn		= trim($_REQUEST['goods_sn']);
		$goods_count	= $_REQUEST['goods_count'];
		$goods_cost		= $_REQUEST['cost'];
		
		if($goods_sn != '' && $goods_count !='' ){
		$sql			= "select goods_sn,goods_name,goods_cost,goods_unit,goods_id from ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
		$sql			= $dbcon->execute($sql);
		$sql			= $dbcon->getResultArray($sql);
		if(count($sql)  == 0){
			$status .= " -[<font color='#FF0000'>操作记录: 没有产品记录，请添加此产品</font>]";
		}else{
			$goods_name		= $sql[0]['goods_name'];
			$goods_sn		= $sql[0]['goods_sn'];
			$goods_cost		= $sql[0]['goods_cost'];
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
	$sql					= $dbcon->getResultArray($sql);
	$in_type				= $sql[0]['io_type'];
	$io_warehousefrom		= $sql[0]['in_warehousefrom'];
	$io_warehouseto			= $sql[0]['in_warehouseto'];
	$iistatus				= $sql[0]['io_status'];
	
	if($_REQUEST['addtype'] == 'audit'){
		
		
			$astatus		= $_REQUEST['astatus'];
			
			if($astatus >=0){
			}else{
			die('操作失败，请联系技术');
			}
			
			if($astatus == '' ) die('操作失败，请联系技术');
			
			echo $iistatus.' & '.$astatus;
			
			if($iistatus != $astatus){
		
				if($astatus ==0 ){
				$esql			= "update ebay_iostore set io_status='$astatus',io_audittime ='',audituser='' where io_ordersn='$io_ordersn'";
				$esql2			= "update ebay_iostoredetail set status ='' where io_ordersn='$io_ordersn'";
				
				
				$dbcon->execute($esql);
				$dbcon->execute($esql2);
				
				
				addoroutstock($io_ordersn,1,$io_warehousefrom);  // 从来源仓库去  - 去 , 0 是jian去
				
				}else if($astatus ==1){
				$esql			= "update ebay_iostore set io_status='$astatus',io_audittime ='$mctime',audituser='$truename' where io_ordersn='$io_ordersn'";
				$esql2			= "update ebay_iostoredetail set status ='B' where io_ordersn='$io_ordersn'";
				addoroutstock($io_ordersn,0,$io_warehousefrom);  // 从来源仓库去  - 去 , 0 是jian去
				
				$dbcon->execute($esql);
				$dbcon->execute($esql2);
				
				
				
				}else if($astatus == 2){
					
					addoroutstock($io_ordersn,1,$io_warehouseto);  // 从来源仓库去 + 去 , 0 是jian去
					$el			= "update ebay_iostore set io_status='2'  where io_ordersn='$io_ordersn'";
					$dbcon->execute($el);	
				}
				
				
				$status	= " -[<font color='#33CC33'>操作记录: 单据审核成功</font>]";
			
			}else{
			
				$status	= " -[<font color='#FF0000'>操作记录: 单据审核失败</font>]";
			}
	
		
	
	}
	

	
		
	
	$sql				= "select * from  ebay_iostore where io_ordersn='$io_ordersn'";
	$sql				=  $dbcon->execute($sql);
	$sql				=  $dbcon->getResultArray($sql);
	$isadd				= count($sql);
	
	$io_user			=  $sql[0]['io_user'];
	$in_type			=  $sql[0]['io_type'];
	$in_warehouse		=  $sql[0]['io_warehouse'];
	$in_warehouseto			=  $sql[0]['in_warehouseto'];
	$in_warehousefrom		=  $sql[0]['in_warehousefrom'];
	
	$note				=  $sql[0]['io_note'];
	$iistatus			=  $sql[0]['io_status'];
	$partner			=  $sql[0]['partner'];
	$audituser			=  $sql[0]['audituser'];
	$operationuser		=  $sql[0]['operationuser'];
	$audituser			=  $sql[0]['audituser'];
	$io_addtime			=  $sql[0]['io_addtime'];
	if($io_addtime != '') $io_addtime	= date('Y-m-d H:i:s',$io_addtime);
	$io_audittime			=  $sql[0]['io_audittime']?$sql[0]['io_audittime']:'';
	if($io_audittime != '' && $io_audittime != '0') $io_audittime	= date('Y-m-d H:i:s',$io_audittime);
	
		

 ?><div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo '入库单'.$status;?> </h2>
</div>

<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
  <td nowrap="nowrap" scope="row" >
   <?php if($iistatus == '0' || $iistatus == ''){ ?><input name="input" type="button" value="保存单据" onclick="save()" /><?php } ?>
   <?php if($iistatus == '0' || $iistatus == ''){ ?> <input name="input" type="button" value="审核单据" onclick="audit(1)"  /> <?php } ?>
   <?php if($iistatus == '1' ){ ?> 
   
   <input name="input2" type="button" value="反审核单据" onclick="audit(0)" />
   <input name="input2" type="button" value="审核入库" onclick="audit(2)" />
   
   
   <?php } ?>
    <input name="input4" type="button" value="打印单据" onclick="printorder()" /></td>
</tr>
<tr>
	
	
	
		
	<td nowrap="nowrap" scope="row" >&nbsp;<br />
	  <strong>1.填写基本资料	  </strong><br />
	  <br />
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
                      <td class="login_txt_bt"><table width="100%" border="1" cellspacing="3" cellpadding="0">
                        <tr>
                          <td width="8%"> 从仓库</td>
                          <td width="8%"><select name="in_warehousefrom" id="in_warehousefrom">
                            <option value="-1" >未设置</option>
                            <?php 
							$sql	 = "select store_name,id from ebay_store where ebay_user='$user'";
							$sql	 = $dbcon->execute($sql);
							$sql	 = $dbcon->getResultArray($sql);
							for($i=0;$i<count($sql);$i++){					
							$store_name		= $sql[$i]['store_name'];
							$cid			=  $sql[$i]['id'];
					 		?>
                            <option value="<?php echo $cid;?>" <?php if($in_warehousefrom == $cid) echo "selected=selected" ?>><?php echo $store_name;?></option>
                            <?php } ?>
                          </select></td>
                          <td width="4%">到仓库</td>
                          <td width="8%"><select name="in_warehouseto" id="in_warehouseto">
                            <option value="-1" >未设置</option>
                            <?php 
							for($i=0;$i<count($sql);$i++){					
							$store_name	= $sql[$i]['store_name'];
							$cid			=  $sql[$i]['id'];
					 		?>
                            <option value="<?php echo $cid;?>" <?php if($in_warehouseto == $cid) echo "selected=selected" ?>><?php echo $store_name;?></option>
                            <?php } ?>
                          </select>
                          (必填)</td>
                          <td colspan="2" rowspan="2">备注
                          <textarea name="note" cols="70" rows="3" id="note" ><?php echo $note;?></textarea></td>
                        </tr>
                        
                        <tr>
                          <td>经办人</td>
                          <td><select name="io_user" id="io_user">
                            <option value="-1" >未设置</option>
                            <?php 
					
					$sql	 = "select username from ebay_user where user='$user'";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 
					 	$iousername	= $sql[$i]['username'];
				
					 ?>
                            <option value="<?php echo $iousername;?>" <?php if($io_user == $iousername) echo "selected=selected" ?>><?php echo $iousername;?></option>
                            <?php } ?>
                          </select></td>
                          <td>单号</td>
                          <td><input name="io_ordersn" type="text" id="io_ordersn" value="<?php echo $io_ordersn;?>" size="30"   style="border-bottom :1 solid black; border-left :none; border-right :none; border-top :none; BACKGROUND: none transparent scroll repeat 0% 0%; "/>
                         </td>
                        </tr>
                </table></td>
              </tr>
                    <tr>
                      <td valign="top" class="left_txt"><strong>
                      
                      &nbsp;<br />
                      2.产品资料
                      
                      <input name="input3" type="button" value=" 批量导入" onclick="battchtoxls()" />
                      <br />
                      <br />
                      </strong></td>
        </tr>
                    <tr>
                      <td class="login_txt_bt"><table width="100%" border="1" cellspacing="3" cellpadding="0">
                        <tr>
                          <td>产品编号</td>
                          <td>产品名称</td>
                          <td>单位</td>
                          <td>近30天销量</td>
                          <td>近15天销量</td>
                          <td>近7天销量</td>
                          <td>实际库存</td>
                          <td>占用库存</td>
                          <td>已订购</td>
                          <td>可用库存</td>
                          <td>产品进货成本</td>
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
                        
                        <tr>
                          <td><?php echo $goods_sn;?>&nbsp;</td>
                          <td><?php echo $goods_name;?>&nbsp;</td>
                          <td><?php echo $goods_unit;?>&nbsp;</td>
                          <td><?php
						  
						  $start1						= date('Y-m-d').'23:59:59';	
						  $start0						= date('Y-m-d',strtotime("$start1 -30 days")).' 00:00:00';
						  $qty1							= getProductsqty($start0,$start1,$goods_sn,$in_warehouse);
						  echo $qty1;
						  ?>                      &nbsp;</td>
                          <td><?php
						  
						  $start1						= date('Y-m-d').'23:59:59';	
						  $start0						= date('Y-m-d',strtotime("$start1 -15 days")).' 00:00:00';
						  $qty1							= getProductsqty($start0,$start1,$goods_sn,$in_warehouse);
						  echo $qty1;
						  
						  
						  ?>                            &nbsp;</td>
                          <td><?php
						  
						  $start1						= date('Y-m-d').'23:59:59';	
						  $start0						= date('Y-m-d',strtotime("$start1 -7 days")).' 00:00:00';
						  $qty1							= getProductsqty($start0,$start1,$goods_sn,$in_warehouse);
						  echo $qty1;
						  ?>                            &nbsp;</td>
                          <td>
						  
                          <?php
					
								 
					
									
							$seq				= "select goods_count from ebay_onhandle where goods_sn='$goods_sn' and store_id='$in_warehouse' ";
							$seq				= $dbcon->execute($seq);
							$seq				= $dbcon->getResultArray($seq);
							$truestock			= $seq[0]['goods_count']?$seq[0]['goods_count']:0;
							echo $truestock;
							
							?>
                            
                            
                          </td>
                          <td><?php
						  
						  
						   $stockused	= stockused($goods_sn,$in_warehouse);
						   echo $stockused;
						   
						
						  
						  ?>                            &nbsp;</td>
                          <td><?php
						  
						  $stockbookused	= stockbookused($goods_sn,$in_warehouse);
						  echo $stockbookused;
						  ?></td>
                          <td><?php
							echo abs($goods_count - $stockused);
							?></td>
                          <td>&nbsp;
                          <textarea name="goods_cost<?php echo $id ?>" cols="5" rows="1" id="goods_cost<?php echo $id ?>" ><?php echo $goods_cost;?></textarea></td>
                          <td>&nbsp;
                          <textarea name="goods_count<?php echo $id ?>" cols="6" rows="1" id="goods_count<?php echo $id ?>" ><?php echo $goods_count;?></textarea></td>
                          <td>
                           <?php if($iistatus == '0' || $iistatus == ''){ ?>
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
                          <td>总成本&nbsp;</td>
                          <td><?php echo $totalprice;?>&nbsp;</td>
                          <td><?php echo $totalqty;?>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="13">产品编号：
                           
					
							<input name="goods_sn" type="text" id="goods_sn" />
                            
                          数量：
                          <input name="goods_count" type="text" id="goods_count" />
                          
                           <?php if($iistatus == '0' || $iistatus == ''){ ?>
                          <input type="button" value="添加" onclick="add()" <?php if($iistatus == 1) echo "disabled=\"false\"" ?> />
                          <?php } ?>
                          
                          </td>
                        </tr>
            
                      
                      
                      </table></td>
                    </tr>
                    <tr>
                      <td class="left_txt"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><strong><br />
                            3.操作信息<br />
                          <br />
                          </strong></td>
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
			
		location.href="wtowarehouseadd.php?&module=orders&action=入库&io_ordersn=<?php echo $io_ordersn;?>&addtype=del&stype=<?php echo $stype;?>&id="+id;
			
			
			
		
		
		}
		
	
	
	}
	
	
	function mod(id){
	
		var goods_cost				= document.getElementById('goods_cost'+id).value;
		var goods_count				= document.getElementById('goods_count'+id).value;
		
		if(confirm("确认删除此条记录吗")){
		
		
		var url					= "wtowarehouseadd.php?addtype=mod&module=warehouse&action=入库&io_ordersn=<?php echo $io_ordersn;?>&stype=<?php echo $stype;?>&goods_count="+goods_count+"&goods_cost="+goods_cost+"&modid="+id;
		
		location.href			= url;
		
		
		
		}
		
	
	}
	

	function add(){
		
		
		var in_type				= '';
		
		var in_warehousefrom		= document.getElementById('in_warehousefrom').value;
		var in_warehouseto			= document.getElementById('in_warehouseto').value;
		if(in_warehousefrom == in_warehouseto){			
			alert('两个仓库不能相同');
			return false;
		}
		
		
		var note				= document.getElementById('note').value;
		var io_user				= document.getElementById('io_user').value;

		if(io_user == '') {
		alert('请选择经办人');
		return false
		};
		
		
		
		var goods_sn		= document.getElementById('goods_sn').value;
		var goods_count		= document.getElementById('goods_count').value;
		
		
		if( goods_sn == ""){
				
				alert("产品编号：不能为空");
				document.getElementById('goods_sn').select();
				return false;		
		}
		

		if(isNaN(goods_count) || goods_count == ""){
				
				alert("数量:只能输入数字");
				document.getElementById('goods_count').select();
				return false;		
		}
		
				
		location.href="wtowarehouseadd.php?&module=warehouse&action=入库&io_ordersn=<?php echo $io_ordersn;?>&goods_sn="+encodeURIComponent(goods_sn)+"&goods_count="+goods_count+"&addtype=add&stype=<?php echo $stype;?>&addtype=save&in_type="+in_type+"&in_warehousefrom="+in_warehousefrom+"&note="+note+"&io_user="+io_user+"&in_warehouseto="+in_warehouseto;
		
			
	}
	
	function save(){
		
		var in_type					= '';
		var in_warehousefrom		= document.getElementById('in_warehousefrom').value;
		var in_warehouseto			= document.getElementById('in_warehouseto').value;
		if(in_warehousefrom == in_warehouseto){			
			alert('两个仓库不能相同');
			return false;
		}
		var note				= document.getElementById('note').value;
		var io_user				= document.getElementById('io_user').value;
		if(in_type <0) {alert('请选择入库类型');return false};
		if(in_warehousefrom <0) {alert('请选择调拨仓库');return false;}
		if(in_warehouseto <0) {alert('请选择调入仓库');return false;}
		
		
		
		
		var url					= "wtowarehouseadd.php?addtype=save&in_type="+in_type+"&in_warehousefrom="+in_warehousefrom+"&note="+note+"&module=warehouse&action=入库&io_ordersn=<?php echo $io_ordersn;?>&stype=<?php echo $stype;?>&io_user="+io_user+"&in_warehouseto="+in_warehouseto;
		location.href			= url;
		
	
	}
	
	function audit(astatus){
	
		
		var url					= "wtowarehouseadd.php?addtype=audit&astatus="+astatus+"&action=入库&io_ordersn=<?php echo $io_ordersn;?>&module=warehouse&action=入库&stype=<?php echo $stype;?>";
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


function battchtoxls(){
		
		
		var isadd		= "<?php echo $isadd;?>";
	if(isadd == 0){
		
		alert('请先保存单据');
		return false;
	
	}
	openwindow("battchuploadps.php?io_ordersn=<?php echo $io_ordersn;?>",'',850,400);
		
	}
	
	
	

</script>