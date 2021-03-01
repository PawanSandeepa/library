<?php session_start(); ?>
<?php require_once('../connection/conn.php'); ?>
<?php require_once('external.php'); ?>


<?php 

	$error=array();
	$lenth_error=array();
	$ok=array();
	$msg=array();
	//echo "in php";


	$member_id='';
	$book_id='';
	//$issued_date=date('Y-m-d');
	//$issued_by='';
	$due_date='';
	$return_date='';
	$return_to='';
	$user_id='';

	if (isset($_SESSION['id'])) {
		$user_id=$_SESSION['id'];
		if ($user_id==NULL) {
			header('Location:login.php');
		}
	}
	

	if(isset($_POST['submit'])){

		$issued_by=$user_id;
		//echo $issued_by;
		//check empty fild......

		$req_field = array('book_id');


		$error=array_merge($error, check_empty($req_field));

		//check lenth ..........

		$max_length = array('book_id'=>50);

		$lenth_error=array_merge($lenth_error, check_length($max_length));


		//$member_id=mysqli_real_escape_string($admin_conn,$_POST['member_id']);
		$book_id=mysqli_real_escape_string($admin_conn,$_POST['book_id']);
		//$issued_date=mysqli_real_escape_string($admin_conn,$_POST['issued_date']);
		//$issued_by=mysqli_real_escape_string($admin_conn,$_POST['issued_by']);
		//$due_date=mysqli_real_escape_string($admin_conn,$_POST['due_date']);


		//$error=array_merge($error, check_member($admin_conn,$member_id));
		$error=array_merge($error, check_book($admin_conn,$book_id));

		$get_detail="SELECT member_id,book_id,due_date,issued_date from transactions where book_id='{$book_id}' and return_date IS NULL";


		$check_detail_result=mysqli_query($admin_conn,$get_detail);

		if ($check_detail_result) {
			if (mysqli_num_rows($check_detail_result)!=1) {
				$error[]='have not a recode';
			}
		}

		//echo "65";
		if(empty($error) && empty($lenth_error)){
			//echo "doing code";
			while($detail=mysqli_fetch_assoc($check_detail_result)){
				$member_id=$detail['member_id'];
				$due_date=$detail['due_date'];
            	$issued_date=$detail['issued_date'];
              
            }
            $stoday=date('Y-m-d');
            //echo "75";
            //echo $stoday.$user_id.$issued_date.$member_id.$book_id;

			$query="UPDATE transactions SET return_date='{$stoday}', return_to='{$user_id}',count_of_transactions=count_of_transactions+1 WHERE book_id='{$book_id}' LIMIT 1";
			$count_query="UPDATE members SET count_of_transactions=count_of_transactions+1 WHERE id='{$member_id}' LIMIT 1";
			$survey="UPDATE survey_book SET state='here',description='transaction returned on: {$stoday}' WHERE id='{$book_id}' limit 1";

			$query_result=mysqli_query($admin_conn,$query);
			$count_query_result=mysqli_query($admin_conn,$count_query);
			$survey_result=mysqli_query($admin_conn,$survey);

			if($query_result){
				$today=date_create($stoday);
				$sdue_date=date_create($due_date);
				$ok[]="added recodes..<br>";
				$diff=date_diff($sdue_date,$today);
				if ($sdue_date<$today) {
					$msg[]="<div class=\"redtext\">";
					$msg[]="<b>".$member_id."</b> was ";
					$msg[]=$diff->format("%R%a days");
					$msg[]=" late returned <br> you have to pay <b>Rs. ";
					$msg[]=$diff->format("%a")*(1/2);
					$msg[]="</b></div>";
				}else{
					$msg[]="<div class=\"greentext\">";
					$msg[]="<b>".$member_id."</b> thanks for returned the book in time ";
					$msg[]=$diff->format("%R%a days");
					$msg[]="</div>";
				}
				
				

				$member_id='';
				$book_id='';
				$return_date='';
				$return_by='';
				$due_date='';


				//header('Location :register_members.php?recode was added');
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
	<title>book return</title>
	<link rel="stylesheet" type="text/css" href="../css/form.css">
</head>
<body>
	<div>
		<?php require_once('header.php'); ?>
		<?php require_once('banner.php'); ?>
	</div>

	<div class="register" style="background-color: white">
		<form action="book_return.php" method="post">
			<fieldset>
				<legend><h1>book return form</h1></legend>
				
					<!--print error masseges...-->
					<?php 
						print_error($error,$lenth_error);
						print_ok($ok);
						if(!empty($msg)){
							foreach ($msg as $display) {
								echo $display."<br>";
							}
						
						}
					?>
				
				
				<!--<p><label>member_id</label><input class="txt" type="text" name="member_id" <?php //echo 'value="'.$member_id.'"';?>></p>-->
				<p><label>book_id</label><input class="txt" type="text" name="book_id" <?php echo 'value="'.$book_id.'"';?>></p>
				<!--<p><label>issued_date</label><input type="text" name="issued_date" value="<?php //echo date('Y-m-d');?>" disabled></p>-->
				<!--<p><label>issued_by</label><input type="text" name="issued_by" disabled></p>-->
				<!--<p><label>due_date</label><input type="text" name="due_date" value="<?php //echo date("Y-m-d",strtotime("+14 day")) ?>"<?php //echo 'value="'.$due_date.'"';?>></p>-->
				<p><label>return_date</label><input class="txt" type="text" name="due_date" value="<?php echo date("Y-m-d"); ?>"<?php echo 'value="'.$return_date.'"';?>></p>
				<p><label>return_to</label><input class="txt" type="text" name="return_to" value="<?php echo $user_id; ?>"disabled></p>

				<p><label>&nbsp;</label><button class="add" type="submit" name="submit">get</button></p>

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