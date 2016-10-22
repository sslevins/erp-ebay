<?php
include "include/config.php";
include "top.php";	
	/* 修改客户地址 */
	
	$stype	= $_REQUEST['stype'];
	
	
	function addoroutstock($io_ordersn,$type,$storeid){
	
		
		global $dbcon,$user;
		$sql		= "select * from ebay_iostoredetail where io_ordersn='$io_ordersn'";
		$sql			= $dbcon->execute($sql);
		$sql			= $dbcon->getResultArray($sql);
		for($i=0;$i<count($sql);$i++){
		
			
			$goods_sn			= $sql[$i]['goods_sn'];
			$goods_count		= $sql[$i]['goods_count'];
			$goods_id 			= $sql[$i]['goods_id'];
			$goods_sn 			= $sql[$i]['goods_sn'];
			$goods_name			= $sql[$i]['goods_name'];
			
			
			$seq				= "select * from ebay_onhandle where goods_id='$goods_id' and store_id='$storeid'";
		
			$seq				= $dbcon->execute($seq);
			$seq				= $dbcon->getResultArray($seq);
			if(count($seq) == 0){
			

				$sq			= "insert into ebay_onhandle(goods_id,goods_count,store_id,ebay_user,goods_name,goods_sn) values('$goods_id','$goods_count','$storeid','$user','$goods_name','$goods_sn')";
				
				if($dbcon->execute($sq)){
			
					
					$status	= " -[<font color='#33CC33'>操作记录: 数据保存成功</font>]";
					
				}else{
				
				
					$status = " -[<font color='#FF0000'>操作记录: 数据保存失败</font>]";
		
				}
				
			
			}else{
				
				if($type == 1){
				
					$sq			= "update ebay_onhandle set goods_count=goods_count-$goods_count where goods_id='$goods_id' and store_id='$storeid'";
				}else{
				
					$sq			= "update ebay_onhandle set goods_count=goods_count+$goods_count where goods_id='$goods_id' and store_id='$storeid'";
				
				}
				
				if($dbcon->execute($sq)){
			
					
					$status	= " -[<font color='#33CC33'>操作记录: 数据保存成功</font>]";
					
				}else{
				
				
					$status = " -[<font color='#FF0000'>操作记录: 数据保存失败</font>]";
		
				}
				
			
			}
		
						
			
			
		
		
		}
	
	
	
	}
	
	if($_REQUEST['io_ordersn'] == ""){
	
		$io_ordersn	= "OO-".date('Y')."-".date('m')."-".date('d')."-".date("H").date('i').date('s'). mt_rand(100, 999);
	}else{
		$io_ordersn	= $_REQUEST['io_ordersn'];
	}
	
	if($_REQUEST['addtype'] == 'add'){
		$goods_sn		= $_REQUEST['goods_sn'];
		$goods_count	= $_REQUEST['goods_count'];
		$sql			= "select * from ebay_goods where goods_sn='$goods_sn'";
		$sql			= $dbcon->execute($sql);
		$sql			= $dbcon->getResultArray($sql);
		if(count($sql)  == 0){
			$status = " -[<font color='#FF0000'>操作记录: 没有产品记录，请添加此产品</font>]";
		}else{
			$goods_name		= $sql[0]['goods_name'];
			$goods_price	= $sql[0]['goods_price'];
			$goods_unit		= $sql[0]['goods_unit'];
			$goods_id		= $sql[0]['goods_id'];
			
			$sql		= "insert into ebay_iostoredetail(io_ordersn,goods_name,goods_sn,goods_price,goods_unit,goods_count,goods_id) values('$io_ordersn','$goods_name','$goods_sn','$goods_price','$goods_unit','$goods_count','$goods_id')";
			
				
		if($dbcon->execute($sql)){
			
			
			$status	= " -[<font color='#33CC33'>操作记录: 产品添加成功</font>]";
			
		}else{
		
		
			$status = " -[<font color='#FF0000'>操作记录: 产品添加失败</font>]";

		}
		
			
		
		
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
		$in_type		= $_REQUEST['in_type'];
		$in_warehouse	= $_REQUEST['in_warehouse'];
		$note			= str_rep($_REQUEST['note']);
		$partner			= str_rep($_REQUEST['partner']);
		
		if(count($sql) == 0){
		
			
			$sql	= "insert into ebay_iostore(partner,io_ordersn,io_addtime,io_warehouse,io_type,io_status,io_note,ebay_user,type) values('$partner','$io_ordersn','$mctime','$in_warehouse','$in_type','0','$note','$user','$stype')";
			
		
		}else{
		
			
			$sql	= "update ebay_iostore set partner='$partner',io_warehouse='$in_warehouse',io_type='$in_type',io_note='$note' where io_ordersn='$io_ordersn'";
			
		}
				if($dbcon->execute($sql)){
			
			
			$status	= " -[<font color='#33CC33'>操作记录: 产品添加成功</font>]";
			
		}else{
		
		
			$status = " -[<font color='#FF0000'>操作记录: 产品添加失败</font>]";

		}	
	
	
	
	}
	
	
	
	$sql			= "select * from  ebay_iostore where io_ordersn='$io_ordersn'";
	
	
	$sql			= $dbcon->execute($sql);
	$sql			= $dbcon->getResultArray($sql);
	$in_type		= $sql[0]['io_type'];
	$in_warehouse	= $sql[0]['io_warehouse'];
	$note			= $sql[0]['io_note'];
	$iistatus		=  $sql[0]['io_status'];
	$partner		=  $sql[0]['partner'];
	
	if($_REQUEST['addtype'] == 'audit'){
		
		
		$astatus		= $_REQUEST['astatus'];
		$io_status 		= $sql[0]['io_status'];
		
		$esql			= "update ebay_iostore set io_status='$astatus' where io_ordersn='$io_ordersn'";
		if($dbcon->execute($esql)){
			
			
			$status	= " -[<font color='#33CC33'>操作记录: 单据审核成功</font>]";
			
			if($io_status ==0 && $astatus ==1){
				
				
				echo "审核成功";
				
				addoroutstock($io_ordersn,$astatus,$in_warehouse);
				
				
				
				
			
			
			}else if($io_status ==1 && $astatus ==0){
			
				
				echo "反审核成功";
				addoroutstock($io_ordersn,$astatus,$in_warehouse);
				
			}
			
			
			
		}else{
		
		
			$status = " -[<font color='#FF0000'>操作记录: 单据审核成功</font>]";

		}	
	
		
		
		
	}
	
	
	
	
	if($stype   == '1') $strtype	= "出库";
		
		
		
		
	



 ?>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status;?> </h2>
</div>

<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
	
	
	
		
	<td nowrap="nowrap" scope="row" >&nbsp;<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
                      <td class="login_txt_bt"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><?php echo $strtype;?>：</td>
                          <td><select name="in_type" id="in_type">
                            <option value="-1" >未设置</option>
                            <?php 
					
					$sql	 = "SELECT * FROM `ebay_storetype` where ebay_user='$user' and ebay_storetype='1'";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 
					 	$ebay_storename	= $sql[$i]['ebay_storename'];
						$cid			=  $sql[$i]['id'];
					 ?>
                            <option value="<?php echo $cid;?>" <?php if($in_type == $cid) echo "selected=selected" ?>><?php echo $ebay_storename;?></option>
                            <?php } ?>
                          </select></td>
                          <td>仓库</td>
                          <td><select name="in_warehouse" id="in_warehouse">
                            <option value="-1" >未设置</option>
                            <?php 
					
					$sql	 = "select * from ebay_store where ebay_user='$user'";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 
					 	$store_name	= $sql[$i]['store_name'];
						$cid			=  $sql[$i]['id'];
					 ?>
                            <option value="<?php echo $cid;?>" <?php if($in_warehouse == $cid) echo "selected=selected" ?>><?php echo $store_name;?></option>
                            <?php } ?>
                          </select></td>
                          <td>单号</td>
                          <td><input name="io_ordersn" type="text" id="io_ordersn" value="<?php echo $io_ordersn;?>" size="30">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>备注：</td>
                          <td><textarea name="note" cols="40" id="note"><?php echo $note;?></textarea></td>
                          <td>&nbsp;</td>
                          <td colspan="5">&nbsp;</td>
                        </tr>
                </table></td>
              </tr>
                    <tr>
                      <td valign="top" class="left_txt">
                      
                      &nbsp;<br>
                      <p><br>
                      </p>
                      <p><br>
                        </p></td>
                    </tr>
                    <tr>
                      <td class="login_txt_bt"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td>产品编号</td>
                          <td>产品名称</td>
                          <td>产品售价</td>
                          <td>单位</td>
                          <td>数量</td>
                          <td>操作</td>
                        </tr>
                        
                        <?php
							
							$sql	= "select * from ebay_iostoredetail where io_ordersn='$io_ordersn'";
						
							
							$sql	= $dbcon->execute($sql);
							$sql	= $dbcon->getResultArray($sql);
							for($i=0;$i<count($sql);$i++){
								
								$goods_sn			= $sql[$i]['goods_sn'];
								$goods_name 		= $sql[$i]['goods_name'];
								$goods_price 		= $sql[$i]['goods_price'];
								$goods_unit 		= $sql[$i]['goods_unit'];
								$id					= $sql[$i]['id'];
								$goods_count  		= $sql[$i]['goods_count'];
								
						?>
                        
                        <tr>
                          <td><?php echo $goods_sn;?>&nbsp;</td>
                          <td><?php echo $goods_name;?>&nbsp;</td>
                          <td><?php echo $goods_price;?>&nbsp;</td>
                          <td><?php echo $goods_unit;?>&nbsp;</td>
                          <td><?php echo $goods_count;?>&nbsp;</td>
                          <td><a href="#" onclick="del('<?php echo $id;?>')">删除</a></td>
                        </tr>
                      	<?php
						
						}
						
						?>
                        
                      
                      
                      </table></td>
                    </tr>
                    <tr>
                      <td class="left_txt"><table width="70%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><br />
