<?php
include "include/config.php";


include "top.php";

	$type	= $_REQUEST['type'];
	if($type == "del"){
		
		$id	 = $_REQUEST['id'];
		$sql = "delete from ebay_messagecategory where id=$id";
		if($dbcon->execute($sql)){
			
			$status	= " -[<font color='#33CC33'>操作记录: 记录删除成功</font>]";
			
		}else{
		
			$status = " -[<font color='#FF0000'>操作记录: 记录删除失败</font>]";
		}
		
		
		
	
	}else{
		
		$status = "";
		
	}
	
 ?>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'></div>

<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
		
	<td nowrap="nowrap" scope="row" >
	<input tabindex='2' title='关联eBay帐号' class='button' type="button" name='button' value='添加广告模板' id='search_form_submit' onClick="location.href='advance_indexadd.php?module=advance&action=Message分类'"/>
	&nbsp;
    
    &nbsp;&nbsp;&nbsp;</td>
	</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='8'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" width='2%' class='paginationActionButtons'>&nbsp;</td>
				  <td  nowrap='nowrap' width='1%' align="right" class='paginationChangeButtons'>				  </td>
				</tr>
			</table>		</td>
	</tr><tr height='20'>
					<th scope='col' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>模板名称</div>			</th>
			
		<th scope='col' nowrap="nowrap">Ebay店铺名</th>
		<th scope='col' nowrap="nowrap">在线状态</th>
		<th scope='col' nowrap="nowrap">点击次数</th>
		<th scope='col' nowrap="nowrap">有效期</th>
		<th scope='col' nowrap="nowrap">创建日期</th>
  <th scope='col'  nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>备注</div>			</th>
			
					<th scope='col'  nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'> 操作 </div>			</th>
			
					</tr>
		
		  <?php 
				  
				  	$sql = "select * from ebay_advancename  where ebay_user='$user' ";
					$sqla = $dbcon->execute($sql);
					$sql = $dbcon->getResultArray($sqla);
					$dbcon->free_result($sqla);
						
						
				
					
					for($i=0;$i<count($sql);$i++){
						
						$template_name			= $sql[$i]['template_name'];
						$ebay_account			= $sql[$i]['ebay_account'];
						$id						= $sql[$i]['id'];
						
						
				  ?>
                  
                  
                  
		    
 
									<tr height='20' class='oddListRowS1'>
						<td scope='row' align='left' valign="top" ><?php echo $template_name;?>&nbsp;</td>
				
						    <td scope='row' align='left' valign="top" >
    &nbsp;&nbsp;<?php echo $ebay_account;?></td>
					    <td scope='row' align='left' valign="top" ><a href="messageindex.php?cidtype=<?php echo $id ?>&module=message&action=标记已回复Message&ostatus=3"></a>
    &nbsp;&nbsp;</td>
					    <td scope='row' align='left' valign="top" ><a href="messageindex.php?cidtype=<?php echo $id ?>&module=message&action=草稿Message&ostatus=2"></a>
    &nbsp;&nbsp;</td>
					    <td scope='row' align='left' valign="top" ><a href="messageindex.php?cidtype=<?php echo $id ?>&&module=message&action=未回复Message&ostatus=0"></a></td>
						    <td scope='row' align='left' valign="top" >&nbsp;</td>
						    <td scope='row' align='left' valign="top" >&nbsp;</td>
				
						    <td scope='row' align='left' valign="top" ><a href="#" onClick="delaccount(<?php echo $id; ?>)"></a>
                            
                            <a href="advance_indexadd.php?module=advance&id=<?php echo $id;?>">修改</a>
                            <br />
                            <br />
							 <a href="advance_indextemplate.php?module=advance&id=<?php echo $id;?>">模板广告管理</a>
                             <br />
                             <br />
                            <a href="#"  onclick="GetCode('<?php echo $id; ?>','<?php echo $ebay_account; ?>')"> 获取模板_样式01</a><br /></td>
      </tr>
              
              
              
              <?php
			  
			  
			  }
			  ?>
              
		<tr class='pagination'>
		<td colspan='8'>
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

		function delaccount(id){
		if(confirm('您确认删除此条记录吗')){
			
			location.href = 'messagecategory.php?type=del&id='+id+"&module=message&action=Message分类";
			
		
		}
	
	
	}
	
	
	
	function GetCode(id,account){
	var url ="advance_getcode.php?id="+id+"&account="+account;
	openwindow(url,'',550,385);
	}
	
	
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

</script>