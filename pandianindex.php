<?php
include "include/config.php";


include "top.php";
	$ostatus = $_REQUEST['ostatus'];
	$type	= $_REQUEST['type'];
	 $cpower	= explode(",",$_SESSION['power']);
	if($type == "del"){
		$id	 = $_REQUEST['id'];
		$sql = "delete from  ebay_pandian where pandian_sn='$id' and ebay_user ='$user' ";
		$sql2 = "delete from  ebay_pandiandetail where pandian_sn='$id' and user ='$user'";
	if($dbcon->execute($sql) && $dbcon->execute($sql2)){
			$status	= " -[<font color='#33CC33'>操作记录: 记录删除成功</font>]";
		}else{
			$status = " -[<font color='#FF0000'>操作记录: 记录删除失败</font>]";
		}
	}
	if($type == "savenote"){
		$id	 = $_REQUEST['id'];
		$notes	 = $_REQUEST['notes'];
		$sql = "update ebay_pandian set notes='$notes' where id=$id and ebay_user ='$user' ";
		//echo $sql;
	if($dbcon->execute($sql)){
			$status	= " -[<font color='#33CC33'>操作记录: 备注修改成功</font>]";
		}else{
			$status = " -[<font color='#FF0000'>操作记录: 备注修改失败</font>]";
		}
	}
	if($type == "shenhe"){
		$id	 = $_REQUEST['id'];
		$truename = $_SESSION['truename'];
		$time	= time();
		$usql = "update ebay_pandian set status='1',sh_user='$truename',sh_time='$time' where id=".$id;
		
		
		if($dbcon->execute($usql)){
			$vv = "select pandian_sn,store_id from ebay_pandian where id='$id'";
			$vv = $dbcon->execute($vv);
			$vv = $dbcon->getResultArray($vv);
			$sn = $vv[0]['pandian_sn'];
			$store_id = $vv[0]['store_id'];
			$vv = "select goods_sn,pandian_count from ebay_pandiandetail where pandian_sn='$sn'";
			$vv = $dbcon->execute($vv);
			$vv = $dbcon->getResultArray($vv);
			foreach($vv as $k=>$v){
				$goods_sn = $v['goods_sn'];
				$goods_count = $v['pandian_count'];
				$ss = "select goods_id from ebay_onhandle where goods_sn='$goods_sn' and store_id='$store_id'";
				$ss = $dbcon->execute($ss);
				$ss = $dbcon->getResultArray($ss);
				if(count($ss)>0){
					$usql	= "update ebay_onhandle set goods_count='$goods_count' where goods_sn='$goods_sn' and store_id='$store_id'";
					
					
					echo $usql.'<br>';
					
					
					$dbcon->execute($usql);
				}else{
					$ss = "select goods_id,goods_name from ebay_goods where goods_sn='$goods_sn' and ebay_user='$user'";
					$ss = $dbcon->execute($ss);
					$ss = $dbcon->getResultArray($ss);
					$goods_id = $ss[0]['goods_id'];
					$goods_name = $ss[0]['goods_name'];
					$insql = "insert into ebay_onhandle (goods_id,goods_name,goods_sn,store_id,goods_count) values ('$goods_id','$goods_name','$goods_sn','$store_id','$goods_count');";
					
					
					echo $insql.'<br>';
					
					$dbcon->execute($insql);
				}
			}
			$status	= " -[<font color='#33CC33'>操作记录: 记录审核成功</font>]";
		}else{
			$status = " -[<font color='#FF0000'>操作记录: 记录审核失败</font>]";
		}
	}

 ?>
    <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>

<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
	<h2><?php echo $_REQUEST['action'].$status;?> &nbsp; <a href="pandianindex.php?module=warehouse&ostatus=0&action=盘点审核">未审核(
    <?php
		
		$sql		= "select id from ebay_pandian where status=0 and ebay_user='$user'";		
		$sql			= $dbcon->execute($sql);
		$sql			= $dbcon->getResultArray($sql);	
		echo count($sql);
	?>
    
    
    
    
    )</a>&nbsp;&nbsp;&nbsp; <a href="pandianindex.php?module=warehouse&ostatus=1&action=盘点审核">已审核(
    
    <?php
		
		$sql		= "select id from ebay_pandian where status=1 and ebay_user='$user'";	
	
			
		$sql			= $dbcon->execute($sql);
		$sql			= $dbcon->getResultArray($sql);	
		echo count($sql);
	?>
    
    )</a>&nbsp;&nbsp;&nbsp;</h2>
</div>
<div class='listViewBody'>

