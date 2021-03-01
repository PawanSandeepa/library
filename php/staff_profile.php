<?php session_start(); ?>
<?php require_once('../connection/conn.php'); ?>
<?php require_once('external.php'); ?>

<?php
	$error=array();
	$lenth_error=array();
	$ok=array();

	$member_id='';

	if (isset($_SESSION['job_position'])) {
		$job_position=$_SESSION['job_position'];
		//echo $job_position;
		if ($job_position=="admin" or $job_position=="assistant"){

		}else{
			header('Location:../index.php');
		}
	}else{
		header('Location:login.php?page=staff_profile');
	}
	
	if(isset($_GET['id'])){
		$staff_id=$_GET['id'];
	}elseif (isset($_SESSION['id'])) {
		$staff_id=$_SESSION['id'];
	}else{
		$error[]="didn't passed id details...";
	}

	

	$display_profile='';
	$display_transactions='';
	$get_book='';

	$privete_detail_query="SELECT id,f_name,l_name,address,mobile_number,e_mail,nic,job_position FROM staff WHERE id='{$staff_id}' LIMIT 1";

	$privete_detail=mysqli_query($admin_conn,$privete_detail_query);

	if ($privete_detail) {
		while($detail=mysqli_fetch_assoc($privete_detail)){
		    $id=$detail['id'];
		    $f_name=$detail['f_name'];
		    $l_name=$detail['l_name'];
		    $address=$detail['address'];
		    $mobile_number=$detail['mobile_number'];
		    $e_mail=$detail['e_mail'];
		    $nic=$detail['nic'];
		    $this_job_position=$detail['job_position'];
		    

			$display_profile.='<div class="profile">';
				$display_profile.='<h2>Personal details</h2>';
				$display_profile.='<div class="dprofile">';
					$display_profile.='<img src="../img/staff/profilepic/'.$id.'.jpg">';				
					if ($job_position=="admin") {
							$display_profile.='<br><button onclick="window.location.href = \'upload.php?id='.$id.'\'" style="padding:5px;">change profile picture</button>';
								$display_profile.='<br><input type=button style="padding:5px;" onClick="location.href=\'edit_staff.php?id='.$staff_id.'\'" value=\'edit profile\'></button>';
								$display_profile.='<br><input type=button style="padding:5px;" onClick="location.href=\'reset_password.php?id='.$staff_id.'\'" value=\'reset password\'></button>';
					}
					$display_profile.='<table id="list">';
						$display_profile.='<tr><td>staff id</td><td>'.$id.'</td></tr>';
						$display_profile.='<tr><td>first name</td><td>'.$f_name.'</td></tr>';
						$display_profile.='<tr><td>last name</td><td>'.$l_name.'</td></tr>';
						$display_profile.='<tr><td>address</td><td>'.$address.'</td></tr>';
						$display_profile.='<tr><td>mobile_number</td><td>'.$mobile_number.'</td></tr>';
						$display_profile.='<tr><td>e_mail</td><td>'.$e_mail.'</td></tr>';
						$display_profile.='<tr><td>nic</td><td>'.$nic.'</td></tr>';
						$display_profile.='<tr><td>job_position</td><td>'.$this_job_position.'</td></tr>';
						
					$display_profile.='</table>';
					$display_profile.='</div>';
			$display_profile.='</div>';
		}
	}
	
	

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>staff profile</title>
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

	?>

	<div class="includeone">
		<?php require_once('footer.php') ?>
	</div>
</body>
</html>