<?php
include "include/config.php";


include "top.php";





	$startdate		= $_REQUEST['startdate'];
				$enddate		= $_REQUEST['enddate'];
				$account		= $_REQUEST['account'];
				$goodscategory  = $_REQUEST['goodscategory'];
	
 ?>
   <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status;?> </h2>
</div>

<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
		
	<td nowrap="nowrap" scope="row" >&nbsp;&nbsp;&nbsp;
	 开始时间：
	  <input name="startdate" type="text" id="startdate" onClick="WdatePicker()" value="<?php echo $startdate;?>"/>
	  结束时间：
	  <input name="enddate" type="text" id="enddate" onClick="WdatePicker()" value="<?php echo $enddate;?>" />
	  货品类别：<select name="goodscategory" id="goodscategory">
                            <option value="-1">Please Select</option>
                            <?php
							
							$tsql		= "select * from ebay_goodscategory where ebay_user='$user'";
							$tsql		= $dbcon->execute($tsql);
							$tsql		= $dbcon->getResultArray($tsql);
							for($i=0;$i<count($tsql);$i++){
								
								$categoryid		= $tsql[$i]['id'];
								$categoryname	= $tsql[$i]['name'];								
								
								
							?>
                            
                            <option value="<?php echo $categoryid;?>"  <?php if($categoryid == $goodscategory) echo "selected=\"selected\""?>><?php echo $categoryname; ?></option>
                            
                            <?php
							
							}
							
							
							?>
                            
                          </select>
	  帐号：<select name="account" id="account">
<option value="-1">Please Select</option>
                    <?php 
					
					$sql	 = "select * from ebay_account where ebay_user='$user'";
					$sql	 = $dbcon->execute($sql);
					$sql	 = $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){					
					 
					 	$caccount	= $sql[$i]['ebay_account'];
					 ?>
                      <option value="<?php echo $caccount;?>"  <?php if($account == $caccount) echo "selected=\"selected\""?>><?php echo $caccount;?></option>
                    <?php } ?>
                    </select>
	  <input type="button" value="统计" onclick="searchorder()" /></td>
</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='6'>
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
			
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>产品名称</div>			</th>
			
					<th scope='col' nowrap="nowrap"><span class="left_bt2">数量</span></th>
		<th scope='col' nowrap="nowrap">发生时间&nbsp;</th>
					<th scope='col' nowrap="nowrap">类型&nbsp;</th>
        </tr>
		


			  <?php
			  	
				$type		= $_REQUEST['type'];
				
			
				$sql		= "select * from ebay_goodshistory where ebay_user='$user' and  stocktype='$type'";
				$keys		= $_REQUEST['keys'];
				if($keys != ""){
				
					$sql	.= " and(goodsname like '%$keys%' or goodsn like '%$keys%')";
					
				}
				
				//http://127.0.0.1:99/twu/productinstockindex.php?startdate=2010-11-30&enddate=2010-12-29&account=testcheng&goodscategory=4&module=warehouse&action=%E8%B4%A7%E5%93%81%E5%87%BA%E5%BA%93%E6%98%8E%E7%BB%86&type=%E5%87%BA%E5%BA%93
				
				
				if($startdate != "" && $enddate != ""){
				
				
					$sql	    .= " and(addtime>='$startdate 00:00:00' and addtime<='$enddate 23:59:59')";
				
				
				}
				
				if($account !="" && $account !='-1'){
					
					$sql		.=" and ebay_account='$account'";
				
				
				}
				
				
				if($goodscategory != "" && $goodscategory != "-1"){
				
					$sql		.= "and goods_category='$goodscategory'";
				
				
				}
				
			
		//		echo $sql;
				
				
				
				$query		= $dbcon->query($sql);
				$total		= $dbcon->num_rows($query);
				
				$pageindex  =( isset($_GET['pageindex']) )?$_GET['pageindex']:1;
				$limit = " limit ".($pageindex-1)*$pagesize.",$pagesize";
		
				
				$page=new page(array('total'=>$total,'perpage'=>$pagesize));
				$sql = $sql.$limit;
				$sql		= $dbcon->execute($sql);
				$sql		= $dbcon->getResultArray($sql);
				for($i=0;$i<count($sql);$i++){
					
								
					$goodsid		= $sql[$i]['goodsid'];
					$goodsn			= $sql[$i]['goodsn'];
					$goodsname		= $sql[$i]['goodsname'];
					$goodsprice 	= $sql[$i]['goodsprice '];
					$goodsnumber	= $sql[$i]['goodsnumber'];
					$addtime 		= $sql[$i]['addtime'];
					$stocktype		= $sql[$i]['stocktype'];
					
					
					
			  ?>
              
              
                  
         		<tr height='20' class='oddListRowS1'>
						<td scope='row' align='left' valign="top" ><input name="ordersn" type="checkbox" id="ordersn" value="<?php echo $goods_id;?>" ><?php echo $goodsid;?></td>
				
						    <td scope='row' align='left' valign="top" >
							<?php echo $goodsn; ?>                            </td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $goodsname;?></td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $goodsnumber;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $addtime;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" ><?php echo $stocktype; ?>&nbsp;</td>
      </tr>
              


 
               <?php } ?>
		<tr class='pagination'>
		<td colspan='6'>
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
	
		location.href='productindex.php?module=warehouse&action=货品资料管理&type=delsystem&ordersn='+bill;
		
		
	}

}


		function searchorder(){
	
		

		var content 	= document.getElementById('keys').value;	
		location.href= 'productinstockindex.php?keys='+content+"&module=warehouse&action=货品资料管理&type=<?php echo $type;?>";
		
	}
	
	
	function instock(pid){
	
		
		var url	= "productinstock.php?pid="+pid+"&module=warehouse&action=货品入库";
		window.open(url,"_blank");
		
	
	
	}
	


function searchorder(){
	
		

		var startdate 		= document.getElementById('startdate').value;	
		var enddate 		= document.getElementById('enddate').value;	
		var goodscategory 	= document.getElementById('goodscategory').value;	
		var account 	= document.getElementById('account').value;	
		
		var url = 'productinstockindex.php?startdate='+startdate+"&enddate="+enddate+"&account="+account+"&goodscategory="+goodscategory+"&module=warehouse&action=<?php echo $_REQUEST['action'];?>&type=<?php echo $_REQUEST['type'];?>";
		
		location.href=url;
		
		
	}
	



</script>