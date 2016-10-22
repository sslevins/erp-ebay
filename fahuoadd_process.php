<?php
include "include/config.php";


include "top.php";




	
$id		= $_REQUEST["id"];
	
	$pid		= $_REQUEST["pid"];

	
	if($_POST['submit']){
		
			
			$name				= str_rep($_POST['name']);
			$templatename		= str_rep($_POST['templatename']);
			$days				= str_rep($_POST['days']);
			$order				= str_rep($_POST['order']);
			
			
			if($id == ""){			
			$sql	= "insert into ebay_fahuoprocess(name,template,days,pid,corder) values('$name','$templatename','$days','$pid','$order')";
			}else{
			
			$sql	= "update ebay_fahuoprocess set name='$name',template='$templatename',days='$days',corder='$order' where id=$id";
			}
		
			if($dbcon->execute($sql)){
			
			$status	= " -[<font color='#33CC33'>操作记录:添加成功</font>]";
			
		}else{
		
			$status = " -[<font color='#FF0000'>操作记录:添加失败</font>]";
		}
		
			
		
	}
	
	
	if($id	!= ""){
	
		
		$sql = "select * from  ebay_fahuoprocess where id=$id";
		$sql = $dbcon->execute($sql);
		$sql = $dbcon->getResultArray($sql);
					
		$ctemplate 	= $sql[0]['template'];
		$cname		= $sql[0]['name'];
		$cdays		= $sql[0]['days'];
		$corder		= $sql[0]['corder'];
		
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
                      <form id="form" name="form" method="post" action="fahuoadd_process.php?module=fahuo&action=发货流程添加&pid=<?php echo $pid;?>">
                  <table width="70%" height="210" border="0" cellpadding="0" cellspacing="0">
                <input name="id" type="hidden" value="<?php echo $id;?>">
			      <tr>
                    <td width="41%" height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right">步骤名称</div></td>
                    <td width="3%" align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
                    <td width="56%" height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
                      <input name="name" type="text" id="name" value="<?php echo $cname;?>">
                    </div></td>
                    </tr>
			      <tr>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right">调用模板</div></td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
                    <select name="templatename" id="templatename">
                    <?php
						$sql = "select * from ebay_messagetemplate where ebay_user='$user'";
						$sql = $dbcon->execute($sql);
						$sql = $dbcon->getResultArray($sql);
					
						
						for($i=0;$i<count($sql);$i++){
							
							$templatename	= $sql[$i]['name'];
							$ebay_note		= $sql[$i]['note'];
							$tid			= $sql[$i]['id'];
					
					?>
                           <option value="<?php echo $tid;?>" <?php if($ctemplate == $tid) echo "selected=selected" ?>><?php echo $templatename;?></option>
                    <?php } ?> 
                         </select></div></td>
			        </tr>
			      <tr>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">执行间隔天数</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
                      <input name="days" type="text" id="days" size="50" value="<?php echo $cdays;?>">
                    请输入数字</div></td>
			        </tr>
			      <tr>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt">执行顺序</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td height="30" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="order" type="text" id="order" size="50" value="<?php echo $corder;?>" />
			          第一份信输入1,</div></td>
			        </tr>
			      
			      
                  <tr>				 
                    <td height="30" align="right" class="left_txt"><div align="right"></div></td>
                    <td align="right" class="left_txt">&nbsp;</td>
                    <td height="30" align="right" class="left_txt"><div align="left">
                      <input name="submit" type="submit" value="保存数据" >
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

<script language="javascript">
	
	


</script>
