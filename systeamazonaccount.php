<?php

include "include/config.php";





include "top.php";




$id		= $_REQUEST['id'];
if($id != ''){
$sql		= "delete  from  ebay_account where id='$id'";
if($dbcon->execute($sql)){
$status	= " -[<font color='#33CC33'>操作记录: 记录操作成功</font>]";
}else{
$status = " -[<font color='#FF0000'>操作记录: 记录操作失败</font>]";
}
}


	

 ?>
 <script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>

<style type="text/css">

<!--

.STYLE1 {font-size: xx-small}

-->

</style>



<div id="main">

    <div id="content" >

        <table style="width:100%"><tr><td>



<div class='listViewBody'>





<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">

 

 

<table width="100%" cellspacing="0" cellpadding="0" border="0">

<tr>

	

	

		

	<td nowrap="nowrap" scope="row" ><!--

               <input type="button" value="打印地址A4" onClick="detail2()">

               <input type="button" value="Label标签打印" onclick="detail3()" />-->
	 
	  <input type="button" value="添加Amazon" onclick="location.href='systeamazonaccountadd.php?module=system'" />
	  <a href="Amazon_guide.doc" target="_blank"> 下载帮定向导</a></td>
</tr>
</table>

</div>

<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>

<div id='Accountssaved_viewsSearchForm' style='display: none';></div>

</form>

 

<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>

	<tr class='pagination'>

		<td colspan='4'><div id="rows"></div> 		</td>
	</tr><tr height='20'>

					<th height="28" nowrap="nowrap" scope='col'><div align="left">帐号名称</div></th>

  <th scope='col' nowrap="nowrap"><div align="left">Merchant ID</div></th>

			

					<th scope='col' nowrap="nowrap">
                      <div align="left">MarketPlace ID</div></th>

        <th scope='col' nowrap="nowrap">操作</th>
	</tr>
			  <?php				

			
				$sql		= "select * from ebay_account as a where ebay_user ='$user' and AWS_ACCESS_KEY_ID != ''";
				

				$query		= $dbcon->query($sql);
				$total		= $dbcon->num_rows($query);
				$totalpages = $total;

				

				

				$pageindex  =( isset($_GET['pageindex']) )?$_GET['pageindex']:1;

				$limit = " limit ".($pageindex-1)*$pagesize.",$pagesize";

		

				

				$page=new page(array('total'=>$total,'perpage'=>$pagesize));

				$sql = $sql.$limit;

				$sql		= $dbcon->execute($sql);

				$sql		= $dbcon->getResultArray($sql);

				$dpage		= 0;


				for($i=0;$i<count($sql);$i++){

					
						$ebay_account			= $sql[$i]['ebay_account'];
						$MARKETPLACE_ID			= $sql[$i]['MARKETPLACE_ID'];
						$MERCHANT_ID			= $sql[$i]['MERCHANT_ID'];
						$AWS_SECRET_ACCESS_KEY	= $sql[$i]['AWS_SECRET_ACCESS_KEY'];
						$AWS_ACCESS_KEY_ID		= $sql[$i]['AWS_ACCESS_KEY_ID'];
						$id						= $sql[$i]['id'];
					
			  ?>

              

              

                  

         		<tr height='20' class='oddListRowS1'>

						<td scope='row' align='left' valign="top" ><div align="left"><?php echo $ebay_account;?></div></td>
				  <td scope='row' align='left' valign="top" ><div align="left"><?php echo $MERCHANT_ID;?></div></td>
			      <td scope='row' align='left' valign="top" ><div align="left"><?php echo $MARKETPLACE_ID;?></div></td>
		          <td scope='row' align='left' valign="top" >
                  <a href="systeamazonaccountadd.php?id=<?php echo $id; ?>&module=system">修改</a>
                  
                  &nbsp;<a href="#" onclick="deleterows('<?php echo $id;?>')">删除</a></td>
       		  </tr>
         	
				<?php }
				  ?> 

		<tr class='pagination'>

		<td colspan='4'>

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
	
	function deleterows(id){
	
			
			if(confirm("确认删除此条记录吗")){
			
			
				
				location.href	= 'systeamazonaccount.php?id='+id+"&module=system";
				
			
			
			}
			
		
	
	
	
	}
	



</script>