<?php
include "include/config.php";


include "top.php";

$cpower	= explode(",",$_SESSION['power']);

$warehouse			= $_REQUEST['warehouse'];
$keys				= trim($_REQUEST['keys']);
$searchs			= $_REQUEST['searchs'];
$factory			= $_REQUEST['factory'];
$type				= $_REQUEST['type'];
$isuse				= $_REQUEST['isuse'];
$goodssort					= $_REQUEST['goodssort'];
$sortwarehouse				= $_REQUEST['sortwarehouse'];

if($type 	== "delsystem"){
	
	$ordersn = explode(",",$_REQUEST['ordersn']);

	
	$status  = "";
	for($g=0;$g<count($ordersn);$g++){
		
		
		$sn 	=  $ordersn[$g];

		if($sn != ""){
			$ss			= "select id from ebay_onhandle where goods_id='$sn'";
			$ss			= $dbcon->execute($ss);
			$ss			= $dbcon->getResultArray($ss);
			$goods_count	= $ss[0]['goods_count'];
			if($goods_count > 0){
				$status = " -[<font color='#FF0000'>操作记录: 此产品有库存，系统无法删除</font>]";
			}else{
				$sql		= "delete  from  ebay_goods where goods_id='$sn'";
				if($dbcon->execute($sql)){
						$status	= " -[<font color='#33CC33'>操作记录: 记录删除成功</font>]";
						$sq2		= "delete  from  ebay_onhandle where goods_id='$sn'";
						$dbcon->execute($sq2);
				}else{
								$status = " -[<font color='#FF0000'>操作记录: 记录删除失败</font>]";
				}
			}
		}
	}
	
}



	
	
 ?>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status;?> </h2>
</div>

<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
		
	<td nowrap="nowrap" scope="row" >查找：
	  <input name="keys" type="text" id="keys" value=<?php echo $keys; ?> >
	  <select name="searchs" id="searchs" >
        <option value="0" <?php if($searchs == '0') echo 'selected="selected"';?>>关键字</option>
        <option value="1" <?php if($searchs == '1') echo 'selected="selected"';?>>物品编号(SKU)</option>
        <option value="2" <?php if($searchs == '2') echo 'selected="selected"';?>>物品名称</option>
        <option value="3" <?php if($searchs == '3') echo 'selected="selected"';?>>单位</option>
        <option value="4" <?php if($searchs == '4') echo 'selected="selected"';?>>产品货位</option>
        <option value="5" <?php if($searchs == '5') echo 'selected="selected"';?>>重量</option>
      </select>
	  供应商：
	   <select name="factory" id="factory" >
        <option value="">请选择</option>
		 <?php 
		
		$sql = "select id,company_name from  ebay_partner where ebay_user='$user'";									
		$sql = $dbcon->execute($sql);
		$sql = $dbcon->getResultArray($sql);

		for($i=0;$i<count($sql);$i++){
			$id					= $sql[$i]['id'];
			$company_name			= $sql[$i]['company_name'];	
		?>
		<option value="<?php echo $id;?>" <?php if ($factory == $id) echo 'selected="selected"';?> ><?php echo $company_name; ?></option>
		<?php
		}
		
		
		?>
      </select>
	  类别：
