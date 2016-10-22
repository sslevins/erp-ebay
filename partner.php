
<?php
include "include/config.php";
include "top.php";
$keys			= $_REQUEST['keys']?trim($_REQUEST['keys']):"";
$searchtype			= $_REQUEST['searchtype'];
$id				= $_REQUEST['id'];
$changestatus				= $_REQUEST['changestatus'];
$type			= $_REQUEST['type'];
if($id > 0 ){
	
	if($changestatus == 0){
	$vv			= "update ebay_partner set status = '0' , audittime ='' where id ='$id'  ";
	}else{
	$vv			= "update ebay_partner set status = '1' , audittime ='$nowtime',audituser='$truename' where id ='$id'  ";
	}
	if($dbcon->execute($vv)){
					$status	= " -[<font color='#33CC33'>操作记录: 审核成功</font>]";
	}else{
					$status = " -[<font color='#FF0000'>操作记录: 审核失败</font>]";
	}
}

if($type 	== "delsystem"){
	
	$ordersn = explode(",",$_REQUEST['bill']);
	//print_r($ordersn);
	$status  = "";
	for($g=0;$g<count($ordersn);$g++){
		
		
		$sn 	=  $ordersn[$g];

		if($sn != ""){
			
			$sql		= "delete from  ebay_partner where id='$sn'";
		
		//	echo $sql;
			
		if($dbcon->execute($sql)){
	
	
					$status	= " -[<font color='#33CC33'>操作记录: 记录删除成功</font>]";

	}else{
	

					$status = " -[<font color='#FF0000'>操作记录: 记录删除失败</font>]";

	}

			
		}
	}
	
}


	
 ?>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status;?> 

 &nbsp;
    <a href="partner.php?module=system&status=0&action=供应商管理">未审核(
  	<?php
		
		$sql		= "select id from ebay_partner where status= 0 and ebay_user='$user'";		
		$sql			= $dbcon->execute($sql);
		$sql			= $dbcon->getResultArray($sql);	
		echo count($sql);
	?>
    )</a>&nbsp;&nbsp;&nbsp; 
    
  	<a href="partner.php?module=system&status=1&action=供应商管理">已审核(
    
    <?php
		$sql		= "select id from ebay_partner where status= 1 and ebay_user='$user'";		
		$sql			= $dbcon->execute($sql);
		$sql			= $dbcon->getResultArray($sql);	
		echo count($sql);
	?>
    )</a>&nbsp;&nbsp;&nbsp; 
</h2>
</div>

