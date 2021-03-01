<?php

	//$admin_conn = mysqli_connect('localhost','root','','library');
	$temp_conn = mysqli_connect('localhost','temp','12345','library');

	if(mysqli_connect_errno()){
		die ("database connection fail...");
	}else{
		//echo "conn ok";
	}

	$member1_conn = mysqli_connect('localhost','member1','member1pwd','library');

	if(mysqli_connect_errno()){
		die ("database connection fail...");
	}else{
		//echo "conn ok";
	}

	$member2_conn = mysqli_connect('localhost','member2','member2pwd','library');

	if(mysqli_connect_errno()){
		die ("database connection fail...");
	}else{
		//echo "conn ok";
	}

	
?>