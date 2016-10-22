<?php
include "include/config.php";


include "top.php";



$keys			= $_REQUEST['keys']?trim($_REQUEST['keys']):"";
$type			= $_REQUEST['type'];



if($type 	== "delsystem"){
	
	$ordersn = explode(",",$_REQUEST['id']);
	$status  = "";
	for($g=0;$g<count($ordersn);$g++){
		
		
		$sn 	=  $ordersn[$g];

		if($sn != ""){
			
			$sql		= "delete from  ebay_partner where id='$sn'";
		
			
			
		if($dbcon->execute($sql)){
	
	
					$status	= " -[<font color='#33CC33'>操作记录: 记录删除成功</font>]";

	}else{
	

					$status = " -[<font color='#FF0000'>操作记录: 记录删除失败</font>]";

	}

			
		}
	}
	
}


	
 ?>
  <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>


<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo '客户信息管理'.$status;?> </h2>
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
          开始时间：
          <input name="start" id="start" type="text" onclick="WdatePicker()" value="<?php echo $_REQUEST['start'];?>" />
          结束时间：
          <input name="end" id="end" type="text" onclick="WdatePicker()" value="<?php echo $_REQUEST['end'];?>" />
          <select name="sort" id="sort">
              <option value="0">按总金额降序</option>
              <option value="1">按总金额升序</option>
              <option value="2">按购买次数额降序</option>
               <option value="3">按购买次数额升序</option>
              
              
              
            </select>
          Account:
          <select name="ebay_account" id="ebay_account">
            <option value="" >未设置</option>
            <?php if($_REQUEST['module'] !='zencart'){ ?>
            <?php 
					$sql	 = "select * from ebay_account where ebay_user='$user' order by ebay_account desc ";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 	$account	= $sql[$i]['ebay_account'];
					 ?>
            <option value="<?php echo $account;?>" <?php if($ebay_account == $account) echo "selected=selected" ?>><?php echo $account;?></option>
            <?php }
					
					}else{
					 ?>
            <?php 
					$sql	 = "select * from ebay_zen where user='$user'";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 	$account	= $sql[$i]['zen_name'];
					 ?>
            <option value="<?php echo $account;?>" <?php if($ebay_account == $account) echo "selected=selected" ?>><?php echo $account;?></option>
            <?php } ?>
            <?php } ?>
          </select>
          <input type="button" value="查找" onClick="searchorder()">
            <input type="button" value="XLS导出" onClick="xls()">
			 <input type="button" value="邮箱txt格式下载" onClick="txt()">
            
                    
                    
                    
                    
    
    
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='9'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" width='2%' class='paginationActionButtons'>&nbsp;</td>
				  <td  nowrap='nowrap' width='1%' align="right" class='paginationChangeButtons'>				  </td>
				</tr>
			</table>		</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>操作</div></th>
			
					<th scope='col' nowrap="nowrap">&nbsp;</th>
					<th scope='col' nowrap="nowrap">姓名/客户ID</th>
		<th scope='col' nowrap="nowrap">邮件</th>
			
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>客户电话	</div>			</th>
			
					<th scope='col' nowrap="nowrap"><span style="white-space: nowrap;">所在国家</span></th>
		<th scope='col' nowrap="nowrap">总购买金额</th>
		<th scope='col' nowrap="nowrap">总购买次数</th>
		<th scope='col' nowrap="nowrap">黑名单</th>
	</tr>
		


			  <?php
			  	
				
			  	$sort	= $_REQUEST['sort'];
				
				
	
					
				$sql		= "SELECT ebay_ordersn,ebay_username,ebay_id, COUNT( * ) AS cc, SUM( ebay_total ) as total,ebay_countryname,ebay_phone,ebay_usermail,ebay_userid FROM ebay_order where ebay_user='$user' ";
		
				$keys		= trim($_REQUEST['keys']);
				if($keys	!='') $sql .=" and (ebay_username like '%$keys%' or ebay_userid like '%$keys%' or ebay_countryname like '%$keys%' or ebay_usermail like '%$keys%')";
				
				
				$start		= $_REQUEST['start'];
				$end		= $_REQUEST['end'];
				$ebay_account		= $_REQUEST['ebay_account'];
				if($start !='' && $end	!= ''){
				
					
					$start		= strtotime($start.' 00:00:00');
					$end		= strtotime($end.' 23:59:59');
					
					$sql		.= " and(ebay_createdtime>=$start and ebay_createdtime<=$end)";
				
				}
				
				if($ebay_account != '') $sql .= " and ebay_account ='$ebay_account'";
				
				$sql		.= " GROUP BY ebay_username ";
				
				if($sort  == '0') $sql	.= " ORDER BY  `total` desc ";
				if($sort  == '1') $sql	.= " ORDER BY  `total` asc ";
				if($sort  == '2') $sql	.= " ORDER BY  `cc` desc ";
				
				if($sort  == '3') $sql	.= " ORDER BY  `cc` asc ";
				
				
				
				
				
				$query		= $dbcon->query($sql);
				$total		= $dbcon->num_rows($query);
				
				$pageindex  =( isset($_GET['pageindex']) )?$_GET['pageindex']:1;
				$limit = " limit ".($pageindex-1)*$pagesize.",$pagesize";
		
				
				$page=new page(array('total'=>$total,'perpage'=>$pagesize));
				$sql = $sql.$limit;
				$sql		= $dbcon->execute($sql);
				$sql		= $dbcon->getResultArray($sql);
				for($i=0;$i<count($sql);$i++){
					
				 		 $ebay_username				= $sql[$i]['ebay_username'];
						 $ebay_userid				= $sql[$i]['ebay_userid'];
						 $ebay_ordersn				= $sql[$i]['ebay_ordersn'];
						 $ebay_id					= $sql[$i]['ebay_id'];
						 $ebay_usermail				= $sql[$i]['ebay_usermail'];
					 	 $ebay_phone				= $sql[$i]['ebay_phone'];
						 $cc						= $sql[$i]['cc'];
						 $total						= $sql[$i]['total'];
						 $ebay_countryname			= $sql[$i]['ebay_countryname'];
						 $ordersn				= $sql[$i]['ebay_ordersn'];
						
			  ?>
              
              
                  
         		<tr height='20' class='oddListRowS1'>
						<td scope='row' align='left' valign="top" ><input name="ordersn" type="checkbox" id="ordersn" value="<?php echo $ebay_id;?>" ></td>
				
						    <td scope='row' align='left' valign="top" >
							
							<a href="orderindex.php?keys=<?php echo $ebay_userid; ?>&account=&sku=&module=orders&action=%E6%89%80%E6%9C%89%E8%AE%A2%E5%8D%95&ostatus=100&note=&country=&start=&end=&shipping=&ebay_ordertype=-1&searchtype=1" target="_blank"></a></td>
						    <td scope='row' align='left' valign="top" ><?php echo $ebay_username; ?>&nbsp;<br />
					        <a href="orderindex.php?keys=<?php echo $ebay_userid; ?>&amp;account=&amp;sku=&amp;module=orders&amp;action=%E6%89%80%E6%9C%89%E8%AE%A2%E5%8D%95&amp;ostatus=100&amp;note=&amp;country=&amp;start=&amp;end=&amp;shipping=&amp;ebay_ordertype=-1&amp;searchtype=1" target="_blank"><?php echo $ebay_userid; ?></a></td>
						    <td scope='row' align='left' valign="top" >
							<?php echo $ebay_usermail; ?>                            </td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $ebay_phone;?>&nbsp; </td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $ebay_countryname;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $total;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $cc;?>&nbsp;</td>
		                    <td scope='row' align='left' valign="top" >
                            
                            <?php
								$vv		= "select * from ebay_hackpeoles where userid ='$ebay_userid' and mail ='$ebay_usermail'  ";
								$vv		= $dbcon->execute($vv);
								$vv		= $dbcon->getResultArray($vv);
								$status	= $vv[0]['status'];
								$id		= $vv[0]['id'];
						
							?>
                            
                            <?php if($status == ''){ ?>
                            <a href="#" onclick="bookhackorers('<?php echo $id;?>','<?php echo $ordersn;?>')" >登记</a>
                            <?php } ?>
                            
                            <?php if($status == '0'){ ?>
                            <a href="#" onclick="bookhackorers('<?php echo $id;?>','<?php echo $ordersn;?>')" >开启</a>
                            <?php } ?>
                            
                            <?php if($status == '1'){ ?>
                            <a href="#" onclick="bookhackorers('<?php echo $id;?>','<?php echo $ordersn;?>')" >关闭</a>
                            <?php } ?>
                            
                            
                            </a>
                  &nbsp;</td>
       		  </tr>
              
           
 
               <?php } ?>
		<tr class='pagination'>
		<td colspan='9'>
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