<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
		
	<td nowrap="nowrap" scope="row" >
	<input class='button' type="button" name='button' value='全选' id='search_form_submit' onClick="check_all('ordersn','ordersn')" />
	&nbsp;
	
          关键字：
          <input name="keys" type="text" size="10" id="keys" value="<?php echo $keys ?>">
          <select name="searchtype" id="searchtype">
            <option value="0"  <?php if($searchtype == 0) echo 'selected="selected"';?>>按供应商</option>
            <option value="1"  <?php if($searchtype == 1) echo 'selected="selected"';?>>按SKU</option>
      
          </select>
            <input type="button" value="查找" onClick="searchorder()">
            <input type="button" value="添加" onclick="openurl()" />
            <input type="button" value="导出" onclick="exports()" />
            <input type="button" value="批量导入" onclick="location.href='partneraddxls.php?module=purchase&action=供应商管理'" />
            <input type="button" value="删除" onclick="deleteallsystem()" />
                    
                    
                    
                    
    
    
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='11'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" width='2%' class='paginationActionButtons'>&nbsp;</td>
				  <td  nowrap='nowrap' width='1%' align="right" class='paginationChangeButtons'>				  </td>
				</tr>
			</table>		</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>操作</div></th>
			
					<th scope='col' nowrap="nowrap">名称</th>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>姓名</div></th>
			
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>电话/移动/传真</div>			</th>
			
		<th scope='col' nowrap="nowrap">邮件&nbsp;</th>
					<th scope='col' nowrap="nowrap">QQ</th>
					<th scope='col' nowrap="nowrap">地址&nbsp;</th>
					<th scope='col' nowrap="nowrap">城市</th>
  <th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'> 备注	</div>			</th>
			
		<th scope='col' nowrap="nowrap">审核/审核人</th>
		<th scope='col' nowrap="nowrap">操作</th>
	</tr>
		


			  <?php
				$status		= $_REQUEST['status']?$_REQUEST['status']:0;
				$sql		= "select * from ebay_partner as a  where ebay_user='$user'";
				$tj = "";
				if($keys != "" && $searchtype == 0){
					$tj	= " and (company_name like '%$keys%' or username like '%$keys%' or tel like '%$keys%' or mobile like '%$keys%' or fax like '%$keys%' or mail like '%$keys%' or address like '%$keys%' or note like '%$keys%')";	$sql .= $tj;
					
				}
				
				
				if($keys != "" && $searchtype == 1){
					$sql	= "select * from ebay_partner as a join partner_skuprice as b on a.id = b.partnerid where b.sku like  '%$keys%'";
					
					
				}

				$sql		.= " and a.status ='$status' ";
				
				
				
				$query		= $dbcon->query($sql);
				$total		= $dbcon->num_rows($query);
				
				$pageindex  =( isset($_GET['pageindex']) )?$_GET['pageindex']:1;
				$limit = " limit ".($pageindex-1)*$pagesize.",$pagesize";
		
				
				$page=new page(array('total'=>$total,'perpage'=>$pagesize));
				$sql = $sql.$limit;
				$sql		= $dbcon->execute($sql);
				$sql		= $dbcon->getResultArray($sql);
				for($i=0;$i<count($sql);$i++){
					
				 		 $company_name			= $sql[$i]['company_name'];
						 $username				= @$sql[$i]['username'];
						 $tel					= @$sql[$i]['tel'];
						 $mobile				= @$sql[$i]['mobile'];
					     $fax					= @$sql[$i]['fax'];
						 $mail					= @$sql[$i]['mail'];
						 $address				= @$sql[$i]['address'];
								 $note			= @$sql[$i]['note'];
								  $id			= @$sql[$i]['id'];
						 $city					= @$sql[$i]['city'];
						 
						 $audituser					= @$sql[$i]['audituser'];
						 $audittime					= @$sql[$i]['audittime']; 
				
					 $QQ					= @$sql[$i]['QQ']; 
				
			  ?>
              
              
                  
         		<tr height='20' class='oddListRowS1'>
						<td scope='row' align='left' valign="top" ><input name="ordersn" type="checkbox" id="ordersn" value="<?php echo $id;?>" ></td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $company_name; ?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" >
							<?php echo $username; ?>                            </td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $tel;?>&nbsp; /<?php echo $mobile;?>/<?php echo $fax;?></td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $mail;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $QQ;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $address; ?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $city; ?></td>
						    <td scope='row' align='left' valign="top" ><?php echo $note; ?></td>
		                    <td scope='row' align='left' valign="top" ><?php echo $audittime;?>&nbsp;/<?php echo $audituser;?></td>
		                    <td scope='row' align='left' valign="top" ><a href="partneradd.php?id=<?php echo $id;?>&module=system&action=供应商管理" target="_parent">修改</a>&nbsp;
	                        <input type="button" value="审核" onclick="location.href='partner.php?module=system&action=供应商管理&status=0&id=<?php echo $id;?>&changestatus=1'" />
                            <input type="button" value="反审核" onclick="location.href='partner.php?module=system&action=供应商管理&status=0&id=<?php echo $id;?>&changestatus=0'" />
                            <input type="button" value="货品信息管理" onclick="location.href='partnerskuprice.php?module=system&action=价格清单&partnerid=<?php echo $id;?>'" /></td>
	  </tr>
              
           
 
               <?php } ?>
		<tr class='pagination'>
		<td colspan='11'>
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
  	var searchtype		= document.getElementById('searchtype').value;
		var keys		= document.getElementById('keys').value;
		var url			= 'partner.php?keys='+keys+'&module=system&action=供应商管理&status=<?php echo $_REQUEST['status'];?>&searchtype='+searchtype;
		location.href	= url;
		
		
}

function openurl(){
	
	var url = "partneradd.php?module=system&action=供应商管理";
	window.open(url,"_parent");
	
	
	
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
	
	if(confirm('确认删除此条记录')){
	
		location.href='partner.php?type=delsystem&bill='+bill+"&module=system&action=<?php echo $_REQUEST['action'];?>";
		
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
	
	var url			= "partnertoxls.php?id="+bill+"&status=<?php echo $status;?>";
	window.open(url);
	
}


</script>