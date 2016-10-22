<?php
include "include/config.php";


include "top.php";

$cpower	= explode(",",$_SESSION['power']);

$warehouse			= $_REQUEST['warehouse'];
$keys				= trim($_REQUEST['keys']);
$searchs			= $_REQUEST['searchs'];
$type				= $_REQUEST['type'];
$isuse				= $_REQUEST['isuse'];
$goodscategory		= $_REQUEST['goodscategory'];
$isuse				= $_REQUEST['isuse'];
$cguser				= 	$_REQUEST['cguser'];
function isplan($sku,$storeid){
		global $dbcon,$user;
		$plansql	= "select id from ebay_goods_newplan where sku ='$sku' and ebay_user='$user' and ebay_warehouse='$storeid'";
		$plansql	=$dbcon->execute($plansql);
		$plansql	=$dbcon->getResultArray($plansql);
		if(count($plansql)>0){
			return 0;
		}else{
			return 1;
		}
	}
	if($_POST['submit']){
		
		$totalrecorder		= $_POST['totalrecorder']; // 取得一共有多少行记录
		$totalrecorder		= explode(',',$totalrecorder);

		for($i=0;$i<count($totalrecorder);$i++){
			
			$selectid		= $totalrecorder[$i];
			if($selectid != '' ){
				
				$vv = "select goods_sn,goods_name,goods_unit,factory,kfuser,cguser from ebay_goods where goods_id='$selectid' and ebay_user='$user'";
				$vv			= $dbcon->execute($vv);
				$vv			= $dbcon->getResultArray($vv);
				$goods_name = $vv[0]['goods_name'];
				$unit 		= $vv[0]['goods_unit'];
				$factory	= $vv[0]['factory'];
				$kfuser		= $vv[0]['kfuser'];
				$cguser		= $vv[0]['cguser'];
				$goods_sn  = $vv[0]['goods_sn'];
				$storeid					= $_POST[$selectid.'storeid'];
				$purchaseqty				= $_POST[$selectid.'needcount'];
				$purchaseprice				= $_POST[$selectid.'price'];
				if(isplan($goods_sn,$storeid)){
				$addsql		= "insert into ebay_goods_newplan(sku,goods_name,unit,ebay_warehouse,goods_count,ebay_user,type,partner,purchaseprice,kfuser,cguser) values('$goods_sn','$goods_name','$unit','$storeid','$purchaseqty','$user','1','$factory','$purchaseprice','$kfuser','$cguser')";
				
				if($dbcon->execute($addsql)){
					echo "SKU: ".$goods_sn.' 保存成功<br>';
				}else{
					echo "SKU: ".$goods_sn.' 保存失败<br>';
				}
				}else{
					echo "SKU: ".$goods_sn.' 保存失败,计划已经存在<br>';
				}
			}
		}
	}