function bookhackorers(id,ordersn){
		
		var url = 'bookbackoreradd.php?id='+id+'&module=customer'+"&ordersn="+ordersn;
		location.href = url;
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

function xls()
{
  		
		
		
		var bill	= "";

	var g		= 0;

	var checkboxs = document.getElementsByName("ordersn");

    for(var i=0;i<checkboxs.length;i++){

		if(checkboxs[i].checked == true){

			

			bill = bill + ","+checkboxs[i].value;

			g++;

		}	

		

	}

	if(bill == ""){
		alert("如果您不选择订单号，将会导出所有客户资料");
	}
	var ebay_account			= document.getElementById('ebay_account').value;
	
		var start		= document.getElementById('start').value;
		var end			= document.getElementById('end').value;
	var url			= 'xlscustomer.php?customerid='+bill+"&start="+start+"&end="+end+"&ebay_account="+ebay_account;
	window.open(url,"_blank");
		
		
		
}
function txt()
{ 		
	var start		= document.getElementById('start').value;
	var end			= document.getElementById('end').value;	
	var ebay_account			= document.getElementById('ebay_account').value;

	if(start == "" && end==''){
		alert("请选择付款开始和结束时间");
		return false;
	}

	var url			= 'txtcustomer.php?start='+start+'&end='+end+"&ebay_account="+ebay_account;
	window.open(url,"_blank");
		
		
		
}

function searchorder()
{
  	
		var keys		= document.getElementById('keys').value;
		var start		= document.getElementById('start').value;
		var end			= document.getElementById('end').value;
		
		var sorts			= document.getElementById('sort').value;
		var ebay_account			= document.getElementById('ebay_account').value;
		
		var url			= 's_customer.php?keys='+keys+'&module=customer&action=customer&sort='+sorts+'&start='+start+"&end="+end+"&ebay_account="+ebay_account;
		location.href	= url;
		
		
}

function openurl(){
	
	var url = "partneradd.php";
	window.open(url,"_blank");
	
	
	
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
	
		location.href='partner.php?type=delsystem&id='+bill+"&module=partneraction=<?php echo $_REQUEST['action'];?>";
		
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
</script>