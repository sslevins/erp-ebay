<?php
include "include/config.php";


include "top.php";




	

	
	$id		= $_REQUEST["id"];

	
	if($_POST['submit']){
		
			
			$countryen		= $_POST['countryen'];
			$countrycn		= $_POST['countrycn'];
			$countrysn		= $_POST['countrysn'];
			if($id == ""){
			
			
			$sql	= "insert into ebay_countrys(countryen,countrycn,countrysn,ebay_user) values('$countryen','$countrycn','$countrysn','$user')";
			}else{
			
			$sql	= "update ebay_countrys set countryen='$countryen',countrycn='$countrycn',countrysn='$countrysn' where id=$id";
			}

			if($dbcon->execute($sql)){
			
			$status	= " -[<font color='#33CC33'>数据保存成功</font>]";
		
			
		}else{
		
			$status = " -[<font color='#FF0000'>数据保存失败</font>]";
		}
		
			
		
	}
	
	
	if($id	!= ""){
	
		
		$sql = "select * from ebay_countrys where id=$id";
		$sql = $dbcon->execute($sql);
		$sql = $dbcon->getResultArray($sql);
		$countryen 	 	= $sql[0]['countryen'];
		$countrycn 		= $sql[0]['countrycn'];
		$countrysn 		= $sql[0]['countrysn'];
		
		
		
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
                      <form id="form" name="form" method="post" action="systemcountrysadd.php?module=system&action=地区列表">
                  <table width="70%" border="0" cellpadding="0" cellspacing="0">
                <input name="id" type="hidden" value="<?php echo $id;?>">
			      <tr>
                    <td width="41%" align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right"><span style="white-space: nowrap;">国家名称(英文)</span></div></td>
                    <td width="3%" align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
                    <td width="56%" align="right" bgcolor="#f2f2f2" class="left_txt">
                      <div align="left">
                        <input name="countryen" type="text" id="countryen" value="<?php echo $countryen;?>">
                        </div></td>
                    </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="right"><span style="white-space: nowrap;">国家名称(中文)</span></div></td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div id="gt-res-content">
			            <div dir="ltr">
			              <div align="left">
			                <input name="countrycn" type="text" id="countrycn" value="<?php echo $countrycn;?>" />
			                  </div>
			            </div>
			            </div>
			          <div align="left">
			            <div id="gt-res-tools">
		              </div></td>
			        </tr>
			      <tr>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">国家代码</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt">&nbsp;</td>
			        <td align="right" bgcolor="#f2f2f2" class="left_txt"><div align="left">
			          <input name="countrysn" type="text" id="countrysn" value="<?php echo $countrysn;?>" />
			          </div></td>
			        </tr>
			      
			      
			      
			      
			      
                  <tr>				 
                    <td align="right" class="left_txt"><div align="right"></div></td>
                    <td align="right" class="left_txt">&nbsp;</td>
                    <td align="right" class="left_txt"><div align="left">
                      <input name="submit" type="submit" value="Save">
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
