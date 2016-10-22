<?php
include "include/config.php";


include "top.php";




	

	
	$id		= $_REQUEST["id"];

	
	if($_POST['submit']){
		
			
			$firstweight		= $_POST['firstweight'];
			$nextweight			= $_POST['nextweight'];
			$discount			= $_POST['discount'];
			$countrys			= $_POST['countrys'];
			$name				= $_POST['name'];
			$handlefee				= $_POST['handlefee'];
			
			$xx0				= $_POST['xx0'];
			$xx1				= $_POST['xx1'];
			
			
			if($id == ""){
			
			
			$sql	= "insert into ebay_hkpostcalcfee(firstweight,nextweight,discount,countrys,name,ebay_user,handlefee,xx0,xx1) values('$firstweight','$nextweight','$discount','$countrys','$name','$user','$handlefee','$xx0','$xx1')";
			
			
			
			}else{
			
			$sql	= "update ebay_hkpostcalcfee set firstweight='$firstweight',handlefee='$handlefee',nextweight='$nextweight',xx0='$xx0',xx1='$xx1',discount='$discount',countrys='$countrys',name='$name' where id=$id";
			}

		
			if($dbcon->execute($sql)){
			
			$status	= " -[<font color='#33CC33'>操作记录: 数据保存成功</font>]";
			
			if($id == "") $id		= mysql_insert_id();
			
		}else{
		
			$status = " -[<font color='#FF0000'>操作记录: 数据保存失败</font>]";
		}
		
			
		
	}
	
	

		
		$sql = "select * from ebay_hkpostcalcfee where id=$id";
		$sql = $dbcon->execute($sql);
		$sql = $dbcon->getResultArray($sql);
					
		$firstweight  	= $sql[0]['firstweight'];
		$nextweight  	= $sql[0]['nextweight'];
		$discount	  	= $sql[0]['discount'];
		$countrys	  	= $sql[0]['countrys'];
		$name		  	= $sql[0]['name'];
		$handlefee		  	= $sql[0]['handlefee'];
		
		$xx0		  	= $sql[0]['xx0'];
		$xx1		  	= $sql[0]['xx1'];
		

?>

<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status;?></h2>
</div>
 
<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 <input name="hiddenuserid" type="hidden" value="" id="hiddenuserid" />
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
		
	<td nowrap="nowrap" scope="row" >&nbsp;</td>
	</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td width="26%">
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" class='paginationActionButtons'>			
                      <form id="form" name="form" method="post" action="hkpostshipfeelistadd.php?module=system&action=运费管理&id=<?php echo $id;?>">
                        <table width="60%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>区域名称：</td>
                            <td>&nbsp;</td>
                            <td><input name="name" type="text" id="name" value="<?php echo $name;?>" /></td>
                          </tr>
                          <tr>
                            <td> 每公斤价格(港元)</td>
                            <td>&nbsp;</td>
                            <td><input name="firstweight" type="text" id="firstweight" value="<?php echo $firstweight;?>" /></td>
                          </tr>
                          
                          <tr>
                            <td>挂号费用(港元)</td>
                            <td>&nbsp;</td>
                            <td><input name="handlefee" type="text" id="handlefee" value="<?php echo $handlefee;?>" /></td>
                          </tr>
                          <tr>
                            <td>港元对应RMB汇率</td>
                            <td>&nbsp;</td>
                            <td><input name="discount" type="text" id="discount"  value="<?php echo $discount;?>" /></td>
                          </tr>
                          <tr>
                            <td>对应国家列表：</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td colspan="3"><textarea name="countrys" cols="100" rows="10" id="countrys"><?php echo $countrys;?></textarea>
                            &nbsp;</td>
                          </tr>
                          <tr>
                            <td colspan="3"><input name="submit" type="submit" value="保存" />
                            &nbsp;</td>
                          </tr>
                        </table>
                      </form> 
               </td>
               
	    </tr>
			</table>		</td>
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
