<?php session_start(); ?>
<?php require_once('../connection/conn.php'); ?>
<?php require_once('../php/external.php'); ?>


<?php 

	$error=array();
	$lenth_error=array();
	$ok=array();
	//echo "in php";

	$id='';
	$description='';
	$state='';

	if (isset($_GET['id'])) {
		$id=$_GET['id'];
	}

	if (isset($_SESSION['job_position']) and isset($_SESSION['id'])) {
		//echo $_SESSION['job_position'];
		if ($_SESSION['job_position']=="assistant" or $_SESSION['job_position']=="admin" ){
			
		}else{
			header('Location:../php/login.php?you_can_not_access');
		}
	}else{
		header('Location:../php/login.php?you_can_not_access');
	}

	$query="SELECT description,state FROM survey_book where id='{$id}'";
	$rquery=mysqli_query($admin_conn,$query);
	$detail=mysqli_fetch_assoc($rquery);
	$description=$detail['description'];
	$state=$detail['state'];

	$query="SELECT book_id from transactions where book_id='{$id}' and return_date IS NULL";
	$rquery=mysqli_query($admin_conn,$query);
	if ($rquery) {
		if (mysqli_num_rows($rquery)>0) {
			$state='transaction';
		}
	}
	
	//$state="here";
	if(isset($_POST['submit'])){

		//check empty fild......

		//$req_field = array('description');
		//$error=array_merge($error, check_empty($req_field));

		//check lenth ..........

		$max_length = array('description'=>50);
		$lenth_error=array_merge($lenth_error, check_length($max_length));

		//get detail from html form...
		$id=mysqli_real_escape_string($admin_conn,$_POST['id']);
		$description=mysqli_real_escape_string($admin_conn,$_POST['description']);
		$state=mysqli_real_escape_string($admin_conn,$_POST['state']);
	
		//echo $id.$description.$state;

		if(empty($error) && empty($lenth_error)){
			//echo "doing code";
			$query="UPDATE survey_book SET state='{$state}',description='{$description}' WHERE id='{$id}' limit 1";
			//$query.="state='{$state}',description='{$description}'";
			//$query.="WHERE id='{$id}' limit 1";

			$query_result=mysqli_query($admin_conn,$query);

			if($query_result){

				$ok[]="edited recodes..";

				$id='';

				header('Location:current_input.php?recode was added');
			}else{
				$error[]="recodes aren't edit";
			}
		}//without error...

	}//submit..............


?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>edit book survey</title>
	<link rel="stylesheet" type="text/css" href="../css/form.css">
</head>
<body>
	<div>
		<?php require_once('header.php'); ?>
		<?php require_once('banner.php'); ?>
	</div>
	
	<div class="register" style="background-color: white">
		<form action="edit_survey.php" method="post">
			<fieldset>
				<legend><h1>edit book in survey</h1></legend>
				
					<!--print error masseges...-->
					<?php 
						print_error($error,$lenth_error);
						print_ok($ok);

					?>
				
				
				<p><label>book id</label><input class="txt" type="text" name="id" <?php echo 'value="'.$id.'"';?> disabled></p>
				<input class="txt" type="hidden" name="id" <?php echo 'value="'.$id.'"';?>>
				<p><label>statu</label>
					<select name="state">
						<option value="missing" <?php if($state == 'missing'): ?> selected="selected"<?php endif; ?>>missing</option>
						<option value="here" <?php if($state == 'here'): ?> selected="selected"<?php endif; ?>>here</option>
						<option value="transaction" <?php if($state == 'transaction'): ?> selected="selected"<?php endif; ?>>transaction</option>
					</select>
				</p>
				<p><label>edit description</label><input class="txt" type="text" name="description" <?php echo 'value="'.$description.'"';?>></p>
				<p><label>&nbsp;</label><button class="add" type="submit" name="submit">edit</button></p>

			</fieldset>
		</form>
	</div><!--register div-->
	<div class="includeone">
		<?php require_once('footer.php') ?>
	</div>
</body>
</html>
<?php mysqli_close($admin_conn) ?>