<select name="goodscategory" id="goodscategory">
                            <option value="-1">Please Select</option>
                             <?php 
					$sql		= "select * from ebay_goodscategory where ebay_user='$user' and pid	= 0";
					$sql		= $dbcon->execute($sql);
					$sql		= $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){
					
						$id			= $sql[$i]['id'];
						$name		= $sql[$i]['name'];
						$pid		= $sql[$i]['pid'];
						
						echo "<option value=\"{$id}\">$name</option>";
						
						/*第二层目录*/
						$sq2		= "select * from ebay_goodscategory where ebay_user='$user' and pid	= '$id'";						
						$sq2		= $dbcon->execute($sq2);
						$sq2		= $dbcon->getResultArray($sq2);
						if(count($sq2) >0){
						for($a=0;$a<count($sq2);$a++){
							
							$id2	= $sq2[$a]['id'];
							$iname2	= $sq2[$a]['name'];
							$pid2	= $sq2[$a]['pid'];
												
							echo "<option value=\"{$id2}\">&nbsp;&nbsp {$iname2}</option>";
							
							
							/* 第三导目录 */
							
								$sq3		= "select * from ebay_goodscategory where ebay_user='$user' and pid	= '$id2'";						
								$sq3		= $dbcon->execute($sq3);
								$sq3		= $dbcon->getResultArray($sq3);
								if(count($sq3) >0){
								for($b=0;$b<count($sq3);$b++){
									
									$id3	= $sq3[$b]['id'];
									$iname3	= $sq3[$b]['name'];
									$pid3	= $sq3[$b]['pid'];
														
									echo "<option value=\"{$id3}\">&nbsp;&nbsp;&nbsp;&nbsp;{$iname3}</option>";
									
												
								}
								}
								
										
						}
						}
					
					?>
                        <?php
					
					}
					?>
                          </select>
     产品状态：
                          
            <select name="isuse" id="isuse">
                            <option value="">请选择</option>
                             <?php 
							$sql = "select status from  ebay_goodsstatus where ebay_user='$user'";									
							$sql = $dbcon->execute($sql);
							$sql = $dbcon->getResultArray($sql);
							for($i=0;$i<count($sql);$i++){
								$status			= $sql[$i]['status'];
							?>
                            <option value="<?php echo $status;?>" <?php if($status ==$isuse) echo "selected=selected";?>><?php echo $status; ?></option>
                            <?php
							}
							?>
                          </select>
            仓库：
<select name="warehouse" id="warehouse">
                            <option value="0">Please select</option>
                            <?php 
							
							$sql = "select id,store_name from  ebay_store where ebay_user='$user'";									
							$sql = $dbcon->execute($sql);
							$sql = $dbcon->getResultArray($sql);
				
							for($i=0;$i<count($sql);$i++){
								$id					= $sql[$i]['id'];
								$store_name			= $sql[$i]['store_name'];	
							?>
                            <option value="<?php echo $id;?>" <?php if ($$warehouse == $id) echo 'selected="selected"';?>><?php echo $store_name; ?></option>
                            <?php
							}
							
							
							?>
                            
                            
                          </select>
                          
    
    
    <input type="button" value="查找" onclick="searchorder()" />
	<br />
	操作：
<?php if(in_array("s_gm_delete",$cpower)){?>	<input class='button' type="button" name='search_form_submit' value='删除' id='search_form_submit2' onclick="deleteallsystem()" /><?php }?>
	<input class='button' type="button" name='search_form_submit3' value='复制' id='search_form_submit4' onclick="copyproducts()" />
	
<?php if(in_array("s_gm_add",$cpower)){?>    <input class='button' type="button" name='button' value='添加货品' id='search_form_submit1' onclick="javascript:location.href='productadd.php?module=warehouse&action=货品资料添加'" /><?php }?>
<?php if(in_array("s_gm_add",$cpower)){?>   <input class='button' type="button" name='button' value='货品资料导入' id='search_form_submit8' onclick="javascript:location.href='productaddxls.php?module=warehouse&action=货品资料导入'" /><?php }?>

<?php if(in_array("s_gm_export",$cpower)){?> 
       <input class='button' type="button" name='search_form_submit2' value='货品资料导出' id='search_form_submit3' onclick="exporttoxls()" />
<?php }?>

<?php if(in_array("s_gm_bexport",$cpower)){?> 
       <input class='button' type="button" name='search_form_submit6' value='批量更新库存' id='search_form_submit6' onclick="javascript:location.href='stockupdate.php?module=warehouse&amp;action=批量更新库存'" />
<?php }?>


