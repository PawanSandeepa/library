<?php session_start(); ?>
<?php require_once('../connection/conn.php'); ?>
<?php require_once('../php/external.php'); ?>


<?php 

	$error=array();
	$lenth_error=array();
	$ok=array();
	//echo "in php";

	$id='';

	if (isset($_SESSION['job_position']) and isset($_SESSION['id'])) {
		//echo $_SESSION['job_position'];
		if ($_SESSION['job_position']=="assistant" or $_SESSION['job_position']=="admin" ){
			
		}else{
			header('Location:../php/login.php?you_can_not_access');
		}
	}else{
		header('Location:../php/login.php?you_can_not_access');
	}

	if(isset($_POST['submit'])){

		//check empty fild......

		$req_field = array('id');
		$error=array_merge($error, check_empty($req_field));

		//check lenth ..........

		$max_length = array('id'=>7);
		$lenth_error=array_merge($lenth_error, check_length($max_length));

		//get detail from html form...
		$id=mysqli_real_escape_string($admin_conn,$_POST['id']);
	
		//check have id in survey book table...
		$check_id="select id from survey_book where id='{$id}'";
		$check_id_result=mysqli_query($admin_conn,$check_id);

		if ($check_id_result) {
			if (mysqli_num_rows($check_id_result)!=1) {
				$error[]='id haven\'t in the surver book table';
			}
		}

		if(empty($error) && empty($lenth_error)){
			//echo "doing code";
			$query="UPDATE survey_book SET ";
			$query.="state='missing' ";
			$query.="WHERE id='{$id}' LIMIT 1";

			$query_result=mysqli_query($admin_conn,$query);

			if($query_result){

				$ok[]="removed recode..";

				$id='';

				//$error[]="recode was remove";
				//header('Location:remove_book_servey.php?recode was remove');
			}else{
				$error[]="recodes aren't remove";
			}
		}//without error...

	}//submit..............


?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>remove book survey</title>
	<link rel="stylesheet" type="text/css" href="../css/form.css">
</head>
<body>
	<div>
		<?php require_once('header.php'); ?>
		<?php require_once('banner.php'); ?>
	</div>
	
	<div class="register" style="background-color: white">
		<form action="remove_book_survey.php" method="post">
			<fieldset>
				<legend><h1>remove book for survey</h1></legend>
				
					<!--print error masseges...-->
					<?php 
						print_error($error,$lenth_error);
						print_ok($ok);

					?>
				
				
				<p><label>book id</label><input class="txt" type="text" name="id" <?php echo 'value="'.$id.'"';?>></p>
				
				<p><label>&nbsp;</label><button class="add" type="submit" name="submit">remove</button></p>

			</fieldset>
		</form>
	</div><!--register div-->
	<div class="includeone">
		<?php require_once('footer.php') ?>
	</div>
</body>
</html>
<?php mysqli_close($admin_conn) ?>


