<?php
include "include/config.php";


include "top.php";

$cpower	= explode(",",$_SESSION['power']);

$warehouse			= $_REQUEST['warehouse'];
$keys				= $_REQUEST['keys'];
$searchs			= $_REQUEST['searchs'];
$type				= $_REQUEST['type'];
$isuse				= $_REQUEST['isuse'];

if($type 	== "delsystem"){
	
	$ordersn = explode(",",$_REQUEST['ordersn']);

	
	$status  = "";
	for($g=0;$g<count($ordersn);$g++){
		
		
		$sn 	=  $ordersn[$g];

		if($sn != ""){
		
			
			$ss			= "select * from ebay_onhandle where goods_id='$sn'";
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
            <option value="">Please select</option>
              <option value="0" <?php if($isuse == '0') echo 'selected="selected"'; ?>>在线</option>
               <option value="2" <?php if($isuse == '2') echo 'selected="selected"'; ?>>零库存</option>
               
              <option value="1" <?php if($isuse == '1') echo 'selected="selected"'; ?>>下线</option>
            </select>
            仓库：
<select name="warehouse" id="warehouse">
                            <option value="0">Please select</option>
                            <?php 
							
							$sql = "select * from  ebay_store where ebay_user='$user'";									
							$sql = $dbcon->execute($sql);
							$sql = $dbcon->getResultArray($sql);
				
							for($i=0;$i<count($sql);$i++){
						
								$id					= $sql[$i]['id'];
								$store_name			= $sql[$i]['store_name'];	
						
							
							?>
                            <option value="<?php echo $id;?>"><?php echo $store_name; ?></option>
                            <?php
							}
							
							
							?>
                            
                            
                          </select>
                          
    
    
    <input type="button" value="查找" onclick="searchorder()" />
	<br />
	操作：
	<input class='button' type="button" name='search_form_submit' value='删除' id='search_form_submit2' onclick="deleteallsystem()" />
	
    <input class='button' type="button" name='button' value='添加货品' id='search_form_submit' onclick="javascript:location.href='productadd.php?module=warehouse&action=货品资料添加'" />
    基础资料导入\出：
    <input class='button' type="button" name='button' value='货品资料导入' id='search_form_submit' onclick="javascript:location.href='productaddxls.php?module=warehouse&action=货品资料导入'" />
       <input class='button' type="button" name='search_form_submit2' value='货品资料导出' id='search_form_submit3' onclick="javascript:location.href='productsexportxls.php?module=warehouse&amp;action=货品资料添加'" />
       
       库存数量导入\出：
       <input class='button' type="button" name='search_form_submit2' value='批量更新库存' id='search_form_submit3' onclick="javascript:location.href='stockupdate.php?module=warehouse&amp;action=货品资料添加'" />
       
       <input class='button' type="button" name='search_form_submit4' value='货品库存导出' id='search_form_submit5' onclick="mod2()" />
       <input class='button' type="button" name='button' value='全选' id='search_form_submit' onclick="check_all('ordersn','ordersn')" /></td>
</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='14'>
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
				<div style='white-space: nowrap;'width='100%' align='left'>产品编号</div></th>
			
					<th scope='col' nowrap="nowrap">产品图片</th>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>产品名称</div>			</th>
			
					<th scope='col' nowrap="nowrap"><span class="left_bt2">产品售价</span></th>
		            <th scope='col' nowrap="nowrap"><span class="left_bt2">产品成本</span></th>
		<th scope='col' nowrap="nowrap">单位&nbsp;</th>
					<th scope='col' nowrap="nowrap">产品货位&nbsp;</th>
		            <th scope='col' nowrap="nowrap">实际库存</th>
                    <th scope='col' nowrap="nowrap">重量</th>
                    <th scope='col' nowrap="nowrap">备注</th>
                    <th scope='col' nowrap="nowrap">产品状态</th>
                    <th scope='col' nowrap="nowrap"> 型号 </th>
        <th scope='col' nowrap="nowrap">操作</th>
	</tr>
		


			  <?php
			  	
				
			
				$sql		= "select * from ebay_goods as a where ebay_user='$user'";
				
				$goods_sx		= $_REQUEST['sx'];
				$goods_xx		= $_REQUEST['xx'];
				
				$warehouse		= $_REQUEST['warehouse'];
				if($warehouse != '' && $warehouse != '0'){
					$sql	= "select * from ebay_goods as a join  ebay_onhandle as b ON a.goods_id = b.goods_id where b.store_id='$warehouse' and a.ebay_user='$user'";
				}
				
				$keys		= $_REQUEST['keys'];
				
				
				if($searchs == '0') $sql	.= " and(a.goods_name like '%$keys%' or a.goods_sn like '%$keys%' or a.goods_unit like '%$keys%')";
				if($searchs == '1') $sql	.= " and a.goods_sn = '$keys' ";
				if($searchs == '2') $sql	.= " and a.goods_name = '$keys' ";
				if($searchs == '3') $sql	.= " and a.goods_unit = '$keys' ";
				if($searchs == '4') $sql	.= " and a.goods_location = '$keys' ";
				if($searchs == '5') $sql	.= " and a.goods_weight = '$keys' ";
				
		
				$goodscategory	= $_REQUEST['goodscategory'];
				if($goodscategory!="" && $goodscategory !="-1") $sql	.= " and a.goods_category='$goodscategory'";
				
				$isuse	= $_REQUEST['isuse'];
				if($isuse!="" && $isuse !="-1") $sql	.= " and a.isuse='$isuse'";
			
				$sql	.= " order by a.goods_sn desc ";
				

				
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
					$goods_unit		= $sql[$i]['goods_unit'];
					$goods_location	= $sql[$i]['goods_location'];
					
					$goods_weight	= $sql[$i]['goods_weight']?$sql[$i]['goods_weight']:"";
					$goods_note		= $sql[$i]['goods_note']?$sql[$i]['goods_note']:"";
					$goods_pic		= $sql[$i]['goods_pic']?$sql[$i]['goods_pic']:"";
					$isuse			= $sql[$i]['isuse']?'下线':'上线';
					
					
					$ebay_packingmaterial	= $sql[$i]['ebay_packingmaterial'];
					
			  ?>
              
              
                  
         		<tr height='20' class='oddListRowS1'>
						<td scope='row' align='left' valign="top" ><input name="ordersn" type="checkbox" id="ordersn" value="<?php echo $goods_id;?>" ><?php echo $goods_id;?></td>
				
						    <td scope='row' align='left' valign="top" >
							<?php echo $goods_sn; ?>                            </td>
				
						    <td scope='row' align='left' valign="top" >
                            <?php if($goods_pic != ''){ ?>
                            <img src="images/<?php echo $goods_pic; ?>" width="50" height="50" />
                            <?php } ?>
                            </td>
						    <td scope='row' align='left' valign="top" ><?php echo $goods_name;?></td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $goods_price;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" >
							
							
							<?php 
							

								
							echo $goods_cost;


							
							?>
                            
                            &nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $goods_unit;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $goods_location; ?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" >
                            
                            
                            <?php
								$sqr	 = "select * from ebay_store where ebay_user='$user'";
							
								
								$sqr	 = $dbcon->execute($sqr);
								$sqr	 = $dbcon->getResultArray($sqr);
								for($e=0;$e<count($sqr);$e++){					
								 
									$store_name	= $sqr[$e]['store_name'];
									$storeid	= $sqr[$e]['id'];
									
									$seq				= "select * from ebay_onhandle where goods_sn='$goods_sn' and store_id='$storeid' and goods_id='$goods_id'";
									
								
									
									$seq				= $dbcon->execute($seq);
									$seq				= $dbcon->getResultArray($seq);
									echo $store_name." : ".$seq[0]['goods_count'];
									
									echo " 下限 : ".$seq[0]['goods_xx']."<br>"."<br>";
										
									
								}
							
							
							
							
							?>
                            
                            
                            
                            
                  &nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo number_format($goods_weight,3);?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $goods_note;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $isuse;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $ebay_packingmaterial;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><a href="productadd.php?pid=<?php echo $goods_id;?>&&module=warehouse&action=货品资料添加" target="_blank">修改</a>&nbsp;                </td>
	  </tr>
              


 
               <?php } ?>
		<tr class='pagination'>
		<td colspan='14'>
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
		

		
		location.href= 'productindex.php?keys='+encodeURIComponent(content)+"&goodscategory="+goodscategory+"&module=warehouse&action=货品资料管理&warehouse="+warehouse+"&isuse="+isuse+"&searchs="+searchs;
		
		
	}
	
	
	function instock(pid){
	
		
		var url	= "productinstock.php?pid="+pid+"&module=warehouse&action=货品入库&type=in";
		window.open(url,"_blank");
		
	
	
	}
	
	
	function outstock(pid){
	
		
		var url	= "productinstock.php?pid="+pid+"&module=warehouse&action=货品入库&type=out";
		window.open(url,"_blank");
		
	
	
	}
	
	function rulecountry(){
	
		
		var url	= "rulcountry.php?module=warehouse&action=国家规则设置";
		
		location.href	= url;
		
	}
	





</script>