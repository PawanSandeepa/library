<?php  ?>
<?php require_once('../connection/conn.php'); ?>
<?php require_once('../php/external.php'); ?>
<?php 
	//$query="DELETE FROM cart where due_date<=CURDATE()";
	//$rquery=mysqli_query($admin_conn,$query);
?>
<?php
	$search='';
	$displaytop='<li><a href="../php/login.php">login</a></li>';
	if (isset($_SESSION['id'])) {
		$user_id=$_SESSION['id'];
		
		if (isset($_SESSION['l_name']) and isset($_SESSION['job_position'])) {
			$job_position=$_SESSION['job_position'];
			$last_name=$_SESSION['l_name'];
			if ($job_position=="assistant" or $job_position=="admin") {
				$displaytop='<li><a href="../php/staff_profile.php">'.$last_name.'</a></li>';
				$displaytop.='<li><a href="../php/staff_interface.php">work place</a></li>';
				$query="SELECT member_id,book_id,extend_type FROM extend_request";
				$rquery=mysqli_query($admin_conn,$query);
				if ($rquery) {
					if (mysqli_num_rows($rquery)>0) {
						$ncount=mysqli_num_rows($rquery);
						$displaytop.='<li><a href="../php/notification.php"><div class="blink">'.$ncount.' notification(s)</div></a></li>';
					}
				}
			}
			if ($job_position=="member") {
				$displaytop='<li><a href="../php/member_profile.php">'.$last_name.'</a></li>';
			}

			
		}
		$displaytop.='<li><a href="../php/cart.php">cart</a></li>';
		$displaytop.='<li><a href="../php/logout.php">logout</a></li>';
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
	<link rel="stylesheet" type="text/css" href="../css/main.css">
</head>
<body>
	<div class="wrapper">
		<div class="top-bar clearfix">
			<div class="top-bar-links">
				<ul>
					<li><a href="../index.php">Home</a></li>
					<li><a href="../php/category.php">catogory</a></li>
					<li><a href="#">about us</a></li>
					<?php echo $displaytop; ?>
				</ul>

			</div>
			<div class="top-bar-search">
				<form method="post" action="../index.php">
					<input class="search" type="text" placeholder="Search..." name="search" size="35" <?php echo 'value="'.$search.'"';?>>
					<button type="submit" name="submit"></button>
				</form>

			</div>
		</div>
	</div>
</body>
</html>