<?php require_once('../connection/conn.php'); ?>
<?php require_once('external.php'); ?>

<?php
	$error=array();
	$lenth_error=array();
	$ok=array();

	if (isset($_GET['id'])) {
		$id=$_GET['id'];
		$sha_password=sha1("12345");
		$subid=substr($id,0,2);
      	if($subid=='st'){
      		$change="UPDATE staff SET spassword='{$sha_password}' WHERE id='{$id}' LIMIT 1";
		}elseif($subid=='mb'){
			$change="UPDATE members SET mpassword='{$sha_password}' WHERE id='{$id}' LIMIT 1";
		}

		
		
		$result_change=mysqli_query($admin_conn,$change);
		if ($result_change) {
			$ok[]="password was reset";
		}

	}else{
		$error[]="didn't get member id";
	}


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>reset password</title>
	<link rel="stylesheet" type="text/css" href="../css/form.css">
</head>
<body>
	<div>
		<?php require_once('header.php'); ?>
		<?php require_once('banner.php'); ?>
	</div>
	<?php 
		print_error($error,$lenth_error);
		print_ok($ok);

	?>


	<div class="includeone">
		<?php require_once('footer.php') ?>
	</div>
</body>
</html>
<?php mysqli_close($admin_conn) ?>