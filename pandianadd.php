<?php
include "include/config.php";


include "top.php";


	$type	= $_REQUEST['type'];
	 $cpower	= explode(",",$_SESSION['power']);
	if($type == "del"){
		$id	 = $_REQUEST['id'];
		$sql = "delete from  ebay_pandiandetail where id=$id ";
	if($dbcon->execute($sql)){
			$status	= " -[<font color='#33CC33'>操作记录: 记录删除成功</font>]";
		}else{
			$status = " -[<font color='#FF0000'>操作记录: 记录删除失败</font>]";
		}
	}else{
		$status = "";
	}
	if($_POST['submit']){
		$store_id = $_POST['store_id'];
		$time = time();
		$truename = $_SESSION['truename'];
		for($i=1;$i>0;$i++){
			if($i<10){
				$is = '00'.$i;
			}else{
				$is = '0'.$i;
			}
			$sn = 'PD'.date('ymd').$is;
			$vv = "select id from ebay_pandian where pandian_sn='$sn'"; 
			$vv = $dbcon->execute($vv);
			$vv = $dbcon->getResultArray($vv);
				if(count($vv)<1){
					$insql = "insert into ebay_pandian (pandian_sn,add_user,add_time,store_id,ebay_user,status) values ('$sn','$truename','$time','$store_id','$user','0');";
					$dbcon->execute($insql);
					break;
				}
			}
		$sql = "select id from  ebay_pandiandetail  where status='0' and user='$user'";
		$sql = $dbcon->execute($sql);
		$sql = $dbcon->getResultArray($sql);
		foreach($sql as $k=>$v){
			$pusecount = $_POST['pusecount'.$v['id']];
			$usql = "update ebay_pandiandetail set pandian_count='$pusecount',status='1',pandian_sn='$sn' where id=".$v['id'];
			$dbcon->execute($usql);
		}
	}

 ?>
    <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>

<div id="main">
    <div id="content" >

<div class='listViewBody'>
<?php echo $status;?>

<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
<input type="button" value="添加商品" onclick="addgoods()" />
<input type="button" value="批量导入商品" onclick="addgoodsxls()" />
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
<form action="?module=warehouse" name="myform" method="post">
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='10'>&nbsp;盘点仓库	<select name="store_id" id="store_id">
				<option value="">Please select</option>
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
			</select>		</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>编号</div>			</th>	
					<th scope='col' nowrap="nowrap">产品编号</th>
					<th scope='col' nowrap="nowrap">产品名称</th>
					<th scope='col' nowrap="nowrap">单位</th>
		            <th scope='col' nowrap="nowrap">实际库存</th>
                    <th scope='col' nowrap="nowrap">可用数量</th>
                    <th scope='col' nowrap="nowrap">实盘可用数量</th>
        <th scope='col'  nowrap="nowrap">操作</th>
	</tr>
		
   <?php 
				  
				  	$sql = "select * from  ebay_pandiandetail  where status='0' and user ='$user'";	
					  		
					$query		= $dbcon->query($sql);

					$total		= $dbcon->num_rows($query);
	
					$totalpages = $total;

				

				

				$pageindex  =( isset($_GET['pageindex']) )?$_GET['pageindex']:1;

				$limit = " limit ".($pageindex-1)*$pagesize.",$pagesize";

				$page=new page(array('total'=>$total,'perpage'=>$pagesize));

				$sql = $sql.$limit;
													
			
					$sql = $dbcon->execute($sql);
					$sql = $dbcon->getResultArray($sql);
					$totalcost		= 0;
					
					for($i=0;$i<count($sql);$i++){
						
						$id						= $sql[$i]['id'];
						$goods_sn 				= $sql[$i]['goods_sn'];				
						$goods_name 			= $sql[$i]['goods_name'];								
						$goods_count 			= $sql[$i]['goods_count'];
						$goods_unit				= $sql[$i]['goods_unit'];
						$wait_count				= $sql[$i]['wait_count'];
						$use_count				= $goods_count-$wait_count;
						$pandiancount				= $sql[$i]['pandian_count'];
				  ?>
					<tr height='20' class='oddListRowS1'>
						    <td scope='row' align='left' valign="top" ><?php echo $id; ?></td>				
						    <td scope='row' align='left' valign="top" ><?php echo $goods_sn;?>&nbsp;</td>				
						    <td scope='row' align='left' valign="top" ><?php echo $goods_name;?>&nbsp;-<?php echo $io_typename;?></td>
						    <td scope='row' align='left' valign="top" ><?php echo $goods_unit;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $goods_count;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $use_count;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><input type='text' name='pusecount<?php echo $id; ?>' id='pusercount<?php echo $id; ?>' value='<?php echo $pandiancount;?>' style='width:30px'></td>
						    <td scope='row' align='left' valign="top" ><a href="#" onClick="del(<?php echo $id; ?>)">删除</a>
						    &nbsp;</td>
			 		</tr>
              
              <?php
			  
			  
			  }
			  ?>
              
		<tr class='pagination'>
		<td colspan='11'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons' align="center"><input name="submit" type="submit" onclick='return check()'  value="保存盘点信息" /><?php    echo '<br><center>'.$page->show(2)."</center>";//输出分页 ?></td>
			  </tr>
			</table>		</td>
	</tr>
</table>
</form>

    <div class="clear"></div>
<?php

include "bottom.php";


?>
<script language="javascript">
	
	function del(id){
		if(confirm('您确认删除此条记录吗')){
			location.href = 'pandianadd.php?module=warehouse&id='+id+'&type=del';
		}
	}
	function check(id){
		var store_id	 	= document.getElementById('store_id').value;
		if(store_id==''){
			alert('请选择盘点仓库');
			return false;
		}
	}
function openwindow(url,name,iWidth,iHeight)
{
var url; //转向网页的地址;
var name; //网页名称，可为空;
var iWidth; //弹出窗口的宽度;
var iHeight; //弹出窗口的高度;
var iTop = (window.screen.availHeight-30-iHeight)/2; //获得窗口的垂直位置;
var iLeft = (window.screen.availWidth-10-iWidth)/2; //获得窗口的水平位置;
window.open(url,name,'height='+iHeight+',,innerHeight='+iHeight+',width='+iWidth+',innerWidth='+iWidth+',top='+iTop+',left='+iLeft+',toolbar=no,menubar=no,scrollbars=auto,resizeable=no,location=no,status=no');
}
 function addgoods(){
	var store_id	 	= document.getElementById('store_id').value;
	if(store_id==''){
		alert('请选择盘点仓库');
		return false;
	}
	var url	= 'addpandiangoods.php?storeid='+store_id;
	openwindow(url,'',1000,500);
 }
 function addgoodsxls(){
	var url	= 'addpandianxls.php';
	openwindow(url,'',1000,500);
 }

</script>