<?php if(in_array("s_gm_sexport",$cpower)){?> 
       <input class='button' type="button" name='search_form_submit4' value='货品库存导出' id='search_form_submit5' onclick="mod2()" />
<?php }?>
	  <input class='button' type="button" name='search_form_submit7' value='sku中英文对照' id='search_form_submit7' onclick="javascript:location.href='skulist.php?module=warehouse&amp;action=sku中英文对照'" />
	  <input class='button' type="button" name='search_form_submit7' value='sku国家备注' id='search_form_submit8' onclick="javascript:location.href='skucountrynote.php?module=warehouse&amp;action=sku国家备注'" />
       <input class='button' type="button" name='button' value='全选' id='search_form_submit' onclick="check_all('ordersn','ordersn')" />
	    <input class='button' type="button" name='search_form_submit11' value='产品状态导出' id='search_form_submit11' onclick="javascript:location.href='productstatusxls.php?module=warehouse&amp;action=产品状态导出'" />
		 <input class='button' type="button" name='search_form_submit12' value='产品状态导入' id='search_form_submit12' onclick="javascript:location.href='productaddstatus.php?module=warehouse&amp;action=产品状态导入'" />
		 <input class='button' type="button" name='search_form_submit13' value='包装信息导入' id='search_form_submit12' onclick="javascript:location.href='goodsbzaddxls.php?module=warehouse&amp;action=包装信息导入'" />
		 <input class='button' type="button" name='search_form_submit13' value='包装信息导出' id='search_form_submit12' onclick="javascript:location.href='goodsbzxls.php?module=warehouse&amp;action=包装信息导出'" />
       <br />
       排序：
       <select name="sortwarehouse" id="sortwarehouse">
         <option value="">Please select</option>
         <?php 
							
							$sql = "select id,store_name from  ebay_store where ebay_user='$user'";									
							$sql = $dbcon->execute($sql);
							$sql = $dbcon->getResultArray($sql);
				
							for($i=0;$i<count($sql);$i++){
								$id					= $sql[$i]['id'];
								$store_name			= $sql[$i]['store_name'];	
							?>
         <option value="<?php echo $id;?>" <?php if($sortwarehouse == $id) echo 'selected="selected"';?> ><?php echo $store_name; ?></option>
         <?php
							}
							
							
							?>
       </select>
       <select name="goodssort" id="goodssort">
         <option value="">Please Select</option>
         <option value="1" <?php if($goodssort == '1') echo 'selected="selected"';?>>按数量升序</option>
         <option value="2" <?php if($goodssort == '2') echo 'selected="selected"';?>>按数量降序</option>
        
       </select>
       <input type="button" value="排序" onclick="searchordersort()" /></td>
