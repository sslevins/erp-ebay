<?php
include "include/config.php";
include "top.php";	
	/* 修改客户地址 */
	
	$stype	= $_REQUEST['stype'];
	$io_ordersn	= $_REQUEST['io_ordersn'];

	


	if($_REQUEST['addtype'] == 'del'){
	
		
		$id		= $_REQUEST['id'];
		$sql	= "delete from ebay_iostorepay where id=$id";
		echo $sql;
  		if($dbcon->execute($sql)){
			$status	= " -[<font color='#33CC33'>操作记录: 付款添加成功</font>]";
		}else{
			$status = " -[<font color='#FF0000'>操作记录: 付款添加失败</font>]";
		}
	}
	
	if($_REQUEST['addtype'] == 'save'){
		
		$sql			= "select * from  ebay_iostore where io_ordersn='$io_ordersn'";
		$sql			= $dbcon->execute($sql);
		$sql			= $dbcon->getResultArray($sql);
		
		$io_paidtotal	= $sql[0]['io_paidtotal'];
		
		$cost						=  $_REQUEST['cost'];
		$goods_sn					= $_REQUEST['goods_sn'];
		$sql	= "insert into ebay_iostorepay 
(io_ordersn,pay_time,pay_money,payer,remark) values('$io_ordersn','$mctime',$goods_sn,'$user'	,'$cost'	)";
	
		if($dbcon->execute($sql)){
			$dsql			= "select sum(pay_money) as total from  ebay_iostorepay where io_ordersn='$io_ordersn'";
 			$dsql			= $dbcon->execute($dsql);
			$dsql			= $dbcon->getResultArray($dsql);
			$pay_moeny= $dsql[0][total];
			
			if ($io_paidtotal>$pay_moeny)
			{$usql			= "update ebay_iostore set  paystatus=1  where io_ordersn='$io_ordersn'";
			$dbcon->execute($usql);
			}
			
			if ($io_paidtotal<=$pay_moeny){	$usql			= "update ebay_iostore set  paystatus=3  where io_ordersn='$io_ordersn'";
			$dbcon->execute($usql);
		}
		
		
			$status	.=   " -[<font color='#33CC33'>操作记录付款保存成功</font>]";
			$addtype	= '';
			
		}else{
			$status .= $sql." -[<font color='#FF0000'>操作记录:付款保存失败</font>]";
		}
		
		

	
	
	
	}
	
	
	
	

		

 ?>
<style type="text/css">
<!--
.STYLE1 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
 <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>

<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo '采购订单'.$status;?> </h2>
</div>

<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
 
<tr>
	
	
	
		
	<td nowrap="nowrap" scope="row" >&nbsp;<br />
	
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
                      <td class="login_txt_bt"> </td>
              </tr>
                    <tr>
                      <td valign="top" class="left_txt">
                      
                      &nbsp;<br />
                     付款记录
                      
                      <br />
                      <br /></td>
              </tr>
                    <tr>
                      <td class="login_txt_bt"><table width="100%" border="1" cellspacing="3" cellpadding="0">
                        <tr>
                          <td>编号</td>
                          <td>金额</td>
                          <td>付款人</td>
                          <td>备注</td>
                          <td>时间</td>
                         <td>操作</td>
                        </tr>
                        
                        <?php
							
							$sql	= "select * from ebay_iostorepay where io_ordersn='$io_ordersn'";
						
							$totalprice		= 0;
							$totalqty		= 0;
							
							$sql	= $dbcon->execute($sql);
							$sql	= $dbcon->getResultArray($sql);
							for($i=0;$i<count($sql);$i++){
								$remark			= $sql[$i]['remark'];
								$goods_sn			= $sql[$i]['pay_money'];
								$goods_name 		= $sql[$i]['vremark'];
								$goods_price 		= $sql[$i]['payer'];
 								$id					= $sql[$i]['id'];
								$pay_time  		= $sql[$i]['pay_time'];
								$totalprice			+= $goods_sn ; 
								$totalqty			+= $goods_count;
								
						?>
                        
                        <tr >
                          <td><?php echo  $i+1;?>. &nbsp;</td>
                          <td><?php echo $goods_sn;?>&nbsp;</td>
                          <td>  <?php echo $goods_price;?>  </td>
                          <td><?php echo $remark; ?>&nbsp;</td>
                          <td><?php
						  
						  if($pay_time != '') $pay_time	= date('Y-m-d H:i:s',$pay_time); 
						  
						   echo $pay_time;?>&nbsp;   </td>
                          <td>       &nbsp;   <?php if($iistatus != 2){ ?>
                          <a href="#" onclick="del('<?php echo $id;?>')">删除</a>&nbsp;&nbsp;
                           <?php   } 
						   
						   }
						   ?> </td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="6">金额：
                            <input name="goods_sn" type="text" id="goods_sn" />
                            备注：
                            <input name="notes" type="text" id="notes" />
                         
                          
                       
                          <input type="button" value="添加" onclick="add()" /></td>
                        </tr>
            
                      
                      
                      </table></td>
                    </tr>
                    <tr>
                      <td class="left_txt"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><br /></td>
                        </tr>
                        <tr>
                          <td><br /></td>
                        </tr>
                      </table></td>
                    </tr>
          </table></td>
	</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td width="65%">&nbsp;</td>
	</tr>
              
              
              

              
		<tr class='pagination'>
		<td>
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


	


	function add(){
 		
 		var goods_sn		= document.getElementById('goods_sn').value;
 		var notes			= document.getElementById('notes').value;
		if( notes == ""){
				alert("备注：不能为空");
				document.getElementById('notes').select();
				return false;		
		}
		if(isNaN(goods_sn) || goods_sn == ""){
				alert("金额:只能输入数字");
				document.getElementById('goods_sn').select();
				return false;		
		}
		location.href="purchaseorderpayadd.php?module=purchase&action=采购订单&io_ordersn=<?php echo $io_ordersn;?>&goods_sn="+encodeURIComponent(goods_sn)+"&stype=<?php echo $stype;?>&cost="+notes+"&addtype=save";
	}
	
	function del(id){
		var url		= "purchaseorderpayadd.php?module=purchase&action=采购订单&io_ordersn=<?php echo $io_ordersn;?>&addtype=del&id="+id;
		location.href  = url;
	}
	
	
	
</script>