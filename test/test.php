<?php
$t=date("H");

if ($t<"20") {
  echo "Have a bad day!";
}elseif ($t>20) {
	# code...
	echo "Have a good day!";
}
?>