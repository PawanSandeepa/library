<?php session_start(); ?>
<?php require_once('../connection/conn.php'); ?>
<?php require_once('../connection/tempconn.php'); ?>
<?php require_once('external.php'); ?>

<?php
	$error=array();
	$lenth_error=array();
	$ok=array();

	$member_id='';

	if (isset($_SESSION['job_position'])) {
		$job_position=$_SESSION['job_position'];
	}else{
		header('Location:login.php?page=member_profile');
	}
	
	if(isset($_GET['id'])){
		$member_id=$_GET['id'];
	}elseif("member"==($_SESSION['job_position'])){
		$member_id=$_SESSION['id'];
	}else{
		$error[]="didn't passed id details...";
	}

	

	$display_profile='';
	$display_transactions='';
	$get_book='';

	$privete_detail_query="SELECT id,f_name,l_name,initials,address,dob,gender,phone_mobile,phone_home,nic,address_of_working,working_place,grade,email,registered_date,caretaker_name,caretaker_address,caretaker_nic,guarantor_name,guarantor_address,guarantor_post,guarantor_working_place FROM members WHERE id='{$member_id}' LIMIT 1";
	$transactions_detail_query="SELECT member_id,book_id,issued_date,issued_by,due_date FROM transactions WHERE member_id='{$member_id}' and (return_date IS NULL or return_date='UNKNOWN')";

	$privete_detail=mysqli_query($admin_conn,$privete_detail_query);
	$transactions_detail=mysqli_query($admin_conn,$transactions_detail_query);

	if ($privete_detail) {
		while($detail=mysqli_fetch_assoc($privete_detail)){
		    $id=$detail['id'];
		    $f_name=$detail['f_name'];
		    $l_name=$detail['l_name'];
		    $initials=$detail['initials'];
		    $address=$detail['address'];
		    $dob=$detail['dob'];
		    $gender=$detail['gender'];
		    $phone_mobile=$detail['phone_mobile'];
		    $phone_home=$detail['phone_home'];
		    $nic=$detail['nic'];
		    $address_of_working=$detail['address_of_working'];
		    $working_place=$detail['working_place'];
		    $grade=$detail['grade'];
		    $email=$detail['email'];
		    $registered_date=$detail['registered_date'];
		    $caretaker_name=$detail['caretaker_name'];
		    $caretaker_address=$detail['caretaker_address'];
		    $caretaker_nic=$detail['caretaker_nic'];
		    $guarantor_name=$detail['guarantor_name'];
		    $guarantor_address=$detail['guarantor_address'];
		    $guarantor_post=$detail['guarantor_post'];
		    $guarantor_working_place=$detail['guarantor_working_place'];

			$display_profile.='<div class="profile">';
				$display_profile.='<h2>Personal details</h2>';
				$display_profile.='<div class="dprofile">';
					$display_profile.='<img src="../img/member/profilepic/'.$id.'.jpg">';				
					if ($job_position=="admin" or $job_position=="assistant") {
							$display_profile.='<br><button onclick="window.location.href = \'upload.php?id='.$id.'\'" style="padding:5px;">change profile picture</button>';
							//$display_profile.='<form action="edit_member.php" method="post">';
								//$display_profile.='<input type="hidden" name="id" value="'.$id.'">';
								//$display_profile.='<br><button name="edit" type="submit" style="padding:5px;">edit detail</button>';
								$display_profile.='<br><input type=button style="padding:5px;" onClick="location.href=\'edit_member.php?id='.$member_id.'\'" value=\'edit profile\'></button>';
							//$display_profile.='</form>';
							//$display_profile.='<form action="member_profile.php">';
								$display_profile.='<br><input type=button style="padding:5px;" onClick="location.href=\'reset_password.php?id='.$member_id.'\'" value=\'reset password\'></button>';
							//$display_profile.='</form>';
					}elseif($job_position=="member"){
						$display_profile.='<form action="upload.php" method="post">';
							$display_profile.='<input type="hidden" name="id" value="'.$id.'">';
							//$display_profile.='<br><button name="upload" type="submit" >change profile picture</button><br>';
						$display_profile.='</form>';
						$display_profile.='<br><input type=button onClick="location.href=\'change_password.php\'" value=\'change password\'  style="padding:5px;"></button><br>';
					}else{
						header("Location:login.php?page=member_profile");
					}
					$display_profile.='<table id="list">';
						$display_profile.='<tr><td>member id</td><td>'.$id.'</td></tr>';
						$display_profile.='<tr><td>first name</td><td>'.$f_name.'</td></tr>';
						$display_profile.='<tr><td>last name</td><td>'.$l_name.'</td></tr>';
						$display_profile.='<tr><td>initials</td><td>'.$initials.'</td></tr>';
						$display_profile.='<tr><td>address</td><td>'.$address.'</td></tr>';
						$display_profile.='<tr><td>dob</td><td>'.$dob.'</td></tr>';
						$display_profile.='<tr><td>gender</td><td>'.$gender.'</td></tr>';
						$display_profile.='<tr><td>phone_mobile</td><td>'.$phone_mobile.'</td></tr>';
						$display_profile.='<tr><td>phone_home</td><td>'.$phone_home.'</td></tr>';
						$display_profile.='<tr><td>nic</td><td>'.$nic.'</td></tr>';
						$display_profile.='<tr><td>address_of_working</td><td>'.$address_of_working.'</td></tr>';
						$display_profile.='<tr><td>working_place</td><td>'.$working_place.'</td></tr>';
						$display_profile.='<tr><td>grade</td><td>'.$grade.'</td></tr>';
						$display_profile.='<tr><td>email</td><td>'.$email.'</td></tr>';
						$display_profile.='<tr><td>registered_date</td><td>'.$registered_date.'</td></tr>';
						$display_profile.='<tr><td>caretaker_name</td><td>'.$caretaker_name.'</td></tr>';
						$display_profile.='<tr><td>caretaker_address</td><td>'.$caretaker_address.'</td></tr>';
						$display_profile.='<tr><td>caretaker_nic</td><td>'.$caretaker_nic.'</td></tr>';
						$display_profile.='<tr><td>guarantor_name</td><td>'.$guarantor_name.'</td></tr>';
						$display_profile.='<tr><td>guarantor_address</td><td>'.$guarantor_address.'</td></tr>';
						$display_profile.='<tr><td>guarantor_post</td><td>'.$guarantor_post.'</td></tr>';
						$display_profile.='<tr><td>guarantor_working_place</td><td>'.$guarantor_working_place.'</td></tr>';
					$display_profile.='</table>';
					$display_profile.='</div>';
			$display_profile.='</div>';
		}
	}
	if ($transactions_detail) {
		$wich_book=1;
		$display_transactions.='<div class="trance">';
			$display_transactions.='<h2>transactions details</h2>';
			
				while($detail=mysqli_fetch_assoc($transactions_detail)){
				    $member_id=$detail['member_id'];
				    $book_id=$detail['book_id'];
				    $issued_date=$detail['issued_date'];
				    $issued_by=$detail['issued_by'];
				    $due_date=$detail['due_date'];

				    $date_due_date=date_create($due_date);
				    $today=date('Y-m-d');
				    $date_today=date_create($today);

					$diff=date_diff($date_today,$date_due_date);
					if ($date_today<$date_due_date) {
				    	$display_transactions.='<table id="list">';
				    }else{
				    	$display_transactions.='<table id="rlist">';
				    }
				    
				    $get_book="SELECT name,category_number,statu FROM book WHERE id='{$book_id}'";
				    $get_book_detail=mysqli_query($admin_conn,$get_book);
				    
				    $display_transactions.='<tr><th colspan="2">book '.$wich_book.' details</th></tr>';
				    $display_transactions.='<tr><td>book_id</td><td>'.$book_id.'</td></tr>';
				    while($book_detail=mysqli_fetch_assoc($get_book_detail)){
				    	$display_transactions.='<tr><td>book name</td><td>'.$book_detail['name'].'</td></tr>';
				    	$display_transactions.='<tr><td>category_number</td><td>'.$book_detail['category_number'].'</td></tr>';
				    	$category_details="SELECT category_name FROM category WHERE category_number='{$book_detail['category_number']}'";
				    	$get_category_detail=mysqli_query($admin_conn,$category_details);
				    	$get_details=mysqli_fetch_assoc($get_category_detail);
				    	$display_transactions.='<tr><td>category_name</td><td>'.$get_details['category_name'].'</td></tr>';
				    	$display_transactions.='<tr><td>statu</td><td>'.$book_detail['statu'].'</td></tr>';
				    }
				    $display_transactions.='<tr><td>issued_date</td><td>'.$issued_date.'</td></tr>';
				    $display_transactions.='<tr><td>issued_by</td><td>'.$issued_by.'</td></tr>';
				    $display_transactions.='<tr><td>due_date</td><td>'.$due_date.'</td></tr>';
				    $display_transactions.='<tr><td colspan="2">'.$diff->format("%R%a days").'</td></tr>';
				    if ($diff->format("%R%a days")<28) {
				    	$display_transactions.='<form action="member_profile.php?id='.$member_id.'" method="post">';
				    		$display_transactions.='<input type="hidden" name="member_id" value="'.$member_id.'">';
				    		$display_transactions.='<input type="hidden" name="book_id" value="'.$book_id.'">';
				    		$display_transactions.='<tr><td colspan="2"><button class="add" type="submit" name="extend">extend book due date</button></td></tr>';
				    	$display_transactions.='</form>';
				    }

				    $wich_book=$wich_book+1;
				}
			$display_transactions.='</table>';
					$display_transactions.='</div>';
	}
	
	if (isset($_POST['extend'])) {
		$member_id=mysqli_real_escape_string($admin_conn,$_POST['member_id']);
		$book_id=mysqli_real_escape_string($admin_conn,$_POST['book_id']);
		$query="INSERT INTO extend_request(extend_type,member_id,book_id) VALUES('book_due_date','{$member_id}','{$book_id}')";
		$rquery=mysqli_query($member2_conn,$query);
		if ($rquery) {
			echo '<script type="text/javascript">';
				echo 'alert(\'your request send to library\nif librarian confirms your request, your due time will extend\')';
			echo '</script>';
		}else{
			echo '<script type="text/javascript">';
				echo 'alert(\'your alreay requested\')';
			echo '</script>';
		}
		
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>member profile</title>
	<link rel="stylesheet" type="text/css" href="../css/list.css">
</head>
<body>
	<div>
		<?php require_once('header.php'); ?>
		<?php require_once('banner.php'); ?>
	</div>

	<?php
		print_error($error,$lenth_error);
		echo $display_profile;
		echo $display_transactions;
	?>

	<div class="includeone">
		<?php require_once('footer.php') ?>
	</div>
</body>
</html>