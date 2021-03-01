<?php

	$admin_conn = mysqli_connect('localhost','root','','library');
	//$temp_conn = mysqli_connect('localhost','temp','','library');

	if(mysqli_connect_errno()){
		die ("database connection fail...");
	}else{
		//echo "conn ok";
	}

	
?>