if(isset($_GET['id'])){
		$id = $_GET['id'];
		$storeid					= $_GET['store_id'];
		$purchaseqty				= $_GET['purchaseqty'];
		$purchaseprice				= $_GET['purchaseprice'];
		$vv = "select goods_name,goods_unit,goods_sn,factory,kfuser,goods_note from ebay_goods where goods_id='$id' and ebay_user='$user'";
		$vv			= $dbcon->execute($vv);
		$vv			= $dbcon->getResultArray($vv);
		$goods_name = $vv[0]['goods_name'];
		$unit 		= $vv[0]['goods_unit'];
		$goods_sn 	= $vv[0]['goods_sn'];
		$factory 	= $vv[0]['factory'];
		$kfuser		= $vv[0]['kfuser'];
		$notes		= $vv[0]['goods_note'];
		if(isplan($goods_sn,$storeid)){
			$addsql		= "insert into ebay_goods_newplan(sku,goods_name,unit,ebay_warehouse,goods_count,ebay_user,type,partner,purchaseprice,kfuser,notes) values('$goods_sn','$goods_name','$unit','$storeid','$purchaseqty','$user','1','$factory','$purchaseprice','$kfuser','$notes')";
			if($dbcon->execute($addsql)){
				echo '<script>alert("'.$goods_sn.'保存成功");</script>';
			}else{
				echo '<script>alert("'.$goods_sn.'保存失败");</script>';
			}
		}else{
			echo '<script>alert("'.$goods_sn.'保存失败,已经有该产品采购计划");</script>';
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
                            <option value="<?php echo $id;?>"><?php echo $store_name; ?></option>
                            <?php
							}
							?>
                            
                            
            </select>
             采购人员
				<select name="cguser" id="cguser">
					<option value="" >Please Select</option>
					<?php
					$ss		= "select username from ebay_user   where user ='$user' ";
					$ss		= $dbcon->execute($ss);
					$ss		= $dbcon->getResultArray($ss);
					for($i=0;$i<count($ss); $i++){
									$usernames	= $ss[$i]['username'];
					?>
					<option value="<?php echo $usernames;?>" <?php if($cguser == $usernames) echo 'selected="selected"'; ?>><?php echo $usernames;?></option>
					<?php
					}
					 ?>
				</select>
				<select name="isuse" id="isuse">
                  <option value="">请选择产品状态</option>
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
    
    
    <input type="button" value="查找" onclick="searchorder()" />
	<br /></td>
</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
  <form name="myform" method="post" action="productstockalarm.php?module=purchase" >
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='10'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" width='2%' class='paginationActionButtons'>&nbsp;</td>
				  <td  nowrap='nowrap' width='1%' align="right" class='paginationChangeButtons'>				  </td>
				</tr>
			</table>		</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'><input name="ordersn" type="checkbox" id="ordersn" value="<?php echo $ordersn;?>" onclick="check_all('ordersn','ordersn')" />操作</div></th>
			
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>产品编号</div></th>
			
					<th scope='col' nowrap="nowrap">图片</th>
  <th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>产品名称</div>			</th>
		<th scope='col' nowrap="nowrap">仓库</th>
					<th scope='col' nowrap="nowrap">可用库存</th>
					<th scope='col' nowrap="nowrap">实际库存</th>
					<th scope='col' nowrap="nowrap">订购数量</th>
					<th scope='col' nowrap="nowrap">30天平均销量</th>
					<th scope='col' nowrap="nowrap">预警数量</th>
					<th scope='col' nowrap="nowrap">需采购数量</th>
					<th scope='col' nowrap="nowrap">预设采购价</th>
					<th scope='col' nowrap="nowrap">平均采购价</th>
					<th scope='col' nowrap="nowrap">最新采购价</th>
                    <th scope='col' nowrap="nowrap">重量</th>
                    <th scope='col' nowrap="nowrap">状态</th>
        <th scope='col' nowrap="nowrap">操作</th>
	</tr>
		


			  <?php
			  	
				
			
				$sql		= "select a.*,b.goods_count,b.store_id,b.goods_days,b.purchasedays from ebay_goods as a join  ebay_onhandle as b ON a.goods_id = b.goods_id where a.ebay_user='$user'";
				if($warehouse != '' && $warehouse != '0'){
					$sql	= "select a.*,b.goods_count,b.store_id,b.goods_days,b.purchasedays from ebay_goods as a join  ebay_onhandle as b ON a.goods_id = b.goods_id where b.store_id='$warehouse' and a.ebay_user='$user'";
				}


				
				if($searchs == '0' && $keys != '') $sql	.= " and(a.goods_name like '%$keys%' or a.goods_sn like '%$keys%' or a.goods_unit like '%$keys%')";
				if($searchs == '1' && $keys != '') $sql	.= " and a.goods_sn = '$keys' ";
				if($searchs == '2' && $keys != '') $sql	.= " and a.goods_name = '$keys' ";
				if($searchs == '3' && $keys != '') $sql	.= " and a.goods_unit = '$keys' ";
				if($searchs == '4' && $keys != '') $sql	.= " and a.goods_location = '$keys' ";
				if($searchs == '5' && $keys != '') $sql	.= " and a.goods_weight = '$keys' ";
				if($cguser  != '')		   			$sql .= " and a.cguser = '$cguser' ";
				if($isuse  != '')		   			$sql .= " and a.isuse = '$isuse' ";
				
				
				if($goodscategory!="" && $goodscategory !="-1") $sql	.= " and a.goods_category='$goodscategory'";
				$sql	.= " order by a.goods_sn desc  ";
				$query		= $dbcon->query($sql);
				$total		= $dbcon->num_rows($query);
				
				$pageindex  =( isset($_GET['pageindex']) )?$_GET['pageindex']:1;
				$page=new page(array('total'=>$total,'perpage'=>$pagesize));
				$sql = $sql.$limit;
								
				$sql		= $dbcon->execute($sql);
				$sql		= $dbcon->getResultArray($sql);
				for($i=0;$i<count($sql);$i++){
					
					$goods_id		= $sql[$i]['goods_id'];
					$goods_sn		= $sql[$i]['goods_sn'];
					$goods_name		= $sql[$i]['goods_name'];
					$goods_price	= $sql[$i]['goods_price']?$sql[$i]['goods_price']:0;
					$goods_cost		= $sql[$i]['goods_cost']?$sql[$i]['goods_cost']:0;
					$goods_count	= $sql[$i]['goods_count']?$sql[$i]['goods_count']:0;
					$goods_weight	= $sql[$i]['goods_weight']?$sql[$i]['goods_weight']:"";
					$goods_note		= $sql[$i]['goods_note']?$sql[$i]['goods_note']:"";
					$goods_pic		= $sql[$i]['goods_pic']?$sql[$i]['goods_pic']:"";
					$isuse			= $sql[$i]['isuse'];
					$storeid		= $sql[$i]['store_id'];
					$stockused2	= stockused($goods_sn,$storeid);
		
					$sqr	 = "select store_name from ebay_store where id='$storeid'";
					
								
					$sqr	 = $dbcon->execute($sqr);
					$sqr	 = $dbcon->getResultArray($sqr);
					$storename = $sqr[0]['store_name'];				
					
					$goods_count_qty		= $sql[$i]['goods_count']?$sql[$i]['goods_count']:0;  // 得出产品的实际库存
					$goods_days				= $sql[$i]['goods_days'];
					$purchasedays			= $sql[$i]['purchasedays']?$sql[$i]['purchasedays']:1;	// 需要采购的天数数量
									/* 检查这个产品最早售出的时间 */
									
					
					
					
						/* 检查此sku 是否是组合产品, 包含当前子SKU 销售产品的信息的 */
						$vv				= "select goods_sn,goods_sncombine from ebay_productscombine where goods_sncombine	 like '%$goods_sn%' and ebay_user ='$user' ";
						$vv				= $dbcon->execute($vv);
						$vv				= $dbcon->getResultArray($vv);
						
						$combinestr		= '';
						
						if(count($vv) > 0){
						for($iu=0;$iu<count($vv);$iu++){
							$cgoods_sn			= $vv[$iu]['goods_sn']; // => sold 中售出的物品编号，也就是组合产品编号
							$goods_sncombine	= $vv[$iu]['goods_sncombine'];   // => 子sku号 和期对应的数量。
							$fxgoods_sncombine	= explode(',',$goods_sncombine);
							for($j=0; $j<count($fxgoods_sncombine);$j++){
										$fxlaberstr01	= explode('*',$fxgoods_sncombine[$j]);
										$bgoods_sn		= $fxlaberstr01[0];	
										if($bgoods_sn == $goods_sn ){
										$combinestr		.= " b.sku = '".$cgoods_sn."' or ";
										}
							}			
						}		
					}
					
					
					$gg					= "select a.ebay_paidtime from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn = b.ebay_ordersn where b.sku='$goods_sn' and a.ebay_warehouse='$storeid' order by a.ebay_id asc ";
					
					if($combinestr != '' ){
							$combinestr		= substr($combinestr,0,strlen($combinestr) - 3 );
							$gg					= "select a.ebay_paidtime from ebay_order as a join ebay_orderdetail as b on a.ebay_ordersn = b.ebay_ordersn where (b.sku='$goods_sn' or $combinestr) and a.ebay_warehouse='$storeid' order by a.ebay_id asc ";
					}

					$gg .= ' limit 1 ';


					$gg					= $dbcon->execute($gg);
					$gg					= $dbcon->getResultArray($gg);
					
					$outofsock = 0;


					
									
					if(count($gg) > 0){
					
						/* 如果days 是小于或等于30的话，统一按/每天的销量 */
						$ebay_paidtime		= $gg[0]['ebay_paidtime'];
						$time3 				= $mctime - $ebay_paidtime;
						$day 				= floor($time3/(3600*24));
						

						
						if($day < 30 ){    // 如果小于30 的，按取得小于30 天内的总销量，在除以指定的天数
							if($day == 0) $day = 1;
						
						
							$start1						= date('Y-m-d').'23:59:59';	
							$start0						= date('Y-m-d',strtotime("$start1 -$day days")).' 00:00:00';
							$totalqty					= getProductsqty($start0,$start1,$goods_sn,$storeid)/$day;
							$plancount					= getPurchaseNumber('Plan',$goods_sn,$storeid);
							$Schedulecount				= getPurchaseNumber('Schedule',$goods_sn,$storeid);
							$ForAcceptancecount			= getPurchaseNumber('ForAcceptance',$goods_sn,$storeid);		
							$stockused				= $plancount+$Schedulecount+$ForAcceptancecount;						//  取得已经预订的产品数量
							$needqty					= ceil($totalqty * $goods_days);  // 计算产品库存报警数量
							$goods_count				= $goods_count_qty + $stockused;
							/*  如何实际库存,小于或等于预jin库存时,是生成采购订单 */
							if(($goods_count + $stockused) < $needqty){
								$outofsock						 =  ceil($purchasedays * $totalqty);
							}
						}else{
						
						
						
							 $start1						= date('Y-m-d').'23:59:59';	
							 $start0						= date('Y-m-d H:i:s',strtotime("$start1 -7 days"));
							 $qty0							= (getProductsqty($start0,$start1,$goods_sn,$storeid)/7)*$days7;
							 
							 
							 $start1						= date('Y-m-d').'23:59:59';	
							 $start0						= date('Y-m-d H:i:s',strtotime("$start1 -15 days"));
							 $qty1							= (getProductsqty($start0,$start1,$goods_sn,$storeid)/15)*$days15;
							 
							 $start1						= date('Y-m-d').'23:59:59';	
							 $start0						= date('Y-m-d H:i:s',strtotime("$start1 -30 days"));
							 $qty2							= (getProductsqty($start0,$start1,$goods_sn,$storeid)/30)*$days30;
							 $totalqty						= $qty0 + $qty1 + $qty2;  // 平均每天的销量
							 $plancount						= getPurchaseNumber('Plan',$goods_sn,$storeid);
							 $Schedulecount					= getPurchaseNumber('Schedule',$goods_sn,$storeid);
							 $ForAcceptancecount			= getPurchaseNumber('ForAcceptance',$goods_sn,$storeid);		
							 $stockused						= $plancount+$Schedulecount+$ForAcceptancecount;	
							 
							 $needqty						= ceil($totalqty * $goods_days);  // 计算产品库存报警数量
							 $goods_count					= $goods_count_qty + $stockused;
							 
							 
							/*  如何实际库存,小于或等于预jin库存时,是生成采购订单 */
							 if(($goods_count + $stockused) < $needqty){
								$outofsock						=  ceil($purchasedays * $totalqty);
							}
						}
						$purchasearray			= GetPurchasePrice($goods_sn);
						
					}						  
					if($outofsock >0){
					
					
			  ?>
              
              
                  
         		<tr height='20' class='oddListRowS1'>
					<td scope='row' align='left' valign="top" ><input name="ordersn" type="checkbox" id="ordersn" value="<?php echo $goods_id;?>" ></td>
					<td scope='row' align='left' valign="top" >
					<?php echo $goods_sn; ?>                            </td>
					<td scope='row' align='left' valign="top" >
					<?php if($goods_pic != ''){ ?>
					<img src="images/<?php echo $goods_pic; ?>" width="50" height="50" />
					<?php } ?>                            </td>
					<td scope='row' align='left' valign="top" ><?php echo $goods_name;?></td>
					<td scope='row' align='left' valign="top" ><?php echo $storename;?>&nbsp;</td>
					<td scope='row' align='left' valign="top" ><?php echo $goods_count_qty-$stockused2;?>&nbsp;</td>
					<td scope='row' align='left' valign="top" ><?php echo $goods_count_qty;?>&nbsp;</td>
					<td scope='row' align='left' valign="top" ><?php echo $stockused;?>&nbsp;</td>
					<td scope='row' align='left' valign="top" ><?php echo number_format($totalqty,2);?>&nbsp;</td>
					<td scope='row' align='left' valign="top" ><?php echo $needqty;?>&nbsp;</td>
					<td scope='row' align='left' valign="top" ><input type='text' id='<?php echo $goods_id?>needcount' name='<?php echo $goods_id?>needcount' value='<?php echo $outofsock-$goods_count_qty;?>' style='width:30px' /></td>
					<td scope='row' align='left' valign="top" ><input type='text' id='<?php echo $goods_id?>price' name='<?php echo $goods_id?>price' value='<?php echo $goods_cost;?>' style='width:40px' /><input type='hidden' id='<?php echo $goods_id?>storeid' name='<?php echo $goods_id?>storeid' value='<?php echo $storeid;?>'/></td>
					<td scope='row' align='left' valign="top" ><?php echo $purchasearray[2]?$purchasearray[2]:0;?>&nbsp;</td>
					<td scope='row' align='left' valign="top" ><?php echo $purchasearray[0]?$purchasearray[0]:0;?>&nbsp;</td>
					<td scope='row' align='left' valign="top" ><?php echo number_format($goods_weight,3);?>&nbsp;</td>
					<td scope='row' align='left' valign="top" ><?php echo $isuse;?>&nbsp;</td>
					<td scope='row' align='left' valign="top" style='width:100px;' ><a href="#" onclick="addplan('<?php echo $goods_id?>','<?php echo $storeid;?>')">添加采购计划</a></td>
	  </tr>
              


 
               <?php }} ?>
		<tr class='pagination'>
		<td colspan='17'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'><div align="center"> <input name="totalrecorder" type="hidden" id="totalrecorder" value="<?php echo $i;?>" />
                    <input name="submit" type="submit" onclick="return saveorders()" value="添加选中sku" /></div></td>
					</tr>
			</table>		</td>
	</tr></table>
</form>

    <div class="clear"></div>
<?php

include "bottom.php";


?>
<script language="javascript">
function saveorders(){
		
		var bill	= "";
		var checkboxs = document.getElementsByName("ordersn");
		for(var i=0;i<checkboxs.length;i++){
			if(checkboxs[i].checked == true){
				bill = bill + ","+checkboxs[i].value;
			}	
		}
		if(bill == ""){
			alert("请选择物品");
			return false;
		}
		document.getElementById('totalrecorder').value = bill;
	}

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
function addplan(goodsid,storeid)
{
	var needcount	= document.getElementById(goodsid+'needcount').value;
	var price		= document.getElementById(goodsid+'price').value;
	var url	= 'productstockalarm.php?module=purchase&id='+goodsid+'&purchaseqty='+needcount+'&purchaseprice='+price+'&store_id='+storeid;
	location.href = url;
}





		function searchorder(){
	
		

		var content		 		= document.getElementById('keys').value;
		var goodscategory 		= document.getElementById('goodscategory').value;	
		var warehouse 			= document.getElementById('warehouse').value;	
		var isuse 				=  document.getElementById('isuse').value;	
		var searchs 			= document.getElementById('searchs').value;	
		var cguser 			= document.getElementById('cguser').value;	

		
		location.href= 'productstockalarm.php?keys='+encodeURIComponent(content)+"&goodscategory="+goodscategory+"&module=purchase&action=货品资料管理&warehouse="+warehouse+"&isuse="+encodeURIComponent(isuse)+"&searchs="+searchs+"&cguser="+cguser;
		
		
	}
	
	






</script>