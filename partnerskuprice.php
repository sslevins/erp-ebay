<link rel="stylesheet" type="text/css" href="../cache/themes/Sugar5/css/yui.css" />
<link rel="stylesheet" type="text/css" href="../cache/themes/Sugar5/css/deprecated.css" />
<link rel="stylesheet" type="text/css" href="../cache/themes/Sugar5/css/style.css" /> 
<?php
include "include/config.php";
include "top.php";
$keys					= $_REQUEST['keys']?trim($_REQUEST['keys']):"";
$partner_id				= $_REQUEST['partnerid'];

if($partner_id 	> 0){
		$sql		= "delete from  partner_skuprice where partner_id='$partner_id'";
		
		if($dbcon->execute($sql)){
					$status	= " -[<font color='#33CC33'>操作记录: 记录删除成功</font>]";
		}else{	
					$status = " -[<font color='#FF0000'>操作记录: 记录删除失败</font>]";
		}
}
$partnerid				= $_REQUEST['partnerid'];	// 供应商的ID号


	
 ?>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr>
          <td><div class='listViewBody'>
            
  <div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
		
	<td nowrap="nowrap" scope="row" >产品编号/供应商产品编号：
          <input name="keys" type="text" size="10" id="keys" value="<?php echo $keys ?>">
          <input type="button" value="查找" onClick="searchorder()">
          <input type="button" onclick="location.href='partnerskupriceadd.php?module=purchase&action=价格清单&partnerid=<?php echo $partnerid;?>'" value="添加" />
          <br /></td>
</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='8'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" width='2%' class='paginationActionButtons'>&nbsp;</td>
				  <td  nowrap='nowrap' width='1%' align="right" class='paginationChangeButtons'>				  </td>
				</tr>
			</table>		</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap">产品编号</th>
					<th scope='col' nowrap="nowrap">供应商编号</th>
			
					<th scope='col' nowrap="nowrap">产品单价</th>
			
					<th scope='col' nowrap="nowrap"><span class="left_bt2">产品名称</span></th>
		<th scope='col' nowrap="nowrap"><span class="left_bt2">备注</span></th>
		<th scope='col' nowrap="nowrap">添加人</th>
		<th scope='col' nowrap="nowrap">添加时间</th>
		<th scope='col' nowrap="nowrap">操作</th>
	</tr>
		


			  <?php
					
				$sql		= "select partner_id,sku,partner_sku,goods_name,goods_cost,goods_note,addtime,adduser,ebay_user from partner_skuprice where ebay_user='$user' and partnerid ='$partner_id'";
				
				
				if($_REQUEST['keys'] != ''){
					
					$keys		 = $_REQUEST['keys'];	
					$sql 		.= " and (sku like '%$keys%' or partner_sku like '%$keys%') ";
					
					
				
				
				}
				
				

				
				$query		= $dbcon->query($sql);
				$total		= $dbcon->num_rows($query);
				
				
				
				$pageindex  =( isset($_GET['pageindex']) )?$_GET['pageindex']:1;
				$limit = " limit ".($pageindex-1)*$pagesize.",$pagesize";
				$page=new page(array('total'=>$total,'perpage'=>$pagesize));
				$sql = $sql.$limit;
				$sql		= $dbcon->execute($sql);
				$sql		= $dbcon->getResultArray($sql);
				for($i=0;$i<count($sql);$i++){
					
				 		 $sku					= $sql[$i]['sku'];
						 $partner_sku			= $sql[$i]['partner_sku'];
						 $goods_name			= $sql[$i]['goods_name'];
						 $goods_cost			= $sql[$i]['goods_cost'];
						 $goods_note			= $sql[$i]['goods_note'];
						 $addtime				= $sql[$i]['addtime'];
						 $adduser				= $sql[$i]['adduser'];
						 $ebay_user				= $sql[$i]['ebay_user'];
						 $partner_id			= $sql[$i]['partner_id'];
				
					
			  ?>
              
              
                  
         		<tr height='20' class='oddListRowS1'>
				  <td scope='row' align='left' valign="top" ><?php echo $sku; ?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" >
							<?php echo $partner_sku; ?>                            </td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $goods_cost;?>&nbsp; </td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $goods_name;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $goods_note;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $adduser;?>&nbsp;</td>
		                    <td scope='row' align='left' valign="top" ><?php echo $addtime;?>&nbsp;</td>
		                    <td scope='row' align='left' valign="top" ><a href="partnerskupriceadd.php?id=<?php echo $partner_id;?>&module=system&partnerid=<?php echo $partnerid;?>" target="_parent">修改</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="partnerskuprice.php?partner_id=<?php echo $partner_id;?>&module=system&partnerid=<?php echo $partnerid;?>" target="_parent">删除</a></td>
	  </tr>
              
           
 
               <?php } ?>
		<tr class='pagination'>
		<td colspan='8'>
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


function searchorder()
{
  	
		var keys		= document.getElementById('keys').value;
		var url			= 'partnerskuprice.php?keys='+keys+'&module=system&partnerid=<?php echo $_REQUEST['partnerid']; ?>';
		location.href	= url;
		
		
}

function openurl(){
	
	var url = "partneradd.php?module=purchase&action=供应商管理";
	window.open(url,"_parent");
	
	
}


	function deleteallsystem(sn){

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
	
	if(confirm('确认删除此条记录')){
	
		location.href='partner.php?type=delsystem&id='+bill+"&module=purchase&action=<?php echo $_REQUEST['action'];?>";
		
	}

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


function exports(){
	
	var checkboxs = document.getElementsByName("ordersn");
    var bill      = '';
	
    for(var i=0;i<checkboxs.length;i++){

		if(checkboxs[i].checked == true){

			

			bill = bill + ","+checkboxs[i].value;

		
		}	

		

	}

	if(bill == ""){

		

		alert("如果您不选择供应商，将会导出所有供应商数据！！");

	}
	
	var url			= "partnertoxls.php?id="+bill;
	window.open(url);
	
}


</script>