</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='15'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" width='2%' class='paginationActionButtons'>&nbsp;</td>
				  <td  nowrap='nowrap' width='1%' align="right" class='paginationChangeButtons'>				  </td>
				</tr>
			</table>		</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>操作</div></th>
			
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>SKU</div></th>
			
					<th scope='col' nowrap="nowrap">图片</th>
  <th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>中文	名称</div>			</th>
			
		<th scope='col' nowrap="nowrap">产品单价</th>
		<th scope='col' nowrap="nowrap"><span class="left_bt2">成本</span></th>
		<th scope='col' nowrap="nowrap">最新进价</th>
		<th scope='col' nowrap="nowrap">平均进价</th>
        <th scope='col' nowrap="nowrap">实际库存</th>
                    <th scope='col' nowrap="nowrap">重量</th>
                    <th scope='col' nowrap="nowrap">状态</th>
        <th scope='col' nowrap="nowrap">带包装</th>
        <th scope='col' nowrap="nowrap">操作</th>
	</tr>
		


			  <?php
			  	
				
			
				$sql		= "select * from ebay_newgoods as a where ebay_user='$user'";
				
				$goods_sx		= $_REQUEST['sx'];
				$goods_xx		= $_REQUEST['xx'];
				
				$warehouse		= $_REQUEST['warehouse'];
				if($warehouse != '' && $warehouse != '0'){
					$sql	= "select * from ebay_goods as a join  ebay_onhandle as b ON a.goods_id = b.goods_id where b.store_id='$warehouse' and a.ebay_user='$user'";
					
				}
				
				if($sortwarehouse > 0){
					
					
					$sql	= "select * from ebay_goods as a join  ebay_onhandle as b ON a.goods_id = b.goods_id where  a.ebay_user='$user' and b.store_id='$sortwarehouse'";
					
				}
				
				
				
				if($searchs == '0') {
				
				$sql	.= " and(a.goods_name like '%$keys%' or a.goods_sn like '%$keys%')";
				}
				
				if($searchs == '1'){
					 $sql	.= " and a.goods_sn = '$keys' ";
				}
				
				if($searchs == '2'){
				 $sql	.= " and a.goods_name = '$keys' ";
				}
				
				if($searchs == '5'){
				 $sql	.= " and a.goods_weight = '$keys' ";
				}
				
				if($factory){
					$sql   .= " and a.goods_suppliers = '$factory' ";
				
				}
				$goodscategory	= $_REQUEST['goodscategory'];
				/* 检查是否有子类 */
				$ss				= "select * from ebay_goodscategory where pid ='$goodscategory' ";
				$ss				= $dbcon->execute($ss);
				$ss				= $dbcon->getResultArray($ss);
				if($goodscategory!="" && $goodscategory !="-1"){
				
					if(count($ss) == 0){
						
						 $sql	.= " and a.goods_category='$goodscategory' ";
					 $sql2	.= " and a.goods_category='$goodscategory' ";
					}else{
					
						$strline		= '';
						
						for($i=0;$i<count($ss);$i++){
							
							$pid		= $ss[$i]['id'];
							$strline	.= " a.goods_category='$pid' or ";

						}
						
						$strline		= substr($strline,0,strlen($strline)-3);
						
						
						 $sql	.= " and ( $strline )";
					 $sql2	.= " and ( $strline )";
					}
				
				}
				
				
				$isuse	= $_REQUEST['isuse'];
				if($isuse!="" && $isuse !="-1"){
				
				 $sql	.= " and a.goods_status='$isuse'";
				 $sql2	.= " and a.goods_status='$isuse'";
				}
				
				
				if($goodssort == '1'){
				
				 $sql	.= " order by b.goods_count	 asc ";
				}else if($goodssort == '2'){
				
				$sql	.= " order by b.goods_count  desc ";
				}else{
				$sql	.= " order by a.goods_sn desc ";
				}
				
				
				
				echo $sql;
				
				
				$query		= $dbcon->query($sql);
				$total		= $dbcon->num_rows($query);
				
				$pageindex  =( isset($_GET['pageindex']) )?$_GET['pageindex']:1;
				$limit = " limit ".($pageindex-1)*$pagesize.",$pagesize";
		
				
				$page=new page(array('total'=>$total,'perpage'=>$pagesize));
				$sql = $sql.$limit;
				$sql		= $dbcon->execute($sql);
				$sql		= $dbcon->getResultArray($sql);
				for($i=0;$i<count($sql);$i++){
					
					$goods_register		= $sql[$i]['goods_register'];			
					$goods_id		= $sql[$i]['goods_id'];
					$goods_sn		= $sql[$i]['goods_sn'];
					$goods_name		= $sql[$i]['goods_name'];
					$goods_price	= $sql[$i]['goods_price']?$sql[$i]['goods_price']:0;
					$goods_cost		= $sql[$i]['goods_cost']?$sql[$i]['goods_cost']:0;
					$goods_count	= $sql[$i]['goods_count']?$sql[$i]['goods_count']:0;
					$goods_weight	= $sql[$i]['goods_weight']?$sql[$i]['goods_weight']:"";
					$goods_note		= $sql[$i]['goods_note']?$sql[$i]['goods_note']:"";
					$goods_pic		= $sql[$i]['goods_pic']?$sql[$i]['goods_pic']:"";
					$goods_status			= $sql[$i]['goods_status'];
					
					
			  ?>
              
              
                  
         		<tr height='20' class='oddListRowS1'>
						<td scope='row' align='left' valign="top" ><input name="ordersn" type="checkbox" id="ordersn" value="<?php echo $goods_id;?>" ></td>
				
						    <td scope='row' align='left' valign="top" >
							<?php echo $goods_sn; ?>                            </td>
				
						    <td scope='row' align='left' valign="top" >
                        
                        
                        	<?php
							
							if($goods_pic){
							 ?>
                            <img src="images/<?php echo $goods_pic; ?>" width="50" height="50" />
                            <?php }else{ ?>
                            
                            <img src="images/<?php echo $goods_sn.'.jpg'; ?>" width="50" height="50" />
                            <?php } ?>
                            
                                                                            </td>
						    <td scope='row' align='left' valign="top" ><?php echo $goods_name;?></td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $goods_price;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" >
							
							
							<?php 
							

							if(in_array("s_gm_vcost",$cpower)){
							echo $goods_cost;
							}else{
							echo '无权限';
							}


							
							?>
                            
                            &nbsp;</td>
						    <td scope='row' align='left' valign="top" >
                            
                            <?php
								
								$dataarray				= GetPurchasePrice($goods_sn);	
								
								
								
								 echo $dataarray[0];
							?>
                            &nbsp;</td>
						    <td scope='row' align='left' valign="top" >
                            
							<a href="purchasehistoryprice.php?goods_sn=<?php echo $goods_sn;?>" target="_blank">
							<?php								
								echo $dataarray[2];
							?>
                            </a>
                            
                            
                            &nbsp;</td>
						    <td scope='row' align='left' valign="top" >
                            
                            
                            <?php
								$sqr	 = "select id,store_name from ebay_store where ebay_user='$user'";
								$sqr	 = $dbcon->execute($sqr);
								$sqr	 = $dbcon->getResultArray($sqr);
								for($e=0;$e<count($sqr);$e++){					
								 
									$store_name	= $sqr[$e]['store_name'];
									$storeid	= $sqr[$e]['id'];
									$seq				= "select goods_count from ebay_onhandle where goods_sn='$goods_sn' and store_id='$storeid' and goods_id='$goods_id'";
							
									
									$seq				= $dbcon->execute($seq);
									$seq				= $dbcon->getResultArray($seq);
									echo "<a href='javascript:void(0)' onclick=\"viewio('".$goods_sn."',$storeid)\">";
									echo $store_name." : ".$seq[0]['goods_count'].'</a><br>';
								}
							?>
                            
                            
                            
                            
                  &nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo number_format($goods_weight,3);?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $goods_status;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><a href="#" onclick="viewsales('<?php echo $goods_sn;?>')" >查看销量</a>&nbsp;
	                          <?php if(in_array("s_gm_modify",$cpower)){?>
	                          <a href="productadd.php?pid=<?php echo $goods_id;?>&&module=warehouse&action=货品资料添加" target="_blank">修改</a>
	                          <?php }?>
                            &nbsp; </td>
	  </tr>
              


 
               <?php } ?>
		<tr class='pagination'>
		<td colspan='15'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'><div align="center">
					一共有 <?php echo $total; ?> 个SKU
					
					<?    echo '<br><center>'.$page->show(2)."</center>";//输出分页 ?> 
                </div></td>
					</tr>
			</table>		</td>
	</tr></table>


    <div class="clear"></div>
