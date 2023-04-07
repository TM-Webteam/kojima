<?php

if ($_REQUEST['v1'] == "detail"){

	if ($_REQUEST['v2'] == "category") {
		$inc_page = "category.php";
	}
	else{
		$inc_page = "detail.php";
	} 
} 

// echo $inc_page;

	include ("./".$inc_page);

