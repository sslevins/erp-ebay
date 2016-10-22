<?php
header("Content-Type: application/octet-stream");  
header('Content-Disposition: attachment; filename="mail.txt"');  
include "include/config.php";
$start		= strtotime($_REQUEST['start'].' 00:00:00');
$end		= strtotime($_REQUEST['end'].' 23:59:59');

$ebay_account	= $_REQUEST['ebay_account'];




$sql		= "SELECT ebay_usermail FROM ebay_order where ebay_createdtime>=$start and ebay_createdtime<=$end and ebay_user='$user' ";


if($ebay_account != '' ) $sql .= " and ebay_account='$ebay_account' ";

$sql		= $dbcon->execute($sql);
$sql		= $dbcon->getResultArray($sql);
$a = 0;
foreach($sql as $k=>$v){
	if(preg_match("/^([0-9a-zA-Z]+[.]?+[0-9a-zA-Z])+@(([0-9a-zA-Z]+)[.])+[a-z]{2,10}$/i",$v['ebay_usermail'] )){
		if(($a+1)%6==0){
			echo ' '.$v['ebay_usermail']."; \r\n";
		}else{
			echo ' '.$v['ebay_usermail']."; ";
		}
		$a++;
	}
}