<?php

include "bottom.php";


?>
<script language="javascript">


function check_all(obj,cName)
{
    var checkboxs = document.getElementsByName(cName);
    for(var i=0;i<checkboxs.length;i++){
		if(checkboxs[i].checked == false){
			
			checkboxs[i].checked = true;
		}else{
			
			checkboxs[i].checked = false;
		}	
		
	}
}


function mod(){

	var bill	= "";
	var checkboxs = document.getElementsByName("ordersn");
    for(var i=0;i<checkboxs.length;i++){
		if(checkboxs[i].checked == true){			
			bill = bill + ","+checkboxs[i].value;		
		}		
	}
	if(bill == ""){
		
		alert("请选择订单号");
		return false;	
	}
	
	var  url		= "productmod.php?bill="+bill;
	window.open(url,"_blank");
	
	
	

}


function mod2(){

	var warehouse 	= document.getElementById('warehouse').value;
	
	if(warehouse == 0 || warehouse == 1){
	
		
		alert("请选择选择要导出的仓库");
		return false;
		
	
	}
	
	var url		= "producttowarehouse.php?storeid="+warehouse;
	location.href=url;
	


}

	function copyproducts(){
	
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){			
				bill = checkboxs[i].value;		
			}		
		}
		if(bill == ""){
			
			alert("请选择一个产品");
			return false;	
		}
		
		var url	= "productadd.php?apid="+bill+"&&module=warehouse&action=货品资料添加";
		location.href	= url;
		
		
	
	}


