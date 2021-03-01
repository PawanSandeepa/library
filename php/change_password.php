<?php session_start(); ?>
<?php require_once('../connection/conn.php'); ?>
<?php require_once('external.php'); ?>

<?php
	$error=array();
	$lenth_error=array();
	$ok=array();

	$new_password='';
	$re_enter_password='';
	$old_password='';

	if (isset($_SESSION['id']) && isset($_SESSION['l_name']) && isset($_SESSION['job_position'])) {
		$user_id=$_SESSION['id'];
		$l_name=$_SESSION['l_name'];
		$job_position=$_SESSION['job_position'];

		if (isset($_POST['submit'])) {
			$req_field = array('new_password','re_enter_password','old_password');
			$error=array_merge($error, check_empty($req_field));

			$new_password=mysqli_real_escape_string($admin_conn,$_POST['new_password']);
			$re_enter_password=mysqli_real_escape_string($admin_conn,$_POST['re_enter_password']);
			$old_password=mysqli_real_escape_string($admin_conn,$_POST['old_password']);
			$sha_old_password=sha1($old_password);
			if(empty($error) && empty($lenth_error)){
				if ($new_password==$re_enter_password) {
					$sha_new_password=sha1($new_password);
					if ($job_position=="admin" or $job_position=="assistant") {
						$query="SELECT spassword from staff where id='{$user_id}' limit 1";
						$result_query=mysqli_query($admin_conn,$query);
						if (mysqli_num_rows($result_query)==1) {
							while ($detail=mysqli_fetch_assoc($result_query)) {
								$password=$detail['spassword'];
							}
							if ($sha_old_password==$password) {
								$change="UPDATE staff SET spassword='{$sha_new_password}' WHERE id='{$user_id}' LIMIT 1";
								$result_change=mysqli_query($admin_conn,$change);
								if ($result_change) {
									$ok[]="password was changed";
								}else{
									$error[]="didn't change password";
								}
							}else{
								$error[]="wrong old password";
							}

						}
					}elseif($job_position=="member"){
						$query="SELECT mpassword from members where id='{$user_id}' limit 1";
						$result_query=mysqli_query($admin_conn,$query);
						if (mysqli_num_rows($result_query)==1) {
							while ($detail=mysqli_fetch_assoc($result_query)) {
								$password=$detail['mpassword'];
							}
							if ($sha_old_password==$password) {
								$change="UPDATE members SET mpassword='{$sha_new_password}' WHERE id='{$user_id}' LIMIT 1";
								$result_change=mysqli_query($admin_conn,$change);
								if ($result_change) {
									$ok[]="password was changed";
									$new_password='';
									$re_enter_password='';
									$old_password='';
								}else{
									$error[]="didn't change password";
								}
							}else{
								$error[]="wrong old password";
							}

						}
					}else{
						header('Location:login.php?page=change_password');
					}
				}else{
					$error[]="not match new password and old password";
				}
			}//error
		}//submit
	}else{
		header('Location:login.php?page=change_password');
	}


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>change password</title>
	<link rel="stylesheet" type="text/css" href="../css/form.css">
</head>
<body>
	<div>
		<?php require_once('header.php'); ?>
		<?php require_once('banner.php'); ?>
	</div>
	
	<div class="register" style="background-color: white">
		<form action="change_password.php" method="post">
			<fieldset>
				<legend><h1>Change Password</h1></legend>
				
					<!--print error masseges...-->
					<?php 
						print_error($error,$lenth_error);
						print_ok($ok);

					?>
				
				
				<p><label>New password</label><input class="txt" type="text" name="new_password" <?php echo 'value="'.$new_password.'"';?>></p>
				<p><label>Re enter</label><input class="txt" type="text" name="re_enter_password" <?php echo 'value="'.$re_enter_password.'"';?>></p>
				<p><label>Old password</label><input class="txt" type="text" name="old_password" <?php echo 'value="'.$old_password.'"';?>></p>
				
				<p><label>&nbsp;</label><button class="add" type="submit" name="submit">change</button></p>

			</fieldset>
		</form>
	</div><!--register div-->
	<div class="includeone">
		<?php require_once('footer.php') ?>
	</div>
</body>
</html>
<?php mysqli_close($admin_conn) ?>