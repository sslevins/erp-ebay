<?php
include "include/config.php";


include "top.php";


/**
	 * 获得所有模块的名称以及链接地址
	 *
	 * @access      public
	 * @param       string      $directory      插件存放的目录
	 * @return      array
	 */
	function read_modules($directory = '.')
	{
		global $_LANG;
	
		$dir         = @opendir($directory);
		$set_modules = true;
		$modules     = array();
	
		while (false !== ($file = @readdir($dir)))
		{
			if (preg_match("/^.*?\.php$/", $file))
			{
				include_once($directory. '/' .$file);
			}
		}
		@closedir($dir);
		unset($set_modules);
	
		foreach ($modules AS $key => $value)
		{
			ksort($modules[$key]);
		}
		ksort($modules);
	
		return $modules;
	}

	
	$modules = read_modules('modules');
	

	


	
	if($_REQUEST['act'] == 'install'){
		
		$code		= $_REQUEST['code'];
		
		 $set_modules = true;
		 
		include_once('modules/' . $code . '.php');
		$lang_file = 'language/' .$code. '.php';
		include_once($lang_file);


		
		
		$sql = "SELECT * FROM  ebay_shipping  WHERE shipping_code='" .$code. "' ";
		$sql	= $dbcon->execute($sql);
		$sql	= $dbcon->getResultArray($sql);
		if(count($sql) ==  0){
		
				
				$sql = "INSERT INTO ebay_shipping (" .
                    "shipping_code, shipping_name, shipping_desc, insure, support_cod, enabled, print_bg, config_lable, print_model" .
                ") VALUES (" .
                    "'" . addslashes($modules[0]['code']). "', '" . addslashes($_LANG[$modules[0]['code']]) . "', '" .
                    addslashes($_LANG[$modules[0]['desc']]) . "', '$insure', '" . intval($modules[0]['cod']) . "', 1, '" . addslashes($modules[0]['print_bg']) . "', '" . addslashes($modules[0]['config_lable']) . "', '" . $modules[0]['print_model'] . "')";
					
		
					$dbcon->execute($sql);
					
		
		
		}
			
			
		
	
	}


	
		
	
	
	
	
	
 ?>
<div id="main">
    <div id="content" >
        <table style="width:100%"><tr><td><div class='moduleTitle'>
<h2><?php echo $_REQUEST['action'].$status;?> </h2>
</div>

<div class='listViewBody'>


<div id='Accountsbasic_searchSearchForm' style='' class="edit view search basic">
 
 
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	
	
		
	<td nowrap="nowrap" scope="row" >&nbsp;  配送区域 <br /></td>
	</tr>
</table>
</div>
<div id='Accountsadvanced_searchSearchForm' style='display:none' class="edit view search advanced"></div>
<div id='Accountssaved_viewsSearchForm' style='display: none';></div>
</form>
 
<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view'>
	<tr class='pagination'>
		<td colspan='4'>
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" width='2%' class='paginationActionButtons'>
                    <input type="button" value="新建配送区域" onclick="location.href='shipping_areaadd.php?module=system&action=新建配送区域&shipping_id=<?php echo $_REQUEST['shipping']; ?>'" />
				    &nbsp;</td>
				  <td  nowrap='nowrap' width='1%' align="right" class='paginationChangeButtons'>				  </td>
				</tr>
			</table>		</td>
	</tr><tr height='20'>
					<th scope='col' width='13%' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'>编号	</div>			</th>
			
					<th scope='col' width='13%' nowrap="nowrap">
				<div style='white-space: nowrap;'width='100%' align='left'> 配送区域名称 </div>			</th>
			
					<th scope='col' width='13%' nowrap="nowrap"> 所辖地区 </th>
		<th scope='col' width='13%' nowrap="nowrap"> 操作 </th>
	</tr>
   <?php 
				  
	for ($i = 0; $i < count($modules); $i++)
    {
	
		$lang_file = 'language/' .$modules[$i]['code']. '.php';
		

        if (file_exists($lang_file))
        {
            include_once($lang_file);
        }
		


        /* 检查该插件是否已经安装 */
        $sql = "SELECT shipping_id, shipping_name, shipping_desc, insure, support_cod  FROM ebay_shipping WHERE shipping_code='" .$modules[$i]['code']."'";
		

		
		$sql	= $dbcon->execute($sql);
		$sql	= $dbcon->getResultArray($sql);
		if(count($sql) > 0){
			

			
			

		
            $modules[$i]['id']      		= $sql[0]['shipping_id'];
            $modules[$i]['name'] 	 		= $sql[0]['shipping_name'];
            $modules[$i]['desc']   		 	= $sql[0]['shipping_desc'];
            $modules[$i]['insure_fee']  	= $sql[0]['insure'];
            $modules[$i]['cod']     		= $sql[0]['support_cod'];
            $modules[$i]['shipping_order']  = $sql[0]['shipping_order'];
            $modules[$i]['install'] = 1;
			
				  ?>
                  
                  
                  
		    
 
									<tr height='20' class='oddListRowS1'>
						<td scope='row' align='left' valign="top" ><?php echo $modules[$i]['name']; ?></td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $modules[$i]['desc']  ;?> </td>
				
						    <td scope='row' align='left' valign="top" ><?php echo $note;?>&nbsp;</td>
						    <td scope='row' align='left' valign="top" >&nbsp;</td>
	  </tr>
              
              
              
              <?php
			  
			  
			  }
			  }
			  
			  
			  ?>
			  
  
              
		<tr class='pagination'>
		<td colspan='4'>
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
	
	function del(id){
		if(confirm('您确认删除此条记录吗')){
			
			location.href = 'systemcarrier.php?type=del&id='+id+"&module=system&action=发货方式管理";
			
		
		}
	
	
	}



</script>