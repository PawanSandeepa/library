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

	//geting the list of books...
	$query="SELECT id,name,category_number,writer,statu,printed_date,price,reference FROM book ORDER BY category_number";

			if ($job_position=="admin" or $job_position=="assistant") {
				$rquery=mysqli_query($admin_conn,$query);

				if($rquery){
					$list_count=mysqli_num_rows($rquery);
					//echo $list_count;
					$list.="<h1>book list ({$list_count})</h1>";
					$list.="<table class=\"userlist\">";
					$list.="<tr><th>id</th><th>name</th><th>category number</th><th>category name</th><th>writer</th><th>statu</th><th>printed date</th><th>price</th><th>reference</th><th>edit</th><th>delete</th></tr>";
					while($detail=mysqli_fetch_assoc($rquery)){
						
						$list.="<tr>";
						$list.="<td>{$detail['id']}</td>";
						$list.="<td>{$detail['name']}</td>";
						$list.="<td>{$detail['category_number']}</td>";
						$get_category="SELECT category_name from category where category_number='{$detail['category_number']}'";
						$rget_category=mysqli_query($admin_conn,$get_category);
						$category_detail=mysqli_fetch_assoc($rget_category);
						$list.="<td>{$category_detail['category_name']}</td>";
						$list.="<td>{$detail['writer']}</td>";
						$list.="<td>{$detail['statu']}</td>";
						$list.="<td>{$detail['printed_date']}</td>";
						$list.="<td>{$detail['price']}</td>";
						$list.="<td>{$detail['reference']}</td>";
						$list.="<td><a href=\"edit_book.php?id={$detail['id']}\">edit</a></td>";
						$list.="<td><a href=\"delete_book.php?id={$detail['id']}\" onclick=\"return confirm('are you sure do you want to delete');\">delete</td>";
						$list.="</tr>";
					}
				}else{
					$error[]="can't get book details";
				}

			}else{
				$rquery=mysqli_query($member1_conn,$query);
				if($rquery){
					$list_count=mysqli_num_rows($rquery);
					$list.="<h1>book list ({$list_count})</h1>";
					$list.="<table class=\"userlist\">";
					$list.="<tr><th>id</th><th>name</th><th>category number</th><th>category name</th><th>writer</th><th>statu</th><th>printed date</th><th>price</th><th>reference</th></tr>";
					while($detail=mysqli_fetch_assoc($rquery)){
						
						$list.="<tr>";
						$list.="<td>{$detail['id']}</td>";
						$list.="<td>{$detail['name']}</td>";
						$list.="<td>{$detail['category_number']}</td>";
						$get_category="SELECT category_name from category where category_number='{$detail['category_number']}'";
						$rget_category=mysqli_query($member1_conn,$get_category);
						$category_detail=mysqli_fetch_assoc($rget_category);
						$list.="<td>{$category_detail['category_name']}</td>";
						$list.="<td>{$detail['writer']}</td>";
						$list.="<td>{$detail['statu']}</td>";
						$list.="<td>{$detail['printed_date']}</td>";
						$list.="<td>{$detail['price']}</td>";
						$list.="<td>{$detail['reference']}</td>";
						$list.="</tr>";

					}
				}else{
					$error[]="can't get book details";
				}
			}
		$list.="</table>";


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>book list</title>
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