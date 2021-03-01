<?php session_start(); ?>
<?php require_once('../connection/conn.php'); ?>
<?php require_once('external.php'); ?>


<?php 

	$error=array();
	$lenth_error=array();
	$ok=array();
	$msg=array();

	//echo "in php";

	$id='';
	$name='';
	$category_number='';
	$writer='';
	$statu='';
	$printed_date='';
	$price='';
	$reference='';

	if (isset($_GET['id'])) {
		$book_id=$_GET['id'];

	}else{
		
		echo '<script type="text/javascript">';
			echo 'alert("can\'t identifed book")';
		echo '</script>';
		//exit();
	}

	$get_detail="SELECT id,name,category_number,writer,statu,printed_date,price,reference FROM deleted_book WHERE id='{$book_id}' limit 1";
	$result_get_detail=mysqli_query($admin_conn,$get_detail);
	while ($detail=mysqli_fetch_assoc($result_get_detail)) {
		$id=$detail['id'];
		$name=$detail['name'];
		$category_number=$detail['category_number'];
		$writer=$detail['writer'];
		$statu=$detail['statu'];
		$printed_date=$detail['printed_date'];
		$price=$detail['price'];
		$reference=$detail['reference'];

	}

	if(isset($_POST['submit'])){


		//check empty fild......

		$req_field = array('name','category_number','statu','price');


		$error=array_merge($error, check_empty($req_field));

		//check lenth ..........

		$max_length = array('name'=>50,'category_number'=>15,'writer'=>50,'statu'=>15,'printed_date'=>10);

		$lenth_error=array_merge($lenth_error, check_length($max_length));


		$id=mysqli_real_escape_string($admin_conn,$_POST['id']);
		$name=mysqli_real_escape_string($admin_conn,$_POST['name']);
		$category_number=mysqli_real_escape_string($admin_conn,$_POST['category_number']);
		$writer=mysqli_real_escape_string($admin_conn,$_POST['writer']);
		$statu=mysqli_real_escape_string($admin_conn,$_POST['statu']);
		$printed_date=mysqli_real_escape_string($admin_conn,$_POST['printed_date']);
		$price=mysqli_real_escape_string($admin_conn,$_POST['price']);
		$reference=mysqli_real_escape_string($admin_conn,$_POST['reference']);

		$check_id="select id from book where id='{$id}'";

		$check_id_result=mysqli_query($admin_conn,$check_id);

		if ($check_id_result) {
			if (mysqli_num_rows($check_id_result)>=1) {
				$error[]='id is already exixts';
			}
		}
		//echo "no error";
		if(empty($error) && empty($lenth_error)){
			//echo "doing code";
			$query="INSERT INTO book";
			$query.="(id,name,category_number,writer,statu,printed_date,price,reference)";
			$query.="VALUES('{$id}','{$name}','{$category_number}','{$writer}','{$statu}','{$printed_date}','{$price}','{$reference}')";

			$add_trance="INSERT INTO transactions(book_id) VALUES('{$id}')";
			$add_survey="INSERT INTO survey_book(id,model,state) VALUES('{$id}','{$statu}','here')";

			$add_trance_result=mysqli_query($admin_conn,$add_trance);
			$add_survey_result=mysqli_query($admin_conn,$add_survey);
			$query_result=mysqli_query($admin_conn,$query);

			if($query_result AND $add_trance_result AND $add_survey_result){

				$delete_recode="DELETE FROM deleted_book WHERE id='{$id}' limit 1";
						$rdelete_recode=mysqli_query($admin_conn,$delete_recode);
						if ($rdelete_recode) {
							$ok[]="recodes added..";
							//echo"recodes added..<br>";

							$id='';
							$name='';
							$category_number='';
							$writer='';
							$statu='';
							$printed_date='';
							$price='';
							$reference='';
							
							header('Location:book_list.php?recode was added');
						}
			}else{
				$error[]="recodes aren't added";
			}
		}//without error...

	}//submit..............


?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>add deleted book</title>
	<link rel="stylesheet" type="text/css" href="../css/form.css">
</head>
<body>
	<div>
		<?php require_once('header.php'); ?>
		<?php require_once('banner.php'); ?>
	</div>

	<div class="register" style="background-color: white">
		<form action="add_deleted_book.php" method="post">
			<fieldset>
				<legend><h1>add deleted book form</h1></legend>
				
					<!--print error masseges...-->
					<?php 
						print_error($error,$lenth_error);
						print_ok($ok);
						foreach ($msg as $display) {
							echo $display."<br>";
						}
						

					?>
				
				
				<p><label>book id</label><input class="txt" type="text" name="id" <?php echo 'value="'.$id.'"';?>></p>
				<p><label>name</label><input class="txt" type="text" name="name" <?php echo 'value="'.$name.'"';?>></p>
				<p><label>category_number</label><input class="txt" type="text" name="category_number" <?php echo 'value="'.$category_number.'"';?>></p>
				<p><label>writer</label><input class="txt" type="text" name="writer" <?php echo 'value="'.$writer.'"';?>></p>
				<p><label>statu</label>
					<select name="statu">
						<option value="book" <?php if($detail['statu'] == 'book'): ?> selected="selected"<?php endif; ?>>book</option>
						<option value="news_paper"  <?php if($detail['statu'] == 'news_paper'): ?> selected="selected"<?php endif; ?>>news_paper</option>
						<option value="cd"  <?php if($detail['statu'] == 'cd'): ?> selected="selected"<?php endif; ?>>cd</option>
					</select>
				<p><label>printed_date</label><input class="txt" type="text" name="printed_date" <?php echo 'value="'.$printed_date.'"';?>></p>
				<p><label>price</label><input class="txt" type="text" name="price" <?php echo 'value="'.$price.'"';?>></p>
				<p><label>Is it reference book</label>
					<select name="reference">
						<option value="no" <?php if($detail['reference'] == 'no'): ?> selected="selected"<?php endif; ?>>no</option>
						<option value="yes" <?php if($detail['reference'] == 'yes'): ?> selected="selected"<?php endif; ?>>yes</option>
					</select>
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


