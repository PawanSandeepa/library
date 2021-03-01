<?php session_start(); ?>
<?php require_once('../connection/conn.php'); ?>
<?php require_once('external.php'); ?>

<?php
	$error=array();
	$lenth_error=array();
	$ok=array();

	$job_position='';

	if(isset($_SESSION['job_position'])){
		$job_position=$_SESSION['job_position'];
		if ($job_position=="admin") {
			
		}else{
			header('Location:staff_interface?you can\'t access that page');
		}
	}

	$list='';

	//geting the list of books...
	$query="SELECT id,f_name,l_name,address,mobile_number,e_mail,job_position FROM staff ORDER BY f_name";

			if ($job_position=="admin") {
				$rquery=mysqli_query($admin_conn,$query);

				if($rquery){
					$list_count=mysqli_num_rows($rquery);
					//echo $list_count;
					$list.="<h1>Staff list ({$list_count})</h1>";
					$list.="<table class=\"userlist\">";
						$list.="<tr><th>id</th><th>first name</th><th>last name</th><th>address</th><th>mobile number</th><th>email</th><th>job position</th><th>edit</th></tr>";
						while($detail=mysqli_fetch_assoc($rquery)){
							
							$list.="<tr>";
							$list.="<td>{$detail['id']}</td>";
							$list.="<td>{$detail['f_name']}</td>";
							$list.="<td>{$detail['l_name']}</td>";
							$list.="<td>{$detail['address']}</td>";
							$list.="<td>{$detail['mobile_number']}</td>";
							$list.="<td>{$detail['e_mail']}</td>";
							$list.="<td>{$detail['job_position']}</td>";
							$list.="<td><a href=\"edit_staff.php?id={$detail['id']}\">edit</a></td>";
							$list.="</tr>";
						}
					$list.="</table>";
				}else{
					$error[]="can't get book details";
				}

			}
		



?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>member list</title>
	<link rel="stylesheet" href="../css/list.css">
</head>
<body>
	<div>
		<?php require_once('header.php'); ?>
		<?php require_once('banner.php'); ?>
	</div>
	<main>
		<?php 
			print_error($error,$lenth_error);					
			print_ok($ok);
		?>
			
		<?php echo $list; ?>

		
	</main>
	<div class="includeone">
		<?php require_once('footer.php') ?>
	</div>
</body>
</html>