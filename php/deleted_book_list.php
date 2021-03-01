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

	//deleted book list..........
	$dlist='';
	$dlisth='';
	if ($job_position=="admin") {
		//geting the dlist of books...
		$query="SELECT id,name,category_number,writer,statu,printed_date,price,reference,deleted_date FROM deleted_book ORDER BY deleted_date";
		$rquery=mysqli_query($admin_conn,$query);
		
		if($rquery){
			$dlist_count=mysqli_num_rows($rquery);
			$dlisth="<h1>deleted book list ({$dlist_count})</h1>";
			$dlisth.="<table class=\"userlist\">";
				$dlisth.="<tr><th>id</th><th>name</th><th>category number</th><th>writer</th><th>statu</th><th>printed date</th><th>price</th><th>reference</th><th>date of deleted</th><th>edit</th><th>add</th><th>clear</th></tr>";
				$dlist="<tr><td colspan=\"10\">nothing books</td></tr>";
				while($detail=mysqli_fetch_assoc($rquery)){
					
					$dlist="<tr>";
					$dlist.="<td>{$detail['id']}</td>";
					$dlist.="<td>{$detail['name']}</td>";
					$dlist.="<td>{$detail['category_number']}</td>";
					$dlist.="<td>{$detail['writer']}</td>";
					$dlist.="<td>{$detail['statu']}</td>";
					$dlist.="<td>{$detail['printed_date']}</td>";
					$dlist.="<td>{$detail['price']}</td>";
					$dlist.="<td>{$detail['reference']}</td>";
					$dlist.="<td>{$detail['deleted_date']}</td>";
					$dlist.="<td><a href=\"edit_book.php?id={$detail['id']}\">edit</a></td>";
					$dlist.="<td><a href=\"add_deleted_book.php?id={$detail['id']}\" onclick=\"return confirm('are you sure do you want to add this book');\">add</a></td>";
					$dlist.="<form action='deleted_book_list.php' method='post'>";
						$dlist.="<input type=\"hidden\" name=\"id\" value=\"".$detail['id']."\">";
						$dlist.="<td><button type=\"submit\" onclick=\"return confirm('are you sure do you want to clear this book details. \\nany recodes will remove after this clear about this book');\" name=\"clear\">clear</td>";
					$dlist.="</form>";
					$dlist.="</tr>";
				}
			$dlist.="</table>";
		}else{
			$error[]="can't get deleted book details";
		}
	}else{
		$error[]="you can't access this page";
	}

	if (isset($_POST['clear'])) {
		$id='';
		$id=mysqli_real_escape_string($admin_conn,$_POST['id']);
		//echo "in clear".$id;
		$query="DELETE FROM deleted_book where id='{$id}' limit 1";
		$rquery=mysqli_query($admin_conn,$query);
		if ($rquery) {
			echo '<script type="text/javascript">';
				echo 'alert(book was deleted)';
			echo '</script>';
		}
	}
		

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>deleted book list</title>
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

		<?php echo $dlisth; ?>
		<?php echo $dlist; ?>

		
	</main>
	<div class="includeone">
		<?php require_once('footer.php') ?>
	</div>
</body>
</html>