<?php session_start(); ?>
<?php require_once('../connection/conn.php'); ?>
<?php require_once('../connection/tempconn.php'); ?>
<?php require_once('external.php'); ?>

<?php
	$error=array();
	$lenth_error=array();
	$ok=array();
	$job_position='';
	$book_id='';

	if (isset($_SESSION['job_position'])) {
		$job_position=$_SESSION['job_position'];
	}else{
		//header('Location:login.php?page=book_profile');
	}
	
	if(isset($_GET['id'])){
		$book_id=$_GET['id'];
	}else{
		$error[]="didn't passed id details...";
	}

	if (isset($_POST['add_cart'])) {
		if (isset($_SESSION['id'])) {
			$user_id=$_SESSION['id'];

			$ability="SELECT book_id from cart where member_id='{$user_id}'";
			$rability=mysqli_query($member2_conn,$ability);
			if ($rability) {
				if (mysqli_num_rows($rability)>5) {
					echo'<script>';
					echo'alert("sorry. you already added 5 books to cart")';
					echo'</script>';
				}else{
					$due_date=date("Y-m-d",strtotime("+30 day"));
					$query="INSERT INTO cart(book_id,member_id,due_date) VALUES('{$book_id}','{$user_id}','{$due_date}')";
					$rquery=mysqli_query($member2_conn,$query);
					if ($rquery) {
						echo'<script>';
						echo'alert("added to cart.. your request will remove on 30days")';

						echo'</script>';
						
					}else{
						echo'<script>';
						echo'alert("can\'t add to cart")';
						echo'</script>';
					}
				}
			}
			echo '<script>';
			//echo'location.reload()';
			echo '</script>';
		}else{
			header('Location:login.php?page=book_profile&book_id={$book_id}');
		}
	}

	$display_profile='';
	$display_transactions='';
	//$get_book='';

	$privete_detail_query="SELECT id,name,category_number,writer,statu,printed_date,price,reference FROM book WHERE id='{$book_id}' LIMIT 1";
	$transactions_detail_query="SELECT member_id,book_id,issued_date,issued_by,due_date FROM transactions WHERE book_id='{$book_id}' and (return_date IS NULL or return_date='') limit 1";

	$privete_detail=mysqli_query($admin_conn,$privete_detail_query);
	$transactions_detail=mysqli_query($admin_conn,$transactions_detail_query);

	if ($privete_detail) {
		while($detail=mysqli_fetch_assoc($privete_detail)){
		    $id=$detail['id'];
		    $name=$detail['name'];
		    $category_number=$detail['category_number'];
		    $writer=$detail['writer'];
		    $statu=$detail['statu'];
		    $printed_date=$detail['printed_date'];
		    $price=$detail['price'];
		    $reference=$detail['reference'];
		   

			$display_profile.='<div class="profile">';
				$display_profile.='<h2>book details</h2>';
				$display_profile.='<div class="dprofile">';
									
					if ($job_position=="admin" or $job_position=="assistant") {
						$display_profile.='<br><input type=button style="padding:5px;" onClick="location.href=\'edit_book.php?id='.$book_id.'\'" value=\'edit book details\'></button><br>';
					}
					if (isset($_SESSION['id'])) {
						//$user_id=$_SESSION['id'];
						$display_profile.='<form action="book_profile.php?id='.$book_id.'" method="post">';
							$cart_detail="SELECT book_id from cart where book_id='{$book_id}'";
							$rcart_detail=mysqli_query($member2_conn,$cart_detail);
							if ($rcart_detail) {
								if (mysqli_num_rows($rcart_detail)>0) {
									$display_profile.='<br><button type="submit" name=""value=\'already in cart\'  style="padding:5px;">already in cart</button><br>';
								}else{
									$display_profile.='<br><button type="submit" name="add_cart" style="padding:5px;">add to cart</button><br>';
								}
							}
							
						$display_profile.="</form>";
					}
					$display_profile.='<table id="list">';
						$display_profile.='<tr><td>book id</td><td>'.$id.'</td></tr>';
						$display_profile.='<tr><td>name</td><td>'.$name.'</td></tr>';
						$display_profile.='<tr><td>category number</td><td>'.$category_number.'</td></tr>';
						$category_details="SELECT category_name FROM category WHERE category_number='{$category_number}'";
					    	$get_category_detail=mysqli_query($admin_conn,$category_details);
						    	$get_details=mysqli_fetch_assoc($get_category_detail);
						    	$display_profile.='<tr><td>category_name</td><td>'.$get_details['category_name'].'</td></tr>';
						
						$display_profile.='<tr><td>writer</td><td>'.$writer.'</td></tr>';
						$display_profile.='<tr><td>statu</td><td>'.$statu.'</td></tr>';
						$display_profile.='<tr><td>printed date</td><td>'.$printed_date.'</td></tr>';
						$display_profile.='<tr><td>price</td><td>'.$price.'</td></tr>';
						$display_profile.='<tr><td>is refernce</td><td>'.$reference.'</td></tr>';
						
					$display_profile.='</table>';
					$display_profile.='</div>';
			$display_profile.='</div>';
		}
	}
	if ($transactions_detail) {
		if (mysqli_num_rows($transactions_detail)==1) {
			$display_transactions.='<div class="trance">';
				$display_transactions.='<h2>book is not available</h2><br>';
				if ($job_position=="admin" or $job_position=="assistant"){
					$display_transactions.='<br><h2>transactions details</h2>';
						
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
							$display_transactions.='<tr><td>member id</td><td><a href="member_profile.php?id='.$member_id.'">'.$member_id.'</a></td></tr>';
							$display_transactions.='<tr><td>issued date</td><td>'.$issued_date.'</td></tr>';
						    $display_transactions.='<tr><td>issued by</td><td><a href="staff_profile.php?id='.$issued_by.'">'.$issued_by.'</a></td></tr>';
						    $display_transactions.='<tr><td>due date</td><td>'.$due_date.'</td></tr>';
						    $display_transactions.='<tr><td colspan="2">'.$diff->format("%R%a days").'</td></tr>';

					}
					$display_transactions.='</table>';
				}
			$display_transactions.='</div>';
		}else{
			$display_transactions.='<div class="trance">';
				$display_transactions.='<h2>book is available</h2>';
			$display_transactions.='</div>';
		}
	}
	
	

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>book details</title>
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