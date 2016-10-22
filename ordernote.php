<?php
include "include/config.php";
include "top.php";	
	/* 修改客户地址 */
	$ordersn	= $_REQUEST['ordersn'];
	
	if($_POST['submit']){
		
		$content 	= $_POST['content'];
		$addtime	= date('Y-m-d H:i:s');
		$sql		= "insert into ebay_ordernote(addtime,content,user,ordersn) values('$addtime','$content','$user','$ordersn')";
		if($dbcon->execute($sql)){
	
	
					$status	= " -[<font color='#33CC33'>操作记录: 数据保存成功</font>]";

		}else{
	

					$status = " -[<font color='#FF0000'>操作记录: 数据保存成功</font>]";

		}
	
	
	}
	
	
	

	



 ?>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status;?> </h2>
</div>

<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic"></div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td width="65%"><table width="100%" border="0" cellspacing="1" cellpadding="3">
          <tr>
            <td>编号</td>
            <td>添加时间</td>
            <td>备注</td>
            <td>添加人</td>
            </tr>
            
            <?php 
			
			$sql		= "select * from ebay_ordernote where ordersn='$ordersn'";

	
			$sql		= $dbcon->execute($sql);
			$sql		= $dbcon->getResultArray($sql);
			for($i=0;$i<count($sql);$i++){

				$addtime		= $sql[$i]['addtime'];
				$content			= nl2br($sql[$i]['content']);
				$user			= $sql[$i]['user'];
			
			?>
            
          <tr>
            <td><?php echo $i+1;?>&nbsp;</td>
            <td><?php echo $addtime;?>&nbsp;</td>
            <td><?php echo $content;?>&nbsp;</td>
            <td><?php echo $user;?>&nbsp;</td>
          </tr>
          <?php
		  
		  }
		  
		  ?>
          <tr>
            <td colspan="4">
            <form action="ordernote.php?ordersn=<?php echo $ordersn;?>" method="post">
            备注：
              <textarea name="content" cols="60" rows="3" id="content"></textarea>
              <input name="submit" type="submit" id="submit" value="添加">
            </form>
            </td>
            
            </tr>
        </table></td>
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
	
	function del(ordersn,ebayid){
	
	
		
		if(confirm("确认删除此条记录吗")){
			
			location.href="ordermodifive.php?ordersn=<?php echo $ordersn ?>&ebayid=<?php echo $ebayid;?>&type=del&module=orders&action=新增订单";
			
		
		
		}
		
	
	
	}
	
	function mod(ordersn,ebayid){
	
		
		
		
		if(confirm("确认修改此条记录吗")){
			
			
			var pname	 = document.getElementById('pname'+ebayid).value;
			var pprice	 = document.getElementById('pprice'+ebayid).value;
			var pqty	 = document.getElementById('pqty'+ebayid).value;
			var psku	 = document.getElementById('psku'+ebayid).value;
			var pitemid	 = document.getElementById('pitemid'+ebayid).value;
			
			
			if(isNaN(pqty)){
				
				alert("数量只能输入数字");
				
			
			}else if(isNaN(pprice)){
				
				alert("价格只能输入数字");
			
			}else{
			
				location.href="ordermodifive.php?ordersn=<?php echo $ordersn ?>&ebayid="+ebayid+"&type=mod&pname="+encodeURIComponent(pname)+"&pprice="+pprice+"&pqty="+pqty+"&psku="+psku+"&pitemid="+pitemid+"&module=orders&action="+urlencode(新增订单);
			
			}
					
		}
		
	}
	
	function add(ordersn){
	
		
		var tname		= document.getElementById('tname').value;
		var tprice		= document.getElementById('tprice').value;
		var tqty		= document.getElementById('tqty').value;
		var tsku		= document.getElementById('tsku').value;
		var titemid		= document.getElementById('titemid').value;
		
		if(tname == ""){
		
				
				alert("请输入产品名称");
				document.getElementById('tname').select();
				return false;
				
		}
		
		if(isNaN(tprice) || tprice == ""){
				
				alert("数量只能输入数字");
				document.getElementById('tprice').select();
				return false;		
				
			
		}
		
		if(isNaN(tqty)){
				
				alert("价格只能输入数字");
				document.getElementById('tqty').select();
				return false;
			
		}			
		location.href="ordermodifive.php?ordersn=<?php echo $ordersn ?>&type=add&tname="+encodeURIComponent(tname)+"&tprice="+tprice+"&tqty="+tqty+"&tsku="+tsku+"&titemid="+titemid+"&module=orders&action=新增订单";
			
	}
	


</script>