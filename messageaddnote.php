<?php

include "include/config.php";

$id					= $_REQUEST['id'];
$ebay_account		= $_REQUEST['ebay_account'];
$note				= str_rep($_REQUEST['note']);
$truename			= $_SESSION['truename'];


$ss					= "insert into ebay_messagenote(note,messageid,addtime,ebay_user,ebay_account) values('$note','$id','$nowtime','$truename','$ebay_account')";


if($dbcon->execute($ss)){

	
	echo 'Add success';
	

}else{


	
	echo 'Add Failure';

}




?><input name="" type="button" value="Ok" onclick="cl()" />
<script language="javascript">

function cl(){

//window.opener.location.href  ='a.php';

//window.opener.location.href=window.opener.location.href;


window.close();




}





</script>

