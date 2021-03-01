<?php session_start(); ?>
<?php require_once('../connection/conn.php'); ?>
<?php require_once('../connection/tempconn.php'); ?>
<?php require_once('external.php'); ?>

<?php
	$error=array();
	$lenth_error=array();
	$ok=array();

	$job_position='';

	if(isset($_SESSION['job_position'])){
		$job_position=$_SESSION['job_position'];
	}

	$list='';

	//geting the list of notification...
	$query="SELECT member_id,book_id FROM extend_request WHERE extend_type='book_due_date'";

	if ($job_position=="admin" or $job_position=="assistant") {
		$rquery=mysqli_query($admin_conn,$query);
		if($rquery){
			$list_count=mysqli_num_rows($rquery);
			
			$list.="<h1>Extend Due Date of Books ({$list_count})</h1>";
			$list.="<table class=\"userlist\">";
				$list.="<tr><th>member id</th><th>book id</th><th>reject</th><th>aprove</th></tr>";
				while($detail=mysqli_fetch_assoc($rquery)){
					
					$list.="<tr>";
					$list.="<td><a href=\"member_profile.php?id={$detail['member_id']}\">{$detail['member_id']}</td>";
					$list.="<td><a href=\"book_profile.php?id={$detail['book_id']}\">{$detail['book_id']}</td>";
					$list.="<form action=\"notification.php\" method=\"get\">";
						$list.="<input type=\"hidden\" name=\"action\" value=\"aprove\">";
						$list.="<input type=\"hidden\" name=\"member_id\" value=\"".$detail['member_id']."\">";
						$list.="<input type=\"hidden\" name=\"book_id\" value=\"".$detail['book_id']."\">";
						$list.="<td><button class=\"add\" type=\"submit\">aprove</button></a></td>";
					$list.="</form>";
					$list.="<form action=\"notification.php\" method=\"get\">";
						$list.="<input type=\"hidden\" name=\"action\" value=\"reject\">";
						$list.="<input type=\"hidden\" name=\"member_id\" value=\"".$detail['member_id']."\">";
						$list.="<input type=\"hidden\" name=\"book_id\" value=\"".$detail['book_id']."\">";
						$list.="<td><button class=\"add\" type=\"submit\">reject</button></td>";
					$list.="</form>";
					$list.="</tr>";
				}
			$list.="</table>";
		}else{
			$error[]="can't get notification details";
		}
	}

	if (isset($_GET['action']) and isset($_GET['member_id']) and isset($_GET['book_id'])) {
		$member_id=$_GET['member_id'];
		$book_id=$_GET['book_id'];

		//echo "in get";
		if ($_GET['action']=="aprove") {
			//aprove code for request...
			//echo "in aprove";
			$query="SELECT due_date from transactions where book_id='{$book_id}' and member_id='{$member_id}' limit 1";
			$rquery=mysqli_query($admin_conn,$query);
			if ($rquery) {
				$old=mysqli_fetch_assoc($rquery);
				$old_date=$old['due_date'];
				//echo $old_date;
				$new=date('Y-m-d',strtotime($old_date."+14 days"));
				//echo $new;
				$query="UPDATE transactions SET due_date='{$new}' where book_id='{$book_id}' and member_id='{$member_id}' limit 1";
				mysqli_query($admin_conn,$query);
			}
		}
		$query="DELETE FROM extend_request where extend_type='book_due_date' and member_id='{$member_id}' and book_id='{$book_id}' limit 1";
		mysqli_query($admin_conn,$query);
		header('Location:notification.php');
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>notification</title>
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