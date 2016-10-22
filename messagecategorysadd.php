<?php
include "include/config.php";


include "top.php";




	

	
	$id		= $_REQUEST["id"];

	
	if($_POST['submit']){
		
			
			$tempname		= $_POST['tempname'];

			
			
			if($id == ""){
			
			
			$sql	= "insert into ebay_templatecategory(name,ebay_user) values('$tempname','$user')";
			}else{
			$sql	= "update ebay_templatecategory set name='$tempname' where id=$id";
			}

		
			if($dbcon->execute($sql)){
			
			$status	= " -[<font color='#33CC33'>操作记录: 数据保存成功</font>]";
		
			
			
		}else{
		
			$status = " -[<font color='#FF0000'>操作记录: 数据保存失败</font>]";
		}
		
			
		
	}
	
	
	if($id	!= ""){
	
		
		$sql = "select * from ebay_templatecategory where id=$id";
		$sql = $dbcon->execute($sql);
		$sql = $dbcon->getResultArray($sql);
					
		$tempname  	= $sql[0]['name'];
	
	
	}
	
	
	


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
                      <form id="form" name="form" method="post" action="messagecategorysadd.php?module=message&action=模板添加">
                  <table width="70%" border="1" cellpadding="0" cellspacing="0">
                <input name="id" type="hidden" value="<?php echo $id;?>">
			      <tr>
                    <td width="41%" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right"><span style="white-space: nowrap;">模板名称	 </span>:</div></td>
                    <td width="3%" align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
                    <td width="56%" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
                      <input name="tempname" type="text" id="tempname" value="<?php echo $tempname;?>">
                    </div></td>
                    </tr>
			      
			      

			      
			      
			      
                  <tr>				 
                    <td align="right" class="left_txt"><div align="right"></div></td>
                    <td align="right" class="left_txt">&nbsp;</td>
                    <td align="right" class="left_txt"><div align="left">
                      <input name="submit" type="submit" value="保存数据" onClick="return check()">
                    </div></td>
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
