<?php
include "include/config.php";
$io_ordersn = $_REQUEST['io_ordersn'];
$sku		= $_REQUEST['sku'];
$factory	= $_REQUEST['factory'];
$id	= $_REQUEST['id'];

if($id){
	$id			= substr($id,1);
	$sn			= explode(',',$id);
	foreach($sn as $k=>$v){
	$sql			= "select * from ebay_goods where goods_sn='$v' and ebay_user='$user'";
	$sql			= $dbcon->execute($sql);
	$sql			= $dbcon->getResultArray($sql);
	if(count($sql)  == 0){
		$status .= " -[<font color='#FF0000'>操作记录: 没有产品记录，请添加此产品</font>]";
	}else{
		$goods_name		= $sql[0]['goods_name'];
		$goods_sn		= $sql[0]['goods_sn'];
		$goods_cost	= $sql[0]['goods_cost'];
		$goods_unit		= $sql[0]['goods_unit'];
		$goods_id		= $sql[0]['goods_id'];
		$goods_count    = 1;
		$sql		= "insert into ebay_iostoredetail(io_ordersn,goods_name,goods_sn,goods_cost,goods_unit,goods_count,goods_id) values('$io_ordersn','$goods_name','$goods_sn','$goods_cost','$goods_unit','$goods_count','$goods_id')";
	
		if($dbcon->execute($sql)){
			$status	.= " -[<font color='#33CC33'>操作记录: $v 产品添加成功</font>].<br>";
		}else{
			$status .= " -[<font color='#FF0000'>操作记录: $v 产品添加失败</font>].<br>";
		}

	}
		echo $status;
	}
}
?>
sku<input type='text' name='sku' id='sku' value='<?php echo $sku;?>'/>
供应商<select name="factory" id="factory" >
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
<input type='button' value='查询' onclick="search()"/>
<input type='button' value='添加到采购订单' onclick="addcaigou()"/><br>

<table cellpadding='0' cellspacing='0' width='100%' border='1' class='list view'>
	<tr height='20'>
		<th scope='col' nowrap="nowrap">
			<div style='white-space: nowrap;'width='100%' align='left'>操作</div>
		</th>
		<th scope='col' nowrap="nowrap">
			<div style='white-space: nowrap;'width='100%' align='left'>产品编号</div>
		</th>
		<th scope='col' nowrap="nowrap">
			<div style='white-space: nowrap;'width='100%' align='left'>产品名称</div>			
		</th>
		<th scope='col' nowrap="nowrap"><span class="left_bt2">产品成本</span></th>
		<th scope='col' nowrap="nowrap"><span class="left_bt2">库存数量</span></th>
	</tr>
<?php
$sql	= "select a.goods_name,a.goods_sn,a.goods_cost,goods_id  from ebay_goods as a  where a.ebay_user='$user'";
if($sku) $sql .= " and a.goods_sn='$sku' ";
if($factory) $sql .= " a.and factory='$factory'";
$sql .= " group by a.goods_id";

$query		= $dbcon->query($sql);
$total		= $dbcon->num_rows($query);

$pageindex  =( isset($_GET['pageindex']) )?$_GET['pageindex']:1;
$limit = " limit ".($pageindex-1)*$pagesize.",$pagesize";

$page=new page(array('total'=>$total,'perpage'=>$pagesize));
$sql = $sql.$limit;
$sql	= $dbcon->execute($sql);
$sql	= $dbcon->getResultArray($sql);
foreach($sql as $k=>$v){
	$goods_sn = $v['goods_sn'];
	$goods_name	= $v['goods_name'];
	$goods_cost	= $v['goods_cost'];
	$goods_id= $v['goods_id'];
?>
<tr height='20' class='oddListRowS1'>
	<td scope='row' align='left' valign="top" ><input name="ordersn" type="checkbox" id="ordersn" value="<?php echo $goods_sn;?>" ></td>
	<td scope='row' align='left' valign="top" ><?php echo $goods_sn; ?></td>
	<td scope='row' align='left' valign="top" ><?php echo $goods_name; ?></td>
	<td scope='row' align='left' valign="top" ><?php echo $goods_cost; ?></td>
	<td scope='row' align='left' valign="top" ><?php
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
							?></td>
</tr>
<?php
	}
?>
</table>
<script>
	function search(){
		var factory	 		= document.getElementById('factory').value;
		var sku		 		= document.getElementById('sku').value;
		location.href= 'goodslist.php?sku='+sku+'&factory='+factory+'&io_ordersn=<?php echo $io_ordersn;?>';
	}
	function addcaigou(){
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
		location.href= 'goodslist.php?id='+bill+'&io_ordersn=<?php echo $io_ordersn;?>';
	}
</script>