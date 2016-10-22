<?php
include "include/config.php";


include "top.php";


	$ebayid			= $_REQUEST['ebayid'];
	
	
	if($ebayid != ''){
	$sql			= "delete from ebay_rma where id ='$ebayid'";
	
	
	if($dbcon->execute($sql)){

			

			

			$status	= " -[<font color='#33CC33'>操作记录: 产品修改成功</font>]";

			

		}else{

		

		

			$status = " -[<font color='#FF0000'>操作记录: 产品修改失败</font>]";

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
	
	
		
	<td nowrap="nowrap" scope="row" > Status:
<select name="status" id="status">\
<option value="">Please Select</option>

	    <option value="开启">开启</option>
	    <option value="已回复">已回复</option>
	    <option value="关闭">关闭</option>
        <option value="新产品">新产品</option>
	    <option value="采购成功">采购成功</option>
         <option value="采购失败">采购失败</option>
         
	    </select>   
	      Keys:
	      <input name="keys" type="text" id="keys" />
	      排序:
	      <select name="sort" id="sort">
            <option value="Order by userid">Order by userid</option>
            <option value="Order by countrys">Order by countrys</option>
            <option value="Order by sku">Order by sku</option>
            <option value="Order by rtatype">Order by rtatype</option>
            
          </select>
	      <input type="button" value="Search" onclick="searchs()" />
	      <input name="input" type="button" value="全选" onclick="check_all('ordersn','ordersn')" /><input type="button" value="导出" onclick="exportxls()" />
	      <input type="button" value="添加新的case" onclick="addnew()" />
	      <input type="button" value="显示到期需要处理的case" onclick="searchs('1')" /></td>
	</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='16'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" width='2%' class='paginationActionButtons'>&nbsp;</td>
				  <td  nowrap='nowrap' width='1%' align="right" class='paginationChangeButtons'>				  </td>
				</tr>
			</table>		</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap">操作</th>
					<th scope='col' nowrap="nowrap">状态</th>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'> Case单号 </div>			</th>
			
					<th scope='col' nowrap="nowrap">ebay 帐号</th>
					<th scope='col' nowrap="nowrap">退款金额</th>
					<th scope='col' nowrap="nowrap">客户ID</th>
					<th scope='col' nowrap="nowrap">国家</th>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'> Case日期: </div>			</th>
			
					<th scope='col' nowrap="nowrap">下次处理时间</th>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'> 处理完成日期 </div>			</th>
					<th scope='col' nowrap="nowrap"> 添加人 </th>
		            <th scope='col' nowrap="nowrap"> CASE类型 </th>
        <th scope='col' nowrap="nowrap"> CASE原因 </th>
		<th scope='col' nowrap="nowrap"> 原订单号 </th>
		<th scope='col' nowrap="nowrap">SKU</th>
					<th scope='col' nowrap="nowrap">操作</th>
	</tr>
   <?php 
				  
				  	$sql = "select * from ebay_rma where  ebay_status = '1' ";
					
					if($_REQUEST['keys']!= ''){
						
						
						$keys	= $_REQUEST['keys'];
						
						$sql.= " and (rma_osn like '%$keys%' or sku like '%$keys%' or OpenDate like '%$keys%' or SerialNumber like '%$keys%' or ordernumber like '%$keys%' or countrys like '%$keys%' or userid like '%$keys%')";
						
						
						
					}
					
					
					$sort		= $_REQUEST['sort'];
					$status		= $_REQUEST['status'];
					
					$type		= $_REQUEST['type'];
					
					
					if($type == 1){
					$sql	.= " and nexthandletime <= $mctime and rastatus != '关闭' ";
					}
					if($status != '') $sql .= " and rastatus ='$status' ";
					if($sort == ''){
					$sql .= " order by id desc ";
					}else{
					$sql .= ' '.$sort;					
					}
					
			
					$query		= $dbcon->query($sql);

				$total		= $dbcon->num_rows($query);

				$totalpages = $total;

				
				$pageindex  =( isset($_GET['pageindex']) )?$_GET['pageindex']:1;
				$limit = " limit ".($pageindex-1)*$pagesize.",$pagesize";

				

				$page=new page(array('total'=>$total,'perpage'=>$pagesize));

				$sql = $sql.$limit;

				$sql		= $dbcon->execute($sql);

				$sql		= $dbcon->getResultArray($sql);

			
					
					for($i=0;$i<count($sql);$i++){
						
						
						
						$id		 		= $sql[$i]['id'];
						
						$rma_osn 		= $sql[$i]['rma_osn'];
						$sku	 		= $sql[$i]['sku'];
						$OpenDate 		= $sql[$i]['OpenDate'];
						$SerialNumber 	= $sql[$i]['SerialNumber'];
						$AreaOwner		= $sql[$i]['AreaOwner'];
						$ordernumber	 	= $sql[$i]['ordernumber'];
						$status		 	= $sql[$i]['status'];
						$DueDate		 	= $sql[$i]['DueDate'];
						$ebayid		 	= $sql[$i]['ebay_id'];
						$id		 	= $sql[$i]['id'];
						$pid		 	= $sql[$i]['ebay_pid'];
						$rtatype		 	= $sql[$i]['rtatype'];
						$countrys		 	= $sql[$i]['countrys'];
						$userid		 	= $sql[$i]['userid'];
						
						$ebay_account		 	= $sql[$i]['ebay_account'];
						$ebay_refundamount		 	= $sql[$i]['ebay_refundamount'];
						$rastatus		 	= $sql[$i]['rastatus'];
						
						
						$nexthandletime		 	= $sql[$i]['nexthandletime'];
						if($nexthandletime > 0) $nexthandletime = date('Y-m-d ');
						 
						
						
				  ?>
                  
                  
                  
		    
 
									<tr height='20' class='oddListRowS1'>
									  <td scope='row' align='left' valign="top" ><input name="ordersn" type="checkbox" id="ordersn" value="<?php echo $id;?>" /></td>
						              <td scope='row' align='left' valign="top" ><?php echo $rastatus;?>&nbsp;</td>
						              <td scope='row' align='left' valign="top" ><?php echo $rma_osn; ?></td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $ebay_account;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $ebay_refundamount;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" >
                            
                            <?php
								
								echo $userid;
								
							
							
							?>
                            
                            
                            
                            
                            &nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $countrys;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $OpenDate; ?></td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $nexthandletime;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $DueDate; ?></td>
						    <td scope='row' align='left' valign="top" ><?php echo $AreaOwner;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $rtatype;?></td>
						    <td scope='row' align='left' valign="top" ><?php echo $status;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $ordernumber;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $sku;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><a href="#" onclick="rta('<?php echo $id;?>','<?php echo $id;?>')">查看</a>
                            
                            <a href="#" onclick="deletes('<?php echo $id;?>','<?php echo $id;?>')">删除</a>                            </td>
			  </tr>
									
                                                  
              <?php
			  
			  
			  }
			  ?>
              
                                    
                                    <tr height='20' class='oddListRowS1'>
									  <td colspan="16" align='left' valign="top" scope='row' ><?    echo '<br><center>'.$page->show(2)."</center>";//输出分页 ?></td>
	  </tr>
              
              

              
		<tr class='pagination'>
		<td colspan='16'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'></td>
					</tr>
			</table>		</td>
	</tr></table>


    <div class="clear"></div>
<?php

include "bottom.php";


?>
<script language="javascript">
	
	function del(id){
		if(confirm('您确认删除此条记录吗')){
			
			location.href = 'systemusers.php?type=del&id='+id+"&module=pcase&action=汇率设置";
			
		
		}
	
	
	}
	
	
	function searchs(type){
		var sorts		= document.getElementById('sort').value;
		var keys		= document.getElementById('keys').value;
		var status		= document.getElementById('status').value;
		var url		= 'prmaindex.php?keys='+keys+'&module=pcase&action=RMA管理&ostatus=1&sort='+sorts+"&type="+type+"&status="+status;
		location.href = url;
	
	}
	
	
	
	function rta(ebayid,pid){
		
		
		
		var url		= 'prma.php?ebayid='+ebayid+"&pid="+pid;
	
		openwindow(url,'',600,685);
	
	
	
	}
	
		function deletes(ebayid,pid){
		
		
		
		var url		= 'prmaindex.php?module=pcase&action=CASE管理&mstatus=0&ebayid='+ebayid+"&pid="+pid;
	
		location.href = url;
		
	
	
	
	}
		
//设定打开窗口并居中
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



function exportxls(){


		var bill = '';
		
		
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
	
	
	var url = "labeltoxls.php?bill="+bill;
	window.open(url,"_blank");
	
	
	
	



}


function addnew(){

var url		= 'prma.php?typstatus=1';
	
		openwindow(url,'',800,685);
	


}

</script>