产品编号：<input name="goods_sn" type="text" id="goods_sn">
                            产品数量：
                            <input name="goods_count" type="text" id="goods_count"><input type="button" value="添加" onClick="add()" <?php if($iistatus == 1) echo "disabled=\"false\"" ?> ></td>
                        </tr>
                        <tr>
                          <td><br />
<br />
<input name="" type="button" value="保存单据" onclick="save()" />
<input name="input" type="button" value="审核单据" onclick="audit()" />
<input name="input2" type="button" value="反审核单据" onclick="auditf()" />
                          <input name="input3" type="button" value="关闭窗口" onclick="javascript:window.close();" /></td>
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
	
	function del(id){
	
	
		
		if(confirm("确认删除此条记录吗")){
			
		location.href="outstoreadd.php?&module=orders&action=出库&io_ordersn=<?php echo $io_ordersn;?>&addtype=del&stype=<?php echo $stype;?>&id="+id;
			
			
			
		
		
		}
		
	
	
	}
	

	function add(){
	
		
		var goods_sn		= document.getElementById('goods_sn').value;
		var goods_count		= document.getElementById('goods_count').value;
	
		

		if(isNaN(goods_count) || goods_count == ""){
				
				alert("数量只能输入数字");
				document.getElementById('goods_count').select();
				return false;		
				
			
		}
		
				
		location.href="outstoreadd.php?&module=warehouse&action=出库&io_ordersn=<?php echo $io_ordersn;?>&goods_sn="+goods_sn+"&goods_count="+goods_count+"&addtype=add&stype=<?php echo $stype;?>";
			
	}
	
	function save(){
		
		var in_type				= document.getElementById('in_type').value;
		var in_warehouse		= document.getElementById('in_warehouse').value;
		var note				= document.getElementById('note').value;
		var partner				= "";
		
		if(in_type <0) {alert('请选择出库类型');return false};
		if(in_warehouse <0) {alert('请选择出库类型');return false;}
		
		
		var url					= "outstoreadd.php?addtype=save&in_type="+in_type+"&in_warehouse="+in_warehouse+"&note="+note+"&module=warehouse&action=出库&io_ordersn=<?php echo $io_ordersn;?>&stype=<?php echo $stype;?>&partner="+partner;
		location.href			= url;
		
	
	}
	
	function audit(){
	
		
		var url					= "outstoreadd.php?addtype=audit&astatus=1&action=出库&io_ordersn=<?php echo $io_ordersn;?>&module=warehouse&action=出库&stype=<?php echo $stype;?>";
		location.href			= url;
		
	
	
	}
	
	function auditf(){
	
		
		var url					= "outstoreadd.php?addtype=audit&astatus=0&action=出库&io_ordersn=<?php echo $io_ordersn;?>&module=warehouse&action=出库&stype=<?php echo $stype;?>";
		location.href			= url;
		
	
	
	}
	


</script>