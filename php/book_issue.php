<?php session_start(); ?>
<?php require_once('../connection/conn.php'); ?>
<?php require_once('external.php'); ?>


<?php 

	$error=array();
	$lenth_error=array();
	$ok=array();
	//echo "in php";


	$member_id='';
	$book_id='';
	$issued_date=date('Y-m-d');
	$issued_by='';
	$due_date='';
	$user_id='';

	if (isset($_SESSION['id'])) {
		$user_id=$_SESSION['id'];
		//echo $user_id;
		
	}else{
		//echo $_SESSION['id'];
		header('Location:login.php?page=book_issue');
	}
	
	$issued_by=$_SESSION['id'];
	if(isset($_POST['submit'])){


		
		//echo $issued_by;
		//check empty fild......

		$req_field = array('member_id','book_id','due_date');


		$error=array_merge($error, check_empty($req_field));

		//check lenth ..........

		$max_length = array('member_id'=>7,'book_id'=>50);

		$lenth_error=array_merge($lenth_error, check_length($max_length));

		$member_id=mysqli_real_escape_string($admin_conn,$_POST['member_id']);
		$book_id=mysqli_real_escape_string($admin_conn,$_POST['book_id']);
		//$issued_date=mysqli_real_escape_string($admin_conn,$_POST['issued_date']);
		//$issued_by=mysqli_real_escape_string($admin_conn,$_POST['issued_by']);
		$due_date=mysqli_real_escape_string($admin_conn,$_POST['due_date']);

		$error=array_merge($error, check_member($admin_conn,$member_id));
		$error=array_merge($error, check_book($admin_conn,$book_id));

		if(empty($error)){
			$book_detail="SELECT id,name,reference from book where id='{$book_id}' limit 1";
			$result_book_detail=mysqli_query($admin_conn,$book_detail);
			while($detail=mysqli_fetch_assoc($result_book_detail)){
	              $id=$detail['id'];
	              $name=$detail['name'];
	              $reference=$detail['reference'];
	        }

	        if ($reference=="yes") {
	        	$error[]='this book is reference one. can not issue this book';
	        }


//			$check_id="SELECT member_id from transactions where member_id='{$member_id}' and book_id='{$book_id}' and issued_date='{$issued_date}'";
			$get_book_detail="SELECT book_id from transactions where book_id='{$book_id}' and return_date IS NULL";
			$get_member_detail="SELECT member_id from transactions where member_id='{$member_id}' and (return_date IS NULL or return_date = 'UNKNOWN')";

//			$check_id_result=mysqli_query($admin_conn,$check_id);
			$check_get_book_detail=mysqli_query($admin_conn,$get_book_detail);
			$check_get_member_detail=mysqli_query($admin_conn,$get_member_detail);
/*
			if ($check_id_result) {
				if (mysqli_num_rows($check_id_result)>=1) {
					$error[]='can not do this transaction <br> becouse this person took this book today also';
				}
			}*/
			if ($check_get_member_detail) {
				if (mysqli_num_rows($check_get_member_detail)>1) {
					$error[]='can not do this transaction <br> becouse this person already took two books';
				}
			}
			if ($check_get_book_detail) {
				if (mysqli_num_rows($check_get_book_detail)>=1) {
					$error[]='can not do this transaction <br> becouse this book was already issued';
				}
			}
		}

		if(empty($error) && empty($lenth_error)){
			//echo "doing code";
			$query="UPDATE transactions SET member_id='{$member_id}',issued_date='{$issued_date}',issued_by='{$issued_by}',due_date='{$due_date}',return_date=NULL,return_to=NULL WHERE book_id='{$book_id}' limit 1";
			$survey="UPDATE survey_book SET state='transaction',description='member id: {$member_id}, issued date: {$issued_date}, due date: {$due_date}' WHERE id='{$book_id}' limit 1";
			$survey_result=mysqli_query($admin_conn,$survey);
			$query_result=mysqli_query($admin_conn,$query);

			if($query_result and $survey_result){

				$ok[]="added recodes..";

				$member_id='';
				$book_id='';
				$issued_date='';
				$issued_by='';
				$due_date='';


				//header('Location :register_members.php?recode was added');
			}else{
				$error[]='recodes aren\'t added';
			}
		}//without error...

	}//submit..............


?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>book issue</title>
	<link rel="stylesheet" type="text/css" href="../css/form.css">
</head>
<body>
	<div>
		<?php require_once('header.php'); ?>
		<?php require_once('banner.php'); ?>
	</div>

	<div class="register" style="background-color: white">
		<form action="book_issue.php" method="post">
			<fieldset>
				<legend><h1>book transaction form</h1></legend>
				
					<!--print error masseges...-->
					<?php 
						print_error($error,$lenth_error);
						print_ok($ok);

					?>
				
				
				<p><label>member_id</label><input class="txt" type="text" name="member_id" <?php echo 'value="'.$member_id.'"';?>></p>
				<p><label>book_id</label><input class="txt" type="text" name="book_id" <?php echo 'value="'.$book_id.'"';?>></p>
				<p><label>issued_date</label><input class="txt" type="text" name="issued_date" value="<?php echo date('Y-m-d');?>" disabled></p>
				<p><label>issued_by</label><input class="txt" type="text" name="issued_by" value="<?php echo $user_id; ?>" disabled></p>
				<p><label>due_date</label><input class="txt" type="text" name="due_date" value="<?php echo date("Y-m-d",strtotime("+14 day")) ?>"<?php echo 'value="'.$due_date.'"';?>></p>

				<p><label>&nbsp;</label><button class="add" type="submit" name="submit">add</button></p>

			</fieldset>
		</form>
	</div><!--register div-->
	<div class="includeone">
		<?php require_once('footer.php') ?>
	</div>
</body>
</html>
<?php mysqli_close($admin_conn) ?>


<?php //echo 'value="'.$issued_by.'"';?>
<?php //echo 'value="'.$issued_date.'"';?>