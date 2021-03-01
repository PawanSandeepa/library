<?php session_start(); ?>
<?php require_once('../connection/conn.php'); ?>
<?php require_once('../connection/tempconn.php'); ?>
<?php require_once('external.php'); ?>

<?php
	$user_id='';
	$display='';
	$id='';

	if (isset($_SESSION['id'])) {
		$user_id=$_SESSION['id'];
	}else{
		header('loging.php?page=cart');
	}

	

	$get="SELECT book_id,member_id,due_date from cart where member_id='{$user_id}'";
	$get_result=mysqli_query($member2_conn,$get);
	$display.='<div class="container">';
		while($detail=mysqli_fetch_assoc($get_result)){
			$display.='<div class="card">';
				$display.='<div class="cart">';
					$display.='<div class="content1">';
						$id=$detail['book_id'];
						$display.='<a href="book_profile.php?id='.$id.'">';
						//put the img link....
						$display.='<img src="../img/profile_book.png">';
					    $display.='<h3><b>Book Id : '.$id.'</b></h3></a>';
					    //$display.='<h3><b>name : '.$detail['member_id'].'</b></h3>';
					    $display.='<p>Request Expire Date : '.$detail['due_date'].'</p>';
					    $display.='<form action="cart.php" method="post">';
					    	$display.='<button class="logadd" type="submit" name="remove" style="padding:5px;" onclick="return confirm(\'are you sure do you want to remove\');">Remove from cart</button>';
					    	$display.='<input type="hidden" name="id" <?php echo value="'.$id.'";?>';
					    $display.='</form>';
			   		$display.='</div>';
				$display.='</div>';
			$display.='</div>';
		}
	$display.='</div>';
	//echo $id.'down';

	if (isset($_POST['remove'])) {

		$remove_id=mysqli_real_escape_string($member2_conn,$_POST['id']);
		//echo $remove_id;
		$query="DELETE FROM cart WHERE book_id='{$remove_id}' limit 1";
		$rquery=mysqli_query($member2_conn,$query);
		if ($rquery) {
			echo '<script type="text/javascript">';
				echo 'alert("removed item from cart")';
			echo '</script>';
		}
		header('Location:cart.php');
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>cart</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
	<div>
		<?php require_once('header.php'); ?>
		<?php require_once('banner.php'); ?>
	</div>
	<?php echo $display; ?>
	<div class="includeone">
		<?php require_once('footer.php') ?>
	</div>
</body>
</html>