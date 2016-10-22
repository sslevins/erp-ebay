<?php
include "include/config.php";


include "top.php";
		
		$shipping_id	= $_REQUEST['shipping_id'];
	
		$sql = "SELECT * FROM  ebay_shipping  WHERE shipping_id='" .$shipping_id. "' ";
		
		
		$sql	= $dbcon->execute($sql);
		$sql	= $dbcon->getResultArray($sql);
		
		$set_modules = 1;
		$code		= $sql[0]['shipping_code'];		
		
		include_once('modules/' . $code . '.php');
		$lang_file = 'language/' .$code. '.php';
		include_once($lang_file);
		
		

   	 $fields = array();
   	 foreach ($modules[0]['configure'] AS $key => $val)
  	  {
        $fields[$key]['name']   = $val['name'];
        $fields[$key]['value']  = $val['value'];
        $fields[$key]['label']  = $_LANG[$val['name']];
 	   }
	
	print_r($fields);
	
	
	
	
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
		<td width="52%">
			<table border='0' cellpadding='0' cellspacing='0' width='100%' class='paginationTable'>
				<tr>
					<td nowrap="nowrap" width='2%' class='paginationActionButtons'>&nbsp;<table >
    <tr>
      <td class="label"> 配送区域名称: :</td>
<td><input type="text" name="shipping_area_name" maxlength="60" size="30" value="" />
  *</td>
    </tr>
    
    
    <?php
		
		for($i=0;$i<count($fields);$i++){
		
				$name		= $fields[$i]['name'];
				$value		= $fields[$i]['value'];
				$label		= $fields[$i]['label'];
		
	
	
	
	 ?>
            <tr id="" >
              <td class="label"><?php echo $label;?></td>
              <td><input type="text" name="{$field.name}"  maxlength="60" size="20" value="<?php echo $value;?>" />*</td>
            </tr>
            
            
            
            <?php
			
			
			}
			
			?>

  </table></td>
				  <td  nowrap='nowrap' width='1%' align="right" class='paginationChangeButtons'>				  </td>
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