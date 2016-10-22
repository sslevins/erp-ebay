<?php
include "include/config.php";



$type	= $_REQUEST['type'];

if($type 	== "delsystem"){
	
	$ordersn = explode(",",$_REQUEST['ordersn']);

	
	$status  = "";
	for($g=0;$g<count($ordersn);$g++){
		
		
		$sn 	=  $ordersn[$g];

		if($sn != ""){
			
			$sql		= "delete  from  ebay_goods where goods_id='$sn'";
		
			
			
		if($dbcon->execute($sql)){
	
	
					$status	= " -[<font color='#33CC33'>操作记录: 记录删除成功</font>]";

	}else{
	

					$status = " -[<font color='#FF0000'>操作记录: 记录删除失败</font>]";

	}

			
		}
	}
	
}



	
	
 ?>
 <link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/yui.css" />

<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/deprecated.css" />

<link rel="stylesheet" type="text/css" href="cache/themes/Sugar5/css/style.css" /> 
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr>
          <td><div class='listViewBody'>
            
  <div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
		
	<td nowrap="nowrap" scope="row" >&nbsp;&nbsp;&nbsp;
	
	关键字：
	<input name="keys" type="text" id="keys" /> 
	  
	  类别：
	  货品类别：<select name="goodscategory" id="goodscategory">
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
	  仓库：<select name="warehouse" id="warehouse">
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
	  
	  
	  
	  <input type="button" value="查找" onClick="searchorder()" /></td>
</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='7'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" width='2%' class='paginationActionButtons'>&nbsp;</td>
				  <td  nowrap='nowrap' width='1%' align="right" class='paginationChangeButtons'>				  </td>
				</tr>
			</table>		</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>产品编号</div></th>
			
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>产品名称</div>			</th>
			
					<th scope='col' nowrap="nowrap"><span class="left_bt2">产品重量</span></th>
		<th scope='col' nowrap="nowrap">单位&nbsp;</th>
					<th scope='col' nowrap="nowrap">产品货位&nbsp;</th>
		            <th scope='col' nowrap="nowrap">实际库存</th>
        <th scope='col' nowrap="nowrap">操作</th>
	</tr>
		


			  <?php
			  	
				
			
				$sql		= "select * from ebay_goods as a where ebay_user='$user'";
				
				
				$warehouse		= $_REQUEST['warehouse'];
				if($warehouse != '' && $warehouse != '0'){
				
					
					$sql	= "select * from ebay_goods as a join  ebay_onhandle as b ON a.goods_id = b.goods_id where b.store_id='$warehouse' and a.ebay_user='$user'";
					
				
				}
				
				$keys		= $_REQUEST['keys'];
				if($keys != ""){
				
					$sql	.= " and(a.goods_name like '%$keys%' or a.goods_sn like '%$keys%' or a.goods_unit like '%$keys%')";
					
				}
				$goodscategory	= $_REQUEST['goodscategory'];
				if($goodscategory!="" && $goodscategory !="-1") $sql	.= " and a.goods_category='$goodscategory'";
				
				
			
				

				
				
				
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
					
					
					
					
			  ?>
              
              
                  
         		<tr height='20' class='oddListRowS1'>
						<td scope='row' align='left' valign="top" >
						  <?php echo $goods_sn; ?>                            </td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $goods_name;?></td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $goods_weight;?>&nbsp;</td>
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
									echo $store_name." : ".$seq[0]['goods_count']."<br>";
								
										
									
								}
							
							
							
							
							?>
                            
                            
                            
                            
                  &nbsp;</td>
						    <td scope='row' align='left' valign="top" ><a href="#" onclick="edits('<?php echo '0';?>','<?php echo $goods_sn;?>','<?php echo $goods_name;?>','<?php echo $goods_price;?>')">Add</a>&nbsp;                </td>
	  </tr>
              


 
               <?php } ?>
		<tr class='pagination'>
		<td colspan='7'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'><div align="center"><?    echo '<br><center>'.$page->show(2)."</center>";//输出分页 ?> 
                </div></td>
					</tr>
			</table>		</td>
	</tr></table>


    <div class="clear"></div>
<?php

include "bottom.php";


?>
<script language="javascript">


function edits(itemid,tsku,tname,price)
{
qty	=	1;
window.opener.goods_sn.value 	= tsku;
window.opener.goods_count.value = qty;



		window.opener.location.href= 'productslistinout.php?keys';
		
		

}




		function searchorder(){
	
		

		var content		 	= document.getElementById('keys').value;
		var goodscategory 	= document.getElementById('goodscategory').value;	
		var warehouse 	= document.getElementById('warehouse').value;	
		
		
		
		location.href= 'productslistinout.php?keys='+content+"&goodscategory="+goodscategory+"&module=warehouse&action=货品资料管理&warehouse="+warehouse;
		
	}
	





</script>