<?php
include "include/config.php";

	
	$addmid		=$_POST['addmid'];
	$addmid		= explode("**",$addmid);

	for($i=0;$i<count($addmid);$i++){
		
		$mid		= $addmid[$i];
		
		
		if($mid != ''){
		
			
			$content	= $_POST['content'.$mid];
		
			
			AddMemberMessageRTQ($mid,$content,$_SESSION['truename']);		
		
		
		
		
		
		}
	
	
	
	
	
	
	}
	
	




?>
