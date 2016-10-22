<?php
include "include/config.php";


include "top.php";




	

	
	$id		= $_REQUEST["id"];

	
	if($_POST['submit']){
		
			
			$cname		= $_POST['name'];
			$pid		= $_POST['pid'];
	
		
			
			if($id == ""){
			
			
			$sql	= "insert into ebay_goodscategory(name,ebay_user,pid) values('$cname','$user','$pid')";
			}else{
			
			$sql	= "update ebay_goodscategory set name='$cname',pid='$pid' where id=$id";
			}
			
			
			
	
			if($dbcon->execute($sql)){
			
			$status	= " -[<font color='#33CC33'>操作记录: 数据保存成功</font>]";
			
		}else{
		
			$status = " -[<font color='#FF0000'>操作记录: 数据保存失败</font>]";
		}
		
			
		
	}
	
	
	if($id	!= ""){
	
		
		$sql = "select * from ebay_goodscategory where id=$id";
		$sql = $dbcon->execute($sql);
		$sql = $dbcon->getResultArray($sql);
					
		$cname  	= $sql[0]['name'];
		$cpid	  	= $sql[0]['pid'];
	
	
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
                      <form id="form" name="form" method="post" action="productcategoryadd.php?module=warehouse&action=添加货品类别&id=<?php echo $id;?>">
                  <table width="70%" border="0" cellpadding="0" cellspacing="0">
                <input name="id" type="hidden" value="<?php echo $id;?>">
			      
			      <tr>
			        <td width="41%" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right"><span style="white-space: nowrap;">类别名称:</span></div></td>
			        <td width="3%" align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td width="56%" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="name" type="text" id="name" size="50" value="<?php echo $cname;?>">
			        </div></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">所属父类</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <select name="pid" id="pid">
                       <option value="0">无</option>
                        <?php
					
					$sql		= "select * from ebay_goodscategory where ebay_user='$user'";
					$sql		= $dbcon->execute($sql);
					$sql		= $dbcon->getResultArray($sql);
					for($i=0;$i<count($sql);$i++){
						
						$id		= $sql[$i]['id'];
						$name	= $sql[$i]['name'];
						
					
					
					
					
					
					?>
                        <option value="<?php echo $id;?>" <?php if($id == $cpid) echo "selected=selected"; ?>><?php echo $name;?></option>
                        <?php
					
					}
					
					?>
                      </select>
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
