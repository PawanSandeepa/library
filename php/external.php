

<?php


	//check empty fild......
	global $conn;
	function check_empty($req_field){
		$error=array();
		foreach ($req_field as $value) {
			if(empty(trim($_POST[$value]))){
				$error[]=$value.' is required';
			}
		}
		return $error;
	}

	function check_length($max_length){
		$error=array();
		foreach ($max_length as $fild => $lenth) {
			if(strlen(trim($_POST[$fild])) > $lenth){
				$error[]=$fild.' must be less than '.$lenth.' characters';
			}
		}
		return $error;
	}

	function check_password($password,$r_password){
		$error=array();
		if ($password!=$r_password) {
			$error[]="passwords are not mach";
		}
		return $error;
	}


	function print_error($error,$lenth_error){
		if(!empty($error)){
			echo "<div class=\"error\">";
			foreach ($error as $display) {
				echo $display."<br>";
			}
			echo "</div>";
		}
		if(!empty($lenth_error)){
			echo "<div class=\"lerror\">";
			foreach ($lenth_error as $value) {
				echo $value."<br>";
			}
			echo "</div>";
		
		}
	}

	function print_ok($ok){
		if(!empty($ok)){
			echo "<div class=\"ok\">";
			foreach ($ok as $display) {
				echo $display."<br>";
			}
			echo "</div>";
		}
	}

	function check_member($admin_conn,$member_id){
		$error=array();
		$query="select id from members where id='{$member_id}'";
		$result_query=mysqli_query($admin_conn,$query);
		if ($result_query) {
			if (mysqli_num_rows($result_query)) {
				
			}else{
				$error[]="member id is not valid";	
			}	 
		}
		return $error;
	}


	function check_book($admin_conn,$book_id){
		$error=array();
		$query="select id from book where id='{$book_id}'";
		$result_query=mysqli_query($admin_conn,$query);
		if ($result_query) {
			if (mysqli_num_rows($result_query)) {
				
			}else{
 				$error[]="book id is not valid";
 			}
		}
		return $error;
	}

	function phpalert($getmsg){
		echo '<script type="text/javascript">';
			echo 'alert({$getmsg})';
		echo '</script>';
	}

?>

