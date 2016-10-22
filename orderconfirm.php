<?php 
include "include/config.php";


	$ebay_id					= $_REQUEST['ebay_id'];
	$ordershipfee				= $_REQUEST['ordershipfee'];
	$ordercopst					= $_REQUEST['ordercopst'];
	$orderweight				= $_REQUEST['orderweight']*1000;
	$sql		= "update ebay_order set ordershipfee='$ordershipfee',ordercopst='$ordercopst',orderweight2='$orderweight',profitstatus='1' where ebay_id ='$ebay_id'";
	if($dbcon->execute($sql)){
					$status	= " 操作记录: 操作成功";
	}else{
					$status = "操作记录: 操作失败";
	}
?>
<script language="javascript">

var str	= '<?php echo $status;?>';

alert(str);

window.close();

  

</script>