<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
<form action="?module=warehouse" name="myform" method="post">
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='11'>&nbsp;			</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>编号</div>			</th>	
					<th scope='col' nowrap="nowrap">盘点单号</th>
					<th scope='col' nowrap="nowrap">盘点物品数</th>
					<th scope='col' nowrap="nowrap">盘点仓库</th>
					<th scope='col' nowrap="nowrap">盘点日期</th>
		            <th scope='col' nowrap="nowrap">提交人员</th>
					<?php if($ostatus==1){?>
					<th scope='col' nowrap="nowrap">审核日期</th>
		            <th scope='col' nowrap="nowrap">审核人员</th>
					<?php } ?>
					<th scope='col' nowrap="nowrap">状态</th>
                    <th scope='col' nowrap="nowrap">备注</th>
					<th scope='col'  nowrap="nowrap">操作</th>
	</tr>
		
   <?php 
				  
				  	$sql = "select * from  ebay_pandian  where ebay_user='$user' and status='$ostatus'";	
					  	
					$sql 	.= " order by add_time desc ";
					$query		= $dbcon->query($sql);

					$total		= $dbcon->num_rows($query);
	
					$totalpages = $total;

				

				//echo $sql;

				$pageindex  =( isset($_GET['pageindex']) )?$_GET['pageindex']:1;

				$limit = " limit ".($pageindex-1)*$pagesize.",$pagesize";

				$page=new page(array('total'=>$total,'perpage'=>$pagesize));

				$sql = $sql.$limit;
													
			
					$sql = $dbcon->execute($sql);
					$sql = $dbcon->getResultArray($sql);
					$totalcost		= 0;
					
					for($i=0;$i<count($sql);$i++){
						
						$id						= $sql[$i]['id'];
						$pandian_sn 			= $sql[$i]['pandian_sn'];				
						$store_id	 			= $sql[$i]['store_id'];	
						$vv = "select store_name from ebay_store where id='$store_id'";
						$vv = $dbcon->execute($vv);
						$vv = $dbcon->getResultArray($vv);
						$store_name = $vv[0]['store_name'];
						$vv = "select count(id) as counts from ebay_pandiandetail where pandian_sn='$pandian_sn'";
						$vv = $dbcon->execute($vv);
						$vv = $dbcon->getResultArray($vv);
						$pandian_count 			= $vv[0]['counts'];
						$add_time				= date("Y-m-d H:i",$sql[$i]['add_time']);
						$add_user				= $sql[$i]['add_user'];
						$sh_time				= $sql[$i]['sh_time']?date("Y-m-d H:i",$sql[$i]['sh_time']):'';
						$sh_user				= $sql[$i]['sh_user']?$sql[$i]['sh_user']:'';
						$statuss				= $sql[$i]['status']?'已审核':'未审核';
						$notes					= $sql[$i]['notes'];
				  ?>
					<tr height='20' class='oddListRowS1'>
						    <td scope='row' align='left' valign="top" ><?php echo $id; ?></td>				
						    <td scope='row' align='left' valign="top" ><?php echo $pandian_sn;?>&nbsp;</td>				
						    <td scope='row' align='left' valign="top" ><?php echo $pandian_count;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $store_name;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $add_time;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $add_user;?>&nbsp;</td>
							<?php if($ostatus==1){?>
						    <td scope='row' align='left' valign="top" ><?php echo $sh_time;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $sh_user;?>&nbsp;</td>
							<?php } ?>
							<td scope='row' align='left' valign="top" ><?php echo $statuss;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php if($ostatus==0){?><input type='text' name='notes<?php echo $id; ?>' id='notes<?php echo $id; ?>' value='<?php echo $notes; ?>' style='width:80px'><br><a href="#" onClick="savenote('<?php echo $id; ?>')">save</a><?php }else{ echo $notes;}?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><a href="#" onClick="check('<?php echo $pandian_sn; ?>','<?php echo $ostatus; ?>')">查看详细信息</a><?php if($ostatus==0){?> &nbsp;|&nbsp;<a href="#" onClick="shenhe(<?php echo $id; ?>)">审核</a> &nbsp;|&nbsp; <a href="#" onClick="del('<?php echo $pandian_sn; ?>')">删除</a><?php } ?>
						    &nbsp;</td>
			 		</tr>
              
              <?php
			  
			  
			  }
			  ?>
              
		<tr class='pagination'>
		<td colspan='11'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons' align="center"><?    echo '<br><center>'.$page->show(2)."</center>";//输出分页 ?></td>
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
			location.href = 'pandianindex.php?module=warehouse&id='+id+'&type=del&ostatus=0';
		}
	}
	function savenote(id){
			var notes = document.getElementById('notes'+id).value;
			location.href = 'pandianindex.php?module=warehouse&id='+id+'&type=savenote&ostatus=0&notes='+notes;
	}
	function shenhe(id){
		if(confirm('您确认审核通过此条记录吗')){
			location.href = 'pandianindex.php?module=warehouse&id='+id+'&type=shenhe&ostatus=0';
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
 function check(sn,status){
	var url	= 'pandiandetaillist.php?sn='+sn+'&status='+status;
	openwindow(url,'',600,400);
 }

</script>