function deleteallsystem(){

	var bill	= "";
	var checkboxs = document.getElementsByName("ordersn");
    for(var i=0;i<checkboxs.length;i++){
		if(checkboxs[i].checked == true){			
			bill = bill + ","+checkboxs[i].value;		
		}		
	}
	if(bill == ""){
		
		alert("请选择订单号");
		return false;	
	}
	
	
		var content		 		= document.getElementById('keys').value;
		var goodscategory 		= document.getElementById('goodscategory').value;	
		var warehouse 			= document.getElementById('warehouse').value;	
		var isuse 				= document.getElementById('isuse').value;
		var searchs 			= document.getElementById('searchs').value;	
		
	
	if(confirm('确认删除此条记录')){
	
		location.href='productindex.php?module=warehouse&action=货品资料管理&type=delsystem&ordersn='+bill+'&keys='+encodeURIComponent(content)+"&goodscategory="+goodscategory+"&module=warehouse&action=货品资料管理&warehouse="+warehouse+"&isuse="+isuse+"&searchs="+searchs;
		
		
	}

}


		function searchorder(){
	
		

		var content		 		= document.getElementById('keys').value;
		var goodscategory 		= document.getElementById('goodscategory').value;	
		var warehouse 			= document.getElementById('warehouse').value;	
		var isuse 				= document.getElementById('isuse').value;
		var searchs 			= document.getElementById('searchs').value;	
		var factory 			= document.getElementById('factory').value;	
		location.href= 'productindex.php?keys='+encodeURIComponent(content)+"&goodscategory="+goodscategory+"&module=warehouse&action=货品资料管理&warehouse="+warehouse+"&isuse="+isuse+"&searchs="+searchs+"&factory="+factory;
		
		
	}
	
		function searchordersort(){
	
		
		var sortwarehouse		 		= document.getElementById('sortwarehouse').value;
		var goodssort			 		= document.getElementById('goodssort').value;
		var content		 		= document.getElementById('keys').value;
		var goodscategory 		= document.getElementById('goodscategory').value;	
		var warehouse 			= document.getElementById('warehouse').value;	
		var isuse 				= document.getElementById('isuse').value;
		var searchs 			= document.getElementById('searchs').value;	
		location.href= 'productindex.php?keys='+encodeURIComponent(content)+"&goodscategory="+goodscategory+"&module=warehouse&action=货品资料管理&warehouse="+warehouse+"&isuse="+isuse+"&searchs="+searchs+"&goodssort="+goodssort+"&sortwarehouse="+sortwarehouse;
		
		
	}
	function instock(pid){
	
		
		var url	= "productinstock.php?pid="+pid+"&module=warehouse&action=货品入库&type=in";
		window.open(url,"_blank");
		
	
	
	}
	
	
	function outstock(pid){
	
		
		var url	= "productinstock.php?pid="+pid+"&module=warehouse&action=货品入库&type=out";
		window.open(url,"_blank");
		
	
	
	}
	function exporttoxls(){
		
		var goodscategory 		= document.getElementById('goodscategory').value;	
		var url	= "productsexportxls.php?module=warehouse&goodscategory="+goodscategory;
		window.open(url,"_blank");
	
	
	}
	function rulecountry(){
	
		
		var url	= "rulcountry.php?module=warehouse&action=国家规则设置";
		
		location.href	= url;
		
	}
	
	function viewsales(sn){
		var url	= "productview.php?goods_sn="+encodeURIComponent(sn)+"&module=warehouse&action=货品资料添";
		window.open(url,"_blank");
	}
	
	function viewio(sku,store){
		var url	= "viewio.php?sku="+sku+"&store="+store;
		window.open(url, 'newwindow', 'height=500, width=1000, top=100, left=300, toolbar=no, menubar=no, scrollbars=yes,resizable=no,location=no, status=no');
	}

document.onkeydown=function(event){
  e = event ? event :(window.event ? window.event : null);
  if(e.keyCode==13){
 searchorder();
  }
 }

</script>