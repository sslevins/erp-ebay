<?php
	include "include/config.php";
	
	$type = $_REQUEST['action'];
	if($type =="Logout"){		
		$_SESSION['user'] = "";
		header("location: login.php");	
	}
	
	/* ³ö¿â¶©µ¥ */
	







?>
<script language="javascript">


location.href = 'login.php';

</script>
